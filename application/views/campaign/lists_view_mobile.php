<?php

	// [1] 분류 - 캠페인 카테고리 배열
	$arr = array('sql_select' => '*','sql_from' => 'campaign_cate','sql_where' => array('use'=>'Y'), 'sql_order_by'=>'order ASC');
	$result_cate = $this->basic_model->arr_get_result($arr);

	$ca_code_options = array('' => '분류');
	foreach($result_cate['qry'] as $i=>$cate) {
		$ca_code_options[$cate->cate_name] = $cate->cate_name;
	}

	$cate_name_selected =  isset($cate_name) ? $cate_name : set_value('cate_name');
	$cate_name_selected = ('' != $cate_name_selected) ? $cate_name_selected : '분류';

	$cate_name_selected_val = ('' != $cate_name_selected && '분류' != $cate_name_selected ) ? $cate_name_selected : '';


	// [2] 정렬
	$ofl = $this->input->get('ofl',FALSE);
	$ordered_selected = ($ofl) ? $ofl : 'reg_datetime DESC';
	//echo $ordered_selected.'<<<<';
	$order_select_options = array(
					  'reg_datetime DESC'    => '등록일자 최신순',
					  'reg_datetime ASC'     => '등록일자 오래된순',

					  'cmp_term_end DESC'     => '종료임박',
					  'visit_cnt DESC'     => '조회수',
					);

	$ordered_selected_txt = isset($order_select_options[$ordered_selected]) ? $order_select_options[$ordered_selected] : '정렬';
	$ordered_selected_val = $ordered_selected;

?>
<style type="text/css">
.cmp_list > div {
	padding: 6px;
	transition: all 0.2s;
}
.cmp_list > div:hover {
	background-color: #58ae31;
}
.cmp_list > div > a {
	display: block;
	background-color: #ffffff;
}
</style>

<?php
if( ! empty($top_bnr_mobile) ) {
?>

	<!-- 캠페인 탑 비주얼 배너 영역 -->
	<div class="bnr_wrap">
	 <div class="wrap_cmplist_top_bnr_mobile">
	  <?php foreach($top_bnr_mobile as $i => $bnr) { ?>
		<div class="list_top_bnr" style="background-image:url('<?php echo $bnr->banner_src ?>'); ">
			<div class="txt"><?php echo nl2br($bnr->bn_memo) ?></div>
		</div>
	  <?php } ?>
	 </div>
	</div>
	<script type="text/javascript">
	$(document).ready(function(){
	  $('.wrap_cmplist_top_bnr_mobile').not('.slick-initialized').slick({
		  infinite: true,
		  speed: 500,
		  fade: true,
		  cssEase: 'linear',
		  arrows: false,
		  dots: false,
		  autoplay: true,
		  autoplaySpeed: 5000,
	  });
	});
	</script>

<?php 
}
?>

	<div class="cmp_wrap">
	  <div class="main_sect">
		<div class="main_ctnt">

		  <div style="position: relative; width: 100%; ">

			<h3 class="cmp_subject">
				<a class="<?php echo ($term == 'ended') ? '' : 'active'; ?>" href="/campaign/lists">진행중인 캠페인</a> <span>|</span> <a class="<?php echo ($term == 'ended') ? 'active' : ''; ?>" href="/campaign/lists?term=ended">종료된 캠페인</a>
			</h3>

			<hr class="cmp_subject_line" />

			<?php echo form_open($this->uri->uri_string(), array('id'=>'search_form','name'=>'search_form','method'=>'get', 'style'=>'position:relative; right:0; top:5px;')); ?>
				<input type="hidden" name="term" value="<?php echo $term ?>" />
				<div class="d-flex" style="position:relative; vertical-align:bottom; min-height:32px;">

					<!-- 분류 -->
					<div id="cate_dropdown" class="dropdown" style="display:inline-block; margin-right:5px; ">
					  <button class="btn btn-secondary btn-ssm dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
						<?php echo $cate_name_selected ?>
					  </button>
					  <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton1">
					  <?php foreach($ca_code_options as $cate_val => $cate_txt) { ?>
						<li class="dropdown-menu-cate-item" data-value="<?php echo $cate_txt ?>"><a class="dropdown-item" href="#" style="font-size:13px;" alt="<?php echo $cate_txt ?>"><?php echo $cate_txt ?></a></li>
					  <?php } ?>
					  </ul>
					</div>
					<input type="hidden" id="cate" name="cate" value="<?php echo $cate_name_selected_val ?>" />



					<div id="order_dropdown" class="dropdown" style="display:inline-block; ">
					  <button class="btn btn-secondary btn-ssm dropdown-toggle" type="button" id="dropdownMenuButton2" data-bs-toggle="dropdown" aria-expanded="false">
						<?php echo $ordered_selected_txt ?>
					  </button>
					  <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton2">
					  <?php foreach($order_select_options as $order_val => $order) { ?>
						<li class="dropdown-menu-order-item" data-value="<?php echo $order_val ?>"><a class="dropdown-item" href="#" style="font-size:13px;" alt="<?php echo $order_val ?>"><?php echo $order ?></a></li>
					  <?php } ?>
					  </ul>
					</div>
					<input type="hidden" id="ofl" name="ofl" value="<?php echo $ordered_selected_val ?>" />

				</div>
			<?php echo form_close(); ?>
		  </div>

		  <hr class="cmp_row_line_top" />

		  <div class="cmp_list">
			  <!-- <div class="row"> -->

					<?php
					foreach($list as $key => $cmp) {
					?>
						<div style="margin:10px 0;">
						  <a href="/campaign/detail/<?php echo $cmp->code ?>" class="" style="text-decoration:none;">

							<div class="row">
							  <div class="col-4">
								<div class="cmp_img_wrap">
								  <div class="cmp_img" style="height: 100px; background-image:linear-gradient( rgba(0, 0, 0, 0.2), rgba(0, 0, 0, 0.2) ),url('<?php echo $cmp->campaign_main_src ?>'); background-size:cover; background-repeat:no-repeat; "></div>
								</div>
							  </div>
							  <div class="col-8">
								<div class="cmp_list_item py-2">
									<div class="cmp_ttl ellipsis"><?php echo $cmp->cmp_title ?></div>
									<div class="cmp_org" style="font-size: 15px;"><?php echo $cmp->cmp_org_name ?></div>
									<div class="cmp_term"><?php echo $cmp->cmp_term_begin ?> ~ <?php echo $cmp->cmp_term_end ?></div>
								</div>
							  </div>
							</div>

						  </a>
						</div>

						<hr class="cmp_row_line" />

					<?php } ?>

			  <!-- </div> -->
			</div>
		</div>
	  </div>
	</div>

