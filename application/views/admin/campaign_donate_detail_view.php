<!-- 
<h1>캠페인 기부 관리</h1>

<h2 class="mb_40" style="color:#353535;">기부자 목록</h2>




<div class="tbl_frm">
	<table class="table-hover">
	<tr>
	  <th class='text_center'>NO</th>
	  <th class=''>아이디</th>
	  <th class=''>이름</th>
	  <th class=''>기부일자</th>
	  <th class=''>기부내용</th>
	</tr>
	<?php foreach($list as $i => $o) { ?>
	<tr>
	  <td class="text_center"><?php echo $o->num ?></td>
	  <td><div class="ellipsis"><?php echo $o->user_username ?></div></td>
	  <td class="text_center"><?php echo $o->donor_name ?></td>
	  <td class="text_center"><?php echo $o->reg_date ?></td>
	  <td class="text_center"><a href="/admin/campaign/donate/donor/MLLXCS"><button type="button" class="btn btn-default-flat btn-sm">내역보기</button></a></td>
	</tr>
	<?php } ?>
	</table>
</div>
 -->
