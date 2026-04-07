<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Item_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();

		//$ci =& get_instance();
		//$this->board_config_name = 'board_config';		// board config
		//$this->board_group_name  = 'board_group';		// board group
		//$this->board_files_name  = 'board_files';		// board files

		// table
		$this->tbl_items = 'items';
		$this->tbl_item_category = 'item_category';
		$this->tbl_item_zzim = 'item_zzim';

		$this->username = $this->tank_auth->get_username();
	}


	// 작성 및 수정
	function form_save($data=array(),$idx=false)
	{
		if($this->tank_auth->is_logged_admin(FALSE)) {
			return FALSE;
		}

		if($idx) {
			// 업데이트
			$this->db->where('idx', $idx);
			if ($this->db->update($this->tbl_items, $data)) {
				$data['idx'] = $idx;
				return $data;
			}
		}
		else {
			// 신규
			if ($this->db->insert($this->tbl_items, $data)) {
				$idx = $this->db->insert_id();
				$data['idx'] = $idx;
				return $data;
			}
		}

		return NULL;
	}

}