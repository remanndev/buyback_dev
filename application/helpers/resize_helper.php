<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


/** - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
 * 마냐님 소스
 * - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -  */

function resize_thumb($filename, $sourcepath=FALSE, $targetpath=FALSE, $width='', $height='', $crop=FALSE, $fix_dim=FALSE) {

	if (!$filename || !$sourcepath || !$targetpath || !$width)
		return FALSE;

	if ($crop) {
		$w = explode(',', $width);
		$h = explode(',', $height);
		$config['x_axis'] = ($w[1] / 2) - ($w[0] / 2);
		$config['y_axis'] = ($h[1] / 2) - ($h[0] / 2);
		$width  = $w[0];
		$height = $h[0];
	}

    $source_file = '/'.$sourcepath.'/'.$filename;
    $thumb_file  = '/'.$sourcepath.'/thumb/'.$width.'px_'.$filename;

    //$source_img_html    = "<img src='".DATA_DIR.$source_file."' alt='이미지'/>";
    $thumb_img_html    = "<img src='".DATA_DIR.$thumb_file."' alt='이미지'/>";

    if (file_exists(DATA_PATH.$thumb_file))
        return $thumb_img_html;

    $config['source_image']   = DATA_PATH.$source_file;
    $config['new_image']      = DATA_PATH.$thumb_file;
    $config['create_thumb']   = TRUE;
    $config['thumb_marker']   = FALSE;
    $config['master_dim']     = 'auto'; //$master_dim; // 'auto';
    $config['maintain_ratio'] = (!$height) ? TRUE : FALSE;
    $config['width']          = $width;
    $config['height']         = (!$height) ? $width : $height;

	$CI =& get_instance();
	$CI->load->library('image_lib');
    $CI->image_lib->initialize($config);

	/*
	if($CI->image_lib->resize()) {
        return $thumb_img_html;
	}
	*/

	$CI =& get_instance();
    $CI->load->library('image_lib');
    $CI->image_lib->initialize($config);
    if (($crop && $CI->image_lib->crop()) || $CI->image_lib->resize())
        return $thumb_img_html;
    else
        return ''; //'이미지 생성에 실패 하였습니다. (jpg,gif,jpeg,png 파일이 아닙니다.)';

}




/** - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
 * 응용 소스
 * - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
 */

