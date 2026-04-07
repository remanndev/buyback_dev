<style type="text/css">
	#cmp_cmt_wrap { margin-top: 20px; }

	#cmp_cmt_wrap .cmp_cmt_outline { padding: 20px 10px 0; }

	#cmp_cmt_wrap .cmt_ttl { font-size: 16px; font-weight: bold; margin-bottom: 0; padding: 0; }
	#cmp_cmt_wrap .cmp_row_line { margin: 5px 0 10px; }


	#cmp_cmt_wrap .cmp_list_item .cmp_ttl { font-size: 14px; font-weight: bold; }
	#cmp_cmt_wrap .cmp_list_item .cmp_org { font-size: 13px; color: #535353; font-weight: normal; }



</style>

	<div id="cmp_cmt_wrap" class="cmp_wrap">
	  <div class="main_sect">

		<div class="cmp_cmt_outline roundbox_5" style="border: 1px solid silver;">

		  <h3 class="cmt_ttl">같이 기부해요</h3>

		  <hr class="cmp_row_line" />

		  <div class="cmp_list">
			<?php
			foreach($list_random_2 as $key => $cmp) {

				if( $key > 5 )
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

				<div style="margin:10px 0;">
				  <a href="/campaign/detail/<?php echo $cmp->code ?>" class="" style="text-decoration:none;">

					<div class="row">
					  <div class="col-5">
						<div class="cmp_img_wrap">
						  <div class="cmp_img" style="border: 1px solid rgb(213, 213, 213); height: 80px; background-image:url('<?php echo $cmp->campaign_main_src ?>'); background-size:cover; background-repeat:no-repeat; "></div>
						</div>
					  </div>
					  <div class="col-7" style="padding-left: 0;">
					    <div class="dsp_flex_column  dsp_flex_xy_center" style="height: 100%;">
						  <div class="cmp_list_item">
							<div class="cmp_ttl ellipsis2"><?php echo $cmp->cmp_title ?></div>
							<div class="cmp_org ellipsis2"><?php echo $cmp->cmp_org_name ?></div>
						  </div>
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

