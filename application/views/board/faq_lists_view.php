<?php

// 카테고리메뉴
$ca_code_options = array();
if('' !== trim($bbs_cf->bo_category)) {
	$arr_bbs_menu = explode(',',$bbs_cf->bo_category);
	foreach($arr_bbs_menu as $i=>$menu) {
		$ca_code_options[$menu] = $menu;
	}
}

$selected_ca_code =  isset($cate_menu) ? $cate_menu : (isset($row->ca_code) ? $row->ca_code : set_value('ca_code'));
if($selected_ca_code == '') {
	$selected_ca_code = 'all';
}
$ca_code_options = array('all' => '전체');
if('' !== trim($bbs_cf->bo_category)) {
	$arr_bbs_menu = explode(',',$bbs_cf->bo_category);
	foreach($arr_bbs_menu as $i=>$menu) {
		$ca_code_options[$menu] = $menu;
	}
}

// [1/2]검색어
$searched_field = $this->input->post('search_field','');
$search_select_options = array(
                  'wr_subject'          => '제목',
                  'wr_content'           => '내용',
                );

$searched_text = $this->input->post('search_text','');
$height_search_text = ($arr_seg[1] === 'admin') ? '24' : '28'; // px
$search_text = array(
	'name'	=> 'search_text',
	'id'	=> 'search_text',
	'value' => ($searched_text) ? $searched_text : set_value('search_text'),
	'maxlength'	=> 20,
	'style'	=> 'width:120px;'
);

// [2/2] 정렬
$order_field = $this->input->post('order_field',FALSE);
$ordered_field = ($order_field) ? $order_field : 'wr_idx DESC';
$order_select_options = array(
				  'wr_datetime DESC'    => '등록일자 ↓',
				  'wr_datetime ASC'     => '등록일자 ↑',
                );


// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
// 모바일 설정
$_class_container = 'container';
$_line_limit = 'col-3';
if(IS_MOBILE) {
	$_class_container = 'm_container_bbs';
	$_line_limit = 'col-6';
}
?>

