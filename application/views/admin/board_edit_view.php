<?php
/** - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
 * 회원구분( 1:전체 / 10:준회원·sns로그인회원 / 20:정회원 / 100:관리자 )
*/
	$arr_level = $level_result;
	unset($arr_level[0]); // 전체 제외
	//print_r($arr_level);

/** - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
 * 게시판 그룹
*/
	$gr_select_options = array();
	foreach($gr_result['qry'] as $i => $o) :
	  $gr_select_options[$o->gr_code] = $o->gr_title.' / '.$o->gr_code;
	endforeach;
	$gr_selected = ($this->input->post('gr_code')) ? $this->input->post('gr_code') : $row->gr_code;

/** - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
 * 게시판 유형
*/
/*
	$bo_type_select_options = array(
		'basic'       => '기본 게시판',
		'webzine'     => '웹진 게시판',
		'video'     => '영상 게시판',
		'gallery'     => '갤러리',
		'blog'       => '블로그형',
		'hello'       => '헬로부산형',
		'inquiry'         => '문의게시판',
		'faq'         => 'FAQ',
		'consult'     => '빠른상담',
		'tag'     => '태그형',
	);
*/
	$bo_type_select_options = $arr_bbskin;
	$bo_type_selected = ($this->input->post('bo_type')) ? $this->input->post('bo_type') : $row->bo_type;



// 게시판 관리자 선택
	/*
	$bo_admin_fk_select_options = array(
		'basic'       => '기본 게시판',
		'webzine'     => '웹진 게시판',
		'video'     => '영상 게시판',
		'gallery'     => '갤러리',
		'blog'       => '블로그형',
		'hello'       => '헬로부산형',
		'inquiry'         => '문의게시판',
		'faq'         => 'FAQ',
		'consult'     => '빠른상담',
		'tag'     => '태그형',
	);
	$bo_admin_fk_selected = ($this->input->post('bo_admin_fk')) ? $this->input->post('bo_admin_fk') : $row->bo_admin_fk;
	*/

	$bo_admin_fk_select_options = array();
	foreach($admin_result['qry'] as $i => $o) :
	  $bo_admin_fk_select_options[$o->id] = $o->nickname;
	endforeach;
	$bo_admin_fk_selected = ($this->input->post('bo_admin_fk')) ? $this->input->post('bo_admin_fk') : $row->bo_admin_fk;

?>


