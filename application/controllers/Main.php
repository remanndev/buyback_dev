<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		
		redirect('/sell');

		//$this->load->library('tank_auth');
	}

	public function index()
	{


		// load css, js  - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		/*
			load_css('<link rel="stylesheet" href="'.LIB_DIR.'/slider/slick-1.8.1/slick/slick.css" />');
			load_css('<link rel="stylesheet" href="'.LIB_DIR.'/slider/slick-1.8.1/slick/slick-theme.css" />');
			load_js('<script src="'.LIB_DIR.'/slider/slick-1.8.1/slick/slick.min.js"></script>');
			load_css('<link href="//spoqa.github.io/spoqa-han-sans/css/SpoqaHanSansNeo.css" rel="stylesheet" type="text/css">');
		*/


		$data = array(
			'viewPage' => 'main_view'
		);

		$this->load->view('layout/layout_view', $data);
	}
}
