	<div class="container_wrap">
		<div class="contents_wrap">

			<!-- 마이페이지 사이드 메뉴 -->
			<?php $this->load->view('mypage/pc_side_view'); ?>

			<!-- 캠페인 좌측 컨텐츠 -->
			<div class="mypage_ctnt">

				<h2 class="mb_40" style="display:block; color:#353535; position:relative;">
					나의 기부 물품 현황 <small>- 상세</small>
					<small style="position:absolute; bottom:0; right:0;">
						
					</small>
				</h2>

				<dl class="mt_30">
					<dt>1. 기부명</dt>
					<dd class="mt_10 py_20 px_20" style="background-color:#f7f7fb;">
						<?php echo $cmp_row->cmp_title; ?>
					</dd>
				</dl>

				<dl class="mt_30">
					<dt>2. 내 기부 물품 현재 상태</dt>
					<dd class="mt_10 py_20 px_20" style="background-color:#f7f7fb;">
						<h3><?php echo date('Y년 m월 d일') ?> [<?php echo $dn_row->state_good_proc ?>]</h3>
					</dd>
				</dl>

				<dl class="mt_30">
					<dt>3. 기부 물품 수량</dt>
					<dd>
						<div class="tbl_purple mt_5">
							<table id="dsp_goods_table" style="width:100%;">
								<tr>
									<th>종류</th>
									<th>수량</th>
									<th>제조사</th>
									<th>모델명</th>
									<th>구성부품</th>
									<th>비고</th>
								</tr>
								<?php foreach($dngoods_list as $i => $o) { ?>
								<tr>
									<td class="text_center"><?php echo $o->gd_type; ?></td>
									<td class="text_center"><?php echo $o->gd_amt; ?></td>
									<td class="text_center"><?php echo $o->gd_maker; ?></td>
									<td class="text_center"><?php echo $o->gd_model; ?></td>
									<td class="text_center"><?php echo $o->gd_part; ?></td>
									<td class="text_center"><?php echo $o->gd_memo; ?></td>
								</tr>
								<?php } ?>
							</table>
						</div>
					</dd>
				</dl>

				<dl class="mt_30">
					<dt>4. 기부 물품 처리 상황</dt>
					<dd>
						<div class="tbl_purple mt_5">
							<table id="dsp_goods_table" style="width:100%;">
								<tr>
									<th>진행</th>
									<th>일자</th>
									<th>완료여부</th>
								</tr>
								<tr>
									<td class="text_center">접수일</td>
									<td class="text_center"><?php echo substr($dn_row->reg_datetime,0,10); ?></td>
									<td class="text_center">완료</td>
								</tr>
								<tr>
									<td class="text_center">수거예정일자</td>
									<td class="text_center"><?php echo $dn_row->pickup_date; ?></td>
									<td class="text_center"><?php echo $dn_row->state_pickup; ?></td>
								</tr>
								<tr>
									<td class="text_center">검수중</td>
									<td class="text_center"><?php echo $dn_row->check_date; ?></td>
									<td class="text_center"><?php echo $dn_row->state_check; ?></td>
								</tr>
								<tr>
									<td class="text_center">재생중</td>
									<td class="text_center"><?php echo $dn_row->recycle_date; ?></td>
									<td class="text_center"><?php echo $dn_row->state_recycle; ?></td>
								</tr>
								<tr>
									<td class="text_center">나눔중</td>
									<td class="text_center"><?php echo $dn_row->handout_date; ?></td>
									<td class="text_center"><?php echo $dn_row->state_handout; ?></td>
								</tr>
								<tr>
									<td class="text_center">나눔완료</td>
									<td class="text_center"><?php echo $dn_row->handout_finish_date; ?></td>
									<td class="text_center"><?php echo $dn_row->state_handout_finish; ?></td>
								</tr>
							</table>
						</div>
					</dd>
				</dl>

				<dl class="mt_30">
					<dt>5. 기부 물품 검수 현황</dt>
					<dd class="mt_10 py_20 px_20" style="background-color:#f7f7fb;">
						<div>기부된 물품의 상세 검수 현황을 확인할 수 있습니다.</div>
						<a href="<?php echo base_url() ?>mypage/donation/report_check/<?php echo $cmp_row->code; ?>/<?php echo $dn_row->idx ?>" target="_blank"><button type="button" class="o_btn btn btn-purple-line mt_10">상세 검수 현황</button></a>
					</dd>
				</dl>

				<dl class="mt_30">
					<dt>6. 기부 가치 평가</dt>
					<dd class="mt_10 py_20 px_20" style="background-color:#f7f7fb;">
						<!-- <div>* 당신의 기부는 총 <span class="color_red"><?php //echo number_format($dn_row->donation_value); ?>원</span>의 가치로 평가되었습니다. </div> -->
						<div>* 자원순환과 나눔에 함께해주셔서 감사합니다. </div>
						<div>* 총 <span class="color_red"><?php echo number_format($dn_row->donation_value); ?>원</span>이 캠페인에 적립되었습니다. </div>
						<div>* 검수결과 B등급 이상의 제품만 재생됩니다.</div>
					</dd>
					<dd>
						<div class="tbl_purple mt_5">
							<table id="dsp_goods_table" style="width:100%;">
								<colgroup>
									<col width="260" />
									<col />
									<col />
									<col />
									<col />
									<col />
								</colgroup>
								<tr>
									<th>기부명</th>
									<th>검수평가</th>
									<th>수량</th>
									<th>평가금액</th>
									<th>재생/재활용비용</th>
									<th>기부가치</th>
								</tr>
								<tr>
									<td rowspan="2" class=""><?php echo $cmp_row->cmp_title; ?></td>
									<td class="text_center">재생 대상</td>
									<td class="text_right"><?php echo number_format($dn_row->chk_recycle_amt) ?> 대</td>
									<td class="text_right"><?php echo number_format($dn_row->chk_recycle_money) ?> 원</td>
									<td class="text_right"><?php echo number_format($dn_row->chk_recycle_cost) ?> 원</td>
									<td class="text_right"><?php echo number_format($dn_row->chk_recycle_worth) ?> 원</td>
								</tr>
								<tr>
									<td class="text_center">재활용 대상</td>
									<td class="text_right"><?php echo number_format($dn_row->chk_reuse_amt) ?> 대</td>
									<td class="text_right"><?php echo number_format($dn_row->chk_reuse_money) ?> 원</td>
									<td class="text_right"><?php echo number_format($dn_row->chk_reuse_cost) ?> 원</td>
									<td class="text_right"><?php echo number_format($dn_row->chk_reuse_worth) ?> 원</td>
								</tr>
							</table>
						</div>
					</dd>
				</dl>

				<dl class="mt_30">
					<dt>7. 데이터 완전 삭제 현황</dt>
					<dd class="mt_10 py_20 px_20" style="background-color:#f7f7fb;">
						<div>데이터 삭제 리포트를 확인할 수 있습니다.</div>
						<a href="<?php echo base_url() ?>mypage/donation/report_del/<?php echo $cmp_row->code; ?>/<?php echo $dn_row->idx ?>/list" target="_blank"><button type="button" class="o_btn btn btn-purple-line mt_10">데이터 완전 삭제 리포트</button></a>
					</dd>
				</dl>

				<dl class="mt_30">
					<dt>8. 기부금 영수증 확인</dt>
					<dd class="mt_10 py_20 px_20" style="background-color:#f7f7fb;">
						<div>기부금 영수증 사본을 확인 할 수 있습니다.</div>
						<a href="<?php echo base_url() ?>mypage/donation/report_receipt/<?php echo $cmp_row->code; ?>/<?php echo $dn_row->idx ?>" target="_blank"><button type="button" class="o_btn btn btn-purple-line mt_10">기부금 영수증 보기</button></a>
					</dd>
				</dl>



			</div>

			<hr class="clear_both" />
		</div>
	</div>