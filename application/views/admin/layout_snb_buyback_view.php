<?php
$seg3 = isset($arr_seg[3]) ? $arr_seg[3] : '';
$is_spec_menu = in_array($seg3, array('spec_lists', 'spec_quick', 'spec_write', 'spec_excel', 'spec_excel_download', 'spec_excel_template'), true);
?>

<div class="snb_header">
    <h2><?php echo $is_spec_menu ? '매입기준 관리' : '매입신청 관리'; ?></h2>
</div>

<dl>
    <dt class="m10 menu_toggle">매입기준 관리</dt>
    <dd class="m10 list-minus <?php echo ($seg3 === 'spec_lists') ? 'active' : ''; ?>"><a href="<?php echo base_url(); ?>admin/buyback/spec_lists">가격 기준 목록</a></dd>
    <dd class="m10 list-minus <?php echo ($seg3 === 'spec_quick') ? 'active' : ''; ?>"><a href="<?php echo base_url(); ?>admin/buyback/spec_quick">가격 기준 빠른수정</a></dd>
    <dd class="m10 list-minus <?php echo ($seg3 === 'spec_write') ? 'active' : ''; ?>"><a href="<?php echo base_url(); ?>admin/buyback/spec_write">가격 기준 등록/수정</a></dd>
    <dd class="m10 list-minus <?php echo ($seg3 === 'spec_excel') ? 'active' : ''; ?>"><a href="<?php echo base_url(); ?>admin/buyback/spec_excel">엑셀 업로드</a></dd>

    <dt class="m20 menu_toggle">매입신청 관리</dt>
    <dd class="m20 list-minus <?php echo ($seg3 === 'list') ? 'active' : ''; ?>"><a href="<?php echo base_url(); ?>admin/buyback/list">전체 신청 목록</a></dd>
    <dd class="m20 list-minus <?php echo ($seg3 === 'partner_lists') ? 'active' : ''; ?>"><a href="<?php echo base_url(); ?>admin/buyback/partner_lists">회원사별 신청 목록</a></dd>
    <dd class="m20 list-minus <?php echo ($seg3 === 'ready_lists') ? 'active' : ''; ?>"><a href="<?php echo base_url(); ?>admin/buyback/ready_lists">전송 대기 목록</a></dd>
    <dd class="m20 list-minus <?php echo ($seg3 === 'sent_lists') ? 'active' : ''; ?>"><a href="<?php echo base_url(); ?>admin/buyback/sent_lists">전송 완료 목록</a></dd>
    <dd class="m20 list-minus <?php echo ($seg3 === 'failed_lists') ? 'active' : ''; ?>"><a href="<?php echo base_url(); ?>admin/buyback/failed_lists">전송 실패 목록</a></dd>
</dl>