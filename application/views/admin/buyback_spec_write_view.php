<?php
$row = isset($row) && is_array($row) ? $row : array();
?>
<div class="admin_wrap">
    <h1><?php echo !empty($is_edit) ? '매입 기준 수정' : '매입 기준 등록'; ?></h1>

    <?php if (!empty($flash_error)): ?>
        <div class="alert alert-danger"><?php echo html_escape($flash_error); ?></div>
    <?php endif; ?>

    <?php echo validation_errors('<div class="alert alert-danger">', '</div>'); ?>

    <?php if (empty($table_ready)): ?>
        <div class="alert alert-warning">`buyback_spec_master` 테이블이 아직 없습니다. SQL 반영 후 다시 확인해주세요.</div>
    <?php else: ?>
        <form method="post" class="card card-body">
            <div class="row g-3">
                <div class="col-md-3">
                    <label class="form-label">기기종류</label>
                    <input type="text" name="device_type" class="form-control" value="<?php echo html_escape(isset($row['device_type']) ? $row['device_type'] : ''); ?>" placeholder="노트북 / 데스크탑 / 모니터 / 부품">
                </div>
                <div class="col-md-3">
                    <label class="form-label">부품종류</label>
                    <input type="text" name="part_type" class="form-control" value="<?php echo html_escape(isset($row['part_type']) ? $row['part_type'] : ''); ?>" placeholder="CPU / RAM / SSD / VGA">
                </div>
                <div class="col-md-3">
                    <label class="form-label">제조사</label>
                    <input type="text" name="manufacturer" class="form-control" value="<?php echo html_escape(isset($row['manufacturer']) ? $row['manufacturer'] : ''); ?>" placeholder="Dell / HP / 삼성">
                </div>
                <div class="col-md-3">
                    <label class="form-label">카테고리</label>
                    <input type="text" name="category_name" class="form-control" value="<?php echo html_escape(isset($row['category_name']) ? $row['category_name'] : ''); ?>" placeholder="인텔 12세대 / 삼성-LG">
                </div>
                <div class="col-md-6">
                    <label class="form-label">모델명 / 상세 사양</label>
                    <input type="text" name="model_name" class="form-control" value="<?php echo html_escape(isset($row['model_name']) ? $row['model_name'] : ''); ?>" placeholder="i5 12400 / 10세대 i5/8G/X">
                </div>
                <div class="col-md-2">
                    <label class="form-label">매입가</label>
                    <input type="text" name="price_value" class="form-control" value="<?php echo html_escape(isset($row['price_value']) ? $row['price_value'] : ''); ?>" placeholder="공란 허용">
                    <div class="form-text">공란이면 문의 처리</div>
                </div>
                <div class="col-md-2">
                    <label class="form-label">정렬순서</label>
                    <input type="number" name="sort_order" class="form-control" value="<?php echo html_escape(isset($row['sort_order']) ? $row['sort_order'] : '100'); ?>">
                </div>
                <div class="col-md-2">
                    <label class="form-label">사용여부</label>
                    <select name="is_active" class="form-select">
                        <option value="1" <?php echo (!isset($row['is_active']) || (string) $row['is_active'] === '1') ? 'selected' : ''; ?>>사용</option>
                        <option value="0" <?php echo (isset($row['is_active']) && (string) $row['is_active'] === '0') ? 'selected' : ''; ?>>중지</option>
                    </select>
                </div>
            </div>

            <div class="mt-4 d-flex gap-2">
                <button type="submit" class="btn btn-primary"><?php echo !empty($is_edit) ? '수정 저장' : '등록 저장'; ?></button>
                <a href="<?php echo base_url('admin/buyback/spec_lists'); ?>" class="btn btn-outline-secondary">목록</a>
            </div>
        </form>
    <?php endif; ?>
</div>