function resize_thumb_image($filename, $sourcepath, $targetpath, $width='', $height='', $crop=FALSE, $fix_dim=FALSE, $res='img') {

	if (!$filename || !$width)
        return FALSE;

    if ($crop) {
        $w = explode(',', $width);
        $h = explode(',', $height);

        $crop_x_axis = isset($w[1]) ? $w[1] : $w[0];
        $crop_y_axis = isset($h[1]) ? $h[1] : $h[0];

        $width  = $w[0];
        $height = $h[0];
    }
	$height = (!$height) ? $width : $height;

    $source_file = '/'.$sourcepath.'/'.$filename;
	$source_file_path = DATA_PATH.'/'.$sourcepath.'/'.$filename;

	// [2020-04-14] 레티나 대응
	/*
	$filename_arr = explode('.',$filename);
	$filename_retina = $filename_arr[0].'@2x.'.$filename_arr[1];
	$thumb_file_path_retina = DATA_PATH.'/'.$sourcepath.'/thumb/'.$width.'px_'.$filename_retina;
	*/

    $thumb_file  = '/'.$targetpath.'/'.$width.'px_'.$filename;
	$thumb_file_path = DATA_PATH.'/'.$sourcepath.'/thumb/'.$width.'px_'.$filename;
    $thumb_img_html    = "<img src='".DATA_DIR.$thumb_file."' alt='이미지' class='img-cover' style='width:100%;  max-width:".$width."px;' />";
    $thumb_img_src    = DATA_DIR.$thumb_file;

    $thumb_crop_file  = '/'.$targetpath.'/'.$width.'px_crop_'.$filename;
	$thumb_crop_file_path = DATA_PATH.'/'.$sourcepath.'/thumb/'.$width.'px_crop_'.$filename;
    $thumb_crop_img_html    = "<img src='".DATA_DIR.$thumb_crop_file."' alt='이미지' style='width:100%;  max-width:".$width."px;' />";
    $thumb_crop_img_src    = DATA_DIR.$thumb_crop_file;


	if($crop) {
		if (file_exists($thumb_crop_file_path)) {
			return ('src' == $res) ? $thumb_crop_img_src : $thumb_crop_img_html;
		}
	}
	else {
		if (file_exists($thumb_file_path)) {
			return ('src' == $res) ? $thumb_img_src : $thumb_img_html;
		}
	}



	// 원본과 리사이즈할 이미지의 비율 비교
	if( $fix_dim ) {
		//$master_dim = 'auto';
        if($fix_dim === 'width' OR $fix_dim === 'height')
          $master_dim = $fix_dim;
        else
		  $master_dim = 'auto';
	}
	else {
		$new_ratio = $width/$height;
		$source_size = @getimagesize($source_file_path);
		if (isset($source_size[1])) {
			$org_ratio = $source_size[0]/$source_size[1];

			if($org_ratio > $new_ratio)
				$master_dim = 'height';
			elseif($org_ratio < $new_ratio)
				$master_dim = 'width';
			else
				$master_dim = 'auto';
		}
		else
			$master_dim = 'auto';
	}

	$source_size = @getimagesize($source_file_path);
	if( $source_size[0] >= $source_size[1] ) {
		$master_dim = 'height';
	} else {
		$master_dim = 'width';
	}


    $config['source_image']   = $source_file_path;
    $config['new_image']	  = $thumb_file_path;
    $config['create_thumb']   = TRUE;
    $config['thumb_marker']   = FALSE;
    $config['master_dim']   = $master_dim; // 'auto';
    $config['maintain_ratio'] = TRUE; // (!$height) ? TRUE : FALSE;
    $config['width'] 		  = $width;
    $config['height']		  = (!$height) ? $width : $height;

	$CI =& get_instance();
	$CI->load->library('image_lib');
    $CI->image_lib->initialize($config);

	if($CI->image_lib->resize()) {


		// @2x 파일명을 추가하여 카피
		//@copy($source_file_path, $thumb_file_path_retina);
		//@copy($thumb_file_path, $thumb_file_path_retina);



		if($crop) {

			$config['x_axis'] = $crop_x_axis;
			$config['y_axis'] = $crop_y_axis;

			$thumb_file_path = DATA_PATH.'/'.$sourcepath.'/thumb/'.$width.'px_'.$filename;
			$crop_thumb_file_path = DATA_PATH.'/'.$sourcepath.'/thumb/'.$width.'px_crop_'.$filename;

			// [2020-04-14] 레티나 대응
			//$crop_thumb_file_path_retina = DATA_PATH.'/'.$sourcepath.'/thumb/'.$width.'px_crop_'.$filename_retina;

			$crop_thumb_dir = DATA_DIR.'/'.$sourcepath.'/thumb/'.$width.'px_crop_'.$filename;
			$crop_img_html    = "<img src='".$crop_thumb_dir."' alt='이미지' style='width:100%;  max-width:".$width."px;' />";
			$crop_img_src = $crop_thumb_dir;

			$config['source_image']   = $thumb_file_path;
			$config['new_image']	  = $crop_thumb_file_path;
			$config['create_thumb']   = TRUE;
			$config['thumb_marker']   = FALSE;
			$config['master_dim']   = $master_dim; // 'auto';
			$config['maintain_ratio'] = (!$height) ? TRUE : FALSE;
			$config['width'] 		  = $width;
			$config['height']		  = (!$height) ? $width : $height;

			$CI->image_lib->initialize($config);
			if($CI->image_lib->crop()) {

				// @2x 파일명을 추가하여 카피
				//@copy($thumb_file_path, $crop_thumb_file_path_retina);
				//@copy($crop_thumb_file_path, $crop_thumb_file_path_retina);

				return ('src' == $res) ? $crop_img_src : $crop_img_html;
			}
			else
				return ('src' == $res) ? $thumb_img_src : $thumb_img_html;

		}
		else
			return ('src' == $res) ? $thumb_img_src : $thumb_img_html;
	}
	else
   		return ''; //'이미지 생성에 실패 하였습니다. (jpg,gif,jpeg,png 파일이 아닙니다.)';
}



