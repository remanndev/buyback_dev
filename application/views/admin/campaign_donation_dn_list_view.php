<style type="text/css">
.dn_list { width: 100%; /* max-width: 1800px; */}
.dn_list tr th { background-color: #f8f8f8; color:#363636; }
.dn_list tr.dn_list_row td { background-color: #fcfcfc; color: #474747; font-size: 15px;}

.dn_list tr.dn_list_row.clicked td {  background-color: #dedede;  }
.dn_list tr.dn_list_row.cmp_ended td {  background-color: #ababab; color: #ffffff; }

.dn_detail_list {}
.dn_detail_list tr th, .dn_detail_list tr td { font-size: 15px; }
.dn_detail_list tr th { line-height: 20px !important; padding:5px 10px !important; background-color: #f8f8f8; border-top: 1px solid #ccc; color:#363636;  font-size: 15px;}
.dn_detail_list tr td { line-height: 15px !important; padding:3px 10px !important;  font-size: 14px; border-bottom: 1px dashed #ccc; }


.vstat_list { margin: 3px auto 10px auto;}
.vstat_list tr th, .dn_detail_list tr td { font-size: 15px; }
.vstat_list tr th { line-height: 25px !important; padding:5px 10px !important; background-color: #f8f8f8; border-top: 1px solid #ccc; color:#363636;  font-size: 15px;}
.vstat_list tr td { line-height: 24px !important; padding:3px 10px !important;  font-size: 14px; border-bottom: 1px dashed #ccc; }

/* 버튼도 텍스트 선택 가능 */
.allow-select {
  user-select: text !important;
}

/* */
#search_form {}
#search_form dl { height: 42px; }
#search_form dl dt, #search_form dl dd { height: 42px; display: flex; align-items: center; }

#search_form dl.dl_srhdate label { margin-right: 10px; }

#search_form select { line-height: 28px; height: 32px; }
#search_form input[type="text"] { line-height: 28px; height: 32px; padding: 3px 3px; }
</style>

<link rel="stylesheet" type="text/css" href="/assets/lib/datetimepicker-master/jquery.datetimepicker.min.css" media="screen">
<script src="/assets/lib/datetimepicker-master/jquery.datetimepicker.full.js"></script>


<h1 class="dsp_flex">
	<div>기부 관리</div>
	<div style="margin-left: 25px;">
	  <div style="margin: 0; position: absolute; left: 0; width: 500px; top: -10px;" class="dsp_flex">
		<button id="btn_update_status" class="btn btn-primary btn-md" type="button">검수 및 배송상태 갱신</button>
		<!-- <small style="line-height: 37px; font-size: 17px; margin-left: 10px; color: #666;">최근 업데이트 : <?php //echo $latest_update ?></small> -->
	  </div>
	</div>
</h1>


<div class="tbl_frm" style="border:none;">


			<div class="dsp_flex" style="font-size:16px; font-weight: bold; margin-top: 20px; padding-bottom: 5px;">
				캠페인 정보
				<?php //if($cmp_term == 'ing') { ?>
				<button id="btn_update_worth" class="btn btn-success btn-xs" type="button" style="margin-left: 5px;">기부가치 갱신하기</button>
				<?php //} ?>
			</div>

			<table class="dn_list" style="border-top: 1px solid silver;">
			<tr>
			  <th class='text-center'>캠페인명</th>
			  <th class='text-center'>주관단체</th>
			  <th class='text-center'>기부가치</th>
			  <th class='text-center'>생성일</th>
			  <th class='text-center'>기간</th>
			</tr>
			<tr class="dn_list_row">
			  <td>
				<?php if( isset($cmp_row->dn_new_cnt) && $cmp_row->dn_new_cnt > 0 ) { ?>
					<button class="btn btn-warning-flat btn-xs me-2" data-idx="<?php echo $cmp_row->idx ?>">NEW (<?php echo $cmp_row->dn_new_cnt ?>)</button>
				<?php } ?>
				<?php if( isset($cmp_row->dn_list[0]) ) { ?>
					<button class="btn btn-primary-flat btn-xs me-2" data-idx="<?php echo $cmp_row->idx ?>">상세내역 (<?php echo ( isset($cmp_row->dn_total_cnt) && $cmp_row->dn_total_cnt > 0 ) ? $cmp_row->dn_total_cnt : 0 ?>)</button>
				<?php } ?>
				<div class="ellipsis" style="font-weight:bold;"><?php echo $cmp_row->cmp_title ?></div>
			  </td>
			  <td class="text-center"><?php echo $cmp_row->cmp_org_name ?></td>
			  <td class="text-center"><?php echo $dnval_tot_comma?></td>
			  <td class="text-center" style="width: 120px;"><?php echo $cmp_row->reg_date ?></td>
			  <td class="text-center" style="width: 220px;"><?php echo $cmp_row->cmp_term ?></td>
			</tr>
			</table>



			<div style="width: 140px; font-size:16px; font-weight: bold; margin-top: 20px; padding-bottom: 5px;">검색 필터</div>
			<div>

				<?php echo form_open($this->uri->uri_string(), array('id'=>'search_form','name'=>'search_form','method'=>'GET', 'autocomplete'=>'off')); ?>
					<div class="panel panel-sliver-flat">
					  <div class="panel-heading">

<?php 

	/** - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	 * 검색
	*/
	// [1] 배송상태
		$select_options__tracking_dvcd_state = array(
			'all'    => '전체',
			'02:배송완료'    => '02차 배송완료',
			'02:배송출발'   => '02차 배송출발',
			'02:집화처리'   => '02차 집화처리',
			'02:집화지시'   => '02차 집화지시',
			'01:배송완료'   => '01차 배송완료',
			'01:배송출발'   => '01차 배송출발',
			'01:집화처리'   => '01차 집화처리',
			'01:집화지시'   => '01차 집화지시',
		);

		$select_options__tracking_cd_state = array(
			''     => '전체',
			'접수'  => '접수',
			'수거'  => '수거',
			'검수'  => '검수',
			'완료'  => '완료',
		);

	// [2] 기부 아이디
		$search_text__dn_no = array(
			'name'	=> 'dn_no',
			'id'	=> 'dn_no',
			'value' => ($srh['dn_no']) ? $srh['dn_no'] : set_value('dn_no'),
			'maxlength'	=> 10,
			'class'	=> 'o_input'
		);
		
		$search_text__donor_name = array(
			'name'	=> 'donor_name',
			'id'	=> 'donor_name',
			'value' => ($srh['donor_name']) ? $srh['donor_name'] : set_value('donor_name'),
			'maxlength'	=> 40,
			'class'	=> 'o_input'
		);

		$search_text__donor_phone = array(
			'name'	=> 'donor_phone',
			'id'	=> 'donor_phone',
			'value' => ($srh['donor_phone']) ? $srh['donor_phone'] : set_value('donor_phone'),
			'maxlength'	=> 20,
			'class'	=> 'o_input'
		);


		$search_text__srh_date_start = array(
			'name'	=> 'srh_date_start',
			'id'	=> 'srh_date_start',
			'value' => ($srh['srh_date_start']) ? $srh['srh_date_start'] : set_value('srh_date_start'),
			'maxlength'	=> 20,
			'class'	=> 'sdatetimepicker  o_input',
			'style' => 'width: 120px; text-align: center;'
		);

		$search_text__srh_date_end = array(
			'name'	=> 'srh_date_end',
			'id'	=> 'srh_date_end',
			'value' => ($srh['srh_date_end']) ? $srh['srh_date_end'] : set_value('srh_date_end'),
			'maxlength'	=> 20,
			'class'	=> 'edatetimepicker  o_input',
			'style' => 'width: 120px; text-align: center;'
		);

		$search_radio__srh_reg_dt = array(
			'name'          => 'dn_srh_dt',
			'id'            => 'srh_reg_dt',
			'value'         => 'reg_dt',
			'checked'       => ($srh['dn_srh_dt'] == 'reg_dt') ? true : false,
			'style'         => 'margin:10px 5px 10px 15px'
		);
		$search_radio__srh_return_dt = array(
			'name'          => 'dn_srh_dt',
			'id'            => 'srh_return_dt',
			'value'         => 'return_dt',
			'checked'       => ($srh['dn_srh_dt'] == 'return_dt') ? true : false,
			'style'         => 'margin:10px 5px 10px 15px'
		);

?>

							<dl class="dsp_flex">
								<dt>배송현상태 : </dt>
								<dd style="padding-left: 10px;">
									<?php echo form_dropdown('tracking_dvcd_state', $select_options__tracking_dvcd_state, $srh['tracking_dvcd_state'], 'class="o_selectbox"'); ?>
									<!-- <select name="tracking_dvcd_state" >
										<option value="">전체</option>
										<option value="02:배송완료">02차 배송완료</option>
										<option value="02:배송출발">02차 배송출발</option>
										<option value="02:집화처리">02차 집화처리</option>
										<option value="02:집화지시">02차 집화지시</option>
										<option value="01:배송완료">01차 배송완료</option>
										<option value="01:배송출발">01차 배송출발</option>
										<option value="01:집화처리">01차 집화처리</option>
										<option value="01:집화지시">01차 집화지시</option>
									</select> -->
								</dd>
								<dt style="padding-left: 30px;">검수진행상태 : </dt>
								<dd style="padding-left: 10px;">
									<?php echo form_dropdown('tracking_cd_state', $select_options__tracking_cd_state, $srh['tracking_cd_state'], 'class="o_selectbox"'); ?>
									<!-- <select name="tracking_cd_state" >
										<option value="">전체</option>
										<option value="접수">접수</option>
										<option value="수거">수거</option>
										<option value="검수">검수</option>
										<option value="완료">완료</option>
									</select> -->
								</dd>
							</dl>
							<dl class="dsp_flex">
								<dt>기부아이디 : </dt>
								<dd style="padding-left: 10px;">
									<?php echo form_input($search_text__dn_no); ?>
								</dd>
							</dl>
							<dl class="dsp_flex">
								<dt>기부자이름 : </dt>
								<dd style="padding-left: 10px;">
									<?php echo form_input($search_text__donor_name); ?>
								</dd>
								<dt style="padding-left: 20px;">연락처 : </dt>
								<dd style="padding-left: 10px;">
									<?php echo form_input($search_text__donor_phone); ?>
								</dd>
							</dl>
							<dl class="dl_srhdate dsp_flex">
								<dt>검색기간 : </dt>
								<dd style="padding-left: 10px;">
								  <div class="dsp_flex">
								    <label for="srh_reg_dt" class="dsp_flex_y_center">
										<?php echo form_radio($search_radio__srh_reg_dt); ?> <span style="padding-left: 3px;">기부접수일</span>
									</label>
									<label for="srh_return_dt" class="dsp_flex_y_center">
										<?php echo form_radio($search_radio__srh_return_dt); ?> <span style="padding-left: 3px;">수거신청일</span>
									</label>
								  </div>
								</dd>
								<dd style="padding-left: 5px;">
									<!-- <input type="text" name="srh_date_start" class="sdatetimepicker"  style="width: 120px; text-align: center;" /> ~ <input type="text" name="srh_date_end" class="edatetimepicker"  style="width: 120px; text-align: center; " /> -->
									<?php echo form_input($search_text__srh_date_start); ?> ~ <?php echo form_input($search_text__srh_date_end); ?>
								</dd>
								<dd style="padding-left: 10px;"><?php echo form_submit('search', '검색', 'class="btn btn-dark btn-sm px-2 py-1"'); ?></dd>
							</dl>

					  </div>
					</div>
				<?php echo form_close(); ?>

			</div>

			<div style="width: 140px; font-size:16px; font-weight: bold; margin-top: 20px; padding-bottom: 5px;">기부 상세 내역</div>
			<table class="table table-hover dn_detail_list" style="width:100%;">
				<tr>
				  <th class='text-center' style="width: 20px; height: 32px;">NEW</th>
				  <th class='text-center' style="width: 50px;">NO</th>
				  <!-- <th class='text-center'>아이디</th> -->
				  <th class='text-center' style="width: 100px;">이름</th>
				  <th class='text-center' style="width: 140px;">연락처</th>
				  <th class='text-center' style="width: 200px;">이메일</th>
				  <th class='text-center' style="width: 140px;">기부일시</th>
				  <!-- <th class='text-center'>신청옵션</th> -->
				  <th class='text-center' style="width: 100px;">영수증신청</th>
				  <?php //if('112.185.52.193' == REMOTE_ADDR){ ?>
				  <th style="text-align: right; width:60px;">기부아이디</th>
				  <?php //} ?>
				  <th class='text-center' style="width:60px;">상태</th>
				  <th class='text-center' style="width:60px;">내역</th>
				  <!-- <th class='text-center' style="width:110px;">기부접수</th> -->
				  <th class='text-center' style="width:130px;">배송상태</th>
				  <th class='text-center' style="width:110px;">수거신청일시</th>
				  <th class="text-center" style="width:70px;">관리</th>
				  <th class='text-center' style="width:110px;">삭제보고서</th>
				  <th class='text-center' style="width:100px;">기부가치</th>
				  <th></th>
				</tr>
				<?php foreach($dn_list as $j => $dn) { ?>
				<tr style="<?php echo $dn->cancel_bg; ?>">
				  <td class="text-center">
					<?php echo IS_NULL($dn->mng_chk) ? '<button class="btn btn-warning-flat btn-xs  allow-select" disabled>NEW</button>' : ''; ?>
					<?php echo ! IS_NULL($dn->cancel) ? '<button class="btn btn-secondary btn-xs  allow-select" disabled>취소</button>' : ''; ?>
				  </td>
				  <td class="text-center"><?php echo $dn->num ?></td>
				  <!-- <td><div class="ellipsis"><?php //echo ($dn->user_idx > 0) ? $dn->user_username : '(비회원)' ?></div></td> -->
				  <td class="text-center"><?php echo $dn->donor_name ?></td>
				  <td class="text-center"><?php echo $dn->cellphone ?></td>
				  <td><div class="ellipsis"><?php echo (isset($dn->user_idx) && $dn->user_idx > 0) ? $dn->user_email : '(비회원)' ?></div></td>
				  <td class="text-center">
					<?php echo $dn->reg_dt ?>
				  </td>
				  <!-- <td class="text-center"><?php //echo $dn->opt_request_ko ?></td> -->
				  <td class="text-center"><?php echo (isset($dn->receipt_req_dt) && '' != $dn->receipt_req_dt) ? substr($dn->receipt_req_dt,0,10) : ''; ?></td>

				  <?php //if('112.185.52.193' == REMOTE_ADDR){ ?>
				  <td style="font-size: 15px; text-align: center;"><?php echo $dn->idx; ?></td>
				  <?php //} ?>

				  <td class="text-center"><?php echo $dn->state_step ?></td>
				  <td class="text-center"><a href="/admin/campaign/donation/donor/<?php echo $cmp_row->code ?>/<?php echo $dn->idx ?>/<?php echo $dn->user_idx ?>"><button type="button" class="btn btn-outline-dark btn-xs  allow-select">보기</button></a></td>
				  <!-- <td class="text-center"><?php //echo isset($dn->cj_book_dt) ? $dn->cj_book_dt : ''; ?></td> -->
				  <td class="text-center"><?php echo $dn->cj_tracking_no ?> <?php echo $dn->tracking_state ?></td>
				  <td class="text-center" title="기부접수: <?php echo isset($dn->cj_book_dt) ? $dn->cj_book_dt : ''; ?>">
					<?php if(isset($dn->cj_return) && 'success' == $dn->cj_return && isset($dn->cj_return_dt) && ''!=$dn->cj_return_dt) { ?>
						<div><?php echo $dn->cj_return_dt ?></div>
					<?php } else if( isset($dn->cj_book_dt_succ) && '' != $dn->cj_book_dt_succ ) { ?>
						<div style="color: #e0e0e0;"><?php //echo $dn->cj_book_dt_succ ?></div>
					<?php } ?>
				  </td>
				  <td  class="text-center">
					<?php
					// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - 
					// 경사원 캠페인만 택배 재접수 및 재반품 버튼 활성화 
					// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - 
					// if('redi' == $cmp_row->code  &&  $dn->idx > 501) {
						
					// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - 
					// 모든 캠페인에서 택배 재접수 및 재반품 버튼 활성화 
					// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - 
					if($dn->idx > 501) {
					?>

						<?php
						// [1] 재접수 - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
						// 택배접수 재접수 버튼
						if('success' != $dn->cj_book) { ?>
						<a href="#" id="btn_book_<?php echo $dn->idx ?>" onclick="retry_cj_book('<?php echo $dn->idx ?>'); return false;" title="[택배접수실패] <?php echo $dn->cj_book ?>"><button class="btn btn-primary btn-xs  allow-select">재접수</button></a>
						<?php } ?>

						<?php
						// [2] 재반품 - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
						// 택배반품 재반품 버튼
						// 아직 유저가 '수거신청'을 누르지 않은 따끈따근한 상태
						if(IS_NULL($dn->cj_return)) {
						?>
							<!-- <a href="#" onclick="retry_cj_return('<?php echo $dn->idx ?>'); return false;" title="수거신청을 누르지 않은 따끈따끈한 상태의 기부"><button class="btn btn-dark btn-xs  allow-select">재반품</button></a> -->
						<?php 
						}
						// '수거요청'을 눌렀으나 '반품'이 정상적으로 되지 않은 상태
						elseif('success' != $dn->cj_return) {
						?>
							<a href="#" id="btn_return_<?php echo $dn->idx ?>" onclick="retry_cj_return('<?php echo $dn->idx ?>'); return false;" title="[반품등록실패] <?php echo $dn->cj_return ?>"><button class="btn btn-warning btn-xs  allow-select">재수거</button></a>
						<?php
						}
						?>
					<?php } ?>
				  </td>
				  <td class="text-center">
					<?php if(! is_null($dn->del_date)) { ?><a href="<?php echo base_url('admin/campaign/donation/report_del_ros/'.$cmp_row->code.'/'.$dn->idx) ?>" target="_blank" class="btn btn-outline-dark btn-xs">삭제보고서</a><?php } ?>
				  </td>
				  <td><div style="text-align: right;"><?php echo $dn->donation_val_comma; ?></div></td>
				  <td></td>
				</tr>
				<?php } ?>
			</table>





			<?php if( ! $srh['get__tracking_info']) { ?>
			<div style="width: 140px; font-size:16px; font-weight: bold; margin-top: 30px; padding-bottom: 5px;">기부 취소 내역</div>
			<table class="table table-hover dn_detail_list" style="width:100%;">
				<tr>
				  <th class='text-center' style="width: 20px; height: 32px;">NEW</th>
				  <th class='text-center' style="width: 50px;">NO</th>
				  <th class='text-center' style="width: 100px;">이름</th>
				  <th class='text-center' style="width: 140px;">연락처</th>
				  <th class='text-center' style="width: 200px;">이메일</th>
				  <th class='text-center' style="width: 140px;">기부일시</th>
				  <th class='text-center' style="width: 120px;">영수증신청</th>
				  <?php //if('112.185.52.193' == REMOTE_ADDR){ ?>
				  <th style="text-align: right; width:60px;">기부아이디</th>
				  <?php //} ?>
				  <th class='text-center' style="width:60px;">상태</th>
				  <th class='text-center' style="width:60px;">내역</th>
				  <th class="text-center" style="width:70px;">관리</th>
				  <th class='text-center' style="width:110px;">수거신청일시</th>
				  <th class='text-center' style="width:110px;">배송상태</th>
				  <th class='text-center' style="width:110px;">삭제보고서</th>
				  <th class='text-center' style="width:110px;">삭제일시</th>
				  <th></th>
				</tr>
				<?php foreach($dn_cancel_result['qry'] as $j => $dn) { ?>
				<tr style="background-color: #eeeeee;">
				  <td class="text-center">
					
				  </td>
				  <td class="text-center"><?php echo $dn->num ?></td>
				  <td class="text-center"><?php echo $dn->donor_name ?></td>
				  <td class="text-center"><?php echo $dn->cellphone ?></td>
				  <td><div class="ellipsis"><?php echo (isset($dn->email ) && $dn->user_idx > 0) ? $dn->email : '(비회원)' ?></div></td>
				  <td class="text-center">
					<?php echo isset($dn->reg_datetime) ? substr($dn->reg_datetime,0,10) : ''; ?>
				  </td>
				  <td class="text-center"><?php echo (isset($dn->receipt_req_dt) && '' != $dn->receipt_req_dt) ? substr($dn->receipt_req_dt,0,10) : ''; ?></td>
				  <?php //if('112.185.52.193' == REMOTE_ADDR){ ?>
				  <td style="font-size: 15px; text-align: center;"><?php echo $dn->idx; ?></td>
				  <?php //} ?>

				  <td class="text-center"><?php echo ! IS_NULL($dn->cancel) ? '<button class="btn btn-secondary btn-xs  allow-select" disabled>취소</button>' : ''; ?></td>
				  <td class="text-center"><a href="/admin/campaign/donation/donor/<?php echo $cmp_row->code ?>/<?php echo $dn->idx ?>/<?php echo $dn->user_idx ?>"><button type="button" class="btn btn-outline-dark btn-xs  allow-select">보기</button></a></td>
				  <td  class="text-center">
				  </td>
				  <td class="text-center" title="기부접수: <?php echo isset($dn->cj_book_dt) ? $dn->cj_book_dt : ''; ?>">
				  </td>
				  <td class="text-center"></td>
				  <td class="text-center">
					<?php if(! is_null($dn->del_date)) { ?><a href="<?php echo base_url('admin/campaign/donation/report_del_ros/'.$cmp_row->code.'/'.$dn->idx) ?>" target="_blank" class="btn btn-outline-dark btn-xs">삭제보고서</a><?php } ?>
				  </td>
				  <td class="text-center">
					<?php echo isset($dn->delete) ? substr($dn->delete,0,16) : ''; ?>
				  </td>
				  <td></td>
				</tr>
				<?php } ?>
			</table>
			<?php } ?>

</div>














<script type="text/javascript">
$(document).ready(function(){

  $('.close_viewStateWeekModal').on('click',function(){
	  $('.dn_list_row').removeClass('clicked');
  });

  $('.btn_list_cnt_week').on('click',function(){

	$('.dn_list_row').removeClass('clicked');

	let cmp_idx = $(this).data('idx');
	let cmp_code = $(this).data('code');
	let cmp_ttl = $(this).data('cmpttl');

	// console.log(cmp_idx);
	// console.log(cmp_code);
	// console.log(cmp_ttl);

	$('#viewStatWeekModalLabel').html(cmp_ttl);

	var request = $.ajax({
	  url: "/admin/campaign/call_visit_stat_week/",
	  method: "POST",
	  data: { 'cmp_code' : cmp_code  /* , '<?php echo $this->security->get_csrf_token_name() ?>':'<?php echo $this->security->get_csrf_hash() ?>' */},
	  dataType: "html"
	});
	request.done(function( res ) {
	  //console.log(res);

	  //$('.tr_'+cmp_code+' td').css('background-color','#cccccc');
	  $('.tr_'+cmp_code).addClass('clicked');
	  $('#viewStatWeekModalContent').html(res);

	});
	request.fail(function( jqXHR, textStatus ) {
	  alert( "Request failed: " + textStatus );
	  console.log(error);
	  //alert( "access error.." );
	  return false;
	});

  });
});
</script>


<script>
// 택배 재접수
// retry_cj_book
function retry_cj_book(dn_idx){

		var request = $.ajax({
		  url: "/trans/trans_retry_cj_book/",
		  method: "POST",
		  data: { 'dn_idx': dn_idx },
		  dataType: "text"
		});
		request.done(function( res ) {

			console.log(res);
			if('{"data":"success"}'==res) {
				alert('재접수가 완료되었습니다.');
				location.reload();
			}
			else {
				alert(res);
			}

		});
		request.fail(function( jqXHR, textStatus ) {
		  alert( "Request failed: " + textStatus );
		});

}

// 택배 재반품
// retry_cj_return
// {"data":"W:NotThisTime"}
function retry_cj_return(dn_idx){

		var request = $.ajax({
		  url: "/trans/trans_retry_cj_return/",
		  method: "POST",
		  data: { 'dn_idx' : dn_idx },
		  dataType: "text"
		});
		request.done(function( res ) {

			console.log(res);
			//alert(res);
			if('{"data":"success"}'==res) {
				alert('재반품이 완료되었습니다.');
				location.reload();
			}
			else if('{"data":"W:NotThisTime"}'==res){
				alert('1차 배송이 진행중입니다.\n1차 배송완료 후 눌러주세요.');
			}
			else {
				alert(res);
			}

		});
		request.fail(function( jqXHR, textStatus ) {
		  alert( "Request failed: " + textStatus );
		  console.log(error);
		  //alert( "access error.." );
		  return false;
		});

}
</script>






<script type="text/javascript">
$(document).ready(function(){
	
	var cmp_idx = <?php echo isset($cmp_row->idx) ? $cmp_row->idx : ''; ?>;
	console.log('cmp_idx: '+cmp_idx);
	
	if('' == cmp_idx) {
		alert('잘못된 경로로 접속하셨습니다.');
		location.history(-1);
		return false;
	}
	
	
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	// 세션 한정 
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	let ss_visit_chk = JSON.parse(sessionStorage.getItem('ss_visit_chk')) || {};
	// 방문 여부 체크
	const hasVisited = !!ss_visit_chk[cmp_idx];
	
	if (!hasVisited) {
		console.log('첫 방문');
		ss_visit_chk[cmp_idx] = true;

		// 저장
		//localStorage.setItem('ss_visit_chk', JSON.stringify(ss_visit_chk));
		sessionStorage.setItem('ss_visit_chk', JSON.stringify(ss_visit_chk));
		
		// 갱신
		update_status_list();
	} else {
		console.log('이미 방문한 캠페인');
	}

	
	
	

	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	// localStorage + 객체(Map) 구조
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	/*
	// 기존 방문 기록 불러오기
	let ss_visit_chk = JSON.parse(localStorage.getItem('ss_visit_chk')) || {};

	// 방문 여부 체크
	const hasVisited = !!ss_visit_chk[cmp_idx];

	if (!hasVisited) {
		console.log('첫 방문');
		ss_visit_chk[cmp_idx] = true;

		// 저장
		localStorage.setItem('ss_visit_chk', JSON.stringify(ss_visit_chk));
		
		// 갱신
		update_status_list();
	} else {
		console.log('이미 방문한 캠페인');
	}
	*/
		
		


	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	// php 세션
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	/*
	// 최초 접속시 검수 및 배송상태 갱신
	var ss_update_chk = '<?php echo $ss_update_chk ?>';
	if('true' != ss_update_chk) {
		// 갱신
		update_status_list();
	}
	*/

	// 검수 및 배송 상태 갱신
	$('#btn_update_status').on('click', function(){

		// 갱신
		update_status_list();

	});


	function update_status_list() {


			// 캠페인 idx 가 있으면 그 캠페인 꺼만, 
			// 빈 값이면 활성화 캠페인 전체
			var cmp_idx = <?php echo isset($cmp_row->idx) ? $cmp_row->idx : ''; ?>;
			//console.log('cmp_idx:'+cmp_idx);

			var request = $.ajax({
			  url: "/admin/campaign/trans_update_status_dn/",
			  method: "POST",
			  data: { 'cmp_idx' : cmp_idx },
			  dataType: "text"
			});
			request.done(function( res ) {
			  console.log(res);
			  alert(res);

			  // 페이지 새로고침
			  location.reload();

			});
			request.fail(function( jqXHR, textStatus ) {
			  alert( "Request failed: " + textStatus );
			  console.log(error);
			  //alert( "access error.." );
			  return false;
			});

	}



	// 기부가치 업데이트
	$('#btn_update_worth').on('click', function(){
		// 갱신
		update_worth_list();
	});

	// 기부가치 업데이트
	function update_worth_list() {
		
			// 캠페인 idx 가 있으면 그 캠페인 꺼만, 
			// 빈 값이면 활성화 캠페인 전체
			var cmp_idx = <?php echo isset($cmp_row->idx) ? $cmp_row->idx : ''; ?>;

			var request = $.ajax({
			  url: "/admin/campaign/trans_update_worth_dn/",
			  method: "POST",
			  data: { 'cmp_idx' : cmp_idx },
			  dataType: "text"
			});
			request.done(function( res ) {
			  console.log(res);
			  alert(res);

			  // 페이지 새로고침
			  location.reload();

			});
			request.fail(function( jqXHR, textStatus ) {
			  alert( "Request failed: " + textStatus );
			  console.log(error);
			  //alert( "access error.." );
			  return false;
			});

	}





});
</script>

<script>
$('.sdatetimepicker').datetimepicker({
	lang:'kr',
	//format:'Y-m-d H:i:s',
	//format:'Y-m-d H:00:00',
	format:'Y-m-d',
	timepicker:false,
	yearStart:'2025',
	//yearEnd:'2035'
});
$('.edatetimepicker').datetimepicker({
	lang:'kr',
	//format:'Y-m-d H:i:s',
	//format:'Y-m-d H:59:59',
	format:'Y-m-d',
	timepicker:false,
	yearStart:'2025',
	//yearEnd:'2035'
});
</script>


