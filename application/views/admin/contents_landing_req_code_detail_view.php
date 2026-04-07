<div class=" admin_wrap">

	<h1>신청/문의 상세</h1>

	<h2><?php echo $landing_title ?></h2>

	<div class="tbl_landing_frm">

		<table>
		<colgroup>
		  <col width="130">
		  <col>
		</colgroup>

		<?php
			foreach($arr_fld_nm as $i => $fld_nm) {
			  $no = $i + 1;
			  if($fld_nm == '') {
				continue;
			  }
		?>
		<tr>
			<th><?php echo $fld_nm ?></th>
			<td><?php echo $list[$i] ?></td>
		</tr>
		<?php } ?>


		<?php
			foreach($arr_file_ttl as $j => $file_ttl) {
			  $no2 = $j + 1;
			  if($no2 > $row->file_cnt) {
				continue;
			  }
		?>
		<tr>
			<th><?php echo $file_ttl ?></th>
			<td>
				<a href="<?php echo $arr_file_link[$j] ?>" style="color: #0d6efd; text-decoration: underline;"><?php echo $arr_file_name[$j] ?></a>
				(<?php echo $arr_file_size[$j] ?>)
			</td>
		</tr>
		<?php } ?>






		<tr>
			<th>신청일자</th>
			<td><?php echo $list[($i+1)] ?></td>
		</tr>
		</table>
	</div>
	
	<div class="buttonBox" style="width:100%; margin:50px auto 30px; text-align:center;">
		<a href="<?php echo base_url() ?>admin/contents/landing/req_code/<?php echo $code ?>" class="btn btn-dark btn-sm">목록</a>
	</div>


</div>

<script type="text/javascript">
$(function(){
	$R('.page_content ', { 
		focus: true,
		lang: 'ko',
		minHeight: '300px',
		//maxHeight: '1000px',
		plugins: ['fontsize','fontcolor','filemanager','video','table','alignment','inlinestyle','specialchars','textdirection','widget','fontfamily','fullscreen'],
		imageUpload: "/files/upload/redactor_image/<?php echo url_code('page/image','e') ?>/page",
		imagePosition: true,
		fileUpload: "/files/upload/redactor_file/<?php echo url_code('page/file','e') ?>/page",

		buttonsAddAfter: {
			after: 'deleted',
			buttons: ['underline','line', 'redo', 'undo', 'underline', 'ol', 'ul', 'sup', 'sub']
		},
		buttonsHide: ['lists']

	});
});
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

$('.datepicker').datetimepicker({
	lang:'kr',
	format:'Y-m-d',
	timepicker:false,
	//format:'Y-m-d',
	yearStart:'<?php echo date("Y") -1 ?>',
	yearEnd:'<?php echo date("Y") +10 ?>'
});
</script>


<script type="text/javascript">
$(function(){

	$('.fld_nm').each(function(){
		if($(this).val() != '') {
			$(this).removeClass('empty_fld');
		}
	});

	$('.fld_nm').on('focus',function(){
		$(this).removeClass('empty_fld');
	});
	$('.fld_nm').on('blur',function(){
		if($(this).val() == '') {
			$(this).addClass('empty_fld');
		}
	});

});
</script>