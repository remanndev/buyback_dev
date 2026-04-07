<?php
/** - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
 * 게시판 그룹 관리
*/

// 그룹 신규 추가
$board_gr_code = array(
	'name'	=> 'gr_code',
	'id'	=> 'gr_code',
	'value' => set_value('gr_code',''),
	'maxlength'	=> 20,
	'class' => 'o_input'
);
$board_gr_title = array(
	'name'	=> 'gr_title',
	'id'	=> 'gr_title',
	'value' => set_value('gr_title',''),
	'maxlength'	=> 20,
	'class' => 'o_input'
);

/*
$gr_admin_select_options = array(
	'1'    => '최고관리자'
);
*/
$gr_admin_select_options = array();
foreach($gr_admin['qry'] as $i => $o) {
	$gr_admin_select_options[$o->id] = $o->nickname;
}
$gr_admin_selected = ($this->input->post('gr_admin')) ? $this->input->post('gr_admin') : '';


// [1/2]검색어
$searched_field = $this->input->post('search_field','');
$search_select_options = array(
                  'gr_code'    => '그룹 코드',
                  'gr_title'   => '그룹명'
                );
$searched_text = $this->input->post('search_text','');
$search_text = array(
	'name'	=> 'search_text',
	'id'	=> 'search_text',
	'value' => ($searched_text) ? $searched_text : set_value('search_text'),
	'maxlength'	=> 20,
	'style'	=> 'width:120px;'
);

// [2/2] 정렬
$order_field = $this->input->post('order_field',FALSE);
$ordered_field = ($order_field) ? $order_field : 'idx DESC';
$order_select_options = array(
				  'gr_code ASC'     => '그룹 코드 ↑',
				  'gr_code DESC'    => '그룹 코드 ↓',
				  'gr_title ASC'     => '그룹 타이틀 ↑',
                  'gr_title DESC'    => '그룹 타이틀 ↓',
                );
?>