function resize_thumb_image_crop($filename, $sourcepath, $targetpath, $width='', $height='', $crop=FALSE, $fix_dim=FALSE, $res='img',$crop_width='',$crop_height='',$crop_x_axis='',$crop_y_axis='') {

	if (!$filename || !$width)
        return FALSE;

	/*
    if ($crop) {
        $w = explode(',', $width);
        $h = explode(',', $height);

        $crop_x_axis = isset($w[1]) ? $w[1] : $w[0];
        $crop_y_axis = isset($h[1]) ? $h[1] : $h[0];

        $width  = $w[0];
        $height = $h[0];
    }
	*/

	$height = (!$height) ? $width : $height;

    $source_file = '/'.$sourcepath.'/'.$filename;
	$source_file_path = DATA_PATH.'/'.$sourcepath.'/'.$filename;

	// [2020-04-14] 레티나 대응
	/*
	$filename_arr = explode('.',$filename);
	$filename_retina = $filename_arr[0].'@2x.'.$filename_arr[1];
	$thumb_file_path_retina = DATA_PATH.'/'.$sourcepath.'/thumb/'.$width.'px_'.$filename_retina;
	*/

    $thumb_file  = '/'.$targetpath.'/'.$width.'px_'.$filename;
	$thumb_file_path = DATA_PATH.'/'.$sourcepath.'/thumb/'.$width.'px_'.$filename;
    $thumb_img_html    = "<img src='".DATA_DIR.$thumb_file."' alt='이미지' style='width:100%;  max-width:".$width."px;' />";
    $thumb_img_src    = DATA_DIR.$thumb_file;

    $thumb_crop_file  = '/'.$targetpath.'/'.$crop_width.'px_crop_'.$filename;
	$thumb_crop_file_path = DATA_PATH.'/'.$sourcepath.'/thumb/'.$crop_width.'px_crop_'.$filename;
    $thumb_crop_img_html    = "<img src='".DATA_DIR.$thumb_crop_file."' alt='이미지' style='width:100%;  max-width:".$crop_width."px;' />";
    $thumb_crop_img_src    = DATA_DIR.$thumb_crop_file;


	if($crop) {
		if (file_exists($thumb_crop_file_path)) {
			return ('src' == $res) ? $thumb_crop_img_src : $thumb_crop_img_html;
		}
	}
	else {
		if (file_exists($thumb_file_path)) {
			return ('src' == $res) ? $thumb_img_src : $thumb_img_html;
		}
	}



	// 원본과 리사이즈할 이미지의 비율 비교
	if( $fix_dim ) {
		//$master_dim = 'auto';
        if($fix_dim === 'width' OR $fix_dim === 'height')
          $master_dim = $fix_dim;
        else
		  $master_dim = 'auto';
	}
	else {
		$new_ratio = $width/$height;
		$source_size = @getimagesize($source_file_path);
		if (isset($source_size[1])) {
			$org_ratio = $source_size[0]/$source_size[1];

			if($org_ratio > $new_ratio)
				$master_dim = 'height';
			elseif($org_ratio < $new_ratio)
				$master_dim = 'width';
			else
				$master_dim = 'auto';
		}
		else
			$master_dim = 'auto';
	}

	$source_size = @getimagesize($source_file_path);
	if( $source_size[0] >= $source_size[1] ) {
		$master_dim = 'height';
	} else {
		$master_dim = 'width';
	}


    $config['source_image']   = $source_file_path;
    $config['new_image']	  = $thumb_file_path;
    $config['create_thumb']   = TRUE;
    $config['thumb_marker']   = FALSE;
    $config['master_dim']   = $master_dim; // 'auto';
    $config['maintain_ratio'] = TRUE; // (!$height) ? TRUE : FALSE;
    $config['width'] 		  = $width;
    $config['height']		  = (!$height) ? $width : $height;

	$CI =& get_instance();
	$CI->load->library('image_lib');
    $CI->image_lib->initialize($config);

	if($CI->image_lib->resize()) {


		// @2x 파일명을 추가하여 카피
		//@copy($source_file_path, $thumb_file_path_retina);
		//@copy($thumb_file_path, $thumb_file_path_retina);



		if($crop) {

			$config['x_axis'] = $crop_x_axis;
			$config['y_axis'] = $crop_y_axis;

			$thumb_file_path = DATA_PATH.'/'.$sourcepath.'/thumb/'.$width.'px_'.$filename;
			$crop_thumb_file_path = DATA_PATH.'/'.$sourcepath.'/thumb/'.$crop_width.'px_crop_'.$filename;

			// [2020-04-14] 레티나 대응
			//$crop_thumb_file_path_retina = DATA_PATH.'/'.$sourcepath.'/thumb/'.$width.'px_crop_'.$filename_retina;

			$crop_thumb_dir = DATA_DIR.'/'.$sourcepath.'/thumb/'.$crop_width.'px_crop_'.$filename;
			$crop_img_html    = "<img src='".$crop_thumb_dir."' alt='이미지' style='width:100%;  max-width:".$crop_width."px;' />";
			$crop_img_src = $crop_thumb_dir;

			$config['source_image']   = $thumb_file_path;
			$config['new_image']	  = $crop_thumb_file_path;
			$config['create_thumb']   = TRUE;
			$config['thumb_marker']   = FALSE;
			$config['master_dim']   = $master_dim; // 'auto';
			$config['maintain_ratio'] = (!$crop_height) ? TRUE : FALSE;
			$config['width'] 		  = $crop_width;
			$config['height']		  = (!$crop_height) ? $crop_width : $crop_height;

			$CI->image_lib->initialize($config);
			if($CI->image_lib->crop()) {

				// @2x 파일명을 추가하여 카피
				//@copy($thumb_file_path, $crop_thumb_file_path_retina);
				//@copy($crop_thumb_file_path, $crop_thumb_file_path_retina);

				return ('src' == $res) ? $crop_img_src : $crop_img_html;
			}
			else
				return ('src' == $res) ? $thumb_img_src : $thumb_img_html;

		}
		else
			return ('src' == $res) ? $thumb_img_src : $thumb_img_html;
	}
	else
   		return ''; //'이미지 생성에 실패 하였습니다. (jpg,gif,jpeg,png 파일이 아닙니다.)';
}









