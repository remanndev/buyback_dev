<?php
class Banner_model extends CI_Model {
	function __construct() {
		parent::__construct();
	}

	function list_result($sst, $sod, $sfl, $stx, $limit, $offset,$cate='all',$where_opt=FALSE) {
		$this->db->start_cache();
		if($where_opt) {
			$this->db->where($where_opt);
		}
		if ($stx) {
			switch ($sfl) {
				default :
					$this->db->like($sfl, $stx, 'both');
				break;
			}
		}
		if( ! $cate OR $cate != 'all') {
			$this->db->where('bn_category', $cate);
		}
		$this->db->stop_cache();

		$result['total_cnt'] = $this->db->count_all_results('mng_banner');

		$this->db->select('*');
		$this->db->order_by('bn_use', 'DESC');
		$this->db->order_by('bn_category', 'ASC');
		$this->db->order_by('bn_code', 'ASC');
		$this->db->order_by('bn_name', 'ASC');
		$this->db->order_by('bn_rank', 'ASC');

		if($sst && $sod)
			$this->db->order_by($sst, $sod);
		else
			$this->db->order_by("reg_datetime", "asc");

		$qry = $this->db->get('mng_banner', $limit, $offset);
		$result['qry'] = $qry->result_array();

		$this->db->flush_cache();

		return $result;
	}


	function list_result_code() {
		$this->db->start_cache();
		$this->db->stop_cache();

		$result_code['total_cnt'] = $this->db->count_all_results('mng_banner');

		$this->db->select('*');
		$this->db->order_by('bn_category', 'asc');
		$this->db->order_by('bn_name', 'asc');
		$this->db->order_by('bn_id', 'asc');
		$qry_code = $this->db->get('mng_banner');
		$result_code['qry'] = $qry_code->result_array();

		$this->db->flush_cache();

		return $result_code;
	}



	function get_banner($bn_id, $fields='*') {
		if (!$bn_id)
			return FALSE;

		return $this->db->select($fields)->get_where('mng_banner', array('bn_id' => $bn_id))->row_array();
	}



	/*
	function record($w='',$bn_id=FALSE) {
		$sql = array(
			'bn_name' => $this->input->post('bn_name'),
			'bn_image' => $this->input->post('bn_image'),
			'bn_memo' => $this->input->post('bn_memo'),
			'bn_use' => $this->input->post('bn_use'),
			'bn_type' => $this->input->post('bn_type'),
			'bn_sdate' => $this->input->post('sdate').' '.$this->input->post('stime_h').':'.$this->input->post('stime_i').':'.$this->input->post('stime_s'),
			'bn_edate' => $this->input->post('edate').' '.$this->input->post('etime_h').':'.$this->input->post('etime_i').':'.$this->input->post('etime_s'),
			'bn_width' => $this->input->post('bn_width'),
			'bn_height' => $this->input->post('bn_height'),
			'bn_x' => $this->input->post('bn_x'),
			'bn_y' => $this->input->post('bn_y')
		);

		if ($w == '') {
			$sql['bn_datetime'] = TIME_YMDHIS;
			$this->db->insert('mng_banner', $sql);
			return $this->db->insert_id();
		}
		else {
			if( ! $bn_id)
				$bn_id = $this->input->post('bn_id');
			$this->db->update('mng_banner', $sql, array('bn_id' => $bn_id));
			return $bn_id;
		}
	}

	function list_update($bn_ids, $bn_names, $bn_uses) {
		$batch = array();
		foreach ($bn_ids as $bn_id) {
			$batch[] = array(
				'bn_id' => $bn_id,
				'bn_name' => $bn_names[$bn_id],
				'bn_use' => (isset($bn_uses[$bn_id])) ? $bn_uses[$bn_id] : ''
			);
		}

		$this->db->update_batch('mng_banner', $batch, 'bn_id');
	}
	*/

