<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Files extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		/*
		$this->load->database();
		$this->load->model('sample_m');
		$this->load->helper(array('url','date','common'));
		*/

		$this->load->library('tank_auth');
		$this->load->model('upload_model');
	}









	/** - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	 * [다운로드]
	 */

	function download($filepath = FALSE,$filename = FALSE,$filename_original = FALSE) {

		$filepath_decode = url_code($filepath, 'd');


		if($filename) {
			$file_url = DATA_PATH."/".$filepath_decode."/".$filename;
			if (is_file("$file_url")) {
				$files=filesize($file_url);
			} else {
				alert('해당 파일이나 경로가 존재하지 않습니다.');
			}

			if($filename_original) {
				//$filename = $filename_original; // 실제 업로드되기 전의 파일명이 있다면 교체하여 다운로드
				$filename = url_code($filename_original, 'd');

				/*
				// 특수문자는 언더바로..
				$arr_from = array('(',')','-');
				$arr_to   = array('_','_','_');
				$filename = str_replace($arr_from, $arr_to, $filename_original);
				*/
			}

			$this->_file_transact($file_url, "file",$filename,$files);

			//- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
			// 다운로드 횟수 업데이트
			//- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
			//$this->Download_model->insert(HTTP_REFERER, $filepath_decode, $filename, $filename_original);

		}
		else {
			alert('잘못된 접근입니다.');
		}
	}



	private function _file_transact($file_path, $type,$filename="file",$filesize=0) {

		   if($type == "file") {       // 파일다운로드의 경우

				/*
					// 익스플로러
					//echo $_SERVER['HTTP_USER_AGENT'];
					//exit;

					[ie 11]
					Mozilla/5.0 (Windows NT 10.0; WOW64; Trident/7.0; rv:11.0) like Gecko
					[ie Edge]
					Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/51.0.2704.79 Safari/537.36 Edge/14.14393
					[chrome]
					Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36
					[ff]
					Mozilla/5.0 (Windows NT 10.0; WOW64; rv:51.0) Gecko/20100101 Firefox/51.0
				*/

				$ie = FALSE;
				$userAgent = $_SERVER["HTTP_USER_AGENT"];
				if ( preg_match("/MSIE*/", $userAgent) ) {
					// 익스플로러
					$ie = TRUE;
				} elseif ( preg_match("/Trident*/", $userAgent ) && preg_match("/rv:11.0*/", $userAgent) &&  preg_match("/Gecko*/", $userAgent) ) {
					//$browser = "Explorer 11";
					$ie = TRUE;
				} elseif ( preg_match("/Edge*/", $userAgent) ) {
					$ie = TRUE;
				}

				if( $ie ) { // 브라우져 구분
					$filename = urlencode($filename); // 파일명이나 경로에 한글이나 공백이 포함될 경우를 고려
					Header("Content-Type: doesn/matter");
					Header("Content-Length: $filesize");   // 이부부을 넣어 주어야지 다운로드 진행 상태가 표시 됩니다.
					Header("Content-Disposition: inline; filename=$filename");
					Header("Content-Transfer-Encoding: binary");
					Header("Pragma: no-cache");
					Header("Expires: 0");
				} else {
					Header("Content-type: file/unknown");
					Header("Content-Length: $filesize");
					Header("Content-Disposition: attachment; filename=$filename");
					Header("Content-Description: PHP3 Generated Data");
					Header("Pragma: no-cache");
					Header("Expires: 0");
				}

		   } else {
				  header("Content-type: $type");
				  header("Pragma: no-cache");
				  header("Expires: 0");
		   }
		   if (is_file("$file_path")) {


				$this->load->helper('download');
				$data = file_get_contents($file_path); // Read the file's contents
				force_download($filename, $data);


				/*
				  $fp = fopen("$file_path", "r");
				  if (!fpassthru($fp))  // 서버부하를 줄이려면 print 나 echo 또는 while 문을 이용한 기타 보단 이방법이...
						 fclose($fp);
				*/

				/* 참고
					ob_clean();
					flush();
					readfile($filepath);
				*/

		   } else {
				  echo "해당 파일이나 경로가 존재하지 않습니다.";
		   }
	}














	/** - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	 * [업로드]
	 */
	function upload_basic($upload_folder="upload/files") {

		// This is a simplified example, which doesn't cover security of uploaded files.
		// This example just demonstrate the logic behind the process.

		// files storage folder
		//$dir = '/sitecom/files/';

		$upload_dir = DATA_DIR.'/'.$upload_folder.'/';
		$upload_path = realpath(FCPATH).DATA_DIR.'/'.$upload_folder.'/';

		if(isset($_FILES["myfile"]))
		{
			//Filter the file types , if you want.
			if ($_FILES["myfile"]["error"] > 0)
			{
			  echo "Error: " . $_FILES["file"]["error"] . "<br>";
			}
			else
			{
				//move the uploaded file to uploads folder;
				move_uploaded_file($_FILES["myfile"]["tmp_name"],$upload_path. $_FILES["myfile"]["name"]);

			 echo "Uploaded File :".$_FILES["myfile"]["name"];
			}

		}

	}

	// redactor 3
	function upload($upload_type=FALSE,$encoded_upload_folder=FALSE,$wr_table='',$wr_table_idx='',$width_limit=false)
	{


			// [2019-01-29] upload 시에 flashdata 가 사라지는 듯 해서, 한 번 더 세팅..
			$time = $this->session->flashdata('captcha_time');
			$word = $this->session->flashdata('captcha_word');

			// Save captcha params in session
			$this->session->set_flashdata(array(
					'captcha_word' => $word,
					'captcha_time' => $time
			));


			if( 'popup' === $wr_table ) {
				$wr_table = 'mng_popup';
			}

			if('redactor_image' === $upload_type)
			{
					//$this->_redactor_image($encoded_upload_folder,$wr_table,$wr_table_idx,$width_limit);

					// 업로드 경로 특정
					$upload_folder = ($encoded_upload_folder) ? url_code($encoded_upload_folder,'d') : "upload/images";
					$upload_dir = DATA_DIR.'/'.$upload_folder.'/';
					$upload_path = DATA_PATH.'/'.$upload_folder.'/';

					$dir = $upload_path;


					//$files = [];
					//$types = ['image/png', 'image/jpg', 'image/gif', 'image/jpeg', 'image/pjpeg'];

					$files = array();
					$types = array('image/png', 'image/jpg', 'image/gif', 'image/jpeg', 'image/pjpeg');

					if (isset($_FILES['file']))
					{

						foreach ($_FILES['file']['name'] as $key => $name)
						{
							$type = strtolower($_FILES['file']['type'][$key]);
							if (in_array($type, $types))
							{
								// setting file's mysterious name
								$filename_org = $_FILES['file']['tmp_name'][$key];

								$arrtmpname = explode('.',$name);
								$cnttmpname = count($arrtmpname);
								$file_ext = $arrtmpname[$cnttmpname-1];

								//$filename = md5(date('YmdHis')).'.jpg';
								$filename = md5(date('YmdHis').mt_rand()).'.'.$file_ext;
								$path = $dir.$filename;

								//$filename_apple = md5(date('YmdHis')).'@2x.'.$file_ext;
								//$path_apple = $dir.$filename_apple;

								// copying
								move_uploaded_file($filename_org, $path);
								//@copy($path, $path_apple);

								$source_size = @getimagesize($path);

								//echo $_FILES['file']['size'][$key];

								// 업로드 데이타 가져오기
								//$upload_data = $this->upload->data();
								$upload_data = array(
									'file_name' => $filename,
									'orig_name' => $name,
									'file_size' => $_FILES['file']['size'][$key],
									'is_image' => 'image',
									'image_width' => (isset($source_size[0]) ? $source_size[0] : ''),
									'image_height' => (isset($source_size[1]) ? $source_size[1] : '')
								);

								// 고유 세션 정보
								$user_idx = $this->tank_auth->get_user_id();
								$file_write_sess = $this->session->userdata('ss_file_'.$user_idx);

								// 파일 관리 디비에 저장
								$data = array(
									'wr_sess'       => $file_write_sess,
									'wr_table'         => $wr_table,
									'wr_table_idx'     => $wr_table_idx,
									'user_idx'      => $user_idx,
									'upload_type'   => 'editor',
									'upload_gubun'   => 'image',
									'file_name'     => $upload_data['file_name'],
									'file_name_org' => $upload_data['orig_name'],
									'file_dir'      => $upload_folder,
									'file_size'     => $upload_data['file_size'],
									'file_type'     => ($upload_data['is_image']) ? 'image' : 'file',
									'img_width'     => $upload_data['image_width'],
									'img_height'    => $upload_data['image_height'],
									'datetime_upload'  => TIME_YMDHIS
									);
								$res = $this->upload_model->insert_file_manager($data);




								/*
								$files['file-'.$key] = array(
									'url' => '/tmp/images/'.$filename.'.jpg', 'id' => $id
								);
								*/

								$files['file-'.$key] = array(
									'url' => $upload_dir.$filename,
									'id' => isset($res['idx']) ? $res['idx'] : ''
								);
							}
						}
					}


			}
			elseif('redactor_file' === $upload_type)
			{
					//$this->_redactor_file($encoded_upload_folder,$wr_table,$wr_table_idx,$width_limit);

					// 업로드 경로 특정
					$upload_folder = ($encoded_upload_folder) ? url_code($encoded_upload_folder,'d') : "upload/files";
					$upload_dir = DATA_DIR.'/'.$upload_folder.'/';
					$upload_path = DATA_PATH.'/'.$upload_folder.'/';

					$dir = $upload_path;


					// This is a simplified example, which doesn't cover security of uploaded files.
					// This example just demonstrate the logic behind the process.

					//$files = [];
					$files = array();

					if (isset($_FILES['file']))
					{
						foreach ($_FILES['file']['name'] as $key => $name)
						{
							//move_uploaded_file($_FILES['file']['tmp_name'][$key], '/my-files/'.$name);

							// setting file's mysterious name
							$filename_org = $_FILES['file']['tmp_name'][$key];

							$arrtmpname = explode('.',$name);
							$cnttmpname = count($arrtmpname);
							$file_ext = $arrtmpname[$cnttmpname-1];

							//$filename = md5(date('YmdHis')).'.jpg';
							$filename = md5(date('YmdHis')).'.'.$file_ext;
							$path = $dir.$filename;

							// copying
							move_uploaded_file($filename_org, $path);





								// 업로드 데이타 가져오기
								//$upload_data = $this->upload->data();
								$upload_data = array(
									'file_name' => $filename,
									'orig_name' => $name,
									'file_size' => $_FILES['file']['size'][$key],
									'is_image' => 'file',
									'image_width' => '',
									'image_height' => ''
								);

								// 고유 세션 정보
								$user_idx = $this->tank_auth->get_user_id();
								$file_write_sess = $this->session->userdata('ss_file_'.$user_idx);

								$file_type_chk = 'file';
								if( $upload_data['image_width'] > 0 ) {
									$file_type_chk = 'image';
									$upload_data['is_image'] = 'image';
								}

								// 파일 관리 디비에 저장
								$data = array(
									'wr_sess'       => $file_write_sess,
									'wr_table'         => $wr_table,
									'wr_table_idx'     => $wr_table_idx,
									'user_idx'      => $user_idx,
									'upload_type'   => 'editor',
									'upload_gubun'   => 'file',
									'file_name'     => $upload_data['file_name'],
									'file_name_org' => $upload_data['orig_name'],
									'file_dir'      => $upload_folder,
									'file_size'     => $upload_data['file_size'],
									'file_type'     => $upload_data['is_image'],
									'img_width'     => $upload_data['image_width'],
									'img_height'    => $upload_data['image_height'],
									'datetime_upload'  => TIME_YMDHIS
									);
								$res = $this->upload_model->insert_file_manager($data);

							/*
							$files['file-'.$key] = [
								'url' => $upload_dir.$filename,
								'name' => $name,
								'id' => md5(date('YmdHis'))
							];
							*/

							$files['file'] = array(
								'url' => $upload_dir.$filename,
								'name' => $name,
								'id' => isset($res['idx']) ? $res['idx'] : ''
							);

						}
					}


			}
			elseif('item_image' === $upload_type)
			{
					//$this->_redactor_image($encoded_upload_folder,$wr_table,$wr_table_idx,$width_limit);

					// $wr_table = 'products';
					// $wr_table_idx => 제품 인덱스

					// 업로드 경로 특정
					$upload_folder = ($encoded_upload_folder) ? url_code($encoded_upload_folder,'d') : "upload/images";
					$upload_dir = DATA_DIR.'/'.$upload_folder.'/';
					$upload_path = DATA_PATH.'/'.$upload_folder.'/';

					$dir = $upload_path;


					//$files = [];
					//$types = ['image/png', 'image/jpg', 'image/gif', 'image/jpeg', 'image/pjpeg'];

					$files = array();
					$types = array('image/png', 'image/jpg', 'image/gif', 'image/jpeg', 'image/pjpeg');

					if (isset($_FILES['file']))
					{

						//foreach ($_FILES['file']['name'] as $key => $name)
						//{
							//$type = strtolower($_FILES['file']['type'][$key]);
							$type = strtolower($_FILES['file']['type']);
							// $prd_idx = strtolower($_POST['prd_idx']);
							$no = strtolower($_POST['no']);  // 썸네일 이미지 번호
							$file_idx = strtolower($_POST['file_idx']); // 파일 인덱스 번호
							if (in_array($type, $types))
							{
								// setting file's mysterious name
								//$filename_org = $_FILES['file']['tmp_name'][$key];
								$filename_org = $_FILES['file']['tmp_name'];

								$name = $_FILES['file']['name'];

								$arrtmpname = explode('.',$name);
								$cnttmpname = count($arrtmpname);
								$file_ext = $arrtmpname[$cnttmpname-1];

								//$filename = md5(date('YmdHis')).'.jpg';
								$filename = md5(date('YmdHis')).'.'.$file_ext;
								$path = $dir.$filename;

								// copying
								move_uploaded_file($filename_org, $path);

								$source_size = @getimagesize($path);

								// 업로드 데이타 가져오기
								//$upload_data = $this->upload->data();
								$upload_data = array(
									'file_name' => $filename,
									'orig_name' => $name,
									//'file_size' => $_FILES['file']['size'][$key],
									'file_size' => $_FILES['file']['size'],
									'is_image' => 'image',
									'image_width' => (isset($source_size[0]) ? $source_size[0] : ''),
									'image_height' => (isset($source_size[1]) ? $source_size[1] : '')
								);

								// 고유 세션 정보
								$user_idx = $this->tank_auth->get_user_id();
								$file_write_sess = $this->session->userdata('ss_file_'.$user_idx);


								$sql_from = 'file_manager';
								//$sql_where = array('wr_table'=>$wr_table,'wr_table_idx'=>$wr_table_idx,'order'=>$no);
								$sql_where = array('wr_table'=>$wr_table,'wr_table_idx'=>$wr_table_idx,'gubun'=>'thumb');
								//$order_cnt = $this->basic_model->get_common_count($sql_from, $sql_where);
								$thumb_cnt = $this->basic_model->get_common_count($sql_from, $sql_where);

								// 신규
								//if('' == $wr_table_idx) // 제품 인덱스
								//if('' == $wr_table_idx  OR  ! $order_cnt  OR  $order_cnt < 1) // 제품 썸네일 번호로 등록된 것이 있는 지 체크. 없으면..
								if('' == $wr_table_idx  OR  ! $thumb_cnt  OR  $thumb_cnt < 10) // 제품 썸네일 번호로 등록된 것이 있는 지 체크. 없으면..
								{

										//$where_arr = array('wr_table'=>$wr_table,'wr_table_idx'=>$wr_table_idx);
										$where_arr = array('wr_table'=>$wr_table,'wr_table_idx'=>$wr_table_idx,'gubun'=>'thumb');
										$max_no = $this->basic_model->get_max($sql_from,$where_arr,'order');
										$new_no = $max_no + 1;

										// 파일 관리 디비에 저장
										$data = array(
											'wr_sess'       => $file_write_sess,
											'wr_table'         => $wr_table,
											'wr_table_idx'     => $wr_table_idx,
											'user_idx'      => $user_idx,
											'upload_type'   => 'form',
											'upload_gubun'   => 'image',
											'order' => $new_no, // $no
											'file_name'     => $upload_data['file_name'],
											'file_name_org' => $upload_data['orig_name'],
											'file_dir'      => $upload_folder,
											'file_size'     => $upload_data['file_size'],
											'file_type'     => ($upload_data['is_image']) ? 'image' : 'file',
											'img_width'     => $upload_data['image_width'],
											'img_height'    => $upload_data['image_height'],
											'gubun'         => 'thumb',
											'datetime_upload'  => TIME_YMDHIS
											);
										$this->upload_model->insert_file_manager($data);

								}
								// 수정
								else {

										// 파일 관리 디비에 저장
										$data = array(
											'wr_sess'       => '',
											'wr_table'         => $wr_table,
											'wr_table_idx'     => $wr_table_idx,
											'user_idx'      => $user_idx,
											//'upload_type'   => 'form',
											//'upload_gubun'   => 'image',
											//'order' => $no,
											'file_name'     => $upload_data['file_name'],
											'file_name_org' => $upload_data['orig_name'],
											'file_dir'      => $upload_folder,
											'file_size'     => $upload_data['file_size'],
											'file_type'     => ($upload_data['is_image']) ? 'image' : 'file',
											'img_width'     => $upload_data['image_width'],
											'img_height'    => $upload_data['image_height'],
											'gubun'         => 'thumb',
											'datetime_upload'  => TIME_YMDHIS
											);
										$this->upload_model->edit_file_manager($data,'items',$wr_table_idx,$no,$file_index);
								}


								/*
								$files['file-'.$key] = array(
									'url' => '/tmp/images/'.$filename.'.jpg', 'id' => $id
								);
								*/

								/*
								$files['file-'.$key] = array(
									'url' => $upload_dir.$filename
								);
								*/

								$files['file'] = array('url' => $upload_dir.$filename);
							}
						//}
					}



			}

			elseif('product_image' === $upload_type)
			{
					//$this->_redactor_image($encoded_upload_folder,$wr_table,$wr_table_idx,$width_limit);

					// $wr_table = 'products';
					// $wr_table_idx => 제품 인덱스

					// 업로드 경로 특정
					$upload_folder = ($encoded_upload_folder) ? url_code($encoded_upload_folder,'d') : "upload/images";
					$upload_dir = DATA_DIR.'/'.$upload_folder.'/';
					$upload_path = DATA_PATH.'/'.$upload_folder.'/';

					$dir = $upload_path;


					//$files = [];
					//$types = ['image/png', 'image/jpg', 'image/gif', 'image/jpeg', 'image/pjpeg'];

					$files = array();
					$types = array('image/png', 'image/jpg', 'image/gif', 'image/jpeg', 'image/pjpeg');

					if (isset($_FILES['file']))
					{

						//foreach ($_FILES['file']['name'] as $key => $name)
						//{
							//$type = strtolower($_FILES['file']['type'][$key]);
							$type = strtolower($_FILES['file']['type']);
							// $prd_idx = strtolower($_POST['prd_idx']);
							$no = strtolower($_POST['no']);  // 썸네일 이미지 번호
							$file_idx = strtolower($_POST['file_idx']); // 파일 인덱스 번호
							if (in_array($type, $types))
							{
								// setting file's mysterious name
								//$filename_org = $_FILES['file']['tmp_name'][$key];
								$filename_org = $_FILES['file']['tmp_name'];

								$name = $_FILES['file']['name'];

								$arrtmpname = explode('.',$name);
								$cnttmpname = count($arrtmpname);
								$file_ext = $arrtmpname[$cnttmpname-1];

								//$filename = md5(date('YmdHis')).'.jpg';
								$filename = md5(date('YmdHis')).'.'.$file_ext;
								$path = $dir.$filename;

								// copying
								move_uploaded_file($filename_org, $path);

								$source_size = @getimagesize($path);

								// 업로드 데이타 가져오기
								//$upload_data = $this->upload->data();
								$upload_data = array(
									'file_name' => $filename,
									'orig_name' => $name,
									//'file_size' => $_FILES['file']['size'][$key],
									'file_size' => $_FILES['file']['size'],
									'is_image' => 'image',
									'image_width' => (isset($source_size[0]) ? $source_size[0] : ''),
									'image_height' => (isset($source_size[1]) ? $source_size[1] : '')
								);

								// 고유 세션 정보
								$user_idx = $this->tank_auth->get_user_id();
								$file_write_sess = $this->session->userdata('ss_file_'.$user_idx);


								$sql_from = 'file_manager';
								//$sql_where = array('wr_table'=>$wr_table,'wr_table_idx'=>$wr_table_idx,'order'=>$no);
								$sql_where = array('wr_table'=>$wr_table,'wr_table_idx'=>$wr_table_idx,'gubun'=>'thumb');
								//$order_cnt = $this->basic_model->get_common_count($sql_from, $sql_where);
								$thumb_cnt = $this->basic_model->get_common_count($sql_from, $sql_where);

								// 신규
								//if('' == $wr_table_idx) // 제품 인덱스
								//if('' == $wr_table_idx  OR  ! $order_cnt  OR  $order_cnt < 1) // 제품 썸네일 번호로 등록된 것이 있는 지 체크. 없으면..
								if('' == $wr_table_idx  OR  ! $thumb_cnt  OR  $thumb_cnt < 5) // 제품 썸네일 번호로 등록된 것이 있는 지 체크. 없으면..
								{

										//$where_arr = array('wr_table'=>$wr_table,'wr_table_idx'=>$wr_table_idx);
										$where_arr = array('wr_table'=>$wr_table,'wr_table_idx'=>$wr_table_idx,'gubun'=>'thumb');
										$max_no = $this->basic_model->get_max($sql_from,$where_arr,'order');
										$new_no = $max_no + 1;

										// 파일 관리 디비에 저장
										$data = array(
											'wr_sess'       => $file_write_sess,
											'wr_table'         => $wr_table,
											'wr_table_idx'     => $wr_table_idx,
											'user_idx'      => $user_idx,
											'upload_type'   => 'form',
											'upload_gubun'   => 'image',
											'order' => $new_no, // $no
											'file_name'     => $upload_data['file_name'],
											'file_name_org' => $upload_data['orig_name'],
											'file_dir'      => $upload_folder,
											'file_size'     => $upload_data['file_size'],
											'file_type'     => ($upload_data['is_image']) ? 'image' : 'file',
											'img_width'     => $upload_data['image_width'],
											'img_height'    => $upload_data['image_height'],
											'gubun'         => 'thumb',
											'datetime_upload'  => TIME_YMDHIS
											);
										$this->upload_model->insert_file_manager($data);

								}
								// 수정
								else {

										// 파일 관리 디비에 저장
										$data = array(
											'wr_sess'       => '',
											'wr_table'         => $wr_table,
											'wr_table_idx'     => $wr_table_idx,
											'user_idx'      => $user_idx,
											//'upload_type'   => 'form',
											//'upload_gubun'   => 'image',
											//'order' => $no,
											'file_name'     => $upload_data['file_name'],
											'file_name_org' => $upload_data['orig_name'],
											'file_dir'      => $upload_folder,
											'file_size'     => $upload_data['file_size'],
											'file_type'     => ($upload_data['is_image']) ? 'image' : 'file',
											'img_width'     => $upload_data['image_width'],
											'img_height'    => $upload_data['image_height'],
											'gubun'         => 'thumb',
											'datetime_upload'  => TIME_YMDHIS
											);
										$this->upload_model->edit_file_manager($data,'products',$wr_table_idx,$no,$file_index);
								}


								/*
								$files['file-'.$key] = array(
									'url' => '/tmp/images/'.$filename.'.jpg', 'id' => $id
								);
								*/

								/*
								$files['file-'.$key] = array(
									'url' => $upload_dir.$filename
								);
								*/

								$files['file'] = array('url' => $upload_dir.$filename);
							}
						//}
					}



			}





			// This is a simplified example, which doesn't cover security of uploaded images.
			// This example just demonstrate the logic behind the process.

			// files storage folder
			//$dir = '/sitecom/images/';
			

			// 업로드 경로 특정
			/*
			$upload_folder = ($encoded_upload_folder) ? url_code($encoded_upload_folder,'d') : "upload/images";
			$upload_dir = DATA_DIR.'/'.$upload_folder.'/';
			$upload_path = DATA_PATH.'/'.$upload_folder.'/';
			*/

			echo stripslashes(json_encode($files));


	}




	// redactor 1
	function __upload($type=FALSE,$encoded_upload_folder=FALSE,$wr_table='',$wr_table_idx='',$width_limit=false)
	{

		// [2019-01-29] upload 시에 flashdata 가 사라지는 듯 해서, 한 번 더 세팅..
		$time = $this->session->flashdata('captcha_time');
		$word = $this->session->flashdata('captcha_word');

		// Save captcha params in session
		$this->session->set_flashdata(array(
				'captcha_word' => $word,
				'captcha_time' => $time
		));


		if( 'popup' === $wr_table ) {
			$wr_table = 'mng_popup';
		}
		elseif( 'survey' === $wr_table ) {
			$wr_table = 'WL_SURVEY';
		}
		elseif( 'survey_form' === $wr_table ) {
			$wr_table = 'WL_SURVEY_FORM';
		}

		if('redactor_image' === $type)
		{
			$this->_redactor_image($encoded_upload_folder,$wr_table,$wr_table_idx,$width_limit);
		}
		elseif('redactor_file' === $type)
		{
			$this->_redactor_file($encoded_upload_folder,$wr_table,$wr_table_idx,$width_limit);
		}
	}




	/**
	 * REDACTOR editor
	 */
    private function _redactor_image($encoded_upload_folder=FALSE,$wr_table='',$wr_table_idx='',$width_limit=false) {

			// 업로드 경로 특정
			$upload_folder = ($encoded_upload_folder) ? url_code($encoded_upload_folder,'d') : "upload/images";
			$upload_dir = DATA_DIR.'/'.$upload_folder.'/';
			$upload_path = DATA_PATH.'/'.$upload_folder.'/';

            // 업로드 변수 설정
            $config['upload_path'] = $upload_path;
            $config['max_size'] = '10240';
            $config['max_width']  = '0'; // 5120
            $config['max_height']  = '0'; // 5120
            $config['remove_spaces']  = TRUE;  // TRUE로 설정하면 파일명에 공백이 있을경우 밑줄(_)로 변경. 권장 옵션.
            $config['overwrite']  = FALSE;
			$config['allowed_types'] = 'png|jpg|gif|jpeg|pjpeg|bmp'; // '*'
            $config['encrypt_name']  = TRUE;  // TRUE로 설정하면 파일이름은 랜덤하게 암호화된 문자열로 변환.
			//$new_file_name = date('YmdHis', time()).randstrlower2(10);
			//$config['file_name'] = $new_file_name;

            $this->load->library('upload', $config);

			$field_name = 'file';
            if( $this->upload->do_upload($field_name) ) {

					// 업로드 데이타 가져오기
					$upload_data = $this->upload->data();

					// [2020-04-14] 레티나 대응
					// @2x 파일명을 추가하여 카피
					/*
					$img_file = $upload_data['full_path'];
					$new_file = $upload_data['file_path'].$upload_data['raw_name'].'@2x'.$upload_data['file_ext'];
					@copy($img_file, $new_file);
					*/


					// 고유 세션 정보
					$user_idx = $this->tank_auth->get_user_id();
					$file_write_sess = $this->session->userdata('ss_file_'.$user_idx);

					// 파일 관리 디비에 저장
					$data = array(
						'wr_sess'       => $file_write_sess,
						'wr_table'         => $wr_table,
						'wr_table_idx'     => $wr_table_idx,
						'user_idx'      => $user_idx,
						'upload_type'   => 'editor',
						'upload_gubun'   => 'image',
						'file_name'     => $upload_data['file_name'],
						'file_name_org' => $upload_data['orig_name'],
						'file_dir'      => $upload_folder,
						'file_size'     => $upload_data['file_size'],
						'file_type'     => ($upload_data['is_image']) ? 'image' : 'file',
						'img_width'     => $upload_data['image_width'],
						'img_height'    => $upload_data['image_height'],
						'datetime_upload'  => TIME_YMDHIS
						);
					$this->upload_model->insert_file_manager($data);



					// 업로드 된 파일의 상대 위치
					$filelink = $upload_dir . $upload_data['file_name'];

                    // 에디터 출력
					$array = array(
                        'filelink' => $filelink,
                        'class' => $upload_data['file_name']
                    );
					echo stripslashes(json_encode($array));
            }
			else {
					echo json_encode(array('error' => $this->upload->display_errors('', '')));
					/*
					// 에러 발생시, 관리자에게만 에러 내용을 표시
					$error_msg = $this->upload->display_errors('<p>', '</p>');
					$alert_msg = $this->upload->display_errors('', '');
					if( SU_ADMIN ) {
						echo $error_msg;
						//alert($alert_msg);
						//exit;
					}
					*/

			}

			$this->upload->initialize($config);
	}





    private function _redactor_file($encoded_upload_folder=FALSE,$wr_table,$wr_table_idx) {

			// 업로드 경로 특정
			$upload_folder = ($encoded_upload_folder) ? url_code($encoded_upload_folder,'d') : "upload/files";
			$upload_dir = DATA_DIR.'/'.$upload_folder.'/';
			$upload_path = DATA_PATH.'/'.$upload_folder.'/';

            // 업로드 변수 설정
            $config['upload_path'] = $upload_path;
            $config['max_size']	= '10240';
            $config['max_width']  = '0'; // 5120
            $config['max_height']  = '0'; // 5120
            $config['remove_spaces']  = TRUE;  // TRUE로 설정하면 파일명에 공백이 있을경우 밑줄(_)로 변경. 권장 옵션.
            $config['overwrite']  = FALSE;
            $config['allowed_types'] = '*';  // 'png|jpg|gif|jpeg|pjpeg|bmp|csv|txt|pdf|zip|ppt|pptx|doc|docx|xlsx|word|hwp'
            $config['encrypt_name']  = TRUE;  // TRUE로 설정하면 파일이름은 랜덤하게 암호화된 문자열로 변환.
            //$new_file_name = date('YmdHis', time()).randstrlower2(10);
			//$config['file_name'] = $new_file_name;

            $this->load->library('upload', $config);

			$field_name = 'file';
            if( $this->upload->do_upload($field_name) ) {

					// 업로드 데이타 가져오기
					$upload_data = $this->upload->data();

					// 고유 세션 정보
					$user_idx = $this->tank_auth->get_user_id();
					$file_write_sess = $this->session->userdata('ss_file_'.$user_idx);

					// 파일 관리 디비에 저장
					$data = array(
						'wr_sess'       => $file_write_sess,
						'wr_table'         => $wr_table,
						'wr_table_idx'     => $wr_table_idx,
						'user_idx'      => $user_idx,
						'upload_type'   => 'editor',
						'upload_gubun'   => 'file',
						'file_name'     => $upload_data['file_name'],
						'file_name_org' => $upload_data['orig_name'],
						'file_dir'      => $upload_folder,
						'file_size'     => $upload_data['file_size'],
						'file_type'     => ($upload_data['is_image']) ? 'image' : 'file',
						'img_width'     => $upload_data['image_width'],
						'img_height'    => $upload_data['image_height'],
						'datetime_upload'  => TIME_YMDHIS
						);
					$this->upload_model->insert_file_manager($data);


					// 업로드 된 파일의 상대 위치
					//$filelink = $upload_dir . $upload_data['file_name'];

					// [2017-12-13] 업로드 된 파일의 상대 위치 다운로드 파일 통해서 원제목으로 다운로드
					//$filelink = base_url() . 'files/download/'. url_code($upload_folder,'e') .'/'. $upload_data['file_name'] .'/'. url_code(remove_special_word($upload_data['orig_name'],'.'),'e');
					$filelink = base_url() . 'files/download/'. url_code($upload_folder,'e') .'/'. $upload_data['file_name'] .'/'. url_code(remove_special_word($upload_data['orig_name'],'.'),'e');


                    $array = array(
                        'filelink' => $filelink,
                        'filename' => $upload_data['orig_name'],
                        'class' => $upload_data['file_name']
                    );
					echo stripslashes(json_encode($array));
            }
			else {
					echo json_encode(array('error' => $this->upload->display_errors('', '')));
					/*
					// 에러 발생시, 관리자에게만 에러 내용을 표시
					$error_msg = $this->upload->display_errors('<p>', '</p>');
					$alert_msg = $this->upload->display_errors('', '');
					if( SU_ADMIN ) {
						echo $error_msg;
						//alert($alert_msg);
						//exit;
					}
					*/
			}
			$this->upload->initialize($config);
	}











	/**
	 * SUMMERNOTE editor
	 * [주의!] 커스트마이징 해야 함..
	 */
    function summernote($encoded_upload_folder=FALSE,$wr_table,$wr_table_idx,$width_limit=FALSE) {

            // 업로드 경로 특정
            if($encoded_upload_folder):
              $upload_folder = url_code($encoded_upload_folder,'d');
            else :
			  $upload_folder = "summernote";
            endif;


			$upload_dir = DATA_DIR.'/'.$upload_folder.'/';
			$upload_path = DATA_PATH.'/'.$upload_folder.'/';

            /** -------------------------------------------------------------------------------------------------
             * 이미지 업로드
             * 업로드 기본 경로 : /data/redactor/images
             * ------------------------------------------------------------------------------------------------- */

            // 업로드 변수 설정
            $config['upload_path'] = $upload_path;
            $config['max_size']	= '10240';
            $config['max_width']  = '0';
            $config['max_height']  = '0';
            $config['encrypt_name']  = FALSE;  // TRUE로 설정하면 파일이름은 랜덤하게 암호화된 문자열로 변환.
            $config['remove_spaces']  = TRUE;  // TRUE로 설정하면 파일명에 공백이 있을경우 밑줄(_)로 변경. 권장 옵션.
            $config['overwrite']  = FALSE;

            $new_file_name = date('YmdHis', time()).randstrlower2(10);
			$config['file_name'] = $new_file_name;

			$config['allowed_types'] = 'png|jpg|gif|jpeg|pjpeg|bmp';

            $this->load->library('upload', $config);

			$field_name='file';
            $upload_ok = $this->upload->do_upload($field_name);

            // REDACTOR 관련
            if( $upload_ok ) {

					// 업로드 데이타 가져오기
					$upload_data = $this->upload->data();

					// 업로드 된 파일의 상대 위치
					$filelink = $upload_dir . $upload_data['file_name'];

					// jquery ajax 에서 success 의 response 값을 못가져오길래 검색해보니,
					// 요 아래 코드를 ajax 페이지에서 호출하는 페이지에 넣어주라고 함.
					header("Content-type: text/html; charset=utf-8");

					echo stripslashes($filelink);
            }
			else {
					echo json_encode(array('error' => $this->upload->display_errors('', '')));
					/*
					// 에러 발생시, 관리자에게만 에러 내용을 표시
					$error_msg = $this->upload->display_errors('<p>', '</p>');
					$alert_msg = $this->upload->display_errors('', '');
					if( SU_ADMIN ) {
						echo $error_msg;
						//alert($alert_msg);
						//exit;
					}
					*/
			}


			$this->upload->initialize($config);

	}





}