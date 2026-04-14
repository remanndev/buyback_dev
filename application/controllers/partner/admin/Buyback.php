<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Buyback extends CI_Controller
{
    protected $slug = '';
    protected $partner = array();
    protected $arr_seg = array();

    function __construct()
    {
        parent::__construct();

        $this->load->helper(array('form', 'url', 'load', 'security'));
        $this->load->library('form_validation');
        $this->load->library('tank_auth');
        $this->load->model('Buyback_model');
        $this->load->model('Partner_model');

        $this->arr_seg = $this->uri->segment_array();

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
            'viewPage' => 'partner/admin/buyback/index',
        );

        $this->render_layout($data, $this->partner['name'] . ' 매입 요청 관리');
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
            'viewPage' => 'partner/admin/buyback/view',
        );

        $this->render_layout($data, $this->partner['name'] . ' 요청 상세');
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

    protected function render_layout($data, $title)
    {
        $data['header_view'] = 'partner/layout_header_view';
        $data['header_data'] = array(
            'partner' => $this->partner,
            'home_url' => site_url('partner/' . $this->slug . '/sell'),
            'login_url' => site_url('partner/' . $this->slug . '/login'),
            'logout_url' => site_url('partner/' . $this->slug . '/logout'),
            'admin_url' => site_url('partner/' . $this->slug . '/admin/buyback'),
            'can_manage_partner' => true,
        );
        $data['arr_meta'] = (object) array(
            'title' => $title,
        );

        $this->load->view('layout/layout_view', $data);
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
        if (!$this->tank_auth->is_admin()) {
            $this->tank_auth->logout();
            redirect('/partner/' . $this->slug . '/login/' . url_code(current_url(), 'e'));
        }

        if (!$this->Partner_model->has_admin_access($this->partner['id'], $this->tank_auth->get_user_id())) {
            show_error('해당 파트너 관리자 권한이 없습니다.', 403);
        }
    }
}
