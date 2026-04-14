<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Buyback_model extends CI_Model
{
    protected $table_request = 'buyback_request';
    protected $table_device  = 'buyback_request_device';
    protected $table_fields  = array();
    protected $partner_table_candidates = array('partner', 'partners', 'partner_list');
    protected $partner_table = null;
    protected $partner_fields = null;

    public function insert_request_with_devices($request_data, $devices)
    {
        $this->db->trans_begin();

        $request_row = $this->filter_insert_data($this->table_request, $request_data);
        $this->db->insert($this->table_request, $request_row);
        $request_id = (int) $this->db->insert_id();

        if ($request_id < 1) {
            $this->db->trans_rollback();
            return false;
        }

        foreach ($devices as $device) {
            $row = array(
                'request_id'       => $request_id,
                'device_type'      => isset($device['device_type']) ? $device['device_type'] : '',
                'manufacturer'     => isset($device['manufacturer']) ? $device['manufacturer'] : '',
                'model_name'       => isset($device['model_name']) ? $device['model_name'] : '',
                'part_type'        => isset($device['part_type']) ? $device['part_type'] : '',
                'category_name'    => isset($device['category_name']) ? $device['category_name'] : '',
                'condition_grade'  => isset($device['condition_grade']) ? $device['condition_grade'] : '',
                'qty'              => isset($device['qty']) ? (int) $device['qty'] : 1,
                'unit_price_value' => isset($device['unit_price_value']) ? (int) $device['unit_price_value'] : 0,
                'unit_price_text'  => isset($device['unit_price_text']) ? $device['unit_price_text'] : '',
                'spec_json'        => isset($device['spec_json']) ? $device['spec_json'] : null,
                'sort_order'       => isset($device['sort_order']) ? (int) $device['sort_order'] : 1,
            );

            $device_row = $this->filter_insert_data($this->table_device, $row);
            $this->db->insert($this->table_device, $device_row);
        }

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return false;
        }

        $this->db->trans_commit();
        return $request_id;
    }

    public function get_request_list($partner_id = null, $filters = array())
    {
        if (is_array($partner_id)) {
            $filters = $partner_id;
            $partner_id = isset($filters['partner_id']) && $filters['partner_id'] !== ''
                ? (int) $filters['partner_id']
                : null;
        }

        $filters = is_array($filters) ? $filters : array();

        $this->db->select('r.*');
        $this->db->from($this->table_request . ' r');

        if ($partner_id !== null) {
            if (!$this->supports_partner_scope()) {
                return array();
            }

            $this->db->where('r.partner_id', (int) $partner_id);
        }

        if (!empty($filters['status'])) {
            $this->db->where('r.status', $filters['status']);
        }

        if (!empty($filters['api_send_status']) && $this->supports_api_send_status()) {
            $this->db->where('r.api_send_status', $filters['api_send_status']);
        }

        $this->db->order_by('r.id', 'DESC');
        $requests = $this->db->get()->result_array();

        if (empty($requests)) {
            return array();
        }

        $request_ids = array_column($requests, 'id');
        $devices_map = $this->get_devices_grouped($request_ids);

        foreach ($requests as &$request) {
            $request['devices'] = isset($devices_map[$request['id']]) ? $devices_map[$request['id']] : array();
        }
        unset($request);

        return $requests;
    }

    public function get_request($id, $partner_id = null)
    {
        $this->db->from($this->table_request);
        $this->db->where('id', (int) $id);

        if ($partner_id !== null) {
            if (!$this->supports_partner_scope()) {
                return array();
            }

            $this->db->where('partner_id', (int) $partner_id);
        }

        $row = $this->db->get()->row_array();
        return $row ? $row : array();
    }

    public function get_request_detail($id, $partner_id = null)
    {
        $request = $this->get_request($id, $partner_id);
        if (empty($request)) {
            return array();
        }

        $request['devices'] = $this->get_devices_by_request($id);
        return $request;
    }

    public function get_member_request_list($member_user_id)
    {
        $member_user_id = (int) $member_user_id;
        if ($member_user_id < 1 || !$this->supports_member_scope()) {
            return array();
        }

        $partner_table = $this->get_partner_table();
        $partner_id_field = $this->get_partner_id_field();
        $partner_name_field = $this->get_partner_name_field();
        $partner_slug_field = $this->get_partner_slug_field();

        $select = array('r.*');
        if ($partner_table && $partner_id_field && $partner_name_field && $this->supports_partner_scope()) {
            $select[] = 'p.' . $partner_name_field . ' AS partner_name';
            if ($partner_slug_field) {
                $select[] = 'p.' . $partner_slug_field . ' AS partner_slug';
            }
        }

        $this->db->select(implode(', ', $select), false);
        $this->db->from($this->table_request . ' r');

        if ($partner_table && $partner_id_field && $partner_name_field && $this->supports_partner_scope()) {
            $this->db->join(
                $partner_table . ' p',
                'p.' . $partner_id_field . ' = r.partner_id',
                'left'
            );
        }

        $this->db->where('r.member_user_id', $member_user_id);
        $this->db->order_by('r.id', 'DESC');

        $requests = $this->db->get()->result_array();
        if (empty($requests)) {
            return array();
        }

        $request_ids = array_column($requests, 'id');
        $devices_map = $this->get_devices_grouped($request_ids);

        foreach ($requests as &$request) {
            $request['partner_name'] = isset($request['partner_name']) ? $request['partner_name'] : '';
            $request['partner_slug'] = isset($request['partner_slug']) ? $request['partner_slug'] : '';
            $request['devices'] = isset($devices_map[$request['id']]) ? $devices_map[$request['id']] : array();
        }
        unset($request);

        return $requests;
    }

    public function get_member_request_detail($id, $member_user_id)
    {
        $id = (int) $id;
        $member_user_id = (int) $member_user_id;

        if ($id < 1 || $member_user_id < 1 || !$this->supports_member_scope()) {
            return array();
        }

        $partner_table = $this->get_partner_table();
        $partner_id_field = $this->get_partner_id_field();
        $partner_name_field = $this->get_partner_name_field();
        $partner_slug_field = $this->get_partner_slug_field();

        $select = array('r.*');
        if ($partner_table && $partner_id_field && $partner_name_field && $this->supports_partner_scope()) {
            $select[] = 'p.' . $partner_name_field . ' AS partner_name';
            if ($partner_slug_field) {
                $select[] = 'p.' . $partner_slug_field . ' AS partner_slug';
            }
        }

        $this->db->select(implode(', ', $select), false);
        $this->db->from($this->table_request . ' r');

        if ($partner_table && $partner_id_field && $partner_name_field && $this->supports_partner_scope()) {
            $this->db->join(
                $partner_table . ' p',
                'p.' . $partner_id_field . ' = r.partner_id',
                'left'
            );
        }

        $this->db->where('r.id', $id);
        $this->db->where('r.member_user_id', $member_user_id);

        $request = $this->db->get()->row_array();
        if (empty($request)) {
            return array();
        }

        $request['partner_name'] = isset($request['partner_name']) ? $request['partner_name'] : '';
        $request['partner_slug'] = isset($request['partner_slug']) ? $request['partner_slug'] : '';
        $request['devices'] = $this->get_devices_by_request($id);

        return $request;
    }

    public function get_devices_grouped($request_ids)
    {
        if (empty($request_ids)) {
            return array();
        }

        $this->db->select('*');
        $this->db->from($this->table_device);
        $this->db->where_in('request_id', $request_ids);
        $this->db->order_by('request_id', 'ASC');
        $this->db->order_by('sort_order', 'ASC');

        $rows = $this->db->get()->result_array();
        $grouped = array();

        foreach ($rows as $row) {
            if (!isset($grouped[$row['request_id']])) {
                $grouped[$row['request_id']] = array();
            }

            $grouped[$row['request_id']][] = $this->normalize_device_row($row);
        }

        return $grouped;
    }

    public function get_devices_by_request($request_id)
    {
        $this->db->select('*');
        $this->db->from($this->table_device);
        $this->db->where('request_id', (int) $request_id);
        $this->db->order_by('sort_order', 'ASC');

        $rows = $this->db->get()->result_array();
        $devices = array();

        foreach ($rows as $row) {
            $devices[] = $this->normalize_device_row($row);
        }

        return $devices;
    }

    public function delete_request($id, $partner_id = null)
    {
        $request = $this->get_request($id, $partner_id);
        if (empty($request)) {
            return false;
        }

        $this->db->trans_begin();

        $this->db->where('request_id', (int) $id);
        $this->db->delete($this->table_device);

        $this->db->where('id', (int) $id);
        if ($partner_id !== null && $this->supports_partner_scope()) {
            $this->db->where('partner_id', (int) $partner_id);
        }
        $this->db->delete($this->table_request);

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return false;
        }

        $this->db->trans_commit();
        return true;
    }

    public function update_request($id, $data, $partner_id = null)
    {
        $request = $this->get_request($id, $partner_id);
        if (empty($request)) {
            return false;
        }

        $row = $this->filter_insert_data($this->table_request, $data);
        if (empty($row)) {
            return false;
        }

        $this->db->where('id', (int) $id);
        if ($partner_id !== null && $this->supports_partner_scope()) {
            $this->db->where('partner_id', (int) $partner_id);
        }

        return (bool) $this->db->update($this->table_request, $row);
    }

    protected function normalize_device_row($row)
    {
        $specs = array();
        if (!empty($row['spec_json'])) {
            $decoded = json_decode($row['spec_json'], true);
            if (is_array($decoded)) {
                $specs = $decoded;
            }
        }

        return array(
            'id'               => isset($row['id']) ? (int) $row['id'] : 0,
            'device'           => isset($row['device_type']) ? $row['device_type'] : '',
            'device_type'      => isset($row['device_type']) ? $row['device_type'] : '',
            'manufacturer'     => isset($row['manufacturer']) ? $row['manufacturer'] : '',
            'model'            => isset($row['model_name']) ? $row['model_name'] : '',
            'model_name'       => isset($row['model_name']) ? $row['model_name'] : '',
            'part_type'        => isset($row['part_type']) ? $row['part_type'] : '',
            'category_name'    => isset($row['category_name']) ? $row['category_name'] : '',
            'specs'            => $specs,
            'condition'        => isset($row['condition_grade']) ? $row['condition_grade'] : '',
            'condition_grade'  => isset($row['condition_grade']) ? $row['condition_grade'] : '',
            'price_value'      => isset($row['unit_price_value']) ? (int) $row['unit_price_value'] : 0,
            'unit_price_value' => isset($row['unit_price_value']) ? (int) $row['unit_price_value'] : 0,
            'price_text'       => isset($row['unit_price_text']) ? $row['unit_price_text'] : '',
            'unit_price_text'  => isset($row['unit_price_text']) ? $row['unit_price_text'] : '',
            'qty'              => isset($row['qty']) ? (int) $row['qty'] : 1,
        );
    }

    protected function supports_partner_scope()
    {
        return $this->db->field_exists('partner_id', $this->table_request);
    }

    protected function supports_api_send_status()
    {
        return $this->db->field_exists('api_send_status', $this->table_request);
    }

    protected function supports_member_scope()
    {
        return $this->db->field_exists('member_user_id', $this->table_request);
    }

    protected function filter_insert_data($table, $data)
    {
        $fields = $this->get_table_fields($table);
        if (empty($fields)) {
            return $data;
        }

        return array_intersect_key($data, array_flip($fields));
    }

    protected function get_table_fields($table)
    {
        if (!array_key_exists($table, $this->table_fields)) {
            $this->table_fields[$table] = $this->db->table_exists($table)
                ? $this->db->list_fields($table)
                : array();
        }

        return $this->table_fields[$table];
    }

    protected function get_partner_table()
    {
        if ($this->partner_table !== null) {
            return $this->partner_table;
        }

        foreach ($this->partner_table_candidates as $table) {
            if ($this->db->table_exists($table)) {
                $this->partner_table = $table;
                return $this->partner_table;
            }
        }

        $this->partner_table = false;
        return $this->partner_table;
    }

    protected function get_partner_fields()
    {
        if ($this->partner_fields !== null) {
            return $this->partner_fields;
        }

        $table = $this->get_partner_table();
        $this->partner_fields = $table ? $this->db->list_fields($table) : array();

        return $this->partner_fields;
    }

    protected function get_partner_id_field()
    {
        return $this->pick_field($this->get_partner_fields(), array('id', 'idx'));
    }

    protected function get_partner_name_field()
    {
        return $this->pick_field($this->get_partner_fields(), array('name', 'partner_name', 'title'));
    }

    protected function get_partner_slug_field()
    {
        return $this->pick_field($this->get_partner_fields(), array('slug', 'code'));
    }

    protected function pick_field($fields, $candidates)
    {
        foreach ((array) $candidates as $candidate) {
            if (in_array($candidate, (array) $fields, true)) {
                return $candidate;
            }
        }

        return null;
    }
}
