<div class=" admin_wrap">

	<h1>배너 관리</h1>

	<h2>배너 <?php echo $last_loc ?></h2>

	<?php
	$attributes = array('id' => 'fbanner', 'name' => 'fbanner', 'class' => 'form-horizontal');
	echo form_open_multipart(current_url(),$attributes);
	?>
	<input type="hidden" name="w"     value="<?php echo $w?>" />
	<input type="hidden" id="bn_id" name="bn_id" value="<?php echo $bn_id?>" />
	<?php //echo validation_errors('<div class="err_color_red">','</div>')?>
	<fieldset>
		
		<div class="tbl_frm" style="position:relative; width:100%; ">
		<table>
			<colgroup>
			  <col width="130">
			  <col>
			</colgroup>
			<tr>
				<th>배너 코드(위치) <span style="color:red;">*</span></th>
				<td>
				  <select id="bn_category" class="o_selectbox" name="bn_category">
					<option value=''>카테고리 *</option>
					<option value='common' <?php echo (isset($bn_row['bn_category']) && $bn_row['bn_category'] == 'common') ? 'selected' : '' ?> >- 공 통 -</option>
					<option value='main' <?php echo (isset($bn_row['bn_category']) && $bn_row['bn_category'] == 'main') ? 'selected' : '' ?> >- 메 인 -</option>
					<option value='sub' <?php echo (isset($bn_row['bn_category']) && $bn_row['bn_category'] == 'sub') ? 'selected' : '' ?> >- 서 브 -</option>
					<option value='etc' <?php echo (isset($bn_row['bn_category']) && $bn_row['bn_category'] == 'etc') ? 'selected' : '' ?> >- 기 타 -</option>
				  </select>

				  <input type='text' id='bn_code' name='bn_code' value="<?php echo isset($bn_row['bn_code']) ? $bn_row['bn_code'] : '' ?>" style="width:0; height:0; position:absolute; visibility:hidden;" readonly>
				  <select id="saved_bn_code" class="o_selectbox" name="saved_bn_code" onchange="chk_bn_code_saved();">
					<option value=''>위치 코드</option>
					<?php foreach($code_result['qry'] as $code_row) { ?>
					<option value="<?php echo $code_row['bn_code'] ?>"   <?php echo (isset($bn_row['bn_code']) && $bn_row['bn_code'] == $code_row['bn_code']) ? 'selected' : '' ?> ><?php echo $code_row['bn_code'] ?></option>
					<?php } ?>
				  </select>
				  <input type="text" id="new_bn_code" class="o_input" name="new_bn_code" placeholder="새 위치 코드 입력" value="" title="새로운 위치코드가 필요한 경우에만 입력하세요." alt="새로운 위치코드가 필요한 경우에만 입력하세요." onblur="chk_bn_code_new();" onkeyup="chk_bn_code_new();">
				  <small style='display:inline; color:#7c7c7c;'>← 새로운 코드(위치)가 필요한 경우에만 입력하세요.(영문,숫자,언더바)</small>

				  <div style="margin-top:10px; font-size: 14px;">
					<dl>
						<dt>[고정 위치코드]</dt>
						<dd>
							메인페이지 상단 배너 [PC] : main_top_banner_pc<br />
							메인페이지 상단 배너 [MOBILE] : main_top_banner_mobile
						</dd>
					<dl>
				  </div>
				</td>
			</tr>
			<tr>
				<th><label for="bn_name" style="width:130px;font-weight:bold;">배너 이름(확인용) <span style="color:red;">*</span></label></th>
				<td>
					<input type="text" id="bn_name" name="bn_name" class="o_input" style="width:100%; max-width:380px;" placeholder="배너 이름을 입력하세요." value="<?php echo isset($bn_row['bn_name']) ? $bn_row['bn_name'] : ''; ?>">
					<small style='display:inline; color:#7c7c7c;'>← 동일한 배너 코드가 이미 있는 경우, 자동 입력됩니다.</small>
				</td>
			</tr>

			<tr>
				<th>사용 여부 <span style="color:red;">*</span></th>
				<td>
				  <select id="bn_use" class="o_selectbox" name="bn_use">
					<option value='0'   <?php echo (isset($bn_row['bn_use']) && $bn_row['bn_use'] === '0') ? 'selected' : '' ?> >사용 안함</option>
					<option value='1'   <?php echo (isset($bn_row['bn_use']) && $bn_row['bn_use'] === '1') ? 'selected' : '' ?> >사용함</option>
				  </select>
				</td>
			</tr>

			<tr>
				<th>배너 순서 <span style="color:red;">*</span></th>
				<td>
				  <input type="text" id="bn_rank" class="o_input" name="bn_rank" style="width:100px" placeholder="배너 순위" value="<?php echo isset($bn_row['bn_rank']) ? $bn_row['bn_rank'] : ''; ?>">
				  <small style='display:inline; color:#7c7c7c;'>← 같은 코드 내에서의 배너 우선 순위를 입력하세요</small>
				</td>
			</tr>
			<tr>
				<th>배너 크기 <span style="color:red;">*</span></th>
				<td>
				  <input type="text" id="bn_width" class="o_input" name="bn_width" style="width:100px" placeholder="가로 크기" value="<?php echo isset($bn_row['bn_width']) ? $bn_row['bn_width'] : ''; ?>"> X 
				  <input type="text" id="bn_height" class="o_input" name="bn_height" style="width:100px" placeholder="세로 크기" value="<?php echo isset($bn_row['bn_height']) ? $bn_row['bn_height'] : ''; ?>">
				  <small style='display:inline; color:#7c7c7c;'>← 이미지의 가로 X 세로 크기. (단위 px)</small>

				  <!-- <hr class='clear' style='border-bottom:1px dashed silver;' />
				  <small>
					메인 지원정보 배너 : 가로: 320px, 세로:175px<br />
					모바일 이벤트 메인 비주얼 배너 : 가로: 968px, 세로:300px<br />
				  </small> -->

				</td>
			</tr>

			<tr>
				<th>배너 이미지 주소(선택)</th>
				<td>
				  <input type="text" id="bn_image_url" class="o_input" name="bn_image_url" style="width:500px;" placeholder="배너 이미지 주소를 입력하세요." value="<?php echo isset($bn_row['bn_image_url']) ? $bn_row['bn_image_url'] : ''; ?>">
				  <div><small style='color:#7c7c7c;'>★ 업로드 배너 이미지보다 우선 적용됩니다.</small></div>
				</td>
			</tr>
			<tr>
				<th>배너 링크 주소</th>
				<td>
				  <span>
					<input type="text" id="bn_link" class="o_input" name="bn_link" style="width:500px;" placeholder="배너 링크 주소를 입력하세요." value="<?php echo isset($bn_row['bn_link']) ? $bn_row['bn_link'] : ''; ?>">
				  </span>
				  <div><small style='color:#7c7c7c;'>★ 배너를 클릭했을 때 이동하는 URL 주소입니다..</small></div>
				  <div><small style='color:#ff0000;'>http:// 또는 https:// 를 포함해서 전체 URL을 입력해주세요!</small></div>
				</td>
			</tr>
			<tr>
				<th>배너 링크 타겟</th>
				<td>
				  <select id="bn_target" class="o_selectbox" name="bn_target">
					<option value=''>배너 URL 타겟</option>
					<!-- <option value='_top'   <?php echo ($bn_row['bn_target'] == '_top') ? 'selected' : '' ?> >_top</option>
					<option value='_blank'   <?php echo ($bn_row['bn_target'] == '_blank') ? 'selected' : '' ?> >_blank</option>
					<option value='_parent'   <?php echo ($bn_row['bn_target'] == '_parent') ? 'selected' : '' ?> >_parent</option>
					<option value='_self'   <?php echo ($bn_row['bn_target'] == '_self') ? 'selected' : '' ?> >_self</option> -->
					<option value='_blank'   <?php echo (isset($bn_row['bn_target']) && $bn_row['bn_target'] == '_blank') ? 'selected' : '' ?> > → 새 창 또는 새 탭에서 열기</option>
					<option value='_self'   <?php echo (isset($bn_row['bn_target']) && $bn_row['bn_target'] == '_self') ? 'selected' : '' ?> > → 현재 페이지에서 열기</option>
				  </select>
				</td>
			</tr>

			<tr>
				<th>배너 이미지</th>
				<td>
					<input type="hidden" id="bn_type" name="bn_type" value='image' />
					<input type="file" id="bn_image" name="bn_image" />
					<input type="hidden" name="bn_image_saved" value="<?php echo isset($bn_row['bn_image']) ? $bn_row['bn_image'] : ''; ?>" />
					<?php if(isset($bn_row['bn_image']) && $bn_row['bn_image']) { ?>
					<div style="margin-top:10px; width:100%;">
						<img src="<?php echo $bn_row['bn_image_src'] ?>" class="img-responsive" alt="배너 이미지" style="width:100%; max-width:<?php echo $bn_row['bn_width'] ?>px;">
						<div>
							<label for="del_bn_image" class="del_image_chk" style="display:inline-block; margin-top:5px;"><input type='checkbox' id='del_bn_image' name='del_bn_image'> 삭제</label>
						</div>
					</div>
					<?php } ?>
				</td>
			</tr>


			<!-- <tr>
				<th>배너 시작일자</th>
				<td>
				  <input type="text" class="banner_date o_input" id="bn_sdate" name="bn_sdate" placeholder="배너 시작일자" value="<?php //echo $bn_row['bn_sdate']?>" title="클릭하시면 달력이 나옵니다.">
				  <small style='display:inline; color:#7c7c7c;'>← 클릭하시면 달력이 나옵니다. / 비워두시면 기한 없이 노출됩니다.</small>
				</td>
			</tr>
			<tr>
				<th>배너 종료일자</th>
				<td>
				  <input type="text" class="banner_date o_input" id="bn_edate" name="bn_edate" placeholder="배너 종료일자" value="<?php// echo $bn_row['bn_edate']?>" title="클릭하시면 달력이 나옵니다.">
				  <small style='display:inline; color:#7c7c7c;'>← 클릭하시면 달력이 나옵니다. / 비워두시면 기한 없이 노출됩니다.</small>
				</td>
			</tr> -->


			<tr>
				<th>관리자 메모 제목</th>
				<td>
				  <input type="text" id="bn_memo_ttl" class="o_input" name="bn_memo_ttl" placeholder="배너 제목" style="width:100%;" value="<?php echo isset($bn_row['bn_memo_ttl']) ? $bn_row['bn_memo_ttl'] : ''; ?>" />
				</td>
			</tr>
			<tr>
				<th>관리자 메모 내용</th>
				<td>
				  <textarea id="bn_memo" name="bn_memo" placeholder="배너 내용" style="width:100%; height:100px;"><?php echo isset($bn_row['bn_memo']) ? $bn_row['bn_memo'] : ''; ?></textarea>
				</td>
			</tr>
		</table>

		<div style="">

			<hr class="line" />
			<div class="text-center">
				<!-- <button type="reset" class="btn btn-sm btn-secondary"><strong>리셋</strong></button> -->
				<button type="submit" class="btn btn-sm btn-dark"><strong>저장</strong></button>
				<button type="button" class="btn btn-sm btn-dark" onclick="location.href='/admin/design/banner/lists/all/<?php echo $page_num_link?>';"><strong>목록</strong></button>
			</div>

		  </div>

	</fieldset>
	</form>

