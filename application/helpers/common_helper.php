<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/** - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -- - - - - - - - - - - - -
 * URL 관련 helper
 *- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
 * HTTP의 URL을 "/"를 Delimiter로 사용하여 배열로 바꾸어 리턴한다.
 *
 * @param	string	대상이 되는 문자열
 * @return	string[]
 */
function segment_explode($seg)
{
	//세크먼트 앞뒤 '/' 제거후 uri를 배열로 반환
	$len = strlen($seg);
	if(substr($seg, 0, 1) == '/')
	{
		$seg = substr($seg, 1, $len);
	}
	$len = strlen($seg);

	if(substr($seg, -1) == '/')
	{
		$seg = substr($seg, 0, $len-1);
	}
	$seg_exp = explode("/", $seg);

	return $seg_exp;
}

//로그인 처리용 주소 인코딩, 디코딩
function url_code($url, $type='e')
{
	if($type == 'e')
	{
		//encode
		return strtr(base64_encode(addslashes(gzcompress(serialize($url), 9))), '+/=', '-_.');
		//return strtr(base64_encode(addslashes(gzcompress(serialize($url), 9))), '+/=', '-_^');
	}
	else
	{
		//decode
		return @unserialize(gzuncompress(stripslashes(base64_decode(strtr($url, '-_.', '+/=')))));
		//return @unserialize(gzuncompress(stripslashes(base64_decode(strtr($url, '-_^', '+/=')))));
	}
}





// 뒤로 가기
function history_back() {
	$CI =& get_instance();

	echo "<meta http-equiv=\"content-type\" content=\"text/html; charset=".$CI->config->item('charset')."\">";
	echo "<script type='text/javascript'> history.go(-1); </script>";
	exit;
}

// 해당 url로 이동
function goto_url($url) {
	$temp = parse_url($url);
	//if (empty($temp['host'])) {
	if (isset($temp['host']) && empty($temp['host'])) {
		$CI =& get_instance();
		$url = ($temp['path'] != '/') ? '/'.$url : $CI->config->item('base_url');
	}
	echo "<script type='text/javascript'> location.replace('".$url."'); </script>";
	exit;
}

// script 실행
function run_script($script=FALSE) {
  //open_auth_layer('login_layer');
  if( $script ) {
	$CI =& get_instance();

	echo "<meta http-equiv=\"content-type\" content=\"text/html; charset=".$CI->config->item('charset')."\">";
	echo "<script type='text/javascript'>";
    echo $script;
    echo "</script>";
	exit;
  }
}



// 특수 문자 제거
function remove_special_word($string,$except=FALSE) {
	if('.' === $except) {
		$string = preg_replace("/[ #\&\+\-%@=\/\\\:;,'\"\^`~\_|\!\?\*$#<>()\[\]\{\}]/i", "", $string);
	}
	else {
		$string = preg_replace("/[ #\&\+\-%@=\/\\\:;,\.'\"\^`~\_|\!\?\*$#<>()\[\]\{\}]/i", "", $string);
	}
	return $string;
}






/**
 * Show info message
 *
 * @param	string
 * @return	void
 */
function sess_message($message)
{
	$CI =& get_instance();
	$CI->session->set_flashdata('message', $message);
}

function sess_name_message($sess_name='message',$message)
{
	$CI =& get_instance();
	$CI->session->set_flashdata($sess_name, $message);
}







/** - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -- - - - - - - - - - - - -
 * 문자 관련 helper
 *- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
 *
 * @param	string	대상이 되는 문자열
 * @return	string[]
 */

// 한글 한글자(2byte, 유니코드 3byte)는 길이 2, 공란.영숫자.특수문자는 길이 1
function cut_str($str, $len, $suffix='…') {
    $s = substr($str, 0, $len);

    $cnt = 0;
    for ($i=0; $i<strlen($s); $i++) {
        if (ord($s[$i]) > 127)
            $cnt++;
    }

    $CI =& get_instance();
    if (strtoupper($CI->config->item('charset')) == 'UTF-8')
        $s = substr($s, 0, $len - ($cnt % 3));
    else
        $s = substr($s, 0, $len - ($cnt % 2));

    if (strlen($s) >= strlen($str))
        $suffix = '';

    return $s . $suffix;
}



