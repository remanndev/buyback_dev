<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Campaign_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();

		$this->tbl_campaign = 'campaign';
		$this->tbl_campaign_comment = 'campaign_comment';
		$this->tbl_campaign_news = 'campaign_news';

		$this->tbl_donation = 'donation';
		$this->tbl_donation_goods = 'donation_goods';

		$this->tbl_device_amt = 'mng_device_amt';
		$this->tbl_donated_device = 'donated_device';
		$this->tbl_donated_amount = 'donated_amount';
		$this->tbl_donated_archive = 'donated_archive';

		$this->tbl_share_campaign = 'req_sharecampaign';

		$this->tbl_dn_report_check = 'donation_report_check';

		$this->tbl_dn_report_delete_photo = 'donation_report_delete_photo';  // photo
		$this->tbl_dn_report_delete_list = 'donation_report_delete_list';  // list
		$this->tbl_dn_report_delete_cert = 'donation_report_delete_cert';  // cert

	}




	// 캠페인 런칭(공개)
	function _launch($cidx=FALSE)
	{
		if($cidx) {
			$data = array('state'=>'launch');
			$this->db->where(array('idx'=>$cidx));
			if ($this->db->update($this->tbl_campaign, $data)) {
				$data['idx'] = $cidx;
				return $data;
			}
		}
		return FALSE;
	}
	// 캠페인 제출
	function _submit($cidx=FALSE)
	{
		if($cidx) {
			$data = array('state'=>'submit');
			$this->db->where(array('idx'=>$cidx));
			if ($this->db->update($this->tbl_campaign, $data)) {
				$data['idx'] = $cidx;
				return $data;
			}
		}
		return FALSE;
	}
	// 캠페인 제출상태로 리셋
	function _reset_submit($cidx=FALSE)
	{
		if($cidx) {
			$data = array('state'=>'submit');
			$this->db->where(array('idx'=>$cidx));
			if ($this->db->update($this->tbl_campaign, $data)) {
				$data['idx'] = $cidx;
				return $data;
			}
		}
		return FALSE;
	}
	// 캠페인 작성상태로 리셋
	function _reset_write($cidx=FALSE)
	{
		if($cidx) {
			$data = array('state'=>'write');
			$this->db->where(array('idx'=>$cidx));
			if ($this->db->update($this->tbl_campaign, $data)) {
				$data['idx'] = $cidx;
				return $data;
			}
		}
		return FALSE;
	}



	// 캠페인 삭제
	function _del($cidx=FALSE)
	{
		$this->db->where('idx', $cidx);
		$this->db->delete('campaign');
		if ($this->db->affected_rows() > 0) {
			return TRUE;
		}
		return FALSE;
	}


	// 캠페인 신규 및 수정
	function write($cidx=FALSE,$data=NULL)
	{
		// 게시글 수정
		if($cidx && $data) {
			$this->db->where(array('idx'=>$cidx));
			if ($this->db->update($this->tbl_campaign, $data)) {
				$data['idx'] = $cidx;
				//return $data;
			}
		}
		// 새 글 작성
		else {
			if ($this->db->insert($this->tbl_campaign, $data)) {
				$idx = $this->db->insert_id();
				$data['idx'] = $idx;
				//return $data;
			}
		}

		return $data;
		//return NULL;
	}


	// 코멘트 작성/수정/답변
	function cmt_write($mode='write',$cmp_idx=FALSE,$cmt_idx=FALSE,$data=FALSE) {

		// 새 코멘트 작성
		if(('write'===$mode) && $data) {
			if ($this->db->insert($this->tbl_campaign_comment, $data)) {
				$cmt_idx = $this->db->insert_id();
				$this->db->where('idx', $cmt_idx);
				$this->db->update($this->tbl_campaign_comment,array('parent_idx'=>$cmt_idx));
				return $cmt_idx;
			}
			return false;
		}
		// 코멘트 수정
		else if(('update'===$mode) && $cmt_idx && $data) {
			$this->db->where(array('idx'=>$cmt_idx));
			if( $this->db->update($this->tbl_campaign_comment, $data) )
				return $cmt_idx;
			else 
				return false;
		}
		// 답변글 작성
		else if(('reply'===$mode) && $data) {
			if ($this->db->insert($this->tbl_campaign_comment, $data)) {
				$cmt_idx = $this->db->insert_id();
				return $cmt_idx;
			}
		}

		return false;
	}



	// 코멘트 삭제
	function cmt_del($cmt_idx=FALSE) {

		if(! $this->tank_auth->is_logged_in()) {
			return FALSE;
		}

		$this->db->where('idx', $cmt_idx);
		$this->db->delete($this->tbl_campaign_comment);
		if ($this->db->affected_rows() > 0) {
			return TRUE;
		}
		return FALSE;

	}









	// 캠페인 모금소식 작성/수정
	function cmpnews_write($mode='write',$cmp_idx=FALSE,$cmpnews_idx=FALSE,$data=FALSE) {

		// 새 코멘트 작성
		if(('write'===$mode) && $data) {
			if ($this->db->insert($this->tbl_campaign_news, $data)) {
				$cmpnews_idx = $this->db->insert_id();
				$this->db->where('idx', $cmpnews_idx);
				$this->db->update($this->tbl_campaign_news,array('parent_idx'=>$cmpnews_idx));
				return $cmpnews_idx;
			}
			return false;
		}
		// 코멘트 수정
		else if(('update'===$mode) && $cmpnews_idx && $data) {
			$this->db->where(array('idx'=>$cmpnews_idx));
			if( $this->db->update($this->tbl_campaign_news, $data) )
				return $cmpnews_idx;
			else 
				return false;
		}

		return false;
	}



	// 캠페인 모금소식  삭제
	function cmpnews_del($cmpnews_idx=FALSE) {

		if(! $this->tank_auth->is_logged_in()) {
			return FALSE;
		}

		$this->db->where('idx', $cmpnews_idx);
		//$this->db->delete($this->tbl_campaign_news);
		if( $this->db->update($this->tbl_campaign_news,array('del_yn'=>'Y','del_datetime'=>date('Y-m-d H:i:s'))) )
			return $cmpnews_idx;
		else 
			return false;

		/*
		if ($this->db->affected_rows() > 0) {
			return TRUE;
		}
		*/
		return FALSE;

	}








	// 기부 정보
	function write_donation($data=NULL)
	{
		// 기부정보 등록
		if ($this->db->insert($this->tbl_donation, $data)) {
			$idx = $this->db->insert_id();
			$data['idx'] = $idx;
		}
		return $data;
	}
	function write_donation_goods($data_goods=NULL) {
		// 기부 물품 등록
		if ($this->db->insert($this->tbl_donation_goods, $data_goods)) {
			$idx = $this->db->insert_id();
			$data_goods['idx'] = $idx;
		}
		return $data_goods;
	}




	// [2025-08-22] 수거, 검수 날짜 업데이트 FROM ROS
	function dn_update_date($idx=FALSE, $data=FALSE) {

		$this->db->where(array('idx'=>$idx));
		if( $this->db->update($this->tbl_donation, $data) )
			return $idx;
		else 
			return false;
	}

	// [2025-09-03] 택배 물류 추적 상태 업데이트
	function dn_update_tracking($idx=FALSE, $data=FALSE) {

		$this->db->where(array('idx'=>$idx));
		if( $this->db->update($this->tbl_donation, $data) )
			return $idx;
		else 
			return false;
	}


	// 관리자 영역 - 기부물품정보 업데이트
	function trans_dn_update($idx=FALSE, $data=FALSE) {

		$this->db->where(array('idx'=>$idx));
		if( $this->db->update($this->tbl_donation, $data) )
			return $idx;
		else 
			return false;
	}

	// 관리자 영역 - 기부물품정보 업데이트
	function trans_dngood_update($idx=FALSE, $data=FALSE) {

		$this->db->where(array('idx'=>$idx));
		if( $this->db->update($this->tbl_donation_goods, $data) )
			return $idx;
		else 
			return false;
	}

	// 관리자 영역 - 기부물품정보 상세검수현황 삭제
	function trans_dn_reportchk_del($idx=FALSE)
	{
		$this->db->where('idx', $idx);
		$this->db->delete($this->tbl_dn_report_check);
		if ($this->db->affected_rows() > 0) {
			return TRUE;
		}
		return FALSE;
	}

	// 관리자 영역 - 데이터 완전 삭제 리포트 :: 목록 삭제
	function trans_dn_reportList_del($idx=FALSE)
	{
		$this->db->where('idx', $idx);
		$this->db->delete($this->tbl_dn_report_delete_list);
		if ($this->db->affected_rows() > 0) {
			return TRUE;
		}
		return FALSE;
	}







	// 메인 페이지 노출용 기부된 디지털 기기 수량
	function donated_device_update($idx=FALSE,$data=NULL)
	{

		// 정보 수정
		if($idx && $data) {
			$this->db->where(array('idx'=>$idx));
			if ($this->db->update($this->tbl_donated_device, $data)) {
				$data['idx'] = $idx;
			}
			else {
				return NULL;
			}
		}
		else {
			return NULL;
		}

		return $data;
	}





	// 메인 페이지 노출용 기부된 금액
	function donated_amount_update($idx=FALSE,$data=NULL)
	{

		// 정보 수정
		if($idx && $data) {
			$this->db->where(array('idx'=>$idx));
			if ($this->db->update($this->tbl_donated_amount, $data)) {
				$data['idx'] = $idx;
			}
			else {
				return NULL;
			}
		}
		else {
			return NULL;
		}

		return $data;
	}



	// 메인 페이지 노출용 월별 기기 수량 및 금액
	function donated_archive($idx=FALSE,$data=NULL)
	{

		if($idx){
			$this->db->where(array('idx'=>$idx));
			if ($this->db->update($this->tbl_donated_archive, $data)) {
				$data['idx'] = $idx;
			}
			else {
				return NULL;
			}
		}
		else {
			// 나눔캠페인 신청 등록
			if ($this->db->insert($this->tbl_donated_archive, $data)) {
				$idx = $this->db->insert_id();
				$data['idx'] = $idx;
			}
		}

		return $data;
	}





	// 나눔캠페인을 신청한 정보 등록
	function sharecampaign_request($data=NULL)
	{
		// 나눔캠페인 신청 등록
		if ($this->db->insert($this->tbl_share_campaign, $data)) {
			$idx = $this->db->insert_id();
			$data['idx'] = $idx;
		}
		return $data;
	}





	// 캠페인 상세 검수 현황 처리
	function donate_report_check($idxno=NULL,$proc=NULL,$data=NULL)
	{
		if($proc == 'update') {
			$this->db->where(array('idx'=>$idxno));
			if ($this->db->update($this->tbl_dn_report_check, $data)) {
				$data['idx'] = $idxno;
			}
			return $data;
		}
		else if($proc == 'insert') {
			if ($this->db->insert($this->tbl_dn_report_check, $data)) {
				$idx = $this->db->insert_id();
				$data['idx'] = $idx;
			}
			return $data;
		}
		else {
			return 'err';
		}
	}







