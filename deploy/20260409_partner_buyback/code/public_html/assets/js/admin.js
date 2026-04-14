/* When the user scrolls down, hide the navbar. When the user scrolls up, show the navbar */
	/*
	var prevScrollpos = window.pageYOffset;
	window.onscroll = function() {
	  var currentScrollPos = window.pageYOffset;
	  //console.log( prevScrollpos +' > '+ currentScrollPos );
	  if (prevScrollpos > currentScrollPos  ||  prevScrollpos == 0) {
		document.getElementById("navbar").style.top = "0";
	  } else {
		document.getElementById("navbar").style.top = "-85px";
	  }
	  prevScrollpos = currentScrollPos;
	}
	*/


/* Nav active process */
	$(document).ready(function() {

		var path = window.location.pathname || "";
		var active_menu = "";
		var $menu_items = $("#navbar ul li");

		if (/^\/admin\/user(\/|$)/.test(path)) {
			active_menu = "member";
		} else if (/^\/admin\/partner(\/|$)/.test(path)) {
			active_menu = "partner";
		} else if (/^\/admin\/buyback\/spec_(lists|write|excel|excel_download|excel_template)(\/|$)/.test(path)) {
			active_menu = "buyback-spec";
		} else if (/^\/admin\/buyback(\/|$)/.test(path)) {
			active_menu = "buyback-request";
		} else if (/^\/admin\/env(\/|$)/.test(path)) {
			active_menu = "visit";
		}

		if (active_menu !== "" && $menu_items.filter("[data-menu]").length) {
			$menu_items.removeClass("active");
			$menu_items.find("button.btn-nav-flat").removeClass("active");

			var $active_item = $menu_items.filter('[data-menu="' + active_menu + '"]').first();
			$active_item.addClass("active");
			$active_item.find("button.btn-nav-flat").addClass("active");
		} else {
			$("#navbar ul li a[href]").each(function() {
				var url = window.location.href;
				var chk = url.indexOf(this.href);
				var $parent = $(this).parent();
				var $button = $(this).find("button.btn-nav-flat");

				$parent.removeClass("active");
				$button.removeClass("active");

				if(chk != -1) {
					$parent.addClass("active");
					$button.addClass("active");
				}
			});
		}


		// 
		if( $("#scroll-fix-header").offset() ) {

			var header_offset_top = $("#scroll-fix-header").offset().top;
			//console.log(header_offset_top);

			$(window).scroll(  function() {
				var header_offset_width = $("#scroll-fix-header").width();

				$(".scroll_fixed").css("position", "relative");
				$(".scroll_fixed").css("width", header_offset_width);

				if((window.pageYOffset + 12) >= header_offset_top) {
					$(".scroll_fixed").css("position", "fixed");
					$(".scroll_fixed").css("top", "50px");

				} else {
					$('#scroll-fix-header').css('height','0');
					$(".scroll_fixed").css("position", "relative");
					$(".scroll_fixed").css("padding-top", "0");
					$(".scroll_fixed").css("top", 0);
				}
			});

		}

		/*
		// snb
		if( $("#scroll-fix-snb").offset() ) {

			var snb_offset_top = $("#scroll-fix-snb").offset().top;

			$(window).scroll(  function() {
				var snb_offset_width = $("#scroll-fix-snb").width();

				$(".snb_scroll_fixed").css("position", "relative");
				$(".snb_scroll_fixed").css("width", snb_offset_width);

				if(window.pageYOffset >= snb_offset_top) {
					$(".snb_scroll_fixed").css("position", "fixed");
					$(".snb_scroll_fixed").css("top", "0");

				} else {
					$('#scroll-fix-snb').css('height','0');
					//$(".snb_scroll_fixed").css("margin-top", "20px");
					$(".snb_scroll_fixed").css("position", "relative");
					$(".snb_scroll_fixed").css("padding-top", "0");
					$(".snb_scroll_fixed").css("top", 0);
				}
			});

		}
		*/
	});


	// snb 메뉴 열고 닫기
	$(document).on("click", ".menu_toggle", function() {
		var info = $(this).attr('class').split(' ');
		var menu = info[0];

		//console.log(('dd.'+menu));

		if($(this).is(".menu_close")) {
			$(this).removeClass("menu_close");
			$(this).nextAll('dd.'+menu).slideDown();
			var gubun = '';
		} else {			
			$(this).addClass("menu_close");
			$(this).nextAll('dd.'+menu).slideUp();
			var gubun = 'close';
		}

		//$.post(tb_admin_url+"/ajax.menu.php",{ type: menu, gubun: gubun });
    });

/* Description */








/* - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
 * 팝업 스크립트
 * - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
 */
	function slt_check(f, act) {
		var str = '';
		if (act.indexOf('update') != -1)
			str = '수정'; 
		else if (act.indexOf('delete') != -1) 
			str = '삭제';
		else
			return;

		if ($("input[name='chk[]']:checked", f).length < 1) {
			alert(str + "할 자료를 하나 이상 선택하세요.");
			return;
		}

		if (str == '삭제' && !confirm('선택한 자료를 정말 삭제 하시겠습니까?'))
			return;

		f.action = act;
		f.submit();
	}



	$(document).ready(function(){

		$('#allcheck').click(function(){
			//만약 전체 선택 체크박스가 체크된상태일경우 
			if($(this).prop("checked")) { 
				//해당화면에 전체 checkbox들을 체크해준다 
				$("input[type=checkbox][class='chk_box']").prop("checked",true); 
				// 전체선택 체크박스가 해제된 경우 
			} else { 
				//해당화면에 모든 checkbox들의 체크를해제시킨다. 
				$("input[type=checkbox][class='chk_box']").prop("checked",false); 
			}
		});

	});
