<?php
// 게시판 등록
$new_board_code = array(
	'name'	=> 'new_bo_code',
	'id'	=> 'new_bo_code',
	'value' => set_value('new_bo_code',''),
	'maxlength'	=> 20,
	'class' => 'o_input',
	'placeholder' => '영문 소문자'
);
$new_board_title = array(
	'name'	=> 'new_bo_title',
	'id'	=> 'new_bo_title',
	'value' => set_value('new_bo_title',''),
	'maxlength'	=> 20,
	'class' => 'o_input',
	'placeholder' => '한글,영문,숫자'
);

$gr_select_options = array();
foreach($gr_result['qry'] as $i => $o) :
  $gr_select_options[$o->gr_code] = $o->gr_title;
endforeach;
$gr_selected = ($this->input->post('gr_code')) ? $this->input->post('gr_code') : '';



/*
$new_board_type_select_options = array(
	'basic'       => '기본 게시판',
	'webzine'     => '웹진 게시판',
	'video'     => '영상 게시판',
	'gallery'     => '갤러리',
	'blog'        => '블로그형',
	'hello'       => '헬로부산형',
	'inquiry'         => '문의게시판',
	'faq'         => 'FAQ',
	'consult'     => '빠른상담',
	'tag'     => '태그형',
);
*/
$new_board_type_select_options = $arr_bbskin;
$new_board_type_selected = ($this->input->post('new_bo_type')) ? $this->input->post('new_bo_type') : '';



/** - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
 * 검색
*/
// [1] 검색필드
	$sfl_select_options = array(
		'bo_code'    => '게시판 코드',
		'bo_title'   => '게시판 제목'
	);
// [2] 검색어
	$search_text = array(
		'name'	=> 'stx',
		'id'	=> 'stx',
		'value' => ($stx) ? $stx : set_value('stx'),
		'maxlength'	=> 20,
		'class'	=> 'o_input'
	);

/** - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
 * 정렬
*/
	$ofl_select_options = array(
		'bconf.bo_code DESC'    => '게시판 코드 ↓',
		'bconf.bo_code ASC'     => '게시판 코드 ↑',
		'bconf.bo_title DESC'    => '게시판 제목 ↓',
		'bconf.bo_title ASC'     => '게시판 제목 ↑',
		'bgrp.gr_title DESC'    => '그룹명 ↓',
		'bgrp.gr_title ASC'     => '그룹명 ↑',
	);

?>

