<?php
// 카테고리메뉴
$selected_ca_code =  (isset($cate_menu) && '' !=$cate_menu) ? $cate_menu : (isset($row->ca_code) ? $row->ca_code : set_value('ca_code'));
$ca_code_options = array('' => '카테고리를 선택해주세요.');
if('' !== trim($bbs_cf->bo_category)) {
	$arr_bbs_menu = explode(',',$bbs_cf->bo_category);
	foreach($arr_bbs_menu as $i=>$menu) {
		$ca_code_options[$menu] = $menu;
	}
}




// 기관명(제목) 설정
$input_subject = array(
	'name'	=> 'wr_subject',
	'id'	=> 'wr_subject',
	'value' => isset($row->wr_subject) ? $row->wr_subject : set_value('wr_subject'),
	'maxlength'	=> 255,
	'class' => 'o_input',
	'placeholder' => '기관명을 입력하세요.',
	'autocomplete' => 'off',
	'style'	=> 'width:100%;padding:5px 7px;vertical-align:middle; font-size:17px;'
);
// 담당자명(선택)
$input_manager = array(
	'name'	=> 'addfld_1',
	'id'	=> 'addfld_1',
	'value' => isset($row->addfld_1) ? $row->addfld_1 : set_value('addfld_1'),
	'maxlength'	=> 255,
	'class' => 'o_input',
	'placeholder' => '담당자명을 입력하세요.',
	'autocomplete' => 'off',
	'style'	=> 'width:100%;padding:5px 7px;vertical-align:middle; font-size:17px;'
);
// 주소 (우편번호)
$input_postcode = array(
	'name'	=> 'addfld_2',
	'id'	=> 'postcode',
	'value' => isset($row->addfld_2) ? $row->addfld_2 : set_value('addfld_2'),
	'maxlength'	=> 5,
	'class' => 'o_input',
	'placeholder' => '우편번호',
	'autocomplete' => 'off',
	'style'	=> 'width:100px;padding:5px 7px;vertical-align:middle; font-size:17px;'
);
// 주소 1
$input_addr = array(
	'name'	=> 'addfld_3',
	'id'	=> 'addr',
	'value' => isset($row->addfld_3) ? $row->addfld_3 : set_value('addfld_3'),
	'maxlength'	=> 255,
	'class' => 'o_input mb-1',
	'placeholder' => '주소 검색 버튼을 클릭하여 주소를 입력하세요.',
	'autocomplete' => 'off',
	'style'	=> 'width:100%;padding:5px 7px;vertical-align:middle; font-size:17px;'
);
// 주소 2
$input_addr_detail = array(
	'name'	=> 'addfld_4',
	'id'	=> 'addr_detail',
	'value' => isset($row->addfld_4) ? $row->addfld_4 : set_value('addfld_4'),
	'maxlength'	=> 255,
	'class' => 'o_input mb-1',
	'placeholder' => '주소 검색 버튼을 클릭하여 상세주소를 입력하세요.',
	'autocomplete' => 'off',
	'style'	=> 'width:100%;padding:5px 7px;vertical-align:middle; font-size:17px;'
);
// 이메일
$input_email = array(
	'name'	=> 'addfld_5',
	'id'	=> 'addfld_5',
	'value' => isset($row->addfld_5) ? $row->addfld_5 : set_value('addfld_5'),
	'maxlength'	=> 255,
	'class' => 'o_input',
	'placeholder' => '이메일을 입력하세요.',
	'autocomplete' => 'off',
	'style'	=> 'width:100%;padding:5px 7px;vertical-align:middle; font-size:17px;'
);
// 사업분야
$input_business = array(
	'name'	=> 'addfld_6',
	'id'	=> 'addfld_6',
	'value' => isset($row->addfld_6) ? $row->addfld_6 : set_value('addfld_6'),
	'maxlength'	=> 255,
	'class' => 'o_input',
	'placeholder' => '사업분야를 입력하세요.',
	'autocomplete' => 'off',
	'style'	=> 'width:40%;padding:5px 7px;vertical-align:middle; font-size:17px;  display:none;'
);
// 단체유형
$input_orgtype = array(
	'name'	=> 'addfld_7',
	'id'	=> 'addfld_7',
	'value' => isset($row->addfld_7) ? $row->addfld_7 : set_value('addfld_7'),
	'maxlength'	=> 255,
	'class' => 'o_input',
	'placeholder' => '단체유형을 입력하세요.',
	'autocomplete' => 'off',
	'style'	=> 'width:40%;padding:5px 7px;vertical-align:middle; font-size:17px;  display:none;'
);
// 홈페이지
$input_website = array(
	'name'	=> 'addfld_8',
	'id'	=> 'addfld_8',
	'value' => isset($row->addfld_8) ? $row->addfld_8 : set_value('addfld_8'),
	'maxlength'	=> 255,
	'class' => 'o_input',
	'placeholder' => '홈페이지 주소를 입력하세요. (http://www.naver.com)',
	'autocomplete' => 'off',
	'style'	=> 'width:100%;padding:5px 7px;vertical-align:middle; font-size:17px;'
);

