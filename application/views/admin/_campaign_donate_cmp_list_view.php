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

<h1>기부 관리</h1>

<h2 class="mb_40 dsp_flex" style="color:#353535; line-height: 30px;">
	<div>캠페인 목록</div>
	<div style="font-weight: normal; font-size: 15px; margin-left: 25px;">
		<a class="btn btn-<?php echo ('ing' == $term) ? '' : 'outline-'; ?>secondary btn-ssm" href="/admin/campaign/donate/cmp_list?term=ing">진행중</a>
		<a class="btn btn-<?php echo ('end' == $term) ? '' : 'outline-'; ?>secondary btn-ssm" href="/admin/campaign/donate/cmp_list?term=end">종료</a>
		<a class="btn btn-<?php echo ('' == $term OR 'all' == $term) ? '' : 'outline-'; ?>secondary btn-ssm" href="/admin/campaign/donate/cmp_list?term=all">전체</a>
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
	   <a href="<?php echo base_url('admin/campaign/donate/cmp_dn_list/'.$o->idx); ?>" target="blank">
		<?php if( isset($o->dn_new_cnt) && $o->dn_new_cnt > 0 ) { ?>
			<button class="btn btn-warning-flat btn-xs me-2" data-idx="<?php echo $o->idx ?>">NEW (<?php echo $o->dn_new_cnt ?>)</button>
		<?php } ?>
		<?php if( isset($o->dn_list[0]) ) { ?>
			<button class="btn btn-primary-flat btn-xs me-2" data-idx="<?php echo $o->idx ?>">상세내역 (<?php echo ( isset($o->dn_total_cnt) && $o->dn_total_cnt > 0 ) ? $o->dn_total_cnt : 0 ?>)</button>
		<?php } ?>
		<div class="ellipsis" style="font-weight:bold;"><?php echo $o->cmp_title ?></div>
	   </a>
	  </td>
	  <td class="text-center"><?php echo $o->cmp_org_name ?></td>
	  <td class="text-center"><?php echo $o->dnval_tot_val ?></td>
	  <td class="text-center" style="width: 120px;"><?php echo $o->reg_date ?></td>
	  <td class="text-center" style="width: 220px;"><?php echo $o->cmp_term ?></td>
	</tr>
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