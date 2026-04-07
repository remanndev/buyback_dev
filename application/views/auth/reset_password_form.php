<?php
$new_password = array(
	'name'         => 'new_password',
	'id'           => 'new_password',
	'class'        => 'input required_field '.('' != form_error('new_password') ? 'is-error' : ''),
	'maxlength'    => $this->config->item('password_max_length', 'tank_auth'),
	'size'         => 30,
	'placeholder'  => '새 비밀번호를 입력하세요',
	'required'     => 'required',
	'autocomplete' => 'new-password'
);

$confirm_new_password = array(
	'name'         => 'confirm_new_password',
	'id'           => 'confirm_new_password',
	'class'        => 'input required_field '.('' != form_error('confirm_new_password') ? 'is-error' : ''),
	'maxlength'    => $this->config->item('password_max_length', 'tank_auth'),
	'size'         => 30,
	'placeholder'  => '새 비밀번호를 다시 입력하세요',
	'required'     => 'required',
	'autocomplete' => 'new-password'
);

// 모바일에서는 해당 요소 삭제
if (IS_MOBILE) {
	unset($new_password['required']);
	unset($confirm_new_password['required']);
}
?>

	<main class="page-main">
		<div class="auth-shell">
			<div class="card auth-card">

				<div class="auth-kicker">NEW PASSWORD</div>
				<h2 class="auth-title">비밀번호 변경</h2>
				<p class="auth-subtitle">
					새로 사용할 비밀번호를 입력해 주세요.
					안전한 비밀번호로 변경한 뒤 다시 로그인하실 수 있습니다.
				</p>

				<?php echo form_open($this->uri->uri_string(), 'class="auth-form"'); ?>
					<fieldset>
						<legend class="screen_out">비밀번호 변경 입력폼</legend>

						<div class="form-group">
							<label class="form-label" for="<?php echo $new_password['id']; ?>">새 비밀번호</label>
							<?php echo form_password($new_password); ?>
							<div class="form-error">
								<?php echo form_error($new_password['name']); ?>
								<?php echo isset($errors[$new_password['name']]) ? $errors[$new_password['name']] : ''; ?>
							</div>
							<div class="form-help">
								영문, 숫자, 특수문자를 조합하면 더 안전합니다.
							</div>
						</div>

						<div class="form-group">
							<label class="form-label" for="<?php echo $confirm_new_password['id']; ?>">새 비밀번호 확인</label>
							<?php echo form_password($confirm_new_password); ?>
							<div class="form-error">
								<?php echo form_error($confirm_new_password['name']); ?>
								<?php echo isset($errors[$confirm_new_password['name']]) ? $errors[$confirm_new_password['name']] : ''; ?>
							</div>
						</div>

						<div class="auth-actions">
							<?php echo form_submit('change', '비밀번호 변경하기', 'class="btn btn-primary"'); ?>
						</div>

						<div class="auth-links">
							<?php echo anchor('/auth/login/', '← 로그인 페이지로 이동'); ?>
						</div>
					</fieldset>
				<?php echo form_close(); ?>

				<div class="auth-note">
					새 비밀번호는 이전에 사용한 비밀번호와 다르게 설정하는 것이 좋습니다.
					타인이 쉽게 추측할 수 있는 정보는 피해주세요.
				</div>

			</div>
		</div>
	</main>
