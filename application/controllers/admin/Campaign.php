<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Campaign extends CI_Controller
{
	function __construct()
	{
		parent::__construct();

		$this->load->helper(array('form', 'url','load','security'));
		$this->load->library('form_validation');
		$this->load->library('tank_auth');
		$this->load->library('upload_lib');
		//$this->load->library('pagination');
		$this->load->library('querystring');
		$this->lang->load('tank_auth');

		$this->load->library('campaign_lib');

		$this->username = $this->tank_auth->get_username();
		$this->arr_seg = $this->uri->segment_array();
		/*
		if (!$this->tank_auth->is_admin()  &&  $this->tank_auth->is_logged_in()) {	// 관리자는 아닌데, 로그인 회원인 경우
			$this->tank_auth->logout();
			//alert('관리자로 로그인해주세요.','admin/');
			//alert($this->lang->line('auth_message_admin_page'), 'admin/');
		}
		*/

		// 관리자 로그인 후에만 접속 가능, 그 외에는 메인 페이지로 이동.
		if (! $this->tank_auth->is_admin()) {			// not logged in or activated
			$this->tank_auth->logout();
			redirect('/auth/login/'. url_code( current_url(), 'e'));
		}


		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		// 검수 및 배송상태 갱신 여부 확인
		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		$this->user_idx = $this->tank_auth->get_user_id();
		$ss_update_time = 'ss_update_time_'.$this->user_idx;
		$this->ss_update_chk = 'true';
		if (! $this->session->userdata($ss_update_time)) {
			//$this->session->set_userdata($ss_update_time, time());
			$this->ss_update_chk = 'false';
		}


	}

	function index()
	{

		if ($this->tank_auth->is_admin()) {									// logged in
			//$data['arr_seg'] = $this->arr_seg;
			//$data['viewPage'] = 'admin/user_main_view';
			//$this->load->view('admin/_layout_view', $data);

			//$this->main();
			//redirect('/admin/campaign/main/');
			//redirect('/admin/campaign/donate/lists');
			//redirect(base_url('admin/campaign/donate/lists'));
			redirect(base_url('admin/campaign/donation/cmp_list'));
		}
		elseif($this->tank_auth->is_logged_in()) {
			$this->tank_auth->logout();
			//alert('관리자로 로그인해주세요.','admin/');
			//alert($this->lang->line('auth_message_admin_page'), 'admin/');
		}
		else {
			redirect('/admin/auth/');
		}
	}



	// # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # #

	function main() {


			//redirect(base_url().'admin/campaign/lists');
			//redirect(base_url('admin/campaign/donate/lists'));
			redirect(base_url('admin/campaign/donation/cmp_list'));
			exit;


		// Get data.
			$breadcrumb = array(
				'캠페인'=>base_url().'admin/campaign/main',
				'메인'=>''
			);

			$data = array(
				'arr_seg'   => $this->arr_seg, //$this->uri->segment_array(),
				'breadcrumb'    => $breadcrumb,
				'viewPage'  => 'admin/campaign_main_view'
			);

			$this->load->view('admin/layout_view', $data);
	}


	// # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # #


	// 캠페인 제출
	function submit($cidx) {
		if($this->campaign_lib->_submit($cidx)) {
			alert('제출이 완료되었습니다.','/admin/campaign/detail/'.$cidx.'/submit');
		}
		else {
			redirect(base_url().'admin/campaign/lists/launch');
		}
	}

	// 캠페인 런칭(공개)
	function launch($cidx) {
		if($this->campaign_lib->_launch($cidx)) {
			alert('런칭이 완료되었습니다. \n이제 캠페인이 공개됩니다.','/admin/campaign/detail/'.$cidx.'/launch');
		}
		else {
			redirect(base_url().'admin/campaign/lists/launch');
		}
	}

	// 캠페인 제출상태로 변경
	function reset_submit($cidx) {
		if($this->campaign_lib->_reset_submit($cidx)) {
			alert('제출 상태로 변경되었습니다.','/admin/campaign/detail/'.$cidx.'/submit');
		}
		else {
			redirect(base_url().'admin/campaign/lists/submit');
		}
	}


	// 캠페인 작성상태로 변경
	function reset_write($cidx) {
		if($this->campaign_lib->_reset_write($cidx)) {
			alert('작성 상태로 변경되었습니다.','/admin/campaign/detail/'.$cidx.'/write');
		}
		else {
			redirect(base_url().'admin/campaign/lists/write');
		}
	}



	// 캠페인 삭제
	function adm_del($cidx) {
		if($this->campaign_lib->_adm_del($cidx)) {
			alert('삭제되었습니다.');
		}
		else {
			alert('존재하지 않거나 이미 삭제된 캠페인입니다.');
		}
	}








	// 캠페인 목록
	function lists($state=FALSE) {

		if( ! $state) {
			redirect(base_url().'admin/campaign/lists/submit');
		}


		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		// GET parameter
		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		$this->load->library('querystring', NULL, 'param'); // 쿼리스트링 주소
		$param	  =& $this->param;
	
		// 캠페인 상태
		$sql_where = array('state'=>$state);
		
		// 런칭 캠페인 중 진행중/종료 구분
		if('launch' == $state) :
			$term = $param->get('term',FALSE);
			if('end' == $term) :
				$sql_where['cmp_term_end < '] = TIME_YMD;
			elseif('ing' == $term) :
				$sql_where['cmp_term_end >= '] = TIME_YMD;
			endif;
		endif;


		// 목록 가져오기
		$arr_where = array(
				'sql_select'     => '*',
				'sql_from'       => 'campaign',
				//'sql_where'      => array('state'=>$state),
				'sql_where'      => $sql_where,
				'sql_order_by'   => 'reg_datetime DESC'
		);
		$result = $this->basic_model->arr_get_result($arr_where);

		//print_r($result);
		$list = array();
		$ino = 0;
		foreach($result['qry'] as $key => $row) {

			//print_r($row);
			//echo '<hr /><hr /><hr />';

			$list[$ino] = new stdClass();

			// 번호
			//$num = ($result['total_count'] - $limit*($page-1) - $ino);
			$num = ($result['total_count'] - $ino);
			$list[$ino]->num = $num;

			$list[$ino]->idx = $row->idx;
			$list[$ino]->cmp_cate = $row->cmp_cate;
			$list[$ino]->cmp_title = $row->cmp_title;
			$list[$ino]->cmp_term_begin = $row->cmp_term_begin;
			$list[$ino]->cmp_term_end = $row->cmp_term_end;
			$list[$ino]->cmp_term = $row->cmp_term_begin.'~'.$row->cmp_term_end;
			$list[$ino]->reg_datetime = $row->reg_datetime;
			$list[$ino]->reg_date = substr($row->reg_datetime,0,10);

			$list[$ino]->cmp_org_name = $row->cmp_org_name;
			//$cmp->org_name = isset($row->cmp_org_name) ? $row->cmp_org_name : '';

			$list[$ino]->state = $row->state;
			$btn_type = '';
			$state_str = '작성';
			if('submit' == $row->state) :
				$state_str = '제출';
			elseif('launch' == $row->state) :
				$state_str = '런칭';
				$btn_type = 'btn-primary';
				if( TIME_YMD > $row->cmp_term_end ) :
					$state_str = '종료';
					$btn_type = '';
				endif;
			endif;
			$list[$ino]->state_str = $state_str;
			$list[$ino]->btn_type = $btn_type;


			// 대표이미지(목록 및 캠페인 대표 이미지)
				$arr_where = array(
						'sql_select'     => '*',
						'sql_from'       => 'file_manager',
						'sql_where'      => array('wr_table'=>'campaign','wr_table_idx'=>$row->idx,'upload_type'=>'form','gubun'=>'list','file_type'=>'image'),
						'sql_order_by'   => 'idx DESC',
						'limit'          => 1
				);
				$file_row = $this->basic_model->arr_get_row($arr_where);
				$file_idx = isset($file_row->idx) ? $file_row->idx : '';
				$campaign_main_img = '';
				if(! empty($file_row)) {
					$this->load->helper('resize');
					$img_w = '400';
					$img_h = '300';
					$thumb_src = resize_thumb_image($file_row->file_name, $file_row->file_dir, $file_row->file_dir.'/thumb', $img_w,$img_h,FALSE,'auto','src');
					$campaign_main_src = $thumb_src;
				}
				$list[$ino]->file_idx = $file_idx;
				$list[$ino]->campaign_main_src = $campaign_main_src;




			$ino++;

		}





		// Get data.
			$breadcrumb = array(
				'캠페인'=>base_url().'admin/campaign/lists',
				'목록'=>''
			);

			$data = array(
				'list' => $list,
				'arr_seg'   => $this->arr_seg, //$this->uri->segment_array(),
				'breadcrumb'    => $breadcrumb,
				'viewPage'  => 'admin/campaign_lists_view'
			);

			$this->load->view('admin/layout_view', $data);
	}





	// 캠페인 상세
	function detail($cidx=FALSE) {


		// 캠페인 정보
		$row = array();

		$ctnt_file_idx = array();
		$ctnt_file_img = array();

		if($cidx) {
			// 캠페인 정보
			$arr_where = array(
					'sql_select'     => '*',
					'sql_from'       => 'campaign',
					'sql_where'      => array('idx'=>$cidx)
			);
			$row = $this->basic_model->arr_get_row($arr_where);

			// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
			// 대표이미지(목록 및 캠페인 대표 이미지)
			$arr_where = array(
					'sql_select'     => '*',
					'sql_from'       => 'file_manager',
					'sql_where'      => array('wr_table'=>'campaign','wr_table_idx'=>$row->idx,'upload_type'=>'form','gubun'=>'list','file_type'=>'image'),
					'sql_order_by'   => 'idx DESC',
					'limit'          => 1
			);
			$file_row = $this->basic_model->arr_get_row($arr_where);
			//echo $this->db->last_query();
			if(! empty($file_row)) {
				$this->load->helper('resize');
				$img_w = '750';
				$img_h = '';

				$thumb_img = resize_thumb_image($file_row->file_name, $file_row->file_dir, $file_row->file_dir.'/thumb', $img_w,$img_h,FALSE,'width','img');
				$row->campaign_main_img = $thumb_img;
				$row->file_idx = $file_row->idx;
			}
			//echo $thumb_img.'<<<<';



			// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
			// 캠페인 단락 이미지
				//$this->load->helper('resize');
				$img_w = '800';
				$img_h = '';

				$arr_where = array(
						'sql_select'     => '*',
						'sql_from'       => 'file_manager',
						'sql_where'      => array('wr_table'=>'campaign','wr_table_idx'=>$row->idx,'upload_type'=>'form','file_type'=>'image','gubun'=>'ctnt_img'),
						'sql_order_by'   => 'idx DESC',
						'limit'          => 10
				);
				$file_result = $this->basic_model->arr_get_result($arr_where);
				//echo $this->db->last_query();
				//$ctnt_file_idx = array();
				//$ctnt_file_img = array();
				foreach($file_result['qry'] as $k => $o) {

					$ctnt_file_idx[$o->down_no] = $o->idx;

					//echo $o->file_name.'<<<br />';

					$thumb_img = resize_thumb_image($o->file_name, $o->file_dir, $o->file_dir.'/thumb', $img_w,$img_h,FALSE,'width','img');
					$ctnt_file_img[$o->down_no] = $thumb_img;

					//echo $thumb_img.'<<<<br />';

				}
				//$row->ctnt_file_idx = $ctnt_file_idx;
				//$row->ctnt_file_img = $ctnt_file_img;
		}

		$cmp = new stdClass();

		$cmp->cate = isset($row->cmp_cate) ? $row->cmp_cate : '';
		$cmp->title = isset($row->cmp_title) ? $row->cmp_title : '';
		$cmp->content = isset($row->cmp_content) ? $row->cmp_content : '';
		$goal_money = isset($row->cmp_goal_money) ? intVal($row->cmp_goal_money) : 0;
		$cmp->goal_money = $goal_money;
		$cmp->goal_money_comma = ($goal_money != '') ? number_format($goal_money) : '';

		$goal_money_10000 = ($goal_money > 0) ? intVal($goal_money / 10000) : '';
		$cmp->goal_money_10000 = ($goal_money_10000 != '') ? number_format($goal_money_10000) : '';



		//$cmp->goal_desc = isset($row->cmp_goal_desc) ? nl2br($row->cmp_goal_desc) : '';
		//$goal_desc = '<ul style="font-size: 20px; margin-top: 10px;">';
		$goal_desc = '<ul>';
		if( '' != $row->goal_device_1)	$goal_desc .= '<li>'.$row->goal_device_1;
		if( '' != $row->goal_amt_1)		$goal_desc .= '<span>'.number_format($row->goal_amt_1).'대</span></li>';
		if( '' != $row->goal_device_2)	$goal_desc .= '<li>'.$row->goal_device_2;
		if( '' != $row->goal_amt_2)		$goal_desc .= '<span>'.number_format($row->goal_amt_2).'대</span></li>';
		if( '' != $row->goal_device_3)	$goal_desc .= '<li>'.$row->goal_device_3;
		if( '' != $row->goal_amt_3)		$goal_desc .= '<span>'.number_format($row->goal_amt_3).'대</span></li>';
		if( '' != $row->goal_device_4)	$goal_desc .= '<li>'.$row->goal_device_4;
		if( '' != $row->goal_amt_4)		$goal_desc .= '<span>'.number_format($row->goal_amt_4).'대</span></li>';
		if( '' != $row->goal_device_5)	$goal_desc .= '<li>'.$row->goal_device_5;
		if( '' != $row->goal_amt_5)		$goal_desc .= '<span>'.number_format($row->goal_amt_5).'대</span></li>';
		$goal_desc .= '</ul>';

		$cmp->goal_desc = $goal_desc;



		$cmp->term_begin = isset($row->cmp_term_begin) ? $row->cmp_term_begin : '';
		$cmp->term_end = isset($row->cmp_term_end) ? $row->cmp_term_end : '';
		$cmp->org_name = isset($row->cmp_org_name) ? $row->cmp_org_name : '';
		$cmp->org_info = isset($row->cmp_org_info) ? $row->cmp_org_info : '';
		$cmp->writer_idx = isset($row->writer_idx) ? $row->writer_idx : '';
		$cmp->writer_name = isset($row->writer_name) ? $row->writer_name : '';
		$cmp->state = isset($row->state) ? $row->state : '';

		$cmp->campaign_main_img = isset($row->campaign_main_img) ? $row->campaign_main_img : '';

		$cmp->cmp_website = isset($row->cmp_website) ? $row->cmp_website : '';


		// 캠페인 컨텐츠 단락 정보
		$cmp->ctnt_ttl_1 = isset($row->ctnt_ttl_1) ? $row->ctnt_ttl_1 : '';
		$cmp->ctnt_ttl_2 = isset($row->ctnt_ttl_2) ? $row->ctnt_ttl_2 : '';
		$cmp->ctnt_ttl_3 = isset($row->ctnt_ttl_3) ? $row->ctnt_ttl_3 : '';
		$cmp->ctnt_detail_1 = isset($row->ctnt_detail_1) ? $row->ctnt_detail_1 : '';
		$cmp->ctnt_detail_2 = isset($row->ctnt_detail_2) ? $row->ctnt_detail_2 : '';
		$cmp->ctnt_detail_3 = isset($row->ctnt_detail_3) ? $row->ctnt_detail_3 : '';

		$cmp->ctnt_file_idx = $ctnt_file_idx;
		$cmp->ctnt_file_img = $ctnt_file_img;





		// 캠페인별(주관단체별) 기부가치 합산 금액
		$arr_where_dnval = array(
				'sql_select'     => 'sum(donation_value) as totVal',
				'sql_from'       => 'donation',
				'sql_where'      => array('cmp_code'=>$row->code,'delete'=>NULL),
		);
		$dnval_row = $this->basic_model->arr_get_row($arr_where_dnval);
		$dnval_tot_val = intVal($dnval_row->totVal);
		$cmp->dnval_tot_val = $dnval_tot_val;
		$cmp->dnval_tot_val_txt = ($dnval_tot_val > 0) ? number_format($dnval_tot_val).'원' : '';

		//echo $goal_money.'<<<';
		//echo $cmp->goal_money;

		// 캠페인 진행율
		$goal_per = ($cmp->goal_money > 0) ? intVal($dnval_tot_val / $cmp->goal_money) : 0;
		$cmp->goal_per = $goal_per;
		//echo $goal_per.'<<<<';




		// Get data.
			$breadcrumb = array(
				'캠페인'=>base_url().'admin/campaign/detail',
				'상세'=>''
			);

			$data = array(
				'row' => $row,
				'cmp' => $cmp,
				'arr_seg'   => $this->arr_seg, //$this->uri->segment_array(),
				'breadcrumb'    => $breadcrumb,
				'viewPage'  => 'admin/campaign_detail_view'
			);

			$this->load->view('admin/layout_view', $data);
	}





	// 관리자 캠페인 수정
	/*
	function edit($cidx=FALSE) {
		alert('준비중입니다.');
	}
	*/

	function edit($cidx=FALSE)
	{

		load_js('<script src="'. JS_DIR .'/campaign_script.js"></script>');

		load_css('<link rel="stylesheet" href="'.LIB_DIR.'/datetimepicker-master/jquery.datetimepicker.min.css" />');
		load_js('<script src="'.LIB_DIR.'/datetimepicker-master/jquery.datetimepicker.full.js"></script>');


        //<!-- redactor.css -->
		load_css('<link rel="stylesheet" type="text/css" href="'. ASSETS_DIR .'/lib/editor/redactor/redactor.min.css" />');
    	//<!-- redactor.js -->
		load_js('<script src="'. ASSETS_DIR .'/lib/editor/redactor/redactor.min.js"></script>');
        //<!-- plugin js -->
		load_js('<script src="'. ASSETS_DIR .'/lib/editor/redactor/_plugins/fontsize/fontsize.js"></script>');
		load_js('<script src="'. ASSETS_DIR .'/lib/editor/redactor/_plugins/fontcolor/fontcolor.js"></script>');
		load_js('<script src="'. ASSETS_DIR .'/lib/editor/redactor/_plugins/filemanager/filemanager.js"></script>');
		load_js('<script src="'. ASSETS_DIR .'/lib/editor/redactor/_plugins/imagemanager/imagemanager.js"></script>');
		load_js('<script src="'. ASSETS_DIR .'/lib/editor/redactor/_plugins/table/table.js"></script>');
		load_js('<script src="'. ASSETS_DIR .'/lib/editor/redactor/_plugins/video/video.js"></script>');
		load_js('<script src="'. ASSETS_DIR .'/lib/editor/redactor/_plugins/alignment/alignment.js"></script>');

		load_css('<link rel="stylesheet" type="text/css" href="'. ASSETS_DIR .'/lib/editor/redactor/_plugins/inlinestyle/inlinestyle.css" />');
		load_js('<script src="'. ASSETS_DIR .'/lib/editor/redactor/_plugins/inlinestyle/inlinestyle.js"></script>');

		load_js('<script src="'. ASSETS_DIR .'/lib/editor/redactor/_plugins/specialchars/specialchars.js"></script>');
		load_js('<script src="'. ASSETS_DIR .'/lib/editor/redactor/_plugins/textdirection/textdirection.js"></script>');
		load_js('<script src="'. ASSETS_DIR .'/lib/editor/redactor/_plugins/widget/widget.js"></script>');
		load_js('<script src="'. ASSETS_DIR .'/lib/editor/redactor/_plugins/fontfamily/fontfamily.js"></script>');
		load_js('<script src="'. ASSETS_DIR .'/lib/editor/redactor/_plugins/fullscreen/fullscreen.js"></script>');

		//<!-- connect the languages file -->
		load_js('<script src="'. ASSETS_DIR .'/lib/editor/redactor/_langs/ko.js?v='.time().'"></script>');





		// 캠페인 카테고리 배열
		$arr = array('sql_select' => '*','sql_from' => 'campaign_cate','sql_where' => array('use'=>'Y'), 'sql_order_by'=>'order ASC');
		$result_cate = $this->basic_model->arr_get_result($arr);






		// # 에러 메시지 CSS
		$this->form_validation->set_error_delimiters('<div class="error">','</div>');

		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		// 저장시..
		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

		//$this->form_validation->set_rules('campaign_cate', '캠페인 카테고리', 'trim|required|xss_clean');
		$this->form_validation->set_rules('campaign_cate', '캠페인 카테고리', 'trim|xss_clean');

		$this->form_validation->set_rules('campaign_title', '캠페인 제목', 'trim|required|xss_clean');
		$this->form_validation->set_rules('campaign_content', '캠페인 내용', 'trim');

		//$this->form_validation->set_rules('goal_money', '목표기부가치', 'trim|required|xss_clean');
		$this->form_validation->set_rules('goal_money', '목표기부가치', 'trim|xss_clean');

		//$this->form_validation->set_rules('goal_desc', '목표기기', 'trim|required|xss_clean');
		$this->form_validation->set_rules('term_begin', '모금기간', 'trim|required|xss_clean');
		$this->form_validation->set_rules('term_end', '모금기간', 'trim|required|xss_clean');

		$this->form_validation->set_rules('org_name', '단체명', 'trim|xss_clean');
		$this->form_validation->set_rules('org_desc', '단체소개', 'trim|xss_clean');

		/*
		$this->form_validation->set_rules('ctnt_ttl_1', '캠페인 단락1 제목', 'trim|required|xss_clean');
		$this->form_validation->set_rules('ctnt_detail_1', '캠페인 내용1 제목', 'trim|required|xss_clean');

		$this->form_validation->set_rules('ctnt_ttl_2', '캠페인 단락2 제목', 'trim|required|xss_clean');
		$this->form_validation->set_rules('ctnt_detail_2', '캠페인 내용2 제목', 'trim|required|xss_clean');

		$this->form_validation->set_rules('ctnt_ttl_3', '캠페인 단락3 제목', 'trim|required|xss_clean');
		$this->form_validation->set_rules('ctnt_detail_3', '캠페인 내용3 제목', 'trim|required|xss_clean');
		*/

		if ($this->form_validation->run() !== FALSE) {

			// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
			// 글 작성(새글, 답변글, 수정)시 업로드 파일 저장을 위해 고유 세션 생성
			// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
			$user_idx = $this->tank_auth->get_user_id();
			$ss_write_name = 'ss_file_'.$user_idx;
			if (! $this->session->userdata($ss_write_name)) {
				$this->session->set_userdata($ss_write_name, $user_idx.'_'.time());
			}


			/*
			$goal_device = $this->input->post('goal_device');
			$goal_amt = $this->input->post('goal_amt');
			print_r($goal_device);
			print_r($goal_amt);
			exit;
			*/


			if (!is_null($data = $this->campaign_lib->write($cidx))) {		// success

				// [캠페인 목록 이미지] 폼업로드 파일 저장 처리
				$this->load->library('upload_lib');

				$field_name = 'campaign_main_image';
				$encoded_upload_folder = url_code('campaign/image','e');
				$table = 'campaign';
				$table_idx = $data['idx'];
				$return_data=FALSE;
				$max_upload_size='20480'; // 20MB
				$this->upload_lib->upload_file($field_name,$encoded_upload_folder,$table,$table_idx,'',FALSE,FALSE,$return_data,$max_upload_size,FALSE,FALSE,FALSE);


				// 공통
				$encoded_upload_folder = url_code('campaign/image','e');
				$table = 'campaign';
				$table_idx = $data['idx'];
				$return_data=FALSE;
				$max_upload_size='20480'; // 20MB

				// [캠페인 단락1이미지]
				$field_name = 'campaign_ctnt_image_1';
				$down_no = 1;
				$gubun = 'ctnt_img';
				$this->upload_lib->upload_file($field_name,$encoded_upload_folder,$table,$table_idx,'',FALSE,FALSE,$return_data,$max_upload_size,$down_no,$gubun,FALSE);

				// [캠페인 단락2이미지]
				$field_name = 'campaign_ctnt_image_2';
				$down_no = 2;
				$gubun = 'ctnt_img';
				$this->upload_lib->upload_file($field_name,$encoded_upload_folder,$table,$table_idx,'',FALSE,FALSE,$return_data,$max_upload_size,$down_no,$gubun,FALSE);

				// [캠페인 단락3이미지]
				$field_name = 'campaign_ctnt_image_3';
				$down_no = 3;
				$gubun = 'ctnt_img';
				$this->upload_lib->upload_file($field_name,$encoded_upload_folder,$table,$table_idx,'',FALSE,FALSE,$return_data,$max_upload_size,$down_no,$gubun,FALSE);


				redirect(base_url().'admin/campaign/edit/'.$data['idx']);
			}

		}
		else 
		{

			$row = array();
			$arr_device = array();
			$arr_amt = array();

			if($cidx) {
				// 캠페인 정보
				$arr_where = array(
						'sql_select'     => '*',
						'sql_from'       => 'campaign',
						'sql_where'      => array('idx'=>$cidx)
				);
				$row = $this->basic_model->arr_get_row($arr_where);

				// 목표기기 및 목표수량
				// goal_device_2, goal_amt_2 부터~ 
				// goal_device_1, goal_amt_1 은 추가버튼 등등 미리 출력
				//$arr_device = array();
				//$arr_amt = array();
				$no = 0;
				for($i=1; $i<=5; $i++) {
					$device_nm = 'goal_device_'.$i;
					$amt_nm = 'goal_amt_'.$i;

					if( '' != $row->$device_nm ) {
						$arr_device[$no] = $row->$device_nm ;
						$arr_amt[$no] = $row->$amt_nm ;
						$no++;
					}
				}




				// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
				// 대표이미지(목록 및 캠페인 대표 이미지)
				$arr_where = array(
						'sql_select'     => '*',
						'sql_from'       => 'file_manager',
						'sql_where'      => array('wr_table'=>'campaign','wr_table_idx'=>$row->idx,'upload_type'=>'form','gubun'=>'list','file_type'=>'image'),
						'sql_order_by'   => 'idx DESC',
						'limit'          => 1
				);
				$file_row = $this->basic_model->arr_get_row($arr_where);
				//echo $this->db->last_query();
				if(! empty($file_row)) {
					$this->load->helper('resize');
					$img_w = '750';
					$img_h = '';

					$thumb_img = resize_thumb_image($file_row->file_name, $file_row->file_dir, $file_row->file_dir.'/thumb', $img_w,$img_h,FALSE,'width','img');
					$row->campaign_main_img = $thumb_img;
					$row->file_idx = $file_row->idx;
				}
				//echo $thumb_img.'<<<<';

			}






				// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
				// 캠페인 단락 이미지
				//$this->load->helper('resize');
				$img_w = '800';
				$img_h = '';

				$arr_where = array(
						'sql_select'     => '*',
						'sql_from'       => 'file_manager',
						'sql_where'      => array('wr_table'=>'campaign','wr_table_idx'=>$row->idx,'upload_type'=>'form','file_type'=>'image','gubun'=>'ctnt_img'),
						'sql_order_by'   => 'idx DESC',
						'limit'          => 10
				);
				$file_result = $this->basic_model->arr_get_result($arr_where);
				//echo $this->db->last_query();
				$ctnt_file_idx = array();
				$ctnt_file_img = array();
				foreach($file_result['qry'] as $k => $o) {

					$ctnt_file_idx[$o->down_no] = $o->idx;

					//echo $o->file_name.'<<<br />';

					$thumb_img = resize_thumb_image($o->file_name, $o->file_dir, $o->file_dir.'/thumb', $img_w,$img_h,FALSE,'width','img');
					$ctnt_file_img[$o->down_no] = $thumb_img;

					//echo $thumb_img.'<<<<br />';

				}
				$row->ctnt_file_idx = $ctnt_file_idx;
				$row->ctnt_file_img = $ctnt_file_img;




			// 기부 디바이스 명
			$arr_device_pool = array('노트북','데스크탑','스마트패드','스마트폰');








			// Get data.
			$breadcrumb = array(
				'캠페인'=>base_url().'admin/campaign/lists',
				'수정'=>''
			);

			$data = array(
				'result_cate' => $result_cate,
				'arr_device' => $arr_device,
				'arr_amt' => $arr_amt,
				'row' => $row,
				'arr_seg'   => $this->arr_seg, //$this->uri->segment_array(),
				'breadcrumb'    => $breadcrumb,
				'viewPage'  => 'admin/campaign_edit_view'
			);

			$this->load->view('admin/layout_view', $data);


		}
	}




















	// [2025-10-22] 기부가치 업데이트
	function trans_update_worth_dn() {

		// 캠페인에 들어왔다면,
		$cmp_idx = $this->input->post('cmp_idx');

		// 시작 시간 기록
		$start_time = microtime(true);


		// SQL 작성
		$sql_select = 'dn.*';
		$sql_from = 'donation as dn';
		//$sql_where = array('dn.delete' => NULL, 'dn.idx > '=> 500, 'cmp.state'=>'launch', 'cmp_term_end >= ' => TIME_YMD);
		//$sql_where = array('dn.delete' => NULL, 'dn.idx > '=> 100, 'cmp.state'=>'launch', 'cmp_term_end >= ' => TIME_YMD);
		// handout_finish_date
		$sql_where = array('dn.delete' => NULL, 'dn.idx > '=> 100, 'cmp.state'=>'launch', 'cmp_term_end >= ' => TIME_YMD, 'handout_finish_date !='=>NULL);

		$sql_group_by = FALSE;
		$sql_order_by = 'dn.reg_datetime DESC';
		// 조인
		$sql_join_tbl = 'campaign as cmp';
		$sql_join_on = 'dn.cmp_idx = cmp.idx';
		$sql_join_option = 'LEFT OUTER';

		// 특정 캠페인의 기부내역만 업데이트 하려면
		if( $cmp_idx && '' != $cmp_idx ){
			$sql_where['dn.cmp_idx'] = $cmp_idx;
		}

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
		$dn_result = $this->basic_model->arr_get_result($arr);
		
		//print_r($dn_result['total_count']);
		//exit;


		
		// 반복문 시작
		foreach($dn_result['qry'] as $j => $dn_row) {


				/* - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
				 * 기부가치 업데이트
				 * 검수가 완료($dn_row->check_date != '')된 것들만.
				 */
				if(! IS_NULL($dn_row->check_date) && '' != $dn_row->check_date) {

						$post_url = 'https://ros.remann.co.kr/replus/getInsp'; // ros.remann.co.kr/replus/getInsp

						$cert_key = 'ub9acud50cub7ecuc2a4u0072u006fu0073uc5f0ub3d9';
						$curl_data = array('id'=>$dn_row->idx,'key'=>$cert_key);
						$output_json = $this->curl_post_ros($post_url, $curl_data); // return 등록한 작업요청id값
						$output_arr = json_decode($output_json, true);

						$arr_worth_tbl = $this->config->item('arr_worth_tbl', 'tank_auth');

						$worth_recycle = 0;
						$worth_reuse = 0;

						if( isset($output_arr['data']) && ! empty($output_arr['data']) && ! is_null($output_arr['data'])) {
							foreach ($output_arr['data'] as $i => $item) {
								// print_r($item);

								$itm_insp_kind = $item['insp_kind'];
								$itm_grade = $item['grade'];

								$itm_worth_val = isset($arr_worth_tbl[$itm_insp_kind]->$itm_grade) ? $arr_worth_tbl[$itm_insp_kind]->$itm_grade : 0;

								if('D' == $itm_grade) {
									$worth_recycle += $itm_worth_val;
								}
								else {
									$worth_reuse += $itm_worth_val;
								}
							}
						}

						// 재생대상 기부가치
						$chk_recycle_worth = $worth_recycle;

						// 재활용대상 기부가치
						$chk_reuse_worth = $worth_reuse;

						// 토탈 기부가치평가
						$donation_value = $worth_recycle + $worth_reuse;

						// 업데이트
						$data_worth = array(
							'chk_recycle_worth' => $chk_recycle_worth,
							'chk_reuse_worth' => $chk_reuse_worth,
							'donation_value' => $donation_value
						);
						//if(! empty($data_worth)) {
						if( ($data_worth['donation_value']) > 0 ) {
							$this->campaign_lib->dn_updates($dn_row->idx, $data_worth);
						}

				}


		}


		// 종료 시간 기록
		$end_time = microtime(true);

		// 실행 시간 계산 (초 단위)
		$execution_time = $end_time - $start_time;

		echo "기부가치 상태가 갱신되었습니다.\n\n업데이트 실행 시간: " . $execution_time . " 초";

	}






	// [2025-09-13] 검수 및 배송상태 업데이트
	function trans_update_status_dn() {

		$cmp_idx = $this->input->post('cmp_idx');

		// 시작 시간 기록
		$start_time = microtime(true);


		// sql_join_tbl
		// sql_join_on
		// sql_join_option

		/* */

			$sql_select = 'dn.*';
			$sql_from = 'donation as dn';
			$sql_where = array('dn.delete' => NULL, 'dn.idx > '=> 500, 'cmp.state'=>'launch', 'cmp_term_end >= ' => TIME_YMD);
			$sql_group_by = FALSE;
			$sql_order_by = 'dn.reg_datetime DESC';
			// 조인
			$sql_join_tbl = 'campaign as cmp';
			$sql_join_on = 'dn.cmp_idx = cmp.idx';
			$sql_join_option = 'LEFT OUTER';

			// 특정 캠페인의 기부내역만 업데이트 하려면
			if( $cmp_idx && '' != $cmp_idx ){
				$sql_where['dn.cmp_idx'] = $cmp_idx;
			}

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
			$dn_result = $this->basic_model->arr_get_result($arr);
			//print_r($dn_result['total_count']);
			//exit;


			foreach($dn_result['qry'] as $j => $dn_row) {

				//print_r($dn_row);

				// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
				// ROS에 저장된 진행상황 날짜들 가져오기

				// [2025-09-03] 수거신청을 한 것들만 해당
				if(! is_null($dn_row->cj_return_dt) OR ! is_null($dn_row->pickup_req_date))
				{

					// [2025-09-03] 수거완료 및 검수완료 날짜 가져오기
					if( is_null($dn_row->pickup_date) 
					  OR '' == $dn_row->pickup_date 
					  OR is_null($dn_row->check_date) 
					  OR '' == $dn_row->check_date 
					  OR is_null($dn_row->del_date) 
					  OR '' == $dn_row->del_date) 
					{

							// [개발용 주소] // 로컬 작업용 pc
							//$post_url = 'http://183.99.21.70:8080/replus/getStateDate';  
							// [실제사용주소]
							$post_url = 'https://ros.remann.co.kr/replus/getStateDate'; // ros.remann.co.kr/replus/getStateDate
							$cert_key = 'ub9acud50cub7ecuc2a4u0072u006fu0073uc5f0ub3d9';
							$curl_data = array('id'=>$dn_row->idx,'key'=>$cert_key);
							$output_json = $this->curl_post_ros($post_url, $curl_data); // return 등록한 작업요청id값
							$output_arr = json_decode($output_json, true);

							$whDate = (! empty($output_arr['whDate']) && ! is_null($output_arr['whDate'])) ? $output_arr['whDate'] : '';
							$inspDate = (! empty($output_arr['inspDate']) && ! is_null($output_arr['inspDate'])) ? $output_arr['inspDate'] : '';
							// 검수 > 데이터삭제 건 검수완료 날짜 >>> 데이터삭제보고서 생성 시점
							// 삭제보고서 생성일자
							$delDate = (! empty($output_arr['delDate']) && ! is_null($output_arr['delDate'])) ? $output_arr['delDate'] : '';

							// 만약 실입고 없이 검수로 넘어가면..
							// 그래서 검수날짜는 있는데 수거날짜가 없으면 검수날짜를 수거날짜에도 넣어줘라!
							if('' != $inspDate && '' == $whDate) {
								$whDate = $inspDate;
							}

							// 업데이트
							$data = array();
							// 수거
							if('' != $whDate) {
								$data['pickup_date']=$whDate;
								$dn_row->pickup_date = $whDate;
								$dn_row->state_pickup = 1;
							}
							// 검수
							if('' != $inspDate) {
								$data['check_date']=$inspDate;
								$dn_row->check_date = $inspDate;
								$dn_row->state_check = 1;
							}
							// 삭제보고서
							if('' != $delDate) {
								$data['del_date']=$delDate;
								$dn_row->del_date = $delDate;
								$dn_row->state_del = 1;
							}

							if(! empty($data)) {
								$this->campaign_lib->dn_updates($dn_row->idx, $data);
							}

					}

				}  // if(! is_null($dn_row->cj_return_dt)) 
				// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - 




				// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
				// 택배 물류 추적 tracking
				$tracking_state = $dn_row->cj_tracking_state;

				// [2025-09-03] 1. 수거신청을 한 것들만 해당
				// [2025-09-03] 2. 수거신청을 한 것들 중에서 배송완료 안된 것들만.
				//if(! is_null($dn_row->cj_return_dt) && '배송완료' != $dn_row->cj_tracking_state) {
				if( '02' == $dn_row->cj_tracking_dv_code && '배송완료' == $dn_row->cj_tracking_state ) {

					// [1] 2차 택배 반품까지 완료한 것은 추적 제외합니다제외

				}
				else {

					// [개발용 주소] // 로컬 작업용 pc
					//$post_url = 'http://183.99.21.70:8080/cj/getGdsTrc';  
					// [실제사용주소]
					$post_url = 'https://ros.remann.co.kr/cj/getGdsTrc';
					$curl_data = array('id'=>$dn_row->idx);
					$output_json = $this->curl_post_ros($post_url, $curl_data); // return 등록한 작업요청id값
					//print_r($output_json);
					
					$output_arr = json_decode($output_json, true); // $output_arr['data'][0]

					$trackingData = isset($output_arr['data']) ? end($output_arr['data']) : false;
					//print_r($trackingData);

					// 택배 구분(1차, 2차)
					$rcpt_DV = isset($trackingData['rcpt_DV']) ? $trackingData['rcpt_DV'] : '';

					// 배송상태 코드
					$tracking_code = isset($trackingData['crg_ST']) ? $trackingData['crg_ST'] : '';

					// 배송상태
					$tracking_state = isset($trackingData['crg_ST_NM']) ? $trackingData['crg_ST_NM'] : '';


					$data_trc = array();

					// 업데이트
					if('' != $rcpt_DV) {
						// 1차(택배접수), 2차(반품)
						//$this->campaign_lib->dn_update_tracking($dn_row->idx, $rcpt_DV,'rcpt_DV');
						$data_trc['cj_tracking_dv_code'] = $rcpt_DV;
					}
					// 업데이트
					if('' != $tracking_code) {
						// 추적 상태 코드
						//$this->campaign_lib->dn_update_tracking($dn_row->idx, $tracking_code,'code');
						$data_trc['cj_tracking_code'] = $tracking_code;
					}
					// 업데이트
					if('' != $tracking_state) {
						// 추적 상태명
						//$this->campaign_lib->dn_update_tracking($dn_row->idx, $tracking_state,'state');
						$data_trc['cj_tracking_state'] = $tracking_state;
					}
					
					if($trackingData) {
						// 최신 추적 정보가 앞으로 올 수 있도록 역순 정렬
						$trackingData_reverse = array_reverse($trackingData);
						// 1) 배열 → JSON 변환
						$tracking_json = json_encode($trackingData_reverse, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
						// 2) JSON 비교, 다르면 업데이트
						if ($dn_row->tracking_json !== $tracking_json) {
							//$this->campaign_lib->dn_update_tracking($dn_row->idx, $tracking_json,'tracking_json');
							$data_trc['tracking_json'] = $tracking_json;
							$data_trc['tracking_json_dt'] = TIME_YMDHIS;
						}
					}


					if(! empty($data_trc)) {
						$this->campaign_lib->dn_updates($dn_row->idx, $data_trc);
					}

				}
				// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -








			}




		/* 갱신 시간 업데이트 */
			// 가장 최근 기부건
			$arr_where = array(
					'sql_select'     => '*',
					'sql_from'       => 'donation',
					'sql_where'      => array('idx !='=>''),
					'sql_order_by'   => 'reg_datetime DESC',
					'limit'            => 1
			);
			$row = $this->basic_model->arr_get_row($arr_where);
			if(isset($row->idx) && '' != $row->idx) {
				$data_latest = array();
				$data_latest['latest_update_dt']=TIME_YMDHIS;
				$this->campaign_lib->dn_updates($row->idx, $data_latest);
			}

		// 종료 시간 기록
		$end_time = microtime(true);





		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		// 검수 및 배송상태 갱신 여부 확인
		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		//$user_idx = $this->tank_auth->get_user_id();
		$ss_update_time = 'ss_update_time_'.$this->user_idx;
		//$this->ss_update_chk = true;
		if (! $this->session->userdata($ss_update_time)) {
			$this->session->set_userdata($ss_update_time, time());
			//$this->ss_update_chk = false;
		}




		
		
		// 실행 시간 계산 (초 단위)
		$execution_time = $end_time - $start_time;

		echo "검수 및 배송상태가 갱신되었습니다.\n\n업데이트 실행 시간: " . $execution_time . " 초";


	}






	// # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # #
	// [2025-09-13] 
	// + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + +
	// [기부 관리] 캠페인 목록, 기부 목록
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	function donation($method=FALSE,$cmp_code=FALSE,$donate_idx=FALSE,$dn_user_idx=FALSE) {

		if(! $method) {
			redirect(base_url('admin/campaign/donation/cmp_list'));
		}


		else if('cmp_list' == $method) {
			// [2025-09-12] 기부목록을 보기 전에 캠페인 목록부터.
			$this->donation_cmp_list();
		}
		else if('dn_list' == $method) {
			// [2025-09-12] 선택한 캠페인의 기부자 목록
			$this->donation_dn_list();
		}
		else if('donor' == $method) {
			// [2025-09-12] 선택한 캠페인의 기부자 목록
			$this->donation_dn_donor($cmp_code,$donate_idx,$dn_user_idx);
		}
		else if('report_del_ros' == $method) {
			$this->donation_report_del_ros($cmp_code,$donate_idx);
		}
		else {
			// 기부 관리의 캠페인 목록
			redirect(base_url('admin/campaign/donation/cmp_list'));
		}

	}



	// [2025-09-12] 기부목록을 보기 전에 캠페인 목록부터.
	private function donation_cmp_list() {

		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		// 페이징 정보 
		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		$this->load->library('segment', array('offset'=>5), 'seg'); // 세그먼트 주소( page 위치 )
		$this->load->library('querystring', NULL, 'param'); // 쿼리스트링 주소
		$seg	  =& $this->seg;
		$param	  =& $this->param;


		// 캠페인 상태 (런칭된 캠페인만)
		$sql_where = array('state'=>'launch','del_datetime'=>NULL);
		
		// 런칭 캠페인 중 진행중/종료 구분
		$term = $param->get('term',FALSE);

		// [2025-08-11] 기본적으로 진행중인 것부터 보여준다.
		if(! $term) {
			$term = 'ing';
		}
		if('end' == $term) :
			$sql_where['cmp_term_end < '] = TIME_YMD;
		elseif('ing' == $term) :
			$sql_where['cmp_term_end >= '] = TIME_YMD;
		endif;

		// 페이징
		$limit = 100;
		$page  = $seg->get('page', 1); // 페이지
		if(! isset($page) OR empty($page)) {
			$page = '1';
		}
		$offset = ($page - 1) * $limit;


		// 기부관리 대상 (런칭)캠페인 목록 가져오기
		$arr_where = array(
				'sql_select'     => '*',
				'sql_from'       => 'campaign',
				'sql_where'      => $sql_where,
				'sql_order_by'   => 'reg_datetime DESC',
				'page'             => $page,
				'limit'            => $limit,
				'offset'           => $offset
		);
		$result = $this->basic_model->arr_get_result($arr_where);

		//print_r($result);
		$list = array();
		$ino = 0;
		foreach($result['qry'] as $key => $row) {

			//print_r($row);
			$list[$ino] = new stdClass();

			// 번호
			//$num = ($result['total_count'] - $ino);
			$num = ($result['total_count'] - $limit*($page-1) - $ino);
			$list[$ino]->num = $num;

			$list[$ino]->idx = $row->idx;
			$list[$ino]->cmp_code = $row->code;
			$list[$ino]->cmp_title = $row->cmp_title;
			$list[$ino]->cmp_term_begin = $row->cmp_term_begin;
			$list[$ino]->cmp_term_end = $row->cmp_term_end;
			$list[$ino]->cmp_term = $row->cmp_term_begin.'~'.$row->cmp_term_end;
			$list[$ino]->reg_datetime = $row->reg_datetime;
			$list[$ino]->reg_date = substr($row->reg_datetime,0,10);

			$list[$ino]->cmp_org_name = $row->cmp_org_name;

			$list[$ino]->state = $row->state;
			$state_str = '작성';
			if('submit' == $row->state) :
				$state_str = '제출';
			elseif('launch' == $row->state) :
				$state_str = '런칭';
			endif;
			$list[$ino]->state_str = $state_str;

			$list[$ino]->visit_human = $row->visit_human;
			$list[$ino]->visit_bot = $row->visit_bot;



			// 캠페인별(주관단체별) 기부가치 합산 금액
			$arr_where_dnval = array(
					'sql_select'     => 'sum(donation_value) as totVal',
					'sql_from'       => 'donation',
					'sql_where'      => array('cmp_code'=>$row->code,'delete'=>NULL),
			);
			$dnval_row = $this->basic_model->arr_get_row($arr_where_dnval);
			$dnval_tot_val = $dnval_row->totVal;
			$list[$ino]->dnval_tot_val = ($dnval_tot_val > 0) ? number_format($dnval_tot_val).'원' : '';


			// - - - - - - - - - - - - - - -
			// 접속자 주간 통계를 위한 데이터
			// campaign_visit_week
			// - - - - - - - - - - - - - - -
			// 오늘 날짜
			$today = date('Y-m-d');
			// 오늘 요일 (1: 월요일, 2: 화요일, ..., 7: 일요일)
			$today_weekday = date('w', strtotime($today));
			// 이번 주 월요일 날짜
			$this_monday = date('Y-m-d', strtotime('-' . ($today_weekday - 1) . ' days', strtotime($today)));
			$visit_cnt_week = $this->basic_model->get_common_count('campaign_visit_stat_week', array('date' => $this_monday,'cmp_code' => $row->code));
			$arr_where = array(
					'sql_select'     => '*',
					'sql_from'       => 'campaign_visit_stat_week',
					'sql_where'      => array('date' => $this_monday,'cmp_code' => $row->code)
			);
			$row_week = $this->basic_model->arr_get_row($arr_where);
			$list[$ino]->visit_human_thisweek = isset($row_week->cnt_human) ? $row_week->cnt_human : 0;



			// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
			// [2023-09-22] 새로운 기부신청 개수 확인해서 가져오기
			// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
			// 캠페인 기부 신청 목록 가져오기
			//echo $row->idx ."<br />";
			$arr_where = array(
					'sql_from'       => 'donation',
					'sql_where'      => array('cmp_code'=>$row->code, 'delete'=>NULL, 'mng_chk'=>NULL)
			);
			$dn_new_cnt = $this->basic_model->get_total($arr_where);
			$list[$ino]->dn_new_cnt = $dn_new_cnt;


			// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
			// [2023-09-22] 기부신청 개수 토탈
			// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
			// 캠페인 기부 신청 목록 가져오기
			//echo $row->idx ."<br />";
			$arr_where = array(
					'sql_from'       => 'donation',
					'sql_where'      => array('cmp_code'=>$row->code, 'delete'=>NULL)
			);
			$dn_total_cnt = $this->basic_model->get_total($arr_where);
			$list[$ino]->dn_total_cnt = $dn_total_cnt;



			// 캠페인 기부 신청 목록 가져오기
			//echo $row->idx ."<br />";
			$arr_where = array(
					'sql_select'     => '*',
					'sql_from'       => 'donation',
					'sql_where'      => array('cmp_code'=>$row->code, 'delete'=>NULL),
					'sql_order_by'   => 'cancel ASC, reg_datetime DESC'
			);
			$dn_result = $this->basic_model->arr_get_result($arr_where);

			//print_r($dn_result);
			$dn_list = array();
			$jno = 0;

			$cno = 0; // 취소건 카운트

			foreach($dn_result['qry'] as $j => $dn_row) {

				//print_r($dn_row);

				$dn_list[$jno] = new stdClass();


				
				//$uacc = $this->tank_auth->get_userinfo_idx($dn_row->idx);
				if($dn_row->user_idx > 1000) {
					// 일반 회원
					$uacc = $this->tank_auth->get_userinfo_idx($dn_row->user_idx);
				} else {
					// 관리자
					$uacc = $this->tank_auth->get_admininfo_idx($dn_row->user_idx);
				}
				//print_r($uacc);


				// 처리옵션
				$opt_request_ko = '';
				if(isset($dn_row->opt_request) && 'data_reset' == $dn_row->opt_request) {
					$opt_request_ko = '데이터 삭제';
				}
				else if(isset($dn_row->opt_request) && 'discard' == $dn_row->opt_request) {
					$opt_request_ko = '폐기';
				}


				// 번호
				//$num = ($dn_result['total_count'] - $limit*($page-1) - $jno);
				$dn_num = ($dn_result['total_count'] - $jno);
				$dn_list[$jno]->num = $dn_num;


				// - - - - - - - - - - - - - - - - - -
				// 기부 취소 처리
				// - - - - - - - - - - - - - - - - - -
				// num
				/*
				if('redi' == $row->code) {
				  if( ! is_null($dn_row->cancel) ) {
					$cno++;
				  }
				}
				*/

				if( ! is_null($dn_row->cancel) ) {
					$cno++;
				}



				$dn_list[$jno]->idx = $dn_row->idx;
				$dn_list[$jno]->cmp_code = $dn_row->cmp_code;
				$dn_list[$jno]->user_idx = $dn_row->user_idx;
				$dn_list[$jno]->user_username = $dn_row->user_username;

				$dn_list[$jno]->donor_type = $dn_row->donor_type;
				$dn_list[$jno]->company = $dn_row->company;
				$dn_list[$jno]->donor_name = $dn_row->donor_name;
				$dn_list[$jno]->cellphone = $dn_row->cellphone;
				//$dn_list[$jno]->email = $dn_row->email;
				$dn_list[$jno]->user_email = isset($uacc->email) ? $uacc->email : '';
				$dn_list[$jno]->postcode = $dn_row->postcode;
				$dn_list[$jno]->addr = $dn_row->addr;
				$dn_list[$jno]->addr_detail = $dn_row->addr_detail;

				$dn_list[$jno]->opt_request = $dn_row->opt_request;
				$dn_list[$jno]->opt_request_ko = $opt_request_ko;

				$dn_list[$jno]->pickup_date = $dn_row->pickup_date;
				$dn_list[$jno]->pickup_date_plz = $dn_row->pickup_date_plz;

				$dn_list[$jno]->check_date = $dn_row->check_date;

				$dn_list[$jno]->del_date = $dn_row->del_date;

				$dn_list[$jno]->reg_datetime = $dn_row->reg_datetime;
				$reg_date = substr($dn_row->reg_datetime,0,10);
				$dn_list[$jno]->reg_date = $reg_date;

				$tmp_reg_d = substr($dn_row->reg_datetime,2,8);
				$tmp_reg_t = substr($dn_row->reg_datetime,11,5);
				$tmp_reg_dt = $tmp_reg_d.' <span style="color:#b1b1b1;">'.$tmp_reg_t.'</span>';
				$dn_list[$jno]->reg_dt = $tmp_reg_dt;

				$dn_list[$jno]->reg_ip = $dn_row->reg_ip;

				$dn_list[$jno]->mng_chk = $dn_row->mng_chk;

				$dn_list[$jno]->receipt_req_dt = $dn_row->receipt_req_dt;

				$dn_list[$jno]->donation_value = $dn_row->donation_value;

				
				$dn_list[$jno]->cancel = $dn_row->cancel;
				$dn_list[$jno]->cancel_bg = IS_NULL($dn_row->cancel) ? '' : 'background-color: #eeeeee; ';

				$jno++;
			}

			$list[$ino]->dn_list = $dn_list;

			$ino++;

		}


		// 가장 최근 기부건
			$arr_where = array(
					'sql_select'     => 'idx, latest_update_dt',
					'sql_from'       => 'donation',
					'sql_where'      => array('latest_update_dt !='=>NULL, 'latest_update_dt !='=>''),
					'sql_order_by'   => 'latest_update_dt DESC',
					'limit'            => 1
			);
			$row_latest = $this->basic_model->arr_get_row($arr_where);
			$latest_update = (isset($row_latest->latest_update_dt) && '' != $row_latest->latest_update_dt) ? $row_latest->latest_update_dt : '';



		// Get data.
			$breadcrumb = array(
				'캠페인'=>base_url().'admin/campaign/donate',
				'기부관리'=>''
			);

			$data = array(
				'term' => $term,
				'list' => $list,
				'latest_update' => $latest_update,

				'ss_update_chk' => $this->ss_update_chk,

				'arr_seg'   => $this->arr_seg, //$this->uri->segment_array(),
				'breadcrumb'    => $breadcrumb,
				'viewPage'  => 'admin/campaign_donation_cmp_list_view'
			);

			$this->load->view('admin/layout_view', $data);

	}








	// 원하는 기간 동안에 완료처리 되지 않은 건들의 아이템 정보
	function get_item_dn($date_s='',$date_e='') {

		// 2025년 10월

		$date_s = ('' != $date_s) ? $date_s : '2025-10-01';
		$date_e = ('' != $date_e) ? $date_e : '2025-10-31';

		$date_s .= ' 00:00:00';
		$date_e .= ' 23:59:59';

		$sql = " SELECT dn.*, gd.idx as gd_idx, gd.dn_idx, gd.gd_type, gd.gd_amt, gd.gd_grade FROM `donation` as dn ";
		$sql .= " LEFT OUTER JOIN `donation_goods` as gd ";
		$sql .= " ON dn.idx = gd.dn_idx ";
		$sql .= " WHERE (dn.state_handout_finish != 1 OR dn.state_handout_finish IS NULL) AND dn.`delete` IS NULL AND '".$date_e."' >= dn.reg_datetime AND dn.reg_datetime >= '".$date_s."' ";
		$sql .= " ORDER BY dn.`cmp_code` DESC, dn.`idx`  DESC; ";




		// Result query
		/*
		$query = $this->db->get($arr['sql_from']);
		$result['qry'] = $query->result();
		$result['qry_count'] = $query->num_rows();
		*/

		
		
		
		$query = $this->db->query($sql);
		$result['qry'] = $query->result();
		$result['qry_count'] = $query->num_rows();


		// Get data.
			$data = array(
				'result' => $result,
				'viewPage'  => 'admin/campaign_donation_item_list_view'
			);

			$this->load->view('admin/layout_view', $data);

	}



	// 원하는 기간 동안에 완료처리 되지 않은 건들의 아이템 정보
	function get_worth_monthly($date_s='',$date_e='') {

		// donation_value
		/*

			SELECT
				DATE_FORMAT(reg_datetime, '%Y-%m') AS month,
				donation.cmp_code,
				SUM(donation_value) AS total_value
			FROM donation
			WHERE donation.delete IS NULL AND reg_datetime > '2025-01-01 00:00:00'
			GROUP BY cmp_code, DATE_FORMAT(reg_datetime, '%Y-%m')  
			ORDER BY `month` DESC

		*/



	}





















	// [2025-09-12] 선택한 캠페인의 기부자 목록.
	private function donation_dn_list() {

		// 캠페인 정보
			$cmp_idx=isset($this->arr_seg[5]) ? $this->arr_seg[5]: false;

		// 캠페인 정보
			$arr_where = array(
					'sql_select'     => '*',
					'sql_from'       => 'campaign',
					'sql_where'      => array('idx'=>$cmp_idx)
			);
			$cmp_row = $this->basic_model->arr_get_row($arr_where);
			if(! $cmp_row->idx) {
				alert('존재하지 않거나 삭제된 캠페인입니다.');
				exit;
			}
			else {
				$cmp_row->reg_date = substr($cmp_row->reg_datetime,0,10);
				$cmp_row->cmp_term = $cmp_row->cmp_term_begin.'~'.$cmp_row->cmp_term_end;
			}



			$cmp_term = 'ing';
			if($cmp_row->cmp_term_end < TIME_YMD) {
				$cmp_term = 'end';
			}
			//echo $cmp_term.'<<';



			// 캠페인별(주관단체별) 기부가치 합산 금액
			$arr_where_dnval = array(
					'sql_select'     => 'sum(donation_value) as totVal',
					'sql_from'       => 'donation',
					'sql_where'      => array('cmp_idx'=>$cmp_idx,'delete'=>NULL),
			);
			$dnval_row = $this->basic_model->arr_get_row($arr_where_dnval);
			$dnval_tot_val = $dnval_row->totVal;
			$dnval_tot_comma = ($dnval_tot_val > 0) ? number_format($dnval_tot_val).'원' : '';





		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		// GET parameter
		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
			$this->load->library('querystring', NULL, 'param'); // 쿼리스트링 주소
			$param	  =& $this->param;

		
			// - - - - - - - - - - - - - - - - - - - - - - - - - - -
			// 기부 목록 검색 쿼리
			// - - - - - - - - - - - - - - - - - - - - - - - - - - -
			$sql_where = array('cmp_idx'=>$cmp_idx, 'delete'=>NULL);

			$srh = array();


			// - - - - - - - - - - - - - - - - - - - - - - - - - - -
			// 배송상태(전체, 02:배송완료 ~ 01:집화지시)
			// - - - - - - - - - - - - - - - - - - - - - - - - - - -
			$tracking_dv_code = false;
			$tracking_state = false;
			// - - - - - - - - - - - - - - - - - - - - - - - - - - -


			

			// 이 값이 있으면 검색이므로 취소 건 나오지 않게 처리
			$get__tracking_info = $param->get('tracking_dvcd_state',FALSE);
			//echo $get__tracking_info;
			$srh['get__tracking_info'] = $get__tracking_info;


			$tracking_info = ('all' == $get__tracking_info) ? '' : $get__tracking_info;
			//echo $tracking_info.'<<<';

			$srh['tracking_dvcd_state'] = $tracking_info;
			if('' != $tracking_info) {
				$tracking_arr = explode(':',$tracking_info);
				$tracking_dv_code = isset($tracking_arr[0]) ? $tracking_arr[0] : '';
				$tracking_state = isset($tracking_arr[1]) ? $tracking_arr[1] : '';

				if($tracking_dv_code != ''){
					$sql_where['cj_tracking_dv_code'] = $tracking_dv_code;
				}
				if($tracking_state != ''){
					$sql_where['cj_tracking_state'] = $tracking_state;
				}
			}
			else {
				// 전체
			}


			// - - - - - - - - - - - - - - - - - - - - - - - - - - -
			// 검수 진행상태
			// - - - - - - - - - - - - - - - - - - - - - - - - - - -
			// $srh['tracking_dvcd_state'] = $tracking_info;
			$tracking_cd_state = $param->get('tracking_cd_state',FALSE);
			$srh['tracking_cd_state'] = $tracking_cd_state;

			//echo $tracking_cd_state;

			if('완료' == $tracking_cd_state) {
				$sql_where['state_handout_finish'] = 1;
				$sql_where['handout_finish_date !='] = NULL;
			}
			else if('검수' == $tracking_cd_state) {
				$sql_where['check_date !='] = NULL;
				// 완료 아닌 거
				$sql_where['state_handout_finish'] = NULL;
				$sql_where['handout_finish_date'] = NULL;
			}
			else if('수거' == $tracking_cd_state) {
				$sql_where['pickup_date !='] = NULL;
				// 완료 및 검수가 아닌 거
				$sql_where['check_date'] = NULL;
				$sql_where['state_handout_finish'] = NULL;
				$sql_where['handout_finish_date'] = NULL;

			}
			else if('접수' == $tracking_cd_state) {
				$sql_where['reg_datetime !='] = NULL;

				// 완료 및 검수가 아닌 거
				$sql_where['pickup_date'] = NULL;
				$sql_where['check_date'] = NULL;
				$sql_where['state_handout_finish'] = NULL;
				$sql_where['handout_finish_date'] = NULL;
			}

			/*

						// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
						// [2025-08-22] 기부 완료 처리
						$state_dn_complete = ('1' == $dn_row->state_handout_finish) ? '완료' : '';
						$dn_list[$jno]->state_dn_complete = $state_dn_complete;

						$state_step = '';

						if('1' == $dn_row->state_handout_finish  &&  '' != $dn_row->handout_finish_date) {
							//$state_step = "완료";
							$state_step = '<span class="btn btn-primary btn-xs  allow-select" style="pointer-events: none;">완료</span>';
						}
						else if('' != $dn_row->check_date) {
							// $inspDate
							//$state_step = "검수";
							$state_step = '<span class="btn btn-success btn-xs  allow-select" style="pointer-events: none;">검수</span>';
						}
						else if('' != $dn_row->pickup_date) {
							// $whDate
							//$state_step = "수거";
							$state_step = '<span class="btn btn-secondary btn-xs  allow-select" style="pointer-events: none;">수거</span>';
						}
						else if('' != $dn_row->reg_datetime) {
							//$state_step = "접수";
							$state_step = '<span class="btn btn-outline-secondary btn-xs  allow-select" style="pointer-events: none;">접수</span>';
						}

						$dn_list[$jno]->state_step = $state_step;
			*/






			// - - - - - - - - - - - - - - - - - - - - - - - - - - -
			// 기부 아이디
			// - - - - - - - - - - - - - - - - - - - - - - - - - - -
			$dn_no = false;
			// - - - - - - - - - - - - - - - - - - - - - - - - - - -
			$dn_no = $param->get('dn_no',FALSE);
			$srh['dn_no'] = $dn_no;
			if('' != $dn_no) {
				$sql_where['idx'] = $dn_no;
			}

			// - - - - - - - - - - - - - - - - - - - - - - - - - - -
			// 기부자 이름
			// - - - - - - - - - - - - - - - - - - - - - - - - - - -
			$donor_name = false;
			// - - - - - - - - - - - - - - - - - - - - - - - - - - -
			$donor_name = $param->get('donor_name',FALSE);
			$srh['donor_name'] = $donor_name;
			if('' != $donor_name) {
				//$sql_where['donor_name'] = $donor_name;
				$sql_where['donor_name LIKE '] = '%'.$donor_name.'%';
			}

			// - - - - - - - - - - - - - - - - - - - - - - - - - - -
			// 기부자 연락처
			// - - - - - - - - - - - - - - - - - - - - - - - - - - -
			$donor_phone = false;
			// - - - - - - - - - - - - - - - - - - - - - - - - - - -
			$donor_phone = $param->get('donor_phone',FALSE);
			$srh['donor_phone'] = $donor_phone;
			if('' != $donor_phone) {
				//$sql_where['cellphone'] = $donor_phone;
				$sql_where['cellphone LIKE '] = '%'.$donor_phone.'%';
			}

			// - - - - - - - - - - - - - - - - - - - - - - - - - - -
			// 기간 검색
			// reg_dt, return_dt
			// - - - - - - - - - - - - - - - - - - - - - - - - - - -
			$dt_column = ''; // 기간 검색 선택값
			$dn_srh_dt = $param->get('dn_srh_dt',FALSE);
			$srh_date_start = $param->get('srh_date_start',FALSE);
			$srh_date_end = $param->get('srh_date_end',FALSE);

			$srh['dn_srh_dt'] = $dn_srh_dt;
			$srh['srh_date_start'] = $srh_date_start;
			$srh['srh_date_end'] = $srh_date_end;

			if('' != $dn_srh_dt) {
				if('reg_dt' == $dn_srh_dt) {
					$dt_column = 'reg_datetime';
				}
				else if('return_dt' == $dn_srh_dt) {
					//$dt_column = 'pickup_req_date'; // ROS 수거 완료 일시
					$dt_column = 'cj_return_dt'; // 사용자 신청일시
				}
				if('' != $dt_column && '' != $srh_date_start && '' != $srh_date_end){
					$sql_where[$dt_column.' >='] = $srh_date_start. ' 00:00:00';
					$sql_where[$dt_column.' <='] = $srh_date_end. ' 23:59:59';
				}
			}










		// 캠페인 기부 신청 목록 가져오기
			//echo $row->idx ."<br />";
			$arr_where = array(
					'sql_select'     => '*',
					'sql_from'       => 'donation',
					'sql_where'      => $sql_where,
					//'sql_order_by'   => 'cancel ASC, reg_datetime DESC'
					'sql_order_by'   => 'reg_datetime DESC'
			);
			$dn_result = $this->basic_model->arr_get_result($arr_where);

			// echo $this->db->last_query();

			//print_r($dn_result);
			$dn_list = array();
			$jno = 0;

			$cno = 0; // 취소건 카운트

			foreach($dn_result['qry'] as $j => $dn_row) {

				//print_r($dn_row);

				$dn_list[$jno] = new stdClass();


				
				//$uacc = $this->tank_auth->get_userinfo_idx($dn_row->idx);
				if($dn_row->user_idx > 1000) {
					// 일반 회원
					$uacc = $this->tank_auth->get_userinfo_idx($dn_row->user_idx);
				} else {
					// 관리자
					$uacc = $this->tank_auth->get_admininfo_idx($dn_row->user_idx);
				}
				//print_r($uacc);


				// 처리옵션
				$opt_request_ko = '';
				if(isset($dn_row->opt_request) && 'data_reset' == $dn_row->opt_request) {
					$opt_request_ko = '데이터 삭제';
				}
				else if(isset($dn_row->opt_request) && 'discard' == $dn_row->opt_request) {
					$opt_request_ko = '폐기';
				}


				// 번호
				//$num = ($dn_result['total_count'] - $limit*($page-1) - $jno);
				$dn_num = ($dn_result['total_count'] - $jno);
				$dn_list[$jno]->num = $dn_num;


				// - - - - - - - - - - - - - - - - - -
				// 기부 취소 처리
				// - - - - - - - - - - - - - - - - - -
				// num
				/*
				if('redi' == $cmp_row->code) {
				  if( ! is_null($dn_row->cancel) ) {
					$cno++;
				  }
				}
				*/
				if( ! is_null($dn_row->cancel) ) {
					$cno++;
				}




				$dn_list[$jno]->idx = $dn_row->idx;
				$dn_list[$jno]->cmp_code = $dn_row->cmp_code;
				$dn_list[$jno]->user_idx = $dn_row->user_idx;
				$dn_list[$jno]->user_username = $dn_row->user_username;

				$dn_list[$jno]->donor_type = $dn_row->donor_type;
				$dn_list[$jno]->company = $dn_row->company;
				$dn_list[$jno]->donor_name = $dn_row->donor_name;
				$dn_list[$jno]->cellphone = $dn_row->cellphone;
				//$dn_list[$jno]->email = $dn_row->email;
				$dn_list[$jno]->user_email = isset($uacc->email) ? $uacc->email : '';
				$dn_list[$jno]->postcode = $dn_row->postcode;
				$dn_list[$jno]->addr = $dn_row->addr;
				$dn_list[$jno]->addr_detail = $dn_row->addr_detail;

				$dn_list[$jno]->opt_request = $dn_row->opt_request;
				$dn_list[$jno]->opt_request_ko = $opt_request_ko;

				$dn_list[$jno]->pickup_date = $dn_row->pickup_date;
				$dn_list[$jno]->pickup_date_plz = $dn_row->pickup_date_plz;

				$dn_list[$jno]->check_date = $dn_row->check_date;

				$dn_list[$jno]->del_date = $dn_row->del_date;

				$dn_list[$jno]->reg_datetime = $dn_row->reg_datetime;
				$reg_date = substr($dn_row->reg_datetime,0,10);
				$dn_list[$jno]->reg_date = $reg_date;

				$tmp_reg_d = substr($dn_row->reg_datetime,2,8);
				$tmp_reg_t = substr($dn_row->reg_datetime,11,5);
				$tmp_reg_dt = $tmp_reg_d.' <span style="color:#b1b1b1;">'.$tmp_reg_t.'</span>';
				$dn_list[$jno]->reg_dt = $tmp_reg_dt;

				$dn_list[$jno]->reg_ip = $dn_row->reg_ip;

				$dn_list[$jno]->mng_chk = $dn_row->mng_chk;

				$dn_list[$jno]->receipt_req_dt = $dn_row->receipt_req_dt;

				$dn_list[$jno]->donation_value = $dn_row->donation_value;
				$dn_list[$jno]->donation_val_comma = ($dn_row->donation_value) ? number_format($dn_row->donation_value) : '';

				
				$dn_list[$jno]->cancel = $dn_row->cancel;
				$dn_list[$jno]->cancel_bg = IS_NULL($dn_row->cancel) ? '' : 'background-color: #eeeeee; ';



				// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
				// ROS에 저장된 진행상황 날짜들 가져오기

				/*

				// [2025-09-03] 수거신청을 한 것들만 해당
				if(! is_null($dn_row->cj_return_dt) OR ! is_null($dn_row->pickup_req_date)) {

				  // [2025-09-03] 수거완료 및 검수완료 날짜 가져오기
				  if( is_null($dn_row->pickup_date) OR '' == $dn_row->pickup_date OR is_null($dn_row->check_date) OR '' == $dn_row->check_date OR is_null($dn_row->del_date) OR '' == $dn_row->del_date) {

					// [개발용 주소] // 로컬 작업용 pc
					//$post_url = 'http://183.99.21.70:8080/replus/getStateDate';  
					// [실제사용주소]
					$post_url = 'https://ros.remann.co.kr/replus/getStateDate'; // ros.remann.co.kr/replus/getStateDate
					$cert_key = 'ub9acud50cub7ecuc2a4u0072u006fu0073uc5f0ub3d9';
					$curl_data = array('id'=>$dn_row->idx,'key'=>$cert_key);
					$output_json = $this->curl_post_ros($post_url, $curl_data); // return 등록한 작업요청id값
					$output_arr = json_decode($output_json, true);

					$whDate = (! empty($output_arr['whDate']) && ! is_null($output_arr['whDate'])) ? $output_arr['whDate'] : '';
					$inspDate = (! empty($output_arr['inspDate']) && ! is_null($output_arr['inspDate'])) ? $output_arr['inspDate'] : '';
					// 검수 > 데이터삭제 건 검수완료 날짜 >>> 데이터삭제보고서 생성 시점
					// 삭제보고서 생성일자
					$delDate = (! empty($output_arr['delDate']) && ! is_null($output_arr['delDate'])) ? $output_arr['delDate'] : '';

					// 만약 실입고 없이 검수로 넘어가면..
					// 그래서 검수날짜는 있는데 수거날짜가 없으면 검수날짜를 수거날짜에도 넣어줘라!
					if('' != $inspDate && '' == $whDate) {
						$whDate = $inspDate;
					}

					//echo '[idx] '.$dn_row->idx.'<<<<br />';
					//echo '[수거] '.$whDate.'<<<<<<<br />';
					//echo '[검수] '.$inspDate.'<<<<<<<br />';
					//echo '<hr />';

					// 업데이트
					$data = array();
					if('' != $whDate) {
						$data['pickup_date']=$whDate;
						$dn_row->pickup_date = $whDate;
						$dn_row->state_pickup = 1;
						$dn_list[$jno]->pickup_date = $whDate;
					}
					if('' != $inspDate) {
						$data['check_date']=$inspDate;
						$dn_row->check_date = $inspDate;
						$dn_row->state_check = 1;
						$dn_list[$jno]->check_date = $inspDate;
					}
					if('' != $delDate) {
						$data['del_date']=$delDate;
						$dn_row->del_date = $delDate;
						$dn_row->state_del = 1;
						$dn_list[$jno]->del_date = $delDate;
					}

					if(! empty($data)) {
						$this->campaign_lib->dn_updates($dn_row->idx, $data);
					}

				  }

				}  // if(! is_null($dn_row->cj_return_dt)) 

				*/
				// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - 



				// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
				// [2025-08-22] 기부 완료 처리
				$state_dn_complete = ('1' == $dn_row->state_handout_finish) ? '완료' : '';
				$dn_list[$jno]->state_dn_complete = $state_dn_complete;

				$state_step = '';

				if('1' == $dn_row->state_handout_finish  &&  '' != $dn_row->handout_finish_date) {
					//$state_step = "완료";
					$state_step = '<span class="btn btn-primary btn-xs  allow-select" style="pointer-events: none;">완료</span>';
				}
				else if('' != $dn_row->check_date) {
					// $inspDate
					//$state_step = "검수";
					$state_step = '<span class="btn btn-success btn-xs  allow-select" style="pointer-events: none;">검수</span>';
				}
				else if('' != $dn_row->pickup_date) {
					// $whDate
					//$state_step = "수거";
					$state_step = '<span class="btn btn-secondary btn-xs  allow-select" style="pointer-events: none;">수거</span>';
				}
				else if('' != $dn_row->reg_datetime) {
					//$state_step = "접수";
					$state_step = '<span class="btn btn-outline-secondary btn-xs  allow-select" style="pointer-events: none;">접수</span>';
				}

				$dn_list[$jno]->state_step = $state_step;


				$dn_list[$jno]->cj_book = $dn_row->cj_book;
				$dn_list[$jno]->cj_return = $dn_row->cj_return;

				// 기부신청(reg_datetime 과 같음)
				$dn_list[$jno]->cj_book_dt = substr($dn_row->cj_book_dt,5,11);
				$dn_list[$jno]->cj_book_dt_succ = ($dn_row->cj_book == 'success') ? substr($dn_row->cj_book_dt,5,11) : ''; // substr($row->reg_datetime,0,10);

				// 수거신청
				$dn_list[$jno]->cj_return_dt = ($dn_row->cj_return == 'success') ? substr($dn_row->cj_return_dt,5,11) : '';

				$tmp_return_d = substr($dn_row->cj_return_dt,5,5);
				$tmp_return_t = substr($dn_row->cj_return_dt,11,5);
				$tmp_return_dt = $tmp_return_d.' <span style="color:#b1b1b1;">'.$tmp_return_t.'</span>';
				$dn_list[$jno]->cj_return_dt = $tmp_return_dt;






					// - - - - - - - - - - - - - - - - - - - - - - - - - - -
					// 경사원 캠페인에서 '수거신청' 버튼 노출을 위한 처리
					// - - - - - - - - - - - - - - - - - - - - - - - - - - -
					/*
					$active_return_btn = false;
					$cj_rcpt_dv = '';

					if('redi' != $dn_row->cmp_code) {
						if( $dn_row->cj_return != 'success' ) { // 택배 반품 신청 성공 여부

						}
					}
					*/



				// [1] 디비에 저장된 값
				$dn_list[$jno]->cj_tracking_dv_code = $dn_row->cj_tracking_dv_code;
				$dn_list[$jno]->cj_tracking_dv_code_text = ('' != $dn_row->cj_tracking_dv_code) ? '['.$dn_row->cj_tracking_dv_code.'] ' : '';

				$cj_tracking_no = '';
				if('01' == $dn_row->cj_tracking_dv_code) {
					$cj_tracking_no = '[1차] ';
				}
				else if('02' == $dn_row->cj_tracking_dv_code) {
					$cj_tracking_no = '[2차] ';
				}
				else {
					$cj_tracking_no = '';
				}
				$dn_list[$jno]->cj_tracking_no = $cj_tracking_no;


				// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
				// 택배 물류 추적 tracking
				$tracking_state = $dn_row->cj_tracking_state;
				$dn_list[$jno]->tracking_state = $tracking_state;

				$dn_list[$jno]->rcpt_dv_code = $dn_row->cj_tracking_dv_code;


				/*

				// [2025-09-03] 1. 수거신청을 한 것들만 해당
				// [2025-09-03] 2. 수거신청을 한 것들 중에서 배송완료 안된 것들만.
				if(! is_null($dn_row->cj_return_dt) && '배송완료' != $dn_row->cj_tracking_state) {

					// [개발용 주소] // 로컬 작업용 pc
					//$post_url = 'http://183.99.21.70:8080/cj/getGdsTrc';  
					// [실제사용주소]
					$post_url = 'https://ros.remann.co.kr/cj/getGdsTrc';

					$curl_data = array('id'=>$dn_row->idx);
					//print_r($curl_data);

					$output_json = $this->curl_post_ros($post_url, $curl_data); // return 등록한 작업요청id값
					//print_r($output_json);
					
					$output_arr = json_decode($output_json, true); // $output_arr['data'][0]
					//$output_arr = json_decode($output_json); // $output_arr->data[0]

					//if('112.185.52.193' == REMOTE_ADDR){
					//	print_r($output_arr);
					//	echo '<hr />';
					//}

					//$trackingData = isset($output_arr['data'][0]) ? $output_arr['data'][0] : 'false';
					$trackingData = isset($output_arr['data']) ? end($output_arr['data']) : 'false';
					//print_r($trackingData);


					
					// 택배 구분(1차, 2차)
					$rcpt_DV = isset($trackingData['rcpt_DV']) ? $trackingData['rcpt_DV'] : '';
					$dn_list[$jno]->rcpt_dv_code = '['.$rcpt_DV.']';
					// [2] api 로 가벼올 값이 있으면 그걸로 대체.
					$dn_list[$jno]->cj_tracking_dv_code = ('' != $rcpt_DV) ? '['.$rcpt_DV.'] ' : '';


					// 배송상태 코드
					$tracking_code = isset($trackingData['crg_ST']) ? $trackingData['crg_ST'] : '';
					$dn_list[$jno]->tracking_code = $tracking_code;

					// 배송상태
					$tracking_state = isset($trackingData['crg_ST_NM']) ? $trackingData['crg_ST_NM'] : '';
					//$dn_list[$jno]->tracking_state = $tracking_state;


					// 업데이트
					if('' != $rcpt_DV) {
						// 추적 코드
						$this->campaign_lib->dn_update_tracking($dn_row->idx, $rcpt_DV,'rcpt_DV');
					}
					// 업데이트
					if('' != $tracking_code) {
						// 추적 코드
						$this->campaign_lib->dn_update_tracking($dn_row->idx, $tracking_code,'code');
					}
					if('' != $tracking_state) {
						// 추적 코드
						$this->campaign_lib->dn_update_tracking($dn_row->idx, $tracking_state,'state');
					}

					
				}
				$dn_list[$jno]->tracking_state = $tracking_state;
				*/
				// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -



					/*
					Array ( 
						[id] => 2 
						[no_CLDV_RSN_CD] => 
						[crg_ST] => 01 
						[rcpt_DV] => 01 
						[crg_ST_NM] => 집화지시 
						[dealemp_NM] => 박*업 
						[dealt_BRAN_NM] => 경기포천신내촌 
						[acptr_NM] => 본인 
						[invc_NO] => 685140735832 
						[detail_RSN] => 
						[cust_USE_NO] => 314 
						[scan_YMD] => 20250828 
						[scan_HOUR] => 141915
					)
					*/

					/*
						"crg_ST":"01","rcpt_DV":"01","crg_ST_NM":"집화지시"
						"crg_ST":"11","rcpt_DV":"01","crg_ST_NM":"집화처리"
						"crg_ST":"82","rcpt_DV":"01","crg_ST_NM":"배송출발"
						"crg_ST":"91","rcpt_DV":"01","crg_ST_NM":"배송완료"
					*/




				$jno++;
			}


		// 캠페인 기부 취소건
			$arr_where = array(
					'sql_select'     => '*',
					'sql_from'       => 'donation',
					'sql_where'      => array('cmp_idx'=>$cmp_idx, 'cancel !='=>NULL, 'delete !='=>NULL),
					//'sql_order_by'   => 'cancel ASC, reg_datetime DESC'
					'sql_order_by'   => 'delete DESC'
			);
			$dn_cancel_result = $this->basic_model->arr_get_result($arr_where);
			//print_r($dn_cancel_result);

			foreach($dn_cancel_result['qry'] as $j => $dn_row) {
				//print_r($dn_row);
				// 번호
				//$num = ($dn_result['total_count'] - $limit*($page-1) - $j);
				$dn_num = ($dn_cancel_result['total_count'] - $j);
				$dn_cancel_result['qry'][$j]->num = $dn_num;
			}





		// 가장 최근 기부건
			$arr_where = array(
					'sql_select'     => 'idx, latest_update_dt',
					'sql_from'       => 'donation',
					'sql_where'      => array('latest_update_dt !='=>NULL, 'latest_update_dt !='=>''),
					'sql_order_by'   => 'latest_update_dt DESC',
					'limit'            => 1
			);
			$row_latest = $this->basic_model->arr_get_row($arr_where);
			$latest_update = (isset($row_latest->latest_update_dt) && '' != $row_latest->latest_update_dt) ? $row_latest->latest_update_dt : '';



		// Get data.
			$breadcrumb = array(
				'캠페인'=>base_url().'admin/campaign/donate',
				'기부관리'=>''
			);

			// $dn_cancel_result['qry'] = array();

			$data = array(
				'cmp_row' => $cmp_row,
				'cmp_term' => $cmp_term,
				'dnval_tot_comma' => $dnval_tot_comma,
				'dn_list' => $dn_list,
				'dn_cancel_result' => $dn_cancel_result,
				'srh' => $srh,
				'latest_update' => $latest_update,

				'ss_update_chk' => $this->ss_update_chk,

				'arr_seg'   => $this->arr_seg, //$this->uri->segment_array(),
				'breadcrumb'    => $breadcrumb,
				'viewPage'  => 'admin/campaign_donation_dn_list_view'
			);

			$this->load->view('admin/layout_view', $data);
	}



	// 기부 상세 내역 [처음부터 다시 볼 것..]
	private function donation_dn_donor($cmp_code=FALSE,$donate_idx=FALSE,$user_idx=FALSE) {

			//if(! $donate_idx || ! $user_idx) {
			if(! $donate_idx) {
				//alert('존재하지 않거나 삭제된 캠페인입니다.',base_url().'admin/donate/detail/'.$cmp_code);
				alert('존재하지 않거나 삭제된 캠페인입니다.');
				exit;
			}

			load_css('<link rel="stylesheet" href="'.LIB_DIR.'/datetimepicker-master/jquery.datetimepicker.min.css" />');
			load_js('<script src="'.LIB_DIR.'/datetimepicker-master/jquery.datetimepicker.full.js"></script>');


			// 캠페인 정보
			$arr_where = array(
					'sql_select'     => '*',
					'sql_from'       => 'campaign',
					'sql_where'      => array('code'=>$cmp_code)
			);
			$cmp_row = $this->basic_model->arr_get_row($arr_where);


			// 기부자 정보
			$arr_where = array(
					'sql_select'     => '*',
					'sql_from'       => 'donation',
					'sql_where'      => array('idx'=>$donate_idx, 'delete'=>NULL)
			);
			$dn_row = $this->basic_model->arr_get_row($arr_where);
			//print_r($dn_row);

			if(! isset($dn_row->idx) ) {
				alert('존재하지 않거나 삭제된 기부내역입니다.');
				exit;
			}

			//print_r($dn_row);
			//exit;

			// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
			// 기부 물품 현재 상태
			/*
			$state_good_proc = '접수 중';
			$state_good_proc = ('1' == $dn_row->state_reg) ? '접수 완료' : '접수 중';
			if('' != $dn_row->pickup_date) {
				$state_good_proc = ('1' == $dn_row->state_pickup) ? '수거 완료' : '수거 중';
			}
			if('' != $dn_row->check_date) {
				$state_good_proc = ('1' == $dn_row->state_check) ? '검수 완료' : '검수 중';
			}
			if('' != $dn_row->recycle_date) {
				$state_good_proc = ('1' == $dn_row->state_recycle) ? '재생 완료' : '재생 중';
			}
			if('' != $dn_row->handout_date) {
				$state_good_proc = ('1' == $dn_row->state_handout) ? '나눔 완료' : '나눔 중';
			}
			*/

			// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
			// 기부 물품 현재 상태
			/*
			//$state_good_proc = '접수 중';
			$state_good_proc = '접수 완료';


			if('1' == $dn_row->state_reg  &&  '' != $dn_row->pickup_date) {
				$state_good_proc = ('1' == $dn_row->state_pickup) ? '수거 완료' : '수거 중';
			}
			if('1' == $dn_row->state_pickup &&  '' != $dn_row->check_date) {
				$state_good_proc = ('1' == $dn_row->state_check) ? '검수 완료' : '검수 중';
			}
			if('1' == $dn_row->state_check  &&  '' != $dn_row->recycle_date) {
				$state_good_proc = ('1' == $dn_row->state_recycle) ? '재생 완료' : '재생 중';
			}
			if('1' == $dn_row->state_recycle  &&  '' != $dn_row->handout_date) {
				$state_good_proc = ('1' == $dn_row->state_handout) ? '나눔 완료' : '나눔 중';
			}

			$dn_row->state_good_proc = $state_good_proc;
			*/

			// [2023-05-16] 기부 물품 처리 상황 단계별 잠금 해제
			$arr_dn_disabled = array(
							'pickup'=>' disabled ',
							'check'=>' disabled ',
							'recycle'=>' disabled ',
							'handout'=>' disabled ',
							'handout_finish'=>' disabled ',
			);

			if('1' == $dn_row->state_reg) 
				$arr_dn_disabled['pickup'] = '';
			if('1' == $dn_row->state_pickup) 
				$arr_dn_disabled['check'] = '';
			if('1' == $dn_row->state_check) 
				$arr_dn_disabled['recycle'] = '';
			if('1' == $dn_row->state_recycle) 
				$arr_dn_disabled['handout'] = '';
			if('1' == $dn_row->state_handout) 
				$arr_dn_disabled['handout_finish'] = '';

			/*
			if('1' == $dn_row->state_recycle) {
				$arr_dn_disabled['pickup'] = '';
				$arr_dn_disabled['check'] = '';
				$arr_dn_disabled['recycle'] = '';
				$arr_dn_disabled['handout'] = '';
				//$arr_dn_disabled['handout_finish'] = '';
			}
			elseif('1' == $dn_row->state_check) {
				$arr_dn_disabled['pickup'] = '';
				$arr_dn_disabled['check'] = '';
				$arr_dn_disabled['recycle'] = '';
				//$arr_dn_disabled['handout'] = '';
			}
			elseif('1' == $dn_row->state_pickup) {
				$arr_dn_disabled['pickup'] = '';
				$arr_dn_disabled['check'] = '';
				//$arr_dn_disabled['recycle'] = '';
				//$arr_dn_disabled['handout'] = '';
			}
			elseif('1' == $dn_row->state_reg) {
				$arr_dn_disabled['pickup'] = '';
				//$arr_dn_disabled['check'] = '';
				//$arr_dn_disabled['recycle'] = '';
				//$arr_dn_disabled['handout'] = '';
			}
			*/


			/*
			if('1' == $dn_row->state_reg) {
				$arr_dn_disabled['pickup'] = '';
				//$arr_dn_disabled['check'] = '';
				//$arr_dn_disabled['recycle'] = '';
				//$arr_dn_disabled['handout'] = '';
			}
			elseif('1' == $dn_row->state_pickup) {
				$arr_dn_disabled['pickup'] = '';
				$arr_dn_disabled['check'] = '';
				//$arr_dn_disabled['recycle'] = '';
				//$arr_dn_disabled['handout'] = '';
			}
			elseif('1' == $dn_row->state_check) {
				$arr_dn_disabled['pickup'] = '';
				$arr_dn_disabled['check'] = '';
				$arr_dn_disabled['recycle'] = '';
				//$arr_dn_disabled['handout'] = '';
			}
			elseif('1' == $dn_row->state_recycle) {
				$arr_dn_disabled['pickup'] = '';
				$arr_dn_disabled['check'] = '';
				$arr_dn_disabled['recycle'] = '';
				$arr_dn_disabled['handout'] = '';
				//$arr_dn_disabled['handout_finish'] = '';
			}
			*/



			$arr_donor_type = explode(':',$dn_row->donor_type);
			$donor_type_text = isset($arr_donor_type[1]) ? $arr_donor_type[1] : '';
			$donor_type_code = isset($arr_donor_type[0]) ? $arr_donor_type[0] : '';
			$dn_row->donor_type_text = $donor_type_text;
			$dn_row->donor_type_code = $donor_type_code;

			$dn_row->addr_detail = str_replace('<주소끝>','',$dn_row->addr_detail);




			
			// 처리옵션
			$opt_request_ko = '';
			if(isset($dn_row->opt_request) && 'data_reset' == $dn_row->opt_request) {
				$opt_request_ko = '데이터 삭제';
			}
			else if(isset($dn_row->opt_request) && 'discard' == $dn_row->opt_request) {
				$opt_request_ko = '폐기';
			}
			$dn_row->opt_request_ko = $opt_request_ko;



			// 기부관리 대상 (런칭)캠페인 목록 가져오기
			$arr_where = array(
					'sql_select'     => '*',
					'sql_from'       => 'donation_goods',
					'sql_where'      => array('dn_idx'=>$donate_idx),  // ,'user_idx'=>$user_idx
					'sql_order_by'   => 'idx asc'
			);
			$gd_result = $this->basic_model->arr_get_result($arr_where);




			//print_r($gd_result);
			$dngoods_list = array();
			$ino = 0;
			foreach($gd_result['qry'] as $key => $row) {

				//print_r($row);

				$dngoods_list[$ino] = new stdClass();

				// 번호
				//$num = ($gd_result['total_count'] - $limit*($page-1) - $ino);
				$num = ($gd_result['total_count'] - $ino);
				$dngoods_list[$ino]->num = $num;

				$dngoods_list[$ino]->idx = $row->idx;
				$dngoods_list[$ino]->user_idx = $row->user_idx;
				$dngoods_list[$ino]->dn_idx = $row->dn_idx;

				//$dngoods_list[$ino]->user_username = $row->user_username;

				$dngoods_list[$ino]->gd_type = $row->gd_type;
				$dngoods_list[$ino]->gd_amt = $row->gd_amt;
				$dngoods_list[$ino]->gd_grade = $row->gd_grade;

				$dngoods_list[$ino]->gd_maker = $row->gd_maker;
				$dngoods_list[$ino]->gd_model = $row->gd_model;
				$dngoods_list[$ino]->gd_part = $row->gd_part;
				$dngoods_list[$ino]->gd_memo = $row->gd_memo;

				$dngoods_list[$ino]->reg_datetime = $row->reg_datetime;
				$dngoods_list[$ino]->reg_date = substr($row->reg_datetime,0,10);

				$dngoods_list[$ino]->reg_ip = $row->reg_ip;


				$ino++;

			}





		// 업로드 이미지 정보
			$arr = array(
					'sql_select'     => '*',
					'sql_from'       => 'file_manager',
					'sql_where'      => array('wr_table'=>'donation', 'wr_table_idx'=>$dn_row->idx, 'upload_type' => 'form', 'file_type'=>'image'),
					'sql_order_by'   => 'idx DESC'
			);
			$file_result = $this->basic_model->arr_get_result($arr);
			//print_r($file_result);









			// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
			// ROS에 저장된 진행상황 날짜들 가져오기
				// [개발용 주소] // 로컬 작업용 pc
				//$post_url = 'http://183.99.21.70:8080/replus/getStateDate';  
				// [실제사용주소]
				$post_url = 'https://ros.remann.co.kr/replus/getStateDate'; // ros.remann.co.kr/replus/getStateDate
				$cert_key = 'ub9acud50cub7ecuc2a4u0072u006fu0073uc5f0ub3d9';
				$curl_data = array('id'=>$donate_idx,'key'=>$cert_key);
				$output_json = $this->curl_post_ros($post_url, $curl_data); // return 등록한 작업요청id값
				$output_arr = json_decode($output_json, true);
				//echo $output_json;
				//print_r($output_arr);
				// Array ( [inspDate] => 2025-08-12 [whDate] => )

				$whDate = (! empty($output_arr['whDate']) && ! is_null($output_arr['whDate'])) ? $output_arr['whDate'] : '';
				$inspDate = (! empty($output_arr['inspDate']) && ! is_null($output_arr['inspDate'])) ? $output_arr['inspDate'] : '';

				// 삭제보고서 생성일자
				$delDate = (! empty($output_arr['delDate']) && ! is_null($output_arr['delDate'])) ? $output_arr['delDate'] : '';

				// 만약 실입고 없이 검수로 넘어가면..
				// 그래서 검수날짜는 있는데 수거날짜가 없으면 검수날짜를 수거날짜에도 넣어줘라!
				if('' != $inspDate && '' == $whDate) {
					$whDate = $inspDate;
				}

				
				//$dn_row->whDate = ('' != $whDate) ? $whDate : $dn_row->pickup_date; // pickup_date
				$dn_row->whDate = $whDate;
				
				//$dn_row->inspDate = ('' != $inspDate) ? $inspDate : $dn_row->check_date; // check_date
				$dn_row->inspDate = $inspDate; // check_date
				
				$dn_row->delDate = $delDate;


				// 업데이트
				/*
				if('' != $whDate) {
					// 수거날짜 업데이트
					$this->campaign_lib->dn_update_date($dn_row->idx, $whDate,'pickup_date');

					$dn_row->pickup_date = $whDate;
					$dn_row->state_pickup = 1;
				}
				if('' != $inspDate) {
					// 검수날짜 업데이트
					$this->campaign_lib->dn_update_date($dn_row->idx, $inspDate, 'check_date',);

					$dn_row->check_date = $inspDate;
					$dn_row->state_check = 1;
				}
				*/


				// 업데이트
				$data = array();
				if('' != $whDate) {
					$data['pickup_date']=$whDate;
					$dn_row->pickup_date = $whDate;
					$dn_row->state_pickup = 1;
				}
				if('' != $inspDate) {
					$data['check_date']=$inspDate;
					$dn_row->check_date = $inspDate;
					$dn_row->state_check = 1;
				}
				if('' != $delDate) {
					$data['del_date']=$delDate;
					$dn_row->del_date = $delDate;
					$dn_row->state_del = 1;
				}

				if(! empty($data)) {
					$this->campaign_lib->dn_updates($dn_row->idx, $data);
				}



				/*
				$info_date = new stdClass();
				$info_date->whDate = $whDate;
				$info_date->inspDate = $inspDate;

				// 만약 실입고 없이 검수로 넘어가면..
				// 그래서 검수날짜는 있는데 수거날짜가 없으면 검수날짜를 수거날짜에도 넣어줘라!
				if('' != $info_date->inspDate && '' == $info_date->whDate) {
					$info_date->whDate = $info_date->inspDate;
				}
				*/
			// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -



			// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
				// 기부 물품 현재 상태 renewal
				$state_good_proc = '접수 완료';

				$dn_row->state_accept_txt = '';
				$dn_row->state_pickup_txt = '';
				$dn_row->state_check_txt = '';
				$dn_row->state_delreport_txt = '';

				if('' != $delDate) {
					$state_good_proc = "삭제보고서 생성";

					$dn_row->state_accept_txt = '완료';
					$dn_row->state_pickup_txt = '완료';
					$dn_row->state_check_txt = '완료';
					$dn_row->state_delreport_txt = '완료';
				}

				if('' != $inspDate) {
					$state_good_proc = "검수 완료";

					$dn_row->state_accept_txt = '완료';
					$dn_row->state_pickup_txt = '완료';
					$dn_row->state_check_txt = '완료';
				}
				else if('' != $whDate) {
					$state_good_proc = "수거 완료";

					$dn_row->state_accept_txt = '완료';
					$dn_row->state_pickup_txt = '완료';
					$dn_row->state_check_txt = '';
				}
				else if('' != $dn_row->reg_datetime) {
					$state_good_proc = "접수 완료";

					$dn_row->state_accept_txt = '완료';
					$dn_row->state_pickup_txt = '';
					$dn_row->state_check_txt = '';
				}

				// 현재 진행상태
				$dn_row->state_good_proc = $state_good_proc;
			// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -





			// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
			// ROS에 저장된 상세 검수 현황 가져오기
				// [개발용 주소] // 로컬 작업용 pc
				//$post_url = 'http://183.99.21.70:8080/replus/getInsp';  
				// [실제사용주소]
				$post_url = 'https://ros.remann.co.kr/replus/getInsp'; // ros.remann.co.kr/replus/getInsp

				$cert_key = 'ub9acud50cub7ecuc2a4u0072u006fu0073uc5f0ub3d9';
				$curl_data = array('id'=>$donate_idx,'key'=>$cert_key);
				$output_json = $this->curl_post_ros($post_url, $curl_data); // return 등록한 작업요청id값
				$output_arr = json_decode($output_json, true);
				
				// print_r($curl_data);
				// print_r($output_json);
				// print_r($output_arr);

				
				/* - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
				// [START] 가치
					$arr_worth_tbl = array('데스크탑','노트북','태블릿','스마트폰','기타');
					$arr_worth_tbl['데스크탑'] = new stdClass();
					$arr_worth_tbl['데스크탑']->A = 9200;
					$arr_worth_tbl['데스크탑']->B = 4200;
					$arr_worth_tbl['데스크탑']->C = 4200;
					$arr_worth_tbl['데스크탑']->D = 2000;

					$arr_worth_tbl['노트북'] = new stdClass();
					$arr_worth_tbl['노트북']->A = 23200;
					$arr_worth_tbl['노트북']->B = 13200;
					$arr_worth_tbl['노트북']->C = 13200;
					$arr_worth_tbl['노트북']->D = 2000;

					$arr_worth_tbl['태블릿'] = new stdClass();
					$arr_worth_tbl['태블릿']->A = 19200;
					$arr_worth_tbl['태블릿']->B = 11200;
					$arr_worth_tbl['태블릿']->C = 11200;
					$arr_worth_tbl['태블릿']->D = 1000;

					$arr_worth_tbl['스마트폰'] = new stdClass();
					$arr_worth_tbl['스마트폰']->A = 33200;
					$arr_worth_tbl['스마트폰']->B = 20200;
					$arr_worth_tbl['스마트폰']->C = 20200;
					$arr_worth_tbl['스마트폰']->D = 1000;

					$arr_worth_tbl['기타'] = new stdClass();
					$arr_worth_tbl['기타']->A = 0;
					$arr_worth_tbl['기타']->B = 0;
					$arr_worth_tbl['기타']->C = 0;
					$arr_worth_tbl['기타']->D = 0;
				// [END] 가치
				 - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - */
				$arr_worth_tbl = $this->config->item('arr_worth_tbl', 'tank_auth');



				$item_list = array();
				$arr_worth_val = array('reproduct'=>0, 'recycle'=>0);
				$arr_worth_cnt = array('reproduct'=>0, 'recycle'=>0);

				if( isset($output_arr['data']) && ! empty($output_arr['data']) && ! is_null($output_arr['data'])) {
					foreach ($output_arr['data'] as $i => $item) {
						// print_r($item);
						$item_list[$i] = new stdClass();

						$itm_insp_kind = $item['insp_kind'];
						$itm_grade = $item['grade'];

						$item_list[$i]->insp_kind = $itm_insp_kind;
						$item_list[$i]->mfr = $item['mfr'];
						$item_list[$i]->model = $item['model'];
						$item_list[$i]->sn = $item['sn'];
						$item_list[$i]->registeredDate = $item['registeredDate'];
						$item_list[$i]->rmk_1 = $item['rmk_1'];
						$item_list[$i]->grade = $itm_grade;

						$itm_worth_val = isset($arr_worth_tbl[$itm_insp_kind]->$itm_grade) ? $arr_worth_tbl[$itm_insp_kind]->$itm_grade : 0;
						$itm_worth_cnt = 0;

						if('D' == $itm_grade) {
							$arr_worth_val['recycle'] += $itm_worth_val;
							$arr_worth_cnt['recycle']++;
						}
						else {
							$arr_worth_val['reproduct'] += $itm_worth_val;
							$arr_worth_cnt['reproduct']++;
						}
					}
				}
				//print_r($arr_worth);

				$worth_val_total = array_sum($arr_worth_val);
				//print_r($worth_val_total);





				/*
					// 재생대상 기부가치
					// chk_recycle_worth
					$chk_recycle_worth = $arr_worth_val['recycle'];

					// 재활용대상 기부가치
					// chk_reuse_worth
					$chk_reuse_worth = $arr_worth_val['reproduct'];

					// 토탈 기부가치평가
					// donation_value
					//$donation_value = (($chk_recycle_worth + $chk_reuse_worth) == $worth_val_total) ? $worth_val_total : $worth_val_total;
					$donation_value = $worth_val_total;

					// 업데이트
					$data_worth = array(
						'chk_recycle_worth' => $chk_recycle_worth,
						'chk_reuse_worth' => $chk_reuse_worth,
						'donation_value' => $donation_value
					);
					if(! empty($data_worth)) {
						$this->campaign_lib->dn_updates($dn_row->idx, $data_worth);
					}
				*/

			// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -




			// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
			// ROS에 저장된 상세 검수 현황 가져오기
				// [개발용 주소] // 로컬 작업용 pc
				//$post_url = 'http://183.99.21.70:8080/replus/getDel';  
				// [실제사용주소]
				$post_url = 'https://ros.remann.co.kr/replus/getDel'; // ros.remann.co.kr/replus/getDel

				$cert_key = 'ub9acud50cub7ecuc2a4u0072u006fu0073uc5f0ub3d9';
				$curl_data = array('id'=>$donate_idx,'key'=>$cert_key);
				$output_json = $this->curl_post_ros($post_url, $curl_data); // return 등록한 작업요청id값
				$output_arr = json_decode($output_json, true);

				$report = new stdClass();
				$resData = isset($output_arr['data'][0]) ? $output_arr['data'][0] : false;

				//print_r($resData);

				$download_blancco_link = '';
				$file_path = 'https://ros.remann.co.kr/resources/img/inspDel/';
				if(isset($resData['file_doc1_path']) && '' != $resData['file_doc1_path']) {
					$download_blancco_link = $file_path.$resData['file_doc1_path'];
				}
				//echo $download_blancco_link;
			// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -



			// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
			// 택배 물류 추적 tracking
				// [개발용 주소] // 로컬 작업용 pc
				//$post_url = 'http://183.99.21.70:8080/cj/getGdsTrc';  
				// [실제사용주소]
				$post_url = 'https://ros.remann.co.kr/cj/getGdsTrc';

				$curl_data = array('id'=>$donate_idx);
				$output_json = $this->curl_post_ros($post_url, $curl_data); // return 등록한 작업요청id값
				//print_r($output_json);

				$output_arr = json_decode($output_json, true); // $output_arr['data'][0]
				//$output_arr = json_decode($output_json); // $output_arr->data[0]

				//print_r($output_arr);
				//exit;

				$trackingData = isset($output_arr['data']) ? $output_arr['data'] : false;
				// print_r($trackingData);

				/*
					Array ( [id] => 2 [no_CLDV_RSN_CD] => [crg_ST] => 01 [rcpt_DV] => 01 [crg_ST_NM] => 집화지시 [dealemp_NM] => 박*업 [dealt_BRAN_NM] => 경기포천신내촌 [acptr_NM] => 본인 [invc_NO] => 685140735832 [detail_RSN] => [cust_USE_NO] => 314 [scan_YMD] => 20250828 [scan_HOUR] => 141915 )
					Array ( [id] => 13 [no_CLDV_RSN_CD] => [crg_ST] => 11 [rcpt_DV] => 01 [crg_ST_NM] => 집화처리 [dealemp_NM] => 박*업 [dealt_BRAN_NM] => 경기포천신내촌 [acptr_NM] => 본인 [invc_NO] => 685140735832 [detail_RSN] => [cust_USE_NO] => 314 [scan_YMD] => 20250828 [scan_HOUR] => 142048 )
					Array ( [id] => 20 [no_CLDV_RSN_CD] => [crg_ST] => 82 [rcpt_DV] => 01 [crg_ST_NM] => 배송출발 [dealemp_NM] => 안*윤 [dealt_BRAN_NM] => 하나집배점 [acptr_NM] => 본인 [invc_NO] => 685140735832 [detail_RSN] => [cust_USE_NO] => 314 [scan_YMD] => 20250828 [scan_HOUR] => 142048 )
					Array ( [id] => 31 [no_CLDV_RSN_CD] => [crg_ST] => 91 [rcpt_DV] => 01 [crg_ST_NM] => 배송완료 [dealemp_NM] => 안*윤 [dealt_BRAN_NM] => 하나집배점 [acptr_NM] => 본인 [invc_NO] => 685140735832 [detail_RSN] => [cust_USE_NO] => 314 [scan_YMD] => 20250828 [scan_HOUR] => 142048 )
				*/

				// 배송상태
				//$tracking_state = isset($trackingData['crg_ST_NM']) ? $trackingData['crg_ST_NM'] : '';

				/*
				Array ( 
					[id] => 2 
					[no_CLDV_RSN_CD] => 
					[crg_ST] => 01 
					[rcpt_DV] => 01 
					[crg_ST_NM] => 집화지시 
					[dealemp_NM] => 박*업 
					[dealt_BRAN_NM] => 경기포천신내촌 
					[acptr_NM] => 본인 
					[invc_NO] => 685140735832 
					[detail_RSN] => 
					[cust_USE_NO] => 314 
					[scan_YMD] => 20250828 
					[scan_HOUR] => 141915
				)
				*/


				if($trackingData) {

					// 최신 추적 정보가 앞으로 올 수 있도록 역순 정렬
					$trackingData = array_reverse($trackingData);

					// 1) 배열 → JSON 변환
					$tracking_json = json_encode($trackingData, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

					// 2) JSON 비교, 다르면 업데이트
					if ($dn_row->tracking_json !== $tracking_json) {

						$this->campaign_lib->dn_update_tracking($dn_row->idx, $tracking_json,'tracking_json');

					}

				}



			// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -








		// Get data.
			$breadcrumb = array(
				'캠페인'=>base_url().'admin/campaign/donate',
				'기부목록'=>base_url().'admin/campaign/donate/lists',
				'기부상세정보'=>''
			);

			$data = array(
				'cmp_row' => $cmp_row,
				'dn_row' => $dn_row,
				'dngoods_list' => $dngoods_list,

				'arr_dn_disabled' => $arr_dn_disabled,

				'file_result' => $file_result,

				'item_list' => $item_list,
				'arr_worth_cnt' => $arr_worth_cnt,
				'arr_worth_val' => $arr_worth_val,
				'worth_val_total' => $worth_val_total,

				'download_blancco_link' => $download_blancco_link,

				'trackingData' => $trackingData,

				'arr_seg'   => $this->arr_seg, //$this->uri->segment_array(),
				'breadcrumb'    => $breadcrumb,
				'viewPage'  => 'admin/campaign_donation_dn_donor_view'
				//'viewPage'  => 'admin/campaign_donate_donor_view'
			);

			$this->load->view('admin/layout_view', $data);
	}



	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	// 데이터 완전 삭제 리포트
	// [2025-08-20] ROS 에서 데이터를 받아와서 처리
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	private function donation_report_del_ros($cmp_code=FALSE,$dn_idx=FALSE) {

		if(! $cmp_code) {
			alert('존재하지 않거나 삭제된 캠페인입니다.');
			exit;
		}


		// 캠페인 정보
		$arr_where = array(
				'sql_select'     => '*',
				'sql_from'       => 'campaign',
				'sql_where'      => array('code'=>$cmp_code)
		);
		$cmp_row = $this->basic_model->arr_get_row($arr_where);
		if(! $cmp_row->idx) {
			alert('존재하지 않거나 삭제된 캠페인입니다.');
			exit;
		}

		// 기부 정보
		$arr_where = array(
				'sql_select'     => '*',
				'sql_from'       => 'donation',
				'sql_where'      => array('idx'=>$dn_idx, 'cmp_code'=>$cmp_code)
		);
		$dn_row = $this->basic_model->arr_get_row($arr_where);

		if(! isset($dn_row->idx)) {
			alert('존재하지 않거나 삭제된 기부건입니다.');
			exit;
		}

		//print_r($dn_row);
		$donor_name = isset($dn_row->donor_name) ? $dn_row->donor_name : '';



		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		// ROS에 저장된 상세 검수 현황 가져오기
			// [개발용 주소] // 로컬 작업용 pc
			//$post_url = 'http://183.99.21.70:8080/replus/getInsp';  
			// [실제사용주소]
			$post_url = 'https://ros.remann.co.kr/replus/getDel'; // ros.remann.co.kr/replus/getDel

			$cert_key = 'ub9acud50cub7ecuc2a4u0072u006fu0073uc5f0ub3d9';
			$curl_data = array('id'=>$dn_idx,'key'=>$cert_key);
			$output_json = $this->curl_post_ros($post_url, $curl_data); // return 등록한 작업요청id값
			$output_arr = json_decode($output_json, true);
			
			//print_r($output_arr);

			/*
			if('112.185.52.193' == REMOTE_ADDR OR '116.45.104.200' == REMOTE_ADDR) {
				print_r( isset($output_arr['data'][0]) ? $output_arr['data'][0] : '');
				echo '<hr />';
				print_r( isset($output_arr['data'][1]) ? $output_arr['data'][1] : '');
				echo '<hr />';
				print_r( isset($output_arr['data'][2]) ? $output_arr['data'][2] : '');
				echo '<hr />';
				print_r( isset($output_arr['data'][3]) ? $output_arr['data'][3] : '');
				echo '<hr />';
			}
			*/

			$report = new stdClass();
			$resData = isset($output_arr['data'][0]) ? $output_arr['data'][0] : false;

			$arr_eraseType = array();
			$merged_eraseType = [];
			$arr_eraseType = [];

			$erase_ssn = array();

			if($resData) {

				$res_list = array();

				if( isset($output_arr['data']) && ! empty($output_arr['data']) && ! is_null($output_arr['data'])) {
					foreach ($output_arr['data'] as $i => $res) {
						$res_list[$i] = new stdClass();
						$res_list[$i]->registeredDate = $res['registeredDate'];
						$res_list[$i]->securityofficer = $res['securityofficer'];
						$res_list[$i]->user_nm = $res['user_nm'];
						$res_list[$i]->delk_id = $res['delk_id'];
						$res_list[$i]->erase_type = $res['erase_type'];
						$res_list[$i]->file_kind = isset($res['file_kind']) ? $res['file_kind'] : '';;
						$res_list[$i]->file_nm = isset($res['file_nm']) ? $res['file_nm'] : '';
						$res_list[$i]->ssn = $res['ssn'];

						/*
						if (!in_array($res['erase_type'], $arr_eraseType)) {
							$arr_eraseType[] = $res['erase_type'];   // 또는 array_push($arr_eraseType, $res['erase_type']);
							array_push($arr_eraseType, $res['erase_type']);
						}
						*/

						// explode 후 trim 처리
						$parts = array_map('trim', explode(',', $res['erase_type']));
						$merged_eraseType = array_merge($merged_eraseType, $parts);


						$erase_ssn[$res['erase_type']] = new stdClass();
						$erase_ssn[$res['erase_type']]->ssn = isset($res['ssn']) && '' != $res['ssn'] ?$res['ssn'] : 'N/A (파쇄)';

					}
				}
				//print_r($arr_eraseType); // 디가우징,분쇄,블랑코,천공

				// 중복 제거 후 정렬(optional)
				$arr_eraseType = array_unique($merged_eraseType);
				sort($arr_eraseType);

				$registeredDate = isset($resData['registeredDate']) ? $resData['registeredDate'] : '';
				$registeredDate = substr($registeredDate, 0, 16);
				$report->registeredDate = $registeredDate;

				// delk_id
				$report->delk_id = $resData['delk_id'];

				//$insurance_number = '2025082011-0001';
				$reg_date_number = str_replace(array('-',' ',':'),'',$registeredDate);
				$insurance_number = substr($reg_date_number, 0, 10);

				$ins_no = format_insurance($dn_idx);

				$report->insurance_number = '#'.$insurance_number.'-'.$ins_no;

				$cus_nm = isset($resData['cus_nm']) ? $resData['cus_nm'] : '';
				//$report->cus_nm = $cus_nm;
				// [2025-09-03] 기부 정보에서 기부자 이름을 가져옵니다.
				$report->cus_nm = $donor_name; 

				$user_nm = isset($resData['user_nm']) ? $resData['user_nm'] : '';
				$report->user_nm = $user_nm;

				$securityofficer = isset($resData['securityofficer']) ? $resData['securityofficer'] : '';
				$report->securityofficer = $securityofficer;

				$ssn = isset($resData['ssn']) ? $resData['ssn'] : 'N/A (파쇄에 따른 미확인)';
				$report->ssn = $ssn;

				$report->erase_ssn = $erase_ssn;


				$file_path = 'https://ros.remann.co.kr/resources/img/inspDel/';

				$file_bfr1_path = isset($resData['file_bfr1_path']) ? $file_path.$resData['file_bfr1_path'] : '';
				$file_ing1_path = isset($resData['file_ing1_path']) ? $file_path.$resData['file_ing1_path'] : '';
				$file_aft1_path = isset($resData['file_aft1_path']) ? $file_path.$resData['file_aft1_path'] : '';
				$file_doc1_path = isset($resData['file_doc1_path']) ? $file_path.$resData['file_doc1_path'] : '';
				/*
				echo $file_bfr1_path.'<<<<<br />';
				echo $file_ing1_path.'<<<<<br />';
				echo $file_aft1_path.'<<<<<br />';
				echo $file_doc1_path.'<<<<<br />';
				*/
				$report->file_bfr1_path = $file_bfr1_path;
				$report->file_ing1_path = $file_ing1_path;
				$report->file_aft1_path = $file_aft1_path;
				$report->file_doc1_path = $file_doc1_path;

				$report->file_bfr1_img = ('' != $file_bfr1_path) ? '<img src="'.$file_bfr1_path.'" />' : '';
				$report->file_ing1_img = ('' != $file_ing1_path) ? '<img src="'.$file_ing1_path.'" />' : '';
				$report->file_aft1_img = ('' != $file_aft1_path) ? '<img src="'.$file_aft1_path.'" />' : '';
				$report->file_doc1_img = ('' != $file_doc1_path) ? '<img src="'.$file_doc1_path.'" />' : '';

				$place_del = '리맨본사(포천시)';
				$report->place_del = $place_del;

				$copyText = '© 2025 사회적기업 (주)리맨. All rights reserved.';
				$report->copyText = $copyText;

				// 문서 만든 날짜. 
				// 접속날짜. 오늘 날짜
				$access_date = date('Y년 m월 d일');
				$report->access_date = $access_date;


			}
			else {
				alert('데이터 삭제 보고서가 아직 작성되지 않았습니다. \n검수가 완료된 후 확인하실 수 있습니다.');
			}
		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -




		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		// ROS에 저장된 상세 검수 현황 가져오기
			// [개발용 주소] // 로컬 작업용 pc
			//$post_url = 'http://183.99.21.70:8080/replus/getInsp';  
			// [실제사용주소]
			$post_url = 'https://ros.remann.co.kr/replus/getInsp'; // ros.remann.co.kr/replus/getInsp

			$cert_key = 'ub9acud50cub7ecuc2a4u0072u006fu0073uc5f0ub3d9';
			$curl_data = array('id'=>$dn_idx,'key'=>$cert_key);
			$output_json = $this->curl_post_ros($post_url, $curl_data); // return 등록한 작업요청id값
			$output_arr = json_decode($output_json, true);
			//print_r($output_arr);

			$item_list = array();
			if( isset($output_arr['data']) && ! empty($output_arr['data']) && ! is_null($output_arr['data'])) {
				foreach ($output_arr['data'] as $i => $item) {
					// print_r($item);
					$item_list[$i] = new stdClass();

					$itm_insp_kind = $item['insp_kind'];
					$itm_grade = $item['grade'];

					$item_list[$i]->insp_kind = $itm_insp_kind;
					$item_list[$i]->mfr = $item['mfr'];
					$item_list[$i]->model = $item['model'];
					$item_list[$i]->sn = $item['sn'];
					$item_list[$i]->registeredDate = $item['registeredDate'];
					$item_list[$i]->rmk_1 = $item['rmk_1'];
					$item_list[$i]->grade = $itm_grade;
				}
			}
		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -



		// 페이지
		//$viewPage = 'admin/campaign_donate_report_del_ros_view';
		$viewPage = 'admin/campaign_donation_report_del_ros_view';


		// 데이터 - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		$data = array(
			'cmp_code' =>$cmp_code,
			'dn_idx' =>$dn_idx,
			'cmp_row' => $cmp_row,
			'dn_row' => $dn_row,

			/*
			'dn_del_result' => $dn_del_result,
			'dn_del_row_photo' => $dn_del_row_photo,
			'dn_del_row_cert' => $dn_del_row_cert,
			'cert_file' => $cert_file,
			'cert_file_url' => $cert_file_url,
			*/

			'res_list' => $res_list,
			'item_list' => $item_list,

			'report' => $report,
			'arr_eraseType' => $arr_eraseType,

			'arr_seg' => $this->arr_seg,
			'viewPage' => $viewPage
		);
		$this->load->view('layout_print_view', $data);
	}











	// # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # #


	// + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + +
	// 협의체 회원 전용 캠페인 관리 페이지
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	function donate($method=FALSE,$cmp_code=FALSE,$donate_idx=FALSE,$dn_user_idx=FALSE) 
	{
		if(! $method) {
			redirect(base_url().'admin/campaign/donate/lists');
		}

		if('lists' == $method) {
			$this->donate_lists();
		}
		else if('donor_list' == $method) { // 캠페인별 후원자 목록, 검색 추가(이름/연락처/이메일)
			$this->donate_donor_list();
		}
		else if('donor' == $method) { // 기부 상세 내역 [처음부터 다시 볼 것..]
			$this->donate_donor($cmp_code,$donate_idx,$dn_user_idx);
		}
		else if('donor_del' == $method) { // 기부 상세 내역 삭제
			$this->donate_donor_del($cmp_code,$donate_idx);
		}
		else if('report_check' == $method) {
			$this->donate_report_check($cmp_code,$donate_idx,$dn_user_idx);
		}
		else if('report_del' == $method) {
			// $this->donate_report_del($cmp_code,$donate_idx,$dn_user_idx);
			$this->donate_report_del($cmp_code,$donate_idx);
		}
		else if('report_del_ros' == $method) {
			$this->donate_report_del_ros($cmp_code,$donate_idx);
		}
		else if('report_receipt' == $method) {
			$this->donate_report_receipt($cmp_code,$donate_idx,$dn_user_idx);
		}
		/*
		else if('cmp_list' == $method) {
			// [2025-09-12] 기부목록을 보기 전에 캠페인 목록부터.
			$this->donate_cmp_list();
		}
		else if('cmp_dn_list' == $method) {
			// [2025-09-12] 선택한 캠페인의 기부자 목록
			$this->donate_cmp_dn_list();
		}
		*/

	}


	// [2025-09-12] 기부목록을 보기 전에 캠페인 목록부터.
	function _donate_cmp_list() {

		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		// 페이징 정보 
		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		$this->load->library('segment', array('offset'=>5), 'seg'); // 세그먼트 주소( page 위치 )
		$this->load->library('querystring', NULL, 'param'); // 쿼리스트링 주소
		$seg	  =& $this->seg;
		$param	  =& $this->param;


		// 캠페인 상태 (런칭된 캠페인만)
		$sql_where = array('state'=>'launch','del_datetime'=>NULL);
		
		// 런칭 캠페인 중 진행중/종료 구분
		$term = $param->get('term',FALSE);

		// [2025-08-11] 기본적으로 진행중인 것부터 보여준다.
		if(! $term) {
			$term = 'ing';
		}
		if('end' == $term) :
			$sql_where['cmp_term_end < '] = TIME_YMD;
		elseif('ing' == $term) :
			$sql_where['cmp_term_end >= '] = TIME_YMD;
		endif;

		// 페이징
		$limit = 100;
		$page  = $seg->get('page', 1); // 페이지
		if(! isset($page) OR empty($page)) {
			$page = '1';
		}
		$offset = ($page - 1) * $limit;


		// 기부관리 대상 (런칭)캠페인 목록 가져오기
		$arr_where = array(
				'sql_select'     => '*',
				'sql_from'       => 'campaign',
				'sql_where'      => $sql_where,
				'sql_order_by'   => 'reg_datetime DESC',
				'page'             => $page,
				'limit'            => $limit,
				'offset'           => $offset
		);
		$result = $this->basic_model->arr_get_result($arr_where);

		//print_r($result);
		$list = array();
		$ino = 0;
		foreach($result['qry'] as $key => $row) {

			//print_r($row);
			$list[$ino] = new stdClass();

			// 번호
			//$num = ($result['total_count'] - $ino);
			$num = ($result['total_count'] - $limit*($page-1) - $ino);
			$list[$ino]->num = $num;

			$list[$ino]->idx = $row->idx;
			$list[$ino]->cmp_code = $row->code;
			$list[$ino]->cmp_title = $row->cmp_title;
			$list[$ino]->cmp_term_begin = $row->cmp_term_begin;
			$list[$ino]->cmp_term_end = $row->cmp_term_end;
			$list[$ino]->cmp_term = $row->cmp_term_begin.'~'.$row->cmp_term_end;
			$list[$ino]->reg_datetime = $row->reg_datetime;
			$list[$ino]->reg_date = substr($row->reg_datetime,0,10);

			$list[$ino]->cmp_org_name = $row->cmp_org_name;

			$list[$ino]->state = $row->state;
			$state_str = '작성';
			if('submit' == $row->state) :
				$state_str = '제출';
			elseif('launch' == $row->state) :
				$state_str = '런칭';
			endif;
			$list[$ino]->state_str = $state_str;

			$list[$ino]->visit_human = $row->visit_human;
			$list[$ino]->visit_bot = $row->visit_bot;



			// 캠페인별(주관단체별) 기부가치 합산 금액
			$arr_where_dnval = array(
					'sql_select'     => 'sum(donation_value) as totVal',
					'sql_from'       => 'donation',
					'sql_where'      => array('cmp_code'=>$row->code,'delete'=>NULL),
			);
			$dnval_row = $this->basic_model->arr_get_row($arr_where_dnval);
			$dnval_tot_val = $dnval_row->totVal;
			$list[$ino]->dnval_tot_val = ($dnval_tot_val > 0) ? number_format($dnval_tot_val).'원' : '';


			// - - - - - - - - - - - - - - -
			// 접속자 주간 통계를 위한 데이터
			// campaign_visit_week
			// - - - - - - - - - - - - - - -
			// 오늘 날짜
			$today = date('Y-m-d');
			// 오늘 요일 (1: 월요일, 2: 화요일, ..., 7: 일요일)
			$today_weekday = date('w', strtotime($today));
			// 이번 주 월요일 날짜
			$this_monday = date('Y-m-d', strtotime('-' . ($today_weekday - 1) . ' days', strtotime($today)));
			$visit_cnt_week = $this->basic_model->get_common_count('campaign_visit_stat_week', array('date' => $this_monday,'cmp_code' => $row->code));
			$arr_where = array(
					'sql_select'     => '*',
					'sql_from'       => 'campaign_visit_stat_week',
					'sql_where'      => array('date' => $this_monday,'cmp_code' => $row->code)
			);
			$row_week = $this->basic_model->arr_get_row($arr_where);
			$list[$ino]->visit_human_thisweek = isset($row_week->cnt_human) ? $row_week->cnt_human : 0;



			// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
			// [2023-09-22] 새로운 기부신청 개수 확인해서 가져오기
			// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
			// 캠페인 기부 신청 목록 가져오기
			//echo $row->idx ."<br />";
			$arr_where = array(
					'sql_from'       => 'donation',
					'sql_where'      => array('cmp_code'=>$row->code, 'delete'=>NULL, 'mng_chk'=>NULL)
			);
			$dn_new_cnt = $this->basic_model->get_total($arr_where);
			$list[$ino]->dn_new_cnt = $dn_new_cnt;


			// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
			// [2023-09-22] 기부신청 개수 토탈
			// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
			// 캠페인 기부 신청 목록 가져오기
			//echo $row->idx ."<br />";
			$arr_where = array(
					'sql_from'       => 'donation',
					'sql_where'      => array('cmp_code'=>$row->code, 'delete'=>NULL)
			);
			$dn_total_cnt = $this->basic_model->get_total($arr_where);
			$list[$ino]->dn_total_cnt = $dn_total_cnt;



			// 캠페인 기부 신청 목록 가져오기
			//echo $row->idx ."<br />";
			$arr_where = array(
					'sql_select'     => '*',
					'sql_from'       => 'donation',
					'sql_where'      => array('cmp_code'=>$row->code, 'delete'=>NULL),
					'sql_order_by'   => 'cancel ASC, reg_datetime DESC'
			);
			$dn_result = $this->basic_model->arr_get_result($arr_where);

			//print_r($dn_result);
			$dn_list = array();
			$jno = 0;

			$cno = 0; // 취소건 카운트

			foreach($dn_result['qry'] as $j => $dn_row) {

				//print_r($dn_row);

				$dn_list[$jno] = new stdClass();


				
				//$uacc = $this->tank_auth->get_userinfo_idx($dn_row->idx);
				if($dn_row->user_idx > 1000) {
					// 일반 회원
					$uacc = $this->tank_auth->get_userinfo_idx($dn_row->user_idx);
				} else {
					// 관리자
					$uacc = $this->tank_auth->get_admininfo_idx($dn_row->user_idx);
				}
				//print_r($uacc);


				// 처리옵션
				$opt_request_ko = '';
				if(isset($dn_row->opt_request) && 'data_reset' == $dn_row->opt_request) {
					$opt_request_ko = '데이터 삭제';
				}
				else if(isset($dn_row->opt_request) && 'discard' == $dn_row->opt_request) {
					$opt_request_ko = '폐기';
				}


				// 번호
				//$num = ($dn_result['total_count'] - $limit*($page-1) - $jno);
				$dn_num = ($dn_result['total_count'] - $jno);
				$dn_list[$jno]->num = $dn_num;


				// - - - - - - - - - - - - - - - - - -
				// 기부 취소 처리
				// - - - - - - - - - - - - - - - - - -
				// num
				/*
				if('redi' == $row->code) {
				  if( ! is_null($dn_row->cancel) ) {
					$cno++;
				  }
				}
				*/
				if( ! is_null($dn_row->cancel) ) {
					$cno++;
				}




				$dn_list[$jno]->idx = $dn_row->idx;
				$dn_list[$jno]->cmp_code = $dn_row->cmp_code;
				$dn_list[$jno]->user_idx = $dn_row->user_idx;
				$dn_list[$jno]->user_username = $dn_row->user_username;

				$dn_list[$jno]->donor_type = $dn_row->donor_type;
				$dn_list[$jno]->company = $dn_row->company;
				$dn_list[$jno]->donor_name = $dn_row->donor_name;
				$dn_list[$jno]->cellphone = $dn_row->cellphone;
				//$dn_list[$jno]->email = $dn_row->email;
				$dn_list[$jno]->user_email = isset($uacc->email) ? $uacc->email : '';
				$dn_list[$jno]->postcode = $dn_row->postcode;
				$dn_list[$jno]->addr = $dn_row->addr;
				$dn_list[$jno]->addr_detail = $dn_row->addr_detail;

				$dn_list[$jno]->opt_request = $dn_row->opt_request;
				$dn_list[$jno]->opt_request_ko = $opt_request_ko;

				$dn_list[$jno]->pickup_date = $dn_row->pickup_date;
				$dn_list[$jno]->pickup_date_plz = $dn_row->pickup_date_plz;

				$dn_list[$jno]->check_date = $dn_row->check_date;

				$dn_list[$jno]->del_date = $dn_row->del_date;

				$dn_list[$jno]->reg_datetime = $dn_row->reg_datetime;
				$reg_date = substr($dn_row->reg_datetime,0,10);
				$dn_list[$jno]->reg_date = $reg_date;

				$tmp_reg_d = substr($dn_row->reg_datetime,2,8);
				$tmp_reg_t = substr($dn_row->reg_datetime,11,5);
				$tmp_reg_dt = $tmp_reg_d.' <span style="color:#b1b1b1;">'.$tmp_reg_t.'</span>';
				$dn_list[$jno]->reg_dt = $tmp_reg_dt;

				$dn_list[$jno]->reg_ip = $dn_row->reg_ip;

				$dn_list[$jno]->mng_chk = $dn_row->mng_chk;

				$dn_list[$jno]->receipt_req_dt = $dn_row->receipt_req_dt;

				$dn_list[$jno]->donation_value = $dn_row->donation_value;

				
				$dn_list[$jno]->cancel = $dn_row->cancel;
				$dn_list[$jno]->cancel_bg = IS_NULL($dn_row->cancel) ? '' : 'background-color: #eeeeee; ';

				$jno++;
			}

			$list[$ino]->dn_list = $dn_list;

			$ino++;

		}


		// Get data.
			$breadcrumb = array(
				'캠페인'=>base_url().'admin/campaign/donate',
				'기부관리'=>''
			);

			$data = array(
				'term' => $term,
				'list' => $list,
				'arr_seg'   => $this->arr_seg, //$this->uri->segment_array(),
				'breadcrumb'    => $breadcrumb,
				'viewPage'  => 'admin/campaign_donate_cmp_list_view'
			);

			$this->load->view('admin/layout_view', $data);

	}




	// [2025-09-12] 선택한 캠페인의 기부자 목록.
	function _donate_cmp_dn_list() {

		//$cmp_idx=false;
		$cmp_idx=isset($this->arr_seg[5]) ? $this->arr_seg[5]: false;

		// 캠페인 정보
			$arr_where = array(
					'sql_select'     => '*',
					'sql_from'       => 'campaign',
					'sql_where'      => array('idx'=>$cmp_idx)
			);
			$cmp_row = $this->basic_model->arr_get_row($arr_where);

			if(! $cmp_row->idx) {
				alert('존재하지 않거나 삭제된 캠페인입니다.');
				exit;
			}
			else {

				$cmp_row->reg_date = substr($cmp_row->reg_datetime,0,10);
				$cmp_row->cmp_term = $cmp_row->cmp_term_begin.'~'.$cmp_row->cmp_term_end;


			}



		// 캠페인 기부 신청 목록 가져오기
			//echo $row->idx ."<br />";
			$arr_where = array(
					'sql_select'     => '*',
					'sql_from'       => 'donation',
					'sql_where'      => array('cmp_idx'=>$cmp_idx, 'delete'=>NULL),
					//'sql_order_by'   => 'cancel ASC, reg_datetime DESC'
					'sql_order_by'   => 'reg_datetime DESC'
			);
			$dn_result = $this->basic_model->arr_get_result($arr_where);

			//print_r($dn_result);
			$dn_list = array();
			$jno = 0;

			$cno = 0; // 취소건 카운트

			foreach($dn_result['qry'] as $j => $dn_row) {

				//print_r($dn_row);

				$dn_list[$jno] = new stdClass();


				
				//$uacc = $this->tank_auth->get_userinfo_idx($dn_row->idx);
				if($dn_row->user_idx > 1000) {
					// 일반 회원
					$uacc = $this->tank_auth->get_userinfo_idx($dn_row->user_idx);
				} else {
					// 관리자
					$uacc = $this->tank_auth->get_admininfo_idx($dn_row->user_idx);
				}
				//print_r($uacc);


				// 처리옵션
				$opt_request_ko = '';
				if(isset($dn_row->opt_request) && 'data_reset' == $dn_row->opt_request) {
					$opt_request_ko = '데이터 삭제';
				}
				else if(isset($dn_row->opt_request) && 'discard' == $dn_row->opt_request) {
					$opt_request_ko = '폐기';
				}


				// 번호
				//$num = ($dn_result['total_count'] - $limit*($page-1) - $jno);
				$dn_num = ($dn_result['total_count'] - $jno);
				$dn_list[$jno]->num = $dn_num;


				// - - - - - - - - - - - - - - - - - -
				// 기부 취소 처리
				// - - - - - - - - - - - - - - - - - -
				// num
				/*
				if('redi' == $cmp_row->code) {
				  if( ! is_null($dn_row->cancel) ) {
					$cno++;
				  }
				}
				*/
				if( ! is_null($dn_row->cancel) ) {
					$cno++;
				}




				$dn_list[$jno]->idx = $dn_row->idx;
				$dn_list[$jno]->cmp_code = $dn_row->cmp_code;
				$dn_list[$jno]->user_idx = $dn_row->user_idx;
				$dn_list[$jno]->user_username = $dn_row->user_username;

				$dn_list[$jno]->donor_type = $dn_row->donor_type;
				$dn_list[$jno]->company = $dn_row->company;
				$dn_list[$jno]->donor_name = $dn_row->donor_name;
				$dn_list[$jno]->cellphone = $dn_row->cellphone;
				//$dn_list[$jno]->email = $dn_row->email;
				$dn_list[$jno]->user_email = isset($uacc->email) ? $uacc->email : '';
				$dn_list[$jno]->postcode = $dn_row->postcode;
				$dn_list[$jno]->addr = $dn_row->addr;
				$dn_list[$jno]->addr_detail = $dn_row->addr_detail;

				$dn_list[$jno]->opt_request = $dn_row->opt_request;
				$dn_list[$jno]->opt_request_ko = $opt_request_ko;

				$dn_list[$jno]->pickup_date = $dn_row->pickup_date;
				$dn_list[$jno]->pickup_date_plz = $dn_row->pickup_date_plz;

				$dn_list[$jno]->check_date = $dn_row->check_date;

				$dn_list[$jno]->del_date = $dn_row->del_date;

				$dn_list[$jno]->reg_datetime = $dn_row->reg_datetime;
				$reg_date = substr($dn_row->reg_datetime,0,10);
				$dn_list[$jno]->reg_date = $reg_date;

				$tmp_reg_d = substr($dn_row->reg_datetime,2,8);
				$tmp_reg_t = substr($dn_row->reg_datetime,11,5);
				$tmp_reg_dt = $tmp_reg_d.' <span style="color:#b1b1b1;">'.$tmp_reg_t.'</span>';
				$dn_list[$jno]->reg_dt = $tmp_reg_dt;

				$dn_list[$jno]->reg_ip = $dn_row->reg_ip;

				$dn_list[$jno]->mng_chk = $dn_row->mng_chk;

				$dn_list[$jno]->receipt_req_dt = $dn_row->receipt_req_dt;

				$dn_list[$jno]->donation_value = $dn_row->donation_value;

				
				$dn_list[$jno]->cancel = $dn_row->cancel;
				$dn_list[$jno]->cancel_bg = IS_NULL($dn_row->cancel) ? '' : 'background-color: #eeeeee; ';



				// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
				// ROS에 저장된 진행상황 날짜들 가져오기

				// [2025-09-03] 수거신청을 한 것들만 해당
				if(! is_null($dn_row->cj_return_dt) OR ! is_null($dn_row->pickup_req_date)) {

				  // [2025-09-03] 수거완료 및 검수완료 날짜 가져오기
				  if( is_null($dn_row->pickup_date) OR '' == $dn_row->pickup_date OR is_null($dn_row->check_date) OR '' == $dn_row->check_date OR is_null($dn_row->del_date) OR '' == $dn_row->del_date) {

					// [개발용 주소] // 로컬 작업용 pc
					//$post_url = 'http://183.99.21.70:8080/replus/getStateDate';  
					// [실제사용주소]
					$post_url = 'https://ros.remann.co.kr/replus/getStateDate'; // ros.remann.co.kr/replus/getStateDate
					$cert_key = 'ub9acud50cub7ecuc2a4u0072u006fu0073uc5f0ub3d9';
					$curl_data = array('id'=>$dn_row->idx,'key'=>$cert_key);
					$output_json = $this->curl_post_ros($post_url, $curl_data); // return 등록한 작업요청id값
					$output_arr = json_decode($output_json, true);

					$whDate = (! empty($output_arr['whDate']) && ! is_null($output_arr['whDate'])) ? $output_arr['whDate'] : '';
					$inspDate = (! empty($output_arr['inspDate']) && ! is_null($output_arr['inspDate'])) ? $output_arr['inspDate'] : '';
					// 검수 > 데이터삭제 건 검수완료 날짜 >>> 데이터삭제보고서 생성 시점
					// 삭제보고서 생성일자
					$delDate = (! empty($output_arr['delDate']) && ! is_null($output_arr['delDate'])) ? $output_arr['delDate'] : '';

					// 만약 실입고 없이 검수로 넘어가면..
					// 그래서 검수날짜는 있는데 수거날짜가 없으면 검수날짜를 수거날짜에도 넣어줘라!
					if('' != $inspDate && '' == $whDate) {
						$whDate = $inspDate;
					}

					/*
					echo '[idx] '.$dn_row->idx.'<<<<br />';
					echo '[수거] '.$whDate.'<<<<<<<br />';
					echo '[검수] '.$inspDate.'<<<<<<<br />';
					echo '<hr />';
					*/

					// 업데이트
					$data = array();
					if('' != $whDate) {
						$data['pickup_date']=$whDate;
						$dn_row->pickup_date = $whDate;
						$dn_row->state_pickup = 1;
						$dn_list[$jno]->pickup_date = $whDate;
					}
					if('' != $inspDate) {
						$data['check_date']=$inspDate;
						$dn_row->check_date = $inspDate;
						$dn_row->state_check = 1;
						$dn_list[$jno]->check_date = $inspDate;
					}
					if('' != $delDate) {
						$data['del_date']=$delDate;
						$dn_row->del_date = $delDate;
						$dn_row->state_del = 1;
						$dn_list[$jno]->del_date = $delDate;
					}

					if(! empty($data)) {
						$this->campaign_lib->dn_updates($dn_row->idx, $data);
					}

				  }

				}  // if(! is_null($dn_row->cj_return_dt)) 
				// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - 



				// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
				// [2025-08-22] 기부 완료 처리
				$state_dn_complete = ('1' == $dn_row->state_handout_finish) ? '완료' : '';
				$dn_list[$jno]->state_dn_complete = $state_dn_complete;

				$state_step = '';

				if('1' == $dn_row->state_handout_finish  &&  '' != $dn_row->handout_finish_date) {
					//$state_step = "완료";
					$state_step = '<span class="btn btn-primary btn-xs  allow-select" style="pointer-events: none;">완료</span>';
				}
				else if('' != $dn_row->check_date) {
					// $inspDate
					//$state_step = "검수";
					$state_step = '<span class="btn btn-success btn-xs  allow-select" style="pointer-events: none;">검수</span>';
				}
				else if('' != $dn_row->pickup_date) {
					// $whDate
					//$state_step = "수거";
					$state_step = '<span class="btn btn-secondary btn-xs  allow-select" style="pointer-events: none;">수거</span>';
				}
				else if('' != $dn_row->reg_datetime) {
					//$state_step = "접수";
					$state_step = '<span class="btn btn-outline-secondary btn-xs  allow-select" style="pointer-events: none;">접수</span>';
				}

				$dn_list[$jno]->state_step = $state_step;


				$dn_list[$jno]->cj_book = $dn_row->cj_book;
				$dn_list[$jno]->cj_return = $dn_row->cj_return;

				// 기부신청(reg_datetime 과 같음)
				$dn_list[$jno]->cj_book_dt = substr($dn_row->cj_book_dt,5,11);
				$dn_list[$jno]->cj_book_dt_succ = ($dn_row->cj_book == 'success') ? substr($dn_row->cj_book_dt,5,11) : ''; // substr($row->reg_datetime,0,10);

				// 수거신청
				$dn_list[$jno]->cj_return_dt = ($dn_row->cj_return == 'success') ? substr($dn_row->cj_return_dt,5,11) : '';

				$tmp_return_d = substr($dn_row->cj_return_dt,5,5);
				$tmp_return_t = substr($dn_row->cj_return_dt,11,5);
				$tmp_return_dt = $tmp_return_d.' <span style="color:#b1b1b1;">'.$tmp_return_t.'</span>';
				$dn_list[$jno]->cj_return_dt = $tmp_return_dt;






					// - - - - - - - - - - - - - - - - - - - - - - - - - - -
					// 경사원 캠페인에서 '수거신청' 버튼 노출을 위한 처리
					// - - - - - - - - - - - - - - - - - - - - - - - - - - -
					/*
					$active_return_btn = false;
					$cj_rcpt_dv = '';

					if('redi' != $dn_row->cmp_code) {
						if( $dn_row->cj_return != 'success' ) { // 택배 반품 신청 성공 여부

						}
					}
					*/



				// [1] 디비에 저장된 값
				$dn_list[$jno]->cj_tracking_dv_code = $dn_row->cj_tracking_dv_code;
				$dn_list[$jno]->cj_tracking_dv_code_text = ('' != $dn_row->cj_tracking_dv_code) ? '['.$dn_row->cj_tracking_dv_code.'] ' : '';

				$cj_tracking_no = '';
				if('01' == $dn_row->cj_tracking_dv_code) {
					$cj_tracking_no = '[1차] ';
				}
				else if('02' == $dn_row->cj_tracking_dv_code) {
					$cj_tracking_no = '[2차] ';
				}
				else {
					$cj_tracking_no = '';
				}
				$dn_list[$jno]->cj_tracking_no = $cj_tracking_no;


				// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
				// 택배 물류 추적 tracking
				$tracking_state = $dn_row->cj_tracking_state;

				$dn_list[$jno]->rcpt_dv_code = '';

				// [2025-09-03] 1. 수거신청을 한 것들만 해당
				// [2025-09-03] 2. 수거신청을 한 것들 중에서 배송완료 안된 것들만.
				if(! is_null($dn_row->cj_return_dt) && '배송완료' != $dn_row->cj_tracking_state) {

					// [개발용 주소] // 로컬 작업용 pc
					//$post_url = 'http://183.99.21.70:8080/cj/getGdsTrc';  
					// [실제사용주소]
					$post_url = 'https://ros.remann.co.kr/cj/getGdsTrc';

					$curl_data = array('id'=>$dn_row->idx);
					//print_r($curl_data);

					$output_json = $this->curl_post_ros($post_url, $curl_data); // return 등록한 작업요청id값
					//print_r($output_json);
					/*
					if('112.185.52.193' == REMOTE_ADDR){
						print_r($output_json);
						echo '<hr />';
					}
					*/
					
					$output_arr = json_decode($output_json, true); // $output_arr['data'][0]
					//$output_arr = json_decode($output_json); // $output_arr->data[0]
					/*
					if('112.185.52.193' == REMOTE_ADDR){
						print_r($output_arr);
						echo '<hr />';
					}
					*/

					//$trackingData = isset($output_arr['data'][0]) ? $output_arr['data'][0] : 'false';
					$trackingData = isset($output_arr['data']) ? end($output_arr['data']) : 'false';
					//print_r($trackingData);


					
					// 택배 구분(1차, 2차)
					$rcpt_DV = isset($trackingData['rcpt_DV']) ? $trackingData['rcpt_DV'] : '';
					$dn_list[$jno]->rcpt_dv_code = '['.$rcpt_DV.']';
					// [2] api 로 가벼올 값이 있으면 그걸로 대체.
					$dn_list[$jno]->cj_tracking_dv_code = ('' != $rcpt_DV) ? '['.$rcpt_DV.'] ' : '';
					$dn_list[$jno]->cj_tracking_dv_code_text = ('' != $dn_row->cj_tracking_dv_code) ? '['.$dn_row->cj_tracking_dv_code.'] ' : '';

					$cj_tracking_no = '';
					if('01' == $dn_row->cj_tracking_dv_code) {
						$cj_tracking_no = '[1차] ';
					}
					else if('02' == $dn_row->cj_tracking_dv_code) {
						$cj_tracking_no = '[2차] ';
					}
					else {
						$cj_tracking_no = '';
					}
					$dn_list[$jno]->cj_tracking_no = $cj_tracking_no;


					// 배송상태 코드
					$tracking_code = isset($trackingData['crg_ST']) ? $trackingData['crg_ST'] : '';
					$dn_list[$jno]->tracking_code = $tracking_code;

					// 배송상태
					$tracking_state = isset($trackingData['crg_ST_NM']) ? $trackingData['crg_ST_NM'] : '';
					//$dn_list[$jno]->tracking_state = $tracking_state;


					// 업데이트
					if('' != $rcpt_DV) {
						// 1차(택배접수), 2차(반품)
						$this->campaign_lib->dn_update_tracking($dn_row->idx, $rcpt_DV,'rcpt_DV');
					}
					// 업데이트
					if('' != $tracking_code) {
						// 추적 상태 코드
						$this->campaign_lib->dn_update_tracking($dn_row->idx, $tracking_code,'code');
					}
					if('' != $tracking_state) {
						// 추적 상태명
						$this->campaign_lib->dn_update_tracking($dn_row->idx, $tracking_state,'state');
					}

					/*
					Array ( 
						[id] => 2 
						[no_CLDV_RSN_CD] => 
						[crg_ST] => 01 
						[rcpt_DV] => 01 
						[crg_ST_NM] => 집화지시 
						[dealemp_NM] => 박*업 
						[dealt_BRAN_NM] => 경기포천신내촌 
						[acptr_NM] => 본인 
						[invc_NO] => 685140735832 
						[detail_RSN] => 
						[cust_USE_NO] => 314 
						[scan_YMD] => 20250828 
						[scan_HOUR] => 141915
					)
					*/

					/*
						"crg_ST":"01","rcpt_DV":"01","crg_ST_NM":"집화지시"
						"crg_ST":"11","rcpt_DV":"01","crg_ST_NM":"집화처리"
						"crg_ST":"82","rcpt_DV":"01","crg_ST_NM":"배송출발"
						"crg_ST":"91","rcpt_DV":"01","crg_ST_NM":"배송완료"
					*/
					
				}
				$dn_list[$jno]->tracking_state = $tracking_state;
				// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

				$jno++;
			}







		// 캠페인 기부 취소건
			$arr_where = array(
					'sql_select'     => '*',
					'sql_from'       => 'donation',
					'sql_where'      => array('cmp_idx'=>$cmp_idx, 'cancel !='=>NULL, 'delete !='=>NULL),
					//'sql_order_by'   => 'cancel ASC, reg_datetime DESC'
					'sql_order_by'   => 'delete DESC'
			);
			$dn_cancel_result = $this->basic_model->arr_get_result($arr_where);
			//print_r($dn_cancel_result);

			foreach($dn_cancel_result['qry'] as $j => $dn_row) {

				//print_r($dn_row);

				// 번호
				//$num = ($dn_result['total_count'] - $limit*($page-1) - $j);
				$dn_num = ($dn_cancel_result['total_count'] - $j);

				$dn_cancel_result['qry'][$j]->num = $dn_num;

			}








		// Get data.
			$breadcrumb = array(
				'캠페인'=>base_url().'admin/campaign/donate',
				'기부관리'=>''
			);

			$data = array(
				'cmp_row' => $cmp_row,
				'dn_list' => $dn_list,
				'dn_cancel_result' => $dn_cancel_result,
				'arr_seg'   => $this->arr_seg, //$this->uri->segment_array(),
				'breadcrumb'    => $breadcrumb,
				'viewPage'  => 'admin/campaign_donate_cmp_dn_list_view'
			);

			$this->load->view('admin/layout_view', $data);
	}





















	// trans file - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	// 캠페인 주간 방문자(view) 수 가져오기
	// trans file - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	public function call_visit_stat_week() {
		
		// jquery ajax 에서 success 의 response 값을 못가져오길래 검색해보니,
		// 요 아래 코드를 ajax 페이지에서 호출하는 페이지에 넣어주라고 함.
		header("Content-type: text/html; charset=utf-8");
		header("Content-Type:application/json");

		$cmp_code = $this->input->post('cmp_code',FALSE);

		// 현재 신청 상태 확인
		$arr = array(
				'sql_select'     => '*',
				'sql_from'       => 'campaign_visit_stat_week',
				'sql_where'      => array('cmp_code'=>$cmp_code),
				'sql_order_by'   => 'date DESC'
		);
		$result = $this->basic_model->arr_get_result($arr);

		$res = '<h6 class="dsp_flex_sp_between m-0"><strong>주간 통계</strong> <small>(매주 월요일 기준)</small></h6>';
		$res .= '<table class="vstat_list" style="width: 100%;">';
		$res .= '  <tr>';
		$res .= '    <th style="border-bottom: 1px solid #ddd;">date</th>';
		$res .= '    <th style="border-bottom: 1px solid #ddd;">view</th>';
		$res .= '  </tr>';
		foreach($result['qry'] as $i => $row) { 
		$res .= '  <tr>';
		$res .= '    <td>'.$row->date.'</td>';
		$res .= '    <td>'.$row->cnt_human.'</td>';
		$res .= '  </tr>';
		}
		$res .= '</table>';

		echo $res;
	}




	// 기부관리
	private function donate_lists() {

		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		// GET parameter
		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		$this->load->library('querystring', NULL, 'param'); // 쿼리스트링 주소
		$param	  =& $this->param;
	
		// 캠페인 상태
		$sql_where = array('state'=>'launch');
		
		// 런칭 캠페인 중 진행중/종료 구분
		$term = $param->get('term',FALSE);

		// [2025-08-11] 기본적으로 진행중인 것부터 보여준다.
		if(! $term) {
			$term = 'ing';
		}
		if('end' == $term) :
			$sql_where['cmp_term_end < '] = TIME_YMD;
		elseif('ing' == $term) :
			$sql_where['cmp_term_end >= '] = TIME_YMD;
		endif;


		// 기부관리 대상 (런칭)캠페인 목록 가져오기
		$arr_where = array(
				'sql_select'     => '*',
				'sql_from'       => 'campaign',
				'sql_where'      => $sql_where,
				'sql_order_by'   => 'reg_datetime DESC'
		);
		$result = $this->basic_model->arr_get_result($arr_where);

		//print_r($result);
		$list = array();
		$ino = 0;
		foreach($result['qry'] as $key => $row) {

			//print_r($row);

			$list[$ino] = new stdClass();

			// 번호
			//$num = ($result['total_count'] - $limit*($page-1) - $ino);
			$num = ($result['total_count'] - $ino);
			$list[$ino]->num = $num;

			$list[$ino]->idx = $row->idx;
			$list[$ino]->cmp_code = $row->code;
			$list[$ino]->cmp_title = $row->cmp_title;
			$list[$ino]->cmp_term_begin = $row->cmp_term_begin;
			$list[$ino]->cmp_term_end = $row->cmp_term_end;
			$list[$ino]->cmp_term = $row->cmp_term_begin.'~'.$row->cmp_term_end;
			$list[$ino]->reg_datetime = $row->reg_datetime;
			$list[$ino]->reg_date = substr($row->reg_datetime,0,10);

			$list[$ino]->cmp_org_name = $row->cmp_org_name;

			$list[$ino]->state = $row->state;
			$state_str = '작성';
			if('submit' == $row->state) :
				$state_str = '제출';
			elseif('launch' == $row->state) :
				$state_str = '런칭';
			endif;
			$list[$ino]->state_str = $state_str;

			$list[$ino]->visit_human = $row->visit_human;
			$list[$ino]->visit_bot = $row->visit_bot;



			// 캠페인별(주관단체별) 기부가치 합산 금액
			$arr_where_dnval = array(
					'sql_select'     => 'sum(donation_value) as totVal',
					'sql_from'       => 'donation',
					'sql_where'      => array('cmp_code'=>$row->code,'delete'=>NULL),
			);
			$dnval_row = $this->basic_model->arr_get_row($arr_where_dnval);
			$dnval_tot_val = $dnval_row->totVal;

			$list[$ino]->dnval_tot_val = ($dnval_tot_val > 0) ? number_format($dnval_tot_val).'원' : '';



			// - - - - - - - - - - - - - - -
			// 접속자 주간 통계를 위한 데이터
			// campaign_visit_week
			// - - - - - - - - - - - - - - -
			// 오늘 날짜
			$today = date('Y-m-d');
			// 오늘 요일 (1: 월요일, 2: 화요일, ..., 7: 일요일)
			$today_weekday = date('w', strtotime($today));
			// 이번 주 월요일 날짜
			$this_monday = date('Y-m-d', strtotime('-' . ($today_weekday - 1) . ' days', strtotime($today)));

			$visit_cnt_week = $this->basic_model->get_common_count('campaign_visit_stat_week', array('date' => $this_monday,'cmp_code' => $row->code));

			$arr_where = array(
					'sql_select'     => '*',
					'sql_from'       => 'campaign_visit_stat_week',
					'sql_where'      => array('date' => $this_monday,'cmp_code' => $row->code)
			);
			$row_week = $this->basic_model->arr_get_row($arr_where);


			$list[$ino]->visit_human_thisweek = isset($row_week->cnt_human) ? $row_week->cnt_human : 0;





			// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
			// [2023-09-22] 새로운 기부신청 개수 확인해서 가져오기
			// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
			// 캠페인 기부 신청 목록 가져오기
			//echo $row->idx ."<br />";
			$arr_where = array(
					'sql_from'       => 'donation',
					'sql_where'      => array('cmp_code'=>$row->code, 'delete'=>NULL, 'mng_chk'=>NULL)
			);
			$dn_new_cnt = $this->basic_model->get_total($arr_where);
			$list[$ino]->dn_new_cnt = $dn_new_cnt;


			// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
			// [2023-09-22] 기부신청 개수 토탈
			// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
			// 캠페인 기부 신청 목록 가져오기
			//echo $row->idx ."<br />";
			$arr_where = array(
					'sql_from'       => 'donation',
					'sql_where'      => array('cmp_code'=>$row->code, 'delete'=>NULL)
			);
			$dn_total_cnt = $this->basic_model->get_total($arr_where);
			$list[$ino]->dn_total_cnt = $dn_total_cnt;





			// 캠페인 기부 신청 목록 가져오기
			//echo $row->idx ."<br />";
			$arr_where = array(
					'sql_select'     => '*',
					'sql_from'       => 'donation',
					'sql_where'      => array('cmp_code'=>$row->code, 'delete'=>NULL),
					'sql_order_by'   => 'cancel ASC, reg_datetime DESC'
			);
			$dn_result = $this->basic_model->arr_get_result($arr_where);

			//print_r($dn_result);
			$dn_list = array();
			$jno = 0;

			$cno = 0; // 취소건 카운트

			foreach($dn_result['qry'] as $j => $dn_row) {

				//print_r($dn_row);

				$dn_list[$jno] = new stdClass();


				
				//$uacc = $this->tank_auth->get_userinfo_idx($dn_row->idx);
				if($dn_row->user_idx > 1000) {
					// 일반 회원
					$uacc = $this->tank_auth->get_userinfo_idx($dn_row->user_idx);
				} else {
					// 관리자
					$uacc = $this->tank_auth->get_admininfo_idx($dn_row->user_idx);
				}
				//print_r($uacc);


				// 처리옵션
				$opt_request_ko = '';
				if(isset($dn_row->opt_request) && 'data_reset' == $dn_row->opt_request) {
					$opt_request_ko = '데이터 삭제';
				}
				else if(isset($dn_row->opt_request) && 'discard' == $dn_row->opt_request) {
					$opt_request_ko = '폐기';
				}


				// 번호
				//$num = ($dn_result['total_count'] - $limit*($page-1) - $jno);
				$dn_num = ($dn_result['total_count'] - $jno);
				$dn_list[$jno]->num = $dn_num;


				// - - - - - - - - - - - - - - - - - -
				// 기부 취소 처리
				// - - - - - - - - - - - - - - - - - -
				// num
				/*
				if('redi' == $row->code) {
				  if( ! is_null($dn_row->cancel) ) {
					$cno++;
				  }
				}
				*/
				if( ! is_null($dn_row->cancel) ) {
					$cno++;
				}




				$dn_list[$jno]->idx = $dn_row->idx;
				$dn_list[$jno]->cmp_code = $dn_row->cmp_code;
				$dn_list[$jno]->user_idx = $dn_row->user_idx;
				$dn_list[$jno]->user_username = $dn_row->user_username;

				$dn_list[$jno]->donor_type = $dn_row->donor_type;
				$dn_list[$jno]->company = $dn_row->company;
				$dn_list[$jno]->donor_name = $dn_row->donor_name;
				$dn_list[$jno]->cellphone = $dn_row->cellphone;
				//$dn_list[$jno]->email = $dn_row->email;
				$dn_list[$jno]->user_email = isset($uacc->email) ? $uacc->email : '';
				$dn_list[$jno]->postcode = $dn_row->postcode;
				$dn_list[$jno]->addr = $dn_row->addr;
				$dn_list[$jno]->addr_detail = $dn_row->addr_detail;

				$dn_list[$jno]->opt_request = $dn_row->opt_request;
				$dn_list[$jno]->opt_request_ko = $opt_request_ko;

				$dn_list[$jno]->pickup_date = $dn_row->pickup_date;
				$dn_list[$jno]->pickup_date_plz = $dn_row->pickup_date_plz;

				$dn_list[$jno]->check_date = $dn_row->check_date;

				$dn_list[$jno]->del_date = $dn_row->del_date;

				$dn_list[$jno]->reg_datetime = $dn_row->reg_datetime;
				$reg_date = substr($dn_row->reg_datetime,0,10);
				$dn_list[$jno]->reg_date = $reg_date;

				$tmp_reg_d = substr($dn_row->reg_datetime,2,8);
				$tmp_reg_t = substr($dn_row->reg_datetime,11,5);
				$tmp_reg_dt = $tmp_reg_d.' <span style="color:#b1b1b1;">'.$tmp_reg_t.'</span>';
				$dn_list[$jno]->reg_dt = $tmp_reg_dt;

				$dn_list[$jno]->reg_ip = $dn_row->reg_ip;

				$dn_list[$jno]->mng_chk = $dn_row->mng_chk;

				$dn_list[$jno]->receipt_req_dt = $dn_row->receipt_req_dt;

				$dn_list[$jno]->donation_value = $dn_row->donation_value;

				
				$dn_list[$jno]->cancel = $dn_row->cancel;
				$dn_list[$jno]->cancel_bg = IS_NULL($dn_row->cancel) ? '' : 'background-color: #eeeeee; ';


				// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
				// 기부 물품 현재 상태
				/*
				//$state_good_proc = '접수 중';
				$state_good_proc = '접수 완료';
				if('1' == $dn_row->state_reg  &&  '' != $dn_row->pickup_date) {
					$state_good_proc = ('1' == $dn_row->state_pickup) ? '수거 완료' : '수거 중';
				}
				if('1' == $dn_row->state_pickup &&  '' != $dn_row->check_date) {
					$state_good_proc = ('1' == $dn_row->state_check) ? '검수 완료' : '검수 중';
				}
				if('1' == $dn_row->state_check  &&  '' != $dn_row->recycle_date) {
					$state_good_proc = ('1' == $dn_row->state_recycle) ? '재생 완료' : '재생 중';
				}
				if('1' == $dn_row->state_recycle  &&  '' != $dn_row->handout_date) {
					$state_good_proc = ('1' == $dn_row->state_handout) ? '나눔 완료' : '나눔 중';
				}
				$dn_list[$jno]->state_good_proc = $state_good_proc;
				*/


				// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
				// ROS에 저장된 진행상황 날짜들 가져오기

				// [2025-09-03] 수거신청을 한 것들만 해당
				if(! is_null($dn_row->cj_return_dt) OR ! is_null($dn_row->pickup_req_date)) {

				  // [2025-09-03] 수거완료 및 검수완료 날짜 가져오기
				  if( is_null($dn_row->pickup_date) OR '' == $dn_row->pickup_date OR is_null($dn_row->check_date) OR '' == $dn_row->check_date OR is_null($dn_row->del_date) OR '' == $dn_row->del_date) {

					// [개발용 주소] // 로컬 작업용 pc
					//$post_url = 'http://183.99.21.70:8080/replus/getStateDate';  
					// [실제사용주소]
					$post_url = 'https://ros.remann.co.kr/replus/getStateDate'; // ros.remann.co.kr/replus/getStateDate
					$cert_key = 'ub9acud50cub7ecuc2a4u0072u006fu0073uc5f0ub3d9';
					$curl_data = array('id'=>$dn_row->idx,'key'=>$cert_key);
					$output_json = $this->curl_post_ros($post_url, $curl_data); // return 등록한 작업요청id값
					$output_arr = json_decode($output_json, true);

					$whDate = (! empty($output_arr['whDate']) && ! is_null($output_arr['whDate'])) ? $output_arr['whDate'] : '';
					$inspDate = (! empty($output_arr['inspDate']) && ! is_null($output_arr['inspDate'])) ? $output_arr['inspDate'] : '';
					// 검수 > 데이터삭제 건 검수완료 날짜 >>> 데이터삭제보고서 생성 시점
					// 삭제보고서 생성일자
					$delDate = (! empty($output_arr['delDate']) && ! is_null($output_arr['delDate'])) ? $output_arr['delDate'] : '';

					// 만약 실입고 없이 검수로 넘어가면..
					// 그래서 검수날짜는 있는데 수거날짜가 없으면 검수날짜를 수거날짜에도 넣어줘라!
					if('' != $inspDate && '' == $whDate) {
						$whDate = $inspDate;
					}

					/*
					echo '[idx] '.$dn_row->idx.'<<<<br />';
					echo '[수거] '.$whDate.'<<<<<<<br />';
					echo '[검수] '.$inspDate.'<<<<<<<br />';
					echo '<hr />';
					*/

					// 업데이트
					$data = array();
					if('' != $whDate) {
						$data['pickup_date']=$whDate;
						$dn_row->pickup_date = $whDate;
						$dn_row->state_pickup = 1;
						$dn_list[$jno]->pickup_date = $whDate;
					}
					if('' != $inspDate) {
						$data['check_date']=$inspDate;
						$dn_row->check_date = $inspDate;
						$dn_row->state_check = 1;
						$dn_list[$jno]->check_date = $inspDate;
					}
					if('' != $delDate) {
						$data['del_date']=$delDate;
						$dn_row->del_date = $delDate;
						$dn_row->state_del = 1;
						$dn_list[$jno]->del_date = $delDate;
					}

					if(! empty($data)) {
						$this->campaign_lib->dn_updates($dn_row->idx, $data);
					}

				  }

				}  // if(! is_null($dn_row->cj_return_dt)) 
				// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - 



				// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
				// [2025-08-22] 기부 완료 처리
				$state_dn_complete = ('1' == $dn_row->state_handout_finish) ? '완료' : '';
				$dn_list[$jno]->state_dn_complete = $state_dn_complete;

				$state_step = '';

				/*
				if('' != $dn_row->reg_datetime) {
					// $state_step = '<button type="button" class="btn btn-outline-secondary btn-xs" readonly>접수</button>';
					$state_step = '<span class="btn btn-outline-secondary btn-xs  allow-select" style="pointer-events: none;">접수</span>';

				}
				if('1' == $dn_row->state_pickup  &&  '' != $dn_row->pickup_date) {
					$state_step = '<span class="btn btn-secondary btn-xs  allow-select" style="pointer-events: none;">수거</span>';
				}
				if('1' == $dn_row->state_check  &&  '' != $dn_row->check_date) {
					$state_step = '<span class="btn btn-success btn-xs  allow-select" style="pointer-events: none;">검수</span>';
				}
				if('1' == $dn_row->state_handout_finish  &&  '' != $dn_row->handout_finish_date) {
					$state_step = '<span class="btn btn-primary btn-xs  allow-select" style="pointer-events: none;">완료</span>';
				}
				$dn_list[$jno]->state_step = $state_step;
				*/


				/*
				if('' != $delDate) {
					$state_step = "완료";
				}
				if('' != $inspDate) {
					$state_step = "검수";
				}
				else if('' != $whDate) {
					$state_step = "수거";
				}
				else if('' != $dn_row->reg_datetime) {
					$state_step = "접수";
				}
				*/


				//if('' != $dn_row->del_date) {
				if('1' == $dn_row->state_handout_finish  &&  '' != $dn_row->handout_finish_date) {
					//$state_step = "완료";
					$state_step = '<span class="btn btn-primary btn-xs  allow-select" style="pointer-events: none;">완료</span>';
				}
				else if('' != $dn_row->check_date) {
					// $inspDate
					//$state_step = "검수";
					$state_step = '<span class="btn btn-success btn-xs  allow-select" style="pointer-events: none;">검수</span>';
				}
				else if('' != $dn_row->pickup_date) {
					// $whDate
					//$state_step = "수거";
					$state_step = '<span class="btn btn-secondary btn-xs  allow-select" style="pointer-events: none;">수거</span>';
				}
				else if('' != $dn_row->reg_datetime) {
					//$state_step = "접수";
					$state_step = '<span class="btn btn-outline-secondary btn-xs  allow-select" style="pointer-events: none;">접수</span>';
				}

				$dn_list[$jno]->state_step = $state_step;





				$dn_list[$jno]->cj_book = $dn_row->cj_book;
				$dn_list[$jno]->cj_return = $dn_row->cj_return;

				// 기부신청(reg_datetime 과 같음)
				$dn_list[$jno]->cj_book_dt = substr($dn_row->cj_book_dt,5,11);
				$dn_list[$jno]->cj_book_dt_succ = ($dn_row->cj_book == 'success') ? substr($dn_row->cj_book_dt,5,11) : ''; // substr($row->reg_datetime,0,10);

				// 수거신청
				$dn_list[$jno]->cj_return_dt = ($dn_row->cj_return == 'success') ? substr($dn_row->cj_return_dt,5,11) : '';

				$tmp_return_d = substr($dn_row->cj_return_dt,5,5);
				$tmp_return_t = substr($dn_row->cj_return_dt,11,5);
				$tmp_return_dt = $tmp_return_d.' <span style="color:#b1b1b1;">'.$tmp_return_t.'</span>';
				$dn_list[$jno]->cj_return_dt = $tmp_return_dt;






					// - - - - - - - - - - - - - - - - - - - - - - - - - - -
					// 경사원 캠페인에서 '수거신청' 버튼 노출을 위한 처리
					// - - - - - - - - - - - - - - - - - - - - - - - - - - -
					/*
					$active_return_btn = false;
					$cj_rcpt_dv = '';

					if('redi' != $dn_row->cmp_code) {
						if( $dn_row->cj_return != 'success' ) { // 택배 반품 신청 성공 여부

						}
					}
					*/



				// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
				// 택배 물류 추적 tracking
				$tracking_state = $dn_row->cj_tracking_state;

				// [2025-09-03] 1. 수거신청을 한 것들만 해당
				// [2025-09-03] 2. 수거신청을 한 것들 중에서 배송완료 안된 것들만.
				if(! is_null($dn_row->cj_return_dt) && '배송완료' != $dn_row->cj_tracking_state) {

					// [개발용 주소] // 로컬 작업용 pc
					//$post_url = 'http://183.99.21.70:8080/cj/getGdsTrc';  
					// [실제사용주소]
					$post_url = 'https://ros.remann.co.kr/cj/getGdsTrc';

					$curl_data = array('id'=>$dn_row->idx);
					//print_r($curl_data);

					$output_json = $this->curl_post_ros($post_url, $curl_data); // return 등록한 작업요청id값
					//print_r($output_json);
					/*
					if('112.185.52.193' == REMOTE_ADDR){
						print_r($output_json);
						echo '<hr />';
					}
					*/
					
					$output_arr = json_decode($output_json, true); // $output_arr['data'][0]
					//$output_arr = json_decode($output_json); // $output_arr->data[0]
					/*
					if('112.185.52.193' == REMOTE_ADDR){
						print_r($output_arr);
						echo '<hr />';
					}
					*/

					//$trackingData = isset($output_arr['data'][0]) ? $output_arr['data'][0] : 'false';
					$trackingData = isset($output_arr['data']) ? end($output_arr['data']) : 'false';
					//print_r($trackingData);

					// 택배 구분(1차, 2차)
					$rcpt_DV = isset($trackingData['rcpt_DV']) ? $trackingData['rcpt_DV'] : '';
					$dn_list[$jno]->rcpt_dv_code = '['.$rcpt_DV.']';

					// 배송상태 코드
					$tracking_code = isset($trackingData['crg_ST']) ? $trackingData['crg_ST'] : '';
					$dn_list[$jno]->tracking_code = $tracking_code;

					// 배송상태
					$tracking_state = isset($trackingData['crg_ST_NM']) ? $trackingData['crg_ST_NM'] : '';
					//$dn_list[$jno]->tracking_state = $tracking_state;

					// 업데이트
					if('' != $rcpt_DV) {
						// 1차(택배접수), 2차(반품)
						$this->campaign_lib->dn_update_tracking($dn_row->idx, $rcpt_DV,'rcpt_DV');
					}
					// 업데이트
					if('' != $tracking_code) {
						// 추적 상태 코드
						$this->campaign_lib->dn_update_tracking($dn_row->idx, $tracking_code,'code');
					}
					if('' != $tracking_state) {
						// 추적 상태명
						$this->campaign_lib->dn_update_tracking($dn_row->idx, $tracking_state,'state');
					}

					/*
					Array ( 
						[id] => 2 
						[no_CLDV_RSN_CD] => 
						[crg_ST] => 01 
						[rcpt_DV] => 01 
						[crg_ST_NM] => 집화지시 
						[dealemp_NM] => 박*업 
						[dealt_BRAN_NM] => 경기포천신내촌 
						[acptr_NM] => 본인 
						[invc_NO] => 685140735832 
						[detail_RSN] => 
						[cust_USE_NO] => 314 
						[scan_YMD] => 20250828 
						[scan_HOUR] => 141915
					)
					*/

					/*
						"crg_ST":"01","rcpt_DV":"01","crg_ST_NM":"집화지시"
						"crg_ST":"11","rcpt_DV":"01","crg_ST_NM":"집화처리"
						"crg_ST":"82","rcpt_DV":"01","crg_ST_NM":"배송출발"
						"crg_ST":"91","rcpt_DV":"01","crg_ST_NM":"배송완료"
					*/
					
				}
				$dn_list[$jno]->tracking_state = $tracking_state;
				// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -


					$cj_tracking_no = '';
					if('01' == $dn_row->cj_tracking_dv_code) {
						$cj_tracking_no = '[1차] ';
					}
					else if('02' == $dn_row->cj_tracking_dv_code) {
						$cj_tracking_no = '[2차] ';
					}
					else {
						$cj_tracking_no = '';
					}
					$dn_list[$jno]->cj_tracking_no = $cj_tracking_no;





				$jno++;
			}

			$list[$ino]->dn_list = $dn_list;

			$ino++;

		}




		// Get data.
			$breadcrumb = array(
				'캠페인'=>base_url().'admin/campaign/donate',
				'기부목록'=>''
			);

			$data = array(
				'term' => $term,
				'list' => $list,
				'arr_seg'   => $this->arr_seg, //$this->uri->segment_array(),
				'breadcrumb'    => $breadcrumb,
				'viewPage'  => 'admin/campaign_donate_list_view'
			);

			$this->load->view('admin/layout_view', $data);
	}



	// 기부 상세 내역 삭제
	private function donate_donor_del($cmp_code=FALSE,$donate_idx=FALSE) {

		if($this->campaign_lib->_donor_del($cmp_code,$donate_idx)) {
			alert('삭제되었습니다.');
		}
		else {
			alert('존재하지 않거나 이미 삭제된 캠페인입니다.');
		}

	}


	// 기부 삭제
	public function trans_donate_donor_del($cmp_code=FALSE,$donate_idx=FALSE) {

		// jquery ajax 에서 success 의 response 값을 못가져오길래 검색해보니,
		// 요 아래 코드를 ajax 페이지에서 호출하는 페이지에 넣어주라고 함.
		header("Content-type: text/html; charset=utf-8");
		header("Content-Type:application/json");

		$cmp_code = $this->input->post('cmp_code',FALSE);
		$donate_idx = $this->input->post('dn_idx',FALSE);

		if($this->campaign_lib->_donor_del($cmp_code,$donate_idx)) {
			echo 'succ';
		}
		else {
			echo 'fail';
		}
	}


	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	// [2025-09-15] 기부 취소
	// [취소이지만 삭제처리 업데이트]
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	public function trans_donation_donor_cancel($cmp_code=FALSE,$donate_idx=FALSE) {

		// jquery ajax 에서 success 의 response 값을 못가져오길래 검색해보니,
		// 요 아래 코드를 ajax 페이지에서 호출하는 페이지에 넣어주라고 함.
		header("Content-type: text/html; charset=utf-8");
		header("Content-Type:application/json");

		$cmp_code = $this->input->post('cmp_code',FALSE);
		$donate_idx = $this->input->post('dn_idx',FALSE);

		if($this->campaign_lib->_donor_cancel($cmp_code,$donate_idx)) {
			echo 'succ';
		}
		else {
			echo 'fail';
		}
	}

	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	// [2025-09-01] 기부 취소
	// [취소이지만 삭제처리 업데이트]
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	public function trans_donate_donor_cancel($cmp_code=FALSE,$donate_idx=FALSE) {

		// jquery ajax 에서 success 의 response 값을 못가져오길래 검색해보니,
		// 요 아래 코드를 ajax 페이지에서 호출하는 페이지에 넣어주라고 함.
		header("Content-type: text/html; charset=utf-8");
		header("Content-Type:application/json");

		$cmp_code = $this->input->post('cmp_code',FALSE);
		$donate_idx = $this->input->post('dn_idx',FALSE);

		if($this->campaign_lib->_donor_cancel($cmp_code,$donate_idx)) {
			echo 'succ';
		}
		else {
			echo 'fail';
		}
	}



	// 캠페인별 후원자 목록(중복 포함)
	private function donate_donor_list() {

		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		// 페이징 정보 
		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
			$this->load->library('segment', array('offset'=>5), 'seg'); // 세그먼트 주소( page 위치 )
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
			//$ofl = 'cmp.reg_datetime DESC, dn.reg_datetime DESC';
			//if($ofl = $param->get('ofl','cmp.reg_datetime DESC, dn.reg_datetime DESC')) { // order_field 캠페인 기준
			if($ofl = $param->get('ofl','dn.reg_datetime DESC, cmp.reg_datetime DESC')) { // order_field 기부일시 기준
				$qstr .= ('' == $qstr) ? '?' : '&';
				//$qstr .= 'ofl='.$ofl;
				$qstr .= ($ofl != '') ? 'ofl='.$ofl : '';
			}

			// 페이징
			$limit = 20;
			$page  = $seg->get('page', 1); // 페이지
			if(! isset($page) OR empty($page)) {
				$page = 1;
			}
			$offset = ($page - 1) * $limit;





			// 검색
			$like_field = $sfl;                         // search
			$like_match = $stx;
			$like_side = 'both';


		// 캠페인별 기부자 목록 가져오기
			$sql_select = 'cmp.cmp_title, cmp.state, dn.*';
			$sql_from = 'campaign as cmp';
			$sql_join_tbl = 'donation as dn';
			$sql_join_on = 'dn.cmp_code = cmp.code AND dn.delete IS NULL';
			$sql_join_option = ''; //'LEFT OUTER';
			$sql_where = array('cmp.state'=>'launch');
			$sql_group_by = FALSE;
			$sql_order_by = $ofl;


			// 검색 상관없는 전체 수
			//$total_cnt = $this->basic_model->get_common_count($sql_from,$sql_where);
			//$total_cnt = $this->basic_model->get_common_count_join($sql_from,$sql_where,$sql_join_tbl,$sql_join_on,$sql_join_option);
			
			// echo $total_cnt.'<<<<hr />';
			// echo $this->db->last_query();



		// [SQL] visit
			$arr = array(
					'sql_select'        => $sql_select,
					'sql_from'          => $sql_from,
					'sql_join_tbl'      => $sql_join_tbl,
					'sql_join_on'       => $sql_join_on,
					'sql_join_option'   => $sql_join_option,
					'like_field'        => $like_field,
					'like_match'        => $like_match,
					'like_side'         => $like_side,
					'sql_where'         => $sql_where,
					'sql_group_by'      => $sql_group_by,
					'sql_order_by'      => $ofl,  // $order_field.' DESC, IDX DESC',
					'page'              => $page,
					'limit'             => $limit,
					'offset'            => $offset
			);



		$result = $this->basic_model->arr_get_result($arr);

		foreach($result['qry'] as $i => $o)
		{
			// 번호
			$num = ($result['total_count'] - $limit*($page-1) - $i);
			$result['qry'][$i]->num = $num;
		}


		//echo $this->db->last_query();
		//print_r($result);

		$dno = 0;
		$dn_num = 1;
		$donor_list = array();
		$cmp_code = '';

		foreach($result['qry'] as $key => $row) {

			$donor_list[$dno] = new stdClass();

			// 번호
			//$num = ($result['total_count'] - $dno);
			//$donor_list[$dno]->num = $num;
			$donor_list[$dno]->num = $row->num;

			$donor_list[$dno]->cmp_title = $row->cmp_title;
			$donor_list[$dno]->cmp_code = $row->cmp_code;

			// 번호
			//$dn_num = ($result['total_count'] - $dno);
			if($cmp_code != $row->cmp_code) {
				$cmp_code = $row->cmp_code;
				$dn_num = 1;
			}
			else {
				$dn_num++;
			}
			$donor_list[$dno]->dn_num = $dn_num;

			$donor_list[$dno]->donor_name = $row->donor_name;
			$donor_list[$dno]->donor_phone = $row->cellphone;
			$donor_list[$dno]->donor_email = $row->email; //isset($uacc->email) ? $uacc->email : '';

			$donor_list[$dno]->reg_datetime = $row->reg_datetime;
			$donor_list[$dno]->reg_date = substr($row->reg_datetime,0,10);

			$donor_list[$dno]->receipt_req_dt = $row->receipt_req_dt;
			$donor_list[$dno]->receipt_req_date = substr($row->receipt_req_dt,0,10);


			
			$donor_list[$dno]->donation_value = $row->donation_value;



			$donor_list[$dno]->mng_chk = $row->mng_chk;

			$dno++;
		}


		// pagination 설정
			$config['suffix']	   = $qstr;
			$config['base_url']    = base_url('admin/campaign/donate/donor_list/page/');
			$config['per_page']    = $limit;
			$config['total_rows']  = $result['total_count'];
			$config['uri_segment'] = $seg->pos('page');  // 5

		// 검색 목록 ADD
			$btn_prev_part = $btn_next_part = '';
			$config['full_tag_open']  = "<ul class='pagination'>".$btn_prev_part;
			$config['full_tag_close'] = $btn_next_part.'</ul>';

			$config['first_link'] = '<span aria-hidden="true">←</span>';
			$config['prev_link'] = '<span aria-hidden="true">&laquo;</span>';
			$config['next_link'] = '<span aria-hidden="true">&raquo;</span>';
			$config['last_link'] = '<span aria-hidden="true">→</span>';

			$this->load->library('pagination', $config);

			$paging = $this->pagination->create_links();


		// Get data.
			$breadcrumb = array(
				'캠페인'=>base_url().'admin/campaign/donate',
				'기부자 목록'=>''
			);

			$data = array(
				'sfl' => $sfl,
				'stx' => $stx,
				'ofl' => $ofl,
				'page'      => $page,
				'limit'      => $limit,
				'paging'    => $paging,

				'result' => $result,

				'donor_list' => $donor_list,
				//'total_cnt' => $total_cnt,

				'arr_seg'   => $this->arr_seg, //$this->uri->segment_array(),
				'breadcrumb'    => $breadcrumb,
				'viewPage'  => 'admin/campaign_donate_donor_list_view'
			);

			//print_r($data);

			$this->load->view('admin/layout_view', $data);
	}






	// 기부 상세 내역 [처음부터 다시 볼 것..]
	private function donate_donor($cmp_code=FALSE,$donate_idx=FALSE,$user_idx=FALSE) {

			//if(! $donate_idx || ! $user_idx) {
			if(! $donate_idx) {
				//alert('존재하지 않거나 삭제된 캠페인입니다.',base_url().'admin/donate/detail/'.$cmp_code);
				alert('존재하지 않거나 삭제된 캠페인입니다.');
				exit;
			}

			load_css('<link rel="stylesheet" href="'.LIB_DIR.'/datetimepicker-master/jquery.datetimepicker.min.css" />');
			load_js('<script src="'.LIB_DIR.'/datetimepicker-master/jquery.datetimepicker.full.js"></script>');


			// 캠페인 정보
			$arr_where = array(
					'sql_select'     => '*',
					'sql_from'       => 'campaign',
					'sql_where'      => array('code'=>$cmp_code)
			);
			$cmp_row = $this->basic_model->arr_get_row($arr_where);


			// 기부자 정보
			$arr_where = array(
					'sql_select'     => '*',
					'sql_from'       => 'donation',
					'sql_where'      => array('idx'=>$donate_idx, 'delete'=>NULL)
			);
			$dn_row = $this->basic_model->arr_get_row($arr_where);

			if(! isset($dn_row->idx) ) {
				alert('존재하지 않거나 삭제된 기부내역입니다.');
				exit;
			}

			//print_r($dn_row);
			//exit;

			// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
			// 기부 물품 현재 상태
			/*
			$state_good_proc = '접수 중';
			$state_good_proc = ('1' == $dn_row->state_reg) ? '접수 완료' : '접수 중';
			if('' != $dn_row->pickup_date) {
				$state_good_proc = ('1' == $dn_row->state_pickup) ? '수거 완료' : '수거 중';
			}
			if('' != $dn_row->check_date) {
				$state_good_proc = ('1' == $dn_row->state_check) ? '검수 완료' : '검수 중';
			}
			if('' != $dn_row->recycle_date) {
				$state_good_proc = ('1' == $dn_row->state_recycle) ? '재생 완료' : '재생 중';
			}
			if('' != $dn_row->handout_date) {
				$state_good_proc = ('1' == $dn_row->state_handout) ? '나눔 완료' : '나눔 중';
			}
			*/

			// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
			// 기부 물품 현재 상태
			/*
			//$state_good_proc = '접수 중';
			$state_good_proc = '접수 완료';


			if('1' == $dn_row->state_reg  &&  '' != $dn_row->pickup_date) {
				$state_good_proc = ('1' == $dn_row->state_pickup) ? '수거 완료' : '수거 중';
			}
			if('1' == $dn_row->state_pickup &&  '' != $dn_row->check_date) {
				$state_good_proc = ('1' == $dn_row->state_check) ? '검수 완료' : '검수 중';
			}
			if('1' == $dn_row->state_check  &&  '' != $dn_row->recycle_date) {
				$state_good_proc = ('1' == $dn_row->state_recycle) ? '재생 완료' : '재생 중';
			}
			if('1' == $dn_row->state_recycle  &&  '' != $dn_row->handout_date) {
				$state_good_proc = ('1' == $dn_row->state_handout) ? '나눔 완료' : '나눔 중';
			}

			$dn_row->state_good_proc = $state_good_proc;
			*/

			// [2023-05-16] 기부 물품 처리 상황 단계별 잠금 해제
			$arr_dn_disabled = array(
							'pickup'=>' disabled ',
							'check'=>' disabled ',
							'recycle'=>' disabled ',
							'handout'=>' disabled ',
							'handout_finish'=>' disabled ',
			);

			if('1' == $dn_row->state_reg) 
				$arr_dn_disabled['pickup'] = '';
			if('1' == $dn_row->state_pickup) 
				$arr_dn_disabled['check'] = '';
			if('1' == $dn_row->state_check) 
				$arr_dn_disabled['recycle'] = '';
			if('1' == $dn_row->state_recycle) 
				$arr_dn_disabled['handout'] = '';
			if('1' == $dn_row->state_handout) 
				$arr_dn_disabled['handout_finish'] = '';

			/*
			if('1' == $dn_row->state_recycle) {
				$arr_dn_disabled['pickup'] = '';
				$arr_dn_disabled['check'] = '';
				$arr_dn_disabled['recycle'] = '';
				$arr_dn_disabled['handout'] = '';
				//$arr_dn_disabled['handout_finish'] = '';
			}
			elseif('1' == $dn_row->state_check) {
				$arr_dn_disabled['pickup'] = '';
				$arr_dn_disabled['check'] = '';
				$arr_dn_disabled['recycle'] = '';
				//$arr_dn_disabled['handout'] = '';
			}
			elseif('1' == $dn_row->state_pickup) {
				$arr_dn_disabled['pickup'] = '';
				$arr_dn_disabled['check'] = '';
				//$arr_dn_disabled['recycle'] = '';
				//$arr_dn_disabled['handout'] = '';
			}
			elseif('1' == $dn_row->state_reg) {
				$arr_dn_disabled['pickup'] = '';
				//$arr_dn_disabled['check'] = '';
				//$arr_dn_disabled['recycle'] = '';
				//$arr_dn_disabled['handout'] = '';
			}
			*/


			/*
			if('1' == $dn_row->state_reg) {
				$arr_dn_disabled['pickup'] = '';
				//$arr_dn_disabled['check'] = '';
				//$arr_dn_disabled['recycle'] = '';
				//$arr_dn_disabled['handout'] = '';
			}
			elseif('1' == $dn_row->state_pickup) {
				$arr_dn_disabled['pickup'] = '';
				$arr_dn_disabled['check'] = '';
				//$arr_dn_disabled['recycle'] = '';
				//$arr_dn_disabled['handout'] = '';
			}
			elseif('1' == $dn_row->state_check) {
				$arr_dn_disabled['pickup'] = '';
				$arr_dn_disabled['check'] = '';
				$arr_dn_disabled['recycle'] = '';
				//$arr_dn_disabled['handout'] = '';
			}
			elseif('1' == $dn_row->state_recycle) {
				$arr_dn_disabled['pickup'] = '';
				$arr_dn_disabled['check'] = '';
				$arr_dn_disabled['recycle'] = '';
				$arr_dn_disabled['handout'] = '';
				//$arr_dn_disabled['handout_finish'] = '';
			}
			*/



			$arr_donor_type = explode(':',$dn_row->donor_type);
			$donor_type_text = isset($arr_donor_type[1]) ? $arr_donor_type[1] : '';
			$donor_type_code = isset($arr_donor_type[0]) ? $arr_donor_type[0] : '';
			$dn_row->donor_type_text = $donor_type_text;
			$dn_row->donor_type_code = $donor_type_code;

			$dn_row->addr_detail = str_replace('<주소끝>','',$dn_row->addr_detail);




			
			// 처리옵션
			$opt_request_ko = '';
			if(isset($dn_row->opt_request) && 'data_reset' == $dn_row->opt_request) {
				$opt_request_ko = '데이터 삭제';
			}
			else if(isset($dn_row->opt_request) && 'discard' == $dn_row->opt_request) {
				$opt_request_ko = '폐기';
			}
			$dn_row->opt_request_ko = $opt_request_ko;



			// 기부관리 대상 (런칭)캠페인 목록 가져오기
			$arr_where = array(
					'sql_select'     => '*',
					'sql_from'       => 'donation_goods',
					'sql_where'      => array('dn_idx'=>$donate_idx),  // ,'user_idx'=>$user_idx
					'sql_order_by'   => 'idx asc'
			);
			$gd_result = $this->basic_model->arr_get_result($arr_where);




			//print_r($gd_result);
			$dngoods_list = array();
			$ino = 0;
			foreach($gd_result['qry'] as $key => $row) {

				//print_r($row);

				$dngoods_list[$ino] = new stdClass();

				// 번호
				//$num = ($gd_result['total_count'] - $limit*($page-1) - $ino);
				$num = ($gd_result['total_count'] - $ino);
				$dngoods_list[$ino]->num = $num;

				$dngoods_list[$ino]->idx = $row->idx;
				$dngoods_list[$ino]->user_idx = $row->user_idx;
				$dngoods_list[$ino]->dn_idx = $row->dn_idx;

				//$dngoods_list[$ino]->user_username = $row->user_username;

				$dngoods_list[$ino]->gd_type = $row->gd_type;
				$dngoods_list[$ino]->gd_amt = $row->gd_amt;
				$dngoods_list[$ino]->gd_grade = $row->gd_grade;

				$dngoods_list[$ino]->gd_maker = $row->gd_maker;
				$dngoods_list[$ino]->gd_model = $row->gd_model;
				$dngoods_list[$ino]->gd_part = $row->gd_part;
				$dngoods_list[$ino]->gd_memo = $row->gd_memo;

				$dngoods_list[$ino]->reg_datetime = $row->reg_datetime;
				$dngoods_list[$ino]->reg_date = substr($row->reg_datetime,0,10);

				$dngoods_list[$ino]->reg_ip = $row->reg_ip;


				$ino++;

			}





		// 업로드 이미지 정보
			$arr = array(
					'sql_select'     => '*',
					'sql_from'       => 'file_manager',
					'sql_where'      => array('wr_table'=>'donation', 'wr_table_idx'=>$dn_row->idx, 'upload_type' => 'form', 'file_type'=>'image'),
					'sql_order_by'   => 'idx DESC'
			);
			$file_result = $this->basic_model->arr_get_result($arr);
			//print_r($file_result);









			// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
			// ROS에 저장된 진행상황 날짜들 가져오기
				// [개발용 주소] // 로컬 작업용 pc
				//$post_url = 'http://183.99.21.70:8080/replus/getStateDate';  
				// [실제사용주소]
				$post_url = 'https://ros.remann.co.kr/replus/getStateDate'; // ros.remann.co.kr/replus/getStateDate
				$cert_key = 'ub9acud50cub7ecuc2a4u0072u006fu0073uc5f0ub3d9';
				$curl_data = array('id'=>$donate_idx,'key'=>$cert_key);
				$output_json = $this->curl_post_ros($post_url, $curl_data); // return 등록한 작업요청id값
				$output_arr = json_decode($output_json, true);
				//echo $output_json;
				//print_r($output_arr);
				// Array ( [inspDate] => 2025-08-12 [whDate] => )

				$whDate = (! empty($output_arr['whDate']) && ! is_null($output_arr['whDate'])) ? $output_arr['whDate'] : '';
				$inspDate = (! empty($output_arr['inspDate']) && ! is_null($output_arr['inspDate'])) ? $output_arr['inspDate'] : '';

				// 삭제보고서 생성일자
				$delDate = (! empty($output_arr['delDate']) && ! is_null($output_arr['delDate'])) ? $output_arr['delDate'] : '';

				// 만약 실입고 없이 검수로 넘어가면..
				// 그래서 검수날짜는 있는데 수거날짜가 없으면 검수날짜를 수거날짜에도 넣어줘라!
				if('' != $inspDate && '' == $whDate) {
					$whDate = $inspDate;
				}

				$dn_row->whDate = $whDate;
				$dn_row->inspDate = $inspDate;
				$dn_row->delDate = $delDate;


				// 업데이트
				/*
				if('' != $whDate) {
					// 수거날짜 업데이트
					$this->campaign_lib->dn_update_date($dn_row->idx, $whDate,'pickup_date');

					$dn_row->pickup_date = $whDate;
					$dn_row->state_pickup = 1;
				}
				if('' != $inspDate) {
					// 검수날짜 업데이트
					$this->campaign_lib->dn_update_date($dn_row->idx, $inspDate, 'check_date',);

					$dn_row->check_date = $inspDate;
					$dn_row->state_check = 1;
				}
				*/


				// 업데이트
				$data = array();
				if('' != $whDate) {
					$data['pickup_date']=$whDate;
					$dn_row->pickup_date = $whDate;
					$dn_row->state_pickup = 1;
				}
				if('' != $inspDate) {
					$data['check_date']=$inspDate;
					$dn_row->check_date = $inspDate;
					$dn_row->state_check = 1;
				}
				if('' != $delDate) {
					$data['del_date']=$delDate;
					$dn_row->del_date = $delDate;
					$dn_row->state_del = 1;
				}

				if(! empty($data)) {
					$this->campaign_lib->dn_updates($dn_row->idx, $data);
				}



				/*
				$info_date = new stdClass();
				$info_date->whDate = $whDate;
				$info_date->inspDate = $inspDate;

				// 만약 실입고 없이 검수로 넘어가면..
				// 그래서 검수날짜는 있는데 수거날짜가 없으면 검수날짜를 수거날짜에도 넣어줘라!
				if('' != $info_date->inspDate && '' == $info_date->whDate) {
					$info_date->whDate = $info_date->inspDate;
				}
				*/
			// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -



			// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
				// 기부 물품 현재 상태 renewal
				$state_good_proc = '접수 완료';

				$dn_row->state_accept_txt = '';
				$dn_row->state_pickup_txt = '';
				$dn_row->state_check_txt = '';
				$dn_row->state_delreport_txt = '';

				if('' != $delDate) {
					$state_good_proc = "삭제보고서 생성";

					$dn_row->state_accept_txt = '완료';
					$dn_row->state_pickup_txt = '완료';
					$dn_row->state_check_txt = '완료';
					$dn_row->state_delreport_txt = '완료';
				}

				if('' != $inspDate) {
					$state_good_proc = "검수 완료";

					$dn_row->state_accept_txt = '완료';
					$dn_row->state_pickup_txt = '완료';
					$dn_row->state_check_txt = '완료';
				}
				else if('' != $whDate) {
					$state_good_proc = "수거 완료";

					$dn_row->state_accept_txt = '완료';
					$dn_row->state_pickup_txt = '완료';
					$dn_row->state_check_txt = '';
				}
				else if('' != $dn_row->reg_datetime) {
					$state_good_proc = "접수 완료";

					$dn_row->state_accept_txt = '완료';
					$dn_row->state_pickup_txt = '';
					$dn_row->state_check_txt = '';
				}

				// 현재 진행상태
				$dn_row->state_good_proc = $state_good_proc;
			// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -





			// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
			// ROS에 저장된 상세 검수 현황 가져오기
				// [개발용 주소] // 로컬 작업용 pc
				//$post_url = 'http://183.99.21.70:8080/replus/getInsp';  
				// [실제사용주소]
				$post_url = 'https://ros.remann.co.kr/replus/getInsp'; // ros.remann.co.kr/replus/getInsp

				$cert_key = 'ub9acud50cub7ecuc2a4u0072u006fu0073uc5f0ub3d9';
				$curl_data = array('id'=>$donate_idx,'key'=>$cert_key);
				$output_json = $this->curl_post_ros($post_url, $curl_data); // return 등록한 작업요청id값
				$output_arr = json_decode($output_json, true);
				//print_r($output_arr);

				// 가치
				$arr_worth_tbl = array('데스크탑','노트북','태블릿','스마트폰','기타');
				$arr_worth_tbl['데스크탑'] = new stdClass();
				$arr_worth_tbl['데스크탑']->A = 9200;
				$arr_worth_tbl['데스크탑']->B = 4200;
				$arr_worth_tbl['데스크탑']->C = 4200;
				$arr_worth_tbl['데스크탑']->D = 2000;

				$arr_worth_tbl['노트북'] = new stdClass();
				$arr_worth_tbl['노트북']->A = 23200;
				$arr_worth_tbl['노트북']->B = 13200;
				$arr_worth_tbl['노트북']->C = 13200;
				$arr_worth_tbl['노트북']->D = 2000;

				$arr_worth_tbl['태블릿'] = new stdClass();
				$arr_worth_tbl['태블릿']->A = 19200;
				$arr_worth_tbl['태블릿']->B = 11200;
				$arr_worth_tbl['태블릿']->C = 11200;
				$arr_worth_tbl['태블릿']->D = 1000;

				$arr_worth_tbl['스마트폰'] = new stdClass();
				$arr_worth_tbl['스마트폰']->A = 33200;
				$arr_worth_tbl['스마트폰']->B = 20200;
				$arr_worth_tbl['스마트폰']->C = 20200;
				$arr_worth_tbl['스마트폰']->D = 1000;

				$arr_worth_tbl['기타'] = new stdClass();
				$arr_worth_tbl['기타']->A = 0;
				$arr_worth_tbl['기타']->B = 0;
				$arr_worth_tbl['기타']->C = 0;
				$arr_worth_tbl['기타']->D = 0;


				$item_list = array();
				$arr_worth_val = array('reproduct'=>0, 'recycle'=>0);
				$arr_worth_cnt = array('reproduct'=>0, 'recycle'=>0);

				if( isset($output_arr['data']) && ! empty($output_arr['data']) && ! is_null($output_arr['data'])) {
					foreach ($output_arr['data'] as $i => $item) {
						// print_r($item);
						$item_list[$i] = new stdClass();

						$itm_insp_kind = $item['insp_kind'];
						$itm_grade = $item['grade'];

						$item_list[$i]->insp_kind = $itm_insp_kind;
						$item_list[$i]->mfr = $item['mfr'];
						$item_list[$i]->model = $item['model'];
						$item_list[$i]->sn = $item['sn'];
						$item_list[$i]->registeredDate = $item['registeredDate'];
						$item_list[$i]->rmk_1 = $item['rmk_1'];
						$item_list[$i]->grade = $itm_grade;

						$itm_worth_val = isset($arr_worth_tbl[$itm_insp_kind]->$itm_grade) ? $arr_worth_tbl[$itm_insp_kind]->$itm_grade : 0;
						$itm_worth_cnt = 0;

						if('D' == $itm_grade) {
							$arr_worth_val['recycle'] += $itm_worth_val;
							$arr_worth_cnt['recycle']++;
						}
						else {
							$arr_worth_val['reproduct'] += $itm_worth_val;
							$arr_worth_cnt['reproduct']++;
						}
					}
				}
				//print_r($arr_worth);

				$worth_val_total = array_sum($arr_worth_val);
				//print_r($worth_val_total);

			// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -




			// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
			// ROS에 저장된 상세 검수 현황 가져오기
				// [개발용 주소] // 로컬 작업용 pc
				//$post_url = 'http://183.99.21.70:8080/replus/getInsp';  
				// [실제사용주소]
				$post_url = 'https://ros.remann.co.kr/replus/getDel'; // ros.remann.co.kr/replus/getDel

				$cert_key = 'ub9acud50cub7ecuc2a4u0072u006fu0073uc5f0ub3d9';
				$curl_data = array('id'=>$donate_idx,'key'=>$cert_key);
				$output_json = $this->curl_post_ros($post_url, $curl_data); // return 등록한 작업요청id값
				$output_arr = json_decode($output_json, true);

				$report = new stdClass();
				$resData = isset($output_arr['data'][0]) ? $output_arr['data'][0] : false;

				//print_r($resData);

				$download_blancco_link = '';
				$file_path = 'https://ros.remann.co.kr/resources/img/inspDel/';
				if(isset($resData['file_doc1_path']) && '' != $resData['file_doc1_path']) {
					$download_blancco_link = $file_path.$resData['file_doc1_path'];
				}
				//echo $download_blancco_link;
			// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -



			// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
			// 택배 물류 추적 tracking
				// [개발용 주소] // 로컬 작업용 pc
				//$post_url = 'http://183.99.21.70:8080/cj/getGdsTrc';  
				// [실제사용주소]
				$post_url = 'https://ros.remann.co.kr/cj/getGdsTrc';

				$curl_data = array('id'=>$donate_idx);
				$output_json = $this->curl_post_ros($post_url, $curl_data); // return 등록한 작업요청id값
				//print_r($output_json);

				$output_arr = json_decode($output_json, true); // $output_arr['data'][0]
				//$output_arr = json_decode($output_json); // $output_arr->data[0]

				//print_r($output_arr);
				//exit;

				$trackingData = isset($output_arr['data']) ? $output_arr['data'] : false;
				// print_r($trackingData);

				/*
					Array ( [id] => 2 [no_CLDV_RSN_CD] => [crg_ST] => 01 [rcpt_DV] => 01 [crg_ST_NM] => 집화지시 [dealemp_NM] => 박*업 [dealt_BRAN_NM] => 경기포천신내촌 [acptr_NM] => 본인 [invc_NO] => 685140735832 [detail_RSN] => [cust_USE_NO] => 314 [scan_YMD] => 20250828 [scan_HOUR] => 141915 )
					Array ( [id] => 13 [no_CLDV_RSN_CD] => [crg_ST] => 11 [rcpt_DV] => 01 [crg_ST_NM] => 집화처리 [dealemp_NM] => 박*업 [dealt_BRAN_NM] => 경기포천신내촌 [acptr_NM] => 본인 [invc_NO] => 685140735832 [detail_RSN] => [cust_USE_NO] => 314 [scan_YMD] => 20250828 [scan_HOUR] => 142048 )
					Array ( [id] => 20 [no_CLDV_RSN_CD] => [crg_ST] => 82 [rcpt_DV] => 01 [crg_ST_NM] => 배송출발 [dealemp_NM] => 안*윤 [dealt_BRAN_NM] => 하나집배점 [acptr_NM] => 본인 [invc_NO] => 685140735832 [detail_RSN] => [cust_USE_NO] => 314 [scan_YMD] => 20250828 [scan_HOUR] => 142048 )
					Array ( [id] => 31 [no_CLDV_RSN_CD] => [crg_ST] => 91 [rcpt_DV] => 01 [crg_ST_NM] => 배송완료 [dealemp_NM] => 안*윤 [dealt_BRAN_NM] => 하나집배점 [acptr_NM] => 본인 [invc_NO] => 685140735832 [detail_RSN] => [cust_USE_NO] => 314 [scan_YMD] => 20250828 [scan_HOUR] => 142048 )
				*/

				// 배송상태
				//$tracking_state = isset($trackingData['crg_ST_NM']) ? $trackingData['crg_ST_NM'] : '';

				/*
				Array ( 
					[id] => 2 
					[no_CLDV_RSN_CD] => 
					[crg_ST] => 01 
					[rcpt_DV] => 01 
					[crg_ST_NM] => 집화지시 
					[dealemp_NM] => 박*업 
					[dealt_BRAN_NM] => 경기포천신내촌 
					[acptr_NM] => 본인 
					[invc_NO] => 685140735832 
					[detail_RSN] => 
					[cust_USE_NO] => 314 
					[scan_YMD] => 20250828 
					[scan_HOUR] => 141915
				)
				*/


				if($trackingData) {

					// 최신 추적 정보가 앞으로 올 수 있도록 역순 정렬
					$trackingData = array_reverse($trackingData);

					// 1) 배열 → JSON 변환
					$tracking_json = json_encode($trackingData, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

					// 2) JSON 비교, 다르면 업데이트
					if ($dn_row->tracking_json !== $tracking_json) {

						$this->campaign_lib->dn_update_tracking($dn_row->idx, $tracking_json,'tracking_json');

					}

				}



			// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -








		// Get data.
			$breadcrumb = array(
				'캠페인'=>base_url().'admin/campaign/donate',
				'기부목록'=>base_url().'admin/campaign/donate/lists',
				'기부상세정보'=>''
			);

			$data = array(
				'cmp_row' => $cmp_row,
				'dn_row' => $dn_row,
				'dngoods_list' => $dngoods_list,

				'arr_dn_disabled' => $arr_dn_disabled,

				'file_result' => $file_result,

				'item_list' => $item_list,
				'arr_worth_cnt' => $arr_worth_cnt,
				'arr_worth_val' => $arr_worth_val,
				'worth_val_total' => $worth_val_total,

				'download_blancco_link' => $download_blancco_link,

				'trackingData' => $trackingData,

				'arr_seg'   => $this->arr_seg, //$this->uri->segment_array(),
				'breadcrumb'    => $breadcrumb,
				'viewPage'  => 'admin/campaign_donate_donor_view'
			);

			$this->load->view('admin/layout_view', $data);
	}




	// 기부 - 상세 검수 현황
	private function donate_report_check($cmp_code=FALSE,$donate_idx=FALSE,$user_idx=FALSE) {

		// 캠페인 정보
			$arr_where = array(
					'sql_select'     => '*',
					'sql_from'       => 'campaign',
					'sql_where'      => array('code'=>$cmp_code)
			);
			$cmp_row = $this->basic_model->arr_get_row($arr_where);

		// 기부자 정보
			$arr_where = array(
					'sql_select'     => '*',
					'sql_from'       => 'donation',
					'sql_where'      => array('idx'=>$donate_idx, 'delete'=>NULL)
			);
			$dn_row = $this->basic_model->arr_get_row($arr_where);


		// 검수현황 업데이트
		/*
		샘플

		$this->form_validation->set_rules('device_idx[]', 'idx', 'trim|required|xss_clean');

		$this->form_validation->set_rules('device_name[]', 'device_name', 'trim|xss_clean');
		$this->form_validation->set_rules('device_amount[]', 'device_amount', 'trim|xss_clean');
		$this->form_validation->set_rules('device_display[]', 'device_display', 'trim|xss_clean');
		$this->form_validation->set_rules('device_order[]', 'device_order', 'trim|xss_clean');

		if ($this->form_validation->run() == FALSE)
		{
			//$this->load->view('myform');
		}
		else
		{
			if (!is_null($data = $this->campaign_lib->donate_report_check())) {		// success
				sess_message('저장되었습니다.');
				redirect(current_url());
			}
		}
		*/



		$this->form_validation->set_rules('idx[]', 'idx', 'trim|xss_clean');

		if ($this->form_validation->run() == FALSE)
		{
			//$this->load->view('myform');

			// donation_report_check
			// private function donate_report_check($cmp_code=FALSE,$donate_idx=FALSE,$user_idx=FALSE) {


			// 저장된 상세 검수 현황 가져오기
				$arr_where = array(
						'sql_select'     => '*',
						'sql_from'       => 'donation_report_check',
						'sql_where'      => array('cmp_code'=>$cmp_code,'donate_idx'=>$donate_idx,'user_idx'=>$user_idx)
				);
				$dnchk_result = $this->basic_model->arr_get_result($arr_where);

				//print_r($dnchk_result);


			// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
			// ROS에 저장된 상세 검수 현황 가져오기
				// [개발용 주소] // 로컬 작업용 pc
				//$post_url = 'http://183.99.21.70:8080/replus/getInsp';  
				// [실제사용주소]
				$post_url = 'https://ros.remann.co.kr/replus/getInsp'; // ros.remann.co.kr/replus/getInsp

				$cert_key = 'ub9acud50cub7ecuc2a4u0072u006fu0073uc5f0ub3d9';
				$curl_data = array('id'=>$donate_idx,'key'=>$cert_key);
				$output_json = $this->curl_post_ros($post_url, $curl_data); // return 등록한 작업요청id값
				$output_arr = json_decode($output_json, true);

				$item_list = array();

				if( isset($output_arr['data']) && ! empty($output_arr['data']) && ! is_null($output_arr['data'])) {
					foreach ($output_arr['data'] as $i => $item) {
						$item_list[$i] = new stdClass();
						$item_list[$i]->insp_kind = $item['insp_kind'];
						$item_list[$i]->mfr = $item['mfr'];
						$item_list[$i]->model = $item['model'];
						$item_list[$i]->sn = $item['sn'];
						$item_list[$i]->registeredDate = $item['registeredDate'];
						$item_list[$i]->rmk_1 = $item['rmk_1'];
						$item_list[$i]->grade = $item['grade'];
					}
				}
			// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -





			// Get data.
				$breadcrumb = array(
					'캠페인'=>base_url().'admin/campaign/donate',
					'기부목록'=>base_url().'admin/campaign/donate/lists',
					'기부상세정보'=>base_url().'admin/campaign/donate/donor/'.$cmp_code.'/'.$donate_idx.'/'.$user_idx,
					'상세검수현황'=>''
				);

				$data = array(
					'cmp_code' => $cmp_code,
					'donate_idx' => $donate_idx,
					'user_idx' => $user_idx,
					'dnchk_result' => $dnchk_result,
					'item_list' => $item_list,

					'cmp_row' => $cmp_row,
					'dn_row' => $dn_row,
					'arr_seg'   => $this->arr_seg, //$this->uri->segment_array(),
					'breadcrumb'    => $breadcrumb,
					'viewPage'  => 'admin/campaign_donate_report_check_view'
				);

				$this->load->view('admin/layout_view', $data);
		}
		else
		{
			if (!is_null($data = $this->campaign_lib->donate_report_check($cmp_code,$donate_idx,$user_idx))) {		// success
				sess_message('저장되었습니다.');
				redirect(current_url());
			}
		}


	}



	/* [2025] chatgpt 버전 */
	function curl_post_ros($url, $data)
	{
		// 1. 모든 값에 대해:
		//    - 줄바꿈을 \n 으로 치환 (실제 개행 → 문자열)
		//    - UTF-8 인코딩 보장
		foreach ($data as $key => $value) {
			$value = str_replace(["\r\n", "\r", "\n"], "\\n", $value); // 줄바꿈을 문자열 \n으로
			$data[$key] = mb_convert_encoding($value, 'UTF-8', 'auto');
		}

		// 2. 쿼리 문자열로 변환
		$post_field_string = http_build_query($data, '', '&');

		// 3. cURL 설정
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post_field_string);
		curl_setopt($ch, CURLOPT_HTTPHEADER, [
			'Content-Type: application/x-www-form-urlencoded; charset=UTF-8'
		]);
		curl_setopt($ch, CURLOPT_POST, true);

		$response = curl_exec($ch);

		curl_close($ch);

		return $response;
	}



	// 기부 - 데이터 완전 삭제 리포트
	// $this->donate_report_del($cmp_code,$donate_idx,$dn_user_idx);
	private function donate_report_del($cmp_code=FALSE,$donate_idx=FALSE,$dn_user_idx=FALSE) {

		load_css('<link rel="stylesheet" href="'.LIB_DIR.'/datetimepicker-master/jquery.datetimepicker.min.css" />');
		load_js('<script src="'.LIB_DIR.'/datetimepicker-master/jquery.datetimepicker.full.js"></script>');

		// 캠페인 정보
			$arr_where = array(
					'sql_select'     => '*',
					'sql_from'       => 'campaign',
					'sql_where'      => array('code'=>$cmp_code)
			);
			$cmp_row = $this->basic_model->arr_get_row($arr_where);

		// 기부자 정보
			$arr_where = array(
					'sql_select'     => '*',
					'sql_from'       => 'donation',
					'sql_where'      => array('idx'=>$donate_idx, 'delete'=>NULL)
			);
			$dn_row = $this->basic_model->arr_get_row($arr_where);
			// $dn_user_idx = isset($dn_row->idx) ? $dn_row->user_idx : NULL;


		// EDITOR - redactor 
			//<!-- redactor.css -->
			load_css('<link rel="stylesheet" type="text/css" href="'. ASSETS_DIR .'/lib/editor/redactor/redactor.min.css" />');
			//<!-- redactor.js -->
			load_js('<script src="'. ASSETS_DIR .'/lib/editor/redactor/redactor.min.js"></script>');
			//<!-- plugin js -->
			load_js('<script src="'. ASSETS_DIR .'/lib/editor/redactor/_plugins/filemanager/filemanager.js"></script>');
			load_js('<script src="'. ASSETS_DIR .'/lib/editor/redactor/_plugins/imagemanager/imagemanager.js"></script>');
			load_js('<script src="'. ASSETS_DIR .'/lib/editor/redactor/_plugins/table/table.js"></script>');
			load_js('<script src="'. ASSETS_DIR .'/lib/editor/redactor/_plugins/video/video.js"></script>');
			load_js('<script src="'. ASSETS_DIR .'/lib/editor/redactor/_plugins/alignment/alignment.js"></script>');

			load_css('<link rel="stylesheet" type="text/css" href="'. ASSETS_DIR .'/lib/editor/redactor/_plugins/inlinestyle/inlinestyle.css" />');
			load_js('<script src="'. ASSETS_DIR .'/lib/editor/redactor/_plugins/inlinestyle/inlinestyle.js"></script>');

			load_js('<script src="'. ASSETS_DIR .'/lib/editor/redactor/_plugins/specialchars/specialchars.js"></script>');
			load_js('<script src="'. ASSETS_DIR .'/lib/editor/redactor/_plugins/textdirection/textdirection.js"></script>');
			load_js('<script src="'. ASSETS_DIR .'/lib/editor/redactor/_plugins/widget/widget.js"></script>');
			load_js('<script src="'. ASSETS_DIR .'/lib/editor/redactor/_plugins/fontfamily/fontfamily.js"></script>');
			load_js('<script src="'. ASSETS_DIR .'/lib/editor/redactor/_plugins/fontsize/fontsize.js"></script>');
			load_js('<script src="'. ASSETS_DIR .'/lib/editor/redactor/_plugins/fontcolor/fontcolor.js"></script>');
			load_js('<script src="'. ASSETS_DIR .'/lib/editor/redactor/_plugins/fullscreen/fullscreen.js"></script>');

			//<!-- connect the languages file -->
			load_js('<script src="'. ASSETS_DIR .'/lib/editor/redactor/_langs/ko.js?v='.time().'"></script>');



		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		// 관리자 글 작성(새글, 답변글, 수정)시 업로드 파일 저장을 위해 고유 세션 생성
		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
			$user_idx = $this->tank_auth->get_user_id();
			$ss_write_name = 'ss_file_'.$user_idx;
			if (! $this->session->userdata($ss_write_name)) {
				$this->session->set_userdata($ss_write_name, $user_idx.'_'.time());
			}

		// process
			$tbl_idx = FALSE;

			if ($this->input->post('submit')) 
			{


				$tab = $this->input->post('tab');
				// list, photo, cert

				if( 'list' == $tab) {

					//$res = $this->cms_lib->contents_save();
					$res = $this->campaign_lib->dn_report_del_save_list();

				}
				elseif( 'photo' == $tab) {
					
					//$res = $this->campaign_lib->dn_report_del_save_photo();
					$res = $this->campaign_lib->dn_report_del_save_photo();


					// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
					// 글 작성시 에디터로 업로드 한 파일 정보 저장 후, 세션 삭제
					// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
					//$user_idx = $this->tank_auth->get_user_id();
					$tbl_code = 'dn_report_del_photo';
					$sess_file_write = $this->session->userdata($ss_write_name);
					$res = $this->upload_model->update_file_manager($sess_file_write,$tbl_code,$res['idx']);

				}
				elseif( 'cert' == $tab) {

					$res = $this->campaign_lib->dn_report_del_save_cert();

					// 업로드
					if( isset($res['idx']) ) {

							// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
							// 폼업로드 파일 저장 처리
							// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
							//$this->load->library('upload_lib');
							// max upload size
								$max_upload_size = 20480; // 20MB
								//$tbl_code = 'donation_report_delete_cert';
								$tbl_code = 'dn_report_del_cert';
								$tbl_idx = $res['idx'];

								//$cnt_succ_upload = $this->upload_lib->multi_upload_file('attach_file_form', url_code('contents/files','e'), $tbl_code, $res['idx'], '', $max_upload_size );

								//$succ_upload = $this->upload_lib->upload_file($field_name,$encoded_upload_folder,$wr_table,$wr_table_idx,$wr_opt_idx,$multi_files,$i,$return_data,$max_upload_size);

								$field_name = 'attach_file_form';
								$encoded_upload_folder = url_code('donation/files','e');
								$wr_table = $tbl_code;
								$wr_table_idx = $tbl_idx;
								$wr_opt_idx='';
								$multi_files=FALSE;
								$multi_index=FALSE;
								$return_data=TRUE;
								$max_upload_size='20480';
								$down_no=FALSE;
								$gubun=FALSE;
								$file_title=FALSE;

								$this->upload_lib->upload_file($field_name,$encoded_upload_folder,$wr_table,$wr_table_idx,$wr_opt_idx,$multi_files,$multi_index,$return_data,$max_upload_size,$down_no,$gubun,$file_title);


								//echo $cnt_succ_upload.'<<<<<<';
								//exit;

							// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
							// 글 작성시 에디터로 업로드 한 파일 정보 저장 후, 세션 삭제
							// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
								$sess_file_write = $this->session->userdata($ss_write_name);
								$this->upload_model->update_file_manager($sess_file_write,$tbl_code,$tbl_idx);

					}

				}

				//sess_message('게시판 정보가 수정되었습니다.');
				redirect(base_url().'admin/campaign/donate/report_del/'.$cmp_code.'/'.$donate_idx.'?tab='.$tab);

				// http://replus.kr/admin/campaign/donate/report_del/XNYCY/70/list
			}






		// [1. 목록] 저장된 데이터 완전 삭제 리포트 - 목록 가져오기
				$arr_where = array(
						'sql_select'     => '*',
						'sql_from'       => 'donation_report_delete_list',
						//'sql_where'      => array('cmp_code'=>$cmp_code,'donate_idx'=>$donate_idx,'user_idx'=>$dn_user_idx)
						'sql_where'      => array('cmp_code'=>$cmp_code,'donate_idx'=>$donate_idx)
				);
				$dn_del_result = $this->basic_model->arr_get_result($arr_where);
				//print_r($dn_del_result);

		// [2. 사진] 데이터 완전 삭제 리포트 - 사진
			$row_photo = array();
			/*
			if($cmp_code && $donate_idx && $dn_row->user_idx) {
				$arr = array('sql_select' => '*','sql_from' => 'donation_report_delete_photo','sql_where' => array('cmp_code' => $cmp_code, 'donate_idx' => $dn_row->idx, 'user_idx'=>$dn_row->user_idx), 'sql_order_by'=>'idx DESC', 'limit'=>1);
				$row_photo = $this->basic_model->arr_get_row($arr);
			}
			*/
			if($cmp_code && $donate_idx) {
				$arr = array('sql_select' => '*','sql_from' => 'donation_report_delete_photo','sql_where' => array('cmp_code' => $cmp_code, 'donate_idx' => $dn_row->idx), 'sql_order_by'=>'idx DESC', 'limit'=>1);
				$row_photo = $this->basic_model->arr_get_row($arr);
			}


		// [3. 증명] 데이터 완전 삭제 리포트 - 증명서, 인증서
			$row_cert = array();
			/*
			if($cmp_code && $donate_idx && $dn_row->user_idx) {
				$arr = array('sql_select' => '*','sql_from' => 'donation_report_delete_cert','sql_where' => array('cmp_code' => $cmp_code, 'donate_idx' => $dn_row->idx, 'user_idx'=>$dn_row->user_idx));
				$row_cert = $this->basic_model->arr_get_row($arr);
			}
			*/
			if($cmp_code && $donate_idx) {
				$arr = array('sql_select' => '*','sql_from' => 'donation_report_delete_cert','sql_where' => array('cmp_code' => $cmp_code, 'donate_idx' => $dn_row->idx));
				$row_cert = $this->basic_model->arr_get_row($arr);
			}


		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		// 에디터에서 업로드한 파일 가져오기
		// [2. 사진] 데이터 완전 삭제 리포트 - 사진
		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
			$total_cnt_file_editor = 0;
			$result_file_editor = array();

			if(isset($row_photo->idx) && '' != $row_photo->idx)
			{
				//$tbl_code = 'donation_report_delete_photo';
				$tbl_code = 'dn_report_del_photo';

				$get_type='result';  // 'result', 'result_array'
				$sql_from='file_manager';
				$fields='*';
				$join_tbl=FALSE;
				$join_where=FALSE;
				$join_option='left outer';
				//$sql_where_form = "wr_table='".$tbl_code."' AND wr_table_idx='". $row_photo->idx ."'  AND upload_type='form'";
				$sql_where_editor = "wr_table='".$tbl_code."'  AND  wr_table_idx=". $row_photo->idx ."  AND upload_type='editor'";

				// 전체 수
				//$total_cnt_file_form = $this->basic_model->get_common_count($sql_from, $sql_where_form);
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

				/*
				$arr = array(
						'sql_select'     => $fields,
						'sql_from'       => $sql_from,
						'sql_where'      => $sql_where_form,
						'sql_order_by'   => $order_field.' '.$order_direction
				);
				$result_file_form = $this->basic_model->arr_get_result($arr);
				//print_r($result_file_form);
				*/

				$arr = array(
						'sql_select'     => $fields,
						'sql_from'       => $sql_from,
						'sql_where'      => $sql_where_editor,
						'sql_order_by'   => $order_field.' '.$order_direction
				);
				$result_file_editor = $this->basic_model->arr_get_result($arr);

			}




		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		// 폼에서 업로드한 파일 가져오기
		// [3. 증명] 데이터 완전 삭제 리포트 - 증명
		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
			$total_cnt_file_form = 0;
			$result_file_form = array();

			// echo $row_cert->idx ."<<<";

			if(isset($row_cert->idx) && '' != $row_cert->idx)
			{
				//$tbl_code = 'donation_report_delete_cert';
				$tbl_code = 'dn_report_del_cert';

				$get_type='result';  // 'result', 'result_array'
				$sql_from='file_manager';
				$fields='*';
				$join_tbl=FALSE;
				$join_where=FALSE;
				$join_option='left outer';
				$sql_where_form = "wr_table='".$tbl_code."' AND wr_table_idx='". $row_cert->idx ."'  AND upload_type='form'";
				//echo $sql_where_form;

				// 전체 수
				$total_cnt_file_form = $this->basic_model->get_common_count($sql_from, $sql_where_form);

				$like_field = '';
				$like_match = '';
				$like_side='both';
				$sql_group_by = '';

				$order_field = 'datetime_upload';
				$order_direction = 'desc';

				$limit = FALSE;
				$page  = FALSE;
				$offset = FALSE;

				$arr = array(
						'sql_select'     => $fields,
						'sql_from'       => $sql_from,
						'sql_where'      => $sql_where_form,
						'sql_order_by'   => $order_field.' '.$order_direction
				);
				$result_file_form = $this->basic_model->arr_get_result($arr);

			}






		// 탭메뉴
			$this->load->library('querystring', NULL, 'param'); // 쿼리스트링 주소
			$param	  =& $this->param;
			$tab = $param->get('tab','list');



		// Get data.
			$breadcrumb = array(
				'캠페인'=>base_url().'admin/campaign/donate',
				'기부목록'=>base_url().'admin/campaign/donate/lists',
				'기부상세정보'=>base_url().'admin/campaign/donate/donor/'.$cmp_code.'/'.$donate_idx.'/list',
				'데이터 완전 삭제 리포트'=>''
			);

			$data = array(
				'tab' => $tab,
				'cmp_row' => $cmp_row,
				'dn_row' => $dn_row,
				'arr_seg'   => $this->arr_seg, //$this->uri->segment_array(),
				'breadcrumb'    => $breadcrumb,

				'dn_del_result' => $dn_del_result,
				'row_photo' => $row_photo,
				'row_cert' => $row_cert,

				'total_cnt_file_editor'     => $total_cnt_file_editor,
				'result_file_editor'     => $result_file_editor,

				'total_cnt_file_form'     => $total_cnt_file_form,
				'result_file_form'     => $result_file_form,

				'viewPage'  => 'admin/campaign_donate_report_del_view'
			);

			$this->load->view('admin/layout_view', $data);
	}



	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	// 데이터 완전 삭제 리포트
	// [2025-08-20] ROS 에서 데이터를 받아와서 처리
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	private function donate_report_del_ros($cmp_code=FALSE,$dn_idx=FALSE) {

		if(! $cmp_code) {
			alert('존재하지 않거나 삭제된 캠페인입니다.');
			exit;
		}


		// 캠페인 정보
		$arr_where = array(
				'sql_select'     => '*',
				'sql_from'       => 'campaign',
				'sql_where'      => array('code'=>$cmp_code)
		);
		$cmp_row = $this->basic_model->arr_get_row($arr_where);
		if(! $cmp_row->idx) {
			alert('존재하지 않거나 삭제된 캠페인입니다.');
			exit;
		}

		// 기부 정보
		$arr_where = array(
				'sql_select'     => '*',
				'sql_from'       => 'donation',
				'sql_where'      => array('idx'=>$dn_idx, 'cmp_code'=>$cmp_code)
		);
		$dn_row = $this->basic_model->arr_get_row($arr_where);

		if(! isset($dn_row->idx)) {
			alert('존재하지 않거나 삭제된 기부건입니다.');
			exit;
		}

		//print_r($dn_row);
		$donor_name = isset($dn_row->donor_name) ? $dn_row->donor_name : '';



		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		// ROS에 저장된 상세 검수 현황 가져오기
			// [개발용 주소] // 로컬 작업용 pc
			//$post_url = 'http://183.99.21.70:8080/replus/getInsp';  
			// [실제사용주소]
			$post_url = 'https://ros.remann.co.kr/replus/getDel'; // ros.remann.co.kr/replus/getDel

			$cert_key = 'ub9acud50cub7ecuc2a4u0072u006fu0073uc5f0ub3d9';
			$curl_data = array('id'=>$dn_idx,'key'=>$cert_key);
			$output_json = $this->curl_post_ros($post_url, $curl_data); // return 등록한 작업요청id값
			$output_arr = json_decode($output_json, true);

			/*
			if('112.185.52.193' == REMOTE_ADDR OR '116.45.104.200' == REMOTE_ADDR) {
				print_r( isset($output_arr['data'][0]) ? $output_arr['data'][0] : '');
				echo '<hr />';
				print_r( isset($output_arr['data'][1]) ? $output_arr['data'][1] : '');
				echo '<hr />';
				print_r( isset($output_arr['data'][2]) ? $output_arr['data'][2] : '');
				echo '<hr />';
				print_r( isset($output_arr['data'][3]) ? $output_arr['data'][3] : '');
				echo '<hr />';
			}
			*/

			$report = new stdClass();
			$resData = isset($output_arr['data'][0]) ? $output_arr['data'][0] : false;

			$arr_eraseType = array();
			$merged_eraseType = [];
			$arr_eraseType = [];

			$erase_ssn = array();

			if($resData) {

				$res_list = array();

				if( isset($output_arr['data']) && ! empty($output_arr['data']) && ! is_null($output_arr['data'])) {
					foreach ($output_arr['data'] as $i => $res) {
						$res_list[$i] = new stdClass();
						$res_list[$i]->registeredDate = $res['registeredDate'];
						$res_list[$i]->securityofficer = $res['securityofficer'];
						$res_list[$i]->user_nm = $res['user_nm'];
						$res_list[$i]->delk_id = $res['delk_id'];
						$res_list[$i]->erase_type = $res['erase_type'];
						$res_list[$i]->file_kind = isset($res['file_kind']) ? $res['file_kind'] : '';;
						$res_list[$i]->file_nm = isset($res['file_nm']) ? $res['file_nm'] : '';
						$res_list[$i]->ssn = $res['ssn'];

						/*
						if (!in_array($res['erase_type'], $arr_eraseType)) {
							$arr_eraseType[] = $res['erase_type'];   // 또는 array_push($arr_eraseType, $res['erase_type']);
							array_push($arr_eraseType, $res['erase_type']);
						}
						*/

						// explode 후 trim 처리
						$parts = array_map('trim', explode(',', $res['erase_type']));
						$merged_eraseType = array_merge($merged_eraseType, $parts);


						$erase_ssn[$res['erase_type']] = new stdClass();
						$erase_ssn[$res['erase_type']]->ssn = isset($res['ssn']) && '' != $res['ssn'] ?$res['ssn'] : 'N/A (파쇄)';

					}
				}
				//print_r($arr_eraseType); // 디가우징,분쇄,블랑코,천공

				// 중복 제거 후 정렬(optional)
				$arr_eraseType = array_unique($merged_eraseType);
				sort($arr_eraseType);

				$registeredDate = isset($resData['registeredDate']) ? $resData['registeredDate'] : '';
				$registeredDate = substr($registeredDate, 0, 16);
				$report->registeredDate = $registeredDate;

				// delk_id
				$report->delk_id = $resData['delk_id'];

				//$insurance_number = '2025082011-0001';
				$reg_date_number = str_replace(array('-',' ',':'),'',$registeredDate);
				$insurance_number = substr($reg_date_number, 0, 10);

				$ins_no = format_insurance($dn_idx);

				$report->insurance_number = '#'.$insurance_number.'-'.$ins_no;

				$cus_nm = isset($resData['cus_nm']) ? $resData['cus_nm'] : '';
				//$report->cus_nm = $cus_nm;
				// [2025-09-03] 기부 정보에서 기부자 이름을 가져옵니다.
				$report->cus_nm = $donor_name; 

				$user_nm = isset($resData['user_nm']) ? $resData['user_nm'] : '';
				$report->user_nm = $user_nm;

				$securityofficer = isset($resData['securityofficer']) ? $resData['securityofficer'] : '';
				$report->securityofficer = $securityofficer;

				$ssn = isset($resData['ssn']) ? $resData['ssn'] : 'N/A (파쇄에 따른 미확인)';
				$report->ssn = $ssn;

				$report->erase_ssn = $erase_ssn;


				$file_path = 'https://ros.remann.co.kr/resources/img/inspDel/';

				$file_bfr1_path = isset($resData['file_bfr1_path']) ? $file_path.$resData['file_bfr1_path'] : '';
				$file_ing1_path = isset($resData['file_ing1_path']) ? $file_path.$resData['file_ing1_path'] : '';
				$file_aft1_path = isset($resData['file_aft1_path']) ? $file_path.$resData['file_aft1_path'] : '';
				$file_doc1_path = isset($resData['file_doc1_path']) ? $file_path.$resData['file_doc1_path'] : '';
				/*
				echo $file_bfr1_path.'<<<<<br />';
				echo $file_ing1_path.'<<<<<br />';
				echo $file_aft1_path.'<<<<<br />';
				echo $file_doc1_path.'<<<<<br />';
				*/
				$report->file_bfr1_path = $file_bfr1_path;
				$report->file_ing1_path = $file_ing1_path;
				$report->file_aft1_path = $file_aft1_path;
				$report->file_doc1_path = $file_doc1_path;

				$report->file_bfr1_img = ('' != $file_bfr1_path) ? '<img src="'.$file_bfr1_path.'" />' : '';
				$report->file_ing1_img = ('' != $file_ing1_path) ? '<img src="'.$file_ing1_path.'" />' : '';
				$report->file_aft1_img = ('' != $file_aft1_path) ? '<img src="'.$file_aft1_path.'" />' : '';
				$report->file_doc1_img = ('' != $file_doc1_path) ? '<img src="'.$file_doc1_path.'" />' : '';

				$place_del = '리맨본사(포천시)';
				$report->place_del = $place_del;

				$copyText = '© 2025 사회적기업 (주)리맨. All rights reserved.';
				$report->copyText = $copyText;

				// 문서 만든 날짜. 
				// 접속날짜. 오늘 날짜
				$access_date = date('Y년 m월 d일');
				$report->access_date = $access_date;


			}
			else {
				alert('데이터 삭제 보고서가 아직 작성되지 않았습니다. \n검수가 완료된 후 확인하실 수 있습니다.');
			}
		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -




		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		// ROS에 저장된 상세 검수 현황 가져오기
			// [개발용 주소] // 로컬 작업용 pc
			//$post_url = 'http://183.99.21.70:8080/replus/getInsp';  
			// [실제사용주소]
			$post_url = 'https://ros.remann.co.kr/replus/getInsp'; // ros.remann.co.kr/replus/getInsp

			$cert_key = 'ub9acud50cub7ecuc2a4u0072u006fu0073uc5f0ub3d9';
			$curl_data = array('id'=>$dn_idx,'key'=>$cert_key);
			$output_json = $this->curl_post_ros($post_url, $curl_data); // return 등록한 작업요청id값
			$output_arr = json_decode($output_json, true);
			//print_r($output_arr);

			$item_list = array();
			if( isset($output_arr['data']) && ! empty($output_arr['data']) && ! is_null($output_arr['data'])) {
				foreach ($output_arr['data'] as $i => $item) {
					// print_r($item);
					$item_list[$i] = new stdClass();

					$itm_insp_kind = $item['insp_kind'];
					$itm_grade = $item['grade'];

					$item_list[$i]->insp_kind = $itm_insp_kind;
					$item_list[$i]->mfr = $item['mfr'];
					$item_list[$i]->model = $item['model'];
					$item_list[$i]->sn = $item['sn'];
					$item_list[$i]->registeredDate = $item['registeredDate'];
					$item_list[$i]->rmk_1 = $item['rmk_1'];
					$item_list[$i]->grade = $itm_grade;
				}
			}
		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -



		// 페이지
		$viewPage = 'admin/campaign_donate_report_del_ros_view';


		// 데이터 - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		$data = array(
			'cmp_code' =>$cmp_code,
			'dn_idx' =>$dn_idx,
			'cmp_row' => $cmp_row,
			'dn_row' => $dn_row,

			/*
			'dn_del_result' => $dn_del_result,
			'dn_del_row_photo' => $dn_del_row_photo,
			'dn_del_row_cert' => $dn_del_row_cert,
			'cert_file' => $cert_file,
			'cert_file_url' => $cert_file_url,
			*/

			'res_list' => $res_list,
			'item_list' => $item_list,

			'report' => $report,
			'arr_eraseType' => $arr_eraseType,

			'arr_seg' => $this->arr_seg,
			'viewPage' => $viewPage
		);
		$this->load->view('layout_print_view', $data);
	}



	// 다시 택배 접수하기
	// [2025-09-08] 택배 접수가 안된 건 자동으로 접수시키기
	private function ___trans_retry_cj_book() {

		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		// 리턴 false
		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		//return false;

		$dn_idx = $this->input->post('dn_idx');

		if( $dn_idx > 501 ) {


				// 기부자 정보
				$arr_where = array(
						'sql_select'     => '*',
						'sql_from'       => 'donation',
						'sql_where'      => array('idx'=>$dn_idx, 'delete'=>NULL)
				);
				$dn_row = $this->basic_model->arr_get_row($arr_where);

				//if( isset($dn_row->idx) && ! IS_NULL($dn_row->cj_book) && 'success' != $dn_row->cj_book ) {
				//if( isset($dn_row->idx) && ! IS_NULL($dn_row->cj_book) && 'success' != $dn_row->cj_book ) {
				if( isset($dn_row->idx) && 'success' != $dn_row->cj_book ) {

						// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
						// [2025-08-28]
						// 택배접수 api 
						// 작업요청서 보낸 후, 택배접수 api 전송
						// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
						/*
							id	기부신청id
							rcpt_dv	접수구분 01: 일반, 02: 반품
							name	기부자명
							phone	전화번호(-으로 구분된 연결된전화번호)
							zip_no	우편번호
							addr1	기부자주소
							addr2	기부자상세주소
						*/

						
						// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
						// 택배 신규 접수
						// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
						$rcpt_dv = '01';


						$dn_idx = $dn_row->idx;
						$donor_name = $dn_row->donor_name;
						$dn_phone = $dn_row->cellphone;
						$postcode = $dn_row->postcode;
						$addr = $dn_row->addr;
						$addr_detail = $dn_row->addr_detail;
						// echo $dn_idx.' :: '.$donor_name.'<<<<br />';


						if( '' != $dn_idx) {

							// [개발용 주소] // 로컬 작업용 pc
							//$post_url_cj = 'http://183.99.21.70:8080/cj/regBook';  
							// [실제사용주소]
							$post_url_cj = 'https://ros.remann.co.kr/cj/regBook';

							$curl_data_cj = array(
								'id'=>$dn_idx,
								'rcpt_dv' => $rcpt_dv,
								'name'=>$donor_name,
								'phone'=>$dn_phone,
								'zip_no'=>$postcode,
								'addr1'=>$addr,
								'addr2'=>$addr_detail
							);

							//print_r($curl_data_cj);
							//exit;

							// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - 
							// 택배 접수 보내기
							// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - 
							$output_json = $this->curl_post($post_url_cj, $curl_data_cj); // return 등록한 작업요청id값
							$this->db->simple_query(" UPDATE donation SET cj_memo='".$output_json."' WHERE idx = ".$dn_idx );

							// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - 
							// 택배 접수 결과 저장
							// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - 
							$resArr = json_decode($output_json);
							$cjbook_res = isset($resArr->data) ? $resArr->data : 'error';
							$cjbook_dt = ('error' != $cjbook_res) ? TIME_YMDHIS : '';

							$this->db->simple_query(" UPDATE donation SET cj_book = '".$cjbook_res."', cj_book_dt = '".$cjbook_dt."', cj_book_json='".$output_json."#admin' WHERE idx = ".$dn_idx );

							print_r($output_json);

						}

						//exit;

				}
				else {
					echo '이미 접수된 상태입니다.';
				}


		}
		else {

			echo '501 이하는 제외합니다:'.$dn_idx;

		}

	}





	// 다시 택배 반품하기
	// [2025-09-08] 택배 반품이 안된 건 자동으로 반품시키기
	private function ___trans_retry_cj_return() {

		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		// 리턴 false
		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		//return false;

		$dn_idx = $this->input->post('dn_idx');


		if( $dn_idx > 501 ) {

				// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
				// 0. 기부자 정보
				// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
				$arr = array(
						'sql_select'     => '*',
						'sql_from'       => 'donation',
						'sql_where'      => array('idx'=>$dn_idx, 'delete'=>NULL),
				);
				$dn_row = $this->basic_model->arr_get_row($arr);

				//if( isset($dn_row->idx) && ! IS_NULL($dn_row->cj_return) && 'success' != $dn_row->cj_return ) {
				if( isset($dn_row->idx) && 'success' != $dn_row->cj_return ) {




						// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
						// [2025-08-28]
						// 택배접수 api 
						// 작업요청서 보낸 후, 택배접수 api 전송
						// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
						/*
							id	기부신청id
							rcpt_dv	접수구분 01: 일반, 02: 반품
							name	기부자명
							phone	전화번호(-으로 구분된 연결된전화번호)
							zip_no	우편번호
							addr1	기부자주소
							addr2	기부자상세주소
						*/

						
						// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
						// 택배 신규 접수
						// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
						$rcpt_dv = '02';



						$dn_idx = $dn_row->idx;
						$donor_name = $dn_row->donor_name;
						$dn_phone = $dn_row->cellphone;
						$zip_no = $dn_row->postcode;
						$addr1 = $dn_row->addr;
						$addr2 = $dn_row->addr_detail;



						if( '' != $dn_idx) {

							// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
							// 1. 택배 반품접수 요청 보내기
							// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
							// [개발용 주소] // 로컬 작업용 pc
							//$post_url = 'http://183.99.21.70:8080/cj/regBook_return';  
							// [실제사용주소]
							$post_url = 'https://ros.remann.co.kr/cj/regBook_return';

							$curl_data = array(
								'id'=>$dn_idx,
								'rcpt_dv' => $rcpt_dv, // 반품은 '02'
								'name'=>$donor_name,
								'phone'=>$dn_phone,
								'zip_no'=>$zip_no,
								'addr1'=>$addr1,
								'addr2'=>$addr2
							);
							//print_r($curl_data);
							//exit;

							$output_json = $this->curl_post($post_url, $curl_data);
							// echo $output_json;
							// exit; 
							/*
							{"data":"f:ORA-00001"}
							*/

							//$output_arr = json_decode($output_json, true);
							//$cjreturn_res = $output_arr['data'];

							$output_arr = json_decode($output_json); // false(기본값)
							$cjreturn_res = $output_arr->data;
							//echo $cjreturn_res;
							//exit; 

							$cjreturn_dt = TIME_YMDHIS;

							// 리턴 값 업데이트(donation > cj_return, cj_return_dt, return_json)
							//$this->db->simple_query(" UPDATE donation SET cj_return = '".$cjreturn_res."', cj_return_dt = '".$cjreturn_dt."#admin', cj_return_json='".$output_json."' WHERE idx = ".$dn_idx );
							$this->db->simple_query(" UPDATE donation SET cj_return = '".$cjreturn_res."', cj_return_dt = '".$cjreturn_dt."', cj_return_json='".$output_json."#admin' WHERE idx = ".$dn_idx );

							print_r($output_json);


						}

						//exit;

				}
				else {
					echo '이미 반품접수된 상태입니다.';
				}


		}
		else {

			echo '501 이하는 제외합니다::'.$dn_idx;

		}


	}









	// 기부 - 기부금 영수증 보기
	private function donate_report_receipt($cmp_code=FALSE,$donate_idx=FALSE,$user_idx=FALSE) {

		// 캠페인 정보
			$arr_where = array(
					'sql_select'     => '*',
					'sql_from'       => 'campaign',
					'sql_where'      => array('code'=>$cmp_code)
			);
			$cmp_row = $this->basic_model->arr_get_row($arr_where);

		// 기부자 정보
			$arr_where = array(
					'sql_select'     => '*',
					'sql_from'       => 'donation',
					'sql_where'      => array('idx'=>$donate_idx, 'delete'=>NULL)
			);
			$dn_row = $this->basic_model->arr_get_row($arr_where);




		// Get data.
			$breadcrumb = array(
				'캠페인'=>base_url().'admin/campaign/donate',
				'기부목록'=>base_url().'admin/campaign/donate/lists',
				'기부상세정보'=>base_url().'admin/campaign/donate/donor/'.$cmp_code.'/'.$donate_idx.'/list',
				'기부금 영수증 보기'=>''
			);

			$data = array(
				'cmp_row' => $cmp_row,
				'dn_row' => $dn_row,
				'arr_seg'   => $this->arr_seg, //$this->uri->segment_array(),
				'breadcrumb'    => $breadcrumb,
				'viewPage'  => 'admin/campaign_donate_report_receipt_view'
			);

			$this->load->view('admin/layout_view', $data);
	}




	/** - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	* 캠페인 기부 관련 저장 proc
	*/
	function trans($method=FALSE) {

		$this->load->model('campaign_model');

		if('dn_update' == $method) {
			$res = $this->campaign_lib->trans_dn_update();
			echo $res;
		}
		elseif('dngood_update' == $method) {
			$res = $this->campaign_lib->trans_dngood_update();
			echo $res;
		}
		elseif('dn_reportchk_del' == $method) {
			$res = $this->campaign_lib->trans_dn_reportchk_del();
			echo $res;
		}
		elseif('dn_reportList_del' == $method) {
			$res = $this->campaign_lib->trans_dn_reportList_del();
			echo $res;
		}
		elseif('alimtalk_dn_complete' == $method) {
			$res = $this->campaign_lib->trans_alimtalk_dn_complete();
			echo $res; // 성공 'succ', 실패 'fail'
		}


	}


	// 메인 페이지 - 지금까지 기부된 디지털기기 표시 수량 수동 입력
	public function donated_device() {

		// 
		$this->form_validation->set_rules('device_idx[]', 'idx', 'trim|required|xss_clean');

		$this->form_validation->set_rules('device_name[]', 'device_name', 'trim|xss_clean');
		$this->form_validation->set_rules('device_amount[]', 'device_amount', 'trim|xss_clean');
		$this->form_validation->set_rules('device_display[]', 'device_display', 'trim|xss_clean');
		$this->form_validation->set_rules('device_order[]', 'device_order', 'trim|xss_clean');

		if ($this->form_validation->run() == FALSE)
		{
			//$this->load->view('myform');
		}
		else
		{
			if (!is_null($data = $this->campaign_lib->donated_device())) {		// success
				sess_message('수정되었습니다.');
				redirect(current_url());
			}
		}


		// 디바이스 수량 정보
			$arr_where = array(
					'sql_select'     => '*',
					'sql_from'       => 'donated_device',
					'sql_where'      => array('del_datetime'=>NULL),
					'sql_order_by'   => 'device_display ASC, device_order ASC'
			);
			$result = $this->basic_model->arr_get_result($arr_where);

			//print_r($result);

		// Get data.
			$breadcrumb = array(
				'캠페인'=>base_url().'admin/campaign/donate',
				'수량 관리'=>base_url().'admin/campaign/donated_device'
			);

			$data = array(
				'result' => $result,
				'arr_seg'   => $this->arr_seg, //$this->uri->segment_array(),
				'breadcrumb'    => $breadcrumb,
				'viewPage'  => 'admin/campaign_donated_device_view'
			);

			$this->load->view('admin/layout_view', $data);
	}





	// 메인 페이지 - 지금까지 기부된 금액 수동 입력
	public function donated_amount() {

		// 
		$this->form_validation->set_rules('amt_idx[]', 'idx', 'trim|required|xss_clean');

		$this->form_validation->set_rules('amt_title[]', 'amt_title', 'trim|xss_clean');
		$this->form_validation->set_rules('amt_value[]', 'amt_value', 'trim|xss_clean');
		$this->form_validation->set_rules('amt_display[]', 'amt_display', 'trim|xss_clean');
		$this->form_validation->set_rules('amt_order[]', 'amt_order', 'trim|xss_clean');

		if ($this->form_validation->run() == FALSE)
		{
			//$this->load->view('myform');
		}
		else
		{
			if (!is_null($data = $this->campaign_lib->donated_amount())) {		// success
				sess_message('수정되었습니다.');
				redirect(current_url());
			}
		}


		// 디바이스 수량 정보
			$arr_where = array(
					'sql_select'     => '*',
					'sql_from'       => 'donated_amount',
					'sql_where'      => array('del_datetime'=>NULL),
					'sql_order_by'   => 'amt_display ASC, amt_order ASC'
			);
			$result = $this->basic_model->arr_get_result($arr_where);

			//print_r($result);

		// Get data.
			$breadcrumb = array(
				'캠페인'=>base_url().'admin/campaign/donate',
				'수량 관리'=>base_url().'admin/campaign/donated_amount'
			);

			$data = array(
				'result' => $result,
				'arr_seg'   => $this->arr_seg, //$this->uri->segment_array(),
				'breadcrumb'    => $breadcrumb,
				'viewPage'  => 'admin/campaign_donated_amount_view'
			);

			$this->load->view('admin/layout_view', $data);
	}





	// 메인 페이지 - 월별 누적 사회적 가치(매월 기부물품(수량,대) 및 기부가치(금액,원))
	public function donated_archive() {

		//$this->form_validation->set_rules('arc_idx', 'idx', 'trim|required|xss_clean');

		$this->form_validation->set_rules('date_ym', '연월', 'trim|required|xss_clean');
		$this->form_validation->set_rules('cnt_device', '기부물품수량', 'trim|required|xss_clean');
		$this->form_validation->set_rules('cnt_amt', '기부가치금액', 'trim|required|xss_clean');
		$this->form_validation->set_rules('std_date', '기준일자', 'trim|xss_clean');

		if ($this->form_validation->run() == FALSE)
		{
			//$this->load->view('myform');
		}
		else
		{
			if (!is_null($data = $this->campaign_lib->donated_archive())) {		// success
				sess_message('저장되었습니다.');
				redirect(current_url());
			}
		}


		// 디바이스 수량 정보
			$arr_where = array(
					'sql_select'     => '*',
					'sql_from'       => 'donated_archive',
					'sql_where'      => array('del_datetime'=>NULL),
					'sql_order_by'   => 'date_ym DESC'
			);
			$result = $this->basic_model->arr_get_result($arr_where);

			//print_r($result);

		// Get data.
			$breadcrumb = array(
				'캠페인'=>base_url().'admin/campaign/donate',
				'누적가치 관리'=>base_url().'admin/campaign/donated_archive'
			);

			$data = array(
				'result' => $result,
				'arr_seg'   => $this->arr_seg, //$this->uri->segment_array(),
				'breadcrumb'    => $breadcrumb,
				'viewPage'  => 'admin/campaign_donated_archive_view'
			);

			$this->load->view('admin/layout_view', $data);
	}




}