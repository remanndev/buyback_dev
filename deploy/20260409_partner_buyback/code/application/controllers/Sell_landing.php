<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sell_landing extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->helper(array('url', 'form'));
        $this->load->library('tank_auth');
        $this->load->model('Partner_model');
        load_css('<link rel="stylesheet" href="'.CSS_DIR.'/page_buyback.css?v=260326" />');
    }

    public function index()
    {
        $remann_partner = $this->Partner_model->get_by_slug('remann');

        $remann_link = site_url('partner/remann');
        $remann_name = !empty($remann_partner['name']) ? $remann_partner['name'] : '리맨';
        $partner_link = site_url('partner/company');

        $data = array(
            'remann_link' => $remann_link,
            'remann_name' => $remann_name,
            'partner_link' => $partner_link,
            'header_view' => 'sell/header_view',
            'header_data' => $this->build_header_data(),
            'arr_meta' => $this->build_meta(
                '중고기기 매입 신청',
                '노트북, 데스크탑, 모니터와 부품까지 쉽고 빠르게 중고기기 매입을 신청하세요.',
                site_url('sell')
            ),
            'viewPage' => 'sell/landing_view',
        );

        $this->load->view('layout/layout_view', $data);
    }

    public function save_devices()
    {
        $this->json(array(
            'result' => 'fail',
            'message' => '회원사 전용 링크에서만 신청할 수 있습니다.',
            'redirect_url' => site_url('sell'),
        ));
    }

    public function pickup()
    {
        redirect('/sell');
    }

    public function submit()
    {
        redirect('/sell');
    }

    protected function json($data)
    {
        $this->output
            ->set_content_type('application/json', 'utf-8')
            ->set_output(json_encode($data, JSON_UNESCAPED_UNICODE));
    }

    protected function build_header_data()
    {
        return array(
            'home_url' => base_url(),
            'member_login_url' => base_url('auth/login'),
            'member_logout_url' => base_url('auth/logout'),
            'admin_url' => base_url('admin'),
            'is_member_logged_in' => $this->tank_auth->is_logged_in(),
            'is_site_admin_logged_in' => $this->tank_auth->is_admin(),
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
