<?php
// 상단 탑배너 이미지 - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	// pc
	$top_bnr_pc = $this->basic_model->get_banner_list('share_top_pc',10);
	// mobile
	$top_bnr_mobile = $this->basic_model->get_banner_list('share_top_mobile',10);
?>



<style type="text/css">
	.bo_title strong {font-size:34px; }

	/* 나눔캠페인 신청 내역 */
	.btn_confirm {width: 70px; }
	.req_box { margin: 15px 0; padding: 0 0 10px 0;  background-color: #f9f9f9; border:1px dashed silver;}
	.wrap_req_detail h2 { 
		margin:15px 0 10px 0; padding-bottom: 10px; border-bottom: 1px dashed #ccc;
		position: relative;
		font-size: 20px;
		font-weight: 800;
		letter-spacing: -1px;
		line-height: 1em;
		padding: 0 0 10px 10px;
	}

	.wrap_req_detail dl {clear:both; position:relative; margin: 0 0 5px 0;  padding: 3px 15px 0; vertical-align: top;}
	.wrap_req_detail dl dt { display:inline-block; width: 100px; margin:0; padding: 2px 4px; vertical-align: top; background-color:#eeeeee;}
	.wrap_req_detail dl dd { display:inline-block; margin:0; padding-left: 5px;vertical-align: top;}
	.wrap_req_detail dl dt, .wrap_req_detail dl dd {
		font-family: '나눔고딕','Nanum Gothic','맑은고딕','Malgun Gothic','gulim','arial', 'Dotum', 'AppleGothic', sans-serif;
		font-weight: 400;
		letter-spacing: -0.05em;
		font-size: 13px;
	}



	.dsp-none-pc { display: none;}
	.dsp-none-mobile { display:;}
	/*  모바일 */
	@media screen and (max-width: 991px) {
		.dsp-none-pc { display: block;}
		.dsp-none-mobile { display: none;}
	}


	/* [게시판] 나눔캠페인 컨텐츠 내에서 유튜브 iframe width 100%, height auto */
	@media screen and (max-width: 991px) {
		.bbs_content figure {
			position: relative;
			padding-bottom: 56.25%;
			padding-top: 30px;
			height: 0;
			overflow: hidden;
		}
		 
		.bbs_content figure iframe,
		.bbs_content figure object,
		.bbs_content figure embed {
			position: absolute;
			top: 0;
			left: 0;
			width: 100% !important;
			height: 100% !important;
		}
	}
</style>



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
			<!-- <div class="o-fade-in"> -->
			<section>

				<!-- 페이지 내용 -->

				<h3 class="bo_title">
					<strong><?php echo isset($bbs_cf->bo_title) ? $bbs_cf->bo_title : '게시판'; ?></strong>

					<div class="" style="position:absolute; top:0px; right:0;padding:0; text-align:center;">
						<a href="<?php echo $bbs_code_url ?>/lists/page/<?php echo $page ?>" class="" style="text-decoration:none;">
							<button class="btn btn-dark btn-sm" type="button">목록</button>
						</a>
						<?php if( (isset($user->id) ? $user->id : NULL) === $row->user_idx  OR  $this->tank_auth->is_admin() ) { ?>
						  <a href="<?php echo $bbs_code_url ?>/write/<?php echo $wr_idx ?>/page/<?php echo $page ?>" class="" style="text-decoration:none;">
							<button class="btn btn-dark btn-sm" type="button">수정</button>
						  </a>
						  <a href="<?php echo $bbs_code_url ?>/delete/<?php echo $wr_idx ?>/page/<?php echo $page ?>" onclick="del_url('<?php echo $bbs_code_url ?>/delete/<?php echo $wr_idx ?>/page/<?php echo $page ?>'); return false;"  class="" style="text-decoration:none;">
							<button class="btn btn-dark btn-sm" type="button">삭제</button>
						  </a>
						<?php } ?>
					</div>

				</h3>

				<div class="bbs_basic_detail ">

					<div class="bbs_header">
						<h4 class="bbs_ttl pt_10 px_10">
							<?php echo $row->wr_subject ?>
						</h4>
						<!-- <div class="bbs_info mt_10 px_10">
							<?php //echo $row->wr_name ?> 
							<small> 조회수 : <?php echo $row->wr_hit ?></small>
							<small class="ml_20"> 작성일 : <?php echo $row->wr_datetime_point ?></small>
						</div> -->
						<div class="bbs_info mt_10 px_10" style="text-align:left;">
							<div><?php echo $row->addfld_1 ?> ~ <?php echo $row->addfld_2 ?> </div>
						</div>
					</div>

					<div class="bbs_info" style="text-align:left;">
						<?php if($result_file_form && $result_file_form['total_count'] > 0) { ?>
						<ul style="background-color:#f9f9f9; margin:5px 0; padding:15px; border:1px dashed #e6e6e6; list-style:none;">
							<?php
							foreach($result_file_form['qry'] as $i => $o) {
								$filepath = url_code($o->file_dir, 'e');
								$filename = $o->file_name;
								$filename_original = $o->file_name_org;
							?>
							  <li class="file_form_0" style="position:relative; font-size:13px;">
								<div style="padding:2px 0;">
								  <a href="/files/download/<?php echo $filepath ?>/<?php echo $filename ?>/<?php echo $filename_original ?>">
									<img src="<?php echo IMG_DIR ?>/common/icon_file.png" style="margin-right:5px; vertical-align:middle;">
									<?php echo $o->file_name_org ?> (<?php echo number_format($o->file_size) ?> KB)
								  </a>
								</div>
							  </li>
							<?php } ?>
						</ul>
						<?php } ?>
					</div>

					<div class="site-section" style="padding:15px 10px;" >
						  <div class="redactor-styles redactor-in wr_content_wrap o_table_mobile" style="padding:0; border:none; min-height: 300px;">
							<div class="mob_overflow_x">
							  <div class="bbs_content"><?php echo $row->wr_content ?></div>
							</div>
						  </div>
					</div>

					<?php if($bbs_cf->bo_use_comment > 0 ) { ?>

					<div class="site-section mt-5" style="border-top:3px solid rgba(51,51,51,1);  padding:25px 10px;" >


						<div style="position:relative; width:100%; ">
							<div style="position:absolute; left:0; top:0; width:60px; "><h3 style="font-size:22px;">댓글</h3></div>

							<div style="position:relative; width:calc(100% - 170px); margin-left:70px;">
								<textarea id="cmt_content" style="width:100%; height:80px; padding:10px; border:1px solid #ccc;"></textarea>
							</div>

							<div style="position:absolute; right:0; top:0; width:80px;">
								<?php if ($this->tank_auth->is_logged_in()) { ?>
								<button id="btn_comment" type="button" class="o_btn btn btn-black-flat" style="float:right; display:inline-block;margin-left:15px; height:80px;">댓글 등록</button>
								<?php } else { ?>
								<button onclick="alert('로그인을 먼저 해주세요.');" type="button" class="o_btn btn btn-black-flat" style="float:right; display:inline-block;margin-left:15px; height:80px;">댓글 등록</button>
								<?php } ?>
							</div>

						</div>




						<?php
						$cmt_line_css = ($result_cmt['total_count'] > 0) ? ' padding-top:30px;border-bottom:1px solid #cccccc;' : '';
						?>
						<div style="clear:both; <?php echo $cmt_line_css ?>"></div>



						<div id="layer_comment">
							<?php
							foreach($result_cmt['qry'] as $i => $o) {
								
								$reply_layer_css = "";

								// 답글인 경우
								if( '2' === $o->depth ) {
									$reply_layer_css = "margin:0; padding:10px; padding-left:50px; background-color:#f3f3f3; background-image:url('". IMG_DIR."/common/icon_reply.gif'); background-repeat:no-repeat; background-position:20px 13px; ";
								}
								
							?>
							<div style="<?php echo ($i < 1) ? 'margin-top:25px;' : ''; ?> padding:0 15px 0 <?php echo (IS_MOBILE) ? '5px' : '90px' ; ?>; color:#666;">

								<?php if( '1' === $o->depth  &&  $i > 0 ) { ?>
								<div style="margin:20px 0; width:100%; height:1px; background-color:#eeeeee;"></div>
								<?php } ?>

								<div id="cmt_layer_<?php echo $o->idx ?>" style="<?php echo $reply_layer_css ?>">

									<h4 style="position:relative;font-size:15px;">
										<?php echo $o->username ?> <small style="font-size:13px; color:#a6a6a6; font-weight:normal; padding:0 5px;"> <?php echo $o->reg_datetime ?></small>


										<?php if($this->tank_auth->is_admin()  OR  (isset($this->user->id) && $this->user->id === $o->user_idx)) { ?>
										<button type="button" class="o_btn btn btn-black-flat btn-xs" onclick="cmt_edit_view(<?php echo $o->idx ?>);">수정</button>
										<button type="button" class="o_btn btn btn-black-flat btn-xs" onclick="cmt_del(<?php echo $o->idx ?>);">삭제</button>
										<?php } ?>

										<?php //if( $o->depth === '1' && $this->tank_auth->is_admin()) { ?>
										<?php if( $o->depth === '1') { ?>
										<button type="button" class="o_btn btn btn-black-flat btn-xs" onclick="cmt_reply_view(<?php echo $o->idx ?>);">답글</button>
										<?php } ?>
									</h4>

									<div id="view_cmt_<?php echo $o->idx ?>" style="margin:15px 0; padding:0;"><?php echo nl2br($o->content) ?></div>

									<!-- 코멘트 수정 -->
									<div id="edit_cmt_<?php echo $o->idx ?>" style="display: none; margin:5px 0; ">
									  <div style="position:relative; width: 100%; vertical-align:top;">
										<div style="width: calc(100% - 80px);">
											<textarea id="cmt_content_<?php echo $o->idx ?>" style="width:100%; padding:10px; border:1px solid #ccc;"><?php echo $o->content ?></textarea>
										</div>
										<div style="width:70px; position:absolute; top:0; right:0;">
											<button type="button" class="o_btn btn btn-black-flat btn-sm" style="padding:13px 15px;" onclick="cmt_write(<?php echo $o->idx ?>,'update');">수정하기</button>
										</div>
									  </div>
									</div>
									<hr style=" clear:both; border:none;" />
									

									<!-- 코멘트 댓글 -->
									<div id="reply_cmt_<?php echo $o->idx?>" style="display: none; position:relative; margin:0 0 15px 0;  padding-left:0px;  background-image:url('<?php echo IMG_DIR?>/common/icon_reply.gif'); background-repeat:no-repeat; background-position:20px 5px; ">
									  <div style="position:relative; width: 100%; vertical-align:top;">
										<div style="width: calc(100% - 80px);">
											<textarea id="reply_content_<?php echo $o->idx ?>" style="width:100%; padding:10px; border:1px solid #ccc;"></textarea>
										</div>
										<div style="width:70px; position:absolute; top:0; right:0;">
											<button type="button" class="o_btn btn btn-black-flat btn-sm" style="padding:13px 15px;" onclick="cmt_write(<?php echo $o->idx ?>,'reply');"> 답글달기</button>
										</div>
									  </div>
									  <hr style=" clear:both; border:none;" />
									</div>

									<?php if( '1' === $o->depth ) { ?>
									<div id="layer_reply_<?php echo $o->idx ?>"></div>
									<?php } ?>
									

								</div>

							</div>

							<?php } ?>
						</div>

					</div>
					<?php } ?>


					<div style="clear:both; margin:0 0 20px 0;  border-bottom:1px solid #818181;"></div>


					<div class="site-section py-0">
					  <div class="container">
						<div class="row mb-1">
							<div class="col">

									<div style="position:relative;padding:25px; text-align:center; ">



										<?php if($row->addfld_2 < date('Y-m-d') ) { ?>
										<a href="/sharecampaign/request/<?php echo $wr_idx ?>?page=<?php echo $page ?>" class="mx-3" style="text-decoration:none;" onclick="alert('나눔 캠페인 신청이 종료되었습니다.'); return false;">
											<button class="btn btn-secondary btn-md" type="button">나눔신청 마감</button>
										</a>
										<?php //} elseif( isset($this->user->level) && $this->user->level >= 20 ) { ?>
										<?php } elseif( isset($this->user->level) && $this->user->level >= 0 ) { ?>
										<a href="/sharecampaign/request/<?php echo $wr_idx ?>?page=<?php echo $page ?>" class="mx-3" style="text-decoration:none;">
											<button class="btn btn-success btn-md" type="button">나눔 신청하기</button>
										</a>
										<?php } else { ?>
											
										<?php } ?>


										<a href="<?php echo $bbs_code_url ?>/lists/page/<?php echo $page ?>" class="mr-1" style="text-decoration:none;">
											<button class="btn btn-dark btn-md" type="button">목록</button>
										</a>
										<?php if( (isset($user->id) ? $user->id : NULL) === $row->user_idx  OR  $this->tank_auth->is_admin() ) { ?>
										  <a href="<?php echo $bbs_code_url ?>/write/<?php echo $wr_idx ?>/page/<?php echo $page ?>" class="mr-1" style="text-decoration:none;">
											<button class="btn btn-dark btn-md" type="button">수정</button>
										  </a>
										  <a href="<?php echo $bbs_code_url ?>/delete/<?php echo $wr_idx ?>/page/<?php echo $page ?>" onclick="del_url('<?php echo $bbs_code_url ?>/delete/<?php echo $wr_idx ?>/page/<?php echo $page ?>'); return false;"  class="mr-1" style="text-decoration:none;">
											<button class="btn btn-dark btn-md" type="button">삭제</button>
										  </a>
										<?php } ?>
									</div>

							</div>
						</div>
					  </div>
					</div>

				</div>

			</section>


			<section style="margin-top: 100px;">
				
				<h3 class="bo_title">
					<strong>신청 내역</strong>
				</h3>
				<div style="clear:both; margin:5px 0 5px 0;  border-bottom:2px solid rgba(51,51,51,1);"></div>

				<table class="table table-hover table-md">
				  <!-- <colgroup class="dsp-none-mobile">
					<col class="d-none d-md-table-cell">
					<col>
					<col>
					<col class="d-none d-md-table-cell">
					<col class="d-none d-md-table-cell">
				  </colgroup>
				  <thead class="dsp-none-mobile">
					<tr>
					  <th class="text-center d-none d-md-table-cell" scope="col"><?php echo (IS_MOBILE) ? '' : '번호' ?></th>
					  <th class="text-center" scope="col">작성자</th>
					  <th class="text-left" scope="col">신청제목</th>
					  <th class="text-center d-none d-md-table-cell" scope="col">작성일자</th>
					  <th class="text-center d-none d-md-table-cell" scope="col">접수확인</th>
					</tr>
				  </thead> -->

				  <colgroup class="dsp-none-mobile">
					<col class="" style="width: 50px;">
					<!-- <col class="" style="width: 70px;"> -->
					<col>
					<col class="" style="width: 120px;">
					<?php if($this->tank_auth->is_admin() && $this->arr_seg[1] == 'admin') { ?>
					<col class="" style="width: 100px;">
					<col class="" style="width: 100px;">
					<?php } ?>
				  </colgroup>
				  <thead class="dsp-none-mobile ">
					<tr>
					  <th class="text-center" scope="col">번호</th>
					  <!-- <th class="text-center" scope="col">작성자</th> -->
					  <th class="text-left" scope="col">신청제목</th>
					  <th class="text-center" scope="col">작성일자</th>
					  <?php if($this->tank_auth->is_admin() && $this->arr_seg[1] == 'admin') { ?>
					  <th class="text-center" scope="col">접수확인</th>
					  <th class="text-center" scope="col">관리</th>
					  <?php } ?>
					</tr>
				  </thead>

				  <tbody>

				<?php 
				foreach($share_result['qry'] as $i => $o) {
					// 번호
					$num = ($share_result['total_count'] - $share_limit*($share_page-1) - $i);

					$btn_state_type = 'btn-secondary';
					if('확인' == $o->state) {
						$btn_state_type = 'btn-primary';
					}
					elseif('미확인' == $o->state) {
						$btn_state_type = 'btn-secondary';
					}

					// 개인인 경우, 이름에 * 처리
					$req_gubun = $o->req_gubun;
					$req_name = $o->req_name;

					
					if($req_gubun == '개인') {
						$req_name = cut_str_name($o->req_name, 0, 3, '');
						$req_name .= '*';
						$req_name .= cut_str_name($o->req_name, 6, 3, '');
					}


					$link_line = '';
					if( 'admin' === $arr_seg[1] ) { 
						$link_line = 'text-decoration: underline;';
					}
				?>
					<tr id="req_tr_<?php echo $o->idx ?>">
					  <td class="text-center "><?php echo $num ?></td>
					  <!-- <td class="text-center d-none d-md-table-cell"><?php //echo $req_name ?></td> -->
					  <td class="text-left ">

						<div>
							<!-- <div class="dsp-none-pc">
								<?php //echo $o->req_name ?> <span style="color: #a0a0a0; margin-left:10px;"> <?php //echo substr($o->req_datetime,0,10)?></span>
							</div> -->
							<a href="<?php echo current_url() ?>" class="view_request" data-id="wrap_req_<?php echo $o->idx ?>" onclick="return false;" style="<?php echo $link_line ?>"><?php echo $o->req_subject ?></a>
							<div class="dsp-none-pc">
								<span style="color: #a0a0a0; font-size:15px;"> <?php echo substr($o->req_datetime,0,10)?></span>
							</div>
						</div>

						<div id="wrap_req_<?php echo $o->idx ?>" class="wrap_req_detail" style="display: none;">
							
							<div class="req_box">
								<h2>신청자 정보</h2>
								<dl>
									<dt>신청자 구분 </dt>
									<dd><?php echo $o->req_gubun ?></dd>
								</dl>
								<dl>
									<dt>신청자명 </dt>
									<dd><?php echo $o->req_name ?></dd>
								</dl>
								<dl>
									<dt>방문주소 </dt>
									<dd>(<?php echo $o->req_postcode ?>) <?php echo $o->req_addr ?> <?php echo $o->req_addr_detail ?></dd>
								</dl>
								<dl>
									<dt>생년월일 </dt>
									<dd><?php echo $o->req_birthday ?></dd>
								</dl>
								<dl>
									<dt>휴대전화 </dt>
									<dd><?php echo $o->req_phone ?></dd>
								</dl>
								<dl>
									<dt>신청사유 </dt>
									<dd><?php echo $o->req_reason ?></dd>
								</dl>
							</div>

							
							<div class="req_box">
								<h2>수혜자 정보</h2>
								<dl>
									<dt>수혜자 구분 </dt>
									<dd><?php echo $o->bnf_gubun ?></dd>
								</dl>
								<dl>
									<dt>수혜자(단체)명 </dt>
									<dd><?php echo $o->bnf_name ?></dd>
								</dl>
								<dl>
									<dt>수혜자대상 수 </dt>
									<dd><?php echo $o->bnf_count ?></dd>
								</dl>
								<dl>
									<dt>주소 </dt>
									<dd>(<?php echo $o->bnf_postcode ?>) <?php echo $o->bnf_addr ?> <?php echo $o->bnf_addr_detail ?></dd>
								</dl>
								<dl>
									<dt>휴대전화 </dt>
									<dd><?php echo $o->bnf_phone ?></dd>
								</dl>
								<dl>
									<dt>희망기기 수량 </dt>
									<dd><?php echo $o->bnf_devices ?></dd>
								</dl>
								<dl>
									<dt>수혜대상 소개 및 기기 활용목적 </dt>
									<dd><?php echo $o->bnf_content ?></dd>
								</dl>
							</div>

						</div>
					  </td>
					  <td class="text-center d-none d-md-table-cell"><?php echo substr($o->req_datetime,0,10)?></td>
					  <?php if($this->tank_auth->is_admin() && (isset($this->arr_seg[1]) && $this->arr_seg[1] == 'admin')) { ?>
					  <td class="text-center ">
						<?php
						$state_readonly = 'readonly';
						if( 'admin' === $arr_seg[1] ) { 
							$state_readonly = '';
						}
						$btn_type = (isset($o->state) && '확인' == $o->state) ? 'btn-primary-flat' : 'btn-gray-flat';
						$btn_text =  (isset($o->state) && '' != $o->state) ? $o->state : '미확인';
						?>
							<!-- 확인/미확인 -->
							<button id="confirm_<?php echo $o->idx ?>" class="btn_confirm o_btn btn <?php echo $btn_type ?> btn-sm"  data-idx="<?php echo $o->idx ?>" <?php echo $state_readonly ?> ><?php echo $btn_text; ?></button>
					  </td>
					  <td class="text-center ">
						<!-- 삭제 관리 버튼 -->
							<button id="del_<?php echo $o->idx ?>" class="btn_del o_btn btn btn-danger-flat btn-sm"  data-idx="<?php echo $o->idx ?>" >삭제</button>
					  </td>
					  <?php } ?>
					</tr>
				<?php } ?>

				  </tbody>
				</table>
			</section>

		  </div>
		</div>


	</div>
  </div>
</div>

<?php
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - 
// 관리자 페이지에서만 관리
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - 
//if( 'admin' === $arr_seg[1] ) { 
if($this->tank_auth->is_admin()) {
?>

<script type="text/javascript">
$(document).ready(function(){


	// 삭제 버튼
	$('.btn_del').on('click', function() {
		if(confirm('정말 삭제하시겠습니까?')) {
			var req_idx = $(this).data('idx');
			// 관리자만 삭제
			var request = $.ajax({
			  url: "/trans/delete_state_request_sharecampaign/",
			  method: "POST",
			  data: { 'idx': req_idx},
			  dataType: "text"
			});
			request.done(function( res ) {
			  $('#req_tr_'+req_idx).remove();
			});
			request.fail(function( jqXHR, textStatus ) {
			  alert( "Request failed: " + textStatus );
			  return false;
			});
		}
	});
	
	
	// 접수 확인 버튼
	$('.btn_confirm').on('click', function() {

		var eid = $(this).attr('id');
		//console.log(eid);
		var idx = $(this).data('idx');
		//console.log(idx);
		var confirm_txt = $(this).text();
		//console.log(confirm_txt);


		// 삭제하려는 사람과 등록한 사람 비교 포함.
		var request = $.ajax({
		  url: "/trans/update_state_request_sharecampaign/",
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


	// 신청 내역 자세히 보기
	$('.view_request').on('click', function(){

		var view_wrap_id = $(this).data('id');
		var view_wrap = $('#'+view_wrap_id);
		var view_click_state = view_wrap.css('display');
		console.log(view_click_state);
		if(view_click_state == 'none') {
			$('.wrap_req_detail').hide();
			view_wrap.css('display','block');
		}
		else {
			$('.wrap_req_detail').hide();
		}


	});

});

</script>

<?php
}
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - 
// 관리자 페이지에서만 관리
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - 
?>




<script type="text/javascript">
$(document).ready(function() {
	$('#btn_comment').click(function(){
		var cmt_idx = false;
		cmt_write(cmt_idx,'write');
	});
});


// 코멘트 삭제
function cmt_del(cmt_idx) {

	if( confirm('코멘트를 삭제하시겠습니까?\n확인을 누르시면 해당 코멘트가 완전히 삭제됩니다.') ) {
		$.ajax({
			type: "POST",
			url: "/trans/comment_del/",
			data: { 
				'cmt_idx': cmt_idx
			}
		}).done(function( res ) {
			if('not_logged_in' == res) {
				alert('로그인을 먼저 해주세요!');
			}
			else if('not_owner' == res) {
				alert('작성자만 삭제하실 수 있습니다!');
			}
			else if('exist_reply' == res) {
				alert('답글이 달린 댓글은 삭제하실 수 없습니다!');
			}
			else {
				//$('#cmt_layer_'+cmt_idx).remove();

				// 새로고침
				location.reload();
			}
		}).fail(function(error) {
			console.log(error);
			alert( "access error.." );
		}); // 맨 마지막에 세미콜론(;)
	}

}

// 코멘트 수정버튼 클릭
function cmt_edit_view(cmt_idx) {
	$('#view_cmt_'+cmt_idx).hide();
	$('#edit_cmt_'+cmt_idx).show();
}

// 코멘트 댓글버튼 클릭
function cmt_reply_view(cmt_idx) {
	$('#reply_cmt_'+cmt_idx).show();
}

// 코멘트 작성/수정/답글
function cmt_write(cmt_idx,cmt_mode) {

	var cmt_content = $('#cmt_content').val();
	if('update' == cmt_mode) {
		// 수정시
		cmt_content = $('#cmt_content_'+cmt_idx).val();
	}
	else if('reply' == cmt_mode) {
		// 수정시
		cmt_content = $('#reply_content_'+cmt_idx).val();
	}
	else {
		cmt_mode='write';
	}


	if( '' == cmt_content ) {
		alert('코멘트를 입력해주세요.');
	}
	else {

		var bbs_code = '<?php echo $bbs_cf->bo_code ?>';
		var wr_idx = <?php echo $wr_idx ?>;

		$.ajax({
			  type: "POST",
			  url: "/trans/comment_write/",
			  data: { 
				  'bbs_code': bbs_code,
				  'bbs_idx': wr_idx,
				  'cmt_content': cmt_content,
				  'cmt_mode': cmt_mode,
				  'cmt_idx': cmt_idx
			  }
		}).done(function( res ) {
			  //alert("Data Loaded: " + res);
			  //location.replace('<?php echo current_url() ?>');
			  //location.href = '<?php echo current_url() ?>';

			  if('not_logged_in' == res) {
				alert('로그인을 먼저 해주세요!');
			  }
			  else {

				//console.log(cmt_mode);

				if('update' == cmt_mode) {
					$('#view_cmt_'+cmt_idx).show();
					$('#edit_cmt_'+cmt_idx).hide();
					// 컨텐츠 수정
					$('#view_cmt_'+cmt_idx).html(res);
				}
				else if('reply' == cmt_mode) {
					// 컨텐츠 추가
					$('#reply_content_'+cmt_idx).val('');
					//$('#layer_reply_'+cmt_idx).prepend(res);

					// 새로고침
					location.reload();
				}
				else {
					// 컨텐츠 추가
					$('#cmt_content').val('');
					//$('#layer_comment').prepend(res);

					// 새로고침
					location.reload();
				}

			  }

		}).fail(function(error) {

			  //console.log(error);

			  alert( "access error.." );
		}); // 맨 마지막에 세미콜론(;)

	}

}

</script>


