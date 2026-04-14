<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Member_auth extends CI_Controller
{
    protected $slug = '';
    protected $partner = array();

    public function __construct()
    {
        parent::__construct();

        $this->load->helper(array('form', 'url', 'security'));
        $this->load->library('form_validation');
        $this->load->library('tank_auth');
        $this->load->library('partner_admin_auth');
        $this->load->model('Partner_model');
        $this->lang->load('tank_auth');

        load_css('<link rel="stylesheet" href="'.CSS_DIR.'/page_auth.css?v=260414d" />');
    }

    public function login($slug, $rpath_encode = FALSE)
    {
        $this->boot_partner($slug);

        $default_redirect = site_url('partner/' . $this->slug . '/sell');
        $redirect_url = $rpath_encode ? url_code($rpath_encode, 'd') : $default_redirect;

        if ($this->tank_auth->is_logged_in()) {
            redirect($this->resolve_redirect($redirect_url));
        }

        if ($this->tank_auth->is_logged_in(FALSE)) {
            redirect(base_url('auth/send_again'));
        }

        $login = '';
        $data = array();
        $data['login_by_username'] = ($this->config->item('login_by_username', 'tank_auth') AND
            $this->config->item('use_username', 'tank_auth'));
        $data['login_by_email'] = $this->config->item('login_by_email', 'tank_auth');

        $this->form_validation->set_rules('login', 'Login', 'trim|required|xss_clean');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean');
        $this->form_validation->set_rules('remember', 'Remember me', 'integer');

        if ($this->config->item('login_count_attempts', 'tank_auth') AND ($posted_login = $this->input->post('login'))) {
            $login = $this->security->xss_clean($posted_login);
        }

        $data['use_recaptcha'] = $this->config->item('use_recaptcha', 'tank_auth');
        if ($this->tank_auth->is_max_login_attempts_exceeded($login)) {
            if ($data['use_recaptcha']) {
                $this->form_validation->set_rules('recaptcha_response_field', 'Confirmation Code', 'trim|xss_clean|required|callback__check_recaptcha');
            } else {
                $this->form_validation->set_rules('captcha', 'Confirmation Code', 'trim|xss_clean|required|callback__check_captcha');
            }
        }

        $data['errors'] = array();

        if ($this->form_validation->run()) {
            $login_value = $this->form_validation->set_value('login');

            if ($this->tank_auth->is_admin_chk($login_value)) {
                $data['errors']['login'] = 'Partner admins must use the partner admin login page.';
            } elseif ($this->tank_auth->login(
                $login_value,
                $this->form_validation->set_value('password'),
                $this->form_validation->set_value('remember'),
                $data['login_by_username'],
                $data['login_by_email']
            )) {
                redirect($this->resolve_redirect($redirect_url));
            } else {
                $errors = $this->tank_auth->get_error_message();
                if (isset($errors['banned'])) {
                    $this->show_message($this->lang->line('auth_message_banned') . ' ' . $errors['banned']);
                } elseif (isset($errors['not_activated'])) {
                    redirect('/auth/send_again/');
                } else {
                    foreach ($errors as $key => $value) {
                        $data['errors'][$key] = $this->lang->line($value);
                    }
                }
            }
        }

        $data['show_captcha'] = FALSE;
        if ($this->tank_auth->is_max_login_attempts_exceeded($login)) {
            $data['show_captcha'] = TRUE;
            if ($data['use_recaptcha']) {
                $data['recaptcha_html'] = $this->create_recaptcha();
            } else {
                $data['captcha_html'] = $this->create_captcha();
            }
        }

        $data['login_id'] = $login;
        $data['rpath_admin'] = FALSE;
        $data['rpath_decode'] = $redirect_url;
        $data['rpath_encode'] = $rpath_encode;
        $data['partner'] = $this->partner;
        $data['partner_manager_login_url'] = site_url('partner/' . $this->slug . '/admin/login');
        $data['header_view'] = 'partner/header_view';
        $data['header_data'] = $this->build_header_data();
        $data['arr_meta'] = $this->build_meta(
            $this->partner['name'] . ' 회원 로그인',
            $this->partner['name'] . ' 매입 신청을 위한 회원 로그인 페이지입니다.',
            site_url('partner/' . $this->slug . '/login')
        );
        $data['viewPage'] = 'auth/login_form';

        $this->load->view('layout/layout_view', $data);
    }

    public function logout($slug)
    {
        $this->boot_partner($slug);
        $this->tank_auth->logout();
        redirect(site_url('partner/' . $this->slug . '/login'));
    }

    public function show_message($message)
    {
        $this->session->set_flashdata('message', $message);
        redirect(site_url('partner/' . $this->slug . '/login'));
    }

    public function create_captcha()
    {
        $this->load->helper('captcha');

        $config = array(
            'img_path' => $this->config->item('captcha_path', 'tank_auth'),
            'img_url' => base_url().$this->config->item('captcha_path', 'tank_auth'),
            'font_path' => $this->config->item('captcha_fonts_path', 'tank_auth'),
            'font_size' => $this->config->item('captcha_font_size', 'tank_auth'),
            'img_width' => $this->config->item('captcha_width', 'tank_auth'),
            'img_height' => $this->config->item('captcha_height', 'tank_auth'),
            'show_grid' => $this->config->item('captcha_grid', 'tank_auth'),
            'expiration' => $this->config->item('captcha_expire', 'tank_auth'),
            'word_length' => $this->config->item('captcha_word_length', 'tank_auth'),
            'pool' => $this->config->item('captcha_pool', 'tank_auth'),
        );

        $captcha = create_captcha($config);
        $this->session->set_flashdata(array(
            'captcha_word' => $captcha['word'],
            'captcha_time' => $captcha['time'],
        ));

        return $captcha['image'];
    }

    public function _check_captcha($code)
    {
        $time = $this->session->flashdata('captcha_time');
        $word = $this->session->flashdata('captcha_word');
        list($usec, $sec) = explode(' ', microtime());
        $now = ((float) $usec + (float) $sec);

        if ($now - $time > $this->config->item('captcha_expire', 'tank_auth')) {
            $this->form_validation->set_message('_check_captcha', $this->lang->line('auth_captcha_expired'));
            return FALSE;
        }

        if (($this->config->item('captcha_case_sensitive', 'tank_auth') AND $code != $word) OR strtolower($code) != strtolower($word)) {
            $this->form_validation->set_message('_check_captcha', $this->lang->line('auth_incorrect_captcha'));
            return FALSE;
        }

        return TRUE;
    }

    public function create_recaptcha()
    {
        $this->load->helper('recaptcha');

        $options = "<script>var RecaptchaOptions = {theme: 'custom', custom_theme_widget: 'recaptcha_widget'};</script>\n";
        $html = recaptcha_get_html($this->config->item('recaptcha_public_key', 'tank_auth'), NULL, $this->config->item('use_ssl', 'tank_auth'));

        return $options.$html;
    }

    public function _check_recaptcha()
    {
        $this->load->helper('recaptcha');

        $resp = recaptcha_check_answer(
            $this->config->item('recaptcha_private_key', 'tank_auth'),
            $_SERVER['REMOTE_ADDR'],
            $_POST['recaptcha_challenge_field'],
            $_POST['recaptcha_response_field']
        );

        if (!$resp->is_valid) {
            $this->form_validation->set_message('_check_recaptcha', $this->lang->line('auth_incorrect_captcha'));
            return FALSE;
        }

        return TRUE;
    }

    protected function boot_partner($slug)
    {
        $this->slug = trim((string) $slug);
        $partner = $this->Partner_model->get_by_slug($this->slug);

        if (!$partner) {
            show_404();
        }

        $this->partner = $partner;
    }

    protected function resolve_redirect($redirect_url)
    {
        $default_redirect = site_url('partner/' . $this->slug . '/sell');

        if ($redirect_url && strpos($redirect_url, '/partner/' . $this->slug . '/sell') !== FALSE) {
            return $redirect_url;
        }

        return $default_redirect;
    }

    protected function build_header_data()
    {
        return array(
            'header_mode' => 'partner_public',
            'partner' => $this->partner,
            'home_url' => site_url('partner/' . $this->slug . '/sell'),
            'member_login_url' => site_url('partner/' . $this->slug . '/login'),
            'member_logout_url' => site_url('partner/' . $this->slug . '/logout'),
            'partner_admin_login_url' => site_url('partner/' . $this->slug . '/admin/login'),
            'partner_admin_logout_url' => site_url('partner/' . $this->slug . '/admin/logout'),
            'partner_admin_url' => site_url('partner/' . $this->slug . '/admin/buyback'),
            'is_member_logged_in' => $this->tank_auth->is_logged_in(),
            'is_site_admin_logged_in' => $this->tank_auth->is_admin(),
            'is_partner_admin_logged_in' => $this->partner_admin_auth->is_logged_in($this->partner['id']),
        );
    }

    protected function build_meta($title, $description, $url = '')
    {
        $site_name = $this->config->item('website_name', 'tank_auth');

        return (object) array(
            'title' => $title . ' | ' . $site_name,
            'description' => $description,
            'og_title' => $title . ' | ' . $site_name,
            'og_description' => $description,
            'og_url' => $url ?: current_url(),
        );
    }
}