</div>


<!-- <?php /* ?>
<script type='text/javascript' src='<?php echo JS_DIR?>/md5.js'></script>
<script type='text/javascript' src='<?php echo JS_DIR?>/kcaptcha.js'></script>
<script type='text/javascript' src='<?php echo JS_DIR?>/jquery/validate.js'></script>
<script type='text/javascript' src='<?php echo JS_DIR?>/jquery/validate_ext.js'></script>
<script type='text/javascript' src='<?php echo JS_DIR?>/jquery/validate_reg.js'></script>

<script type='text/javascript' src='<?php echo JS_DIR?>/jquery/datepicker.js'></script>
<?php */ ?> -->
<script type='text/javascript' src='<?php echo LIB_DIR?>/jquery/jquery_validate.js'></script>

<link rel="stylesheet" type="text/css" href="<?php echo LIB_DIR?>/datetimepicker-master/jquery.datetimepicker.min.css" media="screen"/>
<script src="<?php echo LIB_DIR?>/datetimepicker-master/jquery.datetimepicker.full.js"></script>

<script type='text/javascript'>
//<![CDATA[
/* rules 와 messages 에는 id 값이 아니라 name 값을 지정해야 한다. */
$(function() {

	$('#fbanner').validate({
		onkeyup: false,
		rules: {
			bn_name: 'required',
			bn_category: 'required',
			bn_code: 'required'
		},
		messages: {
			bn_name: '배너 이름을 입력하세요.',
			bn_category: '배너 카테고리를 선택하세요.',
			bn_code: '배너 위치코드를 선택하거나 새로 입력하세요.'
		},
		errorPlacement: function(error, element) {
			error.appendTo(element.parent()).wrap("<div class='err_color_red'></div>");
			//console.log(error);
			err_msg = error[0]['textContent'];
			//alert(err_msg);
		},
		submitHandler: function(f) {
			f.submit();
		}
	});

	//var year = new Date().getFullYear();
	//$('.banner_date').datepicker({yearRange:(year)+':'+(year+10)});


	// datetimepicker
	$.datetimepicker.setLocale('kr');
	$('.banner_date').datetimepicker({
		lang:'kr',
		timepicker:false,
		format:'Y-m-d',
		formatDate:'Y/m/d',
		yearStart:'<?php echo date("Y") -2 ?>',
		yearEnd:'<?php echo date("Y") +5 ?>'
	});


});



