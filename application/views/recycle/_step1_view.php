<div class="ctnt_wrap">

	<h1 class="t-center">수거함 번호 입력</h1>

	<?php if('' != $qrcode_src) { ?>
	<div style="width:100%; max-width: 200px; margin:0 auto;;">
	  <div class="badge bg-dark" style="padding: 10px">
	    <img src="<?php echo $qrcode_src ?>" style="width:100%;" />
		<h2 style="margin:10px 0 5px 0;padding:0; font-size:32px; letter-spacing:7px;"><?php echo $code; ?></h2>
	  </div>
	</div>
	<?php } ?>

	<?php echo form_open(base_url().'recycle/proc', array('id'=>'form','name'=>'form', 'style'=>'padding-top: 40px;', 'onsubmit'=>'return frmchk();')); ?>
		<input type="hidden" id="code_org" name="code_org" value="<?php echo $code ?>" />
		<input type="hidden" name="step" value="step1" />

		<h3 class="t-center">QR코드 하단의 수거함 번호를 입력해 주세요.</h3>
		<div class="t-center">
			<input type="text" id="qrcode" name="qrcode" value="" class="o_input input_1" required />
		</div>

		<h3 class="t-center" style="padding-top: 20px;">한 번 더 입력해 주세요.</h3>
		<div class="t-center">
			<input type="text" id="qrcode_confirm" name="qrcode_confirm" value="" class="o_input input_1" required />
		</div>

		<div class="t-center" style="padding: 40px 0;">
			<button class="btn btn-primary btn-lg" style="width: 200px;">다음</button>
		</div>

	<?php echo form_close(); ?>
</div>

<script type="text/javascript">
$(document).ready(function(){
  //$('#form').submit();
});

  function frmchk() {
	var code_org = $('#code_org').val();
	var qrcode = $('#qrcode').val();
	var qrcode_confirm = $('#qrcode_confirm').val();

	if('' == qrcode) {
		alert('수거함 번호를 입력해주세요.');
		$('#qrcode').focus();
		return false;
	}
	else if(code_org != qrcode) {
		alert('수거함 번호를 바르게 입력해주세요.');
		$('#qrcode').val('');
		$('#qrcode_confirm').val('');
		$('#qrcode').focus();
		return false;
	}
	else if(qrcode != qrcode_confirm) {
		alert('재입력하신 수거함 번호가 다릅니다. 번호를 바르게 입력해주세요.');
		$('#qrcode_confirm').val('');
		$('#qrcode_confirm').focus();
		return false;
	}
	else {
		return true;
	}

  }
</script>