<div class=" admin_wrap">

	<h1 style="position:relative;"><?php echo $landing_title ?></h1>

	<h2>접수 목록 </h2>

	<div class="tbl_basic">
		<table class="table table-hover" style="width:100%;">
			<thead>
			<tr class='text-center'>
			  <th style="width:80px;">NO</th>
			  <?php
				foreach($arr_fld_nm as $i => $fld_nm) {
				  $no = $i + 1;
				  if(trim($arr_fld_nm[$i]) == '') {
					continue;
				  }
				  if(trim($arr_fld_type[$i]) != 'input:text') {
					continue;
				  }
			  ?>
			  <th><?php echo $fld_nm ?></th>
			  <?php } ?>
			  <!-- <th>기관명</th>
			  <th>담당자명</th>
			  <th>연락처</th>
			  <th>이메일</th>
			  <th>홈페이지</th> -->
			  <th style="width:120px;">관리</th>
			</tr>
			</thead>
			<tbody>
			<?php foreach ($list as $o): ?>
			<tr>
			  <td class='text-center'><?php echo $o->num ?></td>
			  <?php
				foreach($arr_fld_nm as $i => $fld_nm) {
				  $no = $i + 1;
				  if(trim($arr_fld_nm[$i]) == '') {
					continue;
				  }
				  if(trim($arr_fld_type[$i]) != 'input:text') {
					continue;
				  }
			  ?>
			  <td class='text-center'><?php echo $o->txtfld[$no] ?></td>
			  <?php } ?>

			  <!-- <td class='text-center'><?php echo $o->fld_1 ?></td>
			  <td class='text-center'><?php echo $o->fld_2 ?></td>
			  <td class='text-center'><?php echo $o->fld_3 ?></td>
			  <td class='text-center'><?php echo $o->fld_4 ?></td>
			  <td class='text-center'><?php echo $o->fld_5 ?></td> -->

			  <td class='text-center'>
				<button type="button" class="btn btn-secondary btn-xs">확인</button>
				<button type="button" class="btn btn-danger btn-xs">삭제</button>
			  </td>
			</tr>
			<?php endforeach; ?>
			</tbody>
		</table>


		<div class="clearfix">
			<div class="text-center">
				<?php echo $paging?>
			</div>
		</div>

	</div>

</div>
