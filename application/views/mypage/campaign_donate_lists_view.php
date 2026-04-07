<?php //print_r($dn_list); ?>

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
						<h2 class="mb_40" style="color:#353535;">캠페인 관리 <small>- 기부자 목록</small></h2>

						<h5 class="_mobile">캠페인 목록</h5>
						<div class="tbl_frm res_tbl_wrap" style="width:100%; overflow:none; overflow-x:auto; margin-bottom: 30px;">
							<table class="table-hover">
							<tr class="_pc">
							  <!-- <th class=''>카테고리</th> -->
							  <th class=''>캠페인명</th>
							  <th class='' style="width: 140px;">모금기간</th>
							  <th class=''>모금금액</th>
							  <th class='' style="width: 120px;">작성일자</th>
							  <th class='' style="width: 70px;">단계</th>
							</tr>
							<tr>
							  <!-- <td class="" data-label="카테고리"><?php //echo $cmp_row->cmp_cate ?></td> -->
							  <td class="" data-label="캠페인명"><a href="/mypage/campaign/info/<?php echo $cmp_row->idx ?>"><div class="ellipsis" style="max-width:320px; text-decoration:underline;"><?php echo $cmp_row->cmp_title ?></div></a></td>
							  <td class="" data-label="모금기간"><?php echo $cmp_row->cmp_term ?></td>
							  <td class="" data-label="모금금액"><?php echo $cmp_row->dnval_tot_val ?></td>
							  <td class="" data-label="작성일자"><?php echo $cmp_row->reg_date ?></td>
							  <td class="" data-label="단계"><?php echo $cmp_row->state_str ?></td>
							</tr>
							</table>
						</div>


						<h5 class="_mobile">기부자 목록</h5>
						<div class="tbl_frm res_tbl_wrap">
							<table class="table-hover" style="width:100%;">
							<tr class="_pc">
							  <th class='center_pc'>NO</th>
							  <!-- <th class='center_pc'>아이디</th> -->
							  <th class='center_pc'>이름</th>
							  <th class='center_pc'>기부일자</th>
							  <th class='center_pc'>기부금액</th>

							  <th class='center_pc'>기부내용</th>
							  <th class='center_pc'>기부금영수증</th>
							  <th class='center_pc'>보기</th>
							</tr>
							<?php foreach($dn_list as $j => $dn) { ?>
							<tr>
							  <td class="center_pc" data-label="NO"><?php echo $dn->num ?></td>
							  <!-- <td data-label="아이디"><div class="ellipsis"><?php //echo ($dn->user_idx > 0) ? $dn->user_username : '(비회원)' ?></div></td> -->
							  <td class="center_pc" data-label="이름">
								<?php echo $dn->donor_name ?>
								<div><?php echo ($dn->user_idx > 0) ? $dn->user_username : '(비회원)' ?></div>
							  </td>
							  <td class="center_pc" data-label="기부일자"><?php echo $dn->reg_date ?></td>

							  <td class="center_pc" data-label="기부금액"><?php echo isset($dn->donation_comma) ? $dn->donation_comma.'원' : ''; ?></td>

							  <td class="center_pc" data-label="기부내용"><?php echo $dn->state_good_proc ?></td>
							  <td class="center_pc" data-label="기부금영수증"><?php echo (isset($dn->receipt_req_dt) && '' != $dn->receipt_req_dt) ? '신청' : ''; ?></td>
							  
							  <td class="center_pc" data-label="보기"><a href="/mypage/campaign/campaign_donate_detail/<?php echo $dn->cmp_code ?>/<?php echo $dn->idx ?>/<?php echo $dn->user_idx ?>"><button type="button" class="btn btn-default-flat btn-sm">상세정보</button></a></td>
							</tr>
							<?php } ?>
							</table>
						</div>

					</div>

					<hr class="clear_both" />

				</div>
			</div>

		</div>
	</div>


