<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Users
 *
 * This model represents user authentication data. It operates the following tables:
 * - user account data,
 * - user profiles
 *
 * @package	Tank_auth
 * @author	Ilya Konyukhov (http://konyukhov.com/soft/)
 */
class Users extends CI_Model
{
	private $admin_fields			= NULL;
	private $table_name			= 'users';			// user accounts
	private $profile_table_name	= 'user_profiles';	// user profiles
	private $admin_table_name			= 'users_admin';			// admin user accounts
	private $inven_table_name			= 'erp_inventory';			// 재고

	private $npo_table_name			= 'npo_list';			// 재고

	function __construct()
	{
		parent::__construct();

		$ci =& get_instance();
		$this->table_name			= $ci->config->item('db_table_prefix', 'tank_auth').$this->table_name;
		$this->profile_table_name	= $ci->config->item('db_table_prefix', 'tank_auth').$this->profile_table_name;

		//$this->inven_table_name	= $ci->config->item('db_table_prefix', 'tank_auth').$this->inven_table_name;
	}

	/**
	 * Get user record by Id
	 *
	 * @param	int
	 * @param	bool
	 * @return	object
	 */
	function get_user_by_id($user_id, $activated)
	{
		$this->db->where('id', $user_id);
		$this->db->where('activated', $activated ? 1 : 0);

		$query = $this->db->get($this->table_name);
		if ($query->num_rows() == 1) return $query->row();
		return NULL;
	}

	function get_profile_by_id($user_id)
	{
		$this->db->where('user_id', $user_id);

		$query = $this->db->get($this->profile_table_name);
		if ($query->num_rows() == 1) return $query->row();
		return NULL;
	}


	/**
	 * Get user record by login (username or email)
	 *
	 * @param	string
	 * @return	object
	 */
	/*
	function get_user_by_login($login)
	{
		$this->db->where('LOWER(username)=', strtolower($login));
		$this->db->or_where('LOWER(email)=', strtolower($login));

		$query = $this->db->get($this->table_name);
		if ($query->num_rows() == 1) return $query->row();
		return NULL;
	}
	*/

	function get_user_by_login($login='')
	{
	  if('' != $login) {
		$this->db->where('LOWER(username)=', strtolower($login));
		$this->db->or_where('LOWER(email)=', strtolower($login));

		$query = $this->db->get($this->table_name);
		if ($query->num_rows() == 1) return $query->row();
	  }
	  return NULL;
	}

	/**
	 * Get user record by username
	 *
	 * @param	string
	 * @return	object
	 */
	function get_user_by_username($username)
	{
		$this->db->where('LOWER(username)=', strtolower($username));

		$query = $this->db->get($this->table_name);
		if ($query->num_rows() == 1) return $query->row();
		return NULL;
	}

	/**
	 * Get user record by email
	 *
	 * @param	string
	 * @return	object
	 */
	function get_user_by_email($email)
	{
		$this->db->where('LOWER(email)=', strtolower($email));

		$query = $this->db->get($this->table_name);
		if ($query->num_rows() == 1) return $query->row();
		return NULL;
	}




	/**
	 * Get user record by Id
	 *
	 * @param	int
	 * @param	bool
	 * @return	object
	 */
	function get_admin_by_id($user_id, $activated)
	{
		$this->db->where('id', $user_id);
		$this->db->where('activated', $activated ? 1 : 0);
		$this->db->where('deleted', NULL);

		$query = $this->db->get($this->admin_table_name);
		if ($query->num_rows() == 1) return $query->row();
		return NULL;
	}

	function get_admin_by_username($username, $activated)
	{
		$this->db->where('username', $username);
		$this->db->where('activated', $activated ? 1 : 0);
		$this->db->where('deleted', NULL);

		$query = $this->db->get($this->admin_table_name);
		if ($query->num_rows() == 1) return $query->row();
		return NULL;
	}






	/**
	 * Check if username available for registering
	 *
	 * @param	string
	 * @return	bool
	 */
	function is_username_available($username)
	{
		$this->db->select('1', FALSE);
		$this->db->where('LOWER(username)=', strtolower($username));

		$query = $this->db->get($this->table_name);
		return $query->num_rows() == 0;
	}
	function is_admin_available($username)
	{
		$this->db->select('1', FALSE);
		$this->db->where('LOWER(username)=', strtolower($username));

		$query = $this->db->get($this->admin_table_name);
		return $query->num_rows() == 0;
	}


	/**
	 * Check if username available for registering
	 *
	 * @param	string
	 * @return	bool
	 */
	function is_admin_name_available($username)
	{
		$this->db->select('1', FALSE);
		$this->db->where('LOWER(username)=', strtolower($username));

		$query = $this->db->get($this->admin_table_name);
		return $query->num_rows() == 0;
	}

	/**
	 * Check if email available for registering
	 *
	 * @param	string
	 * @return	bool
	 */
	function is_email_available($email)
	{
		$this->db->select('1', FALSE);
		$this->db->where('LOWER(email)=', strtolower($email));
		$this->db->or_where('LOWER(new_email)=', strtolower($email));

		$query = $this->db->get($this->table_name);
		return $query->num_rows() == 0;
	}
	function is_admin_email_available($email)
	{
		$this->db->select('1', FALSE);
		$this->db->where('LOWER(email)=', strtolower($email));
		$this->db->or_where('LOWER(new_email)=', strtolower($email));

		$query = $this->db->get($this->admin_table_name);
		return $query->num_rows() == 0;
	}



	/**
	 * Check if admin user for login
	 *
	 * @param	string
	 * @return	bool
	 */
	function is_admin_chk($login)
	{
		$this->db->select('1', FALSE);
		$this->db->group_start();
		$this->db->where('LOWER(username)=', strtolower($login));
		$this->db->or_where('LOWER(email)=', strtolower($login));
		$this->db->group_end();
		$this->apply_admin_type_filter(array('SITE', 'BOTH'));

		$query = $this->db->get($this->admin_table_name);
		return $query->num_rows() == 1;
	}

	function is_admin_idx($user_idx)
	{
		$this->db->select('1', FALSE);
		$this->db->where('id=', $user_idx);

		$query = $this->db->get($this->admin_table_name);
		return $query->num_rows() == 1;
	}




	/**
	 * Get user record by login
	 *
	 * @param	string
	 * @return	object
	 */
	function get_user_by_username_admin($login, $allowed_types = NULL)
	{
		$this->db->group_start();
		$this->db->where('LOWER(username)=', strtolower($login));
		$this->db->or_where('LOWER(email)=', strtolower($login));
		$this->db->group_end();
		$this->apply_admin_type_filter($allowed_types);

		$query = $this->db->get($this->admin_table_name);
		if ($query->num_rows() == 1) return $query->row();
		return NULL;
	}



	/**
	 * Create new user record
	 *
	 * @param	array
	 * @param	bool
	 * @return	array
	 */
	function create_user($data, $activated = TRUE)
	{
		$data['created'] = date('Y-m-d H:i:s');
		$data['activated'] = $activated ? 1 : 0;

		// NPO 회원은 가입시 미인증 처리
		if($data['level'] == 20) {
			$data['activated'] = 0;
		}

		if ($this->db->insert($this->table_name, $data)) {
			$user_id = $this->db->insert_id();
			if ($activated)	$this->create_profile($user_id);
			return array('user_id' => $user_id);
		}
		return NULL;
	}

	/**
	 * Activate user if activation key is valid.
	 * Can be called for not activated users only.
	 *
	 * @param	int
	 * @param	string
	 * @param	bool
	 * @return	bool
	 */
	function activate_user($user_id, $activation_key, $activate_by_email)
	{
		$this->db->select('1', FALSE);
		$this->db->where('id', $user_id);
		if ($activate_by_email) {
			$this->db->where('new_email_key', $activation_key);
		} else {
			$this->db->where('new_password_key', $activation_key);
		}
		$this->db->where('activated', 0);
		$query = $this->db->get($this->table_name);

		if ($query->num_rows() == 1) {

			$this->db->set('activated', 1);
			$this->db->set('new_email_key', NULL);
			$this->db->where('id', $user_id);
			$this->db->update($this->table_name);

			$this->create_profile($user_id);
			return TRUE;
		}
		return FALSE;
	}

	/**
	 * Purge table of non-activated users
	 *
	 * @param	int
	 * @return	void
	 */
	function purge_na($expire_period = 172800)
	{
		$this->db->where('activated', 0);
		$this->db->where('UNIX_TIMESTAMP(created) <', time() - $expire_period);
		$this->db->delete($this->table_name);
	}

	/**
	 * Delete user record
	 *
	 * @param	int
	 * @return	bool
	 */
	function delete_user($user_id)
	{
		$this->db->where('id', $user_id);
		$this->db->delete($this->table_name);
		if ($this->db->affected_rows() > 0) {
			$this->delete_profile($user_id);
			return TRUE;
		}
		return FALSE;
	}

	/**
	 * Delete user record
	 *
	 * @param	int
	 * @return	bool
	 */
	function delete_admin($user_id)
	{
		$this->db->where('id', $user_id);
		$this->db->delete($this->admin_table_name);
		if ($this->db->affected_rows() > 0) {
			return TRUE;
		}
		return FALSE;
	}


	/**
	 * Delete user record
	 *
	 * @param	int
	 * @return	bool
	 */
	function delete_manager($user_id)
	{
		$this->db->where('id', $user_id);
		$this->db->delete($this->admin_table_name);
		if ($this->db->affected_rows() > 0) {
			return TRUE;
		}
		return FALSE;
	}





	/**
	 * Set new password key for user.
	 * This key can be used for authentication when resetting user's password.
	 *
	 * @param	int
	 * @param	string
	 * @return	bool
	 */
	function set_password_key($user_id, $new_pass_key)
	{
		$this->db->set('new_password_key', $new_pass_key);
		$this->db->set('new_password_requested', date('Y-m-d H:i:s'));
		$this->db->where('id', $user_id);

		$this->db->update($this->table_name);
		return $this->db->affected_rows() > 0;
	}

	/**
	 * Check if given password key is valid and user is authenticated.
	 *
	 * @param	int
	 * @param	string
	 * @param	int
	 * @return	void
	 */
	function can_reset_password($user_id, $new_pass_key, $expire_period = 900)
	{
		$this->db->select('1', FALSE);
		$this->db->where('id', $user_id);
		$this->db->where('new_password_key', $new_pass_key);
		$this->db->where('UNIX_TIMESTAMP(new_password_requested) >', time() - $expire_period);

		$query = $this->db->get($this->table_name);
		return $query->num_rows() == 1;
	}

	/**
	 * Change user password if password key is valid and user is authenticated.
	 *
	 * @param	int
	 * @param	string
	 * @param	string
	 * @param	int
	 * @return	bool
	 */
	function reset_password($user_id, $new_pass, $new_pass_key, $expire_period = 900)
	{
		$this->db->set('password', $new_pass);
		$this->db->set('new_password_key', NULL);
		$this->db->set('new_password_requested', NULL);
		$this->db->where('id', $user_id);
		$this->db->where('new_password_key', $new_pass_key);
		$this->db->where('UNIX_TIMESTAMP(new_password_requested) >=', time() - $expire_period);

		$this->db->update($this->table_name);
		return $this->db->affected_rows() > 0;
	}

	/**
	 * Change user password
	 *
	 * @param	int
	 * @param	string
	 * @return	bool
	 */
	function change_password($user_id, $new_pass)
	{
		$this->db->set('password', $new_pass);
		$this->db->where('id', $user_id);

		$this->db->update($this->table_name);
		return $this->db->affected_rows() > 0;
	}

	/**
	 * Set new email for user (may be activated or not).
	 * The new email cannot be used for login or notification before it is activated.
	 *
	 * @param	int
	 * @param	string
	 * @param	string
	 * @param	bool
	 * @return	bool
	 */
	function set_new_email($user_id, $new_email, $new_email_key, $activated)
	{
		$this->db->set($activated ? 'new_email' : 'email', $new_email);
		$this->db->set('new_email_key', $new_email_key);
		$this->db->where('id', $user_id);
		$this->db->where('activated', $activated ? 1 : 0);

		$this->db->update($this->table_name);
		return $this->db->affected_rows() > 0;
	}

	/**
	 * Activate new email (replace old email with new one) if activation key is valid.
	 *
	 * @param	int
	 * @param	string
	 * @return	bool
	 */
	function activate_new_email($user_id, $new_email_key)
	{
		$this->db->set('email', 'new_email', FALSE);
		$this->db->set('new_email', NULL);
		$this->db->set('new_email_key', NULL);
		$this->db->where('id', $user_id);
		$this->db->where('new_email_key', $new_email_key);

		$this->db->update($this->table_name);
		return $this->db->affected_rows() > 0;
	}

	/**
	 * Update user login info, such as IP-address or login time, and
	 * clear previously generated (but not activated) passwords.
	 *
	 * @param	int
	 * @param	bool
	 * @param	bool
	 * @return	void
	 */
	function update_login_info($user_id, $record_ip, $record_time)
	{

		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

		// [2021-08-10] admin login check
		if( $this->is_admin_idx($user_id)) {
			$user_table_name = $this->admin_table_name;
		}
		else {
			$user_table_name = $this->table_name;
		}

		// [2021-08-11] 로그인 횟수 증가 추가
		$this->db->select('cnt_login', FALSE);
		$this->db->where('id', $user_id);
		$query = $this->db->get($user_table_name);
		//$cnt_login = 0;
		if($row = $query->row()) {
			$cnt_login = $row->cnt_login;
			$cnt_login++;

			$this->db->set('cnt_login', $cnt_login);
			$this->db->where('id', $user_id);
			$this->db->update($user_table_name);
		}
		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

		$this->db->set('new_password_key', NULL);
		$this->db->set('new_password_requested', NULL);

		if ($record_ip)		$this->db->set('last_ip', $this->input->ip_address());
		if ($record_time)	$this->db->set('last_login', date('Y-m-d H:i:s'));

		$this->db->where('id', $user_id);
		$this->db->update($user_table_name);
	}

	/**
	 * Ban user
	 *
	 * @param	int
	 * @param	string
	 * @return	void
	 */
	function ban_user($user_id, $reason = NULL)
	{
		$this->db->where('id', $user_id);
		$this->db->update($this->table_name, array(
			'banned'		=> 1,
			'ban_reason'	=> $reason,
		));
	}

	/**
	 * Unban user
	 *
	 * @param	int
	 * @return	void
	 */
	function unban_user($user_id)
	{
		$this->db->where('id', $user_id);
		$this->db->update($this->table_name, array(
			'banned'		=> 0,
			'ban_reason'	=> NULL,
		));
	}

	/**
	 * Create an empty profile for a new user
	 *
	 * @param	int
	 * @return	bool
	 */
	private function create_profile($user_id)
	{
		// [2021-08-12] username 확인해서 추가
		$this->db->select('username', FALSE);
		$this->db->where('id', $user_id);
		$query = $this->db->get($this->table_name);
		if($row = $query->row()) {
			$username = $row->username;
			$this->db->set('user_username', $username);
		}

		// NPO 회원 가입시 상호/법인명 등록 처리
		$upro_company      = $this->input->post('company',false);
		if($upro_company) {
			$this->db->set('company', $upro_company);
		}

		$upro_phone = preg_replace('/[^0-9]/', '', (string) $this->input->post('phone', false));
		if ($upro_phone !== '') {
			$this->db->set('phone', $upro_phone);
		}

		$this->db->set('user_id', $user_id);
		return $this->db->insert($this->profile_table_name);
	}

	/**
	 * Delete user profile
	 *
	 * @param	int
	 * @return	void
	 */
	private function delete_profile($user_id)
	{
		$this->db->where('user_id', $user_id);
		$this->db->delete($this->profile_table_name);
	}










	/** [2022-10-19]
	 * 마이페이지에서 회원 정보 수정
	 *
	 */
	function user_edit($user_idx,$data=FALSE) {

		$this->db->where('id', $user_idx);
		if ($this->db->update($this->table_name, $data)) {
			$this->upro_edit($user_idx);
			return array('user_idx' => $user_idx);
		}
		return NULL;
	}

	private function upro_edit($user_idx)
	{
		$this->input->post(NULL, TRUE); // returns all POST items with XSS filter

		/*
		//$upro_gender     = $this->input->post('upro_gender');
		//$upro_birth      = $this->input->post('upro_birth');
		//$upro_newsletter = $this->input->post('upro_newsletter');
		//$upro_newsletter_date = ($upro_newsletter) ? TIME_YMDHIS : '';
		$upro_phone_1      = $this->input->post('upro_phone_1');
		$upro_phone_2      = $this->input->post('upro_phone_2');
		$upro_phone_3      = $this->input->post('upro_phone_3');
		$upro_phone = ($upro_phone_2 && $upro_phone_3) ? $upro_phone_1 .'-'. $upro_phone_2 .'-'. $upro_phone_3 : '';

		$upro_tel_1   = $this->input->post('upro_tel_1');
		$upro_tel_2   = $this->input->post('upro_tel_2');
		$upro_tel_3   = $this->input->post('upro_tel_3');
		$upro_tel    = ($upro_tel_2 && $upro_tel_3) ? $upro_tel_1 .'-'. $upro_tel_2 .'-'. $upro_tel_3 : '';

		$postcode      = $this->input->post('postcode');
		$addr          = $this->input->post('addr');
		$addr_detail   = $this->input->post('addr_detail');

		$ip            = $this->input->post('ip');
		$mac_address   = $this->input->post('mac_address');

		$upro_data = array(
			//'user_id'          =>$user_idx,
			//'upro_code'        =>$upro_code,
			//'upro_gender'      =>$upro_gender,
			//'upro_birth'       =>$upro_birth,
			//'upro_newsletter'  =>$upro_newsletter,
			//'upro_newsletter_date' =>$upro_newsletter_date,
			'phone'       =>$upro_phone,
			'tel'         =>$upro_tel,
			'postcode'    =>$postcode,
			'addr'        =>$addr,
			'addr_detail' =>$addr_detail,
			'ip'          =>$ip,
			'mac_address' =>$mac_address
		);
		*/


		$upro_phone      = str_replace('-','',$this->input->post('phone'));
		$upro_company      = $this->input->post('company');
		$upro_company_info      = $this->input->post('company_info');
		$website      = $this->input->post('website');

		$upro_data = array(
			'phone'          =>$upro_phone,
			'company'          =>$upro_company,
			'website'          =>$website,
		);

		if($upro_company_info) {
			$upro_data['company_info'] = $upro_company_info;
		}


		$this->db->where('user_id',$user_idx);

		return $this->db->update($this->profile_table_name,$upro_data);
	}






	/** [2020-12-13]
	 * 마이페이지에서 정보 수정
	 *
	 */
	function update_user_mypage($user_idx, $data)
	{
		$this->db->where('id', $user_idx);
		if ($this->db->update($this->table_name, $data)) {
			$this->update_profile_mypage($user_idx);
			return array('user_id' => $user_idx);
		}
		return NULL;
	}




	private function update_profile_mypage($user_idx)
	{
		$this->input->post(NULL, TRUE); // returns all POST items with XSS filter

		/*
		//$upro_gender     = $this->input->post('upro_gender');
		//$upro_birth      = $this->input->post('upro_birth');
		//$upro_newsletter = $this->input->post('upro_newsletter');
		//$upro_newsletter_date = ($upro_newsletter) ? TIME_YMDHIS : '';
		$upro_phone_1      = $this->input->post('upro_phone_1');
		$upro_phone_2      = $this->input->post('upro_phone_2');
		$upro_phone_3      = $this->input->post('upro_phone_3');
		$upro_phone = ($upro_phone_2 && $upro_phone_3) ? $upro_phone_1 .'-'. $upro_phone_2 .'-'. $upro_phone_3 : '';

		$upro_tel_1   = $this->input->post('upro_tel_1');
		$upro_tel_2   = $this->input->post('upro_tel_2');
		$upro_tel_3   = $this->input->post('upro_tel_3');
		$upro_tel    = ($upro_tel_2 && $upro_tel_3) ? $upro_tel_1 .'-'. $upro_tel_2 .'-'. $upro_tel_3 : '';

		$postcode      = $this->input->post('postcode');
		$addr          = $this->input->post('addr');
		$addr_detail   = $this->input->post('addr_detail');

		$ip            = $this->input->post('ip');
		$mac_address   = $this->input->post('mac_address');

		$upro_data = array(
			//'user_id'          =>$user_idx,
			//'upro_code'        =>$upro_code,
			//'upro_gender'      =>$upro_gender,
			//'upro_birth'       =>$upro_birth,
			//'upro_newsletter'  =>$upro_newsletter,
			//'upro_newsletter_date' =>$upro_newsletter_date,
			'phone'       =>$upro_phone,
			'tel'         =>$upro_tel,
			'postcode'    =>$postcode,
			'addr'        =>$addr,
			'addr_detail' =>$addr_detail,
			'ip'          =>$ip,
			'mac_address' =>$mac_address
		);
		*/


		$upro_phone      = str_replace('-','',$this->input->post('phone'));
		$upro_company      = $this->input->post('company');

		$upro_data = array(
			'phone'          =>$upro_phone,
			'company'          =>$upro_company
		);
		$this->db->where('user_id',$user_idx);

		return $this->db->update($this->profile_table_name,$upro_data);
	}






	/**
	 * Delete user record
	 *
	 * @param	int
	 * @return	bool
	 */
	function delete_excel_user($reason=FALSE)
	{
		//$this->db->where('route', 'excel');
		//$this->db->select('user_id', FALSE);
		//$result = $this->db->get($this->table_name)->result_array();

		//print_r($result);
		//exit;


		$arr['sql_from'] = $this->table_name;
		$arr['sql_where'] = array('route'=>'excel');
		$arr['sql_select'] = 'id';
		$result = $this->basic_model->arr_get_result($arr);

		/*
		echo $this->db->last_query();
		echo '<hr />';
		print_r($result);
		exit;
		*/

		foreach($result['qry'] as $key => $row) 
		{
			$this->db->where('id', $row->id);
			$this->db->delete($this->table_name);
			if ($this->db->affected_rows() > 0) {
				$this->delete_profile($row->id);
			}
		}

		return true;
	}




	/**
	 * Delete npo record
	 *
	 * @param	int
	 * @return	bool
	 */
	function delete_excel_npo($reason=FALSE)
	{
		//$this->db->where('route', 'excel');
		//$this->db->select('user_id', FALSE);
		//$result = $this->db->get($this->npo_table_name)->result_array();

		//print_r($result);
		//exit;


		$arr['sql_from'] = $this->npo_table_name;
		$arr['sql_where'] = array('route'=>'excel');
		$arr['sql_select'] = 'id';
		$result = $this->basic_model->arr_get_result($arr);

		/*
		echo $this->db->last_query();
		echo '<hr />';
		print_r($result);
		exit;
		*/

		foreach($result['qry'] as $key => $row) 
		{
			$this->db->where('id', $row->id);
			$this->db->delete($this->npo_table_name);
			if ($this->db->affected_rows() > 0) {
				$this->delete_profile($row->id);
			}
		}

		return true;
	}






	/** 2020-11-06 */
	function excel_user_by_admin($data,$pfdata)
	{

		if( $this->is_username_available($data['username']) ) {
			if ($this->db->insert($this->table_name, $data)) {
				$user_id = $this->db->insert_id();
				$this->excel_profile_by_admin($user_id,$pfdata);
				return array('user_id' => $user_id);
			}
			else {
				return NULL;
			}
		}
		return NULL;
	}




	/** 2023-05-17 */
	function excel_npo_by_admin($data)
	{

		if ($this->db->insert($this->npo_table_name, $data)) {
			$idx = $this->db->insert_id();
			return array('idx' => $idx);
		}
		else {
			return NULL;
		}

		/*
		if( $this->is_username_available($data['username']) ) {
			if ($this->db->insert($this->npo_table_name, $data)) {
				$idx = $this->db->insert_id();
				return array('idx' => $idx);
			}
			else {
				return NULL;
			}
		}
		return NULL;
		*/
	}




	/** [2017-03-13]
	 * Create an empty profile for a new user by admin
	 *
	 * @param	int
	 * @return	bool
	 */
	private function excel_profile_by_admin($user_id,$pfdata)
	{
		$upro_data = array('user_id' => $user_id);

		$upro_phone = $pfdata['phone'];
		$upro_birth = $pfdata['birth'];

		if('' !== $upro_phone)   $upro_data['phone']       = $upro_phone;
		if('' !== $upro_birth)   $upro_data['birth']       = $upro_birth;

		$this->db->set($upro_data);

		$res = $this->db->insert($this->profile_table_name);

		//echo $this->db->last_query();
		//exit;

		return $res;
	}








	/** - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	 * [2021-08-09] 이후 추가
	 */

	/**
	 * Check if username is admin
	 *
	 * @param	string
	 * @return	bool
	 */
	function is_admin($username)
	{
		$this->db->select('1', FALSE);
		$this->db->where('LOWER(username)=', strtolower($username));
		$this->db->where('banned','0');
		$this->apply_admin_type_filter(array('SITE', 'BOTH'));

		$query = $this->db->get($this->admin_table_name);
		return $query->num_rows();
	}
	/**
	 * Check if username is super admin
	 *
	 * @param	string
	 * @return	bool
	 */
	function is_sadmin($username)
	{
		$this->db->select('1', FALSE);
		$this->db->where('LOWER(username)=', strtolower($username));
		$this->db->where('banned','0');
		$this->db->where('is_sadmin','1');
		$this->apply_admin_type_filter(array('SITE', 'BOTH'));

		$query = $this->db->get($this->admin_table_name);
		return $query->num_rows();
	}

	function get_admin_type_field()
	{
		$fields = $this->get_admin_fields();
		return in_array('type', $fields, TRUE) ? 'type' : NULL;
	}

	private function get_admin_fields()
	{
		if ($this->admin_fields !== NULL) {
			return $this->admin_fields;
		}

		$this->admin_fields = $this->db->list_fields($this->admin_table_name);
		return $this->admin_fields;
	}

	private function apply_admin_type_filter($allowed_types = NULL)
	{
		$type_field = $this->get_admin_type_field();
		if (!$type_field || $allowed_types === NULL) {
			return;
		}

		$normalized_types = array();
		foreach ((array) $allowed_types as $type) {
			$type = strtoupper(trim((string) $type));
			if ($type !== '') {
				$normalized_types[] = $type;
			}
		}

		if (!empty($normalized_types)) {
			$this->db->where_in($type_field, array_values(array_unique($normalized_types)));
		}
	}










	/** - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	 * [2020-10-29]
	 * 관리자에 의한 회원 등록
	 *
	 */
	//function create_user_by_admin($data)
	/*
	function create_user_by_admin($data,$user_idx=FALSE)
	{

		// 회원 table 에도, 관리자 table 에도 없는 아이디인지 체크
		if( $this->is_username_available($data['username']) && $this->is_admin_available($data['username']) ) {

			// user, admin 모두 사용하지 않는 아이디인 경우, 회원 등록 처리
			if ($this->db->insert($this->table_name, $data)) {
				$user_id = $this->db->insert_id();

				// 관리자에 의한 회원 추가는 인증 상태로 처리
				//if ($activated)	$this->create_profile($user_id);
				$this->create_profile_by_admin($user_id,$data['username']);
				return array('user_id' => $user_id);
			}
			else {
				return NULL;
			}
		}
		return NULL;
	}
	*/

	//function create_user_by_admin($data,$user_idx=FALSE)
	function create_user_by_admin($data,$data_pf=FALSE)
	{

		// 회원 table 에도, 관리자 table 에도 없는 아이디인지 체크
		if( $this->is_username_available($data['username']) && $this->is_admin_available($data['username']) ) {

			// user, admin 모두 사용하지 않는 아이디인 경우, 회원 등록 처리
			if ($this->db->insert($this->table_name, $data)) {
				$user_id = $this->db->insert_id();

				// 관리자에 의한 회원 추가는 인증 상태로 처리
				//if ($activated)	$this->create_profile($user_id);
				$this->create_profile_by_admin($user_id,$data['username'],$data_pf);
				return array('user_id' => $user_id);
			}
			else {
				return NULL;
			}
		}
		return NULL;
	}




	/** [2017-03-13]
	 * Create an empty profile for a new user by admin
	 *
	 * @param	int
	 * @return	bool
	 */
	private function create_profile_by_admin($user_id,$username,$data_pf=FALSE)
	{
		$upro_data = array('user_id' => $user_id, 'user_username'=>$username);

		$this->input->post(NULL, TRUE); // returns all POST items with XSS filter

		$upro_phone_1      = $this->input->post('upro_phone_1');
		$upro_phone_2      = $this->input->post('upro_phone_2');
		$upro_phone_3      = $this->input->post('upro_phone_3');
		//$upro_phone = ($upro_phone_2 && $upro_phone_3) ? $upro_phone_1 .'-'. $upro_phone_2 .'-'. $upro_phone_3 : '';
		$upro_phone = $upro_phone_1 . $upro_phone_2 . $upro_phone_3;

		$upro_tel_1   = $this->input->post('upro_tel_1');
		$upro_tel_2   = $this->input->post('upro_tel_2');
		$upro_tel_3   = $this->input->post('upro_tel_3');
		$upro_tel     = ($upro_tel_2 && $upro_tel_3) ? $upro_tel_1 .'-'. $upro_tel_2 .'-'. $upro_tel_3 : '';

		$postcode      = $this->input->post('postcode');
		$addr          = $this->input->post('addr');
		$addr_detail   = $this->input->post('addr_detail');

		if('' !== $upro_phone)   $upro_data['phone']       = $upro_phone;
		if('' !== $upro_tel)     $upro_data['tel']         = $upro_tel;
		if('' !== $postcode)     $upro_data['postcode']    = $postcode;
		if('' !== $addr)         $upro_data['addr']        = $addr;
		if('' !== $addr_detail)  $upro_data['addr_detail'] = $addr_detail;

		
		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		// [2023-11-23] 관리자가 관리자페이지 > 캠페인개설협약신청자 목록에서 바로 가입처리했을 때.
		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		if( isset($data_pf['tel']) && '' != $data_pf['tel'] ) {
			$upro_data['tel']         = $data_pf['tel'];
		}
		if( isset($data_pf['company']) && '' != $data_pf['company'] ) {
			$upro_data['company']         = $data_pf['company'];
		}
		if( isset($data_pf['manager']) && '' != $data_pf['manager'] ) {
			$upro_data['manager']         = $data_pf['manager'];
		}


		$this->db->set($upro_data);

		$res = $this->db->insert($this->profile_table_name);

		//echo $this->db->last_query();
		//exit;

		return $res;
	}



	/** [2017-03-13]
	 * 관리자에 의한 회원 정보 수정
	 *
	 */
	function update_user_by_admin($user_idx, $data, $data_pf=false)
	{
		$this->db->where('id', $user_idx);
		if ($this->db->update($this->table_name, $data)) {
			$this->update_profile_admin($user_idx,$data_pf);
			return array('user_id' => $user_idx);
		}
		return NULL;
	}



	/** [2017-03-13]
	 * 관리자에 의한 회원 정보 수정
	 *
	 */
	private function update_profile_admin($user_idx,$data_pf=FALSE)
	{
		$this->input->post(NULL, TRUE); // returns all POST items with XSS filter
		//$upro_gender     = $this->input->post('upro_gender');
		//$upro_birth      = $this->input->post('upro_birth');
		//$upro_newsletter = $this->input->post('upro_newsletter');
		//$upro_newsletter_date = ($upro_newsletter) ? TIME_YMDHIS : '';
		$upro_phone_1      = $this->input->post('upro_phone_1');
		$upro_phone_2      = $this->input->post('upro_phone_2');
		$upro_phone_3      = $this->input->post('upro_phone_3');
		//$upro_phone = ($upro_phone_2 && $upro_phone_3) ? $upro_phone_1 .'-'. $upro_phone_2 .'-'. $upro_phone_3 : '';
		$upro_phone = $upro_phone_1.$upro_phone_2.$upro_phone_3;

		$upro_tel_1   = $this->input->post('upro_tel_1');
		$upro_tel_2   = $this->input->post('upro_tel_2');
		$upro_tel_3   = $this->input->post('upro_tel_3');
		$upro_tel    = ($upro_tel_2 && $upro_tel_3) ? $upro_tel_1 .'-'. $upro_tel_2 .'-'. $upro_tel_3 : '';

		$postcode      = $this->input->post('postcode');
		$addr          = $this->input->post('addr');
		$addr_detail   = $this->input->post('addr_detail');

		$ip            = $this->input->post('ip');
		$mac_address   = $this->input->post('mac_address');



		$upro_data = array(
			//'user_id'          =>$user_idx,
			//'upro_code'        =>$upro_code,
			//'upro_gender'      =>$upro_gender,
			//'upro_birth'       =>$upro_birth,
			//'upro_newsletter'  =>$upro_newsletter,
			//'upro_newsletter_date' =>$upro_newsletter_date,
			'phone'       =>$upro_phone,
			'tel'         =>$upro_tel,
			'postcode'    =>$postcode,
			'addr'        =>$addr,
			'addr_detail' =>$addr_detail,
			//'ip'          =>$ip,
			//'mac_address' =>$mac_address
		);


		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		// [2023-11-23] 관리자가 관리자페이지 > 캠페인개설협약신청자 목록에서 바로 가입처리했을 때.
		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		if( isset($data_pf['tel']) && '' != $data_pf['tel'] ) {
			$upro_data['tel']         = $data_pf['tel'];
		}
		if( isset($data_pf['company']) && '' != $data_pf['company'] ) {
			$upro_data['company']         = $data_pf['company'];
		}
		if( isset($data_pf['manager']) && '' != $data_pf['manager'] ) {
			$upro_data['manager']         = $data_pf['manager'];
		}



		$this->db->where('user_id',$user_idx);

		return $this->db->update($this->profile_table_name,$upro_data);
	}







	/** [2020-10-29]
	 * 관리자에 의한 사이트매니저 등록
	 *
	 */
	function create_manager($data)
	{
		if (!isset($data['type']) || !in_array($data['type'], array('SITE', 'PARTNER', 'BOTH'), TRUE)) {
			$data['type'] = 'SITE';
		}

		if( $this->is_admin_name_available($data['username']) ) {
			if ($this->db->insert($this->admin_table_name, $data)) {
				$user_id = $this->db->insert_id();
				return array('user_id' => $user_id);
			}
			else {
				return NULL;
			}
		}
		return NULL;
	}

	/** [2017-03-13]
	 * 관리자에 의한 회원 정보 수정
	 *
	 */
	function update_manager($user_idx, $data)
	{
		if (isset($data['type']) && !in_array($data['type'], array('SITE', 'PARTNER', 'BOTH'), TRUE)) {
			unset($data['type']);
		}

		$this->db->where('id', $user_idx);
		if ($this->db->update($this->admin_table_name, $data)) {
			return array('user_id' => $user_idx);
		}
		return NULL;
	}





	/** 2022-02-11 */
	function excel_upload_inven_lists($data)
	{
		if ($this->db->insert($this->inven_table_name, $data)) {
			$idx = $this->db->insert_id();
			return array('idx' => $idx);
		}
		else {
			return NULL;
		}
	}



	/** 2022-02-11 */
	function excel_update_inven_lists($data)
	{
		$this->db->where('barcode', $data['barcode']);
		if ($this->db->update($this->inven_table_name, $data)) {
			return array('barcode' => $data['barcode']);
		}
		return NULL;
	}

}

/* End of file users.php */
/* Location: ./application/models/auth/users.php */