function cut_str_name($str, $begin, $len, $suffix='') {
    $s = substr($str, $begin, $len);

    $cnt = 0;
    for ($i=0; $i<strlen($s); $i++) {
        if (ord($s[$i]) > 127)
            $cnt++;
    }

    $CI =& get_instance();
    if (strtoupper($CI->config->item('charset')) == 'UTF-8')
        $s = substr($s, 0, $len - ($cnt % 3));
    else
        $s = substr($s, 0, $len - ($cnt % 2));

    if (strlen($s) >= strlen($str))
        $suffix = '';

    return $s . $suffix;
}


/* 자르기.. 영어(알파벳), 한글(음절) 모두 한 자씩 처리 함수 정의 */
function cut_string($string,$start,$length,$suffix='',$charset=NULL) {     
	if($charset==NULL) {
		$charset='UTF-8';
	}
	/* 정확한 문자열의 길이를 계산하기 위해, mb_strlen 함수를 이용 */
	$str_len=mb_strlen($string,'UTF-8'); 
	if($str_len>$length) {   
		/* mb_substr  PHP 4.0 이상, iconv_substr PHP 5.0 이상 */
		$string=mb_substr($string,$start,$length,'UTF-8');   
		$string.=$suffix;
	}         
	return $string;             
}





function get_text($str) {
	// &nbsp; &amp; &middot; 등의 코드를 정상으로 출력
	// "/\&([a-z0-9]{1,20}|\#[0-9]{0,3});/i" -> "&#038;\\1;"
	$str = str_replace(
		array("<", ">", "'"),
		array("&lt;", "&gt;", "&#039;"), $str
	);

	return $str;
}

// 이게 뭐더라...
function conv_content($str, $html) {
	$CI =& get_instance();
	$CI->load->library('typography');

    if ($html) {
		// 동영상 출력
        function entity_decode($text) { return htmlspecialchars_decode($text[0]); }
        $str = preg_replace_callback('#(<|&lt;)/?(object|embed|param)([^>]*|[^&gt;]*)(&gt;|>)#i', 'entity_decode', $str);

		$str = $CI->typography->auto_typography($str); // format_characters
	}
    else {
		$str = get_text($str);
		$str = $CI->typography->nl2br_except_pre($str);
	}

	// URL 링크
	$patterns = array(
		"/&lt;/", "/&gt;/", "/&amp;/", "/&quot;/", "/&nbsp;/",
		"/([^(http:\/\/)]|\(|^)(www\.[a-zA-Z0-9\.-]+)/i",
		"/([^(HREF=\"?'?)|(SRC=\"?'?)]|\(|^)((http|https|ftp|telnet|news|mms):\/\/[a-zA-Z0-9\.-]+\.[가-힣\xA1-\xFEa-zA-Z0-9\.:&#=_\?\/~\+%@;\-\|\,\(\)]+)/i",
		// EUC-KR "/([^(HREF=\"?'?)|(SRC=\"?'?)]|\(|^)((http|https|ftp|telnet|news|mms):\/\/[a-zA-Z0-9\.-]+\.[\xA1-\xFEa-zA-Z0-9\.:&#=_\?\/~\+%@;\-\|\,\(\)]+)/i",
		"/([0-9a-z]([-_\.]?[0-9a-z])*@[0-9a-z]([-_\.]?[0-9a-z])*\.[a-z]{2,4})/i",
		"/\t_nbsp_\t/", "/\t_lt_\t/", "/\t_gt_\t/"
	);
	$replace = array(
		"\t_lt_\t", "\t_gt_\t", "&", "\"", "\t_nbsp_\t",
		"\\1<a href=\"http://\\2\" target='_blank'>\\2</a>",
		"\\1<a href=\"\\2\" target='_blank'>\\2</a>",
		"<a href='mailto:\\1'>\\1</a>",
		"&nbsp;", "&lt;", "&gt;"
	);
	$str = preg_replace($patterns, $replace, $str);

	return $str;
}

// 이건 또 뭐더라.. 검색할 때 사용하던 건가?
function search_font($str, $stx, $tag_open='<code style="color:#ff0000;">', $tag_close = '</code>') {
	if ($str == '')
		return FALSE;

	if ($stx != '') {
		// 문자앞에 \ 를 붙인다.
		$src = array('/', '|');
		$dst = array('\/', '\|');

		if (!trim($stx)) return $str;

		// 검색어 전체를 공란으로 나눈다
		$s = explode(' ', $stx);

		// '/(검색1|검색2)/i' 와 같은 패턴을 만듬
		$pattern = '';
		$bar = '';
		foreach($s as $row) {
			if (trim($row) == '')
				continue;
			$tmp_str = str_replace($src, $dst, quotemeta($row));
			$pattern .= $bar . $tmp_str . '(?![^<]*>)';
			$bar = '|';
		}

		return preg_replace('/('.$pattern.')/i', $tag_open.'\\1'.$tag_close, $str);

		// 기존
		// return preg_replace('/('.preg_quote($stx, '/').')/i', $tag_open."\\1".$tag_close, $str);
	}

	return $str;
}















/** - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -- - - - - - - - - - - - -
 * 랜덤 함수 helper
 *- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
 */

// 페이지 코드 생성
function new_code($len,$size='upper') {
	$return_str="";
	for($i = 0; $i < $len; $i++)
	{
		mt_srand((double)microtime()*1000000);
		if( $len < 5 )
		{
			if('upper' === $size){
				$return_str .= substr('ABCDEFGHIJKLMNOPQRSTUVWXYZ', mt_rand(0,25),1);
			}else{
				$return_str .= substr('abcdefghijklmnopqrstuvwxyz', mt_rand(0,25),1);
			}

		}
		else
		{
			if('upper' === $size){
				$return_str .= substr('ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890', mt_rand(0,35),1);
			}else{
				$return_str .= substr('abcdefghijklmnopqrstuvwxyz1234567890', mt_rand(0,35),1);
			}

		}
	}
	return $return_str;
}



// 회원 코드 생성
function make_upro_code($len,$size='upper') {
	$return_str="";
	for($i = 0; $i < $len; $i++)
	{
		mt_srand((double)microtime()*1000000);
		if( $i < 5 )
		{
			if('upper' === $size){
				$return_str .= substr('ABCDEFGHIJKLMNOPQRSTUVWXYZ', mt_rand(0,26),1);
			}else{
				$return_str .= substr('abcdefghijklmnopqrstuvwxyz', mt_rand(0,26),1);
			}

		}
		else
		{
			if('upper' === $size){
				$return_str .= substr('ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890', mt_rand(0,36),1);
			}else{
				$return_str .= substr('abcdefghijklmnopqrstuvwxyz1234567890', mt_rand(0,36),1);
			}

		}
	}
	return $return_str;
}


// 숫자 랜덤함수
function randnumber($len)
{
	$return_str="";
	for($i = 0; $i < $len; $i++)
	{
		mt_srand((double)microtime()*1000000);
		$return_str .= substr('0123456789', mt_rand(0,10),1);
	}
	return $return_str;
}

// 문자(소문자) 랜덤함수
function rand_str($total_len)
{
	$return_str="";
	for($i = 0; $i < $total_len; $i++)
	{
		mt_srand((double)microtime()*1000000);
		$return_str .= substr('abcdehkmnorstuvwxz', mt_rand(0,18),1); // fgijlpqy 제외
	}
	return $return_str;
}

// 문자(대문자)와 숫자 랜덤함수
function randstrupper($len)
{
	$return_str="";
	for($i = 0; $i < $len; $i++)
	{
		mt_srand((double)microtime()*1000000);
		//$return_str .= substr('ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890', mt_rand(0,36),1);
		$return_str .= substr('ABCDEFGHIJKLMNOPQRSTUVWXYZ123456789', mt_rand(0,35),1);
	}
	return $return_str;
}

// 문자(소문자)와 숫자 랜덤함수
function randstrlower($len)
{
	$return_str="";
	for($i = 0; $i < $len; $i++)
	{
		mt_srand((double)microtime()*1000000);
		$return_str .= substr('0123456789abcdefghijklmnopqrstuvwxyz0123456789', mt_rand(0,45),1);
	}
	return $return_str;
}


// 문자(소문자)와 숫자 랜덤함수
function randstrlower2($len)
{
	$return_str="";
	for($i = 0; $i < $len; $i++)
	{
		mt_srand((double)microtime()*1000000);
		$return_str .= substr('0123456789abcdehkmnorstuvwxz0123456789', mt_rand(0,38),1); // fgijlpqy 제외
	}
	return $return_str;
}

// 랜덤 함수 응용 : 한 번에 여러 개의 랜덤수 뽑아내기
// get_random_number("처음 수", "마지막 수", "뽑아낼 랜덤 개수")
function get_random_number($num_first="1", $num_last="100", $get_cnt="10") {
  $cnt = 0;
  $chk = $data = array();
  while ( $cnt<$get_cnt )
  {
   $rand = mt_rand($num_first,$num_last);
   if ( !isset($chk[$rand]) ) {
    $chk[$rand] = 1;
    $data[] = $rand;
    $cnt++;
   }
  }
  return $data;
}

