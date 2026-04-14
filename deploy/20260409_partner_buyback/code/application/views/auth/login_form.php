<?php
$hide_by_admin = '';
$show_by_admin = '';
if ('admin' == $rpath_admin) {
    $hide_by_admin = 'display:none;';
    $show_by_admin = 'display:block;';
}

if ($login_by_username && $login_by_email) {
    $login_label = '아이디 또는 이메일';
} elseif ($login_by_username) {
    $login_label = '아이디';
} else {
    $login_label = '이메일';
}

$login = array(
    'name'         => 'login',
    'id'           => 'login',
    'class'        => 'input remann-input required_field ' . ('' != form_error('login') ? 'is-error' : ''),
    'value'        => set_value('login'),
    'maxlength'    => 80,
    'size'         => 30,
    'placeholder'  => $login_label,
    'required'     => 'required',
    'autocomplete' => 'off',
    'tabindex'     => 1,
);

$password = array(
    'name'         => 'password',
    'id'           => 'password',
    'class'        => 'input remann-input required_field ' . ('' != form_error('password') ? 'is-error' : ''),
    'size'         => 30,
    'placeholder'  => '비밀번호',
    'required'     => 'required',
    'autocomplete' => 'off',
    'tabindex'     => 2,
);

$captcha = array(
    'name'         => 'captcha',
    'id'           => 'captcha',
    'maxlength'    => 8,
    'class'        => 'input remann-input required_field ' . ('' != form_error('captcha') ? 'is-error' : ''),
    'placeholder'  => '인증코드',
    'required'     => 'required',
    'autocomplete' => 'off',
    'tabindex'     => 3,
);

if (IS_MOBILE) {
    unset($login['required']);
    unset($password['required']);
    unset($captcha['required']);
}
?>

<main class="login-main">
    <div class="login-shell">
        <section class="login-hero">
            <div>
                <div class="hero-badge">WELCOME BACK</div>
                <h1 class="hero-title">로그인하고<br>매입 서비스를 이어가세요</h1>
                <p class="hero-desc">
                    신청 내역 확인, 매입 진행 상태 조회, 수거 일정 관리까지
                    한 번의 로그인으로 편리하게 이용할 수 있습니다.
                </p>

                <div class="hero-points">
                    <div class="hero-point">
                        <div class="hero-point-icon">1</div>
                        <div>
                            <strong>빠른 신청 관리</strong>
                            <span>이전에 등록한 기기와 신청 내역을 손쉽게 확인할 수 있습니다.</span>
                        </div>
                    </div>
                    <div class="hero-point">
                        <div class="hero-point-icon">2</div>
                        <div>
                            <strong>실시간 진행 확인</strong>
                            <span>수거, 검수, 정산까지 현재 상태를 한 화면에서 확인합니다.</span>
                        </div>
                    </div>
                    <div class="hero-point">
                        <div class="hero-point-icon">3</div>
                        <div>
                            <strong>안전한 계정 인증</strong>
                            <span>이메일 로그인과 인증코드 입력으로 보다 안전하게 보호됩니다.</span>
                        </div>
                    </div>
                </div>
            </div>

            <div style="font-size:13px; color:rgba(255,255,255,0.78); line-height:1.7;">
                도움이 필요하시면 고객센터를 통해 빠르게 안내해드리겠습니다.
            </div>
        </section>

        <section class="login-card">
            <div class="login-card-top">
                <div class="login-kicker">ACCOUNT LOGIN</div>
                <h2 class="login-title">로그인</h2>
                <p class="login-subtitle">
                    간편 로그인 또는 이메일 로그인으로 서비스를 이용하세요.
                </p>
            </div>

            <script>
            $(document).ready(function() {
                $('#kakaoLoginBtnStart').css('cursor', 'pointer');
                $('#kakaoLoginBtnStart').on('click', function() {
                    var rpath_encode = $(this).data('rpath');
                    kakaoLogin(rpath_encode);
                });
            });

            function kakaoLogin(rpath_encode) {
                location.href = '/sns/kakaoAuth/' + rpath_encode;
            }
            </script>

            <div class="social-login-wrap" style="<?php echo $hide_by_admin ?>">
                <img
                    src="<?php echo IMG_DIR ?>/common/kakao_login_large_wide.png"
                    alt="카카오 로그인"
                    id="kakaoLoginBtnStart"
                    class="kakao-login-image"
                    data-rpath="<?php echo $rpath_encode ?>"
                />
            </div>

            <div class="login-entry-actions" style="<?php echo $hide_by_admin ?>">
    <div id="btn_email_login" style="<?php echo ('' != $login_id || 'admin' == $rpath_admin) ? 'display:none;' : 'display:block;'; ?>">
        <button type="button" class="email-login-trigger">
            이메일로 로그인하기
        </button>
    </div>

    <?php if (!empty($partner_manager_login_url)) { ?>
        <div class="manager-login-shortcut" style="<?php echo ('' != $login_id || 'admin' == $rpath_admin) ? 'display:none;' : 'display:block;'; ?>">
            <a href="<?php echo $partner_manager_login_url; ?>" class="manager-login-trigger">매니저 로그인</a>
        </div>
    <?php } ?>
