
	<main class="page-main">
		<div class="auth-shell">

			<div class="card auth-card text-center">

				<!-- 아이콘 -->
				<div class="auth-complete-icon">
					✓
				</div>

				<!-- 타이틀 -->
				<h2 class="auth-complete-title">
					요청이 정상적으로 처리되었습니다
				</h2>

				<!-- 설명 -->
				<p class="auth-complete-desc">
					아래 안내 내용을 확인해 주세요.
				</p>

				<!-- 서버 메시지 -->
				<div class="auth-message is-info mt-20">
					<?php echo $message; ?>
				</div>

				<!-- 버튼 영역 -->
				<div class="auth-actions mt-24">
					<a href="/auth/login/" class="btn btn-primary">
						로그인 페이지로 이동
					</a>
				</div>

				<!-- 추가 안내 -->
				<div class="auth-note">
					문제가 지속될 경우 고객센터로 문의해 주세요.
				</div>

			</div>

		</div>
	</main>
