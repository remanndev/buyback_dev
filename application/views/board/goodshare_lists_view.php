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
$_line_limit = 'col-3';
if(IS_MOBILE) {
	$_class_container = 'm_container_bbs';
	$_line_limit = 'col-6';
}
?>

<style type="text/css">
	.bbs_basic_list {border-top:0px solid #333333; position:relative; display:block; }
	.bbs_basic_list table {width: 100%;}
	.bbs_basic_list table thead th { font-size:15px; padding:15px 12px !important; border-bottom:1px solid #bfbfbf;}
	.bbs_basic_list table tbody td { padding:11px !important; border-bottom:1px solid #dddddd;}
	.bbs_basic_list table td, .bbs_basic_list table td a { font-size:14px; color:#333333; text-decoration:none;}

	/*
	.bbs_basic_list table thead th, .bbs_basic_list table tbody td { border-right:1px solid #ddd;}
	.bbs_basic_list table thead th:last-child, .bbs_basic_list table tbody td:last-child { border-right:none;}
	*/

	h3.o_content_ttl {position:relative; font-size:45px; font-weight:bold; text-align:center;}
	h4.o_content_ttl {position:relative; font-size:34px; font-weight:bold; }
	.o_content_ttl_redbar {position:absolute; top:0; left:15px; width:27px; height:5px; background-color:red; }
</style>


<script type="text/javascript">
	function goto_cate(cate) {
		var enc_cate = encodeURI(cate);
		location.href='<?php echo BASEURL ?><?php echo SEG_STRING ?>?cate='+enc_cate;
	}
</script>



<?php
// 관리자페이지가 아닐 경우에만 노출
if( 'admin' !== $arr_seg[1] ) { ?>

	<!-- 캠페인 탑 비주얼 배너 영역 -->
	<div class="bnr_wrap">
		<div class="wrap_top_bnr">
		  <?php foreach($top_bnr_pc as $i => $bnr) { ?>
			<div class="list_top_bnr" style="background-image:url('<?php echo $bnr->banner_src ?>'); ">
				<div class="txt"><?php echo nl2br($bnr->bn_memo) ?></div>
			</div>
		  <?php } ?>
		</div>
	</div>
	<script type="text/javascript">
	$(document).ready(function(){
	  $('.wrap_top_bnr').not('.slick-initialized').slick({
		  slidesToShow: 1,
		  slidesToScroll: 1,
		  arrows: false,
		  dots: false
	  });
	});
	</script>

<?php 
} // 관리자페이지가 아닐 경우에만 노출
?>


<div class="contents_wrap">
	
	<div class="<?php echo $_class_container ?> py_35" style="margin:0 auto;">

		<div>
			<?php echo $bbs_cf->bo_head; ?>
		</div>

		<!-- 페이지 내용 -->
		<div class="o_page_content">
			<section class="o_ctnt" >

				<!-- <div style="width:100%; height:300px; background-color:#f3f3fa;">
					나눔 신청 배너 이미지
				</div>

				<div class="mt_20" style="width:100%; height:500px; background-color:#f4f4f4;">
					나눔 신청 소개 내용
				</div> -->

				<?php
				// ▼▼▼ 사용자 페이지 전용 - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
				//if( 'board' === $arr_seg[1] ) {
					if( (isset($user->group_fk) ? $user->group_fk : 1) >= $bbs_cf->bo_level_write    OR     $this->tank_auth->is_admin()) {
				?>
				  <div class="py_30" style="width:100%; text-align:center;">
					<a href="<?php echo $bbs_code_url ?>/write/0/page/<?php echo $page ?>"><button class="o_btn btn btn-black-flat" type="button">나눔 신청하기</button></a>
				  </div>
				<?php
					}
				//}
				?>
			</section>
		</div>



		<!-- 페이지 내용 -->
		<div class="o_page_content">
			<section class="o_ctnt" >

					<!-- <h4 class="o_content_ttl"><?php echo isset($bbs_cf->bo_title) ? $bbs_cf->bo_title : '게시판'; ?></h4> -->

					<div class="mt_20">
					<!-- <?php echo form_open($this->uri->uri_string(), array('id'=>'search_form','name'=>'search_form','method'=>'get')); ?>
						<div class="row" style="position:relative; vertical-align:bottom; height:30px; margin-bottom:15px;">
							<div class="col-4" style="font-size:14px; line-height:38px;">
								전체 <span style="color:red;"><?php echo total_count_all ?></span> 개
							</div>
							<div class="col-8" style="position:relative;">
								<div style="position:absolute; right:15px; z-index:1; text-align:right;">
								<?php
									if($bbs_cf->bo_use_category &&  trim($bbs_cf->bo_category) !== '' ) { 
										echo form_dropdown('ca_code', $ca_code_options, $selected_ca_code, 'class="o_selectbox" style="line-height:40px;font-size:15px; vertical-align:middle; "   onchange="goto_cate(this.value);" ');
									}
								?>
									<input type="hidden" name="sfl" value="wr_subject,wr_content" />
									<input type="text" name="stx" value="<?php echo $stx ?>" style="line-height:35px; width:100%; max-width:180px; padding:0 10px; border:none; border-bottom:1px solid #cccccc;" placeholder="검색" />
									<button type="submit" style="border:none; padding:0;"><img src="<?php echo IMG_DIR ?>/2020/btn_srh_board.jpg" /></button>
								</div>
							</div>
						</div>
					<?php echo form_close(); ?> -->
					</div>


				<?php if(IS_MOBILE) { ?>


					<div class="bbs_basic_list">

						<table class="table table-hover table-md" cellpadding="0" cellspacing="0">
						  <colgroup>
							<col style="width:60px;">
							<?php if($bbs_cf->bo_use_category && NULL !== $bbs_cf->bo_category && '' !== $bbs_cf->bo_category) { ?>
							<col style="width:10%;">
							<?php } ?>
							<col>
						  </colgroup>
						  <thead class="">
							<tr>
							  <th class="text-center" scope="col">번호</th>
							  <?php if($bbs_cf->bo_use_category && NULL !== $bbs_cf->bo_category && '' !== $bbs_cf->bo_category) { ?>
							  <th class="text-center" scope="col">분류</th>
							  <?php } ?>
							  <th class="text-center" scope="col">제목</th>
							</tr>
						  </thead>
						  <tbody>

							<?php

							// 공지체크한 목록
							$dsp_notice_list = ( 'all' === $bbs_cf->bo_notice_type  OR  ( $page === '1' && 'first' === $bbs_cf->bo_notice_type ) ) ? TRUE : FALSE;
							if( $dsp_notice_list ) {
							foreach($result_notice['qry'] as $i => $o) {
							?>
							<tr style="background-color:#fbfbfb;">
							  <td class="text-center" style="font-weight:bolder;"><button class="btn btn-dark btn-xs">공지</button></td>
							  <?php if($bbs_cf->bo_use_category && NULL !== $bbs_cf->bo_category && '' !== $bbs_cf->bo_category) { ?>
							  <td class="text-center"><?php echo $o->ca_code ?></td>
							  <?php } ?>
							  <td>
								<a href="<?php echo $bbs_code_url ?>/detail/<?php echo $o->wr_idx ?>/page/<?php echo $page ?>" style="font-weight:bold; font-size:17px;"><?php echo $o->wr_subject ?></a>
								<div style="font-size:15px; color:#686868;"><?php echo substr($o->wr_datetime,0,10) ?></div>
							  </td>
							</tr>
							<?php
							} // foreach
							} // if

							?>


							<?php
							// 전체 목록
							foreach($result['qry'] as $i => $o)
							{
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
							?>

							<tr>
							  <td class="text-center"><?php echo $num ?></td>
							  <?php if($bbs_cf->bo_use_category && NULL !== $bbs_cf->bo_category && '' !== $bbs_cf->bo_category) { ?>
							  <td class="text-center"><?php echo $o->ca_code ?></td>
							  <?php } ?>
							  <td>
								<a href="<?php echo $bbs_code_url ?>/detail/<?php echo $o->wr_idx ?>/page/<?php echo $page ?>" style="display:block; font-size:17px;">
								  <?php echo $re_space ?><?php echo $icon_secret ?>
								  <?php echo $o->wr_subject ?>
								  <?php echo $icon_file ?>
								</a>
								<div style="font-size:15px; color:#686868;"><?php echo substr($o->wr_datetime,0,10) ?></div>
							  </td>
							</tr>



							<?php 
							}
							?>

						  </tbody>
						</table>

					</div>

				<?php } else { ?>

					<div class="bbs_basic_list">

						<table class="table table-hover table-md" cellpadding="0" cellspacing="0">
						  <colgroup>
							<col style="width:80px;">
							<?php if($bbs_cf->bo_use_category && NULL !== $bbs_cf->bo_category && '' !== $bbs_cf->bo_category) { ?>
							<col style="width:10%;">
							<?php } ?>
							<col>
							<col>
							<col style="width: 120px;">
							<col style="width: 100px;">
						  </colgroup>
						  <thead class="">
							<tr>
							  <th class="text-center" scope="col">번호</th>
							  <?php if($bbs_cf->bo_use_category && NULL !== $bbs_cf->bo_category && '' !== $bbs_cf->bo_category) { ?>
							  <th class="text-center" scope="col">분류</th>
							  <?php } ?>
							  <th class="text-center" scope="col">작성자</th>
							  <th class="text-center" scope="col">신청사유</th>
							  <th class="text-center" scope="col">작성일자</th>
							  <th class="text-center" scope="col">접수확인</th>
							</tr>
						  </thead>
						  <tbody>

							<?php

							// 공지체크한 목록
							$dsp_notice_list = ( 'all' === $bbs_cf->bo_notice_type  OR  ( $page === '1' && 'first' === $bbs_cf->bo_notice_type ) ) ? TRUE : FALSE;
							if( $dsp_notice_list ) {
							foreach($result_notice['qry'] as $i => $o) {
							?>
							<tr style="background-color:#fbfbfb;">
							  <td class="text-center" style="font-weight:bolder;"><button class="btn btn-dark btn-xs">공지</button></td>
							  <?php if($bbs_cf->bo_use_category && NULL !== $bbs_cf->bo_category && '' !== $bbs_cf->bo_category) { ?>
							  <td class="text-center"><?php echo $o->ca_code ?></td>
							  <?php } ?>
							  <td><a href="<?php echo $bbs_code_url ?>/detail/<?php echo $o->wr_idx ?>/page/<?php echo $page ?>" style="font-weight:bold;"><?php echo $o->wr_subject ?></a></td>
							  <td class="text-center "><?php echo substr($o->wr_datetime,0,10) ?></td>
							  <td class="text-center "></td>
							  <td class="text-center "></td>
							</tr>
							<?php
							} // foreach
							} // if

							?>


							<?php
							// 전체 목록
							foreach($result['qry'] as $i => $o)
							{
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
							?>

							<tr>
							  <td class="text-center"><?php echo $num ?></td>
							  <?php if($bbs_cf->bo_use_category && NULL !== $bbs_cf->bo_category && '' !== $bbs_cf->bo_category) { ?>
							  <td class="text-center"><?php echo $o->ca_code ?></td>
							  <?php } ?>
							  <td class="text-center "><?php echo $o->req_name ?></td>
							  <td>
								<a href="<?php echo $bbs_code_url ?>/detail/<?php echo $o->wr_idx ?>/page/<?php echo $page ?>" style="display:block;">
								  <?php echo $re_space ?><?php echo $icon_secret ?>
								  <?php echo $o->wr_subject ?>
								  <?php echo $icon_file ?>
								</a>
							  </td>
							  <td class="text-center "><?php echo substr($o->wr_datetime,0,10) ?></td>
							  <td class="text-center ">
								
								<?php
								$btn_type = (isset($o->confirm) && '확인' == $o->confirm) ? 'btn-primary-flat' : 'btn-gray-flat';
								$btn_text =  (isset($o->confirm) && '' != $o->confirm) ? $o->confirm : '미확인';
								if($this->tank_auth->is_admin()) {
								?>
									<!-- 미확인 -->
									<button id="confirm_<?php echo $o->wr_idx ?>" class="btn_confirm o_btn btn <?php echo $btn_type ?> btn-sm"  data-idx="<?php echo $o->wr_idx ?>"><?php echo $btn_text; ?></button>
								<?php 
								} else { 
									echo $btn_text;
								} ?>
							  </td>
							</tr>



							<?php 
							}
							?>

						  </tbody>
						</table>

					</div>

				<?php } ?>

				<div class="py_30">
				  <div class="text-center">
					<?php echo $paging ?>
				  </div>
				</div>

				<!-- <?php
				// ▼▼▼ 사용자 페이지 전용 - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
				if( 'board' === $arr_seg[1] ) {
					if( (isset($user->group_fk) ? $user->group_fk : 1) >= $bbs_cf->bo_level_write    OR     $this->tank_auth->is_admin()) {
				?>
				  <div style="width:100%; text-align:right;">
					<a href="<?php echo $bbs_code_url ?>/write/0/page/<?php echo $page ?>"><button class="o_btn btn btn-black-flat" type="button">글쓰기</button></a>
				  </div>
				<?php
					}
				}
				?> -->

			</section>
		</div>


	</div>
</div>

<script type="text/javascript">
$(document).ready(function(){
	$('.btn_confirm').on('click', function() {

		var eid = $(this).attr('id');
		console.log(eid);
		var idx = $(this).data('idx');
		//console.log(idx);
		var confirm_txt = $(this).text();
		//console.log(confirm_txt);


		// 삭제하려는 사람과 등록한 사람 비교 포함.
		var request = $.ajax({
		  url: "/trans/chg_state_goodshare/",
		  method: "POST",
		  data: { 'idx': idx, 'confirm_txt': confirm_txt},
		  dataType: "text"
		});

		request.done(function( res ) {


			// 변경 완료
			if('확인' == res) {
				$('#'+eid).removeClass('btn-primary-flat').removeClass('btn-gray-flat');
				$('#'+eid).addClass('btn-primary-flat');
				$('#'+eid).text(res);
			}
			else if('미확인' == res) {


				$('#'+eid).removeClass('btn-primary-flat').removeClass('btn-gray-flat');
				$('#'+eid).addClass('btn-gray-flat');
				$('#'+eid).text(res);
			}
		});

		request.fail(function( jqXHR, textStatus ) {
		  alert( "Request failed: " + textStatus );

		  return false;
		});

	});
});
</script>