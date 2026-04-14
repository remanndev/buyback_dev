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
							<div class="buyback-my-eyebrow">PROFILE</div>
							<h1 class="buyback-my-panel-title">내 정보</h1>
						</div>
					</div>

					<table class="buyback-my-info-table">
						<tr>
							<th>이름</th>
							<td><?php echo html_escape($user_summary['nickname']); ?></td>
						</tr>
						<tr>
							<th>아이디</th>
							<td><?php echo html_escape($user_summary['username']); ?></td>
						</tr>
						<tr>
							<th>이메일</th>
							<td><?php echo html_escape($user_summary['email']); ?></td>
						</tr>
						<tr>
							<th>연락처</th>
							<td><?php echo $user_summary['phone'] !== '' ? html_escape($user_summary['phone']) : '-'; ?></td>
						</tr>
						<tr>
							<th>로그인 방식</th>
							<td><?php echo html_escape($user_summary['login_type']); ?></td>
						</tr>
					</table>

					<div class="buyback-my-note">회원 정보 수정 기능은 다음 단계에서 별도로 연결할 예정입니다.</div>
				</div>
			</section>
		</div>
	</div>
</main>
