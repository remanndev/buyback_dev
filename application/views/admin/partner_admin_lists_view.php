<div class="admin_wrap">
    <h1>추가 매니저 관리</h1>
    <h2>
        <span style="display:inline-block; width:220px;"><?php echo html_escape($partner['name']); ?> (<?php echo html_escape($partner['slug']); ?>)</span>
        <span style="float:right;">
            <a href="/admin/partner/adminwrite/<?php echo $partner['id']; ?>"><button type="button" class="btn btn-dark btn-xs">추가 매니저 등록</button></a>
            <a href="/admin/partner/view/<?php echo $partner['id']; ?>"><button type="button" class="btn btn-secondary btn-xs">상세로 돌아가기</button></a>
        </span>
    </h2>

    <h2>대표 매니저</h2>
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
                <?php if (!empty($primary_admin)) { ?>
                    <tr>
                        <td><?php echo html_escape($primary_admin['username']); ?></td>
                        <td><?php echo html_escape($primary_admin['nickname']); ?></td>
                        <td><?php echo html_escape($primary_admin['email']); ?></td>
                        <td><?php echo html_escape($primary_admin['type']); ?></td>
                    </tr>
                <?php } else { ?>
                    <tr>
                        <td colspan="4" class="text-center">등록된 대표 매니저가 없습니다.</td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <h2>추가 매니저 목록</h2>
    <div class="tbl_basic">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>아이디</th>
                    <th>이름</th>
                    <th>이메일</th>
                    <th>타입</th>
                    <th class="text-center">관리</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($additional_partner_admins)) { ?>
                    <?php foreach ($additional_partner_admins as $admin) { ?>
                    <tr>
                        <td><?php echo html_escape($admin['username']); ?></td>
                        <td><?php echo html_escape($admin['nickname']); ?></td>
                        <td><?php echo html_escape($admin['email']); ?></td>
                        <td><?php echo html_escape($admin['type']); ?></td>
                        <td class="text-center">
                            <a href="/admin/partner/adminwrite/<?php echo $partner['id']; ?>/<?php echo $admin['id']; ?>"><button class="btn btn-secondary btn-xs">수정</button></a>
                            <a href="/admin/partner/admindel/<?php echo $partner['id']; ?>/<?php echo $admin['id']; ?>" onclick="del_confirm('admin/partner/admindel/<?php echo $partner['id']; ?>/<?php echo $admin['id']; ?>'); return false;"><button class="btn btn-danger btn-xs">삭제</button></a>
                        </td>
                    </tr>
                    <?php } ?>
                <?php } else { ?>
                    <tr>
                        <td colspan="5" class="text-center">등록된 추가 매니저가 없습니다.</td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <h2>관리자 연동</h2>
    <div class="panel panel-default-flat" style="padding:16px; border:1px solid #ddd;">
        <p style="margin-bottom:6px; color:#666;">BOTH 타입 계정은 사이트 관리자이면서 특정 회원사의 매니저 역할도 함께 사용할 수 있는 계정입니다.</p>
        <p style="margin-bottom:10px; color:#666;">아래에서 선택한 계정에 <strong style="color:#222;"><?php echo html_escape($partner['name']); ?></strong> 회원사의 매니저 권한을 연동합니다.</p>
        <?php echo form_open('/admin/partner/link_admin/' . $partner['id']); ?>
            <select name="admin_user_id" class="o_selectbox">
                <option value="">선택하세요</option>
                <?php foreach ($both_candidates as $admin) { ?>
                    <option value="<?php echo $admin['id']; ?>"><?php echo html_escape($admin['nickname'] . ' (' . $admin['username'] . ')'); ?></option>
                <?php } ?>
            </select>
            <button type="submit" class="btn btn-dark btn-xs">연결</button>
        <?php echo form_close(); ?>

        <?php if (!empty($both_admins)) { ?>
            <div style="margin-top:16px;">
                <strong>현재 연동된 BOTH 계정</strong>
                <ul style="margin-top:8px; padding-left:18px;">
                    <?php foreach ($both_admins as $admin) { ?>
                        <li>
                            <?php echo html_escape($admin['nickname']); ?> (<?php echo html_escape($admin['username']); ?>)
                            <a href="/admin/partner/unlink_admin/<?php echo $partner['id']; ?>/<?php echo $admin['id']; ?>" onclick="del_confirm('admin/partner/unlink_admin/<?php echo $partner['id']; ?>/<?php echo $admin['id']; ?>'); return false;" style="margin-left:8px; color:#c00;">연동 해제</a>
                        </li>
                    <?php } ?>
                </ul>
            </div>
        <?php } ?>
    </div>
</div>