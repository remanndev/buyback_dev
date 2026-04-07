
	<!-- 메인 탑 비주얼 배너 영역 -->
	<div class="main_top_bnr" style="background-image:linear-gradient( rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5) ), url('/assets/images/layout/main_top_banner_1.png'); ">
		<div class="txt1">안녕하세요.</div>
		<div class="txt2">지구를 위해, 이웃을 위해 기부하는 RePlus 입니다.</div>
	</div>


	<!-- 진행중인 캠페인 목록 -->
	<div class="main_cmp">
	  <div class="main_sect">
		<div class="main_ctnt">

			<h3 class="cmp_subject">진행중인 캠페인 </h3>
			<hr class="cmp_subject_line" />

			<div class="cmp_list">
			  <ul class="row">
				<?php
				foreach($cmp_list as $kcnt => $cmp) {
					//$cmp_tag_bg_color = (($kcnt % 2) > 0 ) ? 'cmp_tag_bg_green' : 'cmp_tag_bg_blue';
					$cmp_tag_bg_color = 'cmp_tag_bg_blue';
				?>
				<li class="col-4">
				  <a href="/campaign/detail/<?php echo $cmp->code ?>" class="" style="text-decoration:none;">
					<div class="cmp_img_wrap">
					  <div class="cmp_img" style="background-image:linear-gradient( rgba(0, 0, 0, 0.2), rgba(0, 0, 0, 0.2) ),url('<?php echo $cmp->campaign_main_src ?>'); ">
						<div class="cmp_list_item">
							<div class="cmp_cate">[비영리 IT 지원센터]</div>
							<div class="cmp_ttl"><?php echo $cmp_first->cmp_title ?></div>
							<div class="cmp_tag">
								<div class="cmp_tag_txt">#이웃을 위해</div>
								<div class="cmp_tag_bg <?php echo $cmp_tag_bg_color ?>"></div>
							</div>
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
	</div>


	<!-- 가치 및 디바이스 수량 -->
	<div class="main_value">
	  <div class="main_sect">
		<div class="main_ctnt">
			<div class="row">
			<?php
			foreach($result_amount['qry'] as $cnt => $row) { 
				if('기부 가치' == $row->amt_title OR '기부가치' == $row->amt_title) {
					$box_val_class = 'box_val_donate';
					$box_val_icon = 'icon_val_donate.png';
				}
				elseif('환경 가치' == $row->amt_title OR '환경가치' == $row->amt_title) {
					$box_val_class = 'box_val_env';
					$box_val_icon = 'icon_val_env.png';
				}
			?>
				<div class="col-6">
					<div class="box_value <?php echo $box_val_class ?>">
						<img src="<?php echo IMG_DIR ?>/layout/<?php echo $box_val_icon ?>" style="width:62px; height:61px;" /> <?php echo $row->amt_title ?>
					</div>
					<hr class="box_val_line" />
					<div class="box_val_amt"><?php echo number_format($row->amt_value) ?> <span>원</span></div>
				</div>
			<?php } ?>
			</div>
			<div class="box_device">
				<div class="row">
				<?php
				foreach($result_device['qry'] as $cnt => $row) { 
					if('노트북' == $row->device_name) {
						$device_icon = 'ico_device_laptop.png';
					}
					elseif('데스크탑' == $row->device_name) {
						$device_icon = 'ico_device_desktop.png';
					}
					elseif('모니터' == $row->device_name) {
						$device_icon = 'ico_device_monitor.png';
					}
					elseif('태블릿' == $row->device_name) {
						$device_icon = 'ico_device_tablet.png';
					}
					else {
						$device_icon = '';
					}
				?>
					<div class="col-3">
						<div class="dev_icon"><img src="<?php echo IMG_DIR ?>/layout/<?php echo $device_icon ?>" style="width:42px; height:42px;" /></div>
						<div class="dev_title"><?php echo $row->device_name ?></div>
						<div class="dev_count"><?php echo $row->device_amount ?></div>
					</div>
				<?php } ?>
				</div>
			</div>

		</div>
	  </div>
	</div>


	<!-- 기부 절차 -->
	<div class="main_process">
	  <div class="main_sect">
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
				<img src="<?php echo IMG_DIR ?>/layout/main_process_img_1.png" />
			</div>

		</div>
	  </div>
	</div>

	<hr class="only_line" />


	<div class="main_news">
	  <div class="main_sect">
		<div class="main_ctnt">

			<div class="news_title">
			  <h3 class="news_ttl_text">News & CASE</h3>
			  <div class="news_ttl_line"></div>
			</div>
			<div class="news_list">
			  <div class="row">

				<div class="col-6">
					<div class="news_item">
						<div class="news_img" style="background-image:url('<?php echo IMG_DIR ?>/layout/campaign_img.png');"></div>
						<div class="news_text">
							<div class="text_cate text_blue">[News]</div>
							<div class="text_ttl">03. 음식이 주는 배부름과 행복</div>
							<div class="text_date">2022-08-16</div>
						</div>
					</div>
				</div>

				<div class="col-6">
					<div class="news_item">
						<div class="news_img" style="background-image:url('<?php echo IMG_DIR ?>/layout/campaign_img.png');"></div>
						<div class="news_text">
							<div class="text_cate text_green">[CASE]</div>
							<div class="text_ttl">03. 음식이 주는 배부름과 행복</div>
							<div class="text_date">2022-05-10</div>
						</div>
					</div>
				</div>

			  </div>
			</div>

		</div>
	  </div>
	</div>
