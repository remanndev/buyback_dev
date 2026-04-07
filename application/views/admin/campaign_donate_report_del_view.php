<?php
// 탭메뉴 고정
$active_tab = array('list'=>'','photo'=>'','cert'=>'');
$active_ctnt = array('list'=>'display:none;','photo'=>'display:none;','cert'=>'display:none;');


if($tab == 'list') {
	$active_tab['list'] = 'active';
	$active_ctnt['list'] = 'display: block;';
}
elseif($tab == 'photo') {
	$active_tab['photo'] = 'active';
	$active_ctnt['photo'] = 'display: block;';
}
elseif($tab == 'cert') {
	$active_tab['cert'] = 'active';
	$active_ctnt['cert'] = 'display: block;';
}

// 로그인 관리자
$adm_username = $this->tank_auth->get_username();

?>


<style type="text/css">
  .report_del_wrap { margin: 25px 0; }
  .report_del_wrap ul {}
  .report_del_wrap ul li {}
  .report_del_wrap ul li a { font-size: 17px; }
  .report_del_wrap ul li a.active {font-weight:600;}
  .report_del_sect { display: none; }
</style>


<h1>데이터 완전 삭제 리포트</h1>

<h2 class="mb_40" style="color:#353535;">캠페인명</h2>
<div class="mypage_ctnt">
	<dl class="mt_10">
		<!-- <dt>1. 기부명</dt> -->
		<dd class="mt_10 py_20 px_20" style="background-color:#f7f7fb;">
			<?php echo $cmp_row->cmp_title; ?>
		</dd>
	</dl>
</div>




<div class="report_del_wrap">
	<ul class="nav nav-tabs">
	  <li class="nav-item">
		<a id="btn_report_list" class="nav-link btn_report <?php echo $active_tab['list'] ?>" data-tab="list" href="#" onclick="return false;">목록</a>
	  </li>
	  <li class="nav-item">
		<a id="btn_report_photo" class="nav-link btn_report <?php echo $active_tab['photo'] ?>" data-tab="photo" href="#" onclick="return false;">사진</a>
	  </li>
	  <li class="nav-item">
		<a id="btn_report_cert" class="nav-link btn_report <?php echo $active_tab['cert'] ?>" data-tab="cert" href="#" onclick="return false;">증명</a>
	  </li>
	</ul>
</div>




