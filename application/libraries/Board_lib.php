<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Board
 */
class Board_lib
{
	private $error = array();

	function __construct()
	{
		$this->ci =& get_instance();

		$this->ci->load->config('tank_auth', TRUE);
		$this->ci->load->database();
		$this->ci->load->model('tank_auth/users');

		/*
		// Try to autologin
		$this->autologin();
		*/

		$this->ci->load->model('board_model');
		$this->ci->load->model('upload_model');

	}



	/** - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	 * [게시판 공통] 중복 체크
	 */

	function is_board_available($table='',$field='',$value='')
	{
		return ((strlen($table) > 0) AND (strlen($field) > 0) AND (strlen($value) > 0) AND $this->ci->board_model->is_board_available($table,$field,$value));
	}
	/*
	function is_group_code_available($gr_code)
	{
		return ((strlen($gr_code) > 0) AND $this->ci->board_model->is_group_code_available($gr_code));
	}
	*/






	/** - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	 * 게시판 그룹 관리
	 */

	// 그룹 만들기
	function make_board_group($gr_code='',$gr_title='',$gr_admin_fk='2')
	{
		if($gr_code && $gr_title && $gr_admin_fk)
		{
			$data = array(
				'gr_code'      => $gr_code,
				'gr_title'     => $gr_title,
				'gr_admin_fk'  => $gr_admin_fk,
				'gr_reg_date'  => TIME_YMDHIS,
				'gr_reg_ip'    => $this->ci->input->ip_address(),
			);

			if (!is_null($res = $this->ci->board_model->make_board_group($data))) {
				return $data;
			}
		}

		return NULL;
	}

	// 그룹 업데이트
	function update_board_group($gr_idx='',$data=array())
	{
		if (!is_null($res = $this->ci->board_model->update_board_group($gr_idx,$data))) {
			return $data;
		}
	}

	// 그룹 삭제
	function delete_board_group($gr_code=FALSE)
	{

		if( ! $this->ci->tank_auth->is_admin()) {
			return FALSE;
		}
		/*
		if($this->ci->tank_auth->is_logged_admin(FALSE)) {
			return FALSE;
		}
		*/

		// 그룹에 속한 게시판이 하나라도 있다면 그룹 삭제 불가
		$bo_cnt = $this->ci->basic_model->get_common_count('board_config', array('gr_code'=>$gr_code));
		if($bo_cnt > 0) {
			return 'exist_boards';
		}
		else if ($gr_code && ! ($this->ci->board_lib->is_board_available('board_group','gr_code',$gr_code))) {
			return $this->ci->board_model->delete_board_group($gr_code);
		}
		return FALSE;
	}






	/** - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	 * 게시판 관리
	 */

	// 게시판 생성
	function make_board($new_bo_code,$new_bo_title,$new_bo_type,$gr_code) {

		if($new_bo_code && $new_bo_title && $new_bo_type && $gr_code)
		{
			$data = array(
				'gr_code'      => $gr_code,
				'bo_code'      => $new_bo_code,
				'bo_title'     => $new_bo_title,
				'bo_type'      => $new_bo_type,
				'bo_reg_date'  => TIME_YMDHIS,
				'bo_reg_ip'    => $this->ci->input->ip_address(),
			);

			if (!is_null($res = $this->ci->board_model->make_board($data))) {
				return $data;
			}
		}

		return NULL;
	}

	// 게시판 정보 업데이트 1
	function edit_board($bo_code=FALSE)
	{

			$data = array(
				'bo_title'   => $this->ci->input->post('bo_title'),
				'gr_code'       => $this->ci->input->post('gr_code'),
				'bo_type'	=> $this->ci->input->post('bo_type'),
				'bo_width_limit'	=> $this->ci->input->post('bo_width_limit'),
				'bo_width_max'	=> $this->ci->input->post('bo_width_max'),
				'bo_admin_fk'	=> $this->ci->input->post('bo_admin_fk'),

				'bo_level_list'	=> $this->ci->input->post('bo_level_list'),
				'bo_level_read'	=> $this->ci->input->post('bo_level_read'),
				'bo_level_write'	=> $this->ci->input->post('bo_level_write'),
				'bo_level_reply'	=> $this->ci->input->post('bo_level_reply'),
				'bo_level_comment'	=> $this->ci->input->post('bo_level_comment'),
				'bo_level_upload'	=> $this->ci->input->post('bo_level_upload'),
				'bo_level_download'	=> $this->ci->input->post('bo_level_download'),

				'bo_writer_type'	=> $this->ci->input->post('bo_writer_type'),
				'bo_use_secret'	=> $this->ci->input->post('bo_use_secret'),
				'bo_use_category'	=> $this->ci->input->post('bo_use_category'),
				'bo_category'	=> $this->ci->input->post('bo_category'),
				'bo_use_new'	=> $this->ci->input->post('bo_use_new'),
				'bo_new_condition'	=> $this->ci->input->post('bo_new_condition'),
				'bo_use_hot'	=> $this->ci->input->post('bo_use_hot'),
				'bo_hot_condition'	=> $this->ci->input->post('bo_hot_condition'),
				'bo_use_staff'	=> $this->ci->input->post('bo_use_staff'),
				'bo_use_comment'	=> $this->ci->input->post('bo_use_comment'),

				'bo_notice_limit'	=> $this->ci->input->post('bo_notice_limit'),
				'bo_notice_type'	=> $this->ci->input->post('bo_notice_type'),
				'bo_page_limit'	=> $this->ci->input->post('bo_page_limit'),
				'bo_use_editor'	=> $this->ci->input->post('bo_use_editor'),
				'bo_editor_type'	=> $this->ci->input->post('bo_editor_type'),

				'bo_use_upload'	=> $this->ci->input->post('bo_use_upload'),
				'bo_upload_cnt'	=> $this->ci->input->post('bo_upload_cnt'),
				'bo_upload_size'	=> $this->ci->input->post('bo_upload_size'),
				'bo_use_link'	=> $this->ci->input->post('bo_use_link'),
				'bo_init_content'	=> $this->ci->input->post('bo_init_content'),
				'bo_file_position'	=> $this->ci->input->post('bo_file_position'),
				'bo_file_image_display'	=> $this->ci->input->post('bo_file_image_display'),
				'bo_image_width'	=> $this->ci->input->post('bo_image_width'),
				'bo_head'	=> $this->ci->input->post('bo_head'),
				'bo_tail'	=> $this->ci->input->post('bo_tail'),

				'arrfld_1_ttl'	=> $this->ci->input->post('arrfld_1_ttl'),
				'arrfld_1'	=> $this->ci->input->post('arrfld_1'),
				'arrfld_2_ttl'	=> $this->ci->input->post('arrfld_2_ttl'),
				'arrfld_2'	=> $this->ci->input->post('arrfld_2'),
			);
			//print_r($data);
			//exit;

			if (!is_null($res = $this->ci->board_model->edit_board($bo_code,$data))) {
				return $data;
			}

	}