<div class=" admin_wrap">

	<h1>게시판 관리</h1>

	<?php if('sadmin' === $this->username){ ?>

	<h2>게시판 신규 등록</h2>
	<?php echo form_open($this->uri->uri_string(), array('id'=>'board_form','name'=>'board_form')); ?>
		<div class="panel panel-default-flat">
		  <div class="panel-heading">
			  <div style="display:inline-block; vertical-align:top;">
				<label style="font-size:13px; "><span class="" style="font-size:13px; vertical-align:middle; font-weight:bold;">그룹선택 : </span></label>
				<?php echo form_dropdown('gr_code', $gr_select_options, $gr_selected, 'class="o_selectbox"'); ?>
			  </div>
			  <div style="display:inline-block; vertical-align:top; margin-left:30px;">
				<label style="font-size:13px;"><span class="" style="font-size:13px; vertical-align:middle; font-weight:bold;">게시판 코드 : </span></label>
				<input type="hidden" id="duplicate_bo_code" name="duplicate_bo_code" value="<?php echo set_value('duplicate_bo_code','') ?>" />
				<?php echo form_input($new_board_code); ?>
				<button type="button" class="btn btn-dark btn-xs o_btn  check_bo_code">중복 체크</button>
				<?php echo form_error('new_bo_code', '<div id="err_duplicate_bo_code" class="err_color_red" style="padding-top:3px;">','</div>'); ?>

			  </div>
			  <div style="display:inline-block; vertical-align:top;  margin-left:30px;">
				<label style="font-size:13px;"><span class="" style="font-size:13px; vertical-align:middle; font-weight:bold;">게시판 제목 : </span></label>
				<?php echo form_input($new_board_title); ?>
				<?php echo form_error('new_bo_title', '<div class="err_color_red" style="padding-top:3px;">','</div>'); ?>
			  </div>
			  <div style="display:inline-block; vertical-align:top;  margin-left:30px;">
				<label style="font-size:13px;"><span class="" style="font-size:13px; vertical-align:middle; font-weight:bold;">유형 : </span></label>
				<?php echo form_dropdown('new_bo_type', $new_board_type_select_options, $new_board_type_selected, 'class="o_selectbox"'); ?>
			  </div>

			  <div style="display:inline-block; vertical-align:top; ">
				<?php echo form_submit('new_bo_submit', '만들기', 'class="btn btn-dark btn-xs o_btn"'); ?>
			  </div>
		  </div>
		</div>
	<?php echo form_close(); ?>


	<h2>게시판 검색</h2>
	<?php echo form_open($this->uri->uri_string(), array('id'=>'search_form','name'=>'search_form','method'=>'GET')); ?>
		<div class="panel panel-default-flat">
		  <div class="panel-heading">
				<label style="font-size:13px;vertical-align:baseline;"><span class="" style="font-size:13px; line-height:24px; display:inline-block; font-weight:bold;">검색어</span>  : </label>
				<?php echo form_dropdown('sfl', $sfl_select_options, $sfl, 'class="o_selectbox"'); ?>
				<?php echo form_input($search_text); ?>
				<?php echo form_submit('search', '검색', 'class="btn btn-dark btn-xs o_btn"'); ?>
		  </div>
		</div>
	<?php echo form_close(); ?>

	<?php } ?>







	<h2>게시판 목록</h2>

	<?php echo form_open($this->uri->uri_string(), array('id'=>'order_form','name'=>'order_form','method'=>'GET')); ?>
		<div>
			<small>
				검색 <span style="color:red;font-weight:bold;"><?php echo $result['total_count'] ?></span> 개 / 전체 <span style="color:red;font-weight:bold;"><?php echo $total_cnt ?></span> 개
			</small>
			<div style="position:absolute; bottom:4px; right:0;">
				<?php echo form_dropdown('ofl', $ofl_select_options, $ofl, 'class="o_selectbox"   onchange="document.order_form.submit();" '); ?>
			</div>
		</div>
		<hr style="clear:both; margin:0; height:0;" />
	<?php echo form_close(); ?>


	<div class="tbl_basic">
		<table class="table table-hover">
		<thead>
		<tr>
		  <th class='text-center'>NO</th>
		  <!-- <th class='text-center'>그룹ID</th> -->
		  <th class='text-center'>그룹명</th>
		  <th class=''>게시판 코드</th>
		  <th class=''>게시판 제목</th>
		  <th class=''>유형</th>
		  <!-- <th class=''>최신글</th>
		  <th class=''>전체글</th> -->
		  <th class='text-center'>담당자</th>
		  <th class='text-center' style="width:120px;">관리</th>
		</tr>
		</thead>
		<tbody>
		<?php
		foreach($result['qry'] as $i => $o)
		{
			// 번호
			$num = ($result['total_count'] - $limit*($page-1) - $i);
		?>
		<tr>
		  <td class="text-center"><?php echo $num ?></td>
		  <!-- <td class='text-center'>[<?php //echo $o->gr_code ?>]</td> -->
		  <td class='text-center'><?php echo $o->gr_title ?></td>
		  <td><?php echo $o->bo_code ?></td>
		  <td><?php echo $o->bo_title ?></td>
		  <td><?php echo $new_board_type_select_options[$o->bo_type] ?></td>
		  <!-- <td><?php //echo isset($o->bo_cnt_write_recent) ? $o->bo_cnt_write_recent : '0' ?></td>
		  <td><?php //echo $o->bo_cnt_write ?></td> -->
		  <td class="text-center" style="text-align:center;">
			<?php echo $o->bo_admin_nickname ?>
		  </td>
		  <td class="text-center">
			<a href="/admin/board/edit/<?php echo $o->bo_code ?>"><button type="button" class="btn btn-secondary btn-xs" alt="<?php echo $o->bo_code ?>">수정</button></a>
			<a href="/admin/board/board_del/<?php echo $o->bo_code ?>" onclick="del_confirm('admin/board/board_del/<?php echo $o->bo_code ?>'); return false;"><button type="button" class="btn btn-danger btn-xs">삭제</button></a>
		  </td>
		</tr>
		<?php
		}
		?>
		</tbody>
		</table>
	</div>
	<div style="text-align:center;"><?php echo $paging ?></div>

</div>

<script type="text/javascript">
$(document).ready(function(){

	// 게시판 그룹 중복 체크
	$('.check_bo_code').click(function(){

			var new_bo_code = $('#new_bo_code').val();
			if('' == new_bo_code) {
				alert('게시판 코드를 입력해주세요');
				$('#new_bo_code').focus();
				return false;
			}

			var request = $.ajax({
			  url: "/trans/duplication_check/",
			  method: "POST",
			  data: { 'check_table': 'board_config', 'check_field': 'bo_code', 'check_value' : new_bo_code  /* , '<?php echo $this->security->get_csrf_token_name() ?>':'<?php echo $this->security->get_csrf_hash() ?>' */},
			  dataType: "html"
			});

			request.done(function( res ) {
			  $('#duplicate_bo_code').val('');
			  if('true' == res) {
				alert('사용 가능한 게시판 코드입니다.');
				$('#duplicate_bo_code').val(new_bo_code);
				$('#err_duplicate_bo_code').html('');
				$('#new_bo_code').css('background-color','#eeeeee');

				return true;
			  }
			  else {
				alert('사용할 수 없는 게시판 코드입니다.');
				$('#new_bo_code').val('');
				$('#new_bo_code').css('background-color','#ffffff');
				$('#new_bo_code').focus();

				return false;
			  }

			});

			request.fail(function( jqXHR, textStatus ) {
			  alert( "Request failed: " + textStatus );
			  $('#new_bo_code').val('');
			  $('#new_bo_code').css('background-color','#ffffff');

			  return false;
			});

	});



});
</script>