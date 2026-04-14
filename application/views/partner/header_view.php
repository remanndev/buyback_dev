<?php
$header_mode = isset($header_mode) ? $header_mode : 'partner_public';
$partner_name = isset($partner['name']) ? $partner['name'] : $this->config->item('website_name', 'tank_auth');
$home_link = isset($home_url) ? $home_url : base_url();
$show_member_controls = ($header_mode !== 'partner_admin');
$header_logo_src = (!empty($partner['logo_src'])) ? $partner['logo_src'] : $this->config->item('website_logo_src', 'tank_auth');
$header_logo_alt = $partner_name;
?>
<header class="bg-white dark:bg-gray-900 border-b border-gray-200 dark:border-gray-800 sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
        <a href="<?php echo $home_link; ?>" class="flex items-center">
            <img src="<?php echo html_escape($header_logo_src); ?>" alt="<?php echo html_escape($header_logo_alt); ?>" style="height:40px; width:auto; max-width:220px;" />
        </a>

        <div class="flex items-center gap-3">
            <?php if (!empty($is_site_admin_logged_in)): ?>
                <span class="text-xs font-medium text-gray-400">사이트 관리자 로그인 중</span>
            <?php endif; ?>

            <?php if (!empty($is_partner_admin_logged_in) && !empty($partner_admin_url)): ?>
                <a href="<?php echo $partner_admin_url; ?>" class="text-sm font-medium text-gray-600 dark:text-gray-300 hover:text-primary">매니저</a>
            <?php endif; ?>

            <?php if (!empty($is_partner_admin_logged_in) && !empty($partner_admin_logout_url)): ?>
                <a href="<?php echo $partner_admin_logout_url; ?>" class="text-sm font-medium text-gray-600 dark:text-gray-300 hover:text-primary">매니저 로그아웃</a>
            <?php endif; ?>

            <?php if ($show_member_controls): ?>
                <?php if (!empty($is_member_logged_in)): ?>
                    <a href="<?php echo isset($member_logout_url) ? $member_logout_url : base_url('auth/logout'); ?>" class="text-sm font-medium text-gray-600 dark:text-gray-300 hover:text-primary">로그아웃</a>
                <?php elseif (!empty($member_login_url)): ?>
                    <a href="<?php echo $member_login_url; ?>" class="text-sm font-medium text-gray-600 dark:text-gray-300 hover:text-primary">회원 로그인</a>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
</header>
