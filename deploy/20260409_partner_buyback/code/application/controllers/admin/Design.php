<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Design extends CI_Controller
{
	function __construct()
	{
		parent::__construct();

		/*
		$autoload['libraries'] = array('database', 'session','user_agent','basic_lib'); // ,'tank_auth','mobiledetect'
		$autoload['helper'] = array('url', 'file', 'common');
		*/

		$this->load->helper(array('form', 'load','security'));
		$this->load->library('form_validation');
		$this->load->library('tank_auth');
		$this->load->library('upload_lib');
		$this->load->model('upload_model');
		$this->load->model('popup_model');
		$this->load->model('banner_model');
		$this->lang->load('tank_auth');

		$this->username = $this->tank_auth->get_username();
		$this->arr_seg = $this->uri->segment_array();

		$this->load->library('pagination');
		$this->load->library('querystring');


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
			redirect(base_url().'auth/login/'. url_code( current_url(), 'e'));
		}


		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		// 배너 카테고리/코드
		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		$param =& $this->querystring;
		$bncode = $param->get('bncode',FALSE);
		$bn_list_title = '';

		$arr = array(
			'sql_select'   => 'bn_category, bn_code, bn_name',
			'sql_from'     => 'mng_banner',
			'sql_where'    => array('bn_id >' => 0),
			'sql_group_by' => 'bn_category, bn_code, bn_name',
			'sql_order_by' => 'bn_category ASC, bn_name ASC'
		);
		$this->bnr_result = $this->basic_model->arr_get_result($arr);
		//print_r($this->bnr_result);
		$this->bnr_side_list = array();
		foreach($this->bnr_result['qry'] as $key => $bnr) {

			//echo $key.'<<<br />';
			if($bnr->bn_category == 'common') { $bno = 1000 + $key; }
			if($bnr->bn_category == 'main') { $bno = 2000 + $key; }
			if($bnr->bn_category == 'sub') { $bno = 3000 + $key; }
			if($bnr->bn_category == 'etc') { $bno = 4000 + $key; }

			$this->bnr_side_list[$bno] = new stdClass();

			$this->bnr_side_list[$bno]->cate_code = $bnr->bn_category;
			$cate_text = '';
			$cate_text = ($cate_text == '' && $bnr->bn_category == 'common') ? '[공통]' : $cate_text;
			$cate_text = ($cate_text == '' && $bnr->bn_category == 'main') ? '[메인]' : $cate_text;
			$cate_text = ($cate_text == '' && $bnr->bn_category == 'sub') ? '[서브]' : $cate_text;
			$cate_text = ($cate_text == '' && $bnr->bn_category == 'etc') ? '[기타]' : $cate_text;
			$this->bnr_side_list[$bno]->cate_text = $cate_text;

			$this->bnr_side_list[$bno]->bn_code = $bnr->bn_code;
			$this->bnr_side_list[$bno]->bn_name = $bnr->bn_name;
			$this->bnr_side_list[$bno]->bn_nav_title = $cate_text .' '. $bnr->bn_name;
			$this->bnr_side_list[$bno]->bn_nav_link = base_url().'admin/design/banner/lists/'.$bnr->bn_category.'?bncode='.$bnr->bn_code;

			if($bncode == $bnr->bn_code) { // 배너코드
				$this->bn_list_title = $cate_text .' '. $bnr->bn_name;
			}
			
		}
		// 키 값으로 오름차순 정렬 ksort() / 내림차순은 krsort()
		ksort($this->bnr_side_list);

	}

	function index()
	{
		redirect(base_url().'admin/design/banner/lists');
	}

	function main() {

		redirect(base_url().'admin/design/banner/lists');	

		/*
		$data['arr_seg'] = $this->arr_seg;
		$data['viewPage'] = 'admin/design_main_view';
		//$this->load->view('admin/_layout_view', $data);
		$this->load->view('admin/layout_view', $data);
		*/
	}




	function menu($step="list",$seg5=FALSE,$seg6=FALSE,$seg7=FALSE)
	{



		// Get data.
			$breadcrumb = array(
				'디자인'=>base_url().'admin/design/menu',
				'메뉴 관리'=>''
			);

			$data = array(
				'arr_seg'   => $this->arr_seg, //$this->uri->segment_array(),
				'breadcrumb'    => $breadcrumb,
				'viewPage'  => 'admin/design_menu_view'
			);

			$this->load->view('admin/layout_view', $data);
	}



	function page($step="list",$seg5=FALSE,$seg6=FALSE,$seg7=FALSE)
	{



		// Get data.
			$breadcrumb = array(
				'디자인'=>base_url().'admin/design/page',
				'페이지 관리'=>''
			);

			$data = array(
				'arr_seg'   => $this->arr_seg, //$this->uri->segment_array(),
				'breadcrumb'    => $breadcrumb,
				'viewPage'  => 'admin/design_page_list_view'
			);

			$this->load->view('admin/layout_view', $data);
	}





	function banner($step="lists",$seg5=FALSE,$seg6=FALSE,$seg7=FALSE) 
	{

		switch ($step) {
			case 'lists':
					// 배너 목록
					$cate = $seg5;
					$this->_banner_lists($cate);
			break;
			case 'form':
					// 배너 등록/수정
					$w     = $seg5;
					$bn_id = $seg6;
					$page_num = $seg7;
					$this->_banner_form($w,$bn_id,$page_num);
			break;
			case 'delete':
					// 배너 삭제
					$bn_id = $seg5;
					$this->_banner_delete($bn_id);
			break;
			default:
				alert('잘못된 접근입니다.', '/admin/design/banner/lists/all');
			break;
		}

	}


	//function _banner_lists($cate='all') {
	function _banner_lists($cate=false) {

		if( ! $cate) {
			redirect(base_url().'admin/design/banner/lists/all');
		}

		$param =& $this->querystring;
		$page = $this->uri->segment(7, 1);
		$sst  = $param->get('sst', 'bn_id');
		$sod  = $param->get('sod', 'asc');
		$sfl  = $param->get('sfl');
		$stx  = $param->get('stx');

		// 배너 코드
		$bn_code  = $param->get('bncode');
		$where_opt = FALSE;
		if( isset($bn_code) ) {
			$where_opt = array('bn_code'=>$bn_code);
		}

		$config['uri_segment'] = 7;
		$config['suffix'] = $param->output();
		$config['base_url'] = RT_DIR.'/admin/design/banner/lists/'.$cate.'/page/';
		$config['per_page'] = 20;

		$offset = ($page - 1) * $config['per_page'];
		$result = $this->banner_model->list_result($sst, $sod, $sfl, $stx, $config['per_page'], $offset,$cate, $where_opt);

		$config['total_rows'] = $result['total_cnt'];
		$this->pagination->initialize($config);

		$list = array();
		//$cagegory = array('공통','메인','서브','기타');

		//print_r($result);
		//exit;

		//$token = get_token();
		foreach ($result['qry'] as $i => $row) {

			$list[$i] = new stdClass();

			$list[$i]->num = ($result['total_cnt'] - $config['per_page']*($page-1) - $i);

			$list[$i]->bn_id = $row['bn_id'];
			$list[$i]->bn_name = $row['bn_name'];
			//$list[$i]->bn_category = $cagegory[$row['bn_category']]; /* 0[공통], 1[메인], 2[서브], 3[기타] */
			$list[$i]->bn_category = $row['bn_category']; /*   공통/메인/서브/기타   */
			switch ($row['bn_category']) {
				case 'common':
					$bn_cate_str = '공통';
				break;
				case 'main':
					$bn_cate_str = '메인';
				break;
				case 'sub':
					$bn_cate_str = '서브';
				break;
				case 'etc':
					$bn_cate_str = '기타';
				break;
			}
			$list[$i]->bn_cate_str = $bn_cate_str;
			$list[$i]->bn_code = $row['bn_code'];
			$list[$i]->bn_rank = $row['bn_rank'];
			$list[$i]->bn_type = $row['bn_type'];

			$list[$i]->bn_use = $row['bn_use'];
			$list[$i]->bn_use_text = ($row['bn_use'] == 1) ? '<span style="color:blue; font-weight:bold;">사용함</span>' : '<span style="color:red;">사용안함</span>';

			$list[$i]->bn_image = $row['bn_image'];
			if($row['bn_image']) {
				$bn_image_src = DATA_DIR."/banner/image/".$row['bn_image'];
				$bn_image_exist = TRUE;
			}
			else {
				$bn_image_src = IMG_DIR."/no_image.png";
				$bn_image_exist = FALSE;
			}
			$list[$i]->bn_image_src = $bn_image_src;
			$list[$i]->bn_image_exist = $bn_image_exist;

			$list[$i]->bn_image_url = $row['bn_image_url'];
			$list[$i]->bn_link = $row['bn_link'];
			$list[$i]->bn_memo = $row['bn_memo'];
			$list[$i]->bn_target = $row['bn_target'];
			$list[$i]->bn_sdate = $row['bn_sdate'];
			$list[$i]->bn_edate = $row['bn_edate'];
			$list[$i]->reg_date = date('Y-m-d', strtotime($row['reg_datetime']));
			$list[$i]->mb_id_reg = $row['mb_id_reg'];
			$list[$i]->mb_id_update = $row['mb_id_update'];

			// $list[$i]->date = date('Y-m-d', strtotime($row['bn_datetime']));
			//$list[$i]->use_chk = ($row['bn_use']) ? "checked='checked'" : '';

			/*
			$list[$i]->s_pre = icon('보기', "javascript:win_open('banner/".$row['bn_id']."', 'banner".$row['bn_id']."', 'left=".$row['bn_x']."px,top=".$row['bn_y']."px,width=".$row['bn_width']."px,height=".$row['bn_height']."px,scrollbars=0');");
			$list[$i]->s_mod = icon('수정', 'banner/form/u/'.$row['bn_id']);
			$list[$i]->s_del = icon('삭제', "javascript:post_send('".ADM_F."/_trans/banner/delete', {bn_id:'".$row['bn_id']."', token:'".$token."'}, true);");
			*/
			$list[$i]->s_mod = icon('수정', 'banner/form/u/'.$row['bn_id']);
			//$list[$i]->s_del = icon('삭제', "javascript:post_send('/admin/_trans/banner/delete', {bn_id:'".$row['bn_id']."', token:'".$token."'}, true);");
			$list[$i]->s_del = icon('삭제', "javascript:del('admin/design/banner/delete/".$row['bn_id']."')");


			// 이미지 실제 사이즈
			$arr = array('sql_select' => 'img_width,img_height','sql_from' => 'file_manager','sql_where' => array('wr_table'=>'mng_banner','wr_table_idx'=>$row['bn_id']));
			$row_fm = $this->basic_model->arr_get_row($arr);

			$bn_width = ($row['bn_width'] > 0) ? $row['bn_width'] : (isset($row_fm->img_width) ? $row_fm->img_width : 0);
			$bn_height = ($row['bn_height'] > 0) ? $row['bn_height'] : (isset($row_fm->img_height) ? $row_fm->img_height : 0);

			$list[$i]->bn_width = $bn_width;
			$list[$i]->bn_height = $bn_height;


		}



		// 카테고리별 배너 저장
		$list_common = $list_main = $list_sub = $list_etc = array();
		$bno_common = $bno_main = $bno_sub = $bno_etc = 0;

		$result_code = $this->banner_model->list_result_code();
		foreach ($result_code['qry'] as $row) {

			switch ($row['bn_category']) {

					// 1. 공통
					case 'common':

						$bn_code_common_tmp = $row['bn_code'];
						if($bno_common < 1)
							$bn_code_common = $bn_code_common_tmp;
						else {
							if($bn_code_common === $bn_code_common_tmp) :
								//continue;
							else :
								$bn_code_common = $bn_code_common_tmp;
							endif;
						}
						$list_common[$bno_common] = new stdClass();
						$list_common[$bno_common]->bn_code = $bn_code_common;
						$list_common[$bno_common]->bn_name = $row['bn_name'];
						$bno_common++;

					//break;
					// 2. 메인
					case 'main':

						$bn_code_main_tmp = $row['bn_code'];
						if($bno_main < 1)
							$bn_code_main = $bn_code_main_tmp;
						else {
							if($bn_code_main === $bn_code_main_tmp) :
								//continue;
							else :
								$bn_code_main = $bn_code_main_tmp;
							endif;
						}

						$list_main[$bno_main] = new stdClass();
						$list_main[$bno_main]->bn_code = $bn_code_main;
						$list_main[$bno_main]->bn_name = $row['bn_name'];
						$bno_main++;

					//break;
					// 3. 서브
					case 'sub':

						$bn_code_sub_tmp = $row['bn_code'];
						if($bno_sub < 1)
							$bn_code_sub = $bn_code_sub_tmp;
						else {
							if($bn_code_sub === $bn_code_sub_tmp) :
								//continue;
							else :
								$bn_code_sub = $bn_code_sub_tmp;
							endif;
						}

						$list_sub[$bno_sub] = new stdClass();
						$list_sub[$bno_sub]->bn_code = $bn_code_sub;
						$list_sub[$bno_sub]->bn_name = $row['bn_name'];
						$bno_sub++;

					//break;
					// 4. 기타
					case 'etc':

						$bn_code_etc_tmp = $row['bn_code'];
						if($bno_etc < 1) {
							$bn_code_etc = $bn_code_etc_tmp;
						}
						else {
							if($bn_code_etc === $bn_code_etc_tmp) :
								//continue;
							else :
								$bn_code_etc = $bn_code_etc_tmp;
							endif;
						}

						$list_etc[$bno_etc] = new stdClass();
						$list_etc[$bno_etc]->bn_code = $bn_code_etc;
						$list_etc[$bno_etc]->bn_name = isset($row['bn_name']) ? $row['bn_name'] : '';
						$bno_etc++;

					//break;

					default: 
						break;

			}

		}
		$list_cnt = array('common'=>$bno_common,'main'=>$bno_main,'sub'=>$bno_sub,'etc'=>$bno_etc);



		// Get data.
			$breadcrumb = array(
				'디자인'=>base_url().'admin/design/main',
				'배너'=>base_url().'admin/design/banner',
				'배너 관리'=>''
			);

			$data = array(
				'list' => $list,

				'list_cnt' => $list_cnt,
				'list_common' => $list_common,
				'list_main' => $list_main,
				'list_sub' => $list_sub,
				'list_etc' => $list_etc,

				'seg4' => $this->uri->segment(4, 'all'),
				'bncode' => $param->get('bncode'),

				's_add' => icon('작성', 'banner/form'),

				'sfl' => $sfl,
				'stx' => $stx,

				'total_cnt' => number_format($result['total_cnt']),
				'paging' => $this->pagination->create_links(),

				'sort_bn_name' => $param->sort('bn_name'),
				'sort_bn_category' => $param->sort('bn_category'),
				'sort_bn_type' => $param->sort('bn_type'),
				'sort_bn_sdate' => $param->sort('bn_sdate'),
				'sort_bn_edate' => $param->sort('bn_edate'),

				'arr_seg'   => $this->arr_seg, //$this->uri->segment_array(),
				'breadcrumb'    => $breadcrumb,
				'viewPage'  => 'admin/design_banner_list_view'
			);

			$this->load->view('admin/layout_view', $data);


	}


    /** -----------------------------------------------------------------------------------------------------------
     | 배너 수정 및 등록하기
     |  ------------------------------------------------------------------------------------------------------------
     */
	function _banner_form($w='', $bn_id=FALSE,$page_num=FALSE) {

		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		// 글 작성(새글, 답변글, 수정)시 업로드 파일 저장을 위해 고유 세션 생성
		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		$user_idx = $this->tank_auth->get_user_id();
		$ss_write_name = 'ss_file_'.$user_idx;
		if (! $this->session->userdata($ss_write_name)) {
			$this->session->set_userdata($ss_write_name, $user_idx.'_'.time());
		}


		$this->load->library('form_validation');

		$config = array(
			array('field'=>'bn_name', 'label'=>'* 배너명', 'rules'=>'trim|required'),
			array('field'=>'bn_category', 'label'=>'* 배너카테고리', 'rules'=>'trim|required'),
			array('field'=>'bn_code', 'label'=>'* 배너위치코드', 'rules'=>'trim|required')
			/*
			array('field'=>'bn_rank', 'label'=>'배너순위', 'rules'=>'trim|required'),
			array('field'=>'bn_width', 'label'=>'배너 가로 사이즈', 'rules'=>'trim|required'),
			array('field'=>'bn_height', 'label'=>'배너 세로 사이즈', 'rules'=>'trim|required'),
			array('field'=>'bn_type', 'label'=>'배너 타입', 'rules'=>'trim|required')
			array('field'=>'bn_sdate', 'label'=>'배너 시작일자', 'rules'=>'trim|required'),
			array('field'=>'bn_edate', 'label'=>'배너 종료일자', 'rules'=>'trim|required'),
			*/
		);

		$this->form_validation->set_rules($config);
		if ($this->form_validation->run() == FALSE) {

				$bn_row = FALSE;
				$page_num_link = '';
				if ($w == '') {
						$title = "등록";
				}
				else if ($w == 'u') {

						$title = "수정";
						$image_src = FALSE;

						// 등록된 배너
						if($bn_id) {
							$bn_row = $this->banner_model->get_banner($bn_id);

							//$bn_row['reg_date'] = date('Y-m-d', strtotime($bn_row['reg_datetime']));
							$bn_row['reg_date'] = substr($bn_row['reg_datetime'], 0, 10);

							$image_path = DATA_PATH.'/banner/image/'.$bn_row['bn_image'];
							if(is_file($image_path)) :
								$image_src = DATA_DIR.'/banner/image/'.$bn_row['bn_image'];
							endif;

							// 이미지 원본 사이즈
							$arr = array('sql_select' => 'img_width,img_height','sql_from' => 'file_manager','sql_where' => array('wr_table'=>'mng_banner','wr_table_idx'=>$bn_id));
							$row_fm = $this->basic_model->arr_get_row($arr);

							// 이미지 사이즈를 지정하지 않으면 원본 사이즈로 지정
							$bn_row['bn_width'] = ($bn_row['bn_width'] > 0) ? $bn_row['bn_width'] : (isset($row_fm->img_width) ? $row_fm->img_width : 0);
							$bn_row['bn_height'] = ($bn_row['bn_height'] > 0) ? $bn_row['bn_height'] : (isset($row_fm->img_height) ? $row_fm->img_height : 0);
						}
						$bn_row['bn_image_src'] = $image_src;

						if($page_num)
							$page_num_link = "page/".$page_num;
						else
							$page_num_link = "";

				}
				else {
						alert("잘못된 접근입니다.");
				}

				// 배너 코드(위치) 가져오기
				$code_result = $this->banner_model->get_bn_code();

				//print_r($code_result);




			// Get data.
				$last_loc = ($bn_id) ? '수정' : '등록';
				$breadcrumb = array(
					'디자인'=>base_url().'admin/design/main',
					'배너'=>base_url().'admin/design/banner',
					'배너 '.$last_loc=>''
				);


				$data = array(
					'w' => $w,
					//'token' => get_token(),
					'bn_id' => $bn_id,
					'bn_row' => $bn_row,
					'code_result' => $code_result,
					'page_num_link' => $page_num_link,
					'last_loc' => $last_loc,

					'arr_seg'   => $this->arr_seg, //$this->uri->segment_array(),
					'breadcrumb'    => $breadcrumb,
					'viewPage'  => 'admin/design_banner_form_view'
				);

				$this->load->view('admin/layout_view', $data);

		}
		else {

				//check_token();
				$w = $this->input->post('w');
				$bn_id = $this->input->post('bn_id');

				// 배너 이미지 초기화
				$bn_image = '';
				$bn_image_old = '';

				if ($bn_id) {
					$bn_row = $this->banner_model->get_banner($bn_id);
					$bn_image_old = isset($bn_row['bn_image']) ? $bn_row['bn_image'] : '';
					$bn_image = $bn_image_old;
				}

				// 기존 이미지 삭제하기를 체크 했을 때
				if ( '' != $bn_image_old && $this->input->post('del_bn_image') ) {
					//$this->upload_model->delete_image($bn_image_old,'/banner/image/');

					$file_idx=FALSE;
					$table='mng_banner';
					$table_idx=$bn_id;
					$sql_where=FALSE;
					$this->upload_lib->delete_file_manager($file_idx,$table,$table_idx,$sql_where);

					$bn_image = '';
				}

				/**
				 * - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
				 * [bn_image] 후원기업 이미지 업로드
				 * - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
				 * $this->upload_model->upload_image('bn_image','/banner/image/','400|320|140');
				 * ▶ [업로드 field name],   [업로드 경로],   [리사이즈 크기]
				 * ▶ $upload_image_names : [암호화된이름]|[원본이름]
				 * - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - */
				// 업로드 파일을 선택했을 때
				/*
				$upload_image_names = FALSE;
				if( ! empty($_FILES) && $_FILES['bn_image']['tmp_name'] ) {
					// 신규 이미지 업로드
					$upload_image_names = $this->upload_model->upload_image('bn_image','/banner/image/');
					if($upload_image_names) {
						$arr_upload_image_names = explode('|',$upload_image_names);
						$new_upload_image_name = $arr_upload_image_names[0];
						// 새로운 업로드가 성공하면, 기존 업로드 이미지는 자동 삭제처리
						if( $bn_image_old ) {
							$this->upload_model->delete_image($bn_image_old,'/banner/image/');
						}
						$bn_image = $new_upload_image_name;
					}
				}
				*/



				// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
				// 폼업로드 파일 저장 처리
				// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
				$res = $this->upload_lib->upload_file('bn_image', url_code('banner/image','e'), 'mng_banner', $bn_id, '', FALSE, FALSE, true );

				//$bn_image = FALSE;
				if( isset($res['file_name']) && '' != $res['file_name'] ) {
					$bn_image = $res['file_name'];
				}





				if (!$w) {
					$bn_id = $this->banner_model->insert($bn_image);
				}
				else if ($w == 'u') {
					$bn_id = $this->banner_model->update($bn_id, $bn_image);
				}
				else
					alert("잘못된 접근입니다.");


				// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
				// 글 작성시 에디터로 업로드 한 파일 정보 저장 후, 세션 삭제
				// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
				//$user_idx = $this->tank_auth->get_user_id();
				$sess_file_write = $this->session->userdata($ss_write_name);
				$this->upload_model->update_file_manager($sess_file_write,'mng_banner',$bn_id);




			if($bn_id)
				goto_url('/admin/design/banner/form/u/'.$bn_id);
			else
				goto_url('/admin/design/banner/lists');

		}
	}





	function _banner_delete($bn_id) {


		$bn_ids = ($bn_id) ? $bn_id : $this->input->post('bn_id');

		if (!$bn_ids)
			alert_close("잘못된 접근입니다.");

		$this->db->where_in('bn_id', $bn_ids);
		$this->db->delete('mng_banner');

		// 이미지 삭제
		if ($bn_ids) {
			$file_idx=FALSE;
			$table='mng_banner';
			$table_idx=$bn_id;
			$sql_where=' wr_table = "mng_banner" AND wr_table_idx IN ('. $bn_ids .')';
			$this->upload_lib->delete_file_manager($file_idx,$table,$table_idx,$sql_where);
		}


		goto_url('/admin/design/banner/lists/');
	}














	function popup($step="lists",$seg5=FALSE,$seg6=FALSE) 
	{

		switch ($step) {
			case 'lists':
					// 팝업 목록
					$this->_popup_lists();
			break;
			case 'form':
					// 팝업 등록/수정

					$w     = $seg5;
					$pu_id = $seg6;

					$this->_popup_form($w,$pu_id);
			break;
			case 'update':

					if ($this->input->post('chk')) {
						$pu_ids = $this->input->post('chk');
						$pu_names = $this->input->post('pu_name');
						$pu_uses = $this->input->post('pu_use');
					}
					else
						alert('잘못된 접근입니다.');

					$this->popup_model->list_update($pu_ids, $pu_names, $pu_uses);
					
					redirect('/admin/design/popup/lists');
					exit;
			
			break;
			case 'delete':

					if ($this->input->post('pu_id'))
						$pu_ids = array($this->input->post('pu_id'));
					else if ($this->input->post('chk'))
						$pu_ids = $this->input->post('chk');
					else
						alert('잘못된 접근입니다.');

					$this->popup_model->delete($pu_ids);
					
					redirect('/admin/design/popup/lists');
					exit;

			break;
			case 'del':

					if ( ! $seg5)
						alert('잘못된 접근입니다.');

					$pu_id = $seg5;

					$this->popup_model->delete($pu_id);
					
					//goto_url('/admin/popup/lists');
					redirect('/admin/design/popup/lists');
					exit;


			break;
			default:
				alert('잘못된 접근입니다.', '/');
			break;
		}

	}


	private function _popup_lists()
	{


		$param =& $this->querystring;
		$page = $this->uri->segment(6, 1);
		$sst  = $param->get('sst', 'pu_id');
		$sod  = $param->get('sod', 'asc');
		$sfl  = $param->get('sfl');
		$stx  = $param->get('stx');

		/*
		echo $sst.'<<<<br />';
		echo $sod.'<<<<br />';
		echo $sfl.'<<<<br />';
		echo $stx.'<<<<br />';
		exit;
		*/

		$config['suffix'] = $param->output();
		$config['base_url'] = RT_DIR.'/admin/design/popup/lists/page/';
		$config['per_page'] = 10;

		$offset = ($page - 1) * $config['per_page'];
		$result = $this->popup_model->list_result($sst, $sod, $sfl, $stx, $config['per_page'], $offset);

		$config['total_rows'] = $result['total_cnt'];
		$this->pagination->initialize($config);

		$list = array();
		$type = array('새창', '레이어');

		//$token = get_token();

		//print_r($result['qry']);
		//exit;


		foreach ($result['qry'] as $i => $row) {

			$list[$i] = new stdClass();

			// 번호
			$list[$i]->num = ($result['total_cnt'] - $config['per_page']*($page-1) - $i);

			$list[$i]->id = $row['pu_id'];
			$list[$i]->name = $row['pu_name'];
			$list[$i]->type = isset($row['pu_type']) ? $type[$row['pu_type']] : '';
			$list[$i]->sdate = $row['pu_sdate'];
			$list[$i]->edate = $row['pu_edate'];
			// $list[$i]->date = date('Y-m-d', strtotime($row['pu_datetime']));

			$list[$i]->use_chk = ($row['pu_use']) ? "checked='checked'" : '';

			$list[$i]->s_pre = icon('보기', "javascript:win_open('popup/".$row['pu_id']."', 'popup".$row['pu_id']."', 'left=".$row['pu_x']."px,top=".$row['pu_y']."px,width=".$row['pu_width']."px,height=".$row['pu_height']."px,scrollbars=0');");
			$list[$i]->s_mod = icon('수정', 'design/popup/form/u/'.$row['pu_id']);
			//$list[$i]->s_del = icon('삭제', "javascript:post_send('_trans/tr_admin_popup/delete', {pu_id:'".$row['pu_id']."', token:'".$token."'}, true);");
			//$list[$i]->s_del = icon('삭제', 'popup/design/del/'.$row['pu_id']);
			$list[$i]->s_del = icon('삭제', "javascript:del('admin/design/popup/del/".$row['pu_id']."')");

		}



		// Get data.
			$breadcrumb = array(
				'디자인'=>base_url().'admin/design/main',
				'팝업 목록'=>''
			);

			$data = array(

				'list' => $list,
				//'s_add' => icon('작성', 'popup/form'),

				'sfl' => $sfl,
				'stx' => $stx,

				'total_cnt' => number_format($result['total_cnt']),
				'paging' => $this->pagination->create_links(),

				'sort_pu_name' => $param->sort('pu_name'),
				'sort_pu_type' => $param->sort('pu_type'),
				'sort_pu_sdate' => $param->sort('pu_sdate'),
				'sort_pu_edate' => $param->sort('pu_edate'),
				'sort_pu_use' => $param->sort('pu_use'),

				'arr_seg'   => $this->arr_seg, //$this->uri->segment_array(),
				'breadcrumb'    => $breadcrumb,
				'viewPage'  => 'admin/design_popup_list_view'
			);

			$this->load->view('admin/layout_view', $data);
	}



	private function _popup_form($w='', $pu_id='')
	{

			// 필수 CSS 로드
			load_css('<link rel="stylesheet" type="text/css" href="'. LIB_DIR .'/editor/redactor/redactor.css" media="screen"/>');
			// 필수 JS 로드
			load_js('<script src="'. LIB_DIR .'/editor/redactor/redactor.min.js"></script>');
			load_js('<script src="'. LIB_DIR .'/editor/redactor/_langs/ko.js"></script>');
			load_js('<script src="'. LIB_DIR .'/editor/redactor/_plugins/table/table.js"></script>');
			load_js('<script src="'. LIB_DIR .'/editor/redactor/_plugins/video/video.js"></script>');


			/*
			// 필수 CSS 로드
			load_css('<link rel="stylesheet" type="text/css" href="'. LIB_DIR .'/editor/redactor/jscss/redactor.css" media="screen"/>');
			load_css('<link rel="stylesheet" type="text/css" href="'. LIB_DIR .'/editor/redactor/jscss/redactor_setting.css" media="screen"/>');

			// datetimepicker css, js
			//load_css('<link rel="stylesheet" type="text/css" href="'. LIB_DIR .'/datetimepicker-master/jquery.datetimepicker.min.css" media="screen"/>');
			//load_js('<script src="'. LIB_DIR .'/datetimepicker-master/jquery.datetimepicker.full.js"></script>');


			// 필수 JS 로드
			load_js('<script src="'. LIB_DIR .'/editor/redactor/jscss/redactor.js"></script>');
			load_js('<script src="'. LIB_DIR .'/editor/redactor/plugins/lang_kr.js"></script>');
			load_js('<script src="'. LIB_DIR .'/editor/redactor/plugins/table.js"></script>');
			load_js('<script src="'. LIB_DIR .'/editor/redactor/plugins/video.js"></script>');
			//load_js('<script src="'. LIB_DIR .'/editor/redactor/plugins/counter.js"></script>');
			*/




			/*
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
			*/



			$config = array(
				array('field'=>'pu_name', 'label'=>'* 팝업 제목', 'rules'=>'trim|required|max_length[255]|xss_clean'),
				array('field'=>'pu_content', 'label'=>'* 팝업 내용', 'rules'=>'trim|required')
				//array('field'=>'pu_file', 'label'=>'팝업 파일', 'rules'=>'trim|required|max_length[20]|alpha_dash')
			);



			// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
			// 글 작성(새글, 답변글, 수정)시 업로드 파일 저장을 위해 고유 세션 생성
			// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
			$user_idx = $this->tank_auth->get_user_id();
			$ss_write_name = 'ss_file_'.$user_idx;
			if (! $this->session->userdata($ss_write_name)) {
				$this->session->set_userdata($ss_write_name, $user_idx.'_'.time());
			}


			$this->form_validation->set_rules($config);
			if ($this->form_validation->run() == FALSE) {
				if ($w == '' || $w != 'u') {

					$title = '등록';
					$pu = array_false(array('pu_id','pu_name','pu_file','pu_content'));
					$s = array_false(array('date','h','i','s'));
					$e = array_false(array('date','h','i','s'));

					$pu['pu_use'] = 0;
					$pu['pu_type'] = 1;
					$pu['pu_width'] = $pu['pu_height'] = 100;
					$pu['pu_x'] = $pu['pu_y'] = 0;

					$pu['pu_sdate'] = $pu['pu_edate'] = '';
				}
				else if ($w == 'u') {
					$title = '수정';
					$pu = $this->popup_model->get_popup($pu_id);
					if (!isset($pu['pu_id']))
						alert('등록된 자료가 없습니다.');

					// 시작일
					list($s['date'], $time) = explode(' ', $pu['pu_sdate']);
					list($s['h'], $s['i'], $s['s']) = explode(':', $time);
					
					// 종료일
					list($e['date'], $time) = explode(' ', $pu['pu_edate']);
					list($e['h'], $e['i'], $e['s']) = explode(':', $time);
				}


				

			// Get data.
				$last_loc = ($pu_id && '' !== $pu_id) ? '팝업 수정' : '팝업 등록';
				$breadcrumb = array(
					'디자인'=>base_url().'admin/design/main',
					$last_loc=>''
				);

				$data = array(

					'w' => $w,
					//'token' => get_token(),
					'super' => 'admin',


					'pu' => $pu,

					'id' 	=> $pu['pu_id'],
					'pu_name' 	=> $pu['pu_name'],
					'file' 	=> $pu['pu_file'],
					'pu_content' 	=> $pu['pu_content'],
					'use_chk' => ($pu['pu_use']) ? "checked='checked'" : '',
					'type' 	=> $pu['pu_type'],

					'sdatetime'   => $pu['pu_sdate'],
					'sdate'   => $s['date'],
					'stime_h' => $s['h'],
					'stime_i' => $s['i'],
					'stime_s' => $s['s'],

					'edatetime'   => $pu['pu_edate'],
					'edate'   => $e['date'],
					'etime_h' => $e['h'],
					'etime_i' => $e['i'],
					'etime_s' => $e['s'],

					'width'  => $pu['pu_width'],
					'height' => $pu['pu_height'],
					'x' 	 => $pu['pu_x'],
					'y' 	 => $pu['pu_y'],

					'arr_seg'   => $this->arr_seg, //$this->uri->segment_array(),
					'breadcrumb'    => $breadcrumb,
					'viewPage'  => 'admin/design_popup_form_view'
				);

				$this->load->view('admin/layout_view', $data);

			}
			else {
				//check_token();
				
				$w = $this->input->post('w');
				if (!$w) {
					$pu = $this->popup_model->get_popup($pu_id, 'pu_id');
					if (isset($pu['pu_id']))
						alert('이미 존재하는 팝업 ID 입니다.');
				}
				else if ($w == 'u') {
					// what!?
				}
				else
					alert('잘못된 접근입니다.');

				$pu_id = $this->popup_model->record($w);



				// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
				// 글 작성시 에디터로 업로드 한 파일 정보 저장 후, 세션 삭제
				// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
				//$user_idx = $this->tank_auth->get_user_id();
				$sess_file_write = $this->session->userdata($ss_write_name);
				$this->upload_model->update_file_manager($sess_file_write,'mng_popup',$pu_id);




				// goto_url(ADM_F.'/popup/form/u/'.$pu_id);
				redirect('/admin/design/popup/form/u/'.$pu_id);
			}

	}


































	

}
