<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class MY_Form_validation extends CI_Form_validation {

	// --------------------------------------------------------------------

	/**
	 * Match one field to another
	 *
	 * [언어설정] 참고
	 * $lang['duplicate']			= "%s 필드의 중복 검사는 필수입니다.";
	 *
	 * @access	public
	 * @param	string
	 * @param	field
	 * @return	bool
	 */
	public function duplicate($str, $field)
	{
		if ( ! isset($_POST[$field]))
		{
			return FALSE;
		}

		$field = $_POST[$field];

		return ($str !== $field) ? FALSE : TRUE;
	}




}