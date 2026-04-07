<?php

// [1] 카테고리메뉴
/*
$ca_code_options = array();
if('' !== trim($bbs_cf->bo_category)) {
	$arr_bbs_menu = explode(',',$bbs_cf->bo_category);
	foreach($arr_bbs_menu as $i=>$menu) {
		$ca_code_options[$menu] = $menu;
	}
}
*/
$ca_code_options = array('' => '분류');
if('' !== trim($bbs_cf->bo_category)) {
	$arr_bbs_menu = explode(',',$bbs_cf->bo_category);
	foreach($arr_bbs_menu as $i=>$menu) {
		$ca_code_options[$menu] = $menu;
	}
}
$ca_code_selected =  isset($cate_menu) ? $cate_menu : (isset($row->ca_code) ? $row->ca_code : set_value('ca_code'));
$ca_code_selected = ('' != $ca_code_selected) ? $ca_code_selected : '분류';

//$ca_code_selected_val = ('' != $ca_code_selected || '전체' != $ca_code_selected ) ? $ca_code_selected : '';
$ca_code_selected_val = ('' != $ca_code_selected && '분류' != $ca_code_selected ) ? $ca_code_selected : '';


// [2] 정렬
$ofl = $this->input->get('ofl',FALSE);
$ordered_selected = ($ofl) ? $ofl : 'wr_idx DESC';
//echo $ordered_selected.'<<<<';
$order_select_options = array(
				  'wr_datetime DESC'    => '등록일자 최신순',
				  'wr_datetime ASC'     => '등록일자 오래된순',
                );

$ordered_selected_txt = isset($order_select_options[$ordered_selected]) ? $order_select_options[$ordered_selected] : '정렬';
$ordered_selected_val = $ordered_selected;

//echo $this->arr_seg[1];


// 상단 탑배너 이미지 - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	// pc
	$top_bnr_pc = $this->basic_model->get_banner_list('share_top_pc',10);
	// mobile
	$top_bnr_mobile = $this->basic_model->get_banner_list('share_top_mobile',10);

// 대표나눔사례 - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	// 대표나눔사례
	$this->cases_share_bnr = $this->basic_model->get_banner_list('cases_share_event',10);

?>


<style type="text/css">
	.bo_title strong {font-size:34px; }
</style>



<?php
// 관리자페이지가 아닐 경우에만 노출
if( 'admin' !== $arr_seg[1] ) { ?>


	<div class="pc_wrap d-none d-lg-block">
	<?php 
	// [PC] 나눔신청 내용
	$this->load->view('campaign/inc_share_top_pc');
	?>
	</div>

	<div class="mobile_wrap d-block d-lg-none">
	<?php 
	// [MOBILE] 나눔신청 내용
	$this->load->view('campaign/inc_share_top_mobile');
	?>
	</div>


<?php
} // 관리자페이지가 아닐 경우에만 노출
?>



