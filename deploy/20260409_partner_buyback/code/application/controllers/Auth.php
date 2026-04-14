<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Auth extends CI_Controller
{
	function __construct()
	{
		parent::__construct();

		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		$this->load->helper('security');
		$this->load->library('tank_auth');
		$this->lang->load('tank_auth');

		// seg array
		$this->arr_seg = $this->uri->segment_array();

		// xss_clean ???β뼯爰껃퐲????쇰쭓???
		$this->post = $this->input->post(NULL, true);
		
		
		load_css('<link rel="stylesheet" href="'.CSS_DIR.'/page_auth.css?v=260414d" />');

	}

	function index()
	{
		if ($message = $this->session->flashdata('message')) {
			//$this->load->view('auth/general_message', array('message' => $message));

			$data['message'] = $message;
			$this->apply_page_meta($data, 'message');
			$data['viewPage'] = 'auth/general_message';
			$this->load->view('layout/layout_view', $data);
		} else {
			redirect('/auth/login/');
		}
	}

	/**
	 * Login user on the site
	 *
	 * @return void
	 */
	function login($rpath_encode=FALSE)
	{

        if($rpath_encode)
          $rpath_decode = url_code($rpath_encode, 'd');
        else
          $rpath_decode = '';

        $partner_manager_login_url = '';
        if (preg_match('#/partner/([a-z0-9-]+)/#i', $rpath_decode, $partner_matches)) {
            $partner_manager_login_url = site_url('partner/' . strtolower($partner_matches[1]) . '/admin/login');
        }

		//echo $rpath_decode;
		//exit;


		// ???援온??잙갭큔???????볥궙?袁р뵾???? ??????癲????꿔꺂?????용Ъ?
		$rpath_admin = strpos($rpath_decode,'admin');


		if ($this->tank_auth->is_logged_in()) {									// logged in
			//redirect('');
			//redirect(base_url($rpath_decode));
			redirect($rpath_decode);

		} elseif ($this->tank_auth->is_logged_in(FALSE)) {						// logged in, not activated
			redirect(base_url('auth/send_again'));

		} else {

			//print_r($this->post);
			//exit;

			$data['login_by_username'] = ($this->config->item('login_by_username', 'tank_auth') AND
					$this->config->item('use_username', 'tank_auth'));
			$data['login_by_email'] = $this->config->item('login_by_email', 'tank_auth');

			$this->form_validation->set_rules('login', 'Login', 'trim|required|xss_clean');
			$this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean');
			$this->form_validation->set_rules('remember', 'Remember me', 'integer');

			// Get login for counting attempts to login
			if ($this->config->item('login_count_attempts', 'tank_auth') AND
					($login = $this->input->post('login'))) {
				$login = $this->security->xss_clean($login);
			} else {
				$login = '';
			}

			$data['use_recaptcha'] = $this->config->item('use_recaptcha', 'tank_auth');
			if ($this->tank_auth->is_max_login_attempts_exceeded($login)) {
				if ($data['use_recaptcha'])
					$this->form_validation->set_rules('recaptcha_response_field', 'Confirmation Code', 'trim|xss_clean|required|callback__check_recaptcha');
				else
					$this->form_validation->set_rules('captcha', 'Confirmation Code', 'trim|xss_clean|required|callback__check_captcha');
			}
			$data['errors'] = array();

			if ($this->form_validation->run()) {								// validation ok
				if ($this->tank_auth->login(
						$this->form_validation->set_value('login'),
						$this->form_validation->set_value('password'),
						$this->form_validation->set_value('remember'),
						$data['login_by_username'],
						$data['login_by_email'])) {								// success

					$login = $this->form_validation->set_value('login');
					if($this->tank_auth->is_admin_chk($login)) {
						redirect('/admin');
					}
					else {
						//redirect('');
						redirect($rpath_decode);
					}

				} else {
					$errors = $this->tank_auth->get_error_message();
					if (isset($errors['banned'])) {								// banned user
						$this->_show_message($this->lang->line('auth_message_banned').' '.$errors['banned']);

					} elseif (isset($errors['not_activated'])) {				// not activated user
						redirect('/auth/send_again/');

					} else {													// fail
						foreach ($errors as $k => $v)	$data['errors'][$k] = $this->lang->line($v);
					}
				}
			}
			$data['show_captcha'] = FALSE;
			if ($this->tank_auth->is_max_login_attempts_exceeded($login)) {
				$data['show_captcha'] = TRUE;
				if ($data['use_recaptcha']) {
					$data['recaptcha_html'] = $this->_create_recaptcha();
				} else {
					$data['captcha_html'] = $this->_create_captcha();
				}
			}
			
			// ????썹땟?㈑?? ?????????Β???汝??吏?????? ?꿔꺂?????용Ъ?
			$data['login_id'] = ('' != $login) ? $login : '';

			// ???援온??잙갭큔???????볥궙?袁р뵾???? ????????? ?꿔꺂?????용Ъ?
			$data['rpath_admin'] = $rpath_admin ? 'admin' : FALSE;
			
			$data['rpath_decode'] = $rpath_decode;
			$data['rpath_encode'] = $rpath_encode;
            $data['partner_manager_login_url'] = $partner_manager_login_url;
			$this->apply_page_meta($data, 'login');

			//$this->load->view('auth/login_form', $data);
			$data['viewPage'] = 'auth/login_form';
			$this->load->view('layout/layout_view', $data);
		}
	}

	/**
	 * Logout user
	 *
	 * @return void
	 */
	function logout()
	{
		$this->tank_auth->logout();

		//$this->_show_message($this->lang->line('auth_message_logged_out'));

		redirect(base_url());
	}

	/**
	 * Register user on the site
	 *
	 * @return void
	 */
	function register()
	{

		/**
		* [2025-07-25]
		* ????Β??뼐 ???????醫딆쓧???? ??? ?????놃닓??
		* ????寃?????? ??⑤㈇????????汝??吏??癲ル슢??遺븍퉲?
		*/

		//redirect( base_url('auth/login') );
		//return false;
		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -



		if ($this->tank_auth->is_logged_in()) {									// logged in
			redirect('');

		} elseif ($this->tank_auth->is_logged_in(FALSE)) {						// logged in, not activated
			redirect('/auth/send_again/');

		} elseif (!$this->config->item('allow_registration', 'tank_auth')) {	// registration is off
			$this->_show_message($this->lang->line('auth_message_registration_disabled'));

		} else {
			$use_username = $this->config->item('use_username', 'tank_auth');
			if ($use_username) {
			$this->form_validation->set_rules('username', 'Username', 'trim|required|xss_clean|min_length['.$this->config->item('username_min_length', 'tank_auth').']|max_length['.$this->config->item('username_max_length', 'tank_auth').']|alpha_dash|is_unique[users.username]|is_unique[users_admin.username]');
			}

			$use_nickname = $this->config->item('use_nickname', 'tank_auth');
			if ($use_nickname) {
			$this->form_validation->set_rules('nickname', 'Name', 'trim|required|xss_clean|min_length['.$this->config->item('nickname_min_length', 'tank_auth').']|max_length['.$this->config->item('nickname_max_length', 'tank_auth').']');
			}

			$this->form_validation->set_rules('email', 'Email', 'trim|required|xss_clean|valid_email|is_unique[users.email]|is_unique[users_admin.email]');
			$this->form_validation->set_rules('phone', 'Phone', 'trim|required|xss_clean|max_length[20]');
			// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
			// ??쑬?甕곕뜇???怨론???釉?揶쎛?館釉?袁⑥쨯 雅뚯눘苑랃㎗?롡봺
			// $this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean|min_length['.$this->config->item('password_min_length', 'tank_auth').']|max_length['.$this->config->item('password_max_length', 'tank_auth').']|alpha_dash');
			// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
			$this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean|min_length['.$this->config->item('password_min_length', 'tank_auth').']|max_length['.$this->config->item('password_max_length', 'tank_auth').']');
			$this->form_validation->set_rules('confirm_password', 'Confirm Password', 'trim|required|xss_clean|matches[password]');

			$captcha_registration	= $this->config->item('captcha_registration', 'tank_auth');
			$use_recaptcha			= $this->config->item('use_recaptcha', 'tank_auth');
			if ($captcha_registration) {
				if ($use_recaptcha) {
					$this->form_validation->set_rules('recaptcha_response_field', 'Confirmation Code', 'trim|xss_clean|required|callback__check_recaptcha');
				} else {
					$this->form_validation->set_rules('captcha', 'Confirmation Code', 'trim|xss_clean|required|callback__check_captcha');
				}
			}
			$data['errors'] = array();

			$email_activation = $this->config->item('email_activation', 'tank_auth');

			if ($this->form_validation->run()) {								// validation ok
				if (!is_null($data = $this->tank_auth->create_user(
						$use_username ? $this->form_validation->set_value('username') : '',
						$use_nickname ? $this->form_validation->set_value('nickname') : '',
						$this->form_validation->set_value('email'),
						$this->form_validation->set_value('password'),
						$email_activation))) {									// success

					$data['site_name'] = $this->config->item('website_name', 'tank_auth');

					if ($email_activation) {									// send "activate" email
						$data['activation_period'] = $this->config->item('email_activation_expire', 'tank_auth') / 3600;

						$this->_send_email('activate', $data['email'], $data);

						unset($data['password']); // Clear password (just for any case)

						$this->_show_message($this->lang->line('auth_message_registration_completed_1'));

					} else {
						if ($this->config->item('email_account_details', 'tank_auth')) {	// send "welcome" email

							$this->_send_email('welcome', $data['email'], $data);
						}
						unset($data['password']); // Clear password (just for any case)

						//$this->_show_message($this->lang->line('auth_message_registration_completed_2').' '.anchor('/auth/login/', 'Login'));

						$user_type = '';
						/*
						if($data['level'] == 20) {
							$user_type = 'NPO';
						}
						else if($data['level'] == 10) {
                            $user_type = '??怨쀫틮';
						}
						*/

                        $this->_show_message($user_type . $this->lang->line('auth_message_registration_completed_2').' <div style="padding-top:15px;">'.anchor('/auth/login/', '<button type="button" class="btn btn-dark">'.$user_type.'??????β돦裕????꾩룆?餓??띠럾???/button>').'</div>');

					}
				} else {
					$errors = $this->tank_auth->get_error_message();
					foreach ($errors as $k => $v)	$data['errors'][$k] = $this->lang->line($v);
				}
			}
			if ($captcha_registration) {
				if ($use_recaptcha) {
					$data['recaptcha_html'] = $this->_create_recaptcha();
				} else {
					$data['captcha_html'] = $this->_create_captcha();
				}
			}
			$data['use_username'] = $use_username;
			$data['use_nickname'] = $use_nickname;
			$data['captcha_registration'] = $captcha_registration;
			$data['use_recaptcha'] = $use_recaptcha;
			$this->apply_page_meta($data, 'register');
			//$this->load->view('auth/register_form', $data);
			$data['viewPage'] = 'auth/register_form';
			$this->load->view('layout/layout_view', $data);
		}
	}

	/**
	 * Send activation email again, to the same or new email address
	 *
	 * @return void
	 */
	function send_again()
	{
		if (!$this->tank_auth->is_logged_in(FALSE)) {							// not logged in or activated
			// ?亦껋꼨援?? ????⑤베鍮??汝??吏?????썹땟???????씸???
			$this->tank_auth->logout();
			// ?汝??吏???????볥궙?袁р뵾??????????⑤베鍮??????
			redirect('/auth/login/');

		} else {

			$this->form_validation->set_rules('email', 'Email', 'trim|required|xss_clean|valid_email');

			$data['errors'] = array();

			if ($this->form_validation->run()) {								// validation ok
				if (!is_null($data = $this->tank_auth->change_email(
						$this->form_validation->set_value('email')))) {			// success

					$data['site_name']	= $this->config->item('website_name', 'tank_auth');
					$data['activation_period'] = $this->config->item('email_activation_expire', 'tank_auth') / 3600;

					$this->_send_email('activate', $data['email'], $data);

					$this->_show_message(sprintf($this->lang->line('auth_message_activation_email_sent'), $data['email']));

				} else {
					$errors = $this->tank_auth->get_error_message();
					foreach ($errors as $k => $v)	$data['errors'][$k] = $this->lang->line($v);
				}
			}

			// ?亦껋꼨援?? ????⑤베鍮??汝??吏?????썹땟???????씸???
			$this->tank_auth->logout();

			//$this->load->view('auth/send_again_form', $data);
			//$data['viewPage'] = 'auth/send_again_form';
			$this->apply_page_meta($data, 'activate');
			$data['viewPage'] = 'auth/activate_msg';
			$this->load->view('layout/layout_view', $data);
		}
	}

	/**
	 * Activate user account.
	 * User is verified by user_id and authentication code in the URL.
	 * Can be called by clicking on link in mail.
	 *
	 * @return void
	 */
	function activate()
	{
		$user_id		= $this->uri->segment(3);
		$new_email_key	= $this->uri->segment(4);

		// Activate user
		if ($this->tank_auth->activate_user($user_id, $new_email_key)) {		// success
			$this->tank_auth->logout();
			$this->_show_message($this->lang->line('auth_message_activation_completed').' '.anchor('/auth/login/', 'Login'));

		} else {																// fail
			$this->_show_message($this->lang->line('auth_message_activation_failed'));
		}
	}

	/**
	 * Generate reset code (to change password) and send it to user
	 *
	 * @return void
	 */
	function forgot_password()
	{
		if ($this->tank_auth->is_logged_in()) {									// logged in
			redirect('');

		} elseif ($this->tank_auth->is_logged_in(FALSE)) {						// logged in, not activated
			redirect('/auth/send_again/');

		} else {
			$this->form_validation->set_rules('login', 'Email or login', 'trim|required|xss_clean');

			$data['errors'] = array();

			if ($this->form_validation->run()) {								// validation ok
				if (!is_null($data = $this->tank_auth->forgot_password(
						$this->form_validation->set_value('login')))) {

					$data['site_name'] = $this->config->item('website_name', 'tank_auth');

					// Send email with password activation link
					$this->_send_email('forgot_password', $data['email'], $data);

					$this->_show_message($this->lang->line('auth_message_new_password_sent'));

				} else {
					$errors = $this->tank_auth->get_error_message();
					foreach ($errors as $k => $v)	$data['errors'][$k] = $this->lang->line($v);
				}
			}
			//$this->load->view('auth/forgot_password_form', $data);
			$this->apply_page_meta($data, 'forgot_password');
			$data['viewPage'] = 'auth/forgot_password_form';
			$this->load->view('layout/layout_view', $data);
		}
	}

	/**
	 * Replace user password (forgotten) with a new one (set by user).
	 * User is verified by user_id and authentication code in the URL.
	 * Can be called by clicking on link in mail.
	 *
	 * @return void
	 */
	function reset_password()
	{
		$user_id		= $this->uri->segment(3);
		$new_pass_key	= $this->uri->segment(4);

		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		// ????????袁⑸즴????醫딆쓧??嚥싳쇎紐?????썹땟怨⒲뀋????녿뮝???ル튉??욧낮???β뼯?蹂λ뤀
		//$this->form_validation->set_rules('new_password', 'New Password', 'trim|required|xss_clean|min_length['.$this->config->item('password_min_length', 'tank_auth').']|max_length['.$this->config->item('password_max_length', 'tank_auth').']|alpha_dash');
		$this->form_validation->set_rules('new_password', 'New Password', 'trim|required|xss_clean|min_length['.$this->config->item('password_min_length', 'tank_auth').']|max_length['.$this->config->item('password_max_length', 'tank_auth').']');
		$this->form_validation->set_rules('confirm_new_password', 'Confirm New Password', 'trim|required|xss_clean|matches[new_password]');

		$data['errors'] = array();

		if ($this->form_validation->run()) {								// validation ok
			if (!is_null($data = $this->tank_auth->reset_password(
					$user_id, $new_pass_key,
					$this->form_validation->set_value('new_password')))) {	// success

				$data['site_name'] = $this->config->item('website_name', 'tank_auth');

				// Send email with new password
				$this->_send_email('reset_password', $data['email'], $data);

				$this->_show_message($this->lang->line('auth_message_new_password_activated').' '.anchor('/auth/login/', 'Login'));

			} else {														// fail
				$this->_show_message($this->lang->line('auth_message_new_password_failed'));
			}
		} else {
			// Try to activate user by password key (if not activated yet)
			if ($this->config->item('email_activation', 'tank_auth')) {
				$this->tank_auth->activate_user($user_id, $new_pass_key, FALSE);
			}

			if (!$this->tank_auth->can_reset_password($user_id, $new_pass_key)) {
				$this->_show_message($this->lang->line('auth_message_new_password_failed'));
			}
		}
		//$this->load->view('auth/reset_password_form', $data);
		$this->apply_page_meta($data, 'reset_password');
		$data['viewPage'] = 'auth/reset_password_form';
		$this->load->view('layout/layout_view', $data);
	}

	/**
	 * Change user password
	 *
	 * @return void
	 */
	function change_password()
	{
		if (!$this->tank_auth->is_logged_in()) {								// not logged in or not activated
			redirect('/auth/login/');

		} else {
			$this->form_validation->set_rules('old_password', 'Old Password', 'trim|required|xss_clean');
			// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
			// ????????袁⑸즴????醫딆쓧??嚥싳쇎紐?????썹땟怨⒲뀋????녿뮝???ル튉??욧낮???β뼯?蹂λ뤀
			//$this->form_validation->set_rules('new_password', 'New Password', 'trim|required|xss_clean|min_length['.$this->config->item('password_min_length', 'tank_auth').']|max_length['.$this->config->item('password_max_length', 'tank_auth').']|alpha_dash');
			$this->form_validation->set_rules('new_password', 'New Password', 'trim|required|xss_clean|min_length['.$this->config->item('password_min_length', 'tank_auth').']|max_length['.$this->config->item('password_max_length', 'tank_auth').']');
			$this->form_validation->set_rules('confirm_new_password', 'Confirm New Password', 'trim|required|xss_clean|matches[new_password]');

			$data['errors'] = array();

			if ($this->form_validation->run()) {								// validation ok
				if ($this->tank_auth->change_password(
						$this->form_validation->set_value('old_password'),
						$this->form_validation->set_value('new_password'))) {	// success
					$this->_show_message($this->lang->line('auth_message_password_changed'));

				} else {														// fail
					$errors = $this->tank_auth->get_error_message();
					foreach ($errors as $k => $v)	$data['errors'][$k] = $this->lang->line($v);
				}
			}
			//$this->load->view('auth/change_password_form', $data);
			$this->apply_page_meta($data, 'change_password');
			$data['viewPage'] = 'auth/change_password_form';
			$this->load->view('layout/layout_view', $data);
		}
	}

	/**
	 * Change user email
	 *
	 * @return void
	 */
	function change_email()
	{
		if (!$this->tank_auth->is_logged_in()) {								// not logged in or not activated
			redirect('/auth/login/');

		} else {
			$this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean');
			$this->form_validation->set_rules('email', 'Email', 'trim|required|xss_clean|valid_email');

			$data['errors'] = array();

			if ($this->form_validation->run()) {								// validation ok
				if (!is_null($data = $this->tank_auth->set_new_email(
						$this->form_validation->set_value('email'),
						$this->form_validation->set_value('password')))) {			// success

					$data['site_name'] = $this->config->item('website_name', 'tank_auth');

					// Send email with new email address and its activation link
					$this->_send_email('change_email', $data['new_email'], $data);

					$this->_show_message(sprintf($this->lang->line('auth_message_new_email_sent'), $data['new_email']));

				} else {
					$errors = $this->tank_auth->get_error_message();
					foreach ($errors as $k => $v)	$data['errors'][$k] = $this->lang->line($v);
				}
			}
			//$this->load->view('auth/change_email_form', $data);
			$this->apply_page_meta($data, 'change_email');
			$data['viewPage'] = 'auth/change_email_form';
			$this->load->view('layout/layout_view', $data);
		}
	}

	/**
	 * Replace user email with a new one.
	 * User is verified by user_id and authentication code in the URL.
	 * Can be called by clicking on link in mail.
	 *
	 * @return void
	 */
	function reset_email()
	{
		$user_id		= $this->uri->segment(3);
		$new_email_key	= $this->uri->segment(4);

		// Reset email
		if ($this->tank_auth->activate_new_email($user_id, $new_email_key)) {	// success
			$this->tank_auth->logout();
			$this->_show_message($this->lang->line('auth_message_new_email_activated').' '.anchor('/auth/login/', 'Login'));

		} else {																// fail
			$this->_show_message($this->lang->line('auth_message_new_email_failed'));
		}
	}

	/**
	 * Delete user from the site (only when user is logged in)
	 *
	 * @return void
	 */
	function unregister()
	{
		if (!$this->tank_auth->is_logged_in()) {								// not logged in or not activated
			redirect('/auth/login/');

		} else {
			$this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean');

			$data['errors'] = array();

			if ($this->form_validation->run()) {								// validation ok
				if ($this->tank_auth->delete_user(
						$this->form_validation->set_value('password'))) {		// success
					$this->_show_message($this->lang->line('auth_message_unregistered'));

				} else {														// fail
					$errors = $this->tank_auth->get_error_message();
					foreach ($errors as $k => $v)	$data['errors'][$k] = $this->lang->line($v);
				}
			}
			//$this->load->view('auth/unregister_form', $data);
			$this->apply_page_meta($data, 'unregister');
			$data['viewPage'] = 'auth/unregister_form';
			$this->load->view('layout/layout_view', $data);
		}
	}

	/**
	 * Show info message
	 *
	 * @param	string
	 * @return	void
	 */
	function _show_message($message)
	{
		$this->session->set_flashdata('message', $message);
		redirect('/auth/');
	}

	protected function apply_page_meta(&$data, $type)
	{
		$site_name = $this->config->item('website_name', 'tank_auth');
		$map = array(
			'message' => array(
				'title' => 'Notice',
				'description' => 'Remann buyback service notice page.',
			),
			'login' => array(
				'title' => 'Login',
				'description' => 'Remann buyback service login page.',
			),
			'register' => array(
				'title' => 'Register',
				'description' => 'Remann buyback service registration page.',
			),
			'activate' => array(
				'title' => 'Account Activation',
				'description' => 'Please check the email verification and account activation guide.',
			),
			'forgot_password' => array(
				'title' => 'Forgot Password',
				'description' => 'Password reset guide page.',
			),
			'reset_password' => array(
				'title' => 'Reset Password',
				'description' => 'Set a new password on this page.',
			),
			'change_password' => array(
				'title' => 'Change Password',
				'description' => 'Change your account password on this page.',
			),
			'change_email' => array(
				'title' => 'Change Email',
				'description' => 'Change your account email address on this page.',
			),
			'unregister' => array(
				'title' => 'Unregister',
				'description' => 'Remann buyback service unregister page.',
			),
		);

		$meta = isset($map[$type]) ? $map[$type] : $map['message'];
		$data['arr_meta'] = (object) array(
			'title' => $meta['title'] . ' | ' . $site_name,
			'description' => $meta['description'],
			'og_title' => $meta['title'] . ' | ' . $site_name,
			'og_description' => $meta['description'],
			'og_url' => current_url(),
		);
	}

	/**
	 * Send email message of given type (activate, forgot_password, etc.)
	 *
	 * @param	string
	 * @param	string
	 * @param	array
	 * @return	void
	 */
	function _send_email($type, $email, &$data)
	{
		$this->load->library('email');
		$this->email->from($this->config->item('webmaster_email', 'tank_auth'), $this->config->item('website_name', 'tank_auth'));
		$this->email->reply_to($this->config->item('webmaster_email', 'tank_auth'), $this->config->item('website_name', 'tank_auth'));
		$this->email->to($email);
		$this->email->subject(sprintf($this->lang->line('auth_subject_'.$type), $this->config->item('website_name', 'tank_auth')));
		$this->email->message($this->load->view('email/'.$type.'-html', $data, TRUE));
		$this->email->set_alt_message($this->load->view('email/'.$type.'-txt', $data, TRUE));
		$this->email->send();
	}

	/**
	 * Create CAPTCHA image to verify user as a human
	 *
	 * @return	string
	 */
	function _create_captcha()
	{
		$this->load->helper('captcha');

		/*
		$cap = create_captcha(array(
			'img_path'		=> RT_PATH.'/'.$this->config->item('captcha_path', 'tank_auth'),
			'img_url'		=> base_url().$this->config->item('captcha_path', 'tank_auth'),
			'font_path'		=> RT_PATH.'/'.$this->config->item('captcha_fonts_path', 'tank_auth'),
			'font_size'		=> $this->config->item('captcha_font_size', 'tank_auth'),
			'img_width'		=> $this->config->item('captcha_width', 'tank_auth'),
			'img_height'	=> $this->config->item('captcha_height', 'tank_auth'),
			'show_grid'		=> $this->config->item('captcha_grid', 'tank_auth'),
			'expiration'	=> $this->config->item('captcha_expire', 'tank_auth'),
			'word_length'	=> $this->config->item('captcha_word_length', 'tank_auth'),
			'pool'	=> $this->config->item('captcha_pool', 'tank_auth'),
		));
		*/



		$arr_cap = array(
			'img_path'		=> $this->config->item('captcha_path', 'tank_auth'),
			'img_url'		=> base_url().$this->config->item('captcha_path', 'tank_auth'),
			'font_path'		=> $this->config->item('captcha_fonts_path', 'tank_auth'),
			'font_size'		=> $this->config->item('captcha_font_size', 'tank_auth'),
			'img_width'		=> $this->config->item('captcha_width', 'tank_auth'),
			'img_height'	=> $this->config->item('captcha_height', 'tank_auth'),
			'show_grid'		=> $this->config->item('captcha_grid', 'tank_auth'),
			'expiration'	=> $this->config->item('captcha_expire', 'tank_auth'),
			'word_length'	=> $this->config->item('captcha_word_length', 'tank_auth'),
			'pool'	=> $this->config->item('captcha_pool', 'tank_auth'),
		);
		//print_r($arr_cap);

		//echo $this->arr_seg[2];
		//echo '<script>alert("'.$this->arr_seg[2].'");</script>';
		if(isset($this->arr_seg[2])) {
			if($this->arr_seg[2] == 'register' OR $this->arr_seg[2] == 'login' OR $this->arr_seg[2] == 'renew_captcha') {
				$arr_cap['img_width']=200;
				$arr_cap['img_height']=50;
			}
		}

		$cap = create_captcha($arr_cap);



		// Save captcha params in session
		$this->session->set_flashdata(array(
				'captcha_word' => $cap['word'],
				'captcha_time' => $cap['time'],
		));

		return $cap['image'];
	}

	// captcha ??醫딆┣???
	function renew_captcha()
	{
		echo $this->_create_captcha();
	}



	/**
	 * Callback function. Check if CAPTCHA test is passed.
	 *
	 * @param	string
	 * @return	bool
	 */
	function _check_captcha($code)
	{
		$time = $this->session->flashdata('captcha_time');
		$word = $this->session->flashdata('captcha_word');

		list($usec, $sec) = explode(" ", microtime());
		$now = ((float)$usec + (float)$sec);

		if ($now - $time > $this->config->item('captcha_expire', 'tank_auth')) {
			$this->form_validation->set_message('_check_captcha', $this->lang->line('auth_captcha_expired'));
			return FALSE;

		} elseif (($this->config->item('captcha_case_sensitive', 'tank_auth') AND
				$code != $word) OR
				strtolower($code) != strtolower($word)) {
			$this->form_validation->set_message('_check_captcha', $this->lang->line('auth_incorrect_captcha'));
			return FALSE;
		}
		return TRUE;
	}

	/**
	 * Create reCAPTCHA JS and non-JS HTML to verify user as a human
	 *
	 * @return	string
	 */
	function _create_recaptcha()
	{
		$this->load->helper('recaptcha');

		// Add custom theme so we can get only image
		$options = "<script>var RecaptchaOptions = {theme: 'custom', custom_theme_widget: 'recaptcha_widget'};</script>\n";

		// Get reCAPTCHA JS and non-JS HTML
		$html = recaptcha_get_html($this->config->item('recaptcha_public_key', 'tank_auth'), NULL, $this->config->item('use_ssl', 'tank_auth'));

		return $options.$html;
	}

	/**
	 * Callback function. Check if reCAPTCHA test is passed.
	 *
	 * @return	bool
	 */
	function _check_recaptcha()
	{
		$this->load->helper('recaptcha');

		$resp = recaptcha_check_answer($this->config->item('recaptcha_private_key', 'tank_auth'),
				$_SERVER['REMOTE_ADDR'],
				$_POST['recaptcha_challenge_field'],
				$_POST['recaptcha_response_field']);

		if (!$resp->is_valid) {
			$this->form_validation->set_message('_check_recaptcha', $this->lang->line('auth_incorrect_captcha'));
			return FALSE;
		}
		return TRUE;
	}

}

/* End of file auth.php */
/* Location: ./application/controllers/auth.php */

