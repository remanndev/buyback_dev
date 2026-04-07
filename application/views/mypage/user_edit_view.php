<?php
/* - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
* 회원 가입 결과 페이지 주소
* /application/views/auth/message_succ_join.php
*/

/*
$email = array(
	'name'	=> 'email',
	'id'	=> 'email',
	'value' => isset($user->email) ? $user->email : set_value('email'),
	'maxlength'	=> 80,
	'class'	=> 'form-style big gray-version no-shadow form-style-with-icon section-shadow-blue reg_required',
	'style' => 'background-color:#eeeeee;',
	'placeholder' => '이메일',
	'autocomplete' => 'off',
	'readonly' => true,
	'disabled' => true
);

*/

$password = array(
	'name'	=> 'password',
	'id'	=> 'password',
	'value' => set_value('password'),
	'maxlength'	=> $this->config->item('password_max_length', 'tank_auth'),
	'class'	=> 'form-style big gray-version no-shadow form-style-with-icon section-shadow-blue reg_required',
	'placeholder' => '비밀번호',
	'autocomplete' => 'off'
);
$password_confirm = array(
	'name'	=> 'password_confirm',
	'id'	=> 'password_confirm',
	'value' => set_value('password_confirm'),
	'maxlength'	=> $this->config->item('password_max_length', 'tank_auth'),
	'class'	=> 'form-style big gray-version no-shadow form-style-with-icon section-shadow-blue reg_required',
	'placeholder' => '비밀번호 확인',
	'autocomplete' => 'off'
);
$captcha = array(
	'name'	=> 'captcha',
	'id'	=> 'captcha',
	'maxlength'	=> 8,
	'style' => 'width:100px; padding:10px 9px;  border: 1px solid #999999; '
);
// 전화번호
$phone = array(
	'name'	=> 'phone',
	'id'	=> 'phone',
	'value' => isset($upro->phone) ? $upro->phone : set_value('phone'),
	'maxlength'	=> 80,
	'class'	=> 'form-style big gray-version no-shadow form-style-with-icon section-shadow-blue',
	'placeholder' => '전화번호',
	'autocomplete' => 'off'
);



// 업체명(선택)
$company = array(
	'name'	=> 'company',
	'id'	=> 'company',
	'value' => isset($upro->company) ? $upro->company : set_value('company'),
	'maxlength'	=> 80,
	'class'	=> 'form-style big gray-version no-shadow form-style-with-icon section-shadow-blue',
	'placeholder' => '업체명(선택)',
	'autocomplete' => 'off'
);

// 단체 소개(선택)
$company_info = array(
	'name'	=> 'company_info',
	'id'	=> 'company_info',
	'value' => isset($upro->company_info) ? $upro->company_info : set_value('company_info'),
	'class'	=> 'form-style big gray-version no-shadow form-style-with-icon section-shadow-blue',
	'style'	=> 'width: 100%; height: 300px;',
	'placeholder' => '단체 소개',
	'autocomplete' => 'off'
);
// 홈페이지(선택)
$website = array(
	'name'	=> 'website',
	'id'	=> 'website',
	'value' => isset($upro->website) ? $upro->website : set_value('website'),
	'maxlength'	=> 200,
	'class'	=> 'form-style big gray-version no-shadow form-style-with-icon section-shadow-blue',
	'placeholder' => '홈페이지(선택)',
	'autocomplete' => 'off',
	'style' => ' width: 100%; border:1px solid rgba(0,0,0,.075); '
);


