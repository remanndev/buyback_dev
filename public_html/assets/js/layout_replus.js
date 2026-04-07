/** - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
| 메뉴 상단 고정
*/

	$(document).ready(function(){

		
		var pagetype = $('#pagetype').val();

		if( pagetype == 'main' ) 
		{

			var top_height = 0; //29; 
			$(window).trigger('scroll');
			$(window).on('scroll', function () {

				/* Desktop */
				/*
				if ($(window).scrollTop() > top_height) {
					$('.header_wrap').addClass('scrolled');
					$('.header_wrap .top_logo img').attr('src', '/assets/images/layout/logo_color.svg');
					$('.header_wrap .top_util .ic_join').attr('src', '/assets/images/layout/icon_join_gray.png');
					$('.header_wrap .top_util .ic_login').attr('src', '/assets/images/layout/icon_login_gray.png');
				} else {

					$('.header_wrap').removeClass('scrolled');
					$('.header_wrap .top_logo img').attr('src', '/assets/images/layout/logo_white.svg');
					$('.header_wrap .top_util .ic_join').attr('src', '/assets/images/layout/icon_join.png');
					$('.header_wrap .top_util .ic_login').attr('src', '/assets/images/layout/icon_login.png');
				}
				*/

				/* Desktop */
				if ($(window).scrollTop() > top_height) {
					$('.header_wrap').addClass('scrolled');
					$('.header_wrap .top_logo img').attr('src', '/assets/images/layout/logo_color_resize.png');
					$('.header_wrap .top_util .ic_join').attr('src', '/assets/images/layout/icon_join_gray.png');
					$('.header_wrap .top_util .ic_login').attr('src', '/assets/images/layout/icon_login_gray.png');
				} else {

					$('.header_wrap').removeClass('scrolled');
					$('.header_wrap .top_logo img').attr('src', '/assets/images/layout/logo_white_resize.png');
					$('.header_wrap .top_util .ic_join').attr('src', '/assets/images/layout/icon_join.png');
					$('.header_wrap .top_util .ic_login').attr('src', '/assets/images/layout/icon_login.png');
				}



			});

		}


	});
