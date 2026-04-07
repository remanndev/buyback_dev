	<!-- 모바일 -->
	<?php $this->load->view('mypage/mypage_side_mobile_view'); ?>

	<style type="text/css">
	/* 테이블 좌우 스크롤 생성 */
	  @media screen and (max-width: 481px) 
	  {
		.o_table_mobile {width: 100%;overflow: hidden;}
		.o_table_mobile .tbl_scroll {overflow-x: scroll;}
		.o_table_mobile .tbl_scroll table {width: 100%;min-width:480px;}
	  }
	</style>


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

						<h2 class="mb_40" style="display:block; color:#353535; position:relative;">
							나의 기부 물품 현황 <small>- 상세</small>
							<small style="position:absolute; bottom:0; right:0;">
								
							</small>
						</h2>

						<dl class="mt_30">
							<dt>1. 캠페인명</dt>
							<dd class="mt-2 px-3 py-4" style="background-color:#f7f7fb;">
								<a href="<?php echo base_url() ?>campaign/detail/<?php echo $cmp_row->code; ?>" style="text-decoration: underline;"><?php echo $cmp_row->cmp_title; ?></a>
							</dd>
						</dl>

						<dl class="mt_30">
							<dt>2. 기부 물품 현재 상태</dt>
							<dd class="mt-2 px-3 py-4" style="background-color:#f7f7fb;">
								<h5 class="m-0 p-0 fw-bold"><?php echo date('Y년 m월 d일') ?> [<?php echo $dn_row->state_good_proc ?>]</h5>
							</dd>
						</dl>

						<!-- <dl class="mt_30">
							<dt>3. 기부 물품 처리 옵션(선택)</dt>
							<dd class="mt-2 px-3 py-4" style="background-color:#f7f7fb;">
								<h5 class="m-0 p-0 fw-bold"><?php //echo $dn_row->opt_request_ko ?></h5>
							</dd>
						</dl> -->

						<dl class="mt_30">
							<dt>
								3. 기부 물품 수량
								<?php if( (isset($dn_row->goods_memo) && '' != trim($dn_row->goods_memo)) || ($file_result['total_count'] > 0) ) { ?>
								<button id="btn_gd_info" class="btn btn-xs btn-secondary">배출 물품 자세히 보기</button></dt>
								<?php } ?>
							<dd>
							  <div class="o_table_mobile">
								<div class="tbl_purple mt_5 tbl_scroll">
									<table id="dsp_goods_table" style="width:100%;">
										<tr>
											<th>종류</th>
											<th>수량</th>
										</tr>
										<?php foreach($dngoods_list as $i => $o) { ?>
										<tr>
											<td class="text_center"><?php echo $o->gd_type; ?></td>
											<td class="text_center"><?php echo $o->gd_amt; ?></td>
										</tr>
										<?php } ?>
									</table>
								</div>
							  </div>
							</dd>
						</dl>

						<?php if( isset($dn_row->goods_memo) && '' != trim($dn_row->goods_memo) ) { ?>
						<dl id="wrap_gd_memo" class="mt-3" style="display: none;">
							<dt>배출 물품 설명</dt>
							<dd class="mt-1 p-3" style="background-color:#f7f7fb; font-size: 14px;">
								<?php echo nl2br($dn_row->goods_memo); ?>
							</dd>
						</dl>
						<?php } ?>

						<?php if($file_result['total_count'] > 0 ) { ?>

						<style type="text/css">
							.dnpic_wrap { background-color: transparent; }
							.dnpic_wrap img { width: 100%; height: auto; border: 1px dashed gray;}
						</style>

						<dl id="wrap_gd_pic" class="mt-3" style="display: none;">
							<dt>배출 물품 사진</dt>
							<dd class="mt-1 p-3" style="background-color:#f7f7fb; font-size: 14px;">
								<div class="row">
									<?php foreach($file_result['qry'] as $fkey => $frow) { ?>
										<div class="dnpic_wrap col-4">
											<img src="<?php echo DATA_DIR ?>/<?php echo $frow->file_dir; ?>/<?php echo $frow->file_name; ?>" />
										</div>
									<?php } ?>
								</div>
							</dd>
						</dl>
						<?php } ?>

						<script type="text/javascript">
						  $('#btn_gd_info').on('click',function(){
							let gd_memo = <?php echo isset($dn_row->goods_memo) ? strlen($dn_row->goods_memo) : -1 ?>;
							let gd_pic_cnt = <?php echo $file_result['total_count'] ?>;

							if( gd_memo > 0 ) {
								$('#wrap_gd_memo').slideToggle();
							}
							if( gd_pic_cnt > 0 ) {
								$('#wrap_gd_pic').slideToggle();
							}
						  });
						</script>

						<dl class="mt_30">
							<dt>4. 기부 물품 처리 상황</dt>
							<dd>
							  <div class="o_table_mobile">
								<div class="tbl_purple mt_5 tbl_scroll">

									<table id="dsp_goods_table" style="width:100%;">
										<tr>
											<th>진행상태</th>
											<th>처리상황</th>
											<th>처리일자</th>
										</tr>
										<tr>
											<td class="text_center" title="기부 접수일자">접수</td>
											<td class="text_center" title="접수 상태"><?php echo $dn_row->state_accept_txt ?></td>
											<td class="text_center"><?php echo substr($dn_row->reg_datetime,0,10); ?></td>
										</tr>
										<tr>
											<td class="text_center" title="택배API 수거일자">수거</td>
											<td class="text_center" title="수거 상태"><?php echo $dn_row->state_pickup_txt ?></td>
											<td class="text_center"><?php echo $dn_row->pickup_date; ?></td>
										</tr>
										<tr>
											<td class="text_center" title="ROS 검수 시작일자">검수</td>
											<td class="text_center" title="검수 상태"><?php echo $dn_row->state_check_txt ?></td>
											<td class="text_center"><?php echo $dn_row->check_date; ?></td>
										</tr>
										<?php if(! is_null($dn_row->handout_finish_date)) { ?>
										<tr>
											<td class="text_center" title="ROS 완료 일자">완료</td>
											<td class="text_center" title="최종 상태"><?php echo $dn_row->state_cmpl_txt ?></td>
											<td class="text_center"><?php echo $dn_row->handout_finish_date; ?></td>
										</tr>
										<?php } ?>
									</table>

								</div>
							  </div>
							</dd>
						</dl>

						<dl class="mt_30">
							<dt>5. 기부 물품 검수 현황</dt>
							<dd>

								<?php if( empty($item_list) ) { ?>
								  <div class="mt_10 py_20 px_20" style="background-color:#f7f7fb;">
									<div>검수전입니다. 검수가 완료되면 표시됩니다.</div>
								  </div>
								<?php } else { ?>
								  <div class="mt_10">기부된 물품의 상세 검수 현황을 확인할 수 있습니다.</div>
								  <div class="tbl_purple">
									<table id="dsp_itmes_table" style="width:100%;">
										<tr>
											<th class="text-center">NO</th>
											<th class="text-center">종류</th>
											<th class="text-center">제조사</th>
											<th class="text-center">모델명</th>
											<th class="text-center">판정등급</th>
										</tr>
										<?php 
										foreach($item_list as $key => $chk_row) {
										?>
										<tr>
											<td class="text-center"><?php echo $key + 1 ?></td>
											<td class="text-center"><?php echo $chk_row->insp_kind ?></td>
											<td class="text-center"><?php echo $chk_row->mfr ?></td>
											<td class="text-center"><?php echo $chk_row->model ?></td>
											<td class="text-center"><?php echo $chk_row->grade ?></td>
										</tr>
										<?php 
										}
										?>
									</table>
								  </div>
								  <div class="text-right" style="font-size: 14px;">* 실제로 검수한 수량이며, 기부신청서 작성시 입력한 수량과 차이가 있을 수 있습니다.</div>
								<?php } ?>

							</dd>
						</dl>

						<dl class="mt_30">
							<dt>6. 기부 가치 평가</dt>
							<dd>
							  <?php if( empty($item_list) ) { ?>
								<div class="mt_10 py_20 px_20" style="background-color:#f7f7fb;">
								  <div>평가전입니다. 평가가 완료되면 표시됩니다.</div>
								</div>
							  <?php } else { ?>

								<div class="mt_10 py_20 px_20" style="background-color:#f7f7fb;">
									<!-- <div>* 당신의 기부는 총 <span class="color_red"><?php //echo number_format($worth_val_total); ?>원</span>의 가치로 평가되었습니다. </div> -->
									<div>* 자원순환과 나눔에 함께해주셔서 감사합니다. </div>
									<div>* 총 <span class="color_red"><?php echo number_format($worth_val_total); ?>원</span>이 캠페인에 적립되었습니다. </div>
									<div>* 검수결과 C등급 이상의 제품만 재생됩니다.</div>
								</div>

								<div class="o_table_mobile">
									<div class="tbl_purple mt_5 tbl_scroll">
										<table id="dsp_goods_table" style="width:100%;">
											<colgroup>
												<col />
												<col style="width: 14%;" />
												<col style="width: 12%;" />
												<col style="width: 17%;" />
											</colgroup>
											<tr>
												<th>기부명</th>
												<th>검수평가</th>
												<th>수량</th>
												<th>기부가치</th>
											</tr>
											<tr>
												<td rowspan="2" class=""><?php echo $cmp_row->cmp_title; ?></td>
												<td class="text_center">재생 대상</td>
												<td class="text_right"><?php echo number_format($arr_worth_cnt['reproduct']) ?> 대</td>
												<td class="text_right"><?php echo number_format($arr_worth_val['reproduct']) ?> 원</td>
											</tr>
											<tr>
												<td class="text_center">재활용 대상</td>
												<td class="text_right"><?php echo number_format($arr_worth_cnt['recycle']) ?> 대</td>
												<td class="text_right"><?php echo number_format($arr_worth_val['recycle']) ?> 원</td>
											</tr>
										</table>
									</div>
								</div>

							  <?php } ?>
							</dd>

						</dl>

						<?php //print_r($dn_row->del_date) ?>


						<dl class="mt_30">
							<dt>7. 데이터 완전 삭제 현황</dt>
							<dd>
							  <div class="mt_10 py_20 px_20" style="background-color:#f7f7fb;">
								<?php if($dn_row->del_date && '' != $dn_row->del_date) { ?>
									<div>데이터 삭제 리포트를 확인할 수 있습니다.</div>
									<a href="<?php echo base_url() ?>mypage/donation/report_del_ros/<?php echo $cmp_row->code; ?>/<?php echo $dn_row->idx ?>" target="_blank"><button type="button" class="o_btn btn btn-purple-line mt_10">데이터 완전 삭제 리포트</button></a>
									
									<?php if('' != $download_blancco_link) { ?>
									<a href="<?php echo $download_blancco_link ?>" target="blancco"><button type="button" class="o_btn btn btn-purple-line mt_10">블랑코 삭제 리포트</button></a>
									<?php } else { ?>
									<button type="button" onclick="alert('준비중입니다.'); return false;" class="o_btn btn btn-purple-line mt_10" disabled>블랑코 삭제 리포트</button>
									<?php } ?>
								<?php } else { ?>
									<div>리포트 작성 전입니다. 리포트가 작성되면 표시됩니다.</div>
								<?php } ?>
							  </div>
							</dd>
						</dl>




						<?php
						/* - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - 
						 * 탄수중립포인트 지급 내역
						 * - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - 
						<dl class="mt_30">
							<dt>8. 탄소중립포인트 지급 내역</dt>
							<dd>
							  <div class="mt_10 py_20 px_20" style="background-color:#f7f7fb;">
								준비중입니다.
							  </div>
							</dd>
						</dl>
						*/ ?>

					</div>
				</div>
			</div>
		</div>
	</div>


