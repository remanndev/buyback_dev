<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Sns extends CI_Controller {
	function __construct() {
		parent::__construct();


		/*
		[방성진] [오후 5:03] SNS 계정입니다. 
		KAKAO
		remanncorp@gmail.com  /  kcrc7297@
		네이버
		remanncorp@naver.com   /  kcrc7297@
		*/


		//$this->ci =& get_instance();


		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		// 네이버
		// 참고 : https://developers.naver.com/apps/#/myapps/0I5NQBqV46i6k2ZjDBPC/overview

			$this->nidClientID = ""; //"cHB22IKzRODWkukPVsuL";
			$this->nid_ClientSecret = ""; //"C7w4ranLrK";
			$this->nid_RedirectURL = base_url("sns/naverLogin");


		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		// 카카오
		// 참고 : https://developers.kakao.com/docs/latest/ko/kakaologin/rest-api

			$this->key_restapi = '32e65c3cbe259d246d9077c85f1273e7';
			$this->redirect_uri = base_url('sns/kakaoLogin');
			$this->client_secret = 'xm6G6PO8f5YBJY9mBI9XfdwPMU4gsFES';

			/* [Buyback]
				네이티브 앱 키	c8d72a49bcdde5791057995c0f9d1e90
				REST API 키	32e65c3cbe259d246d9077c85f1273e7
				JavaScript 키	fabffaa87e0bc6a2e4f3a0137ac5ad77
				Admin 키	0af41e9c79e8d3681f4ef010b2382df4
			*/

		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		// 구글
		// [임시] indera.heo@gmail.com
		// 참고 : https://developers.google.com/identity/sign-in/web/sign-in
		// 참고 : https://console.cloud.google.com/apis/credentials


	}



	function googleAuth() {

		// return url 롤 등록했는데, 왜 안될까;;

		/* 
		$rpath_encode = $this->input->post('rpath_encode');
		//$data= array('rpath_encode' => $rpath_encode);
		//$this->load->view('auth/sns_googleAuth',$data);

		$data = array(
			'rpath_encode' => $rpath_encode,
			'arr_seg' => $this->uri->segment_array(),
			'viewPage' => 'auth/sns_googleAuth'
		);

		$this->load->view('_layout_view', $data);

		*/
		redirect('/');


	}

	// 구글 api 설정에서... [https://console.developers.google.com/apis/credentials]
	function googleLogin() {

			$rpath_encode = $this->input->post('rpath_encode');

			$id = $this->input->post('id');
			$fullname = $this->input->post('fullname');
			$givenname = $this->input->post('givenname');
			$familyname = $this->input->post('familyname');
			$imageurl = $this->input->post('imageurl');
			$email = $this->input->post('email');
			$id_token = $this->input->post('id_token');

			if('' != $rpath_encode) {
				$return_url = url_code($rpath_encode, 'd');
			}
			else {
				$return_url = "/";
			}




			// 일단 존재하는 회원인지 확인 후, 가입(SNS 로그인) 처리
			$username_sns = 'g_'.$id;
			$arr = array(
					'sql_select'     => '*',
					'sql_from'       => 'users',
					'sql_where'      => array('username'=>$username_sns),
			);
			$row = $this->basic_model->arr_get_row($arr);
			if(! isset($row->username)) {


				// 가입정보
					$email_activation = $this->config->item('email_activation', 'tank_auth');
					//$activated = (! $email_activation) ? true : false;
					$activated = (! $email_activation) ? 1 : 0;

					if('10' == $o->level) { $group_str = '일반회원'; }
					elseif('20' == $o->level) { $group_str = '협의체회원'; }


					$level = 10; // 회원구분(10:일반회원, 20:협의체회원, 90:관리자)

					$data = array(
						'username'	=> $username_sns,
						'nickname'	=> $fullname,
						'level'	=> $level, // '10',
						//'password'	=> $hashed_password,
						'email'		=> $email,
						'dupinfo'	=> '',

						//'birth'		=> $birth,
						//'mobile'	=> $mobile,
						//'gender'	=> $gender,

						'created'	=> date('Y-m-d H:i:s'),
						'activated'	=> $activated,

						'last_login' => date('Y-m-d H:i:s'),
						'last_ip'	=> $this->input->ip_address(),
						'sns'	=> 'google'
					);

				// 회원 가입처리.
					//$this->db->insert('users', $data);
					if ($this->db->insert('users', $data)) {
						$user_idx = $this->db->insert_id();

						$upro_data = array('user_id' => $user_idx);
						$this->db->set($upro_data);
						$this->db->insert('user_profiles');
					}

			}

			//$user_idx = 'g_idx_'.$id;
			$user_idx = (isset($user_idx)) ? $user_idx : 'g_idx_'.$id;

			$arr = array(
					'sql_select'     => '*',
					'sql_from'       => 'users',
					'sql_where'      => array('username'=>$username_sns),
			);
			$row = $this->basic_model->arr_get_row($arr);
			if(isset($row->id)) {
				$user_idx = $row->id;
			}





			// 로그인 처리
			$this->session->set_userdata(array(
					'user_id'	=> $user_idx,
					'username'	=> $username_sns,
					'nickname'	=> $fullname,
					'email'	=> $email,
					'level'	=> '10', // 일반회원
					'status'	=> '1',
					'login_type' => 'sns',
					'sns_comp' => 'google'
			));

			//  팝업 방식
			//echo '<script>opener.location.reload();</script>';
			//echo '<script>window.close();</script>';

			// 페이지 변경 방식
			echo '<script>location.href="'.$return_url.'";</script>';

	}

	function googleLogout() {


	}










	// + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + +
	// 카카오
	// 참고#https://hyoseung930.tistory.com/88
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

	//function kakaoAuth($rpath_encode=FALSE) {
	/*
	function kakaoAuth($rpath_encode=FALSE) {
		//$this->session->set_userdata('sns_rpath_encode', $rpath_encode);
		$auth_url  = 'https://kauth.kakao.com/oauth/authorize?client_id='.$this->key_restapi.'&redirect_uri='.$this->redirect_uri.'&response_type=code';
		redirect($auth_url );
	}
	*/

	function kakaoAuth($rpath_encode=FALSE) {

		//echo urlencode($rpath_encode);
		//exit;

		//$this->session->set_userdata('sns_rpath_encode', $rpath_encode);

		if($rpath_encode  &&  '' != $rpath_encode) {
			$return_url = url_code($rpath_encode, 'd');
		}
		else {
			$return_url = "/";
		}

		/*
		$auth_url  = 'https://kauth.kakao.com/oauth/authorize?client_id='.$this->key_restapi.'&redirect_uri='.$this->redirect_uri.'&response_type=code&state='.urlencode($return_url);
		//echo $auth_url;
		//exit;

		redirect($auth_url );
		//header("Location: $auth_url");
		exit;
		*/

			// state 파라미터에 redirect 정보를 담아서 콜백 시 복원
			$auth_url = "https://kauth.kakao.com/oauth/authorize?response_type=code"
					  . "&client_id={$this->key_restapi}"
					  . "&redirect_uri=" . urlencode($this->redirect_uri)
					  . "&state=" . urlencode($return_url);

			//echo $auth_url.'<<<<br />';

			header("Location: $auth_url");
			exit;

	}











	//function kakaoLogin($rpath_encode=FALSE) {
	function kakaoLogin() {

		//$rpath_encode = $this->session->userdata('sns_rpath_encode');

		$get_data = $_GET;

		// 콜백 시 전달되는 파라미터
		$code = $_GET['code'] ?? '';
		$state = $_GET['state'] ?? '/';
		//$return_url_after = base_url($state);
		$return_url_after = $state;

		$token_response = $this->request_json(
			'https://kauth.kakao.com/oauth/token',
			array(
				'grant_type' => 'authorization_code',
				'client_id' => $this->key_restapi,
				'redirect_uri' => $this->redirect_uri,
				'code' => $code,
				'client_secret' => $this->client_secret,
			)
		);
		$token_json = $token_response['json'];

		//print_r($token_json);
		//exit;

		$kakao_email_check = 0;
		if (empty($token_json['access_token'])) {
			log_message(
				'error',
				'Kakao token exchange failed: redirect_uri=' . $this->redirect_uri .
				', http_code=' . (int) $token_response['http_code'] .
				', curl_error=' . $token_response['error'] .
				', response=' . substr((string) $token_response['body'], 0, 1000)
			);
			//echo "<script>alert('아이디 정보가 없습니다. 재시도 해주세요.');</script>";
			// alert_close('아이디 정보가 없습니다. 재시도 해주세요.');
			alert('아이디 정보가 없습니다. 재시도 해주세요.',base_url().'auth/login');

			exit();
		} else {

			// [POST] 로그인 회원 정보 가져오기
			$user_info_response = $this->request_json(
				'https://kapi.kakao.com/v2/user/me',
				array(
					'property_keys' => '["kakao_account.email"]',
				),
				array(
					'Authorization: Bearer '.$token_json['access_token'],
				)
			);
			$user_info_json = $user_info_response['json'];

			if (!@$user_info_json['kakao_account']['email']) {
				$this->request_json(
					'https://kapi.kakao.com/v1/user/unlink',
					array(),
					array(
						'Authorization: Bearer '.$token_json['access_token'],
					)
				);

				//alert('필수 정보에 동의하지 않으셨습니다. 로그인을 재시도 해주세요.', '_login');
				alert('필수 정보에 동의하지 않으셨습니다. 로그인을 재시도 해주세요.');
			}

			// [GET] 로그인 회원 정보 가져오기
			$user_info_response = $this->request_json(
				'https://kapi.kakao.com/v2/user/me',
				NULL,
				array(
					'Authorization: Bearer '.$token_json['access_token'],
				)
			);
			$user_arr = $user_info_response['json'];
			/*
				//print_r($user_arr);
				Array ( 
					[id] => 1327759217 
					[connected_at] => 2020-04-05T17:14:59Z 
					[properties] => Array ( [nickname] => D루피 ) 
					[kakao_account] => Array ( [profile_needs_agreement] => [profile] => Array ( [nickname] => D루피 ) [has_email] => 1 [email_needs_agreement] => [is_email_valid] => 1 [is_email_verified] => 1 [email] => incoreain@gmail.com ) )
			*/

			/*
			print_r($user_arr);
			exit;


			Array ( 
				[id] => 2283874689 
				[connected_at] => 2022-10-28T07:18:17Z 
				[properties] => Array ( [nickname] => 허인 ) 
				[kakao_account] => Array ( 
					[profile_nickname_needs_agreement] => 
					[profile] => Array ( [nickname] => 허인 [is_default_nickname] => ) 
					[name_needs_agreement] => 
					[name] => 허인 
					[has_email] => 1 
					[email_needs_agreement] => 
					[is_email_valid] => 1 
					[is_email_verified] => 1 
					[email] => indera.heo@gmail.com 
					[has_phone_number] => 1 
					[phone_number_needs_agreement] => 
					[phone_number] => +82 10-3261-6320
				)
			)


			Array ( 
				[id] => 2232473535 
				[connected_at] => 2025-07-25T03:21:37Z 
				[properties] => Array ( [nickname] => 리맨 ) 
				[kakao_account] => Array ( 
					[profile_nickname_needs_agreement] => 
					[profile] => Array ( [nickname] => 리맨 [is_default_nickname] => ) 
					[name_needs_agreement] => 
					[name] => 허인 
					[has_email] => 1 
					[email_needs_agreement] => 
					[is_email_valid] => 1 
					[is_email_verified] => 1 
					[email] => remanncorp@gmail.com 
					[has_phone_number] => 
					[phone_number_needs_agreement] => ) 
			)

			*/

			$nickname1 = isset($user_arr['properties']['nickname']) ? $user_arr['properties']['nickname'] : $user_arr['id'];
			$nickname2 = isset($user_arr['kakao_account']['profile']['nickname']) ? $user_arr['kakao_account']['profile']['nickname'] : false;
			$nickname3 = isset($user_arr['kakao_account']['name']) ? $user_arr['kakao_account']['name'] : false;
			$nickname = ($nickname3) ? $nickname3 : (($nickname2) ? $nickname2 : $nickname1);
			$email = isset($user_arr['kakao_account']['email']) ? $user_arr['kakao_account']['email'] : false;
			$phone_number = isset($user_arr['kakao_account']['phone_number']) ? $user_arr['kakao_account']['phone_number'] : false;
			$phone = $phone_number ? str_replace('+82 10-','010-',$phone_number) : '*';


			// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
			// 일단 사용중인 이메일인지 확인
			// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
			$arr = array(
					'sql_select'     => '*',
					'sql_from'       => 'users',
					'sql_where'      => array('email'=>$email, 'sns'=>NULL),
			);
			$row = $this->basic_model->arr_get_row($arr);
			if( isset($row->email) && $row->email != '' ) {

				$shell_string = "curl -v -X POST https://kapi.kakao.com/v1/user/logout -H 'Authorization: Bearer ".$token_json['access_token']."'";
				$res = shell_exec($shell_string);
				//print_r($res);

				alert('\n같은 이메일로 가입한 이력이 있습니다.\n이메일 로그인으로 접속해주세요.',base_url().'auth/login');
				return false;
			}
			// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -





			// 일단 존재하는 회원인지 확인 후, 가입(SNS 로그인) 처리
			$username_sns = 'k_'.$user_arr['id'];
			$arr = array(
					'sql_select'     => '*',
					'sql_from'       => 'users',
					'sql_where'      => array('username'=>$username_sns),
			);
			$row = $this->basic_model->arr_get_row($arr);
			if(! isset($row->username)) {


				// 가입정보
					$email_activation = $this->config->item('email_activation', 'tank_auth');
					//$activated = (! $email_activation) ? true : false;
					$activated = (! $email_activation) ? 1 : 0;

					$level = 10; // 회원구분(10:일반회원, 20:협의체회원, 90:관리자)

					$data = array(
						'username'	=> $username_sns,
						'nickname'	=> $nickname,
						'level'	=> $level, // '10',
						//'password'	=> $hashed_password,
						'email'		=> $email,
						'dupinfo'	=> '',

						//'birth'		=> $birth,
						//'mobile'	=> $mobile,
						//'gender'	=> $gender,

						'created'	=> date('Y-m-d H:i:s'),
						'activated'	=> $activated,

						'last_login' => date('Y-m-d H:i:s'),
						'last_ip'	=> $this->input->ip_address(),
						'sns'	=> 'kakao'
					);

				// 회원 가입처리.
					//$this->db->insert('users', $data);
					if ($this->db->insert('users', $data)) {
						$user_idx = $this->db->insert_id();

						//$upro_data = array('user_id' => $user_idx);
						$upro_data = array('user_id' => $user_idx,'phone'=>$phone);
						$this->db->set($upro_data);
						$this->db->insert('user_profiles');
					}

			}
			else {
				// [2024-01-03] 이미 존재하는 회원이면.. 휴대폰 번호 없는 정보 확인하여 업데이트 처리
				$arr = array(
						'sql_select'     => '*',
						'sql_from'       => 'user_profiles',
						'sql_where'      => array('user_id'=>$row->id),
				);
				$row_upro = $this->basic_model->arr_get_row($arr);
				if(IS_NULL($row_upro->phone) OR '' == $row_upro->phone) {
					$this->db->where('user_id', $row->id);
					$this->db->update('user_profiles',array('phone'=>$phone));
				}

				/*
				// 이미 이메일로 카카오 중복 체크를 위에서 했으므로 주석처리
				if(IS_NULL($row->email) OR '' == $row->email) {
					$this->db->where('id', $row->id);
					$this->db->update('users',array('email'=>$email));
				}
				*/

			}



			//$user_idx = 'g_idx_'.$id;
			$user_idx = (isset($user_idx)) ? $user_idx : 'k_idx_'.$user_arr['id'];

			$arr = array(
					'sql_select'     => '*',
					'sql_from'       => 'users',
					'sql_where'      => array('username'=>$username_sns),
			);
			$row = $this->basic_model->arr_get_row($arr);
			if(isset($row->id)) {
				$user_idx = $row->id;
			}








			// 로그인 처리
			$this->session->set_userdata(array(
					'user_id'	=> $user_idx,
					'username'	=> $username_sns,
					'nickname'	=> $nickname,
					'email'	=> $email,
					'level'	=> '10', // 일반회원
					'status'	=> '1',
					'login_type' => 'sns',
					'sns_comp' => 'kakao'
			));

			/*
			// 로그아웃
				$shell_string = "curl -v -X POST https://kapi.kakao.com/v1/user/logout -H 'Authorization: Bearer ".$token_json['access_token']."'";
				$res = shell_exec($shell_string);
				print_r($res);
			*/

			/*
			// 연결 귾기
				$shell_string = "curl -v -X POST https://kapi.kakao.com/v1/user/unlink -H 'Authorization: Bearer ".$token_json['access_token']."'";
				$res = shell_exec($shell_string);
				print_r($res);
			*/





			//  팝업 방식
			//echo '<script>opener.location.reload();</script>';
			//echo '<script>window.close();</script>';

			// 페이지 변경 방식
			// echo '<script>location.href="/";</script>';


			// 그리고 원래 페이지로 이동
			header("Location: $return_url_after");
			exit;
		}

	}









	// + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + +
	// 네이버
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	//function naver_login() {
	function naverAuth() {

		// 네이버 로그인 접근토큰 요청 예제
		  $client_id = $this->nidClientID;
		  $redirectURI = urlencode($this->nid_RedirectURL);
		  $state = "RAMDOM_STATE";
		  $apiURL = "https://nid.naver.com/oauth2.0/authorize?response_type=code&client_id=".$client_id."&redirect_uri=".$redirectURI."&state=".$state;

		redirect($apiURL);
	}

	//function naver_callback() {
	function naverLogin() {

		// 네이버 로그인 콜백 예제
		  $client_id = $this->nidClientID;
		  $client_secret = $this->nid_ClientSecret;
		  $code = $_GET["code"];;
		  $state = $_GET["state"];;
		  $redirectURI = urlencode($this->nid_RedirectURL);
		  $url = "https://nid.naver.com/oauth2.0/token?grant_type=authorization_code&client_id=".$client_id."&client_secret=".$client_secret."&redirect_uri=".$redirectURI."&code=".$code."&state=".$state;
		  $is_post = false;
		  $ch = curl_init();
		  curl_setopt($ch, CURLOPT_URL, $url);
		  curl_setopt($ch, CURLOPT_POST, $is_post);
		  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		  $headers = array();
		  $response = curl_exec ($ch);
		  $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		  //echo "status_code:".$status_code."";
		  curl_close ($ch);

		  /*
		  if($status_code == 200) {
			echo $response;
		  } else {
			echo "Error 내용:".$response;
		  }
		  */


		  if($status_code == 200) {
			//echo $response;

				$res_json = json_decode($response, true);

				$access_token = $res_json['access_token'];
				$refresh_token = $res_json['refresh_token'];
				$token_type = $res_json['token_type'];
				$expires_in = $res_json['expires_in'];



				$token = $access_token;
				$header = "Bearer ".$token; // Bearer 다음에 공백 추가
				$url = "https://openapi.naver.com/v1/nid/me";
				$is_post = false;
				$ch = curl_init();
				curl_setopt($ch, CURLOPT_URL, $url);
				curl_setopt($ch, CURLOPT_POST, $is_post);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				$headers = array();
				$headers[] = "Authorization: ".$header;
				curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
				$response = curl_exec ($ch);
				$status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
				//echo "status_code:".$status_code."<br>";
				curl_close ($ch);
				/*
				if($status_code == 200) {
					echo $response;
				} else {
					echo "Error 내용:".$response;
				}
				*/

				if($status_code == 200) {
					//echo $response;

					$me_json = json_decode($response, true);
					$user = $me_json['response'];
					//print_r($me_json);
					//exit;
					/*
					Array ( 
						[resultcode] => 00 
						[message] => success 
						[response] => Array ( [id] => 5798856 
												[nickname] => 린 
												[email] => riddleme@naver.com 
												[name] => 허인 )
						) 

					*/

					//$user_id = 'naver_'.$user['id'];
					$username = 'naver_'.$user['id'];
					$nickname = isset($user['name']) ? $user['name'] : (isset($user['nickname']) ? $user['nickname'] : $username);
					$email = isset($user['email']) ? $user['email'] : '';



					// 일단 존재하는 회원인지 확인 후, 가입(SNS 로그인) 처리
					$username_sns = 'n_'.$user['id'];
					$arr = array(
							'sql_select'     => '*',
							'sql_from'       => 'users',
							'sql_where'      => array('username'=>$username_sns),
					);
					$row = $this->basic_model->arr_get_row($arr);
					if(! isset($row->username)) {


						// 가입정보
							$email_activation = $this->config->item('email_activation', 'tank_auth');
							//$activated = (! $email_activation) ? true : false;
							$activated = (! $email_activation) ? 1 : 0;

							$level = 10; // 회원구분(10:일반회원, 20:협의체회원, 90:관리자)

							$data = array(
								'username'	=> $username_sns,
								'nickname'	=> $nickname,
								'level'	=> $level, // '10',
								//'password'	=> $hashed_password,
								'email'		=> $email,
								'dupinfo'	=> '',

								//'birth'		=> $birth,
								//'mobile'	=> $mobile,
								//'gender'	=> $gender,

								'created'	=> date('Y-m-d H:i:s'),
								'activated'	=> $activated,

								'last_login' => date('Y-m-d H:i:s'),
								'last_ip'	=> $this->input->ip_address(),
								'sns'	=> 'naver'
							);

						// 회원 가입처리.
							//$this->db->insert('users', $data);
							if ($this->db->insert('users', $data)) {
								$user_idx = $this->db->insert_id();

								$upro_data = array('user_id' => $user_idx);
								$this->db->set($upro_data);
								$this->db->insert('user_profiles');
							}

					}

					//$user_idx = 'g_idx_'.$id;
					$user_idx = (isset($user_idx)) ? $user_idx : 'n_idx_'.$user['id'];

					$arr = array(
							'sql_select'     => '*',
							'sql_from'       => 'users',
							'sql_where'      => array('username'=>$username_sns),
					);
					$row = $this->basic_model->arr_get_row($arr);
					if(isset($row->id)) {
						$user_idx = $row->id;
					}











					// 로그인 처리
					$this->session->set_userdata(array(
							'user_id'	=> $user_idx,
							'username'	=> $username_sns,
							'nickname'	=> $nickname,
							'email'	=> $email,
							'level'	=> '10', // 일반회원
							'status'	=> '1',
							'login_type' => 'sns',
							'sns_comp' => 'naver'
					));


				} else {
					//echo "Error 내용:".$response;
				}



		  } else {
			//echo "Error 내용:".$response;
		  }

		/*
			print_r($_SESSION);
			exit;
			Array ( [] => 
				Array ( 
					[session_id] => 0361bdff050ec92f3162bd9ab105213c 
					[last_activity] => 1586348327 
					[user_id] => naver_5798856 
					[username] => naver_5798856 
					[nickname] => 린 
					[email] => sample@naver.com 
					[level] => 1 
					[status] => 1 
					[login_type] => sns 
					[sns_comp] => naver ) ) 
		*/

		  
		  // 접근 토큰 삭제
		  // https://nid.naver.com/oauth2.0/token?grant_type=delete&client_id={클라이언트 아이디}&client_secret={클라이언트 시크릿}&access_token={접근 토큰}&service_provider=NAVER
		  // 아래 주석을 활성화 시키면, 네이버계정으로 로그인할 때마다 동의를 구하는 팝업창이 뜹니다.
		  /*
			  $url = "https://nid.naver.com/oauth2.0/token?grant_type=delete&client_id=".$client_id."&client_secret=".$client_secret."&access_token=".$token."&service_provider=NAVER";
			  $is_post = false;
			  $ch = curl_init();
			  curl_setopt($ch, CURLOPT_URL, $url);
			  curl_setopt($ch, CURLOPT_POST, $is_post);
			  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			  $headers = array();
			  $response = curl_exec ($ch);
			  $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			  //echo "status_code:".$status_code."";
			  curl_close ($ch);

		  */



		//  팝업 방식
		//echo '<script>opener.location.reload();</script>';
		//echo '<script>window.close();</script>';

		// 페이지 변경 방식
		echo '<script>location.href="/";</script>';

	}

	private function request_json($url, $post_fields = NULL, $headers = array())
	{
		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_TIMEOUT, 30);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, TRUE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);

		if (!empty($headers)) {
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		}

		if ($post_fields !== NULL) {
			curl_setopt($ch, CURLOPT_POST, TRUE);
			curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post_fields));
		}

		$body = curl_exec($ch);
		$error = curl_error($ch);
		$http_code = (int) curl_getinfo($ch, CURLINFO_HTTP_CODE);
		curl_close($ch);

		$json = json_decode((string) $body, TRUE);
		if (!is_array($json)) {
			$json = array();
		}

		return array(
			'body' => (string) $body,
			'json' => $json,
			'http_code' => $http_code,
			'error' => (string) $error,
		);
	}

}
