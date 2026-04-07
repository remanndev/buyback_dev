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

						<h2 class="mb_40" style="display:block; color:#353535;">나의 기부 물품 현황 <small>- 상세 - 기부금 영수증</small></h2>

						<dl class="mt_30">
							<dt>1. 기부명</dt>
							<dd class="mt_10 py_20 px_20" style="background-color:#f7f7fb;">
								<?php echo $cmp_row->cmp_title; ?>
							</dd>
						</dl>

						<dl class="mt_30">
							<dt>2. 기부금 영수증 신청 안내</dt>
							<dd class="mt_10 py_20 px_20" style="background-color:#f7f7fb;">
							<?php if( isset($dn_row->receipt_req_dt) ) { ?>
								<button id="btn_request_receipt" type="button" class="o_btn btn btn-secondary" disabled>신청완료</button>
							<?php } else { ?>
								<button id="btn_request_receipt" type="button" class="o_btn btn btn-purple-line"  onclick="request_receipt();">신청하기</button>
							<?php } ?>
							</dd>
						</dl>

						<dl class="mt_30">
							<dt>3. 기부금 영수증 발급 안내</dt>
							<dd class="mt_10 py_20 px_20" style="background-color:#f7f7fb;">
								회원님의 성함과 주민등록번호(13자리)를 기입한 경우 홈택스에서 확인할 수 있습니다.<br />
								<a href="https://www.hometax.go.kr/" target="_blank"><button type="button" class="o_btn btn btn-purple-line mt_10">홈택스 바로 가기</button></a>

							</dd>
						</dl>

						<?php /* 
						<dl class="mt_30">
							<dt>4. 기부금 영수증 인쇄 안내 </dt>
							<dd class="mt_10 py_20 px_20" style="background-color:#f7f7fb;">
								디지털기부플랫폼에서 발급한 기부금영수증을 원하실 경우 홈페이지에서 직접 인쇄 할 수 있습니다. <br />
								
								<a href="/mypage/donation/report_receipt_paper/<?php echo $cmp_row->code; ?>/<?php echo $dn_row->idx ?>" target="_blank"><button type="button" class="o_btn btn btn-purple-line mt_10">기부금영수증 확인하기</button></a>
								</div>
							</dd>
						</dl>
						*/ ?>
					</div>

				</div>
			</div>
		</div>
	</div>

	
	
<script type="text/javascript">
$(document).ready(function(){

	// receipt_req_dt

	

	
});

function request_receipt() {

	var dn_idx = '<?php echo $dn_idx ?>';
	var cmp_code = '<?php echo $cmp_code ?>';
	var u_idx = '<?php echo $u_idx ?>';

	var request = $.ajax({
	  url: "/trans/request_receipt",
	  method: "POST",
	  data: { 'dn_idx':dn_idx,'cmp_code':cmp_code,'u_idx':u_idx },
	  dataType: "html"
	});
	request.done(function( res ) {
	  console.log(res);
	  //obj.next().css('display', 'inline-block');;
	  //setTimeout(msgAutoHide, 1000, obj);


	  // [res]
	  // true,false, already, null

	  if( res == 'true' ) {
		  alert('기부금 영수증 신청이 완료되었습니다.');
		  // 신청 완료 표시
		  $('#btn_request_receipt').text('신청완료').prop('disabled',true);
	  }
	  else if( res == 'false' ) {
		  alert('기부금 영수증 신청이 접수되지 못했습니다.\n관리자에 문의해 주세요.');
	  }
	  else if( res == 'already' ) {
		  alert('이미 신청하셨습니다.');
		  // 신청 완료 표시
		  $('#btn_request_receipt').text('신청완료').prop('disabled',true);
	  }
	  else {
		  alert('캠페인 또는 기부내역이 존재하지 않습니다.');
	  }

	});
	request.fail(function( jqXHR, textStatus ) {
	  alert( "Request failed: " + textStatus );
	  return false;
	});

}
</script>