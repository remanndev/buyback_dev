<h1>행사 일정</h1>
<h2 style="position:relative;">
	<?php echo $title ?>
</h2>
<hr style="margin-top:5px;" />

<form id="fstart" class="form-horizontal" role="form" name="fstart" method="post" enctype="multipart/form-data" action="/admin/calendar/write/<?php echo $category ?>/<?php echo $cal_no ?><?php echo $add_url ?>">
<input type="hidden" name="w" value="<?php echo $w ?>" />
<input type="hidden" name="category" value="<?php echo $category ?>" />
<input type="hidden" name="cal_no" value="<?php echo $cal_no ?>" />
<?php echo validation_errors('<pre style="color:red;">','</pre>')?>
<fieldset>

<div class="tbl_frm">
	<table>
		<colgroup>
		  <col width="150">
		  <col>
		</colgroup>
		<tr>
		  <th>일정 날짜</th>
		  <td>
			  <!-- <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span> -->
			  <input type="text" name="cal_date" id="cal_date" class="form-control span3 calendar_date" value="<?php echo set_value('cal_date', isset($cal_row['cal_date']) ? $cal_row['cal_date'] : ''); ?>"  title="클릭하시면 달력이 나옵니다." placeholder="일정 시작 날짜를 선택해주세요." style="width:120px; display:inline-block;"> ~ 
			  <input type="text" name="cal_date_end" id="cal_date_end" class="form-control span3 calendar_date" value="<?php echo set_value('cal_date_end', isset($cal_row['cal_date_end']) ? $cal_row['cal_date_end'] : ''); ?>"  title="클릭하시면 달력이 나옵니다." placeholder="일정 종료 날짜를 선택해주세요." style="width:120px; display:inline-block;">

			  <div>
				<?php echo form_error('cal_date','<div class="error">','</div>'); ?>
				<?php echo form_error('cal_date_end','<div class="error">','</div>'); ?>
			  </div>
		  </td>
		</tr>
		<tr>
		  <th>일정 제목</th>   
		  <td>
			<input type="text" name="cal_title" id="cal_title" class="form-control" value="<?php echo set_value('cal_title', isset($cal_row['cal_title']) ? $cal_row['cal_title'] : ''); ?>" maxlength="200">
			<?php echo form_error('cal_title','<div class="error">','</div>'); ?>
		  </td>
		</tr>
		<tr>
		  <th>일정 링크 (선택)</th>
		  <td>
			<div style="color:red; padding-bottom: 3px;"> 반드시 <strong>http://</strong> 또는 <strong>https://</strong> 로 시작하는 전체 링크를 입력해주세요.</div>
			<input type="text" name="cal_url" id="cal_url" class="form-control" value="<?php echo set_value('cal_url', isset($cal_row['cal_url']) ? $cal_row['cal_url'] : ''); ?>" maxlength="200" placeholder="http:// 또는 https:// 로 시작하는 전체 링크를 입력해주세요.">
			<?php echo form_error('cal_url','<div class="error">','</div>'); ?>
		  </td>
		</tr>
		<tr>
		  <th>일정 내용</th>
		  <td>
			<textarea id="cal_content" name="cal_content" class="form-control" ><?php echo set_value('cal_content', isset($cal_row['cal_content']) ? $cal_row['cal_content'] : ''); ?></textarea>
			<?php echo form_error('cal_content','<div class="error">','</div>'); ?>
		  </td>
		</tr>
	</table>

	<hr class="line" />
	<div class="text-center">
		<!-- <p class="btn-group"> -->
		  <!-- <button type="reset" class="btn btn-default btn-lg"><strong>초기화</strong></button> -->
		  <button type="submit" class="btn btn-dark btn-md"><strong>저장</strong></button>
		  <button type="button" class="btn btn-dark btn-md" onclick="location.href='/admin/calendar/lists/<?php echo $category?><?php echo $add_url ?>';"><strong>목록</strong></button>
		<!-- </p> -->
	</div>
</div>

</fieldset>
</form>



<!-- <script type='text/javascript' src='<?php echo JS_DIR?>/jquery/validate.js'></script> -->
<script type='text/javascript' src='<?php echo JS_DIR?>/jquery.datetimepicker.full.js'></script>
<script type='text/javascript'>
//<![CDATA[
/* rules 와 messages 에는 id 값이 아니라 name 값을 지정해야 한다. */
$(function() {

	/*
	$('#fstart').validate({
		onkeyup: false,
		rules: {
			//wr_key: { required:true, wrKey:true },
			cal_date : { required:true },
			cal_title : { required:true },
			cal_content : { required:true }
			
		},
		messages: {
			//wr_key: '자동등록방지용 코드가 맞지 않습니다.',
			cal_date: '일정 날짜를 선택해주세요.',
			cal_title: '일정 제목을 입력해주세요.',
			cal_content: '일정 내용을 입력해주세요.'
		},
		errorPlacement: function(error, element) {
			error.appendTo(element.parent().parent()).wrap("<p class='mgt_5'></p>");
    },
		submitHandler: function(f) {
			f.submit();
		}
	});
	*/

	var year = new Date().getFullYear();
	$('.calendar_date').datepicker({yearRange:(2012)+':'+(year+5)});

});
//]]>
</script>



<link rel="stylesheet" type="text/css" href="/assets/lib/datetimepicker-master/jquery.datetimepicker.min.css" media="screen"/>
<script src="/assets/lib/datetimepicker-master/jquery.datetimepicker.full.js"></script>
<script type="text/javascript">
// datetimepicker
$.datetimepicker.setLocale('kr');
$('.calendar_date').datetimepicker({
	lang:'kr',
	timepicker:false,
	format:'Y-m-d',
	formatDate:'Y/m/d',
	yearStart:'<?php echo date("Y") -2 ?>',
	yearEnd:'<?php echo date("Y") +5 ?>'
});
/*
$('.date_picker').datetimepicker({
	lang:'kr',
	timepicker:false,
	format:'Y-m-d',
	formatDate:'Y/m/d',
	yearStart:'<?php echo date("Y") -2 ?>',
	yearEnd:'<?php echo date("Y") +5 ?>'
});

$('.datetime_picker').datetimepicker({
	lang:'kr',
	timepicker:true,
	format:'Y-m-d H:i',
	formatDate:'Y/m/d',
	yearStart:'<?php echo date("Y") -2 ?>',
	yearEnd:'<?php echo date("Y") +5 ?>'
});
*/
</script>







<script type="text/javascript">
	$R('#cal_content', { 
		focus: true,
		//toolbarExternal: '#my-external-toolbar',
		lang: 'ko',
		minHeight: '500px',
		maxHeight: '1000px',
		plugins: ['fontsize','fontcolor','filemanager','video','table','alignment','inlinestyle','specialchars','textdirection','widget','fontfamily','fullscreen'],
		imageUpload: "/files/upload/redactor_image/<?php echo url_code('calendar/image','e') ?>",
		fileUpload: "/files/upload/redactor_file/<?php echo url_code('calendar/files','e') ?>",

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
	$R('#cal_content', 'insertion.insertHtml', add_tag);
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