</div>

<div
    id="auth_login_wrap"
                class="auth-panel <?php echo ('' != $login_id || 'admin' == $rpath_admin) ? 'is-open' : ''; ?>"
                style="<?php echo ('' != $login_id || 'admin' == $rpath_admin) ? 'display:block;' : 'display:none;'; ?>"
            >
                <div class="auth-panel-header">
                    <h3 class="auth-panel-title">이메일 로그인</h3>
                    <p class="auth-panel-desc">가입하신 계정 정보로 로그인해주세요.</p>
                </div>

                <?php echo form_open($this->uri->uri_string()); ?>
                    <fieldset style="border:0; padding:0; margin:0;">
                        <legend class="screen_out">로그인 입력폼</legend>

                        <div class="form-group">
                            <label class="form-label" for="<?php echo $login['id']; ?>"><?php echo $login_label; ?></label>
                            <?php echo form_input($login); ?>
                            <div class="err_color_red">
                                <?php echo isset($errors[$login['name']]) ? $errors[$login['name']] : ''; ?>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="<?php echo $password['id']; ?>">비밀번호</label>
                            <?php echo form_password($password); ?>
                            <div class="err_color_red">
                                <?php echo form_error($password['name']); ?>
                                <?php echo isset($errors[$password['name']]) ? $errors[$password['name']] : ''; ?>
                            </div>
                        </div>

                        <?php if ($show_captcha) { ?>
                            <?php if ($use_recaptcha) { ?>
                                <div class="form-group">
                                    <div class="captcha-box">
                                        <div id="recaptcha_image"></div>
                                        <div style="margin-top:10px; font-size:13px;">
                                            <a href="javascript:Recaptcha.reload()">새 CAPTCHA 보기</a><br>
                                            <div class="recaptcha_only_if_image">
                                                <a href="javascript:Recaptcha.switch_type('audio')">음성 CAPTCHA로 전환</a>
                                            </div>
                                            <div class="recaptcha_only_if_audio">
                                                <a href="javascript:Recaptcha.switch_type('image')">이미지 CAPTCHA로 전환</a>
                                            </div>
                                        </div>
                                        <div style="margin-top:12px;">
                                            <input type="text" id="recaptcha_response_field" name="recaptcha_response_field" class="input remann-input" />
                                        </div>
                                        <div class="err_color_red"><?php echo form_error('recaptcha_response_field'); ?></div>
                                        <?php echo $recaptcha_html; ?>
                                    </div>
                                </div>
                            <?php } else { ?>
                                <div class="form-group">
                                    <label class="form-label" for="<?php echo $captcha['id']; ?>">인증코드</label>
                                    <div class="captcha-box">
                                        <?php echo form_input($captcha); ?>

                                        <div id="btn_renew_code" class="captcha-image-wrap" title="이미지를 클릭하시면 인증코드가 새로고침됩니다.">
                                            <span id="span_captcha_html"><?php echo $captcha_html; ?></span>
                                        </div>
                                        <div class="captcha-guide">이미지를 클릭하면 인증코드가 새로고침됩니다.</div>
                                    </div>
                                    <div class="err_color_red">
                                        <?php echo form_error($captcha['name']); ?>
                                        <?php echo isset($errors[$captcha['name']]) ? $errors[$captcha['name']] : ''; ?>
                                    </div>
                                </div>
                            <?php } ?>
                        <?php } ?>

                        <div class="form-group" style="margin-top:22px;">
                            <?php echo form_submit('submit', '로그인', 'id="btn_submit" class="login-submit-btn" tabindex="4"'); ?>
                        </div>

                        <div class="login-links">
                            <?php echo anchor('/auth/forgot_password/', '비밀번호 찾기', 'class="login-links-right"'); ?>
                        </div>
                    </fieldset>
                <?php echo form_close(); ?>

                <div class="login-note">
                    로그인에 문제가 있으신 경우, 입력하신 이메일 또는 비밀번호를 다시 확인해주세요.
                </div>
            </div>
        </section>
    </div>
</main>

<script>
$(document).ready(function(){
    $('#btn_email_login').on('click', function(){
        $(this).hide();
        $('.manager-login-shortcut').hide();
        $('#auth_login_wrap').fadeIn(180).addClass('is-open');
    });

    $('#btn_renew_code').on('click', function(){
        // 기존 캡차 갱신 스크립트가 있으면 그대로 연결
        // 또는 location.reload(); 방식으로 교체 가능
    });
});
</script>
