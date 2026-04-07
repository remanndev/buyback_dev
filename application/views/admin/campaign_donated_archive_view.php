<?php
	// 등록
	$date_ym = array(
		'name'	=> 'date_ym',
		'id'	=> 'date_ym',
		'value' => set_value('date_ym',''),
		'maxlength'	=> 7,
		'class' => 'o_input datepicker_ym',
		'placeholder' => date("Y-m"),
		'style' => 'width: 170px;'
	);
	$cnt_device = array(
		'name'	=> 'cnt_device',
		'id'	=> 'cnt_device',
		'value' => set_value('cnt_device',''),
		'maxlength'	=> 20,
		'class' => 'o_input add_comma',
		'placeholder' => '기부 물품 수량',
		'style' => 'width: 170px;'
	);
	$cnt_amt = array(
		'name'	=> 'cnt_amt',
		'id'	=> 'cnt_amt',
		'value' => set_value('cnt_amt',''),
		'maxlength'	=> 20,
		'class' => 'o_input add_comma',
		'placeholder' => '기부 가치 금액',
		'style' => 'width: 170px;'
	);
	$std_date = array(
		'name'	=> 'std_date',
		'id'	=> 'std_date',
		'value' => set_value('std_date',''),
		'maxlength'	=> 20,
		'class' => 'o_input datepicker',
		'placeholder' => '기준 일자',
		'style' => 'width: 170px;'
	);





?>


<style>
  .tbl_frm {}
  .tbl_frm table th { text-align:center;}
  .o_input {width:100%; padding:3px 10px; }
  .amt_title {}
  .amt_value {text-align:right;}
  .amt_display {}
  .amt_order {text-align: center;}

  .display_use button.btn-primary::after {
    content: " √";
  }
  .display_use button.btn-secondary::after {
    content: " √";
  }

  #arc_form .err_color_red { font-size: 13px; }
  .err_color_red p { margin: 0; }
</style>
<div class=" admin_wrap">

	<h1>누적된 사회적 가치 월별 관리</h1>



	<h2>신규 등록</h2>
	<?php echo form_open($this->uri->uri_string(), array('id'=>'archive_form','name'=>'archive_form')); ?>
		<div class="panel panel-default-flat" style="width:100%; max-width: 800px;">
		  <div class="panel-heading">

			<div id="arc_form" class="dsp_flex">

			  <div style="display:inline-block; vertical-align:baseline; margin-right:10px;">
				<label style="font-size:13px; vertical-align:middle; font-weight:bold;">연월(숫자만 6자리 입력)</label>
				<div>
					<?php echo form_input($date_ym); ?>
					<?php echo form_error('date_ym', '<div id="err_duplicate_date_ym" class="err_color_red" style="position: absolute; bottom: -30px; left: 0;">','</div>'); ?>
				</div>
			  </div>
			  <div style="display:inline-block; vertical-align:baseline; margin-right:10px;">
				<label style="font-size:13px; vertical-align:middle; font-weight:bold;">기부 물품 수량(대)</label>
				<div>
					<?php echo form_input($cnt_device); ?>
					<?php echo form_error('cnt_device', '<div id="err_duplicate_cnt_device" class="err_color_red" style="position: absolute; bottom: -30px; left: 0;">','</div>'); ?>
				</div>
			  </div>
			  <div style="display:inline-block; vertical-align:baseline; margin-right:10px;">
				<label style="font-size:13px; vertical-align:middle; font-weight:bold;">기부 가치 금액(원)</label>
				<div>
					<?php echo form_input($cnt_amt); ?>
					<?php echo form_error('cnt_amt', '<div id="err_duplicate_cnt_amt" class="err_color_red" style="position: absolute; bottom: -30px; left: 0;">','</div>'); ?>
				</div>
			  </div>
			  <div style="display:inline-block; vertical-align:baseline; margin-right:10px;">
				<label style="font-size:13px; vertical-align:middle; font-weight:bold;">기준 일자</label>
				<div>
					<?php echo form_input($std_date); ?>
					<?php echo form_error('std_date', '<div id="err_duplicate_std_date" class="err_color_red" style="position: absolute; bottom: -30px; left: 0;">','</div>'); ?>
				</div>
			  </div>

			  <div class="dsp_flex_column_reverse" style="vertical-align:baseline; padding-bottom: 2px;">
				<?php echo form_submit('submit', '등록', 'class="btn btn-black-flat btn-sm o_btn"'); ?>
			  </div>

			</div>

		  </div>
		</div>
	<?php echo form_close(); ?>

	<div class="err_color_red"><?php //echo validation_errors(); ?></div>



	<h2>월별 누적 가치</h2>

	<div class="tbl_frm" style="width:100%; max-width: 800px;">
		<table>
		<colgroup>
		  <col style="width:20%;">
		  <col style="width:25%;">
		  <col style="width:25%;">
		  <col style="width:20%;">
		  <col style="width:10%;">
		</colgroup>

		<tr>
		  <th>연월</th>
		  <th>기부물품 수량</th>
		  <th>기부가치 금액</th>
		  <th>기준 일자</th>
		  <th>관리</th>
		</tr>
		<?php foreach($result['qry'] as $key => $row) { ?>
		<tr>
		  <td class="text-center"><?php echo $row->date_ym?></td>
		  <td><div style="width: 80%; margin: 0 auto; text-align: right;"><?php echo number_format($row->cnt_device); ?> 대</div></td>
		  <td><div style="width: 80%; margin: 0 auto; text-align: right;"><?php echo number_format($row->cnt_amt); ?> 원</div></td>
		  <td class="text-center"><?php echo $row->std_date?></td>
		  <td class="text-center"><button type="button" class="btn btn-xs btn-danger-flat btn-sm btn_delete" data-idx="<?php echo $row->idx?>">삭제</button></td>
		</tr>
		<?php } ?>
		</table>

	</div>

	<hr class="clear" />
