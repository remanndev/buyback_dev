	<style type="text/css">
	.tabcontent,
	.tabcontent_comment { margin-bottom:50px; padding:30px 15px; background-color:#ffffff; border-left:1px solid #ccc;  border-right:1px solid #ccc;  border-bottom:1px solid #ccc;}
	
	  .cmp_detail_wrap { background-color: #f4f4f4; }
	  .cmp_aside { margin-top:15px; width:100%; padding:25px; background-color:#ffffff;}

	  .cmp_image {  }
	  .cmp_image figure { margin:0; }
	  .cmp_image figure img { width: 100%; height: auto; display: block; }

	  .cmp_aside dl.cmp_period { margin:0; }
	  .cmp_aside dl.cmp_period dt { margin:0; font-size:18px; font-weight:500; }
	  .cmp_aside dl.cmp_period dd { margin:0; font-size:26px; font-weight:700; }
	  .cmp_aside dl.cmp_period .item_percent { margin:0; padding:0; }
	  
	  .cmp_aside dl.cmp_target { margin:0; }
	  .cmp_aside dl.cmp_target dt { margin:0; font-size:18px; font-weight:500; }
	  .cmp_aside dl.cmp_target dd { margin:0; font-size:38px; font-weight:700; text-align:right; }

	  .cmp_aside dl.cmp_device { margin:0; }
	  .cmp_aside dl.cmp_device dt { margin:0; font-size:18px; font-weight:500; }
	  .cmp_aside dl.cmp_device dd { margin:0; font-size:24px; font-weight:700; text-align:right; }

	  .cmp_aside dl.cmp_org { margin:0; }
	  .cmp_aside dl.cmp_org dt { margin:0; font-size:18px; font-weight:500; }
	  .cmp_aside dl.cmp_org dd { margin:0; font-weight:400; word-break: break-all; }


	/* Style the tab */
	  .cmp_content {}

		.cmp_content .tab,
		.cmp_content .tab_comment {
		  overflow: hidden;
		  background-color: #f6f6f6;
		  margin-top:50px;
		}

		/* Style the buttons inside the tab */
		.cmp_content .tab button,
		.cmp_content .tab_comment button {
		  /* 
		  background-color: inherit; */
		  background-color: #FFFFFF;
		  float: left;
		  border: none;
		  outline: none;
		  cursor: pointer;
		  padding: 14px 16px;
		  transition: 0.3s;
		  font-size: 20px;
		  font-weight: bolder;
		  color: #a6a6a6;

		  /*
		  width:33.333%; */
		  width:50%;

		  border-bottom: 1px solid #ccc;
		  outline:0;
		}

		/*  모바일 - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - */
		@media screen and (max-width: 480px) {
		  .cmp_content .tab button {
			padding: 14px 5px;
			font-size: 4.2vw;
		  }
		}
		/* // 모바일 - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - */


		.cmp_content .tab button:first-child {
			margin-right: 0px;
		}

		/* Change background color of buttons on hover */
		.cmp_content .tab button:hover {
		  /* background-color: #ddd; */
		}

		/* Create an active/current tablink class */
		.cmp_content .tab button.active {
		  background-color: #fff;

		  border: 1px solid #ccc;
		  border-bottom: 1px solid #fff;
		  color: #000000;
		}

		/* Style the tab content */
		.cmp_content .tabcontent,
		.cmp_content .tabcontent_comment 
		{
		  display: none;
		  padding: 40px 0;
		  border-top: none;
		}
		.cmp_content .tabcontent_comment { border:1px solid #ccc; }

		.cmp_content .tabcontent p,
		.cmp_content .tabcontent_comment p {
			line-height:170%;
			color:#4f4f4f;
		}

</style>

<style>
	.opn_tooltip {
	  position: relative;
	  display: inline-block;
	}

	.opn_tooltip .tooltiptext {
	  visibility: hidden;
	  width: 120px;
	  background-color: #555;
	  color: #fff;
	  /*
	  background-color: #fff;
	  color: #555;
	  */
	  font-size:13px;
	  text-align: center;
	  border-radius: 6px;
	  padding: 5px 0;
	  position: absolute;
	  z-index: 1;
	  bottom: 125%;
	  left: 50%;
	  margin-left: -60px;
	  opacity: 0;
	  transition: opacity 0.3s;
	  border:1px solid #555;
	}

	.opn_tooltip .tooltiptext::after {
	  content: "";
	  position: absolute;
	  top: 100%;
	  left: 50%;
	  margin-left: -5px;
	  border-width: 5px;
	  border-style: solid;
	  border-color: #555 transparent transparent transparent;
	}

	.opn_tooltip:hover .tooltiptext {
	  visibility: visible;
	  opacity: 1;
	}


	.cmp_org { font-size: 19px; color: #5a5a5a; font-weight: bold; }
	.cmp_title { font-size: 25px; font-weight: bold;}
	.cmp_cate {}
	.cmp_term { font-size:19px; color: #9b9b9b; letter-spacing:-0.7px;}

	.cmp_target_wrap {margin-top:40px; }
	.cmp_target_ttl, .cmp_device_ttl { font-size: 20px; font-weight: bold;}
	.cmp_target_money { font-size:25px; font-weight: bold; color: #808080; letter-spacing:-0.7px; text-align: right; }
	.cmp_target_money > span { font-size:18px;}

	/*
	.cmp_device_list ul { margin: 15px 5px 30px 0; }
	.cmp_device_list ul li { clear:both; padding:5px 15px 5px 0; font-size: 18px; }
	.cmp_device_list ul li > span { float: right;}
	*/

	.cmp_device_list ul { margin: 0px 5px 0px 0px; padding-left: 1.5rem; }
	.cmp_device_list ul li { clear:both; padding:5px 5px 0px 0px; font-size: 17px; list-style-type: disc; }
	.cmp_device_list ul li > span { float: right;}

	#layer_cmpnews img { width:auto; max-width:100%;}

	/*
	 * 캠페인용 단체 정보
	*/
	.cmp_org_wrap {margin-top:20px; }
	dl.cmp_org_info { padding:20px; background-color:#fbfbfd; border:1px dashed #ffffff;}
	dl.cmp_org_info dt { font-size: 18px; font-weight:bold; width:100%; border-bottom:1px solid silver; padding-bottom: 10px; }
	dl.cmp_org_info dd { padding-top:10px; font-size: 15px; }
</style>

<style>
	/* [2024-12-03] 진행율 */
	.per_number { font-size: 52px; font-weight: bold; color: #009f00; }
	.per_unit { font-size: 24px; color: #009f00; }

	.cmp_goal_ttl,
	.cmp_goal_money { font-size: 22px; font-weight: bold; }
	.cmp_goal_money .money_comma { font-family: tahoma !important; color: #009f00; }
	.cmp_goal_money .money_unit {}
</style>


<style>
	.font_basic { font-family: 'Nanum Gothic','Noto Sans KR', AppleSDGothicNeo-Regular,'맑은 고딕','Malgun Gothic',dotum,'돋움',sans-serif !important; }
	/*
	.btnSnsModal .modal-title { font-size: 30px; font-weight: bold; }
	.btnSnsModal .modal-body { margin: 0 auto; text-align: center; }
	.btnSnsModal .btn_sns_link_2, 
	.btnSnsModal .btn_sns_kakao_2 { width: 96px; height: 96px; border: none; outline: none; padding: 0; }
	.btnSnsModal .btn_sns_link_2 { background:url('/assets/images/layout/btn_sns_link.png') no-repeat; background-size: 100% 100%; }
	.btnSnsModal .btn_sns_kakao_2 { background:url('/assets/images/layout/btn_sns_kakao.png') no-repeat; background-size: 100% 100%; }
	*/
	.btnSnsModal .sns_txt { font-size: 21px; text-align: center; }
	.btnSnsModal .btn_modal_close { position: absolute; top: -12px; right: 11px; width: 30px; height: 30px; border: none; }
	
	#btnSnsModal .modal-content { width: 100%; max-width: 480px; margin: 0 auto; }
	#btnSnsModal .modal-content .modal-body { width: 100%; max-width: 270px; margin: 0 auto; }
	#btnSnsModal .modal-content .modal-body div { text-align: center; }

	#btnSnsModal .modal-title { font-size: 30px; font-weight: bold; }
	#btnSnsModal .btn_sns_link_2,
	#btnSnsModal .btn_sns_kakao_2 { width: 96px; height: 96px; border: none; outline: none; padding: 0; }
	#btnSnsModal .btn_sns_link_2 { background:url('/assets/images/layout/btn_sns_link.png') no-repeat; background-size: 100% 100%; }
	#btnSnsModal .btn_sns_kakao_2 { background:url('/assets/images/layout/btn_sns_kakao.png') no-repeat; background-size: 100% 100%; }
	#btnSnsModal .sns_txt { font-size: 21px; text-align: center; }



	#btnSnsModal_mobile .modal-content { width: 80%; max-width: 280px; margin: 0 auto; }
	#btnSnsModal_mobile .modal-content .modal-body { width: 100%; max-width: 220px; margin: 0 auto; }
	#btnSnsModal_mobile .modal-content .modal-body div { text-align: center; }

	#btnSnsModal_mobile .modal-title { font-size: 24px; font-weight: bold; }
	#btnSnsModal_mobile .btn_sns_link_2,
	#btnSnsModal_mobile .btn_sns_kakao_2 { width: 64px; height: 64px; border: none; outline: none; padding: 0; }
	#btnSnsModal_mobile .btn_sns_link_2 { background:url('/assets/images/layout/btn_sns_link.png') no-repeat; background-size: 100% 100%; }
	#btnSnsModal_mobile .btn_sns_kakao_2 { background:url('/assets/images/layout/btn_sns_kakao.png') no-repeat; background-size: 100% 100%; }
	#btnSnsModal_mobile .sns_txt { font-size: 18px; text-align: center; }

</style>


<div class="d-block d-lg-none">
	<figure id="cmp_main_img_mobile"><?php echo $cmp->campaign_main_img ?></figure>
</div>


<div class="pc_wrap">
  <div class="ctnt_wrap">
	<div class="ctnt_inside">

		<div class="my-5">
		<!-- 캠페인 상세 -->
			<div class="row">

				<div class="col-12 col-lg-8">

					<div class="cmp_image d-none d-lg-block pb-4">
						<figure id="cmp_main_img"><?php echo $cmp->campaign_main_img ?></figure>
					</div>

					<div class="col-12 d-block d-lg-none">
						<div class="cmp_side_wrap pb-4">
							<div class="cmp_title"><?php echo $cmp->title ?></div>

							<?php if('' == $cmp->goal_money_comma) { ?>

							<hr />
							<div class="cmp_term"><?php echo $cmp->term_begin ?> ~ <?php echo $cmp->term_end ?></div>
							<hr />

							<?php } else { ?>

							<!-- [2024-12-03] 진행율 ** 모바일 -->
							<!-- 							 -->
							<div class="my-2">
								<div>
									<span class="per_number"><?php echo $cmp->goal_per ?></span>
									<span class="per_unit">%</span>
								</div>
								<div class="per_progress">
									<div class="progress" style="height: .4rem;" role="progressbar" aria-label="Success example" aria-valuenow="<?php echo $cmp->goal_per ?>" aria-valuemin="0" aria-valuemax="100">
									  <div class="progress-bar bg-success" style="width: <?php echo $cmp->goal_per ?>%"></div>
									</div>
								</div>
							</div>

							<div class="cmp_term dsp_flex_x_end">
								<?php echo $cmp->term_end ?> 까지
							</div>

							<!-- [2024-12-03] 모금 목표 -->
							<!-- -->
							<div class="dsp_flex_sp_between pt-4">
								<div class="cmp_goal_ttl">모금 목표</div>
								<div class="cmp_goal_money">
									<span class="money_comma"><?php echo $cmp->goal_money_comma ?></span> <span class="money_unit">원</span>
								</div>
							</div>

							<hr class="my-2 mb-3" style="height: 2px; background-color: #000; opacity: .5;" />
							 
							<?php } ?>


							<div class="cmp_device_wrap pt-4 mb-4 pb-3">
								<div class="cmp_device_ttl">필요한 디지털 기기</div>
								<div class="cmp_device_list">
									<?php echo $cmp->goal_desc ?>
								</div>
							</div>


							<div class="dsp_flex_sp_between">
								<div class="cmp_btn" style="width: calc(100% - 78px); height: 64px;">
									<?php if($cmp->term_end < date('Y-m-d')) { ?>
									  <a href="#" onclick="alert('기부캠페인 기간이 종료되었습니다.'); return false;">
										<button class="o_btn o_btn_block btn-gray-flat my-0 py-0" style="border: none;"><h3 style="height: 64px; line-height: 64px; margin:0; font-weight: bold;">종 료</h3></button>
									  </a>
									<?php } else { ?>
									  <a href="<?php echo base_url() ?>campaign/donation/<?php echo $code; ?><?php echo ('' != $utm_qstr) ? '?'.$utm_qstr : ''; ?>" style="text-decoration:none;">
										<button class="o_btn o_btn_block btn-success-flat my-0 py-0" style="border: none;"><h3 style="height: 64px; line-height: 64px; margin:0; font-weight: bold;">기부하기</h3></button>
									  </a>
									<?php } ?>
								</div>
								<a href="#" onclick="return false;" type="button" data-bs-toggle="modal" data-bs-target="#btnSnsModal_mobile"><img src="<?php echo IMG_DIR ?>/layout/btn_sns_share.png" style="height: 64px;" /></a>

								
							</div>

							<!-- Modal -->
							<div class="modal fade btnSnsModal" id="btnSnsModal_mobile" tabindex="-1" aria-labelledby="btnSnsModalLabel_mobile" aria-hidden="true">
							  <div class="modal-dialog modal-dialog-centered">
								<div class="modal-content radius_10 pt-4 pb-4">
								  <div class="modal-header dsp_flex_x_center" style="border: none;">
									<h2 class="modal-title font_basic fs-10" id="btnSnsModalLabel_mobile">공유하기</h2>
									<button type="button" class="btn-close btn_modal_close" data-bs-dismiss="modal" aria-label="Close"></button>
								  </div>
								  <div class="modal-body">
									<div class="dsp_flex_sp_between">
										<div>
											<input type="button" class="btn_sns_link_2" onclick="copyToClipboard('link-to-copy-mobile');" data-bs-dismiss="modal" aria-label="Close" >
											<div class="sns_txt font_basic">링크 복사</div>
											<div id="link-to-copy-mobile" class="d-none"><?php echo current_url(); ?></div>
										</div>
										<div>
											<input id="kakaotalk-sharing-btn-mobile" type="button" class="btn_sns_kakao_2" data-bs-dismiss="modal" aria-label="Close" >
											<div class="sns_txt font_basic">카카오 공유</div>
										</div>
									</div>
								  </div>
								</div>
							  </div>
							</div>


							<div class="cmp_org_wrap">
								<!-- 단체 소개 -->
								<dl class="cmp_org_info">
									<dt>
										<?php echo $cmp->org_name ?>
										<?php if( isset($cmp->org_link) && $cmp->org_link != '') { ?>
										<a href="<?php echo $cmp->org_link ?>"><button class="btn btn-secondary btn-xs">바로가기</button></a>
										<?php } ?>
									</dt>
									<dd class="mt-2"><?php echo $cmp->org_info ?></dd>
								</dl>
							</div>

							<?php if( isset($cmp->cmp_website) && $cmp->cmp_website != '') { ?>
							<div>
								<a href="<?php echo $cmp->cmp_website ?>" target="_npo"><button type="button" class="btn btn-light btn-block py-2" style="font-size: .9rem; border: 1px solid #dbdbdb;">NPO 홈페이지 바로가기 > </button></a>
							</div>
							<?php } ?>

						</div>
					</div>


					<!-- 
						1. 캠페인 소개 
						2. 모금 소식
					-->
					<div class="cmp_content">

						<div id="btns_campaign_open" class="tab">
						  <button type="button" class="tablinks active" onclick="openTab(event, 'tab_campaign')" id="campaignOpen_cmp">캠페인 소개</button>
						  <button type="button" class="tablinks" onclick="openTab(event, 'tab_cmpnews')" id="cmpnewsOpen_news">모금 소식</button>
						</div>

						<input type="hidden" id="cmptab" value="<?php echo $cmptab ?>" />
						<div id="tab_campaign" class="tabcontent wrap_figure" style="padding:25px;">

							<?php echo (isset($cmp->ctnt_ttl_1) && '' != $cmp->ctnt_ttl_1) ? '<h5>'.$cmp->ctnt_ttl_1.'</h5>' : '' ?>
							<?php echo (isset($cmp->ctnt_detail_1) && '' != $cmp->ctnt_detail_1) ? '<p>'.nl2br($cmp->ctnt_detail_1).'</p>' : '' ?>
							<?php echo (isset($cmp->ctnt_file_img[1]) && '' != $cmp->ctnt_file_img[1]) ? '<p class="pb-4">'.$cmp->ctnt_file_img[1].'</p>' : '' ?>
							<?php echo (isset($cmp->ctnt_ttl_2) && '' != $cmp->ctnt_ttl_2) ? '<h5>'.$cmp->ctnt_ttl_2.'</h5>' : '' ?>
							<?php echo (isset($cmp->ctnt_detail_2) && '' != $cmp->ctnt_detail_2) ? '<p>'.nl2br($cmp->ctnt_detail_2).'</p>' : '' ?>
							<?php echo (isset($cmp->ctnt_file_img[2]) && '' != $cmp->ctnt_file_img[2]) ? '<p class="pb-4">'.$cmp->ctnt_file_img[2].'</p>' : '' ?>
							<?php echo (isset($cmp->ctnt_ttl_3) && '' != $cmp->ctnt_ttl_3) ? '<h5>'.$cmp->ctnt_ttl_3.'</h5>' : '' ?>
							<?php echo (isset($cmp->ctnt_detail_3) && '' != $cmp->ctnt_detail_3) ? '<p>'.nl2br($cmp->ctnt_detail_3).'</p>' : '' ?>
							<?php echo (isset($cmp->ctnt_file_img[3]) && '' != $cmp->ctnt_file_img[3]) ? '<p class="pb-4">'.$cmp->ctnt_file_img[3].'</p>' : '' ?>

							<?php echo $cmp->content ?>
						</div>
						<div id="tab_cmpnews" class="tabcontent" style="padding:25px;">
							
							<?php 
							// 로그인 회원 정보
							if ($this->tank_auth->is_admin()  OR  $login_is_writer) { // logged in
							?>
							  <?php echo form_open($this->uri->uri_string(), array('id'=>'cmpnews_form','name'=>'cmpnews_form', 'onsubmit'=>'return false;')); ?>
								<div id="cmpnews_layer_real" style="display: none;">
									<textarea id="cmpnews_content" name="cmpnews_content" class="o_input cmpnews_content" style="width:100%; min-width:100%; max-width:100%; height:70px; min-height:70px; max-height:70px;"></textarea>
									<div class="py_10" style="text-align:right;">
										<button type="submit" id="btn_cmpnews" class="o_btn btn-info btn-lg" style="padding:12px 30px; color:#ffffff; background-color:#1b92cb;" data-cmpidx="<?php echo $cidx ?>" data-cmpcode="<?php echo $code; ?>">소식 등록</button>
									</div>
								</div>
								<div id="cmpnews_layer_btn">
									<div class="py_10" style="text-align:right;">
										<button type="button" id="btn_cmpnews" class="o_btn btn-info btn-lg" style="padding:12px 30px; color:#ffffff; background-color:#1b92cb;" onclick="fn_use_cmpnews();">소식 등록</button>
									</div>
								</div>
								<script>
									function fn_use_cmpnews() {
										$('#cmpnews_layer_btn').hide();
										$('#cmpnews_layer_real').fadeIn();
									}
								</script>

							  <?php echo form_close(); ?>
							<?php } ?>
							<?php if($result_cmpnews['total_count'] > 0) { ?>
							<div id="layer_cmpnews" style="border-top:1px solid #939393;">
								<?php
								foreach($result_cmpnews['qry'] as $i => $o) {
								?>
									<div style="padding:15px 0; border-bottom:1px solid #dddddd;">
										<small style="color:gray; margin-right:15px;"><strong style="color:#000; margin-right:15px; "><?php echo isset($o->user_id) && '' != $o->user_id ? $o->user_nickname : 'guest'; ?></strong> <?php echo substr($o->reg_datetime,0,16); ?></small>
										<?php if($this->tank_auth->is_admin()  OR  (isset($this->user_idx) && $this->user_idx === $o->user_idx)) { ?>
										<button type="button" class="btn btn-dark-flat btn-xs" onclick="cmpnews_edit_view(<?php echo $o->idx ?>);">수정</button>
										<button type="button" class="btn btn-danger-flat btn-xs" onclick="cmpnews_del(<?php echo $o->idx ?>);">삭제</button>
										<?php } ?>
										<div id="view_cmpnews_<?php echo $o->idx ?>" class="wrap_figure" style="padding-top:5px; font-size:15px; color:#2c2c2c; font-weight:bold;"><?php echo nl2br($o->content) ?></div>
										<!-- 코멘트 수정 -->
										<div id="edit_cmpnews_<?php echo $o->idx ?>" style="display: none; margin:5px 0; ">
										  <div style="position:relative; width: 100%; vertical-align:top;">
											<div style="width: calc(100% - 85px);">
												<textarea id="cmpnews_content_<?php echo $o->idx ?>" class="cmpnews_content" style="width:100%; min-width:100%; max-width:100%; padding:10px; border:1px solid #ccc;font-size:15px;"><?php echo $o->content ?></textarea>
											</div>
											<div style="position:absolute; top:0; right:0;">
												<button type="button" class="btn btn-secondary btn-sm" style="padding:20px 15px;" onclick="cmpnews_write('update',<?php echo $o->idx ?>);">수정하기</button>
											</div>
										  </div>
										</div>
									</div>
								<?php
								}
								?>
							</div>
							<?php 
							} else { 
								// 로그인 회원 정보
								if (! $this->tank_auth->is_admin()  &&  ! $login_is_writer) { // logged in
									echo '아직 등록된 모금 소식이 없습니다.';
								}
							}
							?>
						</div>
					</div>




					<!-- 
						3. 응원 댓글 (코멘트)
						
						// 응원 댓글은 자동 출력
						openTab(event, 'tab_comment');
					-->
					<div class="cmp_content">

						<div style="font-weight: bold;">
						  <h5 style="font-weight: bold;">응원 댓글</h5>
						</div>

						<input type="hidden" id="cmp_idx" value="<?php echo $cidx ?>" />
						<div id="tab_comment" class="tabcontent_comment" style="padding:25px; display: block;">
							<?php if ($this->tank_auth->is_logged_in()) { // logged in ?>
							  <?php echo form_open($this->uri->uri_string(), array('id'=>'comment_form','name'=>'comment_form', 'onsubmit'=>'return false;')); ?>

								<!-- <input type="hidden" id="cmp_idx" value="<?php //echo $cidx ?>" /> -->
								<div id="cmt_layer_real" style="display: ;">
								  <textarea id="cmt_content" name="cmt_content" class="o_input" style="width:100%; min-width:100%; max-width:100%; height:120px; min-height:120px; max-height:120px;"></textarea>
								  <div class="py_10" style="text-align:right;">
									<button type="submit" id="btn_comment" class="o_btn btn-info btn-lg" style="padding:12px 30px; color:#ffffff; background-color:#1b92cb;">댓글 달기</button>
								  </div>
								</div>
							  <?php echo form_close(); ?>
							<?php } else { ?>
								<textarea id="cmt_content" name="cmt_content" class="o_input" style="width:100%; min-width:100%; max-width:100%; height:120px; min-height:120px; max-height:120px;" disabled placeholder="로그인 후에 이용해주세요."></textarea>
								<div class="py_10" style="text-align:right;">
									<button type="submit" id="btn_disabled" class="o_btn btn-info btn-lg"  style="padding:12px 30px; color:#ffffff; background-color:#1b92cb;" onclick="alert('로그인 후에 이용해주세요.');" >댓글 달기</button>
								</div>
							<?php } ?>
							<?php if($result_cmt['total_count'] > 0) { ?>
							<div id="layer_comment" style="border-top:1px solid #939393;">
								<?php
								foreach($result_cmt['qry'] as $i => $o) {
									$reply_layer_css = "";
									// 답글인 경우
									if( '2' === $o->depth ) {
										$reply_layer_css = "margin:0; padding:10px; padding-left:50px; background-color:#f9f9f9; background-image:url('". IMG_DIR."/common/icon_reply.gif'); background-repeat:no-repeat; background-position:20px 17px; ";
									}
								?>
									<div style="padding:15px; border-bottom:1px solid #dddddd; <?php echo $reply_layer_css ?>">
										<small style="color:gray; margin-right:15px;"><strong style="color:#000; margin-right:15px; "><?php echo isset($o->user_name) && '' != $o->user_name ? $o->user_name : 'guest'; ?></strong> <?php echo substr($o->reg_datetime,0,16); ?></small>
										<?php if($this->tank_auth->is_admin()  OR  (isset($this->user_idx) && $this->user_idx === $o->user_idx)) { ?>
										<button type="button" class="btn btn-dark-flat btn-xs" onclick="cmt_edit_view(<?php echo $o->idx ?>);">수정</button>
										<?php if($this->tank_auth->is_admin() && $o->depth === '1') { ?>
										<button type="button" class="btn btn-dark-flat btn-xs" onclick="cmt_reply_view(<?php echo $o->idx ?>);">답글</button>
										<?php } ?>
										<button type="button" class="btn btn-danger-flat btn-xs" onclick="cmt_del(<?php echo $o->idx ?>);">삭제</button>
										<?php } ?>
										<div id="view_cmt_<?php echo $o->idx ?>" style="padding-top:5px; font-size:15px; color:#2c2c2c; font-weight:normal;"><?php echo nl2br($o->content) ?></div>
										<!-- 코멘트 수정 -->
										<div id="edit_cmt_<?php echo $o->idx ?>" style="display: none; margin:5px 0; ">
										  <div style="position:relative; width: 100%; vertical-align:top;">
											<div style="width: calc(100% - 85px);">
												<textarea id="cmt_content_<?php echo $o->idx ?>" style="width:100%; min-width:100%; max-width:100%; padding:10px; border:1px solid #ccc;font-size:15px;"><?php echo $o->content ?></textarea>
											</div>
											<div style="position:absolute; top:0; right:0;">
												<button type="button" class="btn btn-secondary btn-sm" style="padding:20px 15px;" onclick="cmp_cmt_write(<?php echo $o->idx ?>,'update');">수정하기</button>
											</div>
										  </div>
										</div>
										<!-- 코멘트 댓글 -->
										<div id="reply_cmt_<?php echo $o->idx?>" style="display: none; position:relative; margin:15px 0;  padding-left:35px;  background-image:url('<?php echo IMG_DIR?>/common/icon_reply.gif'); background-repeat:no-repeat; background-position:5px 5px; ">
										  <div style="position:relative; width: 100%; vertical-align:top;">
											<div style="width: calc(100% - 85px);">
												<textarea id="reply_content_<?php echo $o->idx ?>" style="width:100%; min-width:100%; max-width:100%; padding:10px; border:1px solid #ccc;"></textarea>
											</div>
											<div style="position:absolute; top:0; right:0;">
												<button type="button" class="btn btn-secondary btn-sm" style="padding:20px 15px;" onclick="cmp_cmt_write(<?php echo $o->idx ?>,'reply');"> 답글달기</button>
											</div>
										  </div>
										  <hr style=" clear:both; border:none;" />
										</div>
									</div>
								<?php
								}
								?>
							</div>
							<?php } ?>
						</div>
					</div>

				</div>

				<div class="col-12 col-lg-4 d-none d-lg-block">
					<div class="cmp_side_wrap pb-4 px-3">
						<div class="cmp_title"><?php echo $cmp->title ?></div>


						<?php if('' == $cmp->goal_money_comma) { ?>

						<hr />
						<div class="cmp_term"><?php echo $cmp->term_begin ?> ~ <?php echo $cmp->term_end ?></div>
						<hr />

						<?php } else { ?>

						<!-- ### 삭제 금지 # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # -->
						<!-- [2024-12-03] 진행율 ** 데스크탑 -->
						<!-- 						-->

						<div class="my-2">
							<div>
								<span class="per_number"><?php echo $cmp->goal_per ?></span>
								<span class="per_unit">%</span>
							</div>
							<div class="per_progress">
								<div class="progress" style="height: .4rem;" role="progressbar" aria-label="Success example" aria-valuenow="<?php echo $cmp->goal_per ?>" aria-valuemin="0" aria-valuemax="100">
								  <div class="progress-bar bg-success" style="width: <?php echo $cmp->goal_per ?>%"></div>
								</div>
							</div>
						</div>

						<div class="cmp_term dsp_flex_x_end">
							<?php echo $cmp->term_end ?> 까지
						</div>

						<!-- [2024-12-03] 모금 목표 -->
						<!--  -->
						<div class="dsp_flex_sp_between pt-4">
							<div class="cmp_goal_ttl">모금 목표</div>
							<div class="cmp_goal_money">
								<span class="money_comma"><?php echo $cmp->goal_money_comma ?></span> <span class="money_unit">원</span>
							</div>
						</div>

						<hr class="my-2 mb-3" style="height: 2px; background-color: #000; opacity: .5;" />

						<!-- ### 삭제 금지 # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # -->
						<?php } ?>




						<div class="cmp_device_wrap pt-4 mb-4 pb-3">
							<div class="cmp_device_ttl">목표 모금 수량</div>
							<div class="cmp_device_list">
								<?php echo $cmp->goal_desc ?>
							</div>
						</div>

						<div class="dsp_flex_sp_between">
							<div class="cmp_btn" style="width: calc(100% - 78px); height: 64px;">
								<?php if($cmp->term_end < date('Y-m-d')) { ?>
								  <a href="#" onclick="alert('기부캠페인 기간이 종료되었습니다.'); return false;">
									<button class="o_btn o_btn_block btn-gray-flat my-0 py-0" style="border: none;"><h3 style="height: 64px; line-height: 64px; margin:0; font-weight: bold;">종 료</h3></button>
								  </a>
								<?php } else { ?>
								  <a href="<?php echo base_url() ?>campaign/donation/<?php echo $code; ?><?php echo ('' != $utm_qstr) ? '?'.$utm_qstr : ''; ?>" style="text-decoration:none;">
									<button class="o_btn o_btn_block btn-success-flat my-0 py-0" style="border: none;"><h3 style="height: 64px; line-height: 64px; margin:0; font-weight: bold;">기부하기</h3></button>
								  </a>
								<?php } ?>
							</div>
							<a href="#" onclick="return false;" type="button" data-bs-toggle="modal" data-bs-target="#btnSnsModal"><img src="<?php echo IMG_DIR ?>/layout/btn_sns_share.png" style="height: 64px;" /></a>

							
						</div>

						<!-- Modal -->
						<div class="modal fade btnSnsModal" id="btnSnsModal" tabindex="-1" aria-labelledby="btnSnsModalLabel" aria-hidden="true">
						  <div class="modal-dialog modal-dialog-centered">
							<div class="modal-content radius_10 pt-4 pb-5">
							  <div class="modal-header dsp_flex_x_center" style="border: none;">
								<h2 class="modal-title font_basic fs-10" id="btnSnsModalLabel">공유하기</h2>
								<button type="button" class="btn-close btn_modal_close" data-bs-dismiss="modal" aria-label="Close"></button>
							  </div>
							  <div class="modal-body">
								<div class="dsp_flex_sp_between" style="">
									<div>
										<input type="button" class="btn_sns_link_2" onclick="copyToClipboard('link-to-copy');" data-bs-dismiss="modal" aria-label="Close" >
										<div class="sns_txt font_basic">링크 복사</div>
										<div id="link-to-copy" class="d-none"><?php echo current_url(); ?></div>
									</div>
									<div>
										<input id="kakaotalk-sharing-btn" type="button" class="btn_sns_kakao_2" data-bs-dismiss="modal" aria-label="Close" >
										<div class="sns_txt font_basic">카카오 공유</div>
									</div>
								</div>
							  </div>
							</div>
						  </div>
						</div>

						<div class="cmp_org_wrap">
							<!-- 단체 소개 -->
							<dl class="cmp_org_info">
								<dt>
									<?php echo $cmp->org_name ?>
									<?php if( isset($cmp->org_link) && $cmp->org_link != '') { ?>
									<a href="<?php echo $cmp->org_link ?>"><button class="btn btn-secondary btn-xs">바로가기</button></a>
									<?php } ?>
								</dt>
								<dd class="mt-2"><?php echo $cmp->org_info ?></dd>
							</dl>

							<?php if( isset($cmp->cmp_website) && $cmp->cmp_website != '') { ?>
							<div>
								<a href="<?php echo $cmp->cmp_website ?>" target="_npo"><button type="button" class="btn btn-light btn-block py-2" style="font-size: .9rem; border: 1px solid #dbdbdb;">NPO 홈페이지 바로가기 > </button></a>
							</div>
							<?php } ?>
						</div>



						<div class="pc_wrap d-none d-lg-block">
						<?php 
							// [MOBILE] 캠페인 목록
							$this->load->view('campaign/list_random_view_pc_side');
						?>
						</div>




					</div>
				</div>
			</div>
		</div>



		<div class="pc_wrap d-none d-lg-block">
		<?php 
		// [PC] 캠페인 목록
		$this->load->view('campaign/list_random_view_pc');
		?>
		</div>

		<div class="mobile_wrap d-block d-lg-none">
		<?php 
		// [MOBILE] 캠페인 목록
		$this->load->view('campaign/list_random_view_mobile');
		?>
		</div>



	</div>
  </div>
</div>

<script type="text/javascript">
	function tab_sess(tab_name) {
		$.ajax({
			  type: "POST",
			  url: "/trans/sess_cmptab/"+tab_name,
			  data: { 
				  'tab_name': tab_name
			  }
		}).done(function( res ) {
			  //alert("Data Loaded: " + res);
		}).fail(function(error) {
			  //console.log(error);
			  //alert( "access error.." );
		}); // 맨 마지막에 세미콜론(;)
	}

	function openTab(evt, tabName) {
	  var i, tabcontent, tablinks;
	  tabcontent = document.getElementsByClassName("tabcontent");
	  for (i = 0; i < tabcontent.length; i++) {
		tabcontent[i].style.display = "none";
	  }

	  tablinks = document.getElementsByClassName("tablinks");
	  for (i = 0; i < tablinks.length; i++) {
		tablinks[i].className = tablinks[i].className.replace(" active", "");
	  }
	  document.getElementById(tabName).style.display = "block";
	  evt.currentTarget.className += " active";

	  //sess_cmptab
	  tab_sess(tabName);
	}


	function trigger_openTab(id, tabName) {
	  var i, tabcontent, tablinks;
	  tabcontent = document.getElementsByClassName("tabcontent");
	  for (i = 0; i < tabcontent.length; i++) {
		tabcontent[i].style.display = "none";
	  }

	  tablinks = document.getElementsByClassName("tablinks");
	  for (i = 0; i < tablinks.length; i++) {
		tablinks[i].className = tablinks[i].className.replace(" active", "");
	  }
	  document.getElementById(tabName).style.display = "block";
	  //evt.currentTarget.className += " active";
	  $('#'+id).addClass('active');

	  //sess_cmptab
	  tab_sess(tabName);
	}


	/*
	// Get the element with id="defaultOpen" and click on it
	//var cmptab = '<?php echo ($cmptab && '' != $cmptab) ? $cmptab : "campaign" ?>'; //$('#cmptab').val();
	var cmptab = '<?php echo $cmptab ?>'; //$('#cmptab').val();
	console.log(cmptab+'Open');
	document.getElementById(cmptab+'Open').click();
	*/

	$(document).ready(function(){

		var cmptab = '<?php echo $cmptab ?>'; //$('#cmptab').val();
		//console.log(cmptab+'Open');
		//document.getElementById(cmptab+'Open').click();
		var btnID = '<?php echo str_replace("tab_","",$cmptab); ?>Open';

		$('#'+cmptab).bind('click',function(){
			$('.tablinks').removeClass('active');
			$('#'+btnID).addClass('active');
			$('#'+cmptab).show();
		});
		$('#'+cmptab).trigger('click');

	});



	// 이미지 figure.f_img { height=auto }
	$(document).ready(function(){
		$('figure > img').parent().css('height','auto').css('padding',0);
	});
</script>

<script type="text/javascript">
	$R('.cmpnews_content', { 
		focus: true,
		//toolbarExternal: '#my-external-toolbar',
		lang: 'ko',
		minHeight: '300px',
		maxHeight: '500px',
		plugins: ['fontsize','fontcolor','filemanager','video','table','alignment','inlinestyle','specialchars','widget','fontfamily','fullscreen'],
		imageUpload: "/files/upload/redactor_image/<?php echo url_code('campaign/image','e') ?>/<?php echo $code ?>/<?php echo $cidx ?>",
		imagePosition: true,
		fileUpload: "/files/upload/redactor_file/<?php echo url_code('campaign/files','e') ?>/<?php echo $code ?>/<?php echo $cidx ?>",
		/*
		buttonsAddAfter: {
			after: 'deleted',
			buttons: ['underline','line', 'redo', 'undo', 'underline', 'ol', 'ul', 'sup', 'sub']
		},
		*/
		buttonsHide: ['lists']
	});
</script>


<script type="text/javascript">
$(document).ready(function(){

	<?php if($cmp->term_end < date('Y-m-d')) { ?>
		// 종료된 캠페인 기본 탭
		trigger_openTab('cmpnewsOpen_news', 'tab_cmpnews');
	<?php } else { ?>
		// 진행중 캠페인 기본 탭
		trigger_openTab('campaignOpen_cmp', 'tab_campaign');
	<?php } ?>

});
</script>



<!--  카카오 공유  -->

<!-- <a id="kakaotalk-sharing-btn-sample" href="javascript:;">
  <img src="https://developers.kakao.com/assets/img/about/logos/kakaotalksharing/kakaotalk_sharing_btn_medium.png"
    alt="카카오톡 공유 보내기 버튼" />
</a> -->

<script src="https://t1.kakaocdn.net/kakao_js_sdk/2.7.4/kakao.min.js"
  integrity="sha384-DKYJZ8NLiK8MN4/C5P2dtSmLQ4KwPaoqAfyA/DfmEc1VDxu4yyC7wy6K1Hs90nka" crossorigin="anonymous"></script>
<script>
  Kakao.init('a217aa850a224a735be93a6fbe593173'); // 사용하려는 앱의 JavaScript 키 입력
</script>

<script> 
  // 현재 링크
  //var url ='<?php echo current_url(); ?>';
  var page_url = window.location.href;

  // 페이지 타이틀
  //var page_title = '캠페인';
  // const metaTitle = document.querySelector('meta[name="og:title"]').content;
	const metaOGTitle = $('meta[property="og:title"]').attr('content');
	//console.log(metaOGTitle);

  // 페이지 설명
  //var page_description = '설명';
  // const metaDescription = document.querySelector('meta[name="og:description"]').content;
	const metaDescription = $('meta[property="og:description"]').attr('content');
	//console.log(metaDescription);

  // 프로토콜 (http, https) 가져오기
	const protocol = window.location.protocol;
	//console.log(protocol); // 예: "https:"

  // 도메인 가져오기
	const domain = window.location.hostname;
	//console.log(domain); // 예: "example.com"

	

  // 페이지 대표 이미지
  // var page_image = '';
	var page_image_src = $('#cmp_main_img_mobile > img').attr('src');
	//console.log(page_image_src);

	var page_image_url = protocol+'//'+domain+page_image_src;





  Kakao.Share.createDefaultButton({
    container: '#kakaotalk-sharing-btn',
    objectType: 'feed',
    content: {
      title: metaOGTitle,
      description: metaDescription,
      imageUrl: page_image_url,
      link: {
        // [내 애플리케이션] > [플랫폼] 에서 등록한 사이트 도메인과 일치해야 함
        mobileWebUrl: page_url,
        webUrl: page_url,
      },
    },
    buttons: [
      {
        title: '웹으로 보기',
        link: {
          mobileWebUrl: page_url,
          webUrl: page_url,
        },
      },
      {
        title: '앱으로 보기',
        link: {
          mobileWebUrl: page_url,
          webUrl: page_url,
        },
      },
    ],
  });

  Kakao.Share.createDefaultButton({
    container: '#kakaotalk-sharing-btn-mobile',
    objectType: 'feed',
    content: {
      title: metaOGTitle,
      description: metaDescription,
      imageUrl: page_image_url,
      link: {
        // [내 애플리케이션] > [플랫폼] 에서 등록한 사이트 도메인과 일치해야 함
        mobileWebUrl: page_url,
        webUrl: page_url,
      },
    },
    buttons: [
      {
        title: '웹으로 보기',
        link: {
          mobileWebUrl: page_url,
          webUrl: page_url,
        },
      },
      {
        title: '앱으로 보기',
        link: {
          mobileWebUrl: page_url,
          webUrl: page_url,
        },
      },
    ],
  });
</script>