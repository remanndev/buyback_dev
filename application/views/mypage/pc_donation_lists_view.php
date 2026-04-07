	<div class="container_wrap">
		<div class="contents_wrap">

			<!-- 마이페이지 사이드 메뉴 -->
			<?php $this->load->view('mypage/pc_side_view'); ?>

			<!-- 캠페인 좌측 컨텐츠 -->
			<div class="mypage_ctnt">
				<h2 class="mb_40" style="color:#353535;">나의 기부 물품 현황 <small>- 목록</small></h2>


				<div class="tbl_frm">
					<table class="table-hover">
					<tr>
					  <th class='text_center'>NO</th>
					  <th class=''>캠페인명</th>
					  <th class=''>기부신청일자</th>
					  <th class=''>상태</th>
					</tr>
					<?php foreach($list as $i => $o) { ?>
					<tr>
					  <td class="text_center"><?php echo $o->num ?></td>
					  <td><a href="/mypage/donation/detail/<?php echo $o->cmp_code ?>/<?php echo $o->idx ?>"><div class="ellipsis" style="width:320px;"><?php echo $o->cmp_title ?></div></a></td>
					  <td class="text_center"><?php echo $o->reg_date ?></td>
					  <td class="text_center"><?php echo $o->state_good_proc ?></td>
					</tr>
					<?php } ?>
					</table>
				</div>


			</div>


			<hr class="clear_both" />



		</div>
	</div>