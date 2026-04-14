<?php
// <!-- 공지사항 -->
if($this->uri->segment(1,'') != 'auth') {

	$footer_logo_src = (!empty($partner['logo_src'])) ? $partner['logo_src'] : $this->config->item('website_logo_src', 'tank_auth');
	$footer_logo_alt = !empty($partner['name']) ? $partner['name'] : $this->config->item('website_name', 'tank_auth');

	$latest_notice = array();
	$result_latest_notice = $this->basic_model->latest_bbs('notice',5,200,array('opt_notice'=>1));
	$cnt_notice = 0;
	foreach($result_latest_notice as $i => $row) {
		$latest_notice[$i] = new stdClass();
		$latest_notice[$i]->subject = $row->subject;
		$latest_notice[$i]->href = $row->href;
		$cnt_notice++;
	}
	// [2025-09-23] 공지 체크한 게 하나 뿐이면 카피해서 같은 거 두 개가 반복
	if($cnt_notice == 1){
		$latest_notice[1] = $latest_notice[0];
	}
/*
	// <!-- 푸터 컨텐츠 -->
		$arr_footer = array('sql_select' => '*','sql_from' => 'mng_contents','sql_where' => array('idx' => 9, 'del_datetime' => NULL));
		$row_footer = $this->basic_model->arr_get_row($arr_footer);
*/

// [2024-10-15] 
/*
$footer_logo_img = 'replus_logo_black_202410.png';
$footer_logo_src = IMG_DIR.'/layout/replus_logo_black_202410.png';
*/
?>


<!-- [PC] -->
<style>
  .notice_ul {height: 33px;/*line-height: 33px;*/overflow: hidden;margin: 0;padding: 0;list-style: none;}
  .notice_ul li {height: 33px;padding: 0px;margin: 0px;}
</style>
<div class="pc_wrap d-none d-lg-block">
	<div class="footer_notice_wrap">
	  <div class="main_sect">
		<div class="main_ctnt">
			<div class="notice_ttl" style="display: inline-block; border-bottom: 3px solid green; ">공지사항</div>
			<div class="notice_ctnt" style="width: 80%;">
			 <ul id="footer_notice" class="notice_ul">
			  <?php foreach($latest_notice as $i => $notice) { ?>
				<li class=""><a href="<?php echo $notice->href ?>"><?php echo $notice->subject ?></a></li>
			  <?php } ?>
			 </ul>
			</div>
		</div>
	  </div>
	</div>
</div>
<script>
 function notice_scroll(){
  $('#footer_notice li:first').slideUp( function () { $(this).appendTo($('#footer_notice')).slideDown(); });
 }
 setInterval(function(){ notice_scroll() }, 3000);
</script>


<!-- [MOBILE] -->
<div class="mobile_wrap d-block d-lg-none">
	<div class="footer_notice_wrap">
	  <div class="main_sect">
		<div class="main_ctnt">
			<div class="notice_ttl">공지사항</div>
			<div class="notice_ctnt">

			 <ul id="footer_notice_mobile" class="notice_ul">
			  <?php foreach($latest_notice as $i => $notice) { ?>
				<li class="ellipsis"><a href="<?php echo $notice->href ?>"><?php echo $notice->subject ?></a></li>
			  <?php } ?>
			 </ul>

			</div>
		</div>
	  </div>
	</div>
</div>
<?php 
}
?>
<script>
 function notice_scroll_mobile(){
  $('#footer_notice_mobile li:first').slideUp( function () { $(this).appendTo($('#footer_notice_mobile')).slideDown(); });
 }
 setInterval(function(){ notice_scroll_mobile() }, 3000);
</script>




<style>



</style>

<?php
// 메인페이지에만 노출 띠배너
if($this->uri->segment(1,'') == '') {
?>
<div class="pc_wrap d-none d-lg-block">
	<div class="main_bottom_bnr">
		<div class="btmbnr_ttl">나눔신청</div>
		<div class="btmbnr_desc">나눔 캠페인을 개설한 NPO의 신청조건에 따라 리퍼비시 제품을 보급하는 캠페인입니다.</div>
		<a href="<?php echo base_url() ?>B/SHARECAMPAIGN/나눔신청" class="btmbnr_link">자세히 보기 </a>
	</div>
</div>

<div class="mobile_wrap d-block d-lg-none">
	<div class="main_bottom_bnr">
		<div class="bottom_img_left"></div>
		<div class="bottom_img_right"></div>
		<div class="btmbnr_ttl">나눔신청</div>
		<div class="btmbnr_desc">나눔 캠페인을 개설한 NPO의 신청조건에 따라<br />리퍼비시 제품을 보급하는 캠페인입니다.</div>
		<a href="<?php echo base_url() ?>B/SHARECAMPAIGN/나눔신청" class="btmbnr_link">자세히 보기 </a>
	</div>
</div>
<?php
}
?>



