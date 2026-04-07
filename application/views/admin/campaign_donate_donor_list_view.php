<?php
//  print_r($donor_list);
/** - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
 * 검색
*/
// [1] 검색필드
	$sfl_select_options = array(
		'cmp_title'    => '캠페인명',
		'donor_name'   => '기부자명',
		'cellphone'   => '연락처',
		'email'   => '이메일'
	);
// [2] 검색어
	$search_text = array(
		'name'	=> 'stx',
		'id'	=> 'stx',
		'value' => ($stx) ? $stx : set_value('stx'),
		'maxlength'	=> 20,
		'class'	=> 'o_input'
	);
?>

<style type="text/css">
.dn_list { width: 100%; /*max-width: 1800px; */}
.dn_list tr th { background-color: #6d6d6d; color:#ffffff; }
.dn_list tr.dn_list_row td { background-color: #fafafa; color: #474747; font-size: 15px; border-bottom: 1px dashed #ccc; }
/*
.dn_detail_list {}
.dn_detail_list tr th, .dn_detail_list tr td { font-size: 15px; }
.dn_detail_list tr th { line-height: 20px !important; padding:5px 10px !important; background-color: #f8f8f8; border-top: 1px solid #ccc; color:#363636;  font-size: 15px;}
.dn_detail_list tr td { line-height: 15px !important; padding:3px 10px !important;  font-size: 14px; border-bottom: 1px dashed #ccc; }
*/
.cmp_first {}
.cmp_first td { background-color: #eeeeee !important; border-top: 1px solid #ccc; /* border-bottom: 1px dashed #ccc; */ }

.cmp_bgcolor_0 td {background-color: #ffffff !important;}
.cmp_bgcolor_1 td {background-color: #f8f8f8 !important;}
</style>

<h1>기부자 목록</h1>





	<?php 
	echo form_open($this->uri->uri_string(), array('id'=>'search_form','name'=>'search_form','method'=>'get'));
	?>
		<h2>검색</h2>

		<div class="panel panel-default-flat">
		  <div class="panel-heading">
			<div style="display:inline-block; ">
				<?php echo form_dropdown('sfl', $sfl_select_options, $sfl, 'class="o_selectbox"'); ?>
				<?php echo form_input($search_text); ?>
				<button type="submit" class="btn btn-dark btn-xs">검색</button>
			</div>
		  </div>
		</div>
	<?php echo form_close(); ?>



<h2 class="mb_40" style="color:#353535;">캠페인별 기부자 목록 <small>(기부일자 기준 정렬)</small></h2>
<div class="tbl_frm" style="border:none;">
	<table class="dn_list">
	<tr>
	  <th class='text-center'>NO</th>
	  <th class='text-center'>캠페인코드</th>
	  <th class='text-center'>캠페인명</th>
	  <th class='text-center'>기부가치</th>
	  <th class='text-center'>기부자명</th>
	  <th class='text-center' style="width: 150px;">연락처</th>
	  <th class='text-center'>이메일</th>
	  <th class='text-center' style="width: 120px;">기부일자</th>
	  <th class='text-center'>영수증신청</th>
	  <th class='text-center' style="width: 120px;">관리자 확인일시</th>
	</tr>
	<?php
	$cmpcd = '';
	$bgno = 0;

	foreach($donor_list as $i => $o) {
		//$tr_bordertop = ($cmpcd != $o->cmp_code) ? 'border-top: 1px solid red;' : '';

		if($cmpcd != $o->cmp_code) {
			$cmpcd = $o->cmp_code;
			$bgno++;
		}
		$tr_bg = ($bgno%2 == 1) ? 'cmp_bgcolor_0' : 'cmp_bgcolor_1';

		// 번호
		$num = ($result['total_count'] - $limit*($page-1) - $i);

	?>
	<tr class="dn_list_row <?php echo $tr_bg ?>">
	  <td class="text-center"><?php echo $num ?></td>
	  <td class="text-center"><?php echo $o->cmp_code ?></td>
	  <td class=""><?php echo $o->cmp_title ?></td>
	  <td class="text-center"><?php echo number_format($o->donation_value) ?></td>
	  <td class="text-center"><?php echo $o->donor_name ?></td>
	  <td class="text-center"><?php echo $o->donor_phone ?></td>
	  <td class="text-center"><?php echo $o->donor_email ?></td>

	  <td class="text-center"><?php echo $o->reg_date ?></td>
	  <td class="text-center"><?php echo (isset($o->receipt_req_date) && '' != $o->receipt_req_date) ? $o->receipt_req_date : ''; ?></td>
	  <td class="text-center"><?php echo $o->mng_chk ?></td>
	</tr>
	<?php } ?>
	</table>

	<div class="dn_list" style="text-align:center;"><?php echo $paging ?></div>

</div>
