<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once('phpass-0.5/PasswordHash.php');

define('STATUS_ACTIVATED', '1');
define('STATUS_NOT_ACTIVATED', '0');

define('STATUS_ADMIN', '1');
define('STATUS_NOT_ADMIN', '0');

/**
 * Tank_auth
 *
 * Authentication library for Code Igniter.
 *
 * @package		Tank_auth
 * @author		Ilya Konyukhov (http://konyukhov.com/soft/)
 * @version		1.0.9
 * @based on	DX Auth by Dexcell (http://dexcell.shinsengumiteam.com/dx_auth)
 * @license		MIT License Copyright (c) 2008 Erick Hartanto
 */
class Tank_auth
{
	private $error = array();

	function __construct()
	{
		$this->ci =& get_instance();

		$this->ci->load->config('tank_auth', TRUE);

		//$this->ci->load->library('session');
		$this->ci->load->database();
		$this->ci->load->model('tank_auth/users');

		// Try to autologin
		$this->autologin();
	}

	/**
	 * Login user on the site. Return TRUE if login is successful
	 * (user exists and activated, password is correct), otherwise FALSE.
	 *
	 * @param	string	(username or email or both depending on settings in config file)
	 * @param	string
	 * @param	bool
	 * @return	bool
	 */
	function login($login, $password, $remember, $login_by_username, $login_by_email)
	{
		if ((strlen($login) > 0) AND (strlen($password) > 0)) {

			// Which function to use to login (based on config)
			if ($login_by_username AND $login_by_email) {
				$get_user_func = 'get_user_by_login';
			} else if ($login_by_username) {
				$get_user_func = 'get_user_by_username';
			} else {
				$get_user_func = 'get_user_by_email';
			}

			// [2021-08-10] admin login check
			if( $this->is_admin_chk($login)) {
				$get_user_func = 'get_user_by_username_admin';
			}

			//echo $get_user_func;
			//echo $login;

			if (!is_null($user = $this->ci->users->$get_user_func($login))) {	// login ok

				//print_r($user);
				//exit;

				// Does password match hash in database?
				$hasher = new PasswordHash(
						$this->ci->config->item('phpass_hash_strength', 'tank_auth'),
						$this->ci->config->item('phpass_hash_portable', 'tank_auth'));
				if ($hasher->CheckPassword($password, $user->password)) {		// password ok

					if ($user->banned == 1) {									// fail - banned
						$this->error = array('banned' => $user->ban_reason);

					} else {
						$this->ci->session->set_userdata(array(
								'user_id'	=> $user->id,
								'username'	=> $user->username,
								'nickname'	=> $user->nickname,
								'status'	=> ($user->activated == 1) ? STATUS_ACTIVATED : STATUS_NOT_ACTIVATED,
						));


						/*
						$user_idx = $this->ci->tank_auth->get_user_id();
						echo $user_idx.'<<<<br />';
						$username = $this->ci->tank_auth->get_username();
						echo $username.'<<<<br />';
						exit;
						*/

						if( $this->is_admin_chk($login)) {
							$this->ci->session->set_userdata['admin_title'] = ' -- [관리자로 로그인 중]';
						}

						if ($user->activated == 0) {							// fail - not activated
							$this->error = array('not_activated' => '');

						} else {												// success
							if ($remember) {
								$this->create_autologin($user->id);
							}

							// 로그인 시도 횟수 초기화
							$this->clear_login_attempts($login);

							// [2021-08-11] users model에 로그인 횟수 증가 추가
							$this->ci->users->update_login_info(
									$user->id,
									$this->ci->config->item('login_record_ip', 'tank_auth'),
									$this->ci->config->item('login_record_time', 'tank_auth'));
							return TRUE;
						}
					}
				} else {														// fail - wrong password
					$this->increase_login_attempt($login);
					$this->error = array('password' => 'auth_incorrect_password');
				}
			} else {															// fail - wrong login
				$this->increase_login_attempt($login);
				$this->error = array('login' => 'auth_incorrect_login');
			}
		}
		return FALSE;
	}

	/**
	 * Logout user from the site
	 *
	 * @return	void
	 */
	function logout()
	{
		$this->delete_autologin();

		// See http://codeigniter.com/forums/viewreply/662369/ as the reason for the next line
		$this->ci->session->set_userdata(array('user_id' => '', 'username' => '', 'status' => ''));

		$this->ci->session->sess_destroy();
	}

	/**
	 * Check if user logged in. Also test if user is activated or not.
	 *
	 * @param	bool
	 * @return	bool
	 */
	function is_logged_in($activated = TRUE)
	{
		return $this->ci->session->userdata('status') === ($activated ? STATUS_ACTIVATED : STATUS_NOT_ACTIVATED);
	}

	/**
	 * Get user_id
	 *
	 * @return	string
	 */
	function get_user_id()
	{
		return $this->ci->session->userdata('user_id');
	}

