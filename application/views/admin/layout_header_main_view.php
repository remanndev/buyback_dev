<?php
$seg2 = isset($arr_seg[2]) ? $arr_seg[2] : '';
$seg3 = isset($arr_seg[3]) ? $arr_seg[3] : '';
$disable_page_loader = ($seg2 === 'buyback' && in_array($seg3, array('spec_lists', 'spec_quick'), true));

$is_member_menu = in_array($seg2, array('user'), true);
$is_partner_menu = ($seg2 === 'partner');
$is_buyback_spec_menu = ($seg2 === 'buyback' && in_array($seg3, array('spec_lists', 'spec_quick', 'spec_write', 'spec_excel'), true));
$is_buyback_request_menu = ($seg2 === 'buyback' && !$is_buyback_spec_menu);
$is_visit_menu = ($seg2 === 'env');
?>

<div class="top-util" style="position:absolute; top:3px; right:5px; z-index:1000;">
	<a href="/" target="_blank"><button class="btn btn-primary btn-xs" style="margin-right:2px;">사이트 메인</button></a>
	<a href="/auth/logout"><button class="btn btn-danger btn-xs">로그아웃</button></a>
</div>
<div id="navbar" class="navbar-bg" style="position:relative">
	<a class="navbar-brand" href="/admin/"><img src="/assets/images/layout/remann_buyback_logo.png" style="height:34px; width:auto;" /></a>
	<ul class="mr_auto">
		<li data-menu="member" class="<?php echo $is_member_menu ? 'active' : ''; ?>"><a href="/admin/user/lists"><button type="button" class="btn btn-nav-flat">회원관리</button></a></li>
		<li data-menu="partner" class="<?php echo $is_partner_menu ? 'active' : ''; ?>"><a href="/admin/partner/lists"><button type="button" class="btn btn-nav-flat">회원사관리</button></a></li>
		<li data-menu="buyback-spec" class="<?php echo $is_buyback_spec_menu ? 'active' : ''; ?>"><a href="/admin/buyback/spec_lists"><button type="button" class="btn btn-nav-flat">매입기준관리</button></a></li>
		<li data-menu="buyback-request" class="<?php echo $is_buyback_request_menu ? 'active' : ''; ?>"><a href="/admin/buyback/list"><button type="button" class="btn btn-nav-flat">매입신청관리</button></a></li>
		<li data-menu="visit" class="<?php echo $is_visit_menu ? 'active' : ''; ?>"><a href="/admin/env/visit"><button type="button" class="btn btn-nav-flat">방문자관리</button></a></li>
	</ul>
</div>

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
