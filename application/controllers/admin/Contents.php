<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Contents extends CI_Controller
{
	function __construct()
	{
		parent::__construct();

		/*
		$autoload['libraries'] = array('database', 'session','user_agent','basic_lib'); // ,'tank_auth','mobiledetect'
		$autoload['helper'] = array('url', 'file', 'common');
		*/

		$this->load->helper(array('form', 'load','security'));
		$this->load->library('form_validation');
		$this->load->library('tank_auth');
		$this->load->library('upload_lib');
		$this->load->library('pagination');
		$this->load->library('querystring');
		$this->load->library('cms_lib');
		$this->load->model('upload_model');
		$this->lang->load('tank_auth');

		$this->username = $this->tank_auth->get_username();
		$this->arr_seg = $this->uri->segment_array();


		// 관리자 로그인 후에만 접속 가능, 그 외에는 메인 페이지로 이동.
		if (! $this->tank_auth->is_admin()) {			// not logged in or activated
			$this->tank_auth->logout();
			redirect(base_url().'auth/login/'. url_code( current_url(), 'e'));
		}



		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		// 생성된 컨텐츠 페이지 목록 가져오기
		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		$sql_select = '*';
		$sql_from = 'mng_contents';
		$sql_where = array('del_datetime' => NULL,'use_yn'=>'Y');
		$sql_group_by = FALSE;
		$sql_order_by = 'idx DESC';
		// 조인
		$sql_join_tbl = FALSE;
		$sql_join_on = FALSE;
		$sql_join_option = 'LEFT OUTER';

		// 검색 상관없는 전체 수
		$this->total_count = $this->basic_model->get_common_count($sql_from,$sql_where);
		$arr = array(
				'sql_select'     => $sql_select,
				'sql_from'       => $sql_from,
				'sql_join_tbl'       => $sql_join_tbl,
				'sql_join_on'        => $sql_join_on,
				'sql_join_option'    => $sql_join_option,
				'sql_where'      => $sql_where, //array('PIDX' => $pidx),
				'sql_group_by'   => $sql_group_by,
				'sql_order_by'   => $sql_order_by,  // $order_field.' DESC, IDX DESC',
		);
		$this->contents_result = $this->basic_model->arr_get_result($arr);
		//print_r($this->contents_result);


		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		// 생성된 랜딩 페이지 목록 가져오기
		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		$sql_select = '*';
		$sql_from = 'mng_landing';
		$sql_where = array('del_datetime' => NULL);
		$sql_group_by = FALSE;
		$sql_order_by = 'idx DESC';
		// 조인
		$sql_join_tbl = FALSE;
		$sql_join_on = FALSE;
		$sql_join_option = 'LEFT OUTER';

		// 검색 상관없는 전체 수
		$this->total_count = $this->basic_model->get_common_count($sql_from,$sql_where);
		$arr = array(
				'sql_select'     => $sql_select,
				'sql_from'       => $sql_from,
				'sql_join_tbl'       => $sql_join_tbl,
				'sql_join_on'        => $sql_join_on,
				'sql_join_option'    => $sql_join_option,
				'sql_where'      => $sql_where, //array('PIDX' => $pidx),
				'sql_group_by'   => $sql_group_by,
				'sql_order_by'   => $sql_order_by,  // $order_field.' DESC, IDX DESC',
		);
		$this->landing_result = $this->basic_model->arr_get_result($arr);
		//print_r($this->landing_result);




		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		// 제품 카테고리 목록 가져오기
		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		// 1차 카테고리
			$sql_arr = array(
					'sql_select'     => '*',
					'sql_from'       => 'item_category',
					'sql_where'      => array('depth'=>1,'disuse'=>NULL),
					'sql_order_by'   => 'order ASC',
			);
			$this->item_cate1_result = $this->basic_model->arr_get_result($sql_arr);




        //<!-- redactor.css -->
		load_css('<link rel="stylesheet" type="text/css" href="'. ASSETS_DIR .'/lib/editor/redactor-3-5-2/redactor.min.css" />');
    	//<!-- redactor.js -->
		load_js('<script src="'. ASSETS_DIR .'/lib/editor/redactor-3-5-2/redactor.min.js"></script>');
        //<!-- plugin js -->
		load_js('<script src="'. ASSETS_DIR .'/lib/editor/redactor-3-5-2/plugins/fontsize/fontsize.js"></script>');
		load_js('<script src="'. ASSETS_DIR .'/lib/editor/redactor-3-5-2/plugins/fontcolor/fontcolor.js"></script>');
		load_js('<script src="'. ASSETS_DIR .'/lib/editor/redactor-3-5-2/plugins/fontfamily/fontfamily.js"></script>');
		load_js('<script src="'. ASSETS_DIR .'/lib/editor/redactor-3-5-2/plugins/filemanager/filemanager.js"></script>');
		load_js('<script src="'. ASSETS_DIR .'/lib/editor/redactor-3-5-2/plugins/imagemanager/imagemanager.js"></script>');
		load_js('<script src="'. ASSETS_DIR .'/lib/editor/redactor-3-5-2/plugins/table/table.js"></script>');
		load_js('<script src="'. ASSETS_DIR .'/lib/editor/redactor-3-5-2/plugins/video/video.js"></script>');
		load_js('<script src="'. ASSETS_DIR .'/lib/editor/redactor-3-5-2/plugins/alignment/alignment.js"></script>');

		load_css('<link rel="stylesheet" type="text/css" href="'. ASSETS_DIR .'/lib/editor/redactor-3-5-2/plugins/inlinestyle/inlinestyle.css" />');
		load_js('<script src="'. ASSETS_DIR .'/lib/editor/redactor-3-5-2/plugins/inlinestyle/inlinestyle.js"></script>');

		load_js('<script src="'. ASSETS_DIR .'/lib/editor/redactor-3-5-2/plugins/specialchars/specialchars.js"></script>');
		load_js('<script src="'. ASSETS_DIR .'/lib/editor/redactor-3-5-2/plugins/textdirection/textdirection.js"></script>');
		load_js('<script src="'. ASSETS_DIR .'/lib/editor/redactor-3-5-2/plugins/widget/widget.js"></script>');
		load_js('<script src="'. ASSETS_DIR .'/lib/editor/redactor-3-5-2/plugins/fullscreen/fullscreen.js"></script>');

		//<!-- connect the languages file -->
		load_js('<script src="'. ASSETS_DIR .'/lib/editor/redactor-3-5-2/langs/ko.js?v='.time().'"></script>');


	}

	function index()
	{
		redirect(base_url().'admin/contents/cms/form');
	}

	function main() {

		redirect(base_url().'admin/contents/cms/form');	

		/*
		$data['arr_seg'] = $this->arr_seg;
		$data['viewPage'] = 'admin/design_main_view';
		//$this->load->view('admin/_layout_view', $data);
		$this->load->view('admin/layout_view', $data);
		*/
	}



	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	// CMS 관리
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	function cms($step=FALSE) 
	{
		if(! $step) {
			$step = 'form';
			redirect(base_url().'admin/contents/cms/'.$step);
		}
		switch ($step) {
			case 'form':
					// cms 목록 및 상세
					$page_code = isset($this->arr_seg[5]) ? $this->arr_seg[5] : '';  // 페이지코드
					$command = isset($this->arr_seg[6]) ? $this->arr_seg[6] : '';  // main/sub, 메인/하위 메뉴 추가, 없으면 수정
					$this->_cms_form($page_code,$command);
			break;
			default:
				alert('잘못된 접근입니다.', '/admin/contents/cms/form');
			break;
		}
	}



	private function _make_nav_file() {


					$page_code = isset($this->arr_seg[5]) ? $this->arr_seg[5] : '';  // 페이지코드

					// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
					// 메뉴 html 파일 생성/수정
					// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
					$this->load->library('ftp');
					$this->load->helper('file');

					//$this->ftp->chmod(VIEWPATH, 0777);


					/*
						$data = 'Some file data : ';
						$data .= time();
						echo VIEWPATH;
						echo '<br />';
						echo VIEWPATH.'layout_nav_desk_view.php';
						echo '<br />';
						echo $data.'<<<br />';

						

						if ( ! write_file(VIEWPATH.'layout_nav_view.php', $data))
						{
								echo 'Unable to write the file';
						}
						else
						{
								echo 'File written!';
						}
					*/






					// cms 데이터 가져오기

						$arr_d1 = array('sql_select' => '*','sql_from' => 'mng_cms','sql_where' => array('depth'=>1,'use_yn'=>'Y','del_datetime' => NULL),'sql_order_by' => 'depth ASC,order ASC');
						$cms_result_d1 = $this->basic_model->arr_get_result($arr_d1);

						$nav_desk_main = '';
						$nav_desk_main .= '<ul class="row" style="">';

						foreach($cms_result_d1['qry'] as $k1 => $nav1) {
							$a_target = ($nav1->page_type == 'link') ? ' target="blank" ' : '';

							$nav_desk_main .= '  <li class="col-md-auto" style="margin:0;padding:0;">';
							$nav_desk_main .= '    <dl class="" style="margin:0;">';
							$nav_desk_main .= '      <dt class="desknav_main nav_'. $nav1->first_code .'" data-pagecode="'. $nav1->page_code .'">';
							$nav_desk_main .= '        <a href="'. $nav1->page_url .'" '.$a_target.'>'. $nav1->menu_name .'<span class="sr-only">'. $nav1->menu_name .'</span></a>';
							$nav_desk_main .= '      </dt>';
							$nav_desk_main .= '    </dl>';
							$nav_desk_main .= '  </li>';
						}
						$nav_desk_main .= '</ul>';


						if ( ! write_file(VIEWPATH.'layout_nav_desk_main_view.php', $nav_desk_main))
						{
								alert('Unable to write the file : layout_nav_desk_main_view.php');
								//echo 'Unable to write the file : layout_nav_desk_main_view.php';
						}
						else
						{
								//alert('File written! : layout_nav_desk_main_view.php');
								//echo 'File written! : layout_nav_desk_main_view.php';
						}




						/*
						echo VIEWPATH.'layout_nav_desk_main_view.php';
						echo '<br />';

						echo $nav_desk_main;
						exit;
						*/


						$nav_desk_sub = '';
						foreach($cms_result_d1['qry'] as $k1 => $nav1) {
							

							$nav_desk_sub .= '<div id="sub_'. $nav1->page_code .'" class="o_subnav" style="display: none;">';
							$nav_desk_sub .= '  <div class="header_wrap">';
							$nav_desk_sub .= '    <div class="desk_navbar_sub_container" style="padding:15px 0; display: ;">';

							$nav_desk_sub .= '      <div class="desk_navbar_sub_sidebar" style="padding-right:25px; text-align:right;line-height:40px; font-weight:bolder; font-size:22px;">'. $nav1->menu_name .'</div>';
							$nav_desk_sub .= '      <div class="desk_navbar_sub_main" style="border-left:1px solid #aaaaaa; width:100%;">';
							$nav_desk_sub .= '        <ul class="row" style="width:100%; max-width:980px; margin-bottom:0;">';

							$arr_d2 = array('sql_select' => '*','sql_from' => 'mng_cms','sql_where' => array('depth'=>2,'use_yn'=>'Y','parent_code'=>$nav1->page_code,'del_datetime' => NULL),'sql_order_by' => 'depth ASC,order ASC');
							$cms_result_d2 = $this->basic_model->arr_get_result($arr_d2);

							foreach($cms_result_d2['qry'] as $k2 => $nav2) {

								$a_target = ($nav2->page_type == 'link') ? ' target="blank" ' : '';

								$nav_desk_sub .= '<li class="col-md-auto nav_'. $nav2->page_code .'" style="padding-right:60px; display:inline-block; line-height:40px;">';
								$nav_desk_sub .= '  <a href="'. $nav2->page_url .'" '.$a_target.' style="text-decoration:none;">'. $nav2->menu_name .'</a>';
								$nav_desk_sub .= '</li>';

							}

							$nav_desk_sub .= '        </ul>';
							$nav_desk_sub .= '      </div>';
							$nav_desk_sub .= '    </div>';
							$nav_desk_sub .= '  </div>';
							$nav_desk_sub .= '</div>';

						}

						if ( ! write_file(VIEWPATH.'layout_nav_desk_sub_view.php', $nav_desk_sub))
						{
								alert('Unable to write the file : layout_nav_desk_sub_view.php');
								//echo 'Unable to write the file : layout_nav_desk_sub_view.php';
						}
						else
						{
								//echo 'File written! : layout_nav_desk_sub_view.php';
						}











						$nav_mobile = '';
						$navNo = 0;

						foreach($cms_result_d1['qry'] as $k1 => $nav1) {

							$a_target = ($nav1->page_type == 'link') ? ' target="blank" ' : '';

							// 2차 메뉴 존재하는지 여부
							$tcnt = $this->basic_model->get_common_count('mng_cms',array('depth'=>2,'use_yn'=>'Y','parent_code'=>$nav1->page_code,'del_datetime' => NULL));
							//echo $tcnt.'<<<<br />';

							//$link_depth1 = ( isset($list_nav2[$page_code]) ) ? '#' : $nav->page_url;
							//$link_depth1 = ( $tcnt > 0 ) ? '#' : $nav1->page_url;
							$link_depth1 = $nav1->page_url;
							$navNo++;
							$mNum = $navNo * 10;

							$arr_d2 = array('sql_select' => '*','sql_from' => 'mng_cms','sql_where' => array('depth'=>2,'use_yn'=>'Y','parent_code'=>$nav1->page_code,'del_datetime' => NULL),'sql_order_by' => 'depth ASC,order ASC');
							$cms_result_d2 = $this->basic_model->arr_get_result($arr_d2);
							$icon_depth2_plus = ($cms_result_d2['total_count'] > 0) ? 'icon_depth_plus' : '';

							
							$nav_mobile .= '<dl class="style_none mobile_navbar">';

							//$nav_mobile .= '  <dt class="m'. $mNum .' menu_toggle menu_close nav_'. $nav1->first_code .' '.$icon_depth2_plus.'"><a href="'. $link_depth1 .'" class="" '.$a_target.'>'. $nav1->menu_name .'<span class="sr-only">'. $nav1->menu_name .'</span></a></dt>';
							
							$nav_mobile .= '  <dt class="m'. $mNum .' menu_toggle menu_close nav_'. $nav1->first_code .' '.$icon_depth2_plus.'"><a href="'. $link_depth1 .'" class="" '.$a_target.'><span class="activenav">'. $nav1->menu_name .'</span><span class="sr-only">'. $nav1->menu_name .'</span></a></dt>';

							//$nav_mobile .= '  <dt class="m'. $mNum .' menu_toggle menu_close nav_'. $nav1->first_code .' '.$icon_depth2_plus.'"><a href="'. $link_depth1 .'" class="">'. $nav1->menu_name .'<span class="sr-only">'. $nav1->menu_name .'</span></a></dt>';

							foreach($cms_result_d2['qry'] as $k2 => $nav2) {

								$a_target = ($nav2->page_type == 'link') ? ' target="blank" ' : '';

								$arr_d3 = array('sql_select' => '*','sql_from' => 'mng_cms','sql_where' => array('depth'=>3,'use_yn'=>'Y','parent_code'=>$nav2->page_code,'del_datetime' => NULL),'sql_order_by' => 'depth ASC,order ASC');
								$cms_result_d3 = $this->basic_model->arr_get_result($arr_d3);

								$icon_depth3_plus = ($cms_result_d3['total_count'] > 0) ? 'icon_depth_plus' : '';

								$nav_mobile .= '  <dd class="m'. $mNum .' nav_'. $nav2->page_code .' '.$icon_depth3_plus.'"><a href="'. $nav2->page_url .'"  class="" '.$a_target.'> '. $nav2->menu_name .'</a></dd>';

								foreach($cms_result_d3['qry'] as $k3 => $nav3) {
									$a_target = ($nav3->page_type == 'link') ? ' target="blank" ' : '';

									$arr_d4 = array('sql_select' => '*','sql_from' => 'mng_cms','sql_where' => array('depth'=>4,'use_yn'=>'Y','parent_code'=>$nav3->page_code,'del_datetime' => NULL),'sql_order_by' => 'depth ASC,order ASC');
									$cms_result_d4 = $this->basic_model->arr_get_result($arr_d4);
									$icon_depth4_plus = ($cms_result_d4['total_count'] > 0) ? 'icon_depth_plus' : '';

									$nav_mobile .= '  <dd class="m'. $mNum .' depth3 nav_'. $nav3->page_code .' '.$icon_depth4_plus.'"><a href="'. $nav3->page_url .'" class="" '.$a_target.'><span> - </span>'. $nav3->menu_name .'</a></dd>';

									foreach($cms_result_d4['qry'] as $k4 => $nav4) {
										$a_target = ($nav4->page_type == 'link') ? ' target="blank" ' : '';
										$nav_mobile .= '  <dd class="m'. $mNum .' depth4 nav_'. $nav4->page_code .'"><a href="'. $nav4->page_url .'" '.$a_target.'><span> · </span>'. $nav4->menu_name .'</a></dd>';

									}
								}
							}
							$nav_mobile .= '</dl>';

						}

						if ( ! write_file(VIEWPATH.'layout_nav_mobile_view.php', $nav_mobile))
						{
								alert('Unable to write the file : layout_nav_mobile_view.php');
								//echo 'Unable to write the file : layout_nav_desk_sub_view.php';
						}
						else
						{
								//echo 'File written! : layout_nav_desk_sub_view.php';
						}

						//$this->ftp->chmod(VIEWPATH, 0755);

						//exit;


	}

	private function _cms_form($page_code=FALSE,$command=FALSE) {

		// 페이지 구분 flag
			$page_type = '';
			$boardpage = '';
			$htmlpage = '';
			$ctntpage = '';
			$landpage = '';

		// # 에러 메시지 CSS
			$this->form_validation->set_error_delimiters('<div class="err_color_red">','</div>');
		// # 신규/수정/삭제 - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
			if( $this->input->post('submit', FALSE) ) {

				$this->form_validation->set_rules('parent_code', '상위코드', 'trim|required');
				$this->form_validation->set_rules('page_code', '페이지코드', 'trim|required|xss_clean');
				/*
				if('write' == $command) {
					$this->form_validation->set_rules('page_code', '페이지코드', 'trim|required|xss_clean|is_unique[mng_cms.page_code]');
				}
				else {
					//$this->form_validation->set_rules('page_code', '페이지코드', 'trim|required|xss_clean|is_unique[mng_cms.page_code]');
				}
				*/

				$this->form_validation->set_rules('command', 'action', 'trim');
				$this->form_validation->set_rules('menu_name', '메뉴명', 'trim|required|xss_clean');
				// page_type
				$this->form_validation->set_rules('page_type', '페이지구분', 'trim|required');
				// page_flag
				$this->form_validation->set_rules('boardpage', '게시판', 'trim');
				$this->form_validation->set_rules('htmlpage', 'HTML 페이지', 'trim');
				$this->form_validation->set_rules('ctntpage', '컨텐츠 페이지', 'trim');
				$this->form_validation->set_rules('landpage', '랜딩 페이지', 'trim');
				// page_url
				$this->form_validation->set_rules('page_url', '페이지 URL', 'trim|required');



				$this->form_validation->set_rules('depth', '뎁스', 'trim|required');
				$this->form_validation->set_rules('order', '순번', 'trim|required');
				$this->form_validation->set_rules('use_yn', '사용 여부', 'trim|required');
				$this->form_validation->set_rules('folder', '폴더 사용 여부', 'trim');

				$this->form_validation->set_rules('page_title', '페이지 타이틀', 'trim');
				$this->form_validation->set_rules('meta_keyword', '페이지 키워드', 'trim');
				$this->form_validation->set_rules('meta_description', '페이지 설명', 'trim');

				$this->form_validation->set_rules('og_title', 'og:title', 'trim');
				$this->form_validation->set_rules('og_description', 'og:description', 'trim');
				$this->form_validation->set_rules('og_image', 'og:image', 'trim');
				$this->form_validation->set_rules('og_url', 'og:url', 'trim');

				$this->form_validation->set_rules('layout_header', '헤더', 'trim');
				$this->form_validation->set_rules('layout_footer', '헤더', 'trim');

				$page_type = $this->input->post('page_type', FALSE);
				// page_flag
				$boardpage = $this->input->post('boardpage', FALSE);
				$htmlpage = $this->input->post('htmlpage', FALSE);
				$ctntpage = $this->input->post('ctntpage', FALSE);
				$landpage = $this->input->post('landpage', FALSE);

				if ($this->form_validation->run()) {	// validation ok

					// 메뉴 구성 기본정보
					$parent_code  = $this->form_validation->set_value('parent_code');
					$page_code = $this->form_validation->set_value('page_code');
					$depth = $this->form_validation->set_value('depth');
					$command = $this->form_validation->set_value('command');
					$page_url = $this->form_validation->set_value('page_url');

					$arr = array('sql_select' => '*','sql_from' => 'mng_cms','sql_where' => array('page_code' => $page_code));
					$cms_row = $this->basic_model->arr_get_row($arr);
					$menu_order_parent = isset($cms_row->menu_order) ? $cms_row->menu_order : '';
					$pagecode_first = isset($cms_row->first_code) ? $cms_row->first_code : '';
					if($pagecode_first == '') {
						$tmp_arr = explode('_',$cms_row->menu_order);
						$pagecode_first = (isset($tmp_arr[0]) && $tmp_arr[0] != '') ? $tmp_arr[0] : '';
					}


					// 신규 등록
					if('write' == $command) {

						// 새로운 페이지코드(OLD)
						//$pagecode_new = $this->_new_pagecode();
						// 새로운 페이지코드(NEW)
						$pagecode_new = $this->_new_code(5);

						$depth++;
						$order = $this->_new_order($page_code);
						//$menu_order = ('' != $menu_order_parent) ? $menu_order_parent.'_'.str_replace('P','',$pagecode_new) : $pagecode_new;
						$menu_order = ('' != $menu_order_parent) ? $menu_order_parent.'_'.$pagecode_new : $pagecode_new;
						$first_code = ($depth < 2) ? $pagecode_new : $pagecode_first;

						// 메뉴 정렬용
						$nav_ord = $first_code.'-'.$depth.'-'.$order;

						// 신규 페이지 뉴코드 적용
						$page_url = str_replace($page_code,$pagecode_new,$page_url);

						$data = array(
							'nav_ord'=>$nav_ord,
							'first_code'=>$first_code,
							'parent_code'=>$page_code,
							'page_code'=>$pagecode_new,
							'depth'=>$depth,
							'order'=>$order,
							'menu_order'=>$menu_order,
							'page_url' => $page_url
						);
							

						if (!is_null($res = $this->cms_lib->write_cms($data))) {		// success
							$msg = ('00000' == $page_code) ? '메인 메뉴가 추가되었습니다.' : '하위 메뉴가 추가되었습니다.';
							sess_message($msg);

							$this->_make_nav_file();

							redirect(base_url().'admin/contents/cms/form/'.$pagecode_new);
						}
						else {
							sess_message('error.');
						}

					}
					// 
					elseif('edit' == $command) {
						
						// 메뉴 정렬용
						$new_order = $this->input->post('order');
						$nav_ord = $pagecode_first.'-'.$depth.'-'.$new_order;

						// page_type
						$page_type = $this->input->post('page_type', FALSE);
						// page_flag
						$boardpage = $this->input->post('boardpage', FALSE);
						$htmlpage = $this->input->post('htmlpage', FALSE);
						$ctntpage = $this->input->post('ctntpage', FALSE);
						$landpage = $this->input->post('landpage', FALSE);

						$page_flag = '';
						if($page_type == 'boardpage') { $page_flag = $boardpage; }
						elseif($page_type == 'htmlpage') { $page_flag = $htmlpage; }
						elseif($page_type == 'ctntpage') { $page_flag = $ctntpage; }
						elseif($page_type == 'landpage') { $page_flag = $landpage; }

						$data = array(
							'first_code' => $pagecode_first,
							'nav_ord' => $nav_ord,

							'page_type' => $page_type,
							'page_flag' => $page_flag,

							'menu_name' => $this->input->post('menu_name'),
							'page_url' => $this->input->post('page_url'),

							'order' => $new_order,
							'use_yn' => $this->input->post('use_yn'),
							'folder' => $this->input->post('folder'),

							'page_title' => $this->input->post('page_title'),
							'meta_keyword' => $this->input->post('meta_keyword'),
							'meta_description' => $this->input->post('meta_description'),

							'og_title' => $this->input->post('og_title'),
							'og_description' => $this->input->post('og_description'),
							'og_image' => $this->input->post('og_image'),
							'og_url' => $this->input->post('og_url'),

							'layout_header' => $this->input->post('layout_header'),
							'layout_footer' => $this->input->post('layout_footer'),

							'edit_username' => $this->tank_auth->get_username(),
							'edit_datetime' => date('Y-m-d H:i:s'),
						);



						if (!is_null($res = $this->cms_lib->edit_cms($page_code,$data))) {		// success
							sess_message('수정이 완료되었습니다.');

							$this->_make_nav_file();

							redirect(base_url().'admin/contents/cms/form/'.$page_code);
							//redirect($this->uri->uri_string());
						}
						else {
							sess_message('error.');
						}

					}
					elseif('del' == $command) {
						if (!is_null($res = $this->cms_lib->delete_cms($page_code))) {		// success
							if('deny' == $res) {
								// 삭제되지 않은 하위 메뉴가 있어서 삭제 불가.
								//sess_message('<div style="color:red;">삭제하지 않은 하위 메뉴가 있습니다.  &nbsp; 하위메뉴를 모두 삭제하신 후 다시 시도해주세요. </div>');
								alert('삭제하지 않은 하위 메뉴가 있습니다. \n하위메뉴를 모두 삭제하신 후 다시 시도해주세요.',base_url().'admin/contents/cms/form/'.$page_code);
							}
							else {

								$this->_make_nav_file();

								//sess_message('삭제가 완료되었습니다.');
								//redirect(base_url().'admin/contents/cms/form/');
								alert('삭제가 완료되었습니다.',base_url().'admin/contents/cms/form/');
							}
						}
						else {
							sess_message('error.');
						}
					}

					//echo $command.'<<<<<<br />';
					//exit;


				}
			}






			//$this->_make_nav_file();
















		// 삭제되었거나 존재하지 않는 페이지는 예외 처리
		if($page_code && $command == FALSE) {
			$arr = array('sql_select' => '*','sql_from' => 'mng_cms','sql_where' => array('page_code'=>$page_code));
			$row = $this->basic_model->arr_get_row($arr);
			if((! isset($row->page_code) OR $row->del_datetime !== NULL)) {
				alert('이미 삭제되었거나, 존재하지 않는 페이지입니다.', base_url().'admin/contents/cms/form/');
			}
		}


		// dtree 필수
			load_css('<link rel="stylesheet" type="text/css" media="screen" href="'.LIB_DIR.'/dtree/dtree.css?v=1" />');
			load_js('<script src="'. LIB_DIR .'/dtree/dtree.js?v=4"></script>');
			load_js('<script type="text/javascript" charset="UTF-8" src="/assets/lib/dtree/js/jquery.cookie.js"></script>');
			load_js('<script type="text/javascript" charset="UTF-8" src="/assets/lib/dtree/js/jquery.jstree.js"></script>');

		// cms 데이터 가져오기
			$arr = array('sql_select' => '*','sql_from' => 'mng_cms','sql_where' => array('del_datetime' => NULL),'sql_order_by' => 'depth ASC,order ASC');
			$cms_result = $this->basic_model->arr_get_result($arr);
			//print_r($cms_result['qry']);
			if('' != $page_code && '00000' != $page_code && $cms_result['total_count'] < 1) {
				alert('이미 삭제되었거나, 존재하지 않는 메뉴입니다.');
				redirect(base_url().'admin/contents/cms/form');
			}

			$arr = array('sql_select' => '*','sql_from' => 'mng_cms','sql_where' => array('page_code' => $page_code));
			$row = $this->basic_model->arr_get_row($arr);
			//print_r($cms_row);

			// 하위 메뉴 작성시 입력 값들 초기화
			if( $command == 'write' && '00000' == $page_code) {
				// 메인 메뉴 추가
				$cms_row = new stdClass();
				$order = $this->_new_order('00000');
				$cms_row->order = $order;
			}
			elseif( $command == 'write' && '' != $page_code) {
				// 서브 메뉴 츄가
				$cms_row = new stdClass();
				$cms_row->page_code = $row->page_code;
				$cms_row->page_type = $row->page_type;
				$cms_row->page_flag = $row->page_flag;
				$cms_row->depth = $row->depth;
				$order = $this->_new_order($page_code);
				$cms_row->order = $order;
				$cms_row->menu_name = $row->menu_name;
			}
			else {
				$cms_row = $row;
			}


		// location 값 가져오기
			$location_info = '홈';
			if( isset($cms_row->menu_order) ) {
				$arr_pagecode = explode('_',$cms_row->menu_order);
				//print_r($arr_pagecode);
				foreach($arr_pagecode as $key => $code) {

					$loc_page_code = ($key > 0) ? 'P'.$code : $code;
					$arr = array('sql_select' => '*','sql_from' => 'mng_cms','sql_where' => array('page_code' => $loc_page_code));
					$row = $this->basic_model->arr_get_row($arr);
					if( isset($row->menu_name) ) {
						$location_info .= ' / '.$row->menu_name;
					}
				}
			}


		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		// 생성된 게시판 목록 가져오기
		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
			$sql_select = 'bconf.idx, bconf.gr_code, bconf.bo_code, bconf.bo_title, bconf.bo_use_category, bconf.bo_category, bgrp.gr_title';
			$sql_from = 'board_config as bconf';
			$sql_where = array('bconf.idx >' => 0);
			$sql_group_by = FALSE;
			$sql_order_by = 'bgrp.gr_code ASC';
			// 조인
			$sql_join_tbl = 'board_group as bgrp';
			$sql_join_on = 'bconf.gr_code = bgrp.gr_code';
			$sql_join_option = 'LEFT OUTER';

			// 검색 상관없는 전체 수
			$arr = array(
					'sql_select'     => $sql_select,
					'sql_from'       => $sql_from,
					'sql_join_tbl'       => $sql_join_tbl,
					'sql_join_on'        => $sql_join_on,
					'sql_join_option'    => $sql_join_option,
					'sql_where'      => $sql_where,
					'sql_group_by'   => $sql_group_by,
					'sql_order_by'   => $sql_order_by
			);
			$boards_result = $this->basic_model->arr_get_result($arr);
			//print_r($boards_result);


		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		// HTML 페이지 목록 가져오기
		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
			$arr_htmlpage = array();
			$htmlpage_skin_dir = APPPATH.'views/page/';
			$htmlpage_skin_files = scandir($htmlpage_skin_dir); 

			foreach($htmlpage_skin_files as $file)
			{
				if(is_file($htmlpage_skin_dir.$file)){
					//echo $file.'<<<<br />';
					$tmp_arr = explode('.',$file);
					if( isset($tmp_arr[0]) && '' != $tmp_arr[0] ){
						$arr_htmlpage[$tmp_arr[0]] = '/views/page/'.$file;
					}
				}
			}
			//print_r($arr_htmlpage);



		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		// 생성된 컨텐츠 페이지 목록 가져오기
		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		/*
			$sql_select = '*';
			$sql_from = 'mng_contents';
			$sql_where = array('del_datetime' => NULL);
			$sql_group_by = FALSE;
			$sql_order_by = 'idx DESC';
			// 조인
			$sql_join_tbl = FALSE;
			$sql_join_on = FALSE;
			$sql_join_option = 'LEFT OUTER';
			$arr = array(
					'sql_select'     => $sql_select,
					'sql_from'       => $sql_from,
					'sql_join_tbl'       => $sql_join_tbl,
					'sql_join_on'        => $sql_join_on,
					'sql_join_option'    => $sql_join_option,
					'sql_where'      => $sql_where, //array('PIDX' => $pidx),
					'sql_group_by'   => $sql_group_by,
					'sql_order_by'   => $sql_order_by,  // $order_field.' DESC, IDX DESC',
			);
			$contents_result = $this->basic_model->arr_get_result($arr);
			//print_r($contents_result);
		*/



		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		// 생성된 랜딩 페이지 목록 가져오기
		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		/*
			$sql_select = '*';
			$sql_from = 'mng_landing';
			$sql_where = array('del_datetime' => NULL);
			$sql_group_by = FALSE;
			$sql_order_by = 'idx DESC';
			// 조인
			$sql_join_tbl = FALSE;
			$sql_join_on = FALSE;
			$sql_join_option = 'LEFT OUTER';

			$arr = array(
					'sql_select'     => $sql_select,
					'sql_from'       => $sql_from,
					'sql_join_tbl'       => $sql_join_tbl,
					'sql_join_on'        => $sql_join_on,
					'sql_join_option'    => $sql_join_option,
					'sql_where'      => $sql_where, //array('PIDX' => $pidx),
					'sql_group_by'   => $sql_group_by,
					'sql_order_by'   => $sql_order_by,  // $order_field.' DESC, IDX DESC',
			);
			$landing_result = $this->basic_model->arr_get_result($arr);
			//print_r($landing_result);
		*/

		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		// 랜딩 페이지 목록 가져오기
		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
			$arr_landpage = array();


		// Get data.
			$breadcrumb = array(
				'컨텐츠'=>base_url().'admin/contents',
				'CMS 관리'=>''
			);

			$data = array(
				'cms_result' => $cms_result,
				'boards_result' => $boards_result,
				'arr_htmlpage' => $arr_htmlpage,
				'contents_result' => $this->contents_result,
				'landing_result' => $this->landing_result,
				'item_cate1_result' => $this->item_cate1_result,
				'location_info' => $location_info,

				'page_type' => $page_type,
				'boardpage' => $boardpage,
				'htmlpage' => $htmlpage,
				'ctntpage' => $ctntpage,
				'landpage' => $landpage,

				'cms_row' => $cms_row,
				'page_code' => $page_code,
				'command' => $command,
				'arr_seg'   => $this->arr_seg, //$this->uri->segment_array(),
				'breadcrumb'    => $breadcrumb,
				'viewPage'  => 'admin/contents_cms_form_view'
			);

			$this->load->view('admin/layout_view', $data);

	}



	// 페이지코드 만들기
	private function _new_code($len=5) {


		$new_code = new_code($len,'upper');

		$arr = array('sql_select' => '*','sql_from' => 'mng_cms','sql_where' => array('code'=>$new_code));
		$cnt = $this->basic_model->get_common_count('mng_cms',$sql_where);

		if($cnt > 0) {
			$new_code = _new_code($len);
		}

		return $new_code;
	}


	// 페이지코드 만들기
	private function _new_pagecode() {
		$sql_where = array('idx >'=>0);
		$arr = array('sql_select' => '*','sql_from' => 'mng_cms','sql_where' => $sql_where,'sql_order_by'=>'idx DESC');
		$cnt = $this->basic_model->get_common_count('mng_cms',$sql_where);
		$row = $this->basic_model->arr_get_row($arr);

		if($cnt > 0) {
			$pidx = $row->idx + 1;
			$len = strlen($pidx);
			$codelen = 4;
			$repeat = $codelen - $len;
			$pagecode = 'P';
			for($i=1;$i<=$repeat;$i++) {
				$pagecode .= '0';
			}
			$pagecode .= $pidx;
		}
		else {
			$pagecode = 'P0001';
		}
		return $pagecode;
	}

	// ORDER
	private function _new_order($page_code) {
		$sql_where = array('parent_code'=>$page_code,'del_datetime'=>NULL);
		$arr = array('sql_select' => '*','sql_from' => 'mng_cms','sql_where' => $sql_where,'sql_order_by'=>'ORDER DESC');
		$cnt = $this->basic_model->get_common_count('mng_cms',$sql_where);
		$row = $this->basic_model->arr_get_row($arr);

		if($cnt >0) {
			$order = $row->order + 1;
		}
		else {
			$order = 1;
		}
		return $order;
	}







	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	// 컨텐츠 페이지 관리
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	function page($step=FALSE,$flag=FALSE) 
	{
		if(! $step) {
			$step = 'lists';
			redirect(base_url().'admin/contents/cms/'.$step);
		}

		switch ($step) {
			case 'lists':
					$this->_page_lists();
			break;
			case 'form':
					$idx = $flag ? $flag : '';
					$this->_page_form($idx);
			break;
			case 'del':
					$idx = $flag ? $flag : $this->input->post('idx');
					$this->_page_del($idx);
			break;
			default:
				alert('잘못된 접근입니다.', '/admin/contents/page/lists');
			break;
		}
	}


	private function _page_del($idx)
	{
			if (!is_null($res = $this->cms_lib->contents_delete($idx))) {		// success
				//sess_message('삭제가 완료되었습니다.');
				//redirect(base_url().'admin/contents/page/form/');
				alert('삭제가 완료되었습니다.',base_url().'admin/contents/page/lists/');
			}
			else {
				sess_message('error.');
			}

	}


	private function _page_lists()
	{
			// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
			// 페이징 정보 
			// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
			$this->load->library('segment', array('offset'=>4), 'seg'); // 세그먼트 주소( page 위치 )
			$this->load->library('querystring', NULL, 'param'); // 쿼리스트링 주소
			$seg	  =& $this->seg;
			$param	  =& $this->param;
			
			// [페이징]
			$qstr = '';
			
			// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
			// sql 
			// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
			$sql_select = 'idx,cate,page_title,page_seo_url,page_content,use_yn,reg_username,reg_datetime';
			$sql_from = 'mng_contents';
			$sql_where = array('del_datetime' => NULL);
			$sql_group_by = FALSE;
			$sql_order_by = 'idx DESC';

			// 페이징
			$limit = '10';
			$page  = $seg->get('page', 1); // 페이지
			if(! isset($page) OR empty($page)) {
				$page = '1';
			}
			$offset = ($page - 1) * $limit;

			// 검색
			$like_field = FALSE;                         // search
			$like_match = FALSE;
			$like_side = 'both';
			// 조인
			$sql_join_tbl = FALSE;
			$sql_join_on = FALSE;
			$sql_join_option = 'LEFT OUTER';

			// 검색 상관없는 전체 수
			$total_count = $this->basic_model->get_common_count($sql_from,$sql_where);

			$arr = array(
					'sql_select'     => $sql_select,
					'sql_from'       => $sql_from,
					'sql_join_tbl'       => $sql_join_tbl,
					'sql_join_on'        => $sql_join_on,
					'sql_join_option'    => $sql_join_option,
					'like_field'      => $like_field,
					'like_match'      => $like_match,
					'like_side'      => $like_side,
					'sql_where'      => $sql_where, //array('PIDX' => $pidx),
					'sql_group_by'   => $sql_group_by,
					'sql_order_by'   => $sql_order_by,  // $order_field.' DESC, IDX DESC',
					'page'      => $page,
					'limit'      => $limit,
					'offset'      => $offset,
			);
			$result = $this->basic_model->arr_get_result($arr);

			// pagination 설정
			$config['suffix']	   = $qstr; // $param->output();
			$config['base_url']    = base_url() . 'admin/contents/lists/page/';
			$config['per_page']    = $limit;
			$config['total_rows']  = $result['total_count'];
			$config['uri_segment'] = $seg->pos('page');  // 5

			// 검색 목록 ADD
			$btn_prev_part = $btn_next_part = '';
			$config['full_tag_open']  = "<ul class='pagination'>".$btn_prev_part;
			$config['full_tag_close'] = $btn_next_part.'</ul>';

			//$CI =& get_instance();
			//$CI->load->library('pagination', $config);
			$this->load->library('pagination', $config);


			$this->pagination->initialize($config);

			$list = array();
			foreach ($result['qry'] as $i => $row) {

				$list[$i] = new stdClass();

				$list[$i]->num = ($result['total_count'] - $config['per_page']*($page-1) - $i);

				$list[$i]->idx = $row->idx;
				$list[$i]->cate = $row->cate;
				$list[$i]->page_title = $row->page_title;
				$list[$i]->page_seo_url = $row->page_seo_url;
				$list[$i]->page_content = $row->page_content;
				$list[$i]->use_yn = $row->use_yn;
				$list[$i]->reg_username = $row->reg_username;
				$list[$i]->reg_datetime = $row->reg_datetime;
				$list[$i]->reg_date = substr($row->reg_datetime,0,10);
			}


		// Get data.
			$breadcrumb = array(
				'컨텐츠'=>base_url().'admin/contents',
				'컨텐츠 페이지 목록'=>''
			);

			$data = array(

				'list' => $list,
				'paging' => $this->pagination->create_links(),

				'arr_seg'   => $this->arr_seg, //$this->uri->segment_array(),
				'breadcrumb'    => $breadcrumb,
				'viewPage'  => 'admin/contents_page_lists_view'
			);

			$this->load->view('admin/layout_view', $data);
	}

	private function _page_form($idx=FALSE)
	{


        /*
		//<!-- redactor.css -->
		load_css('<link rel="stylesheet" type="text/css" href="'. ASSETS_DIR .'/lib/editor/redactor/redactor.min.css" />');
    	//<!-- redactor.js -->
		load_js('<script src="'. ASSETS_DIR .'/lib/editor/redactor/redactor.min.js"></script>');
        //<!-- plugin js -->
		load_js('<script src="'. ASSETS_DIR .'/lib/editor/redactor/_plugins/filemanager/filemanager.js"></script>');
		load_js('<script src="'. ASSETS_DIR .'/lib/editor/redactor/_plugins/imagemanager/imagemanager.js"></script>');
		load_js('<script src="'. ASSETS_DIR .'/lib/editor/redactor/_plugins/table/table.js"></script>');
		load_js('<script src="'. ASSETS_DIR .'/lib/editor/redactor/_plugins/video/video.js"></script>');
		load_js('<script src="'. ASSETS_DIR .'/lib/editor/redactor/_plugins/alignment/alignment.js"></script>');

		load_css('<link rel="stylesheet" type="text/css" href="'. ASSETS_DIR .'/lib/editor/redactor/_plugins/inlinestyle/inlinestyle.css" />');
		load_js('<script src="'. ASSETS_DIR .'/lib/editor/redactor/_plugins/inlinestyle/inlinestyle.js"></script>');

		load_js('<script src="'. ASSETS_DIR .'/lib/editor/redactor/_plugins/specialchars/specialchars.js"></script>');
		load_js('<script src="'. ASSETS_DIR .'/lib/editor/redactor/_plugins/textdirection/textdirection.js"></script>');
		load_js('<script src="'. ASSETS_DIR .'/lib/editor/redactor/_plugins/widget/widget.js"></script>');
		load_js('<script src="'. ASSETS_DIR .'/lib/editor/redactor/_plugins/fontfamily/fontfamily.js"></script>');
		load_js('<script src="'. ASSETS_DIR .'/lib/editor/redactor/_plugins/fontsize/fontsize.js"></script>');
		load_js('<script src="'. ASSETS_DIR .'/lib/editor/redactor/_plugins/fontcolor/fontcolor.js"></script>');
		load_js('<script src="'. ASSETS_DIR .'/lib/editor/redactor/_plugins/fullscreen/fullscreen.js"></script>');

		//<!-- connect the languages file -->
		load_js('<script src="'. ASSETS_DIR .'/lib/editor/redactor/_langs/ko.js?v='.time().'"></script>');
		*/


		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		// 글 작성(새글, 답변글, 수정)시 업로드 파일 저장을 위해 고유 세션 생성
		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
			$user_idx = $this->tank_auth->get_user_id();
			$ss_write_name = 'ss_file_'.$user_idx;
			if (! $this->session->userdata($ss_write_name)) {
				$this->session->set_userdata($ss_write_name, $user_idx.'_'.time());
			}



		// process
			if ($this->input->post('submit')) 
			{
				$res = $this->cms_lib->contents_save();

				
				// 업로드
				if( isset($res['idx']) ) {

						// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
						// 폼업로드 파일 저장 처리
						// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
						//$this->load->library('upload_lib');
						// max upload size
							$max_upload_size = 20480; // 20MB
							$tbl_code = 'mng_contents';

							//$cnt_succ_upload = $this->upload_lib->multi_upload_file('attach_file_form', url_code('contents/files','e'), $tbl_code, $res['idx'], '', $max_upload_size );
							//$succ_upload = $this->upload_lib->upload_file($field_name,$encoded_upload_folder,$wr_table,$wr_table_idx,$wr_opt_idx,$multi_files,$i,$return_data,$max_upload_size);

							$field_name = 'attach_file_form';
							$encoded_upload_folder = url_code('contents/files','e');
							$wr_table = $tbl_code;
							$wr_table_idx = $res['idx'];
							$wr_opt_idx='';
							$multi_files=FALSE;
							$multi_index=FALSE;
							$return_data=TRUE;
							$max_upload_size='20480';
							$down_no=FALSE;
							$gubun=FALSE;
							$file_title=FALSE;

							$this->upload_lib->upload_file($field_name,$encoded_upload_folder,$wr_table,$wr_table_idx,$wr_opt_idx,$multi_files,$multi_index,$return_data,$max_upload_size,$down_no,$gubun,$file_title);


							//echo $cnt_succ_upload.'<<<<<<';
							//exit;

						// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
						// 글 작성시 에디터로 업로드 한 파일 정보 저장 후, 세션 삭제
						// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
							$sess_file_write = $this->session->userdata($ss_write_name);
							$this->upload_model->update_file_manager($sess_file_write,$tbl_code,$res['idx']);

				}

				//sess_message('게시판 정보가 수정되었습니다.');
				redirect(base_url().'admin/contents/page/form/'.$res['idx']);
			}


			// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
			// 폼과 에디터에 업로드한 파일 가져오기
			// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

			$total_cnt_file_form = 0;
			$result_file_form = array();

			if($idx)
			{
				$tbl_code = 'mng_contents';

				$get_type='result';  // 'result', 'result_array'
				$sql_from='file_manager';
				$fields='*';
				$join_tbl=FALSE;
				$join_where=FALSE;
				$join_option='left outer';
				$sql_where_form = "wr_table='".$tbl_code."' AND (wr_table_idx='". $idx ."'  OR  wr_sess='". $this->session->userdata($ss_write_name) ."')  AND upload_type='form'";

				// 전체 수
				$total_cnt_file_form = $this->basic_model->get_common_count($sql_from, $sql_where_form);

				$like_field = '';
				$like_match = '';
				$like_side='both';
				$sql_group_by = '';

				$order_field = 'datetime_upload';
				$order_direction = 'desc';

				$limit = FALSE;
				$page  = FALSE;
				$offset = FALSE;

				$arr = array(
						'sql_select'     => $fields,
						'sql_from'       => $sql_from,
						'sql_where'      => $sql_where_form,
						'sql_order_by'   => $order_field.' '.$order_direction
				);
				$result_file_form = $this->basic_model->arr_get_result($arr);
				//print_r($result_file_form);
			}


		// 정보
			$row = array();
			if($idx) {
				$arr = array('sql_select' => '*','sql_from' => 'mng_contents','sql_where' => array('idx' => $idx, 'del_datetime' => NULL));
				$row = $this->basic_model->arr_get_row($arr);
			}

			if( $idx && ! isset($row->idx) ) {
				alert('존재하지 않는 페이지입니다.',base_url().'admin/contents/page/form');
			}


		// 필수 css/js
		/*
			// 필수 CSS 로드
			load_css('<link rel="stylesheet" type="text/css" href="'. LIB_DIR .'/editor/redactor/redactor.css?v=1" media="screen"/>');
			// 필수 JS 로드
			load_js('<script src="'. LIB_DIR .'/editor/redactor/redactor.min.js"></script>');
			load_js('<script src="'. LIB_DIR .'/editor/redactor/_langs/ko.js"></script>');
			load_js('<script src="'. LIB_DIR .'/editor/redactor/_plugins/table/table.js"></script>');
			load_js('<script src="'. LIB_DIR .'/editor/redactor/_plugins/video/video.js"></script>');
		*/

		// Get data.
			$str = ($idx) ? '수정' : '등록';
			$breadcrumb = array(
				'컨텐츠'=>base_url().'admin/contents',
				'컨텐츠 페이지 '.$str=>''
			);

			$data = array(
				'idx' => $idx,
				'row' => $row,
				'arr_seg'   => $this->arr_seg, //$this->uri->segment_array(),
				'breadcrumb'    => $breadcrumb,

				'total_cnt_file_form'     => $total_cnt_file_form,
				'result_file_form'     => $result_file_form,

				'viewPage'  => 'admin/contents_page_form_view'
			);

			$this->load->view('admin/layout_view', $data);
	}




	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	// 랜딩 페이지 관리
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	function landing($step=FALSE,$flag=FALSE,$flag2=FALSE) 
	{
		if(! $step) {
			$step = 'lists';
			redirect(base_url().'admin/contents/landing/'.$step);
		}

		switch ($step) {

			case 'form':
					$idx = $flag ? $flag : '';
					$this->_landing_form($idx);
			break;
			case 'lists':
					$this->_landing_lists();
			break;
			case 'req':
					if(! $flag) {
						//$flag = 'lists';
						redirect(base_url().'admin/contents/landing/req/lists');
					}
					if($flag == 'lists') :
						$this->_landing_req_list();
					elseif(is_int($flag) == 1) :
						$idx = $flag ? $flag : '';
						$this->_landing_req_member($idx);
					endif;
			break;

			case 'req_list':
					$this->_landing_req_list();
			break;
			case 'req_code':
					if(! $flag OR '' ==  $flag) :
						//$flag = 'npo'; // npo, comp, ..
						redirect(base_url().'admin/contents/landing/req_list');
					else :
						$code = $flag;
						$this->_landing_req_code($code);
					endif;
			break;
			case 'req_code_detail':

					$code = $flag;
					$idx = $flag2;

					// 문의/신청 상세
					$this->_landing_req_code_detail($code,$idx);
			break;
			case 'req_code_del':
					$idx = $flag ? $flag : $this->input->post('idx');
					$this->_landing_req_code_del($idx);
			break;


			case 'del':
					$idx = $flag ? $flag : $this->input->post('idx');
					$this->_landing_del($idx);
			break;
			default:
				alert('잘못된 접근입니다.', '/admin/contents/landing/lists');
			break;
		}
	}


	// 신청/문의 상세
	private function _landing_req_code_detail($code=FALSE,$idx=FALSE)
	{

		if(! $code OR ! $idx ) {
			alert('\n잘못된 경로로 접속하셨습니다.\n이전 페이지로 돌아갑니다.');
			exit;
		}

		/*
		$landing_title = '신청 문의';
		if('comp' == $code) {
			$landing_title = '기업 제휴 문의';
		}
		elseif('npo' == $code) {
			$landing_title = 'NPO 협약 신청';
		}
		*/

		// 랜딩 페이지 정보
		$arr_fld_nm = array();
		$arr_fld_chk = array();
		$arr_fld_type = array();

		// 랜딩 페이지 파일 정보
		$arr_file_ttl = array();
		$arr_file_desc = array();

		$row = array();

		if($code) {
			$arr = array('sql_select' => '*','sql_from' => 'mng_landing','sql_where' => array('code' => $code));
			$row = $this->basic_model->arr_get_row($arr);

			//print_r($row);

			if(isset($row->idx)) {
				$arr_fld_nm = array($row->fld_nm_1,$row->fld_nm_2,$row->fld_nm_3,$row->fld_nm_4,$row->fld_nm_5,$row->fld_nm_6,$row->fld_nm_7,$row->fld_nm_8,$row->fld_nm_9,$row->fld_nm_10);
				$arr_fld_chk = array($row->fld_chk_1,$row->fld_chk_2,$row->fld_chk_3,$row->fld_chk_4,$row->fld_chk_5,$row->fld_chk_6,$row->fld_chk_7,$row->fld_chk_8,$row->fld_chk_9,$row->fld_chk_10);
				$arr_fld_type = array($row->fld_type_1,$row->fld_type_2,$row->fld_type_3,$row->fld_type_4,$row->fld_type_5,$row->fld_type_6,$row->fld_type_7,$row->fld_type_8,$row->fld_type_9,$row->fld_type_10);


				$arr_file_ttl = array($row->file_ttl_1,$row->file_ttl_2,$row->file_ttl_3,$row->file_ttl_4,$row->file_ttl_5);
				$arr_file_desc = array($row->file_desc_1,$row->file_desc_2,$row->file_desc_3,$row->file_desc_4,$row->file_desc_5);
			}
		}

		$landing_title = (isset($row->title) && '' != $row->title) ? $row->title : '신청 문의';


		// 신청/문의 상세 내역
		$arr = array('sql_select' => '*','sql_from' => 'landing','sql_where' => array('code'=>$code,'idx'=>$idx));
		$row = $this->basic_model->arr_get_row($arr);

		$list = array(
			$row->txtfld_1,
			$row->txtfld_2,
			$row->txtfld_3,
			$row->txtfld_4,
			$row->txtfld_5,
			$row->txtfld_6,
			$row->txtfld_7,
			$row->txtfld_8,
			$row->txtfld_9,
			$row->txtfld_10,
			(isset($row->created) ? substr($row->created,0,10) : '' )
		);



		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		// 글 작성(새글, 답변글, 수정)시 업로드 파일 저장을 위해 고유 세션 생성
		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
			$user_idx = $this->tank_auth->get_user_id();
			$ss_write_name = 'ss_file_'.$user_idx;
			if (! $this->session->userdata($ss_write_name)) {
				$this->session->set_userdata($ss_write_name, $user_idx.'_'.time());
			}


		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		// 업로드 파일 가져오기
		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
			$tbl_code = 'mng_landing';

			$get_type='result';  // 'result', 'result_array'
			$sql_from='file_manager';
			$fields='*';
			$join_tbl=FALSE;
			$join_where=FALSE;
			$join_option='left outer';
			$sql_where_form = "wr_table='".$tbl_code."' AND (wr_table_idx='". $idx ."'  OR  wr_sess='". $this->session->userdata($ss_write_name) ."')  AND upload_type='form'";

			// 전체 수
			$total_cnt_file_form = $this->basic_model->get_common_count($sql_from, $sql_where_form);

			$like_field = '';
			$like_match = '';
			$like_side='both';
			$sql_group_by = '';

			/*
			$order_field = 'datetime_upload';
			$order_direction = 'desc';
			*/

			$order_field = 'order';
			$order_direction = 'ASC';

			$limit = FALSE;
			$page  = FALSE;
			$offset = FALSE;

			$arr = array(
					'sql_select'     => $fields,
					'sql_from'       => $sql_from,
					'sql_where'      => $sql_where_form,
					'sql_order_by'   => $order_field.' '.$order_direction
			);
			$result_file_form = $this->basic_model->arr_get_result($arr);
			//print_r($result_file_form);

			$arr_file_link = array();
			$arr_file_name = array();
			$arr_file_size = array();
			foreach($result_file_form['qry'] as $i => $o) {
				$filepath = url_code($o->file_dir, 'e');
				$filename = $o->file_name;
				$filename_original = $o->file_name_org;

				// 원본 파일명에 괄호가 있는 경우 치환하여 다운로드
				$filename_original = str_replace(array('(',')'), array('_','_'),$filename_original);


				$arr_file_link[$i] = "/files/download/".$filepath."/".$filename."/".$filename_original;
				$arr_file_name[$i] = $filename_original;
				$arr_file_size[$i] = isset($o->file_size) ? number_format($o->file_size)."KB" : "";
			}


		// Get data.
			$breadcrumb = array(
				'컨텐츠'=>base_url().'admin/contents',
				'랜딩 페이지 관리'=>base_url().'admin/contents/landing/req_list',
				'신청/문의 내역'=>''
			);

			$data = array(
				'landing_title' => $landing_title,
				'code' => $code,
				'idx' => $idx,
				'row' => $row,
				'list' => $list,

				'arr_fld_nm' => $arr_fld_nm,
				'arr_fld_chk' => $arr_fld_chk,
				'arr_fld_type' => $arr_fld_type,

				'arr_file_ttl' => $arr_file_ttl,
				'arr_file_desc' => $arr_file_desc,

				'arr_file_link' => $arr_file_link,
				'arr_file_name' => $arr_file_name,
				'arr_file_size' => $arr_file_size,

				'arr_seg'   => $this->arr_seg, //$this->uri->segment_array(),
				'breadcrumb'    => $breadcrumb,
				'viewPage'  => 'admin/contents_landing_req_code_detail_view'
			);

			$this->load->view('admin/layout_view', $data);

	}



	// 신청/문의 내역을 삭제합니다.
	private function _landing_req_code_del($idx=FALSE)
	{
			if (!is_null($res = $this->cms_lib->landing_req_code_delete($idx))) {		// success
				//sess_message('삭제가 완료되었습니다.');
				//redirect(base_url().'admin/contents/page/form/');
				$code=$res['code'];
				alert('삭제가 완료되었습니다.',base_url().'admin/contents/landing/req_code/'.$code);
			}
			else {
				sess_message('error.');
			}

	}


	// 관리자가 생성한 랜딩 페이지를 삭제합니다. 
	// 주의해주세요! 
	private function _landing_del($idx)
	{
			if (!is_null($res = $this->cms_lib->landing_delete($idx))) {		// success
				//sess_message('삭제가 완료되었습니다.');
				//redirect(base_url().'admin/contents/page/form/');
				alert('삭제가 완료되었습니다.',base_url().'admin/contents/landing/lists/');
			}
			else {
				sess_message('error.');
			}

	}



	private function _landing_form($idx=FALSE)
	{

		// process
			if ($this->input->post('submit')) 
			{
				$this->cms_lib->landing_save();
			}


		// 정보
			$row = array();

			$arr_fld_nm = array();
			$arr_fld_chk = array();
			$arr_fld_type = array();
			$arr_fld_desc = array();

			// 랜딩 페이지 파일 정보
			$arr_file_ttl = array();
			$arr_file_desc = array();

			if($idx) {
				$arr = array('sql_select' => '*','sql_from' => 'mng_landing','sql_where' => array('idx' => $idx));
				$row = $this->basic_model->arr_get_row($arr);

				if(isset($row->idx)) {
					$arr_fld_nm = array($row->fld_nm_1,$row->fld_nm_2,$row->fld_nm_3,$row->fld_nm_4,$row->fld_nm_5,$row->fld_nm_6,$row->fld_nm_7,$row->fld_nm_8,$row->fld_nm_9,$row->fld_nm_10);
					$arr_fld_chk = array($row->fld_chk_1,$row->fld_chk_2,$row->fld_chk_3,$row->fld_chk_4,$row->fld_chk_5,$row->fld_chk_6,$row->fld_chk_7,$row->fld_chk_8,$row->fld_chk_9,$row->fld_chk_10);
					$arr_fld_type = array($row->fld_type_1,$row->fld_type_2,$row->fld_type_3,$row->fld_type_4,$row->fld_type_5,$row->fld_type_6,$row->fld_type_7,$row->fld_type_8,$row->fld_type_9,$row->fld_type_10);

					$arr_fld_desc = array($row->fld_desc_1,$row->fld_desc_2,$row->fld_desc_3,$row->fld_desc_4,$row->fld_desc_5,$row->fld_desc_6,$row->fld_desc_7,$row->fld_desc_8,$row->fld_desc_9,$row->fld_desc_10);

					$arr_file_ttl = array($row->file_ttl_1,$row->file_ttl_2,$row->file_ttl_3,$row->file_ttl_4,$row->file_ttl_5);
					$arr_file_desc = array($row->file_desc_1,$row->file_desc_2,$row->file_desc_3,$row->file_desc_4,$row->file_desc_5);
				}
			}


		// 필수 css/js
		/*
			// 필수 CSS 로드
			load_css('<link rel="stylesheet" type="text/css" href="'. LIB_DIR .'/editor/redactor/redactor.css?v=1" media="screen"/>');
			// 필수 JS 로드
			load_js('<script src="'. LIB_DIR .'/editor/redactor/redactor.min.js"></script>');
			load_js('<script src="'. LIB_DIR .'/editor/redactor/_langs/ko.js"></script>');
			load_js('<script src="'. LIB_DIR .'/editor/redactor/_plugins/table/table.js"></script>');
			load_js('<script src="'. LIB_DIR .'/editor/redactor/_plugins/video/video.js"></script>');
		*/

		// Get data.
			$breadcrumb = array(
				'컨텐츠'=>base_url().'admin/contents',
				'랜딩 페이지 관리'=>''
			);

			$data = array(
				'idx' => $idx,
				'row' => $row,
				'arr_fld_nm' => $arr_fld_nm,
				'arr_fld_chk' => $arr_fld_chk,
				'arr_fld_type' => $arr_fld_type,
				'arr_fld_desc' => $arr_fld_desc,

				'arr_file_ttl' => $arr_file_ttl,
				'arr_file_desc' => $arr_file_desc,

				'arr_seg'   => $this->arr_seg, //$this->uri->segment_array(),
				'breadcrumb'    => $breadcrumb,
				'viewPage'  => 'admin/contents_landing_form_view'
			);

			$this->load->view('admin/layout_view', $data);
	}


	private function _landing_lists()
	{
			// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
			// 페이징 정보 
			// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
			$this->load->library('segment', array('offset'=>4), 'seg'); // 세그먼트 주소( page 위치 )
			$this->load->library('querystring', NULL, 'param'); // 쿼리스트링 주소
			$seg	  =& $this->seg;
			$param	  =& $this->param;
			
			// [페이징]
			$qstr = '';
			
			// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
			// sql 
			// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
			$sql_select = 'idx,title,code,content_top,content_bottom,agree_term,use_yn,sdate,edate,url,fld_nm_1,fld_nm_2,fld_nm_3,fld_nm_4,fld_nm_5,fld_nm_6,fld_nm_7,fld_nm_8,fld_nm_9,fld_nm_10,reg_username,reg_datetime';
			$sql_from = 'mng_landing';
			$sql_where = array('del_datetime' => NULL);
			$sql_group_by = FALSE;
			$sql_order_by = 'idx DESC';

			// 페이징
			$limit = '10';
			$page  = $seg->get('page', 1); // 페이지
			if(! isset($page) OR empty($page)) {
				$page = '1';
			}
			$offset = ($page - 1) * $limit;

			// 검색
			$like_field = FALSE;                         // search
			$like_match = FALSE;
			$like_side = 'both';
			// 조인
			$sql_join_tbl = FALSE;
			$sql_join_on = FALSE;
			$sql_join_option = 'LEFT OUTER';

			// 검색 상관없는 전체 수
			$total_count = $this->basic_model->get_common_count($sql_from,$sql_where);

			$arr = array(
					'sql_select'     => $sql_select,
					'sql_from'       => $sql_from,
					'sql_join_tbl'       => $sql_join_tbl,
					'sql_join_on'        => $sql_join_on,
					'sql_join_option'    => $sql_join_option,
					'like_field'      => $like_field,
					'like_match'      => $like_match,
					'like_side'      => $like_side,
					'sql_where'      => $sql_where, //array('PIDX' => $pidx),
					'sql_group_by'   => $sql_group_by,
					'sql_order_by'   => $sql_order_by,  // $order_field.' DESC, IDX DESC',
					'page'      => $page,
					'limit'      => $limit,
					'offset'      => $offset,
			);
			$result = $this->basic_model->arr_get_result($arr);

			//print_r($result);

			// pagination 설정
			$config['suffix']	   = $qstr; // $param->output();
			$config['base_url']    = base_url() . 'admin/landing/lists/page/';
			$config['per_page']    = $limit;
			$config['total_rows']  = $result['total_count'];
			$config['uri_segment'] = $seg->pos('page');  // 5

			// 검색 목록 ADD
			$btn_prev_part = $btn_next_part = '';
			$config['full_tag_open']  = "<ul class='pagination'>".$btn_prev_part;
			$config['full_tag_close'] = $btn_next_part.'</ul>';

			//$CI =& get_instance();
			//$CI->load->library('pagination', $config);
			$this->load->library('pagination', $config);


			$this->pagination->initialize($config);

			$list = array();
			foreach ($result['qry'] as $i => $row) {

				$list[$i] = new stdClass();

				$list[$i]->num = ($result['total_count'] - $config['per_page']*($page-1) - $i);

				$list[$i]->idx = $row->idx;
				$list[$i]->title = $row->title;
				$list[$i]->code = $row->code;
				$list[$i]->content_top = $row->content_top;
				$list[$i]->content_bottom = $row->content_bottom;
				$list[$i]->agree_term = $row->agree_term;
				$list[$i]->use_yn = $row->use_yn;
				$list[$i]->sdate = $row->sdate;
				$list[$i]->edate = $row->edate;
				$list[$i]->url = $row->url;
				$list[$i]->fld_nm_1 = $row->fld_nm_1;
				$list[$i]->fld_nm_2 = $row->fld_nm_2;
				$list[$i]->fld_nm_3 = $row->fld_nm_3;
				$list[$i]->fld_nm_4 = $row->fld_nm_4;
				$list[$i]->fld_nm_5 = $row->fld_nm_5;
				$list[$i]->fld_nm_6 = $row->fld_nm_6;
				$list[$i]->fld_nm_7 = $row->fld_nm_7;
				$list[$i]->fld_nm_8 = $row->fld_nm_8;
				$list[$i]->fld_nm_9 = $row->fld_nm_9;
				$list[$i]->fld_nm_10 = $row->fld_nm_10;
				$list[$i]->reg_username = $row->reg_username;
				$list[$i]->reg_datetime = $row->reg_datetime;
				$list[$i]->reg_date = substr($row->reg_datetime,0,10);
			}


		// Get data.
			$breadcrumb = array(
				'컨텐츠'=>base_url().'admin/landing',
				'컨텐츠 페이지 목록'=>''
			);

			$data = array(

				'list' => $list,
				'paging' => $this->pagination->create_links(),

				'arr_seg'   => $this->arr_seg, //$this->uri->segment_array(),
				'breadcrumb'    => $breadcrumb,
				'viewPage'  => 'admin/contents_landing_lists_view'
			);

			$this->load->view('admin/layout_view', $data);
	}


	// 개별 랜딩 페이지 접수 목록
	private function _landing_req_code($code=FALSE)
	{
			
			// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
			// 페이징 정보 
			// admin/contents/landing/req_code/[code]/page
			// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
			$this->load->library('segment', array('offset'=>6), 'seg'); // 세그먼트 주소( page 위치 )
			$this->load->library('querystring', NULL, 'param'); // 쿼리스트링 주소
			$seg	  =& $this->seg;
			$param	  =& $this->param;
			
			// [페이징]
			$qstr = '';
			
			// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
			// sql 
			// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
			$sql_select = '*';
			$sql_from = 'landing';
			$sql_where = array('code'=>$code, 'del_datetime' => NULL);
			$sql_group_by = FALSE;
			$sql_order_by = 'idx DESC';

			// 페이징
			$limit = '10';
			$page  = $seg->get('page', 1); // 페이지
			if(! isset($page) OR empty($page)) {
				$page = '1';
			}
			$offset = ($page - 1) * $limit;

			// 검색
			$like_field = FALSE;                         // search
			$like_match = FALSE;
			$like_side = 'both';
			// 조인
			$sql_join_tbl = FALSE;
			$sql_join_on = FALSE;
			$sql_join_option = 'LEFT OUTER';

			// 검색 상관없는 전체 수
			$total_count = $this->basic_model->get_common_count($sql_from,$sql_where);

			$arr = array(
					'sql_select'     => $sql_select,
					'sql_from'       => $sql_from,
					'sql_join_tbl'       => $sql_join_tbl,
					'sql_join_on'        => $sql_join_on,
					'sql_join_option'    => $sql_join_option,
					'like_field'      => $like_field,
					'like_match'      => $like_match,
					'like_side'      => $like_side,
					'sql_where'      => $sql_where, //array('PIDX' => $pidx),
					'sql_group_by'   => $sql_group_by,
					'sql_order_by'   => $sql_order_by,  // $order_field.' DESC, IDX DESC',
					'page'      => $page,
					'limit'      => $limit,
					'offset'      => $offset,
			);
			$result = $this->basic_model->arr_get_result($arr);

			//print_r($result);

			// pagination 설정
			$config['suffix']	   = $qstr; // $param->output();
			$config['base_url']    = base_url() . 'admin/contents/landing/req_code/'.$code.'/page/';  // admin/contents/landing/req/lists/page
			$config['per_page']    = $limit;
			$config['total_rows']  = $result['total_count'];
			$config['uri_segment'] = $seg->pos('page');  // 5

			// 검색 목록 ADD
			$btn_prev_part = $btn_next_part = '';
			$config['full_tag_open']  = "<ul class='pagination'>".$btn_prev_part;
			$config['full_tag_close'] = $btn_next_part.'</ul>';

			//$CI =& get_instance();
			//$CI->load->library('pagination', $config);
			$this->load->library('pagination', $config);


			$this->pagination->initialize($config);

			$list = array();
			foreach ($result['qry'] as $i => $row) {

				$list[$i] = new stdClass();

				$list[$i]->num = ($result['total_count'] - $config['per_page']*($page-1) - $i);

				$list[$i]->idx = $row->idx;
				$list[$i]->type = $row->type;
				$list[$i]->code = $row->code;
				$list[$i]->user_idx = $row->user_idx;
				$list[$i]->name = $row->name;
				$list[$i]->phone = $row->phone;
				$list[$i]->postcode = $row->postcode;
				$list[$i]->addr = $row->addr;
				$list[$i]->addr_detail = $row->addr_detail;

				$list[$i]->ip = $row->ip;
				$list[$i]->created = $row->created;
				$list[$i]->deleted = $row->deleted;

				$list[$i]->reg_date = substr($row->created,0,10);

				/*
				$list[$i]->fld_1 = $row->fld_1;
				$list[$i]->fld_2 = $row->fld_2;
				$list[$i]->fld_3 = $row->fld_3;
				$list[$i]->fld_4 = $row->fld_4;
				$list[$i]->fld_5 = $row->fld_5;
				$list[$i]->fld_6 = $row->fld_6;
				$list[$i]->fld_7 = $row->fld_7;
				$list[$i]->fld_8 = $row->fld_8;
				$list[$i]->fld_9 = $row->fld_9;
				$list[$i]->fld_10 = $row->fld_10;

				$list[$i]->txtfld_1 = $row->txtfld_1;
				$list[$i]->txtfld_2 = $row->txtfld_2;
				$list[$i]->txtfld_3 = $row->txtfld_3;
				$list[$i]->txtfld_4 = $row->txtfld_4;
				$list[$i]->txtfld_5 = $row->txtfld_5;
				*/


				$list[$i]->txtfld[1] = $row->txtfld_1;
				$list[$i]->txtfld[2] = $row->txtfld_2;
				$list[$i]->txtfld[3] = $row->txtfld_3;
				$list[$i]->txtfld[4] = $row->txtfld_4;
				$list[$i]->txtfld[5] = $row->txtfld_5;
				$list[$i]->txtfld[6] = $row->txtfld_6;
				$list[$i]->txtfld[7] = $row->txtfld_7;
				$list[$i]->txtfld[8] = $row->txtfld_8;
				$list[$i]->txtfld[9] = $row->txtfld_9;
				$list[$i]->txtfld[10] = $row->txtfld_10;

				$list[$i]->agree = $row->agree;


				// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
				// [2023-11-23] 캠페인 개설 협약 신청 건
				// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
				//echo $row->txtfld_4.'<br />';
				// 이메일
				// 회원 가입된 이메일인지 확인
				$chk_join_available = $this->tank_auth->is_email_available($row->txtfld_4);
				$list[$i]->chk_join_available = $chk_join_available;


			}

			// print_r($list);




			// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
			// mng_landing sql 
			// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
			$arr = array('sql_select' => '*','sql_from' => 'mng_landing','sql_where' => array('code'=>$code, 'del_datetime' => NULL));
			$mng_row = $this->basic_model->arr_get_row($arr);


			$arr_fld_nm = array();
			$arr_fld_chk = array();
			$arr_fld_type = array();
			if(isset($mng_row->idx)) {
				$arr_fld_nm = array($mng_row->fld_nm_1,$mng_row->fld_nm_2,$mng_row->fld_nm_3,$mng_row->fld_nm_4,$mng_row->fld_nm_5,$mng_row->fld_nm_6,$mng_row->fld_nm_7,$mng_row->fld_nm_8,$mng_row->fld_nm_9,$mng_row->fld_nm_10);
				$arr_fld_chk = array($mng_row->fld_chk_1,$mng_row->fld_chk_2,$mng_row->fld_chk_3,$mng_row->fld_chk_4,$mng_row->fld_chk_5,$mng_row->fld_chk_6,$mng_row->fld_chk_7,$mng_row->fld_chk_8,$mng_row->fld_chk_9,$mng_row->fld_chk_10);
				$arr_fld_type = array($mng_row->fld_type_1,$mng_row->fld_type_2,$mng_row->fld_type_3,$mng_row->fld_type_4,$mng_row->fld_type_5,$mng_row->fld_type_6,$mng_row->fld_type_7,$mng_row->fld_type_8,$mng_row->fld_type_9,$mng_row->fld_type_10);
			}


		// Get data.
			$breadcrumb = array(
				'컨텐츠'=>base_url().'admin/landing',
				'랜딩페이지 관리'=>''
			);

			$landing_title = '';
			if('npo' == $code) {
				$landing_title .= 'NPO 협약 신청 ';
			}
			elseif('comp' == $code) {
				$landing_title .= '기업 제휴 문의 ';
			}

			$landing_title .= '접수 목록';

			$data = array(

				'mng_row' => $mng_row,

				'arr_fld_nm' => $arr_fld_nm,
				'arr_fld_chk' => $arr_fld_chk,
				'arr_fld_type' => $arr_fld_type,


				'landing_title' => $landing_title,
				'code' => $code,

				'list' => $list,
				'paging' => $this->pagination->create_links(),

				'arr_seg'   => $this->arr_seg, //$this->uri->segment_array(),
				'breadcrumb'    => $breadcrumb,
				'viewPage'  => 'admin/contents_landing_req_code_view'
			);

			$this->load->view('admin/layout_view', $data);
	}
		



	private function _landing_req_list()
	{
			
			// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
			// 페이징 정보 
			// admin/contents/landing/req/lists/page
			// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
			$this->load->library('segment', array('offset'=>6), 'seg'); // 세그먼트 주소( page 위치 )
			$this->load->library('querystring', NULL, 'param'); // 쿼리스트링 주소
			$seg	  =& $this->seg;
			$param	  =& $this->param;
			
			// [페이징]
			$qstr = '';
			
			// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
			// sql 
			// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
			$sql_select = 'idx,code,title,content_top,content_bottom,agree_term,use_yn,sdate,edate,url,fld_nm_1,fld_nm_2,fld_nm_3,fld_nm_4,fld_nm_5,fld_nm_6,fld_nm_7,fld_nm_8,fld_nm_9,fld_nm_10,reg_username,reg_datetime';
			$sql_from = 'mng_landing';
			$sql_where = array('del_datetime' => NULL);
			$sql_group_by = FALSE;
			$sql_order_by = 'idx DESC';

			// 페이징
			$limit = '10';
			$page  = $seg->get('page', 1); // 페이지
			if(! isset($page) OR empty($page)) {
				$page = '1';
			}
			$offset = ($page - 1) * $limit;

			// 검색
			$like_field = FALSE;                         // search
			$like_match = FALSE;
			$like_side = 'both';
			// 조인
			$sql_join_tbl = FALSE;
			$sql_join_on = FALSE;
			$sql_join_option = 'LEFT OUTER';

			// 검색 상관없는 전체 수
			$total_count = $this->basic_model->get_common_count($sql_from,$sql_where);

			$arr = array(
					'sql_select'     => $sql_select,
					'sql_from'       => $sql_from,
					'sql_join_tbl'       => $sql_join_tbl,
					'sql_join_on'        => $sql_join_on,
					'sql_join_option'    => $sql_join_option,
					'like_field'      => $like_field,
					'like_match'      => $like_match,
					'like_side'      => $like_side,
					'sql_where'      => $sql_where, //array('PIDX' => $pidx),
					'sql_group_by'   => $sql_group_by,
					'sql_order_by'   => $sql_order_by,  // $order_field.' DESC, IDX DESC',
					'page'      => $page,
					'limit'      => $limit,
					'offset'      => $offset,
			);
			$result = $this->basic_model->arr_get_result($arr);

			//print_r($result);

			// pagination 설정
			$config['suffix']	   = $qstr; // $param->output();
			$config['base_url']    = base_url() . 'admin/contents/landing/req_list/page/';  // admin/contents/landing/req/lists/page
			$config['per_page']    = $limit;
			$config['total_rows']  = $result['total_count'];
			$config['uri_segment'] = $seg->pos('page');  // 5

			// 검색 목록 ADD
			$btn_prev_part = $btn_next_part = '';
			$config['full_tag_open']  = "<ul class='pagination'>".$btn_prev_part;
			$config['full_tag_close'] = $btn_next_part.'</ul>';

			//$CI =& get_instance();
			//$CI->load->library('pagination', $config);
			$this->load->library('pagination', $config);


			$this->pagination->initialize($config);

			$list = array();
			foreach ($result['qry'] as $i => $row) {

				$list[$i] = new stdClass();

				$list[$i]->num = ($result['total_count'] - $config['per_page']*($page-1) - $i);

				$list[$i]->idx = $row->idx;
				$list[$i]->code = $row->code;
				$list[$i]->title = $row->title;
				$list[$i]->content_top = $row->content_top;
				$list[$i]->content_bottom = $row->content_bottom;
				$list[$i]->agree_term = $row->agree_term;
				$list[$i]->use_yn = $row->use_yn;
				$list[$i]->sdate = $row->sdate;
				$list[$i]->edate = $row->edate;
				$list[$i]->url = $row->url;
				$list[$i]->fld_nm_1 = $row->fld_nm_1;
				$list[$i]->fld_nm_2 = $row->fld_nm_2;
				$list[$i]->fld_nm_3 = $row->fld_nm_3;
				$list[$i]->fld_nm_4 = $row->fld_nm_4;
				$list[$i]->fld_nm_5 = $row->fld_nm_5;
				$list[$i]->fld_nm_6 = $row->fld_nm_6;
				$list[$i]->fld_nm_7 = $row->fld_nm_7;
				$list[$i]->fld_nm_8 = $row->fld_nm_8;
				$list[$i]->fld_nm_9 = $row->fld_nm_9;
				$list[$i]->fld_nm_10 = $row->fld_nm_10;
				$list[$i]->reg_username = $row->reg_username;
				$list[$i]->reg_datetime = $row->reg_datetime;
				$list[$i]->reg_date = substr($row->reg_datetime,0,10);
			}


		// Get data.
			$breadcrumb = array(
				'컨텐츠'=>base_url().'admin/landing',
				'랜딩페이지 관리'=>''
			);

			$data = array(

				'list' => $list,
				'paging' => $this->pagination->create_links(),

				'arr_seg'   => $this->arr_seg, //$this->uri->segment_array(),
				'breadcrumb'    => $breadcrumb,
				'viewPage'  => 'admin/contents_landing_req_lists_view'
			);

			$this->load->view('admin/layout_view', $data);
	}




}