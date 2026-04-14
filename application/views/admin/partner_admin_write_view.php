<div class="admin_wrap">
    <h1>회원사 추가 매니저 <?php echo ($user_idx > 0) ? '수정' : '등록'; ?></h1>
    <h2><?php echo html_escape($partner['name']); ?> (<?php echo html_escape($partner['slug']); ?>)</h2>

    <?php if (!empty($errors['account'])) { ?>
        <div class="err_color_red" style="margin-bottom:16px;"><?php echo $errors['account']; ?></div>
    <?php } ?>

    <?php echo form_open($this->uri->uri_string(), array('id'=>'partner_admin_form','name'=>'partner_admin_form')); ?>
    <input type="hidden" name="admin_type" value="PARTNER" />

    <div class="tbl_frm">
        <table>
            <colgroup>
                <col>
                <col>
                <col>
                <col>
            </colgroup>
            <tr>
                <th>회원사</th>
                <td><?php echo html_escape($partner['name']); ?></td>
                <th>타입</th>
                <td>PARTNER</td>
            </tr>
            <tr>
                <th>아이디</th>
                <td>
                    <?php if ($user_idx > 0) { ?>
                        <?php echo html_escape($row->username); ?>
                        <input type="hidden" name="username" value="<?php echo html_escape($row->username); ?>" />
                    <?php } else { ?>
                        <input type="text" name="username" value="<?php echo set_value('username'); ?>" class="o_input" />
                        <?php echo form_error('username', '<div class="err_color_red">', '</div>'); ?>
                    <?php } ?>
                </td>
                <th>비밀번호</th>
                <td>
                    <input type="password" name="member_pw" value="" class="o_input" placeholder="비밀번호" />
                    <input type="password" name="member_pw_confirm" value="" class="o_input" placeholder="비밀번호 확인" />
                    <?php echo form_error('member_pw', '<div class="err_color_red">', '</div>'); ?>
                    <?php echo form_error('member_pw_confirm', '<div class="err_color_red">', '</div>'); ?>
                    <?php if ($user_idx > 0) { ?>
                        <small style="display:block; margin-top:8px; color:#666;">비밀번호 변경이 필요할 때만 입력해 주세요.</small>
                    <?php } ?>
                </td>
            </tr>
            <tr>
                <th>이름</th>
                <td>
                    <input type="text" name="nickname" value="<?php echo set_value('nickname', isset($row->nickname) ? $row->nickname : ''); ?>" class="o_input" />
                    <?php echo form_error('nickname', '<div class="err_color_red">', '</div>'); ?>
                </td>
                <th>이메일</th>
                <td>
                    <input type="email" name="user_email" value="<?php echo set_value('user_email', isset($row->email) ? $row->email : ''); ?>" class="o_input" />
                    <?php echo form_error('user_email', '<div class="err_color_red">', '</div>'); ?>
                    <small style="display:block; color:#666;">선택 입력</small>
                </td>
            </tr>
        </table>
    </div>

    <div style="text-align:center; padding:40px 0 20px;">
        <input type="submit" name="submit" class="btn btn-dark btn-sm" value="저장" />
        <a href="/admin/partner/admins/<?php echo $partner['id']; ?>"><button type="button" class="btn btn-dark btn-sm">목록</button></a>
    </div>
    <?php echo form_close(); ?>
</div>