<div class="pc_wrap">
  <div class="ctnt_wrap py_35">
	<div class="ctnt_inside">

		<?php if( isset($this->arr_seg[1]) && $this->arr_seg[1] != 'admin' ) { ?>
		<div>
			<?php echo $bbs_cf->bo_head; ?>
		</div>
		<?php } ?>

		<div class="contents_wrap">

			<div class="bbs_basic">

				<!-- 페이지 내용 -->
				<section>
					<!-- <h3 class="bo_title">
						<?php //echo isset($bbs_cf->bo_title) ? $bbs_cf->bo_title : '게시판'; ?>
						<div class="d-inline-block d-md-none bo_count" style="font-size:14px; line-height:38px;">
							(검색 <span style="color:red;"><?php echo $total_srh_cnt ?></span> 개 / 전체 <span style="color:red;"><?php echo $total_count_all ?></span> 개)
						</div>
					</h3> -->

					<div class="bo_srh_wrap">
					<?php echo form_open($this->uri->uri_string(), array('id'=>'search_form','name'=>'search_form','method'=>'get')); ?>
						<div class="d-flex" style="position:relative; vertical-align:bottom; min-height:32px;">

							<div class="" style="width: 40%;font-size:14px; line-height:32px; vertical-align:bottom;">
								검색 <span style="color:red;"><?php echo $total_srh_cnt ?></span> 개 / 전체 <span style="color:red;"><?php echo $total_count_all ?></span> 개
							</div>

							<div class="bbs_search_wrap ms-auto" style="width: 50%; position:relative; vertical-align: baseline; text-align:right;">

								<?php
								if( (isset($user->level) ? $user->level : 1) >= $bbs_cf->bo_level_write    OR     $this->tank_auth->is_admin()) {
								?><!-- mobile btn -->
								  <a href="<?php echo $bbs_code_url ?>/write/new/page/<?php echo $page ?>"><button class="btn btn-dark btn-ssm d-block d-md-none" type="button" style="position:absolute;">글쓰기</button></a>
								<?php
									}
								?>

								<?php if($bbs_cf->bo_use_category &&  trim($bbs_cf->bo_category) !== '' ) {  ?>
								<!-- 분류 -->
								<div id="cate_dropdown" class="dropdown" style="display:inline-block; ">
								  <button class="btn btn-secondary btn-ssm dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
									<?php echo $ca_code_selected ?>
								  </button>
								  <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton1">
								  <?php foreach($ca_code_options as $cate_val => $cate_txt) { ?>
									<li class="dropdown-menu-cate-item" data-value="<?php echo $cate_val ?>"><a class="dropdown-item" href="#" style="font-size:13px;" alt="<?php echo $cate_val ?>"><?php echo $cate_txt ?></a></li>
								  <?php } ?>
								  </ul>
								</div>
								<input type="hidden" id="cate" name="cate" value="<?php echo $ca_code_selected_val ?>" />
								<?php } ?>

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


								<!-- <div style="display:inline-block; width:50%; max-width:200px; "> -->
								<div class="bbs_search">
									<input type="hidden" name="sfl" value="wr_subject" />
									<input type="text" name="stx" value="<?php echo $stx ?>" class="bo_input" style="" placeholder="검색" />
									<button type="submit"><img src="<?php echo IMG_DIR ?>/common/btn_srh_board.jpg" /></button>
								</div>
								<button type="button" class="btn btn-dark btn-ssm btn_dsp_srh">검색</button>





							</div>
						</div>
					<?php echo form_close(); ?>
					<!-- <hr /> -->
					</div>
								
					<div class="bbs_white_list">

						<table class="table table-hover table-md">
						  <colgroup class="dsp-none-mobile">
							<col class="d-none d-md-table-cell" style="<?php echo (IS_MOBILE) ? '' : 'width:90px;' ?>">
							<?php if($bbs_cf->bo_use_category && NULL !== $bbs_cf->bo_category && '' !== $bbs_cf->bo_category) { ?>
							<col style="<?php echo (IS_MOBILE) ? 'width:60px;' : 'width:10%;' ?>">
							<?php } ?>
							<col>
							<!-- <col class="d-none d-md-table-cell" style="<?php echo (IS_MOBILE) ? 'width:120px;' : 'width:12%;' ?>"> -->
							<col class="d-none d-md-table-cell" style="width:140px' ?>">
							<?php if($this->tank_auth->is_admin()) { ?>
							<col class=" d-md-table-cell" style="width:120px">
							<?php } ?>
						  </colgroup>
						  <thead class="dsp-none-mobile">
							<tr>
							  <th class="text-center d-none d-md-table-cell" scope="col" style="<?php echo (IS_MOBILE) ? '' : 'width:70px;' ?>"><?php echo (IS_MOBILE) ? '' : '번호' ?></th>
							  <?php if($bbs_cf->bo_use_category && NULL !== $bbs_cf->bo_category && '' !== $bbs_cf->bo_category) { ?>
							  <th class="text-center" scope="col" style="<?php echo (IS_MOBILE) ? 'width:60px;' : 'width:10%;' ?>">분류</th>
							  <?php } ?>
							  <th class="text-center" scope="col">제목</th>
							  <!-- <th class="text-center d-none d-md-table-cell" scope="col" style="<?php echo (IS_MOBILE) ? 'width:120px;' : 'width:12%;' ?>">작성자</th> -->
							  <th class="text-center d-none d-md-table-cell" scope="col" style="width:200px;' ?>">기간</th>
							  <?php if($this->tank_auth->is_admin()) { ?>
							  <th class="text-center  d-md-table-cell" scope="col" style="width:120px">상태</th>
							  <?php } ?>
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
							  <td class="text-center  d-none d-md-table-cell" style="font-weight:bolder;" style="<?php echo (IS_MOBILE) ? '' : 'width:90px;' ?>"><button class="btn btn-dark btn-xs">공지</button></td>
							  <?php if($bbs_cf->bo_use_category && NULL !== $bbs_cf->bo_category && '' !== $bbs_cf->bo_category) { ?>
							  <td class="text-center" style="<?php echo (IS_MOBILE) ? 'width:60px;' : 'width:10%;' ?>"><?php echo $o->ca_code ?></td>
							  <?php } ?>
							  <td class="" style="font-size:16px;">
								<a href="<?php echo $bbs_code_url ?>/detail/<?php echo $o->wr_idx ?>/page/<?php echo $page ?>" style="font-weight:bold; display:block;"><?php echo $o->wr_subject ?></a>
								<div class="d-block d-md-none" style="font-size:15px;"><?php echo $o->addfld_1 ?> ~ <?php echo $o->addfld_2 ?></div>
							  </td>
							  <!-- <td class="text-center d-none d-md-table-cell"><?php //echo $o->wr_name_input ?></td> -->
							  <td class="text-center d-none d-md-table-cell" style="width:140px' ?>"><?php echo $o->addfld_1 ?> ~ <?php echo $o->addfld_2 ?></td>
							  <?php if($this->tank_auth->is_admin()) { ?>
							  <td class="text-center  d-md-table-cell" style="width:120px">
								<?php if( date('Y-m-d') > $o->addfld_2) { ?>
									<a href="<?php echo $bbs_code_url ?>/detail/<?php echo $o->wr_idx ?>/page/<?php echo $page ?>"><button class="btn btn-success btn-sm" type="button">결과 발표 확인</button></a>
								<?php } else { ?>
									<strong style="color:#1b92cb;">접수중</strong>
								<?php } ?>
							  </td>
							  <?php } ?>
							</tr>
							<?php
							} // foreach
							} // if
						  ?>


						  <?php
							// 전체 목록
							foreach($result['qry'] as $i => $o)
							{
								//echo $bbs_code_url .'/detail/'.$o->wr_idx.'/page/'.$page;

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
							  <td class="text-center d-none d-md-table-cell"><?php //echo (IS_MOBILE) ? '' : $num  ?><?php echo $num ?></td>
							  <?php if($bbs_cf->bo_use_category && NULL !== $bbs_cf->bo_category && '' !== $bbs_cf->bo_category) { ?>
							  <td class="text-center"><?php echo $o->ca_code ?></td>
							  <?php } ?>
							  <td style="font-size:16px;">
								<!-- <a href="<?php echo $bbs_code_url ?>/detail/<?php echo $o->wr_idx ?>/page/<?php echo $page ?>" style="display:block;" <?php echo $o->password_popup ?>> -->
								<a href="<?php echo $bbs_code_url ?>/detail/<?php echo $o->wr_idx ?>" style="display:block;" <?php echo $o->password_popup ?>>
								  <?php echo $re_space ?><?php echo $icon_secret ?>
								  <?php echo $o->wr_subject ?>
								  <?php echo $icon_file ?>
								</a>
								<!-- <div class="d-block d-md-none" style="padding-top:5px; font-size:13px; color:#838383;">
									<?php echo substr($o->wr_datetime,0,10) ?> / 조회 <?php echo $o->wr_hit ?>
								</div> -->

								<div class="d-block d-md-none" style="font-size:15px;"><?php echo $o->addfld_1 ?> ~ <?php echo $o->addfld_2 ?></div>

							  </td>
							  <!-- <td class="text-center d-none d-md-table-cell"><?php //echo $o->wr_name_input ?></td> -->
							  <td class="text-center d-none d-md-table-cell"><?php echo $o->addfld_1 ?> ~ <?php echo $o->addfld_2 ?></td>
							  <?php if($this->tank_auth->is_admin()) { ?>
							  <td class="text-center  d-md-table-cell">
								<?php if( date('Y-m-d') > $o->addfld_2) { ?>
									<a href="<?php echo $bbs_code_url ?>/detail/<?php echo $o->wr_idx ?>/page/<?php echo $page ?>"><button class="btn btn-success btn-sm" type="button">결과 발표 확인</button></a>
								<?php } else { ?>
									<strong style="color:#1b92cb;">접수중</strong>
								<?php } ?>
							  </td>
							  <?php } ?>
							</tr>



						  <?php 
							}
						  ?>

						  </tbody>
						</table>

					</div>



					<div class="row">
					  <div class="col-md-12 text-center mb-4">
						<?php echo $paging ?>
					  </div>
					</div>

					<?php //echo $bbs_code_url ?>

					<?php
					// ▼▼▼ 사용자 페이지 전용 - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
					if( (isset($user->level) ? $user->level : 1) >= $bbs_cf->bo_level_write    OR     $this->tank_auth->is_admin()) {
					?>
					  <div style="width:100%; text-align:right;">
						<a href="<?php echo $bbs_code_url ?>/write/new/page/<?php echo $page ?>"><button class="btn btn-dark btn-sm" type="button">나눔캠페인 작성</button></a>
					  </div>
					<?php
					}
					?>


				</section>

			</div>
		</div>

	</div>
  </div>
