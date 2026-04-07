<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Recycle
 */
class Recycle_lib
{
	private $error = array();

	function __construct()
	{
		$this->ci =& get_instance();

		$this->ci->load->config('tank_auth', TRUE);
		$this->ci->load->database();
		$this->ci->load->model('tank_auth/users');

		$this->ci->load->model('recycle_model');
		$this->ci->load->model('upload_model');

		$this->ci->username = $this->ci->tank_auth->get_username();

		// table
		$this->tbl_recycle_place = 'recycle_place';
		$this->tbl_recycle_request = 'recycle_request';
		$this->tbl_file_manager = 'file_manager';
	}



	/** - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	 * 장소 코드 중복 체크
	 */

	function is_place_code_available($table='',$field='',$value='')
	{
		return ((strlen($table) > 0) AND (strlen($field) > 0) AND (strlen($value) > 0) AND $this->ci->recycle_model->is_place_code_available($table,$field,$value));
	}



	/** - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	 * 장소 관리
	 */

	// 장소 정보 추가
	function make_place_code($pl_code='',$pl_name='')
	{
		if($pl_code && $pl_name)
		{
			$data = array(
				'pl_code'       => $pl_code,
				'pl_name'       => $pl_name,
				'memo'          => $this->ci->input->post('memo', ''),
				'reg_datetime'  => TIME_YMDHIS,
				'reg_admin'     => $this->ci->username,
			);

			if (!is_null($res = $this->ci->recycle_model->make_place_code($data))) {
				return $res;
			}
		}

		return NULL;
	}


	// 장소 코드 삭제
	function delete_place_code($pl_code=FALSE)
	{

		if( ! $this->ci->tank_auth->is_admin()) {
			return FALSE;
		}

		if ($pl_code && ! ($this->ci->recycle_lib->is_place_code_available($this->tbl_recycle_place,'pl_code',$pl_code))) {

			$data = array(
				'del_datetime'  => TIME_YMDHIS,
				'del_admin'     => $this->ci->username,
			);

			return $this->ci->recycle_model->delete_place_code($pl_code,$data);
		}
		return NULL;
	}


	// 장소 코드 업데이트
	function update_place_code($pl_idx='',$data=array())
	{

		$data['memo'] = $this->ci->input->post('memo', '');
		$data['edit_datetime'] = TIME_YMDHIS;
		$data['edit_admin'] = $this->ci->username;

		if (!is_null($res = $this->ci->recycle_model->update_place_code($pl_idx,$data))) {
			return $data;
		}
	}

}