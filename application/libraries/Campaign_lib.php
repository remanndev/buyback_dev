<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Campaign
 */
class Campaign_lib
{
	private $error = array();

	function __construct()
	{
		$this->ci =& get_instance();

		// $this->ci->load->config('tank_auth', TRUE); // autoload
		$this->ci->load->database();
		$this->ci->load->library('session');
		$this->ci->load->library('tank_auth');
		$this->ci->load->model('tank_auth/users');
		$this->ci->load->model('campaign_model');
		$this->ci->load->model('upload_model');
	}




	// 캠페인 런칭 처리
	function _launch($cidx=FALSE) {

		if($this->ci->campaign_model->_launch($cidx)) {
			return TRUE;
		}
		return FALSE;
	}

	
	// 캠페인 제출 처리
	function _submit($cidx=FALSE) {

		if($this->ci->campaign_model->_submit($cidx)) {
			return TRUE;
		}
		return FALSE;
	}

	// 캠페인 제출 상태로 리셋(런칭 -> 제출 상태로 변경)
	function _reset_submit($cidx=FALSE) {

		if($this->ci->campaign_model->_reset_submit($cidx)) {
			return TRUE;
		}
		return FALSE;
	}


	// 캠페인 작성 상태로 리셋(제출 -> 작성 상태로 변경)
	function _reset_write($cidx=FALSE) {

		if($this->ci->campaign_model->_reset_write($cidx)) {
			return TRUE;
		}
		return FALSE;
	}





	// 캠페인 삭제
	function _del($cidx=FALSE) {

		if($this->ci->campaign_model->_del($cidx)) {
			// 파일 삭제
			return $this->ci->upload_model->delete_file_manager(FALSE,'campaign',$cidx);
		}
		return FALSE;
	}


	// 캠페인 삭제, 최고 관리자는 모두 삭제 가능하도록..
	function _adm_del($cidx=FALSE) {

		// 최고 관리자는 모두 삭제 가능하도록..
		if( $this->ci->tank_auth->is_admin() ) {
			if($this->ci->campaign_model->_del($cidx)) {
				// 파일 삭제
				return $this->ci->upload_model->delete_file_manager(FALSE,'campaign',$cidx);
			}
			return FALSE;
		}
		return FALSE;
	}



	// 캠페인 기부내역 삭제, 최고 관리자는 모두 삭제 가능하도록..
	function _donor_del($cmp_code=FALSE,$donate_idx=FALSE) {
		// 최고 관리자는 모두 삭제 가능하도록..
		if( $this->ci->tank_auth->is_admin() ) {
			return $this->ci->campaign_model->_donor_del($cmp_code,$donate_idx);
		}
		return FALSE;
	}


	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	// 캠페인 기부 취소, 최고 관리자는 모두 취소 가능하도록..
	// [취소이지만 삭제처리 업데이트]
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	function _donor_cancel($cmp_code=FALSE,$donate_idx=FALSE) {
		// 최고 관리자는 모두 취소 가능하도록..
		if( $this->ci->tank_auth->is_admin() ) {
			return $this->ci->campaign_model->_donor_cancel($cmp_code,$donate_idx);
		}
		return FALSE;
	}


	// [작성자] 캠페인 기부내역 삭제
	function _donation_del_writer($cmp_code=FALSE,$donate_idx=FALSE,$user_idx=FALSE) {
		// 본인의 기부내역만 삭제 가능하도록 user_idx 전달
		return $this->ci->campaign_model->_donation_del_writer($cmp_code,$donate_idx,$user_idx);
	}




	// 캠페인 작성히기(수정하기)
	function write($cidx=FALSE)
	{

		// 저장 데이터
		$data = array();

		// 로그인 회원 정보
		$user_idx = $this->ci->tank_auth->get_user_id();

		// 일반회원과 관리자 구분
		$user_table = ($user_idx < 1000) ? 'users_admin' : 'users';

		// 작성자 정보
		$uacc = $this->ci->basic_model->get_common_row('row','username,nickname',$user_table,FALSE,FALSE,FALSE,array('id'=>$user_idx));
		$uacc_name = 'guest';
		if(isset($uacc->username)) {
			$uacc_name = $uacc->nickname;
			$uacc_id = $uacc->username;
		}
		/*
		$data['writer_idx'] = $user_idx;
		$data['writer_name'] = $uacc_name;
		*/


		$campaign_cate = $this->ci->input->post('campaign_cate');
		$campaign_title = $this->ci->input->post('campaign_title');
		$campaign_content = $this->ci->input->post('campaign_content');
		$data['cmp_cate'] = $campaign_cate;
		$data['cmp_title'] = $campaign_title;
		$data['cmp_content'] = $campaign_content;
		
		
		$goal_money = $this->ci->input->post('goal_money');
		$goal_desc = $this->ci->input->post('goal_desc');
		$term_begin = $this->ci->input->post('term_begin');
		$term_end = $this->ci->input->post('term_end');

		$data['cmp_goal_money'] = str_replace(',','',trim($goal_money));
		$data['cmp_goal_desc'] = $goal_desc;
		$data['cmp_term_begin'] = $term_begin;
		$data['cmp_term_end'] = $term_end;

		$org_name = $this->ci->input->post('org_name');
		$cmp_org_info = $this->ci->input->post('cmp_org_info');
		$org_link = $this->ci->input->post('org_link');
		$data['cmp_org_name'] = $org_name;
		$data['cmp_org_info'] = $cmp_org_info;
		$data['cmp_org_link'] = $org_link;

		$cmp_website = $this->ci->input->post('cmp_website');
		$data['cmp_website'] = $cmp_website;

		// [초기화] goal_device, goal_amt
		for($i=1;$i<6;$i++) {
			$data['goal_device_'.$i] = NULL;
			$data['goal_amt_'.$i] = NULL;
		}
		// [] goal_device, goal_amt
		$goal_device = $this->ci->input->post('goal_device');
		$goal_amt = $this->ci->input->post('goal_amt');
		foreach($goal_device as $key => $device) {
			if('' != $device) {
				$no = $key + 1;
				$data['goal_device_'.$no] = $device;
			}
		}
		foreach($goal_amt as $key => $amt) {
			if('' != $amt) {
				$no = $key + 1;
				$data['goal_amt_'.$no] = $amt;
			}
		}


		// 캠페인 단락 제목 및 내용
		$ctnt_ttl_1 = $this->ci->input->post('ctnt_ttl_1');
		$data['ctnt_ttl_1'] = $ctnt_ttl_1;
		$ctnt_detail_1 = $this->ci->input->post('ctnt_detail_1');
		$data['ctnt_detail_1'] = $ctnt_detail_1;

		$ctnt_ttl_2 = $this->ci->input->post('ctnt_ttl_2');
		$data['ctnt_ttl_2'] = $ctnt_ttl_2;
		$ctnt_detail_2 = $this->ci->input->post('ctnt_detail_2');
		$data['ctnt_detail_2'] = $ctnt_detail_2;

		$ctnt_ttl_3 = $this->ci->input->post('ctnt_ttl_3');
		$data['ctnt_ttl_3'] = $ctnt_ttl_3;
		$ctnt_detail_3 = $this->ci->input->post('ctnt_detail_3');
		$data['ctnt_detail_3'] = $ctnt_detail_3;



		// 신규
		if( ! $cidx )
		{
			$data['reg_datetime'] = TIME_YMDHIS;
			$data['reg_ip'] = REMOTE_ADDR;

			// 캠페인 고유 코드 생성
			$chk_code = FALSE;
			while($chk_code == FALSE) {
				$cmp_code = randstrupper(6);
				$chk_code = $this->is_cmp_code($cmp_code);
				if( ! $chk_code) :
					break;
				endif;
			}
			$data['code'] = $cmp_code;

			// 신규는 일반 회원이나 관리자나 마찬가지
			$data['writer_idx'] = $user_idx;
			$data['writer_name'] = $uacc_name;

		}
		else {
			// 기존 캠페인 중 고유 코드가 없는 경우만..
			// 캠페인 정보
			$arr_where = array(
					'sql_select'     => '*',
					'sql_from'       => 'campaign',
					'sql_where'      => array('idx'=>$cidx)
			);
			$row = $this->ci->basic_model->arr_get_row($arr_where);
			if( isset($row->idx) && (NULL == $row->code || '' == $row->code)) {
				// 캠페인 고유 코드 생성
				$chk_code = FALSE;
				while($chk_code == FALSE) {
					$cmp_code = randstrupper(6);
					$chk_code = $this->is_cmp_code($cmp_code);
					if( ! $chk_code) :
						break;
					endif;
				}
				$data['code'] = $cmp_code;
			}


			// 수정은 작성자 정보 변경 금지
			/*
			$data['writer_idx'] = $user_idx;
			$data['writer_name'] = $uacc_name;
			*/


		}

		// 새글이나 답변글 작성 또는 수정
		if (!is_null($res = $this->ci->campaign_model->write($cidx,$data))) {
			$inserted_idx = $res['idx'];

			return $res;
		}

		return NULL;

	}


