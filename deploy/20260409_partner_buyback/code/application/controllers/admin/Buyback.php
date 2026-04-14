<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Buyback extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->helper(array('form', 'url', 'load', 'security'));
        $this->load->library('form_validation');
        $this->load->library('tank_auth');
        $this->load->library('upload_lib');
        $this->load->library('querystring');
        $this->lang->load('tank_auth');

        $this->load->model('Buyback_model');
        $this->load->model('Buyback_spec_model');
        $this->load->model('Partner_model');

        $this->username = $this->tank_auth->get_username();
        $this->arr_seg = $this->uri->segment_array();

        if (!$this->tank_auth->is_admin()) {
            $this->tank_auth->logout();
            redirect('/auth/login/' . url_code(current_url(), 'e'));
        }

        load_css('<link rel="stylesheet" href="' . CSS_DIR . '/page_buyback.css?v=260326" />');
    }

    public function index()
    {
        redirect('/admin/buyback/list');
    }

    public function list()
    {
        $this->render_request_list('매입신청 목록');
    }

    public function delete($id = 0)
    {
        $id = (int) $id;

        if ($id < 1) {
            show_404();
        }

        $this->Buyback_model->delete_request($id);

        redirect('/admin/buyback');
    }

    public function partner_lists()
    {
        $this->render_request_list('회원사별 매입신청 목록');
    }

    public function ready_lists()
    {
        $this->render_request_list('전송 대기 목록', array('api_send_status' => 'READY'));
    }

    public function sent_lists()
    {
        $this->render_request_list('전송 완료 목록', array('api_send_status' => 'SENT'));
    }

    public function failed_lists()
    {
        $this->render_request_list('전송 실패 목록', array('api_send_status' => 'FAILED'));
    }

    public function spec_lists()
    {
        $filters = $this->get_spec_filters_from_query();

        $breadcrumb = array(
            '매입신청관리' => base_url() . 'admin/buyback/list',
            '매입기준관리 > 가격 기준 목록' => '',
        );

        $data = array(
            'arr_seg' => $this->arr_seg,
            'breadcrumb' => $breadcrumb,
            'table_ready' => $this->Buyback_spec_model->table_exists(),
            'filters' => $filters,
            'spec_rows' => $this->Buyback_spec_model->get_list($filters),
            'device_options' => $this->Buyback_spec_model->get_filter_options('device_type'),
            'part_options' => $this->Buyback_spec_model->get_filter_options('part_type'),
            'manufacturer_options' => $this->Buyback_spec_model->get_filter_options('manufacturer'),
            'flash_message' => $this->session->flashdata('buyback_spec_message'),
            'flash_error' => $this->session->flashdata('buyback_spec_error'),
            'viewPage' => 'admin/buyback_spec_lists_view',
        );

        $this->load->view('admin/layout_view', $data);
    }

    public function spec_quick()
    {
        $filters = $this->get_spec_filters_from_query();

        $breadcrumb = array(
            '매입신청관리' => base_url() . 'admin/buyback/list',
            '매입기준관리 > 가격 기준 빠른수정' => '',
        );

        $data = array(
            'arr_seg' => $this->arr_seg,
            'breadcrumb' => $breadcrumb,
            'table_ready' => $this->Buyback_spec_model->table_exists(),
            'filters' => $filters,
            'spec_rows' => $this->Buyback_spec_model->get_list($filters),
            'device_options' => $this->Buyback_spec_model->get_filter_options('device_type'),
            'part_options' => $this->Buyback_spec_model->get_filter_options('part_type'),
            'manufacturer_options' => $this->Buyback_spec_model->get_filter_options('manufacturer'),
            'flash_message' => $this->session->flashdata('buyback_spec_message'),
            'flash_error' => $this->session->flashdata('buyback_spec_error'),
            'viewPage' => 'admin/buyback_spec_quick_view',
        );

        $this->load->view('admin/layout_view', $data);
    }

    public function spec_write($id = 0)
    {
        $id = (int) $id;
        $row = $id > 0 ? $this->Buyback_spec_model->get($id) : array();

        if ($id > 0 && empty($row)) {
            show_404();
        }

        $this->form_validation->set_rules('device_type', '기기종류', 'required|trim|max_length[30]');
        $this->form_validation->set_rules('part_type', '부품종류', 'trim|max_length[50]');
        $this->form_validation->set_rules('manufacturer', '제조사', 'trim|max_length[100]');
        $this->form_validation->set_rules('category_name', '카테고리', 'trim|max_length[150]');
        $this->form_validation->set_rules('model_name', '모델명', 'required|trim|max_length[191]');
        $this->form_validation->set_rules('price_value', '매입가', 'trim');
        $this->form_validation->set_rules('sort_order', '정렬', 'trim|integer');
        $this->form_validation->set_rules('is_active', '사용 여부', 'trim|integer');

        if ($this->form_validation->run()) {
            $save_data = array(
                'device_type' => $this->input->post('device_type', true),
                'part_type' => $this->input->post('part_type', true),
                'manufacturer' => $this->input->post('manufacturer', true),
                'category_name' => $this->input->post('category_name', true),
                'model_name' => $this->input->post('model_name', true),
                'price_value' => $this->input->post('price_value', true),
                'sort_order' => $this->input->post('sort_order', true),
                'is_active' => $this->input->post('is_active', true),
            );

            $saved_id = $this->Buyback_spec_model->save($save_data, $id);
            if ($saved_id) {
                $this->session->set_flashdata(
                    'buyback_spec_message',
                    $id > 0 ? '가격 기준이 수정되었습니다.' : '가격 기준이 등록되었습니다.'
                );
                redirect('/admin/buyback/spec_lists');
                return;
            }

            $this->session->set_flashdata('buyback_spec_error', '가격 기준 저장 중 오류가 발생했습니다.');
            redirect(current_url());
            return;
        }

        $breadcrumb = array(
            '매입신청관리' => base_url() . 'admin/buyback/list',
            '매입기준관리 > 가격 기준 목록' => base_url() . 'admin/buyback/spec_lists',
            $id > 0 ? '가격 기준 수정' : '가격 기준 등록' => '',
        );

        $form_row = !empty($_POST) ? $_POST : $row;

        $data = array(
            'arr_seg' => $this->arr_seg,
            'breadcrumb' => $breadcrumb,
            'table_ready' => $this->Buyback_spec_model->table_exists(),
            'row' => $form_row,
            'is_edit' => ($id > 0),
            'flash_error' => $this->session->flashdata('buyback_spec_error'),
            'viewPage' => 'admin/buyback_spec_write_view',
        );

        $this->load->view('admin/layout_view', $data);
    }

    public function spec_toggle($id = 0)
    {
        $id = (int) $id;
        if ($id < 1) {
            show_404();
        }

        $ok = $this->Buyback_spec_model->toggle_active($id);
        $this->session->set_flashdata(
            $ok ? 'buyback_spec_message' : 'buyback_spec_error',
            $ok ? '사용 여부가 변경되었습니다.' : '사용 여부 변경 중 오류가 발생했습니다.'
        );

        redirect('/admin/buyback/spec_lists');
    }

    public function spec_ajax_update()
    {
        if ($this->input->method(true) !== 'POST') {
            show_404();
        }

        $id = (int) $this->input->post('id');
        $field = (string) $this->input->post('field', true);
        $value = $this->input->post('value', true);

        if ($id < 1) {
            $this->json_response(array(
                'result' => 'fail',
                'message' => '잘못된 요청입니다.',
                'errors' => array(
                    'common' => '잘못된 요청입니다.',
                ),
            ));
        }

        if (function_exists('session_write_close')) {
            @session_write_close();
        }

        $errors = array();
        $result = $this->Buyback_spec_model->update_inline_field($id, $field, $value, $errors);

        if (!$result) {
            $message = '값 저장에 실패했습니다.';
            if (!empty($errors)) {
                $first_error = reset($errors);
                if ($first_error) {
                    $message = $first_error;
                }
            }

            $this->json_response(array(
                'result' => 'fail',
                'message' => $message,
                'errors' => $errors,
            ));
        }

        $this->json_response(array(
            'result' => 'ok',
            'message' => '저장되었습니다.',
            'field' => $result['field'],
            'value' => $result['value'],
            'display_value' => $result['display_value'],
        ));
    }

    public function spec_excel()
    {
        $breadcrumb = array(
            '매입신청관리' => base_url() . 'admin/buyback/list',
            '매입기준관리 > 가격 기준 목록' => base_url() . 'admin/buyback/spec_lists',
            '엑셀 업로드' => '',
        );

        $result = null;

        if ($this->input->post('excel_upload_submit')) {
            $mode = $this->input->post('upload_mode', true) === 'update_price' ? 'update_price' : 'skip';

            if (empty($_FILES['excel_file']['tmp_name'])) {
                $this->session->set_flashdata('buyback_spec_error', '엑셀 파일을 선택해 주세요.');
                redirect(current_url());
                return;
            }

            try {
                $rows = $this->read_excel_rows($_FILES['excel_file']['tmp_name']);
                $result = $this->Buyback_spec_model->import_rows($rows, $mode);
                $this->session->set_flashdata('buyback_spec_message', '엑셀 업로드가 완료되었습니다.');
            } catch (Exception $e) {
                $this->session->set_flashdata('buyback_spec_error', $e->getMessage());
                redirect(current_url());
                return;
            }
        }

        $data = array(
            'arr_seg' => $this->arr_seg,
            'breadcrumb' => $breadcrumb,
            'table_ready' => $this->Buyback_spec_model->table_exists(),
            'flash_message' => $this->session->flashdata('buyback_spec_message'),
            'flash_error' => $this->session->flashdata('buyback_spec_error'),
            'upload_result' => $result,
            'viewPage' => 'admin/buyback_spec_excel_view',
        );

        $this->load->view('admin/layout_view', $data);
    }

    public function spec_excel_download()
    {
        $this->stream_spec_excel_download();
    }

    public function spec_excel_template()
    {
        $this->stream_spec_excel_template();
    }

    protected function stream_spec_excel_download()
    {
        $rows = $this->Buyback_spec_model->get_list($this->get_spec_filters_from_query());
        $excel_state = $this->begin_excel_runtime();

        try {
            $this->load->library('excel');
            $this->excel->setActiveSheetIndex(0);
            $sheet = $this->excel->getActiveSheet();
            $sheet->setTitle('buyback_spec_list');

            $headers = array('device_type', 'part_type', 'manufacturer', 'category_name', 'model_name', 'price_value', 'sort_order', 'is_active');
            foreach ($headers as $index => $header) {
                $this->write_excel_cell($sheet, chr(65 + $index) . '1', $header);
            }

            $row_no = 2;
            foreach ($rows as $row) {
                $this->write_excel_cell($sheet, 'A' . $row_no, isset($row['device_type']) ? $row['device_type'] : '');
                $this->write_excel_cell($sheet, 'B' . $row_no, isset($row['part_type']) ? $row['part_type'] : '');
                $this->write_excel_cell($sheet, 'C' . $row_no, isset($row['manufacturer']) ? $row['manufacturer'] : '');
                $this->write_excel_cell($sheet, 'D' . $row_no, isset($row['category_name']) ? $row['category_name'] : '');
                $this->write_excel_cell($sheet, 'E' . $row_no, isset($row['model_name']) ? $row['model_name'] : '');
                $this->write_excel_cell($sheet, 'F' . $row_no, isset($row['price_value']) ? $row['price_value'] : 0);
                $this->write_excel_cell($sheet, 'G' . $row_no, isset($row['sort_order']) ? $row['sort_order'] : 0);
                $this->write_excel_cell($sheet, 'H' . $row_no, isset($row['is_active']) ? $row['is_active'] : 0);
                $row_no++;
            }

            $this->send_excel_headers('buyback_spec_list_' . date('Ymd') . '.xls');

            $writer = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
            $writer->save('php://output');
            exit;
        } finally {
            $this->end_excel_runtime($excel_state);
        }
    }

    protected function stream_spec_excel_template()
    {
        $excel_state = $this->begin_excel_runtime();

        try {
            $this->load->library('excel');
            $this->excel->setActiveSheetIndex(0);
            $sheet = $this->excel->getActiveSheet();
            $sheet->setTitle('buyback_spec_template');

            $headers = array('device_type', 'part_type', 'manufacturer', 'category_name', 'model_name', 'price_value', 'sort_order', 'is_active');
            foreach ($headers as $index => $header) {
                $this->write_excel_cell($sheet, chr(65 + $index) . '1', $header);
            }

            $examples = array(
                array('노트북', '', 'Dell', '', '10세대 i5/8G/256G', 96000, 10, 1),
                array('모니터', '', '', '삼성/LG', '24인치 FHD', 35000, 20, 1),
                array('parts', 'CPU', '', '인텔 12세대', '인텔 코어 i5 12400', 89355, 30, 1),
            );

            $row_no = 2;
            foreach ($examples as $example) {
                foreach ($example as $index => $value) {
                    $this->write_excel_cell($sheet, chr(65 + $index) . $row_no, $value);
                }
                $row_no++;
            }

            $this->send_excel_headers('buyback_spec_template_' . date('Ymd') . '.xls');

            $writer = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
            $writer->save('php://output');
            exit;
        } finally {
            $this->end_excel_runtime($excel_state);
        }
    }

    protected function begin_excel_runtime()
    {
        $state = array(
            'error_reporting' => error_reporting(),
            'display_errors' => ini_get('display_errors'),
        );

        error_reporting($state['error_reporting'] & ~E_DEPRECATED & ~E_USER_DEPRECATED & ~E_NOTICE & ~E_WARNING);
        @ini_set('display_errors', '0');

        return $state;
    }

    protected function end_excel_runtime($state)
    {
        if (isset($state['error_reporting'])) {
            error_reporting($state['error_reporting']);
        }

        if (isset($state['display_errors'])) {
            @ini_set('display_errors', (string) $state['display_errors']);
        }
    }

    protected function write_excel_cell($sheet, $cell, $value)
    {
        $sheet->setCellValueExplicit($cell, (string) $value, PHPExcel_Cell_DataType::TYPE_STRING);
    }

    protected function send_excel_headers($filename)
    {
        while (ob_get_level() > 0) {
            @ob_end_clean();
        }

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
    }

    protected function render_request_list($page_title, $preset_filters = array())
    {
        $filters = array_merge(array(
            'partner_id' => $this->input->get('partner_id', true),
            'status' => $this->input->get('status', true),
            'api_send_status' => $this->input->get('api_send_status', true),
        ), $preset_filters);

        $partner_rows = $this->Partner_model->get_list();
        $partner_map = array();
        foreach ($partner_rows as $partner) {
            $partner_map[(int) $partner['id']] = $partner['name'];
        }

        $requests = $this->Buyback_model->get_request_list($filters);
        foreach ($requests as &$request) {
            $request['partner_name'] = '';
            if (isset($request['partner_id']) && isset($partner_map[(int) $request['partner_id']])) {
                $request['partner_name'] = $partner_map[(int) $request['partner_id']];
            }
        }
        unset($request);

        $breadcrumb = array(
            '매입신청관리' => base_url() . 'admin/buyback/list',
            $page_title => '',
        );

        $data = array(
            'arr_seg' => $this->arr_seg,
            'breadcrumb' => $breadcrumb,
            'page_title' => $page_title,
            'filters' => $filters,
            'partner_options' => $partner_rows,
            'requests' => $requests,
            'viewPage' => 'admin/buyback_request_lists_view',
        );

        $this->load->view('admin/layout_view', $data);
    }

    protected function read_excel_rows($file_path)
    {
        $excel_state = $this->begin_excel_runtime();

        try {
            $this->load->library('excel');

            $objPHPExcel = PHPExcel_IOFactory::load($file_path);
            $sheet = $objPHPExcel->getSheet(0);
            $highestRow = $sheet->getHighestRow();
            $highestColumn = $sheet->getHighestColumn();
            $header_range = 'A1:' . $highestColumn . '1';
            $body_range = 'A2:' . $highestColumn . $highestRow;

            $headers = $sheet->rangeToArray($header_range, null, true, false);
            $rows = $sheet->rangeToArray($body_range, null, true, false);

            $headers = isset($headers[0]) ? array_map('trim', $headers[0]) : array();
            if (empty($headers)) {
                throw new Exception('엑셀 헤더를 읽을 수 없습니다.');
            }

            $required = array('device_type', 'part_type', 'manufacturer', 'category_name', 'model_name', 'price_value', 'sort_order', 'is_active');
            foreach ($required as $required_header) {
                if (!in_array($required_header, $headers, true)) {
                    throw new Exception('엑셀 헤더에 "' . $required_header . '" 컬럼이 없습니다.');
                }
            }

            $result = array();
            foreach ($rows as $row) {
                if (!is_array($row)) {
                    continue;
                }

                $assoc = array();
                foreach ($headers as $index => $header) {
                    $assoc[$header] = isset($row[$index]) ? $row[$index] : '';
                }

                if (
                    trim((string) $assoc['device_type']) === '' &&
                    trim((string) $assoc['model_name']) === '' &&
                    trim((string) $assoc['category_name']) === ''
                ) {
                    continue;
                }

                $result[] = $assoc;
            }

            return $result;
        } finally {
            $this->end_excel_runtime($excel_state);
        }
    }

    protected function get_spec_filters_from_query()
    {
        return array(
            'device_type' => $this->input->get('device_type', true),
            'part_type' => $this->input->get('part_type', true),
            'manufacturer' => $this->input->get('manufacturer', true),
            'keyword' => $this->input->get('keyword', true),
            'is_active' => $this->input->get('is_active', true),
        );
    }

    protected function json_response($data)
    {
        if (!headers_sent()) {
            header('Content-Type: application/json; charset=utf-8');
        }

        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        exit;
    }
}
