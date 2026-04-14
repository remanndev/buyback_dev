<?php
$header_logo_src = $this->config->item('website_logo_src', 'tank_auth');
$header_logo_alt = $this->config->item('website_name', 'tank_auth');
?>
<header class="bg-white dark:bg-gray-900 border-b border-gray-200 dark:border-gray-800 sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
        <a href="<?php echo isset($home_url) ? $home_url : base_url(); ?>">
            <div class="flex items-center">
                <img src="<?php echo html_escape($header_logo_src); ?>" alt="<?php echo html_escape($header_logo_alt); ?>" style="height:40px; width:auto; max-width:220px;" />
            </div>
        </a>

        <div class="flex items-center gap-3">
            <?php if (!empty($is_site_admin_logged_in)): ?>
                <span class="text-xs font-medium text-gray-400">사이트 관리자 로그인 중</span>
            <?php endif; ?>

            <?php if (!empty($is_member_logged_in)): ?>
                <a href="<?php echo isset($member_logout_url) ? $member_logout_url : base_url('auth/logout'); ?>" class="text-sm font-medium text-gray-600 dark:text-gray-300 hover:text-primary">로그아웃</a>
            <?php else: ?>
                <a href="<?php echo isset($member_login_url) ? $member_login_url : base_url('auth/login'); ?>" class="text-sm font-medium text-gray-600 dark:text-gray-300 hover:text-primary">회원 로그인</a>
            <?php endif; ?>
        </div>
    </div>
</header>