</div>

<!-- 비밀번호 입력팝업창 ---->
<div class="modal fade modal-small" id="passModal" tabindex="-1" role="dialog" data-toggle="modal" aria-labelledby="passModal" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-body z-bigger">
				<div class="container-fluid">

				<?php echo form_open($this->uri->uri_string(), array('id'=>'fboardpassword','name'=>'fboardpassword')); ?>

					<button type="button" class="close2" data-dismiss="modal" aria-label="Close">
						<i class="uil uil-multiply"></i>
					</button>
					<div class="row justify-content-center">
						<div class="col-12 text-center">
							<h3 class="mb-2">비밀번호 입력</h3>
							<p class="mb-3">비밀번호 입력 후 열람가능합니다.</p>
						</div>
						<div class="col-12">
							<div class="col-12 section divider-dark3"></div>
						</div>

						<div class="col-12 pt-4"> 
							<div class="form-group">
								<input type="password" id="password" name="password" class="form-style form-style-with-icon" placeholder="" autocomplete="off">
							</div>   													
						</div>	
						<div class="col-12 text-center mt-2">
							<input type="submit" name="submit" class="btn btn-fluid btn-dark" value="확인"></input>
						</div>
					</div>

				<?php echo form_close(); ?>

				</div>
			</div>
		</div>
	</div>
