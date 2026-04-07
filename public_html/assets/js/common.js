/*
$( document ).ready(function() {
  var hamburger = $('#hamburger-icon');
  hamburger.click(function() {
     hamburger.toggleClass('active');
     return false;
  });
});
*/


/**
 | captcha 인증코드 갱신
 |
 */
$(document).ready(function(){
	$("#btn_renew_code").click(function(){
		$.ajax({
			url: "/auth/renew_captcha", 
			success: function(result){
				//console.log(result);
				$("#span_captcha_html").html(result);
			}
		});
	});
});




/** - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
 | [이메일 유효성 검사]
 | - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -  */
	function validateEmail(email) {
		var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
		return re.test(email);
	}

	function chk_confirm(msg) {
		if(confirm(msg)) 
			return true;
		else
			return false;
	}


// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
// 공통
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

// 일반 삭제 검사 확인
	function del(href,msg=false) {
		if(msg == false) {
			msg = "\n한번 삭제한 자료는 복구할 방법이 없습니다.\n정말 삭제하시겠습니까?";
		}
		//if(confirm("한번 삭제한 자료는 복구할 방법이 없습니다.\n\n정말 삭제하시겠습니까?")) 
		if(confirm(msg)) 
			document.location.href = '/' + href;
	}

// 일반 삭제 검사 확인
	function del_confirm(href) {
		if(confirm("\n한번 삭제한 자료는 복구할 방법이 없습니다.\n삭제하시겠습니까?")) {
			if(confirm("정말 삭제하시겠습니까?")) {
				document.location.href = '/' + href;
			}
		}
	}

	function del_confirm_msg(href,msg="\n한번 삭제한 자료는 복구할 방법이 없습니다.\n삭제하시겠습니까?") {
		if(confirm(msg)) {
			if(confirm("정말 삭제하시겠습니까?")) {
				document.location.href = '/' + href;
			}
		}
	}

	function cancel_confirm_msg(href,msg="\n한번 취소한 자료는 복구할 수 없습니다.\n취소하시겠습니까?") {
		if(confirm(msg)) {
			if(confirm("정말 취소하시겠습니까?")) {
				document.location.href = '/' + href;
			}
		}
	}




// 일반 삭제 검사 확인
	function del_url(url) {
		if(confirm("\n한번 삭제한 자료는 복구할 방법이 없습니다.\n정말 삭제하시겠습니까?")) 
			document.location.href = url;
	}

// 일반 삭제 검사 확인
	function del_confirm_url(url) {
		if(confirm("\n한번 삭제한 자료는 복구할 방법이 없습니다.\n삭제하시겠습니까?")) {
			if(confirm("정말 삭제하시겠습니까?")) {
				document.location.href = url;
			}
		}
	}

// 페이지 이동
	function redirect(url) {
		document.location.href = url;
	}


// 팝업 열기
	function win_open(url, name, option) {
		var popup = window.open('/' + url, name, option);
		popup.focus();
	}

// 팝업 닫기
	function popup_close(id, onday) {
		if (onday) {
			var today = new Date();
			today.setTime(today.getTime() + (60*60*1000*24));
			document.cookie = id + "=" + escape( true ) + "; path=/; expires=" + today.toGMTString() + ";";
		}

		if (window.parent.name.indexOf(id) != -1)
			window.close();
		else
			document.getElementById(id).style.display = 'none';
	}


