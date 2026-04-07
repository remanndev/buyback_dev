<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * load_css
 *
 * CSS를 등록 한다.
 *
 * @param string css file 경로
 * @return void
 */
if ( ! function_exists('load_css'))
{
  function load_css($css_file)
  {
    $key = md5($css_file);

    if(!isset($GLOBALS['hoksi_css'][$key]) || $GLOBALS['hoksi_css'][$key]) {
      $GLOBALS['hoksi_css'][$key] = $css_file;
    }
  }
}

/**
 * load_js
 *
 * 자바 스크립트를 등록 한다.
 *
 * @param string javascript file 경로
 * @return void
 */
if ( ! function_exists('load_js'))
{
  function load_js($js_file)
  {
    $key = md5($js_file);

    if(!isset($GLOBALS['hoksi_js'][$key]) || $GLOBALS['hoksi_js'][$key]) {
      $GLOBALS['hoksi_js'][$key] = $js_file;
    }
  }
}


/* End of file load_helper.php */
/* Location: ./application/helpers/load_helper.php */