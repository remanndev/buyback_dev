<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Cms
 */
class Cms_lib
{
	private $error = array();

	function __construct()
	{
		$this->ci =& get_instance();

		$this->ci->load->config('tank_auth', TRUE);
		$this->ci->load->database();
		$this->ci->load->model('tank_auth/users');
		$this->ci->load->model('upload_model');
		$this->ci->load->model('cms_model');

		// 관리자 로그인 후에만 접속 가능, 그 외에는 메인 페이지로 이동.
		if (! $this->ci->tank_auth->is_admin()) {			// not logged in or activated
			redirect('/auth/login/'. url_code( current_url(), 'e'));
		}

	}


	function write_cms($arr) {

			$data = $arr; // parent_code,page_code,depth,order

			$order_post = $this->ci->input->post('order');
			$order_new_auto = $arr['order'];

			$order = (isset($order_post) && '' != $order_post) ? $order_post : $order_new_auto;

			// page_type
			$page_type = $this->ci->input->post('page_type', FALSE);
			// page_flag
			$boardpage = $this->ci->input->post('boardpage', FALSE);
			$htmlpage = $this->ci->input->post('htmlpage', FALSE);
			$ctntpage = $this->ci->input->post('ctntpage', FALSE);
			$landpage = $this->ci->input->post('landpage', FALSE);

			$page_flag = '';
			if($page_type == 'boardpage') { $page_flag = $boardpage; }
			elseif($page_type == 'htmlpage') { $page_flag = $htmlpage; }
			elseif($page_type == 'ctntpage') { $page_flag = $ctntpage; }
			elseif($page_type == 'landpage') { $page_flag = $landpage; }

			$data['page_type'] = $page_type;
			$data['page_flag'] = $page_flag;

			$data['menu_name'] = $this->ci->input->post('menu_name');
			//$data['page_url'] = $this->ci->input->post('page_url');



			$data['order'] = $order;
			$data['use_yn'] = $this->ci->input->post('use_yn');
			$data['folder'] = $this->ci->input->post('folder');
			$data['page_title'] = $this->ci->input->post('page_title');
			$data['meta_keyword'] = $this->ci->input->post('meta_keyword');
			$data['meta_description'] = $this->ci->input->post('meta_description');

			$data['og_title'] = $this->ci->input->post('og_title');
			$data['og_description'] = $this->ci->input->post('og_description');
			$data['og_image'] = $this->ci->input->post('og_image');
			$data['og_url'] = $this->ci->input->post('og_url');

			$data['layout_header'] = $this->ci->input->post('layout_header');
			$data['layout_footer'] = $this->ci->input->post('layout_footer');

			//$data['memo'] = $this->ci->input->post('memo');

			$data['reg_username'] = $this->ci->tank_auth->get_username();
			$data['reg_datetime'] = date('Y-m-d H:i:s');


			if (!is_null($res = $this->ci->cms_model->write_cms($data))) {
				return $res;
			}
			return NULL;
	}

	// 수정
	function edit_cms($pagecode=FALSE,$arr=array()) {

			$data = $arr;

			if (!is_null($res = $this->ci->cms_model->edit_cms($pagecode,$data))) {
				return $res;
			}
			return NULL;

	}


	// 삭제
	function delete_cms($pagecode=FALSE) {

			$data = array(
				'use_yn' => 'N',
				'del_username' => $this->ci->tank_auth->get_username(),
				'del_datetime' => date('Y-m-d H:i:s')
			);
			if (!is_null($res = $this->ci->cms_model->delete_cms($pagecode,$data))) {
				return $res;
			}
			return NULL;

	}



	// CMS 정보 가져오기
	function get_cms($url=FALSE) {
		
	}