	/**
	 * Get username
	 *
	 * @return	string
	 */
	function get_username()
	{
		return $this->ci->session->userdata('username');
	}













	function get_nickname()
	{
		return $this->ci->session->userdata('nickname');
	}

	function get_sns_rpath_encode()
	{
		return $this->ci->session->userdata('sns_rpath_encode');
	}


	/**
	 * Get user information
	 *
	 * @return	string
	 */
	function get_userinfo($login=FALSE,$all=FALSE)
	{

		/*
		if(! $login)
			return false;
		*/


		$row = $this->ci->users->get_user_by_login($login);

		// 인증받지 못한 경우, 로그아웃 처리
		if (isset($row->activated) && $row->activated == 0) {
			$this->logout();
			redirect('/');
		}

		// 관리자
		if('admin' == $login || 'sadmin' == $login) {
			$row = $this->ci->users->get_admin_by_username($login,true);
		}

		if( ! isset($row->username) ) {
			return false;
		}

		$user = new stdClass();
		if($all) :
			$user = $row;

		else : 

			$user->id        = $row->id;
			$user->username  = $row->username;
			$user->nickname  = $row->nickname;
			$user->email     = $row->email;
			$user->activated = $row->activated;
			$user->banned    = $row->banned;
			$user->cnt_login = $row->cnt_login;
			$user->level     = $row->level;
			$user->sns     = isset($row->sns) ? $row->sns : '';

		endif;

		if(! $this->is_admin()) {

			if( isset($user->id) && $user->id > 0) {

				$row_upro = $this->ci->users->get_profile_by_id($user->id);

				$user->website      = isset($row_upro->website) ? $row_upro->website : '';
				$user->country      = isset($row_upro->country) ? $row_upro->country : '';
				$user->birth        = isset($row_upro->birth) ? $row_upro->birth : '';
				$user->phone        = isset($row_upro->phone) ? $row_upro->phone : '';
				$user->tel          = isset($row_upro->tel) ? $row_upro->tel : '';
				$user->fax          = isset($row_upro->fax) ? $row_upro->fax : '';
				$user->postcode     = isset($row_upro->postcode) ? $row_upro->postcode : '';
				$user->addr         = isset($row_upro->addr) ? $row_upro->addr : '';
				$user->addr_detail  = isset($row_upro->addr_detail) ? $row_upro->addr_detail : '';
				$user->company      = isset($row_upro->company) ? $row_upro->company : '';
				$user->company_info      = isset($row_upro->company_info) ? $row_upro->company_info : '';

			}

		}

		return $user;
	}

	function get_userinfo_idx($user_idx=FALSE)
	{
		if(! $user_idx)
			return false;

		$row = $this->ci->users->get_user_by_id($user_idx, TRUE);
		if( ! isset($row->username) ) {
			return false;
		}

		$user = new stdClass();
		$user->id        = $row->id;
		$user->username  = $row->username;
		$user->nickname  = $row->nickname;
		$user->email     = $row->email;
		$user->activated = $row->activated;
		$user->banned    = $row->banned;
		$user->cnt_login = $row->cnt_login;
		$user->level     = $row->level;
		$user->sns     = isset($row->sns) ? $row->sns : '';
		return $user;
	}




	function get_admininfo_idx($user_idx=FALSE)
	{
		if(! $user_idx)
			return false;

		$row = $this->ci->users->get_admin_by_id($user_idx, TRUE);
		if( ! isset($row->username) ) {
			return false;
		}

		$user = new stdClass();
		$user->id        = $row->id;
		$user->username  = $row->username;
		$user->nickname  = $row->nickname;
		$user->email     = $row->email;
		$user->activated = $row->activated;
		$user->banned    = $row->banned;
		$user->cnt_login = $row->cnt_login;
		$user->level     = $row->level;
		$user->is_sadmin  = $row->is_sadmin;
		return $user;
	}




















