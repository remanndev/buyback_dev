<style type="text/css">
.dn_list { width: 100%; /* max-width: 1800px; */}
.dn_list tr th { background-color: #6d6d6d; color:#ffffff; }
.dn_list tr.dn_list_row td { background-color: #fafafa; color: #474747; font-size: 15px;}

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
</style>

<h1>기부 목록</h1>

<h2 class="mb_40 dsp_flex" style="color:#353535; line-height: 30px;">
	<div>캠페인별 기부 목록</div>
	<div style="font-weight: normal; font-size: 15px; margin-left: 25px;">
		<a class="btn btn-<?php echo ('ing' == $term) ? '' : 'outline-'; ?>secondary btn-ssm" href="/admin/campaign/donate/lists?term=ing">진행중</a>
		<a class="btn btn-<?php echo ('end' == $term) ? '' : 'outline-'; ?>secondary btn-ssm" href="/admin/campaign/donate/lists?term=end">종료</a>
		<a class="btn btn-<?php echo ('' == $term OR 'all' == $term) ? '' : 'outline-'; ?>secondary btn-ssm" href="/admin/campaign/donate/lists?term=all">전체</a>
	</div>
</h2>





<!-- Modal - 캠페인별 주간 통계 -->
<!-- Vertically centered scrollable modal -->
<div class="modal fade" id="viewStatWeekModal" tabindex="-1" aria-labelledby="viewStatWeekModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h6 class="modal-title" id="viewStatWeekModalLabel"></h6>
        <button type="button" class="btn-close close_viewStateWeekModal" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div id="viewStatWeekModalContent" class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary close_viewStateWeekModal" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>






<div class="tbl_frm" style="border:none;">
	<table class="dn_list">
	<tr>
	  <th class='text-center'>NO</th>
	  <th class='text-center' title="누적 view 수">누적뷰</th>
	  <th class='text-center' title="이번 주 view 수">금주뷰</th>
	  <th class='text-center' title="주별 view 수 합계" style="width: 100px;">주간통계</th>
	  <th class='text-center'>캠페인명</th>
	  <th class='text-center'>주관단체</th>
	  <th class='text-center'>기부가치(원)</th>
	  <th class='text-center'>생성일</th>
	  <th class='text-center'>기간</th>
	  <!-- <th class='text-center'>기부 상세</th> -->
	</tr>
	<?php
		$is_ended = '';
		foreach($list as $i => $o) {
			$is_ended = '';
			if( TIME_YMD > $o->cmp_term_end ) {
				$is_ended = 'cmp_ended';
			}
	?>
	<tr class="dn_list_row tr_<?php echo $o->cmp_code ?>  <?php echo $is_ended ?>">
	  <td class="text-center"><?php echo $o->num ?></td>
	  <td class="text-center" title="누적 view 수"><?php echo number_format($o->visit_human) ?></td>
	  <td class="text-center" title="이번 주 view 수">
		<?php echo number_format($o->visit_human_thisweek) ?>
	  </td>
	  <td class="text-center" title="주별 view 수 합계">
		<button class="btn btn-default-flat btn-xs me-2  btn_list_cnt_week"  data-bs-toggle="modal" data-bs-target="#viewStatWeekModal" data-idx="<?php echo $o->idx ?>" data-code="<?php echo $o->cmp_code ?>" data-cmpttl="<?php echo $o->cmp_title ?>">주간 통계</button>
	  </td>
	  <td>
		<?php if( isset($o->dn_new_cnt) && $o->dn_new_cnt > 0 ) { ?>
			<button class="btn btn-warning-flat btn-xs me-2  btn_dn_list" data-idx="<?php echo $o->idx ?>">NEW (<?php echo $o->dn_new_cnt ?>)</button>
		<?php } ?>
		<?php if( isset($o->dn_list[0]) ) { ?>
			<button class="btn btn-primary-flat btn-xs me-2  btn_dn_list" data-idx="<?php echo $o->idx ?>">상세내역 (<?php echo ( isset($o->dn_total_cnt) && $o->dn_total_cnt > 0 ) ? $o->dn_total_cnt : 0 ?>)</button>
		<?php } ?>
		<div class="ellipsis" style="font-weight:bold;"><?php echo $o->cmp_title ?></div>
	  </td>
	  <td class="text-center"><?php echo $o->cmp_org_name ?></td>
	  <td class="text-center"><?php echo $o->dnval_tot_val ?></td>
	  <td class="text-center" style="width: 120px;"><?php echo $o->reg_date ?></td>
	  <td class="text-center" style="width: 220px;"><?php echo $o->cmp_term ?></td>
	</tr>

	<?php if( isset($o->dn_list[0]) ) { ?>
	<tr id="dn_list_<?php echo $o->idx ?>" class="d-none">
		<td></td>
		<td colspan="8" style="padding:15px 0px 35px 0;">
		  <div>
			<div style="width: 140px; font-size:16px; font-weight: bold; padding-bottom: 5px;">기부 상세 내역</div>
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
				  <th class='text-center' style="width: 120px;">영수증신청</th>
				  <?php //if('112.185.52.193' == REMOTE_ADDR){ ?>
				  <th style="text-align: right; width:60px;">기부아이디</th>
				  <?php //} ?>
				  <th class='text-center' style="width:60px;">상태</th>
				  <th class='text-center' style="width:60px;">내역</th>
				  <th class="text-center" style="width:70px;">관리</th>
				  <!-- <th class='text-center' style="width:110px;">기부접수</th> -->
				  <th class='text-center' style="width:110px;">수거신청일시</th>
				  <th class='text-center' style="width:110px;">배송상태</th>
				  <th class='text-center' style="width:110px;">삭제보고서</th>
				  <th></th>
				</tr>
				<?php foreach($o->dn_list as $j => $dn) { ?>
				<tr style="<?php echo $dn->cancel_bg; ?>">
				  <td class="text-center">
					<?php echo IS_NULL($dn->mng_chk) ? '<button class="btn btn-warning-flat btn-xs  allow-select">NEW</button>' : ''; ?>
					<?php echo ! IS_NULL($dn->cancel) ? '<button class="btn btn-secondary btn-xs  allow-select">취소</button>' : ''; ?>
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
				  <td class="text-center"><a href="/admin/campaign/donate/donor/<?php echo $o->cmp_code ?>/<?php echo $dn->idx ?>/<?php echo $dn->user_idx ?>"><button type="button" class="btn btn-outline-dark btn-xs  allow-select">보기</button></a></td>
				  <td  class="text-center">
					<?php /* <!-- <a href="#" onclick="del_confirm_remove(this,'<?php echo $o->cmp_code ?>','<?php echo $dn->idx ?>'); return false;"><button class="btn btn-outline-danger btn-xs  allow-select">삭제</button></a> --> */ ?>

					<?php
					// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - 
					// 경사원 캠페인만 택배 재접수 및 재반품 버튼 활성화 
					// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - 
					if('redi' == $o->cmp_code  &&  $dn->idx > 501) { ?>

						<?php
						// [1] 재접수 - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
						// 택배접수 재접수 버튼
						if('success' != $dn->cj_book) { ?>
						<a href="#" id="btn_book_<?php echo $dn->idx ?>" onclick="retry_cj_book('<?php echo $dn->idx ?>'); return false;" title="[택배접수실패] <?php echo $dn->cj_book ?>"><button class="btn btn-primary btn-xs  allow-select">재접수!</button></a>
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
							<a href="#" id="btn_return_<?php echo $dn->idx ?>" onclick="retry_cj_return('<?php echo $dn->idx ?>'); return false;" title="[반품등록실패] <?php echo $dn->cj_return ?>"><button class="btn btn-warning btn-xs  allow-select">재반품</button></a>
						<?php
						}
						?>

					<?php } ?>


				  </td>

				  <!-- <td class="text-center"><?php //echo isset($dn->cj_book_dt) ? $dn->cj_book_dt : ''; ?></td> -->
				  <td class="text-center" title="기부접수: <?php echo isset($dn->cj_book_dt) ? $dn->cj_book_dt : ''; ?>">

					<?php //echo isset($dn->cj_return_dt) ? $dn->cj_return_dt : ''; ?>

					<?php if(isset($dn->cj_return) && 'success' == $dn->cj_return && isset($dn->cj_return_dt) && ''!=$dn->cj_return_dt) { ?>
						<div><?php echo $dn->cj_return_dt ?></div>
					<?php } else if( isset($dn->cj_book_dt_succ) && '' != $dn->cj_book_dt_succ ) { ?>
						<div style="color: #e0e0e0;"><?php //echo $dn->cj_book_dt_succ ?></div>
					<?php } ?>

				  </td>
				  <td class="text-center"><?php echo $dn->cj_tracking_no ?> <?php echo $dn->tracking_state ?></td>
				  <td class="text-center"><!-- https://replus.kr/admin/campaign/donate/report_del_ros/redi/405 -->
					<?php // echo $dn->del_date ?>
					<?php if(! is_null($dn->del_date)) { ?><a href="<?php echo base_url('admin/campaign/donate/report_del_ros/'.$o->cmp_code.'/'.$dn->idx) ?>" target="_blank" class="btn btn-outline-dark btn-xs">삭제보고서</a><?php } ?>
				  </td>
				  <td></td>
				</tr>
				<?php } ?>
			</table>
		  </div>
		</td>
	</tr>
	<?php  } ?>
	<?php } ?>
	</table>
</div>

<script>
// 일반 삭제 검사 확인
/*
	function del_confirm_remove(obj,cmp_code,dn_idx) {
		if(confirm("\n한번 삭제한 자료는 복구할 방법이 없습니다.\n삭제하시겠습니까?")) {
			if(confirm("정말 삭제하시겠습니까?")) {
				var request = $.ajax({
				  url: "/admin/campaign/trans_donate_donor_del/",
				  method: "POST",
				  data: { 'cmp_code' : cmp_code, 'dn_idx' : dn_idx },
				  dataType: "html"
				});
				request.done(function( res ) {
					//console.log(res);
					if('succ' == res) {
						// HTML에서 tr 즉시 제거
						let tr = obj.closest("tr");
						if (tr) tr.remove();
					}
					else {
						alert('삭제되지 않았습니다.\n문제가 계속 되면 관리자에 문의해주세요.');
					}
				});
				request.fail(function( jqXHR, textStatus ) {
				  alert( "Request failed: " + textStatus );
				  console.log(error);
				  //alert( "access error.." );
				  return false;
				});
			}
		}
	}
*/
</script>

<script type="text/javascript">
$(document).ready(function(){
  $('.btn_dn_list').on('click',function(){
	let dn_idx = $(this).data('idx');
	let dn_list = $('#dn_list_'+dn_idx);
	let dsp = dn_list.css('display');
	//console.log(dsp);

	if(dsp == 'none') {
		dn_list.removeClass('d-none');
	}
	else {
		dn_list.addClass('d-none');
	}
	
  });
});
</script>

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
		  url: "/admin/campaign/trans_retry_cj_book/",
		  method: "POST",
		  data: { 'dn_idx' : dn_idx },
		  dataType: "html"
		});
		request.done(function( res ) {
		  console.log(res);
		  alert(res);

		  if('{"data":"success"}'==res) {
			  $('#btn_book_'+dn_idx).remove();
		  }

		  //$('.tr_'+cmp_code+' td').css('background-color','#cccccc');
		  //$('.tr_'+cmp_code).addClass('clicked');
		  //$('#viewStatWeekModalContent').html(res);

		});
		request.fail(function( jqXHR, textStatus ) {
		  alert( "Request failed: " + textStatus );
		  console.log(error);

		  if('{"data":"success"}'==res) {
			  $('#btn_return_'+dn_idx).remove();
		  }

		  //alert( "access error.." );
		  return false;
		});

}

// 택배 재반품
// retry_cj_return
function retry_cj_return(dn_idx){

		var request = $.ajax({
		  url: "/admin/campaign/trans_retry_cj_return/",
		  method: "POST",
		  data: { 'dn_idx' : dn_idx },
		  dataType: "html"
		});
		request.done(function( res ) {
		  console.log(res);
		  alert(res);

		  //$('.tr_'+cmp_code+' td').css('background-color','#cccccc');
		  //$('.tr_'+cmp_code).addClass('clicked');
		  //$('#viewStatWeekModalContent').html(res);

		});
		request.fail(function( jqXHR, textStatus ) {
		  alert( "Request failed: " + textStatus );
		  console.log(error);
		  //alert( "access error.." );
		  return false;
		});
}
</script>