
<h1>상세 검수 현황</h1>

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
	기부 물품 검수 현황 (ROS 서버 기준)
</h2>
	<div class="mypage_ctnt" style="width: 100%; max-width: 1000px;">
		<div class="tbl_purple mt_10">

			<table id="dsp_itmes_table" style="width:100%;">
				<tr>
					<th>NO</th>
					<th class="text-center">종류</th>
					<th class="text-center">제조사</th>
					<th class="text-center">모델명</th>
					<!-- <th class="text-center">기기사양</th> -->
					<th class="text-center">판정등급</th>
				</tr>

				<?php 
				//foreach($dngoods_list as $i => $o) { 
				//foreach($dnchk_result['qry'] as $key => $chk_row) {
				foreach($item_list as $key => $chk_row) {
				?>
				<tr>
					<td class="text-center"><?php echo $key + 1 ?></td>
					<td class="text-center"><?php echo $chk_row->insp_kind ?></td>
					<td class="text-center"><?php echo $chk_row->mfr ?></td>
					<td class="text-center"><?php echo $chk_row->model ?></td>
					<td class="text-center"><?php echo $chk_row->grade ?></td>
				</tr>
				<?php 
				}
				?>
			</table>

		</div>
	</div>

	<!-- <hr /> -->





<div style="display: none;">

	<h2 class="mb_40" style="color:#353535; position:relative;">
		기부 물품 검수 현황
		<button type="button" id="btn_add_item" class="o_btn  btn-sm btn-purple-flat" style="position:absolute; right:0; vertical-align: baseline;">추가</button>
	</h2>
	<div class="mypage_ctnt">
		<div class="tbl_purple mt_10">
			<?php echo form_open_multipart($this->uri->uri_string(), array('id'=>'check_form','name'=>'check_form', 'onsubmit'=>'return form_check();')); ?>

				<input type="hidden" name="cmp_code" value="<?php echo $cmp_code ?>" />
				<input type="hidden" name="donate_idx" value="<?php echo $donate_idx ?>" />
				<input type="hidden" name="user_idx" value="<?php echo $user_idx ?>" />

				<table id="dsp_goods_table" style="width:100%;">
					<tr>
						<!-- <th>NO</th> -->
						<th class="text-center">종류</th>
						<th class="text-center">제조사</th>
						<th class="text-center">모델명</th>
						<th class="text-center">기기사양</th>
						<th class="text-center">판정등급</th>
						<th class="text-center">삭제<!-- <button type="button" class="o_btn btn-xs btn-default-flat" style="margin-left:4px; vertical-align: baseline;padding:0 12px; line-height:34px;" disabled>삭제</button> --></th>
					</tr>
					<?php 
					foreach($dnchk_result['qry'] as $key => $chk_row) {
					?>
					<tr>
						<!-- <td class="text-center"><input type="text" class="o_input save_item" value="" data-idx="" data-fld="" /></td> -->
						<td class="text-center"><input type="text" style="width:100%;" class="o_input save_item" name="chk_kind[]" value="<?php echo $chk_row->chk_kind ?>" /></td>
						<td class="text-center"><input type="text" style="width:100%;" class="o_input save_item" name="chk_maker[]" value="<?php echo $chk_row->chk_maker ?>" /></td>
						<td class="text-center"><input type="text" style="width:100%;" class="o_input save_item" name="chk_model[]" value="<?php echo $chk_row->chk_model ?>" /></td>
						<td class="text-center"><input type="text" style="width:100%;" class="o_input save_item" name="chk_spec[]" value="<?php echo $chk_row->chk_spec ?>" /></td>
						<td class="text-center"><input type="text" style="width:100%;" class="o_input save_item" name="chk_grade[]" value="<?php echo $chk_row->chk_grade ?>" /></td>
						<td class="text-center">
							<input type="hidden" name="idx[]" value="<?php echo $chk_row->idx ?>" />
							<button type="button" onclick="remove_item(this,<?php echo $chk_row->idx ?>);" class="o_btn btn-xs btn-danger-flat" style="margin-left:4px; vertical-align: baseline;padding:0 12px; line-height:34px;" >X</button>
						</td>
					</tr>
					<?php 
					}
					?>
					<!-- <tr>
						<td class="text-center"><input type="text" style="width:100%;" class="o_input save_item" name="chk_kind[]" value="" /></td>
						<td class="text-center"><input type="text" style="width:100%;" class="o_input save_item" name="chk_maker[]" value="" /></td>
						<td class="text-center"><input type="text" style="width:100%;" class="o_input save_item" name="chk_model[]" value="" /></td>
						<td class="text-center"><input type="text" style="width:100%;" class="o_input save_item" name="chk_spec[]" value="" /></td>
						<td class="text-center"><input type="text" style="width:100%;" class="o_input save_item" name="chk_grade[]" value="" /></td>
						<td class="text-center">
							<input type="hidden" name="idx[]" value="" />
							<button type="button" onclick="remove_item(this,'');" class="o_btn btn-xs btn-danger-flat remove_itm" style="margin-left:4px; vertical-align: baseline;padding:0 12px; line-height:34px;" >X</button>
						</td>
					</tr> -->
				</table>

				<div class="my_50 text-center"><button type="submit" class="o_btn btn btn-purple-flat" style="padding:10px 30px;">저장</button></div>

			<?php echo form_close(); ?>
		</div>

	</div>

