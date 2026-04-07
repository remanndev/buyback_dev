<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Sharecampaign extends CI_Controller
{
	function __construct()
	{
		parent::__construct();

		$this->load->helper(array('form', 'url','load'));
		$this->load->library('form_validation');
		$this->load->helper('security');
		$this->load->library('tank_auth');
		$this->lang->load('tank_auth');

		$this->load->library('campaign_lib');

		//$this->load->library('upload_lib');
		//$this->load->model('Upload_model');

		/*
		if (! $this->tank_auth->is_logged_in()) {
			redirect('/auth/login/'. url_code($this->uri->uri_string(), 'e'));
		}
		*/
		
		$this->user_idx = $this->tank_auth->get_user_id();
		$this->username = $this->tank_auth->get_username();
		$this->user = $this->tank_auth->get_userinfo($this->username);
		$this->arr_seg = $this->uri->segment_array();


		if( $this->tank_auth->is_admin() ) {
			$this->user = $this->tank_auth->get_admininfo_idx($this->user_idx);
		}


		load_js('<script src="'.JS_DIR.'/campaign_script.js?v='. time() .'"></script>');


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


		// 로그인 필요.
		//echo current_url();
		//exit;
		if( ! $this->tank_auth->is_logged_in()) {
			$redirect_url = base_url().'auth/login/'. url_code(current_url(), 'e');
			alert('로그인이 필요한 페이지입니다.',$redirect_url);
		}
	}

	function index()
	{
		redirect('/B/SHARECAMPAIGN/나눔신청');
	}



	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	// [2] 나눔캠페인 신청
	//     /campaign/sharecampaign/[$wr_idx]?page=[$page]
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

	function request($wr_idx=FALSE) {


		//if(! isset($this->user->level) OR $this->user->level < 20 ) {
		if(! isset($this->user->level) OR $this->user->level < 1 ) {
			alert('나눔 신청 권한이 없습니다.');
		}

		// 상단 탑배너 이미지 - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
			// pc
			$top_bnr_pc = $this->basic_model->get_banner_list('share_top_pc',10);
			// mobile
			$top_bnr_mobile = $this->basic_model->get_banner_list('share_top_mobile',10);



		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		// GET 정보 
		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		/*
			$this->load->library('querystring', NULL, 'param'); // 쿼리스트링 주소
			$param	  =& $this->param;

			// [page 번호, 중요하진 않음]
			$get_page = $param->get('page', false);
		*/




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

						// [예외 1.2]
						if(7 == $wr_idx) {


							$this->form_validation->set_rules('gubun', '신청자 구분', 'trim|required|xss_clean');
							$this->form_validation->set_rules('req_subject', '신청제목', 'trim|required|xss_clean');
							$this->form_validation->set_rules('req_name', '신청자명', 'trim|required|xss_clean');

							if( $this->input->post('gubun') == '단체' ) {
							  $this->form_validation->set_rules('req_name_org', '상호/법인명', 'trim|required|xss_clean');
							} else {
							  $this->form_validation->set_rules('req_name_org', '상호/법인명', 'trim|xss_clean');
							}

							$this->form_validation->set_rules('req_postcode', '주소(우편번호)', 'trim|required');
							$this->form_validation->set_rules('req_addr', '주소', 'trim|required');
							$this->form_validation->set_rules('req_addr_detail', '상세주소', 'trim|required');
							//$this->form_validation->set_rules('req_birthday', '생년월일', 'trim|required');
							$this->form_validation->set_rules('req_phone', '휴대전화', 'trim|required');
							$this->form_validation->set_rules('req_reason', '신청사유', 'trim|required|xss_clean');

							/*
							$this->form_validation->set_rules('gubun_bnf', '수혜자 구분', 'trim|required|xss_clean');
							$this->form_validation->set_rules('bnf_name', '수혜자명', 'trim|required|xss_clean');
							$this->form_validation->set_rules('bnf_count', '수혜대상 수', 'trim|required|xss_clean');
							$this->form_validation->set_rules('bnf_postcode', '주소(우편번호)', 'trim|required');
							$this->form_validation->set_rules('bnf_addr', '주소', 'trim|required');
							$this->form_validation->set_rules('bnf_addr_detail', '상세주소', 'trim|required');
							$this->form_validation->set_rules('bnf_phone', '휴대전화', 'trim|required');
							$this->form_validation->set_rules('bnf_devices', '희망 기기 및 수량', 'trim|required');
							$this->form_validation->set_rules('bnf_content', '수혜대상 소개 및 기기 활용목적', 'trim|required|xss_clean');
							*/
							$this->form_validation->set_rules('bnf_devices', '희망 기기 및 수량', 'trim|required');
							$this->form_validation->set_rules('bnf_content', '단체소개서, 활동보고서', 'trim|required|xss_clean');

						}
						else {

							$this->form_validation->set_rules('gubun', '신청자 구분', 'trim|required|xss_clean');
							$this->form_validation->set_rules('req_subject', '신청제목', 'trim|required|xss_clean');
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

						}

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

							//alert('나눔 신청이 완료되었습니다.',base_url().'B/SHARECAMPAIGN/나눔신청/detail/'.$wr_idx.'/page/'.$get_page);
							alert('나눔 신청이 완료되었습니다.',base_url().'B/SHARECAMPAIGN/나눔신청/detail/'.$wr_idx);

						} else {
							$errors = $this->tank_auth->get_error_message();
							foreach ($errors as $k => $v)	$data['errors'][$k] = $this->lang->line($v);
						}
					}
			}





		// 나눔캠페인 정보
			$arr = array('sql_select' => '*','sql_from' => 'bbs_sharecampaign','sql_where' => array('wr_idx'=>$wr_idx));
			$cmp_row = $this->basic_model->arr_get_row($arr);

			if( $cmp_row->addfld_2 < date('Y-m-d') ) {
				alert('나눔 캠페인 신청 기간이 종료되었습니다.');
				return false;
			}






		// load css, js  - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
			load_css('<link rel="stylesheet" href="'.LIB_DIR.'/slider/slick-1.8.1/slick/slick.css" />');
			load_js('<script src="'.LIB_DIR.'/slider/slick-1.8.1/slick/slick.min.js"></script>');

		// 페이지
			$viewPage = 'campaign/sharecampaign_view';

			// [예외 1.2]
			if(7 == $wr_idx) {
				// [2023-12-05] 2023 리플러스 IT 나눔 캠페인 │ 경기북부 소재 공익단체의 많은 신청 바랍니다!
				$viewPage = 'campaign/sharecampaign_'.$wr_idx.'_view';
			}

		// 데이터 - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
			$data = array(
				'arr_seg' => $this->arr_seg,

				'top_bnr_mobile' => $top_bnr_mobile,
				'top_bnr_pc' => $top_bnr_pc,

				'cmp_row' => $cmp_row,
				'wr_idx' => $wr_idx,
				//'page' => $get_page,

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


















}

/* End of file Campaign.php */
/* Location: ./application/controllers/Campaign.php */