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
							<div class="buyback-my-eyebrow">BUYBACK HISTORY</div>
							<h1 class="buyback-my-panel-title">매입 신청 내역</h1>
						</div>
					</div>

					<?php if (!empty($list)) { ?>
						<div class="buyback-my-table-wrap">
							<table class="buyback-my-table">
								<thead>
									<tr>
										<th>접수번호</th>
										<th>회원사</th>
										<th>신청 기기</th>
										<th>신청일</th>
										<th>상태</th>
										<th>총 금액</th>
										<th>상세</th>
									</tr>
								</thead>
								<tbody>
									<?php foreach ($list as $item) { ?>
										<tr>
											<td data-label="접수번호"><?php echo html_escape($item['request_no']); ?></td>
											<td data-label="회원사"><?php echo html_escape($item['partner_name']); ?></td>
											<td data-label="신청 기기"><?php echo html_escape($item['device_summary']); ?></td>
											<td data-label="신청일"><?php echo html_escape($item['created_date']); ?></td>
											<td data-label="상태"><span class="buyback-my-chip"><?php echo html_escape($item['status_label']); ?></span></td>
											<td data-label="총 금액"><?php echo html_escape($item['total_price_text']); ?></td>
											<td data-label="상세"><a href="<?php echo $item['detail_url']; ?>" class="buyback-my-link-button">상세 보기</a></td>
										</tr>
									<?php } ?>
								</tbody>
							</table>
						</div>
					<?php } else { ?>
						<div class="buyback-my-empty">등록된 매입 신청 내역이 없습니다.</div>
					<?php } ?>
				</div>
			</section>
		</div>
	</div>
</main>
