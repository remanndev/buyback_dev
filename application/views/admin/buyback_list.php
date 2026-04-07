
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>

<div class=" admin_wrap">

	<h1 class="flex justify-between items-center">
		<div>수거 신청 목록</div>
		<span class="text-sm text-gray-500">총 <?php echo count($requests); ?>건</span>
	</h1>

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm overflow-hidden border border-gray-100 dark:border-gray-700">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-900/50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">신청일시</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">신청자 정보</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">기기 정보</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">수거 정보</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">예상 매입가</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">관리</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        <?php if (empty($requests)): ?>
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                                    신청 내역이 없습니다.
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($requests as $item): ?>
                                <?php
                                $devices = isset($item['devices']) ? $item['devices'] : array();
                                $first = !empty($devices) ? $devices[0] : null;
                                $total_units = 0;
                                foreach ($devices as $d) {
                                    $total_units += (int)$d['qty'];
                                }
                                ?>
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                        <?php echo html_escape($item['created_at']); ?>
                                    </td>

                                    <td class="px-6 py-4">
                                        <div class="text-sm font-medium text-gray-900 dark:text-white">
                                            <?php echo html_escape($item['applicant_name']); ?>
                                        </div>
                                        <div class="text-sm text-gray-500">
                                            <?php echo html_escape($item['phone']); ?>
                                        </div>
                                        <div class="text-xs text-gray-400 mt-1">
                                            <?php echo html_escape(trim($item['address1'] . ' ' . $item['address2'])); ?>
                                        </div>
                                    </td>

                                    <td class="px-6 py-4">
                                        <?php if ($first): ?>
                                            <div class="text-sm font-bold text-primary">다중 기기 (<?php echo $total_units; ?>대)</div>
                                            <div class="text-sm text-gray-900 dark:text-white">
                                                <?php echo html_escape($first['device']); ?> · <?php echo html_escape($first['manufacturer']); ?>
                                            </div>
                                            <div class="text-xs text-gray-500 mt-1">
                                                <?php echo html_escape($first['model']); ?> · <?php echo html_escape($first['condition']); ?>
                                            </div>
                                        <?php else: ?>
                                            <div class="text-sm text-gray-400">기기 정보 없음</div>
                                        <?php endif; ?>
                                    </td>

                                    <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">
                                        <div><span class="font-medium">방문:</span> <?php echo html_escape($item['visit_date'] . ' ' . $item['visit_time']); ?></div>
                                        <div><span class="font-medium">장소:</span> <?php echo html_escape($item['pickup_location']); ?></div>
                                        <?php if (!empty($item['pickup_memo'])): ?>
                                            <div class="text-xs mt-1 text-gray-400"><?php echo html_escape($item['pickup_memo']); ?></div>
                                        <?php endif; ?>
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900 dark:text-white">
                                        <?php echo html_escape($item['total_price_text']); ?>
                                        <div class="text-xs font-normal text-gray-500 mt-1">
                                            <?php echo html_escape($item['bank_name'] . ' ' . $item['account_number']); ?>
                                        </div>
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <a href="<?php echo site_url('admin/buyback/delete/' . $item['id']); ?>"
                                           onclick="return confirm('정말 삭제하시겠습니까?');"
                                           class="text-red-600 hover:text-red-900 dark:hover:text-red-400">
                                            삭제
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

</div>