<?php
$seg2 = isset($arr_seg[2]) ? $arr_seg[2] : '';
$seg3 = isset($arr_seg[3]) ? $arr_seg[3] : '';
$seg4 = isset($arr_seg[4]) ? $arr_seg[4] : '';

$is_user_section = ($seg2 === 'user' || $seg2 === '');
$title = ($seg2 === 'partner') ? '회원사 관리' : '회원 관리';
?>

<div class="snb_header">
    <h2><?php echo $title; ?></h2>
</div>

<dl>
    <?php if ($is_user_section) { ?>
    <dt class="m10 menu_toggle">일반회원 관리</dt>
    <dd class="m10 list-minus <?php echo ($seg2 === 'user' && $seg3 === 'lists') ? 'active' : ''; ?>"><a href="<?php echo base_url(); ?>admin/user/lists">일반회원 목록</a></dd>
    <dd class="m10 list-minus <?php echo ($seg2 === 'user' && $seg3 === 'write') ? 'active' : ''; ?>"><a href="<?php echo base_url(); ?>admin/user/write">일반회원 등록/수정</a></dd>

    <dt class="m20 menu_toggle">관리자 관리</dt>
    <dd class="m20 list-minus <?php echo ($seg2 === 'user' && $seg3 === 'admlists') ? 'active' : ''; ?>"><a href="<?php echo base_url(); ?>admin/user/admlists">관리자 목록</a></dd>
    <dd class="m20 list-minus <?php echo ($seg2 === 'user' && $seg3 === 'admwrite') ? 'active' : ''; ?>"><a href="<?php echo base_url(); ?>admin/user/admwrite">관리자 등록/수정</a></dd>
    <?php } ?>

    <?php if ($seg2 === 'partner') { ?>
    <dt class="m10 menu_toggle">회원사 관리</dt>
    <dd class="m10 list-minus <?php echo ($seg3 === 'lists') ? 'active' : ''; ?>"><a href="<?php echo base_url(); ?>admin/partner/lists">회원사 목록</a></dd>
    <dd class="m10 list-minus <?php echo ($seg3 === 'write' && empty($seg4)) ? 'active' : ''; ?>"><a href="<?php echo base_url(); ?>admin/partner/write">회원사 등록</a></dd>
    <dd class="m10 list-minus <?php echo ($seg3 === 'write' && !empty($seg4)) ? 'active' : ''; ?>"><a href="<?php echo base_url(); ?>admin/partner/lists" onclick="alert('회원사를 먼저 선택해주세요.'); return false;">회원사 수정</a></dd>
    <dd class="m10 list-minus <?php echo ($seg3 === 'view') ? 'active' : ''; ?>"><a href="<?php echo base_url(); ?>admin/partner/lists" onclick="alert('회원사를 먼저 선택해주세요.'); return false;">회원사 상세</a></dd>
    <dd class="m10 list-minus <?php echo ($seg3 === 'admins' || $seg3 === 'adminwrite') ? 'active' : ''; ?>"><a href="<?php echo base_url(); ?>admin/partner/admins">회원사 매니저 관리</a></dd>
    <dd class="m10 list-minus <?php echo ($seg3 === 'managerlists') ? 'active' : ''; ?>"><a href="<?php echo base_url(); ?>admin/partner/managerlists">회원사 매니저 목록</a></dd>
    <?php } ?>
</dl>