	// 게시판 정보 업데이트 2
	function update_board($bo_code=FALSE, $data=array())
	{
		if (!is_null($res = $this->ci->board_model->edit_board($bo_code,$data))) {
			return $data;
		}
	}


	// 게시판 삭제
	function delete_board($bo_code=FALSE)
	{
		/*
		if($this->ci->tank_auth->is_logged_admin(FALSE)) {
			return FALSE;
		}
		*/

		if( ! $this->ci->tank_auth->is_admin()) {
			return FALSE;
		}

		if ($bo_code && ! ($this->ci->board_lib->is_board_available('board_config','bo_code',$bo_code))) {
			return $this->ci->board_model->delete_board($bo_code);
		}
		return FALSE;
	}


	// 게시판 정보 업데이트 3 - admin 관리자용
	function edit_board_brief($bo_code=FALSE)
	{

			$data = array(
				'bo_title'   => $this->ci->input->post('bo_title'),
				'gr_code'       => $this->ci->input->post('gr_code'),
				/*
				'bo_type'	=> $this->ci->input->post('bo_type'),
				'bo_width_limit'	=> $this->ci->input->post('bo_width_limit'),
				'bo_width_max'	=> $this->ci->input->post('bo_width_max'),
				'bo_admin_fk'	=> $this->ci->input->post('bo_admin_fk'),
				*/

				'bo_level_list'	=> $this->ci->input->post('bo_level_list'),
				'bo_level_read'	=> $this->ci->input->post('bo_level_read'),
				'bo_level_write'	=> $this->ci->input->post('bo_level_write'),
				'bo_level_reply'	=> $this->ci->input->post('bo_level_reply'),
				/*
				'bo_level_comment'	=> $this->ci->input->post('bo_level_comment'),
				'bo_level_upload'	=> $this->ci->input->post('bo_level_upload'),
				'bo_level_download'	=> $this->ci->input->post('bo_level_download'),
				*/

				/*
				'bo_writer_type'	=> $this->ci->input->post('bo_writer_type'),
				'bo_use_secret'	=> $this->ci->input->post('bo_use_secret'),
				'bo_use_category'	=> $this->ci->input->post('bo_use_category'),
				'bo_category'	=> $this->ci->input->post('bo_category'),
				'bo_use_new'	=> $this->ci->input->post('bo_use_new'),
				'bo_new_condition'	=> $this->ci->input->post('bo_new_condition'),
				'bo_use_hot'	=> $this->ci->input->post('bo_use_hot'),
				'bo_hot_condition'	=> $this->ci->input->post('bo_hot_condition'),
				'bo_use_staff'	=> $this->ci->input->post('bo_use_staff'),
				'bo_use_comment'	=> $this->ci->input->post('bo_use_comment'),
				*/

				/*
				'bo_notice_limit'	=> $this->ci->input->post('bo_notice_limit'),
				'bo_notice_type'	=> $this->ci->input->post('bo_notice_type'),
				'bo_page_limit'	=> $this->ci->input->post('bo_page_limit'),
				'bo_use_editor'	=> $this->ci->input->post('bo_use_editor'),
				'bo_use_upload'	=> $this->ci->input->post('bo_use_upload'),
				'bo_upload_cnt'	=> $this->ci->input->post('bo_upload_cnt'),
				'bo_upload_size'	=> $this->ci->input->post('bo_upload_size'),
				'bo_use_link'	=> $this->ci->input->post('bo_use_link'),
				'bo_init_content'	=> $this->ci->input->post('bo_init_content'),
				'bo_file_position'	=> $this->ci->input->post('bo_file_position'),
				'bo_file_image_display'	=> $this->ci->input->post('bo_file_image_display'),
				'bo_image_width'	=> $this->ci->input->post('bo_image_width'),
				'bo_head'	=> $this->ci->input->post('bo_head'),
				'bo_tail'	=> $this->ci->input->post('bo_tail'),
				*/

				'bo_page_limit'	=> $this->ci->input->post('bo_page_limit'),

				'bo_use_upload'	=> $this->ci->input->post('bo_use_upload'),
				'bo_upload_cnt'	=> $this->ci->input->post('bo_upload_cnt'),
				'bo_upload_size'	=> $this->ci->input->post('bo_upload_size'),

			);


			if (!is_null($res = $this->ci->board_model->edit_board($bo_code,$data))) {
				return $data;
			}

	}








	/** - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	 * 게시글 관리
	 */

