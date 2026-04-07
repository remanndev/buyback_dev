<h1>카테고리 관리</h1>

<!-- <h2>카테고리 목록</h2> -->

<div class="o_cate_wrap" style="width:100%; min-width:980px; max-width:1800px;">
	
	<!-- 2차 이후 부모 카테고리 값들 --> 
	<input type="hidden" id="pcate1" class="o_input" />
	<input type="hidden" id="pcate2" class="o_input" />
	<input type="hidden" id="pcate3" class="o_input" />
	<input type="hidden" id="pcate4" class="o_input" />

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
	  <tr>
		<td><input type="text" id="reg_cate1" class="reg_cate_input o_input active" data-depth="1" /> <button id="btn_reg_cate1" class="btn btn-xss btn-dark reg_cate" data-pno="" data-ready="">등록</button></td>
		<td><input type="text" id="reg_cate2" class="reg_cate_input o_input" data-depth="2" readonly /> <button id="btn_reg_cate2" class="btn btn-xss btn-secondary reg_cate" data-pno="1" data-ready="ready">등록</button></td>
		<td><input type="text" id="reg_cate3" class="reg_cate_input o_input" data-depth="3" readonly /> <button id="btn_reg_cate3" class="btn btn-xss btn-secondary reg_cate" data-pno="2" data-ready="ready">등록</button></td>
		<td><input type="text" id="reg_cate4" class="reg_cate_input o_input" data-depth="4" readonly /> <button id="btn_reg_cate4" class="btn btn-xss btn-secondary reg_cate" data-pno="3" data-ready="ready">등록</button></td>
	  </tr>
	</thead>
	<tbody>
	  <tr>
		<td>
		  <ul id="sortable1" class="sortable">
			<?php foreach($result_cate1['qry'] as $i => $row) { ?>
				<li id="cate_wrap_<?php echo $row->idx?>" class="item_box input_cate1 cate1_<?php echo ($i+1)?>" onclick="ready_nextcate(<?php echo $row->idx?>,<?php echo $row->depth?>,this);">
					<input type="text" id="cate_idx_<?php echo $row->idx?>" name="" value="<?php echo $row->name ?>" class="o_input"  />
					<input type="text" id="cate_order_<?php echo $row->idx?>" name="" value="<?php echo $row->order?>" class="o_input" style="width:34px;">
					<button type="button" class="btn btn-secondary btn-xss" style="z-index:100;" onclick="edit_cate(<?php echo $row->idx?>);">수정</button>
					<button type="button" class="btn btn-danger btn-xss" style="z-index:100;" onclick="del_cate(<?php echo $row->idx?>);">삭제</button>
				</li>
			<?php } ?>
		  </ul>
		</td>
		<td>
		  <div id="wrap_cate2">
			<!-- 영상감시장치 계약 ☞ -->
		  </div>
		</td>
		<td>
		  <div id="wrap_cate3">
			<!-- 카메라 ☞ -->
		  </div>
		</td>
		<td>
		  <div id="wrap_cate4">
		  </div>
		</td>
	  </tr>
	</tbody>
	</table>
</div>