	/**
	 * Create new user on the site and return some data about it:
	 * user_id, username, password, email, new_email_key (if any).
	 *
	 * @param	string
	 * @param	string
	 * @param	string
	 * @param	bool
	 * @return	array
	 */
	function create_user($username, $nickname, $email, $password, $email_activation)
	{
		if ((strlen($username) > 0) AND !$this->ci->users->is_username_available($username)) {
			//$this->error = array('username' => 'auth_username_in_use');
			$this->error = array('username' => 'auth_userid_in_use');

		} elseif (!$this->ci->users->is_email_available($email)) {
			$this->error = array('email' => 'auth_email_in_use');

		} else {
			// Hash password using phpass
			$hasher = new PasswordHash(
					$this->ci->config->item('phpass_hash_strength', 'tank_auth'),
					$this->ci->config->item('phpass_hash_portable', 'tank_auth'));
			$hashed_password = $hasher->HashPassword($password);

			// [2022-07-19] 회원 구분 [10:준회원, sns로그인 회원, 20:NPO회원]
			$level = $this->ci->input->post('group_fk',FALSE);

			/*
			// 나이스 본인인증을 거친 후 발급되는 중복가입 방지용 고유 확인정보 
			$dupinfo = $this->ci->input->post('dupinfo','');
			
			$nickname = $this->ci->input->post('nickname','');
			$birth = $this->ci->input->post('birth','');
			$mobile = $this->ci->input->post('mobile','');
			$gender = $this->ci->input->post('gender','');
			*/

			/* [2022-11-04] 회원 가입시 아이디를 제외했으므로, 이메일 앞자리와 가입시간을 임시 아이디로 등록한다. */
			if($username == '' OR (strlen($username) < 1)) {

				$arr_email = explode('@',$email);
				//$username = $arr_email[0].'_'.time();
				$username = $arr_email[0].'_'.date('YmdHis');
			}

			$data = array(
				'username'	=> $username,
				'nickname'	=> $nickname,
				'password'	=> $hashed_password,
				'email'		=> $email,
				'level'	=> $level, // '20,30',
				'last_ip'	=> $this->ci->input->ip_address(),
			);

			if ($email_activation) {
				$data['new_email_key'] = md5(rand().microtime());
			}
			if (!is_null($res = $this->ci->users->create_user($data, !$email_activation))) {
				$data['user_id'] = $res['user_id'];
				$data['password'] = $password;
				unset($data['last_ip']);
				return $data;
			}
		}
		return NULL;
	}

	/**
	 * Check if username available for registering.
	 * Can be called for instant form validation.
	 *
	 * @param	string
	 * @return	bool
	 */
	function is_username_available($username)
	{
		return ((strlen($username) > 0) AND $this->ci->users->is_username_available($username));
	}

	function is_admin_available($username)
	{
		return ((strlen($username) > 0) AND $this->ci->users->is_admin_available($username));
	}
	/**
	 * Check if email available for registering.
	 * Can be called for instant form validation.
	 *
	 * @param	string
	 * @return	bool
	 */
	function is_email_available($email)
	{
		return ((strlen($email) > 0) AND $this->ci->users->is_email_available($email));
	}
	function is_admin_email_available($email)
	{
		return ((strlen($email) > 0) AND $this->ci->users->is_admin_email_available($email));
	}

	/**
	 * Change email for activation and return some data about user:
	 * user_id, username, email, new_email_key.
	 * Can be called for not activated users only.
	 *
	 * @param	string
	 * @return	array
	 */
	function change_email($email)
	{
		$user_id = $this->ci->session->userdata('user_id');

		if (!is_null($user = $this->ci->users->get_user_by_id($user_id, FALSE))) {

			$data = array(
				'user_id'	=> $user_id,
				'username'	=> $user->username,
				'email'		=> $email,
			);
			if (strtolower($user->email) == strtolower($email)) {		// leave activation key as is
				$data['new_email_key'] = $user->new_email_key;
				return $data;

			} elseif ($this->ci->users->is_email_available($email)) {
				$data['new_email_key'] = md5(rand().microtime());
				$this->ci->users->set_new_email($user_id, $email, $data['new_email_key'], FALSE);
				return $data;

			} else {
				$this->error = array('email' => 'auth_email_in_use');
			}
		}
		return NULL;
	}

	/**
	 * Activate user using given key
	 *
	 * @param	string
	 * @param	string
	 * @param	bool
	 * @return	bool
	 */
	function activate_user($user_id, $activation_key, $activate_by_email = TRUE)
	{
		$this->ci->users->purge_na($this->ci->config->item('email_activation_expire', 'tank_auth'));

		if ((strlen($user_id) > 0) AND (strlen($activation_key) > 0)) {
			return $this->ci->users->activate_user($user_id, $activation_key, $activate_by_email);
		}
		return FALSE;
	}

	/**
	 * Set new password key for user and return some data about user:
	 * user_id, username, email, new_pass_key.
	 * The password key can be used to verify user when resetting his/her password.
	 *
	 * @param	string
	 * @return	array
	 */
	function forgot_password($login)
	{
		if (strlen($login) > 0) {

			if (!is_null($user = $this->ci->users->get_user_by_login($login))) {

				$data = array(
					'user_id'		=> $user->id,
					'username'		=> $user->username,
					'email'			=> $user->email,
					'new_pass_key'	=> md5(rand().microtime()),
				);

				$this->ci->users->set_password_key($user->id, $data['new_pass_key']);
				return $data;

			} else {
				$this->error = array('login' => 'auth_incorrect_email_or_username');
			}
		}
		return NULL;
	}

	/**
	 * Check if given password key is valid and user is authenticated.
	 *
	 * @param	string
	 * @param	string
	 * @return	bool
	 */
	function can_reset_password($user_id, $new_pass_key)
	{
		if ((strlen($user_id) > 0) AND (strlen($new_pass_key) > 0)) {
			return $this->ci->users->can_reset_password(
				$user_id,
				$new_pass_key,
				$this->ci->config->item('forgot_password_expire', 'tank_auth'));
		}
		return FALSE;
	}