<!-- 데이터 완전 삭제 리포트 - 목록 데이터 -->
<div id="report_del_sect_list" class="report_del_sect" style="<?php echo $active_ctnt['list'] ?>">

	<h2 class="mb_40" style="color:#353535; position:relative;">
		목록
		<button type="button" id="btn_add_item" class="o_btn  btn-sm btn-purple-flat" style="position:absolute; right:0; vertical-align: baseline;">추가</button>
	</h2>
	<div class="mypage_ctnt">
		<div class="tbl_purple mt_10">

			<?php echo form_open($this->uri->uri_string(), array('id'=>'form_list','name'=>'form')); ?>

				<!-- 데이터 완전 삭제 리포트 - 목록 데이터 -->
				<input type="hidden" name="tab" value="list" />

				<!-- <input type="hidden" name="idx" value="<?php //echo isset($row->idx) ? $row->idx : '';?>" /> -->
				<input type="hidden" name="cmp_idx" value="<?php echo isset($cmp_row->idx) ? $cmp_row->idx : '';?>" />
				<input type="hidden" name="cmp_code" value="<?php echo isset($cmp_row->code) ? $cmp_row->code : '';?>" />
				<input type="hidden" name="donate_idx" value="<?php echo isset($dn_row->idx) ? $dn_row->idx : '';?>" />
				<input type="hidden" name="user_idx" value="<?php echo isset($dn_row->user_idx) ? $dn_row->user_idx : '';?>" />

				<table id="dsp_goods_table" style="width:100%;">
					<tr>
						<!-- <th>NO</th> -->
						<th class="text-center">저장매체종류</th>
						<th class="text-center">HDD고유번호</th>
						<th class="text-center">용량</th>
						<th class="text-center">데이터 폐기방법</th>
						<th class="text-center">보안책임자<!-- a Chief Security Officer --></th>
						<th class="text-center">작업일자</th>
						<th class="text-center">삭제</th>
					</tr>
					<?php 
					foreach($dn_del_result['qry'] as $key => $del_row) {
					?>
					<tr>
						<td class="text-center"><input type="text" style="width:100%;" class="o_input save_item" name="hdd_type[]" value="<?php echo $del_row->hdd_type ?>" /></td>
						<td class="text-center"><input type="text" style="width:100%;" class="o_input save_item" name="hdd_idno[]" value="<?php echo $del_row->hdd_idno ?>" /></td>
						<td class="text-center"><input type="text" style="width:100%;" class="o_input save_item" name="hdd_capacity[]" value="<?php echo $del_row->hdd_capacity ?>" /></td>
						<td class="text-center"><input type="text" style="width:100%;" class="o_input save_item" name="del_method[]" value="<?php echo $del_row->del_method ?>" /></td>
						<td class="text-center"><input type="text" style="width:100%;" class="o_input save_item" name="del_cso[]" value="<?php echo $del_row->del_cso ?>" /></td>
						<td class="text-center"><input type="text" style="width:100%;" class="o_input save_item datepicker" name="del_date[]" value="<?php echo $del_row->del_date ?>" /></td>
						<td class="text-center">
							<input type="hidden" name="idx[]" value="<?php echo $del_row->idx ?>" />
							<button type="button" onclick="remove_item(this,<?php echo $del_row->idx ?>);" class="o_btn btn-xs btn-danger-flat" style="margin-left:4px; vertical-align: baseline;padding:0 12px; line-height:34px;" >X</button>
						</td>
					</tr>
					<?php 
					}
					?>
				</table>

				<div class="my_50 text-center">
					<!-- <button type="submit" class="btn btn-dark">저장</button> -->
					<input type="submit" name="submit" class="btn btn-dark" value="저장" style="margin:0 auto;"/>
				</div>

			<?php echo form_close(); ?>
		</div>
	</div>

	<!-- 데이터 완전 삭제 리포트 샘플용 - 목록 데이터 # 삭제하지 마세요. -->
	<table id="add_item_sample" style="display:none;">
		<tr>
			<td class="text-center"><input type="text" style="width:100%;" class="o_input save_item" name="hdd_type[]" value="" /></td>
			<td class="text-center"><input type="text" style="width:100%;" class="o_input save_item" name="hdd_idno[]" value="" /></td>
			<td class="text-center"><input type="text" style="width:100%;" class="o_input save_item" name="hdd_capacity[]" value="" /></td>
			<td class="text-center"><input type="text" style="width:100%;" class="o_input save_item" name="del_method[]" value="" /></td>
			<td class="text-center"><input type="text" style="width:100%;" class="o_input save_item" name="del_cso[]" value="" /></td>
			<td class="text-center"><input type="text" style="width:100%;" class="o_input save_item datepicker" onclick="datepick(this);" name="del_date[]" value="" /></td>
			<td class="text-center">
				<input type="hidden" name="idx[]" value="" />
				<button type="button" onclick="remove_item(this,'');" class="o_btn btn-xs btn-danger-flat" style="margin-left:4px; vertical-align: baseline;padding:0 12px; line-height:34px;" >X</button>
			</td>
		</tr>
	</table>

</div>

<script type="text/javascript">

	function form_check() {
		return true;
	}

	// item 삭제
	function remove_item(_this, idx){

		//console.log( $(_this).attr('class') );

		if(idx != '') {
			// data 삭제
			var request = $.ajax({
			  // url: "/admin/campaign/trans/dn_reportchk_del",
			  url: "/admin/campaign/trans/dn_reportList_del",
			  method: "POST",
			  data: { 'idx':idx },
			  dataType: "html"
			});
			request.done(function( res ) {
			  //console.log(res);
			  alert('삭제되었습니다.');
			});
			request.fail(function( jqXHR, textStatus ) {
			  alert( "Request failed: " + textStatus );
			  return false;
			});
		}

		// remove tr field
		$(_this).parents().parents('tr').remove();
	};

	$(document).ready(function(){

		/* 캠페인 만들기 # 목표기기 추가 */
		$('#btn_add_item').on('click', function(){
			html = $('#add_item_sample').html();
			$('#dsp_goods_table').append(html);
		});

		$('.remove_itm').on('click',function(){
			$(this).parents().parents('tr').remove();
		});
	});
</script>




