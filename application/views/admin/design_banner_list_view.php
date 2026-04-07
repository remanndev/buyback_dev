<div class=" admin_wrap">

	<h1 style="position:relative;">
		배너 관리 <?php echo isset($this->bn_list_title) ? ' - <span style="font-size:17px; padding:5px 7px; background-color:#dedede;">' .$this->bn_list_title. '</span>' : ''; ?>
		<a href="/admin/design/banner/form"><button type="button" class="btn btn-dark btn-ssm" style="position:absolute; bottom:9px; right:0;" onclick="location.href='/admin/design/banner/form'">배너 등록하기</button></a>
	</h1>

	<!-- <div class="panel panel-default-flat" style="display:none;">
	  <div class="panel-heading">
		<h3 class="panel-title" style="position:relative;">
			배너 코드
			<a href="/admin/design/banner/form"><button type="button" class="btn btn-primary btn-xs" style="position:absolute; top:-2px; right:0;" onclick="location.href='/admin/design/banner/form'">배너 등록하기</button></a>
		</h3>
		
	  </div>
	  <div class="panel-body">
		  <table>
			<colgroup>
			  <col width="80">
			  <col>
			</colgroup>
			<tr>
			  <th><button type="button" class="btn btn-xs btn-primary " style="margin:4px 0 3px;"  disabled="disabled">전체</button></th>
			  <td><a href="/admin/design/banner/lists/all"><button type="button" class="btn btn-primary btn-xs <?php echo ($seg4 === 'all') ? 'active' : '' ?>"  onclick="location.href='/admin/design/banner/lists/all'">전체 보기</button></a></td>
			</tr>
			<?php if($list_cnt['common'] > 0) { ?>
			<tr>
			  <th><button type="button" class="btn btn-xs btn-primary " style="margin:4px 0 3px;"  disabled="disabled">공통</button></th>
			  <td style="padding-top:5px;">
				<?php foreach($list_common as $o) { ?>
				  <a href="/admin/design/banner/lists/common?&bncode=<?php echo $o->bn_code ?>">
					<button type="button" class="btn btn-<?php echo ($bncode == $o->bn_code) ? 'primary' : 'secondary' ?> btn-ssm    <?php echo ($bncode == $o->bn_code) ? 'active' : '' ?>"  onclick="location.href='/admin/design/banner/lists/common?&bncode=<?php echo $o->bn_code ?>'"><?php echo $o->bn_code ?> <hr style="margin:2px 0;border:none; border-bottom: 1px solid silver;" /> <?php echo $o->bn_name ?></button>
				  </a>
				<?php } ?>
			  </td>
			</tr>
			<?php
			  }
			  if($list_cnt['main'] > 0) {
			?>
			<tr>
			  <th><button type="button" class="btn btn-xs btn-primary " style="margin:4px 0 3px;"  disabled="disabled">메인</button></th>
			  <td style="padding-top:5px;">
				<?php foreach($list_main as $o) { ?>
				  <a href="/admin/design/banner/lists/main?&bncode=<?php echo $o->bn_code ?>"><button type="button" class="py-2 btn btn-<?php echo ($bncode == $o->bn_code) ? 'primary' : 'secondary' ?> btn-ssm    <?php echo ($bncode == $o->bn_code) ? 'active' : '' ?>"  onclick="location.href='/admin/design/banner/lists/main?&bncode=<?php echo $o->bn_code ?>'"><?php echo $o->bn_code ?> <hr style="margin:2px 0;border:none; border-bottom: 1px solid silver;" /> <?php echo $o->bn_name ?></button></a>
				<?php } ?>
			  </td>
			</tr>
			<?php
			  }
			  if($list_cnt['sub'] > 0) {
			?>
			<tr>
			  <th><button type="button" class="btn btn-xs btn-primary " style="margin:4px 0 3px;"  disabled="disabled">서브</button></th>
			  <td style="padding-top:5px;">
				<?php foreach($list_sub as $o) { ?>
				  <a href="/admin/design/banner/lists/sub?&bncode=<?php echo $o->bn_code ?>"><button type="button" class="py-2 btn btn-<?php echo ($bncode == $o->bn_code) ? 'primary' : 'secondary' ?> btn-ssm    <?php echo ($bncode == $o->bn_code) ? 'active' : '' ?>"  onclick="location.href='/admin/design/banner/lists/sub?&bncode=<?php echo $o->bn_code ?>'"><?php echo $o->bn_code ?> <hr style="margin:2px 0;border:none; border-bottom: 1px solid silver;" /> <?php echo $o->bn_name ?></button></a>
				<?php } ?>
			  </td>
			</tr>
			<?php
			  }
			  if($list_cnt['etc'] > 0) {
			?>
			<tr>
			  <th><button type="button" class="btn btn-xs btn-primary " style="margin:4px 0 3px;"  disabled="disabled">기타</button></th>
			  <td style="padding-top:5px;">
				<?php foreach($list_etc as $o) { ?>
				  <a href="/admin/design/banner/lists/etc?&bncode=<?php echo $o->bn_code ?>"><button type="button" class="btn btn-<?php echo ($bncode == $o->bn_code) ? 'primary' : 'secondary' ?> btn-ssm    <?php echo ($bncode == $o->bn_code) ? 'active' : '' ?>"  onclick="location.href='/admin/design/banner/lists/etc?&bncode=<?php echo $o->bn_code ?>'"><?php echo $o->bn_code ?> <hr style="margin:2px 0;border:none; border-bottom: 1px solid silver;" /> <?php echo $o->bn_name ?></button></a>
				<?php } ?>
			  </td>
			</tr>
			<?php
			  }
			?>
		  </table>
	  </div>
	</div> -->


	<h2>배너 목록</h2>

	<div class="tbl_basic">
		<table class="table table-hover" style="width:100%;">
			<thead>
			<tr class='text-center'>
			  <th>NO</th>
			  <th>이미지</th>
			  <th>배너 위치</th>
			  <th>배너 코드</th>
			  <th>배너 이름</th>
			  <th>배너 순서</th>
			  <th>배너 크기</th>
			  <th>타겟</th>
			  <th>사용 여부</th>
			  <th>관리</th>
			</tr>
			</thead>
			<tbody>
			<?php foreach ($list as $o): ?>
			<tr class='text-center' style="<?php echo ($o->bn_use != 1) ? 'background-color:#f7f7f7;' : ''; ?>">
			  <td><?php echo $o->num ?></td>
			  <td>
					<?php 
						if($o->bn_image_exist && $o->bn_image_src) {
							//$max_width = ($o->bn_width > 0) ? ' max-width:'.$o->bn_width.'px;' : '';
							echo "<img src='".$o->bn_image_src."' alt='".$o->bn_cate_str." 배너 이미지' title='".$o->bn_cate_str." 배너 이미지' style='width:100%; max-width:100px; height:auto;' class='bn_image_thumb' data-bnid='".$o->bn_id."' />"; 
						}
						else {
							echo "배너 이미지를 등록해주세요.";
						}
					?>
			  </td>
			  <td>[<?php echo $o->bn_cate_str ?>]</td>
			  <td><?php echo $o->bn_code ?></td>
			  <td><?php echo $o->bn_name ?></td>
			  <td></span><?php echo $o->bn_rank ?></td>
			  <td><?php echo $o->bn_width ?> x <?php echo $o->bn_height ?></td>
			  <td><?php echo ($o->bn_target == '_blank') ? '새창 또는 새탭' : '현재 페이지' ?></td>
			  <td><?php echo ($o->bn_use === '1') ? '<strong>사용</strong>' : '사용 안함' ?></td>
			  <td>
				<a href="/admin/design/banner/form/u/<?php echo $o->bn_id ?>"><button type="button" class="btn btn-secondary btn-xs" onclick="location.href='/admin/design/banner/form/u/<?php echo $o->bn_id ?>'">수정</button></a>
				<a href="javascript:post_send('admin/design/banner/delete', {bn_id:'<?php echo $o->bn_id?>'}, true);"><button type="button" class="btn btn-danger btn-xs">삭제</button></a>
			  </td>
			</tr>
			<tr id="bn_big_<?php echo $o->bn_id ?>" class="bn_big_img" style="display: none;">
			  <td colspan="10">
				<div style="">
				<?php 
					if($o->bn_image_exist && $o->bn_image_src) {
						$max_width = ($o->bn_width > 0) ? ' max-width:'.$o->bn_width.'px;' : '';
						echo "<img src='".$o->bn_image_src."' alt='".$o->bn_cate_str." 배너 이미지' title='".$o->bn_cate_str." 배너 이미지' style='width:100%; ".$max_width." height:auto;' />"; 
					}
					else {
						echo "배너 이미지를 등록해주세요.";
					}
				?>
				</div>
			  </td>
			</tr>
			<?php endforeach; ?>
			</tbody>
		</table>


		<!-- <div id="accordion">
			<div class="accordion-item">
			  <div class="item-list">
				<span data-bs-toggle="collapse" data-parent="#accordion" data-bs-target="#collapse1" aria-controls="collapse1">Collapsible Group 11</span>
			  </div>
			  <div id="collapse1" class="collapse in" data-bs-parent="#accordion">
				Lorem ipsum dolor sit amet, consectetur adipisicing elit,
				sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
				quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
			  </div>
			</div>
			<div class="accordion-item">
			  <div class="item-list">
				<span data-bs-toggle="collapse" data-parent="#accordion" data-bs-target="#collapse2" aria-controls="collapse2">Collapsible Group 22</span>
			  </div>
			  <div id="collapse2" class="collapse in" data-bs-parent="#accordion">
				Lorem ipsum dolor sit amet, consectetur adipisicing elit,
				sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
				quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
			  </div>
			</div>
			<div class="accordion-item">
			  <div class="item-list">
				<span data-bs-toggle="collapse" data-parent="#accordion" data-bs-target="#collapse3" aria-controls="collapse3">Collapsible Group 33</span>
			  </div>
			  <div id="collapse3" class="collapse in" data-bs-parent="#accordion">
				Lorem ipsum dolor sit amet, consectetur adipisicing elit,
				sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
				quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
			  </div>
			</div>
		</div> -->


		<div class="clearfix">
			<!-- <button type="button" class="btn btn-info" onclick="slt_check(this.form, '<?php echo ADM_PATH?>/_trans/popup/update')">선택수정</button>
			<button type="button" class="btn btn-danger" onclick="slt_check(this.form, '<?php echo ADM_PATH?>/_trans/popup/delete')">선택삭제</button> -->

			<div class="text-center">
				<?php echo $paging?>
			</div>
		</div>

	</div>

</div>


<script type="text/javascript">
$(document).ready(function(){
	$('.bn_image_thumb').on('click',function(){
		var bn_id = $(this).data('bnid');
		$('#bn_big_'+bn_id).toggle();
	});
});
</script>