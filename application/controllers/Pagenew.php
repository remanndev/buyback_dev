<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pagenew extends CI_Controller {

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

		// $autoload['helper'] = array('url', 'file', 'common');
		$this->load->helper(array('form', 'load'));
		$this->arr_seg = $this->uri->segment_array();
	}



	function _remap($page_name=FALSE)
	{

		if(! $page_name):
			alert('잘못된 경로로 접속하셨습니다.','/');
		endif;

		//$arr_page = explode('-',$page_name);

		//$view_page = 'pages/'. str_replace('-','_',$page_name) .'_view';
		//$view_page = 'page/'. str_replace('-','_',$page_name);
		$view_page = 'page/'. trim($page_name);
		if ( ! is_file(realpath(APPPATH).'/views/'.$view_page.'.php')) {
			alert('해당 파일이나 경로가 존재하지 않습니다.');
		}

		$this->load->library('querystring', NULL, 'param'); // 쿼리스트링 주소
		$param  =& $this->param;
		$qstr = $param->qstr;

		$pno = isset($qstr['pno']) ? $qstr['pno'] : false;
		$add_url = ($pno) ? '?pno='.$pno : '';

		//$newpage = isset($qstr['np']) ? $qstr['np'] : false;

		$data = array(
			'page_ttl' => '페이지 - '.$page_name,
			'add_url' => $add_url,
			'pno' => $pno,
			'arr_seg' => $this->arr_seg,
			'viewPage' => $view_page
		);


		$this->load->view('layout_blank_view', $data);
	}


}

/* End of file page.php */
/* Location: ./application/controllers/page.php */