<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Landing_rsv extends CI_Controller {
	function __construct() {
		parent::__construct();



		$this->load->helper(array('form', 'url','load'));
		$this->load->helper('security');

		$this->load->library('form_validation');
		$this->load->library('tank_auth');
		$this->load->library('board_lib');
		$this->load->library('upload_lib');
		$this->load->library('landing_lib');
		$this->load->model('tank_auth/users');
		$this->lang->load('tank_auth');

		$this->load->library('simple_html_dom');

	}



	// 팬딩페이지 - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

	function write() {

		//$use_recaptcha			= $this->config->item('use_recaptcha', 'tank_auth');

		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		// 글쓰기 저장시..
		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		//if( $this->input->post('submit') ) {


		$type        = $this->input->post('type');



		// # 에러 메시지 CSS
		$this->form_validation->set_error_delimiters('<div class="error">','</div>');

		$this->form_validation->set_rules('name', '이름', 'trim|required|xss_clean');
		$this->form_validation->set_rules('phone', '휴대전화', 'trim|required|xss_clean');
		if('sb0_1' == $type) {
			$this->form_validation->set_rules('postcode', '우편번호', 'trim|required|xss_clean');
			$this->form_validation->set_rules('addr', '주소', 'trim|required|xss_clean');
			$this->form_validation->set_rules('addr_detail', '상세주소', 'trim|required|xss_clean');
		} elseif('rsv_1' == $type) {
			$this->form_validation->set_rules('rsv_date', '예약 날짜', 'trim|required|xss_clean');
			$this->form_validation->set_rules('rsv_time', '예약 시간', 'trim|required|xss_clean');
			$this->form_validation->set_rules('rsv_part', '예약 파트', 'trim|required|xss_clean');
		} else {
			$this->form_validation->set_rules('rdate', '날짜', 'trim|required|xss_clean');
			$this->form_validation->set_rules('rtime', '시간', 'trim|required|xss_clean');
		}

		
		/*
		if ($use_recaptcha) {
			$this->form_validation->set_rules('recaptcha_response_field', '자동등록방지코드', 'trim|xss_clean|required|callback__check_recaptcha');
		} else {
			$this->form_validation->set_rules('captcha', '자동등록방지코드', 'trim|xss_clean|required|callback__check_captcha');
		}
		*/

		//}



		$return_url        = $this->input->post('return_url');
		//$return_url = base_url().'page/sb0_1';


		if ($this->form_validation->run() !== FALSE) {

			$res_idx = $this->landing_lib->write();

			$landing_ttl = ('rsv_1' == $type) ? '방문예약' : '관심등록';

			if($res_idx) {
				alert($landing_ttl.'이 완료되었습니다.\n감사합니다.',$return_url);
			}
			else {
				alert('등록이 되지 않았습니다.\n관리자에 문의해주세요.',$return_url);
			}

		}
		else {
			//history_back();
			alert('이름, 휴대전화 등의 정보를 모두 입력해주세요.');
		}

	}







	function rsv_write() {

		//$use_recaptcha			= $this->config->item('use_recaptcha', 'tank_auth');

		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		// 글쓰기 저장시..
		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		//if( $this->input->post('submit') ) {

		$type        = $this->input->post('type');

		// # 에러 메시지 CSS
		$this->form_validation->set_error_delimiters('<div class="error">','</div>');

		$this->form_validation->set_rules('name', '이름', 'trim|required|xss_clean');
		$this->form_validation->set_rules('phone', '휴대전화', 'trim|required|xss_clean|min_length[10]|max_length[11]');
		if('sb0_1' == $type) {
			$this->form_validation->set_rules('postcode', '우편번호', 'trim|required|xss_clean');
			$this->form_validation->set_rules('addr', '주소', 'trim|required|xss_clean');
			$this->form_validation->set_rules('addr_detail', '상세주소', 'trim|required|xss_clean');
		} elseif('rsv_1' == $type) {
			$this->form_validation->set_rules('rsv_date', '예약 날짜', 'trim|required|xss_clean');
			$this->form_validation->set_rules('rsv_time', '예약 시간', 'trim|required|xss_clean');
			$this->form_validation->set_rules('rsv_part', '예약 파트', 'trim|required|xss_clean');
		} else {
			$this->form_validation->set_rules('rdate', '날짜', 'trim|required|xss_clean');
			$this->form_validation->set_rules('rtime', '시간', 'trim|required|xss_clean');
		}

		//}

		$return_url        = $this->input->post('return_url');
		//$return_url = base_url().'page/sb0_1';


		if ($this->form_validation->run() !== FALSE) {

			$res_idx = $this->landing_lib->rsv_write();

			if($res_idx == 'reserve_limit') {
				alert('선택하신 시간대의 예약이 마감되었습니다.\n다른 시간대를 선택해주세요.',$return_url);
			}
			else if($res_idx == 'reserve_repeat') {

				/* 현재 예약 신청건..
				$rsv_date        = $this->input->post('rsv_date');
				$rsv_time        = $this->input->post('rsv_time');
				$rsv_part        = $this->input->post('rsv_part');

				$tstamp = strtotime($rsv_part) + 20*60;
				$time_end = date('H:i',$tstamp);
				$rsv_msg = '이미 신청하신 예약 시간입니다.';
				*/

				/* 기존 예약 신청 건 검색 */
				$phone        = $this->input->post('phone');
				$arr_where = array(
						'sql_select'     => '*',
						'sql_from'       => 'rsv',
						'sql_where'      => array('phone'=>$phone)
						//'sql_order_by' => 'idx desc',
						//'limit'      => 1
				);
				$row = $this->basic_model->arr_get_row($arr_where);

				$rsv_date        = $row->rsv_date;
				$rsv_part        = $row->rsv_part;
				$tstamp = strtotime($rsv_part) + 20*60;
				$time_end = date('H:i',$tstamp);


				$rsv_msg = '이미 방문예약을 신청하셨습니다.';
				//$rsv_msg .= '\n\n['.$rsv_date.' '.$rsv_part.'~'.$time_end.']';
				$rsv_msg .= '\n\n';
				$rsv_msg .= '예약날짜 : '.$rsv_date;
				$rsv_msg .= '\n';
				$rsv_msg .= '예약시간 : '.$rsv_part.'~'.$time_end;

				alert($rsv_msg,$return_url);
			}
			else {

				$landing_ttl = ('rsv_1' == $type) ? '방문예약' : '관심등록';

				if($res_idx) {
					alert($landing_ttl.'이 완료되었습니다.\n감사합니다.',$return_url);
				}
				else {
					alert('등록이 되지 않았습니다.\n관리자에 문의해주세요.',$return_url);
				}

			}
		}
		else {
			//history_back();
			alert('이름, 휴대전화 등의 정보를 모두 정확하게 입력해주세요.');
		}

	}





	function winner_rsv_write() {

		//$use_recaptcha			= $this->config->item('use_recaptcha', 'tank_auth');

		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		// 글쓰기 저장시..
		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		//if( $this->input->post('submit') ) {

		$type        = $this->input->post('type');

		// # 에러 메시지 CSS
		$this->form_validation->set_error_delimiters('<div class="error">','</div>');

		$this->form_validation->set_rules('name', '이름', 'trim|required|xss_clean');
		$this->form_validation->set_rules('phone', '휴대전화', 'trim|required|xss_clean|min_length[10]|max_length[11]');

		$this->form_validation->set_rules('rsv_date', '예약 날짜', 'trim|required|xss_clean');
		$this->form_validation->set_rules('rsv_time', '예약 시간', 'trim|required|xss_clean');
		$this->form_validation->set_rules('rsv_part', '예약 파트', 'trim|required|xss_clean');

		//}

		$return_url        = $this->input->post('return_url');
		//$return_url = base_url().'page/sb0_1';


		if ($this->form_validation->run() !== FALSE) {

			$res_idx = $this->landing_lib->winner_rsv_write();

			if($res_idx == 'reserve_limit') {
				alert('선택하신 시간대의 예약이 마감되었습니다.\n다른 시간대를 선택해주세요.',$return_url);
			}
			else if($res_idx == 'no_winner') {
				alert('당첨자가 아닙니다.',$return_url);
			}
			else if($res_idx == 'reserve_repeat') {

				/* 현재 예약 신청건..
				$rsv_date        = $this->input->post('rsv_date');
				$rsv_time        = $this->input->post('rsv_time');
				$rsv_part        = $this->input->post('rsv_part');

				$tstamp = strtotime($rsv_part) + 20*60;
				$time_end = date('H:i',$tstamp);
				$rsv_msg = '이미 신청하신 예약 시간입니다.';
				*/

				/* 기존 예약 신청 건 검색 */
				$phone        = $this->input->post('phone');
				$arr_where = array(
						'sql_select'     => '*',
						'sql_from'       => 'winner_rsv',
						'sql_where'      => array('phone'=>$phone)
						//'sql_order_by' => 'idx desc',
						//'limit'      => 1
				);
				$row = $this->basic_model->arr_get_row($arr_where);

				$rsv_date        = $row->rsv_date;
				$rsv_part        = $row->rsv_part;
				$tstamp = strtotime($rsv_part) + 60*60;
				$time_end = date('H:i',$tstamp);


				$rsv_msg = '이미 당첨자전용 방문예약을 신청하셨습니다.';
				//$rsv_msg .= '\n\n['.$rsv_date.' '.$rsv_part.'~'.$time_end.']';
				$rsv_msg .= '\n\n';
				$rsv_msg .= '예약날짜 : '.$rsv_date;
				$rsv_msg .= '\n';
				$rsv_msg .= '예약시간 : '.$rsv_part.'~'.$time_end;

				alert($rsv_msg,$return_url);
			}
			else {

				$landing_ttl = ('sb0_3' == $type) ? '당첨자전용예약' : '';

				if($res_idx) {
					alert($landing_ttl.'이 완료되었습니다.\n감사합니다.',$return_url);
				}
				else {
					alert('등록이 되지 않았습니다.\n관리자에 문의해주세요.',$return_url);
				}

			}
		}
		else {
			//history_back();
			alert('이름, 휴대전화 등의 정보를 모두 정확하게 입력해주세요.');
		}

	}



}

/* End of file Landing.php */
/* Location: ./application/controllers/Landing.php */