
<h1>캠페인 관리</h1>

<h2 class="mb_40" style="color:#353535;">캠페인 목록</h2>

<div class="tbl_frm">
	<table class="table-hover">
	<colgroup>
	  <col style="width: 70px;" />
	  <col style="width: 120px;" />
	  <col style="width: 140px;" />
	  <col />
	  <col />
	  <col />
	  <col />
	  <col />
	</colgroup>
	<tr>
	  <th class='text_center'>NO</th>
	  <th class=''>카테고리</th>
	  <th class=''>이미지</th>
	  <th class=''>개설기관</th>
	  <th class=''>캠페인명</th>
	  <th class=''>모금기간</th>
	  <th class=''>작성일자</th>
	  <th class=''>단계</th>
	  <th class='text_center'>관리</th>
	</tr>
	<?php foreach($list as $i => $o) { ?>
	<tr>
	  <td class="text_center"><?php echo $o->num ?></td>
	  <td class="text_center"><?php echo $o->cmp_cate ?></td>
	  <td class="text_center"><img src="<?php echo $o->campaign_main_src ?>" style="width: 100px;" /></td>
	  <td class="text_center"><?php echo $o->cmp_org_name ?></td>
	  <td><a href="/admin/campaign/detail/<?php echo $o->idx ?>/<?php echo $o->state?>"><div class="ellipsis" style="text-decoration: underline;"><?php echo $o->cmp_title ?></div></a></td>
	  <td class="text_center"><?php echo $o->cmp_term ?></td>
	  <td class="text_center"><?php echo $o->reg_date ?></td>
	  <td class="text_center"><button class="btn <?php echo $o->btn_type ?> btn-xs" disabled><?php echo $o->state_str ?></button></td>
	  <td class="text_center">
		<!-- <a href="/mypage/campaign/write/<?php echo $o->idx ?>"><button class="btn btn-gray-flat btn-xs">수정</button></a> -->
		<a href="#" onclick="del_confirm('admin/campaign/adm_del/<?php echo $o->idx ?>'); return false;"><button class="btn btn-danger-flat btn-xs">삭제</button></a>
	  </td>
	</tr>
	<?php } ?>
	</table>
</div>

