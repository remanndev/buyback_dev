<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Cms_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();

	}

	// 신규
	function write_cms($data)
	{
		if($this->tank_auth->is_logged_admin(FALSE)) {
			return FALSE;
		}

		if ($this->db->insert('mng_cms', $data)) {
			$idx = $this->db->insert_id();
			$data['idx'] = $idx;
			return $data;
		}
		return NULL;
	}

	// 수정
	function edit_cms($pagecode,$data)
	{
		if($this->tank_auth->is_logged_admin(FALSE)) {
			return FALSE;
		}

		$this->db->where('page_code', $pagecode);
		if ($this->db->update('mng_cms', $data)) {
			$data['page_code'] = $pagecode;
			return $data;
		}
		return NULL;
	}


	// 삭제
	function delete_cms($pagecode,$data)
	{
		if($this->tank_auth->is_logged_admin(FALSE)) {
			return FALSE;
		}

		// 하위에 하나라도 삭제되지 않은 것이 있으면 삭제 불가.
		$this->db->select('1', FALSE);
		$this->db->where('parent_code',$pagecode);
		$this->db->where('del_datetime',NULL);
		$query = $this->db->get('mng_cms');
		if($query->num_rows() > 0) {
			// 하위에 하나라도 삭제되지 않은 것이 있으면 삭제 불가.
			return 'deny';
		}
		else if($query->num_rows() == 0) {
			$this->db->where('page_code', $pagecode);
			if ($this->db->update('mng_cms', $data)) {
				$data['page_code'] = $pagecode;
				return $data;
			}
		}
		else {
			return NULL;
		}
		return NULL;
	}






	// write_contents
	function write_contents($data=FALSE) {
		if($this->tank_auth->is_logged_admin(FALSE)) {
			return FALSE;
		}

		if ($this->db->insert('mng_contents', $data)) {
			$idx = $this->db->insert_id();
			$data['idx'] = $idx;
			return $data;
		}
		return NULL;
	}

	// 수정
	function edit_contents($idx,$data)
	{
		if($this->tank_auth->is_logged_admin(FALSE)) {
			return FALSE;
		}

		$this->db->where('idx', $idx);
		if ($this->db->update('mng_contents', $data)) {
			$data['idx'] = $idx;
			return $data;
		}
		return NULL;
	}



	// 삭제
	function del_contents($idx,$data)
	{
		if($this->tank_auth->is_logged_admin(FALSE)) {
			return FALSE;
		}

		$this->db->where('idx', $idx);
		if ($this->db->update('mng_contents', $data)) {
			$data['idx'] = $idx;
			return $data;
		}
		return NULL;
	}












	// write_contents
	function write_landing($data=FALSE) {
		if($this->tank_auth->is_logged_admin(FALSE)) {
			return FALSE;
		}

		if ($this->db->insert('mng_landing', $data)) {
			$idx = $this->db->insert_id();
			$data['idx'] = $idx;
			return $data;
		}
		return NULL;
	}

	// 수정
	function edit_landing($idx,$data)
	{
		if($this->tank_auth->is_logged_admin(FALSE)) {
			return FALSE;
		}

		$this->db->where('idx', $idx);
		if ($this->db->update('mng_landing', $data)) {
			return $data;
		}
		return NULL;
	}



	// 랜딩 페이지를 삭제
	function del_landing($idx,$data)
	{
		if($this->tank_auth->is_logged_admin(FALSE)) {
			return FALSE;
		}

		$this->db->where('idx', $idx);
		if ($this->db->update('mng_landing', $data)) {
			$data['idx'] = $idx;
			return $data;
		}
		return NULL;
	}


	// 개별 신청/문의 내역을 삭제
	function del_landing_req_code($idx,$data)
	{
		if($this->tank_auth->is_logged_admin(FALSE)) {
			return FALSE;
		}

		$this->db->where('idx', $idx);
		if ($this->db->update('landing', $data)) {
			$data['idx'] = $idx;

			$arr = array('sql_select'=>'code','sql_from'=>'landing','sql_where'=>array('idx'=>$idx));
			$row = $this->basic_model->arr_get_row($arr);
			$data['code'] = $row->code;

			return $data;
		}
		return NULL;
	}











}