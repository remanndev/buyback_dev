<?php
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
// 모바일 설정
$_class_container = 'container';
$_line_limit = 'col-3';
if(IS_MOBILE) {
	$_class_container = 'm_container_bbs';
	$_line_limit = 'col-6';
}
?>

<style type="text/css">

	.guide_section {width: 100%; max-width: 720px; margin:0 auto 100px; }
	.guide_section > h3.top_title {
			font-family: 'Nanum Gothic','Noto Sans KR', AppleSDGothicNeo-Regular,'맑은 고딕','Malgun Gothic';
			font-size: 24px;
			font-weight: bold;
			font-stretch: normal;
			font-style: normal;
			line-height: 1.2;
			letter-spacing: normal;
			text-align: center;
			color: #549732;
	}

	.guide_title_bar {  width: 76px; height: 9px; margin: 0 auto 15px; background-color: #549732; }

	.sect_title { margin:20px 0 0 0; font-family: 'Nanum Gothic','Noto Sans KR', AppleSDGothicNeo-Regular,'맑은 고딕','Malgun Gothic'; font-size: 34px;font-weight: 800;font-stretch: normal;font-style: normal;line-height: 0.85;letter-spacing: normal;text-align: center;color: #549732;}
	.sect_desc { margin:20px 0 0 0; font-family: 'Nanum Gothic','Noto Sans KR', AppleSDGothicNeo-Regular,'맑은 고딕','Malgun Gothic'; font-size: 18px; font-weight: bold; font-stretch: normal; font-style: normal; line-height: 1.42; letter-spacing: -0.36px; text-align: center; color: #353535; }
	.sect_ctnt { margin:50px 0 0 0; font-family: 'Nanum Gothic','Noto Sans KR', AppleSDGothicNeo-Regular,'맑은 고딕','Malgun Gothic'; font-size: 18px;font-weight: normal;font-stretch: normal;font-style: normal;line-height: 1.42;letter-spacing: -0.36px;text-align: left;color: #353535;}

	.sect_btn {  width: 320px;height: 70px;margin: 42px auto;padding: 23px 34px; object-fit: contain; background-color: #1891c9; color:#ffffff; font-weight: bold;}
	.sect_btn:hover { color:#fff; }

	/* 2022-12-18 */
	.o_content_ttl {text-align:center; }
	.o_content_ttl strong { font-family:'Nanum Gothic','NanumGothic','나눔고딕','나눔 고딕', 'Noto Sans KR', AppleSDGothicNeo-Regular,'맑은 고딕','Malgun Gothic',dotum,'돋움',sans-serif;
					font-size: 34px;font-weight: 800;font-stretch: normal;font-style: normal;
					line-height: 0.85;letter-spacing: normal;text-align: left;color: #353535;
					margin:0 auto; text-align: center;
				}

</style>


<div class="pc_wrap">
  <div class="ctnt_wrap py_35">
	<div class="ctnt_inside">
		<div class="contents_wrap">
			<div style="margin:0 auto;">

				<!-- 페이지 내용 -->
				<h3 class="o_content_ttl">
					<strong>기부 절차 안내</strong>
				</h3>


				<div id="sect_1" class="guide_section">
					<h3 class="top_title mt-4">리플러스를 통한 현물 기부는<br />다섯 단계로 나누어 진행됩니다</h3>
					<div class="mt-5 text-center">각 단계마다 주체가 되는 기관이 책임지고 진행하며, 리플러스는 중간에서 기부 코디네이터가 되어 기부 물품이 원활하게 수혜자에게 전달되도록 합니다.</div>
					<div class="mt-5 py-5 text-center">
						<img src="<?php echo IMG_DIR ?>/replus/guide_sect1_img1_big.png" style="width:100%; max-width: 556px; margin:0 auto;" />
					</div>
				</div>


				<div id="sect_2" class="guide_section">
					<div class="guide_title_bar"></div>
					<h2 class="sect_title">사전 준비</h2>
					<div class="sect_desc">NPO가 해야 할 일이에요</div>
					<div class="sect_ctnt">
						<strong>[NPO와 리플러스 협약 체결]</strong> <br />
						<br />
						기부 캠페인 개설은 NPO 및 사회적 협동조합만 가능합니다. 현물 기부의 특성상 캠페인 개설 전에 물품의 수거와 처리를 위하여 리플러스와 사전 협약이 필요해요.<br />
						<br />
						협약 신청은 리플러스 이메일(<strong>replus@npoit.kr</strong>) 또는 메인화면 우측 하단 [협약 신청]에서 가능하며, 협약 체결 후 캠페인 목적, 모금 수량, 대상 등을 기획하여 캠페인을 런칭합니다.
					</div>
					<div class="text-center"><a href="<?php echo base_url() ?>landing/npo"><button class="btn sect_btn">NPO 회원 협약신청으로 바로가기</button></a></div>
				</div>


				<div id="sect_3" class="guide_section">
					<div class="guide_title_bar"></div>
					<h2 class="sect_title">캠페인 선택 후 기부 신청</h2>
					<div class="sect_desc">기부자가 해야 할 일이에요</div>
					<div class="sect_ctnt">
						비영리기관들이 모금하는 다양한 캠페인이 있습니다.캠페인 유형은 나눔에 가까운 "이웃을 위해"와 환경에 가까운 "지구를 위해" 두 유형이 있으며, 원하는 캠페인을 선택하여 기부할 수 있습니다. <br />
						<br />
						물품 기부 캠페인은 특성상 현금 기부 캠페인에 비해 모금 기간이 길어요. 기업(기관) 기부자는 사무용 기기 교체 시점 맞추어 기부하시기를 권해드립니다. 물품의 수거를 위해 연락처와 주소는 정확하게 입력해주세요.
					</div>
					<div class="text-center"><a href="/campaign/lists"><button class="btn sect_btn">기부캠페인 목록으로 바로가기</button></a></div>
				</div>


				<div id="sect_4" class="guide_section">
					<div class="guide_title_bar"></div>
					<h2 class="sect_title">안전 수거</h2>
					<div class="sect_desc">리플러스가 하는 일이에요</div>
					<div class="sect_ctnt">
						택배 기사님이나 리플러스 회수 직원이 사전 약속을 하고 기부 물품 수거 희망일자에 맞춰 안전 수거를 진행합니다. 수거는 수거 희망지역 분포에 따라 기간이 달라질 수 있으니 최대한 넉넉하게 잡아주세요. 수거 일자가 확정되면 별도로 안내드립니다. 단, 5대 이하 소량 물품의 경우에는 택배로 보내주셔야하며, 방법은 별도로 안내를 드립니다.
					</div>
				</div>


				<div id="sect_5" class="guide_section">
					<div class="guide_title_bar"></div>
					<h2 class="sect_title">재생 및 가치 산정</h2>
					<div class="sect_desc">리플러스가 하는 일이에요</div>
					<div class="sect_ctnt">
						기부 물품을 리사이클 센터에서 검수하여 재생하고 기부 및 환경 가치를 산정합니다. 이 과정에서 디지털 기기의 상태를 확인하고, 재사용이 가능한 물품과 폐기(재생)해야 할 물품을 구분합니다. 저장장치 데이터 삭제 또한 이 과정에서 진행되며 삭제는 디가우징, 천공폐기, 분쇄, 소프트웨어 방식 삭제 중에서 가장 안전한 방법으로 처리합니다. 이 후에는 [마이페이지]에서 처리 사진과 삭제 보고서를 확인하실 수 있습니다. 최종적으로 산정된 기부 가치는 필수 소요 비용을 제외하고 재생 제품과 현금으로 NPO에게 전달됩니다.
					</div>
				</div>


				<div id="sect_5" class="guide_section">
					<div class="guide_title_bar"></div>
					<h2 class="sect_title">나눔 및 전달</h2>
					<div class="sect_desc">NPO가 하는 일이에요</div>
					<div class="sect_ctnt">
						리플러스 그린센터에서 재생하고 산정한 재생 제품과 기부금으로 캠페인 목적(목적 사업)에 맞게 활용합니다. 수혜자에게 디지털 기기를 개별 전달할 경우에는 리플러스에서 수혜자에게 직접 전달합니다. <br />
						<br />
						기부에 참여하신 분들은 기부 물품 진행 상황을 리플러스 홈페이지 [마이페이지]에서 확인하실 수 있습니다.
					</div>
				</div>


				<div id="sect_5" class="guide_section">
					<div class="guide_title_bar"></div>
					<h2 class="sect_title">피드백 및 예우</h2>
					<div class="sect_desc">NPO가 하는 일이에요</div>
					<div class="sect_ctnt">
						이제 기부캠페인의 모든 절차가 종료 되었습니다. 기부자를 위한 피드백과 예우를 해야 할 때입니다. <br />
						<br />
						NPO는 기부 물품이 어떻게 재생되고, 가치가 산정되었으며, 어떻게 사용되었는지 기부캠페인 모금 소식을 통해 알려드립니다. <br />
						<br />
						리플러스는 홈페이지 My Page에 기부자께서 기부하신 물품과 산정된 기부가치, 데이터 삭제 리포트, 기부금 영수증을 게시해드립니다. 언제든 본인의 기부 현황을 확인하실 수 있습니다. <br />
						<br />
						NPO에서 기부자를 위한 특별한 예우를 다할 수 있도록 리플러스가 도울 것입니다.
					</div>
				</div>





			</div>
		</div>
	</div>
  </div>
</div>