<?php
$old_password = array(
	'name'         => 'old_password',
	'id'           => 'old_password',
	'class'        => 'input required_field '.('' != form_error('old_password') ? 'is-error' : ''),
	'value'        => set_value('old_password'),
	'size'         => 30,
	'placeholder'  => '기존 비밀번호를 입력하세요',
	'required'     => 'required',
	'autocomplete' => 'off'
);

$new_password = array(
	'name'         => 'new_password',
	'id'           => 'new_password',
	'class'        => 'input required_field '.('' != form_error('new_password') ? 'is-error' : ''),
	'maxlength'    => $this->config->item('password_max_length', 'tank_auth'),
	'size'         => 30,
	'placeholder'  => '새 비밀번호를 입력하세요',
	'required'     => 'required',
	'autocomplete' => 'off'
);

$confirm_new_password = array(
	'name'         => 'confirm_new_password',
	'id'           => 'confirm_new_password',
	'class'        => 'input required_field '.('' != form_error('confirm_new_password') ? 'is-error' : ''),
	'maxlength'    => $this->config->item('password_max_length', 'tank_auth'),
	'size'         => 30,
	'placeholder'  => '새 비밀번호를 다시 입력하세요',
	'required'     => 'required',
	'autocomplete' => 'off'
);

// 모바일에서는 해당 요소 삭제
if (IS_MOBILE) {
	unset($old_password['required']);
	unset($new_password['required']);
	unset($confirm_new_password['required']);
}
?>

	<main class="page-main">
		<div class="auth-shell">
			<div class="card auth-card">

				<div class="auth-kicker">PASSWORD CHANGE</div>
				<h2 class="auth-title">비밀번호 변경</h2>
				<p class="auth-subtitle">
					현재 비밀번호를 확인한 뒤
					새로운 비밀번호로 변경해 주세요.
				</p>

				<?php echo form_open($this->uri->uri_string(), 'class="auth-form"'); ?>
					<fieldset>
						<legend class="screen_out">비밀번호 변경 입력폼</legend>

						<div class="form-group">
							<label class="form-label" for="<?php echo $old_password['id']; ?>">기존 비밀번호</label>
							<?php echo form_password($old_password); ?>
							<div class="form-error">
								<?php echo form_error($old_password['name']); ?>
								<?php echo isset($errors[$old_password['name']]) ? $errors[$old_password['name']] : ''; ?>
							</div>
						</div>

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
					새 비밀번호는 기존 비밀번호와 다르게 설정하는 것이 좋습니다.
					타인에게 유추되기 쉬운 번호나 반복 문자열은 피해주세요.
				</div>

			</div>
		</div>
	</main>
