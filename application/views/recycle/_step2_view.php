<div class="ctnt_wrap">

	<?php if('' != $qrcode_src) { ?>
	<div style="width:100%; max-width: 200px; margin:0 auto;;">
	  <div class="badge bg-dark" style="padding: 10px">
	    <img src="<?php echo $qrcode_src ?>" style="width:100%;" />
		<h2 style="margin:10px 0 5px 0;padding:0; font-size:32px; letter-spacing:7px;"><?php echo $code; ?></h2>
	  </div>
	</div>
	<?php } ?>

	<h1 class="t-center">디지털 기기 수거함</h1>


	<script src="<?php echo JS_DIR ?>/sns_recycle.js"></script>
	<div class="mt-4 text-sm-center" style="display: flex; justify-content: space-evenly;">
		<div class="">
			<!-- 카카오 계정으로 로그인 -->
			<a href="#"><img src="<?php echo IMG_DIR ?>/common/sns_login_kakao.png" alt="카카오 로그인" class="kakaoLoginBtn"></a>
		</div>
		<div class="" style="display: none;">
			<!-- 네이버 계정으로 로그인 -->
			<a href="#"><img src="<?php echo IMG_DIR ?>/common/sns_login_naver.png" alt="네이버 로그인" class="naverLoginBtn"></a> 
		</div>
	</div>

</div>

