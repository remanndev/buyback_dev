
<main class="flex-grow py-8 md:py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-8 text-center md:text-left">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">수거 신청</h1>
            <p class="text-gray-500 dark:text-gray-400">방문 수거 정보를 입력해주세요.</p>
        </div>

        <div class="flex flex-col lg:flex-row gap-8">
            <div class="flex-grow lg:w-2/3">
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-100 dark:border-gray-700 overflow-hidden">
                    <div class="p-6 border-b border-gray-100 dark:border-gray-700">
                        <h2 class="text-xl font-bold text-gray-900 dark:text-white">신청 정보 입력</h2>
                    </div>

                    <form method="post" action="<?php echo site_url('sell/submit'); ?>" class="p-6 space-y-6">
                        <?php if (validation_errors()): ?>
                            <div class="rounded-lg border border-red-200 bg-red-50 text-red-700 px-4 py-3 text-sm">
                                <?php echo validation_errors(); ?>
                            </div>
                        <?php endif; ?>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="input-name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">이름</label>
                                <input type="text" id="input-name" name="name" value="<?php echo set_value('name'); ?>" placeholder="이름을 입력하세요" class="w-full px-4 py-3 bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary transition-shadow text-gray-900 dark:text-white">
                            </div>
                            <div>
                                <label for="input-phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">연락처</label>
                                <input type="tel" id="input-phone" name="phone" value="<?php echo set_value('phone'); ?>" placeholder="01000000000" class="w-full px-4 py-3 bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary transition-shadow text-gray-900 dark:text-white">
                            </div>
                        </div>

                        <div>
                            <label for="input-address" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">주소</label>
                            <input type="text" id="input-address" name="address1" value="<?php echo set_value('address1'); ?>" placeholder="주소를 입력해주세요" class="w-full px-4 py-3 bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary transition-shadow text-gray-900 dark:text-white">
                        </div>

                        <div>
                            <label for="input-address-detail" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">상세주소</label>
                            <input type="text" id="input-address-detail" name="address2" value="<?php echo set_value('address2'); ?>" placeholder="상세주소를 입력해주세요 (동, 호수 등)" class="w-full px-4 py-3 bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary transition-shadow text-gray-900 dark:text-white">
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="input-date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">방문일</label>
                                <input type="date" id="input-date" name="visit_date" value="<?php echo set_value('visit_date'); ?>" class="w-full px-4 py-3 bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary transition-shadow text-gray-900 dark:text-white">
                            </div>
                            <div>
                                <label for="input-time" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">방문시간</label>
                                <select id="input-time" name="visit_time" class="w-full pl-4 pr-10 py-3 bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary appearance-none transition-shadow text-gray-900 dark:text-white">
                                    <option value="">시간 선택</option>
                                    <option value="09:00~12:00" <?php echo set_select('visit_time', '09:00~12:00'); ?>>09:00~12:00</option>
                                    <option value="12:00~15:00" <?php echo set_select('visit_time', '12:00~15:00'); ?>>12:00~15:00</option>
                                    <option value="15:00~18:00" <?php echo set_select('visit_time', '15:00~18:00'); ?>>15:00~18:00</option>
                                    <option value="18:00~20:00" <?php echo set_select('visit_time', '18:00~20:00'); ?>>18:00~20:00</option>
                                </select>
                            </div>
                        </div>

                        <div>
                            <label for="pickup-location" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">수거 장소</label>
                            <select id="pickup-location" name="pickup_location" class="w-full pl-4 pr-10 py-3 bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary appearance-none transition-shadow text-gray-900 dark:text-white">
                                <option value="">선택해주세요</option>
                                <option value="문 앞" <?php echo set_select('pickup_location', '문 앞'); ?>>문 앞</option>
                                <option value="경비실" <?php echo set_select('pickup_location', '경비실'); ?>>경비실</option>
                                <option value="직접 전달" <?php echo set_select('pickup_location', '직접 전달'); ?>>직접 전달</option>
                            </select>
                        </div>

                        <div>
                            <label for="input-memo" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">메모</label>
                            <input type="text" id="input-memo" name="pickup_memo" value="<?php echo set_value('pickup_memo'); ?>" placeholder="공동현관 비밀번호 등 기사님께 전달할 메모를 입력해주세요." class="w-full px-4 py-3 bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary transition-shadow text-gray-900 dark:text-white">
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="input-bank" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">은행명</label>
                                <select id="input-bank" name="bank_name" class="w-full pl-4 pr-10 py-3 bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary appearance-none transition-shadow text-gray-900 dark:text-white">
                                    <option value="">은행 선택</option>
                                    <option value="국민은행" <?php echo set_select('bank_name', '국민은행'); ?>>국민은행</option>
                                    <option value="신한은행" <?php echo set_select('bank_name', '신한은행'); ?>>신한은행</option>
                                    <option value="우리은행" <?php echo set_select('bank_name', '우리은행'); ?>>우리은행</option>
                                    <option value="하나은행" <?php echo set_select('bank_name', '하나은행'); ?>>하나은행</option>
                                    <option value="농협은행" <?php echo set_select('bank_name', '농협은행'); ?>>농협은행</option>
                                    <option value="기업은행" <?php echo set_select('bank_name', '기업은행'); ?>>기업은행</option>
                                    <option value="카카오뱅크" <?php echo set_select('bank_name', '카카오뱅크'); ?>>카카오뱅크</option>
                                    <option value="토스뱅크" <?php echo set_select('bank_name', '토스뱅크'); ?>>토스뱅크</option>
                                </select>
                            </div>
                            <div>
                                <label for="input-account" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">계좌번호</label>
                                <input type="text" id="input-account" name="account_number" value="<?php echo set_value('account_number'); ?>" placeholder="계좌번호 (-없이 입력)" class="w-full px-4 py-3 bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary transition-shadow text-gray-900 dark:text-white">
                            </div>
                        </div>

                        <div class="pt-4 border-t border-gray-100 dark:border-gray-700 flex justify-between items-center">
                            <a href="<?php echo site_url('sell'); ?>" class="text-gray-500 hover:text-gray-700 dark:hover:text-gray-300 font-medium text-sm flex items-center gap-1 transition-colors">
                                <span class="material-icons text-base">arrow_back</span>
                                이전 단계
                            </a>
                            <button type="submit" class="bg-primary hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-lg shadow-lg shadow-blue-500/30 transition-all transform hover:-translate-y-0.5 flex items-center gap-2">
                                수거 신청 완료
                                <span class="material-icons text-sm">check_circle</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="lg:w-1/3">
                <div class="sticky top-24">
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-100 dark:border-gray-700 overflow-hidden">
                        <div class="p-6 border-b border-gray-100 dark:border-gray-700">
                            <h2 class="text-lg font-bold text-gray-900 dark:text-white">신청 요약</h2>
                        </div>

                        <div class="p-6 space-y-4 max-h-[70vh] overflow-y-auto">
                            <?php
                            $total_units = 0;
                            foreach ($devices as $d) {
                                $total_units += (int)$d['qty'];
                            }
                            ?>

                            <div class="flex items-center justify-between rounded-lg bg-gray-50 dark:bg-gray-900/50 p-4">
                                <div>
                                    <div class="text-sm text-gray-500">총 수량</div>
                                    <div class="text-lg font-bold text-gray-900 dark:text-white"><?php echo $total_units; ?>대</div>
                                </div>
                                <div class="text-right">
                                    <div class="text-sm text-gray-500">예상 매입가</div>
                                    <div class="text-xl font-bold text-primary"><?php echo html_escape($total_price_text); ?></div>
                                </div>
                            </div>

                            <div class="space-y-3">
                                <?php foreach ($devices as $d): ?>
                                    <div class="flex items-center justify-between p-3 border border-gray-100 dark:border-gray-700 rounded-lg">
                                        <div class="flex-1 min-w-0">
                                            <div class="font-medium text-gray-900 dark:text-white">
                                                <?php echo html_escape($d['device_type']); ?> · <?php echo html_escape($d['manufacturer']); ?>
                                            </div>
                                            <div class="text-xs text-gray-500 mt-1 truncate">
                                                <?php echo html_escape($d['model_name']); ?> · <?php echo html_escape($d['condition_grade']); ?>
                                            </div>
                                        </div>
                                        <div class="text-right ml-3">
                                            <div class="font-bold text-primary"><?php echo html_escape($d['unit_price_text']); ?></div>
                                            <?php if ((int)$d['qty'] > 1): ?>
                                                <div class="text-xs text-gray-500 mt-1">x<?php echo (int)$d['qty']; ?></div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>