<div class=" admin_wrap">

	<h1>랜딩 페이지 관리</h1>

	<?php echo form_open($this->uri->uri_string(), array('id'=>'form','name'=>'form')); ?>

		<input type="hidden" name="idx" value="<?php echo isset($idx) ? $idx : '';?>" />

		<?php echo validation_errors('<div class="err_color_red">', '</div>'); ?>

		<h2>랜딩 페이지 <?php echo ($idx) ? '수정' : '등록' ?></h2>

		<div class="tbl_landing_frm">
			<table>
			<colgroup>
			  <col width="130">
			  <col>
			</colgroup>
			<tr>
				<th>페이지 제목</th>
				<td>
					<input type="text" id="title" class="o_input w_100" name="title" value="<?php echo set_value('title', isset($row->title) ? $row->title : '') ?>" style="width:200px; " />
					<?php echo form_error('title','<div class="err_color_red">','</div>'); ?>
				</td>
			</tr>
			<tr>
				<th>페이지 코드</th>
				<td>
					<input type="text" id="code" class="o_input w_100" name="code" value="<?php echo set_value('code', isset($row->code) ? $row->code : '') ?>" style="width:200px; " />
					<?php echo form_error('code','<div class="err_color_red">','</div>'); ?>
				</td>
			</tr>
			<tr>
				<th>사용여부</th>
				<td>
					<input type="radio" id="use_Y" name="use_yn" value="Y"  <?php echo set_radio('use_yn', 'Y', (! isset($row->use_yn) OR (isset($row->use_yn) && 'Y' == $row->use_yn)) ? TRUE : FALSE); ?>> <label for="use_Y">사용</label>
					<input type="radio" id="use_N" name="use_yn" value="N"  <?php echo set_radio('use_yn', 'N', (isset($row->use_yn) && 'N' == $row->use_yn) ? TRUE : FALSE); ?>> <label for="use_N">사용 안함</label>
					<?php echo form_error('use_yn','<div class="err_color_red">','</div>'); ?>
				</td>
			</tr>
			<tr>
				<th>사용기간</th>
				<td>
					<input type="text" id="sdate" name="sdate" class="datepicker o_input inline-block" maxlength="10" value="<?php echo (! isset($row->sdate) || '0000-00-00' == $row->sdate) ? '' : $row->sdate ?>" style="width:120px; text-align:center; font-family:verdana; font-size:14px;" autocomplete="off" placeholder="시작 일자" />
					 ~ 
					<input type="text" id="edate" name="edate" class="datepicker o_input inline-block" maxlength="10" value="<?php echo (! isset($row->edate) || '0000-00-00' == $row->edate) ? '' : $row->edate ?>" style="width:120px; text-align:center; font-family:verdana; font-size:14px;" autocomplete="off" placeholder="종료 일자" />
				</td>
			</tr>

			<tr>
				<th>랜딩페이지 상단 내용</th>
				<td>
					<?php echo form_error('content_top', '<div class="err_color_red">','</div>'); ?>
					<textarea id="content_top" name="content_top" class="page_content o_input" ><?php echo set_value('content_top', isset($row->content_top) ? $row->content_top : '') ; ?></textarea>
				</td>
			</tr>

			<tr>
				<th>랜딩페이지 접수항목</th>
				<td>

					<style>
					.landing_fld {}
					.landing_fld > li { display:flex; border-bottom: 1px dashed #ccc; font-size: 15px; }
					.landing_fld > li > div { margin-right: 30px; }
					.landing_fld > li .fld_nm { width: 200px; }
					.landing_fld > li .fld_chk { width: 140px; }
					.landing_fld > li .fld_type { width: 200px; }
					.landing_fld > li .fld_desc { width: 400px; }

					.form-check-input:checked {
						background-color: #e60000;
						border-color: #e60000;
					}
					</style>
				  <ul class="landing_fld">
					<li> 
						<div class="fld_nm"><strong>항목명</strong></div>
						<div class="fld_chk"><strong>필수 여부</strong></div>
						<div class="fld_type"><strong>입력 형식</strong></div>
						<div class="fld_desc"><strong>입력 내용(예시)</strong></div>
					</li>

				  <?php
					//foreach($arr_fld_nm as $i => $o) {
					//  $no = $i + 1;
					for($i=0;$i<10;$i++) {
						$no = $i + 1;
				  ?>
					<li> 
						<div class="fld_nm">
							<input type="text" id="fld_nm_<?php echo $no ?>" class="o_input fld_nm <?php echo (isset($arr_fld_chk[$i]) && $arr_fld_chk[$i]) ? 'req_fld' : '' ?>" name="fld_nm_<?php echo $no ?>" value="<?php echo set_value('fld_nm_'.$no, isset($arr_fld_nm[$i]) ? $arr_fld_nm[$i] : '') ?>" autocomplete="off" />
						</div>

						<div class="fld_chk form-check form-switch">
						  <input class="form-check-input" type="checkbox" id="fld_chk_<?php echo $no ?>" name="fld_chk_<?php echo $no ?>" value="1" <?php echo set_checkbox('fld_chk_'.$no, '1', (isset($arr_fld_chk[$i]) && $arr_fld_chk[$i]) ? TRUE : '' ); ?> />
						  <label class="form-check-label" for="fld_chk_<?php echo $no ?>">필수 체크</label>
						</div>

						<div class="fld_type btn-group text-center" role="group" aria-label="Basic radio toggle button group">
						  <input type="radio" class="btn-check" name="fld_type_<?php echo $no ?>" id="fld_type_input_text_<?php echo $no ?>" <?php echo set_radio('fld_type_'.$no, 'input:text', (isset($arr_fld_type[$i]) && $arr_fld_type[$i] == 'input:text') ? TRUE : ''); ?> value="input:text">
						  <label class="btn btn-outline-primary btn-xs" for="fld_type_input_text_<?php echo $no ?>">단문</label>
						  <input type="radio" class="btn-check" name="fld_type_<?php echo $no ?>" id="fld_type_textarea_<?php echo $no ?>" <?php echo set_radio('fld_type_'.$no, 'textarea', (isset($arr_fld_type[$i]) && $arr_fld_type[$i] == 'textarea') ? TRUE : ''); ?> value="textarea">
						  <label class="btn btn-outline-primary btn-xs" for="fld_type_textarea_<?php echo $no ?>">장문</label>
						</div>

						<div class="fld_desc">
							<input type="text" id="fld_desc_<?php echo $no ?>" class="o_input fld_desc <?php echo (isset($arr_fld_chk[$i]) && $arr_fld_chk[$i]) ? 'req_fld' : '' ?>" name="fld_desc_<?php echo $no ?>" value="<?php echo set_value('fld_desc_'.$no, isset($arr_fld_desc[$i]) ? $arr_fld_desc[$i] : '') ?>" autocomplete="off" />
						</div>

					</li>

				  <?php } ?>
				  </ul>

				</td>
			</tr>

			<tr>
				<th>파일 첨부 수량</th>
				<td>
				<?php
					$file_cnt = isset($row->file_cnt) ? $row->file_cnt : 0;
				?>
				  <select id="file_cnt" name="file_cnt">
				    <option value="0" <?php echo($file_cnt == 0) ? 'selected' : ''; ?>>0</option>
					<option value="1" <?php echo($file_cnt == 1) ? 'selected' : ''; ?>>1</option>
					<option value="2" <?php echo($file_cnt == 2) ? 'selected' : ''; ?>>2</option>
					<option value="3" <?php echo($file_cnt == 3) ? 'selected' : ''; ?>>3</option>
					<option value="4" <?php echo($file_cnt == 4) ? 'selected' : ''; ?>>4</option>
					<option value="5" <?php echo($file_cnt == 5) ? 'selected' : ''; ?>>5</option>
				  </select>
				</td>
			</tr>
			<tr>
				<th>파일 첨부 상세</th>
				<td>
					<style>
					.landing_file {}
					.landing_file > li { display:flex; border-bottom: 1px dashed #ccc; padding: 3px 0; font-size: 15px; }
					.landing_file > li > div { margin-right: 30px; text-align:left;}
					.landing_file > li .file_ttl { width: 200px; }
					.landing_file > li .file_desc { width: calc(100% - 200px); }
					.landing_file > li .file_ttl input,
					.landing_file > li .file_desc textarea { width: 100%; font-size: 13px; }

					.form-check-input:checked {
						background-color: #e60000;
						border-color: #e60000;
					}
					</style>

				  <ul class="landing_file">
					<li> 
						<div class="file_ttl"><strong>파일 타이틀</strong></div>
						<div class="file_desc"><strong>파일 설명</strong></div>
					</li>
				  <?php
					//$file_cnt = isset($row->file_cnt) ? $row->file_cnt : 0;
					$file_disabled = 'disabled';
					for($i=0;$i<5;$i++) {
						$no = $i + 1;

						if($no <= $file_cnt) {
							$file_disabled = '';
						}
						else {
							$file_disabled = 'disabled';
						}

				  ?>
					<li class="file_desc_cnt"> 
						<div class="file_ttl">
							<input type="text" id="file_ttl_<?php echo $no ?>" class="o_input file_desc_cnt_<?php echo $no ?>" name="file_ttl_<?php echo $no ?>" value="<?php echo set_value('file_ttl_'.$no, isset($arr_file_ttl[$i]) ? $arr_file_ttl[$i] : '') ?>" autocomplete="off" <?php echo $file_disabled ?> />
						</div>
						<div class="file_desc">
							<!-- <input type="text" id="file_desc_<?php echo $no ?>" class="o_input file_desc_cnt_<?php echo $no ?>" name="file_desc_<?php echo $no ?>" value="<?php echo set_value('file_desc_'.$no, isset($arr_file_desc[$i]) ? $arr_file_desc[$i] : '') ?>" autocomplete="off" <?php echo $file_disabled ?> /> -->

							<textarea id="file_desc_<?php echo $no ?>" class="file_desc_cnt_<?php echo $no ?>" style=" height: 80px;" name="file_desc_<?php echo $no ?>" <?php echo $file_disabled ?>><?php echo set_value('file_desc_'.$no, isset($arr_file_desc[$i]) ? $arr_file_desc[$i] : '') ?></textarea>
						</div>

					</li>
				  <?php 
				  }
				  ?>
				  </ul>
				</td>
			</tr>

			<tr>
				<th>개인정보 수집 및 이용안내</th>
				<td><!-- 참고 : https://www.onepage.biz/business/#menu-02  -->
					<?php echo form_error('agree_term', '<div class="err_color_red">','</div>'); ?>
					<textarea id="agree_term" name="agree_term" class="page_content o_input" ><?php echo set_value('agree_term', isset($row->agree_term) ? $row->agree_term : '') ; ?></textarea>
				</td>
			</tr>

			<tr>
				<th>랜딩페이지 하단 내용</th>
				<td>
					<?php echo form_error('content_bottom', '<div class="err_color_red">','</div>'); ?>
					<textarea id="content_bottom" name="content_bottom" class="page_content o_input" ><?php echo set_value('content_bottom', isset($row->content_bottom) ? $row->content_bottom : '') ; ?></textarea>
				</td>
			</tr>
			
			</table>
		</div>

		
		<div class="buttonBox" style="width:100%; margin:50px auto 30px; text-align:center;">
			<hr style="margin-bottom:50px; " />
			<input type="submit" name="submit" id="btn_submit" class="btn btn-dark btn-sm" value="확인" style="margin:0 auto;"/>
			<a href="<?php echo base_url() ?>admin/contents/landing/lists" class="btn btn-dark btn-sm">목록</a>
			<?php if( isset($row->idx) ) { ?>
			<a href="javascript:post_send('admin/contents/landing/delete', {idx:'<?php echo $row->idx;?>'}, true);" class="btn btn-danger btn-sm">삭제</a>
			<?php } ?>
		</div>


	<?php echo form_close(); ?>

</div>

<script type="text/javascript">
$(function(){
	$R('.page_content ', { 
		focus: true,
		lang: 'ko',
		minHeight: '300px',
		//maxHeight: '1000px',
		plugins: ['fontsize','fontcolor','filemanager','video','table','alignment','inlinestyle','specialchars','textdirection','widget','fontfamily','fullscreen'],
		imageUpload: "/files/upload/redactor_image/<?php echo url_code('page/image','e') ?>/page",
		imagePosition: true,
		fileUpload: "/files/upload/redactor_file/<?php echo url_code('page/file','e') ?>/page",

		buttonsAddAfter: {
			after: 'deleted',
			buttons: ['underline','line', 'redo', 'undo', 'underline', 'ol', 'ul', 'sup', 'sub']
		},
		buttonsHide: ['lists']

	});
});
</script>




<link rel="stylesheet" type="text/css" href="/assets/lib/datetimepicker-master/jquery.datetimepicker.min.css" media="screen"/>
<script src="/assets/lib/datetimepicker-master/jquery.datetimepicker.full.js"></script>
<script type="text/javascript">
// datetimepicker
$.datetimepicker.setLocale('kr');
/*
$('.datetimepicker').datetimepicker({
	lang:'kr',
	datepicker:false,
	timepicker:false,
	format:'Y-m-d',
	formatDate:'Y/m/d',
	yearStart:'<?php echo date("Y") -1 ?>',
	yearEnd:'<?php echo date("Y") +10 ?>'
});
*/

$('.datepicker').datetimepicker({
	lang:'kr',
	format:'Y-m-d',
	timepicker:false,
	//format:'Y-m-d',
	yearStart:'<?php echo date("Y") -1 ?>',
	yearEnd:'<?php echo date("Y") +10 ?>'
});
</script>


<script type="text/javascript">
$(function(){

	$('.fld_nm').each(function(){
		if($(this).val() != '') {
			$(this).removeClass('empty_fld');
		}
	});

	$('.fld_nm').on('focus',function(){
		$(this).removeClass('empty_fld');
	});
	$('.fld_nm').on('blur',function(){
		if($(this).val() == '') {
			$(this).addClass('empty_fld');
		}
	});

	// 파일 수량 변경시
	$('#file_cnt').on('change', function() {
		let file_cnt = $(this).val();
		//console.log( file_cnt );
		let no = 0;
		$('.file_desc_cnt').each(function(){
			no++;
			//console.log(no +' <= ' + file_cnt);
			if(no <= file_cnt) {
				$('.file_desc_cnt_'+no).attr('disabled',false);
			}
			else {
				$('.file_desc_cnt_'+no).attr('disabled',true);
			}
		});
	});

});
</script>