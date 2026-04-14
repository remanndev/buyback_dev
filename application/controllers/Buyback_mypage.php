<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Buyback_mypage extends CI_Controller
{
	protected $user_idx = 0;
	protected $username = '';
	protected $user = null;
	protected $profile = null;

	public function __construct()
	{
		parent::__construct();

		$this->load->helper(array('url', 'form', 'load'));
		$this->load->library(array('session', 'tank_auth'));
		$this->lang->load('tank_auth');
		$this->load->model('Buyback_model');
		$this->load->model('tank_auth/users', 'auth_users');

		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/' . url_code(current_url(), 'e'));
			return;
		}

		if ($this->tank_auth->is_admin()) {
			redirect('/admin/');
			return;
		}

		$this->user_idx = (int) $this->tank_auth->get_user_id();
		$this->username = (string) $this->tank_auth->get_username();
		$this->user = $this->tank_auth->get_userinfo($this->username);
		$this->profile = $this->auth_users->get_profile_by_id($this->user_idx);

		load_css('<link rel="stylesheet" href="' . CSS_DIR . '/page_buyback.css?v=260326" />');
		load_css('<link rel="stylesheet" href="' . CSS_DIR . '/page_buyback_mypage.css?v=260410c" />');
	}

	public function index()
	{
		redirect('/mypage/main');
	}

	public function main()
	{
		$requests = $this->Buyback_model->get_member_request_list($this->user_idx);
		$summary = $this->build_summary($requests);

		$this->render('mypage/main_view', array(
			'current_menu' => 'main',
			'user_summary' => $this->build_user_summary(),
			'summary' => $summary,
			'recent_requests' => array_slice($summary['requests'], 0, 3),
		), json_decode('\"\ub9c8\uc774\ud398\uc774\uc9c0\"'));
	}

	public function buyback($method = 'lists', $request_id = false)
	{
		if ($method === 'lists') {
			$this->buyback_lists();
			return;
		}

		if ($method === 'detail') {
			$this->buyback_detail($request_id);
			return;
		}

		show_404();
	}

	public function user($page = 'edit')
	{
		$this->render('mypage/profile_view', array(
			'current_menu' => 'user',
			'user_summary' => $this->build_user_summary(),
		), json_decode('\"\ub0b4 \uc815\ubcf4\"'));
	}

	public function donation($arg1 = null, $arg2 = null, $arg3 = null)
	{
		redirect('/mypage/buyback/lists');
	}

	public function campaign($arg1 = null, $arg2 = null, $arg3 = null)
	{
		redirect('/mypage/main');
	}

	public function edit()
	{
		redirect('/mypage/user/edit');
	}

	protected function buyback_lists()
	{
		$requests = $this->Buyback_model->get_member_request_list($this->user_idx);
		$list = array();

		foreach ((array) $requests as $row) {
			$devices = isset($row['devices']) && is_array($row['devices']) ? $row['devices'] : array();
			$list[] = array(
				'id' => (int) $row['id'],
				'request_no' => isset($row['request_no']) ? $row['request_no'] : '',
				'partner_name' => !empty($row['partner_name']) ? $row['partner_name'] : '-',
				'status_label' => $this->status_label(isset($row['status']) ? $row['status'] : ''),
				'created_date' => !empty($row['created_at']) ? substr($row['created_at'], 0, 10) : '',
				'total_price_text' => $this->price_text(isset($row['total_price_value']) ? $row['total_price_value'] : 0),
				'device_summary' => $this->build_device_summary($devices),
				'detail_url' => '/mypage/buyback/detail/' . (int) $row['id'],
			);
		}

		$this->render('mypage/buyback_lists_view', array(
			'current_menu' => 'buyback',
			'user_summary' => $this->build_user_summary(),
			'list' => $list,
		), json_decode('\"\ub9e4\uc785 \uc2e0\uccad \ub0b4\uc5ed\"'));
	}

	protected function buyback_detail($request_id = false)
	{
		$request_id = (int) $request_id;
		if ($request_id < 1) {
			redirect('/mypage/buyback/lists');
			return;
		}

		$row = $this->Buyback_model->get_member_request_detail($request_id, $this->user_idx);
		if (empty($row)) {
			alert('조회할 수 없는 매입 신청입니다.', '/mypage/buyback/lists');
			return;
		}

		$devices = array();
		foreach ((array) $row['devices'] as $device) {
			$spec_lines = array();
			if (!empty($device['specs']) && is_array($device['specs'])) {
				foreach ($device['specs'] as $key => $value) {
					if ($value === '' || $value === null) {
						continue;
					}

					if (is_array($value)) {
						$value = implode(', ', $value);
					}

					$spec_lines[] = array(
						'label' => (string) $key,
						'value' => (string) $value,
					);
				}
			}

			$devices[] = array(
				'label' => $this->build_device_label($device),
				'qty' => isset($device['qty']) ? (int) $device['qty'] : 1,
				'condition_grade' => isset($device['condition_grade']) ? (string) $device['condition_grade'] : '',
				'price_text' => $this->price_text(isset($device['unit_price_value']) ? $device['unit_price_value'] : 0),
				'spec_lines' => $spec_lines,
			);
		}

		$request = array(
			'request_no' => isset($row['request_no']) ? $row['request_no'] : '',
			'partner_name' => !empty($row['partner_name']) ? $row['partner_name'] : '-',
			'status_label' => $this->status_label(isset($row['status']) ? $row['status'] : ''),
			'api_status_label' => $this->api_status_label(isset($row['api_send_status']) ? $row['api_send_status'] : ''),
			'applicant_name' => isset($row['applicant_name']) ? $row['applicant_name'] : '',
			'phone' => isset($row['phone']) ? $row['phone'] : '',
			'address' => trim(
				(isset($row['postcode']) ? $row['postcode'] : '') . ' ' .
				(isset($row['address1']) ? $row['address1'] : '') . ' ' .
				(isset($row['address2']) ? $row['address2'] : '')
			),
			'visit_at' => trim((isset($row['visit_date']) ? $row['visit_date'] : '') . ' ' . (isset($row['visit_time']) ? $row['visit_time'] : '')),
			'pickup_location' => isset($row['pickup_location']) ? $row['pickup_location'] : '',
			'pickup_memo' => isset($row['pickup_memo']) ? $row['pickup_memo'] : '',
			'bank_account' => trim((isset($row['bank_name']) ? $row['bank_name'] : '') . ' ' . (isset($row['account_number']) ? $row['account_number'] : '')),
			'total_price_text' => $this->price_text(isset($row['total_price_value']) ? $row['total_price_value'] : 0),
			'created_at' => isset($row['created_at']) ? $row['created_at'] : '',
			'devices' => $devices,
		);

		$this->render('mypage/buyback_detail_view', array(
			'current_menu' => 'buyback',
			'user_summary' => $this->build_user_summary(),
			'request' => $request,
		), json_decode('\"\ub9e4\uc785 \uc2e0\uccad \uc0c1\uc138\"'));
	}

	protected function render($view_page, $content_data, $title)
	{
		$description_map = array(
			'mypage/main_view' => json_decode('"\ub0b4 \uc911\uace0\uae30\uae30 \ub9e4\uc785 \uc2e0\uccad \ud604\ud669\uacfc \ucd5c\uadfc \uc2e0\uccad \ub0b4\uc5ed\uc744 \ud655\uc778\ud558\uc138\uc694."'),
			'mypage/buyback_lists_view' => json_decode('"\ub0b4\uac00 \uc2e0\uccad\ud55c \uc911\uace0\uae30\uae30 \ub9e4\uc785 \ub0b4\uc5ed\uacfc \uc9c4\ud589 \uc0c1\ud0dc\ub97c \ud655\uc778\ud558\uc138\uc694."'),
			'mypage/buyback_detail_view' => json_decode('"\uc120\ud0dd\ud55c \uc911\uace0\uae30\uae30 \ub9e4\uc785 \uc2e0\uccad\uc758 \uc0c1\uc138 \uc815\ubcf4\uc640 \ucc98\ub9ac \uc0c1\ud0dc\ub97c \ud655\uc778\ud558\uc138\uc694."'),
			'mypage/profile_view' => json_decode('"\ub0b4 \uc815\ubcf4\uc640 \uc5f0\ub77d\ucc98 \ub4f1 \ud68c\uc6d0 \uc815\ubcf4\ub97c \ud655\uc778\ud558\uc138\uc694."'),
		);

		$data = array(
			'header_view' => 'sell/header_view',
			'header_data' => $this->build_header_data(),
			'arr_meta' => $this->build_meta(
				$title,
				isset($description_map[$view_page]) ? $description_map[$view_page] : json_decode('"\ub9ac\ub9e8 \uc911\uace0 \ub9e4\uc785 \ub9c8\uc774\ud398\uc774\uc9c0\uc785\ub2c8\ub2e4."'),
				site_url(trim($this->uri->uri_string(), '/'))
			),
			'content_data' => $content_data,
			'viewPage' => $view_page,
		);

		$this->load->view('layout/layout_view', $data);
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

	protected function build_header_data()
	{
		return array(
			'home_url' => base_url('sell'),
			'member_login_url' => base_url('auth/login'),
			'member_logout_url' => base_url('auth/logout'),
			'admin_url' => base_url('admin'),
			'is_member_logged_in' => $this->tank_auth->is_logged_in(),
			'is_site_admin_logged_in' => $this->tank_auth->is_admin(),
		);
	}

	protected function build_summary($requests)
	{
		$summary = array(
			'total_count' => 0,
			'requested_count' => 0,
			'processing_count' => 0,
			'completed_count' => 0,
			'total_price_value' => 0,
			'total_price_text' => $this->price_text(0),
			'requests' => array(),
		);

		foreach ((array) $requests as $row) {
			$status = isset($row['status']) ? $row['status'] : '';
			$summary['total_count']++;
			$summary['total_price_value'] += isset($row['total_price_value']) ? (int) $row['total_price_value'] : 0;

			if ($status === 'REQUESTED' || $status === 'READY') {
				$summary['requested_count']++;
			} elseif ($status === 'REVIEWING') {
				$summary['processing_count']++;
			} elseif ($status === 'SENT') {
				$summary['completed_count']++;
			}

			$devices = isset($row['devices']) && is_array($row['devices']) ? $row['devices'] : array();
			$summary['requests'][] = array(
				'request_no' => isset($row['request_no']) ? $row['request_no'] : '',
				'created_date' => !empty($row['created_at']) ? substr($row['created_at'], 0, 10) : '',
				'status_label' => $this->status_label($status),
				'device_summary' => $this->build_device_summary($devices),
				'total_price_text' => $this->price_text(isset($row['total_price_value']) ? $row['total_price_value'] : 0),
				'detail_url' => '/mypage/buyback/detail/' . (int) $row['id'],
			);
		}

		$summary['total_price_text'] = $this->price_text($summary['total_price_value']);
		return $summary;
	}

	protected function build_user_summary()
	{
		$phone = '';
		if ($this->profile && isset($this->profile->phone)) {
			$phone = (string) $this->profile->phone;
		}

		return array(
			'nickname' => isset($this->user->nickname) ? (string) $this->user->nickname : '',
			'username' => $this->username,
			'email' => isset($this->user->email) ? (string) $this->user->email : '',
			'phone' => $phone,
			'login_type' => isset($this->user->sns) && $this->user->sns !== '' ? strtoupper((string) $this->user->sns) : 'GENERAL',
		);
	}

	protected function build_device_summary($devices)
	{
		$devices = is_array($devices) ? $devices : array();
		if (empty($devices)) {
			return '신청 기기 없음';
		}

		$first = $this->build_device_label($devices[0]);
		$count = count($devices);

		return $count > 1 ? ($first . ' 외 ' . ($count - 1) . '건') : $first;
	}

	protected function build_device_label($device)
	{
		$parts = array();
		foreach (array('device_type', 'part_type', 'manufacturer', 'category_name', 'model_name') as $field) {
			$value = isset($device[$field]) ? trim((string) $device[$field]) : '';
			if ($value !== '' && !in_array($value, $parts, true)) {
				$parts[] = $value;
			}
		}

		return !empty($parts) ? implode(' / ', $parts) : '기기 정보 없음';
	}

	protected function status_label($status)
	{
		$labels = array(
			'REQUESTED' => '접수완료',
			'REVIEWING' => '검수중',
			'READY' => '처리대기',
			'SENT' => '전송완료',
			'FAILED' => '전송실패',
			'CANCELLED' => '취소',
		);

		return isset($labels[$status]) ? $labels[$status] : ($status !== '' ? $status : '-');
	}

	protected function api_status_label($status)
	{
		$labels = array(
			'READY' => '전송 대기',
			'SENT' => '전송 완료',
			'FAILED' => '전송 실패',
		);

		return isset($labels[$status]) ? $labels[$status] : ($status !== '' ? $status : '-');
	}

	protected function price_text($amount)
	{
		return number_format((int) $amount) . '원';
	}
}