// 랜덤 함수 응용 : 한 번에 여러 개의 랜덤수 뽑아내기(배열의 크기가 작은 경우 적합)
// get_random_number("처음 수", "마지막 수", "뽑아낼 랜덤 개수")
function get_shuffle_number($num_first="1", $num_last="100", $get_cnt="10") {

  $temp = range($num_first,$num_last);
  shuffle($temp);
  $data = array_slice($temp,0,$get_cnt);

  //print_r($data);
  return $data;
}


// 마이크로 타임(1/100, 백분의1초 단위 시간 리턴)
function microtime_float()
{
    list($usec, $sec) = explode(" ", microtime());
    return ((float)$usec + (float)$sec);
}





function format_insurance($num) {
    $len = strlen((string)$num);

    if ($len == 1) {
        return "000" . $num;
    } elseif ($len == 2) {
        return "00" . $num;
    } elseif ($len == 3) {
        return "0" . $num;
    } else {
        return (string)$num;
    }
}




/** - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -- - - - - - - - - - - - -
 * HTML 관련 helper
 *- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
 */

// get video src
function get_video_tag($str,$w='300px',$h='auto') {

    $strArr = explode( "<iframe", $str);
    $strCnt = count($strArr);
    $strResult = "";

	//print_r($strArr);
	//echo '<hr style="border-bottom:1px solid red;" />';

    if($strCnt > 1  &&  isset($strArr[1])) {

	  $strArr2 = explode( "</iframe>", $strArr[1]);
	  $strCnt2 = count($strArr2);

	  if($strCnt2 > 1  &&  isset($strArr2[0])) {
		$strResult .= "<iframe style='width:100%; max-width:".$w."; height:".$h.";' ";
		$strResult .= $strArr2[0];
		$strResult .= "</iframe>";
	  }
	  else {
		$strResult .= "<iframe style='width:100%; max-width:".$w."; height:".$h.";' ";
		$strResult .= $strArr[1];
		$strResult .= "</iframe>";
	  }

    }

	return $strResult;
}



// head tag를 아예 제거하는 함수 ▶ <head 와 </head> 안에 있는 건 다 제거합니다.
function remove_head($str) {
   $strArr = explode( "<head", $str);
   $strCnt = count($strArr);
   $strResult = "";
   for($i=0;$i<$strCnt;$i++) {
    $str2Arr[$i] = explode( "</head>", $strArr[$i]);
    if($i==0 && $str2Arr[$i][0]!="")
  $strResult .= $str2Arr[$i][0];
    else
  $strResult .= $str2Arr[$i][1];
   }
  return $strResult;
}

// script tag를 아예 제거하는 함수 ▶ <script 와 </script> 안에 있는 건 다 제거합니다.
function remove_script($str) {
   $strArr = explode( "<script", $str);
   $strCnt = count($strArr);
   $strResult = "";
   for($i=0;$i<$strCnt;$i++) {
    $str2Arr[$i] = explode( "</script>", $strArr[$i]);
    if($i==0 && $str2Arr[$i][0]!="")
  $strResult .= $str2Arr[$i][0];
    else
  $strResult .= $str2Arr[$i][1];
   }
  return $strResult;
}

// [배열 리턴] html tag와 공백을 제거하고 실제 내용만 배열화하는 함수 ▶ 꺽쇠(<>)포함, 안에 있는 건 다 제거합니다.
function remove_tags_make_arr($str) {
   $str = get_text($str);

   $str = str_replace('<', '&lt;', $str);
   $str = str_replace('>', '&gt;', $str);



   //$strArr = explode( "<", $str);
   $strArr = explode( "&lt;", $str);
   $strCnt = count($strArr);
   $strResult = "";

   $ano = 0;
   $arr_data = array();

   for($i=0;$i<$strCnt;$i++) {
    //$str2Arr[$i] = explode( ">", $strArr[$i]);
    $str2Arr[$i] = explode( "&gt;", $strArr[$i]);

    if($i==0 && $str2Arr[$i][0]!="") {
		$tmp_str = isset($str2Arr[$i][0]) ? $str2Arr[$i][0] : '';
	}
    else {
		$tmp_str = isset($str2Arr[$i][1]) ? $str2Arr[$i][1] : '';
	}

    if(trim($tmp_str) != "") {
		$arr_data[$ano] = $tmp_str;
		$ano++;
    }
   }

  return $arr_data;
}