/*
$input_wr_name = array(
	'name'	=> 'wr_name',
	'id'	=> 'wr_name',
	'value' => isset($row->wr_name) ? $row->wr_name : set_value('wr_name'),
	'maxlength'	=> 255,
	'style'	=> 'width:100%;padding:3px 7px;line-height:20px;font-size:13px; vertical-align:middle;'
);
*/


/*
* 사업분야, 단체유형
*/
	$ttl_business = explode(',',$bbs_cf->arrfld_1_ttl);
	$arr_business = explode(',',$bbs_cf->arrfld_1);
	$ttl_org = explode(',',$bbs_cf->arrfld_2_ttl);
	$arr_org = explode(',',$bbs_cf->arrfld_2);

	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	// 사업분야
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	// $selected_business =  set_value('ca_business');
	$selected_business =  isset($row->addfld_6) ? $row->addfld_6 : set_value('ca_business');
	$ca_business_options = array('' => '사업분야를 선택해주세요.');
	$direct_business = '';
	foreach($arr_business as $i=>$menu) {
		$ca_business_options[$menu] = $menu;
		if( isset($row->addfld_6) && '' != $row->addfld_6 && $direct_business == '') {
			if($row->addfld_6 == $menu) {
				$direct_business = 'none';
			}
		}
	}
	$ca_business_options['direct'] = '기타(직접입력)';
	// 수정시..
	if($direct_business != 'none') {
		$direct_business = 'direct';
		$selected_business = 'direct';
	}

	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	// 단체유형
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	//$selected_org =  set_value('ca_org');
	$selected_org =  isset($row->addfld_7) ? $row->addfld_7 : set_value('ca_org');
	$ca_org_options = array('' => '단체유형을 선택해주세요.');
	$direct_org = '';
	foreach($arr_org as $i=>$menu) {
		$ca_org_options[$menu] = $menu;
		if( isset($row->addfld_7) && '' != $row->addfld_7 && $direct_org == '') {
			if($row->addfld_7 == $menu) {
				$direct_org = 'none';
			}
		}
	}
	$ca_org_options['direct'] = '기타(직접입력)';
	// 수정시..
	if($direct_org != 'none') {
		$direct_org = 'direct';
		$selected_org = 'direct';
	}





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
	'style' => 'padding:10px; '
);


// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
// 모바일 설정
//$_class_container = 'container';
$_class_container = '';
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


	/* 함께 하는 기관 */
	#org_form {}
	#org_form dl { display:flex; flex-direction: row; }
	#org_form dl dt { padding: 10px 0 10px 15px; width: 180px; font-size:17px; font-weight:bold; background-color: #eeeeee;}
	#org_form dl dd { width: calc(100% - 180px); margin:0;}

	.ttl_org_frm { font-size:24px !important; font-weight:bold;}
	.o_input {line-height: 200%; }


	@media screen and (max-width: 991px) {
		#org_form dl { flex-direction: column; }
		#org_form dl dt { width: 100%; }
		#org_form dl dd { width: 100%; }
	}
</style>


