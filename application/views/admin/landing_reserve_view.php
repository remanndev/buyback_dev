<?php
/** - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
 * 회원검색
*/

// [1/3]회원 구분
$user_type = $this->input->post('user_type',FALSE);

// [2/3]검색어
//$searched_field = $this->input->post('search_field','');
$searched_field = $like_field;
$search_select_options = array(
                  //'all'    => '통합검색',
                  //'username'    => '아이디',
                  'name'   => '이름',
                  //'email'       => '이메일',
                  'phone'  => '휴대전화',
                );
//$searched_text = $this->input->post('search_text','');
$searched_text = $like_match;
$search_text = array(
	'name'	=> 'search_text',
	'id'	=> 'search_text',
	'value' => ($searched_text) ? $searched_text : set_value('search_text'),
	'maxlength'	=> 20,
	'class'	=> 'o_input'
);

// [3/3] 정렬
$order_field = $this->input->post('order_field',FALSE);
//$ordered_field = ($order_field) ? $order_field : 'users.created DESC';
$ordered_field = ($order_field) ? $order_field : $srh_order_field;



$order_select_options = array(
				  'rsv_date ASC, rsv_part ASC'  => '예약일자 ↑',
				  'rsv_date DESC, rsv_part DESC'  => '예약일자 ↓',
				  'name ASC'     => '이름 ↑',
				  'name DESC'    => '이름 ↓',
				  'phone ASC'     => '휴대전화 ↑',
                  'phone DESC'    => '휴대전화 ↓',
                  'created ASC'           => '등록일자 ↑',
                  'created DESC'          => '등록일자 ↓',
                );



// [4/3] 회원 구분
/*
$group_fk = $this->input->post('group_fk',FALSE);
$grouped_fk = ($group_fk) ? $group_fk : $srh_group_fk;
$group_select_options = array(
			  ''    => '전체',
			  '3'    => '준회원',
			  '5'     => '정회원',
			  '7'     => '사이트매니저',
			  '9'     => '관리자'
                );
*/
?>
<?php //$page_ttl = ($arr_seg[4] == 'sb0_2') ? '방문예약리스트' : '관심고객리스트';  ?>
<?php 
	/*
	if($arr_seg[4] == 'rsv') {
		$page_ttl = '방문예약리스트';
	}
	elseif($arr_seg[4] == 'sb0_3') {
		$page_ttl = '당첨자방문예약리스트';
	}
	else {
		$page_ttl = '관심고객리스트';
	}
	*/
	$page_ttl = '방문예약리스트';
?>
<h1><?php echo $page_ttl ?> 관리</h1>



<h2>검색</h2>
<?php echo form_open($this->uri->uri_string(), array('id'=>'search_form','name'=>'search_form')); ?>

	<div class="panel panel-default-flat">
	  <div class="panel-heading">
		<div style="display:inline-block; ">
			<?php echo form_dropdown('search_field', $search_select_options, $searched_field, 'class="o_selectbox"'); ?>
			<?php echo form_input($search_text); ?>
			<?php echo form_submit('search', '검색', 'class="btn btn-dark btn-xs " style=""'); ?>
			&nbsp; <?php echo $btn_excel ?>
		</div>
	  </div>
	</div>

	<h2 style="position:relative;">
		<span style="position:relative; float:left;">목록</span>
		
		<div style="position:relative; float:left; margin-left:25px;">
			검색 <span style="color:red;font-weight:bold;"><?php echo $result['total_count'] ?></span> 명 / 전체 <span style="color:red;font-weight:bold;"><?php echo $total_count_all ?></span> 명
			
		</div>
		<div style="position:absolute; bottom:7px; right:0;">
			<?php //echo form_dropdown('group_fk', $group_select_options, $grouped_fk, 'class="o_selectbox" onchange="document.search_form.submit();" '); ?>
			<?php echo form_dropdown('order_field', $order_select_options, $ordered_field, 'class="o_selectbox" onchange="document.search_form.submit();" '); ?>
		</div>
		<hr style="clear:both; border:none; margin-top:5px; margin-bottom:0; height:0;" />
	</h2>


<?php echo form_close(); ?>

<?php //echo $arr_seg[4] ?>


<div class="tbl_frm">
	<table class="table-hover">
	<tr>
	  <th class='bg_f6f6f6 text-center'>NO</th>
	  <!-- <th class='bg_f6f6f6'>구분</th> -->
	  <th class='bg_f6f6f6'>이름</th>
	  <th class='bg_f6f6f6'>휴대전화</th>
	  <?php if($arr_seg[4] == 'sb0_1') { ?>
	  <th class='bg_f6f6f6'>주소</th>
	  <?php } elseif($arr_seg[4] == 'sb0_2' OR $arr_seg[4] == 'sb0_3') { ?>
	  <th class='bg_f6f6f6'>동반인</th>
	  <th class='bg_f6f6f6'>예약 날짜 / 시간 파트</th>
	  <?php } ?>
	  <th class='bg_f6f6f6'>등록일</th>
	  <th class='bg_f6f6f6' style="width:100px;">관리</th>
	</tr>
	<?php
	foreach($result['qry'] as $i => $o)
	{
		// 번호
		$num = ($result['total_count'] - $limit*($page-1) - $i);

		$phone = array();
		$phone[0] = substr($o->phone,0,3);
		$phone[1] = substr($o->phone,3,4);
		$phone[2] = substr($o->phone,7,4);
		$phone_str = implode('-',$phone);
	?>

	<tr>
	  <td class="text-center"><?php echo $num ?></td>
	  <!-- <td><?php //echo $group_type ?></td> -->
	  <td><?php echo $o->name ?></td>
	  <td><?php echo $phone_str ?></td>
	  <?php if($arr_seg[4] == 'sb0_1') { ?>
	  <td>
		<div><?php echo $o->postcode ?></div>
		<div><?php echo $o->addr ?> <?php echo $o->addr_detail ?></div>
	  </td>
	  <?php } elseif($arr_seg[4] == 'sb0_2' OR $arr_seg[4] == 'sb0_3') { ?>
	  <td><?php echo $o->partner ?> 명</td>
	  <td>
		<div><?php echo $o->rsv_date ?> / <?php echo $o->rsv_part ?></div>
	  </td>
	  <?php } ?>
	  <td><?php echo substr($o->created,0,16) ?></td>
	  <td><button class="btn btn-danger btn-xs" onclick="del_rsv(<?php echo $o->idx ?>);">삭제</button></td>
	</tr>

	<?php
	}
	?>
	</table>
</div>

<div style="text-align:center;"><?php echo $paging ?></div>

<script type="text/javascript">
function del_rsv(no) {
	if( confirm('정말 삭제하시겠습니까?\n삭제하신 데이터는 복구할 수 없습니다.') ) {
		location.href = '/admin/landing/reserve_del/'+no+'/<?php echo url_code(current_url(),"e") ?>';
	}
}
</script>