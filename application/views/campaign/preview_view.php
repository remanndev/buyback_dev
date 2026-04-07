<style type="text/css">
	.tabcontent { margin-bottom:50px; padding:30px 15px; background-color:#ffffff; border-left:1px solid #ccc;  border-right:1px solid #ccc;  border-bottom:1px solid #ccc;}
	.cmp_image {  }
	.cmp_image figure { margin:0; }
	.cmp_image figure img { width: 100%; height: auto; display: block; }
	/* Style the tab */
	.cmp_content {}
	.cmp_content .tab { overflow: hidden; background-color: #f6f6f6; margin-top:50px; }
	/* Style the buttons inside the tab */
	.cmp_content .tab button { background-color: #FFFFFF; float: left; border: none; outline: none; cursor: pointer; padding: 14px 16px; transition: 0.3s; font-size: 20px; font-weight: bolder; color: #a6a6a6; width:33.333%; border-bottom: 1px solid #ccc; outline:0; }
	/*  모바일 - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - */
	@media screen and (max-width: 480px) {
	  .cmp_content .tab button { padding: 14px 5px; font-size: 4.2vw; }
	}
	/* // 모바일 - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - */
	.cmp_content .tab button:first-child { margin-right: 0px; }
	/* Change background color of buttons on hover */
	.cmp_content .tab button:hover { /* background-color: #ddd; */ }
	/* Create an active/current tablink class */
	.cmp_content .tab button.active { background-color: #fff; border: 1px solid #ccc; border-bottom: 1px solid #fff; color: #000000; }
	/* Style the tab content */
	.cmp_content .tabcontent { padding: 40px 0; border-top: none; }
	.cmp_content .tabcontent p { line-height:170%; color:#4f4f4f; }
</style>

<style>
	.cmp_org { font-size: 19px; color: #9b9b9b; font-weight: bold; }
	.cmp_title { font-size: 25px; font-weight: bold;}
	.cmp_cate {}
	.cmp_term { font-size:19px; color: #9b9b9b; letter-spacing:-0.7px;}
	.cmp_target_wrap {margin-top:40px; }
	.cmp_target_ttl, .cmp_device_ttl { font-size: 20px; font-weight: bold;}
	.cmp_target_money { font-size:25px; font-weight: bold; color: #808080; letter-spacing:-0.7px; text-align: right; }
	.cmp_target_money > span { font-size:18px;}
	.cmp_device_list ul { margin: 15px 5px 30px 0; }
	.cmp_device_list ul li { clear:both; padding:5px 15px 5px 0; font-size: 18px; }
	.cmp_device_list ul li > span { float: right;}
	/*
	 * 캠페인용 단체 정보 */
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


<div class="d-block mt-4">
  <div class="ctnt_wrap px-3">
	<div class="ctnt_inside text-center p-3" style="background-color: #ececec; border: dashed 1px silver; font-weight: bold; font-size: 17px;">
	  미리 보기
	</div>
  </div>
</div>

<div class="d-block d-lg-none mt-4">
	<figure><?php echo $cmp->campaign_main_img ?></figure>
</div>

<div class="">
  <div class="ctnt_wrap">
	<div class="ctnt_inside">

		<div class="my-4">
		<!-- 캠페인 상세 -->
			<div class="row">
				<div class="col-12 col-lg-8">
					<div class="cmp_image d-none d-lg-block pb-4">
						<figure><?php echo $cmp->campaign_main_img ?></figure>
					</div>
					<div class="col-12 d-block d-lg-none"><!-- 모바일 -->
						<div class="cmp_side_wrap pb-4 px-3">
							<div class="cmp_title"><?php echo $cmp->title ?></div>

							<!-- [2024-12-03] 진행율 -->
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
								<!-- <?php //echo $cmp->term_begin ?> ~  --><?php echo $cmp->term_end ?> 까지
							</div>

							<!-- [2024-12-03] 모금 목표 -->
							<div class="dsp_flex_sp_between pt-4">
								<div class="cmp_goal_ttl">모금 목표</div>
								<div class="cmp_goal_money">
									<span class="money_comma"><?php echo $cmp->goal_money_comma ?></span> <span class="money_unit">원</span>
								</div>
							</div>

							<hr class="my-2 mb-3" style="height: 2px; background-color: #000; opacity: .5;" />

							<div class="cmp_device_wrap">
								<div class="cmp_device_ttl">필요한 디지털 기기</div>
								<div class="cmp_device_list">
									<?php echo $cmp->goal_desc ?>
								</div>
							</div>
							<div class="cmp_btn">
								<button class="o_btn o_btn_block btn-success-flat" onclick="alert('미리보기 페이지입니다.');"><h3 style="line-height:50px; margin-bottom:0; font-weight: bold;">기부하기</h3></button>
							</div>

							<div class="dsp_flex_sp_between mt-2">
								<button class="o_btn o_btn_block btn-warning-flat" style="width: 48%;" onclick="alert('미리보기 페이지입니다.');">링크 복사</button>
								<button id="kakaotalk-sharing-btn" class="o_btn o_btn_block btn-warning-flat" style="width: 48%;" onclick="alert('미리보기 페이지입니다.');">카카오 공유</button>
							</div>
							<div id="link-to-copy" class="d-none"><?php echo current_url(); ?></div>



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
								<a href="<?php echo $cmp->cmp_website ?>"><button type="button" class="btn btn-light btn-block py-2">자세히 보기 > </button></a>
							</div>
							<?php } ?>

						</div>
					</div>
					<div class="cmp_content">
						<div class="tab">
						  <button class="tablinks active" onclick="openTab(event, 'tab_campaign')" id="campaignOpen">캠페인 소개</button>
						  <button class="tablinks" onclick="openTab(event, 'tab_comment')" id="commentOpen">응원 댓글</button>
						  <button class="tablinks" onclick="openTab(event, 'tab_cmpnews')" id="cmpnewsOpen">모금 소식</button>
						</div>
						<input type="hidden" id="cmptab" value="<?php //echo $cmptab ?>" />
						<input type="hidden" id="cmp_idx" value="<?php echo $cidx ?>" />
						<div id="tab_campaign" class="tabcontent wrap_figure" style="padding:25px;">

							<?php echo (isset($cmp->ctnt_ttl_1) && '' != $cmp->ctnt_ttl_1) ? '<h5>'.$cmp->ctnt_ttl_1.'</h5>' : '' ?>
							<?php echo (isset($cmp->ctnt_detail_1) && '' != $cmp->ctnt_detail_1) ? '<p>'.$cmp->ctnt_detail_1.'</p>' : '' ?>
							<?php echo (isset($cmp->ctnt_file_img[1]) && '' != $cmp->ctnt_file_img[1]) ? '<p class="pb-4">'.$cmp->ctnt_file_img[1].'</p>' : '' ?>

							<?php echo (isset($cmp->ctnt_ttl_2) && '' != $cmp->ctnt_ttl_2) ? '<h5>'.$cmp->ctnt_ttl_2.'</h5>' : '' ?>
							<?php echo (isset($cmp->ctnt_detail_2) && '' != $cmp->ctnt_detail_2) ? '<p>'.$cmp->ctnt_detail_2.'</p>' : '' ?>
							<?php echo (isset($cmp->ctnt_file_img[2]) && '' != $cmp->ctnt_file_img[2]) ? '<p class="pb-4">'.$cmp->ctnt_file_img[2].'</p>' : '' ?>

							<?php echo (isset($cmp->ctnt_ttl_3) && '' != $cmp->ctnt_ttl_3) ? '<h5>'.$cmp->ctnt_ttl_3.'</h5>' : '' ?>
							<?php echo (isset($cmp->ctnt_detail_3) && '' != $cmp->ctnt_detail_3) ? '<p>'.$cmp->ctnt_detail_3.'</p>' : '' ?>
							<?php echo (isset($cmp->ctnt_file_img[3]) && '' != $cmp->ctnt_file_img[3]) ? '<p class="pb-4">'.$cmp->ctnt_file_img[3].'</p>' : '' ?>


							<?php echo $cmp->content ?>
						</div>
					</div>
				</div>
				<div class="col-12 col-lg-4 d-none d-lg-block">
					<div class="cmp_side_wrap py-4 px-3">
						<div class="cmp_title"><?php echo $cmp->title ?></div>


						<!-- [2024-12-03] 진행율 -->
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
							<!-- <?php //echo $cmp->term_begin ?> ~  --><?php echo $cmp->term_end ?> 까지
						</div>

						<!-- [2024-12-03] 모금 목표 -->
						<div class="dsp_flex_sp_between pt-4">
							<div class="cmp_goal_ttl">모금 목표</div>
							<div class="cmp_goal_money">
								<span class="money_comma"><?php echo $cmp->goal_money_comma ?></span> <span class="money_unit">원</span>
							</div>
						</div>

						<hr class="my-2 mb-3" style="height: 2px; background-color: #000; opacity: .5;" />



						<div class="cmp_device_wrap ">
							<div class="cmp_device_ttl">목표 기부 수량</div>
							<div class="cmp_device_list">
								<?php echo $cmp->goal_desc ?>
							</div>
						</div>

						<div class="cmp_btn">
							<button class="o_btn o_btn_block btn-success-flat" onclick="alert('미리보기 페이지입니다.');"><h3 style="line-height:50px; margin-bottom:0; font-weight: bold;">기부하기</h3></button>
						</div>

						<div class="dsp_flex_sp_between mt-2">
							<button class="o_btn o_btn_block btn-warning-flat" style="width: 48%;" onclick="alert('미리보기 페이지입니다.');">링크 복사</button>
							<button id="kakaotalk-sharing-btn" class="o_btn o_btn_block btn-warning-flat" style="width: 48%;" onclick="alert('미리보기 페이지입니다.');">카카오 공유</button>
						</div>
						<div id="link-to-copy" class="d-none"><?php echo current_url(); ?></div>


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
							<a href="<?php echo $cmp->cmp_website ?>"><button type="button" class="btn btn-light btn-block py-2">자세히 보기 > </button></a>
						</div>
						<?php } ?>

					</div>
				</div>
			</div>
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

