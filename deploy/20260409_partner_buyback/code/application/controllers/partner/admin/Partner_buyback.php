<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Partner_buyback extends CI_Controller
{
    protected $slug = '';
    protected $partner = array();

    public function __construct()
    {
        parent::__construct();

        $this->load->helper(array('form', 'url', 'load', 'security'));
        $this->load->library('form_validation');
        $this->load->library('partner_admin_auth');
        $this->load->library('tank_auth');
        $this->load->library('buyback_ros_api');
        $this->load->model('Buyback_model');
        $this->load->model('Partner_model');

        load_css('<link rel="stylesheet" href="'.CSS_DIR.'/page_buyback.css?v=260326" />');
    }

    public function index($slug)
    {
        $this->boot_partner($slug);
        $this->guard_admin();

        $data = array(
            'partner' => $this->partner,
            'requests' => $this->Buyback_model->get_request_list($this->partner['id']),
            'buyback_admin_base_path' => 'partner/' . $this->slug . '/admin/buyback',
            'flash_message' => $this->session->flashdata('partner_buyback_message'),
            'flash_error' => $this->session->flashdata('partner_buyback_error'),
            'header_view' => 'partner/header_view',
            'header_data' => $this->build_header_data(),
            'arr_meta' => (object) array(
                'title' => $this->partner['name'] . ' Partner Buyback Admin',
            ),
            'viewPage' => 'partner/admin/buyback_index_view',
        );

        $this->load->view('layout/layout_view', $data);
    }

    public function view($slug, $id = 0)
    {
        $this->boot_partner($slug);
        $this->guard_admin();

        $request = $this->Buyback_model->get_request_detail((int) $id, $this->partner['id']);
        if (empty($request)) {
            show_404();
        }

        $data = array(
            'partner' => $this->partner,
            'request' => $request,
            'buyback_admin_base_path' => 'partner/' . $this->slug . '/admin/buyback',
            'flash_message' => $this->session->flashdata('partner_buyback_message'),
            'flash_error' => $this->session->flashdata('partner_buyback_error'),
            'header_view' => 'partner/header_view',
            'header_data' => $this->build_header_data(),
            'arr_meta' => (object) array(
                'title' => $this->partner['name'] . ' Request Detail',
            ),
            'viewPage' => 'partner/admin/buyback_detail_view',
        );

        $this->load->view('layout/layout_view', $data);
    }

    public function delete($slug, $id = 0)
    {
        $this->boot_partner($slug);
        $this->guard_admin();

        if ((int) $id < 1) {
            show_404();
        }

        $this->Buyback_model->delete_request((int) $id, $this->partner['id']);
        redirect(site_url('partner/' . $this->slug . '/admin/buyback'));
    }

    public function send($slug, $id = 0)
    {
        $this->boot_partner($slug);
        $this->guard_admin();

        $id = (int) $id;
        if ($id < 1) {
            show_404();
        }

        $request = $this->Buyback_model->get_request_detail($id, $this->partner['id']);
        if (empty($request)) {
            show_404();
        }

        if (!empty($request['ros_wa_id']) && isset($request['api_send_status']) && $request['api_send_status'] === 'SENT') {
            $this->session->set_flashdata('partner_buyback_message', 'This request was already sent to ROS.');
            redirect(site_url('partner/' . $this->slug . '/admin/buyback/view/' . $id));
            return;
        }

        $result = $this->buyback_ros_api->send_request($this->partner, $request);
        $update_data = array(
            'api_sent_at' => date('Y-m-d H:i:s'),
            'api_request_payload' => $result['request_payload'],
            'api_response_payload' => $result['response_payload'],
        );

        if ($result['success']) {
            $update_data['api_send_status'] = 'SENT';
            $update_data['api_error_message'] = null;
            $update_data['ros_wa_id'] = $result['ros_wa_id'];

            $this->Buyback_model->update_request($id, $update_data, $this->partner['id']);
            $this->session->set_flashdata('partner_buyback_message', 'ROS request was sent successfully.');
        } else {
            $update_data['api_send_status'] = 'FAILED';
            $update_data['api_error_message'] = $result['error_message'];

            $this->Buyback_model->update_request($id, $update_data, $this->partner['id']);
            $this->session->set_flashdata('partner_buyback_error', $result['error_message']);
        }

        redirect(site_url('partner/' . $this->slug . '/admin/buyback/view/' . $id));
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

    protected function guard_admin()
    {
        if (!$this->partner_admin_auth->is_logged_in($this->partner['id'])) {
            redirect('/partner/' . $this->slug . '/admin/login/' . url_code(current_url(), 'e'));
        }
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
            'is_partner_admin_logged_in' => true,
        );
    }
}
