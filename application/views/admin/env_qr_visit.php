<style>
  .admin_wrap {
    font-size: 13px;
  }

  .admin_wrap th { border-top: 1px solid silver;}
  .admin_wrap th,
  .admin_wrap td {
	border-left: 1px dashed silver;
  }
  .admin_wrap th:last-child,
  .admin_wrap td:last-child {
	border-right: 1px dashed silver;
  }
</style>

<div class="admin_wrap">

  <h1 class="dsp_flex">
	<div>QR 코드 방문</div>
	<small style="margin-left: 15px; font-size: 14px; font-family: verdana; letter-spacing: 0.05rem; display: inline-block; padding: 3px 7px; background-color:#e9e9f3;  ">[링크 예시] https://replus.kr/access?from=<span style="color: red;font-weight: bold;">google</span></small>
  </h1>

  <div style="width:100%; margin-right: 10px;">
	<h2><?php echo $arr_seg[3] ?></h2>

	<table class="table table-striped" style="table-layout: fixed;">
	  <thead>
		<tr>
		  <th scope="col" style="width: 50px;">No</th>
		  <th scope="col" style="width: 100px;">datetime</th>
		  <th scope="col" style="width: 130px;">QR</th>
		  <th scope="col" style="width: 60px;">cnt</th>
		  <th scope="col" style="width: 130px;">ip</th>
		  <!-- <th scope="col" style="width: 240px;">referer</th> -->
		  <th scope="col">agent</th>
		</tr>
	  </thead>
	  <tbody>
	<?php
	foreach($result['qry'] as $k => $o) {
	?>
		<tr>
		  <th scope="row"><?php echo number_format($o->num) ?></th>
		  <th scope="row"><?php echo $o->vi_datetime ?></th>
		  <td><?php echo $o->acc_from ?></td>
		  <td><?php echo $o->cnt ?></td>
		  <td><?php echo $o->vi_ip ?></td>
		  <!-- <td class="white_space_normal"><?php //echo $o->vi_referer ?></td> -->
		  <td class="white_space_normal"><?php echo $o->vi_agent ?></td>
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