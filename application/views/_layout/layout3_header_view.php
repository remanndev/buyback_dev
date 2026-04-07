	<!-- [PC] 헤더영역 -->
	<div class="pc_wrap d-none d-lg-block">
	  <div class="header_wrap">
		<div class="top_logo"><a href=""><img src="<?php echo IMG_DIR ?>/layout/logo_white.svg" /></a></div>
		<div class="top_nav">
			<a href="" class="<?php echo (isset($seg[1]) && $seg[1] && 'campaign') ? 'active' : ''; ?>" >기부캠페인</a>
			<a href="">나눔신청</a>
			<a href="">함께하는 기관</a>
			<a href="">기부 절차 안내</a>
		</div>
		<div class="top_util">
		  <div style="">
			<a href=""><img class="ic_join" src="<?php echo IMG_DIR ?>/layout/icon_join.png" /> <span>회원가입</span></a>
			<a href=""><img class="ic_login" src="<?php echo IMG_DIR ?>/layout/icon_login.png" /> <span>로그인</span></a>
		  </div>
		</div>
	  </div>
	</div>


	<!-- [MOBILE] 헤더영역 -->
	<div class="mobile_wrap d-block d-lg-none">
	  <div class="header_wrap">

		<div class="top_logo"><img src="<?php echo IMG_DIR ?>/layout/logo_white.svg" /></div>

		<div class="navbar">

			<!-- mobile nav icon : open -->
			<a href="/" onclick="return false;" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRightMobile" aria-controls="offcanvasRightMobile">
			  <div class="hamberger_btn">
				<div></div>
				<div></div>
				<div></div>
			  </div>
			</a>

			<!-- mobile nav icon : wrap -->
			<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRightMobile" aria-labelledby="offcanvasRightMobileLabel">
			  <div class="offcanvas-header">
				<h5 id="offcanvasRightMobileLabel">
					<div class="btn-group" style="display:flex;" role="group" aria-label="Basic example">
					  <?php if ($this->tank_auth->is_logged_in()) {									// logged in ?>
					  <a href="/mypage" class="btn btn-sm btn-outline-dark">마이페이지</a>
					  <a href="/auth/logout" class="btn btn-sm btn-outline-dark">로그아웃</a>
					  <?php } else { ?>
					  <a href="/auth/login" class="btn btn-sm btn-outline-dark">로그인</a>
					  <a href="/auth/register" class="btn btn-sm btn-outline-dark">회원가입</a>
					  <?php } ?>
					  <!-- <a href="/search" class="btn btn-sm btn-outline-dark">검색</a> -->
					</div>
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

				<!-- 모바일 메뉴 [mob_nav_dark / mob_nav_gray / mob_nav_white] -->
				<div class="mob_nav_gray">
					<?php
						// nav_desk 메인
						$this->load->view('layout_nav_mobile_view');
					?>
				</div>

			  </div>
			</div>

		</div>

	  </div>
	</div>

