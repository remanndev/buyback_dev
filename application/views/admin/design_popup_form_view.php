<div class=" admin_wrap">

	<h1>팝업 관리</h1>

	<h2>팝업 <?php echo isset($last_loc) ? $last_loc : '등록'; ?></h2>

	<?php
	$attributes = array('id' => 'fpopup', 'name' => 'fpopup', 'class' => 'form-horizontal');
	echo form_open_multipart(current_url(),$attributes);
	?>
	<input type="hidden" name="w"    value="<?php echo $w?>" />
	<input type="hidden" name="pu_id" value="<?php echo $id?>" />

	<?php //echo validation_errors('<div class="err_color_red">','</div>')?>

	  <div class="tbl_frm" style="position:relative; width:100%; ">
		<table>
			<colgroup>
			  <col width="130">
			  <col>
			</colgroup>

			<tr>
				<th><label for="pu_name">팝업 제목</label></th>
				<td>
					<input type="text" id="pu_name" name="pu_name" class="o_input" maxlength="200" style="width:100%;" value="<?php echo set_value('pu_name', (isset($pu_name) ? $pu_name : '')) ; ?>" autocomplete="off" />
					<?php echo form_error('pu_name', '<div class="err_color_red">','</div>'); ?>
				</td>
			</tr>
			<tr>
				<th>팝업 사용</th>
				<td><label for="pu_use"><input type="checkbox" id="pu_use" name="pu_use" value="1" <?php echo $use_chk?>/> 사용</label></td>
			</tr>
			<tr>
				<th>팝업 형식</th>
				<td>
					<input type="radio" id="pu_type_1" name="pu_type" value="1"  <?php echo set_radio('pu_type', '1', (! isset($pu['pu_type']) OR (isset($pu['pu_type']) && '1' == $pu['pu_type'])) ? TRUE : FALSE); ?>> <label for="pu_type_1">레이어 팝업</label>
					<input type="radio" id="pu_type_0" name="pu_type" value="0"  <?php echo set_radio('pu_type', '0', (isset($pu['pu_type']) && '0' == $pu['pu_type']) ? TRUE : FALSE); ?>> <label for="pu_type_0">일반 팝업(새창)</label>
					<?php echo form_error('pu_type','<div class="err_color_red">','</div>'); ?>
				</td>
			</tr>
			<tr>
				<th>시작일시</th>
				<td>
					<input type="text" id="sdatetime" name="sdatetime" class="sdatetimepicker o_input inline-block" maxlength="19" value="<?php echo ($sdatetime === '0000-00-00 00:00:00') ? '' : $sdatetime ?>" style="width:190px; text-align:center; font-family:verdana; font-size:14px;" autocomplete="off" placeholder="시작 일자&시간" />
				</td>
			</tr>
			<tr>
				<th>종료일시</th>
				<td>
					<input type="text" id="edatetime" name="edatetime" class="edatetimepicker o_input inline-block" maxlength="19" value="<?php echo ($edatetime === '0000-00-00 00:00:00') ? '' : $edatetime ?>" autocomplete="off" style="width:190px; text-align:center; font-family:verdana; font-size:14px;" placeholder="종료 일자&시간" />
				</td>
			</tr>

			<tr>
				<th>팝업 사이즈</th>
				<td>
					가로크기 : <input type="text" id="pu_width" name="pu_width" class="o_input inline-block" style="width:50px; padding-left:5px; padding-right:5px; text-align:right; display:inline-block;" maxlength="5" value="<?php echo $width?>" autocomplete="off" /> px
					&nbsp;&nbsp;&nbsp;
					세로크기 : <input type="text" id="pu_height" name="pu_height" class="o_input inline-block" style="width:50px; padding-left:5px; padding-right:5px; text-align:right; display:inline-block;" maxlength="5" value="<?php echo $height?>" autocomplete="off" /> px
				</td>
			</tr>
			<tr>
				<th>팝업 위치</th>
				<td>
					왼쪽에서 : <input type="text" id="pu_x" name="pu_x" class="o_input inline-block" style="width:50px; padding-left:5px; padding-right:5px; text-align:right; display:inline-block;" maxlength="5" value="<?php echo $x?>" autocomplete="off" /> px
					&nbsp;&nbsp;&nbsp;
					위로부터 : <input type="text" id="pu_y" name="pu_y" class="o_input inline-block" style="width:50px; padding-left:5px; padding-right:5px; text-align:right; display:inline-block;" maxlength="5" value="<?php echo $y?>" autocomplete="off" /> px
				</td>
			</tr>

			<!-- <tr>
				<th>팝업 파일</th>
				<td>
					<input type="text" id="pu_file" name="pu_file" class="form-control" maxlength="20" value="<?php echo $file?>" />
					<small>팝업 파일이 없는 경우에만 아래의 팝업 내용으로 팝업이 만들어집니다.</small>
					<small>파일 확장자를 제외한 이름(<span style='font-weight:bolder; color:#0080ff;'>%</span>)만 입력하세요. (skin/popup/<span style='font-weight:bolder; color:#0080ff;'>%</span>.html)</small>
				</td>
			</tr> -->
			<tr>
				<th><label for="pu_content">팝업 내용</label></th>
				<td>

					<?php echo form_error('pu_content', '<div class="err_color_red">','</div>'); ?>
					<textarea id="pu_content" name="pu_content" class="form-control o_input" placeholder="팝업 내용을 작성해 주세요."><?php echo set_value('pu_content', (isset($pu_content) ? $pu_content : '')) ; ?></textarea>

					<script type="text/javascript">
					$(function(){
						$R('#pu_content', { 
							focus: true,
							//toolbarExternal: '#my-external-toolbar',
							lang: 'ko',
							minHeight: '500px',
							maxHeight: '1000px',
							plugins: ['fontsize','fontcolor','filemanager','video','table','alignment','inlinestyle','specialchars','textdirection','widget','fontfamily','fullscreen'],
							imageUpload: "/files/upload/redactor_image/<?php echo url_code('popup/image','e') ?>/popup",
							imagePosition: true,
							fileUpload: "/files/upload/redactor_file/<?php echo url_code('popup/file','e') ?>/popup",

							buttonsAddAfter: {
								after: 'deleted',
								buttons: ['underline','line', 'redo', 'undo', 'underline', 'ol', 'ul', 'sup', 'sub']
							},
							buttonsHide: ['lists']

						});
					});
					</script>

				</td>
			</tr>


		</table>

		<div class="text-center" style="margin:20px 0;">
			<button type="submit" class="btn btn-sm btn-dark">확인</button>
			<button type="button" class="btn btn-sm btn-dark" onclick="document.location.href='/admin/design/popup/lists';">목록</button>
		</div>

	  </div>

	</form>


