<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sell extends CI_Controller {

	function __construct()
	{
		parent::__construct();

		$this->load->library('tank_auth');
        $this->load->model('Buyback_model');
        $this->load->library(array('session', 'form_validation'));
        $this->load->helper(array('url', 'form'));
		
		load_css('<link rel="stylesheet" href="'.CSS_DIR.'/page_buyback.css?v=260326" />');

	}

	// 매입 신청 페이지
	public function index()
	{

		// load css, js  - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		/*
			load_css('<link rel="stylesheet" href="'.LIB_DIR.'/slider/slick-1.8.1/slick/slick.css" />');
			load_css('<link rel="stylesheet" href="'.LIB_DIR.'/slider/slick-1.8.1/slick/slick-theme.css" />');
			load_js('<script src="'.LIB_DIR.'/slider/slick-1.8.1/slick/slick.min.js"></script>');
			load_css('<link href="//spoqa.github.io/spoqa-han-sans/css/SpoqaHanSansNeo.css" rel="stylesheet" type="text/css">');
		*/

        $data = array(
            'complete_message' => $this->session->flashdata('complete_message'),
			'viewPage' => 'sell/sell_view'
        );

		$this->load->view('layout/layout_view', $data);
	}



    public function save_devices()
    {
        if ($this->input->method(TRUE) !== 'POST') {
            show_404();
        }

        $devices_json = $this->input->post('devices', false);
        $total_price  = $this->input->post('total_price', true);

        $devices = json_decode($devices_json, true);

        if (!is_array($devices) || empty($devices)) {
            return $this->_json(array(
                'result' => 'fail',
                'message' => '기기 정보가 없습니다.'
            ));
        }

        $normalized_devices = $this->_normalize_devices($devices);

        if (empty($normalized_devices)) {
            return $this->_json(array(
                'result' => 'fail',
                'message' => '유효한 기기 정보가 없습니다.'
            ));
        }

        $computed_total = $this->_calc_total_price($normalized_devices);

        $this->session->set_userdata('buyback_devices', $normalized_devices);
        $this->session->set_userdata('buyback_total_price_value', $computed_total);
        $this->session->set_userdata('buyback_total_price_text', '₩ ' . number_format($computed_total));

        return $this->_json(array(
            'result' => 'ok'
        ));
    }

    public function pickup()
    {
        $devices = $this->session->userdata('buyback_devices');
        $total_price_text = $this->session->userdata('buyback_total_price_text');
        $total_price_value = $this->session->userdata('buyback_total_price_value');

        if (empty($devices) || !is_array($devices)) {
            redirect('/sell');
            return;
        }

        $data = array(
            'devices' => $devices,
            'total_price_text' => $total_price_text ?: '₩ 0',
            'total_price_value' => (int)$total_price_value,
			'viewPage' => 'sell/pickup_view'
        );

		$this->load->view('layout/layout_view', $data);
    }

    public function submit()
    {
        if ($this->input->method(TRUE) !== 'POST') {
            show_404();
        }

        $devices = $this->session->userdata('buyback_devices');
        $total_price_text = $this->session->userdata('buyback_total_price_text');
        $total_price_value = $this->session->userdata('buyback_total_price_value');

        if (empty($devices) || !is_array($devices)) {
            redirect('/sell');
            return;
        }

        $this->form_validation->set_rules('name', '이름', 'required|trim|max_length[100]');
        $this->form_validation->set_rules('phone', '연락처', 'required|trim|max_length[20]');
        $this->form_validation->set_rules('address1', '주소', 'required|trim|max_length[255]');
        $this->form_validation->set_rules('address2', '상세주소', 'trim|max_length[255]');
        $this->form_validation->set_rules('visit_date', '방문일', 'required|trim');
        $this->form_validation->set_rules('visit_time', '방문시간', 'required|trim|max_length[50]');
        $this->form_validation->set_rules('pickup_location', '수거장소', 'required|trim|max_length[50]');
        $this->form_validation->set_rules('pickup_memo', '메모', 'trim|max_length[255]');
        $this->form_validation->set_rules('bank_name', '은행명', 'required|trim|max_length[50]');
        $this->form_validation->set_rules('account_number', '계좌번호', 'required|trim|max_length[100]');

        if ($this->form_validation->run() === FALSE) {
            $data = array(
                'devices' => $devices,
                'total_price_text' => $total_price_text ?: '₩ 0',
                'total_price_value' => (int)$total_price_value
            );

            $this->load->view('sell/pickup', $data);
            return;
        }

        $request_data = array(
            'request_no'        => $this->_generate_request_no(),
            'applicant_name'    => $this->input->post('name', true),
            'phone'             => $this->_normalize_phone($this->input->post('phone', true)),
            'address1'          => $this->input->post('address1', true),
            'address2'          => $this->input->post('address2', true),
            'visit_date'        => $this->input->post('visit_date', true),
            'visit_time'        => $this->input->post('visit_time', true),
            'pickup_location'   => $this->input->post('pickup_location', true),
            'pickup_memo'       => $this->input->post('pickup_memo', true),
            'bank_name'         => $this->input->post('bank_name', true),
            'account_number'    => $this->input->post('account_number', true),
            'total_price_text'  => $total_price_text ?: '₩ 0',
            'total_price_value' => (int)$total_price_value,
            'status'            => 'REQUESTED',
            'reg_ip'            => $this->input->ip_address()
        );

        $request_id = $this->Buyback_model->insert_request_with_devices($request_data, $devices);

        if (!$request_id) {
            show_error('수거 신청 저장 중 오류가 발생했습니다.');
        }

        $this->session->unset_userdata('buyback_devices');
        $this->session->unset_userdata('buyback_total_price_text');
        $this->session->unset_userdata('buyback_total_price_value');

        $this->session->set_flashdata('complete_message', '수거 신청이 정상적으로 접수되었습니다.');

        redirect('/sell');
    }

    private function _normalize_devices($devices)
    {
        $result = array();

        foreach ($devices as $idx => $device) {
            if (!is_array($device)) {
                continue;
            }

            $specs = array();
            if (isset($device['specs']) && is_array($device['specs'])) {
                $specs = $device['specs'];
            }

            $qty = isset($device['qty']) ? (int)$device['qty'] : 1;
            if ($qty < 1) {
                $qty = 1;
            }

            $price_value = isset($device['price_value']) ? (int)$device['price_value'] : 0;

            $manufacturer = '';
            if (!empty($device['manufacturer'])) {
                $manufacturer = trim($device['manufacturer']);
            } elseif (!empty($specs['category'])) {
                $manufacturer = trim($specs['category']);
            }

            $model_name = '';
            if (!empty($device['model'])) {
                $model_name = trim($device['model']);
            } elseif (!empty($specs['name'])) {
                $model_name = trim($specs['name']);
            }

            $part_type = !empty($specs['part_type']) ? trim($specs['part_type']) : '';
            $category_name = !empty($specs['category']) ? trim($specs['category']) : '';

            $result[] = array(
                'device_type'      => !empty($device['device']) ? trim($device['device']) : '',
                'manufacturer'     => $manufacturer,
                'model_name'       => $model_name,
                'part_type'        => $part_type,
                'category_name'    => $category_name,
                'condition_grade'  => !empty($device['condition']) ? trim($device['condition']) : '',
                'qty'              => $qty,
                'unit_price_value' => $price_value,
                'unit_price_text'  => '₩ ' . number_format($price_value) . ' ~',
                'spec_json'        => json_encode($specs, JSON_UNESCAPED_UNICODE),
                'sort_order'       => $idx + 1
            );
        }

        return $result;
    }

    private function _calc_total_price($devices)
    {
        $total = 0;

        foreach ($devices as $device) {
            $price = isset($device['unit_price_value']) ? (int)$device['unit_price_value'] : 0;
            $qty   = isset($device['qty']) ? (int)$device['qty'] : 1;
            if ($qty < 1) {
                $qty = 1;
            }

            $total += ($price * $qty);
        }

        return $total;
    }

    private function _generate_request_no()
    {
        return 'SB' . date('YmdHis') . mt_rand(100, 999);
    }

    private function _normalize_phone($phone)
    {
        return preg_replace('/[^0-9]/', '', (string)$phone);
    }

    private function _json($data)
    {
        $this->output
            ->set_content_type('application/json', 'utf-8')
            ->set_output(json_encode($data, JSON_UNESCAPED_UNICODE));
    }
	
	
	
}
