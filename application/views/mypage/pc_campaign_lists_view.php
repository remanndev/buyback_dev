	<div class="container_wrap">
		<div class="contents_wrap">

			<!-- 마이페이지 사이드 메뉴 -->
			<?php $this->load->view('mypage/pc_side_view'); ?>

			<!-- 캠페인 좌측 컨텐츠 -->
			<div class="mypage_ctnt">

				<h2 class="mb_40" style="color:#353535;">캠페인 관리</h2>




				<div class="tbl_frm">
					<table class="table-hover">
					<tr>
					  <th class='text_center'>NO</th>
					  <th class=''>캠페인명</th>
					  <th class=''>모금기간</th>
					  <th class=''>작성일자</th>
					  <th class=''>단계</th>
					  <th class='text_center'>관리</th>
					</tr>
					<?php foreach($list as $i => $o) { ?>
					<tr>
					  <td class="text_center"><?php echo $o->num ?></td>
					  <td><a href="/mypage/campaign/campaign_donate_lists/<?php echo $o->idx ?>"><div class="ellipsis" style="width:320px;"><?php echo $o->cmp_title ?></div></a></td>
					  <td class="text_center"><?php echo $o->cmp_term ?></td>
					  <td class="text_center"><?php echo $o->reg_date ?></td>
					  <td class="text_center"><?php echo $o->state_str ?></td>
					  <td class="text_center">
						<a href="/mypage/campaign/write/<?php echo $o->idx ?>"><button class="btn btn-gray-flat btn-xs">수정</button></a>
						<a href="#" onclick="del_confirm('mypage/campaign/del/<?php echo $o->idx ?>'); return false;"><button class="btn btn-danger-flat btn-xs">삭제</button></a>
					  </td>
					</tr>
					<?php } ?>
					</table>
				</div>




			</div>

			<hr class="clear_both" />
		</div>
	</div>