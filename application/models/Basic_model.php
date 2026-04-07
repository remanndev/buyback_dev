<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Basic_model extends CI_Model
{

	function __construct()
	{
		parent::__construct();

		$ci =& get_instance();
	}






	// [2021-04-03]
	function get_total($arr)
	{

		if(! isset($arr['sql_from'])) {
			return false;
		}

		$this->db->start_cache();

		$this->db->start_cache();
		if (! empty($arr['sql_where']))
		{
			$this->db->where($arr['sql_where']);
		}

		// Like
		if ( ! empty($arr['like_match']))
		{
			// 콤마로 연결된 여러개의 필드를 하나의 검색으로 검색할 때
			$arr_likefld = explode(',',$arr['like_field']);
			if(count($arr_likefld) > 1) {
					foreach($arr_likefld as $key => $val) {
						if($key < 1) {
							$this->db->like($val, $arr['like_match'], $arr['like_side']);
						} else {
							$this->db->or_like($val, $arr['like_match'], $arr['like_side']);
						}
					}
			}
			// 그냥 하나의 필드를 하나의 검색어로 검색할 때
			else {
				switch ($arr['like_field'])
				{
					default :
						$this->db->like($arr['like_field'], $arr['like_match'], $arr['like_side']);
						break;
				}
			}
		}

		$this->db->stop_cache();

		//$total_count = $this->db->count_all_results($arr['sql_from']);
		$total_count = $this->db->count_all_results($arr['sql_from']);

		$this->db->flush_cache();

		return $total_count;
	}



	/**
	 * - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	 * Get common result, row
	 * - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	 * $get_type : result, result_array
	 * - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	*/

	// [2020-04-01]
	function arr_get_result($arr)
	{

		if(! isset($arr['sql_from'])) {
			return false;
		}

		$this->db->start_cache();

		if (! empty($arr['sql_where']))
		{
			$this->db->where($arr['sql_where']);
		}

		//echo $arr['sql_from'] . "<<<<br />";
		/*
		if('bbs_event_list' == $arr['sql_from']) {
			print_r($arr['sql_where']);
			echo '<hr />';
		}
		*/

		// Like
		if ( ! empty($arr['like_match']))
		{
			// 콤마로 연결된 여러개의 필드를 하나의 검색으로 검색할 때
			$arr_likefld = explode(',',$arr['like_field']);
			if(count($arr_likefld) > 1) {
					foreach($arr_likefld as $key => $val) {
						if($key < 1) {
							$this->db->like($val, $arr['like_match'], $arr['like_side']);
						} else {
							$this->db->or_like($val, $arr['like_match'], $arr['like_side']);
						}
					}
			}
			// 그냥 하나의 필드를 하나의 검색어로 검색할 때
			else {
				switch ($arr['like_field'])
				{
					default :
						$this->db->like($arr['like_field'], $arr['like_match'], $arr['like_side']);
						break;
				}
			}
		}

		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		// join
		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		if (! empty($arr['sql_join_tbl']) && ! empty($arr['sql_join_on']))
		{
			$sql_join_option = isset($arr['sql_join_option']) ? $arr['sql_join_option'] : '';
			if('' != $sql_join_option) {
				$this->db->join($arr['sql_join_tbl'], $arr['sql_join_on'], $arr['sql_join_option']);
			}
			else {
				$this->db->join($arr['sql_join_tbl'], $arr['sql_join_on']);
			}
		}

		$this->db->stop_cache();


		$result['total_count'] = $this->db->count_all_results($arr['sql_from']);

		// Group by
		if (! empty($arr['sql_group_by']))
		{
			$this->db->group_by($arr['sql_group_by']);
		}
		// Order by
		if (! empty($arr['sql_order_by']))
		{
			$this->db->order_by($arr['sql_order_by']);
		}
		// Limit
		if (! empty($arr['limit']))
		{
			if (! empty($arr['offset'])) {
				$this->db->limit($arr['limit'], $arr['offset']);
			}
			else {
				$this->db->limit($arr['limit']);
			}
		}
		// Set directly submitted SELECT and WHERE clauses.
		if (! empty($arr['sql_select']))
		{
			$this->db->select($arr['sql_select']);
		}







		// Result query
		$query = $this->db->get($arr['sql_from']);
		$result['qry'] = $query->result();
		$result['qry_count'] = $query->num_rows();

		$this->db->flush_cache();

		return $result;
	}



	// [2020-04-01]
	function arr_get_row($arr)
	{

		if(! isset($arr['sql_from'])) {
			return false;
		}

		$this->db->start_cache();
		if (! empty($arr['sql_where']))
		{
			$this->db->where($arr['sql_where']);
		}
		$this->db->stop_cache();

		// Group by
		if (! empty($arr['sql_group_by']))
		{
			$this->db->group_by($arr['sql_group_by']);
		}
		// Order by
		if (! empty($arr['sql_order_by']))
		{
			$this->db->order_by($arr['sql_order_by']);
		}
		// Limit
		if (! empty($arr['limit']))
		{
			if (! empty($arr['offset'])) {
				$this->db->limit($arr['limit'], $arr['offset']);
			}
			else {
				$this->db->limit($arr['limit']);
			}
		}
		// Set directly submitted SELECT and WHERE clauses.
		if (! empty($arr['sql_select']))
		{
			$this->db->select($arr['sql_select']);
		}

		// join
		if (! empty($arr['sql_join_tbl']) && ! empty($arr['sql_join_on']))
		{
			$sql_join_option = isset($arr['sql_join_option']) ? $arr['sql_join_option'] : '';
			if('' != $sql_join_option) {
				$this->db->join($arr['sql_join_tbl'], $arr['sql_join_on'], $arr['sql_join_option']);
			}
			else {
				$this->db->join($arr['sql_join_tbl'], $arr['sql_join_on']);
			}
		}





		// Row query
		$row = $this->db->get($arr['sql_from'])->row();
		$this->db->flush_cache();

		return $row;
	}




	/**
	 * - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	 * Get common count
	 * - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	*/
	function get_common_count($sql_from = FALSE, $sql_where = FALSE) {
		if(! $sql_from OR ! $sql_where){
			return false;
		}
		if( is_array($sql_where) )
			$this->db->where($sql_where);
		else
			$this->db->where($sql_where, NULL, FALSE);

		return $this->db->count_all_results($sql_from);
    }

	function get_common_count_join($sql_from = FALSE, $sql_where = FALSE, $sql_join_tbl=FALSE, $sql_join_on=FALSE, $sql_join_option=FALSE) {
		if(! $sql_from OR ! $sql_where){
			return false;
		}
		if( is_array($sql_where) )
			$this->db->where($sql_where);
		else
			$this->db->where($sql_where, NULL, FALSE);

		// join
		if (! empty($sql_join_tbl) && ! empty($sql_join_on))
		{
			$sql_join_option = isset($sql_join_option) ? $sql_join_option : '';
			if('' != $sql_join_option) {
				$this->db->join($sql_join_tbl, $sql_join_on, $sql_join_option);
			}
			else {
				$this->db->join($sql_join_tbl, $sql_join_on);
			}
		}

		return $this->db->count_all_results($sql_from);
    }



	/**
	 * - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	 * 최대 order 숫자를 얻는다.
	 * - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	*/
	function get_max($table,$where_arr,$order='order') {

		// 가장 큰 번호를 얻자
		$this->db->select_max($order, 'max_order');
		$this->db->where($where_arr);
		$row = $this->db->get($table)->row();

		$max_order = isset($row->max_order) ? $row->max_order : 0;

		return $max_order;
	}




	/**
	 * - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	 * 배너 리스트 가져오기
	 * - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	*/
	function get_banner_list($bn_code=FALSE, $limit='10') {

		if (!$bn_code)
			return FALSE;

		$this->db->start_cache();
		$this->db->where('bn_code', $bn_code);
		$this->db->where('bn_use', '1');

		//$this->db->where('bn_sdate <=', date('Y-m-d'));
		//$this->db->where('bn_edate >=', date('Y-m-d'));

		$this->db->stop_cache();

		$result['total_count'] = $this->db->count_all_results('mng_banner');

		$this->db->select('*');
		//$this->db->order_by('bn_category', 'asc');
		//$this->db->order_by('bn_code', 'asc');
		$this->db->order_by('bn_rank', 'asc');
		$this->db->order_by('bn_id', 'asc');
		$this->db->limit($limit);
		$qry = $this->db->get('mng_banner');
		$result['qry'] = $qry->result_array();

		$this->db->flush_cache();

		//return $result;

		$lists = array();
		//$lists = FALSE;
		foreach ($result['qry'] as $i => $row) {

			$lists[$i] = new stdClass();

			$lists[$i]->bn_id = $row['bn_id'];
			$lists[$i]->bn_name = $row['bn_name'];
			$lists[$i]->bn_category = $row['bn_category'];
			$lists[$i]->bn_code = $row['bn_code'];
			$lists[$i]->bn_rank = $row['bn_rank'];
			$lists[$i]->bn_width = $row['bn_width'];
			$lists[$i]->bn_height = $row['bn_height'];
			$lists[$i]->bn_type = $row['bn_type'];
			$lists[$i]->bn_image = $row['bn_image'];
			$lists[$i]->bn_image_url = $row['bn_image_url'];
			$lists[$i]->bn_link = $row['bn_link'];
			$lists[$i]->bn_target = $row['bn_target'];
			$lists[$i]->bn_memo_ttl = $row['bn_memo_ttl'];
			$lists[$i]->bn_memo = $row['bn_memo'];
			//$lists[$i]->bn_sdate = $row['bn_sdate'];
			//$lists[$i]->bn_edate = $row['bn_edate'];
			$lists[$i]->reg_datetime = $row['reg_datetime'];

			if( $row['bn_type'] === 'image' ) :
				if($row['bn_image_url']) :
					$banner_src = $row['bn_image_url'];
				elseif($row['bn_image']) :
					$banner_src = DATA_DIR."/banner/image/".$row['bn_image'];
				endif;
			endif;
			$lists[$i]->banner_src = $banner_src;
			//echo $banner_src."<<<br>";
		}

		return $lists;
	}


	// 링크 걸린 배너 하나 가져오기
	function get_banner($bn_code, $bn_rank=FALSE, $fields='*') {

			$CI =& get_instance();
			$CI->db->where('bn_code', $bn_code);
			if($bn_rank)
				$CI->db->where('bn_rank', $bn_rank);

			$CI->db->select($fields);
			$CI->db->order_by("bn_rank", "asc");
			$CI->db->order_by("bn_id", "asc");
			$CI->db->limit(1);
			$qry = $CI->db->get('mng_banner');
			$total = $qry->num_rows();

			$banner = FALSE;
			if($total > 0) {

					$row = $qry->row_array();

					if( $row['bn_type'] == 'image' ) {

							if($row['bn_image_url']) {
								$image_src = $row['bn_image_url'];
							}
							elseif($row['bn_image']) {
								$image_src = DATA_DIR."/banner/images/".$row['bn_image'];
							}

							$img_style = " style='";
							if($row['bn_width'] > 0) {
								$img_style .= "max-width:".$row['bn_width']."px; ";
							} else {
								$img_style .= "width:100%;";
							}
							/*
							if($row['bn_height'] > 0) {
								$img_style .= "height:".$row['bn_height']."px; ";
							}
							*/
							$img_style .= "' ";

							$img_a_link_begin = "";
							$img_a_link_end = "";
							if($row['bn_link']) {
								$img_a_link_begin = "<a href='".$row['bn_link']."' ";
								if($row['bn_target']) {
									$img_a_link_begin .= " target='".$row['bn_target']."' ";
								}
								$img_a_link_begin .= ">";
								$img_a_link_end = "</a>";
							}

							$banner = $img_a_link_begin."<img src='".$image_src."' ".$img_style." alt='banner' />".$img_a_link_end;

					}
					elseif( $row['bn_type'] == 'flash' ) {
					}

			}
			// 배너 출력
			return $banner;
	}


	//  배너 이미지 소스 하나 가져오기
	function get_banner_src($bn_code, $bn_rank=FALSE, $fields='*') {

		$CI =& get_instance();
		$CI->db->where('bn_code', $bn_code);
		if($bn_rank)
			$CI->db->where('bn_rank', $bn_rank);

		$CI->db->select($fields);
		$CI->db->order_by("bn_rank", "asc");
		$CI->db->order_by("bn_id", "asc");
		$CI->db->limit(1);
		$qry = $CI->db->get('mng_banner');
		$total = $qry->num_rows();

		$banner_src = FALSE;
		if($total > 0) {

				$row = $qry->row_array();

				if( $row['bn_type'] == 'image' ) {

					if($row['bn_image_url']) {
						$banner_src = $row['bn_image_url'];
					}
					elseif($row['bn_image']) {
						$banner_src = DATA_DIR."/banner/images/".$row['bn_image'];
					}

				}
				elseif( $row['bn_type'] == 'flash' ) {
				}

		}
		// 배너 출력
		return $banner_src;
	}






    /** --------------------------------------------------------------------------------------------------------------
     | 메뉴 정보 가져오기
     | ----------------------------------------------------------------------------------------------------------------
     */
	function get_menu_result($fields='*', $where_option=FALSE, $order_by=FALSE, $depth=FALSE) {

		$this->db->start_cache();
		if($where_option):
			$this->db->where($where_option);
		endif;
		$this->db->where('del_datetime','');
		if($depth)
			$this->db->where('menu_depth',$depth);
		$this->db->stop_cache();

		$result['total_count'] = $this->db->count_all_results('menu');
		$this->db->select($fields);
		if($order_by){
			$this->db->order_by($order_by);
		}
		$this->db->order_by('menu_order desc');
		$result['qry'] = $this->db->get('menu')->result_array();
		$this->db->flush_cache();

		$lists = array();
		foreach ($result['qry'] as $i => $row) {
			$lists[$i]->menu_id = $row['menu_id'];
			$lists[$i]->menu_title = $row['menu_title'];
			$lists[$i]->menu_href = $row['menu_href'];
			$lists[$i]->menu_parent_id = $row['menu_parent_id'];
			$lists[$i]->menu_depth = $row['menu_depth'];
			$lists[$i]->menu_order = $row['menu_order'];
		}
		$result['lists'] = $lists;

		return $result;
	}











    /** --------------------------------------------------------------------------------------------------------------
     | Latest board data
     | ----------------------------------------------------------------------------------------------------------------
     */

    function write_gallery($bo_code=FALSE, $limit=5, $cut=50, $upload_type='form', $img_w='275', $img_h='190') {

		$bo_table = 'bbs_'. $bo_code;

        $this->db->cache_on();
		$this->db->where(array('wr_option !=' => 'secret'));
		$this->db->select('wr_idx, wr_comment, ca_code, wr_subject, wr_option, wr_datetime, addfld_1, addfld_2, addfld_3, addfld_4, addfld_5');
		$result = $this->db->order_by('wr_datetime', 'desc')->get($bo_table, $limit)->result_array();
        $this->db->cache_off();

		/*
		$len = strlen($bo_table);
		$len = ($len < 0) ? 0 : $len;
		$bo_code = substr($bo_table, 4, $len);
		*/



        $list = array();
		foreach($result as $i => $row) {
            $list[$i] = new stdClass(); // 2013-10-02
			$list[$i]->href = base_url().'board/'.$bo_code.'/detail/'.$row['wr_idx'].($row['ca_code'] ? '?sca='.$row['ca_code'] : '');
			$list[$i]->subject = cut_str(get_text($row['wr_subject']), $cut);
			$list[$i]->comt_cnt = ($row['wr_comment']) ? '('.$row['wr_comment'].')' : '';
			$list[$i]->write_date = substr($row['wr_datetime'],0,10);

			$this->load->helper('resize');
			// 썸네일 이미지 처리
			$thumb_img = '<img src="'.IMG_DIR.'/common/blank_image.png" style="width:100%" />';
			$thumb_img_src = IMG_DIR.'/common/blank_image.png';
			if($row['wr_idx'])
			{
				$file_row = $this->get_common_row('row','*','file_manager',FALSE,FALSE,FALSE,array('wr_table'=>$bo_code, 'wr_table_idx'=>$row['wr_idx'], 'upload_type' => $upload_type, 'file_type'=>'image'),FALSE,'idx desc',1);

				//echo $this->db->last_query();

				if(! empty($file_row)) {
					//$thumb_img = resize_thumb_image($file_row->file_name, $file_row->file_dir, $file_row->file_dir.'/thumb', $img_w,$img_h,FALSE,'width','img');
					$thumb_img_src = resize_thumb_image($file_row->file_name, $file_row->file_dir, $file_row->file_dir.'/thumb', $img_w,$img_h,FALSE,'width','src');
				}
			}
			$list[$i]->thumb_img = $thumb_img;
			$list[$i]->thumb_img_src = $thumb_img_src;

			$list[$i]->ca_code = $row['ca_code'];

			$list[$i]->addfld_1 = $row['addfld_1'];
			$list[$i]->addfld_2 = $row['addfld_2'];
			$list[$i]->addfld_3 = $row['addfld_3'];
			$list[$i]->addfld_4 = $row['addfld_4'];
			$list[$i]->addfld_5 = $row['addfld_5'];


		}

		return $list;
	}


	// 게시글
    function latest_bbs($bo_code, $limit=5, $cut=200, $add_where=FALSE) {

        //$this->db->cache_on();

		$this->db->where('wr_option !=', 'secret');
		$this->db->where('VIEW', 'Y');
		if($add_where) {
			$this->db->where($add_where);
		}
		$bo_table = 'bbs_'.$bo_code;
		$this->db->select('wr_idx, wr_subject, ca_code, wr_datetime, addfld_1, addfld_2, addfld_3, addfld_4, addfld_5');
		$result = $this->db->order_by('wr_datetime', 'desc')->get($bo_table, $limit)->result_array();

        //$this->db->cache_off();

        $list = array();
		//$this->load->helper('textual');
		foreach($result as $i => $row) {
            $list[$i] = new stdClass(); // 2013-10-02
			$list[$i]->wr_idx = $row['wr_idx'];
			$list[$i]->href = '/board/'.$bo_code.'/detail/'.$row['wr_idx'];
			$list[$i]->subject = cut_str(get_text($row['wr_subject']), $cut);
			$list[$i]->wr_date = substr($row['wr_datetime'],0,10);
			$list[$i]->wr_datetime = $row['wr_datetime'];


			$list[$i]->addfld_1 = $row['addfld_1'];
			$list[$i]->addfld_2 = $row['addfld_2'];
			$list[$i]->addfld_3 = $row['addfld_3'];
			$list[$i]->addfld_4 = $row['addfld_4'];
			$list[$i]->addfld_5 = $row['addfld_5'];

		}

		return $list;
	}




	/**
	 * - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	 * Get common row
	 * - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	 * $get_type : row, row_array
	 * - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	*/

	//function get_common_row($get_type='row',$fields='*',$sql_from=FALSE,$sql_where=FALSE,$sql_group_by=FALSE,$sql_order_by=FALSE,$limit=FALSE) {

	function get_common_row($get_type='row',$fields='*',$sql_from=FALSE,$join_tbl=FALSE,$join_where=FALSE,$join_option=FALSE,$sql_where=FALSE,$sql_group_by=FALSE,$sql_order_by=FALSE,$limit=FALSE,$sql_or_where=FALSE) {

		$this->db->select($fields);

		// Join
		if ( ! empty($join_tbl) && ! empty($join_where))
		{
			$this->db->join($join_tbl, $join_where, $join_option);
		}

		// Where
		if ( ! empty($sql_where))
		{
			if( is_array($sql_where) )
				$this->db->where($sql_where);
			else
				$this->db->where($sql_where, NULL, FALSE);
		}

		if($sql_or_where) {
			$this->db->where($sql_or_where);
		}


		// Group by
		if ($sql_group_by)
		{
			$this->db->group_by($sql_group_by);
		}

		if ($sql_order_by)
		{
			$this->db->order_by($sql_order_by);
		}
		// Limit
		//if ( ! empty($limit) )
		if ($limit)
		{
			$this->db->limit($limit);
		}

		if($get_type === 'row'):
			//$row = $this->db->get_where($sql_from,$sql_where)->row();
			$data = $this->db->get($sql_from,$sql_where)->row();
		else:
			//$row = $this->db->get_where($sql_from,$sql_where)->row_array();
			$data = $this->db->get($sql_from,$sql_where)->row_array();
		endif;

		return $data;
	}


}