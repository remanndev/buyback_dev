<!doctype html>
<html class="no-js" lang="en" dir="ltr">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<!-- <meta name="theme-color" content="#cba86a"> -->

	<!-- Favicon -->
	<link rel="shortcut icon" href="<?php echo BASEURL ?>/assets/images/favicon.ico" type="image/x-icon">
	<link rel="icon" href="<?php echo BASEURL ?>/assets/images/favicon.ico" type="image/x-icon">
	<!-- // Favicon -->

    <!-- Bootstrap CSS -->
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous"> -->
	<link rel="stylesheet" href="<?php echo LIB_DIR ?>/bootstrap/bootstrap-5.0.2-dist/css/bootstrap.min.css" />

	<link rel="stylesheet" href="<?php echo CSS_DIR ?>/common.css?v=<?php echo rand() ?>" />
	<link rel="stylesheet" href="<?php echo CSS_DIR ?>/layout.css?v=<?php echo rand() ?>" />

	<?php
	// CSS 파일을 로드 한다.
	if(isset($GLOBALS['hoksi_css']) && $GLOBALS['hoksi_css']) { foreach($GLOBALS['hoksi_css'] as $css_file) { echo $css_file . PHP_EOL;}}
	/* - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	 load_css('<link rel="stylesheet" type="text/css" media="screen" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/themes/blitzer/jquery-ui.css" />');
	 * - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	 */
	?>
    <title>SYMSCO<?php //echo $this->config->item('website_name', 'tank_auth') ?></title>
  </head>
  <body>
	<div class="layout_content">

		<!-- Desctop top -->
		<div class="header_top">
			<div class="contents_wrap">
				<div style="float:right;">
					<span>
						<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-telephone-fill" viewBox="0 0 16 18"><path fill-rule="evenodd" d="M1.885.511a1.745 1.745 0 0 1 2.61.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.678.678 0 0 0 .178.643l2.457 2.457a.678.678 0 0 0 .644.178l2.189-.547a1.745 1.745 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.634 18.634 0 0 1-7.01-4.42 18.634 18.634 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877L1.885.511z"/></svg>
						<a href="tel:+82514059800" style="padding-left:2px;">+82 51 405 9800</a>
					</span>
				</div>
			</div>
		</div>

		<!-- Desctop Nav -->
		<div class="header_nav">
			<div id="navbar_fixed" class="navbar_fixed">
			  <div class="contents_wrap">
				<div class="navlogo"></div>
				<div class="navbar">
					<ul class="row gx-4"><!-- gx-5 -->
						<li class="col-md-auto"><a href="#">HOME</a></li>
						<li class="col-md-auto"><a href="#">ABOUT</a></li>
						<li class="col-md-auto"><a href="#">PRODUCTS</a></li>
						<li class="col-md-auto"><a href="#">SERVICES</a></li>
						<li class="col-md-auto"><a href="#">CERT</a></li>
						<li class="col-md-auto"><a href="#">CONTACT</a></li>
					</ul>
					<div class="navbar_srh" style="">
						<form class="d-flex" action="<?php echo REQUEST_URI ?>" method="post">
						  <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" style="width:120px;">
						  <button class="btn btn-outline-success" type="submit">Search</button>
						</form>
					</div>
				</div>
			  </div>
			</div>
		</div>

		
		<!-- Mobile Nav -->
		<div class="header_nav_mobile">
			<div id="navbar_fixed_mobile" class="navbar_fixed">
			  <div class="contents_wrap">
				<div class="navlogo"></div>
				<div class="navbar">
					<!-- mobile nav icon : open -->
					<a href="/" onclick="return false;" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRightMobile" aria-controls="offcanvasRightMobile">
					  <div class="hamberger_btn">
						<div></div>
						<div></div>
						<div></div>
					  </div>
					</a>
					<!-- mobile nav icon : wrap -->
					<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRightMobile" aria-labelledby="offcanvasRightMobileLabel">
					  <div class="offcanvas-header">
						<h5 id="offcanvasRightMobileLabel"></h5>
						<!-- mobile nav icon : close -->
						<a href="#" onclick="return false;" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRightMobile" aria-controls="offcanvasRightMobile">
						  <div class="hamberger_btn_close">
							<div class="bar1"></div>
							<div class="bar2"></div>
							<div class="bar3"></div>
						  </div>
						</a>
					  </div>
					  <div class="offcanvas-body">
						
					  </div>
					</div>
				</div>
			  </div>
			</div>
		</div>





		<div class="contents_wrap">
			contents

			<br />
			<br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br />

		</div>
	</div>

	<footer class="layout_footer">
		<div class="contents_wrap">
			footer
		</div>
	</footer>




    <!-- jQuery and Bootstrap Bundle (includes Popper) -->
	<?php /* 
	<!-- <script src="<?php echo ASSETS_DIR ?>/lib/jquery/jquery-1.11.3.min.js"></script> -->
	<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> -->
	<!-- <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script> -->
	<?php */ ?>
	<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> -->
	
	<script src="<?php echo ASSETS_DIR ?>/lib/jquery/jquery-1.11.3.min.js"></script>
	<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/jquery-ui.min.js"></script>
	

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script> -->
	<?php /*><!-- <script src="<?php echo LIB_DIR ?>/bootstrap/bootstrap-5.0.2-dist/js/bootstrap.bundle.min.js"></script> --><?php */ ?>
	<script src="<?php echo LIB_DIR ?>/bootstrap/bootstrap-5.0.2-dist/js/bootstrap.bundle.min.js"></script>

	<!-- Scripts -->
	<script src="<?php echo JS_DIR ?>/common.js?v=<?php echo rand() ?>"></script>
	<script src="<?php echo JS_DIR ?>/layout.js?v=<?php echo rand() ?>"></script>

	<?php
	// 자바 스크립트 파일을 로드 한다.
	if(isset($GLOBALS['hoksi_js']) && $GLOBALS['hoksi_js']) { foreach($GLOBALS['hoksi_js'] as $js_file) { echo $js_file . PHP_EOL;}}
	/* - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	 load_js('<script src="/js/plugins/jqgrid/4.6.0/jquery.jqGrid.min.js" type="text/javascript"></script>');
	 * - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	 */
	?>

  </body>
</html>