?>




	<!-- 모바일 -->
	<?php $this->load->view('mypage/mypage_side_mobile_view'); ?>
	<!-- <div class="m_slide_nav d-block d-md-none">
		<div class="m_slide_nav_wrap">
			<div class="m_list_nav">
				<ul>
					<li><span><a href="/mypage/donation/lists">나의 기부 물품 현황</a></span></li>
					<li><span><a href="/mypage/user/edit/">정보수정</a></span></li>
					<?php if( isset($this->user->level) && $this->user->level > 10 ) { ?>
					<li><span><a href="/mypage/campaign/lists">캠페인 관리</a></span></li>
					<li><span><a href="/mypage/campaign/write">캠페인 만들기</a></span></li>
					<?php } ?>
				</ul>
			</div>
		</div>
	</div> -->

	<div class="ctnt_wrap">
		<div class="ctnt_inside">
			<div class="row py_35">
				<div class="d-none d-lg-block col-lg-3">
					<!-- 마이페이지 사이드 메뉴 -->
					<?php $this->load->view('mypage/mypage_side_view'); ?>
				</div>
				<div class="col-12 col-lg-9">

						<h2 class="mb_20" style="color:#353535;">정보 수정</h2>
								
								<!-- 내정보수정 -->
								<?php echo form_open($this->uri->uri_string()); ?>

									<!-- <div class="tbl_purple mt_5"> -->
									<div class="tbl_frm">
										<table id="dsp_user_table" style="width:100%;">
											<colgroup>
												<col width="120">
												<col>
											</colgroup>
											<?php if($user->level === '20') { ?>
											<tr>
												<th>구분</th>
												<td>NPO 회원</td>
											</tr>
											<?php } ?>

											<!-- <tr>
												<th>아이디</th>
												<td><?php //echo $user->username; ?></td>
											</tr> -->
											<tr>
												<th>이름</th>
												<td><?php echo $user->nickname; ?></td>
											</tr>
											<tr>
												<th>이메일</th>
												<td><?php echo $user->email; ?></td>
											</tr>

											<tr>
												<th>비밀번호</th>
												<td>
													<?php echo form_password($password); ?>
													<?php echo form_error($password['name']); ?>
													<?php echo isset($errors[$password['name']])?'<div class="error2">'.$errors[$password['name']].'</div>':''; ?>
												</td>
											</tr>
											<tr>
												<th>비밀번호 확인</th>
												<td>
													<?php echo form_password($password_confirm); ?>
													<?php echo form_error($password_confirm['name']); ?>
													<?php echo isset($errors[$password_confirm['name']])?'<div class="error2">'.$errors[$password_confirm['name']].'</div>':''; ?>
												</td>
											</tr>
										</table>
									</div>



									<?php if($user->level === '20') { ?>
									<div class="tbl_frm mt-3">

										<table id="dsp_npo_table" class="" style="width:100%;">
											<colgroup>
												<col width="120">
												<col>
											</colgroup>
											<tr>
												<th>단체명</th>
												<td>
													<?php echo form_input($company); ?>
													<?php echo form_error($company['name']); ?>
													<?php echo isset($errors[$company['name']])?'<div class="error2">'.$errors[$company['name']].'</div>':''; ?>
												</td>
											</tr>
											<tr>
												<th>단체 소개</th>
												<td>
													<?php echo form_textarea($company_info); ?>
													<?php echo form_error($company_info['name']); ?>
													<?php echo isset($errors[$company_info['name']])?'<div class="error2">'.$errors[$company_info['name']].'</div>':''; ?>
												</td>
											</tr>
											<tr>
												<th>홈페이지</th>
												<td>
													<?php echo form_input($website); ?>
													<?php echo form_error($website['name']); ?>
													<?php echo isset($errors[$website['name']])?'<div class="error2">'.$errors[$website['name']].'</div>':''; ?>
												</td>
											</tr>
										</table>
									
									</div>
									<?php } ?>




									<div class="mt-5 mb-3 text-center">
										<input type="submit" name="submit" value="수정하기" id="btn_edit" class="btn btn-dark btn-md" style="font-weight:bold;" />
									</div>

									<input type="hidden" id="password_min_length" value="<?php echo $this->config->item('password_min_length', 'tank_auth') ?>" />

									<input type="hidden" id="requestnumber" name="requestnumber" value="<?php echo set_value('requestnumber', (isset($requestnumber) ? $requestnumber : '' )); ?>" />
									<input type="hidden" id="succ_nice" name="succ_nice" value="<?php echo set_value('succ_nice', (isset($succ_nice) ? $succ_nice : '' )); ?>" />
									<input type="hidden" id="dupinfo" name="dupinfo" value="<?php echo set_value('dupinfo') ?>" /> 
									<input type="hidden" id="birth" name="birth" value="<?php echo set_value('birthdate') ?>" /> 
									<input type="hidden" id="mobile" name="mobile" value="<?php echo set_value('mobile') ?>" /> 
									<input type="hidden" id="gender" name="gender" value="<?php echo set_value('gender') ?>" />

								<?php echo form_close(); ?>

				</div>
			</div>
		</div>
	</div>






<!-- JAVASCRIPT
================================================== -->

<script type="text/javascript">
	$R('#company_info', { 
		//focus: true,
		//toolbarExternal: '#my-external-toolbar',
		lang: 'ko',
		minHeight: '200px',
		maxHeight: '300px',
		buttonsHide: ['html','format','italic','lists','deleted']
	});
</script>


<script type="text/javascript">

	// 내정보수정  onsubmit 실행
	function proc_edit() {

	}

</script>
