<!doctype html>
<html class="no-js" lang="ko" dir="ltr">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<style>
	  body {margin:0;padding:0;}
	</style>
  </head>
  <body>
<?php
	if ( isset($viewPage) && $viewPage ) $this->load->view($viewPage); // 페이지 내용
?>
  </body>
</html>