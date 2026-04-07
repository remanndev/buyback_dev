<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Landing_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();

		$this->tbl_landing = 'landing';
		$this->tbl_landing_agree = 'landing_agree';


		/*
		*/
		$this->tbl_rsv = 'rsv';
		$this->tbl_rsv_stats = 'rsv_stats';
		$this->tbl_winner_rsv = 'winner_rsv';
		$this->tbl_winner_rsv_stats = 'winner_rsv_stats';
	}



	// 랜딩 등록
	function write($data=NULL)
	{
		// 새 글 작성
		if ($this->db->insert($this->tbl_landing, $data)) {
			$idx = $this->db->insert_id();
			$data['idx'] = $idx;
		}
		return $data;
	}


	// 랜딩 삭제 처리(업데이트)
	function request_del($idx=FALSE) 
	{
		$this->db->where(array('idx'=>$idx));
		return $this->db->update($this->tbl_landing, array('deleted' => TIME_YMDHIS));
	}


	// 개인정보수집동의
	function agree_write($idx=FALSE,$data=NULL)
	{

		// 게시글 수정
		if($idx && $data) {
			$this->db->where(array('idx'=>$idx));
			if ($this->db->update($this->tbl_landing_agree, $data)) {
				$data['idx'] = $idx;
				//return $data;
			}
		}
		// 새 글 작성
		else {
			if ($this->db->insert($this->tbl_landing_agree, $data)) {
				$idx = $this->db->insert_id();
				$data['idx'] = $idx;
				//return $data;
			}
		}

		return $data;
		//return NULL;
	}




    public function tooManyInWindow(string $ip, int $minutes = 10, int $threshold = 5, ?int $bo_idx = null): bool
    {
        $this->db->from('landing')
                 ->where('ip', $ip)
                 ->where('created >=', date('Y-m-d H:i:s', time() - $minutes * 60));
        if ($bo_idx !== null) {
            $this->db->where('idx', $bo_idx);
        }
        return $this->db->count_all_results() >= $threshold;
    }














	// 예약 등록
	function rsv_write($data_rsv=NULL,$data_rsv_stats=NULL)
	{
		// 새 글 작성
		if ($this->db->insert($this->tbl_rsv, $data_rsv)) {
			$idx = $this->db->insert_id();
			$data['idx'] = $idx;


			// 예약 현황 업데이트
			$exist_rsv_part_num = $this->basic_model->get_common_count($this->tbl_rsv_stats, array('rsv_date'=>$data_rsv['rsv_date'], 'rsv_time'=>$data_rsv['rsv_time'], 'rsv_part'=>$data_rsv['rsv_part']));
			if($exist_rsv_part_num > 0) {
				$this->db->where(array('rsv_date'=>$data_rsv['rsv_date'], 'rsv_time'=>$data_rsv['rsv_time'], 'rsv_part'=>$data_rsv['rsv_part']));
				$this->db->update($this->tbl_rsv_stats, array('rsv_part_num' => $data_rsv_stats['rsv_part_num']));
			}
			else {
				$this->db->insert($this->tbl_rsv_stats, $data_rsv_stats);
			}

		}
		return $data;
	}

	// 예약 내역 삭제 처리(업데이트)
	function reserve_del($idx=FALSE) 
	{
		$this->db->where(array('idx'=>$idx));
		$this->db->update($this->tbl_rsv, array('deleted' => TIME_YMDHIS));

		// 삭제처리 한 예약시간대의 예약건 업데이트
		$arr_where = array(
				'sql_select'     => '*',
				'sql_from'       => $this->tbl_rsv,
				'sql_where'      => array('idx'=>$idx)
		);
		$row = $this->basic_model->arr_get_row($arr_where);

		$rsv_part_num = $this->basic_model->get_common_count($this->tbl_rsv, array('rsv_date'=>$row->rsv_date, 'rsv_time'=>$row->rsv_time, 'rsv_part'=>$row->rsv_part, 'deleted'=>NULL));
		$this->db->where(array('rsv_date'=>$row->rsv_date, 'rsv_time'=>$row->rsv_time, 'rsv_part'=>$row->rsv_part));
		$this->db->update($this->tbl_rsv_stats, array('rsv_part_num' => $rsv_part_num));
		
		return $rsv_part_num;
	}

	// 예약 내역 삭제 처리(업데이트)
	function reserve_del_winner($idx=FALSE) 
	{
		$this->db->where(array('idx'=>$idx));
		$this->db->update($this->tbl_winner_rsv, array('deleted' => TIME_YMDHIS));

		// 삭제처리 한 예약시간대의 예약건 업데이트
		$arr_where = array(
				'sql_select'     => '*',
				'sql_from'       => $this->tbl_winner_rsv,
				'sql_where'      => array('idx'=>$idx)
		);
		$row = $this->basic_model->arr_get_row($arr_where);

		$rsv_part_num = $this->basic_model->get_common_count($this->tbl_winner_rsv, array('rsv_date'=>$row->rsv_date, 'rsv_time'=>$row->rsv_time, 'rsv_part'=>$row->rsv_part, 'deleted'=>NULL));
		$this->db->where(array('rsv_date'=>$row->rsv_date, 'rsv_time'=>$row->rsv_time, 'rsv_part'=>$row->rsv_part));
		$this->db->update($this->tbl_rsv_stats, array('rsv_part_num' => $rsv_part_num));
		
		return $rsv_part_num;
	}

	// 당첨자 전용 예약 등록
	function winner_rsv_write($data_rsv=NULL,$data_rsv_stats=NULL)
	{
		// 새 글 작성
		if ($this->db->insert($this->tbl_winner_rsv, $data_rsv)) {
			$idx = $this->db->insert_id();
			$data['idx'] = $idx;


			// 예약 현황 업데이트
			$exist_rsv_part_num = $this->basic_model->get_common_count($this->tbl_winner_rsv_stats, array('rsv_date'=>$data_rsv['rsv_date'], 'rsv_time'=>$data_rsv['rsv_time'], 'rsv_part'=>$data_rsv['rsv_part']));
			if($exist_rsv_part_num > 0) {
				$this->db->where(array('rsv_date'=>$data_rsv['rsv_date'], 'rsv_time'=>$data_rsv['rsv_time'], 'rsv_part'=>$data_rsv['rsv_part']));
				$this->db->update($this->tbl_winner_rsv_stats, array('rsv_part_num' => $data_rsv_stats['rsv_part_num']));
			}
			else {
				$this->db->insert($this->tbl_winner_rsv_stats, $data_rsv_stats);
			}

		}
		return $data;
	}

	// 당첨자 전용 예약 내역 삭제 처리(업데이트)
	function winner_reserve_del($idx=FALSE) 
	{
		$this->db->where(array('idx'=>$idx));
		$this->db->update($this->tbl_winner_rsv, array('deleted' => TIME_YMDHIS));

		// 삭제처리 한 예약시간대의 예약건 업데이트
		$arr_where = array(
				'sql_select'     => '*',
				'sql_from'       => $this->tbl_winner_rsv,
				'sql_where'      => array('idx'=>$idx)
		);
		$row = $this->basic_model->arr_get_row($arr_where);

		$rsv_part_num = $this->basic_model->get_common_count($this->tbl_winner_rsv, array('rsv_date'=>$row->rsv_date, 'rsv_time'=>$row->rsv_time, 'rsv_part'=>$row->rsv_part, 'deleted'=>NULL));
		$this->db->where(array('rsv_date'=>$row->rsv_date, 'rsv_time'=>$row->rsv_time, 'rsv_part'=>$row->rsv_part));
		$this->db->update($this->tbl_winner_rsv_stats, array('rsv_part_num' => $rsv_part_num));
		
		return $rsv_part_num;
	}



	// 당첨자 전용 예약 내역 삭제 처리(업데이트)
	function winner_del($idx=FALSE) 
	{
		$this->db->where(array('idx'=>$idx));
		return $this->db->update('winner_list', array('deleted' => TIME_YMDHIS));
	}





	/**
	 * Delete user record
	 *
	 * @param	int
	 * @return	bool
	 */
	function delete_excel_winner()
	{
		// 데이터 비우기
		return $this->db->truncate('winner_list');
	}



	/** 2020-11-06 */
	function excel_winner_by_admin($data=FALSE)
	{

		if( $this->is_winner_available($data['phone']) ) {
			if ($this->db->insert('winner_list', $data)) {
				$user_id = $this->db->insert_id();
				return array('user_id' => $user_id);
			}
			else {
				return NULL;
			}
		}
		return NULL;
	}


	/**
	 * Check if username available for registering
	 *
	 * @param	string
	 * @return	bool
	 */
	function is_winner_available($phone)
	{
		$this->db->select('1', FALSE);
		$this->db->where('phone', trim($username));

		$query = $this->db->get('winner_list');
		return $query->num_rows() == 0;
	}



}