<style type="text/css">
	/* 2024-03-22 */
	.page_tabnav { margin: 0 auto; padding: 0 15px; width: 100%; max-width: 600px; }
	.page_tabnav > button { width: 32%; max-width: 190px; height: 47px;border: none;background-color: #c2c2c2;border-top-left-radius: 7px;border-top-right-radius: 7px;color: #ffffff;font-weight: bold; }
	.page_tabnav > button.tabnav_active { background-color: #54a435; }
	.tabnav_ctnt {}
	.tabnav_ctnt .ctnt_sect { border-bottom: 1px solid #cacaca; }
	.tabnav_ctnt .ctnt_sect .sect_max { margin:0 auto; padding: 35px 15px; width: 100%;  max-width: 960px; min-height: 400px; z-index: 2;}
	.step_no { color: #49bbf3; font-size: 14px; text-decoration: underline;}
	.step_ttl { color: #0091d9; font-size: 28px; font-weight: bold; margin-top: 10px; margin-bottom: 15px; }
	.step_ctnt { font-size: 17px; margin-top: 10px; line-height: 160%;  }
	.step_btn { padding: 15px 0 0 0; }
	.step_btn button { border:1px solid #0091d9; background-color: #ffffff; color: #0091d9; padding: 0 20px; line-height: 36px; font-size: 14px; } 
	.step_memo { margin-top: 25px;}
	.step_memo dl { font-size: 15px; }
	.step_memo dl dt {}
	.step_memo dl dd { margin-top: 8px; padding-left: 15px; }

	.ctnt_sect {
		position: relative;
		width: 100%;
		min-height: 400px;
	}
	#tabnav_ctnt_1 .ctnt_sect { min-height: 400px; }
	#tabnav_ctnt_1_1 .sect_bg_wrap .sect_bg { background-image: url('/assets/images/replus/dn_bgimg_step_1.png?v=2');}
	#tabnav_ctnt_1_2 .sect_bg_wrap .sect_bg { background-image: url('/assets/images/replus/dn_bgimg_step_2.png?v=1');}
	#tabnav_ctnt_1_3 .sect_bg_wrap .sect_bg { background-image: url('/assets/images/replus/dn_bgimg_step_3.png?v=1');}

	#tabnav_ctnt_1 .sect_bg_wrap {
		position: relative; 
		margin: 0 auto;
		width: 100%; 
		max-width: 1100px; 
	}
	#tabnav_ctnt_1 .sect_bg {
		z-index: 1;
		position: absolute;
		bottom: 0;
		right: 0;
		width: 100%;
		min-height: 400px;
		margin: 0 aut0;
		background-repeat: no-repeat;
		background-size: auto 80%;
		background-position: right bottom;
	}


	#tabnav_ctnt_2 .ctnt_sect { min-height: 300px; }

	#tabnav_ctnt_2_1 .sect_bg_wrap .sect_bg { background-image: url('/assets/images/replus/replus_bgimg_step1.png?v=1');}
	#tabnav_ctnt_2_2 .sect_bg_wrap .sect_bg { background-image: url('/assets/images/replus/replus_bgimg_step2.png?v=1');}
	#tabnav_ctnt_2_3 .sect_bg_wrap .sect_bg { background-image: url('/assets/images/replus/replus_bgimg_step3.png?v=1');}
	#tabnav_ctnt_2_4 .sect_bg_wrap .sect_bg { background-image: url('/assets/images/replus/replus_bgimg_step4.png?v=1');}
	#tabnav_ctnt_2_5 .sect_bg_wrap .sect_bg { background-image: url('/assets/images/replus/replus_bgimg_step5.png?v=1');}
	#tabnav_ctnt_2_6 .sect_bg_wrap .sect_bg { background-image: url('/assets/images/replus/replus_bgimg_step6.png?v=1');}

	#tabnav_ctnt_2 .sect_bg_wrap {
		position: relative; 
		margin: 0 auto;
		width: 100%; 
		max-width: 1100px; 
	}
	#tabnav_ctnt_2 .sect_bg {
		z-index: 1;
		position: absolute;
		bottom: 0;
		right: 0;
		width: 100%;
		min-height: 400px;
		margin: 0 aut0;
		background-repeat: no-repeat;
		background-size: auto 60%;
		background-position: right center;
		/*
		background-position: right 35px; */
	}


	@media screen and (max-width: 991px) {
		.ctnt_sect { 
			padding-bottom: 180px;
		}

		#tabnav_ctnt_1 .ctnt_sect { min-height: 180px; }

		#tabnav_ctnt_1_2.ctnt_sect { 
			padding-bottom: 160px;
		}
		#tabnav_ctnt_1 .sect_bg_wrap {
			position: absolute; 
			left: 0;
			bottom: 0;
		}
		#tabnav_ctnt_1 .sect_bg_wrap .sect_bg {
			background-size: auto 50%;
			background-position: center bottom;
		}

		#tabnav_ctnt_2 .sect_bg_wrap {
			position: absolute; 
			left: 0;
			bottom: 0;
		}
		#tabnav_ctnt_2 .sect_bg_wrap .sect_bg {
			background-size: auto 40%;
			background-position: center center;
		}

	}


	.page_title {
		font-family: 'Nanum Gothic', 'NanumGothic', '나눔고딕', '나눔 고딕', 'Noto Sans KR', AppleSDGothicNeo-Regular, '맑은 고딕', 'Malgun Gothic', dotum, '돋움', sans-serif;
		font-size: 28px;
		font-weight: 800;
		font-stretch: normal;
		font-style: normal;
		/*
		line-height: 0.85; */
		letter-spacing: normal;
		text-align: left;
		color: #353535;
	}



	.dn_btn_comp {
		width: 528px;
		height: 148px;
		background-color: transparent;
		background-image: url('<?php echo IMG_DIR ?>/replus/dn_btn_comp.png');
		background-repeat: no-repeat;
		background-size: 100% 100%;
		border: none;
		outline: none;
		margin: 80px auto;
	}
	.dn_btn_comp:hover {
		background-image: url('<?php echo IMG_DIR ?>/replus/dn_btn_comp_hover.png');
	}
	@media screen and (max-width: 991px) {
		.dn_btn_comp {
			width: 80vw;
			height: 22.43vw;
			margin: 50px auto;
		}
	}

