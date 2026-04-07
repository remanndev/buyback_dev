<?php
$footer_wrap_pt = '';
if($this->uri->segment(1,'') == 'auth') {
	$footer_wrap_pt = '';
}
else {
	$footer_wrap_pt = '';

	$latest_notice = array();
	$result_latest_notice = $this->basic_model->latest_bbs('notice',1);
	foreach($result_latest_notice as $i => $row) {
		$latest_notice[$i] = new stdClass();
		$latest_notice[$i]->subject = $row->subject;
		$latest_notice[$i]->href = $row->href;
	}
?>
	<div class="footer_notice_wrap dsp_pc">
		<div class="main_ctnt_wrap">
			<div class="footer_notice_title">공지사항</div>
			<div class="footer_notice_ctnt" style="width: 80%;">
			  <?php foreach($latest_notice as $i => $notice) { ?>
				<div class="ellipsis"><a href="<?php echo $notice->href ?>"><?php echo $notice->subject ?></a></div>
			  <?php } ?>
			</div>
		</div>
	</div>
<?php 
}
?>

	<!-- 푸터 -->
	<div class="footer_wrap dsp_pc">
		<div class="main_ctnt_wrap">
			<div class="footer_logo"><img src="<?php echo IMG_DIR ?>/layout/logo_footer.png" style="width:191px;" /></div>
			<div class="footer_link">
				<ul>
					<li><a href="/page/term_use">이용약관</a></li>
					<li class="h_line"></li>
					<li><a href="/page/term_privacy">개인정보처리방침</a></li>
				</ul>
			</div>

			<div class="footer_info pb-4">
				<div class="finfo_center">
					사단법인 비영리IT지원센터 (리플러스 추진단)<br />
					사업자 등록번호 : 110-82-17575<span class="h_line"></span>Email npoit@npoit.kr
				</div>
				<div class="finfo_addr mt-3">서울특별시 은평구 통일로 684, 서울혁신파크 9동 3층 312호</div>
				<div class="finfo_copyright my-5">Copyright © Replus All Rights Reserved.</div>
			</div>
		</div>
	</div>
