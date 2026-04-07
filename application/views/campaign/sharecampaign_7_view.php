<?php
/*
# 참고 사이트
# https://news.seoul.go.kr/gov/lovepc-request-info/lovepc-request
*/

// 제목 설정
$req_reason = array(
	'name'	=> 'req_reason',
	'id'	=> 'req_reason',
	'value' => set_value('req_reason'),
	'maxlength'	=> 255,
	'class' => 'o_input',
	'placeholder' => '신청사유를 입력하세요.',
	'style'	=> 'width:100%; vertical-align:middle;'
);

$captcha = array(
	'name'	=> 'captcha',
	'id'	=> 'captcha',
	'maxlength'	=> 8,
	'class' => 'form-control bo_input',
	'style' => 'display:inline-block; width: 120px;',
	'autocomplete' => 'no'
);
?>


<style type="text/css">
	.bbs_basic_list {border-top:2px solid #333333; position:relative; display:block; }
	.bbs_basic_list table {width: 100%;}
	.bbs_basic_list table thead th { font-size:15px; padding:15px 12px !important; border-bottom:1px solid #bfbfbf;}
	.bbs_basic_list table tbody td { padding:11px !important; border-bottom:1px solid #dddddd;}
	.bbs_basic_list table td, .bbs_basic_list table td a { font-size:14px; color:#333333; text-decoration:none;}

	h3.o_content_ttl {position:relative; font-size:45px; font-weight:bold; text-align:center;}
	h4.o_content_ttl {position:relative; font-size:34px; font-weight:bold; }
	.o_content_ttl_redbar {position:absolute; top:0; left:15px; width:27px; height:5px; background-color:red; }

	.o_agree_ctnt {margin-top:40px; border-top:2px solid#333333; border-bottom:1px solid#333333; background-color:#fafafa; padding:30px; font-size:15px;}
	.o_agree_ctnt dl {margin-bottom:3px;}
	.o_agree_ctnt dl dt, .o_agree_ctnt dl dd { display:inline-block;}


	

	.tbl_share_sky {}
	.tbl_share_sky table {}
	.tbl_share_sky table th { background-color:#f8fdff; font-size: 18px; font-weight: bold; padding: 15px;}
	.tbl_share_sky table td {}
	.tbl_share_sky table td .ttl_mobile {display:none;}


	@media screen and (max-width: 768px) {
		.tbl_share_sky {}
		.tbl_share_sky table { }
		.tbl_share_sky table th { display: none; }
		.tbl_share_sky table td { width:100%; }
		.tbl_share_sky table td .ttl_mobile {display:block;}
		.tbl_share_sky table td .ttl_mobile h5 {display:inline-block; font-weight:bold; font-size: 17px; padding: 3px 5px; background-color:#f8fdff; border-bottom:1px solid silver;}

	}
</style>


<div class="pc_wrap">
	<!-- 캠페인 탑 비주얼 배너 영역 -->
	<div class="wrap_cmplist_top_bnr">
	  <?php foreach($top_bnr_pc as $i => $bnr) { ?>
		<div class="cmplist_top_bnr" style="background-image:url('<?php echo $bnr->banner_src ?>'); ">
			<div class="txt" style="color:#3d3c43;" ><?php echo nl2br($bnr->bn_memo) ?></div>
		</div>
	  <?php } ?>
	</div>
</div>

<script type="text/javascript">
$(document).ready(function(){
  $('.wrap_cmplist_top_bnr').not('.slick-initialized').slick({
	  slidesToShow: 1,
	  slidesToScroll: 1,
	  arrows: false,
	  dots: false
  });
});
</script>


<!-- 진행중인 나눔 캠페인 -->
<div class="ctnt_wrap">
  <div class="ctnt_inside">
	<div class="subpage_wrap">

		<div class="subpage_ttl">
		  <h3 class="subpage_ttl_text">나눔 신청하기 <!-- <small class="subpage_desc" style="font-size:23px;">(신청자 정보)</small> --></h3>
		  <div class="subpage_ttl_line"></div>
		</div>
	</div>
  </div>
</div>


<div class="pc_wrap">
  <div class="ctnt_wrap py_35">
	<div class="ctnt_inside">

					<h3 class="pb-3">나눔 캠페인 정보</h3>
					<div class="tbl_purple tbl_share_sky">
						<table style="max-width:100%; border-top:1px solid #000000;">
							<colgroup>
								<col style="width:<?php echo (IS_MOBILE) ? '35%' : '200px'?>;">
								<col style="width:<?php echo (IS_MOBILE) ? '65%' : ''?>;">
							</colgroup>
							<tr class="gubun">
								<th>캠페인명</th>
								<td><div class="ttl_mobile"><h5>캠페인명</h5></div><?php echo $cmp_row->wr_subject ?></td>
							</tr>
							<tr class="gubun">
								<th>기간</th>
								<td><div class="ttl_mobile"><h5>기간</h5></div><?php echo $cmp_row->addfld_1 ?> ~ <?php echo $cmp_row->addfld_2 ?></td>
							</tr>

						</table>

					</div>


					<?php echo validation_errors(); ?>

					<?php echo form_open_multipart($this->uri->uri_string(), array('id'=>'board_form','name'=>'board_form','onsubmit'=>'frm_submit();')); ?>

						<input type="hidden" id="scmp_idx" name="scmp_idx" value="<?php echo $wr_idx ?>" />

						<?php //echo validation_errors('<div class="error">', '</div>'); ?>


						<h3 class="mt-5 pt-5 pb-3">신청자 정보</h3>
						<div class="tbl_purple tbl_share_sky">
							<table style="max-width:100%; border-top:1px solid #000000;">
								<colgroup>
									<col style="width:<?php echo (IS_MOBILE) ? '35%' : '200px'?>;">
									<col style="width:<?php echo (IS_MOBILE) ? '65%' : ''?>;">
								</colgroup>

								<tr>
									<th>신청제목 <span class="color_red">*</span></th>
									<td><div class="ttl_mobile"><h5>신청자명 <span class="color_red">*</span></h5></div>
										<input type="text" id="req_subject" class="o_input" style="width:80%;" name="req_subject" value="<?php echo set_value('req_subject'); ?>" >
										<?php echo form_error('req_subject', '<div class="error" style="color:red;">','</div>'); ?>
									</td>
								</tr>

								<tr class="gubun">
									<th>구분 <span class="color_red">*</span></th>
									<td><div class="ttl_mobile"><h5>구분 <span class="color_red">*</span></h5></div>
										<div class="o_radio_container">
											<label for="gubun_per"><input type="radio" id="gubun_per" class="gubun_radio" name="gubun" value="개인" <?php echo  set_radio('gubun', '개인', (isset($row->gubun) && $row->gubun == '개인') ? TRUE : ''); ?> /> 개인</label>
											<label for="gubun_org"><input type="radio" id="gubun_org" class="gubun_radio" name="gubun" value="단체" <?php echo  set_radio('gubun', '단체', ! isset($row->gubun) || (isset($row->gubun) && $row->gubun == '단체') ? TRUE : ''); ?> /> 단체</label>
										</div>
										<?php echo form_error('gubun', '<div class="error" style="color:red;">','</div>'); ?>
									</td>
								</tr>
								<tr class="type_A">
									<th class="manager_name">신청자명 <span class="color_red">*</span></th>
									<td><div class="ttl_mobile"><h5>신청자명 <span class="color_red">*</span></h5></div>
										<input type="text" id="req_name" class="o_input" style="max-width:80%;" name="req_name" value="<?php echo isset($user->nickname) ? $user->nickname : set_value('req_name'); ?>" >
										<?php echo form_error('req_name', '<div class="error" style="color:red;">','</div>'); ?>
									</td>
								</tr>
								<tr class="type_B">
									<th>상호/<br class="d-block d-sm-none" />법인명 <span class="color_red">*</span></th>
									<td><div class="ttl_mobile"><h5>법인명</h5></div>
										<input type="text" id="req_name_org" class="o_input" style="max-width:80%;" name="req_name_org" value="<?php echo isset($user->comp_name) ? $user->comp_name : set_value('req_name_org'); ?>" > <br /><small>대표자 명이 아닌 사업자 등록증 상에 등록된 상호/법인명을 입력해주세요.</small>
										<?php echo form_error('req_name_org', '<div class="error" style="color:red;">','</div>'); ?>
									</td>
								</tr>
								<tr>
									<th>방문주소 <span class="color_red">*</span></th>
									<td><div class="ttl_mobile"><h5>방문주소 <span class="color_red">*</span></h5></div>
										<input type="text" id="req_postcode" name="req_postcode" value="<?php echo isset($user->postcode) ? $user->postcode : set_value('req_postcode'); ?>" readonly class="o_input bg_readonly"  style="width:120px;" /> <button type="button" onclick="srh_execDaumPostcode('req_'); return false;" class="o_btn btn btn-dark-flat btn-sm">검색</button>
										<div class="pt_5">
											<input type="text" id="req_addr" class="o_input bg_readonly" style="width:80%;" name="req_addr" value="<?php echo isset($user->addr) ? $user->addr : set_value('req_addr'); ?>" readonly >
										</div>
										<div class="pt_5">
											<input type="text" id="req_addr_detail" class="o_input" style="width:80%;" name="req_addr_detail" value="<?php echo isset($user->addr_detail) ? $user->addr_detail : set_value('req_addr_detail'); ?>" placeholder="추가주소를 입력해주세요.">
										</div>

										<?php echo form_error('req_addr', '<div class="error" style="color:red;">','</div>'); ?>
										<?php echo form_error('req_addr_detail', '<div class="error" style="color:red;">','</div>'); ?>
									</td>
								</tr>
								<tr class=" d-none">
									<th>생년월일 <span class="color_red">*</span></th>
									<td><div class="ttl_mobile"><h5>생년월일 <span class="color_red">*</span></h5></div>
										<input type="text" id="req_birthday" class="o_input" style="max-width:80%;" name="req_birthday" value="<?php echo isset($user->birthday) ? $user->birthday : set_value('req_birthday'); ?>" >
										<div><small style="color:#7a7a7a;">예) 770717 (1977년 7월 17일)</small></div>
										<?php echo form_error('req_birthday', '<div class="error" style="color:red;">','</div>'); ?>
									</td>
								</tr>

								<tr>
									<th>휴대전화 <span class="color_red">*</span></th>
									<td><div class="ttl_mobile"><h5>휴대전화 <span class="color_red">*</span></h5></div>
									<?php 
										//print_r($user)
										$arr_phone = array('010','','');

										if( isset($row->req_phone) && '' != $row->req_phone ) {
											$arr_phone[0] = substr($row->req_phone, 0, 3);
											$arr_phone[1] = substr($row->req_phone, 4, 4);
											$arr_phone[2] = substr($row->req_phone, 9, 4);
										}
										elseif( isset($user->phone) ) {
											$arr_phone[0] = substr($user->phone, 0, 3);
											$arr_phone[1] = substr($user->phone, 3, 4);
											$arr_phone[2] = substr($user->phone, 7, 4);
										}
									?>
										<!-- <select id="req_phone_1" name="req_phone_1" class="o_selectbox" style="width: 70px;">
											<option value="010" <?php echo ('010' == $arr_phone[0]) ? 'selected': ''; ?>>010</option>
											<option value="011" <?php echo ('011' == $arr_phone[0]) ? 'selected': ''; ?>>011</option>
											<option value="016" <?php echo ('016' == $arr_phone[0]) ? 'selected': ''; ?>>016</option>
											<option value="017" <?php echo ('017' == $arr_phone[0]) ? 'selected': ''; ?>>017</option>
											<option value="018" <?php echo ('018' == $arr_phone[0]) ? 'selected': ''; ?>>018</option>
											<option value="019" <?php echo ('019' == $arr_phone[0]) ? 'selected': ''; ?>>019</option>
										</select> -->
										<input type="text" id="req_phone_1" class="o_input " name="req_phone_1" value="<?php echo set_value('req_phone_1', isset($arr_phone[0]) ? $arr_phone[0] : '010'); ?>"  pattern="[0-9]+" maxlength="3"  style="width: 60px;" onKeyup="this.value=this.value.replace(/[^0-9]/g,'');" />
										<input type="text" id="req_phone_2" class="o_input " name="req_phone_2" value="<?php echo set_value('req_phone_2', isset($arr_phone[1]) ? $arr_phone[1] : ''); ?>"  pattern="[0-9]+" maxlength="4"  style="width: 70px;" onKeyup="this.value=this.value.replace(/[^0-9]/g,'');" />
										<input type="text" id="req_phone_3" class="o_input " name="req_phone_3" value="<?php echo isset($arr_phone[2]) ? $arr_phone[2] : set_value('req_phone_3'); ?>"  pattern="[0-9]+" maxlength="4"  style="width: 70px;" onKeyup="this.value=this.value.replace(/[^0-9]/g,'');" onkeyup="return onlyNumber();" />

										<input type="hidden" id="req_phone" class="o_input " name="req_phone" value="<?php echo set_value('req_phone',isset($row->req_phone) ? $row->req_phone : '') ?>" readonly style="background-color:#cccccc; width: 120px; text-align:center;" />
										<?php echo form_error('req_phone', '<div class="error" style="color:red;">','</div>'); ?>
									</td>
								</tr>
								<tr>
									<th>신청사유 <span class="color_red">*</span></th>
									<td><div class="ttl_mobile"><h5>신청사유 <span class="color_red">*</span></h5></div>
										<?php //echo form_input($req_reason); ?>
										<?php //echo form_error('req_reason','<div class="error">','</div>'); ?>
										<textarea id="req_reason" class="o_input" name="req_reason" style="width:100%; height: 150px;" placeholder="신청사유를 입력하세요."><?php echo set_value('req_reason') ?></textarea>
										<?php echo form_error('req_reason', '<div class="error" style="color:red;">','</div>'); ?>
									</td>
								</tr>

								<tr class="gubun_bnf d-none">
									<th>수혜자구분 <span class="color_red">*</span></th>
									<td><div class="ttl_mobile"><h5>수혜자구분 <span class="color_red">*</span></h5></div>
										<div class="o_radio_container">
											<label for="gubun_bnf_per"><input type="radio" id="gubun_bnf_per" class="gubun_bnf_radio" name="gubun_bnf" value="개인" <?php echo  set_radio('gubun_bnf', '개인', ! isset($row->gubun_bnf) || (isset($row->gubun_bnf) && $row->gubun_bnf == '개인') ? TRUE : ''); ?> /> 개인</label>
											<label for="gubun_bnf_org"><input type="radio" id="gubun_bnf_org" class="gubun_bnf_radio" name="gubun_bnf" value="단체" <?php echo  set_radio('gubun_bnf', '단체', (isset($row->gubun_bnf) && $row->gubun_bnf == '단체') ? TRUE : ''); ?> /> 단체</label>
										</div>
										<?php echo form_error('gubun_bnf', '<div class="error" style="color:red;">','</div>'); ?>
									</td>
								</tr>


								<tr class=" d-none">
									<th>수혜자(단체)명 <span class="color_red">*</span></th>
									<td><div class="ttl_mobile"><h5>수혜자(단체)명  <span class="color_red">*</span></h5></div>
										<input type="text" id="bnf_name" class="o_input" name="bnf_name" value="<?php echo set_value('bnf_name'); ?>" >
										<?php echo form_error('bnf_name', '<div class="error" style="color:red;">','</div>'); ?>
									</td>
								</tr>
								<tr class=" d-none">
									<th>수혜대상 수 <span class="color_red">*</span></th>
									<td><div class="ttl_mobile"><h5>수혜대상 수 <span class="color_red">*</span></h5></div>
										<input type="text" id="bnf_count" class="o_input" name="bnf_count" value="<?php echo set_value('bnf_count'); ?>" >
										<?php echo form_error('bnf_count', '<div class="error" style="color:red;">','</div>'); ?>
									</td>
								</tr>
								<tr class=" d-none">
									<th>주소 <span class="color_red">*</span></th>
									<td><div class="ttl_mobile"><h5>주소 <span class="color_red">*</span></h5></div>
										<input type="text" id="bnf_postcode" name="bnf_postcode" value="<?php echo set_value('bnf_postcode'); ?>" readonly class="o_input bg_readonly"  style="width:120px;" /> <button type="button" onclick="srh_execDaumPostcode('bnf_'); return false;" class="o_btn btn btn-dark-flat btn-sm">검색</button>
										<div class="pt_5">
											<input type="text" id="bnf_addr" class="o_input bg_readonly" style="width:100%;" name="bnf_addr" value="<?php echo set_value('bnf_addr'); ?>" readonly >
										</div>
										<div class="pt_5">
											<input type="text" id="bnf_addr_detail" class="o_input" style="width:100%;" name="bnf_addr_detail" value="<?php echo set_value('bnf_addr_detail'); ?>" placeholder="추가주소를 입력해주세요.">
										</div>

										<?php echo form_error('bnf_addr', '<div class="error" style="color:red;">','</div>'); ?>
										<?php echo form_error('bnf_addr_detail', '<div class="error" style="color:red;">','</div>'); ?>
									</td>
								</tr>
								<tr class=" d-none">
									<th>휴대전화 <span class="color_red">*</span></th>
									<td><div class="ttl_mobile"><h5>휴대전화 <span class="color_red">*</span></h5></div>
										<input type="text" id="bnf_phone_1" class="o_input " name="bnf_phone_1" value="<?php echo set_value('bnf_phone_1','010'); ?>"  pattern="[0-9]+" maxlength="3"  style="width: 60px;" onKeyup="this.value=this.value.replace(/[^0-9]/g,'');" />
										<input type="text" id="bnf_phone_2" class="o_input " name="bnf_phone_2" value="<?php echo set_value('bnf_phone_2'); ?>"  pattern="[0-9]+" maxlength="4"  style="width: 70px;" onKeyup="this.value=this.value.replace(/[^0-9]/g,'');" />
										<input type="text" id="bnf_phone_3" class="o_input " name="bnf_phone_3" value="<?php echo set_value('bnf_phone_3'); ?>"  pattern="[0-9]+" maxlength="4"  style="width: 70px;" onKeyup="this.value=this.value.replace(/[^0-9]/g,'');" onkeyup="return onlyNumber();" />

										<input type="hidden" id="bnf_phone" class="o_input " name="bnf_phone" value="<?php echo set_value('bnf_phone'); ?>" readonly style="background-color:#cccccc; width: 120px; text-align:center;" />
										<?php echo form_error('bnf_phone', '<div class="error" style="color:red;">','</div>'); ?>
									</td>
								</tr>
								<tr>
									<th>희망기기 수량 <span class="color_red">*</span></th>
									<td><div class="ttl_mobile"><h5>희망기기 수량 <span class="color_red">*</span></h5></div>
										<input type="text" id="bnf_devices" class="o_input" name="bnf_devices" value="<?php echo set_value('bnf_devices'); ?>" />
										<?php echo form_error('bnf_devices', '<div class="error" style="color:red;">','</div>'); ?>
									</td>
								</tr>
								<tr>
									<th><div class="change_line" style="">단체소개서 및<br /> 활동보고서<span class="color_red">*</span></div></th>
									<td><div class="ttl_mobile"><h5>단체소개서 및 활동보고서 <span class="color_red">*</span></h5></div>
										<textarea id="bnf_content" class="o_input" name="bnf_content" style="width:100%; height: 150px;" placeholder="구체적일수록 선정 가능성이 높습니다."><?php echo set_value('bnf_content') ?></textarea>
										<?php echo form_error('bnf_content', '<div class="error" style="color:red;">','</div>'); ?>
									</td>
								</tr>

								<?php if(! $this->tank_auth->is_logged_in()) { ?>
								<tr>
									<th>자동등록 방지  <span class="color_red">*</span></th>
									<td><div class="ttl_mobile"><h5>자동등록 방지  <span class="color_red">*</span></h5></div>

										<?php if ($show_captcha) { ?>
										<div>

											<?php if ($use_recaptcha) { ?>

													<h6 style="font-size:13px; margin:5px 0;">아래의 코드를 정확하게  입력해주세요.</h6>
													<input type="text" id="recaptcha_response_field" name="recaptcha_response_field" class="o_input" />
													<?php //echo form_error('recaptcha_response_field'); ?>
													<?php echo form_error('recaptcha_response_field','<div class="error">','</div>'); ?>


													<div style="margin-top:5px; padding:10px 5px; border:1px solid #eee;">
													  <div id="recaptcha_image"></div>
													</div>

													<a href="javascript:Recaptcha.reload()">Get another CAPTCHA</a>
													<div class="recaptcha_only_if_image"><a href="javascript:Recaptcha.switch_type('audio')">Get an audio CAPTCHA</a></div>
													<div class="recaptcha_only_if_audio"><a href="javascript:Recaptcha.switch_type('image')">Get an image CAPTCHA</a></div>

													<div style="margin:5px 0;"><?php echo $recaptcha_html; ?></div>

											<?php } else { ?>

													<h6 style="font-size:13px; margin:13px 0 0 0;">아래의 코드를 정확하게  입력해주세요.  <button id="btn_code_renew" type="button" class="btn btn-dark btn-xs" onclick="">새로고침</button></h6>
													<div style="padding-top:5px;">
														<span id="layer_captcha_html" style="display:inline-block;padding:5px 0;"><?php echo $captcha_html; ?></span>
														<?php echo form_input($captcha); ?>
													</div>
													<?php echo form_error($captcha['name'],'<div class="error">','</div>'); ?>

											<?php } ?>

										</div>
										<?php } ?>

									</td>
								</tr>
								<?php } ?>
							</table>

						</div>


						<div style="position:relative; width:100%; padding:30px 0; text-align:center; ">
							<input type="submit" name="submit" value="나눔신청"  class="o_btn btn btn-dark-flat btn-lg" style="font-size:20px; padding:12px 40px;" />
						</div>

					<?php echo form_close(); ?>


	</div>
  </div>
</div>









<!-- iOS에서는 position:fixed 버그가 있음, 적용하는 사이트에 맞게 position:absolute 등을 이용하여 top,left값 조정 필요 -->
<div id="layer_execDaumPostcode" style="display:none;position:fixed;overflow:hidden;z-index:11;-webkit-overflow-scrolling:touch;">
<img src="//t1.daumcdn.net/postcode/resource/images/close.png" id="btnCloseLayer" style="cursor:pointer;position:absolute;right:-3px;top:-3px;z-index:1" onclick="closeDaumPostcode()" alt="닫기 버튼">
</div>



<script src="//t1.daumcdn.net/mapjsapi/bundle/postcode/prod/postcode.v2.js"></script>
<script>
    // 우편번호 찾기 화면을 넣을 element
    var element_layer = document.getElementById('layer_execDaumPostcode');

    function closeDaumPostcode() {
        // iframe을 넣은 element를 안보이게 한다.
        element_layer.style.display = 'none';
    }

    function srh_execDaumPostcode(pre) {
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
                document.getElementById(pre+'postcode').value = data.zonecode; //5자리 새우편번호 사용
                document.getElementById(pre+'addr').value = fullAddr;
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

		//console.log(document.documentElement.clientWidth);
		// 모바일 대응
		var client_width = document.documentElement.clientWidth;
		if(client_width <= 500) {
			width = client_width - 30;
			height = 300;
		}

        // 위에서 선언한 값들을 실제 element에 넣는다.
        element_layer.style.width = width + 'px';
        element_layer.style.height = height + 'px';
        element_layer.style.border = borderWidth + 'px solid';
        // 실행되는 순간의 화면 너비와 높이 값을 가져와서 중앙에 뜰 수 있도록 위치를 계산한다.
        element_layer.style.left = (((window.innerWidth || document.documentElement.clientWidth) - width)/2 - borderWidth) + 'px';
        element_layer.style.top = (((window.innerHeight || document.documentElement.clientHeight) - height)/2 - borderWidth + 40) + 'px';
    }
</script>




<script type="text/javascript">
$(document).ready(function(){

	// 개인 / 사업자 구분
	$('.gubun_radio').on('click', function() {
		var gubun = $(this).val();
		// 사업자 및 개인 구분 처리
		if('단체' == gubun) {
			// 사업자
			$('.type_B').show();
			//$('.manager_name').html('담당자 이름');
		}
		else if('개인' == gubun) {
			// 개인
			$('.type_B').hide();
			//$('.manager_name').html('신청자명');
		}
	});

	// 신청자 휴대전화
	$('#req_phone_1').on('change blur', function(){
		phone = get_phone('req');
		$('#req_phone').val(phone);
	});
	$('#req_phone_2').on('keydown keyup blur', function(){
		phone = get_phone('req');
		$('#req_phone').val(phone);
	});
	$('#req_phone_3').on('keydown keyup blur', function(){
		phone = get_phone('req');
		$('#req_phone').val(phone);
	});

	// 수혜자 휴대전화
	$('#bnf_phone_1').on('change blur', function(){
		phone = get_phone('bnf');
		$('#bnf_phone').val(phone);
	});
	$('#bnf_phone_2').on('keydown keyup blur', function(){
		phone = get_phone('bnf');
		$('#bnf_phone').val(phone);
	});
	$('#bnf_phone_3').on('keydown keyup blur', function(){
		phone = get_phone('bnf');
		$('#bnf_phone').val(phone);
	});

	function get_phone(flag) {
		var pre = flag+'_';
		phone_1 = $('#'+pre+'phone_1').val();
		phone_2 = $('#'+pre+'phone_2').val();
		phone_3 = $('#'+pre+'phone_3').val();
		phone = '';
		if( phone_1 != '' && phone_2 != '' && phone_3 != '') {
			phone = phone_1+'-'+phone_2+'-'+phone_3;
		}
		return phone;
	}

	// 신청자 이름으로 글 제목 만들기
	/*
	$('#req_name').on('keydown keyup blur', function(){
		fn_mk_subject(this.value);
	});
	*/

	// 신청자 정보 동일 체크
	$('#same_form').on('click', function(){

		var chked = $(this).is(':checked');

			if( chked ) {
				
				req_name = $('#req_name').val();
				req_postcode = $('#req_postcode').val();
				req_addr = $('#req_addr').val();
				req_addr_detail = $('#req_addr_detail').val();

				req_birthday = $('#req_birthday').val();

				req_phone_1 = $('#req_phone_1').val();
				req_phone_2 = $('#req_phone_2').val();
				req_phone_3 = $('#req_phone_3').val();
				req_phone = $('#req_phone').val();

				$('#bnf_name').val(req_name);
				$('#bnf_postcode').val(req_postcode);
				$('#bnf_addr').val(req_addr);
				$('#bnf_addr_detail').val(req_addr_detail);
				$('#bnf_birthday').val(req_birthday);

				$('#bnf_phone_1').val(req_phone_1);
				$('#bnf_phone_2').val(req_phone_2);
				$('#bnf_phone_3').val(req_phone_3);

				$('#bnf_phone').val(req_phone);

			}
			else {
				
				$('#bnf_name').val('');
				$('#bnf_postcode').val('');
				$('#bnf_addr').val('');
				$('#bnf_addr_detail').val('');
				$('#bnf_birthday').val('');

				$('#bnf_phone_1').val('');
				$('#bnf_phone_2').val('');
				$('#bnf_phone_3').val('');

				$('#bnf_phone').val('');

			}

			


	});


	$('#email_comp').on('change', function(){

		var ecomp = $(this).val();

		//console.log(ecomp);
		if('direct' == ecomp) {
			$('#email_2').val('');
		}
		else if('' != ecomp) {
			$('#email_2').val(ecomp);
		}
	});

	$('#email_comp2').on('change', function(){

		var ecomp = $(this).val();

		//console.log(ecomp);
		if('direct' == ecomp) {
			$('#email_4').val('');
		}
		else if('' != ecomp) {
			$('#email_4').val(ecomp);
		}
	});

});
</script>



<script type="text/javascript">
	$(document).ready(function(){
		$("#btn_code_renew").click(function(){
			renew_cap();
		});

		function renew_cap() {
			$.ajax({
				url: "/campaign/renew_captcha", 
				success: function(result){
					//console.log(result);
					$("#layer_captcha_html").html(result);
				}
			});
		}
		
		//$('#btn_code_renew').trigger("click");

		
		function click_renew() {
			$('#btn_code_renew').trigger("click");
		}
		//setTimeout(click_renew, 300);
		
	});
</script>




<script type="text/javascript">
	$R('#bnf_content', { 
		focus: false,
		//toolbarExternal: '#my-external-toolbar',
		lang: 'ko',
		minHeight: '300px',
		maxHeight: '500px',
		//plugins: ['fontsize','fontcolor','filemanager','video','table','alignment','inlinestyle','specialchars','widget','fontfamily','fullscreen'],
		plugins: ['filemanager'],
		imageUpload: "/files/upload/redactor_image/<?php echo url_code('sharecampaign/image','e') ?>/sharecampaign/<?php echo $wr_idx ?>",
		imagePosition: true,
		fileUpload: "/files/upload/redactor_file/<?php echo url_code('sharecampaign/files','e') ?>/sharecampaign/<?php echo $wr_idx ?>",
		/*
		buttonsAddAfter: {
			after: 'deleted',
			buttons: ['underline','line', 'redo', 'undo', 'underline', 'ol', 'ul', 'sup', 'sub']
		},
		*/
		buttonsHide: ['lists']
	});
</script>