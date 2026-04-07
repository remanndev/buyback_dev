<div class=" admin_wrap">

	<h1>장소 코드 관리</h1>

	<h2>삭제 코드 목록</h2>

	<div>
		<small>
			<!-- 검색 <span style="color:red;font-weight:bold;"><?php //echo $result['total_count'] ?></span> 개 /  -->
			전체 <span style="color:red;font-weight:bold;"><?php echo $total_cnt ?></span> 개
		</small>
	</div>
	<hr style="clear:both; margin:0; height:0;" />



	<div class="tbl_basic">
		<table class="table table-hover">
		<thead>
		<tr>
		  <th class='text-center' style="width: 70px;">NO</th>
		  <th class=''>장소 코드</th>
		  <th class=''>장소 이름</th>
		  <th class=''>관리자</th>
		  <th class=''>삭제 일시</th>
		  <th class=' text-center'>관리</th>
		</tr>
		</thead>
		<tbody>
		<?php
		foreach($result['qry'] as $i => $o)
		{
			// 번호
			$num = ($result['total_count'] - $limit*($page-1) - $i);
		?>
		<tr>
		  <td class="text-center"><?php echo $num ?></td>
		  <td><?php echo $o->pl_code ?></td>
		  <td><?php echo $o->pl_name ?></td>
		  <td><?php echo $o->del_admin ?></td>
		  <td><?php echo $o->del_datetime ?></td>
		  <td class=" text-center">
			<button type="button" class="btn btn-danger btn-xs"  onclick="del('admin/recycle/remove_place/<?php echo url_code($o->pl_code,'e') ?>','\n이 코드를 삭제하시면 재사용이 가능합니다.\n정말 삭제하시겠습니까?');">삭제</button>
		  </td>
		</tr>
		<?php
		}
		?>
		</tbody>
		</table>
	</div>

	<div style="text-align:center;"><?php echo $paging ?></div>

</div>
