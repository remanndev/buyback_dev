<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Recycle extends CI_Controller {
	function __construct() {
		parent::__construct();

		$this->load->helper(array('form', 'url','load'));
		$this->load->helper('security');

		$this->load->library('form_validation');
		$this->load->library('tank_auth');
		$this->load->library('upload_lib');
	}

	public function index() {
		$this->main();

	}

	public function main25() {
		$data = array(
			'viewPage' => 'recycle/main_25_view'
		);
		$this->load->view('layout_recycle_view', $data);
	}

	public function main() {
		$data = array(
			'viewPage' => 'recycle/main_2601_view'
		);
		$this->load->view('layout_recycle_view', $data);
	}


}