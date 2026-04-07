<?php 
	// [2023-05-25] 메인 페이지 && 서브 페이지인 공통
	$class_pagetype = 'sub';
	$class_header_area = 'header_area';
	$class_scrolled = 'scrolled';
	$class_logo_img = 'logo_color_resize.png';
	$class_util_img_join = 'icon_join_gray.png';
	$class_util_img_login = 'icon_login_gray.png';
?>
<style type="text/css">
	.header_recycle { height: 90px; background-color: #162c4d; }
	.header_wrap { height: 90px; }
	.header_wrap .header_max { width: 100%; max-width: 1100px; height: 100%; margin: 0 auto; }

	.header_wrap .top_logo { padding-left: 15px; }
	.header_wrap .top_logo img { height: 40px; }
	.header_wrap .top_nav { width: 100%; padding-top: 5px; padding-left: 25px; }
	.header_wrap .top_nav > a { padding-top: 10px; color: #ffffff; font-size: 20px; font-weight: bold; }
	.header_wrap .top_nav > a::before {
		content:"|";
		display:inline-block;
		width:25px;
		height:40px;
	}
	.header_wrap .top_util {
		right: 15px;
	}
	.header_wrap .top_util > a {
		color: #ffffff; font-size: 16px; font-weight: normal; 
	}

	@media screen and (max-width: 991px) {
		.header_recycle { height: 80px; background-color: #162c4d; }
		.header_wrap { height: 80px; }
		.header_wrap .top_logo { padding-left: 20px; }
		.header_wrap .top_logo img { width: 100px; height: auto; }

		.header_wrap .top_nav { width: 100%; padding-top: 5px; padding-left: 15px; }
		.header_wrap .top_nav > a { padding-top: 10px; color: #ffffff; font-size: 18px; font-weight: bold; }
		.header_wrap .top_nav > a::before {
			content:"|";
			display:inline-block;
			width:15px;
			height:40px;
		}

	}



</style>

	<!-- 헤더영역 -->
	<div class="header_recycle">
		<div class="header_wrap">
		  <div class="header_max dsp_flex_y_center">
			<div class="top_logo">
				<a href="<?php echo base_url() ?>"><img src="<?php echo IMG_DIR ?>/layout/<?php echo $class_logo_img ?>" /></a>
			</div>
			<div class="top_nav dsp_flex_sp_between dsp_flex_y_center" style="">
				<a href="<?php echo base_url('recycle') ?>">리사이클 센터</a>
				<div class="top_util">
					<?php if ($this->tank_auth->is_logged_in()) {									// logged in ?>
					  <a href="/auth/logout"><span>로그아웃</a></a>
					<?php } else { ?>
					  <a href="/auth/login"><span>로그인</span></a>
					<?php } ?>
				</div>
			</div>
		  </div>
		</div>
	</div>

