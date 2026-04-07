<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Design extends CI_Controller {

	function __construct()
	{
		parent::__construct();

		// To load the CI benchmark and memory usage profiler - set 1==1.
		if (2==1)
		{
			$sections = array(
				'benchmarks' => TRUE, 'memory_usage' => TRUE,
				'config' => FALSE, 'controller_info' => FALSE, 'get' => FALSE, 'post' => FALSE, 'queries' => FALSE,
				'uri_string' => FALSE, 'http_headers' => FALSE, 'session_data' => FALSE
			);
			$this->output->set_profiler_sections($sections);
			$this->output->enable_profiler(TRUE);
		}

		$this->load->library('tank_auth');
	}

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{

		
		load_css('<link rel="stylesheet" type="text/css" href="'. CSS_DIR .'/minimal.css"/>');

		// 팝업 - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

			$this->load->model('popup_model');
			$popup = $this->popup_model->output();
			$pubasic = $pulayer = array();

			foreach ($popup as $i => $row) {
				$id = $row['pu_id'];
				$skin = 'popup_main_view';

				if ( ! $this->input->cookie('popup'.$id)  &&  file_exists(APPPATH.'views/'.$skin.'.php') ) {
					if ($row['pu_type'] == 1) {
						// 레이어 팝업
						$pulayer[] = "<div id='popup".$id."'  class='ipopuplayer'  style='position:absolute; width:".$row['pu_width']."px; height:".$row['pu_height']."px; top:".$row['pu_y']."px; left:".$row['pu_x']."px; z-index:1000;'>".$this->load->view($skin, array('id'=>'popup'.$id, 'content' => $row['pu_content'], 'pu_type' => $row['pu_type'], 'roundbox' => 'roundbox_4'), TRUE)."</div>";
					}
					else {
						// 일반 팝업
						$pubasic[$i] = new stdClass();
						$pubasic[$i]->pu_type = $row['pu_type'];
						$pubasic[$i]->id = $id;
						$pubasic[$i]->html = "win_open('popup/".$id."', 'popup".$id."', 'left=".$row['pu_x']."px,top=".$row['pu_y']."px,width=".$row['pu_width']."px,height=".$row['pu_height']."px,scrollbars=0');";
					}
				}
			}



		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		// 지금까지 기부된 디지털 기기
			$arr_where = array(
					'sql_select'     => 'gd_type, sum(gd_amt) as tot_amt',
					'sql_from'       => 'donation_goods',
					'sql_where'      => array('idx >'=>0),
					'sql_group_by'    => 'gd_type',
			);
			$device_result = $this->basic_model->arr_get_result($arr_where);
			//print_r($device_result);





		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		// 지금까지 기부참여자, 기부금액(평가금액?? 기부가치금액??)
		$total_donor = $this->basic_model->get_common_count('donation',array('idx >'=>0));
		//echo $total_donor;

		//$total_donation_value = $this->campaign_lib->get_common_count('donation',array('idx >'=>0));
		$arr_where = array(
				'sql_select'     => 'sum(donation_value) as tot_val',
				'sql_from'       => 'donation',
				'sql_where'      => array('idx >'=>0),
		);
		$dnval_row = $this->basic_model->arr_get_row($arr_where);
		//print_r($dnval_row);
		$total_donation_value = $dnval_row->tot_val;


		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		// 최신 캠페인 목록 3개 가져오기
		$arr_where = array(
				'sql_select'     => '*',
				'sql_from'       => 'campaign',
				'sql_where'      => array('state'=>'launch'),
				'sql_order_by'   => 'cmp_term_begin DESC, reg_datetime DESC',
				'limit'          => 5
		);
		$result = $this->basic_model->arr_get_result($arr_where);

		//print_r($result);
		$list = array();
		$ino = 0;
		foreach($result['qry'] as $key => $row) {

			//print_r($row);

			$list[$ino] = new stdClass();

			// 번호
			//$num = ($result['total_count'] - $limit*($page-1) - $ino);
			$num = ($result['total_count'] - $ino);
			$list[$ino]->num = $num;

			$list[$ino]->idx = $row->idx;
			$list[$ino]->code = $row->code;
			$list[$ino]->cmp_title = $row->cmp_title;
			$list[$ino]->cmp_term_begin = $row->cmp_term_begin;
			$list[$ino]->cmp_term_end = $row->cmp_term_end;
			$list[$ino]->cmp_term = $row->cmp_term_begin.'~'.$row->cmp_term_end;

			$list[$ino]->cmp_org_name = $row->cmp_org_name;
			$list[$ino]->cmp_org_info = $row->cmp_org_info;

			$list[$ino]->reg_datetime = $row->reg_datetime;
			$list[$ino]->reg_date = substr($row->reg_datetime,0,10);
			$list[$ino]->state = $row->state;
			$state_str = '<button class="btn o_btn btn-xs btn-silver-flat" disabled>작성</button>';
			if('submit' == $row->state) :
				$state_str = '<button class="btn o_btn btn-xs btn-success-flat">제출</button>';
			elseif('launch' == $row->state) :
				$state_str = '<button class="btn o_btn btn-xs btn-primary-flat">런칭</button>';
			endif;
			$list[$ino]->state_str = $state_str;


			// 대표이미지(목록 및 캠페인 대표 이미지)
			$arr_where = array(
					'sql_select'     => '*',
					'sql_from'       => 'file_manager',
					'sql_where'      => array('wr_table'=>'campaign','wr_table_idx'=>$row->idx,'upload_type'=>'form','file_type'=>'image'),
					'sql_order_by'   => 'idx DESC',
					'limit'          => 1
			);
			$file_row = $this->basic_model->arr_get_row($arr_where);
			$file_idx = isset($file_row->idx) ? $file_row->idx : '';
			$campaign_main_img = '';
			if(! empty($file_row)) {
				$this->load->helper('resize');
				$img_w = '800';
				$img_h = '600';
				$thumb_img = resize_thumb_image($file_row->file_name, $file_row->file_dir, $file_row->file_dir.'/thumb', $img_w,$img_h,FALSE,'auto','img');
				$campaign_main_img = $thumb_img;
			}
			$list[$ino]->file_idx = $file_idx;
			$list[$ino]->campaign_main_img = $campaign_main_img;


			// 목표 기기 수량 총합 [campaign]
			$goal_amt = 0;
			$goal_amt += intVal($row->goal_amt_1);
			$goal_amt += intVal($row->goal_amt_2);
			$goal_amt += intVal($row->goal_amt_3);
			$goal_amt += intVal($row->goal_amt_4);
			$goal_amt += intVal($row->goal_amt_5);
			//echo $goal_amt.'<<<';
			$list[$ino]->goal_amt = $goal_amt;

			// 관리자가 입력한 기기 수량 총합 [donation]
			$arr_where = array(
					'sql_select'     => 'sum(dng.gd_amt) as tot_amt',
					'sql_from'       => 'donation as dn',
					'sql_join_tbl'   => 'donation_goods as dng',
					'sql_join_on'    => 'dn.idx = dng.dn_idx',
					'sql_where'      => array('dn.cmp_code'=>$row->code),
			);
			$dng_row = $this->basic_model->arr_get_row($arr_where);
			$dng_total_amt = $dng_row->tot_amt;
			$list[$ino]->dng_total_amt = $dng_total_amt;

			// [사용 안함]기부율 (수량으로 계산)
			/*
			$dn_per = 0;
			if($goal_amt > 0) {
				$dn_per = ($dng_total_amt / $goal_amt) * 100;
			}
			$list[$ino]->dn_per = $dn_per;
			*/

			// 기부가치평가 금액
			$arr_where = array(
					'sql_select'     => 'donation_value', 
					'sql_from'       => 'donation',
					'sql_where'      => array('cmp_code'=>$row->code,'state_recycle'=>1), // 관리자가 재생중에 완료 체크한 것만 처리
			);
			$dn_result = $this->basic_model->arr_get_result($arr_where);

			$donation_value = 0;
			foreach($dn_result['qry'] as $dn_key => $dn_row) {
				if( isset($dn_row->donation_value) && intVal($dn_row->donation_value) > 0 ) {
					$donation_value += intVal($dn_row->donation_value);
				}
			}
			$list[$ino]->donation_value = number_format($donation_value);



			// 남은 날짜
			$left_date = intval((strtotime($row->cmp_term_end)-strtotime(date('Y-m-d'))) / 86400); // 나머지 날짜값이 나옵니다.
			if($left_date > 0) {
				$left_date_str = $left_date.'일 남음';
			}
			else if($left_date < 0) {
				$left_date_str = '종료';
			}
			else {
				$left_date_str = '오늘 마감';
			}
			$list[$ino]->left_date_str = $left_date_str;

			// 남은 날짜 percent
			$total_day = intval((strtotime($row->cmp_term_end)-strtotime($row->cmp_term_begin)) / 86400); // 나머지 날짜값이 나옵니다.
			$left_day = intval((strtotime($row->cmp_term_end)-strtotime(date('Y-m-d'))) / 86400); // 나머지 날짜값이 나옵니다.
			$left_day = ($left_day < 0) ? 0 : $left_day;
			$left_date_per = 100 - intval(($left_day/$total_day)*100);
			$list[$ino]->left_date_per = $left_date_per;




			$ino++;
		}



		$data = array(

			'device_result' => $device_result,
			'total_donor' => $total_donor,
			'total_donation_value' => $total_donation_value,

			'list' => $list,

			'pulayer' => $pulayer,
			'pubasic' => $pubasic,
			'viewPage' => 'design_main_view'
		);

		$this->load->view('layout_design_view', $data);
	}
}
