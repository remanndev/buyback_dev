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
</style>
<div class="admin_wrap">

  <h1>사이트 방문 통계</h1>

  <div style="width:100%; max-width: 1000px; margin-right: 10px;">
	<h2>방문 통계 LIST</h2>  <small>* 매주 월요일을 기준으로 집계됩니다.</small>
	<table class="table table-striped text-center" style=" border:1px dashed silver;">
	  <thead>
		<tr>
		  <th scope="col">날짜</th>
		  <th scope="col">방문자</th>
		  <th scope="col">페이지뷰</th>
		  <th scope="col" class="bg_total">누적방문자</th>
		  <th scope="col" class="bg_total">누적뷰</th>
		  <th scope="col">[봇] 방문</th>
		  <th scope="col">[봇] 뷰</th>
		  <th scope="col" class="bg_bot_total">[봇] 누적방문</th>
		  <th scope="col" class="bg_bot_total">[봇] 누적뷰</th>
		</tr>
	  </thead>
	  <tbody>
	  <?php foreach($result['qry'] as $k => $o) { ?>
		<tr>
		  <th scope="row"><?php echo $o->monday_week ?></th>
		  <td><?php echo number_format($o->week_visitor) ?></td>
		  <td><?php echo number_format($o->week_view) ?></td>
		  <td class="bg_total"><?php echo number_format($o->total_visitor) ?></td>
		  <td class="bg_total"><?php echo number_format($o->total_view) ?></td>
		  <td><?php echo number_format($o->week_visitor_bot) ?></td>
		  <td><?php echo number_format($o->week_view_bot) ?></td>
		  <td class="bg_bot_total"><?php echo number_format($o->total_visitor_bot) ?></td>
		  <td class="bg_bot_total"><?php echo number_format($o->total_view_bot) ?></td>
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
