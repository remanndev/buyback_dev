	<div class="container_wrap">
		<div class="contents_wrap">

			<!-- 마이페이지 사이드 메뉴 -->
			<?php $this->load->view('mypage/pc_side_view'); ?>

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
									<th>기기사양</th>
									<th>판정등급</th>
								</tr>
								<?php //foreach($dngoods_list as $i => $o) { ?>
								<?php for($i=9;$i>0;$i--) { ?>
								<tr>
									<td class="text_center"><?php echo $i ?></td>
									<td class="text_center">노트북</td>
									<td class="text_center">엘지</td>
									<td class="text_center">Z50PS</td>
									<td class="text_center"></td>
									<td class="text_center">A</td>
								</tr>
								<?php } ?>
							</table>
						</div>
						<div style="text-align:right; padding-top:5px;">
							B 이상의 판정등급 제품만 재생됩니다.
						</div>
					</dd>
				</dl>

			</div>

			<hr class="clear_both" />
		</div>
	</div>