<?php

// 카테고리메뉴
//$selected_ca_code =  (isset($cate_menu) && '' !=$cate_menu) ? $cate_menu : (isset($row->ca_code) ? $row->ca_code : set_value('ca_code'));
$selected_combo_cate1 =  $combo_cate1;
$combo_cate1_options = array('' => '전체');
foreach($result_cate1['qry'] as $i => $o) {
	$combo_cate1_options[$o->idx] = $o->name;
}

$selected_combo_cate2 =  $combo_cate2;
$combo_cate2_options = array('' => '전체');
foreach($result_cate2['qry'] as $i => $o) {
	$combo_cate2_options[$o->idx] = $o->name;
}

$selected_combo_cate3 =  $combo_cate3;
$combo_cate3_options = array('' => '전체');
foreach($result_cate3['qry'] as $i => $o) {
	$combo_cate3_options[$o->idx] = $o->name;
}

$selected_combo_cate4 =  $combo_cate4;
$combo_cate4_options = array('' => '전체');
foreach($result_cate4['qry'] as $i => $o) {
	$combo_cate4_options[$o->idx] = $o->name;
}


// 검색 필드
$searched_field = $sfl;
$search_select_options = array(
	//'all'    => '통합검색',
	'itm_title'    => '제품명',
	'itm_subtitle'   => '간단설명'
);

// 검색어
$search_text = array(
	'name'	=> 'stx',
	'id'	=> 'stx',
	'value' => trim(set_value('stx',($stx) ? $stx : '')),
	'maxlength'	=> 20,
	'class'	=> 'o_input'
);

