<?php
/* 아이디 */
if ($use_username) {
	$username = array(
		'name'         => 'username',
		'id'           => 'username',
		'class'        => 'input required_field '.('' != form_error('username') ? 'is-error' : ''),
		'value'        => form_error('username') ? '' : set_value('username'),
		'maxlength'    => $this->config->item('username_max_length', 'tank_auth'),
		'size'         => 30,
		'placeholder'  => '아이디',
		'required'     => 'required',
		'autocomplete' => 'username'
	);
}

/* 이름 */
if ($use_nickname) {
	$nickname = array(
		'name'         => 'nickname',
		'id'           => 'nickname',
		'class'        => 'input required_field '.('' != form_error('nickname') ? 'is-error' : ''),
		'value'        => form_error('nickname') ? '' : set_value('nickname'),
		'maxlength'    => $this->config->item('nickname_max_length', 'tank_auth'),
		'placeholder'  => '이름',
		'required'     => 'required',
		'autocomplete' => 'name'
	);
}

/* 상호/법인명 */
$company = array(
	'name'         => 'company',
	'id'           => 'company',
	'value'        => form_error('company') ? '' : set_value('company'),
	'maxlength'    => 100,
	'class'        => 'input '.('' != form_error('company') ? 'is-error' : ''),
	'placeholder'  => '상호/법인명',
	'autocomplete' => 'organization'
);

$email = array(
	'name'         => 'email',
	'id'           => 'email',
	'class'        => 'input required_field '.('' != form_error('email') ? 'is-error' : ''),
	'value'        => form_error('email') ? '' : set_value('email'),
	'maxlength'    => 80,
	'size'         => 30,
	'placeholder'  => '이메일',
	'required'     => 'required',
	'autocomplete' => 'email'
);

$password = array(
	'name'         => 'password',
	'type'         => 'password',
	'id'           => 'password',
	'class'        => 'input required_field '.('' != form_error('password') ? 'is-error' : ''),
	'maxlength'    => $this->config->item('password_max_length', 'tank_auth'),
	'size'         => 30,
	'placeholder'  => '비밀번호',
	'required'     => 'required',
	'autocomplete' => 'new-password'
);

$confirm_password = array(
	'name'         => 'confirm_password',
	'type'         => 'password',
	'id'           => 'confirm_password',
	'class'        => 'input required_field '.('' != form_error('confirm_password') ? 'is-error' : ''),
	'maxlength'    => $this->config->item('password_max_length', 'tank_auth'),
	'size'         => 30,
	'placeholder'  => '비밀번호 재확인',
	'required'     => 'required',
	'autocomplete' => 'new-password'
);

$captcha = array(
	'name'         => 'captcha',
	'id'           => 'captcha',
	'maxlength'    => 8,
	'class'        => 'input required_field '.('' != form_error('captcha') ? 'is-error' : ''),
	'placeholder'  => '인증코드',
	'required'     => 'required',
	'autocomplete' => 'off'
);

