<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Inven
 *
 * This model represents inven data. It operates the following tables:
 * - inven data,
 * - inven input
 * - inven output
 * - inven history
 *
 * @package	Inven_lib
 */
class Inven_model extends CI_Model
{
	private $table_nm_inven = 'erp_inven';			// 재고
	private $table_nm_pur_req = 'erp_pur_req';			// 재고
	private $table_nm_pur_item = 'erp_pur_req_item';			// 재고

	function __construct()
	{
		parent::__construct();
		$ci =& get_instance();
	}

	/** 2022-02-11 */
	function excel_upload_inven_lists($data)
	{
		if ($this->db->insert($this->table_nm_inven, $data)) {
			$idx = $this->db->insert_id();
			return array('idx' => $idx);
		}
		else {
			return NULL;
		}
	}
	/** 2022-02-11 */
	function excel_update_inven_lists($data)
	{
		$this->db->where('barcode', $data['barcode']);
		if ($this->db->update($this->table_nm_inven, $data)) {
			return array('barcode' => $data['barcode']);
		}
		return NULL;
	}





	/** 2022-02-16 */
	function excel_upload_pur_req($data)
	{
		if ($this->db->insert($this->table_nm_pur_req, $data)) {
			$idx = $this->db->insert_id();
			return array('idx' => $idx);
		}
		else {
			return NULL;
		}
	}



	/** 2022-02-16 */
	function excel_upload_pur_req_item($data)
	{
		if ($this->db->insert($this->table_nm_pur_item, $data)) {
			$idx = $this->db->insert_id();
			return array('idx' => $idx);
		}
		else {
			return NULL;
		}
	}

















}

/* End of file Inven.php */
/* Location: ./application/models/Inven.php */