<div class=" admin_wrap">

	<h1 style="position:relative;">
		팝업 관리
		<button type="button" class="btn btn-ssm btn-dark" style="position:absolute; right:0; bottom:9px;" onclick="location.href='/admin/design/popup/form'">신규등록</button>
	</h1>

	<div style="position:relative; margin:20px 0 0 0;">
		<div style="font-size:15px; position:relative;">
		  <a href="/admin/design/popup/lists">처음</a> (총 <?php echo $total_cnt?>개)
		</div>
	</div>
	<div style="clear:both;"></div>

	<form name="fpopuplist" method="post" action="">
	<!-- <input type="hidden" name="token" value="<?php //echo $token?>"/> -->

	<div class="tbl_frm">
	<table>
		<colgroup>
		  <col width="40">
		  <col width="60">
		  <col>
		  <col width="80">
		  <col width="140">
		  <col width="140">
		  <col width="60">
		  <col width="170">
		</colgroup>
		<thead>
			<tr>
				<th class="text-center" style="height:26px; vertical-align:middle;"><input type="checkbox" id="allcheck" /></th>
				<th class="text-center" style="height:26px; vertical-align:middle;">번호</th>
				<th class="text-center" style="height:26px; vertical-align:middle;">제목</th>
				<th class="text-center" style="height:26px; vertical-align:middle;">형식</th>
				<th class="text-center" style="height:26px; vertical-align:middle;"><a href="<?php echo $sort_pu_sdate?>">시작일</a></th>
				<th class="text-center" style="height:26px; vertical-align:middle;"><a href="<?php echo $sort_pu_edate?>">종료일</a></th>
				<th class="text-center" style="height:26px; vertical-align:middle;">사용</th>
				<th class="text-center" style="height:26px; vertical-align:middle;">관리<?//=$s_add?></th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($list as $o): ?>
			<tr>
				<td class="text-center"><input type="checkbox" class="chk_box" name="chk[]" value="<?php echo $o->id?>" /></td>
				<td class="text-center"><?php echo $o->num?></td>
				<td class="text-center"><input type="text" name="pu_name[<?php echo $o->id?>]" class="form-control o_input" maxlength="200" style="width:97%;" value="<?php echo $o->name?>" /></td>
				<td class="text-center"><?php echo $o->type?></td>
				<td class="text-center" ><?php echo $o->sdate?></td>
				<td class="text-center"><?php echo $o->edate?></td>
				<td class="text-center"><input type="checkbox" name="pu_use[<?php echo $o->id?>]" <?php echo $o->use_chk?> value="1" /></td>
				<td class="text-center"><?php echo $o->s_pre?> <?php echo $o->s_mod?> <?php echo $o->s_del?></td>
			</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
	</div>

	<div class="clearfix" style="position:relative; margin-top:10px;">

		<div class="pull-left">
			<button type="button" class="btn btn-ssm btn-dark" onclick="location.href='/admin/design/popup/form'">신규등록</button>
			<button type="button" class="btn btn-ssm btn-dark" onclick="slt_check(this.form, '/admin/design/popup/update')">선택수정</button>
			<button type="button" class="btn btn-ssm btn-danger" onclick="slt_check(this.form, '/admin/design/popup/delete')">선택삭제</button>
		</div>

		<!-- <button type="button" class="btn btn-xs btn-dark" style="position:absolute; bottom:0; right:0;" onclick="location.href='/admin/design/form'">신규등록</button> -->
		<div class="text-center" style="margin:50px 0; text-align:center;">
			<?php echo $paging?>
		</div>
	</div>

	</form>

</div>

<?php if ($stx): ?>
<script type='text/javascript'>
//<![CDATA[
document.fsearch.sfl.value = '<?php echo $sfl?>';
//]]>
</script>
<?php endif; ?>