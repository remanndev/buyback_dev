<h2>2025년 10월</h2>
<h4>완료되지 못한 건들</h4>

<table class="table table-hover dn_detail_list" style="width:100%;">
	<tr>
	  <th class='text-center'>NO</th>
	  <th class='text-center'>캠페인</th>
	  <th class='text-center'>번호</th>
	  <th class='text-center'>이름</th>
	  <th class='text-center'>연락처</th>
	  <th class='text-center'>이메일</th>
	  <th class='text-center'>기부일시</th>
	  <th class='text-center'>상태</th>
	  <th class='text-center'>품목</th>
	  <th class='text-center'>수량</th>
	</tr>

	<?php

	$dn_idx_pre = '';
	$dn_idx = '';

	$cmp_code = '';

	$dn_name = '';
	$dn_phone = '';
	$dn_email = '';
	$dn_dt = '';

	foreach($result['qry'] as $i => $row) {
		$num = ($result['qry_count'] - $i);

		if($row->idx == $dn_idx_pre) {
			$dn_idx = '';
			$dn_idx_pre = $row->idx;

			$cmp_code = '';

			$dn_name = '';
			$dn_phone = '';
			$dn_email = '';
			$dn_dt = '';

		}
		else {
			$dn_idx = $row->idx;
			$dn_idx_pre = $row->idx;

			$cmp_code = $row->cmp_code;

			$dn_name = $row->donor_name;
			$dn_phone = $row->cellphone;
			$dn_email = $row->email;
			$dn_dt = $row->reg_datetime;

		}


		if('1' == $row->state_handout_finish  &&  '' != $row->handout_finish_date) {
			//$state_step = '<span class="btn btn-primary btn-xs  allow-select" style="pointer-events: none;">완료</span>';
			$state_step = "완료";
		}
		else if('' != $row->check_date) {
			// $inspDate
			$state_step = "검수";
			//$state_step = '<span class="btn btn-success btn-xs  allow-select" style="pointer-events: none;">검수</span>';
		}
		else if('' != $row->pickup_date) {
			// $whDate
			$state_step = "수거";
			//$state_step = '<span class="btn btn-secondary btn-xs  allow-select" style="pointer-events: none;">수거</span>';
		}
		else if('' != $row->reg_datetime) {
			$state_step = "접수";
			//$state_step = '<span class="btn btn-outline-secondary btn-xs  allow-select" style="pointer-events: none;">접수</span>';
		}

	?>
	<tr>
	  <td class='text-center'><?php echo $num; ?></td>
	  <td class='text-center'><?php echo $cmp_code ?></td>
	  <td class='text-center'><?php echo $dn_idx ?></td>
	  <td class='text-center'><?php echo $dn_name ?></td>
	  <td class='text-center'><?php echo $dn_phone ?></td>
	  <td class='text-center'><?php echo $dn_email ?></td>
	  <td class='text-center'><?php echo $dn_dt ?></td>
	  <td class='text-center'><?php echo $state_step ?></td>
	  <td class='text-center'><?php echo $row->gd_type ?></td>
	  <td class='text-center'><?php echo $row->gd_amt ?></td>
	</tr>
	<?php } ?>

</table>
