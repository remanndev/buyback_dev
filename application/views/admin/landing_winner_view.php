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
	if($arr_seg[4] == 'sb0_2') {
		$page_ttl = '방문예약리스트';
	}
	elseif($arr_seg[4] == 'sb0_3') {
		$page_ttl = '당첨자방문예약리스트';
	}
	else {
		$page_ttl = '관심고객리스트';
	}
?>
<h1><?php echo $page_ttl ?> 관리</h1>


<?php //if($arr_seg[3] == 'winner' && $arr_seg[4] == 'sb0_3') { ?>
<h2>당첨자 목록 엑셀 업로드</h2>

<div class="panel panel-default-flat">
  <div class="panel-heading">
	<div style="position:relative;">
		

		<!-- 당첨자 정보 엑셀 업로드 -->
		<form name="excel_winner_upload" action="<?php echo base_url() ?><?php echo $this->uri->uri_string() ?>" method="post" enctype="multipart/form-data" target="hidden_ifr">
			<a class="btn btn-primary-flat btn-sm" title="성명/공급종류/동/호/전화번호/주택형" href="/files/download/<?php echo url_code('sample', 'e') ?>/winner_upload_sample.xlsx">업로드엑셀 샘플</a>
			<input type="hidden" name="chk_excel" value="upload" />
			<input type="file" name="excel_file" class="o_input" style="border:none; display:inline-block; background-color:#dddddd;" />
			<input type="submit" name="excel_upload_submit" class="o_input" value="엑셀 업로드" />
		</form>

		<!-- 엑셀 업로드 회원정보만 초기화 -->
		<div style="position:absolute;top:0; right:0;">
			<form name="excel_users_truncate" action="<?php echo base_url() ?><?php echo $this->uri->uri_string() ?>" method="post" target="hidden_ifr" onsubmit="return chk_submit();">
				<input type="hidden" name="chk_excel" value="truncate" />
				<input type="submit" name="excel_truncate_submit" value="엑셀업로드데이터삭제" class="o_input"  title="[주의!!!] 클릭하시면 엑셀업로드데이터 정보가 모두 삭제화됩니다." />
			</form>
			<script type="text/javascript">
				function chk_submit() {
					if( confirm('정말 엑셀업로드 정보를 삭제하시겠습니까? 이 결정은 되돌릴 수 없습니다!') ) {
						return true;
					}
					else
						return false;
				}
			</script>
		</div>

		<iframe id="hidden_iframe" name="hidden_ifr" style="width:0; height:0; display: none;"></iframe>


	</div>
  </div>
</div>
<?php //} ?>

<h2>검색</h2>
<?php echo form_open($this->uri->uri_string(), array('id'=>'search_form','name'=>'search_form')); ?>

	<div class="panel panel-default-flat">
	  <div class="panel-heading">
		<div style="display:inline-block; ">
			<?php echo form_dropdown('search_field', $search_select_options, $searched_field, 'class="o_selectbox"'); ?>
			<?php echo form_input($search_text); ?>
			<?php echo form_submit('search', '검색', 'class="btn btn-black-flat btn-xs o_btn" style=""'); ?>
			&nbsp; <?php echo $btn_excel ?>
		</div>
	  </div>
	</div>

	<h2 style="position:relative;">
		<span style="position:relative; float:left;">관리자 목록</span>
		
		<div style="position:relative; float:left; margin-left:25px;">
			검색 <span style="color:red;font-weight:bold;"><?php echo $result['total_count'] ?></span> 명 / 전체 <span style="color:red;font-weight:bold;"><?php echo $total_count_all ?></span> 명
			
		</div>
		<div style="position:absolute; bottom:7px; right:0;">
			<?php //echo form_dropdown('group_fk', $group_select_options, $grouped_fk, 'class="o_selectbox" onchange="document.search_form.submit();" '); ?>
			<?php echo form_dropdown('order_field', $order_select_options, $ordered_field, 'class="o_selectbox" onchange="document.search_form.submit();" '); ?>
		</div>
		<hr style="clear:both; border:none; margin-top:5px; margin-bottom:0;" />
	</h2>


<?php echo form_close(); ?>

<?php //echo $arr_seg[4] ?>


<div class="tbl_frm">
	<table class="table-hover">
	<tr>
	  <th class='bg_f6f6f6 text-center'>NO</th>
	  <th class='bg_f6f6f6'>성명</th>
	  <th class='bg_f6f6f6'>공급종류</th>
	  <th class='bg_f6f6f6'>동</th>
	  <th class='bg_f6f6f6'>호</th>
	  <th class='bg_f6f6f6'>휴대전화</th>
	  <th class='bg_f6f6f6'>주택형</th>
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
	  <td><?php echo $o->name ?></td>
	  <td><?php echo $o->type ?></td>
	  <td><?php echo $o->dong ?></td>
	  <td><?php echo $o->ho ?></td>
	  <td><?php echo $phone_str ?></td>
	  <td><?php echo $o->area ?></td>
	  <td><?php echo substr($o->created,0,16) ?></td>
	  <td><button class="btn btn-danger btn-xs" onclick="del_winner(<?php echo $o->idx ?>);">삭제</button></td>
	</tr>

	<?php
	}
	?>
	</table>
</div>

<div style="text-align:center;"><?php echo $paging ?></div>

<script type="text/javascript">
function del_winner(no) {
	if( confirm('정말 삭제하시겠습니까?\n삭제하신 데이터는 복구할 수 없습니다.') ) {
		location.href = '/admin/landing/winner_del/'+no+'/<?php echo url_code(current_url(),"e") ?>';
	}
}
</script>