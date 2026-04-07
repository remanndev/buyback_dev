<div class=" admin_wrap">

	<h1 style="position:relative;">
		컨텐츠 페이지 목록 <?php echo isset($this->bn_list_title) ? ' - <span style="font-size:17px; padding:5px 7px; background-color:#dedede;">' .$this->bn_list_title. '</span>' : ''; ?>
		<a href="/admin/contents/page/form"><button type="button" class="btn btn-dark btn-ssm" style="position:absolute; bottom:9px; right:0;" onclick="location.href='/admin/contents/page/form'">페이지 등록하기</button></a>
	</h1>

	<h2>컨텐츠 페이지 목록</h2>

	<div class="tbl_basic">
		<table class="table table-hover" style="width:100%;">
			<thead>
			<tr class='text-center'>
			  <th style="width:60px;">NO</th>
			  <th>페이지 명</th>
			  <th style="width:120px;">사용 여부</th>
			  <!-- <th style="width:120px;">작성자</th> -->
			  <th style="width:120px;">작성일</th>
			  <th style="width:120px;">관리</th>
			</tr>
			</thead>
			<tbody>
			<?php foreach ($list as $o): ?>
			<tr style="<?php echo ($o->use_yn != 'Y') ? 'background-color:#f7f7f7;' : ''; ?>">
			  <td class='text-center'><?php echo $o->num ?></td>
			  <td><?php echo $o->page_title ?></td>
			  <td class='text-center'><?php echo ($o->use_yn === 'Y') ? '<strong>사용</strong>' : '사용 안함' ?></td>
			  <!-- <td class='text-center'><?php //echo $o->reg_username ?></td> -->
			  <td class='text-center'><?php echo $o->reg_date ?></td>
			  <td class='text-center'>
				<a href="/admin/contents/page/form/<?php echo $o->idx ?>"><button type="button" class="btn btn-secondary btn-xs" onclick="location.href='/admin/contents/page/form/<?php echo $o->idx ?>'">수정</button></a>
				<?php if($o->idx > 11) { ?>
				<a href="javascript:post_send('admin/contents/page/del', {idx:'<?php echo $o->idx;?>'}, true);"><button type="button" class="btn btn-danger btn-xs">삭제</button></a>
				<?php } ?>
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
