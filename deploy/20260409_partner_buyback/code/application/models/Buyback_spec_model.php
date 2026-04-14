<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Buyback_spec_model extends CI_Model
{
    protected $table = 'buyback_spec_master';

    public function table_exists()
    {
        return $this->db->table_exists($this->table);
    }

    public function get_list($filters = array())
    {
        if (!$this->table_exists()) {
            return array();
        }

        $this->db->from($this->table);
        $this->apply_filters($filters);
        $this->db->order_by('device_type', 'ASC');
        $this->db->order_by('part_type', 'ASC');
        $this->db->order_by('manufacturer', 'ASC');
        $this->db->order_by('category_name', 'ASC');
        $this->db->order_by('sort_order', 'ASC');
        $this->db->order_by('model_name', 'ASC');

        return $this->db->get()->result_array();
    }

    public function get($id)
    {
        if (!$this->table_exists()) {
            return array();
        }

        $row = $this->db->get_where($this->table, array('id' => (int) $id))->row_array();
        return $row ? $row : array();
    }

    public function save($data, $id = 0)
    {
        if (!$this->table_exists()) {
            return false;
        }

        $row = $this->normalize_row($data);

        if ((int) $id > 0) {
            $this->db->where('id', (int) $id);
            $this->db->update($this->table, $row);
            return (int) $id;
        }

        $this->db->insert($this->table, $row);
        return (int) $this->db->insert_id();
    }

    public function toggle_active($id)
    {
        $row = $this->get($id);
        if (empty($row)) {
            return false;
        }

        $next = ((int) $row['is_active'] === 1) ? 0 : 1;

        $this->db->where('id', (int) $id);
        return (bool) $this->db->update($this->table, array('is_active' => $next));
    }

    public function update_inline_field($id, $field, $value, &$errors = array())
    {
        $errors = array();

        if (!$this->table_exists()) {
            $errors['common'] = '매입 기준 테이블이 없습니다.';
            return false;
        }

        $id = (int) $id;
        if ($id < 1) {
            $errors['common'] = '잘못된 요청입니다.';
            return false;
        }

        $allowed_fields = array('model_name', 'price_value', 'sort_order');
        if (!in_array($field, $allowed_fields, true)) {
            $errors['common'] = '잘못된 요청입니다.';
            return false;
        }

        if ($field === 'model_name') {
            $current = $this->db
                ->select('id, device_type, part_type, manufacturer, category_name')
                ->get_where($this->table, array('id' => $id), 1)
                ->row_array();

            if (empty($current)) {
                $errors['common'] = '대상 데이터를 찾을 수 없습니다.';
                return false;
            }

            $model_name = trim((string) $value);
            if ($model_name === '') {
                $errors['model_name'] = '모델명은 필수입니다.';
                return false;
            }

            $candidate = $current;
            $candidate['model_name'] = $model_name;

            if ($this->has_duplicate_key($candidate, $id)) {
                $errors['model_name'] = '이미 같은 기준 데이터가 있습니다.';
                return false;
            }

            if (!$this->update_single_field($id, array('model_name' => $model_name))) {
                $errors['common'] = '저장에 실패했습니다.';
                return false;
            }

            return array(
                'field' => 'model_name',
                'value' => $model_name,
                'display_value' => $model_name,
            );
        }

        if ($field === 'price_value') {
            $price_value = $this->normalize_inline_price($value, $errors);
            if (!empty($errors)) {
                return false;
            }

            if (!$this->update_single_field($id, array('price_value' => $price_value))) {
                $errors['common'] = '저장에 실패했습니다.';
                return false;
            }

            return array(
                'field' => 'price_value',
                'value' => ($price_value === null) ? '' : (string) $price_value,
                'display_value' => ($price_value === null) ? '' : number_format($price_value),
            );
        }

        $sort_order = $this->normalize_inline_sort_order($value, $errors);
        if (!empty($errors)) {
            return false;
        }

        if (!$this->update_single_field($id, array('sort_order' => $sort_order))) {
            $errors['common'] = '저장에 실패했습니다.';
            return false;
        }

        return array(
            'field' => 'sort_order',
            'value' => (string) $sort_order,
            'display_value' => (string) $sort_order,
        );
    }

    public function get_filter_options($field)
    {
        if (!$this->table_exists()) {
            return array();
        }

        $allowed = array('device_type', 'part_type', 'manufacturer');
        if (!in_array($field, $allowed, true)) {
            return array();
        }

        $this->db->distinct();
        $this->db->select($field);
        $this->db->from($this->table);
        $this->db->where($field . ' !=', '');
        $this->db->order_by($field, 'ASC');
        $rows = $this->db->get()->result_array();

        return array_values(array_filter(array_map(function ($row) use ($field) {
            return isset($row[$field]) ? $row[$field] : '';
        }, $rows)));
    }

    public function import_rows($rows, $mode = 'skip')
    {
        $result = array(
            'total' => 0,
            'inserted' => 0,
            'updated' => 0,
            'skipped' => 0,
            'errors' => 0,
            'error_rows' => array(),
        );

        if (!$this->table_exists()) {
            $result['errors'] = count($rows);
            return $result;
        }

        foreach ($rows as $index => $row) {
            $result['total']++;

            try {
                $normalized = $this->normalize_row($row);
                if ($normalized['device_type'] === '' || $normalized['model_name'] === '') {
                    throw new RuntimeException('기기종류와 모델명은 필수입니다.');
                }

                $existing = $this->find_existing($normalized);
                if ($existing) {
                    if ($mode === 'update_price') {
                        $update = array(
                            'price_value' => $normalized['price_value'],
                            'sort_order' => $normalized['sort_order'],
                            'is_active' => $normalized['is_active'],
                        );
                        $this->db->where('id', (int) $existing['id']);
                        $this->db->update($this->table, $update);
                        $result['updated']++;
                    } else {
                        $result['skipped']++;
                    }
                    continue;
                }

                $this->db->insert($this->table, $normalized);
                $result['inserted']++;
            } catch (Throwable $e) {
                $result['errors']++;
                $result['error_rows'][] = array(
                    'row_number' => $index + 1,
                    'message' => $e->getMessage(),
                );
            }
        }

        return $result;
    }

    public function get_front_datasets()
    {
        $result = array(
            'priceDB' => array(),
            'secondPriceTable' => array(),
        );

        if (!$this->table_exists()) {
            return $result;
        }

        $this->db->from($this->table);
        $this->db->where('is_active', 1);
        $this->db->order_by('device_type', 'ASC');
        $this->db->order_by('manufacturer', 'ASC');
        $this->db->order_by('category_name', 'ASC');
        $this->db->order_by('sort_order', 'ASC');
        $this->db->order_by('model_name', 'ASC');
        $rows = $this->db->get()->result_array();

        foreach ($rows as $row) {
            $device_type = $row['device_type'];
            $part_type = $row['part_type'];
            $manufacturer = $row['manufacturer'];
            $category_name = $row['category_name'];
            $model_name = $row['model_name'];
            $price_value = ($row['price_value'] === null || $row['price_value'] === '') ? null : (int) $row['price_value'];

            if (in_array($device_type, array('노트북', '데스크탑'), true) && $manufacturer !== '') {
                if (!isset($result['secondPriceTable'][$device_type])) {
                    $result['secondPriceTable'][$device_type] = array();
                }
                if (!isset($result['secondPriceTable'][$device_type][$manufacturer])) {
                    $result['secondPriceTable'][$device_type][$manufacturer] = array();
                }

                $result['secondPriceTable'][$device_type][$manufacturer][$model_name] = $price_value;
                continue;
            }

            $type = $part_type !== '' ? $part_type : $device_type;
            $category = $category_name !== '' ? $category_name : $manufacturer;

            $result['priceDB'][] = array(
                'type' => $type,
                'category' => $category,
                'name' => $model_name,
                'price' => $price_value,
            );
        }

        return $result;
    }

    protected function apply_filters($filters)
    {
        if (!empty($filters['device_type'])) {
            $this->db->where('device_type', trim($filters['device_type']));
        }

        if (!empty($filters['part_type'])) {
            $this->db->where('part_type', trim($filters['part_type']));
        }

        if (!empty($filters['manufacturer'])) {
            $this->db->where('manufacturer', trim($filters['manufacturer']));
        }

        $is_active = isset($filters['is_active']) ? $filters['is_active'] : '';
        if ($is_active !== '' && $is_active !== null) {
            $this->db->where('is_active', (int) $is_active);
        }

        if (!empty($filters['keyword'])) {
            $keyword = trim($filters['keyword']);
            $this->db->group_start();
            $this->db->like('model_name', $keyword);
            $this->db->or_like('category_name', $keyword);
            $this->db->or_like('manufacturer', $keyword);
            $this->db->group_end();
        }
    }

    protected function normalize_row($data)
    {
        $price_value = isset($data['price_value']) ? trim((string) $data['price_value']) : '';

        return array(
            'device_type' => isset($data['device_type']) ? trim((string) $data['device_type']) : '',
            'part_type' => isset($data['part_type']) ? trim((string) $data['part_type']) : '',
            'manufacturer' => isset($data['manufacturer']) ? trim((string) $data['manufacturer']) : '',
            'category_name' => isset($data['category_name']) ? trim((string) $data['category_name']) : '',
            'model_name' => isset($data['model_name']) ? trim((string) $data['model_name']) : '',
            'price_value' => ($price_value === '') ? null : (int) preg_replace('/[^0-9\-]/', '', $price_value),
            'sort_order' => isset($data['sort_order']) && $data['sort_order'] !== '' ? (int) $data['sort_order'] : 100,
            'is_active' => isset($data['is_active']) ? (int) $data['is_active'] : 1,
        );
    }

    protected function find_existing($row)
    {
        $this->db->from($this->table);
        $this->db->where('device_type', $row['device_type']);
        $this->db->where('part_type', $row['part_type']);
        $this->db->where('manufacturer', $row['manufacturer']);
        $this->db->where('category_name', $row['category_name']);
        $this->db->where('model_name', $row['model_name']);

        $found = $this->db->get()->row_array();
        return $found ? $found : array();
    }

    protected function has_duplicate_key($row, $exclude_id = 0)
    {
        $this->db->from($this->table);
        $this->db->where('device_type', isset($row['device_type']) ? $row['device_type'] : '');
        $this->db->where('part_type', isset($row['part_type']) ? $row['part_type'] : '');
        $this->db->where('manufacturer', isset($row['manufacturer']) ? $row['manufacturer'] : '');
        $this->db->where('category_name', isset($row['category_name']) ? $row['category_name'] : '');
        $this->db->where('model_name', isset($row['model_name']) ? $row['model_name'] : '');

        $exclude_id = (int) $exclude_id;
        if ($exclude_id > 0) {
            $this->db->where('id !=', $exclude_id);
        }

        return (bool) $this->db->count_all_results();
    }

    protected function update_single_field($id, $data)
    {
        $this->db->where('id', (int) $id);
        $this->db->update($this->table, $data);

        if ($this->db->affected_rows() > 0) {
            return true;
        }

        return (bool) $this->db
            ->select('id')
            ->get_where($this->table, array('id' => (int) $id), 1)
            ->row_array();
    }

    protected function normalize_inline_price($value, &$errors)
    {
        $raw = trim((string) $value);
        if ($raw === '') {
            return null;
        }

        $normalized = preg_replace('/[^0-9\-]/', '', $raw);
        if ($normalized === '' || !preg_match('/^-?\d+$/', $normalized)) {
            $errors['price_value'] = '매입가는 숫자만 입력해주세요.';
            return null;
        }

        $price = (int) $normalized;
        if ($price < 0) {
            $errors['price_value'] = '매입가는 0 이상으로 입력해주세요.';
            return null;
        }

        return $price;
    }

    protected function normalize_inline_sort_order($value, &$errors)
    {
        $raw = trim((string) $value);
        if ($raw === '') {
            return 100;
        }

        if (!preg_match('/^-?\d+$/', $raw)) {
            $errors['sort_order'] = '정렬값은 숫자만 입력해주세요.';
            return 100;
        }

        return (int) $raw;
    }
}