<?php
// <!-- 푸터 컨텐츠 -->
	$arr_footer = array('sql_select' => '*','sql_from' => 'mng_contents','sql_where' => array('idx' => 9, 'del_datetime' => NULL));
	$row_footer = $this->basic_model->arr_get_row($arr_footer);
?>
<?php
$footer_logo_src = (!empty($partner['logo_src'])) ? $partner['logo_src'] : $this->config->item('website_logo_src', 'tank_auth');
$footer_logo_alt = !empty($partner['name']) ? $partner['name'] : $this->config->item('website_name', 'tank_auth');
?>
<!-- 푸터 -->
<style>
  ul.footer_sns {position:absolute; bottom:-5px; right:0; margin:0;padding:0;list-style: none; text-align: right; width: 100%;}
  ul.footer_sns li {margin-left:5px; display:inline-block; }

  ul.footer_sns2 {position:absolute; top: 5px; left:0; margin:0;padding:0;list-style: none; text-align: left; width: 100%;}
  ul.footer_sns2 li {margin-right:5px; display:inline-block; }

  .pc_wrap .footer_editor .req_btns {position:absolute; top: 0px; right: 0; z-index:10;}
</style>

<!-- 
[2023-05-11] pc/mobile
	리플러스에서 블로그를 운영하여, 메인페이지 하단에 블로그 링크 수정 요청합니다. 
	https://blog.naver.com/replus_digitalgive
	==> 방이사님 의견 : 폼과 글이 갖춰지면 수정
-->

<div class="pc_wrap d-none d-lg-block">
	<div class="footer_wrap">
	  <div class="main_sect">
		<div class="main_ctnt">
			<div class="footer_logo">
				<img src="<?php echo html_escape($footer_logo_src); ?>" alt="<?php echo html_escape($footer_logo_alt); ?>" style="max-width:260px; width:100%; height:auto;" />
				<ul class="footer_sns" style="">
				  <li style="position: absolute; bottom: 0; right: 235px;">
					<a href="https://www.nia.or.kr/site/nia_kor/main.do" target="_blank"><img src="<?php echo IMG_DIR ?>/common/footer_cert_img_NIA2.png" style="height: 84px;" /></a>
				  </li>
				  <li style="position: absolute; bottom: 0; right: 160px;">
					<a href="https://www.i-award.or.kr/" target="_blank"><img src="<?php echo IMG_DIR ?>/common/footer_img_webaward25.png" style="height: 84px;" /></a>
				  </li>
				  <li><a href="https://blog.naver.com/replus_digitalgive" target="_blank"><img src="<?php echo IMG_DIR ?>/common/sns_g_nblog.png" style="width:40px;" /></a></li>
				  <li><a href="https://www.instagram.com/replus_give " target="_blank"><img src="<?php echo IMG_DIR ?>/common/sns_g_insta.png" style="width:40px;" /></a></li>
				  <!-- <li><a href="https://www.facebook.com/DigitalGive" target="_blank"><img src="<?php echo IMG_DIR ?>/common/sns_g_fb.png" style="width:40px;" /></a></li> -->
				  <li><a href="https://www.youtube.com/c/npoitcenter" target="_blank"><img src="<?php echo IMG_DIR ?>/common/sns_g_utube.png" style="width:40px;" /></a></li>
				</ul>
			</div>
			<hr style="margin-bottom:0;" />
			<div class="footer_editor">
				<div class="req_btns dsp_flex_column dsp_flex_x_end">
					<div class="dsp_flex_x_end">
						<!-- <a href="/landing/NIA"><button type="button" class="btn btn-secondary btn-xs" style="margin-right: 3px;">NIA 지원사업신청</button></a> -->
						<a href="/landing_npo/form"><button type="button" class="btn btn-secondary btn-xs" style="margin-right: 3px;">NPO 협약신청</button></a>
						<a href="/landing/comp"><button type="button" class="btn btn-secondary btn-xs">기업 제휴 문의</button></a>
					</div>

					<!-- <div style="position: relative; height: 55px; margin-top: 5px;">
					  <div class="dsp_flex_x_end">
						<div id="wrap_translate_pc" class="wrap_translate" style="display: none;">
						<?php //$this->load->view('translation_view'); // 번역 버튼 ?>
						</div>
						<div class="quick_translate" style="display: ; margin-left: 10px;">
							<button class="btn btn-secondary btn-sm" onclick="show_translate('pc');">Translation</button>
						</div>
					  </div>
					</div> -->

				</div>
				<?php echo nl2br($row_footer->page_content); ?>
			</div>
		</div>
	  </div>
	</div>
