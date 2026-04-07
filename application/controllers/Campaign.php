<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Campaign extends CI_Controller
{
	function __construct()
	{
		parent::__construct();

		$this->load->helper(array('form', 'url','load'));
		$this->load->library('form_validation');
		$this->load->helper('security');
		$this->load->library('tank_auth');
		$this->lang->load('tank_auth');
		$this->load->library('basic_lib');
		$this->load->library('campaign_lib');
		$this->load->library('upload_lib');
		$this->load->helper('resize');
		//$this->load->model('Upload_model');

		/*
		if (! $this->tank_auth->is_logged_in()) {
			redirect('/auth/login/'. url_code($this->uri->uri_string(), 'e'));
		}
		*/
		
		$this->arr_seg = $this->uri->segment_array();
		$this->user_idx = $this->tank_auth->get_user_id();
		$this->username = $this->tank_auth->get_username();
		$this->user = array();
		if( $this->tank_auth->is_admin() ) {
			$this->user = $this->tank_auth->get_admininfo_idx($this->user_idx);
		}
		elseif($this->username && '' != $this->username) {
			$this->user = $this->tank_auth->get_userinfo($this->username);
		}

		load_js('<script src="'.JS_DIR.'/campaign_script.js?v=<?php echo time() ?>"></script>');

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



		// echo $this->meta_row->page_title;
		//$this->first_code = 'CAMPAIGN';
		//$this->page_code = 'CAMPAIGN';

		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		// 메뉴 정보 가져오기
		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		$page_code = 'CAMPAIGN';
		$meta_arr = array('sql_select' => '*','sql_from' => 'mng_cms','sql_where' => array('page_code'=>$page_code));
		$this->cms_row = $this->basic_model->arr_get_row($meta_arr);
		if((! isset($this->cms_row->page_code) OR $this->cms_row->del_datetime !== NULL)) {
			alert('이미 삭제되었거나, 존재하지 않는 페이지입니다.', base_url());
		}

		// echo $this->cms_row->page_title;
		$this->first_code = $this->cms_row->first_code;
		$this->page_code = $this->cms_row->page_code;




		/* - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		* UTM 파라미터 추가
		* - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - */
		$arr_param = $_GET;
		$this->utm_qstr = '';
		$arr_utm = array('utm_source','utm_medium','utm_campaign','utm_content','utm_term');
		foreach($arr_utm as $i => $param) {

			if(isset($this->arr_seg[2]) && 'campaign'==$this->arr_seg[1] && 'detail'==$this->arr_seg[2]){
				if('utm_medium' == $param && isset($arr_param[$param]) && 'cpc_detail'==$arr_param[$param]){
					$arr_param[$param] = 'cpc_donation';
				}
			}
			$this->utm_qstr .= ($i > 0 && isset($arr_param[$param]) && '' != $arr_param[$param]) ? '&' : '';
			$this->utm_qstr .= (isset($arr_param[$param]) && '' != $arr_param[$param]) ? $param.'='.$arr_param[$param] : '';
		}

	}

	function index()
	{
		redirect('/campaign/lists');
	}


	function direct_waRegi() {



		$user_idx = ''; // 2370;
		$dn_idx = ''; // 829;
		$cmp_title = ''; // '리플러스박스와 함께하는 디지털기기 안심 회수 캠페인';

		// cert_key 값은 ROS 제공
		$cert_key = 'ub9acud50cub7ecuc2a4u0072u006fu0073uc5f0ub3d9';



		if($user_idx != '' && $dn_idx != '' && $cmp_title != '') 
		{


				// 대표이미지(목록 및 캠페인 대표 이미지)
				$arr_where = array(
						'sql_select'     => '*',
						'sql_from'       => 'donation',
						'sql_where'      => array('idx'=>$dn_idx)
				);
				$row = $this->basic_model->arr_get_row($arr_where);
				//print_r($row);
				//echo '<hr />';

				// 이름
				$donor_name = $row->donor_name;
				// 메모
				$dn_rmk = $row->goods_memo;
				// 주소, 전화번호, 이메일
				$dn_phone = $row->cellphone;
				$dn_email = $row->email;
				$dn_addr = $row->postcode.' '.$row->addr.' '.$row->addr_detail;
				$dn_rmk .= '\n - - - - - - - - - \n';
				$dn_rmk .= $dn_phone.'\n';
				$dn_rmk .= $dn_email.'\n';
				$dn_rmk .= $dn_addr.'\n';
				$dn_rmk .= '수거요청일자: ';
				$dn_rmk .= ('' != $row->pickup_date_plz) ? $row->pickup_date_plz : ' 요청 없음';
				$dn_rmk .= '\n';

				//print_r($dn_rmk);
				//echo '<hr />';



				// 기부물품 종류 코드
				$arr_ctgr = array('스마트폰'=>'ph','태블릿'=>'tb','노트북'=>'lt','데스크탑'=>'dt','기타'=>'etc');



				$arr = array(
						'sql_select'       => '*',
						'sql_from'         => 'donation_goods',
						'sql_where'        => array('user_idx'=>$user_idx,'dn_idx'=>$dn_idx),
						'sql_order_by'     => 'idx DESC'
				);
				$result = $this->basic_model->arr_get_result($arr);


				$data_good = array();
				$data_items['items'] = array();
				$str_item_cnt = '';

				foreach($result['qry'] as $key => $row) {

					$goods_kind = $row->gd_type;
					$goods_amt = $row->gd_amt;
					$code_ctgr = isset($arr_ctgr[$goods_kind]) ? $arr_ctgr[$goods_kind] : '';
					$data_good = array('ctgr'=>$code_ctgr, 'qty'=>$goods_amt);
					$data_items['items'][] = $data_good;

					// $str_item_cnt
					// 스마트폰2.태블릿3.노트북1
					// 스마트폰12.태블릿4.노트북2
					if('' != $goods_amt && $goods_amt > 0) {
						$str_item_cnt .= ('' != $str_item_cnt) ? '.' : '';
						$str_item_cnt .= $goods_kind.$goods_amt;
					}
				}

				// json 만들기 - 기부 물품 정보
				// {"items":[{"ctgr":dt,"qty":2},{"ctgr":lt,"qty":2}]}

				$dn_items_json = json_encode($data_items);

				/*
				echo $str_item_cnt;
				echo '<hr />';
				print_r($data_items);
				echo '<hr />';
				print_r($dn_items_json);
				echo '<hr />';
				exit;
				*/


				// [개발용 주소] // 로컬 작업용 pc
				// $post_url = 'http://183.99.21.70:8080/replus/waRegi';  
				// [실제사용주소]
				$post_url = 'https://ros.remann.co.kr/replus/waRegi';

				$curl_data = array(
					'id'=>$dn_idx,
					'campaign'=>$cmp_title,
					'name'=>$donor_name,
					'items'=>$dn_items_json,
					'rmk'=>$dn_rmk,
					'key'=>$cert_key,
					'itemstr'=>$str_item_cnt
				);
				$output = $this->curl_post($post_url, $curl_data); // return 등록한 작업요청id값

				echo $output.'<<<<<<<<br />';

				if( $output && $output > 0 ) {
					// 업데이트
					$ros_wa_id = $output;
					$this->db->simple_query(" UPDATE donation SET ros_wa_id = ".$ros_wa_id." WHERE idx = ".$dn_idx );
				}


		}

	}



	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	// [1] 기부 캠페인
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -


	// 캠페인 목록
	function lists()
	{


			// 상단 탑배너 이미지 - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

			// pc
			$top_bnr_pc = $this->basic_model->get_banner_list('campaign_top_pc',10);

			// mobile
			$top_bnr_mobile = $this->basic_model->get_banner_list('campaign_top_mobile',10);




			// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
			// 페이징 정보 
			// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
			$this->load->library('segment', array('offset'=>3), 'seg'); // 세그먼트 주소( page 위치 )
			$this->load->library('querystring', NULL, 'param'); // 쿼리스트링 주소
			$seg	  =& $this->seg;
			$param	  =& $this->param;

			// [페이징]
			$qstr = '';

			// [분류]
			$get_cate_name = $param->get('cate', false);
			$qstr = ( $get_cate_name ) ? '?cate='.$get_cate_name : '';

			// [종료]
			if($get_term = $param->get('term','')) { // order_field
				$qstr .= ('' == $qstr) ? '?' : '&';
				$qstr .= ($get_term != '') ? 'term='.$get_term : '';
			}

			// [정렬]
			if($ofl = $param->get('ofl','')) { // order_field
				$qstr .= ('' == $qstr) ? '?' : '&';
				$qstr .= ($ofl != '') ? 'ofl='.$ofl : '';
			}


			// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
			// sql 
			// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
			$sql_select = '*';
			$sql_from = 'campaign';
			$sql_where = array('state'=>'launch','dsp_admin'=>NULL);
			$sql_group_by = FALSE;
			$sql_order_by = (isset($ofl) && '' != $ofl) ? $ofl : 'cmp_term_begin DESC, reg_datetime DESC';

			if($get_term == 'ended') {
				// 종료 캠페인
				$sql_where['cmp_term_end < '] = date('Y-m-d');
			}
			else {
				// 진행중인 캠페인
				//$sql_where['cmp_term_begin <= '] = date('Y-m-d');
				$sql_where['cmp_term_end >= '] = date('Y-m-d');
			}

			// 페이징
			$limit = 12; //'20';
			$page  = $seg->get('page', 1); // 페이지
			if(! isset($page) OR empty($page)) {
				$page = '1';
			}
			$offset = ($page - 1) * $limit;


			// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
			// 전체 수
			// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
			// 검색 상관없는 전체 수
			$total_count_all = $this->basic_model->get_common_count($sql_from,$sql_where);

			// 카테고리 메뉴 사용시
			$cate_name = $param->get('cate', false);
			if( $cate_name && 'all' != $cate_name) {
				$sql_where['cmp_cate'] = $cate_name;
			}


			$arr = array(
					'sql_select'       => $sql_select,
					'sql_from'         => $sql_from,
					'sql_where'        => $sql_where,
					'sql_group_by'     => $sql_group_by,
					'sql_order_by'     => $sql_order_by,
					'page'             => $page,
					'limit'            => $limit,
					'offset'           => $offset,
			);
			$result = $this->basic_model->arr_get_result($arr);


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
				$list[$ino]->code = $row->code;
				$list[$ino]->cmp_cate = $row->cmp_cate;
				$list[$ino]->cmp_title = $row->cmp_title;
				$list[$ino]->cmp_term_begin = $row->cmp_term_begin;
				$list[$ino]->cmp_term_end = $row->cmp_term_end;
				$list[$ino]->cmp_term = $row->cmp_term_begin.'~'.$row->cmp_term_end;



				// cmp_tag_bg_green, cmp_tag_bg_blue

				$cmp_tag_bg = '';
				if( '지구를 위해' == $row->cmp_cate ) {
					$cmp_tag_bg = 'cmp_tag_bg_green';
				}
				else if( '이웃을 위해' == $row->cmp_cate ) {
					$cmp_tag_bg = 'cmp_tag_bg_blue';
				}
				$list[$ino]->cmp_tag_bg = $cmp_tag_bg;


				// 남은 날짜
				$left_date = intval((strtotime($row->cmp_term_end)-strtotime(date('Y-m-d'))) / 86400); // 나머지 날짜값이 나옵니다.
				if($left_date > 0) {
					$left_date_str = $left_date.'일 남음';
				}
				else if($left_date < 0) {
					$left_date_str = '종료';
				}
				else {
					$left_date_str = '오늘 마감';
				}
				$list[$ino]->left_date_str = $left_date_str;

				// 남은 날짜 percent
				$total_day = intval((strtotime($row->cmp_term_end)-strtotime($row->cmp_term_begin)) / 86400); // 나머지 날짜값이 나옵니다.
				$left_day = intval((strtotime($row->cmp_term_end)-strtotime(date('Y-m-d'))) / 86400); // 나머지 날짜값이 나옵니다.

				//echo $total_day.'<<<<<<br />';
				//exit;

				if($total_day === 0) {
					$total_day = 1;
				}



				$cmp_term_end_2024 = ($left_date < 0) ? '종료' : date('~ Y년 m월 d일까지',strtotime($row->cmp_term_end));
				$list[$ino]->cmp_term_end_2024 = $cmp_term_end_2024;




				$left_day = ($left_day < 0) ? 0 : $left_day;
				$left_date_per = 100 - intval(($left_day/$total_day)*100);
				$list[$ino]->left_date_per = $left_date_per;


				$list[$ino]->cmp_org_name = $row->cmp_org_name;
				$list[$ino]->cmp_org_info = $row->cmp_org_info;

				$list[$ino]->reg_datetime = $row->reg_datetime;
				$list[$ino]->reg_date = substr($row->reg_datetime,0,10);
				$list[$ino]->state = $row->state;
				$state_str = '<button class="btn o_btn btn-xs btn-silver-flat" disabled>작성</button>';
				if('submit' == $row->state) :
					$state_str = '<button class="btn o_btn btn-xs btn-success-flat">제출</button>';
				elseif('launch' == $row->state) :
					$state_str = '<button class="btn o_btn btn-xs btn-primary-flat">런칭</button>';
				endif;


				$list[$ino]->state_str = $state_str;


				// 대표이미지(목록 및 캠페인 대표 이미지)
				$arr_where = array(
						'sql_select'     => '*',
						'sql_from'       => 'file_manager',
						'sql_where'      => array('wr_table'=>'campaign','wr_table_idx'=>$row->idx,'upload_type'=>'form','file_type'=>'image','gubun'=>'list'),
						'sql_order_by'   => 'idx DESC',
						'limit'          => 1
				);
				$file_row = $this->basic_model->arr_get_row($arr_where);
				$file_idx = isset($file_row->idx) ? $file_row->idx : '';
				$campaign_main_img = '';
				if(! empty($file_row)) {
					//$this->load->helper('resize');
					$img_w = '400';
					$img_h = '300';
					//$thumb_img = resize_thumb_image($file_row->file_name, $file_row->file_dir, $file_row->file_dir.'/thumb', $img_w,$img_h,FALSE,'auto','img');
					//$campaign_main_img = $thumb_img;
					$thumb_src = resize_thumb_image($file_row->file_name, $file_row->file_dir, $file_row->file_dir.'/thumb', $img_w,$img_h,FALSE,'auto','src');
					$campaign_main_src = $thumb_src;
				}
				$list[$ino]->file_idx = $file_idx;
				//$list[$ino]->campaign_main_img = $campaign_main_img;
				$list[$ino]->campaign_main_src = $campaign_main_src;






				// 목표 기기 수량 총합 [campaign]
				$goal_amt = 0;
				$goal_amt += intVal($row->goal_amt_1);
				$goal_amt += intVal($row->goal_amt_2);
				$goal_amt += intVal($row->goal_amt_3);
				$goal_amt += intVal($row->goal_amt_4);
				$goal_amt += intVal($row->goal_amt_5);
				//echo $goal_amt.'<<<';
				$list[$ino]->goal_amt = $goal_amt;

				// 관리자가 입력한 기기 수량 총합 [donation]
				// 기부 정보
				$arr_where = array(
						//'sql_select'     => 'dng.*',
						'sql_select'     => 'sum(dng.gd_amt) as tot_amt',
						'sql_from'       => 'donation as dn',
						'sql_join_tbl'   => 'donation_goods as dng',
						'sql_join_on'    => 'dn.idx = dng.dn_idx',
						'sql_where'      => array('dn.cmp_code'=>$row->code),
				);
				$dn_row = $this->basic_model->arr_get_row($arr_where);
				//print_r($dn_row);
				$dng_total_amt = $dn_row->tot_amt;
				$list[$ino]->dng_total_amt = $dng_total_amt;

				// 기부율 (수량으로 계산)
				$dn_per = 0;
				if($goal_amt > 0) {
					$dn_per = ($dng_total_amt / $goal_amt) * 100;
				}
				//echo $dn_per.'%';
				$list[$ino]->dn_per = $dn_per;



				// 기부가치평가 금액
				$arr_where = array(
						'sql_select'     => 'donation_value', 
						'sql_from'       => 'donation',
						'sql_where'      => array('cmp_code'=>$row->code,'state_recycle'=>1), // 관리자가 재생중에 완료 체크한 것만 처리
				);
				$dn_result = $this->basic_model->arr_get_result($arr_where);

				$donation_value = 0;
				foreach($dn_result['qry'] as $dn_key => $dn_row) {
					if( isset($dn_row->donation_value) && intVal($dn_row->donation_value) > 0 ) {
						$donation_value += intVal($dn_row->donation_value);
					}
				}
				$list[$ino]->donation_value = number_format($donation_value);

				$ino++;
			}






		// pagination 설정
			$config['suffix']	   = $qstr; //$qstr;
			$config['base_url']    = base_url() .'campaign/lists/page/';
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


		// load css, js  - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
			load_css('<link rel="stylesheet" href="'.LIB_DIR.'/slider/slick-1.8.1/slick/slick.css" />');
			load_js('<script src="'.LIB_DIR.'/slider/slick-1.8.1/slick/slick.min.js"></script>');



		// 페이지
			$viewPage = 'campaign/lists_view';

		// 데이터 - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
			$data = array(
				'arr_seg' => $this->arr_seg,
				'cate_name' => $get_cate_name,
				'paging' => $paging_html,
				'term' => $get_term,
				
				'top_bnr_pc' => $top_bnr_pc,
				'top_bnr_mobile' => $top_bnr_mobile,

				'list' => $list,
				'viewPage' => $viewPage
			);
			$this->load->view('layout_view', $data);
	}



	// 캠페인 미리보기
	function preview()
	{

		// # [2017-03-22] 에러 메시지 CSS
		$this->form_validation->set_error_delimiters('<div class="error_board_admin">','</div>');

		if( $this->input->post('submit') ) {
			
			$this->form_validation->set_rules('code', '캠페인 코드', 'trim|required|xss_clean');
			if ($this->form_validation->run()) {	// validation ok

				$code = $this->input->post('code');

				if(! $code) {
					alert('존재하지 않거나 삭제된 캠페인입니다.');
					exit;
				}

				// 캠페인 정보
				$arr_where = array(
						'sql_select'     => '*',
						'sql_from'       => 'campaign',
						'sql_where'      => array('code'=>$code)
				);
				$row = $this->basic_model->arr_get_row($arr_where);

				if(! isset($row->idx)) {
					alert('존재하지 않거나 삭제된 캠페인입니다.');
					exit;
				}






				// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
				// 대표이미지(목록 및 캠페인 대표 이미지)
					$arr_where = array(
							'sql_select'     => '*',
							'sql_from'       => 'file_manager',
							//'sql_where'      => array('wr_table'=>'campaign','wr_table_idx'=>$row->idx,'upload_type'=>'form','file_type'=>'image'),
							'sql_where'      => array('wr_table'=>'campaign','wr_table_idx'=>$row->idx,'upload_type'=>'form','gubun'=>'list'),
							'sql_order_by'   => 'idx DESC',
							'limit'          => 1
					);
					$file_row = $this->basic_model->arr_get_row($arr_where);
					//echo $this->db->last_query();
					if(! empty($file_row)) {
						//$this->load->helper('resize');
						$img_w = '870'; // 750
						$img_h = '';

						$thumb_img = resize_thumb_image($file_row->file_name, $file_row->file_dir, $file_row->file_dir.'/thumb', $img_w,$img_h,FALSE,'width','img');
						$row->campaign_main_img = $thumb_img;

						$thumb_src = resize_thumb_image($file_row->file_name, $file_row->file_dir, $file_row->file_dir.'/thumb', $img_w,$img_h,FALSE,'width','src');
						$row->campaign_main_src = $thumb_src;


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
							//'sql_where'      => array('wr_table'=>'campaign','wr_table_idx'=>$row->idx,'upload_type'=>'form','file_type'=>'image','gubun'=>'ctnt_img'),
							'sql_where'      => array('wr_table'=>'campaign','wr_table_idx'=>$row->idx,'upload_type'=>'form','gubun'=>'ctnt_img'),
							'sql_order_by'   => 'idx DESC',
							'limit'          => 10
					);
					$file_result = $this->basic_model->arr_get_result($arr_where);
					$ctnt_file_idx = array();
					$ctnt_file_img = array();
					$ctnt_file_src = array();
					foreach($file_result['qry'] as $k => $o) {
						$ctnt_file_idx[$o->down_no] = $o->idx;
						$thumb_img = resize_thumb_image($o->file_name, $o->file_dir, $o->file_dir.'/thumb', $img_w,$img_h,FALSE,'width','img');
						$ctnt_file_img[$o->down_no] = $thumb_img;
						$thumb_src = resize_thumb_image($o->file_name, $o->file_dir, $o->file_dir.'/thumb', $img_w,$img_h,FALSE,'width','src');
						$ctnt_file_src[$o->down_no] = $thumb_src;
					}







				// 캠페인 정보
					$cmp = new stdClass();

					$cmp->cate = isset($row->cmp_cate) ? $row->cmp_cate : '';
					$cmp->title = isset($row->cmp_title) ? $row->cmp_title : '';
					$cmp->content = isset($row->cmp_content) ? $row->cmp_content : '';
					/*
					$goal_money = isset($row->cmp_goal_money) ? $row->cmp_goal_money : 0;
					$goal_money = ($goal_money > 0) ? intVal($goal_money / 10000) : 0;
					$cmp->goal_money = number_format($goal_money);
					*/

					$goal_money = isset($row->cmp_goal_money) ? intVal($row->cmp_goal_money) : 0;
					$cmp->goal_money = $goal_money;
					$cmp->goal_money_comma = ($goal_money != '') ? number_format($goal_money) : '';

					$goal_money_10000 = ($goal_money > 0) ? intVal($goal_money / 10000) : '';
					$cmp->goal_money_10000 = ($goal_money_10000 != '') ? number_format($goal_money_10000) : '';



					//$cmp->goal_desc = isset($row->cmp_goal_desc) ? nl2br($row->cmp_goal_desc) : '';
					//$goal_desc = '<ul class="device_amount">';
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
					$cmp->org_link = isset($row->cmp_org_link) ? $row->cmp_org_link : '';
					$cmp->writer_idx = isset($row->writer_idx) ? $row->writer_idx : '';
					$cmp->writer_name = isset($row->writer_name) ? $row->writer_name : '';
					$cmp->state = isset($row->state) ? $row->state : '';

					// 캠페인 자세히 보기 링크(함께 하는 기관 해당 단체로 연결)
					$cmp->cmp_website = isset($row->cmp_website) ? $row->cmp_website : '';


					$cmp->campaign_main_img = isset($row->campaign_main_img) ? $row->campaign_main_img : '';
					$cmp->campaign_main_src = isset($row->campaign_main_src) ? $row->campaign_main_src : '';


					// 캠페인 컨텐츠 단락 정보
					$cmp->ctnt_ttl_1 = isset($row->ctnt_ttl_1) ? $row->ctnt_ttl_1 : '';
					$cmp->ctnt_ttl_2 = isset($row->ctnt_ttl_2) ? $row->ctnt_ttl_2 : '';
					$cmp->ctnt_ttl_3 = isset($row->ctnt_ttl_3) ? $row->ctnt_ttl_3 : '';
					$cmp->ctnt_detail_1 = isset($row->ctnt_detail_1) ? $row->ctnt_detail_1 : '';
					$cmp->ctnt_detail_2 = isset($row->ctnt_detail_2) ? $row->ctnt_detail_2 : '';
					$cmp->ctnt_detail_3 = isset($row->ctnt_detail_3) ? $row->ctnt_detail_3 : '';

					$cmp->ctnt_file_idx = $ctnt_file_idx;
					$cmp->ctnt_file_img = $ctnt_file_img;
					$cmp->ctnt_file_src = $ctnt_file_src;


				// 남은 날짜 percent
					$total_day = intval((strtotime($row->cmp_term_end)-strtotime($row->cmp_term_begin)) / 86400); // 나머지 날짜값이 나옵니다.
					$left_day = intval((strtotime($row->cmp_term_end)-strtotime(date('Y-m-d'))) / 86400); // 나머지 날짜값이 나옵니다.

					$left_day = ($left_day < 0) ? 0 : $left_day;
					$total_day = ($total_day < 1) ? 1 : $total_day;
					$left_date_per = 100 - intval(($left_day/$total_day)*100);
					$cmp->left_date_per = $left_date_per;


				// 남은 날짜
					$left_date = intval((strtotime($row->cmp_term_end)-strtotime(date('Y-m-d'))) / 86400); // 나머지 날짜값이 나옵니다.
					if($left_date > 0) {
						$left_date_str = $left_date.'일 남음';
					}
					else if($left_date < 0) {
						$left_date_str = '종료';
					}
					else {
						$left_date_str = '오늘 마감';
					}
					$cmp->left_date_str = $left_date_str;



				// 기부가치평가 금액
					$arr_where = array(
							'sql_select'     => 'donation_value', 
							'sql_from'       => 'donation',
							'sql_where'      => array('cmp_code'=>$row->code,'state_recycle'=>1), // 관리자가 재생중에 완료 체크한 것만 처리
					);
					$dn_result = $this->basic_model->arr_get_result($arr_where);

					$donation_value = 0;
					foreach($dn_result['qry'] as $dn_key => $dn_row) {
						if( isset($dn_row->donation_value) && intVal($dn_row->donation_value) > 0 ) {
							$donation_value += intVal($dn_row->donation_value);
						}
					}
					$cmp->donation_value = number_format($donation_value);



				// [2024-12-02] 캠페인별(주관단체별) 기부가치 합산 금액
					$arr_where_dnval = array(
							'sql_select'     => 'sum(donation_value) as totVal',
							'sql_from'       => 'donation',
							'sql_where'      => array('cmp_code'=>$row->code,'delete'=>NULL),
					);
					$dnval_row = $this->basic_model->arr_get_row($arr_where_dnval);
					$dnval_tot_val = $dnval_row->totVal;

					$cmp->dnval_tot_val = ($dnval_tot_val > 0) ? number_format($dnval_tot_val).'원' : '';

				// [2024-12-02] 캠페인 진행율
					$rate_cmp_goal = '';
					if($dnval_tot_val != '' && $goal_money != '' && $goal_money > 0) {
						$rate_cmp_goal = $dnval_tot_val / $goal_money * 100;
					}
					$cmp->rate_cmp_goal = $rate_cmp_goal;


					// 캠페인 진행율
					$goal_per = ($cmp->goal_money > 0) ? intVal($dnval_tot_val / $cmp->goal_money) : 0;
					$cmp->goal_per = $goal_per;
					//echo $goal_per.'<<<<';


					// 페이지
					$viewPage = 'campaign/preview_view';

					//print_r($row);

					// 로그인 회원이 캠페인 작성자인 경우 true, 아니면 false
					$login_is_writer = (isset($this->user->id) && $this->user->id == $row->writer_idx && $this->user->level == 20) ? true : false;
					


					// 데이터 - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
					$data = array(
						'arr_seg' => $this->arr_seg,
						'code' => $code,
						'cidx' => $row->idx,
						//'cmptab' => $cmptab, // campaign, comment
						'row' => $row,
						'cmp' => $cmp,
						'viewPage' => $viewPage
					);
					$this->load->view('layout_view', $data);


			}

		}
		else {

			alert('잘못된 경로로 접속하셨습니다.');
			return false;

		}

	}


	// 캠페인 상세
	//function detail($cidx=FALSE)
	function detail($code=FALSE)
	{

		if(! $code) {
			alert('존재하지 않거나 삭제된 캠페인입니다.',base_url().'campaign/lists');
			exit;
		}

		// 캠페인 정보
		$arr_where = array(
				'sql_select'     => '*',
				'sql_from'       => 'campaign',
				//'sql_where'      => array('idx'=>$cidx)
				'sql_where'      => array('code'=>$code,'state'=>'launch')
		);
		$row = $this->basic_model->arr_get_row($arr_where);

		if(! isset($row->idx)) {
			alert('존재하지 않거나 삭제된 캠페인입니다.',base_url().'campaign/lists');
			exit;
		}


		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		// 캠페인 방문자 체크
		// * 캠페인 런칭 기간에만 작동하도록 세팅
		// * cmp_term_begin ~ cmp_term_end 
		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		// echo $row->cmp_term_begin.'~'.$row->cmp_term_end;

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

		// 각종 변수
		$php_self     = $this->input->server('PHP_SELF');
		$http_referer = $this->input->server('HTTP_REFERER');
		$visit_agent = $this->input->server('HTTP_USER_AGENT');
		$visit_ip = $this->input->server('REMOTE_ADDR');
		$visit_referer = ($http_referer) ? $http_referer : $php_self;

		if($row->cmp_term_begin <= $today  &&  $today <= $row->cmp_term_end) 
		{

				// 저장
				$data = array('cmp_code'=>$code,'ip'=>$visit_ip, 'dt'=>TIME_YMDHIS, 'agent'=>$visit_agent, 'referer'=>$visit_referer);
				
				$isBot = $this->basic_lib->isBot($visit_agent);
				if($isBot) {
					//봇
					$data['chk_bot']=1;
				}
				$this->db->insert('campaign_visit', $data);


				// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
				// 기본 통계
				// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
				// stat 테이블 처리
				$data_stat = array('date'=>$this_monday, 'cmp_code'=>$code);
				if($isBot) { $data_stat['cnt_bot']=1;    /* 봇 */ }
				else       { $data_stat['cnt_human']=1;  /* 아마도 휴먼 */ }
				$dt_visit_cnt = $this->basic_model->get_common_count('campaign_visit_stat_week', array('date' => $this_monday,'cmp_code' => $code));
				if( $dt_visit_cnt > 0 ) {
					// 업데이트
					$sql_update_cnt = ($isBot) ? ' cnt_bot = cnt_bot + 1 ' : ' cnt_human = cnt_human + 1 ';
					$this->db->simple_query(" UPDATE campaign_visit_stat_week SET ".$sql_update_cnt." WHERE date = '".$this_monday."' AND cmp_code = '".$code."';");
				}
				else {
					// 신규
					$this->db->insert('campaign_visit_stat_week', $data_stat);
				}


				// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
				// 주간 통계
				// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
				// stat_week 테이블 처리
				$data_stat = array('date'=>TIME_YMD, 'cmp_code'=>$code);
				if($isBot) { $data_stat['cnt_bot']=1;    /* 봇 */ }
				else       { $data_stat['cnt_human']=1;  /* 아마도 휴먼 */ }
				$dt_visit_cnt = $this->basic_model->get_common_count('campaign_visit_stat', array('date' => date('Y-m-d'),'cmp_code' => $code));
				if( $dt_visit_cnt > 0 ) {
					// 업데이트
					$sql_update_cnt = ($isBot) ? ' cnt_bot = cnt_bot + 1 ' : ' cnt_human = cnt_human + 1 ';
					$this->db->simple_query(" UPDATE campaign_visit_stat SET ".$sql_update_cnt." WHERE date = '".date('Y-m-d')."' AND cmp_code = '".$code."';");
				}
				else {
					// 신규
					$this->db->insert('campaign_visit_stat', $data_stat);
				}



				/* 
				* 캠페인 테이블에 바로 업데이트
				*/
				$sql_update_cmp = ($isBot) ? ' visit_bot = visit_bot + 1 ' : ' visit_human = visit_human + 1 ';
				$this->db->simple_query(" UPDATE campaign SET ".$sql_update_cmp." WHERE code = '".$code."';");

		}




		// 대표이미지(목록 및 캠페인 대표 이미지)
		$arr_where = array(
				'sql_select'     => '*',
				'sql_from'       => 'file_manager',
				'sql_where'      => array('wr_table'=>'campaign','wr_table_idx'=>$row->idx,'upload_type'=>'form','file_type'=>'image','gubun'=>'list'),
				'sql_order_by'   => 'idx DESC',
				'limit'          => 1
		);
		$file_row = $this->basic_model->arr_get_row($arr_where);
		//echo $this->db->last_query();
		if(! empty($file_row)) {
			//$this->load->helper('resize');
			$img_w = '870'; // 750
			$img_h = '';

			$thumb_img = resize_thumb_image($file_row->file_name, $file_row->file_dir, $file_row->file_dir.'/thumb', $img_w,$img_h,FALSE,'width','img');
			$row->campaign_main_img = $thumb_img;

			$thumb_src = resize_thumb_image($file_row->file_name, $file_row->file_dir, $file_row->file_dir.'/thumb', $img_w,$img_h,FALSE,'width','src');
			$row->campaign_main_src = $thumb_src;


			$row->file_idx = $file_row->idx;
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
		$ctnt_file_idx = array();
		$ctnt_file_img = array();
		$ctnt_file_src = array();
		foreach($file_result['qry'] as $k => $o) {
			$ctnt_file_idx[$o->down_no] = $o->idx;
			$thumb_img = resize_thumb_image($o->file_name, $o->file_dir, $o->file_dir.'/thumb', $img_w,$img_h,FALSE,'width','img');
			$ctnt_file_img[$o->down_no] = $thumb_img;
			$thumb_src = resize_thumb_image($o->file_name, $o->file_dir, $o->file_dir.'/thumb', $img_w,$img_h,FALSE,'width','src');
			$ctnt_file_src[$o->down_no] = $thumb_src;
		}




		$cmp = new stdClass();

		$cmp->cate = isset($row->cmp_cate) ? $row->cmp_cate : '';
		$cmp->title = isset($row->cmp_title) ? $row->cmp_title : '';
		$cmp->content = isset($row->cmp_content) ? $row->cmp_content : '';

		/*
		$goal_money = isset($row->cmp_goal_money) ? $row->cmp_goal_money : 0;
		$goal_money = ($goal_money > 0) ? intVal($goal_money / 10000) : 0;
		$cmp->goal_money = number_format($goal_money);
		*/

		$goal_money = isset($row->cmp_goal_money) ? intVal($row->cmp_goal_money) : 0;
		$cmp->goal_money = $goal_money;
		$cmp->goal_money_comma = ($goal_money != '') ? number_format($goal_money) : '';

		$goal_money_10000 = ($goal_money > 0) ? intVal($goal_money / 10000) : '';
		$cmp->goal_money_10000 = ($goal_money_10000 != '') ? number_format($goal_money_10000) : '';




		//$cmp->goal_desc = isset($row->cmp_goal_desc) ? nl2br($row->cmp_goal_desc) : '';
		//$goal_desc = '<ul class="device_amount">';
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
		$cmp->org_link = isset($row->cmp_org_link) ? $row->cmp_org_link : '';
		$cmp->writer_idx = isset($row->writer_idx) ? $row->writer_idx : '';
		$cmp->writer_name = isset($row->writer_name) ? $row->writer_name : '';
		$cmp->state = isset($row->state) ? $row->state : '';

		// 캠페인 자세히 보기 링크(함께 하는 기관 해당 단체로 연결)
		$cmp->cmp_website = isset($row->cmp_website) ? $row->cmp_website : '';


		$cmp->campaign_main_img = isset($row->campaign_main_img) ? $row->campaign_main_img : '';
		$cmp->campaign_main_src = isset($row->campaign_main_src) ? $row->campaign_main_src : '';

		// 캠페인 컨텐츠 단락 정보
		$cmp->ctnt_ttl_1 = isset($row->ctnt_ttl_1) ? $row->ctnt_ttl_1 : '';
		$cmp->ctnt_ttl_2 = isset($row->ctnt_ttl_2) ? $row->ctnt_ttl_2 : '';
		$cmp->ctnt_ttl_3 = isset($row->ctnt_ttl_3) ? $row->ctnt_ttl_3 : '';
		$cmp->ctnt_detail_1 = isset($row->ctnt_detail_1) ? $row->ctnt_detail_1 : '';
		$cmp->ctnt_detail_2 = isset($row->ctnt_detail_2) ? $row->ctnt_detail_2 : '';
		$cmp->ctnt_detail_3 = isset($row->ctnt_detail_3) ? $row->ctnt_detail_3 : '';

		$cmp->ctnt_file_idx = $ctnt_file_idx;
		$cmp->ctnt_file_img = $ctnt_file_img;
		$cmp->ctnt_file_src = $ctnt_file_src;



		// 남은 날짜 percent
			$total_day = intval((strtotime($row->cmp_term_end)-strtotime($row->cmp_term_begin)) / 86400); // 나머지 날짜값이 나옵니다.
			$left_day = intval((strtotime($row->cmp_term_end)-strtotime(date('Y-m-d'))) / 86400); // 나머지 날짜값이 나옵니다.

			$left_day = ($left_day < 0) ? 0 : $left_day;
			$total_day = ($total_day < 1) ? 1 : $total_day;
			$left_date_per = 100 - intval(($left_day/$total_day)*100);
			$cmp->left_date_per = $left_date_per;


		// 남은 날짜
			$left_date = intval((strtotime($row->cmp_term_end)-strtotime(date('Y-m-d'))) / 86400); // 나머지 날짜값이 나옵니다.
			if($left_date > 0) {
				$left_date_str = $left_date.'일 남음';
			}
			else if($left_date < 0) {
				$left_date_str = '종료';
			}
			else {
				$left_date_str = '오늘 마감';
			}
			$cmp->left_date_str = $left_date_str;



		// 기부가치평가 금액
			$arr_where = array(
					'sql_select'     => 'donation_value', 
					'sql_from'       => 'donation',
					'sql_where'      => array('cmp_code'=>$row->code,'state_recycle'=>1), // 관리자가 재생중에 완료 체크한 것만 처리
			);
			$dn_result = $this->basic_model->arr_get_result($arr_where);

			$donation_value = 0;
			foreach($dn_result['qry'] as $dn_key => $dn_row) {
				if( isset($dn_row->donation_value) && intVal($dn_row->donation_value) > 0 ) {
					$donation_value += intVal($dn_row->donation_value);
				}
			}
			$cmp->donation_value = number_format($donation_value);



		// [2024-12-02] 캠페인별(주관단체별) 기부가치 합산 금액
			$arr_where_dnval = array(
					'sql_select'     => 'sum(donation_value) as totVal',
					'sql_from'       => 'donation',
					'sql_where'      => array('cmp_code'=>$row->code,'delete'=>NULL),
			);
			$dnval_row = $this->basic_model->arr_get_row($arr_where_dnval);
			$dnval_tot_val = $dnval_row->totVal;

			$cmp->dnval_tot_val = ($dnval_tot_val > 0) ? number_format($dnval_tot_val).'원' : '';

		// [2024-12-02] 캠페인 진행율
			$rate_cmp_goal = '';
			if($dnval_tot_val != '' && $goal_money != '' && $goal_money > 0) {
				$rate_cmp_goal = $dnval_tot_val / $goal_money * 100;
			}
			$cmp->rate_cmp_goal = $rate_cmp_goal;

			// 캠페인 진행율
			$goal_per = ($cmp->goal_money > 0) ? intVal($dnval_tot_val / $cmp->goal_money) : 0;
			$cmp->goal_per = $goal_per;
			//echo $goal_per.'<<<<';




		// 코멘트 목록 가져오기
		$arr_where = array(
				'sql_select'     => '*',
				'sql_from'       => 'campaign_comment',
				'sql_where'      => array('cmp_idx'=>$row->idx, 'del_yn'=>'N'),
				'sql_order_by'   => 'parent_idx desc, depth asc, order desc'
		);
		$result_cmt = $this->basic_model->arr_get_result($arr_where);

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




		// 캠페인 모금소식 목록 가져오기
		$arr_where = array(
				'sql_select'     => '*',
				'sql_from'       => 'campaign_news',
				'sql_where'      => array('cmp_idx'=>$row->idx, 'del_yn'=>'N', 'del_datetime'=>NULL),
				'sql_order_by'   => 'order DESC, reg_datetime DESC'
		);
		$result_cmpnews = $this->basic_model->arr_get_result($arr_where);

		foreach($result_cmpnews['qry'] as $i => $o) {

			if($o->user_idx > 1000) {
				// 일반 회원
				$user_cmt = $this->tank_auth->get_userinfo_idx($o->user_idx);
			} else {
				// 관리자
				$user_cmt = $this->tank_auth->get_admininfo_idx($o->user_idx);
			}


			//$result_cmpnews['qry'][$i]->user_nickname = isset($user_cmt->nickname) ? $user_cmt->nickname : 'GUEST';
			if( isset($user_cmt->nickname) ) {
				$cmt_nickname = $user_cmt->nickname;
			} else {
				$cmt_nickname = "GUEST";
			}
			$result_cmpnews['qry'][$i]->user_nickname = $cmt_nickname;

		}
		//print_r($result_cmpnews['qry']);




		// 캠페인 탭메뉴 campaign, comment
		$cmptab = $this->session->userdata('sess_cmptab');
		if(! $cmptab OR '' == $cmptab) {
			$cmptab = 'tab_campaign';
			/*
			if(IS_MOBILE) :
				$cmptab = 'm_campaign';
			endif;
			*/
		}





			// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
			// 진행중인 다른 캠페인 sql 
			// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
			$sql_select = '*';
			$sql_from = 'campaign';
			$sql_where = array('state'=>'launch');
			$sql_group_by = FALSE;
			$sql_order_by = (isset($ofl) && '' != $ofl) ? $ofl : 'cmp_term_begin DESC, reg_datetime DESC';

			// 진행중인 캠페인
			$sql_where['cmp_term_begin <= '] = date('Y-m-d');
			$sql_where['cmp_term_end >= '] = date('Y-m-d');

			// 페이징
			$limit = 100;
			$page = '1';
			$offset = ($page - 1) * $limit;

			$arr = array(
					'sql_select'       => $sql_select,
					'sql_from'         => $sql_from,
					'sql_where'        => $sql_where,
					'sql_group_by'     => $sql_group_by,
					'sql_order_by'     => $sql_order_by,
					'page'             => $page,
					'limit'            => $limit,
					'offset'           => $offset,
			);
			$result = $this->basic_model->arr_get_result($arr);

			$list = array();
			$ino = 0;
			foreach($result['qry'] as $k => $o) {

				//print_r($o);

				$list[$ino] = new stdClass();

				// 번호
				$num = ($result['total_count'] - $ino);
				$list[$ino]->num = $num;

				$list[$ino]->idx = $o->idx;
				$list[$ino]->code = $o->code;
				$list[$ino]->cmp_cate = $o->cmp_cate;
				$list[$ino]->cmp_title = $o->cmp_title;
				$list[$ino]->cmp_term_begin = $o->cmp_term_begin;
				$list[$ino]->cmp_term_end = $o->cmp_term_end;
				$list[$ino]->cmp_term = $o->cmp_term_begin.'~'.$o->cmp_term_end;

				// cmp_tag_bg_green, cmp_tag_bg_blue

				$cmp_tag_bg = '';
				if( '지구를 위해' == $o->cmp_cate ) {
					$cmp_tag_bg = 'cmp_tag_bg_green';
				}
				else if( '이웃을 위해' == $o->cmp_cate ) {
					$cmp_tag_bg = 'cmp_tag_bg_blue';
				}
				$list[$ino]->cmp_tag_bg = $cmp_tag_bg;


				// 남은 날짜
				$left_date = intval((strtotime($o->cmp_term_end)-strtotime(date('Y-m-d'))) / 86400); // 나머지 날짜값이 나옵니다.
				if($left_date > 0) {
					$left_date_str = $left_date.'일 남음';
				}
				else if($left_date < 0) {
					$left_date_str = '종료';
				}
				else {
					$left_date_str = '오늘 마감';
				}
				$list[$ino]->left_date_str = $left_date_str;

				// 남은 날짜 percent
				$total_day = intval((strtotime($o->cmp_term_end)-strtotime($o->cmp_term_begin)) / 86400); // 나머지 날짜값이 나옵니다.
				$left_day = intval((strtotime($o->cmp_term_end)-strtotime(date('Y-m-d'))) / 86400); // 나머지 날짜값이 나옵니다.

				if($total_day === 0) {
					$total_day = 1;
				}

				$left_day = ($left_day < 0) ? 0 : $left_day;
				$left_date_per = 100 - intval(($left_day/$total_day)*100);
				$list[$ino]->left_date_per = $left_date_per;


				$list[$ino]->cmp_org_name = $o->cmp_org_name;
				$list[$ino]->cmp_org_info = $o->cmp_org_info;

				$list[$ino]->reg_datetime = $o->reg_datetime;
				$list[$ino]->reg_date = substr($o->reg_datetime,0,10);
				$list[$ino]->state = $o->state;
				$state_str = '<button class="btn o_btn btn-xs btn-silver-flat" disabled>작성</button>';
				if('submit' == $o->state) :
					$state_str = '<button class="btn o_btn btn-xs btn-success-flat">제출</button>';
				elseif('launch' == $o->state) :
					$state_str = '<button class="btn o_btn btn-xs btn-primary-flat">런칭</button>';
				endif;


				$list[$ino]->state_str = $state_str;


				// 대표이미지(목록 및 캠페인 대표 이미지)
				$arr_where = array(
						'sql_select'     => '*',
						'sql_from'       => 'file_manager',
						'sql_where'      => array('wr_table'=>'campaign','wr_table_idx'=>$o->idx,'upload_type'=>'form','file_type'=>'image','gubun'=>'list'),
						'sql_order_by'   => 'idx DESC',
						'limit'          => 1
				);
				$file_row = $this->basic_model->arr_get_row($arr_where);
				$file_idx = isset($file_row->idx) ? $file_row->idx : '';
				$campaign_main_img = '';
				if(! empty($file_row)) {
					//$this->load->helper('resize');
					$img_w = '400';
					$img_h = '300';
					//$thumb_img = resize_thumb_image($file_row->file_name, $file_row->file_dir, $file_row->file_dir.'/thumb', $img_w,$img_h,FALSE,'auto','img');
					//$campaign_main_img = $thumb_img;
					$thumb_src = resize_thumb_image($file_row->file_name, $file_row->file_dir, $file_row->file_dir.'/thumb', $img_w,$img_h,FALSE,'auto','src');
					$campaign_main_src = $thumb_src;
				}
				$list[$ino]->file_idx = $file_idx;
				//$list[$ino]->campaign_main_img = $campaign_main_img;
				$list[$ino]->campaign_main_src = $campaign_main_src;


				// 목표 기기 수량 총합 [campaign]
				$goal_amt = 0;
				$goal_amt += intVal($o->goal_amt_1);
				$goal_amt += intVal($o->goal_amt_2);
				$goal_amt += intVal($o->goal_amt_3);
				$goal_amt += intVal($o->goal_amt_4);
				$goal_amt += intVal($o->goal_amt_5);
				//echo $goal_amt.'<<<';
				$list[$ino]->goal_amt = $goal_amt;

				// 관리자가 입력한 기기 수량 총합 [donation]
				// 기부 정보
				$arr_where = array(
						//'sql_select'     => 'dng.*',
						'sql_select'     => 'sum(dng.gd_amt) as tot_amt',
						'sql_from'       => 'donation as dn',
						'sql_join_tbl'   => 'donation_goods as dng',
						'sql_join_on'    => 'dn.idx = dng.dn_idx',
						'sql_where'      => array('dn.cmp_code'=>$o->code),
				);
				$dn_row = $this->basic_model->arr_get_row($arr_where);
				//print_r($dn_row);
				$dng_total_amt = $dn_row->tot_amt;
				$list[$ino]->dng_total_amt = $dng_total_amt;

				// 기부율 (수량으로 계산)
				$dn_per = 0;
				if($goal_amt > 0) {
					$dn_per = ($dng_total_amt / $goal_amt) * 100;
				}
				//echo $dn_per.'%';
				$list[$ino]->dn_per = $dn_per;


				// 기부가치평가 금액
				$arr_where = array(
						'sql_select'     => 'donation_value', 
						'sql_from'       => 'donation',
						'sql_where'      => array('cmp_code'=>$o->code,'state_recycle'=>1), // 관리자가 재생중에 완료 체크한 것만 처리
				);
				$dn_result = $this->basic_model->arr_get_result($arr_where);

				$donation_value = 0;
				foreach($dn_result['qry'] as $dn_key => $dn_row) {
					if( isset($dn_row->donation_value) && intVal($dn_row->donation_value) > 0 ) {
						$donation_value += intVal($dn_row->donation_value);
					}
				}
				$list[$ino]->donation_value = number_format($donation_value);

				$ino++;
			}


			// 랜덤
			shuffle($list);

			$list_random = array();
			foreach($list as $k => $val) {
				if( $k > 3 )
					break;

				$list_random[$k] = $val;
			}
			//print_r($list_random);

			$list_random_2 = array();
			foreach($list as $k => $val) {
				if( $k > 6 )
					break;

				$list_random_2[$k] = $val;
			}



		// 페이지
		$viewPage = 'campaign/detail_view';

		if('SHXQ19' == $code OR 'redi' == $code) {
			// 2025-08-01
			$viewPage = 'page/campaign_redi';
		}

		//print_r($row);

		// 로그인 회원이 캠페인 작성자인 경우 true, 아니면 false
		$login_is_writer = (isset($this->user->id) && $this->user->id == $row->writer_idx && $this->user->level == 20) ? true : false;
		





		// 데이터 - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		$data = array(
			'arr_seg' => $this->arr_seg,

			'login_is_writer' => $login_is_writer,   // 로그인 회원이 캠페인 작성자인 경우 true, 아니면 false

			/*
			// 캠페인 작성자 정보
			'writer_idx' => $row->writer_idx,
			// 로그인 회원 정보
			'uacc_idx' => $this->user->id,
			'uacc_level' => $this->user->level,
			*/

			'utm_qstr' => $this->utm_qstr,

			'code' => $code,
			'cidx' => $row->idx,
			'cmptab' => $cmptab, // campaign, comment
			'row' => $row,
			'cmp' => $cmp,
			'result_cmt' => $result_cmt,
			'result_cmpnews' => $result_cmpnews,
			'list_random' => $list_random,
			'list_random_2' => $list_random_2,
			'viewPage' => $viewPage
		);
		$this->load->view('layout_view', $data);
	}















	// 캠페인 기부 flow
	//function donation($cidx=FALSE)
	function donation($code=FALSE,$result=FALSE)
	{

		if (! $this->tank_auth->is_logged_in()) {
			redirect('/auth/login/'. url_code(base_url($this->uri->uri_string()), 'e'));
		}

		// 캠페인 정보
		$arr_where = array(
				'sql_select'     => '*',
				'sql_from'       => 'campaign',
				'sql_where'      => array('code'=>$code)
		);
		$row = $this->basic_model->arr_get_row($arr_where);

		if(! $row->idx) {
			alert('존재하지 않거나 삭제된 캠페인입니다.',base_url().'campaign/lists');
			exit;
		}

		// 캠페인 시작일 이전인 경우
		if( $row->cmp_term_begin > date('Y-m-d') ) {
			alert('현재 모금 기간이 아닙니다. 이전 페이지로 돌아갑니다.');
			//exit;
		}

		// 기한 종료로 기부하기 마감 알림
		if( $row->cmp_term_end < date('Y-m-d') ) {
			alert('모금 기간이 종료되어 이전 페이지로 돌아갑니다.');
			//exit;
		}

		// # 에러 메시지 CSS
		$this->form_validation->set_error_delimiters('<div class="error">','</div>');

		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		// 저장시..
		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

		/*
			$this->form_validation->set_rules('campaign_title', '캠페인 제목', 'trim|required|xss_clean');
			$this->form_validation->set_rules('campaign_content', '캠페인 내용', 'trim|required|xss_clean');

			$this->form_validation->set_rules('goal_money', '목표기부가치', 'trim|required|xss_clean');
			//$this->form_validation->set_rules('goal_desc', '목표기기', 'trim|required|xss_clean');
			$this->form_validation->set_rules('term_begin', '모금기간', 'trim|required|xss_clean');
			$this->form_validation->set_rules('term_end', '모금기간', 'trim|required|xss_clean');

			$this->form_validation->set_rules('org_name', '단체명', 'trim|xss_clean');
			$this->form_validation->set_rules('org_desc', '단체소개', 'trim|xss_clean');
		*/

		$this->form_validation->set_rules('donor_type', '기부신청자 정보', 'trim|required|xss_clean');

		if ($this->form_validation->run() !== FALSE) {

			// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
			// 글 작성(새글, 답변글, 수정)시 업로드 파일 저장을 위해 고유 세션 생성
			// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
			/*
				$user_idx = $this->tank_auth->get_user_id();
				$ss_write_name = 'ss_file_'.$user_idx;
				if (! $this->session->userdata($ss_write_name)) {
					$this->session->set_userdata($ss_write_name, $user_idx.'_'.time());
				}
			*/

			if (!is_null($res_data = $this->campaign_lib->write_donation($code))) {		// success

				/*
					//print_r($res_data);
					//exit;

					Array ( 
						[user_idx] => 1 [user_username] => sadmin [cmp_idx] => 173 [cmp_code] => redi [donor_type] => A:개인 [company] => 
						[donor_name] => 최고관리자 [manager_dept] => [manager_title] => [goods_memo] => [cellphone] => 010-3261-6320 [email] => jobs.heo@gmail.com [postcode] => 47592 [addr] => 부산 연제구 쌍미천로45번길 78 (연산동) [addr_detail] => 112 [opt_request] => discard [pickup_date_plz] => [reg_datetime] => 2025-08-11 15:09:51 [reg_ip] => 112.185.52.193 [idx] => 310 )

				*/

				// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
				// 폼업로드 파일 저장 처리
				// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
				// max upload size
				//$max_upload_size = 5120; // 5MB
				$max_upload_size = 10240; // 10MB
				$tbl_donation = 'donation';

				// 파일 하나만 처리
				// if($res = $this->upload_lib->upload_file('attach_file_form_1', url_code('donation/image','e'), $tbl_donation, $res_data['idx'], '', FALSE, FALSE, true,$max_upload_size )) {

				// 파일 여러 개 처리
				if($res = $this->upload_lib->multi_upload_file('attach_file_form[]',url_code('donation/image','e'),$tbl_donation,$res_data['idx'],'', $max_upload_size,TRUE)) {

					// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
					// [START] 원본 리사이즈 대체 시작
					// 업로드 성공시 리사이징 처리
					// resize 
					// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

					// 리사이즈는 뷰 페이지에서!!!
				}


				// 특정 페이지로 이동
				//redirect(base_url().'campaign/donation/'.$res_data['cmp_code'].'/result');
				//alert('기부 신청이 완료되었습니다.\n신청해주셔서 감사합니다!',base_url().'campaign/donation/'.$res_data['cmp_code'].'/result');

				// 캠페인 정보

				// 기부신청 완료시 이메일 발송
				$cmp_title = isset($row->cmp_title) ? $row->cmp_title : '캠페인 기부 신청';
				$arr_email = array('jinakim@remann.co.kr', 'jin@remann.co.kr', 'gugaya@remann.co.kr', 'incoreain@gmail.com');

				//print_r($res_data);
				//exit; 
				$this->_campaign_send_email($cmp_title, $arr_email, $res_data);


				/*
				// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
				// [2025-08-01]
				// 기부 완료 후, ros 로 작업요청서 작성 요청 보내기
				// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
				*/
				/*
					$dn_idx = $res_data['idx'];
					//$dn_items = '';
					$dn_rmk = $goods_memo;
					$cert_key = 'ub9acud50cub7ecuc2a4u0072u006fu0073uc5f0ub3d9';


					// 기부물품 종류 코드
					$arr_ctgr = array('스마트폰'=>'ph','태블릿'=>'tb','노트북'=>'lt','데스크탑'=>'dt','기타'=>'etc');

					$goods_kind = $this->input->post('goods_kind');
					$goods_amt = $this->input->post('goods_amt');
					$goods_grade = $this->input->post('goods_grade');
					$goods_memo = $this->input->post('goods_memo');

					// json 만들기 - 기부 물품 정보
					// {"items":[{"ctgr":dt,"qty":2},{"ctgr":lt,"qty":2}]}
					$data_good = array();
					$data_items['items'] = array();
					if(is_array($goods_kind)) {
						foreach($goods_kind as $i => $good) {
							$code_ctgr = isset($arr_ctgr[$goods_kind[$i]]) ? $arr_ctgr[$goods_kind[$i]] : '';
							$data_good = array('ctgr'=>$code_ctgr, 'qty'=>$goods_amt[$i]);
							$data_items['items'][] = $data_good;
						}
					}
					$dn_items_json = json_encode($data_items);


					// [실제사용주소]
					//$post_url = 'https://ros.remann.co.kr/replus/waRegi';
					// [개발용 주소] // 로컬 작업용 pc
					$post_url = 'http://183.99.21.70:8080/replus/waRegi';  

					$curl_data = array('id'=>$dn_idx,'items'=>$dn_items_json,'rmk'=>$dn_rmk,'key'=>$cert_key);
					$output = $this->curl_post($post_url, $curl_data); // return 등록한 작업요청id값

					print_r($output);
				*/



				// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
				// 캠페인 기부 성공 체크

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


				// 각종 변수
				$php_self     = $this->input->server('PHP_SELF');
				$http_referer = $this->input->server('HTTP_REFERER');
				$visit_agent = $this->input->server('HTTP_USER_AGENT');
				$visit_ip = $this->input->server('REMOTE_ADDR');
				$visit_referer = ($http_referer) ? $http_referer : $php_self;


				if($row->cmp_term_begin <= $today  &&  $today <= $row->cmp_term_end) 
				{

						// 저장
						$data_dn = array('cmp_code'=>$code,'chk_submit'=>1,'ip'=>$visit_ip, 'dt'=>TIME_YMDHIS, 'agent'=>$visit_agent, 'referer'=>$visit_referer);
						
						$isBot = $this->basic_lib->isBot($visit_agent);
						if($isBot) {
							//봇
							$data_dn['chk_bot']=1;
						}
						$this->db->insert('campaign_dn', $data_dn);


						// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
						// 통계
						// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

						// 일간 통계
						// donate stat 테이블 처리
						$data_stat = array('date'=>TIME_YMD, 'cmp_code'=>$code, 'cnt_submit'=>'cnt_submit + 1');
						if($isBot) { $data_stat['cnt_bot']=1;    /* 봇 */ }
						else       { $data_stat['cnt_human']=1;  /* 아마도 휴먼 */ }
						$dt_visit_cnt = $this->basic_model->get_common_count('campaign_dn_stat', array('date' => date('Y-m-d'),'cmp_code' => $code));
						if( $dt_visit_cnt > 0 ) {
							// 업데이트
							$sql_update_cnt = ($isBot) ? ' cnt_bot = cnt_bot + 1 ' : ' cnt_human = cnt_human + 1 ';
							$this->db->simple_query(" UPDATE campaign_dn_stat SET cnt_submit = cnt_submit + 1 AND ".$sql_update_cnt." WHERE date = '".date('Y-m-d')."' AND cmp_code = '".$code."';");
						}
						else {
							// 신규
							$this->db->insert('campaign_dn_stat', $data_stat);
						}

						// 주간 통계
						// donate stat 테이블 처리
						$data_stat = array('date'=>$this_monday, 'cmp_code'=>$code, 'cnt_submit'=>'cnt_submit + 1');
						if($isBot) { $data_stat['cnt_bot']=1;    /* 봇 */ }
						else       { $data_stat['cnt_human']=1;  /* 아마도 휴먼 */ }
						$dt_visit_cnt = $this->basic_model->get_common_count('campaign_dn_stat_week', array('date' => $this_monday,'cmp_code' => $code));
						if( $dt_visit_cnt > 0 ) {
							// 업데이트
							$sql_update_cnt = ($isBot) ? ' cnt_bot = cnt_bot + 1 ' : ' cnt_human = cnt_human + 1 ';
							$this->db->simple_query(" UPDATE campaign_dn_stat_week SET cnt_submit = cnt_submit + 1 AND ".$sql_update_cnt." WHERE date = '".$this_monday."' AND cmp_code = '".$code."';");
						}
						else {
							// 신규
							$this->db->insert('campaign_dn_stat_week', $data_stat);
						}

				}






				// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
				// [2025-08-11] 모든 캠페인에서 작업요청서 작성 요청을 보냅니다.
				// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
				// [2025-08-01]
				// 기부 완료 후, ros 로 작업요청서 작성 요청 보내기
				// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
				// 기부물품 종류 코드
				$arr_ctgr = array('스마트폰'=>'ph','태블릿'=>'tb','노트북'=>'lt','데스크탑'=>'dt','기타'=>'etc');

				$goods_kind = $this->input->post('goods_kind');
				$goods_amt = $this->input->post('goods_amt');
				$goods_grade = $this->input->post('goods_grade');
				$goods_memo = $this->input->post('goods_memo');

				$dn_idx = $res_data['idx'];
				//$dn_items = '';
				$dn_rmk = $goods_memo;
				// cert_key 값은 ROS 제공
				$cert_key = 'ub9acud50cub7ecuc2a4u0072u006fu0073uc5f0ub3d9';

				$donor_name = $res_data['donor_name'];

				// 주소, 전화번호, 이메일
				$dn_phone = $res_data['cellphone'];
				$dn_email = $res_data['email'];
				$dn_addr = $res_data['postcode'].' '.$res_data['addr'].' '.$res_data['addr_detail'];

				$dn_rmk .= '\n - - - - - - - - - \n';
				$dn_rmk .= $dn_phone.'\n';
				$dn_rmk .= $dn_email.'\n';
				$dn_rmk .= $dn_addr.'\n';

				/*
				if('' != $res_data['pickup_date_plz']) {
					$dn_rmk .= '수거요청일자: '.$res_data['pickup_date_plz'].'\n';
				}
				*/
				$dn_rmk .= '수거요청일자: ';
				$dn_rmk .= ('' != $res_data['pickup_date_plz']) ? $res_data['pickup_date_plz'] : ' 요청 없음';
				$dn_rmk .= '\n';

				// json 만들기 - 기부 물품 정보
				// {"items":[{"ctgr":dt,"qty":2},{"ctgr":lt,"qty":2}]}
				$data_good = array();
				$data_items['items'] = array();
				$str_item_cnt = '';
				if(is_array($goods_kind)) {
					foreach($goods_kind as $i => $good) {
						$code_ctgr = isset($arr_ctgr[$goods_kind[$i]]) ? $arr_ctgr[$goods_kind[$i]] : '';
						$data_good = array('ctgr'=>$code_ctgr, 'qty'=>$goods_amt[$i]);
						$data_items['items'][] = $data_good;

						// $str_item_cnt
						// 스마트폰2.태블릿3.노트북1
						// 스마트폰12.태블릿4.노트북2
						if('' != $goods_amt[$i] && $goods_amt[$i] > 0) {
							$str_item_cnt .= ('' != $str_item_cnt) ? '.' : '';
							$str_item_cnt .= $goods_kind[$i].$goods_amt[$i];
						}
					}
				}

				$dn_items_json = json_encode($data_items);
				//echo $str_item_cnt;
				//exit;

				// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
				// 작업요청 등록
				// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
				// [개발용 주소] // 로컬 작업용 pc
				//$post_url = 'http://183.99.21.70:8080/replus/waRegi';  
				// [실제사용주소]
				$post_url = 'https://ros.remann.co.kr/replus/waRegi';

				$curl_data = array(
					'id'=>$dn_idx,
					'campaign'=>$row->cmp_title,
					'name'=>$donor_name,
					'items'=>$dn_items_json,
					'rmk'=>$dn_rmk,
					'key'=>$cert_key,
					'itemstr'=>$str_item_cnt
				);
				$output = $this->curl_post($post_url, $curl_data); // return 등록한 작업요청id값

				if( $output && $output > 0 ) {
					// 업데이트
					$ros_wa_id = $output;
					$this->db->simple_query(" UPDATE donation SET ros_wa_id = ".$ros_wa_id." WHERE idx = ".$dn_idx );
				}






				/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
				 * [2025-09-10] 경사원 캠페인만 택배접수 및 알림톡 발송
				 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
				/*
				if('redi' == $code ) {
				}
				*/


				/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
				 * [2026-01-05] 모든 캠페인에 택배접수 및 알림톡 발송
				 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
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

					// [개발용 주소] // 로컬 작업용 pc
					//$post_url_cj = 'http://183.99.21.70:8080/cj/regBook';  
					// [실제사용주소]
					$post_url_cj = 'https://ros.remann.co.kr/cj/regBook';

					$curl_data_cj = array(
						'id'=>$dn_idx,
						'rcpt_dv' => '01',
						'name'=>$donor_name,
						'phone'=>$dn_phone,
						'zip_no'=>$res_data['postcode'],
						'addr1'=>$res_data['addr'],
						'addr2'=>$res_data['addr_detail']
					);

					// 택배 접수 보내기
					$output_json = $this->curl_post($post_url_cj, $curl_data_cj); // return 등록한 작업요청id값

					// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - 
					// 택배 접수 결과 저장
					// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - 
					$resArr = json_decode($output_json);
					$cjbook_res = isset($resArr->data) ? $resArr->data : 'error';
					$cjbook_dt = ('error' != $cjbook_res) ? TIME_YMDHIS : '';

					//$this->db->simple_query(" UPDATE donation SET cj_book = '".$cjbook_res."', cj_book_dt = '".$cjbook_dt."', cj_book_json='".$output_json."' WHERE idx = ".$dn_idx );
					//print_r($output_json);
					//exit;

					// 시간 저장
					$this->db->simple_query(" UPDATE donation SET cj_book_dt = '".$cjbook_dt."' WHERE idx = ".$dn_idx );
					// 리턴 값 저장
					$this->db->simple_query(" UPDATE donation SET cj_book = '".$cjbook_res."', cj_book_json='".$output_json."' WHERE idx = ".$dn_idx );

					// 성공이 아닌 경우 메모
					if('success' != $cjbook_res) {
						$this->db->simple_query(" UPDATE donation SET cj_memo='".$output_json."' WHERE idx = ".$dn_idx );
					}

					// [2025-08-26] 일단, 경사원 캠페인만 알림톡 발송
					// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
					// [2025-08-21]
					// 기부 완료 후, 알리고 알림톡 발송
					// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
					  /* 
					  -----------------------------------------------------------------------------------
					  알림톡 전송
					  -----------------------------------------------------------------------------------
					  버튼의 경우 템플릿에 버튼이 있을때만 버튼 파라메더를 입력하셔야 합니다.
					  버튼이 없는 템플릿인 경우 버튼 파라메더를 제외하시기 바랍니다.
					  */

					// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
					// [성공] alim_msg_UC_3926
					// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
					/*
					$alim_msg_UC_3926 = "안녕하세요, {$donor_name}님. \\n"
									 . "리플러스박스와 함께하는 디지털기기 안심 회수 캠페인에 참여해주셔서 감사합니다.  \\n"
									 . " \\n"
									 . "리플러스박스는 신청 이후 평균 3~5일 이내로 도착합니다. 받으신 후, 아래의 절차에 따라 물품을 포장해주세요. \\n"
									 . " \\n"
									 . "※ 박스에 함께 동봉된 파우치도 반드시 포함해서 포장해주세요! \\n"
									 . "※ 전원이 켜지는 제품이라면 애플 제품은 클라우드락 해제, 안드로이드 제품은 1차로 공장초기화를 진행한 뒤 보내주세요. (해당 작업이 어렵다면 그대로 보내주셔도 괜찮습니다.) \\n"
									 . " \\n"
									 . "▶ 수령 및 수거 절차 \\n"
									 . "1) 박스를 받으신 후, 안내문에 따라 각 기기를 안전파우치에 포장해주세요. \\n"
									 . "2) 파우치를 리플러스박스안에 넣은 뒤 박스테이프를 붙인 후 십자 벨트로 마감해주세요. \\n"
									 . "3) 포장이 완료되면 마이페이지-수거 신청 버튼을 꼭 눌러주세요.  \\n"
									 . "4) 박스를 받았던 주소 문 밖에 리플러스박스를 놓아주세요.  \\n"
									 . "5) 수거 신청 확인 후, 택배 기사님이 방문하여 회수를 진행할 예정입니다. \\n"
									 . " \\n"
									 . "▶ 리플러스박스 벨트 비밀번호 : 205  \\n"
									 . " \\n"
									 . "나눔하신 디지털 기기의 처리 과정은 향후 리플러스 내 마이페이지를 통해 확인해주세요.  \\n"
									 . "기기 내 데이터는 안전하게 삭제되며, 삭제 완료 후 발급되는 데이터 삭제 리포트는 순차적으로 업로드 될 예정입니다. \\n"
									 . " \\n"
									 . "나눔과 자원순환에 동참해 주셔서 감사합니다! \\n";
					*/

					// [2025-12-31] 변경예정
					// [2026-01-05] 모든 캠페인에 적용
					$alim_msg_UE_2597 = "안녕하세요, {$donor_name}님. \\n"
									 . "{$row->cmp_title} 캠페인에 참여해주셔서 감사합니다. \\n"
									 . "\\n"
									 . "기기를 안전하게 기부할 수 있는 리플러스박스는 신청 이후 평균 3~5일 이내로 도착합니다. 받으신 후, 아래의 절차에 따라 물품을 포장해주세요.\\n"
									 . "\\n"
									 . "※ 박스에 함께 동봉된 파우치도 반드시 포함해서 포장해주세요!\\n"
									 . "※ 전원이 켜지는 제품이라면 애플 제품은 클라우드락 해제, 안드로이드 제품은 1차로 공장초기화를 진행한 뒤 보내주세요. (해당 작업이 어렵다면 그대로 보내주셔도 괜찮습니다.)\\n"
									 . "\\n"
									 . "▶ 수령 및 수거 절차\\n"
									 . "1) 박스를 받으신 후, 안내문에 따라 각 기기를 안전파우치에 포장해주세요.\\n"
									 . "2) 파우치를 리플러스박스안에 넣은 뒤 박스테이프를 붙인 후 십자 벨트로 마감해주세요.\\n"
									 . "3) 포장이 완료되면 마이페이지-수거 신청 버튼을 꼭 눌러주세요. \\n"
									 . "4) 박스를 받았던 주소 문 밖에 리플러스박스를 놓아주세요. \\n"
									 . "5) 수거 신청 확인 후, 택배 기사님이 방문하여 회수를 진행할 예정입니다.\\n"
									 . "\\n"
									 . "▶ 리플러스박스 벨트 비밀번호 : 205 \\n"
									 . "\\n"
									 . "나눔하신 디지털 기기의 처리 과정은 향후 리플러스 내 마이페이지를 통해 확인해주세요. \\n"
									 . "기기 내 데이터는 안전하게 삭제되며, 삭제 완료 후 발급되는 데이터 삭제 리포트는 순차적으로 업로드 될 예정입니다.\\n"
									 . "\\n"
									 . "▶기타 문의사항 : 리플러스 디지털현물기부플랫폼 (본 채널)  \\n"
									 . "\\n"
									 . "나눔과 자원순환에 동참해 주셔서 감사합니다!\\n";

	

					$_apiURL    =	'https://kakaoapi.aligo.in/akv10/alimtalk/send/';
					$_hostInfo  =	parse_url($_apiURL);
					$_port      =	(strtolower($_hostInfo['scheme']) == 'https') ? 443 : 80;
					$_variables =	array(
						'apikey'      => 'psuzi3jafauix0qipbr6n2tvl98bbzaq', 
						'userid'      => 'remann', 
						'senderkey'   => '0af469b73d77f82798cfdeedebf0d91fe8a27353', 
						'tpl_code'    => 'UE_2597', //'UC_3926',
						'sender'      => '070-4652-5192',
						'senddate'    => date("YmdHis", strtotime("+10 minutes")),
						'receiver_1'  => $dn_phone,
						'recvname_1'  => $donor_name,
						'subject_1'   => '리플러스 전체 (1) - 수거 절차 및 캠페인 안내', // '리플러스 박스 (1) - 수거 절차 및 캠페인 안내',
						'message_1'   => $alim_msg_UE_2597,
						'button_1'    => '{"button":[{"name":"채널 추가","linkType":"AC"}, {"name":"리플러스 홈페이지","linkType":"WL","linkTypeName":"웹링크","linkM":"https://replus.kr/","linkP":"https://replus.kr/"}, {"name":"포장 후 수거 신청하기","linkType":"WL","linkTypeName":"웹링크","linkM":"https://replus.kr/mypage/","linkP":"https://replus.kr/mypage/"}]}'
					);
					


					$output_aligo = $this->curl_aligo($_port,$_apiURL,$_variables);

					// JSON 문자열 배열 변환
					$retArr = json_decode($output_aligo);

					// 결과값 출력
					//print_r($retArr);
					//exit;


				/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
				 * // [2026-01-05] 모든 캠페인에 택배접수 및 알림톡 적용
				 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */



				if ($this->tank_auth->is_logged_in()) {
					// 로그인 회원은 마이페이지로 이동
					//alert('기부 신청이 완료되었습니다.\\n신청해주셔서 감사합니다! \\n\\n['.$retArr->code.']'.$retArr->message,base_url().'mypage/donation/lists');
					alert('기부 신청이 완료되었습니다.\\n신청해주셔서 감사합니다!',base_url().'mypage/donation/lists');
				}
				else {
					// 비회원은 홈으로 이동
					alert('기부 신청이 완료되었습니다.\n신청해주셔서 감사합니다!',base_url().'campaign/detail/'.$code);
				}
			}
		}
		else 
		{

		}

		load_css('<link rel="stylesheet" href="'.LIB_DIR.'/datetimepicker-master/jquery.datetimepicker.min.css" />');
		load_js('<script src="'.LIB_DIR.'/datetimepicker-master/jquery.datetimepicker.full.js"></script>');

		if(! $code) {
			alert('존재하지 않거나 삭제된 캠페인입니다.',base_url().'campaign/lists');
			exit;
		}

		/*
		// 캠페인 정보
		$arr_where = array(
				'sql_select'     => '*',
				'sql_from'       => 'campaign',
				'sql_where'      => array('code'=>$code)
		);
		$row = $this->basic_model->arr_get_row($arr_where);

		if(! $row->idx) {
			alert('존재하지 않거나 삭제된 캠페인입니다.',base_url().'campaign/lists');
			exit;
		}

		// 기한 종료로 기부하기 마감 알림
		if( $row->cmp_term_end < date('Y-m-d') ) {
			//alert('기부캠페인 기간이 종료되어 이전 페이지로 돌아갑니다.');
			//exit;
		}
		*/

		$user = ( isset($this->user) && ! empty($this->user) ) ? $this->user : new stdClass();
		$user->arr_phone = array('010','','');

		if ($this->tank_auth->is_logged_in()) {

			// 연락처(휴대폰)
			$phone = isset($user->phone) ? $user->phone : '';
			$phone = trim(str_replace('-','',$phone));
			if('' != $phone) {
				$arr_phone[0] = substr($phone,0,3);
				$arr_phone[1] = substr($phone,3,4);
				$arr_phone[2] = substr($phone,7,4);
				$user->arr_phone = $arr_phone;
			}
			
			// 이메일
			$email = isset($user->email) ? $user->email : '';
			$arr_email = array();
			if('' != $email) {
				$arr_email = explode('@',$email);
			}
			$user->arr_email = $arr_email;

		}











		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		// 캠페인 기부페이지 접속자 체크

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

			// 각종 변수
			$php_self     = $this->input->server('PHP_SELF');
			$http_referer = $this->input->server('HTTP_REFERER');
			$visit_agent = $this->input->server('HTTP_USER_AGENT');
			$visit_ip = $this->input->server('REMOTE_ADDR');
			$visit_referer = ($http_referer) ? $http_referer : $php_self;

			if($row->cmp_term_begin <= $today  &&  $today <= $row->cmp_term_end) 
			{

					// 저장
					$data_ins = array('cmp_code'=>$code,'ip'=>$visit_ip, 'dt'=>TIME_YMDHIS, 'agent'=>$visit_agent, 'referer'=>$visit_referer);
					
					$isBot = $this->basic_lib->isBot($visit_agent);
					if($isBot) {
						//봇
						$data_ins['chk_bot']=1;
					}
					$this->db->insert('campaign_dn', $data_ins);


					// 일간 통계
					// donate stat 테이블 처리
					$data_stat = array('date'=>TIME_YMD, 'cmp_code'=>$code);
					if($isBot) { $data_stat['cnt_bot']=1;    /* 봇 */ }
					else       { $data_stat['cnt_human']=1;  /* 아마도 휴먼 */ }
					$dt_visit_cnt = $this->basic_model->get_common_count('campaign_dn_stat', array('date' => date('Y-m-d'),'cmp_code' => $code));
					if( $dt_visit_cnt > 0 ) {
						// 업데이트
						$sql_update_cnt = ($isBot) ? ' cnt_bot = cnt_bot + 1 ' : ' cnt_human = cnt_human + 1 ';
						$this->db->simple_query(" UPDATE campaign_dn_stat SET ".$sql_update_cnt." WHERE date = '".date('Y-m-d')."' AND cmp_code = '".$code."';");
					}
					else {
						// 신규
						$this->db->insert('campaign_dn_stat', $data_stat);
					}



					// 주간 통계
					// donate stat 테이블 처리
					$data_stat = array('date'=>$this_monday, 'cmp_code'=>$code, 'cnt_submit'=>'cnt_submit + 1');
					if($isBot) { $data_stat['cnt_bot']=1;    /* 봇 */ }
					else       { $data_stat['cnt_human']=1;  /* 아마도 휴먼 */ }
					$dt_visit_cnt = $this->basic_model->get_common_count('campaign_dn_stat_week', array('date' => $this_monday,'cmp_code' => $code));
					if( $dt_visit_cnt > 0 ) {
						// 업데이트
						$sql_update_cnt = ($isBot) ? ' cnt_bot = cnt_bot + 1 ' : ' cnt_human = cnt_human + 1 ';
						$this->db->simple_query(" UPDATE campaign_dn_stat_week SET cnt_submit = cnt_submit + 1 AND ".$sql_update_cnt." WHERE date = '".$this_monday."' AND cmp_code = '".$code."';");
					}
					else {
						// 신규
						$this->db->insert('campaign_dn_stat_week', $data_stat);
					}


			}









		/*
		// 페이지
		$viewPage = 'campaign/donation_view';

		// [2024-04-08]
		// 오프라인 행사로 사용할 캠페인의 '물품수거 요청일자'를 행상 당일로 고정
		if('JD3O7X' == $code) {
			$viewPage = 'campaign/donation_JD3O7X_240423_view';
		}
		else if('FIZB' == $code) {
			$viewPage = 'campaign/donation_FIZB_241007_view';
		}
		else if('redi' == $code) {

			// 2025년 특별한 캠페인 
			$viewPage = 'campaign/donation_redi_251104_view';
		}
		else {
			// 
			//$viewPage = 'campaign/donation_common_view';
		}
		*/
			
		
		
		/*
		//echo REMOTE_ADDR;
		// 기부하기 페이지 공통 작업
		if('61.82.205.90' == REMOTE_ADDR){
			// [2025-12-30] 캠페인 기부를 리디캠페인 기준으로 통일
			$viewPage = 'campaign/donation_common_view';
		}
		*/
		
		
					
		// 캠페인 페이지 통일
		$viewPage = 'campaign/donation_common_view';


		// 데이터 - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		$data = array(
			'arr_seg' => $this->arr_seg,

			'utm_qstr' => $this->utm_qstr,

			'user' => isset($user) ? $user : array(),
			'code' => $code,
			'cidx' => $row->idx,
			'row' => $row,
			'viewPage' => $viewPage
		);
		$this->load->view('layout_view', $data);
	}





	// [2025-09-08] 택배 접수가 안된 건 수동으로 접수시키기
	function cj_direct() {

		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		// 리턴 false
		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		return false;


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


					$dn_idx = '';
					$donor_name = '';
					$dn_phone = '';
					$postcode = '';
					$addr = '';
					$addr_detail = '';
					echo $dn_idx.' :: '.$donor_name.'<<<<br />';


					if( '' != $dn_idx) {

						// [개발용 주소] // 로컬 작업용 pc
						//$post_url_cj = 'http://183.99.21.70:8080/cj/regBook';  
						// [실제사용주소]
						$post_url_cj = 'https://ros.remann.co.kr/cj/regBook';

						$curl_data_cj = array(
							'id'=>$dn_idx,
							'rcpt_dv' => '01',
							'name'=>$donor_name,
							'phone'=>$dn_phone,
							'zip_no'=>$postcode,
							'addr1'=>$addr,
							'addr2'=>$addr_detail
						);

						print_r($curl_data_cj);
						//exit;

						// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - 
						// 택배 접수 보내기
						// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - 
						$output_json = $this->curl_post($post_url_cj, $curl_data_cj); // return 등록한 작업요청id값

						// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - 
						// 택배 접수 결과 저장
						// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - 
						$resArr = json_decode($output_json);
						$cjbook_res = isset($resArr->data) ? $resArr->data : 'error';
						$cjbook_dt = ('error' != $cjbook_res) ? TIME_YMDHIS : '';

						$this->db->simple_query(" UPDATE donation SET cj_book = '".$cjbook_res."', cj_book_dt = '".$cjbook_dt."', cj_book_json='".$output_json."' WHERE idx = ".$dn_idx );

						print_r($output_json);

					}

					exit;

	}
































	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	// [2] 나눔캠페인 신청
	//     /campaign/sharecampaign/[$wr_idx]?page=[$page]
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

	function sharecampaign($wr_idx=FALSE) {

		// 상단 탑배너 이미지 - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
			// pc
			$top_bnr_pc = $this->basic_model->get_banner_list('share_top_pc',10);
			// mobile
			$top_bnr_mobile = $this->basic_model->get_banner_list('share_top_mobile',10);



		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		// GET 정보 
		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
			$this->load->library('querystring', NULL, 'param'); // 쿼리스트링 주소
			$param	  =& $this->param;

			// [page 번호, 중요하진 않음]
			$get_page = $param->get('page', false);




		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		// POST 정보 
		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

			// # [2017-03-22] 에러 메시지 CSS
			$this->form_validation->set_error_delimiters('<div class="error_board_admin">','</div>');


			// [1/3] 캅챠 자동등록방지
			$captcha_registration	= $this->config->item('captcha_registration', 'tank_auth');
			$use_recaptcha			= $this->config->item('use_recaptcha', 'tank_auth');

			// 하단에서 일회성 사용
			$data['use_recaptcha'] = $use_recaptcha;

			// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
			// 글쓰기 저장시..
			// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
			if( $this->input->post('submit') ) {

					// 나눔신청
					// 개인정보처리동의, 이름, 이메일, 연락처, 업체명, 직책, 주소, 신청과목, 내용

						$this->form_validation->set_rules('gubun', '신청자 구분', 'trim|required|xss_clean');
						$this->form_validation->set_rules('req_name', '신청자명', 'trim|required|xss_clean');
						$this->form_validation->set_rules('req_name_org', '상호/법인명', 'trim');
						$this->form_validation->set_rules('req_postcode', '주소(우편번호)', 'trim|required');
						$this->form_validation->set_rules('req_addr', '주소', 'trim|required');
						$this->form_validation->set_rules('req_addr_detail', '상세주소', 'trim|required');
						$this->form_validation->set_rules('req_birthday', '생년월일', 'trim|required');
						$this->form_validation->set_rules('req_phone', '휴대전화', 'trim|required');
						$this->form_validation->set_rules('req_reason', '신청사유', 'trim|required|xss_clean');

						//$this->form_validation->set_rules('chk_agree', '개인정보 처리 동의', 'trim|required|xss_clean');

						$this->form_validation->set_rules('gubun_bnf', '수혜자 구분', 'trim|required|xss_clean');
						$this->form_validation->set_rules('bnf_name', '수혜자명', 'trim|required|xss_clean');
						//$this->form_validation->set_rules('bnf_target', '수혜대상', 'trim|required|xss_clean');
						$this->form_validation->set_rules('bnf_count', '수혜대상 수', 'trim|required|xss_clean');
						$this->form_validation->set_rules('bnf_postcode', '주소(우편번호)', 'trim|required');
						$this->form_validation->set_rules('bnf_addr', '주소', 'trim|required');
						$this->form_validation->set_rules('bnf_addr_detail', '상세주소', 'trim|required');
						$this->form_validation->set_rules('bnf_phone', '휴대전화', 'trim|required');
						//$this->form_validation->set_rules('bnf_birthday', '생년월일', 'trim|required');
						$this->form_validation->set_rules('bnf_devices', '희망 기기 및 수량', 'trim|required');
						$this->form_validation->set_rules('bnf_content', '수혜대상 소개 및 기기 활용목적', 'trim|required|xss_clean');

						//$this->form_validation->set_rules('passwd', '비밀번호', 'trim|required');

						// (답변글이거나 새글일 때) 그리고 (사이트매니저 이상인 경우) 패스 ==> 수정 글이 아닌 이상, 매니저 권한이 없는 일반 회원은 자동등록방지코드를 입력해야 함.
						if( ! $this->tank_auth->is_logged_in()) {
							if ($use_recaptcha) {
								$this->form_validation->set_rules('recaptcha_response_field', '자동등록방지코드', 'trim|xss_clean|required|callback__check_recaptcha');
							} else {
								$this->form_validation->set_rules('captcha', '자동등록방지코드', 'trim|xss_clean|required|callback__check_captcha');
							}
						}


					if ($this->form_validation->run()) {	// validation ok

						if (!is_null($data = $this->campaign_lib->sharecampaign_request($wr_idx))) {		// success

							/*
							$redirect_url = base_url().'B/SHARECAMPAIGN/나눔신청/detail/'.$wr_idx.'/page/'.$get_page;
							//sess_message('나눔 신청이 완료되었습니다.');
							alert_stay('나눔 신청이 완료되었습니다.');
							redirect($redirect_url);
							*/

							alert('나눔 신청이 완료되었습니다.',base_url().'B/SHARECAMPAIGN/나눔신청/detail/'.$wr_idx.'/page/'.$get_page);

						} else {
							$errors = $this->tank_auth->get_error_message();
							foreach ($errors as $k => $v)	$data['errors'][$k] = $this->lang->line($v);
						}
					}
			}











		// load css, js  - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
			load_css('<link rel="stylesheet" href="'.LIB_DIR.'/slider/slick-1.8.1/slick/slick.css" />');
			load_js('<script src="'.LIB_DIR.'/slider/slick-1.8.1/slick/slick.min.js"></script>');

		// 페이지
			$viewPage = 'campaign/sharecampaign_view';

		// 데이터 - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
			$data = array(
				'arr_seg' => $this->arr_seg,

				'top_bnr_mobile' => $top_bnr_mobile,
				'top_bnr_pc' => $top_bnr_pc,

				'wr_idx' => $wr_idx,
				'page' => $get_page,

				'viewPage' => $viewPage
			);


			// 캅챠[2/3]
			$data['show_captcha'] = TRUE;
			if ($use_recaptcha) {
				$data['recaptcha_html'] = $this->_create_recaptcha();
			} else {
				$data['captcha_html'] = $this->_create_captcha();
			}

			// 캅챠[3/3]
			$data['show_captcha'] = isset($data['show_captcha']) ? $data['show_captcha'] : false;;
			$data['use_recaptcha'] = isset($data['use_recaptcha']) ? $data['use_recaptcha'] : false;
			$data['recaptcha_html'] = isset($data['recaptcha_html']) ? $data['recaptcha_html'] : false;
			$data['captcha_html'] = isset($data['captcha_html']) ? $data['captcha_html'] : false;


			$this->load->view('layout_view', $data);
	}











	/**
	 * Create CAPTCHA image to verify user as a human
	 *
	 * @return	string
	 */

	function _create_captcha()
	{
		$this->load->helper('captcha');

		$cap = create_captcha(array(
			'img_path'		=> $this->config->item('captcha_path', 'tank_auth'),
			'img_url'		=> base_url().$this->config->item('captcha_path', 'tank_auth'),
			'font_path'		=> $this->config->item('captcha_fonts_path', 'tank_auth'),
			'font_size'		=> $this->config->item('captcha_font_size', 'tank_auth'),
			'img_width'		=> $this->config->item('captcha_width', 'tank_auth'),
			'img_height'	=> $this->config->item('captcha_height', 'tank_auth'),
			'show_grid'		=> $this->config->item('captcha_grid', 'tank_auth'),
			'expiration'	=> $this->config->item('captcha_expire', 'tank_auth'),
			'word_length'	=> $this->config->item('captcha_word_length', 'tank_auth'),
			'pool'	=> $this->config->item('captcha_pool', 'tank_auth'),
		));

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

















	/**
	 * Send email message of given type (activate, forgot_password, etc.)
	 *
	 * @param	string
	 * @param	string
	 * @param	array
	 * @return	void
	 * _send_email('npo', 'jinakim@remann.co.kr,jin@remann.co.kr,gugaya@remann.co.kr,riddleme@naver.com',&$data)
	 */
	function _campaign_send_email($cmp_title, $email, &$data)
	{

		$subject = $cmp_title;
		$data['cmp_title'] = $cmp_title;

		$this->load->library('email');
		$this->email->from($this->config->item('webmaster_email', 'tank_auth'), $this->config->item('website_name', 'tank_auth'));
		$this->email->reply_to($this->config->item('webmaster_email', 'tank_auth'), $this->config->item('website_name', 'tank_auth'));
		$this->email->to($email);
		$this->email->subject($subject);
		$this->email->message($this->load->view('email/campaign_donate-html', $data, TRUE));
		$this->email->set_alt_message($this->load->view('email/campaign_donate-txt', $data, TRUE));
		$this->email->send();

	}



	/* [2024]버전 */
	function __curl_post($url, $fields)
	{

		// jquery ajax 에서 success 의 response 값을 못가져오길래 검색해보니,
		// 요 아래 코드를 ajax 페이지에서 호출하는 페이지에 넣어주라고 함.
		//header("Content-type: text/html; charset=utf-8");
		//header("Content-Type:application/json");

		$post_field_string = http_build_query($fields, '', '&');

		$ch = curl_init();                                                            // curl 초기화

		curl_setopt($ch, CURLOPT_URL, $url);                                 // url 지정하기

		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);              // 요청결과를 문자열로 반환

		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);               // connection timeout : 10초

		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);                 // 원격 서버의 인증서가 유효한지 검사 여부

		curl_setopt($ch, CURLOPT_POSTFIELDS, $post_field_string);      // POST DATA

		curl_setopt($ch, CURLOPT_POST, true);                               // POST 전송 여부

		$response = curl_exec($ch);

		curl_close ($ch);

		return $response;
	}


	/* [2025] chatgpt 버전 */
	function curl_post($url, $data)
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



	function curl_get($url, $arr_fld)
	{
		/*
		$reqState = $arr_fld['reqState'];
		$data = array(
			'reqState' => $reqState
		);
		*/

		$get_field_string = http_build_query($arr_fld, '', '&');

		//$url_get = $url . "?" . http_build_query($get_field_string, '', );
		$url_get = $url . "?" . $get_field_string;
		//$url_get = $url . "?" . http_build_query($data, '', );
		//return $url_get;

		$ch = curl_init();                                 //curl 초기화
		curl_setopt($ch, CURLOPT_URL, $url_get);               //URL 지정하기
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);    //요청 결과를 문자열로 반환 
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);      //connection timeout 10초 
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);   //원격 서버의 인증서가 유효한지 검사 안함
		 
		$response = curl_exec($ch);
		curl_close($ch);
		 
		return $response;
	}



	function curl_aligo($_port,$_apiURL,$_variables) {

		$oCurl = curl_init();
		curl_setopt($oCurl, CURLOPT_PORT, $_port);
		curl_setopt($oCurl, CURLOPT_URL, $_apiURL);
		curl_setopt($oCurl, CURLOPT_POST, 1);
		curl_setopt($oCurl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($oCurl, CURLOPT_POSTFIELDS, http_build_query($_variables));
		curl_setopt($oCurl, CURLOPT_SSL_VERIFYPEER, FALSE);

		$ret = curl_exec($oCurl);
		$error_msg = curl_error($oCurl);
		curl_close($oCurl);

		// 리턴 JSON 문자열 확인
		// print_r($ret . PHP_EOL);
		return $ret;

		// JSON 문자열 배열 변환
		// $retArr = json_decode($ret);

		// 결과값 출력
		// print_r($retArr);

		/*
		code : 0 성공, 나머지 숫자는 에러
		message : 결과 메시지
		*/

	}



}

/* End of file Campaign.php */
/* Location: ./application/controllers/Campaign.php */