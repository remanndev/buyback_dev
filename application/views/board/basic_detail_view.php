<style type="text/css">
	.bo_title strong {font-size:34px; }
</style>

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
						<div class="bbs_info mt_10 px_10">
							<?php //echo $row->wr_name ?> 
							<small> 조회수 : <?php echo $row->wr_hit ?></small>
							<small class="ml_20"> 작성일 : <?php echo $row->wr_datetime_point ?></small>
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
							  <?php echo $row->wr_content ?>
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


					<div style="clear:both; margin:0 0 30px 0;  border-bottom:2px solid rgba(51,51,51,1);"></div>


					<div class="site-section py-0">
					  <div class="container">
						<div class="row mb-1">
							<div class="col">

									<div style="position:relative;padding:25px; text-align:center; ">
										<a href="<?php echo $bbs_code_url ?>/lists/page/<?php echo $page ?>" class="mx-1" style="text-decoration:none;">
											<button class="btn btn-dark btn-sm" type="button">목록</button>
										</a>
										<?php if( (isset($user->id) ? $user->id : NULL) === $row->user_idx  OR  $this->tank_auth->is_admin() ) { ?>
										  <a href="<?php echo $bbs_code_url ?>/write/<?php echo $wr_idx ?>/page/<?php echo $page ?>" class="mx-1" style="text-decoration:none;">
											<button class="btn btn-dark btn-sm" type="button">수정</button>
										  </a>
										  <a href="<?php echo $bbs_code_url ?>/delete/<?php echo $wr_idx ?>/page/<?php echo $page ?>" onclick="del_url('<?php echo $bbs_code_url ?>/delete/<?php echo $wr_idx ?>/page/<?php echo $page ?>'); return false;"  class="mx-1" style="text-decoration:none;">
											<button class="btn btn-dark btn-sm" type="button">삭제</button>
										  </a>
										<?php } ?>
									</div>

							</div>
						</div>
					  </div>
					</div>

				</div>

			</section>

		  </div>
		</div>


	</div>
  </div>
</div>














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


