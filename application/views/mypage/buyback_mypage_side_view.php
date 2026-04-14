<?php
$current = isset($current_menu) ? $current_menu : 'main';
$nickname = isset($user_summary['nickname']) ? $user_summary['nickname'] : '';
$email = isset($user_summary['email']) ? $user_summary['email'] : '';
$login_type = isset($user_summary['login_type']) ? $user_summary['login_type'] : 'GENERAL';
?>

<aside class="buyback-my-side">
	<div class="buyback-my-side-card">
		<div class="buyback-my-side-badge"><?php echo html_escape($login_type); ?></div>
		<div class="buyback-my-side-name"><?php echo html_escape($nickname); ?></div>
		<div class="buyback-my-side-email"><?php echo html_escape($email); ?></div>
	</div>

	<nav class="buyback-my-nav" aria-label="마이페이지 메뉴">
		<a href="/mypage/main" class="buyback-my-nav-item <?php echo ($current === 'main') ? 'active' : ''; ?>">대시보드</a>
		<a href="/mypage/buyback/lists" class="buyback-my-nav-item <?php echo ($current === 'buyback') ? 'active' : ''; ?>">매입 신청 내역</a>
		<a href="/mypage/user/edit" class="buyback-my-nav-item <?php echo ($current === 'user') ? 'active' : ''; ?>">내 정보</a>
	</nav>
</aside>
