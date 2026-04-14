<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Mypage extends CI_Controller
{
	function __construct()
	{
		parent::__construct();

		$this->load->helper(array('form', 'url','load'));
		$this->load->library('form_validation');
		$this->load->helper('security');
		$this->load->helper('resize');
		$this->load->library('tank_auth');
		$this->lang->load('tank_auth');

		$this->load->library('campaign_lib');
		$this->load->library('board_lib');
		$this->load->model('Buyback_model');
		//$this->load->library('upload_lib');
		//$this->load->model('Upload_model');

		// 로그인이 필요한 페이지!!!
		if (! $this->tank_auth->is_logged_in()) {
			//echo $this->uri->uri_string();
			//exit;
			//redirect('/auth/login/'. url_code('/'.$this->uri->uri_string(), 'e'));
			redirect('/auth/login/'. url_code( current_url(), 'e'));
		}
		else if( $this->tank_auth->is_admin() ) {
			//alert('관리자님은 관리자 페이지를 이용해주세요~ ^^');
			redirect('/admin/');
		}
		
		$this->user_idx = $this->tank_auth->get_user_id();
		$this->username = $this->tank_auth->get_username();
		$this->user = $this->tank_auth->get_userinfo($this->username);
		$this->arr_seg = $this->uri->segment_array();
	}

	function index()
	{
		/*
		echo FCPATH .'_sess/'.'<br />'; 
		echo '메인 페이지';
		*/

		/*
		if (! $this->tank_auth->is_logged_in()) {
			redirect('/auth/login/'. url_code( current_url(), 'e'));
		} else {
			$data['user_id']	= $this->tank_auth->get_user_id();
			$data['username']	= $this->tank_auth->get_username();
			//$this->load->view('main', $data);

			$data['viewPage'] = 'main';
			$this->load->view('layout_view', $data);
		}
		*/

		redirect('/mypage/main');

	}

	function main()
	{

		//print_r($this->user);
		//exit;

		if( isset($this->user->level) && $this->user->level == '20' ) {
			redirect('/mypage/campaign/lists');
		}
		else {
			redirect('/mypage/donation/lists');
		}
	}







	// + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + +
	// 협의체 회원 전용 캠페인 관리 페이지
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	function campaign($method="lists",$cidx=FALSE,$flag1=FALSE,$flag2=FALSE) 
	{
		load_js('<script src="'. JS_DIR .'/campaign_script.js"></script>');

		if('lists' == $method) {
			$this->campaign_lists();
		}
		else if('write' == $method) {
			$this->campaign_write($cidx);
		}
		else if('info' == $method) {
			$this->campaign_info($cidx);
		}
		else if('del' == $method) {
			$this->campaign_delete($cidx);
		}
		else if('submit' == $method) {
			$this->campaign_submit($cidx);
		}
		else if('recover' == $method) {
			$this->campaign_recover($cidx);
		}

		else if('campaign_donate_lists' == $method) {
			$this->campaign_donate_lists($cidx);
		}
		else if('campaign_donate_detail' == $method) {
			$this->campaign_donate_detail($cidx,$flag1,$flag2);
		}
	}


	
	// 기부 신청 내역
	//private function campaign_donate_detail($cidx,$flag1,$flag2)
	private function campaign_donate_detail($cmp_code=FALSE,$donate_idx=FALSE,$user_idx=FALSE)
	{

			//if(! $donate_idx || ! $user_idx) {
			if(! $donate_idx) {
				//alert('존재하지 않거나 삭제된 캠페인입니다.',base_url().'admin/donate/detail/'.$cmp_code);
				alert('존재하지 않거나 삭제된 캠페인입니다.');
				exit;
			}



			// 캠페인 정보
			$arr_where = array(
					'sql_select'     => '*',
					'sql_from'       => 'campaign',
					'sql_where'      => array('code'=>$cmp_code)
			);
			$cmp_row = $this->basic_model->arr_get_row($arr_where);

			$cmp_row->cmp_term = $cmp_row->cmp_term_begin.'~'.$cmp_row->cmp_term_end;
			$cmp_row->reg_date = substr($cmp_row->reg_datetime,0,10);

			$cmp_row->state = $cmp_row->state;
			$state_str = '<button class="btn o_btn btn-xs btn-silver-flat" disabled>작성</button>';
			if('submit' == $cmp_row->state) :
				$state_str = '<button class="btn o_btn btn-xs btn-success-flat">제출</button>';
			elseif('launch' == $cmp_row->state) :
				$state_str = '<button class="btn o_btn btn-xs btn-primary-flat">런칭</button>';
			endif;
			$cmp_row->state_str = $state_str;



			// 기부자 정보
			$arr_where = array(
					'sql_select'     => '*',
					'sql_from'       => 'donation',
					'sql_where'      => array('idx'=>$donate_idx)
			);
			$dn_row = $this->basic_model->arr_get_row($arr_where);

			/*
				// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
				// 기부 물품 현재 상태
				$state_good_proc = '접수 완료';

				//echo $dn_row->state_reg.'<<<br />';

				$state_good_proc = ('완료' == $dn_row->state_reg) ? '접수 완료' : '접수 중';

				if('' != $dn_row->pickup_date) {
					$state_good_proc = ('완료' == $dn_row->state_pickup) ? '수거 완료' : '수거 중';
				}
				if('' != $dn_row->check_date) {
					$state_good_proc = ('완료' == $dn_row->state_check) ? '검수 완료' : '검수 중';
				}
				if('' != $dn_row->recycle_date) {
					$state_good_proc = ('완료' == $dn_row->state_recycle) ? '재생 완료' : '재생 중';
				}
				if('' != $dn_row->handout_date) {
					$state_good_proc = ('완료' == $dn_row->state_handout) ? '나눔 완료1' : '나눔 중';
				}
				if('' != $dn_row->handout_finish_date) {
					$state_good_proc = ('완료' == $dn_row->state_handout_finish) ? '나눔 완료3' : '나눔 완료2';
				}
				$dn_row->state_good_proc = $state_good_proc;

			*/





			// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
			// 기부 물품 현재 상태
			// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
			$state_good_proc = '접수 완료';

			$dn_row->state_reg_txt = '';
			$dn_row->state_pickup_txt = '';
			$dn_row->state_check_txt = '';
			$dn_row->state_recycle_txt = '';
			$dn_row->state_handout_txt = '';
			$dn_row->state_handout_finish_txt = '';

			// echo $dn_row->state_reg.'<<<br />';

			$state_good_proc = ('1' == $dn_row->state_reg) ? '접수 완료' : '접수 중';
			$dn_row->state_reg_txt = $state_good_proc;

			if('' != $dn_row->pickup_date && '1' == $dn_row->state_reg) {
				$state_good_proc = ('1' == $dn_row->state_pickup) ? '수거 완료' : '수거 중';
				$dn_row->state_pickup_txt = $state_good_proc;
			}
			if('' != $dn_row->check_date && '1' == $dn_row->state_pickup) {
				$state_good_proc = ('1' == $dn_row->state_check) ? '검수 완료' : '검수 중';
				$dn_row->state_check_txt = $state_good_proc;
			}
			if('' != $dn_row->recycle_date && '1' == $dn_row->state_check) {
				$state_good_proc = ('1' == $dn_row->state_recycle) ? '재생 완료' : '재생 중';
				$dn_row->state_recycle_txt = $state_good_proc;
			}
			/*
			if('' != $dn_row->handout_date && '1' == $dn_row->state_recycle) {
				$state_good_proc = ('1' == $dn_row->state_handout) ? '나눔 완료1' : '나눔 중';
				$dn_row->state_handout_txt = $state_good_proc;
			}
			if('' != $dn_row->handout_finish_date && '1' == $dn_row->state_handout) {
				$state_good_proc = ('1' == $dn_row->state_handout_finish) ? '나눔 완료3' : '나눔 완료2';
				$dn_row->state_handout_finish_txt = $state_good_proc;
			}
			*/

			if('' != $dn_row->handout_date && '1' == $dn_row->state_recycle) {
				$state_good_proc = ('1' == $dn_row->state_handout) ? '나눔 완료' : '나눔 중';
				$dn_row->state_handout_txt = $state_good_proc;
			}

			$dn_row->state_good_proc = $state_good_proc;

			// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - //










			$arr_donor_type = explode(':',$dn_row->donor_type);
			$donor_type_text = isset($arr_donor_type[1]) ? $arr_donor_type[1] : '';
			$donor_type_code = isset($arr_donor_type[0]) ? $arr_donor_type[0] : '';
			$dn_row->donor_type_text = $donor_type_text;
			$dn_row->donor_type_code = $donor_type_code;

			$dn_row->addr_detail = str_replace('<주소끝>','',$dn_row->addr_detail);

			$dn_row->donation_comma = ( $dn_row->donation_value > 0 ) ? number_format($dn_row->donation_value) : '';


			// 기부관리 대상 (런칭)캠페인 목록 가져오기
			$arr_where = array(
					'sql_select'     => '*',
					'sql_from'       => 'donation_goods',
					'sql_where'      => array('dn_idx'=>$donate_idx,'user_idx'=>$user_idx),
					'sql_order_by'   => 'idx asc'
			);
			$gd_result = $this->basic_model->arr_get_result($arr_where);




			//print_r($gd_result);
			$list = array();
			$ino = 0;
			foreach($gd_result['qry'] as $key => $row) {

				//print_r($row);

				$list[$ino] = new stdClass();

				// 번호
				//$num = ($gd_result['total_count'] - $limit*($page-1) - $ino);
				$num = ($gd_result['total_count'] - $ino);
				$list[$ino]->num = $num;

				$list[$ino]->idx = $row->idx;
				$list[$ino]->user_idx = $row->user_idx;
				$list[$ino]->dn_idx = $row->dn_idx;

				//$list[$ino]->user_username = $row->user_username;

				$list[$ino]->gd_type = $row->gd_type;
				$list[$ino]->gd_amt = $row->gd_amt;
				$list[$ino]->gd_grade = $row->gd_grade;

				$list[$ino]->gd_maker = $row->gd_maker;
				$list[$ino]->gd_model = $row->gd_model;
				$list[$ino]->gd_part = $row->gd_part;
				$list[$ino]->gd_memo = $row->gd_memo;

				$list[$ino]->reg_datetime = $row->reg_datetime;
				$list[$ino]->reg_date = substr($row->reg_datetime,0,10);

				$list[$ino]->reg_ip = $row->reg_ip;

				$ino++;

			}




			// 페이지
			$viewPage = 'mypage/campaign_donate_detail_view';

			// 데이터 - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
			$data = array(
				'cmp_row' => $cmp_row,
				'dn_row' => $dn_row,
				'dngoods_list' => $list,
				'arr_seg'   => $this->arr_seg, //$this->uri->segment_array(),
				'viewPage' => $viewPage
			);
			$this->load->view('layout_view', $data);
	}



	// 기부 신청 내역
	private function campaign_donate_lists($cidx)
	{



			// 캠페인 정보
			$arr_where = array(
					'sql_select'     => '*',
					'sql_from'       => 'campaign',
					'sql_where'      => array('idx'=>$cidx)
			);
			$cmp_row = $this->basic_model->arr_get_row($arr_where);
			$cmp_row->cmp_term = $cmp_row->cmp_term_begin.' ~ '.$cmp_row->cmp_term_end;
			$cmp_row->reg_date = substr($cmp_row->reg_datetime,0,10);

			$cmp_row->state = $cmp_row->state;
			$state_str = '<button class="btn o_btn btn-xs btn-silver-flat" disabled>작성</button>';
			if('submit' == $cmp_row->state) :
				$state_str = '<button class="btn o_btn btn-xs btn-success-flat">제출</button>';
			elseif('launch' == $cmp_row->state) :
				$state_str = '<button class="btn o_btn btn-xs btn-primary-flat">런칭</button>';
			endif;
			$cmp_row->state_str = $state_str;


			// 캠페인별(주관단체별) 기부가치 합산 금액
			$arr_where_dnval = array(
					'sql_select'     => 'sum(donation_value) as totVal',
					'sql_from'       => 'donation',
					'sql_where'      => array('cmp_code'=>$cmp_row->code,'delete'=>NULL),
			);
			$dnval_row = $this->basic_model->arr_get_row($arr_where_dnval);
			$dnval_tot_val = $dnval_row->totVal;
			$cmp_row->dnval_tot_val = ($dnval_tot_val > 0) ? number_format($dnval_tot_val).'원' : '';






			// 기부관리 대상 (런칭)캠페인 목록 가져오기
			//echo $cmp_row->idx ."<br />";
			$arr_where = array(
					'sql_select'     => '*',
					'sql_from'       => 'donation',
					'sql_where'      => array('cmp_idx'=>$cidx),
					'sql_order_by'   => 'reg_datetime DESC'
			);
			$dn_result = $this->basic_model->arr_get_result($arr_where);

			//print_r($dn_result);
			$dn_list = array();
			$jno = 0;
			foreach($dn_result['qry'] as $j => $dn_row) {

				//print_r($dn_row);

				$dn_list[$jno] = new stdClass();

				// 번호
				//$num = ($dn_result['total_count'] - $limit*($page-1) - $jno);
				$dn_num = ($dn_result['total_count'] - $jno);
				$dn_list[$jno]->num = $dn_num;

				$dn_list[$jno]->idx = $dn_row->idx;
				$dn_list[$jno]->cmp_code = $dn_row->cmp_code;
				$dn_list[$jno]->user_idx = $dn_row->user_idx;
				$dn_list[$jno]->user_username = $dn_row->user_username;

				$dn_list[$jno]->donor_type = $dn_row->donor_type;
				$dn_list[$jno]->company = $dn_row->company;
				$dn_list[$jno]->donor_name = $dn_row->donor_name;
				$dn_list[$jno]->cellphone = $dn_row->cellphone;
				$dn_list[$jno]->email = $dn_row->email;
				$dn_list[$jno]->postcode = $dn_row->postcode;
				$dn_list[$jno]->addr = $dn_row->addr;
				$dn_list[$jno]->addr_detail = $dn_row->addr_detail;

				$dn_list[$jno]->opt_request = $dn_row->opt_request;
				$dn_list[$jno]->pickup_date = $dn_row->pickup_date;

				$dn_list[$jno]->reg_datetime = $dn_row->reg_datetime;
				$dn_list[$jno]->reg_date = substr($dn_row->reg_datetime,0,10);

				$dn_list[$jno]->reg_ip = $dn_row->reg_ip;

				$dn_list[$jno]->receipt_req_dt = $dn_row->receipt_req_dt;

				/*
					// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
					// 기부 물품 현재 상태
					$state_good_proc = '접수 완료';

					//echo $dn_row->state_reg.'<<<br />';

					$state_good_proc = ('완료' == $dn_row->state_reg) ? '접수 완료' : '접수 중';

					if('' != $dn_row->pickup_date) {
						$state_good_proc = ('완료' == $dn_row->state_pickup) ? '수거 완료' : '수거 중';
					}
					if('' != $dn_row->check_date) {
						$state_good_proc = ('완료' == $dn_row->state_check) ? '검수 완료' : '검수 중';
					}
					if('' != $dn_row->recycle_date) {
						$state_good_proc = ('완료' == $dn_row->state_recycle) ? '재생 완료' : '재생 중';
					}
					if('' != $dn_row->handout_date) {
						$state_good_proc = ('완료' == $dn_row->state_handout) ? '나눔 완료1' : '나눔 중';
					}
					if('' != $dn_row->handout_finish_date) {
						$state_good_proc = ('완료' == $dn_row->state_handout_finish) ? '나눔 완료3' : '나눔 완료2';
					}
				*/

				// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
				// 기부 물품 현재 상태
				// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
				$state_good_proc = '접수 완료';

				$dn_row->state_reg_txt = '';
				$dn_row->state_pickup_txt = '';
				$dn_row->state_check_txt = '';
				$dn_row->state_recycle_txt = '';
				$dn_row->state_handout_txt = '';
				$dn_row->state_handout_finish_txt = '';

				// echo $dn_row->state_reg.'<<<br />';

				$state_good_proc = ('1' == $dn_row->state_reg) ? '접수 완료' : '접수 중';
				$dn_row->state_reg_txt = $state_good_proc;

				if('' != $dn_row->pickup_date && '1' == $dn_row->state_reg) {
					$state_good_proc = ('1' == $dn_row->state_pickup) ? '수거 완료' : '수거 중';
					$dn_row->state_pickup_txt = $state_good_proc;
				}
				if('' != $dn_row->check_date && '1' == $dn_row->state_pickup) {
					$state_good_proc = ('1' == $dn_row->state_check) ? '검수 완료' : '검수 중';
					$dn_row->state_check_txt = $state_good_proc;
				}
				if('' != $dn_row->recycle_date && '1' == $dn_row->state_check) {
					$state_good_proc = ('1' == $dn_row->state_recycle) ? '재생 완료' : '재생 중';
					$dn_row->state_recycle_txt = $state_good_proc;
				}
				/*
				if('' != $dn_row->handout_date && '1' == $dn_row->state_recycle) {
					$state_good_proc = ('1' == $dn_row->state_handout) ? '나눔 완료1' : '나눔 중';
					$dn_row->state_handout_txt = $state_good_proc;
				}
				if('' != $dn_row->handout_finish_date && '1' == $dn_row->state_handout) {
					$state_good_proc = ('1' == $dn_row->state_handout_finish) ? '나눔 완료3' : '나눔 완료2';
					$dn_row->state_handout_finish_txt = $state_good_proc;
				}
				*/
				if('' != $dn_row->handout_date && '1' == $dn_row->state_recycle) {
					$state_good_proc = ('1' == $dn_row->state_handout) ? '나눔 완료' : '나눔 중';
					$dn_row->state_handout_txt = $state_good_proc;
				}

				$dn_row->state_good_proc = $state_good_proc;

				// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - //

				$dn_list[$jno]->state_reg_txt = $dn_row->state_reg_txt;
				$dn_list[$jno]->state_pickup_txt = $dn_row->state_pickup_txt;
				$dn_list[$jno]->state_check_txt = $dn_row->state_check_txt;
				$dn_list[$jno]->state_recycle_txt = $dn_row->state_recycle_txt;
				$dn_list[$jno]->state_handout_txt = $dn_row->state_handout_txt;
				$dn_list[$jno]->state_handout_finish_txt = $dn_row->state_handout_finish_txt;



				$dn_list[$jno]->state_good_proc = $state_good_proc;

				$dn_list[$jno]->donation_value = $dn_row->donation_value;
				$dn_list[$jno]->donation_comma = ( $dn_row->donation_value > 0 ) ? number_format($dn_row->donation_value) : '';

				$jno++;
			}
			//print_r($dn_list);

		// 페이지
		$viewPage = 'mypage/campaign_donate_lists_view';

		// 데이터 - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		$data = array(
			'cmp_row' => $cmp_row,
			'dn_list' => $dn_list,
			'viewPage' => $viewPage
		);
		$this->load->view('layout_view', $data);
	}





	// 제출
	private function campaign_submit($cidx)
	{
		if($this->campaign_lib->_submit($cidx)) {
			alert('제출이 완료되었습니다.','/mypage/campaign/write/'.$cidx);
		}
		else {
			redirect('/mypage/campaign/lists');
		}
	}

	// 제출된 캠페인을 회수
	private function campaign_recover($cidx)
	{
		if($this->campaign_lib->_reset_write($cidx)) {
			alert('제출하셨던 캠페인을 회수하였습니다.','/mypage/campaign/write/'.$cidx);
		}
		else {
			redirect('/mypage/campaign/lists');
		}
	}


	// 삭제
	private function campaign_delete($cidx)
	{
		if($this->campaign_lib->_del($cidx)) {
			alert('삭제되었습니다.','mypage/campaign/lists');
		}
		else {
			alert('존재하지 않거나 이미 삭제된 캠페인입니다.');
		}
	}




	// [준비중] 캠페인 목록 관리
	private function campaign_lists()
	{

		//alert('준비중입니다.');

		// 목록 가져오기
		$arr_where = array(
				'sql_select'     => '*',
				'sql_from'       => 'campaign',
				'sql_where'      => array('writer_idx'=>$this->user_idx),
				'sql_order_by'   => 'reg_datetime DESC'
		);
		$result = $this->basic_model->arr_get_result($arr_where);

		//print_r($result);
		$list = array();
		$ino = 0;
		foreach($result['qry'] as $key => $row) {

			//print_r($row);

			$list[$ino] = new stdClass();

			// 번호
			//$num = ($result['total_count'] - $limit*($page-1) - $ino);
			$num = ($result['total_count'] - $ino);
			$list[$ino]->num = $num;

			$list[$ino]->idx = $row->idx;
			$list[$ino]->cmp_cate = $row->cmp_cate;
			$list[$ino]->cmp_title = $row->cmp_title;
			$list[$ino]->cmp_term_begin = $row->cmp_term_begin;
			$list[$ino]->cmp_term_end = $row->cmp_term_end;
			$list[$ino]->cmp_term = $row->cmp_term_begin.'~'.$row->cmp_term_end;
			$list[$ino]->reg_datetime = $row->reg_datetime;
			$list[$ino]->reg_date = substr($row->reg_datetime,0,10);

			$list[$ino]->state = $row->state;
			$state_str = '<button class="btn o_btn btn-xs btn-silver-flat" disabled>작성</button>';
			if('submit' == $row->state) :
				$state_str = '<button class="btn o_btn btn-xs btn-success-flat" style="cursor: default;">제출</button>';
			elseif('launch' == $row->state) :
				$state_str = '<button class="btn o_btn btn-xs btn-primary-flat" style="cursor: default;">런칭</button>';
			endif;
			$list[$ino]->state_str = $state_str;









			// 기부관리 대상 (런칭)캠페인 목록 가져오기
			//echo $row->idx ."<br />";
			$arr_where = array(
					'sql_select'     => '*',
					'sql_from'       => 'donation',
					'sql_where'      => array('cmp_code'=>$row->code),
					'sql_order_by'   => 'reg_datetime DESC'
			);
			$dn_result = $this->basic_model->arr_get_result($arr_where);

			//print_r($dn_result);
			$dn_list = array();
			$jno = 0;
			foreach($dn_result['qry'] as $j => $dn_row) {

				//print_r($dn_row);

				$dn_list[$jno] = new stdClass();

				// 번호
				//$num = ($dn_result['total_count'] - $limit*($page-1) - $jno);
				$dn_num = ($dn_result['total_count'] - $jno);
				$dn_list[$jno]->num = $dn_num;

				$dn_list[$jno]->idx = $dn_row->idx;
				$dn_list[$jno]->cmp_code = $dn_row->cmp_code;
				$dn_list[$jno]->user_idx = $dn_row->user_idx;
				$dn_list[$jno]->user_username = $dn_row->user_username;

				$dn_list[$jno]->donor_type = $dn_row->donor_type;
				$dn_list[$jno]->company = $dn_row->company;
				$dn_list[$jno]->donor_name = $dn_row->donor_name;
				$dn_list[$jno]->cellphone = $dn_row->cellphone;
				$dn_list[$jno]->email = $dn_row->email;
				$dn_list[$jno]->postcode = $dn_row->postcode;
				$dn_list[$jno]->addr = $dn_row->addr;
				$dn_list[$jno]->addr_detail = $dn_row->addr_detail;

				$dn_list[$jno]->opt_request = $dn_row->opt_request;
				$dn_list[$jno]->pickup_date = $dn_row->pickup_date;

				$dn_list[$jno]->reg_datetime = $dn_row->reg_datetime;
				$dn_list[$jno]->reg_date = substr($dn_row->reg_datetime,0,10);

				$dn_list[$jno]->reg_ip = $dn_row->reg_ip;


				// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
				// 기부 물품 현재 상태
				// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
				$state_good_proc = '접수 중';

				$dn_row->state_reg_txt = '';
				$dn_row->state_pickup_txt = '';
				$dn_row->state_check_txt = '';
				$dn_row->state_recycle_txt = '';
				$dn_row->state_handout_txt = '';
				$dn_row->state_handout_finish_txt = '';

				// echo $dn_row->state_reg.'<<<br />';

				$state_good_proc = ('1' == $dn_row->state_reg) ? '접수 완료' : '접수 중';
				$dn_row->state_reg_txt = $state_good_proc;

				if('' != $dn_row->pickup_date && '1' == $dn_row->state_reg) {
					$state_good_proc = ('1' == $dn_row->state_pickup) ? '수거 완료' : '수거 중';
					$dn_row->state_pickup_txt = $state_good_proc;
				}
				if('' != $dn_row->check_date && '1' == $dn_row->state_pickup) {
					$state_good_proc = ('1' == $dn_row->state_check) ? '검수 완료' : '검수 중';
					$dn_row->state_check_txt = $state_good_proc;
				}
				if('' != $dn_row->recycle_date && '1' == $dn_row->state_check) {
					$state_good_proc = ('1' == $dn_row->state_recycle) ? '재생 완료' : '재생 중';
					$dn_row->state_recycle_txt = $state_good_proc;
				}
				/*
				if('' != $dn_row->handout_date && '1' == $dn_row->state_recycle) {
					$state_good_proc = ('1' == $dn_row->state_handout) ? '나눔 완료1' : '나눔 중';
					$dn_row->state_handout_txt = $state_good_proc;
				}
				if('' != $dn_row->handout_finish_date && '1' == $dn_row->state_handout) {
					$state_good_proc = ('1' == $dn_row->state_handout_finish) ? '나눔 완료3' : '나눔 완료2';
					$dn_row->state_handout_finish_txt = $state_good_proc;
				}
				*/

				if('' != $dn_row->handout_date && '1' == $dn_row->state_recycle) {
					$state_good_proc = ('1' == $dn_row->state_handout) ? '나눔 완료' : '나눔 중';
					$dn_row->state_handout_txt = $state_good_proc;
				}

				// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - //




				$dn_list[$jno]->state_reg_txt = $dn_row->state_reg_txt;
				$dn_list[$jno]->state_pickup_txt = $dn_row->state_pickup_txt;
				$dn_list[$jno]->state_check_txt = $dn_row->state_check_txt;
				$dn_list[$jno]->state_recycle_txt = $dn_row->state_recycle_txt;
				$dn_list[$jno]->state_handout_txt = $dn_row->state_handout_txt;
				$dn_list[$jno]->state_handout_finish_txt = $dn_row->state_handout_finish_txt;



				$dn_list[$jno]->state_good_proc = $state_good_proc;


				$jno++;

			}
			$list[$ino]->dn_list = $dn_list;




			$ino++;
		}

		//print_r($list);



		// 페이지
		$viewPage = 'mypage/campaign_lists_view';

		// 데이터 - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		$data = array(
			'list' => $list,
			'viewPage' => $viewPage
		);
		$this->load->view('layout_view', $data);
	}




	// [작업중] 캠페인 신규/수정
	private function campaign_write($cidx=FALSE)
	{


		load_css('<link rel="stylesheet" href="'.LIB_DIR.'/datetimepicker-master/jquery.datetimepicker.min.css" />');
		load_js('<script src="'.LIB_DIR.'/datetimepicker-master/jquery.datetimepicker.full.js"></script>');


        //<!-- redactor.css -->
		load_css('<link rel="stylesheet" type="text/css" href="'. ASSETS_DIR .'/lib/editor/redactor/redactor.min.css" />');
    	//<!-- redactor.js -->
		load_js('<script src="'. ASSETS_DIR .'/lib/editor/redactor/redactor.min.js"></script>');
        //<!-- plugin js -->
		load_js('<script src="'. ASSETS_DIR .'/lib/editor/redactor/_plugins/fontsize/fontsize.js"></script>');
		load_js('<script src="'. ASSETS_DIR .'/lib/editor/redactor/_plugins/fontcolor/fontcolor.js"></script>');
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
		load_js('<script src="'. ASSETS_DIR .'/lib/editor/redactor/_plugins/fullscreen/fullscreen.js"></script>');

		//<!-- connect the languages file -->
		load_js('<script src="'. ASSETS_DIR .'/lib/editor/redactor/_langs/ko.js?v='.time().'"></script>');



		// 캠페인 카테고리 배열
		$arr = array('sql_select' => '*','sql_from' => 'campaign_cate','sql_where' => array('use'=>'Y'), 'sql_order_by'=>'order ASC');
		$result_cate = $this->basic_model->arr_get_result($arr);



		// # 에러 메시지 CSS
		$this->form_validation->set_error_delimiters('<div class="error">','</div>');

		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		// 저장시..
		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

		//$this->form_validation->set_rules('campaign_cate', '캠페인 카테고리', 'trim|required|xss_clean');
		$this->form_validation->set_rules('campaign_cate', '캠페인 카테고리', 'trim|xss_clean');

		$this->form_validation->set_rules('campaign_title', '캠페인 제목', 'trim|required|xss_clean');
		$this->form_validation->set_rules('campaign_content', '캠페인 내용', 'trim');

		//$this->form_validation->set_rules('goal_money', '목표기부가치', 'trim|required|xss_clean');
		$this->form_validation->set_rules('goal_money', '목표기부가치', 'trim|xss_clean');

		//$this->form_validation->set_rules('goal_desc', '목표기기', 'trim|required|xss_clean');
		$this->form_validation->set_rules('term_begin', '모금기간', 'trim|required|xss_clean');
		$this->form_validation->set_rules('term_end', '모금기간', 'trim|required|xss_clean');

		$this->form_validation->set_rules('org_name', '단체명', 'trim|xss_clean');
		$this->form_validation->set_rules('org_desc', '단체소개', 'trim|xss_clean');


		$this->form_validation->set_rules('ctnt_ttl_1', '캠페인 단락1 제목', 'trim|required|xss_clean');
		$this->form_validation->set_rules('ctnt_detail_1', '캠페인 내용1 제목', 'trim|required|xss_clean');

		$this->form_validation->set_rules('ctnt_ttl_2', '캠페인 단락2 제목', 'trim|required|xss_clean');
		$this->form_validation->set_rules('ctnt_detail_2', '캠페인 내용2 제목', 'trim|required|xss_clean');

		$this->form_validation->set_rules('ctnt_ttl_3', '캠페인 단락3 제목', 'trim|required|xss_clean');
		$this->form_validation->set_rules('ctnt_detail_3', '캠페인 내용3 제목', 'trim|required|xss_clean');



		if ($this->form_validation->run() !== FALSE) {

			// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
			// 글 작성(새글, 답변글, 수정)시 업로드 파일 저장을 위해 고유 세션 생성
			// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
			$user_idx = $this->tank_auth->get_user_id();
			$ss_write_name = 'ss_file_'.$user_idx;
			if (! $this->session->userdata($ss_write_name)) {
				$this->session->set_userdata($ss_write_name, $user_idx.'_'.time());
			}


			/*
			$goal_device = $this->input->post('goal_device');
			$goal_amt = $this->input->post('goal_amt');
			print_r($goal_device);
			print_r($goal_amt);
			exit;
			*/

			/*
				upload_file(
					$field_name,
					$encoded_upload_folder=FALSE,
					$wr_table=FALSE,
					$wr_table_idx=false,
					$wr_opt_idx='',
					$multi_files=FALSE,
					$multi_index=FALSE,
					$return_data=FALSE,
					$max_upload_size='2048',
					$down_no=FALSE,
					$gubun=FALSE,
					$file_title=FALSE) 


			*/


			if (!is_null($data = $this->campaign_lib->write($cidx))) {		// success

				// [캠페인 목록 이미지] 폼업로드 파일 저장 처리
				$this->load->library('upload_lib');

				$field_name = 'campaign_main_image';
				$encoded_upload_folder = url_code('campaign/image','e');
				$table = 'campaign';
				$table_idx = $data['idx'];
				$return_data=FALSE;
				$max_upload_size='20480'; // 20MB
				$gubun = 'list';
				$this->upload_lib->upload_file($field_name,$encoded_upload_folder,$table,$table_idx,'',FALSE,FALSE,$return_data,$max_upload_size,FALSE,$gubun,FALSE);


				// 공통
				$encoded_upload_folder = url_code('campaign/image','e');
				$table = 'campaign';
				$table_idx = $data['idx'];
				$return_data=FALSE;
				$max_upload_size='20480'; // 20MB

				// [캠페인 단락1이미지]
				$field_name = 'campaign_ctnt_image_1';
				$down_no = 1;
				$gubun = 'ctnt_img';
				$this->upload_lib->upload_file($field_name,$encoded_upload_folder,$table,$table_idx,'',FALSE,FALSE,$return_data,$max_upload_size,$down_no,$gubun,FALSE);

				// [캠페인 단락2이미지]
				$field_name = 'campaign_ctnt_image_2';
				$down_no = 2;
				$gubun = 'ctnt_img';
				$this->upload_lib->upload_file($field_name,$encoded_upload_folder,$table,$table_idx,'',FALSE,FALSE,$return_data,$max_upload_size,$down_no,$gubun,FALSE);

				// [캠페인 단락3이미지]
				$field_name = 'campaign_ctnt_image_3';
				$down_no = 3;
				$gubun = 'ctnt_img';
				$this->upload_lib->upload_file($field_name,$encoded_upload_folder,$table,$table_idx,'',FALSE,FALSE,$return_data,$max_upload_size,$down_no,$gubun,FALSE);

				redirect(base_url().'mypage/campaign/write/'.$data['idx']);
			}

		}
		else 
		{

			$row = array();
			$arr_device = array();
			$arr_amt = array();

			if($cidx) {
				// 캠페인 정보
				$arr_where = array(
						'sql_select'     => '*',
						'sql_from'       => 'campaign',
						'sql_where'      => array('idx'=>$cidx)
				);
				$row = $this->basic_model->arr_get_row($arr_where);

				// 목표기기 및 목표수량
				// goal_device_2, goal_amt_2 부터~ 
				// goal_device_1, goal_amt_1 은 추가버튼 등등 미리 출력
				//$arr_device = array();
				//$arr_amt = array();
				/*
				$no = 1;
				for($i=2; $i<=5; $i++) {
					$device_nm = 'goal_device_'.$i;
					$amt_nm = 'goal_amt_'.$i;

					if( '' != $row->$device_nm ) {
						$arr_device[$no] = $row->$device_nm ;
						$arr_amt[$no] = $row->$amt_nm ;
						$no++;
					}
				}
				*/

				$no = 0;
				for($j=1; $j<=5; $j++) {
					$device_nm = 'goal_device_'.$j;
					$amt_nm = 'goal_amt_'.$j;

					if( '' != $row->$device_nm ) {
						$arr_device[$no] = $row->$device_nm ;
						$arr_amt[$no] = $row->$amt_nm ;
						$no++;
					}
				}


				// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
				// 대표이미지(목록 및 캠페인 대표 이미지)
				$arr_where = array(
						'sql_select'     => '*',
						'sql_from'       => 'file_manager',
						//'sql_where'      => array('wr_table'=>'campaign','wr_table_idx'=>$row->idx,'upload_type'=>'form','file_type'=>'image','gubun'=>'list'),
						'sql_where'      => array('wr_table'=>'campaign','wr_table_idx'=>$row->idx,'upload_type'=>'form','gubun'=>'list'),
						'sql_order_by'   => 'idx DESC',
						'limit'          => 1
				);
				$file_row = $this->basic_model->arr_get_row($arr_where);
				//echo $this->db->last_query();

				$row->campaign_main_img = '';
				$row->file_idx = '';

				if(! empty($file_row)) {
					//$this->load->helper('resize');
					$img_w = '750';
					$img_h = '';

					$thumb_img = resize_thumb_image($file_row->file_name, $file_row->file_dir, $file_row->file_dir.'/thumb', $img_w,$img_h,FALSE,'width','img');
					$row->campaign_main_img = $thumb_img;
					$row->file_idx = $file_row->idx;
				}
				//echo $thumb_img.'<<<<';






				// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
				// 캠페인 단락 이미지
				//$this->load->helper('resize');
				$img_w = '800';
				$img_h = '';

				$arr_where = array(
						'sql_select'     => '*',
						'sql_from'       => 'file_manager',
						//'sql_where'      => array('wr_table'=>'campaign','wr_table_idx'=>$row->idx,'upload_type'=>'form','file_type'=>'image','gubun'=>'ctnt_img'),
						'sql_where'      => array('wr_table'=>'campaign','wr_table_idx'=>$row->idx,'upload_type'=>'form','gubun'=>'ctnt_img'),
						'sql_order_by'   => 'idx DESC',
						'limit'          => 10
				);
				$file_result = $this->basic_model->arr_get_result($arr_where);
				//echo $this->db->last_query();
				$ctnt_file_idx = array();
				$ctnt_file_img = array();
				foreach($file_result['qry'] as $k => $o) {

					$ctnt_file_idx[$o->down_no] = $o->idx;

					//echo $o->file_name.'<<<br />';

					$thumb_img = resize_thumb_image($o->file_name, $o->file_dir, $o->file_dir.'/thumb', $img_w,$img_h,FALSE,'width','img');
					$ctnt_file_img[$o->down_no] = $thumb_img;

					//echo $thumb_img.'<<<<br />';

				}
				$row->ctnt_file_idx = $ctnt_file_idx;
				$row->ctnt_file_img = $ctnt_file_img;

				//print_r($row->ctnt_file_img);






			}

			// 기부 디바이스 명
			$arr_device_pool = array('노트북','데스크탑','스마트패드','스마트폰');




			// 함께 하는 기관 연동
			// 로그인 한 NPO 회원이 작성한 최신 '함께하는 기관' 정보 가져오기
			$arr_where = array(
					'sql_select'     => '*',
					'sql_from'       => 'bbs_orgs',
					'sql_where'      => array('user_idx'=>$this->user_idx),
					'sql_order_by'   => 'wr_idx DESC',
					'limit'          => 1
			);
			//$org_row = new stdClass();
			if( $org_row = $this->basic_model->arr_get_row($arr_where) ) {
				$org_link = base_url().'B/PEOPLE/함께-하는-기관/detail/'.$org_row->wr_idx;
				$org_row->org_link = $org_link;
				$org_row->org_name = ( isset($org_row->wr_subject) && $org_row->wr_subject != '' ) ? $org_row->wr_subject : '';
				$org_row->org_info = ( isset($org_row->wr_content) && $org_row->wr_content != '' ) ? $org_row->wr_content : '';
			}
			else {
				$org_row = new stdClass();
				$org_row->org_link = '';
				$org_row->org_name = '';
				$org_row->org_info = '';
			}
			



			//print_r($this->user);
			//print_r($this->user->company);
			//print_r($this->user->company_info);

			$company = isset($this->user->company) ? $this->user->company : '';
			$company_info = isset($this->user->company_info) ? $this->user->company_info : '';


			// 페이지
			$viewPage = 'mypage/campaign_write_view';

			// 데이터 - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
			$data = array(
				'result_cate' => $result_cate,
				'arr_device' => $arr_device,
				'arr_amt' => $arr_amt,
				'row' => $row,
				'org_row' => $org_row,

				'company' => $company,
				'company_info' => $company_info,

				'viewPage' => $viewPage
			);
			$this->load->view('layout_view', $data);

		}
	}





	// 캠페인 정보 보기
	private function campaign_info($cidx=FALSE)
	{

		load_css('<link rel="stylesheet" href="'.LIB_DIR.'/datetimepicker-master/jquery.datetimepicker.min.css" />');
		load_js('<script src="'.LIB_DIR.'/datetimepicker-master/jquery.datetimepicker.full.js"></script>');


        //<!-- redactor.css -->
		load_css('<link rel="stylesheet" type="text/css" href="'. ASSETS_DIR .'/lib/editor/redactor/redactor.min.css" />');
    	//<!-- redactor.js -->
		load_js('<script src="'. ASSETS_DIR .'/lib/editor/redactor/redactor.min.js"></script>');
        //<!-- plugin js -->
		load_js('<script src="'. ASSETS_DIR .'/lib/editor/redactor/_plugins/fontsize/fontsize.js"></script>');
		load_js('<script src="'. ASSETS_DIR .'/lib/editor/redactor/_plugins/fontcolor/fontcolor.js"></script>');
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
		load_js('<script src="'. ASSETS_DIR .'/lib/editor/redactor/_plugins/fullscreen/fullscreen.js"></script>');

		//<!-- connect the languages file -->
		load_js('<script src="'. ASSETS_DIR .'/lib/editor/redactor/_langs/ko.js?v='.time().'"></script>');




		// 캠페인 카테고리 배열
		$arr = array('sql_select' => '*','sql_from' => 'campaign_cate','sql_where' => array('use'=>'Y'), 'sql_order_by'=>'order ASC');
		$result_cate = $this->basic_model->arr_get_result($arr);


		$row = array();
		$arr_device = array();
		$arr_amt = array();

		if($cidx) {
			// 캠페인 정보
			$arr_where = array(
					'sql_select'     => '*',
					'sql_from'       => 'campaign',
					'sql_where'      => array('idx'=>$cidx)
			);
			$row = $this->basic_model->arr_get_row($arr_where);

			// 목표기기 및 목표수량
			// goal_device_2, goal_amt_2 부터~ 
			// goal_device_1, goal_amt_1 은 추가버튼 등등 미리 출력
			//$arr_device = array();
			//$arr_amt = array();
			$no = 1;
			for($i=1; $i<=5; $i++) {
				$device_nm = 'goal_device_'.$i;
				$amt_nm = 'goal_amt_'.$i;

				if( '' != $row->$device_nm ) {
					$arr_device[$no] = $row->$device_nm ;
					$arr_amt[$no] = $row->$amt_nm ;
					$no++;
				}
			}




			// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
			// 대표이미지(목록 및 캠페인 대표 이미지)
			$arr_where = array(
					'sql_select'     => '*',
					'sql_from'       => 'file_manager',
					'sql_where'      => array('wr_table'=>'campaign','wr_table_idx'=>$row->idx,'upload_type'=>'form','file_type'=>'image','gubun'=>'list'),
					'sql_order_by'   => 'idx DESC',
					'limit'          => 1
			);
			$file_row = $this->basic_model->arr_get_row($arr_where);
			//echo $this->db->last_query();
			if(! empty($file_row)) {
				//$this->load->helper('resize');
				$img_w = '750';
				$img_h = '';

				$thumb_img = resize_thumb_image($file_row->file_name, $file_row->file_dir, $file_row->file_dir.'/thumb', $img_w,$img_h,FALSE,'width','img');
				$row->campaign_main_img = $thumb_img;
				$row->file_idx = $file_row->idx;
			}
			//echo $thumb_img.'<<<<';




			// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
			// 캠페인 단락 이미지
				//$this->load->helper('resize');
				$img_w = '800';
				$img_h = '';

				$arr_where = array(
						'sql_select'     => '*',
						'sql_from'       => 'file_manager',
						'sql_where'      => array('wr_table'=>'campaign','wr_table_idx'=>$row->idx,'upload_type'=>'form','file_type'=>'image','gubun'=>'ctnt_img'),
						'sql_order_by'   => 'idx DESC',
						'limit'          => 10
				);
				$file_result = $this->basic_model->arr_get_result($arr_where);
				//echo $this->db->last_query();
				$ctnt_file_idx = array();
				$ctnt_file_img = array();
				foreach($file_result['qry'] as $k => $o) {

					$ctnt_file_idx[$o->down_no] = $o->idx;

					//echo $o->file_name.'<<<br />';

					$thumb_img = resize_thumb_image($o->file_name, $o->file_dir, $o->file_dir.'/thumb', $img_w,$img_h,FALSE,'width','img');
					$ctnt_file_img[$o->down_no] = $thumb_img;

					//echo $thumb_img.'<<<<br />';

				}
				$row->ctnt_file_idx = $ctnt_file_idx;
				$row->ctnt_file_img = $ctnt_file_img;



		}

		// 기부 디바이스 명
		$arr_device_pool = array('노트북','데스크탑','스마트패드','스마트폰');




		// 함께 하는 기관 연동
		// 로그인 한 NPO 회원이 작성한 최신 '함께하는 기관' 정보 가져오기
		$arr_where = array(
				'sql_select'     => '*',
				'sql_from'       => 'bbs_orgs',
				'sql_where'      => array('user_idx'=>$this->user_idx),
				'sql_order_by'   => 'wr_idx DESC',
				'limit'          => 1
		);
		//$org_row = new stdClass();
		if( $org_row = $this->basic_model->arr_get_row($arr_where) ) {
			$org_link = base_url().'B/PEOPLE/함께-하는-기관/detail/'.$org_row->wr_idx;
			$org_row->org_link = $org_link;
			$org_row->org_name = ( isset($org_row->wr_subject) && $org_row->wr_subject != '' ) ? $org_row->wr_subject : '';
			$org_row->org_info = ( isset($org_row->wr_content) && $org_row->wr_content != '' ) ? $org_row->wr_content : '';
		}
		else {
			$org_row = new stdClass();
			$org_row->org_link = '';
			$org_row->org_name = '';
			$org_row->org_info = '';
		}
		


		// 페이지
		$viewPage = 'mypage/campaign_info_view';

		// 데이터 - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		$data = array(
			'result_cate' => $result_cate,
			'arr_device' => $arr_device,
			'arr_amt' => $arr_amt,
			'row' => $row,
			'org_row' => $org_row,
			'viewPage' => $viewPage
		);
		$this->load->view('layout_view', $data);

	}















	// + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + +
	// 일반 회원 전용 캠페인 후원 페이지
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	function donation($method="lists",$cmp_code=FALSE,$flag=FALSE,$flag2=FALSE) 
	{
		if('lists' == $method) {
			$this->donation_lists();
		}
		else if('detail' == $method) {
			$this->donation_detail($cmp_code,$flag);
		}
		else if('del' == $method) {
			$this->donation_del_writer($cmp_code,$flag,$flag2);
		}
		else if('report_check' == $method) {
			$this->donation_report_check($cmp_code,$flag);
		}
		else if('report_del' == $method) {
			$this->donation_report_del($cmp_code,$flag,$flag2);
		}
		else if('report_del_ros' == $method) {
			$this->donation_report_del_ros($cmp_code,$flag,$flag2);
		}
		else if('report_receipt' == $method) {
			$this->donation_report_receipt($cmp_code,$flag);
		}
		else {
			redirect(base_url('mypage/donation/detail/'.$cmp_code));
		}
	}



	// 기부 상세 내역 삭제
	private function donation_del_writer($cmp_code=FALSE,$donate_idx=FALSE,$user_idx=FALSE) {

		if(! $user_idx OR $this->user_idx != $user_idx ) {
			alert('삭제 권한이 없습니다.');
			return false;
		}
		elseif($this->campaign_lib->_donation_del_writer($cmp_code,$donate_idx,$user_idx)) {
			alert('삭제되었습니다.');
		}
		else {
			alert('존재하지 않거나 이미 삭제된 기부내역입니다.');
		}

	}



	// [준비중] 상세검수현황
	private function donation_report_check($cmp_code=FALSE,$dn_idx=FALSE) {

		if(! $cmp_code) {
			alert('존재하지 않거나 삭제된 캠페인입니다.',base_url().'mypage/donation/lists');
			exit;
		}
		// 캠페인 정보
		$arr_where = array(
				'sql_select'     => '*',
				'sql_from'       => 'campaign',
				'sql_where'      => array('code'=>$cmp_code)
		);
		$cmp_row = $this->basic_model->arr_get_row($arr_where);
		if(! $cmp_row->idx) {
			alert('존재하지 않거나 삭제된 캠페인입니다.',base_url().'mypage/donation/lists');
			exit;
		}

		// 기부 정보
		$arr_where = array(
				'sql_select'     => '*',
				'sql_from'       => 'donation',
				'sql_where'      => array('idx'=>$dn_idx, 'cmp_code'=>$cmp_code, 'user_idx'=>$this->user_idx)
		);
		$dn_row = $this->basic_model->arr_get_row($arr_where);



		// 저장된 상세 검수 현황 가져오기
			$arr_where = array(
					'sql_select'     => '*',
					'sql_from'       => 'donation_report_check',
					'sql_where'      => array('cmp_code'=>$cmp_code,'donate_idx'=>$dn_idx,'user_idx'=>$this->user_idx)
			);
			$dnchk_result = $this->basic_model->arr_get_result($arr_where);

			//print_r($dnchk_result);





		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		// ROS에 저장된 상세 검수 현황 가져오기
			// [개발용 주소] // 로컬 작업용 pc
			//$post_url = 'http://183.99.21.70:8080/replus/getInsp';  
			// [실제사용주소]
			$post_url = 'https://ros.remann.co.kr/replus/getInsp'; // ros.remann.co.kr/replus/getInsp

			$cert_key = 'ub9acud50cub7ecuc2a4u0072u006fu0073uc5f0ub3d9';
			$curl_data = array('id'=>$dn_idx,'key'=>$cert_key);
			$output_json = $this->curl_post_ros($post_url, $curl_data); // return 등록한 작업요청id값
			$output_arr = json_decode($output_json, true);

			$item_list = array();

			if( isset($output_arr['data']) && ! empty($output_arr['data']) && ! is_null($output_arr['data'])) {
				foreach ($output_arr['data'] as $i => $item) {
					$item_list[$i] = new stdClass();
					$item_list[$i]->insp_kind = $item['insp_kind'];
					$item_list[$i]->mfr = $item['mfr'];
					$item_list[$i]->model = $item['model'];
					$item_list[$i]->sn = $item['sn'];
					$item_list[$i]->registeredDate = $item['registeredDate'];
					$item_list[$i]->rmk_1 = $item['rmk_1'];
					$item_list[$i]->grade = $item['grade'];
				}
			}
		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -




		// 페이지
		$viewPage = 'mypage/donation_report_check_view';

		// 모바일 - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		//if(IS_MOBILE) :
		//	$viewPage = 'mypage/mobile_donation_report_check_view';
		//endif;

		// 데이터 - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		$data = array(
			'cmp_row' => $cmp_row,
			'dn_row' => $dn_row,
			'dnchk_result' => $dnchk_result,
			'item_list' => $item_list,
			'viewPage' => $viewPage
		);
		$this->load->view('layout_view', $data);
	}

	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	// 데이터 완전 삭제 리포트
	// [2025-08-20] ROS 에서 데이터를 받아와서 처리
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	private function donation_report_del_ros($cmp_code=FALSE,$dn_idx=FALSE) {

		if(! $cmp_code) {
			alert('존재하지 않거나 삭제된 캠페인입니다.',base_url().'mypage/donation/lists');
			exit;
		}


		// 캠페인 정보
		$arr_where = array(
				'sql_select'     => '*',
				'sql_from'       => 'campaign',
				'sql_where'      => array('code'=>$cmp_code)
		);
		$cmp_row = $this->basic_model->arr_get_row($arr_where);
		if(! $cmp_row->idx) {
			alert('존재하지 않거나 삭제된 캠페인입니다.',base_url().'mypage/donation/lists');
			exit;
		}

		// 기부 정보
		$arr_where = array(
				'sql_select'     => '*',
				'sql_from'       => 'donation',
				'sql_where'      => array('idx'=>$dn_idx, 'cmp_code'=>$cmp_code, 'user_idx'=>$this->user_idx)
		);
		$dn_row = $this->basic_model->arr_get_row($arr_where);



		/*
		// [1. 목록] 저장된 데이터 완전 삭제 리포트 - 목록 가져오기
		$arr_where = array(
				'sql_select'     => '*',
				'sql_from'       => 'donation_report_delete_list',
				'sql_where'      => array('cmp_code'=>$cmp_code,'donate_idx'=>$dn_idx,'user_idx'=>$this->user_idx)
		);
		$dn_del_result = $this->basic_model->arr_get_result($arr_where);
		//print_r($dn_del_result);

		// [2. 사진] 저장된 데이터 완전 삭제 리포트 - 사진 가져오기
		$arr_where = array(
				'sql_select'     => '*',
				'sql_from'       => 'donation_report_delete_photo',
				'sql_where'      => array('cmp_code'=>$cmp_code,'donate_idx'=>$dn_idx,'user_idx'=>$this->user_idx)
		);
		$dn_del_result_photo = $this->basic_model->arr_get_result($arr_where);
		//print_r($dn_del_result_photo);  // del_content
		$dn_del_row_photo = $this->basic_model->arr_get_row($arr_where);
		//print_r($dn_del_row_photo);  // del_content



		// [3. 증명] 저장된 데이터 완전 삭제 리포트 - 증명 가져오기
		$arr_where = array(
				'sql_select'     => '*',
				'sql_from'       => 'donation_report_delete_cert',
				'sql_where'      => array('cmp_code'=>$cmp_code,'donate_idx'=>$dn_idx,'user_idx'=>$this->user_idx)
		);
		$dn_del_result_cert = $this->basic_model->arr_get_result($arr_where);
		$dn_del_row_cert = $this->basic_model->arr_get_row($arr_where);
		//print_r($dn_del_row_cert);

		// 파일 가져오기
		$cert_file = false;
		$cert_file_url = false;
		if( isset($dn_del_row_cert->idx) && '' != $dn_del_row_cert->idx ) {
			$sql_arr = array(
					'sql_select'     => '*',
					'sql_from'       => 'file_manager',
					'sql_where'      => array('wr_table'=>'dn_report_del_cert','wr_table_idx'=>$dn_del_row_cert->idx,'gubun'=>'list'),
					'sql_order_by'   => 'order ASC',
					'limit'   => 1
			);
			$cert_row = $this->basic_model->arr_get_row($sql_arr);
			//print_r($cert_row);
			if( isset($cert_row->file_dir) && isset($cert_row->file_name) ) 
			{
				$cert_file = DATA_DIR.'/'.$cert_row->file_dir.'/'.$cert_row->file_name;
				$cert_file_url = (isset($cert_row->file_name) && $cert_row->file_name != '') ? '/files/download/'.url_code($cert_row->file_dir,'e').'/'.$cert_row->file_name.'/'.url_code($cert_row->file_name_org,'e') : '#';
			}

		}
		*/



		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		// ROS에 저장된 상세 검수 현황 가져오기
			// [개발용 주소] // 로컬 작업용 pc
			//$post_url = 'http://183.99.21.70:8080/replus/getInsp';  
			// [실제사용주소]
			$post_url = 'https://ros.remann.co.kr/replus/getDel'; // ros.remann.co.kr/replus/getDel

			$cert_key = 'ub9acud50cub7ecuc2a4u0072u006fu0073uc5f0ub3d9';
			$curl_data = array('id'=>$dn_idx,'key'=>$cert_key);
			$output_json = $this->curl_post_ros($post_url, $curl_data); // return 등록한 작업요청id값
			$output_arr = json_decode($output_json, true);

			/*
			if('112.185.52.193' == REMOTE_ADDR OR '116.45.104.200' == REMOTE_ADDR) {
				print_r($output_arr);
				echo '<hr />';
			}
			*/

			$report = new stdClass();
			$resData = isset($output_arr['data'][0]) ? $output_arr['data'][0] : false;

			$merged_eraseType = [];
			$arr_eraseType = [];
			$erase_ssn = array();


			if($resData) {

				$res_list = array();

				if( isset($output_arr['data']) && ! empty($output_arr['data']) && ! is_null($output_arr['data'])) {
					foreach ($output_arr['data'] as $i => $res) {
						$res_list[$i] = new stdClass();
						$res_list[$i]->registeredDate = $res['registeredDate'];
						$res_list[$i]->securityofficer = $res['securityofficer'];
						$res_list[$i]->user_nm = $res['user_nm'];
						$res_list[$i]->delk_id = $res['delk_id'];
						$res_list[$i]->erase_type = $res['erase_type'];
						$res_list[$i]->file_kind = isset($res['file_kind']) ? $res['file_kind'] : '';;
						$res_list[$i]->file_nm = isset($res['file_nm']) ? $res['file_nm'] : '';
						$res_list[$i]->ssn = $res['ssn'];


						/*
						if (!in_array($res['erase_type'], $arr_eraseType)) {
							$arr_eraseType[] = $res['erase_type'];   // 또는 array_push($arr_eraseType, $res['erase_type']);
							array_push($arr_eraseType, $res['erase_type']);
						}
						*/
						// explode 후 trim 처리
						$parts = array_map('trim', explode(',', $res['erase_type']));
						$merged_eraseType = array_merge($merged_eraseType, $parts);


						$erase_ssn[$res['erase_type']] = new stdClass();
						//$erase_ssn[$res['erase_type']]->ssn = isset($res['ssn']) ?$res['ssn'] : 'N/A (파쇄에 따른 미확인)';
						$erase_ssn[$res['erase_type']]->ssn = isset($res['ssn']) && '' != $res['ssn'] ?$res['ssn'] : 'N/A (파쇄)';

					}
				}
				//print_r($arr_eraseType); // 디가우징,분쇄,블랑코,천공

				// 중복 제거 후 정렬(optional)
				$arr_eraseType = array_unique($merged_eraseType);
				sort($arr_eraseType);



				$registeredDate = isset($resData['registeredDate']) ? $resData['registeredDate'] : '';
				$registeredDate = substr($registeredDate, 0, 16);
				$report->registeredDate = $registeredDate;

				// delk_id
				$report->delk_id = $resData['delk_id'];

				//$insurance_number = '2025082011-0001';
				$reg_date_number = str_replace(array('-',' ',':'),'',$registeredDate);
				$insurance_number = substr($reg_date_number, 0, 10);

				$ins_no = format_insurance($dn_idx);

				$report->insurance_number = '#'.$insurance_number.'-'.$ins_no;

				$cus_nm = isset($resData['cus_nm']) ? $resData['cus_nm'] : '';
				$report->cus_nm = $cus_nm;

				$user_nm = isset($resData['user_nm']) ? $resData['user_nm'] : '';
				$report->user_nm = $user_nm;

				$securityofficer = isset($resData['securityofficer']) ? $resData['securityofficer'] : '';
				$report->securityofficer = $securityofficer;

				$ssn = isset($resData['ssn']) ? $resData['ssn'] : 'N/A (파쇄에 따른 미확인)';
				$report->ssn = $ssn;

				$report->erase_ssn = $erase_ssn;


				$file_path = 'https://ros.remann.co.kr/resources/img/inspDel/';

				$file_bfr1_path = isset($resData['file_bfr1_path']) ? $file_path.$resData['file_bfr1_path'] : '';
				$file_ing1_path = isset($resData['file_ing1_path']) ? $file_path.$resData['file_ing1_path'] : '';
				$file_aft1_path = isset($resData['file_aft1_path']) ? $file_path.$resData['file_aft1_path'] : '';
				$file_doc1_path = isset($resData['file_doc1_path']) ? $file_path.$resData['file_doc1_path'] : '';
				/*
				echo $file_bfr1_path.'<<<<<br />';
				echo $file_ing1_path.'<<<<<br />';
				echo $file_aft1_path.'<<<<<br />';
				echo $file_doc1_path.'<<<<<br />';
				*/
				$report->file_bfr1_path = $file_bfr1_path;
				$report->file_ing1_path = $file_ing1_path;
				$report->file_aft1_path = $file_aft1_path;
				$report->file_doc1_path = $file_doc1_path;

				$report->file_bfr1_img = ('' != $file_bfr1_path) ? '<img src="'.$file_bfr1_path.'" />' : '';
				$report->file_ing1_img = ('' != $file_ing1_path) ? '<img src="'.$file_ing1_path.'" />' : '';
				$report->file_aft1_img = ('' != $file_aft1_path) ? '<img src="'.$file_aft1_path.'" />' : '';
				$report->file_doc1_img = ('' != $file_doc1_path) ? '<img src="'.$file_doc1_path.'" />' : '';

				$place_del = '리맨본사(포천시)';
				$report->place_del = $place_del;

				$copyText = '© 2025 사회적기업 (주)리맨. All rights reserved.';
				$report->copyText = $copyText;

				// 문서 만든 날짜. 
				// 접속날짜. 오늘 날짜
				$access_date = date('Y년 m월 d일');
				$report->access_date = $access_date;




			}
			else {
				alert('데이터 삭제 보고서가 아직 작성되지 않았습니다. \n검수가 완료된 후 확인하실 수 있습니다.',base_url('mypage/donation/detail/'.$cmp_code.'/'.$dn_idx));


			}
		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -




		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		// ROS에 저장된 상세 검수 현황 가져오기
			// [개발용 주소] // 로컬 작업용 pc
			//$post_url = 'http://183.99.21.70:8080/replus/getInsp';  
			// [실제사용주소]
			$post_url = 'https://ros.remann.co.kr/replus/getInsp'; // ros.remann.co.kr/replus/getInsp

			$cert_key = 'ub9acud50cub7ecuc2a4u0072u006fu0073uc5f0ub3d9';
			$curl_data = array('id'=>$dn_idx,'key'=>$cert_key);
			$output_json = $this->curl_post_ros($post_url, $curl_data); // return 등록한 작업요청id값
			$output_arr = json_decode($output_json, true);
			//print_r($output_arr);

			$item_list = array();
			if( isset($output_arr['data']) && ! empty($output_arr['data']) && ! is_null($output_arr['data'])) {
				foreach ($output_arr['data'] as $i => $item) {
					// print_r($item);
					$item_list[$i] = new stdClass();

					$itm_insp_kind = $item['insp_kind'];
					$itm_grade = $item['grade'];

					$item_list[$i]->insp_kind = $itm_insp_kind;
					$item_list[$i]->mfr = $item['mfr'];
					$item_list[$i]->model = $item['model'];
					$item_list[$i]->sn = $item['sn'];
					$item_list[$i]->registeredDate = $item['registeredDate'];
					$item_list[$i]->rmk_1 = $item['rmk_1'];
					$item_list[$i]->grade = $itm_grade;
				}
			}
		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -



		// 페이지
		$viewPage = 'mypage/donation_report_del_ros_view';


		// 데이터 - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		$data = array(
			'cmp_code' =>$cmp_code,
			'dn_idx' =>$dn_idx,
			'cmp_row' => $cmp_row,
			'dn_row' => $dn_row,

			/*
			'dn_del_result' => $dn_del_result,
			'dn_del_row_photo' => $dn_del_row_photo,
			'dn_del_row_cert' => $dn_del_row_cert,
			'cert_file' => $cert_file,
			'cert_file_url' => $cert_file_url,
			*/

			'res_list' => $res_list,
			'item_list' => $item_list,

			'report' => $report,
			'arr_eraseType' => $arr_eraseType,

			'arr_seg' => $this->arr_seg,
			'viewPage' => $viewPage
		);
		$this->load->view('layout_print_view', $data);
	}





	/* [2025] chatgpt 버전 */
	function curl_post_ros($url, $data)
	{
		// 1. 모든 값에 대해:
		//    - 줄바꿈을 \n 으로 치환 (실제 개행 → 문자열)
		//    - UTF-8 인코딩 보장
		foreach ($data as $key => $value) {
			$value = str_replace(["\r\n", "\r", "\n"], "\\n", $value); // 줄바꿈을 문자열 \n으로
			$data[$key] = mb_convert_encoding($value, 'UTF-8', 'auto');
		}

		// 2. 쿼리 문자열로 변환
		$post_field_string = http_build_query($data, '', '&');

		// 3. cURL 설정
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post_field_string);
		curl_setopt($ch, CURLOPT_HTTPHEADER, [
			'Content-Type: application/x-www-form-urlencoded; charset=UTF-8'
		]);
		curl_setopt($ch, CURLOPT_POST, true);

		$response = curl_exec($ch);

		curl_close($ch);

		return $response;
	}






	// [준비중] 데이터 완전 삭제 리포트
	private function donation_report_del($cmp_code=FALSE,$dn_idx=FALSE,$type="list") {

		if(! $cmp_code) {
			alert('존재하지 않거나 삭제된 캠페인입니다.',base_url().'mypage/donation/lists');
			exit;
		}
		// 캠페인 정보
		$arr_where = array(
				'sql_select'     => '*',
				'sql_from'       => 'campaign',
				'sql_where'      => array('code'=>$cmp_code)
		);
		$cmp_row = $this->basic_model->arr_get_row($arr_where);
		if(! $cmp_row->idx) {
			alert('존재하지 않거나 삭제된 캠페인입니다.',base_url().'mypage/donation/lists');
			exit;
		}

		// 기부 정보
		$arr_where = array(
				'sql_select'     => '*',
				'sql_from'       => 'donation',
				'sql_where'      => array('idx'=>$dn_idx, 'cmp_code'=>$cmp_code, 'user_idx'=>$this->user_idx)
		);
		$dn_row = $this->basic_model->arr_get_row($arr_where);




		// [1. 목록] 저장된 데이터 완전 삭제 리포트 - 목록 가져오기
		$arr_where = array(
				'sql_select'     => '*',
				'sql_from'       => 'donation_report_delete_list',
				'sql_where'      => array('cmp_code'=>$cmp_code,'donate_idx'=>$dn_idx,'user_idx'=>$this->user_idx)
		);
		$dn_del_result = $this->basic_model->arr_get_result($arr_where);
		//print_r($dn_del_result);

		// [2. 사진] 저장된 데이터 완전 삭제 리포트 - 사진 가져오기
		$arr_where = array(
				'sql_select'     => '*',
				'sql_from'       => 'donation_report_delete_photo',
				'sql_where'      => array('cmp_code'=>$cmp_code,'donate_idx'=>$dn_idx,'user_idx'=>$this->user_idx)
		);
		$dn_del_result_photo = $this->basic_model->arr_get_result($arr_where);
		//print_r($dn_del_result_photo);  // del_content
		$dn_del_row_photo = $this->basic_model->arr_get_row($arr_where);
		//print_r($dn_del_row_photo);  // del_content



		// [3. 증명] 저장된 데이터 완전 삭제 리포트 - 증명 가져오기
		$arr_where = array(
				'sql_select'     => '*',
				'sql_from'       => 'donation_report_delete_cert',
				'sql_where'      => array('cmp_code'=>$cmp_code,'donate_idx'=>$dn_idx,'user_idx'=>$this->user_idx)
		);
		$dn_del_result_cert = $this->basic_model->arr_get_result($arr_where);
		$dn_del_row_cert = $this->basic_model->arr_get_row($arr_where);
		//print_r($dn_del_row_cert);

		// 파일 가져오기
		$cert_file = false;
		$cert_file_url = false;
		if( isset($dn_del_row_cert->idx) && '' != $dn_del_row_cert->idx ) {
			$sql_arr = array(
					'sql_select'     => '*',
					'sql_from'       => 'file_manager',
					'sql_where'      => array('wr_table'=>'dn_report_del_cert','wr_table_idx'=>$dn_del_row_cert->idx,'gubun'=>'list'),
					'sql_order_by'   => 'order ASC',
					'limit'   => 1
			);
			$cert_row = $this->basic_model->arr_get_row($sql_arr);
			//print_r($cert_row);
			if( isset($cert_row->file_dir) && isset($cert_row->file_name) ) 
			{
				$cert_file = DATA_DIR.'/'.$cert_row->file_dir.'/'.$cert_row->file_name;
				$cert_file_url = (isset($cert_row->file_name) && $cert_row->file_name != '') ? '/files/download/'.url_code($cert_row->file_dir,'e').'/'.$cert_row->file_name.'/'.url_code($cert_row->file_name_org,'e') : '#';
			}

		}


		// 페이지
		$viewPage = 'mypage/donation_report_del_view';


		// 데이터 - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		$data = array(
			'cmp_code' =>$cmp_code,
			'dn_idx' =>$dn_idx,
			'cmp_row' => $cmp_row,
			'dn_row' => $dn_row,

			'dn_del_result' => $dn_del_result,
			'dn_del_row_photo' => $dn_del_row_photo,
			'dn_del_row_cert' => $dn_del_row_cert,
			'cert_file' => $cert_file,
			'cert_file_url' => $cert_file_url,

			'arr_seg' => $this->arr_seg,
			'viewPage' => $viewPage
		);
		$this->load->view('layout_view', $data);
	}


	// [준비중] 기부금 영수증 보기
	private function donation_report_receipt($cmp_code=FALSE,$dn_idx=FALSE) {

		if(! $cmp_code) {
			alert('존재하지 않거나 삭제된 캠페인입니다.',base_url().'mypage/donation/lists');
			exit;
		}
		// 캠페인 정보
		$arr_where = array(
				'sql_select'     => '*',
				'sql_from'       => 'campaign',
				'sql_where'      => array('code'=>$cmp_code)
		);
		$cmp_row = $this->basic_model->arr_get_row($arr_where);
		if(! $cmp_row->idx) {
			alert('존재하지 않거나 삭제된 캠페인입니다.',base_url().'mypage/donation/lists');
			exit;
		}


		// 기부 정보
		$arr_where = array(
				'sql_select'     => '*',
				'sql_from'       => 'donation',
				'sql_where'      => array('idx'=>$dn_idx, 'cmp_code'=>$cmp_code, 'user_idx'=>$this->user_idx)
		);
		$dn_row = $this->basic_model->arr_get_row($arr_where);
		//print_r($dn_row);


		// 페이지
		$viewPage = 'mypage/donation_report_receipt_view';

		// 데이터 - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		$data = array(
			'cmp_code' => $cmp_code,
			'dn_idx' => $dn_idx,
			'u_idx' => $this->user_idx,

			'cmp_row' => $cmp_row,
			'dn_row' => $dn_row,
			'viewPage' => $viewPage
		);
		$this->load->view('layout_view', $data);
	}



	function test_cj_tracking($dn_idx = false) {

		//$dn_idx = 501;

		if( $dn_idx ) 
		{

					$post_url = 'https://ros.remann.co.kr/cj/getGdsTrc';
					$curl_data = array('id'=>$dn_idx);
					//print_r($curl_data);

					$output_json = $this->curl_post_ros($post_url, $curl_data); // return 등록한 작업요청id값
					//print_r($output_json);

					$output_arr = json_decode($output_json, true); // $output_arr['data'][0]

					if('14.42.161.237' == REMOTE_ADDR) {
						echo $dn_idx.'<<<<br />'; // 581
						//print_r($output_json);
						//echo '<hr />';
						print_r($output_arr);
						echo '<hr />';
					}



					/*

						{"data":[{"id":341,"no_CLDV_RSN_CD":"","dealemp_NM":"강현웅","crg_ST":"91","scan_HOUR":"140206","invc_NO":"844158250795","rcpt_DV":"02","acptr_NM":"사회적기업리맨","scan_YMD":"20250911","detail_RSN":"","dealt_BRAN_NM":"경기포천선단","cust_USE_NO":"503_R","crg_ST_NM":"배송완료"}]}

						Array ( 
						[data] => Array ( 
							[0] => Array ( 
								[id] => 341 [no_CLDV_RSN_CD] => [dealemp_NM] => 강현웅 [crg_ST] => 91 [scan_HOUR] => 140206 [invc_NO] => 844158250795 [rcpt_DV] => 02 [acptr_NM] => 사회적기업리맨 [scan_YMD] => 20250911 [detail_RSN] => [dealt_BRAN_NM] => 경기포천선단 [cust_USE_NO] => 503_R [crg_ST_NM] => 배송완료 )
							)
						)
					*/

		}

	}



	// [준비중] 기부현황 목록 관리
	private function donation_lists() {

		//print_r($this->user);
		
		
		// 허린(1716 카카오 incoreain@gmail.com)
		if(1716 == $this->user_idx) {
			// echo $this->user_idx;
			//$this->user_idx = 3020; // 권규나
			//$this->user_idx = 3034; // 정유진
			//$this->user_idx = 3026; // 최은영
			//$this->user_idx = 3013; // 송진우
			//$this->user_idx = 2974; // 홍경희
			//$this->user_idx = 3011; // 김덕향
			//$this->user_idx = 2999; // 김채은
			
			//$this->user_idx = 2985; // 서덕균
			//$this->user_idx = 2929; // 박지은
			
			//$this->user_idx = 3063; // 전은주
		}

		// 목록 가져오기
		$arr_where = array(
				'sql_select'     => 'dn.*, cmp.code, cmp.cmp_title, cmp.cmp_term_begin, cmp.cmp_term_end, cmp.cmp_term_end, cmp.state',
				'sql_from'       => 'donation as dn',
				'sql_join_tbl'   => 'campaign as cmp',
				'sql_join_on'    => 'dn.cmp_idx = cmp.idx',
				//'sql_where'      => array('dn.user_idx'=>$this->user_idx, 'dn.delete'=>NULL),
				'sql_where'      => array('dn.user_idx'=>$this->user_idx,'dn.delete'=>NULL),
				'sql_order_by'   => 'dn.reg_datetime DESC'
		);
		$result = $this->basic_model->arr_get_result($arr_where);

		//print_r($result);
		$list = array();
		$ino = 0;
		foreach($result['qry'] as $key => $row) {

			//print_r($row);

			$list[$ino] = new stdClass();


			$dn_idx = $row->idx;

			// 번호
			//$num = ($result['total_count'] - $limit*($page-1) - $ino);
			$num = ($result['qry_count'] - $ino);
			$list[$ino]->num = $num;

			$list[$ino]->idx = $row->idx;
			$list[$ino]->user_idx = $row->user_idx;
			$list[$ino]->cmp_code = $row->code;
			$list[$ino]->cmp_title = $row->cmp_title;
			$list[$ino]->cmp_term_begin = $row->cmp_term_begin;
			$list[$ino]->cmp_term_end = $row->cmp_term_end;
			$list[$ino]->cmp_term = $row->cmp_term_begin.'~'.$row->cmp_term_end;
			$list[$ino]->reg_datetime = $row->reg_datetime;
			$reg_date = substr($row->reg_datetime,0,10);
			$list[$ino]->reg_date = $reg_date;

			$list[$ino]->state = $row->state;
			$state_str = '<button class="btn o_btn btn-xs btn-silver-flat" disabled>작성</button>';
			if('submit' == $row->state) :
				$state_str = '<button class="btn o_btn btn-xs btn-success-flat">제출</button>';
			elseif('launch' == $row->state) :
				$state_str = '<button class="btn o_btn btn-xs btn-primary-flat">런칭</button>';
			endif;
			$list[$ino]->state_str = $state_str;






			// 기부물품목록 가져오기
			$arr_where_dng = array(
					'sql_select'     => 'gd_type, gd_amt, gd_grade',
					'sql_from'       => 'donation_goods',
					'sql_where'      => array('user_idx'=>$this->user_idx,'dn_idx'=>$row->idx),
					'sql_order_by'   => 'reg_datetime DESC'
			);
			$result_dng = $this->basic_model->arr_get_result($arr_where_dng);

			//print_r($result_dngood);
			//echo '<hr />';

			$dng_list = array();
			$dng_str = '';
			foreach($result_dng['qry'] as $key_dng => $row_dng) {
				$dng_str .= ('' != $dng_str) ? '/' : '';
				$dng_str .= ('' != $row_dng->gd_type) ? $row_dng->gd_type : '';
			}
			//echo $dng_str.'<<<br />';
			$list[$ino]->dng_str = $dng_str;


			// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
			//echo '<br />수거: '.$row->pickup_date;
			//echo '<br />검수: '.$row->check_date;
			// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
			// ROS에 저장된 진행상황 날짜들 가져오기
			if(NULL == $row->pickup_date OR NULL == $row->check_date) {
				// [개발용 주소] // 로컬 작업용 pc
				//$post_url = 'http://183.99.21.70:8080/replus/getStateDate';  
				// [실제사용주소]
				$post_url = 'https://ros.remann.co.kr/replus/getStateDate'; // ros.remann.co.kr/replus/getStateDate
				$cert_key = 'ub9acud50cub7ecuc2a4u0072u006fu0073uc5f0ub3d9';
				$curl_data = array('id'=>$dn_idx,'key'=>$cert_key);
				$output_json = $this->curl_post_ros($post_url, $curl_data); // return 등록한 작업요청id값
				$output_arr = json_decode($output_json, true);
				//echo $output_json;
				//print_r($output_arr);
				// Array ( [inspDate] => 2025-08-12 [whDate] => )

				$whDate = (! empty($output_arr['whDate']) && ! is_null($output_arr['whDate'])) ? $output_arr['whDate'] : '';
				$inspDate = (! empty($output_arr['inspDate']) && ! is_null($output_arr['inspDate'])) ? $output_arr['inspDate'] : '';

				// 만약 실입고 없이 검수로 넘어가면..
				// 그래서 검수날짜는 있는데 수거날짜가 없으면 검수날짜를 수거날짜에도 넣어줘라!
				if('' != $inspDate && '' == $whDate) {
					$whDate = $inspDate;
				}

				//$row->whDate = $whDate;
				//$row->inspDate = $inspDate;

				$list[$ino]->whDate = $whDate;
				$list[$ino]->inspDate = $inspDate;


				// 업데이트
				if('' != $whDate) {
					// 수거날짜 업데이트
					$this->campaign_lib->dn_update_date($dn_idx, $whDate,'pickup_date');

					$row->pickup_date = $whDate;
					$row->state_pickup = 1;
				}
				if('' != $inspDate) {
					// 검수날짜 업데이트
					$this->campaign_lib->dn_update_date($dn_idx, $inspDate, 'check_date',);

					$row->check_date = $inspDate;
					$row->state_check = 1;
				}

			}
			// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -












			// - - - - - - - - - - - - - - - - - - - - - - - - - - -
			// 경사원 캠페인에서 '수거신청' 버튼 노출을 위한 처리
			// - - - - - - - - - - - - - - - - - - - - - - - - - - -
			$active_return_btn = false;
			$cj_rcpt_dv = '';

			//if('redi' == $row->cmp_code) {

				if( $row->cj_return != 'success' ) { // 택배 반품 신청 성공 여부

					// [개발용 주소] // 로컬 작업용 pc
					//$post_url = 'http://183.99.21.70:8080/cj/getGdsTrc';  
					// [실제사용주소]
					$post_url = 'https://ros.remann.co.kr/cj/getGdsTrc';
					$curl_data = array('id'=>$row->idx);
					//print_r($curl_data);

					$output_json = $this->curl_post_ros($post_url, $curl_data); // return 등록한 작업요청id값

					/*
					if('14.42.161.237' == REMOTE_ADDR) {
						echo $row->idx.'<<<<br />'; // 581
						print_r($output_json);
						echo '<hr />';
					}
					*/

					$output_arr = json_decode($output_json, true); // $output_arr['data'][0]


					if( isset($output_arr['data'])  && ! empty($output_arr['data']) ) {

						// [1] 리턴값 오류일 경우
						// [2] 리턴값 정상일 경우

						// 마지막 배송 추적 데이터(가장 최신 행적)
						$trackingData = isset($output_arr['data']) ? end($output_arr['data']) : false;


						// 예약 구분(1차[01], 2차 반품[02])
						$rcpt_dv = isset($trackingData['rcpt_DV']) ? $trackingData['rcpt_DV'] : '';
						// 배송상태 코드 [1차 배송완료: 91]
						$tracking_code = isset($trackingData['crg_ST']) ? $trackingData['crg_ST'] : '';
						// 배송상태 설명 [1차 배송완료: 배송완료]
						$tracking_state = isset($trackingData['crg_ST_NM']) ? $trackingData['crg_ST_NM'] : '';

						// 1차 배송 정보 업데이트
						if($rcpt_dv == '01') {
							$cj_rcpt_dv = $rcpt_dv;
							// 1차 배송 정보 업데이트
							if('' != $tracking_state) {
								// 추적 코드
								$this->campaign_lib->dn_update_tracking($row->idx, $tracking_state,'cj_book_state');
							}
						}

						// 1차 택배접수 건이 배송완료되어 사용자에게 도착했을 때만 수거신청 버튼 활성화
						//$active_return_btn = false;
						if($rcpt_dv == '01' && $tracking_state == '배송완료'){
							$active_return_btn = true;
						}

					}
					// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

				}

			//}

			$list[$ino]->cj_rcpt_dv = $cj_rcpt_dv; // '01' 이면 1차 택배접수건, '02' 이면 2차 반품 접수건
			$list[$ino]->active_return_btn = $active_return_btn;

 
			/*
					Array ( 
					[data] => Array ( 
						[0] => Array ( 
							[id] => 341 
							[no_CLDV_RSN_CD] => 
							[dealemp_NM] => 강현웅 
							[crg_ST] => 91 
							[scan_HOUR] => 140206 
							[invc_NO] => 844158250795 
							[rcpt_DV] => 02 
							[acptr_NM] => 사회적기업리맨 
							[scan_YMD] => 20250911 
							[detail_RSN] => 
							[dealt_BRAN_NM] => 경기포천선단 
							[cust_USE_NO] => 503_R 
							[crg_ST_NM] => 배송완료
							)
						)
					)

					Array ( 
						[id] => 2 
						[no_CLDV_RSN_CD] => 
						[crg_ST] => 01 
						[rcpt_DV] => 01 
						[crg_ST_NM] => 집화지시 
						[dealemp_NM] => 박*업 
						[dealt_BRAN_NM] => 경기포천신내촌 
						[acptr_NM] => 본인 
						[invc_NO] => 685140735832 
						[detail_RSN] => 
						[cust_USE_NO] => 314 
						[scan_YMD] => 20250828 
						[scan_HOUR] => 141915
					)


				{"data":[{"id":341,"no_CLDV_RSN_CD":"","dealemp_NM":"강현웅","crg_ST":"91","scan_HOUR":"140206","invc_NO":"844158250795","rcpt_DV":"02","acptr_NM":"사회적기업리맨","scan_YMD":"20250911","detail_RSN":"","dealt_BRAN_NM":"경기포천선단","cust_USE_NO":"503_R","crg_ST_NM":"배송완료"}]}



			*/


			// 수거신청 버튼 OR 신청 완료 배치
			$list[$ino]->pickup_req_date = $row->pickup_req_date;


			/*
			if('redi' == $row->code) {

				if($reg_date == TIME_YMD) {
					// 기부 당일은 대기 상태 처리
					$btn_updateWaState = '<span class="badge btn-primary-flat btn-xs" data-idx="'. $row->idx .'" disabled title="수거박스를 받으시면, 물품포장을 완료하신 후 수거신청을 해주세요." style="font-weight:normal; filter: grayscale(100%); padding: 1px 5px; width: 55px; line-height: 22px;">신청 대기</span>';
				}
				elseif( is_null($row->pickup_req_date) ) {
					// 수거신청 처리가 안된 상태

					if( ! is_null($row->cj_return_dt) ){
						// 수거 버튼은 눌렀으나 여러 이유로 처리가 안됐을 때, 관리자에는 '재수거' 버튼 활성화
						$btn_updateWaState = '<span class="badge bg-dark" style="font-weight:normal; padding: 1px 5px; width: 55px; line-height: 22px;">접수 완료</span>';
					}
					else {
						// 수거 버튼을 아직 누르지 않았을 때.
						$btn_updateWaState = '<button class="btn btn-primary-flat btn-xs btn_updateWaState" data-idx="'. $row->idx .'" style="font-weight:bold; padding: 1px 5px; width: 55px; line-height: 22px;">수거 신청</button>';
					}
				}
				else {
					$btn_updateWaState = '<span class="badge bg-dark" style="font-weight:normal; padding: 1px 5px; width: 55px; line-height: 22px;">신청 완료</span>';
				}

			}
			else {
				// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
				// 경사원 캠페인(redi)가 아니면 신청완료로 표기
				// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
				$btn_updateWaState = '<span class="badge bg-dark" style="font-weight:normal; padding: 1px 5px; width: 55px; line-height: 22px;">신청완료</span>';

			}
			*/
				
			/*
			*/

			/*
			if( $row->cj_return == 'success' ) {
				// 반품 완료 == 수거 신청 완료
				$btn_updateWaState = '<span class="badge bg-dark" style="font-weight:normal; padding: 1px 5px; width: 55px; line-height: 22px;">신청 완료</span>';
			}
			else if( $active_return_btn && is_null($row->pickup_req_date) ) {
				$btn_updateWaState = '<button class="btn btn-primary-flat btn-xs btn_updateWaState" data-idx="'. $row->idx .'" style="font-weight:bold; padding: 1px 5px; width: 55px; line-height: 22px;">수거 신청</button>';
			}
			else if( ! $active_return_btn && is_null($row->pickup_req_date) ) {
				$btn_updateWaState = '<button class="btn btn-primary-flat btn-xs btn_updateWaState" data-idx="'. $row->idx .'" style="font-weight:bold; padding: 1px 5px; width: 55px; line-height: 22px;">수거 신청</button>';
			}
			else {
				$btn_updateWaState = '<span class="badge btn-primary-flat btn-xs" data-idx="'. $row->idx .'" disabled title="수거박스를 받으시면, 물품포장을 완료하신 후 수거신청을 해주세요." style="font-weight:normal; filter: grayscale(100%); padding: 1px 5px; width: 55px; line-height: 22px;">신청 대기</span>';
			}
			*/











			/* [2026-02-10] */
			/*
			if($reg_date == TIME_YMD) {
				// 기부 당일은 대기 상태 처리
				$btn_updateWaState = '<span class="badge btn-primary-flat btn-xs" data-idx="'. $row->idx .'" disabled title="수거박스를 받으시면, 물품포장을 완료하신 후 수거신청을 해주세요." style="font-weight:normal; filter: grayscale(100%); padding: 1px 5px; width: 55px; line-height: 22px;">신청 대기</span>';
			}
			elseif( is_null($row->pickup_req_date) ) {
				// 수거신청 처리가 안된 상태

				if( ! is_null($row->cj_return_dt) ){
					// 수거 버튼은 눌렀으나 여러 이유로 처리가 안됐을 때, 관리자에는 '재수거' 버튼 활성화
					$btn_updateWaState = '<span class="badge bg-dark" style="font-weight:normal; padding: 1px 5px; width: 55px; line-height: 22px;">접수 완료</span>';
				}
				else {
					// 수거 버튼을 아직 누르지 않았을 때.
					$btn_updateWaState = '<button class="btn btn-primary-flat btn-xs btn_updateWaState" data-idx="'. $row->idx .'" style="font-weight:bold; padding: 1px 5px; width: 55px; line-height: 22px;">수거 신청</button>';
				}
			}
			else {
				$btn_updateWaState = '<span class="badge bg-dark" style="font-weight:normal; padding: 1px 5px; width: 55px; line-height: 22px;">신청 완료</span>';
			}
			*/



			/* [2026-02-11] */
			/*
			$btn_updateWaState = '';
			if($reg_date == TIME_YMD) {
				// 기부 당일은 대기 상태 처리
				// [1]
				$btn_updateWaState = '<span class="badge btn-primary-flat btn-xs" data-idx="'. $row->idx .'" disabled title="수거박스를 받으시면, 물품포장을 완료하신 후 수거신청을 해주세요." style="font-weight:normal; filter: grayscale(100%); padding: 1px 5px; width: 55px; line-height: 22px;">신청 대기</span>';
			}
			elseif( is_null($row->pickup_req_date) ) {
				// 수거신청 처리가 안된 상태

				if( is_null($row->cj_return_dt) ){
					// 수거 버튼은 눌렀으나 여러 이유로 처리가 안됐을 때, 관리자에는 '재수거' 버튼 활성화
					$btn_updateWaState = '<span class="badge bg-dark" style="font-weight:normal; padding: 1px 5px; width: 55px; line-height: 22px;">접수 완료</span>';
				}
				else {
					
					//echo $row->cj_tracking_dv_code.'<<br />';
					//echo $row->cj_tracking_state.'<<br />';
					
					if( $row->cj_tracking_dv_code == '01') {
						// 1차 배송완료 이후, 수거 버튼 노출
						$btn_updateWaState = '<span class="badge bg-dark" style="font-weight:normal; padding: 1px 5px; width: 65px; line-height: 22px;">박스 배송중</span>';
						if($row->cj_tracking_state == '배송완료' OR $row->cj_tracking_code == '91') {
							// 1차 배송완료 상태
							$btn_updateWaState = '<button class="btn btn-primary-flat btn-xs btn_updateWaState" data-idx="'. $row->idx .'" style="font-weight:bold; padding: 1px 5px; width: 55px; line-height: 22px;">수거 신청</button>';
						}
					}
					else {
						$btn_updateWaState = '<span class="badge bg-secondary" style="font-weight:normal; padding: 1px 5px; width: 65px; line-height: 22px; ">박스 준비중</span>';
					}
				}
			}
			else {
				
				if( $row->cj_tracking_dv_code == '02') {
					// 1차 배송완료 이후, 수거 버튼 노출
					$btn_updateWaState = '<span class="badge bg-dark" style="font-weight:normal; padding: 1px 5px; width: 65px; line-height: 22px;">박스 수거중</span>';
					if($row->cj_tracking_state == '배송완료') {
						$btn_updateWaState = '<span class="badge bg-dark" style="font-weight:normal; padding: 1px 5px; width: 55px; line-height: 22px;">배송 완료</span>';
					}
				}
				else {
					$btn_updateWaState = '<span class="badge bg-dark" style="font-weight:normal; padding: 1px 5px; width: 55px; line-height: 22px;">신청 완료</span>';
				}
			}
			*/
			
			
			/* [2026-02-19] */
			$btn_updateWaState = '';
			if($reg_date == TIME_YMD) {
				// 기부 당일은 대기 상태 처리
				// [1]
				$btn_updateWaState = '<span class="badge btn-primary-flat btn-xs" data-idx="'. $row->idx .'" disabled title="수거박스를 받으시면, 물품포장을 완료하신 후 수거신청을 해주세요." style="font-weight:normal; filter: grayscale(100%); padding: 1px 5px; width: 55px; line-height: 22px;">접수 대기</span>';
			}
			elseif( is_null($row->pickup_req_date) ) {
				//echo $row->cj_tracking_dv_code.'<<br />';
				//echo $row->cj_tracking_state.'<<br />';
				
				if( $row->cj_tracking_dv_code == '01') {
					// 1차 배송완료 이후, 수거 버튼 노출
					$btn_updateWaState = '<span class="badge bg-dark" style="font-weight:normal; padding: 1px 5px; width: 65px; line-height: 22px;">박스 배송중</span>';
					if( $row->cj_tracking_code == '91' OR $row->cj_tracking_state == '배송완료' ) {
						// 1차 배송완료 상태
						$btn_updateWaState = '<button class="btn btn-primary-flat btn-xs btn_updateWaState" data-idx="'. $row->idx .'" style="font-weight:bold; padding: 1px 5px; width: 55px; line-height: 22px;">수거 신청</button>';
					}
					elseif( $row->cj_tracking_code == '82' ) {
						// 1차 배송 출발 상태
						$btn_updateWaState = '<span class="badge bg-secondary" style="font-weight:normal; padding: 1px 5px; width: 65px; line-height: 22px; ">박스 배송중</span>';
					}
					else {
						$btn_updateWaState = '<span class="badge bg-secondary" style="font-weight:normal; padding: 1px 5px; width: 65px; line-height: 22px; ">박스 준비중</span>';
					}

				}
				else {
					$btn_updateWaState = '<span class="badge bg-secondary" style="font-weight:normal; padding: 1px 5px; width: 65px; line-height: 22px; ">접수 완료</span>';
				}

			}
			else {
				
				if( $row->cj_tracking_dv_code == '02') {
					if( $row->cj_tracking_code == '91' OR $row->cj_tracking_state == '배송완료' ) {
						$btn_updateWaState = '<span class="badge bg-dark" style="font-weight:normal; padding: 1px 5px; width: 55px; line-height: 22px;">배송 완료</span>';
					}
					elseif( $row->cj_tracking_code == '82' ) {
						// 2차 배송 출발 상태
						$btn_updateWaState = '<span class="badge bg-secondary" style="font-weight:normal; padding: 1px 5px; width: 65px; line-height: 22px; ">박스 수거중</span>';
					}
					else {
						// 1차 배송완료 이후, 수거 버튼 노출
						$btn_updateWaState = '<span class="badge bg-secondary" style="font-weight:normal; padding: 1px 5px; width: 65px; line-height: 22px; ">신청 완료</span>';
					}
				}
				else {
					$btn_updateWaState = '<span class="badge bg-dark" style="font-weight:normal; padding: 1px 5px; width: 55px; line-height: 22px;">신청 완료.</span>';
				}
			}
			
			
			
			$list[$ino]->btn_updateWaState = $btn_updateWaState;


			/*
				[$row->cj_tracking_code]
				"crg_ST":"01","rcpt_DV":"01","crg_ST_NM":"집화지시"
				"crg_ST":"11","rcpt_DV":"01","crg_ST_NM":"집화처리"
				"crg_ST":"82","rcpt_DV":"01","crg_ST_NM":"배송출발"
				"crg_ST":"91","rcpt_DV":"01","crg_ST_NM":"배송완료"
			*/











			// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
			// 기부 물품 현재 상태
			// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
				// 기부 물품 현재 상태 renewal
				$state_good_proc = '접수';

				$state_accept_txt = '';
				$state_pickup_txt = '';
				$state_check_txt = '';
				$state_cmpl_txt = '';

				if(! is_null($row->handout_finish_date)) {
					$state_good_proc = "<strong>완료</strong>";

					$state_accept_txt = '완료';
					$state_pickup_txt = '완료';
					$state_check_txt = '완료';
					$state_cmpl_txt = '완료';
				}
				else if(! is_null($row->check_date)) {
					$state_good_proc = "<strong>검수</strong>";

					$state_accept_txt = '완료';
					$state_pickup_txt = '완료';
					$state_check_txt = '완료';
				}
				else if(! is_null($row->pickup_date)) {
					$state_good_proc = "수거";

					$state_accept_txt = '완료';
					$state_pickup_txt = '완료';
					$state_check_txt = '';
				}
				else if(! is_null($row->reg_datetime)) {
					$state_good_proc = "접수";

					$state_accept_txt = '완료';
					$state_pickup_txt = '';
					$state_check_txt = '';
				}

				// 현재 진행상태
				$state_good_proc = $state_good_proc;
			// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -



			/*
			$list[$ino]->state_reg_txt = $state_reg_txt;
			$list[$ino]->state_pickup_txt = $state_pickup_txt;
			$list[$ino]->state_check_txt = $state_check_txt;
			$list[$ino]->state_recycle_txt = $state_recycle_txt;
			$list[$ino]->state_handout_txt = $state_handout_txt;
			$list[$ino]->state_handout_finish_txt = $state_handout_finish_txt;
			*/
			// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - //


			if(NULL != $row->delete) {
				$state_good_proc = '관리자 삭제';
			}

			$list[$ino]->state_good_proc = $state_good_proc;
			//$list[$ino]->delete = $row->delete;

			$ino++;
		}

		//print_r($list);


		/*
		// 페이지
		$viewPage = 'mypage/pc_donation_lists_view';
		// 모바일 - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		if(IS_MOBILE) :
			$viewPage = 'mypage/mobile_donation_lists_view';
		endif;
		*/

		// 페이지
		$viewPage = 'mypage/donation_lists_view';


		// 데이터 - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		$data = array(
			'list' => $list,
			'viewPage' => $viewPage
		);
		$this->load->view('layout_view', $data);
	}





	// [준비중] 기부현황 상세
	private function donation_detail($cmp_code=FALSE, $dn_idx=FALSE) {

		if(! $cmp_code) {
			alert('존재하지 않거나 삭제된 캠페인입니다.',base_url().'mypage/donation/lists');
			exit;
		}

		// 캠페인 정보
		$arr_where = array(
				'sql_select'     => '*',
				'sql_from'       => 'campaign',
				'sql_where'      => array('code'=>$cmp_code)
		);
		$cmp_row = $this->basic_model->arr_get_row($arr_where);

		if(! $cmp_row->idx) {
			alert('존재하지 않거나 삭제된 캠페인입니다.',base_url().'mypage/donation/lists');
			exit;
		}


		// 기부 정보
		$arr_where = array(
				'sql_select'     => '*',
				'sql_from'       => 'donation',
				'sql_where'      => array('idx'=>$dn_idx, 'cmp_code'=>$cmp_code, 'user_idx'=>$this->user_idx, 'delete'=>NULL)
		);
		$dn_row = $this->basic_model->arr_get_row($arr_where);

		if(! isset($dn_row->idx)) {
			alert('존재하지 않거나 삭제된 기부내역입니다.',base_url().'mypage/donation/lists');
			exit;
		}

		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		// 기부 물품 현재 상태
		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		/*
		$state_good_proc = '접수 완료';

		$dn_row->state_reg_txt = '';
		$dn_row->state_pickup_txt = '';
		$dn_row->state_check_txt = '';
		$dn_row->state_recycle_txt = '';
		$dn_row->state_handout_txt = '';
		$dn_row->state_handout_finish_txt = '';

		// echo $dn_row->state_reg.'<<<br />';

		$state_good_proc = ('1' == $dn_row->state_reg) ? '접수 완료' : '접수 중';
		$dn_row->state_reg_txt = $state_good_proc;

		if('' != $dn_row->pickup_date && '1' == $dn_row->state_reg) {
			$state_good_proc = ('1' == $dn_row->state_pickup) ? '수거 완료' : '수거 중';
			$dn_row->state_pickup_txt = $state_good_proc;
		}
		if('' != $dn_row->check_date && '1' == $dn_row->state_pickup) {
			$state_good_proc = ('1' == $dn_row->state_check) ? '검수 완료' : '검수 중';
			$dn_row->state_check_txt = $state_good_proc;
		}
		if('' != $dn_row->recycle_date && '1' == $dn_row->state_check) {
			$state_good_proc = ('1' == $dn_row->state_recycle) ? '재생 완료' : '재생 중';
			$dn_row->state_recycle_txt = $state_good_proc;
		}
		// * 
		if('' != $dn_row->handout_date && '1' == $dn_row->state_recycle) {
			$state_good_proc = ('1' == $dn_row->state_handout) ? '나눔 완료1' : '나눔 중';
			$dn_row->state_handout_txt = $state_good_proc;
		}
		if('' != $dn_row->handout_finish_date && '1' == $dn_row->state_handout) {
			$state_good_proc = ('1' == $dn_row->state_handout_finish) ? '나눔 완료3' : '나눔 완료2';
			$dn_row->state_handout_finish_txt = $state_good_proc;
		}
		// * /

		if('' != $dn_row->handout_date && '1' == $dn_row->state_recycle) {
			$state_good_proc = ('1' == $dn_row->state_handout) ? '나눔 완료' : '나눔 중';
			$dn_row->state_handout_txt = $state_good_proc;
		}

		$dn_row->state_good_proc = $state_good_proc;
		*/


		
		// 처리옵션
		$opt_request_ko = '';
		if(isset($dn_row->opt_request) && 'data_reset' == $dn_row->opt_request) {
			$opt_request_ko = '데이터 삭제';
		}
		else if(isset($dn_row->opt_request) && 'discard' == $dn_row->opt_request) {
			$opt_request_ko = '폐기';
		}
		$dn_row->opt_request_ko = $opt_request_ko;


		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - //



		// 물품 가져오기
		$arr_where = array(
				'sql_select'     => '*',
				'sql_from'       => 'donation_goods',
				'sql_where'      => array('dn_idx'=>$dn_row->idx, 'user_idx'=>$this->user_idx),
				'sql_order_by'   => 'idx asc'
		);
		$dngoods_result = $this->basic_model->arr_get_result($arr_where);

		$dngoods_list = array();
		foreach($dngoods_result['qry'] as $i => $o) {
			$dngoods_list[$i] = new stdClass();

			$dngoods_list[$i]->gd_type = $o->gd_type;
			$dngoods_list[$i]->gd_amt = $o->gd_amt;
			$dngoods_list[$i]->gd_grade = $o->gd_grade;

			$dngoods_list[$i]->gd_maker = $o->gd_maker;
			$dngoods_list[$i]->gd_model = $o->gd_model;
			$dngoods_list[$i]->gd_part = $o->gd_part;
			$dngoods_list[$i]->gd_memo = $o->gd_memo;

		}

		// 업로드 이미지 정보
		$arr = array(
				'sql_select'     => '*',
				'sql_from'       => 'file_manager',
				'sql_where'      => array('wr_table'=>'donation', 'wr_table_idx'=>$dn_row->idx, 'upload_type' => 'form', 'file_type'=>'image'),
				'sql_order_by'   => 'idx DESC'
		);
		$file_result = $this->basic_model->arr_get_result($arr);
		//print_r($file_result);



		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		// ROS에 저장된 진행상황 날짜들 가져오기
			// [개발용 주소] // 로컬 작업용 pc
			//$post_url = 'http://183.99.21.70:8080/replus/getStateDate';  
			// [실제사용주소]
			$post_url = 'https://ros.remann.co.kr/replus/getStateDate'; // ros.remann.co.kr/replus/getStateDate
			$cert_key = 'ub9acud50cub7ecuc2a4u0072u006fu0073uc5f0ub3d9';
			$curl_data = array('id'=>$dn_idx,'key'=>$cert_key);
			$output_json = $this->curl_post_ros($post_url, $curl_data); // return 등록한 작업요청id값
			$output_arr = json_decode($output_json, true);
			//echo $output_json;
			//print_r($output_arr);
			// Array ( [inspDate] => 2025-08-12 [whDate] => )

			$whDate = (! empty($output_arr['whDate']) && ! is_null($output_arr['whDate'])) ? $output_arr['whDate'] : '';
			$inspDate = (! empty($output_arr['inspDate']) && ! is_null($output_arr['inspDate'])) ? $output_arr['inspDate'] : '';

			// 만약 실입고 없이 검수로 넘어가면..
			// 그래서 검수날짜는 있는데 수거날짜가 없으면 검수날짜를 수거날짜에도 넣어줘라!
			if('' != $inspDate && '' == $whDate) {
				$whDate = $inspDate;
			}

			$dn_row->whDate = $whDate;
			$dn_row->inspDate = $inspDate;


			// 업데이트
			if('' != $whDate) {
				// 수거날짜 업데이트
				$this->campaign_lib->dn_update_date($dn_idx, $whDate,'pickup_date');

				$dn_row->pickup_date = $whDate;
				$dn_row->state_pickup = 1;
			}
			if('' != $inspDate) {
				// 검수날짜 업데이트
				$this->campaign_lib->dn_update_date($dn_idx, $inspDate, 'check_date',);

				$dn_row->check_date = $inspDate;
				$dn_row->state_check = 1;
			}




			/*
			$info_date = new stdClass();
			$info_date->whDate = $whDate; // 수거완료일자
			$info_date->inspDate = $inspDate; // 검수완료일자

			// 만약 실입고 없이 검수로 넘어가면..
			// 그래서 검수날짜는 있는데 수거날짜가 없으면 검수날짜를 수거날짜에도 넣어줘라!
			if('' != $info_date->inspDate && '' == $info_date->whDate) {
				$info_date->whDate = $info_date->inspDate;
			}
			*/
		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -


		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		/*
			// 기부 물품 현재 상태 renewal
			$state_good_proc = '접수 완료';

			$dn_row->state_accept_txt = '';
			$dn_row->state_pickup_txt = '';
			$dn_row->state_check_txt = '';

			if('' != $inspDate) {
				$state_good_proc = "검수 완료";

				$dn_row->state_accept_txt = '완료';
				$dn_row->state_pickup_txt = '완료';
				$dn_row->state_check_txt = '완료';
			}
			else if('' != $whDate) {
				$state_good_proc = "수거 완료";

				$dn_row->state_accept_txt = '완료';
				$dn_row->state_pickup_txt = '완료';
				$dn_row->state_check_txt = '';
			}
			else if('' != $dn_row->reg_datetime) {
				$state_good_proc = "접수 완료";

				$dn_row->state_accept_txt = '완료';
				$dn_row->state_pickup_txt = '';
				$dn_row->state_check_txt = '';
			}

			// 현재 진행상태
			$dn_row->state_good_proc = $state_good_proc;
		*/
		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

			$state_step = '';
			/*
			if('' != $dn_row->reg_datetime) {
				//$state_step = '<button type="button" class="btn btn-outline-secondary btn-xs" readonly>접수</button>';
			}
			if('1' == $dn_row->state_pickup  &&  '' != $dn_row->pickup_date) {
				//$state_step = '<button type="button" class="btn btn-secondary btn-xs" readonly>수거</button>';
			}
			if('1' == $dn_row->state_check  &&  '' != $dn_row->check_date) {
				//$state_step = '<button type="button" class="btn btn-success btn-xs">검수</button>';
			}
			if('1' == $dn_row->state_handout_finish  &&  '' != $dn_row->handout_finish_date) {
				//$state_step = '<button type="button" class="btn btn-primary btn-xs">완료</button>';
			}
			*/


			$dn_row->state_accept_txt = '';
			$dn_row->state_pickup_txt = '';
			$dn_row->state_check_txt = '';
			$dn_row->state_cmpl_txt = '';


			if('1' == $dn_row->state_handout_finish  &&  '' != $dn_row->handout_finish_date) {
				$state_good_proc = "완료";
				//$state_step = '<button type="button" class="btn btn-primary btn-xs">완료</button>';
				$dn_row->state_accept_txt = '완료';
				$dn_row->state_pickup_txt = '완료';
				$dn_row->state_check_txt = '완료';
				$dn_row->state_cmpl_txt = '완료';
			}
			else if('1' == $dn_row->state_check  &&  '' != $dn_row->check_date) {
				$state_good_proc = "검수";
				//$state_step = '<button type="button" class="btn btn-success btn-xs">검수</button>';
				$dn_row->state_accept_txt = '완료';
				$dn_row->state_pickup_txt = '완료';
				$dn_row->state_check_txt = '완료';
				$dn_row->state_cmpl_txt = '';
			}
			else if('1' == $dn_row->state_pickup  &&  '' != $dn_row->pickup_date) {
				$state_good_proc = "수거";
				//$state_step = '<button type="button" class="btn btn-secondary btn-xs" readonly>수거</button>';
				$dn_row->state_accept_txt = '완료';
				$dn_row->state_pickup_txt = '완료';
				$dn_row->state_check_txt = '';
				$dn_row->state_cmpl_txt = '';
			}
			else if('' != $dn_row->reg_datetime) {
				$state_good_proc = "접수";
				//$state_step = '<button type="button" class="btn btn-outline-secondary btn-xs" readonly>접수</button>';
				$dn_row->state_accept_txt = '완료';
				$dn_row->state_pickup_txt = '';
				$dn_row->state_check_txt = '';
				$dn_row->state_cmpl_txt = '';
			}

			$dn_row->state_good_proc = $state_good_proc;




		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		// ROS에 저장된 상세 검수 현황 가져오기
			// [개발용 주소] // 로컬 작업용 pc
			//$post_url = 'http://183.99.21.70:8080/replus/getInsp';  
			// [실제사용주소]
			$post_url = 'https://ros.remann.co.kr/replus/getInsp'; // ros.remann.co.kr/replus/getInsp

			$cert_key = 'ub9acud50cub7ecuc2a4u0072u006fu0073uc5f0ub3d9';
			$curl_data = array('id'=>$dn_idx,'key'=>$cert_key);
			$output_json = $this->curl_post_ros($post_url, $curl_data); // return 등록한 작업요청id값
			$output_arr = json_decode($output_json, true);

			//print_r($output_arr);
			/*
				Array ( [data] => Array ( [0] => Array ( [insp_id] => [insp_kind] => 스마트폰 [user_idx] => [confirmYN] => [id] => [no] => [barcode] => [grade] => A [mfr] => DICOM [size] => [model] => [sn] => [extra_info] => [registeredDate] => 2025-08-18 [prodYn] => [fixYn] => [is_deleted] => [quick] => [autoYn] => [cgen_1] => [cclass_1] => [cmodel_1] => [cgen_2] => [cclass_2] => [cmodel_2] => [mmfr_1] => [mspec_1] => [mcapa_1] => [mmfr_2] => [mspec_2] => [mcapa_2] => [mmfr_3] => [mspec_3] => [mcapa_3] => [mmfr_4] => [mspec_4] => [mcapa_4] => [mmfr_5] => [mspec_5] => [mcapa_5] => [mmfr_6] => [mspec_6] => [mcapa_6] => [mmfr_7] => [mspec_7] => [mcapa_7] => [mmfr_8] => [mspec_8] => [mcapa_8] => [skind_1] => [smfr_1] => [scapa_1] => [ssn_1] => [skind_2] => [smfr_2] => [scapa_2] => [ssn_2] => [skind_3] => [smfr_3] => [scapa_3] => [ssn_3] => [skind_4] => [smfr_4] => [scapa_4] => [ssn_4] => [window] => [office] => [status] => [graphic_1] => [graphic_2] => [rmk_1] => [rmk_2] => [rmk_3] => [rmk_4] => [rmk_5] => [rmk_6] => [user_nm] => ) ) )

			*/

			// 가치
			$arr_worth_tbl = array('데스크탑','노트북','태블릿','스마트폰','기타');
			$arr_worth_tbl['데스크탑'] = new stdClass();
			$arr_worth_tbl['데스크탑']->A = 9200;
			$arr_worth_tbl['데스크탑']->B = 4200;
			$arr_worth_tbl['데스크탑']->C = 4200;
			$arr_worth_tbl['데스크탑']->D = 2000;

			$arr_worth_tbl['노트북'] = new stdClass();
			$arr_worth_tbl['노트북']->A = 23200;
			$arr_worth_tbl['노트북']->B = 13200;
			$arr_worth_tbl['노트북']->C = 13200;
			$arr_worth_tbl['노트북']->D = 2000;

			$arr_worth_tbl['태블릿'] = new stdClass();
			$arr_worth_tbl['태블릿']->A = 19200;
			$arr_worth_tbl['태블릿']->B = 11200;
			$arr_worth_tbl['태블릿']->C = 11200;
			$arr_worth_tbl['태블릿']->D = 1000;

			$arr_worth_tbl['스마트폰'] = new stdClass();
			$arr_worth_tbl['스마트폰']->A = 33200;
			$arr_worth_tbl['스마트폰']->B = 20200;
			$arr_worth_tbl['스마트폰']->C = 20200;
			$arr_worth_tbl['스마트폰']->D = 1000;

			$arr_worth_tbl['기타'] = new stdClass();
			$arr_worth_tbl['기타']->A = 0;
			$arr_worth_tbl['기타']->B = 0;
			$arr_worth_tbl['기타']->C = 0;
			$arr_worth_tbl['기타']->D = 0;


			$item_list = array();
			$arr_worth_val = array('reproduct'=>0, 'recycle'=>0);
			$arr_worth_cnt = array('reproduct'=>0, 'recycle'=>0);

			if( isset($output_arr['data']) && ! empty($output_arr['data']) && ! is_null($output_arr['data'])) {
				foreach ($output_arr['data'] as $i => $item) {
					// print_r($item);
					$item_list[$i] = new stdClass();

					$itm_insp_kind = $item['insp_kind'];
					$itm_grade = $item['grade'];

					$item_list[$i]->insp_kind = $itm_insp_kind;
					$item_list[$i]->mfr = $item['mfr'];
					$item_list[$i]->model = $item['model'];
					$item_list[$i]->sn = $item['sn'];
					$item_list[$i]->registeredDate = $item['registeredDate'];
					$item_list[$i]->rmk_1 = $item['rmk_1'];
					$item_list[$i]->grade = $itm_grade;

					$itm_worth_val = isset($arr_worth_tbl[$itm_insp_kind]->$itm_grade) ? $arr_worth_tbl[$itm_insp_kind]->$itm_grade : 0;
					$itm_worth_cnt = 0;

					if('D' == $itm_grade) {
						$arr_worth_val['recycle'] += $itm_worth_val;
						$arr_worth_cnt['recycle']++;
					}
					else {
						$arr_worth_val['reproduct'] += $itm_worth_val;
						$arr_worth_cnt['reproduct']++;
					}
				}
			}

			//print_r($arr_worth);

			$worth_val_total = array_sum($arr_worth_val);
			//print_r($worth_val_total);

		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -



		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		// 삭제보고서 블랑코 파일 링크
			// [개발용 주소] // 로컬 작업용 pc
			//$post_url = 'http://183.99.21.70:8080/replus/getInsp';  
			// [실제사용주소]
			$post_url = 'https://ros.remann.co.kr/replus/getDel'; // ros.remann.co.kr/replus/getDel

			$cert_key = 'ub9acud50cub7ecuc2a4u0072u006fu0073uc5f0ub3d9';
			$curl_data = array('id'=>$dn_idx,'key'=>$cert_key);
			$output_json = $this->curl_post_ros($post_url, $curl_data); // return 등록한 작업요청id값
			$output_arr = json_decode($output_json, true);

			$report = new stdClass();
			$resData = isset($output_arr['data'][0]) ? $output_arr['data'][0] : false;

			//print_r($resData);

			$download_blancco_link = '';
			$file_path = 'https://ros.remann.co.kr/resources/img/inspDel/';
			if(isset($resData['file_doc1_path']) && '' != $resData['file_doc1_path']) {
				$download_blancco_link = $file_path.$resData['file_doc1_path'];
			}
			//echo $download_blancco_link;
		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -



		// 페이지
		$viewPage = 'mypage/donation_detail_view';

		// 데이터 - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		$data = array(
			'cmp_row' => $cmp_row,
			'dn_row' => $dn_row,
			'dngoods_list' => $dngoods_list,
			'file_result' => $file_result,
			'item_list' => $item_list,
			'arr_worth_cnt' => $arr_worth_cnt,
			'arr_worth_val' => $arr_worth_val,
			'worth_val_total' => $worth_val_total,
			'download_blancco_link' => $download_blancco_link,
			'viewPage' => $viewPage
		);
		$this->load->view('layout_view', $data);
	}







	function buyback($method='lists', $request_id=FALSE)
	{
		if ('lists' === $method) {
			$this->buyback_lists();
			return;
		}

		if ('detail' === $method) {
			$this->buyback_detail($request_id);
			return;
		}

		show_404();
	}

	private function buyback_lists()
	{
		$rows = $this->Buyback_model->get_member_request_list($this->user_idx);
		$list = array();

		foreach ($rows as $row) {
			$devices = isset($row['devices']) && is_array($row['devices']) ? $row['devices'] : array();
			$list[] = array(
				'id' => (int) $row['id'],
				'request_no' => isset($row['request_no']) ? $row['request_no'] : '',
				'partner_name' => !empty($row['partner_name']) ? $row['partner_name'] : '-',
				'status' => isset($row['status']) ? $row['status'] : '',
				'status_label' => $this->buyback_status_label(isset($row['status']) ? $row['status'] : ''),
				'created_at' => isset($row['created_at']) ? $row['created_at'] : '',
				'created_date' => !empty($row['created_at']) ? substr($row['created_at'], 0, 10) : '',
				'total_price_value' => isset($row['total_price_value']) ? (int) $row['total_price_value'] : 0,
				'total_price_text' => $this->buyback_price_text(isset($row['total_price_value']) ? $row['total_price_value'] : 0),
				'device_summary' => $this->build_buyback_device_summary($devices),
				'detail_url' => '/mypage/buyback/detail/' . (int) $row['id'],
			);
		}

		$data = array(
			'list' => $list,
			'viewPage' => 'mypage/buyback_lists_view',
		);
		$this->load->view('layout_view', $data);
	}

	private function buyback_detail($request_id=FALSE)
	{
		$request_id = (int) $request_id;
		if ($request_id < 1) {
			redirect('/mypage/buyback/lists');
			return;
		}

		$row = $this->Buyback_model->get_member_request_detail($request_id, $this->user_idx);
		if (empty($row)) {
			alert('조회할 수 없는 매입 신청입니다.', '/mypage/buyback/lists');
			return;
		}

		$devices = array();
		foreach ((array) $row['devices'] as $device) {
			$devices[] = array(
				'device_type' => isset($device['device_type']) ? $device['device_type'] : '',
				'manufacturer' => isset($device['manufacturer']) ? $device['manufacturer'] : '',
				'model_name' => isset($device['model_name']) ? $device['model_name'] : '',
				'part_type' => isset($device['part_type']) ? $device['part_type'] : '',
				'category_name' => isset($device['category_name']) ? $device['category_name'] : '',
				'condition_grade' => isset($device['condition_grade']) ? $device['condition_grade'] : '',
				'qty' => isset($device['qty']) ? (int) $device['qty'] : 1,
				'price_text' => $this->buyback_price_text(isset($device['unit_price_value']) ? $device['unit_price_value'] : (isset($device['price_value']) ? $device['price_value'] : 0)),
				'specs' => isset($device['specs']) && is_array($device['specs']) ? $device['specs'] : array(),
				'label' => $this->build_buyback_device_label($device),
			);
		}

		$request = array(
			'id' => (int) $row['id'],
			'request_no' => isset($row['request_no']) ? $row['request_no'] : '',
			'partner_name' => !empty($row['partner_name']) ? $row['partner_name'] : '-',
			'status_label' => $this->buyback_status_label(isset($row['status']) ? $row['status'] : ''),
			'api_send_status_label' => $this->buyback_api_status_label(isset($row['api_send_status']) ? $row['api_send_status'] : ''),
			'applicant_name' => isset($row['applicant_name']) ? $row['applicant_name'] : '',
			'phone' => isset($row['phone']) ? $row['phone'] : '',
			'address1' => isset($row['address1']) ? $row['address1'] : '',
			'address2' => isset($row['address2']) ? $row['address2'] : '',
			'visit_date' => isset($row['visit_date']) ? $row['visit_date'] : '',
			'visit_time' => isset($row['visit_time']) ? $row['visit_time'] : '',
			'pickup_location' => isset($row['pickup_location']) ? $row['pickup_location'] : '',
			'pickup_memo' => isset($row['pickup_memo']) ? $row['pickup_memo'] : '',
			'bank_name' => isset($row['bank_name']) ? $row['bank_name'] : '',
			'account_number' => isset($row['account_number']) ? $row['account_number'] : '',
			'total_price_text' => $this->buyback_price_text(isset($row['total_price_value']) ? $row['total_price_value'] : 0),
			'created_at' => isset($row['created_at']) ? $row['created_at'] : '',
			'devices' => $devices,
		);

		$data = array(
			'request' => $request,
			'viewPage' => 'mypage/buyback_detail_view',
		);
		$this->load->view('layout_view', $data);
	}

	private function build_buyback_device_summary($devices)
	{
		$devices = is_array($devices) ? $devices : array();
		if (empty($devices)) {
			return '신청 기기 없음';
		}

		$first = $this->build_buyback_device_label($devices[0]);
		$count = count($devices);

		if ($count <= 1) {
			return $first;
		}

		return $first . ' 외 ' . ($count - 1) . '건';
	}

	private function build_buyback_device_label($device)
	{
		$parts = array();

		$device_type = isset($device['device_type']) ? trim((string) $device['device_type']) : '';
		$manufacturer = isset($device['manufacturer']) ? trim((string) $device['manufacturer']) : '';
		$model_name = isset($device['model_name']) ? trim((string) $device['model_name']) : '';
		$part_type = isset($device['part_type']) ? trim((string) $device['part_type']) : '';
		$category_name = isset($device['category_name']) ? trim((string) $device['category_name']) : '';

		if ($device_type !== '') {
			$parts[] = $device_type;
		}
		if ($part_type !== '') {
			$parts[] = $part_type;
		}
		if ($manufacturer !== '') {
			$parts[] = $manufacturer;
		}
		if ($category_name !== '' && $category_name !== $manufacturer) {
			$parts[] = $category_name;
		}
		if ($model_name !== '') {
			$parts[] = $model_name;
		}

		$parts = array_values(array_unique(array_filter($parts)));
		return !empty($parts) ? implode(' / ', $parts) : '기기 정보 없음';
	}

	private function buyback_status_label($status)
	{
		$labels = array(
			'REQUESTED' => '접수완료',
			'REVIEWING' => '검토중',
			'READY' => '처리대기',
			'SENT' => '전송완료',
			'FAILED' => '전송실패',
			'CANCELLED' => '취소',
		);

		return isset($labels[$status]) ? $labels[$status] : ($status !== '' ? $status : '-');
	}

	private function buyback_api_status_label($status)
	{
		$labels = array(
			'READY' => '전송 대기',
			'SENT' => '전송 완료',
			'FAILED' => '전송 실패',
		);

		return isset($labels[$status]) ? $labels[$status] : ($status !== '' ? $status : '-');
	}

	private function buyback_price_text($amount)
	{
		return number_format((int) $amount) . '원';
	}



	/* 내정보수정 - - - - - - - - - - - - - - - - - - - - - - - - - - - - */
	function user($page='edit') {

		if($this->user->level != 20) {
			redirect('/mypage/main');
			exit;
		}

		if($this->tank_auth->is_admin()) {
			alert('관리자 정보는 수정하실 수 없습니다.');
		}



		load_css('<link rel="stylesheet" href="'.LIB_DIR.'/datetimepicker-master/jquery.datetimepicker.min.css" />');
		load_js('<script src="'.LIB_DIR.'/datetimepicker-master/jquery.datetimepicker.full.js"></script>');


        //<!-- redactor.css -->
		load_css('<link rel="stylesheet" type="text/css" href="'. ASSETS_DIR .'/lib/editor/redactor/redactor.min.css" />');
    	//<!-- redactor.js -->
		load_js('<script src="'. ASSETS_DIR .'/lib/editor/redactor/redactor.min.js"></script>');
        //<!-- plugin js -->
		load_js('<script src="'. ASSETS_DIR .'/lib/editor/redactor/_plugins/fontsize/fontsize.js"></script>');
		load_js('<script src="'. ASSETS_DIR .'/lib/editor/redactor/_plugins/fontcolor/fontcolor.js"></script>');
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
		load_js('<script src="'. ASSETS_DIR .'/lib/editor/redactor/_plugins/fullscreen/fullscreen.js"></script>');

		//<!-- connect the languages file -->
		load_js('<script src="'. ASSETS_DIR .'/lib/editor/redactor/_langs/ko.js?v='.time().'"></script>');





		/** - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		* [2017-02-17] 회원가입 에러 메시지 CSS */
		// $this->form_validation->set_error_delimiters('<div class="error_member">','</div>');
		// $data['errors'] = array();


		// # 에러 메시지 CSS
		$this->form_validation->set_error_delimiters('<div class="error">','</div>');

		// 상호/법인명
		$this->form_validation->set_rules('company', '상호/법인명', 'trim|xss_clean');

		// 비밀번호 등록시에만 체크
		$password = $this->input->post('password','');
		$password_confirm = $this->input->post('password_confirm','');
		//$is_set_pw = FALSE;
		if( '' !== $password || '' !== $password_confirm ) {
		  $this->form_validation->set_rules('password', '비밀번호', 'trim|required|xss_clean|min_length['.$this->config->item('password_min_length', 'tank_auth').']|max_length['.$this->config->item('password_max_length', 'tank_auth').']');
		  $this->form_validation->set_rules('password_confirm', '비밀번호 확인', 'trim|required|xss_clean|matches[password]');
		  //$is_set_pw = TRUE;
		}


		if ($this->form_validation->run() !== FALSE) {

			$user_idx = $this->user_idx;
			if (!is_null($data = $this->tank_auth->user_edit($user_idx))) {		// success
				// 특정 페이지로 이동
				//redirect(current_url());

				alert('회원 정보가 수정되었습니다.',current_url());
				//redirect(current_url());
			}
			else {
				alert('회원 정보를 확인할 수 없습니다. 담당자에게 문의하세요.');
			}

		}



		$user = $this->users->get_user_by_id($this->user_idx, TRUE); // TRUE 는 'activated 회원'만을 의미
		$upro = $this->users->get_profile_by_id($this->user_idx);
		$data = array('user'=>$user, 'upro'=>$upro, 'viewPage'=>'mypage/user_edit_view');
		$this->load->view('layout_view', $data);
	}








	/* [참고용] 내정보수정 - - - - - - - - - - - - - - - - - - - - - - - - - - - - */
	function edit()
	{
		alert('준비중입니다.');
		exit; 

		if($this->tank_auth->is_admin()) {
			alert('관리자 정보는 수정하실 수 없습니다.');
		}


		/** - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		* [2017-02-17] 회원가입 에러 메시지 CSS */
		$this->form_validation->set_error_delimiters('<div class="error_member">','</div>');
		$data['errors'] = array();


		if( $this->input->post('submit') ) {

			//print_r($this->input->post());
			//exit;


				// 비밀번호 등록시에만 체크
				$password = $this->input->post('password','');
				$password_confirm = $this->input->post('password_confirm','');
				$is_set_pw = FALSE;
				if( '' !== $password || '' !== $password_confirm ) {
				  $this->form_validation->set_rules('password', '비밀번호', 'trim|required|xss_clean|min_length['.$this->config->item('password_min_length', 'tank_auth').']|max_length['.$this->config->item('password_max_length', 'tank_auth').']');
				  $this->form_validation->set_rules('password_confirm', '비밀번호 확인', 'trim|required|xss_clean|matches[password]');
				  $is_set_pw = TRUE;
				}


			// 공통
			/*
				username,nickname,email,password,confirm_password,comp_name,phone

			*/
				// 이름
				//$this->form_validation->set_rules('username', '아이디', 'trim|required|xss_clean');

				$this->form_validation->set_rules('nickname', '이름', 'trim|required|xss_clean');
				$this->form_validation->set_rules('phone', '전화번호', 'trim');
				$this->form_validation->set_rules('comp_name', '업체명(선택)', 'trim');

				//$this->form_validation->set_rules('upro_postcode', '우편번호', '');
				//$this->form_validation->set_rules('upro_addr', '주소', '');
				//$this->form_validation->set_rules('upro_addr_detail', '상세주소', '');

				// 이메일
				//$this->form_validation->set_rules('user_email', '이메일', 'trim|required|xss_clean|valid_email|duplicate[duplicate_email]');
				//$this->form_validation->set_rules('duplicate_email', '이메일 중복 체크', '');
				//$this->form_validation->set_rules('duplicate_email', '이메일을', '');
				//$this->form_validation->set_rules('upro_newsletter', '이메일 수신 동의', '');

				/*
				if( '' !== $this->input->post('user_email') ) {
					$this->form_validation->set_rules('user_email', '이메일', 'trim|required|xss_clean|valid_email|duplicate[duplicate_email]');
				}
				*/

				// 이메일 인증 사용 여부
				//$email_activation = $this->config->item('email_activation', 'tank_auth');

			if ($this->form_validation->run()) {	// validation ok

				//print_r($this->input->post());
				//exit;


				// 신규회원 등록일 경우에만 아이디 등록
				//$username = (! $user_idx && $use_username) ? $this->form_validation->set_value('username') : '';
				//$email    = ($this->form_validation->set_value('user_email')) ? $this->form_validation->set_value('user_email') : '';
				$password = ( $is_set_pw ) ? $this->form_validation->set_value('password') : '';

				//if (!is_null($data = $this->tank_auth->write_user_by_admin($this->user_idx,$username,$email,$password))) {		// success
				if (!is_null($data = $this->tank_auth->update_user_mypage($this->user_idx,$username,$email,$password))) {		// success
					//$this->_show_message($this->lang->line('auth_message_registration_completed_1'));
					if($this->user_idx) {



						//$this->_show_message('회원 정보가 수정되었습니다.');
						//redirect(current_url());

						//alert('회원 정보가 수정되었습니다.',current_url());

						sess_message('회원 정보가 수정되었습니다.');
						//redirect(current_url());
						redirect(base_url());
					}
					else {

						//$this->_show_message('신규 회원 정보가 등록되었습니다.');
						//redirect(current_url().'/'.$data['user_id']);

						//alert('신규 회원 정보가 등록되었습니다.',current_url().'/'.$data['user_id']);
					}
				} else {
					$errors = $this->tank_auth->get_error_message();
					foreach ($errors as $k => $v)	$data['errors'][$k] = $this->lang->line($v);
				}
			}

		}







		$data = array('user'=>$this->user);

		$use_username = $this->config->item('use_username', 'tank_auth');
		$data['use_username'] = $use_username;


		$data['viewPage'] = 'mypage/edit_view';
		$this->load->view('layout_view', $data);

	}



















	/* 관심제품 */
	function __zzim()
	{


		// # 페이징 정보 - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
			$this->load->library('segment', array('offset'=>3), 'seg'); // 세그먼트 주소( page 위치 )
			$this->load->library('querystring', NULL, 'param'); // 쿼리스트링 주소

			$seg	  =& $this->seg;
			$param	  =& $this->param;

		// 페이징에서 사용
			$qstr = '';


		// # sql - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
			$sql_arr = array(
					'sql_select'     => 'prd.*',
					'sql_from'       => 'prd_zzim as zzim',
					'sql_where'      => array('user_idx'=>$this->user_idx),
					'sql_order_by'   => 'zzim.idx DESC',

					'sql_join_tbl'   => 'products as prd',
					'sql_join_on'   => 'zzim.prd_idx = prd.idx',
					'sql_join_option'   => ''
			);
			$total_count = $this->basic_model->get_common_count($sql_arr['sql_from'],$sql_arr['sql_where']);

			$limit = '20';
			$page  = $seg->get('page', 1); // 페이지
			$page_total = ceil($total_count / $limit);
			if($page_total < 1) {
				$page_total = 1;
			}
			if( $page > $page_total ) {
				$page = ($page < 1) ? 1 : $page_total;
			}
			$offset = ($page - 1) * $limit;
			$sql_arr['offset'] = $offset;
			$sql_arr['limit'] = $limit;
			$result_zzim = $this->basic_model->arr_get_result($sql_arr);
			//print_r($result_zzim);

			foreach($result_zzim['qry'] as $i => $o) {
				// 제품 대표 썸네일
				$sql_arr = array(
						'sql_select'     => '*',
						'sql_from'       => 'file_manager',
						'sql_where'      => array('wr_table'=>'products','wr_table_idx'=>$o->idx,'gubun'=>'thumb'),
						'sql_order_by'   => 'order ASC',
						'limit'   => 1
				);
				$row = $this->basic_model->arr_get_row($sql_arr);
				$src_thumb1 = DATA_DIR.'/'.$row->file_dir.'/'.$row->file_name;
				$result_zzim['qry'][$i]->src_thumb1 = $src_thumb1;
			}

			// pagination 설정
			$config['suffix']	   = $qstr; //$qstr;
			$config['base_url']    = base_url() . 'mypage/zzim/page/';
			$config['per_page']    = $limit;
			$config['total_rows']  = $result_zzim['total_count'];
			$config['uri_segment'] = $seg->pos('page');  // 5

			// 검색 목록 ADD
			$btn_prev_part = $btn_next_part = '';
			$config['full_tag_open']  = "<ul class='pagination pagination-sm justify-content-center'>".$btn_prev_part;
			$config['full_tag_close'] = $btn_next_part.'</ul>';

			$config['first_link'] = '<span aria-hidden="true"><i class="uil uil-left-arrow-to-left"></i></span>';
			$config['prev_link'] = '<span aria-hidden="true"><i class="uil uil-arrow-left"></i></span>';
			$config['next_link'] = '<span aria-hidden="true"><i class="uil uil-arrow-right"></i></span>';
			$config['last_link'] = '<span aria-hidden="true"><i class="uil uil-arrow-to-right"></i></span>';


			//$CI =& get_instance();
			//$CI->load->library('pagination', $config);
			$this->load->library('pagination', $config);



		$data = array(
			'result_zzim' => $result_zzim,
			'paging'    => $this->pagination->create_links(),
		);

		$data['viewPage'] = 'mypage/zzim_view';
		$this->load->view('layout_view', $data);

	}



	/* 견적문의내역 */
	function __estimate()
	{

		$data['viewPage'] = 'mypage/estimate_view';
		$this->load->view('layout_view', $data);

	}





}

/* End of file Mypage.php */
/* Location: ./application/controllers/Mypage.php */
