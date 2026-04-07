<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class _Common {

	/**
	 * pre_controller 컨트롤러가 호출되기 직전입니다. 모든 기반클래스(base classes), 라우팅 그리고 보안점검이 완료된 상태입니다.
	*/
	function pre() {
		$CI = & get_instance();
	}


	/**
	 * post_controller_constructor 컨트롤러가 인스턴스화 된 직후입니다.즉 사용준비가 완료된 상태가 되겠죠. 하지만, 인스턴스화 된 후 메소드들이 호출되기 직전입니다.
	*/

	function post() {

		$CI = & get_instance();
		header("Content-Type: text/html; charset=utf8");

		$http_host     = $CI->input->server('HTTP_HOST');
		$domain = $CI->config->item('website_domain','tank_auth');
		
		if( $domain !== $http_host ) {
			//redirect("http://".$domain.REQUEST_URI);
		}
		
		if( $http_host === 'replus.openuri.net' ) {
			redirect("https://".$domain.REQUEST_URI);
		}



		// sns 로그인 시 리다이렉트..
		/*
			if ($CI->tank_auth->is_logged_in()) {
				if($rpath_encode = $CI->session->userdata('rpath_encode')) {
					$CI->session->unset_userdata('rpath_encode');

					$rpath_decode = url_code($rpath_encode,'d');
					redirect($rpath_decode);
				}
			}
		*/




		/* - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - */
		// 방문자 통계

			$php_self     = $CI->input->server('PHP_SELF');
			$http_referer = $CI->input->server('HTTP_REFERER');
		
			if( ! $CI->session->userdata('refer_init') ) {
				$CI->session->set_userdata('refer_init',$http_referer);
			}

			$http_host = $_SERVER['HTTP_HOST'];
			$request_uri = $_SERVER['REQUEST_URI'];
			$url = $http_host . $request_uri;
			$agent = $CI->input->server('HTTP_USER_AGENT');

			//$isBot = strpos($agent, 'bot');

			$CI->load->library('basic_lib');
			$isBot = $CI->basic_lib->isBot($agent);

			$visit_ip = $CI->input->server('REMOTE_ADDR');
			$visit_referer = ($http_referer) ? $http_referer : $php_self;



			$seg1 = $CI->uri->segment(1, '');
			$seg2 = $CI->uri->segment(2, '');
			$seg3 = $CI->uri->segment(3, '');



			// 방문 세션 초기화
			//$CI->session->set_userdata('visit_today','');
			//$CI->session->set_userdata('visit_ip','');

			/*
			if ($CI->session->userdata('visit_ip') != $visit_ip) {
					$CI->session->set_userdata('visit_ip',$visit_ip);
			}
			*/





		/* - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - */
		// 접속자 통계 [1,2]
		// visit_stats

		//$CI->session->set_userdata('visit_stats','');
		//$CI->session->set_userdata('visit_ip','');


		/*
		*/
		//if($seg1 != 'trans') 
		$arr_except = array('trans','admin','auth');
		if(! in_array($seg1,$arr_except) )
		{


			/* - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - */
			// 접속자 주간 통계 [0]
			// visit_stats_week

				// 오늘 날짜
				$today = date('Y-m-d');

				// 오늘 요일 (1: 월요일, 2: 화요일, ..., 7: 일요일)
				$today_weekday = date('w', strtotime($today));

				// 이번 주 월요일 날짜
				$this_monday = date('Y-m-d', strtotime('-' . ($today_weekday - 1) . ' days', strtotime($today)));



			/* - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - */
			// 접속자 통계 [1]
			// visit_stats

				if (! $CI->session->userdata('visit_stats') ) {
					$CI->session->set_userdata('visit_stats',true);


					// 기본(일자별) 방문자 통계 신규 - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
						$cnt = $CI->basic_model->get_common_count('visit_stats', array('date' => date('Y-m-d')));
						if($cnt < 1) {
							$arr = array(
									'sql_select'     => '*',
									'sql_from'       => 'visit_stats',
									'sql_where'      => 'idx > 0',
									'limit'          => 1,
									'sql_order_by'   => 'date DESC'
							);
							$row = $CI->basic_model->arr_get_row($arr);

							$total_visitor = isset($row->total_visitor) ? $row->total_visitor : 0;
							$total_view = isset($row->total_view) ? $row->total_view : 0;
							$total_visitor_bot = isset($row->total_visitor_bot) ? $row->total_visitor_bot : 0;
							$total_view_bot = isset($row->total_view_bot) ? $row->total_view_bot : 0;

							$sql = " insert into visit_stats ( date, total_visitor, total_view, total_visitor_bot, total_view_bot, today_visitor, today_view, today_visitor_bot, today_view_bot ) values ";
							if($isBot) {
								$sql .= " ('".TIME_YMD."',".$total_visitor.",".$total_view.",".($total_visitor_bot + 1).",".$total_view_bot.",0,0,1,0 ) ";
							}
							else {
								$sql .= " ('".TIME_YMD."',".($total_visitor + 1).",".$total_view.",".$total_visitor_bot.",".$total_view_bot.",1,0,0,0 ) ";
							}
							$CI->db->simple_query($sql);
						}


					// 주간 방문자 통계 신규 - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
						$cnt_week = $CI->basic_model->get_common_count('visit_stats_week', array('monday_week' => $this_monday));
						if($cnt_week < 1) {
							$arr_week = array(
									'sql_select'     => '*',
									'sql_from'       => 'visit_stats_week',
									'sql_where'      => 'idx > 0',
									'limit'          => 1,
									'sql_order_by'   => 'monday_week DESC'
							);
							$row_week = $CI->basic_model->arr_get_row($arr_week);

							$total_visitor = isset($row_week->total_visitor) ? $row_week->total_visitor : 0;
							$total_view = isset($row_week->total_view) ? $row_week->total_view : 0;
							$total_visitor_bot = isset($row_week->total_visitor_bot) ? $row_week->total_visitor_bot : 0;
							$total_view_bot = isset($row_week->total_view_bot) ? $row_week->total_view_bot : 0;

							$sql = " insert into visit_stats_week ( monday_week, total_visitor, total_view, total_visitor_bot, total_view_bot, week_visitor, week_view, week_visitor_bot, week_view_bot ) values ";
							if($isBot) {
								$sql .= " ('".$this_monday."',".$total_visitor.",".$total_view.",".($total_visitor_bot + 1).",".$total_view_bot.",0,0,1,0 ) ";
							}
							else {
								$sql .= " ('".$this_monday."',".($total_visitor + 1).",".$total_view.",".$total_visitor_bot.",".$total_view_bot.",1,0,0,0 ) ";
							}
							$CI->db->simple_query($sql);
						}


				}


				// [접속자 기준] update visitor count
				if ($CI->session->userdata('visit_ip') != $visit_ip) {


					// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
					// 기본(일자별) 통계
					$sql = ' UPDATE visit_stats SET ';
					if($isBot) {
						$sql .= " today_visitor_bot = (today_visitor_bot + 1), total_visitor_bot = (total_visitor_bot + 1) ";
					}
					else {
						$sql .= " today_visitor = (today_visitor + 1), total_visitor = (total_visitor + 1) ";
					}
					$sql .= " WHERE date = '".date('Y-m-d')."' ; ";
					$CI->db->simple_query($sql);


					// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
					// 주간 방문자 통계
					$sql = ' UPDATE visit_stats_week SET ';
					if($isBot) {
						$sql .= " week_visitor_bot = (week_visitor_bot + 1), total_visitor_bot = (total_visitor_bot + 1) ";
					}
					else {
						$sql .= " week_visitor = (week_visitor + 1), total_visitor = (total_visitor + 1) ";
					}
					$sql .= " WHERE monday_week = '".$this_monday."' ; ";
					$CI->db->simple_query($sql);



				}


				// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
				// 기본(일자별) 통계
				// [페이지 뷰 기준] update view count
				$sql = ' UPDATE visit_stats SET ';
				if($isBot) {
					$sql .= " today_view_bot = (today_view_bot + 1), total_view_bot = (total_view_bot + 1) ";
				}
				else {
					$sql .= " today_view = (today_view + 1), total_view = (total_view + 1) ";
				}
				$sql .= " WHERE date = '".date('Y-m-d')."' ; ";
				$CI->db->simple_query($sql);



				// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
				// 주간 통계
				// [페이지 뷰 기준] update view count
				$sql = ' UPDATE visit_stats_week SET ';
				if($isBot) {
					$sql .= " week_view_bot = (week_view_bot + 1), total_view_bot = (total_view_bot + 1) ";
				}
				else {
					$sql .= " week_view = (week_view + 1), total_view = (total_view + 1) ";
				}
				$sql .= " WHERE monday_week = '".$this_monday."' ; ";
				$CI->db->simple_query($sql);




			/* - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - */
			// 접속자 통계 [2]
			// visit
			// visit_bot
			// visit_stats
				

				/*
				*/
				if ($CI->session->userdata('visit_ip') != $visit_ip) {
					$CI->session->set_userdata('visit_ip',$visit_ip);
					
					if($isBot) {
						$cnt = $CI->basic_model->get_common_count('visit_bot', array('vi_ip' => $visit_ip,'vi_date' => date('Y-m-d')));
						if($cnt > 0) {
							$CI->db->simple_query(" UPDATE visit_bot SET cnt = cnt + 1 WHERE vi_ip = '".$visit_ip."' AND vi_date = '".date('Y-m-d')."' ;");
						}
						else {
							$CI->db->simple_query(" insert into visit_bot ( vi_ip, cnt, vi_date, vi_datetime, vi_currentpage, vi_referer, vi_agent ) values ( '".$visit_ip."', 1, '".TIME_YMD."', '".TIME_YMDHIS."', '".$url."', '".$visit_referer."', '".$CI->input->server('HTTP_USER_AGENT')."' ) ");
						}
					}
					else {
						$cnt = $CI->basic_model->get_common_count('visit', array('vi_ip' => $visit_ip,'vi_date' => date('Y-m-d')));
						if($cnt > 0) {
							$CI->db->simple_query(" UPDATE visit SET cnt = cnt + 1 WHERE vi_ip = '".$visit_ip."' AND vi_date = '".date('Y-m-d')."' ;");
						}
						else {

							// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
							// 2024-09-19
							// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
							if (strpos($visit_referer, 'naver') !== false) {
								$sns = 'naver';
							}
							elseif (strpos($visit_referer, 'google') !== false) {
								$sns = 'google';
							}
							elseif (strpos($visit_referer, 'daum') !== false) {
								$sns = 'daum';
							}
							else {
								$sns = '';
							}

							$CI->db->simple_query(" insert into visit ( vi_ip, cnt, vi_date, vi_datetime, vi_currentpage, vi_referer, vi_agent, sns ) values ( '".$visit_ip."', 1, '".TIME_YMD."', '".TIME_YMDHIS."', '".$url."', '".$visit_referer."', '".$CI->input->server('HTTP_USER_AGENT')."', '".$sns."' ) ");
						}
					}
				}


		}



		/* - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - */
		// 방문자 통계
			$arr = array(
					'sql_select'     => '*',
					'sql_from'       => 'visit_stats',
					'sql_where'      => 'idx > 0',
					'limit'          => 1,
					'sql_order_by'   => 'idx DESC'
			);
			$row = $CI->basic_model->arr_get_row($arr);

			define('TODAY_VISITOR', isset($row->today_visitor) ? $row->today_visitor : 0);
			define('TOTAL_VISITOR', isset($row->total_visitor) ? $row->total_visitor : 0);
			define('TODAY_VIEW', isset($row->today_view) ? $row->today_view : 0);
			define('TOTAL_VIEW', isset($row->total_view) ? $row->total_view : 0);

			define('TODAY_VISITOR_BOT', isset($row->today_visitor_bot) ? $row->today_visitor_bot : 0);
			define('TOTAL_VISITOR_BOT', isset($row->total_visitor_bot) ? $row->total_visitor_bot : 0);
			define('TODAY_VIEW_BOT', isset($row->today_view_bot) ? $row->today_view_bot : 0);
			define('TOTAL_VIEW_BOT', isset($row->total_view_bot) ? $row->total_view_bot : 0);




















		/* ▼ ▼ ▼ ▼ ▼ ▼ ▼ ▼ ▼ ▼ ▼ ▼ ▼ ▼ ▼ ▼ ▼ ▼ ▼ ▼ ▼ ▼ ▼ ▼ ▼ ▼ ▼ ▼ ▼ ▼ ▼ ▼ ▼ ▼ ▼ ▼ ▼ ▼ ▼ ▼ ▼ ▼ ▼ ▼ ▼ ▼ */
		
		/*

			// 이전에 방문한 페이지 목록을 가져옵니다.
			$visited_pages = isset($_SESSION['visited_pages']) ? $_SESSION['visited_pages'] : array();
			// 현재 페이지 URL을 가져옵니다.
			$current_page = $_SERVER['PHP_SELF'];

			// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
			// 사이트에 방문시 방문날짜의 방문통계 데이터가 없을 경우 생성
			// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
			$cnt = $CI->basic_model->get_common_count('y_visit_stats', array('date' => TIME_YMD));
			if($cnt < 1) {
					$arr = array(
							'sql_select'     => '*',
							'sql_from'       => 'y_visit_stats',
							'sql_where'      => array('idx > ' => 0),
							'limit'          => 1,
							'sql_order_by'   => 'date DESC'
					);
					$row = $CI->basic_model->arr_get_row($arr);
					$total_view = isset($row->total_view) ? $row->total_view : 0;
					$total_visitor = isset($row->total_visitor) ? $row->total_visitor : 0;
					$total_view_bot = isset($row->total_view_bot) ? $row->total_view_bot : 0;
					$total_visitor_bot = isset($row->total_visitor_bot) ? $row->total_visitor_bot : 0;

					$data = array(
							'date'=> TIME_YMD,
							'today_view'=> 0,
							'today_visitor'=> 0,
							'total_view'=> $total_view,
							'total_visitor'=> $total_visitor,
							'today_view_bot'=> 0,
							'today_visitor_bot'=> 0,
							'total_view_bot'=> $total_view_bot,
							'total_visitor_bot'=> $total_visitor_bot,
					);
					$CI->db->insert('y_visit_stats', $data);
			}

			// 처음 방문한 페이지
			if (!in_array($current_page, $visited_pages)) {
				// [1] 방문자 수 증가
				if(empty($visited_pages)) {
					$CI->db->simple_query(" UPDATE y_visit_stats SET today_visitor = today_visitor + 1, total_visitor = total_visitor + 1 WHERE date = '".TIME_YMD."' ;");
				}
				$visited_pages[] = $current_page;
				$_SESSION['visited_pages'] = $visited_pages;
			}

			// 이미 방문했던 페이지
			if (in_array($current_page, $visited_pages)) {
				// [2] 뷰 카운트 플러스
				$CI->db->simple_query(" UPDATE y_visit_stats SET today_view = today_view + 1, total_view = total_view + 1  WHERE date = '".TIME_YMD."' ;");
				// [3] 방문 정보 저장
				$cnt = $CI->basic_model->get_common_count('y_visit', array('vi_ip' => $visit_ip,'vi_date' => date('Y-m-d')));
				if($cnt > 0) {
					$CI->db->simple_query(" UPDATE y_visit SET cnt = cnt + 1 WHERE vi_ip = '".$visit_ip."' AND vi_date = '".date('Y-m-d')."' ;");
				}
				else {
					$CI->db->simple_query(" insert into y_visit ( vi_ip, cnt, vi_date, vi_datetime, vi_currentpage, vi_referer, vi_agent ) values ( '".$visit_ip."', 1, '".TIME_YMD."', '".TIME_YMDHIS."', '".$url."', '".$visit_referer."', '".$CI->input->server('HTTP_USER_AGENT')."' ) ");
				}
			}

			
			$visit_who = ($isBot) ? 'bot' : '';
			$CI->db->simple_query(" insert into y_visit_all ( who, vi_ip, vi_date, vi_datetime, vi_currentpage, vi_referer, vi_agent ) values ( '".$visit_who."', '".$visit_ip."', '".TIME_YMD."', '".TIME_YMDHIS."', '".$url."', '".$visit_referer."', '".$CI->input->server('HTTP_USER_AGENT')."' ) ");
			
		*/

		/* ▲ ▲ ▲ ▲ ▲ ▲ ▲ ▲ ▲ ▲ ▲ ▲ ▲ ▲ ▲ ▲ ▲ ▲ ▲ ▲ ▲ ▲ ▲ ▲ ▲ ▲ ▲ ▲ ▲ ▲ ▲ ▲ ▲ ▲ ▲ ▲ ▲ ▲ ▲ ▲ ▲ ▲ ▲ ▲ ▲ ▲ */












		/* ▼ ▼ ▼ ▼ ▼ ▼ ▼ ▼ ▼ ▼ ▼ ▼ ▼ ▼ ▼ ▼ ▼ ▼ ▼ ▼ ▼ ▼ ▼ ▼ ▼ ▼ ▼ ▼ ▼ ▼ ▼ ▼ ▼ ▼ ▼ ▼ ▼ ▼ ▼ ▼ ▼ ▼ ▼ ▼ ▼ ▼ */

			// naver, google, daum  검색 결과 집계

			$arr = array(
					'sql_select'     => '*',
					'sql_from'       => 'visit_stats_sns',
					'sql_where'      => 'idx > 0',
					'limit'          => 1,
					'sql_order_by'   => 'idx DESC'
			);
			$row_latest = $CI->basic_model->arr_get_row($arr);
			$latest_visit_idx = isset($row_latest->visit_idx) ? $row_latest->visit_idx : 0;

			if('' == $latest_visit_idx) {
				$latest_visit_idx = 0;
			}

			/* - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - */
			// SNS 접속자 통계 
			// visit_sns
			// $arr_sns = array('naver','google','daum');


			// SELECT * FROM `x_visit_sns` WHERE `vi_date` LIKE '2023-02%'

			$arr = array(
				'sql_select'     => '*',
				'sql_from'       => 'visit',
				'sql_where'   => 'vi_id > '.$latest_visit_idx,
				'sql_order_by'   => 'vi_id ASC'
			);
			$result_sns = $CI->basic_model->arr_get_result($arr);

			$date_month = '';
			$last_month = '';

			$naver_month = 0;
			$naver_total = 0;
			$google_month = 0;
			$google_total = 0;
			$daum_month = 0;
			$daum_total = 0;
			$etc_month = 0;
			$etc_total = 0;

			$sns = '';


			foreach($result_sns['qry'] as $k => $o) {

				$visit_idx = $o->vi_id;

				$date = $o->vi_date;
				$date_month = substr($date, 0, 7); // 연월

				// echo $date_month.'<<<br />';

				// 새로운 달
				if($last_month != $date_month) {
					$naver_month = 0;
					$google_month = 0;
					$daum_month = 0;
					$etc_month = 0;
				}

				$last_month = $date_month;
				
				
				// naver
				if (strpos($o->vi_referer, 'naver') !== false) {
					//echo "URL에 '{$word}'가 포함되어 있습니다.\n";
					$sns = 'naver';
					$naver_month++;
				}
				elseif (strpos($o->vi_referer, 'google') !== false) {
					$sns = 'google';
					$google_month++;
				}
				elseif (strpos($o->vi_referer, 'daum') !== false) {
					$sns = 'daum';
					$daum_month++;
				}
				else {
					$sns = '';
					// $etc_month++;
				}

				$cnt = $CI->basic_model->get_common_count('visit_stats_sns', array('date_month' => $date_month));

				if( $cnt < 1 ) {

					$arr = array(
						'sql_select'     => '*',
						'sql_from'       => 'visit_stats_sns',
						'sql_where'   => 'idx > 0',
						'sql_order_by'   => 'idx DESC',
						'limit' => 1
					);
					$row = $CI->basic_model->arr_get_row($arr);
					
					$naver_total = isset($row->naver_total) ? $row->naver_total : 0;
					$naver_total += $naver_month;

					$google_total = isset($row->google_total) ? $row->google_total : 0;
					$google_total += $google_month;

					$daum_total = isset($row->daum_total) ? $row->daum_total : 0;
					$daum_total += $daum_month;

					$etc_total = isset($row->etc_total) ? $row->etc_total : 0;
					$etc_total += $etc_month;

					$sql = " insert into visit_stats_sns ( date_month, naver_month, naver_total, google_month, google_total, daum_month, daum_total, etc_month, etc_total, visit_idx ) values ";
					$sql .= " ( '".$date_month."', $naver_month, $naver_total, $google_month, $google_total, $daum_month, $daum_total, $etc_month, $etc_total, $visit_idx ) ";

					$CI->db->simple_query($sql);

				}
				else {

					$sql = ' UPDATE visit_stats_sns SET ';

					if($sns == 'naver') {
						$sql .= ' naver_month=naver_month+1, naver_total=naver_total+1 ';
					}
					elseif($sns == 'google') {
						$sql .= ' google_month=google_month+1, google_total=google_total+1 ';
					}
					elseif($sns == 'daum') {
						$sql .= ' daum_month=daum_month+1, daum_total=daum_total+1 ';
					}
					else {
						$sql .= ' etc_month=etc_month+1, etc_total=etc_total+1 ';
					}

					$sql .= ', visit_idx="'.$visit_idx.'" ';

					$sql .= ' WHERE date_month = "'.$date_month.'" ';

					if('' != $sns) {
						$CI->db->simple_query($sql);
					}

				}

			}

		/* ▲ ▲ ▲ ▲ ▲ ▲ ▲ ▲ ▲ ▲ ▲ ▲ ▲ ▲ ▲ ▲ ▲ ▲ ▲ ▲ ▲ ▲ ▲ ▲ ▲ ▲ ▲ ▲ ▲ ▲ ▲ ▲ ▲ ▲ ▲ ▲ ▲ ▲ ▲ ▲ ▲ ▲ ▲ ▲ ▲ ▲ */











		/* - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - */
		// 모바일 체크 [3] : CI 자체 기능, autoload 처리

			// autoload
			$CI->load->library('mobiledetect');
			//$CI->load->library('user_agent');

			$is_mobile = FALSE;
			if($CI->mobiledetect->isMobile() || $CI->agent->mobile()) :
				$is_mobile = TRUE;
			endif;
			define('IS_MOBILE', $is_mobile);



	} // [END] function post() {

}

/* End of file Common.php */
/* Location: ./application/hooks/Common.php */