<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Calendar extends CI_Controller {
	function __construct() {
		parent::__construct();
		$this->load->model('Calendar_model');

		$this->load->helper(array('form', 'url','load'));
		$this->load->library('form_validation');
		$this->load->helper('security');
		$this->load->library('tank_auth');
		$this->lang->load('tank_auth');

		$this->username = $this->tank_auth->get_username();
		$this->arr_seg = $this->uri->segment_array();


		// 필수 CSS 로드
		load_css('<link rel="stylesheet" type="text/css" href="'. LIB_DIR .'/editor/redactor/redactor.css" media="screen"/>');
		//load_css('<link rel="stylesheet" type="text/css" href="'. LIB_DIR .'/editor/redactor/jscss/redactor_setting.css" media="screen"/>');

		// 필수 JS 로드
		load_js('<script src="'. LIB_DIR .'/editor/redactor/redactor.js"></script>');
		load_js('<script src="'. LIB_DIR .'/editor/redactor/_langs/ko.js"></script>');
		load_js('<script src="'. LIB_DIR .'/editor/redactor/_plugins/table/table.js"></script>');
		load_js('<script src="'. LIB_DIR .'/editor/redactor/_plugins/video/video.js"></script>');



		// 관리자 로그인 후에만 접속 가능, 그 외에는 메인 페이지로 이동.
		if (! $this->tank_auth->is_admin()) {			// not logged in or activated
			$this->tank_auth->logout();
			redirect('/admin/auth/login/'. url_code( current_url(), 'e'));
		}
	}

	/**
	function index() {
		if (SU_ADMIN != ADMIN) {
			alert('최고관리자만 접근할 수 있습니다.');
			return false;
		}
	}
	*/

	function index() {
		/** - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		* 캘린더(일정) 메뉴 가져오기
		*/
		$set_calendar = explode(',',$this->config->item('cf_calendar_arr', 'tank_auth'));
		$cnt_calendar = count($set_calendar);
		$arr_calendar = array();
		if($cnt_calendar) {
			for($c=0;$c<$cnt_calendar;$c++) {
				$tmp_calendar = explode(':',$set_calendar[$c]);
				$arr_calendar[$c]['name'] = $tmp_calendar[0];
				$arr_calendar[$c]['code'] = $tmp_calendar[1];
			}
		}
		$category = $arr_calendar[0]['code'];

		goto_url(base_url().'admin/calendar/lists/'.$category);
		exit;
	}

	/**
	* 일정 등록
	*/
	function write($category=FALSE, $cal_no=FALSE, $selected_year=FALSE, $selected_month=FALSE) {

		/** - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		* 캘린더(일정) 메뉴 가져오기
		*/
		$set_calendar = explode(',',$this->config->item('cf_calendar_arr', 'tank_auth'));
		$cnt_calendar = count($set_calendar);
		$arr_calendar = array();
		if($cnt_calendar) {
			for($c=0;$c<$cnt_calendar;$c++) {
				$tmp_calendar = explode(':',$set_calendar[$c]);
				$arr_calendar[$c]['name'] = $tmp_calendar[0];
				$arr_calendar[$c]['code'] = $tmp_calendar[1];
			}
		}


		if($category===FALSE) {
			alert('잘못된 경로로 들어오신 듯 해요. 이전 페이지로 이동합니다.');
			exit;
		}

		$this->load->helper('chkstr');
		$config = array(
			array('field'=>'cal_date', 'label'=>'일정 시작 날짜', 'rules'=>'trim|required'),
			array('field'=>'cal_date_end', 'label'=>'일정 종료 날짜', 'rules'=>'trim|required'),
			array('field'=>'cal_title', 'label'=>'일정 제목', 'rules'=>'trim|required|max_length[200]'),  // |callback_mb_email_check
			array('field'=>'cal_url', 'label'=>'일정 링크', 'rules'=>'trim'),
			array('field'=>'cal_content', 'label'=>'일정 내용', 'rules'=>'trim')
			//array('field'=>'wr_key', 'label'=>'자동등록방지', 'rules'=>'trim|required')
		);

		$this->load->library(array('form_validation'));
		$this->form_validation->set_rules($config);
		if ($this->form_validation->run() === FALSE) {

				// 타이틀
				/*
				if($category=='ngo')
					$title = 'NGO 일정 등록';
				else
					$title = '센터 일정 등록';
				*/

				$title = false;
				for($c=0;$c<$cnt_calendar;$c++) {
					if($category === $arr_calendar[$c]['code']) {
						$title = $arr_calendar[$c]['name']." 일정 관리";
					}
				}
				if( ! $title)
					$title = "일정";




				// 정보 담아오기
				$cal_row = $this->Calendar_model->view($category, $cal_no);
				if( $cal_no && count($cal_row) < 1) {
					alert('존재하지 않는 정보입니다. 이전페이지로 이동합니다.');
					exit;
				}


				$add_url = '';
				if($selected_year && $selected_month)
					$add_url = '/'.$selected_year.'/'.$selected_month;


				$breadcrumb = array(
					'행사일정'=>base_url().'admin/calendar',
					'관리'=>''
				);

				$data = array(
					'title' => $title,
					'category' => $category,
					'cal_no' => $cal_no,
					'w' => ($cal_no) ? 'u' : '',
					'cal_row' => $cal_row,
					'add_url' => $add_url,

					//'token' => get_token(),
					'arr_seg'   => $this->arr_seg, //$this->uri->segment_array(),

					'breadcrumb'    => $breadcrumb,
					'viewPage'  => 'admin/calendar_form'
				);

				/*
				widget::run('head', $head);
				$this->load->view(ADM_F.'/calendar_form', $data);
				widget::run('tail');
				*/

				$this->load->view('admin/layout_view', $data);
		}
		else {

				$add_url = '';
				if($selected_year && $selected_month)
					$add_url = '/'.$selected_year.'/'.$selected_month;

				$cal_no = $this->Calendar_model->write();

				if( ! $cal_no)
					alert('잘못된 경로로 들어오셨습니다.');
				else
					goto_url(base_url().'admin/calendar/write/'.$category.'/'.$cal_no.$add_url);

		}

	}







	function lists($category=FALSE,$selected_year=FALSE,$selected_month=FALSE) {

		/** - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		* 캘린더(일정) 메뉴 가져오기
		*/
		$set_calendar = explode(',',$this->config->item('cf_calendar_arr', 'tank_auth'));
		$cnt_calendar = count($set_calendar);
		$arr_calendar = array();
		if($cnt_calendar) {
			for($c=0;$c<$cnt_calendar;$c++) {
				$tmp_calendar = explode(':',$set_calendar[$c]);
				$arr_calendar[$c]['name'] = $tmp_calendar[0];
				$arr_calendar[$c]['code'] = $tmp_calendar[1];
			}
		}

		if($category===FALSE) {
			$category = $arr_calendar[0]['code'];
		}

		$default_date = explode('-',date('Y-m-d',TIME_STAMP));

		if($selected_year === FALSE OR $selected_month === FALSE) {
			$selected_year = $default_date[0];
			$selected_month = $default_date[1];
		}

		$cal_result = $this->Calendar_model->view_month_lists($category, $selected_year, $selected_month);

		$calendar_list = array();
		$default_cal_list = "<ul class='calendar_list' style='padding-left:15px;'>";

		$no = 1;
		foreach($cal_result['qry'] as $i  => $row) {

			/*
			$cal_date_arr = explode('-',$row['cal_date']);
			$cal_date_y = $cal_date_arr[0];
			$cal_date_m = $cal_date_arr[1];
			$cal_date_d = $cal_date_arr[2];

			$cal_date_str = $cal_date_y."년 ".$cal_date_m."월 ".$cal_date_d."일";
			$calendar_list[$row['cal_date_d']] = "view_cal_list('".$category."', '".$row['cal_date']."', '".$cal_date_str."')";
			*/


			$arr_dates = getDatesStartToLast($row['cal_date'], $row['cal_date_end']);
			foreach($arr_dates as $i => $date) {

				$cal_date_arr = explode('-',$date);
				$cal_date_y = $cal_date_arr[0];
				$cal_date_m = $cal_date_arr[1];
				$cal_date_d = $cal_date_arr[2];

				if($selected_year == $cal_date_y && $selected_month == $cal_date_m) {
					$cal_date_str = $cal_date_y."년 ".$cal_date_m."월 ".$cal_date_d."일";
					$calendar_list[intVal($cal_date_d)] = "view_cal_list('".$category."', '".$date."', '".$cal_date_str."')";
				}
			}


			//$default_cal_list .= "<li style='padding:2px 0; list-style:none;'>".$no.". [".$row['cal_date']."] <a id='cal_list_".$row['cal_no']."' class='cal_font' href='#' onclick='view_cal_detail(".$row['cal_no'].")'> ".$row['cal_title']."</a> <button type='button' class='btn btn-info-flat btn-xs'  style='padding:1px 5px; vertical-align:top;'  onclick='edit_calendar(".$row['cal_no'].")'>수정</button></li>";

			$cal_date_html = $row['cal_date'];
			if($row['cal_date'] != $row['cal_date_end'] && $row['cal_date_end'] != '0000-00-00' && $row['cal_date_end'] != NULL) {
				$cal_date_html .= ' ~ '.$row['cal_date_end'];
			}

			$default_cal_list .= "<li style='padding:2px 0; list-style:none;'>";
			$default_cal_list .= $no.". [".$cal_date_html."] ";
			$default_cal_list .= "<a id='cal_list_".$row['cal_no']."' class='cal_font' href='#' onclick='view_cal_detail(".$row['cal_no'].")'> ".$row['cal_title']."</a> ";
			$default_cal_list .= " <div style='display:inline-block; padding:0 3px;background-color:#e9e9f3;'>[".$row['cal_url']."] </div>";
			$default_cal_list .= " <button type='button' class='btn btn-dark btn-xs'  style='margin-left:5px; padding:1px 5px; vertical-align:top;'  onclick=\"edit_calendar('".$category."',".$row['cal_no'].", '".$selected_year."', '".$selected_month."')\">수정</button> ";
			$default_cal_list .= " <button type='button' class='btn btn-danger btn-xs'  style='padding:1px 5px; vertical-align:top;'  onclick=\"del_calendar('".$category."',".$row['cal_no'].", '".$selected_year."', '".$selected_month."')\">삭제</button>";
			$default_cal_list .= "</li>";



			$no++;
		}
		$default_cal_list .= "</ul>";


		// 금일 일정
		$cal_result_today = $this->Calendar_model->view_today_lists($category);

		//echo $this->db->last_query();


		$prefs = array (
					'start_day'    => 'monday',
					'show_next_prev'  => TRUE,
					'next_prev_url'   => '/admin/calendar/lists/'.$category
				);

		$prefs['template'] = '

		   {table_open}<table class="calendar_table" border="0" cellpadding="0" cellspacing="0" style="width:100%;">{/table_open}

		   {heading_row_start}<tr>{/heading_row_start}

		   {heading_previous_cell}<th style="width:14.2857%;"><a href="{previous_url}"><img src="'.IMG_DIR.'/icons/calendar_arw1.gif" style="margin-right:10px;" /></a></th>{/heading_previous_cell}
		   {heading_title_cell}<th colspan="{colspan}">{heading}</th>{/heading_title_cell}
		   {heading_next_cell}<th style="width:14.2857%;"><a href="{next_url}"><img src="'.IMG_DIR.'/icons/calendar_arw2.gif" style="margin-right:10px;" /></a></th>{/heading_next_cell}

		   {heading_row_end}</tr>{/heading_row_end}

		   {week_row_start}<tr>{/week_row_start}
		   {week_day_cell}<td style="background-color:#ffffff;">{week_day}</td>{/week_day_cell}
		   {week_row_end}</tr>{/week_row_end}

		   {cal_row_start}<tr>{/cal_row_start}
		   {cal_cell_start}<td style="background-color:#ffffff;">{/cal_cell_start}

		   {cal_cell_content}<a href="#" onclick="{content}; return false;">{day}</a>{/cal_cell_content}
		   {cal_cell_content_today}<div class="highlight strong" style=" background-color:#ead5d5;"><a href="#" onclick="{content}; return false;">{day}</a></div>{/cal_cell_content_today}

		   {cal_cell_no_content}{day}{/cal_cell_no_content}
		   {cal_cell_no_content_today}<div class="highlight" style=" background-color:#ead5d5;">{day}</div>{/cal_cell_no_content_today}

		   {cal_cell_blank}&nbsp;{/cal_cell_blank}

		   {cal_cell_end}</td>{/cal_cell_end}
		   {cal_row_end}</tr>{/cal_row_end}

		   {table_close}</table>{/table_close}
		';

		$this->load->library('calendar', $prefs);
		//$this->load->library('calendar');


		// 타이틀
		/*
		if($category=='ngo')
			$title = 'NGO 일정 관리';
		else
			$title = '센터 일정 관리';
		*/

		$title = false;
		for($c=0;$c<$cnt_calendar;$c++) {
			if($category === $arr_calendar[$c]['code']) {
				$title = $arr_calendar[$c]['name']." 일정 목록";
			}
		}
		if( ! $title)
			$title = "일정 관리";


		$breadcrumb = array(
			'행사일정'=>base_url().'admin/calendar',
			'관리'=>''
		);

		$data = array(
			'title' => $title,
			'category' => $category,
			'calendar_list'=>$calendar_list,
			'selected_year' => $selected_year,
			'selected_month' => $selected_month,
			'default_date' => $default_date,
			'default_cal_list' => $default_cal_list,

			'cal_result_today' => $cal_result_today,

			'arr_seg'   => $this->arr_seg, //$this->uri->segment_array(),

			'breadcrumb'    => $breadcrumb,
			'viewPage'  => 'admin/calendar_lists'
		);

		//print_r($data);

		$this->load->view('admin/layout_view', $data);
	}








	/**
	* 일정 삭제
	*/
	function del($category=FALSE, $cal_no=FALSE, $selected_year=FALSE, $selected_month=FALSE) {

		if($category===FALSE) {
			alert('잘못된 경로로 들어오신 듯 해요. 이전 페이지로 이동합니다.');
			exit;
		}

		$del_ok = $this->Calendar_model->del($category, $cal_no);

		$return_url = base_url().'admin/calendar/lists/'.$category;
		if( $selected_year && $selected_month)
			$return_url .= "/".$selected_year."/".$selected_month;

		if( ! $del_ok)
			alert('이미 삭제되었거나 없는 일정입니다.');
		else
			goto_url($return_url);

	}


















    /** -----------------------------------------------------------------------------------------------------------
     | 일정 리스트
     |  ------------------------------------------------------------------------------------------------------------
     */
	function view_date_list() {

		$category= $this->input->post('category');
		$date= $this->input->post('date');
		//$date_str = explode('-',$date);
		$cal_date_arr = explode('-',$date);
		$cal_date_y = $cal_date_arr[0];
		$cal_date_m = $cal_date_arr[1];
		$cal_date_d = $cal_date_arr[2];


		//$sql = array('cal_category' => $category, 'cal_date' => $date);
		$sql = array('cal_category' => $category, 'cal_date <=' => $date, 'cal_date_end >=' => $date);
		$result = $this->Calendar_model->view_date_lists($sql);

		$html_date = "";
		$html_date = "<ul class='calendar_list' style='padding-left:15px;'>";
		$no = 1;
		foreach($result['qry'] as $row) {

			$cal_date_html = $row['cal_date'];
			if($row['cal_date'] != $row['cal_date_end'] && $row['cal_date_end'] != '0000-00-00' && $row['cal_date_end'] != NULL) {
				$cal_date_html .= ' ~ '.$row['cal_date_end'];
			}

			$html_date .= "<li style='padding:2px 0; list-style:none;'>".$no.". [".$cal_date_html."] <a id='cal_list_".$row['cal_no']."' class='cal_font' href='#' onclick='view_cal_detail(".$row['cal_no'].")'> ".$row['cal_title']."</a> ";
			$html_date .= " <button type='button' class='btn btn-dark btn-xs'  style='margin-left:5px; padding:1px 5px; vertical-align:top;'  onclick=\"edit_calendar('".$category."',".$row['cal_no'].",".$cal_date_y.",".$cal_date_m.")\">수정</button>";
			$html_date .= " <button type='button' class='btn btn-danger btn-xs'  style='padding:1px 5px; vertical-align:top;'  onclick=\"del_calendar('".$category."',".$row['cal_no'].", '".$cal_date_y."', '".$cal_date_m."')\">삭제</button>";
			$html_date .= "</li>";

			$no++;
		}
		$html_date .= "</ul>";

		echo $html_date;

	} // END function view_date_list()




	function view_date_detail() {

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




















/* -------------------------------------------------------------------------------------------------------------------------- */
}

/* End of file calendar.php */
/* Location: ./application/controllers/adm/calendar.php */