    /** --------------------------------------------------------------------------------------------------------------
     | 존재하는 캠페인 코드인지 체크
     | ----------------------------------------------------------------------------------------------------------------
     */
	function is_cmp_code($cmp_code=FALSE) {
		$this->ci->db->where('code',$cmp_code);
		$this->ci->db->where('del_datetime', NULL); // 삭제된 캠페인 제외
		$total = $this->ci->db->count_all_results('campaign');
        if( $total > 0 ) :
            return TRUE; // 이미 존재함.
        else :
            return FALSE; // 없음.
		endif;
    }








	// 캠페인 응원댓글 코멘트
	function cmt_write($mode='write',$cmp_idx=FALSE,$cmt_idx=FALSE,$cmt_content=FALSE)
	{

		if(! $this->ci->tank_auth->is_logged_in() ) {
			return 'not_logged_in';
			exit;
		}

		// 로그인 회원 정보
		//$user = $this->ci->tank_auth->get_userinfo($this->ci->tank_auth->get_username());
		$user_idx = $this->ci->tank_auth->get_user_id();
		$username = $this->ci->tank_auth->get_username();
		$nickname = $this->ci->tank_auth->get_nickname();

		if( $mode === 'write' )
		{
			$data = array(
				'cmp_idx'    => $cmp_idx,
				'user_idx'    => $user_idx,
				'user_id'    => $username,
				'user_name'    => $nickname,
				'content'    => $cmt_content,
				'reg_datetime'  => TIME_YMDHIS,
				'reg_ip'    => $this->ci->input->ip_address()
			);
		}
		elseif( $mode === 'update' )
		{
			// 자기 글 정보
			$data = array(
				'content'    => $cmt_content
			);
		}
		elseif( $mode === 'reply' )
		{
			// 부모 글 정보
			$sql_from = 'campaign_comment';
			$sql_where = array('cmp_idx'=>$cmp_idx,'parent_idx'=>$cmt_idx);
			$order_no = $this->ci->basic_model->get_common_count($sql_from, $sql_where);
			//return $this->ci->db->last_query();
			$depth = 2;

			$data = array(
				'cmp_idx'    => $cmp_idx,
				'user_idx'    => $user_idx,
				'user_id'    => $username,
				'user_name'    => $nickname,

				'content'    => $cmt_content,
				'parent_idx'    => $cmt_idx,
				'depth'    => $depth,
				'order'    => $order_no,
				'reg_datetime'  => TIME_YMDHIS,
				'reg_ip'    => $this->ci->input->ip_address()
			);
		}

		// 새글이나 답변글 작성 또는 수정
		if (!is_null($res = $this->ci->campaign_model->cmt_write($mode,$cmp_idx,$cmt_idx,$data))) {
			return $res;
		}

	}


	// 코멘트 삭제하기
	function cmt_del($cmt_idx=FALSE)
	{

		if(! $this->ci->tank_auth->is_logged_in() ) {
			return 'not_logged_in';
			exit;
		}

		// 로그인 회원 정보
		$user_idx = $this->ci->tank_auth->get_user_id();

		// 자기 글 정보
		//$cmt_idx = $this->ci->input->post('cmt_idx');


		// 답글이 달린 댓글인지 체크
		// $res = 'exist_reply';
		$sql_from = 'campaign_comment';
		$sql_where = array('parent_idx'=>$cmt_idx, 'depth'=>2);
		$chk_reply = $this->ci->basic_model->get_common_count($sql_from, $sql_where);


		// 로그인 회원 본인의 코멘트인지 확인
		$sql_from = 'campaign_comment';
		$sql_where = array('idx'=>$cmt_idx, 'user_idx'=>$user_idx);
		$chk_owner = $this->ci->basic_model->get_common_count($sql_from, $sql_where);

		if($chk_reply) {
			$res = 'exist_reply';
		}
		else if(! $chk_owner) {
			$res = 'not_owner';
		}
		else {
			$res = $this->ci->campaign_model->cmt_del($cmt_idx);
		}



		// 최고 관리자는 모두 삭제 가능하도록..
		if( $res != 'exist_reply' && $this->ci->tank_auth->is_admin() ) {
			$res = $this->ci->campaign_model->cmt_del($cmt_idx);
		}


		return $res;
	}







