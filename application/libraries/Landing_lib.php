<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Landing
 */
class Landing_lib
{
	private $error = array();

	function __construct()
	{
		$this->ci =& get_instance();

		// $this->ci->load->config('tank_auth', TRUE); // autoload
		$this->ci->load->database();
		$this->ci->load->library('session');
		$this->ci->load->model('tank_auth/users');
		$this->ci->load->model('landing_model');
		$this->ci->load->model('upload_model');
	}


	/*
	// 고객정보 입력
	function write($submit_code=FALSE)
	{

		// 로그인 회원 정보
		$user_idx = $this->ci->tank_auth->get_user_id();
		$data['user_idx'] = $user_idx;

		$fld_1 = $this->ci->input->post('fld_1');
		$fld_2 = $this->ci->input->post('fld_2');
		$fld_3 = $this->ci->input->post('fld_3');
		$fld_4 = $this->ci->input->post('fld_4');
		$fld_5 = $this->ci->input->post('fld_5');
		$fld_6 = $this->ci->input->post('fld_6');
		$fld_7 = $this->ci->input->post('fld_7');
		$fld_8 = $this->ci->input->post('fld_8');
		$fld_9 = $this->ci->input->post('fld_9');
		$fld_10 = $this->ci->input->post('fld_10');
		$txtfld_1 = $this->ci->input->post('txtfld_1');
		$txtfld_2 = $this->ci->input->post('txtfld_2');
		$txtfld_3 = $this->ci->input->post('txtfld_3');
		$txtfld_4 = $this->ci->input->post('txtfld_4');
		$txtfld_5 = $this->ci->input->post('txtfld_5');
		$agree = $this->ci->input->post('agree');

		$data['fld_1'] = $fld_1;
		$data['fld_2'] = $fld_2;
		$data['fld_3'] = $fld_3;
		$data['fld_4'] = $fld_4;
		$data['fld_5'] = $fld_5;
		$data['fld_6'] = $fld_6;
		$data['fld_7'] = $fld_7;
		$data['fld_8'] = $fld_8;
		$data['fld_9'] = $fld_9;
		$data['fld_10'] = $fld_10;
		$data['txtfld_1'] = $txtfld_1;
		$data['txtfld_2'] = $txtfld_2;
		$data['txtfld_3'] = $txtfld_3;
		$data['txtfld_4'] = $txtfld_4;
		$data['txtfld_5'] = $txtfld_5;
		$data['agree'] = $agree;
		
		$data['code'] = $this->ci->input->post('submit_code');
		$data['type'] = $this->ci->input->post('type');
		$data['ip'] = REMOTE_ADDR;
		$data['created'] = TIME_YMDHIS;

		// 새글이나 답변글 작성 또는 수정
		if (!is_null($res = $this->ci->landing_model->write($data))) {
			return $res;
		}
		else
			return NULL;

	}
	*/


