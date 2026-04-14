<div class="admin_wrap">
    <h1>회원사 <?php echo ($partner_id > 0) ? '수정' : '등록'; ?></h1>
    <h2>기본 정보</h2>

    <?php if (!empty($errors['primary_account'])) { ?>
        <div class="err_color_red" style="margin-bottom:16px;"><?php echo $errors['primary_account']; ?></div>
    <?php } ?>

    <?php echo form_open($this->uri->uri_string(), array('id' => 'partner_form', 'name' => 'partner_form')); ?>

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
                <td>
                    <input type="text" name="name" value="<?php echo set_value('name', isset($partner['name']) ? $partner['name'] : ''); ?>" class="o_input" />
                    <?php echo form_error('name', '<div class="err_color_red">', '</div>'); ?>
                </td>
                <th>활성 여부</th>
                <td>
                    <label><?php echo form_checkbox('is_active', '1', set_checkbox('is_active', '1', isset($partner['is_active']) ? (bool) $partner['is_active'] : true)); ?> 사용</label>
                </td>
            </tr>
            <tr>
                <th>슬러그</th>
                <td colspan="3">
                    <?php if ($partner_id > 0) { ?>
                        <input type="text" name="slug" value="<?php echo html_escape(isset($partner['slug']) ? $partner['slug'] : ''); ?>" class="o_input" readonly="readonly" />
                        <small style="display:block; color:#666;">슬러그는 변경할 수 없습니다.</small>
                    <?php } else { ?>
                        <input type="text" name="slug" value="<?php echo set_value('slug', isset($partner['slug']) ? $partner['slug'] : ''); ?>" class="o_input" />
                        <?php echo form_error('slug', '<div class="err_color_red">', '</div>'); ?>
                        <small style="display:block; color:#666;">예: remann, replus</small>
                    <?php } ?>
                </td>
            </tr>
        </table>
    </div>

    <h2>대표 매니저 계정</h2>
    <div class="tbl_frm">
        <table>
            <colgroup>
                <col>
                <col>
                <col>
                <col>
            </colgroup>
            <tr>
                <th>아이디</th>
                <td>
                    <?php if (!empty($primary_admin)) { ?>
                        <input type="text" name="admin_username" value="<?php echo html_escape($primary_admin['username']); ?>" class="o_input" readonly="readonly" />
                        <small style="display:block; color:#666;">아이디는 변경할 수 없습니다.</small>
                    <?php } else { ?>
                        <input type="text" name="admin_username" value="<?php echo set_value('admin_username'); ?>" class="o_input" />
                        <?php echo form_error('admin_username', '<div class="err_color_red">', '</div>'); ?>
                    <?php } ?>
                </td>
                <th>비밀번호</th>
                <td>
                    <input type="password" name="admin_password" value="" class="o_input" placeholder="비밀번호" />
                    <input type="password" name="admin_password_confirm" value="" class="o_input" placeholder="비밀번호 확인" />
                    <?php echo form_error('admin_password', '<div class="err_color_red">', '</div>'); ?>
                    <?php echo form_error('admin_password_confirm', '<div class="err_color_red">', '</div>'); ?>
                    <?php if ($partner_id > 0 && !$require_primary_admin) { ?>
                        <small style="display:block; margin-top:8px; color:#666;">비밀번호를 변경할 때만 입력해 주세요.</small>
                    <?php } ?>
                </td>
            </tr>
            <tr>
                <th>이름</th>
                <td>
                    <input type="text" name="admin_nickname" value="<?php echo set_value('admin_nickname', !empty($primary_admin['nickname']) ? $primary_admin['nickname'] : ''); ?>" class="o_input" />
                    <?php echo form_error('admin_nickname', '<div class="err_color_red">', '</div>'); ?>
                </td>
                <th>이메일</th>
                <td>
                    <input type="email" name="admin_email" value="<?php echo set_value('admin_email', !empty($primary_admin['email']) ? $primary_admin['email'] : ''); ?>" class="o_input" />
                    <?php echo form_error('admin_email', '<div class="err_color_red">', '</div>'); ?>
                    <small style="display:block; color:#666;">선택 입력</small>
                </td>
            </tr>
        </table>
    </div>

    <div style="text-align:center; padding:40px 0 20px;">
        <input type="submit" name="submit" class="btn btn-dark btn-sm" value="저장" />
        <?php if ($partner_id > 0) { ?>
            <a href="/admin/partner/view/<?php echo $partner_id; ?>"><button type="button" class="btn btn-dark btn-sm">상세</button></a>
        <?php } ?>
        <a href="/admin/partner/lists"><button type="button" class="btn btn-dark btn-sm">목록</button></a>
    </div>

    <?php echo form_close(); ?>
</div>