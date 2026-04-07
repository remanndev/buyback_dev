<?php
class Calendar_model extends CI_Model {
	function __construct() {
		parent::__construct();
	}


	// 일정 등록
	function write() {

		$this->load->library('tank_auth');


		// 로그인 안했다면 로그인 페이지로..
		if (!$this->tank_auth->is_admin()) {
			alert("로그인 되어 있지 않습니다.", BASEURL.'/admin');
		}
		else {
			//$mb = unserialize(MEMBER);
			//echo $this->username;
			//$this->user = $this->tank_auth->get_userinfo($this->username);
			$this->user_idx = $this->tank_auth->get_user_id();
			$this->username = $this->tank_auth->get_username();
			$this->nickname = $this->tank_auth->get_nickname();
			//echo $this->user_idx;
			//echo $this->username;
			//echo $this->nickname;
		}


		$w = $this->input->post('w');
		$cal_no = $this->input->post('cal_no');
		$category = $this->input->post('category');

		$cal_date = $this->input->post('cal_date');
		$cal_date_end = $this->input->post('cal_date_end');
		$cal_title = $this->input->post('cal_title');
		$cal_url = $this->input->post('cal_url');
		$cal_content = $this->input->post('cal_content');

		$cal_date_y = $cal_date_m = $cal_date_d = false;
		if($cal_date) {
			$arr_date = explode('-',$cal_date);
			$cal_date_y = $arr_date[0];
			$cal_date_m = $arr_date[1];
			$cal_date_d = $arr_date[2];
		}

		$cal_date_end_y = $cal_date_end_m = $cal_date_end_d = false;
		if($cal_date_end) {
			$arr_date = explode('-',$cal_date_end);
			$cal_date_end_y = $arr_date[0];
			$cal_date_end_m = $arr_date[1];
			$cal_date_end_d = $arr_date[2];
		}

		if($w === 'u') {
			if( ! $cal_no) {
				return false;
				exit;
			}
			$sql = array(
				'cal_date' => $cal_date,
				'cal_date_y' => $cal_date_y,
				'cal_date_m' => $cal_date_m,
				'cal_date_d' => $cal_date_d,

				'cal_date_end' => $cal_date_end,
				'cal_date_end_y' => $cal_date_end_y,
				'cal_date_end_m' => $cal_date_end_m,
				'cal_date_end_d' => $cal_date_end_d,

				'cal_title' => $cal_title,
				'cal_url' => $cal_url,
				'cal_content' => $cal_content
			);
			$this->db->update('mng_calendar', $sql, array('cal_no' => $cal_no));
			return $cal_no;
		}
		else {
			$sql = array(
				//'access_host' => HTTP_HOST,
				'cal_category' => $category,
				'mb_idx' => $this->user_idx,
				'mb_name' => $this->nickname,
				'cal_date' => $cal_date,
				'cal_date_y' => $cal_date_y,
				'cal_date_m' => $cal_date_m,
				'cal_date_d' => $cal_date_d,
				'cal_date_end' => $cal_date_end,
				'cal_date_end_y' => $cal_date_end_y,
				'cal_date_end_m' => $cal_date_end_m,
				'cal_date_end_d' => $cal_date_end_d,

				'cal_title' => $cal_title,
				'cal_url' => $cal_url,
				'cal_content' => $cal_content,
				'reg_datetime' => TIME_YMDHIS,
				'reg_ip' => REMOTE_ADDR
			);

			$this->db->insert('mng_calendar', $sql);
			return $this->db->insert_id();
		}

	}


	// 일정 삭제
	function del($category, $cal_no) {
			if( !$category  OR  ! $cal_no) {
				return false;
				exit;
			}
			$sql = array(
				'del_datetime' => TIME_YMDHIS
			);
			$del_ok = $this->db->update('mng_calendar', $sql, array('cal_no' => $cal_no, 'cal_category' => $category));
			return $del_ok;
	}



	// 해당일자의 상세일정 불러오기
	function view($category, $cal_no, $fields='*') {
		if($cal_no) {
			$this->db->select($fields);
			$this->db->where('cal_no', $cal_no);
			//$this->db->where('access_host', HTTP_HOST);
			$query = $this->db->get('mng_calendar');
			return $query->row_array();
		}
		else
			return false;
	}


