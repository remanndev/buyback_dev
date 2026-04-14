
	<!-- [2023-05-25] 
		NPO가 '기부하기'에 참여할 확률이 희박할 것 같아 
		NPO 마이페이지 '나의 기부 물품 현황' 부분은 가리는 것으로 결정하였으며, 
		NPO 마이페이지 순서는 캠페인 관리 -> 캠페인 개설 -> 정보 수정 -> 회원 탈퇴로 변경 부탁드립니다.
	-->
	<div class="m_slide_nav d-block d-md-none">
		<div class="m_slide_nav_wrap">
			<div class="m_list_nav">
				<ul>
					<?php if($this->user->level != 20) { /* [2023-05-25] NPO 회원이 아닌 경우 */ ?>
					<li><span><a href="/mypage/buyback/lists">매입 신청 내역</a></span></li>
					<li><span><a href="/mypage/donation/lists">나의 기부 물품 현황</a></span></li>
					<?php } ?>
					<?php if( isset($this->user->level) && $this->user->level > 10 ) { ?>
					<li><span><a href="/mypage/campaign/lists">캠페인 관리</a></span></li>
					<li><span><a href="/mypage/campaign/write">캠페인 개설</a></span></li>
					<?php } ?>
					<?php if($this->user->level == 20) { ?>
					<li><span><a href="/mypage/user/edit/">정보수정</a></span></li>
					<?php } ?>
					<?php /* 
					<li><span><a href="/auth/unregister/">회원 탈퇴</a></span></li>
					<?php */ ?>
				</ul>
			</div>
		</div>
	</div>