	/**
	 * Replace user password (forgotten) with a new one (set by user)
	 * and return some data about it: user_id, username, new_password, email.
	 *
	 * @param	string
	 * @param	string
	 * @return	bool
	 */
	function reset_password($user_id, $new_pass_key, $new_password)
	{
		if ((strlen($user_id) > 0) AND (strlen($new_pass_key) > 0) AND (strlen($new_password) > 0)) {

			if (!is_null($user = $this->ci->users->get_user_by_id($user_id, TRUE))) {

				// Hash password using phpass
				$hasher = new PasswordHash(
						$this->ci->config->item('phpass_hash_strength', 'tank_auth'),
						$this->ci->config->item('phpass_hash_portable', 'tank_auth'));
				$hashed_password = $hasher->HashPassword($new_password);

				if ($this->ci->users->reset_password(
						$user_id,
						$hashed_password,
						$new_pass_key,
						$this->ci->config->item('forgot_password_expire', 'tank_auth'))) {	// success

					// Clear all user's autologins
					$this->ci->load->model('tank_auth/user_autologin');
					$this->ci->user_autologin->clear($user->id);

					return array(
						'user_id'		=> $user_id,
						'username'		=> $user->username,
						'email'			=> $user->email,
						'new_password'	=> $new_password,
					);
				}
			}
		}
		return NULL;
	}

	/**
	 * Change user password (only when user is logged in)
	 *
	 * @param	string
	 * @param	string
	 * @return	bool
	 */
	function change_password($old_pass, $new_pass)
	{
		$user_id = $this->ci->session->userdata('user_id');

		if (!is_null($user = $this->ci->users->get_user_by_id($user_id, TRUE))) {

			// Check if old password correct
			$hasher = new PasswordHash(
					$this->ci->config->item('phpass_hash_strength', 'tank_auth'),
					$this->ci->config->item('phpass_hash_portable', 'tank_auth'));
			if ($hasher->CheckPassword($old_pass, $user->password)) {			// success

				// Hash new password using phpass
				$hashed_password = $hasher->HashPassword($new_pass);

				// Replace old password with new one
				$this->ci->users->change_password($user_id, $hashed_password);
				return TRUE;

			} else {															// fail
				$this->error = array('old_password' => 'auth_incorrect_password');
			}
		}
		return FALSE;
	}

	/**
	 * Change user email (only when user is logged in) and return some data about user:
	 * user_id, username, new_email, new_email_key.
	 * The new email cannot be used for login or notification before it is activated.
	 *
	 * @param	string
	 * @param	string
	 * @return	array
	 */
	function set_new_email($new_email, $password)
	{
		$user_id = $this->ci->session->userdata('user_id');

		if (!is_null($user = $this->ci->users->get_user_by_id($user_id, TRUE))) {

			// Check if password correct
			$hasher = new PasswordHash(
					$this->ci->config->item('phpass_hash_strength', 'tank_auth'),
					$this->ci->config->item('phpass_hash_portable', 'tank_auth'));
			if ($hasher->CheckPassword($password, $user->password)) {			// success

				$data = array(
					'user_id'	=> $user_id,
					'username'	=> $user->username,
					'new_email'	=> $new_email,
				);

				if ($user->email == $new_email) {
					$this->error = array('email' => 'auth_current_email');

				} elseif ($user->new_email == $new_email) {		// leave email key as is
					$data['new_email_key'] = $user->new_email_key;
					return $data;

				} elseif ($this->ci->users->is_email_available($new_email)) {
					$data['new_email_key'] = md5(rand().microtime());
					$this->ci->users->set_new_email($user_id, $new_email, $data['new_email_key'], TRUE);
					return $data;

				} else {
					$this->error = array('email' => 'auth_email_in_use');
				}
			} else {															// fail
				$this->error = array('password' => 'auth_incorrect_password');
			}
		}
		return NULL;
	}

	/**
	 * Activate new email, if email activation key is valid.
	 *
	 * @param	string
	 * @param	string
	 * @return	bool
	 */
	function activate_new_email($user_id, $new_email_key)
	{
		if ((strlen($user_id) > 0) AND (strlen($new_email_key) > 0)) {
			return $this->ci->users->activate_new_email(
					$user_id,
					$new_email_key);
		}
		return FALSE;
	}

	/**
	 * Delete user from the site (only when user is logged in)
	 *
	 * @param	string
	 * @return	bool
	 */
	function delete_user($password)
	{
		$user_id = $this->ci->session->userdata('user_id');

		if (!is_null($user = $this->ci->users->get_user_by_id($user_id, TRUE))) {

			// Check if password correct
			$hasher = new PasswordHash(
					$this->ci->config->item('phpass_hash_strength', 'tank_auth'),
					$this->ci->config->item('phpass_hash_portable', 'tank_auth'));
			if ($hasher->CheckPassword($password, $user->password)) {			// success

				$this->ci->users->delete_user($user_id);
				$this->logout();
				return TRUE;

			} else {															// fail
				$this->error = array('password' => 'auth_incorrect_password');
			}
		}
		return FALSE;
	}




