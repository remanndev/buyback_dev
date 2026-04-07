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
/*
.cmp_list ul li {
	padding: 8px;
	transition: all 0.2s;
}
.cmp_list ul li:hover {
	background-color: #58ae31;
}
.cmp_list ul li a {
	display: block;
	background-color: #ffffff;
}
*/
</style>

	<style type="text/css">
	.cmp_list ul li {
		padding: 6px;
		transition: all 0.2s;
	}
	.cmp_list ul li .itm_box {
		padding: 2px;
		background-color: #ffffff;
	}
	.cmp_list ul li:hover .itm_box {
		padding: 2px;
		background-color: #58ae31;
	}
	.cmp_list ul li .itm_box a {
		display: block;
		border-bottom:1px solid #cecece;
		background-color: #ffffff;
	}
	.cmp_list ul li:hover .itm_box a {
		/*
		border-bottom:1px solid #58ae31;
		border-bottom: none; */
	}


	.page_title {
		font-family: 'Nanum Gothic', 'NanumGothic', '나눔고딕', '나눔 고딕', 'Noto Sans KR', AppleSDGothicNeo-Regular, '맑은 고딕', 'Malgun Gothic', dotum, '돋움', sans-serif;
		font-size: 28px;
		font-weight: 800;
		font-stretch: normal;
		font-style: normal;
		/*
		line-height: 0.85; */
		letter-spacing: normal;
		text-align: left;
		color: #353535;
	}

	</style>

<?php
if( ! empty($top_bnr_pc) ) {
?>

	<!-- 캠페인 탑 비주얼 배너 영역 -->
	<div class="wrap_cmplist_top_bnr">
	  <?php foreach($top_bnr_pc as $i => $bnr) { ?>
		<div class="cmplist_top_bnr" style="background-image:url('<?php echo $bnr->banner_src ?>'); ">
			<div class="txt"><?php echo nl2br($bnr->bn_memo) ?></div>
		</div>
	  <?php } ?>
	</div>
	<script type="text/javascript">
	$(document).ready(function(){
	  $('.wrap_cmplist_top_bnr').not('.slick-initialized').slick({
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

<div class="ctnt_wrap">
	<div class="ctnt_inside">

		<div class="cmp_wrap">

			<div style="position: relative; width: 100%; ">

				<h3 class="cmp_subject font_common">
					<a class="<?php echo ($term == 'ended') ? '' : 'active'; ?>" href="/campaign/lists">진행중인 캠페인</a> <span> | </span> <a class="<?php echo ($term == 'ended') ? 'active' : ''; ?>" href="/campaign/lists?term=ended">종료된 캠페인</a>
				</h3>

				<?php echo form_open($this->uri->uri_string(), array('id'=>'search_form','name'=>'search_form','method'=>'get', 'style'=>'position:absolute; right:0; top:5px;')); ?>
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

			<hr class="cmp_subject_line" />

			<div class="cmp_list">
			  <ul class="row">

					<?php
					foreach($list as $key => $cmp) {
					?>

						<li class="col-3">
						 <div class="itm_box">
						  <a href="/campaign/detail/<?php echo $cmp->code ?>" class="" style="text-decoration:none;">
							<div class="cmp_img_wrap">
							  <div class="cmp_img" style="border: 1px solid rgb(213, 213, 213); border-bottom: none;  background-image:<?php echo ($term == 'ended') ? 'linear-gradient( rgba(0, 0, 0, 0.2), rgba(0, 0, 0, 0.2) ),' : ''; ?>url('<?php echo $cmp->campaign_main_src ?>'); "></div>
							</div>

							<div class="cmp_list_item">
								<div class="cmp_ttl ellipsis2" style="height: 48px;"><?php echo $cmp->cmp_title ?></div>
								<div class="cmp_cate"><?php echo $cmp->cmp_org_name ?></div>
								<!-- <?php /* 
								<div class="cmp_term"><span class="bs_badge bs_text-bg-secondary"><?php echo $cmp->cmp_term_begin ?> ~ <?php echo $cmp->cmp_term_end ?></span></div> */ ?> -->
								<div class="cmp_term_2024 <?php echo ('종료' == $cmp->cmp_term_end_2024) ? 'color_silver' : ''; ?>"><?php echo $cmp->cmp_term_end_2024 ?></div>
							</div>
						  </a>
						 </div>
						</li>
					<?php } ?>

			  </ul>
			</div>

		</div>

		<!-- </div>
	  </div>
	</div> -->


	</div>
</div>


