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
/*
$_line_limit = 'col-3';
if(IS_MOBILE) {
	$_class_container = 'm_container_bbs';
	$_line_limit = 'col-6';
}
*/

//$_line_limit = 'col-12 col-sm-6 col-md-4 col-lg-3';
$_line_limit = 'col-6 col-md-3';
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


	.list_img {
		overflow:hidden;
		border:1px solid #dddddd;
		width: 100%;
		height: 180px; 
		background-size:cover;
		background-position:center center;
		background-repeat:no-repeat;
	}
	@media screen and (max-width: 991px) {
		.list_img {
			height: 160px; 
		}
	}

</style>

<script type="text/javascript">
	function goto_cate(cate) {
		var enc_cate = encodeURI(cate);
		location.href='<?php echo BASEURL ?><?php echo SEG_STRING ?>?cate='+enc_cate;
	}
</script>



<div id="board_orgs" class="ctnt_wrap py_40">
	<div class="ctnt_inside">

		<?php if( isset($this->arr_seg[1]) && $this->arr_seg[1] != 'admin' ) { ?>
		<div>
			<?php echo $bbs_cf->bo_head; ?>
		</div>
		<?php } ?>

		<div class="contents_wrap">
			<div class="">


				<!-- 페이지 내용 -->
				<section>
					<h3 class="bo_title">
						<strong><?php echo isset($bbs_cf->bo_title) ? $bbs_cf->bo_title : '게시판'; ?></strong>
						<div class="d-none bo_count" style="font-size:14px; line-height:38px;">
							(검색 <span style="color:red;"><?php echo $total_srh_cnt ?></span> 개 / 전체 <span style="color:red;"><?php echo $total_count_all ?></span> 개)
						</div>
					</h3>



				<!-- 페이지 내용 -->
				<div class="o_page_content">
					<section class="o_ctnt" >

						<div class="mt_20">
							<?php echo form_open($this->uri->uri_string(), array('id'=>'search_form','name'=>'search_form','method'=>'get')); ?>
								<div class="row" style="position:relative; vertical-align:bottom; height:30px; margin-bottom:15px;">
									<div class="col-4" style="font-size:14px; line-height:38px;">
										전체 <span style="color:red;"><?php echo $total_count_all ?></span> 개
									</div>
									<div class="col-8" style="position:relative;">
										<div style="position:absolute; right:15px; z-index:1; text-align:right;">
										<?php
											if($bbs_cf->bo_use_category &&  trim($bbs_cf->bo_category) !== '' ) { 
												echo form_dropdown('ca_code', $ca_code_options, $selected_ca_code, 'class="o_selectbox" style="line-height:40px;font-size:15px; vertical-align:middle; "   onchange="goto_cate(this.value);" ');
											}
										?>
											<input type="hidden" name="sfl" value="wr_subject,wr_content" />
											<input type="text" name="stx" value="<?php echo $stx ?>" style="line-height:35px; font-size:18px; width:100%; max-width:180px; padding:0 10px; border:none; border-bottom:1px solid #cccccc;" placeholder="검색" />
											<button type="submit" style="border:none; padding:0;"><img src="<?php echo IMG_DIR ?>/common/btn_srh_board.jpg" /></button>
										</div>
									</div>
								</div>
							<?php echo form_close(); ?>
						</div>
						<hr style="border:none; border-bottom:1px solid #ccc; margin-bottom: 25px;" />

						<div class="row" style="min-height:400px;">

							<?php
							// 전체 목록
							foreach($result['qry'] as $i => $o)
							{
								/*
								// 번호
								$num = ($result['total_count'] - $limit*($page-1) - $i);

								// 비밀글
								$icon_secret = ('1'===$o->opt_secret) ? '<img src="'. IMG_DIR .'/common/icon_secret.png" style="margin-right:5px;" />' : '';

								// 파일
								$icon_file = ($o->wr_count_file > 0) ? '<img src="'. IMG_DIR .'/common/icon_file.png" style="margin-left:5px;" />' : '';

								// 답글
								$depth = strlen($o->wr_reply) * 15;
								$re_space = "";
								if($depth > 0) {
									$re_space = "<span style='display:inline-block; margin-left:". $depth ."px;'>ㄴ</span>";
								}

								$no = $i % 3;
								$over_sec = ((4+2*$no)/10).'s';
								$after_sec = ((3+2*$no)/10).'s';
								*/
							?>

								<div class="<?php echo $_line_limit ?>" style="margin-bottom:25px; text-align:center;">
								  <div style="overflow:hidden;">
									<a href="<?php echo $bbs_code_url ?>/detail/<?php echo $o->wr_idx ?>/page/<?php echo $page ?>" style="text-decoration:none;">
										<div class="list_img" style="background-image:url('<?php echo $o->resize_thumb_src ?>'); <?php echo isset($o->css_bgsize) ? $o->css_bgsize : ''; ?>"></div>
										<div class="list_subject" style="padding:10px 0; color:#333333; font-size:15px; font-weight: bold; text-align:left;" ><div style="line-height:22px; height:44px; overflow: hidden; text-overflow: ellipsis; display:-webkit-box; white-space: normal; -webkit-line-clamp:2; -webkit-box-orient: vertical; word-wrap:break-word;"><?php echo (isset($o->ca_code) && '' != $o->ca_code) ? '['.$o->ca_code.'] ' : '' ?><?php echo $o->wr_subject ?></div></div>
									</a>
								  </div>
								</div>

							<?php 
							}
							?>
						</div>

						<div>
						  <div class="text-center mb-4">
							<?php echo $paging ?>
						  </div>
						</div>

						<?php
						// ▼▼▼ 사용자 페이지 전용 - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
						//if( 'board' === $arr_seg[1] ) {
							if( (isset($user->level) ? $user->level : 1) >= $bbs_cf->bo_level_write    OR     $this->tank_auth->is_admin()) {
						?>
						  <div style="width:100%; text-align:right;">
							<a href="<?php echo $bbs_code_url ?>/write/0/page/<?php echo $page ?>"><button class="o_btn btn btn-black-flat" type="button">글쓰기</button></a>
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