	// 글 작성히기(수정하기)
	function write($bo_code=FALSE,$wr_idx=FALSE,$mode='write',$bbs_cf=FALSE)
	{
		// 로그인 회원 정보
		$user_idx = $this->ci->tank_auth->get_user_id();
		//$user = $this->ci->tank_auth->get_userinfo($this->ci->tank_auth->get_username());
		//$user_level = isset($user->level) ? $user->level : '';

		$user_table = ($user_idx < 1000) ? 'users_admin' : 'users';
		//$uacc = $this->ci->basic_model->get_common_row('row','username,nickname',$user_table,FALSE,FALSE,FALSE,array('id'=>$user_idx));

		// 게시판 설정파일
		$arr = array('sql_select' => 'username,nickname','sql_from' => $user_table,'sql_where' => array('id'=>$user_idx));
		$uacc = $this->ci->basic_model->arr_get_row($arr);


		if(isset($uacc->username)) {
			$wr_name = $uacc->nickname;
			$wr_username = $uacc->username;
		}


		$data = array();


		// 작성자 정보
		$wr_name_post = $this->ci->input->post('wr_name');
		if($wr_name_post && '' != $wr_name_post) {
			$wr_name = $wr_name_post;
		}

		if(! isset($wr_name) OR '' == $wr_name) {
			$wr_name = 'guest';
		}



		// 교육 신청
		$wr_subject = $this->ci->input->post('wr_subject');
		if('request' == $bo_code ) 
		{
			$wr_subject = $wr_name.'님의 신청입니다.';
		}


		if( $mode === 'write' )
		{

			// 가장 작은 번호에 1을 빼서 넘겨줌
			$wr_num = $this->ci->board_model->get_min_num($bo_code);
			$wr_num = (int)($wr_num - 1);

			$ord_num = $this->ci->board_model->get_max_ord($bo_code);
			$ord_num = (int)($ord_num + 1);


			$password = NULL;
			if( $this->ci->input->post('opt_secret') ) {
				
				if($this->ci->input->post('wr_password')) {
					//$this->ci->load->library('encrypt');
					//$password = $this->ci->encrypt->encode($this->ci->input->post('wr_password'));

					$password = md5($this->ci->input->post('wr_password'));
				}
				else {
					$password = isset($uacc->username) ? $uacc->username : '';
				}

				$ss_password_name = 'ss_bbs_password';
				$this->ci->session->set_userdata($ss_password_name, time());
			}


			$data = array(
				//'ca_code'      => $this->ci->input->post('ca_code'),
				'ORD'      => $ord_num,

				'wr_subject'      => $wr_subject,
				'opt_notice'      => $this->ci->input->post('opt_notice'),
				'opt_staff'      => $this->ci->input->post('opt_staff'),
				'opt_secret'      => $this->ci->input->post('opt_secret'),
				'wr_content'     => $this->ci->input->post('wr_content'),

				'wr_datetime'  => TIME_YMDHIS,
				'wr_ip'    => $this->ci->input->ip_address(),
				'user_idx'    => $user_idx,
				'wr_name'    => $wr_name,
				//'wr_name'    => $this->ci->input->post('wr_name'),

				'wr_password' => $password,

				'wr_num'      => $wr_num,
				'wr_reply'    => ''
			);


		}
		elseif( $mode === 'update' )
		{


			$password = NULL;
			if( $this->ci->input->post('opt_secret') ) {
				
				if($this->ci->input->post('wr_password')) {
					//$this->ci->load->library('encrypt');
					//$password = $this->ci->encrypt->encode($this->ci->input->post('wr_password'));

					$password = md5($this->ci->input->post('wr_password'));
				}
				else {
					$password = isset($user->username) ? $user->username : '';
				}

				$ss_password_name = 'ss_bbs_password';
				$this->ci->session->set_userdata($ss_password_name, time());
			}

			$data = array(
				//'ca_code'      => $this->ci->input->post('ca_code'),

				'wr_subject'      => $wr_subject,
				'opt_notice'      => $this->ci->input->post('opt_notice'),
				'opt_staff'      => $this->ci->input->post('opt_staff'),
				'opt_secret'      => $this->ci->input->post('opt_secret'),
				'wr_content'     => $this->ci->input->post('wr_content'),
				//'wr_name'    => $this->ci->input->post('wr_name'),

				'wr_last'  => TIME_YMDHIS,
				'wr_password' => $password
			);

		}
		elseif( $mode === 'reply' )
		{
			// 부모 글 정보
			$parent_wr_idx = $wr_idx;
			//$parent_row = $this->ci->basic_model->get_common_row('row','*',BBS_PRE.$bo_code,FALSE,FALSE,FALSE,array('wr_idx'=>$parent_wr_idx),FALSE,FALSE,FALSE);

			$arr = array('sql_select' => '*','sql_from' => BBS_PRE.$bo_code,'sql_where' => array('wr_idx'=>$parent_wr_idx));
			$parent_row = $this->ci->basic_model->arr_get_row($arr);

			// 하나의 답변에 대한 갯수 체크 (최대 26개)
			$reply = $this->ci->board_model->get_reply_step($bo_code, $parent_row->wr_num, $bbs_cf->bo_reply_order, $parent_row->wr_reply);

			$data = array(
				//'ca_code'      => $this->ci->input->post('ca_code'),

				'wr_subject'      => $this->ci->input->post('wr_subject'),
				'opt_notice'      => $this->ci->input->post('opt_notice'),
				'opt_staff'      => $this->ci->input->post('opt_staff'),
				'opt_secret'      => $this->ci->input->post('opt_secret'),
				'wr_content'     => $this->ci->input->post('wr_content'),

				'wr_datetime'  => TIME_YMDHIS,
				'wr_ip'    => $this->ci->input->ip_address(),
				'user_idx'    => $user_idx,
				'wr_name'    => $user->nickname,
				'wr_password' => ( $this->ci->input->post('opt_secret') ) ? $user->username : '',

				'wr_num'      => $parent_row->wr_num,
				'wr_reply'    => $reply
			);

		}

		// 카테고리가 있는 경우만,
		if($this->ci->input->post('ca_code',FALSE)) {
			$data['ca_code'] = $this->ci->input->post('ca_code');
		}

		// 공지체크는 관리자만!!!
		/*
		if($this->ci->tank_auth->is_logged_admin(FALSE)) {
			$data['opt_notice'] = $this->ci->input->post('opt_notice');
		}
		*/
		if($this->ci->tank_auth->is_admin()) {
			$data['opt_notice'] = $this->ci->input->post('opt_notice');
		}


		// 링크가 있는 경우만,
		$wr_link = '';
		if($this->ci->input->post('wr_link',FALSE)) {
			$wr_link = $this->ci->input->post('wr_link',FALSE);
		}
		$data['wr_link'] = $wr_link;

		$wr_link_target = '1'; // [1]자기창, [2]새창
		if($this->ci->input->post('wr_link_target',FALSE)) {
			$wr_link_target = $this->ci->input->post('wr_link_target',FALSE);
			$data['wr_link_target'] = $wr_link_target;
		}
		


		// 추가 칼럼
		if($this->ci->input->post('addfld_1',FALSE) !== NULL) {
			$data['addfld_1'] = $this->ci->input->post('addfld_1');
		}
		if($this->ci->input->post('addfld_2',FALSE) !== NULL) {
			$data['addfld_2'] = $this->ci->input->post('addfld_2');
		}
		if($this->ci->input->post('addfld_3',FALSE) !== NULL) {
			$data['addfld_3'] = $this->ci->input->post('addfld_3');
		}
		if($this->ci->input->post('addfld_4',FALSE) !== NULL) {
			$data['addfld_4'] = $this->ci->input->post('addfld_4');
		}
		if($this->ci->input->post('addfld_5',FALSE) !== NULL) {
			$data['addfld_5'] = $this->ci->input->post('addfld_5');
		}
		if($this->ci->input->post('addfld_6',FALSE) !== NULL) {
			$data['addfld_6'] = $this->ci->input->post('addfld_6');
		}
		if($this->ci->input->post('addfld_7',FALSE) !== NULL) {
			$data['addfld_7'] = $this->ci->input->post('addfld_7');
		}
		if($this->ci->input->post('addfld_8',FALSE) !== NULL) {
			$data['addfld_8'] = $this->ci->input->post('addfld_8');
		}
		if($this->ci->input->post('addfld_9',FALSE) !== NULL) {
			$data['addfld_9'] = $this->ci->input->post('addfld_9');
		}
		if($this->ci->input->post('addfld_10',FALSE) !== NULL) {
			$data['addfld_10'] = $this->ci->input->post('addfld_10');
		}


		if($this->ci->input->post('wr_email',FALSE) !== NULL) {
			$data['wr_email'] = $this->ci->input->post('wr_email');
		}
		if($this->ci->input->post('wr_mobile',FALSE) !== NULL) {
			$data['wr_mobile'] = $this->ci->input->post('wr_mobile');
		}

		// 이벤트
		if($this->ci->input->post('sdate',FALSE) !== NULL) {
			$data['SDATE'] = $this->ci->input->post('sdate');
		}
		if($this->ci->input->post('edate',FALSE) !== NULL) {
			$data['EDATE'] = $this->ci->input->post('edate');
		}
		if($this->ci->input->post('view',FALSE) !== NULL) {
			$data['VIEW'] = $this->ci->input->post('view');
		}

		// 공지사항, 이벤트 ==> 메인에 배너 노출 여부(Y/N)
		if($this->ci->input->post('main_dsp',FALSE) !== NULL) {
			$data['main_dsp'] = $this->ci->input->post('main_dsp');
		}


		// 온라인 상담, 질문유형(수술문의/예약문의/일반문의)
		if($this->ci->input->post('qtype',FALSE) !== NULL) {
			$data['qtype'] = $this->ci->input->post('qtype');
		}

		// 온라인 상담 [reserve]
		if('reserve' == $bo_code) {
			//$data['REFER'] = $this->ci->input->post('refer');
			$data['reserve_year'] = $this->ci->input->post('reserve_year');
			$data['reserve_month'] = $this->ci->input->post('reserve_month');
			$data['reserve_date'] = $this->ci->input->post('reserve_date');
			$data['reserve_time'] = $this->ci->input->post('reserve_time');
		}

		// 이벤트 [event]
		if('event' == $bo_code) {
			$arr_branch = $this->ci->input->post('addfld_5');
			$branch = implode(',',$arr_branch);
			$data['addfld_5'] = $branch;
		}




		// 나눔신청
		if('goodshare' == $bo_code ) 
		{
			// 신청자 정보 및 수혜자 정보
			$data['gubun'] = $this->ci->input->post('gubun');

			$data['req_name'] = $this->ci->input->post('req_name');
			$data['req_name_org'] = $this->ci->input->post('req_name_org');
			$data['req_postcode'] = $this->ci->input->post('req_postcode');
			$data['req_addr'] = $this->ci->input->post('req_addr');
			$data['req_addr_detail'] = $this->ci->input->post('req_addr_detail');
			$data['req_birthday'] = $this->ci->input->post('req_birthday');
			$data['req_phone'] = $this->ci->input->post('req_phone');

			$data['bnf_name'] = $this->ci->input->post('bnf_name');
			$data['bnf_target'] = $this->ci->input->post('bnf_target');
			$data['bnf_postcode'] = $this->ci->input->post('bnf_postcode');
			$data['bnf_addr'] = $this->ci->input->post('bnf_addr');
			$data['bnf_addr_detail'] = $this->ci->input->post('bnf_addr_detail');
			$data['bnf_birthday'] = $this->ci->input->post('bnf_birthday');
			$data['bnf_phone'] = $this->ci->input->post('bnf_phone');
			$data['bnf_devices'] = $this->ci->input->post('bnf_devices');
			//$data['passwd'] = $this->ci->input->post('passwd');
		}



		// 새글이나 답변글 작성 또는 수정
		if (!is_null($res = $this->ci->board_model->write($bo_code,$wr_idx,$data,$mode,$bbs_cf->bo_notice_idxs))) {
			$inserted_idx = $res['wr_idx'];
			return $res;
		}

		return NULL;
	}