<style type="text/css">
	.bbs_basic_list {border-top:2px solid #333333; position:relative; display:block; }
	.bbs_basic_list table {width: 100%;}
	.bbs_basic_list table thead th { font-size:15px; padding:15px 12px !important; border-bottom:1px solid #bfbfbf;}
	.bbs_basic_list table tbody td { padding:11px !important; border-bottom:1px solid #dddddd;}
	.bbs_basic_list table td, .bbs_basic_list table td a { font-size:14px; color:#333333; text-decoration:none;}

	h3.o_content_ttl {position:relative; font-size:45px; font-weight:bold; text-align:center;}
	h4.o_content_ttl {position:relative; font-size:34px; font-weight:bold; }
	.o_content_ttl_redbar {position:absolute; top:0; left:15px; width:27px; height:5px; background-color:red; }

	.o_ctnt > div.row > div {position:relative; }
	.step_arrow {position:absolute; top:10px; right:-25px; background-image:url('<?php echo IMG_DIR ?>/donate/icons8-arrow-100.png'); background-position:100% 10%; background-size:40px; background-repeat:no-repeat;  width: 40px; height:40px;}
	.step_arrow_mobile {position:absolute; top:4px; right:-25px; background-image:url('<?php echo IMG_DIR ?>/donate/icons8-arrow-100.png'); background-position:100% 10%; background-size:30px; background-repeat:no-repeat;  width: 40px; height:40px;}

	.faq_ctnt img { width: auto; max-width: 100%;}

</style>

<script type="text/javascript">
	function goto_cate(cate) {
		var enc_cate = encodeURI(cate);
		location.href='<?php echo BASEURL ?><?php echo SEG_STRING ?>?cate='+enc_cate;
	}
</script>


<div class="pc_wrap">
  <div class="ctnt_wrap py_40">
	<div class="ctnt_inside">

		<div class="contents_wrap">
			<!-- 캠페인 상세 -->
			<div class="<?php echo $_class_container ?>" style="margin:0 auto;">

				<div>
					<?php echo $bbs_cf->bo_head; ?>
				</div>


				<?php //if(IS_MOBILE) { ?>
				<div class="o_page_content mb_50  d-block d-md-none">
					<section class="o_ctnt" >
						<h4 class="o_content_ttl">기부 절차 안내</h4>

						<div class="mt_30 pt_50" style="background-color:#f7f7fb; display: none;">

							<div class="row" style="position:relative;">
								<div class="col-3 text-center mx_10" style="padding:0;"><span class="step_arrow_mobile"></span><img src="<?php echo IMG_DIR ?>/donate/donate_step_1.png" style="width: 40px;" /><div class="py_20">모금캠페인<br />선택</div></div>
								<div class="col-3 text-center mx_10" style="padding:0;"><span class="step_arrow_mobile"></span><img src="<?php echo IMG_DIR ?>/donate/donate_step_2.png" style="width: 40px;" /><div class="py_20">기부신청서<br />작성</div></div>
								<div class="col-3 text-center mx_10" style="padding:0;"><img src="<?php echo IMG_DIR ?>/donate/donate_step_3.png" style="width: 40px;" /><div class="py_20">확인 및<br />연락</div></div>
							</div>
							<div class="col-12 py_20"></div>
							
							<div class="row" style="position:relative;">
								<div class="col-1 text-center" style="padding:0;"><span class="step_arrow_mobile"></span></div>
								<div class="col-3 text-center mx_5" style="padding:0;"><span class="step_arrow_mobile"></span><img src="<?php echo IMG_DIR ?>/donate/donate_step_4.png" style="width: 40px;" /><div class="py_20">기관과 물품 기부 협력 약정(행사)</div></div>
								<div class="col-3 text-center mx_5" style="padding:0;"><span class="step_arrow_mobile"></span><img src="<?php echo IMG_DIR ?>/donate/donate_step_5.png" style="width: 40px;" /><div class="py_20">물품 수거 (재생센터)</div></div>
								<div class="col-3 text-center mx_5" style="padding:0;"><img src="<?php echo IMG_DIR ?>/donate/donate_step_6.png" style="width: 40px;" /><div class="py_20">검수 및 등급 판정</div></div>
							</div>
							<div class="col-12 py_20"></div>

							<div class="row" style="position:relative;">
								<div class="col-1 text-center" style="padding:0;"><span class="step_arrow_mobile"></span></div>
								<div class="col-3 text-center mx_5" style="padding:0;"><span class="step_arrow_mobile"></span><img src="<?php echo IMG_DIR ?>/donate/donate_step_7.png" style="width: 40px;" /><div class="py_20">기부 가치<br />산정</div></div>
								<div class="col-3 text-center mx_5" style="padding:0;"><span class="step_arrow_mobile"></span><img src="<?php echo IMG_DIR ?>/donate/donate_step_8.png" style="width: 40px;" /><div class="py_20">수혜자 나눔 절차 진행</div></div>
								<div class="col-3 text-center mx_5" style="padding:0;"><img src="<?php echo IMG_DIR ?>/donate/donate_step_9.png" style="width: 40px;" /><div class="py_20">결과 인터넷 게시</div></div>
							</div>
							<div class="col-12 py_20"></div>
						</div>


						<style type="text/css">
						  #dn_proc_mobile.dn_process_wrap { padding:25px 0;}
						  #dn_proc_mobile .dn_proc_img {}
						  #dn_proc_mobile .dn_proc_txt { margin:0 auto; padding:0; width: 100%; list-style:none; }
						  #dn_proc_mobile .dn_proc_txt li { width:50%; display: inline-block; margin:0 0 20px 0; padding: 0; float:left; text-align:center; font-size:18px; color:#55a635; font-weight:bold; }
						  #dn_proc_mobile .dn_proc_txt li img.mdn_proc { width:90% !important; margin:0 auto; }
						  #dn_proc_mobile .dn_proc_txt li img.mdn_proc_no { width: 26px;}
						</style>
						<div id="dn_proc_mobile" class="dn_process_wrap">
							<ul class="dn_proc_txt" style="">
								<li>
									<img class="mdn_proc" src="<?php echo IMG_DIR ?>/replus/mdn_proc_1.png" style="width: 100%;" />
									<div><img class="mdn_proc_no" src="<?php echo IMG_DIR ?>/replus/dn_proc_no_1.png" /> 캠페인 선택</div>
								</li>
								<li>
									<img class="mdn_proc" src="<?php echo IMG_DIR ?>/replus/mdn_proc_2.png" style="width: 100%;" />
									<div><img class="mdn_proc_no" src="<?php echo IMG_DIR ?>/replus/dn_proc_no_2.png" /> 물품 확인 및 약정</div>
								</li>
								<li>
									<img class="mdn_proc" src="<?php echo IMG_DIR ?>/replus/mdn_proc_3.png" style="width: 100%;" />
									<div><img class="mdn_proc_no" src="<?php echo IMG_DIR ?>/replus/dn_proc_no_3.png" /> 물품 수거</div>
								</li>
								<li>
									<img class="mdn_proc" src="<?php echo IMG_DIR ?>/replus/mdn_proc_4.png" style="width: 100%;" />
									<div><img class="mdn_proc_no" src="<?php echo IMG_DIR ?>/replus/dn_proc_no_4.png" /> 기부 가치 산정</div>
								</li>
								<li>
									<img class="mdn_proc" src="<?php echo IMG_DIR ?>/replus/mdn_proc_5.png" style="width: 100%;" />
									<div><img class="mdn_proc_no" src="<?php echo IMG_DIR ?>/replus/dn_proc_no_5.png" /> 나눔 및 결과보고</div>
								</li>

							</ul>
							<div style="clear:both;"></div>
						</div>


					</section>
				</div>

				<?php //} else { ?>
				<!-- 기부 절차 안내 -->
				<div class="o_page_content mb_50  d-none d-md-block">
					<section class="o_ctnt" >
						<h4 class="o_content_ttl">기부 절차 안내</h4>
						<style type="text/css">
						  #dn_proc_pc.dn_process_wrap { padding:25px 0;}
						  #dn_proc_pc .dn_proc_img {}
						  #dn_proc_pc .dn_proc_txt { margin:0 auto; padding:0; width: 100%; list-style:none; }
						  #dn_proc_pc .dn_proc_txt li { width:20%; display: inline-block; margin:0; padding: 0; float:left; text-align:center; font-size:24px; color:#55a635; font-weight:bold; }
						  #dn_proc_pc .dn_proc_txt li img { width:36px !important; }
						</style>
						<div id="dn_proc_pc" class="dn_process_wrap">
						  <a href="/B/PARTNERS/기부-절차-안내">
							<div class="dn_proc_img"><img src="<?php echo IMG_DIR ?>/replus/donate_process.jpg" style="width: 100%;" /></div>
							<!-- <ul class="dn_proc_txt" style="">
								<li><img src="<?php echo IMG_DIR ?>/replus/dn_proc_no_1.png" /> 캠페인 선택</li>
								<li><img src="<?php echo IMG_DIR ?>/replus/dn_proc_no_2.png" /> 물품 확인 및 약정</li>
								<li><img src="<?php echo IMG_DIR ?>/replus/dn_proc_no_3.png" /> 물품 수거</li>
								<li><img src="<?php echo IMG_DIR ?>/replus/dn_proc_no_4.png" /> 기부 가치 산정</li>
								<li><img src="<?php echo IMG_DIR ?>/replus/dn_proc_no_5.png" /> 나눔 및 결과보고</li>
							</ul>
							<div style="clear:both;"></div> -->
						  </a>
						</div>

					</section>
				</div>
				<?php //} ?>



				<!-- 페이지 내용 -->
				<div class="o_page_content" style="min-height:400px;">
					<section class="o_ctnt" >

						<h4 class="o_content_ttl"><?php echo isset($bbs_cf->bo_title) ? $bbs_cf->bo_title : '게시판'; ?></h4>

						<div class="mt_20">
						<?php echo form_open($this->uri->uri_string(), array('id'=>'search_form','name'=>'search_form','method'=>'get')); ?>
							<div class="row" style="position:relative; vertical-align:bottom; height:30px; margin-bottom:15px;">

								<div class="col-12 col-lg-7" style="font-size:14px; line-height:38px;">
									<!-- 전체 <span style="color:red;"><?php echo $total_count_all ?></span> 개 -->
									<?php
										if($bbs_cf->bo_use_category &&  trim($bbs_cf->bo_category) !== '' ) { 
											//echo form_dropdown('ca_code', $ca_code_options, $selected_ca_code, 'class="o_selectbox" style="line-height:40px;font-size:15px; vertical-align:middle; "   onchange="goto_cate(this.value);" ');
									?>
										<ul class="nav nav-pills" id="pills-tab" role="tablist">
										<?php foreach($ca_code_options as $menu_code => $menu_ttl) { ?>
										  <li class="nav-item" role="presentation">
											<button class="nav-link py-0 px-3 <?php echo ($selected_ca_code == $menu_code) ? 'active' : ''; ?>" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true" onclick="goto_cate('<?php echo $menu_code ?>');"><?php echo $menu_ttl ?></button>
										  </li>
										<?php } ?>
										</ul>
									<?php
										}
									?>
								</div>
								<div class="col-12 col-lg-5 d-none d-md-block" style="position:relative;font-size:14px; line-height:38px;">
									<div style="z-index:1; text-align:right; position:absolute; bottom: 0; right:12px; ">
										<input type="hidden" name="sfl" value="wr_subject" />
										<input type="text" name="stx" value="<?php echo $stx ?>" style="line-height:35px; width:140px; padding:0 10px; border:none; border-bottom:1px solid #ddd;" placeholder="검색" />
										<button type="submit" style="border:none; padding:0;"><img src="<?php echo IMG_DIR ?>/common/btn_srh_board.jpg" /></button>
									</div>
								</div>
							</div>
						<?php echo form_close(); ?>
						<!-- <hr /> -->
						</div>


						<div class="bbs_basic_list">
							<table cellpadding="0" cellspacing="0">
							  <colgroup>
								<col style="width:5%;">
								<?php if($bbs_cf->bo_use_category && NULL !== $bbs_cf->bo_category && '' !== $bbs_cf->bo_category) { ?>
								<col class="text-center d-none d-md-block" style="width:10%;">
								<?php } ?>
								<col>
							  </colgroup>
							  <tbody>
							  <?php
								foreach($result['qry'] as $i => $o)
								{
								?>
								<tr>
								  <td class="text-center" style="vertical-align:top;">Q</td>
								  <?php if($bbs_cf->bo_use_category && NULL !== $bbs_cf->bo_category && '' !== $bbs_cf->bo_category) { ?>
								  <td class="text-center d-none d-md-block" style="vertical-align:top;"><?php echo $o->ca_code ?></td>
								  <?php } ?>
								  <td class="wrap_faq_item" data-ans-id="ans_<?php echo $o->wr_idx ?>" style="cursor:pointer;">
									<div class="d-block d-md-none">[<?php echo $o->ca_code ?>]</div>
									<?php echo $o->wr_subject ?>
									<?php if($this->tank_auth->is_admin()) { ?>
										<a href="<?php echo $bbs_code_url ?>/detail/<?php echo $o->wr_idx ?>/page/<?php echo $page ?>" style="margin-left:15px; font-size:16px;"><button type="button" class="o_btn btn btn-black-flat btn-xs">수정</button></a>
									<?php } ?>
								  </td>
								</tr>
								<tr id="ans_<?php echo $o->wr_idx ?>" style="display:none;">
								  <td class="text-center" style="vertical-align:top;">A</td>
								  <?php if($bbs_cf->bo_use_category && NULL !== $bbs_cf->bo_category && '' !== $bbs_cf->bo_category) { ?>
								  <?php } ?>
								  <td colspan="2" style="">
									<div class="faq_ctnt" style="font-size:15px; padding:15px; background-color:#f7f7fb;">
										<?php echo $o->wr_content; ?>
									</div>
								  </td>
								</tr>
							  <?php 
								}
							  ?>
							  </tbody>
							</table>
						</div>



						<div class="py_30">
						  <div class="text-center">
							<?php echo $paging ?>
						  </div>
						</div>

						<?php
						// ▼▼▼ 사용자 페이지 전용 - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
						//if( 'board' === $arr_seg[1] ) {
							//echo $bbs_cf->bo_admin_fk .'=='. $user->id;
							if( (isset($user->group_fk) ? $user->group_fk : 1) >= $bbs_cf->bo_level_write    OR     $this->tank_auth->is_admin()) {
							//if( isset($user->group_fk) && ($user->group_fk >= 9 OR $bbs_cf->bo_admin_fk == $user->id) ) {
						?>
						  <div style="width:100%; text-align:right;">
							<a href="<?php echo $bbs_code_url ?>/write/0/page/<?php echo $page ?>"><button class="o_btn btn btn-black-flat" type="button">글쓰기</button><!-- <img src="<?php echo IMG_DIR ?>/common/btn_write_list.png?v=2" style="width:20%; max-width: 50px; position:fixed; left:15px; bottom:15px; z-index:1;" alt="글쓰기" /> --></a>
						  </div>
						<?php
							}
						//}
						?>


					</section>
				</div>


			</div>
		</div>

	</div>
  </div>
</div>

<script type="text/javascript">
$(document).ready(function(){

	$('.wrap_faq_item').on('click', function(){
		var ans_id = $(this).data('ans-id');
		$('#'+ans_id).toggle();
	});

		

});
</script>