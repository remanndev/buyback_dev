  <style type="text/css">

	/* 화면용 기본 */
	@media screen {
	  html, body { margin: 0; padding: 0; width: 100%; min-height: 100%; position: relative; color: #272724; font-size: 17px; font-family: 'Pretendard Variable', system-ui, -apple-system, "Noto Sans KR", Arial, sans-serif; }
	  body {
		width: 100%; min-height: 100%;
		/*
		background-image: url('<?php echo IMG_DIR ?>/report/reportDel_bg_circle.png'), url('<?php echo IMG_DIR ?>/report/reportDel_bg.png'); 
		background-position: center center, center center;
		background-repeat: no-repeat, no-repeat;
		background-size: clamp(400px, 60vw, 800px) auto, cover;
		*/
	  }

	  .bg-content{ 
		width: 100%; min-height: 100%;
		background-image: url('<?php echo IMG_DIR ?>/report/reportDel_bg_circle.png'), url('<?php echo IMG_DIR ?>/report/reportDel_bg.png'); 
		background-position: center center, center center;
		background-repeat: no-repeat, no-repeat;
		background-size: clamp(400px, 60vw, 800px) auto, cover;
	  }

	}

	.wrap_report {}
	.ctnt_rpt { margin: 0 70px; }

	#topCopyright { width: 100%; /* height: 30px; */  padding-top: 20px; }
	#topCopyright .copyText { padding-top: 0px; line-height: 24px; font-size: 18px; }

	#topLineBg {
		width: 100%; height: 50px; margin-top: 10px; line-height: 50px; 
		background-image:url('<?php echo IMG_DIR ?>/report/reportDel_topLineBg.png'); background-position: center center; background-repeat:no-repeat; background-size: cover cover; 
	}
	#topLineBg div { font-size: 19px; }

	#topSubjectLogo { margin-top: 25px; }
	.report_subject { font-size: 48px; font-weight: 800; }
	.report_subtitle { font-size: 23px; font-weight: 500; }
	.topLogo { width: 194px; }

	#sectBasicInfo { }
	.sect_wrap { margin-top: 40px; }
	.sect_ttl { font-size: 22px; font-weight: bold; color: #008dd5; margin-bottom: 12px; }
	.sect_basic { background-color: #ffffff; padding: 32px 39px 29px 39px; }
	.sect_basic dl { margin: 0; padding: 0; }
	.sect_basic dl dt { margin: 0; padding: 0; font-size: 17px; font-weight: normal; }
	.sect_basic dl dd { margin: 0; padding: 0; font-size: 20px; font-weight: 700; margin-top: 17px;}

	.sect_tbl { text-align: left; border-top: 2px solid #707070; border-bottom: 1px solid #707070; padding-bottom: 20px; }
	.sect_tbl table {  width: 100%; }
	.sect_tbl table th { background-color: #e9e6e3; height: 46px; vertical-align: middle; font-weight: 500; padding-left: 35px; }
	.sect_tbl table td { font-size: 22px; padding-left: 35px; padding-top: 16px; }

	.trans_bg {
		/* 맨 아래: 실제 배경 이미지 */
		/* 그 위: 반투명 흰색 오버레이 */
		background: rgba(255, 255, 255, 0.6); /* 흰색 + 투명도 */
	}

	.sect_photo { }
	.sect_photo dl { margin: 0 auto; width: 32%; display: inline-block; }
	.sect_photo dl dt { }
	.sect_photo dl dd { margin-top: 5px; margin-bottom: 15px;  }
	.sect_photo .pic { width: 100%; height: 200px; overflow: hidden; background-color: #e9e6e3; } 
	.sect_photo .pic img { width: 100%; height: auto; margin: 0; padding: 0; }

	.sect_date {text-align: right; font-size: 22px; font-weight: 800; margin-top: 30px; }

	.remann_copy {
		vertical-align: bottom;
		background-image: url('<?php echo IMG_DIR ?>/report/reportDel_sign.png'); 
		background-position: right bottom;
		background-repeat: no-repeat; 
		background-size: 102px 100px;
		height: 100px;
	}
	.remann_copy .copyLogo { text-align: right; font-size: 22px; font-weight: 800; margin-right: 40px;  }
	.remann_copy .copyLogo > img { width: 210px; }

	.remann_copy .copyCompany { font-size: 27px; font-weight: 700; margin-right: 40px; line-height: 44px;}
	.remann_copy .copyCeo { font-size: 27px; vertical-align: bottom; line-height: 44px;}
	.remann_copy .copyCeo > span { font-weight: 700; margin-right: 60px; vertical-align: bottom; }

	.sect_cert { margin-top: 10px; padding-bottom: 30px; text-align: right; font-size: 20px; font-weight: 500;}
  </style>




  <style type="text/css">
	/* 인쇄용 */
	@media print {

	  /* 용지와 여백 */
	  @page {
		size: A4 portrait;            /* 필요시 letter / landscape */
		margin: 12mm;                 /* 프린터 드라이버 여백과 합쳐짐 */
	  }

	  /* 전역 리셋 */
	  html, body {  margin: 0; padding: 0; width: 100%; /* height: 100%; */ height: auto !important; overflow: visible !important; }
	  body { color: #000; background-color: #fff !important; }
	  body {
		width: 100%; height: 100%;
		/*
		background-image: url('<?php echo IMG_DIR ?>/report/reportDel_bg_circle.png'), url('<?php echo IMG_DIR ?>/report/reportDel_bg.png'); 
		background-position: center center, center center;
		background-repeat: no-repeat, no-repeat;
		background-size: 480px 480px, cover;
		*/
	  }

	  /* 화면용 배경 제거 */
	  body { background: none !important; }

	  /* 매 페이지 반복되는 고정 배경 */
	  .print-bg{
		position: fixed;
		inset: 0;                   /* 전체 페이지 커버 */
		z-index: 0;
		/* background: url(/img/bg.jpg) center/cover no-repeat; */
		background-image: url('<?php echo IMG_DIR ?>/report/reportDel_bg_circle.png'), url('<?php echo IMG_DIR ?>/report/reportDel_bg.png'); 
		background-position: center center, center center;
		background-repeat: no-repeat, no-repeat;
		background-size: 480px 480px, cover;

		/* 타일 패턴을 원하면 ↓ */
		/* background: url(/img/pattern.png) top left repeat; */
		/* background-size: 200px auto;  // 필요 시 조절 */
		/* opacity: .15; */               /* 워터마크 농도 */
		pointer-events: none;
	  }
	  .print-content{ position: relative; z-index: 1; }

	  /* 인쇄 레이아웃 깨짐 방지 */
	  /*
	  html, body { height: auto !important; overflow: visible !important; }
	  [style*="transform"], .transformed { transform: none !important; }
	  */


	  /* 화면 전용 UI 숨기기 */
	  .no-print, nav, header .btn, .floating, .modal, .toast, .video, .map { display: none !important; }

	  /* 콘텐츠 폭/폰트 */
	  .print-container { max-width: none !important; width: 100% !important; }
	  body { font-size: 12pt; }       /* 화면보다 살짝 키우면 가독 ↑ */

	  /* 링크: URL도 함께 출력 (내부앵커/전화/메일 제외) */
	  a[href^="#"], a[href^="tel:"], a[href^="mailto:"] { text-decoration: none; }
	  a[href]:after { content: " (" attr(href) ")"; font-size: 10pt; word-break: break-all; }

	  /* 이미지/도표 */
	  img, svg { max-width: 100% !important; page-break-inside: avoid; break-inside: avoid; }
	  figure { margin: 0 0 8pt; }
	  figcaption { font-size: 10pt; color: #333; }

	  /* 표 테이블 */
	  table { width: 100%; border-collapse: collapse; }
	  thead { display: table-header-group; }   /* 페이지 넘어가도 헤더 반복 */
	  tfoot { display: table-footer-group; }
	  tr, img, table, pre, blockquote { page-break-inside: avoid; break-inside: avoid; }
	  th, td { border: 1px solid #999; padding: 6pt; }

	  /* 페이지 나누기 제어 */
	  .page-break { page-break-before: always; break-before: page; }
	  h1, h2, h3 { page-break-after: avoid; break-after: avoid; }

	  /* 배경색/배경이미지 출력 (브라우저 설정에 좌우됨) */
	  /* 컬러/이미지 출력 보정 */
	  * { -webkit-print-color-adjust: exact; print-color-adjust: exact; }

	  /* position, transform 이슈 방지 */
	  [style*="position:sticky"], .sticky { position: static !important; }
	  [style*="transform"], .transformed { transform: none !important; }

	  /* fullpage/snap/스크롤 라이브러리 사용 시 */
	  .fp-section, .section, [data-fullpage] { height: auto !important; }
	  .fp-wrapper, .fp-container, .swiper, .slick-track { transform: none !important; height: auto !important; }
	  .swiper-slide, .slick-slide { width: auto !important; }


		
		.trans_bg {
			background: #ffffff !important; /* 프린트 시엔 완전 흰색 */
			color: #000000 !important;      /* 글자색은 검정으로 */
		}

		#topCopyright { width: 100%; height: 20px; margin-top: 30px; padding-top: 0px; }
		#topCopyright .copyText { padding-top: 0px; line-height: 20px; font-size: 13px; }

		#topLineBg {
			width: 100%; height: 45px; margin-top: 5px; line-height: 45px; font-size: 16px; 
			background-image:url('<?php echo IMG_DIR ?>/report/reportDel_topLineBg.png'); background-position: center center; background-repeat:no-repeat; background-size: cover cover; 
		}

		.ctnt_rpt { margin: 0 40px; }

		#topSubjectLogo { margin-top: 15px; }
		.report_subject { font-size: 23px; font-weight: 700; }
		.report_subtitle { font-size: 14px; font-weight: 500; }
		.report_topLogo {}
		.report_topLogo .topLogo { width: 120px; padding-bottom: 5px; }

		#sectBasicInfo {  }
		.sect_wrap { margin-top: 20px; }
		.sect_ttl { font-size: 17px; font-weight: bold; color: #008dd5; margin-bottom: 7px; }
		.sect_basic { background-color: #ffffff; padding: 12px 20px; }
		.sect_basic dl { margin: 0; padding: 0; }
		.sect_basic dl dt { margin: 0; padding: 0; font-size: 13px; font-weight: normal; }
		.sect_basic dl dd { margin: 0; padding: 0; font-size: 15px; font-weight: 700; margin-top: 2px;}

		.sect_tbl { text-align: left; border-top: 2px solid #707070; border-bottom: 1px solid #707070; padding-bottom: 5px; }
		.sect_tbl table {  width: 100%; border: none; vertical-align: middle; }
		.sect_tbl table th { font-size: 14px; background-color: #e9e6e3; height: 22px; vertical-align: middle; font-weight: 500; padding: 5px 15px; border: none; }
		.sect_tbl table td { font-size: 14px; padding: 3px 15px; border: none; }

		.sect_photo {}
		.sect_photo dl { width: 32%; display: inline-block; margin: 0; padding: 0; }
		.sect_photo dl dt { margin: 0; padding: 0; }
		.sect_photo dl dd { margin-top: 5px; margin-bottom: 15px; padding: 0; }
		.sect_photo .pic { width: 100%; max-width: 280px; height: 140px; overflow: hidden; background-color: #e9e6e3; } 
		.sect_photo .pic img { width: 100%; height: auto; }

		.sect_date {text-align: right; font-size: 18px; font-weight: 700; }
		
		.remann_copy {
			background-image: url('<?php echo IMG_DIR ?>/report/reportDel_sign.png'); 
			background-position: right bottom;
			background-repeat: no-repeat; 
			background-size: 81px 80px;
			height: 82px;
		}
		.remann_copy .copyLogo { text-align: right; font-size: 22px; font-weight: 800; margin-right: 40px; line-height: 45px; }
		.remann_copy .copyLogo > img { width: 140px; }

		.remann_copy .copyCompany { font-size: 22px; font-weight: 700; margin-right: 40px;}
		.remann_copy .copyCeo { font-size: 22px; }
		.remann_copy .copyCeo > span { font-weight: 700; margin-right: 50px; }

		.sect_cert { margin-top: 0; text-align: right; font-size: 16px; font-weight: 500; margin-top: 10px; }
	}
  </style>



  <div class="print-bg"></div>
  <div class="print-content bg-content">

	<div id="topCopyright">
	  <div class="ctnt_rpt">
		<div class="copyText">© 2025 주식회사 ABC. All rights reserved.</div>
	  </div>
	</div>
	
	<div id="topLineBg">
	  <div class="ctnt_rpt">
		<div class="dsp_flex_sp_between">
			<div>2025-08-12 00:00</div>
			<div>#Issuance Number 발급번호</div>
		</div>
	  </div>
	</div>
	
	<div id="topSubjectLogo">
	  <div class="ctnt_rpt">
		<div class="dsp_flex_sp_between">
			<div class="report_subject">데이터 삭제 보고서 <small class="report_subtitle">Data Erasure Report</small></div>
			<div class="report_topLogo dsp_flex_column_reverse"><img class="topLogo" src="<?php echo IMG_DIR ?>/report/reportDel_topLogo.png" /></div>
		</div>
	  </div>
	</div>


	
	<div id="sectBasicInfo" class="sect_wrap">
	  <div class="ctnt_rpt">
	
		<div class="sect_ttl">기본정보</div>
		<div class="sect_basic dsp_flex_sp_between">
	
			<dl class="dsp_flex_column">
				<dt>고객명</dt>
				<dd>고객명</dd>
			</dl>
	
			<dl class="dsp_flex_column">
				<dt>삭제 일시</dt>
				<dd>2025-08-12 12:23</dd>
			</dl>
	
			<dl class="dsp_flex_column">
				<dt>보안 책임자</dt>
				<dd>책임자명</dd>
			</dl>
	
			<dl class="dsp_flex_column">
				<dt>처리 담당자</dt>
				<dd>처리자명</dd>
			</dl>
	
			<dl class="dsp_flex_column">
				<dt>삭제 장소</dt>
				<dd>삭제 장소</dd>
			</dl>
	
		</div>
	  </div>
	</div>
	
	<div class="sect_wrap">
	  <div class="ctnt_rpt">
		<div class="sect_ttl">데이터 삭제 기기 정보</div>
		<div class="sect_tbl" style="">
			<table cellpadding="0" cellspacing="0">
				<tr>
					<th>종류</th>
					<th>제조사</th>
					<th>모델명</th>
					<th>검수 등급</th>
				</tr>
				<tr>
					<td>기기 종류</td>
					<td>제조사제조</td>
					<td>모델명asslddfjs-w2ddf</td>
					<td>검수 등급</td>
				</tr>
				<tr>
					<td>기기 종류</td>
					<td>제조사제조</td>
					<td>모델명asslddfjs-w2ddf</td>
					<td>검수 등급</td>
				</tr>
				<tr>
					<td>기기 종류</td>
					<td>제조사제조</td>
					<td>모델명asslddfjs-w2ddf</td>
					<td>검수 등급</td>
				</tr>
				<tr>
					<td>기기 종류</td>
					<td>제조사제조</td>
					<td>모델명asslddfjs-w2ddf</td>
					<td>검수 등급</td>
				</tr>
			</table>
		</div>
	  </div>
	</div>
	
	<div class="sect_wrap">
	  <div class="ctnt_rpt">
		<div class="sect_ttl">데이터 삭제 처리 정보</div>
		<div class="trans_bg sect_basic">
			<div class="dsp_flex_sp_between" style="width: 100%;">
				<dl class="dsp_flex_column">
					<dt>삭제방법</dt>
					<dd>파쇄</dd>
					<dd>천공</dd>
					<dd>디가우징</dd>
					<dd>SW삭제</dd>
				</dl>
				<dl class="dsp_flex_column">
					<dt>처리장치규격</dt>
					<dd>SS-200 SSD Shredder</dd>
					<dd>HARDDISK BORING</dd>
					<dd>ME-P3M</dd>
					<dd>Blancco Drive Eraser</dd>
				</dl>
				<dl class="dsp_flex_column">
					<dt>처리장치제조사</dt>
					<dd>주문제작</dd>
					<dd>주문제작</dd>
					<dd>주문제작</dd>
					<dd>Blancco</dd>
				</dl>
				<dl class="dsp_flex_column">
					<dt>관리 S/N</dt>
					<dd>N/A (파쇄에 따른 미확인)</dd>
					<dd>N/A (파쇄에 따른 미확인)</dd>
					<dd>N/A (파쇄에 따른 미확인)</dd>
					<dd>N/A (파쇄에 따른 미확인)</dd>
				</dl>
			</div>
		</div>
	  </div>
	</div>
	
	
	<div class="sect_wrap">
	  <div class="ctnt_rpt">
		<div class="sect_ttl">현장 사진</div>
		<div class="trans_bg sect_basic sect_photo">
	
			<div class="dsp_flex_sp_between">
	
				<dl class="dsp_flex_column">
					<dt>삭제 전 현장 사진</dt>
					<dd>
						<div class="pic"><img src="" style="" /></div>
					</dd>
				</dl>
	
				<dl class="dsp_flex_column">
					<dt>삭제 전 현장 사진</dt>
					<dd>
						<div class="pic"><img src="" style="" /></div>
					</dd>
				</dl>
	
				<dl class="dsp_flex_column">
					<dt>삭제 전 현장 사진</dt>
					<dd>
						<div class="pic"><img src="" style="" /></div>
					</dd>
				</dl>
	
			</div>
	
		</div>
	  </div>
	</div>
	
	
	<div class="sect_wrap" style="margin-top: 0px;">
		<div class="ctnt_rpt">
			<div class="sect_date">2025 년 08 월 01 일</div>
		</div>
	</div>
	
	
	<div class="sect_wrap" style="margin-top: 0px;">
		<div class="ctnt_rpt">
			<div class="dsp_flex_column_reverse remann_copy">
				<div class="dsp_flex_x_end">
					<div class="copyLogo">
						<img src="<?php echo IMG_DIR ?>/report/reportDel_bottomLogo.png" />
					</div>
					<div class="copyCompany">주식회사 리 맨</div>
					<div class="copyCeo">대표이사 <span>구 자 덕</span></div>
				</div>
			</div>
		</div>
	</div>
	
	<div class="sect_wrap" style="margin-top: 0px;">
		<div class="ctnt_rpt">
			<div class="sect_cert">
				ISO27001 인증 (정보보호 국제표준) · SERI R2V3 인증 (전자제품 재활용 국제표준)
			</div>
		</div>
	</div>

  </div>


