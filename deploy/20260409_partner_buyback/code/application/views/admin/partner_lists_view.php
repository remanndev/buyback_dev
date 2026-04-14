<div class="admin_wrap">
    <h1>회원사 관리</h1>
    <h2>
        <span style="display:inline-block; width:120px;">회원사 목록</span>
        <span style="float:right;">
            <a href="/admin/partner/write"><button type="button" class="btn btn-dark btn-xs">회원사 등록</button></a>
        </span>
    </h2>

    <div class="tbl_basic">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th class="text-center">NO</th>
                    <th>슬러그</th>
                    <th>회원사명</th>
                    <th>활성</th>
                    <th>대표 관리자</th>
                    <th>관리자 타입</th>
                    <th class="text-center">관리</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($partners)) { ?>
                    <?php foreach ($partners as $index => $partner) { ?>
                    <tr>
                        <td class="text-center"><?php echo $index + 1; ?></td>
                        <td><?php echo html_escape($partner['slug']); ?></td>
                        <td><?php echo html_escape($partner['name']); ?></td>
                        <td><?php echo $partner['is_active'] ? 'Y' : 'N'; ?></td>
                        <td>
                            <?php echo html_escape($partner['admin_nickname']); ?>
                            <?php if (!empty($partner['admin_username'])) { ?>
                                <small>(<?php echo html_escape($partner['admin_username']); ?>)</small>
                            <?php } ?>
                        </td>
                        <td><?php echo html_escape($partner['admin_type']); ?></td>
                        <td class="text-center">
                            <a href="/admin/partner/view/<?php echo $partner['id']; ?>"><button class="btn btn-dark btn-xs">상세보기</button></a>
                            <a href="/admin/partner/write/<?php echo $partner['id']; ?>"><button class="btn btn-secondary btn-xs">수정</button></a>
                        </td>
                    </tr>
                    <?php } ?>
                <?php } else { ?>
                    <tr>
                        <td colspan="7" class="text-center">등록된 회원사가 없습니다.</td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>