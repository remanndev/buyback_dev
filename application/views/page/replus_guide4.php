<style type="text/css">

	/* - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	 * 공통 
	 */
	 /*
	* { font-family: 'Noto Sans KR', 'Nanum Gothic', 'NanumGothic', '나눔고딕', '나눔 고딕', AppleSDGothicNeo-Regular, '맑은 고딕', 'Malgun Gothic', dotum, '돋움', sans-serif; }
	*/


	/* - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	 * 분기 [mobile / desktop] 
	 */
	.mobile-only { display: block !important; }
	.desktop-only { display: none !important; }

	@media (min-width: 768px) {
	  .mobile-only { display: none !important; }
	  .desktop-only { display: block !important; }
	}


	/* - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	 * 반응형 기본 틀
	 */
	 
	/* 모바일 기본 * * * * * * * * * * * * * * * * * * * * */
	.card-list {
	  display: flex;
	  flex-direction: column;
	  gap: 0px;
	}
	.card-list .figure { margin-top: 12px; text-align: center; }
	.card-list .figure img { width: 100%; max-width: 280px; margin: 0 auto; }
	
	.card_step { font-size: 18px; color: #272724; font-weight: 500; margin-top: 10px; }
	.card_ttl { font-size: 26px; font-weight: 700; color: #00a4ff; line-height: 1.1; }
	.card_desc { font-size: 15px; font-weight: normal; color: #272724; margin-top: 15px; }
	.card_ctnt_1 { 
		margin-top: 15px;
		font-size: 15px;
		font-weight: normal;
		line-height: 1.4;
		color: #272724;
	}
	.card_highlight { display: inline-block;  background-color: #cff0ac; }
	
	.card-list ul { padding-left: 1rem; }
	.card-list ul.small-dot li::marker { font-size: 0.5em; }
	.card-list ul.gap7 li { margin-top: 7px; }
	
	.card_box_1 {
		margin: 15px 0 10px;
		padding: 20px 30px;
		border-radius: 10px;
		border: solid 1px #00a4ff;
		background-color: #fff;
	}
	.card_box_1 dl, .card_box_1 dl dt, .card_box_1 dl dd { margin:0;  padding:0; }
	.card_box_1 dl dt {
		font-size: 14px;
		font-weight: 500;
		color: #00a4ff;
		margin-left: -11px;
		margin-bottom: 3px;
	}
	.card_box_1 dl dd {
		font-size: 14px;
		font-weight: 500;
		font-size: 14px;
		font-weight: 500;
		line-height: 1.43;
		color: #272724;
	}
	
	/* 동그라미 안에 숫자 목록 */
	.step-list {
	  list-style: none;
	  padding-left: 0;
	  counter-reset: step;
	}
	.step-list li {
	  counter-increment: step;
	  position: relative;
	  padding-left: 34px;
	  margin-bottom: 12px;
	  line-height: 1.4;
	  font-size: 15px;
	  font-weight: 500;
	}
	.step-list li::before {
	  content: counter(step);
	  position: absolute;
	  left: 0;
	  top: 2px;

	  width: 20px;
	  height: 20px;

	  background: #1e88ff;
	  color: #fff;

	  font-size: 13px;
	  font-weight: bold;
	  border-radius: 50%;

	  display: flex;
	  align-items: center;
	  justify-content: center;
	  
	  /* box-shadow: 0 2px 6px rgba(0,0,0,.15); */
	}
	
	


	.manual-steps {
	  list-style: none;
	  padding: 0;
	  margin: 0;
	  counter-reset: step;
	}

	.manual-steps li {
	  counter-increment: step;
	  position: relative;

	  display: flex;
	  gap: 10px;

	  padding-left: 28px;
	  margin-bottom: 5px;
	  
	  font-size: 15px;
	  font-weight: 500;
	  font-stretch: normal;
	  color: #272724;
	  line-height: 1.4;
	}

	/* 번호 원 */
	.manual-steps li::before {
	  content: counter(step);
	  position: absolute;
	  left: 0;
	  top: 0;

	  width: 20px;
	  height: 20px;

	  background: #000;
	  color: #fff;

	  font-size: 13px;
	  font-weight: 700;

	  border-radius: 50%;

	  display: flex;
	  align-items: center;
	  justify-content: center;
	}
	
	.color_blue {font-size: 14px;font-weight: 500;font-stretch: normal;color: #00a4ff; line-height: 1.29;}

	
	
	
	/* 태블릿 * * * * * * * * * * * * * * * * * * * * */
	@media (min-width: 768px) {
		.card-list {
			/* flex-direction: row; */
			flex-wrap: wrap;
			gap: 6px;
		}
		.card_step { 
			/* font-size: 18px; color: #272724; font-weight: 500; margin-top: 10px; */ 

			font-size: 18px;
			font-weight: 400;
			color:#ababab; 
		}
		.card_ttl {
			/* font-size: 26px; font-weight: bold; color: #00a4ff; line-height: 1.1; */
			margin-top: 10px;
			font-size: 28px;
			font-weight: 700;
			color: #00a4ff;
		}
		.card_desc {
			/* font-size: 15px; font-weight: 500; color: #272724; margin-top: 15px; */
			font-size: 17px;
			
		}
		.card_ctnt_1 { 
			/* margin-top: 15px;font-size: 15px;font-weight: 500;line-height: 1.4;color: #272724; */
			font-size: 17px;
		}
		.card_box_1 dl dt {
			font-size: 16px;
		}
		.card_box_1 dl dd {
			font-size: 14px;
		}

		/*
		.manual-steps {
		}
		.manual-steps li {
			width: 25%; 
			display: block;
		}
		*/

		.desktop-only .manual-steps li {
			width: 25%; 
			display: block;
		}
		.desktop-only .manual-steps li img {
			width: 100%;
			max-width: 180px;
		}
		.desktop-only .manual-steps li .step-text {
			margin-top: 10px;
			width: 100%;
			max-width: 180px;
		}


	}

	/* 데스크탑 * * * * * * * * * * * * * * * * * * * * */
	@media (min-width: 1200px) {
	}
	
	
	.btn_dn_comp {
		margin: 30px auto;
	}
	.btn_dn_comp button {
		width: 290px;
		height: 82px;
		background-color: transparent;
		background-image: url(/assets/images/replus/dn_btn_comp.png);
		background-repeat: no-repeat;
		background-size: 100% auto;
		border: none;
		outline: none;
	}
	
	.btn_blue button {
	  padding: 12px 19px 16px 17px;
	  border-radius: 5px;
	  background-color: #00a4ff;
	  border: none;
	  color: #ffffff;
	}

	/* - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	 * 반응형
	 */
	 
	 
	/* 모바일 기본 * * * * * * * * * * * * * * * * * * * * */
	/* 페이지 타이틀 */
	.page_ttl {
		font-size: 30px; font-weight: 700; font-stretch: normal; font-style: normal; letter-spacing: normal; text-align: left; color: #272724;
		padding: 15px 0 0 0;
	}
	/* 탭메뉴 */
	.navtab { }
	.navtab button { width: calc(50% - 6px); background-color: #daeef8; border: none;  }
	.navtab  button.tab_active { background-color: #82d6ff;  }
	
	hr.navtab_bottom { border-bottom: 4px solid #82d6ff; margin: 0; padding: 0; opacity: 1.0 !important; }


	/* 태블릿 * * * * * * * * * * * * * * * * * * * * */
	@media (min-width: 768px) {
		.page_ttl {
			padding: 40px 0 0 0;
		}
		.btn_dn_comp {
			margin: 60px auto 60px;
		}
		.btn_dn_comp button {
			width: 380px;
			height: 120px;
		}
	}

	/* 데스크탑 * * * * * * * * * * * * * * * * * * * * */
	@media (min-width: 1200px) {
		.page_ttl {
			padding: 40px 0 0 0;
		}
		.btn_dn_comp {
			margin: 70px auto 60px;
		}
		.btn_dn_comp button {
			width: 460px;
			height: 140px;
		}
	}
</style>


<style type="text/css">
	/* 전체 래퍼 */
	.tab-wrap {
	  width: 100%;
	  max-width: 800px;
	  margin: 0 auto;
	}

	/* 버튼 영역 */
	.tab-buttons {
	  display: flex;
	}

	/* 공통 버튼 */
	.tab-btn {
	  flex: 1;
	  padding: 6px 0 5px;
	  background: #daeef8;
	  /* border: 1px solid #bcdff1;
	  border-bottom: none; */
	  border: none;
	  cursor: pointer;

	  font-size: 15px;
	  font-weight: 600;
	  color: #272724;
	  
	  line-height: 1.1;

	  transition: background 0.2s ease, color 0.2s ease;
	}

	/* 🔹 왼쪽 버튼 */
	.tab-btn:first-child {
	  /* 
	  border-radius: 15px 0 0 0; */ /* 좌상단만 */
	  border-radius: 15px 15px 0 0; /* 상단만 */
	}

	/* 🔹 오른쪽 버튼 */
	.tab-btn:last-child {
	  /* 
	  border-radius: 0 15px 0 0; */ /* 우상단만 */
	  border-radius: 15px 15px 0 0; /* 상단만 */
	}

	/* 🔹 active 상태 */
	.tab-btn.active {
	  background: #82d6ff;
	  color: #272724;
	  position: relative;
	  z-index: 2;
	}

	/* 콘텐츠 영역 */
	.tab-contents {
	  border: none; /* 1px solid #bcdff1; */
	  /* background: #ffffff; */
	  padding: 20px 20px 0 20px;
	}
	.tab-contents_2 {
	  border: none; /* 1px solid #bcdff1; */
	  /* background: #ffffff; */
	  padding: 50px 20px;
	}

	/* 콘텐츠 기본 숨김 */
	.tab-content {
	  display: none;
	  width: 100%;
	  max-width: 800px;
	  margin: 0 auto;

	}

	/* 콘텐츠 활성화 */
	.tab-content.active {
	  display: block;
	}
	

	
	/* 태블릿 * * * * * * * * * * * * * * * * * * * * */
	@media (min-width: 768px) {

		/* 공통 버튼 */
		.tab-btn {
		  flex: 1;
		  margin: 0 5px;
		  padding: 10px 0 8px;
		  background: #daeef8;
		  /* border: 1px solid #bcdff1;
		  border-bottom: none; */
		  border: none;
		  cursor: pointer;

		  font-size: 22px;
		  font-weight: 600;
		  color: #272724;
		  
		  line-height: 1.5;

		  transition: background 0.2s ease, color 0.2s ease;
		}
		.tab-btn br { display: none; }
		
		/*
		.card-list .card_desc br { display: none; }
		*/
		.card-list .card_ttl br { display: none; }

		.tab-wrap {
			max-width: 1100px;
		}
		.tab-content {
			max-width: 1100px;
		}


	  
		.tab-contents {
			display: flex; 
			justify-content: space-between; 
			padding-top: 50px;
		}
		.tab-contents section:first-child{
			width: 55%;
		}
		.tab-contents section:nth-child(2){
			width: 35%;
		}
		
		.tab-contents_2 {
			display: flex; 
			justify-content: space-between; 
		}
		.tab-contents_2 section:first-child{
			width: 55%;
		}
		.tab-contents_2 section:nth-child(2){
			width: 35%;
		}

	}
	/* 데스크탑 * * * * * * * * * * * * * * * * * * * * */
	@media (min-width: 1200px) {

	}
	
	
</style>


<!-- 페이지 타이틀 -->
<div class="ctnt_wrap" style="margin-bottom: 20px;">
	<div class="ctnt_inside">
		<div class="contents_wrap">
			<h3 class="page_ttl">기부 안내</h3>
		</div>
	</div>
</div>


<!-- 페이지 네비 -->
<div class="ctnt_wrap">
	<div class="ctnt_inside">
		<div class="contents_wrap">
		
			<div class="tab-wrap">
			  <div class="tab-buttons">
				<button class="tab-btn active" data-tab="tab1">기부절차 안내</button>
				<button class="tab-btn" data-tab="tab2">리플러스박스 <br />사용 안내</button>
			  </div>
			</div>
			
			
		</div>
	</div>
</div>
<hr class="navtab_bottom" />




<!-- 탭 1 콘텐츠 -->
<div class="tab-content active" id="tab1">

	<!-- 탭 1-1 콘텐츠 -->
	<div class="ctnt_wrap">
		<div class="ctnt_inside">
			<div class="tab-contents">

				<section class="card-list">
					<div class="card_step">STEP 1</div>
					<div class="card_ttl">캠페인 선택</div>
					<div class="card_desc"><strong>현재 진행중인 캠페인</strong> 중 <br />희망하시는 캠페인을 선택해주세요. </div>
				</section>
				<section class="card-list">
					<div class="figure"><img src="/assets/images/page/guide1_step1.png?v=1" /></div>
				</section>
				
			</div>
		</div>
	</div>

	<!-- 탭 1-2 콘텐츠 -->
	<div class="ctnt_wrap" style="background-color: #eff7fb;">
		<div class="ctnt_inside">
			<div class="tab-contents">

				<section class="card-list">
					<div class="card_step">STEP 2 : 리플러스박스 받기</div>
					<div class="card_ttl">기부 참여</div>
					<div class="card_ctnt_1">
						<ul class="small-dot gap7">
						  <li><span class="card_highlight">기부하기</span> 버튼을 누른 후, 기부자 정보와 기부물품정보 를 입력해주세요.</li>
						  <li><span class="card_highlight">추가</span> 버튼을 이용해 여러 종류의 기기를 등급별로 등록할 수 있습니다. </li>
						  <li>기부 품목에 맞춰 편리하게 물건을 포장할 수 있는 <span class="card_highlight">리플러스박스</span> 를 보내드립니다. </li>
						  <li>PC 및 모니터 등 부피가 큰 기기 기부를 희망하시는 경우 별도의 상자를 이용하여 포장 부탁드립니다. </li>
						</ul>
					</div>


					<div class="card_box_1">
						<dl>
						  <dt>* 기부가능품목</dt>
						  <dd>데스크탑, 모니터, 노트북, 태블릿PC, 스마트폰/피처폰, 저장장치(HDD/SSD/외장하드 등)가 들어있는 디지털기기</dd>
						</dl>
					</div>
				</section>
				
				
				<section class="card-list">
					<div class="figure"><img src="/assets/images/page/guide1_step2.png?v=1" /></div>
				</section>

			</div>
		</div>
	</div>


	<!-- 탭 1-3 콘텐츠 -->
	<div class="ctnt_wrap" style="background-color: #ffffff;">
		<div class="ctnt_inside">
			<div class="tab-contents">

				<section class="card-list">
					<div class="card_step">STEP3 : 리플러스박스 수령 후</div>
					<div class="card_ttl">기부물품포장 및 <br />수거신청</div>
					<div class="card_desc">
						리플러스박스가 배송되면, 박스안에 있는 
						안전 파우치에 각 기기를 넣어주세요.
					</div>
					<div class="card_desc">
						태블릿&노트북용 /스마트폰용 안전 파우치 포장을 완료한 뒤, 리플러스 마이페이지에서 수거신청 버튼을 눌러주세요.
					</div>
				</section>
				<section class="card-list" style="margin-top: 10px;">
					<div class="figure"><img src="/assets/images/page/guide1_step3.png?v=1" /></div>
				</section>

			</div>
		</div>
	</div>


	<!-- 탭 1-4 콘텐츠 -->
	<div class="ctnt_wrap" style="background-color: #eff7fb;">
		<div class="ctnt_inside">
			<div class="tab-contents">

				<section class="card-list">
					<div class="card_step">STEP 4</div>
					<div class="card_ttl">배송&검수 현황 확인</div>
					<div class="card_desc">
						수거 후 실시간 배송 현황 및 검수 현황을 
						<strong>[마이페이지]</strong>에서 확인할 수 있습니다.
					</div>
				</section>
				<section class="card-list" style="margin-top: 10px;">
					<div class="figure"><img src="/assets/images/page/guide1_step4.png?v=1" /></div>
				</section>

			</div>
		</div>
	</div>



	<!-- 탭 1-5 콘텐츠 -->
	<div class="ctnt_wrap" style="background-color: #ffffff;">
		<div class="ctnt_inside">
			<div class="tab-contents">

				<section class="card-list">
					<div class="card_step">STEP5</div>
					<div class="card_ttl">최종 기부 완료</div>
					<div class="card_desc">
						<ul class="small-dot">
						  <li>최종 검수 및 데이터삭제가 완료되면 안내톡이 발송됩니다. </li>
						  <li>기부자는 마이페이지를 통해 데이터 완전 삭제 리포트를 받아 보실 수 있습니다.</li>
						  <li>기기 등급에 따라 기부가치가 산정되고, 해당 금액만큼 캠페인에 적립됩니다. </li>
						  <li>캠페인을 개설한 단체는 필요한 재제조 디지털 기기를 리플러스를 통해 지원받을 수 있습니다.</li>
						</ul>
					</div>
				</section>
				<section class="card-list">
					<div class="figure"><img src="/assets/images/page/guide1_step5.png?v=1" /></div>
				</section>

			</div>
		</div>
	</div>




	<!-- 탭 1-6 콘텐츠 -->
	<div class="ctnt_wrap" style="background-color: #eff7fb;">
		<div class="ctnt_inside">
			<div class="tab-contents">

				<section class="card-list">
					<div class="card_step">STEP 6</div>
					<div class="card_ttl">기부금 영수증 발급 </div>
					<div class="card_desc">캠페인이 종료되고 난 뒤, 캠페인 개설 단체에서 기부금 영수증 발급을 위한 별도의 안내연락을 드립니다. </div>
				</section>
				<section class="card-list" style="margin-top: 10px;">
					<div class="figure"><img src="/assets/images/page/guide1_step6.png?v=1" /></div>
				</section>

			</div>
		</div>
	</div>


	<div class="dsp_flex_xy_center">
		<a href="https://replus.kr/landing/comp" class="btn_dn_comp"><button type="button" class="dn_btn_comp"></button></a>
	</div>


</div>



<!-- 탭 2 콘텐츠 -->
<div class="tab-content" id="tab2">

	<!-- 탭 2-1 콘텐츠 -->
	<div class="ctnt_wrap">
		<div class="ctnt_inside">
			<div class="tab-contents_2">

				<section class="card-list">
					<div class="card_ttl">리플러스박스 동봉 물품</div>
					<div class="card_ctnt_1">
						<ul class="small-dot">
						  <li>안전 파우치(스마트폰/노트북용)</li>
						  <li>십자벨트</li>
						  <li>안내문</li>
						</ul>
					</div>
				</section>
				<section class="card-list" style="margin-bottom: 10px;">
					<div class="figure"><img src="/assets/images/page/guide2_step1.png" /></div>
				</section>
				
			</div>
		</div>
	</div>

	<!-- 탭 2-2 콘텐츠 -->
	<div class="ctnt_wrap" style="background-color: #eff7fb;">
		<div class="ctnt_inside">
			<div class="tab-contents_2">

				<section class="card-list">
					<div class="card_ttl">리플러스박스 포장 방법</div>
					<ol class="step-list" style="margin-top: 30px;">
						<li>나눔 신청한 디지털 기기들을 안전파우치 안에 넣은 뒤, 리플러스 박스 안에 넣어주세요. </li>
						<li>리플러스박스 상단의 벨크로패치(찍찍이)에 맞춰 상자를 닫아주세요.</li>
						<li>동봉된 십자벨트로 박스를 감싸주세요. <div class="color_blue">(아래 십자벨트 사용법 참고)</div></li>
						<li>리플러스 마이페이지 및 안내서에 있는 QR코드를 이용해 수거신청을 해주세요.  </li>
						<li>신청 후, 물품은 미리 수거 장소 앞에 놔주세요. <div class="color_blue">수거 신청 후 2-3일 이내로 CJ택배에서 방문수거합니다.</div></li>
					</ol>
				</section>
				<section class="card-list" style="margin-bottom: 10px;">
					<div class="figure"><img src="/assets/images/page/guide2_step2.png" /></div>
				</section>

			</div>
		</div>
	</div>



	<!-- 탭 2-3 콘텐츠 -->
	<div class="ctnt_wrap" style="margin-bottom: 40px;">
		<div class="ctnt_inside">
			<div class="tab-contents_2">

				<section class="card-list">
					<div class="card_ttl">십자벨트 사용법</div>
					<div class="card_ctnt_1" style="margin-top: 30px;">
						태블릿&노트북용 안전 파우치와 스마트폰용 안전 파우치 포장을 완료한 뒤, 리플러스 <span class="card_highlight">마이페이지에서 수거신청</span> 버튼을 눌러주세요.
					</div>
					<div style="margin-top: 20px;">
						<a href="https://youtube.com/shorts/fybA1UgpPc4?si=-p-XeH-B0yJ7KDjJ" class="btn_blue" target="_blank"><button>십자벨트 사용법 영상 보러 가기</button></a>
					</div>
				</section>

				<section class="card-list" style="margin: 30px 0;">
					<div class="figure"><img src="/assets/images/page/guide2_step3.png" /></div>
				</section>

				<div class="card-list  mobile-only">
					<ol class="manual-steps">
					  <li>
						<div class="step-img">
						  <img src="/assets/images/page/g2s3img1.png" />
						</div>
						<div class="step-text">
						  사진과 같이 잠금벨트의 비밀번호 부분이 상자칸을 비켜 오도록 박스를 감싸주세요.
						</div>
					  </li>

					  <li>
						<div class="step-img">
						  <img src="/assets/images/page/g2s3img2.png" />
						</div>
						<div class="step-text">
						  남은 선을 대각선 방향으로 돌려주세요.
						</div>
					  </li>
					  

					  <li>
						<div class="step-img">
						  <img src="/assets/images/page/g2s3img3.png" />
						</div>
						<div class="step-text">
						  한번 더 박스를 감싸 잠금장치를 끼워주세요.
						</div>
					  </li>
					  

					  <li>
						<div class="step-img">
						  <img src="/assets/images/page/g2s3img4.png" />
						</div>
						<div class="step-text">
						  잠금장치에 맞춰 끼운 후 비밀번호를 돌려주세요.
						</div>
					  </li>
					  
					</ol>
				</div>
				
			</div>
			
			<div class="desktop-only">
			
					<ol class="manual-steps dsp_flex_sp_between">
					  <li>
						<div class="step-img">
						  <img src="/assets/images/page/g2s3img1.png" />
						</div>
						<div class="step-text">
						  사진과 같이 <br />잠금벨트의 비밀번호 부분이 <br />상자칸을 비켜 오도록 <br />박스를 감싸주세요.
						</div>
					  </li>

					  <li>
						<div class="step-img">
						  <img src="/assets/images/page/g2s3img2.png" />
						</div>
						<div class="step-text">
						  남은 선을 <br />대각선 방향으로 <br />돌려주세요.
						</div>
					  </li>
					  

					  <li>
						<div class="step-img">
						  <img src="/assets/images/page/g2s3img3.png" />
						</div>
						<div class="step-text">
						  한번 더 박스를 감싸 <br />잠금장치를 끼워주세요.
						</div>
					  </li>
					  

					  <li>
						<div class="step-img">
						  <img src="/assets/images/page/g2s3img4.png" />
						</div>
						<div class="step-text">
						  잠금장치에 맞춰 끼운 후 <br />비밀번호를 돌려주세요.
						</div>
					  </li>
					  
					</ol>

			</div>
			
		</div>
	</div>



</div>







<script>
document.querySelectorAll('.tab-btn').forEach(btn => {
  btn.addEventListener('click', () => {
    const target = btn.dataset.tab;

    // 버튼 active 처리
    document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');

    // 콘텐츠 active 처리
    document.querySelectorAll('.tab-content').forEach(c => c.classList.remove('active'));
    document.getElementById(target).classList.add('active');
  });
});
</script>




<!-- 기업 기부버튼 -->
<!-- <div class="dsp_flex_xy_center">
	<a href="<?php echo base_url('landing/comp'); ?>"><button type="button" class="dn_btn_comp"></button></a>
</div> -->



<script type="text/javascript">
$(document).ready(function(){

});
</script>
