<div class=" admin_wrap">

	<h1>메인 페이지 :: 기부된 디지털 기기 수량 관리</h1>
	<h2>기본정보</h2>

	<!-- 노트북, 데스크탑, 모니터, 스마트패드, 스마트폰 -->

	<?php echo form_open($this->uri->uri_string(), array('id'=>'amount_form','name'=>'amount_form', 'onsubmit'=>' return chk_form();')); ?>

	<div class="tbl_frm">
		<table>
		<colgroup>
		  <col style="width:120px;">
		  <col>
		</colgroup>
		<tr>
		  <th>노트북</th>
		  <td>
			<input type="text" id="notebook" name="notebook" value="<?php echo set_value('notebook', (isset($row->notebook) ? $row->notebook : '' )); ?>" class="o_input" />
			<?php echo form_error('notebook','<div class="err_color_red">','</div>'); ?>
		  </td>
		</tr>
		<tr>
		  <th>데스크탑</th>
		  <td>
			<input type="text" id="pc" name="pc" value="<?php echo set_value('pc', (isset($row->pc) ? $row->pc : '' )); ?>" class="o_input" />
			<?php echo form_error('pc','<div class="err_color_red">','</div>'); ?>
		  </td>
		</tr>
		<tr>
		  <th>모니터</th>
		  <td>
			<input type="text" id="monitor" name="monitor" value="<?php echo set_value('monitor', (isset($row->monitor) ? $row->monitor : '' )); ?>" class="o_input" />
			<?php echo form_error('monitor','<div class="err_color_red">','</div>'); ?>
		  </td>
		</tr>
		<tr>
		  <th>스마트패드</th>
		  <td>
			<input type="text" id="tablet" name="tablet" value="<?php echo set_value('tablet', (isset($row->tablet) ? $row->tablet : '' )); ?>" class="o_input" />
			<?php echo form_error('tablet','<div class="err_color_red">','</div>'); ?>
		  </td>
		</tr>
		<tr>
		  <th>스마트폰</th>
		  <td>
			<input type="text" id="smartphone" name="smartphone" value="<?php echo set_value('smartphone', (isset($row->smartphone) ? $row->smartphone : '' )); ?>" class="o_input" />
			<?php echo form_error('smartphone','<div class="err_color_red">','</div>'); ?>
		  </td>
		</tr>
		</table>
	</div>

	<div style="text-align:center; padding:40px 0 20px;">
		<input type="submit" name="submit" class="btn btn-dark btn-sm" value="저장" />
	</div>

	<?php echo form_close(); ?>
	<hr class="clear" />
</div>

<!-- 노트북, 데스크탑, 모니터, 스마트패드, 스마트폰 -->
<script type="text/javascript">
// 폼 체크
function chk_form() {

	var notebook = $('#notebook').val();
	var pc = $('#pc').val();
	var monitor = $('#monitor').val();
	var tablet = $('#tablet').val();
	var smartphone = $('#smartphone').val();

	if('' == notebook) {
		alert('노트북 수량을 입력해주세요.');
		return false;
	}
	else if('' == pc) {
		alert('데스크탑 수량을 입력해주세요.');
		return false;
	}
	else if('' == monitor) {
		alert('모니터 수량을 입력해주세요.');
		return false;
	}
	else if('' == tablet) {
		alert('스마트패드 수량을 입력해주세요.');
		return false;
	}
	else if('' == smartphone) {
		alert('스마트폰 수량을 입력해주세요.');
		return false;
	}

	return true;
}
</script>

