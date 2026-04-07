<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Item
 */
class Item_lib
{
	private $error = array();

	function __construct()
	{
		$this->ci =& get_instance();

		// $this->ci->load->config('tank_auth', TRUE); // autoload
		$this->ci->load->database();
		$this->ci->load->model('tank_auth/users');
		$this->ci->load->model('item_model');
		$this->ci->load->model('upload_model');

		$this->ci->username = $this->ci->tank_auth->get_username();
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
			$depth = ('' != $cate2 && 0 !== $cate2) ? 2 : $depth;
			$depth = ('' != $cate3 && 0 !== $cate3) ? 3 : $depth;
			$depth = ('' != $cate4 && 0 !== $cate4) ? 4 : $depth;





/*

			$this->form_validation->set_rules('cate_idx', '카테고리', 'trim|required|xss_clean');
			$this->form_validation->set_rules('itm_code', '제품 코드', 'trim|required|xss_clean');
			$this->form_validation->set_rules('itm_title', '제품명', 'trim|required|xss_clean');
			$this->form_validation->set_rules('itm_subtitle', '제품명 하단 설명', 'trim|xss_clean');
			$this->form_validation->set_rules('itm_order', '제품 정렬순서', 'trim|required|xss_clean');

			$this->form_validation->set_rules('itm_maker', '제조사', 'trim|xss_clean');
			$this->form_validation->set_rules('itm_origin', '원산지', 'trim|xss_clean');
			$this->form_validation->set_rules('itm_brand', '브랜드', 'trim|xss_clean');
			$this->form_validation->set_rules('itm_model', '모델', 'trim|xss_clean');

			$this->form_validation->set_rules('itm_type_hit', '히트', 'trim|xss_clean');
			$this->form_validation->set_rules('itm_type_pick', '추천', 'trim|xss_clean');
			$this->form_validation->set_rules('itm_type_new', '신상품', 'trim|xss_clean');
			$this->form_validation->set_rules('itm_type_best', '베스트', 'trim|xss_clean');
			$this->form_validation->set_rules('itm_type_dc', '할인', 'trim|xss_clean');

			$this->form_validation->set_rules('itm_desc', '상세 정보', 'trim');
			$this->form_validation->set_rules('itm_desc_mobile', '상세 정보 - 모바일', 'trim');
			$this->form_validation->set_rules('itm_spec', '주요 사양', 'trim');
			$this->form_validation->set_rules('itm_spec_mobile', '주요 사양 - 모바일', 'trim');
			$this->form_validation->set_rules('itm_addinfo', '추가 정보', 'trim');
			$this->form_validation->set_rules('itm_addinfo_mobile', '추가 정보 - 모바일', 'trim');


*/



			$data = array(
				'cate_idx'   => $this->ci->input->post('cate_idx'),
				'depth'   => $depth,
				'cate1'   => $cate1,
				'cate2'   => $cate2,
				'cate3'   => $cate3,
				'cate4'   => $cate4,
				'itm_title'    => $this->ci->input->post('itm_title'),
				'itm_subtitle' => $this->ci->input->post('itm_subtitle'),
				'itm_order'    => $this->ci->input->post('itm_order'),

				'itm_maker'    => $this->ci->input->post('itm_maker'),
				'itm_origin'   => $this->ci->input->post('itm_origin'),
				'itm_brand'    => $this->ci->input->post('itm_brand'),
				'itm_model'    => $this->ci->input->post('itm_model'),
				'itm_price'    => $this->ci->input->post('itm_price'),

				'itm_main_dsp'	=> $this->ci->input->post('itm_main_dsp'),

				'itm_type_hit'	=> $this->ci->input->post('itm_type_hit'),
				'itm_type_pick'	=> $this->ci->input->post('itm_type_pick'),
				'itm_type_new'	=> $this->ci->input->post('itm_type_new'),
				'itm_type_best'	=> $this->ci->input->post('itm_type_best'),
				'itm_type_dc'	=> $this->ci->input->post('itm_type_dc'),

				'itm_desc'	=> $this->ci->input->post('itm_desc'),
				'itm_desc_mobile'	=> $this->ci->input->post('itm_desc_mobile'),
				'itm_spec'	=> $this->ci->input->post('itm_spec'),
				'itm_spec_mobile'	=> $this->ci->input->post('itm_spec_mobile'),
				'itm_addinfo'	=> $this->ci->input->post('itm_addinfo'),
				'itm_addinfo_mobile'	=> $this->ci->input->post('itm_addinfo_mobile'),
			);

			if($idx) {
				// 수정
				$data['mod_username'] = $this->username;
				$data['mod_datetime'] = TIME_YMDHIS;
			}
			else {
				// 신규
				$data['itm_code'] = $this->ci->input->post('itm_code'); // 제품코드
				$data['reg_username'] = $this->username;
				$data['reg_datetime'] = TIME_YMDHIS;
			}

			if (!is_null($res = $this->ci->item_model->form_save($data,$idx))) {// SIUD
				return $res;
			}

	}








}