<?php
$password = array(
	'name'         => 'password',
	'id'           => 'password',
	'type'         => 'password',
	'size'         => 30,
	'class'        => 'input required_field '.('' != form_error('password') ? 'is-error' : ''),
	'placeholder'  => '비밀번호를 입력하세요',
	'required'     => 'required',
	'autocomplete' => 'current-password'
);

// 모바일에서는 해당 요소 삭제
if (IS_MOBILE) {
	unset($password['required']);
}
?>

	<main class="page-main">
		<div class="auth-shell">
			<div class="card auth-card">

				<div class="auth-kicker">ACCOUNT DELETE</div>
				<h2 class="auth-title">회원 탈퇴</h2>
				<p class="auth-subtitle">
					본인 확인을 위해 비밀번호를 입력해 주세요.
					탈퇴를 진행하면 계정 이용이 중단됩니다.
				</p>

				<div class="auth-message is-error">
					회원 탈퇴는 되돌릴 수 없습니다.
					탈퇴 전에 필요한 정보가 있는지 다시 확인해 주세요.
				</div>

				<?php echo form_open($this->uri->uri_string(), array('class' => 'auth-form', 'onsubmit' => 'return chk_form();')); ?>
					<fieldset>
						<legend class="screen_out">회원 탈퇴</legend>

						<div class="form-group">
							<label class="form-label" for="<?php echo $password['id']; ?>">비밀번호</label>
							<?php echo form_password($password); ?>
							<div class="form-error">
								<?php echo form_error($password['name']); ?>
								<?php echo isset($errors[$password['name']]) ? $errors[$password['name']] : ''; ?>
							</div>
						</div>

						<div class="auth-actions">
							<?php echo form_submit('cancel', '회원 탈퇴', 'class="btn btn-primary"'); ?>
						</div>

						<div class="auth-links">
							<?php echo anchor('/auth/login/', '← 로그인 페이지로 이동'); ?>
						</div>
					</fieldset>
				<?php echo form_close(); ?>

				<div class="auth-note">
					탈퇴 처리 이후에는 계정 복구가 제한될 수 있습니다.
					서비스 정책에 따라 일부 정보는 관련 법령에 따라 일정 기간 보관될 수 있습니다.
				</div>

			</div>
		</div>
	</main>


<script>
function chk_form() {
	if (confirm('정말 탈퇴하시겠습니까?')) {
		return true;
	}
	return false;
}
</script>