<div class=" admin_wrap">


	<h1>게시판 그룹 관리</h1>

	<h2>게시판 그룹 신규 등록</h2>

	<?php echo form_open($this->uri->uri_string(), array('id'=>'group_form','name'=>'group_form')); ?>
		<div class="panel panel-default-flat">
			<div class="panel-heading">
				<div style="display:inline-block; vertical-align:top;">
					<label style="font-size:14px;"><span class="" style=" vertical-align:middle; font-weight:bold;">그룹코드(영문 소문자) : </span></label>
					<input type="hidden" id="duplicate_gr_code" name="duplicate_gr_code" value="<?php echo set_value('duplicate_gr_code','') ?>" />
					<?php echo form_input($board_gr_code); ?>
					<button type="button" class="btn btn-dark btn-xs o_btn  check_gr_code">중복 체크</button>
					<?php echo form_error('gr_code', '<div id="err_duplicate_gr_code" class="err_color_red">','</div>'); ?>
				</div>
				<div style="display:inline-block; vertical-align:top; margin-left:30px;">
					<label style="font-size:14px;"><span class="" style=" vertical-align:middle; font-weight:bold;">그룹명 : </span></label>
					<?php echo form_input($board_gr_title); ?>
					<?php echo form_error('gr_title', '<div class="err_color_red">','</div>'); ?>
				</div>
				<div style="display:inline-block; vertical-align:top; margin-left:30px;">
					<label style="font-size:14px;"><span class="" style=" vertical-align:middle; font-weight:bold;">그룹관리자 : </span></label>
					<?php echo form_dropdown('gr_admin', $gr_admin_select_options, $gr_admin_selected, 'class="o_selectbox"'); ?>
					<?php echo form_submit('gr_submit', '신규 등록', 'class="btn btn-dark btn-xs o_btn"'); ?>
				</div>
			</div>
		</div>
	<?php echo form_close(); ?>



	<h2>게시판 그룹 목록</h2>

	<div>
		<small>
			검색 <span style="color:red;font-weight:bold;"><?php echo $result['total_count'] ?></span> 개 / 전체 <span style="color:red;font-weight:bold;"><?php echo $total_cnt ?></span> 개
		</small>
	</div>
	<hr style="clear:both; margin:0; height:0;" />



	<div class="tbl_basic">
		<table class="table table-hover">
		<thead>
		<tr>
		  <th class='text-center'>NO</th>
		  <th class=''>그룹 코드</th>
		  <th class=''>그룹명</th>
		  <th class=''>그룹 관리자 ID</th>
		  <th class=''>게시판</th>
		  <th class=' text-center'>관리</th>
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
		  <td><?php echo $o->gr_code ?></td>
		  <td><input type="text" id="saved_gr_title_<?php echo $o->idx ?>" class="o_input" value="<?php echo $o->gr_title ?>" /></td>
		  <td>
			<?php //echo $o->gr_admin_fk ?>
			<?php echo form_dropdown('gr_admin', $gr_admin_select_options, $o->gr_admin_fk, 'id="saved_gr_admin_'.$o->idx.'" class="o_selectbox"'); ?>
		  </td>
		  <td>
		  <?php
		  echo '['.$o->board_count.'개] ';
		  foreach($o->board_list as $bno => $board) {
			echo (($bno > 0) ? ', ' : '') . $board->bo_title;
		  }
		  ?>
		  </td>
		  <td class=" text-center">
			<button type="button" class="btn btn-secondary btn-xs  btn_update_group" alt="<?php echo $o->idx ?>">수정</button>
			<button type="button" class="btn btn-danger btn-xs"  onclick="del('admin/board/group_del/<?php echo $o->gr_code ?>');">삭제</button>
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
	$('.check_gr_code').click(function(){

			var gr_code = $('#gr_code').val();
			if('' == gr_code) {
				alert('그룹코드를 입력해주세요');
				$('#gr_code').focus();
				return false;
			}

			var request = $.ajax({
			  url: "/trans/duplication_check/",
			  method: "POST",
			  data: { 'check_table': 'board_group', 'check_field': 'gr_code', 'check_value' : gr_code  /* , '<?php echo $this->security->get_csrf_token_name() ?>':'<?php echo $this->security->get_csrf_hash() ?>' */},
			  dataType: "html"
			});

			request.done(function( res ) {

			  //console.log(res);

			  $('#duplicate_gr_code').val('');
			  if('true' == res) {
				alert('사용 가능한 그룹코드입니다.');
				$('#duplicate_gr_code').val(gr_code);
				$('#err_duplicate_gr_code').html('');
				$('#gr_code').css('background-color','#eeeeee');

				return true;
			  }
			  else {
				alert('사용할 수 없는 그룹코드입니다.');
				$('#gr_code').val('');
				$('#gr_code').css('background-color','#ffffff');
				$('#gr_code').focus();

				return false;
			  }

			});

			request.fail(function( jqXHR, textStatus ) {
			  alert( "Request failed: " + textStatus );
			  $('#gr_code').val('');
			  $('#gr_code').css('background-color','#ffffff');

			  return false;
			});

	});

	// 게시판 그룹 업데이트
	$('.btn_update_group').click(function(){

			var gr_idx = $(this).attr('alt');
			var gr_admin_fk = $('#saved_gr_admin_'+gr_idx).val();
			var gr_title = $('#saved_gr_title_'+gr_idx).val();

			//alert(gr_idx +'/'+ gr_admin_fk +'/'+ gr_title);

			var request = $.ajax({
			  url: "/trans/update_board_group/",
			  method: "POST",
			  data: { 'gr_idx': gr_idx, 'gr_admin_fk': gr_admin_fk, 'gr_title': gr_title  /* , '<?php echo $this->security->get_csrf_token_name() ?>':'<?php echo $this->security->get_csrf_hash() ?>' */},
			  dataType: "html"
			});

			request.done(function( res ) {

			  if('true' == res) {
				alert('업데이트 되었습니다.');
			  }
			  else {
				alert('업데이트에 실패했습니다.');
			  }

			});

			request.fail(function( jqXHR, textStatus ) {
			  alert( "Request failed: " + textStatus );
			});

	});

});
</script>