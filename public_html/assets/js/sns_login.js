$(document).ready(function() {


	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - 
	// 카카오 로그인
	function kakaoLogin(rpath_encode) {
		// 팝업창 방식
		//window.open('/sns/kakaoAuth/'+rpath_encode, 'kakaoAuth', 'width=600, height=550, menubar=no, scrollbars=no, statusbar=no, resizable=no');

		//alert('[2]'+rpath_encode);

		// 페이지 변경 방식
		location.href = '/sns/kakaoAuth/'+rpath_encode;
	}

	/*
	$('.kakaoLoginBtn').css('cursor', 'pointer');
	$('.kakaoLoginBtn').on('click', function() {
		//var rpath_encode = $(this).attr('alt');
		var rpath_encode = $(this).data('rpath');
		//alert('[1]'+rpath_encode);
		kakaoLogin(rpath_encode);
	});
	*/


	
	$('#kakaoLoginBtnStart').css('cursor', 'pointer');

	//$('#kakaoLoginBtnStart').on('click', function() {
	$(document).on('click', '#kakaoLoginBtnStart', function() {
		//var rpath_encode = $(this).attr('alt');
		var rpath_encode = $(this).data('rpath');
		//alert('[1]'+rpath_encode);
		kakaoLogin(rpath_encode);
	});






	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - 
	// 네이버 로그인
	function naverLogin(rpath_encode) {
		// 팝업창 방식
		//window.open('/sns/naver_login', 'naverAuth', 'width=600, height=550, menubar=no, scrollbars=no, statusbar=no, resizable=no');
		//window.open('/sns/naverAuth/'+rpath_encode, 'naverAuth', 'width=600, height=550, menubar=no, scrollbars=no, statusbar=no, resizable=no');

		// 페이지 변경 방식
		location.href = '/sns/naverAuth/'+rpath_encode;
	}

	$('.naverLoginBtn').css('cursor', 'pointer');
	$('.naverLoginBtn').on('click', function() {
		var rpath_encode = $(this).attr('alt');
		naverLogin(rpath_encode);
	})




	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - 
	// 페이스북 로그인




});