<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Landing extends CI_Controller {

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


		/*
		$this->load->library('tank_auth');
		//$this->load->library('cms_lib');
		$this->load->library('landing_lib');
		$this->load->library('form_validation');
		$this->load->library('upload_lib');
		$this->load->helper(array('form', 'load'));
		*/


		$this->load->helper(array('form', 'load'));
		$this->load->library('form_validation');
		$this->load->library('tank_auth');
		$this->load->library('upload_lib');
		$this->load->library('landing_lib');
		$this->load->model('upload_model');
		$this->lang->load('tank_auth');

		$this->arr_seg = $this->uri->segment_array();


		if (! $this->tank_auth->is_logged_in()) {  // not logged in or not activated
			//redirect('/auth/login/'. url_code($this->uri->uri_string(), 'e'));
			redirect('/auth/login/'. url_code(base_url($this->uri->uri_string()), 'e'));
		}
	}

	/*
	다운로드 링크
	/files/download/< # ?php echo url_code('page/file','e') ? # >/< # ?php echo url_code('한국지능정보사회진흥원(NIA) × 리플러스 비영리단체 · 지역아동센터 PC 지원 사업 공고문.pdf','e') ? # >
	
	*/

	function _remap($code=FALSE,$arr=FALSE)
	{

		if(! $code):
			alert('잘못된 경로로 접속하셨습니다.','/');
		endif;

		if('index' == $code) {
			redirect(base_url().'landing/comp');
		}
		else if('npo' == $code) {
			//redirect(base_url().'landing_npo/');
		}
		else if('NIA' == $code) {
			//redirect(base_url().'landing_npo/');
		}

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
			//array_push($validation_rules, array('field' => 'agree', 'label' => '개인정보 수집 및 이용 동의', 'rules' => 'trim|required'));

			// 파일 업로드 체크
			/*
			foreach($arr_file_ttl as $i => $file_ttl) {
				$no = $i + 1;
				// if(trim($arr_file_ttl[$i]) == '' && $row->file_cnt < $no) {
				if($row->file_cnt < $no) {
					continue;
				}
				$validation_rules[] = array('field' => 'attach_file_'.$no, 'label' => $file_ttl, 'rules' => 'required');
			}
			*/

			
			//$validation_rules[] = array('field' => 'attach_file[]', 'label' => '파일 첨부', 'rules' => 'required');



			/*
			if('comp' == $submit_code) {
				$validation_rules = array(
					array('field' => 'submit_code', 'label' => '신청문의 코드', 'rules' => 'trim|required'),

					array('field' => 'fld_1', 'label' => '회사(기관)명', 'rules' => 'trim|required'),
					array('field' => 'fld_2', 'label' => '소속부서명', 'rules' => 'trim'),
					array('field' => 'fld_3', 'label' => '담당자명', 'rules' => 'trim|required'),
					array('field' => 'fld_4', 'label' => '연락처', 'rules' => 'trim|required'),
					array('field' => 'fld_5', 'label' => '이메일', 'rules' => 'trim'),
					array('field' => 'txtfld_1', 'label' => '불용 물품 종류/수량', 'rules' => 'trim'),
					array('field' => 'txtfld_2', 'label' => '기타 문의 사항 등', 'rules' => 'trim'),
					array('field' => 'agree', 'label' => '개인정보 수집 및 이용 동의', 'rules' => 'trim|required'),
				);
			}
			elseif('npo' == $submit_code) {
				$validation_rules = array(
					array('field' => 'submit_code', 'label' => '신청문의 코드', 'rules' => 'trim|required'),

					array('field' => 'fld_1', 'label' => '기관명', 'rules' => 'trim|required'),
					array('field' => 'fld_2', 'label' => '담당자명', 'rules' => 'trim|required'),
					array('field' => 'fld_3', 'label' => '연락처', 'rules' => 'trim|required'),
					array('field' => 'fld_4', 'label' => '이메일', 'rules' => 'trim'),
					array('field' => 'fld_5', 'label' => '홈페이지', 'rules' => 'trim'),
					array('field' => 'txtfld_1', 'label' => '기관소개', 'rules' => 'trim'),
					array('field' => 'txtfld_2', 'label' => '개설 예정 캠페인 소개', 'rules' => 'trim'),
					array('field' => 'txtfld_3', 'label' => '기부금 사용 계획', 'rules' => 'trim'),
					array('field' => 'agree', 'label' => '개인정보 수집 및 이용 동의', 'rules' => 'trim|required'),
				);
			}
			*/
			
			$this->form_validation->set_rules($validation_rules);


			

			// [2024-01-30] NPO 협약신청 폼에서만 파일 업로드 필수 체크
			//if('npo' == $code) {

			// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
			// [2024-10-24] 파일 업로드 체크 필수 
			// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
			$arr_chk_file = array('npo','2024campaigner');

			if(in_array($code, $arr_chk_file)) {

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


			$succ = false;

			// Run the validation.
			//if ($this->form_validation->run() !== FALSE) {
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

							
							// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
							// [2024-10-24] 완료 메시지 재정의
							// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
							// $arr_chk_file = array('npo','2024campaigner');

							if('2024campaigner' == $code) {
								$succ_msg = '리플러스 캠페이너 지원사업 접수가 완료되었습니다. \n운영팀에서 검토 후 연락드리겠습니다. \n감사합니다.';
							}

					}
					else {
						$succ_msg = '정상적인 경로로 접수해주세요.';
					}

					$succ_redirect = base_url().'landing/'.$submit_code;
					alert($succ_msg, $succ_redirect);
				}
			}
			else {

				alert_stay('신청서 내용을 모두 작성해주세요.');

			}

		}
		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -




		$page_code = (isset($arr_seg[0]) && $arr_seg[0] != '') ? $arr_seg[0] : false;
		$page_uri = (isset($arr_seg[1]) && $arr_seg[1] != '') ? $arr_seg[1] : '';

		//echo '/landing/'.$idx.'/'.$page_code.'/'.$page_uri;

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

		if(! isset($row->code) ) {
			alert('잘못된 경로로 접속하셨습니다.','/');
		}

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

		/*
		//$view_page = 'landing/landing_'.$code.'_view';
		//$view_page = 'landing/landing_page_view';
		//$layout_page = 'layout_view';
		if('npo' == $code) {
			//$view_page = 'landing/landing_page_npo_view';
			//$layout_page = 'layout_npo_view';
		}
		*/


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
			'viewPage' => 'landing/landing_page_view'
		);

		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		// [2024-05-30] 김명진 과장님 요청
		// 개인정보 수집 및 이용안내 내용을 비워두면 
		// => 동의 체크박스 주석 처리, 필요 없음
		// => 신청확인 버튼 주석 처리, 필요 없음.
		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		if('NIA' == $code) {
			$data['viewPage'] = 'landing/landing_page_nonsubmit_view';
		}

		$this->load->view('layout_view', $data);
	}







	/*

	function _remap($idx=FALSE,$arr=FALSE)
	{

		if(! $idx):
			alert('잘못된 경로로 접속하셨습니다.','/');
		endif;

		$page_code = (isset($arr[0]) && $arr[0] != '') ? $arr[0] : false;
		$page_uri = (isset($arr[1]) && $arr[1] != '') ? $arr[1] : '';

		//echo '/landing/'.$idx.'/'.$page_code.'/'.$page_uri;

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

	*/





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