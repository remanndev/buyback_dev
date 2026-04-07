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
			  <th>신청일자</th>
			  <th style="width:100px;">관리</th>
			  <?php if('campaign' == $code OR 'npo' == $code) { ?>
			  <th style="width:80px;">회원상태</th>
			  <?php } ?>
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

			  <!-- <td class='text-center'><?php //echo $o->fld_1 ?></td>
			  <td class='text-center'><?php //echo $o->fld_2 ?></td>
			  <td class='text-center'><?php //echo $o->fld_3 ?></td>
			  <td class='text-center'><?php //echo $o->fld_4 ?></td>
			  <td class='text-center'><?php //echo $o->fld_5 ?></td> -->

			  <td class='text-center'><?php echo $o->reg_date ?></td>
			  <td class='text-center'>
				<a href="/admin/contents/landing/req_code_detail/<?php echo $o->code ?>/<?php echo $o->idx ?>"><button type="button" class="btn btn-secondary btn-xs">확인</button></a>
				<a href="javascript:post_send('admin/contents/landing/req_code_del', {code:'<?php echo $o->code;?>',idx:'<?php echo $o->idx;?>'}, true);"><button type="button" class="btn btn-danger btn-xs">삭제</button></a>
			  </td>
			  <?php if('campaign' == $code OR 'npo' == $code) { ?>
			  <td class='text-center'>
			  <?php if($o->chk_join_available) { ?>
				<button class="btn btn-dark btn-xs   btn_join_npo" data-fld_1="<?php echo $o->txtfld[1] ?>" data-fld_2="<?php echo $o->txtfld[2] ?>" data-fld_3="<?php echo $o->txtfld[3] ?>" data-fld_4="<?php echo $o->txtfld[4] ?>" data-fld_5="<?php echo $o->txtfld[5] ?>">가입처리</button>
			  <?php } else { ?>
				<button class="btn btn-secondary btn-xs" disabled>가입완료</button>
			  <?php } ?>

				<!-- <button class="btn btn-secondary btn-xs" onclick="alert('샘플입니다.')">NPO</button> -->
			  </td>
			  <?php } ?>
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


<script type="text/javascript">
// NPO 협약 신청자들을 관리자가 승인하여 회원 가입처리
$(document).ready(function(){
	$('.btn_join_npo').on('click', function(){

			var npo_name = $(this).data('fld_1');
			var npo_manager = $(this).data('fld_2');
			var npo_tel = $(this).data('fld_3');
			var npo_email = $(this).data('fld_4');
			var npo_homepage = $(this).data('fld_5');


			if( confirm('회원 가입을 진행하시겠습니까?') ) {

					var request = $.ajax({
					  url: "/trans/join_npo_byadmin",
					  method: "POST",
					  data: { 'npo_name':npo_name,'npo_tel':npo_tel,'npo_email':npo_email,'npo_manager':npo_manager },
					  dataType: "html"
					});
					request.done(function( res ) {
						//console.log(res);
						if('exist' == res) {
							alert('이미 존재하는 회원입니다.');
						}
						else if(res > 0) {
							alert('회원 가입이 완료되었습니다.');
						}
						location.reload();
					});
					request.fail(function( jqXHR, textStatus ) {
					  alert( "Request failed: " + textStatus );
					  return false;
					});

			}

	});
});
</script>