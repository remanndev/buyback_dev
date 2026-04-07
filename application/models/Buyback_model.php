<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Buyback_model
 *
 * buyback 관련 핵심 비즈니스 데이터 접근 모델.
 *
 * 중요:
 * - 관리자 조회/상세/API 전송 대상 조회에는 partner_id 조건을 강제한다.
 */
class Buyback_model extends CI_Model
{
    protected $request_table = 'buyback_requests';
    protected $device_table = 'buyback_request_devices';
    protected $api_log_table = 'buyback_api_logs';

    /**
     * 일반 회원 매입요청 생성.
     */
    public function create_request($data)
    {
        $this->db->insert($this->request_table, $data);
        return (int) $this->db->insert_id();
    }

    /**
     * 매입요청 디바이스 행 추가.
     */
    public function add_request_device($data)
    {
        $this->db->insert($this->device_table, $data);
        return (int) $this->db->insert_id();
    }

    /**
     * 관리자 목록 조회(반드시 partner_id 제한).
     */
    public function get_requests_by_partner($partner_id, $limit = 50, $offset = 0)
    {
        return $this->db
            ->where('partner_id', (int) $partner_id)
            ->order_by('id', 'DESC')
            ->limit((int) $limit, (int) $offset)
            ->get($this->request_table)
            ->result_array();
    }

    /**
     * 관리자 상세 조회(반드시 partner_id + request_id 동시 제한).
     */
    public function get_request_detail_for_partner($partner_id, $request_id)
    {
        $request = $this->db
            ->where('partner_id', (int) $partner_id)
            ->where('id', (int) $request_id)
            ->limit(1)
            ->get($this->request_table)
            ->row_array();

        if (!$request) {
            return array();
        }

        $devices = $this->db
            ->where('buyback_request_id', (int) $request_id)
            ->order_by('id', 'ASC')
            ->get($this->device_table)
            ->result_array();

        $request['devices'] = $devices;
        return $request;
    }

    /**
     * API 전송 로그 기록.
     */
    public function insert_api_log($data)
    {
        $this->db->insert($this->api_log_table, $data);
        return (int) $this->db->insert_id();
    }
}