<div class="pc_wrap">
  <div class="ctnt_wrap py_40">
	<div class="ctnt_inside">

		<div class="contents_wrap">
			<!-- 캠페인 상세 -->
			<div class="<?php echo $_class_container ?> " style="margin:0 auto;">

				<div>
					<?php echo $bbs_cf->bo_head; ?>
				</div>

				<!-- 페이지 내용 -->
				<div class="o_page_content">
					<section class="o_ctnt" >

						<h3 class="bo_title">
							<strong><?php echo isset($bbs_cf->bo_title) ? $bbs_cf->bo_title : '게시판'; ?></strong>
						</h3>

						<div class="mt_20">

						<?php echo form_open_multipart($this->uri->uri_string(), array('id'=>'org_form','name'=>'org_form')); ?>
								

								<h3 class="ttl_org_frm mt-5">기관 소개</h3>
								<dl>
									<dt class="">기관 소개</dt>
									<dd>
										<textarea id="wr_content" name="wr_content" class="o_input" style="width: 100%; height: 100px; line-height: 150%; padding: 10px; font-size: 16px;" placeholder="(50자 이내)"><?php echo isset($row->wr_content) ? $row->wr_content : set_value('wr_content',$bbs_cf->bo_init_content) ?></textarea>
										<?php echo form_error('wr_content','<div class="error">','</div>'); ?>
									</dd>
								</dl>

								<h3 class="ttl_org_frm mt-5">기관 정보</h3>

								<dl>
									<dt>기관명</dt>
									<dd>
										<?php echo form_input($input_subject); ?>
										<?php echo form_error('wr_subject','<div class="error">','</div>'); ?>
									</dd>
								</dl>
								<dl>
									<dt>담당자명(선택)</dt>
									<dd>
										<?php echo form_input($input_manager); ?>
										<?php echo form_error('addfld_1','<div class="error">','</div>'); ?>
									</dd>
								</dl>
								<dl>
									<dt>주소</dt>
									<dd>
										<div class="mb-1">
											<?php echo form_input($input_postcode); ?> 
											 <button type="button" onclick="srh_execDaumPostcode(); return false;" class="o_btn btn btn-dark btn-lg" style="height:44px; width: 90px;">검색</button>

										</div>
										<?php echo form_input($input_addr); ?>
										<?php echo form_input($input_addr_detail); ?>
										<?php echo form_error('addfld_2','<div class="error">','</div>'); ?>
										<?php echo form_error('addfld_3','<div class="error">','</div>'); ?>
										<?php echo form_error('addfld_4','<div class="error">','</div>'); ?>
									</dd>
								</dl>
								<dl>
									<dt>이메일</dt>
									<dd>
										<?php echo form_input($input_email); ?>
										<?php echo form_error('addfld_5','<div class="error">','</div>'); ?>
									</dd>
								</dl>
								<dl>
									<dt>사업분야</dt>
									<dd style="display:flex;">
										
										<?php echo form_dropdown('ca_business', $ca_business_options, $selected_business, 'id="ca_business" class="form-control o_selectbox" style="width: 30%; padding:5px 7px;vertical-align:middle; font-size:17px; margin-right: 10px; height:42px !important;"'); ?>

										<?php echo form_input($input_business); ?>
										<?php echo form_error('addfld_6','<div class="error">','</div>'); ?>
									</dd>
								</dl>
								<dl>
									<dt>단체유형</dt>
									<dd style="display:flex;">
										<?php echo form_dropdown('ca_org', $ca_org_options, $selected_org, 'id="ca_org" class="form-control o_selectbox" style="width: 30%; padding:5px 7px;vertical-align:middle; font-size:17px; margin-right: 10px;"'); ?>

										<?php echo form_input($input_orgtype); ?>
										<?php echo form_error('addfld_7','<div class="error">','</div>'); ?>
									</dd>
								</dl>
								<dl>
									<dt>홈페이지</dt>
									<dd>
										<?php echo form_input($input_website); ?>
										<?php echo form_error('addfld_8','<div class="error">','</div>'); ?>
									</dd>
								</dl>





								<?php if($bbs_cf->bo_use_category &&  trim($bbs_cf->bo_category) !== '' ) { ?>
								<div>
									<?php echo form_dropdown('ca_code', $ca_code_options, $selected_ca_code, 'class="form-control" style="width:100%;font-size:15px; vertical-align:middle; background-color:#f7f7f7;"'); ?>
									<?php echo form_error('ca_code','<div class="error">','</div>'); ?>
								</div>
								<?php } ?>

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





								<?php
									if(('reply' === $mode  OR  'write' === $mode)  && (! $this->tank_auth->is_logged_in())) {
								?>

								<dl class="board_write">
								  <dt>자동등록방지</dt>
								  <dd>

										<?php if ($show_captcha) { ?>
										<div>

											<?php if ($use_recaptcha) { ?>

													<h6 style="font-size:13px; margin:5px 0;">아래의 코드를 정확하게  입력해주세요.</h6>
													<input type="text" id="recaptcha_response_field" name="recaptcha_response_field" autocomplete="off" />
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

													<h6 style="font-size:13px; margin:5px 0 0 0;">아래의 코드를 정확하게  입력해주세요.  <button id="btn_code_renew" type="button" class="btn btn-default-flat btn-xs" onclick="">새로고침</button></h6>
													<div style="padding-top:5px;">
														<span id="layer_captcha_html" style="margin-top:5px;"><?php echo $captcha_html; ?></span>
														<?php echo form_input($captcha); ?>
													</div>
													<?php echo form_error($captcha['name'],'<div class="error">','</div>'); ?>

											<?php } ?>

										</div>
										<?php } ?>

								  </dd>
								</dl>

								<?php } ?>




								<!-- 업로드 -->
								<?php
								if( $bbs_cf->bo_use_upload > 0 ) {
									$fno_limit = $bbs_cf->bo_upload_cnt;
								?>


									<?php if($fno_limit > 0) { ?>
									<dl>
										<dt>대표이미지</dt>
										<dd>
											<div style="padding: 7px 10px 5px; border: 1px solid silver;"><input type="file" name="attach_file_form[]" class="o_input_file mb-1" style="width:100%; border:none;" /></div>
										</dd>
									</dl>
									<?php } ?>

									<?php if($fno_limit > 1) { ?>
									<dl>
										<dt>첨부 파일</dt>
										<dd>
											<?php
											for($fno=1;$fno<$fno_limit;$fno++) {
											?>
											  <div><input type="file" name="attach_file_form[]" class="o_input_file mb-1" style="width:100%;" /></div>
											<?php } ?>
										</dd>
									</dl>
									<?php } ?>

									<?php if($result_file_form && $result_file_form['total_count'] > 0) { ?>
									<ul style="background-color:#ffffff; margin-top:10px; padding:15px; border:1px solid #EEEEEE; background-color:#f7f7f7; list-style:none;">
									  <?php foreach($result_file_form['qry'] as $i => $o) { ?>
									  <li class="file_form_<?php echo $i ?>" style="position:relative; line-height:170%; font-size:15px;">
										<?php echo $o->file_name_org ?> (<?php echo number_format($o->file_size) ?> KB)
										<img src="<?php echo IMG_DIR ?>/common/icon_btn_del.gif" style="cursor:pointer;" alt="삭제" title="삭제" onclick="delete_file_manager(<?php echo $o->idx ?>,'file_form_<?php echo $i ?>','<?php echo $o->file_type ?>','<?php echo $o->file_dir ?>','<?php echo $o->file_name ?>')" />
									  </li>
									  <?php } ?>
									</ul>
									<?php } ?>

								<?php } ?>





								<div style="position:relative; width:100%; padding:30px 0; text-align:center; ">
									<button type="submit" name="submit" class="o_btn btn btn-black-flat mx-1">저장</button>
									<input type="hidden" name="submit" value="submit" />
									<a href="<?php echo $cancel_link?>" class="o_btn btn btn-black-flat mx-1" role="button" aria-pressed="true">취소</a>
								</div>

						<?php echo form_close(); ?>

					</section>
				</div>
			
			</div>
		</div>

	</div>
  </div>
