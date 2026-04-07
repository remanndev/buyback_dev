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
					<div class="mypage_ctnt" style="">
						<h2 class="mb_20" style="color:#353535;">캠페인 관리</h2>


						<style>
							/* common */
							.res_tbl_wrap {
								position: relative;
								overflow: hidden;
								margin: 0 auto;
								width: 100%;
								max-width: 1200px;
								border-top: 2px solid #121212;
							}
							.res_tbl_wrap table {
								display: table;
								width: 100%;
								border-collapse: collapse;
								border-spacing: 0;
							}
							.res_tbl_wrap table thead tr th {
								border-bottom: 1px solid #121212;
							}
							.res_tbl_wrap table thead tr th,
							.res_tbl_wrap table tbody tr td {
								text-align: left;
								/* padding: 0.8125vw 1.25vw; */
								font-size: 15px;
								/* font-size: 1.3vw; */
								/* line-height: 1.375vw; */
							}
							.res_tbl_wrap table tbody tr td {
								border-bottom: 1px solid #efefef;
								height: auto !important;
							}

							.center_pc { text-align: center !important; }

							/* desktop only */
							@media screen and (min-width: 1200px) {
								.res_tbl_wrap table thead tr th,
								.res_tbl_wrap table tbody tr td {
									/*padding: 12px 20px;*/
									/* font-size: 16px;
									line-height: 22px; */
								}
							}

							/* mobile only */
							@media screen and (max-width: 990px) {
								.res_tbl_wrap table col {
									width: 100% !important;
								}
								.res_tbl_wrap table thead {
									display: none;
								}
								.res_tbl_wrap table tbody tr {
									border-bottom: 1px solid #efefef;
								}
								.res_tbl_wrap table tbody tr td {
									width: 100%;
									display: flex;
									margin-bottom: 2px;
									padding: 1px 5px;
									border-bottom: none;
									font-size: 14px;
									line-height: 18px;
								}
								.res_tbl_wrap table tbody tr td:first-child, 
								.res_tbl_wrap table tbody tr th:first-child {
									/* padding-top: 16px; */
									margin-top: 5px;
								}
								.res_tbl_wrap table tbody tr td:last-child, 
								.res_tbl_wrap table tbody tr th:last-child {
									/* padding-bottom: 15px; */
									margin-bottom: 5px;
								}
								.res_tbl_wrap table tbody tr td:before {
									display: inline-block;
									margin-right: 12px;
									-webkit-box-flex: 0;
									-ms-flex: 0 0 100px;
									flex: 0 0 100px;
									font-weight: 700;
									content: attr(data-label);
									background-color: #f3f3f3;
									min-height: 22px;
									line-height: 22px;
									padding-left: 5px;
								}

								/* mobile */
								.center_pc { text-align: left !important; }
							}
						</style>



						<div>
							<div class="tbl_frm res_tbl_wrap" style="width:100%; overflow:none; overflow-x:auto;">
								<table class="table-hover" style="font-size: 15px;">
								<tr class="_pc">
								  <th class='center_pc'>NO</th>
								  <!-- <th class=''>카테고리</th> -->
								  <th class=''>캠페인명</th>
								  <th class='center_pc'>기부자</th>
								  <th class='center_pc'>모금기간</th>
								  <th class='center_pc'>작성일자</th>
								  <th class='center_pc'>단계</th>
								  <th class='center_pc'>관리</th>
								</tr>
								<?php foreach($list as $i => $o) { ?>
								<tr>
								  <td class="center_pc" data-label="NO"><?php echo $o->num ?></td>
								  <!-- <td class="text-center"><?php //echo $o->cmp_cate ?></td> -->
								  <td data-label="캠페인명"><a href="/mypage/campaign/info/<?php echo $o->idx ?>" style="max-width:320px; text-decoration:underline;"><?php echo $o->cmp_title ?></a></td>
								  <td class='center_pc' data-label="기부자"><a href="/mypage/campaign/campaign_donate_lists/<?php echo $o->idx ?>"><button class="btn btn-dark btn-xs">보기</button></a></td>
								  <td class="center_pc" data-label="모금기간" style="font-size: 13px;"><?php echo $o->cmp_term ?></td>
								  <td class="center_pc" data-label="작성일자" style="font-size: 13px;"><?php echo $o->reg_date ?></td>
								  <td class="center_pc" data-label="단계"><?php echo $o->state_str ?></td>
								  <td class="center_pc" data-label="관리">
									<?php if('launch' != $o->state) { ?>
									<a href="/mypage/campaign/write/<?php echo $o->idx ?>"><button class="btn btn-gray-flat btn-xs">수정</button></a>
									<?php } ?>
									<!-- <a href="#" onclick="del_confirm('mypage/campaign/del/<?php //echo $o->idx ?>'); return false;"><button class="btn btn-danger-flat btn-xs">삭제</button></a> -->
								  </td>
								</tr>
								<?php } ?>
								</table>
							</div>
						</div>

					</div>
				</div>
			</div>
		</div>
	</div>
