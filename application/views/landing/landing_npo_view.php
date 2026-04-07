<style>
.page_title {
	position: relative;
	margin: 0 !important;
	display: flex;
}
.page_title strong {
    font-family: 'Nanum Gothic','NanumGothic','나눔고딕','나눔 고딕', 'Noto Sans KR', AppleSDGothicNeo-Regular,'맑은 고딕','Malgun Gothic',dotum,'돋움',sans-serif;
    font-size: 28px;
    font-weight: 800;
    font-stretch: normal;
    font-style: normal;
    line-height: 1;
    letter-spacing: normal;
    text-align: left;
    color: #353535;
}

.page_title .plink {
	position: absolute; 
	right: 0;
	bottom: 0;

	font-size: 20px;
	color: #535353;
}

.input_border_css1 {
  border-top: none;
  border-left: none;
  border-right: none;
}
.btn_blue_white button { border:1px solid #0091d9; background-color: #ffffff; color: #0091d9; padding: 0 20px; line-height: 36px; font-size: 14px; } 

/** - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
 * 신청 폼 CSS 디자인
*/

/* [1] mobile 우선 */
.rsp_frm {border-top:1px solid #888;}
.rsp_frm .fld_wrap {display: block; }
.rsp_frm dl { margin: 0; padding:0; width: 100%; border-bottom:1px solid #e4e5e7;}
.rsp_frm dl dt, .rsp_frm dl dd { margin:0; text-align:left;vertical-align:middle; }
.rsp_frm dl dt { line-height:30px; padding:5px 10px; border-bottom:1px dashed #d3d5d8; display: flex; align-items: center; background-color: #f8f8f8; white-space: nowrap; text-overflow: ellipsis; font-weight:600; }
.rsp_frm dl dd { min-height:50px; padding:0 0 5px 0;  }
.rsp_frm dl dd input[type=text] { min-height: 50px; padding: 0 10px; } 
.rsp_frm dl dd em {color:#7d7d7d;}
.rsp_frm dl dd label {margin-right:7px; height: 100%;}


/* [2] pc 대응 */
@media screen and (min-width: 992px) {
	.rsp_frm {border-top:1px solid #888;}
	.rsp_frm .fld_wrap {display: block; }
	.rsp_frm dl { margin: 0; padding:0; display: flex; width: 100%; border-bottom:1px solid #e4e5e7;}
	.rsp_frm dl dt, .rsp_frm dl dd { display: inline-block; margin:0; min-height:50px;  padding:5px 10px; text-align:left;vertical-align:middle; }
	.rsp_frm dl dt { width: 25%; line-height:50px; border-bottom: none; /* display: flex; align-items: center; */ background-color: #f8f8f8; /* white-space: nowrap; text-overflow: ellipsis; */ font-weight:600; }
	.rsp_frm dl dd { width: 75%; }
	.rsp_frm dl dd input[type=text] { min-height: 50px; } 
	.rsp_frm dl dd em {color:#7d7d7d;}
	.rsp_frm dl dd label {margin-right:7px; height: 100%;}
}


.file_guide_text { top: 0; font-size: 14px; font-weight: normal; }
@media screen and (min-width: 992px) {
	.file_guide_text { top: -25px; font-size: 14px; font-weight: normal; }
}
</style>


<div class="py_35">

	<div class="ctnt_wrap">
		<div class="redactor-styles" style="width: 100%; padding: 16px 15px;">
			<h3 class="page_title">
				<strong><?php echo $row->title; ?></strong>
				<a class="plink  d-block d-sm-none" href="<?php echo base_url('landing_npo/guide');?>">협약 안내</a>
			</h3>
		</div>
	</div>
	<hr style="margin-top: 0;" />

	<div class="ctnt_wrap">
		<div class="redactor-styles" style="width: 100%; padding: 16px 15px;">

				<?php echo $row->content_top; ?>
				<!-- <hr /> -->

				<?php echo form_open_multipart($this->uri->uri_string(), array('id'=>'form','name'=>'form', 'onsubmit'=>'return frmchk();')); ?>
					<input type="hidden" name="submit_code" value="<?php echo $code ?>" />

					<input type="text" name="website" autocomplete="off" style="display:none">
					<input type="hidden" name="form_started_at" value="<?= time() ?>">

					<?php //echo validation_errors('<div class="err_color_red mb-1">', '</div>'); ?>

					<div class="rsp_frm">

					  <?php
						foreach($arr_fld_nm as $i => $o) {
						  $no = $i + 1;
						  if(trim($arr_fld_nm[$i]) == '') {
							continue;
						  }
					  ?>

						<div class="fld_wrap">
						  <dl>
							<dt><?php echo nl2br($arr_fld_nm[$i]); ?></dt>
							<dd>
								<?php if($arr_fld_type[$i] == 'textarea') { ?>
								<textarea id="txtfld_<?php echo $no ?>" class="o_input input_border_css1 fldchk" name="txtfld_<?php echo $no ?>" data-fldnm='<?php echo $arr_fld_nm[$i] ?>' style="width: 100%; height: 150px;" placeholder="<?php echo $arr_fld_desc[$i] ?>"><?php echo set_value('txtfld_'.$no) ?></textarea>
								<?php } else { ?>
								<input type="text" id="txtfld_<?php echo $no ?>" class="o_input w_100 input_border_css1 fldchk" name="txtfld_<?php echo $no ?>" value="<?php echo set_value('txtfld_'.$no) ?>"  data-fldnm='<?php echo $arr_fld_nm[$i] ?>'  style="width: 100%; " autocomplete="off" placeholder="<?php echo $arr_fld_desc[$i] ?>" />
								<?php } ?>
								<?php echo form_error('txtfld_'.$no,'<div class="err_color_red">','</div>'); ?>
							</dd>
						  </dl>
						</div>

					  <?php 
						}
					  ?>

						<div class="fld_wrap">
						  <dl>
							<dt>개인정보 수집 및 이용 동의</dt>
							<dd>
								<div class="p-2"><?php echo $row->agree_term; ?></div>
								<div class="px-2">
									<label for="agree">
										<input id="agree" type="checkbox" name="agree" value="agree" /> 개인정보의 수집 및 이용에 동의합니다. 
										<?php echo form_error('agree','<div class="err_color_red">','</div>'); ?>
									</label>
								</div>
							</dd>
						  </dl>
						</div>




					  <input type="hidden" id="file_cnt" name="file_cnt" value="<?php echo $row->file_cnt ?>" />
					  <?php
						foreach($arr_file_ttl as $i => $o) {
						  $no = $i + 1;
						  if(trim($arr_file_ttl[$i]) == '' && $row->file_cnt < $no) {
							continue;
						  }
					  ?>
						<div class="fld_wrap">
						  <dl>
							<dt>
								파일 첨부 <?php echo $no ?> &nbsp; 
								<div class="file_guide_text">(<?php echo $arr_file_ttl[$i] ?>)</div>
							</dt>
							<dd>
								<!-- <input type="file" name="attach_file_<?php echo $no ?>" class="o_input" style="width:100%; padding:0; border:none;" /> -->
								<?php //echo form_error('attach_file_'.$no,'<div class="err_color_red">','</div>'); ?>

								<input type="file" name="attach_file[]" class="o_input" style="width:100%; padding:0; border:none;" />
								<?php echo form_error('attach_file[]','<div class="err_color_red">','</div>'); ?>
								<div style="font-size: 14px; font-weight: normal; margin-top: 5px;">(<?php echo nl2br($arr_file_desc[$i]); ?>)</div>

							</dd>
						  </dl>
						</div>
					  <?php 
						}
					  ?>





					</div>

					<div class="buttonBox" style="width:100%; margin:50px auto 30px; text-align:center;">
						<button type="submit" name="submit" id="btn_submit" class="btn btn-dark btn-md" style="margin:0 auto;"/>확인</button>
					</div>


				<?php echo form_close(); ?>

				<!-- <hr /> -->

				<?php echo $row->content_bottom; ?>

		</div>
	</div>
</div>


<script type="text/javascript">
  function frmchk() {

	let file_cnt = $('#file_cnt').val();
	let msg = '<?php echo $row->title; ?> 접수를 하시겠습니까?';

	if(file_cnt > 0) {
		msg +='\n\n';
		msg +=' * 파일 첨부 항목이 있습니다. \n * 업로드 할 파일을 등록하셨다면 확인 버튼을 눌러 접수를 진행해주세요.';
		msg +='\n';
	}

	if( confirm(msg) ) {
		return true;
	}
	else {
		return false;
	}
  }
</script>

<script type="text/javascript">
$(function(){

	$('.fldchk').on('keyup',function(event) {

		const arr_chkName = ['이름','성명','담당자','담당자명','신청자','신청자명'];
		const arr_chkPhone = ['연락처','전화번호','휴대전화'];
		//const arr_chkEmail = ['이메일','email','e-mail','Email'];

		let fldnm = $(this).data('fldnm');
		let fldVal = $(this).val();

		//console.log( fldVal );

		// 이름 체크
		if( arr_chkName.includes(fldnm) ) {

			// 한글이 아니면 지우기
			$(this).val( fldVal.replace(/[a-z0-9]|[ \[\]{}()<>?|`~!@#$%^&*-_+=,.;:\"\\]/g,"") );

		}

		// 연락처 체크
		if( arr_chkPhone.includes(fldnm) ) {

			//$(this).val( fldVal.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1') );

			$(this).attr('maxlength',13);

			var autoHypenPhone = function(str){
				  str = str.replace(/[^0-9]/g, '');
				  var tmp = '';
				  if( str.length < 4){
					  return str;
				  }else if(str.length < 7){
					  tmp += str.substr(0, 3);
					  tmp += '-';
					  tmp += str.substr(3);
					  return tmp;
				  }else if(str.length < 11){
					  tmp += str.substr(0, 3);
					  tmp += '-';
					  tmp += str.substr(3, 3);
					  tmp += '-';
					  tmp += str.substr(6);
					  return tmp;
				  }else{              
					  tmp += str.substr(0, 3);
					  tmp += '-';
					  tmp += str.substr(3, 4);
					  tmp += '-';
					  tmp += str.substr(7);
					  return tmp;
				  }
			  
				  return str;
			}

			$(this).val( autoHypenPhone( fldVal ) );  
		}

		// 이메일 체크
		/*
		if( arr_chkEmail.includes(fldnm) ) {

			function email_check( email ) {
				
				var regex=/([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
				return (email != '' && email != 'undefined' && regex.test(email));
			}

			if(! email_check(fldVal)) {
				alert('이메일을 형식에 맞게 입력해주세요.');
			}
		}
		*/

	});




	// [이메일 체크] - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	$('.fldchk').on('blur',function(event) {

		let fldnm = $(this).data('fldnm');
		let fldVal = $(this).val();
		//console.log( fldVal );
		//console.log( fldnm );

		// [이메일 체크] - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		const arr_chkEmail = ['이메일','email','e-mail','Email'];
		if( arr_chkEmail.includes(fldnm) ) {
			function email_check( email ) {
				
				var regex=/([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
				return (email != '' && email != 'undefined' && regex.test(email));
			}
			if(! email_check(fldVal)) {
				alert('이메일을 형식에 맞게 입력해주세요.');
				$(this).val('');
			}
		}


	});










	$('.fldchk').on('keyup',function(event) {

		let fldnm = $(this).data('fldnm');
		let fldVal = $(this).val();
		//console.log( fldVal );

		let fldId = $(this).attr('id');

		// [기관명 검색] - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		const arr_chkNpo = ['기관명','단체명'];
		if( arr_chkNpo.includes(fldnm) && '' != fldVal) {

			// ajax 
			var request = $.ajax({
			  url: "/trans/call_npo_name",
			  method: "POST",
			  data: { 'stx':fldVal},
			  dataType: "json"
			});

			request.done(function( res ) {
			  // 	var arr_cms = <?php //echo json_encode($cms_result) ?>;

			  //console.log(res);
			  //console.log(res['npo_name']);
			  //$('#'+wrap_cate_id).html(res);
			   

			  // console.log(res[0]['npo_name']);

			  let npo_len = res.length;
			  /*
			  for(let i=0; i<npo_len; i++) {
				console.log( res[i].npo_name );
			  }
			  */

				let html = '';
			  
				html += '<div id="npo_list_box" class="dropdown" style="position:absolute; top:0; left:0; width: 100%; height:auto; max-height: 500px;  background-color: #ffffff;">';
				//html += '  <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">';
				//html += '	'+fldVal;
				//html += '  </button>';
				html += '  <ul class="dropdown-menu show" style="margin:0; height:auto; max-height: 400px; overflow-y:auto; border-radius:0;">';

				for(let i=0; i<npo_len; i++) {
					//console.log( res[i].npo_name );
					html += '	<li><a class="dropdown-item ellipsis" href="#" onclick="get_npo_data('+res[i].idx+'); return false;" style="width: 280px; font-size: 12px; padding-right: 20px;">'+res[i].npo_name+'</a></li>';
				}
				html += '  </ul>';
				html += '</div>';

				//console.log(html);


				//if( $('#'+fldId+'_dropdown') ) {
				if( document.getElementById(fldId+'_dropdown') ) {
					$('#'+fldId+'_dropdown').html(html);
				}
				else {
					$('#'+fldId).after('<div id="'+fldId+'_dropdown"></div>');
				}

				
				/*
				*/

			});

			request.fail(function( jqXHR, textStatus ) {
			  alert( "Request failed: " + textStatus );
			  return false;
			});
		}
	});

});
</script>



<script type="text/javascript">
	// 클릭한 기관의 정보 가져오기
	function get_npo_data(idx) {

			console.log(idx);

			// ajax 
			var request = $.ajax({
			  url: "/trans/call_npo_info",
			  method: "POST",
			  data: { 'idx':idx},
			  dataType: "json"
			});

			request.done(function( data ) {
			  // 	var arr_cms = <?php //echo json_encode($cms_result) ?>;

			  console.log(data);
			  //console.log(res['npo_name']);
			  //$('#'+wrap_cate_id).html(res);

			  $('#npo_list_box').css('display','none');

			  // 기관명
			  $('#txtfld_1').val(data.npo_name);

			  // 담당자명
			  $('#txtfld_2').val(data.npo_ceo);

			  // 연락처
			  $('#txtfld_3').val(data.npo_tel);

			  // 기관소개
			  let npo_data = '';
			  npo_data += '[소재지]\n';
			  npo_data += data.npo_addr+'\n';
			  npo_data += '[주된사업]\n';
			  npo_data += data.npo_business+'\n';
			  npo_data += '[비고]\n';
			  npo_data += data.npo_memo+'\n';

			  $('#txtfld_6').val(npo_data);

			});

			request.fail(function( jqXHR, textStatus ) {
			  alert( "Request failed: " + textStatus );
			  return false;
			});
	}

</script>


<script type="text/javascript">

  /*
  function fld_chk() {

	$('.fldchk').each(function(index, item) {

		const arr_chkName = ['이름','성명','담당자','담당자명','신청자','신청자명'];
		const arr_chkPhone = ['연락처','전화번호','휴대전화'];
		const arr_chkEmail = ['이메일','email','e-mail','Email'];

		let fldnm = $(item).data('fldnm');
		let fldVal = $(item).val();

		// 이름 체크
		if( arr_chkName.includes(fldnm) ) {

			const regex = /^[ㄱ-ㅎ|가-힣]+$/;
			if(regex.test(fldVal)) {
				// 한글이면
				return true;
			}
			else {
				// 한글이 아니면
				alert(fldnm+'에 한글만 입력해주세요.');
				$(item).focus();
				return false;
			}

		}

		// 연락처 체크
		if( arr_chkPhone.includes(fldnm) ) {

			//전화번호 정규식표현식
			const telRegex1 = /\d{3}-\d{4}-\d{4}/; 
			//(\d는 숫자를 의미하고, {} 숫자갯수를 의미합니다.)
			if(telRegex1.test(fldVal)) {
				// 유효한 전화번호
				return true;
			}
			else {
				// 유효하지 않은 전화번호
				alert('유효하지 않는 전화번호입니다');
				$(item).focus();
				return false;
			}

			//휴대폰 정규식표현식
			const telRegex2 = /^01([0|1|6|7|8|9])-?([0-9]{3,4})-?([0-9]{4})$/;
			if(telRegex2.test(fldVal)) {
				// 유효한 전화번호
				return true;
			}
			else {
				// 유효하지 않은 전화번호
				alert('유효하지 않는 휴대전화번호입니다');
				$(item).focus();
				return false;
			}
		}

		// 이메일 체크
		if( arr_chkEmail.includes(fldnm) ) {

			//이메일 정규식표현식
			const emailRegex = /^[0-9a-zA-Z]([-_\.]?[0-9a-zA-Z])*@[0-9a-zA-Z]([-_\.]?[0-9a-zA-Z])*\.[a-zA-Z]{2,3}$/;
			if(emailRegex.test(fldVal)) {
				// 유효한 이메일
				return true;
			}
			else {
				// 유효하지 않은 이메일
				alert('유효하지 않는 이메일 주소입니다');
				$(item).focus();
				return false;
			}

		}

	});

  }
  */


  /*
  function frmchk() {

	// 이름, 연락처, 이메일 유효성 검사
	if(! fld_chk() ) {
		return false;
	}
	else if( confirm('<?php echo $row->title; ?> 접수를 하시겠습니까?') ) {
		return true;
	}
	else {
		return false;
	}
  }
  */
</script>

