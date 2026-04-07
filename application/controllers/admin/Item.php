<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Item extends CI_Controller
{
	function __construct()
	{
		parent::__construct();

		$this->load->helper(array('form', 'load','security'));
		$this->load->library('form_validation');
		$this->load->library('tank_auth');
		$this->load->library('item_lib');
		$this->load->library('upload_lib');
		$this->load->library('pagination');
		$this->load->library('querystring');
		$this->load->model('upload_model');
		$this->lang->load('tank_auth');

		$this->username = $this->tank_auth->get_username();
		$this->arr_seg = $this->uri->segment_array();

		// table
		$this->tbl_items = 'items';
		$this->tbl_item_category = 'item_category';
		$this->tbl_item_zzim = 'item_zzim';

		$this->tbl_file_manager = 'file_manager';




		// 관리자 로그인 후에만 접속 가능, 그 외에는 메인 페이지로 이동.
		if (! $this->tank_auth->is_admin()) {			// not logged in or activated
			$this->tank_auth->logout();
			redirect(base_url().'auth/login/'. url_code( current_url(), 'e'));
		}
	}


	/** + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + +
	| index
	*/
	function index()
	{

		if ($this->tank_auth->is_admin()) {									// logged in
			redirect('/admin/item/lists');
		}
		elseif($this->tank_auth->is_logged_in()) {
			$this->tank_auth->logout();
			//alert('관리자로 로그인해주세요.','admin/');
			//alert($this->lang->line('auth_message_admin_page'), 'admin/');
		}
		else {
			redirect('/auth/');
		}
	}





	/** + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + +
	| 카테고리 관리
	*/
	function category() {

		// 1차 카테고리
			$sql_arr = array(
					'sql_select'     => '*',
					'sql_from'       => $this->tbl_item_category,
					'sql_where'      => array('depth'=>1,'disuse'=>NULL,'del_datetime'=>NULL),
					'sql_order_by'   => 'order ASC',
			);
			$result_cate1 = $this->basic_model->arr_get_result($sql_arr);

		// Get data.
			$breadcrumb = array(
				'제품'=>base_url().'admin/item/lists',
				'카테고리 관리'=>''
			);

			$data = array(
				'result_cate1' => $result_cate1,

				'arr_seg'   => $this->arr_seg, //$this->uri->segment_array(),
				'breadcrumb'    => $breadcrumb,
				'viewPage'  => 'admin/item_category_view'
			);

			$this->load->view('admin/layout_view', $data);
	}








	/** + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + +
	| 제품 관리
	*/

	// 제품 등록
	function form($idx=FALSE) {



			// 선택 제품 정보
			$sql_arr = array(
					'sql_select'     => '*',
					'sql_from'       => $this->tbl_items,
					'sql_where'      => array('idx'=>$idx)
			);
			$row = $this->basic_model->arr_get_row($sql_arr);
			if( $idx && $idx > 0 && ! isset($row->idx) ) {
				alert('존재하지 않거나 이미 삭제된 제품입니다.',base_url().'admin/item/lists');
				exit;
				//return FALSE;
			}



			
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



			// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
			// 글 작성(새글, 답변글, 수정)시 업로드 파일 저장을 위해 고유 세션 생성
			// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
			$user_idx = $this->tank_auth->get_user_id();
			$ss_write_name = 'ss_file_'.$user_idx;
			if (! $this->session->userdata($ss_write_name)) {
				$this->session->set_userdata($ss_write_name, $user_idx.'_'.time());
			}


			// 카테고리 정보
			$sql_arr = array(
					'sql_select'     => '*',
					'sql_from'       => $this->tbl_item_category,
					'sql_where'      => array('depth'=>1,'disuse'=>NULL,'del_datetime'=>NULL),
					'sql_order_by'   => 'order ASC',
			);
			$result_cate1 = $this->basic_model->arr_get_result($sql_arr);


			// 에러 메시지 CSS
			$this->form_validation->set_error_delimiters('<div class="err_color_red">','</div>');

			$this->form_validation->set_rules('cate1', '1차 카테고리', 'trim|xss_clean');
			$this->form_validation->set_rules('cate2', '2차 카테고리', 'trim|xss_clean');
			$this->form_validation->set_rules('cate3', '3차 카테고리', 'trim|xss_clean');
			$this->form_validation->set_rules('cate4', '4차 카테고리', 'trim|xss_clean');

			$this->form_validation->set_rules('cate_idx', '카테고리', 'trim|required|xss_clean');

			if( ! $idx) {
				$this->form_validation->set_rules('itm_code', '제품 코드', 'trim|required|xss_clean|is_unique[items.itm_code]');
			}

			$this->form_validation->set_rules('itm_title', '제품명', 'trim|required|xss_clean');
			$this->form_validation->set_rules('itm_subtitle', '제품명 하단 설명', 'trim|xss_clean');
			$this->form_validation->set_rules('itm_order', '제품 정렬순서', 'trim|required|xss_clean');

			$this->form_validation->set_rules('itm_maker', '제조사', 'trim|xss_clean');
			$this->form_validation->set_rules('itm_origin', '원산지', 'trim|xss_clean');
			$this->form_validation->set_rules('itm_brand', '브랜드', 'trim|xss_clean');
			$this->form_validation->set_rules('itm_model', '모델', 'trim|xss_clean');
			$this->form_validation->set_rules('itm_price', '가격', 'trim|xss_clean');

			$this->form_validation->set_rules('itm_type_hit', '히트', 'trim|xss_clean');
			$this->form_validation->set_rules('itm_type_pick', '추천', 'trim|xss_clean');
			$this->form_validation->set_rules('itm_type_new', '신상품', 'trim|xss_clean');
			$this->form_validation->set_rules('itm_type_best', '베스트', 'trim|xss_clean');
			$this->form_validation->set_rules('itm_type_dc', '할인', 'trim|xss_clean');

			$this->form_validation->set_rules('itm_desc', '상세 정보', 'trim');
			$this->form_validation->set_rules('itm_desc_mobile', '상세 정보 - 모바일', 'trim');
			$this->form_validation->set_rules('itm_spec', '주요 사양', 'trim');
			$this->form_validation->set_rules('itm_spec_mobile', '주요 사양 - 모바일', 'trim');
			$this->form_validation->set_rules('itm_addinfo', '추가 정보', 'trim');
			$this->form_validation->set_rules('itm_addinfo_mobile', '추가 정보 - 모바일', 'trim');



			if ($this->form_validation->run() == FALSE)
			{
					//$this->load->view('myform');
			}
			else
			{
					//$this->load->view('formsuccess');

					if (!is_null($data = $this->item_lib->form($idx))) {		// success

							// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
							// 폼업로드 파일 저장 처리
							// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
							$this->load->library('upload_lib');
							$max_upload_size = 20480; // 2048:2MB, 20480:20MB


							/*
							// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
							// 제품 이미지 업로드는 ajax로만 처리.
							// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

								// 제품 이미지 업로드는 신규 등록시에만 여기에서 처리.
								// 수정시에는 ajax 로 처리
								$succ_cnt = 0;
								if(! $idx) {
									//$this->upload_lib->multi_upload_file('attach_file_img[]', url_code('item/image','e'), $this->tbl_items, $idx, '', $max_upload_size, true);
									$succ_cnt = $this->upload_lib->multi_upload_file('attach_file_img', url_code('item/image','e'), $this->tbl_items, '', '', $max_upload_size, false);
								}
							*/


							// 다운로드 파일 관리는 최대 30개까지
							for($ino=1;$ino<=30;$ino++) {
								$file_title = $this->input->post('file_title_'.$ino,FALSE);
								$wr_table_idx = ($idx) ? $idx : false;
								if( isset($_FILES['attach_download_'.$ino]['size'])  &&  $_FILES['attach_download_'.$ino]['size'] > 0) {
									$this->upload_lib->upload_file('attach_download_'.$ino,url_code('item/files','e'),$this->tbl_items,$wr_table_idx,1,FALSE,FALSE,true,$max_upload_size,$ino,'download',$file_title);
								}
								// 글 작성시 업로드 한 다운로드 파일명 업데이트
								$this->upload_model->update_file_title($this->tbl_items,$data['idx'],$file_title,$ino);
							}

							// 다운로드 파일 순서 재정렬
							$this->reOrderDownNo($this->tbl_items,$data['idx'],'download');

							// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
							// 글 작성시 에디터로 업로드 한 파일 정보 저장 후, 세션 삭제
							// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
							//$user_idx = $this->tank_auth->get_user_id();
							$sess_file_write = $this->session->userdata($ss_write_name);
							$res = $this->upload_model->update_file_manager($sess_file_write,$this->tbl_items,$data['idx']);



							sess_message('제품 정보가 저장되었습니다.');
							if($idx) {
								redirect(current_url());
							} else {
								redirect(current_url().'/'.$data['idx']);
							}

					} else {
						$errors = $this->tank_auth->get_error_message();
						foreach ($errors as $k => $v)	$data['errors'][$k] = $this->lang->line($v);
					}

			}



			// 제품 정보
			$row = array();
			$row_cate = array();
			$result_cate2 = $result_cate3 = $result_cate4 = array();
			$img_list = array();
			$result_file_form = array();
			$cate_text = '';

			//$download = array('','','','',''); // [0]은 더미, $download[1]~[4] 
			$download = array();


			if($idx) {
				
					// 제품 정보
					$sql_from = $this->tbl_items;
					$sql_where = array('idx'=>$idx);
					$arr = array('sql_select' => '*','sql_from' => $sql_from,'sql_where' => $sql_where);
					$row = $this->basic_model->arr_get_row($arr);


					// 카테고리 정보
					$sql_from = $this->tbl_item_category;
					$sql_where = array('idx'=>$row->cate_idx);
					$arr = array('sql_select' => '*','sql_from' => $sql_from,'sql_where' => $sql_where);
					$row_cate = $this->basic_model->arr_get_row($arr);



					if($row->cate1 > 0) {
						$row_tmp = $this->basic_model->arr_get_row(array('sql_select'=>'name', 'sql_from'=>$this->tbl_item_category, 'sql_where'=>array('idx'=>$row->cate1)));
						$cate_text .= $row_tmp->name;
					}
					if($row->cate2 > 0) {
						$row_tmp = $this->basic_model->arr_get_row(array('sql_select'=>'name', 'sql_from'=>$this->tbl_item_category, 'sql_where'=>array('idx'=>$row->cate2)));
						//$cate_text .= ' > '.$row_tmp->name;
						$cate_text .= isset($row_tmp->name) ? ' > '.$row_tmp->name : '';
					}
					if($row->cate3 > 0) {
						$row_tmp = $this->basic_model->arr_get_row(array('sql_select'=>'name', 'sql_from'=>$this->tbl_item_category, 'sql_where'=>array('idx'=>$row->cate3)));
						//$cate_text .= ' > '.$row_tmp->name;
						$cate_text .= isset($row_tmp->name) ? ' > '.$row_tmp->name : '';
					}
					if($row->cate4 > 0) {
						$row_tmp = $this->basic_model->arr_get_row(array('sql_select'=>'name', 'sql_from'=>$this->tbl_item_category, 'sql_where'=>array('idx'=>$row->cate4)));
						//$cate_text .= ' > '.$row_tmp->name;
						$cate_text .= isset($row_tmp->name) ? ' > '.$row_tmp->name : '';
					}




					// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
					// 폼에서 업로드한 제품 이미지 파일 가져오기
					// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
						$sql_select = '*';
						$sql_from = $this->tbl_file_manager;
						$sql_where = array('wr_table'=>$this->tbl_items,'wr_table_idx'=>$idx,'upload_type'=>'form','gubun'=>'thumb');
						$sql_group_by = FALSE;
						$sql_order_by = 'order ASC';
						// 조인
						$sql_join_tbl = FALSE;
						$sql_join_on = FALSE;
						$sql_join_option = 'LEFT OUTER';
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
						$result_file_form = $this->basic_model->arr_get_result($arr);
						//print_r($result_file_form);




					//$img_list = array();
					foreach($result_file_form['qry'] as $i => $o) {
						if('thumb' == $o->gubun) {
							$img_list[$i] = new stdClass();
							$img_list[$i]->wr_table = $o->wr_table;
							$img_list[$i]->wr_table_idx = $o->wr_table_idx;

							$img_list[$i]->file_idx = $o->idx;
							$img_list[$i]->file_order = $o->order;
							$img_list[$i]->file_dir = DATA_DIR.'/'.$o->file_dir.'/';
							$img_list[$i]->file_name = $o->file_name;
							$img_list[$i]->file_src = DATA_DIR.'/'.$o->file_dir.'/'.$o->file_name;
							//echo DATA_DIR.'/'.$o->file_dir.'/'.$o->file_name."<<<<<<<<br />";
						}
					}

					// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
					// 폼에서 업로드한 다운로드 파일 가져오기
					// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
						$sql_select = '*';
						$sql_from = $this->tbl_file_manager;
						$sql_where = array('wr_table'=>$this->tbl_items,'wr_table_idx'=>$idx,'upload_type'=>'form','gubun'=>'download');
						$sql_group_by = FALSE;
						$sql_order_by = 'idx DESC';
						// 조인
						$sql_join_tbl = FALSE;
						$sql_join_on = FALSE;
						$sql_join_option = 'LEFT OUTER';
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
						$result_file_form = $this->basic_model->arr_get_result($arr);
						//print_r($result_file_form);



					//$download = array();
					$j = 0;
					$n_old = '';
					foreach($result_file_form['qry'] as $i => $o) {

						if('download' == $o->gubun) {
							// $o->down_no

							$n = $o->down_no;
							$download[$n] = new stdClass();

							$download[$n]->wr_table = $o->wr_table;
							$download[$n]->wr_table_idx = $o->wr_table_idx;

							$download[$n]->file_idx = $o->idx;
							$download[$n]->file_order = $o->order;
							$download[$n]->file_dir = DATA_DIR.'/'.$o->file_dir.'/';
							$download[$n]->file_name = $o->file_name;
							$download[$n]->file_name_org = $o->file_name_org;
							$download[$n]->file_src = DATA_DIR.'/'.$o->file_dir.'/'.$o->file_name;

							$download[$n]->file_download = url_code($o->file_dir,'e').'/'.$o->file_name.'/'.$o->file_name_org;
							$download[$n]->file_download_enc = url_code($o->file_dir,'e').'/'.$o->file_name.'/'.url_code($o->file_name_org,'e');

							$download[$n]->file_title = $o->title;
						}

					}
					//exit;

			}

			// 다운로드 파일 관리 수기입력 타이틀 그룹 가져오기
			$list_down_title= $this->grp_downfiles();
			//print_r($grp_down_title);



		// Get data.
			$breadcrumb = array(
				'제품'=>base_url().'admin/itme/lists',
				'제품 등록/수정'=>''
			);

			$data = array(
				'idx'			=> $idx,
				'row'			=> $row,
				'row_cate'			=> $row_cate,
				'result_cate1' => $result_cate1,
				'result_cate2' => $result_cate2,
				'result_cate3' => $result_cate3,
				'result_cate4' => $result_cate4,

				'result_file_form' => $result_file_form,

				'cate_text' => $cate_text,

				'img_list' => $img_list,
				'download' => $download,
				'list_down_title' => $list_down_title,

				'arr_seg'   => $this->arr_seg, //$this->uri->segment_array(),
				'breadcrumb'    => $breadcrumb,
				'viewPage'  => 'admin/item_form_view'
			);

			$this->load->view('admin/layout_view', $data);
	}








	// 제품 목록
	function lists() {

		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		// 페이징 세팅, 검색어 세팅
		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
			$this->load->library('segment', array('offset'=>4), 'seg'); // 세그먼트 주소( page 위치 )
			$this->load->library('querystring', NULL, 'param'); // 쿼리스트링 주소
			$seg	  =& $this->seg;
			$param	  =& $this->param;
			
			// [sql] where option 
			$sql_where_option = array('items.idx >' => 0, 'items.del_datetime' => NULL);
			
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
			if($ofl = $param->get('ofl','items.idx DESC')) { // order_field
				$qstr .= ('' == $qstr) ? '?' : '&';
				$qstr .= 'ofl='.$ofl;
			}





		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		// 카테고리 정보 
		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

			// 카테고리 선택
			$combo_cate = array('','','','',''); // 0,1,2,3,4
			//print_r($combo_cate);

			// 카테고리 선택
			if($param->get('cidx',false)) {
				$cidx = $param->get('cidx',FALSE);
				$depth = $param->get('depth',FALSE);
				$qstr .= ('' == $qstr) ? '?' : '&';
				$qstr .= 'cidx='.$cidx;
				$qstr .= '&depth='.$depth;

				// 선택 카테고리 정보
				$sql_arr = array(
						'sql_select'     => '*',
						'sql_from'       => 'item_category',
						'sql_where'      => array('idx'=>$cidx)
				);
				$row_cate = $this->basic_model->arr_get_row($sql_arr);

				if($row_cate->depth == 1) {
					$combo_cate[1] = $row_cate->idx;
				}
				elseif($row_cate->depth == 2) {
					$combo_cate[1] = $row_cate->pcate1;
					$combo_cate[2] = $row_cate->idx;
				}
				elseif($row_cate->depth == 3) {
					$combo_cate[1] = $row_cate->pcate1;
					$combo_cate[2] = $row_cate->pcate2;
					$combo_cate[3] = $row_cate->idx;
				}
				elseif($row_cate->depth == 4) {
					$combo_cate[1] = $row_cate->pcate1;
					$combo_cate[2] = $row_cate->pcate2;
					$combo_cate[3] = $row_cate->pcate3;
					$combo_cate[4] = $row_cate->idx;
				}

				//$sql_where['cate_idx'] = $cidx;
				// OR 구문 때문에 where 절 다시 작성
				$sql_where_option = ' items.idx > 0 AND items.del_datetime IS NULL ';
				$sql_where_option .= ' AND (items.cate1='.$cidx.' OR items.cate2='.$cidx.' OR items.cate3='.$cidx.' OR items.cate4='.$cidx.') ';

			}
			//print_r($combo_cate);







		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		// sql 
		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
			$sql_select = '*';
			$sql_from = $this->tbl_items;
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
			$sql_join_tbl = FALSE; //'board_group as bgrp';
			$sql_join_on = FALSE; //'bconf.gr_code = bgrp.gr_code';
			$sql_join_option = FALSE; //'LEFT OUTER';

			// 검색 상관없는 전체 수
			$item_total_cnt = $this->basic_model->get_common_count($sql_from,$sql_where);


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
			$result['total_count_comma'] = number_format($result['total_count']);


		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		// pagination 설정
		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
			$config['suffix']	   = $qstr;
			$config['base_url']    = base_url() . 'admin/item/lists/page/';
			$config['per_page']    = $limit;
			$config['total_rows']  = $result['total_count'];
			$config['uri_segment'] = $seg->pos('page');  // 5

			// 검색 목록 
			$btn_prev_part = $btn_next_part = '';
			$config['full_tag_open']  = "<ul class='pagination'>".$btn_prev_part;
			$config['full_tag_close'] = $btn_next_part.'</ul>';

			$this->load->library('pagination', $config);









		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		// 제품 리스트 정보
		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
			foreach($result['qry'] as $i => $o) {

				// 제품 대표 썸네일
				$sql_arr = array(
						'sql_select'     => '*',
						'sql_from'       => 'file_manager',
						'sql_where'      => array('wr_table'=>$this->tbl_items,'wr_table_idx'=>$o->idx,'gubun'=>'thumb'),
						'sql_order_by'   => 'order ASC',
						'limit'   => 1
				);
				$row = $this->basic_model->arr_get_row($sql_arr);
				$file_src = '';
				if(isset($row->file_dir) && isset($row->file_name)) {
					$file_src = DATA_DIR.'/'.$row->file_dir.'/'.$row->file_name;
				}
					$result['qry'][$i]->thumb1 = $file_src;

				// 카테고리
				$cate_text = '';

				if($o->idx) {
					
						// 제품 정보
						$sql_from = $this->tbl_items;
						$sql_where = array('idx'=>$o->idx);
						$arr = array('sql_select' => '*','sql_from' => $sql_from,'sql_where' => $sql_where);
						$row = $this->basic_model->arr_get_row($arr);

						// 카테고리 정보
						$sql_from_cate = $this->tbl_item_category;
						$sql_where = array('idx'=>$row->cate_idx);
						$arr = array('sql_select' => '*','sql_from' => $sql_from_cate,'sql_where' => $sql_where);
						$row_cate = $this->basic_model->arr_get_row($arr);

						if($row->cate1 > 0) {
							$row_tmp = $this->basic_model->arr_get_row(array('sql_select'=>'name', 'sql_from'=>$sql_from_cate, 'sql_where'=>array('idx'=>$row->cate1)));
							$cate_text .= $row_tmp->name;
						}
						if($row->cate2 > 0) {
							$row_tmp = $this->basic_model->arr_get_row(array('sql_select'=>'name', 'sql_from'=>$sql_from_cate, 'sql_where'=>array('idx'=>$row->cate2)));
							//$cate_text .= ' > '.$row_tmp->name;
							$cate_text .= isset($row_tmp->name) ? ' > '.$row_tmp->name : '';
						}
						if($row->cate3 > 0) {
							$row_tmp = $this->basic_model->arr_get_row(array('sql_select'=>'name', 'sql_from'=>$sql_from_cate, 'sql_where'=>array('idx'=>$row->cate3)));
							//$cate_text .= ' > '.$row_tmp->name;
							$cate_text .= isset($row_tmp->name) ? ' > '.$row_tmp->name : '';
						}
						if($row->cate4 > 0) {
							$row_tmp = $this->basic_model->arr_get_row(array('sql_select'=>'name', 'sql_from'=>$sql_from_cate, 'sql_where'=>array('idx'=>$row->cate4)));
							//$cate_text .= ' > '.$row_tmp->name;
							$cate_text .= isset($row_tmp->name) ? ' > '.$row_tmp->name : '';
						}

				}

				$result['qry'][$i]->cate_text = $cate_text;
			}



		// 카테고리 정보
			$result_cate1 = $result_cate2 = $result_cate3 = $result_cate4 = array();

			$sql_arr = array(
					'sql_select'     => '*',
					'sql_from'       => $this->tbl_item_category,
					'sql_where'      => array('depth'=>1,'disuse'=>NULL,'del_datetime'=>NULL),
					'sql_order_by'   => 'order ASC',
			);
			$result_cate1 = $this->basic_model->arr_get_result($sql_arr);

			$sql_arr['sql_where'] = array('depth'=>2,'pcate1'=>$combo_cate[1],'disuse'=>NULL,'del_datetime'=>NULL);
			$result_cate2 = $this->basic_model->arr_get_result($sql_arr);

			$sql_arr['sql_where'] = array('depth'=>3,'pcate2'=>$combo_cate[2],'disuse'=>NULL,'del_datetime'=>NULL);
			$result_cate3 = $this->basic_model->arr_get_result($sql_arr);

			$sql_arr['sql_where'] = array('depth'=>4,'pcate3'=>$combo_cate[3],'disuse'=>NULL,'del_datetime'=>NULL);
			$result_cate4 = $this->basic_model->arr_get_result($sql_arr);



		// Get data.
			$breadcrumb = array(
				'제품'=>base_url().'admin/item/lists',
				'제품 목록'=>''
			);

			$data = array(
				'sfl' => $sfl,
				'stx' => $stx,
				'ofl' => $ofl,

				'item_total_cnt' => $item_total_cnt,

				'result_cate1' => $result_cate1,
				'result_cate2' => $result_cate2,
				'result_cate3' => $result_cate3,
				'result_cate4' => $result_cate4,

				'combo_cate' => $combo_cate,

				'combo_cate1' => $combo_cate[1],
				'combo_cate2' => $combo_cate[2],
				'combo_cate3' => $combo_cate[3],
				'combo_cate4' => $combo_cate[4],

				'result'    => $result,
				'page'      => $page,
				'limit'      => $limit,
				'paging'    => $this->pagination->create_links(),

				'arr_seg'   => $this->arr_seg, //$this->uri->segment_array(),
				'breadcrumb'    => $breadcrumb,
				'viewPage'  => 'admin/item_lists_view'
			);

			$this->load->view('admin/layout_view', $data);
	}














	// 제품 삭제
	//function del_prd($idx=FALSE) {
	function del_item($idx=FALSE) {
		if($idx) {

			// 선택 제품 정보
			$sql_arr = array(
					'sql_select'     => '*',
					'sql_from'       => $this->tbl_items,
					'sql_where'      => array('idx'=>$idx)
			);
			$row = $this->basic_model->arr_get_row($sql_arr);
			if( $idx > 0 && ! isset($row->idx) ) {
				alert('존재하지 않거나 이미 삭제된 제품입니다.',base_url().'admin/item/lists');
				exit;
				//return FALSE;
			}

			// 제품 삭제
			if(isset($row->idx)) {

				// 제품 테이블에서 삭제
				/*
					$this->db->where('idx', $row->idx);
					$this->db->delete($this->tbl_items);
				*/

				// 제품 테이블 삭제상태로 업데이트
					$data = array('del_username'=>$this->username, 'del_datetime'=>TIME_YMDHIS);
					$this->db->where('idx',$row->idx);
					if($res = $this->db->update($this->tbl_items, $data)) {

						// 제품 이미지 및 파일 삭제
							$sql_arr = array(
									'sql_select'     => '*',
									'sql_from'       => $this->tbl_file_manager,
									'sql_where'      => array('wr_table'=>$this->tbl_items,'wr_table_idx'=>$row->idx),
									'sql_order_by'   => 'order ASC',
							);
							$result = $this->basic_model->arr_get_result($sql_arr);
							foreach($result['qry'] as $key => $o) {
								$this->upload_lib->delete_file_manager($o->idx);
							}

					}

			}

			alert('삭제되었습니다.',base_url().'admin/item/lists');

		}
	}



	// 파일 삭제
	function del_file($file_idx,$wr_table,$wr_table_idx,$rpath_encode) {
		//$this->upload_lib->delete_file_manager(false,false,false,array('wr_table'=>'products','wr_table_idx'=>$wr_table_idx,'gubun'=>'thumb'));
		$this->upload_lib->delete_file_manager($file_idx);

		if($this->tbl_items == $wr_table) {
			$this->reOrderDownNo($wr_table,$wr_table_idx,'download');
		}

		if($this->thumbReOrder($wr_table,$wr_table_idx,'download')) {
			$rpath_decode = url_code($rpath_encode, 'd');
			redirect($rpath_decode);
		}
	}


	// 썸네일 삭제
	function del_thumbnail($file_idx,$wr_table,$wr_table_idx,$rpath_encode) {
		//$this->upload_lib->delete_file_manager(false,false,false,array('wr_table'=>'products','wr_table_idx'=>$wr_table_idx,'gubun'=>'thumb'));
		$this->upload_lib->delete_file_manager($file_idx);

		if($this->thumbReOrder($wr_table,$wr_table_idx,'thumb')) {
			$rpath_decode = url_code($rpath_encode, 'd');
			redirect($rpath_decode);
		}
	}

	function thumbReOrder($wr_table,$wr_table_idx,$gubun='thumb') {
		

			$sql_arr = array(
					'sql_select'     => '*',
					'sql_from'       => $this->tbl_file_manager,
					'sql_where'      => array('wr_table'=>$wr_table,'wr_table_idx'=>$wr_table_idx,'gubun'=>$gubun),
					'sql_order_by'   => 'order ASC',
			);
			$result = $this->basic_model->arr_get_result($sql_arr);
			//print_r($result);

			$ord = 1;
			foreach($result['qry'] as $i => $o) {

				//echo $o->idx.'<<<br />';

				$data = array('order' => $ord);
				$this->db->where('idx',$o->idx);
				$this->db->update($this->tbl_file_manager, $data);

				$ord++;
			}

			return true;

	}


	// 제품 파일 다운로드 순서 재정렬
	function reOrderDownNo($wr_table,$wr_table_idx,$gubun='download') {
		
			$sql_arr = array(
					'sql_select'     => '*',
					'sql_from'       => $this->tbl_file_manager,
					'sql_where'      => array('wr_table'=>$wr_table,'wr_table_idx'=>$wr_table_idx,'gubun'=>$gubun),
					'sql_order_by'   => 'down_no ASC',
			);
			$result = $this->basic_model->arr_get_result($sql_arr);
			//print_r($result);

			$ord = 1;
			foreach($result['qry'] as $i => $o) {

				//echo $o->idx.'<<<br />';

				$data = array('down_no' => $ord);
				$this->db->where('idx',$o->idx);
				$this->db->update($this->tbl_file_manager, $data);

				$ord++;
			}

			return true;
	}

	// 제품 다운로드 파일 수기입력 타이틀 그룹 가져오기
	function grp_downfiles() {
		
			$sql_arr = array(
					'sql_select'     => 'title',
					'sql_from'       => $this->tbl_file_manager,
					'sql_where'      => array('wr_table'=>$this->tbl_items,'gubun'=>'download','title !='=>''),
					'sql_order_by'   => 'title ASC',
					'sql_group_by'   => 'title',
			);
			$result = $this->basic_model->arr_get_result($sql_arr);
			//print_r($result);

			$list = array();
			foreach($result['qry'] as $i => $title) {
				$list[$i] = $title;
			}

			return $list;
	}








}