	function contents_save() 
	{

		// # 에러 메시지 CSS
		$this->ci->form_validation->set_error_delimiters('<div class="err_color_red">','</div>');

		//this->ci->load->library('form_validation');

		// Set validation rules.
		$validation_rules = array(
			array('field' => 'page_title', 'label' => '페이지 제목', 'rules' => 'trim|required'),
			array('field' => 'use_yn', 'label' => '사용 여부', 'rules' => 'trim|required'),
			array('field' => 'page_content', 'label' => '페이지 내용', 'rules' => 'trim|required')
		);
		
		$this->ci->form_validation->set_rules($validation_rules);

		// Run the validation.
		if ($this->ci->form_validation->run())
		{

			// Get user id from session to use in the insert function as a primary key.
			$user_idx = $this->ci->tank_auth->get_user_id();
			$username = $this->ci->tank_auth->get_username();

			// 신규 등록인지 수정인지 여부
			$idx = $this->ci->input->post('idx',true);

			if(! $idx) :

					$data = array(
						'page_title' => $this->ci->input->post('page_title'),
						'page_seo_url' => '',
						'use_yn' => $this->ci->input->post('use_yn'),
						'page_content' => $this->ci->input->post('page_content'),
						'reg_username' => $this->ci->tank_auth->get_username(),
						'reg_datetime' => TIME_YMDHIS
					);

					if (!is_null($res = $this->ci->cms_model->write_contents($data))) {
						return $res;

						//sess_message('게시판 정보가 수정되었습니다.');
						//redirect(base_url().'admin/contents/page/form/'.$res['idx']);
					}
					return NULL;



			else :

					$data = array(
						'page_title' => $this->ci->input->post('page_title'),
						'page_seo_url' => '',
						'use_yn' => $this->ci->input->post('use_yn'),
						'page_content' => $this->ci->input->post('page_content'),
					);

					if (!is_null($res = $this->ci->cms_model->edit_contents($idx,$data))) {
						return $res;

						//redirect(base_url().'admin/contents/page/form/'.$idx);
					}
					return NULL;
			endif;
					
			redirect('admin/contents/page/form/'.$idx);
		}
		else
		{		
			// Set validation errors.
			$this->ci->data['message'] = validation_errors('<p class="error_msg">', '</p>');
			
			return FALSE;
		}

	}


	// 삭제
	function contents_delete($idx=FALSE) {

			$data = array(
				'use_yn' => 'N',
				'del_username' => $this->ci->tank_auth->get_username(),
				'del_datetime' => date('Y-m-d H:i:s')
			);
			if (!is_null($res = $this->ci->cms_model->del_contents($idx,$data))) {
				return $res;
			}
			return NULL;

	}











