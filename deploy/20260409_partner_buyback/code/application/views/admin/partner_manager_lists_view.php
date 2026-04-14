<div class="admin_wrap">
    <h1>회원사 매니저 목록</h1>

    <div class="tbl_basic">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th class="text-center">NO</th>
                    <th>회원사</th>
                    <th>슬러그</th>
                    <th>매니저 아이디</th>
                    <th>이름</th>
                    <th>이메일</th>
                    <th>TYPE</th>
                    <th>상태</th>
                    <th class="text-center">관리</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($manager_rows)) { ?>
                    <?php foreach ($manager_rows as $index => $row) { ?>
                    <tr>
                        <td class="text-center"><?php echo $index + 1; ?></td>
                        <td><?php echo html_escape($row['partner_name']); ?></td>
                        <td><?php echo html_escape($row['partner_slug']); ?></td>
                        <td><?php echo html_escape($row['username']); ?></td>
                        <td><?php echo html_escape($row['nickname']); ?></td>
                        <td><?php echo html_escape($row['email']); ?></td>
                        <td><?php echo html_escape($row['type']); ?></td>
                        <td><?php echo ((int) $row['activated'] === 1) ? '사용' : '중지'; ?></td>
                        <td class="text-center">
                            <a href="/admin/partner/adminwrite/<?php echo $row['partner_id']; ?>/<?php echo $row['admin_user_id']; ?>"><button class="btn btn-secondary btn-xs">수정</button></a>
                        </td>
                    </tr>
                    <?php } ?>
                <?php } else { ?>
                    <tr>
                        <td colspan="9" class="text-center">등록된 회원사 매니저가 없습니다.</td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>
