<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Inven_lib
 *
 * Inventory library for Code Igniter.
 *
 * @package		Inven_lib
 */
class Inven_lib
{
	private $error = array();

	function __construct()
	{
		$this->ci =& get_instance();
		//$this->ci->load->config('tank_auth', TRUE);
		//$this->ci->load->library('session');
		$this->ci->load->library('tank_auth');
		$this->ci->load->database();
		$this->ci->load->model('inven_model');
	}






	public function excel_upload_pur_req($item_data=FALSE) {

			if (!is_null($res = $this->ci->inven_model->excel_upload_pur_req($item_data))) {
				$item_data['idx'] = $res['idx'];
				return $item_data;
			}

		return NULL;
	}

	public function excel_upload_pur_req_item($item_data=FALSE) {

			if (!is_null($res = $this->ci->inven_model->excel_upload_pur_req_item($item_data))) {
				$item_data['idx'] = $res['idx'];
				return $item_data;
			}

		return NULL;
	}





	public function arr_inven_list($arr=FALSE) 
	{

		//print_r($arr);

		$list = array('total_count'=>0, 'qry'=>array());

		if($arr) {
			$result = $this->ci->basic_model->arr_get_result($arr);
			$list['total_count'] = $result['total_count'];

			foreach ($result['qry'] as $i => $row) {

				$list['qry'][$i] = new stdClass();
				$list['qry'][$i]->num = ($result['total_count'] - $arr['limit']*($arr['page']-1) - $i);

				//print_r($row);

				$list['qry'][$i]->idx = $row->idx;
				$list['qry'][$i]->barcode = $row->barcode;
				$list['qry'][$i]->sku = $row->sku;
				$list['qry'][$i]->branch = $row->branch;
				$list['qry'][$i]->itm_name = $row->itm_name;
				$list['qry'][$i]->itm_qty = $row->itm_qty;
				$list['qry'][$i]->location = $row->location;
				$list['qry'][$i]->brand = $row->brand;
				$list['qry'][$i]->volume = $row->volume;
				$list['qry'][$i]->unit = $row->unit;

				$list['qry'][$i]->itm_garo = $row->itm_garo;
				$list['qry'][$i]->itm_sero = $row->itm_sero;
				$list['qry'][$i]->itm_height = $row->itm_height;
				$list['qry'][$i]->itm_weight = $row->itm_weight;

				$list['qry'][$i]->exp_date = $row->exp_date;
				$list['qry'][$i]->buy_date = $row->buy_date;
				$list['qry'][$i]->buy_price = $row->buy_price;
				$list['qry'][$i]->vendor = $row->vendor;
				$list['qry'][$i]->itm_mall_url = $row->itm_mall_url;
				$list['qry'][$i]->itm_pic_url = $row->itm_pic_url;
				$list['qry'][$i]->created = $row->created;
				$list['qry'][$i]->deleted = $row->deleted;

			}
		}

		return ( ! empty($list)) ? $list : false;
	}


















	function excel_upload_inven_lists($idata=FALSE) {


			/*
			$barcode	= isset($udata[0]) && $udata[0] != '' ? $udata[0] : NULL;
			$sku		= isset($udata[1]) && $udata[1] != '' ? $udata[1] : NULL;
			$branch		= isset($udata[2]) && $udata[2] != '' ? $udata[2] : NULL;
			$itm_name	= isset($udata[3]) && $udata[3] != '' ? $udata[3] : NULL;
			$location	= isset($udata[4]) && $udata[4] != '' ? $udata[4] : NULL;
			$itm_qty	= isset($udata[5]) && $udata[5] != '' ? $udata[5] : NULL;
			$brand		= isset($udata[6]) && $udata[6] != '' ? $udata[6] : NULL;
			$volume		= isset($udata[7]) && $udata[7] != '' ? $udata[7] : NULL;
			$unit		= isset($udata[8]) && $udata[8] != '' ? $udata[8] : NULL;
			$itm_garo	= isset($udata[9]) && $udata[9] != '' ? $udata[9] : NULL;
			$itm_sero	= isset($udata[10]) && $udata[10] != '' ? $udata[10] : NULL;
			$itm_height = isset($udata[11]) && $udata[11] != '' ? $udata[11] : NULL;
			$itm_weight = isset($udata[12]) && $udata[12] != '' ? $udata[12] : NULL;
			$exp_date	= isset($udata[13]) && $udata[13] != '' ? $udata[13] : NULL;
			$buy_date	= isset($udata[14]) && $udata[14] != '' ? $udata[14] : NULL;
			$buy_price	= isset($udata[15]) && $udata[15] != '' ? $udata[15] : NULL;
			$vendor		= isset($udata[16]) && $udata[16] != '' ? $udata[16] : NULL;
			$itm_pic_url = isset($udata[17]) && $udata[17] != '' ? $udata[17] : NULL;
			*/

			$barcode = $idata['barcode'];
			$sku = $idata['sku'];
			$branch = $idata['branch'];
			$itm_name = $idata['itm_name'];
			$location = $idata['location'];
			$itm_qty = $idata['itm_qty'];
			$brand = $idata['brand'];
			$volume = $idata['volume'];
			$unit = $idata['unit'];
			$itm_garo = $idata['itm_garo'];
			$itm_sero = $idata['itm_sero'];
			$itm_height = $idata['itm_height'];
			$itm_weight = $idata['itm_weight'];
			$exp_date = $idata['exp_date'];
			$buy_date = $idata['buy_date'];
			$buy_price = $idata['buy_price'];
			$vendor = $idata['vendor'];
			$itm_pic_url = $idata['itm_pic_url'];


			$data = array(
				'created'	=> TIME_YMDHIS,
				'route'	=> 'excel',

				'barcode' => $barcode,
				'sku' => $sku,
				'branch' => $branch,
				'itm_name' => $itm_name,
				'location' => $location,
				'itm_qty' => $itm_qty,
				'brand' => $brand,
				'volume' => $volume,
				'unit' => $unit,
				'itm_garo' => $itm_garo,
				'itm_sero' => $itm_sero,
				'itm_height' => $itm_height,
				'itm_weight' => $itm_weight,
				'exp_date' => $exp_date,
				'buy_date' => $buy_date,
				'buy_price' => $buy_price,
				'vendor' => $vendor,
				'itm_pic_url' => $itm_pic_url,

				'mnger_id' => $this->ci->tank_auth->get_username()
			);

			if (!is_null($res = $this->ci->inven_model->excel_upload_inven_lists($data))) {
				$data['idx'] = $res['idx'];
				return $data;
			}

		return NULL;
	}

