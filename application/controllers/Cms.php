<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cms extends CI_Controller {

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
		// $this->load->library('cms_lib');


		// $autoload['helper'] = array('url', 'file', 'common');
		$this->load->helper(array('form', 'load'));
		$this->arr_seg = $this->uri->segment_array();
	}





	function _remap($page_type=FALSE,$arr=FALSE)
	{

		$page_code = isset($arr[0]) ? trim($arr[0]) : '';

		if(! $page_code || $page_code == ''):
			alert('잘못된 경로로 접속하셨습니다.','/');
		endif;

		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		// 메뉴 정보 가져오기
		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		$meta_arr = array('sql_select' => '*','sql_from' => 'mng_cms','sql_where' => array('page_code'=>$page_code));
		$this->cms_row = $this->basic_model->arr_get_row($meta_arr);
		if((! isset($this->cms_row->page_code) OR $this->cms_row->del_datetime !== NULL)) {
			alert('이미 삭제되었거나, 존재하지 않는 페이지입니다.', base_url());
		}

		// echo $this->cms_row->page_title;
		$this->first_code = $this->cms_row->first_code;
		$this->page_code = $this->cms_row->page_code;



		if($page_type == 'C') :
			$this->_ctnt_page($page_code,$arr);
		elseif($page_type == 'H') :
			$this->_html_page($page_code,$arr);
		elseif($page_type == 'L') :
			$this->_land_page($page_code,$arr);
		endif;
	}




	private function _ctnt_page($page_code=FALSE,$arr=FALSE)
	{

		if(! $page_code):
			alert('잘못된 경로로 접속하셨습니다.','/');
		endif;

		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		// 메뉴 정보 가져오기
		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		$cms_arr = array('sql_select' => '*','sql_from' => 'mng_cms','sql_where' => array('page_code'=>$page_code, 'page_type'=>'ctntpage'));
		$cms_row = $this->basic_model->arr_get_row($cms_arr);
		if((! isset($cms_row->page_code) OR $cms_row->del_datetime !== NULL)) {
			alert('이미 삭제되었거나, 존재하지 않는 페이지입니다.', base_url());
		}

		$menu_name = $cms_row->menu_name;
		$idx = $cms_row->page_flag;
		$page_uri = (isset($arr[0]) && $arr[0] != '') ? $arr[0] : FALSE;

		if(! $idx):
			alert('잘못된 경로로 접속하셨습니다.','/');
		endif;

		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		// 생성된 컨텐츠 페이지 정보 가져오기
		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		$sql_select = '*';
		$sql_from = 'mng_contents';
		$sql_where = array('idx'=>$idx,'del_datetime'=>NULL);
		// 검색 상관없는 전체 수
		$arr = array(
				'sql_select'     => $sql_select,
				'sql_from'       => $sql_from,
				'sql_where'      => $sql_where, //array('PIDX' => $pidx),
		);
		$row = $this->basic_model->arr_get_row($arr);

		$data = array(
			'row' => $row,
			'page_ttl' => $page_uri,
			'arr_seg' => $this->arr_seg,
			'viewPage' => 'page_contents_view'
		);

		$this->load->view('layout_view', $data);
	}



	private function _html_page($page_code=FALSE,$arr=FALSE)
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
		$page_name = $cms_row->page_flag;
		$page_uri = (isset($arr[0]) && $arr[0] != '') ? $arr[0] : FALSE;

		$view_page = 'page/'. trim($page_name);
		if ( ! is_file(realpath(APPPATH).'/views/'.$view_page.'.php')) {
			alert('해당 파일이나 경로가 존재하지 않습니다. \n'.'/views/'.$view_page.'.php');
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



	private function _land_page($page_code=FALSE,$arr=FALSE)
	{


		if(! $page_code):
			alert('잘못된 경로로 접속하셨습니다.','/');
		endif;

		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		// 메뉴 정보 가져오기
		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		$cms_arr = array('sql_select' => '*','sql_from' => 'mng_cms','sql_where' => array('page_code'=>$page_code, 'page_type'=>'landpage'));
		$cms_row = $this->basic_model->arr_get_row($cms_arr);
		if((! isset($cms_row->page_code) OR $cms_row->del_datetime !== NULL)) {
			alert('이미 삭제되었거나, 존재하지 않는 페이지입니다.', base_url());
		}

		$menu_name = $cms_row->menu_name;
		$idx = $cms_row->page_flag;
		$page_uri = (isset($arr[0]) && $arr[0] != '') ? $arr[0] : FALSE;

		if(! $idx):
			alert('잘못된 경로로 접속하셨습니다.','/');
		endif;

		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		// 생성된 컨텐츠 페이지 정보 가져오기
		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		$sql_select = '*';
		$sql_from = 'mng_landing';
		$sql_where = array('idx'=>$idx,'del_datetime'=>NULL);
		// 검색 상관없는 전체 수
		$arr = array(
				'sql_select'     => $sql_select,
				'sql_from'       => $sql_from,
				'sql_where'      => $sql_where, //array('PIDX' => $pidx),
		);
		$row = $this->basic_model->arr_get_row($arr);

		$data = array(
			'row' => $row,
			'page_ttl' => $page_uri,
			'arr_seg' => $this->arr_seg,
			'viewPage' => 'page_landing_view'
		);

		$this->load->view('layout_view', $data);
	}

}

/* End of file page.php */
/* Location: ./application/controllers/page.php */