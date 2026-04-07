
<h1>기부금 영수증 보기</h1>

<h2 class="mb_40" style="color:#353535;">캠페인명</h2>
<div class="mypage_ctnt">
	<dl class="mt_10">
		<!-- <dt>1. 기부명</dt> -->
		<dd class="mt_10 py_20 px_20" style="background-color:#f7f7fb;">
			<?php echo $cmp_row->cmp_title; ?>
		</dd>
	</dl>
</div>


<h2 class="mb_40" style="color:#353535; position:relative;">
	기부금 영수증 신청 여부
</h2>
<div class="mypage_ctnt">
	<dl class="mt_10">
		<!-- <dt>1. 기부명</dt> -->
		<dd class="mt_10 py_20 px_20" style="background-color:#f7f7fb;">
			<?php echo isset($dn_row->receipt_req_dt) ? '신청 ('.substr($dn_row->receipt_req_dt,0,10).')' : '미신청'; ?>
		</dd>
	</dl>
</div>


<h2 class="mb_40" style="color:#353535; position:relative;">
	기부금 영수증 보기
</h2>
<div class="mypage_ctnt">
	<div class="tbl_purple mt_10">

	</div>


</div>