// html tag와 공백을 제거하고 실제 텍스트만 리턴하는 함수 ▶ 꺽쇠(<>)포함, 안에 있는 건 다 제거합니다.
function remove_tags($str) {
	$str = get_text($str);
   $strArr = explode( '&lt;', $str);
   $strCnt = count($strArr);
   $strResult = "";

   $ano = 0;
   $arr_data = array();

   for($i=0;$i<$strCnt;$i++) {
    $str2Arr[$i] = explode( '&gt;', $strArr[$i]);
	$str2Cnt = count($str2Arr[$i]);

	//print_r($str2Arr[$i]);
	//echo $str2Cnt."<br><br>";

    if($i==0 && $str2Arr[$i][0]!='')
		$tmp_str = $str2Arr[$i][0];
	elseif($str2Cnt > 1)
		$tmp_str = $str2Arr[$i][1];
    else
		$tmp_str = '';


    if(trim($tmp_str) != "") {
   $arr_data[$ano] = $tmp_str;
   $ano++;
    }
   }

  $return_str = implode(' ',$arr_data);
  return $return_str;
}


function remove_tags_all($str="") {

	// 불당팩 : 파일이름속의 공백을 없애줍니다
	$str = str_ireplace(" ", "", $str);

	// 불당팩 : 파일이름속의 특수문자를 없애줍니다.
	//$str = $string = preg_replace ("/[ #\&\+\-%@=\/\\\:;,\.'\"\^`~\_|\!\?\*$#<>()\[\]\{\}]/i", "",  $str);
	$str = $string = preg_replace ("/[ #\&\+\-%@=\/\\\:;,\'\"\^`~\_|\!\?\*$#<>()\[\]\{\}]/i", "",  $str);

	// 아래의 문자열이 들어간 파일은 -x 를 붙여서 웹경로를 알더라도 실행을 하지 못하도록 함
	//$str = preg_replace("/\.(php|phtm|htm|cgi|pl|exe|jsp|asp|inc)/i", "$0-x", $str);

	return $str;
}






// ▶▶ 1. 가져오기를 원하는 url의 페이지 정보 파싱 ◀◀
function get_fetch_url($the_url) {
  $content = '';

  $url_parsed = parse_url($the_url);
  $host = $url_parsed["host"];
  $port = isset($url_parsed["port"]) ? $url_parsed["port"] : '80';
  //if($port==0) $port = 80;
  $the_path = $url_parsed["path"];
  if(empty($the_path)) $the_path = "/";
  if(empty($host)) return false;
  if( isset($url_parsed["query"]) && $url_parsed["query"] != "") $the_path .= "?".$url_parsed["query"];
  $out = "GET ".$the_path." HTTP/1.0\r\nHost: ".$host."\r\n\r\nUser-Agent: Mozilla/4.0 \r\n";
  $fp = fsockopen($host, $port, $errno, $errstr, 30);
  usleep(50);
  if($fp) {
   socket_set_timeout($fp, 30);
   fwrite($fp, $out);
   $body = false;
   $i=0;
   while(!feof($fp)) {
    $buffer = fgets($fp, 128);
    if($body) $content .= $buffer;
    if($buffer=="\r\n") $body = true;
    $i++;
   }
   fclose($fp);
  }
  else {
   return false;
  }
  return $content;
}

