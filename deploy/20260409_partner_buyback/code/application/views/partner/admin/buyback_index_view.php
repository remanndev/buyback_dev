<?php $buyback_admin_base_path = isset($buyback_admin_base_path) ? trim($buyback_admin_base_path, '/') : ''; ?>

<main class="flex-grow py-8 md:py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
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
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white"><?php echo html_escape($partner['name']); ?> 매입 신청</h1>
            </div>
            <a href="<?php echo site_url('partner/' . rawurlencode($partner['slug']) . '/sell'); ?>" class="text-sm font-medium text-primary hover:underline">공개 신청 화면 보기</a>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm overflow-hidden border border-gray-100 dark:border-gray-700">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-900/50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">접수일시</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">신청자</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">기기</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">방문</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">금액</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">API</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">관리</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        <?php if (empty($requests)): ?>
                            <tr>
                                <td colspan="7" class="px-6 py-12 text-center text-gray-500">등록된 매입 신청이 없습니다.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($requests as $item): ?>
                                <?php
                                $devices = isset($item['devices']) ? $item['devices'] : array();
                                $first = !empty($devices) ? $devices[0] : null;
                                $total_units = 0;
                                foreach ($devices as $device) {
                                    $total_units += (int) $device['qty'];
                                }
                                ?>
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                        <?php echo html_escape(isset($item['created_at']) ? $item['created_at'] : ''); ?>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm font-medium text-gray-900 dark:text-white"><?php echo html_escape(isset($item['applicant_name']) ? $item['applicant_name'] : ''); ?></div>
                                        <div class="text-sm text-gray-500"><?php echo html_escape(isset($item['phone']) ? $item['phone'] : ''); ?></div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <?php if ($first): ?>
                                            <div class="text-sm font-bold text-primary"><?php echo (int) $total_units; ?>대</div>
                                            <div class="text-sm text-gray-900 dark:text-white"><?php echo html_escape($first['device']); ?> · <?php echo html_escape($first['manufacturer']); ?></div>
                                            <div class="text-xs text-gray-500 mt-1"><?php echo html_escape($first['model']); ?> · <?php echo html_escape($first['condition']); ?></div>
                                        <?php else: ?>
                                            <div class="text-sm text-gray-400">기기 정보 없음</div>
                                        <?php endif; ?>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">
                                        <div><?php echo html_escape((isset($item['visit_date']) ? $item['visit_date'] : '') . ' ' . (isset($item['visit_time']) ? $item['visit_time'] : '')); ?></div>
                                        <div class="text-xs mt-1"><?php echo html_escape(isset($item['pickup_location']) ? $item['pickup_location'] : ''); ?></div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900 dark:text-white">
                                        <?php echo html_escape(isset($item['total_price_text']) ? $item['total_price_text'] : ''); ?>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        <div class="font-medium text-gray-900 dark:text-white"><?php echo html_escape(isset($item['api_send_status']) ? $item['api_send_status'] : ''); ?></div>
                                        <?php if (!empty($item['ros_wa_id'])): ?>
                                            <div class="text-xs text-gray-500 mt-1">ROS #<?php echo html_escape($item['ros_wa_id']); ?></div>
                                        <?php endif; ?>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <a href="<?php echo site_url($buyback_admin_base_path . '/view/' . (int) $item['id']); ?>" class="text-primary hover:underline">상세</a>
                                        <?php if (empty($item['ros_wa_id'])): ?>
                                            <span class="mx-2 text-gray-300">|</span>
                                            <a href="<?php echo site_url($buyback_admin_base_path . '/send/' . (int) $item['id']); ?>" onclick="return confirm('이 요청을 ROS로 전송하시겠습니까?');" class="text-emerald-600 hover:underline">ROS 전송</a>
                                        <?php endif; ?>
                                        <span class="mx-2 text-gray-300">|</span>
                                        <a href="<?php echo site_url($buyback_admin_base_path . '/delete/' . (int) $item['id']); ?>" onclick="return confirm('이 신청을 삭제하시겠습니까?');" class="text-red-600 hover:underline">삭제</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>
