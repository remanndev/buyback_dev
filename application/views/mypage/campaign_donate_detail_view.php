<?php //print_r($dn_list); ?>

	<div class="ctnt_wrap">
		<div class="ctnt_inside">


			<div class="row py_35">
				<div class="d-none d-lg-block col-lg-3">
					<!-- 마이페이지 사이드 메뉴 -->
					<?php $this->load->view('mypage/mypage_side_view'); ?>
				</div>
				<div class="col-12 col-lg-9">

					<!-- 캠페인 좌측 컨텐츠 -->
					<div class="mypage_ctnt">
						<h2 class="mb_40" style="color:#353535;">캠페인 관리 <small>- 기부자 상세 정보</small></h2>



						<div class="tbl_frm" style="width:100%; overflow:none; overflow-x:auto; margin-bottom: 30px;">
							<table class="table-hover">
							<tr>
							  <th class=''>캠페인명</th>
							  <th class=''>모금기간</th>
							  <th class=''>작성일자</th>
							  <th class=''>단계</th>
							</tr>
							<tr>
							  <td class=""><div class="ellipsis" style="max-width:320px;"><?php echo $cmp_row->cmp_title ?></div></td>
							  <td class=""><?php echo $cmp_row->cmp_term ?></td>
							  <td class=""><?php echo $cmp_row->reg_date ?></td>
							  <td class=""><?php echo $cmp_row->state_str ?></td>
							</tr>
							</table>
						</div>



										   
						<!-- 캠페인 좌측 컨텐츠 -->
						<div class=" mb_50">

							<div class="tbl_purple">
								<table id="dsp_goods_table" style="width:100%;">
									<colgroup>
										<col width="140" />
										<col />
									</colgroup>
									<tr>
										<th>기부자 구분</th>
										<td><?php echo $dn_row->donor_type_text; ?></td>
									</tr>
									<?php if('B' == $dn_row->donor_type_text) { ?>
									<tr>
										<th>상호명(법인명)</th>
										<td><?php echo $dn_row->company; ?></td>
									</tr>
									<?php } ?>
									<tr>
										<th>이름(담당자)</th>
										<td><?php echo $dn_row->donor_name; ?>  <?php echo ($dn_row->user_idx > 0) ? '('.$dn_row->user_username.')' : '(비회원)'; ?></td>
									</tr>
									<tr>
										<th>휴대전화</th>
										<td><?php echo $dn_row->cellphone; ?></td>
									</tr>
									<tr>
										<th>이메일</th>
										<td><?php echo $dn_row->email; ?></td>
									</tr>
									<!-- <tr>
										<th>방문주소</th>
										<td><?php //echo $dn_row->postcode; ?> <?php //echo $dn_row->addr; ?> <?php //echo $dn_row->addr_detail; ?></td>
									</tr> -->
									<tr>
										<th>기부금영수증</th>
										<td><?php echo (isset($dn_row->receipt_req_dt) && '' != $dn_row->receipt_req_dt) ? '신청 ('.substr($dn_row->receipt_req_dt,0,10).')' : '미신청'; ?></td>
									</tr>
									<!-- <tr>
										<th>기부가치</th>
										<td><?php // echo (isset($dn_row->donation_comma) && '' != $dn_row->donation_comma) ? $dn_row->donation_comma.'원' : ''; ?></td>
									</tr> -->
								</table>
							</div>

						</div>

					</div>

					<hr class="clear_both" />

				</div>
			</div>

		</div>
	</div>








<script type="text/javascript">
	// datetimepicker
	$.datetimepicker.setLocale('kr');
	$('.datepicker').datetimepicker({
		lang:'kr',
		timepicker:false,
		format:'Y-m-d',
		formatDate:'Y/m/d'
	});
</script>

