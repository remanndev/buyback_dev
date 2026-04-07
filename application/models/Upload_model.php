<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Upload_model extends CI_Model
{

	function __construct()
	{
		parent::__construct();

		$ci =& get_instance();
	}


	/**
	 * - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	 * upload file information save
	 * - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	*/
	function insert_file_manager($data)
	{
			if ($this->db->insert('file_manager', $data)) {
				$idx = $this->db->insert_id();
				$data['idx'] = $idx;
				return $data;
			}
			return NULL;
	}

	function edit_file_manager($data,$wr_table=FALSE,$wr_table_idx=FALSE,$order=FALSE,$file_index=FALSE)
	{
		$sql_from = 'file_manager';

		if($file_index) {
			$this->db->where(array('idx'=>$file_index));
			if ($this->db->update('file_manager', $data)) {
				$data['idx'] = $file_index; // file idx
				return $data;
			}
		}
		else {
			$sql_where = array('wr_table'=>$wr_table,'wr_table_idx'=>$wr_table_idx,'order'=>$order);
			$row = $this->basic_model->arr_get_row(array('sql_select'=>'*', 'sql_from'=>$sql_from, 'sql_where'=>$sql_where));
			$this->db->where(array('wr_table'=>$wr_table,'wr_table_idx'=>$wr_table_idx,'order'=>$order));

			if ($this->db->update('file_manager', $data)) {
				$data['idx'] = isset($row->idx) ? $row->idx : ''; // file idx
				return $data;
			}
		}


		/*
		$sql_from = 'file_manager';
		$sql_where = array('wr_table'=>$wr_table,'wr_table_idx'=>$wr_table_idx,'order'=>$order);
		$order_cnt = $this->basic_model->get_common_count($sql_from, $sql_where);

		if($order_cnt) { // order 파일이 있으면 기존 파일 수정, 없으면 신규 파일
			$row = $this->basic_model->arr_get_row(array('sql_select'=>'*', 'sql_from'=>$sql_from, 'sql_where'=>$sql_where));
			$this->db->where(array('wr_sess'=>$file_write_sess,'wr_table'=>$wr_table));
			if ($this->db->update('file_manager', $data)) {
				$data['idx'] = isset($row->idx) ? $row->idx : ''; // file idx
				return $data;
			}
		}
		else {
			if ($this->db->insert('file_manager', $data)) {
				$idx = $this->db->insert_id();
				$data['idx'] = $idx; // file idx
				return $data;
			}
		}
		*/
		return NULL;
	}


	function update_file_manager($file_write_sess=FALSE,$wr_table=FALSE,$wr_table_idx=FALSE,$delete_sess=TRUE)
	{

			if(! $file_write_sess  OR  ! $wr_table  OR  ! $wr_table_idx)
				return NULL;

			$data = array(
				'wr_sess' => '',
				'wr_table_idx' => $wr_table_idx,
				'datetime_save' => TIME_YMDHIS
				);

			$this->db->where(array('wr_sess'=>$file_write_sess,'wr_table'=>$wr_table));
			if ($this->db->update('file_manager', $data)) {

				if($delete_sess) {
					// 파일 정보 저장을 위한 고유 세션 정보 삭제
					$this->delete_session_file_manager();
				}
				return $data;
			}
			return NULL;
	}

	// 수기 입력한 다운로드 파일의 타이틀 저장
	function update_file_title($wr_table=FALSE,$wr_table_idx=FALSE,$file_title=FALSE,$down_no=FALSE)
	{

			if(! $wr_table  OR  ! $wr_table_idx  OR  ! $down_no)
				return NULL;

			$data = array(
				'title' => $file_title
				);

			$this->db->where(array('wr_table'=>$wr_table,'wr_table_idx'=>$wr_table_idx, 'gubun'=>'download', 'down_no'=>$down_no));
			if ($this->db->update('file_manager', $data)) {
				return $data;
			}
			return NULL;
	}


	// [2019-01-30] 먼저 업로드 후, 업로드 메시지를 talks 테이블에 저장하고, talks_idx 값을 file_manager 에 업데이트 하기 위한 용도
	function update_file_manager_talks($file_write_sess=FALSE,$wr_table=FALSE,$wr_table_idx=FALSE,$delete_sess=TRUE)
	{

			if(! $file_write_sess  OR  ! $wr_table  OR  ! $wr_table_idx)
				return NULL;

			$data = array(
				'wr_sess' => '',
				'wr_table'=>$wr_table,
				'wr_table_idx' => $wr_table_idx,
				'datetime_save' => TIME_YMDHIS
				);

			$this->db->where(array('wr_sess'=>$file_write_sess));
			if ($this->db->update('file_manager', $data)) {

				if($delete_sess) {
					// 파일 정보 저장을 위한 고유 세션 정보 삭제
					$this->delete_session_file_manager();
				}
				return $data;
			}
			return NULL;
	}



	function delete_session_file_manager()
	{

		// 파일 정보 저장을 위한 고유 세션 정보 삭제
		$user_idx = $this->tank_auth->get_user_id();
		$this->session->unset_userdata('ss_file_'.$user_idx);

	}


	// 파일 삭제
	function delete_file_manager($file_idx=FALSE,$table=FALSE,$table_idx=FALSE,$sql_where=FALSE)
	{
			$user_idx = $this->tank_auth->get_user_id();

			if( $sql_where ) :
				$arr = array('sql_select' => '*','sql_from' => 'file_manager','sql_where' => $sql_where);
				$result = $this->basic_model->arr_get_result($arr);
			elseif( $file_idx ) :
				$arr = array('sql_select' => '*','sql_from' => 'file_manager','sql_where' => array('idx'=>$file_idx));
				$result = $this->basic_model->arr_get_result($arr);
			elseif($table && $table_idx) :
				$arr = array('sql_select' => '*','sql_from' => 'file_manager','sql_where' => array('wr_table'=>$table,'wr_table_idx'=>$table_idx));
				$result = $this->basic_model->arr_get_result($arr);
			else :
				return FALSE;
			endif;

			foreach($result['qry'] as $i => $row) {

				// 업로드 본인이거나, 관리자이면 파일 삭제 및 디비 삭제
				if( (isset($row->user_idx) && ($row->user_idx == $user_idx)) OR $this->tank_auth->is_admin() )
				{
					$file = DATA_PATH .'/'. $row->file_dir .'/'. $row->file_name;  // 파일 경로

					if(is_file($file)) {  // 파일이 존재하면
						if(unlink($file)) {  // 파일 삭제
							// 파일이 삭제되면, 디비에서도 파일 정보 삭제
							$this->db->where('idx', $row->idx);
							$this->db->delete('file_manager');
						}
					}
					else {
							// 파일이 존재하지 않으면, 디비에서도 파일 정보 삭제
							$this->db->where('idx', $row->idx);
							$this->db->delete('file_manager');
					}
				}

			}
			return TRUE;
	}



	// 세션이 남아있는 파일의 세션 갱신
	function update_file_session($file_idx=FALSE,$sess_file_write=FALSE)
	{

		//return $file_idx .'/'. $sess_file_write;
		//exit;


			$user_idx = $this->tank_auth->get_user_id();
			if( $file_idx ) {
				$row = $this->basic_model->get_common_row('row','*','file_manager',FALSE,FALSE,FALSE,array('idx'=>$file_idx),FALSE,FALSE,FALSE);

				// 업로드 본인이면 파일 세션 갱신
				if( (isset($row->wr_sess) && '' !== $row->wr_sess) && (isset($row->user_idx) && ($row->user_idx === $user_idx)) )
				{
					$data = array('wr_sess' => $sess_file_write);
					$this->db->where('idx',$file_idx);
					$this->db->update('file_manager', $data);

					//return $this->db->last_query();

				}
			}

			return TRUE;
	}



}