<!-- 데이터 완전 삭제 리포트 - 사진 데이터 -->
<div id="report_del_sect_photo" class="report_del_sect" style="<?php echo $active_ctnt['photo'] ?>">
	<h2 class="mb_40" style="color:#353535; position:relative;">사진</h2>

	<div class="mypage_ctnt">

	  <?php echo form_open_multipart($this->uri->uri_string(), array('id'=>'form_photo','name'=>'form')); ?>

		<input type="hidden" name="tab" value="photo" />

		<input type="hidden" name="idx" value="<?php echo isset($row_photo->idx) ? $row_photo->idx : '';?>" />
		<input type="hidden" name="cmp_idx" value="<?php echo isset($cmp_row->idx) ? $cmp_row->idx : '';?>" />
		<input type="hidden" name="cmp_code" value="<?php echo isset($cmp_row->code) ? $cmp_row->code : '';?>" />
		<input type="hidden" name="donate_idx" value="<?php echo isset($dn_row->idx) ? $dn_row->idx : '';?>" />
		<input type="hidden" name="user_idx" value="<?php echo isset($dn_row->user_idx) ? $dn_row->user_idx : '';?>" />

		<?php //echo validation_errors('<div class="err_color_red">', '</div>'); ?>


		<div class="tbl_frm">
			<table>
			<colgroup>
			  <col width="130">
			  <col>
			</colgroup>
			<!-- <tr>
				<th>사용여부</th>
				<td>
					<input type="radio" id="use_Y" name="use_yn" value="Y"  <?php echo set_radio('use_yn', 'Y', (! isset($row->use_yn) OR (isset($row->use_yn) && 'Y' == $row->use_yn)) ? TRUE : FALSE); ?>> <label for="use_Y">사용</label>
					<input type="radio" id="use_N" name="use_yn" value="N"  <?php echo set_radio('use_yn', 'N', (isset($row->use_yn) && 'N' == $row->use_yn) ? TRUE : FALSE); ?>> <label for="use_N">사용 안함</label>
					<?php echo form_error('use_yn','<div class="err_color_red">','</div>'); ?>
				</td>
			</tr> -->

			<tr>
				<th>페이지 내용</th>
				<td>
					<?php echo form_error('del_content', '<div class="err_color_red">','</div>'); ?>
					<textarea id="del_content" name="del_content" class="o_input" ><?php echo set_value('del_content', isset($row_photo->del_content) ? $row_photo->del_content : '') ; ?></textarea>
					<?php echo form_error('del_content','<div class="err_color_red">','</div>'); ?>

					<?php if($total_cnt_file_editor > 0) { ?>
					<hr />
					<div style="width:100%; padding:0;">
					  <ul style="background-color:#ffffff; margin:0 0 0 5px;  padding-left:10px; height:118px; border:1px solid #EEEEEE; overflow-y:auto;  ">
					  
						  <?php foreach($result_file_editor['qry'] as $i => $o) { ?>
							<li class="file_editor_<?php echo $i ?>" style="font-size:11px; position:relative; line-height:200%; list-style:none;">
								<?php echo $o->file_name_org ?> (<?php echo number_format($o->file_size) ?> KB)

								<img src="<?php echo IMG_DIR ?>/common/icon_btn_upload.gif" style="cursor:pointer; vertical-align:middle;" alt="업로드" title="업로드" onclick="file_insert_to_content('<?php echo $o->file_dir ?>','<?php echo $o->file_name ?>','<?php echo $o->file_name_org ?>','<?php echo $o->file_type ?>','<?php echo $o->img_width ?>','1024')" />
								<img src="<?php echo IMG_DIR ?>/common/icon_btn_del.gif" style="cursor:pointer; vertical-align:middle;" alt="삭제" title="삭제" onclick="delete_file_manager(<?php echo $o->idx ?>,'file_editor_<?php echo $i ?>','<?php echo $o->file_type ?>','<?php echo $o->file_dir ?>','<?php echo $o->file_name ?>')" />

							</li>
						  <?php } ?>
					  
					  </ul>
					</div>
					<?php } ?>

				</td>
			</tr>

			<!-- <tr>
				<th>리포트 파일</th>
				<td>
					<input type="file" name="attach_file_form" class="o_input" style="width:100%; padding:0; border:none;" />
					<?php echo form_error('attach_file_form','<div class="err_color_red">','</div>'); ?>
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
			</tr> -->
			</table>
		</div>
		
		<div class="buttonBox" style="width:100%; margin:50px auto 30px; text-align:center;">
			<hr style="margin-bottom:50px; " />
			<input type="submit" name="submit" class="btn btn-dark" value="저장" style="margin:0 auto;"/>
		</div>

	  <?php echo form_close(); ?>
	
	</div>

</div>