</div>

<script type='text/javascript' src='<?php echo LIB_DIR?>/jquery/jquery_validate.js'></script>
<script type='text/javascript'>
//<![CDATA[
$(function() {
	$('#fboardpassword').validate({
		rules: { 
			password: { required:true, minlength:3 }
		},
		messages: {
			password: { required:'비밀번호를 입력하세요.', minlength:'최소 3자 이상 입력하세요.' }
		},
		errorPlacement: function(error, element) {
			error.appendTo(element.parent()).wrap('<p></p>');
		}
	});
});

/*
function set_action(bo_code,idx,page) {
	var actionpage = '/B/'+bo_code+'/password/'+idx+'/page/'+page;
	console.log( actionpage );
	$('#fboardpassword').attr('action',actionpage);
}
*/
function set_action(page_code,bo_code,idx,page) {
	var actionpage = '/B/'+page_code+'/'+bo_code+'/password/'+idx+'/page/'+page;
	console.log( actionpage );
	$('#fboardpassword').attr('action',actionpage);
}

//]]>
</script>




<script type="text/javascript">
	function goto_cate(cate) {
		var enc_cate = encodeURI(cate);
		location.href='<?php echo BASEURL ?><?php echo SEG_STRING ?>?cate='+enc_cate;
	}
</script>


