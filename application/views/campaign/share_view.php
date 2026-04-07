<style type="text/css">
  .share_title {
	font-size: 56px;
	font-weight: 800;
	font-stretch: normal;
	font-style: normal;
	line-height: normal;
	letter-spacing: -2.8px;
	color: #000;
  }
  .share_title:after {
	width: 76px;
	height: 5px;
	margin: 18px 78px 31px 139px;
	background-color: #55a635;
  }

</style>

<div class="pc_wrap">

	<!-- 캠페인 탑 비주얼 배너 영역 -->
	<div class="wrap_cmplist_top_bnr">
	  <?php foreach($top_bnr_pc as $i => $bnr) { ?>
		<div class="cmplist_top_bnr" style="background-image:url('<?php echo $bnr->banner_src ?>'); ">
			<div class="txt" style="color:#3d3c43;" ><?php echo nl2br($bnr->bn_memo) ?></div>
		</div>
	  <?php } ?>
	</div>
	<script type="text/javascript">
	$(document).ready(function(){
	  $('.wrap_cmplist_top_bnr').not('.slick-initialized').slick({
		  slidesToShow: 1,
		  slidesToScroll: 1,
		  arrows: false,
		  dots: false
	  });
	});
	</script>


	<div class="cmp_wrap">
	  <div class="main_sect">
		<div class="main_ctnt">

			<h2 class="share_title">나눔 캠페인이란?</h2>

			<br />
			<br />
			<br />
			<br />
			<br />

		</div>
	  </div>
	</div>


</div>