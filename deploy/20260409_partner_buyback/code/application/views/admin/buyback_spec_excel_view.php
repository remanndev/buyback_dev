<div class="admin_wrap">
    <h1 class="d-flex justify-content-between align-items-center">
        <div>매입 기준 엑셀 업로드</div>
        <a href="<?php echo base_url('admin/buyback/spec_excel_template'); ?>" class="btn btn-outline-primary btn-sm">샘플 양식 다운로드</a>
    </h1>

    <?php if (!empty($flash_message)): ?>
        <div class="alert alert-success"><?php echo html_escape($flash_message); ?></div>
    <?php endif; ?>

    <?php if (!empty($flash_error)): ?>
        <div class="alert alert-danger"><?php echo html_escape($flash_error); ?></div>
    <?php endif; ?>

    <?php if (empty($table_ready)): ?>
        <div class="alert alert-warning">`buyback_spec_master` 테이블이 아직 없습니다. SQL 반영 후 다시 확인해주세요.</div>
    <?php else: ?>
        <div class="card card-body mb-3">
            <h5>업로드 규칙</h5>
            <ul class="mb-0">
                <li>기본 모드는 <strong>신규만 등록</strong>입니다.</li>
                <li>같은 키가 있으면 기본은 스킵합니다.</li>
                <li><strong>기존 가격 업데이트 포함</strong>을 선택하면 중복 키의 가격, 정렬순서, 사용여부를 갱신합니다.</li>
                <li>중복 기준: 기기종류 + 부품종류 + 제조사 + 카테고리 + 모델명</li>
            </ul>
        </div>

        <div class="card card-body mb-3">
            <h5>엑셀 컬럼 순서</h5>
            <div class="table-responsive">
                <table class="table table-bordered table-sm mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>device_type</th>
                            <th>part_type</th>
                            <th>manufacturer</th>
                            <th>category_name</th>
                            <th>model_name</th>
                            <th>price_value</th>
                            <th>sort_order</th>
                            <th>is_active</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>노트북</td>
                            <td></td>
                            <td>Dell</td>
                            <td></td>
                            <td>10세대 i5/8G/X</td>
                            <td>96000</td>
                            <td>10</td>
                            <td>1</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <form method="post" enctype="multipart/form-data" class="card card-body">
            <div class="row g-3 align-items-end">
                <div class="col-md-5">
                    <label class="form-label">엑셀 파일</label>
                    <input type="file" name="excel_file" class="form-control" accept=".xls,.xlsx,.csv">
                </div>
                <div class="col-md-4">
                    <label class="form-label">처리 모드</label>
                    <select name="upload_mode" class="form-select">
                        <option value="skip">신규만 등록</option>
                        <option value="update_price">기존 가격 업데이트 포함</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <button type="submit" name="excel_upload_submit" value="1" class="btn btn-primary w-100">업로드 실행</button>
                </div>
            </div>
        </form>

        <?php if (!empty($upload_result)): ?>
            <div class="card card-body mt-3">
                <h5>처리 결과</h5>
                <div class="row g-3">
                    <div class="col-md-2">총 <?php echo (int) $upload_result['total']; ?>건</div>
                    <div class="col-md-2 text-success">신규 <?php echo (int) $upload_result['inserted']; ?>건</div>
                    <div class="col-md-2 text-primary">가격업데이트 <?php echo (int) $upload_result['updated']; ?>건</div>
                    <div class="col-md-2 text-secondary">중복스킵 <?php echo (int) $upload_result['skipped']; ?>건</div>
                    <div class="col-md-2 text-danger">오류 <?php echo (int) $upload_result['errors']; ?>건</div>
                </div>

                <?php if (!empty($upload_result['error_rows'])): ?>
                    <hr>
                    <h6>오류 행</h6>
                    <ul class="mb-0">
                        <?php foreach ($upload_result['error_rows'] as $error_row): ?>
                            <li><?php echo (int) $error_row['row_number']; ?>행: <?php echo html_escape($error_row['message']); ?></li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    <?php endif; ?>
</div>
