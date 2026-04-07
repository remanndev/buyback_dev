<?php
/*
$seg1 = $this->uri->segment(1);
//echo $seg1.'<<<<<<<<<';

// 메인 페이지인 경우,
$class_pagetype = 'main';
$class_header_area = '';
$class_scrolled = '';
$class_logo_img = 'logo_white_resize.png';
$class_util_img_join = 'icon_join.png';
$class_util_img_login = 'icon_login.png';

if($seg1 != '') {
	// 서브 페이지인 경우,
	$class_pagetype = 'sub';
	$class_header_area = 'header_area';
	$class_scrolled = 'scrolled';
	$class_logo_img = 'logo_color_resize.png';
	$class_util_img_join = 'icon_join_gray.png';
	$class_util_img_login = 'icon_login_gray.png';
}
*/


// [2023-05-25] 메인 페이지 && 서브 페이지인 공통
$class_pagetype = 'sub';
$class_header_area = 'header_area';
$class_scrolled = 'scrolled';
//$class_logo_img = 'logo_color_resize.png';
$class_util_img_join = 'icon_join_gray.png';
$class_util_img_login = 'icon_login_gray.png';

// [2024-10-15] 
$class_logo_img = 'replus_logo_color_202410.png';


$active = array('campaign'=>'', 'sharecampaign'=>'', 'people'=>'', 'guide'=>'', 'faq'=>'', 'notice'=>'');

if(isset($arr_seg[1]) && $arr_seg[1] == 'campaign') {
	$active['campaign'] = 'active';
}
elseif( (isset($arr_seg[1]) && $arr_seg[1] == 'sharecampaign') OR ( isset($arr_seg[2]) && $arr_seg[2] == 'SHARECAMPAIGN' ) ) {
	$active['sharecampaign'] = 'active';
}
elseif( isset($arr_seg[2]) && $arr_seg[2] == 'PEOPLE' ) {
	$active['people'] = 'active';
}
elseif( isset($arr_seg[2]) && $arr_seg[2] == 'GUIDE' ) {
	$active['guide'] = 'active';
}
elseif( isset($arr_seg[2]) && $arr_seg[2] == 'FAQ' ) {
	$active['faq'] = 'active';
}
elseif( isset($arr_seg[2]) && $arr_seg[2] == 'notice' ) {
	$active['notice'] = 'active';
}

