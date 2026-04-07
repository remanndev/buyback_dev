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

  <h1>SNS 검색 방문 통계</h1>

  <div style="width:100%; max-width: 1000px; margin-right: 10px;">
	<!-- <h2>SNS 검색 방문 통계 LIST</h2> -->
	<table class="table table-striped text-center" style=" border:1px dashed silver;">
	  <thead>
		<tr>
		  <th scope="col">연월</th>
		  <th scope="col">네이버</th>
		  <th scope="col">구글</th>
		  <th scope="col">다음</th>
		</tr>
	  </thead>
	  <tbody>
	  <?php foreach($result['qry'] as $k => $o) { ?>
		<tr>
		  <th scope="row"><?php echo $o->date_month ?></th>
		  <td><?php echo number_format($o->naver_month) ?></td>
		  <td><?php echo number_format($o->google_month) ?></td>
		  <td><?php echo number_format($o->daum_month) ?></td>
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
