<main class="flex-grow py-8 md:py-12">
	<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
		<?php $this->load->view('mypage/buyback_mypage_side_mobile_view', array('current_menu' => $current_menu)); ?>

		<div class="buyback-my-layout">
			<div class="hidden lg:block">
				<?php $this->load->view('mypage/buyback_mypage_side_view', array('current_menu' => $current_menu, 'user_summary' => $user_summary)); ?>
			</div>

			<section class="buyback-my-content">
				<div class="buyback-my-panel">
					<div class="buyback-my-panel-head">
						<div>
							<div class="buyback-my-eyebrow">REQUEST DETAIL</div>
							<h1 class="buyback-my-panel-title">매입 신청 상세</h1>
						</div>
						<a href="/mypage/buyback/lists" class="buyback-my-link-button">목록으로</a>
					</div>

					<div class="buyback-my-section">
						<h2 class="buyback-my-section-title">신청 정보</h2>
						<table class="buyback-my-info-table">
							<tr>
								<th>접수번호</th>
								<td><?php echo html_escape($request['request_no']); ?></td>
							</tr>
							<tr>
								<th>회원사</th>
								<td><?php echo html_escape($request['partner_name']); ?></td>
							</tr>
							<tr>
								<th>신청 상태</th>
								<td><span class="buyback-my-chip"><?php echo html_escape($request['status_label']); ?></span></td>
							</tr>
							<tr>
								<th>연동 상태</th>
								<td><?php echo html_escape($request['api_status_label']); ?></td>
							</tr>
							<tr>
								<th>신청일시</th>
								<td><?php echo html_escape($request['created_at']); ?></td>
							</tr>
							<tr>
								<th>총 금액</th>
								<td><?php echo html_escape($request['total_price_text']); ?></td>
							</tr>
						</table>
					</div>

					<div class="buyback-my-section">
						<h2 class="buyback-my-section-title">수거 정보</h2>
						<table class="buyback-my-info-table">
							<tr>
								<th>신청자명</th>
								<td><?php echo html_escape($request['applicant_name']); ?></td>
							</tr>
							<tr>
								<th>연락처</th>
								<td><?php echo html_escape($request['phone']); ?></td>
							</tr>
							<tr>
								<th>주소</th>
								<td><?php echo html_escape($request['address']); ?></td>
							</tr>
							<tr>
								<th>방문 일시</th>
								<td><?php echo html_escape($request['visit_at']); ?></td>
							</tr>
							<tr>
								<th>수거 위치</th>
								<td><?php echo html_escape($request['pickup_location']); ?></td>
							</tr>
							<tr>
								<th>요청 메모</th>
								<td><?php echo nl2br(html_escape($request['pickup_memo'])); ?></td>
							</tr>
							<tr>
								<th>입금 계좌</th>
								<td><?php echo html_escape($request['bank_account']); ?></td>
							</tr>
						</table>
					</div>

					<div class="buyback-my-section">
						<h2 class="buyback-my-section-title">신청 기기</h2>
						<?php if (!empty($request['devices'])) { ?>
							<div class="buyback-my-device-list">
								<?php foreach ($request['devices'] as $device) { ?>
									<div class="buyback-my-device-card">
										<div class="buyback-my-device-title"><?php echo html_escape($device['label']); ?></div>
										<div class="buyback-my-device-meta">
											<span>수량 <?php echo (int) $device['qty']; ?>개</span>
											<?php if (!empty($device['condition_grade'])) { ?>
												<span>상태 <?php echo html_escape($device['condition_grade']); ?></span>
											<?php } ?>
											<span>단가 <?php echo html_escape($device['price_text']); ?></span>
										</div>

										<?php if (!empty($device['spec_lines'])) { ?>
											<ul class="buyback-my-spec-list">
												<?php foreach ($device['spec_lines'] as $spec_line) { ?>
													<li><?php echo html_escape($spec_line['label']); ?>: <?php echo html_escape($spec_line['value']); ?></li>
												<?php } ?>
											</ul>
										<?php } ?>
									</div>
								<?php } ?>
							</div>
						<?php } else { ?>
							<div class="buyback-my-empty">등록된 기기 정보가 없습니다.</div>
						<?php } ?>
					</div>
				</div>
			</section>
		</div>
	</div>
</main>