</style>

<div class="ctnt_wrap pt_35 pb_5">
	<div class="ctnt_inside">
		<div class="contents_wrap">
			<h3 class="page_title">기부 절차 안내</h3>
		</div>
	</div>
</div>

<!-- 기부절차 안내 -->
<div id="tabnav_ctnt_1" class="tabnav_ctnt">

		<div id="tabnav_ctnt_1_1" class="ctnt_sect">
			<div class="sect_max">
				
				<div class="step_no">STEP 1</div>
				<div class="step_ttl">캠페인 선택</div>
				<div class="step_ctnt">
					사용하지 않는 중고 디지털 기기를 기부해 주세요!<br />
					IT기기가 필요한 <strong>현재 진행중인 캠페인</strong> 중<br />
					희망하시는 캠페인에 기부하기를 선택해 주세요.
				</div>
				<div class="step_btn">
					<a href="<?php echo base_url('campaign/lists');?>"><button type="button" class="roundbox_30">바로 가기</button></a>
				</div>
				<div class="step_memo">
					<dl>
						<dt>※ 카카오톡 간편 로그인 후 기부 가능합니다. </dt>
						<dd>마이페이지에서 수거 제품 처리 현황, 데이터 삭제 결과를 확인해보세요.</dd>
					</dl>
				</div>
			</div>
			<div class="sect_bg_wrap"><div class="sect_bg"></div></div>
		</div>

		<div id="tabnav_ctnt_1_2" class="ctnt_sect">
			<div class="sect_max">
				<div class="step_no">STEP 2</div>
				<div class="step_ttl">캠페인 참여</div>
				<div class="step_ctnt">
					희망일자에 맞추어 기부물품을 안전하게 수거합니다.<br />
					방문 수거를 위해 방문 전 미리 연락드립니다.
				</div>
				<div class="step_memo">
					<dl>
						<dt>※ 수거 후 기기는 리사이클센터(주식회사 리맨)로 이동합니다.</dt>
						<dd>기부된 물품은 리사이클 센터에서 검수 후 재생하여<br />
							기부가치와 환경 가치를 산정한 후 기부됩니다.
						</dd>
						<dd>
							일부 캠페인은 수거를 위한 박스를 따로 전달드립니다. <br />
							캠페인 내에 있는 설명을 유의해서 읽어주세요.
						</dd>
					</dl>
				</div>
				<div class="step_btn">
					<a href="<?php echo base_url('recycle');?>"><button type="button" class="roundbox_30">리사이클 센터 바로 가기</button></a>
				</div>
			</div>
			<div class="sect_bg_wrap"><div class="sect_bg"></div></div>
		</div>

		<div id="tabnav_ctnt_1_3" class="ctnt_sect">
			<div class="sect_max">
				<div class="step_no">STEP 3</div>
				<div class="step_ttl">실시간 마이페이지 확인</div>
				<div class="step_ctnt">
					물품 검수 현황 및 기부 가치 평가,<br />
					데이터 완전 삭제 리포트,<br />
					기부금 영수증을 신청하실 수 있습니다.
				</div>
				<div class="step_btn">
					<a href="<?php echo base_url('mypage');?>"><button type="button" class="roundbox_30">바로 가기</button></a>
				</div>
				<div class="step_memo">
					<dl>
						<dt>※ 후원 소식 확인</dt>
						<dd>기부자가 참여한 기부캠페인의 후원 소식과 감사 인사를 확인할 수 있습니다.
						</dd>
					</dl>
				</div>
			</div>
			<div class="sect_bg_wrap"><div class="sect_bg"></div></div>
		</div>

</div>


<!-- 기업 기부버튼 -->
<div class="dsp_flex_xy_center">
	<a href="<?php echo base_url('landing/comp'); ?>"><button type="button" class="dn_btn_comp"></button></a>
</div>



<script type="text/javascript">
$(document).ready(function(){

});
</script>