</div>


<script type='text/javascript' src='<?php echo LIB_DIR?>/jquery/jquery_validate.js'></script>
<script type='text/javascript'>
//<![CDATA[
/* rules 와 messages 에는 id 값이 아니라 name 값을 지정해야 한다. */
/*
$(function() {

	$('#fpopup').validate({
		onkeyup: false,
		rules: {
			pu_name: 'required',
			pu_content: 'required'
		},
		messages: {
			pu_name: '팝업 제목을 입력하세요.',
			pu_content: '팝업 내용을 입력하세요.'
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

});
*/
</script>


<link rel="stylesheet" type="text/css" href="/assets/lib/datetimepicker-master/jquery.datetimepicker.min.css" media="screen"/>
<script src="/assets/lib/datetimepicker-master/jquery.datetimepicker.full.js"></script>
<script type="text/javascript">
// datetimepicker
$.datetimepicker.setLocale('kr');
/*
$('.datetimepicker').datetimepicker({
	lang:'kr',
	datepicker:false,
	timepicker:false,
	format:'Y-m-d',
	formatDate:'Y/m/d',
	yearStart:'<?php echo date("Y") -1 ?>',
	yearEnd:'<?php echo date("Y") +10 ?>'
});
*/

$('.sdatetimepicker').datetimepicker({
	lang:'kr',
	format:'Y-m-d H:00:00',
	//format:'Y-m-d H:i:s',
	yearStart:'<?php echo date("Y") -1 ?>',
	yearEnd:'<?php echo date("Y") +10 ?>'
});
$('.edatetimepicker').datetimepicker({
	lang:'kr',
	format:'Y-m-d H:59:59',
	//format:'Y-m-d H:i:s',
	yearStart:'<?php echo date("Y") -1 ?>',
	yearEnd:'<?php echo date("Y") +10 ?>'
});
</script>
