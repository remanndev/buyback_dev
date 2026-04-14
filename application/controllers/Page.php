<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Page extends CI_Controller {

    function __construct()
    {
        parent::__construct();

        if (2 == 1)
        {
            $sections = array(
                'benchmarks' => TRUE, 'memory_usage' => TRUE,
                'config' => FALSE, 'controller_info' => FALSE, 'get' => FALSE, 'post' => FALSE, 'queries' => FALSE,
                'uri_string' => FALSE, 'http_headers' => FALSE, 'session_data' => FALSE
            );
            $this->output->set_profiler_sections($sections);
            $this->output->enable_profiler(TRUE);
        }

        $this->load->library('tank_auth');
        $this->load->helper(array('form', 'load'));
        $this->arr_seg = $this->uri->segment_array();
    }

    function _remap($page_name = FALSE, $arr = FALSE)
    {
        if (!$page_name) {
            alert('잘못된 경로로 접속하셨습니다.', '/');
        }

        $legal_pages = array(
            'terms_use' => 'terms_use',
            'term_use' => 'terms_use',
            'terms_privacy' => 'terms_privacy',
            'term_privacy' => 'terms_privacy',
        );

        if (isset($legal_pages[$page_name])) {
            $this->render_legal_page($legal_pages[$page_name]);
            return;
        }

        $page_code = (isset($arr[0]) && $arr[0] != '') ? $arr[0] : FALSE;
        $page_uri = (isset($arr[1]) && $arr[1] != '') ? $arr[1] : '';

        $view_page = 'page/' . trim($page_name);
        if (!is_file(realpath(APPPATH) . '/views/' . $view_page . '.php')) {
            alert('해당 파일이나 경로가 존재하지 않습니다.');
        }

        $this->load->library('querystring', NULL, 'param');
        $param =& $this->param;
        $qstr = $param->qstr;

        $pno = isset($qstr['pno']) ? $qstr['pno'] : false;
        $add_url = ($pno) ? '?pno=' . $pno : '';

        $data = array(
            'page_ttl' => '페이지 - ' . $page_name,
            'add_url' => $add_url,
            'pno' => $pno,
            'page_code' => $page_code,
            'arr_seg' => $this->arr_seg,
            'viewPage' => $view_page
        );

        if ('rsv' == $page_name OR 'rsv_1' == $page_name) {
            $arr_where = array(
                'sql_select' => '*',
                'sql_from' => 'landing_agree',
                'sql_where' => array('idx' => 1)
            );
            $row = $this->basic_model->arr_get_row($arr_where);
            $data['row'] = $row;
        }

        $selected_year = isset($this->arr_seg[3]) ? $this->arr_seg[3] : date('Y');
        $selected_month = isset($this->arr_seg[4]) ? $this->arr_seg[4] : date('m');

        $data['selected_year'] = $selected_year;
        $data['selected_month'] = $selected_month;

        $this->load->view('layout_view', $data);
    }

    protected function render_legal_page($page_name)
    {
        load_css('<link rel="stylesheet" href="' . CSS_DIR . '/page_buyback.css?v=260326" />');
        load_css('<link rel="stylesheet" href="' . CSS_DIR . '/page_buyback_mypage.css?v=260410c" />');
        load_css('<link rel="stylesheet" href="' . CSS_DIR . '/page_terms.css?v=260410a" />');

        $meta_map = array(
            'terms_use' => array(
                'title' => json_decode('"\uc774\uc6a9\uc57d\uad00"'),
                'description' => json_decode('"\ub9ac\ub9e8 \uc911\uace0 \ub9e4\uc785 \uc11c\ube44\uc2a4 \uc774\uc6a9\uc57d\uad00\uc744 \ud655\uc778\ud558\uc138\uc694."'),
            ),
            'terms_privacy' => array(
                'title' => json_decode('"\uac1c\uc778\uc815\ubcf4\ucc98\ub9ac\ubc29\uce68"'),
                'description' => json_decode('"\ub9ac\ub9e8 \uc911\uace0 \ub9e4\uc785 \uc11c\ube44\uc2a4\uc758 \uac1c\uc778\uc815\ubcf4 \uc218\uc9d1 \ubc0f \ucc98\ub9ac \ubc29\uce68\uc744 \ud655\uc778\ud558\uc138\uc694."'),
            ),
        );
        $meta = isset($meta_map[$page_name]) ? $meta_map[$page_name] : array(
            'title' => json_decode('"\uc57d\uad00 \uc548\ub0b4"'),
            'description' => json_decode('"\ub9ac\ub9e8 \uc911\uace0 \ub9e4\uc785 \uc11c\ube44\uc2a4 \uc548\ub0b4 \ud398\uc774\uc9c0\uc785\ub2c8\ub2e4."'),
        );

        $data = array(
            'header_view' => 'sell/header_view',
            'header_data' => $this->build_header_data(),
            'arr_meta' => $this->build_meta($meta['title'], $meta['description'], site_url('page/' . $page_name)),
            'content_data' => array(
                'current_page' => $page_name,
            ),
            'viewPage' => 'page/' . $page_name,
        );

        $this->load->view('layout/layout_view', $data);
    }

    protected function build_header_data()
    {
        return array(
            'home_url' => base_url('sell'),
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

/* End of file page.php */
/* Location: ./application/controllers/page.php */