// POST 전송, 결과값 리턴
	function post_send(href, parm, del) {
		if (!del || confirm("\n한번 삭제한 자료는 복구할 수 없습니다.\n정말 삭제하시겠습니까?")) { 
			$.post('/' + href, parm, function(req) {
				document.write(req);
			});
		}
	}
	function post_send_restore(href, parm, del) {
		if (!del || confirm("복원하시겠습니까?")) { 
			$.post('/' + href, parm, function(req) {
				document.write(req);
			});
		}
	}

	// 삭제 전 한 번 더 확인
	function post_send_del_again(href, parm, del) {
		if (!del || confirm("\n한 번 삭제한 자료는 복구할 수 없습니다.\n정말 삭제하시겠습니까?")) { 
			if(confirm("\n정말 삭제해도 되겠습니까?\n")) {
				$.post('/' + href, parm, function(req) {
					document.write(req);
				});
			}
		}
	}

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
// 쿠키
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	function getCookieVal (offset) {
	   var endstr = document.cookie.indexOf (";", offset);
	   if (endstr == -1) endstr = document.cookie.length;
	   return unescape(document.cookie.substring(offset, endstr));
	}

	function GetCookie (name) {
	   var arg = name + "=";
	   var alen = arg.length;
	   var clen = document.cookie.length;
	   var i = 0;
	   while (i < clen) {	//while open
		  var j = i + alen;
		  if (document.cookie.substring(i, j) == arg)
			 return getCookieVal (j);
		  i = document.cookie.indexOf(" ", i) + 1;
		  if (i == 0) break; 
	   }	//while close
	   return null;
	}

	// SetCookie(name, value, [expires], [path], [domain], [secure])
	function SetCookie (name, value) {
	   var argv = SetCookie.arguments;
	   var argc = SetCookie.arguments.length;
	   var expires = (2 < argc) ? argv[2] : null;
	   var path = (3 < argc) ? argv[3] : null;
	   var domain = (4 < argc) ? argv[4] : null;
	   var secure = (5 < argc) ? argv[5] : false;
	   document.cookie = name + "=" + escape (value) +
		  ((expires == null) ? "" : 
			 ("; expires=" + expires.toGMTString())) +
		  ((path == null) ? "" : ("; path=" + path)) +
		  ((domain == null) ? "" : ("; domain=" + domain)) +
		  ((secure == true) ? "; secure" : "");
	} 



// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
// 기능
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

	// 숫자에 금액단위로 콤마 넣고 반환..
	function addComma(n) {
	 if(isNaN(n)){return 0;}
	  var reg = /(^[+-]?\d+)(\d{3})/;   
	  n += '';
	  while (reg.test(n))
		n = n.replace(reg, '$1' + ',' + '$2');
	  return n;
	}

	//숫자에서 콤마를 빼고 반환.
	function removeComma(n){
		n=n.replace(/,/g,"");
		if(isNaN(n)){return 0;} else{return n;}
	}

	// javascript 에서 trim 기능 구현
	function trim (str) {
		var	str = str.replace(/^\s\s*/, ''),
			ws = /\s/,
			i = str.length;
		while (ws.test(str.charAt(--i)));
		return str.slice(0, i + 1);
	}

	//숫자만
	function onlyNumber(){
		if((event.keyCode<48)||(event.keyCode>57))
		event.returnValue=false;
	}
	//숫자와 포인트만
	function NumberandPoint(){
		if((event.keyCode != 46)&&(event.keyCode<48)||(event.keyCode>57))
		event.returnValue=false;
	}
	//숫자와 마이너스만
	function NumberandMinus(){
		if((event.keyCode != 45)&&(event.keyCode<48)||(event.keyCode>57))
		event.returnValue=false;
	}
	//숫자와 콤마만
	function NumberandComma(){
		if((event.keyCode != 44)&&(event.keyCode<48)||(event.keyCode>57))
		event.returnValue=false;
	}



	function noHan(event){
		event = event || window.event;
		var keyID = (event.which) ? event.which : event.keyCode;
		if (!(keyID >=37 && keyID<=40)) {
			event.target.value = event.target.value.replace(/[^a-z0-9]/gi, "");
		}
	}
	function fnOnlyNumber(event){
		event = event || window.event;
		var keyID = (event.which) ? event.which : event.keyCode;
		
			if ( (keyID >= 48 && keyID <= 57) || (keyID >= 96 && keyID <= 105) || keyID == 8 || keyID == 46 || keyID == 37 || keyID == 39 || keyID == 9) {
				return;
			}else{
				return false;
			}
		
	}
	function removeChar(event) {
		event = event || window.event;
		var keyID = (event.which) ? event.which : event.keyCode;
		if ( keyID == 8 || keyID == 46 || keyID == 37 || keyID == 39 ) 
			return;
		else
			event.target.value = event.target.value.replace(/[^0-9]/g, "");
	}




	//화면크기 확대
	var zoomFirst = 100;
	function fn_zoomIn() {
		if (zoomFirst!=300){
			zoomFirst = zoomFirst + 10;
			document.getElementById("zoomInOut").style.zoom = zoomFirst+'%';
		}
	}
	//화면크기 축소
	function fn_zoomOut()    {
		if (zoomFirst!=80){
			zoomFirst = zoomFirst - 10;
			document.getElementById("zoomInOut").style.zoom = zoomFirst+'%';
		}
	}
	//화면크기 복원
	function fn_zoom100()    {
		document.getElementById("zoomInOut").style.zoom = '100%';
	}

	// fadeout
	function fadeout(id) {
		$('#'+id).fadeOut();
	}





// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
// 폼체크
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
function chk_form_val(type,id,title,id2,title2,len)
{
	if( type == 'require' ) 
	{
			// 필수 체크
			if( $('#' + id).val() == '' )
			{
				alert(title + ' 항목은 필수입니다.');
				$('#' + id).focus();

				if(id2 != '' )
				  $('#' + id2).focus();

				chk = false;
			}
			else
				chk = true;

	}

	if( type == 'confirm_check' ) 
	{
			// 필수 체크
			if( $('#' + id).val() == '' )
			{
				alert(title + '인지 확인중입니다.');
				$('#' + id).focus();

				if(id2 != '' )
				  $('#' + id2).focus();

				chk = false;
			}
			else
				chk = true;

	}

	// 비교 체크
	else if( type == 'match' )
	{

			if( $('#' + id).val() != $('#' + id2).val() )
			{
				alert(title + ' 항목과 ' + title2 + ' 항목이 일치하지 않습니다.');
				$('#' + id2).focus();

				chk = false;
			}
			else
				chk = true;

	}
	// 길이 체크
	else if( type == 'length' )
	{

			if( $('#' + id).val().length < len  )
			{
				alert(title + ' 항목은 ' + len + ' 글자 이상 입력 가능합니다.');
				$('#' + id).focus();


				if(id2 != '' )
				  $('#' + id2).focus();

				chk = false;
			}
			else
				chk = true;

	}
	// 길이 체크
	else if( type == 'limit_len' )
	{

			if( $('#' + id).val().length < len  )
			{
				alert(title + ' 항목을 다시 확인해주세요.');
				$('#' + id).focus();


				if(id2 != '' )
				  $('#' + id2).focus();

				chk = false;
			}
			else
				chk = true;

	}
	// 검색 체크
	else if( type == 'search' )
	{

			// 필수 체크
			if( $('#' + id).val() == '' )
			{
				alert('사용 가능한 ' + title + ' 항목인지 검색해주세요.');

				chk = false;
			}
			else
				chk = true;

	}
	// 체크박스라디오박스 체크
	else if( type == 'checkbox' )
	{

			if( ! $('#' + id).is(":checked")) {

				alert(title + ' 항목은 필수입니다.');
				$('#' + id).focus();

				chk = false;

			}
			else
				chk = true;

	}
	// 체크박스라디오박스 체크
	else if( type == 'radio' )
	{

			var name = id;

			if ($("input[name='" + name + "']:checked").length < 1) {

				alert(title + ' 항목은 필수입니다.');
				$('#' + id).focus();

				chk = false;

			}
			else
				chk = true;

			var chk_val = id2;
			if( chk == true && chk_val != '' )
			{
				if( chk_val != $("input[name='" + name + "']:checked").val() )
				{
					alert(title + ' 항목에 동의가 필요합니다.');
					chk = false;
				}
			}

	}
	// html 요소 존재 여부
	else if( type == 'is_html' )
	{

			var html_ctnt = $('#' + id).html();
			if( html_ctnt.length < 1 ) {

				alert(title + ' 항목은 필수입니다.');
				chk = false;

			}
			else
				chk = true;

	}

	return chk;
}





/** - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
 | 마우스 온오버시에 이미지 온/오프
 | - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -  */
	$(function() {
		$(".imgOver").mouseover(function(e) {imgOver(this);});
		$(".imgOver").focusin(function(e) {imgOver(this);});
		$(".imgOver").mouseout(function(e) {imgOut(this);});
		$(".imgOver").focusout(function(e) {imgOut(this);});
	});
	imgOver = function(obj) {
		//$(obj).children(":first-child").attr("src", function() {return this.src.replace("_off","_on");});
		$(obj).attr("src", function() {return this.src.replace("_off","_on");});
	};
	imgOut = function(obj) {
		//$(obj).children(":first-child").attr("src", function() {return this.src.replace("_on","_off");});
		$(obj).attr("src", function() {return this.src.replace("_on","_off");});
	};



/** - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
 | 마우스 온오버시에 이미지 온/오프 두 번째
 | - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -  */
	$(function() {
		$(".imgOnOff").mouseover(function(e) {imgOn(this);});
		$(".imgOnOff").focusin(function(e) {imgOn(this);});
		$(".imgOnOff").bind('touchstart',function(e) {imgOn(this);});

		$(".imgOnOff").mouseout(function(e) {imgOff(this);});
		$(".imgOnOff").focusout(function(e) {imgOff(this);});
	});
	imgOn = function(obj) {
		// 메뉴 모두 off
		var alt_no = $(obj).attr('alt');
		//console.log(alt_no);
		$('.imgOnOff').each(function(){
			$(this).attr("src", function() {return this.src.replace("_on","_off");});
		});
		$(obj).attr("src", function() {return this.src.replace("_off","_on");});

		// 컨텐츠 모두 off 후 선택 하나만 display
		$('.imgCtnt').removeClass('hide').addClass('hide');
		$('#imgCtnt'+alt_no).removeClass('hide');

	};
	imgOff = function(obj) {
		//$(obj).attr("src", function() {return this.src.replace("_on","_off");});
	};






/** - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
 | SNS 공유하기 소스
 | - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -  */

	// 페이스북
	function share_facebook() {
		window.open('https://www.facebook.com/sharer/sharer.php?u=' +encodeURIComponent(document.URL)+'&t='+encodeURIComponent(document.title), 'facebooksharedialog', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=300,width=600');
	}

	// 트위터
	function share_twitter() {
		window.open('https://twitter.com/intent/tweet?text='+encodeURIComponent(document.title)+'%20-%20'+encodeURIComponent(document.URL), 'twittersharedialog', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=300,width=600');
	}

	// 카카오스토리
	function share_kakaostory() {
		window.open('https://story.kakao.com/s/share?url=' +encodeURIComponent(document.URL), 'kakaostorysharedialog', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes, height=400,width=600');
	}




/** - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
 | 스크롤 감지
 | - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -  */

	// Hide Header on on scroll down
	var did_Scroll;
	var last_ScrollTop = 0;
	var delta = 5;

	$(window).scroll(function(event){
		did_Scroll = true;
	});

	setInterval(function() {
		if (did_Scroll) {
			has_Scrolled();
			did_Scroll = false;
		}
	}, 250);

	function has_Scrolled() {
		var st = $(this).scrollTop();
		
		// Make sure they scroll more than delta
		if(Math.abs(last_ScrollTop - st) <= delta)
			return;
		
		// If they scrolled down and are past the navbar, add class .nav-up.
		// This is necessary so you never see what is "behind" the navbar.
		if (st > last_ScrollTop){
			// Scroll Down
			return 'scroll_down';

		} else {
			// Scroll Up
			return 'scroll_up';
		}
		
		last_ScrollTop = st;
	} 





    function copyToClipboard(id='') {
      // 복사할 텍스트 요소 가져오기
      const textElement = document.getElementById(id);
      const text = textElement.textContent || textElement.innerText;

      // 클립보드에 텍스트 복사
      navigator.clipboard.writeText(text)
        .then(() => {
          alert("복사가 완료되었습니다!");
        })
        .catch((err) => {
          console.error("복사 실패: ", err);
          alert("복사에 실패했습니다.");
        });
    }