function chk_bn_code_new() {
	// 콤보박스 초기화
	$("#saved_bn_code option:eq(0)").prop("selected", true);

	chk_bn_code();
}

function chk_bn_code_saved() {
	// 신규 코드 입력란 초기화
	$('#new_bn_code').val('');

	chk_bn_code();
}

// 배너 위치코드 
function chk_bn_code() {
	var bn_code = '';
	var new_bn_code = trim($('#new_bn_code').val());
	var saved_bn_code = trim($('#saved_bn_code').val());

	if(new_bn_code != '') {
		bn_code = new_bn_code;
	} else {
		bn_code = saved_bn_code;
	}
	$('#bn_code').val(bn_code);


  // 기존에 등록했던 코드라면, 배너 이름 가져오기
	var request = $.ajax({
	  url: "/trans/get_banner_info/",
	  method: "POST",
	  data: { 'bn_code' : bn_code  /* , '<?php echo $this->security->get_csrf_token_name() ?>':'<?php echo $this->security->get_csrf_hash() ?>' */},
	  dataType: "html"
	});

	request.done(function( res ) {
	  //console.log(res);
	  if('' != res) {
		$('#bn_name').val(res);
		$('#bn_name').css('background-color','#eeeeee');
	  }
	  else {
		$('#bn_name').val('');
		$('#bn_name').css('background-color','#ffffff');
	  }

	});

	request.fail(function( jqXHR, textStatus ) {
	  alert( "Request failed: " + textStatus );
	  $('#bn_name').val('');
	  $('#bn_name').css('background-color','#ffffff');
	  return false;
	});

}
//]]>
</script>