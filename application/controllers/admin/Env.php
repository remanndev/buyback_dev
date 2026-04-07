<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Env extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->library('tank_auth');
		$this->lang->load('tank_auth');

		// 관리자 로그인 후에만 접속 가능, 그 외에는 메인 페이지로 이동.
		if(! $this->tank_auth->is_admin() ) {
			$this->tank_auth->logout();
			redirect('/auth/login/'. url_code('/admin','e'));
		}

		$this->arr_seg = $this->uri->segment_array();

		//redirect('/admin/user/');
		//exit;
	}

	function index()
	{
		redirect(base_url().'admin/env/visit/');
	}


	function sns_month()
	{
		$arr = array(
			'sql_select'     => '*',
			'sql_from'       => 'visit_stats_sns',
			'sql_where'   => 'idx > 0',
			'sql_order_by'   => 'idx DESC'
		);
		$result = $this->basic_model->arr_get_result($arr);

		// print_r($result['qry']);


	}




	// 월간 통계 - sns
	function stats_sns()
	{

		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		// 페이징 정보 
		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
			$this->load->library('segment', array('offset'=>4), 'seg'); // 세그먼트 주소( page 위치 )
			$this->load->library('querystring', NULL, 'param'); // 쿼리스트링 주소
			$seg	  =& $this->seg;
			$param	  =& $this->param;

			// [페이징]
			$qstr = '';

			$get_cate_menu = $param->get('cate', false);
			$qstr = ( $get_cate_menu ) ? '?cate='.$get_cate_menu : '';

			
			// 검색
			if($sfl = $param->get('sfl',FALSE)) { // search field
				$qstr .= ('' == $qstr) ? '?' : '&';
				$qstr .= 'sfl='.$sfl;
			}
			if($stx = $param->get('stx',FALSE)) { // search text
				$qstr .= ('' == $qstr) ? '?' : '&';
				$qstr .= 'stx='.$stx;
			}

			// 정렬
			if($ofl = $param->get('ofl','')) { // order_field
				$qstr .= ('' == $qstr) ? '?' : '&';
				//$qstr .= 'ofl='.$ofl;
				$qstr .= ($ofl != '') ? 'ofl='.$ofl : '';
			}

			// 페이징
			$limit = '20';
			$page  = $seg->get('page', 1); // 페이지
			if(! isset($page) OR empty($page)) {
				$page = '1';
			}
			$offset = ($page - 1) * $limit;


		// [SQL] visit
			$arr = array('sql_select' => '*','sql_from' => 'visit_stats_sns','sql_where' => array('idx > ' => 0),'sql_order_by' => 'idx DESC','page' => $page,'limit' => $limit,'offset' => $offset,);
			$result = $this->basic_model->arr_get_result($arr);

			$list = array('month'=>'','naver_month'=>'','google_month'=>'','daum_month'=>'');
			foreach($result['qry'] as $i => $o)
			{
				// 번호
				//$num = ($result['total_count'] - $limit*($page-1) - $i);
				//$result['qry'][$i]->num = $num;

				$list['month'] = $o->date_month;
				$list['naver_month'] = isset($o->naver_month) ? $o->naver_month : 0;
				$list['google_month'] = isset($o->google_month) ? $o->google_month : 0;
				$list['daum_month'] = isset($o->daum_month) ? $o->daum_month : 0;

				break;
			}





			// pagination 설정
			$config['suffix']	   = $qstr; //$qstr;
			$config['base_url']    = base_url().'admin/env/stats_sns/page/';
			$config['per_page']    = $limit;
			$config['total_rows']  = $result['total_count'];
			$config['uri_segment'] = $seg->pos('page');  // 5
			// 페이징 버튼
			$btn_prev_part = $btn_next_part = '';
			$config['full_tag_open']  = "<ul class='pagination'>".$btn_prev_part;
			$config['full_tag_close'] = $btn_next_part.'</ul>';

			$this->load->library('pagination', $config);

			$paging_html = $this->pagination->create_links();






		// Get data.
			$breadcrumb = array(
				'관리자 메인'=>base_url().'admin/main'
			);

			$data = array(
				'list' => $list,
				'result' => $result,
				'paging'    => $paging_html,

				'arr_seg'   => $this->arr_seg,
				'breadcrumb'    => $breadcrumb,
				'viewPage'  => 'admin/env_visit_stats_sns'
			);

			$this->load->view('admin/layout_view', $data);
	}















	function visit()
	{

		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		// 페이징 정보 
		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
			$this->load->library('segment', array('offset'=>4), 'seg'); // 세그먼트 주소( page 위치 )
			$this->load->library('querystring', NULL, 'param'); // 쿼리스트링 주소
			$seg	  =& $this->seg;
			$param	  =& $this->param;

			// [페이징]
			$qstr = '';

			$get_cate_menu = $param->get('cate', false);
			$qstr = ( $get_cate_menu ) ? '?cate='.$get_cate_menu : '';

			
			// 검색
			if($sfl = $param->get('sfl',FALSE)) { // search field
				$qstr .= ('' == $qstr) ? '?' : '&';
				$qstr .= 'sfl='.$sfl;
			}
			if($stx = $param->get('stx',FALSE)) { // search text
				$qstr .= ('' == $qstr) ? '?' : '&';
				$qstr .= 'stx='.$stx;
			}

			// 정렬
			if($ofl = $param->get('ofl','')) { // order_field
				$qstr .= ('' == $qstr) ? '?' : '&';
				//$qstr .= 'ofl='.$ofl;
				$qstr .= ($ofl != '') ? 'ofl='.$ofl : '';
			}

			// 페이징
			$limit = '20';
			$page  = $seg->get('page', 1); // 페이지
			if(! isset($page) OR empty($page)) {
				$page = '1';
			}
			$offset = ($page - 1) * $limit;


		// [SQL] visit
			$arr = array('sql_select' => '*','sql_from' => 'visit','sql_where' => array('cnt > ' => 0),'sql_order_by' => 'vi_id DESC','page' => $page,'limit' => $limit,'offset' => $offset,);
			$result = $this->basic_model->arr_get_result($arr);

			foreach($result['qry'] as $i => $o)
			{
				// 번호
				$num = ($result['total_count'] - $limit*($page-1) - $i);
				$result['qry'][$i]->num = $num;
			}





			// pagination 설정
			$config['suffix']	   = $qstr; //$qstr;
			$config['base_url']    = base_url().'admin/env/visit/page/';
			$config['per_page']    = $limit;
			$config['total_rows']  = $result['total_count'];
			$config['uri_segment'] = $seg->pos('page');  // 5
			// 페이징 버튼
			$btn_prev_part = $btn_next_part = '';
			$config['full_tag_open']  = "<ul class='pagination'>".$btn_prev_part;
			$config['full_tag_close'] = $btn_next_part.'</ul>';

			$this->load->library('pagination', $config);

			$paging_html = $this->pagination->create_links();






		// Get data.
			$breadcrumb = array(
				'관리자 메인'=>base_url().'admin/main'
			);

			$data = array(
				'result' => $result,
				'paging'    => $paging_html,

				'arr_seg'   => $this->arr_seg,
				'breadcrumb'    => $breadcrumb,
				'viewPage'  => 'admin/env_visit'
			);

			$this->load->view('admin/layout_view', $data);
	}


	function visit_bot()
	{


		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		// 페이징 정보 
		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
			$this->load->library('segment', array('offset'=>4), 'seg'); // 세그먼트 주소( page 위치 )
			$this->load->library('querystring', NULL, 'param'); // 쿼리스트링 주소
			$seg	  =& $this->seg;
			$param	  =& $this->param;

			// [페이징]
			$qstr = '';

			$get_cate_menu = $param->get('cate', false);
			$qstr = ( $get_cate_menu ) ? '?cate='.$get_cate_menu : '';

			
			// 검색
			if($sfl = $param->get('sfl',FALSE)) { // search field
				$qstr .= ('' == $qstr) ? '?' : '&';
				$qstr .= 'sfl='.$sfl;
			}
			if($stx = $param->get('stx',FALSE)) { // search text
				$qstr .= ('' == $qstr) ? '?' : '&';
				$qstr .= 'stx='.$stx;
			}

			// 정렬
			if($ofl = $param->get('ofl','')) { // order_field
				$qstr .= ('' == $qstr) ? '?' : '&';
				//$qstr .= 'ofl='.$ofl;
				$qstr .= ($ofl != '') ? 'ofl='.$ofl : '';
			}

			// 페이징
			$limit = '20';
			$page  = $seg->get('page', 1); // 페이지
			if(! isset($page) OR empty($page)) {
				$page = '1';
			}
			$offset = ($page - 1) * $limit;

		// [SQL] visit
			$arr = array('sql_select' => '*','sql_from' => 'visit_bot','sql_where' => array('cnt > ' => 0),'sql_order_by' => 'vi_id DESC','page' => $page,'limit' => $limit,'offset' => $offset,);
			$result = $this->basic_model->arr_get_result($arr);

			foreach($result['qry'] as $i => $o)
			{
				// 번호
				$num = ($result['total_count'] - $limit*($page-1) - $i);
				$result['qry'][$i]->num = $num;
			}





			// pagination 설정
			$config['suffix']	   = $qstr; //$qstr;
			$config['base_url']    = base_url().'admin/env/visit_bot/page/';
			$config['per_page']    = $limit;
			$config['total_rows']  = $result['total_count'];
			$config['uri_segment'] = $seg->pos('page');  // 5
			// 페이징 버튼
			$btn_prev_part = $btn_next_part = '';
			$config['full_tag_open']  = "<ul class='pagination'>".$btn_prev_part;
			$config['full_tag_close'] = $btn_next_part.'</ul>';

			$this->load->library('pagination', $config);

			$paging_html = $this->pagination->create_links();


		// Get data.
			$breadcrumb = array(
				'관리자 메인'=>base_url().'admin/main'
			);

			$data = array(
				'result' => $result,
				'paging'    => $paging_html,

				'arr_seg'   => $this->arr_seg,
				'breadcrumb'    => $breadcrumb,
				'viewPage'  => 'admin/env_visit'
			);

			$this->load->view('admin/layout_view', $data);
	}



	// 기본 통계
	function stats()
	{

		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		// 페이징 정보 
		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
			$this->load->library('segment', array('offset'=>4), 'seg'); // 세그먼트 주소( page 위치 )
			$this->load->library('querystring', NULL, 'param'); // 쿼리스트링 주소
			$seg	  =& $this->seg;
			$param	  =& $this->param;

			// [페이징]
			$qstr = '';

			$get_cate_menu = $param->get('cate', false);
			$qstr = ( $get_cate_menu ) ? '?cate='.$get_cate_menu : '';

			
			// 검색
			if($sfl = $param->get('sfl',FALSE)) { // search field
				$qstr .= ('' == $qstr) ? '?' : '&';
				$qstr .= 'sfl='.$sfl;
			}
			if($stx = $param->get('stx',FALSE)) { // search text
				$qstr .= ('' == $qstr) ? '?' : '&';
				$qstr .= 'stx='.$stx;
			}

			// 정렬
			if($ofl = $param->get('ofl','')) { // order_field
				$qstr .= ('' == $qstr) ? '?' : '&';
				//$qstr .= 'ofl='.$ofl;
				$qstr .= ($ofl != '') ? 'ofl='.$ofl : '';
			}

			// 페이징
			$limit = '20';
			$page  = $seg->get('page', 1); // 페이지
			if(! isset($page) OR empty($page)) {
				$page = '1';
			}
			$offset = ($page - 1) * $limit;


		// [SQL] visit
			$arr = array('sql_select' => '*','sql_from' => 'visit_stats','sql_where' => array('idx > ' => 0),'sql_order_by' => 'date DESC','page' => $page,'limit' => $limit,'offset' => $offset,);
			$result = $this->basic_model->arr_get_result($arr);

			$list = array('date'=>'','today_visitor'=>'','today_view'=>'','total_visitor'=>'','total_view'=>'','today_visitor_bot'=>'','today_view_bot'=>'','total_visitor_bot'=>'','total_view_bot'=>'');
			foreach($result['qry'] as $i => $o)
			{
				// 번호
				//$num = ($result['total_count'] - $limit*($page-1) - $i);
				//$result['qry'][$i]->num = $num;

				$list['date'] = $o->date;
				$list['today_visitor'] = isset($o->today_visitor) ? $o->today_visitor : 0;
				$list['today_view'] = isset($o->today_view) ? $o->today_view : 0;
				$list['total_visitor'] = isset($o->total_visitor) ? $o->total_visitor : 0;
				$list['total_view'] = isset($o->total_view) ? $o->total_view : 0;

				$list['today_visitor_bot'] = isset($o->today_visitor_bot) ? $o->today_visitor_bot : 0;
				$list['today_view_bot'] = isset($o->today_view_bot) ? $o->today_view_bot : 0;
				$list['total_visitor_bot'] = isset($o->total_visitor_bot) ? $o->total_visitor_bot : 0;
				$list['total_view_bot'] = isset($o->total_view_bot) ? $o->total_view_bot : 0;

				break;
			}





			// pagination 설정
			$config['suffix']	   = $qstr; //$qstr;
			$config['base_url']    = base_url().'admin/env/stats/page/';
			$config['per_page']    = $limit;
			$config['total_rows']  = $result['total_count'];
			$config['uri_segment'] = $seg->pos('page');  // 5
			// 페이징 버튼
			$btn_prev_part = $btn_next_part = '';
			$config['full_tag_open']  = "<ul class='pagination'>".$btn_prev_part;
			$config['full_tag_close'] = $btn_next_part.'</ul>';

			$this->load->library('pagination', $config);

			$paging_html = $this->pagination->create_links();






		// Get data.
			$breadcrumb = array(
				'관리자 메인'=>base_url().'admin/main'
			);

			$data = array(
				'list' => $list,
				'result' => $result,
				'paging'    => $paging_html,

				'arr_seg'   => $this->arr_seg,
				'breadcrumb'    => $breadcrumb,
				'viewPage'  => 'admin/env_visit_stats'
			);

			$this->load->view('admin/layout_view', $data);
	}


	// 주간 통계
	function stats_week()
	{

		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		// 페이징 정보 
		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
			$this->load->library('segment', array('offset'=>4), 'seg'); // 세그먼트 주소( page 위치 )
			$this->load->library('querystring', NULL, 'param'); // 쿼리스트링 주소
			$seg	  =& $this->seg;
			$param	  =& $this->param;

			// [페이징]
			$qstr = '';

			$get_cate_menu = $param->get('cate', false);
			$qstr = ( $get_cate_menu ) ? '?cate='.$get_cate_menu : '';

			
			// 검색
			if($sfl = $param->get('sfl',FALSE)) { // search field
				$qstr .= ('' == $qstr) ? '?' : '&';
				$qstr .= 'sfl='.$sfl;
			}
			if($stx = $param->get('stx',FALSE)) { // search text
				$qstr .= ('' == $qstr) ? '?' : '&';
				$qstr .= 'stx='.$stx;
			}

			// 정렬
			if($ofl = $param->get('ofl','')) { // order_field
				$qstr .= ('' == $qstr) ? '?' : '&';
				//$qstr .= 'ofl='.$ofl;
				$qstr .= ($ofl != '') ? 'ofl='.$ofl : '';
			}

			// 페이징
			$limit = '20';
			$page  = $seg->get('page', 1); // 페이지
			if(! isset($page) OR empty($page)) {
				$page = '1';
			}
			$offset = ($page - 1) * $limit;


		// [SQL] visit
			$arr = array('sql_select' => '*','sql_from' => 'visit_stats_week','sql_where' => array('idx > ' => 0),'sql_order_by' => 'monday_week DESC','page' => $page,'limit' => $limit,'offset' => $offset,);
			$result = $this->basic_model->arr_get_result($arr);

			$list = array('date'=>'','week_visitor'=>'','week_view'=>'','total_visitor'=>'','total_view'=>'','week_visitor_bot'=>'','week_view_bot'=>'','total_visitor_bot'=>'','total_view_bot'=>'');
			foreach($result['qry'] as $i => $o)
			{
				// 번호
				//$num = ($result['total_count'] - $limit*($page-1) - $i);
				//$result['qry'][$i]->num = $num;

				$list['date'] = $o->monday_week;
				$list['week_visitor'] = isset($o->week_visitor) ? $o->week_visitor : 0;
				$list['week_view'] = isset($o->week_view) ? $o->week_view : 0;
				$list['total_visitor'] = isset($o->total_visitor) ? $o->total_visitor : 0;
				$list['total_view'] = isset($o->total_view) ? $o->total_view : 0;

				$list['week_visitor_bot'] = isset($o->week_visitor_bot) ? $o->week_visitor_bot : 0;
				$list['week_view_bot'] = isset($o->week_view_bot) ? $o->week_view_bot : 0;
				$list['total_visitor_bot'] = isset($o->total_visitor_bot) ? $o->total_visitor_bot : 0;
				$list['total_view_bot'] = isset($o->total_view_bot) ? $o->total_view_bot : 0;

				break;
			}





			// pagination 설정
			$config['suffix']	   = $qstr; //$qstr;
			$config['base_url']    = base_url().'admin/env/stats_week/page/';
			$config['per_page']    = $limit;
			$config['total_rows']  = $result['total_count'];
			$config['uri_segment'] = $seg->pos('page');  // 5
			// 페이징 버튼
			$btn_prev_part = $btn_next_part = '';
			$config['full_tag_open']  = "<ul class='pagination'>".$btn_prev_part;
			$config['full_tag_close'] = $btn_next_part.'</ul>';

			$this->load->library('pagination', $config);

			$paging_html = $this->pagination->create_links();






		// Get data.
			$breadcrumb = array(
				'관리자 메인'=>base_url().'admin/main'
			);

			$data = array(
				'list' => $list,
				'result' => $result,
				'paging'    => $paging_html,

				'arr_seg'   => $this->arr_seg,
				'breadcrumb'    => $breadcrumb,
				'viewPage'  => 'admin/env_visit_stats_week'
			);

			$this->load->view('admin/layout_view', $data);
	}











	/* - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	 * QR 방문 통계
	*/

	// QR 방문자 정보
	function qr_visit() {

		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		// 페이징 정보 
		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
			$this->load->library('segment', array('offset'=>4), 'seg'); // 세그먼트 주소( page 위치 )
			$this->load->library('querystring', NULL, 'param'); // 쿼리스트링 주소
			$seg	  =& $this->seg;
			$param	  =& $this->param;

			// [페이징]
			$qstr = '';
			
			// 검색
			if($sfl = $param->get('sfl',FALSE)) { // search field
				$qstr .= ('' == $qstr) ? '?' : '&';
				$qstr .= 'sfl='.$sfl;
			}
			if($stx = $param->get('stx',FALSE)) { // search text
				$qstr .= ('' == $qstr) ? '?' : '&';
				$qstr .= 'stx='.$stx;
			}
			// 정렬
			if($ofl = $param->get('ofl','')) { // order_field
				$qstr .= ('' == $qstr) ? '?' : '&';
				//$qstr .= 'ofl='.$ofl;
				$qstr .= ($ofl != '') ? 'ofl='.$ofl : '';
			}

			// 페이징
			$limit = '20';
			$page  = $seg->get('page', 1); // 페이지
			if(! isset($page) OR empty($page)) {
				$page = '1';
			}
			$offset = ($page - 1) * $limit;


		// [SQL] visit
			$arr = array('sql_select' => '*','sql_from' => 'qr_visit','sql_where' => array('cnt > ' => 0),'sql_order_by' => 'vi_id DESC','page' => $page,'limit' => $limit,'offset' => $offset,);
			$result = $this->basic_model->arr_get_result($arr);

			foreach($result['qry'] as $i => $o)
			{
				// 번호
				$num = ($result['total_count'] - $limit*($page-1) - $i);
				$result['qry'][$i]->num = $num;
			}

			// pagination 설정
			$config['suffix']	   = $qstr; //$qstr;
			$config['base_url']    = base_url().'admin/env/qr_visit/page/';
			$config['per_page']    = $limit;
			$config['total_rows']  = $result['total_count'];
			$config['uri_segment'] = $seg->pos('page');  // 5
			// 페이징 버튼
			$btn_prev_part = $btn_next_part = '';
			$config['full_tag_open']  = "<ul class='pagination'>".$btn_prev_part;
			$config['full_tag_close'] = $btn_next_part.'</ul>';

			$this->load->library('pagination', $config);

			$paging_html = $this->pagination->create_links();


		// Get data.
			$breadcrumb = array(
				'관리자 메인'=>base_url().'admin/main'
			);

			$data = array(
				'result' => $result,
				'paging'    => $paging_html,

				'arr_seg'   => $this->arr_seg,
				'breadcrumb'    => $breadcrumb,
				'viewPage'  => 'admin/env_qr_visit'
			);

			$this->load->view('admin/layout_view', $data);
	}




	// QR 방문자 정보 일간 통계
	function qr_stats() {

		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		// 페이징 정보 
		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
			$this->load->library('segment', array('offset'=>4), 'seg'); // 세그먼트 주소( page 위치 )
			$this->load->library('querystring', NULL, 'param'); // 쿼리스트링 주소
			$seg	  =& $this->seg;
			$param	  =& $this->param;

			// [페이징]
			$qstr = '';
			
			// 검색
			if($sfl = $param->get('sfl',FALSE)) { // search field
				$qstr .= ('' == $qstr) ? '?' : '&';
				$qstr .= 'sfl='.$sfl;
			}
			if($stx = $param->get('stx',FALSE)) { // search text
				$qstr .= ('' == $qstr) ? '?' : '&';
				$qstr .= 'stx='.$stx;
			}

			// 정렬
			if($ofl = $param->get('ofl','')) { // order_field
				$qstr .= ('' == $qstr) ? '?' : '&';
				//$qstr .= 'ofl='.$ofl;
				$qstr .= ($ofl != '') ? 'ofl='.$ofl : '';
			}

			// 페이징
			$limit = '20';
			$page  = $seg->get('page', 1); // 페이지
			if(! isset($page) OR empty($page)) {
				$page = '1';
			}
			$offset = ($page - 1) * $limit;


		// [SQL] visit
			$arr = array('sql_select' => '*','sql_from' => 'qr_stats_day','sql_where' => array('idx > ' => 0),'sql_order_by' => 'date DESC','page' => $page,'limit' => $limit,'offset' => $offset,);
			$result = $this->basic_model->arr_get_result($arr);

			$list = array('date'=>'','today_visitor'=>'','today_view'=>'','total_visitor'=>'','total_view'=>'');
			foreach($result['qry'] as $i => $o)
			{
				// 번호
				//$num = ($result['total_count'] - $limit*($page-1) - $i);
				//$result['qry'][$i]->num = $num;

				$list['date'] = $o->date;
				$list['acc_from'] = isset($o->acc_from) ? $o->acc_from : '';
				$list['today_visitor'] = isset($o->today_visitor) ? $o->today_visitor : 0;
				$list['today_view'] = isset($o->today_view) ? $o->today_view : 0;
				$list['total_visitor'] = isset($o->total_visitor) ? $o->total_visitor : 0;
				$list['total_view'] = isset($o->total_view) ? $o->total_view : 0;

				break;
			}


			// pagination 설정
			$config['suffix']	   = $qstr; //$qstr;
			$config['base_url']    = base_url().'admin/env/qr_stats/page/';
			$config['per_page']    = $limit;
			$config['total_rows']  = $result['total_count'];
			$config['uri_segment'] = $seg->pos('page');  // 5
			// 페이징 버튼
			$btn_prev_part = $btn_next_part = '';
			$config['full_tag_open']  = "<ul class='pagination'>".$btn_prev_part;
			$config['full_tag_close'] = $btn_next_part.'</ul>';

			$this->load->library('pagination', $config);

			$paging_html = $this->pagination->create_links();


		// Get data.
			$breadcrumb = array(
				'관리자 메인'=>base_url().'admin/main'
			);

			$data = array(
				'list' => $list,
				'result' => $result,
				'paging'    => $paging_html,

				'arr_seg'   => $this->arr_seg,
				'breadcrumb'    => $breadcrumb,
				'viewPage'  => 'admin/env_qr_stats'
			);

			$this->load->view('admin/layout_view', $data);
	}




	// QR 방문자 정보 주간 통계
	function qr_stats_week()
	{

		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		// 페이징 정보 
		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
			$this->load->library('segment', array('offset'=>4), 'seg'); // 세그먼트 주소( page 위치 )
			$this->load->library('querystring', NULL, 'param'); // 쿼리스트링 주소
			$seg	  =& $this->seg;
			$param	  =& $this->param;

			// [페이징]
			$qstr = '';
			
			// 검색
			if($sfl = $param->get('sfl',FALSE)) { // search field
				$qstr .= ('' == $qstr) ? '?' : '&';
				$qstr .= 'sfl='.$sfl;
			}
			if($stx = $param->get('stx',FALSE)) { // search text
				$qstr .= ('' == $qstr) ? '?' : '&';
				$qstr .= 'stx='.$stx;
			}

			// 정렬
			if($ofl = $param->get('ofl','')) { // order_field
				$qstr .= ('' == $qstr) ? '?' : '&';
				//$qstr .= 'ofl='.$ofl;
				$qstr .= ($ofl != '') ? 'ofl='.$ofl : '';
			}

			// 페이징
			$limit = '20';
			$page  = $seg->get('page', 1); // 페이지
			if(! isset($page) OR empty($page)) {
				$page = '1';
			}
			$offset = ($page - 1) * $limit;


		// [SQL] visit
			$arr = array('sql_select' => '*','sql_from' => 'qr_stats_week','sql_where' => array('idx > ' => 0),'sql_order_by' => 'monday_week DESC','page' => $page,'limit' => $limit,'offset' => $offset,);
			$result = $this->basic_model->arr_get_result($arr);

			$list = array('date'=>'','week_visitor'=>'','week_view'=>'','total_visitor'=>'','total_view'=>'');
			foreach($result['qry'] as $i => $o)
			{
				// 번호
				//$num = ($result['total_count'] - $limit*($page-1) - $i);
				//$result['qry'][$i]->num = $num;

				$list['date'] = $o->monday_week;
				$list['acc_from'] = isset($o->acc_from) ? $o->acc_from : '';
				$list['week_visitor'] = isset($o->week_visitor) ? $o->week_visitor : 0;
				$list['week_view'] = isset($o->week_view) ? $o->week_view : 0;
				$list['total_visitor'] = isset($o->total_visitor) ? $o->total_visitor : 0;
				$list['total_view'] = isset($o->total_view) ? $o->total_view : 0;

				break;
			}


			// pagination 설정
			$config['suffix']	   = $qstr; //$qstr;
			$config['base_url']    = base_url().'admin/env/qr_stats_week/page/';
			$config['per_page']    = $limit;
			$config['total_rows']  = $result['total_count'];
			$config['uri_segment'] = $seg->pos('page');  // 5
			// 페이징 버튼
			$btn_prev_part = $btn_next_part = '';
			$config['full_tag_open']  = "<ul class='pagination'>".$btn_prev_part;
			$config['full_tag_close'] = $btn_next_part.'</ul>';

			$this->load->library('pagination', $config);

			$paging_html = $this->pagination->create_links();


		// Get data.
			$breadcrumb = array(
				'관리자 메인'=>base_url().'admin/main'
			);

			$data = array(
				'list' => $list,
				'result' => $result,
				'paging'    => $paging_html,

				'arr_seg'   => $this->arr_seg,
				'breadcrumb'    => $breadcrumb,
				'viewPage'  => 'admin/env_qr_stats_week'
			);

			$this->load->view('admin/layout_view', $data);
	}














	private function _sns_input() 
	{

		$arr = array(
				'sql_select'     => '*',
				'sql_from'       => 'visit_stats_sns',
				'sql_where'      => 'idx > 0',
				'limit'          => 1,
				'sql_order_by'   => 'idx DESC'
		);
		$row_latest = $this->basic_model->arr_get_row($arr);
		$latest_visit_idx = isset($row_latest->visit_idx) ? $row_latest->visit_idx : 0;

		if('' == $latest_visit_idx) {
			$latest_visit_idx = 0;
		}


		/* - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - */
		// SNS 접속자 통계 
		// visit_sns
		// $arr_sns = array('naver','google','daum');


		// SELECT * FROM `x_visit_sns` WHERE `vi_date` LIKE '2023-02%'


		$arr = array(
			'sql_select'     => '*',
			'sql_from'       => 'visit',
			'sql_where'   => 'vi_id > '.$latest_visit_idx,
			//'sql_where'   => 'vi_id >= 100001 AND vi_id < 150000',
			'sql_order_by'   => 'vi_id ASC'
		);

		$result_sns = $this->basic_model->arr_get_result($arr);

		$date_month = '';
		$last_month = '';

		$naver_month = 0;
		$naver_total = 0;
		$google_month = 0;
		$google_total = 0;
		$daum_month = 0;
		$daum_total = 0;
		$etc_month = 0;
		$etc_total = 0;

		$sns = '';


		foreach($result_sns['qry'] as $k => $o) {

			$visit_idx = $o->vi_id;

			$date = $o->vi_date;
			$date_month = substr($date, 0, 7); // 연월

			// echo $date_month.'<<<br />';

			// 새로운 달
			if($last_month != $date_month) {
				$naver_month = 0;
				$google_month = 0;
				$daum_month = 0;
				$etc_month = 0;
			}

			$last_month = $date_month;
			
			
			// naver
			if (strpos($o->vi_referer, 'naver') !== false) {
				//echo "URL에 '{$word}'가 포함되어 있습니다.\n";
				$sns = 'naver';
				$naver_month++;
			}
			elseif (strpos($o->vi_referer, 'google') !== false) {
				$sns = 'google';
				$google_month++;
			}
			elseif (strpos($o->vi_referer, 'daum') !== false) {
				$sns = 'daum';
				$daum_month++;
			}
			else {
				$sns = '';
				// $etc_month++;
			}

			$cnt = $this->basic_model->get_common_count('visit_stats_sns', array('date_month' => $date_month));

			if( $cnt < 1 ) {

				$arr = array(
					'sql_select'     => '*',
					'sql_from'       => 'visit_stats_sns',
					'sql_where'   => 'idx > 0',
					'sql_order_by'   => 'idx DESC',
					'limit' => 1
				);
				$row = $this->basic_model->arr_get_row($arr);
				
				$naver_total = isset($row->naver_total) ? $row->naver_total : 0;
				$naver_total += $naver_month;

				$google_total = isset($row->google_total) ? $row->google_total : 0;
				$google_total += $google_month;

				$daum_total = isset($row->daum_total) ? $row->daum_total : 0;
				$daum_total += $daum_month;

				$etc_total = isset($row->etc_total) ? $row->etc_total : 0;
				$etc_total += $etc_month;

				$sql = " insert into visit_stats_sns ( date_month, naver_month, naver_total, google_month, google_total, daum_month, daum_total, etc_month, etc_total, visit_idx ) values ";
				$sql .= " ( '".$date_month."', $naver_month, $naver_total, $google_month, $google_total, $daum_month, $daum_total, $etc_month, $etc_total, $visit_idx ) ";

				$this->db->simple_query($sql);

			}
			else {

				$sql = ' UPDATE visit_stats_sns SET ';

				if($sns == 'naver') {
					$sql .= ' naver_month=naver_month+1, naver_total=naver_total+1 ';
				}
				elseif($sns == 'google') {
					$sql .= ' google_month=google_month+1, google_total=google_total+1 ';
				}
				elseif($sns == 'daum') {
					$sql .= ' daum_month=daum_month+1, daum_total=daum_total+1 ';
				}
				else {
					$sql .= ' etc_month=etc_month+1, etc_total=etc_total+1 ';
				}

				$sql .= ', visit_idx="'.$visit_idx.'" ';

				$sql .= ' WHERE date_month = "'.$date_month.'" ';

				if('' != $sns) {
					$this->db->simple_query($sql);
				}

			}

		}



	}



}