<script type="text/javascript">

	/* - - - - - -  - - -  - - -  - - -  - - -  - - -  - - -  - - -  - - -  - - -  - - -  - - -  - - - 
	 * 카테고리 신규 등록
	 * - - - - - -  - - -  - - -  - - -  - - -  - - -  - - -  - - -  - - -  - - -  - - -  - - -  - - - */
	$(document).ready(function(){

		$('.reg_cate').on('click',function() {

			var obj = $(this);
			var ready = obj.data('ready');
			var pno = obj.data('pno');

			if('ready' == ready) {
				alert(pno+'차 카테고리를 먼저 선택해주세요.');
			}
			else {
				// 신규 카테고리 등록
				var reg = $(this).prev();
				var cate_depth = reg.data('depth'); // 1,2,3,4 (1차,2차,3차,4차메뉴)
				var cate_name = reg.val();  // 카테고리명

				if('' != cate_name) {

					var pcate1 = $('#pcate1').val();  // 2차메뉴용
					var pcate2 = $('#pcate2').val();  // 3차메뉴용
					var pcate3 = $('#pcate3').val();  // 4차메뉴용
					//var pcate4 = $('#pcate4').val();

					item_reg_cate(cate_name,cate_depth,pcate1,pcate2,pcate3);
				}
				else {
					alert('카테고리명을 입력하세요.');
				}
			}

		});

		function item_reg_cate(cate_name,cate_depth,pcate1,pcate2,pcate3) {

			//console.log(cate_name+'/'+cate_depth+'/'+pcate1+'/'+pcate2+'/'+pcate3); 
			if('' != cate_name) {

				var request = $.ajax({
				  url: "/trans/item_reg_cate",
				  method: "POST",
				  data: { 'cate_name':cate_name,'cate_depth':cate_depth, 'pcate1':pcate1,'pcate2':pcate2,'pcate3':pcate3},
				  dataType: "html"
				});

				request.done(function( res ) {
					//console.log(res);
					$('#sortable'+cate_depth).append(res);
					$('.reg_cate_input').val('');
				});

				request.fail(function( jqXHR, textStatus ) {
				  alert( "Request failed: " + textStatus );
				  return false;
				});

			}

		}

	});


	/* - - - - - -  - - -  - - -  - - -  - - -  - - -  - - -  - - -  - - -  - - -  - - -  - - -  - - - 
	 * 카테고리 선택시 하위 카테고리 신규 등록 가능 전환 및 목록 노출
	 * - - - - - -  - - -  - - -  - - -  - - -  - - -  - - -  - - -  - - -  - - -  - - -  - - -  - - - */

		function ready_nextcate(idx, depth, obj) {
			
			// 클릭한 메뉴 선택 표시
			$('.input_cate'+depth).removeClass('active');
			$(obj).addClass('active');

			// 하위 카테고리를 위한 부모카테고리 인덱스 값
			$('#pcate'+depth).val(idx);
			
			// 선택한 메뉴보다 하위의 부모카테고리 값들은 초기화
			var ino=depth+1;
			for(pno=ino;pno<=4;pno++) {
				$('#pcate'+pno).val('');
				//$('#btn_reg_cate'+pno).attr('name','ready');
				$('#btn_reg_cate'+pno).data('ready','ready');
				$('#btn_reg_cate'+pno).removeClass('btn-dark').addClass('btn-secondary'); // 버튼 색

				$('#reg_cate'+pno).removeClass('active'); // input bg
				$('#reg_cate'+pno).attr('readonly',true); // input readonly
				$('#wrap_cate'+pno).html('');
			}

			// 하위 카테고리 신규등록 가능 전환
			$('#reg_cate'+ino).addClass('active'); // input bg
			$('#reg_cate'+ino).attr('readonly',false); // input readonly
			$('#btn_reg_cate'+ino).removeClass('btn-secondary').addClass('btn-dark'); // 버튼 색
			//$('#btn_reg_cate'+ino).attr('name',''); // 버튼 명
			$('#btn_reg_cate'+ino).data('ready',''); // 버튼 명

			// 하위 카테고리 목록 노출
			item_list_child_cate(idx,depth);
		}

		function item_list_child_cate(pidx,depth) {

			var child_depth = depth + 1;

			// #wrap_cate
			var wrap_cate_id = 'wrap_cate'+child_depth;

			var request = $.ajax({
			  url: "/trans/item_list_child_cate",
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


	/* - - - - - -  - - -  - - -  - - -  - - -  - - -  - - -  - - -  - - -  - - -  - - -  - - -  - - - 
	 * 수정
	 * - - - - - -  - - -  - - -  - - -  - - -  - - -  - - -  - - -  - - -  - - -  - - -  - - -  - - - */
		function edit_cate(idx) {

			var cate_id = 'cate_idx_'+idx;
			var cate_val = $('#'+cate_id).val();

			var cate_order_id = 'cate_order_'+idx;
			var cate_order_val = $('#'+cate_order_id).val();

			var request = $.ajax({
			  url: "/trans/item_edit_cate",
			  method: "POST",
			  data: { 'cate_idx':idx,'cate_val':cate_val,'cate_order':cate_order_val},
			  dataType: "html"
			});

			request.done(function( res ) {
			  //console.log(res);
			  if('true' == res) {
				alert('수정이 완료되었습니다.');
			  }
			   
			});

			request.fail(function( jqXHR, textStatus ) {
			  alert( "Request failed: " + textStatus );
			  return false;
			});

		}


	/* - - - - - -  - - -  - - -  - - -  - - -  - - -  - - -  - - -  - - -  - - -  - - -  - - -  - - - 
	 * 삭제
	 * - - - - - -  - - -  - - -  - - -  - - -  - - -  - - -  - - -  - - -  - - -  - - -  - - -  - - - */
		function del_cate(idx) {

			if(confirm('정말 삭제하시겠습니까?')) {

				var request = $.ajax({
				  url: "/trans/item_del_cate",
				  method: "POST",
				  data: { 'cate_idx':idx},
				  dataType: "html"
				});

				request.done(function( res ) {
				  if('remain_category' == res) {
					  alert('하위 카테고리가 남아 있습니다.\n하위 카테고리가 없을 때, 삭제 가능합니다.');
				  }
				  else if('remain_item' == res) {
					  alert('해당 카테고리에 제품이 남아 있습니다.\n제품이 없을 때, 삭제 가능합니다.');
				  }
				  else {
					  $('#cate_wrap_'+idx).remove();
					  alert('카테고리가 삭제되었습니다.');
				  }
				   
				});

				request.fail(function( jqXHR, textStatus ) {
				  alert( "Request failed: " + textStatus );
				  return false;
				});

			}
		}

	/* - - - - - -  - - -  - - -  - - -  - - -  - - -  - - -  - - -  - - -  - - -  - - -  - - -  - - - 
	 * 아이템 순서 조정 
	 * - - - - - -  - - -  - - -  - - -  - - -  - - -  - - -  - - -  - - -  - - -  - - -  - - -  - - - */
		function reorder_list() {
			$(".item_box").each(function(i, box) {
				$(box).find(".item_num").html(i + 1);
			});
		}


</script>
