<?php
$password = array(
	'name'         => 'password',
	'id'           => 'password',
	'size'         => 30,
	'class'        => 'input required_field '.('' != form_error('password') ? 'is-error' : ''),
	'placeholder'  => '현재 비밀번호를 입력하세요',
	'required'     => 'required',
	'autocomplete' => 'off'
);

$email = array(
	'name'         => 'email',
	'id'           => 'email',
	'value'        => set_value('email'),
	'maxlength'    => 80,
	'size'         => 30,
	'class'        => 'input required_field '.('' != form_error('email') ? 'is-error' : ''),
	'placeholder'  => '새 이메일 주소를 입력하세요',
	'required'     => 'required',
	'autocomplete' => 'off'
);

// 모바일에서는 해당 요소 삭제
if (IS_MOBILE) {
	unset($password['required']);
	unset($email['required']);
}
?>

	<main class="page-main">
		<div class="auth-shell">
			<div class="card auth-card">

				<div class="auth-kicker">EMAIL CHANGE</div>
				<h2 class="auth-title">이메일 재설정</h2>
				<p class="auth-subtitle">
					본인 확인을 위해 현재 비밀번호를 입력한 뒤,
					새로 사용할 이메일 주소를 등록해 주세요.
				</p>

				<?php echo form_open($this->uri->uri_string(), 'class="auth-form"'); ?>
					<fieldset>
						<legend class="screen_out">이메일 재설정 입력폼</legend>

						<div class="form-group">
							<label class="form-label" for="<?php echo $password['id']; ?>">비밀번호</label>
							<?php echo form_password($password); ?>
							<div class="form-error">
								<?php echo form_error($password['name']); ?>
								<?php echo isset($errors[$password['name']]) ? $errors[$password['name']] : ''; ?>
							</div>
						</div>

						<div class="form-group">
							<label class="form-label" for="<?php echo $email['id']; ?>">새 이메일</label>
							<?php echo form_input($email); ?>
							<div class="form-error">
								<?php echo form_error($email['name']); ?>
								<?php echo isset($errors[$email['name']]) ? $errors[$email['name']] : ''; ?>
							</div>
							<div class="form-help">
								변경 후에는 새 이메일 주소로 안내 메일이 발송될 수 있습니다.
							</div>
						</div>

						<div class="auth-actions">
							<?php echo form_submit('change', '이메일 변경하기', 'class="btn btn-primary"'); ?>
						</div>

						<div class="auth-links">
							<?php echo anchor('/auth/login/', '← 로그인 페이지로 이동'); ?>
						</div>
					</fieldset>
				<?php echo form_close(); ?>

				<div class="auth-note">
					정확한 이메일 주소를 입력해 주세요.
					잘못된 주소를 입력하면 인증이나 안내 메일을 받지 못할 수 있습니다.
				</div>

			</div>
		</div>
	</main>
