<style type="text/css">
#campaign figure { margin:0; }
#campaign figure img { width: 100%; height: auto; display: block; }
</style>

<style>
	.cmp_org { font-size: 19px; color: #9b9b9b; font-weight: bold; }
	.cmp_title { font-size: 24px; font-weight: 600;}
	.cmp_cate {}
	.cmp_term { font-size:18px; color: #9b9b9b; letter-spacing:-0.7px; font-weight: 600;}
	.cmp_target_wrap {margin-top:40px; }
	.cmp_target_ttl, .cmp_device_ttl { font-size: 20px; font-weight: bold;}
	.cmp_target_money { font-size:25px; font-weight: bold; color: #808080; letter-spacing:-0.7px; text-align: right; }
	.cmp_target_money > span { font-size:18px;}
	.cmp_device_list ul { margin: 0px 5px 0px 30px; }
	.cmp_device_list ul li { clear:both; padding:5px 15px 0px 0px; font-size: 18px; list-style-type: disc; }
	.cmp_device_list ul li > span { float: right;}


	/*
	 * 캠페인용 단체 정보 */
	.cmp_org_wrap {margin-top:20px; }
	dl.cmp_org_info { padding:20px; background-color:#fbfbfd; border:1px dashed #ffffff;}
	dl.cmp_org_info dt { font-size: 18px; font-weight:bold; width:100%; border-bottom:1px solid silver; padding-bottom: 10px; }
	dl.cmp_org_info dd { padding-top:10px; font-size: 15px; }

	.cmp_ctnt .tab button { width:33.333%; }

	/* [2024-12-03] 진행율 */
	.per_number { font-size: 52px; font-weight: bold; color: #009f00; }
	.per_unit { font-size: 24px; color: #009f00; }

	.cmp_goal_ttl,
	.cmp_goal_money { font-size: 22px; font-weight: bold; }
	.cmp_goal_money .money_comma { font-family: tahoma !important; color: #009f00; }
	.cmp_goal_money .money_unit {}


</style>


<h1 style="position:relative;">
	캠페인 관리
	<span style="position:absolute; right:0; bottom:5px;">
		<?php if('write' == $row->state) { ?>
			<button type="button" class="btn  btn-silver" style="margin:0 auto; color:#000000;" disabled>작성중 캠페인</button>
		<?php } elseif('submit' == $row->state) { ?>
			<button type="button" class="btn  btn-success-flat" style="margin:0 auto; color:#ffffff;" disabled>제출된 캠페인</button>
		<?php } elseif('launch' == $row->state) { ?>
			<button type="button" class="btn  btn-primary-flat" style="margin:0 auto; color:#ffffff;" disabled>런칭된 캠페인</button>
		<?php } ?>
	</span>
</h1>

	<div class="adm_campaign_wrap">
		<!-- 캠페인 상세 -->
		<div class="adm_container">

			<div class="row">

				<!-- 캠페인 좌측 컨텐츠 -->
				<!-- <div class="cmp_ctnt col-12 col-lg-8"> -->
				<div class="cmp_ctnt col-8">


					<figure style="min-height:200px; background-color:#efefef;">
						<?php echo $cmp->campaign_main_img ?>
					</figure>



					<!-- <div class="tab">
					  <button class="tablinks active" onclick="openTab(event, 'campaign')" id="defaultOpen">캠페인 소개</button>
					  <button class="tablinks">응원댓글</button>
					</div> -->

					<div class="tab">
					  <button class="tablinks active" onclick="openTab(event, 'campaign')" id="defaultOpen">캠페인 소개</button>
					  <button class="tablinks">응원 댓글</button>
					  <button class="tablinks">모금 소식</button>
					</div>


					<div id="campaign" class="tabcontent" style="min-height:400px;">

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

					<div id="comment" class="tabcontent"></div>


					<script>
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
					}

					// Get the element with id="defaultOpen" and click on it
					document.getElementById("defaultOpen").click();
					</script>
	   
				</div>

				<!-- 캠페인 우측 컨텐츠 -->
				<!-- <div class="cmp_ctnt_side d-none d-lg-block col-lg-4"> -->
				<div class="cmp_ctnt_side col-4">

					<!-- <div class="cmp_org">[<?php echo $cmp->org_name ?>]</div> -->
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

					<div class="cmp_device_wrap pt-4 mb-4 pb-3">
						<div class="cmp_device_ttl">필요한 디지털 기기</div>
						<div class="cmp_device_list">
							<?php echo $cmp->goal_desc ?>
						</div>
					</div>


					<div class="cmp_btn">
						<button class="o_btn o_btn_block btn-success-flat o_btn_v60" onclick="alert('준비중입니다..');"><h3 style="margin:0; font-size:18.72px;">기부하기</h3></button>
					</div>

					<div class="dsp_flex_sp_between mt-2">
						<button class="o_btn o_btn_block btn-warning-flat" style="width: 48%;" onclick="copyToClipboard('link-to-copy');">링크 복사</button>
						<button id="kakaotalk-sharing-btn" class="o_btn o_btn_block btn-warning-flat" style="width: 48%;">카카오 공유</button>
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
					<div class="mt-2">
						<a href="<?php echo $cmp->cmp_website ?>"><button type="button" class="btn btn-light btn-block py-2">자세히 보기 > </button></a>
					</div>
					<?php } ?>


				</div>

			</div>

			<hr class="" style="margin:30px 0; border-bottom:none;" />
		</div>
	</div>











<div style="text-align:center;">
	<?php if('write' == $row->state) { ?>
		<a href="#" onclick="submit_confirm('/admin/campaign/submit/<?php echo $row->idx ?>'); return false;"><button type="button" class="btn  btn-success-flat o_btn_v50_px20" style="margin:0 auto;">제출하기</button></a>
	<?php } elseif('submit' == $row->state) { ?>
		<a href="#" onclick="reset_write_confirm('/admin/campaign/reset_write/<?php echo $row->idx ?>'); return false;"><button type="button" class="btn  btn-black-flat o_btn_v50_px20" style="margin:0 auto; ">제출 취소</button></a>
		<a href="#" onclick="launch_confirm('/admin/campaign/launch/<?php echo $row->idx ?>'); return false;"><button type="button" class="btn  btn-success-flat o_btn_v50_px20" style="margin:0 auto;">런칭하기</button></a>
	<?php } elseif('launch' == $row->state) { ?>
		<a href="#" onclick="reset_submit_confirm('/admin/campaign/reset_submit/<?php echo $row->idx ?>'); return false;"><button type="button" class="btn  btn-black-flat o_btn_v50_px20" style="margin:0 auto; ">런칭 취소</button></a>
		<button type="button" class="btn  btn-primary-flat o_btn_v50_px20" style="margin:0 auto; ">런칭 완료</button>
	<?php } ?>

	<a href="/admin/campaign/edit/<?php echo $row->idx ?>"><button type="button" class="btn  btn-black-flat o_btn_v50_px20" style="margin:0 auto;">수정하기</button></a>

</div>
<script type="text/javascript">

		// 런칭 취소 후 제출 상태로 변경
		function submit_confirm(url) {
			if( confirm( '정말 제출 상태로 변경하시겠습니까?') ) {
				location.href = url;
			}
		}

		// 런칭하기
		function launch_confirm(url) {
			if( confirm( '정말 공개하시겠습니까? \n공개하신 캠페인은 즉시 캠페인 페이지에 반영됩니다.') ) {
				location.href = url;
			}
		}

		// 런칭 취소 후 제출 상태로 변경
		function reset_submit_confirm(url) {
			if( confirm( '정말 제출 상태로 변경하시겠습니까? \n공개하신 캠페인은 즉시 캠페인 페이지에서 제외됩니다.') ) {
				location.href = url;
			}
		}

		// 제출 취소 후 작성 상태로 변경
		function reset_write_confirm(url) {
			if( confirm( '정말 작성 상태로 변경하시겠습니까? \n해당 캠페인은 수정 가능한 상태로 변경됩니다.') ) {
				location.href = url;
			}
		}

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
  var page_title = '캠페인';

  // 페이지 설명
  var page_description = '설명';

  // 페이지 대표 이미지
  var page_image = '';

  Kakao.Share.createDefaultButton({
    container: '#kakaotalk-sharing-btn',
    objectType: 'feed',
    content: {
      title: page_title,
      description: page_description,
      imageUrl: page_image,
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