// ▶▶ 2. 파싱해 온 정보로 환율정보 추출하기 ◀◀
function get_exchange_info($currency) {
  //--------------------------------------------------------------------------------------------------------------------
  // 환율 소스 사이트 : http://community.fxkeb.com/fxportal/jsp/RS/DEPLOY_EXRATE/fxrate_all.html
  //--------------------------------------------------------------------------------------------------------------------
  // $currency 는 국가별 통화 코드, 위 사이트 참조
  //--------------------------------------------------------------------------------------------------------------------
  // 가져오기를 원하는 국가의 환율 정보
  // $exchange_info[0] : 통화명
  // $exchange_info[1] : 현찰 살 때
  // $exchange_info[2] : 현찰 팔 때
  // $exchange_info[3] : 송금 보낼 때
  // $exchange_info[4] : 송금 받을 때
  // $exchange_info[5] : 수표 팔 때
  // $exchange_info[6] : 매매기준율
  // $exchange_info[7] : 미화환산율
  //--------------------------------------------------------------------------------------------------------------------
  // 환율 소스 사이트
  //$str_fetch = $this->get_fetch_url("http://community.fxkeb.com/fxportal/jsp/RS/DEPLOY_EXRATE/fxrate_all.html");
  $str_fetch = $this->get_fetch_url("https://search.naver.com/search.naver?sm=top_hty&fbm=0&ie=utf8&query=%ED%99%98%EC%9C%A8");

  $strArr = explode( "<", $str_fetch);                                  // 왼쪽 꺽쇠(<)로 내용 분할
  $strCnt = count($strArr);                                                 // 위에서 분할한 배열의 count 값
  for($i=0;$i<$strCnt;$i++) {
   $str2Arr[$i] = explode( ">", $strArr[$i]);                      // 다시 오른쪽 꺽쇠(>)로 내용 2차 분할
   $str_position = strchr($str2Arr[$i][1],$currency);            // 찾고자 하는 국가 정보의 위치값($i) 검색
   if($str_position) $str_no = $i;                                       // 찾고자 하는 국가 정보의 위치값($i) 저장
  }
  for($k=0;$k<8;$k++) {
   if($k==0)
    $str_info[$k] = $currency;
   else
    $str_info[$k] = trim($str2Arr[($str_no+(2*$k))][1]);     // 찾고자 하는 국가의 환율정보값 저장
  }
  return $str_info;
}














 /**
  * 하뒤 디렉토리 파일까지 퍼미션 지정
  *
  * @param String $path : 디렉토리
  * @param int $filemode : 퍼미션 값
  */
 function chmodr($path, $filemode) {
  $CI =& get_instance();
  if (!is_dir($path))
   return chmod($path, $filemode);

  $dh = opendir($path);
  while (($file = readdir($dh)) !== false) {
   if($file != '.' && $file != '..') {
    $fullpath = $path.'/'.$file;

    if(is_link($fullpath))
     return FALSE;
    elseif(!is_dir($fullpath) && !chmod($fullpath, $filemode))
      return FALSE;
    elseif(!$CI->common->chmodr($fullpath, $filemode))
     return FALSE;
   }
  }

  closedir($dh);

  if(chmod($path, $filemode))
   return TRUE;
  else
   return FALSE;
 }

 /**
  * 디렉토리 삭제
  * @param String $dir : 삭제할 디렉토리
  * @return Boolean
  */
 function deleteDirectory($dir) {
  if (!file_exists($dir)) return true;
  if (!is_dir($dir) || is_link($dir)) return unlink($dir);

  foreach (scandir($dir) as $item) {
   if ($item == '.' || $item == '..') continue;
   if (!$this->deleteDirectory($dir . "/" . $item)) {
    chmod($dir . "/" . $item, 0777);
    if (!$this->deleteDirectory($dir . "/" . $item)) return false;
   };
  }
  return rmdir($dir);
 }

 /**
  * 디렉토리 통체로 복사하여 하위 디렉토리까지 복사.
  *
  * @param String $src : 복사 할 디렉토리.
  * @param String $dst : 복사 될 디렉토리.
  */
 function recurseCopy($src, $dst) {
  $dir = opendir($src);
  @ mkdir($dst);
  while (false !== ($file = readdir($dir))) {
   if (($file != '.') && ($file != '..')) {
    if (is_dir($src . '/' . $file)) {
     $this->recurseCopy($src . '/' . $file, $dst . '/' . $file);
    } else {
     copy($src . '/' . $file, $dst . '/' . $file);
    }
   }
  }
  closedir($dir);
 }














/** - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -- - - - - - - - - - - - -
 * alert
 *- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
 */

// 경고메세지를 경고창으로
function alert($msg='', $url='')
{
	$CI =& get_instance();

	if (!$msg) $msg = '올바른 방법으로 이용해 주십시오.';

	echo "<meta http-equiv=\"content-type\" content=\"text/html; charset=".$CI->config->item('charset')."\">";
	echo "<script type='text/javascript'>alert('".$msg."');";
    if ($url) :
        //echo "location.replace('".$url."');";
		$temp = parse_url($url);
		//if (empty($temp['host'])) {
		if (isset($temp['host']) && empty($temp['host'])) {
			$CI =& get_instance();
			$url = ($temp['path'] != '/') ? '/'.$url : $CI->config->item('base_url');
		}
		echo "location.replace('".$url."');";
	else :
		echo "history.go(-1);";
	endif;
	echo "</script>";
	exit;
}

