<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Partner_sell extends CI_Controller
{
    protected $slug = '';
    protected $partner = array();

    public function __construct()
    {
        parent::__construct();

        $this->load->library('tank_auth');
        $this->load->library('partner_admin_auth');
        $this->load->library(array('session', 'form_validation'));
        $this->load->helper(array('url', 'form'));
        $this->load->model('Buyback_model');
        $this->load->model('Buyback_spec_model');
        $this->load->model('Partner_model');

        load_css('<link rel="stylesheet" href="'.CSS_DIR.'/page_buyback.css?v=260326" />');
    }

    public function index($slug)
    {
        $this->boot_partner($slug);
        $datasets = $this->Buyback_spec_model->get_front_datasets();

        $data = array(
            'partner' => $this->partner,
            'complete_message' => $this->session->flashdata($this->flash_key('complete_message')),
            'buyback_base_path' => $this->base_path(),
            'buyback_price_db_json' => json_encode($datasets['priceDB'], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
            'buyback_second_price_table_json' => json_encode($datasets['secondPriceTable'], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
            'header_view' => 'partner/header_view',
            'header_data' => $this->build_header_data(),
            'arr_meta' => $this->build_meta(
                $this->partner['name'] . ' 중고기기 매입 신청',
                $this->partner['name'] . ' 전용 중고기기 매입 신청 페이지입니다. 기기 선택부터 수거 신청까지 한 번에 진행하세요.',
                site_url($this->base_path())
            ),
            'viewPage' => 'sell/sell_view',
        );

        $this->load->view('layout/layout_view', $data);
    }

    public function save_devices($slug)
    {
        $this->boot_partner($slug);

        if ($this->input->method(TRUE) !== 'POST') {
            show_404();
        }

        $devices_json = $this->input->post('devices', false);
        $devices = json_decode($devices_json, true);

        if (!is_array($devices) || empty($devices)) {
            return $this->json(array(
                'result' => 'fail',
                'message' => 'No selected devices.',
            ));
        }

        $normalized_devices = $this->normalize_devices($devices);
        if (empty($normalized_devices)) {
            return $this->json(array(
                'result' => 'fail',
                'message' => 'No valid device rows to save.',
            ));
        }

        $computed_total = $this->calc_total_price($normalized_devices);

        $this->session->set_userdata($this->session_key('devices'), $normalized_devices);
        $this->session->set_userdata($this->session_key('total_price_value'), $computed_total);
        $this->session->set_userdata($this->session_key('total_price_text'), number_format($computed_total) . ' KRW');

        return $this->json(array('result' => 'ok'));
    }

    public function pickup($slug)
    {
        $this->boot_partner($slug);
        $this->guard_member();

        $devices = $this->session->userdata($this->session_key('devices'));
        $total_price_text = $this->session->userdata($this->session_key('total_price_text'));
        $total_price_value = $this->session->userdata($this->session_key('total_price_value'));

        if (empty($devices) || !is_array($devices)) {
            redirect('/' . $this->base_path());
            return;
        }

        $data = array(
            'partner' => $this->partner,
            'devices' => $devices,
            'total_price_text' => $total_price_text ?: '0 KRW',
            'total_price_value' => (int) $total_price_value,
            'default_name' => $this->get_default_applicant_name(),
            'default_phone' => $this->get_default_applicant_phone(),
            'buyback_base_path' => $this->base_path(),
            'header_view' => 'partner/header_view',
            'header_data' => $this->build_header_data(),
            'arr_meta' => $this->build_meta(
                $this->partner['name'] . ' 수거 정보 입력',
                $this->partner['name'] . ' 매입 신청을 위한 수거 정보 입력 단계입니다.',
                site_url($this->base_path() . '/pickup')
            ),
            'viewPage' => 'sell/pickup_view',
        );

        $this->load->view('layout/layout_view', $data);
    }

    public function submit($slug)
    {
        $this->boot_partner($slug);
        $this->guard_member();

        if ($this->input->method(TRUE) !== 'POST') {
            show_404();
        }

        $devices = $this->session->userdata($this->session_key('devices'));
        $total_price_text = $this->session->userdata($this->session_key('total_price_text'));
        $total_price_value = $this->session->userdata($this->session_key('total_price_value'));

        if (empty($devices) || !is_array($devices)) {
            redirect('/' . $this->base_path());
            return;
        }

        $this->form_validation->set_rules('name', 'Name', 'required|trim|max_length[100]');
        $this->form_validation->set_rules('phone', 'Phone', 'required|trim|callback_valid_phone|max_length[20]');
        $this->form_validation->set_rules('postcode', '우편번호', 'required|trim|max_length[10]');
        $this->form_validation->set_rules('address1', '주소', 'required|trim|max_length[255]');
        $this->form_validation->set_rules('address2', '상세주소', 'required|trim|max_length[255]');
        $this->form_validation->set_rules('visit_date', '방문일', 'required|trim');
        $this->form_validation->set_rules('visit_time', '방문시간', 'trim|max_length[50]');
        $this->form_validation->set_rules('pickup_location', '수거장소', 'trim|max_length[50]');
        $this->form_validation->set_rules('pickup_memo', '메모', 'trim|max_length[255]');
        $this->form_validation->set_rules('bank_name', '은행명', 'trim|max_length[50]');
        $this->form_validation->set_rules('account_number', '계좌번호', 'trim|max_length[100]');

        if ($this->form_validation->run() === FALSE) {
            $data = array(
                'partner' => $this->partner,
                'devices' => $devices,
                'total_price_text' => $total_price_text ?: '0 KRW',
                'total_price_value' => (int) $total_price_value,
                'default_name' => $this->get_default_applicant_name(),
                'default_phone' => $this->get_default_applicant_phone(),
                'buyback_base_path' => $this->base_path(),
                'header_view' => 'partner/header_view',
                'header_data' => $this->build_header_data(),
                'arr_meta' => $this->build_meta(
                    $this->partner['name'] . ' 수거 정보 입력',
                    $this->partner['name'] . ' 매입 신청을 위한 수거 정보 입력 단계입니다.',
                    site_url($this->base_path() . '/pickup')
                ),
                'viewPage' => 'sell/pickup_view',
            );

            $this->load->view('layout/layout_view', $data);
            return;
        }

        $request_data = array(
            'request_no' => $this->generate_request_no(),
            'partner_id' => $this->partner['id'],
            'member_user_id' => (int) $this->tank_auth->get_user_id(),
            'applicant_name' => $this->input->post('name', true),
            'phone' => $this->normalize_phone($this->input->post('phone', true)),
            'postcode' => $this->input->post('postcode', true),
            'address1' => $this->input->post('address1', true),
            'address2' => $this->input->post('address2', true),
            'visit_date' => $this->input->post('visit_date', true),
            'visit_time' => $this->input->post('visit_time', true),
            'pickup_location' => $this->input->post('pickup_location', true),
            'pickup_memo' => $this->input->post('pickup_memo', true),
            'bank_name' => $this->input->post('bank_name', true),
            'account_number' => $this->input->post('account_number', true),
            'total_price_text' => $total_price_text ?: '0 KRW',
            'total_price_value' => (int) $total_price_value,
            'status' => 'REQUESTED',
            'api_send_status' => 'READY',
            'reg_ip' => $this->input->ip_address(),
        );

        $request_id = $this->Buyback_model->insert_request_with_devices($request_data, $devices);
        if (!$request_id) {
            show_error('매입 신청 저장 중 오류가 발생했습니다.');
        }

        $this->clear_session();
        $this->session->set_flashdata($this->flash_key('complete_message'), '수거 신청이 정상적으로 접수되었습니다.');

        redirect('/' . $this->base_path());
    }

    protected function boot_partner($slug)
    {
        $this->slug = trim((string) $slug);
        $partner = $this->Partner_model->get_by_slug($this->slug);

        if (!$partner) {
            show_404();
        }

        $this->partner = $partner;
    }

    protected function guard_member()
    {
        if ($this->tank_auth->is_logged_in()) {
            return;
        }

        redirect('/partner/' . $this->slug . '/login/' . url_code(current_url(), 'e'));
    }

    protected function build_header_data()
    {
        return array(
            'header_mode' => 'partner_public',
            'partner' => $this->partner,
            'home_url' => site_url($this->base_path()),
            'member_login_url' => site_url('partner/' . $this->slug . '/login'),
            'member_logout_url' => site_url('partner/' . $this->slug . '/logout'),
            'partner_admin_login_url' => site_url('partner/' . $this->slug . '/admin/login'),
            'partner_admin_logout_url' => site_url('partner/' . $this->slug . '/admin/logout'),
            'partner_admin_url' => site_url('partner/' . $this->slug . '/admin/buyback'),
            'is_member_logged_in' => $this->tank_auth->is_logged_in(),
            'is_site_admin_logged_in' => $this->tank_auth->is_admin(),
            'is_partner_admin_logged_in' => $this->partner_admin_auth->is_logged_in($this->partner['id']),
        );
    }

    protected function session_key($suffix)
    {
        return 'partner_buyback_' . md5($this->slug) . '_' . $suffix;
    }

    protected function flash_key($suffix)
    {
        return 'partner_flash_' . md5($this->slug) . '_' . $suffix;
    }

    protected function clear_session()
    {
        $this->session->unset_userdata($this->session_key('devices'));
        $this->session->unset_userdata($this->session_key('total_price_text'));
        $this->session->unset_userdata($this->session_key('total_price_value'));
    }

    protected function base_path()
    {
        return 'partner/' . $this->slug . '/sell';
    }

    protected function normalize_devices($devices)
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

            $qty = isset($device['qty']) ? (int) $device['qty'] : 1;
            if ($qty < 1) {
                $qty = 1;
            }

            $price_value = isset($device['price_value']) ? (int) $device['price_value'] : 0;

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

            $result[] = array(
                'device_type' => !empty($device['device']) ? trim($device['device']) : '',
                'manufacturer' => $manufacturer,
                'model_name' => $model_name,
                'part_type' => !empty($specs['part_type']) ? trim($specs['part_type']) : '',
                'category_name' => !empty($specs['category']) ? trim($specs['category']) : '',
                'condition_grade' => !empty($device['condition']) ? trim($device['condition']) : '',
                'qty' => $qty,
                'unit_price_value' => $price_value,
                'unit_price_text' => number_format($price_value) . ' KRW',
                'spec_json' => json_encode($specs, JSON_UNESCAPED_UNICODE),
                'sort_order' => $idx + 1,
            );
        }

        return $result;
    }

    protected function calc_total_price($devices)
    {
        $total = 0;

        foreach ($devices as $device) {
            $price = isset($device['unit_price_value']) ? (int) $device['unit_price_value'] : 0;
            $qty = isset($device['qty']) ? (int) $device['qty'] : 1;
            if ($qty < 1) {
                $qty = 1;
            }

            $total += ($price * $qty);
        }

        return $total;
    }

    protected function build_meta($title, $description, $url = '')
    {
        $site_name = $this->config->item('website_name', 'tank_auth');

        return (object) array(
            'title' => $title . ' | ' . $site_name,
            'description' => $description,
            'og_title' => $title . ' | ' . $site_name,
            'og_description' => $description,
            'og_url' => $url ?: current_url(),
        );
    }

    protected function generate_request_no()
    {
        return 'PB' . date('YmdHis') . mt_rand(100, 999);
    }

    protected function normalize_phone($phone)
    {
        return preg_replace('/[^0-9]/', '', (string) $phone);
    }

    public function valid_phone($phone)
    {
        $normalized = $this->normalize_phone($phone);

        if ($normalized === '') {
            $this->form_validation->set_message('valid_phone', '올바른 연락처 형식으로 입력해주세요.');
            return false;
        }

        if (!preg_match('/^(01[016789][0-9]{7,8}|02[0-9]{7,8}|0[3-9][0-9][0-9]{7,8})$/', $normalized)) {
            $this->form_validation->set_message('valid_phone', '올바른 연락처 형식으로 입력해주세요.');
            return false;
        }

        return true;
    }

    protected function json($data)
    {
        $this->output
            ->set_content_type('application/json', 'utf-8')
            ->set_output(json_encode($data, JSON_UNESCAPED_UNICODE));
    }

    protected function get_current_userinfo()
    {
        if (!$this->tank_auth->is_logged_in()) {
            return false;
        }

        return $this->tank_auth->get_userinfo($this->tank_auth->get_username());
    }

    protected function get_default_applicant_name()
    {
        $user = $this->get_current_userinfo();
        if (!$user) {
            return '';
        }

        if (!empty($user->nickname)) {
            return (string) $user->nickname;
        }

        if (!empty($user->username)) {
            return (string) $user->username;
        }

        return '';
    }

    protected function get_default_applicant_phone()
    {
        $user = $this->get_current_userinfo();
        if (!$user || empty($user->phone)) {
            return '';
        }

        return (string) $user->phone;
    }
}
