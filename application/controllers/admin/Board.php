<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Board extends CI_Controller
{
	function __construct()
	{
		parent::__construct();

		// $autoload['helper'] = array('url', 'file', 'common');

		$this->load->helper(array('form', 'load','security'));
		$this->load->library('form_validation');
		$this->load->library('tank_auth');
		$this->load->library('board_lib');
		$this->load->library('upload_lib');
		$this->load->model('upload_model');
		$this->lang->load('tank_auth');

		// 관리자 로그인 후에만 접속 가능, 그 외에는 메인 페이지로 이동.
		if (! $this->tank_auth->is_admin()) {			// not logged in or activated
			$this->tank_auth->logout();
			redirect('/auth/login/'. url_code( current_url(), 'e'));
		}

		$this->username = $this->tank_auth->get_username();
		$this->arr_seg = $this->uri->segment_array();

        //<!-- board.css -->
		load_css('<link rel="stylesheet" type="text/css" href="'. CSS_DIR .'/board.css?v='.time().'" />');





		/*
		// 필수 CSS 로드
		load_css('<link rel="stylesheet" type="text/css" href="'. LIB_DIR .'/editor/redactor/redactor.css" media="screen"/>');
		// 필수 JS 로드
		load_js('<script src="'. LIB_DIR .'/editor/redactor/redactor.js"></script>');
		load_js('<script src="'. LIB_DIR .'/editor/redactor/_langs/ko.js"></script>');
		load_js('<script src="'. LIB_DIR .'/editor/redactor/_plugins/table/table.js"></script>');
		load_js('<script src="'. LIB_DIR .'/editor/redactor/_plugins/video/video.js"></script>');
		*/


        //<!-- redactor.css -->
		load_css('<link rel="stylesheet" type="text/css" href="'. ASSETS_DIR .'/lib/editor/redactor-3-5-2/redactor.min.css" />');
    	//<!-- redactor.js -->
		load_js('<script src="'. ASSETS_DIR .'/lib/editor/redactor-3-5-2/redactor.min.js"></script>');
        //<!-- plugin js -->
		load_js('<script src="'. ASSETS_DIR .'/lib/editor/redactor-3-5-2/plugins/fontsize/fontsize.js"></script>');
		load_js('<script src="'. ASSETS_DIR .'/lib/editor/redactor-3-5-2/plugins/fontcolor/fontcolor.js"></script>');
		load_js('<script src="'. ASSETS_DIR .'/lib/editor/redactor-3-5-2/plugins/fontfamily/fontfamily.js"></script>');
		load_js('<script src="'. ASSETS_DIR .'/lib/editor/redactor-3-5-2/plugins/filemanager/filemanager.js"></script>');
		load_js('<script src="'. ASSETS_DIR .'/lib/editor/redactor-3-5-2/plugins/imagemanager/imagemanager.js"></script>');
		load_js('<script src="'. ASSETS_DIR .'/lib/editor/redactor-3-5-2/plugins/table/table.js"></script>');
		load_js('<script src="'. ASSETS_DIR .'/lib/editor/redactor-3-5-2/plugins/video/video.js"></script>');
		load_js('<script src="'. ASSETS_DIR .'/lib/editor/redactor-3-5-2/plugins/alignment/alignment.js"></script>');

		load_css('<link rel="stylesheet" type="text/css" href="'. ASSETS_DIR .'/lib/editor/redactor-3-5-2/plugins/inlinestyle/inlinestyle.css" />');
		load_js('<script src="'. ASSETS_DIR .'/lib/editor/redactor-3-5-2/plugins/inlinestyle/inlinestyle.js"></script>');

		load_js('<script src="'. ASSETS_DIR .'/lib/editor/redactor-3-5-2/plugins/specialchars/specialchars.js"></script>');
		load_js('<script src="'. ASSETS_DIR .'/lib/editor/redactor-3-5-2/plugins/textdirection/textdirection.js"></script>');
		load_js('<script src="'. ASSETS_DIR .'/lib/editor/redactor-3-5-2/plugins/widget/widget.js"></script>');
		load_js('<script src="'. ASSETS_DIR .'/lib/editor/redactor-3-5-2/plugins/fullscreen/fullscreen.js"></script>');

		//<!-- connect the languages file -->
		load_js('<script src="'. ASSETS_DIR .'/lib/editor/redactor-3-5-2/langs/ko.js?v='.time().'"></script>');



        //<!-- datetimekeeper -->
		load_css('<link rel="stylesheet" type="text/css" href="'. ASSETS_DIR .'/lib/datetimepicker-master/jquery.datetimepicker.min.css" />');
		load_js('<script src="'. ASSETS_DIR .'/lib/datetimepicker-master/jquery.datetimepicker.full.js"></script>');


		// slick slider
		load_css('<link rel="stylesheet" type="text/css" href="'. ASSETS_DIR .'/lib/slider/slick-1.8.1/slick/slick.css" />');
		load_css('<link rel="stylesheet" type="text/css" href="'. ASSETS_DIR .'/lib/slider/slick-1.8.1/slick/slick-theme.css" />');
		load_js('<script src="'. ASSETS_DIR .'/lib/slider/slick-1.8.1/slick/slick.min.js?v='.time().'"></script>');





		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		// 생성된 게시판 목록 가져오기
		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		$sql_select = 'bconf.idx, bconf.gr_code, bconf.bo_code, bconf.bo_title, bconf.bo_use_category, bconf.bo_category, bgrp.gr_title';
		$sql_from = 'board_config as bconf';
		$sql_where = array('bconf.idx >' => 0);
		$sql_group_by = FALSE;
		$sql_order_by = 'bgrp.gr_code ASC';
		// 조인
		$sql_join_tbl = 'board_group as bgrp';
		$sql_join_on = 'bconf.gr_code = bgrp.gr_code';
		$sql_join_option = 'LEFT OUTER';

		// 검색 상관없는 전체 수
		$this->board_total_count = $this->basic_model->get_common_count($sql_from,$sql_where);
		$arr = array(
				'sql_select'     => $sql_select,
				'sql_from'       => $sql_from,
				'sql_join_tbl'       => $sql_join_tbl,
				'sql_join_on'        => $sql_join_on,
				'sql_join_option'    => $sql_join_option,
				'sql_where'      => $sql_where, //array('PIDX' => $pidx),
				'sql_group_by'   => $sql_group_by,
				'sql_order_by'   => $sql_order_by,  // $order_field.' DESC, IDX DESC',
		);
		$this->boards_result = $this->basic_model->arr_get_result($arr);
		//print_r($this->boards_result);

		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		// 회원 레벨
		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		$arr = array('sql_select' => '*','sql_from' => 'user_level','sql_where' => array('use' => 'Y'),'sql_order_by' => 'no ASC');
		$this->level_result = $this->basic_model->arr_get_result($arr);
		//print_r($this->level_result);

	}






	function index()
	{
		//redirect(base_url().'admin/sub/main');
		//$this->main();

		redirect(base_url().'admin/board/lists');

		
	}

	function main() {

		// Get data.
		$breadcrumb = array(
			'게시판'=>base_url().'admin/board/main',
			'게시판 관리'=>''
		);

		$data = array(
			'arr_seg'   => $this->arr_seg,
			'breadcrumb'    => $breadcrumb,
			'viewPage'  => 'admin/board_main_view'
		);

		$this->load->view('admin/layout_view', $data);
	}















	function group()
	{

			// 마스터 관리자가 아니면 redirect
			if('sadmin' !== $this->username){
				redirect('/admin/board/main');
			}

			// # [2017-03-15] 에러 메시지 CSS
			//$this->form_validation->set_error_delimiters('<div class="error_board_admin">','</div>');
			$this->form_validation->set_error_delimiters('<div class="error">','</div>');
			$gr_data = array('errors'=>array());

			// # 그룹 신규 등록 - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
			if( $gr_submit = $this->input->post('gr_submit', FALSE) ) {
				$this->form_validation->set_rules('duplicate_gr_code', '그룹코드', '');
				$this->form_validation->set_rules('gr_code', '그룹코드', 'trim|required|xss_clean|duplicate[duplicate_gr_code]');
				$this->form_validation->set_rules('gr_title', '그룹이름', 'trim|required|xss_clean');
				$this->form_validation->set_rules('gr_admin', '그룹관리자', 'trim|required|xss_clean');

				if ($this->form_validation->run()) {	// validation ok
					// 신규그룹 등록일 경우에만 아이디 등록
					$gr_code  = $this->form_validation->set_value('gr_code');
					$gr_title = $this->form_validation->set_value('gr_title');
					$gr_admin = $this->form_validation->set_value('gr_admin');

					if(! $this->board_lib->is_board_available('board_group','gr_code',$gr_code)) {
						alert('이미 존재하는 그룹 코드입니다.',current_url());
						//alert('이미 존재하는 그룹 코드입니다.',$this->uri->uri_string());
					}

					if (!is_null($gr_data = $this->board_lib->make_board_group($gr_code,$gr_title,$gr_admin))) {		// success
						sess_message('게시판 그룹이 추가되었습니다.');
						redirect(current_url());
						//redirect($this->uri->uri_string());
					} else {
						$errors = $this->tank_auth->get_error_message();
						foreach ($errors as $k => $v)	$gr_data['errors'][$k] = $this->lang->line($v);
					}
				}
			}






			// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
			// 페이징 정보 
			// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
			$this->load->library('segment', array('offset'=>4), 'seg'); // 세그먼트 주소( page 위치 )
			$this->load->library('querystring', NULL, 'param'); // 쿼리스트링 주소
			$seg	  =& $this->seg;
			$param	  =& $this->param;
			
			// [페이징]
			$qstr = '';
			
			// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
			// sql 
			// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
			$sql_select = 'idx,gr_code,gr_title,gr_admin_fk,gr_reg_date,gr_reg_ip';
			$sql_from = 'board_group';
			$sql_where = array('idx >' => 0);
			$sql_group_by = FALSE;
			$sql_order_by = 'gr_code ASC';

			// 페이징
			$limit = '20';
			$page  = $seg->get('page', 1); // 페이지
			if(! isset($page) OR empty($page)) {
				$page = '1';
			}
			$offset = ($page - 1) * $limit;

			// 검색
			$like_field = FALSE;                         // search
			$like_match = FALSE;
			$like_side = 'both';
			// 조인
			$sql_join_tbl = FALSE;
			$sql_join_on = FALSE;
			$sql_join_option = 'LEFT OUTER';

			// 검색 상관없는 전체 수
			$board_grp_total_count = $this->basic_model->get_common_count($sql_from,$sql_where);

			$arr = array(
					'sql_select'     => $sql_select,
					'sql_from'       => $sql_from,
					'sql_join_tbl'       => $sql_join_tbl,
					'sql_join_on'        => $sql_join_on,
					'sql_join_option'    => $sql_join_option,
					'like_field'      => $like_field,
					'like_match'      => $like_match,
					'like_side'      => $like_side,
					'sql_where'      => $sql_where, //array('PIDX' => $pidx),
					'sql_group_by'   => $sql_group_by,
					'sql_order_by'   => $sql_order_by,  // $order_field.' DESC, IDX DESC',
					'page'      => $page,
					'limit'      => $limit,
					'offset'      => $offset,
			);
			$result = $this->basic_model->arr_get_result($arr);





			// pagination 설정
			$config['suffix']	   = $qstr;
			$config['base_url']    = base_url() . 'admin/board/group/page/';
			$config['per_page']    = $limit;
			$config['total_rows']  = $result['total_count'];
			$config['uri_segment'] = $seg->pos('page');  // 5

			// 검색 목록 ADD
			$btn_prev_part = $btn_next_part = '';
			$config['full_tag_open']  = "<ul class='pagination'>".$btn_prev_part;
			$config['full_tag_close'] = $btn_next_part.'</ul>';

			//$CI =& get_instance();
			//$CI->load->library('pagination', $config);
			$this->load->library('pagination', $config);


			// 그룹에 속한 게시판 목록
			$boards_in_group = array();
			foreach($result['qry'] as $i => $o)
			{
				$arr = array(
						'sql_select'     => 'idx,gr_code,bo_code,bo_title',
						'sql_from'       => 'board_config',
						'sql_where'      => array('gr_code'=>$o->gr_code),
						'sql_group_by'   => FALSE,
						'sql_order_by'   => 'bo_title ASC',
				);
				$boards_in_group = $this->basic_model->arr_get_result($arr);


				$result['qry'][$i]->board_count = $boards_in_group['total_count'];
				$result['qry'][$i]->board_list = $boards_in_group['qry'];
			}

			// 관리자 권한을 가진 회원 명단
			$arr = array(
					'sql_select'     => 'id,username,nickname,is_sadmin',
					'sql_from'       => 'users_admin',
					'sql_where'      => array('deleted'=>NULL,'username !='=>'sadmin'),
					'sql_group_by'   => FALSE,
					'sql_order_by'   => 'id ASC',
			);
			$gr_admin = $this->basic_model->arr_get_result($arr);





		// Get data.
			$breadcrumb = array(
				'게시판'=>base_url().'admin/board/main',
				'그룹'=>''
			);

			$data = array(
				'gr_submit' => $gr_submit,
				'gr_data'   => $gr_data,
				'gr_admin'  => $gr_admin,

				'boards_result' => $this->boards_result,

				'total_cnt' => $board_grp_total_count,
				'result'    => $result,
				'page'      => $page,
				'limit'      => $limit,
				'paging'    => $this->pagination->create_links(),
				'arr_seg'   => $this->arr_seg, //$this->uri->segment_array(),

				'breadcrumb'    => $breadcrumb,
				'viewPage'  => 'admin/board_group_view'
			);

			$this->load->view('admin/layout_view', $data);
	}




	function group_del($gr_code=FALSE)
	{
		// 마스터 관리자가 아니면 redirect
		if('sadmin' !== $this->username){
			redirect('/admin/board/main');
		}

		/*
		// 그룹에 속한 게시판이 하나라도 있다면 그룹 삭제 불가
		$bo_cnt = $this->basic_model->get_common_count('board_config', array('gr_code'=>$gr_code));
		if($bo_cnt > 0) {
			alert('그룹에 속한 게시판이 남아 있습니다. ');
		}
		// 게시판 그룹 정보를 완전히 삭제
		else if($res = $this->board_lib->delete_board_group($gr_code)) {
			if( 'exist_boards' === $res )
				alert('그룹에 속한 게시판이 있습니다. 해당 게시판을 다른 그룹으로 이동하신 후 삭제해주세요.');
			else
				alert('그룹이 삭제되었습니다.','admin/board/group');
		}
		*/

		if($res = $this->board_lib->delete_board_group($gr_code)) {
			if( 'exist_boards' === $res ) {
				alert('그룹에 속한 게시판이 있습니다.\n해당 게시판을 다른 그룹으로 이동하신 후 삭제해주세요.');
			}
			else {
				//alert('그룹이 삭제되었습니다.','admin/board/group');
				sess_message('그룹이 삭제되었습니다.');
				redirect('admin/board/group');
			}
		}
	}





	function lists()
	{
		// 마스터 관리자가 아니면 redirect
			if('sadmin' !== $this->username){
				//redirect('/admin/board/main');
			}

		// # [2017-03-16] 게시판 만들기
		// 에러 메시지 CSS
			$this->form_validation->set_error_delimiters('<div class="error_board_admin">','</div>');
			$bo_data = array('errors'=>array());

		// # 그룹 신규 등록 - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
			if( $new_bo_submit = $this->input->post('new_bo_submit', FALSE) ) {

				$this->form_validation->set_rules('duplicate_bo_code', '게시판 코드', '');
				$this->form_validation->set_rules('new_bo_code', '게시판 코드', 'trim|required|xss_clean|duplicate[duplicate_bo_code]');
				$this->form_validation->set_rules('new_bo_title', '게시판 제목', 'trim|required|xss_clean');
				$this->form_validation->set_rules('new_bo_type', '유형', 'trim|required|xss_clean');
				$this->form_validation->set_rules('gr_code', '그룹명', 'trim|required|xss_clean');

				if ($this->form_validation->run()) {	// validation ok
					// 신규그룹 등록일 경우에만 아이디 등록
					$new_bo_code  = $this->form_validation->set_value('new_bo_code');
					$new_bo_title = $this->form_validation->set_value('new_bo_title');
					$new_bo_type = $this->form_validation->set_value('new_bo_type');
					$gr_code = $this->form_validation->set_value('gr_code');

					if(! $this->board_lib->is_board_available('board_config','bo_code',$new_bo_code)) {
						alert('이미 존재하는 게시판 코드입니다.',current_url());
						//alert('이미 존재하는 그룹 코드입니다.',$this->uri->uri_string());
					}

					if (!is_null($bo_data = $this->board_lib->make_board($new_bo_code,$new_bo_title,$new_bo_type,$gr_code))) {		// success
						alert('게시판이 추가되었습니다');
						sess_message('게시판이 추가되었습니다.');
						redirect(current_url());
						//redirect($this->uri->uri_string());
					} else {
						$errors = $this->tank_auth->get_error_message();
						foreach ($errors as $k => $v)	$bo_data['errors'][$k] = $this->lang->line($v);
					}
				}
			}


		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		// 페이징 정보 
		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
			$this->load->library('segment', array('offset'=>4), 'seg'); // 세그먼트 주소( page 위치 )
			$this->load->library('querystring', NULL, 'param'); // 쿼리스트링 주소
			$seg	  =& $this->seg;
			$param	  =& $this->param;
			
			// [sql] where option 
			$sql_where_option = array('bconf.idx >' => 0);
			
			// [페이징]
			$qstr = '';
			
			// 검색
			if($sfl = $param->get('sfl',FALSE)) { // search field
				$qstr .= ('' == $qstr) ? '?' : '&';
				$qstr .= 'sfl='.$sfl;
			}
			if($stx = $param->get('stx',FALSE)) { // search text
				// 휴대전화 검색인 경우
				if(isset($sfl) && 'phone' == $sfl) {
					$stx = trim(str_replace('-','',$stx));
				}
				$qstr .= ('' == $qstr) ? '?' : '&';
				$qstr .= 'stx='.$stx;
			}
			// 정렬
			if($ofl = $param->get('ofl','bgrp.gr_code ASC')) { // order_field
				$qstr .= ('' == $qstr) ? '?' : '&';
				$qstr .= 'ofl='.$ofl;
			}

		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		// sql 
		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
			$sql_select = 'bconf.idx,bconf.gr_code,bconf.bo_code,bconf.bo_admin_fk,bconf.bo_title,bconf.bo_type,bconf.bo_cnt_write,bgrp.gr_title';
			$sql_from = 'board_config as bconf';
			$sql_where = $sql_where_option;
			$sql_group_by = FALSE;
			$sql_order_by = $ofl;

			// 페이징
			$limit = '20';
			$page  = $seg->get('page', 1); // 페이지
			if(! isset($page) OR empty($page)) {
				$page = '1';
			}
			$offset = ($page - 1) * $limit;

			// 검색
			$like_field = $sfl;                         // search
			$like_match = $stx;
			$like_side = 'both';
			// 조인
			$sql_join_tbl = 'board_group as bgrp';
			$sql_join_on = 'bconf.gr_code = bgrp.gr_code';
			$sql_join_option = 'LEFT OUTER';

			// 검색 상관없는 전체 수
			$total_cnt = $this->basic_model->get_common_count($sql_from,$sql_where);

			$arr = array(
					'sql_select'     => $sql_select,
					'sql_from'       => $sql_from,
					'sql_join_tbl'       => $sql_join_tbl,
					'sql_join_on'        => $sql_join_on,
					'sql_join_option'    => $sql_join_option,
					'like_field'      => $like_field,
					'like_match'      => $like_match,
					'like_side'      => $like_side,
					'sql_where'      => $sql_where,
					'sql_group_by'   => $sql_group_by,
					'sql_order_by'   => $sql_order_by,  // $order_field.' DESC, IDX DESC',
					'page'      => $page,
					'limit'      => $limit,
					'offset'      => $offset,
			);
			$result = $this->basic_model->arr_get_result($arr);



		// 게시판 관리자
			foreach($result['qry'] as $i => $o)
			{
				$user_mng = $this->tank_auth->get_admininfo_idx($o->bo_admin_fk);
				$result['qry'][$i]->bo_admin_nickname = isset($user_mng->nickname) ? $user_mng->nickname : '';
			}


		// pagination 설정
			$config['suffix']	   = $qstr;
			$config['base_url']    = base_url() . 'admin/board/lists/page/';
			$config['per_page']    = $limit;
			$config['total_rows']  = $result['total_count'];
			$config['uri_segment'] = $seg->pos('page');  // 5

		// 검색 목록 ADD
			$btn_prev_part = $btn_next_part = '';
			$config['full_tag_open']  = "<ul class='pagination'>".$btn_prev_part;
			$config['full_tag_close'] = $btn_next_part.'</ul>';

			$this->load->library('pagination', $config);

		// 그룹 리스트
			$arr = array(
					'sql_select'     => '*',
					'sql_from'       => 'board_group',
					'sql_where'      => array('idx >'=>'0'),
					'sql_order_by'   => 'gr_code ASC',
			);
			$gr_result = $this->basic_model->arr_get_result($arr);


		// 게시판 스킨 불러오기
			$arr_bbskin = array();
			$bbs_skin_dir = APPPATH.'views/board/';
			$bbs_skin_files = scandir($bbs_skin_dir); 
			foreach($bbs_skin_files as $file)
			{
				if(is_file($bbs_skin_dir.$file)){
					$tmp_arr = explode('_',$file);
					if( isset($tmp_arr[0]) && '' != $tmp_arr[0] ){
						if(! in_array($tmp_arr[0], $arr_bbskin)) {
							$arr_bbskin[$tmp_arr[0]] = $tmp_arr[0];
						}
					}
				}
			}


		// Get data.
			$breadcrumb = array(
				'게시판'=>base_url().'admin/board/main',
				'관리'=>''
			);

			$data = array(
				'sfl' => $sfl,
				'stx' => $stx,
				'ofl' => $ofl,

				'gr_result'  => $gr_result,
				'arr_bbskin' => $arr_bbskin,

				'boards_result' => $this->boards_result,

				'total_cnt' => $total_cnt,
				'result'    => $result,
				'page'      => $page,
				'limit'      => $limit,
				'paging'    => $this->pagination->create_links(),
				'arr_seg'   => $this->arr_seg, //$this->uri->segment_array(),

				'breadcrumb'    => $breadcrumb,
				'viewPage'  => 'admin/board_lists_view'
			);

			$this->load->view('admin/layout_view', $data);
	}









	// sadmin 전용
	function edit($bo_code=FALSE)
	{

		if(! $bo_code) {
			alert('게시판이 선택되지 않았습니다.');
		}

		// 마스터 관리자가 아니면 redirect
		if('sadmin' !== $this->username){
			//redirect('/admin/board/main');
			//redirect('/admin/board/edits/'.$bo_code);
		}

		if( $this->input->post('submit') ) {

				//print_r($this->input->post());
				//exit;


				// # [2017-03-22] 에러 메시지 CSS
				$this->form_validation->set_error_delimiters('<div class="error_board_admin">','</div>');

				$this->form_validation->set_rules('bo_title', '게시판 제목', 'trim|required|xss_clean');
				$this->form_validation->set_rules('gr_code', '게시판 그룹', 'trim|required|xss_clean');
				$this->form_validation->set_rules('bo_type', '게시판 유형', 'trim|required|xss_clean');
				$this->form_validation->set_rules('bo_width_limit', '게시판 너비', 'trim|required|xss_clean');
				$this->form_validation->set_rules('bo_width_max', '게시판 너비', 'trim|required|xss_clean');
				$this->form_validation->set_rules('bo_admin_fk', '게시판 관리자', 'trim|required|xss_clean');


				$this->form_validation->set_rules('bo_level_list', '목록 권한', 'trim|required');
				$this->form_validation->set_rules('bo_level_read', '보기 권한', 'trim|required');
				$this->form_validation->set_rules('bo_level_write', '쓰기 권한', 'trim|required');
				$this->form_validation->set_rules('bo_level_reply', '답글 권한', 'trim|required');
				$this->form_validation->set_rules('bo_level_comment', '코멘트 권한', 'trim|required');
				$this->form_validation->set_rules('bo_level_upload', '업로드 권한', 'trim|required');
				$this->form_validation->set_rules('bo_level_download', '다운로드 권한', 'trim|required');

				$this->form_validation->set_rules('bo_writer_type', '작성자명 설정', 'trim|required');
				$this->form_validation->set_rules('bo_use_secret', '비밀글 설정', 'trim|required');
				$this->form_validation->set_rules('bo_use_category', '카테고리 사용', 'trim|required');
				$this->form_validation->set_rules('bo_category', '카테고리 내용', '');

				$this->form_validation->set_rules('bo_use_new', 'NEW 아이콘', 'trim|required');
				$this->form_validation->set_rules('bo_new_condition', 'NEW 아이콘 설정 시간', '');
				$this->form_validation->set_rules('bo_use_hot', 'HOT 아이콘', 'trim|required');
				$this->form_validation->set_rules('bo_hot_condition', 'HOT 아이콘 설정 기준', '');
				$this->form_validation->set_rules('bo_use_staff', '관리자 체크', 'trim|required');
				$this->form_validation->set_rules('bo_use_comment', '코멘트 사용 설정', 'trim|required');

				$this->form_validation->set_rules('bo_notice_limit', '', '');
				$this->form_validation->set_rules('bo_notice_type', '', '');
				$this->form_validation->set_rules('bo_page_limit', '페이지당 게시물 수', 'trim|required');

				$this->form_validation->set_rules('bo_use_editor', '에디터 사용', 'trim|required');
				$this->form_validation->set_rules('bo_editor_type', '에디터 종류', 'trim|required');
				
				$this->form_validation->set_rules('bo_use_upload', '첨부파일 사용', 'trim|required');
				$this->form_validation->set_rules('bo_upload_cnt', '첨부파일 업로드 개수', '');
				$this->form_validation->set_rules('bo_upload_size', '첨부파일 크기 제한', '');
				$this->form_validation->set_rules('bo_use_link', '링크 사용', 'trim|required');
				$this->form_validation->set_rules('bo_init_content', '초기 내용 세팅', '');

				$this->form_validation->set_rules('bo_file_position', '첨부파일 노출 위치', 'trim|required');
				//$this->form_validation->set_rules('bo_file_image_display', '첨부파일 이미지 표시', 'trim|required');
				//$this->form_validation->set_rules('bo_image_width', '첨부파일 이미지 리사이즈', 'trim|required');

				$this->form_validation->set_rules('bo_head', '상단 디자인', '');
				$this->form_validation->set_rules('bo_tail', '하단 디자인', '');

				$this->form_validation->set_rules('arrfld_1_ttl', '배열1 제목', '');
				$this->form_validation->set_rules('arrfld_1', '배열1', '');
				$this->form_validation->set_rules('arrfld_2_ttl', '배열2 제목', '');
				$this->form_validation->set_rules('arrfld_2', '배열2', '');

				if ($this->form_validation->run()) {	// validation ok

					//print_r($this->input->post());
					//exit;

					if (!is_null($data = $this->board_lib->edit_board($bo_code))) {		// success
						sess_message('게시판 정보가 수정되었습니다.');
						redirect(current_url());
					} else {
						$errors = $this->tank_auth->get_error_message();
						foreach ($errors as $k => $v)	$data['errors'][$k] = $this->lang->line($v);
					}
				}

		}



		// 게시판 정보
			//$row = $this->basic_model->get_common_row($get_type='row',$fields='*','board_config',FALSE,FALSE,FALSE,array('bo_code'=>$bo_code),FALSE,FALSE,FALSE);
			$arr = array(
					'sql_select'     => '*',
					'sql_from'       => 'board_config',
					'sql_where'      => array('bo_code'=>$bo_code)
			);
			$row = $this->basic_model->arr_get_row($arr);

		// 그룹 리스트
			//$gr_result = $this->basic_model->get_common_result ('result','board_group','*',FALSE,FALSE,'left outer', array('idx >'=>'0'),FALSE,FALSE,'both',FALSE,'gr_title','asc',FALSE,0);
			$arr = array(
					'sql_select'     => '*',
					'sql_from'       => 'board_group',
					'sql_where'      => array('idx >'=>'0'),
					'sql_order_by'   => 'gr_title ASC'
			);
			$gr_result = $this->basic_model->arr_get_result($arr);




		// 게시판 관리자 리스트(회원 목록)
			//$admin_result = $this->basic_model->get_common_result ('result','users_admin','*',FALSE,FALSE,'left outer', array('id >'=>'0','is_sadmin'=>'-1'),FALSE,FALSE,'both',FALSE,'nickname','asc',FALSE,0);
			$arr = array(
					'sql_select'     => '*',
					'sql_from'       => 'users_admin',
					'sql_where'      => array('id >'=>'0','is_sadmin'=>'0'),
					'sql_order_by'   => 'nickname ASC'
			);
			$admin_result = $this->basic_model->arr_get_result($arr);



		// 게시판 스킨 불러오기
			$arr_bbskin = array();
			$bbs_skin_dir = APPPATH.'views/board/';
			$bbs_skin_files = scandir($bbs_skin_dir); 
			foreach($bbs_skin_files as $file)
			{
				if(is_file($bbs_skin_dir.$file)){
					//echo $file.'<<<<br />';

					$tmp_arr = explode('_',$file);
					if( isset($tmp_arr[0]) && '' != $tmp_arr[0] ){
						if(! in_array($tmp_arr[0], $arr_bbskin)) {
							$arr_bbskin[$tmp_arr[0]] = $tmp_arr[0];
						}
					}
				}
			}



		// 서버의  upload_max_size 
			$upload_max_size = ini_get('upload_max_filesize');
			$row->upload_max_size = $upload_max_size;


		// Get data.
			$breadcrumb = array(
				'게시판'=>base_url().'admin/board/main',
				'수정'=>''
			);

			$data = array(
				'level_result'  => $this->level_result['qry'],
				'row'  => $row,
				'gr_result'  => $gr_result,
				'arr_bbskin' => $arr_bbskin,
				'admin_result'  => $admin_result,
				'boards_result' => $this->boards_result,
				'arr_seg'   => $this->arr_seg, //$this->uri->segment_array(),
				'breadcrumb'    => $breadcrumb,
				'viewPage'  => 'admin/board_edit_view'
			);

			$this->load->view('admin/layout_view', $data);
	}




	// 기본 관리자 admin 전용
	function edits($bo_code=FALSE)
	{

		if(! $bo_code) {
			alert('게시판이 선택되지 않았습니다.');
		}

		if( $this->input->post('submit') ) {

				// # [2017-03-22] 에러 메시지 CSS
				$this->form_validation->set_error_delimiters('<div class="error_board_admin">','</div>');


				$this->form_validation->set_rules('bo_title', '게시판 제목', 'trim|required|xss_clean');
				$this->form_validation->set_rules('gr_code', '게시판 그룹', 'trim|required|xss_clean');
				//$this->form_validation->set_rules('bo_type', '게시판 유형', 'trim|required|xss_clean');
				//$this->form_validation->set_rules('bo_width_limit', '게시판 너비', 'trim|required|xss_clean');
				//$this->form_validation->set_rules('bo_width_max', '게시판 너비', 'trim|required|xss_clean');
				//$this->form_validation->set_rules('bo_admin_fk', '게시판 관리자', 'trim|required|xss_clean');


				$this->form_validation->set_rules('bo_level_list', '목록 권한', 'trim|required');
				$this->form_validation->set_rules('bo_level_read', '보기 권한', 'trim|required');
				$this->form_validation->set_rules('bo_level_write', '쓰기 권한', 'trim|required');
				$this->form_validation->set_rules('bo_level_reply', '답글 권한', 'trim|required');
				//$this->form_validation->set_rules('bo_level_comment', '코멘트 권한', 'trim|required');
				//$this->form_validation->set_rules('bo_level_upload', '업로드 권한', 'trim|required');
				//$this->form_validation->set_rules('bo_level_download', '다운로드 권한', 'trim|required');

				/*
				$this->form_validation->set_rules('bo_writer_type', '작성자명 설정', 'trim|required');
				$this->form_validation->set_rules('bo_use_secret', '비밀글 설정', 'trim|required');
				$this->form_validation->set_rules('bo_use_category', '카테고리 사용', 'trim|required');
				$this->form_validation->set_rules('bo_category', '카테고리 내용', '');

				$this->form_validation->set_rules('bo_use_new', 'NEW 아이콘', 'trim|required');
				$this->form_validation->set_rules('bo_new_condition', 'NEW 아이콘 설정 시간', '');
				$this->form_validation->set_rules('bo_use_hot', 'HOT 아이콘', 'trim|required');
				$this->form_validation->set_rules('bo_hot_condition', 'HOT 아이콘 설정 기준', '');
				$this->form_validation->set_rules('bo_use_staff', '관리자 체크', 'trim|required');
				$this->form_validation->set_rules('bo_use_comment', '코멘트 사용 설정', 'trim|required');
				*/

				//$this->form_validation->set_rules('bo_notice_limit', '', '');
				//$this->form_validation->set_rules('bo_notice_type', '', '');
				$this->form_validation->set_rules('bo_page_limit', '페이지당 게시물 수', 'trim|required');

				//$this->form_validation->set_rules('bo_use_editor', '에디터 사용', 'trim|required');
				$this->form_validation->set_rules('bo_use_upload', '첨부파일 사용', 'trim|required');
				$this->form_validation->set_rules('bo_upload_cnt', '첨부파일 업로드 개수', '');
				$this->form_validation->set_rules('bo_upload_size', '첨부파일 크기 제한', '');
				//$this->form_validation->set_rules('bo_use_link', '링크 사용', 'trim|required');
				//$this->form_validation->set_rules('bo_init_content', '초기 내용 세팅', '');

				/*
				$this->form_validation->set_rules('bo_file_position', '첨부파일 노출 위치', 'trim|required');
				$this->form_validation->set_rules('bo_file_image_display', '첨부파일 이미지 표시', 'trim|required');
				$this->form_validation->set_rules('bo_image_width', '첨부파일 이미지 리사이즈', 'trim|required');

				$this->form_validation->set_rules('bo_head', '상단 디자인', '');
				$this->form_validation->set_rules('bo_tail', '하단 디자인', '');
				*/

				if ($this->form_validation->run()) {	// validation ok

					//print_r($this->input->post());
					//exit;

					if (!is_null($data = $this->board_lib->edit_board_brief($bo_code))) {		// success
						sess_message('게시판 정보가 수정되었습니다.');
						redirect(current_url());
					} else {
						$errors = $this->tank_auth->get_error_message();
						foreach ($errors as $k => $v)	$data['errors'][$k] = $this->lang->line($v);
					}
				}

		}


		// 게시판 정보
			//$row = $this->basic_model->get_common_row($get_type='row',$fields='*','board_config',FALSE,FALSE,FALSE,array('bo_code'=>$bo_code),FALSE,FALSE,FALSE);
			$arr = array(
					'sql_select'     => '*',
					'sql_from'       => 'board_config',
					'sql_where'      => array('bo_code'=>$bo_code)
			);
			$row = $this->basic_model->arr_get_row($arr);

		// 그룹 리스트
			//$gr_result = $this->basic_model->get_common_result ('result','board_group','*',FALSE,FALSE,'left outer', array('idx >'=>'0'),FALSE,FALSE,'both',FALSE,'gr_title','asc',FALSE,0);
			$arr = array(
					'sql_select'     => '*',
					'sql_from'       => 'board_group',
					'sql_where'      => array('idx >'=>'0'),
					'sql_order_by'   => 'gr_title ASC'
			);
			$gr_result = $this->basic_model->arr_get_result($arr);




		// 게시판 관리자 리스트(회원 목록)
			//$admin_result = $this->basic_model->get_common_result ('result','users_admin','*',FALSE,FALSE,'left outer', array('id >'=>'0','is_sadmin'=>'-1'),FALSE,FALSE,'both',FALSE,'nickname','asc',FALSE,0);
			$arr = array(
					'sql_select'     => '*',
					'sql_from'       => 'users_admin',
					'sql_where'      => array('id >'=>'0','is_sadmin'=>'0'),
					'sql_order_by'   => 'nickname ASC'
			);
			$admin_result = $this->basic_model->arr_get_result($arr);



		// 게시판 스킨 불러오기
		$arr_bbskin = array();
		$bbs_skin_dir = APPPATH.'views/board/';
		$bbs_skin_files = scandir($bbs_skin_dir); 
		foreach($bbs_skin_files as $file)
		{
			if(is_file($bbs_skin_dir.$file)){
				//echo $file.'<<<<br />';

				$tmp_arr = explode('_',$file);
				if( isset($tmp_arr[0]) && '' != $tmp_arr[0] ){
					if(! in_array($tmp_arr[0], $arr_bbskin)) {
						$arr_bbskin[$tmp_arr[0]] = $tmp_arr[0];
					}
				}
			}
		}


		// Get data.
			$breadcrumb = array(
				'게시판'=>base_url().'admin/board/main',
				'수정'=>''
			);

			$data = array(
				'row'  => $row,
				'gr_result'  => $gr_result,
				'arr_bbskin' => $arr_bbskin,
				'admin_result'  => $admin_result,
				'boards_result' => $this->boards_result,
				'arr_seg'   => $this->arr_seg, //$this->uri->segment_array(),
				'breadcrumb'    => $breadcrumb,
				'viewPage'  => 'admin/board_edits_view'
			);

			$this->load->view('admin/layout_view', $data);
	}






	function board_del($bo_code=FALSE)
	{
		// 마스터 관리자가 아니면 redirect
		if('sadmin' !== $this->username){
			redirect('/admin/board/');
		}

		// 게시판 그룹 정보를 완전히 삭제
		if($this->board_lib->delete_board($bo_code)) {
			alert('게시판이 삭제되었습니다.',base_url().'admin/board/lists');
		}
		else {
			alert('게시판이 삭제되지 않았습니다. 다시 한 번 확인해주세요.','admin/board/lists');
		}
	}
















	/*
	* basic.openuri.net/B/7PQI9/
	*/
	function bbs($bo_code=FALSE)
	{


		$this->bbs_code_url = '/admin/board/bbs/'.$bo_code;

		$bo_style = $this->uri->segment(5, 'lists');
		if(! $bo_style)
			redirect($this->bbs_url_pre .'/lists/');

		$wr_idx = $this->uri->segment(6, FALSE);
		$page_ttl = $this->uri->segment(7, 'page');
		$page = $this->uri->segment(8, 1);







		// 게시판 설정파일 - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		$arr = array('sql_select' => '*','sql_from' => 'board_config','sql_where' => array('bo_code'=>$bo_code));
		$this->bbs_cf = $this->basic_model->arr_get_row($arr);

		if( ! isset($this->bbs_cf->bo_code)) {
			alert('준비중이거나 존재하지 않는 페이지입니다.');
		}

		// 로그인 회원 정보 - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		//$this->user = $this->tank_auth->get_userinfo($this->tank_auth->get_username());
		$user_level = isset($this->user->level) ? $this->user->level : 1; // 1 이면 비회원
		if( $this->tank_auth->is_admin() ) {
			$user_level = 100;
		}

		//echo $user_level .' < '. $this->bbs_cf->bo_level_list;  // 1 < 1
		//exit;

		switch ($bo_style) {
			case 'lists':
				if( $user_level < $this->bbs_cf->bo_level_list ) :
					//alert('권한이 없습니다.');
					if($this->tank_auth->is_logged_in()):
						// 목록 보기 권한이 안될 경우, 쓰기 페이지 권한 체크하여 이동
						if( $user_level >= $this->bbs_cf->bo_level_write ) :
							$redirect_url = $this->bbs_code_url .'/write/';
							redirect($redirect_url);
						else :
							// 이전 페이지로 이동
							history_back();
						endif;

					elseif($bo_code == 'form'):
						// 제휴문의 게시판일 경우만..
						$redirect_url = $this->bbs_code_url .'/write/';
						redirect($redirect_url);

					else : 
						redirect('/auth/login/'. url_code($this->uri->uri_string(), 'e'));
					endif;

				endif;
				$this->_bbs_lists($bo_code);
			break;
			case 'request':
				if (! $this->tank_auth->is_admin()) :
					//alert('권한이 없습니다.');
					redirect('/auth/login/'. url_code($this->uri->uri_string(), 'e'));
				endif;
				$this->_bbs_request($bo_code);
			break;

			case 'result':

				$tmp_rtime = $this->session->userdata('tmp_result_time', time());
				$now = ((float)$usec + (float)$sec);
				if ($now - $tmp_rtime < 180) {
					$this->_bbs_result($bo_code,$wr_idx,$page_ttl,$page);
				}
				else {

					// 목록 보기 권한이 안될 경우, 쓰기 페이지 권한 체크하여 이동
					if( $user_level >= $this->bbs_cf->bo_level_read ) :
						$redirect_url = $this->bbs_code_url .'/detail/'.$wr_idx;
					elseif( $user_level >= $this->bbs_cf->bo_level_list ) :
						$redirect_url = $this->bbs_code_url .'/lists/';
					elseif( $user_level >= $this->bbs_cf->bo_level_write ) :
						$redirect_url = $this->bbs_code_url .'/write/';
					else :
						$redirect_url = '/';
					endif;

					if($page && $redirect_url != '/') {
						$redirect_url .= 'page/'.$page;
					}

					redirect($redirect_url);

				}

			break;

			case 'detail':
				// 기본 권한
				//alert($user_level .' < '. $this->bbs_cf->bo_level_read);
				if( $user_level < $this->bbs_cf->bo_level_read ) :
					//alert('권한이 없습니다.');
					/*
					$redirect_url = $this->bbs_code_url .'/lists/';
					if($page) {
						$redirect_url .= 'page/'.$page;
					}
					*/

					// 이전 페이지 체크
					$str_refer = str_replace(array('http://','https://'),array('',''),$_SERVER['HTTP_REFERER']);
					$tmp_refer = explode('?',$str_refer);
					$arr_refer = explode('/',$tmp_refer[0]);
					//print_r($arr_refer);
					//exit;
					/*
						Array ( 
							[0] => canta.soi9works.com
							[1] => board 
							[2] => reserve  
							[3] => lists 
							[4] => page [5] =>  )
					*/
					/*
							echo $user_level.'<<<br />';
							echo $this->bbs_cf->bo_level_list.'<<<br />';
							echo $this->bbs_cf->bo_level_write.'<<<br />';
							exit;
					*/

					if(isset($arr_refer[1]) && 'board' == $arr_refer[1]) {
						if(isset($arr_refer[3]) && 'detail' == $arr_refer[3]) {

							// 목록 보기 권한이 안될 경우, 쓰기 페이지 권한 체크하여 이동
							if( $user_level >= $this->bbs_cf->bo_level_list ) :
								$redirect_url = $this->bbs_code_url .'/lists/';
							elseif( $user_level >= $this->bbs_cf->bo_level_write ) :
								$redirect_url = $this->bbs_code_url .'/write/';
							endif;
							if($page) {
								$redirect_url .= 'page/'.$page;
							}

							redirect($redirect_url);
						}
						elseif(isset($arr_refer[3]) && 'lists' == $arr_refer[3]) {

							// 목록 보기 권한이 안될 경우, 쓰기 페이지 권한 체크하여 이동
							if( $user_level >= $this->bbs_cf->bo_level_list ) :
								$redirect_url = $this->bbs_code_url .'/lists/';
							elseif( $user_level >= $this->bbs_cf->bo_level_write ) :
								$redirect_url = $this->bbs_code_url .'/write/';
							endif;
							if($page) {
								$redirect_url .= 'page/'.$page;
							}

							redirect($redirect_url);
						}
					}

					$redirect_url = 'auth/login/'. url_code($this->uri->uri_string(), 'e');
					//alert('로그인이 필요한 페이지입니다.',$redirect_url);
					redirect($redirect_url);

				endif;
				$this->_bbs_detail($bo_code,$wr_idx,$page_ttl,$page);
			break;
			case 'write':
				if( $user_level < $this->bbs_cf->bo_level_write   &&   ! $this->tank_auth->is_admin()) :
					//alert('권한이 없습니다.');

					// 쓰기 페이지에서 로그아웃 시에는 목록으로 이동
					//redirect($this->bbs_code_url .'/lists/');
					//$redirect_url = $this->bbs_code_url .'/lists/';
					$redirect_url = '/auth/login/'. url_code($this->uri->uri_string(), 'e');

					if($page) {
						$redirect_url .= 'page/'.$page;
					}
					redirect($redirect_url);

				endif;
				$this->_bbs_write($bo_code,$wr_idx,$page_ttl,$page);
			break;
			case 'reply':
				if( $user_level < $this->bbs_cf->bo_level_reply ) :
					//alert('권한이 없습니다.');
					//redirect('/auth/login/'. url_code($this->uri->uri_string(), 'e'));

					// 쓰기 페이지에서 로그아웃 시에는 목록으로 이동
					redirect($this->bbs_code_url .'/lists/');
				endif;
				//$this->_bbs_reply($bo_code,$wr_idx,$page_ttl,$page);
				$this->_bbs_write($bo_code,$wr_idx,$page_ttl,$page,'reply');
			break;
			case 'delete':
				$this->_bbs_delete($bo_code,$wr_idx,$page_ttl,$page);
			break;
			/*
			case 'editor':
                $css_skin = 'swfupload';
                $bo_field = '*';
            break;
			*/
			case 'password':
				$bo_field = '*';
				$this->_bbs_password($bo_code,$wr_idx,$page_ttl,$page);
			break;
			/*
			case 'download':
				$bo_field = '*';
			break;
            case 'rss':
                $bo_field = '*';
            break;
			*/
			default:
				alert('잘못된 접근입니다.', '/');
			break;
		}

	}







	// 게시글 목록
	function _bbs_lists($bo_code)
	{

			// 게시판 정보 테이블
			$bo_table = BBS_PRE.$bo_code;

			// 게시판 설정파일
			$arr = array('sql_select' => '*','sql_from' => 'board_config','sql_where' => array('bo_code'=>$bo_code));
			$bbs_cf = $this->basic_model->arr_get_row($arr);

			// 게시판별 카테고리 정보
			$arr_bo_cate = ('' != $bbs_cf->bo_category) ? explode(',',str_replace(' ','',$bbs_cf->bo_category)) : array();
			$cnt_bo_cate = count($arr_bo_cate);

			// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
			// 페이징 정보 
			// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
			$this->load->library('segment', array('offset'=>6), 'seg'); // 세그먼트 주소( page 위치 )
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
				// 휴대전화 검색인 경우
				if(isset($sfl) && 'phone' == $sfl) {
					$stx = trim(str_replace('-','',$stx));
				}
				$qstr .= ('' == $qstr) ? '?' : '&';
				$qstr .= 'stx='.$stx;
			}

			// 정렬
			//if($ofl = $param->get('ofl','ORD DESC, wr_datetime DESC, wr_reply ASC')) { // order_field
			if($ofl = $param->get('ofl','')) { // order_field
				$qstr .= ('' == $qstr) ? '?' : '&';
				//$qstr .= 'ofl='.$ofl;
				$qstr .= ($ofl != '') ? 'ofl='.$ofl : '';
			}


			// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
			//비밀글 세션 초기화 (목록에서 클릭할 때마다 비번 입력창 뜨도록)
			// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
			$ss_password_name = 'ss_bbs_password';
			$this->session->set_userdata($ss_password_name, FALSE);


			// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
			// sql 
			// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
			$sql_select = '*';
			$sql_from = $bo_table;
			$sql_where = array('wr_idx >' => 0);
			$sql_group_by = FALSE;
			$sql_order_by = (isset($ofl) && '' != $ofl) ? $ofl : 'ORD DESC, wr_datetime DESC, wr_reply ASC';

			// 페이징
			$limit = $bbs_cf->bo_page_limit; //'20';
			$page  = $seg->get('page', 1); // 페이지
			if(! isset($page) OR empty($page)) {
				$page = '1';
			}
			$offset = ($page - 1) * $limit;

			// 검색
			$like_field = $sfl;                         // search
			$like_match = $stx;
			$like_side = 'both';
			// 조인
			$sql_join_tbl = FALSE;
			$sql_join_on = FALSE;
			$sql_join_option = 'LEFT OUTER';

			// 검색 상관없는 전체 수
			$total_count_all = $this->basic_model->get_common_count($sql_from,$sql_where);

			// 카테고리 메뉴 사용시
			$cate_menu = $param->get('cate', false);
			if( $cate_menu && 'all' != $cate_menu) {
				$sql_where['ca_code'] = $cate_menu;
			}

			// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
			// 관리자라면 모두 볼 수 있고, 아니면..
			// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
			if (! $this->tank_auth->is_admin()) {			// not logged in or activated

				// 회원이라면 VIEW 값이 'Y' 인 것만 볼 수 있게.
				$sql_where['VIEW'] = 'Y';

				// APP (승인/미승인)
				$sql_where['APP'] = 'Y';
			}

			$arr = array(
					'sql_select'       => $sql_select,
					'sql_from'         => $sql_from,
					'sql_join_tbl'     => $sql_join_tbl,
					'sql_join_on'      => $sql_join_on,
					'sql_join_option'  => $sql_join_option,
					'like_field'       => $like_field,
					'like_match'       => $like_match,
					'like_side'        => $like_side,
					'sql_where'        => $sql_where,
					'sql_group_by'     => $sql_group_by,
					'sql_order_by'     => $sql_order_by,
					'page'             => $page,
					'limit'            => $limit,
					'offset'           => $offset,
			);
			$result = $this->basic_model->arr_get_result($arr);

			//echo $this->db->last_query();
			//echo '<br />';
			//echo $sql_order_by;





			//$arr_bo_cate_cnt = false;
			//$total_cnt = $this->basic_model->get_common_count($bo_table, array('del_yn' => 'N'));
			//$arr_bo_cate_cnt = array('all'=>$total_cnt);















			$this->load->helper('resize');
			foreach($result['qry'] as $i => $row) {

				$썸네일이미지_src = '';

					$thumb_img_blank = "blank_image_list.png";
					//$thumb_img_blank = "blank_image_w600h400.png";
					//$thumb_img_blank = "blank_img_rand_".rand(1,12).".jpg";


					// 썸네일 이미지 처리
					$thumb_img = '<img src="'.IMG_DIR.'/common/'.$thumb_img_blank.'" style="width:100%" />';
					$thumb_src = IMG_DIR.'/common/'.$thumb_img_blank;
					$tag_photo = '';

					$thumb_img_crop = '<img src="'.IMG_DIR.'/common/'.$thumb_img_blank.'" style="width:100%" />';
					$thumb_src_crop = IMG_DIR.'/common/'.$thumb_img_blank;
					$tag_photo_crop = '';

					// 실제 이미지
					$raw_img_src = false;
					$raw_img_path = false;

					$썸네일이미지_src = false;
					$썸네일이미지_path = false;

					$크롭이미지_src = false;

					// 댓글(코멘트) 수량
					$total_cnt_cmt = false;

					

					if($row->wr_idx)
					{

						/*
						if('myestimate' == $bo_code ) {
							$result['qry'][$i]->wr_name = $row->wr_name;
						}
						*/
						$result['qry'][$i]->wr_name_estimate = $row->wr_name;



						//  list 이미지 (첫 번째 업로드 이미지)
						$썸네일이미지_path = '';
						$썸네일이미지_src = '';
						$크롭이미지_src = '';

						//$file_row = $this->basic_model->get_common_row('row','*','file_manager',FALSE,FALSE,FALSE,array('wr_table'=>$bo_code, 'wr_table_idx'=>$row->wr_idx, 'upload_type' => 'form', 'file_type'=>'image','gubun'=>'list'),FALSE,'idx desc',1);

						// 선택한 글 정보
						$arr = array(
								'sql_select'     => '*',
								'sql_from'       => 'file_manager',
								//'sql_where'      => array('wr_table'=>$bo_code, 'wr_table_idx'=>$row->wr_idx, 'upload_type' => 'form', 'file_type'=>'image','gubun'=>'list'),
								'sql_where'      => array('wr_table'=>$bo_code, 'wr_table_idx'=>$row->wr_idx, 'upload_type' => 'form', 'file_type'=>'image'),
								'sql_order_by'   => 'idx DESC',
								'limit'            => 1
						);
						$file_row = $this->basic_model->arr_get_row($arr);



						/*
						print_r($file_row);
						echo '<hr />';
						echo $this->db->last_query();
						echo '<hr />';
						exit;
						*/

						//if(! empty($file_row)  &&  $file_row->upload_type === 'editor'  &&   $file_row->upload_gubun !== 'file') {
						if(! empty($file_row)) {

							// 실제 이미지
							//$raw_img_src = '/data/'.$file_row->file_dir.'/'.$file_row->file_name;
							$raw_img_src = DATA_DIR.'/'.$file_row->file_dir.'/'.$file_row->file_name;
							$raw_img_path = DATA_PATH.'/'.$file_row->file_dir.'/'.$file_row->file_name;

							$썸네일이미지_src = $raw_img_src;
							$썸네일이미지_path = $raw_img_path;

							/*
							// 원본 이미지
							if('event' == $bo_code || 'review_succ' == $bo_code) {
								$썸네일이미지_src = $raw_img_src;
							}
							else {
								
								// $thumb_src = resize_thumb_image($file_row->file_name, $file_row->file_dir, $file_row->file_dir.'/thumb', '800','600',false,'width','src');
								// $썸네일이미지_src = $thumb_src;
								// $thumb_src_crop = resize_thumb_image_crop($file_row->file_name, $file_row->file_dir, $file_row->file_dir.'/thumb', '800','600',true,'auto','src','800','600', 0,0);
								// $크롭이미지_src = $thumb_src_crop;
								// $썸네일이미지_src = $raw_img_src;
							}
							*/
						}

						//  banner 이미지 (두 번째 업로드 이미지)
						$썸네일이미지_src_banner = '';
						$크롭이미지_src_banner = '';
						//$file_row_bnr = $this->basic_model->get_common_row('row','*','file_manager',FALSE,FALSE,FALSE,array('wr_table'=>$bo_code, 'wr_table_idx'=>$row->wr_idx, 'upload_type' => 'form', 'file_type'=>'image','gubun'=>'banner'),FALSE,'idx desc',1);


						// 선택한 글 정보
						$arr = array(
								'sql_select'     => '*',
								'sql_from'       => 'file_manager',
								'sql_where'      => array('wr_table'=>$bo_code, 'wr_table_idx'=>$row->wr_idx, 'upload_type' => 'form', 'file_type'=>'image','gubun'=>'banner'),
								//'sql_where'      => array('wr_table'=>$bo_code, 'wr_table_idx'=>$row->wr_idx, 'upload_type' => 'form', 'file_type'=>'image'),
								'sql_order_by'   => 'idx DESC',
								'limit'            => 1
						);
						$file_row_bnr = $this->basic_model->arr_get_row($arr);
						//echo $this->db->last_query();
						//exit;
						//print_r($file_row_bnr);
						//exit;


						if(! empty($file_row_bnr)) {
							// 실제 이미지
							$raw_img_src = '/data/'.$file_row_bnr->file_dir.'/'.$file_row_bnr->file_name;
							$thumb_src = resize_thumb_image($file_row_bnr->file_name, $file_row_bnr->file_dir, $file_row_bnr->file_dir.'/thumb', '800','600',false,'width','src');
							//echo $thumb_src.'<<<<<<<<br />';
							//exit;
							$썸네일이미지_src_banner = $thumb_src;
							$thumb_src_crop = resize_thumb_image_crop($file_row_bnr->file_name, $file_row_bnr->file_dir, $file_row_bnr->file_dir.'/thumb', '800','600',true,'auto','src','800','600', 0,0);
							$크롭이미지_src_banner = $thumb_src_crop;
						}





						// 기존 사이트 이미지
						if(! isset($file_row->file_name)) {

							if('event' == $bo_code) {
								if(isset($row->bo_file3) && '' != $row->bo_file3) {
									$썸네일이미지_src = '/data/file/community_02/'.$row->bo_file3;
									$썸네일이미지_src_banner = $썸네일이미지_src;
								}
								elseif(isset($row->bo_file2) && '' != $row->bo_file2) {
									$썸네일이미지_src = '/data/file/community_02/'.$row->bo_file2;
									$썸네일이미지_src_banner = $썸네일이미지_src;
								}
							}
							else if('review_succ' == $bo_code) {
								if(isset($row->bo_file1) && '' != $row->bo_file1) {
									$썸네일이미지_src = '/data/file/review_01/'.$row->bo_file1;
									$썸네일이미지_src_banner = $썸네일이미지_src;
								}
								elseif(isset($row->bo_file2) && '' != $row->bo_file2) {
									$썸네일이미지_src = '/data/file/review_01/'.$row->bo_file2;
									$썸네일이미지_src_banner = $썸네일이미지_src;
								}
							}
						}


						// 구 홈페이지에서 가져온 이미지가 있는 경우.. 
						if('' == $썸네일이미지_src  &&  isset($file_row->file_dir)  &&  $file_row->file_dir = '/upload/board/') {
							//$썸네일이미지_src = '/upload/board/'.$file_row->file_name;
							//echo $썸네일이미지_src;
							//exit;
						}


						// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
						// 코멘트(답변 글) 수 가져오기
						// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
						$sql_from_cmt='board_comment';
						$sql_where_cmt = "bo_code='".$bo_code."'  AND  wr_idx=". $row->wr_idx ." AND del_yn='N'";

						// 전체 수
						$total_cnt_cmt = $this->basic_model->get_common_count($sql_from_cmt, $sql_where_cmt);


					}

					$result['qry'][$i]->total_cnt_cmt = $total_cnt_cmt;







					// [list] 그래도 썸네일 이미지가 없으면, 기본 디폴트 이미지
					if('' == $썸네일이미지_src) {
						$썸네일이미지_src = IMG_DIR.'/common/'.$thumb_img_blank;
						$썸네일이미지_path = IMG_PATH.'/common/'.$thumb_img_blank;
					}


					// 썸네일 이미지 가로 세로 사이즈 비교
					//echo $썸네일이미지_path.'<<<<<<<<<<<<<br />';
					$img_getsize = @getimagesize($썸네일이미지_path);
					//print_r($img_size);
					//exit;

					$getsize_w = 0;
					$getsize_h = 0;
					if( isset($img_getsize[0]) && isset($img_getsize[1]) ) {
						$getsize_w = $img_getsize[0];
						$getsize_h = $img_getsize[1];
					}

					$css_bgsize = '';
					if($getsize_w > $getsize_h) {
						$css_bgsize = 'background-size: 90% auto;';
					}
					else if($getsize_w <= $getsize_h) {
						$css_bgsize = 'background-size: auto 90%;';
					}

					$result['qry'][$i]->css_bgsize = $css_bgsize; // 기존 디비에 등록된 이미지












					// [list] 그래도 썸네일 이미지가 없으면, 기본 디폴트 이미지
					if('' == $썸네일이미지_src) {
						$썸네일이미지_src = IMG_DIR.'/common/'.$thumb_img_blank;
					}

					//$img_src = '/data/'.$file_row->file_dir.'/'.$file_row->file_name;
					$result['qry'][$i]->raw_img_src = $raw_img_src; // 기존 디비에 등록된 이미지

					$result['qry'][$i]->resize_thumb_src = $썸네일이미지_src;
					$result['qry'][$i]->resize_crop_src = $크롭이미지_src;


					// [banner] 그래도 썸네일 이미지가 없으면, 기본 디폴트 이미지
					if('' == $썸네일이미지_src_banner) {
						$썸네일이미지_src_banner = IMG_DIR.'/common/'.$thumb_img_blank;
					}
					$result['qry'][$i]->resize_thumb_src_banner = $썸네일이미지_src_banner;
					$result['qry'][$i]->resize_crop_src_banner = $크롭이미지_src_banner;



					$result['qry'][$i]->wr_name_input = $row->wr_name;

					// 작성자 정보
					if( isset($row->user_idx) ) {
						$user_table = ($row->user_idx < 1000) ? 'users_admin' : 'users';
						//$uacc = $this->basic_model->get_common_row('row','username,nickname',$user_table,FALSE,FALSE,FALSE,array('id'=>$row->user_idx));

						// 선택한 글 정보
						$arr = array(
								'sql_select'     => 'username,nickname',
								'sql_from'       => $user_table,
								'sql_where'      => array('id'=>$row->user_idx)
						);
						$uacc = $this->basic_model->arr_get_row($arr);



						if(isset($uacc->username)) {
							$result['qry'][$i]->wr_name = $uacc->nickname;
							$result['qry'][$i]->wr_username = $uacc->username;
						}
					}


					// 컨텐츠 텍스트만 컷
					$result['qry'][$i]->wr_content_cut = cut_str(remove_tags($row->wr_content),160);
					$result['qry'][$i]->wr_content_text = remove_tags($row->wr_content);
					$result['qry'][$i]->wr_content = $row->wr_content;

					$result['qry'][$i]->wr_subject = (strpos($like_field, 'subject')) ? search_font($row->wr_subject, $like_match) : $row->wr_subject;


					$tag_video = get_video_tag($row->wr_content,'800px','auto');
					if('' !== $tag_video) {
						$icon_bbs = 'video';
					}
					elseif('' !== $tag_photo) {
						$icon_bbs = 'photo';
					}
					else {
						$icon_bbs = 'text';
					}

					$result['qry'][$i]->icon_bbs = $icon_bbs;
					$result['qry'][$i]->tag_video = $tag_video;
					$result['qry'][$i]->tag_photo = $tag_photo;
					$result['qry'][$i]->tag_photo_crop = $tag_photo_crop;


					$result['qry'][$i]->wr_datetime_point = str_replace('-','. ',substr($row->wr_datetime,0,10));
					$result['qry'][$i]->wr_datetime_en = date("d F, Y", strtotime($row->wr_datetime));




					// 일반인 후기에서 작성자 명 가져오기
					//$wr_name_asta = cut_string($row->wr_name,0,1) .'*'. cut_string($row->wr_name,2,1,'');
					//$result['qry'][$i]->wr_name_asta = $wr_name_asta;

					$wr_name_asta = cut_string($row->wr_name,0,1) .'**';
					$result['qry'][$i]->wr_name_asta = $wr_name_asta;

					// 24시간 초과 여부 체크
					$chk24h = time() - strtotime($row->wr_datetime);
					$chk24h = (int) ($chk24h / (60*24));

					// new 아이콘 설정
					$bo_use_new_tag = '';
					if($chk24h < 24  &&  $bbs_cf->bo_use_new == 1) {
						//$bo_use_new_tag = '<img src="'. V20_DIR .'/img/new/icon_new.png" width="10" align="absmiddle" alt="새글">';
						//$bo_use_new_tag = '<span><i class="icon uil uil-asterisk color-primary"></i></span>';

						$bo_use_new_tag = '<span style="padding-left: 10px"><img src="/assets/img/icon_new.png" width="10" align="absmiddle" alt="새글"></span>';
					}
					$result['qry'][$i]->bo_use_new_tag = $bo_use_new_tag;
					//echo $chk24h.'/'.$chk24h/60/60;
					//echo '<br />';







					// 비밀번호 입력창 팝업
					$password_popup = "";
					if($row->opt_secret > 0){
						if(! $this->tank_auth->is_logged_in()  &&  $row->user_idx < 1) { // 비로그인 && 비로그인작성시 user_idx 값은 0

							// 비회원 비밀글
							$ss_password_name = 'ss_bbs_password';
							if (! $this->session->userdata($ss_password_name)) {
								//$this->session->set_userdata($ss_password_name, time());
								//redirect( $this->bbs_code_url .'/password/'.$wr_idx.'/'.$page_ttl.'/'.$page );
								$password_popup = ' onclick="set_action(\''.$bo_code.'\','.$row->wr_idx.','.$page.'); return false;" data-toggle="modal" data-target="#passModal"  ';

							}
							else {
								// 비번 입력하고 패스~
								$this->session->set_userdata($ss_password_name, FALSE);
							}

						}
						elseif((! $this->tank_auth->is_logged_in()) || ((isset($this->user->id) && ($this->user->id !== $row->user_idx)) && ! $this->tank_auth->is_admin()) ) {
							//alert('권한이 없습니다.');
							//exit;
						}
					}

					$result['qry'][$i]->password_popup = $password_popup;



					// 진행중/지난 이벤트 구분
					if('event' == $bo_code) {
						$end_date_event = $row->add_column_2;
						if($end_date_event < date('Y-m-d')) {
							//  지난이벤트
							$event_list['passed'][$i] = $result['qry'][$i];
						}
						else {
							// 진행중 이벤트
							$event_list['present'][$i] = $result['qry'][$i];
						}
					}
			}





			// pagination 설정
			$config['suffix']	   = $qstr; //$qstr;
			$config['base_url']    = $this->bbs_code_url .'/lists/page/';
			$config['per_page']    = $limit;
			$config['total_rows']  = $result['total_count'];
			$config['uri_segment'] = $seg->pos('page');  // 5

			if(IS_MOBILE) {
				$config['num_links'] = 1;
			}




			// 페이징 버튼
			$btn_prev_part = $btn_next_part = '';
			$config['full_tag_open']  = "<ul class='pagination'>".$btn_prev_part;
			$config['full_tag_close'] = $btn_next_part.'</ul>';

			// ▼▼▼ 권한 설정에 따른 버튼 노출  - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
			/*
			if( (isset($this->user->group_fk) ? $this->user->group_fk : 1) >= $bbs_cf->bo_level_write) {
				$btn_next_part = '<li class="page-item"><a class="page-link" href="'.$this->bbs_code_url.'/write/0/page/'.$page.'"><span aria-hidden="true"><i class="uil uil-edit-alt"></i></span></a></li>';
			}
			$config['full_tag_open']  = "<ul class='pagination pagination-sm justify-content-center'>".$btn_prev_part;
			$config['full_tag_close'] = $btn_next_part.'</ul>';
			*/

			if(IS_MOBILE) {
				$config['first_link'] = '<span aria-hidden="true">←</span>';
				$config['prev_link'] = '<span aria-hidden="true">&laquo;</span>';
				$config['next_link'] = '<span aria-hidden="true">&raquo;</span>';
				$config['last_link'] = '<span aria-hidden="true">→</span>';
			}
			else {
				$config['first_link'] = '<span aria-hidden="true">←</span>';
				$config['prev_link'] = '<span aria-hidden="true">&laquo;</span>';
				$config['next_link'] = '<span aria-hidden="true">&raquo;</span>';
				$config['last_link'] = '<span aria-hidden="true">→</span>';
			}


			$this->load->library('pagination', $config);

			$paging_html = $this->pagination->create_links();


			// 공지체크한 목록
			$sql_where_notice = "wr_idx IN (". $bbs_cf->bo_notice_idxs ."0)"; // <= 게시판 설정에 저장된 공지사항 인덱스만 검색. 마지막에 붙은 0은 끝에 붙은 콤마 처리용
			$arr = array(
					'sql_select'       => $sql_select,
					'sql_from'         => $sql_from,
					'sql_join_tbl'     => $sql_join_tbl,
					'sql_join_on'      => $sql_join_on,
					'sql_join_option'  => $sql_join_option,
					'like_field'       => $like_field,
					'like_match'       => $like_match,
					'like_side'        => $like_side,
					'sql_where'        => $sql_where_notice,
					'sql_group_by'     => $sql_group_by,
					'sql_order_by'     => $sql_order_by,
					'page'             => $page,
					'limit'            => $limit,
					'offset'           => $offset,
			);
			$result_notice = $this->basic_model->arr_get_result($arr);
			//echo $this->db->last_query();

			foreach($result_notice['qry'] as $i => $row) {

					// 썸네일 이미지 - - - - - - -  - - - - - - -  - - - - - - -  - - - - - - -  - - - - - - -  - - - - - - - 

					// 실제 이미지
					$raw_img_src = false;
					//  list 이미지 (첫 번째 업로드 이미지)
					$썸네일이미지_src = '';
					$크롭이미지_src = '';

					//$file_row = $this->basic_model->get_common_row('row','*','file_manager',FALSE,FALSE,FALSE,array('wr_table'=>$bo_code, 'wr_table_idx'=>$row->wr_idx, 'upload_type' => 'form', 'file_type'=>'image','gubun'=>'list'),FALSE,'idx desc',1);

					$arr = array('sql_select' =>'*','sql_from' =>'file_manager','sql_where' =>array('wr_table'=>$bo_code, 'wr_table_idx'=>$row->wr_idx, 'upload_type' => 'form', 'file_type'=>'image','gubun'=>'list'),'sql_order_by'=>'idx desc','limit'=>1);
					$file_row = $this->basic_model->arr_get_row($arr);

					if(! empty($file_row)) {
						// 실제 이미지
						$raw_img_src = '/data/'.$file_row->file_dir.'/'.$file_row->file_name;
						
						// 원본 이미지
						if('event' == $bo_code || 'review_succ' == $bo_code) {
							$썸네일이미지_src = $raw_img_src;
							$썸네일이미지_path = $raw_img_path;
						}
						else {
							$썸네일이미지_src = $raw_img_src;
							$썸네일이미지_path = $raw_img_path;
						}

					}

					$thumb_img_blank = "blank_image_list.png";
					if('' == $썸네일이미지_src) {
						$썸네일이미지_src = IMG_DIR.'/common/'.$thumb_img_blank;
					}
					$result_notice['qry'][$i]->raw_img_src = $raw_img_src; // 기존 디비에 등록된 이미지
					$result_notice['qry'][$i]->resize_thumb_src = $썸네일이미지_src;
					$result_notice['qry'][$i]->resize_crop_src = $크롭이미지_src;



					$wr_datetime_point = '';
					$wr_datetime_en = '';
					if( isset($row->wr_datetime) ) {
						$wr_datetime_point = str_replace('-','. ',substr($row->wr_datetime,0,10));
						$wr_datetime_en = date("d F, Y", strtotime($row->wr_datetime));
					}
					$result_notice['qry'][$i]->wr_datetime_point = $wr_datetime_point;
					$result_notice['qry'][$i]->wr_datetime_en = $wr_datetime_en;



					// 작성자 정보
					$user_table = ($row->user_idx < 1000) ? 'users_admin' : 'users';
					//$uacc = $this->basic_model->get_common_row('row','username,nickname',$user_table,FALSE,FALSE,FALSE,array('id'=>$row->user_idx));

					$arr = array(
							'sql_select'     => 'username,nickname',
							'sql_from'       => $user_table,
							'sql_where'      => array('id'=>$row->user_idx)
					);
					$uacc = $this->basic_model->arr_get_row($arr);

					$result_notice['qry'][$i]->wr_name_input = $row->wr_name;
					$result_notice['qry'][$i]->wr_name = isset($uacc->nickname) ? $uacc->nickname : $row->wr_name;
					$result_notice['qry'][$i]->wr_username = isset($uacc->username) ? $uacc->username : '';


					/*
					// 파일 다운로드
					if('data' == $bo_code) {

						$download_url = '#';

						// 업로드 파일
						$arr_where_data = array(
								'sql_select'     => '*',
								'sql_from'       => 'file_manager',
								'sql_where'      => array('wr_table' => $bo_code, 'wr_table_idx'=>$row->wr_idx, 'upload_type'=>'form' )
						);
						$row_file_data = $this->basic_model->arr_get_row($arr_where_data);
						if( isset($row_file_data->file_dir) ) {
							$download_url = '/files/download/'.url_code($row_file_data->file_dir,'e').'/'.$row_file_data->file_name.'/'.url_code($row_file_data->file_name_org,'e');
						}
						//echo $download_url;
						//exit;
						$result_notice['qry'][$i]->download_url = $download_url;
					}
					*/



					// 비밀번호 입력창 팝업
					$password_popup = "";
					if($row->opt_secret > 0){
						if(! $this->tank_auth->is_logged_in()  &&  $row->user_idx < 1) { // 비로그인 && 비로그인작성시 user_idx 값은 0

							// 비회원 비밀글
							$ss_password_name = 'ss_bbs_password';
							if (! $this->session->userdata($ss_password_name)) {
								//$this->session->set_userdata($ss_password_name, time());
								//redirect( $this->bbs_code_url .'/password/'.$wr_idx.'/'.$page_ttl.'/'.$page );
								$password_popup = ' onclick="set_action(\''.$bo_code.'\','.$row->wr_idx.','.$page.'); return false;" data-toggle="modal" data-target="#passModal"  ';

							}
							else {
								// 비번 입력하고 패스~
								$this->session->set_userdata($ss_password_name, FALSE);
							}

						}
						elseif((! $this->tank_auth->is_logged_in()) || ((isset($this->user->id) && ($this->user->id !== $row->user_idx)) && ! $this->tank_auth->is_admin()) ) {
							//alert('권한이 없습니다.');
							//exit;
						}
					}

					$result_notice['qry'][$i]->password_popup = $password_popup;


			}



			// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
			// [원래 문자열] $like_field, $like_match
			// [인코딩 문자] $search_field, $search_text, $sfl, $stx
			// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -



			// 그룹 리스트
			//$gr_result = $this->basic_model->get_common_result ('result','board_group','*',FALSE,FALSE,'left outer', array('idx >'=>'0'),FALSE,FALSE,'both',FALSE,'gr_title','asc',FALSE,0);

			$arr = array(
					'sql_select'     => '*',
					'sql_from'       => 'board_group',
					'sql_where'      => array('idx >'=>'0'), //array('PIDX' => $pidx),
					'sql_order_by'   => 'gr_title asc'
			);
			$gr_result = $this->basic_model->arr_get_result($arr);


			//echo $this->bbs_code_url.'<<<<<<<<br />';



			// Get data.
			$last_loc = $bbs_cf->bo_title;
			$this->data = array(
				//'user' => $this->user,

				'cate_menu' => $cate_menu,

				'boards_result' => $this->boards_result, // 왼쪽 사이드 메뉴
				'bbs_cf'        => $this->bbs_cf,
				'arr_bo_cate'   => $arr_bo_cate, // 게시판 설정의 카테고리명 배열
				//'arr_bo_cate_cnt'   => $arr_bo_cate_cnt, // 게시판 설정의 카테고리별 게시물 수 배열

				'gr_result'  => $gr_result,
				//'bbs_code_url'  => base_url() . 'board/bbs/'. $bo_code,
				'bbs_code_url'  => $this->bbs_code_url,
				'title_desc'    => '목록',

				'bo_code'       => $bo_code,

				'total_count_all' => $total_count_all, // 카테고리 등 검색 빼고 전체

				'total_srh_cnt' => $result['total_count'],
				'result_notice'    => $result_notice,
				'result'    => $result,
				'page'      => $page,
				'limit'      => $limit,
				'offset'     => $offset,
				//'paging'    => $this->pagination->create_links(),
				'paging'    => $paging_html,
				'arr_seg'   => $this->arr_seg, //$this->uri->segment_array(),

				'sfl'      => $like_field,
				'stx'      => $like_match,

				'layout'    => 'sub',
				'menu'      => 'board',
				'last_loc'   => $last_loc,
				'breadcrumb' => array('게시판'=>'','게시물 관리'=>'',$last_loc=>''),
				'viewPage'  => 'board/'. $bbs_cf->bo_type .'_lists_view'
				//'viewPage'  => '_board/skin/'. $bbs_cf->bo_type .'_lists'. (IS_MOBILE ? '_mobile' : '') .'_view'
			);

			$this->load->view('admin/layout_view', $this->data);
	}





	// 게시글 상세 뷰
	function _bbs_detail($bo_code,$wr_idx=FALSE,$page_ttl='page',$page=1)
	{

			if(! $wr_idx)
				redirect($this->bbs_code_url);


			// 게시판 정보 테이블
			$bo_table = BBS_PRE.$bo_code;

			// 게시판 설정파일
			$arr = array('sql_select' => '*','sql_from' => 'board_config','sql_where' => array('bo_code'=>$bo_code));
			$bbs_cf = $this->basic_model->arr_get_row($arr);



			// [1/3] 캅챠 자동등록방지
			$captcha_registration	= $this->config->item('captcha_registration', 'tank_auth');
			$use_recaptcha			= $this->config->item('use_recaptcha', 'tank_auth');

			// # 에러 메시지 CSS
			$this->form_validation->set_error_delimiters('<div class="error">','</div>');

			
			// 선택한 글 정보
			$get_type='row';
			$fields='*';
			$sql_from=BBS_PRE.$bo_code;  // 게시판 테이블
			$join_tbl=FALSE;
			$join_where=FALSE;
			$join_option=FALSE;
			$sql_where=array('wr_idx'=>$wr_idx);
			$sql_group_by=FALSE;
			$sql_order_by=FALSE;
			$limit=FALSE;

			$sql_or_where = FALSE;

			// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
			// 관리자라면 모두 볼 수 있고,
			// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
				if (! $this->tank_auth->is_admin()) {			// not logged in or activated
					// 회원이라면 VIEW 값이 'N' 이 아닌 것만 볼 수 있게.
					$sql_where['VIEW'] = 'Y';

					// APP (승인/미승인)
					//$sql_where['APP'] = 'Y';
				}
			
			// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
			// 공통 추가
			// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
				// 기존 사이트 디비세팅 유지
				$sql_where['del_yn'] = 'N';




			//$row = $this->basic_model->get_common_row($get_type,$fields,$sql_from,$join_tbl,$join_where,$join_option,$sql_where,$sql_group_by,$sql_order_by,1,$sql_or_where);

			// 게시판 설정파일
			$arr = array('sql_select' => '*','sql_from' => $bo_table,'sql_where' => array('wr_idx'=>$wr_idx));
			$row = $this->basic_model->arr_get_row($arr);


			//echo $this->db->last_query();
			//echo '<br />';
			//print_r($row);
			//exit;

			// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
			// 존재하지 않는 글이거나 삭제된 글 또는 권한 없는 글을 볼 때..
			// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
			if( $wr_idx > 0 && ! isset($row->wr_idx) )
				alert('존재하지 않는 글이거나 삭제된 글입니다.',$this->bbs_code_url .'/lists');


			// 이전글
				$sql_where_prev = array('ORD >'=>$row->ORD,'opt_notice <'=>1, 'del_yn'=>'N');; // wr_datetime
				if(! $this->tank_auth->is_admin()) {
					$sql_where_prev['APP'] = 'Y';
					$sql_where_prev['VIEW'] = 'Y';
				}
				$sql_order_by_prev = 'ORD ASC';

				$limit_prev=1;

				//$row_prev = $this->basic_model->get_common_row($get_type,$fields,$sql_from,$join_tbl,$join_where,$join_option,$sql_where_prev,$sql_group_by,$sql_order_by_prev,$limit_prev);
				$arr = array('sql_select' =>$fields,'sql_from' =>$sql_from,'sql_where' =>$sql_where_prev,'sql_order_by'=>$sql_order_by_prev,'limit'=>$limit_prev);
				$row_prev = $this->basic_model->arr_get_row($arr);


				if( isset($row_prev->wr_datetime) ) {
					$row_prev->wr_datetime_point = str_replace('-','. ',substr($row_prev->wr_datetime,0,10));
				}
				//echo $row_prev->wr_idx.'/';


			// 다음글
				$sql_where_next = array('ORD <'=>$row->ORD,'opt_notice <'=>1, 'del_yn'=>'N');; // wr_datetime
				if(! $this->tank_auth->is_admin()) {
					$sql_where_next['APP'] = 'Y';
					$sql_where_next['VIEW'] = 'Y';
				}
				$sql_order_by_next = 'ORD DESC';
				$limit_next=1;

				//$row_next = $this->basic_model->get_common_row($get_type,$fields,$sql_from,$join_tbl,$join_where,$join_option,$sql_where_next,$sql_group_by,$sql_order_by_next,$limit_next);
				$arr = array('sql_select' =>$fields,'sql_from' =>$sql_from,'sql_where' =>$sql_where_next,'sql_order_by'=>$sql_order_by_next,'limit'=>$limit_next);
				$row_next = $this->basic_model->arr_get_row($arr);

				if( isset($row_next->wr_datetime) ) {
					$row_next->wr_datetime_point = str_replace('-','. ',substr($row_next->wr_datetime,0,10));
				}
				//echo $row_next->wr_idx;
				//exit;


			//if( $wr_idx > 0 && ! isset($row->wr_idx) )
			//	alert('존재하지 않는 글이거나 삭제된 글입니다.',$this->bbs_code_url .'/lists');

			// 비밀글 권한
			if($row->opt_secret > 0){
				//if( ($this->user->id !== $row->user_idx) && $this->user->level < 9 ) {

				if(! $this->tank_auth->is_logged_in()  &&  $row->user_idx < 1) {

					// 비회원 비밀글
					$ss_password_name = 'ss_bbs_password';
					if (! $this->session->userdata($ss_password_name)) {
						//$this->session->set_userdata($ss_password_name, time());
						redirect( $this->bbs_code_url .'/password/'.$wr_idx.'/'.$page_ttl.'/'.$page );
					}
					else {
						// 비번 입력하고 패스~
						//$this->session->set_userdata($ss_password_name, FALSE);
					}

				}
				elseif((isset($this->user->id) && ($this->user->id !== $row->user_idx)) && ! $this->tank_auth->is_admin()) {
					
					$redirect_url = $this->bbs_code_url .'/lists/';
					if($page) {
						$redirect_url .= 'page/'.$page;
					}
					alert('작성자 이외에는 열람하실 수 없습니다.',$redirect_url);
					exit;

				}

				elseif((! $this->tank_auth->is_logged_in())) {
					redirect('/auth/login/'. url_code($this->uri->uri_string(), 'e'));
					/*
					$redirect_url = $this->bbs_code_url .'/lists/';
					if($page) {
						$redirect_url .= 'page/'.$page;
					}
					redirect($redirect_url);
					*/
					exit;
				}
			}

			// 작성자 정보
			/*
			$uacc = $this->basic_model->get_common_row('row','nickname','users',FALSE,FALSE,FALSE,array('id'=>$row->user_idx));
			if( isset($uacc->nickname) && (! $row->wr_name  OR  '' == $row->wr_name) ) {
				$row->wr_name  = $uacc->nickname;
			}
			*/

			// 작성자 정보
			$row->wr_name_input  = $row->wr_name;
			$user_table = ($row->user_idx < 1000) ? 'users_admin' : 'users';

			//$uacc = $this->basic_model->get_common_row('row','username,nickname',$user_table,FALSE,FALSE,FALSE,array('id'=>$row->user_idx));
			$arr = array('sql_select' =>'username,nickname','sql_from' =>$user_table,'sql_where' =>array('id'=>$row->user_idx));
			$uacc = $this->basic_model->arr_get_row($arr);

			if(isset($uacc->username)) {
				$row->wr_name  = $uacc->nickname;
				$row->wr_username  = $uacc->username;
			}



			if( isset($row->wr_datetime) ) {
				$row->wr_datetime_point = str_replace('-','. ',substr($row->wr_datetime,0,10));
				$row->wr_datetime_en = date("d F, Y", strtotime($row->wr_datetime));
			}

			$row->wr_content  = $row->wr_content;


			// 한번 읽은글은 브라우저를 닫기전까지는 카운트를 증가시키지 않음
			$ss_view_name = 'ss_view_'.$bo_code.'_'.$wr_idx;
			if (!$this->session->userdata($ss_view_name)) {
				$this->board_lib->hit_update($bo_code, $wr_idx);
				$this->session->set_userdata($ss_view_name, TRUE);
			}


			// 그룹 리스트
			//$gr_result = $this->basic_model->get_common_result ('result','board_group','*',FALSE,FALSE,'left outer', array('idx >'=>'0'),FALSE,FALSE,'both',FALSE,'gr_title','asc',FALSE,0);
			$arr = array(
					'sql_select'     => '*',
					'sql_from'       => 'board_group',
					'sql_where'      => array('idx >'=>'0'), //array('PIDX' => $pidx),
					'sql_order_by'   => 'gr_title asc'
			);
			$gr_result = $this->basic_model->arr_get_result($arr);




			// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
			// 폼과 에디터에 업로드한 파일 가져오기
			// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
			$get_type='result';  // 'result', 'result_array'
			$sql_from='file_manager';
			$fields='*';
			$join_tbl=FALSE;
			$join_where=FALSE;
			$join_option='left outer';
			$sql_where_form = "wr_table='".$bo_code."'  AND  wr_table_idx=". $wr_idx ."  AND upload_type='form'";
			$sql_where_editor = "wr_table='".$bo_code."'  AND  wr_table_idx=". $wr_idx ."  AND upload_type='editor'";

			// 전체 수
			$total_cnt_file_form = $this->basic_model->get_common_count($sql_from, $sql_where_form);
			$total_cnt_file_editor = $this->basic_model->get_common_count($sql_from, $sql_where_editor);

			$like_field = '';
			$like_match = '';
			$like_side='both';
			$sql_group_by = '';
			$order_field = 'datetime_upload';
			$order_direction = 'desc';
			$limit = FALSE;
			//$page  = FALSE;
			$offset = FALSE;

			//$result_file_form = $this->basic_model->get_common_result ($get_type,$sql_from,$fields,$join_tbl,$join_where,$join_option,$sql_where_form,$like_field,$like_match,$like_side,$sql_group_by,$order_field,$order_direction,$limit,$offset);
			$arr = array(
					'sql_select'     => $fields,
					'sql_from'       => $sql_from,
					'sql_where'      => $sql_where_form,
					'sql_order_by'   => $order_field.' '.$order_direction
			);
			$result_file_form = $this->basic_model->arr_get_result($arr);


			//$result_file_editor = $this->basic_model->get_common_result ($get_type,$sql_from,$fields,$join_tbl,$join_where,$join_option,$sql_where_editor,$like_field,$like_match,$like_side,$sql_group_by,$order_field,$order_direction,$limit,$offset);
			$arr = array(
					'sql_select'     => $fields,
					'sql_from'       => $sql_from,
					'sql_where'      => $sql_where_editor,
					'sql_order_by'   => $order_field.' '.$order_direction
			);
			$result_file_editor = $this->basic_model->arr_get_result($arr);



			$list_image_html = '';
			$list_image_src = '';
			if( isset($result_file_form['qry'][0]->file_name) ) {
				$list_img = $result_file_form['qry'][0];
				$list_image_src = DATA_DIR .'/'. $list_img->file_dir .'/'. $list_img->file_name;
				$list_image_html = '<img src="'. $list_image_src .'" />';
			}


			$meta_image_src = '';
			if( isset($result_file_editor['qry'][0]->file_name) ) {
				$list_img = $result_file_editor['qry'][0];
				$meta_image_src = DATA_DIR .'/'. $list_img->file_dir .'/'. $list_img->file_name;
			}


			$banner_img_html = '';
			$list_img_html = '';
			foreach($result_file_form['qry'] as $i => $o) 
			{
				$file_path = DATA_PATH.'/'.$o->file_dir.'/'.$o->file_name;
				$download_url = (isset($o->file_name) && $o->file_name != '') ? '/files/download/'.url_code($o->file_dir,'e').'/'.$o->file_name.'/'.url_code($o->file_name_org,'e') : '#';
				$result_file_form['qry'][$i]->download_url = $download_url;

				if($o->gubun == 'banner') {
					$image_src = DATA_DIR .'/'. $o->file_dir .'/'. $o->file_name;
					$banner_img_html = '<img src="'. $image_src .'" />';
				}
				if($o->gubun == 'list') {
					$list_image_src = DATA_DIR .'/'. $o->file_dir .'/'. $o->file_name;
					$list_img_html = '<img src="'. $list_image_src .'" />';
				}
			}



			// sns 공유 이미지 등등..

			$this->load->helper('resize');

			// 썸네일 이미지 처리
			$thumb_img = '<img src="'.IMG_DIR.'/common/blank_image.png" style="width:100%" />';
			$thumb_src = IMG_DIR.'/common/blank_image.png';


			$thumb_img_crop = '<img src="'.IMG_DIR.'/common/blank_image.png" style="width:100%" />';
			$thumb_src_crop = IMG_DIR.'/common/blank_image.png';

			if($row->wr_idx)
			{
				//$file_row = $this->basic_model->get_common_row('row','*','file_manager',FALSE,FALSE,FALSE,array('wr_table'=>$bo_code, 'wr_table_idx'=>$row->wr_idx, 'upload_type != ' => '', 'file_type'=>'image'),FALSE,'idx asc',1);

				$arr = array('sql_select' =>'*','sql_from' =>'file_manager','sql_where' =>array('wr_table'=>$bo_code, 'wr_table_idx'=>$row->wr_idx, 'upload_type != ' => '', 'file_type'=>'image'),'sql_order_by'=>'idx asc','limit'=>1);
				$file_row = $this->basic_model->arr_get_row($arr);

				if(! empty($file_row)) {

					//$thumb_img = resize_thumb_image($file_row->file_name, $file_row->file_dir, $file_row->file_dir.'/thumb', '768','410',false,'width');
					//$thumb_src = resize_thumb_image($file_row->file_name, $file_row->file_dir, $file_row->file_dir.'/thumb', '768','410',false,'width','src');

					//$thumb_img_crop = resize_thumb_image($file_row->file_name, $file_row->file_dir, $file_row->file_dir.'/thumb', '768,0','410,0',true,'width');
					//$thumb_src_crop = resize_thumb_image($file_row->file_name, $file_row->file_dir, $file_row->file_dir.'/thumb', '768,0','410,0',true,'width','src');

				}
			}

			// 컨텐츠 텍스트만 컷
			$wr_content_cut = cut_str(remove_tags($row->wr_content),160);


			// 온라인상담 추가 데이터
			$cmt_init_content = '';


			// 카테고리 메뉴 사용시
			$this->load->library('querystring', NULL, 'param'); // 쿼리스트링 주소
			$param	  =& $this->param;
			$cate_menu_list = $param->get('cate', false);

			$cate_menu = $row->ca_code;


			// 모바일 전화번호 세팅
			$row->wr_mobile_str = $row->wr_mobile;
			if(strlen($row->wr_mobile) > 7) {
				$row->wr_mobile_str = substr($row->wr_mobile,0,3).'-'.substr($row->wr_mobile,3,4).'-'.substr($row->wr_mobile,7,4);
			}




			// 코멘트 목록
			$get_type='result';
			$sql_from='board_comment';
			$fields='*';
			$join_tbl=FALSE;
			$join_where=FALSE;
			$join_option='left outer';
			$sql_where=array('bo_code'=>$bo_code, 'wr_idx'=>$wr_idx);
			$like_field=FALSE;
			$like_match=FALSE;
			$like_side='both';
			$sql_group_by=FALSE;
			$order_field='parent desc, depth asc, order desc';
			$order_direction=FALSE;
			$limit=FALSE;
			$offset=0;

			//$result_cmt = $this->basic_model->get_common_result ($get_type,$sql_from,$fields,$join_tbl,$join_where,$join_option,$sql_where,$like_field,$like_match,$like_side,$sql_group_by,$order_field,$order_direction,$limit,$offset);
			$arr = array(
					'sql_select'     => $fields,
					'sql_from'       => $sql_from,
					'sql_where'      => $sql_where,
					'sql_order_by'   => $order_field
			);
			$result_cmt = $this->basic_model->arr_get_result($arr);


			foreach($result_cmt['qry'] as $i => $o) {

				if($o->user_idx > 1000) {
					// 일반 회원
					$user_cmt = $this->tank_auth->get_userinfo_idx($o->user_idx);
				} else {
					// 관리자
					$user_cmt = $this->tank_auth->get_admininfo_idx($o->user_idx);
				}


				//$result_cmt['qry'][$i]->user_nickname = isset($user_cmt->nickname) ? $user_cmt->nickname : 'GUEST';
				if( isset($user_cmt->nickname) ) {
					$cmt_nickname = $user_cmt->nickname;
				} else {
					$cmt_nickname = "GUEST";
				}
				$result_cmt['qry'][$i]->user_nickname = $cmt_nickname;

			}
			//print_r($result_cmt['qry']);



			$in_category = '';





























			// Get data.
			$last_loc = $this->bbs_cf->bo_title;
			$this->data = array(
				//'user' => $this->user,

				'thumb_img' => $thumb_img,
				'thumb_src' => $thumb_src,
				'thumb_img_crop' => $thumb_img_crop,
				'thumb_src_crop' => $thumb_src_crop,

				'cate_menu' => $cate_menu,
				'cate_menu_list' => $cate_menu_list,
				'meta_image_src' => $meta_image_src,

				'boards_result' => $this->boards_result, // 왼쪽 사이드 메뉴
				'bbs_cf'        => $this->bbs_cf,
				'gr_result'     => $gr_result,
				'bbs_code_url'  => $this->bbs_code_url,
				'title_desc'    => '상세 내용',
				'in_category'   => $in_category,

				'bo_code'       => $bo_code,
				'wr_idx'       => $wr_idx,
				'page_ttl'      => $page_ttl,
				'page'       => $page,

				'total_cnt_file_form'     => $total_cnt_file_form,
				'total_cnt_file_editor'     => $total_cnt_file_editor,
				'result_file_form'     => $result_file_form,
				'result_file_editor'   => $result_file_editor,

				'row'              => $row,
				'row_prev'         => $row_prev,
				'row_next'         => $row_next,

				'og_title'         => (isset($row->wr_subject)) ? $row->wr_subject : '',
				'list_image_html'  => $list_image_html,
				'list_image_src'   => $list_image_src,
				'arr_seg'          => $this->arr_seg, //$this->uri->segment_array(),

				'banner_img_html'   => $banner_img_html,
				'list_img_html'   => $list_img_html,

				'result_cmt'       => $result_cmt,
				'cmt_init_content' => $cmt_init_content,




				'layout'        => 'sub',
				'menu'          => 'board',
				'last_loc'      => $last_loc,
				'breadcrumb' => array('게시판'=>'','게시물 관리'=>'',$last_loc=>''),
				'viewPage'      => 'board/'. $this->bbs_cf->bo_type .'_detail_view'
				//'viewPage'      => '_board/skin/'. $this->bbs_cf->bo_type .'_detail'. (IS_MOBILE ? '_mobile' : '') .'_view'
			);


			/*
			if('event' == $bo_code) {
				$this->data['result_event_list'] = $result_event_list;
				$this->data['total_cnt_all'] = $total_cnt_all; // 카테고리 등 검색 빼고 전체
				$this->data['total_cnt']  = $total_cnt;
				$this->data['result_notice'] = $result_notice;
				$this->data['result']    = $result;
				$this->data['page']      = $page;
				$this->data['limit']     = $limit;
				$this->data['offset']    = $offset;
				//$this->data['paging']    = $this->pagination->create_links();
				$this->data['paging']    = $paging_html;
			}
			*/










			//sharecampaign
			//$bo_code

			// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
			// 나눔캠페인 신청내역
			// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

			$share_result = false;

			if( $bo_code === 'sharecampaign' )  
			{

				// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
				// sql - 신청내역
				// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
				$sql_select = '*';
				$sql_from = 'req_sharecampaign';
				$sql_where = array('scmp_idx' => $wr_idx, 'del_datetime' => NULL);
				$sql_order_by = 'req_datetime DESC, idx DESC';

				// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
				// 페이징 정보 
				// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
				$this->load->library('segment', array('offset'=>6), 'seg'); // 세그먼트 주소( page 위치 )
				$this->load->library('querystring', NULL, 'param'); // 쿼리스트링 주소
				$seg	  =& $this->seg;
				$param	  =& $this->param;

				// 페이징
				$page  = $seg->get('page', 1); // 페이지
				if(! isset($page) OR empty($page)) {
					$page = '1';
				}
				
				$limit = '20'; //'20';
				$offset = ($page - 1) * $limit;

				$arr = array(
						'sql_select'       => $sql_select,
						'sql_from'         => $sql_from,
						'sql_where'        => $sql_where,
						'sql_order_by'     => $sql_order_by,
						'page'             => $page,
						'limit'            => $limit,
						'offset'           => $offset,
				);
				$share_result = $this->basic_model->arr_get_result($arr);

				$this->data['share_page'] = $page;
				$this->data['share_limit'] = $limit;
				$this->data['share_result'] = $share_result;
			}






			$this->load->view('admin/layout_view', $this->data);
	}




	// 게시글 상세 뷰 - 신청 폼 등 작성 후 잠깐 보여주는 페이지용
	function _bbs_result($bo_code,$wr_idx=FALSE,$page_ttl='page',$page=1)
	{

			if(! $wr_idx)
				redirect($this->bbs_code_url);


			// 게시판 설정파일
			$get_type='row';
			$fields='*';
			$sql_from='board_config';
			$join_tbl=FALSE;
			$join_where=FALSE;
			$join_option=FALSE;
			$sql_where=array('bo_code'=>$bo_code);
			$sql_group_by=FALSE;
			$sql_order_by=FALSE;
			$limit=FALSE;

			//$bbs_cf = $this->basic_model->get_common_row($get_type,$fields,$sql_from,$join_tbl,$join_where,$join_option,$sql_where,$sql_group_by,$sql_order_by,$limit);
			$arr = array('sql_select' =>$fields,'sql_from' =>$sql_from,'sql_where' =>$sql_where);
			$bbs_cf = $this->basic_model->arr_get_row($arr);



			// [1/3] 캅챠 자동등록방지
			$captcha_registration	= $this->config->item('captcha_registration', 'tank_auth');
			$use_recaptcha			= $this->config->item('use_recaptcha', 'tank_auth');

			// # 에러 메시지 CSS
			$this->form_validation->set_error_delimiters('<div class="error">','</div>');

			
			// 선택한 글 정보
			$get_type='row';
			$fields='*';
			$sql_from=BBS_PRE.$bo_code;  // 게시판 테이블
			$join_tbl=FALSE;
			$join_where=FALSE;
			$join_option=FALSE;
			$sql_where=array('wr_idx'=>$wr_idx);
			$sql_group_by=FALSE;
			$sql_order_by=FALSE;
			$limit=FALSE;

			$sql_or_where = FALSE;

			// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
			// 관리자라면 모두 볼 수 있고,
			// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
				if (! $this->tank_auth->is_admin()) {			// not logged in or activated
					// 회원이라면 VIEW 값이 'N' 이 아닌 것만 볼 수 있게.
					$sql_where['VIEW'] = 'Y';

					// APP (승인/미승인)
					//$sql_where['APP'] = 'Y';
				}
			
			// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
			// 공통 추가
			// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
				// 기존 사이트 디비세팅 유지
				$sql_where['del_yn'] = 'N';




			//$row = $this->basic_model->get_common_row($get_type,$fields,$sql_from,$join_tbl,$join_where,$join_option,$sql_where,$sql_group_by,$sql_order_by,1,$sql_or_where);
			$arr = array('sql_select' =>$fields,'sql_from' =>$sql_from,'sql_where' =>$sql_where);
			$row = $this->basic_model->arr_get_row($arr);

			//echo $this->db->last_query();
			//echo '<br />';
			//print_r($row);
			//exit;

			// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
			// 존재하지 않는 글이거나 삭제된 글 또는 권한 없는 글을 볼 때..
			// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
			if( $wr_idx > 0 && ! isset($row->wr_idx) )
				alert('존재하지 않는 글이거나 삭제된 글입니다.',$this->bbs_code_url .'/lists');


			// 이전글
				$sql_where_prev = array('ORD >'=>$row->ORD,'opt_notice <'=>1, 'del_yn'=>'N');; // wr_datetime
				if(! $this->tank_auth->is_admin()) {
					$sql_where_prev['APP'] = 'Y';
					$sql_where_prev['VIEW'] = 'Y';
				}
				$sql_order_by_prev = 'ORD ASC';
				$limit_prev=1;

				//$row_prev = $this->basic_model->get_common_row($get_type,$fields,$sql_from,$join_tbl,$join_where,$join_option,$sql_where_prev,$sql_group_by,$sql_order_by_prev,$limit_prev);
				$arr = array('sql_select' =>$fields,'sql_from' =>$sql_from,'sql_where' =>$sql_where_prev,'sql_order_by'=>$sql_order_by_prev,'limit'=>$limit_prev);
				$row_prev = $this->basic_model->arr_get_row($arr);

				if( isset($row_prev->wr_datetime) ) {
					$row_prev->wr_datetime_point = str_replace('-','. ',substr($row_prev->wr_datetime,0,10));
				}
				//echo $row_prev->wr_idx.'/';


			// 다음글
				$sql_where_next = array('ORD <'=>$row->ORD,'opt_notice <'=>1, 'del_yn'=>'N');; // wr_datetime
				if(! $this->tank_auth->is_admin()) {
					$sql_where_next['APP'] = 'Y';
					$sql_where_next['VIEW'] = 'Y';
				}
				$sql_order_by_next = 'ORD DESC';
				$limit_next=1;

				//$row_next = $this->basic_model->get_common_row($get_type,$fields,$sql_from,$join_tbl,$join_where,$join_option,$sql_where_next,$sql_group_by,$sql_order_by_next,$limit_next);
				$arr = array('sql_select' =>$fields,'sql_from' =>$sql_from,'sql_where' =>$sql_where_next,'sql_order_by'=>$sql_order_by_next,'limit'=>$limit_next);
				$row_prev = $this->basic_model->arr_get_row($arr);

				if( isset($row_next->wr_datetime) ) {
					$row_next->wr_datetime_point = str_replace('-','. ',substr($row_next->wr_datetime,0,10));
				}
				//echo $row_next->wr_idx;
				//exit;


			//if( $wr_idx > 0 && ! isset($row->wr_idx) )
			//	alert('존재하지 않는 글이거나 삭제된 글입니다.',$this->bbs_code_url .'/lists');

			// 비밀글 권한
			if($row->opt_secret > 0){
				//if( ($this->user->id !== $row->user_idx) && $this->user->level < 9 ) {

				if(! $this->tank_auth->is_logged_in()  &&  $row->user_idx < 1) {

					// 비회원 비밀글
					$ss_password_name = 'ss_bbs_password';
					if (! $this->session->userdata($ss_password_name)) {
						//$this->session->set_userdata($ss_password_name, time());
						redirect( $this->bbs_code_url .'/password/'.$wr_idx.'/'.$page_ttl.'/'.$page );
					}
					else {
						// 비번 입력하고 패스~
						//$this->session->set_userdata($ss_password_name, FALSE);
					}

				}
				elseif((isset($this->user->id) && ($this->user->id !== $row->user_idx)) && ! $this->tank_auth->is_admin()) {
					
					$redirect_url = $this->bbs_code_url .'/lists/';
					if($page) {
						$redirect_url .= 'page/'.$page;
					}
					alert('작성자 이외에는 열람하실 수 없습니다.',$redirect_url);
					exit;

				}

				elseif((! $this->tank_auth->is_logged_in())) {
					redirect('/auth/login/'. url_code($this->uri->uri_string(), 'e'));
					/*
					$redirect_url = $this->bbs_code_url .'/lists/';
					if($page) {
						$redirect_url .= 'page/'.$page;
					}
					redirect($redirect_url);
					*/
					exit;
				}
			}

			// 작성자 정보
			/*
			$uacc = $this->basic_model->get_common_row('row','nickname','users',FALSE,FALSE,FALSE,array('id'=>$row->user_idx));
			if( isset($uacc->nickname) && (! $row->wr_name  OR  '' == $row->wr_name) ) {
				$row->wr_name  = $uacc->nickname;
			}
			*/

			// 작성자 정보
			$row->wr_name_input  = $row->wr_name;
			$user_table = ($row->user_idx < 1000) ? 'users_admin' : 'users';

			//$uacc = $this->basic_model->get_common_row('row','username,nickname',$user_table,FALSE,FALSE,FALSE,array('id'=>$row->user_idx));
			$arr = array('sql_select' =>'username,nickname','sql_from' =>$user_table,'sql_where' =>array('id'=>$row->user_idx));
			$uacc = $this->basic_model->arr_get_row($arr);

			if(isset($uacc->username)) {
				$row->wr_name  = $uacc->nickname;
				$row->wr_username  = $uacc->username;
			}



			if( isset($row->wr_datetime) ) {
				$row->wr_datetime_point = str_replace('-','. ',substr($row->wr_datetime,0,10));
				$row->wr_datetime_en = date("d F, Y", strtotime($row->wr_datetime));
			}

			$row->wr_content  = nl2br($row->wr_content);


			// 한번 읽은글은 브라우저를 닫기전까지는 카운트를 증가시키지 않음
			$ss_view_name = 'ss_view_'.$bo_code.'_'.$wr_idx;
			if (!$this->session->userdata($ss_view_name)) {
				$this->board_lib->hit_update($bo_code, $wr_idx);
				$this->session->set_userdata($ss_view_name, TRUE);
			}


			// 그룹 리스트
			//$gr_result = $this->basic_model->get_common_result ('result','board_group','*',FALSE,FALSE,'left outer', array('idx >'=>'0'),FALSE,FALSE,'both',FALSE,'gr_title','asc',FALSE,0);
			$arr = array(
					'sql_select'     => '*',
					'sql_from'       => 'board_group',
					'sql_where'      => array('idx >'=>'0'), //array('PIDX' => $pidx),
					'sql_order_by'   => 'gr_title asc'
			);
			$gr_result = $this->basic_model->arr_get_result($arr);




			// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
			// 폼과 에디터에 업로드한 파일 가져오기
			// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
			$get_type='result';  // 'result', 'result_array'
			$sql_from='file_manager';
			$fields='*';
			$join_tbl=FALSE;
			$join_where=FALSE;
			$join_option='left outer';
			$sql_where_form = "wr_table='".$bo_code."'  AND  wr_table_idx=". $wr_idx ."  AND upload_type='form'";
			$sql_where_editor = "wr_table='".$bo_code."'  AND  wr_table_idx=". $wr_idx ."  AND upload_type='editor'";

			// 전체 수
			$total_cnt_file_form = $this->basic_model->get_common_count($sql_from, $sql_where_form);
			$total_cnt_file_editor = $this->basic_model->get_common_count($sql_from, $sql_where_editor);

			$like_field = '';
			$like_match = '';
			$like_side='both';
			$sql_group_by = '';
			$order_field = 'datetime_upload';
			$order_direction = 'desc';
			$limit = FALSE;
			$page  = FALSE;
			$offset = FALSE;
			
			

			//$result_file_form = $this->basic_model->get_common_result ($get_type,$sql_from,$fields,$join_tbl,$join_where,$join_option,$sql_where_form,$like_field,$like_match,$like_side,$sql_group_by,$order_field,$order_direction,$limit,$offset);
			$arr = array(
					'sql_select'     => $fields,
					'sql_from'       => $sql_from,
					'sql_where'      => $sql_where_form,
					'sql_order_by'   => $order_field.' '.$order_direction
			);
			$result_file_form = $this->basic_model->arr_get_result($arr);


			//$result_file_editor = $this->basic_model->get_common_result ($get_type,$sql_from,$fields,$join_tbl,$join_where,$join_option,$sql_where_editor,$like_field,$like_match,$like_side,$sql_group_by,$order_field,$order_direction,$limit,$offset);
			$arr = array(
					'sql_select'     => $fields,
					'sql_from'       => $sql_from,
					'sql_where'      => $sql_where_editor,
					'sql_order_by'   => $order_field.' '.$order_direction
			);
			$result_file_editor = $this->basic_model->arr_get_result($arr);





			$list_image_html = '';
			$list_image_src = '';
			if( isset($result_file_form['qry'][0]->file_name) ) {
				$list_img = $result_file_form['qry'][0];
				$list_image_src = DATA_DIR .'/'. $list_img->file_dir .'/'. $list_img->file_name;
				$list_image_html = '<img src="'. $list_image_src .'" />';
			}


			$meta_image_src = '';
			if( isset($result_file_editor['qry'][0]->file_name) ) {
				$list_img = $result_file_editor['qry'][0];
				$meta_image_src = DATA_DIR .'/'. $list_img->file_dir .'/'. $list_img->file_name;
			}


			$banner_img_html = '';
			$list_img_html = '';
			foreach($result_file_form['qry'] as $i => $o) 
			{
				$file_path = DATA_PATH.'/'.$o->file_dir.'/'.$o->file_name;
				$download_url = (isset($o->file_name) && $o->file_name != '') ? '/files/download/'.url_code($o->file_dir,'e').'/'.$o->file_name.'/'.url_code($o->file_name_org,'e') : '#';
				$result_file_form['qry'][$i]->download_url = $download_url;

				if($o->gubun == 'banner') {
					$image_src = DATA_DIR .'/'. $o->file_dir .'/'. $o->file_name;
					$banner_img_html = '<img src="'. $image_src .'" />';
				}
				if($o->gubun == 'list') {
					$list_image_src = DATA_DIR .'/'. $o->file_dir .'/'. $o->file_name;
					$list_img_html = '<img src="'. $list_image_src .'" />';
				}
			}



			// sns 공유 이미지 등등..

			$this->load->helper('resize');

			// 썸네일 이미지 처리
			$thumb_img = '<img src="'.IMG_DIR.'/common/blank_image.png" style="width:100%" />';
			$thumb_src = IMG_DIR.'/common/blank_image.png';


			$thumb_img_crop = '<img src="'.IMG_DIR.'/common/blank_image.png" style="width:100%" />';
			$thumb_src_crop = IMG_DIR.'/common/blank_image.png';

			if($row->wr_idx)
			{
				//$file_row = $this->basic_model->get_common_row('row','*','file_manager',FALSE,FALSE,FALSE,array('wr_table'=>$bo_code, 'wr_table_idx'=>$row->wr_idx, 'upload_type != ' => '', 'file_type'=>'image'),FALSE,'idx asc',1);

				$arr = array('sql_select' =>'*','sql_from' =>'file_manager','sql_where' =>array('wr_table'=>$bo_code, 'wr_table_idx'=>$row->wr_idx, 'upload_type != ' => '', 'file_type'=>'image'),'sql_order_by'=>'idx asc','limit'=>1);
				$file_row = $this->basic_model->arr_get_row($arr);

				if(! empty($file_row)) {

					//$thumb_img = resize_thumb_image($file_row->file_name, $file_row->file_dir, $file_row->file_dir.'/thumb', '768','410',false,'width');
					//$thumb_src = resize_thumb_image($file_row->file_name, $file_row->file_dir, $file_row->file_dir.'/thumb', '768','410',false,'width','src');

					//$thumb_img_crop = resize_thumb_image($file_row->file_name, $file_row->file_dir, $file_row->file_dir.'/thumb', '768,0','410,0',true,'width');
					//$thumb_src_crop = resize_thumb_image($file_row->file_name, $file_row->file_dir, $file_row->file_dir.'/thumb', '768,0','410,0',true,'width','src');

				}
			}

			// 컨텐츠 텍스트만 컷
			$wr_content_cut = cut_str(remove_tags($row->wr_content),160);


			// 온라인상담 추가 데이터
			$cmt_init_content = '';


			// 카테고리 메뉴 사용시
			$this->load->library('querystring', NULL, 'param'); // 쿼리스트링 주소
			$param	  =& $this->param;
			$cate_menu_list = $param->get('cate', false);

			$cate_menu = $row->ca_code;


			// 모바일 전화번호 세팅
			$row->wr_mobile_str = $row->wr_mobile;
			if(strlen($row->wr_mobile) > 7) {
				$row->wr_mobile_str = substr($row->wr_mobile,0,3).'-'.substr($row->wr_mobile,3,4).'-'.substr($row->wr_mobile,7,4);
			}




			// 코멘트 목록
			$get_type='result';
			$sql_from='board_comment';
			$fields='*';
			$join_tbl=FALSE;
			$join_where=FALSE;
			$join_option='left outer';
			$sql_where=array('bo_code'=>$bo_code, 'wr_idx'=>$wr_idx);
			$like_field=FALSE;
			$like_match=FALSE;
			$like_side='both';
			$sql_group_by=FALSE;
			$order_field='parent desc, depth asc, order desc';
			$order_direction=FALSE;
			$limit=FALSE;
			$offset=0;

			//$result_cmt = $this->basic_model->get_common_result ($get_type,$sql_from,$fields,$join_tbl,$join_where,$join_option,$sql_where,$like_field,$like_match,$like_side,$sql_group_by,$order_field,$order_direction,$limit,$offset);

			$arr = array(
					'sql_select'     => $fields,
					'sql_from'       => $sql_from,
					'sql_where'      => $sql_where,
					'sql_order_by'   => $order_field
			);
			$result_cmt = $this->basic_model->arr_get_result($arr);


			foreach($result_cmt['qry'] as $i => $o) {

				if($o->user_idx > 1000) {
					// 일반 회원
					$user_cmt = $this->tank_auth->get_userinfo_idx($o->user_idx);
				} else {
					// 관리자
					$user_cmt = $this->tank_auth->get_admininfo_idx($o->user_idx);
				}


				//$result_cmt['qry'][$i]->user_nickname = isset($user_cmt->nickname) ? $user_cmt->nickname : 'GUEST';
				if( isset($user_cmt->nickname) ) {
					$cmt_nickname = $user_cmt->nickname;
				} else {
					$cmt_nickname = "GUEST";
				}
				$result_cmt['qry'][$i]->user_nickname = $cmt_nickname;

			}
			//print_r($result_cmt['qry']);



			$in_category = '';






			// Get data.
			$last_loc = $this->bbs_cf->bo_title;
			$this->data = array(
				'user' => $this->user,

				'thumb_img' => $thumb_img,
				'thumb_src' => $thumb_src,
				'thumb_img_crop' => $thumb_img_crop,
				'thumb_src_crop' => $thumb_src_crop,

				'cate_menu' => $cate_menu,
				'cate_menu_list' => $cate_menu_list,
				'meta_image_src' => $meta_image_src,

				'boards_result' => $this->boards_result, // 왼쪽 사이드 메뉴
				'bbs_cf'        => $this->bbs_cf,
				'gr_result'     => $gr_result,
				'bbs_code_url'  => $this->bbs_code_url,
				'title_desc'    => '상세 내용',
				'in_category'   => $in_category,

				'bo_code'       => $bo_code,
				'wr_idx'       => $wr_idx,
				'page_ttl'      => $page_ttl,
				'page'       => $page,

				'total_cnt_file_form'     => $total_cnt_file_form,
				'total_cnt_file_editor'     => $total_cnt_file_editor,
				'result_file_form'     => $result_file_form,
				'result_file_editor'   => $result_file_editor,

				'row'              => $row,
				'row_prev'         => $row_prev,
				'row_next'         => $row_next,

				'og_title'         => (isset($row->wr_subject)) ? $row->wr_subject : '',
				'list_image_html'  => $list_image_html,
				'list_image_src'   => $list_image_src,
				'arr_seg'          => $this->arr_seg, //$this->uri->segment_array(),

				'banner_img_html'   => $banner_img_html,
				'list_img_html'   => $list_img_html,

				'result_cmt'       => $result_cmt,
				'cmt_init_content' => $cmt_init_content,




				'layout'        => 'sub',
				'menu'          => 'board',
				'last_loc'      => $last_loc,
				//'breadcrumb'    => array('게시판','게시글 관리',$last_loc),
				'breadcrumb' => array('게시판'=>'','게시물 관리'=>'',$last_loc=>''),
				'viewPage'      => '_board/skin/'. $this->bbs_cf->bo_type .'_result_view'
				//'viewPage'      => '_board/skin/'. $this->bbs_cf->bo_type .'_detail'. (IS_MOBILE ? '_mobile' : '') .'_view'
			);


			if('event' == $bo_code) {

				$this->data['result_event_list'] = $result_event_list;

				$this->data['total_cnt_all'] = $total_cnt_all; // 카테고리 등 검색 빼고 전체

				$this->data['total_cnt']  = $total_cnt;
				$this->data['result_notice'] = $result_notice;
				$this->data['result']    = $result;
				$this->data['page']      = $page;
				$this->data['limit']     = $limit;
				$this->data['offset']    = $offset;
				//$this->data['paging']    = $this->pagination->create_links();
				$this->data['paging']    = $paging_html;
			}

			$this->load->view('admin/layout_view', $this->data);
	}








	// 이벤트 신청 목록
	function _bbs_request($bo_code,$page_ttl='page',$page=1)
	{

			// Get data.
			$last_loc = $this->bbs_cf->bo_title;
			$this->data = array(
				'user' => $this->user,
				'arr_seg'          => $this->arr_seg, //$this->uri->segment_array(),
				'layout'        => 'sub',
				'menu'          => 'board',
				'last_loc'      => $last_loc,
				//'breadcrumb'    => array('게시판','이벤트 문의',$last_loc),
				'breadcrumb' => array('게시판'=>'','게시물 관리'=>'',$last_loc=>''),
				'viewPage'      => '_board/skin/event_request_view'
			);




			// 이벤트 접수 목록

						// # 페이징 정보 - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
						$this->load->library('segment', array('offset'=>4), 'seg'); // 세그먼트 주소( page 텍스트 위치 )
						$this->load->library('querystring', NULL, 'param'); // 쿼리스트링 주소

						$seg	  =& $this->seg;
						$param	  =& $this->param;


						// 검색어 검색
						/*
						$like_field = $this->input->post('search_field',FALSE);
						$like_field = $this->input->post('search_field',FALSE);
						$like_match = $this->input->post('search_text',FALSE);
						$like_side='both';
						*/

						$sql_from = 'event_request';
						//$sql_where = array('wr_idx'=>$wr_idx,'DELYN'=>'N');
						$sql_where = array('DELYN'=>'N');


						// 전체 수
						$total_cnt = $this->basic_model->get_common_count($sql_from, $sql_where);


						// 접수구분
						$search_field = $this->input->post('search_field',FALSE);
						$search_text = $this->input->post('search_text',FALSE);

						$sfl_get = $param->get('sfl', false);
						$stx_get = $param->get('stx', false);

						if(! $search_field) { $search_field = $sfl_get; }
						if(! $search_text) { $search_text = url_code($stx_get,'d'); }

						$search_text = trim($search_text);


						// 접수기간 검색
						$sdate = $this->input->post('sdate',FALSE);
						$edate = $this->input->post('edate',FALSE);

						$sdate_get = $param->get('sdate', false);
						$edate_get = $param->get('edate', false);

						if(! $sdate) { $sdate = $sdate_get; }
						if(! $edate) { $edate = $edate_get; }




						$qstr = '';
						if('' != $sdate && '' != $edate) {
							//$sql_where_add = ' AND ('.$sdate.' <= REGDATE AND REGDATE <= '.$edate.') ';
							$sql_where['REGDATE >='] = $sdate;
							$sql_where['REGDATE <='] = $edate;

							$qstr .= '?sdate='.$sdate.'&edate='.$edate;
						}


						$sql_where_srh_total = $sql_where;
						if('' != $search_field && '' != $search_text) {

							$stx = url_code($search_text,'e');

							$qstr .= ('' == $qstr) ? '?' : '&';
							$qstr .= 'sfl='.$search_field.'&stx='.$stx;

							$sql_where_srh_total[$search_field.' like '] = '%'.$search_text.'%';
						}
						// 검색 전체 수
						$total_srh_cnt = $this->basic_model->get_common_count($sql_from, $sql_where_srh_total);

						//echo $this->db->last_query();
						//exit;




						// 정렬
						$order_field = $this->input->post('order_field',FALSE);
						if(! $order_field) $order_field = 'REGDATE';
						$order_direction = $this->input->post('order_direction','DESC');

						$limit = '10';
						$page  = $seg->get('page', 1); // 페이지
						if(! isset($page) OR empty($page)) {
							$page = '1';
						}
						$offset = ($page - 1) * $limit;

						$arr = array(
								'sql_select'     => '*',
								'sql_from'       => $sql_from,

								//'like_field'      => $this->input->post('search_field',FALSE),
								//'like_match'      => $this->input->post('search_text',FALSE),
								'like_field'      => ('' != $search_field) ? $search_field : FALSE,
								'like_match'      => ('' != $search_text) ? $search_text : FALSE,
								'like_side'      => 'both',

								'sql_where'      => $sql_where, //array('PIDX' => $pidx),
								'sql_group_by'   => FALSE,
								'sql_order_by'   => $order_field.' DESC, IDX DESC',
								
								'page'      => $page,
								'limit'      => $limit,
								'offset'      => $offset,
						);
						$event_result = $this->basic_model->arr_get_result($arr);





						// [이벤트 문의] 추가 자료 필요시
						foreach($event_result['qry'] as $i => $o)
						{

							$state_btn = '';
							$state_btn = '<input type="button" onclick="javascript:confirm_tel(\''.$o->IDX.'\',\'tel\');" value="전화확인">';
							if('Y' == $o->STATE) {
								$state_btn = '처리완료';
							}
							$event_result['qry'][$i]->state_btn = $state_btn;




							// SoftTelemanager - spam
							$arr_spam = array(
									'sql_select'     => '*',
									'sql_from'       => 'SoftTelemanager_spam',
									'sql_where'      => array('event_cost' => 'event', 'event_cost_idx'=>$o->IDX )
							);
							$row_spam = $this->basic_model->arr_get_row($arr_spam);
							if(isset($row_spam->Flag)) {
								$event_result['qry'][$i]->state_btn = 'spam';
							}


							// SoftTelemanager
							$arr_flag = array(
									'sql_select'     => '*',
									'sql_from'       => 'SoftTelemanager',
									'sql_where'      => array('event_cost' => 'event', 'event_cost_idx'=>$o->IDX )
							);
							$row_flag = $this->basic_model->arr_get_row($arr_flag);
							$flag = isset($row_flag->Flag) ? $row_flag->Flag : '';
							$event_result['qry'][$i]->FLAG = $flag;

							if(isset($row_flag->Flag)) {
								$event_result['qry'][$i]->state_btn = $flag;
							}

							//echo $this->db->last_query();
							//echo '<hr />';




							$mobile_hpn = $o->MOBILE;
							if('' != $o->MOBILE && strlen($o->MOBILE) > 9) {
								if(false === strpos($o->MOBILE,'-')) {
									if(strlen($o->MOBILE) == 10) {
										$mobile_hpn = substr($o->MOBILE,0,3);
										$mobile_hpn .= '-'.substr($o->MOBILE,3,3);
										$mobile_hpn .= '-'.substr($o->MOBILE,6,4);
									}
									else {
										$mobile_hpn = substr($o->MOBILE,0,3);
										$mobile_hpn .= '-'.substr($o->MOBILE,3,4);
										$mobile_hpn .= '-'.substr($o->MOBILE,7,4);
									}
								}
							}
							$event_result['qry'][$i]->MOBILE_HPN = $mobile_hpn;

						}

						// pagination 설정
						$config['suffix']	   = $qstr;
						//$config['base_url']    = base_url() . 'admin/program/event_request/page/';
						$config['base_url']    = base_url() . 'board/csb002/request/page/';

						
						$config['per_page']    = $limit;
						$config['total_rows']  = $event_result['total_count'];
						$config['uri_segment'] = $seg->pos('page');  // 5

						// 검색 목록 ADD
						$btn_prev_part = $btn_next_part = '';

						$config['full_tag_open']  = "<ul class='pagination pagination-sm justify-content-center'>".$btn_prev_part;
						$config['full_tag_close'] = $btn_next_part.'</ul>';

						$config['first_link'] = '<span aria-hidden="true"><i class="uil uil-left-arrow-to-left"></i></span>';
						$config['prev_link'] = '<span aria-hidden="true"><i class="uil uil-arrow-left"></i></span>';
						$config['next_link'] = '<span aria-hidden="true"><i class="uil uil-arrow-right"></i></span>';
						$config['last_link'] = '<span aria-hidden="true"><i class="uil uil-arrow-to-right"></i></span>';


						$this->load->library('pagination', $config);

						$paging_html = $this->pagination->create_links();

						if('' == $paging_html) {
							if( (isset($this->user->level) ? $this->user->level : 1) >= $bbs_cf->bo_level_write) {
								$paging_html = '<ul class="pagination pagination-sm justify-content-center">';
								$paging_html .= '<li class="page-item"><a class="page-link" href="'.$this->bbs_code_url.'/write/"><span aria-hidden="true"><i class="uil uil-edit-alt"></i></span></a></li>';
								$paging_html .= '</ul>';
							}
						}



						$this->data['event_result'] = $event_result;
						$this->data['page'] = $page;
						$this->data['limit'] = $limit;
						$this->data['offset'] = $offset;
						$this->data['paging'] = $paging_html;
						$this->data['arr_seg'] = $this->arr_seg;





			/*
			if(IS_MOBILE) {
				$header_add_tag = '<div style="padding:0 15px 30px 15px;">';
				$footer_add_tag = '</div>';

				$this->data['header_add_tag'] = $header_add_tag;
				$this->data['footer_add_tag'] = $footer_add_tag;
			}
			*/

			//$this->load->view('_layout_view', $this->data);

			//$this->data['tpl'] = TPL;
			$this->load->view('admin/layout_view', $this->data);

			/*
			if(IS_MOBILE) {
				$this->load->view('mobile_layout_view', $this->data);
			}
			else {
				$this->load->view('layout_view', $this->data);
			}
			*/

	}







	// 게시글 쓰기 및 수정
	function _bbs_write($bo_code,$wr_idx=FALSE,$page_ttl='page',$page=1,$mode=FALSE)
	{

			// 게시판 정보 테이블
			$bo_table = BBS_PRE.$bo_code;

			if($wr_idx == 'new')
				$wr_idx = 0;

			if('reply' !== $mode)
				$mode = ($wr_idx > 0) ? 'update' : 'write';


			// 카테고리 메뉴 사용시
			$cate_menu = $this->input->post('cate_menu', false);

			// 쿼리스트링
			if(! $cate_menu) {
				$this->load->library('querystring', NULL, 'param'); // 쿼리스트링 주소
				$param	  =& $this->param;
				$cate_menu = $param->get('cate', false);
			}
			$add_url = (isset($cate_menu) && $cate_menu) ? '?cate='.$cate_menu : '';
			

			// # [2017-03-22] 에러 메시지 CSS
			$this->form_validation->set_error_delimiters('<div class="error_board_admin">','</div>');

			// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
			// 글 작성(새글, 답변글, 수정)시 업로드 파일 저장을 위해 고유 세션 생성
			// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
			$user_idx = $this->tank_auth->get_user_id();
			$ss_write_name = 'ss_file_'.$user_idx;
			if (! $this->session->userdata($ss_write_name)) {
				$this->session->set_userdata($ss_write_name, $user_idx.'_'.time());
			}




			// [1/3] 캅챠 자동등록방지
			$data['use_recaptcha'] = $this->config->item('use_recaptcha', 'tank_auth');
			/*
			if ($data['use_recaptcha']) {
				$this->form_validation->set_rules('recaptcha_response_field', '확인 코드', 'trim|xss_clean|required|callback__check_recaptcha');
			}
			elseif( $this->input->post('captcha') ) {
				$this->form_validation->set_rules('captcha', '확인 코드', 'trim|xss_clean|required|callback__check_captcha');
			}
			*/


			$captcha_registration	= $this->config->item('captcha_registration', 'tank_auth');
			$use_recaptcha			= $this->config->item('use_recaptcha', 'tank_auth');



			// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
			// 글쓰기 저장시..
			// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
			if( $this->input->post('submit') ) {

					//$this->form_validation->set_rules('wr_subject', '제목', 'trim|required|xss_clean');
					//$this->form_validation->set_rules('wr_content', '내용', 'trim|required');

					$this->form_validation->set_rules('opt_secret', '비밀글', '');
					if ($this->tank_auth->is_admin()) {
						$this->form_validation->set_rules('opt_notice', '공지글', '');
					}

					$ca_code_ttl = '카테고리';
					if($this->bbs_cf->bo_use_category) {
						$this->form_validation->set_rules('ca_code', $ca_code_ttl, 'trim|required');
					}
					
					/*
					// [칸타BS] 방송사례
					if('media' == $bo_code ) 
					{
						// 제목,내용
						$this->form_validation->set_rules('wr_subject', '제목', 'trim|required|xss_clean');
						$this->form_validation->set_rules('wr_content', '내용', 'trim|required');
						// 언론사
						$this->form_validation->set_rules('add_column_1', '언론사', 'trim|required');
					}
					elseif('form' == $bo_code ) 
					{
						// 제목,내용
						//$this->form_validation->set_rules('wr_subject', '제목', 'trim|required|xss_clean');
						$this->form_validation->set_rules('wr_content', '내용', 'trim|required');
						// 이름, 이메일, 연락처, 업체명, 제품, 내용
						$this->form_validation->set_rules('chk_agree', '개인정보 처리', 'trim|required|xss_clean');
						$this->form_validation->set_rules('wr_name', '이름', 'trim|required|xss_clean');
						$this->form_validation->set_rules('wr_mobile', '연락처', 'trim|required');
						$this->form_validation->set_rules('wr_email', '이메일', 'trim|required');
						//$this->form_validation->set_rules('wr_password', '비밀번호', 'trim|required');

						//$this->form_validation->set_rules('captcha', '자동등록방지코드', 'trim|xss_clean|required|callback__check_captcha');
					}
					elseif('counsel' == $bo_code ) 
					{
						// 제목,내용
						$this->form_validation->set_rules('wr_subject', '제목', 'trim|required|xss_clean');
						$this->form_validation->set_rules('wr_content', '내용', 'trim|required');
						// 이름, 이메일, 연락처, 업체명, 제품, 내용
						$this->form_validation->set_rules('chk_agree', '개인정보 처리', 'trim|required|xss_clean');
						$this->form_validation->set_rules('wr_name', '이름', 'trim|required|xss_clean');
						$this->form_validation->set_rules('wr_mobile', '연락처', 'trim|required');
						$this->form_validation->set_rules('wr_email', '이메일', 'trim|required');
						$this->form_validation->set_rules('wr_password', '비밀번호', 'trim|required');

						//$this->form_validation->set_rules('captcha', '자동등록방지코드', 'trim|xss_clean|required|callback__check_captcha');
					}
					elseif('reserve' == $bo_code ) 
					{
						// 제목,내용
						$this->form_validation->set_rules('wr_subject', '제목', 'trim|required|xss_clean');
						$this->form_validation->set_rules('wr_content', '내용', 'trim|required');

						$this->form_validation->set_rules('add_column_1', '상담구분', 'trim|required');
						$this->form_validation->set_rules('add_column_2', '지점', 'trim|required');
						$this->form_validation->set_rules('add_column_3', '관심분야', 'trim|required');

						// 이름, 연락처, 개인정보 처리
						$this->form_validation->set_rules('chk_agree', '개인정보 처리', 'trim|required|xss_clean');
						$this->form_validation->set_rules('wr_name', '이름', 'trim|required|xss_clean');
						$this->form_validation->set_rules('wr_mobile', '연락처', 'trim|required');

						//$this->form_validation->set_rules('reserve_year', '예약시간', 'trim|required');
						//$this->form_validation->set_rules('reserve_month', '예약시간', 'trim|required');
						//$this->form_validation->set_rules('reserve_date', '예약시간', 'trim|required');

						$this->form_validation->set_rules('add_column_5', '예약일자', 'trim|required');
						$this->form_validation->set_rules('reserve_time', '예약시간', 'trim|required');
					}
					elseif('event' == $bo_code ) 
					{
						// 제목,이름,내용
						$this->form_validation->set_rules('wr_subject', '제목', 'trim|required|xss_clean');
						$this->form_validation->set_rules('wr_content', '내용', 'trim|required');

						$this->form_validation->set_rules('add_column_1', '시작일', 'trim|required');
						$this->form_validation->set_rules('add_column_2', '종료일', 'trim|required');
						$this->form_validation->set_rules('add_column_3', '사용여부', 'trim|required');
						$this->form_validation->set_rules('add_column_4', '메인노출', 'trim|required');
						$this->form_validation->set_rules('add_column_5[]', '지점', 'trim|required');
					}
					elseif('review_exp' == $bo_code ) 
					{
						// 제목,이름,내용
						$this->form_validation->set_rules('wr_subject', '제목', 'trim|required|xss_clean');
						$this->form_validation->set_rules('wr_name', '이름', 'trim|required|xss_clean');
						$this->form_validation->set_rules('wr_content', '내용', 'trim|required');

						$this->form_validation->set_rules('add_column_1', '성공감량', 'trim|required');
						$this->form_validation->set_rules('add_column_2', '관리기간', 'trim|required');
						$this->form_validation->set_rules('add_column_3', '관리부위', 'trim|required');
					}
					elseif('review_succ' == $bo_code ) 
					{
						// 제목,이름,내용
						$this->form_validation->set_rules('wr_subject', '제목', 'trim|required|xss_clean');
						$this->form_validation->set_rules('wr_name', '이름', 'trim|required|xss_clean');
						$this->form_validation->set_rules('wr_content', '내용', 'trim|required');

						$this->form_validation->set_rules('add_column_1', '성공감량', 'trim|required');
						$this->form_validation->set_rules('add_column_2', '신장', 'trim|required');
						$this->form_validation->set_rules('add_column_3', '나이', 'trim|required');
						$this->form_validation->set_rules('add_column_4', '지점', 'trim|required');
						$this->form_validation->set_rules('add_column_5', '관리기간', 'trim|required');
						$this->form_validation->set_rules('add_column_6', '관리부위', 'trim|required');
					}
					else {
						$this->form_validation->set_rules('wr_subject', '제목', 'trim|required|xss_clean');
						$this->form_validation->set_rules('wr_content', '내용', 'trim|required');
					}
					*/


					/*
					// 견적 요청
					if('myestimate' == $bo_code ) 
					{
						// 이름, 이메일, 연락처, 업체명, 제품, 내용
						$this->form_validation->set_rules('wr_name', '이름', 'trim|required|xss_clean');
						$this->form_validation->set_rules('wr_email', '이메일', 'trim|required');
						$this->form_validation->set_rules('wr_mobile', '연락처', 'trim|required');
						$this->form_validation->set_rules('add_column_1', '업체명', 'trim|required|xss_clean');
						//$this->form_validation->set_rules('sel_prd_idx[]', '제품', 'trim|required|xss_clean');
					}
					// 신청하기
					elseif('request' == $bo_code ) 
					{
						// 개인정보처리동의, 이름, 이메일, 연락처, 업체명, 직책, 주소, 신청과목, 내용

						$this->form_validation->set_rules('chk_agree', '개인정보 처리', 'trim|required|xss_clean');

						$this->form_validation->set_rules('wr_name', '이름', 'trim|required|xss_clean');
						$this->form_validation->set_rules('wr_email', '이메일', 'trim|required');
						$this->form_validation->set_rules('wr_mobile', '연락처', 'trim|required');
						$this->form_validation->set_rules('add_column_1', '업체명', 'trim|required|xss_clean');
						//$this->form_validation->set_rules('add_column_6', '신청과목', 'trim|required|xss_clean');
					}
					*/



					$this->form_validation->set_rules('wr_subject', '제목', 'trim|required|xss_clean');
					$this->form_validation->set_rules('wr_content', '내용', 'trim|required');




					
					//if(('reply' === $mode  OR  ! $wr_idx) && ! $this->tank_auth->is_admin()) {
					// (답변글이거나 새글일 때) 그리고 (사이트매니저 이상인 경우) 패스 ==> 수정 글이 아닌 이상, 매니저 권한이 없는 일반 회원은 자동등록방지코드를 입력해야 함.
					//if(('reply' == $mode  OR  FALSE == $wr_idx) && (! $this->tank_auth->is_logged_in() OR (isset($this->user->group_fk) && $this->user->group_fk < 3))) {

					// (답변글이거나 새글일 때) 그리고 (사이트매니저 이상인 경우) 패스 ==> 수정 글이 아닌 이상, 매니저 권한이 없는 일반 회원은 자동등록방지코드를 입력해야 함.
					if( (! $this->tank_auth->is_logged_in())  &&  ('reply' == $mode  OR  FALSE == $wr_idx) ) {

					  /* 회원 가입시 사용 여부
					  if ($captcha_registration) { // tank auth 에서 true 로 설정한 경우에만 실행
						if ($use_recaptcha) {
							$this->form_validation->set_rules('recaptcha_response_field', '자동등록방지코드', 'trim|xss_clean|required|callback__check_recaptcha');
						} else {
							$this->form_validation->set_rules('captcha', '자동등록방지코드', 'trim|xss_clean|required|callback__check_captcha');
						}
					  }
					  */

						if ($use_recaptcha) {
							$this->form_validation->set_rules('recaptcha_response_field', '자동등록방지코드', 'trim|xss_clean|required|callback__check_recaptcha');
						} else {
							$this->form_validation->set_rules('captcha', '자동등록방지코드', 'trim|xss_clean|required|callback__check_captcha');
						}
					}

					// 게시판별 필수 체크
						/*
						if('gallery' == $this->bbs_cf->bo_type) {
							//  갤러리 목록 이미지
							if (empty($_FILES['attach_file_list']['name']))
							{
								$this->form_validation->set_rules('attach_file_list', '목록이미지', 'required');
							}
						}
						*/


					

					if ($this->form_validation->run()) {	// validation ok

						//print_r($this->input->post('add_column_5'));
						//exit;

						if (!is_null($data = $this->board_lib->write($bo_code,$wr_idx,$mode,$this->bbs_cf))) {		// success

							$cnt_succ_upload = false;
							if( $this->bbs_cf->bo_use_upload )
							{

								// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
								// 폼업로드 파일 저장 처리
								// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
								$this->load->library('upload_lib');

								/*
								// 게시판별 필수 체크
								if('gallery' == $this->bbs_cf->bo_type) {
									//  갤러리 목록 이미지
									$this->upload_lib->upload_file('attach_file_list', url_code('board/'. $bo_code .'/files','e'), $bo_code, $wr_idx);
								}
								*/

								// max upload size
								$bo_upload_size = $this->bbs_cf->bo_upload_size;
								if($bo_upload_size  &&  $bo_upload_size > 0) {
									$max_upload_size = $bo_upload_size * 1000;
								} else {
									$max_upload_size = 20480; // 20MB
								}


								//$this->upload_lib->multi_upload_file('attach_file_form[]', url_code('board/'. $bo_code .'/files','e'), $bo_code, $wr_idx );
								$cnt_succ_upload = $this->upload_lib->multi_upload_file('attach_file_form[]', url_code('board/'. $bo_code .'/files','e'), $bo_code, $wr_idx, '', $max_upload_size,FALSE,'list' );




								/*
								if('cert' == $bo_code) {
									$this->upload_lib->upload_file('attach_download_1',url_code('board/'. $bo_code .'/files','e'),$bo_code,$wr_idx,1,FALSE,FALSE,true,$max_upload_size,'','list');
									$this->upload_lib->upload_file('attach_download_2',url_code('board/'. $bo_code .'/files','e'),$bo_code,$wr_idx,1,FALSE,FALSE,true,$max_upload_size,1,'download');
								}
								*/



								// 업로드 된 파일 수량을 게시글에 업데이트
								$wr_idx = (isset($data['wr_idx']) && $data['wr_idx'] > 0) ? $data['wr_idx'] : $wr_idx;
								$this->board_lib->cnt_file_update($bo_code, $wr_idx);

							}

							// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
							// 글 작성시 에디터로 업로드 한 파일 정보 저장 후, 세션 삭제
							// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
							//$user_idx = $this->tank_auth->get_user_id();
							$sess_file_write = $this->session->userdata($ss_write_name);
							$res = $this->upload_model->update_file_manager($sess_file_write,$bo_code,$data['wr_idx']);

							if( $cnt_succ_upload ) {
								// 업로드 된 파일 수량을 게시글에 업데이트
								$wr_idx = (isset($data['wr_idx']) && $data['wr_idx'] > 0) ? $data['wr_idx'] : $wr_idx;
								$this->board_lib->cnt_file_update($bo_code, $wr_idx);
							}

							// 글 작성 후, 상세 페이지로 이동
							//$redirect_url = $this->bbs_code_url .'/detail/'.$data['wr_idx'].'/page/'.$page.$add_url;

							// 글 작성 후, 목록 페이지로 이동
							$redirect_url = $this->bbs_code_url .'/lists/page/'.$page.$add_url;
							
							// 제휴문의
							if('form' == $bo_code) {
								$redirect_url = $this->bbs_code_url .'/write/';
								// 관리자에게 메일 발송
								//$receive_email = $data['wr_email'];
								//$receive_email = 'works@soi9.co.kr';
								$receive_email = $this->config->item('webmaster_email', 'tank_auth');

								// 
								$subject = $data['wr_name'].'님의 제휴문의입니다.';
								$this->_send_email('form_partner', $receive_email, $data, $subject);
							}






							// 글 작성 후, 목록 페이지로 이동
							//$redirect_url = $this->bbs_code_url .'/lists/page/'.$page.$add_url;

							/*
							// 비용문의
							if('csb005' == $bo_code) {
								$redirect_url = $this->bbs_code_url .'/write/';
								// 비용 문의 신청자에게 관련 메일 발송
								$subject = '문의하신 수술비용 안내입니다.';
								$this->_send_email('cost', $data['wr_email'], $data, $subject);
							}
							*/

							/*
							if('webzine_request' === $this->bbs_cf->bo_type) {
								// 웹진 구독 신청 후 신청 페이지로 다시 이동
								$redirect_url = $this->bbs_code_url .'/write/';
								sess_message('구독 신청이 접수되었습니다.');
								alert('구독 신청이 접수되었습니다.',$redirect_url);
							}
							elseif('reply' === $mode) {
							*/

							if('reply' === $mode) {
								sess_message('답글이 작성되었습니다.');
								alert('답글이 작성되었습니다.',$redirect_url);
							}
							elseif('write' === $mode) {
								if('form' == $bo_code) {
									sess_message('제휴문의가 접수가 완료되었습니다.');
									alert('제휴문의가 접수가 완료되었습니다.',$redirect_url);
								}
								elseif('reserve' == $bo_code) { // 상담예약

									$this->session->set_userdata('tmp_result_time', time());

									// 접수 신청등을 했을 때, 단 한 번 볼 수 있는 작성결과 확인 페이지
									$redirect_url = $this->bbs_code_url .'/result/'.$data['wr_idx'].'/page/'.$page.$add_url;

									sess_message('상담예약 접수가 완료되었습니다.');
									alert('상담예약 접수가 완료되었습니다.',$redirect_url);
								}
								else {
									sess_message('글이 작성되었습니다.');
									alert('글이 작성되었습니다.',$redirect_url);
								}
							}
							elseif('update' === $mode) {
								sess_message('글이 수정되었습니다.');
								alert('글이 수정되었습니다.',$redirect_url);
							}

						} else {
							$errors = $this->tank_auth->get_error_message();
							foreach ($errors as $k => $v)	$data['errors'][$k] = $this->lang->line($v);
						}
					}
			}


			// 캅챠[2/3]
			$data['show_captcha'] = TRUE;
			if ($data['use_recaptcha']) {
				$data['recaptcha_html'] = $this->_create_recaptcha();
			} else {
				$data['captcha_html'] = $this->_create_captcha();
			}






			// 선택한 글 정보
			$arr = array(
					'sql_select'     => '*',
					'sql_from'       => $bo_table,
					'sql_where'      => array('wr_idx'=>$wr_idx)
			);
			$row = $this->basic_model->arr_get_row($arr);

			if(! isset($row->wr_idx)  &&  $wr_idx > 0)
				alert('존재하지 않는 글이거나 삭제된 글입니다.',$this->bbs_code_url .'/lists');




			// 그룹 리스트
			$arr = array(
					'sql_select'     => '*',
					'sql_from'       => 'board_group',
					'sql_where'      => array('idx >'=>'0'),
					'sql_order_by'   => 'gr_title ASC'
			);
			$gr_result = $this->basic_model->arr_get_result($arr);


			if('reply' === $mode) {
				// 답글 컨텐츠 설정
				$row->wr_subject = '[답글]'. $row->wr_subject;
				$row->wr_content = '';

				$title_desc = '답변글 작성하기';
			}
			elseif('write' === $mode) {
				$title_desc = '새글 작성하기';
			}
			elseif('update' === $mode) {
				$title_desc = '수정하기';
			}

			// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
			// 폼과 에디터에 업로드한 파일 가져오기
			// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

			$total_cnt_file_form = $total_cnt_file_editor = 0;
			$result_file_form = $result_file_editor = array();

			$img_type_listthumb = '';
			$img_type_banner = '';
			$del_type_listthumb = '';
			$del_type_banner = '';

			if('update' === $mode)
			{

				$get_type='result';  // 'result', 'result_array'
				$sql_from='file_manager';
				$fields='*';
				$join_tbl=FALSE;
				$join_where=FALSE;
				$join_option='left outer';
				$sql_where_form = "wr_table='".$bo_code."' AND (wr_table_idx='". $wr_idx ."'  OR  wr_sess='". $this->session->userdata($ss_write_name) ."')  AND upload_type='form'";
				$sql_where_editor = "wr_table='".$bo_code."' AND (wr_table_idx='". $wr_idx ."'  OR  wr_sess='". $this->session->userdata($ss_write_name) ."')  AND upload_type='editor'";

				// 전체 수
				$total_cnt_file_form = $this->basic_model->get_common_count($sql_from, $sql_where_form);
				$total_cnt_file_editor = $this->basic_model->get_common_count($sql_from, $sql_where_editor);

				$like_field = '';
				$like_match = '';
				$like_side='both';
				$sql_group_by = '';

				$order_field = 'datetime_upload';
				$order_direction = 'desc';

				$limit = FALSE;
				$page  = FALSE;
				$offset = FALSE;


				//$result_file_form = $this->basic_model->get_common_result ($get_type,$sql_from,$fields,$join_tbl,$join_where,$join_option,$sql_where_form,$like_field,$like_match,$like_side,$sql_group_by,$order_field,$order_direction,$limit,$offset);
				$arr = array(
						'sql_select'     => $fields,
						'sql_from'       => $sql_from,
						'sql_where'      => $sql_where_form,
						'sql_order_by'   => $order_field.' '.$order_direction
				);
				$result_file_form = $this->basic_model->arr_get_result($arr);


				//$result_file_editor = $this->basic_model->get_common_result ($get_type,$sql_from,$fields,$join_tbl,$join_where,$join_option,$sql_where_editor,$like_field,$like_match,$like_side,$sql_group_by,$order_field,$order_direction,$limit,$offset);
				$arr = array(
						'sql_select'     => $fields,
						'sql_from'       => $sql_from,
						'sql_where'      => $sql_where_editor,
						'sql_order_by'   => $order_field.' '.$order_direction
				);
				$result_file_editor = $this->basic_model->arr_get_result($arr);




				// 리스트 썸네일 및 배너 이미지
				foreach($result_file_form['qry'] as $i=>$o) {
					if($img_type_listthumb == '' && isset($o->file_name) && $o->gubun == 'list' && $o->file_name != '') {
						if( is_file(RT_PATH . $o->file_dir .'/'. $o->file_name) ) {
							$img_src = $o->file_dir .'/'. $o->file_name;
						}
						else {
							$img_src = DATA_DIR .'/'. $o->file_dir .'/'. $o->file_name;
						}
						$img_type_listthumb = '<img src="'. $img_src .'" style="max-width:100%;" />';
						$del_type_listthumb = '<img src="'.IMG_DIR.'/common/icon_btn_del.gif" style="cursor:pointer;" alt="삭제" title="삭제" onclick="delete_file_manager('. $o->idx .',\'file_form_'. $i .'\',\''. $o->file_type .'\',\''. $o->file_dir .'\',\''. $o->file_name .'\',\'list\')" /> 삭제하기';

					}
					if($img_type_banner == '' && isset($o->file_name) && $o->gubun == 'banner' && $o->file_name != '') {
						$img_src = DATA_DIR .'/'. $o->file_dir .'/'. $o->file_name;
						$img_type_banner = '<img src="'. $img_src .'" style="max-width:100%;" />';
						$del_type_banner = '<img src="'.IMG_DIR.'/common/icon_btn_del.gif" style="cursor:pointer;" alt="삭제" title="삭제" onclick="delete_file_manager('. $o->idx .',\'file_form_'. $i .'\',\''. $o->file_type .'\',\''. $o->file_dir .'\',\''. $o->file_name .'\',\'banner\')" /> 삭제하기';

					}
				}
			}



			// Get data.
			$last_loc = $this->bbs_cf->bo_title;
			$this->data = array(
				//'user' => $this->user,

				'cate_menu' => $cate_menu,

				'mode'      => $mode, // insert, update, reply

				'boards_result' => $this->boards_result, // 왼쪽 사이드 메뉴
				'bbs_cf'        => $this->bbs_cf,
				'gr_result'     => $gr_result,
				'bbs_code_url'  => $this->bbs_code_url,
				'cancel_link'   => ($wr_idx > 0) ? $this->bbs_code_url .'/detail/'. $wr_idx .'/page/'. $page : $this->bbs_code_url .'/lists/page/'. $page,
				'title_desc'    => $title_desc,

				'bo_code'       => $bo_code,
				'wr_idx'        => $wr_idx,
				'page_ttl'      => $page_ttl,
				'page'       => $page,

				'total_cnt_file_form'     => $total_cnt_file_form,
				'total_cnt_file_editor'     => $total_cnt_file_editor,
				'result_file_form'     => $result_file_form,
				'result_file_editor'   => $result_file_editor,

				'img_type_listthumb'   => $img_type_listthumb,
				'img_type_banner'   => $img_type_banner,
				'del_type_listthumb'   => $del_type_listthumb,
				'del_type_banner'   => $del_type_banner,

				'row'           => $row,
				'arr_seg'       => $this->arr_seg, //$this->uri->segment_array(),

				'layout'        => 'sub',
				'menu'          => 'board',
				'last_loc'      => $last_loc,
				//'breadcrumb'    => array('게시판','게시글 관리',$last_loc),
				'breadcrumb' => array('게시판'=>'','게시물 관리'=>'',$last_loc=>''),
				'viewPage'      => 'board/'. $this->bbs_cf->bo_type .'_write_view'
				//'viewPage'      => '_board/skin/'. $this->bbs_cf->bo_type .'_write'. (IS_MOBILE ? '_mobile' : '') .'_view'
			);




			// 캅챠[3/3]
			$this->data['show_captcha'] = isset($data['show_captcha']) ? $data['show_captcha'] : false;;
			$this->data['use_recaptcha'] = isset($data['use_recaptcha']) ? $data['use_recaptcha'] : false;
			$this->data['recaptcha_html'] = isset($data['recaptcha_html']) ? $data['recaptcha_html'] : false;
			$this->data['captcha_html'] = isset($data['captcha_html']) ? $data['captcha_html'] : false;


			/*
			if(IS_MOBILE) {
				$header_add_tag = '<div style="padding:0 15px 30px 15px;">';
				$footer_add_tag = '</div>';

				$this->data['header_add_tag'] = $header_add_tag;
				$this->data['footer_add_tag'] = $footer_add_tag;
			}
			*/

			//$this->load->view('_layout_view', $this->data);


			//$this->data['tpl'] = TPL;
			$this->load->view('admin/layout_view', $this->data);

			/*
			if(IS_MOBILE) {
				$this->load->view('mobile_layout_view', $this->data);
			}
			else {
				$this->load->view('layout_view', $this->data);
			}
			*/

	}


	// 게시글 삭제
	function _bbs_delete($bo_code,$wr_idx=FALSE,$page_ttl='page',$page=1)
	{
			if($this->board_lib->write_delete($bo_code,$wr_idx)) {
				alert('삭제되었습니다.',$this->bbs_code_url .'/lists/page/'. $page);
				//alert('삭제되었습니다.','board/bbs/'.$bo_code.'/lists/page/'. $page);
			}
			else
				alert('삭제되지 못했습니다.');
	}











	/**
	 * Create CAPTCHA image to verify user as a human
	 *
	 * @return	string
	 */

	function _create_captcha()
	{
		$this->load->helper('captcha');


		$arr_cap = array(
			'img_path'		=> './'.$this->config->item('captcha_path', 'tank_auth'),
			'img_url'		=> base_url().$this->config->item('captcha_path', 'tank_auth'),
			'font_path'		=> './'.$this->config->item('captcha_fonts_path', 'tank_auth'),
			'font_size'		=> $this->config->item('captcha_font_size', 'tank_auth'),
			'img_width'		=> $this->config->item('captcha_width', 'tank_auth'),
			'img_height'	=> $this->config->item('captcha_height', 'tank_auth'),
			'show_grid'		=> $this->config->item('captcha_grid', 'tank_auth'),
			'expiration'	=> $this->config->item('captcha_expire', 'tank_auth'),
			'word_length'	=> $this->config->item('captcha_word_length', 'tank_auth'),
			'pool'	=> $this->config->item('captcha_pool', 'tank_auth'),
		);

		/*
		//echo $this->arr_seg[2];
		//echo '<script>alert("'.$this->arr_seg[2].'");</script>';
		if(isset($this->arr_seg[2])) {
			if($this->arr_seg[2] == 'register' OR $this->arr_seg[2] == 'login' OR $this->arr_seg[2] == 'renew_captcha') {
				$arr_cap['img_width']=290;
			}
		}
		*/

		$cap = create_captcha($arr_cap);

		// Save captcha params in session
		$this->session->set_flashdata(array(
				'captcha_word' => $cap['word'],
				'captcha_time' => $cap['time'],
		));

		return $cap['image'];
	}

	// 새로고침
	function renew_captcha()
	{
		echo $this->_create_captcha();
	}




	/**
	 * Callback function. Check if CAPTCHA test is passed.
	 *
	 * @param	string
	 * @return	bool
	 */
	function _check_captcha($code)
	{
		$time = $this->session->flashdata('captcha_time');
		$word = $this->session->flashdata('captcha_word');

		//alert_stay($code. ' / ' .$time. ' / ' .$word);

		list($usec, $sec) = explode(" ", microtime());
		$now = ((float)$usec + (float)$sec);

		if ($now - $time > $this->config->item('captcha_expire', 'tank_auth')) {
			$this->form_validation->set_message('_check_captcha', $this->lang->line('auth_captcha_expired'));
			return FALSE;

		} elseif (($this->config->item('captcha_case_sensitive', 'tank_auth') AND
				$code != $word) OR
				strtolower($code) != strtolower($word)) {
			$this->form_validation->set_message('_check_captcha', $this->lang->line('auth_incorrect_captcha'));
			return FALSE;
		}
		return TRUE;
	}

	/**
	 * Create reCAPTCHA JS and non-JS HTML to verify user as a human
	 *
	 * @return	string
	 */
	function _create_recaptcha()
	{
		$this->load->helper('recaptcha');

		// Add custom theme so we can get only image
		$options = "<script>var RecaptchaOptions = {theme: 'custom', custom_theme_widget: 'recaptcha_widget'};</script>\n";

		// Get reCAPTCHA JS and non-JS HTML
		$html = recaptcha_get_html($this->config->item('recaptcha_public_key', 'tank_auth'), NULL, $this->config->item('use_ssl', 'tank_auth'));

		return $options.$html;
	}

	/**
	 * Callback function. Check if reCAPTCHA test is passed.
	 *
	 * @return	bool
	 */
	function _check_recaptcha()
	{
		$this->load->helper('recaptcha');

		$resp = recaptcha_check_answer($this->config->item('recaptcha_private_key', 'tank_auth'),
				$_SERVER['REMOTE_ADDR'],
				$_POST['recaptcha_challenge_field'],
				$_POST['recaptcha_response_field']);

		if (!$resp->is_valid) {
			$this->form_validation->set_message('_check_recaptcha', $this->lang->line('auth_incorrect_captcha'));
			return FALSE;
		}
		return TRUE;
	}











}