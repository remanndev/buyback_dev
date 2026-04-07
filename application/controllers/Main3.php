<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main3 extends CI_Controller {

	function __construct()
	{
		parent::__construct();

		$this->load->library('tank_auth');
	}

	public function index()
	{

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


		// 진행중인 캠페인 - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

			// 최신 캠페인 목록 6개 가져오기
			$arr_where = array(
					'sql_select'     => '*',
					'sql_from'       => 'campaign',
					'sql_where'      => array('state'=>'launch'),
					'sql_order_by'   => 'cmp_term_begin DESC, reg_datetime DESC',
					'limit'          => 6
			);
			$result = $this->basic_model->arr_get_result($arr_where);

			//print_r($result);
			$cmp_list = array();
			$ino = 0;
			foreach($result['qry'] as $key => $row) {

				//print_r($row);

				$cmp_list[$ino] = new stdClass();

				// 번호
				//$num = ($result['total_count'] - $limit*($page-1) - $ino);
				$num = ($result['total_count'] - $ino);
				$cmp_list[$ino]->num = $num;

				$cmp_list[$ino]->idx = $row->idx;
				$cmp_list[$ino]->code = $row->code;
				$cmp_list[$ino]->cmp_title = $row->cmp_title;
				$cmp_list[$ino]->cmp_term_begin = $row->cmp_term_begin;
				$cmp_list[$ino]->cmp_term_end = $row->cmp_term_end;
				$cmp_list[$ino]->cmp_term = $row->cmp_term_begin.'~'.$row->cmp_term_end;

				$cmp_list[$ino]->cmp_org_name = $row->cmp_org_name;
				$cmp_list[$ino]->cmp_org_info = $row->cmp_org_info;

				$cmp_list[$ino]->reg_datetime = $row->reg_datetime;
				$cmp_list[$ino]->reg_date = substr($row->reg_datetime,0,10);
				$cmp_list[$ino]->state = $row->state;
				$state_str = '<button class="btn o_btn btn-xs btn-silver-flat" disabled>작성</button>';
				if('submit' == $row->state) :
					$state_str = '<button class="btn o_btn btn-xs btn-success-flat">제출</button>';
				elseif('launch' == $row->state) :
					$state_str = '<button class="btn o_btn btn-xs btn-primary-flat">런칭</button>';
				endif;
				$cmp_list[$ino]->state_str = $state_str;


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
				$campaign_main_src = '';
				if(! empty($file_row)) {
					$this->load->helper('resize');
					// $img_w = '800';
					// $img_h = '600';
					// $thumb_img = resize_thumb_image($file_row->file_name, $file_row->file_dir, $file_row->file_dir.'/thumb', $img_w,$img_h,FALSE,'auto','img');
					// $campaign_main_img = $thumb_img;

					//$img_w = '1200';
					//$img_h = '800';

					$img_w = '800,0';
					$img_h = '600,0';

					//$thumb_src = resize_thumb_image($file_row->file_name, $file_row->file_dir, $file_row->file_dir.'/thumb', $img_w,$img_h,FALSE,'auto','src');
					$thumb_src = resize_thumb_image($file_row->file_name, $file_row->file_dir, $file_row->file_dir.'/thumb', $img_w,$img_h,TRUE,'auto','src');
					$campaign_main_src = $thumb_src;
				}

				$cmp_list[$ino]->file_idx = $file_idx;
				$cmp_list[$ino]->campaign_main_img = $campaign_main_img;
				$cmp_list[$ino]->campaign_main_src = $campaign_main_src;


				// 목표 기기 수량 총합 [campaign]
				$goal_amt = 0;
				$goal_amt += intVal($row->goal_amt_1);
				$goal_amt += intVal($row->goal_amt_2);
				$goal_amt += intVal($row->goal_amt_3);
				$goal_amt += intVal($row->goal_amt_4);
				$goal_amt += intVal($row->goal_amt_5);
				//echo $goal_amt.'<<<';
				$cmp_list[$ino]->goal_amt = $goal_amt;

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
				$cmp_list[$ino]->dng_total_amt = $dng_total_amt;

				// [사용 안함]기부율 (수량으로 계산)
				/*
				$dn_per = 0;
				if($goal_amt > 0) {
					$dn_per = ($dng_total_amt / $goal_amt) * 100;
				}
				$cmp_list[$ino]->dn_per = $dn_per;
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
				$cmp_list[$ino]->donation_value = number_format($donation_value);



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
				$cmp_list[$ino]->left_date_str = $left_date_str;

				// 남은 날짜 percent
				$total_day = intval((strtotime($row->cmp_term_end)-strtotime($row->cmp_term_begin)) / 86400); // 나머지 날짜값이 나옵니다.
				$left_day = intval((strtotime($row->cmp_term_end)-strtotime(date('Y-m-d'))) / 86400); // 나머지 날짜값이 나옵니다.
				$left_day = ($left_day < 0) ? 0 : $left_day;
				$left_date_per = 100 - intval(($left_day/$total_day)*100);
				$cmp_list[$ino]->left_date_per = $left_date_per;




				$ino++;
			}



			$list_copy = $cmp_list;
			$cmp_first = array_shift($list_copy);
			$cmp_others = $list_copy;


			/*
			echo '1<hr />';
			print_r($list_first);
			echo '<br />';
			echo '<br />';
			echo '<br />';
			echo '<br />';
			echo '<br />';

			echo '2<hr />';
			print_r($list_others);
			echo '<hr />';
			*/






		// 기부 가치 && 환경 가치 - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
			$arr_where = array(
					'sql_select'     => '*',
					'sql_from'       => 'donated_amount',
					'sql_where'      => array('amt_display'=>'Y','del_datetime'=>NULL),
					'sql_order_by'   => 'amt_display ASC, amt_order ASC'
			);
			$result_amount = $this->basic_model->arr_get_result($arr_where);


		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		// 지금까지 기부된 디지털 기기 - 수동 관리 2
			$arr_where = array(
					'sql_select'     => '*',
					'sql_from'       => 'donated_device',
					'sql_where'      => array('device_display'=>'Y','del_datetime'=>NULL),
					'sql_order_by'   => 'device_display ASC, device_order ASC'
			);
			$result_device = $this->basic_model->arr_get_result($arr_where);







		// News & CASE - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
			$latest_newsncase = array();
			$result_latest_newsncase = $this->basic_model->latest_bbs('newsncase',1);
			foreach($result_latest_newsncase as $i => $row) {
				$latest_newsncase[$i] = new stdClass();
				$latest_newsncase[$i]->subject = $row->subject;
				$latest_newsncase[$i]->href = $row->href;
			}




		// 공지 사항 - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		// footer 에서 처리












		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		/*
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
		// 지금까지 기부된 디지털 기기 - 수동 관리 1
			$arr_where = array(
					'sql_select'     => '*',
					'sql_from'       => 'mng_device_amt',
					'sql_where'      => array('idx'=>1)
			);
			$device_row = $this->basic_model->arr_get_row($arr_where);
			$device_arr = array(
				'notebook'=>$device_row->notebook,
				'pc'=>$device_row->pc,
				'monitor'=>$device_row->monitor,
				'tablet'=>$device_row->tablet,
				'smartphone'=>$device_row->smartphone,
			);
			$device_name = array(
				'notebook'=>'노트북',
				'pc'=>'데스크탑',
				'monitor'=>'모니터',
				'tablet'=>'스마트패드',
				'smartphone'=>'스마트폰',
			);

		*/
		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -





		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		/*
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

		*/
		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -




		$data = array(

			'cmp_list' => $cmp_list, // 진행중 캠페인
			'cmp_first' => $cmp_first, // 첫 번째 캠페인
			'cmp_others' => $cmp_others, // 나머지 캠페인

			'result_amount' => $result_amount, // 기부가치, 환경가치
			'result_device' => $result_device, // 디바이스 수량

			'latest_newsncase' => $latest_newsncase,  // News & CASE

			'pulayer' => $pulayer,
			'pubasic' => $pubasic,
			'viewPage' => 'layout/main3_view'
		);

		$this->load->view('layout/layout3_view', $data);
	}
}
