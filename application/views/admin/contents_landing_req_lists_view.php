<div class=" admin_wrap">

	<h1 style="position:relative;">랜딩 페이지 목록</h1>

	<h2>랜딩 페이지 목록 </h2>

	<div class="tbl_basic">
		<table class="table table-hover" style="width:100%;">
			<thead>
			<tr class='text-center'>
			  <th style="width:80px;">코드</th>
			  <th>페이지 명</th>
			  <th style="width:200px;">사용 기간</th>
			  <!-- <th style="width:80px;">접수 여부</th>
			  <th style="width:120px;">작성자</th>
			  <th style="width:100px;">작성일</th>
			  <th style="width:100px;">관리</th> -->
			</tr>
			</thead>
			<tbody>
			<?php foreach ($list as $o): ?>
			<tr style="<?php echo ($o->use_yn != 'Y') ? 'background-color:#f7f7f7;' : ''; ?>">
			  <td class='text-center'><?php echo $o->code ?></td>
			  <td><a href="/admin/contents/landing/req_code/<?php echo $o->code ?>"><?php echo $o->title ?></a></td>
			  <td class='text-center'><?php echo $o->sdate ?> ~ <?php echo $o->edate ?></td>
			  <!-- <td class='text-center'><?php echo ($o->use_yn === 'Y') ? '<strong>사용</strong>' : '사용 안함' ?></td>
			  <td class='text-center'><?php echo $o->reg_username ?></td>
			  <td class='text-center'><?php echo $o->reg_date ?></td>
			  <td class='text-center'>
				<a href="/admin/contents/landing/form/<?php echo $o->idx ?>"><button type="button" class="btn btn-secondary btn-xs" onclick="location.href='/admin/contents/landing/form/<?php echo $o->idx ?>'">수정</button></a>
				<a href="javascript:post_send('admin/contents/landing/delete', {idx:'<?php echo $o->idx;?>'}, true);"><button type="button" class="btn btn-danger btn-xs">삭제</button></a>
			  </td> -->
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
