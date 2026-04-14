<?php
$footer_logo_src = (!empty($partner['logo_src'])) ? $partner['logo_src'] : $this->config->item('website_logo_src', 'tank_auth');
$footer_logo_alt = !empty($partner['name']) ? $partner['name'] : $this->config->item('website_name', 'tank_auth');
?>
<footer class="bg-white dark:bg-gray-900 border-t border-gray-200 dark:border-gray-800 py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
            <div class="col-span-1 md:col-span-2">
                <div class="flex items-center mb-4">
                    <img src="<?php echo html_escape($footer_logo_src); ?>" alt="<?php echo html_escape($footer_logo_alt); ?>" style="height:40px; width:auto; max-width:220px;" />
                </div>
                <p class="text-sm text-gray-500 dark:text-gray-400 mb-4 max-w-sm">
                    리맨은 중고 IT 기기의 가치를 다시 연결하고 지속 가능한 순환 환경을 위해 노력하는 서비스입니다.
                </p>
            </div>
        </div>
        <div class="border-t border-gray-100 dark:border-gray-800 pt-8 flex flex-col md:flex-row justify-between items-center text-xs text-gray-400">
            <p>© 2024 Remann Inc. All rights reserved.</p>
            <div class="flex gap-4 mt-4 md:mt-0">
                <a class="hover:text-gray-600" href="/page/terms_use">이용약관</a>
                <a class="hover:text-gray-600" href="/page/terms_privacy">개인정보처리방침</a>
            </div>
        </div>
    </div>
</footer>
