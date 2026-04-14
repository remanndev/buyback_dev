<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Auth extends CI_Controller
{
    protected $slug = '';
    protected $partner = array();
    protected $post = array();
    protected $arr_seg = array();

    function __construct()
    {
        parent::__construct();

        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->helper('security');
        $this->load->library('tank_auth');
        $this->load->model('Partner_model');
        $this->lang->load('tank_auth');

        $this->arr_seg = $this->uri->segment_array();
        $this->post = $this->input->post(NULL, true);

        load_css('<link rel="stylesheet" href="'.CSS_DIR.'/page_auth.css?v=260414d" />');
    }

    function login($slug, $rpath_encode = FALSE)
    {
        $this->boot_partner($slug);

        $default_redirect = site_url('partner/' . $this->slug . '/sell');
        $rpath_decode = $rpath_encode ? url_code($rpath_encode, 'd') : $default_redirect;
        $rpath_admin = strpos($rpath_decode, '/partner/' . $this->slug . '/admin/');

        if ($this->tank_auth->is_logged_in()) {
            redirect($this->resolve_login_redirect($rpath_decode));
        } elseif ($this->tank_auth->is_logged_in(FALSE)) {
            redirect(base_url('auth/send_again'));
        } else {
            $data['login_by_username'] = ($this->config->item('login_by_username', 'tank_auth') AND
                    $this->config->item('use_username', 'tank_auth'));
            $data['login_by_email'] = $this->config->item('login_by_email', 'tank_auth');

            $this->form_validation->set_rules('login', 'Login', 'trim|required|xss_clean');
            $this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean');
            $this->form_validation->set_rules('remember', 'Remember me', 'integer');

            if ($this->config->item('login_count_attempts', 'tank_auth') AND
                    ($login = $this->input->post('login'))) {
                $login = $this->security->xss_clean($login);
            } else {
                $login = '';
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
                if ($this->tank_auth->login(
                        $this->form_validation->set_value('login'),
                        $this->form_validation->set_value('password'),
                        $this->form_validation->set_value('remember'),
                        $data['login_by_username'],
                        $data['login_by_email'])) {
                    redirect($this->resolve_login_redirect($rpath_decode));
                } else {
                    $errors = $this->tank_auth->get_error_message();
                    if (isset($errors['banned'])) {
                        $this->show_message($this->lang->line('auth_message_banned').' '.$errors['banned']);
                    } elseif (isset($errors['not_activated'])) {
                        redirect('/auth/send_again/');
                    } else {
                        foreach ($errors as $k => $v) {
                            $data['errors'][$k] = $this->lang->line($v);
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

            $data['login_id'] = ('' != $login) ? $login : '';
            $data['rpath_admin'] = $rpath_admin ? 'admin' : FALSE;
            $data['rpath_decode'] = $rpath_decode;
            $data['rpath_encode'] = $rpath_encode;
            $data['partner'] = $this->partner;
            $data['partner_manager_login_url'] = site_url('partner/' . $this->slug . '/admin/login');
            $data['header_view'] = 'partner/layout_header_view';
            $data['header_data'] = $this->build_header_data();
            $data['arr_meta'] = (object) array(
                'title' => $this->partner['name'] . ' 로그인',
            );
            $data['viewPage'] = 'auth/login_form';

            $this->load->view('layout/layout_view', $data);
        }
    }

    function logout($slug)
    {
        $this->boot_partner($slug);
        $this->tank_auth->logout();
        redirect(site_url('partner/' . $this->slug . '/login'));
    }

    function renew_captcha($slug)
    {
        $this->boot_partner($slug);
        echo $this->create_captcha();
    }

    function show_message($message)
    {
        $this->session->set_flashdata('message', $message);
        redirect(site_url('partner/' . $this->slug . '/login'));
    }

    function create_captcha()
    {
        $this->load->helper('captcha');

        $arr_cap = array(
            'img_path'      => $this->config->item('captcha_path', 'tank_auth'),
            'img_url'       => base_url().$this->config->item('captcha_path', 'tank_auth'),
            'font_path'     => $this->config->item('captcha_fonts_path', 'tank_auth'),
            'font_size'     => $this->config->item('captcha_font_size', 'tank_auth'),
            'img_width'     => $this->config->item('captcha_width', 'tank_auth'),
            'img_height'    => $this->config->item('captcha_height', 'tank_auth'),
            'show_grid'     => $this->config->item('captcha_grid', 'tank_auth'),
            'expiration'    => $this->config->item('captcha_expire', 'tank_auth'),
            'word_length'   => $this->config->item('captcha_word_length', 'tank_auth'),
            'pool'          => $this->config->item('captcha_pool', 'tank_auth'),
        );

        $cap = create_captcha($arr_cap);
        $this->session->set_flashdata(array(
            'captcha_word' => $cap['word'],
            'captcha_time' => $cap['time'],
        ));

        return $cap['image'];
    }

    function _check_captcha($code)
    {
        $time = $this->session->flashdata('captcha_time');
        $word = $this->session->flashdata('captcha_word');

        list($usec, $sec) = explode(" ", microtime());
        $now = ((float) $usec + (float) $sec);

        if ($now - $time > $this->config->item('captcha_expire', 'tank_auth')) {
            $this->form_validation->set_message('_check_captcha', $this->lang->line('auth_captcha_expired'));
            return FALSE;
        } elseif (($this->config->item('captcha_case_sensitive', 'tank_auth') AND $code != $word) OR
                strtolower($code) != strtolower($word)) {
            $this->form_validation->set_message('_check_captcha', $this->lang->line('auth_incorrect_captcha'));
            return FALSE;
        }

        return TRUE;
    }

    function create_recaptcha()
    {
        $this->load->helper('recaptcha');

        $options = "<script>var RecaptchaOptions = {theme: 'custom', custom_theme_widget: 'recaptcha_widget'};</script>\n";
        $html = recaptcha_get_html($this->config->item('recaptcha_public_key', 'tank_auth'), NULL, $this->config->item('use_ssl', 'tank_auth'));

        return $options.$html;
    }

    function _check_recaptcha()
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

    protected function build_header_data()
    {
        return array(
            'partner' => $this->partner,
            'home_url' => site_url('partner/' . $this->slug . '/sell'),
            'login_url' => site_url('partner/' . $this->slug . '/login'),
            'logout_url' => site_url('partner/' . $this->slug . '/logout'),
            'admin_url' => site_url('partner/' . $this->slug . '/admin/buyback'),
            'can_manage_partner' => $this->can_manage_partner(),
        );
    }

    protected function can_manage_partner()
    {
        if (!$this->tank_auth->is_admin()) {
            return false;
        }

        return $this->Partner_model->has_admin_access($this->partner['id'], $this->tank_auth->get_user_id());
    }

    protected function resolve_login_redirect($rpath_decode)
    {
        $partner_admin = site_url('partner/' . $this->slug . '/admin/buyback');
        $partner_sell = site_url('partner/' . $this->slug . '/sell');

        if ($this->tank_auth->is_admin() && $this->can_manage_partner()) {
            if ($rpath_decode && strpos($rpath_decode, '/partner/' . $this->slug . '/') !== FALSE) {
                return $rpath_decode;
            }

            return $partner_admin;
        }

        if ($rpath_decode && strpos($rpath_decode, '/partner/' . $this->slug . '/sell') !== FALSE) {
            return $rpath_decode;
        }

        return $partner_sell;
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
}

