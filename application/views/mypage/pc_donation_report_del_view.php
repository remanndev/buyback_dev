	<div class="container_wrap">
		<div class="contents_wrap">

			<!-- 마이페이지 사이드 메뉴 -->
			<?php $this->load->view('mypage/pc_side_view'); ?>

			<!-- 캠페인 좌측 컨텐츠 -->
			<div class="mypage_ctnt">

				<h2 class="mb_40" style="display:block; color:#353535;">나의 기부 물품 현황 <small>- 상세 - 데이터 완전 삭제 리포트</small></h2>

				<dl class="mt_30">
					<dd class="mt_10 py_20 px_20" style="position:relative; background-color:#f7f7fb; border:1px dashed #ddddee;">
						<?php echo $cmp_row->cmp_title; ?>
					</dd>
				</dl>

				<dl class="mt_30">
					<dt style="position:relative;">
						데이터 완전 삭제 리포트
						<div style="position:absolute; right:0; bottom:0; text-align:right;">
							<a href="<?php echo base_url() ?>mypage/donation/report_del/<?php echo $cmp_code ?>/<?php echo $dn_idx?>/list"><button type="button" class="o_btn btn btn-sm <?php echo ( isset($arr_seg[6]) && 'list' == $arr_seg[6] ) ? 'btn-purple-flat' : 'btn-default-flat' ?>">목록</button></a>
							<a href="<?php echo base_url() ?>mypage/donation/report_del/<?php echo $cmp_code ?>/<?php echo $dn_idx?>/photo"><button type="button" class="o_btn btn btn-sm <?php echo ( isset($arr_seg[6]) && 'photo' == $arr_seg[6] ) ? 'btn-purple-flat' : 'btn-default-flat' ?>">사진</button></a>
							<a href="<?php echo base_url() ?>mypage/donation/report_del/<?php echo $cmp_code ?>/<?php echo $dn_idx?>/cert"><button type="button" class="o_btn btn btn-sm <?php echo ( isset($arr_seg[6]) && 'cert' == $arr_seg[6] ) ? 'btn-purple-flat' : 'btn-default-flat' ?>">증명</button></a>
						</div>
					</dt>
					<dd>

						<?php if( isset($arr_seg[6]) && 'list' == $arr_seg[6] ) { ?>

							<div class="tbl_purple mt_5">
								<table id="dsp_goods_table" style="width:100%;">
									<tr>
										<th>NO</th>
										<th>저장매체종류</th>
										<th>HDD고유번호</th>
										<th>용량</th>
										<th>데이터 폐기방법</th>
										<th>보안책임자</th>
										<th>작업일</th>
									</tr>
									<?php //foreach($dngoods_list as $i => $o) { ?>
									<?php for($i=9;$i>0;$i--) { ?>
									<tr>
										<td class="text_center"><?php echo $i; ?></td>
										<td class="text_center">M.SATA</td>
										<td class="text_center">7C91200QVZAGA</td>
										<td class="text_center">128G</td>
										<td class="text_center">완전파괴(천공)</td>
										<td class="text_center">송현호</td>
										<td class="text_center"><?php echo date('Y/m/d'); ?></td>
									</tr>
									<?php } ?>
								</table>
							</div>

						<?php } else if( isset($arr_seg[6]) && 'photo' == $arr_seg[6] ) { ?>

							<div class="tbl_purple mt_5 pt_20">
								<div class="row">
								<?php for($i=1;$i<13;$i++) { ?>
									<div class="col-3 mb_25"><img src="<?php echo IMG_DIR ?>/sample/delimg<?php echo $i ?>.jpg" style="width:100%;" /></div>
								<?php } ?>
								</div>
							</div>

						<?php } else if( isset($arr_seg[6]) && 'cert' == $arr_seg[6] ) { ?>

							<div class="tbl_purple mt_5 pt_20">

								<img src="<?php echo IMG_DIR ?>/sample/del_cert.jpg" style="width:100%;" />

							</div>

						<?php } ?>


					</dd>
				</dl>

			</div>

			<hr class="clear_both" />
		</div>
	</div>