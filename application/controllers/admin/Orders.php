<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Orders extends CI_Controller
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
			redirect('/admin/orders/request_lists/');
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
		redirect('/admin/orders/request_lists/');
	}





















	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	// 구매의뢰 목록
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	public function request_lists()
	{

		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		// 주문(구매의뢰) 정보 엑셀 파일로 업로드(바코드 번호 필수)
		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		if( $this->input->post('excel_upload_submit') ) {

			$chk = $this->input->post('chk_excel',FALSE);
			$mall = $this->input->post('mall',FALSE);

			if('upload' == $chk) 
			{

				// 엑셀 업로드

				//load our new PHPExcel library
				$this->load->library('excel');

				$objPHPExcel = new PHPExcel();
				$objPHPExcel = PHPExcel_IOFactory::load($_FILES['excel_file']['tmp_name']);
				$sheetsCount = $objPHPExcel->getSheetCount();

				$orderid_before = '';
				$orderid_item = '';

				$pr_idx = '';
				$pr_seq = 1;

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

						//echo $row.'<<<<br />';
						//echo $highestRow.'<<<<br />';

						/* $rowData가 한줄의 데이터를 셀별로 배열처리 됩니다. */
						$rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, TRUE, FALSE);
						//$rowData = $sheet->rangeToArray('B' . $row . ':' . $highestColumn . $row, NULL, TRUE, FALSE);
						$udata = $rowData[0];

						/*
						print_r($udata);
						exit;
						*/

						/*
						[erp_pur_req]
							manager_id
							manager
							pr_mall
							pr_order_id
							currency
							pr_buyer_id
							pr_buyer_email
							pr_buyer_name
							pr_datetime
							pr_shipping
							pr_taxes
							pr_discount
							pr_total
							remark
							created

						[erp_pur_req_item]
							pr_idx
							pr_order_id
							pr_seq
							itm_code
							itm_name
							itm_qty
							unitprice
							status
							remark

						*/

						$manager_id = $this->tank_auth->get_username();
						$manager_name = $this->tank_auth->get_nickname();
						//echo $manager_id.'<<<<<<<<br />';
						//exit;

						if($mall == 'coscorea.com' OR $mall == 'ccorea.com') {

								if($row  < 2) {
									continue;
								}

								// 주문 순번
								$pr_order_num = ($mall == 'ccorea.com') ? $udata[0] : $udata[0];

								// 주문 고유 아이디
								$pr_order_id = ($mall == 'ccorea.com') ? $udata[51] : $udata[55];

								$currency = isset($udata[7]) && $udata[7] != '' ? $udata[7] : NULL;
								$pr_buyer_id = '';
								$pr_buyer_email = isset($udata[1]) && $udata[1] != '' ? $udata[1] : NULL;
								$pr_buyer_name = '';
								//$pr_datetime = isset($udata[3]) && $udata[3] != '' ? $udata[3] : NULL;
								$pr_datetime_org = isset($udata[3]) && $udata[3] != '' ? $udata[3] : NULL;

								$timestamp = strtotime($pr_datetime_org); 
								$newDate = date("Y-m-d", $timestamp );
								$pr_datetime = $newDate;

								$pr_subtotal = isset($udata[8]) && $udata[8] != '' ? $udata[8] : NULL;
								$pr_shipping = isset($udata[9]) && $udata[9] != '' ? $udata[9] : NULL;
								$pr_taxes = isset($udata[10]) && $udata[10] != '' ? $udata[10] : NULL;
								$pr_discount = isset($udata[13]) && $udata[13] != '' ? $udata[13] : NULL;
								$pr_total = isset($udata[11]) && $udata[11] != '' ? $udata[11] : NULL;
								
								$pr_status = isset($udata[2]) && $udata[2] != '' ? $udata[2] : NULL;

								$itm_name = isset($udata[17]) && $udata[17] != '' ? $udata[17] : NULL;
								$itm_qty = isset($udata[16]) && $udata[16] != '' ? $udata[16] : NULL;
								$unitprice = isset($udata[18]) && $udata[18] != '' ? $udata[18] : NULL;

								$req_data = array(
									'manager_id' => $manager_id,
									'manager' => $manager_name,
									'pr_mall' => $mall,
									'pr_order_num' => $pr_order_num,
									'pr_order_id' => $pr_order_id,
									'currency' => $currency,

									'pr_buyer_id' => '',
									'pr_buyer_email' => $pr_buyer_email,
									'pr_buyer_name' => $pr_buyer_name,
									'pr_datetime_org' => $pr_datetime_org,
									'pr_datetime' => $pr_datetime,

									'pr_subtotal' => $pr_subtotal,
									'pr_shipping' => $pr_shipping,
									'pr_taxes' => $pr_taxes,
									'pr_discount' => $pr_discount,
									'pr_total' => $pr_total,
									'pr_status' => $pr_status,
									//'remark' => '',
									//'created' => TIME_YMDHIS,
								);


								$orderid_item = ($pr_order_id != '') ? $pr_order_id : $orderid_item;


								if($orderid_before != $orderid_item) {
									$pr_seq = 1;
								}
								else {
									$pr_seq++;
								}


								$item_data = array(
									'pr_mall' => $mall,
									'pr_order_num' => $pr_order_num,
									'pr_order_id' => $orderid_item,
									'pr_seq' => $pr_seq,
									//'itm_code' => '',
									'itm_name' => $itm_name,
									'itm_qty' => $itm_qty,
									'unitprice' => $unitprice,
								);


								// 주문정보
								$pur_req_cnt = $this->basic_model->get_common_count('erp_pur_req',array('pr_order_id'=>$pr_order_id));
								if($orderid_before != $pr_order_id && $pr_order_id != '') {
									if($pur_req_cnt > 0) {
										//$this->inven_lib->excel_update_pur_req($req_data);
									}
									else {
										$req_data['created'] = TIME_YMDHIS;
										$res = $this->inven_lib->excel_upload_pur_req($req_data);
										$pr_idx = $res['idx'];
									}
								}

								// 주문 상세정보
								$pur_item_cnt = $this->basic_model->get_common_count('erp_pur_req_item',array('pr_order_id'=>$pr_order_id,'pr_seq'=>$pr_seq));
								if($pur_item_cnt > 0) {
									//$this->inven_lib->excel_update_pur_req_item($item_data);
								}
								else {
									$item_data['pr_idx'] = $pr_idx;
									$item_data['pr_seq'] = $pr_seq;
									$this->inven_lib->excel_upload_pur_req_item($item_data);
								}



						}	
						elseif($mall == 'ebay_usa1' OR $mall == 'ebay_usa2' OR $mall == 'ebay_uk' OR $mall == 'ebay_de' OR $mall == 'ebay_au') {

								if($row  < 3 OR '' == $udata[0] ) {
									continue;
								}

								if('record(s) downloaded' == $udata[1]) {
									break;
								}

								$pr_order_id = isset($udata[1]) ? $udata[1] : '';
								// 주문 번호가 없으면 취소된 주문.. 없어도 됩
								if('' == $pr_order_id) {
									continue;
								}


								//$currency = isset($udata[]) && $udata[] != '' ? $udata[] : NULL;
								$pr_buyer_id = isset($udata[2]) && $udata[2] != '' ? $udata[2] : NULL;
								$pr_buyer_email = isset($udata[4]) && $udata[4] != '' ? $udata[4] : NULL;
								$pr_buyer_name = isset($udata[3]) && $udata[3] != '' ? $udata[3] : NULL;
								$pr_datetime_org = isset($udata[48]) && $udata[48] != '' ? $udata[48] : NULL;

								$timestamp = strtotime($pr_datetime_org); 
								$newDate = date("Y-m-d", $timestamp );
								$pr_datetime = $newDate;

								$pr_subtotal = isset($udata[46]) && $udata[46] != '' ? $udata[46] : NULL;
								$pr_shipping = isset($udata[28]) && $udata[28] != '' ? $udata[28] : NULL;
								$pr_taxes = isset($udata[38]) && $udata[38] != '' ? $udata[38] : NULL;
								//$pr_discount = isset($udata[]) && $udata[] != '' ? $udata[] : NULL;
								$pr_total = isset($udata[45]) && $udata[45] != '' ? $udata[45] : NULL;
								//$pr_status = isset($udata[]) && $udata[] != '' ? $udata[] : NULL;

								//$itm_name = isset($udata[23]) && $udata[23] != '' ? $udata[23] : NULL;
								$itm_name = isset($udata[23]) ? $udata[23] : '';
								$itm_qty = isset($udata[26]) && $udata[26] != '' ? $udata[26] : NULL;
								$unitprice = isset($udata[27]) && $udata[27] != '' ? $udata[18] : NULL;

								// [START] ebay 커스텀 - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

								$arr_price = explode(' ',$pr_subtotal);
								$cnt_price = count($arr_price);
								$currency = 'USD';
								if($cnt_price > 1) {
									$currency = trim($arr_price[0]);
									//$pr_subtotal = substr($arr_price[1],1);
									$pr_subtotal = substr($arr_price[1],3);
								}
								else {
									//$pr_subtotal = substr($pr_subtotal,1);
									$pr_subtotal = substr($pr_subtotal,3);
								}

								$arr_price = explode(' ',$pr_shipping);
								$cnt_price = count($arr_price);
								$pr_shipping = ($cnt_price > 1) ? substr($arr_price[1],3) : $pr_shipping = substr($pr_shipping,3);

								$arr_price = explode(' ',$pr_taxes);
								$cnt_price = count($arr_price);
								$pr_taxes = ($cnt_price > 1) ? substr($arr_price[1],3) : $pr_taxes = substr($pr_taxes,3);

								$arr_price = explode(' ',$pr_total);
								$cnt_price = count($arr_price);
								$pr_total = ($cnt_price > 1) ? substr($arr_price[1],3) : $pr_total = substr($pr_total,3);

								$arr_price = explode(' ',$unitprice);
								$cnt_price = count($arr_price);
								$unitprice = ($cnt_price > 1) ? substr($arr_price[1],3) : $unitprice = substr($unitprice,3);
								// [END] ebay 커스텀 - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -



								// 주문정보 + + + + + + + + + + + + + + + + + + + +
								$req_data = array(
									'manager_id' => $manager_id,
									'manager' => $manager_name,
									'pr_mall' => $mall,
									'pr_order_id' => $pr_order_id,
									'currency' => $currency,

									'pr_buyer_id' => $pr_buyer_id,
									'pr_buyer_email' => $pr_buyer_email,
									'pr_buyer_name' => $pr_buyer_name,
									'pr_datetime_org' => $pr_datetime_org,
									'pr_datetime' => $pr_datetime,

									'pr_subtotal' => $pr_subtotal,
									'pr_shipping' => $pr_shipping,
									'pr_taxes' => $pr_taxes,
									//'pr_discount' => $pr_discount,
									'pr_total' => $pr_total,
									//'pr_status' => $pr_status,
									//'remark' => '',
									//'created' => TIME_YMDHIS,
								);

								$pur_req_cnt = $this->basic_model->get_common_count('erp_pur_req',array('pr_order_id'=>$pr_order_id));
								if($orderid_before != $pr_order_id && $pr_order_id != '') {
									if($pur_req_cnt > 0) {
										//$this->inven_lib->excel_update_pur_req($req_data);
									}
									else {
										$req_data['created'] = TIME_YMDHIS;
										$res = $this->inven_lib->excel_upload_pur_req($req_data);
										$pr_idx = $res['idx'];
									}
								}



								// 주문상세정보 - 제품정보 + + + + + + + + + + + + + + + + + + + +
								// 제품명이 있는 경우만
								// ebya 주문내역서에서는 전체 주문정보 하단에 세부 제품내역이 추가되는 형태이므로, 
								if($itm_name == '') {
									continue;
								}
								else {
									$orderid_item = $pr_order_id;
									if($orderid_before != $orderid_item && '' != $pr_order_id) {
										$pr_seq = 1;
									}
									else {
										$pr_seq++;
									}

									$item_data = array(
										'pr_mall' => $mall,
										'pr_order_id' => $orderid_item,
										'pr_seq' => $pr_seq,
										//'itm_code' => '',
										'itm_name' => $itm_name,
										'itm_qty' => $itm_qty,
										'unitprice' => $unitprice,
									);

									// 주문 상세정보
									$pur_item_cnt = $this->basic_model->get_common_count('erp_pur_req_item',array('pr_order_id'=>$pr_order_id,'pr_seq'=>$pr_seq));
									if($pur_item_cnt > 0) {
										//$this->inven_lib->excel_update_pur_req_item($item_data);
									}
									else {
										$item_data['pr_idx'] = $pr_idx;
										$item_data['pr_seq'] = $pr_seq;
										$this->inven_lib->excel_upload_pur_req_item($item_data);
									}

								}



						}
						else {

							//redirect('/admin/orders/request_lists/');
							alert_stay('업로드 대상이 아닌가봅니다. 사이트 관리자에게 문의해주세요.');
							reload_parent_page();


						}


						/*
							// 주문정보
							$pur_req_cnt = $this->basic_model->get_common_count('erp_pur_req',array('pr_order_id'=>$pr_order_id));
							if($orderid_before != $pr_order_id && $pr_order_id != '') {
								if($pur_req_cnt > 0) {
									//$this->inven_lib->excel_update_pur_req($req_data);
								}
								else {
									$req_data['created'] = TIME_YMDHIS;
									$res = $this->inven_lib->excel_upload_pur_req($req_data);
									$pr_idx = $res['idx'];
								}
							}

							// 주문 상세정보
							$pur_item_cnt = $this->basic_model->get_common_count('erp_pur_req_item',array('pr_order_id'=>$pr_order_id,'pr_seq'=>$pr_seq));
							if($pur_item_cnt > 0) {
								//$this->inven_lib->excel_update_pur_req_item($item_data);
							}
							else {
								$item_data['pr_idx'] = $pr_idx;
								$item_data['pr_seq'] = $pr_seq;
								$this->inven_lib->excel_upload_pur_req_item($item_data);
							}
						*/

						/*
						$pur_req_cnt = $this->basic_model->get_common_count('erp_pur_req',array('pr_order_id'=>$pr_order_id));
						if( $pur_req_cnt > 0 ) {
							$this->inven_lib->excel_update_pur_req($req_data);
						}
						else {
							$this->inven_lib->excel_upload_pur_req($req_data);
						}
						*/


						$orderid_before = $orderid_item;

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

		// [페이징]
		$qstr = '';

		// 몰 정보 추가
		if($pr_mall = $param->get('pr_mall',FALSE)) { // search field
			$qstr .= ('' == $qstr) ? '?' : '&';
			$qstr .= 'pr_mall='.$pr_mall;
			$sql_where_option['pr_mall'] = $pr_mall;
		}

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
		if($ofl = $param->get('ofl','pr_datetime DESC')) { // order_field
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
		//$sql_select = 'req.*, order.*';
		$sql_select = 'req.*';
		$sql_from = 'erp_pur_req as req';
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
		$list = $this->inven_lib->arr_req_list($arr);


		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		// pagination 설정
		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		$config['suffix']	   = $qstr; //$qstr;
		$config['base_url']    = base_url() . 'admin/orders/request_lists/page/';
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
		$btn_excel_download = '<a href="/admin/orders/excel_download_request/'.url_code($sfl,'e').'/'.url_code($stx,'e').'/'.url_code($ofl,'e').'" class="btn btn-dark btn-xs o_btn">엑셀 다운</a>';


		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		// Get data.
		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		$breadcrumb = array(
			'주문관리'=>base_url().'admin/orders/request_lists',
			'구매의뢰목록'=>''
		);

		$data = array(
			'sfl' => $sfl,
			'stx' => $stx,
			'ofl' => $ofl,
			'pr_mall' => $pr_mall,

			'inven_total_count' => $inven_total_count,
			'list'    => $list,
			//'result'    => $result,
			'page'      => $page,
			'limit'      => $limit,
			'paging'    => $this->pagination->create_links(),

			'btn_excel_download'  => $btn_excel_download,

			'arr_seg'   => $this->arr_seg, //$this->uri->segment_array(),
			'breadcrumb'    => $breadcrumb,
			'viewPage'  => 'admin/orders_request_lists_view'
		);

		$this->load->view('admin/layout_view', $data);
	}



	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	// 구매의뢰 등록/수정
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	public function request_form()
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
		if($ofl = $param->get('ofl','created DESC')) { // order_field
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
		$list = $this->basic_lib->arr_inven_list($arr);


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
			$stx = '-';
		}
		$btn_excel_download = '<a href="/admin/orders/excel_download_inven/'.url_code($sfl,'e').'/'.url_code($stx,'e').'/'.url_code($ofl,'e').'" class="btn btn-dark btn-xs o_btn">엑셀 다운</a>';


		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		// Get data.
		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		$breadcrumb = array(
			'재고관리'=>base_url().'admin/orders/lists',
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
			'viewPage'  => 'admin/orders_request_form_view'
		);

		$this->load->view('admin/layout_view', $data);
	}


	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	// 구매의뢰 상세
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	public function request_detail($pr_order_id=FALSE)
	{

		if(! $pr_order_id) {
			alert('잘못된 접근입니다.');
		}

		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		// 페이징 정보 
		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		$this->load->library('segment', array('offset'=>4), 'seg'); // 세그먼트 주소( /page/ 위치 )
		$this->load->library('querystring', NULL, 'param'); // 쿼리스트링 주소
		$seg	  =& $this->seg;
		$param	  =& $this->param;

		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		// 주문 정보
		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		$sql_arr = array(
				'sql_select'     => '*',
				'sql_from'       => 'erp_pur_req as req',
				'sql_where'      => array('req.pr_order_id'=>$pr_order_id)
		);
		$row = $this->basic_model->arr_get_row($sql_arr);


		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		// sql 
		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		$sql_select = 'item.*';
		$sql_from = 'erp_pur_req_item as item';
		$like_field = FALSE;                         // search
		$like_match = FALSE;
		$like_side = 'both';
		$sql_where = array('pr_order_id'=>$pr_order_id);            // where, group, order
		$sql_group_by = FALSE;
		$sql_order_by = FALSE;
		// 페이징
		$limit = '100';
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
		$result = $this->basic_model->arr_get_result($arr);


		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		// Get data.
		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		$breadcrumb = array(
			'주문관리'=>base_url().'admin/orders/request_lists',
			'구매의뢰상세'=>''
		);

		$data = array(
			'row'       => $row,
			'result'    => $result,
			//'page'      => $page,
			//'limit'      => $limit,
			//'paging'    => $this->pagination->create_links(),

			'arr_seg'   => $this->arr_seg, //$this->uri->segment_array(),
			'breadcrumb'    => $breadcrumb,
			'viewPage'  => 'admin/orders_request_detail_view'
		);

		$this->load->view('admin/layout_view', $data);
	}





















	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	// 발주 목록
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
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
		if($ofl = $param->get('ofl','created DESC')) { // order_field
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
		$list = $this->basic_lib->arr_inven_list($arr);


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
			$stx = '-';
		}
		$btn_excel_download = '<a href="/admin/orders/excel_download_inven/'.url_code($sfl,'e').'/'.url_code($stx,'e').'/'.url_code($ofl,'e').'" class="btn btn-dark btn-xs o_btn">엑셀 다운</a>';


		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		// Get data.
		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		$breadcrumb = array(
			'재고관리'=>base_url().'admin/orders/lists',
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
			'viewPage'  => 'admin/orders_lists_view'
		);

		$this->load->view('admin/layout_view', $data);
	}


	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	// 신규 발주
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	public function form() {

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