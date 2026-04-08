<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Buyback_model extends CI_Model
{
    protected $table_request = 'buyback_request';
    protected $table_device  = 'buyback_request_device';

    public function insert_request_with_devices($request_data, $devices)
    {
        $this->db->trans_begin();

        $this->db->insert($this->table_request, $request_data);
        $request_id = $this->db->insert_id();

        if (!$request_id) {
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
                'qty'              => isset($device['qty']) ? (int)$device['qty'] : 1,
                'unit_price_value' => isset($device['unit_price_value']) ? (int)$device['unit_price_value'] : 0,
                'unit_price_text'  => isset($device['unit_price_text']) ? $device['unit_price_text'] : '',
                'spec_json'        => isset($device['spec_json']) ? $device['spec_json'] : null,
                'sort_order'       => isset($device['sort_order']) ? (int)$device['sort_order'] : 1
            );

            $this->db->insert($this->table_device, $row);
        }

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return false;
        }

        $this->db->trans_commit();
        return $request_id;
    }

    public function get_request_list()
    {
        $this->db->select('r.*');
        $this->db->from($this->table_request . ' r');
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

            $specs = array();
            if (!empty($row['spec_json'])) {
                $decoded = json_decode($row['spec_json'], true);
                if (is_array($decoded)) {
                    $specs = $decoded;
                }
            }

            $grouped[$row['request_id']][] = array(
                'id'          => (int)$row['id'],
                'device'      => $row['device_type'],
                'manufacturer'=> $row['manufacturer'],
                'model'       => $row['model_name'],
                'specs'       => $specs,
                'condition'   => $row['condition_grade'],
                'price_value' => (int)$row['unit_price_value'],
                'price_text'  => $row['unit_price_text'],
                'qty'         => (int)$row['qty']
            );
        }

        return $grouped;
    }

    public function delete_request($id)
    {
        $this->db->where('id', (int)$id);
        return $this->db->delete($this->table_request);
    }
}