function resize_thumb_anything_src($filename=FALSE, $source_dir=FALSE, $width='', $height=FALSE, $crop=FALSE) {
	if (!$filename || !$width)
        return FALSE;



	//$source_file = DATA_PATH.'/file/'.$bo_table.'/'.$filename;
	//$source_file = DOCU_PATH.$source_dir.'/'.$filename;
	$source_file = $source_dir.'/'.$filename;
    $thumb_dir  = '/anything/thumb/'.$width.'px_'.$filename;


	if(is_file($source_file)) {
		$info = @getimagesize($source_file);
	}



	// 리사이징 이미지
	/*
	if(isset($info[1])) {
		// 가로가 긴 이미지
		if($info[0] > $info[1]) {
			// 세로 기준으로 컷
			$width = ($width > $info[1]) ? $width : $info[1];
			$height = $info[1];
		}
		else {
			// 세로가 긴 이미지는 가로 기준으로 컷
			$crop = true;
			$width = $width.','.$width;
			$height = '0,'.$width;
		}
	}
	*/

	// 이미지가 너무 크면 디폴트 이미지가 나오도록 처리
	/*
	if(isset($info[0])  && $info[0] > 12000 OR $info[1] > 24000) {
		//$img_src = IMG_DIR.'/common/blank_image_w600h400.png';
		$img_src = IMG_DIR.'/common/blank_image_600.png';
		return $img_src;
	}
	*/




    if ($crop) {
        $w = explode(',', $width);
        $h = explode(',', $height);

        //$config['x_axis'] = ($w[1] / 2) - ($w[0] / 2);
        //$config['y_axis'] = ($h[1] / 2) - ($h[0] / 2);

        $config['x_axis'] = $w[1];
        $config['y_axis'] = $h[1];
        $width  = $w[0];
        $height = $h[0];
    }



	$img_src = DATA_DIR.$thumb_dir;
	//$img_html    = "<img src='".$img_src."' alt='이미지' style='width:".$width."px;'/>";

	if (file_exists(DATA_PATH.$thumb_dir))
		return $img_src;

    $config['source_image']   = $source_file;
    $config['new_image']	  = DATA_PATH.$thumb_dir;
    $config['create_thumb']   = TRUE;
    $config['thumb_marker']   = FALSE;
    $config['master_dim']   = 'width';
    $config['maintain_ratio'] = (!$height) ? TRUE : FALSE;
    $config['width'] 		  = $width;
    $config['height']		  = (!$height) ? $width : $height;



	$CI =& get_instance();
	$CI->load->library('image_lib');
    $CI->image_lib->initialize($config);



	if($crop && $CI->image_lib->crop()) :
    	return $img_src;
	elseif($CI->image_lib->resize()) :
    	return $img_src;
   	else :
   		//return '이미지 생성에 실패 하였습니다. (jpg,gif,jpeg,png 파일이 아닙니다.)';
		return false;
	endif;

	/*
    if ($CI->image_lib->resize()) :
    	return $img_src;
    elseif ($crop && $CI->image_lib->crop()) :
    	return $img_src;
   	else :
   		//return '이미지 생성에 실패 하였습니다. (jpg,gif,jpeg,png 파일이 아닙니다.)';
		return false;
	endif;

	*/
}

























/** - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
 * [최종] 2020 응용 소스
 * - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
 */


//get_resize_image($file_row->file_name, $file_row->file_dir, $file_row->file_dir.'/thumb', $width='500', $height='250', 'width', 'src', TRUE, '0,300', '0,200');



function get_resize_image($filename, $sourcepath, $targetpath, $width='', $height='', $fix_dim=FALSE, $res='img', $crop=FALSE, $crop_width='', $crop_height='') {

	if (!$filename || !$width)
        return FALSE;


    $source_file = '/'.$sourcepath.'/'.$filename;
	$source_file_path = DATA_PATH.'/'.$sourcepath.'/'.$filename;


	$thumb_name = $width.'px_'.$filename;

    $thumb_file  = '/'.$targetpath.'/'.$thumb_name;
	$thumb_file_path = DATA_PATH.'/'.$sourcepath.'/thumb/'.$width.'px_'.$filename;
    $thumb_img_html    = "<img src='".DATA_DIR.$thumb_file."' alt='이미지' style='width:100%;  max-width:".$width."px;' />";
    $thumb_img_src    = DATA_DIR.$thumb_file;



	$crop_new_src = DATA_PATH.'/'.$targetpath.'/'.$width.'px_crop_'.$filename;
	$crop_new_file = '/'.$targetpath.'/'.$width.'px_crop_'.$filename;
    $crop_new_html    = "<img src='".DATA_DIR.$crop_new_file."' alt='이미지' style='width:100%;  max-width:".$width."px;' />";

	if (file_exists($crop_new_src)) {
		return ('src' == $res) ? $crop_new_src : $crop_new_html;
	}
	else if (file_exists($thumb_file_path)) {
		return ('src' == $res) ? $thumb_img_src : $thumb_img_html;
	}



	// 원본과 리사이즈할 이미지의 비율 비교
	if( $fix_dim ) {
		//$master_dim = 'auto';
        if($fix_dim === 'width' OR $fix_dim === 'height')
          $master_dim = $fix_dim;
        else
		  $master_dim = 'auto';
	}
	else {
		$new_ratio = $width/$height;
		$source_size = @getimagesize($source_file_path);
		if (isset($source_size[1])) {
			$org_ratio = $source_size[0]/$source_size[1];

			if($org_ratio > $new_ratio)
				$master_dim = 'height';
			elseif($org_ratio < $new_ratio)
				$master_dim = 'width';
			else
				$master_dim = 'auto';
		}
		else
			$master_dim = 'auto';
	}

	$source_size = @getimagesize($source_file_path);
	if( $source_size[0] >= $source_size[1] ) {
		$master_dim = 'height';
	} else {
		$master_dim = 'width';
	}


    $config['source_image']   = $source_file_path;
    $config['new_image']	  = $thumb_file_path;
    $config['create_thumb']   = TRUE;
    $config['thumb_marker']   = FALSE;
    $config['master_dim']   = $master_dim; // 'auto';
    $config['maintain_ratio'] = TRUE; // (!$height) ? TRUE : FALSE;
    $config['width'] 		  = $width;
    $config['height']		  = (!$height) ? $width : $height;

	$CI =& get_instance();
	$CI->load->library('image_lib');
    $CI->image_lib->initialize($config);

	if($CI->image_lib->resize()) {


		// @2x 파일명을 추가하여 카피
		//@copy($source_file_path, $thumb_file_path_retina);
		//@copy($thumb_file_path, $thumb_file_path_retina);



		if($crop) {


				/*
				echo $thumb_name.', '.$targetpath.', '.$master_dim.',  src, '.$crop_width.','.$crop_height;

				500px_cb8480480b55aaa99038a88c570e39b0.png
				, board/cctv/files/thumb
				, height
				, src
				, 0,300
				, 0,200

				exit;
				*/


				/*
				echo $thumb_name .'<<<<br />';
				echo $targetpath .'<<<<br />';
				echo $master_dim .'<<<<br />';
				echo 'src <<<<br />';
				echo $crop_width .'<<<<br />';
				echo $crop_height .'<<<<br />';
				exit;

				480px_7052c725e140bef1cbc6ef7b4aa36184.jpg<<<
				board/cctv/files/thumb<<<
				height<<<
				src <<<
				0,300<<<
				0,200<<<
				*/


				//$crop = get_crop_image($thumb_name, $targetpath, $master_dim, $width, 'src', $crop_width,$crop_height);
				//return $crop;




			$w = explode(',', $crop_width);
			$h = explode(',', $crop_height);

			$crop_x_axis = $w[0];
			$crop_y_axis = $h[0];

			$width  = $w[1];
			$height = $h[1];



			$config['x_axis'] = $crop_x_axis;
			$config['y_axis'] = $crop_y_axis;

			$thumb_source_path = DATA_PATH.'/'.$targetpath.'/'.$width.'px_'.$filename;
			//echo $thumb_source_path;
			$crop_new_path = DATA_PATH.'/'.$targetpath.'/'.$width.'px_crop_'.$filename;
			//echo '<br />'.$crop_new_path;
			//exit;

			/*
				/home/watchcam/public_html/data/board/cctv/files/thumb/600px_7052c725e140bef1cbc6ef7b4aa36184.jpg
				/home/watchcam/public_html/data/board/cctv/files/thumb/600px_crop_7052c725e140bef1cbc6ef7b4aa36184.jpg
			*/

			$crop_new_src = DATA_DIR.'/'.$targetpath.'/'.$width.'px_crop_'.$filename;
			$crop_new_html    = "<img src='".$crop_new_src."' alt='이미지' style='width:100%;  max-width:".$width."px;' />";

			/*
			echo $thumb_source_path;
			echo '<br />';
			echo $crop_new_path;
			exit;
			*/

			$config['source_image']   = $thumb_source_path;
			$config['new_image']	  = $crop_new_path;
			$config['create_thumb']   = TRUE;
			$config['thumb_marker']   = FALSE;
			$config['master_dim']   = $master_dim; // 'auto';
			$config['maintain_ratio'] = (!$height) ? TRUE : FALSE;
			$config['width'] 		  = $width;
			$config['height']		  = (!$height) ? $width : $height;

			$CI =& get_instance();
			$CI->load->library('image_lib');
			$CI->image_lib->initialize($config);
			if($CI->image_lib->crop()) {

				// @2x 파일명을 추가하여 카피
				//@copy($thumb_file_path, $crop_thumb_file_path_retina);
				//@copy($crop_thumb_file_path, $crop_thumb_file_path_retina);

				return ('src' == $res) ? $crop_new_src : $crop_new_html;
			}
			else {
				return ('src' == $res) ? $thumb_img_src : $thumb_img_html;
				//return false;
			}



			/*

				$thumb_filename = substr(strrchr($thumb_src, "/"), 1);


				$config['x_axis'] = $crop_x_axis;
				$config['y_axis'] = $crop_y_axis;

				$thumb_file_path = DATA_PATH.'/'.$sourcepath.'/thumb/'.$width.'px_'.$filename;
				$crop_thumb_file_path = DATA_PATH.'/'.$sourcepath.'/thumb/'.$width.'px_crop_'.$filename;

				// [2020-04-14] 레티나 대응
				//$crop_thumb_file_path_retina = DATA_PATH.'/'.$sourcepath.'/thumb/'.$width.'px_crop_'.$filename_retina;

				$crop_thumb_dir = DATA_DIR.'/'.$sourcepath.'/thumb/'.$width.'px_crop_'.$filename;
				$crop_img_html    = "<img src='".$crop_thumb_dir."' alt='이미지' style='width:100%;  max-width:".$width."px;' />";
				$crop_img_src = $crop_thumb_dir;

				$config['source_image']   = $thumb_file_path;
				$config['new_image']	  = $crop_thumb_file_path;
				$config['create_thumb']   = TRUE;
				$config['thumb_marker']   = FALSE;
				$config['master_dim']   = $master_dim; // 'auto';
				$config['maintain_ratio'] = (!$height) ? TRUE : FALSE;
				$config['width'] 		  = $width;
				$config['height']		  = (!$height) ? $width : $height;

				$CI->image_lib->initialize($config);
				if($CI->image_lib->crop()) {

					// @2x 파일명을 추가하여 카피
					//@copy($thumb_file_path, $crop_thumb_file_path_retina);
					//@copy($crop_thumb_file_path, $crop_thumb_file_path_retina);

					return ('src' == $res) ? $crop_img_src : $crop_img_html;
				}
				else
					return ('src' == $res) ? $thumb_img_src : $thumb_img_html;


			*/

		}
		else
			return ('src' == $res) ? $thumb_img_src : $thumb_img_html;
	}
	else
   		return ''; //'이미지 생성에 실패 하였습니다. (jpg,gif,jpeg,png 파일이 아닙니다.)';
}


