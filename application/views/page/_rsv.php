<?php //echo validation_errors(); ?>

<?php
// $arr_seg[3]
?>

<style type='text/css'>
#contents .down_btn {background:#f5f2df; font-size:16px; color:#aca000; border:1px solid #e2dec2; line-height:45px; width:200px; margin:0 auto; display:block; font-weight:bold; text-align:center;}

#contents .type_tab{position:relative; text-align:center; }
#contents .type_tab .tab_on{position:relative; display:inline-block; color:#fff; background:#aba000; border:1px solid #aba000; line-height:40px; box-sizing:border-box; font-size:16px; font-weight:600; text-align:center; width:300px;}
#contents .type_tab .tab_off{position:relative; display:inline-block; color:#777; background:#fff; border:1px solid #ccc; line-height:40px; box-sizing:border-box; font-size:16px; font-weight:400; text-align:center; width:300px;}


.box1200{position:relative; width:1200px; margin:0 auto;}


#contents .add1 {position:relative; }
#contents .add1 table {position:relative; border-top:2px solid #333;}
#contents .add1 th {position:relative; padding:12px 10px; background:#f8f8f8; border-bottom:1px solid #ddd; background-clip: padding-box; line-height:35px; text-align:center; font-family: 'Noto Sans KR', sans-serif;  font-size:17px; color:#222; font-weight:500; word-spacing:0em; letter-spacing:-0.05em; }
#contents .add1 td {position:relative; padding:12px 10px; background:#fff;  border-bottom:1px solid #ddd; background-clip: padding-box;  line-height:35px; text-align:left; font-family: 'Noto Sans KR', sans-serif;  font-size:17px; color:#666; font-weight:400; word-spacing:0em; letter-spacing:-0.05em; }
#contents .add1 .input1 {border:1px solid #ddd; background:#fff; box-sizing:border-box; border-radius:5px; line-height:36px; height:38px; color:#333; font-size:15px; font-family: 'Noto Sans KR'; font-weight:400; word-spacing:0em; letter-spacing:-0.05em; text-indent:5px; vertical-align:top; }
#contents .add1 input::-webkit-input-placeholder {color:#999;}
#contents .add1 input::-moz-placeholder {color:#999;}

#contents .add1 .btn_address {display:inline-block; padding:0 20px; border:1px solid #777; border-radius:5px; box-sizing:border-box; background:#888; text-align:center; font-size:16px; color:#fff; line-height:36px; height:38px; font-weight:500px;  vertical-align:top; }

#contents .terms_box {position:relative; background:#fff; border:1px solid #ccc; padding:10px; line-height:25px; height:250px; font-size:14px; color:#666; font-family: 'Noto Sans KR'; color:#333; overflow-y:scroll; word-spacing:0em; letter-spacing:-0.05em; }
#contents .terms_list {position:relative;  }
#contents .terms_list ul{position:relative; overflow:auto; overflow-y:hidden; overflow-x:hidden;}
#contents .terms_list li{position:relative; box-sizing:border-box; float:left; text-align:left; padding:5px 0; line-height:22px; width:50%}
#contents .terms_list li:nth-child(even) {position:relative; margin-bottom:20px;}
#contents .terms_list .txt1 {position:relative; text-align:left; font-family: 'Noto Sans KR', sans-serif; font-size:16px; color:#222; font-weight:400; line-height:22px; word-spacing:0em; letter-spacing:-0.05em;}
#contents .terms_list .txt2 {position:relative; text-align:left; font-family: 'Noto Sans KR', sans-serif; font-size:16px; color:#666; font-weight:400; line-height:22px; word-spacing:0em; letter-spacing:-0.05em;}
#contents .terms_list .round{display:inline-block;}
#contents .terms_list li.l_li{text-align:left;}
#contents .terms_list li.r_li{text-align:right;}
#contents .terms_list li > p {margin-bottom:0;}
#contents .terms_list input[type="radio"] {
  display:none;
}

#contents .terms_list input[type="radio"] + label span.round{
  display:inline-block;
  width: 20px;height: 20px;
  margin: -2px 5px 0 4px;
  font-size: 0;
  vertical-align: middle;
  background: url('/assets/images/page/radio_brn.png') no-repeat; cursor:pointer;
  background-size:100%;

}

#contents .terms_list input[type="radio"]:checked + label span.round {
  background: url('/assets/images/page/radio_brn_slc.png') no-repeat; background-size:100%;
}