	function excel_update_inven_lists($idata=FALSE) {

			$barcode = $idata['barcode'];
			$sku = $idata['sku'];
			$branch = $idata['branch'];
			$itm_name = $idata['itm_name'];
			$location = $idata['location'];
			$itm_qty = $idata['itm_qty'];
			$brand = $idata['brand'];
			$volume = $idata['volume'];
			$unit = $idata['unit'];
			$itm_garo = $idata['itm_garo'];
			$itm_sero = $idata['itm_sero'];
			$itm_height = $idata['itm_height'];
			$itm_weight = $idata['itm_weight'];
			$exp_date = $idata['exp_date'];
			$buy_date = $idata['buy_date'];
			$buy_price = $idata['buy_price'];
			$vendor = $idata['vendor'];
			$itm_pic_url = $idata['itm_pic_url'];


			$data = array(
				'route'	=> 'excel',

				'barcode' => $barcode,
				'sku' => $sku,
				'branch' => $branch,
				'itm_name' => $itm_name,
				'location' => $location,
				'itm_qty' => $itm_qty,
				'brand' => $brand,
				'volume' => $volume,
				'unit' => $unit,
				'itm_garo' => $itm_garo,
				'itm_sero' => $itm_sero,
				'itm_height' => $itm_height,
				'itm_weight' => $itm_weight,
				'exp_date' => $exp_date,
				'buy_date' => $buy_date,
				'buy_price' => $buy_price,
				'vendor' => $vendor,
				'itm_pic_url' => $itm_pic_url,

				'mnger_id' => $this->ci->tank_auth->get_username()
			);

			if (!is_null($res = $this->ci->inven_model->excel_update_inven_lists($data))) {
				$data['idx'] = $res['idx'];
				return $data;
			}


		return NULL;
	}










	// 구매의뢰(주문)내역 가져오기
	public function arr_req_list($arr=FALSE) 
	{

		//print_r($arr);

		$list = array('total_count'=>0, 'qry'=>array());

		if($arr) {
			$result = $this->ci->basic_model->arr_get_result($arr);
			$list['total_count'] = $result['total_count'];

			foreach ($result['qry'] as $i => $row) {

				$list['qry'][$i] = new stdClass();
				$list['qry'][$i]->num = ($result['total_count'] - $arr['limit']*($arr['page']-1) - $i);

				//print_r($row);

				$list['qry'][$i]->idx = $row->idx;
				$list['qry'][$i]->manager_id = $row->manager_id;
				$list['qry'][$i]->manager = $row->manager;
				$list['qry'][$i]->pr_mall = $row->pr_mall;
				$list['qry'][$i]->pr_order_num = $row->pr_order_num;
				$list['qry'][$i]->pr_order_id = $row->pr_order_id;
				$list['qry'][$i]->currency = $row->currency;

				$list['qry'][$i]->pr_buyer_id = $row->pr_buyer_id;
				$list['qry'][$i]->pr_buyer_email = $row->pr_buyer_email;
				$list['qry'][$i]->pr_buyer_name = $row->pr_buyer_name;

				$buyer_info = ($row->pr_buyer_id) ? '[ID] '.$row->pr_buyer_id : '';
				$buyer_info .= ($buyer_info != '') ? '<br />' : '';
				$buyer_info .= ($row->pr_buyer_email) ? '[Email] '.$row->pr_buyer_email : '';
				$buyer_info .= ($buyer_info != '' && $row->pr_buyer_email != '') ? '<br />' : '';
				$buyer_info .= ($row->pr_buyer_name) ? '[Name] '.$row->pr_buyer_name : '';
				$list['qry'][$i]->buyer_info = $buyer_info;

				$list['qry'][$i]->pr_datetime_org = $row->pr_datetime_org;
				$list['qry'][$i]->pr_datetime = $row->pr_datetime;

				$list['qry'][$i]->pr_subtotal = $row->pr_subtotal;
				$list['qry'][$i]->pr_shipping = $row->pr_shipping;
				$list['qry'][$i]->pr_taxes = $row->pr_taxes;
				$list['qry'][$i]->pr_discount = $row->pr_discount;
				$list['qry'][$i]->pr_total = $row->pr_total;

				$list['qry'][$i]->pr_status = $row->pr_status;
				$list['qry'][$i]->remark = $row->remark;
				$list['qry'][$i]->created= $row->created;
				$list['qry'][$i]->deleted = $row->deleted;

			}
		}

		return ( ! empty($list)) ? $list : false;
	}


}

/* End of file Inven_lib.php */
/* Location: ./application/libraries/Inven_lib.php */