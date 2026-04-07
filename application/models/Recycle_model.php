<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Recycle_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();

		//$ci =& get_instance();
		$this->tbl_recycle_place = 'recycle_place';
		$this->tbl_recycle_request = 'recycle_request';
	}




	/** - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	 * Check if place code available for registering
	 *
	 * @param	string
	 * @return	bool
	 */
	function is_place_code_available($table='',$field='',$value='')
	{
		$this->db->select('1', FALSE);
		$this->db->where('LOWER('.$field.')=', strtolower($value));

		$query = $this->db->get($table);

		return $query->num_rows() == 0;
	}





	/** - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	 * Create new place code
	 *
	 * @param	array
	 * @param	bool
	 * @return	array
	 */

	// 장소 코드 생성
	function make_place_code($data)
	{
		if( ! $this->tank_auth->is_admin()) {
			return FALSE;
		}

		if ($this->db->insert($this->tbl_recycle_place, $data)) {
			$pl_idx = $this->db->insert_id();
			$data['idx'] = $pl_idx;
			return $data;
		}
		return NULL;
	}


	// 장소 코드 삭제
	function delete_place_code($pl_code,$data)
	{
		if( ! $this->tank_auth->is_admin()) {
			return FALSE;
		}

		/* 완전 삭제
		$this->db->where('pl_code', $pl_code);
		$this->db->delete($this->tbl_recycle_place);
		if ($this->db->affected_rows() > 0) {
			return TRUE;
		}
		return FALSE;
		*/


		/* [필요한 경우에만 사용할 것]
		 * qrcode 이미지 삭제 */
		/*
		$arr = array('sql_select'     => '*','sql_from'       => $this->tbl_recycle_place,'sql_where'      => array('pl_code' => $pl_code));
		$row = $this->basic_model->arr_get_row($arr);
		$file = realpath(FCPATH).'/'.$row->qrcode_dir.$row->qrcode;
		if(is_file($file)) {  // 파일이 존재하면
			unlink($file);  // 파일 삭제
		}
		*/


		/* 업데이트로 삭제 처리 */
		$this->db->where('pl_code', $pl_code);
		if ($this->db->update($this->tbl_recycle_place, $data)) {
			$data['pl_code'] = $pl_code;
			return $data;
		}
		return NULL;
	}




	// 장소 코드 수정
	function update_place_code($pl_idx, $data)
	{
		if( ! $this->tank_auth->is_admin()) {
			return FALSE;
		}

		$this->db->where('idx', $pl_idx);
		if ($this->db->update($this->tbl_recycle_place, $data)) {
			$data['idx'] = $pl_idx;
			return $data;
		}
		return NULL;
	}




}