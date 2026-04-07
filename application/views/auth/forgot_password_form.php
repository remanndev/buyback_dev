<?php
if ($this->config->item('use_username', 'tank_auth')) {
	$login_label = '아이디 또는 이메일';
} else {
	$login_label = '이메일';
}

$login = array(
	'name'         => 'login',
	'id'           => 'login',
	'class'        => 'input required_field '.('' != form_error('login') ? 'is-error' : ''),
	'value'        => set_value('login'),
	'maxlength'    => 80,
	'size'         => 30,
	'placeholder'  => $login_label,
	'required'     => 'required',
	'autocomplete' => 'off'
);

// 모바일에서는 해당 요소 삭제
if (IS_MOBILE) {
	unset($login['required']);
}
?>

	<main class="page-main">
		<div class="auth-shell">
			<div class="card auth-card">

				<div class="auth-kicker">PASSWORD RESET</div>
				<h2 class="auth-title">비밀번호 재설정</h2>
				<p class="auth-subtitle">
					가입하신 계정 정보를 입력하시면
					비밀번호를 다시 설정할 수 있는 안내 메일을 보내드립니다.
				</p>

				<?php echo form_open($this->uri->uri_string(), 'class="auth-form"'); ?>
					<fieldset>
						<legend class="screen_out">비밀번호 재설정 입력폼</legend>

						<div class="form-group">
							<label class="form-label" for="<?php echo $login['id']; ?>"><?php echo $login_label; ?></label>
							<?php echo form_input($login); ?>
							<div class="form-error">
								<?php echo form_error($login['name']); ?>
								<?php echo isset($errors[$login['name']]) ? $errors[$login['name']] : ''; ?>
							</div>
							<div class="form-help">
								가입 시 사용한 아이디 또는 이메일 주소를 입력해 주세요.
							</div>
						</div>

						<div class="auth-actions">
							<?php echo form_submit('reset', '비밀번호 재설정 메일 받기', 'class="btn btn-primary"'); ?>
						</div>

						<div class="auth-links">
							<?php echo anchor('/auth/login/', '← 로그인 페이지로 이동'); ?>
						</div>
					</fieldset>
				<?php echo form_close(); ?>

				<div class="auth-note">
					메일이 도착하지 않으면 스팸함도 함께 확인해 주세요.
					입력한 정보가 가입 정보와 일치하지 않으면 메일이 발송되지 않을 수 있습니다.
				</div>

			</div>
		</div>
	</main>
