<style type="text/css">
.container {}
.container img { max-width: 100%; }
</style>

<div class="ctnt_wrap py_35">
	<div class="ctnt_inside">
		<div class="contents_wrap">
			<!-- 페이지 내용 -->
			<div class="container">
				<section class="o_ctnt">
					<h4 class="o_content_ttl" style="position: relative; font-size: 34px; font-weight: bold;"><?php echo $row->page_title; ?></h4>
					<hr style="border:none; border-bottom:1px solid #ccc; margin-bottom: 25px;">
					<?php echo $row->page_content; ?>
				</section>
			</div>
		</div>
	</div>
</div>