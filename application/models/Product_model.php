<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Product_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();

		//$ci =& get_instance();
		//$this->board_config_name = 'board_config';		// board config
		//$this->board_group_name  = 'board_group';		// board group
		//$this->board_files_name  = 'board_files';		// board files

		$this->tbl_products = 'products';   // products
	}


	// 작성 및 수정
	function form_product($idx,$data)
	{
		if($this->tank_auth->is_logged_admin(FALSE)) {
			return FALSE;
		}

		if($idx) {
			$this->db->where('idx', $idx);
			if ($this->db->update($this->tbl_products, $data)) {
				$data['idx'] = $idx;
				return $data;
			}
		}
		else {
			if ($this->db->insert($this->tbl_products, $data)) {
				$idx = $this->db->insert_id();
				$data['idx'] = $idx;
				return $data;
			}
		}

		return NULL;
	}

}