<script type="text/javascript">
$(function() {
/*
	// dropdown 메뉴가 보이기 직전에 호출되는 이벤트
	$('.cate_dropdown').on('show.bs.dropdown', function () {
		console.log("메뉴가 열리기 전 이벤트!");
	});
	// dropdown 메뉴가 보이기 직후에 호출되는 이벤트
	$('.cate_dropdown').on('shown.bs.dropdown', function () {
		console.log("메뉴가 열린 후 이벤트!");
	});
	// dropdown 메뉴가 사라지기 직전에 호출되는 이벤트
	$('.cate_dropdown').on('hide.bs.dropdown', function () {
		console.log("메뉴가 닫히기 전 이벤트!");
	});
	// dropdown 메뉴가 사라진 직후에 호출되는 이벤트
	$('.cate_dropdown').on('hidden.bs.dropdown ', function () {
		console.log("메뉴가 닫힌 후 이벤트!");
	});
*/

	var slt_cate = "<?php echo $ca_code_selected_val ?>";
	var slt_order = "<?php echo $ordered_selected ?>";

	$('#cate_dropdown .dropdown-menu li > a').bind('click',function (e) {
		var cate_val = $(this).html();
		//$('#cate_dropdown button.dropdown-toggle').html(cate_val +' <span class="caret"></span>');
		$('#cate_dropdown button.dropdown-toggle').html(cate_val +' ');

		cate_val = (cate_val == '분류') ? '' : cate_val;
		$('#cate').val(cate_val);
		document.search_form.submit();
	});

	$('#order_dropdown .dropdown-menu li > a').bind('click',function (e) {
		var order = $(this).html();
		var order_val = $(this).attr('alt');

		//console.log(order);
		//console.log(order_val);

		//$('#order_dropdown button.dropdown-toggle').html(order_val +' <span class="caret"></span>');
		$('#order_dropdown button.dropdown-toggle').html(order +' ');

		$('#ofl').val(order_val);
		document.search_form.submit();
	});


	$('.dropdown-menu-cate-item').removeClass('on');
	$('.dropdown-menu-cate-item').each(function(){
		var $this = $(this);
		var cateVal = $this.data('value');
		//console.log(cateVal);

		if(slt_cate == cateVal) {
			$this.addClass('on');
		}
	});


	$('.dropdown-menu-order-item').removeClass('on');
	$('.dropdown-menu-order-item').each(function(){
		var $this = $(this);
		var cateVal = $this.data('value');
		//console.log(cateVal);

		if(slt_order == cateVal) {
			$this.addClass('on');
		}
	});

	var stx = '<?php echo $stx ?>';
	if( stx != '') {
		click_srh_btn();
	}
	function click_srh_btn() {
		$('.btn_dsp_srh').hide();
		$('.bbs_search').addClass('srh_show');
	}

	$('.btn_dsp_srh').click(function() {
		click_srh_btn();
	});
});
</script>