	// 조회수 증가
	function hit_update($bo_code, $wr_idx) {
		// 게시판 테이블명
		$bo_table = BBS_PRE. $bo_code;  // BBS_PRE: [bbs_]
		$this->ci->board_model->hit_update($bo_table, $wr_idx);
	}
	// 파일 수 업데이트
	function cnt_file_update($bo_code, $wr_idx) {

		// 파일 수량 체크
		$cnt_succ_upload = $this->ci->basic_model->get_common_count('file_manager', array('wr_table'=>$bo_code, 'wr_table_idx'=>$wr_idx, 'upload_type'=>'form'));

		// 게시판 테이블명
		$bo_table = BBS_PRE. $bo_code;  // BBS_PRE: [bbs_]
		$file_data = array('wr_count_file' => $cnt_succ_upload);
		$this->ci->board_model->cnt_file_update($bo_table, $wr_idx, $file_data);
	}


	// 글 삭제하기
	function write_delete($bo_code=FALSE,$wr_idx=FALSE)
	{
		// 선택한 글 정보
		//$row = $this->ci->basic_model->get_common_row('row','*',BBS_PRE.$bo_code,FALSE,FALSE,FALSE,array('wr_idx'=>$wr_idx),FALSE,FALSE,FALSE);
		$arr = array('sql_select' => '*','sql_from' => BBS_PRE.$bo_code,'sql_where' => array('wr_idx'=>$wr_idx));
		$row = $this->ci->basic_model->arr_get_row($arr);

		if( $wr_idx > 0 && ! isset($row->wr_idx) ) {
			alert('존재하지 않는 글이거나 이미 삭제된 글입니다.',$this->ci->bbs_code_url .'/lists/page/'. $page);
			exit;
			//return FALSE;
		}

		// 로그인 회원 정보
		$user_idx = $this->ci->tank_auth->get_user_id();
		//$user = $this->ci->tank_auth->get_userinfo($this->ci->tank_auth->get_username());

		// 본인 여부 및 관리자 여부 확인
		/*
		if( ($user_idx !== $row->user_idx) && $this->ci->tank_auth->is_logged_admin(FALSE) ) {
			alert('권한이 없습니다.');
			exit;
		}
		*/
		if(($user_idx !== $row->user_idx) && ! $this->ci->tank_auth->is_admin()) {
			alert('권한이 없습니다.');
			exit;
			//return FALSE;
		}

		// 글 삭제
		$bo_table = BBS_PRE. $bo_code;  // BBS_PRE: [bbs_]
		if($this->ci->board_model->write_delete($bo_table,$wr_idx)) {
			// 파일 삭제
			return $this->ci->upload_model->delete_file_manager(FALSE,$bo_code,$wr_idx);
		}
		return FALSE;
	}