</div>




	<script type="text/javascript">
	$(function () {
		// 사업분야
		//if('direct' == $("#ca_business").val()  &&  '' != $('#addfld_6').val()) {
		if('direct' == $("#ca_business").val()) {
			$('#addfld_6').show();
		}
		$("#ca_business").on("change", function () {
			var ca_value = $(this).val();
			if('direct' == ca_value) {
				$('#addfld_6').val('');
				$('#addfld_6').show();
			}
			else {
				$('#addfld_6').hide();
				$('#addfld_6').val(ca_value);
			}
		});

		// 단체유형
		//if('direct' == $("#ca_org").val()  &&  '' != $('#addfld_7').val()) {
		if('direct' == $("#ca_org").val()) {
			$('#addfld_7').show();
		}
		$("#ca_org").on("change", function () {
			var ca_value = $(this).val();
			if('direct' == ca_value) {
				$('#addfld_7').val('');
				$('#addfld_7').show();
			}
			else {
				$('#addfld_7').hide();
				$('#addfld_7').val(ca_value);
			}
		});
	});
	</script>





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
	// 선택 파일 삭제
	function delete_file_manager(idx,file_class,file_type,file_dir,file_name)
	{
		if( confirm('삭제하시겠습니까?') )
		{

				// 삭제하려는 사람과 등록한 사람 비교 포함.
				var request = $.ajax({
				  url: "/trans/delete_file_manager/",
				  method: "POST",
				  data: { 'idx': idx  /* , '<?php echo $this->security->get_csrf_token_name() ?>':'<?php echo $this->security->get_csrf_hash() ?>' */},
				  dataType: "html"
				});

				request.done(function( res ) {

					// 파일 삭제하고, 디비에서도 삭제하면
					// 에디터에서 삭제 및 파일 첨부 리스트에서도 삭제
					if('true' == res) {

						// 에디터에서 삭제
						if('image' == file_type) {
							//var del_attr = '/data'+ file_dir + file_name;
							//if($('img').attr('src') == del_attr) {$(this).remove();}
						}
						else {
							//var del_attr = '/data'+ file_dir + file_name;
							//if($('a').attr('href') == del_attr) {$(this).remove();}
						}
						$('.'+file_name).remove();

						// 파일 첨부 리스트에서 삭제
						$('.'+file_class).remove();
					}


				});

				request.fail(function( jqXHR, textStatus ) {
				  alert( "Request failed: " + textStatus );

				  return false;
				});
		}
	}
	</script>