	/**
	 * Delete user by admin
	 *
	 * @param	string
	 * @return	bool
	 */
	function delete_user_by_admin($user_id=FALSE,$reason='관리자삭제')
	{
		if(! $this->is_admin()) {
			return FALSE;
		}

		if ($user_id && !is_null($user = $this->ci->users->get_user_by_id($user_id, TRUE))) {
			return $this->ci->users->delete_user($user_id,$reason);
		}
		else {
			// [2018-05-08] activated 되지 않은 회원도 그냥 삭제 처리
			return $this->ci->users->delete_user($user_id,$reason);
		}
		return FALSE;
	}



	/**
	 * Delete user by admin
	 *
	 * @param	string
	 * @return	bool
	 */
	function delete_excel_user_by_admin($reason='관리자삭제')
	{
		if(! $this->is_admin()) {
			return FALSE;
		}
		else {
			return $this->ci->users->delete_excel_user($reason);
		}
		return FALSE;
	}



	/**
	 * Delete user by admin
	 *
	 * @param	string
	 * @return	bool
	 */
	function delete_excel_npo_by_admin($reason='관리자삭제')
	{
		if(! $this->is_admin()) {
			return FALSE;
		}
		else {
			return $this->ci->users->delete_excel_npo($reason);
		}
		return FALSE;
	}





	/**
	 * Delete manager by admin
	 *
	 * @param	string
	 * @return	bool
	 */
	function delete_manager_by_admin($user_id=FALSE,$reason='관리자삭제')
	{
		if(! $this->is_admin()) {
			return FALSE;
		}

		if ($user_id && !is_null($user = $this->ci->users->get_admin_by_id($user_id, TRUE))) {
			return $this->ci->users->delete_manager($user_id,$reason);
		}
		else {
			// [2018-05-08] activated 되지 않은 회원도 그냥 삭제 처리
			return $this->ci->users->delete_manager($user_id,$reason);
		}
		return FALSE;
	}






	/**
	 * Get error message.
	 * Can be invoked after any failed operation such as login or register.
	 *
	 * @return	string
	 */
	function get_error_message()
	{
		return $this->error;
	}

	/**
	 * Save data for user's autologin
	 *
	 * @param	int
	 * @return	bool
	 */
	private function create_autologin($user_id)
	{
		$this->ci->load->helper('cookie');
		$key = substr(md5(uniqid(rand().get_cookie($this->ci->config->item('sess_cookie_name')))), 0, 16);

		$this->ci->load->model('tank_auth/user_autologin');
		$this->ci->user_autologin->purge($user_id);

		if ($this->ci->user_autologin->set($user_id, md5($key))) {
			set_cookie(array(
					'name' 		=> $this->ci->config->item('autologin_cookie_name', 'tank_auth'),
					'value'		=> serialize(array('user_id' => $user_id, 'key' => $key)),
					'expire'	=> $this->ci->config->item('autologin_cookie_life', 'tank_auth'),
			));
			return TRUE;
		}
		return FALSE;
	}

	/**
	 * Clear user's autologin data
	 *
	 * @return	void
	 */
	private function delete_autologin()
	{
		$this->ci->load->helper('cookie');
		if ($cookie = get_cookie($this->ci->config->item('autologin_cookie_name', 'tank_auth'), TRUE)) {

			$data = unserialize($cookie);

			$this->ci->load->model('tank_auth/user_autologin');
			$this->ci->user_autologin->delete($data['user_id'], md5($data['key']));

			delete_cookie($this->ci->config->item('autologin_cookie_name', 'tank_auth'));
		}
	}

	/**
	 * Login user automatically if he/she provides correct autologin verification
	 *
	 * @return	void
	 */
	private function autologin()
	{
		if (!$this->is_logged_in() AND !$this->is_logged_in(FALSE)) {			// not logged in (as any user)

			$this->ci->load->helper('cookie');
			if ($cookie = get_cookie($this->ci->config->item('autologin_cookie_name', 'tank_auth'), TRUE)) {

				$data = unserialize($cookie);

				if (isset($data['key']) AND isset($data['user_id'])) {

					$this->ci->load->model('tank_auth/user_autologin');
					if (!is_null($user = $this->ci->user_autologin->get($data['user_id'], md5($data['key'])))) {

						// Login user
						$this->ci->session->set_userdata(array(
								'user_id'	=> $user->id,
								'username'	=> $user->username,
								'status'	=> STATUS_ACTIVATED,
						));

						// Renew users cookie to prevent it from expiring
						set_cookie(array(
								'name' 		=> $this->ci->config->item('autologin_cookie_name', 'tank_auth'),
								'value'		=> $cookie,
								'expire'	=> $this->ci->config->item('autologin_cookie_life', 'tank_auth'),
						));

						$this->ci->users->update_login_info(
								$user->id,
								$this->ci->config->item('login_record_ip', 'tank_auth'),
								$this->ci->config->item('login_record_time', 'tank_auth'));
						return TRUE;
					}
				}
			}
		}
		return FALSE;
	}

