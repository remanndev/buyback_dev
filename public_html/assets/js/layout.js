
/** - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
| 메뉴 상단 고정
*/

	$(document).ready(function(){

		/* Desktop */
		var top_height = 0; //29; 
		var scorll_top = $(window).scrollTop();
		if (scorll_top > top_height) {
			$('#navbar_fixed').removeClass('fixed-top').addClass('fixed-top');
			$('#navbar_fixed').addClass('navbar_scrolled');
		} 

		/* Mobile */
		// $('#navbar_fixed_mobile').removeClass('fixed-top').addClass('fixed-top');


		/*--/ Navbar Menu Reduce /--*/
		$(window).trigger('scroll');
		$(window).on('scroll', function () {

			/* Desktop */
			if ($(window).scrollTop() > top_height) {
				$('#navbar_fixed').addClass('fixed-top');
				$('#navbar_fixed').addClass('navbar_scrolled');
			} else {
				$('#navbar_fixed').removeClass('fixed-top');
				$('#navbar_fixed').removeClass('navbar_scrolled');
			}

			/* Mobile */
			/*
			if ($(window).scrollTop() > 0) {
				$('#navbar_fixed_mobile').addClass('fixed-top');
			} else {
				$('#navbar_fixed_mobile').removeClass('fixed-top');
			}
			*/
		});

	});


/** - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
| 메인 페이지 숫자 카운트 
*/

	$(document).ready(function(){

	  $('.device_amt').each(function() { 

		// 카운트를 적용시킬 요소
		let $counter = $(this);
		// 목표 수치
		let max = $counter.data('amt');
		// 목표 id 값
		let cnter_id = $counter.attr('id');
		//console.log(cnter_id+' / '+max);

		setTimeout(() => counter($counter, max), 100);

		const counter = ($counter, max) => {
		  let now = max;

		  const handle = setInterval(() => {

			let count = new Intl.NumberFormat().format(Math.ceil(max - now));
			$('#'+cnter_id).html(count);
		  
			// 목표수치에 도달하면 정지
			if (now < 0) {
			  clearInterval(handle);
			}
			
			// 증가되는 값이 계속하여 작아짐
			const step = now / 6;
			
			// 값을 적용시키면서 다음 차례에 영향을 끼침
			now -= step;
		  }, 60);
		}
	  });
	});




	// 모바일 메뉴 열고 닫기 - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	$(document).on("click", ".menu_toggle", function() {
		$this = $(this);
		var info = $this.attr('class').split(' ');
		var menu = info[0];

		// 다른 메뉴들 일괄 닫기
		$('.menu_toggle').each(function(){
			var info_other = $(this).attr('class').split(' ');
			var menu_other = info_other[0];
			if(menu != menu_other) {
				$(this).addClass("menu_close").removeClass('active');
				$(this).nextAll('dd.'+menu_other).slideUp();
			}
		});

		// 클릭 메뉴 처리
		if($this.is(".menu_close")) {
			$this.removeClass("menu_close").addClass('active');
			$this.nextAll('dd.'+menu).slideDown();
		} else {			
			$this.addClass("menu_close").removeClass('active');
			$this.nextAll('dd.'+menu).slideUp();
		}
	});




	$(document).ready(function(){
		// 서브메뉴 보여주기
		$(".desknav_main").mouseenter(function(){
			$('.o_subnav').hide();

			$this = $(this);
			var page_code = $this.data('pagecode');
			if($('#sub_'+page_code+' .desk_navbar_sub_main ul li').length) {
				$('#sub_'+page_code).show();
			}

			var $evt=$('.navbar_sub');
			if(!$evt.is(':animated')) {
				$evt.slideDown();
			}

		});

		// 서브메뉴 감추기
		$(".navbar_fixed").mouseleave(function(){
			var $evt=$('.navbar_sub');
			if(!$evt.is(':animated')) {
				$evt.slideUp();
			}
		});

		// 검색창 닫기
		$('.close_top_search').click(function(){
			$('#top_search').hide();
		});
	});










