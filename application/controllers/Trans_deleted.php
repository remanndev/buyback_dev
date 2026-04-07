<?php


		/** - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		 * 방송사례 더보기
		 */

		function more_bbs_event($more_limit=FALSE,$more_page=FALSE,$bo_code=FALSE,$cate=FALSE) {

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
				$sql_from='bbs_event';
				$fields='*';

				$join_tbl=FALSE;
				$join_where=FALSE;
				$join_option=FALSE;

				$sql_where=array('wr_idx >' => 0);
				if($cate && '' != $cate) {
					$sql_where['ca_code'] = $cate;
				}
				$sql_where['addfld_2 <'] = date('Y-m-d');




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


						$thumb_img_blank = "blank_image.png";
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


						$html .= '
							<div class=" grid-item filter-design">
								<!--Blog item-->
								<article class="vlt-post vlt-post--style-2">
									<div class="vlt-post__media"><a class="vlt-post__link" href="'.$href.'"></a><img src="'.$thumb_src.'" alt="" loading="lazy">
									</div>
									<div class="vlt-post__content">
										<header class="vlt-post__header">
											<div class="vlt-post-meta font-kr-400 fz-14">
												<span>'.$o->addfld_1.' ~  '.$o->addfld_2 .'</span><span>종료된 이벤트</span>
											</div>
											<h3 class="vlt-post-title font-kr-700"><a href="'.$href.'">'. $o->wr_subject .'</a></h3>
										</header>
									</div>
								</article>
							</div>';





					// 갱신
					//$more_last = $row->wr_idx;

				}

				//echo $html;

				//echo ('' != $html) ? $html.'#total_page#'.$total_page : '';
				echo $html.'#total_page#'.$total_page;

		}










		// 관리자 기업정보 등록/수정 페이지에서 기업 담당자 검색
		function admin_srh_comp_manager() {

			// jquery ajax 에서 success 의 response 값을 못가져오길래 검색해보니,
			// 요 아래 코드를 ajax 페이지에서 호출하는 페이지에 넣어주라고 함.
			header("Content-type: text/html; charset=utf-8");

			$srh_company      = $this->input->post('srh_company');
			$comp_idx      = $this->input->post('comp_idx');

			// 기업 정보
			$this->db->start_cache();
			$this->db->join('users AS uacc', 'upro.user_id = uacc.id', 'left outer');

			$this->db->join('WL_COMPANY AS comp', 'comp.users_fk = uacc.id', 'left outer');

			$this->db->like('upro.comp_name', $srh_company, 'both');
			$this->db->stop_cache();

			$this->db->select('uacc.username, uacc.nickname, comp.idx AS comp_idx, upro.*');
			$this->db->group_by('upro.comp_business_number');
			$this->db->order_by('upro.comp_name', 'ASC');
			$query = $this->db->get('user_profiles AS upro')->result();
			$this->db->flush_cache();

			//echo $this->db->last_query();

			//print_r( $query );

			//echo $query;

			$res = '<table class="table table-hover">';
			$res .= '<tr>';
			$res .= '  <th class="bg_f6f6f6">기업명</th>';
			$res .= '  <th class="bg_f6f6f6">사업자번호</th>';
			$res .= '  <th class="bg_f6f6f6">담당자</th>';
			$res .= '  <th class="bg_f6f6f6" style="width:50px;text-align:center;">선택</th>';
			$res .= '</tr>';

			foreach ($query as $k => $v) {

				$comp_name = str_replace($srh_company,'<span style="color:#ff0000;">'.$srh_company.'</span>',$v->comp_name);

				$res .= '<tr>';
				$res .= '  <td>'. $comp_name .'</td>';
				$res .= '  <td>'. $v->comp_business_number .'</td>';
				$res .= '  <td>'. $v->nickname .'</td>';

				//$res .= '  <td style="text-align:center;"><button class="btn btn-default-flat btn-xs" onclick="choice_company(\''.$v->comp_name.'\',\''.$v->comp_business_number.'\',\''.$v->user_id.'\',\''.$v->nickname.'\');">선택</button></td>';

				$res .= '  <td style="text-align:center;">';
				if($v->comp_idx && $comp_idx !== $v->comp_idx) {
					$res .= '    <span title="이미 등록된 기업입니다."><button class="btn btn-default-flat btn-xs" disabled>완료</button></span>';
				}
				elseif($comp_idx == $v->comp_idx) {
					$res .= '    <button class="btn btn-default-flat btn-xs" onclick="choice_company(\''.$v->comp_name.'\',\''.$v->comp_business_number.'\',\''.$v->user_id.'\',\''.$v->nickname.'\');" title="기업회원 정보로부터 변경된 정보를 반영합니다.">수정</button>';
				}
				else {
					$res .= '    <button class="btn btn-default-flat btn-xs" onclick="choice_company(\''.$v->comp_name.'\',\''.$v->comp_business_number.'\',\''.$v->user_id.'\',\''.$v->nickname.'\');" title="클릭하시면, 선택하신 기업으로 등록/변경됩니다.">선택</button>';
				}
				$res .= '  </td>';
				$res .= '</tr>';
			}
			$res .= '</table>';

			echo $res;

		}


		// 설문지 프로세스 및 설문지명 불러오기
		function admin_call_survey_cate() {

			// jquery ajax 에서 success 의 response 값을 못가져오길래 검색해보니,
			// 요 아래 코드를 ajax 페이지에서 호출하는 페이지에 넣어주라고 함.
			header("Content-type: text/html; charset=utf-8");

			$pidx      = $this->input->post('pidx');

			// 설문지 카테고리(설문지 프로세스 및 설문지명) 정보
			$this->db->start_cache();
			$this->db->where( array('parent_idx'=>$pidx) );
			$this->db->stop_cache();
			$this->db->select('*');
			$this->db->order_by('idx', 'ASC');
			$query = $this->db->get('WL_SURVEY_CATEGORY')->result();
			$this->db->flush_cache();

			$res = '';
			//$res .= '<strong style="display:inline-block;width:80px;">설문지명 : </strong>';
			$res .= '  <select id="survey_title_fk" class="" name="title_fk" onchange="use_new_title(this)">';
			$res .= '	<option value="">설문지명을 선택해주세요</option>"';

			foreach ($query as $k => $v) {
				$res .= '	<option value="'. $v->idx .'">'. $v->title .'</option>';
			}

			if($pidx){
				$res .= '	<option value="new">▶ 새 설문지명 등록</option>';
			}
			$res .= '  </select>';

			echo $res;
		}



		// 설문지 질문 관리
		function admin_survey_question_mng() {


		}


		// 설문지 질문 잠금 처리
		function admin_survey_question_lock() {

				// jquery ajax 에서 success 의 response 값을 못가져오길래 검색해보니,
				// 요 아래 코드를 ajax 페이지에서 호출하는 페이지에 넣어주라고 함.
				header("Content-type: text/html; charset=utf-8");

				$lock = $this->input->post('lock');
				$qidx = $this->input->post('qidx');
				$comp_idx = $this->input->post('comp_idx');
				$survey_idx = $this->input->post('survey_idx');

				$data = array('lock'=>$lock);

				if($qidx){
					$this->db->where('idx', $qidx);
				}
				else {
					$this->db->where('company_fk', $comp_idx);
					$this->db->where('survey_fk', $survey_idx);
				}

				if ($res = $this->db->update('WL_SURVEY_QUESTION', $data)) {
					echo $res;
				}
				else {
					echo false;
				}
		}







		// 설문지 질문 잠금 처리
		function admin_survey_form_question_lock() {

				// jquery ajax 에서 success 의 response 값을 못가져오길래 검색해보니,
				// 요 아래 코드를 ajax 페이지에서 호출하는 페이지에 넣어주라고 함.
				header("Content-type: text/html; charset=utf-8");

				$lock = $this->input->post('lock');
				$qidx = $this->input->post('qidx');
				$survey_form_idx = $this->input->post('survey_form_idx');

				$data = array('lock'=>$lock);

				if($qidx){
					$this->db->where('idx', $qidx);
				}
				else {
					$this->db->where('survey_form_fk', $survey_form_idx);
				}

				if ($res = $this->db->update('WL_SURVEY_FORM_QUESTION', $data)) {
					echo $res;
				}
				else {
					echo false;
				}
		}



		// 관리자 설문지 최종보고서 기업 공개 여부 처리
		function admin_survey_report_display() {

				// jquery ajax 에서 success 의 response 값을 못가져오길래 검색해보니,
				// 요 아래 코드를 ajax 페이지에서 호출하는 페이지에 넣어주라고 함.
				header("Content-type: text/html; charset=utf-8");

				$survey_fk = $this->input->post('survey_fk');
				$display = $this->input->post('display');

				if($survey_fk) {
					$this->db->where('idx', $survey_fk);
					if ($res = $this->db->update('WL_SURVEY', array('display'=>$display))) {
						echo $res;
					}
					else {
						echo false;
					}
				}
				else {
					echo false;
				}

		}



		// [관리자 기능] 일반인 후기에서 승인/미승인
		function review_app_yn() {

				// 관리자가 아니면 실행 불가
				if (! $this->tank_auth->is_admin()) {
					return false;
				}

				// jquery ajax 에서 success 의 response 값을 못가져오길래 검색해보니,
				// 요 아래 코드를 ajax 페이지에서 호출하는 페이지에 넣어주라고 함.
				header("Content-type: text/html; charset=utf-8");

				$bo_code = $this->input->post('bo_code');
				$bo_table = 'bbs_'.$bo_code;
				$wr_idx = $this->input->post('idx');


				if($wr_idx) {


					$row = $this->basic_model->get_common_row('row','APP',$bo_table,FALSE,FALSE,FALSE,array('wr_idx'=>$wr_idx));
					$APP_YN = ('Y' == $row->APP) ? 'N' : 'Y';

					$this->db->where('wr_idx', $wr_idx);
					if ($res = $this->db->update($bo_table, array('APP'=>$APP_YN))) {
						echo $res;
					}
					else {
						echo false;
					}
				}
				else {
					echo false;
				}


		}





	// 원장님별 진료일정 가져오기
	function get_schedule() {


		// jquery ajax 에서 success 의 response 값을 못가져오길래 검색해보니,
		// 요 아래 코드를 ajax 페이지에서 호출하는 페이지에 넣어주라고 함.
			header("Content-type: text/html; charset=utf-8");
			header("Content-Type:application/json");

			$doctor_idx = $this->input->post('doctor',FALSE);
			$year = $this->input->post('year',FALSE);
			$month = $this->input->post('month',FALSE);
			$month_number = $month;
			$month = str_repeat('0',2-strlen($month)).$month;

			$sql_arr = array(
					'sql_select'     => '*',
					'sql_from'       => 'TBL_SCHEDULE',
					'sql_where'      => array('DOCTOR'=>$doctor_idx,'YEAR'=>$year,'MONTH'=>$month),
					'sql_order_by'   => 'DAY ASC',
			);
			$result = $this->basic_model->arr_get_result($sql_arr);


			$res = '';

			$obj = new stdClass();
			$date = '';

			$schedule = '';

			if( $result['total_count'] > 0 ) 
			{
				foreach($result['qry'] as $i => $o) {
					$date = $o->MONTH.'-'.$o->DAY.'-'.$o->YEAR;
					// 스케쥴
					switch ($o->SCHEDULE) {
						case '진료 및 수술':
							$schedule = "<p class='cld on'>진료 및 수술</p>";
						break;
						case '휴일':
							$schedule = "<p class='cld sunday'>휴일</p>";
						break;
						case '휴진':
							$schedule = "<p class='cld off'>휴진</p>";
						break;
						case '오전진료':
							$schedule = "<p class='cld am'>오전진료</p>";
						break;
						case '오후진료':
							$schedule = "<p class='cld pm'>오후진료</p>";
						break;
						case '세미나':
							$schedule = "<p class='cld seminar'>세미나</p>";
						break;
						case '협력진료':
							$schedule = "<p class='cld cowork'>협력진료</p>";
						break;
						case '예약문의':
							$schedule = "<p class='cld reservation'>예약문의</p>";
						break;
						default:
							$schedule = "<p class='cld'>일정 없음</p>";
						break;
					}

					$obj->$date = $schedule;

				}  // end foreach
			}  // end if
			else {
				// 일정이 없는 달..

				// 1. 총일수 구하기
				$max_day = date('t', mktime(0, 0, 0, $month_number, 1, $year)); // 해당월의 마지막 날짜

				for($d=1;$d<=$max_day;$d++) {

					$day = str_repeat('0',2-strlen($d)).$d;

					$date = $month.'-'.$day.'-'.$year;
					$obj->$date = "<p class='cld'>일정 없음</p>";
				}

			}

			echo json_encode($obj);
	}
























?>