<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Partner_auth extends CI_Controller
{
    protected $slug = '';
    protected $partner = array();

    public function __construct()
    {
        parent::__construct();

        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->library('partner_admin_auth');
        $this->load->library('tank_auth');
        $this->load->model('Partner_model');

        load_css('<link rel="stylesheet" href="'.CSS_DIR.'/page_auth.css?v=260414d" />');
    }

    public function login($slug, $rpath_encode = FALSE)
    {
        $this->boot_partner($slug);

        $default_redirect = site_url('partner/' . $this->slug . '/admin/buyback');
        $redirect_url = $rpath_encode ? url_code($rpath_encode, 'd') : $default_redirect;

        if ($this->partner_admin_auth->is_logged_in($this->partner['id'])) {
            redirect($this->resolve_redirect($redirect_url));
        }

        $this->form_validation->set_rules('login', 'Login', 'trim|required');
        $this->form_validation->set_rules('password', 'Password', 'trim|required');

        $data = array(
            'partner' => $this->partner,
            'error_message' => '',
            'rpath_encode' => $rpath_encode,
            'header_view' => 'partner/header_view',
            'header_data' => $this->build_header_data(),
            'arr_meta' => $this->build_meta(
                $this->partner['name'] . ' 매니저 로그인',
                $this->partner['name'] . ' 회원사 매니저 로그인 페이지입니다.',
                site_url('partner/' . $this->slug . '/admin/login')
            ),
            'viewPage' => 'partner/admin/login_view',
        );

        if ($this->form_validation->run()) {
            if ($this->partner_admin_auth->login(
                $this->partner['id'],
                $this->form_validation->set_value('login'),
                $this->form_validation->set_value('password')
            )) {
                redirect($this->resolve_redirect($redirect_url));
            }

            $data['error_message'] = $this->partner_admin_auth->get_error();
        }

        $this->load->view('layout/layout_view', $data);
    }

    public function logout($slug)
    {
        $this->boot_partner($slug);
        $this->partner_admin_auth->logout();
        redirect(site_url('partner/' . $this->slug . '/admin/login'));
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
        $default_redirect = site_url('partner/' . $this->slug . '/admin/buyback');

        if ($redirect_url && strpos($redirect_url, '/partner/' . $this->slug . '/admin/') !== FALSE) {
            return $redirect_url;
        }

        return $default_redirect;
    }

    protected function build_header_data()
    {
        return array(
            'header_mode' => 'partner_admin',
            'partner' => $this->partner,
            'home_url' => site_url('partner/' . $this->slug . '/sell'),
            'member_login_url' => site_url('partner/' . $this->slug . '/login'),
            'member_logout_url' => site_url('partner/' . $this->slug . '/logout'),
            'partner_admin_login_url' => site_url('partner/' . $this->slug . '/admin/login'),
            'partner_admin_logout_url' => site_url('partner/' . $this->slug . '/admin/logout'),
            'partner_admin_url' => site_url('partner/' . $this->slug . '/admin/buyback'),
            'is_member_logged_in' => $this->tank_auth->is_logged_in(),
            'is_site_admin_logged_in' => $this->tank_auth->is_admin(),
            'is_partner_admin_logged_in' => false,
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