<script type="text/javascript">
$(document).ready(function(){

	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	// focus on
	$('.save_dngood').on('click keypress', function() {
		$(this).css('color','red');
	});
	$('.save_dn').on('click keypress', function() {
		$(this).css('color','red');
	});
	// focus off
	$('.save_dngood').on('blur', function() {
		$(this).css('color','#000000');
	});
	$('.save_dn').on('blur', function() {
		$(this).css('color','#000000');
	});

	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	// 기부 물품 관련 정보 저장
	$('.save_dngood').on('blur keyup', function() {

		var obj = $(this);

		// focus off
		//$(this).css('color','#000000');

		//var tbl = 'donation_goods';
		var fld = $(this).data('fld');
		var idx = $(this).data('idx');
		var val = $(this).val();
		if( $(this).hasClass('treat_comma') ) {
			val = removeComma(val);
		}
		//console.log(idx +'/'+ fld +'/'+ val);
		var request = $.ajax({
		  url: "/admin/campaign/trans/dngood_update",
		  method: "POST",
		  data: { 'idx':idx,'fld':fld,'val':val },
		  dataType: "html"
		});
		request.done(function( res ) {
		  //console.log(res);
		  obj.next().css('display', 'inline-block');;
		  setTimeout(msgAutoHide, 1000, obj);
		});
		request.fail(function( jqXHR, textStatus ) {
		  alert( "Request failed: " + textStatus );
		  return false;
		});
	});

	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	// 기부자 관련 정보 저장
	$('.save_dn').on('blur keyup', function() {

		var obj = $(this);

		// focus off
		//$(this).css('color','#000000');

		//var tbl = 'donation';
		var fld = $(this).data('fld');
		var idx = $(this).data('idx');
		var val = $(this).val();
		if( $(this).hasClass('treat_comma') ) {
			val = removeComma(val);
		}
		//console.log(idx +'/'+ fld +'/'+ val);
		var request = $.ajax({
		  url: "/admin/campaign/trans/dn_update",
		  method: "POST",
		  data: { 'idx':idx,'fld':fld,'val':val },
		  dataType: "html"
		});
		request.done(function( res ) {
		  //console.log(res);
		  obj.next().css('display', 'inline-block');;
		  setTimeout(msgAutoHide, 1000, obj);
		});
		request.fail(function( jqXHR, textStatus ) {
		  alert( "Request failed: " + textStatus );
		  return false;
		});

	});


	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	// 기부가치 금액
	/*
	//$('.total_donation_value').on('propertychange change keyup paste input', function() {
	$('.total_donation_value').change(function() {

		//alert('11');

		var obj = $(this);

		// focus off
		//$(this).css('color','#000000');

		//var tbl = 'donation';
		var fld = $(this).data('fld');
		var idx = $(this).data('idx');
		var val = $(this).val();
		if( $(this).hasClass('treat_comma') ) {
			val = removeComma(val);
		}
		//console.log(idx +'/'+ fld +'/'+ val);
		var request = $.ajax({
		  url: "/admin/campaign/trans/dn_update",
		  method: "POST",
		  data: { 'idx':idx,'fld':fld,'val':val },
		  dataType: "html"
		});
		request.done(function( res ) {
		  //console.log(res);
		  obj.next().css('display', 'inline-block');;
		  setTimeout(msgAutoHide, 1000, obj);
		});
		request.fail(function( jqXHR, textStatus ) {
		  alert( "Request failed: " + textStatus );
		  return false;
		});

	});
	*/





	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	// 기부자 물품 완료 처리
	$('.save_dn_chkbox').on('click', function() {
		var chked = $(this).is(":checked");
		var chked_val = '0';
		if( chked ) {
			chked_val = '1';
		}

		var obj = $(this);

		//var tbl = 'donation';
		var fld = $(this).data('fld');
		var idx = $(this).data('idx');
		var val = chked_val;
		if( $(this).hasClass('treat_comma') ) {
			val = removeComma(val);
		}
		//console.log(idx +'/'+ fld +'/'+ val);
		var request = $.ajax({
		  url: "/admin/campaign/trans/dn_update",
		  method: "POST",
		  data: { 'idx':idx,'fld':fld,'val':val },
		  dataType: "html"
		});
		request.done(function( res ) {
		  //console.log(res);
		  obj.next().css('display', 'inline-block');;
		  setTimeout(msgAutoHide, 1000, obj);
		});
		request.fail(function( jqXHR, textStatus ) {
		  alert( "Request failed: " + textStatus );
		  return false;
		});

	});

	// saved 완료 메시지 출력 후 사라짐
	function msgAutoHide(obj) {
	  obj.next().fadeOut();
	}

	



	// 금액 콤마 처리
	$('.treat_comma').on('keyup blur', function() {
		str = addComma(removeComma($(this).val()));
		$(this).val(str);
	});


	// 기부가치 합산 기부가치로 더해주기.
	$('.chk_recycle_worth').on('blur', function() {
		obj = $(this);
		calc_donation_value(obj);
	});
	$('.chk_reuse_worth').on('blur', function() {
		obj = $(this);
		calc_donation_value(obj);
	});

	function calc_donation_value(obj) {
		var dn_val = addComma( Number(removeComma($('.chk_recycle_worth').val())) + Number(removeComma($('.chk_reuse_worth').val())) );
		$('#donation_value').val(dn_val);
		$('#donation_value').focus();
		$('#donation_value').blur();
	}

});
</script>