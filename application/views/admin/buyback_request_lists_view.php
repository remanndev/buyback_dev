<?php
$format_admin_buyback_price = function ($price_text, $price_value = null) {
    if ($price_value !== null && $price_value !== '') {
        return '₩ ' . number_format((int) $price_value);
    }

    $raw = trim((string) $price_text);
    if ($raw === '') {
        return '';
    }

    if (preg_match('/-?\d[\d,]*/u', $raw, $matches)) {
        $numeric = (int) str_replace(',', '', $matches[0]);
        return '₩ ' . number_format($numeric);
    }

    return $raw;
};
?>
<div class="admin_wrap">
    <h1><?php echo isset($page_title) ? html_escape($page_title) : '매입신청 목록'; ?></h1>

    <div class="panel panel-default-flat" style="margin-bottom:20px;">
        <div class="panel-heading">
            <?php echo form_open(current_url(), array('method' => 'get', 'style' => 'display:flex; gap:8px; align-items:center; flex-wrap:wrap;')); ?>
                <select name="partner_id" class="o_selectbox">
                    <option value="">전체 회원사</option>
                    <?php foreach ((array) $partner_options as $partner) { ?>
                        <option value="<?php echo $partner['id']; ?>" <?php echo ((string) $filters['partner_id'] === (string) $partner['id']) ? 'selected' : ''; ?>>
                            <?php echo html_escape($partner['name']); ?>
                        </option>
                    <?php } ?>
                </select>
                <select name="api_send_status" class="o_selectbox">
                    <option value="">전체 전송상태</option>
                    <option value="READY" <?php echo ($filters['api_send_status'] === 'READY') ? 'selected' : ''; ?>>READY</option>
                    <option value="SENT" <?php echo ($filters['api_send_status'] === 'SENT') ? 'selected' : ''; ?>>SENT</option>
                    <option value="FAILED" <?php echo ($filters['api_send_status'] === 'FAILED') ? 'selected' : ''; ?>>FAILED</option>
                </select>
                <button type="submit" class="btn btn-dark btn-xs">검색</button>
                <a href="<?php echo current_url(); ?>"><button type="button" class="btn btn-secondary btn-xs">초기화</button></a>
            <?php echo form_close(); ?>
        </div>
    </div>

    <div class="tbl_basic">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>접수일시</th>
                    <th>회원사</th>
                    <th>신청자</th>
                    <th>연락처</th>
                    <th>기기 요약</th>
                    <th>예상 매입가</th>
                    <th>상태</th>
                    <th>전송상태</th>
                    <th class="text-center">관리</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($requests)) { ?>
                    <tr>
                        <td colspan="9" class="text-center">신청 내역이 없습니다.</td>
                    </tr>
                <?php } else { ?>
                    <?php foreach ($requests as $item) { ?>
                        <?php
                        $devices = isset($item['devices']) ? $item['devices'] : array();
                        $first = !empty($devices) ? $devices[0] : null;
                        $api_status = isset($item['api_send_status']) ? $item['api_send_status'] : '-';
                        ?>
                        <tr>
                            <td><?php echo html_escape(isset($item['created_at']) ? $item['created_at'] : ''); ?></td>
                            <td><?php echo html_escape(isset($item['partner_name']) ? $item['partner_name'] : ''); ?></td>
                            <td><?php echo html_escape(isset($item['applicant_name']) ? $item['applicant_name'] : ''); ?></td>
                            <td><?php echo html_escape(isset($item['phone']) ? $item['phone'] : ''); ?></td>
                            <td>
                                <?php if ($first) { ?>
                                    <?php echo html_escape($first['device_type']); ?>
                                    <?php if (!empty($first['manufacturer'])) { ?> / <?php echo html_escape($first['manufacturer']); ?><?php } ?>
                                    <?php if (!empty($first['model_name'])) { ?><br /><small><?php echo html_escape($first['model_name']); ?></small><?php } ?>
                                <?php } else { ?>
                                    -
                                <?php } ?>
                            </td>
                            <td><?php echo html_escape($format_admin_buyback_price(isset($item['total_price_text']) ? $item['total_price_text'] : '', isset($item['total_price_value']) ? $item['total_price_value'] : null)); ?></td>
                            <td><?php echo html_escape(isset($item['status']) ? $item['status'] : ''); ?></td>
                            <td><?php echo html_escape($api_status); ?></td>
                            <td class="text-center">
                                <a href="<?php echo site_url('admin/buyback/delete/' . $item['id']); ?>" onclick="return confirm('정말 삭제하시겠습니까?');">
                                    <button type="button" class="btn btn-danger btn-xs">삭제</button>
                                </a>
                            </td>
                        </tr>
                    <?php } ?>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>
