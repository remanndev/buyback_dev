
		<!-- Desktop Nav -->
		<div class="header_nav">

			<?php /* Desktop Nav  # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # #  */ ?>
			<div id="navbar_fixed" class="navbar_fixed">
				<div class="desk_nav_wrap">
					<div class="header_wrap">
						<a href="/"><div class="navlogo font_nunitosans">Replus</div></a>
						<div class="desk_navbar">

							<?php
								// nav_desk 메인
								$this->load->view('layout_nav_desk_main_view');
							?>

							<div class="navbar_user">
								<div>
									<?php if ($this->tank_auth->is_admin()) {									// admin ?>
									<a href="/admin">ADMIN</a>
									<?php } ?>
									<?php if ($this->tank_auth->is_logged_in()) {									// logged in ?>
									<?php if (! $this->tank_auth->is_admin()) {									// admin ?>
									<a href="/mypage">마이페이지</a>
									<?php } ?>
									<a href="/auth/logout">로그아웃</a>
									<?php } else { ?>
									<a href="/auth/register">회원가입</a>
									<a href="/auth/login">로그인</a>
									<?php } ?>
								</div>
							</div>

							<div class="navbar_srh">
								<!-- <form class="d-flex" action="<?php echo REQUEST_URI ?>" method="post">
								  <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" style="width:120px;">
								  <button class="btn btn-outline-success" type="submit">Search</button>
								</form> -->
							</div>

						</div>
					</div>

					<div class="navbar_sub">
					<?php
						// nav_desk 서브
						$this->load->view('layout_nav_desk_sub_view');
					?>
					</div>

				</div>
			</div>
		</div>

		
		<!-- Mobile Nav -->
		<div class="header_nav_mobile">
			<div id="navbar_fixed_mobile" class="navbar_fixed fixed-top">
			  <div class="header_wrap">
				<a href="/"><div class="navlogo font_nunitosans">Replus</div></a>
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
		</div>




