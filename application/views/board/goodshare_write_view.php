<?php
/*
# 참고 사이트
# https://news.seoul.go.kr/gov/lovepc-request-info/lovepc-request
*/

// 제목 설정
$input_subject = array(
	'name'	=> 'wr_subject',
	'id'	=> 'wr_subject',
	'value' => set_value('wr_subject',(isset($row->wr_subject) ? $row->wr_subject : '')),
	'maxlength'	=> 255,
	'class' => 'o_input',
	'placeholder' => '신청사유를 입력하세요.',
	'autocomplete' => 'off',
	'style'	=> 'max-width:80%;vertical-align:middle;'
);

// 공지 체크 설정
if( $wr_idx > 0 ) {
	$arr_bo_notice_idxs = explode(',',$bbs_cf->bo_notice_idxs);
	$cf_checked_notice = in_array($row->wr_idx, $arr_bo_notice_idxs);
}
else {
	$cf_checked_notice = FALSE;
}
$checked_notice = (isset($row->opt_notice) && $row->opt_notice > 0) ? TRUE : $cf_checked_notice;
$input_option_notice = array(
	'name'	=> 'opt_notice',
	'id'	=> 'opt_notice',
	'value' => '1',
	'checked' => set_checkbox('opt_notice','1',$checked_notice),
	'style'	=> 'vertical-align:middle'
);

// 비밀글 체크 설정
$cf_checked_secret = FALSE;
$bo_use_secret = $bbs_cf->bo_use_secret;
if('0' === $bo_use_secret):
	// 비밀글 사용 안함
	$cf_checked_secret = FALSE;
elseif('1' === $bo_use_secret):
	// 비밀글 사용, 기본 일반글
	$cf_checked_secret = FALSE;
elseif('2' === $bo_use_secret):
	// 비밀글 사용, 기본 비밀글
	$cf_checked_secret = TRUE;
elseif('3' === $bo_use_secret):
	// 비밀글 사용, 무조건 비밀글
	$cf_checked_secret = TRUE;
endif;
$checked_secret = (isset($row->opt_secret) && $row->opt_secret > 0) ? TRUE : $cf_checked_secret;

$input_option_secret = array(
	'name'	=> 'opt_secret',
	'id'	=> 'opt_secret',
	'value' => '1',
	//'checked' => set_checkbox('opt_secret','1',$checked_secret),
	'checked' => $checked_secret,
	'style'	=> 'vertical-align:middle'
);

$captcha = array(
	'name'	=> 'captcha',
	'id'	=> 'captcha',
	'maxlength'	=> 8,
	'class' => 'o_input',
	'autocomplete' => 'off',
	'style' => 'width:200px; line-height:45px;'
);
?>


<?php

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
// 모바일 설정
$_class_container = 'container';
if(IS_MOBILE) {
	$_class_container = 'm_container_bbs';
}
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

</style>





