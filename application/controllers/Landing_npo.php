<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Landing_npo extends CI_Controller {

	function __construct()
	{
		parent::__construct();

		$this->load->helper(array('form', 'load'));
		$this->load->library('form_validation');
		$this->load->library('tank_auth');
		$this->load->library('upload_lib');
		$this->load->library('landing_lib');
		$this->load->model('upload_model');
		$this->lang->load('tank_auth');

		$this->arr_seg = $this->uri->segment_array();

		//echo $this->uri->uri_string().'<<';

		if (! $this->tank_auth->is_logged_in()) {  // not logged in or not activated
			//redirect('/auth/login/'. url_code($this->uri->uri_string(), 'e'));
			redirect('/auth/login/'. url_code(base_url($this->uri->uri_string()), 'e'));
		}
	}

	function index() {

		redirect(base_url('landing_npo/form'));

	}


	// 협약 안내 페이지
	function guide() {

		// 필수 CSS 로드
		load_css('<link rel="stylesheet" type="text/css" href="'. LIB_DIR .'/editor/redactor/redactor.css?v=1" media="screen"/>');

		$data = array(
			'arr_seg' => $this->arr_seg,
			'viewPage' => 'landing/landing_npo_guide_view'
		);

		$this->load->view('layout_npo_view', $data);
	}


	// 협약 신청 폼
	function form($arr_seg=FALSE) {
		$code = 'npo';
		$page_code = (isset($arr_seg[0]) && $arr_seg[0] != '') ? $arr_seg[0] : false;
		$page_uri = (isset($arr_seg[1]) && $arr_seg[1] != '') ? $arr_seg[1] : '';

		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		// 글 작성(새글, 답변글, 수정)시 업로드 파일 저장을 위해 고유 세션 생성
		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		$user_idx = $this->tank_auth->get_user_id();
		$ss_write_name = 'ss_file_'.$user_idx;
		if (! $this->session->userdata($ss_write_name)) {
			$this->session->set_userdata($ss_write_name, $user_idx.'_'.time());
		}


		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		// 신청 문의 접수 SUBMIT
		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		if( $submit_code = $this->input->post('submit_code',FALSE) )
		{


			// https://chatgpt.com/c/68ba9bed-3124-832b-a08f-b0791997385b
			// https://chatgpt.com/share/68baa362-f160-8007-b215-cd6b6e15f138
			/*
				$website = $this->input->post('website', true);        // 허니팟
				$started = (int)$this->input->post('form_started_at'); // 타임트랩
				$elapsed = time() - $started;

				if (!empty($website)) return show_error('스팸 의심(허니팟).', 400);
				if ($elapsed < 3)     return show_error('스팸 의심(너무 빠름).', 400);
			*/



			/*
				// 스팸
				$ip = '112.214.116.110'
				*/


				/*
				$ip = '112.214.116.110'; // REMOTE_ADDR;
				$minutes = 10; // 10분
				$threshold = 10;

				$this->db->from('landing')
						 ->where('ip', $ip)
						 ->where('created >=', date('Y-m-d H:i:s', time() - $minutes * 60));
				$cnt_time = $this->db->count_all_results();

				$this->db->from('landing')
						 ->where('ip', $ip)
						 ->limit(10);
				$cnt_limit = $this->db->count_all_results();


				if($cnt_time >= $threshold  OR  $cnt_limit >= $threshold) {
					// 스팸으로 의심됨
					echo $cnt.'<<====<';
					echo $cnt_limit."<<<< limit";
					exit;

				}
			*/








			// # 에러 메시지 CSS
			$this->form_validation->set_error_delimiters('<div class="err_color_red">','</div>');

			// Set validation rules.
			$validation_rules = array();

			$sql_select = '*';
			$sql_from = 'mng_landing';
			$sql_where = array('code'=>$code,'del_datetime'=>NULL);
			$arr = array('sql_select' => $sql_select,'sql_from' => $sql_from,'sql_where' => $sql_where);
			$row = $this->basic_model->arr_get_row($arr);

			$arr_fld_nm = array();
			$arr_fld_chk = array();
			$arr_fld_type = array();

			// 랜딩 페이지 파일 정보
			$arr_file_ttl = array();
			$arr_file_desc = array();

			if(isset($row->idx)) {
				$arr_fld_nm = array($row->fld_nm_1,$row->fld_nm_2,$row->fld_nm_3,$row->fld_nm_4,$row->fld_nm_5,$row->fld_nm_6,$row->fld_nm_7,$row->fld_nm_8,$row->fld_nm_9,$row->fld_nm_10);
				$arr_fld_chk = array($row->fld_chk_1,$row->fld_chk_2,$row->fld_chk_3,$row->fld_chk_4,$row->fld_chk_5,$row->fld_chk_6,$row->fld_chk_7,$row->fld_chk_8,$row->fld_chk_9,$row->fld_chk_10);
				$arr_fld_type = array($row->fld_type_1,$row->fld_type_2,$row->fld_type_3,$row->fld_type_4,$row->fld_type_5,$row->fld_type_6,$row->fld_type_7,$row->fld_type_8,$row->fld_type_9,$row->fld_type_10);

				$arr_file_ttl = array($row->file_ttl_1,$row->file_ttl_2,$row->file_ttl_3,$row->file_ttl_4,$row->file_ttl_5);
				$arr_file_desc = array($row->file_desc_1,$row->file_desc_2,$row->file_desc_3,$row->file_desc_4,$row->file_desc_5);

			}

			foreach($arr_fld_nm as $i => $fld_nm) {
				$no = $i + 1;
				if($fld_nm == '') {
					continue;
				}
				$rules = 'trim';
				if($arr_fld_chk[$i] == 1) {
					$rules .= '|required';
				}

				$validation_rules[] = array('field' => 'txtfld_'.$no, 'label' => $fld_nm, 'rules' => $rules);
				//array_push($validation_rules, array('field' => 'txtfld_'.$no, 'label' => $fld_nm, 'rules' => $rules));
			}

			$validation_rules[] = array('field' => 'agree', 'label' => '개인정보 수집 및 이용 동의', 'rules' => 'trim|required');
			
			$this->form_validation->set_rules($validation_rules);

			// [2024-01-30] NPO 협약신청 폼에서만 파일 업로드 필수 체크
			if('npo' == $code) {

				$f_cnt = count($_FILES['attach_file']['name']);
				$f_chk = true;
				if($f_cnt > 0) {
					foreach($_FILES['attach_file']['name'] as $key => $val) {
						if(strlen($val) < 1) {
							$f_chk = false;
						}
					}
				}

				if( ! $f_chk) {
					// 파일 업로드가 있는데, 업로드 값이 없는 것이 하나라도 있으면 체크
					$this->form_validation->set_rules('attach_file[]', '파일 첨부', 'required');
				}

			}


			// Run the validation.
			//if ($this->form_validation->run() !== FALSE) {

			$succ = false;

			if ($this->form_validation->run())
			{

				if (!is_null($res = $this->landing_lib->write($submit_code))) {		// success


					// 업로드
					if( isset($res['idx']) ) {

							$succ = true;

							// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
							// 폼업로드 파일 저장 처리
							// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
							$max_file_cnt = isset($res['file_cnt']) ? $res['file_cnt'] : 0;

							//for($no=1; $no<=$max_file_cnt; $no++) {

								//$this->load->library('upload_lib');
								// max upload size
								//$max_upload_size = 20480; // 20MB
								$tbl_code = 'mng_landing';

								//$field_name = 'attach_file_'.$no;
								$field_name = 'attach_file[]';
								$encoded_upload_folder = url_code('landing/files','e');
								$wr_table = $tbl_code;
								$wr_table_idx = $res['idx'];
								$wr_opt_idx='';
								$multi_files=FALSE;
								$multi_index=FALSE;
								$return_data=TRUE;
								$max_upload_size=20480;
								$down_no=FALSE;
								$gubun='download';
								$file_title=FALSE;



								//$this->upload_lib->upload_file($field_name,$encoded_upload_folder,$wr_table,$wr_table_idx,$wr_opt_idx,$multi_files,$multi_index,$return_data,$max_upload_size,$down_no,$gubun,$file_title);


								$this->upload_lib->multi_upload_file($field_name, url_code('landing/files','e'), $tbl_code, $res['idx'], '', $max_upload_size);

								//echo $field_name.'<<<<<<<<<<<<<<<<<<<<br />';
								//exit;
								//echo $cnt_succ_upload.'<<<<<<';
								//exit;

								// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
								// 글 작성시 에디터로 업로드 한 파일 정보 저장 후, 세션 삭제
								// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
								//$sess_file_write = $this->session->userdata($ss_write_name);
								//$this->upload_model->update_file_manager($sess_file_write,$tbl_code,$res['idx']);

							//}

					}


					if($succ) {

						// [2024-01-09] 접수 완료 이메일 발송
						//$this->_send_email($submit_code, 'jinakim@remann.co.kr,jin@remann.co.kr,riddleme@naver.com',$res);
						$arr_email = array('jinakim@remann.co.kr', 'jin@remann.co.kr', 'gugaya@remann.co.kr', 'incoreain@gmail.com');
						$this->_landing_send_email($submit_code, $arr_email, $res);

						// 접수 완료 메시지
						$succ_msg = '';
						if('npo' == $submit_code)      { $succ_msg .= 'NPO 협약 신청 '; }
						elseif('comp' == $submit_code) { $succ_msg .= '기업 제휴 문의 '; }
						elseif('campaign' == $submit_code) { $succ_msg .= '캠페인 개설 협약 신청 문의 '; }
						else { $succ_msg .= '신청 문의 '; }
						$succ_msg .= '접수가 완료되었습니다. \n운영팀에서 검토 후 연락드리겠습니다. \n감사합니다.';

						//$succ_redirect = base_url().'landing/'.$submit_code;
						//alert($succ_msg, $succ_redirect);

					}
					else {
						$succ_msg = '정상적인 경로로 접수해주세요.';
					}

					$succ_redirect = base_url().'landing/'.$submit_code;
					alert($succ_msg, $succ_redirect);

				}
			}

		}
		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -


		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		// 생성된 컨텐츠 페이지 정보 가져오기
		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		$sql_select = '*';
		$sql_from = 'mng_landing';
		//$sql_where = array('idx'=>$idx,'del_datetime'=>NULL);
		$sql_where = array('code'=>$code,'del_datetime'=>NULL);
		// 검색 상관없는 전체 수
		$arr = array(
				'sql_select'     => $sql_select,
				'sql_from'       => $sql_from,
				'sql_where'      => $sql_where, //array('PIDX' => $pidx),
		);
		$row = $this->basic_model->arr_get_row($arr);

		$arr_fld_nm = array();
		$arr_fld_chk = array();
		$arr_fld_type = array();
		$arr_fld_desc = array();

		// 랜딩 페이지 파일 정보
		$arr_file_ttl = array();
		$arr_file_desc = array();

		if(isset($row->idx)) {
			$arr_fld_nm = array($row->fld_nm_1,$row->fld_nm_2,$row->fld_nm_3,$row->fld_nm_4,$row->fld_nm_5,$row->fld_nm_6,$row->fld_nm_7,$row->fld_nm_8,$row->fld_nm_9,$row->fld_nm_10);
			$arr_fld_chk = array($row->fld_chk_1,$row->fld_chk_2,$row->fld_chk_3,$row->fld_chk_4,$row->fld_chk_5,$row->fld_chk_6,$row->fld_chk_7,$row->fld_chk_8,$row->fld_chk_9,$row->fld_chk_10);
			$arr_fld_type = array($row->fld_type_1,$row->fld_type_2,$row->fld_type_3,$row->fld_type_4,$row->fld_type_5,$row->fld_type_6,$row->fld_type_7,$row->fld_type_8,$row->fld_type_9,$row->fld_type_10);
			$arr_fld_desc = array($row->fld_desc_1,$row->fld_desc_2,$row->fld_desc_3,$row->fld_desc_4,$row->fld_desc_5,$row->fld_desc_6,$row->fld_desc_7,$row->fld_desc_8,$row->fld_desc_9,$row->fld_desc_10);

			$arr_file_ttl = array($row->file_ttl_1,$row->file_ttl_2,$row->file_ttl_3,$row->file_ttl_4,$row->file_ttl_5);
			$arr_file_desc = array($row->file_desc_1,$row->file_desc_2,$row->file_desc_3,$row->file_desc_4,$row->file_desc_5);

		}

		// 필수 CSS 로드
		load_css('<link rel="stylesheet" type="text/css" href="'. LIB_DIR .'/editor/redactor/redactor.css?v=1" media="screen"/>');
		$data = array(
			'code' => $code,
			'row' => $row,

			'arr_fld_nm' => $arr_fld_nm,
			'arr_fld_chk' => $arr_fld_chk,
			'arr_fld_type' => $arr_fld_type,
			'arr_fld_desc' => $arr_fld_desc,

			'arr_file_ttl' => $arr_file_ttl,
			'arr_file_desc' => $arr_file_desc,

			'page_ttl' => $page_uri,
			'arr_seg' => $this->arr_seg,
			'viewPage' => 'landing/landing_npo_view'
		);

		$this->load->view('layout_npo_view', $data);
	}


	/**
	 * Send email message of given type (activate, forgot_password, etc.)
	 *
	 * @param	string
	 * @param	string
	 * @param	array
	 * @return	void
	 * _send_email('npo', 'jinakim@remann.co.kr,jin@remann.co.kr,riddleme@naver.com',&$data)
	 */
	function _landing_send_email($type, $email, &$data)
	{

		// $type => npo, comp
		// [npo]  NPO 협약신청
		// [comp] 기업 제휴 신청

		$subject = '신청 접수 내용';

		if('npo' == $type) :
			$subject = 'NPO 협약 신청';
		elseif('comp' == $type) :
			$subject = '기업 제휴 신청';
		elseif('campaign' == $type) :
			$subject = '캠페인 개설 협약 신청';
		endif;

		$this->load->library('email');
		$this->email->from($this->config->item('webmaster_email', 'tank_auth'), $this->config->item('website_name', 'tank_auth'));
		$this->email->reply_to($this->config->item('webmaster_email', 'tank_auth'), $this->config->item('website_name', 'tank_auth'));
		$this->email->to($email);
		$this->email->subject($subject);
		$this->email->message($this->load->view('email/landing_'.$type.'-html', $data, TRUE));
		$this->email->set_alt_message($this->load->view('email/landing_'.$type.'-txt', $data, TRUE));
		$this->email->send();
	}





}

/* End of file page.php */
/* Location: ./application/controllers/page.php */