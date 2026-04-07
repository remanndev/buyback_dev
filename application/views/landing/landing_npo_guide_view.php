<style>
.page_title {
	position: relative;
	margin: 0 !important;
	display: flex;
}
.page_title strong {
    font-family: 'Nanum Gothic','NanumGothic','나눔고딕','나눔 고딕', 'Noto Sans KR', AppleSDGothicNeo-Regular,'맑은 고딕','Malgun Gothic',dotum,'돋움',sans-serif;
    font-size: 28px;
    font-weight: 800;
    font-stretch: normal;
    font-style: normal;
    line-height: 1;
    letter-spacing: normal;
    text-align: left;
    color: #353535;
}
.page_title .plink {
	position: absolute; 
	right: 0;
	bottom: 0;

	font-size: 20px;
	color: #535353;
}


.input_border_css1 {
  border-top: none;
  border-left: none;
  border-right: none;
}
.btn_blue_white button { border:1px solid #0091d9; background-color: #ffffff; color: #0091d9; padding: 0 20px; line-height: 36px; font-size: 14px; } 

.guide_sect {
	position: relative;
	margin: 0;
	/* padding: 0 0 0 40px; */
}
/*
.guide_sect::before {
	content:"";
	position: absolute;
	left: 10px;
	top: 10px;
	line-height: 28px;
	width:18px;
	height:14px;
	border: none;
	background-image: url('/assets/images/replus/npo_guide_up.png');
	background-repeat: no-repeat;
	background-size: contain;
}
.guide_sect.openned::before {
	background-image: url('/assets/images/replus/npo_guide_down.png');
}
*/
.guide_sect .sect_ttl { position: relative; font-size: 23px; margin-bottom: 20px; padding-left: 35px; cursor: pointer; }
.guide_sect .sect_ttl::before {
	content:"";
	position: absolute;
	left: 10px;
	top: 5px;
	line-height: 28px;
	width:18px;
	height:14px;
	border: none;
	background-image: url('/assets/images/replus/npo_guide_up.png');
	background-repeat: no-repeat;
	background-size: contain;
}
.guide_sect .sect_ttl.openned::before {
	background-image: url('/assets/images/replus/npo_guide_down.png');
}


.sect_desc { margin: 0; padding: 0 0 0 33px; }
.sect_desc > div { margin: 8px 0;}

.ttlno {
	position: relative;
	padding-left: 30px;
}
.ttlno::before {
	content: '';
	position: absolute;
	left: 3px;
	top: 3px;
	width:18px;
	height:18px;
	border: none;
	/* background-image: url('/assets/images/replus/npo_ttlno_1.png'); */
	background-repeat: no-repeat;
	background-size: contain;

}
.ttlno_1.ttlno::before { background-image: url('/assets/images/replus/npo_ttlno_1.png'); }
.ttlno_2.ttlno::before { background-image: url('/assets/images/replus/npo_ttlno_2.png'); }
.ttlno_3.ttlno::before { background-image: url('/assets/images/replus/npo_ttlno_3.png'); }
.ttlno_4.ttlno::before { background-image: url('/assets/images/replus/npo_ttlno_4.png'); }

.ttl_bold { font-weight: bold; }
</style>

<div class="py_35">

	<div class="ctnt_wrap">
		<div class="redactor-styles" style="width: 100%; padding: 16px 15px;">
			<h3 class="page_title">
				<strong>NPO 협약 안내</strong>
				<a class="plink  d-block d-sm-none" href="<?php echo base_url('landing_npo/form');?>">협약 신청</a>
			</h3>
		</div>
	</div>
	<hr style="margin-top: 0;" />

	<div class="ctnt_wrap">
		<div class="redactor-styles" style="width: 100%; max-width: 980px; padding: 16px 15px;">
			<div class="guide_sect">
				<strong class="sect_ttl">가입 조건</strong>
				<div class="sect_desc">
					<div class="ttlno ttlno_1">
						<div>단체 설립 및 운영기간이 3년 이상인 단체</div>
						<div>※ (고유등록증 및 사업자등록증 확인 필수)</div>
					</div>
					<div class="ttlno ttlno_2">
						<div>비영리단체* 또는 사회적협동조합</div>
						<div>(법인, 민간단체, 임의단체)</div>
					</div>
					<div class="ttlno ttlno_3">
						<div>공익사업을 주 사업으로 하며, <br />고유목적사업이 정관에 명시된 단체</div>
					</div>
					<div class="ttlno ttlno_4">
						<div>기부금 영수증 발급이 가능한 단체</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<hr />


	<div class="ctnt_wrap">
		<div class="redactor-styles" style="width: 100%; max-width: 980px; padding: 16px 15px;">
			<div class="guide_sect">
				<strong class="sect_ttl">가입 절차</strong>
				<div class="sect_desc">
					<div class="ttlno ttlno_1">
						<div>NPO 협약신청서 작성 및 제출 (온라인)</div>
					</div>
					<div class="ttlno ttlno_2">
						<div>신청서 검토 및 승인심사 (월 1회)</div>
					</div>
					<div class="ttlno ttlno_3">
						<div>결과 안내 (유선·이메일 통보)</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<hr />


	<div class="ctnt_wrap">
		<div class="redactor-styles" style="width: 100%; max-width: 980px; padding: 16px 15px;">
			<div class="guide_sect">
				<strong class="sect_ttl">제출 서류</strong>
				<div class="sect_desc">
					<div class="ttlno ttlno_1">
						<div>
							<div class="ttl_bold">제출 공통 서류</div>
							<div>· 고유번호증 또는 사업자등록증</div>
						</div>
					</div>
					<div class="ttlno ttlno_2">
						<div class="ttl_bold">단체 유형별 서류</div>
						<div>· 비영리민간단체 : 비영리민간단체등록증</div>
						<div>· 비영리법인 : 법인설립허가증</div>
						<div>· 협동조합 : 설립인가증</div>
						<div>· 사회복지시설 : 시설신고증 또는 위탁협약서, 법인일경우 모법인의 법인설립허가증</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<hr />


	<div class="ctnt_wrap">
		<div class="redactor-styles" style="width: 100%; max-width: 980px; padding: 16px 15px;">
			<div class="guide_sect">
				<strong class="sect_ttl">진행 안내</strong>
				<div class="sect_desc">
					<div class="ttlno ttlno_1">
						<div class="ttl_bold">캠페인 개설</div>
						<div>
							기부캠페인 대상/목적, 디지털기기 품목/수량을 확정하여 캠페인을 개설해 주세요.<br />
							내부 심사 후 [기부캠페인] 페이지에 노출됩니다!
						</div>
					</div>
					<div class="ttlno ttlno_2">
						<div class="ttl_bold">캠페인 진행</div>
						<div>
							리플러스가 기부자들에게 캠페인 참여를 독려하며 기간 내 기기 수거 등의 문의와 <br />
							고객서비스를 제공합니다. 현물 기부 특성상 모금 기간은 3개월 이상을 권장합니다. 
						</div>
					</div>
					<div class="ttlno ttlno_3">
						<div class="ttl_bold">캠페인 종료 및 나눔</div>
						<div>
							캠페인 종료 이후 리사이클센터에서 수거, 검수, 재생, 나눔 과정이 진행됩니다.<br />
							재생완료된 제품은 단체에 전달하며, 지정한 수혜자가 있을 경우 직접 전달합니다.
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

</div>


<script type="text/javascript">
$(function(){
	$('.sect_ttl').on('click',function(){
		$(this).parent().children('.sect_desc').slideToggle();

		if( $(this).hasClass('openned') ) {
			$(this).removeClass('openned');
		}
		else {
			$(this).addClass('openned');
		}
	});
});
</script>