<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Product
 */
class Product_lib
{
	private $error = array();

	function __construct()
	{
		$this->ci =& get_instance();

		// $this->ci->load->config('tank_auth', TRUE); // autoload
		$this->ci->load->database();
		$this->ci->load->model('tank_auth/users');
		$this->ci->load->model('product_model');
		$this->ci->load->model('upload_model');

	}


	function form($idx=FALSE)
	{


		// 관리자 로그인 후에만 접속 가능, 그 외에는 메인 페이지로 이동.
			if (! $this->ci->tank_auth->is_admin()) {			// not logged in or activated
				redirect('/auth/login/'. url_code( current_url(), 'e'));
			}


		// 상품 정보
			$cate1 = $this->ci->input->post('cate1');
			$cate2 = $this->ci->input->post('cate2');
			$cate3 = $this->ci->input->post('cate3');
			$cate4 = $this->ci->input->post('cate4');

			$depth = 1;
			//$depth = ('' != $cate1) ? 1 : 1;
			$depth = ('' != $cate2 && 0 !== $cate2) ? 2 : $depth;
			$depth = ('' != $cate3 && 0 !== $cate3) ? 3 : $depth;
			$depth = ('' != $cate4 && 0 !== $cate4) ? 4 : $depth;

			$editor_pick = $this->ci->input->post('editor_pick');
			if( $editor_pick == '' ) {
				$editor_pick = NULL;
			}
			$editor_recommand = $this->ci->input->post('editor_recommand');
			if( $editor_recommand == '' ) {
				$editor_recommand = NULL;
			}



			$data = array(
				'cate_idx'   => $this->ci->input->post('cate_idx'),
				/*
				'cate1'   => $this->ci->input->post('cate1'),
				'cate2'   => $this->ci->input->post('cate2'),
				'cate3'   => $this->ci->input->post('cate3'),
				'cate4'   => $this->ci->input->post('cate4'),
				*/
				'depth'   => $depth,
				'cate1'   => $cate1,
				'cate2'   => $cate2,
				'cate3'   => $cate3,
				'cate4'   => $cate4,
				'prd_name'       => $this->ci->input->post('prd_name'),
				'prd_name_sub'	=> $this->ci->input->post('prd_name_sub'),
				'prd_spec_simple'	=> $this->ci->input->post('prd_spec_simple'),
				'prd_hashtag'	=> $this->ci->input->post('prd_hashtag'),
				'prd_pixel'	=> $this->ci->input->post('prd_pixel'),
				'prd_price'	=> $this->ci->input->post('prd_price'),
				'ord_price'	=> $this->ci->input->post('ord_price'),

				'editor_pick'	=> $editor_pick,
				'editor_recommand'	=> $editor_recommand,

				'editor_trend_main'	=> $this->ci->input->post('editor_trend_main'),
				'jodal_direct_link'	=> $this->ci->input->post('jodal_direct_link'),

				'prd_info_detail'	=> $this->ci->input->post('prd_info_detail'),
				'prd_info_spec'	=> $this->ci->input->post('prd_info_spec'),
				'prd_info_add'	=> $this->ci->input->post('prd_info_add')
			);

			if (!is_null($res = $this->ci->product_model->form_product($idx,$data))) {
				return $res;
			}

	}








}