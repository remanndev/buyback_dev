<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Partner extends CI_Controller
{
    protected $arr_seg = array();

    public function __construct()
    {
        parent::__construct();

        $this->load->helper(array('form', 'url', 'load', 'security'));
        $this->load->library('form_validation');
        $this->load->library('tank_auth');
        $this->load->model('Partner_model');
        $this->load->model('tank_auth/Users', 'auth_users');

        if (!$this->tank_auth->is_admin()) {
            $this->tank_auth->logout();
            redirect('/auth/login/' . url_code('/admin', 'e'));
        }

        $this->arr_seg = $this->uri->segment_array();
    }

    public function index()
    {
        redirect('/admin/partner/lists');
    }

    public function main()
    {
        redirect('/admin/partner/lists');
    }

    public function lists()
    {
        $data = array(
            'partners' => $this->Partner_model->get_list(),
            'arr_seg' => $this->arr_seg,
            'breadcrumb' => array(
                '회원사 관리' => base_url() . 'admin/partner/main',
                '회원사 목록' => '',
            ),
            'viewPage' => 'admin/partner_lists_view',
        );

        $this->load->view('admin/layout_view', $data);
    }

    public function view($partner_id = 0)
    {
        $partner_id = (int) $partner_id;
        $partner = $this->Partner_model->get_admin_detail($partner_id);
        if (!$partner) {
            show_404();
        }

        $primary_admin = $this->Partner_model->get_primary_admin($partner_id);
        $linked_admins = $this->Partner_model->get_partner_admins($partner_id);
        $additional_partner_admins = array();
        $both_admins = array();

        foreach ($linked_admins as $admin) {
            if (!empty($primary_admin['id']) && (int) $admin['id'] === (int) $primary_admin['id']) {
                continue;
            }

            if (strtoupper((string) $admin['type']) === 'BOTH') {
                $both_admins[] = $admin;
            } else {
                $additional_partner_admins[] = $admin;
            }
        }

        $data = array(
            'partner' => $partner,
            'primary_admin' => $primary_admin,
            'additional_partner_admins' => $additional_partner_admins,
            'both_admins' => $both_admins,
            'arr_seg' => $this->arr_seg,
            'breadcrumb' => array(
                '회원사 관리' => base_url() . 'admin/partner/main',
                '회원사 상세' => '',
            ),
            'viewPage' => 'admin/partner_view_view',
        );

        $this->load->view('admin/layout_view', $data);
    }

    public function write($partner_id = 0)
    {
        $partner_id = (int) $partner_id;
        $partner = $partner_id > 0 ? $this->Partner_model->get_admin_detail($partner_id) : null;
        if ($partner_id > 0 && !$partner) {
            show_404();
        }

        $primary_admin = $partner_id > 0 ? $this->Partner_model->get_primary_admin($partner_id) : null;
        $require_primary_admin = ($partner_id < 1 || empty($primary_admin));
        $errors = array();

        $this->form_validation->set_rules('name', '회원사명', 'trim|required|max_length[120]');
        $this->form_validation->set_rules('is_active', '활성 여부', 'trim');

        if ($partner_id < 1) {
            $this->form_validation->set_rules('slug', '슬러그', 'trim|required|alpha_dash|max_length[60]');
        }

        if ($require_primary_admin) {
            $this->form_validation->set_rules('admin_username', '대표 매니저 아이디', 'trim|required|alpha_dash|min_length[' . $this->config->item('username_min_length', 'tank_auth') . ']|max_length[' . $this->config->item('username_max_length', 'tank_auth') . ']');
            $this->form_validation->set_rules('admin_password', '대표 매니저 비밀번호', 'trim|required|min_length[' . $this->config->item('password_min_length', 'tank_auth') . ']|max_length[' . $this->config->item('password_max_length', 'tank_auth') . ']');
            $this->form_validation->set_rules('admin_password_confirm', '대표 매니저 비밀번호 확인', 'trim|required|matches[admin_password]');
        } else {
            $admin_password = trim((string) $this->input->post('admin_password', TRUE));
            $admin_password_confirm = trim((string) $this->input->post('admin_password_confirm', TRUE));
            if ($admin_password !== '' || $admin_password_confirm !== '') {
                $this->form_validation->set_rules('admin_password', '대표 매니저 비밀번호', 'trim|required|min_length[' . $this->config->item('password_min_length', 'tank_auth') . ']|max_length[' . $this->config->item('password_max_length', 'tank_auth') . ']');
                $this->form_validation->set_rules('admin_password_confirm', '대표 매니저 비밀번호 확인', 'trim|required|matches[admin_password]');
            }
        }

        $this->form_validation->set_rules('admin_nickname', '대표 매니저 이름', 'trim|required|max_length[50]');
        $this->form_validation->set_rules('admin_email', '대표 매니저 이메일', 'trim|valid_email|max_length[255]');

        if ($this->form_validation->run()) {
            $primary_username = trim((string) $this->input->post('admin_username', TRUE));
            $primary_nickname = trim((string) $this->input->post('admin_nickname', TRUE));
            $primary_email = trim((string) $this->input->post('admin_email', TRUE));
            $primary_password = trim((string) $this->input->post('admin_password', TRUE));
            $primary_password_confirm = trim((string) $this->input->post('admin_password_confirm', TRUE));

            $slug = ($partner_id > 0)
                ? (string) $partner['slug']
                : strtolower(trim((string) $this->input->post('slug', TRUE)));

            $conflict_user_id = !empty($primary_admin['id']) ? (int) $primary_admin['id'] : 0;
            $current_primary_username = !empty($primary_admin['username']) ? (string) $primary_admin['username'] : '';

            if ($require_primary_admin && $this->has_partner_admin_conflict(0, $primary_username, $primary_email, null)) {
                $errors['primary_account'] = '이미 사용 중인 아이디 또는 이메일입니다.';
            } elseif (!$require_primary_admin && $this->has_partner_admin_conflict($conflict_user_id, $current_primary_username, $primary_email, $primary_admin)) {
                $errors['primary_account'] = '이미 사용 중인 아이디 또는 이메일입니다.';
            } else {
                $partner_data = array(
                    'slug' => $slug,
                    'name' => trim((string) $this->input->post('name', TRUE)),
                    'is_active' => $this->input->post('is_active') ? 1 : 0,
                );

                $saved_partner_id = (int) $this->Partner_model->save_partner_basic($partner_id, $partner_data);
                if ($saved_partner_id > 0) {
                    $_POST['nickname'] = $primary_nickname;
                    $_POST['user_email'] = $primary_email;
                    $_POST['member_pw'] = $primary_password;
                    $_POST['member_pw_confirm'] = $primary_password_confirm;
                    $_POST['level'] = '80';

                    if ($require_primary_admin) {
                        $saved_admin = $this->tank_auth->write_manager(FALSE, $primary_username, $primary_email, $primary_password);
                        if (!is_null($saved_admin) && !empty($saved_admin['user_id'])) {
                            $saved_user_id = (int) $saved_admin['user_id'];
                            $this->auth_users->update_manager($saved_user_id, array('type' => 'PARTNER', 'level' => 80));
                            $this->Partner_model->link_admin($saved_partner_id, $saved_user_id);
                        } else {
                            $errors['primary_account'] = '대표 매니저 계정을 저장하지 못했습니다.';
                        }
                    } else {
                        $saved_admin = $this->tank_auth->write_manager((int) $primary_admin['id'], $current_primary_username, $primary_email, $primary_password);
                        if (is_null($saved_admin)) {
                            $errors['primary_account'] = '대표 매니저 계정을 수정하지 못했습니다.';
                        } else {
                            $this->auth_users->update_manager((int) $primary_admin['id'], array('nickname' => $primary_nickname, 'type' => 'PARTNER', 'level' => 80));
                            $this->Partner_model->link_admin($saved_partner_id, (int) $primary_admin['id']);
                        }
                    }

                    if (empty($errors)) {
                        sess_message('회원사 정보가 저장되었습니다.');
                        redirect('/admin/partner/view/' . $saved_partner_id);
                    }
                }
            }
        }

        $data = array(
            'partner_id' => $partner_id,
            'partner' => $partner,
            'primary_admin' => $primary_admin,
            'require_primary_admin' => $require_primary_admin,
            'errors' => $errors,
            'arr_seg' => $this->arr_seg,
            'breadcrumb' => array(
                '회원사 관리' => base_url() . 'admin/partner/main',
                ($partner_id > 0 ? '회원사 수정' : '회원사 등록') => '',
            ),
            'viewPage' => 'admin/partner_write_view',
        );

        $this->load->view('admin/layout_view', $data);
    }

    public function admins($partner_id = 0)
    {
        $partner_id = (int) $partner_id;
        if ($partner_id < 1) {
            alert('회원사를 먼저 선택해주세요.', '/admin/partner/lists');
        }

        $partner = $this->Partner_model->get_admin_detail($partner_id);
        if (!$partner) {
            alert('회원사를 먼저 선택해주세요.', '/admin/partner/lists');
        }

        $partner_admins = $this->Partner_model->get_partner_admins($partner_id, array('PARTNER'));
        $primary_admin = $this->Partner_model->get_primary_admin($partner_id);
        $additional_partner_admins = array();

        foreach ($partner_admins as $admin) {
            if (!empty($primary_admin['id']) && (int) $admin['id'] === (int) $primary_admin['id']) {
                continue;
            }
            $additional_partner_admins[] = $admin;
        }

        $data = array(
            'partner' => $partner,
            'primary_admin' => $primary_admin,
            'additional_partner_admins' => $additional_partner_admins,
            'both_admins' => $this->Partner_model->get_partner_admins($partner_id, array('BOTH')),
            'both_candidates' => $this->Partner_model->get_both_admin_candidates($partner_id),
            'arr_seg' => $this->arr_seg,
            'breadcrumb' => array(
                '회원사 관리' => base_url() . 'admin/partner/main',
                '추가 매니저 관리' => '',
            ),
            'viewPage' => 'admin/partner_admin_lists_view',
        );

        $this->load->view('admin/layout_view', $data);
    }

    public function managerlists()
    {
        $data = array(
            'manager_rows' => $this->Partner_model->get_all_partner_managers(),
            'arr_seg' => $this->arr_seg,
            'breadcrumb' => array(
                '회원사관리' => base_url() . 'admin/partner/main',
                '회원사 매니저 목록' => '',
            ),
            'viewPage' => 'admin/partner_manager_lists_view',
        );

        $this->load->view('admin/layout_view', $data);
    }

    public function adminwrite($partner_id = 0, $user_idx = 0)
    {
        $partner_id = (int) $partner_id;
        $user_idx = (int) $user_idx;
        $partner = $this->Partner_model->get_admin_detail($partner_id);
        if (!$partner) {
            show_404();
        }

        $admin_row = $user_idx > 0 ? $this->Partner_model->get_partner_admin($partner_id, $user_idx) : null;
        if ($user_idx > 0 && (!$admin_row || strtoupper((string) $admin_row['type']) !== 'PARTNER')) {
            show_404();
        }

        $errors = array();
        $this->form_validation->set_rules('nickname', '이름', 'trim|required|xss_clean');
        $this->form_validation->set_rules('user_email', '이메일', 'trim|xss_clean|valid_email');

        if ($user_idx < 1) {
            $this->form_validation->set_rules('username', '아이디', 'trim|required|xss_clean|min_length[' . $this->config->item('username_min_length', 'tank_auth') . ']|max_length[' . $this->config->item('username_max_length', 'tank_auth') . ']|alpha_dash');
            $this->form_validation->set_rules('member_pw', '비밀번호', 'trim|required|xss_clean|min_length[' . $this->config->item('password_min_length', 'tank_auth') . ']|max_length[' . $this->config->item('password_max_length', 'tank_auth') . ']');
            $this->form_validation->set_rules('member_pw_confirm', '비밀번호 확인', 'trim|required|xss_clean|matches[member_pw]');
        } else {
            $member_pw = trim((string) $this->input->post('member_pw', TRUE));
            $member_pw_confirm = trim((string) $this->input->post('member_pw_confirm', TRUE));
            if ($member_pw !== '' || $member_pw_confirm !== '') {
                $this->form_validation->set_rules('member_pw', '비밀번호', 'trim|required|xss_clean|min_length[' . $this->config->item('password_min_length', 'tank_auth') . ']|max_length[' . $this->config->item('password_max_length', 'tank_auth') . ']');
                $this->form_validation->set_rules('member_pw_confirm', '비밀번호 확인', 'trim|required|xss_clean|matches[member_pw]');
            }
        }

        if ($this->form_validation->run()) {
            $username = trim((string) $this->input->post('username', TRUE));
            $email = trim((string) $this->input->post('user_email', TRUE));
            $password = trim((string) $this->input->post('member_pw', TRUE));

            if ($this->has_partner_admin_conflict($user_idx, $username, $email, $admin_row)) {
                $errors['account'] = '이미 사용 중인 아이디 또는 이메일입니다.';
            } else {
                $_POST['level'] = '80';
                $saved = $this->tank_auth->write_manager($user_idx, $username, $email, $password);
                if (!is_null($saved)) {
                    $saved_user_id = !empty($saved['user_id']) ? (int) $saved['user_id'] : $user_idx;
                    if ($saved_user_id > 0) {
                        $this->auth_users->update_manager($saved_user_id, array('type' => 'PARTNER', 'level' => 80));
                        $this->Partner_model->link_admin($partner_id, $saved_user_id);
                    }
                    sess_message($user_idx > 0 ? '추가 매니저 정보가 수정되었습니다.' : '추가 매니저가 등록되었습니다.');
                    redirect('/admin/partner/admins/' . $partner_id);
                } else {
                    $errors['account'] = '추가 매니저 정보를 저장하지 못했습니다.';
                }
            }
        }

        $data = array(
            'partner' => $partner,
            'user_idx' => $user_idx,
            'row' => $admin_row ? (object) $admin_row : null,
            'arr_seg' => $this->arr_seg,
            'errors' => $errors,
            'breadcrumb' => array(
                '회원사 관리' => base_url() . 'admin/partner/main',
                '추가 매니저 등록/수정' => '',
            ),
            'viewPage' => 'admin/partner_admin_write_view',
        );

        $this->load->view('admin/layout_view', $data);
    }

    public function admindel($partner_id = 0, $user_idx = 0)
    {
        $partner_id = (int) $partner_id;
        $user_idx = (int) $user_idx;
        $partner = $this->Partner_model->get_admin_detail($partner_id);
        if (!$partner) {
            show_404();
        }

        $admin_row = $this->Partner_model->get_partner_admin($partner_id, $user_idx);
        if (!$admin_row || strtoupper((string) $admin_row['type']) !== 'PARTNER') {
            show_404();
        }

        $primary_admin = $this->Partner_model->get_primary_admin($partner_id);
        if (!empty($primary_admin['id']) && (int) $primary_admin['id'] === $user_idx) {
            sess_message('대표 매니저는 삭제할 수 없습니다.');
            redirect('/admin/partner/admins/' . $partner_id);
            return;
        }

        $this->Partner_model->unlink_admin($partner_id, $user_idx);
        $this->tank_auth->delete_manager_by_admin($user_idx, 'partner_manager_delete');
        sess_message('추가 매니저가 삭제되었습니다.');
        redirect('/admin/partner/admins/' . $partner_id);
    }

    public function link_admin($partner_id = 0)
    {
        $partner_id = (int) $partner_id;
        $partner = $this->Partner_model->get_admin_detail($partner_id);
        if (!$partner) {
            show_404();
        }

        if ($this->input->method(TRUE) !== 'POST') {
            redirect('/admin/partner/admins/' . $partner_id);
            return;
        }

        $admin_user_id = (int) $this->input->post('admin_user_id');
        $candidate_ids = array();
        foreach ($this->Partner_model->get_both_admin_candidates($partner_id) as $admin) {
            $candidate_ids[] = (int) $admin['id'];
        }

        if ($admin_user_id > 0 && in_array($admin_user_id, $candidate_ids, true)) {
            $this->Partner_model->link_admin($partner_id, $admin_user_id);
            sess_message('관리자 연동이 완료되었습니다.');
        }

        redirect('/admin/partner/admins/' . $partner_id);
    }

    public function unlink_admin($partner_id = 0, $user_idx = 0)
    {
        $partner_id = (int) $partner_id;
        $user_idx = (int) $user_idx;
        $partner = $this->Partner_model->get_admin_detail($partner_id);
        if (!$partner) {
            show_404();
        }

        $admin_row = $this->Partner_model->get_partner_admin($partner_id, $user_idx);
        if ($admin_row && strtoupper((string) $admin_row['type']) === 'BOTH') {
            $this->Partner_model->unlink_admin($partner_id, $user_idx);
            sess_message('관리자 연동이 해제되었습니다.');
        }

        redirect('/admin/partner/admins/' . $partner_id);
    }

    public function del($partner_id = 0)
    {
        $partner_id = (int) $partner_id;
        if ($partner_id < 1) {
            show_404();
        }

        $this->Partner_model->delete_partner($partner_id);
        sess_message('회원사가 삭제되었습니다.');
        redirect('/admin/partner/lists');
    }

    protected function has_partner_admin_conflict($user_idx, $username, $email, $current_row = null)
    {
        $user_idx = (int) $user_idx;
        $username = trim((string) $username);
        $email = trim((string) $email);

        if ($user_idx < 1) {
            if (!$this->auth_users->is_username_available($username) || !$this->auth_users->is_admin_available($username)) {
                return true;
            }

            if ($email !== '' && (!$this->auth_users->is_email_available($email) || !$this->auth_users->is_admin_email_available($email))) {
                return true;
            }

            return false;
        }

        $current_username = isset($current_row['username']) ? (string) $current_row['username'] : '';
        $current_email = isset($current_row['email']) ? (string) $current_row['email'] : '';

        if ($username !== '' && strcasecmp($username, $current_username) !== 0) {
            if (!$this->auth_users->is_username_available($username) || !$this->auth_users->is_admin_available($username)) {
                return true;
            }
        }

        if ($email !== '' && strcasecmp($email, $current_email) !== 0) {
            if (!$this->auth_users->is_email_available($email) || !$this->auth_users->is_admin_email_available($email)) {
                return true;
            }
        }

        return false;
    }
}
