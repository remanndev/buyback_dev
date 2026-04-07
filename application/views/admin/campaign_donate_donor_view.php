<!-- 캠페인 좌측 컨텐츠 -->
<div class="mypage_ctnt mb_50" style="width: 100%; max-width: 980px;">

	<h1 style="position: relative;">
		<div>기부자 정보</div>
		<div style="position: absolute; right: 0; bottom: 5px;">
			<button class="btn btn-secondary" onclick="window.history.back();">뒤로 가기</button>
		</div>
	</h1>

	<div class="tbl_purple">
		<table id="dsp_goods_table" style="width:100%;">
			<colgroup>
				<col width="140" />
				<col />
			</colgroup>
			<tr>
				<th>기부자 구분</th>
				<td><?php echo $dn_row->donor_type_text; ?></td>
			</tr>
			<?php if('B' == $dn_row->donor_type_code) { ?>
			<tr>
				<th>상호명(법인명)</th>
				<td><?php echo $dn_row->company; ?></td>
			</tr>
			<tr>
				<th>담당자 부서</th>
				<td><?php echo $dn_row->manager_dept; ?></td>
			</tr>
			<tr>
				<th>담당자 직함</th>
				<td><?php echo $dn_row->manager_title; ?></td>
			</tr>
			<?php } ?>
			<tr>
				<th><?php echo ('B' == $dn_row->donor_type_code) ? '담당자' : '이름'; ?></th>
				<td><?php echo $dn_row->donor_name; ?>  <?php echo ($dn_row->user_idx > 0) ? '('.$dn_row->user_username.')' : '(비회원)'; ?></td>
			</tr>
			<tr>
				<th>휴대전화</th>
				<td><?php echo $dn_row->cellphone; ?></td>
			</tr>
			<tr>
				<th>이메일</th>
				<td><?php echo $dn_row->email; ?></td>
			</tr>
			<tr>
				<th>방문주소</th>
				<td><?php echo $dn_row->postcode; ?> <?php echo $dn_row->addr; ?> <?php echo $dn_row->addr_detail; ?></td>
			</tr>
		</table>
	</div>



</div>



<h1 class="" style="width: 100%; max-width: 980px;">기부 상세 정보</h1>

