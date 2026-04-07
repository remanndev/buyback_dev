	<!-- 모바일 -->
	<?php $this->load->view('mypage/mypage_side_mobile_view'); ?>


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
			padding: 0.8125vw 1.25vw;
			font-size: 15px;
			font-size: 1.3vw;
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
				padding: 12px 20px;
				font-size: 16px;
				line-height: 22px;
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
					<div class="mypage_ctnt" style="">
						<h2 class="mb_40" style="color:#353535;">나의 기부 물품 현황 <small>- 목록</small></h2>
						<div class="tbl_frm  res_tbl_wrap">
							<table class="table-hover">
							<tr class="_pc">
							  <th class="center_pc">NO</th>
							  <th>캠페인명</th>
							  <th class="center_pc" style="width: 135px;">기부신청일자</th>
							  <th class="center_pc" style="width: 100px;">상태</th>
							  <th class="center_pc" style="width: 100px;">수거신청</th>
							</tr>
							<?php foreach($list as $i => $o) { ?>
							<tr class="tbl_list">
							  <td class="center_pc" data-label="NO"><?php echo $o->num ?></td>
							  <td data-label="캠페인명">
								<a href="/mypage/donation/detail/<?php echo $o->cmp_code ?>/<?php echo $o->idx ?>"><span class="" style="width: 100%; max-width:320px;"><?php echo $o->cmp_title ?></span></a>
								<!-- <span class="badge bg-secondary" style="padding: 5px 5px;"><?php //echo $o->dng_str ?></span> -->
							  </td>
							  <td class="center_pc" data-label="기부신청일자"><?php echo $o->reg_date ?></td>
							  <td class="center_pc" data-label="상태">
								<?php echo $o->state_good_proc ?>
							  </td>
							  <td class="center_pc" data-label="수거신청">
								<?php echo $o->btn_updateWaState ?>
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


<?php 
/*
$json = '{"data":"success"}';
$arr = json_decode($json);
print_r($arr->data);
*/
?>


<script type='text/javascript'>
//<![CDATA[
	$(function() {

		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		// 1. 택배 반품접수 요청 보내기
		// 2. 작업요청 전송(기부하기) 상태에서 수거 신청 상태로 업데이트
		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		$('.btn_updateWaState').on('click',function(){

			const obj = $(this);

			if( confirm('리플러스박스를 받으셨나요?\n물품포장을 완료한 후 신청해주세요.') ) {

				// 버튼 중복 클릭 못하게 처리
				obj.prop('disabled', true);

				const dn_idx = obj.data('idx');
				console.log(dn_idx);

				var request = $.ajax({
				  url: "/trans/ros_replus_returnParcel_updateWaState/",
				  method: "POST",
				  data: { 'dn_idx': dn_idx, 'reqState' : 1  /* , '<?php echo $this->security->get_csrf_token_name() ?>':'<?php echo $this->security->get_csrf_hash() ?>' */},
				  dataType: "text"
				});
				request.done(function( res ) {

					//console.log(res);

					/*
					// 대문자 SUCCESS 리턴하면, 
					// 1차 택배반품 성공, 2차 수거신청 상태 업데이트 성공  >>> 2가지 모두 성공한 것.
					if('SUCCESS' == res) {

						// 버튼 클릭 못하게 처리
						//obj.prop('disabled', true);

						// 상태 변경 성공
						alert('신청이 완료되었습니다.');
						location.reload();
					}
					else if (res.substring(0, 2) === "e:") {
						//alert('택배 수거 신청이 접수되지 못했습니다.\n관리자에 문의해주세요.\n\n'+res);
						alert('택배 수거 신청이 접수되지 못했습니다.\n관리자에 문의해주세요.');
						// 버튼 클릭 disabled 취소
						obj.prop('disabled', false);
					}
					else if (res === "W:NotThisTime") {
						alert('리플러스박스가 발송되어 배송중입니다.\n배송받으신 박스에 물품포장을 완료한 후 신청해주세요.');
						// 버튼 클릭 disabled 취소
						obj.prop('disabled', false);
					}
					else {
						// 상태 변경 실패
						//alert('리플러스 수거 요청을 처리하지 못했습니다. \n계속해서 처리되지 않을 경우, 관리자에 문의해주시기 바랍니다.\n\n'+res);
						alert('리플러스 수거 요청을 처리하지 못했습니다. \n계속해서 처리되지 않을 경우, 관리자에 문의해주시기 바랍니다.');
						// 버튼 클릭 disabled 취소
						obj.prop('disabled', false);
					}
					*/



					// 대문자 SUCCESS 리턴하면, 
					// 1차 택배반품 성공, 2차 수거신청 상태 업데이트 성공  >>> 2가지 모두 성공한 것.
					if('SUCCESS' == res) {
						// 상태 변경 성공
						alert('신청이 완료되었습니다.');
						location.reload();
					}
					else if (res === "W:NotThisTime") {
						// alert('리플러스박스가 발송되어 배송중입니다.\n배송받으신 박스에 물품포장을 완료한 후 신청해주세요.');
						alert('신청이 접수되었습니다.\n배송받으신 박스에 물품을 포장하신 후, 수거장소에 비치해주세요.');
						// 버튼 클릭 disabled 취소
						obj.prop('disabled', false);
					}
					else {
						// 신청은 했지만, 뭔가 문제가 생겨서, 접수되었다고 알려줌
						alert('신청이 접수되었습니다.');
						location.reload();
					}




				});
				request.fail(function( jqXHR, textStatus ) {
				  alert( "Request failed: " + textStatus );
				});

			}

		});







		/*
		$('.btn_updateWaState').on('click',function(){

			if( confirm('수거박스를 받으셨나요?\n물품포장을 완료한 후 신청해주세요.') ) {

				const dn_idx = $(this).data('idx');

				var request = $.ajax({
				  url: "/trans/ros_replus_updateWaState/",
				  method: "POST",
				  data: { 'idx': dn_idx, 'reqState' : 1},
				  dataType: "text"
				});
				request.done(function( res ) {

					//console.log(res);
					if('SUCCESS' == res) {
						// 상태 변경 성공
						location.reload();
					}
					else {
						// 상태 변경 실패
						alert('수거 신청이 되지 않았습니다. \n계속해서 신청이 되지 않을 경우, 관리자에 문의해주시기 바랍니다.');
					}
				});
				request.fail(function( jqXHR, textStatus ) {
				  alert( "Request failed: " + textStatus );
				});

			}

		});
		*/


	});
//]]>
</script>