</div>


<div class="mobile_wrap d-block d-lg-none">
	<div class="footer_wrap">
		<div class="main_sect">
			<div class="footer_logo">
				<img class="flogo" src="<?php echo html_escape($footer_logo_src); ?>" alt="<?php echo html_escape($footer_logo_alt); ?>" style="max-width:220px; width:100%; height:auto;" />
			</div>
			<hr style="margin-bottom: 5px;" />

			<div style="width: 100%; height: 40px;">
				<ul class="footer_sns2">
				  <li>
					<a href="https://www.nia.or.kr/site/nia_kor/main.do" target="_blank"><img src="<?php echo IMG_DIR ?>/common/footer_cert_img_NIA2.png" style="height: 40px; " /></a>
				  </li>
				  <li style="margin-right: 10px;"><a href="https://www.i-award.or.kr/" target="_blank"><img src="<?php echo IMG_DIR ?>/common/footer_img_webaward25.png" style="height: 40px;" /></a></li>
				  <li><a href="https://blog.naver.com/replus_digitalgive" target="_blank"><img src="<?php echo IMG_DIR ?>/common/sns_g_nblog.png" style="width:32px;" /></a></li>
				  <li><a href="https://www.instagram.com/replus_give " target="_blank"><img src="<?php echo IMG_DIR ?>/common/sns_g_insta.png" style="width:32px;" /></a></li>
				  <li><a href="https://www.youtube.com/c/npoitcenter" target="_blank"><img src="<?php echo IMG_DIR ?>/common/sns_g_utube.png" style="width:32px;" /></a></li>
				</ul>
			</div>

			<hr style="border: none; border-bottom: 1px dashed #ccc; margin-bottom: 0;" />


			<div class="footer_editor">
				<?php echo nl2br($row_footer->page_content); ?>
			</div>

			<!-- <div style="position: relative; height: 55px; margin-top: 5px;">
			  <div class="dsp_flex_x_start">
				<div class="quick_translate" style="display: ; margin-right: 10px;">
					<button class="btn btn-secondary btn-sm" onclick="show_translate('mob');">Translation</button>
				</div>
				<div id="wrap_translate_mob" class="wrap_translate" style="display: none;">
				<?php //$this->load->view('translation_view'); // 번역 버튼 ?>
				</div>
			  </div>
			</div> -->

		</div>
	</div>
</div>






<style>
#quick_outer { 
    position: relative;
    /* overflow: hidden; */
	width: auto;
    /* width: 135px; */
    height: 425px; 
}
#quick_outer #quick_wrap {
    position: absolute;
	right: 0;
    width: 100px;
    height: 425px;
    transition: .7s;
}
#quick_outer.quick_hide #quick_wrap {
    transition: .7s;
	right: -115px;
}
</style>

<style>
	#quick_wrap { display:flex; flex-direction: column; width: 98px; }
	#quick_wrap .quick_bg { width:100%; background-size:100% 100%; background-repeat:no-repeat;}
	#quick_wrap .quick_top { height: 7.2px; background-image:url('/assets/images/quick1/main_quick_top.png'); }

	#quick_wrap .quick_btn_NIA { height: 85.3px; background-image:url('/assets/images/quick1/main_quick_btn_NIA.png?v=1'); }
	#quick_wrap .quick_btn_NIA_hover { height: 85.3px; background-image:url('/assets/images/quick1/main_quick_btn_NIA_hover.png?v=1'); }

	#quick_wrap .quick_btn_kakao { height: 85.3px; background-image:url('/assets/images/quick1/main_quick_btn_kakao.png'); }
	#quick_wrap .quick_btn_npo { height: 85.3px; background-image:url('/assets/images/quick1/main_quick_btn_npo.png'); }
	#quick_wrap .quick_btn_comp { height: 85.3px; background-image:url('/assets/images/quick1/main_quick_btn_comp_241127.png'); }
	#quick_wrap .quick_btn_top { height: 52px; background-image:url('/assets/images/quick1/main_quick_btn_top.png'); }

	#quick_wrap .quick_top_hover { height: 7.2px; background-image:url('/assets/images/quick1/main_quick_top_hover.png'); }
	#quick_wrap .quick_btn_kakao_hover { height: 85.3px; background-image:url('/assets/images/quick1/main_quick_btn_kakao_hover.png'); }
	#quick_wrap .quick_btn_npo_hover { height: 85.3px; background-image:url('/assets/images/quick1/main_quick_btn_npo_hover.png'); }
	#quick_wrap .quick_btn_comp_hover { height: 85.3px; background-image:url('/assets/images/quick1/main_quick_btn_comp_hover_241127.png'); }
	#quick_wrap .quick_btn_top_hover { height: 52px; background-image:url('/assets/images/quick1/main_quick_btn_top_hover.png'); }


	/* [2024-11-27] 마우스 오버 효과 없이 컬러만 */
	#quick_wrap .quick_top { height: 7.2px; background-image:url('/assets/images/quick1/main_quick_top_hover.png'); }
	#quick_wrap .quick_btn_kakao { height: 85.3px; background-image:url('/assets/images/quick1/main_quick_btn_kakao_hover.png'); }
	#quick_wrap .quick_btn_npo { height: 85.3px; background-image:url('/assets/images/quick1/main_quick_btn_npo_hover.png'); }
	#quick_wrap .quick_btn_comp { height: 85.3px; background-image:url('/assets/images/quick1/main_quick_btn_comp_hover_241127.png'); }
	#quick_wrap .quick_btn_top { height: 52px; background-image:url('/assets/images/quick1/main_quick_btn_top_hover.png'); }

