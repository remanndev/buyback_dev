<?php
$email = array(
	'name'         => 'email',
	'id'           => 'email',
	'value'        => set_value('email'),
	'maxlength'    => 80,
	'size'         => 30,
	'class'        => 'input required_field '.('' != form_error('email') ? 'is-error' : ''),
	'placeholder'  => '가입한 이메일 주소를 입력하세요',
	'required'     => 'required',
	'autocomplete' => 'email'
);

// 모바일에서는 해당 요소 삭제
if (IS_MOBILE) {
	unset($email['required']);
}
?>

	<main class="page-main">
		<div class="auth-shell">
			<div class="card auth-card">

				<div class="auth-kicker">RESEND VERIFICATION</div>
				<h2 class="auth-title">가입 인증 메일 재발송</h2>
				<p class="auth-subtitle">
					가입할 때 사용한 이메일 주소를 입력하시면
					인증 메일을 다시 보내드립니다.
				</p>

				<?php echo form_open($this->uri->uri_string(), 'class="auth-form"'); ?>
					<fieldset>
						<legend class="screen_out">가입 인증 메일 재발송 입력폼</legend>

						<div class="form-group">
							<label class="form-label" for="<?php echo $email['id']; ?>">이메일 주소</label>
							<?php echo form_input($email); ?>
							<div class="form-error">
								<?php echo form_error($email['name']); ?>
								<?php echo isset($errors[$email['name']]) ? $errors[$email['name']] : ''; ?>
							</div>
							<div class="form-help">
								회원가입 시 입력한 이메일 주소와 일치해야 합니다.
							</div>
						</div>

						<div class="auth-actions">
							<?php echo form_submit('send', '인증 메일 재발송', 'class="btn btn-primary"'); ?>
						</div>

						<div class="auth-links">
							<?php echo anchor('/auth/login/', '← 로그인 페이지로 이동'); ?>
						</div>
					</fieldset>
				<?php echo form_close(); ?>

				<div class="auth-note">
					메일이 도착하지 않으면 스팸함도 함께 확인해 주세요.
					이미 인증이 완료된 계정이거나 등록되지 않은 이메일이면 재발송되지 않을 수 있습니다.
				</div>

			</div>
		</div>
	</main>
