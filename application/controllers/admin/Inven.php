<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Inven extends CI_Controller
{
	function __construct()
	{
		parent::__construct();

		// $autoload['helper'] = array('url', 'file', 'common');

		$this->load->helper(array('form', 'url', 'load','security'));
		$this->load->library('form_validation');
		$this->load->library('tank_auth');
		$this->load->library('inven_lib');
		$this->load->library('upload_lib');
		$this->lang->load('tank_auth');

		// 관리자 로그인 후에만 접속 가능, 그 외에는 메인 페이지로 이동.
		if(! $this->tank_auth->is_admin() ) {
			$this->tank_auth->logout();
			redirect('/auth/login/'. url_code('/admin','e'));
		}

		$this->arr_seg = $this->uri->segment_array();

		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		// 회원 레벨
		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		$arr = array('sql_select' => '*','sql_from' => 'user_level','sql_where' => array('use' => 'Y'),'sql_order_by' => 'no ASC');
		$this->level_result = $this->basic_model->arr_get_result($arr);
		//print_r($this->level_result);

	}

	function index()
	{
		//redirect(base_url().'admin/sub/main');
		//$this->main();

		if ($this->tank_auth->is_admin()) {									// logged in
			redirect('/admin/inven/lists/');
		}
		elseif($this->tank_auth->is_logged_in()) {
			$this->tank_auth->logout();
			//alert('관리자로 로그인해주세요.','admin/');
			//alert($this->lang->line('auth_message_admin_page'), 'admin/');
		}
		else {
			redirect('/auth/');
		}

	}

	function main() {
		redirect('/admin/inven/lists/');
	}



	public function lists()
	{

		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		// 재고 정보 엑셀 파일로 업로드(바코드 번호 필수)
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
					// 1번째 줄은 칼럼 타이틀(바코드번호/SKU/분류/상품명 등)
					for ($row = 2; $row <= $highestRow; $row++)
					{
						/* $rowData가 한줄의 데이터를 셀별로 배열처리 됩니다. */
						//$rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, TRUE, FALSE);
						$rowData = $sheet->rangeToArray('B' . $row . ':' . $highestColumn . $row, NULL, TRUE, FALSE);
						$udata = $rowData[0];

						/*
						$barcode	= isset($udata[0]) ? $udata[0] : FALSE;
						$sku		= isset($udata[1]) ? $udata[1] : FALSE;
						$branch		= isset($udata[2]) ? $udata[2] : FALSE;
						$itm_name	= isset($udata[3]) ? $udata[3] : FALSE;
						$location	= isset($udata[4]) ? $udata[4] : FALSE;
						$itm_qty	= isset($udata[5]) ? $udata[5] : FALSE;
						$brand		= isset($udata[6]) ? $udata[6] : FALSE;
						$volume		= isset($udata[7]) ? $udata[7] : FALSE;
						$unit		= isset($udata[8]) ? $udata[8] : FALSE;
						$itm_garo	= isset($udata[9]) ? $udata[9] : FALSE;
						$itm_sero	= isset($udata[10]) ? $udata[10] : FALSE;
						$itm_height = isset($udata[11]) ? $udata[11] : FALSE;
						$itm_weight = isset($udata[12]) ? $udata[12] : FALSE;
						$exp_date	= isset($udata[13]) ? $udata[13] : FALSE;
						$buy_date	= isset($udata[14]) ? $udata[14] : FALSE;
						$buy_price	= isset($udata[15]) ? $udata[15] : FALSE;
						$vendor		= isset($udata[16]) ? $udata[16] : FALSE;
						$itm_pic_url = isset($udata[17]) ? $udata[17] : FALSE;
						*/

						$barcode	= isset($udata[0]) ? $udata[0] : FALSE;

						$idata = array(
							
							'barcode'	=> isset($udata[0]) && $udata[0] != '' ? $udata[0] : NULL,
							'sku'		=> isset($udata[1]) && $udata[1] != '' ? $udata[1] : NULL,
							'branch'	=> isset($udata[2]) && $udata[2] != '' ? $udata[2] : NULL,
							'itm_name'	=> isset($udata[3]) && $udata[3] != '' ? $udata[3] : NULL,
							'location'	=> isset($udata[4]) && $udata[4] != '' ? $udata[4] : NULL,
							'itm_qty'	=> isset($udata[5]) && $udata[5] != '' ? $udata[5] : NULL,
							'brand'		=> isset($udata[6]) && $udata[6] != '' ? $udata[6] : NULL,
							'volume'	=> isset($udata[7]) && $udata[7] != '' ? $udata[7] : NULL,
							'unit'		=> isset($udata[8]) && $udata[8] != '' ? $udata[8] : NULL,
							'itm_garo'	=> isset($udata[9]) && $udata[9] != '' ? $udata[9] : NULL,
							'itm_sero'	=> isset($udata[10]) && $udata[10] != '' ? $udata[10] : NULL,
							'itm_height' => isset($udata[11]) && $udata[11] != '' ? $udata[11] : NULL,
							'itm_weight' => isset($udata[12]) && $udata[12] != '' ? $udata[12] : NULL,
							'exp_date'	=> isset($udata[13]) && $udata[13] != '' ? $udata[13] : NULL,
							'buy_date'	=> isset($udata[14]) && $udata[14] != '' ? $udata[14] : NULL,
							'buy_price'	=> isset($udata[15]) && $udata[15] != '' ? $udata[15] : NULL,
							'vendor'	=> isset($udata[16]) && $udata[16] != '' ? $udata[16] : NULL,
							'itm_pic_url' => isset($udata[17]) && $udata[17] != '' ? $udata[17] : NULL
						);


						$inven_cnt = $this->basic_model->get_common_count('erp_inven',array('barcode'=>$barcode));

						if( $inven_cnt > 0 ) {
							$this->inven_lib->excel_update_inven_lists($idata);
						}
						else {
							$this->inven_lib->excel_upload_inven_lists($idata);
						}

					}
				}

				//redirect(current_url());
				echo '<script type="text/javascript">parent.location.reload();</script>';

			}
		}


		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		// 페이징 정보 
		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		$this->load->library('segment', array('offset'=>4), 'seg'); // 세그먼트 주소( /page/ 위치 )
		$this->load->library('querystring', NULL, 'param'); // 쿼리스트링 주소
		$seg	  =& $this->seg;
		$param	  =& $this->param;
		
		// [sql] where option 
		$sql_where_option = array('deleted'=>NULL);
		$sql_where_option = array('deleted'=>NULL, 'itm_qty >'=>0);

		// [페이징]
		$qstr = '';

		// 검색
		if($sfl = $param->get('sfl',FALSE)) { // search field
			$qstr .= ('' == $qstr) ? '?' : '&';
			$qstr .= 'sfl='.$sfl;
		}
		if($stx = $param->get('stx',FALSE)) { // search text
			$qstr .= ('' == $qstr) ? '?' : '&';
			$qstr .= 'stx='.$stx;
		}
		// 정렬
		if($ofl = $param->get('ofl','created DESC,idx DESC')) { // order_field
			$qstr .= ('' == $qstr) ? '?' : '&';
			$qstr .= 'ofl='.$ofl;
		}

		if($sfl == 'all') {
			$sfl = '';
			$stx = '';
		}




		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		// sql natural
		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		/*
		$this->db->select('*');
		$this->db->from('erp_inven as inven');
		$this->db->join('erp_inven_in as inven_in', 'inven.barcode = inven_in.barcode', 'left');
		$this->db->join('erp_inven_out as inven_out', 'inven.barcode = inven_out.barcode', 'left');

		$array = array('deleted'=>NULL,'itm_qty >'=>0);
		$this->db->where($array);

		$query = $this->db->get();
		*/


		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		// sql 
		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		//$sql_select = 'inven.*, inven_in.*, inven_out.*';
		$sql_select = 'inven.*';
		$sql_from = 'erp_inven as inven';
		$like_field = $sfl;                         // search
		$like_match = $stx;
		$like_side = 'both';
		$sql_where = $sql_where_option;            // where, group, order
		$sql_group_by = FALSE;
		$sql_order_by = $ofl;
		// 페이징
		$limit = '20';
		$page  = $seg->get('page', 1); // 페이지
		if(! isset($page) OR empty($page)) {
			$page = '1';
		}
		$offset = ($page - 1) * $limit;
		// 조인
		$sql_join_tbl = ''; //'erp_inven_in as inven_in';
		$sql_join_on = ''; //'inven.barcode = inven_in.barcode';
		$sql_join_option = ''; //'LEFT OUTER';

		// 검색 상관없는 전체 수
		$inven_total_count = $this->basic_model->get_common_count($sql_from,$sql_where);

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
		//$result = $this->basic_model->arr_get_result($arr);
		//$list = $this->basic_lib->arr_inven_list($arr);
		$list = $this->inven_lib->arr_inven_list($arr);


		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		// pagination 설정
		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		$config['suffix']	   = $qstr; //$qstr;
		$config['base_url']    = base_url() . 'admin/inven/lists/page/';
		$config['per_page']    = $limit;
		$config['total_rows']  = $list['total_count'];
		$config['uri_segment'] = $seg->pos('page');  // 5

		// 검색 목록 ADD
		$btn_prev_part = $btn_next_part = '';
		$config['full_tag_open']  = "<ul class='pagination'>".$btn_prev_part;
		$config['full_tag_close'] = $btn_next_part.'</ul>';

		//$CI =& get_instance();
		//$CI->load->library('pagination', $config);
		$this->load->library('pagination', $config);

		// 엑셀 다운로드
		if($sfl == '' || $sfl == 'all') {
			$sfl = 'all';
			$stx = '';
		}
		$btn_excel_download = '<a href="/admin/inven/excel_download_inven/'.url_code($sfl,'e').'/'.url_code($stx,'e').'/'.url_code($ofl,'e').'" class="btn btn-dark btn-xs o_btn">엑셀 다운</a>';


		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		// Get data.
		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		$breadcrumb = array(
			'재고관리'=>base_url().'admin/inven/lists',
			'재고목록'=>''
		);

		$data = array(
			'sfl' => $sfl,
			'stx' => $stx,
			'ofl' => $ofl,

			'inven_total_count' => $inven_total_count,
			'list'    => $list,
			//'result'    => $result,
			'page'      => $page,
			'limit'      => $limit,
			'paging'    => $this->pagination->create_links(),

			'btn_excel_download'  => $btn_excel_download,

			'arr_seg'   => $this->arr_seg, //$this->uri->segment_array(),
			'breadcrumb'    => $breadcrumb,
			'viewPage'  => 'admin/inven_lists_view'
		);

		$this->load->view('admin/layout_view', $data);
	}







	// 이벤트 엑셀 변환
	function excel_download_inven($sfl='',$stx='',$ofl='')
	{

			// [sql] where option 
			$sql_where_option = array('deleted'=>NULL);


			$sfl = url_code($sfl,'d');
			$stx = url_code($stx,'d');
			$ofl = url_code($ofl,'d');

			if($sfl == 'all') {
				$sfl = FALSE;
				$stx = FALSE;
			}

			// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
			// sql 
			// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
			$sql_select = 'inven.*';
			$sql_from = 'erp_inven as inven';
			$like_field = $sfl;                         // search
			$like_match = $stx;
			$like_side = 'both';
			$sql_where = $sql_where_option;            // where, group, order
			$sql_group_by = FALSE;
			$sql_order_by = $ofl;
			// 조인
			$sql_join_tbl = ''; 
			$sql_join_on = '';
			$sql_join_option = 'LEFT OUTER';

			// 검색 상관없는 전체 수
			$inven_total_count = $this->basic_model->get_common_count($sql_from,$sql_where);

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
			);
			$result = $this->basic_model->arr_get_result($arr);

			//echo $this->db->last_query();
			//exit;

			//load our new PHPExcel library
			$this->load->library('excel');
			//activate worksheet number 1
			$this->excel->setActiveSheetIndex(0);
			//name the worksheet
			$this->excel->getActiveSheet()->setTitle('재고 목록 다운로드');

			//set cell A1 content with some text
			$this->excel->getActiveSheet()->setCellValue('A1', '번호');
			$this->excel->getActiveSheet()->setCellValue('B1', '바코드');
			$this->excel->getActiveSheet()->setCellValue('C1', 'SKU');
			$this->excel->getActiveSheet()->setCellValue('D1', '분류');
			$this->excel->getActiveSheet()->setCellValue('E1', '상품명');
			$this->excel->getActiveSheet()->setCellValue('F1', '수량');
			$this->excel->getActiveSheet()->setCellValue('G1', '위치');
			$this->excel->getActiveSheet()->setCellValue('H1', '브랜드');
			$this->excel->getActiveSheet()->setCellValue('I1', '용량');
			$this->excel->getActiveSheet()->setCellValue('J1', '단위');
			$this->excel->getActiveSheet()->setCellValue('K1', '가로');
			$this->excel->getActiveSheet()->setCellValue('L1', '세로');
			$this->excel->getActiveSheet()->setCellValue('M1', '높이');
			$this->excel->getActiveSheet()->setCellValue('N1', '무게');
			$this->excel->getActiveSheet()->setCellValue('O1', '유통기한');
			$this->excel->getActiveSheet()->setCellValue('P1', '매입일');
			$this->excel->getActiveSheet()->setCellValue('Q1', '매입가');
			$this->excel->getActiveSheet()->setCellValue('R1', '매입처');
			$this->excel->getActiveSheet()->setCellValue('S1', '사진');

			//change the font size
			//$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(20);
			$this->excel->getActiveSheet()->getStyle('A1:S1')->getFont()->setSize(10);

			//make the font become bold
			//$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
			$this->excel->getActiveSheet()->getStyle('A1:S1')->getFont()->setBold(true);

			/*
			$this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
			$this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(30);
			$this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
			$this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(30);
			$this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
			$this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
			*/

			//merge cell A1 until D1
			//$this->excel->getActiveSheet()->mergeCells('A1:D1');

			//set aligment to center for that merged cell (A1 to D1)
			//$this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			//$this->excel->getActiveSheet()->getStyle('A1:H1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->getStyle('A1:S1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

			//set cell others content with some text
			/*
			for($i=2;$i<10;$i++) {
				$this->excel->getActiveSheet()->setCellValue('A'.$i, '이름');
				$this->excel->getActiveSheet()->setCellValue('B'.$i, '연락처');
				$this->excel->getActiveSheet()->setCellValue('C'.$i, '이메일');
				$this->excel->getActiveSheet()->setCellValue('D'.$i, '신청일');
				$this->excel->getActiveSheet()->setCellValue('E'.$i, '비고');
			}
			*/


			//set cell others content with some text
			foreach($result['qry'] as $i => $o)
			{

				// 번호
				//$num = ($result['total_count'] - $limit*($page-1) - $i);
				$num = $i + 1;

				$ino = $i + 2;

				$this->excel->getActiveSheet()->setCellValue('A'.$ino, $num);
				$this->excel->getActiveSheet()->setCellValue('B'.$ino, $o->barcode);
				$this->excel->getActiveSheet()->setCellValue('C'.$ino, $o->sku);
				$this->excel->getActiveSheet()->setCellValue('D'.$ino, $o->branch);
				$this->excel->getActiveSheet()->setCellValue('E'.$ino, $o->itm_name);
				$this->excel->getActiveSheet()->setCellValue('F'.$ino, $o->itm_qty);
				$this->excel->getActiveSheet()->setCellValue('G'.$ino, $o->location);
				$this->excel->getActiveSheet()->setCellValue('H'.$ino, $o->brand);
				$this->excel->getActiveSheet()->setCellValue('I'.$ino, $o->volume);
				$this->excel->getActiveSheet()->setCellValue('J'.$ino, $o->unit);
				$this->excel->getActiveSheet()->setCellValue('K'.$ino, $o->itm_garo);
				$this->excel->getActiveSheet()->setCellValue('L'.$ino, $o->itm_sero);
				$this->excel->getActiveSheet()->setCellValue('M'.$ino, $o->itm_height);
				$this->excel->getActiveSheet()->setCellValue('N'.$ino, $o->itm_weight);
				$this->excel->getActiveSheet()->setCellValue('O'.$ino, $o->exp_date);
				$this->excel->getActiveSheet()->setCellValue('P'.$ino, $o->buy_date);
				$this->excel->getActiveSheet()->setCellValue('Q'.$ino, $o->buy_price);
				$this->excel->getActiveSheet()->setCellValue('R'.$ino, $o->vendor);
				$this->excel->getActiveSheet()->setCellValue('S'.$ino, $o->itm_pic_url);
			}

			//$filename='just_some_random_name.xls'; //save our workbook as this file name
			$filename='inven_list_'.date('Ymd', TIME_STAMP).'.xls'; //save our workbook as this file name

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