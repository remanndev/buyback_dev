<?php
$current = isset($current_menu) ? $current_menu : 'main';
?>

<div class="buyback-my-mobile lg:hidden">
	<div class="buyback-my-mobile-scroll">
		<a href="/mypage/main" class="buyback-my-mobile-item <?php echo ($current === 'main') ? 'active' : ''; ?>">대시보드</a>
		<a href="/mypage/buyback/lists" class="buyback-my-mobile-item <?php echo ($current === 'buyback') ? 'active' : ''; ?>">매입 신청 내역</a>
		<a href="/mypage/user/edit" class="buyback-my-mobile-item <?php echo ($current === 'user') ? 'active' : ''; ?>">내 정보</a>
	</div>
</div>