</div>


<!-- 기부 물품 검수 현황 샘플용 # 삭제하지 마세요. -->
<table id="add_item_sample" style="display:none;">
	<tr>
		<td class="text-center"><input type="text" style="width:100%;" class="o_input save_item" name="chk_kind[]" value="" /></td>
		<td class="text-center"><input type="text" style="width:100%;" class="o_input save_item" name="chk_maker[]" value="" /></td>
		<td class="text-center"><input type="text" style="width:100%;" class="o_input save_item" name="chk_model[]" value="" /></td>
		<td class="text-center"><input type="text" style="width:100%;" class="o_input save_item" name="chk_spec[]" value="" /></td>
		<td class="text-center"><input type="text" style="width:100%;" class="o_input save_item" name="chk_grade[]" value="" /></td>
		<td class="text-center"><input type="hidden" name="idx[]" value="" /><button type="button" onclick="remove_item(this,'');" class="o_btn btn-xs btn-danger-flat" style="margin-left:4px; vertical-align: baseline;padding:0 12px; line-height:34px;">X</button></td>
	</tr>
</table>


<script type="text/javascript">

	function form_check() {
		return true;
	}


	// item 삭제
	function remove_item(_this, idx){

		//console.log( $(_this).attr('class') );

		if(idx != '') {
			// data 삭제
			var request = $.ajax({
			  url: "/admin/campaign/trans/dn_reportchk_del",
			  method: "POST",
			  data: { 'idx':idx },
			  dataType: "html"
			});
			request.done(function( res ) {
			  //console.log(res);
			  alert('삭제되었습니다.');
			});
			request.fail(function( jqXHR, textStatus ) {
			  alert( "Request failed: " + textStatus );
			  return false;
			});
		}

		// remove tr field
		$(_this).parents().parents('tr').remove();
	};

	$(document).ready(function(){

		/* 캠페인 만들기 # 목표기기 추가 */
		$('#btn_add_item').on('click', function(){
			html = $('#add_item_sample').html();
			$('#dsp_goods_table').append(html);
		});

		$('.remove_itm').on('click',function(){
			$(this).parents().parents('tr').remove();
		});




	/*
		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		// focus on
		$('.save_item').on('click keypress', function() {
			$(this).css('color','red');
		});
		// focus off
		$('.save_item').on('blur', function() {
			$(this).css('color','#000000');
		});

		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		// 기부 물품 관련 정보 저장
		$('.save_item').on('blur keyup', function() {
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
			});
			request.fail(function( jqXHR, textStatus ) {
			  alert( "Request failed: " + textStatus );
			  return false;
			});
		});

	*/

	});
</script>