	/**
	 * Check if login attempts exceeded max login attempts (specified in config)
	 *
	 * @param	string
	 * @return	bool
	 */
	function is_max_login_attempts_exceeded($login)
	{
		if ($this->ci->config->item('login_count_attempts', 'tank_auth')) {
			$this->ci->load->model('tank_auth/login_attempts');
			return $this->ci->login_attempts->get_attempts_num($this->ci->input->ip_address(), $login)
					>= $this->ci->config->item('login_max_attempts', 'tank_auth');
		}
		return FALSE;
	}

	/**
	 * Increase number of attempts for given IP-address and login
	 * (if attempts to login is being counted)
	 *
	 * @param	string
	 * @return	void
	 */
	private function increase_login_attempt($login)
	{
		if ($this->ci->config->item('login_count_attempts', 'tank_auth')) {
			if (!$this->is_max_login_attempts_exceeded($login)) {
				$this->ci->load->model('tank_auth/login_attempts');
				$this->ci->login_attempts->increase_attempt($this->ci->input->ip_address(), $login);
			}
		}
	}

	/**
	 * Clear all attempt records for given IP-address and login
	 * (if attempts to login is being counted)
	 *
	 * @param	string
	 * @return	void
	 */
	private function clear_login_attempts($login)
	{
		if ($this->ci->config->item('login_count_attempts', 'tank_auth')) {
			$this->ci->load->model('tank_auth/login_attempts');
			$this->ci->login_attempts->clear_attempts(
					$this->ci->input->ip_address(),
					$login,
					$this->ci->config->item('login_attempt_expire', 'tank_auth'));
		}
	}



	/** - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	 * [2021-08-09] 이후 추가
	 */


	/**
	 * Check if username admin.
	 * Can be called for instant form validation.
	 *
	 * @param	string
	 * @return	bool
	 */

	function is_sadmin()
	{
		if( $this->is_logged_in() )
		{
			$username = $this->get_username();
			return ((strlen($username) > 0) AND $this->ci->users->is_sadmin($username));
		}
	}

	function is_admin()
	{
		if( $this->is_logged_in() )
		{
			$username = $this->get_username();
			return ((strlen($username) > 0) AND $this->ci->users->is_admin($username));
		}
	}


	/**
	 * $is_admin === TRUE 인 경우,   로그인 회원 세션의 status_admin 값이 1이면 return TRUE
	 * $is_admin === FALSE 인 경우,  로그인 회원 세션의 status_admin 값이 0이면 return TRUE
	 */
	function is_logged_admin($is_admin = TRUE)
	{
		return $this->ci->session->userdata('status_admin') === ($is_admin ? STATUS_ADMIN : STATUS_NOT_ADMIN);
	}



	/**
	 * Check if admin user for login.
	 *
	 * @param	string
	 * @return	bool
	 */
	function is_admin_chk($login)
	{
		return ((strlen($login) > 0) AND $this->ci->users->is_admin_chk($login));
	}














	function excel_user_by_admin($nickname='',$username='',$password='',$email='',$phone='',$birth='') {

			$data = array(
				'created'	=> TIME_YMDHIS,
				'activated'	=> '1', //$this->ci->input->post('user_activated'),   // 관리자 회원 등록시 가입인증 처리
				'banned'	=> 0,
				'ban_reason'	=> NULL,
				'route'	=> 'excel'
			);

			$pfdata = array(
				'phone'	=> $phone,
				'birth'	=> $birth
			);

			// 신규등록시, level 
			// 회원구분(10:준회원, 20:정회원)
			//$level = $this->ci->input->post('level');
			//$data['level'] = 10;
			$data['level'] = 10;

			if('' !== $username) {
				$data['username'] = $username;
			}
			if('' !== $nickname) {
				$data['nickname'] = $nickname;
			}
			if('' !== $email) {
				$data['email'] = $email;
			}
			// 비밀번호 등록시에만 체크
			if('' !== $password) {
				// Hash password using phpass
				$hasher = new PasswordHash(
						$this->ci->config->item('phpass_hash_strength', 'tank_auth'),
						$this->ci->config->item('phpass_hash_portable', 'tank_auth'));
				$hashed_password = $hasher->HashPassword($password);
				$data['password'] = $hashed_password;
			}

			if (!is_null($res = $this->ci->users->excel_user_by_admin($data,$pfdata))) {
				$data['user_id'] = $res['user_id'];
				$data['password'] = $password;
				return $data;
			}

		return NULL;
	}





