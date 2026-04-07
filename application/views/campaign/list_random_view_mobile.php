
	<div class="cmp_wrap">
	  <div class="main_sect">
		<!-- <div class="main_ctnt"> -->
		<div>

		  <h3>진행중인 다른 캠페인</h3>

		  <div class="cmp_list">
			<?php
			foreach($list_random as $key => $cmp) {

				if( $key > 1 )
					break;

				$cmp_cate_bg_color = '';
				$cmp_cate_line_color = '';

				if('지구를 위해' == $cmp->cmp_cate) {
					$cmp_cate_line_color = 'cmp_cate_line_blue';
					//$cmp_cate_bg_color = 'cmp_cate_bg_blue';
				}
				elseif('이웃을 위해' == $cmp->cmp_cate) {
					$cmp_cate_line_color = 'cmp_cate_line_green';
					//$cmp_cate_bg_color = 'cmp_cate_bg_green';
				}
			?>
				<hr class="cmp_row_line" />

				<div style="margin:10px 0;">
				  <a href="/campaign/detail/<?php echo $cmp->code ?>" class="" style="text-decoration:none;">

					<div class="row">
					  <div class="col-4">
						<div class="cmp_img_wrap">
						  <!-- <?php /* <div class="cmp_img" style="height: 100px; background-image:linear-gradient( rgba(0, 0, 0, 0.2), rgba(0, 0, 0, 0.2) ),url('<?php echo $cmp->campaign_main_src ?>'); background-size:cover; background-repeat:no-repeat; "></div> */ ?> -->
						  <div class="cmp_img" style="border: 1px solid rgb(213, 213, 213); height: 100px; background-image:url('<?php echo $cmp->campaign_main_src ?>'); background-size:cover; background-repeat:no-repeat; "></div>
						</div>
					  </div>
					  <div class="col-8">
						<div class="cmp_list_item">
							<div class="cmp_org">[<?php echo $cmp->cmp_org_name ?>]</div>
							<div class="cmp_ttl ellipsis"><?php echo $cmp->cmp_title ?></div>
							<?php if($cmp->cmp_cate != '') { ?>
							<!-- <div class="cmp_category">
							  <div class="cmp_cate_round <?php echo $cmp_cate_line_color ?>">
								<div class="cmp_tag_txt">#<?php echo $cmp->cmp_cate ?></div>
							  </div>
							</div> -->
							<?php } ?>
							<div class="cmp_term"><?php echo $cmp->cmp_term_begin ?> ~ <?php echo $cmp->cmp_term_end ?></div>
						</div>
					  </div>
					</div>

				  </a>
				</div>

			<?php } ?>

			</div>
		</div>
	  </div>
	</div>

