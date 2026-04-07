<div class=" admin_wrap">

	<h1>컨텐츠 페이지 <?php echo (isset($idx) && '' != $idx) ? '수정' : '등록'; ?></h1>

	<?php echo form_open_multipart($this->uri->uri_string(), array('id'=>'form','name'=>'form')); ?>

		<input type="hidden" name="idx" value="<?php echo isset($idx) ? $idx : '';?>" />

		<?php //echo validation_errors('<div class="err_color_red">', '</div>'); ?>

		<h2>컨텐츠 페이지 <?php echo (isset($idx) && '' != $idx) ? '수정' : '등록'; ?></h2>

		<div class="tbl_frm">
			<table>
			<colgroup>
			  <col width="130">
			  <col>
			</colgroup>
			<tr>
				<th>페이지 제목</th>
				<td>
					<input type="text" id="page_title" class="o_input w_100" name="page_title" value="<?php echo set_value('page_title', isset($row->page_title) ? $row->page_title : '') ?>" style="width:200px; " />
					<?php echo form_error('page_title','<div class="err_color_red">','</div>'); ?>
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
				<th>페이지 내용</th>
				<td>
					<?php echo form_error('page_content', '<div class="err_color_red">','</div>'); ?>
					<textarea id="page_content" name="page_content" class="o_input" ><?php echo set_value('page_content', isset($row->page_content) ? $row->page_content : '') ; ?></textarea>
				</td>
			</tr>

			<tr>
				<th>대체 파일</th>
				<td>
					<input type="file" name="attach_file_form" class="o_input" style="width:100%; padding:0; border:none;" />
					<div>
						<?php if($result_file_form && $result_file_form['total_count'] > 0) { ?>
						<ul style="background-color:#ffffff; margin-top:10px; padding:10px 15px; border:1px solid #EEEEEE; list-style:none;">
						  <?php
						  foreach($result_file_form['qry'] as $i => $o) {
							//if($i == 0) continue;
						  ?>
						  <li class="file_form_<?php echo $i ?>" style="position:relative; line-height:170%; font-size:15px;">

							<?php if($i > 0) { ?>
							<hr style="border-style:dashed;" />
							<?php } ?>

							<div>
								<img src="<?php echo IMG_DIR ?>/common/icon_file.png" style="margin-right:5px; vertical-align:middle;">
								<?php echo $o->file_name_org ?> (<?php echo number_format($o->file_size) ?> KB)
								<img src="<?php echo IMG_DIR ?>/common/icon_btn_del.gif" style="cursor:pointer;" alt="삭제" title="삭제" onclick="delete_file_manager(<?php echo $o->idx ?>,'file_form_<?php echo $i ?>','<?php echo $o->file_type ?>','<?php echo $o->file_dir ?>','<?php echo $o->file_name ?>')" />
							</div>

							<?php if('image' == $o->file_type) { ?>
							<img src="<?php echo DATA_DIR ?>/<?php echo $o->file_dir ?>/<?php echo $o->file_name ?>" style="width:auto; max-width:100%;" />
							<?php } ?>

						  </li>
						  <?php } ?>
						</ul>
						<?php } ?>
					</div>
				</td>
			</tr>




																	  



			</table>
		</div>

		
		<div class="buttonBox" style="width:100%; margin:50px auto 30px; text-align:center;">
			<hr style="margin-bottom:50px; " />
			<input type="submit" name="submit" id="btn_submit" class="btn btn-dark btn-sm" value="확인" style="margin:0 auto;"/>
		</div>


	<?php echo form_close(); ?>

</div>

<script type="text/javascript">
$(function(){
	$R('#page_content', { 
		focus: true,
		lang: 'ko',
		minHeight: '500px',
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



<script type="text/javascript">
// 선택 파일 삭제
function delete_file_manager(idx,file_class,file_type,file_dir,file_name)
{
	if( confirm('삭제하시겠습니까?') )
	{

			// 삭제하려는 사람과 등록한 사람 비교 포함.
			var request = $.ajax({
			  url: "/trans/delete_file_manager/",
			  method: "POST",
			  data: { 'idx': idx  /* , '<?php echo $this->security->get_csrf_token_name() ?>':'<?php echo $this->security->get_csrf_hash() ?>' */},
			  dataType: "html"
			});

			request.done(function( res ) {

				// 파일 삭제하고, 디비에서도 삭제하면
				// 에디터에서 삭제 및 파일 첨부 리스트에서도 삭제
				if('true' == res) {

					// 에디터에서 삭제
					if('image' == file_type) {
						//var del_attr = '/data'+ file_dir + file_name;
						//if($('img').attr('src') == del_attr) {$(this).remove();}
					}
					else {
						//var del_attr = '/data'+ file_dir + file_name;
						//if($('a').attr('href') == del_attr) {$(this).remove();}
					}
					$('.'+file_name).remove();

					// 파일 첨부 리스트에서 삭제
					$('.'+file_class).remove();
				}


			});

			request.fail(function( jqXHR, textStatus ) {
			  alert( "Request failed: " + textStatus );

			  return false;
			});
	}
}
</script>
