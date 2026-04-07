<?php
	//  요일
	$arr_date = array("일","월","화","수","목","금","토");
?>
<style>

  .admin_wrap {
    font-size: 13px;
  }

  .admin_wrap tr th:nth-child(1) {background-color: #f3f3f3; width: 120px; } 
  .admin_wrap tr th { border-right:1px dashed silver; }
  .admin_wrap tr td { border-left:1px dashed silver; }

  th.bg_total { background-color: #f7f7fb; }
  th.bg_bot { background-color: #fdfffb; }
  th.bg_bot_total { background-color: #f7f7fb; }

  td.bg_total { background-color: #f7f7fb; }
  td.bg_bot { background-color: #fdfffb; }
  td.bg_bot_total { background-color: #f7f7fb; }

  .admin_wrap tr th,
  .admin_wrap tr td { border-top: 1px dashed silver; border-bottom: none; }
  .admin_wrap tr.line_gubun th,
  .admin_wrap tr.line_gubun td { border-top: 1px solid red; border-bottom: none; }

  .admin_wrap thead tr th { border-bottom:1px solid silver; }
</style>
<div class="admin_wrap">

  <h1 class="dsp_flex">
	<div>QR 일간 방문 통계</div>
	<small style="margin-left: 15px; font-size: 14px; font-family: verdana; letter-spacing: 0.05rem; display: inline-block; padding: 3px 7px; background-color:#e9e9f3;  ">[링크 예시] https://replus.kr/access?from=<span style="color: red;font-weight: bold;">google</span></small>
  </h1>

  <div style="width:100%; max-width: 1000px; margin-right: 10px;">
	<h2>방문 통계 LIST</h2>
	<table class="table table-striped text-center" style=" border:1px dashed silver;">
	  <thead>
		<tr>
		  <th scope="col">날짜</th>
		  <th scope="col">QR 구분</th>
		  <!-- <th scope="col">방문자수</th> -->
		  <th scope="col">당일 페이지뷰</th>
		  <!-- <th scope="col" class="bg_total">누적방문자수</th> -->
		  <th scope="col" class="bg_total">누적 페이지뷰</th>
		</tr>
	  </thead>
	  <tbody>
	  <?php 
	  $chk_date = false;
	  $css_border='';
	  foreach($result['qry'] as $k => $o) {
		  if( $chk_date !== $o->date ) {
			  $chk_date = $o->date;
			  if($k > 0)
				$css_border='line_gubun';
		  }
		  else {
			  $css_border='';
		  }
	  ?>
		<tr class="<?php echo $css_border ?>">
		  <th scope="row"><?php echo $o->date ?> (<?php echo $arr_date[date('w', strtotime($o->date))] ?>)</th>
		  <td><?php echo $o->acc_from ?></td>
		  <!-- <td><?php //echo number_format($o->today_visitor) ?></td> -->
		  <td><?php echo number_format($o->today_view) ?></td>
		  <!-- <td class="bg_total"><?php //echo number_format($o->total_visitor) ?></td> -->
		  <td class="bg_total"><?php echo number_format($o->total_view) ?></td>
		</tr>
	  <?php } ?>
	  </tbody>
	</table>
	<div class="row">
	  <div class="col-md-12 text-center mb-4">
		<?php echo $paging ?>
	  </div>
	</div>
  </div>

</div>
