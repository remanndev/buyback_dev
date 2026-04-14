<?php
$seg1 = isset($arr_seg[1]) ? $arr_seg[1] : '';
$seg2 = isset($arr_seg[2]) ? $arr_seg[2] : '';
$seg3 = isset($arr_seg[3]) ? $arr_seg[3] : '';
?>

<div class="snb_header">
    <h2>회원 관리</h2>
</div>

<dl>
    <dt class="m10 menu_toggle">일반회원 관리</dt>
    <dd class="m10 list-minus <?php echo ($seg2 === 'user' && $seg3 === 'lists') ? 'active' : ''; ?>"><a href="<?php echo base_url() ?>admin/user/lists">일반회원 목록</a></dd>
    <dd class="m10 list-minus <?php echo ($seg2 === 'user' && $seg3 === 'write') ? 'active' : ''; ?>"><a href="<?php echo base_url() ?>admin/user/write">회원 등록/수정</a></dd>

    <dt class="m20 menu_toggle">회원사 관리</dt>
    <dd class="m20 list-minus <?php echo ($seg2 === 'partner' && $seg3 === 'lists') ? 'active' : ''; ?>"><a href="<?php echo base_url() ?>admin/partner/lists">회원사 목록</a></dd>
    <dd class="m20 list-minus <?php echo ($seg2 === 'partner' && $seg3 === 'write') ? 'active' : ''; ?>"><a href="<?php echo base_url() ?>admin/partner/write">회원사 등록/수정</a></dd>
    <dd class="m20 list-minus <?php echo ($seg2 === 'partner' && ($seg3 === 'admins' || $seg3 === 'adminwrite')) ? 'active' : ''; ?>"><a href="<?php echo base_url() ?>admin/partner/admins">회원사 매니저 관리</a></dd>

    <dt class="m30 menu_toggle">관리자 관리</dt>
    <dd class="m30 list-minus <?php echo ($seg2 === 'user' && $seg3 === 'admlists') ? 'active' : ''; ?>"><a href="<?php echo base_url() ?>admin/user/admlists">관리자 목록</a></dd>
    <dd class="m30 list-minus <?php echo ($seg2 === 'user' && $seg3 === 'admwrite') ? 'active' : ''; ?>"><a href="<?php echo base_url() ?>admin/user/admwrite">관리자 등록/수정</a></dd>
</dl>