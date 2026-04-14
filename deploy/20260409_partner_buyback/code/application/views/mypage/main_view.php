<main class="flex-grow py-8 md:py-12">
	<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
		<?php $this->load->view('mypage/buyback_mypage_side_mobile_view', array('current_menu' => $current_menu)); ?>

		<div class="buyback-my-layout">
			<div class="hidden lg:block">
				<?php $this->load->view('mypage/buyback_mypage_side_view', array('current_menu' => $current_menu, 'user_summary' => $user_summary)); ?>
			</div>

			<section class="buyback-my-content">
				<div class="buyback-my-hero">
					<div>
						<div class="buyback-my-eyebrow">MY PAGE</div>
						<h1 class="buyback-my-title">내 매입 현황</h1>
						<p class="buyback-my-desc">최근 신청 내역과 진행 상태를 한눈에 확인할 수 있습니다.</p>
					</div>
					<a href="/mypage/buyback/lists" class="buyback-my-primary">신청 내역 보기</a>
				</div>

				<div class="buyback-my-stats">
					<div class="buyback-my-stat-card">
						<div class="buyback-my-stat-label">총 신청 건수</div>
						<div class="buyback-my-stat-value"><?php echo number_format($summary['total_count']); ?></div>
					</div>
					<div class="buyback-my-stat-card">
						<div class="buyback-my-stat-label">접수/대기</div>
						<div class="buyback-my-stat-value"><?php echo number_format($summary['requested_count']); ?></div>
					</div>
					<div class="buyback-my-stat-card">
						<div class="buyback-my-stat-label">검수중</div>
						<div class="buyback-my-stat-value"><?php echo number_format($summary['processing_count']); ?></div>
					</div>
					<div class="buyback-my-stat-card">
						<div class="buyback-my-stat-label">누적 예상 금액</div>
						<div class="buyback-my-stat-value"><?php echo html_escape($summary['total_price_text']); ?></div>
					</div>
				</div>

				<div class="buyback-my-panel">
					<div class="buyback-my-panel-head">
						<h2 class="buyback-my-panel-title">최근 신청 내역</h2>
						<a href="/mypage/buyback/lists" class="buyback-my-link">전체 보기</a>
					</div>

					<?php if (!empty($recent_requests)) { ?>
						<div class="buyback-my-request-list">
							<?php foreach ($recent_requests as $item) { ?>
								<a href="<?php echo $item['detail_url']; ?>" class="buyback-my-request-item">
									<div class="buyback-my-request-main">
										<div class="buyback-my-request-no"><?php echo html_escape($item['request_no']); ?></div>
										<div class="buyback-my-request-summary"><?php echo html_escape($item['device_summary']); ?></div>
									</div>
									<div class="buyback-my-request-meta">
										<span><?php echo html_escape($item['created_date']); ?></span>
										<span class="buyback-my-chip"><?php echo html_escape($item['status_label']); ?></span>
										<span><?php echo html_escape($item['total_price_text']); ?></span>
									</div>
								</a>
							<?php } ?>
						</div>
					<?php } else { ?>
						<div class="buyback-my-empty">아직 등록된 매입 신청이 없습니다.</div>
					<?php } ?>
				</div>
			</section>
		</div>
	</div>
</main>
