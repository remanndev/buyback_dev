<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Trans extends CI_Controller {
	function __construct() {
		parent::__construct();

		$this->load->library('tank_auth');
		$this->load->library('basic_lib');
		$this->load->library('board_lib');
		$this->load->library('upload_lib');
		$this->load->library('campaign_lib');
		$this->load->model('tank_auth/users');

		//$this->load->model('tank_auth/users');
		//$this->load->model('Calendar_model');

		//$this->load->library('simple_html_dom');

		// table
		$this->tbl_items = "items";
		$this->tbl_item_category = "item_category";
		$this->tbl_item_zzim = "item_zzim";

	}


	// 오늘 하루만 
	function access() {

		//$this->session->set_flashdata('enter_main', '1');
        //$this->session->set_userdata('enter_main', '1');

        $cookie = array(
            'name'   => 'main_parking',
            'value'  => '1',
            'expire' => '86500',
            'domain' => '',
            'path'   => '/',
            'prefix' => '',
            'secure' => FALSE
        );

        $this->input->set_cookie($cookie);

		echo '1';
	}



	// 
	function request_receipt() {
		
		// jquery ajax 에서 success 의 response 값을 못가져오길래 검색해보니,
		// 요 아래 코드를 ajax 페이지에서 호출하는 페이지에 넣어주라고 함.
		header("Content-type: text/html; charset=utf-8");
		header("Content-Type:application/json");

		$dn_idx = $this->input->post('dn_idx',FALSE);
		$cmp_code = $this->input->post('cmp_code',FALSE);
		$u_idx = $this->input->post('u_idx',FALSE);

		// 현재 신청 상태 확인
		$arr = array(
				'sql_select'     => '*',
				'sql_from'       => 'donation',
				'sql_where'      => array('idx'=>$dn_idx, 'cmp_code'=>$cmp_code, 'user_idx'=>$u_idx),
		);
		$row = $this->basic_model->arr_get_row($arr);

		//print_r($row);

		// receipt_req_dt
		if(isset($row->receipt_req_dt)) {
			// 이미 신청한 상태.
			// 변수에 값이 존재하고, NULL 이 아닌 값
			echo 'already';
		}
		else {
			// NULL 값이면..
			// 미신청 상태에서 신청 상태로 변경
			$data = array('receipt_req_dt'=>TIME_YMDHIS);
			$this->db->where('idx', $dn_idx);
			if ($this->db->update('donation', $data)) {
				echo 'true';
			}
			else {
				echo 'false';
			}
		}
	}



	// 고유한 페이지 코드 수정
	function page_code_edit($flag=FALSE) {

		// jquery ajax 에서 success 의 response 값을 못가져오길래 검색해보니,
		// 요 아래 코드를 ajax 페이지에서 호출하는 페이지에 넣어주라고 함.
		header("Content-type: text/html; charset=utf-8");
		header("Content-Type:application/json");



		if(! $flag) {
			echo FALSE;
		}
		else {

			$page_code = $this->input->post('page_code',FALSE);
			//$new_code = $this->input->post('new_code',FALSE);
			$new_code = str_replace(' ','',trim($this->input->post('new_code',FALSE)));


			if($page_code == $new_code) {
				echo 'self';
				return false;
			}

			$child_cnt = $this->basic_model->get_common_count('mng_cms', array('parent_code' => $page_code,'del_datetime'=>NULL));
			if($child_cnt > 0) {
				//echo '하위 메뉴가 존재합니다. 하위메뉴를 삭제하시면 수정이 가능합니다.';
				echo 'exist-child';
				return false;
			}

			$used_cnt = $this->basic_model->get_common_count('mng_cms', array('page_code' => $new_code));
			if($used_cnt > 0) {
				//echo '현재 사용중이거나, 과거에 사용했던 페이지 코드입니다.';
				echo 'used';
				return false;
			}


			if($child_cnt < 1 && $used_cnt < 1) {

				if($flag == 'chk') {
					echo 'able';
					return false;

				}
				else if($flag == 'save') {

					// 현재 메뉴 정보 겟
					$arr = array(
							'sql_select'     => '*',
							'sql_from'       => 'mng_cms',
							'sql_where'      => array('page_code'=>$page_code),
					);
					$row = $this->basic_model->arr_get_row($arr);
					$nav_ord = str_replace($page_code,$new_code,$row->nav_ord);
					$menu_order = str_replace($page_code,$new_code,$row->menu_order);
					$first_code = str_replace($page_code,$new_code,$row->first_code);
					$page_url = str_replace($page_code,$new_code,$row->page_url);

					$data = array(
						'page_code'=>$new_code,
						'nav_ord'=>$nav_ord,
						'menu_order'=>$menu_order,
						'first_code'=>$first_code,
						'page_url'=>$page_url,
					);
					$this->db->where('page_code', $page_code);
					if ($this->db->update('mng_cms', $data)) {
						//echo '수정이 완료되었습니다.';
						//echo 'succ';
						echo $new_code;
						return false;
					}

				}
			}

		}

		echo 'false';
		return false;

	}




	// [AJX]수정 데이터 가져오기
	function get_row_land()
	{



		// jquery ajax 에서 success 의 response 값을 못가져오길래 검색해보니,
		// 요 아래 코드를 ajax 페이지에서 호출하는 페이지에 넣어주라고 함.
		header("Content-type: text/html; charset=utf-8");
		header("Content-Type:application/json");

		// idx
		$idx = $this->input->post('idx',FALSE);
		$tbl_name = $this->input->post('tbl',FALSE);

		$arr = array(
				'sql_select'     => '*',
				'sql_from'       => $tbl_name,
				'sql_where'      => array('DELYN' => 'N','IDX'=>$idx),
		);
		$row = $this->basic_model->arr_get_row($arr);

		echo(json_encode($row));
	}


	// 제휴문의 버튼 처리
	function btn_process() {

		// jquery ajax 에서 success 의 response 값을 못가져오길래 검색해보니,
		// 요 아래 코드를 ajax 페이지에서 호출하는 페이지에 넣어주라고 함.
		header("Content-type: text/html; charset=utf-8");

		$idx = $this->input->post('idx');
		$tbl = 'bbs_'.$this->input->post('tbl');

		$sql_arr = array(
				'sql_select'     => '*',
				'sql_from'       => $tbl,
				'sql_where'      => array('wr_idx'=>$idx)
		);
		$row = $this->basic_model->arr_get_row($sql_arr);
		//print_r($row);

		if('bbs_form' == $tbl) {
			if($row->addfld_1 == 'Y') {
				$return_val = 'N';
			}
			else {
				$return_val = 'Y';
			}
			$data = array('addfld_1'=>$return_val);
			$this->db->where('wr_idx', $idx);
			if ($this->db->update($tbl, $data)) {
				echo $return_val;
			}
			else {
				echo 'err';
			}
		}
		else if('bbs_counsel' == $tbl) {
			if($row->addfld_1 == 'Y') {
				$return_val = 'N';
			}
			else {
				$return_val = 'Y';
			}

			$data = array('addfld_1'=>$return_val);
			$this->db->where('wr_idx', $idx);
			if ($this->db->update($tbl, $data)) {
				echo $return_val;
			}
			else {
				echo 'err';
			}
		}
		else if('bbs_reserve' == $tbl) {
			if($row->addfld_4 == 'Y') {
				$return_val = 'N';
			}
			else {
				$return_val = 'Y';
			}

			$data = array('addfld_4'=>$return_val);
			$this->db->where('wr_idx', $idx);
			if ($this->db->update($tbl, $data)) {
				echo $return_val;
			}
			else {
				echo 'err';
			}
		}
		else if('bbs_event_list' == $tbl) {
			if($row->addfld_4 == 'Y') {
				$return_val = 'N';
			}
			else {
				$return_val = 'Y';
			}

			$data = array('addfld_4'=>$return_val);
			$this->db->where('wr_idx', $idx);
			if ($this->db->update($tbl, $data)) {
				echo $return_val;
			}
			else {
				echo 'err';
			}
		}


	}



	// 칸타 이벤트 신청하기
	function canta_event() {

				// jquery ajax 에서 success 의 response 값을 못가져오길래 검색해보니,
				// 요 아래 코드를 ajax 페이지에서 호출하는 페이지에 넣어주라고 함.
				header("Content-type: text/html; charset=utf-8");

				$req_name = $this->input->post('req_name');
				$req_phone = $this->input->post('req_phone');
				$req_branch = $this->input->post('req_branch');

				$event_idx = $this->input->post('event_idx');
				$event_subject = $this->input->post('event_subject');

				// 신청 등록
				$subject = $req_name.' 님의 신청입니다.';
				$content = '이름 : '.$req_name;
				$content .= '<br />전화 : '. $req_phone;
				$content .= '<br />지점 : '. $req_branch;


				// 이벤트 신청 내역
				$bo_code = 'event_list';

				$this->load->model('board_model');

				// 가장 작은 번호에 1을 빼서 넘겨줌
				$wr_num = $this->board_model->get_min_num($bo_code);
				$wr_num = (int)($wr_num - 1);

				$ord_num = $this->board_model->get_max_ord($bo_code);
				$ord_num = (int)($ord_num + 1);

				


				$data = array('wr_subject'=>$subject,'wr_content'=>$content,'wr_name'=>$req_name, 'wr_mobile'=>$req_phone, 'addfld_1'=>$event_idx, 'addfld_2'=>$event_subject, 'addfld_3'=>$req_branch, 'wr_datetime'  => TIME_YMDHIS,'wr_ip' => $this->input->ip_address(), 'ORD'=>$ord_num, 'wr_num' => $wr_num);
				if ($this->db->insert('bbs_event_list', $data)) {
					$idx = $this->db->insert_id();
					echo $idx;

					/*
					$return_url = '/board/event/detail/'.$event_idx;
					if($idx) {
						alert('이벤트 신청이 접수되었습니다.\n신청해주셔서 감사합니다.',base_url().$return_url);
					}
					else {
						alert('신청이 되지 않았습니다.\n관리자에 문의해주세요.',base_url().$return_url);
					}
					*/

				}
				else {
					echo 'iFALSE';
				}




	}


	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	// 제품 찜하기
		function fn_prd_zzim() {
				// jquery ajax 에서 success 의 response 값을 못가져오길래 검색해보니,
				// 요 아래 코드를 ajax 페이지에서 호출하는 페이지에 넣어주라고 함.
				header("Content-type: text/html; charset=utf-8");

				$prd_idx = $this->input->post('prd_idx');
				$user_idx = $this->tank_auth->get_user_id();

				if($user_idx)
				{
					$total = $this->basic_model->get_common_count('prd_zzim', array('user_idx'=>$user_idx, 'prd_idx'=>$prd_idx));
					if( $total > 0 ) {
						// 찜 삭제
						$this->db->where('user_idx', $user_idx);
						$this->db->where('prd_idx', $prd_idx);
						$this->db->delete('prd_zzim');
						if ($this->db->affected_rows() > 0) {
							//return TRUE;
							echo 'del';
						}
						else {
							echo 'dFALSE';
						}
					}
					else {
						// 찜 등록
						$data = array('user_idx'=>$user_idx, 'prd_idx'=>$prd_idx);
						if ($this->db->insert('prd_zzim', $data)) {
							$zzim_idx = $this->db->insert_id();
							echo $zzim_idx;
						}
						else {
							echo 'iFALSE';
						}
					}
				}

		}


	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		// [제품 등록/수정] 제품 하위 카테고리 목록
		function fn_list_next_cate() {

				// jquery ajax 에서 success 의 response 값을 못가져오길래 검색해보니,
				// 요 아래 코드를 ajax 페이지에서 호출하는 페이지에 넣어주라고 함.
				header("Content-type: text/html; charset=utf-8");

				$pidx = $this->input->post('pidx');
				$depth = $this->input->post('depth');
				$child_depth = $depth+1;
				$pcate = 'pcate'.$depth;
				
				$sql_arr = array(
						'sql_select'     => '*',
						'sql_from'       => 'prd_category',
						'sql_where'      => array('depth'=>$child_depth,$pcate=>$pidx,'disuse'=>NULL),
						'sql_order_by'   => 'order ASC',
				);
				$result_cate = $this->basic_model->arr_get_result($sql_arr);

				$res = '';
				$res .= '<ul id="sortable'.$child_depth.'" class="sortable'.$child_depth.'">';
					foreach($result_cate['qry'] as $i => $row) { 
				$res .= '	<li id="cate_wrap_'.$row->idx.'" class="item_box input_cate'.$child_depth.' cate'.$child_depth.'_'.($i+1).'" onclick="ready_nextcate('. $row->idx .','. $row->depth .',this);">';
				//$res .= '		<input type="text" id="cate_idx_'. $row->idx .'" name="" value="'. $row->name .'" class="o_input"  />';
				$res .= '		<span id="cate_idx_'. $row->idx .'" name="" class="cate_box" >'. $row->name .'</span>';
				//$res .= '		<span class="item_num">'.($i + 1).'</span>';
				//$res .= '		<button type="button" class="btn btn-secondary btn-xs py-1" style="z-index:100;" onclick="edit_cate('. $row->idx .');">수정</button>';
				//$res .= '		<button type="button" class="btn btn-danger btn-xs py-1" style="z-index:100;" onclick="del_cate('. $row->idx .');">삭제</button>';
				$res .= '	</li>';
					} 
				$res .= '</ul>';

				echo $res;
		}



	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		// [제품 목록] 제품 하위 카테고리 목록
		function fn_select_next_cate() {

				// jquery ajax 에서 success 의 response 값을 못가져오길래 검색해보니,
				// 요 아래 코드를 ajax 페이지에서 호출하는 페이지에 넣어주라고 함.
				header("Content-type: text/html; charset=utf-8");

				$pidx = $this->input->post('pidx');
				$depth = $this->input->post('depth');
				$child_depth = $depth+1;
				$pcate = 'pcate'.$depth;
				
				$sql_arr = array(
						'sql_select'     => '*',
						'sql_from'       => 'prd_category',
						'sql_where'      => array('depth'=>$child_depth,$pcate=>$pidx,'disuse'=>NULL),
						'sql_order_by'   => 'order ASC',
				);
				$result_cate = $this->basic_model->arr_get_result($sql_arr);

				/*
				$res = '';
				$res .= '<ul id="sortable'.$child_depth.'" class="sortable'.$child_depth.'">';
					foreach($result_cate['qry'] as $i => $row) { 
				$res .= '	<li id="cate_wrap_'.$row->idx.'" class="item_box input_cate'.$child_depth.' cate'.$child_depth.'_'.($i+1).'" onclick="ready_nextcate('. $row->idx .','. $row->depth .',this);">';
				$res .= '		<span id="cate_idx_'. $row->idx .'" name="" class="cate_box" >'. $row->name .'</span>';
				$res .= '	</li>';
					} 
				$res .= '</ul>';
				*/


				$res = '';
				$res .= '<select name="cate'.$child_depth.'" id="cate'.$child_depth.'" class="o_selectbox" style="width:100%;"  onchange="select_nextcate(this.value,'.$child_depth.',this);">';
				$res .= '  <option value="all">전체</option>';
				  foreach($result_cate['qry'] as $i => $o) {
				$res .= '  <option value="'. $o->idx .'">'. $o->name .'</option>';
				  }
				$res .= '</select>';



				echo $res;
		}




	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		// [견적 요청] 
		function fn_select_next_cate_estimate() {

				// jquery ajax 에서 success 의 response 값을 못가져오길래 검색해보니,
				// 요 아래 코드를 ajax 페이지에서 호출하는 페이지에 넣어주라고 함.
				header("Content-type: text/html; charset=utf-8");

				$pidx = $this->input->post('pidx');
				$depth = $this->input->post('depth');

				if($depth < 4) {
						
						// next category 

						$child_depth = $depth+1;
						$pcate = 'pcate'.$depth;
						
						$sql_arr = array(
								'sql_select'     => '*',
								'sql_from'       => 'prd_category',
								'sql_where'      => array('depth'=>$child_depth,$pcate=>$pidx,'disuse'=>NULL),
								'sql_order_by'   => 'order ASC',
						);
						$result_cate = $this->basic_model->arr_get_result($sql_arr);

						/*
						$res = '';
						$res .= '<ul id="sortable'.$child_depth.'" class="sortable'.$child_depth.'">';
							foreach($result_cate['qry'] as $i => $row) { 
						$res .= '	<li id="cate_wrap_'.$row->idx.'" class="item_box input_cate'.$child_depth.' cate'.$child_depth.'_'.($i+1).'" onclick="ready_nextcate('. $row->idx .','. $row->depth .',this);">';
						$res .= '		<span id="cate_idx_'. $row->idx .'" name="" class="cate_box" >'. $row->name .'</span>';
						$res .= '	</li>';
							} 
						$res .= '</ul>';
						*/


						$res = '';
						$res .= '<select name="cate'.$child_depth.'" id="cate'.$child_depth.'" class="o_selectbox" style="width:100%; line-height:50px; height:50px;"  onchange="select_nextcate(this.value,'.$child_depth.',this);">';
						$res .= '  <option value="">카테고리를 선택해주세요.</option>';
						  foreach($result_cate['qry'] as $i => $o) {
						$res .= '  <option value="'. $o->idx .'">'. $o->name .'</option>';
						  }
						$res .= '</select>';

				}
				else if($depth == '4') {

						// products

						$sql_arr = array(
								'sql_select'     => '*',
								'sql_from'       => 'products',
								'sql_where'      => array('cate_idx'=>$pidx),
								'sql_order_by'   => 'prd_name ASC',
						);
						$result_prd = $this->basic_model->arr_get_result($sql_arr);

						$res = '';
						$res .= '<select name="product_list" id="product_list" class="o_selectbox" style="width:100%; line-height:50px; height:50px;"  onchange="select_product(this);">';
						$res .= '  <option value="">제품을 선택해주세요.</option>';
						  foreach($result_prd['qry'] as $i => $o) {
						$res .= '  <option value="'. $o->idx .'">'. $o->prd_name .'</option>';
						  }
						$res .= '</select>';

				}

				echo $res;
		}



	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		// [카테고리 등록/수정] 카테고리 수정
		function fn_edit_cate() {
				// jquery ajax 에서 success 의 response 값을 못가져오길래 검색해보니,
				// 요 아래 코드를 ajax 페이지에서 호출하는 페이지에 넣어주라고 함.
				header("Content-type: text/html; charset=utf-8");

				$cate_idx = $this->input->post('cate_idx');
				$cate_val = $this->input->post('cate_val');

				$cate_order_val = $this->input->post('cate_order');

				$data = array('name'=>$cate_val,'order'=>$cate_order_val);
				$this->db->where('idx', $cate_idx);
				if ($this->db->update('prd_category', $data)) {
					echo 'true';
					//echo $this->db->last_query();
				}
				else {
					echo 'false';
				}
		}

		// 카테고리 삭제
		function fn_del_cate() {
				// jquery ajax 에서 success 의 response 값을 못가져오길래 검색해보니,
				// 요 아래 코드를 ajax 페이지에서 호출하는 페이지에 넣어주라고 함.
				header("Content-type: text/html; charset=utf-8");

				$cate_idx = $this->input->post('cate_idx');

				$this->db->where('idx', $cate_idx);
				$this->db->delete('prd_category');

				if ($this->db->affected_rows() > 0) {
					return TRUE;
				}
				return FALSE;

		}

		// 제품 하위 카테고리 목록
		function fn_list_child_cate() {

				// jquery ajax 에서 success 의 response 값을 못가져오길래 검색해보니,
				// 요 아래 코드를 ajax 페이지에서 호출하는 페이지에 넣어주라고 함.
				header("Content-type: text/html; charset=utf-8");

				$pidx = $this->input->post('pidx');
				$depth = $this->input->post('depth');
				$child_depth = $depth+1;
				$pcate = 'pcate'.$depth;
				
				$sql_arr = array(
						'sql_select'     => '*',
						'sql_from'       => 'prd_category',
						'sql_where'      => array('depth'=>$child_depth,$pcate=>$pidx,'disuse'=>NULL),
						'sql_order_by'   => 'order ASC',
				);
				$result_cate = $this->basic_model->arr_get_result($sql_arr);

				$res = '';
				$res .= '<ul id="sortable'.$child_depth.'" class="sortable'.$child_depth.'">';
					foreach($result_cate['qry'] as $i => $row) { 
				$res .= '	<li id="cate_wrap_'.$row->idx.'" class="item_box input_cate'.$child_depth.' cate'.$child_depth.'_'.($i+1).'" onclick="ready_nextcate('. $row->idx .','. $row->depth .',this);">';
				$res .= '		<input type="text" id="cate_idx_'. $row->idx .'" name="" value="'. $row->name .'" class="o_input"  />';
				//$res .= '		<span class="item_num">'.($i + 1).'</span>';

				$res .= '		<input type="text" id="cate_order_'. $row->idx .'" name="" value="'. $row->order .'" class="o_input" style="width:50px;" />';

				$res .= '		<button type="button" class="btn btn-secondary btn-xs py-1" style="z-index:100;" onclick="edit_cate('. $row->idx .');">수정</button>';
				$res .= '		<button type="button" class="btn btn-danger btn-xs py-1" style="z-index:100;" onclick="del_cate('. $row->idx .');">삭제</button>';
				$res .= '	</li>';
					} 
				$res .= '</ul>';

				echo $res;
		}

		// 제품 카테고리 등록
		function fn_reg_cate() {

			// jquery ajax 에서 success 의 response 값을 못가져오길래 검색해보니,
			// 요 아래 코드를 ajax 페이지에서 호출하는 페이지에 넣어주라고 함.
			header("Content-type: text/html; charset=utf-8");

			$cate_depth = $this->input->post('cate_depth');
			$cate_name = $this->input->post('cate_name');

			$pcate1 = $this->input->post('pcate1'); // 2차메뉴용
			$pcate2 = $this->input->post('pcate2'); // 3차메뉴용
			$pcate3 = $this->input->post('pcate3'); // 4차메뉴용
			$pcate4 = $this->input->post('pcate4');

			$arr_pcate = array('',$pcate1,$pcate2,$pcate3,$pcate4);

			// cate_depth,pcate1,pcate2,pcate3,pcate4
			if($cate_depth && $cate_depth > 0)
			{

				$table = 'prd_category';
				$where_arr = array('depth'=>$cate_depth);
				if($cate_depth > 1) {
					// 2차 카테고리부터 적용
					$cno = $cate_depth - 1;
					$where_arr['pcate'.$cno] = $arr_pcate[$cno];
				}

				$ord_num = $this->get_max_ord($table,$where_arr,'order');
				$ord_num = (int)($ord_num + 1);

				$data = array(
					'depth'      => $cate_depth,
					'order'     => $ord_num,
					'name'  => $cate_name
				);

				if($cate_depth > 1) {
					for($i=1;$i<$cate_depth;$i++) {
						$data['pcate'.$i] = $arr_pcate[$i];
					}
				}

				if ($this->db->insert($table, $data)) {
					$idx = $this->db->insert_id();
					//return $idx;


					$child_depth = $cate_depth + 1;

					$res = '';
					$res .= '	<li id="cate_wrap_'.$idx.'" class="item_box input_cate'.$cate_depth.'" onclick="ready_nextcate('. $idx .','. $cate_depth .',this);">';
					$res .= '		<input type="text" id="cate_idx_'. $idx .'" name="" value="'. $cate_name .'" class="o_input"  />';
					//$res .= '		<span class="item_num">'.($i + 1).'</span>';
					$res .= '		<button type="button" class="btn btn-secondary btn-xs py-1" style="z-index:100;" onclick="edit_cate('. $idx .');">수정</button>';
					$res .= '		<button type="button" class="btn btn-danger btn-xs py-1" style="z-index:100;" onclick="del_cate('. $idx .');">삭제</button>';
					$res .= '	</li>';

					echo $res;

				}

			}
			return NULL;

		}

		// 최대 order 숫자를 얻는다.
		private function get_max_ord($table,$where_arr,$order='order') {

			// 가장 큰 번호를 얻자
			$this->db->select_max($order, 'max_order');
			$this->db->where($where_arr);
			$row = $this->db->get($table)->row();

			$max_order = isset($row->max_order) ? $row->max_order : 0;

			return $max_order;
		}










	// 제품 item 카테고리 + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + +

	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	// 제품 찜하기
		function item_zzim() {
				// jquery ajax 에서 success 의 response 값을 못가져오길래 검색해보니,
				// 요 아래 코드를 ajax 페이지에서 호출하는 페이지에 넣어주라고 함.
				header("Content-type: text/html; charset=utf-8");

				$prd_idx = $this->input->post('prd_idx');
				$user_idx = $this->tank_auth->get_user_id();

				if($user_idx)
				{
					$total = $this->basic_model->get_common_count($this->tbl_item_zzim, array('user_idx'=>$user_idx, 'prd_idx'=>$prd_idx));
					if( $total > 0 ) {
						// 찜 삭제
						$this->db->where('user_idx', $user_idx);
						$this->db->where('prd_idx', $prd_idx);
						$this->db->delete($this->tbl_item_zzim);
						if ($this->db->affected_rows() > 0) {
							//return TRUE;
							echo 'del';
						}
						else {
							echo 'dFALSE';
						}
					}
					else {
						// 찜 등록
						$data = array('user_idx'=>$user_idx, 'prd_idx'=>$prd_idx);
						if ($this->db->insert($this->tbl_item_zzim, $data)) {
							$zzim_idx = $this->db->insert_id();
							echo $zzim_idx;
						}
						else {
							echo 'iFALSE';
						}
					}
				}

		}


	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		// [제품 등록/수정] 제품 하위 카테고리 목록
		function item_list_next_cate() {

				// jquery ajax 에서 success 의 response 값을 못가져오길래 검색해보니,
				// 요 아래 코드를 ajax 페이지에서 호출하는 페이지에 넣어주라고 함.
				header("Content-type: text/html; charset=utf-8");

				$pidx = $this->input->post('pidx');
				$depth = $this->input->post('depth');
				$child_depth = $depth+1;
				$pcate = 'pcate'.$depth;
				
				$sql_arr = array(
						'sql_select'     => '*',
						'sql_from'       => $this->tbl_item_category,
						'sql_where'      => array('depth'=>$child_depth,$pcate=>$pidx,'disuse'=>NULL,'del_datetime'=>NULL),
						'sql_order_by'   => 'order ASC',
				);
				$result_cate = $this->basic_model->arr_get_result($sql_arr);

				$res = '';
				$res .= '<ul id="sortable'.$child_depth.'" class="sortable'.$child_depth.'">';
					foreach($result_cate['qry'] as $i => $row) { 
				$res .= '	<li id="cate_wrap_'.$row->idx.'" class="item_box input_cate'.$child_depth.' cate'.$child_depth.'_'.($i+1).'" onclick="ready_nextcate('. $row->idx .','. $row->depth .',this);">';
				//$res .= '		<input type="text" id="cate_idx_'. $row->idx .'" name="" value="'. $row->name .'" class="o_input"  />';
				$res .= '		<span id="cate_idx_'. $row->idx .'" name="" class="cate_box" >'. $row->name .'</span>';
				//$res .= '		<span class="item_num">'.($i + 1).'</span>';
				//$res .= '		<button type="button" class="btn btn-secondary btn-xs py-1" style="z-index:100;" onclick="edit_cate('. $row->idx .');">수정</button>';
				//$res .= '		<button type="button" class="btn btn-danger btn-xs py-1" style="z-index:100;" onclick="del_cate('. $row->idx .');">삭제</button>';
				$res .= '	</li>';
					} 
				$res .= '</ul>';

				echo $res;
		}



	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		// [제품 목록] 제품 하위 카테고리 목록
		function item_select_next_cate() {

				// jquery ajax 에서 success 의 response 값을 못가져오길래 검색해보니,
				// 요 아래 코드를 ajax 페이지에서 호출하는 페이지에 넣어주라고 함.
				header("Content-type: text/html; charset=utf-8");

				$pidx = $this->input->post('pidx');
				$depth = $this->input->post('depth');
				$child_depth = $depth+1;
				$pcate = 'pcate'.$depth;
				
				$sql_arr = array(
						'sql_select'     => '*',
						'sql_from'       => $this->tbl_item_category,
						'sql_where'      => array('depth'=>$child_depth,$pcate=>$pidx,'disuse'=>NULL,'del_datetime'=>NULL),
						'sql_order_by'   => 'order ASC',
				);
				$result_cate = $this->basic_model->arr_get_result($sql_arr);

				/*
				$res = '';
				$res .= '<ul id="sortable'.$child_depth.'" class="sortable'.$child_depth.'">';
					foreach($result_cate['qry'] as $i => $row) { 
				$res .= '	<li id="cate_wrap_'.$row->idx.'" class="item_box input_cate'.$child_depth.' cate'.$child_depth.'_'.($i+1).'" onclick="ready_nextcate('. $row->idx .','. $row->depth .',this);">';
				$res .= '		<span id="cate_idx_'. $row->idx .'" name="" class="cate_box" >'. $row->name .'</span>';
				$res .= '	</li>';
					} 
				$res .= '</ul>';
				*/


				$res = '';
				$res .= '<select name="cate'.$child_depth.'" id="cate'.$child_depth.'" class="o_selectbox" style="width:100%;"  onchange="select_nextcate(this.value,'.$child_depth.',this);">';
				$res .= '  <option value="all">전체</option>';
				  foreach($result_cate['qry'] as $i => $o) {
				$res .= '  <option value="'. $o->idx .'">'. $o->name .'</option>';
				  }
				$res .= '</select>';



				echo $res;
		}




	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		// [견적 요청] 
		function item_select_next_cate_estimate() {

				// jquery ajax 에서 success 의 response 값을 못가져오길래 검색해보니,
				// 요 아래 코드를 ajax 페이지에서 호출하는 페이지에 넣어주라고 함.
				header("Content-type: text/html; charset=utf-8");

				$pidx = $this->input->post('pidx');
				$depth = $this->input->post('depth');

				if($depth < 4) {
						
						// next category 

						$child_depth = $depth+1;
						$pcate = 'pcate'.$depth;
						
						$sql_arr = array(
								'sql_select'     => '*',
								'sql_from'       => $this->tbl_item_category,
								'sql_where'      => array('depth'=>$child_depth,$pcate=>$pidx,'disuse'=>NULL,'del_datetime'=>NULL),
								'sql_order_by'   => 'order ASC',
						);
						$result_cate = $this->basic_model->arr_get_result($sql_arr);

						/*
						$res = '';
						$res .= '<ul id="sortable'.$child_depth.'" class="sortable'.$child_depth.'">';
							foreach($result_cate['qry'] as $i => $row) { 
						$res .= '	<li id="cate_wrap_'.$row->idx.'" class="item_box input_cate'.$child_depth.' cate'.$child_depth.'_'.($i+1).'" onclick="ready_nextcate('. $row->idx .','. $row->depth .',this);">';
						$res .= '		<span id="cate_idx_'. $row->idx .'" name="" class="cate_box" >'. $row->name .'</span>';
						$res .= '	</li>';
							} 
						$res .= '</ul>';
						*/


						$res = '';
						$res .= '<select name="cate'.$child_depth.'" id="cate'.$child_depth.'" class="o_selectbox" style="width:100%; line-height:50px; height:50px;"  onchange="select_nextcate(this.value,'.$child_depth.',this);">';
						$res .= '  <option value="">카테고리를 선택해주세요.</option>';
						  foreach($result_cate['qry'] as $i => $o) {
						$res .= '  <option value="'. $o->idx .'">'. $o->name .'</option>';
						  }
						$res .= '</select>';

				}
				else if($depth == '4') {

						// products

						$sql_arr = array(
								'sql_select'     => '*',
								'sql_from'       => $this->tbl_items,
								'sql_where'      => array('cate_idx'=>$pidx),
								'sql_order_by'   => 'prd_name ASC',
						);
						$result_prd = $this->basic_model->arr_get_result($sql_arr);

						$res = '';
						$res .= '<select name="product_list" id="product_list" class="o_selectbox" style="width:100%; line-height:50px; height:50px;"  onchange="select_product(this);">';
						$res .= '  <option value="">제품을 선택해주세요.</option>';
						  foreach($result_prd['qry'] as $i => $o) {
						$res .= '  <option value="'. $o->idx .'">'. $o->prd_name .'</option>';
						  }
						$res .= '</select>';

				}

				echo $res;
		}



	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		// [카테고리 등록/수정] 카테고리 수정
		function item_edit_cate() {
				// jquery ajax 에서 success 의 response 값을 못가져오길래 검색해보니,
				// 요 아래 코드를 ajax 페이지에서 호출하는 페이지에 넣어주라고 함.
				header("Content-type: text/html; charset=utf-8");

				$cate_idx = $this->input->post('cate_idx');
				$cate_val = $this->input->post('cate_val');

				$cate_order_val = $this->input->post('cate_order');

				$data = array('name'=>$cate_val,'order'=>$cate_order_val);
				$this->db->where('idx', $cate_idx);
				if ($this->db->update($this->tbl_item_category, $data)) {
					echo 'true';
					//echo $this->db->last_query();
				}
				else {
					echo 'false';
				}
		}


		// 카테고리 삭제
		function item_del_cate() {
				// jquery ajax 에서 success 의 response 값을 못가져오길래 검색해보니,
				// 요 아래 코드를 ajax 페이지에서 호출하는 페이지에 넣어주라고 함.
				header("Content-type: text/html; charset=utf-8");

				$cate_idx = $this->input->post('cate_idx');

				// 삭제하려는 카테고리 정보
				$arr = array(
						'sql_select'     => '*',
						'sql_from'       => $this->tbl_item_category,
						'sql_where'      => array('idx'=>$cate_idx,'del_datetime'=>NULL),
				);
				$row = $this->basic_model->arr_get_row($arr);
				$depth = $row->depth;

				// 하위 카테고리가 있는지 확인
				$pcate_fld = 'pcate'.$depth;
				$pcate_val = $cate_idx;
				$sql_from = $this->tbl_item_category;
				$sql_where = array($pcate_fld=>$pcate_val,'del_datetime'=>NULL); 
				$sub_cate_cnt = $this->basic_model->get_common_count($sql_from, $sql_where);
				if($sub_cate_cnt > 0) {
					echo 'remain_category';
					return false;
				}

				// 제품이 남아 있는지 확인
				$cate_fld = 'cate'.$depth;
				$cate_val = $cate_idx;
				$sql_from = $this->tbl_items;
				$sql_where = array($cate_fld=>$cate_val,'del_datetime'=>NULL); 
				$item_cnt = $this->basic_model->get_common_count($sql_from, $sql_where);
				if($item_cnt > 0) {
					echo 'remain_item';
					return false;
				}


				/*
				$this->db->where('idx', $cate_idx);
				$this->db->delete($this->tbl_item_category);
				if ($this->db->affected_rows() > 0) {
					return TRUE;
				}
				return FALSE;
				*/

				$data = array('del_username'=>$this->tank_auth->get_username(),'del_datetime'=>TIME_YMDHIS);
				$this->db->where('idx', $cate_idx);
				if ($this->db->update($this->tbl_item_category, $data)) {
					return TRUE;
					//echo $this->db->last_query();
				}
				else {
					return FALSE;
				}
		}

		// 제품 하위 카테고리 목록
		function item_list_child_cate() {

				// jquery ajax 에서 success 의 response 값을 못가져오길래 검색해보니,
				// 요 아래 코드를 ajax 페이지에서 호출하는 페이지에 넣어주라고 함.
				header("Content-type: text/html; charset=utf-8");

				$pidx = $this->input->post('pidx');
				$depth = $this->input->post('depth');
				$child_depth = $depth+1;
				$pcate = 'pcate'.$depth;
				
				$sql_arr = array(
						'sql_select'     => '*',
						'sql_from'       => $this->tbl_item_category,
						'sql_where'      => array('depth'=>$child_depth,$pcate=>$pidx,'disuse'=>NULL,'del_datetime'=>NULL),
						'sql_order_by'   => 'order ASC',
				);
				$result_cate = $this->basic_model->arr_get_result($sql_arr);

				$res = '';
				$res .= '<ul id="sortable'.$child_depth.'" class="sortable'.$child_depth.'">';
					foreach($result_cate['qry'] as $i => $row) { 
				$res .= '	<li id="cate_wrap_'.$row->idx.'" class="item_box input_cate'.$child_depth.' cate'.$child_depth.'_'.($i+1).'" onclick="ready_nextcate('. $row->idx .','. $row->depth .',this);">';
				$res .= '		<input type="text" id="cate_idx_'. $row->idx .'" name="" value="'. $row->name .'" class="o_input"  />';
				//$res .= '		<span class="item_num">'.($i + 1).'</span>';

				$res .= '		<input type="text" id="cate_order_'. $row->idx .'" name="" value="'. $row->order .'" class="o_input" style="width:34px;" />';

				$res .= '		<button type="button" class="btn btn-secondary btn-xs py-1" style="z-index:100;" onclick="edit_cate('. $row->idx .');">수정</button>';
				$res .= '		<button type="button" class="btn btn-danger btn-xs py-1" style="z-index:100;" onclick="del_cate('. $row->idx .');">삭제</button>';
				$res .= '	</li>';
					} 
				$res .= '</ul>';

				echo $res;
		}



		// 제품 카테고리 등록
		function item_reg_cate() {

			// jquery ajax 에서 success 의 response 값을 못가져오길래 검색해보니,
			// 요 아래 코드를 ajax 페이지에서 호출하는 페이지에 넣어주라고 함.
			header("Content-type: text/html; charset=utf-8");

			$cate_depth = $this->input->post('cate_depth');
			$cate_name = $this->input->post('cate_name');

			$pcate1 = $this->input->post('pcate1'); // 2차메뉴용
			$pcate2 = $this->input->post('pcate2'); // 3차메뉴용
			$pcate3 = $this->input->post('pcate3'); // 4차메뉴용
			$pcate4 = $this->input->post('pcate4');

			$arr_pcate = array('',$pcate1,$pcate2,$pcate3,$pcate4);

			// cate_depth,pcate1,pcate2,pcate3,pcate4
			if($cate_depth && $cate_depth > 0)
			{

				

				$where_arr = array('depth'=>$cate_depth,'del_datetime'=>NULL);
				if($cate_depth > 1) {
					// 2차 카테고리부터 적용
					$cno = $cate_depth - 1;
					$where_arr['pcate'.$cno] = $arr_pcate[$cno];
				}

				$ord_num = $this->get_max_ord($this->tbl_item_category,$where_arr,'order');
				$ord_num = (int)($ord_num + 1);

				$data = array(
					'depth'      => $cate_depth,
					'order'     => $ord_num,
					'name'  => $cate_name
				);

				if($cate_depth > 1) {
					for($i=1;$i<$cate_depth;$i++) {
						$data['pcate'.$i] = $arr_pcate[$i];
					}
				}

				if ($this->db->insert($this->tbl_item_category, $data)) {
					$idx = $this->db->insert_id();
					//return $idx;


					$child_depth = $cate_depth + 1;

					$res = '';
					$res .= '	<li id="cate_wrap_'.$idx.'" class="item_box input_cate'.$cate_depth.'" onclick="ready_nextcate('. $idx .','. $cate_depth .',this);">';
					$res .= '		<input type="text" id="cate_idx_'. $idx .'" name="" value="'. $cate_name .'" class="o_input"  />';
					//$res .= '		<span class="item_num">'.($i + 1).'</span>';
					$res .= '		<button type="button" class="btn btn-secondary btn-xs py-1" style="z-index:100;" onclick="edit_cate('. $idx .');">수정</button>';
					$res .= '		<button type="button" class="btn btn-danger btn-xs py-1" style="z-index:100;" onclick="del_cate('. $idx .');">삭제</button>';
					$res .= '	</li>';

					echo $res;

				}

			}
			return NULL;

		}



	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		// [제품] 정렬순서 번호 수정
		function item_order_chage() {
				// jquery ajax 에서 success 의 response 값을 못가져오길래 검색해보니,
				// 요 아래 코드를 ajax 페이지에서 호출하는 페이지에 넣어주라고 함.
				header("Content-type: text/html; charset=utf-8");

				$itm_idx = $this->input->post('itm_idx');
				$itm_order = $this->input->post('itm_order');

				$data = array('itm_order'=>$itm_order);
				$this->db->where('idx', $itm_idx);
				if ($this->db->update($this->tbl_items, $data)) {
					echo 'succ';
					//echo $this->db->last_query();
				}
				else {
					echo 'fail';
				}
		}








































	// 검사대상이 알파벳,숫자,밑줄(_),대쉬(-) 이외의 문자를 포함할 때 FALSE를 리턴 합니다.	
	function chk_alpha_dash($str)
	{
		return (bool) preg_match('/^[a-z0-9_-]+$/i', $str);
	}




	// 중복검사 - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	function recycle_duplication_check()
	{
		// jquery ajax 에서 success 의 response 값을 못가져오길래 검색해보니,
		// 요 아래 코드를 ajax 페이지에서 호출하는 페이지에 넣어주라고 함.
		header("Content-type: text/html; charset=utf-8");

		// 장소 코드(pl_code) 생성

		$checkTable = $this->input->post('check_table');
		$checkField = $this->input->post('check_field');
		$checkValue = $this->input->post('check_value');

		if(! $checkTable OR ! $checkField OR ! $checkValue){
			echo 'false';
			exit;
		}

		$chk = $this->recycle_lib->is_place_code_available($checkTable,$checkField,$checkValue);

		echo ($chk) ? 'true' : 'false';
		exit;
	}





	// 중복검사 - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	function duplication_check()
	{
		// jquery ajax 에서 success 의 response 값을 못가져오길래 검색해보니,
		// 요 아래 코드를 ajax 페이지에서 호출하는 페이지에 넣어주라고 함.
		header("Content-type: text/html; charset=utf-8");

		$checkField = $this->input->post('check_field',false);
		$checkValue = $this->input->post('check_value',false);

		// 로그인 했을 경우,
		$mb_idx = $this->input->post('mb_idx',false);
		$mb_email = $this->input->post('mb_email',false);

		if(! $checkField OR ! $checkValue){
			echo 'false';
			exit;
		}

		if( 'username' === $checkField ) {

			// 검사대상이 알파벳,숫자,밑줄(_),대쉬(-) 이외의 문자를 포함할 때 FALSE를 리턴 합니다.	
			if( ! $this->chk_alpha_dash($checkValue) ) {
				echo 'false';
				exit;
			}

			$chk = $this->tank_auth->is_username_available($checkValue);
			$chk_adm = $this->tank_auth->is_admin_available($checkValue);
			echo ($chk && $chk_adm) ? 'true' : 'false';
			exit;
		}
		else if( 'email' === $checkField ) {
			$res = $this->tank_auth->is_email_available($checkValue);
			$res_adm = $this->tank_auth->is_admin_email_available($checkValue);
			
			if(! $res && ! $res_adm) {
				$chk = ($checkValue === $mb_email) ? 'owner' : false;
			}
			else 
				$chk = ($res && $res_adm) ? 'true' : 'false';

			echo $chk;
			exit;
		}
		else if( 'gr_code' === $checkField  OR  'bo_code' === $checkField ) {

			// 게시판그룹(gr_code), 게시판(bo_code) 생성

			// jquery ajax 에서 success 의 response 값을 못가져오길래 검색해보니,
			// 요 아래 코드를 ajax 페이지에서 호출하는 페이지에 넣어주라고 함.
			//header("Content-type: text/html; charset=utf-8");

			$checkTable = $this->input->post('check_table');
			$checkField = $this->input->post('check_field');
			$checkValue = $this->input->post('check_value');

			$chk = $this->board_lib->is_board_available($checkTable,$checkField,$checkValue);

			echo ($chk) ? 'true' : 'false';
			exit;

		}
		else if( 'bo_code' === $checkField ) {

			// 게시판 생성


		}
		else {
			echo 'false';
			exit;
		}

	}



	// 이벤트 관리 - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -




		// [FRM] 이벤트 혜택 신청하기
		function event_request() {

			$this->load->helper(array('form', 'url','load'));
			$this->load->library('form_validation');

			//$captcha_registration	= $this->config->item('captcha_registration', 'tank_auth');
			$use_recaptcha			= $this->config->item('use_recaptcha', 'tank_auth');

			// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
			// 글쓰기 저장시..
			// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
			if( $this->input->post('submit') ) {

					$this->form_validation->set_rules('contactname', '이름', 'trim|required|xss_clean');
					$this->form_validation->set_rules('contactmobile', '연락처', 'trim|required|xss_clean');
					$this->form_validation->set_rules('contactmessage', '문의내용', 'trim|required');

					//if ($captcha_registration) { // tank auth 에서 true 로 설정한 경우에만 실행
						if ($use_recaptcha) {
							$this->form_validation->set_rules('recaptcha_response_field', '자동등록방지코드', 'trim|xss_clean|required|callback__check_recaptcha');
						} else {
							$this->form_validation->set_rules('captcha', '자동등록방지코드', 'trim|xss_clean|required|callback__check_captcha');
						}
					//}

			}


				$bbs_code      = $this->input->post('bbs_code');
				$wr_idx       = $this->input->post('wr_idx');
				$return_url      = $this->input->post('return_url');

				$contactname         = $this->input->post('contactname');
				$contactmobile         = $this->input->post('contactmobile');
				$contactmessage         = $this->input->post('contactmessage');

				$data= array(
					'contactname' => $contactname,
					'contactmobile' => $contactmobile,
					'contactmessage' => $contactmessage
				);

				$res_idx = $this->board_lib->event_contact_write($bbs_code,$wr_idx,$data);

				if($res_idx) {
					alert('이벤트 혜택 신청이 접수되었습니다.\n신청해주셔서 감사합니다.',base_url().$return_url);
				}
				else {
					alert('신청이 되지 않았습니다.\n관리자에 문의해주세요.',base_url().$return_url);
				}

		}



		// [AJX] 이벤트 혜택 신청하기
		function event_contact_write() {

			// jquery ajax 에서 success 의 response 값을 못가져오길래 검색해보니,
			// 요 아래 코드를 ajax 페이지에서 호출하는 페이지에 넣어주라고 함.
			header("Content-type: text/html; charset=utf-8");

			/*
			if (! $this->tank_auth->is_logged_in()) {
				echo 'not_logged_in';
				exit;
			}
			else {
			*/

				$bbs_code      = $this->input->post('bbs_code');
				$wr_idx       = $this->input->post('wr_idx');

				$contactname         = $this->input->post('contactname');
				$contactmobile         = $this->input->post('contactmobile');
				$contactmessage         = $this->input->post('contactmessage');

				$data= array(
					'contactname' => $contactname,
					'contactmobile' => $contactmobile,
					'contactmessage' => $contactmessage
				);

				$res_idx = $this->board_lib->event_contact_write($bbs_code,$wr_idx,$data);

				echo $res_idx;
				exit;

			/*
			}
			*/

		}







	// 게시판 그룹 관리 - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		// 게시판 그룹 업데이트
		function update_board_group()
		{
			// jquery ajax 에서 success 의 response 값을 못가져오길래 검색해보니,
			// 요 아래 코드를 ajax 페이지에서 호출하는 페이지에 넣어주라고 함.
			header("Content-type: text/html; charset=utf-8");

			$gr_idx      = $this->input->post('gr_idx');
			$gr_admin_fk = $this->input->post('gr_admin_fk');
			$gr_title    = $this->input->post('gr_title');

			$data = array('gr_admin_fk'=>$gr_admin_fk,'gr_title'=>$gr_title);

			$chk = $this->board_lib->update_board_group($gr_idx,$data);

			echo ($chk) ? 'true' : 'false';
			exit;
		}




	// 게시판 관리 - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

		// 게시판 글에서 파일 삭제
		function delete_file_manager()
		{
			// jquery ajax 에서 success 의 response 값을 못가져오길래 검색해보니,
			// 요 아래 코드를 ajax 페이지에서 호출하는 페이지에 넣어주라고 함.
			header("Content-type: text/html; charset=utf-8");

			$idx      = $this->input->post('idx');
			$res = $this->upload_lib->delete_file_manager($idx);

			echo ($res) ? 'true' : 'false';
			exit;
		}

		// 세션은 사라지고 파일만 남은 경우, 해당 파일에 세션 갱신
		function update_file_session()
		{
			// jquery ajax 에서 success 의 response 값을 못가져오길래 검색해보니,
			// 요 아래 코드를 ajax 페이지에서 호출하는 페이지에 넣어주라고 함.
			header("Content-type: text/html; charset=utf-8");

			$idx                  = $this->input->post('idx');
			$sess_file_write      = $this->input->post('sess_file_write');

			$res = $this->upload_lib->update_file_session($idx, $sess_file_write);

			echo ($res) ? 'true' : 'false';
			exit;
		}



		function admin_update_cate() {

			// 요 아래 코드를 ajax 페이지에서 호출하는 페이지에 넣어주라고 함.
			header("Content-type: text/html; charset=utf-8");

			$bo_code           = $this->input->post('bo_code');
			$bo_cate_text      = $this->input->post('bo_cate_text');

			$data = array('bo_category' => $bo_cate_text);
			echo $this->board_lib->update_board($bo_code,$data);

		}





		// 게시물 더 보기 #더보기#more
		function more_blist() {


			// jquery ajax 에서 success 의 response 값을 못가져오길래 검색해보니,
			// 요 아래 코드를 ajax 페이지에서 호출하는 페이지에 넣어주라고 함.
			header("Content-type: text/html; charset=utf-8");

			$bo_code      = $this->input->post('bo_code');
			$bo_limit = $this->input->post('bo_limit');
			$bo_offset    = $this->input->post('bo_offset');
			$cate_menu    = $this->input->post('bo_cate', false);
			$bbs_code_url    = $this->input->post('bbs_code_url', false);
			$seg1    = $this->input->post('seg1', false);




			// # 페이징 정보 - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
			$this->load->library('segment', array('offset'=>4), 'seg'); // 세그먼트 주소( page 위치 )
			$this->load->library('querystring', NULL, 'param'); // 쿼리스트링 주소

			$seg	  =& $this->seg;
			$param	  =& $this->param;


			// 공통
			$get_type='result';  // 'result', 'result_array'
			$sql_from = BBS_PRE.$bo_code;
			$fields='*';


			// 게시판 링크 코드 앞쪽
			//$bbs_url_pre = base_url() . 'board/';
			//$bbs_code_url = $bbs_url_pre . $bo_code;


			$join_tbl=FALSE;
			$join_where=FALSE;
			$join_option=FALSE;

			$sql_where=array('wr_idx >' => 0);


			//print_r($param->get('cate'));

			// 카테고리 메뉴 사용시
			//$cate_menu = $param->get('cate', false);
			if( $cate_menu ) {
				$sql_where['ca_code'] = $cate_menu;
			}

			// 전체 수
			$total_cnt = $this->basic_model->get_common_count($sql_from, $sql_where);

			if( $total_cnt <= $bo_offset ) {
				echo 'list_end';
				exit;
			}










			// 검색어 검색
			$like_field = $this->input->post('search_field',FALSE);
			$like_match = $this->input->post('search_text',FALSE);
			$like_side='both';

			$sql_group_by=FALSE;

			$order_field = $this->input->post('order_field',FALSE);
			if(! $order_field) $order_field = 'wr_num, wr_reply ASC';  // 답변글 들여쓰기
			$order_direction = $this->input->post('order_direction',FALSE);

			//$limit = $bbs_cf->bo_page_limit; //'20';
			$limit = $bo_limit; //'20';
			$page  = $seg->get('page', 1); // 페이지

			if(! isset($page) OR empty($page)) {
				$page = '1';
			}
			//$offset = ($page - 1) * $limit;
			$offset = $bo_offset;

			$result = $this->basic_model->get_common_result ($get_type,$sql_from,$fields,$join_tbl,$join_where,$join_option,$sql_where,$like_field,$like_match,$like_side,$sql_group_by,$order_field,$order_direction,$limit,$offset);


			$this->load->helper('resize');
			foreach($result['qry'] as $i => $row) {

					// 썸네일 이미지 처리
					$thumb_img = '<img src="'.IMG_DIR.'/common/blank_image.png" style="width:100%" />';
					if($row->wr_idx)
					{
						//$file_row = $this->basic_model->get_common_row('row','*','file_manager',FALSE,FALSE,FALSE,array('wr_table'=>$bo_code, 'wr_table_idx'=>$row->wr_idx, 'upload_type' => 'form', 'file_type'=>'image'),FALSE,'idx asc',1);

						//$file_row = $this->basic_model->get_common_row('row','*','file_manager',FALSE,FALSE,FALSE,array('wr_table'=>$bo_code, 'wr_table_idx'=>$row->wr_idx, 'upload_type' => 'editor', 'file_type'=>'image'),FALSE,'idx asc',1);

						$file_row = $this->basic_model->get_common_row('row','*','file_manager',FALSE,FALSE,FALSE,array('wr_table'=>$bo_code, 'wr_table_idx'=>$row->wr_idx, 'upload_type != ' => '', 'file_type'=>'image'),FALSE,'idx asc',1);

						//echo $this->db->last_query();

						//if(! empty($file_row)  &&  $file_row->upload_type === 'editor'  &&   $file_row->upload_gubun !== 'file') {
						if(! empty($file_row)) {
							$thumb_img = resize_thumb_image($file_row->file_name, $file_row->file_dir, $file_row->file_dir.'/thumb', '400','300',FALSE,'width');
						}
					}
					$result['qry'][$i]->thumb_img = $thumb_img;

					// 작성자 정보
					$uacc = $this->basic_model->get_common_row('row','nickname','users',FALSE,FALSE,FALSE,array('id'=>$row->user_idx));
					$result['qry'][$i]->wr_name = $uacc->nickname;

					// 컨텐츠 텍스트만 컷
					$result['qry'][$i]->wr_content_cut = cut_str(remove_tags($row->wr_content),200);
			}



			$html = '';

			// 추가 목록
			foreach($result['qry'] as $i => $o)
			{
			
				$class_pick_staff = '';
				if( ('admin' === $seg1 && '1' === $o->opt_staff) ) {
					$class_pick_staff = 'pick_staff';
				}

				$html .= '<div class="grid '. $class_pick_staff .'">';
				$html .= '  <a href="'. $bbs_code_url .'/detail/'. $o->wr_idx .'/page/'. $page .'">';
				$html .= '	<div class="imgholder">';
				$html .= '		'.$o->thumb_img;
				$html .= '	</div>';
				$html .= '	<strong>'. $o->wr_subject .'</strong>';
				$html .= '  </a>';
				$html .= '  <p class="ctnt_cut">'. $o->wr_content_cut .'</p>';

				//$html .= '  <div class="meta">'. $o->ca_code .'</div>';
				$html .= '  <div class="meta">';
				$html .= '    '. $o->ca_code;
				$html .= '    <span class="hit"><img src="'. IMG_DIR .'/common/icon_search.png" style="width:15px;" /> '. $o->wr_hit .'</span>';
				$html .= '  </div>';

						

				$html .= '</div>';
			}

			echo $html;
			exit;


		}











		// 코멘트 쓰기
		function comment_write() {

			// jquery ajax 에서 success 의 response 값을 못가져오길래 검색해보니,
			// 요 아래 코드를 ajax 페이지에서 호출하는 페이지에 넣어주라고 함.
			header("Content-type: text/html; charset=utf-8");

			/*
			if (! $this->tank_auth->is_logged_in()) {
				echo 'not_logged_in';
				exit;
			}
			else {
			*/

				$bbs_code      = $this->input->post('bbs_code');
				$bbs_idx       = $this->input->post('bbs_idx');
				$cmt_mode         = $this->input->post('cmt_mode','write');
				//$cmt_idx       = $this->input->post('cmt_idx');

				if($res = $this->board_lib->cmt_write($bbs_code,$bbs_idx,$cmt_mode)) {
					echo $res;
				}

				exit;

			/*
			}
			*/

		}

		// 코멘트 쓰기
		function comment_del() {

			// jquery ajax 에서 success 의 response 값을 못가져오길래 검색해보니,
			// 요 아래 코드를 ajax 페이지에서 호출하는 페이지에 넣어주라고 함.
			header("Content-type: text/html; charset=utf-8");

			$res = $this->board_lib->cmt_del();

			echo $res;
			exit;
		}







		// 빠른 상담 신청 저장
		function frm_consult() {

			// jquery ajax 에서 success 의 response 값을 못가져오길래 검색해보니,
			// 요 아래 코드를 ajax 페이지에서 호출하는 페이지에 넣어주라고 함.
			header("Content-type: text/html; charset=utf-8");

			$name      = $this->input->post('name');
			$comp       = $this->input->post('comp');
			$phone         = $this->input->post('phone');
			$content       = $this->input->post('content');

			$res = $this->board_lib->consult_write($name,$comp,$phone,$content);


			echo $res;
			//echo ($res) ? 'true' : 'false';
			exit;

		}


		
		
		// 게시판 글 추천하기
		function click_recommand() {

			// jquery ajax 에서 success 의 response 값을 못가져오길래 검색해보니,
			// 요 아래 코드를 ajax 페이지에서 호출하는 페이지에 넣어주라고 함.
			header("Content-type: text/html; charset=utf-8");

				$bo_code      = $this->input->post('bo_code');
				$wr_idx       = $this->input->post('wr_idx');

				$res = $this->board_lib->recommand_write($bo_code,$wr_idx);

				echo $res;
				exit;
		}








		/** - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		 * 방송사례 더보기
		 */

		function more_bbs_media($more_limit=FALSE,$more_page=FALSE,$bo_code=FALSE,$cate=FALSE) {

			// jquery ajax 에서 success 의 response 값을 못가져오길래 검색해보니,
			// 요 아래 코드를 ajax 페이지에서 호출하는 페이지에 넣어주라고 함.
				header("Content-type: text/html; charset=utf-8");

				/*
				$more_limit = $this->input->post('more_limit',FALSE);
				//$more_last = $this->input->post('more_last',FALSE);
				$more_page = $this->input->post('more_page',FALSE);
				$bo_code = $this->input->post('code',FALSE);
				$cate = $this->input->post('cate',FALSE);
				*/

				$bbs_code_url = base_url() . 'board/'. $bo_code;

				// 게시판 설정파일
				$get_type='row';
				$fields='*';
				$sql_from='board_config';
				$join_tbl=FALSE;
				$join_where=FALSE;
				$join_option=FALSE;
				$sql_where=array('bo_code'=>$bo_code);
				$sql_group_by=FALSE;
				$sql_order_by=FALSE;
				$limit=FALSE;
				$bbs_cf = $this->basic_model->get_common_row($get_type,$fields,$sql_from,$join_tbl,$join_where,$join_option,$sql_where,$sql_group_by,$sql_order_by,$limit);


				// 공통
				$get_type='result';  // 'result', 'result_array'
				$sql_from='bbs_media';
				$fields='*';

				$join_tbl=FALSE;
				$join_where=FALSE;
				$join_option=FALSE;

				$sql_where=array('wr_idx >' => 0);
				if($cate && '' != $cate) {
					$sql_where['ca_code'] = $cate;
				}




				// 전체 수
				$total_cnt = $this->basic_model->get_common_count($sql_from, $sql_where);

				$like_field = $this->input->post('search_field',FALSE);
				$like_match = $this->input->post('search_text',FALSE);
				$like_side='both';

				$sql_group_by=FALSE;

				$order_field = $this->input->post('order_field',FALSE);
				//if(! $order_field) $order_field = 'wr_num, wr_reply ASC';  // 답변글 들여쓰기
				//if(! $order_field) $order_field = 'ORD DESC, wr_datetime DESC, wr_reply ASC';  // 답변글 들여쓰기
				//$order_direction = $this->input->post('order_direction',FALSE);

				$order_field = 'opt_notice DESC, ORD DESC, wr_datetime DESC, wr_reply ASC';  // 답변글 들여쓰기
				$order_direction = FALSE;

				$limit = $more_limit; //'20';
				//$page  = $seg->get('page', 1); // 페이지

				if(! isset($more_page) OR empty($more_page)) {
					$more_page = '1';
				}
				$offset = ($more_page - 1) * $limit;

				$result=$this->basic_model->get_common_result($get_type,$sql_from,$fields,$join_tbl,$join_where,$join_option,$sql_where,$like_field,$like_match,$like_side,$sql_group_by,$order_field,$order_direction,$limit,$offset,'opt_notice');

				//print_r($result);

				$total_page = ceil($result['total_count'] / $more_limit);

				$html = '';





				$this->load->helper('resize');
				foreach($result['qry'] as $i => $row) {

					//echo $row->ORD .'#'. $row->wr_idx."<<<<<br />";

					$썸네일이미지_src = '';


						$thumb_img_blank = "blank_image_list.png";
						//$thumb_img_blank = "blank_image_w600h400.png";

						// 썸네일 이미지 처리
						$thumb_img = '<img src="'.IMG_DIR.'/common/'.$thumb_img_blank.'" style="width:100%" />';
						$thumb_src = IMG_DIR.'/common/'.$thumb_img_blank;
						$tag_photo = '';

						$thumb_img_crop = '<img src="'.IMG_DIR.'/common/'.$thumb_img_blank.'" style="width:100%" />';
						$thumb_src_crop = IMG_DIR.'/common/'.$thumb_img_blank;
						$tag_photo_crop = '';

						if($row->wr_idx)
						{
							$file_row = $this->basic_model->get_common_row('row','*','file_manager',FALSE,FALSE,FALSE,array('wr_table'=>$bo_code, 'wr_table_idx'=>$row->wr_idx, 'upload_type' => 'form', 'file_type'=>'image','gubun'=>'list'),FALSE,'idx desc',1);

							//print_r($file_row);
							//echo $this->db->last_query();

							if(! empty($file_row)) {
								$thumb_img = resize_thumb_image($file_row->file_name, $file_row->file_dir, $file_row->file_dir.'/thumb', '600','400',false,'width');

								$thumb_src = resize_thumb_image($file_row->file_name, $file_row->file_dir, $file_row->file_dir.'/thumb', '600','400',false,'width','src');
								
								$썸네일이미지_src = $thumb_src;

								$tag_photo = resize_thumb_image($file_row->file_name, $file_row->file_dir, $file_row->file_dir.'/thumb', '600','400',false,'width');



								$thumb_img_crop = resize_thumb_image($file_row->file_name, $file_row->file_dir, $file_row->file_dir.'/thumb', '600,0','400,0',true,'width');
								$thumb_src_crop = resize_thumb_image($file_row->file_name, $file_row->file_dir, $file_row->file_dir.'/thumb', '600,0','400,0',true,'width','src');

								$tag_photo_crop = resize_thumb_image($file_row->file_name, $file_row->file_dir, $file_row->file_dir.'/thumb', '600,0','400,0',true,'width');

							}

						}


						// 그래도 썸네일 이미지가 없으면, 기본 디폴트 이미지
						if('' == $썸네일이미지_src) {
							$썸네일이미지_src = IMG_DIR.'/common/'.$thumb_img_blank;
						}


						$result['qry'][$i]->thumb_src_2020 = $썸네일이미지_src; // 기존 디비에 등록된 이미지


						$result['qry'][$i]->thumb_img = $thumb_img;
						$result['qry'][$i]->thumb_src = $thumb_src;

						$result['qry'][$i]->thumb_img_crop = $thumb_img_crop;
						$result['qry'][$i]->thumb_src_crop = $thumb_src_crop;

						// 작성자 정보
						$uacc = $this->basic_model->get_common_row('row','nickname','users',FALSE,FALSE,FALSE,array('id'=>$row->user_idx));
						if(isset($uacc->nickname)) {
							$result['qry'][$i]->wr_name = $uacc->nickname;
						}

						// 컨텐츠 텍스트만 컷
						$result['qry'][$i]->wr_content_cut = cut_str(remove_tags($row->wr_content),160);
						$result['qry'][$i]->wr_content = $row->wr_content;


						$tag_video = get_video_tag($row->wr_content,'800px','auto');
						if('' !== $tag_video) {
							$icon_bbs = 'video';
						}
						elseif('' !== $tag_photo) {
							$icon_bbs = 'photo';
						}
						else {
							$icon_bbs = 'text';
						}

						$result['qry'][$i]->icon_bbs = $icon_bbs;
						$result['qry'][$i]->tag_video = $tag_video;
						$result['qry'][$i]->tag_photo = $tag_photo;
						$result['qry'][$i]->tag_photo_crop = $tag_photo_crop;


						$result['qry'][$i]->wr_datetime_point = str_replace('-','. ',substr($row->wr_datetime,0,10));
						$result['qry'][$i]->wr_datetime_en = date("d - F - Y", strtotime($row->wr_datetime));
						$result['qry'][$i]->wr_datetime_en = date("d F, Y", strtotime($row->wr_datetime));

						$wr_datetime_en = date("d F, Y", strtotime($row->wr_datetime));

						$result['qry'][$i]->addfld_1 = $row->addfld_1;


						// 작성자 명
						$wr_name_asta = substr($row->wr_name,0,3) .'*'. substr($row->wr_name,6,3);
						$result['qry'][$i]->wr_name_asta = $wr_name_asta;

						// 24시간 초과 여부 체크
						$chk24h = time() - strtotime($row->wr_datetime);
						$chk24h = (int) ($chk24h / (60*24));

						// new 아이콘 설정
						$bo_use_new_tag = '';
						if($chk24h < 24  &&  $bbs_cf->bo_use_new == 1) {
							//$bo_use_new_tag = '<img src="'. V20_DIR .'/img/new/icon_new.png" width="10" align="absmiddle" alt="새글">';
							$bo_use_new_tag = '<span><i class="icon uil uil-asterisk color-primary"></i></span>';
						}
						$result['qry'][$i]->bo_use_new_tag = $bo_use_new_tag;
						//echo $chk24h.'/'.$chk24h/60/60;
						//echo '<br />';







						// 비밀번호 입력창 팝업
						$password_popup = "";
						if($row->opt_secret > 0){
							if(! $this->tank_auth->is_logged_in()  &&  $row->user_idx < 1) { // 비로그인 && 비로그인작성시 user_idx 값은 0

								// 비회원 비밀글
								$ss_password_name = 'ss_bbs_password';
								if (! $this->session->userdata($ss_password_name)) {
									//$this->session->set_userdata($ss_password_name, time());
									//redirect( $this->bbs_code_url .'/password/'.$wr_idx.'/'.$page_ttl.'/'.$page );
									$password_popup = ' onclick="set_action(\''.$bo_code.'\','.$row->wr_idx.','.$page.'); return false;" data-toggle="modal" data-target="#modal-3"  ';
								}
								else {
									// 비번 입력하고 패스~
									$this->session->set_userdata($ss_password_name, FALSE);
								}

							}
							elseif((! $this->tank_auth->is_logged_in()) || ((isset($this->user->id) && ($this->user->id !== $row->user_idx)) && ! $this->tank_auth->is_admin()) ) {
								//alert('권한이 없습니다.');
								//exit;
							}
						}

						$result['qry'][$i]->password_popup = $password_popup;



						$href = $bbs_code_url.'/detail/'.$row->wr_idx;
						$wr_subject = $row->wr_subject;
						$ca_code = $row->ca_code;

						/*
						$html .= '<div class="col-12 col-md-6 col-lg-4 dx-isotope-grid-item '.$ca_code.'">
									<div class="dx-blog-item dx-box mb-30">
										<a href="'.$href.'" class="dx-blog-item-img">
											<img src="'.$thumb_src.'" alt="">
										</a>

										<div class="dx-blog-item-cont h100">
											<h6 class="dx-blog-item-title">
												<a href="'.$href.'">'.$wr_subject.'</a>
											</h6>
										</div>
									</div>
								</div>';
						*/


						$html .= '
							<div class=" grid-item">
								<!--Blog item-->
								<a href="'.$href.'" style="text-decoration:none;">

									<article class="vlt-post vlt-post--style-2">
										<div class="vlt-post__media">
										<img src="'.$thumb_src.'" class="img_effect" style="width:100%;" loading="lazy" />
										</div>
										<div class="vlt-post__content">
											<header class="vlt-post__header">
												<div class="vlt-post-meta"><span>'.$wr_datetime_en.'</span><span class="font-kr-700">'.$row->addfld_1.'</span>
												</div>
												<h3 class="vlt-post-title font-kr-700 bbs-h">'.$wr_subject.'</h3>
											</header>
										</div>
									</article>
								</a>
							</div>';


					// 갱신
					//$more_last = $row->wr_idx;

				}

				//echo $html;

				//echo ('' != $html) ? $html.'#total_page#'.$total_page : '';
				echo $html.'#total_page#'.$total_page;
		}







		// [2020-03-30] [관리자 기능] 게시물 위로, 아래로 기능
		//function move_updown($bo_code=FALSE,$wr_idx=FALSE,$updown=FALSE) {
		function move_updown() {

				// 관리자가 아니면 실행 불가
				if (! $this->tank_auth->is_admin()) {
					return false;
				}

				// jquery ajax 에서 success 의 response 값을 못가져오길래 검색해보니,
				// 요 아래 코드를 ajax 페이지에서 호출하는 페이지에 넣어주라고 함.
				header("Content-type: text/html; charset=utf-8");


				$bo_code = $this->input->post('bo_code',FALSE);
				$bo_table = 'bbs_'.$bo_code;

				$wr_idx = $this->input->post('idx',FALSE);
				$updown = $this->input->post('updown',FALSE);

				if($wr_idx) {

					$row = $this->basic_model->get_common_row('row','*',$bo_table,FALSE,FALSE,FALSE,array('wr_idx'=>$wr_idx));
					//print_r($row);

					$ord_cur = $row->ORD;
					$idx_cur = $row->wr_idx;

					if('up' == $updown) {
						$row_up = $this->basic_model->get_common_row('row','*',$bo_table,FALSE,FALSE,FALSE,array('ORD >'=>$ord_cur),FALSE,'ORD ASC',1);
						if( isset($row_up->ORD) ) {

							// 위에 글이 있으면.. ORD 번호 맞교환
							$ord_up = $row_up->ORD;
							$idx_up = $row_up->wr_idx;

							// 현재 글의 ORD 값을 위에 있는 글과 바꾸고..
							$this->db->where('wr_idx', $idx_cur);
							$res = $this->db->update($bo_table, array('ORD'=>$ord_up));

							// 위에 있는 글의 ORD 값을 현재 글의 값과 바꾼다.
							$this->db->where('wr_idx', $idx_up);
							$res = $this->db->update($bo_table, array('ORD'=>$ord_cur));

							echo 'success';
						}
						else {
							// 더 이상 위에 글이 없으면
							echo 'top';
						}
					}
					else {
						$row_down = $this->basic_model->get_common_row('row','*',$bo_table,FALSE,FALSE,FALSE,array('ORD <'=>$ord_cur),FALSE,'ORD DESC',1);

						if( isset($row_down->ORD) ) {

							// 아래에 글이 있으면.. ORD 번호 맞교환
							$ord_down = $row_down->ORD;
							$idx_down = $row_down->wr_idx;

							// 현재 글의 ORD 값을 아래에 있는 글과 바꾸고..
							$this->db->where('wr_idx', $idx_cur);
							$res = $this->db->update($bo_table, array('ORD'=>$ord_down));

							// 아래에 있는 글의 ORD 값을 현재 글의 값과 바꾼다.
							$this->db->where('wr_idx', $idx_down);
							$res = $this->db->update($bo_table, array('ORD'=>$ord_cur));

							echo 'success';
						}
						else {
							// 더 이상 아래에 글이 없으면
							echo 'bottom';
						}
					}

				}
				else {
					echo false;
				}


		}






























	function parse_url_arr($url = false) {

		// jquery ajax 에서 success 의 response 값을 못가져오길래 검색해보니,
		// 요 아래 코드를 ajax 페이지에서 호출하는 페이지에 넣어주라고 함.
		header("Content-type: text/html; charset=utf-8");


		//$url = 'http://2018nextsoft.ipmiracle.net/page/about-ceo';
		//$url = 'https://datalab.naver.com/keyword/realtimeList.naver?where=main';
		//$url = 'http://news1.kr/articles/?3342811';

		$url = $this->input->post('url',FALSE);

		if(! $url) {
			return false;
		}
		
		$parsing_url = BASEURL.$url;
		//echo $parsing_url;
		//exit;

		$str_parse = get_fetch_url($parsing_url);
		//print_r($str_parse);


		$str_fatch = remove_tags_make_arr($str_parse);
		print_r($str_fatch);

	}

	function parsing2text($url = false)
	{
		// jquery ajax 에서 success 의 response 값을 못가져오길래 검색해보니,
		// 요 아래 코드를 ajax 페이지에서 호출하는 페이지에 넣어주라고 함.
		header("Content-type: text/html; charset=utf-8");

		$url = $this->input->post('url',FALSE);
		$parsing_url = BASEURL.$url;

		$parsing_str = get_parsing_to_text($parsing_url);

		echo $parsing_str;
	}


	function get_html_parsing($url = false, $elements=FALSE)
	{
		

		// jquery ajax 에서 success 의 response 값을 못가져오길래 검색해보니,
		// 요 아래 코드를 ajax 페이지에서 호출하는 페이지에 넣어주라고 함.
		header("Content-type: text/html; charset=utf-8");

		$url = $this->input->post('url',FALSE);
		$parsing_url = BASEURL.$url;

		if(! $elements) {
			$elements = $this->input->post('elements',FALSE);
		}

		$parsing_str = get_text_from_url($parsing_url,$elements);

		echo $parsing_str;
	}

	function parsing($url = false)
	{

		// jquery ajax 에서 success 의 response 값을 못가져오길래 검색해보니,
		// 요 아래 코드를 ajax 페이지에서 호출하는 페이지에 넣어주라고 함.
		header("Content-type: text/html; charset=utf-8");

		$url = $this->input->post('url',FALSE);

		if(! $url) {
			return false;
		}
		
		$parsing_url = BASEURL.$url;
		//echo $parsing_url;
		//exit;


		// curl이 설치 되었는지 확인
		if (function_exists('curl_init')) {
		   // curl 리소스를 초기화
		   $ch = curl_init(); 

		   // url을 설정
		   curl_setopt($ch, CURLOPT_URL, $parsing_url); 

		   // 헤더는 제외하고 content 만 받음
		   curl_setopt($ch, CURLOPT_HEADER, 0); 

		   // 응답 값을 브라우저에 표시하지 말고 값을 리턴
		   curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 

		   // 브라우저처럼 보이기 위해 user agent 사용
		   curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.7.5) Gecko/20041107 Firefox/1.0'); 

		   $content = curl_exec($ch); 

		   // 리소스 해제를 위해 세션 연결 닫음
		   curl_close($ch);
		} else {
		   // curl 라이브러리가 설치 되지 않음. 다른 방법 알아볼 것
		}

		echo $content;

	}









	function sms_auth() {
	
		$curl = curl_init();

			curl_setopt_array($curl, array(
			CURLOPT_URL => "https://sms.gabia.com/oauth/token",
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => false,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "POST",
			CURLOPT_POSTFIELDS => "grant_type=client_credentials",
			CURLOPT_HTTPHEADER => array(
			  "Content-Type: application/x-www-form-urlencoded",
			  "Authorization: Basic ".base64_encode('eos2020:b1cd20ea8d66bdaedbe2041390ddbda3')
			),
			));


		/*
			{"access_token":"eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJpc3MiOiJodHRwczpcL1wvc21zLmdhYmlhLmNvbVwvIiwiYXVkIjoiXC9vYXV0aFwvdG9rZW4iLCJleHAiOjE1OTQ4MzE1NTAsImNyZWF0ZWRfYXQiOjE1OTQ4Mjc5NTAsInVzZXJfaWQiOiJlb3MyMDIwIiwiY2xpZW50X2lwIjoiMjIyLjIzOS45MS4yNTEifQ.E___TKJu5uTer2Pb2XQxXz5tzAf9UzDxFqxUuF7oTyF_AVH07ZVFtQVUi87XUgMUzRpZ3GGTx7fBrr9DAySRyB6j9eLHuoUgeGj8z16rgGzt5N9Bgi-4mnWWZxsxugyBtML-6imVHwCylNEe2HOAfwyKroCv3EfD3OZz9FI5qKZiM0JlZxscxeX8GkWLj5DNTJDEHvUbjSOUA_zJ1slWSMLByGTFjGcuk_QN40Ja08k2sxd8x0Ld1YkkJnzAxgGxGZVfnjyXOf7EgW9SwW293EGf3QswfToZC8uJPEYay0Eb6YLyVxtujcXnET6kVhseaAD9UOAF17OxvFKoLEo7IA"
			,"refresh_token":"eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJpc3MiOiJodHRwczpcL1wvc21zLmdhYmlhLmNvbVwvIiwiYXVkIjoiXC9vYXV0aFwvdG9rZW4iLCJleHAiOjE1OTQ4NDk1NTAsImNyZWF0ZWRfYXQiOjE1OTQ4Mjc5NTAsImlzX3JlZnJlc2giOnRydWUsInVzZXJfaWQiOiJlb3MyMDIwIiwiY2xpZW50X2lwIjoiMjIyLjIzOS45MS4yNTEiLCJkYXRhIjpbXX0.ld0sXXixJA_mgzkMu92igzubmJfWiW09dYCzE51muigyWa-lj5TO6bmAwqDfcF_OKHHGj1jZ8aK-P-Ng7MD_Jc7L-eBhhD2Cn_1IcAkTN5Z9Kh61p5Ji1eP-1rec5KMssxGjwiYZWtJNBF5uwj1Lw1QC9A0pOLd_AYTwGnJ3JAkNPX51sQBkYUfG7i9r-TfkDcMqrsN_NbzfEEZudZjoJFldbJzw0Ct1Qt_fMyaqlJ0s4EEE6bMDJ5-1rqO3QiYsftUMSHKY4tw8ATDgOdYu5EmSHxGSUW1LDHhz55OUC_eGomWw43g36oRRB_0wX1TG2nf9Nb35H1wYpAgOeNSusg"
			,"expires_in":900
			,"scope":"basic"
			,"create_on":"2020-07-16 00:45:50"
			,"is_expires":"N"
			,"token_type":"basic"
			,"code":"basic"}
		*/


		$response = curl_exec($curl);
		$err = curl_error($curl);

		//$auth_json = json_decode($response);
		//print_r($auth_json);
		//echo '<hr />';

		curl_close($curl);

		/*
		if ($err) {
		echo "cURL Error #:" . $err;
		} else {
		echo $response;
		}
		*/

		if ($err) {
			return "cURL Error #:" . $err;
		} else {
			return $response;
		}
	}

	function sms_send($rcv_phone,$callback='0234542080',$message,$refkey) {

		// $key = base64_encode('eos2020:eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJpc3MiOiJodHRwczpcL1wvc21zLmdhYmlhLmNvbVwvIiwiYXVkIjoiXC9vYXV0aFwvdG9rZW4iLCJleHAiOjE1OTQ4MzE1NTAsImNyZWF0ZWRfYXQiOjE1OTQ4Mjc5NTAsInVzZXJfaWQiOiJlb3MyMDIwIiwiY2xpZW50X2lwIjoiMjIyLjIzOS45MS4yNTEifQ.E___TKJu5uTer2Pb2XQxXz5tzAf9UzDxFqxUuF7oTyF_AVH07ZVFtQVUi87XUgMUzRpZ3GGTx7fBrr9DAySRyB6j9eLHuoUgeGj8z16rgGzt5N9Bgi-4mnWWZxsxugyBtML-6imVHwCylNEe2HOAfwyKroCv3EfD3OZz9FI5qKZiM0JlZxscxeX8GkWLj5DNTJDEHvUbjSOUA_zJ1slWSMLByGTFjGcuk_QN40Ja08k2sxd8x0Ld1YkkJnzAxgGxGZVfnjyXOf7EgW9SwW293EGf3QswfToZC8uJPEYay0Eb6YLyVxtujcXnET6kVhseaAD9UOAF17OxvFKoLEo7IA');


		$auth_json = json_decode($this->sms_auth());
		$key = base64_encode('eos2020:'.$auth_json->access_token);


		/*
		$rcv_phone = '01032616320';
		$callback = '0234542080';
		$message = 'SMS%20TEST%20MESSAGE';
		$refkey = 'RESTAPITEST'.date('Y-m-d H:i:s');
		*/

		$rcv_phone = str_replace('-','',trim($rcv_phone));
		$callback = str_replace('-','',trim($callback));
		$message = $message ? $message : '';
		$refkey = $refkey ? $refkey.date('Y-m-d H:i:s') : 'RESTAPITEST'.date('Y-m-d H:i:s');

		if('' != $message) 
		{


				$curl = curl_init();

				curl_setopt_array($curl, array(
				CURLOPT_URL => "https://sms.gabia.com/api/send/sms",
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => "",
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 0,
				CURLOPT_FOLLOWLOCATION => false,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => "POST",
				CURLOPT_POSTFIELDS => "phone=".$rcv_phone."&callback=".$callback."&message=".$message."&refkey=".$refkey,
				CURLOPT_HTTPHEADER => array(
				  "Content-Type: application/x-www-form-urlencoded",
				  "Authorization: Basic ".$key
				),
				));

				$response = curl_exec($curl);
				$err = curl_error($curl);

				curl_close($curl);

				if ($err) {
				echo "cURL Error #:" . $err;
				} else {
				echo $response;
				}

		}

		/*
			{"code":"200","message":"Success","data":{"BEFORE_SMS_QTY":"1000","AFTER_SMS_QTY":"999","INSERT_ID":14086956}}
		*/

	}









    /** -----------------------------------------------------------------------------------------------------------
     | 일정 리스트
     |  ------------------------------------------------------------------------------------------------------------
     */
	function calendar_view_date_list() {

		$category= $this->input->post('category');
		$date= $this->input->post('date');
		//$date_str = explode('-',$date);

		//$sql = array('cal_category' => $category, 'cal_date' => $date);
		$sql = array('cal_category' => $category, 'cal_date <=' => $date, 'cal_date_end >=' => $date);
		$result = $this->Calendar_model->view_date_lists($sql);

		$html_date = "";
		$html_date = "<ul class='calendar_list' style='padding-left:15px;'>";
		$no = 1;
		foreach($result['qry'] as $row) {
			//$html_date .= "<li style='padding:2px 0; list-style:none;'>".$no.". [".$row['cal_date']."] <a id='cal_list_".$row['cal_no']."' class='cal_font'  href='#' onclick='view_cal_detail(".$row['cal_no'].")'> ".$row['cal_title']."</a></li>";

			$cal_date_html = $row['cal_date'];
			if($row['cal_date'] != $row['cal_date_end'] && $row['cal_date_end'] != '0000-00-00' && $row['cal_date_end'] != NULL) {
				$cal_date_html .= ' ~ '.$row['cal_date_end'];
			}

			$html_date .= "<li style='padding:0 0 20px 0; list-style:none;'><div style='color:#666666;font-size:16px;'>".$cal_date_html."</div> <a id='cal_list_".$row['cal_no']."' class='cal_font' style='font-size:16px; color:#0070bd;'  href='#' onclick='view_cal_detail(".$row['cal_no'].")'> ".$row['cal_title']."</a></li>";


			$no++;
		}
		$html_date .= "</ul>";

		echo $html_date;

	} // END function view_date_list()


	function calendar_view_date_list_main() {

		$category= $this->input->post('category');
		$date= $this->input->post('date');
		$date_str = explode('-',$date);
		$srh_year = $date_str[0];
		$srh_month = $date_str[1];
		$srh_date = $date_str[2];


		//$sql = array('cal_category' => $category, 'cal_date' => $date);
		$sql = array('cal_category' => $category, 'cal_date <=' => $date, 'cal_date_end >=' => $date);
		$result = $this->Calendar_model->view_date_lists($sql);

		$html_date = "";
		//$html_date = "<ul class='calendar_list' style='padding-left:10px;'>";
		$html_date = "<ul class='calendar_list' style='list-style:none; padding:0;'>";

		$no = 1;
		foreach($result['qry'] as $row) {
			//$html_date .= "<li style='padding:2px 0; list-style:none;'>[".$row['cal_date']."]<br /><a id='cal_list_".$row['cal_no']."' class='cal_font'  href='/calendar/lists/".$category."/".$srh_year."/".$srh_month."/".$srh_date."'> ".$row['cal_title']."</a></li>";

			//$html_date .= "<li style='padding:20px 0 0 0; list-style:none;'><div style='color:#666666;font-size:16px;'>".$row['cal_date']."</div> <a id='cal_list_".$row['cal_no']."' class='cal_font' style='font-size:16px; color:#0070bd;'  href='#' onclick='view_cal_detail(".$row['cal_no'].")'> ".$row['cal_title']."</a></li>";

			$cal_date_html = $row['cal_date'];
			if($row['cal_date'] != $row['cal_date_end'] && $row['cal_date_end'] != '0000-00-00' && $row['cal_date_end'] != NULL) {
				$cal_date_html .= ' ~ '.$row['cal_date_end'];
			}

			$html_date .= "<li style='padding:0 0 20px 0; list-style:none;'><div style='color:#666666;font-size:16px;'>".$cal_date_html."</div> <a id='cal_list_".$row['cal_no']."' class='cal_font' style='font-size:16px; color:#0070bd;'  href='/calendar/lists/icvt/s_".$row['cal_no']."'> ".$row['cal_title']."</a></li>";

			$no++;
		}
		$html_date .= "</ul>";

		//$html_date .= "<a href='/calendar/lists/icvt' style='position:absolute; top:0; right:0;'><img src='". IMG_DIR ."/icvt1365/main_schedule_back.png' ></a>";

		echo $html_date;

	} // END function view_date_list()




	function calendar_view_date_detail() {

		$cno= $this->input->post('cno');

		$row = $this->Calendar_model->view_date_detail($cno);

		$cal_date_html = $row['cal_date'];
		if($row['cal_date'] != $row['cal_date_end'] && $row['cal_date_end'] != '0000-00-00' && $row['cal_date_end'] != NULL) {
			$cal_date_html .= ' ~ '.$row['cal_date_end'];
		}

		$html_date = "<table class='calendar_detail'>";
		$html_date .= "<tr><th> 날 짜 </th><td>".$cal_date_html."</td></tr>";
		$html_date .= "<tr><th> 제 목 </th><td>".$row['cal_title']."</td></tr>";
		$html_date .= "<tr><th> 내 용 </th><td>".$row['cal_content']."</td></tr>";
		$html_date .= "</table>";

		echo $html_date;

	} // END function view_date_detail()








	// 랜딩 페이지들 엑셀 변환
	function excel_download_land($pidx=FALSE, $srh_encode=FALSE)
	{

		if(! $pidx) {
			return FALSE;
		}



		$sql_where = array('PIDX' => $pidx,'DELYN'=>'N');

		// 접수기간 검색
		$srh_decode = urldecode($srh_encode);
		$srh_arr = explode('~',$srh_decode);
		$sdate = (isset($srh_arr[0]) && '' != $srh_arr[0]) ? $srh_arr[0] : '';
		$edate = (isset($srh_arr[1]) && '' != $srh_arr[1]) ? $srh_arr[1] : '';

		if('' != $sdate && '' != $edate) {
			$sql_where['REGDATE >='] = $sdate;
			$sql_where['REGDATE <='] = $edate;
		}

		$arr = array(
				'sql_select'     => '*',
				'sql_from'       => 'TBL_LAND_REQ',

				'like_field'      => $this->input->post('search_field',FALSE),
				'like_match'      => $this->input->post('search_text',FALSE),
				'like_side'      => 'both',

				'sql_where'      => $sql_where,
				'sql_order_by'   => 'REGDATE DESC, IDX DESC'
		);
		$result = $this->basic_model->arr_get_result($arr);





		//load our new PHPExcel library
		$this->load->library('excel');
		//activate worksheet number 1
		$this->excel->setActiveSheetIndex(0);
		//name the worksheet
		$this->excel->getActiveSheet()->setTitle('신청자 목록 다운로드');

		//set cell A1 content with some text
		$this->excel->getActiveSheet()->setCellValue('A1', '번호');
		$this->excel->getActiveSheet()->setCellValue('B1', '구분');
		$this->excel->getActiveSheet()->setCellValue('C1', '문의자');
		$this->excel->getActiveSheet()->setCellValue('D1', '연락처');
		$this->excel->getActiveSheet()->setCellValue('E1', '이메일');
		$this->excel->getActiveSheet()->setCellValue('F1', '내용');
		$this->excel->getActiveSheet()->setCellValue('G1', '처리유무');
		$this->excel->getActiveSheet()->setCellValue('H1', '접수일자');

		//change the font size
		//$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(20);
		$this->excel->getActiveSheet()->getStyle('A1:H1')->getFont()->setSize(10);

		//make the font become bold
		//$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->getStyle('A1:H1')->getFont()->setBold(true);

		$this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
		$this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(12);
		$this->excel->getActiveSheet()->getColumnDimension('H')->setWidth(20);

		//merge cell A1 until D1
		//$this->excel->getActiveSheet()->mergeCells('A1:D1');

		//set aligment to center for that merged cell (A1 to D1)
		//$this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle('A1:H1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

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

			$state_str = '전화확인';
			if('Y' == $o->STATE) {
				$state_str = '처리완료';
			}
			


			$mobile_hpn = $o->MOBILE;
			if(strlen($o->MOBILE) == 10) {
				$mobile_hpn = substr($o->MOBILE,0,3);
				$mobile_hpn .= '-'.substr($o->MOBILE,3,3);
				$mobile_hpn .= '-'.substr($o->MOBILE,6,4);
			}
			else {
				$mobile_hpn = substr($o->MOBILE,0,3);
				$mobile_hpn .= '-'.substr($o->MOBILE,3,4);
				$mobile_hpn .= '-'.substr($o->MOBILE,7,4);
			}


			$this->excel->getActiveSheet()->setCellValue('A'.$ino, $num);
			$this->excel->getActiveSheet()->setCellValue('B'.$ino, $o->GUBUN);
			$this->excel->getActiveSheet()->setCellValue('C'.$ino, $o->REGNAME);
			$this->excel->getActiveSheet()->setCellValue('D'.$ino, $mobile_hpn);
			$this->excel->getActiveSheet()->setCellValue('E'.$ino, $o->EMAIL);
			$this->excel->getActiveSheet()->setCellValue('F'.$ino, $o->CTIME);
			$this->excel->getActiveSheet()->setCellValue('G'.$ino, $state_str);
			$this->excel->getActiveSheet()->setCellValue('H'.$ino, $o->REGDATE);
		}

		//$filename='just_some_random_name.xls'; //save our workbook as this file name
		$filename='landing_'.$pidx.'.xls'; //save our workbook as this file name

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




	// 랜딩 엑셀 변환 FAST
	function dnExcelXml_land($pidx=FALSE, $srh_encode=FALSE)
	{

		if(! $pidx) {
			return FALSE;
		}

		$sql_where = array('PIDX' => $pidx,'DELYN'=>'N');

		// 접수기간 검색
		$srh_decode = urldecode($srh_encode);
		$srh_arr = explode('~',$srh_decode);
		$sdate = (isset($srh_arr[0]) && '' != $srh_arr[0]) ? $srh_arr[0] : '';
		$edate = (isset($srh_arr[1]) && '' != $srh_arr[1]) ? $srh_arr[1] : '';

		if('' != $sdate && '' != $edate) {
			$sql_where['REGDATE >='] = $sdate;
			$sql_where['REGDATE <='] = $edate;
		}

		$arr = array(
				'sql_select'     => '*',
				'sql_from'       => 'TBL_LAND_REQ',

				'like_field'      => $this->input->post('search_field',FALSE),
				'like_match'      => $this->input->post('search_text',FALSE),
				'like_side'      => 'both',

				'sql_where'      => $sql_where,
				'sql_order_by'   => 'REGDATE DESC, IDX DESC'
		);
		$result = $this->basic_model->arr_get_result($arr);


		set_time_limit(0);
		ini_set('memory_limit','-1');
		$this->load->library('excelxml');

		$this->excelxml->docAuthor('eoseye');
	
		$sheet = $this->excelxml->addSheet('sheet1');

		
		$format_header = $this->excelxml->addStyle('StyleHeader');
		$format_header->fontSize(10);
		$format_header->fontBold();
		//$format_header->bgColor('#333333');
		//$format_header->fontColor('#FFFFFF');
		$format_header->alignHorizontal('Center');
		$format_header->alignVertical('Center');
		$format_header->border();


		$sheet->writeString(1,1,'번호','StyleHeader');
		$sheet->writeString(1,2,'구분','StyleHeader');
		$sheet->writeString(1,3,'문의자','StyleHeader');
		$sheet->writeString(1,4,'연락처','StyleHeader');
		$sheet->writeString(1,5,'이메일','StyleHeader');
		$sheet->writeString(1,6,'내용','StyleHeader');
		$sheet->writeString(1,7,'처리유무','StyleHeader');
		$sheet->writeString(1,8,'접수일자','StyleHeader');
	
		$sheet->columnWidth(3,60);
		$sheet->columnWidth(4,80);
		$sheet->columnWidth(8,100);


		$format_body = $this->excelxml->addStyle('StyleBody');
		$format_body->alignWraptext();
		$format_body->fontSize(10);
		//$format_body->fontBold();
		//$format_body->bgColor('#333333');
		//$format_body->fontColor('#FFFFFF');
		$format_body->alignHorizontal('Center');
		$format_body->alignVertical('Center');
		$format_body->border();

		//set cell others content with some text
		foreach($result['qry'] as $i => $o)
		{

			// 번호
			//$num = ($result['total_count'] - $limit*($page-1) - $i);
			$num = $i + 1;

			$ino = $i + 2;

			$state_str = '전화확인';
			if('Y' == $o->STATE) {
				$state_str = '처리완료';
			}
		
			$mobile_hpn = $o->MOBILE;
			if(strlen($o->MOBILE) == 10) {
				$mobile_hpn = substr($o->MOBILE,0,3);
				$mobile_hpn .= '-'.substr($o->MOBILE,3,3);
				$mobile_hpn .= '-'.substr($o->MOBILE,6,4);
			}
			else {
				$mobile_hpn = substr($o->MOBILE,0,3);
				$mobile_hpn .= '-'.substr($o->MOBILE,3,4);
				$mobile_hpn .= '-'.substr($o->MOBILE,7,4);
			}


			$sheet->writeString($ino,1,$num,'StyleBody');
			$sheet->writeString($ino,2,$o->GUBUN,'StyleBody');
			$sheet->writeString($ino,3,$o->REGNAME,'StyleBody');
			$sheet->writeString($ino,4,$mobile_hpn,'StyleBody');
			$sheet->writeString($ino,5,$o->EMAIL,'StyleBody');
			$sheet->writeString($ino,6,$o->CTIME,'StyleBody');
			$sheet->writeString($ino,7,$state_str,'StyleBody');
			$sheet->writeString($ino,8,$o->REGDATE,'StyleBody');

			//$sheet->cellWidth($ino,4,200)
		
		}


		$filename='landing_'.$pidx.'.xls'; //save our workbook as this file name
	
		$this->excelxml->sendHeaders($filename);
		$this->excelxml->writeData();
	}


	// 배너관리
	function get_banner_info() {

		// jquery ajax 에서 success 의 response 값을 못가져오길래 검색해보니,
		// 요 아래 코드를 ajax 페이지에서 호출하는 페이지에 넣어주라고 함.
		header("Content-type: text/html; charset=utf-8");

		$bn_code = $this->input->post('bn_code');
		$arr = array(
				'sql_select'     => 'bn_name',
				'sql_from'       => 'mng_banner',
				'sql_where'      => array('bn_code'=>$bn_code),
		);
		$row = $this->basic_model->arr_get_row($arr);

		if( isset($row->bn_name) && '' != $row->bn_name ) {
			echo $row->bn_name;
		}

	}


	// 관리자/담당자 구매의뢰 상세에서 제품 재고 검색
	function search_inven_pr() {

		// jquery ajax 에서 success 의 response 값을 못가져오길래 검색해보니,
		// 요 아래 코드를 ajax 페이지에서 호출하는 페이지에 넣어주라고 함.
		header("Content-type: text/html; charset=utf-8");

		$sfl = $this->input->post('sfl');
		$stx = $this->input->post('stx');

		/*
		$sql_arr = array(
				'sql_select'     => '*',
				'sql_from'       => 'erp_pur_req_item',
				'sql_where'      => array('depth'=>$child_depth,$pcate=>$pidx,'disuse'=>NULL),
				'sql_order_by'   => 'order ASC',
		);
		$result_cate = $this->basic_model->arr_get_result($sql_arr);
		*/


			
			$this->db->start_cache();
			//$this->db->join('users AS uacc', 'upro.user_id = uacc.id', 'left outer');
			//$this->db->join('WL_COMPANY AS comp', 'comp.users_fk = uacc.id', 'left outer');
			$this->db->like('inven.'.$sfl, $stx, 'both');
			$this->db->stop_cache();

			$this->db->select('*');
			$this->db->order_by('inven.itm_name', 'ASC');
			$query = $this->db->get('erp_inven AS inven')->result();
			$this->db->flush_cache();

			//echo $this->db->last_query();

			//print_r( $query );

			$html = '<table>';


			$html = '<div class="tbl_basic">';
			$html .= '<table class="table table-hover">';
			$html .= '<thead>';
			$html .= '<tr>';
			$html .= '  <th>사진</th>';
			$html .= '  <th>위치</th>';
			$html .= '  <th>barcode/sku</th>';
			$html .= '  <th>제품명</th>';
			//$html .= '  <th>브랜드</th>';
			$html .= '  <th>유통기한</th>';
			$html .= '  <th>가격</th>';
			$html .= '  <th>수량</th>';
			$html .= '  <th>선택</th>';
			$html .= '</tr>';
			$html .= '</thead>';
			$html .= '<tbody>';

			foreach ($query as $i => $o) {
				$html .= '<tr>';
				$img = ($o->itm_pic_url != '') ? '<img src="'.$o->itm_pic_url.'" style="width:100%; max-width:80px;" />' : '';
				$html .= '  <td>'.$img.'</td>';
				$html .= '  <td>'.$o->location.'</td>';
				$html .= '  <td>'.$o->barcode.'<br />'.$o->sku.'</td>';
				$html .= '  <td><div><span class="badge rounded-pill bg-warning text-dark">'.$o->brand.'</span></div>'.$o->itm_name.'</td>';
				//$html .= '  <td>'.$o->brand.'</td>';
				$html .= '  <td>'.$o->exp_date.'</td>';
				$html .= '  <td class="text-right">'.number_format($o->buy_price).' 원</td>';
				$html .= '  <td>'.$o->itm_qty.'</td>';
				$html .= '  <td><button class="btn btn-dark btn-xs">선택</button></td>';
				$html .= '</tr>';
			}
			$html .= '</tbody>';
			$html .= '<table>';

			echo $html;


	}

























	// ajax calendar 
	function dsp_calendar_prevnext() {

		// jquery ajax 에서 success 의 response 값을 못가져오길래 검색해보니,
		// 요 아래 코드를 ajax 페이지에서 호출하는 페이지에 넣어주라고 함.
			header("Content-type: text/html; charset=utf-8");
			header("Content-Type:application/json");


			$prefs = array (
						'start_day'    => 'sunday',
						'show_next_prev'  => TRUE,
						//'next_prev_url'   => '/page/'.$page_name,
						'day_type'     => 'short'
					);
			$prefs['template'] = '

			   
			   {heading_previous_cell}<div id="cal_ttl" style="width:100%; text-align:center; line-height:60px; "><a href="{previous_url}"><img src="'.IMG_DIR.'/page/calendar_arw1.gif" style="margin-right:10px;margin-bottom:10px;" /></a>{/heading_previous_cell}
			   {heading_title_cell}<span style="font-size:30px;font-weight:700;line-height:40px;">{heading}</span>{/heading_title_cell}
			   {heading_next_cell}<a href="{next_url}"><img src="'.IMG_DIR.'/page/calendar_arw2.gif" style="margin-left:10px;margin-bottom:10px;" /></a></div>{/heading_next_cell}
			   

			   {table_open}<table class="calendar_table" border="0" cellpadding="0" cellspacing="0" style="width:100%;border-top:3px solid #333;">{/table_open}

			   {week_row_start}<tr>{/week_row_start}
			   {week_day_cell}<th>{week_day}</th>{/week_day_cell}
			   {week_row_end}</tr>{/week_row_end}

			   {cal_row_start}<tr>{/cal_row_start}
			   {cal_cell_start}<td>{/cal_cell_start}

			   {cal_cell_content}<div style="cursor:pointer;" {content}><span style="">{day}</span></div>{/cal_cell_content}
			   {cal_cell_content_today}<div style="cursor:pointer;" {content}><span class="highlight strong" style="">{day}</span></div>{/cal_cell_content_today}

			   {cal_cell_no_content}<div style="color:#eee;">{day}</div>{/cal_cell_no_content}
			   {cal_cell_no_content_today}<div style="color:#eee;">{day}</div>{/cal_cell_no_content_today}

			   {cal_cell_blank}&nbsp;{/cal_cell_blank}

			   {cal_cell_end}</td>{/cal_cell_end}
			   {cal_row_end}</tr>{/cal_row_end}

			   {table_close}</table>{/table_close}
			';

			$this->load->library('calendar', $prefs);



			$selected_year = $this->input->post('year',FALSE);
			$selected_month = $this->input->post('month',FALSE);


			if($selected_year == '2022' && $selected_month == '02') {
			  $data = array(
					25  => 'id="cal25" class="cal_date" onclick="select_date_to_time(this,\'2022-02-25\');"',
					26  => 'id="cal26" class="cal_date" onclick="select_date_to_time(this,\'2022-02-26\');"',
					27  => 'id="cal27" class="cal_date" onclick="select_date_to_time(this,\'2022-02-27\');"',
					28  => 'id="cal28" class="cal_date" onclick="select_date_to_time(this,\'2022-02-28\');"',
			  );
			}
			elseif($selected_year == '2022' && $selected_month == '03') {
			  /*
			  $data = array(
					1  => 'id="cal1" class="cal_date" onclick="select_date_to_time(this,\'2022-03-01\');"',
					2  => 'id="cal2" class="cal_date" onclick="select_date_to_time(this,\'2022-03-02\');"',
					3  => 'id="cal3" class="cal_date" onclick="select_date_to_time(this,\'2022-03-03\');"',
					4  => 'id="cal4" class="cal_date" onclick="select_date_to_time(this,\'2022-03-04\');"',
					5  => 'id="cal5" class="cal_date" onclick="select_date_to_time(this,\'2022-03-05\');"',
					6  => 'id="cal6" class="cal_date" onclick="select_date_to_time(this,\'2022-03-06\');"',
			  );
			  */

			  $data = array();

			  # 3/1~3/6
			  for($day=1;$day<=6;$day++) {
				$data += array($day => 'id="cal'.$day.'" class="cal_date" onclick="select_date_to_time(this,\'2022-03-'.$day.'\');"');
			  }

			  # 3/19~3/31
			  for($day=19;$day<=31;$day++) {
				$data += array($day => 'id="cal'.$day.'" class="cal_date" onclick="select_date_to_time(this,\'2022-03-'.$day.'\');"');
			  }

			}
			else {
				$data = array();
			}

			echo $this->calendar->generate($selected_year, $selected_month, $data);

	}


	// 캘린더에서 날짜 선택
	function dsp_calendar_rsv_time() {

		// jquery ajax 에서 success 의 response 값을 못가져오길래 검색해보니,
		// 요 아래 코드를 ajax 페이지에서 호출하는 페이지에 넣어주라고 함.
			header("Content-type: text/html; charset=utf-8");
			header("Content-Type:application/json");

			// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
			// [1/2]
			//$time_part = 3; // [고정] 00~20분, 20~40분, 40~ 00분
			$time_part = 1; // [고정] 한 시간 단위로 할 때

			//$team_cnt = 10;  // [변동] 각 타임파트당 4팀, 또는 10팀
			$team_cnt = 8;  // [변동] 각 타임파트당 4팀, 또는 10팀
			$time_team_total = $time_part * $team_cnt;
			// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

			$date = $this->input->post('date',FALSE);


			// 전체 수
			//$total_cnt = $this->basic_model->get_common_count($sql_from, $sql_where);
			//$chk = $this->board_lib->is_board_available($checkTable,$checkField,$checkValue);

			$html = '';
			for($t=10;$t<=17;$t++) { 
				if($t == 12) continue; // 12시는 점심시간

				$time = $t.':00';

				//$close_diabled = 'disabled';
				//$close_msg = ''; //'(예약 마감)';


				// 예약 마감처리
				$arr_where = array(
						'sql_select'     => '*',
						'sql_from'       => 'rsv_stats',
						'sql_where'      => array('rsv_date'=>$date, 'rsv_time'=>$time)
				);
				$result = $this->basic_model->arr_get_result($arr_where);
				$rsv_time_total = 0; // max 12 (3x4=12), max 30 (3x10=30)
				foreach($result['qry'] as $k => $o) {
					$rsv_time_total += isset($o->rsv_part_num) ? $o->rsv_part_num : 0;
				}
				$close_diabled = '';
				$close_msg = '';
				if($rsv_time_total >= $time_team_total) {
					$close_diabled = 'disabled';
					$close_msg = '(예약 마감)';
				}


				$html .= '<div style="padding-bottom:5px;" >';
				$html .= '	<input type="radio" class="btn-check" name="rsv_time_radio" id="rsv_time-'. $t .'" autocomplete="off">';
				$html .= '	<label class="btn btn-outline-secondary '.$close_diabled.'" for="rsv_time-'. $t .'" style="width:95%; text-align:left;" onclick="select_time_to_part(\''.$date.'\',\''.$time.'\');" '.$close_diabled.'>'. $t .':00 '. $close_msg .'</label>';
				$html .= '</div>';

			}

			echo $html;

	}


	// 예약 시간 radio 리스트에서 시간 선택
	function dsp_calendar_rsv_part() {

		// jquery ajax 에서 success 의 response 값을 못가져오길래 검색해보니,
		// 요 아래 코드를 ajax 페이지에서 호출하는 페이지에 넣어주라고 함.
			header("Content-type: text/html; charset=utf-8");
			header("Content-Type:application/json");

			// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
			// [2/2]
			//$time_part = 3; // [고정] 00~20분, 20~40분, 40~ 00분
			$time_part = 1; // [고정] 한 시간 단위로 할 때

			//$team_cnt = 10;  // [변동] 각 타임파트당 4팀, 또는 10팀
			$team_cnt = 8;  // [변동] 각 타임파트당 4팀, 또는 10팀
			$time_team_total = $time_part * $team_cnt;
			// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

			$date = $this->input->post('date',FALSE);
			$time = $this->input->post('time',FALSE);

			//echo $date.' / '.$time;

			$html = '';

			$time_start = $time;




			/*
			// 한 시간에 3파트 타임
			for($t=0;$t<=2;$t++) 
			{ 
				//$min = ($t == 0) ? '00' : $t * 20;

				// 예약 마감처리
				$arr_where = array(
						'sql_select'     => '*',
						'sql_from'       => 'rsv_stats',
						'sql_where'      => array('rsv_date'=>$date, 'rsv_time'=>$time, 'rsv_part'=>$time_start)
				);
				$row = $this->basic_model->arr_get_row($arr_where);
				$rsv_part_num = isset($row->rsv_part_num) ? $row->rsv_part_num : 0;

				$close_diabled = '';
				$close_msg = '('.$rsv_part_num.'/'.$team_cnt.')';
				if($rsv_part_num >= $team_cnt) {
					$close_diabled = 'disabled';
					$close_msg = '(예약 마감)';
				}


				//$time_start = $time; //'10:'.$min;
				$tstamp = strtotime($time_start) + 20*60;
				$time_end = date('H:i',$tstamp);
				//echo $time_end;

				$html .= '<div style="padding-bottom:5px;" >';
				$html .= '	<input type="radio" class="btn-check" name="rsv_part_radio" id="rsv_part-'. $t .'" autocomplete="off">';
				$html .= '	<label class="btn btn-outline-secondary '.$close_diabled.'" for="rsv_part-'. $t .'" style="width:95%; text-align:left;" onclick="select_part(\''.$time_start.'\');"  '.$close_diabled.'>';
				$html .= '		'. $time_start .' ~ '. $time_end .' &nbsp; '.$close_msg.'';
				$html .= '	</label>';
				$html .= '</div>';

				$time_start = $time_end;

			}
			*/


			// 한 시간 단위
			for($t=0;$t<1;$t++) 
			{ 
				//$min = ($t == 0) ? '00' : $t * 20;

				// 예약 마감처리
				$arr_where = array(
						'sql_select'     => '*',
						'sql_from'       => 'rsv_stats',
						'sql_where'      => array('rsv_date'=>$date, 'rsv_time'=>$time, 'rsv_part'=>$time_start)
				);
				$row = $this->basic_model->arr_get_row($arr_where);
				$rsv_part_num = isset($row->rsv_part_num) ? $row->rsv_part_num : 0;

				$close_diabled = '';
				$close_msg = '('.$rsv_part_num.'/'.$team_cnt.')';
				if($rsv_part_num >= $team_cnt) {
					$close_diabled = 'disabled';
					$close_msg = '(예약 마감)';
				}


				//$time_start = $time; //'10:'.$min;
				$tstamp = strtotime($time_start) + 60*60;
				$time_end = date('H:i',$tstamp);
				//echo $time_end;

				$html .= '<div style="padding-bottom:5px;" >';
				$html .= '	<input type="radio" class="btn-check" name="rsv_part_radio" id="rsv_part-'. $t .'" autocomplete="off">';
				$html .= '	<label class="btn btn-outline-secondary '.$close_diabled.'" for="rsv_part-'. $t .'" style="width:95%; text-align:left;" onclick="select_part(\''.$time_start.'\');"  '.$close_diabled.'>';
				$html .= '		'. $time_start .' ~ '. $time_end .' &nbsp; '.$close_msg.'';
				$html .= '	</label>';
				$html .= '</div>';

				$time_start = $time_end;

			}

			echo $html;

	}



	// 예약 취소
	function cancel_rsv() {

		// jquery ajax 에서 success 의 response 값을 못가져오길래 검색해보니,
		// 요 아래 코드를 ajax 페이지에서 호출하는 페이지에 넣어주라고 함.
			header("Content-type: text/html; charset=utf-8");
			header("Content-Type:application/json");

			$rsv_name = $this->input->post('rsv_name',FALSE);
			$rsv_phone = $this->input->post('rsv_phone',FALSE);

		// 예약 정보
			$arr_where = array(
					'sql_select'     => '*',
					'sql_from'       => 'rsv',
					'sql_where'      => array('name'=>$rsv_name, 'phone'=>$rsv_phone, 'deleted'=>NULL)
			);
			$row = $this->basic_model->arr_get_row($arr_where);

			//echo $this->db->last_query();


			$this->load->library('landing_lib');
			if ( isset($row->idx) && !is_null($data = $this->landing_lib->reserve_del($row->idx))) {		// success
				//alert('삭제가 완료되었습니다.');
				echo 'deleted';
			}
			else {
				echo 'fail';
			}
	}



	// 예약 확인 
	function find_rsv_info() {

		// jquery ajax 에서 success 의 response 값을 못가져오길래 검색해보니,
		// 요 아래 코드를 ajax 페이지에서 호출하는 페이지에 넣어주라고 함.
			header("Content-type: text/html; charset=utf-8");
			header("Content-Type:application/json");

			$rsv_name = $this->input->post('rsv_name',FALSE);
			$rsv_phone = $this->input->post('rsv_phone',FALSE);

			$html = '';

			// 예약 정보
			$arr_where = array(
					'sql_select'     => '*',
					'sql_from'       => 'rsv',
					'sql_where'      => array('name'=>$rsv_name, 'phone'=>$rsv_phone, 'deleted'=>NULL)
			);
			$row = $this->basic_model->arr_get_row($arr_where);

			if( isset($row->rsv_part) ) {

				//$tstamp = strtotime($row->rsv_part) + 20*60;
				$tstamp = strtotime($row->rsv_part) + 60*60;
				$time_end = date('H:i',$tstamp);

				$rsv_time_str = $row->rsv_part.' ~ '.$time_end;

				$phone = array();
				$phone[0] = substr($row->phone,0,3);
				$phone[1] = substr($row->phone,3,4);
				$phone[2] = substr($row->phone,7,4);
				$phone_str = implode('-',$phone);


				$html = '';
				$html .= '<table class="rsv_tbl" width="100%" border="0" cellpadding="0" cellspacing="0" style="border-top:none;">';
				$html .= '	<colgroup>';
				$html .= '		<col width="150px">';
				$html .= '		<col width="*">';
				$html .= '	</colgroup>';
				$html .= '	<tr>';
				$html .= '		<th>예약자</th>';
				$html .= '		<td><span class="rsv_font">'.$row->name.'</span></td>';
				$html .= '	</tr>';
				$html .= '	<tr>';
				$html .= '		<th>연락처</th>';
				$html .= '		<td><span class="rsv_font">'.$phone_str.'</span></td>';
				$html .= '	</tr>';
				$html .= '	<tr>';
				$html .= '		<th>동반인</th>';
				$html .= '		<td><span class="rsv_font">'.$row->partner.'명</span></td>';
				$html .= '	</tr>';
				$html .= '	<tr>';
				$html .= '		<th>예약 날짜</th>';
				$html .= '		<td><span class="rsv_font">'.$row->rsv_date.'</span></td>';
				$html .= '	</tr>';
				$html .= '	<tr>';
				$html .= '		<th>예약 시간</th>';
				$html .= '		<td><span class="rsv_font">'.$rsv_time_str.'</span></td>';
				$html .= '	</tr>';
				$html .= '</table>';

				//$html .= '<div style="padding:50px 0;text-align:center;"><button id="btn_rsv_cancel" class="rsv_cancel" data-cancel_name="'.$rsv_name.'" data-cancel_phone="'.$rsv_phone.'">예약 취소하기</button></div>';

				$html .= '<div style="padding:50px 0;text-align:center;"><button class="rsv_cancel" onclick="rsv_cancel(\''.$row->name.'\',\''.$row->phone.'\')">예약 취소하기</button></div>';

			}
			else {
				$html = '<div style="text-align:center; padding:30px 0;">입력하신 예약자 정보는 신청 되지 않은 정보입니다.<br />방문 예약 신청 페이지에서 신청해 주세요.</div>';

			}

			echo $html;


	}












	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	// 캠페인 & 나눔신청

		// 캠페인 소개 OR 응원댓글
		function sess_cmptab($tab='campaign') {

			$this->session->set_userdata('sess_cmptab', $tab);

			//echo $tab;
			echo $this->session->userdata('sess_cmptab');

			/*
			$cookie = array(
				'name'   => 'sess_cmptab',
				'value'  => '1',
				'expire' => '1440',
				'domain' => '',
				'path'   => '/',
				'prefix' => '',
				'secure' => FALSE
			);

			$this->input->set_cookie($cookie);

			echo '1';
			*/

		}



		// 나눔신청하기 접수내역 삭제
		function delete_state_request_sharecampaign() {

			// jquery ajax 에서 success 의 response 값을 못가져오길래 검색해보니,
			// 요 아래 코드를 ajax 페이지에서 호출하는 페이지에 넣어주라고 함.
			header("Content-type: text/html; charset=utf-8");

			$idx        = $this->input->post('idx');

			$data = array('del_datetime'=>TIME_YMDHIS);
			$this->db->where('idx', $idx);
			if ($this->db->update('req_sharecampaign', $data)) {
				echo $state;
			}
			else {
				echo 'false';
			}
		}




		// 나눔신청하기 접수확인 상태 변경
		function update_state_request_sharecampaign() {

			// jquery ajax 에서 success 의 response 값을 못가져오길래 검색해보니,
			// 요 아래 코드를 ajax 페이지에서 호출하는 페이지에 넣어주라고 함.
			header("Content-type: text/html; charset=utf-8");

			$idx        = $this->input->post('idx');
			$confirm_txt   = $this->input->post('confirm_txt');

			$state = '';
			if($confirm_txt == '미확인') {
				$state = '확인';
			}
			else {
				$state = '미확인';
			}

			$data = array('state'=>$state);
			$this->db->where('idx', $idx);
			if ($this->db->update('req_sharecampaign', $data)) {
				echo $state;
			}
			else {
				echo 'false';
			}
		}




		// [OLD] 나눔신청하기 접수확인 상태 변경
		function _chg_state_goodshare() {

			// jquery ajax 에서 success 의 response 값을 못가져오길래 검색해보니,
			// 요 아래 코드를 ajax 페이지에서 호출하는 페이지에 넣어주라고 함.
			header("Content-type: text/html; charset=utf-8");

			$wr_idx        = $this->input->post('idx');
			$confirm_txt   = $this->input->post('confirm_txt');

			$chg_txt = '';
			if($confirm_txt == '미확인') {
				$chg_txt = '확인';
			}
			else {
				$chg_txt = '미확인';
			}

			$data = array('confirm'=>$chg_txt);
			$this->db->where('wr_idx', $wr_idx);
			if ($this->db->update('bbs_goodshare', $data)) {
				echo $chg_txt;
			}
			else {
				echo 'false';
			}
		}




	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	// 캠페인
		function campaign($type='comment',$mode='write',$idx=FALSE)
		{

			// jquery ajax 에서 success 의 response 값을 못가져오길래 검색해보니,
			// 요 아래 코드를 ajax 페이지에서 호출하는 페이지에 넣어주라고 함.
			header("Content-type: text/html; charset=utf-8");

			if('comment' == $type) 
			{
				if('write' == $mode OR 'update' == $mode OR 'reply' == $mode) {
					//$cmp_idx = $idx;
					$this->cmp_comment_write($idx,$mode);
				}
				elseif('del' == $mode) {
					//$cmt_idx = $idx;
					$this->cmp_comment_del($idx,$mode);
				}
			}

			if('cmpnews' == $type) 
			{
				if('write' == $mode OR 'update' == $mode OR 'reply' == $mode) {
					//$cmp_idx = $idx;
					$this->cmp_news_write($idx,$mode);
				}
				elseif('del' == $mode) {
					//$cmt_idx = $idx;
					$this->cmp_news_del($idx,$mode);
				}
			}




		}


	// 코멘트 쓰기
		private function cmp_comment_write($cmp_idx=FALSE,$mode='write') {

			// jquery ajax 에서 success 의 response 값을 못가져오길래 검색해보니,
			// 요 아래 코드를 ajax 페이지에서 호출하는 페이지에 넣어주라고 함.
			header("Content-type: text/html; charset=utf-8");

			$cmt_content      = $this->input->post('cmt_content');
			$cmt_idx      = $this->input->post('cmt_idx');

			if($res = $this->campaign_lib->cmt_write($mode,$cmp_idx,$cmt_idx,$cmt_content)) {
				if('write' == $mode) {
					echo nl2br($cmt_content);
				}
				elseif('reply' == $mode) {
					print_r( $res );
				}
			}
			exit;
		}

	// 코멘트 쓰기
		private function cmp_comment_del($cmt_idx=FALSE,$mode='del') {

			// jquery ajax 에서 success 의 response 값을 못가져오길래 검색해보니,
			// 요 아래 코드를 ajax 페이지에서 호출하는 페이지에 넣어주라고 함.
			header("Content-type: text/html; charset=utf-8");

			$res = $this->campaign_lib->cmt_del($cmt_idx);

			echo $res;
			exit;
		}



	// 캠페인 모금소식 쓰기
		private function cmp_news_write($cmp_idx=FALSE,$mode='write') {

			// jquery ajax 에서 success 의 response 값을 못가져오길래 검색해보니,
			// 요 아래 코드를 ajax 페이지에서 호출하는 페이지에 넣어주라고 함.
			header("Content-type: text/html; charset=utf-8");

			$cmp_code      = $this->input->post('cmp_code');
			$cmpnews_content      = $this->input->post('cmpnews_content');
			$cmpnews_idx      = $this->input->post('cmpnews_idx');

			if($res = $this->campaign_lib->news_write($mode,$cmp_idx,$cmpnews_idx,$cmpnews_content,$cmp_code)) {
				if('write' == $mode) {
					echo nl2br($cmpnews_content);
				}
			}
			exit;
		}

	// 캠페인 모금소식 쓰기
		private function cmp_news_del($cmpnews_idx=FALSE,$mode='del') {

			// jquery ajax 에서 success 의 response 값을 못가져오길래 검색해보니,
			// 요 아래 코드를 ajax 페이지에서 호출하는 페이지에 넣어주라고 함.
			header("Content-type: text/html; charset=utf-8");

			$res = $this->campaign_lib->news_del($cmpnews_idx);

			echo $res;
			exit;
		}






		// 비영리단체 이름 및 idx 가져오기
		function call_npo_name() {

			// jquery ajax 에서 success 의 response 값을 못가져오길래 검색해보니,
			// 요 아래 코드를 ajax 페이지에서 호출하는 페이지에 넣어주라고 함.
			header("Content-type: text/html; charset=utf-8");
			header("Content-Type:application/json");


			$stx      = $this->input->post('stx');

			if($res = $this->basic_lib->call_npo_name($stx)) {
				//print_r($res);
				echo json_encode($res['qry']);

				//print_r($res);
				//return $res;
			}
			exit;
		}




		// 비영리단체 정보 가져오기
		function call_npo_info() {

			// jquery ajax 에서 success 의 response 값을 못가져오길래 검색해보니,
			// 요 아래 코드를 ajax 페이지에서 호출하는 페이지에 넣어주라고 함.
			header("Content-type: text/html; charset=utf-8");
			header("Content-Type:application/json");

			$idx      = $this->input->post('idx');

			if($res = $this->basic_lib->call_npo_info($idx)) {
				//echo nl2br($cmpnews_content);
				//print_r($res);
				echo json_encode($res);
			}
			exit;
		}


















		function join_npo_byadmin() {


			$this->load->config('tank_auth', TRUE);

			//$this->load->library('session');
			$this->load->database();
			$this->load->model('tank_auth/users');




			$npo_name = $this->input->post('npo_name');
			$npo_manager = $this->input->post('npo_manager');
			$npo_email = $this->input->post('npo_email');
			$npo_tel = $this->input->post('npo_tel');


			
			if (!is_null($res = $this->users->get_user_by_email($npo_email))) {

				// 존재하는 회원
				echo 'exist';

			}
			else {

				// 없는 회원

				// 신규 등록
				if($npo_name & $npo_email)
				{

					$data_pf = array('tel'=>$npo_tel, 'company'=>$npo_name, 'manager'=>$npo_manager);


					$data = array(
						//'user_type'   => $this->input->post('user_type'),
						//'level'       => $this->input->post('user_level'),
						'created'	=> TIME_YMDHIS,
						'activated'	=> '1', //$this->input->post('user_activated'),   // 관리자 회원 등록시 가입인증 처리
						'banned'	=> '',
						'ban_reason'	=> '',
						'last_ip'	=> $this->input->ip_address(),
						'route'	=> '관리자',
						'memo'	=> '협약신청자 NPO회원 가입처리'
					);


					// 신규등록시, level 
					// 회원 구분 [10:일반회원, 20:NPO회원]
					$level = '20';
					$data['level'] = $level;



					/* [2023-11-20] 회원 가입시 아이디를 제외했으므로, 이메일 앞자리와 가입시간을 임시 아이디로 등록한다. */
					if('' !== $npo_email) {
						$arr_email = explode('@',$npo_email);
						$username = $arr_email[0].'_'.date('YmdHis');
						$data['username'] = $username;
					}

					$nickname = $npo_name;
					$data['nickname'] = $nickname;


					if('' !== $npo_email) {
						$data['email'] = $npo_email;
					}

					// 비밀번호를 임시로 이메일로 등록
					if('' !== $npo_email) {

						$password = $npo_email;

						// Hash password using phpass
						$hasher = new PasswordHash(
								$this->config->item('phpass_hash_strength', 'tank_auth'),
								$this->config->item('phpass_hash_portable', 'tank_auth'));
						$hashed_password = $hasher->HashPassword($password);
						$data['password'] = $hashed_password;
					}

					if (!is_null($res = $this->users->create_user_by_admin($data,$data_pf))) {
						$data['user_id'] = $res['user_id'];
						$data['user_idx'] = $res['user_id'];
						unset($data['last_ip']);
						echo $data['user_idx'];
					}

				}


			}

			return NULL;
		}



		// [누적된 사회적 가치 월별 관리] 개별 삭제

		function donated_archive($flag=''){

			if('del' == $flag){

				$idx = $this->input->post('idx');

				/*
				// 완전히 삭제
				$this->db->where('idx', $idx);
				$this->db->delete('donated_archive');
				if ($this->db->affected_rows() > 0) {
					echo 'true';
				}
				else {
					echo 'false';
				}
				*/

				// 삭제일시 업데이트
				$data = array('del_datetime'=>TIME_YMDHIS);
				$this->db->where('idx', $idx);
				if ($this->db->update('donated_archive', $data)) {
					echo 'true';
				}
				else {
					echo 'false';
				}

			}

			return NULL;
		}





		/*
		* [2025-08-13]
		* 캠페인 기부 후, 작업요청이 전송되면 '신청 대기' 상태이므로
		* 수거 신청 버튼을 눌러 실제로 신청을 마무리 해야 함
		* 
		* - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -*/
		function ros_replus_updateWaState(){

			// jquery ajax 에서 success 의 response 값을 못가져오길래 검색해보니,
			// 요 아래 코드를 ajax 페이지에서 호출하는 페이지에 넣어주라고 함.
			header("Content-type: text/html; charset=utf-8");
			header("Content-Type:application/json");

			$idx = $this->input->post('idx',FALSE);
			//$reqState = $this->input->post('reqState',FALSE);
			$reqState = 1;

			$cert_key = 'ub9acud50cub7ecuc2a4u0072u006fu0073uc5f0ub3d9';

			// [개발용 주소] // 로컬 작업용 pc
			//$post_url = 'http://183.99.21.70:8080/replus/updateWaState';  

			// [실제사용주소]
			$post_url = 'https://ros.remann.co.kr/replus/updateWaState'; // ros.remann.co.kr/replus/updateWaState

			$curl_data = array('id'=>$idx,'reqState'=>$reqState,'key'=>$cert_key);
			$output_json = $this->curl_post($post_url, $curl_data);
			$output_arr = json_decode($output_json, true);

			if( isset($output_arr['s']) && $output_arr['s'] == 'SUCCESS' ) {
				// 업데이트
				$this->db->simple_query(" UPDATE donation SET pickup_req_date = '".TIME_YMDHIS."' WHERE idx = ".$idx );
			}

			echo $output_arr['s'];

		}

		/*
		* [2025-08-28]
		* 수거용 택배를 받으면 제품을 담아 반품 진행
		* 수거 신청 버튼을 눌러 실제로 반품접수 신청
		* 
		* - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -*/
		function ros_replus_returnParcel_updateWaState(){

			// jquery ajax 에서 success 의 response 값을 못가져오길래 검색해보니,
			// 요 아래 코드를 ajax 페이지에서 호출하는 페이지에 넣어주라고 함.
			header("Content-type: text/html; charset=utf-8");
			header("Content-Type:application/json");

			$cert_key = 'ub9acud50cub7ecuc2a4u0072u006fu0073uc5f0ub3d9';
			$dn_idx = $this->input->post('dn_idx',FALSE);
			$reqState = $this->input->post('reqState',FALSE);
			//$reqState = 1;




			// 수거 신청 누른 시각 먼저 저장(사용자 입장에서는 수거신청 누르면 무조건 완료처리(단, 1차배송 완료시에만)
			$cjreturn_dt = TIME_YMDHIS;


			// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
			// 0. 기부자 정보
			// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
			$arr = array(
					'sql_select'     => '*',
					'sql_from'       => 'donation',
					'sql_where'      => array('idx'=>$dn_idx),
			);
			$row = $this->basic_model->arr_get_row($arr);

			$donor_name = $row->donor_name;
			$dn_phone = $row->cellphone;
			$zip_no = $row->postcode;
			$addr1 = $row->addr;
			$addr2 = $row->addr_detail;

			// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
			// 1. 택배 반품접수 요청 보내기
			// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
			// [개발용 주소] // 로컬 작업용 pc
			//$post_url = 'http://183.99.21.70:8080/cj/regBook_return';  
			// [실제사용주소]
			$post_url = 'https://ros.remann.co.kr/cj/regBook_return';

			$curl_data = array(
				'id'=>$dn_idx,
				'rcpt_dv' => '02', // 반품은 '02'
				'name'=>$donor_name,
				'phone'=>$dn_phone,
				'zip_no'=>$zip_no,
				'addr1'=>$addr1,
				'addr2'=>$addr2
			);
			//print_r($curl_data);
			//exit;

			$output_json = $this->curl_post($post_url, $curl_data);
			// echo $output_json;
			// exit; 
			/*
			{"data":"f:ORA-00001"}
			*/

			//$output_arr = json_decode($output_json, true);
			//$cjreturn_res = $output_arr['data'];

			$output_arr = json_decode($output_json); // false(기본값)
			$cjreturn_res = isset($output_arr->data) ? $output_arr->data : 'server error';
			//echo $cjreturn_res;
			//exit; 




			// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
			// [임시] [2025-09-08] dn_idx 값 501까지는 수동으로 success 처리.
			// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
			if( $dn_idx <= 501 ) {
				if('W:NotThisTime' == $cjreturn_res) {
					$cjreturn_res = 'success';
					//$output_json = '{"data":"success"}';
				}
			}
			// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -



			// 리턴 값 업데이트(donation > cj_return, cj_return_dt, return_json)
			// 시간 저장
			$this->db->simple_query(" UPDATE donation SET cj_return_dt = '".$cjreturn_dt."' WHERE idx = ".$dn_idx );
			// 리턴 값 저장
			$this->db->simple_query(" UPDATE donation SET cj_return = '".$cjreturn_res."', cj_return_json='".$output_json."' WHERE idx = ".$dn_idx );


			// 성공이 아닌 경우 메모
			if('success' != $cjreturn_res) {
				$this->db->simple_query(" UPDATE donation SET cj_memo='".$output_json."' WHERE idx = ".$dn_idx );
			}

			// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
			// 1-2 택배반품 처리가 되지 않으면 수거신청이 되지 않도록 처리
			// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
			/*
			if('success' != strtolower($cjreturn_res)) {
				//echo 'fail_return||'.$cjreturn_res;
				// - - - - - - - - - - - - - - - - - - - -
				// 실패시, 'f:블라블라' 리턴
				// 발송 후 수령 전이면 : 'W:NotThisTime'
				// - - - - - - - - - - - - - - - - - - - -
				echo $cjreturn_res; 
				exit;
			}
			*/

			/*
			if('success' != strtolower($cjreturn_res)) {
				$tmparr = explode(':',$cjreturn_res);
				if(isset($tmparr[1])){
					if('W' == $tmparr[0]) {
						// 택배 수령 전
					}
					else if('f' == $tmparr[0]) {

					}
					else {

					}
				}
				else {

				}
				exit;
			}
			*/


			// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
			// 2. 작업요청 전송(기부하기) 상태에서 수거 신청 상태로 업데이트
			// 성공시 대문자 SUCCESS 리턴
			// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

			if('success' == strtolower($cjreturn_res)) 
			{

				// [개발용 주소] // 로컬 작업용 pc
				//$post_url = 'http://183.99.21.70:8080/replus/updateWaState';  
				// [실제사용주소]
				$post_url = 'https://ros.remann.co.kr/replus/updateWaState'; // ros.remann.co.kr/replus/updateWaState

				$curl_data = array('id'=>$dn_idx,'reqState'=>$reqState,'key'=>$cert_key);
				$output_json = $this->curl_post($post_url, $curl_data);
				$output_arr = json_decode($output_json, true);
				$res_code = isset($output_arr['s']) ? strtoupper($output_arr['s']) : '';
				if( strtoupper($res_code) == 'SUCCESS' ) {
					// 업데이트
					$this->db->simple_query(" UPDATE donation SET pickup_req_date = '".TIME_YMDHIS."' WHERE idx = ".$dn_idx );

					echo strtoupper($res_code);  // 1. 반품 및 상태 업데이트 성공
					exit;
				}
				else {
					echo $res_code; // 2. 반품은 성공했으나, 업데이트 실패시 [replus/updateWaState] 리턴 메시지 출력
					exit;
				}

			}
			else {
				//echo 'fail_return||'.$cjreturn_res;
				// - - - - - - - - - - - - - - - - - - - -
				// 실패시, 'e:블라블라' 리턴
				// 발송 후 수령 전이면 : 'W:NotThisTime'
				// - - - - - - - - - - - - - - - - - - - -
				echo $cjreturn_res; 
				exit;
			}

		}







		/* [2025] chatgpt 버전 */
		function curl_post($url, $data)
		{
			// 1. 모든 값에 대해:
			//    - 줄바꿈을 \n 으로 치환 (실제 개행 → 문자열)
			//    - UTF-8 인코딩 보장
			foreach ($data as $key => $value) {
				$value = str_replace(["\r\n", "\r", "\n"], "\\n", $value); // 줄바꿈을 문자열 \n으로
				$data[$key] = mb_convert_encoding($value, 'UTF-8', 'auto');
			}

			// 2. 쿼리 문자열로 변환
			$post_field_string = http_build_query($data, '', '&');

			// 3. cURL 설정
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $post_field_string);
			curl_setopt($ch, CURLOPT_HTTPHEADER, [
				'Content-Type: application/x-www-form-urlencoded; charset=UTF-8'
			]);
			curl_setopt($ch, CURLOPT_POST, true);

			$response = curl_exec($ch);

			curl_close($ch);

			return $response;
		}







		// 다시 택배 접수하기
		// [2025-09-08] 택배 접수가 안된 건 자동으로 접수시키기
		function trans_retry_cj_book() {

			// jquery ajax 에서 success 의 response 값을 못가져오길래 검색해보니,
			// 요 아래 코드를 ajax 페이지에서 호출하는 페이지에 넣어주라고 함.
			header("Content-type: text/html; charset=utf-8");
			header("Content-Type:application/json");

			// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
			// 리턴 false
			// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
			//return false;

			$dn_idx = $this->input->post('dn_idx');

			if( $dn_idx > 501 ) {


					// 기부자 정보
					$arr_where = array(
							'sql_select'     => '*',
							'sql_from'       => 'donation',
							'sql_where'      => array('idx'=>$dn_idx, 'delete'=>NULL)
					);
					$dn_row = $this->basic_model->arr_get_row($arr_where);

					//if( isset($dn_row->idx) && ! IS_NULL($dn_row->cj_book) && 'success' != $dn_row->cj_book ) {
					//if( isset($dn_row->idx) && ! IS_NULL($dn_row->cj_book) && 'success' != $dn_row->cj_book ) {
					if( isset($dn_row->idx) && 'success' != $dn_row->cj_book ) {

							// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
							// [2025-08-28]
							// 택배접수 api 
							// 작업요청서 보낸 후, 택배접수 api 전송
							// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
							/*
								id	기부신청id
								rcpt_dv	접수구분 01: 일반, 02: 반품
								name	기부자명
								phone	전화번호(-으로 구분된 연결된전화번호)
								zip_no	우편번호
								addr1	기부자주소
								addr2	기부자상세주소
							*/

							
							// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
							// 택배 신규 접수
							// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
							$rcpt_dv = '01';


							$dn_idx = $dn_row->idx;
							$donor_name = $dn_row->donor_name;
							$dn_phone = $dn_row->cellphone;
							$postcode = $dn_row->postcode;
							$addr = $dn_row->addr;
							$addr_detail = $dn_row->addr_detail;
							// echo $dn_idx.' :: '.$donor_name.'<<<<br />';


							if( '' != $dn_idx) {

								// [개발용 주소] // 로컬 작업용 pc
								//$post_url_cj = 'http://183.99.21.70:8080/cj/regBook';  
								// [실제사용주소]
								$post_url_cj = 'https://ros.remann.co.kr/cj/regBook';

								$curl_data_cj = array(
									'id'=>$dn_idx,
									'rcpt_dv' => $rcpt_dv,
									'name'=>$donor_name,
									'phone'=>$dn_phone,
									'zip_no'=>$postcode,
									'addr1'=>$addr,
									'addr2'=>$addr_detail
								);

								//print_r($curl_data_cj);
								//exit;

								// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - 
								// 택배 접수 보내기
								// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - 
								$output_json = $this->curl_post($post_url_cj, $curl_data_cj); // return 등록한 작업요청id값
								//$this->db->simple_query(" UPDATE donation SET cj_memo='".$output_json."' WHERE idx = ".$dn_idx );

								// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - 
								// 택배 접수 결과 저장
								// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - 
								$resArr = json_decode($output_json);
								$cjbook_res = isset($resArr->data) ? $resArr->data : 'error';
								$cjbook_dt = ('error' != $cjbook_res) ? TIME_YMDHIS : '';

								$this->db->simple_query(" UPDATE donation SET cj_book = '".$cjbook_res."', cj_book_dt = '".$cjbook_dt."', cj_book_json='".$output_json."#admin' WHERE idx = ".$dn_idx );

								print_r($output_json);

							}

							//exit;

					}
					else {
						echo '이미 접수된 상태입니다.';
					}

			}
			else {

				echo '501 이하는 제외합니다:'.$dn_idx;

			}

		}





		// 다시 택배 반품하기
		// [2025-09-08] 택배 반품이 안된 건 자동으로 반품시키기
		function trans_retry_cj_return() {

			// jquery ajax 에서 success 의 response 값을 못가져오길래 검색해보니,
			// 요 아래 코드를 ajax 페이지에서 호출하는 페이지에 넣어주라고 함.
			header("Content-type: text/html; charset=utf-8");
			header("Content-Type:application/json");

			// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
			// 리턴 false
			// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
			//return false;

			$dn_idx = $this->input->post('dn_idx');


			if( $dn_idx > 501 ) {

					// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
					// 0. 기부자 정보
					// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
					$arr = array(
							'sql_select'     => '*',
							'sql_from'       => 'donation',
							'sql_where'      => array('idx'=>$dn_idx, 'delete'=>NULL),
					);
					$dn_row = $this->basic_model->arr_get_row($arr);

					//if( isset($dn_row->idx) && ! IS_NULL($dn_row->cj_return) && 'success' != $dn_row->cj_return ) {
					if( isset($dn_row->idx) && 'success' != $dn_row->cj_return ) {




							// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
							// [2025-08-28]
							// 택배접수 api 
							// 작업요청서 보낸 후, 택배접수 api 전송
							// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
							/*
								id	기부신청id
								rcpt_dv	접수구분 01: 일반, 02: 반품
								name	기부자명
								phone	전화번호(-으로 구분된 연결된전화번호)
								zip_no	우편번호
								addr1	기부자주소
								addr2	기부자상세주소
							*/

							
							// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
							// 택배 신규 접수
							// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
							$rcpt_dv = '02';



							$dn_idx = $dn_row->idx;
							$donor_name = $dn_row->donor_name;
							$dn_phone = $dn_row->cellphone;
							$zip_no = $dn_row->postcode;
							$addr1 = $dn_row->addr;
							$addr2 = $dn_row->addr_detail;



							if( '' != $dn_idx) {

								// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
								// 1. 택배 반품접수 요청 보내기
								// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
								// [개발용 주소] // 로컬 작업용 pc
								//$post_url = 'http://183.99.21.70:8080/cj/regBook_return';  
								// [실제사용주소]
								$post_url = 'https://ros.remann.co.kr/cj/regBook_return';

								$curl_data = array(
									'id'=>$dn_idx,
									'rcpt_dv' => $rcpt_dv, // 반품은 '02'
									'name'=>$donor_name,
									'phone'=>$dn_phone,
									'zip_no'=>$zip_no,
									'addr1'=>$addr1,
									'addr2'=>$addr2
								);
								//print_r($curl_data);
								//exit;

								$output_json = $this->curl_post($post_url, $curl_data);
								// echo $output_json;
								// exit; 
								/*
								{"data":"f:ORA-00001"}
								*/

								//$output_arr = json_decode($output_json, true);
								//$cjreturn_res = $output_arr['data'];

								$output_arr = json_decode($output_json); // false(기본값)
								$cjreturn_res = $output_arr->data;
								//echo $cjreturn_res;
								//exit; 

								$cjreturn_dt = TIME_YMDHIS;

								// 리턴 값 업데이트(donation > cj_return, cj_return_dt, return_json)
								$this->db->simple_query(" UPDATE donation SET cj_return = '".$cjreturn_res."', cj_return_dt = '".$cjreturn_dt."', cj_return_json='".$output_json."#admin' WHERE idx = ".$dn_idx );








								// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
								// 2. 작업요청 전송(기부하기) 상태에서 수거 신청 상태로 업데이트
								// 성공시 대문자 SUCCESS 리턴
								// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

								if('success' == strtolower($cjreturn_res)) 
								{

									$cert_key = 'ub9acud50cub7ecuc2a4u0072u006fu0073uc5f0ub3d9';
									$reqState = 1;

									// [개발용 주소] // 로컬 작업용 pc
									//$post_url = 'http://183.99.21.70:8080/replus/updateWaState';  
									// [실제사용주소]
									$post_url = 'https://ros.remann.co.kr/replus/updateWaState'; // ros.remann.co.kr/replus/updateWaState

									$curl_data = array('id'=>$dn_idx,'reqState'=>$reqState,'key'=>$cert_key);
									$output_json = $this->curl_post($post_url, $curl_data);
									$output_arr = json_decode($output_json, true);
									$res_code = isset($output_arr['s']) ? strtoupper($output_arr['s']) : '';
									if( strtoupper($res_code) == 'SUCCESS' ) {
										// 업데이트
										$this->db->simple_query(" UPDATE donation SET pickup_req_date = '".TIME_YMDHIS."' WHERE idx = ".$dn_idx );

										//echo strtoupper($res_code);  // 1. 반품 및 상태 업데이트 성공
										//exit;
									}
									else {
										//echo $res_code; // 2. 반품은 성공했으나, 업데이트 실패시 [replus/updateWaState] 리턴 메시지 출력
										//exit;
									}

								}
								else {
									//echo 'fail_return||'.$cjreturn_res;
									// - - - - - - - - - - - - - - - - - - - -
									// 실패시, 'e:블라블라' 리턴
									// 발송 후 수령 전이면 : 'W:NotThisTime'
									// - - - - - - - - - - - - - - - - - - - -
									//echo $cjreturn_res; 
									//exit;
								}







								print_r($output_json);


							}

							//exit;

					}
					else {
						echo '이미 반품접수된 상태입니다.';
					}


			}
			else {

				echo '501 이하는 제외합니다::'.$dn_idx;

			}


		}







}

/* End of file Member_tr.php */
/* Location: ./application/controllers/_trans/member_tr.php */