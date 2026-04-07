<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Sub extends CI_Controller
{
	function __construct()
	{
		parent::__construct();

		// $autoload['helper'] = array('url', 'file', 'common');

		$this->load->helper(array('form', 'load','security'));



		// 관리자 로그인 후에만 접속 가능, 그 외에는 메인 페이지로 이동.
		if (! $this->tank_auth->is_admin()) {			// not logged in or activated
			$this->tank_auth->logout();
			redirect('/auth/login/'. url_code( current_url(), 'e'));
		}
	}

	function index()
	{
		//redirect(base_url().'admin/sub/main');
		$this->main();
	}

	function main() {

		$data['viewPage'] = 'admin/sub_view';
		$this->load->view('admin/layout_view', $data);
	}



}