#contents .btn_area {position:relative; text-align:center; line-height:35px;  color:#666; }
#contents .btn_area a.btn_add, #contents .btn_area button.btn_add {display:inline-block; line-height:40px; height:40px; border-radius:5px; background:#ff363b; width:120px; margin-right:10px; text-align:center; font-family: 'Noto Sans KR', sans-serif;  font-size:18px; color:#fff; font-weight:500; word-spacing:0em; letter-spacing:-0.05em;}
#contents .btn_area a.btn_cancel, #contents .btn_area button.btn_cancel {display:inline-block;  line-height:40px; height:40px; border-radius:5px; background:#bbb; width:120px; text-align:center; font-family: 'Noto Sans KR', sans-serif;  font-size:18px; color:#222; font-weight:500; word-spacing:0em; letter-spacing:-0.05em;}


ol,ul,li {list-style:none;padding:0;margin:0;}





	/* 폰트 크기 */
	.ft_20 {font-size:20px;}
	.ft_19 {font-size:19px;}
	.ft_18 {font-size:18px;}
	.ft_17 {font-size:17px;}
	.ft_16 {font-size:16px;}
	.ft_15 {font-size:15px;}
	.ft_14 {font-size:14px;}


	/* 달력 주 첫날만 빨가색 처리 */
	.calendar_table tbody tr td:nth-child(1){color:red !important;}
	.calendar_table th, .calendar_table td { text-align:center; padding:5px; }
	.calendar_table td { }
	.calendar_list ul{ top:0;  vertical-align:top;}
	.calendar_list li {}
	.calendar_detail {width:100%; border-top: 2px solid #8cc8e8; border-bottom:2px solid #8cc8e8;}
	.calendar_detail th, .calendar_detail td{ padding:5px 10px; border-bottom:1px solid #aed8ee;}
	.calendar_detail th { width:100px; text-align:center; /*background-color:#CBE6F4;*/ line-height:170%;}
	.calendar_detail td { border:1px solid #e7e7e7;}
	.cal_font {}
	.cal_font_weight { font-weight:bolder; color:#393939; }

	.sb_calendar table{position:relative; border-top:2px solid #333;  box-sizing:border-box; overflow:hidden;}
	.sb_calendar th{position:relative; text-align:center; color:#333; background-clip: padding-box; background-color:#f9f9f9; border-bottom:1px solid #ddd; border-left:1px solid #ddd; font-size:16px; line-height:30px; font-family: 'Noto Sans KR'; font-weight:500; word-spacing:0em; letter-spacing:-0.05em; padding:10px; }
	.sb_calendar td{position:relative; text-align:left; color:#666; background-clip: padding-box; background-color:#ffffff; border-bottom:1px solid #ddd; border-left:1px solid #ddd; font-size:16px; /*line-height:30px; */ font-family: 'Noto Sans KR'; font-weight:400; word-spacing:0em; letter-spacing:-0.05em; padding:10px; height:60px;  vertical-align:top;}
	.sb_calendar td > div {/*padding-top:23px;*/ line-height:47px; text-align:center;}

	.sb_calendar th, .sb_calendar td{ min-width:79.14px; max-width:79.14px; }

	.sb_calendar th:first-child, .sb_calendar td:first-child {border-left:none;}
	.sb_calendar td .date_num{position:relative;  text-align:right; color:#333; font-size:16px; font-family: 'Noto Sans KR';  font-weight:700; line-height:22px;}
	.sb_calendar td a.schedule {margin:5px 0; background:url('/assets/images/page/schedule_icon.png')no-repeat left top 7px; padding-left:7px; font-size:13px; color:#888; line-height:16px; font-weight:400; font-family: 'Noto Sans KR'; text-align:left; overflow: hidden; text-overflow: ellipsis; display:-webkit-box; white-space: normal; -webkit-line-clamp:2; -webkit-box-orient: vertical; word-wrap:break-word;  word-spacing:0em; letter-spacing:-0.05em; vertical-align:top;}
	.sb_calendar td a:hover {color:#333; }



	.sb_reserve_time {position:relative; }
	.sb_reserve_time table {position:relative; border-top:1px solid #333;}
	.sb_reserve_time th {position:relative; padding:12px 10px; background:#f8f8f8; border-bottom:1px solid #ddd; background-clip: padding-box; line-height:35px; text-align:center; font-family: 'Noto Sans KR', sans-serif;  font-size:16px; color:#222; font-weight:500; word-spacing:0em; letter-spacing:-0.05em; }
	.sb_reserve_time td {position:relative; padding:12px 10px; background:#fff;  border-bottom:1px solid #ddd; background-clip: padding-box;  line-height:35px; text-align:left; font-family: 'Noto Sans KR', sans-serif;  font-size:16px; color:#666; font-weight:400; word-spacing:0em; letter-spacing:-0.05em; }
	.sb_reserve_time .input1 {border:1px solid #ddd; background:#fff; box-sizing:border-box; border-radius:5px; line-height:36px; height:38px; color:#333; font-size:15px; font-family: 'Noto Sans KR'; font-weight:400; word-spacing:0em; letter-spacing:-0.05em; text-indent:5px; vertical-align:top; }
	.sb_reserve_time input::-webkit-input-placeholder {color:#999;}
	.sb_reserve_time input::-moz-placeholder {color:#999;}



	#loading_rsv_time {display:none; position:absolute;z-index:10;}
	#loading_rsv_time img {width: 240px; top:50%; margin-top:80px;left:50%; margin-left:80px;}
</style>


<style type="text/css">
#contents .terms_list li:nth-child(even) { margin-bottom:0 !important; }
.numer-btn {

    border: 1px solid #dddddd;
    margin-left: 0px;
    padding: 8px;
    vertical-align: top;
	border-radius: 5px;

    width: 37px;
    height: 38px;
    border: 1px solid #dddddd;
    background: #fff;
    font-size: 20px;
    color: #999;
    cursor: pointer;
    line-height: 16px;
}
</style>

<style>
	.btn-check {
		position: absolute;
		clip: rect(0,0,0,0);
		pointer-events: none;
	}
	.btn-check:active+.btn-outline-secondary, .btn-check:checked+.btn-outline-secondary, .btn-outline-secondary.active, .btn-outline-secondary.dropdown-toggle.show, .btn-outline-secondary:active,.btn-outline-secondary:hover{
		color: #fff;
		background-color: #6c757d;
		border-color: #6c757d;
	}

	.btn-outline-secondary.disabled {
		background-color: #eeeeee;
	}

	.btn-outline-secondary {
		color: #6c757d;
		border-color: #6c757d;
	}
	.btn-outline-secondary {
		color: #6c757d;
		border-color: #6c757d;
	}
	.btn-reserve-close {
		color: #ffffff;
		background-color: #a3a9af;
		border-color: #a3a9af;
	}

	.rsv_find {
		display: inline-block;
		position: relative;
		border-radius: 5px;
		background: #aba000;
		text-align: center;
		line-height: 40px;
		height: 40px;
		margin:0 auto;
		padding: 0 30px 0 30px;
		box-sizing: border-box;
		color: #fff;
		font-family: 'Noto Sans KR', sans-serif;
		font-size: 18px;
		font-weight: 500;
		word-spacing: 0em;
		letter-spacing: -0.05em;
	}

	.rsv_cancel {
		display: inline-block;
		position: relative;
		border-radius: 5px;
		background: #e60000;
		text-align: center;
		line-height: 40px;
		height: 40px;
		margin:0 auto;
		padding: 0 30px 0 30px;
		box-sizing: border-box;
		color: #fff;
		font-family: 'Noto Sans KR', sans-serif;
		font-size: 18px;
		font-weight: 500;
		word-spacing: 0em;
		letter-spacing: -0.05em;

	}

</style>

<script type="text/javascript">
$(function(){

	// 동반인 숫자
	var pno = parseInt($('#writer_partner').val());
	$('#decreaseQty').on('click', function() {
		pno--;
		pno = (pno < 0) ? 0 : pno;
		$('#writer_partner').val(pno)
	});
	$('#increaseQty').on('click', function() {
		pno++;
		pno = (pno > 1) ? 1 : pno;
		$('#writer_partner').val(pno)
	});

});
</script>

		

<script type="text/javascript">
$(document).ready(function(){
	$(".sb_tab").click(function(){
		// 탭메뉴 컨트롤
		$('.sb_tab').removeClass('tab_on').removeClass('tab_off').addClass('tab_off');
		$(this).removeClass('tab_off').addClass('tab_on');
		// 내용 컨트롤
		var dsp_tp = $(this).attr('alt');
		$('.sb_tp').hide();
		$('.'+dsp_tp).fadeIn();
	});

	// 예약 정보 확인
	$('.rsv_find').on('click',function(){

			var rsv_name = $('#rsv_name').val();
			var rsv_phone = $('#rsv_phone').val();

			if('' == rsv_name) {
				alert('예약자명을 입력해 주세요.');
				$('#rsv_name').focus();
			}
			else if('' == rsv_phone) {
				alert('예약자 연락처를 입력해 주세요.');
				$('#rsv_phone').focus();
			}
			else {

				// 예약 시간 확인
				var request = $.ajax({
				  url: "/trans/find_rsv_info/",
				  method: "POST",
				  data: { 'rsv_name': rsv_name, 'rsv_phone':rsv_phone},
				  dataType: "html"
				});

				request.done(function( res ) {
				  //console.log(res);
				  $('#rsv_info').html(res);
				  $('#rsv_box').fadeIn();
				});

				request.fail(function( jqXHR, textStatus ) {
				  alert( "Request failed: " + textStatus );
				  return false;
				});

			}
	});

});


// 예약 취소
function rsv_cancel(rsv_name,rsv_phone) {

	if( confirm('예약을 취소하시겠습니까? \n취소하신 예약 시간은 예약 마감 전에 다시 신청하셔야 합니다.') ) {

		// 예약 시간 확인
		var request = $.ajax({
		  url: "/trans/cancel_rsv/",
		  method: "POST",
		  data: { 'rsv_name': rsv_name, 'rsv_phone':rsv_phone},
		  dataType: "html"
		});

		request.done(function( res ) {
		  //console.log(res);
		  var return_url = '<?php echo current_url() ?>';
		  
		  if('deleted' == res) {
			  //console.log(return_url);
			  alert('예약이 취소되었습니다.');
			  location.replace(return_url);
		  }
		  else {
			  //console.log(res);
			  alert('예약이 취소되지 않았습니다. \n계속해서 취소가 되지 않으면 관리자에 문의해주세요.');
		  }
		});

		request.fail(function( jqXHR, textStatus ) {
		  alert( "Request failed: " + textStatus );
		  return false;
		});

	}

}
</script>


	<div id="container">

		<p class="pdt40"></p>
		<div id="contents">

		  <div class="type_tab"><a href="#" class="tab_on sb_tab mgr20" alt="sb_tp1">방문예약하기</a><a href="#" class="tab_off sb_tab" alt="sb_tp2">방문예약 확인 및 취소</a></div>



		  <div class="sb_tp sb_tp2" style="display:none;">
				<div class="box1200">
					<p class="ttl1">방문예약자 정보 입력</p>
					<p class="pdt10"></p>

					<div class="add1">
						<table width="100%" border="0" cellpadding="0" cellspacing="0" >
							<colgroup>
								<col width="150px">
								<col width="*">
							</colgroup>
							<tr>
								<th>예약자명</th>
								<td><input class="input1" id="rsv_name" name="rsv_name" value="<?php echo set_value('name') ?>" style="width:200px;" placeholder=""></td>
							</tr>
							<tr>
								<th>예약자 연락처</th>
								<td><input type="text" class="input1" id="rsv_phone" name="rsv_phone" value="<?php echo set_value('phone') ?>" style="width:200px;" placeholder="" onkeypress="onlyNumber();" onkeyup="onlyNumber();" maxlength="11" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"></td>
							</tr>
						</table>

						<div style="padding:50px 0;text-align:center;"><button class="rsv_find">예약 확인하기</button></div>
					</div>

				</div>


				<div id="rsv_box" class="box1200" style="display: none;">
					<p class="ttl1">예약 정보 확인</p>
					<p class="pdt10"></p>
					<div class="add1">
						<div style="border-top: 2px solid #333;"></div>
						<div id="rsv_info"></div>
					</div>
				</div>


		  </div>


		  <div class="sb_tp sb_tp1">
			<?php echo form_open(base_url().'landing_rsv/rsv_write', array('id'=>'landing_form','name'=>'landing_form', 'onsubmit'=>'return form_check();')); ?>

				<input type="hidden" name="return_url" value="<?php echo base_url()?>page/rsv" />
				<input type="hidden" name="type" value="rsv_1" />
				<div class="box1200">
					<!-- <img src="<?php echo IMG_DIR ?>/2020/sb0_img1.jpg" width="100%">
					<p class="pdt40"></p> -->



					<p class="ttl1">개인정보수집동의</p>
					<p class="pdt10"></p>
					<div style="border-top: 2px solid #333;"></div>
					<p class="pdt10"></p>
					<div class="terms_box" style="height:150px;"><?php echo isset($row->agree_content) ? $row->agree_content : ''; ?></div>
					<p class="pdt20"></p>
					<div class="terms_list">
						<ul>
							<li class="l_li"><p class="txt1">1. 개인정보 수집 및 이용목적에 동의하십니까? <strong>(필수)</strong></p></li>
							<li class="r_li"><div class="round mgr25"><input type="radio" id="agreed_1" name="agreed_1" value="agree" ><label for="agreed_1"><span class="round"></span><span class="txt2">동의합니다.</span></div><div class="round"><input type="radio" id="non-agreed_1" name="agreed_1" value="notagree" ><label for="non-agreed_1"><span class="round"></span><span class="txt2">동의하지않음</span></div></li>
						</ul>
						<ul>
							<li class="l_li"><p class="txt1">2. 제공해 주신 개인정보는 분양마케팅에 활용됩니다. <strong>(필수)</strong></p></li>
							<li class="r_li"><div class="round mgr25"><input type="radio" id="agreed_2" name="agreed_2" value="agree" ><label for="agreed_2"><span class="round"></span><span class="txt2">동의합니다.</span></div><div class="round"><input type="radio" id="non-agreed_2" name="agreed_2" value="notagree" ><label for="non-agreed_2"><span class="round"></span><span class="txt2">동의하지않음</span></div></li>
						</ul>
						<ul>
							<li class="l_li"><p class="txt1">3. 개인정보의 취급위탁에 동의하십니까? <strong>(필수)</strong></p></li>
							<li class="r_li"><div class="round mgr25"><input type="radio" id="agreed_3" name="agreed_3" value="agree" ><label for="agreed_3"><span class="round"></span><span class="txt2">동의합니다.</span></div><div class="round"><input type="radio" id="non-agreed_3" name="agreed_3" value="notagree" ><label for="non-agreed_3"><span class="round"></span><span class="txt2">동의하지않음</span></div></li>
						</ul>
					</div>
					<p class="pdt40"></p>

					<div id="reservation_area" class="ttl1" style="position:relative;">
						방문예약하기
						<div style="position:absolute; bottom:-10px; right:0;">
							<small style="font-size:15px;">※ 예약자명, 예약자 연락처, 인증번호, 백신접종 여부는 필수입력사항 입니다.</small>
						</div>
					</div>
					<p class="pdt10"></p>
					<div class="add1">
						<table width="100%" border="0" cellpadding="0" cellspacing="0" >
							<colgroup>
								<col width="150px">
								<col width="*">
							</colgroup>
							<tr>
								<th>이름</th>
								<td><input class="input1" id="writer_name" name="name" value="<?php echo set_value('name') ?>" style="width:200px;" placeholder=""><span style="font-size:14px;"> ※ 다른 고객의 예약을 위해 중복 예약은 불가능합니다.</span></td>
							</tr>
							<tr>
								<th>휴대전화</th>
								<td><input type="text" class="input1" id="writer_phone" name="phone" value="<?php echo set_value('phone') ?>" style="width:200px;" placeholder="" onkeypress="onlyNumber();" onkeyup="onlyNumber();" maxlength="11" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"></td>
							</tr>
							<tr>
								<th>동반인</th>
								<td>
									<input type="button" id="decreaseQty" value="-" class="textbox numer-btn">
									<input class="input1" id="writer_partner" name="partner" value="<?php echo set_value('partner',0) ?>" style="width:80px; padding:0; text-align:center; text-indent:0;" placeholder="" onkeypress="onlyNumber();" maxlength="2" readonly>
									<input type="button" id="increaseQty" value="+" class="textbox numer-btn">
								</td>
							</tr>
							<tr>
								<th>백신접종 여부</th>
								<td>
									<label style="line-height:20px; display:inline-block; font-size:14px; ">
									  <input type="checkbox" id="vacc_chk" name="vacc_chk" value="Y" style=" vertical-align:-1px;"> 2차 백신 접종 후 14일 경과 6개월(180일) 이내 <br />
									  ※ 미접종자의 경우 48시간 이내 PCR 검사 음성 확인서 또는 확인 문자 제시 필수
									</label>
								</td>
							</tr>
							<!-- <tr>
								<th>날짜선택</th>
								<td>
									<input type="text" id="rdate" name="rdate" class="date_picker" value="<?php echo set_value('rdate') ?>" style="width:120px;" placeholder="날짜" />
									<input type="text" id="rtime" name="rtime" class="time_picker" value="<?php echo set_value('rtime') ?>" style="width:80px;" placeholder="시간" />
							</tr> -->
						</table>
					</div>
					<p class="pdt20"></p>


					<script type="text/javascript">
					$(document).ready(function(){
						move_month('<?php echo $selected_year ?>','<?php echo $selected_month ?>');
					});
					</script>

					<script type="text/javascript">
					// 달력 이동
					function move_month(year,month) {
						console.log(year+'/'+month);
						var request = $.ajax({
						  url: "/trans/dsp_calendar_prevnext/",
						  method: "POST",
						  data: { 'year': year, 'month': month},
						  dataType: "html"
						});

						request.done(function( res ) {
						  //console.log(res);
						  $('#box_calendar').html(res);
						  $('#box_rsv_time').html('<span class="ft_15">예약 날짜를 선택해주세요.</span>');
						  $('#box_rsv_part').html('<span class="ft_15">예약 시간을 선택해주세요.</span>');
						});

						request.fail(function( jqXHR, textStatus ) {
						  alert( "Request failed: " + textStatus );
						  return false;
						});
					}

					// 캘린더에서 날짜 선택
					function select_date_to_time(obj,d) {
						//console.log(obj.id);
						//console.log(d);

						var cal_date_id = obj.id;
						$('.cal_date').css('background-color','#ffffff');
						$('#'+cal_date_id).css('background-color','#ead900');

						$('#rsv_date').val(d);
						$('#text_selected_date').html(d);

						// 예약 시간 출력
						var request = $.ajax({
						  url: "/trans/dsp_calendar_rsv_time/",
						  method: "POST",
						  data: { 'date': d},
						  dataType: "html"
						});

						request.done(function( res ) {
						  //console.log(res);
						  $('#box_rsv_time').html(res).hide().fadeIn('fast');
						  $('#box_rsv_part').html('<span class="ft_15">예약 시간을 선택해주세요.</span>');

						  //$('#loading_rsv_time').html('<img src="<?php echo IMG_DIR ?>/common/loading2.gif" style=" "/>');
						  //$('#loading_rsv_time').show().fadeOut('slow');
						});

						request.fail(function( jqXHR, textStatus ) {
						  alert( "Request failed: " + textStatus );
						  return false;
						});

					}

					// 예약 시간 radio 리스트에서 시간 선택
					function select_time_to_part(d,t) {

						// 예약 시간 출력
						var request = $.ajax({
						  url: "/trans/dsp_calendar_rsv_part/",
						  method: "POST",
						  data: { 'date': d, 'time':t},
						  dataType: "html"
						});

						request.done(function( res ) {
						  //console.log(res);
						  $('#rsv_time').val(t);
						  $('#box_rsv_part').html(res).hide().fadeIn('fast');

						  //$('#loading_rsv_time').html('<img src="<?php echo IMG_DIR ?>/common/loading2.gif" style=" "/>');
						  //$('#loading_rsv_time').show().fadeOut('slow');

						});

						request.fail(function( jqXHR, textStatus ) {
						  alert( "Request failed: " + textStatus );
						  return false;
						});



						//box_rsv_part

					}

					// 파트 선택
					function select_part(t) {
						$('#rsv_part').val(t);
					}


					</script>


					<div id="sb0_1" style="border:0px solid red;">
						<table cellpadding="0" cellspacing="0" class="" style="width:100%; border:none;">
						<tr>
						  <td style="width:48.5%; border:1px solid #ddd; padding:0;">
							<div id="box_calendar" class="sb_calendar" style="padding:10px;">
								<?php
								/*
								if($selected_year == '2022' && $selected_month == '02') {
								  $data = array(
										25  => 'onclick="alert(25);"',
										26  => 'http://example.com/news/article/2022/02/20/',
										27 => 'http://example.com/news/article/2022/02/21/',
										28 => 'http://example.com/news/article/2022/02/22/'
								  );
								}
								elseif($selected_year == '2022' && $selected_month == '03') {
								  $data = array(
										1  => 'onclick="alert(25);"',
										2  => 'http://example.com/news/article/2022/02/20/',
										3 => 'http://example.com/news/article/2022/02/21/',
										4 => 'http://example.com/news/article/2022/02/22/',
										5 => 'http://example.com/news/article/2022/02/22/',
										6 => 'http://example.com/news/article/2022/02/22/',
								  );
								}
								else {
									$data = array();
								}

								echo $this->calendar->generate($selected_year, $selected_month, $data);
								*/
								?>
							</div>
						  </td>
						  <td style="width:1.5% !important; max-width:1.5% !important; padding:0;"></td>
						  <td style="width:50%; border:0px solid #ddd; padding:0;vertical-align:top;">
							<div style="padding:0px; vertical-align:top;">

								<div class="sb_reserve_time">
									<table width="100%" border="0" cellpadding="0" cellspacing="0" style="width:100%; height:100%;">
										<colgroup>
											<col width="15%">
											<col width="33%">
											<col width="15%">
											<col width="37%">
										</colgroup>
										<tr>
											<th>예약 날짜</th>
											<td colspan="3">
												<span id="text_selected_date" class="ft_15" style="font-weight:bold;">예약 날짜를 선택해주세요.</span>
												<input type="hidden" class="input1" id="rsv_date" name="rsv_date" value="<?php echo set_value('rsv_date') ?>" style="width:150px;" placeholder="">
											</td>
										</tr>
										<tr>
											<th style="height:477px; vertical-align:top;">예약 시간</th>
											<td style="vertical-align:top;">
												<!-- <span id="loading_rsv_time"></span> -->
												<div id="box_rsv_time">
													<span class="ft_15">예약 날짜를 선택해주세요.</span>

													<!-- <?php for($t=10;$t<=17;$t++) { 
														if($t == 12) continue;

														$close_diabled = 'disabled';
														$close_msg = '(예약 마감)';

													?>
													<div style="padding-bottom:5px;" >
														<input type="radio" class="btn-check" name="options-outlined" id="secondary-outlined-<?php echo $t ?>" autocomplete="off">
														<label class="btn btn-outline-secondary" for="secondary-outlined-<?php echo $t ?>" style="width:95%; text-align:left;"><?php echo $t ?>:00 <?php //echo $close_msg ?></label>
													</div>
													<?php } ?> -->
												</div>
												<input type="hidden" class="input1" id="rsv_time" name="rsv_time" value="<?php echo set_value('rsv_time') ?>" style="width:150px;" placeholder="">
											</td>

											<th style="vertical-align:top;">예약 파트</th>
											<td style="vertical-align:top;">
												<div id="box_rsv_part">

													<!-- <span class="ft_15">예약 시간을 선택해주세요.</span>
												
													<?php for($t=0;$t<=2;$t++) 
													{ 
														$min = ($t == 0) ? '00' : $t * 20;

														$close_diabled = 'disabled';
														$close_msg = '(예약 마감)';

														$time_start = '10:'.$min;
														$tstamp = strtotime($time_start) + 20*60;
														$time_end = date('H:i',$tstamp);
														//echo $time_end;

														if($t < 1) {
													?>
													<div style="padding-bottom:5px;" >
														<input type="radio" class="btn-check" name="options-outlined" id="secondary-outlined-<?php echo $t ?>" autocomplete="off">
														<label class="btn btn-outline-secondary" for="secondary-outlined-<?php echo $t ?>" style="width:95%; text-align:left;">
															<?php echo $time_start ?> ~ <?php echo $time_end ?> &nbsp; (1/4)
														</label>
													</div>

													<?php
														}
														else {
													?>
													<div style="padding-bottom:5px;" >
														<input type="radio" class="btn-check" name="options-outlined" id="secondary-outlined-<?php echo $t ?>" autocomplete="off">
														<label class="btn btn-outline-secondary" for="secondary-outlined-<?php echo $t ?>" style="width:95%; text-align:left;" disabled>
															<?php echo $time_start ?> ~ <?php echo $time_end ?> (예약 마감)
														</label>
													</div>
													<?php 
														}
													} ?> -->

													

												</div>
												<input type="hidden" class="input1" id="rsv_part" name="rsv_part" value="<?php echo set_value('rsv_part') ?>" style="width:150px;" placeholder="">

											</td>
										</tr>
										<!-- <tr>
											<th style="height:380px; vertical-align:top;">예약 타임</th>
											<td>
												
											</td>
										</tr> -->
									</table>
								</div>




							</div>
						  </td>
						</table>
					</div>
					<p class="pdt40"></p>

					<div class="btn_area"><button type="submit" class="btn_add">예약신청</button><button type="reset" class="btn_cancel">취소</button></div>
				
				</div>

			<?php echo form_close(); ?>
		  </div>


		</div>
		<p class="pdt100"></p>
	</div>


<script type="text/javascript">
function form_check() {
	if('agree' != $("input:radio[name='agreed_1']:checked").val()) { alert('개인정보 수집 및 이용목적에 동의해주세요.'); }
	else if('agree' != $("input:radio[name='agreed_2']:checked").val()) { alert('개인정보의 분양마케팅 활용에 동의해주세요.'); }
	else if('agree' != $("input:radio[name='agreed_3']:checked").val()) { alert('개인정보의 취급위탁에 동의해주세요.'); }
	else if('' == $('#writer_name').val()) { alert('이름을 입력해주세요.'); }
	else if('' == $('#writer_phone').val()) { alert('휴대전화 번호를 입력해주세요.'); }
	else if('Y' != $("input:checkbox[name='vacc_chk']:checked").val()) { alert('백신접종 여부 내용을 확인하시고 체크해주세요.'); }
	else if('' == $('#rsv_date').val()) { alert('방문예약 날짜를 선택해주세요.'); }
	else if('' == $('#rsv_time').val()) { alert('방문예약 시간을 선택해주세요.'); }
	else if('' == $('#rsv_part').val()) { alert('방문예약 파트를 선택해주세요.'); }

	else if( confirm('등록하시겠습니까?') ) {
		return true;
	}
	else {
		return false;
	}
	return false;
}
</script>

<!-- iOS에서는 position:fixed 버그가 있음, 적용하는 사이트에 맞게 position:absolute 등을 이용하여 top,left값 조정 필요 -->
<div id="layer_execDaumPostcode" style="display:none;position:fixed;overflow:hidden;z-index:1;-webkit-overflow-scrolling:touch;">
<img src="//t1.daumcdn.net/localimg/localimages/07/postcode/320/close.png" id="btnCloseLayer" style="cursor:pointer;position:absolute;right:-3px;top:-3px;z-index:1" onclick="closeDaumPostcode()" alt="닫기 버튼">
</div>

<!-- <script src="http://dmaps.daum.net/map_js_init/postcode.v2.js"></script> -->
<script src="//t1.daumcdn.net/mapjsapi/bundle/postcode/prod/postcode.v2.js"></script>
<script>
    // 우편번호 찾기 화면을 넣을 element
    var element_layer = document.getElementById('layer_execDaumPostcode');

    function closeDaumPostcode() {
        // iframe을 넣은 element를 안보이게 한다.
        element_layer.style.display = 'none';
    }

    function srh_execDaumPostcode() {
        new daum.Postcode({
            oncomplete: function(data) {
                // 검색결과 항목을 클릭했을때 실행할 코드를 작성하는 부분.

                // 각 주소의 노출 규칙에 따라 주소를 조합한다.
                // 내려오는 변수가 값이 없는 경우엔 공백('')값을 가지므로, 이를 참고하여 분기 한다.
                var fullAddr = data.address; // 최종 주소 변수
                var extraAddr = ''; // 조합형 주소 변수

                // 기본 주소가 도로명 타입일때 조합한다.
                if(data.addressType === 'R'){
                    //법정동명이 있을 경우 추가한다.
                    if(data.bname !== ''){
                        extraAddr += data.bname;
                    }
                    // 건물명이 있을 경우 추가한다.
                    if(data.buildingName !== ''){
                        extraAddr += (extraAddr !== '' ? ', ' + data.buildingName : data.buildingName);
                    }
                    // 조합형주소의 유무에 따라 양쪽에 괄호를 추가하여 최종 주소를 만든다.
                    fullAddr += (extraAddr !== '' ? ' ('+ extraAddr +')' : '');
                }

                // 우편번호와 주소 정보를 해당 필드에 넣는다.
                document.getElementById('postcode').value = data.zonecode; //5자리 새우편번호 사용
                document.getElementById('addr').value = fullAddr;
                //document.getElementById('sample2_addressEnglish').value = data.addressEnglish;

                // iframe을 넣은 element를 안보이게 한다.
                // (autoClose:false 기능을 이용한다면, 아래 코드를 제거해야 화면에서 사라지지 않는다.)
                element_layer.style.display = 'none';
            },
            width : '100%',
            height : '100%'
        }).embed(element_layer);

        // iframe을 넣은 element를 보이게 한다.
        element_layer.style.display = 'block';

        // iframe을 넣은 element의 위치를 화면의 가운데로 이동시킨다.
        initLayerPosition();
    }

    // 브라우저의 크기 변경에 따라 레이어를 가운데로 이동시키고자 하실때에는
    // resize이벤트나, orientationchange이벤트를 이용하여 값이 변경될때마다 아래 함수를 실행 시켜 주시거나,
    // 직접 element_layer의 top,left값을 수정해 주시면 됩니다.
    function initLayerPosition(){
        var width = 450; //우편번호서비스가 들어갈 element의 width
        var height = 550; //우편번호서비스가 들어갈 element의 height
        var borderWidth = 5; //샘플에서 사용하는 border의 두께

        // 위에서 선언한 값들을 실제 element에 넣는다.
        element_layer.style.width = width + 'px';
        element_layer.style.height = height + 'px';
        element_layer.style.border = borderWidth + 'px solid';
        // 실행되는 순간의 화면 너비와 높이 값을 가져와서 중앙에 뜰 수 있도록 위치를 계산한다.
        element_layer.style.left = (((window.innerWidth || document.documentElement.clientWidth) - width)/2 - borderWidth) + 'px';
        element_layer.style.top = (((window.innerHeight || document.documentElement.clientHeight) - height)/2 - borderWidth) + 'px';
    }
</script>




<link rel="stylesheet" type="text/css" href="/assets/lib/datetimepicker-master/jquery.datetimepicker.min.css" media="screen"/>
<script src="/assets/lib/datetimepicker-master/jquery.datetimepicker.full.js"></script>
<script type="text/javascript">
// datetimepicker
$.datetimepicker.setLocale('kr');
/*
$('.datetimepicker').datetimepicker({
	lang:'kr',
	timepicker:false,
	format:'Y-m-d',
	formatDate:'Y/m/d',
	yearStart:'2020',
	yearEnd:'2027'
});
$('.datetime_picker').datetimepicker({
	lang:'kr',
	timepicker:true,
	format:'Y-m-d H:i',
	formatDate:'Y/m/d',
	yearStart:'<?php echo date("Y") ?>',
	yearEnd:'<?php echo date("Y") +1 ?>'
});
*/

// 25일부터 3월 6일
$('.date_picker').datetimepicker({
	lang:'kr',
	timepicker:false,
	format:'Y-m-d',
	formatDate:'Y-m-d',
	//yearStart:'<?php echo date("Y") ?>',
	//yearEnd:'<?php echo date("Y") +1 ?>',
	//allowDates: ['2022-02-25','2022-02-26','2022-02-27','2022-02-28','2022-03-01','2022-03-02','2022-03-03','2022-03-04','2022-03-05']
});

$('.time_picker').datetimepicker({
	lang:'kr',
	datepicker:false,
	timepicker:true,
	format:'H:i',
	allowTimes:[
	  '10:00', '11:00', '12:00', '13:00', '14:00', '15:00', '16:00', '17:00'
	]
});
</script>