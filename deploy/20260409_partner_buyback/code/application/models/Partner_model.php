<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Partner_model extends CI_Model
{
    protected $partner_table_candidates = array('partner', 'partners', 'partner_list');
    protected $admin_map_table_candidates = array('partner_admin_map', 'partner_admins');

    protected $partner_table = null;
    protected $partner_fields = null;
    protected $admin_map_table = null;
    protected $admin_map_fields = null;

    public function get_by_slug($slug)
    {
        $slug = trim(strtolower((string) $slug));
        if ($slug === '') {
            return null;
        }

        $table = $this->get_partner_table();
        $slug_field = $this->get_partner_slug_field();

        if (!$table || !$slug_field) {
            return null;
        }

        $row = $this->db
            ->from($table)
            ->where($slug_field, $slug)
            ->limit(1)
            ->get()
            ->row_array();

        if (!$row) {
            return null;
        }

        $partner = $this->normalize_partner_row($row);
        return $partner['is_active'] ? $partner : null;
    }

    public function has_admin_access($partner_id, $admin_user_id)
    {
        $partner_id = (int) $partner_id;
        $admin_user_id = (int) $admin_user_id;

        if ($partner_id < 1 || $admin_user_id < 1) {
            return false;
        }

        $map_table = $this->get_admin_map_table();
        $partner_field = $this->pick_field($this->get_admin_map_fields(), array('partner_id', 'partner_idx', 'pidx'));
        $admin_field = $this->pick_field($this->get_admin_map_fields(), array('admin_user_id', 'user_id', 'admin_id'));
        $active_field = $this->pick_field($this->get_admin_map_fields(), array('is_active', 'active', 'use_yn', 'status'));

        if ($map_table && $partner_field && $admin_field) {
            $rows = $this->db
                ->from($map_table)
                ->where($partner_field, $partner_id)
                ->where($admin_field, $admin_user_id)
                ->get()
                ->result_array();

            foreach ($rows as $row) {
                if (!$active_field || $this->is_active_value($row[$active_field])) {
                    return true;
                }
            }
        }

        $partner = $this->get_by_id($partner_id);
        if (!$partner) {
            return false;
        }

        foreach (array('admin_user_id', 'manager_user_id', 'owner_user_id') as $field) {
            if (isset($partner['_raw'][$field]) && (int) $partner['_raw'][$field] === $admin_user_id) {
                return true;
            }
        }

        return false;
    }

    public function get_list()
    {
        $table = $this->get_partner_table();
        if (!$table) {
            return array();
        }

        $partners = $this->db
            ->select('p.*')
            ->from($table . ' AS p')
            ->order_by('p.id', 'DESC')
            ->get()
            ->result_array();

        foreach ($partners as &$partner) {
            $partner = $this->normalize_partner_row($partner);
            $primary_admin = $this->get_primary_admin($partner['id']);
            $partner['admin_user_id'] = !empty($primary_admin['id']) ? (int) $primary_admin['id'] : 0;
            $partner['admin_username'] = !empty($primary_admin['username']) ? (string) $primary_admin['username'] : '';
            $partner['admin_nickname'] = !empty($primary_admin['nickname']) ? (string) $primary_admin['nickname'] : '';
            $partner['admin_type'] = !empty($primary_admin['type']) ? (string) $primary_admin['type'] : '';
        }

        return $partners;
    }

    public function get_active_list($exclude_slugs = array())
    {
        $table = $this->get_partner_table();
        if (!$table) {
            return array();
        }

        $slug_field = $this->get_partner_slug_field();
        $name_field = $this->pick_field($this->get_partner_fields(), array('name', 'partner_name', 'title'));

        $this->db
            ->select('p.*')
            ->from($table . ' AS p');

        $normalized_excludes = array();
        foreach ((array) $exclude_slugs as $slug) {
            $slug = strtolower(trim((string) $slug));
            if ($slug !== '') {
                $normalized_excludes[] = $slug;
            }
        }

        if ($slug_field && !empty($normalized_excludes)) {
            $this->db->where_not_in('p.' . $slug_field, array_values(array_unique($normalized_excludes)));
        }

        if ($name_field) {
            $this->db->order_by('p.' . $name_field, 'ASC');
        } else {
            $this->db->order_by('p.id', 'DESC');
        }

        $rows = $this->db->get()->result_array();

        $partners = array();
        foreach ($rows as $row) {
            $partner = $this->normalize_partner_row($row);
            if ($partner['is_active']) {
                $partners[] = $partner;
            }
        }

        return $partners;
    }

    public function get_admin_detail($partner_id)
    {
        $partner_id = (int) $partner_id;
        if ($partner_id < 1) {
            return null;
        }

        $table = $this->get_partner_table();
        if (!$table) {
            return null;
        }

        $row = $this->db
            ->select('p.*')
            ->from($table . ' AS p')
            ->where('p.id', $partner_id)
            ->limit(1)
            ->get()
            ->row_array();

        if (!$row) {
            return null;
        }

        $partner = $this->normalize_partner_row($row);
        $primary_admin = $this->get_primary_admin($partner_id);
        $partner['admin_user_id'] = !empty($primary_admin['id']) ? (int) $primary_admin['id'] : 0;
        $partner['admin_username'] = !empty($primary_admin['username']) ? (string) $primary_admin['username'] : '';
        $partner['admin_nickname'] = !empty($primary_admin['nickname']) ? (string) $primary_admin['nickname'] : '';
        $partner['admin_type'] = !empty($primary_admin['type']) ? (string) $primary_admin['type'] : '';

        return $partner;
    }

    public function get_admin_candidates()
    {
        if (!$this->db->table_exists('users_admin')) {
            return array();
        }

        return $this->db
            ->select('id, username, nickname, email, type')
            ->from('users_admin')
            ->where('deleted', null)
            ->where('banned', 0)
            ->order_by('nickname', 'ASC')
            ->order_by('username', 'ASC')
            ->get()
            ->result_array();
    }

    public function get_primary_admin($partner_id)
    {
        $admins = $this->get_partner_admins($partner_id, array('PARTNER'));
        return !empty($admins) ? $admins[0] : null;
    }

    public function get_partner_admins($partner_id, $types = array())
    {
        $partner_id = (int) $partner_id;
        if ($partner_id < 1 || !$this->db->table_exists('users_admin')) {
            return array();
        }

        $map_table = $this->get_admin_map_table();
        if (!$map_table) {
            return array();
        }

        $this->db
            ->select('ua.*, pam.partner_id, pam.is_active')
            ->from($map_table . ' AS pam')
            ->join('users_admin AS ua', 'ua.id = pam.admin_user_id', 'inner')
            ->where('pam.partner_id', $partner_id)
            ->where('pam.is_active', 1)
            ->where('ua.deleted', null);

        $normalized_types = array();
        foreach ((array) $types as $type) {
            $type = strtoupper(trim((string) $type));
            if ($type !== '') {
                $normalized_types[] = $type;
            }
        }

        if (!empty($normalized_types)) {
            $this->db->where_in('ua.type', array_values(array_unique($normalized_types)));
        }

        return $this->db
            ->order_by("CASE WHEN ua.type = 'PARTNER' THEN 0 WHEN ua.type = 'BOTH' THEN 1 ELSE 2 END", '', false)
            ->order_by('ua.nickname', 'ASC')
            ->order_by('ua.username', 'ASC')
            ->get()
            ->result_array();
    }

    public function get_both_admin_candidates($partner_id = 0)
    {
        if (!$this->db->table_exists('users_admin')) {
            return array();
        }

        $partner_id = (int) $partner_id;
        $linked_ids = array();
        if ($partner_id > 0) {
            foreach ($this->get_partner_admins($partner_id, array('BOTH')) as $admin) {
                $linked_ids[] = (int) $admin['id'];
            }
        }

        $this->db
            ->select('id, username, nickname, email, type')
            ->from('users_admin')
            ->where('deleted', null)
            ->where('banned', 0)
            ->where('type', 'BOTH');

        if (!empty($linked_ids)) {
            $this->db->where_not_in('id', $linked_ids);
        }

        return $this->db
            ->order_by('nickname', 'ASC')
            ->order_by('username', 'ASC')
            ->get()
            ->result_array();
    }

    public function save_partner_basic($partner_id, $partner_data)
    {
        $table = $this->get_partner_table();
        if (!$table) {
            return 0;
        }

        $partner_id = (int) $partner_id;
        $allowed_fields = array_flip($this->get_partner_fields());
        $data = array();

        foreach ((array) $partner_data as $field => $value) {
            if (!isset($allowed_fields[$field])) {
                continue;
            }

            if ($field === 'slug') {
                $value = strtolower(trim((string) $value));
            }

            $data[$field] = $value;
        }

        if ($partner_id > 0) {
            $this->db->where($this->get_partner_id_field(), $partner_id)->update($table, $data);
            return $partner_id;
        }

        $this->db->insert($table, $data);
        return (int) $this->db->insert_id();
    }

    public function link_admin($partner_id, $admin_user_id)
    {
        $partner_id = (int) $partner_id;
        $admin_user_id = (int) $admin_user_id;
        if ($partner_id < 1 || $admin_user_id < 1) {
            return false;
        }

        $map_table = $this->get_admin_map_table();
        if (!$map_table) {
            return false;
        }

        $existing = $this->db
            ->from($map_table)
            ->where('partner_id', $partner_id)
            ->where('admin_user_id', $admin_user_id)
            ->limit(1)
            ->get()
            ->row_array();

        if ($existing) {
            $this->db
                ->where('id', $existing['id'])
                ->update($map_table, array('is_active' => 1));

            return true;
        }

        $this->db->insert($map_table, array(
            'partner_id' => $partner_id,
            'admin_user_id' => $admin_user_id,
            'is_active' => 1,
        ));

        return $this->db->affected_rows() > 0;
    }

    public function unlink_admin($partner_id, $admin_user_id)
    {
        $partner_id = (int) $partner_id;
        $admin_user_id = (int) $admin_user_id;
        if ($partner_id < 1 || $admin_user_id < 1) {
            return false;
        }

        $map_table = $this->get_admin_map_table();
        if (!$map_table) {
            return false;
        }

        return $this->db
            ->where('partner_id', $partner_id)
            ->where('admin_user_id', $admin_user_id)
            ->update($map_table, array('is_active' => 0));
    }

    public function get_partner_admin($partner_id, $admin_user_id)
    {
        $partner_id = (int) $partner_id;
        $admin_user_id = (int) $admin_user_id;
        if ($partner_id < 1 || $admin_user_id < 1 || !$this->db->table_exists('users_admin')) {
            return null;
        }

        $map_table = $this->get_admin_map_table();
        if (!$map_table) {
            return null;
        }

        return $this->db
            ->select('ua.*, pam.partner_id, pam.is_active')
            ->from($map_table . ' AS pam')
            ->join('users_admin AS ua', 'ua.id = pam.admin_user_id', 'inner')
            ->where('pam.partner_id', $partner_id)
            ->where('pam.admin_user_id', $admin_user_id)
            ->where('pam.is_active', 1)
            ->where('ua.deleted', null)
            ->limit(1)
            ->get()
            ->row_array();
    }

    public function get_all_partner_managers()
    {
        if (!$this->db->table_exists('users_admin')) {
            return array();
        }

        $map_table = $this->get_admin_map_table();
        $partner_table = $this->get_partner_table();
        if (!$map_table || !$partner_table) {
            return array();
        }

        $rows = $this->db
            ->select('pam.partner_id, ua.id AS admin_user_id, ua.username, ua.nickname, ua.email, ua.type, ua.activated, p.id AS partner_pk, p.slug, p.name, p.is_active')
            ->from($map_table . ' AS pam')
            ->join('users_admin AS ua', 'ua.id = pam.admin_user_id', 'inner')
            ->join($partner_table . ' AS p', 'p.id = pam.partner_id', 'inner')
            ->where('pam.is_active', 1)
            ->where('ua.deleted', null)
            ->where('ua.type', 'PARTNER')
            ->order_by('p.name', 'ASC')
            ->order_by('ua.nickname', 'ASC')
            ->order_by('ua.username', 'ASC')
            ->get()
            ->result_array();

        $managers = array();
        foreach ($rows as $row) {
            $managers[] = array(
                'partner_id' => isset($row['partner_pk']) ? (int) $row['partner_pk'] : 0,
                'partner_name' => isset($row['name']) ? (string) $row['name'] : '',
                'partner_slug' => isset($row['slug']) ? (string) $row['slug'] : '',
                'admin_user_id' => isset($row['admin_user_id']) ? (int) $row['admin_user_id'] : 0,
                'username' => isset($row['username']) ? (string) $row['username'] : '',
                'nickname' => isset($row['nickname']) ? (string) $row['nickname'] : '',
                'email' => isset($row['email']) ? (string) $row['email'] : '',
                'type' => isset($row['type']) ? (string) $row['type'] : '',
                'activated' => isset($row['activated']) ? (int) $row['activated'] : 0,
            );
        }

        return $managers;
    }

    public function save_partner($partner_id, $partner_data, $admin_user_id = 0, $admin_type = 'BOTH')
    {
        $table = $this->get_partner_table();
        if (!$table) {
            return 0;
        }

        $partner_id = (int) $partner_id;
        $admin_user_id = (int) $admin_user_id;
        $admin_type = strtoupper(trim((string) $admin_type));
        if (!in_array($admin_type, array('SITE', 'PARTNER', 'BOTH'), true)) {
            $admin_type = 'BOTH';
        }

        $allowed_fields = array_flip($this->get_partner_fields());
        $data = array();
        foreach ((array) $partner_data as $field => $value) {
            if (!isset($allowed_fields[$field])) {
                continue;
            }

            if ($field === 'slug') {
                $value = strtolower(trim((string) $value));
            }

            $data[$field] = $value;
        }

        if ($partner_id > 0) {
            $this->db->where($this->get_partner_id_field(), $partner_id)->update($table, $data);
        } else {
            $this->db->insert($table, $data);
            $partner_id = (int) $this->db->insert_id();
        }

        if ($partner_id < 1) {
            return 0;
        }

        $map_table = $this->get_admin_map_table();
        if ($map_table && in_array('is_active', $this->get_admin_map_fields(), true)) {
            $this->db->where('partner_id', $partner_id)->update($map_table, array('is_active' => 0));
        }

        if ($map_table && $admin_user_id > 0) {
            $existing = $this->db
                ->from($map_table)
                ->where('partner_id', $partner_id)
                ->where('admin_user_id', $admin_user_id)
                ->limit(1)
                ->get()
                ->row_array();

            if ($existing) {
                $this->db
                    ->where('id', $existing['id'])
                    ->update($map_table, array('is_active' => 1));
            } else {
                $this->db->insert($map_table, array(
                    'partner_id' => $partner_id,
                    'admin_user_id' => $admin_user_id,
                    'is_active' => 1,
                ));
            }

            $this->sync_admin_type($admin_user_id, $admin_type);
        }

        return $partner_id;
    }

    public function delete_partner($partner_id)
    {
        $partner_id = (int) $partner_id;
        if ($partner_id < 1) {
            return false;
        }

        $table = $this->get_partner_table();
        if (!$table) {
            return false;
        }

        return $this->db->where($this->get_partner_id_field(), $partner_id)->delete($table);
    }

    protected function get_by_id($partner_id)
    {
        $partner_id = (int) $partner_id;
        if ($partner_id < 1) {
            return null;
        }

        $table = $this->get_partner_table();
        $id_field = $this->get_partner_id_field();

        if (!$table || !$id_field) {
            return null;
        }

        $row = $this->db
            ->from($table)
            ->where($id_field, $partner_id)
            ->limit(1)
            ->get()
            ->row_array();

        if (!$row) {
            return null;
        }

        return $this->normalize_partner_row($row);
    }

    protected function normalize_partner_row($row)
    {
        $id_field = $this->get_partner_id_field();
        $slug_field = $this->get_partner_slug_field();
        $name_field = $this->pick_field($this->get_partner_fields(), array('name', 'partner_name', 'title'));
        $active_field = $this->pick_field($this->get_partner_fields(), array('is_active', 'active', 'use_yn', 'status'));

        return array(
            'id'        => isset($row[$id_field]) ? (int) $row[$id_field] : 0,
            'slug'      => isset($row[$slug_field]) ? (string) $row[$slug_field] : '',
            'name'      => isset($row[$name_field]) ? (string) $row[$name_field] : '',
            'is_active' => $active_field ? $this->is_active_value($row[$active_field]) : true,
            'admin_user_id' => isset($row['admin_user_id']) ? (int) $row['admin_user_id'] : 0,
            'admin_username' => isset($row['admin_username']) ? (string) $row['admin_username'] : '',
            'admin_nickname' => isset($row['admin_nickname']) ? (string) $row['admin_nickname'] : '',
            'admin_type' => isset($row['admin_type']) ? (string) $row['admin_type'] : '',
            '_raw'      => $row,
        );
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
        return false;
    }

    protected function get_admin_map_table()
    {
        if ($this->admin_map_table !== null) {
            return $this->admin_map_table;
        }

        foreach ($this->admin_map_table_candidates as $table) {
            if ($this->db->table_exists($table)) {
                $this->admin_map_table = $table;
                return $this->admin_map_table;
            }
        }

        $this->admin_map_table = false;
        return false;
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

    protected function get_admin_map_fields()
    {
        if ($this->admin_map_fields !== null) {
            return $this->admin_map_fields;
        }

        $table = $this->get_admin_map_table();
        $this->admin_map_fields = $table ? $this->db->list_fields($table) : array();
        return $this->admin_map_fields;
    }

    protected function get_partner_id_field()
    {
        return $this->pick_field($this->get_partner_fields(), array('id', 'idx', 'partner_id'));
    }

    protected function get_partner_slug_field()
    {
        return $this->pick_field($this->get_partner_fields(), array('slug', 'partner_slug', 'code'));
    }

    protected function pick_field($fields, $candidates)
    {
        foreach ($candidates as $candidate) {
            if (in_array($candidate, $fields, true)) {
                return $candidate;
            }
        }

        return null;
    }

    protected function is_active_value($value)
    {
        if (is_bool($value)) {
            return $value;
        }

        $normalized = strtolower(trim((string) $value));
        return in_array($normalized, array('1', 'y', 'yes', 'true', 'active', 'use'), true);
    }

    protected function sync_admin_type($admin_user_id, $admin_type)
    {
        if (!$this->db->table_exists('users_admin')) {
            return;
        }

        $admin_user_id = (int) $admin_user_id;
        if ($admin_user_id < 1) {
            return;
        }

        $row = $this->db
            ->select('type')
            ->from('users_admin')
            ->where('id', $admin_user_id)
            ->limit(1)
            ->get()
            ->row_array();

        if (!$row) {
            return;
        }

        $current_type = strtoupper(trim((string) $row['type']));
        if ($current_type === $admin_type) {
            return;
        }

        $this->db->where('id', $admin_user_id)->update('users_admin', array('type' => $admin_type));
    }
}