	// 비영리 민간 단체 정보 저장
	function excel_npo_by_admin($data=array()) {

			$data['route'] = 'excel';
			$data['created'] = TIME_YMDHIS;

			if (!is_null($res = $this->ci->users->excel_npo_by_admin($data))) {
				return $data;
			}

		return NULL;
	}





	function write_user_by_admin($user_idx=FALSE,$username='',$email='',$password='') {

		$phone = $this->ci->input->post('upro_phone_1');
		$phone .= $this->ci->input->post('upro_phone_2');
		$phone .= $this->ci->input->post('upro_phone_3');

		$banned = ('' != $this->ci->input->post('user_banned',NULL)) ? $this->ci->input->post('user_banned',NULL) : '';


		// npo 회원용
		$npo_name = $this->ci->input->post('nickname');
		$npo_manager = $this->ci->input->post('npo_manager');
		$npo_company = $this->ci->input->post('npo_company');

		$npo_tel = $this->ci->input->post('npo_tel');
		$data_pf = array('tel'=>$npo_tel, 'company'=>$npo_company, 'manager'=>$npo_manager);

		// 신규 등록
		if(! $user_idx)
		{

			$data = array(
				//'user_type'   => $this->ci->input->post('user_type'),
				//'level'       => $this->ci->input->post('user_level'),
				'created'	=> TIME_YMDHIS,
				'activated'	=> '1', //$this->ci->input->post('user_activated'),   // 관리자 회원 등록시 가입인증 처리
				'banned'	=> $banned,
				'ban_reason'	=> $this->ci->input->post('ban_reason',NULL),
				//'user_type'	=> $this->ci->input->post('user_type'),
				//'college_number'	=> $this->ci->input->post('college_number'),
				'last_ip'	=> $this->ci->input->ip_address(),
			);


			// 신규등록시, level 
			// 회원 구분 [10:준회원, 20:정회원]
			$level = $this->ci->input->post('level');
			$data['level'] = $level;

			if('' !== $username) {
				$data['username'] = $username;
			}
			else {
				// 아이디 임의 생성
				$username = time().mt_rand();
				$data['username'] = $username;
			}

			$nickname = $this->ci->input->post('nickname');
			$data['nickname'] = $nickname;


			if('' !== $email) {
				$data['email'] = $email;
			}

			// 비밀번호 등록시에만 체크
			if('' !== $password) {
				// Hash password using phpass
				$hasher = new PasswordHash(
						$this->ci->config->item('phpass_hash_strength', 'tank_auth'),
						$this->ci->config->item('phpass_hash_portable', 'tank_auth'));
				$hashed_password = $hasher->HashPassword($password);
				$data['password'] = $hashed_password;
			}

			if (!is_null($res = $this->ci->users->create_user_by_admin($data,$data_pf))) {
				$data['user_id'] = $res['user_id'];
				$data['user_idx'] = $res['user_id'];
				$data['password'] = $password;
				unset($data['last_ip']);
				return $data;
			}

		}
		// 수정
		else
		{

			// 회원 구분 [10:비회원, 20:정회원]
			$level = $this->ci->input->post('level');

			$data = array(
				//'user_type'   => $this->ci->input->post('user_type'),
				'level'       => $level,
				'nickname'       => $this->ci->input->post('nickname'),
				'email'       => $this->ci->input->post('user_email'),

				//'activated'	=> $this->ci->input->post('user_activated'),
				'banned'	=> $this->ci->input->post('user_banned'),
				'ban_reason'	=> $this->ci->input->post('ban_reason'),
				'last_ip'	=> $this->ci->input->ip_address(),
				//'phone' => $phone
			);



			if('' !== $email) {
				$data['email'] = $email;
			}

			// 비밀번호 등록시에만 체크
			if('' !== $password) {
				// Hash password using phpass
				$hasher = new PasswordHash(
						$this->ci->config->item('phpass_hash_strength', 'tank_auth'),
						$this->ci->config->item('phpass_hash_portable', 'tank_auth'));
				$hashed_password = $hasher->HashPassword($password);
				$data['password'] = $hashed_password;
			}

			if (!is_null($res = $this->ci->users->update_user_by_admin($user_idx,$data,$data_pf))) {
				$data['user_id'] = $res['user_id'];
				$data['password'] = $password;
				unset($data['last_ip']);
				return $data;
			}

		}

		return NULL;

	}


	function update_user_activate($user_idx=FALSE) {

			$data = array('activated' => 1);
			if (!is_null($res = $this->ci->users->update_user_by_admin($user_idx,$data))) {
				$data['user_id'] = $res['user_id'];
				return $data;
			}

	}