<div class="contents_wrap">
	<!-- 캠페인 상세 -->
	<div class="<?php echo $_class_container ?> py_35" style="margin:0 auto;">

		<div>
			<?php echo $bbs_cf->bo_head; ?>
		</div>


		<!-- 페이지 내용 -->
		<div class="o_page_content">
			<section class="o_ctnt" >

				<div style="width:100%; height:300px; background-color:#f3f3fa;">
					나눔 신청 배너 이미지
				</div>

			</section>
		</div>



		<!-- 페이지 내용 -->
		<div class="o_page_content">
			<section class="o_ctnt" >

				<div class="mt_20">

					<?php echo form_open_multipart($this->uri->uri_string(), array('id'=>'board_form','name'=>'board_form','onsubmit'=>'frm_submit();')); ?>


						<?php //echo validation_errors('<div class="error">', '</div>'); ?>

						<input type="hidden" id="wr_subject" name="wr_subject" value="<?php echo set_value('wr_subject',isset($user->nickname) ? $user->nickname.'님의 신청입니다.' : '') ?>" />

						<?php if( $bbs_cf->bo_use_secret > 0 ) { ?>
						<div>
							<?php
							if($bbs_cf->bo_use_secret === '0' ) {
								// 비밀글 사용 안함
							} elseif($bbs_cf->bo_use_secret === '3' ) {
								// 무조건 비밀글
								echo form_hidden('opt_secret', '1');
							} else {
								echo '<label for="opt_secret">'. form_checkbox($input_option_secret) .' 비밀글</label> &nbsp;';
							}
							?>
						</div>
						<?php } ?>

						<div class="o_agree_ctnt">
							<h4 class="mb_5" style="font-weight:bold;">개인정보 수집 및 이용 동의 <span class="color_red">*</span></h4>
							<div class="mb_15">
								<?php echo $this->config->item('website_name', 'tank_auth') ?>에서는 원활한 물품 기부를 위해 개인정보를 수집하고 있습니다.
							</div>

							<dl>
								<dt>개인정보 제공받는 자 : </dt>
								<dd><?php echo $this->config->item('website_name', 'tank_auth') ?> 담당자(0000-0000)</dd>
							</dl>
							<dl>
								<dt>개인정보 수집 범위 : </dt>
								<dd>고객명, 연락처, 주소, 이메일</dd>
							</dl>
							<dl>
								<dt>개인정보 수집 및 이용목적 : </dt>
								<dd>물품기부 활용(0000-0000)</dd>
							</dl>
							<dl>
								<dt>개인정보 제공받는 자 : </dt>
								<dd>개인정보는 수집 및 이용 목적 달성시까지 보유하며, 이용목적 달성 후 파기하는 것을 원칙으로 함.</dd>
							</dl>

							<hr style="border:none; border-bottom:1px solid #ccc;" />
							<div style="vertical-align:baseline;">
								
								<label class="o_checkbox_container ml-2" style="vertical-align:top;">
									개인정보 처리에 동의합니다. 
									<input type="checkbox" name="chk_agree" value="1" <?php echo set_checkbox('chk_agree', '1'); ?> />
									<span class="o_chk_checkmark"></span>
								</label>
								<?php echo form_error('chk_agree', '<div class="error">','</div>'); ?>
							</div>
						</div>



						<h3 class="pt_30 mb_5 color_purple">신청자 정보</h3>
						<div class="tbl_purple">
							<table style="max-width:100%; border-top:1px solid #000000;">
								<colgroup>
									<col style="width:<?php echo (IS_MOBILE) ? '35%' : '200px'?>;">
									<col style="width:<?php echo (IS_MOBILE) ? '65%' : ''?>;">
								</colgroup>
								<tr class="gubun">
									<th>구분 <span class="color_red">*</span></th>
									<td>
										<div class="o_radio_container">
											<label for="gubun_per"><input type="radio" id="gubun_per" class="gubun_radio" name="gubun" value="개인" <?php echo  set_radio('gubun', '개인', ! isset($row->gubun) || (isset($row->gubun) && $row->gubun == '개인') ? TRUE : ''); ?> /> 개인</label>
											<label for="gubun_org"><input type="radio" id="gubun_org" class="gubun_radio" name="gubun" value="단체" <?php echo  set_radio('gubun', '단체', (isset($row->gubun) && $row->gubun == '단체') ? TRUE : ''); ?> /> 단체</label>
										</div>
										<?php echo form_error('gubun', '<div class="error" style="color:red;">','</div>'); ?>
									</td>
								</tr>
								<tr class="type_A">
									<th class="manager_name">신청자명 <span class="color_red">*</span></th>
									<td>
										<input type="text" id="req_name" class="o_input" style="max-width:80%;" name="req_name" value="<?php echo isset($user->nickname) ? $user->nickname : set_value('req_name'); ?>" autocomplete="off" >
										<?php echo form_error('req_name', '<div class="error" style="color:red;">','</div>'); ?>
									</td>
								</tr>
								<tr class="type_B" style="display: none;">
									<th>상호/<br class="d-block d-sm-none" />법인명</th>
									<td>
										<input type="text" id="req_name_org" class="o_input" style="max-width:80%;" name="req_name_org" value="<?php echo isset($user->comp_name) ? $user->comp_name : set_value('req_name_org'); ?>" autocomplete="off" > <br /><small>대표자 명이 아닌 사업자 등록증 상에 등록된 상호/법인명을 입력해주세요.</small>
										<?php echo form_error('req_name_org', '<div class="error" style="color:red;">','</div>'); ?>
									</td>
								</tr>
								<tr>
									<th>주소 <span class="color_red">*</span></th>
									<td>
										<input type="text" id="req_postcode" name="req_postcode" value="<?php echo isset($user->postcode) ? $user->postcode : set_value('req_postcode'); ?>" readonly class="o_input bg_readonly"  style="width:120px;" autocomplete="off" /> <button type="button" onclick="srh_execDaumPostcode('req_'); return false;" class="o_btn btn btn-dark-flat btn-sm">검색</button>
										<div class="pt_5">
											<input type="text" id="req_addr" class="o_input bg_readonly" style="width:80%;" name="req_addr" value="<?php echo isset($user->addr) ? $user->addr : set_value('req_addr'); ?>" readonly autocomplete="off" >
										</div>
										<div class="pt_5">
											<input type="text" id="req_addr_detail" class="o_input" style="width:80%;" name="req_addr_detail" value="<?php echo isset($user->addr_detail) ? $user->addr_detail : set_value('req_addr_detail'); ?>" placeholder="추가주소를 입력해주세요." autocomplete="off">
										</div>

										<?php echo form_error('req_addr', '<div class="error" style="color:red;">','</div>'); ?>
										<?php echo form_error('req_addr_detail', '<div class="error" style="color:red;">','</div>'); ?>
									</td>
								</tr>
								<tr>
									<th>생년월일 <span class="color_red">*</span></th>
									<td>
										<input type="text" id="req_birthday" class="o_input" style="max-width:80%;" name="req_birthday" value="<?php echo isset($user->birthday) ? $user->birthday : set_value('req_birthday'); ?>" autocomplete="off" >
										<div><small style="color:#7a7a7a;">예) 770717 (1977년 7월 17일)</small></div>
										<?php echo form_error('req_birthday', '<div class="error" style="color:red;">','</div>'); ?>
									</td>
								</tr>

								<tr>
									<th>휴대전화 <span class="color_red">*</span></th>
									<td>
									<?php 
										//print_r($user)
										$arr_phone = array('','','');

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
										<select id="req_phone_1" name="req_phone_1" class="o_selectbox" style="width: 70px;">
											<option value="010" <?php echo ('010' == $arr_phone[0]) ? 'selected': ''; ?>>010</option>
											<option value="011" <?php echo ('011' == $arr_phone[0]) ? 'selected': ''; ?>>011</option>
											<option value="016" <?php echo ('016' == $arr_phone[0]) ? 'selected': ''; ?>>016</option>
											<option value="017" <?php echo ('017' == $arr_phone[0]) ? 'selected': ''; ?>>017</option>
											<option value="018" <?php echo ('018' == $arr_phone[0]) ? 'selected': ''; ?>>018</option>
											<option value="019" <?php echo ('019' == $arr_phone[0]) ? 'selected': ''; ?>>019</option>
										</select>
										<input type="text" id="req_phone_2" class="o_input " name="req_phone_2" value="<?php echo set_value('req_phone_2', isset($arr_phone[1]) ? $arr_phone[1] : ''); ?>"  pattern="[0-9]+" maxlength="4"  style="width: 70px;" onKeyup="this.value=this.value.replace(/[^0-9]/g,'');" autocomplete="off" />
										<input type="text" id="req_phone_3" class="o_input " name="req_phone_3" value="<?php echo isset($arr_phone[2]) ? $arr_phone[2] : set_value('req_phone_3'); ?>"  pattern="[0-9]+" maxlength="4"  style="width: 70px;" onKeyup="this.value=this.value.replace(/[^0-9]/g,'');" onkeyup="return onlyNumber();" autocomplete="off" />

										<input type="hidden" id="req_phone" class="o_input " name="req_phone" value="<?php echo set_value('req_phone',isset($row->req_phone) ? $row->req_phone : '') ?>" readonly style="background-color:#cccccc; width: 120px; text-align:center;" />
										<?php echo form_error('req_phone', '<div class="error" style="color:red;">','</div>'); ?>
									</td>
								</tr>
								<tr>
									<th>신청사유 <span class="color_red">*</span></th>
									<td>
										<?php echo form_input($input_subject); ?>
										<?php echo form_error('wr_subject','<div class="error">','</div>'); ?>
									</td>
								</tr>
							</table>

						</div>





						<h3 class="pt_30 mb_5 color_purple">수혜자 정보 <small style="color:#000; font-size:15px;">( <input type="checkbox" id="same_form" /> <label for="same_form" style="color:#000; font-size:15px;">신청자 정보와 동일합니다.)</label></small></h3>
						<div class="tbl_purple" style="">
							<table style="width:100%; ">
								<colgroup>
									<col style="width:<?php echo (IS_MOBILE) ? '35%' : '200px'?>;">
									<col style="width:<?php echo (IS_MOBILE) ? '65%' : ''?>;">
								</colgroup>
								<tr>
									<th>수혜자명 <span class="color_red">*</span></th>
									<td>
										<input type="text" id="bnf_name" class="o_input" name="bnf_name" value="<?php echo set_value('bnf_name'); ?>" autocomplete="off" >
										<?php echo form_error('bnf_name', '<div class="error" style="color:red;">','</div>'); ?>
									</td>
								</tr>
								<tr>
									<th>수혜대상 <span class="color_red">*</span></th>
									<td>
										<select id="bnf_target" name="bnf_target" class="o_selectbox" style="min-width: 180px;">
											<option value="수혜대상 1">수혜대상 1</option>
											<option value="수혜대상 2">수혜대상 2</option>
											<option value="수혜대상 3">수혜대상 3</option>
											<option value="수혜대상 4">수혜대상 4</option>
										</select>
										<?php echo form_error('bnf_target', '<div class="error" style="color:red;">','</div>'); ?>
									</td>
								</tr>
								<tr>
									<th>주소 <span class="color_red">*</span></th>
									<td>
										<input type="text" id="bnf_postcode" name="bnf_postcode" value="<?php echo set_value('bnf_postcode'); ?>" readonly class="o_input bg_readonly"  style="width:120px;" autocomplete="off" /> <button type="button" onclick="srh_execDaumPostcode('bnf_'); return false;" class="o_btn btn btn-dark-flat btn-sm">검색</button>
										<div class="pt_5">
											<input type="text" id="bnf_addr" class="o_input bg_readonly" style="width:100%;" name="bnf_addr" value="<?php echo set_value('bnf_addr'); ?>" readonly autocomplete="off" >
										</div>
										<div class="pt_5">
											<input type="text" id="bnf_addr_detail" class="o_input" style="width:100%;" name="bnf_addr_detail" value="<?php echo set_value('bnf_addr_detail'); ?>" placeholder="추가주소를 입력해주세요." autocomplete="off">
										</div>

										<?php echo form_error('bnf_addr', '<div class="error" style="color:red;">','</div>'); ?>
										<?php echo form_error('bnf_addr_detail', '<div class="error" style="color:red;">','</div>'); ?>
									</td>
								</tr>
								<tr>
									<th>생년월일 <span class="color_red">*</span></th>
									<td>
										<input type="text" id="bnf_birthday" class="o_input" name="bnf_birthday" value="<?php echo set_value('bnf_birthday'); ?>" autocomplete="off" >
										<div><small style="color:#7a7a7a;">예) 770717 (1977년 7월 17일)</small></div>
										<?php echo form_error('bnf_birthday', '<div class="error" style="color:red;">','</div>'); ?>
									</td>
								</tr>

								<tr>
									<th>휴대전화 <span class="color_red">*</span></th>
									<td>
										<select id="bnf_phone_1" name="bnf_phone_1" class="o_selectbox" style="width: 70px;">
											<option value="010">010</option>
											<option value="011">011</option>
											<option value="016">016</option>
											<option value="017">017</option>
											<option value="018">018</option>
											<option value="019">019</option>
										</select>
										<input type="text" id="bnf_phone_2" class="o_input " name="bnf_phone_2" value="<?php echo set_value('bnf_phone_2'); ?>"  pattern="[0-9]+" maxlength="4"  style="width: 70px;" onKeyup="this.value=this.value.replace(/[^0-9]/g,'');" autocomplete="off" />
										<input type="text" id="bnf_phone_3" class="o_input " name="bnf_phone_3" value="<?php echo set_value('bnf_phone_3'); ?>"  pattern="[0-9]+" maxlength="4"  style="width: 70px;" onKeyup="this.value=this.value.replace(/[^0-9]/g,'');" onkeyup="return onlyNumber();" autocomplete="off" />

										<input type="hidden" id="bnf_phone" class="o_input " name="bnf_phone" value="<?php echo set_value('bnf_phone'); ?>" readonly style="background-color:#cccccc; width: 120px; text-align:center;" />
										<?php echo form_error('bnf_phone', '<div class="error" style="color:red;">','</div>'); ?>
									</td>
								</tr>
								<tr>
									<th>희망기기<br /> 수량 <span class="color_red">*</span></th>
									<td>
										<input type="text" id="bnf_devices" class="o_input" name="bnf_devices" value="<?php echo set_value('bnf_devices'); ?>" style="width: 100%;" autocomplete="off" />
										<?php echo form_error('bnf_devices', '<div class="error" style="color:red;">','</div>'); ?>
									</td>
								</tr>
								<tr>
									<th><div class="change_line" style="">수혜대상<br class="d-block d-sm-none" /> 소개 및 <br />기기 <br class="d-block d-sm-none" />활용목적 <span class="color_red">*</span></div></th>
									<td>
										<textarea id="wr_content" class="o_input" name="wr_content" style="width:100%; height: 150px;" placeholder="수혜대상 소개 및 기기 활용목적을 작성해주세요.."><?php echo set_value('wr_content') ?></textarea>
										<?php echo form_error('wr_content', '<div class="error" style="color:red;">','</div>'); ?>
									</td>
								</tr>
								<!-- <tr>
									<th>비밀번호 <span class="color_red">*</span></th>
									<td>
										<input type="password" id="passwd" class="o_input" name="passwd" value="" />
										<?php echo form_error('passwd', '<div class="error" style="color:red;">','</div>'); ?>
									</td>
								</tr> -->

								<?php if(('reply' === $mode  OR  'write' === $mode)  && (! $this->tank_auth->is_logged_in())) { ?>
								<tr>
									<th>자동등록 방지  <span class="color_red">*</span></th>
									<td>

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

						<!-- 업로드 -->
						<?php if( $bbs_cf->bo_use_upload > 0 ) { ?>
						<h3 class="pt_30 mb_5 color_purple">자동등록 방지 </label></small></h3>
						<div class="tbl_purple">
							<table style="width:100%;">
								<colgroup>
									<col width="200">
									<col>
								</colgroup>
								<tr>
									<th>첨부파일</th>
									<td>
										<?php
										$fno_limit = $bbs_cf->bo_upload_cnt;
										for($fno=0;$fno<$fno_limit;$fno++) {
										?>
										  <div><input type="file" name="attach_file_form[]" class="o_input_file mb-1" style="width:100%;" /></div>
										<?php } ?>


										<?php if($result_file_form && $result_file_form['total_count'] > 0) { ?>
										<ul style="background-color:#ffffff; margin-top:5px; padding:15px; border:1px solid #EEEEEE; list-style:none;">
										  <?php foreach($result_file_form['qry'] as $i => $o) { ?>
										  <li class="file_form_<?php echo $i ?>" style="position:relative; line-height:170%; font-size:15px;">
											<?php echo $o->file_name_org ?> (<?php echo number_format($o->file_size) ?> KB)
											<img src="<?php echo IMG_DIR ?>/common/icon_btn_del.gif" style="cursor:pointer;" alt="삭제" title="삭제" onclick="delete_file_manager(<?php echo $o->idx ?>,'file_form_<?php echo $i ?>','<?php echo $o->file_type ?>','<?php echo $o->file_dir ?>','<?php echo $o->file_name ?>')" />
										  </li>
										  <?php } ?>
										</ul>
										<?php } ?>
									</td>
								</tr>
							</table>
						</div>
						<?php } ?>





						<div style="position:relative; width:100%; padding:30px 0; text-align:center; ">
							<input type="submit" name="submit" value="나눔신청"  class="o_btn btn btn-dark-flat btn-lg" style="font-size:20px; padding:12px 40px;" />
						</div>

					<?php echo form_close(); ?>


				</div>
			</section>
		</div>
	</div>
</div>




<script type="text/javascript">
/*
  function fn_mk_subject(wr_name) {
	if(wr_name != '') {
		$('#wr_subject').val(wr_name+'님의 신청입니다.');
	}
	else {
		$('#wr_subject').val('');
	}
  }

  function frm_submit() {
	var wr_name = $('#req_name').val();
	if(wr_name != '') {
		$('#wr_subject').val(wr_name+'님의 신청입니다.');
	}
	else {
		$('#wr_subject').val('');
	}
  }
*/
</script>

<!-- iOS에서는 position:fixed 버그가 있음, 적용하는 사이트에 맞게 position:absolute 등을 이용하여 top,left값 조정 필요 -->
<div id="layer_execDaumPostcode" style="display:none;position:fixed;overflow:hidden;z-index:1;-webkit-overflow-scrolling:touch;">
<img src="//t1.daumcdn.net/localimg/localimages/07/postcode/320/close.png" id="btnCloseLayer" style="cursor:pointer;position:absolute;right:-3px;top:-3px;z-index:1" onclick="closeDaumPostcode()" alt="닫기 버튼">
</div>

<script src="http://dmaps.daum.net/map_js_init/postcode.v2.js"></script>
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

        // 위에서 선언한 값들을 실제 element에 넣는다.
        element_layer.style.width = width + 'px';
        element_layer.style.height = height + 'px';
        element_layer.style.border = borderWidth + 'px solid';
        // 실행되는 순간의 화면 너비와 높이 값을 가져와서 중앙에 뜰 수 있도록 위치를 계산한다.
        element_layer.style.left = (((window.innerWidth || document.documentElement.clientWidth) - width)/2 - borderWidth) + 'px';
        element_layer.style.top = (((window.innerHeight || document.documentElement.clientHeight) - height)/2 - borderWidth) + 'px';
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