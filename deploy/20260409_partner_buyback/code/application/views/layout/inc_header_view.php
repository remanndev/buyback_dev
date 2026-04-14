<?php
$header_logo_src = $this->config->item('website_logo_src', 'tank_auth');
$header_logo_alt = $this->config->item('website_name', 'tank_auth');
?>
<header class="bg-white dark:bg-gray-900 border-b border-gray-200 dark:border-gray-800 sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
        <a href="<?php echo base_url() ?>">
          <div class="flex items-center">
            <img src="<?php echo html_escape($header_logo_src); ?>" alt="<?php echo html_escape($header_logo_alt); ?>" style="height:40px; width:auto; max-width:220px;" />
          </div>
        </a>
		<?php /*
        <!-- <nav class="hidden md:flex gap-8 text-sm font-medium text-gray-600 dark:text-gray-400">
            <a class="hover:text-primary transition-colors" href="#">서비스 소개</a>
            <a class="text-primary" href="#">매입 신청</a>
            <a class="hover:text-primary transition-colors" href="#">이용 후기</a>
            <a class="hover:text-primary transition-colors" href="#">고객센터</a>
        </nav> -->
		*/ ?>
        <div class="flex items-center gap-3">
            <a href="<?php echo base_url('auth/login'); ?>"><button class="text-sm font-medium text-gray-600 dark:text-gray-300 hover:text-primary">로그인</button></a>
        </div>
    </div>
</header>
