<style type="text/css">
.tabnav {
  width: 100%;
  height: 140px;
  margin: 0 auto;
  padding: 40px 0 50px;
  background-color: #f5f5f5;
}

.btn_nav {
  position: relative;
  border: none;
  font-family: NanumGothic;
  font-size: 34px;
  /* font-weight: bold; */
  font-stretch: normal;
  font-style: normal;
  line-height: 0.78;
  letter-spacing: -1.36px;
  text-align: center;
  color: #55a635;
  /* width: 140px; */

  display: inline-block;
  margin: 0 30px;
  background-color: #f5f5f5;
}
.nav_active {
	font-weight: bold;
}
.nav_active::after {
	position: absolute; 
	left:0; 
	bottom: -20px;
	content: "";
	min-width: 100%;

	height: 5px; 
	background-color: #55a635;
}

.nav_ctnt {
	font-size: 18px;
}
.nav_ctnt .nav_ttl {
	font-size: 24px;
	font-weight: bold;
}

.ctnt_box_green { 
	width: 328px;
	padding: 35px;
	background-color: #eef9ea;
}
.ctnt_box_green .ttl {
	font-size: 22px;
	font-weight: bold;
}


.ctnt_box_green_2 { 
	width: 672px;
	padding: 35px;
	background-color: #eef9ea;
}
.ctnt_box_green_2 .ttl {
	font-size: 22px;
	font-weight: bold;
}