	// 코멘트 삭제하기
	function cmt_del()
	{

		if(! $this->ci->tank_auth->is_logged_in() ) {
			return 'not_logged_in';
			exit;
		}

		// 로그인 회원 정보
		$user_idx = $this->ci->tank_auth->get_user_id();
		//$user = $this->ci->tank_auth->get_userinfo($this->ci->tank_auth->get_username());

		// 자기 글 정보
		$cmt_idx = $this->ci->input->post('cmt_idx');


		// 답글이 달린 댓글인지 체크
		// $res = 'exist_reply';
		$sql_from = 'board_comment';
		$sql_where = array('parent'=>$cmt_idx, 'depth'=>2);
		$chk_reply = $this->ci->basic_model->get_common_count($sql_from, $sql_where);


		// 로그인 회원 본인의 코멘트인지 확인
		$sql_from = 'board_comment';
		$sql_where = array('idx'=>$cmt_idx, 'user_idx'=>$user_idx);
		$chk_owner = $this->ci->basic_model->get_common_count($sql_from, $sql_where);

		if($chk_reply) {
			$res = 'exist_reply';
		}
		else if(! $chk_owner) {
			$res = 'not_owner';
		}
		else {
			$res = $this->ci->board_model->cmt_del($cmt_idx);
		}



		// 최고 관리자는 모두 삭제 가능하도록..
		if( $this->ci->tank_auth->is_admin() ) {
			$res = $this->ci->board_model->cmt_del($cmt_idx);
		}


		return $res;
	}