// 경고 메시지 후 새창 띄우고 이동
function alert_popup($msg='', $url='', $popup_url='')
{
	$CI =& get_instance();

	if (!$msg) $msg = '올바른 방법으로 이용해 주십시오.';

	echo "<meta http-equiv=\"content-type\" content=\"text/html; charset=".$CI->config->item('charset')."\">";
	echo "<script type='text/javascript'>alert('".$msg."');";
    if ($url) :

		if($popup_url):
			echo "window.open('". $popup_url ."', '_blank'); ";
		endif;

        //echo "location.replace('".$url."');";
		$temp = parse_url($url);
		//if (empty($temp['host'])) {
		if (isset($temp['host']) && empty($temp['host'])) {
			$CI =& get_instance();
			$url = ($temp['path'] != '/') ? '/'.$url : $CI->config->item('base_url');
		}
		echo "location.replace('".$url."');";
	else :
		echo "history.go(-1);";
	endif;
	echo "</script>";
	exit;
}



// 경고메세지 출력후 창을 닫음
function alert_close($msg)
{
	$CI =& get_instance();

	echo "<meta http-equiv=\"content-type\" content=\"text/html; charset=".$CI->config->item('charset')."\">";
	echo "<script type='text/javascript'> alert('".$msg."'); window.close(); </script>";
	exit;
}

// 경고메세지만 출력
function alert_only($msg)
{
	$CI =& get_instance();

	echo "<meta http-equiv=\"content-type\" content=\"text/html; charset=".$CI->config->item('charset')."\">";
	echo "<script type='text/javascript'> alert('".$msg."'); </script>";
	exit;
}


// 경고메세지만 출력
function alert_stay($msg)
{
	$CI =& get_instance();

	echo "<meta http-equiv=\"content-type\" content=\"text/html; charset=".$CI->config->item('charset')."\">";
	echo "<script type='text/javascript'> alert('".$msg."'); </script>";
	//exit;
}


// 경고메세지 출력후 레이어 감춤
function alert_hide($id, $msg) {
	$CI =& get_instance();

	echo "<meta http-equiv=\"content-type\" content=\"text/html; charset=".$CI->config->item('charset')."\">";
	echo "<script type='text/javascript'> alert('".$msg."'); </script>";
	echo "<script type='text/javascript'> $('#".$id."').hide();</script>";
	exit;
}

/**
 *경고메세지 출력 후 입력창 초기화, 레이어 감춤
 * function alert_init_hide(감추고자하는레이어ID, 초기화할입력창ID, 메시지)
 */
function alert_init_hide($layer_id, $input_id, $msg) {
	$CI =& get_instance();

	echo "<meta http-equiv=\"content-type\" content=\"text/html; charset=".$CI->config->item('charset')."\">";
	echo "<script type='text/javascript'> alert('".$msg."'); </script>";
	echo "<script type='text/javascript'> $('#".$input_id."').val('');</script>";
	echo "<script type='text/javascript'> $('#".$layer_id."').hide();</script>";
	exit;
}


/**
 * 메시지 출력 후 부모창은 원하는 페이지로 이동하고 자신(팝업창)은 닫기
 */
function alert_opener_replace_popup_close($url, $msg=FALSE) {

	$CI =& get_instance();
	$temp = parse_url($url);
	//if (empty($temp['host'])) {
	if (isset($temp['host']) && empty($temp['host'])) {
		$url = ($temp['path'] != '/') ? RT_PATH.'/'.$url : $CI->config->item('base_url').RT_PATH;
	}
	echo "<meta http-equiv=\"content-type\" content=\"text/html; charset=".$CI->config->item('charset')."\">";
	if($msg) { echo "<script type='text/javascript'> alert('".$msg."'); window.close(); </script>"; }
	echo "<script type='text/javascript'> opener.location.replace('".$url."'); </script>";
	echo "<script type='text/javascript'> window.close(); </script>";
	exit;
}


function reload_page() {
	$CI =& get_instance();
	echo "<meta http-equiv=\"content-type\" content=\"text/html; charset=".$CI->config->item('charset')."\">";
	echo "<script type='text/javascript'> window.location.reload(); </script>";
	exit;
}


