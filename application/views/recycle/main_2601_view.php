<style type="text/css">
	.step_no { color: #82d6ff; font-size: 14px; /* text-decoration: underline; */ }
	.step_ttl { color: #00a4ff; font-size: 26px; font-weight: bold; margin-bottom: 15px; }
	.step_ctnt { font-size: 15px; margin-top: 10px; line-height: 160%;  }
	.step_btn { padding: 15px 0 0 0; }
	.step_btn button { border:1px solid #0091d9; background-color: #ffffff; color: #0091d9; padding: 0 20px; line-height: 36px; font-size: 14px; } 
	.step_memo { margin-top: 25px;}
	.step_memo dl { font-size: 15px; margin: 0; }
	.step_memo dl dt {}
	.step_memo dl dd { margin-top: 8px; padding-left: 15px; }


	.ctnt_section {  /* border-bottom: 1px solid #cacaca; */ }

	.ctnt_max { display: flex; margin: 0 auto; padding: 35px 15px; width: 100%; max-width: 1000px; }
	.ctnt_wrap_text { 
		position: relative; 
		margin: 0 auto;
		width: 40%; 
		max-width: 400px; 
	}
	.ctnt_bg_wrap {
		position: relative; 
		margin: 0 auto;
		width: 60%; 
		max-width: 600px; 
	}
	.ctnt_bg_wrap .ctnt_bg {
		z-index: 1;
		width: 100%;
		/* min-height: 280px;  */
		margin: 0 auto;
		text-align: center;
		/*
		background-repeat: no-repeat;
		background-size: 88% auto;
		background-position: right center;
		*/
	}
	.ctnt_bg_wrap .ctnt_bg img { width: 100%; max-width: 400px; margin: 0 auto; }

	@media screen and (max-width: 768px) {
		.ctnt_max {
			width: 100%;
			flex-direction: column; 
		}
		.ctnt_wrap_text {
			width: 100%; 
			max-width: 100%;
		}
		.ctnt_bg_wrap {
			width: 100%; 
			max-width: 100%;
			padding-top: 10px;
		}
		.ctnt_bg_wrap .ctnt_bg {
			background-position: center center;
			/*
			height: 40vw;
			min-height: 40vw; 
			*/
			
		}
		.ctnt_bg_wrap .ctnt_bg img { width: 100%; max-width: 300px; }

	}

	#tabnav_ctnt_2_1 .ctnt_bg_wrap .ctnt_bg { /* background-image: url('/assets/images/replus/replus_bg_step1.png?v=1'); */ }
	#tabnav_ctnt_2_2 .ctnt_bg_wrap .ctnt_bg { /* background-image: url('/assets/images/replus/replus_bg_step2.png?v=1'); */ }
	#tabnav_ctnt_2_3 .ctnt_bg_wrap .ctnt_bg { /* background-image: url('/assets/images/replus/replus_bg_step3.png?v=1'); */ }

	strong { font-weight: 600; }
</style>

<!-- 리플러스 안내 -->
<div id="tabnav_ctnt_2" class="tabnav_ctnt">


		<div id="tabnav_ctnt_2_1" class="ctnt_section">
			<div class="ctnt_max" style="">
				<div class="ctnt_wrap_text">
					<div class="step_no">리사이클센터  01</div>
					<div class="step_ttl">리플러스박스 수거</div>
					<div class="step_ctnt">
						기부해주신 소중한 디지털기기를 <br />
						CJ 대한통운에서 수거합니다.
					</div>
					<div class="step_memo">
						<!-- <dl>
							<dt>※ 방문 수거</dt>
							<dd>(기증물품 5박스 이상일 때)</dd>
						</dl> -->
					</div>
				</div>
				<div class="ctnt_bg_wrap">
					<div class="ctnt_bg"><img src="/assets/images/replus/replus_bg_step1.png?v=1" /></div>
				</div>
			</div>
		</div>

		<div id="tabnav_ctnt_2_2" class="ctnt_section">
			<div class="ctnt_max" style="">
				<div class="ctnt_wrap_text">
					<div class="step_no">리사이클센터  02</div>
					<div class="step_ttl">기기 검수 </div>
					<div class="step_ctnt">
						센터에 도착한 기기들은 연식, 파손 상태, 부품별 <br />
						사용 가능여부에 따라 기부가치 등급을 판정합니다.  
					</div>
					<div class="step_ctnt">
						· <strong>재사용</strong> <br />
						간단한 기기 정비 및 클리닝을 통해 사용이 가능한 상태
					</div>
					<div class="step_ctnt">
						· <strong>재제조</strong> <br />
						필요에 따라 부품을 교환하여 사용 가능한 상태거나, <br />
						일부 부품을 탈거할 수 있는 상태 
					</div>
					<div class="step_ctnt">
						· <strong>재활용</strong> <br />
						기준 이하로 연식이 노후되거나, 기기의 파손상태가 <br />
						심해 파쇄하여 소재로 재활용할 수 있는 상태 
					</div>
				</div>
				<div class="ctnt_bg_wrap">
					<div class="ctnt_bg"><img src="/assets/images/replus/replus_bg_step2.png?v=1" /></div>
				</div>
			</div>
		</div>



		<div id="tabnav_ctnt_2_3" class="ctnt_section">
			<div class="ctnt_max" style="">
				<div class="ctnt_wrap_text">
					<div class="step_no">리사이클센터  03</div>
					<div class="step_ttl">데이터 보안 삭제 </div>
					<div class="step_ctnt">
						기존 기기에 기록되어 있던 데이터를 복구 불가능한 <br />
						방식으로 보안 삭제하여 추후 재사용이 가능한 <br />
						기기로 정비합니다. 또한 각 기기 등급에 따라 <br />
						다른 방식의 데이터 삭제가 진행됩니다. <br />
						<br />
						· 소프트웨어 프로그램을 이용한 데이터 보안 삭제<br />
						· 물리적 파쇄를 이용한 데이터 보안 삭제
					</div>
				</div>
				<div class="ctnt_bg_wrap">
					<div class="ctnt_bg"><img src="/assets/images/replus/replus_bg_step3.png?v=1" /></div>
				</div>
			</div>
		</div>

</div>