	// 코멘트 작성히기(수정하기)
	function cmt_write($bo_code=FALSE,$wr_idx=FALSE,$mode='write')
	{

		if(! $this->ci->tank_auth->is_logged_in() ) {
			return 'not_logged_in';
			exit;
		}



		// 로그인 회원 정보
		$user_idx = $this->ci->tank_auth->get_user_id();
		$username = $this->ci->tank_auth->get_username();
		//$user = $this->ci->tank_auth->get_userinfo($this->ci->tank_auth->get_username());
		$nickname = $this->ci->tank_auth->get_nickname();
		



		// 작성자 정보
		/*
		$user_table = ($user_idx < 1000) ? 'users_admin' : 'users';
		$uacc = $this->basic_model->get_common_row('row','username,nickname',$user_table,FALSE,FALSE,FALSE,array('id'=>$user_idx));
		if(isset($uacc->username)) {
			$nickname  = $uacc->nickname;
		}
		*/





		$data = array();
		$cmt_idx = false;
		$title = '';

		if( $mode === 'write' )
		{
			$data = array(
				'user_idx'    => $user_idx,
				'username'    => $username,
				'nickname'    => $nickname,
				'bo_code'    => $bo_code,
				'wr_idx'    => $wr_idx,
				'title'    => $title,
				'content'    => $this->ci->input->post('cmt_content'),
				'reg_datetime'  => TIME_YMDHIS,
				'reg_ip'    => $this->ci->input->ip_address()
			);
		}
		elseif( $mode === 'update' )
		{
			// 자기 글 정보
			$cmt_idx = $this->ci->input->post('cmt_idx');
			$data = array(
				'content'    => $this->ci->input->post('cmt_content')
			);
		}
		elseif( $mode === 'reply' )
		{
			// 부모 글 정보
			$cmt_idx = $this->ci->input->post('cmt_idx');
			$parent_cmt_idx = $cmt_idx;

			

			$sql_from = 'board_comment';
			$sql_where = array('bo_code'=>$bo_code,'wr_idx'=>$wr_idx,'parent'=>$parent_cmt_idx);
			$order_no = $this->ci->basic_model->get_common_count($sql_from, $sql_where);
			$depth = 2;

			$data = array(
				'user_idx'    => $user_idx,
				'username'    => $username,
				'nickname'    => $nickname,
				'bo_code'    => $bo_code,
				'wr_idx'    => $wr_idx,
				'title'    => $title,
				'content'    => $this->ci->input->post('cmt_content'),
				'parent'    => $parent_cmt_idx,
				'depth'    => $depth,
				'order'    => $order_no,
				'reg_datetime'  => TIME_YMDHIS,
				'reg_ip'    => $this->ci->input->ip_address()
			);

		}

		// 새글이나 답변글 작성 또는 수정
		if (!is_null($res = $this->ci->board_model->cmt_write($bo_code,$wr_idx,$data,$mode,$cmt_idx))) {
			

			if( $res ) {
				//return $data['content'];

				$cmt_idx = $res;
				//$row = $this->ci->basic_model->get_common_row('row','board_comment.*, users.nickname AS user_nickname','board_comment','users','users.id = board_comment.user_idx','left outer',array('idx'=>$cmt_idx),FALSE,FALSE,FALSE);

				$arr = array('sql_select' => 'board_comment.*, users.nickname AS user_nickname','sql_from' => 'board_comment','sql_where' => array('id'=>$cmt_idx), 'sql_join_tbl'=>'users', 'sql_join_on'=>'users.id = board_comment.user_idx');
				$row = $this->ci->basic_model->arr_get_row($arr);

				if( $mode === 'update' ) {
					$html = nl2br($row->content);
				}
				else {

					$reply_layer_style = '';
					if( 'reply' === $mode ) {
						$reply_layer_style = 'margin:10px 0 5px 50px; padding:10px; padding-left:50px; background-color:#f3f3f3; background-image:url(\"'. IMG_DIR .'/common/icon_reply.gif\"); background-repeat:no-repeat; background-position:20px 13px;';
					}

					/*
					$html = '';
					$html .= '<div id="ajax_layer_'. $row->idx .'" style="'. $reply_layer_style .'">';

					if( 'write' === $mode ) {
					//$html .= '	<hr style="margin:25px 0; border:none; border-top:1px dashed #ccc;" />';
					}

					$html .= '	<h4 style="position:relative;font-size:15px;">'. $row->user_nickname. '</h4>';
					$html .= '	<div style="margin:5px 0;">'. nl2br($row->content) .'</div>';
					$html .= '	<em>'. $row->reg_datetime .'</em>';
					$html .= '</div>';
					*/


					$html = '<div id="ajax_cmt_'. $row->idx .'" class="cmt_layer_'. $row->idx .'" style="'. $reply_layer_style .'">';

					$html .= '	<div id="view_cmt_'. $row->idx .'" style="margin:5px 0;">'. nl2br($row->content) .'</div>';

					$html .= '	<h4 style="position:relative;font-size:15px;">';
					$html .= '		<button type="button" class="btn btn-default-flat btn-xs" onclick="cmt_edit_view('. $row->idx .');">수정</button>';
					$html .= '		<button type="button" class="btn btn-default-flat btn-xs" onclick="cmt_del('. $row->idx .');">삭제</button>';
					$html .= '	</h4>';


					/*

					if( 'write' === $mode ) {
					$html .= '	<hr style="margin:25px 0; border:none; border-top:1px dashed #ccc;" />';
					}

					$html .= '	<h4 style="position:relative;font-size:15px;">';
					$html .= '		'. $row->user_nickname;

					$html .= '		<button type="button" class="btn btn-default-flat btn-xs" onclick="cmt_edit_view('. $row->idx .');">수정</button>';
					$html .= '		<button type="button" class="btn btn-default-flat btn-xs" onclick="cmt_del('. $row->idx .');">삭제</button>';

					$html .= '	</h4>';
					$html .= '	<div id="view_cmt_'. $row->idx .'" style="margin:5px 0;">'. nl2br($row->content) .'</div>';
					$html .= '	<div id="edit_cmt_'. $row->idx .'" style="display: none; margin:5px 0;">';
					$html .= '	  <div class="row">';
					$html .= '		<div class="col-md-9 col-sm-8 col-xs-7" style="">';
					$html .= '			<textarea id="cmt_content_'. $row->idx .'" style="width:100%; padding:10px; border:1px solid #ccc;">'. $row->content  .'</textarea>';
					$html .= '		</div>';
					$html .= '		<div class="col-md-2 col-sm-2 col-xs-3">';
					$html .= '			<button type="button" class="btn btn-default-flat btn-sm" style="padding:15px;" onclick="cmt_write('. $row->idx  .',\'update\');">수정하기</button>';
					$html .= '		</div>';
					$html .= '	  </div>';
					$html .= '	</div>';
					$html .= '	<hr style=" clear:both; border:none;" />';
					$html .= '	<em>'. $row->reg_datetime  .'</em>';
					*/

					$html .= '</div>';





				}

				return $html;
			}

		}
		return NULL;
	}