</style>

<script src="https://t1.kakaocdn.net/kakao_js_sdk/2.1.0/kakao.min.js"
  integrity="sha384-dpu02ieKC6NUeKFoGMOKz6102CLEWi9+5RQjWSV0ikYSFFd8M3Wp2reIcquJOemx" crossorigin="anonymous"></script>
<script>
  Kakao.init('a217aa850a224a735be93a6fbe593173'); // 사용하려는 앱의 JavaScript 키 입력
</script>
<script>
  // [2023-05-11] https://pf.kakao.com/_xgesfxj
  function chatChannel() {
    Kakao.Channel.chat({
      //channelPublicId: '_EgKixj',
      channelPublicId: '_xgesfxj',
    });
  }
  function closeChannel() {
	$('.fixed_quick_wrap').hide();
  }
</script>


<div class="fixed_quick_wrap" style="<?php echo (isset($arr_seg[1])) ? 'position: fixed; bottom: 0px;' : 'position:fixed; bottom:15px; '; ?> right: 15px; z-index: 1000;">
  <!-- desktop -->
  <div id="quick_outer" class="d-none d-lg-block">
	
	<div id="quick_wrap">
		<img id="btn_quick_close" src="<?php echo IMG_DIR ?>/quick1/quick_close_btn.png" style="position: absolute; top:20px; left: -26px; width: 26px; padding: 0; display: ;" />
		<img id="btn_quick_open" src="<?php echo IMG_DIR ?>/quick1/quick_open_btn.png" style="position: absolute; top:20px; left: -26px; width: 26px; padding: 0; display: none;" />

		<div id="quick_top" class="quick_bg quick_top"></div>
		<!-- <a href="https://replus.kr/landing/NIA"><div id="quick_btn_NIA" class="quick_bg quick_btn_NIA"></div></a> -->
		<a id="chat-channel-button-pc" href="javascript:chatChannel()"><div id="quick_btn_kakao" class="quick_bg quick_btn_kakao"></div></a>
		<a href="https://replus.kr/landing_npo/form"><div id="quick_btn_npo" class="quick_bg quick_btn_npo"></div></a>
		<a href="https://replus.kr/landing/comp"><div id="quick_btn_comp" class="quick_bg quick_btn_comp"></div></a>
		<a href="#"><div id="quick_btn_top" class="quick_bg quick_btn_top"></div></a>
	</div>
  </div>

  <!-- mobile -->
  <a id="chat-channel-button" class="d-block d-lg-none" href="javascript:chatChannel()">
	<img src="<?php echo IMG_DIR ?>/layout/consult_small_yellow_pc.png"
		alt="카카오톡 채널 채팅하기 버튼" />
  </a>
</div>

<script>
/*
$('#quick_top').on('click', function(){
	$('#quick_top').parents().addClass('quick_hide');
	$('#btn_quick_open').fadeIn('slow');
});
*/
$('#btn_quick_close').on('click', function(){
	$('#quick_top').parents().addClass('quick_hide');
	$('#btn_quick_open').fadeIn('slow');
});
$('#btn_quick_open').on('click', function() {
	$('#quick_top').parents().removeClass('quick_hide');
	$('#btn_quick_open').fadeOut('slow');
});
</script>
