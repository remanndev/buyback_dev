	<!-- 모바일 -->
	<?php $this->load->view('mypage/mypage_side_mobile_view'); ?>
	<!-- <div class="m_slide_nav d-block d-md-none">
		<div class="m_slide_nav_wrap">
			<div class="m_list_nav">
				<ul>
					<li><span><a href="/mypage/donation/lists">나의 기부 물품 현황</a></span></li>
					<li><span><a href="/mypage/user/edit/">정보수정</a></span></li>
					<?php if( isset($this->user->level) && $this->user->level > 10 ) { ?>
					<li><span><a href="/mypage/campaign/lists">캠페인 관리</a></span></li>
					<li><span><a href="/mypage/campaign/write">캠페인 만들기</a></span></li>
					<?php } ?>
				</ul>
			</div>
		</div>
	</div> -->

	<div class="ctnt_wrap">
		<div class="ctnt_inside">
			<div class="row py_35">
				<div class="d-none d-lg-block col-lg-3">
					<!-- 마이페이지 사이드 메뉴 -->
					<?php $this->load->view('mypage/mypage_side_view'); ?>
				</div>
				<div class="col-12 col-lg-9">
					<!-- 캠페인 좌측 컨텐츠 -->
					<div class="mypage_ctnt">

						<h2 class="mb_40" style="display:block; color:#353535;">나의 기부 물품 현황 <small>- 상세 - 검수현황</small></h2>

						<dl class="mt_30">
							<dd class="mt_10 py_20 px_20" style="background-color:#f7f7fb; border:1px dashed #ddddee;">
								<?php echo $cmp_row->cmp_title; ?>
							</dd>
						</dl>

						<dl class="mt_30">
							<dt>기부 물품 검수 현황</dt>
							<dd>
								<div class="tbl_purple mt_5">
									<table id="dsp_goods_table" style="width:100%;">
										<tr>
											<th>NO</th>
											<th>종류</th>
											<th>제조사</th>
											<th>모델명</th>
											<?php /* ?>
											<!-- <th>기기사양</th> -->
											<?php */ ?>
											<th>판정등급</th>
										</tr>

										<?php 
										//foreach($dngoods_list as $i => $o) { 
										//foreach($dnchk_result['qry'] as $key => $chk_row) {
										foreach($item_list as $key => $chk_row) {
										?>
										<tr>
											<td class="text-center"><?php echo $key + 1 ?></td>
											<td class="text-center"><?php echo $chk_row->insp_kind ?></td>
											<td class="text-center"><?php echo $chk_row->mfr ?></td>
											<td class="text-center"><?php echo $chk_row->model ?></td>
											<?php /* ?>
											<!-- <td class="text-center"><?php //echo $chk_row->chk_spec ?></td> -->
											<?php */ ?>
											<td class="text-center"><?php echo $chk_row->grade ?></td>
										</tr>
										<?php 
										}
										?>

										<?php 
										/*
										//foreach($dnchk_result['qry'] as $key => $chk_row) {
										?>
										<tr>
											<td class="text-center"><?php echo $key + 1 ?></td>
											<td class="text-center"><?php echo $chk_row->chk_kind ?></td>
											<td class="text-center"><?php echo $chk_row->chk_maker ?></td>
											<td class="text-center"><?php echo $chk_row->chk_model ?></td>
											<td class="text-center"><?php echo $chk_row->chk_grade ?></td>
										</tr>
										<?php 
										//}
										*/
										?>

									</table>
								</div>
								<div style="text-align:right; padding-top:5px;">
									B 이상의 판정등급 제품만 재생됩니다.
								</div>
							</dd>
						</dl>

					</div>
				</div>
			</div>
		</div>
	</div>