// 로그인 한 회원의 이름
$nick_name = '';
if ($this->tank_auth->is_logged_in()) {
	$user_idx = $this->tank_auth->get_user_id();
	$user = isset($user_idx) ? $this->users->get_user_by_id($user_idx, TRUE) : false; // TRUE 는 'activated 회원'만을 의미
	$nick_name = isset($user->nickname) ? $user->nickname : '';
}
?>
	<!-- [Common] 헤더영역 -->
	<input type="hidden" id="pagetype" value="<?php echo $class_pagetype ?>" />

	<!-- [PC] 헤더영역 -->
	<div class="pc_wrap d-none d-lg-block">
	  <div class="<?php echo $class_header_area; ?>">
		<div class="header_wrap <?php echo $class_scrolled; ?>">
		  <div class="header_max dsp_flex_sp_between">

			<div class="top_logo"><a href="<?php echo base_url() ?>"><img src="<?php echo IMG_DIR ?>/layout/<?php echo $class_logo_img ?>" /></a></div>
			<div class="top_nav">
			  <div class="top_nav_center">
				<a href="/campaign/lists" class="<?php echo $active['campaign']; ?>" >기부캠페인</a>
				<!-- <a href="/B/SHARECAMPAIGN/나눔신청" class="<?php echo $active['sharecampaign']; ?>" >나눔신청</a> -->
				<a href="/B/PEOPLE/함께-하는-기관" class="<?php echo $active['people']; ?>">함께하는기관</a>
				<a href="/H/GUIDE/기부절차안내" class="<?php echo $active['guide']; ?>">기부안내</a>
				<a href="/B/FAQ/자주-묻는-질문" class="<?php echo $active['faq']; ?>">FAQ</a>
				<!-- <a href="/board/notice/lists" class="<?php echo $active['notice']; ?>">공지사항</a> -->
			  </div>
			</div>
			<div class="top_util">
			  <div style="">
				<?php if ($this->tank_auth->is_logged_in()) {									// logged in ?>
				  <a href="/mypage"><img class="ic_join" src="<?php echo IMG_DIR ?>/layout/<?php echo $class_util_img_join ?>" /> <span>마이페이지</span></a>
				  <a href="/auth/logout"><img class="ic_login" src="<?php echo IMG_DIR ?>/layout/<?php echo $class_util_img_login ?>" /> <span>로그아웃</a></a>
				<?php } else { ?>
				  <!-- <a href="/auth/register"><img class="ic_join" src="<?php echo IMG_DIR ?>/layout/<?php echo $class_util_img_join ?>" /> <span>회원가입</span></a> -->
				  <a href="/auth/login/<?php echo url_code(base_url($this->uri->uri_string()), 'e') ?>"><img class="ic_login" src="<?php echo IMG_DIR ?>/layout/<?php echo $class_util_img_login ?>" /> <span>로그인</span></a>
				<?php } ?>
			  </div>
			</div>

		  </div>
		</div>
	  </div>
	</div>


	<!-- [MOBILE] 헤더영역 -->
	<div class="mobile_wrap d-block d-lg-none">
	  <div class="<?php echo $class_header_area; ?>">
		<div class="header_wrap <?php echo $class_scrolled; ?>">

			<div class="top_logo"><a href="<?php echo base_url() ?>"><img src="<?php echo IMG_DIR ?>/layout/<?php echo $class_logo_img ?>" /></a></div>

			<div class="navbar" style="height: 100%;">

				<!-- mobile nav icon : open -->
				<a href="/" onclick="return false;" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRightMobile" aria-controls="offcanvasRightMobile">
				  <div class="hamberger_btn">
					<img src="<?php echo IMG_DIR ?>/replus/mob_hamberger_btn.png" style="width: 18px;" />
				  </div>
				</a>

				<!-- mobile nav icon : wrap -->
				<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRightMobile" aria-labelledby="offcanvasRightMobileLabel">
				  <div class="offcanvas-header" style="padding-right: .5rem;">
					<h5 id="offcanvasRightMobileLabel">

						<div class="dsp_flex_sp_between dsp_flex_y_center">
						  <?php if ($this->tank_auth->is_logged_in()) {									// logged in ?>
							<div style="font-size: 15px;"><?php echo $nick_name ?>님 안녕하세요!</div>
							<a href="/auth/logout" class="btn btn-sm btn-info" style="background-color: #00a4ff; color: #ffffff; border: 1px solid #00a4ff; ">로그아웃</a>
						  <?php } else { ?>
							<img src="<?php echo IMG_DIR ?>/layout/<?php echo $class_logo_img ?>" style="height: 20px;" />
							<a href="/auth/login" class="btn btn-sm btn-info" style="background-color: #00a4ff; color: #ffffff; border: 1px solid #00a4ff; ">로그인</a>
						  <?php } ?>
						</div>

						<?php /*
						<div class="btn-group" style="display:flex;" role="group" aria-label="Basic example">
						  <?php if ($this->tank_auth->is_logged_in()) {									// logged in ?>
						  <a href="/mypage" class="btn btn-sm btn-outline-dark">마이페이지</a>
						  <a href="/auth/logout" class="btn btn-sm btn-outline-dark">로그아웃</a>
						  <?php } else { ?>
						  <a href="/auth/login" class="btn btn-sm btn-outline-dark">로그인</a>
						  <!-- <a href="/auth/register" class="btn btn-sm btn-outline-dark">회원가입</a> -->
						  <?php } ?>
						  <!-- <a href="/search" class="btn btn-sm btn-outline-dark">검색</a> -->
						</div>
						*/ ?>

					</h5>
					<!-- mobile nav icon : close -->
					<a href="#" onclick="return false;" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRightMobile" aria-controls="offcanvasRightMobile">
					  <div class="hamberger_btn_close">
						<div class="bar1"></div>
						<div class="bar2"></div>
						<div class="bar3"></div>
					  </div>
					</a>
				  </div>
				  <div class="offcanvas-body">

					<h5>마이페이지</h5>
					<style>
					.mob_nav_mypage { width: 100%; }
					.mob_nav_mypage img { width: 94%; max-width: 100px; }
					</style>
					<div class="mob_nav_mypage dsp_flex_sp_between dsp_flex_y_center">
						<div><a href="<?php echo base_url('mypage'); ?>"><img src="<?php echo IMG_DIR ?>/replus/mob_nav_mypage_1.png" /></a></div>
						<div style="text-align: center;"><a href="<?php echo base_url('campaign/lists'); ?>"><img src="<?php echo IMG_DIR ?>/replus/mob_nav_mypage_2-1.png" /></a></div>
						<div style="text-align: right;"><a href="javascript:chatChannel();"><img src="<?php echo IMG_DIR ?>/replus/mob_nav_mypage_3.png" /></a></div>
					</div>

					<hr />

					<!-- 모바일 메뉴 [mob_nav_dark / mob_nav_gray / mob_nav_white] -->
					<div class="mob_nav_gray">
						<?php
							// nav_desk 메인
							$this->load->view('layout_nav_mobile_view');
						?>
					</div>

					<hr />

					<div class="mob_nav_gray">
						<dl class="style_none mobile_navbar">
							<dt class="m10 menu_toggle menu_close ">
								<a href="/landing_npo/form" class="" target="blank"><span class="activenav">NPO 협약신청</span><span class="sr-only">NPO 협약신청</span></a>
							</dt>
						</dl>
						<dl class="style_none mobile_navbar">
							<dt class="m20 menu_toggle menu_close ">
								<a href="/landing/comp" class=""><span class="activenav">기업 제휴 문의</span><span class="sr-only">기업 제휴 문의</span></a>
							</dt>
						</dl>
					</div>

					<hr />

					<!-- <div class="req_btns mt-4">
						<a href="/landing_npo/form"><button type="button" class="btn btn-secondary btn-sm mb-1">NPO 협약신청</button></a>
						<a href="/landing/comp"><button type="button" class="btn btn-secondary btn-sm mb-1">기업 제휴 문의</button></a>
					</div> -->

				  </div>
				</div>

			</div>

		</div>

	  </div>
	</div>