?>
	<h1 style="margin-bottom:0;">제품 목록</h1>

	<div id="scroll-fix-header"></div>
	<h3 class="page-header scroll_fixed" style="z-index:110; width:100%; position:relative;">
		<a href="/admin/item/form"><button type="button" name="list" class="btn btn-dark btn-ssm" style="position:absolute; bottom:10px; right:0; padding-left:20px; padding-right:20px; " />신규 등록</button></a>
	</h3>



	<h2 style="position:relative;">
		카테고리 선택
	</h2>
	<div class="o_cate_wrap ">

		<!-- 선택 카테고리 idx -->
		<input type="hidden" name="cate_idx" id="cate_idx" class="o_input" value="<?php echo isset($row->cate_idx) ? $row->cate_idx : '' ?>" /><!-- 선택 카테고리 idx -->
		<!-- ajax 용 -->
		<input type="hidden" name="cate1" id="cate1" class="o_input" value="<?php echo isset($row_cate->pcate1) ? $row_cate->pcate1 : $combo_cate[1] ?>" /><!-- 1차 선택 카테고리 idx -->
		<input type="hidden" name="cate2" id="cate2" class="o_input" value="<?php echo isset($row_cate->pcate2) ? $row_cate->pcate2 : $combo_cate[2] ?>" /><!-- 2차 선택 카테고리 idx -->
		<input type="hidden" name="cate3" id="cate3" class="o_input" value="<?php echo isset($row_cate->pcate3) ? $row_cate->pcate3 : $combo_cate[3] ?>" /><!-- 3차 선택 카테고리 idx -->
		<input type="hidden" name="cate4" id="cate4" class="o_input" value="<?php echo isset($row_cate->pcate4) ? $row_cate->pcate4 : $combo_cate[4] ?>" /><!-- 4차 선택 카테고리 idx -->


		<div id="category_sect" style="<?php echo (isset($idx) && '' != $idx) ? 'display:none;' : '' ?>">

			<table style="width:100%;" cellpadding="0" cellspacing="0">
			<colgroup>
			  <col width="25%" />
			  <col width="25%" />
			  <col width="25%" />
			  <col width="25%" />
			</colgroup>
			<thead>
			  <tr>
				<th>1차</th>
				<th>2차</th>
				<th>3차</th>
				<th>4차</th>
			  </tr>
			</thead>
			<tbody>
			  <tr>
				<td>
					<!-- <select name="combo_cate1" id="combo_cate1" class="o_selectbox" style="width:100%;"  onchange="select_nextcate(this.value,1,this);">
					  <option value='all'>전체</option>
					  <?php foreach($result_cate1['qry'] as $i => $o) { ?>
					  <option value="<?php echo $o->idx ?>"><?php echo $o->name ?></option>
					  <?php } ?>
					</select> -->
					<?php echo form_dropdown('combo_cate1', $combo_cate1_options, $selected_combo_cate1, '  onchange="select_nextcate(this.value,1,this);"  class="form-control  o_combo_category"'); ?>
				</td>
				<td>
					<div id="wrap_cate2">
						<?php 
						if($result_cate2['total_count'] > 0) {
							echo form_dropdown('combo_cate2', $combo_cate2_options, $selected_combo_cate2, '  onchange="select_nextcate(this.value,2,this);"  class="form-control  o_combo_category"');
						}
						?>
					</div>
				</td>
				<td>
					<div id="wrap_cate3">
						<?php
						if($result_cate3['total_count'] > 0) {
							echo form_dropdown('combo_cate3', $combo_cate3_options, $selected_combo_cate3, '  onchange="select_nextcate(this.value,3,this);"  class="form-control  o_combo_category"');
						}
						?>
					</div>
				</td>
				<td>
					<div id="wrap_cate4">
						<?php 
						if($result_cate4['total_count'] > 0) {
							echo form_dropdown('combo_cate4', $combo_cate4_options, $selected_combo_cate4, '  onchange="select_nextcate(this.value,4,this);"  class="form-control  o_combo_category"');
						}
						?>
					</div>
				</td>
			  </tr>
			</tbody>
			</table>

		</div>

	</div>





	<?php echo form_open($this->uri->uri_string(), array('id'=>'search_form','name'=>'search_form', 'method'=>'get')); ?>
	<div class="o_cate_wrap ">
		<h2>제품 검색</h2>

		<div class="panel panel-default-flat">
		  <div class="panel-heading">
			<div style="display:inline-block; ">
				<?php echo form_dropdown('sfl', $search_select_options, $searched_field, 'class="o_selectbox"'); ?>
				<?php echo form_input($search_text); ?>
				<?php echo form_submit('search', '검색', 'class="btn btn-dark btn-xs o_btn" style=""'); ?>
			</div>
		  </div>
		</div>
	</div>
	<?php echo form_close(); ?>





	<div id="item_list" class="o_item_wrap">
		<h2 style="position:relative;border:none;">
			<span style="position:relative; float:left;">제품 목록</span>
			
			<div style="position:relative; float:left; margin-left:25px;">
				검색 <span style="color:red;font-weight:bold;"><?php echo $result['total_count'] ?></span> 개 / 전체 <span style="color:red;font-weight:bold;"><?php echo $item_total_cnt ?></span> 개
			</div>
			<hr style="clear:both; margin-top:5px; margin-bottom:0; border:none; height:0;" />
		</h2>


		<table style="width:100%;" cellpadding="0" cellspacing="0">
		<colgroup>
		  <col width="120px" />
		  <col width="110px" />
		  <col />
		  <col />
		  <col />
		  <col />
		  <col />
		  <col width="120px" />
		</colgroup>
		<thead>
		  <tr>
			<th>이미지</th>
			<th>제품코드</th>
			<th>제품명</th>
			<th>간단설명</th>
			<th>정렬</th>
			<th>메인</th>
			<th>조회</th>
			<th>관리</th>
		  </tr>
		</thead>
		<tbody>
		<?php foreach($result['qry'] as $i => $o) { ?>
		  <tr>
			<td><img src="<?php echo $o->thumb1 ?>" style="width:100%;" /></td>
			<td><?php echo $o->itm_code ?></td>
			<td>
				<div style="color:gray;"><?php echo $o->cate_text ?></div>
				<a href="/admin/item/form/<?php echo $o->idx?>" style="padding-top:5px; font-size:15px; font-weight:bold;"><?php echo $o->itm_title ?></a>
			</td>
			<td><div style="max-width:500px;"><?php echo $o->itm_subtitle ?></div></td>
			<td class="text-center"><input type="text" id="itm_order_<?php echo $o->idx; ?>" class="o_input text-center itm_order_chg" value="<?php echo $o->itm_order; ?>" style="width:40px;" data-order_saved="<?php echo $o->itm_order?>" data-idx="<?php echo $o->idx?>" /></td>
			<td class="text-center"><?php echo ($o->itm_main_dsp > 0) ? 'Y' : ''; ?></td>
			<td class="text-center"><?php echo $o->itm_view_cnt; ?></td>
			<td class="text-center vertical-middle">
				<a href="/admin/item/form/<?php echo $o->idx?>"><button class="btn btn-xss btn-dark">수정</button></a>
				<a href="/admin/item/del_item/<?php echo $o->idx?>" onclick="del_item(<?php echo $o->idx ?>); return false;"><button class="btn btn-xss btn-danger">삭제</button></a>
			</td>
		  </tr>
		<?php } ?>
		</tbody>
		</table>

	</div>


	<div style="text-align:center;"><?php echo $paging ?></div>


	<script type="text/javascript">

	/* - - - - - -  - - -  - - -  - - -  - - -  - - -  - - -  - - -  - - -  - - -  - - -  - - -  - - - 
	 * 카테고리 선택시 하위 카테고리 신규 등록 가능 전환 및 목록 노출
	 * - - - - - -  - - -  - - -  - - -  - - -  - - -  - - -  - - -  - - -  - - -  - - -  - - -  - - - */

		function select_nextcate(idx, depth, obj) {
			
			// 클릭한 메뉴 선택 표시
			$('.input_cate'+depth).removeClass('active');
			$(obj).addClass('active');

			// 선택 카테고리 인덱스 값
			$('#cate'+depth).val(idx);
			$('#cate_idx').val(idx);
			
			// 선택한 메뉴보다 하위의 부모카테고리 값들은 초기화
			var ino=depth+1;
			for(pno=ino;pno<=4;pno++) {
				$('#pcate'+pno).val('');
				$('#btn_reg_cate'+pno).attr('name','ready');
				$('#btn_reg_cate'+pno).removeClass('btn-dark').addClass('btn-light-dark'); // 버튼 색

				$('#reg_cate'+pno).removeClass('active'); // input bg
				$('#reg_cate'+pno).attr('readonly',true); // input readonly
				$('#wrap_cate'+pno).html('');
			}

			// 하위 카테고리 신규등록 가능 전환
			$('#reg_cate'+ino).addClass('active'); // input bg
			$('#reg_cate'+ino).attr('readonly',false); // input readonly
			$('#btn_reg_cate'+ino).removeClass('btn-light-dark').addClass('btn-dark'); // 버튼 색
			$('#btn_reg_cate'+ino).attr('name',''); // 버튼 명

			//reg_cate2

			if('' == idx && depth > 1){

				var cidx_all = $('#cate'+(depth-1)).val();
				location.href = "/admin/item/lists/?cidx="+cidx_all+"&depth="+depth;

			}
			else {
				location.href = "/admin/item/lists/?cidx="+idx+"&depth="+depth;
			}

			// 하위 카테고리 목록 노출
			//fn_list_next_cate(idx,depth);
		}


		function fn_list_next_cate(pidx,depth) {

			//  console.log(pidx+'/'+depth);
			var child_depth = depth + 1;

			// #wrap_cate
			var wrap_cate_id = 'wrap_cate'+child_depth;

			var request = $.ajax({
			  url: "/trans/fn_select_next_cate",
			  method: "POST",
			  data: { 'pidx':pidx,'depth':depth},
			  dataType: "html"
			});

			request.done(function( res ) {
			  //console.log(res);
			  $('#'+wrap_cate_id).html(res);
			   
			});

			request.fail(function( jqXHR, textStatus ) {
			  alert( "Request failed: " + textStatus );
			  return false;
			});

		}

		// 제품 삭제
		function del_item(itm_idx) {
			if( confirm('제품을 삭제하시겠습니까?\n삭제된 제품과 이미지 및 파일은 복구할 수 없습니다.')) {
				location.href="/admin/item/del_item/"+itm_idx;
			}
		}

	</script>


	<script type="text/javascript">
	$(document).ready(function(){

		// 제품 정렬 순서 변경
		$('.itm_order_chg').on('keyup blur', function(){

			var obj = $(this);
			var itm_idx = obj.data('idx');
			var itm_order_saved = obj.data('order_saved');
			var itm_order = obj.val();

			if(itm_order_saved != itm_order && itm_order != '') {

				var request = $.ajax({
				  url: "/trans/item_order_chage",
				  method: "POST",
				  data: { 'itm_idx':itm_idx,'itm_order':itm_order},
				  dataType: "html"
				});

				request.done(function( res ) {
				  //console.log(res);
				  if(res == 'succ') {
					obj.addClass('bg_trans_red');
					setTimeout(function() { obj.removeClass('bg_trans_red').addClass('bg_trans_white'); }, 1000);
				  }
				});

				request.fail(function( jqXHR, textStatus ) {
				  alert( "Request failed: " + textStatus );
				  return false;
				});

			}
		});

	});
	</script>