	// 캠페인 모금소식 
	function news_write($mode='write',$cmp_idx=FALSE,$cmpnews_idx=FALSE,$cmpnews_content=FALSE,$cmp_code=FALSE)
	{

		if(! $this->ci->tank_auth->is_logged_in() ) {
			return 'not_logged_in';
			exit;
		}

		// 로그인 회원 정보
		//$user = $this->ci->tank_auth->get_userinfo($this->ci->tank_auth->get_username());
		$user_idx = $this->ci->tank_auth->get_user_id();
		$username = $this->ci->tank_auth->get_username();
		$nickname = $this->ci->tank_auth->get_nickname();

		if( $mode === 'write' )
		{
			$data = array(
				'cmp_idx'    => $cmp_idx,
				'cmp_code'    => $cmp_code,
				'user_idx'    => $user_idx,
				'user_id'    => $username,
				'user_name'    => $nickname,
				'content'    => $cmpnews_content,
				'reg_datetime'  => TIME_YMDHIS,
				'reg_ip'    => $this->ci->input->ip_address()
			);
		}
		elseif( $mode === 'update' )
		{
			// 자기 글 정보
			$data = array(
				'content'    => $cmpnews_content
			);
		}

		// 새글이나 수정
		if (!is_null($res = $this->ci->campaign_model->cmpnews_write($mode,$cmp_idx,$cmpnews_idx,$data))) {
			return $res;
		}

	}


	// 캠페인 모금소식  삭제하기
	function news_del($cmpnews_idx=FALSE)
	{

		if(! $this->ci->tank_auth->is_logged_in() ) {
			return 'not_logged_in';
			exit;
		}

		// 로그인 회원 정보
		$user_idx = $this->ci->tank_auth->get_user_id();

		// 자기 글 정보
		//$cmpnews_idx = $this->ci->input->post('cmpnews_idx');

		// 로그인 회원 본인의 작성글인지 확인
		$sql_from = 'campaign_news';
		$sql_where = array('idx'=>$cmpnews_idx, 'user_idx'=>$user_idx);
		$chk_owner = $this->ci->basic_model->get_common_count($sql_from, $sql_where);

		if(! $chk_owner) {
			$res = 'not_owner';
		}
		else {
			$res = $this->ci->campaign_model->cmpnews_del($cmpnews_idx);
		}



		// 최고 관리자는 모두 삭제 가능하도록..
		if( $res != 'exist_reply' && $this->ci->tank_auth->is_admin() ) {
			$res = $this->ci->campaign_model->cmpnews_del($cmpnews_idx);
		}


		return $res;
	}






	// 기부물품 등록
	function write_donation($code=FALSE) {

		/*
		Array ( 
			[chk_agree_1] => on 
			[donor_type] => B 
			[name_org] => 마스터컴퍼니 
			[manager_dept] => 담당자부서 
			[manager_title] => 담당자 직함 
			[name] => 마스터 
			[phone_1] => 010 
			[phone_2] => 1111 
			[phone_3] => 2222 
			[postcode] => 13536 
			[addr] => 경기 성남시 분당구 판교역로 4 (백현동) 
			[addr_detail] => 4321 
			[email_1] => jobs.heo 
			[email_2] => gmail.com 
			[email_comp] => gmail.com 
			[chk_agree_3] => on 
			[goods_kind] => 스마트패드 
			[goods_amt] => 30 
			[goods_grade] => A 
			[opt_request] => data_reset 
			//[pickup_date] => 2021-04-19 
			[pickup_date_plz] => 2021-04-19 
		)
		*/

		// 로그인 회원 정보
		$user_idx = $this->ci->tank_auth->get_user_id();
		$user_username = $this->ci->tank_auth->get_username(); // 회원 아이디

		$cmp_idx = $this->ci->input->post('cmp_idx');
		$cmp_code = $this->ci->input->post('cmp_code');

		$donor_type = $this->ci->input->post('donor_type');
		$donor_type_text = ('B' == $donor_type) ? $donor_type.':사업자' : $donor_type.':개인';
		$name_org = $this->ci->input->post('name_org');
		$name = $this->ci->input->post('name');


		$manager_dept = $this->ci->input->post('manager_dept');   // 담당자부서
		$manager_title = $this->ci->input->post('manager_title'); // 담당자 직함 

		$phone_1 = $this->ci->input->post('phone_1');
		$phone_2 = $this->ci->input->post('phone_2');
		$phone_3 = $this->ci->input->post('phone_3');
		$cellphone = $phone_1 .'-'. $phone_2 .'-'. $phone_3;
		$donor_phone = $phone_1 . $phone_2 . $phone_3;

		$postcode = $this->ci->input->post('postcode');
		$addr = $this->ci->input->post('addr');
		$addr_detail = $this->ci->input->post('addr_detail');

		/*
		$email_1 = $this->ci->input->post('email_1');
		$email_2 = $this->ci->input->post('email_2');
		$email_comp = $this->ci->input->post('email_comp');
		$email = $email_1 .'@'. $email_2;
		*/
		$email = $this->ci->input->post('email');

		$goods_kind = $this->ci->input->post('goods_kind');
		$goods_amt = $this->ci->input->post('goods_amt');
		$goods_grade = $this->ci->input->post('goods_grade');

		$goods_memo = $this->ci->input->post('goods_memo');

		$opt_request = $this->ci->input->post('opt_request');
		$pickup_date_plz = $this->ci->input->post('pickup_date_plz');

		// 저장 데이터
		$data = array();
		$data_goods = array();
		
		$data['user_idx'] = $user_idx;
		$data['user_username'] = $user_username; // 회원 아이디

		$data['cmp_idx'] = $cmp_idx;
		$data['cmp_code'] = $cmp_code;
		$data['donor_type'] = $donor_type_text;
		$data['company'] = $name_org;
		$data['donor_name'] = $name;

		$data['manager_dept'] = $manager_dept;
		$data['manager_title'] = $manager_title;

		$data['goods_memo'] = $goods_memo;

		$data['cellphone'] = $cellphone;
		$data['donor_phone'] = $donor_phone;
		$data['email'] = $email;
		$data['postcode'] = $postcode;
		$data['addr'] = $addr;
		$data['addr_detail'] = $addr_detail;
		$data['opt_request'] = $opt_request;
		$data['pickup_date_plz'] = $pickup_date_plz;
		$data['reg_datetime'] = TIME_YMDHIS;
		$data['reg_ip'] = REMOTE_ADDR;

		//$data_goods['goods_kind'] = $goods_kind;
		//$data_goods['goods_amt'] = $goods_amt;
		//$data_goods['goods_grade'] = $goods_grade;

		// 새글이나 답변글 작성 또는 수정
		if (!is_null($res = $this->ci->campaign_model->write_donation($data))) {
			$inserted_idx = $res['idx'];

			// 기부 물품 정보 저장
			if(is_array($goods_kind)) {
				foreach($goods_kind as $i => $good) {
					$data_goods = array('user_idx'=>$user_idx ,'dn_idx'=>$inserted_idx, 'gd_type'=>$goods_kind[$i], 'gd_amt'=>$goods_amt[$i], 'gd_grade'=>$goods_grade[$i], 'reg_datetime'=>TIME_YMDHIS, 'reg_ip'=>REMOTE_ADDR);
					$this->ci->campaign_model->write_donation_goods($data_goods);
				}
			}
			return $res;
		}

		return NULL;
	}


