<main class="flex-grow py-8 md:py-12">
    <div class="max-w-lg mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
            <div class="p-8">
                <p class="text-sm uppercase tracking-[0.2em] text-gray-400">Partner Admin</p>
                <h1 class="mt-3 text-3xl font-bold text-gray-900 dark:text-white"><?php echo html_escape($partner['name']); ?> 관리자 로그인</h1>
                <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">회원사 관리자만 접근할 수 있습니다.</p>

                <?php if (!empty($error_message)): ?>
                    <div class="mt-6 rounded-lg border border-red-200 bg-red-50 text-red-700 px-4 py-3 text-sm">
                        <?php echo html_escape($error_message); ?>
                    </div>
                <?php endif; ?>

                <form method="post" class="mt-6 space-y-5">
                    <div>
                        <label for="partner-admin-login" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">아이디</label>
                        <input id="partner-admin-login" type="text" name="login" value="<?php echo set_value('login'); ?>" class="w-full px-4 py-3 bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary transition-shadow text-gray-900 dark:text-white">
                    </div>

                    <div>
                        <label for="partner-admin-password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">비밀번호</label>
                        <input id="partner-admin-password" type="password" name="password" class="w-full px-4 py-3 bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary transition-shadow text-gray-900 dark:text-white">
                    </div>

                    <button type="submit" class="w-full bg-primary hover:bg-blue-700 text-white font-bold py-3 px-4 rounded-xl transition-all">
                        관리자 로그인
                    </button>
                </form>
            </div>
        </div>
    </div>
</main>
