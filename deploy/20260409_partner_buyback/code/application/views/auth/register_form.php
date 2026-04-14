<?php
if ($use_username) {
    $username = array(
        'name'         => 'username',
        'id'           => 'username',
        'class'        => 'input required_field '.('' != form_error('username') ? 'is-error' : ''),
        'value'        => form_error('username') ? '' : set_value('username'),
        'maxlength'    => $this->config->item('username_max_length', 'tank_auth'),
        'size'         => 30,
        'placeholder'  => '&#50500;&#51060;&#46356;',
        'required'     => 'required',
        'autocomplete' => 'username'
    );
}

if ($use_nickname) {
    $nickname = array(
        'name'         => 'nickname',
        'id'           => 'nickname',
        'class'        => 'input required_field '.('' != form_error('nickname') ? 'is-error' : ''),
        'value'        => form_error('nickname') ? '' : set_value('nickname'),
        'maxlength'    => $this->config->item('nickname_max_length', 'tank_auth'),
        'placeholder'  => '&#51060;&#47492;',
        'required'     => 'required',
        'autocomplete' => 'name'
    );
}

$company = array(
    'name'         => 'company',
    'id'           => 'company',
    'value'        => form_error('company') ? '' : set_value('company'),
    'maxlength'    => 100,
    'class'        => 'input '.('' != form_error('company') ? 'is-error' : ''),
    'placeholder'  => '&#49345;&#54840;/&#48277;&#51064;&#47749;',
    'autocomplete' => 'organization'
);

$email = array(
    'name'         => 'email',
    'id'           => 'email',
    'class'        => 'input required_field '.('' != form_error('email') ? 'is-error' : ''),
    'value'        => form_error('email') ? '' : set_value('email'),
    'maxlength'    => 80,
    'size'         => 30,
    'placeholder'  => '&#51060;&#47700;&#51068;',
    'required'     => 'required',
    'autocomplete' => 'email'
);

$phone = array(
    'name'         => 'phone',
    'id'           => 'phone',
    'class'        => 'input required_field '.('' != form_error('phone') ? 'is-error' : ''),
    'value'        => form_error('phone') ? '' : set_value('phone'),
    'maxlength'    => 20,
    'placeholder'  => '&#50672;&#46973;&#52376;',
    'required'     => 'required',
    'autocomplete' => 'tel'
);

$password = array(
    'name'         => 'password',
    'type'         => 'password',
    'id'           => 'password',
    'class'        => 'input required_field '.('' != form_error('password') ? 'is-error' : ''),
    'maxlength'    => $this->config->item('password_max_length', 'tank_auth'),
    'size'         => 30,
    'placeholder'  => '&#48708;&#48128;&#48264;&#54840;',
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
    'placeholder'  => '&#48708;&#48128;&#48264;&#54840; &#54869;&#51064;',
    'required'     => 'required',
    'autocomplete' => 'new-password'
);

$captcha = array(
    'name'         => 'captcha',
    'id'           => 'captcha',
    'maxlength'    => 8,
    'class'        => 'input required_field '.('' != form_error('captcha') ? 'is-error' : ''),
    'placeholder'  => '&#51064;&#51613;&#53076;&#46300;',
    'required'     => 'required',
    'autocomplete' => 'off'
);

if (IS_MOBILE) {
    if ($use_username) unset($username['required']);
    if ($use_nickname) unset($nickname['required']);
    unset($email['required']);
    unset($phone['required']);
    unset($password['required']);
    unset($confirm_password['required']);
    unset($captcha['required']);
}
?>