	// 기부물품 등록
	/*
	function write_donation_goods($dn_idx) {
	}
	*/



	// 기부 물품 최종 처리 완료 처리 > 알림톡 발송
	function trans_alimtalk_dn_complete() {

			$donor_name = $this->ci->input->post('donor_name');
			$donor_phone = $this->ci->input->post('donor_phone');
			$cmp_title = $this->ci->input->post('cmp_title');
			$dn_idx = $this->ci->input->post('dn_idx');

			// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
			// [성공] alim_msg_6788
			// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
			/*
			$alim_msg_6788 = "안녕하세요~ {$donor_name}님,\\n"
						 . "디지털현물기부플랫폼 리플러스입니다.\\n"
						 . "\\n"
						 . "리플러스박스와 함께 하는 안심 기기회수 캠페인에 참여해 주셔서 감사합니다.\\n"
						 . "나눔하신 디지털 기기의 처리 과정은 리플러스 내 마이페이지를 통해 확인해주세요. \\n"
						 . "\\n"
						 . "기기 내 데이터는 안전하게 삭제되며, 삭제 완료 후 발급되는 데이터 삭제 보고서는 마이페이지에 순차적으로 업로드 될 예정입니다.\\n"
						 . "\\n"
						 . "또한, 본 캠페인의 최종 기부 전달 결과는 11월 30일 캠페인 종료 이후 안내드릴 예정입니다. 진심 어린 참여에 다시 한번 깊이 감사드립니다.\\n";
			 */

			// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
			// [성공] alim_msg_UC_3929
			// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
			/*
			$alim_msg_UC_3929 = "안녕하세요~ {$donor_name}님,\\n"
						 . "디지털현물기부플랫폼 리플러스입니다! \\n"
						 . "\\n"
						 . "리플러스박스와 함께 하는 안심 기기회수 캠페인에 참여해 주셔서 감사합니다.\\n"
						 . "\\n"
						 . "{$donor_name}님께서 나눔해주신 모든 기기의 데이터 삭제가 안전하게 완료되었습니다. \\n"
						 . "데이터 삭제 리포트는 리플러스 마이페이지에서 확인하실 수 있습니다.\\n"
						 . "\\n"
						 . "본 캠페인의 최종 기부 전달 결과는 11월 30일 캠페인 종료 이후 안내드릴 예정입니다. \\n"
						 . "함께 해 주신 {$donor_name}님에게 다시 한번 진심으로 감사드립니다!\\n";
			*/

			// [2025-12-31] 변경예정
			// [2026-01-05] 모든 캠페인에 적용
			$alim_msg_UE_2598 = "안녕하세요~ {$donor_name}님,\\n"
						 . "디지털현물기부플랫폼 리플러스입니다! \\n"
						 . "\\n"
						 . "{$cmp_title} 캠페인에 참여해 주셔서 감사합니다. {$donor_name}님께서 나눔해주신 모든 기기의 데이터 삭제가 안전하게 완료되었습니다! \\n"
						 . "\\n"
						 . "▶데이터 삭제 리포트 확인하기 \\n"
						 . "[마이페이지 - 나의기부물품 현황- 캠페인 명 클릭 - 하단 데이터삭제리포트 버튼 클릭] \\n"
						 . "\\n"
						 . "▶ 기부금 영수증 발급\\n"
						 . "기부금영수증 발급은 캠페인 종료 후 해당 캠페인을 개설한 단체에서 별도의 안내를 진행할 예정입니다. \\n"
						 . "\\n"
						 . "함께 해 주신 {$donor_name}님에게 다시 한번 진심으로 감사드립니다!\\n";




			$_apiURL    =	'https://kakaoapi.aligo.in/akv10/alimtalk/send/';
			$_hostInfo  =	parse_url($_apiURL);
			$_port      =	(strtolower($_hostInfo['scheme']) == 'https') ? 443 : 80;
			$_variables =	array(
				'apikey'      => 'psuzi3jafauix0qipbr6n2tvl98bbzaq', 
				'userid'      => 'remann', 
				'senderkey'   => '0af469b73d77f82798cfdeedebf0d91fe8a27353', 
				'tpl_code'    => 'UE_2598', //'UC_3929',
				'sender'      => '070-4652-5192',
				'senddate'    => date("YmdHis", strtotime("+10 minutes")),
				'receiver_1'  => $donor_phone,
				'recvname_1'  => $donor_name,
				'subject_1'   => '리플러스 전체 (2) - 데이터삭제 완료 및 감사 인사', // '리플러스 박스 (2) - 데이터삭제 완료 및 감사인사',
				'message_1'   => $alim_msg_UE_2598,
				'button_1'    => '{"button":[{"name":"채널 추가","linkType":"AC"}, {"name":"리플러스 홈페이지","linkType":"WL","linkTypeName":"웹링크","linkM":"https://replus.kr/","linkP":"https://replus.kr/"}, {"name":"데이터삭제리포트 확인하기","linkType":"WL","linkTypeName":"웹링크","linkM":"https://replus.kr/mypage/","linkP":"https://replus.kr/mypage/"}]}'
			);
			
			$output_aligo = $this->curl_aligo($_port,$_apiURL,$_variables);

			// JSON 문자열 배열 변환
			$retArr = json_decode($output_aligo);

			// 결과값 출력
			//print_r($retArr);
			//exit;

			/*

				$retArr->code => [0] 이면 알림톡 발송 성공
				$retArr->message => 알림톡 발송 메시지

			*/

			if('0' == $retArr->code) {
				return 'succ'; // 알림톡 발송 성공
			}
			else {
				return 'fail'; // 알림톡 발송 실패
			}


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


	// [2025-08-22]
	// 수거날짜, 검수날짜 업데이트
	// $this->campaign_lib->dn_update_date($dn_row->idx, $whDate,$pickup_date);
	function dn_update_date($idx=false,$date=false,$fld=false) {
		
		$data = array();
		if('pickup_date' == $fld) {
			// 수거
			$data=array('pickup_date'=>$date,'state_pickup'=>1);
		}
		elseif('check_date' == $fld) {
			// 검수
			$data=array('check_date'=>$date,'state_check'=>1);
		}

		$res = false;
		if(! empty($data)) {
			$res = $this->ci->campaign_model->dn_update_date($idx, $data);
		}

		return $res;
	}


	// 기부 정보 업데이트
	function dn_updates($idx=false,$data=array()) {
		
		$res = false;
		if(! empty($data)) {
			$res = $this->ci->campaign_model->dn_update_date($idx, $data);
		}

		return $res;
	}
	

	// [2025-09-03] 
	// 택배 물류 추적 코드 및 상태 업데이트
	// $this->campaign_lib->dn_update_tracking($dn_row->idx, $tracking_code,'code');
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	function dn_update_tracking($idx=false,$tracking_data=false,$fld=false) {
		
		$data = array();
		if('rcpt_DV' == $fld) {
			// 1차(택배접수), 2차(반품)
			$data=array('cj_tracking_dv_code'=>$tracking_data);
		}
		elseif('code' == $fld) {
			// 추적 상태 코드
			$data=array('cj_tracking_code'=>$tracking_data);
		}
		elseif('state' == $fld) {
			// 추적 상태명
			$data=array('cj_tracking_state'=>$tracking_data);
		}
		elseif('tracking_json' == $fld) {
			// 추적 상태명
			$data=array('tracking_json'=>$tracking_data,'tracking_json_dt'=>TIME_YMDHIS);
		}

		$res = false;
		if(! empty($data)) {
			$res = $this->ci->campaign_model->dn_update_tracking($idx, $data);
		}

		return $res;
	}



	function trans_dn_update() {

			//$tbl = $this->ci->input->post('tbl');
			$fld = $this->ci->input->post('fld');
			$idx = $this->ci->input->post('idx');
			$val = $this->ci->input->post('val');

			$data = array($fld => $val);
			$res = $this->ci->campaign_model->trans_dn_update($idx, $data);

			return $res;
	}

	function trans_dngood_update() {

			//$tbl = $this->ci->input->post('tbl');
			$fld = $this->ci->input->post('fld');
			$idx = $this->ci->input->post('idx');
			$val = $this->ci->input->post('val');

			$data = array($fld => $val);
			$res = $this->ci->campaign_model->trans_dngood_update($idx, $data);

			return $res;
	}


	function trans_dn_reportchk_del() {

			$idx = $this->ci->input->post('idx');

			$data = array('idx' => $idx);
			$res = $this->ci->campaign_model->trans_dn_reportchk_del($idx);

			return $res;
	}


	function trans_dn_reportList_del() {

			$idx = $this->ci->input->post('idx');

			$data = array('idx' => $idx);
			$res = $this->ci->campaign_model->trans_dn_reportList_del($idx);

			return $res;
	}





	function donated_device() {

		$device_idx = $this->ci->input->post('device_idx');
		$device_name = $this->ci->input->post('device_name');
		$device_amount = $this->ci->input->post('device_amount');
		$device_display = $this->ci->input->post('device_display');
		$device_order = $this->ci->input->post('device_order');

		foreach($device_idx as $i => $idx) {
			$data = array(
				'device_name'=>$device_name[$i],
				'device_amount'=>$device_amount[$i],
				'device_display'=>$device_display[$i],
				'device_order'=>$device_order[$i]
			);
			$res = $this->ci->campaign_model->donated_device_update($idx,$data);
		}

	}



	function donated_amount() {

		$amt_idx = $this->ci->input->post('amt_idx');
		$amt_title = $this->ci->input->post('amt_title');
		$amt_value = $this->ci->input->post('amt_value');
		$amt_display = $this->ci->input->post('amt_display');
		$amt_order = $this->ci->input->post('amt_order');

		foreach($amt_idx as $i => $idx) {
			$data = array(
				'amt_title'=>$amt_title[$i],
				'amt_value'=>$amt_value[$i],
				'amt_display'=>$amt_display[$i],
				'amt_order'=>$amt_order[$i]
			);
			$res = $this->ci->campaign_model->donated_amount_update($idx,$data);
		}

	}




	function donated_archive() {

		// 로그인 회원 정보
		$user_idx = $this->ci->tank_auth->get_user_id();
		$reg_datetime = date('Y-m-d H:i:s');

		$idx = $this->ci->input->post('idx');
		$date_ym = $this->ci->input->post('date_ym');
		$cnt_device = $this->ci->input->post('cnt_device');
		$cnt_amt = $this->ci->input->post('cnt_amt');
		$std_date = $this->ci->input->post('std_date');

		$cnt_device = (float)str_replace(',','',$cnt_device);
		$cnt_amt = (float)str_replace(',','',$cnt_amt);

		$arr_date = explode('-',$date_ym);
		$date_y = isset($arr_date[0]) ? $arr_date[0] : '';
		$date_m = isset($arr_date[1]) ? $arr_date[1] : '';


		$data = array(
			'date_ym' => $date_ym,
			'date_y' => $date_y,
			'date_m' => $date_m,
			'cnt_device' => $cnt_device,
			'cnt_amt' => $cnt_amt,
			'std_date' => $std_date,

			'uidx' => $user_idx,
			'reg_date' => $reg_datetime
		);

		$res = $this->ci->campaign_model->donated_archive($idx,$data);

		return $res;
	}






	function sharecampaign_request($wr_idx=FALSE) {

		// 저장 데이터
		$data = array();

		// 로그인 회원 정보
		$user_idx = $this->ci->tank_auth->get_user_id();
		// 일반회원과 관리자 구분
		$user_table = ($user_idx < 1000) ? 'users_admin' : 'users';
		// 작성자 정보
		$uacc = $this->ci->basic_model->get_common_row('row','username,nickname',$user_table,FALSE,FALSE,FALSE,array('id'=>$user_idx));
		$uacc_name = 'guest';
		if(isset($uacc->username)) {
			$uacc_name = $uacc->nickname;
			$uacc_id = $uacc->username;
		}
		// 나눔캠페인 인덱스 번호
		//$scmp_idx = $this->ci->input->post('scmp_idx');
		$scmp_idx = $wr_idx ? $wr_idx : $this->ci->input->post('scmp_idx');

		$data['scmp_idx'] = $scmp_idx;
		$data['user_idx'] = $user_idx;


		// 신청자 정보
		$req_subject = $this->ci->input->post('req_subject'); // 신청제목
		$req_gubun = $this->ci->input->post('gubun'); // 신청자 구분
		$req_name = $this->ci->input->post('req_name'); // 신청자명
		$req_name_org = $this->ci->input->post('req_name_org', '');  // 상호/법인명
		$req_postcode = $this->ci->input->post('req_postcode'); // 주소(우편번호)
		$req_addr = $this->ci->input->post('req_addr'); // 주소
		$req_addr_detail = $this->ci->input->post('req_addr_detail'); // 상세주소
		$req_birthday = $this->ci->input->post('req_birthday'); // 생년월일
		$req_phone = $this->ci->input->post('req_phone'); // 휴대전화
		$req_reason = $this->ci->input->post('req_reason'); // 신청사유

		$data['req_subject'] = $req_subject;
		$data['req_gubun'] = $req_gubun;
		$data['req_name'] = $req_name;
		$data['req_name_org'] = $req_name_org;
		$data['req_postcode'] = $req_postcode;
		$data['req_addr'] = $req_addr;
		$data['req_addr_detail'] = $req_addr_detail;
		$data['req_birthday'] = $req_birthday;
		$data['req_phone'] = $req_phone;
		$data['req_reason'] = $req_reason;
		
		// 수혜자 정보
		$bnf_gubun = $this->ci->input->post('gubun_bnf'); // 수혜자 구분
		$bnf_name = $this->ci->input->post('bnf_name'); // 수혜자명
		$bnf_count = $this->ci->input->post('bnf_count'); // 수혜대상 수
		$bnf_postcode = $this->ci->input->post('bnf_postcode'); // 주소(우편번호)
		$bnf_addr = $this->ci->input->post('bnf_addr'); // 주소
		$bnf_addr_detail = $this->ci->input->post('bnf_addr_detail'); // 상세주소
		$bnf_phone = $this->ci->input->post('bnf_phone'); // 휴대전화
		$bnf_devices= $this->ci->input->post('bnf_devices'); // 희망 기기 및 수량
		$bnf_content = $this->ci->input->post('bnf_content'); // 수혜대상 소개 및 기기 활용목적

		$data['bnf_gubun'] = $bnf_gubun;
		$data['bnf_name'] = $bnf_name;
		$data['bnf_count'] = $bnf_count;
		$data['bnf_postcode'] = $bnf_postcode;
		$data['bnf_addr'] = $bnf_addr;
		$data['bnf_addr_detail'] = $bnf_addr_detail;
		$data['bnf_phone'] = $bnf_phone;
		$data['bnf_devices'] = $bnf_devices;
		$data['bnf_content'] = $bnf_content;



		$data['req_datetime'] = TIME_YMDHIS;
		$data['req_ip'] = REMOTE_ADDR;

		// 새글이나 답변글 작성 또는 수정
		if (!is_null($res = $this->ci->campaign_model->sharecampaign_request($data))) {
			$inserted_idx = $res['idx'];

			return $res;
		}

		return NULL;




	}


	// 캠페인 작성히기(수정하기)
	function ___write($cidx=FALSE)
	{

		// 저장 데이터
		$data = array();

		// 로그인 회원 정보
		$user_idx = $this->ci->tank_auth->get_user_id();

		// 일반회원과 관리자 구분
		$user_table = ($user_idx < 1000) ? 'users_admin' : 'users';

		// 작성자 정보
		$uacc = $this->ci->basic_model->get_common_row('row','username,nickname',$user_table,FALSE,FALSE,FALSE,array('id'=>$user_idx));
		$uacc_name = 'guest';
		if(isset($uacc->username)) {
			$uacc_name = $uacc->nickname;
			$uacc_id = $uacc->username;
		}
		/*
		$data['writer_idx'] = $user_idx;
		$data['writer_name'] = $uacc_name;
		*/


		$campaign_cate = $this->ci->input->post('campaign_cate');
		$campaign_title = $this->ci->input->post('campaign_title');
		$campaign_content = $this->ci->input->post('campaign_content');
		$data['cmp_cate'] = $campaign_cate;
		$data['cmp_title'] = $campaign_title;
		$data['cmp_content'] = $campaign_content;
		
		
		$goal_money = $this->ci->input->post('goal_money');
		$goal_desc = $this->ci->input->post('goal_desc');
		$term_begin = $this->ci->input->post('term_begin');
		$term_end = $this->ci->input->post('term_end');

		$data['cmp_goal_money'] = str_replace(',','',trim($goal_money));
		$data['cmp_goal_desc'] = $goal_desc;
		$data['cmp_term_begin'] = $term_begin;
		$data['cmp_term_end'] = $term_end;

		$org_name = $this->ci->input->post('org_name');
		$org_info = $this->ci->input->post('org_info');
		$data['cmp_org_name'] = $org_name;
		$data['cmp_org_info'] = $org_info;


		// [초기화] goal_device, goal_amt
		for($i=1;$i<6;$i++) {
			$data['goal_device_'.$i] = NULL;
			$data['goal_amt_'.$i] = NULL;
		}
		// [] goal_device, goal_amt
		$goal_device = $this->ci->input->post('goal_device');
		$goal_amt = $this->ci->input->post('goal_amt');
		foreach($goal_device as $key => $device) {
			if('' != $device) {
				$no = $key + 1;
				$data['goal_device_'.$no] = $device;
			}
		}
		foreach($goal_amt as $key => $amt) {
			if('' != $amt) {
				$no = $key + 1;
				$data['goal_amt_'.$no] = $amt;
			}
		}


		// 신규
		if( ! $cidx )
		{
			$data['reg_datetime'] = TIME_YMDHIS;
			$data['reg_ip'] = REMOTE_ADDR;

			// 캠페인 고유 코드 생성
			$chk_code = FALSE;
			while($chk_code == FALSE) {
				$cmp_code = randstrupper(6);
				$chk_code = $this->is_cmp_code($cmp_code);
				if( ! $chk_code) :
					break;
				endif;
			}
			$data['code'] = $cmp_code;

			// 신규는 일반 회원이나 관리자나 마찬가지
			$data['writer_idx'] = $user_idx;
			$data['writer_name'] = $uacc_name;

		}
		else {
			// 기존 캠페인 중 고유 코드가 없는 경우만..
			// 캠페인 정보
			$arr_where = array(
					'sql_select'     => '*',
					'sql_from'       => 'campaign',
					'sql_where'      => array('idx'=>$cidx)
			);
			$row = $this->ci->basic_model->arr_get_row($arr_where);
			if( isset($row->idx) && (NULL == $row->code || '' == $row->code)) {
				// 캠페인 고유 코드 생성
				$chk_code = FALSE;
				while($chk_code == FALSE) {
					$cmp_code = randstrupper(6);
					$chk_code = $this->is_cmp_code($cmp_code);
					if( ! $chk_code) :
						break;
					endif;
				}
				$data['code'] = $cmp_code;
			}


			// 수정은 작성자 정보 변경 금지
			/*
			$data['writer_idx'] = $user_idx;
			$data['writer_name'] = $uacc_name;
			*/


		}

		// 새글이나 답변글 작성 또는 수정
		if (!is_null($res = $this->ci->campaign_model->write($cidx,$data))) {
			$inserted_idx = $res['idx'];

			return $res;
		}

		return NULL;

	}







	// 기부물품 상세 검수 현황
	function donate_report_check($cmp_code=FALSE,$donate_idx=FALSE,$user_idx=FALSE) {

		// 저장 데이터
		$data = array();

		$chk_kind = $this->ci->input->post('chk_kind');
		$chk_maker = $this->ci->input->post('chk_maker');
		$chk_model = $this->ci->input->post('chk_model');
		$chk_spec = $this->ci->input->post('chk_spec');
		$chk_grade = $this->ci->input->post('chk_grade');
		$idx = $this->ci->input->post('idx');

		foreach($idx as $i => $idxno) {

			//$data = array();

			if( trim($chk_kind[$i]) == '' && 
				trim($chk_maker[$i]) == '' && 
				trim($chk_model[$i]) == '' && 
				trim($chk_spec[$i]) == '' && 
				trim($chk_grade[$i]) == '') {
				continue;
			}

			$data = array(
				'chk_kind'=>$chk_kind[$i],
				'chk_maker'=>$chk_maker[$i],
				'chk_model'=>$chk_model[$i],
				'chk_spec'=>$chk_spec[$i],
				'chk_grade'=>$chk_grade[$i]
			);

			if('' != $idxno) {
				// update
				$proc = 'update';
				//$data['idx'] = $idxno;
			}
			else {
				// insert
				$proc = 'insert';
				//$data['idx'] = '';

				$data['cmp_code'] = $cmp_code;
				$data['donate_idx'] = $donate_idx;
				$data['user_idx'] = $user_idx;

				$data['reg_datetime'] = TIME_YMDHIS;
				$data['reg_ip'] = REMOTE_ADDR;
				
				// 로그인 회원 정보
				if( $this->ci->tank_auth->is_admin() ) {
					$adm_idx = $this->ci->tank_auth->get_user_id();
					$data['reg_adm_idx'] = $adm_idx;
				}

			}

			$res = $this->ci->campaign_model->donate_report_check($idxno,$proc,$data);
		}

		return TRUE;
	}






	// [1. 목록] 기부물품 데이터 완전 삭제 현황
	function dn_report_del_save_list() 
	{


			// redirect(base_url().'admin/campaign/donate/report_del/'.$cmp_code.'/'.$donate_idx.'?tab=list');






		$this->ci->load->library('form_validation');
		$this->ci->form_validation->set_rules('idx[]', 'idx', 'trim|xss_clean');

		if ($this->ci->form_validation->run())
		{
			/*
			if (!is_null($data = $this->ci->campaign_lib->donate_report_check($cmp_code,$donate_idx,$user_idx))) {		// success
				sess_message('저장되었습니다.');
				redirect(current_url());
			}
			*/


			
			$cmp_idx = $this->ci->input->post('cmp_idx');
			$cmp_code = $this->ci->input->post('cmp_code');
			$donate_idx = $this->ci->input->post('donate_idx');
			$user_idx = $this->ci->input->post('user_idx');


			// 저장 데이터
			$data = array();

			$hdd_type = $this->ci->input->post('hdd_type');
			$hdd_idno = $this->ci->input->post('hdd_idno');
			$hdd_capacity = $this->ci->input->post('hdd_capacity');
			$del_method = $this->ci->input->post('del_method');
			$del_cso = $this->ci->input->post('del_cso');
			$del_date = $this->ci->input->post('del_date');
			$idx = $this->ci->input->post('idx');

			foreach($idx as $i => $idxno) {

				//$data = array();

				if( trim($hdd_type[$i]) == '' && 
					trim($hdd_idno[$i]) == '' && 
					trim($hdd_capacity[$i]) == '' && 
					trim($del_methoddel_method[$i]) == '' && 
					trim($del_cso[$i]) == '' && 
					trim($del_date[$i]) == '') {
					continue;
				}

				$data = array(
					'hdd_type'=>$hdd_type[$i],
					'hdd_idno'=>$hdd_idno[$i],
					'hdd_capacity'=>$hdd_capacity[$i],
					'del_method'=>$del_method[$i],
					'del_cso'=>$del_cso[$i],
					'del_date'=>$del_date[$i],
				);


				if('' != $idxno) {
					// update
					$proc = 'update';
					//$data['idx'] = $idxno;
				}
				else {
					// insert
					$proc = 'insert';
					//$data['idx'] = '';

					$data['cmp_code'] = $cmp_code;
					$data['donate_idx'] = $donate_idx;
					$data['user_idx'] = $user_idx;

					$data['reg_datetime'] = TIME_YMDHIS;
					
					// 로그인 회원 정보
					if( $this->ci->tank_auth->is_admin() ) {
						$adm_idx = $this->ci->tank_auth->get_user_id();
						$data['reg_adm_idx'] = $adm_idx;

						$admin_row = $this->ci->tank_auth->get_admininfo_idx($adm_idx);
						$admin_username = $admin_row->username;
						$data['reg_username'] = $admin_username;
					}

				}

				//$res = $this->ci->campaign_model->donate_report_check($idxno,$proc,$data);
				$res = $this->ci->campaign_model->donate_report_delete_save_list($idxno,$proc,$data);

			}


		}



	}




	// [2. 사진] 기부물품 데이터 완전 삭제 현황
	//function donate_report_del() 
	function dn_report_del_save_photo() 
	{

		// # 에러 메시지 CSS
		$this->ci->form_validation->set_error_delimiters('<div class="err_color_red">','</div>');

		//this->ci->load->library('form_validation');

		// Set validation rules.
		$validation_rules = array(
			//array('field' => 'use_yn', 'label' => '사용 여부', 'rules' => 'trim|required'),
			//array('field' => 'del_content', 'label' => '내용', 'rules' => 'trim|required') // 내용 필수
			array('field' => 'del_content', 'label' => '내용', 'rules' => 'trim') // 빈 내용이어도 저장되도록 수정
		);
		
		$this->ci->form_validation->set_rules($validation_rules);

		// Run the validation.
		if ($this->ci->form_validation->run())
		{


			// Get user id from session to use in the insert function as a primary key.
			//$user_idx = $this->ci->tank_auth->get_user_id();
			$admin_username = $this->ci->tank_auth->get_username();

			// 신규 등록인지 수정인지 여부
			$idx = $this->ci->input->post('idx',true);

			// 캠페인 및 기부 정보
			$cmp_idx = $this->ci->input->post('cmp_idx',true);
			$cmp_code = $this->ci->input->post('cmp_code',true);
			$donate_idx = $this->ci->input->post('donate_idx',true);
			$user_idx = $this->ci->input->post('user_idx',true);

			if(! $idx) :

					$data = array(
						'cmp_idx' => $this->ci->input->post('cmp_idx'),
						'cmp_code' => $this->ci->input->post('cmp_code'),
						'donate_idx' => $this->ci->input->post('donate_idx'),
						'user_idx' => $this->ci->input->post('user_idx'),
						//'use_yn' => $this->ci->input->post('use_yn'),
						'del_content' => $this->ci->input->post('del_content'),
						'reg_username' => $admin_username,
						'reg_datetime' => TIME_YMDHIS
					);

					if (!is_null($res = $this->ci->campaign_model->write_dn_del_report_photo($data))) {
						return $res;

						//sess_message('게시판 정보가 수정되었습니다.');
						//redirect(base_url().'admin/contents/page/form/'.$res['idx']);
					}
					return NULL;

			else :

					$data = array(
						//'use_yn' => $this->ci->input->post('use_yn'),
						'del_content' => $this->ci->input->post('del_content'),
						'edit_username' => $admin_username,
						'edit_datetime' => TIME_YMDHIS
					);

					if (!is_null($res = $this->ci->campaign_model->edit_dn_del_report_photo($idx,$data))) {
						return $res;

						//redirect(base_url().'admin/contents/page/form/'.$idx);
					}
					return NULL;
			endif;
					
			// redirect(base_url().'admin/campaign/donate/report_del/'.$cmp_code.'/'.$donate_idx.'?tab=photo');
		}
		else
		{		
			// Set validation errors.
			$this->ci->data['message'] = validation_errors('<p class="error_msg">', '</p>');
			
			return FALSE;
		}

	}


	// [3. 증명] 기부물품 데이터 완전 삭제 현황
	// 기부물품 영수증 확인
	// 기부물품 데이터 완전 삭제 현황
	//function donate_report_del() 
	function dn_report_del_save_cert() 
	{

		// # 에러 메시지 CSS
		$this->ci->form_validation->set_error_delimiters('<div class="err_color_red">','</div>');

		//this->ci->load->library('form_validation');

		// Set validation rules.
		$validation_rules = array(
			//array('field' => 'use_yn', 'label' => '사용 여부', 'rules' => 'trim|required'),
			//array('field' => 'del_content', 'label' => '내용', 'rules' => 'trim|required')
			array('field' => 'admin_username', 'label' => '관리자', 'rules' => 'trim|required')
		);
		
		$this->ci->form_validation->set_rules($validation_rules);

		// Run the validation.
		if ($this->ci->form_validation->run())
		{


			// Get user id from session to use in the insert function as a primary key.
			//$user_idx = $this->ci->tank_auth->get_user_id();
			//$admin_username = $this->ci->tank_auth->get_username();
			$admin_username = $this->ci->input->post('admin_username',$this->ci->tank_auth->get_username());

			// 신규 등록인지 수정인지 여부 $row_cert->idx
			$idx = trim($this->ci->input->post('idx',true));

			// 캠페인 및 기부 정보
			$cmp_idx = $this->ci->input->post('cmp_idx',true);
			$cmp_code = $this->ci->input->post('cmp_code',true);
			$donate_idx = $this->ci->input->post('donate_idx',true);
			$user_idx = $this->ci->input->post('user_idx',true);

			if(! $idx OR $idx == '') :

					$data = array(
						'cmp_idx' => $this->ci->input->post('cmp_idx'),
						'cmp_code' => $this->ci->input->post('cmp_code'),
						'donate_idx' => $this->ci->input->post('donate_idx'),
						'user_idx' => $this->ci->input->post('user_idx'),
						//'use_yn' => $this->ci->input->post('use_yn'),
						//'del_content' => $this->ci->input->post('del_content'),
						'reg_username' => $admin_username,
						'reg_datetime' => TIME_YMDHIS
					);


					if (!is_null($res = $this->ci->campaign_model->write_dn_del_report_cert($data))) {
						return $res;

						//sess_message('게시판 정보가 수정되었습니다.');
						//redirect(base_url().'admin/contents/page/form/'.$res['idx']);
					}
					return NULL;

			else :

					$data = array(
						//'use_yn' => $this->ci->input->post('use_yn'),
						//'del_content' => $this->ci->input->post('del_content'),
						'edit_username' => $admin_username,
						'edit_datetime' => TIME_YMDHIS
					);

					if (!is_null($res = $this->ci->campaign_model->edit_dn_del_report_cert($idx,$data))) {
						return $res;

						//redirect(base_url().'admin/contents/page/form/'.$idx);
					}
					return NULL;
			endif;
					
			//redirect(base_url().'admin/campaign/donate/report_del/'.$cmp_code.'/'.$donate_idx.'?tab=cert');
		}
		else
		{		
			// Set validation errors.
			$this->ci->data['message'] = validation_errors('<p class="error_msg">', '</p>');
			
			return FALSE;
		}

	}

}