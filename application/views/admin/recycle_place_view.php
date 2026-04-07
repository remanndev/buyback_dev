<?php
/** - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
 * 장소 코드 관리 
*/


// 장소 코드 신규 추가
$place_code = array(
	'name'	=> 'pl_code',
	'id'	=> 'pl_code',
	'value' => set_value('pl_code',''),
	'maxlength'	=> 100,
	'class' => 'o_input',
	'style' => 'width: 200px;'
);
$place_name = array(
	'name'	=> 'pl_name',
	'id'	=> 'pl_name',
	'value' => set_value('pl_name',''),
	'maxlength'	=> 100,
	'class' => 'o_input',
	'style' => 'width: 200px;'
);


// [1/2]검색어
$searched_field = $this->input->post('search_field','');
$search_select_options = array(
                  'pl_code'    => '장소 코드',
                  'pl_name'   => '장소 이름'
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
				  'pl_code ASC'     => '장소 코드 ↑',
				  'pl_code DESC'    => '장소 코드 ↓',
				  'pl_name ASC'     => '장소 타이틀 ↑',
                  'pl_name DESC'    => '장소 타이틀 ↓',
                );
?>

<div class=" admin_wrap">


	<h1>장소 코드 관리</h1>

	<h2>장소 신규 등록</h2>

	<?php echo form_open($this->uri->uri_string(), array('id'=>'place_form','name'=>'place_form')); ?>
		<div class="panel panel-default-flat">
			<div class="panel-heading">
				<div style="display:inline-block; vertical-align:top;">
					<label style="font-size:14px;"><span class="" style=" vertical-align:middle; font-weight:bold;">장소코드(영문 소문자, 숫자) : </span></label>
					<input type="hidden" id="duplicate_pl_code" name="duplicate_pl_code" value="<?php echo set_value('duplicate_pl_code','') ?>" />
					<?php echo form_input($place_code); ?>
					<button type="button" class="btn btn-xs btn-dark  check_pl_code">중복 체크</button>
					<?php echo form_error('pl_code', '<div id="err_duplicate_pl_code" class="err_color_red">','</div>'); ?>
				</div>
				<div style="display:inline-block; vertical-align:top; margin-left:30px;">
					<label style="font-size:14px;"><span class="" style=" vertical-align:middle; font-weight:bold;">장소 이름 : </span></label>
					<?php echo form_input($place_name); ?>
					<?php echo form_submit('pl_submit', '신규 등록', 'class="btn btn-xs btn-dark"'); ?>
					<?php echo form_error('pl_name', '<div class="err_color_red">','</div>'); ?>
				</div>
			</div>
		</div>
	<?php echo form_close(); ?>



	<h2>장소 목록</h2>

	<div>
		<small>
			<!-- 검색 <span style="color:red;font-weight:bold;"><?php //echo $result['total_count'] ?></span> 개 /  -->
			전체 <span style="color:red;font-weight:bold;"><?php echo $total_cnt ?></span> 개
		</small>
	</div>
	<hr style="clear:both; margin:0; height:0;" />



	<div class="tbl_basic">
		<table class="table table-hover">
		<thead>
		<tr>
		  <th class='text-center' style="width: 70px;">NO</th>
		  <th class=''>장소 코드</th>
		  <th class=''>QR 코드</th>
		  <th class=''>장소 이름</th>
		  <th class=''>관리자 (등록/수정)</th>
		  <th class=''>등록/수정 일시</th>
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
		  <td><?php echo $o->pl_code ?></td>
		  <td><?php echo $o->qrcode_img ?></td>
		  <td><input type="text" id="saved_pl_name_<?php echo $o->idx ?>" class="o_input" value="<?php echo $o->pl_name ?>" style="width: 300px;" /></td>
		  <td><?php echo $o->admin_info ?></td>
		  <td><?php echo $o->dt_info ?></td>
		  <td class=" text-center">
			<button type="button" class="btn btn-secondary btn-xs  btn_update_code" data-idx="<?php echo $o->idx ?>">수정</button>
			<button type="button" class="btn btn-danger btn-xs"  onclick="del('admin/recycle/del_place/<?php echo url_code($o->pl_code,'e') ?>');">삭제</button>
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

	// 장소 코드 중복 체크
	$('.check_pl_code').click(function(){

			var pl_code = $('#pl_code').val();
			if('' == pl_code) {
				alert('장소코드를 입력해주세요');
				$('#pl_code').focus();
				return false;
			}

			var request = $.ajax({
			  url: "/admin/recycle/duplication_check/",
			  method: "POST",
			  data: { 'check_table': 'recycle_place', 'check_field': 'pl_code', 'check_value' : pl_code  /* , '<?php echo $this->security->get_csrf_token_name() ?>':'<?php echo $this->security->get_csrf_hash() ?>' */},
			  dataType: "html"
			});

			request.done(function( res ) {

			  $('#duplicate_pl_code').val('');
			  if('true' == res) {
				alert('사용 가능한 장소코드입니다.');
				$('#duplicate_pl_code').val(pl_code);
				$('#err_duplicate_pl_code').html('');
				$('#pl_code').css('background-color','#eeeeee');

				return true;
			  }
			  else {
				alert('사용할 수 없는 장소코드입니다.');
				$('#pl_code').val('');
				$('#pl_code').css('background-color','#ffffff');
				$('#pl_code').focus();

				return false;
			  }

			});

			request.fail(function( jqXHR, textStatus ) {
			  alert( "Request failed: " + textStatus );
			  $('#pl_code').val('');
			  $('#pl_code').css('background-color','#ffffff');

			  return false;
			});

	});

	// 장소 코드 업데이트
	$('.btn_update_code').click(function(){

			var pl_idx = $(this).data('idx');
			var pl_name = $('#saved_pl_name_'+pl_idx).val();

			var request = $.ajax({
			  url: "/admin/recycle/edit_place/",
			  method: "POST",
			  data: { 'pl_idx': pl_idx, 'pl_name': pl_name  /* , '<?php echo $this->security->get_csrf_token_name() ?>':'<?php echo $this->security->get_csrf_hash() ?>' */},
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