	// 최신 일정 목록
	function latest_cal_lists($limit=4) {

			$category = 'sg1365';

			$this->db->start_cache();
			$where_option = "`del_datetime` = '' AND `cal_category` = '".$category."' AND `cal_date_end` >= '".date('Y-m-d')."'";
			$this->db->where($where_option);
			$this->db->stop_cache();
			$result['total_cnt'] = $this->db->count_all_results('mng_calendar');

			$this->db->select('*');
			$this->db->order_by('cal_date', 'asc');
			$this->db->limit($limit);
			$qry = $this->db->get('mng_calendar');
			$result['qry'] = $qry->result_array();
			$this->db->flush_cache();

			//echo $this->db->last_query();

			return $result;
	}


	// 해당 월의 일정 리스트 불러오기
	function view_month_lists($category, $year=FALSE,$month=FALSE, $fields='*') {

		if($year && $month) {

			$this->db->start_cache();
			/*
			$where_option = array(
				//'access_host' => HTTP_HOST,
				'del_datetime' => '',
				'cal_category' => $category,
				'cal_date_y' => $year,
				'cal_date_m' => $month
			);
			*/

			$where_option = "`del_datetime` = '' AND `cal_category` = '".$category."' AND ((`cal_date_y` = '".$year."' AND `cal_date_m` = '".$month."') OR (`cal_date_end_y` = '".$year."' AND `cal_date_end_m` = '".$month."'))";

			$this->db->where($where_option);
			$this->db->stop_cache();
			$result['total_cnt'] = $this->db->count_all_results('mng_calendar');

			$this->db->select('*');
			$this->db->order_by('cal_date', 'asc');
			$qry = $this->db->get('mng_calendar');
			$result['qry'] = $qry->result_array();
			$this->db->flush_cache();

			//echo $this->db->last_query();

			return $result;
		}
		else
			return false;

	}


	// 오늘 일정 리스트 불러오기
	function view_today_lists($category, $fields='*') {

		$today = date('Y-m-d',TIME_STAMP);

		$this->db->start_cache();
		$where_option = array(
			//'access_host' => HTTP_HOST,
			'del_datetime' => '',
			'cal_category' => $category,
			'cal_date' => $today
		);
		$this->db->where($where_option);
		$this->db->stop_cache();
		$result['total_cnt'] = $this->db->count_all_results('mng_calendar');

		$this->db->select('*');
		$qry = $this->db->get('mng_calendar');
		$result['qry'] = $qry->result_array();
		$this->db->flush_cache();

		return $result;

	}

	// 선택 일자
	function view_selected_date_lists($category, $selected_date=FALSE, $fields='*') {

		//$today = date('Y-m-d',TIME_STAMP);

		if( ! $selected_date )
			$today = date('Y-m-d',TIME_STAMP);
		else
			$today = $selected_date;


		$this->db->start_cache();
		$where_option = array(
			//'access_host' => HTTP_HOST,
			'del_datetime' => '',
			'cal_category' => $category,
			//'cal_date' => $selected_date,
			'cal_date <=' => $selected_date,
			'cal_date_end >=' => $selected_date

		);
		$this->db->where($where_option);
		$this->db->stop_cache();
		$result['total_cnt'] = $this->db->count_all_results('mng_calendar');

		$this->db->select('*');
		$qry = $this->db->get('mng_calendar');
		$result['qry'] = $qry->result_array();
		$this->db->flush_cache();

		return $result;

	}



	function view_date_lists($sql, $fields='*') {

			$this->db->start_cache();
			$this->db->where($sql);
			//$this->db->where('access_host', HTTP_HOST);
			$this->db->where('del_datetime', '');
			$this->db->stop_cache();
			$result['total_cnt'] = $this->db->count_all_results('mng_calendar');

			$this->db->select('*');
			$this->db->order_by('cal_date', 'asc');
			$qry = $this->db->get('mng_calendar');
			$result['qry'] = $qry->result_array();
			$this->db->flush_cache();

			return $result;

	}


	function view_date_detail($cal_no, $fields='*') {

		if($cal_no) {
			$this->db->select($fields);
			$this->db->where('cal_no', $cal_no);
			//$this->db->where('access_host', HTTP_HOST);
			$this->db->where('del_datetime', '');
			$query = $this->db->get('mng_calendar');
			return $query->row_array();
		}
		else
			return false;

	}

}
/* End of file calendar_model.php */
/* Location: ./application/models/adm/calendar_model.php */