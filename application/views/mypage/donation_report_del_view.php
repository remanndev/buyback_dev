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
									<!-- <a href="<?php echo base_url() ?>mypage/donation/report_del/<?php echo $cmp_code ?>/<?php echo $dn_idx?>/cert"><button type="button" class="o_btn btn btn-sm <?php echo ( isset($arr_seg[6]) && 'cert' == $arr_seg[6] ) ? 'btn-purple-flat' : 'btn-default-flat' ?>">증명</button></a> -->
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
											<?php 
											foreach($dn_del_result['qry'] as $key => $del_row) {
												// 번호
												$num = ($dn_del_result['total_count'] - $key);
											?>
											<tr>
												<td class="text-center"><?php echo $num ?></td>
												<td class="text-center"><?php echo $del_row->hdd_type ?></td>
												<td class="text-center"><?php echo $del_row->hdd_idno ?></td>
												<td class="text-center"><?php echo $del_row->hdd_capacity ?></td>
												<td class="text-center"><?php echo $del_row->del_method ?></td>
												<td class="text-center"><?php echo $del_row->del_cso ?></td>
												<td class="text-center"><?php echo $del_row->del_date ?></td>
											</tr>
											<?php 
											}
											?>
										</table>
									</div>

								<?php } else if( isset($arr_seg[6]) && 'photo' == $arr_seg[6] ) { ?>
									<div class="tbl_purple mt_5 pt_20">
										<?php echo isset($dn_del_row_photo->del_content) ? $dn_del_row_photo->del_content : ''; ?>
									</div>

								<?php } else if( isset($arr_seg[6]) && 'cert' == $arr_seg[6] ) { ?>

									<!-- <div class="tbl_purple mt_5 pt_20">
										<?php //if($cert_file_url) { ?>
										<a href="<?php //echo $cert_file_url; ?>" target="_new">다운로드 받기</a>
										<?php //} ?>
									</div> -->

								<?php } ?>


							</dd>
						</dl>

					</div>


				</div>
			</div>
		</div>
	</div>