<div class="admin_wrap">

  <?php echo form_open($this->uri->uri_string(), array('id'=>'board_form','name'=>'board_form')); ?>
	
	<div id="scroll-fix-header"></div>
	<h1 style="margin-bottom:0;">
		게시판 수정
		<h3 class="page-header scroll_fixed" style="z-index:110; width:100%; position:relative;">
		  <div style="position:absolute; bottom:10px; right:0px;">
			<input type="submit" name="submit" class="btn btn-primary btn-sm" value="저장" style="padding-left:15px; padding-right:15px; margin-right:5px;" /><a href="/admin/board/lists"><input type="button" name="list" class="btn btn-dark btn-sm" value="목록" style="padding-left:15px; padding-right:15px; margin-left:0;" /></a>
		  </div>
		</h3>
	</h1>

	<?php echo validation_errors('<div class="err_color_red" style="background-color:#ffeeee; padding:3px 10px; margin:2px 0;">', '</div>'); ?>

	<h2>기본 설정</h2>
	<div class="tbl_frm">
		<table>
		<colgroup>
		  <col width="150">
		  <col>
		</colgroup>
		<tr>
		  <th>게시판 그룹</th>
		  <td>
			<?php echo form_dropdown('gr_code', $gr_select_options, $gr_selected, 'class="o_selectbox"'); ?>
		  </td>
		</tr>
		<tr>
		  <th>게시판 코드</th>
		  <td style="font-family:verdana; font-size:18px; "><?php echo $row->bo_code ?></td>
		</tr>
		<tr>
		  <th>게시판 제목</th>
		  <td><input type="text" id="bo_title" class="o_input" name="bo_title" value="<?php echo set_value('bo_title', $row->bo_title) ?>" style="width:200px; " /></td>
		</tr>
		<tr>
		  <th>게시판 유형</th>
		  <td>
			<?php echo form_dropdown('bo_type', $bo_type_select_options, $bo_type_selected, 'class="o_selectbox"'); ?>
		  </td>
		</tr>

		<tr>
		  <th>게시판 관리자</th>
		  <td>
			<?php echo form_dropdown('bo_admin_fk', $bo_admin_fk_select_options, $bo_admin_fk_selected, 'class="o_selectbox"'); ?>
		  </td>
		</tr>

		<tr>
		  <th>게시판 너비</th>
		  <td>
			기본 : <input type="text" id="bo_width_limit" class="o_input" name="bo_width_limit" value="<?php echo set_value('bo_width_limit', $row->bo_width_limit) ?>" style="min-width:200px; " />
			<?php echo form_error('bo_width_limit'); ?>
			<div class="notice_info_red" style="line-height:23px;">게시판 너비는 px 단위이며, <span style="text-decoration:underline; font-weight:bold;">0 으로 세팅시 100% 로 적용</span>됩니다.</div>
			최대 : <input type="text" id="bo_width_max" class="o_input" name="bo_width_max" value="<?php echo set_value('bo_width_max', $row->bo_width_max) ?>" style="min-width:200px; " />
			<?php echo form_error('bo_width_max'); ?>
			<div class="notice_info_red" style="line-height:23px;">게시판 너비 값이 0(100%)일 때, 최대치 값. <span style="text-decoration:underline; font-weight:bold;">0 으로 세팅시 100% 로 적용</span>됩니다.</div>
		  </td>
		</tr>
		</table>
	</div>





	<h2>기능 설정</h2>

	<div class="tbl_frm">
		<table>
		<colgroup>
		  <col width="150">
		  <col>
		</colgroup>
		<tr>
		  <th>작성자명 설정</th>
		  <td>
			<label for="bo_writer_type_name" style="cursor:pointer; padding-right:15px;"><input type="radio" id="bo_writer_type_name" name="bo_writer_type" value="name" <?php echo  set_radio('bo_writer_type', 'name', ('name' === $row->bo_writer_type) ? TRUE : FALSE); ?> style="vertical-align:middle;" /> 이름 사용</label>
			<label for="bo_writer_type_id" style="cursor:pointer; padding-right:15px;"><input type="radio" id="bo_writer_type_id" name="bo_writer_type" value="id" <?php echo  set_radio('bo_writer_type', 'id', ('id' === $row->bo_writer_type) ? TRUE : FALSE); ?> style="vertical-align:middle;" /> 아이디 사용</label>
			<label for="bo_writer_type_none" style="cursor:pointer; padding-right:15px;"><input type="radio" id="bo_writer_type_none" name="bo_writer_type" value="none" <?php echo  set_radio('bo_writer_type', 'none', ('none' === $row->bo_writer_type) ? TRUE : FALSE); ?> style="vertical-align:middle;" /> 사용 안함</label>
		  </td>
		</tr>
		<tr>
		  <th>비밀글 설정</th>
		  <td>
			<label for="bo_use_secret_0" style="cursor:pointer; padding-right:15px;"><input type="radio" id="bo_use_secret_0" name="bo_use_secret" value="0" <?php echo  set_radio('bo_use_secret', '0', ('0' === $row->bo_use_secret) ? TRUE : FALSE); ?> style="vertical-align:middle;" /> 사용 안함(무조건 일반글)</label>
			<label for="bo_use_secret_1" style="cursor:pointer; padding-right:15px;"><input type="radio" id="bo_use_secret_1" name="bo_use_secret" value="1" <?php echo  set_radio('bo_use_secret', '1', ('1' === $row->bo_use_secret) ? TRUE : FALSE); ?> style="vertical-align:middle;" /> 작성시 기본 일반글</label>
			<label for="bo_use_secret_2" style="cursor:pointer; padding-right:15px;"><input type="radio" id="bo_use_secret_2" name="bo_use_secret" value="2" <?php echo  set_radio('bo_use_secret', '2', ('2' === $row->bo_use_secret) ? TRUE : FALSE); ?> style="vertical-align:middle;" /> 작성시 기본 비밀글</label>
			<label for="bo_use_secret_3" style="cursor:pointer; padding-right:15px;"><input type="radio" id="bo_use_secret_3" name="bo_use_secret" value="3" <?php echo  set_radio('bo_use_secret', '3', ('3' === $row->bo_use_secret) ? TRUE : FALSE); ?> style="vertical-align:middle;" /> 무조건 비밀글</label>
		  </td>
		</tr>
		<tr>
		  <th>카테고리 설정</th>
		  <td>
			<label for="bo_use_category_0" style="cursor:pointer; padding-right:15px;" onclick="$('#layer_bo_category').hide();"><input type="radio" id="bo_use_category_0" name="bo_use_category" value="0" <?php echo  set_radio('bo_use_category', '0', ('0' === $row->bo_use_category) ? TRUE : FALSE); ?> style="vertical-align:middle;" /> 사용 안함</label>
			<label for="bo_use_category_1" style="cursor:pointer; padding-right:15px;" onclick="$('#layer_bo_category').show();"><input type="radio" id="bo_use_category_1" name="bo_use_category" value="1" <?php echo  set_radio('bo_use_category', '1', ('1' === $row->bo_use_category) ? TRUE : FALSE); ?> style="vertical-align:middle;" /> 사용</label>

			<div id="layer_bo_category" style="display: <?php echo ('1' === $row->bo_use_category) ? '' : 'none'; ?>; margin-top:5px; padding:0 5px 5px 0">
			  <div class="notice_info_red" style="line-height:23px;">카테고리는 콤마(,)로 구분해서 입력해주세요.</div>
			  <textarea id="bo_category" name="bo_category" style="width:100%; max-width:700px; height:70px;"><?php echo $row->bo_category ?></textarea>
			</div>
			<small></small>
		  </td>
		</tr>
		<tr>
		  <th>NEW 아이콘 설정</th>
		  <td>
			<label for="bo_use_new_0" style="cursor:pointer; padding-right:15px;" ><input type="radio" id="bo_use_new_0" name="bo_use_new" value="0" <?php echo  set_radio('bo_use_new', '0', ('0' === $row->bo_use_new) ? TRUE : FALSE); ?> style="vertical-align:middle;" /> 사용 안함</label>
			<label for="bo_use_new_1" style="cursor:pointer; padding-right:15px;" ><input type="radio" id="bo_use_new_1" name="bo_use_new" value="1" <?php echo  set_radio('bo_use_new', '1', ('1' === $row->bo_use_new) ? TRUE : FALSE); ?> style="vertical-align:middle;" /> 사용</label>
			<input type="text" id="bo_new_condition" class="o_input" name="bo_new_condition" value="<?php echo set_value('bo_new_condition', $row->bo_new_condition) ?>" style="width:50px; text-align:center;"  /> 시간 이내에 작성된 글
		  </td>
		</tr>
		<tr>
		  <th>HOT 아이콘 설정</th>
		  <td>
			<label for="bo_use_hot_0" style="cursor:pointer; padding-right:15px;" ><input type="radio" id="bo_use_hot_0" name="bo_use_hot" value="0" <?php echo  set_radio('bo_use_hot', '0', ('0' === $row->bo_use_hot) ? TRUE : FALSE); ?> style="vertical-align:middle;" /> 사용 안함</label>
			<label for="bo_use_hot_1" style="cursor:pointer; padding-right:15px;" ><input type="radio" id="bo_use_hot_1" name="bo_use_hot" value="1" <?php echo  set_radio('bo_use_hot', '1', ('1' === $row->bo_use_hot) ? TRUE : FALSE); ?> style="vertical-align:middle;" /> 사용</label>
			<input type="text" id="bo_hot_condition" class="o_input" name="bo_hot_condition" value="<?php echo set_value('bo_hot_condition', $row->bo_hot_condition) ?>" style="width:50px; text-align:center;"  /> 회 이상 조회된 글
		  </td>
		</tr>
		<tr>
		  <th>관리자 체크</th>
		  <td>
			<label for="bo_use_staff_0" style="cursor:pointer; padding-right:15px;" ><input type="radio" id="bo_use_staff_0" name="bo_use_staff" value="0" <?php echo  set_radio('bo_use_staff', '0', ('0' === $row->bo_use_staff) ? TRUE : FALSE); ?> style="vertical-align:middle;" /> 사용 안함</label>
			<label for="bo_use_staff_1" style="cursor:pointer; padding-right:15px;" ><input type="radio" id="bo_use_staff_1" name="bo_use_staff" value="1" <?php echo  set_radio('bo_use_staff', '1', ('1' === $row->bo_use_staff) ? TRUE : FALSE); ?> style="vertical-align:middle;" /> 사용</label>
		  </td>
		</tr>
		<tr>
		  <th>코멘트 사용 설정</th>
		  <td>
			<label for="bo_use_comment_0" style="cursor:pointer; padding-right:15px;" ><input type="radio" id="bo_use_comment_0" name="bo_use_comment" value="0" <?php echo  set_radio('bo_use_comment', '0', ('0' === $row->bo_use_comment) ? TRUE : FALSE); ?> style="vertical-align:middle;" /> 사용 안함</label>
			<label for="bo_use_comment_1" style="cursor:pointer; padding-right:15px;" ><input type="radio" id="bo_use_comment_1" name="bo_use_comment" value="1" <?php echo  set_radio('bo_use_comment', '1', ('1' === $row->bo_use_comment) ? TRUE : FALSE); ?> style="vertical-align:middle;" /> 사용</label>
		  </td>
		</tr>
		</table>
	</div>





	<h2>권한 설정</h2>

	<div class="tbl_frm">
		<table>
		<colgroup>
		  <col width="150">
		  <col>
		</colgroup>


		<tr>
		  <th>목록 권한</th>
		  <td>
			<label for="bo_level_list_all" style="cursor:pointer; padding-right:15px;"><input type="radio" id="bo_level_list_all" name="bo_level_list" value="1" <?php echo  set_radio('bo_level_list', '1', ('1' == $row->bo_level_list) ? TRUE : FALSE); ?> style="vertical-align:middle;" /> 전체(비회원+회원)</label>
			<?php foreach($arr_level as $i => $level) { ?>
				<label for="bo_level_list_<?php echo $level->no ?>" style="cursor:pointer; padding-right:15px;"><input type="radio" id="bo_level_list_<?php echo $level->no ?>" name="bo_level_list" value="<?php echo $level->no ?>" <?php echo  set_radio('bo_level_list', $level->no, ($level->no == $row->bo_level_list) ? TRUE : FALSE); ?> style="vertical-align:middle;" /> <?php echo $level->title ?> 이상</label>
			<?php } ?>
		  </td>
		</tr>
		<tr>
		  <th>보기 권한</th>
		  <td>
			<label for="bo_level_read_1" style="cursor:pointer; padding-right:15px;"><input type="radio" id="bo_level_read_1" name="bo_level_read" value="1" <?php echo  set_radio('bo_level_read', '1', ('1' == $row->bo_level_read) ? TRUE : FALSE); ?> style="vertical-align:middle;" /> 전체(비회원+회원)</label>
			<?php foreach($arr_level as $i => $level) { ?>
				<label for="bo_level_read_<?php echo $level->no ?>" style="cursor:pointer; padding-right:15px;"><input type="radio" id="bo_level_read_<?php echo $level->no ?>" name="bo_level_read" value="<?php echo $level->no ?>" <?php echo  set_radio('bo_level_read', $level->no, ($level->no == $row->bo_level_read) ? TRUE : FALSE); ?> style="vertical-align:middle;" /> <?php echo $level->title ?> 이상</label>
			<?php } ?>
		  </td>
		</tr>
		<tr>
		  <th>쓰기 권한</th>
		  <td>
			<label for="bo_level_write_1" style="cursor:pointer; padding-right:15px;"><input type="radio" id="bo_level_write_1" name="bo_level_write" value="1" <?php echo  set_radio('bo_level_write', '1', ('1' == $row->bo_level_write) ? TRUE : FALSE); ?> style="vertical-align:middle;" /> 전체(비회원+회원)</label>
			<?php foreach($arr_level as $i => $level) { ?>
				<label for="bo_level_write_<?php echo $level->no ?>" style="cursor:pointer; padding-right:15px;"><input type="radio" id="bo_level_write_<?php echo $level->no ?>" name="bo_level_write" value="<?php echo $level->no ?>" <?php echo  set_radio('bo_level_write', $level->no, ($level->no == $row->bo_level_write) ? TRUE : FALSE); ?> style="vertical-align:middle;" /> <?php echo $level->title ?> 이상</label>
			<?php } ?>
		  </td>
		</tr>

		<tr>
		  <th>답글 설정 및 권한</th>
		  <td>
			<label for="bo_level_reply_1" style="cursor:pointer; padding-right:15px;"><input type="radio" id="bo_level_reply_1" name="bo_level_reply" value="1" <?php echo  set_radio('bo_level_reply', '1', ('1' == $row->bo_level_reply) ? TRUE : FALSE); ?> style="vertical-align:middle;" /> 전체(비회원+회원)</label>
			<?php foreach($arr_level as $i => $level) { ?>
				<label for="bo_level_reply_<?php echo $level->no ?>" style="cursor:pointer; padding-right:15px;"><input type="radio" id="bo_level_reply_<?php echo $level->no ?>" name="bo_level_reply" value="<?php echo $level->no ?>" <?php echo  set_radio('bo_level_reply', $level->no, ($level->no == $row->bo_level_reply) ? TRUE : FALSE); ?> style="vertical-align:middle;" /> <?php echo $level->title ?> 이상</label>
			<?php } ?>
			<label for="bo_level_reply_0" style="cursor:pointer; padding-right:15px;"><input type="radio" id="bo_level_reply_0" name="bo_level_reply" value="0" <?php echo  set_radio('bo_level_reply', '0', ('0' === $row->bo_level_reply) ? TRUE : FALSE); ?> style="vertical-align:middle;" /> 사용 안함</label>
		  </td>
		</tr>
		<tr>
		  <th>코멘트 설정 및 권한</th>
		  <td>
			<label for="bo_level_comment_1" style="cursor:pointer; padding-right:15px;"><input type="radio" id="bo_level_comment_1" name="bo_level_comment" value="1" <?php echo  set_radio('bo_level_comment', '1', ('1' === $row->bo_level_comment) ? TRUE : FALSE); ?> style="vertical-align:middle;" /> 전체(비회원+회원)</label>
			<?php foreach($arr_level as $i => $level) { ?>
				<label for="bo_level_comment_<?php echo $level->no ?>" style="cursor:pointer; padding-right:15px;"><input type="radio" id="bo_level_comment_<?php echo $level->no ?>" name="bo_level_comment" value="<?php echo $level->no ?>" <?php echo  set_radio('bo_level_comment', $level->no, ($level->no == $row->bo_level_comment) ? TRUE : FALSE); ?> style="vertical-align:middle;" /> <?php echo $level->title ?> 이상</label>
			<?php } ?>
			<label for="bo_level_comment_0" style="cursor:pointer; padding-right:15px;"><input type="radio" id="bo_level_comment_0" name="bo_level_comment" value="0" <?php echo  set_radio('bo_level_comment', '0', ('0' === $row->bo_level_comment) ? TRUE : FALSE); ?> style="vertical-align:middle;" /> 사용 안함</label>
		  </td>
		</tr>
		<tr>
		  <th>업로드 권한</th>
		  <td>
			<label for="bo_level_upload_1" style="cursor:pointer; padding-right:15px;"><input type="radio" id="bo_level_upload_1" name="bo_level_upload" value="1" <?php echo  set_radio('bo_level_upload', '1', ('1' === $row->bo_level_upload) ? TRUE : FALSE); ?> style="vertical-align:middle;" /> 전체(비회원+회원)</label>
			<?php foreach($arr_level as $i => $level) { ?>
				<label for="bo_level_upload_<?php echo $level->no ?>" style="cursor:pointer; padding-right:15px;"><input type="radio" id="bo_level_upload_<?php echo $level->no ?>" name="bo_level_upload" value="<?php echo $level->no ?>" <?php echo  set_radio('bo_level_upload', $level->no, ($level->no == $row->bo_level_upload) ? TRUE : FALSE); ?> style="vertical-align:middle;" /> <?php echo $level->title ?> 이상</label>
			<?php } ?>
		  </td>
		</tr>
		<tr>
		  <th>다운로드 권한</th>
		  <td>
			<label for="bo_level_download_1" style="cursor:pointer; padding-right:15px;"><input type="radio" id="bo_level_download_1" name="bo_level_download" value="1" <?php echo  set_radio('bo_level_download', '1', ('1' === $row->bo_level_download) ? TRUE : FALSE); ?> style="vertical-align:middle;" /> 전체(비회원+회원)</label>
			<?php foreach($arr_level as $i => $level) { ?>
				<label for="bo_level_download_<?php echo $level->no ?>" style="cursor:pointer; padding-right:15px;"><input type="radio" id="bo_level_download_<?php echo $level->no ?>" name="bo_level_download" value="<?php echo $level->no ?>" <?php echo  set_radio('bo_level_download', $level->no, ($level->no == $row->bo_level_download) ? TRUE : FALSE); ?> style="vertical-align:middle;" /> <?php echo $level->title ?> 이상</label>
			<?php } ?>
		  </td>
		</tr>
		</table>
	</div>





	<h2>글목록 화면 설정</h2>

	<div class="tbl_frm">
		<table>
		<colgroup>
		  <col width="150">
		  <col>
		</colgroup>
		<tr>
		  <th>공지 체크 글 설정</th>
		  <td>
			<label for="bo_notice_limit" style="cursor:pointer; padding-right:15px;"><input type="text" id="bo_notice_limit" class="o_input" name="bo_notice_limit" value="<?php echo  set_value('bo_notice_limit', $row->bo_notice_limit); ?>" style="width:50px; text-align:center;" /> 개 노출</label>
			<label for="bo_notice_type_all" style="cursor:pointer; padding-right:15px;"><input type="radio" id="bo_notice_type_all" name="bo_notice_type" value="all" <?php echo  set_checkbox('bo_use_hot', 'all', ('all' === $row->bo_notice_type) ? TRUE : FALSE); ?> style="vertical-align:middle;" /> 모든 페이지에 노출</label>
			<label for="bo_notice_type_first" style="cursor:pointer; padding-right:15px;"><input type="radio" id="bo_notice_type_first" name="bo_notice_type" value="first" <?php echo  set_checkbox('bo_notice_type', 'first', ('first' === $row->bo_notice_type) ? TRUE : FALSE); ?> style="vertical-align:middle;" /> 첫 페이지에만 노출</label>

			<?php /* ?>
			<!-- <div class="notice_info_gray">공지 체크한 글의 노출 개수를 지정할 수 있습니다.</div>
			<div class="notice_info_red">공지 체크한 글의 노출 개수를 지정할 수 있습니다.</div>
			<div class="notice_info_red2">공지 체크한 글의 노출 개수를 지정할 수 있습니다.</div>
			<div class="notice_info_red3">공지 체크한 글의 노출 개수를 지정할 수 있습니다.</div>
			<div class="notice_info_blue">공지 체크한 글의 노출 개수를 지정할 수 있습니다.</div>
			<div class="notice_info_sky">공지 체크한 글의 노출 개수를 지정할 수 있습니다.</div>
			<div class="notice_info_sky2">공지 체크한 글의 노출 개수를 지정할 수 있습니다.</div> -->
			<?php */ ?>

			<div class="notice_info_red" style="margin-top:5px; line-height:23px;">공지 체크한 글의 노출 개수를 지정할 수 있습니다. <span style="font-weight:bolder; text-decoration:underline;">0 으로 설정하시면 공지 체크한 글이 모두 노출됩니다.</span></div>
			<div class="notice_info_red" style="line-height:23px;">모든 페이지에 노출 설정시, 모든 목록 페이지의 상단에 공지사항이 우선 노출됩니다.</div>
			<div class="notice_info_red" style="line-height:23px;">첫 페이지에만 노출 설정시, 첫 번째 목록 페이지에서만 상단에 공지사항이 노출됩니다.</div>
		  </td>
		</tr>
		<tr>
		  <th>페이지당 게시물 수</th>
		  <td>
			<input type="text" id="bo_page_limit" class="o_input" name="bo_page_limit" value="<?php echo  set_value('bo_page_limit', $row->bo_page_limit); ?>" style="width:50px; text-align:center;" />
		  </td>
		</tr>
		</table>
	</div>





	<h2>글쓰기 화면 설정</h2>

	<div class="tbl_frm">
		<table>
		<colgroup>
		  <col width="150">
		  <col>
		</colgroup>
		<tr>
		  <th>에디터 사용</th>
		  <td>
			<label for="bo_use_editor_0" style="cursor:pointer; padding-right:15px;" ><input type="radio" id="bo_use_editor_0" name="bo_use_editor" value="0" <?php echo  set_radio('bo_use_editor', '0', ('0' === $row->bo_use_editor) ? TRUE : FALSE); ?> style="vertical-align:middle;" /> 사용 안함</label>
			<label for="bo_use_editor_1" style="cursor:pointer; padding-right:15px;" ><input type="radio" id="bo_use_editor_1" name="bo_use_editor" value="1" <?php echo  set_radio('bo_use_editor', '1', ('1' === $row->bo_use_editor) ? TRUE : FALSE); ?> style="vertical-align:middle;" /> 사용</label>

			<small style=" background-color:#ebebeb; padding:7px 10px;">
				<label for="bo_editor_redactor" style="cursor:pointer; padding-right:15px;" ><input type="radio" id="bo_editor_redactor" name="bo_editor_type" value="redactor" <?php echo  set_radio('bo_editor_type', 'redactor', ('redactor' === $row->bo_editor_type) ? TRUE : FALSE); ?> style="vertical-align:middle;" /> Redactor3</label>
				<label for="bo_editor_ckeditor" style="cursor:pointer; padding-right:15px;" ><input type="radio" id="bo_editor_ckeditor" name="bo_editor_type" value="ckeditor" <?php echo  set_radio('bo_editor_type', 'ckeditor', ('ckeditor' === $row->bo_editor_type) ? TRUE : FALSE); ?> style="vertical-align:middle;" /> CKEditor5</label>
			</small>

			<?php echo form_error('bo_use_editor','<div class="err_color_red">','</div>'); ?>
			<?php echo form_error('bo_editor_type','<div class="err_color_red">','</div>'); ?>

		  </td>
		</tr>
		<tr>
		  <th>첨부 파일 사용</th>
		  <td>
			<label for="bo_use_upload_0" style="cursor:pointer; padding-right:15px;" ><input type="radio" id="bo_use_upload_0" name="bo_use_upload" value="0" <?php echo  set_radio('bo_use_upload', '0', ('0' === $row->bo_use_upload) ? TRUE : FALSE); ?> style="vertical-align:middle;" /> 사용 안함</label>
			<label for="bo_use_upload_1" style="cursor:pointer; padding-right:18px;" ><input type="radio" id="bo_use_upload_1" name="bo_use_upload" value="1" <?php echo  set_radio('bo_use_upload', '1', ('1' === $row->bo_use_upload) ? TRUE : FALSE); ?> style="vertical-align:middle;" /> 사용 </label>

			<label for="bo_upload_cnt" style="cursor:pointer; padding:0 10px;"> 업로드 수 : <input type="text" id="bo_upload_cnt" class="o_input" name="bo_upload_cnt" value="<?php echo  set_value('bo_upload_cnt', $row->bo_upload_cnt); ?>" style="width:50px; text-align:center;" /> 개</label>
		  </td>
		</tr>
		<tr>
		  <th>첨부 파일 크기 제한</th>
		  <td>
			<label for="bo_upload_size" style="cursor:pointer;"><input type="text" id="bo_upload_size" class="o_input" name="bo_upload_size" value="<?php echo  set_value('bo_upload_size', $row->bo_upload_size); ?>" style="width:50px; text-align:center;" /> MB / 서버(<?php echo $row->upload_max_size ?>)</label>
			<div class="notice_info_red" style="margin-top:5px; line-height:23px;"><strong>에디터에서의 파일 및 이미지 업로드</strong>와 별도의 <strong>첨부 파일 업로드</strong>에 동일하게 적용됩니다.</div>
		  </td>
		</tr>
		<tr>
		  <th>첨부 파일 노출 위치</th>
		  <td>
			<label for="bo_file_position_up" style="cursor:pointer; padding-right:15px;" ><input type="radio" id="bo_file_position_up" name="bo_file_position" value="up" <?php echo  set_radio('bo_file_position', 'up', ('up' === $row->bo_file_position) ? TRUE : FALSE); ?> style="vertical-align:middle;" /> 본문 상단</label>
			<label for="bo_file_position_down" style="cursor:pointer; padding-right:15px;" ><input type="radio" id="bo_file_position_down" name="bo_file_position" value="down" <?php echo  set_radio('bo_file_position', 'down', ('down' === $row->bo_file_position) ? TRUE : FALSE); ?> style="vertical-align:middle;" /> 본문 하단</label>
			<div class="notice_info_red" style="line-height:23px;">첨부파일이 있는 경우, 다운로드 링크의 위치를 지정합니다.</div>
		  </td>
		</tr>

		<tr>
		  <th>링크 사용</th>
		  <td>
			<label for="bo_use_link_0" style="cursor:pointer; padding-right:15px;" ><input type="radio" id="bo_use_link_0" name="bo_use_link" value="0" <?php echo  set_radio('bo_use_link', '0', ('0' === $row->bo_use_link) ? TRUE : FALSE); ?> style="vertical-align:middle;" /> 사용 안함</label>
			<label for="bo_use_link_1" style="cursor:pointer; padding-right:15px;" ><input type="radio" id="bo_use_link_1" name="bo_use_link" value="1" <?php echo  set_radio('bo_use_link', '1', ('1' === $row->bo_use_link) ? TRUE : FALSE); ?> style="vertical-align:middle;" /> 사용</label>
		  </td>
		</tr>
		<tr>
		  <th>초기 내용 세팅</th>
		  <td><textarea id="bo_init_content" name="bo_init_content"><?php echo $row->bo_init_content ?></textarea></td>
		</tr>
		</table>
	</div>





	<!-- <h2>글보기 화면 설정</h2>

	<div class="tbl_frm">
		<table>
		<colgroup>
		  <col width="150">
		  <col>
		</colgroup>
		<tr>
		  <th>첨부파일 노출 위치</th>
		  <td>
			<label for="bo_file_position_up" style="cursor:pointer; padding-right:15px;" ><input type="radio" id="bo_file_position_up" name="bo_file_position" value="up" <?php echo  set_radio('bo_file_position', 'up', ('up' === $row->bo_file_position) ? TRUE : FALSE); ?> style="vertical-align:middle;" /> 본문 상단</label>
			<label for="bo_file_position_down" style="cursor:pointer; padding-right:15px;" ><input type="radio" id="bo_file_position_down" name="bo_file_position" value="down" <?php echo  set_radio('bo_file_position', 'down', ('down' === $row->bo_file_position) ? TRUE : FALSE); ?> style="vertical-align:middle;" /> 본문 하단</label>
			<div class="notice_info_red" style="line-height:23px;">첨부파일이 있는 경우, 다운로드 링크의 위치를 지정합니다.</div>
		  </td>
		</tr>
		<tr>
		  <th>첨부파일 이미지 표시</th>
		  <td>
			<label for="bo_file_image_display_0" style="cursor:pointer; padding-right:15px;" ><input type="radio" id="bo_file_image_display_0" name="bo_file_image_display" value="0" <?php echo  set_radio('bo_file_image_display', '0', ('0' === $row->bo_file_image_display) ? TRUE : FALSE); ?> style="vertical-align:middle;" /> 사용 안함</label>
			<label for="bo_file_image_display_1" style="cursor:pointer; padding-right:15px;" ><input type="radio" id="bo_file_image_display_1" name="bo_file_image_display" value="1" <?php echo  set_radio('bo_file_image_display', '1', ('1' === $row->bo_file_image_display) ? TRUE : FALSE); ?> style="vertical-align:middle;" /> 사용</label>
			<div class="notice_info_red" style="line-height:23px;">첨부파일이 이미지인 경우, 본문 상단에 이를 보여줍니다.</div>
		  </td>
		</tr>
		<tr>
		  <th>첨부파일 이미지 리사이즈</th>
		  <td>
			<input type="text" id="bo_image_width" class="o_input" name="bo_image_width" value="<?php echo  set_value('bo_image_width', $row->bo_image_width); ?>" style="width:40px; text-align:right;" maxlength="4" /> px
			<div class="notice_info_red" style="margin-top:5px; line-height:23px;">업로드 이미지의 너비가 제한된 값보다 큰 경우, 설정값으로 리사이즈하여 보여줍니다.</div>
			<div class="notice_info_red" style="line-height:23px;">모바일에서는 디바이스 해상도보다 클 경우 100% 로 리사이즈하여 보여줍니다.</div>
		  </td>
		</tr>
		</table>
	</div> -->





	<h2>상단 및 하단 디자인</h2>

	<div class="tbl_frm">
		<table>
		<colgroup>
		  <col width="150">
		  <col>
		</colgroup>
		<tr>
		  <th>상단 디자인</th>
		  <td><textarea id="bo_head_design" name="bo_head"><?php echo $row->bo_head ?></textarea></td>
		</tr>
		<tr>
		  <th>하단 디자인</th>
		  <td><textarea id="bo_tail_design" name="bo_tail"><?php echo $row->bo_tail ?></textarea></td>
		</tr>
		</table>
	</div>


	<h2>추가 정보(배열)</h2>

	<div class="tbl_frm">
		<table>
		<colgroup>
		  <col width="150">
		  <col>
		</colgroup>
		<tr>
		  <th style="vertical-align:top;"><input type="text" id="arrfld_1_ttl" class="o_input" name="arrfld_1_ttl" value="<?php echo set_value('arrfld_1_ttl', $row->arrfld_1_ttl) ?>" style="width:200px; " /></th>
		  <td>
			<textarea id="arrfld_1" name="arrfld_1" style="width:100%; max-width:700px; height:70px;"><?php echo $row->arrfld_1 ?></textarea>
		  </td>
		</tr>
		<tr>
		  <th style="vertical-align:top;"><input type="text" id="arrfld_2_ttl" class="o_input" name="arrfld_2_ttl" value="<?php echo set_value('arrfld_2_ttl', $row->arrfld_2_ttl) ?>" style="width:200px; " /></th>
		  <td>
			<textarea id="arrfld_2" name="arrfld_2" style="width:100%; max-width:700px; height:70px;"><?php echo $row->arrfld_2 ?></textarea>
		  </td>
		</tr>
		</table>
	</div>






  <?php echo form_close(); ?>

</div>


<script type="text/javascript">
$(function(){
	$R('#bo_init_content', { minHeight: '200px' });
	$R('#bo_head_design', { minHeight: '200px' });
	$R('#bo_tail_design', { minHeight: '200px' });
});
</script>
