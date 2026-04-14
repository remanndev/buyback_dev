<?php
$buyback_admin_base_path = isset($buyback_admin_base_path) ? trim($buyback_admin_base_path, '/') : '';
$devices = isset($request['devices']) ? $request['devices'] : array();
?>

<main class="flex-grow py-8 md:py-12">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <?php if (!empty($flash_message)): ?>
            <div class="mb-6 rounded-lg border border-green-200 bg-green-50 text-green-700 px-4 py-3 text-sm">
                <?php echo html_escape($flash_message); ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($flash_error)): ?>
            <div class="mb-6 rounded-lg border border-red-200 bg-red-50 text-red-700 px-4 py-3 text-sm">
                <?php echo html_escape($flash_error); ?>
            </div>
        <?php endif; ?>

        <div class="mb-8 flex items-center justify-between gap-4">
            <div>
                <p class="text-sm uppercase tracking-[0.2em] text-gray-400">Partner Admin</p>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white"><?php echo html_escape($partner['name']); ?> 신청 상세</h1>
            </div>
            <div class="flex items-center gap-4">
                <?php if (empty($request['ros_wa_id'])): ?>
                    <a href="<?php echo site_url($buyback_admin_base_path . '/send/' . (int) $request['id']); ?>" onclick="return confirm('이 요청을 ROS로 전송하시겠습니까?');" class="text-sm font-medium text-emerald-600 hover:underline">ROS 전송</a>
                <?php endif; ?>
                <a href="<?php echo site_url($buyback_admin_base_path); ?>" class="text-sm font-medium text-primary hover:underline">목록으로</a>
            </div>
        </div>

        <div class="grid gap-6 lg:grid-cols-2">
            <section class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 p-6">
                <h2 class="text-lg font-bold text-gray-900 dark:text-white mb-4">신청 정보</h2>
                <div class="space-y-3 text-sm">
                    <div><span class="font-medium text-gray-500">신청자</span><div class="mt-1 text-gray-900 dark:text-white"><?php echo html_escape(isset($request['applicant_name']) ? $request['applicant_name'] : ''); ?></div></div>
                    <div><span class="font-medium text-gray-500">연락처</span><div class="mt-1 text-gray-900 dark:text-white"><?php echo html_escape(isset($request['phone']) ? $request['phone'] : ''); ?></div></div>
                    <div><span class="font-medium text-gray-500">주소</span><div class="mt-1 text-gray-900 dark:text-white"><?php echo html_escape(trim((isset($request['postcode']) ? $request['postcode'] . ' ' : '') . (isset($request['address1']) ? $request['address1'] : '') . ' ' . (isset($request['address2']) ? $request['address2'] : ''))); ?></div></div>
                    <div><span class="font-medium text-gray-500">방문 일정</span><div class="mt-1 text-gray-900 dark:text-white"><?php echo html_escape((isset($request['visit_date']) ? $request['visit_date'] : '') . ' ' . (isset($request['visit_time']) ? $request['visit_time'] : '')); ?></div></div>
                    <div><span class="font-medium text-gray-500">수거 장소</span><div class="mt-1 text-gray-900 dark:text-white"><?php echo html_escape(isset($request['pickup_location']) ? $request['pickup_location'] : ''); ?></div></div>
                    <div><span class="font-medium text-gray-500">메모</span><div class="mt-1 text-gray-900 dark:text-white"><?php echo html_escape(isset($request['pickup_memo']) ? $request['pickup_memo'] : ''); ?></div></div>
                </div>
            </section>

            <section class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 p-6">
                <h2 class="text-lg font-bold text-gray-900 dark:text-white mb-4">정산 및 API 정보</h2>
                <div class="space-y-3 text-sm">
                    <div><span class="font-medium text-gray-500">예상 금액</span><div class="mt-1 text-gray-900 dark:text-white"><?php echo html_escape(isset($request['total_price_text']) ? $request['total_price_text'] : ''); ?></div></div>
                    <div><span class="font-medium text-gray-500">은행</span><div class="mt-1 text-gray-900 dark:text-white"><?php echo html_escape(isset($request['bank_name']) ? $request['bank_name'] : ''); ?></div></div>
                    <div><span class="font-medium text-gray-500">계좌번호</span><div class="mt-1 text-gray-900 dark:text-white"><?php echo html_escape(isset($request['account_number']) ? $request['account_number'] : ''); ?></div></div>
                    <div><span class="font-medium text-gray-500">상태</span><div class="mt-1 text-gray-900 dark:text-white"><?php echo html_escape(isset($request['status']) ? $request['status'] : ''); ?></div></div>
                    <div><span class="font-medium text-gray-500">API 상태</span><div class="mt-1 text-gray-900 dark:text-white"><?php echo html_escape(isset($request['api_send_status']) ? $request['api_send_status'] : ''); ?></div></div>
                    <div><span class="font-medium text-gray-500">ROS 작업번호</span><div class="mt-1 text-gray-900 dark:text-white"><?php echo html_escape(isset($request['ros_wa_id']) ? $request['ros_wa_id'] : ''); ?></div></div>
                    <div><span class="font-medium text-gray-500">신청번호</span><div class="mt-1 text-gray-900 dark:text-white"><?php echo html_escape(isset($request['request_no']) ? $request['request_no'] : ''); ?></div></div>
                    <div><span class="font-medium text-gray-500">API 전송시각</span><div class="mt-1 text-gray-900 dark:text-white"><?php echo html_escape(isset($request['api_sent_at']) ? $request['api_sent_at'] : ''); ?></div></div>
                    <div><span class="font-medium text-gray-500">API 에러</span><div class="mt-1 text-gray-900 dark:text-white"><?php echo html_escape(isset($request['api_error_message']) ? $request['api_error_message'] : ''); ?></div></div>
                </div>
            </section>
        </div>

        <section class="mt-6 bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 p-6">
            <h2 class="text-lg font-bold text-gray-900 dark:text-white mb-4">기기 목록</h2>

            <?php if (empty($devices)): ?>
                <div class="text-sm text-gray-500">등록된 기기 정보가 없습니다.</div>
            <?php else: ?>
                <div class="space-y-3">
                    <?php foreach ($devices as $device): ?>
                        <div class="rounded-lg border border-gray-100 dark:border-gray-700 p-4">
                            <div class="flex items-start justify-between gap-4">
                                <div>
                                    <div class="font-medium text-gray-900 dark:text-white">
                                        <?php echo html_escape($device['device']); ?> · <?php echo html_escape($device['manufacturer']); ?>
                                    </div>
                                    <div class="text-sm text-gray-500 mt-1">
                                        <?php echo html_escape($device['model']); ?> · <?php echo html_escape($device['condition']); ?>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <div class="font-bold text-primary"><?php echo html_escape($device['price_text']); ?></div>
                                    <div class="text-xs text-gray-500 mt-1">수량 <?php echo (int) $device['qty']; ?></div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </section>

        <section class="mt-6 grid gap-6 lg:grid-cols-2">
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 p-6">
                <h2 class="text-lg font-bold text-gray-900 dark:text-white mb-4">API Request Payload</h2>
                <pre class="text-xs text-gray-700 dark:text-gray-200 whitespace-pre-wrap break-all"><?php echo html_escape(isset($request['api_request_payload']) ? $request['api_request_payload'] : ''); ?></pre>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 p-6">
                <h2 class="text-lg font-bold text-gray-900 dark:text-white mb-4">API Response Payload</h2>
                <pre class="text-xs text-gray-700 dark:text-gray-200 whitespace-pre-wrap break-all"><?php echo html_escape(isset($request['api_response_payload']) ? $request['api_response_payload'] : ''); ?></pre>
            </div>
        </section>
    </div>
</main>
