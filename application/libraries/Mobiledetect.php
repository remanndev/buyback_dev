<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/* 
 *  ======================================= 
 *  Author     : Muhammad Surya Ikhsanudin 
 *  License    : Protected 
 *  Email      : mutofiyah@gmail.com 
 *   
 *  Dilarang merubah, mengganti dan mendistribusikan 
 *  ulang tanpa sepengetahuan Author 
 *  ======================================= 
 */  
require_once APPPATH."/third_party/Mobile_Detect.php"; 

class Mobiledetect extends Mobile_Detect { 
  public function __construct() { 
	parent::__construct(); 

	$this->detect = new Mobile_Detect;
  } 

  function index() {
	$detect = new Mobile_Detect;
	return $detect;
  }

}