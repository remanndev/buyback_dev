<main class="flex-grow py-8 md:py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="space-y-4">
            <div class="rounded-2xl border border-primary/20 bg-gradient-to-r from-blue-50 via-white to-gray-50 dark:from-primary/15 dark:via-gray-800 dark:to-gray-900 px-7 py-8 shadow-sm">
                <div class="flex flex-col gap-5 md:flex-row md:items-center md:justify-between">
                    <div>
                        <p class="text-sm font-semibold tracking-[0.25em] text-primary uppercase">Featured</p>
                        <h2 class="mt-3 text-2xl md:text-3xl font-bold text-gray-900 dark:text-white"><?php echo html_escape($remann_name); ?> 매입 페이지</h2>
                    </div>
                    <div class="md:text-right">
                        <a href="<?php echo $remann_link; ?>" class="inline-flex items-center justify-center gap-2 rounded-xl bg-primary px-6 py-4 text-base font-bold text-white shadow-lg shadow-blue-500/20 transition-all hover:-translate-y-0.5 hover:bg-blue-700">
                            리맨 매입페이지 바로가기
                            <span class="material-icons text-base">arrow_forward</span>
                        </a>
                    </div>
                </div>
            </div>

            <?php if (!empty($partner_link)): ?>
                <div class="rounded-2xl border border-gray-200 bg-white px-7 py-8 shadow-sm dark:border-gray-700 dark:bg-gray-800">
                    <div class="flex flex-col gap-5 md:flex-row md:items-center md:justify-between">
                        <div>
                            <p class="text-sm font-semibold tracking-[0.25em] text-gray-400 uppercase">Partner</p>
                            <h2 class="mt-3 text-2xl md:text-3xl font-bold text-gray-900 dark:text-white">회원사 매입 페이지</h2>
                        </div>
                        <div class="md:text-right">
                            <a href="<?php echo html_escape($partner_link); ?>" class="inline-flex items-center justify-center gap-2 rounded-xl border border-primary/20 bg-primary px-6 py-4 text-base font-bold text-white shadow-lg shadow-blue-500/20 transition-all hover:-translate-y-0.5 hover:bg-blue-700">
                                회원사 매입페이지 바로가기
                                <span class="material-icons text-base">arrow_forward</span>
                            </a>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</main>
