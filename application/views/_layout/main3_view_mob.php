
	<!-- 메인 탑 비주얼 배너 영역 -->
	<div class="main_top_bnr" style="background-image:linear-gradient( rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5) ), url('/assets/images/layout/main_top_banner_mob_1.png'); ">
		<div class="txt1">안녕하세요.</div>
		<div class="txt2">지구를 위해, 이웃을 위해 기부하는 RePlus 입니다.</div>
	</div>


	<!-- 진행중인 캠페인 목록 -->
	<div class="main_cmp">
		<div class="main_ctnt">

			<h3 class="cmp_subject">진행중인 캠페인 </h3>
			<hr class="cmp_subject_line" />

			<div class="cmp_list">
			  <ul class="row">
				<?php
				for($imgNo=1; $imgNo<=6; $imgNo++) { 
					$cmp_tag_bg_color = (($imgNo % 3) > 0 ) ? 'cmp_tag_bg_green' : 'cmp_tag_bg_blue';
				?>
				<li class="col-6">
					<div class="cmp_img_wrap">
					  <div class="cmp_img" style="background-image:linear-gradient( rgba(0, 0, 0, 0.2), rgba(0, 0, 0, 0.2) ),url('<?php echo IMG_DIR ?>/layout/main_cmp_<?php echo $imgNo ?>.png'); ">
						<div class="cmp_list_item">
							<div class="cmp_cate">[비영리 IT 지원센터]</div>
							<div class="cmp_ttl">교육센터 노트북 나눔센터</div>
							<div class="cmp_tag">
								<div><div class="cmp_tag_txt">#이웃을 위해</div><div class="cmp_tag_bg <?php echo $cmp_tag_bg_color ?>"></div></div>
								
							</div>
						</div>
					  </div>
					</div>
				</li>
				<?php } ?>
			  </ul>
			</div>

		</div>
	</div>




	<!-- 기부가치, 환경가치, 디바이스 수량 -->
	<div class="main_value">
		<div class="main_ctnt">

			<div class="val_box value_box_shadow value_box_roundbox" style="">
				<div class="row box_val_donate">
					<div class="col-5 box_val_ttl">
						<img src="<?php echo IMG_DIR ?>/layout/icon_val_donate.png" style="vertical-align:middle;" /> 기부 가치
					</div>
					<div class="col-7">
						<div class="box_val_amt">1,112,000,000 <span>원</span></div>
					</div>
				</div>
				<hr class="box_val_line" />
				<div class="row box_val_env">
					<div class="col-5 box_val_ttl">
						<img src="<?php echo IMG_DIR ?>/layout/icon_val_env.png" /> 환경 가치
					</div>
					<div class="col-7">
						<div class="box_val_amt">112,000,000 <span>원</span></div>
					</div>
				</div>
			</div>

			<div class="box_device">
				<div class="row">
					<div class="col-3">
						<div class="dev_icon"><img src="<?php echo IMG_DIR ?>/layout/ico_device_laptop.png" /></div>
						<div class="dev_title">노트북</div>
						<div class="dev_count">100</div>
					</div>
					<div class="col-3">
						<div class="dev_icon"><img src="<?php echo IMG_DIR ?>/layout/ico_device_desktop.png" /></div>
						<div class="dev_title">데스크탑</div>
						<div class="dev_count">200</div>
					</div>
					<div class="col-3">
						<div class="dev_icon"><img src="<?php echo IMG_DIR ?>/layout/ico_device_monitor.png" /></div>
						<div class="dev_title">모니터</div>
						<div class="dev_count">150</div>
					</div>
					<div class="col-3">
						<div class="dev_icon"><img src="<?php echo IMG_DIR ?>/layout/ico_device_tablet.png" /></div>
						<div class="dev_title">태블릿</div>
						<div class="dev_count">200</div>
					</div>
				</div>
			</div>

		</div>
	</div>



	<!-- 기부 절차 -->
	<div class="main_process">
		<div class="main_ctnt">

			<div class="proc_title">
			  <h3 class="proc_ttl_text">기부 절차</h3>
			  <div class="proc_ttl_line"></div>
			</div>
			<div class="proc_desc">
				Replus는 도움이 필요한 비영리 단체에 전국의 <br />
				기부자 및 기업의 지원을 이어드립니다.
			</div>
			<div class="proc_img">
				<img src="<?php echo IMG_DIR ?>/layout/mobile_main_process_img_1.png" />
			</div>

		</div>
	</div>




	<!-- News & CASE -->
	<div class="main_newscase">
		<div class="main_ctnt">

			<div class="newscase_title">
			  <h3 class="newscase_ttl_text">News & CASE</h3>
			  <div class="newscase_ttl_line"></div>
			</div>

			<div class="newscase_btn">
				기부 소식 보러 가기
			</div>

		</div>
	</div>


