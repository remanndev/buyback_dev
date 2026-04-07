<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Main extends CI_Controller
{
	function __construct()
	{
		parent::__construct();

		// $autoload['helper'] = array('url', 'file', 'common');

		$this->load->helper(array('form', 'security'));
		$this->load->library('form_validation');
		$this->load->library('tank_auth');
		$this->lang->load('tank_auth');

		// 관리자 로그인 후에만 접속 가능, 그 외에는 메인 페이지로 이동.
		if(! $this->tank_auth->is_admin() ) {
			$this->tank_auth->logout();
			redirect('/auth/login/'. url_code('/admin','e'));
		}

		$this->arr_seg = $this->uri->segment_array();



		redirect('/admin/buyback/list/');
		exit;


	}

	function index()
	{

		// Get data.
			$breadcrumb = array(
				'관리자 메인'=>base_url().'admin/main'
			);

			$data = array(
				'arr_seg'   => $this->arr_seg,
				'breadcrumb'    => $breadcrumb,
				'viewPage'  => 'admin/main_view'
			);

			$this->load->view('admin/layout_view', $data);


		//redirect('/admin/contents/cms/');

		/*

		if ($this->tank_auth->is_admin()) {									// logged in
			$data['arr_seg'] = $this->arr_seg;
			$data['viewPage'] = 'admin/main_view';
			//$this->load->view('admin/_layout_view', $data);
			$this->load->view('admin/adm_layout_view', $data);

		}
		elseif($this->tank_auth->is_logged_in()) {
			$this->tank_auth->logout();
			//alert('관리자로 로그인해주세요.','admin/');

			//alert($this->lang->line('auth_message_admin_page'), 'admin/');
		}
		else {
			//redirect('/auth/');
			redirect('/auth/login/'. url_code( current_url(), 'e'));
		}
		*/
	}

}