/*
	// 캠페인 기부내역 삭제, 최고 관리자는 모두 삭제 가능하도록..
	function _donor_del($cmp_code=FALSE,$donate_idx=FALSE,$user_idx=FALSE) {
		// 최고 관리자는 모두 삭제 가능하도록..
		if( $this->ci->tank_auth->is_admin() ) {
			return $this->ci->campaign_model->_donor_del($cmp_code,$donate_idx,$user_idx);
		}
		return FALSE;
	}

*/
	// 기부캠페인 기부내역 삭제
	function _donor_del($cmp_code=FALSE,$donate_idx=FALSE)
	{
		$this->db->where('cmp_code', $cmp_code);
		$this->db->where('idx', $donate_idx);

		/* 완전 삭제
		$this->db->delete('donation');
		*/

		/* 삭제 상태로 업데이트 */
		$this->db->update('donation',array('delete'=>TIME_YMDHIS));

		if ($this->db->affected_rows() > 0) {
			return TRUE;
		}
		return FALSE;
	}


	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	// 캠페인 기부 취소, 최고 관리자는 모두 취소 가능하도록..
	// [취소이지만 삭제처리 업데이트]
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	function _donor_cancel($cmp_code=FALSE,$donate_idx=FALSE)
	{
		$this->db->where('cmp_code', $cmp_code);
		$this->db->where('idx', $donate_idx);

		/* 취소 상태로 업데이트 */
		$this->db->update('donation',array('delete'=>TIME_YMDHIS,'cancel'=>TIME_YMDHIS));

		if ($this->db->affected_rows() > 0) {
			return TRUE;
		}
		return FALSE;
	}



	// [작성자] 기부캠페인 기부내역 삭제
	function _donation_del_writer($cmp_code=FALSE,$donate_idx=FALSE,$user_idx=FALSE)
	{

		$this->db->where('cmp_code', $cmp_code);
		$this->db->where('idx', $donate_idx);
		$this->db->where('user_idx', $user_idx);
		/* 완전 삭제 */
		$this->db->delete('donation');
		
		/* 삭제 상태로 업데이트
		| $this->db->update('donation',array('delete'=>TIME_YMDHIS));
		*/

		if ($this->db->affected_rows() > 0) {
			return TRUE;
		}
		return FALSE;
	}










	// 데이터 완전 삭제 리포트 - [1. 목록] 캠페인 기부 내역 
	function donate_report_delete_save_list($idxno=NULL,$proc=NULL,$data=NULL)
	{
		if($proc == 'update') {
			$this->db->where(array('idx'=>$idxno));
			if ($this->db->update($this->tbl_dn_report_delete_list, $data)) {
				$data['idx'] = $idxno;
			}
			return $data;
		}
		else if($proc == 'insert') {
			if ($this->db->insert($this->tbl_dn_report_delete_list, $data)) {
				$idx = $this->db->insert_id();
				$data['idx'] = $idx;
			}
			return $data;
		}
		else {
			return 'err';
		}
	}



	// 데이터 완전 삭제 리포트 - [2. 사진] 캠페인 기부 내역 
	// [신규] 캠페인 데이터 완전 삭제 리포트 
	function write_dn_del_report_photo($data=NULL)
	{
		if ($this->db->insert($this->tbl_dn_report_delete_photo, $data)) {
			$idx = $this->db->insert_id();
			$data['idx'] = $idx;
		}
		return $data;
	}
	// [수정] 캠페인 데이터 완전 삭제 리포트
	function edit_dn_del_report_photo($idx=NULL,$data=NULL)
	{
		$this->db->where(array('idx'=>$idx));
		if ($this->db->update($this->tbl_dn_report_delete_photo, $data)) {
			$data['idx'] = $idx;
		}
		return $data;
	}


	function write_dn_del_report_cert($data=NULL)
	{
		if ($this->db->insert($this->tbl_dn_report_delete_cert, $data)) {
			$idx = $this->db->insert_id();
			$data['idx'] = $idx;
		}
		return $data;
	}

	function edit_dn_del_report_cert($idx=NULL,$data=NULL)
	{
		$this->db->where(array('idx'=>$idx));
		if ($this->db->update($this->tbl_dn_report_delete_cert, $data)) {
			$data['idx'] = $idx;
		}
		return $data;
	}

}