	function write_manager($user_idx=FALSE,$username='',$email='',$password='') {

		$banned = ('' != $this->ci->input->post('user_banned',NULL)) ? $this->ci->input->post('user_banned',NULL) : '';


		// 신규 등록
		if(! $user_idx)
		{

			$data = array(
				//'user_type'   => $this->ci->input->post('user_type'),
				//'level'       => $this->ci->input->post('user_level'),
				'created'	=> TIME_YMDHIS,
				'activated'	=> '1', //$this->ci->input->post('user_activated'),   // 관리자 회원 등록시 가입인증 처리
				'banned'	=> $banned,
				'ban_reason'	=> $this->ci->input->post('ban_reason',NULL),
				'last_ip'	=> $this->ci->input->ip_address(),
			);


			// 신규등록시, level => 100
			$level = $this->ci->input->post('level',100);
			$data['level'] = $level;

			if('' !== $username) {
				$data['username'] = $username;
			}

			$nickname = $this->ci->input->post('nickname');
			$data['nickname'] = $nickname;


			if('' !== $email) {
				$data['email'] = $email;
			}

			// 비밀번호 등록시에만 체크
			if('' !== $password) {
				// Hash password using phpass
				$hasher = new PasswordHash(
						$this->ci->config->item('phpass_hash_strength', 'tank_auth'),
						$this->ci->config->item('phpass_hash_portable', 'tank_auth'));
				$hashed_password = $hasher->HashPassword($password);
				$data['password'] = $hashed_password;
			}

			if (!is_null($res = $this->ci->users->create_manager($data))) {
				$data['user_id'] = $res['user_id'];
				$data['password'] = $password;
				unset($data['last_ip']);
				return $data;
			}

		}
		// 수정
		else
		{

			// default level => 10
			//$level = $this->ci->input->post('level',10);

			$data = array(
				//'user_type'   => $this->ci->input->post('user_type'),
				//'level'       => $level,
				'nickname'       => $this->ci->input->post('nickname'),
				'email'       => $this->ci->input->post('user_email'),
				'banned'	=> $this->ci->input->post('user_banned'),
				'ban_reason'	=> $this->ci->input->post('ban_reason'),
				'last_ip'	=> $this->ci->input->ip_address(),
			);

			if('' !== $email) {
				$data['email'] = $email;
			}

			// 비밀번호 등록시에만 체크
			if('' !== $password) {
				// Hash password using phpass
				$hasher = new PasswordHash(
						$this->ci->config->item('phpass_hash_strength', 'tank_auth'),
						$this->ci->config->item('phpass_hash_portable', 'tank_auth'));
				$hashed_password = $hasher->HashPassword($password);
				$data['password'] = $hashed_password;
			}

			if (!is_null($res = $this->ci->users->update_manager($user_idx,$data))) {
				$data['user_id'] = $res['user_id'];
				$data['password'] = $password;
				unset($data['last_ip']);
				return $data;
			}

		}

		return NULL;

	}






	// 사용자 마이페이지에서 정보 수정
	//function update_user_mypage($user_idx=FALSE,$username='',$email='',$password='') {
	function update_user_mypage($user_idx=FALSE,$password='') {

			$data = array(
				//'nickname'       => $this->ci->input->post('nickname'),
				//'email'       => $this->ci->input->post('user_email'),
				'last_ip'	=> $this->ci->input->ip_address()
			);

			// 비밀번호 등록시에만 체크
			if('' !== $password) {
				// Hash password using phpass
				$hasher = new PasswordHash(
						$this->ci->config->item('phpass_hash_strength', 'tank_auth'),
						$this->ci->config->item('phpass_hash_portable', 'tank_auth'));
				$hashed_password = $hasher->HashPassword($password);
				$data['password'] = $hashed_password;
			}

			if (!is_null($res = $this->ci->users->update_user_mypage($user_idx,$data))) {
				$data['user_id'] = $res['user_id'];
				$data['password'] = $password;
				//unset($data['last_ip']);
				return $data;
			}


			return NULL;

	}



	function user_edit($user_idx=FALSE) {

		if(! $user_idx)
			return false;

		$row = $this->ci->users->get_user_by_id($user_idx, TRUE);
		if( ! isset($row->username) ) {
			return false;
		}


		// user
		$password = $this->ci->input->post('password','');
		$password_confirm = $this->ci->input->post('password_confirm','');

		// upro
		//$company = $this->ci->input->post('company','');


		// 수정일시
		$data = array('modified'=>TIME_YMDHIS);

		// 비밀번호 등록시에만 체크
		if('' !== $password) {
			// Hash password using phpass
			$hasher = new PasswordHash(
					$this->ci->config->item('phpass_hash_strength', 'tank_auth'),
					$this->ci->config->item('phpass_hash_portable', 'tank_auth'));
			$hashed_password = $hasher->HashPassword($password);
			$data['password'] = $hashed_password;
		}

		if (!is_null($res = $this->ci->users->user_edit($user_idx,$data))) {
			$data['user_idx'] = $res['user_idx'];
			return $data;
		}


		return NULL;
	}




}

/* End of file Tank_auth.php */
/* Location: ./application/libraries/Tank_auth.php */
