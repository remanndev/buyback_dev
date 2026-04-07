<style>
  .tbl_frm {}
  .tbl_frm table th { text-align:center;}
  .o_input {width:100%; padding:3px 10px; }
  .device_name {}
  .device_amount {text-align:right;}
  .device_display {}
  .device_order {text-align: center;}

  .display_use button.btn-primary::after {
    content: " √";
  }
  .display_use button.btn-secondary::after {
    content: " √";
  }
</style>
<div class=" admin_wrap">

	<h1>기부된 디지털 기기 수량 관리</h1>

	<h2>메인 페이지</h2>

	<!-- 노트북, 데스크탑, 모니터, 스마트패드, 스마트폰 -->


	<?php echo validation_errors(); ?>




	<?php //echo form_open($this->uri->uri_string(), array('id'=>'amount_form','name'=>'amount_form', 'onsubmit'=>' return chk_form();')); ?>
	<?php //echo form_open($this->uri->uri_string(), array('id'=>'device_form','name'=>'device_form')); ?>

	<?php echo form_open($this->uri->uri_string()); ?>

		<div class="tbl_frm" style="width:100%; max-width: 800px;">
			<table>
			<colgroup>
			  <col style="width:10%;">
			  <col style="width:35%;">
			  <col style="width:20%;">
			  <col style="width:20%;">
			  <col style="width:15%;">
			</colgroup>

			<tr>
			  <th>NO</th>
			  <th>디바이스명</th>
			  <th>수량 관리</th>
			  <th>노출 여부</th>
			  <th>정렬 순서</th>
			</tr>
			<?php foreach($result['qry'] as $key => $row) { ?>
			<tr>
			  <td class="text-center">
				<?php echo ($key + 1) ?>
				<input type="hidden" name="device_idx[]" value="<?php echo $row->idx?>" class="o_input device_idx" />
			  </td>
			  <td><input type="text" name="device_name[]" value="<?php echo $row->device_name?>" class="o_input device_name" /></td>
			  <td><input type="text" name="device_amount[]" value="<?php echo $row->device_amount?>" class="o_input device_amount" /></td>
			  <td class="text-center">
				<div class="btn-group display_use" role="group" aria-label="Basic outlined example">
				  <button type="button" class="btn btn-sm btn-dsp btn_y <?php echo ($row->device_display == 'Y') ? 'btn-primary' : 'btn-outline-primary'; ?>" data-idx="<?php echo $row->idx?>" data-value="Y">사용</button>
				  <button type="button" class="btn btn-sm btn-dsp btn_n <?php echo ($row->device_display == 'N') ? 'btn-secondary' : 'btn-outline-secondary'; ?>" data-idx="<?php echo $row->idx?>" data-value="N">숨김</button>
				</div>
				<input type="hidden" id="device_display_<?php echo $row->idx?>" name="device_display[]" value="<?php echo $row->device_display?>" class="o_input device_display" />
			  </td>
			  <td><input type="text" name="device_order[]" value="<?php echo $row->device_order?>" class="o_input device_order" /></td>
			</tr>
			<?php } ?>
			</table>

			<div style="text-align:center; padding:40px 0 20px;">
				<input type="submit" name="submit" class="btn btn-dark btn-sm" value="저장" />
			</div>
		</div>

	<?php echo form_close(); ?>
	<hr class="clear" />
</div>


<script type="text/javascript">
$(document).ready(function(){
  
  $('.btn-dsp').on('click',function() {

	var idxNo = $(this).data('idx');
	var dsp = $(this).data('value');
	$('#device_display_'+idxNo).val(dsp);

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