/* 모바일에서는 해당 요소 삭제 */
if (IS_MOBILE) {
	if ($use_username) unset($username['required']);
	if ($use_nickname) unset($nickname['required']);
	unset($email['required']);
	unset($password['required']);
	unset($confirm_password['required']);
	unset($captcha['required']);
}
?>

	<main class="page-main">
		<div class="auth-shell">
			<div class="card auth-card">

				<div class="auth-kicker">SIGN UP</div>
				<h2 class="auth-title">회원 가입</h2>
				<p class="auth-subtitle">
					기본 정보를 입력해 계정을 생성해 주세요.
					가입 후 인증 또는 승인 절차가 진행될 수 있습니다.
				</p>

				<?php echo form_open($this->uri->uri_string(), 'class="auth-form"'); ?>
					<input type="hidden" name="group_fk" id="group_fk" value="<?php echo set_value('group_fk', 10); ?>" />

					<fieldset>
						<legend class="screen_out">회원가입 입력폼</legend>

						<?php if ($use_username) { ?>
							<div class="form-group">
								<label class="form-label" for="<?php echo $username['id']; ?>">아이디</label>
								<?php echo form_input($username); ?>
								<div class="form-error">
									<?php echo form_error($username['name']); ?>
									<?php echo isset($errors[$username['name']]) ? $errors[$username['name']] : ''; ?>
								</div>
							</div>
						<?php } ?>

						<?php if ($use_nickname) { ?>
							<div class="form-group">
								<label class="form-label" for="<?php echo $nickname['id']; ?>">이름</label>
								<?php echo form_input($nickname); ?>
								<div class="form-error">
									<?php echo form_error($nickname['name']); ?>
									<?php echo isset($errors[$nickname['name']]) ? $errors[$nickname['name']] : ''; ?>
								</div>
							</div>
						<?php } ?>

						<div class="form-group">
							<label class="form-label" for="<?php echo $email['id']; ?>">이메일</label>
							<?php echo form_input($email); ?>
							<div class="form-error">
								<?php echo form_error($email['name']); ?>
								<?php echo isset($errors[$email['name']]) ? $errors[$email['name']] : ''; ?>
							</div>
						</div>

						<div class="form-group">
							<label class="form-label" for="<?php echo $password['id']; ?>">비밀번호</label>
							<?php echo form_password($password); ?>
							<div class="form-error">
								<?php echo form_error($password['name']); ?>
								<?php echo isset($errors[$password['name']]) ? $errors[$password['name']] : ''; ?>
							</div>
							<div class="form-help">
								영문, 숫자, 특수문자를 조합하면 더 안전합니다.
							</div>
						</div>

						<div class="form-group">
							<label class="form-label" for="<?php echo $confirm_password['id']; ?>">비밀번호 확인</label>
							<?php echo form_password($confirm_password); ?>
							<div class="form-error">
								<?php echo form_error($confirm_password['name']); ?>
								<?php echo isset($errors[$confirm_password['name']]) ? $errors[$confirm_password['name']] : ''; ?>
							</div>
						</div>

						<div class="form-group">
							<label class="form-label" for="<?php echo $company['id']; ?>">상호/법인명</label>
							<?php echo form_input($company); ?>
							<div class="form-error">
								<?php echo form_error($company['name']); ?>
								<?php echo isset($errors[$company['name']]) ? $errors[$company['name']] : ''; ?>
							</div>
							<div class="form-help">
								개인 회원이면 비워두셔도 됩니다.
							</div>
						</div>

						<?php if ($captcha_registration) { ?>
							<?php if ($use_recaptcha) { ?>
								<div class="form-group">
									<div class="auth-code-box">
										<div id="recaptcha_image"></div>

										<div class="auth-links mt-12">
											<a href="javascript:Recaptcha.reload()">새 CAPTCHA 보기</a>
											<div class="recaptcha_only_if_image">
												<a href="javascript:Recaptcha.switch_type('audio')">음성 CAPTCHA로 전환</a>
											</div>
											<div class="recaptcha_only_if_audio">
												<a href="javascript:Recaptcha.switch_type('image')">이미지 CAPTCHA로 전환</a>
											</div>
										</div>

										<div class="form-group mt-16 mb-0">
											<label class="form-label" for="recaptcha_response_field">인증코드</label>
											<input type="text" id="recaptcha_response_field" name="recaptcha_response_field" class="input" />
											<div class="form-error"><?php echo form_error('recaptcha_response_field'); ?></div>
										</div>

										<?php echo $recaptcha_html; ?>
									</div>
								</div>
							<?php } else { ?>
								<div class="form-group">
									<label class="form-label" for="<?php echo $captcha['id']; ?>">인증코드</label>
									<div class="auth-code-box">
										<?php echo form_input($captcha); ?>

										<div id="btn_renew_code" class="auth-code-view" title="클릭하시면 새로운 코드로 갱신됩니다.">
											<span id="span_captcha_html" class="<?php echo ((mt_rand(1,100) % 2) < 1) ? 'gray_scale' : ''; ?>">
												<?php echo $captcha_html; ?>
											</span>
										</div>

										<div class="auth-code-help">이미지를 클릭하면 인증코드가 새로고침됩니다.</div>
									</div>

									<div class="form-error">
										<?php echo form_error($captcha['name']); ?>
										<?php echo isset($errors[$captcha['name']]) ? $errors[$captcha['name']] : ''; ?>
									</div>
								</div>
							<?php } ?>
						<?php } ?>

						<div class="auth-actions">
							<?php echo form_submit('register', '회원가입', 'class="btn btn-primary"'); ?>
						</div>

						<div class="auth-links">
							<?php echo anchor('/auth/login/', '← 로그인 페이지로 이동'); ?>
						</div>
					</fieldset>
				<?php echo form_close(); ?>

				<div class="auth-note">
					가입 후 이메일 인증 또는 관리자 승인 절차가 진행될 수 있습니다.
					정확한 정보를 입력해 주세요.
				</div>

			</div>
		</div>
	</main>

<script type="text/javascript">
/*
	기존 group_fk / 회원유형 전환 스크립트가 필요하면
	현재 구조에 맞춰 별도로 다시 붙이면 됩니다.
*/
</script>