<!-- 캠페인 좌측 컨텐츠 -->
<div class="mypage_ctnt">

	<dl class="mt_30">
		<dt>1. 캠페인명</dt>
		<dd class="mt-2 px-3 py-4" style="background-color:#f7f7fb;width: 100%; max-width: 980px;"">
			<?php echo $cmp_row->cmp_title; ?>
		</dd>
	</dl>

	<dl class="mt_30">
		<dt>2. 기부 물품 현재 상태</dt>
		<dd class="mt-2 px-3 py-4" style="background-color:#f7f7fb;width: 100%; max-width: 980px;"">
			<h5 class="m-0 p-0" style="font-weight:bold;"><?php echo date('Y년 m월 d일') ?> [<?php echo $dn_row->state_good_proc ?>]</h5>
		</dd>
	</dl>

	<dl class="mt_30">
		<dt>3. 기부 물품 처리 옵션(선택)</dt>
		<dd class="mt-2 px-3 py-4" style="background-color:#f7f7fb;width: 100%; max-width: 980px;"">
			<h5 class="m-0 p-0" style="font-weight:bold;"><?php echo $dn_row->opt_request_ko ?></h5>
		</dd>
	</dl>

	<dl class="mt_30">
		<dt>
			4-1. 기부 물품 정보 - 종류/수량/등급(기부자 관점)
			<!-- <span class="color_red ml_15">입력하시는 대로 바로 저장됩니다.</span> -->
		</dt>
		<dd>
			<div class="tbl_purple mt_5" style="width:100%; max-width: 980px;">
				<table id="dsp_goods_table" style="width:100%;">
					<tr>
						<th>종류</th>
						<th>수량</th>
						<!-- <th>제조사</th>
						<th>모델명</th>
						<th>구성부품</th>
						<th>비고</th> -->
						<th>등급(기부자관점)</th>
					</tr>
					<?php foreach($dngoods_list as $i => $o) { ?>
					<tr>
						<td class="text_center"><?php echo $o->gd_type; ?></td>
						<td class="text_center"><?php echo $o->gd_amt; ?></td>
						<td><?php echo $o->gd_grade; ?></td>
					</tr>
					<?php } ?>

					<?php 
					/* foreach($dngoods_list as $i => $o) { 
					? >
					<tr>
						<td class="text_center"><?php echo $o->gd_type; ?></td>
						<td class="text_center"><input type="text" class="o_input save_dngood" id="gd_amt_<?php echo $o->idx ?>" value="<?php echo $o->gd_amt; ?>" data-idx="<?php echo $o->idx ?>" data-fld="gd_amt" /> <span class="save_msg_absolute">saved!!!</span></td>
						<td class="text_center"><input type="text" class="o_input save_dngood" id="gd_maker_<?php echo $o->idx ?>" value="<?php echo $o->gd_maker; ?>" data-idx="<?php echo $o->idx ?>" data-fld="gd_maker" /> <span class="save_msg_absolute">saved!!!</span></td>
						<td class="text_center"><input type="text" class="o_input save_dngood" id="gd_model_<?php echo $o->idx ?>" value="<?php echo $o->gd_model; ?>" data-idx="<?php echo $o->idx ?>" data-fld="gd_model" /> <span class="save_msg_absolute">saved!!!</span></td>
						<td class="text_center"><input type="text" class="o_input save_dngood" id="gd_part_<?php echo $o->idx ?>" value="<?php echo $o->gd_part; ?>" data-idx="<?php echo $o->idx ?>" data-fld="gd_part" /> <span class="save_msg_absolute">saved!!!</span></td>
						<td class="text_center"><input type="text" class="o_input save_dngood" id="gd_memo_<?php echo $o->idx ?>" value="<?php echo $o->gd_memo; ?>" data-idx="<?php echo $o->idx ?>" data-fld="gd_memo" /> <span class="save_msg_absolute">saved!!!</span></td>
						<td><?php echo $o->gd_grade; ?></td>
					</tr>
					< ?php
					}
					*/ ?>

				</table>
			</div>
		</dd>
	</dl>

	<dl class="mt_30">
		<dt>
			4-2. 기부 물품 정보 - 배출 물품 설명
		</dt>
		<dd class="mt-2 px-3 py-4" style="background-color:#f7f7fb;width: 100%; max-width: 980px;"">
			<div class="m-0 p-0" style=""><?php echo nl2br($dn_row->goods_memo); ?></div>
		</dd>
	</dl>




	<style type="text/css">
		.dnpic_wrap { width: 32%; height: auto; background-color: #e6e6f2; }
		.dnpic_wrap img { width: 100%; height: auto; border: 1px dashed gray;}
	</style>

	<dl class="mt_30">
		<dt>
			4-3. 기부 물품 정보 - 사진
		</dt>
		<dd>
			<div class="mt-2 px-3 py-4" style="background-color:#f7f7fb; width: 980px;">
				<div class="dsp_flex_sp_between">
					<?php foreach($file_result['qry'] as $fkey => $frow) { ?>

						<div class="dnpic_wrap">
							<img src="<?php echo DATA_DIR ?>/<?php echo $frow->file_dir; ?>/<?php echo $frow->file_name; ?>" />
						</div>

					<?php } ?>
				</div>
			</div>
		</dd>
	</dl>



	<dl class="mt_30">
		<dt>
			5. 기부 물품 처리 상황 
			<!-- <span class="color_red ml_15">입력하시는 대로 바로 저장됩니다.</span> -->
		</dt>
		<dd>
			<div class="tbl_purple mt_5" style=" width: 100%; max-width: 980px;">

				<table id="dsp_goods_table" style="width:100%;">
					<tr class="text-center">
						<th>진행상태</th>
						<th>처리상황</th>
						<th>처리일자</th>
						<th>메모</th>
					</tr>
					<tr>
						<td class="text-center" title="기부 접수일자">접수</td>
						<td class="text-center" title="접수 상태"><?php echo $dn_row->state_accept_txt ?></td>
						<td class="text-center"><?php echo substr($dn_row->reg_datetime,0,10); ?></td>
						<td>
							수거요청일시 : <?php echo ('' != $dn_row->pickup_req_date) ? substr($dn_row->pickup_req_date,0,13).'시' : ''; ?>
						</td>
					</tr>
					<tr>
						<td class="text-center" title="택배API 수거일자">수거</td>
						<td class="text-center" title="수거 상태"><?php echo $dn_row->state_pickup_txt ?></td>
						<td class="text-center"><?php echo $dn_row->whDate; ?></td>
						<td>
							수거희망일자 : <?php echo ('' != $dn_row->pickup_date_plz) ? $dn_row->pickup_date_plz : '<span style="color:#AAA;">요청없음</span>'; ?>
						</td>
					</tr>
					<tr>
						<td class="text-center" title="ROS 검수 시작일자">검수</td>
						<td class="text-center" title="검수 상태"><?php echo $dn_row->state_check_txt ?></td>
						<td class="text-center"><?php echo $dn_row->inspDate; ?></td>
						<td></td>
					</tr>
					<tr>
						<td class="text-center" title="ROS 삭제보고서 생성일자">삭제보고서</td>
						<td class="text-center" title="삭제보고서 생성일자"><?php echo $dn_row->state_delreport_txt ?></td>
						<td class="text-center"><?php echo $dn_row->delDate; ?></td>
						<td></td>
					</tr>
					<tr>
						<td class="text-center">기부처리</td>
						<td class="text-center">
							<label for="dn_state_handout_finish_<?php echo $dn_row->idx ?>">
								<?php 
								// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
								// 완료 처리를 한 후에는 더 이상 체크(true/false) 불가
								// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
								if('1' !== $dn_row->state_handout_finish) { 
								?>
								<input type="checkbox" class="o_input save_dn_chkbox dn_state_handout_finish" id="dn_state_handout_finish_<?php echo $dn_row->idx ?>" value="1" data-idx="<?php echo $dn_row->idx ?>" data-fld="state_handout_finish" <?php echo (1 == $dn_row->state_handout_finish) ? 'checked' : ''; ?> /> 
								<?php 
								}
								// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
								?>
								완료 
								<span id="msg_alimtalk_<?php echo $dn_row->idx ?>"" class="msg_alimtalk"><?php echo ('1' == $dn_row->state_handout_finish) ? ' (알림톡 발송)' : ''; ?></span>
								<span class="save_msg">saved!!!</span>
							</label>
						</td>
						<td class="text-center">
							<input type="text" readonly style="width: 100%; border: none; font-size: 15px;" class="o_input text-center" id="dn_handout_finish_date_<?php echo $dn_row->idx ?>" value="<?php echo $dn_row->handout_finish_date; ?>" data-idx="<?php echo $dn_row->idx ?>" data-fld="handout_finish_date" /> <span class="save_msg_absolute">saved!!!</span>
						</td>
						<td class="text-center">
							<input type="text" class="o_input save_dn" id="dn_memo_handout_finish_<?php echo $dn_row->idx ?>" value="<?php echo $dn_row->memo_handout_finish; ?>" data-idx="<?php echo $dn_row->idx ?>" data-fld="memo_handout_finish" style="width:100%;" /> <span class="save_msg_absolute">saved!!!</span>
						</td>
					</tr>

				</table>

			</div>
		</dd>
	</dl>

	<dl class="mt_10">
		<dt>[물류 추적]</dt>
		<dd>
			<div class="tbl_purple mt_5" style="width: 100%; max-width: 980px;">

				<table id="dsp_goods_table" style="width:100%;">
					<tr class="text-center">
						<th>시간</th>
						<th>현재위치</th>
						<th>배송차수</th>
						<th>배송상태</th>
					</tr>
					<?php 
					if($trackingData) {
					 foreach($trackingData as $key => $row) {
					?>
					<tr>
						<td><?php echo $row['scan_YMD'] ?> <?php echo $row['scan_HOUR'] ?></td>
						<td><?php echo $row['dealt_BRAN_NM'] ?></td>
						<td><?php echo $row['rcpt_DV'] ?>차</td>
						<td><?php echo $row['crg_ST_NM'] ?></td>
					</tr>
					<?php
					 }
					}
					?>
			  </table>

			</div>
		</dd>
	</dl>





	<dl class="mt_30">
		<dt>6. 기부 물품 검수 현황</dt>
		<!-- <dd class="mt_10 py_20 px_20" style="background-color:#f7f7fb;">
			<div>기부된 물품의 상세 검수 현황을 확인할 수 있습니다.</div>
			<a href="<?php echo base_url() ?>admin/campaign/donate/report_check/<?php echo $cmp_row->code; ?>/<?php echo $dn_row->idx ?>/<?php echo $dn_row->user_idx ?>"><button type="button" class="o_btn btn btn-purple-line mt_10">상세 검수 현황</button></a>
		</dd> -->

		<dd>

			<?php if( empty($item_list) ) { ?>
			  <div class="mt_10 py_20 px_20" style="background-color:#f7f7fb;width: 100%; max-width: 980px;">
				<div>검수전입니다. 검수가 완료되면 표시됩니다.</div>
			  </div>
			<?php } else { ?>
			  <div class="mt_10">기부된 물품의 상세 검수 현황을 확인할 수 있습니다.</div>
			  <div class="tbl_purple" style="width: 100%; max-width: 980px;">
				<table id="dsp_itmes_table" style="width:100%;">
					<tr class="text-center">
						<th>NO</th>
						<th>종류</th>
						<th>제조사</th>
						<th>모델명</th>
						<th>판정등급</th>
					</tr>
					<?php 
					foreach($item_list as $key => $chk_row) {
					?>
					<tr class="text-center">
						<td><?php echo $key + 1 ?></td>
						<td><?php echo $chk_row->insp_kind ?></td>
						<td><?php echo $chk_row->mfr ?></td>
						<td><?php echo $chk_row->model ?></td>
						<td><?php echo $chk_row->grade ?></td>
					</tr>
					<?php 
					}
					?>
				</table>
				<div class="text-right" style="font-size: 14px;">* 실제로 검수한 수량이며, 기부신청서 작성시 입력한 수량과 차이가 있을 수 있습니다.</div>
			  </div>
			  
			<?php } ?>

		</dd>
	</dl>

	<dl class="mt_30">
		<dt>
			7. 기부 가치 평가
			<!-- <span class="color_red ml_15">입력하시는 대로 바로 저장됩니다.</span> <span class="color_red_light ml_5">새로고침하시면 저장 상태를 확인하실 수 있습니다.</span> -->
		</dt>

		<dd>
		  <?php if( empty($item_list) ) { ?>
			<div class="mt_10 py_20 px_20" style="background-color:#f7f7fb; width: 100%; max-width: 980px;">
			  <div>평가전입니다. 평가가 완료되면 표시됩니다.</div>
			</div>
		  <?php } else { ?>

			<div class="mt_10 py_20 px_20" style="background-color:#f7f7fb; width: 100%; max-width: 980px;">
				<div>* 당신의 기부는 총 <span class="color_red"><?php echo number_format($worth_val_total); ?>원</span>의 가치로 평가되었습니다. </div>
				<div>* 검수결과 C등급 이상의 제품만 재생됩니다.</div>
			</div>

			<div class="o_table_mobile">
				<div class="tbl_purple mt_5 tbl_scroll" style="width: 100%; max-width: 980px;">
					<table id="dsp_goods_table" style="width:100%;">
						<colgroup>
							<col />
							<col style="width: 14%;" />
							<col style="width: 12%;" />
							<col style="width: 17%;" />
						</colgroup>
						<tr>
							<th>기부명</th>
							<th>검수평가</th>
							<th>수량</th>
							<th>기부가치</th>
						</tr>
						<tr>
							<td rowspan="2" class=""><?php echo $cmp_row->cmp_title; ?></td>
							<td class="text_center">재생 대상</td>
							<td class="text_right"><?php echo number_format($arr_worth_cnt['reproduct']) ?> 대</td>
							<td class="text_right"><?php echo number_format($arr_worth_val['reproduct']) ?> 원</td>
						</tr>
						<tr>
							<td class="text_center">재활용 대상</td>
							<td class="text_right"><?php echo number_format($arr_worth_cnt['recycle']) ?> 대</td>
							<td class="text_right"><?php echo number_format($arr_worth_val['recycle']) ?> 원</td>
						</tr>
					</table>
				</div>
			</div>

		  <?php } ?>
		</dd>

	</dl>

	<!-- <dl class="mt_30">
		<dt>8. 데이터 완전 삭제 현황</dt>
		<dd>
			<div class="mt_10 py_20 px_20" style="background-color:#f7f7fb; width: 100%; max-width: 980px;">
				<div>데이터 삭제 리포트를 확인할 수 있습니다.</div>
				<a href="<?php echo base_url() ?>admin/campaign/donate/report_del/<?php echo $cmp_row->code; ?>/<?php echo $dn_row->idx ?>/list"><button type="button" class="o_btn btn btn-purple-line mt_10">데이터 완전 삭제 리포트</button></a>
			</div>
		</dd>
	</dl> -->

	<dl class="mt_30">
		<dt>8. 데이터 완전 삭제 현황</dt>
		<dd>
		  <div class="mt_10 py_20 px_20" style="background-color:#f7f7fb; width: 100%; max-width: 980px;">
			<?php if( empty($item_list) ) { ?>
				<div>검수전입니다. 검수가 완료되면 표시됩니다.</div>
			<?php } else { ?>
				<div>데이터 삭제 리포트를 확인할 수 있습니다.</div>

				<a href="<?php echo base_url('admin/campaign/donate/report_del_ros/'.$cmp_row->code.'/'.$dn_row->idx) ?>" target="_blank"><button type="button" class="o_btn btn btn-purple-line mt_10">데이터 완전 삭제 리포트</button></a>
				
				<?php if('' != $download_blancco_link) { ?>
				<a href="<?php echo $download_blancco_link ?>" target="blancco"><button type="button" class="o_btn btn btn-purple-line mt_10">블랑코 삭제 리포트</button></a>
				<?php } else { ?>
				<button type="button" onclick="alert('준비중입니다.'); return false;" class="o_btn btn btn-purple-line mt_10" disabled>블랑코 삭제 리포트</button>
				<?php } ?>

			<?php } ?>
		  </div>
		</dd>
	</dl>

	<!-- <dl class="mt_30">
		<dt>9. 기부금 영수증 확인</dt>
		<dd class="mt_10 py_20 px_20" style="background-color:#f7f7fb;">

			<div>기부금 영수증 신청(일자) : <?php //echo isset($dn_row->receipt_req_dt) ? '신청 ('.substr($dn_row->receipt_req_dt,0,10).')' : '미신청'; ?></div>
			<hr style="border: none; border-bottom: 1px dashed #ccc;" />

			<div>기부금 영수증 사본을 확인 할 수 있습니다.</div>
			<a href="<?php echo base_url() ?>admin/campaign/donate/report_receipt/<?php //echo $cmp_row->code; ?>/<?php //echo $dn_row->idx ?>"><button type="button" class="o_btn btn btn-purple-line mt_10">기부금 영수증 보기</button></a>
		</dd>
	</dl> -->

</div>



<?php /*
<div class="mt_30">
	<div style="width: 100%; max-width: 980px; text-align: right;">
		<a href="#" onclick="confirm_remove(this,'<?php echo $cmp_row->code ?>','<?php echo $dn_row->idx ?>'); return false;"><button class="btn btn-danger-flat px_20">기부 삭제</button></a>
		<a href="#" onclick="confirm_cancel(this,'<?php echo $cmp_row->code ?>','<?php echo $dn_row->idx ?>'); return false;"><button class="btn btn-warning-flat px_20">기부 취소</button></a>
	</div>
</div>
*/?>

<div class="mt_30">
	<div style="width: 100%; max-width: 980px; text-align: right;">
		<a href="#" onclick="confirm_cancel(this,'<?php echo $cmp_row->code ?>','<?php echo $dn_row->idx ?>'); return false;"><button class="btn btn-warning-flat px_20">기부 취소</button></a>
	</div>
</div>



<script type="text/javascript">
	// datetimepicker
	$.datetimepicker.setLocale('kr');
	$('.datepicker').datetimepicker({
		lang:'kr',
		timepicker:false,
		format:'Y-m-d',
		scrollMonth : false 
	});
</script>

<script type="text/javascript">
$(document).ready(function(){

	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	// focus on
	$('.save_dngood').on('click keypress', function() {
		$(this).css('color','red');
	});
	$('.save_dn').on('click keypress', function() {
		$(this).css('color','red');
	});
	// focus off
	$('.save_dngood').on('blur', function() {
		$(this).css('color','#000000');
	});
	$('.save_dn').on('blur', function() {
		$(this).css('color','#000000');
	});

	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	// 기부 물품 관련 정보 저장
	$('.save_dngood').on('blur keyup', function() {

		var obj = $(this);

		// focus off
		//$(this).css('color','#000000');

		//var tbl = 'donation_goods';
		var fld = $(this).data('fld');
		var idx = $(this).data('idx');
		var val = $(this).val();
		if( $(this).hasClass('treat_comma') ) {
			val = removeComma(val);
		}
		//console.log(idx +'/'+ fld +'/'+ val);
		var request = $.ajax({
		  url: "/admin/campaign/trans/dngood_update",
		  method: "POST",
		  data: { 'idx':idx,'fld':fld,'val':val },
		  dataType: "html"
		});
		request.done(function( res ) {
		  //console.log(res);
		  obj.next().css('display', 'inline-block');;
		  setTimeout(msgAutoHide, 1000, obj);
		});
		request.fail(function( jqXHR, textStatus ) {
		  alert( "Request failed: " + textStatus );
		  return false;
		});
	});

	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	// 기부자 관련 정보 저장
	$('.save_dn').on('blur keyup', function() {

		var obj = $(this);

		// focus off
		//$(this).css('color','#000000');

		//var tbl = 'donation';
		var fld = $(this).data('fld');
		var idx = $(this).data('idx');
		var val = $(this).val();
		if( $(this).hasClass('treat_comma') ) {
			val = removeComma(val);
		}
		//console.log(idx +'/'+ fld +'/'+ val);
		var request = $.ajax({
		  url: "/admin/campaign/trans/dn_update",
		  method: "POST",
		  data: { 'idx':idx,'fld':fld,'val':val },
		  dataType: "html"
		});
		request.done(function( res ) {
		  //console.log(res);
		  obj.next().css('display', 'inline-block');;
		  setTimeout(msgAutoHide, 1000, obj);
		});
		request.fail(function( jqXHR, textStatus ) {
		  alert( "Request failed: " + textStatus );
		  return false;
		});

	});


	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	// 기부자 물품 완료 처리
	//$('.save_dn_chkbox').on('click', function() {
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	$('.dn_state_handout_finish').on('click', function() {

		const obj = $(this);

		const dn_idx = obj .data('idx');
		var chked = obj .is(":checked");
		var chked_val = ( chked ) ? '1' : '0';
		// console.log(chked_val);

		var msg_confirm = '완료 처리를 하면 알림톡이 발송됩니다.\n완료 처리 하시겠습니까?';
		if( ! confirm(msg_confirm)){
			//console.log('false');
			return false;
		}
		else{
			//console.log('true');
		}

		// - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		//const dn_idx = obj .data('idx');
		//var chked = obj .is(":checked");
		//var chked_val = ( chked ) ? '1' : '0';

		var idx = obj .data('idx');
		var fld = obj .data('fld');
		var val = chked_val;

		console.log(idx +'/'+ fld +'/'+ val);
		var request = $.ajax({
		  url: "/admin/campaign/trans/dn_update",
		  method: "POST",
		  data: { 'idx':idx,'fld':fld,'val':val },
		  dataType: "html"
		});
		request.done(function( res ) {

			// 성공하면 dn_idx 리턴, 
			// 실패하면 false 리턴
			console.log(res); 

			if( ! res || res != dn_idx ) {

				// 완료 처리 실패하면 체크 해제
				obj.prop('checked', false);

				console.log('false');
				alert('완료처리에 실패했습니다.\n관리자에 문의해주세요.');
				return false;

			}
			else {

				// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
				// 완료 처리 성공
				// 1. 알림톡 발송
				if('1' == chked_val) {
					console.log('체크를 했을 때만 알림톡 발송\n체크 해제시에는 알림톡 패스');

					var donor_name = '<?php echo $dn_row->donor_name; ?>';
					var donor_phone = '<?php echo $dn_row->cellphone; ?>';
					var request = $.ajax({
					  url: "/admin/campaign/trans/alimtalk_dn_complete",
					  method: "POST",
					  data: { 'dn_idx':dn_idx,'donor_name':donor_name,'donor_phone':donor_phone },
					  dataType: "html"
					});
					request.done(function( res_aligo ) {

						// 알림톡 발송 이후, 완료처리일자 저장
						// res_aligo ==> 발송 성공 'succ', 발송 실패 'fail'
						console.log(res_aligo);

						if('succ' == res_aligo) {
							$('#msg_alimtalk_'+dn_idx).html(' (알림톡 발송)');
						}

					});
					request.fail(function( jqXHR, textStatus ) {
					  alert( "Request failed: " + textStatus ); // Request failed: parsererror
					  return false;
					});
				}

				
				// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
				// 2. 완료 처리 날짜 등록
					const dt_ymd = getTodayYMD();
					console.log(dt_ymd);

					// 완료 처리일자 저장
					var dt_fld = 'handout_finish_date';
					var dt_val = ('1' == chked_val) ? dt_ymd : '';

					var request = $.ajax({
					  url: "/admin/campaign/trans/dn_update",
					  method: "POST",
					  data: { 'idx':dn_idx,'fld':dt_fld,'val':dt_val },
					  dataType: "html"
					});
					request.done(function( res ) {
						// 완료처리 일자 저장
						$('#dn_handout_finish_date_'+dn_idx).val(dt_val);
						// 더 이상 완료처리할 수 없도록 삭제
						$('#dn_state_handout_finish_'+dn_idx).remove();

					});
					request.fail(function( jqXHR, textStatus ) {
					  alert( "Request failed: " + textStatus );
					  return false;
					});


			}

			/*
			const dt_ymd = getTodayYMD();
			console.log(dt_ymd);

			// 완료 처리일자 저장
			var dt_fld = 'handout_finish_date';
			var dt_val = ('1' == chked_val) ? dt_ymd : '';

			var request = $.ajax({
			  url: "/admin/campaign/trans/dn_update",
			  method: "POST",
			  data: { 'idx':dn_idx,'fld':dt_fld,'val':dt_val },
			  dataType: "html"
			});
			request.done(function( res ) {
				// 완료처리 일자 저장
				$('#dn_handout_finish_date_'+dn_idx).val(dt_val);
				// 더 이상 완료처리할 수 없도록 삭제
				$('#dn_state_handout_finish_'+dn_idx).remove();

			});
			request.fail(function( jqXHR, textStatus ) {
			  alert( "Request failed: " + textStatus );
			  return false;
			});
			*/

		});
		request.fail(function( jqXHR, textStatus ) {
		  alert( "Request failed: " + textStatus );
		  return false;
		});

	});

	// saved 완료 메시지 출력 후 사라짐
	function msgAutoHide(obj) {
	  obj.next().fadeOut();
	}

	// 현재 날짜 반환
	function getTodayYMD() {
	  let d = new Date();
	  return d.getFullYear() + '-' 
		   + String(d.getMonth() + 1).padStart(2, '0') + '-' 
		   + String(d.getDate()).padStart(2, '0');
	}

	



	// 금액 콤마 처리
	$('.treat_comma').on('keyup blur', function() {
		str = addComma(removeComma($(this).val()));
		$(this).val(str);
	});


	// 기부가치 합산 기부가치로 더해주기.
	$('.chk_recycle_worth').on('blur', function() {
		obj = $(this);
		calc_donation_value(obj);
	});
	$('.chk_reuse_worth').on('blur', function() {
		obj = $(this);
		calc_donation_value(obj);
	});

	function calc_donation_value(obj) {
		var dn_val = addComma( Number(removeComma($('.chk_recycle_worth').val())) + Number(removeComma($('.chk_reuse_worth').val())) );
		$('#donation_value').val(dn_val);
		$('#donation_value').focus();
		$('#donation_value').blur();
	}

});
</script>




<script type="text/javascript">
// [2023-09-22] 캠페인 기부 상세 페이지 접속시 관리자 확인 체크(New 표시 삭제)
$(document).ready(function(){

		var idx = '<?php echo $dn_row->idx; ?>';
		var fld = 'mng_chk';
		var val = '<?php echo TIME_YMDHIS ?>';
		//console.log(idx +'/'+ fld +'/'+ val);
		var request = $.ajax({
		  url: "/admin/campaign/trans/dn_update",
		  method: "POST",
		  data: { 'idx':idx,'fld':fld,'val':val },
		  dataType: "html"
		});
		request.done(function( res ) {
		  //console.log(res);
		});
		request.fail(function( jqXHR, textStatus ) {
		  alert( "Request failed: " + textStatus );
		  return false;
		});

});
</script>



<script>
// 일반 삭제 검사 확인
	/*
	function confirm_remove(obj,cmp_code,dn_idx) {
		if(confirm("\n한번 삭제한 자료는 복구할 방법이 없습니다.\n삭제하시겠습니까?")) {
			if(confirm("정말 삭제하시겠습니까?")) {
				var request = $.ajax({
				  url: "/admin/campaign/trans_donate_donor_del/",
				  method: "POST",
				  data: { 'cmp_code' : cmp_code, 'dn_idx' : dn_idx  },
				  dataType: "html"
				});
				request.done(function( res ) {
					//console.log(res);
					if('succ' == res) {
						// 목록으로 돌아가기
					}
					else {
						alert('삭제되지 않았습니다.\n문제가 계속 되면 관리자에 문의해주세요.');
					}
				});
				request.fail(function( jqXHR, textStatus ) {
				  alert( "Request failed: " + textStatus );
				  console.log(error);
				  //alert( "access error.." );
				  return false;
				});
			}
		}
	}
	*/

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
// 기부 취소 확인
// [취소이지만 삭제처리 업데이트]
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	function confirm_cancel(obj,cmp_code,dn_idx) {
		if(confirm("\n기부자의 취소 의사를 확인하셨습니까?")) {
			if(confirm("정말 취소하시겠습니까?")) {
				var request = $.ajax({
				  url: "/admin/campaign/trans_donate_donor_cancel/",
				  method: "POST",
				  data: { 'cmp_code' : cmp_code, 'dn_idx' : dn_idx},
				  dataType: "html"
				});
				request.done(function( res ) {
					console.log(res);
					if('succ' == res) {
						// 목록으로 돌아가기
						alert('취소 처리는 되었으나,\n사용자 및 관리자 페이지에 취소 상태를 적용중입니다.');
					}
					else {
						alert('취소되지 않았습니다.\n문제가 계속 되면 관리자에 문의해주세요.');
					}
				});
				request.fail(function( jqXHR, textStatus ) {
				  alert( "Request failed: " + textStatus );
				  console.log(error);
				  //alert( "access error.." );
				  return false;
				});
			}
		}
	}
</script>