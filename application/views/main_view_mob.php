	<!-- 메인 탑 비주얼 배너 영역 -->
	<style type="text/css">
	.wrap_main_top_bnr_mob .slick-prev {
		left: 50%;
		margin: 0 0 0 -48%;
		z-index: 100;
	}
	.wrap_main_top_bnr_mob .slick-prev:before {
		content: "";
		position: absolute;
		top: 50%;
		left: 50%;
		width: 29px;
		height: 29px;
		-webkit-transform: translate(-50%,-50%) rotate(45deg);
		-ms-transform: translate(-50%,-50%) rotate(45deg);
		transform: translate(-50%,-50%) rotate(45deg);
		margin-left: 10px;
		border-left: 1px solid #000;
		border-bottom: 1px solid #000;
	}


	.wrap_main_top_bnr_mob .slick-next {
		right: 50%;
		margin: 0 -48% 0 0;
		-webkit-transform: rotate(180deg) translateY(50%);
		-ms-transform: rotate(180deg) translateY(50%);
		transform: rotate(180deg) translateY(50%);
		z-index: 100;
	}
	.wrap_main_top_bnr_mob .slick-next:before {
		content: "";
		position: absolute;
		top: 50%;
		left: 50%;
		width: 29px;
		height: 29px;
		-webkit-transform: translate(-50%,-50%) rotate(45deg);
		-ms-transform: translate(-50%,-50%) rotate(45deg);
		transform: translate(-50%,-50%) rotate(45deg);
		margin-left: 10px;
		border-left: 1px solid #000;
		border-bottom: 1px solid #000;
	}

	#mob_cmp_list { width: 100%; height: auto !important; overflow: hidden; }
	</style>

	<div class="wrap_main_top_bnr_mob">
	  <?php foreach($arr_img_bnr_mobile as $i => $bnr) {
		$click_event = 'return false;';
		if( isset($bnr->bn_link) && '' != $bnr->bn_link ) {
			$click_event = '';
		}
	  ?>
	   <a href="<?php echo $bnr->bn_link ?>" target="<?php echo $bnr->bn_target ?>" onclick="<?php echo $click_event; ?>">
		<div class="main_top_bnr" style="background-image:url('<?php echo $bnr->banner_src ?>'); ">
			<div class="txt"><?php echo nl2br($bnr->bn_memo) ?></div>
		</div>
	   </a>
	  <?php } ?>
	</div>

	<script type="text/javascript">
	$(document).ready(function(){
	  $('.wrap_main_top_bnr_mob').not('.slick-initialized').slick({
		  slidesToShow: 1,
		  slidesToScroll: 1,
		  dots: false,
		  autoplay: true,
		  autoplaySpeed: 5000,
		  arrows: false,
	  });
	});
	</script>






	<style type="text/css">
	.main_cmp_items_mob { position: relative; }
	.main_cmp_items_mob .slick-prev {
		left: -20px;
		z-index: 100;
	}
	.main_cmp_items_mob .slick-prev:before {
		content: "";
		position: absolute;
		top: 50%;
		left: 50%;
		width: 18px;
		height: 18px;
		-webkit-transform: translate(-50%,-50%) rotate(45deg);
		-ms-transform: translate(-50%,-50%) rotate(45deg);
		transform: translate(-50%,-50%) rotate(45deg);
		margin-left: 10px;
		border-left: 3px solid #000;
		border-bottom: 3px solid #000;
	}


	.main_cmp_items_mob .slick-next {
		right: -20px;
		-webkit-transform: rotate(180deg) translateY(50%);
		-ms-transform: rotate(180deg) translateY(50%);
		transform: rotate(180deg) translateY(50%);
		z-index: 100;
	}
	.main_cmp_items_mob .slick-next:before {
		content: "";
		position: absolute;
		top: 50%;
		left: 50%;
		width: 18px;
		height: 18px;
		-webkit-transform: translate(-50%,-50%) rotate(45deg);
		-ms-transform: translate(-50%,-50%) rotate(45deg);
		transform: translate(-50%,-50%) rotate(45deg);
		margin-left: 10px;
		border-left: 3px solid #000;
		border-bottom: 3px solid #000;
	}
	</style>


	<!-- 진행중인 캠페인 목록 -->
	<div class="main_cmp">
		<div class="main_ctnt">

			<div>
			  <h3 class="sect_ttl_text font_common font_sect_ttl">최근 캠페인</h3>
			  <div class="sect_ttl_line"></div>
			</div>

			<div id="mob_cmp_list" class="cmp_list">
			  <ul id="main_cmp_items_mob" class="main_cmp_items_mob">
				<?php
				foreach($cmp_list as $kcnt => $cmp) {
				?>
				<li>
				  <a href="/campaign/detail/<?php echo $cmp->code ?>" class="" style="text-decoration:none;">
					<div style="border:1px solid #cecece;">
						<div class="cmp_img" style="width:100%; height: 30vw; background-image:url('<?php echo $cmp->campaign_main_src ?>');  background-size:cover; background-position:center center;"></div>
						<div class="cmp_list_item" style="border-top:1px solid #cecece; ">
							<div class="cmp_ttl ellipsis2" style="height: 38px;"><?php echo $cmp->cmp_title ?></div>
							<div class="cmp_cate ellipsis"><?php echo $cmp->cmp_org_name ?></div>

							<div style="padding: 10px 0 0 10px; text-align: right;">
								<button class="btn btn-green-line btn-sm" type="button" style="border-radius:22px; padding: 5px 15px;">기부하기</button>
							</div>

						</div>
					</div>
				  </a>
				</li>
				<?php } ?>
			  </ul>
			</div>

		</div>
	</div>

	<script type="text/javascript">
	$(document).ready(function(){
		$('#main_cmp_items_mob').slick({
		  infinite: true,
		  slidesToShow: 2,
		  slidesToScroll: 2,
		  dots: false,
		  autoplay: true,
		  autoplaySpeed: 3000,
		});
	});
	</script>



	<!-- 기부가치, 환경가치, 디바이스 수량 v2 -->
	<div class="main_ctnt">
		<div class="mt-5">
		  <h3 class="sect_ttl_text font_common font_sect_ttl">현재까지 누적된 사회적 가치</h3>
		  <div class="sect_ttl_line"></div>
		</div>
	</div>

	<?php // if('183.103.162.165' == REMOTE_ADDR  ||  '220.95.117.166' == REMOTE_ADDR) { ?>

	<style>
	  #mob_main_values { padding: 20px; }
	   .mob_val_ttl_wrap { background-color: #00a0df8f; padding: 12px 16px 8px; }
	   .mob_val_ttl { font-size: 15px; font-weight: bold; }
	   .mob_val_ttl_cnt,
	   .mob_val_ttl_amt { font-size: 24px; font-weight: 500; color: #ffffff; font-family: 'NanumGothicBold'; }
	   .mob_val_ttl_cnt span, .mob_val_ttl_amt span { font-size: 17px; font-weight: normal; }

	   .mob_val_ctnt_wrap { margin-top: 8px; background-color: rgb(48, 175, 222, 0.17); padding: 15px 16px 15px; width: 100%; } /* 백그라운드 칼라만 opacity 적용  */
	   .mob_val_ctnt_wrap h4 { color: #1a1a1a; }
	   .mob_val_ctnt_ttl h4 { font-size: 14px; font-weight: bold; color: #1a1a1a; }

	   .mob_dev_img_bg { border: none; width: 5vw; max-width: 50px; height: 30px; background-repeat: no-repeat; background-size: 100% auto; background-position: bottom right; background-position: top center; }
	   .mob_dev_img_lt { background-image:url('/assets/images/layout/val_img_lt_250102.png'); }
	   .mob_dev_img_dt { background-image:url('/assets/images/layout/val_img_dt_250102.png'); }
	   .mob_dev_img_mt { background-image:url('/assets/images/layout/val_img_mt_250102.png'); }
	   .mob_dev_img_tablet { background-image:url('/assets/images/layout/val_img_tablet_250102.png'); }

	   .mob_ctnt_box_blue { width: 24%; position: relative; padding: 10px 5px; border: none; background-color: #ffffff; color: #70caed; }
	   .mob_dev_box { width: 100%; /* width: calc(100% - 70px); */ text-align: right; }

	   .mob_dev_nm { color: #70caed; font-size: 12px; }
	   .mob_dev_cnt { color: #70caed; font-size: 17px; font-weight: bold; padding-right: 4px; }

	   .mob_ctnt_box_blue_2 { width: 49.5%; position: relative; padding: 10px 12px; border: none; background-color: #ffffff; color: #70caed; }



	  .mob_ctnt_box_green { position: relative; padding: 0; border: none; background-color: #ffffff; color: #549732; }

	  .mob_ctnt_box_green .amt_box { width: 100%; }
	  .mob_ctnt_box_green .amt_box .amt_nm { font-size: 16px; font-weight: 600; }
	  .mob_ctnt_box_green .amt_box .amt_desc { font-size: 11px; font-weight: normal; color: #535352; margin-top: 3px; }
	  .mob_ctnt_box_green .amt_cnt { margin-top: 10px; font-size: 17px; text-align: right; padding-right: 0px; font-weight: 700; }

	  .mob_std_date { text-align: right; font-size: 13px; margin-top: 5px; }

	  .amt_img_bg { border: none; background-repeat: no-repeat; background-size: auto 100%; background-position: top right; background-size: 30px auto; }
	  .amt_img_dn { background-image:url('/assets/images/layout/val_img_dn_250102.png'); }
	  .amt_img_env { background-image:url('/assets/images/layout/val_img_env_250102.png'); }
	</style>

	<div id="mob_main_values">

		<div class="mob_val_ttl_wrap radius_5">
			<div class="mob_val_ttl"><?php echo $arc_row->date_str ?> 기부참여</div>
			<div class="dsp_flex_sp_between">
				<div class="mob_val_ttl_cnt"><span>총</span> <?php echo $arc_row->cnt_device ?> <span>대</span></div>
				<div class="mob_val_ttl_amt"><?php echo $arc_row->cnt_amt ?> <span>원</span></div>
			</div>
		</div>

		<div class="mob_val_ctnt_wrap radius_5">

			<div class="mob_val_ctnt_ttl">
				<h4>기기별 기부 누적 현황 (대)</h4>
			</div>
			<div class="mob_val_ctnt_box dsp_flex_sp_between">
				
				<div class="radius_5  mob_ctnt_box_blue  dsp_flex_column">
					<div class="dsp_flex_sp_around">
						<div class="mob_dev_img_bg mob_dev_img_lt"></div>
						<div class="mob_dev_nm">노트북</div>
					</div>
					<div class="mob_dev_box dsp_flex_sp_between">
						<div></div>
						<div class="mob_dev_cnt"><?php echo $arr_cnt_devices->lt ?></div>
					</div>
				</div>

				<div class="radius_5  mob_ctnt_box_blue  dsp_flex_column">
					<div class="dsp_flex_sp_around">
						<div class="mob_dev_img_bg mob_dev_img_dt"></div>
						<div class="mob_dev_nm">데스크탑</div>
					</div>
					<div class="mob_dev_box dsp_flex_sp_between">
						<div></div>
						<div class="mob_dev_cnt"><?php echo $arr_cnt_devices->dt ?></div>
					</div>
				</div>

				<div class="radius_5  mob_ctnt_box_blue  dsp_flex_column">
					<div class="dsp_flex_sp_around">
						<div class="mob_dev_img_bg mob_dev_img_mt"></div>
						<div class="mob_dev_nm">모니터</div>
					</div>
					<div class="mob_dev_box dsp_flex_sp_between">
						<div></div>
						<div class="mob_dev_cnt"><?php echo $arr_cnt_devices->mt ?></div>
					</div>
				</div>

				<div class="radius_5  mob_ctnt_box_blue  dsp_flex_column">
					<div class="dsp_flex_sp_around">
						<div class="mob_dev_img_bg mob_dev_img_tablet"></div>
						<div class="mob_dev_nm">태블릿</div>
					</div>
					<div class="mob_dev_box dsp_flex_sp_between">
						<div></div>
						<div class="mob_dev_cnt"><?php echo $arr_cnt_devices->tablet ?></div>
					</div>
				</div>

			</div>

			<div class="mob_val_ctnt_ttl mt-3">
				<h4>환산 누적 가치 (원)</h4>
			</div>
			<div class="mob_val_ctnt_box_2  dsp_flex_sp_between">

				<div class="radius_5  mob_ctnt_box_blue_2  dsp_flex_column">
					<div class="radius_10 dsp_flex_column mob_ctnt_box_green  amt_img_bg amt_img_dn">
						<div class="amt_box">
							<div class="amt_nm">기부 가치</div>
							<div class="amt_desc">기부한 물품을<br />공정가치로 환산한 금액</div>
						</div>
						<div class="amt_cnt dsp_flex_x_end"><?php echo $arr_amt_value->dn_mob ?></div>
					</div>
				</div>

				<div class="radius_5  mob_ctnt_box_blue_2  dsp_flex_column">
					<div class="radius_10 dsp_flex_column mob_ctnt_box_green  amt_img_bg amt_img_env">
						<div class="amt_box">
							<div class="amt_nm">환경 가치</div>
							<div class="amt_desc">재사용 · 재활용하여<br />절감된 경제적 가치</div>
						</div>
						<div class="amt_cnt dsp_flex_x_end"><?php echo $arr_amt_value->env_mob ?></div>
					</div>
				</div>

			</div>

			<div class="mob_std_date dsp_flex_x_end"><?php echo $arc_row->std_date ?></div>

		</div>

	</div>
	<?php // } ?>



	<!-- 리플러스 소개 -->
	<div class="main_process">
		<div class="main_ctnt">

			<div>
			  <h3 class="sect_ttl_text font_common font_sect_ttl">리플러스 소개</h3>
			  <div class="sect_ttl_line"></div>
			</div>

			<div class="proc_desc font_sect_ctnt" style="text-align:left;">
				REPLUS는 도움이 필요한 비영리 단체에 전국의 기부자 및 기업의 지원을 이어드립니다.
			</div>

			<div class="my-4">
				<a href="<?php echo base_url('H/GUIDE/기부-절차-안내') ?>"><img src="<?php echo IMG_DIR ?>/replus/btn_bnr_1-2.png?v=1" style="width: 100%;" /></a>
			</div>
			<div>
				<a href="<?php echo base_url('recycle') ?>"><img src="<?php echo IMG_DIR ?>/replus/btn_bnr_2-2.png?v=1" style="width: 100%;" /></a>
			</div>

		</div>
	</div>



	<?php if($utube_use == 'Y') { ?>
	<!-- 리플러스 소개 영상 -->
	<div class="main_process">
		<div class="main_ctnt">

			<!-- <div>
			  <h3 class="sect_ttl_text font_common font_sect_ttl">리플러스 소개 영상</h3>
			  <div class="sect_ttl_line"></div>
			</div> -->


			<!-- 가로형 영상 (자동재생 + 반복) -->
			<div class="video_wrap video_16x9">
				<?php echo $utube_ctnt ?>
			</div>

		</div>
	</div>
	<?php } ?>


	<!-- News & Case -->
	<div class="main_newscase">
		<div class="main_ctnt">

			<div class="newscase_title">
			  <h3 class="newscase_ttl_text">News & Case</h3>
			  <div class="newscase_ttl_line"></div>
			</div>

			<a href="/board/newsncase/lists/page/1" style="text-decoration:none;">
			  <div class="newscase_btn">기부 소식 보러 가기</div>
			</a>

		</div>
	</div>