<main class="page-main">
    <div class="auth-shell">
        <div class="card auth-card">
            <div class="auth-kicker">SIGN UP</div>
            <h2 class="auth-title">&#54924;&#50896; &#44032;&#51077;</h2>
            <p class="auth-subtitle">
                &#44592;&#48376; &#51221;&#48372;&#47484; &#51077;&#47141;&#54644; &#44228;&#51221;&#51012; &#49373;&#49457;&#54644; &#51452;&#49464;&#50836;.
            </p>

            <?php echo form_open($this->uri->uri_string(), 'class="auth-form"'); ?>
                <input type="hidden" name="group_fk" id="group_fk" value="<?php echo set_value('group_fk', 10); ?>" />

                <fieldset>
                    <legend class="screen_out">Register Form</legend>

                    <?php if ($use_username) { ?>
                        <div class="form-group">
                            <label class="form-label" for="<?php echo $username['id']; ?>">&#50500;&#51060;&#46356;</label>
                            <?php echo form_input($username); ?>
                            <div class="form-error">
                                <?php echo form_error($username['name']); ?>
                                <?php echo isset($errors[$username['name']]) ? $errors[$username['name']] : ''; ?>
                            </div>
                        </div>
                    <?php } ?>

                    <?php if ($use_nickname) { ?>
                        <div class="form-group">
                            <label class="form-label" for="<?php echo $nickname['id']; ?>">&#51060;&#47492;</label>
                            <?php echo form_input($nickname); ?>
                            <div class="form-error">
                                <?php echo form_error($nickname['name']); ?>
                                <?php echo isset($errors[$nickname['name']]) ? $errors[$nickname['name']] : ''; ?>
                            </div>
                        </div>
                    <?php } ?>

                    <div class="form-group">
                        <label class="form-label" for="<?php echo $email['id']; ?>">&#51060;&#47700;&#51068;</label>
                        <?php echo form_input($email); ?>
                        <div class="form-error">
                            <?php echo form_error($email['name']); ?>
                            <?php echo isset($errors[$email['name']]) ? $errors[$email['name']] : ''; ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="<?php echo $phone['id']; ?>">&#50672;&#46973;&#52376;</label>
                        <?php echo form_input($phone); ?>
                        <div class="form-error">
                            <?php echo form_error($phone['name']); ?>
                            <?php echo isset($errors[$phone['name']]) ? $errors[$phone['name']] : ''; ?>
                        </div>
                        <div class="form-help">
                            &#49707;&#51088;&#47564; &#51077;&#47141;&#54616;&#44144;&#45208; &#54616;&#51060;&#54548;&#51012; &#54252;&#54632;&#54644; &#51077;&#47141;&#54624; &#49688; &#51080;&#49845;&#45768;&#45796;.
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="<?php echo $password['id']; ?>">&#48708;&#48128;&#48264;&#54840;</label>
                        <?php echo form_password($password); ?>
                        <div class="form-error">
                            <?php echo form_error($password['name']); ?>
                            <?php echo isset($errors[$password['name']]) ? $errors[$password['name']] : ''; ?>
                        </div>
                        <div class="form-help">
                            &#50689;&#47928;, &#49707;&#51088;, &#53945;&#49688;&#47928;&#51088;&#47484; &#51312;&#54633;&#54616;&#47732; &#45908; &#50504;&#51204;&#54633;&#45768;&#45796;.
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="<?php echo $confirm_password['id']; ?>">&#48708;&#48128;&#48264;&#54840; &#54869;&#51064;</label>
                        <?php echo form_password($confirm_password); ?>
                        <div class="form-error">
                            <?php echo form_error($confirm_password['name']); ?>
                            <?php echo isset($errors[$confirm_password['name']]) ? $errors[$confirm_password['name']] : ''; ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="<?php echo $company['id']; ?>">&#49345;&#54840;/&#48277;&#51064;&#47749;</label>
                        <?php echo form_input($company); ?>
                        <div class="form-error">
                            <?php echo form_error($company['name']); ?>
                            <?php echo isset($errors[$company['name']]) ? $errors[$company['name']] : ''; ?>
                        </div>
                        <div class="form-help">
                            &#44060;&#51064; &#54924;&#50896;&#51060;&#47732; &#48708;&#50892;&#46160;&#49492;&#46020; &#46121;&#45768;&#45796;.
                        </div>
                    </div>

                    <?php if ($captcha_registration) { ?>
                        <?php if ($use_recaptcha) { ?>
                            <div class="form-group">
                                <div class="auth-code-box">
                                    <div id="recaptcha_image"></div>

                                    <div class="auth-links mt-12">
                                        <a href="javascript:Recaptcha.reload()">&#49352; CAPTCHA &#48372;&#44592;</a>
                                        <div class="recaptcha_only_if_image">
                                            <a href="javascript:Recaptcha.switch_type('audio')">&#51020;&#49457; CAPTCHA&#47196; &#51204;&#54872;</a>
                                        </div>
                                        <div class="recaptcha_only_if_audio">
                                            <a href="javascript:Recaptcha.switch_type('image')">&#51060;&#48120;&#51648; CAPTCHA&#47196; &#51204;&#54872;</a>
                                        </div>
                                    </div>

                                    <div class="form-group mt-16 mb-0">
                                        <label class="form-label" for="recaptcha_response_field">&#51064;&#51613;&#53076;&#46300;</label>
                                        <input type="text" id="recaptcha_response_field" name="recaptcha_response_field" class="input" />
                                        <div class="form-error"><?php echo form_error('recaptcha_response_field'); ?></div>
                                    </div>

                                    <?php echo $recaptcha_html; ?>
                                </div>
                            </div>
                        <?php } else { ?>
                            <div class="form-group">
                                <label class="form-label" for="<?php echo $captcha['id']; ?>">&#51064;&#51613;&#53076;&#46300;</label>
                                <div class="auth-code-box">
                                    <?php echo form_input($captcha); ?>

                                    <div id="btn_renew_code" class="auth-code-view" title="&#53364;&#47533;&#54616;&#49884;&#47732; &#49352;&#47196;&#50868; &#53076;&#46300;&#47196; &#44081;&#49888;&#46121;&#45768;&#45796;.">
                                        <span id="span_captcha_html" class="<?php echo ((mt_rand(1,100) % 2) < 1) ? 'gray_scale' : ''; ?>">
                                            <?php echo $captcha_html; ?>
                                        </span>
                                    </div>

                                    <div class="auth-code-help">&#51060;&#48120;&#51648;&#47484; &#53364;&#47533;&#54616;&#47732; &#51064;&#51613;&#53076;&#46300;&#44032; &#49352;&#47196;&#44256;&#52840;&#46121;&#45768;&#45796;.</div>
                                </div>

                                <div class="form-error">
                                    <?php echo form_error($captcha['name']); ?>
                                    <?php echo isset($errors[$captcha['name']]) ? $errors[$captcha['name']] : ''; ?>
                                </div>
                            </div>
                        <?php } ?>
                    <?php } ?>

                    <div class="auth-actions">
                        <?php echo form_submit('register', html_entity_decode('&#54924;&#50896;&#44032;&#51077;', ENT_QUOTES, 'UTF-8'), 'class="btn btn-primary"'); ?>
                    </div>

                    <div class="auth-links">
                        <?php echo anchor('/auth/login/', '&#47196;&#44536;&#51064; &#54168;&#51060;&#51648;&#47196; &#51060;&#46041;'); ?>
                    </div>
                </fieldset>
            <?php echo form_close(); ?>

            <div class="auth-note">
                &#44032;&#51077; &#54980; &#51064;&#51613; &#46608;&#45716; &#44288;&#47532;&#51088; &#54869;&#51064; &#51208;&#52264;&#44032; &#51652;&#54665;&#46112; &#49688; &#51080;&#49845;&#45768;&#45796;.
            </div>
        </div>
    </div>
</main>

<script type="text/javascript">
/*
    &#44592;&#51316; group_fk / &#54924;&#50896;&#50976;&#54805; &#51204;&#54872; &#49828;&#53356;&#47549;&#53944;&#44032; &#54596;&#50836;&#54616;&#47732;
    &#54788;&#51116; &#44396;&#51312;&#50640; &#47582;&#52628;&#50612; &#48324;&#46020;&#47196; &#45796;&#49884; &#48537;&#51060;&#47732; &#46121;&#45768;&#45796;.
*/
</script>