function get_crop_image($filename, $targetpath, $master_dim, $thumb_width, $res='img', $crop_width='', $crop_height='') {


			/*
				echo $filename.', '.$targetpath.', '.$master_dim.',  src, '.$crop_width.','.$crop_height;

				500px_cb8480480b55aaa99038a88c570e39b0.png
				, board/cctv/files/thumb
				, height
				, src
				, 0,300
				, 0,200

				exit;
			*/


			/*
				echo $thumb_name .'<<<<br />';
				echo $targetpath .'<<<<br />';
				echo $master_dim .'<<<<br />';
				echo 'src <<<<br />';
				echo $crop_width .'<<<<br />';
				echo $crop_height .'<<<<br />';
				exit;

				480px_7052c725e140bef1cbc6ef7b4aa36184.jpg<<<
				board/cctv/files/thumb<<<
				height<<<
				src <<<
				0,300<<<
				0,200<<<
			*/

			$w = explode(',', $crop_width);
			$h = explode(',', $crop_height);

			$crop_x_axis = $w[0];
			$crop_y_axis = $h[0];

			$width  = $w[1];
			$height = $h[1];



			$config['x_axis'] = $crop_x_axis;
			$config['y_axis'] = $crop_y_axis;

			$thumb_file_path = DATA_PATH.'/'.$targetpath.'/'.$thumb_width.'px_'.$filename;
			$crop_thumb_file_path = DATA_PATH.'/'.$targetpath.'/'.$thumb_width.'px_crop_'.$filename;

			$crop_img_src = DATA_DIR.'/'.$targetpath.'/'.$thumb_width.'px_crop_'.$filename;
			$crop_img_html    = "<img src='".$crop_img_src."' alt='이미지' style='width:100%;  max-width:".$width."px;' />";

			/*
			echo $thumb_file_path;
			echo '<br />';
			echo $crop_thumb_file_path;
			exit;
			*/

			$config['source_image']   = $thumb_file_path;
			$config['new_image']	  = $crop_thumb_file_path;
			$config['create_thumb']   = TRUE;
			$config['thumb_marker']   = FALSE;
			$config['master_dim']   = $master_dim; // 'auto';
			$config['maintain_ratio'] = (!$height) ? TRUE : FALSE;
			$config['width'] 		  = $width;
			$config['height']		  = (!$height) ? $width : $height;

			$CI =& get_instance();
			$CI->load->library('image_lib');
			$CI->image_lib->initialize($config);
			if($CI->image_lib->crop()) {

				// @2x 파일명을 추가하여 카피
				//@copy($thumb_file_path, $crop_thumb_file_path_retina);
				//@copy($crop_thumb_file_path, $crop_thumb_file_path_retina);

				return ('src' == $res) ? $crop_img_src : $crop_img_html;
			}
			else {
				//return ('src' == $res) ? $thumb_img_src : $thumb_img_html;
				return false;
			}

}