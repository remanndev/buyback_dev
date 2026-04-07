<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pdf extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->arr_seg = $this->uri->segment_array();
	}

}