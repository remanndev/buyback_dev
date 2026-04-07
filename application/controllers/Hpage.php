<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Hpage extends CI_Controller {

	function __construct()
	{
		parent::__construct();

		// To load the CI benchmark and memory usage profiler - set 1==1.
		if (2==1)
		{
			$sections = array(
				'benchmarks' => TRUE, 'memory_usage' => TRUE,
				'config' => FALSE, 'controller_info' => FALSE, 'get' => FALSE, 'post' => FALSE, 'queries' => FALSE,
				'uri_string' => FALSE, 'http_headers' => FALSE, 'session_data' => FALSE
			);
			$this->output->set_profiler_sections($sections);
			$this->output->enable_profiler(TRUE);
		}


		$this->load->library('tank_auth');


		// $autoload['helper'] = array('url', 'file', 'common');
		$this->load->helper(array('form', 'load'));
		$this->arr_seg = $this->uri->segment_array();
	}



	function _remap($page_code=FALSE,$arr=FALSE)
	{

		if(! $page_code):
			alert('잘못된 경로로 접속하셨습니다.','/');
		endif;

		// 메뉴 정보 가져오기
		$cms_arr = array('sql_select' => '*','sql_from' => 'mng_cms','sql_where' => array('page_code'=>$page_code, 'page_type'=>'htmlpage'));
		$cms_row = $this->basic_model->arr_get_row($cms_arr);
		if((! isset($cms_row->page_code) OR $cms_row->del_datetime !== NULL)) {
			alert('이미 삭제되었거나, 존재하지 않는 페이지입니다.', base_url());
		}

		$menu_name = $cms_row->menu_name;
		$page_name = $cms_row->page_type_sub;
		$page_uri = (isset($arr[0]) && $arr[0] != '') ? $arr[0] : FALSE;

		$view_page = 'page/'. trim($page_name);
		if ( ! is_file(realpath(APPPATH).'/views/'.$view_page.'.php')) {
			alert('해당 파일이나 경로가 존재하지 않습니다.');
		}

		$this->load->library('querystring', NULL, 'param'); // 쿼리스트링 주소
		$param  =& $this->param;
		$qstr = $param->qstr;

		$pno = isset($qstr['pno']) ? $qstr['pno'] : false;
		$add_url = ($pno) ? '?pno='.$pno : '';

		$data = array(
			'page_ttl' => '페이지 - '.$page_name,
			'add_url' => $add_url,
			'pno' => $pno,

			'page_code' => $page_code,

			'arr_seg' => $this->arr_seg,
			'viewPage' => $view_page
		);

		$this->load->view('layout_view', $data);
	}


}

/* End of file page.php */
/* Location: ./application/controllers/page.php */