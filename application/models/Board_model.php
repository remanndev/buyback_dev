<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Board_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();

		//$ci =& get_instance();
		$this->board_config_name = 'board_config';		// board config
		$this->board_group_name  = 'board_group';		// board group
		//$this->board_files_name  = 'board_files';		// board files
	}




	/** - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	 * Check if baord  [ ]  available for registering
	 *
	 * @param	string
	 * @return	bool
	 */
	function is_board_available($table='',$field='',$value='')
	{
		$this->db->select('1', FALSE);
		$this->db->where('LOWER('.$field.')=', strtolower($value));

		$query = $this->db->get($table);
		return $query->num_rows() == 0;
	}
	/*
	function is_group_code_available($gr_code)
	{
		$this->db->select('1', FALSE);
		$this->db->where('LOWER(gr_code)=', strtolower($gr_code));

		$query = $this->db->get($this->board_group_name);
		return $query->num_rows() == 0;
	}
	*/





	/** - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	 * Create new board group
	 *
	 * @param	array
	 * @param	bool
	 * @return	array
	 */

	// 게시판 그룹 생성
	function make_board_group($data)
	{
		/*
		if($this->tank_auth->is_logged_admin(FALSE)) {
			return FALSE;
		}
		*/
		if( ! $this->tank_auth->is_admin()) {
			return FALSE;
		}


		if ($this->db->insert($this->board_group_name, $data)) {
			$gr_idx = $this->db->insert_id();
			$data['idx'] = $gr_idx;
			return $data;
		}
		return NULL;
	}

	// 게시판 그룹 수정
	function update_board_group($gr_idx, $data)
	{
		/*
		if($this->tank_auth->is_logged_admin(FALSE)) {
			return FALSE;
		}
		*/
		if( ! $this->tank_auth->is_admin()) {
			return FALSE;
		}

		$this->db->where('idx', $gr_idx);
		if ($this->db->update($this->board_group_name, $data)) {
			$data['idx'] = $gr_idx;
			return $data;
		}
		return NULL;
	}

	// 게시판 그룹 삭제
	function delete_board_group($gr_code)
	{
		/*
		if($this->tank_auth->is_logged_admin(FALSE)) {
			return FALSE;
		}
		*/
		if( ! $this->tank_auth->is_admin()) {
			return FALSE;
		}

		$this->db->where('gr_code', $gr_code);
		$this->db->delete($this->board_group_name);
		if ($this->db->affected_rows() > 0) {
			return TRUE;
		}
		return FALSE;
	}





	/** - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	 * Create new board
	 *
	 * @param	array
	 * @param	bool
	 * @return	bool
	 */

	// 새로운 게시판 생성
	function make_board($data) {

		/*
		if($this->tank_auth->is_logged_admin(FALSE)) {
			return FALSE;
		}
		*/
		if( ! $this->tank_auth->is_admin()) {
			return FALSE;
		}

		// 게시판 코드
		$new_bo_code = $data['bo_code'];
		$new_bo_table = BBS_PRE. $new_bo_code;  // BBS_PRE: [bbs_]

		// 게시판 테이블 생성
		if( $this->create_table($new_bo_table) ) {


			/** 기존 자료실 삭제 - 한 번에 다 삭제는 안됨.. 또, 디렉토리 안에 하나라도 있으면 안되는 듯..
			 |rmdir(realpath(FCPATH).'/data/board/'.$new_bo_code.'/image/thumb/');
			 |rmdir(realpath(FCPATH).'/data/board/'.$new_bo_code.'/image/');
			 |rmdir(realpath(FCPATH).'/data/board/'.$new_bo_code.'/files/');
			 |rmdir(realpath(FCPATH).'/data/board/'.$new_bo_code);
			 */

			$old_umask = umask();
			umask(000);
			// 게시판 자료실 생성
			if( ! mkdir(realpath(FCPATH).'/data/board/'.$new_bo_code.'/files/', 0777, true) ) {
				return '업로드 폴더를 생성하지 못했습니다. 퍼미션을 확인하세요!';
				exit;
			}

			if( ! mkdir(realpath(FCPATH).'/data/board/'.$new_bo_code.'/files/thumb/', 0777, true) ) {
				return '업로드 폴더를 생성하지 못했습니다. 퍼미션을 확인하세요!';
				exit;
			}

			if( ! mkdir(realpath(FCPATH).'/data/board/'.$new_bo_code.'/image/', 0777, true) ) {
				return '업로드 폴더를 생성하지 못했습니다. 퍼미션을 확인하세요!';
				exit;
			}

			if( ! mkdir(realpath(FCPATH).'/data/board/'.$new_bo_code.'/image/thumb/', 0777, true) ) {
				return '업로드 폴더를 생성하지 못했습니다. 퍼미션을 확인하세요!';
				exit;
			}
			umask($old_umask);

			chmod(realpath(FCPATH).'/data/board/'.$new_bo_code, 0755);
			chmod(realpath(FCPATH).'/data/board/'.$new_bo_code.'/files/', 0777);
			chmod(realpath(FCPATH).'/data/board/'.$new_bo_code.'/files/thumb/', 0777);
			chmod(realpath(FCPATH).'/data/board/'.$new_bo_code.'/image/', 0777);
			chmod(realpath(FCPATH).'/data/board/'.$new_bo_code.'/image/thumb/', 0777);

			if ($this->db->insert($this->board_config_name, $data)) {
				$bo_idx = $this->db->insert_id();
				$data['idx'] = $bo_idx;
				return $data;
			}
		}

		return NULL;
	}

	function create_table($table_name) {

		/*
		if($this->tank_auth->is_logged_admin(FALSE)) {
			return FALSE;
		}
		*/
		if( ! $this->tank_auth->is_admin()) {
			return FALSE;
		}

		$this->load->dbforge();

		$wr_idx_fields = array(
				'wr_idx' => array(
						'type' => 'INT',
						'constraint' => 10,
						'unsigned' => TRUE,
						'auto_increment' => TRUE
				),
		);
		$this->dbforge->add_field($wr_idx_fields);

		//$this->dbforge->add_field('wr_idx INT(10) unsigned NOT NULL ');

		$this->dbforge->add_field('BOARDID varchar(50) NULL COLLATE "utf8_bin"');
		$this->dbforge->add_field('ORD int(10) NOT NULL');
		$this->dbforge->add_field('VIEW ENUM("Y","N") NULL DEFAULT "Y" COMMENT "Y/N"');
		$this->dbforge->add_field('APP ENUM("Y","N") NULL DEFAULT "Y" COMMENT "승인/미승인"');

		$this->dbforge->add_field('wr_num int(10) NOT NULL');
		$this->dbforge->add_field('wr_reply varchar(10) NOT NULL COLLATE "utf8_bin"');
		$this->dbforge->add_field('ca_code varchar(255) NOT NULL COLLATE "utf8_bin"');
		$this->dbforge->add_field('wr_comment int(10) unsigned NOT NULL');
		$this->dbforge->add_field("wr_option set('editor','secret','mail','nocomt') NOT NULL");

		$this->dbforge->add_field('opt_notice tinyint(2) unsigned NULL');
		$this->dbforge->add_field('opt_editor tinyint(2) unsigned NULL');
		$this->dbforge->add_field('opt_secret tinyint(2) unsigned NULL');
		$this->dbforge->add_field('opt_staff tinyint(2) unsigned NULL');

		$this->dbforge->add_field('wr_subject varchar(255) NOT NULL COLLATE "utf8_bin"');
		$this->dbforge->add_field('wr_content text NOT NULL COLLATE "utf8_bin"');
		$this->dbforge->add_field('wr_seo_title varchar(255) NOT NULL COLLATE "utf8_bin"');
		$this->dbforge->add_field('wr_hit int(10) unsigned NOT NULL');
		$this->dbforge->add_field('wr_link varchar(255) NOT NULL COLLATE "utf8_bin"');
		$this->dbforge->add_field('wr_link_target int(1) NOT NULL DEFAULT "1"');
		$this->dbforge->add_field('user_idx int(10) NOT NULL');
		$this->dbforge->add_field('wr_password char(128)  NULL COLLATE "utf8_bin"');
		$this->dbforge->add_field('wr_name varchar(100)  NULL COLLATE "utf8_bin"');
		$this->dbforge->add_field('wr_email varchar(200) NULL COLLATE "utf8_bin"');
		$this->dbforge->add_field('wr_mobile varchar(200) NULL COLLATE "utf8_bin"');

		$this->dbforge->add_field('regid varchar(200) NOT NULL COLLATE "utf8_bin"');
		$this->dbforge->add_field('wr_datetime datetime NOT NULL');
		$this->dbforge->add_field('uptid varchar(200) NOT NULL COLLATE "utf8_bin"');
		$this->dbforge->add_field('wr_last datetime NOT NULL');

		$this->dbforge->add_field('wr_ip varchar(20) NOT NULL COLLATE "utf8_bin"');
		$this->dbforge->add_field('wr_count_file tinyint(4) unsigned NOT NULL');
		$this->dbforge->add_field('wr_count_image tinyint(4) unsigned NOT NULL');

		$this->dbforge->add_field('del_yn varchar(10) NOT NULL DEFAULT "N" COLLATE "utf8_bin"');
		$this->dbforge->add_field('del_datetime varchar(10) NULL COLLATE "utf8_bin"');

		$this->dbforge->add_field('memo text NOT NULL COLLATE "utf8_bin"');
		$this->dbforge->add_field('addfld_1 varchar(255) NULL COLLATE "utf8_bin"');
		$this->dbforge->add_field('addfld_2 varchar(255) NULL COLLATE "utf8_bin"');
		$this->dbforge->add_field('addfld_3 varchar(255) NULL COLLATE "utf8_bin"');
		$this->dbforge->add_field('addfld_4 varchar(255) NULL COLLATE "utf8_bin"');
		$this->dbforge->add_field('addfld_5 varchar(255) NULL COLLATE "utf8_bin"');
		$this->dbforge->add_field('addfld_6 varchar(255) NULL COLLATE "utf8_bin"');
		$this->dbforge->add_field('addfld_7 varchar(255) NULL COLLATE "utf8_bin"');
		$this->dbforge->add_field('addfld_8 varchar(255) NULL COLLATE "utf8_bin"');
		$this->dbforge->add_field('addfld_9 varchar(255) NULL COLLATE "utf8_bin"');
		$this->dbforge->add_field('addfld_10 varchar(255) NULL COLLATE "utf8_bin"');

		$this->dbforge->add_key('wr_idx',true);
		$this->dbforge->add_key('wr_num');
		$this->dbforge->add_key('wr_reply');
		$this->dbforge->add_key('ca_code');
		$this->dbforge->add_key('opt_notice');

		$this->dbforge->add_key('user_idx');
		$this->dbforge->add_key('wr_name');
		$this->dbforge->add_key('wr_datetime');

		$this->dbforge->create_table($table_name, TRUE);

		return true;
	}


	// 게시판 수정
	function edit_board($bo_code,$data)
	{

		if( ! $this->tank_auth->is_admin()) {
			return NULL;
		}

		$this->db->where('bo_code', $bo_code);
		if ($this->db->update($this->board_config_name, $data)) {
			$data['bo_code'] = $bo_code;
			return $data;
		}
		return NULL;
	}


	// [1/2] 개별 게시판 삭제
	function delete_board($bo_code) {

		/*
		if($this->tank_auth->is_logged_admin(FALSE)) {
			return FALSE;
		}
		*/
		if( ! $this->tank_auth->is_admin()) {
			return FALSE;
		}


		// 게시판 삭제시 관련 설정, 업로드파일, 게시물, 코멘트 모두 삭제
		/*
		//$this->db->where('bo_code', $bo_code);
		//$this->db->delete(array('board_config', 'board_write', 'board_comment'));
		//$this->db->delete(array('board_config', 'board_comment'));
		*/


		$this->db->delete('board_config', array('bo_code'=>$bo_code));
		$this->db->delete('board_comment', array('bo_code'=>$bo_code));


		/*
		//$this->db->where('wr_table', $bo_code);
		//$this->db->delete(array('file_manager'));
		*/
		$this->db->delete('file_manager', array('wr_table'=>$bo_code));

		$this->load->dbforge();
		//$this->dbforge->drop_table($bo_codes);

		$bo_table = BBS_PRE . $bo_code;
        if( $this->dbforge->drop_table($bo_table) ) {
            // 기존 자료실 삭제 - 한 번에 다 삭제는 안됨.. 또, 디렉토리 안에 하나라도 있으면 안되는 듯..

			//$files = glob('path/to/temp/*'); // get all file names
			$files = glob(realpath(FCPATH).'/data/board/'.$bo_code.'/files/thumb/{,.}*', GLOB_BRACE);
			foreach($files as $file){ // iterate files
			  if(is_file($file))
				unlink($file); // delete file
			}
			rmdir(realpath(FCPATH).'/data/board/'.$bo_code.'/files/thumb');

			$files = glob(realpath(FCPATH).'/data/board/'.$bo_code.'/files/{,.}*', GLOB_BRACE);
			foreach($files as $file){ // iterate files
			  if(is_file($file))
				unlink($file); // delete file
			}
			rmdir(realpath(FCPATH).'/data/board/'.$bo_code.'/files');

			$files = glob(realpath(FCPATH).'/data/board/'.$bo_code.'/image/thumb/{,.}*', GLOB_BRACE);
			foreach($files as $file){ // iterate files
			  if(is_file($file))
				unlink($file); // delete file
			}
			rmdir(realpath(FCPATH).'/data/board/'.$bo_code.'/image/thumb');

			$files = glob(realpath(FCPATH).'/data/board/'.$bo_code.'/image/{,.}*', GLOB_BRACE);
			foreach($files as $file){ // iterate files
			  if(is_file($file))
				unlink($file); // delete file
			}
			rmdir(realpath(FCPATH).'/data/board/'.$bo_code.'/image');
			rmdir(realpath(FCPATH).'/data/board/'.$bo_code);

            //return "게시판이 삭제되었습니다.";
			return TRUE;
        }
        else {
            //return "게시판이 삭제되지 않았습니다.";
			return FALSE;
        }
	}



	// [2/2]여러 게시판 삭제
	function delete_boards($bo_codes) {

		/*
		if($this->tank_auth->is_logged_admin(FALSE)) {
			return FALSE;
		}
		*/
		if( ! $this->tank_auth->is_admin()) {
			return FALSE;
		}

		// 게시판 삭제시 관련 설정, 업로드파일, 게시물, 코멘트 모두 삭제
		$this->db->where_in('bo_code', $bo_codes);
		$this->db->delete(array('board_config', 'board_write', 'board_comment'));
		//$this->load->dbforge();

		$this->db->where_in('wr_table', $bo_codes);
		$this->db->delete(array('file_manager'));

		$this->load->dbforge();
		$is_delete = FALSE;

		foreach($bo_codes as $bo_code) {
			$bo_table = BBS_PRE . $bo_code;
			if( $this->dbforge->drop_table($bo_table) ) {

				$files = glob(realpath(FCPATH).'/data/board/'.$bo_code.'/files/thumb/{,.}*', GLOB_BRACE);
				foreach($files as $file){ // iterate file
				  if(is_file($file))
					unlink($file); // delete file
				}
				rmdir(realpath(FCPATH).'/data/board/'.$bo_code.'/files/thumb');

				$files = glob(realpath(FCPATH).'/data/board/'.$bo_code.'/files/{,.}*', GLOB_BRACE);
				foreach($files as $file){ // iterate file
				  if(is_file($file))
					unlink($file); // delete file
				}
				rmdir(realpath(FCPATH).'/data/board/'.$bo_code.'/files');

				$files = glob(realpath(FCPATH).'/data/board/'.$bo_code.'/image/thumb/{,.}*', GLOB_BRACE);
				foreach($files as $file){ // iterate file
				  if(is_file($file))
					unlink($file); // delete file
				}
				rmdir(realpath(FCPATH).'/data/board/'.$bo_code.'/image/thumb');

				$files = glob(realpath(FCPATH).'/data/board/'.$bo_code.'/image{,.}*', GLOB_BRACE);
				foreach($files as $file){ // iterate file
				  if(is_file($file))
					unlink($file); // delete file
				}
				rmdir(realpath(FCPATH).'/data/board/'.$bo_code.'/image');
				rmdir(realpath(FCPATH).'/data/board/'.$bo_code);

				$is_delete = TRUE;
			}
		}

		//return "선택하신 게시판이 모두 삭제되었습니다.";
		return $is_delete;
	}








	/** - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	 * Write on the bulletin board.
	 *
	 */

	// spam 체크

	function spam_check($bo_code=FALSE,$data=NULL) {

		$spamChk = false;

		// ★ ★ ★ ★ ★ ★ ★ ★ ★ ★ ★ ★ ★ ★ ★ ★ ★ ★ ★ ★ ★ ★ ★ ★ ★ ★ ★ ★ ★ ★ ★ ★ ★ ★ ★ ★ ★ ★ ★ ★ ★ ★ ★
		// 온라인상담 및 비용문의 게시판에서 글 작성시..  스팸 차단
		// ★ ★ ★ ★ ★ ★ ★ ★ ★ ★ ★ ★ ★ ★ ★ ★ ★ ★ ★ ★ ★ ★ ★ ★ ★ ★ ★ ★ ★ ★ ★ ★ ★ ★ ★ ★ ★ ★ ★ ★ ★ ★ ★
		//if('csb004' == $bo_code OR 'csb005' == $bo_code ) 
		if('csb005' == $bo_code ) 
		{

			// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
			// 스팸성 글 필터링
			// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
			//$spamChk = false;

			// [2020-05-05] 비정상적인 경우 접근 차단
			$chk_wr_name = (isset($data['wr_name']) && '' != $data['wr_name']) ? $data['wr_name'] : $this->input->post('wr_name');
			$chk_wr_mobile = (isset($data['wr_mobile']) && '' != $data['wr_mobile']) ? $data['wr_mobile'] : $this->input->post('wr_mobile');
			$chk_wr_content = (isset($data['wr_content']) && '' != $data['wr_content']) ? $data['wr_content'] : $this->input->post('wr_content');
			$wr_email = (isset($data['wr_email']) && '' != $data['wr_email']) ? $data['wr_email'] : $this->input->post('wr_email');


			// 한글이 없다면.. 
			$nohanchk = false;
			if(! preg_match("/[\xE0-\xFF][\x80-\xFF][\x80-\xFF]/", $chk_wr_name)) {
				$nohanchk = true; 
			}
			$regname_len = isset($chk_wr_name) ? strlen($chk_wr_name) : 0;
		
			$mobile_chk = isset($chk_wr_mobile) ? substr($chk_wr_mobile,0,2) : false;
			$mobile_len = isset($chk_wr_mobile) ? strlen($chk_wr_mobile) : 0;
			$msg_chk = isset($chk_wr_content) ? strpos($chk_wr_content,'http') : false;

			if($nohanchk OR $regname_len > 21  OR  '01' != $mobile_chk  OR  $mobile_len < 10 OR $mobile_len > 11  OR  $msg_chk !== false) {
				$spamChk = true;

				// 스팸으로 판단하여 작성 차단
				//return false;
				//return NULL;

					$inserted_idx = '';

					// 비용문의 게시판에서 글 작성시.. 스팸글 작성 후 redirect
					if('csb005' == $bo_code) 
					{
						$soft_refer = $this->input->post('refer','A') ? '_'.$this->input->post('refer','A') : '_A';  // _A
						$dataSoft = array(
							'Gubun'    => $soft_refer,
							'Cust_Name'    => $chk_wr_name,
							'Cust_Phone'    => $chk_wr_mobile,
							'Email'    => $wr_email,
							'contents'    => $chk_wr_content,
							'MakeDate'  => TIME_YMDHIS,
							'event_cost'    => 'cost',
							'event_cost_idx'    => $inserted_idx
						);
						// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
						// 스팸성 글 필터링
						// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
						$this->board_model->softTelemanager_write($dataSoft);
					}



				$refer = $_SERVER['HTTP_REFERER'];
				//$redirect_url = $this->bbs_code_url .'/write/';
				$redirect_url = $refer;
				redirect($redirect_url);
				exit;
			}

		}


	}

	// 글 쓰기
	function write($bo_code=FALSE,$wr_idx=FALSE,$data=NULL,$mode='write',$bo_notice_idxs='')
	{

		// 스팸체크
		//$this->spam_check($bo_code,$data);

		// 게시판 테이블명
		$bo_table = BBS_PRE. $bo_code;  // BBS_PRE: [bbs_]

		// 게시글 수정
		if(('update'===$mode) && $bo_code && $wr_idx && $data) {
			$this->db->where(array('wr_idx'=>$wr_idx));
			if ($this->db->update($bo_table, $data)) {
				$data['wr_idx'] = $wr_idx;
				//return $data;
			}
		}
		// 새 글 작성
		else if(('write'===$mode) && $bo_code && $data) {
			if ($this->db->insert($bo_table, $data)) {
				$wr_idx = $this->db->insert_id();
				$data['wr_idx'] = $wr_idx;
				//return $data;
			}
		}
		// 답변글 작성
		else if(('reply'===$mode) && $bo_code && $data) {
			if ($this->db->insert($bo_table, $data)) {
				$wr_idx = $this->db->insert_id();
				$data['wr_idx'] = $wr_idx;
				//return $data;
			}
		}

		//echo $this->db->last_query();
		//exit;


		// 공지사항 체크는 관리자만
		if ( $this->tank_auth->is_sadmin() OR $this->tank_auth->is_admin() ) {

			$chk_notice = $data['opt_notice'];
			$bo_notice = $bo_notice_idxs;
			$notice_array = explode(',', trim($bo_notice_idxs));

			if($chk_notice) {
				if($mode === 'write') {
					$bo_notice = $wr_idx.','.$bo_notice_idxs;
				}
				else {
					if (!in_array((int)$wr_idx, $notice_array))
						$bo_notice = $wr_idx.','.$bo_notice_idxs;
				}
			}
			else {
				$nokey = array_search((int)$wr_idx, $notice_array);
				if (is_int($nokey)) {
					unset($notice_array[(int)$nokey]);
					$bo_notice = implode(',', $notice_array);
				}
			}

			$this->db->where('bo_code', $bo_code);
			$this->db->update('board_config',array('bo_notice_idxs'=>$bo_notice));
		}

		return $data;
		//return NULL;
	}


	// 공지사항 체크 글 번호를 board_config 에 업데이트
	function update_notice_in_board_config($bo_code,$bo_notice) {
		if($this->tank_auth->is_admin()) {
			$this->db->where('bo_code', $bo_code);
			$this->db->update('board_config',array('bo_notice_idxs'=>$bo_notice));
		}
	}


	// 조회수 증가
	function hit_update($bo_table, $wr_idx) {
		$this->db->set('wr_hit', 'wr_hit + 1', FALSE);
		$this->db->update($bo_table, null, array('wr_idx' => $wr_idx));
	}

	
	// 추천수 증가
	function recommand_update($bo_table, $wr_idx) {
		$this->db->set('wr_recommand', 'wr_recommand + 1', FALSE);
		$this->db->update($bo_table, null, array('wr_idx' => $wr_idx));
	}



	// 업로드 파일 수량 업데이트
	function cnt_file_update($bo_table, $wr_idx, $file_data) {
		$this->db->where('wr_idx', $wr_idx);
		$this->db->update($bo_table,$file_data);
	}


	function write_delete($bo_table=FALSE,$wr_idx=FALSE)
	{
		$this->db->where('wr_idx', $wr_idx);
		$this->db->delete($bo_table);
		if ($this->db->affected_rows() > 0) {
			return TRUE;
		}
		return FALSE;
	}
















	// 게시판의 최대 ORD 숫자를 얻는다.
	function get_max_ord($bo_code) {

		// 게시판 테이블명
		$bo_table = BBS_PRE. $bo_code;  // BBS_PRE: [bbs_]

	    // 가장 큰 번호를 얻어
	    $this->db->select_max('ORD', 'max_ord_num');
	    $row = $this->db->get_where($bo_table)->row();

	    return $row->max_ord_num;
	}




	// 게시판의 최소 wr_num을 얻는다.
	function get_min_num($bo_code) {

		// 게시판 테이블명
		$bo_table = BBS_PRE. $bo_code;  // BBS_PRE: [bbs_]

	    // 가장 작은 번호를 얻어
	    $this->db->select_min('wr_num', 'min_wr_num');
	    $row = $this->db->get_where($bo_table)->row();

	    return $row->min_wr_num;
	}

	// 답변 단계 얻기
	function get_reply_step($bo_code, $wr_num, $bo_reply_order=FALSE, $wr_reply) {

		// 게시판 테이블명
		$bo_table = BBS_PRE. $bo_code;  // BBS_PRE: [bbs_]

		$reply_len = strlen($wr_reply) + 1;

		if ($bo_reply_order) {
			$begin_reply_char = 'A';
			$end_reply_char = 'Z';
			$reply_number = +1;

			$this->db->select_max(' SUBSTRING(wr_reply, '.$reply_len.', 1) ', 'reply');
		}
		else {
			$begin_reply_char = 'Z';
			$end_reply_char = 'A';
			$reply_number = -1;

			$this->db->select_min(' SUBSTRING(wr_reply, '.$reply_len.', 1) ', 'reply');
		}

        $this->db->where(array(
			'wr_num' => $wr_num,
			'SUBSTRING(wr_reply, '.$reply_len.', 1) <>' => ''
		));

		if ($wr_reply)
			$this->db->like('wr_reply', $wr_reply, 'after');

		$row = $this->db->get($bo_table)->row_array();

		if (!isset($row['reply']))
			$reply_char = $begin_reply_char;
		else if ($row['reply'] == $end_reply_char) // A~Z은 26 입니다.
			alert("더 이상 답변하실 수 없습니다.\\n\\n답변은 26개 까지만 가능합니다.");
		else
			$reply_char = chr(ord($row['reply']) + $reply_number);

		return $wr_reply.$reply_char;
	}










	// 코멘트 삭제
	function cmt_del($cmt_idx=FALSE) {

		if(! $this->tank_auth->is_logged_in()) {
			return FALSE;
		}

		$this->db->where('idx', $cmt_idx);
		$this->db->delete('board_comment');
		if ($this->db->affected_rows() > 0) {
			return TRUE;
		}
		return FALSE;

	}

	// 코멘트 쓰기
	function cmt_write($bo_code=FALSE,$wr_idx=FALSE,$data=NULL,$mode='write',$cmt_idx=FALSE)
	{

		// 코멘트 테이블명
		$cmt_table = 'board_comment';


		// 새 코멘트 작성
		if(('write'===$mode) && $bo_code && $data) {
			if ($this->db->insert($cmt_table, $data)) {
				$cmt_idx = $this->db->insert_id();
				$this->db->where('idx', $cmt_idx);
				$this->db->update($cmt_table,array('parent'=>$cmt_idx));
				return $cmt_idx;
			}
			return false;
		}
		// 코멘트 수정
		else if(('update'===$mode) && $bo_code && $cmt_idx && $data) {
			$this->db->where(array('idx'=>$cmt_idx));
			if( $this->db->update($cmt_table, $data) )
				return $cmt_idx;
			else 
				return false;
		}
		// 답변글 작성
		else if(('reply'===$mode) && $bo_code && $data) {
			if ($this->db->insert($cmt_table, $data)) {
				$cmt_idx = $this->db->insert_id();
				return $cmt_idx;
			}
		}
		else {
			return false;
		}
	}



	function event_contact_write($bo_code=FALSE,$wr_idx=FALSE,$data=FALSE) {

		// 신청 내용 작성
		if($bo_code && $data) {
			if ($this->db->insert('event_request', $data)) {
				return $this->db->insert_id();
			}
			return false;
		}

	}

	// softTelemanager_write
	function softTelemanager_write($data=FALSE) {

		// 신청 내용 작성
		if($data) {

			// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
			// 스팸성 글 필터링
			// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
			$spamChk = false;

			// [2020-05-05] 비정상적인 경우 접근 차단
			// 한글이 없다면.. 
			$nohanchk = false;
			if(! preg_match("/[\xE0-\xFF][\x80-\xFF][\x80-\xFF]/", $data['Cust_Name'])) {
				$nohanchk = true; 
			}
			$regname_len = isset($data['Cust_Name']) ? strlen($data['Cust_Name']) : 0;
			$mobile_chk = isset($data['Cust_Phone']) ? substr($data['Cust_Phone'],0,2) : false;
			$mobile_len = isset($data['Cust_Phone']) ? strlen($data['Cust_Phone']) : 0;
			$msg_chk = isset($data['contents']) ? strpos($data['contents'],'http') : false;
			if($nohanchk OR $regname_len > 21  OR  '01' != $mobile_chk  OR  $mobile_len < 10 OR $mobile_len > 11  OR  $msg_chk !== false) {
				$spamChk = true;
			}


			// 신청 내용 작성 ==> SoftTelemanager
			$tbl_softtelemanager = ($spamChk) ? 'SoftTelemanager_spam' : 'SoftTelemanager';
			if($spamChk) {
				$data['ip'] = REMOTE_ADDR;
				$data['ip2'] = $this->input->ip_address();
			}

			$refer = $_SERVER['HTTP_REFERER'];
			$data['refer'] = $refer;


			
			/* 
			###+++++++++++++++++++++++++++++++++###
			// 구 웹사이트 DB(eoseye.co.kr)
			$data_cokr = $data;
			unset($data_cokr['event_cost']);
			unset($data_cokr['event_cost_idx']);
			$this->eoseyecokr_db = $this->load->database('eoseyecokr', true);
			$this->eoseyecokr_db->insert($tbl_softtelemanager, $data_cokr);

			// Complete SQL transaction.
			$this->eoseyecokr_db->trans_complete();
			###+++++++++++++++++++++++++++++++++###
			*/





			// 신청 내용 작성
			if ($this->db->insert($tbl_softtelemanager, $data)) {
				return $this->db->insert_id();
			}
			return false;
		}
		else 
			return false;

	}



	// 랜딩페이지
	function landing_write($data=FALSE) {

		// 신청 내용 작성
		if ($this->db->insert('TBL_LAND_REQ', $data)) {
			return $this->db->insert_id();
		}
		return false;

	}



	// [2020-06-01] 비용문의
	function request_write($data=FALSE) {

		// 스팸체크
		$this->spam_check('csb005',$data);

		if ($this->db->insert('bbs_csb005', $data)) {
			return $this->db->insert_id();
		}
		return false;
	}

	// [2020-05-20] 비용문의
	function _request_write($data=FALSE,$dataSoft=FALSE,$spamChk=FALSE) {

		$tbl_softtelemanager = ($spamChk) ? 'SoftTelemanager_spam' : 'SoftTelemanager';

		/*
		// 신청 내용 작성 ==> SoftTelemanager
		if ($this->db->insert($tbl_softtelemanager, $dataSoft)) {
			// 신청 내용 작성
			$this->db->insert('bbs_csb005', $data);
			return $this->db->insert_id();
		}
		*/

		// 신청 내용 작성 ==> SoftTelemanager
		if ($this->db->insert('bbs_csb005', $data)) {
			$dataSoft['event_cost'] = 'cost';
			$dataSoft['event_cost_idx'] = $this->db->insert_id();
			// 신청 내용 작성
			$this->db->insert($tbl_softtelemanager, $dataSoft);
			return $this->db->insert_id();
		}

		return false;
	}





}