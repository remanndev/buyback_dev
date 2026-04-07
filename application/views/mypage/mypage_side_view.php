<?php
/*
	echo $this->username.'<<<<br />';
	echo $this->user->sns.'<<<<br />';
	echo $this->user->nickname.'<<<<br />';
*/
	$user_id = (isset($this->user->sns) && $this->user->sns != '') ? '[ '.$this->user->sns.' <span style="font-size:14px;">가입회원</span> ]' : substr($this->username,0,3).'＊＊＊';
?>

			<div class="mypage_side d-none d-md-block" style="width:91%; ">

				<div class="my_profile_wrap">
					<!-- <img src="<?php echo IMG_DIR ?>/sample/basic_profile.jpg" width="72" height="72" alt="유저 프로필 사진" class="my_profile_img img_circle" id="profileImageArea"> -->
					<?php if($this->user->level == 20) { ?>
					  <span class="badge bg-success">NPO 회원</span>
					<?php } else if($this->user->level == 10) { ?>
					  <span class="badge bg-success">일반 회원</span>
					<?php } ?>

					<div class="my_profile_nickname"><span class="ellipsis" id="nickNameArea"><?php echo $this->user->nickname; ?></span>님</div>
					<div class="my_profile_id mt_10" id="maskingIdArea">
						<!-- <?php //echo substr($this->username,0,4) ?><span style="font-size:11px;">＊＊＊</span> -->
						<?php echo $user_id ?>
					</div>
				</div>
				<?php
					// 서브메뉴 active 설정
					$arr_active = array(
						'snav1'=> ((isset($this->arr_seg[2]) && 'donation' == $this->arr_seg[2]) ? 'true' : 'false'),
						'snav2'=> (((isset($this->arr_seg[2]) && 'user' == $this->arr_seg[2]) && (isset($this->arr_seg[3]) && 'edit' == $this->arr_seg[3])) ? 'true' : 'false'),
						'snav3'=> (((isset($this->arr_seg[2]) && 'campaign' == $this->arr_seg[2]) && (isset($this->arr_seg[3]) && 'lists' == $this->arr_seg[3])) ? 'true' : 'false'),
						'snav4'=> (((isset($this->arr_seg[2]) && 'campaign' == $this->arr_seg[2]) && (isset($this->arr_seg[3]) && 'write' == $this->arr_seg[3])) ? 'true' : 'false')
					);
				?>
				<div id="lnb" class="my_lnb" role="menu">
					<!-- [2023-05-25] 
						NPO가 '기부하기'에 참여할 확률이 희박할 것 같아 
						NPO 마이페이지 '나의 기부 물품 현황' 부분은 가리는 것으로 결정하였으며, 
						NPO 마이페이지 순서는 캠페인 관리 -> 캠페인 개설 -> 정보 수정 -> 회원 탈퇴로 변경 부탁드립니다.
					-->

					<?php
					// [2023-05-25] NPO 회원이 아닌 경우
					if($this->user->level != 20) {
					?>
					<a href="/mypage/donation/lists" role="menuitem" class="my_lnb_item" id="lnb_my_home" aria-current="<?php echo $arr_active['snav1']; ?>">나의 기부 물품 현황</a>
					<?php } ?>

					<?php if( isset($this->user->level) && $this->user->level > 10 ) { ?>
					<a href="/mypage/campaign/lists" role="menuitem" class="my_lnb_item" id="lnb_my_activity" aria-current="<?php echo $arr_active['snav3']; ?>">캠페인 관리</a>
					<a href="/mypage/campaign/write" role="menuitem" class="my_lnb_item" id="lnb_my_activity" aria-current="<?php echo $arr_active['snav4']; ?>">캠페인 개설</a>
					<?php } else { ?>
					<!-- <a href="/mypage/campaign" role="menuitem" class="my_lnb_item" id="lnb_my_activity" aria-current="false">나의 기부 현황</a> -->
					<?php } ?>

					<?php /* 
					<a href="/mypage/regularDonation?type=A" role="menuitem" id="my_lnb_item" class="my_lnb_item" aria-current="false">정기기부관리</a>
					<div role="menu">
						<a href="/mypage/regularDonation?type=A" role="menuitem" class="my_lnb_sub_item" id="lnb_my_regular_donation_A" aria-current="false">서브메뉴 A</a>
						<a href="/mypage/regularDonation?type=B" role="menuitem" class="my_lnb_sub_item" id="lnb_my_regular_donation_B" aria-current="false">서브메뉴 B</a>
					</div>
					*/ ?>

					<?php if($this->user->level == 20) { ?>
					<a href="/mypage/user/edit/" role="menuitem" class="my_lnb_item" id="lnb_my_notification" aria-current="<?php //echo $arr_active['snav2']; ?>">정보 수정</a>
					<?php } ?>
					<?php /* 
					<a href="/mypage/user/edit/" role="menuitem" class="my_lnb_item" id="lnb_my_notification" aria-current="<?php //echo $arr_active['snav2']; ?>">정보 수정</a>
					<a href="/auth/unregister/" role="menuitem" class="my_lnb_item">회원 탈퇴</a>
					*/ ?>
				</div>

			</div>

