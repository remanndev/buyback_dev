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

// 제목 설정
$input_subject = array(
	'name'	=> 'wr_subject',
	'id'	=> 'wr_subject',
	//'value' => isset($row->wr_subject) ? $row->wr_subject : set_value('wr_subject'),
	'value' => set_value('wr_subject',isset($row->wr_subject) ? $row->wr_subject : ''),
	//'onblur' => "fn_mk_subject(this.value);",
	'maxlength'	=> 255,
	'class' => 'bo_input form-control ',
	'autocomplete' => 'off',
	'placeholder' => '제목을 입력해주세요.'
);

// input_wr_name
$input_wr_name = array(
	'name'	=> 'wr_name',
	'id'	=> 'wr_name',
	'value' => isset($row->wr_name) ? $row->wr_name : set_value('wr_name'),
	'maxlength'	=> 255,
	'class' => 'bo_input form-control ',
	'autocomplete' => 'off',
	'placeholder' => '이름을 입력해주세요.',
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
	'class' => 'custom-control-input',
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
	'class' => 'form-control bo_input',
	'style' => 'display:inline-block; width: 120px;',
	'autocomplete' => 'no'
);



// 예약 년도
$selected_rsv_year =  isset($row->reserve_year) ? $row->reserve_year : set_value('reserve_year');
$this_year = date('Y');
$rsv_year_options = array();
for($i=0;$i<2;$i++) {
	$rsv_year_options[($this_year+$i)] = ($this_year+$i).'년';
}
// 예약 월
$this_month = date('n');
$selected_rsv_month =  isset($row->reserve_month) ? $row->reserve_month : set_value('reserve_month',$this_month);
$rsv_month_options = array();
for($i=1;$i<13;$i++) {
	$rsv_month_options[$i] = ($i < 10) ? '0':'';
	$rsv_month_options[$i] .= $i.'월';
}
// 예약 일
$this_date = date('j');
$selected_rsv_date =  isset($row->reserve_date) ? $row->reserve_date : set_value('reserve_date',$this_date);
$rsv_date_options = array();
for($i=1;$i<32;$i++) {
	$rsv_date_options[$i] = ($i < 10) ? '0':'';
	$rsv_date_options[$i] .= $i.'일';
}

// 예약 시간
$this_time = date('G');
$next_time = $this_time+1;

$this_timestr = ($this_time < 10) ? '0'.$this_time:$this_time;
$this_timestr .= ':00~';
$this_timestr .= ($next_time < 10) ? '0'.$next_time:$next_time;
$this_timestr .= ':00';

$selected_rsv_time =  isset($row->reserve_time) ? $row->reserve_time : set_value('reserve_time',$this_timestr);
$rsv_time_options = array();
for($i=10;$i<19;$i++) {
	$timestr = $i.':00~'.($i+1).':00';
	$rsv_time_options[$timestr] = $timestr;
}

/*
동의		agree
이름		wr_name
휴대전화	wr_mobile
이메일	wr_email
우편번호	addfld_1
주소1		addfld_2
주소2		addfld_3
토지지번	addfld_4
토지면적	addfld_5

*/

//print_r($row);
?>