	// 고객정보 입력
	function write($submit_code=FALSE)
	{

		/*
		$ip = REMOTE_ADDR;
		$minutes = 10;
		$threshold = 5;
		if (!is_null($res = $this->ci->landing_model->tooManyInWindow($ip, $minutes, $threshold))) {
			echo  "OK: ".$res;
			exit;
		}
		else {
			//return NULL;

			echo 'NULL';
			exit;
		}
		*/



		// 로그인 회원 정보
		$user_idx = $this->ci->tank_auth->get_user_id();
		$data['user_idx'] = $user_idx;

		/* 실사용 안함 */
		/*
		$fld_1 = $this->ci->input->post('fld_1');
		$fld_2 = $this->ci->input->post('fld_2');
		$fld_3 = $this->ci->input->post('fld_3');
		$fld_4 = $this->ci->input->post('fld_4');
		$fld_5 = $this->ci->input->post('fld_5');
		$fld_6 = $this->ci->input->post('fld_6');
		$fld_7 = $this->ci->input->post('fld_7');
		$fld_8 = $this->ci->input->post('fld_8');
		$fld_9 = $this->ci->input->post('fld_9');
		$fld_10 = $this->ci->input->post('fld_10');
		*/

		/* 실사용 필드 */
		$txtfld_1 = $this->ci->input->post('txtfld_1');
		$txtfld_2 = $this->ci->input->post('txtfld_2');
		$txtfld_3 = $this->ci->input->post('txtfld_3');
		$txtfld_4 = $this->ci->input->post('txtfld_4');
		$txtfld_5 = $this->ci->input->post('txtfld_5');
		$txtfld_6 = $this->ci->input->post('txtfld_6');
		$txtfld_7 = $this->ci->input->post('txtfld_7');
		$txtfld_8 = $this->ci->input->post('txtfld_8');
		$txtfld_9 = $this->ci->input->post('txtfld_9');
		$txtfld_10 = $this->ci->input->post('txtfld_10');

		$agree = $this->ci->input->post('agree');

		$file_cnt = $this->ci->input->post('file_cnt');

		/* 실사용 안함 */
		/*
		$data['fld_1'] = $fld_1;
		$data['fld_2'] = $fld_2;
		$data['fld_3'] = $fld_3;
		$data['fld_4'] = $fld_4;
		$data['fld_5'] = $fld_5;
		$data['fld_6'] = $fld_6;
		$data['fld_7'] = $fld_7;
		$data['fld_8'] = $fld_8;
		$data['fld_9'] = $fld_9;
		$data['fld_10'] = $fld_10;
		*/

		/* 실사용 필드 */
		$data['txtfld_1'] = $txtfld_1;
		$data['txtfld_2'] = $txtfld_2;
		$data['txtfld_3'] = $txtfld_3;
		$data['txtfld_4'] = $txtfld_4;
		$data['txtfld_5'] = $txtfld_5;
		$data['txtfld_6'] = $txtfld_6;
		$data['txtfld_7'] = $txtfld_7;
		$data['txtfld_8'] = $txtfld_8;
		$data['txtfld_9'] = $txtfld_9;
		$data['txtfld_10'] = $txtfld_10;

		$data['agree'] = $agree;
		$data['file_cnt'] = $file_cnt;
		
		$data['code'] = $this->ci->input->post('submit_code');
		$data['type'] = $this->ci->input->post('type');
		$data['ip'] = REMOTE_ADDR;
		$data['created'] = TIME_YMDHIS;

		// 새글이나 답변글 작성 또는 수정
		if (!is_null($res = $this->ci->landing_model->write($data))) {
			return $res;
		}
		else
			return NULL;

	}







	// 신청문의 삭제 처리(업데이트)
	function request_del($idx=FALSE) {
		// 새글이나 답변글 작성 또는 수정
		if (!is_null($res = $this->ci->landing_model->request_del($idx))) {
			return $res;
		}
		else {
			return NULL;
		}
	}


	// 랜딩페이지 개인정보수집동의 작성히기(수정하기)
	function agree_write($idx=FALSE)
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
		$data['admin_idx'] = $user_idx;
		$data['admin_name'] = $uacc_name;

		$agree_type = $this->ci->input->post('agree_type');
		$data['agree_type'] = $agree_type;

		$agree_content = $this->ci->input->post('agree_content');
		$data['agree_content'] = $agree_content;
		
		// 신규
		if( ! $idx )
		{
			$data['ip'] = REMOTE_ADDR;
			$data['datetime'] = TIME_YMDHIS;
		}

		// 새글이나 답변글 작성 또는 수정
		if (!is_null($res = $this->ci->landing_model->agree_write($idx,$data))) {
			//$inserted_idx = $res['idx'];

			return $res;
		}

