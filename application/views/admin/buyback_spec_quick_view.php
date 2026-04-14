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
$inline_update_url = base_url('admin/buyback/spec_ajax_update');
?>
<div class="admin_wrap">
    <h1 class="d-flex justify-content-between align-items-center">
        <div>가격 기준 빠른수정</div>
        <div class="btn-group" role="group">
            <a href="<?php echo base_url('admin/buyback/spec_lists'); ?>" class="btn btn-outline-secondary btn-sm">읽기 전용 목록</a>
            <a href="<?php echo $filtered_download_url; ?>" class="btn btn-outline-secondary btn-sm">검색 결과 다운로드</a>
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
                        <a href="<?php echo base_url('admin/buyback/spec_quick'); ?>" class="btn btn-outline-secondary">초기화</a>
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
                            <tr data-id="<?php echo (int) $row['id']; ?>" data-save-url="<?php echo html_escape($inline_update_url); ?>">
                                <td><?php echo (int) $row['id']; ?></td>
                                <td><?php echo html_escape($row['device_type']); ?></td>
                                <td><?php echo html_escape($row['part_type']); ?></td>
                                <td><?php echo html_escape($row['manufacturer']); ?></td>
                                <td><?php echo html_escape($row['category_name']); ?></td>
                                <td class="js-edit-cell">
                                    <input
                                        type="text"
                                        class="form-control form-control-sm js-quick-input"
                                        data-field="model_name"
                                        data-original="<?php echo html_escape($row['model_name']); ?>"
                                        value="<?php echo html_escape($row['model_name']); ?>"
                                    >
                                </td>
                                <td class="js-edit-cell" style="min-width: 140px; width: 140px;">
                                    <input
                                        type="text"
                                        class="form-control form-control-sm js-quick-input js-price-input"
                                        data-field="price_value"
                                        data-original="<?php echo ($row['price_value'] === null || $row['price_value'] === '') ? '' : (int) $row['price_value']; ?>"
                                        value="<?php echo ($row['price_value'] === null || $row['price_value'] === '') ? '' : number_format((int) $row['price_value']); ?>"
                                        placeholder="문의"
                                        inputmode="numeric"
                                    >
                                </td>
                                <td class="js-edit-cell" style="min-width: 96px; width: 96px;">
                                    <input
                                        type="text"
                                        class="form-control form-control-sm js-quick-input"
                                        data-field="sort_order"
                                        data-original="<?php echo (int) $row['sort_order']; ?>"
                                        value="<?php echo (int) $row['sort_order']; ?>"
                                        inputmode="numeric"
                                    >
                                </td>
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

        <style>
            .js-edit-cell {
                transition: background-color 0.25s ease;
            }

            .js-edit-cell.is-editing {
                background-color: #eef5ff;
            }

            .js-edit-cell.is-success {
                background-color: #e7f7ee;
            }

            .js-edit-cell.is-error {
                background-color: #fdeceb;
            }
        </style>

        <script>
            (function($) {
                function normalizeValue(field, value) {
                    var raw = $.trim(value || '');

                    if (field === 'price_value' || field === 'sort_order') {
                        return raw.replace(/[^0-9\-]/g, '');
                    }

                    return raw;
                }

                function formatPrice(value) {
                    var normalized = normalizeValue('price_value', value);
                    if (normalized === '') {
                        return '';
                    }

                    if (!/^-?\d+$/.test(normalized)) {
                        return value;
                    }

                    return normalized.replace(/\B(?=(\d{3})+(?!\d))/g, ',');
                }

                function clearCellState($cell) {
                    $cell.removeClass('is-editing is-success is-error');
                    window.clearTimeout($cell.data('flashTimer'));
                }

                function flashCell($cell, className) {
                    clearCellState($cell);
                    $cell.addClass(className);
                    $cell.data('flashTimer', window.setTimeout(function() {
                        $cell.removeClass(className);
                    }, 900));
                }

                function getOriginalValue($input) {
                    var original = $input.data('original');
                    if (original === undefined || original === null) {
                        return '';
                    }

                    return String(original);
                }

                function applySavedValue($input, response) {
                    var field = $input.data('field');
                    var normalized = response && response.value !== undefined && response.value !== null ? String(response.value) : '';
                    var displayValue = response && response.display_value !== undefined && response.display_value !== null ? String(response.display_value) : normalized;

                    if (field === 'price_value') {
                        displayValue = formatPrice(displayValue);
                    }

                    $input.val(displayValue).data('original', normalized);
                }

                function saveField($input) {
                    var $row = $input.closest('tr');
                    var $cell = $input.closest('.js-edit-cell');
                    var field = $input.data('field');
                    var normalized = normalizeValue(field, $input.val());

                    if ($input.data('saving')) {
                        return;
                    }

                    if (normalized === getOriginalValue($input)) {
                        clearCellState($cell);
                        if (field === 'price_value') {
                            $input.val(formatPrice($input.val()));
                        }
                        return;
                    }

                    $input.data('saving', true);

                    $.ajax({
                        url: $row.data('save-url'),
                        type: 'POST',
                        dataType: 'json',
                        data: {
                            id: $row.data('id'),
                            field: field,
                            value: normalized
                        },
                        global: false
                    }).done(function(response) {
                        if (response && response.result === 'ok' && response.field === field) {
                            applySavedValue($input, response);
                            flashCell($cell, 'is-success');
                            return;
                        }

                        flashCell($cell, 'is-error');
                    }).fail(function() {
                        flashCell($cell, 'is-error');
                    }).always(function() {
                        $input.data('saving', false);
                    });
                }

                $(function() {
                    $('.js-price-input').each(function() {
                        $(this).val(formatPrice($(this).val()));
                    });

                    $(document).on('focus', '.js-quick-input', function() {
                        var $cell = $(this).closest('.js-edit-cell');
                        clearCellState($cell);
                        $cell.addClass('is-editing');
                    });

                    $(document).on('blur', '.js-quick-input', function() {
                        var $input = $(this);
                        var $cell = $input.closest('.js-edit-cell');
                        var field = $input.data('field');

                        if (field === 'price_value') {
                            $input.val(formatPrice($input.val()));
                        }

                        $cell.removeClass('is-editing');
                        saveField($input);
                    });
                });
            })(jQuery);
        </script>
    <?php endif; ?>
</div>
