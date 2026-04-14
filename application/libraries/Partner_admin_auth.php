<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once(APPPATH.'libraries/phpass-0.5/PasswordHash.php');

class Partner_admin_auth
{
    protected $ci;
    protected $session_key = 'partner_sess';
    protected $error = '';

    public function __construct()
    {
        $this->ci =& get_instance();
        $this->ci->load->library('session');
        $this->ci->load->model('tank_auth/users');
        $this->ci->load->model('Partner_model');
    }

    public function login($partner_id, $login, $password)
    {
        $partner_id = (int) $partner_id;
        $login = trim((string) $login);
        $password = (string) $password;
        $this->error = '';

        if ($partner_id < 1 || $login === '' || $password === '') {
            $this->error = 'Please check the login fields.';
            return false;
        }

        $user = $this->ci->users->get_user_by_username_admin($login, array('PARTNER', 'BOTH'));
        if (!$user) {
            $this->error = 'Invalid login credentials.';
            return false;
        }

        $hasher = new PasswordHash(
            $this->ci->config->item('phpass_hash_strength', 'tank_auth'),
            $this->ci->config->item('phpass_hash_portable', 'tank_auth')
        );

        if (!$hasher->CheckPassword($password, $user->password)) {
            $this->error = 'Invalid login credentials.';
            return false;
        }

        if ((int) $user->activated !== 1 || (int) $user->banned === 1) {
            $this->error = 'This admin account is not available.';
            return false;
        }

        if (!$this->ci->Partner_model->has_admin_access($partner_id, (int) $user->id)) {
            $this->error = 'This admin account is not assigned to the partner.';
            return false;
        }

        $this->ci->session->set_userdata($this->session_key, array(
            'partner_id' => $partner_id,
            'user_id' => (int) $user->id,
            'username' => (string) $user->username,
            'nickname' => isset($user->nickname) ? (string) $user->nickname : '',
            'logged_in' => true,
            'logged_at' => date('Y-m-d H:i:s'),
        ));

        return true;
    }

    public function logout()
    {
        $this->ci->session->unset_userdata($this->session_key);
    }

    public function is_logged_in($partner_id = null)
    {
        $session = $this->get_session();
        if (empty($session['logged_in'])) {
            return false;
        }

        if ($partner_id !== null && (int) $session['partner_id'] !== (int) $partner_id) {
            return false;
        }

        return true;
    }

    public function get_user_id()
    {
        $session = $this->get_session();
        return isset($session['user_id']) ? (int) $session['user_id'] : 0;
    }

    public function get_error()
    {
        return $this->error;
    }

    protected function get_session()
    {
        $session = $this->ci->session->userdata($this->session_key);
        return is_array($session) ? $session : array();
    }
}