		return NULL;

	}




















	// 예약
	function rsv_write()
	{

		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		// [3/3]
		$time_part = 1; // [고정] 00~20분, 20~40분, 40~ 00분
		$team_cnt = 8;  // [변동] 각 타임파트당 4팀, 또는 10팀
		$time_team_total = $time_part * $team_cnt;
		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

		// 로그인 회원 정보
		//$user_idx = $this->ci->tank_auth->get_user_id();
		//$data_rsv['user_idx'] = $user_idx;

		$type = $this->ci->input->post('type');
		$data_rsv['type'] = $type;

		$name = $this->ci->input->post('name');
		$data_rsv['name'] = $name;
		$phone = $this->ci->input->post('phone');
		$data_rsv['phone'] = $phone;

		$partner = $this->ci->input->post('partner');
		$data_rsv['partner'] = $partner;
		$vacc_chk = $this->ci->input->post('vacc_chk');
		$data_rsv['vacc_chk'] = $vacc_chk;

		$rsv_date = $this->ci->input->post('rsv_date');
		$data_rsv['rsv_date'] = $rsv_date;
		$rsv_time = $this->ci->input->post('rsv_time');
		$data_rsv['rsv_time'] = $rsv_time;
		$rsv_part = $this->ci->input->post('rsv_part');
		$data_rsv['rsv_part'] = $rsv_part;
		
		$data_rsv['ip'] = REMOTE_ADDR;
		$data_rsv['created'] = TIME_YMDHIS;


		// rsv_stats
		$rsv_date = $this->ci->input->post('rsv_date');
		$data_rsv_stats['rsv_date'] = $rsv_date;
		$rsv_time = $this->ci->input->post('rsv_time');
		$data_rsv_stats['rsv_time'] = $rsv_time;
		$rsv_part = $this->ci->input->post('rsv_part');
		$data_rsv_stats['rsv_part'] = $rsv_part;

		// 각 파트별 예약팀 수 체크
		//$rsv_part_num = 0;
		$rsv_part_num = $this->ci->basic_model->get_common_count('rsv', array('rsv_date'=>$rsv_date, 'rsv_time'=>$rsv_time, 'rsv_part'=>$rsv_part, 'deleted'=>NULL));
		$rsv_part_num++;
		$data_rsv_stats['rsv_part_num'] = $rsv_part_num;
		if( $rsv_part_num > $team_cnt ) {
			return 'reserve_limit';
		}


		// 각 파트별 동일한 전화번호 예약팀 체크
		/*
		$chk_phone_repeat = $this->ci->basic_model->get_common_count('rsv', array('rsv_date'=>$rsv_date, 'rsv_time'=>$rsv_time, 'rsv_part'=>$rsv_part, 'deleted'=>NULL, 'phone'=>$phone));
		if( $chk_phone_repeat > 0 ) {
			return 'reserve_repeat';
		}
		*/

		// 전체 내역에서 동일한 전화번호 예약팀 체크
		$chk_phone_repeat = $this->ci->basic_model->get_common_count('rsv', array('deleted'=>NULL, 'phone'=>$phone));
		if( $chk_phone_repeat > 0 ) {
			return 'reserve_repeat';
		}


		// 새글이나 답변글 작성 또는 수정
		if (!is_null($res = $this->ci->landing_model->rsv_write($data_rsv,$data_rsv_stats))) {
			//$inserted_idx = $res['idx'];

			return $res;
		}
		else
			return NULL;

	}


	// 당첨자전용 예약
	function winner_rsv_write()
	{

		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		// [3/3]
		$time_part = 1; // [고정] 00~20분, 20~40분, 40~ 00분
		$team_cnt = 100;  // [변동] 각 타임파트당 4팀, 또는 10팀
		$time_team_total = $time_part * $team_cnt;
		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

		// 로그인 회원 정보
		//$user_idx = $this->ci->tank_auth->get_user_id();
		//$data_rsv['user_idx'] = $user_idx;

		$type = $this->ci->input->post('type');
		$data_rsv['type'] = $type;

		$name = $this->ci->input->post('name');
		$data_rsv['name'] = $name;
		$phone = $this->ci->input->post('phone');
		$data_rsv['phone'] = $phone;

		$partner = $this->ci->input->post('partner');
		$data_rsv['partner'] = $partner;
		$vacc_chk = $this->ci->input->post('vacc_chk');
		$data_rsv['vacc_chk'] = $vacc_chk;

		$rsv_date = $this->ci->input->post('rsv_date');
		$data_rsv['rsv_date'] = $rsv_date;
		$rsv_time = $this->ci->input->post('rsv_time');
		$data_rsv['rsv_time'] = $rsv_time;
		$rsv_part = $this->ci->input->post('rsv_part');
		$data_rsv['rsv_part'] = $rsv_part;
		
		$data_rsv['ip'] = REMOTE_ADDR;
		$data_rsv['created'] = TIME_YMDHIS;


		// 당첨자 인지 아닌지 체크
		//$is_winner = $this->ci->basic_model->get_common_count('winner_list', array('phone'=>$phone, 'deleted'=>NULL));
		$is_winner = $this->ci->basic_model->get_common_count('winner_list', array('name'=>$name, 'phone'=>$phone, 'deleted'=>NULL));
		if( $is_winner < 1 ) {
			return 'no_winner';
		}

		// rsv_stats
		$rsv_date = $this->ci->input->post('rsv_date');
		$data_rsv_stats['rsv_date'] = $rsv_date;
		$rsv_time = $this->ci->input->post('rsv_time');
		$data_rsv_stats['rsv_time'] = $rsv_time;
		$rsv_part = $this->ci->input->post('rsv_part');
		$data_rsv_stats['rsv_part'] = $rsv_part;

		// 각 파트별 예약팀 수 체크
		//$rsv_part_num = 0;
		$rsv_part_num = $this->ci->basic_model->get_common_count('winner_rsv', array('rsv_date'=>$rsv_date, 'rsv_time'=>$rsv_time, 'rsv_part'=>$rsv_part, 'deleted'=>NULL));
		$rsv_part_num++;
		$data_rsv_stats['rsv_part_num'] = $rsv_part_num;
		if( $rsv_part_num > $team_cnt ) {
			return 'reserve_limit';
		}


		// 각 파트별 동일한 전화번호 예약팀 체크
		/*
		$chk_phone_repeat = $this->ci->basic_model->get_common_count('rsv', array('rsv_date'=>$rsv_date, 'rsv_time'=>$rsv_time, 'rsv_part'=>$rsv_part, 'deleted'=>NULL, 'phone'=>$phone));
		if( $chk_phone_repeat > 0 ) {
			return 'reserve_repeat';
		}
		*/

		// 전체 내역에서 동일한 전화번호 예약팀 체크
		$chk_phone_repeat = $this->ci->basic_model->get_common_count('winner_rsv', array('deleted'=>NULL, 'phone'=>$phone));
		if( $chk_phone_repeat > 0 ) {
			return 'reserve_repeat';
		}


		// 새글이나 답변글 작성 또는 수정
		if (!is_null($res = $this->ci->landing_model->winner_rsv_write($data_rsv,$data_rsv_stats))) {
			//$inserted_idx = $res['idx'];

			return $res;
		}
		else
			return NULL;

	}


	// 예약 내역 삭제 처리(업데이트)
	function reserve_del($idx=FALSE) {
		// 새글이나 답변글 작성 또는 수정
		if (!is_null($res = $this->ci->landing_model->reserve_del($idx))) {
			return $res;
		}
		else {
			return NULL;
		}
	}


	// 예약 내역 삭제 처리(업데이트)
	function reserve_del_winner($idx=FALSE) {
		// 새글이나 답변글 작성 또는 수정
		if (!is_null($res = $this->ci->landing_model->reserve_del_winner($idx))) {
			return $res;
		}
		else {
			return NULL;
		}
	}


	// 예약 내역 삭제 처리(업데이트)
	function winner_reserve_del($idx=FALSE) {
		// 새글이나 답변글 작성 또는 수정
		if (!is_null($res = $this->ci->landing_model->winner_reserve_del($idx))) {
			return $res;
		}
		else {
			return NULL;
		}
	}



	/**
	 * Delete user by admin
	 *
	 * @param	string
	 * @return	bool
	 */
	function delete_excel_winner_by_admin()
	{
		return $this->ci->landing_model->delete_excel_winner();
	}


	function excel_winner_by_admin($name='',$type='',$dong='',$ho='',$phone='',$area='') {

		$phone = str_replace('  ','',$phone);
		$phone = str_replace(' ','',$phone);
		$phone = trim(str_replace('-','',$phone));

			$data = array(
				'name'	=> $name,
				'type'	=> $type,
				'dong'	=> $dong,
				'ho'	=> $ho,
				'phone'	=> $phone,
				'area'	=> $area,
				'created'	=> TIME_YMDHIS
			);

			if (!is_null($res = $this->ci->landing_model->excel_winner_by_admin($data))) {
				return $data;
			}

		return NULL;
	}



	// 당첨자 개별 삭제 처리(업데이트)
	function winner_del($idx=FALSE) {
		// 새글이나 답변글 작성 또는 수정
		if (!is_null($res = $this->ci->landing_model->winner_del($idx))) {
			return $res;
		}
		else {
			return NULL;
		}
	}


}