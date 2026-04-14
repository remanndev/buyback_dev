		<?php
			$loader_seg2 = isset($arr_seg[2]) ? $arr_seg[2] : $this->uri->segment(2);
			$loader_seg3 = isset($arr_seg[3]) ? $arr_seg[3] : $this->uri->segment(3);
			$disable_page_loader = ($loader_seg2 === 'buyback' && in_array($loader_seg3, array('spec_lists', 'spec_quick'), true));
		?>
		<div class="top-util" style="position:absolute; top:3px; right:5px; z-index:1000;">
			<a href="/" target="_blank"><button class="btn btn-primary btn-xs" style="margin-right:2px;">사이트 메인</button></a>
			<a href="/auth/logout"><button class="btn btn-danger btn-xs">로그아웃</button></a>
		</div>

		<div id="navbar" class="navbar-bg" style="position:relative">
			<a class="navbar-brand" href="/admin/"><img src="/assets/images/layout/remann_buyback_logo.png" style="height:34px; width:auto;" /></a>
			<ul class="mr_auto">
				<li><a href="/admin/user"><button type="button" class="btn btn-nav-flat">회원관리</button></a></li>
				<li><a href="/admin/buyback"><button type="button" class="btn btn-nav-flat">매입관리</button></a></li>
				<li><a href="/admin/env"><button type="button" class="btn btn-nav-flat">방문자 관리</button></a></li>

				<?php /*
				<li><a href="/admin/board"><button type="button" class="btn btn-nav-flat">게시판관리</button></a></li>
				<li><a href="/admin/design"><button type="button" class="btn btn-nav-flat">디자인관리</button></a></li>
				<li><a href="/admin/contents"><button type="button" class="btn btn-nav-flat">컨텐츠관리</button></a></li>
				<li><a href="/admin/campaign"><button type="button" class="btn btn-nav-flat">캠페인관리</button></a></li>
				*/ ?>

				<?php if(isset($this->username) && 'sadmin' === $this->username){ ?>
				<!-- <li><a href="/admin/product"><button type="button" class="btn btn-nav-flat">상품 관리</button></a></li> -->
				<!-- <li><a href="/admin/item"><button type="button" class="btn btn-nav-flat">상품 관리</button></a></li>
				<li><a href="/admin/calendar"><button type="button" class="btn btn-nav-flat">프로그램 일정</button></a></li>
				<li><a href="/admin/landing/reserve/rsv_1"><button type="button" class="btn btn-nav-flat">방문예약리스트</button></a></li> -->
				<!-- <li><a href="/admin/env"><button type="button" class="btn btn-nav-flat">사이트 관리</button></a></li> -->
				<!-- <li><a href="/admin/recycle"><button type="button" class="btn btn-nav-flat">수거요청관리</button></a></li> -->
				<!-- <li><a href="/admin/inven"><button type="button" class="btn btn-nav-flat">재고 관리</button></a></li>
				<li><a href="/admin/orders"><button type="button" class="btn btn-nav-flat">주문 관리</button></a></li> -->
				<!-- <li><a href="/admin/landing/request/npo"><button type="button" class="btn btn-nav-flat">문의관리</button></a></li> -->
				<?php } ?>
			</ul>
		</div>

		<!-- [START] ###################################################################################### -->

		<!-- 1) 레이아웃 공통 추가 -->
		<?php if (!$disable_page_loader): ?>
		<div id="page-blocker" aria-hidden="true">
		  <div class="loader" role="status" aria-live="polite" aria-label="처리 중"></div>
		</div>

		<style>
		  #page-blocker {
			position: fixed; inset: 0;
			background: rgba(0,0,0,.35);
			display: none;
			align-items: center; justify-content: center;
			z-index: 99999;
			backdrop-filter: blur(1px);
			cursor: wait;
		  }
		  body.loading {
			overflow: hidden;
		  }
		  .loader {
			width: 56px; height: 56px;
			border: 4px solid rgba(255,255,255,.35);
			border-top-color: #fff;
			border-radius: 50%;
			animation: spin 0.8s linear infinite;
		  }
		  @keyframes spin { to { transform: rotate(360deg); } }
		</style>

		<script>
		  (function () {
			let pending = 0;
			const blocker = document.getElementById('page-blocker');

			function show() {
			  pending++;
			  if (blocker.style.display !== 'flex') {
				blocker.style.display = 'flex';
				document.body.classList.add('loading');
				document.body.setAttribute('aria-busy', 'true');
			  }
			}
			function hide() {
			  pending = Math.max(0, pending - 1);
			  if (pending === 0) {
				blocker.style.display = 'none';
				document.body.classList.remove('loading');
				document.body.removeAttribute('aria-busy');
			  }
			}

			window.PageLoader = { show, hide };
		  })();
		</script>

		<script>
		  if (window.jQuery) {
			$(document).ajaxStart(function () { PageLoader.show(); });
			$(document).ajaxStop(function () { PageLoader.hide(); });
			$(document).ajaxError(function () { PageLoader.hide(); });
		  }
		</script>
		<?php else: ?>
		<script>
		  window.PageLoader = {
			show: function () {},
			hide: function () {}
		  };
		</script>
		<?php endif; ?>

		<!-- [END] ###################################################################################### -->
