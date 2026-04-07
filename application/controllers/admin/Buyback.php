<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Buyback extends CI_Controller
{
	function __construct()
	{
		parent::__construct();

		$this->load->helper(array('form', 'url','load','security'));
		$this->load->library('form_validation');
		$this->load->library('tank_auth');
		$this->load->library('upload_lib');
		$this->load->library('querystring');
		$this->lang->load('tank_auth');

        $this->load->model('Buyback_model');

		$this->username = $this->tank_auth->get_username();
		$this->arr_seg = $this->uri->segment_array();

		// 관리자 로그인 후에만 접속 가능, 그 외에는 메인 페이지로 이동.
		if (! $this->tank_auth->is_admin()) {			// not logged in or activated
			$this->tank_auth->logout();
			redirect('/auth/login/'. url_code( current_url(), 'e'));
		}

		load_css('<link rel="stylesheet" href="'.CSS_DIR.'/page_buyback.css?v=260326" />');

	}

    public function index()
    {
		redirect('/admin/buyback/list');
	}


    public function list()
    {

		// Get data.
			$breadcrumb = array(
				'중고매입'=>base_url().'admin/backup',
				'페이지 관리'=>''
			);

			$data = array(
				'arr_seg'   => $this->arr_seg, //$this->uri->segment_array(),
				'breadcrumb'    => $breadcrumb,
				'requests' => $this->Buyback_model->get_request_list(),
				'viewPage'  => 'admin/buyback_list'
			);

			$this->load->view('admin/layout_view', $data);
    }

    public function delete($id = 0)
    {
        $id = (int)$id;

        if ($id < 1) {
            show_404();
        }

        $this->Buyback_model->delete_request($id);

        redirect('/admin/buyback');
    }
}
