
<?php /* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * 

<!-- 페이지 서브 비주얼 -->
<div class="o_page_visual o_media_visual">
	<div class="o_ctnt">
		<dl>
			<dt class="o_page_ttl color_white">미디어</dt>
			<dd class="o_page_desc color_white">World Best Professional CCTV Manufacture</dd>
			<div style="width:32px; height:5px;background-color:#ffffff; margin:30px auto 0;"></div>
		</dl>
	</div>
</div>

<!-- 페이지 탭메뉴 -->
<div class="o_page_nav">
	<div class="o_ctnt">
		<ul class="row o_none" style="margin:0 auto; text-align:center;">
			<li class="col active"><span><a href="/board/cctv">cctv로 보는 세상</a></span></li>
			<li class="col"><span><a href="/board/cctv_man">씨읽남</a></span></li>
		</ul>
	</div>
</div>
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */ ?>

<?php
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
// 모바일 설정
$_class_container = 'container';
if(IS_MOBILE) {
	$_class_container = 'm_container_bbs';
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

</style>

<div class="contents_wrap">
	<!-- 캠페인 상세 -->
	<div class="<?php echo $_class_container ?> py_35" style="margin:0 auto;">

		<div>
			<?php echo $bbs_cf->bo_head; ?>
		</div>


		<div class="o_page_content">
			<section class="o_ctnt" >

				<div style="width:100%; height:300px; background-color:#f3f3fa;">
					나눔 신청 배너 이미지
				</div>

			</section>
		</div>

		<!-- 페이지 내용 -->
		<div class="o_page_content">
			<section class="o_ctnt" >

				<!-- <h4 class="o_content_ttl"><?php echo isset($bbs_cf->bo_title) ? $bbs_cf->bo_title : '게시판'; ?></h4> -->


				<div class="mt_20">

					<div style="border-top:3px solid rgba(51,51,51,1); border-bottom:1px solid rgba(11,11,11,.12);background-color:#FBFBFB;" >
						<h2 class="pt_10 px_10" style="margin:0; font-size:24px; font-weight:bold;">
							<?php echo $row->wr_subject ?>
						</h2>
						<p class="mt_10 px_10 py_5" style="text-align:right; font-size:16px; background-color:#ffffff; border-top:1px dashed rgba(11,11,11,.12);">
							<?php //echo $row->wr_name ?> 
							<small> 조회수 : <?php echo $row->wr_hit ?></small>
							<small class="ml_20"> 작성일 : <?php echo $row->wr_datetime_point ?></small>
						</p>
					</div>


					<div class="site-section" style="padding:15px 10px;" >
						<div class="redactor-styles wr_content_wrap" style="padding:10px 0; border:none;">
							<?php //echo $row->wr_content ?>






							<h4>신청자 정보</h4>
							<div class="tbl_purple">
								<table style="width:100%;">
									<colgroup>
										<col width="200">
										<col>
									</colgroup>
									<tr class="gubun">
										<th>구분</th>
										<td><?php echo $row->gubun ?></td>
									</tr>
									<tr>
										<th class="manager_name">신청자명</th>
										<td><?php echo $row->req_name ?></td>
									</tr>
									<tr style="display: <?php echo ('단체' == $row->gubun) ? '' : 'none'; ?>;">
										<th>상호/법인명</th>
										<td><?php echo $row->req_name_org ?></td>
									</tr>
									<tr>
										<th>주소</th>
										<td><?php echo $row->req_postcode ?> / <?php echo $row->req_addr ?> <?php echo $row->req_addr_detail ?></td>
									</tr>
									<tr>
										<th>생년월일</th>
										<td><?php echo $row->req_birthday ?></td>
									</tr>
									<tr>
										<th>휴대전화</th>
										<td><?php echo $row->req_phone ?></td>
									</tr>
									<tr>
										<th>신청사유</th>
										<td><?php echo $row->wr_subject ?></td>
									</tr>
								</table>
							</div>


							<h4 style="margin-top:40px;">수혜자 정보</h4>
							<div class="tbl_purple">
								<table style="width:100%;">
									<colgroup>
										<col width="200">
										<col>
									</colgroup>
									<tr>
										<th class="manager_name">신청자명</th>
										<td><?php echo $row->bnf_name ?></td>
									</tr>
									<tr style="display: none;">
										<th>수혜대상</th>
										<td><?php echo $row->bnf_target ?></td>
									</tr>
									<tr>
										<th>주소</th>
										<td><?php echo $row->bnf_postcode ?> / <?php echo $row->bnf_addr ?> <?php echo $row->bnf_addr_detail ?></td>
									</tr>
									<tr>
										<th>생년월일</th>
										<td><?php echo $row->bnf_birthday ?></td>
									</tr>
									<tr>
										<th>휴대전화</th>
										<td><?php echo $row->bnf_phone ?></td>
									</tr>
									<tr>
										<th>희망 기기 및 수량</th>
										<td><?php echo $row->bnf_devices ?></td>
									</tr>
									<tr>
										<th>수혜대상 소개 및<br />기기 활용목적</th>
										<td><?php echo $row->wr_content ?></td>
									</tr>
								</table>
							</div>


						</div>
					</div>


				</div>






					<?php if($bbs_cf->bo_use_comment > 0 ) { ?>

					<div class="site-section" style="margin-top:30px; border-top:3px solid rgba(51,51,51,1);  padding:25px 10px;">


						<div style="position:relative; width:100%; ">
							<div style="position:absolute; left:0; top:0; width:60px; "><h3 style="font-size:22px;">댓글</h3></div>

							<div style="position:relative; width:calc(100% - 170px); margin-left:70px;">
								<textarea id="cmt_content" style="width:100%; height:80px; padding:10px; border:1px solid #ccc;"></textarea>
							</div>

							<div style="position:absolute; right:0; top:0; width:80px;">
								<?php if ($this->tank_auth->is_logged_in()) { ?>
								<button id="o_btn btn_comment" type="button" class="o_btn btn btn-dark-flat" style="float:right; display:inline-block;margin-left:15px; height:80px;">댓글 등록</button>
								<?php } else { ?>
								<button onclick="alert('로그인을 먼저 해주세요.');" type="button" class="o_btn btn btn-dark-flat" style="float:right; display:inline-block;margin-left:15px; height:80px;">댓글 등록</button>
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
										<button type="button" class="o_btn btn btn-dark-flat btn-xs" onclick="cmt_edit_view(<?php echo $o->idx ?>);">수정</button>
										<button type="button" class="o_btn btn btn-dark-flat btn-xs" onclick="cmt_del(<?php echo $o->idx ?>);">삭제</button>
										<?php } ?>

										<?php //if( $o->depth === '1' && $this->tank_auth->is_admin()) { ?>
										<?php if( $o->depth === '1') { ?>
										<button type="button" class="o_btn btn btn-dark-flat btn-xs" onclick="cmt_reply_view(<?php echo $o->idx ?>);">답글</button>
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
											<button type="button" class="o_btn btn btn-dark-flat btn-sm" style="padding:13px 15px;" onclick="cmt_write(<?php echo $o->idx ?>,'update');">수정하기</button>
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
											<button type="button" class="o_btn btn btn-dark-flat btn-sm" style="padding:13px 15px;" onclick="cmt_write(<?php echo $o->idx ?>,'reply');"> 답글달기</button>
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
											<button class="o_btn btn btn-dark-flat " type="button">목록</button>
										</a>
										<?php /* if( (isset($user->id) ? $user->id : NULL) === $row->user_idx  OR  $this->tank_auth->is_admin() ) { ?>
										  <!-- <a href="<?php echo $bbs_code_url ?>/write/<?php echo $wr_idx ?>/page/<?php echo $page ?>" class="mx-1" style="text-decoration:none;">
											<button class="o_btn btn btn-dark-flat " type="button">수정</button>
										  </a>
										  <a href="<?php echo $bbs_code_url ?>/delete/<?php echo $wr_idx ?>/page/<?php echo $page ?>" onclick="del_url('<?php echo $bbs_code_url ?>/delete/<?php echo $wr_idx ?>/page/<?php echo $page ?>'); return false;"  class="mx-1" style="text-decoration:none;">
											<button class="o_btn btn btn-dark-flat " type="button">삭제</button>
										  </a> -->
										<?php } */ ?>

										<?php if( $this->tank_auth->is_admin() ) { ?>
										  <a href="<?php echo $bbs_code_url ?>/delete/<?php echo $wr_idx ?>/page/<?php echo $page ?>" onclick="del_url('<?php echo $bbs_code_url ?>/delete/<?php echo $wr_idx ?>/page/<?php echo $page ?>'); return false;"  class="mx-1" style="text-decoration:none;">
											<button class="o_btn btn btn-dark-flat " type="button">삭제</button>
										  </a>
										<?php } ?>
									</div>

							</div>
						</div>
					  </div>
					</div>


			</section>
		</div>
	</div>
</div>



















<script type="text/javascript">
/*
	$R('#cmt_content', { 
		focus: true,
		//toolbarExternal: '#my-external-toolbar',
		lang: 'ko',
		minHeight: '500px',
		maxHeight: '1000px',
		//plugins: ['fontsize','fontcolor','filemanager','video','table','alignment','inlinestyle','specialchars','textdirection','widget','fontfamily','fullscreen'],
		imageUpload: "/files/upload/redactor_image/<?php echo url_code('board/'. $bo_code .'/image','e') ?>/<?php echo $bo_code ?>/<?php echo $wr_idx ?>",
		fileUpload: "/files/upload/redactor_file/<?php echo url_code('board/'. $bo_code .'/files','e') ?>/<?php echo $bo_code ?>/<?php echo $wr_idx ?>",

		buttonsAddAfter: {
			after: 'deleted',
			buttons: ['underline','line', 'redo', 'undo', 'underline', 'ol', 'ul', 'sup', 'sub']
		},
		buttonsHide: ['lists']

	});
	*/
</script>

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

		$.ajax({
			  type: "POST",
			  url: "/trans/comment_write/",
			  data: { 
				  'bbs_code': '<?php echo $bbs_cf->bo_code ?>',
				  'bbs_idx': <?php echo $wr_idx ?>,
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