</div>


<script type="text/javascript">
$(document).ready(function(){
  
  $('.btn-dsp').on('click',function() {

	var idxNo = $(this).data('idx');
	var dsp = $(this).data('value');
	$('#amt_display_'+idxNo).val(dsp);

	//$(this).removeClass('btn-outline-primary').addClass('btn-primary');
	//$(this).siblings().removeClass('btn-primary').addClass('btn-outline-primary');

	if( $(this).hasClass('btn_y') ) {
		$(this).removeClass('btn-outline-primary').addClass('btn-primary');
		$(this).siblings().removeClass('btn-secondary').addClass('btn-outline-secondary');
	}
	else {
		$(this).removeClass('btn-outline-secondary').addClass('btn-secondary');
		$(this).siblings().removeClass('btn-primary').addClass('btn-outline-primary');
	}

  });

});

function chk_form() {
  alert('submit?');
}
</script>




<link rel="stylesheet" type="text/css" href="/assets/lib/datetimepicker-master/jquery.datetimepicker.min.css" media="screen"/>
<script src="/assets/lib/datetimepicker-master/jquery.datetimepicker.full.js"></script>
<script type="text/javascript">
$(document).ready(function(){

	// datetimepicker
	$.datetimepicker.setLocale('kr');

	$('.datepicker').datetimepicker({
		lang:'kr',
		format:'Y-m-d',
		formatDate:'Y-m-d',
		timepicker:false,
	});

	/*
	$('.datepicker_ym').datetimepicker({
		lang:'kr',
		format:'Y-m-d',
		formatDate:'Y-m-d',
		timepicker: false, // 시간 선택 비활성화
		closeOnDateSelect: true, // 선택 후 자동 닫기
	});
	*/


	// 입력 값 포맷 자동 변환
	$('.datepicker_ym').on('input', function() {
		let inputVal = $(this).val();
		// 숫자만 입력되었는지 확인 (202412 같은 형식)
		if (/^\d{6}$/.test(inputVal)) {
			// 연도와 월을 포맷팅
			const formattedValue = inputVal.slice(0, 4) + '-' + inputVal.slice(4, 6);
			$(this).val(formattedValue);
		}
	});

	/*
	$('.add_comma').on('keypress',function(){

		let inputVal = removeComma($(this).val());
		let inputComma = addComma(inputVal);
		$(this).val(inputComma);

	});
	*/

});
</script>
<script type="text/javascript">
$(document).ready(function(){

	$('.add_comma').on('keyup',function() {
		var str = removeComma(trim($(this).val()));
		var n = addComma(str);
		//console.log(n);
		//$('.add_comma').val(n);
		$(this).val(n);
	});

});
</script>


<script type="text/javascript">
$(document).ready(function(){
	$('.btn_delete').on('click',function(){

		let idx = $(this).data('idx');

		console.log(idx);


		var request = $.ajax({
		  url: "/trans/donated_archive/del/",
		  method: "POST",
		  data: { 'idx': idx  /* , '<?php echo $this->security->get_csrf_token_name() ?>':'<?php echo $this->security->get_csrf_hash() ?>' */},
		  dataType: "text"
		});

		request.done(function( res ) {

			// console.log(res);
			if('true' == res){
				location.reload();

			}

		});

		request.fail(function( jqXHR, textStatus ) {
		  alert( "Request failed: " + textStatus );

		  return false;
		});


	});




});
</script>