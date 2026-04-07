<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cpage extends CI_Controller {

	function __construct()
	{
		parent::__construct();

		$this->load->library('tank_auth');
		// $this->load->library('cms_lib');
		// $autoload['helper'] = array('url', 'file', 'common');
		$this->load->helper(array('form', 'load'));
		$this->arr_seg = $this->uri->segment_array();
	}


	/*  /C/P0014/5/%EC%9D%B8%EC%82%AC%EB%A7%90  */
	function _remap($page_code=FALSE,$arr=FALSE)
	{

		if(! $page_code):
			alert('잘못된 경로로 접속하셨습니다.','/');
		endif;


		// [2022-10-14] 관리자 페이지의 컨텐츠 페이지에서 추가한 페이지를 출력시키기 위해 추가
		if( 'code' == $page_code ) {
			// [2022-10-14] 관리자 페이지의 컨텐츠 페이지에서 추가한 페이지를 출력시키기 위해 추가

			$code = (isset($arr[0]) && $arr[0] != '') ? $arr[0] : FALSE;

			if(! $code):
				alert('잘못된 경로로 접속하셨습니다.','/');
			endif;

			// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
			// 생성된 컨텐츠 페이지 정보 가져오기
			// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
			$sql_select = '*';
			$sql_from = 'mng_contents';
			$sql_where = array('code'=>$code,'use_yn'=>'Y','del_datetime'=>NULL);
			// 검색 상관없는 전체 수
			$arr = array(
					'sql_select'     => $sql_select,
					'sql_from'       => $sql_from,
					'sql_where'      => $sql_where
			);
			$row = $this->basic_model->arr_get_row($arr);

			if(! isset($row->idx)):
				alert('잘못된 경로로 접속하셨습니다.','/');

			else :

				// 업로드 파일이 있는 경우, 파일 다운로드로 대체

				$tbl_code = 'mng_contents';
				$get_type='result';  // 'result', 'result_array'
				$sql_from='file_manager';
				$fields='*';
				$join_tbl=FALSE;
				$join_where=FALSE;
				$join_option='left outer';
				$sql_where_form = "wr_table='".$tbl_code."' AND wr_table_idx='". $row->idx ."' AND upload_type='form'";

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
						'sql_order_by'   => $order_field.' '.$order_direction,
						'limit' => 1
				);
				$row_file = $this->basic_model->arr_get_row($arr);


				// 만일 파일이 있다면 파일 다운로드 처리,
				if( isset($row_file->idx) ) 
				{
					$filepath = url_code($row_file->file_dir, 'e');
					$filename = $row_file->file_name;
					$filename_original = $row_file->file_name_org;

					$file_download_link = '/files/download/'. $filepath .'/'. $filename .'/'. $filename_original;

					$file_view_link = '/data/'. $row_file->file_dir .'/'. $filename;

					//redirect($file_link);
				}

			endif;

			
			// 파일이 없다면 등록된 페이지로 이동
			$data = array(
				'row' => $row,
				'page_ttl' => $row->page_title,
				'arr_seg' => $this->arr_seg,
				'viewPage' => 'page_contents_wrap_view'
			);

			
			// 업로드 파일 여부로 구분
			if( isset($file_view_link) && $file_view_link != '' ) {
				// 업로드 파일이 있는 경우,
				$data['file_view_link'] = $file_view_link;
				$data['viewPage'] = 'pdf_viewer';
				$this->load->view('layout_pdf', $data);
			}
			else {
				// 업로드 파일이 없는 경우
				if( isset($file_view_link) && $file_view_link != '' ) {
					$data['file_view_link'] = $file_view_link;
					$data['viewPage'] = 'pdf_viewer';
					$this->load->view('layout_view', $data);
				}
				$this->load->view('layout_view', $data);
			}


		}
		else {

			// 일반적인 페이지 출력

			// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
			// 메뉴 정보 가져오기
			// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
			$cms_arr = array('sql_select' => '*','sql_from' => 'mng_cms','sql_where' => array('page_code'=>$page_code, 'page_type'=>'ctntpage'));
			$cms_row = $this->basic_model->arr_get_row($cms_arr);
			if((! isset($cms_row->page_code) OR $cms_row->del_datetime !== NULL)) {
				alert('이미 삭제되었거나, 존재하지 않는 페이지입니다.', base_url());
			}

			$menu_name = $cms_row->menu_name;
			$idx = $cms_row->page_type_sub;
			$page_uri = (isset($arr[0]) && $arr[0] != '') ? $arr[0] : FALSE;

			if(! $idx):
				alert('잘못된 경로로 접속하셨습니다.','/');
			endif;

			// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
			// 생성된 컨텐츠 페이지 정보 가져오기
			// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
			$sql_select = '*';
			$sql_from = 'mng_contents';
			$sql_where = array('idx'=>$idx,'del_datetime'=>NULL);
			// 검색 상관없는 전체 수
			$arr = array(
					'sql_select'     => $sql_select,
					'sql_from'       => $sql_from,
					'sql_where'      => $sql_where, //array('PIDX' => $pidx),
			);
			$row = $this->basic_model->arr_get_row($arr);

			$data = array(
				'row' => $row,
				'page_ttl' => $page_uri,
				'arr_seg' => $this->arr_seg,
				'viewPage' => 'page_contents_view'
			);

			$this->load->view('layout_view', $data);

		}
	}


}

/* End of file page.php */
/* Location: ./application/controllers/page.php */