<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Landing extends CI_Controller
{
	function __construct()
	{
		parent::__construct();

		$this->load->helper(array('form', 'url','load','security'));
		$this->load->library('form_validation');
		$this->load->library('tank_auth');
		$this->load->library('upload_lib');
		$this->load->library('landing_lib');
		$this->lang->load('tank_auth');


		// 관리자 로그인 후에만 접속 가능, 그 외에는 메인 페이지로 이동.
		if(! $this->tank_auth->is_admin() ) {
			$this->tank_auth->logout();
			redirect('/admin/auth/login/'. url_code('/admin','e'));
		}

		$this->username = $this->tank_auth->get_username();
		$this->user = $this->tank_auth->get_userinfo($this->username);
		$this->arr_seg = $this->uri->segment_array();
	}

	function index()
	{

		if ($this->tank_auth->is_admin()) {									// logged in
			redirect('/admin/landing/request/npo');
		}
		elseif($this->tank_auth->is_logged_in()) {
			$this->tank_auth->logout();
			redirect(base_url());
			//alert('관리자로 로그인해주세요.','admin/');
			//alert($this->lang->line('auth_message_admin_page'), 'admin/');
		}
		else {
			redirect('/admin/auth/'. url_code( current_url(), 'e'));
		}
	}


	/* 사용 안함 */
	private function lists($type="")
	{

		if($type == '') {
			redirect(base_url().'admin/landing/lists/p1');
		}

		// # 페이징 정보 - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		$this->load->library('segment', array('offset'=>5), 'seg'); // 세그먼트 주소( page 위치 )
		$this->load->library('querystring', NULL, 'param'); // 쿼리스트링 주소

		$seg	  =& $this->seg;
		$param	  =& $this->param;



		// 총 토탈 가져오기
		$arr_where = array(
				'sql_select'     => '*',
				'sql_from'       => 'landing',
				'sql_where'      => array('type'=>$type, 'datetime IS NOT '=>NULL)
		);
		$total_count_all = $this->basic_model->get_total($arr_where);

		// 검색어 검색
		$like_field = $this->input->post('search_field',FALSE);
		$like_match = $this->input->post('search_text',FALSE);
		$like_side='both';


		//$order_direction = $this->input->post('order_direction',FALSE);
		//if(! $order_direction) $order_direction = 'DESC';
		$order_field = $this->input->post('order_field',FALSE);
		if(! $order_field) $order_field = 'datetime DESC';



		if($param->get('sfl',false)) {
			$like_field = $param->get('sfl',FALSE);
		}
		if($param->get('stx',false)) {
			$like_match = $param->get('stx',FALSE);
		}
		if($param->get('order_field',false)) {
			$order_field = $param->get('order_field',FALSE);
		}


		// 휴대전화 검색인 경우
		if('phone' == $like_field) {
			$like_match = trim(str_replace('-','',$like_match));
		}

		//$sql_where = array();


		$limit = '20';
		$page  = $seg->get('page', 1); // 페이지
		if(! isset($page) OR empty($page)) {
			$page = '1';
		}
		$offset = ($page - 1) * $limit;






		// 페이징에서 사용
		$qstr = '';

		if($like_field) {
			//$like_field = $param->get('sfl');
			$qstr .= ('' == $qstr) ? '?' : '&';
			$qstr .= 'sfl='.$like_field;
		}
		if($like_match) {
			//$like_match = $param->get('stx');
			$qstr .= ('' == $qstr) ? '?' : '&';
			$qstr .= 'stx='.$like_match;
		}
		if($order_field) {
			//$order_field = $param->get('order_field');
			$qstr .= ('' == $qstr) ? '?' : '&';
			$qstr .= 'order_field='.$order_field;
		}





		// 목록 가져오기
		$arr_where = array(
				'sql_select'     => '*',
				'sql_from'       => 'landing',
				'like_field'     => $like_field,
				'like_match'     => $like_match,
				'like_side'     => $like_side,
				'sql_where'      => '',
				'sql_order_by'   => $order_field,
				'limit'   => $limit,
				'offset'   => $offset,
		);

		$result = $this->basic_model->arr_get_result($arr_where);
		//echo $this->db->last_query();
		//exit;




		// pagination 설정
		$config['suffix']	   = $qstr; //$qstr;
		$config['base_url']    = base_url() . 'admin/landing/lists/'.$type.'/page/';
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
				'랜딩페이지'=>base_url().'admin/landing/lists/',
				'목록'=>''
			);

			$data = array(
				'total_count_all' => $total_count_all,

				'like_field' => $like_field,
				'like_match' => $like_match,
				'srh_order_field'	 => $order_field,

				'result'    => $result,
				'page'      => $page,
				'limit'      => $limit,
				'paging'    => $this->pagination->create_links(),

				'arr_seg'   => $this->arr_seg, //$this->uri->segment_array(),
				'breadcrumb'    => $breadcrumb,
				'viewPage'  => 'admin/landing_lists_view'
			);

			// 엑셀 다운로드
			//$btn_excel = '<a href="/admin/landing/excel_download/'.$like_field.'/'.$like_match.'/'.url_code($order_field,'e').'" class="btn btn-black-flat btn-xs o_btn">엑셀 다운</a>';

			$srh_add = '';
			$srh_add .= $like_field.'/';
			$srh_add .= $like_match.'/';
			$srh_add .= $order_field;

			$ex_srh_add = url_code($srh_add,'e');

			$btn_excel = '<a href="/admin/landing/excel_download/'.$type.'/'.$ex_srh_add.'" class="btn btn-dark btn-xs">엑셀 다운</a>';
			$data['btn_excel'] = $btn_excel;

			$this->load->view('admin/layout_view', $data);
	}



	/* 개인정보동의 */
	function agree($idx=FALSE) {

		load_css('<link rel="stylesheet" href="'.CSS_DIR.'/jquery.datetimepicker.min.css" />');
		load_js('<script src="'.JS_DIR.'/jquery.datetimepicker.full.js"></script>');


        //<!-- redactor.css -->
		load_css('<link rel="stylesheet" type="text/css" href="'. ASSETS_DIR .'/lib/editor/redactor/redactor.min.css" />');
    	//<!-- redactor.js -->
		load_js('<script src="'. ASSETS_DIR .'/lib/editor/redactor/redactor.min.js"></script>');
        //<!-- plugin js -->
		load_js('<script src="'. ASSETS_DIR .'/lib/editor/redactor/_plugins/fontsize/fontsize.js"></script>');
		load_js('<script src="'. ASSETS_DIR .'/lib/editor/redactor/_plugins/fontcolor/fontcolor.js"></script>');
		load_js('<script src="'. ASSETS_DIR .'/lib/editor/redactor/_plugins/filemanager/filemanager.js"></script>');
		load_js('<script src="'. ASSETS_DIR .'/lib/editor/redactor/_plugins/imagemanager/imagemanager.js"></script>');
		load_js('<script src="'. ASSETS_DIR .'/lib/editor/redactor/_plugins/table/table.js"></script>');
		load_js('<script src="'. ASSETS_DIR .'/lib/editor/redactor/_plugins/video/video.js"></script>');
		load_js('<script src="'. ASSETS_DIR .'/lib/editor/redactor/_plugins/alignment/alignment.js"></script>');

		load_css('<link rel="stylesheet" type="text/css" href="'. ASSETS_DIR .'/lib/editor/redactor/_plugins/inlinestyle/inlinestyle.css" />');
		load_js('<script src="'. ASSETS_DIR .'/lib/editor/redactor/_plugins/inlinestyle/inlinestyle.js"></script>');

		load_js('<script src="'. ASSETS_DIR .'/lib/editor/redactor/_plugins/specialchars/specialchars.js"></script>');
		load_js('<script src="'. ASSETS_DIR .'/lib/editor/redactor/_plugins/textdirection/textdirection.js"></script>');
		load_js('<script src="'. ASSETS_DIR .'/lib/editor/redactor/_plugins/widget/widget.js"></script>');
		load_js('<script src="'. ASSETS_DIR .'/lib/editor/redactor/_plugins/fontfamily/fontfamily.js"></script>');
		load_js('<script src="'. ASSETS_DIR .'/lib/editor/redactor/_plugins/fullscreen/fullscreen.js"></script>');

		//<!-- connect the languages file -->
		load_js('<script src="'. ASSETS_DIR .'/lib/editor/redactor/_langs/ko.js?v='.time().'"></script>');






		// # 에러 메시지 CSS
		$this->form_validation->set_error_delimiters('<div class="error">','</div>');

		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		// 저장시..
		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

		$this->form_validation->set_rules('agree_type', '동의 type', 'trim|required|xss_clean');
		$this->form_validation->set_rules('agree_content', '개인정보수집동의 내용', 'trim|required|xss_clean');

		if ($this->form_validation->run() !== FALSE) {
			if (!is_null($data = $this->landing_lib->agree_write($idx))) {		// success
				redirect(base_url().'admin/landing/agree/'.$data['idx']);
			}
		}
		else 
		{

			// 개인정보수집동의 정보
			$arr_where = array(
					'sql_select'     => '*',
					'sql_from'       => 'landing_agree'
					//'sql_where'      => array('idx'=>1)
					//'sql_order_by' => 'idx desc',
					//'limit'      => 1
			);
			if($idx) {
				$arr_where['sql_where'] = array('idx'=>$idx);
			}
			else {
				$arr_where['sql_order_by'] = 'idx desc';
				$arr_where['limit'] = 1;
			}

			$row = $this->basic_model->arr_get_row($arr_where);
			//echo $this->db->last_query();
			//echo '<br />';
			//exit;

			if(! $idx) {
				redirect(base_url().'admin/landing/agree/'.$row->idx);
			}

			// Get data.
			$breadcrumb = array(
				'랜딩페이지'=>base_url().'admin/landing/agree/',
				'목록'=>''
			);

			$data = array(

				'row'    => $row,

				'arr_seg'   => $this->arr_seg, //$this->uri->segment_array(),
				'breadcrumb'    => $breadcrumb,
				'viewPage'  => 'admin/landing_agree_view'
			);


			$this->load->view('admin/layout_view', $data);

		}


	}




	function request($type="")
	{

		// npo(NPO 협약 신청), comp(기업 제휴 문의)
		if($type == '') {
			redirect(base_url().'admin/landing/request/npo');
		}

		$tbl_landing = 'landing';

		// # 페이징 정보 - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		$this->load->library('segment', array('offset'=>5), 'seg'); // 세그먼트 주소( page 위치 )
		$this->load->library('querystring', NULL, 'param'); // 쿼리스트링 주소

		$seg	  =& $this->seg;
		$param	  =& $this->param;

		// 총 토탈 가져오기
		$arr_where = array(
				'sql_select'     => '*',
				'sql_from'       => $tbl_landing,
				'sql_where'      => array('type'=>$type, 'deleted'=>NULL)
		);
		$total_count_all = $this->basic_model->get_total($arr_where);

		// 검색어 검색
		$like_field = $this->input->post('search_field',FALSE);
		$like_match = $this->input->post('search_text',FALSE);
		$like_side='both';

		//$order_direction = $this->input->post('order_direction',FALSE);
		//if(! $order_direction) $order_direction = 'DESC';
		$order_field = $this->input->post('order_field',FALSE);
		//if(! $order_field) $order_field = 'created DESC';
		if(! $order_field) $order_field = 'created DESC';

		if($param->get('sfl',false)) {
			$like_field = $param->get('sfl',FALSE);
		}
		if($param->get('stx',false)) {
			$like_match = $param->get('stx',FALSE);
		}
		if($param->get('order_field',false)) {
			$order_field = $param->get('order_field',FALSE);
		}

		// 휴대전화 검색인 경우
		if('phone' == $like_field) {
			$like_match = trim(str_replace('-','',$like_match));
		}

		$limit = '20';
		$page  = $seg->get('page', 1); // 페이지
		if(! isset($page) OR empty($page)) {
			$page = '1';
		}
		$offset = ($page - 1) * $limit;

		// 페이징에서 사용
		$qstr = '';

		if($like_field) {
			//$like_field = $param->get('sfl');
			$qstr .= ('' == $qstr) ? '?' : '&';
			$qstr .= 'sfl='.$like_field;
		}
		if($like_match) {
			//$like_match = $param->get('stx');
			$qstr .= ('' == $qstr) ? '?' : '&';
			$qstr .= 'stx='.$like_match;
		}
		if($order_field) {
			//$order_field = $param->get('order_field');
			$qstr .= ('' == $qstr) ? '?' : '&';
			$qstr .= 'order_field='.$order_field;
		}

		// 목록 가져오기
		$arr_where = array(
				'sql_select'     => '*',
				'sql_from'       => $tbl_landing,
				'like_field'     => $like_field,
				'like_match'     => $like_match,
				'like_side'     => $like_side,
				'sql_where'      => '',
				'sql_order_by'   => $order_field,
				'limit'   => $limit,
				'offset'   => $offset,
		);

		$result = $this->basic_model->arr_get_result($arr_where);
		//echo $this->db->last_query();
		//exit;

		// pagination 설정
		$config['suffix']	   = $qstr; //$qstr;
		$config['base_url']    = base_url() . 'admin/landing/request/'.$type.'/page/';
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
				'신청문의관리'=>base_url().'admin/landing/request/',
				'목록'=>''
			);

			$data = array(
				'total_count_all' => $total_count_all,

				'like_field' => $like_field,
				'like_match' => $like_match,
				'srh_order_field'	 => $order_field,

				'result'    => $result,
				'page'      => $page,
				'limit'      => $limit,
				'paging'    => $this->pagination->create_links(),

				'arr_seg'   => $this->arr_seg, //$this->uri->segment_array(),
				'breadcrumb'    => $breadcrumb,
				'viewPage'  => 'admin/landing_request_view'
			);

			// [reserve/ 방문예약, 당첨자예약] 엑셀 다운로드
			//$btn_excel = '<a href="/admin/landing/excel_download/'.$like_field.'/'.$like_match.'/'.url_code($order_field,'e').'" class="btn btn-black-flat btn-xs o_btn">엑셀 다운</a>';

			$srh_add = '';
			$srh_add .= $like_field.'/';
			$srh_add .= $like_match.'/';
			$srh_add .= $order_field;

			$ex_srh_add = url_code($srh_add,'e');

			//$btn_excel = '<a href="/admin/landing/excel_download_rsv/'.$type.'/'.$ex_srh_add.'" class="btn btn-dark btn-xs">엑셀 다운</a>';
			$btn_excel = '<a href="/admin/landing/excel_download_request/'.$type.'/'.$ex_srh_add.'" class="btn btn-dark btn-xs">엑셀 다운</a>';
			$data['btn_excel'] = $btn_excel;

			$this->load->view('admin/layout_view', $data);
	}


	function request_del($no="",$return_encode="")
	{
		$return_url = url_code($return_encode,'d');
		//echo $return_url;
		if (!is_null($data = $this->landing_lib->reserve_del($no))) {		// success
			alert('삭제가 완료되었습니다.',$return_url);
			//redirect($return_url);
		}
	}




	// 이벤트 엑셀 변환
	//function excel_download($like_field=FALSE,$like_match=FALSE,$order_field=FALSE)
	function excel_download($type=FALSE,$ex_srh_add=FALSE)
	{

		$srh_add = url_code($ex_srh_add,'d');
		$arr_srh = explode('/',$srh_add);

		$like_field = isset($arr_srh[0]) ? $arr_srh[0] : '';
		$like_match = isset($arr_srh[1]) ? $arr_srh[1] : '';
		$order_field = isset($arr_srh[2]) ? $arr_srh[2] : '';

		// 검색어 검색
		$like_side='both';


		// 휴대전화 검색인 경우
		if('phone' == $like_field && '' != $like_match) {
			$like_match = trim(str_replace('-','',$like_match));
		}

		if($type) {
			$sql_where = array('type'=>$type);
		}

		// 목록 가져오기
		$arr_where = array(
				'sql_select'     => '*',
				'sql_from'       => 'landing',
				'sql_where'      => $sql_where,
				'sql_order_by'   => $order_field
		);



		if('' != $like_field && '' != $like_match)  {
			$arr_where['like_field'] = $like_field;
			$arr_where['like_match'] = $like_match;
			$arr_where['like_side'] = $like_side;
		}

		$result = $this->basic_model->arr_get_result($arr_where);








					//load our new PHPExcel library
					$this->load->library('excel');
					//activate worksheet number 1
					$this->excel->setActiveSheetIndex(0);
					//name the worksheet
					$this->excel->getActiveSheet()->setTitle('고객정보 다운로드');

					//set cell A1 content with some text
					$this->excel->getActiveSheet()->setCellValue('A1', '번호');
					$this->excel->getActiveSheet()->setCellValue('B1', '이름');
					$this->excel->getActiveSheet()->setCellValue('C1', '휴대전화');
					$this->excel->getActiveSheet()->setCellValue('D1', '우편번호');
					$this->excel->getActiveSheet()->setCellValue('E1', '주소');
					$this->excel->getActiveSheet()->setCellValue('F1', '등록일자');

					//change the font size
					//$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(20);
					$this->excel->getActiveSheet()->getStyle('A1:F1')->getFont()->setSize(10);

					//make the font become bold
					//$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
					$this->excel->getActiveSheet()->getStyle('A1:F1')->getFont()->setBold(true);

					//$this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
					$this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
					//$this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
					$this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(50);
					$this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(15);

					//$this->excel->getActiveSheet()->getStyle('A1:F1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);


					//set cell others content with some text
					foreach($result['qry'] as $i => $o)
					{

						// 번호
						//$num = ($result['total_count'] - $limit*($page-1) - $i);
						$num = $i + 1;

						$ino = $i + 2;

						$phone = array();
						$phone[0] = substr($o->phone,0,3);
						$phone[1] = substr($o->phone,3,4);
						$phone[2] = substr($o->phone,7,4);
						$phone_str = implode('-',$phone);

						$this->excel->getActiveSheet()->setCellValue('A'.$ino, $num);
						$this->excel->getActiveSheet()->setCellValue('B'.$ino, $o->name);
						$this->excel->getActiveSheet()->setCellValue('C'.$ino, $phone_str);
						$this->excel->getActiveSheet()->setCellValue('D'.$ino, $o->postcode);
						$this->excel->getActiveSheet()->setCellValue('E'.$ino, $o->addr.' '.$o->addr_detail);
						$this->excel->getActiveSheet()->setCellValue('F'.$ino, substr($o->datetime,0,10));

					}







					//$filename='just_some_random_name.xls'; //save our workbook as this file name
					$filename='landing_list_'.date('YmdHis', TIME_STAMP).'.xls'; //save our workbook as this file name

					header('Content-Type: application/vnd.ms-excel'); //mime type
					header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
					header('Cache-Control: max-age=0'); //no cache
					//
					//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
					//if you want to save it as .XLSX Excel 2007 format
					$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
					//force user to download the Excel file without writing it to server's HD
					$objWriter->save('php://output');


	}




























































	function reserve_del($no="",$return_encode="")
	{
		$return_url = url_code($return_encode,'d');
		//echo $return_url;
		if (!is_null($data = $this->landing_lib->reserve_del($no))) {		// success
			alert('삭제가 완료되었습니다.',$return_url);
			//redirect($return_url);
		}
	}

	function reserve_del_winner($no="",$return_encode="")
	{
		$return_url = url_code($return_encode,'d');
		//echo $return_url;
		if (!is_null($data = $this->landing_lib->reserve_del_winner($no))) {		// success
			alert('삭제가 완료되었습니다.',$return_url);
			//redirect($return_url);
		}
	}


	function reserve($type="")
	{

		if($type == '') {
			redirect(base_url().'admin/landing/reserve/rsv');
		}

		$tbl_landing = 'rsv';


		// # 페이징 정보 - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		$this->load->library('segment', array('offset'=>5), 'seg'); // 세그먼트 주소( page 위치 )
		$this->load->library('querystring', NULL, 'param'); // 쿼리스트링 주소

		$seg	  =& $this->seg;
		$param	  =& $this->param;



		// 총 토탈 가져오기
		$arr_where = array(
				'sql_select'     => '*',
				'sql_from'       => $tbl_landing,
				'sql_where'      => array('type'=>$type, 'deleted'=>NULL)
		);
		$total_count_all = $this->basic_model->get_total($arr_where);

		// 검색어 검색
		$like_field = $this->input->post('search_field',FALSE);
		$like_match = $this->input->post('search_text',FALSE);
		$like_side='both';


		//$order_direction = $this->input->post('order_direction',FALSE);
		//if(! $order_direction) $order_direction = 'DESC';
		$order_field = $this->input->post('order_field',FALSE);
		//if(! $order_field) $order_field = 'created DESC';
		if(! $order_field) $order_field = 'rsv_date ASC, rsv_part ASC';



		if($param->get('sfl',false)) {
			$like_field = $param->get('sfl',FALSE);
		}
		if($param->get('stx',false)) {
			$like_match = $param->get('stx',FALSE);
		}
		if($param->get('order_field',false)) {
			$order_field = $param->get('order_field',FALSE);
		}


		// 휴대전화 검색인 경우
		if('phone' == $like_field) {
			$like_match = trim(str_replace('-','',$like_match));
		}

		//$sql_where = array();


		$limit = '20';
		$page  = $seg->get('page', 1); // 페이지
		if(! isset($page) OR empty($page)) {
			$page = '1';
		}
		$offset = ($page - 1) * $limit;






		// 페이징에서 사용
		$qstr = '';

		if($like_field) {
			//$like_field = $param->get('sfl');
			$qstr .= ('' == $qstr) ? '?' : '&';
			$qstr .= 'sfl='.$like_field;
		}
		if($like_match) {
			//$like_match = $param->get('stx');
			$qstr .= ('' == $qstr) ? '?' : '&';
			$qstr .= 'stx='.$like_match;
		}
		if($order_field) {
			//$order_field = $param->get('order_field');
			$qstr .= ('' == $qstr) ? '?' : '&';
			$qstr .= 'order_field='.$order_field;
		}





		// 목록 가져오기
		$arr_where = array(
				'sql_select'     => '*',
				'sql_from'       => $tbl_landing,
				'like_field'     => $like_field,
				'like_match'     => $like_match,
				'like_side'     => $like_side,
				'sql_where'      => '',
				'sql_order_by'   => $order_field,
				'limit'   => $limit,
				'offset'   => $offset,
		);

		$result = $this->basic_model->arr_get_result($arr_where);
		//echo $this->db->last_query();
		//exit;




		// pagination 설정
		$config['suffix']	   = $qstr; //$qstr;
		$config['base_url']    = base_url() . 'admin/landing/reserve/'.$type.'/page/';
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
				'랜딩페이지'=>base_url().'admin/landing/reserve/',
				'목록'=>''
			);

			$data = array(
				'total_count_all' => $total_count_all,

				'like_field' => $like_field,
				'like_match' => $like_match,
				'srh_order_field'	 => $order_field,

				'result'    => $result,
				'page'      => $page,
				'limit'      => $limit,
				'paging'    => $this->pagination->create_links(),

				'arr_seg'   => $this->arr_seg, //$this->uri->segment_array(),
				'breadcrumb'    => $breadcrumb,
				'viewPage'  => 'admin/landing_reserve_view'
			);

			// [reserve/ 방문예약, 당첨자예약] 엑셀 다운로드
			//$btn_excel = '<a href="/admin/landing/excel_download/'.$like_field.'/'.$like_match.'/'.url_code($order_field,'e').'" class="btn btn-black-flat btn-xs o_btn">엑셀 다운</a>';

			$srh_add = '';
			$srh_add .= $like_field.'/';
			$srh_add .= $like_match.'/';
			$srh_add .= $order_field;

			$ex_srh_add = url_code($srh_add,'e');

			$btn_excel = '<a href="/admin/landing/excel_download_rsv/'.$type.'/'.$ex_srh_add.'" class="btn btn-dark btn-xs">엑셀 다운</a>';
			$data['btn_excel'] = $btn_excel;

			$this->load->view('admin/layout_view', $data);
	}










	function winner_del($no="",$return_encode="")
	{
		$return_url = url_code($return_encode,'d');
		//echo $return_url;
		if (!is_null($data = $this->landing_lib->winner_del($no))) {		// success
			alert('삭제가 완료되었습니다.');
			redirect($return_url);
		}
	}

	// 당첨자 목록
	function winner($type="")
	{






		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		// 엑셀 파일로 업로드한 회원 정보만 삭제
		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		if( $this->input->post('excel_truncate_submit') ) {

			$chk = $this->input->post('chk_excel',FALSE);
			if('truncate' == $chk) 
			{

				// 회원 정보를 완전히 삭제
				if($this->landing_lib->delete_excel_winner_by_admin()) {
					//alert('회원 정보가 삭제되었습니다.','admin/user');
					//redirect(base_url().'admin/user');
					echo '<script type="text/javascript">parent.location.reload();</script>';
				}

			}
		}


		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		// 회원 정보 엑셀 파일로 업로드
		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		if( $this->input->post('excel_upload_submit') ) {

			$chk = $this->input->post('chk_excel',FALSE);
			if('upload' == $chk) 
			{

					// 엑셀 업로드

					//load our new PHPExcel library
					$this->load->library('excel');

					$objPHPExcel = new PHPExcel();
					$objPHPExcel = PHPExcel_IOFactory::load($_FILES['excel_file']['tmp_name']);
					$sheetsCount = $objPHPExcel->getSheetCount();

					/* 시트별로 읽기 */
					for($i = 0; $i < $sheetsCount; $i++)
					{
						$objPHPExcel->setActiveSheetIndex($i);
						$sheet = $objPHPExcel->getActiveSheet();
						$highestRow = $sheet->getHighestRow();
						$highestColumn = $sheet->getHighestColumn();
					 
						/* 한줄읽기 */
						// 1번째 줄은 칼럼 타이틀(성명/공급종류/동/호/전화번호/주택형)
						for ($row = 2; $row <= $highestRow; $row++)
						{
							/* $rowData가 한줄의 데이터를 셀별로 배열처리 됩니다. */
							$rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, TRUE, FALSE);
							$udata = $rowData[0];

							$name = isset($udata[0]) ? $udata[0] : FALSE;
							$type = isset($udata[1]) ? $udata[1] : FALSE;
							$dong = isset($udata[2]) ? $udata[2] : FALSE;
							$ho = isset($udata[3]) ? $udata[3] : FALSE;
							//$phone = isset($udata[4]) ? trim(str_replace(' ','',$udata[4])) : FALSE;
							$phone = isset($udata[4]) ? $udata[4] : FALSE;
							$area = isset($udata[5]) ? $udata[5] : FALSE;

							if( $phone != '' ) {
								$this->landing_lib->excel_winner_by_admin($name,$type,$dong,$ho,$phone,$area);  
							}
						}
					}

					//redirect(current_url());
					echo '<script type="text/javascript">parent.location.reload();</script>';

			}
		}














		if($type == '') {
			redirect(base_url().'admin/landing/winner/sb0_3');
		}

		$tbl_winner_list = 'winner_list';

		// # 페이징 정보 - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		$this->load->library('segment', array('offset'=>5), 'seg'); // 세그먼트 주소( page 위치 )
		$this->load->library('querystring', NULL, 'param'); // 쿼리스트링 주소

		$seg	  =& $this->seg;
		$param	  =& $this->param;



		// 총 토탈 가져오기
		$arr_where = array(
				'sql_select'     => '*',
				'sql_from'       => $tbl_winner_list,
				'sql_where'      => array('deleted'=>NULL)
		);
		$total_count_all = $this->basic_model->get_total($arr_where);

		// 검색어 검색
		$like_field = $this->input->post('search_field',FALSE);
		$like_match = $this->input->post('search_text',FALSE);
		$like_side='both';


		//$order_direction = $this->input->post('order_direction',FALSE);
		//if(! $order_direction) $order_direction = 'DESC';
		$order_field = $this->input->post('order_field',FALSE);
		//if(! $order_field) $order_field = 'created DESC';
		if(! $order_field) $order_field = 'idx ASC';



		if($param->get('sfl',false)) {
			$like_field = $param->get('sfl',FALSE);
		}
		if($param->get('stx',false)) {
			$like_match = $param->get('stx',FALSE);
		}
		if($param->get('order_field',false)) {
			$order_field = $param->get('order_field',FALSE);
		}


		// 휴대전화 검색인 경우
		if('phone' == $like_field) {
			$like_match = trim(str_replace('-','',$like_match));
			$like_match = trim(str_replace(' ','',$like_match));
		}

		//$sql_where = array();


		$limit = '20';
		$page  = $seg->get('page', 1); // 페이지
		if(! isset($page) OR empty($page)) {
			$page = '1';
		}
		$offset = ($page - 1) * $limit;






		// 페이징에서 사용
		$qstr = '';

		if($like_field) {
			//$like_field = $param->get('sfl');
			$qstr .= ('' == $qstr) ? '?' : '&';
			$qstr .= 'sfl='.$like_field;
		}
		if($like_match) {
			//$like_match = $param->get('stx');
			$qstr .= ('' == $qstr) ? '?' : '&';
			$qstr .= 'stx='.$like_match;
		}
		if($order_field) {
			//$order_field = $param->get('order_field');
			$qstr .= ('' == $qstr) ? '?' : '&';
			$qstr .= 'order_field='.$order_field;
		}





		// 목록 가져오기
		$arr_where = array(
				'sql_select'     => '*',
				'sql_from'       => $tbl_winner_list,
				'like_field'     => $like_field,
				'like_match'     => $like_match,
				'like_side'     => $like_side,
				'sql_where'      => '',
				'sql_order_by'   => $order_field,
				'limit'   => $limit,
				'offset'   => $offset,
		);

		$result = $this->basic_model->arr_get_result($arr_where);
		//echo $this->db->last_query();
		//exit;




		// pagination 설정
		$config['suffix']	   = $qstr; //$qstr;
		$config['base_url']    = base_url() . 'admin/landing/winner/'.$type.'/page/';
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
				'랜딩페이지'=>base_url().'admin/landing/winner/',
				'목록'=>''
			);

			$data = array(
				'total_count_all' => $total_count_all,

				'like_field' => $like_field,
				'like_match' => $like_match,
				'srh_order_field'	 => $order_field,

				'result'    => $result,
				'page'      => $page,
				'limit'      => $limit,
				'paging'    => $this->pagination->create_links(),

				'arr_seg'   => $this->arr_seg, //$this->uri->segment_array(),
				'breadcrumb'    => $breadcrumb,
				'viewPage'  => 'admin/landing_winner_view'
			);

			// 엑셀 다운로드
			//$btn_excel = '<a href="/admin/landing/excel_download/'.$like_field.'/'.$like_match.'/'.url_code($order_field,'e').'" class="btn btn-black-flat btn-xs o_btn">엑셀 다운</a>';

			$srh_add = '';
			$srh_add .= $like_field.'/';
			$srh_add .= $like_match.'/';
			$srh_add .= $order_field;

			$ex_srh_add = url_code($srh_add,'e');

			$btn_excel = '<a href="/admin/landing/excel_download_winner/'.$type.'/'.$ex_srh_add.'" class="btn btn-dark btn-xs">엑셀 다운</a>';
			$data['btn_excel'] = $btn_excel;

			$this->load->view('admin/layout_view', $data);
	}





	// 예약 엑셀 변환
	//function excel_download($like_field=FALSE,$like_match=FALSE,$order_field=FALSE)
	function excel_download_rsv($type=FALSE,$ex_srh_add=FALSE)
	{

		$srh_add = url_code($ex_srh_add,'d');
		$arr_srh = explode('/',$srh_add);

		$like_field = isset($arr_srh[0]) ? $arr_srh[0] : '';
		$like_match = isset($arr_srh[1]) ? $arr_srh[1] : '';
		$order_field = isset($arr_srh[2]) ? $arr_srh[2] : 'rsv_date ASC, rsv_part ASC';

		// 검색어 검색
		$like_side='both';


		// 휴대전화 검색인 경우
		if('phone' == $like_field && '' != $like_match) {
			$like_match = trim(str_replace('-','',$like_match));
		}

		if($type) {
			$sql_where = array('type'=>$type,'deleted'=>NULL);
		}

		$tbl_landing = 'rsv';

		// 목록 가져오기
		$arr_where = array(
				'sql_select'     => '*',
				'sql_from'       => $tbl_landing,
				'sql_where'      => $sql_where,
				'sql_order_by'   => $order_field
		);



		if('' != $like_field && '' != $like_match)  {
			$arr_where['like_field'] = $like_field;
			$arr_where['like_match'] = $like_match;
			$arr_where['like_side'] = $like_side;
		}

		$result = $this->basic_model->arr_get_result($arr_where);








					//load our new PHPExcel library
					$this->load->library('excel');
					//activate worksheet number 1
					$this->excel->setActiveSheetIndex(0);
					//name the worksheet
					$this->excel->getActiveSheet()->setTitle('고객정보 다운로드');

					//set cell A1 content with some text
					$this->excel->getActiveSheet()->setCellValue('A1', '번호');
					$this->excel->getActiveSheet()->setCellValue('B1', '이름');
					$this->excel->getActiveSheet()->setCellValue('C1', '휴대전화');
					$this->excel->getActiveSheet()->setCellValue('D1', '동반인(명)');
					$this->excel->getActiveSheet()->setCellValue('E1', '예약날짜');
					$this->excel->getActiveSheet()->setCellValue('F1', '예약시간');
					$this->excel->getActiveSheet()->setCellValue('G1', '등록일자');

					//change the font size
					//$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(20);
					$this->excel->getActiveSheet()->getStyle('A1:G1')->getFont()->setSize(10);

					//make the font become bold
					//$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
					$this->excel->getActiveSheet()->getStyle('A1:G1')->getFont()->setBold(true);

					/*
					//$this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
					$this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
					$this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
					$this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
					$this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
					$this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
					*/

					//$this->excel->getActiveSheet()->getStyle('A1:G1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);


					//set cell others content with some text
					foreach($result['qry'] as $i => $o)
					{

						// 번호
						//$num = ($result['total_count'] - $limit*($page-1) - $i);
						$num = $i + 1;

						$ino = $i + 2;

						$phone = array();
						$phone[0] = substr($o->phone,0,3);
						$phone[1] = substr($o->phone,3,4);
						$phone[2] = substr($o->phone,7,4);
						$phone_str = implode('-',$phone);

						$tstamp = strtotime($o->rsv_part) + 20*60;
						$time_end = date('H:i',$tstamp);


						$this->excel->getActiveSheet()->setCellValue('A'.$ino, $num);
						$this->excel->getActiveSheet()->setCellValue('B'.$ino, $o->name);
						$this->excel->getActiveSheet()->setCellValue('C'.$ino, $phone_str);
						$this->excel->getActiveSheet()->setCellValue('D'.$ino, $o->partner);
						$this->excel->getActiveSheet()->setCellValue('E'.$ino, $o->rsv_date);
						$this->excel->getActiveSheet()->setCellValue('F'.$ino, $o->rsv_part.'~'.$time_end);
						$this->excel->getActiveSheet()->setCellValue('G'.$ino, substr($o->created,0,10));

					}





					$file_name_rsv = 'landing_list_';
					if($type == 'sb0_3') {
						$file_name_rsv = 'landing_list_winner_';
					}

					//$filename='just_some_random_name.xls'; //save our workbook as this file name
					$filename=$file_name_rsv.date('YmdHis', TIME_STAMP).'.xls'; //save our workbook as this file name

					header('Content-Type: application/vnd.ms-excel'); //mime type
					header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
					header('Cache-Control: max-age=0'); //no cache
					//
					//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
					//if you want to save it as .XLSX Excel 2007 format
					$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
					//force user to download the Excel file without writing it to server's HD
					$objWriter->save('php://output');


	}




	// 예약 엑셀 변환
	//function excel_download($like_field=FALSE,$like_match=FALSE,$order_field=FALSE)
	function excel_download_winner($type=FALSE,$ex_srh_add=FALSE)
	{

		$srh_add = url_code($ex_srh_add,'d');
		$arr_srh = explode('/',$srh_add);

		$like_field = isset($arr_srh[0]) ? $arr_srh[0] : '';
		$like_match = isset($arr_srh[1]) ? $arr_srh[1] : '';
		$order_field = isset($arr_srh[2]) ? $arr_srh[2] : 'idx ASC';

		// 검색어 검색
		$like_side='both';


		// 휴대전화 검색인 경우
		if('phone' == $like_field && '' != $like_match) {
			$like_match = trim(str_replace('-','',$like_match));
		}

		if($type) {
			$sql_where = array('deleted'=>NULL);
		}

		// 목록 가져오기
		$arr_where = array(
				'sql_select'     => '*',
				'sql_from'       => 'winner_list',
				'sql_where'      => $sql_where,
				'sql_order_by'   => $order_field
		);



		if('' != $like_field && '' != $like_match)  {
			$arr_where['like_field'] = $like_field;
			$arr_where['like_match'] = $like_match;
			$arr_where['like_side'] = $like_side;
		}

		$result = $this->basic_model->arr_get_result($arr_where);








					//load our new PHPExcel library
					$this->load->library('excel');
					//activate worksheet number 1
					$this->excel->setActiveSheetIndex(0);
					//name the worksheet
					$this->excel->getActiveSheet()->setTitle('당첨자정보 다운로드');

					//set cell A1 content with some text
					$this->excel->getActiveSheet()->setCellValue('A1', '번호');
					$this->excel->getActiveSheet()->setCellValue('B1', '성명');
					$this->excel->getActiveSheet()->setCellValue('C1', '공급종류');
					$this->excel->getActiveSheet()->setCellValue('D1', '동');
					$this->excel->getActiveSheet()->setCellValue('E1', '호');
					$this->excel->getActiveSheet()->setCellValue('F1', '전화번호');
					$this->excel->getActiveSheet()->setCellValue('G1', '주택형');

					//change the font size
					//$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(20);
					$this->excel->getActiveSheet()->getStyle('A1:G1')->getFont()->setSize(10);

					//make the font become bold
					//$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
					$this->excel->getActiveSheet()->getStyle('A1:G1')->getFont()->setBold(true);

					/*
					//$this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
					$this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
					$this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
					$this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
					$this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
					$this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
					*/

					//$this->excel->getActiveSheet()->getStyle('A1:G1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);


					//set cell others content with some text
					foreach($result['qry'] as $i => $o)
					{

						// 번호
						//$num = ($result['total_count'] - $limit*($page-1) - $i);
						$num = $i + 1;

						$ino = $i + 2;

						$phone = array();
						$phone[0] = substr($o->phone,0,3);
						$phone[1] = substr($o->phone,3,4);
						$phone[2] = substr($o->phone,7,4);
						$phone_str = implode('-',$phone);

						$this->excel->getActiveSheet()->setCellValue('A'.$ino, $num);
						$this->excel->getActiveSheet()->setCellValue('B'.$ino, $o->name);
						$this->excel->getActiveSheet()->setCellValue('C'.$ino, $o->type);
						$this->excel->getActiveSheet()->setCellValue('D'.$ino, $o->dong);
						$this->excel->getActiveSheet()->setCellValue('E'.$ino, $o->ho);
						$this->excel->getActiveSheet()->setCellValue('F'.$ino, $phone_str);
						$this->excel->getActiveSheet()->setCellValue('G'.$ino, $o->area);

					}







					//$filename='just_some_random_name.xls'; //save our workbook as this file name
					$filename='winner_list_'.date('YmdHis', TIME_STAMP).'.xls'; //save our workbook as this file name

					header('Content-Type: application/vnd.ms-excel'); //mime type
					header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
					header('Cache-Control: max-age=0'); //no cache
					//
					//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
					//if you want to save it as .XLSX Excel 2007 format
					$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
					//force user to download the Excel file without writing it to server's HD
					$objWriter->save('php://output');


	}





}