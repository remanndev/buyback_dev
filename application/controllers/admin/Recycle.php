<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Recycle extends CI_Controller
{
	function __construct()
	{
		parent::__construct();

		$this->load->helper(array('form', 'load','security'));
		$this->load->library('form_validation');
		$this->load->library('tank_auth');
		$this->load->library('pagination');
		$this->load->library('querystring');
		$this->load->library('recycle_lib');

		//$this->load->library('upload_lib');
		//$this->load->model('upload_model');
		$this->lang->load('tank_auth');

		$this->username = $this->tank_auth->get_username();
		$this->arr_seg = $this->uri->segment_array();

		// table
		$this->tbl_recycle_place = 'recycle_place';
		$this->tbl_recycle_request = 'recycle_request';
		$this->tbl_file_manager = 'file_manager';


		// 관리자 로그인 후에만 접속 가능, 그 외에는 메인 페이지로 이동.
		if (! $this->tank_auth->is_admin()) {			// not logged in or activated
			$this->tank_auth->logout();
			redirect(base_url().'auth/login/'. url_code( current_url(), 'e'));
		}

	}

	function index()
	{
		$data = array();
		redirect(base_url().'admin/recycle/request');
	}

	// qrcode 생성
	private function make_qrcode($pl_code=FALSE) {

		//it's very important!
		if (trim($pl_code) == '')
			die('data cannot be empty! <a href="'.base_url().'admin/recycle/place">back</a>');

		// qrcode 에 담을 데이터
		$qr_data = base_url().'recycle/access/'.$pl_code;

		//load our new qrcode library
		$this->load->library('qrcode');

		// qrcode 이미지 저장 경로
		$PNG_PATH = '/home/digitalgive/public_html/data/recycle/qrcode/';

		//processing form input
		//remember to sanitize user input in real-life solution !!!
		$errorCorrectionLevel = 'M';  // (smallest) 'L' < 'M' < 'Q' < 'H' (best)
		$matrixPointSize = 10;  // 1 ~ 10
		$frameMarginSize = 2;  // 1 ~ 10


		$filename = 'qr_'.$pl_code.'_'.md5($qr_data.'|'.$errorCorrectionLevel.'|'.$matrixPointSize).'.png';

		// qrcode 생성
		QRcode::png($qr_data, $PNG_PATH.$filename, $errorCorrectionLevel, $matrixPointSize, $frameMarginSize);    

		return $filename;
	}


	function place()
	{

		$this->form_validation->set_error_delimiters('<div class="error">','</div>');
		$pl_data = array('errors'=>array());

		// # 그룹 신규 등록 - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		if( $pl_submit = $this->input->post('pl_submit', FALSE) ) {
			$this->form_validation->set_rules('duplicate_pl_code', '장소코드', '');
			$this->form_validation->set_rules('pl_code', '장소코드', 'trim|required|xss_clean|duplicate[duplicate_pl_code]');
			$this->form_validation->set_rules('pl_name', '장소이름', 'trim|required|xss_clean');

			if ($this->form_validation->run()) {	// validation ok
				$pl_code  = $this->form_validation->set_value('pl_code');
				$pl_name = $this->form_validation->set_value('pl_name');

				if(! $this->recycle_lib->is_place_code_available($this->tbl_recycle_place,'pl_code',$pl_code)) {
					alert('이미 존재하는 장소 코드입니다.',current_url());
				}

				if (!is_null($pl_data = $this->recycle_lib->make_place_code($pl_code,$pl_name))) {		// success

					// qrcode 생성 및 이미지 저장
					$filename = $this->make_qrcode($pl_code);
					// 업데이트
					$data = array('qrcode'=>$filename,'qrcode_dir'=>'data/recycle/qrcode/');
					$this->recycle_lib->update_place_code($pl_data['idx'],$data);

					// sess_message('장소 코드가 추가되었습니다.');
					// redirect(current_url());

					alert('장소 코드가 추가되었습니다.',current_url());
				} else {
					$errors = $this->tank_auth->get_error_message();
					foreach ($errors as $k => $v)	$pl_data['errors'][$k] = $this->lang->line($v);
				}
			}
		}

		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		// 페이징 정보 
		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		$this->load->library('segment', array('offset'=>4), 'seg'); // 세그먼트 주소( page 위치 )
		$this->load->library('querystring', NULL, 'param'); // 쿼리스트링 주소
		$seg	  =& $this->seg;
		$param	  =& $this->param;
		
		// [페이징]
		$qstr = '';
		
		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		// sql 
		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		$sql_select = 'idx,pl_code,pl_name,memo,reg_admin,reg_datetime,edit_admin,edit_datetime,qrcode,qrcode_dir';
		$sql_from = $this->tbl_recycle_place;
		$sql_where = array('idx >' => 0, 'del_datetime'=>NULL);
		$sql_group_by = FALSE;
		$sql_order_by = 'idx DESC';

		// 페이징
		$limit = '20';
		$page  = $seg->get('page', 1); // 페이지
		if(! isset($page) OR empty($page)) {
			$page = '1';
		}
		$offset = ($page - 1) * $limit;

		// 검색
		$like_field = FALSE;                         // search
		$like_match = FALSE;
		$like_side = 'both';
		// 조인
		$sql_join_tbl = FALSE;
		$sql_join_on = FALSE;
		$sql_join_option = 'LEFT OUTER';

		// 검색 상관없는 전체 수
		$place_total_count = $this->basic_model->get_common_count($sql_from,$sql_where);

		$arr = array(
				'sql_select'     => $sql_select,
				'sql_from'       => $sql_from,
				'sql_join_tbl'       => $sql_join_tbl,
				'sql_join_on'        => $sql_join_on,
				'sql_join_option'    => $sql_join_option,
				'like_field'      => $like_field,
				'like_match'      => $like_match,
				'like_side'      => $like_side,
				'sql_where'      => $sql_where, //array('PIDX' => $pidx),
				'sql_group_by'   => $sql_group_by,
				'sql_order_by'   => $sql_order_by,  // $order_field.' DESC, IDX DESC',
				'page'      => $page,
				'limit'      => $limit,
				'offset'      => $offset,
		);
		$result = $this->basic_model->arr_get_result($arr);

		foreach($result['qry'] as $i => $o) {
			// 관리자 정보
			$admin_info = $o->reg_admin;
			if( NULL !== $o->edit_admin ) {
				$admin_info .= ' / '.$o->edit_admin;
			}
			$result['qry'][$i]->admin_info = $admin_info;

			// 등록/수정 일시
			$dt_info = $o->reg_datetime;
			if( NULL !== $o->edit_datetime ) {
				$dt_info = $o->edit_datetime;
			}
			$result['qry'][$i]->dt_info = $dt_info;


			$qrcode_src = '';
			$qrcode_src .= (isset($o->qrcode_dir) && $o->qrcode_dir != '') ? base_url().$o->qrcode_dir : '';
			$qrcode_src .= (isset($o->qrcode) && $o->qrcode != '') ? $o->qrcode : '';
			$result['qry'][$i]->qrcode_src = $qrcode_src;

			$qrcode_img = ($qrcode_src != '') ? '<figure style="width: 100px;"><img src="'.$qrcode_src.'" style="width:100%;" /></figure>' : '';
			$result['qry'][$i]->qrcode_img = $qrcode_img;

		}

		// pagination 설정
		$config['suffix']	   = $qstr;
		$config['base_url']    = base_url() . 'admin/recycle/place/page/';
		$config['per_page']    = $limit;
		$config['total_rows']  = $result['total_count'];
		$config['uri_segment'] = $seg->pos('page');  // 5

		// 검색 목록 ADD
		$btn_prev_part = $btn_next_part = '';
		$config['full_tag_open']  = "<ul class='pagination'>".$btn_prev_part;
		$config['full_tag_close'] = $btn_next_part.'</ul>';

		//$CI =& get_instance();
		//$CI->load->library('pagination', $config);
		$this->load->library('pagination', $config);

		// Get data.
		$breadcrumb = array(
			'수거요청관리'=>base_url().'admin/recycle/place',
			'장소 관리'=>''
		);

		$data = array(
			'pl_submit' => $pl_submit,
			'pl_data'   => $pl_data,

			'total_cnt' => $place_total_count,
			'result'    => $result,
			'page'      => $page,
			'limit'      => $limit,
			'paging'    => $this->pagination->create_links(),
			'arr_seg'   => $this->arr_seg, //$this->uri->segment_array(),

			'breadcrumb'    => $breadcrumb,
			'viewPage'  => 'admin/recycle_place_view'
		);

		$this->load->view('admin/layout_view', $data);
	}


	function del_list() {


		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		// 페이징 정보 
		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		$this->load->library('segment', array('offset'=>4), 'seg'); // 세그먼트 주소( page 위치 )
		$this->load->library('querystring', NULL, 'param'); // 쿼리스트링 주소
		$seg	  =& $this->seg;
		$param	  =& $this->param;
		
		// [페이징]
		$qstr = '';
		
		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		// sql 
		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		$sql_select = 'idx,pl_code,pl_name,memo,del_admin,del_datetime';
		$sql_from = $this->tbl_recycle_place;
		$sql_where = array('idx >' => 0, 'del_datetime IS NOT '=>NULL);
		$sql_group_by = FALSE;
		$sql_order_by = 'del_datetime DESC';

		// 페이징
		$limit = '20';
		$page  = $seg->get('page', 1); // 페이지
		if(! isset($page) OR empty($page)) {
			$page = '1';
		}
		$offset = ($page - 1) * $limit;

		// 검색
		$like_field = FALSE;                         // search
		$like_match = FALSE;
		$like_side = 'both';
		// 조인
		$sql_join_tbl = FALSE;
		$sql_join_on = FALSE;
		$sql_join_option = 'LEFT OUTER';

		// 검색 상관없는 전체 수
		$place_total_count = $this->basic_model->get_common_count($sql_from,$sql_where);

		$arr = array(
				'sql_select'     => $sql_select,
				'sql_from'       => $sql_from,
				'sql_join_tbl'       => $sql_join_tbl,
				'sql_join_on'        => $sql_join_on,
				'sql_join_option'    => $sql_join_option,
				'like_field'      => $like_field,
				'like_match'      => $like_match,
				'like_side'      => $like_side,
				'sql_where'      => $sql_where, //array('PIDX' => $pidx),
				'sql_group_by'   => $sql_group_by,
				'sql_order_by'   => $sql_order_by,  // $order_field.' DESC, IDX DESC',
				'page'      => $page,
				'limit'      => $limit,
				'offset'      => $offset,
		);
		$result = $this->basic_model->arr_get_result($arr);

		// pagination 설정
		$config['suffix']	   = $qstr;
		$config['base_url']    = base_url() . 'admin/recycle/del_list/page/';
		$config['per_page']    = $limit;
		$config['total_rows']  = $result['total_count'];
		$config['uri_segment'] = $seg->pos('page');  // 5

		// 검색 목록 ADD
		$btn_prev_part = $btn_next_part = '';
		$config['full_tag_open']  = "<ul class='pagination'>".$btn_prev_part;
		$config['full_tag_close'] = $btn_next_part.'</ul>';

		//$CI =& get_instance();
		//$CI->load->library('pagination', $config);
		$this->load->library('pagination', $config);

		// Get data.
		$breadcrumb = array(
			'수거요청관리'=>base_url().'admin/recycle/place',
			'삭제 코드 목록'=>''
		);

		$data = array(

			'total_cnt' => $place_total_count,
			'result'    => $result,
			'page'      => $page,
			'limit'      => $limit,
			'paging'    => $this->pagination->create_links(),
			'arr_seg'   => $this->arr_seg, //$this->uri->segment_array(),

			'breadcrumb'    => $breadcrumb,
			'viewPage'  => 'admin/recycle_del_list_view'
		);

		$this->load->view('admin/layout_view', $data);
	}



	// 장소 코드 삭제 - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	function del_place($pl_code_encode=FALSE)
	{

		$pl_code = url_code($pl_code_encode,'d');

		if($res = $this->recycle_lib->delete_place_code($pl_code)) {
			sess_message('선택하신 장소 코드가 삭제되었습니다.');
			redirect('admin/recycle/place');
		}
	}


	// 장소 코드 수정 - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	function edit_place()
	{
		// jquery ajax 에서 success 의 response 값을 못가져오길래 검색해보니,
		// 요 아래 코드를 ajax 페이지에서 호출하는 페이지에 넣어주라고 함.
		header("Content-type: text/html; charset=utf-8");

		$pl_idx      = $this->input->post('pl_idx');
		$pl_name    = $this->input->post('pl_name');

		$data = array('pl_name'=>$pl_name);

		$chk = $this->recycle_lib->update_place_code($pl_idx,$data);

		echo ($chk) ? 'true' : 'false';
		exit;
	}


	// 중복검사 - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	function duplication_check()
	{
		// jquery ajax 에서 success 의 response 값을 못가져오길래 검색해보니,
		// 요 아래 코드를 ajax 페이지에서 호출하는 페이지에 넣어주라고 함.
		header("Content-type: text/html; charset=utf-8");

		// 장소 코드(pl_code) 생성

		$checkTable = trim($this->input->post('check_table'));
		$checkField = trim($this->input->post('check_field'));
		$checkValue = trim($this->input->post('check_value'));

		if(! $checkTable OR ! $checkField OR ! $checkValue){
			echo 'false';
			exit;
		}

		$chk = $this->recycle_lib->is_place_code_available($checkTable,$checkField,$checkValue);

		echo ($chk) ? 'true' : 'false';
		exit;
	}































	public function request() {





		// Get data.
		$breadcrumb = array(
			'수거요청'=>base_url().'admin/recycle',
			'신청 관리'=>''
		);

		$data = array(
			'arr_seg'   => $this->arr_seg,
			'breadcrumb'    => $breadcrumb,
			'viewPage'  => 'admin/recycle_request_view'
		);

		$this->load->view('admin/layout_view', $data);
	}



}