	function delete($bn_ids) {
		$this->db->where_in('bn_id', $bn_ids);
		$this->db->delete('mng_banner');
	}




	// 배너 등록
	function insert($bn_image='') {

		if ($this->tank_auth->is_logged_in()):
			$user_id = $this->tank_auth->get_user_id();
		else :
			alert("로그인 후 이용해주세요.", '/');
			exit;
		endif;

		$sql = array(
			'bn_name' => $this->input->post('bn_name'),
			'bn_category' => $this->input->post('bn_category'),
			'bn_code' => $this->input->post('bn_code'),
			'bn_rank' => $this->input->post('bn_rank'),
			'bn_width' => $this->input->post('bn_width'),
			'bn_height' => $this->input->post('bn_height'),
			'bn_type' => $this->input->post('bn_type'),
			'bn_image' => $bn_image,
			'bn_image_url' => $this->input->post('bn_image_url'),
			'bn_link' => $this->input->post('bn_link'),
			'bn_memo_ttl' => $this->input->post('bn_memo_ttl'),
			'bn_memo' => $this->input->post('bn_memo'),
			'bn_target' => $this->input->post('bn_target'),
			'bn_sdate' => $this->input->post('bn_sdate'),
			'bn_edate' => $this->input->post('bn_edate'),
			'bn_use' => $this->input->post('bn_use'),
			'reg_datetime' => TIME_YMDHIS,
			'reg_ip' => $this->input->server('REMOTE_ADDR'),
			'mb_id_reg' => $user_id
		);
		$this->db->insert('mng_banner', $sql);
		return $this->db->insert_id();
	}


	// 배너 수정
	function update($bn_id, $bn_image='') {
		/*
		if ( ! IS_MEMBER ):
			alert("로그인 후 이용해주세요.", '/');
			exit;
		else:
			$mb = unserialize(MEMBER);
		endif;
		*/

		if ($this->tank_auth->is_logged_in()):
			$user_id = $this->tank_auth->get_user_id();
		else :
			alert("로그인 후 이용해주세요.", '/');
			exit;
		endif;


		$sql = array(
			'bn_name' => $this->input->post('bn_name'),
			'bn_category' => $this->input->post('bn_category'),
			'bn_code' => $this->input->post('bn_code'),
			'bn_rank' => $this->input->post('bn_rank'),
			'bn_width' => $this->input->post('bn_width'),
			'bn_height' => $this->input->post('bn_height'),
			'bn_type' => $this->input->post('bn_type'),
			'bn_image' => $bn_image,
			'bn_image_url' => $this->input->post('bn_image_url'),
			'bn_link' => $this->input->post('bn_link'),
			'bn_memo_ttl' => $this->input->post('bn_memo_ttl'),
			'bn_memo' => $this->input->post('bn_memo'),
			'bn_target' => $this->input->post('bn_target'),
			'bn_sdate' => $this->input->post('bn_sdate'),
			'bn_edate' => $this->input->post('bn_edate'),
			'bn_use' => $this->input->post('bn_use'),
			'mb_id_update' =>$user_id
		);
		$ok = $this->db->update('mng_banner', $sql, array('bn_id' => $bn_id));
		if($ok)
			return $bn_id;
		else
			return false;
	}


	// 배너 위치코드 grouping 해서 가져오기
	function get_bn_code() {

						$this->db->start_cache();
						$this->db->group_by('bn_category, bn_code, bn_name');
						$this->db->stop_cache();

						$total_cnt = $this->db->get('mng_banner')->num_rows();
						$result['total_cnt'] = $total_cnt;

						$this->db->select('bn_category, bn_code, bn_name');
						$this->db->order_by('bn_code', 'asc');
						$qry = $this->db->get('mng_banner');
						$result['qry'] = $qry->result_array();
						$this->db->flush_cache();

						return $result;

	}


}

/* End of file admin_banner_model.php */
/* Location: ./application/models/admin_banner_model.php */