<style>
	/*
	input[type=text] {    height: calc(1.5em + .72rem + 1.8px);     font-weight: 400;    line-height: 1.5; font-size: 14px;color: #495057;border: 1px solid #ced4da;padding:.375rem .75rem;}
	*/

	label.frm-title {margin:0; border:1px dashed #dddddd; padding:0 15px; width:100%; line-height:36px;}
	.frm-desc {border:0px dashed #dddddd; line-height:36px;}
</style>



<?php if( isset($this->arr_seg[1]) && $this->arr_seg[1] != 'admin' ) { ?>
<div>
	<?php echo $bbs_cf->bo_head; ?>
</div>
<?php } ?>

<div class="contents_wrap">
  <div class="bbs_basic">

	<!-- 캠페인 상세 -->
	<div style="margin:0 auto; ">

		<!-- 페이지 내용 -->
		<div class="o_page_content">
			<section class="o_ctnt" >

				<h3 class="bo_title"><?php echo isset($bbs_cf->bo_title) ? $bbs_cf->bo_title : '게시판'; ?></h3>


				<div class="" style="border-top: 2px solid rgba(51,51,51,1);">
					<br />



							<?php echo form_open_multipart($this->uri->uri_string(), array('id'=>'board_form','name'=>'board_form','onsubmit'=>'frm_submit();')); ?>

								<?php echo validation_errors('<div class="err_color_red">', '</div>'); ?>

								<!-- 입력폼 -->
								<div>	
									<div class="vlt-widget--top-line5"></div>

									<?php
									if( $this->tank_auth->is_admin() ) { ?>
									<div class="row">
										<div class="col-md-2 col-3 col-form-label d-none d-md-block py-0"><label class="frm-title">공지선택</label></div>
										<div class="col-md-10 col-8 frm-desc">
										  <div class="custom-control custom-checkbox">
											<?php echo form_checkbox($input_option_notice) ?>
											<label class="custom-control-label" for="opt_notice">공지</label>
										  </div>
										</div>
									</div>
									<div class="line_gap_10"></div>
									<?php } ?>

									<?php if($bbs_cf->bo_use_category &&  trim($bbs_cf->bo_category) !== '' ) { ?>
									<div class="row">
										<div class="col-md-2 col-form-label d-none d-md-block py-0"><label class="frm-title">카테고리</label></div>
										<div class="col-md-10 frm-desc">
											<?php echo form_dropdown('ca_code', $ca_code_options, $selected_ca_code, 'class="form-control o_selectbox" style="width:100%; height:40px; font-size:14px; vertical-align:middle; background-color:#f7f7f7;"'); ?>
											<?php echo form_error('ca_code','<div class="err_color_red">','</div>'); ?>
										</div>
									</div>
									<div class="line_gap_10"></div>
									<?php } ?>


									<div class="row">
										<div class="col-md-2 col-form-label d-none d-md-block py-0"><label class="frm-title">제목</label></div>
										<div class="col-md-10">
											<?php echo form_input($input_subject); ?>
											<?php echo form_error('wr_subject','<div class="err_color_red">','</div>'); ?>
										</div>
									</div>
									<div class="line_gap_10"></div>

									<?php 
										//echo $bbs_cf->bo_writer_type
										// name, id, none
									?>

									<?php if(! $this->tank_auth->is_logged_in()){ ?>
									<div class="row">
										<div class="col-md-2 col-form-label d-none d-md-block py-0"><label class="frm-title">이름</label></div>
										<div class="col-md-10">
											<?php echo form_input($input_wr_name); ?>
											<?php echo form_error('wr_name','<div class="err_color_red">','</div>'); ?>
										</div>
									</div>
									<div class="line_gap_10"></div>
									<?php } ?>


									<!-- 비밀글 사용 -->
									<?php if( $bbs_cf->bo_use_secret > 0 ) { ?>


									<div class="row">
										<div class="col-md-2 col-form-label d-none d-md-block py-0"><label class="frm-title">비밀번호</label></div>
										<div class="col-md-10">
											<input type="password" name="wr_password" placeholder="글수정과 열람을 위해 비밀번호는 필수입니다." class="form-control bo_input_password" value="<?php echo set_value('wr_password',isset($user->wr_password) ? $user->wr_password : '') ?>" placeholder="" />
											<?php echo form_error('wr_password','<div class="error">','</div>'); ?>
											<!-- <small>글수정과 열람을 위해 비밀번호는 필수입니다.</small> -->
										</div>
									</div>
									<div class="line_gap_10"></div>


										<?php
										if($bbs_cf->bo_use_secret === '0' ) {
											// 비밀글 사용 안함
										} elseif($bbs_cf->bo_use_secret === '3' ) {
											// 무조건 비밀글
											echo form_hidden('opt_secret', '1');
										} else {
											//echo '<label for="opt_secret">'. form_checkbox($input_option_secret) .' 자동 비공개</label> &nbsp;';
											//echo form_checkbox($input_option_secret) .' <label class="checkbox mb-0" for="opt_secret">자동 비공개</label>';
									?>
									<div class="row">
										<div class="col-md-2 col-form-label d-none d-md-block py-0"><label class="frm-title">비공개</label></div>
										<div class="col-md-10">
											<?php echo form_checkbox($input_option_secret) .' <label class="checkbox mb-0" style="line-height:36px;" for="opt_secret">자동 비공개</label>'; ?>
										</div>
									</div>
									<div class="line_gap_10"></div>
									<?php
										}
									}
									?>




									<div class="row">
										<div class="col-md-2 col-form-label d-none d-md-block py-0"><label class="frm-title">내용</label></div>
										<div class="col-md-10">
											<textarea id="wr_content" class="form-control" name="wr_content" placeholder="내용을 입력해주세요."><?php echo isset($row->wr_content) ? $row->wr_content : set_value('wr_content',$bbs_cf->bo_init_content) ?></textarea>
											<?php echo form_error('wr_content','<div class="err_color_red">','</div>'); ?>

											<?php
											// 업데이트 할 때만 노출
											if('update' == $mode && $result_file_editor) { ?>

											<hr />

											<div class="page-header-sub mt-2" style="position:relative; padding:0;">
												<h3 style="display:inline-block; margin:0 15px 0 0; font-size:15px; font-weight:bold;">에디터 파일 관리<small></small></h3>
												<div class="notice_info_red" style="display:inline-block; font-size:13px; ">에디터에서 업로드한 파일은 글 저장 이후에 확인하실 수 있습니다.</div>
											</div>
											
											<div id="uploaded_file" style="position:relative; margin:2px 0; width:100%;  border:1px solid #cccccc; background-color:#fafafa;">
											  <div style="padding:5px; height:auto; overflow:hidden;">

												<div id="uploaded_thumb" style="position:relative; width:26.5%; max-width:155px; display:inline-block;">
												<?php
													$thumb_image = '<img id="preview_file" src="'. IMG_DIR .'/common/pn_preview.gif" alt="..." class="img-thumbnail" style="width:100%;">';
													echo $thumb_image;
												?>
												</div>
												
												<div style="float:right; width:100%; min-width:73%; max-width:calc(100% - 155px); height:100%; padding:0;">
												  <ul style="background-color:#ffffff; margin:0 0 0 5px;  padding-left:10px; height:118px; border:1px solid #EEEEEE; overflow-y:auto;  ">
												  <?php if($result_file_editor) { ?>
													  <?php foreach($result_file_editor['qry'] as $i => $o) { ?>
														<li class="file_editor_<?php echo $i ?>" style="font-size:11px; position:relative; line-height:200%; list-style:none;">
															<?php echo $o->file_name_org ?> (<?php echo number_format($o->file_size) ?> KB)

															<img src="<?php echo IMG_DIR ?>/common/icon_btn_upload.gif" style="cursor:pointer; vertical-align:middle;" alt="업로드" title="업로드" onclick="file_insert_to_content('<?php echo $o->file_dir ?>','<?php echo $o->file_name ?>','<?php echo $o->file_name_org ?>','<?php echo $o->file_type ?>','<?php echo $o->img_width ?>','<?php echo $bbs_cf->bo_image_width ?>')" />
															<img src="<?php echo IMG_DIR ?>/common/icon_btn_del.gif" style="cursor:pointer; vertical-align:middle;" alt="삭제" title="삭제" onclick="delete_file_manager(<?php echo $o->idx ?>,'file_editor_<?php echo $i ?>','<?php echo $o->file_type ?>','<?php echo $o->file_dir ?>','<?php echo $o->file_name ?>')" />

														</li>
													  <?php } ?>
												  <?php } ?>
												  </ul>
												</div>
												
												<hr style="clear:both; margin:0; padding:0; width:0; height:0;" />

											  </div>
											</div>
											<?php } ?>

										</div>
									</div>
									<div class="line_gap_10"></div>




									<!-- 업로드 -->
									<?php if( $bbs_cf->bo_use_upload > 0 ) { ?>

									<div class="row">
										<div class="col-md-2 col-form-label d-none d-md-block py-0"><label class="frm-title">대표이미지</label></div>
										<div class="col-md-10" style="padding-bottom: 5px;">
											<div style="font-size: 12px;padding-top:5px "><input type="file" name="attach_file_form[]" class="custom-file2-input" /></div>

											<?php if($result_file_form && $result_file_form['total_count'] > 0) { ?>
											<ul style="background-color:#ffffff; margin-top:5px; padding:15px; border:1px solid #EEEEEE; list-style:none;">
											<?php
											  $o = $result_file_form['qry'][0];
											?>
											  <li class="file_form_0" style="position:relative; line-height:170%; font-size:15px;">

												<div>
													<?php echo $o->file_name_org ?> (<?php echo number_format($o->file_size) ?> KB)
													<img src="<?php echo IMG_DIR ?>/common/icon_btn_del.gif" style="cursor:pointer;" alt="삭제" title="삭제" onclick="delete_file_manager(<?php echo $o->idx ?>,'file_form_0','<?php echo $o->file_type ?>','<?php echo $o->file_dir ?>','<?php echo $o->file_name ?>')" />
												</div>

												<?php if('image' == $o->file_type) { ?>
												<!-- <hr style="border-style:dashed;" /> -->
												<img src="<?php echo DATA_DIR ?>/<?php echo $o->file_dir ?>/<?php echo $o->file_name ?>" style="width:auto; max-width:100%;" />
												<?php } ?>

											  </li>
											</ul>
											<?php } ?>

										</div>
									</div>

									<?php
									$fno_limit = $bbs_cf->bo_upload_cnt;
									if($fno_limit > 1) {
									?>
									<div class="line_gap_10"></div>

									<div class="row">
										<div class="col-md-2 col-form-label d-none d-md-block py-0"><label class="frm-title">첨부파일</label></div>
										<div class="col-md-10" style="padding-bottom: 5px;">

											<?php
											for($fno=1;$fno<$fno_limit;$fno++) {
											?>
											  <div style="font-size: 12px;padding-top:5px "><input type="file" name="attach_file_form[]" class="custom-file2-input" style="width:100%;" /></div>
											<?php } ?>

											<?php if($result_file_form && $result_file_form['total_count'] > 1) { ?>
											<ul style="background-color:#ffffff; margin-top:5px; padding:15px; border:1px solid #EEEEEE; list-style:none;">
											  <?php
											  foreach($result_file_form['qry'] as $i => $o) {
												if($i == 0) continue;
											  ?>
											  <li class="file_form_<?php echo $i ?>" style="position:relative; line-height:170%; font-size:15px;">

												<?php if($i > 0) { ?>
												<hr style="border-style:dashed;" />
												<?php } ?>

												<div>
													<?php echo $o->file_name_org ?> (<?php echo number_format($o->file_size) ?> KB)
													<img src="<?php echo IMG_DIR ?>/common/icon_btn_del.gif" style="cursor:pointer;" alt="삭제" title="삭제" onclick="delete_file_manager(<?php echo $o->idx ?>,'file_form_<?php echo $i ?>','<?php echo $o->file_type ?>','<?php echo $o->file_dir ?>','<?php echo $o->file_name ?>')" />
												</div>

												<?php if('image' == $o->file_type) { ?>
												<!-- <hr style="border-style:dashed;" /> -->
												<img src="<?php echo DATA_DIR ?>/<?php echo $o->file_dir ?>/<?php echo $o->file_name ?>" style="width:auto; max-width:100%;" />
												<?php } ?>

											  </li>
											  <?php } ?>
											</ul>
											<?php } ?>

										</div>
									</div>

									<?php } ?>
									<?php } ?>
									





									<?php if(! $this->tank_auth->is_logged_in()) { ?>

									<div class="line_gap_10"></div>

									<div class="row">
										<div class="col-md-2 col-form-label d-none d-md-block py-0"><label class="frm-title">스팸방지</label></div>
										<div class="col-md-10">
											<!-- <div class="vlt-gap-10"></div>
											<p class="fz-14">아래의 코드를 정확하게 입력해주세요.</p>
											<div class="vlt-gap-10"></div> -->
											<?php if ($show_captcha) { ?>
											<div>
												<?php if ($use_recaptcha) { ?>
														<h6 style="font-size:13px; margin:5px 0;">아래의 코드를 정확하게  입력해주세요.</h6>
														<input type="text" id="recaptcha_response_field" name="recaptcha_response_field" />
														<?php //echo form_error('recaptcha_response_field'); ?>
														<?php echo form_error('recaptcha_response_field','<div class="err_color_red">','</div>'); ?>
														<div style="margin-top:5px; padding:10px 5px; border:1px solid #eee;">
														  <div id="recaptcha_image"></div>
														</div>
														<a href="javascript:Recaptcha.reload()">Get another CAPTCHA</a>
														<div class="recaptcha_only_if_image"><a href="javascript:Recaptcha.switch_type('audio')">Get an audio CAPTCHA</a></div>
														<div class="recaptcha_only_if_audio"><a href="javascript:Recaptcha.switch_type('image')">Get an image CAPTCHA</a></div>
														<div style="margin:5px 0;"><?php echo $recaptcha_html; ?></div>
												<?php } else { ?>
														<div>
															<div id="btn_code_renew" style="display:inline-block;" title="클릭하면 새로운 코드가 생성됩니다.">
																<span id="layer_captcha_html" class="gray_scale"><?php echo $captcha_html; ?></span>
															</div>
															<div style="display:inline-block; "><?php echo form_input($captcha); ?></div>
														</div>
														<?php echo form_error($captcha['name'],'<div class="err_color_red">','</div>'); ?>
												<?php } ?>
											</div>
											<?php } ?>
										</div>
									</div>
									<?php } ?>



									<div class="row text-right" style="margin-top:20px;">
										<div class="col-md-12">
											<input type="submit" name="submit" value="등록" class="btn btn-dark btn-sm" />
											<a href="<?php echo $bbs_code_url ?>/lists/page/<?php echo $page ?>"><span class="btn btn-dark btn-sm">목록</span></a>
										</div>
									</div>
									<div class="line_gap_30"></div>		
								</div>

							<?php echo form_close(); ?>






				</div>
			</section>
		</div>	
	</div>

  </div>
</div>


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



<script type="text/javascript">
	$R('#wr_content', { 
		focus: true,
		//toolbarExternal: '#my-external-toolbar',
		lang: 'ko',
		minHeight: '500px',
		maxHeight: '1000px',
		plugins: ['fontsize','fontcolor','filemanager','video','table','alignment','inlinestyle','specialchars','textdirection','widget','fontfamily','fullscreen'],
		imageUpload: "/files/upload/redactor_image/<?php echo url_code('board/'. $bo_code .'/image','e') ?>/<?php echo $bo_code ?>/<?php echo $wr_idx ?>",
		imagePosition: true,
		fileUpload: "/files/upload/redactor_file/<?php echo url_code('board/'. $bo_code .'/files','e') ?>/<?php echo $bo_code ?>/<?php echo $wr_idx ?>",
		buttonsAddAfter: {
			after: 'deleted',
			buttons: ['underline','line', 'redo', 'undo', 'underline', 'ol', 'ul', 'sup', 'sub']
		},
		buttonsHide: ['lists']

	});
</script>

<script type="text/javascript">
// 파일을 본문 안에 추가
function file_insert_to_content(file_dir,file_name,file_name_org,file_type,img_width,limit_width)
{
	if('image' == file_type){
		var img_w = img_width+'px';
		if(Number(img_width) > Number(limit_width)) {
			img_w = limit_width +'px';
		}
		var add_tag = '<p><img class="'+file_name+'" src="/data/'+ file_dir + '/' + file_name +'" alt="" width="'+img_w+'"></p>';
	}
	else {
		var add_tag = '<p><a class="'+file_name+'" href="/data/'+ file_dir + '/' + file_name +'">'+file_name_org+'</a></p>';
	}

	// insert
	$R('#wr_content', 'insertion.insertHtml', add_tag);
}

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



<script type="text/javascript">
	$(document).ready(function(){
		$("#btn_code_renew").click(function(){
			renew_cap();
		});

		function renew_cap() {
			$.ajax({
				url: "/auth/renew_captcha", 
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