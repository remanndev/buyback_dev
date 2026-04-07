<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Basic
 */
class Basic_lib
{
	function __construct()
	{
		$this->ci =& get_instance();
		// $this->ci->load->model('basic_model'); // autoload
	}



	// 기관 및 단체명으로 정보 가져오기
	public function call_npo_name($stx=FALSE) {

		if($stx)
		{
			$sql_arr = array(
					'sql_select'     => 'idx, npo_name',
					'sql_from'       => 'npo_list',
					'sql_where'      => array('idx >= '=>1),
					'like_field'     => 'npo_name',
					'like_match'     => trim($stx),
					'like_side'     => 'both',
					'sql_order_by'   => 'npo_name ASC',
			);
			$result = $this->ci->basic_model->arr_get_result($sql_arr);

			return $result;
		}
		else {
			return NULL;

		}



	}


	// 기관 및 단체명으로 정보 가져오기
	public function call_npo_info($idx=FALSE) {

		if($idx)
		{
			$sql_arr = array(
					'sql_select'     => '*',
					'sql_from'       => 'npo_list',
					'sql_where'      => array('idx'=>$idx)
			);
			$row = $this->ci->basic_model->arr_get_row($sql_arr);

			return $row;
		}
		else {
			return NULL;

		}



	}


	public function arr_user_list($arr=FALSE) 
	{

		//print_r($arr);

		$list = array('total_count'=>0, 'qry'=>array());

		if($arr) {
			$result = $this->ci->basic_model->arr_get_result($arr);
			$list['total_count'] = $result['total_count'];

			foreach ($result['qry'] as $i => $row) {

				$list['qry'][$i] = new stdClass();
				$list['qry'][$i]->num = ($result['total_count'] - $arr['limit']*($arr['page']-1) - $i);

				//print_r($row);

				$list['qry'][$i]->user_idx = $row->user_idx;
				$list['qry'][$i]->username = $row->username;
				$list['qry'][$i]->nickname = $row->nickname;
				$list['qry'][$i]->email = $row->email;
				$list['qry'][$i]->activated = $row->activated;
				$list['qry'][$i]->level = $row->level;
				$list['qry'][$i]->banned = $row->banned;
				$list['qry'][$i]->ban_reason = $row->ban_reason;
				$list['qry'][$i]->sleep_email = $row->sleep_email;
				$list['qry'][$i]->sleep_state = $row->sleep_state;

				$list['qry'][$i]->last_ip = $row->last_ip;
				$list['qry'][$i]->last_login = $row->last_login;
				$list['qry'][$i]->created = $row->created;
				$list['qry'][$i]->modified = $row->modified;


				$join_route = '일반가입';
				if( isset($row->sns) ) {
					if($row->sns == NULL) {
						$join_route = '일반가입';
					} else {
						$join_route = '<button type="button" class="btn btn-warning btn-xs" style="font-weight: bold; color: #000000; letter-spacing: 1px;" disabled>'.strtoupper($row->sns).'</button>';
					}
				}
				$list['qry'][$i]->sns = $join_route;


				if($arr['sql_from'] == 'users')
				{
					$list['qry'][$i]->country = $row->country;
					$list['qry'][$i]->website = $row->website;
					$list['qry'][$i]->birth = $row->birth;
					$list['qry'][$i]->phone = $row->phone;
					$list['qry'][$i]->tel = $row->tel;
					$list['qry'][$i]->fax = $row->fax;

					$list['qry'][$i]->postcode = $row->postcode;
					$list['qry'][$i]->addr = $row->addr;
					$list['qry'][$i]->addr_detail = $row->addr_detail;

					$list['qry'][$i]->company = $row->company;
					$list['qry'][$i]->manager = $row->manager;
				}
			}
		}

		return ( ! empty($list)) ? $list : false;
	}





	// 사용자가 봇인지 여부 확인
	function isBot($user_agent) {
		// 일반적인 봇 문자열 패턴
		$bot_patterns = array(
			'bot',
			'Bot',
			'crawl',
			'Crawl',
			'spider',
			'Spider',
			'google',
			'Google',
			'bing',
			'Bing',
			'yahoo',
			'Yahoo',
			'yeti',
			'Yeti',
			'slurp',
			'Slurp',
			'yandex',
			'Yandex',
		);

		foreach ($bot_patterns as $pattern) {
			if (stripos($user_agent, $pattern) !== false) {
				return true;
			}
		}

		return false;
	}



	//function is_bot($ip_address, $user_agent) {
	function is_bot($user_agent) {

	  /*
	  // 봇으로 알려진 IP 주소 목록
	  $bot_ips = array(
		"127.0.0.1", // 예시
		"192.168.1.1", // 예시
	  );
	  */

	  // 봇 사용자 에이전트 문자열 목록
	  $bot_user_agents = array(
		"Googlebot",
		"Bingbot",
		"Baiduspider",
		"YandexBot",
		"Slurp",
		"DuckDuckBot",
	  );

	  /*
	  // IP 주소 검사
	  if (in_array($ip_address, $bot_ips)) {
		return true;
	  }
	  */

	  // 사용자 에이전트 문자열 검사
	  foreach ($bot_user_agents as $bot_user_agent) {
		if (strpos($user_agent, $bot_user_agent) !== false) {
		  return true;
		}
	  }

	  // 봇으로 판단되지 않음
	  return false;

	}




}