<!-- 데이터 완전 삭제 리포트 - 증명서 데이터 -->
<div id="report_del_sect_cert" class="report_del_sect" style="<?php echo $active_ctnt['cert'] ?>">
	<h2 class="mb_40" style="color:#353535; position:relative;">증명</h2>

	<div class="mypage_ctnt">

	  <?php echo form_open_multipart($this->uri->uri_string(), array('id'=>'form_cert','name'=>'form')); ?>

		<input type="hidden" name="tab" value="cert" />

		<input type="hidden" name="idx" value="<?php echo isset($row_cert->idx) ? $row_cert->idx : '';?>" />
		<input type="hidden" name="cmp_idx" value="<?php echo isset($cmp_row->idx) ? $cmp_row->idx : '';?>" />
		<input type="hidden" name="cmp_code" value="<?php echo isset($cmp_row->code) ? $cmp_row->code : '';?>" />
		<input type="hidden" name="donate_idx" value="<?php echo isset($dn_row->idx) ? $dn_row->idx : '';?>" />
		<input type="hidden" name="user_idx" value="<?php echo isset($dn_row->user_idx) ? $dn_row->user_idx : '';?>" />

		<input type="hidden" name="admin_username" value="<?php echo isset($adm_username) ? $adm_username : '';?>" />

		<?php echo validation_errors('<div class="err_color_red">', '</div>'); ?>


		<div class="tbl_frm">
			<table>
			<colgroup>
			  <col width="130">
			  <col>
			</colgroup>
			<tr>
				<th>파일</th>
				<td>
					<input type="file" name="attach_file_form" class="o_input" style="width:100%; padding:0; border:none;" />
					<?php echo form_error('attach_file_form','<div class="err_color_red">','</div>'); ?>
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
			<input type="submit" name="submit" class="btn btn-dark" value="저장" style="margin:0 auto;"/>
		</div>

	  <?php echo form_close(); ?>

	</div>

</div>
















<script type="text/javascript">
$(document).ready(function(){

  // 탭메뉴 클릭 (목록,사진,증명)
  $('.btn_report').on('click', function(){
	var tab = $(this).data('tab');
	console.log( tab );

	// 메뉴
	$('.btn_report').removeClass('active');
	$(this).addClass('active');

	// 컨텐츠
	$('.report_del_sect').hide();
	$('#report_del_sect_'+tab).show();



  });
});
</script>




<script type="text/javascript">
$(function(){
	$R('#del_content', { 
		focus: true,
		lang: 'ko',
		minHeight: '400px',
		//plugins: ['fontsize','fontcolor','filemanager','video','table','alignment','inlinestyle','specialchars','textdirection','widget','fontfamily','fullscreen'],
		plugins: ['filemanager'],
		imageUpload: "/files/upload/redactor_image/<?php echo url_code('donation/image','e') ?>/dn_report_del_photo",
		//imageUpload: "/files/upload_redactor/_image/<?php echo url_code('donation/image','e') ?>/dn_report_del_photo",
		imagePosition: true,
		fileUpload: "/files/upload/redactor_file/<?php echo url_code('donation/files','e') ?>/dn_report_del_photo",
			/*
		buttonsAddAfter: {
			after: 'deleted',
			buttons: ['underline','line', 'redo', 'undo', 'underline', 'ol', 'ul', 'sup', 'sub']
		},
		*/
		buttonsHide: ['lists']

	});
});
</script>



<script type="text/javascript">
// 파일을 본문 안에 추가
function file_insert_to_content(file_dir,file_name,file_name_org,file_type,img_width,limit_width)
{
	if('image' == file_type){
		var img_w = img_width+'px';
		if(Number(img_width) > Number(limit_width)) {
			img_w = limit_width +'px';
		}
		var add_tag = '<p><img class="'+file_name+'" src="/data/'+ file_dir + '/' + file_name +'" alt="" width="'+img_w+'"></p>';
	}
	else {
		var add_tag = '<p><a class="'+file_name+'" href="/data/'+ file_dir + '/' + file_name +'">'+file_name_org+'</a></p>';
	}

	// insert
	$R('#del_content', 'insertion.insertHtml', add_tag);
}


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


<script type="text/javascript">
$(function(){
	// datetimepicker
	$.datetimepicker.setLocale('kr');
	$('.datepicker').datetimepicker({
		lang:'kr',
		timepicker:false,
		format:'Y-m-d',
		scrollMonth : false 
	});
});

function datepick(el) {
	$.datetimepicker.setLocale('kr');

	//console.log(el);
	//el.style.color = 'red';
	var input_id = Date.now();
	el.setAttribute('id',input_id);

	datepicker(input_id);
	/*
	$('#'+input_id).datetimepicker({
		lang:'kr',
		timepicker:false,
		format:'Y-m-d',
		scrollMonth : false 
	});
	*/
}

function datepicker(input_id) {
	$('#'+input_id).datetimepicker({
		lang:'kr',
		timepicker:false,
		format:'Y-m-d',
		scrollMonth : false 
	});
}
</script>