.page_nav {}
.page_nav > button { width:49%; height: 100px; /* max-width: 600px; */ margin: 0 10px; padding: 20px 0 30px; background-color: #f5f5f5;}
.page_nav > button.nav_active::after {
	position: absolute; 
	left:0; 
	bottom: 0px;
	content: "";
	min-width: 100%;

	height: 5px; 
	background-color: #55a635;
}

</style>

<div class="">
  <div class="ctnt_wrap py_35">
	<div class="ctnt_inside">
		<div class="contents_wrap">
			<div style="margin:0 auto;  width: 100%;  max-width: 860px;">

				<!-- <div class="tabnav dsp_flex_xy_center">
					<button id="btn_nav1" data-ctnt="nav_ctnt_1" class="btn_nav nav_active">기부자</button>
					<button id="btn_nav2" data-ctnt="nav_ctnt_2" class="btn_nav">NPO</button>
				</div> -->

				<div class="mt-4 page_nav  dsp_flex_sp_between ">
					<button id="btn_nav1" data-ctnt="nav_ctnt_1" class="btn_nav nav_active">기부자</button>
					<button id="btn_nav2" data-ctnt="nav_ctnt_2" class="btn_nav">NPO</button>
				</div>




				<!-- 기부자 안내 -->
				<div id="nav_ctnt_1" class="nav_ctnt">

					<div class="mt-5">
						나에게 필요없는 물건이 누군가에겐 꼭 필요한 물건으로 <br />중고디지털기기 버리지말고 기부하세요! 현물 기부 플랫폼 REPLUS
					</div>

					<div class="nav_ttl mt-5">
						REPLUS 로그인
					</div>
					<div class="mt-2">
						집에서 잠자고 있는 중고디지털기기 기부해주세요! REPLUS가 직접 찾아갑니다.<br />
						방문수거와 제품 처리를 위해 리플러스에 로그인해 주세요.
					</div>

					<div class="mt-4 dsp_flex_x_start">
						<div class="ctnt_box_green dsp_flex_column dsp_flex_xy_center me-3">
							<div class="ttl mb-4">쉽고 간편하게 로그인</div>
							<div class="">'카카오로 시작하기'</div>
							<div class="">또는 '이메일 로그인하기'</div>
						</div>
						<div class="ctnt_box_green dsp_flex_column dsp_flex_xy_center">
							<div class="ttl mb-4">회원가입 없이 기부</div>
							<div class="">'카카오로 시작하기'</div>
							<div class="">또는 '이메일 로그인하기'</div>
						</div>
					</div>

					<div class="nav_ttl mt-5">
						캠페인 참여
					</div>
					<div class="mt-2">
						참여하고 싶은 [기부캠페인] → [기부하기] 버튼으로 참여해주세요!<br />
						신청 후 방문 수거를 위해 REPLUS에서 휴대전화, 카톡 등으로 연락드립니다.
					</div>

					<div class="nav_ttl mt-5">
						캠페인 진행
					</div>
					<div class="mt-2">
						기부자의 희망일자에 맞춰 안전하게 수거하여 리사이클 센터로 이동합니다.<br />
						기부 물품은 리사이클 센터에서 검수 한 후에 재생하고 기부가치와 환경 가치를 산정합니다.
					</div>

					<div class="nav_ttl mt-5">
						캠페인 종료
					</div>
					<div class="mt-2">
						[마이페이지] → [나의 기부 물품 현황]에서<br />
						물품 검수 현황, 기부 가치 평가, 데이터 완전 삭제 리포트 등을 확인하실 수 있습니다.
					</div>

					<div class="nav_ttl mt-5">
						후원 소식
					</div>
					<div class="mt-2">
						기부자가 참여한 기부캠페인의 후원 소식과 감사 인사를 [캠페인] → [모금 소식]에서 확인할 수 있습니다.<br />
						기부금 영수증은 모금 소식 등록 이후 [마이페이지]에서 확인 가능합니다.
					</div>

					<div class="dsp_flex_xy_center my-5">
						<a href="<?php echo base_url('campaign/lists'); ?>"><button class="btn btn-success btn-lg py-4 px-5" style="background-color: #55a635; font-family: NanumGothic; font-weight: bolder;"><h3>기부캠페인 바로 가기</h3></button></a>
					</div>
				</div>


				<!-- NPO 안내 -->
				<div id="nav_ctnt_2" class="nav_ctnt" style="display: none;">

					<div class="mt-5">
						정보소외계층을 위한 디지털기기 지원<br />
						수거, 재생, 가치 산정, 나눔 및 전달까지 REPLUS가 도와드릴게요!
					</div>

					<div class="nav_ttl mt-5">
						REPLUS 협약체결
					</div>
					<div class="mt-2">
						현물 기부 특성상 캠페인 개설 전 물품의 수거와 처리를 위해 리플러스와 사전 협약이 필요해요!
					</div>

					<div class="mt-4 dsp_flex_x_start">
						<div class="ctnt_box_green dsp_flex_column dsp_flex_xy_center me-3">
							<div class="ttl">NPO 협약 신청서</div>
							<div class="ttl">제출</div>
							
						</div>
						<div class="ctnt_box_green dsp_flex_column dsp_flex_xy_center">
							<div class="ttl">이메일 문의</div>
							<div class="ttl">replus@npoit.kr</div>
						</div>
					</div>


					<div class="nav_ttl mt-5">
						캠페인 개설
					</div>
					<div class="mt-2">
						기부캠페인 대상 / 목적, 디지털기기 품목 / 수량을 확정하여 캠페인을 개설해 주세요.<br />
						내부 심사 후 [기부캠페인]에 노출됩니다!
					</div>

					<div class="mt-4 dsp_flex_x_start">
						<div class="ctnt_box_green_2 dsp_flex_column dsp_flex_xy_center me-3">
							<div class="ttl">캠페인 개설 절차</div>
							<div class="ttl">
								[로그인] → [마이페이지] → [캠페인 개설] → [제출]
							</div>
						</div>
					</div>

					<div class="nav_ttl mt-5">
						캠페인 진행
					</div>
					<div class="mt-2">
						REPLUS가 모금개설기관을 도와 기부자들에게 캠페인 참여를 독려합니다.<br />
						현물 기부 특성상 모금 기간은 최소 3개월 이상으로 권장합니다. <br />
						캠페인 기간 동안 디지털기기 수거 등의 문의와 고객 서비스를 제공합니다.
					</div>

					<div class="nav_ttl mt-5">
						캠페인 종료 및 나눔
					</div>
					<div class="mt-2">
						캠페인 종료 이후 리사이클센터에서 수거 > 검수 > 재생 > 나눔 과정이 진행됩니다.<br />
						재활용/재제조 된 제품은 단체에 일괄 전달드리며, 미리 지정한 수혜자가 있을 경우<br />
						리플러스에서 직접 전달해드립니다.
					</div>

					<div class="nav_ttl mt-5">
						나눔 보고
					</div>
					<div class="mt-2">
						기부자에게 피드백과 예우를 [모금 소식]을 통해 전달해주세요. <br />
						제품 나눔 이후 1개월 이내에 기부금 영수증 발급과 캠페인 후기 작성 꼭 부탁드립니다.
					</div>

					<div class="dsp_flex_xy_center my-5">
						<a href="<?php echo base_url('landing/npo'); ?>"><button class="btn btn-success btn-lg py-4 px-5" style="background-color: #55a635; font-family: NanumGothic; font-weight: bolder;"><h3>NPO 협약신청 바로 가기</h3></button></a>
					</div>

				</div>

			</div>
		</div>
	</div>
  </div>
</div>


<script type="text/javascript">
$(document).ready(function(){
	$('.btn_nav').on('click',function(){
		$('.btn_nav').removeClass('nav_active');
		$(this).addClass('nav_active');

		$('.nav_ctnt').hide();
		let nav_ctnt = $(this).data('ctnt');
		$('#'+nav_ctnt).fadeIn();
	});
});
</script>