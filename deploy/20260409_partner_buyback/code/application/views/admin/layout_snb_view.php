<?php

$seg1 = isset($arr_seg[1]) ? $arr_seg[1] : '';
$seg2 = isset($arr_seg[2]) ? $arr_seg[2] : '';
$seg3 = isset($arr_seg[3]) ? $arr_seg[3] : '';
$seg4 = isset($arr_seg[4]) ? $arr_seg[4] : '';
$seg5 = isset($arr_seg[5]) ? $arr_seg[5] : '';



// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
// [2023-09-22] 새로운 기부신청 개수 확인해서 가져오기
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
// 캠페인 기부 신청 목록 가져오기
/*
$arr_where = array(
		'sql_from'       => 'donation',
		'sql_where'      => array('delete'=>NULL, 'mng_chk'=>NULL)
);
$dn_new_cnt = $this->basic_model->get_total($arr_where);
echo $dn_new_cnt;
*/
?>

<?php if(! isset($arr_seg[2]) ) { ?>

<?php } else if('user' == $arr_seg[2]  OR  'npo' == $arr_seg[2]) { ?>

			<!-- <div class="snb_header ico_config" style="height: 100px;text-align: center;">
				<h2 style="padding:15px 0 0 0;font-size: 20px;font-weight: 600;letter-spacing: -1px; text-align:center; color:#454545;">
					<img src="/assets/images/icons/gnb-member.png" style="height:40px; margin:0 auto; display:block;" />
					회원관리
				</h2>
			</div> -->
			<div class="snb_header">
				<h2>회원관리</h2>
			</div>


			<dl>
				<dt class="m10 menu_toggle">회원관리</dt>
				<dd class="m10 list-minus <?php echo (in_array($seg2, array('user')) && in_array($seg3, array('write'))) ? 'active' : ''; ?>"><a href="<?php echo base_url() ?>admin/user/write">회원 등록/수정</a></dd>
				<dd class="m10 list-minus <?php echo (in_array($seg2, array('user')) && in_array($seg3, array('lists'))) ? 'active' : ''; ?>"><a href="<?php echo base_url() ?>admin/user/lists">일반회원 목록</a></dd>
				<dd class="m10 list-minus <?php echo (in_array($seg2, array('user')) && in_array($seg3, array('grplists'))) ? 'active' : ''; ?>"><a href="<?php echo base_url() ?>admin/user/grplists">NPO회원 목록</a></dd>

				<dt class="m20 menu_toggle">관리자관리</dt>
				<dd class="m20 list-minus <?php echo (in_array($seg3, array('admlists'))) ? 'active' : ''; ?>"><a href="<?php echo base_url() ?>admin/user/admlists">관리자 목록</a></dd>
				<dd class="m20 list-minus <?php echo (in_array($seg3, array('admwrite'))) ? 'active' : ''; ?>"><a href="<?php echo base_url() ?>admin/user/admwrite">관리자 등록/수정</a></dd>

				<dt class="mt-4 m30 menu_toggle">비영리단체관리</dt>
				<dd class="m30 list-minus <?php echo (in_array($seg2, array('npo')) && in_array($seg3, array('lists'))) ? 'active' : ''; ?>"><a href="<?php echo base_url() ?>admin/npo/lists">단체 목록</a></dd>
				<!-- <dd class="m30 list-minus <?php echo (in_array($seg2, array('npo')) && in_array($seg3, array('write'))) ? 'active' : ''; ?>"><a href="<?php echo base_url() ?>admin/npo/write">등록/수정</a></dd> -->


				<!-- <dd class="m10 <?php echo (in_array($seg3, array('sleeps'))) ? 'active' : ''; ?>"><a href="<?php echo base_url() ?>admin/user/sleeps">휴면회원 관리</a></dd> -->

				<!-- <dd class="m10"><a href="http://bluevation.store/admin/member.php?code=level_form">회원 레벨관리</a></dd>
				<dd class="m10"><a href="http://bluevation.store/admin/member.php?code=register_form">회원 등록하기</a></dd>
				<dd class="m10"><a href="http://bluevation.store/admin/member.php?code=xls">회원 엑셀일괄등록</a></dd>
				<dd class="m10"><a href="http://bluevation.store/admin/member.php?code=mail_list">회원 일괄메일발송</a></dd>

				<dt class="m20 menu_toggle">포인트관리</dt>
				<dd class="m20"><a href="http://bluevation.store/admin/member.php?code=point">포인트 관리</a></dd>
				<dd class="m20"><a href="http://bluevation.store/admin/member.php?code=pointxls">포인트 엑셀일괄등록</a></dd>
				<dd class="m20"><a href="http://bluevation.store/admin/member.php?code=point_select_form">포인트 일괄지급&amp;차감</a></dd>

				<dt class="m30 menu_toggle">가입통계</dt>
				<dd class="m30"><a href="http://bluevation.store/admin/member.php?code=month">월별 가입통계분석</a></dd>
				<dd class="m30"><a href="http://bluevation.store/admin/member.php?code=day">일별 가입통계분석</a></dd>
				-->
			</dl>


<?php } else if('buyback' == $arr_seg[2]) { ?>

			<div class="snb_header">
				<h2>매입관리</h2>
			</div>


			<dl>
				<dt class="m10 menu_toggle">매입관리</dt>
				<dd class="m10 list-minus <?php echo (in_array($seg2, array('buyback')) && in_array($seg3, array('list'))) ? 'active' : ''; ?>"><a href="<?php echo base_url() ?>admin/buyback/list">수거 신청 목록</a></dd>
				<dd class="m10 list-minus <?php echo (in_array($seg2, array('buyback')) && in_array($seg3, array('spec_lists'))) ? 'active' : ''; ?>"><a href="<?php echo base_url() ?>admin/buyback/spec_lists">매입 기준 목록</a></dd>
				<dd class="m10 list-minus <?php echo (in_array($seg2, array('buyback')) && in_array($seg3, array('spec_write'))) ? 'active' : ''; ?>"><a href="<?php echo base_url() ?>admin/buyback/spec_write">매입 기준 등록/수정</a></dd>
				<dd class="m10 list-minus <?php echo (in_array($seg2, array('buyback')) && in_array($seg3, array('spec_excel'))) ? 'active' : ''; ?>"><a href="<?php echo base_url() ?>admin/buyback/spec_excel">엑셀 업로드</a></dd>
			</dl>


<?php } else if('campaign' == $arr_seg[2]) { ?>

			<div class="snb_header">
				<h2>캠페인관리</h2>
			</div>

			<?php 
				// [2023-05-11] 런칭 캠페인 중 진행중인 것과 종료된 것 구분
				$term = isset($this->param) ? $this->param->get('term',FALSE) : '';
			?>
			<dl>
				<dt class="m10 menu_toggle">캠페인 관리</dt>
				<dd class="m10 list-plus <?php echo (in_array($seg3, array('lists','detail'))) ? 'active' : ''; ?>"><a href="<?php echo base_url() ?>admin/campaign/lists/">캠페인 목록</a></dd>
				<dd class="m10">
					<ul class="subnav3depth">
						<li class="subnav3list <?php echo (in_array($seg4, array('write')) OR in_array($seg5, array('write'))) ? 'active' : ''; ?>">
							<a href="/admin/campaign/lists/write">작성중</a>
						</li>
						<li class="subnav3list <?php echo (in_array($seg4, array('submit')) OR in_array($seg5, array('submit'))) ? 'active' : ''; ?>">
							<a href="/admin/campaign/lists/submit">제출</a>
						</li>
						<li class="subnav3list <?php echo ($term == 'ing' && (in_array($seg4, array('launch')) OR in_array($seg5, array('launch')))) ? 'active' : ''; ?>">
							<a href="/admin/campaign/lists/launch?term=ing">개설</a><?php /* 런칭 */ ?>
						</li>
						<li class="subnav3list <?php echo ($term == 'end' && (in_array($seg4, array('launch')) OR in_array($seg5, array('launch')))) ? 'active' : ''; ?>">
							<a href="/admin/campaign/lists/launch?term=end">종료</a>
						</li>
					</ul>
				</dd>





				<dt class="m20 menu_toggle">기부 관리 <span class="badge bg-dark">NEW</span></dt>
				<dd class="m20 list-minus <?php echo ( in_array($seg3, array('donation'))  &&  in_array($seg4, array('cmp_list','dn_list','donor')) ) ? 'active' : ''; ?>"><a href="<?php echo base_url('admin/campaign/donation/cmp_list') ?>">캠페인별 기부관리</a></dd>




				<?php /*
				<dt class="m20 menu_toggle">기부 목록</dt>
				<dd class="m20 list-minus <?php echo ( in_array($seg3, array('donate'))  &&  in_array($seg4, array('lists')) ) ? 'active' : ''; ?>"><a href="<?php echo base_url() ?>admin/campaign/donate/lists">캠페인별 기부목록</a></dd>
				<dd class="m20 list-minus <?php echo ( in_array($seg3, array('donate')) &&  in_array($seg4, array('donor_list')) ) ? 'active' : ''; ?>"><a href="<?php echo base_url() ?>admin/campaign/donate/donor_list">캠페인별 기부자 목록</a></dd>
				*/ ?>




				<dt class="m30 menu_toggle">나눔신청 관리</dt>
				<!-- <dd class="m30 list-minus <?php echo (in_array($seg3, array('share'))) ? 'active' : ''; ?>"><a href="<?php echo base_url() ?>admin/campaign/share" onclick="alert('준비중입니다.'); return false;">나눔 신청</a></dd> -->
				<dd class="m30 list-minus"><a href="<?php echo base_url() ?>admin/board/bbs/sharecampaign">나눔 캠페인</a></dd>

				<!-- <dt class="m40 menu_toggle">함께하는 기관</dt>
				<dd class="m40 list-minus <?php echo (in_array($seg3, array('together'))) ? 'active' : ''; ?>"><a href="<?php echo base_url() ?>admin/campaign/together" onclick="alert('준비중입니다.'); return false;">함께하는 기관</a></dd>

				<dt class="m50 menu_toggle">기부절차안내</dt>
				<dd class="m50 list-minus <?php echo (in_array($seg3, array('guide'))) ? 'active' : ''; ?>"><a href="<?php echo base_url() ?>admin/campaign/guide" onclick="alert('준비중입니다.'); return false;">기부절차안내</a></dd> -->

				<dt class="m70 menu_toggle">메인페이지 기부 관리</dt>
				<dd class="m70 list-minus <?php echo (in_array($seg3, array('donated_device'))) ? 'active' : ''; ?>"><a href="<?php echo base_url() ?>admin/campaign/donated_device">수량 관리</a></dd>
				<dd class="m70 list-minus <?php echo (in_array($seg3, array('donated_amount'))) ? 'active' : ''; ?>"><a href="<?php echo base_url() ?>admin/campaign/donated_amount">가치 관리</a></dd>

				<dd class="m70 list-minus <?php echo (in_array($seg3, array('donated_archive'))) ? 'active' : ''; ?>"><a href="<?php echo base_url() ?>admin/campaign/donated_archive">월별 가치 관리</a></dd>

			</dl>




<?php } else if('board' == $arr_seg[2]) {

			$arr_bbs = array();
			if( isset($boards_result['qry']) ) {
				foreach($boards_result['qry'] as $i => $row) {

					//print_r($row);
					$arr_bbs[$i] = new stdClass();
					$arr_bbs[$i]->gr_code = $row->gr_code;
					$arr_bbs[$i]->gr_title = $row->gr_title;
					$arr_bbs[$i]->bo_code = $row->bo_code;
					$arr_bbs[$i]->bo_title = $row->bo_title;
					$arr_bbs[$i]->bo_use_category = $row->bo_use_category;
					$arr_bbs[$i]->bo_category = $row->bo_category;
				}
			}
?>

			<div class="snb_header">
				<h2>게시판관리</h2>
			</div>

			<dl>
				<?php //if('sadmin' === $this->username){ ?>
				<?php if(isset($this->username) && 'sadmin' === $this->username){ ?>
				<dt class="m10 menu_toggle">게시판 관리</dt>
				<dd class="m10 list-minus <?php echo ('group' == $seg3) ? 'active' : ''; ?>"><a href="<?php echo base_url() ?>admin/board/group">그룹 관리</a></dd>
				<dd class="m10 list-minus <?php echo (in_array($seg3, array('lists','edit'))) ? 'active' : ''; ?>"><a href="<?php echo base_url() ?>admin/board/lists">게시판 관리</a></dd>
				<?php } ?>
				<?php //} ?>

				<dt class="m20 menu_toggle">게시물 관리</dt>
				<dd class="m20">
					<ul class="subnav3depth">
					<?php
					$gr_code = false;
					foreach($arr_bbs as $i => $o) {
						if(! $gr_code || $gr_code !== $o->gr_code) {
							echo '<li class="subnav3ttl">['. $o->gr_title .']</li>';
						}
						$gr_code = $o->gr_code;
					?>
						<li class="subnav3list">
							<a href="/admin/board/bbs/<?php echo $o->bo_code ?>"><?php echo $o->bo_title ?></a>
						</li>
					<?php
					}
					?>
					</ul>
				</dd>
			</dl>

<?php } else if('design' == $arr_seg[2]) { ?>

			<!-- <div class="snb_header ico_config" style="height: 100px;text-align: center;">
				<h2 style="padding:15px 0 0 0;font-size: 20px;font-weight: 600;letter-spacing: -1px; text-align:center; color:#454545;">
					<img src="/assets/images/icons/gnb-design.png" style="height:40px; margin:0 auto; display:block;" />
					디자인관리
				</h2>
			</div> -->
			<div class="snb_header">
				<h2>디자인관리</h2>
			</div>

			<dl>


				<dt class="m20 menu_toggle">팝업 관리</dt>
				<dd class="m20 list-minus <?php echo (in_array($seg3, array('popup')) && in_array($seg4, array('form'))) ? 'active' : ''; ?>"><a href="<?php echo base_url() ?>admin/design/popup/form">팝업 등록/수정</a></dd>
				<dd class="m20 list-minus <?php echo (in_array($seg3, array('popup')) && in_array($seg4, array('lists'))) ? 'active' : ''; ?>"><a href="<?php echo base_url() ?>admin/design/popup/lists">팝업 목록</a></dd>


				<dt class="m30 menu_toggle">배너 관리</dt>
				<dd class="m30 list-minus <?php echo (in_array($seg3, array('banner')) && in_array($seg4, array('form'))) ? 'active' : ''; ?>"><a href="<?php echo base_url() ?>admin/design/banner/form">배너 등록/수정</a></dd>
				<dd class="m30 list-plus <?php echo (in_array($seg3, array('banner')) && in_array($seg4, array('lists'))) ? 'active' : ''; ?>"><a href="<?php echo base_url() ?>admin/design/banner/lists">[전체] 배너 관리</a></dd>
				<dd class="m30">
					<ul class="subnav3depth">
					  <?php foreach($this->bnr_side_list as $bno => $bnr) { ?>
						<li class="subnav3list <?php echo (isset($bncode) && $bncode == $bnr->bn_code) ? 'active' : '' ?>">
							<a href="<?php echo $bnr->bn_nav_link ?>"><?php echo $bnr->bn_nav_title ?></a>
						</li>
					  <?php } ?>
					</ul>
				</dd>
			</dl>


<?php } else if('contents' == $arr_seg[2]) { ?>
			<?php
				$arr_ctnts = array();
				if( isset($this->contents_result['qry']) ) {
					foreach($this->contents_result['qry'] as $i => $row) {
						//print_r($row);

						if($row->use_yn != 'Y') {continue;}
						$arr_ctnts[$i] = new stdClass();
						$arr_ctnts[$i]->idx = $row->idx;
						$arr_ctnts[$i]->cate = $row->cate;
						$arr_ctnts[$i]->page_title = $row->page_title;
						$arr_ctnts[$i]->use_yn = $row->use_yn;
					}
				}

				$arr_landing = array();
				if( isset($this->landing_result['qry']) ) {
					foreach($this->landing_result['qry'] as $i => $row) {
						//print_r($row);

						if($row->use_yn != 'Y') {continue;}
						$arr_landing[$i] = new stdClass();
						$arr_landing[$i]->idx = $row->idx;
						$arr_landing[$i]->code = $row->code;
						$arr_landing[$i]->title = $row->title;
						$arr_landing[$i]->use_yn = $row->use_yn;
						$arr_landing[$i]->content_top = $row->content_top;
						$arr_landing[$i]->content_bottom = $row->content_bottom;
						$arr_landing[$i]->sdate = $row->sdate;
						$arr_landing[$i]->edate = $row->edate;
						$arr_landing[$i]->url = $row->url;
						$arr_landing[$i]->fld_nm_1 = $row->fld_nm_1;
						$arr_landing[$i]->fld_nm_2 = $row->fld_nm_2;
						$arr_landing[$i]->fld_nm_3 = $row->fld_nm_3;
						$arr_landing[$i]->fld_nm_4 = $row->fld_nm_4;
						$arr_landing[$i]->fld_nm_5 = $row->fld_nm_5;
						$arr_landing[$i]->fld_nm_6 = $row->fld_nm_6;
						$arr_landing[$i]->fld_nm_7 = $row->fld_nm_7;
						$arr_landing[$i]->fld_nm_8 = $row->fld_nm_8;
						$arr_landing[$i]->fld_nm_9 = $row->fld_nm_9;
						$arr_landing[$i]->fld_nm_10 = $row->fld_nm_10;

						$arr_landing[$i]->reg_username = $row->reg_username;
						$arr_landing[$i]->reg_datetime = $row->reg_datetime;

					}
				}
			?>

			<div class="snb_header">
				<h2>컨텐츠관리</h2>
			</div>

			<dl>

				<dt class="m10 menu_toggle">CMS 관리</dt>
				<dd class="m10 list-minus <?php echo (in_array($seg3, array('cms'))) ? 'active' : ''; ?>"><a href="<?php echo base_url() ?>admin/contents/cms">CMS 관리</a></dd>


				<dt class="m30 menu_toggle">컨텐츠 관리</dt>
				<dd class="m30 list-minus <?php echo ('page' == $seg3 && in_array($seg4, array('form')) && ! $seg5) ? 'active' : ''; ?>"><a href="<?php echo base_url() ?>admin/contents/page/form">컨텐츠 페이지 등록</a></dd>

				<dd class="m30 list-plus <?php echo ('page' == $seg3 && in_array($seg4, array('lists'))) ? 'active' : ''; ?>"><a href="<?php echo base_url() ?>admin/contents/page/lists">컨텐츠 페이지 목록</a></dd>
				<dd class="m30">
					<ul class="subnav3depth">
						<?php foreach($arr_ctnts as $i => $o) { ?>
						<li class="subnav3list <?php echo (isset($seg5) && $seg5 == $o->idx) ? 'active' : '' ?>">
							<a href="/admin/contents/page/form/<?php echo $o->idx?>"  <?php echo ($o->use_yn != 'Y') ? 'style="text-decoration:line-through" title="사용안함"' : '' ?>><?php echo $o->page_title ?></a>
						</li>
						<?php } ?>
					</ul>
				</dd>

				<!-- <dt class="m50 menu_toggle">필수 컨텐츠</dt>
				<dd class="m50 list-minus <?php //echo (in_array($seg5, array('history'))) ? 'active' : ''; ?>"><a href="<?php echo base_url() ?>admin/contents/sub/history">연혁</a></dd>
				<dd class="m50 list-minus <?php //echo (in_array($seg5, array('privacy'))) ? 'active' : ''; ?>"><a href="<?php echo base_url() ?>admin/contents/sub/privacy">개인정보 처리방침</a></dd>
				<dd class="m50 list-minus <?php //echo (in_array($seg5, array('terms'))) ? 'active' : ''; ?>"><a href="<?php echo base_url() ?>admin/contents/sub/terms">이용약관</a></dd> -->

				<br />
				<dt class="m30 menu_toggle">랜딩 페이지 관리</dt>
				<dd class="m30 list-minus <?php echo ('landing' == $seg3 && in_array($seg4, array('form')) && ! $seg5) ? 'active' : ''; ?>"><a href="<?php echo base_url() ?>admin/contents/landing/form">랜딩 페이지 등록</a></dd>

				<dd class="m30 list-minus <?php echo ('landing' == $seg3 && in_array($seg4, array('lists'))) ? 'active' : ''; ?>"><a href="<?php echo base_url() ?>admin/contents/landing/lists">랜딩 페이지 목록</a></dd>
				<dd class="m30 list-plus <?php echo ('landing' == $seg3 && in_array($seg4, array('req_list'))) ? 'active' : ''; ?>"><a href="<?php echo base_url() ?>admin/contents/landing/req_list">신청/문의 목록</a></dd>
				<dd class="m30">
					<ul class="subnav3depth">
						<?php foreach($arr_landing as $i => $o) { ?>
						<li class="subnav3list <?php echo (isset($seg5) && $seg4 == 'req_code' && $seg5 == $o->code) ? 'active' : '' ?>">
							<a href="/admin/contents/landing/req_code/<?php echo $o->code?>"  <?php echo ($o->use_yn != 'Y') ? 'style="text-decoration:line-through" title="사용안함"' : '' ?>><?php echo $o->title ?></a>
						</li>
						<?php } ?>
					</ul>
				</dd>

			</dl>



<?php } else if('product' == $arr_seg[2]) { ?>

			<!-- <div class="snb_header ico_config" style="height: 100px;text-align: center;">
				<h2 style="padding:15px 0 0 0;font-size: 20px;font-weight: 600;letter-spacing: -1px; text-align:center; color:#454545;">
					<img src="/assets/images/icons/gnb-product.png" style="height:40px; margin:0 auto; display:block;" />
					제품 관리
				</h2>
			</div> -->
			<div class="snb_header">
				<h2>제품 관리</h2>
			</div>

			<dl>
				<dt class="m20 menu_toggle">카테고리 관리</dt>
				<dd class="m20 list-minus <?php echo (in_array($seg3, array('category'))) ? 'active' : ''; ?>"><a href="<?php echo base_url() ?>admin/product/category">카테고리 관리</a></dd>
				<!-- <dd class="m20 list-minus <?php echo (in_array($seg3, array('category_order'))) ? 'active' : ''; ?>"><a href="<?php echo base_url() ?>admin/product/category_order">카테고리 정렬</a></dd> -->

				<dt class="m10 menu_toggle">제품 관리</dt>
				<dd class="m10 list-minus <?php echo (in_array($seg3, array('form'))) ? 'active' : ''; ?>"><a href="<?php echo base_url() ?>admin/product/form">제품 등록</a></dd>
				<dd class="m10 list-minus <?php echo (in_array($seg3, array('lists'))) ? 'active' : ''; ?>"><a href="<?php echo base_url() ?>admin/product/lists">제품 목록</a></dd>


			</dl>


<?php } else if('item' == $arr_seg[2]) { ?>

			<!-- <div class="snb_header ico_config" style="height: 100px;text-align: center;">
				<h2 style="padding:15px 0 0 0;font-size: 20px;font-weight: 600;letter-spacing: -1px; text-align:center; color:#454545;">
					<img src="/assets/images/icons/gnb-product.png" style="height:40px; margin:0 auto; display:block;" />
					제품 관리
				</h2>
			</div> -->
			<div class="snb_header">
				<h2>제품 관리</h2>
			</div>

			<dl>
				<dt class="m20 menu_toggle">카테고리 관리</dt>
				<dd class="m20 list-minus <?php echo (in_array($seg3, array('category'))) ? 'active' : ''; ?>"><a href="<?php echo base_url() ?>admin/item/category">카테고리 관리</a></dd>
				<!-- <dd class="m20 list-minus <?php echo (in_array($seg3, array('category_order'))) ? 'active' : ''; ?>"><a href="<?php echo base_url() ?>admin/item/category_order">카테고리 정렬</a></dd> -->

				<dt class="m10 menu_toggle">제품 관리</dt>
				<dd class="m10 list-minus <?php echo (in_array($seg3, array('form'))) ? 'active' : ''; ?>"><a href="<?php echo base_url() ?>admin/item/form">제품 등록/수정</a></dd>
				<dd class="m10 list-minus <?php echo (in_array($seg3, array('lists'))) ? 'active' : ''; ?>"><a href="<?php echo base_url() ?>admin/item/lists">제품 목록</a></dd>


			</dl>



<?php } else if('inven' == $arr_seg[2]) { ?>

			<!-- <div class="snb_header ico_config" style="height: 100px;text-align: center;">
				<h2 style="padding:15px 0 0 0;font-size: 20px;font-weight: 600;letter-spacing: -1px; text-align:center; color:#454545;">
					<img src="/assets/images/icons/gnb-product.png" style="height:40px; margin:0 auto; display:block;" />
					제품 관리
				</h2>
			</div> -->
			<div class="snb_header">
				<h2>재고 관리</h2>
			</div>

			<dl>
				<dt class="m10 menu_toggle">재고 관리</dt>
				<dd class="m10 list-minus <?php echo (in_array($seg3, array('lists'))) ? 'active' : ''; ?>"><a href="<?php echo base_url() ?>admin/inven/lists">재고 목록</a></dd>
				<dd class="m10 list-minus <?php echo (in_array($seg3, array('write'))) ? 'active' : ''; ?>"><a href="<?php echo base_url() ?>admin/inven/write">재고 등록/수정</a></dd>
			</dl>


<?php } else if('orders' == $arr_seg[2]) { ?>

			<div class="snb_header">
				<h2>주문 관리</h2>
			</div>

			<dl>
				<dt class="m10 menu_toggle">구매의뢰 관리</dt>
				<dd class="m10 list-minus <?php echo (in_array($seg3, array('request_lists'))) ? 'active' : ''; ?>"><a href="<?php echo base_url() ?>admin/orders/request_lists">구매의뢰 목록</a></dd>
				<dd class="m10 list-minus <?php echo (in_array($seg3, array('request_form'))) ? 'active' : ''; ?>"><a href="<?php echo base_url() ?>admin/orders/request_form">구매의뢰 등록</a></dd>

				<dt class="m20 menu_toggle">발주 관리</dt>
				<dd class="m20 list-minus <?php echo (in_array($seg3, array('lists'))) ? 'active' : ''; ?>"><a href="<?php echo base_url() ?>admin/orders/lists">발주 목록</a></dd>
				<dd class="m20 list-minus <?php echo (in_array($seg3, array('form'))) ? 'active' : ''; ?>"><a href="<?php echo base_url() ?>admin/orders/form">신규 발주</a></dd>

			</dl>




<?php } else if('env' == $arr_seg[2]) { ?>

			<!-- <div class="snb_header ico_config" style="height: 100px;text-align: center;">
				<h2 style="padding:15px 0 0 0;font-size: 20px;font-weight: 600;letter-spacing: -1px; text-align:center; color:#454545;">
					<img src="/assets/images/icons/gnb-env.png" style="height:40px; margin:0 auto; display:block;" />
					방문자 관리
				</h2>
			</div> -->
			<div class="snb_header">
				<h2>방문자 관리</h2>
			</div>


			<dl>
				<dt class="m10 menu_toggle">방문자 확인</dt>
				<dd class="m10 list-minus <?php echo (in_array($seg3, array('visit'))) ? 'active' : ''; ?>"><a href="<?php echo base_url('admin/env/visit') ?>">visit</a></dd>
				<dd class="m10 list-minus <?php echo (in_array($seg3, array('visit_bot'))) ? 'active' : ''; ?>"><a href="<?php echo base_url('admin/env/visit_bot') ?>">visit_bot</a></dd>
				<dd class="m10 list-minus <?php echo (in_array($seg3, array('stats'))) ? 'active' : ''; ?>"><a href="<?php echo base_url('admin/env/stats') ?>">통계</a></dd>
				<dd class="m10 list-minus <?php echo (in_array($seg3, array('stats_week'))) ? 'active' : ''; ?>"><a href="<?php echo base_url('admin/env/stats_week') ?>">통계(주간)</a></dd>
				<dd class="m10 list-minus <?php echo (in_array($seg3, array('stats_sns'))) ? 'active' : ''; ?>"><a href="<?php echo base_url('admin/env/stats_sns') ?>">검색 통계</a></dd>
			</dl>



			<!-- <dl>
				<dt class="m20 menu_toggle">QR 방문자 확인</dt>
				<dd class="m20 list-minus <?php echo (in_array($seg3, array('qr_visit'))) ? 'active' : ''; ?>"><a href="<?php echo base_url('admin/env/qr_visit') ?>">QR visit</a></dd>
				<dd class="m20 list-minus <?php echo (in_array($seg3, array('qr_stats'))) ? 'active' : ''; ?>"><a href="<?php echo base_url() ?>admin/env/qr_stats">QR 통계(일간)</a></dd>
				<dd class="m20 list-minus <?php echo (in_array($seg3, array('qr_stats_week'))) ? 'active' : ''; ?>"><a href="<?php echo base_url() ?>admin/env/qr_stats_week">QR 통계(주간)</a></dd>
			</dl> -->




			<?php /*
			<dl>
				<dt class="m10 menu_toggle">기본환경설정</dt>
				<dd class="m10 list-minus <?php echo (in_array($seg3, array('config'))) ? 'active' : ''; ?>"><a href="<?php echo base_url() ?>admin/env/config">기본환경설정</a></dd>
				<dd class="m10 list-minus <?php echo (in_array($seg3, array('search'))) ? 'active' : ''; ?>"><a href="<?php echo base_url() ?>admin/env/search">검색 최적화 설정</a></dd>
				<dd class="m10 list-minus <?php echo (in_array($seg3, array('sns'))) ? 'active' : ''; ?>"><a href="<?php echo base_url() ?>admin/env/sns">소셜 정보 설정</a></dd>
				<dd class="m10 list-minus <?php echo (in_array($seg3, array('info'))) ? 'active' : ''; ?>"><a href="<?php echo base_url() ?>admin/env/info">info</a></dd>
				<dd class="m10 list-minus <?php echo (in_array($seg3, array('phpinfo'))) ? 'active' : ''; ?>"><a href="<?php echo base_url() ?>admin/env/phpinfo">phpinfo</a></dd>

				<!-- <dt class="m30 menu_toggle">가입통계</dt>
				<dd class="m30"><a href="http://bluevation.store/admin/member.php?code=month">월별 가입통계분석</a></dd>
				<dd class="m30"><a href="http://bluevation.store/admin/member.php?code=day">일별 가입통계분석</a></dd> -->
			</dl>
			*/ ?>



<?php } else if('calendar' == $arr_seg[2]) { ?>

			<div class="snb_header">
				<h2>프로그램 일정</h2>
			</div>

			<dl>
				<dt class="m10 menu_toggle">프로그램 일정</dt>
				<dd class="m10 list-minus <?php echo (in_array($seg3, array('lists','form'))) ? 'active' : ''; ?>"><a href="<?php echo base_url() ?>admin/calendar/lists">일정 관리</a></dd>
			</dl>




<?php } else if('landing' == $arr_seg[2]) { ?>

			<div class="snb_header">
				<h2>신청문의관리</h2>
			</div>

			<?php if('rsv_1' == $arr_seg[4] OR '1' == $arr_seg[4]) { ?>
			<?php } elseif('rsv_2' == $arr_seg[4] OR '2' == $arr_seg[4]) { ?>
			<?php } ?>

			<dl>
				<dt class="m10 menu_toggle">NPO 협약 신청</dt>
				<dd class="m10 list-minus <?php echo (in_array($seg3, array('request')) && $seg4 == 'npo') ? 'active' : ''; ?>"><a href="<?php echo base_url() ?>admin/landing/request/npo">신청 목록</a></dd>
				<dd class="m10 list-minus <?php echo (in_array($seg3, array('agree')) && $seg4 == 1) ? 'active' : ''; ?>"><a href="<?php echo base_url() ?>admin/landing/agree/1">개인정보수집동의</a></dd>

				<dt class="m10 menu_toggle">기업 제휴 문의</dt>
				<dd class="m10 list-minus <?php echo (in_array($seg3, array('request')) && $seg4 == 'comp') ? 'active' : ''; ?>"><a href="<?php echo base_url() ?>admin/landing/request/comp">문의 목록</a></dd>
				<dd class="m10 list-minus <?php echo (in_array($seg3, array('agree')) && $seg4 == 2) ? 'active' : ''; ?>"><a href="<?php echo base_url() ?>admin/landing/agree/2">개인정보수집동의</a></dd>
			</dl>





<?php } else if('recycle' == $arr_seg[2]) { ?>

			<div class="snb_header">
				<h2>수거요청관리</h2>
			</div>

			<dl>
				<dt class="m10 menu_toggle">장소 코드 관리</dt>
				<dd class="m10 list-minus <?php echo (in_array($seg3, array('place'))) ? 'active' : ''; ?>"><a href="<?php echo base_url() ?>admin/recycle/place">장소 코드 관리</a></dd>
				<dd class="m10 list-minus <?php echo (in_array($seg3, array('del_list'))) ? 'active' : ''; ?>"><a href="<?php echo base_url() ?>admin/recycle/del_list">삭제 코드 목록</a></dd>

				<dt class="m10 menu_toggle">수거 요청 관리</dt>
				<dd class="m10 list-minus <?php echo (in_array($seg3, array('request'))) ? 'active' : ''; ?>"><a href="<?php echo base_url() ?>admin/recycle/request">수거 요청 관리</a></dd>
			</dl>

<?php }  ?>