	function landing_save() 
	{

		// # 에러 메시지 CSS
		$this->ci->form_validation->set_error_delimiters('<div class="err_color_red">','</div>');

		//this->ci->load->library('form_validation');

		// Set validation rules.
		$validation_rules = array(
			array('field' => 'title', 'label' => '페이지 제목', 'rules' => 'trim|required'),
			array('field' => 'code', 'label' => '페이지 코드', 'rules' => 'trim|required'),
			array('field' => 'use_yn', 'label' => '사용 여부', 'rules' => 'trim|required'),
			array('field' => 'sdate', 'label' => '시작일자', 'rules' => 'trim|required'),
			array('field' => 'edate', 'label' => '종료일자', 'rules' => 'trim|required'),
			array('field' => 'content_top', 'label' => '상단 내용', 'rules' => 'trim'),

			array('field' => 'fld_nm_1', 'label' => '접수항목', 'rules' => 'trim'),
			array('field' => 'fld_nm_2', 'label' => '접수항목', 'rules' => 'trim'),
			array('field' => 'fld_nm_3', 'label' => '접수항목', 'rules' => 'trim'),
			array('field' => 'fld_nm_4', 'label' => '접수항목', 'rules' => 'trim'),
			array('field' => 'fld_nm_5', 'label' => '접수항목', 'rules' => 'trim'),
			array('field' => 'fld_nm_6', 'label' => '접수항목', 'rules' => 'trim'),
			array('field' => 'fld_nm_7', 'label' => '접수항목', 'rules' => 'trim'),
			array('field' => 'fld_nm_8', 'label' => '접수항목', 'rules' => 'trim'),
			array('field' => 'fld_nm_9', 'label' => '접수항목', 'rules' => 'trim'),
			array('field' => 'fld_nm_10', 'label' => '접수항목', 'rules' => 'trim'),

			array('field' => 'fld_chk_1', 'label' => '접수항목 필수 체크 여부', 'rules' => 'trim'),
			array('field' => 'fld_chk_2', 'label' => '접수항목 필수 체크 여부', 'rules' => 'trim'),
			array('field' => 'fld_chk_3', 'label' => '접수항목 필수 체크 여부', 'rules' => 'trim'),
			array('field' => 'fld_chk_4', 'label' => '접수항목 필수 체크 여부', 'rules' => 'trim'),
			array('field' => 'fld_chk_5', 'label' => '접수항목 필수 체크 여부', 'rules' => 'trim'),
			array('field' => 'fld_chk_6', 'label' => '접수항목 필수 체크 여부', 'rules' => 'trim'),
			array('field' => 'fld_chk_7', 'label' => '접수항목 필수 체크 여부', 'rules' => 'trim'),
			array('field' => 'fld_chk_8', 'label' => '접수항목 필수 체크 여부', 'rules' => 'trim'),
			array('field' => 'fld_chk_9', 'label' => '접수항목 필수 체크 여부', 'rules' => 'trim'),
			array('field' => 'fld_chk_10', 'label' => '접수항목 필수 체크 여부', 'rules' => 'trim'),

			array('field' => 'fld_type_1', 'label' => '접수항목 타입', 'rules' => 'trim'),
			array('field' => 'fld_type_2', 'label' => '접수항목 타입', 'rules' => 'trim'),
			array('field' => 'fld_type_3', 'label' => '접수항목 타입', 'rules' => 'trim'),
			array('field' => 'fld_type_4', 'label' => '접수항목 타입', 'rules' => 'trim'),
			array('field' => 'fld_type_5', 'label' => '접수항목 타입', 'rules' => 'trim'),
			array('field' => 'fld_type_6', 'label' => '접수항목 타입', 'rules' => 'trim'),
			array('field' => 'fld_type_7', 'label' => '접수항목 타입', 'rules' => 'trim'),
			array('field' => 'fld_type_8', 'label' => '접수항목 타입', 'rules' => 'trim'),
			array('field' => 'fld_type_9', 'label' => '접수항목 타입', 'rules' => 'trim'),
			array('field' => 'fld_type_10', 'label' => '접수항목 타입', 'rules' => 'trim'),

			array('field' => 'content_bottom', 'label' => '하단 내용', 'rules' => 'trim'),
			array('field' => 'agree_term', 'label' => '개인정보 수집 및 이용안내', 'rules' => 'trim'),


			array('field' => 'file_cnt', 'label' => '파일 첨부 수량', 'rules' => 'trim'),
			array('field' => 'file_ttl_1', 'label' => '파일 제목 1', 'rules' => 'trim'),
			array('field' => 'file_ttl_2', 'label' => '파일 제목 2', 'rules' => 'trim'),
			array('field' => 'file_ttl_3', 'label' => '파일 제목 3', 'rules' => 'trim'),
			array('field' => 'file_ttl_4', 'label' => '파일 제목 4', 'rules' => 'trim'),
			array('field' => 'file_ttl_5', 'label' => '파일 제목 5', 'rules' => 'trim'),
			array('field' => 'file_desc_1', 'label' => '파일 설명 1', 'rules' => 'trim'),
			array('field' => 'file_desc_2', 'label' => '파일 설명 2', 'rules' => 'trim'),
			array('field' => 'file_desc_3', 'label' => '파일 설명 3', 'rules' => 'trim'),
			array('field' => 'file_desc_4', 'label' => '파일 설명 4', 'rules' => 'trim'),
			array('field' => 'file_desc_5', 'label' => '파일 설명 5', 'rules' => 'trim'),

		);
		
		$this->ci->form_validation->set_rules($validation_rules);

		// Run the validation.
		if ($this->ci->form_validation->run())
		{

			// Get user id from session to use in the insert function as a primary key.
			$user_idx = $this->ci->tank_auth->get_user_id();
			$username = $this->ci->tank_auth->get_username();

			// 신규 등록인지 수정인지 여부
			$idx = $this->ci->input->post('idx',true);

			$fld_nm_1 = $this->ci->input->post('fld_nm_1',false);
			$fld_nm_2 = $this->ci->input->post('fld_nm_2',false);
			$fld_nm_3 = $this->ci->input->post('fld_nm_3',false);
			$fld_nm_4 = $this->ci->input->post('fld_nm_4',false);
			$fld_nm_5 = $this->ci->input->post('fld_nm_5',false);
			$fld_nm_6 = $this->ci->input->post('fld_nm_6',false);
			$fld_nm_7 = $this->ci->input->post('fld_nm_7',false);
			$fld_nm_8 = $this->ci->input->post('fld_nm_8',false);
			$fld_nm_9 = $this->ci->input->post('fld_nm_9',false);
			$fld_nm_10 = $this->ci->input->post('fld_nm_10',false);



			if(! $idx) :

					$data = array(
						'title' => $this->ci->input->post('title'),
						'code' => $this->ci->input->post('code'),
						//'page_seo_url' => '',
						'use_yn' => $this->ci->input->post('use_yn'),
						'sdate' => $this->ci->input->post('sdate'),
						'edate' => $this->ci->input->post('edate'),
						'content_top' => $this->ci->input->post('content_top'),

						'fld_nm_1' => $fld_nm_1,
						'fld_nm_2' => $fld_nm_2,
						'fld_nm_3' => $fld_nm_3,
						'fld_nm_4' => $fld_nm_4,
						'fld_nm_5' => $fld_nm_5,
						'fld_nm_6' => $fld_nm_6,
						'fld_nm_7' => $fld_nm_7,
						'fld_nm_8' => $fld_nm_8,
						'fld_nm_9' => $fld_nm_9,
						'fld_nm_10' => $fld_nm_10,

						'fld_chk_1' => ($fld_nm_1) ? $this->ci->input->post('fld_chk_1') : NULL,
						'fld_chk_2' => ($fld_nm_2) ? $this->ci->input->post('fld_chk_2') : NULL,
						'fld_chk_3' => ($fld_nm_3) ? $this->ci->input->post('fld_chk_3') : NULL,
						'fld_chk_4' => ($fld_nm_4) ? $this->ci->input->post('fld_chk_4') : NULL,
						'fld_chk_5' => ($fld_nm_5) ? $this->ci->input->post('fld_chk_5') : NULL,
						'fld_chk_6' => ($fld_nm_6) ? $this->ci->input->post('fld_chk_6') : NULL,
						'fld_chk_7' => ($fld_nm_7) ? $this->ci->input->post('fld_chk_7') : NULL,
						'fld_chk_8' => ($fld_nm_8) ? $this->ci->input->post('fld_chk_8') : NULL,
						'fld_chk_9' => ($fld_nm_9) ? $this->ci->input->post('fld_chk_9') : NULL,
						'fld_chk_10' => ($fld_nm_10) ? $this->ci->input->post('fld_chk_10') : NULL,

						'fld_type_1' => ($fld_nm_1) ? $this->ci->input->post('fld_type_1') : NULL,
						'fld_type_2' => ($fld_nm_2) ? $this->ci->input->post('fld_type_2') : NULL,
						'fld_type_3' => ($fld_nm_3) ? $this->ci->input->post('fld_type_3') : NULL,
						'fld_type_4' => ($fld_nm_4) ? $this->ci->input->post('fld_type_4') : NULL,
						'fld_type_5' => ($fld_nm_5) ? $this->ci->input->post('fld_type_5') : NULL,
						'fld_type_6' => ($fld_nm_6) ? $this->ci->input->post('fld_type_6') : NULL,
						'fld_type_7' => ($fld_nm_7) ? $this->ci->input->post('fld_type_7') : NULL,
						'fld_type_8' => ($fld_nm_8) ? $this->ci->input->post('fld_type_8') : NULL,
						'fld_type_9' => ($fld_nm_9) ? $this->ci->input->post('fld_type_9') : NULL,
						'fld_type_10' => ($fld_nm_10) ? $this->ci->input->post('fld_type_10') : NULL,

						'fld_desc_1' => ($fld_nm_1) ? $this->ci->input->post('fld_desc_1') : NULL,
						'fld_desc_2' => ($fld_nm_2) ? $this->ci->input->post('fld_desc_2') : NULL,
						'fld_desc_3' => ($fld_nm_3) ? $this->ci->input->post('fld_desc_3') : NULL,
						'fld_desc_4' => ($fld_nm_4) ? $this->ci->input->post('fld_desc_4') : NULL,
						'fld_desc_5' => ($fld_nm_5) ? $this->ci->input->post('fld_desc_5') : NULL,
						'fld_desc_6' => ($fld_nm_6) ? $this->ci->input->post('fld_desc_6') : NULL,
						'fld_desc_7' => ($fld_nm_7) ? $this->ci->input->post('fld_desc_7') : NULL,
						'fld_desc_8' => ($fld_nm_8) ? $this->ci->input->post('fld_desc_8') : NULL,
						'fld_desc_9' => ($fld_nm_9) ? $this->ci->input->post('fld_desc_9') : NULL,
						'fld_desc_10' => ($fld_nm_10) ? $this->ci->input->post('fld_desc_10') : NULL,

						'file_cnt' => $this->ci->input->post('file_cnt'),

						'file_ttl_1' => $this->ci->input->post('file_ttl_1'),
						'file_ttl_2' => $this->ci->input->post('file_ttl_2'),
						'file_ttl_3' => $this->ci->input->post('file_ttl_3'),
						'file_ttl_4' => $this->ci->input->post('file_ttl_4'),
						'file_ttl_5' => $this->ci->input->post('file_ttl_5'),

						'file_desc_1' => $this->ci->input->post('file_desc_1'),
						'file_desc_2' => $this->ci->input->post('file_desc_2'),
						'file_desc_3' => $this->ci->input->post('file_desc_3'),
						'file_desc_4' => $this->ci->input->post('file_desc_4'),
						'file_desc_5' => $this->ci->input->post('file_desc_5'),

						'content_bottom' => $this->ci->input->post('content_bottom'),
						'agree_term' => $this->ci->input->post('agree_term'),
						'reg_username' => $this->ci->tank_auth->get_username(),
						'reg_datetime' => TIME_YMDHIS
					);

					if (!is_null($res = $this->ci->cms_model->write_landing($data))) {
						//return $res;

						//sess_message('게시판 정보가 수정되었습니다.');
						redirect(base_url().'admin/contents/landing/form/'.$res['idx']);

						//alert('게시판이 삭제되었습니다.','admin/board/lists');

					}
					return NULL;



			else :

					$data = array(
						'title' => $this->ci->input->post('title'),
						'code' => $this->ci->input->post('code'),
						//'page_seo_url' => '',
						'use_yn' => $this->ci->input->post('use_yn'),
						'sdate' => $this->ci->input->post('sdate'),
						'edate' => $this->ci->input->post('edate'),
						'content_top' => $this->ci->input->post('content_top'),

						'fld_nm_1' => $fld_nm_1,
						'fld_nm_2' => $fld_nm_2,
						'fld_nm_3' => $fld_nm_3,
						'fld_nm_4' => $fld_nm_4,
						'fld_nm_5' => $fld_nm_5,
						'fld_nm_6' => $fld_nm_6,
						'fld_nm_7' => $fld_nm_7,
						'fld_nm_8' => $fld_nm_8,
						'fld_nm_9' => $fld_nm_9,
						'fld_nm_10' => $fld_nm_10,

						'fld_chk_1' => ($fld_nm_1) ? $this->ci->input->post('fld_chk_1') : NULL,
						'fld_chk_2' => ($fld_nm_2) ? $this->ci->input->post('fld_chk_2') : NULL,
						'fld_chk_3' => ($fld_nm_3) ? $this->ci->input->post('fld_chk_3') : NULL,
						'fld_chk_4' => ($fld_nm_4) ? $this->ci->input->post('fld_chk_4') : NULL,
						'fld_chk_5' => ($fld_nm_5) ? $this->ci->input->post('fld_chk_5') : NULL,
						'fld_chk_6' => ($fld_nm_6) ? $this->ci->input->post('fld_chk_6') : NULL,
						'fld_chk_7' => ($fld_nm_7) ? $this->ci->input->post('fld_chk_7') : NULL,
						'fld_chk_8' => ($fld_nm_8) ? $this->ci->input->post('fld_chk_8') : NULL,
						'fld_chk_9' => ($fld_nm_9) ? $this->ci->input->post('fld_chk_9') : NULL,
						'fld_chk_10' => ($fld_nm_10) ? $this->ci->input->post('fld_chk_10') : NULL,

						'fld_type_1' => ($fld_nm_1) ? $this->ci->input->post('fld_type_1') : NULL,
						'fld_type_2' => ($fld_nm_2) ? $this->ci->input->post('fld_type_2') : NULL,
						'fld_type_3' => ($fld_nm_3) ? $this->ci->input->post('fld_type_3') : NULL,
						'fld_type_4' => ($fld_nm_4) ? $this->ci->input->post('fld_type_4') : NULL,
						'fld_type_5' => ($fld_nm_5) ? $this->ci->input->post('fld_type_5') : NULL,
						'fld_type_6' => ($fld_nm_6) ? $this->ci->input->post('fld_type_6') : NULL,
						'fld_type_7' => ($fld_nm_7) ? $this->ci->input->post('fld_type_7') : NULL,
						'fld_type_8' => ($fld_nm_8) ? $this->ci->input->post('fld_type_8') : NULL,
						'fld_type_9' => ($fld_nm_9) ? $this->ci->input->post('fld_type_9') : NULL,
						'fld_type_10' => ($fld_nm_10) ? $this->ci->input->post('fld_type_10') : NULL,

						'fld_desc_1' => ($fld_nm_1) ? $this->ci->input->post('fld_desc_1') : NULL,
						'fld_desc_2' => ($fld_nm_2) ? $this->ci->input->post('fld_desc_2') : NULL,
						'fld_desc_3' => ($fld_nm_3) ? $this->ci->input->post('fld_desc_3') : NULL,
						'fld_desc_4' => ($fld_nm_4) ? $this->ci->input->post('fld_desc_4') : NULL,
						'fld_desc_5' => ($fld_nm_5) ? $this->ci->input->post('fld_desc_5') : NULL,
						'fld_desc_6' => ($fld_nm_6) ? $this->ci->input->post('fld_desc_6') : NULL,
						'fld_desc_7' => ($fld_nm_7) ? $this->ci->input->post('fld_desc_7') : NULL,
						'fld_desc_8' => ($fld_nm_8) ? $this->ci->input->post('fld_desc_8') : NULL,
						'fld_desc_9' => ($fld_nm_9) ? $this->ci->input->post('fld_desc_9') : NULL,
						'fld_desc_10' => ($fld_nm_10) ? $this->ci->input->post('fld_desc_10') : NULL,

						'file_cnt' => $this->ci->input->post('file_cnt'),

						'file_ttl_1' => $this->ci->input->post('file_ttl_1'),
						'file_ttl_2' => $this->ci->input->post('file_ttl_2'),
						'file_ttl_3' => $this->ci->input->post('file_ttl_3'),
						'file_ttl_4' => $this->ci->input->post('file_ttl_4'),
						'file_ttl_5' => $this->ci->input->post('file_ttl_5'),

						'file_desc_1' => $this->ci->input->post('file_desc_1'),
						'file_desc_2' => $this->ci->input->post('file_desc_2'),
						'file_desc_3' => $this->ci->input->post('file_desc_3'),
						'file_desc_4' => $this->ci->input->post('file_desc_4'),
						'file_desc_5' => $this->ci->input->post('file_desc_5'),

						'content_bottom' => $this->ci->input->post('content_bottom'),
						'agree_term' => $this->ci->input->post('agree_term'),
						'edit_username' => $this->ci->input->post('edit_username'),
						'edit_datetime' => $this->ci->input->post('edit_datetime'),
					);

					if (!is_null($res = $this->ci->cms_model->edit_landing($idx,$data))) {
						//return $res;

						//echo $this->ci->db->last_query();
						//exit;

						redirect(base_url().'admin/contents/landing/form/'.$idx);

					}
					return NULL;
			endif;
					
			redirect('admin/contents/page/form/'.$idx);
		}
		else
		{		
			// Set validation errors.
			$this->ci->data['message'] = validation_errors('<p class="error_msg">', '</p>');
			
			return FALSE;
		}

	}


	// 랜딩 페이지를 삭제
	function landing_delete($idx=FALSE) {

			$data = array(
				'use_yn' => 'N',
				'del_username' => $this->ci->tank_auth->get_username(),
				'del_datetime' => date('Y-m-d H:i:s')
			);
			if (!is_null($res = $this->ci->cms_model->del_landing($idx,$data))) {
				return $res;
			}
			return NULL;

	}



	// 개별 신청 내역을 삭제
	function landing_req_code_delete($idx=FALSE) {

			$data = array(
				'del_username' => $this->ci->tank_auth->get_username(),
				'del_datetime' => date('Y-m-d H:i:s')
			);
			if (!is_null($res = $this->ci->cms_model->del_landing_req_code($idx,$data))) {
				return $res;
			}
			return NULL;

	}











}