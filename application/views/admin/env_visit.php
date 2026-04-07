<style>
  .admin_wrap {
    font-size: 13px;
  }
</style>

<div class="admin_wrap">

  <h1>사이트 방문 <?php echo $arr_seg[3] ?></h1>

  <div style="width:100%; margin-right: 10px;">
	<h2><?php echo $arr_seg[3] ?></h2>

	<table class="table table-striped" style="table-layout: fixed;">
	  <thead>
		<tr>
		  <th scope="col" style="width: 45px;">No</th>
		  <th scope="col" style="width: 70px;">datetime</th>
		  <th scope="col" style="width: 20px;">cnt</th>
		  <th scope="col" style="width: 80px;">ip</th>
		  <th scope="col" style="width: 240px;">referer</th>
		  <th scope="col" style="width: 50%;">agent</th>
		</tr>
	  </thead>
	  <tbody>
	<?php
	foreach($result['qry'] as $k => $o) {
	?>
		<tr>
		  <th scope="row"><?php echo number_format($o->num) ?></th>
		  <th scope="row"><?php echo $o->vi_datetime ?></th>
		  <td><?php echo $o->cnt ?></td>
		  <td><?php echo $o->vi_ip ?></td>
		  <td class="white_space_normal"><?php echo $o->vi_referer ?></td>
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