function reload_parent_page() {
	$CI =& get_instance();
	echo "<meta http-equiv=\"content-type\" content=\"text/html; charset=".$CI->config->item('charset')."\">";
	echo "<script type='text/javascript'> parent.location.reload(); </script>";
	exit;
}









/** - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -- - - - - - - - - - - - -
 * time
 *- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
 */

function set_timeout($func,$sec_micro) {
	$CI =& get_instance();

	echo "<meta http-equiv=\"content-type\" content=\"text/html; charset=".$CI->config->item('charset')."\">";
	echo "<script type='text/javascript'> setTimeout( function { ". $func ."}, ". $sec_micro ."); </script>";
	exit;
}











// 치환
/*
- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - 
$string = 'The quick brown fox jumped over the lazy dog.';
$patterns[0] = '/quick/';
$patterns[1] = '/brown/';
$patterns[2] = '/fox/';
$replacements[2] = 'bear';
$replacements[1] = 'black';
$replacements[0] = 'slow';
- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - 
[result]
The bear black slow jumped over the lazy dog.
- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - 
*/
function replace_tag($patterns, $replacements, $string)
{
	return preg_replace($patterns, $replacements, $string);
}







// array_fill_keys (PHP 5 >= 5.2.0) -_-
function array_false($arr, $is_key=FALSE) {
	if ($is_key)
		$arr = array_keys($arr);

	foreach ($arr as $val) {
		$row[$val] = FALSE;
	}
	return $row;
}










// 작업아이콘 출력
function icon($act, $link, $target='_self') {

	$btn_color = '';
    switch ($act) {
    	case '작성': $icon = 'pencil'; break;
    	case '추가': $icon = 'plus'; break;
    	case '생성': $icon = 'plus'; break;
    	case '수정': $icon = 'edit';  $btn_color = 'btn-secondary';break;
    	case '삭제': $icon = 'trash'; $btn_color = 'btn-danger'; break; // remove
    	case '보기': $icon = 'search'; $btn_color = 'btn-dark'; break;
    	case '미리보기': $icon = 'picture'; break;
		case '목록': $icon = 'list'; break;
		case '복구': $icon = 'trash'; $btn_color = 'btn-info'; break; // restore
    }

    /*
	$icon = '<span class="glyphicon glyphicon-'.$icon.'" alt="'.$act.'">'.$act.'</span>';
	if (strpos($link, 'javascript') === FALSE)
		$btn = "<a href='".RT_DIR.'/admin/'.$link."' class='btn btn-sm btn-default-flat ".$btn_color."' target='".$target."' title='".$act."'>".$icon."</a>";
	else
		$btn = "<a href='javascript:;' class='btn btn-sm btn-default-flat ".$btn_color."' onclick=\"".$link."\" title='".$act."'>".$icon."</a>";
	*/

	if (strpos($link, 'javascript') === FALSE)
		$btn = "<a href='".RT_DIR.'/admin/'.$link."' class='btn btn-xs btn-default-flat ".$btn_color."' target='".$target."' title='".$act."'>".$act."</a>";
	else
		$btn = "<a href='javascript:;' class='btn btn-xs btn-default-flat ".$btn_color."' onclick=\"".$link."\" title='".$act."'>".$act."</a>";

    return $btn;
}




// 시작날짜와 마지막날짜 사이의 날짜들 배열로 구하기
function getDatesStartToLast($startDate, $lastDate) {
    $regex = "/^\d{4}-(0[1-9]|1[012])-(0[1-9]|[12][0-9]|3[0-1])$/";
    if(!(preg_match($regex, $startDate) && preg_match($regex, $lastDate))) return "Not Date Format";
    $period = new DatePeriod( new DateTime($startDate), new DateInterval('P1D'), new DateTime($lastDate." +1 day"));
    foreach ($period as $date) $dates[] = $date->format("Y-m-d");
    return $dates;
}









// 단어가 포함되어 있는지 확인하는 함수
function checkWordsInUrl($url, $words) {
	$chk = '';
    foreach ($words as $word) {
        // strpos() 함수를 사용하여 단어가 URL에 있는지 확인
        if (strpos($url, $word) !== false) {
            //echo "URL에 '{$word}'가 포함되어 있습니다.\n";
			$chk = $word;
			//break;
        } else {
            //echo "URL에 '{$word}'가 포함되어 있지 않습니다.\n";
        }
    }
	return $chk;
}








/* End of file common_helper.php */
/* Location: ./application/helpers/common_helper.php */