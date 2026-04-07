<?php

// 비밃번호 설정
$input_password = array(
	'name'	=> 'password',
	'id'	=> 'password',
	'value' => '',
	'maxlength'	=> 255,
	'type' => 'password',
	'style'	=> 'width:100%;padding:3px 7px;line-height:20px;font-size:13px; vertical-align:middle;border:1px solid #e5e5e5;'
);
?>

<div style="width:<?php echo ($bbs_cf->bo_width_limit > 0) ? $bbs_cf->bo_width_limit.'px;' : '100%;' ?>   <?php echo ( $bbs_cf->bo_width_limit == '0'  && $bbs_cf->bo_width_max > 0) ? 'max-width:'.$bbs_cf->bo_width_max.'px;' : '100%;' ?>   <?php echo ('board' === $this->uri->segment(1)) ? 'margin:0 auto;' : ''; ?>">

	<div class="container">

		<?php echo form_open($this->uri->uri_string(), array('id'=>'board_form','name'=>'board_form')); ?>

			<h3 class="page-header board_name" style="border-bottom:1px solid #ddd;">
				<?php echo isset($last_loc) ? $last_loc : '게시판'; ?>
			</h3>


			<div style="margin:20px 0;">

				<div class="alert alert-warning" role="alert">
					문의글을 남기실 때 사용하셨던 비밀번호를 입력해주세요.
				</div>


				<div style="margin-top:50px;text-align:center; vertical-align:top;">

					<table class="table table_form" style="width: 300px; border-bottom:1px solid #ddd; display:inline-block; vertical-align:top;">
					<colgroup>
					  <col width="100">
					  <col>
					</colgroup>

					<?php if (! $this->tank_auth->is_logged_in()) { // logged in ?>
					<tr>
					  <th class='bg_f6f6f6 t-center'>비밀번호</th>
					  <td style="padding-right:25px; line-height:28px;">
						<?php echo form_input($input_password); ?>
						<?php echo form_error('password','<div class="error">','</div>'); ?>
					  </td>
					</tr>
					<?php } ?>
					</table>

					<input type="submit" name="submit" class="btn btn-black-flat btn-sm" style="display:inline-block;  vertical-align:top; margin-top:10px; margin-left:25px;"  value="확인" />

				</div>

			</div>


		<?php echo form_close(); ?>

	</div>

</div>