	function consult_write($name=false,$comp=false,$phone=false,$content=false) {

		$bo_code = 'consult';

		// 가장 작은 번호에 1을 빼서 넘겨줌
		$wr_num = $this->ci->board_model->get_min_num($bo_code);
		$wr_num = (int)($wr_num - 1);

		$data = array(
			'wr_subject'      => $name.'님의 빠른상담신청입니다.',
			'wr_content'     => $content,
			'wr_datetime'  => TIME_YMDHIS,
			'wr_ip'    => $this->ci->input->ip_address(),
			'wr_name'    => $name,
			'wr_num'      => $wr_num,
			'wr_reply'    => '',
			'addfld_1' => $comp, // 회사명
			'addfld_2' => $phone, // 연릭처
		);


		// 새글이나 답변글 작성 또는 수정
		$wr_idx = false;
		if (!is_null($res = $this->ci->board_model->write($bo_code,$wr_idx,$data))){
			return $res;
		}

		return NULL;






	}





	// 게시판 추천(로그인 없음)
	function recommand_write($bo_code=FALSE,$wr_idx=FALSE) {


		$this->ci->load->library('user_agent');

		/*

		if ($this->ci->agent->is_browser())
		{
			$agent = $this->ci->agent->browser().' '.$this->ci->agent->version();
		}
		elseif ($this->ci->agent->is_robot())
		{
			$agent = $this->ci->agent->robot();
		}
		elseif ($this->ci->agent->is_mobile())
		{
			$agent = $this->ci->agent->mobile();
		}
		else
		{
			$agent = 'Unidentified User Agent';
		}

		echo $agent;

		echo $this->ci->agent->platform(); // 플렛폼정보 (Windows, Linux, Mac, etc.)

		*/


		$ip = REMOTE_ADDR;
		$os = $this->ci->agent->platform();
		$mobile = $this->ci->agent->mobile();
		$browser = $this->ci->agent->browser().' '.$this->ci->agent->version();

		$this->ci->db->select('1', FALSE);

		$this->ci->db->where('bo_code',$bo_code);
		$this->ci->db->where('wr_idx',$wr_idx);

		$this->ci->db->where('ip',$ip);
		$this->ci->db->where('os',$os);
		$this->ci->db->where('mobile',$mobile);
		$this->ci->db->where('browser',$browser);

		$query = $this->ci->db->get('board_recommand');

		if($query->num_rows() == 0) 
		{
			$data = array(
				'bo_code'      => $bo_code,
				'wr_idx'       => $wr_idx,
				'ip'    => $this->ci->input->ip_address(),
				'os'    => $os,
				'mobile'    => $mobile,
				'browser' => $browser,
				'wr_datetime'  => TIME_YMDHIS,
			);

			if( $this->ci->db->insert('board_recommand', $data) ) {

				// 추천 수 업데이트 
				$bo_table = BBS_PRE. $bo_code;  // BBS_PRE: [bbs_]
				$this->ci->board_model->recommand_update($bo_table, $wr_idx);



				return 'ok';
			}
		}
		else if($query->num_rows() > 0) {
			return 'already';
		}
		else {
			return false;
		}
	}



	// 이벤트 혜택 신청하기
	function event_contact_write($bo_code=FALSE,$wr_idx=FALSE,$arr=FALSE)
	{
		/*
			if(! $this->ci->tank_auth->is_logged_in() ) {
				return 'not_logged_in';
				exit;
			}
			// 로그인 회원 정보
			$user_idx = $this->ci->tank_auth->get_user_id();
			$user = $this->ci->tank_auth->get_userinfo($this->ci->tank_auth->get_username());
		*/


			$this->ci->db->select('*');
			$this->ci->db->where('wr_idx',$wr_idx);
			$row = $this->ci->db->get_where('bbs_'.$bo_code)->row();
			$gubun = $row->wr_subject;

			$data = array(
				'REFER'    => 'E',
				'bo_code'    => $bo_code,
				'wr_idx'    => $wr_idx,
				'REGNAME'    => $arr['contactname'],
				'MOBILE'    => $arr['contactmobile'],
				'CTIME'    => $arr['contactmessage'],
				'GUBUN'    => $gubun,
				'REGDATE'  => TIME_YMDHIS
			);


			// 새글이나 답변글 작성 또는 수정
			if (!is_null($res_idx = $this->ci->board_model->event_contact_write($bo_code,$wr_idx,$data))) {

				// SoftTelemanager 등록 처리
				// Gubun, Cust_Name, Cust_Phone, Email, contents, event_cost, event_cost_idx

				$dataSoft = array(
					'Gubun'      => $gubun.'_E',
					'Cust_Name'  => $arr['contactname'],
					'Cust_Phone' => $arr['contactmobile'],
					'Email'      => '', 
					'contents'   => $arr['contactmessage'],
					'MakeDate'  => TIME_YMDHIS,
					'event_cost' => 'event',
					'event_cost_idx' => $res_idx
				);

				// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
				// 스팸성 글 필터링
				// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
				$this->ci->board_model->softTelemanager_write($dataSoft);

				return $res_idx;
			}
			return false;

	}






