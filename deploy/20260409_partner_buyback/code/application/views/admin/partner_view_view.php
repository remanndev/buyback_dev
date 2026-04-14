<div class="admin_wrap">
    <h1>회원사 상세</h1>
    <h2><?php echo html_escape($partner['name']); ?> (<?php echo html_escape($partner['slug']); ?>)</h2>

    <div class="tbl_frm">
        <table>
            <colgroup>
                <col>
                <col>
                <col>
                <col>
            </colgroup>
            <tr>
                <th>회원사명</th>
                <td><?php echo html_escape($partner['name']); ?></td>
                <th>활성 여부</th>
                <td><?php echo !empty($partner['is_active']) ? '사용' : '중지'; ?></td>
            </tr>
            <tr>
                <th>슬러그</th>
                <td><?php echo html_escape($partner['slug']); ?></td>
                <th>대표 매니저</th>
                <td>
                    <?php if (!empty($primary_admin)) { ?>
                        <?php echo html_escape($primary_admin['nickname']); ?>
                        <small>(<?php echo html_escape($primary_admin['username']); ?>)</small>
                    <?php } else { ?>
                        <span style="color:#999;">등록된 대표 매니저가 없습니다.</span>
                    <?php } ?>
                </td>
            </tr>
            <?php if (!empty($primary_admin)) { ?>
            <tr>
                <th>대표 매니저 이메일</th>
                <td><?php echo html_escape($primary_admin['email']); ?></td>
                <th>대표 매니저 타입</th>
                <td><?php echo html_escape($primary_admin['type']); ?></td>
            </tr>
            <?php } ?>
        </table>
    </div>

    <div style="text-align:center; padding:40px 0 20px;">
        <a href="/admin/partner/write/<?php echo $partner['id']; ?>"><button type="button" class="btn btn-dark btn-sm">수정</button></a>
        <a href="/admin/partner/admins/<?php echo $partner['id']; ?>"><button type="button" class="btn btn-dark btn-sm">추가 매니저 관리</button></a>
        <a href="/admin/partner/del/<?php echo $partner['id']; ?>" onclick="del_confirm('admin/partner/del/<?php echo $partner['id']; ?>'); return false;"><button type="button" class="btn btn-danger btn-sm">삭제</button></a>
        <a href="/admin/partner/lists"><button type="button" class="btn btn-dark btn-sm">목록</button></a>
    </div>

    <h2>현재 연결된 추가 매니저</h2>
    <div class="tbl_basic">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>아이디</th>
                    <th>이름</th>
                    <th>이메일</th>
                    <th>타입</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($additional_partner_admins) || !empty($both_admins)) { ?>
                    <?php foreach ($additional_partner_admins as $admin) { ?>
                    <tr>
                        <td><?php echo html_escape($admin['username']); ?></td>
                        <td><?php echo html_escape($admin['nickname']); ?></td>
                        <td><?php echo html_escape($admin['email']); ?></td>
                        <td><?php echo html_escape($admin['type']); ?></td>
                    </tr>
                    <?php } ?>
                    <?php foreach ($both_admins as $admin) { ?>
                    <tr>
                        <td><?php echo html_escape($admin['username']); ?></td>
                        <td><?php echo html_escape($admin['nickname']); ?></td>
                        <td><?php echo html_escape($admin['email']); ?></td>
                        <td><?php echo html_escape($admin['type']); ?></td>
                    </tr>
                    <?php } ?>
                <?php } else { ?>
                    <tr>
                        <td colspan="4" class="text-center">연결된 추가 매니저가 없습니다.</td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>