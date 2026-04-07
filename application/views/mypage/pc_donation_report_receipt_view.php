	<div class="container_wrap">
		<div class="contents_wrap">

			<!-- 마이페이지 사이드 메뉴 -->
			<?php $this->load->view('mypage/pc_side_view'); ?>

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
					<dt>2. 기부금 영수증 발급 안내</dt>
					<dd class="mt_10 py_20 px_20" style="background-color:#f7f7fb;">
						회원님의 성함과 주민등록번호(13자리)를 기입한 경우 홈택스에서 확인할 수 있습니다.<br />
						<a href="https://www.hometax.go.kr/" target="_blank"><button type="button" class="o_btn btn btn-purple-line mt_10">홈택스 바로 가기</button></a>

					</dd>
				</dl>

				<dl class="mt_30">
					<dt>3. 기부금 영수증 인쇄 안내 </dt>
					<dd class="mt_10 py_20 px_20" style="background-color:#f7f7fb;">
						디지털기부플랫폼에서 발급한 기부금영수증을 원하실 경우 홈페이지에서 직접 인쇄 할 수 있습니다. <br />
						
						<a href="/mypage/donation/report_receipt_paper/<?php echo $cmp_row->code; ?>/<?php echo $dn_row->idx ?>" target="_blank"><button type="button" class="o_btn btn btn-purple-line mt_10">기부금영수증 확인하기</button></a>
						</div>
					</dd>
				</dl>



			</div>

			<hr class="clear_both" />
		</div>
	</div>