	// 랜딩페이지 등록 
	// [TBL_LAND_REQ]
	function landing_write($arr=FALSE)
	{
		/*
			if(! $this->ci->tank_auth->is_logged_in() ) {
				return 'not_logged_in';
				exit;
			}
			// 로그인 회원 정보
			$user_idx = $this->ci->tank_auth->get_user_id();
			$user = $this->ci->tank_auth->get_userinfo($this->ci->tank_auth->get_username());
		*/

			$data = array(
				'PIDX'    => $arr['pidx'],
				'REFER'    => $arr['refer'],
				'REGNAME'    => $arr['name'],
				'EMAIL'    => $arr['email'],
				'MOBILE'    => $arr['mobile'],
				'CTIME'    => $arr['message'],
				'MESSAGE'    => $arr['message'],
				'GUBUN'    => $arr['gubun'],
				'BRANCH'    => $arr['branch'],
				'REGDATE'  => TIME_YMDHIS
			);


			if( isset($arr['call_time']) ) {
				$data['CALL_TIME'] = $arr['call_time'];
			}
			if( isset($arr['insurance_yn']) ) {
				$data['INSURANCE_YN'] = $arr['insurance_yn'];
			}


			// 새글이나 답변글 작성 또는 수정
			/*
			if (!is_null($res_idx = $this->ci->board_model->landing_write($data))) {
				return $res_idx;
			}
			return false;
			*/


			// 새글이나 답변글 작성 또는 수정
			if (!is_null($res_idx = $this->ci->board_model->landing_write($data))) {
				return $res_idx;
			}
			return false;

	}



	// 비용문의 등록
	function request_write($arr=FALSE)
	{
		/*
			if(! $this->ci->tank_auth->is_logged_in() ) {
				return 'not_logged_in';
				exit;
			}
			// 로그인 회원 정보
			$user_idx = $this->ci->tank_auth->get_user_id();
			$user = $this->ci->tank_auth->get_userinfo($this->ci->tank_auth->get_username());
		*/



		/*
			$data = array(
				'REFER'    => $arr['refer'],
				'REGNAME'    => $arr['name'],
				'EMAIL'    => $arr['email'],
				'MOBILE'    => $arr['mobile'],
				'CTIME'    => $arr['message'],
				'MESSAGE'    => $arr['message'],
				'GUBUN'    => $arr['gubun'],
				'REGDATE'  => TIME_YMDHIS
			);

		*/

			$bo_code = 'csb005';

			// 가장 작은 번호에 1을 빼서 넘겨줌
			$wr_num = $this->ci->board_model->get_min_num($bo_code);
			$wr_num = (int)($wr_num - 1);

			$ord_num = $this->ci->board_model->get_max_ord($bo_code);
			$ord_num = (int)($ord_num + 1);

			$password = NULL;

			$data = array(
				//'ca_code'      => $this->ci->input->post('ca_code'),
				'ORD'      => $ord_num,
				'REFER'      => $arr['refer'],
				'wr_name'    => $arr['name'],
				'wr_email'    => $arr['email'],
				'wr_mobile'    => $arr['mobile'],
				'wr_subject'    => $arr['message'],
				'wr_content'    => $arr['message'],
				'ca_code'    => $arr['gubun'],
				'wr_datetime'  => TIME_YMDHIS,
				'wr_ip'    => $this->ci->input->ip_address(),
				'wr_num'      => $wr_num,
				'wr_reply'    => ''
			);

			$soft_refer = (isset($arr['gubun'])  &&  '' != $arr['gubun']) ? $arr['gubun'] : '';
			$soft_refer .= '_'.$arr['refer'];
			$dataSoft = array(
				'Gubun'    => $soft_refer,
				'Cust_Name'    => $arr['name'],
				'Cust_Phone'    => $arr['mobile'],
				'Email'    => $arr['email'],
				'contents'    => $arr['message'],
				'MakeDate'  => TIME_YMDHIS
			);


			// 새글이나 답변글 작성 또는 수정
			if (!is_null($res_idx = $this->ci->board_model->request_write($data))) {

				$dataSoft['event_cost'] = 'cost';
				$dataSoft['event_cost_idx'] = $res_idx;

				$this->ci->board_model->softTelemanager_write($dataSoft);
				return $res_idx;
			}



			// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
			// 스팸성 글 필터링
			// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
			/*
			$spamChk = false;

			// [2020-05-05] 비정상적인 경우 접근 차단
			$regname_len = isset($arr['name']) ? strlen($arr['name']) : 0;
			$mobile_chk = isset($arr['mobile']) ? substr($arr['mobile'],0,2) : false;
			$mobile_len = isset($arr['mobile']) ? strlen($arr['mobile']) : 0;
			$msg_chk = isset($arr['message']) ? strpos($arr['message'],'http') : false;
			//if($regname_len > 12  OR  '01' != $mobile_chk  OR  $mobile_len < 10 OR $mobile_len > 11  OR  $msg_chk !== false) {
			if($regname_len > 21  OR  '01' != $mobile_chk  OR  $mobile_len < 10 OR $mobile_len > 11  OR  $msg_chk !== false) {
				$spamChk = true;
			}

			// 새글이나 답변글 작성 또는 수정
			if (!is_null($res_idx = $this->ci->board_model->request_write($data,$dataSoft,$spamChk))) {
				return $res_idx;
			}
			*/

			return false;
	}














}