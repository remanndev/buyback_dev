<style>
.page_title strong {
    font-family: 'Nanum Gothic','NanumGothic','나눔고딕','나눔 고딕', 'Noto Sans KR', AppleSDGothicNeo-Regular,'맑은 고딕','Malgun Gothic',dotum,'돋움',sans-serif;
    font-size: 34px;
    font-weight: 800;
    font-stretch: normal;
    font-style: normal;
    line-height: 0.85;
    letter-spacing: normal;
    text-align: left;
    color: #353535;
}
</style>
<div class="ctnt_wrap py_35">
	<div class="ctnt_inside">
		<div class="contents_wrap">
			<div style="width: 100%; max-width: 980px;">

				<h3 class="page_title">
					<strong><?php echo $row->title; ?></strong>
				</h3>
				<hr />

				<?php echo $row->content_top; ?>
				<!-- <hr /> -->

				<?php echo form_open($this->uri->uri_string(), array('id'=>'form','name'=>'form', 'onsubmit'=>'return frmchk();')); ?>
					<input type="hidden" name="submit_code" value="npo" />

					<?php echo validation_errors('<div class="err_color_red mb-1">', '</div>'); ?>

					<div class="tbl_frm">

						<table>
						<colgroup>
						  <col width="130">
						  <col>
						</colgroup>
					    <?php
						foreach($arr_fld_nm as $i => $o) {
						  $no = $i + 1;
						  if(trim($arr_fld_nm[$i]) == '') {
							continue;
						  }
					    ?>
						<tr>
							<th><?php echo $arr_fld_nm[$i] ?></th>
							<td>
								<?php if($arr_fld_type[$i] == 'textarea') { ?>
								<textarea id="txtfld_<?php echo $no ?>" class="o_input" name="txtfld_<?php echo $no ?>" style="width: 100%; height: 150px;"><?php echo set_value('txtfld_'.$no) ?></textarea>
								<?php } else { ?>
								<input type="text" id="txtfld_<?php echo $no ?>" class="o_input w_100" name="txtfld_<?php echo $no ?>" value="<?php echo set_value('txtfld_'.$no) ?>" style="width:300px; " />
								<?php } ?>
								<?php echo form_error('txtfld_'.$no,'<div class="err_color_red">','</div>'); ?>
							</td>
						</tr>
						<?php 
						}
						?>

						<tr>
							<th>개인정보 수집 및 이용 동의</th>
							<td>
								<?php echo $row->agree_term; ?>
								<div>
									<label for="agree">
										<input id="agree" type="checkbox" name="agree" value="agree" /> 개인정보의 수집 및 이용에 동의합니다. 
										<?php echo form_error('agree','<div class="err_color_red">','</div>'); ?>
									</label>
								</div>
							</td>
						</tr>

						</table>
					</div>

					<div class="buttonBox" style="width:100%; margin:50px auto 30px; text-align:center;">
						<button type="submit" name="submit" id="btn_submit" class="btn btn-dark btn-md" style="margin:0 auto;"/>확인</button>
					</div>


				<?php echo form_close(); ?>

				<script>
					function frmchk() {
						if( confirm('<?php echo $row->title; ?> 접수를 하시겠습니까?') ) {
							return true;
						}
						else {
							return false;
						}
					}
				</script>

				<!-- <hr /> -->

				<?php echo $row->content_bottom; ?>

			</div>
		</div>
	</div>
</div>