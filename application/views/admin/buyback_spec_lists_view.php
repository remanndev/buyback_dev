<?php
$download_params = array();
foreach ($filters as $filter_key => $filter_value) {
    if ($filter_value === '' || $filter_value === null) {
        continue;
    }
    $download_params[$filter_key] = $filter_value;
}
$filtered_download_url = base_url('admin/buyback/spec_excel_download');
if (!empty($download_params)) {
    $filtered_download_url .= '?' . http_build_query($download_params);
}
?>
<div class="admin_wrap">
    <h1 class="d-flex justify-content-between align-items-center">
        <div>가격 기준 목록</div>
        <div class="btn-group" role="group">
            <a href="<?php echo base_url('admin/buyback/spec_excel_download'); ?>" class="btn btn-outline-secondary btn-sm">전체 다운로드</a>
            <a href="<?php echo $filtered_download_url; ?>" class="btn btn-outline-secondary btn-sm">검색 결과 다운로드</a>
            <a href="<?php echo base_url('admin/buyback/spec_quick'); ?>" class="btn btn-outline-primary btn-sm">빠른수정</a>
            <a href="<?php echo base_url('admin/buyback/spec_write'); ?>" class="btn btn-primary btn-sm">가격 기준 등록</a>
        </div>
    </h1>

    <?php if (!empty($flash_message)): ?>
        <div class="alert alert-success"><?php echo html_escape($flash_message); ?></div>
    <?php endif; ?>

    <?php if (!empty($flash_error)): ?>
        <div class="alert alert-danger"><?php echo html_escape($flash_error); ?></div>
    <?php endif; ?>

    <?php if (empty($table_ready)): ?>
        <div class="alert alert-warning">`buyback_spec_master` 테이블이 아직 없습니다. SQL 반영 여부를 다시 확인해 주세요.</div>
    <?php else: ?>
        <form method="get" class="card card-body mb-3">
            <div class="row g-2">
                <div class="col-md-2">
                    <label class="form-label">기기종류</label>
                    <select name="device_type" class="form-select form-select-sm">
                        <option value="">전체</option>
                        <?php foreach ($device_options as $option): ?>
                            <option value="<?php echo html_escape($option); ?>" <?php echo ($filters['device_type'] === $option) ? 'selected' : ''; ?>>
                                <?php echo html_escape($option); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">부품종류</label>
                    <select name="part_type" class="form-select form-select-sm">
                        <option value="">전체</option>
                        <?php foreach ($part_options as $option): ?>
                            <option value="<?php echo html_escape($option); ?>" <?php echo ($filters['part_type'] === $option) ? 'selected' : ''; ?>>
                                <?php echo html_escape($option); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">제조사</label>
                    <select name="manufacturer" class="form-select form-select-sm">
                        <option value="">전체</option>
                        <?php foreach ($manufacturer_options as $option): ?>
                            <option value="<?php echo html_escape($option); ?>" <?php echo ($filters['manufacturer'] === $option) ? 'selected' : ''; ?>>
                                <?php echo html_escape($option); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">사용 여부</label>
                    <select name="is_active" class="form-select form-select-sm">
                        <option value="">전체</option>
                        <option value="1" <?php echo ((string) $filters['is_active'] === '1') ? 'selected' : ''; ?>>사용</option>
                        <option value="0" <?php echo ((string) $filters['is_active'] === '0') ? 'selected' : ''; ?>>중지</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">검색어</label>
                    <div class="input-group input-group-sm">
                        <input type="text" name="keyword" value="<?php echo html_escape($filters['keyword']); ?>" class="form-control" placeholder="모델명 / 카테고리 / 제조사">
                        <button type="submit" class="btn btn-dark">검색</button>
                        <a href="<?php echo base_url('admin/buyback/spec_lists'); ?>" class="btn btn-outline-secondary">초기화</a>
                    </div>
                </div>
            </div>
        </form>

        <div class="mb-2 text-muted">총 <?php echo count($spec_rows); ?>건</div>

        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>기기종류</th>
                        <th>부품종류</th>
                        <th>제조사</th>
                        <th>카테고리</th>
                        <th>모델명</th>
                        <th>매입가</th>
                        <th>정렬</th>
                        <th>상태</th>
                        <th>관리</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($spec_rows)): ?>
                        <tr>
                            <td colspan="10" class="text-center text-muted py-4">등록된 가격 기준 데이터가 없습니다.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($spec_rows as $row): ?>
                            <tr>
                                <td><?php echo (int) $row['id']; ?></td>
                                <td><?php echo html_escape($row['device_type']); ?></td>
                                <td><?php echo html_escape($row['part_type']); ?></td>
                                <td><?php echo html_escape($row['manufacturer']); ?></td>
                                <td><?php echo html_escape($row['category_name']); ?></td>
                                <td><?php echo html_escape($row['model_name']); ?></td>
                                <td>
                                    <?php
                                    if ($row['price_value'] === null || $row['price_value'] === '') {
                                        echo '문의';
                                    } else {
                                        echo number_format((int) $row['price_value']);
                                    }
                                    ?>
                                </td>
                                <td><?php echo (int) $row['sort_order']; ?></td>
                                <td>
                                    <span class="badge bg-<?php echo ((int) $row['is_active'] === 1) ? 'success' : 'secondary'; ?>">
                                        <?php echo ((int) $row['is_active'] === 1) ? '사용' : '중지'; ?>
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex flex-wrap gap-1">
                                        <a href="<?php echo base_url('admin/buyback/spec_write/' . $row['id']); ?>" class="btn btn-outline-primary btn-sm">수정</a>
                                        <a href="<?php echo base_url('admin/buyback/spec_toggle/' . $row['id']); ?>" class="btn btn-outline-secondary btn-sm" onclick="return confirm('사용 여부를 변경하시겠습니까?');">
                                            <?php echo ((int) $row['is_active'] === 1) ? '비활성' : '활성'; ?>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>
