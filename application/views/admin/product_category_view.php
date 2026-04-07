<link href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css" rel="stylesheet" type="text/css" />
<style>
</style>

<script type="text/javascript" src="https://code.jquery.com/ui/1.12.1/jquery-ui.js" ></script>
<script type="text/javascript">
//<![CDATA[
	/** 아이템을 등록한다. */
	function submitItem() {
		if(!validateItem()) {
			return;
		}
		alert("등록");
	}

	/** 아이템 체크 */
	function validateItem() {
		var items = $("input[type='text'][name='item']");
		if(items.length == 0) {
			alert("작성된 아이템이 없습니다.");
			return false;
		}

		var flag = true;
		for(var i = 0; i < items.length; i++) {
			if($(items.get(i)).val().trim() == "") {
				flag = false;
				alert("내용을 입력하지 않은 항목이 있습니다.");
				break;
			}
		}

		return flag;
	}

	/** UI 설정 */
	$(function() {
		$("#itemBoxWrap").sortable({
			placeholder:"itemBoxHighlight",
			start: function(event, ui) {
				ui.item.data('start_pos', ui.item.index());
			},
			stop: function(event, ui) {
				var spos = ui.item.data('start_pos');
				var epos = ui.item.index();
					  reorder();
			}
		});
		//$("#itemBoxWrap").disableSelection();
		
		$( "#sortable" ).sortable();
		$( "#sortable" ).disableSelection();
	});

	/** 아이템 순서 조정 */
	function reorder() {
		$(".itemBox").each(function(i, box) {
			$(box).find(".item_num").html(i + 1);
		});
	}

	/** 아이템 추가 */
	function createItem() {
		$(createBox())
		.appendTo("#itemBoxWrap")
		.hover(
			function() {
				$(this).css('backgroundColor', '#f9f9f5');
				$(this).find('.deleteBox').show();
			},
			function() {
				$(this).css('background', 'none');
				$(this).find('.deleteBox').hide();
			}
		)
			.append("<div class='deleteBox'>[삭제]</div>")
			.find(".deleteBox").click(function() {
			var valueCheck = false;
			$(this).parent().find('input').each(function() {
				if($(this).attr("name") != "type" && $(this).val() != '') {
					valueCheck = true;
				}
			});

			if(valueCheck) {
				var delCheck = confirm('입력하신 내용이 있습니다.\n삭제하시겠습니까?');
			}
			if(!valueCheck || delCheck == true) {
				$(this).parent().remove();
				reorder();
			}
		});
		// 숫자를 다시 붙인다.
		reorder();
	}

	/** 아이템 박스 작성 */
	function createBox() {
		var contents = "<div class='itemBox'>"
					 + "<div style='float:left;'>"
					 + "<span class='itemNum'></span> "
					 + "<input type='text' name='item' style='width:300px;'/>"
					 + "</div>"
					 + "</div>";
		return contents;
	}
//]]>
</script>


<h1>카테고리 관리</h1>

<!-- <h2>카테고리 목록</h2> -->


<!-- 
<div>
    <div style="float:left;width:100px;">아이템 추가 : </div>
    <div style="clar:both;">
        <input type="button" id="addItem" value="추가" onclick="createItem();" />
        <input type="button" id="submitItem" value="제출" onclick="submitItem();" />
    </div>
</div>

<br />
<div id="itemBoxWrap"></div>
 -->
<!-- <br />
<ul id="sortable">
  <li class="ui-state-default"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>Item 1</li>
  <li class="ui-state-default"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>Item 2</li>
  <li class="ui-state-default"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>Item 3</li>
  <li class="ui-state-default"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>Item 4</li>
  <li class="ui-state-default"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>Item 5</li>
</ul>
 -->


<div class="o_cate_wrap" >
	
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
		<td><input type="text" id="reg_cate1" class="reg_cate_input o_input active" data-depth="1" /> <button id="btn_reg_cate1" class="btn btn-xss btn-dark reg_cate" name="">등록</button></td>
		<td><input type="text" id="reg_cate2" class="reg_cate_input o_input" data-depth="2" readonly /> <button id="btn_reg_cate2" class="btn btn-xss btn-secondary reg_cate" alt="1" name="ready">등록</button></td>
		<td><input type="text" id="reg_cate3" class="reg_cate_input o_input" data-depth="3" readonly /> <button id="btn_reg_cate3" class="btn btn-xss btn-secondary reg_cate" alt="2" name="ready">등록</button></td>
		<td><input type="text" id="reg_cate4" class="reg_cate_input o_input" data-depth="4" readonly /> <button id="btn_reg_cate4" class="btn btn-xss btn-secondary reg_cate" alt="3" name="ready">등록</button></td>
	  </tr>
	</thead>
	<tbody>
	  <tr>
		<td>
		  <ul id="sortable1" class="sortable">
			<?php foreach($result_cate1['qry'] as $i => $row) { ?>
				<li id="cate_wrap_<?php echo $row->idx?>" class="item_box input_cate1 cate1_<?php echo ($i+1)?>" onclick="ready_nextcate(<?php echo $row->idx?>,<?php echo $row->depth?>,this);">
					<input type="text" id="cate_idx_<?php echo $row->idx?>" name="" value="<?php echo $row->name ?>" class="o_input"  />
					<button type="button" class="btn btn-secondary btn-xss" style="z-index:100;" onclick="edit_cate(<?php echo $row->idx?>);">수정</button>
					<!-- <button type="button" class="btn btn-danger btn-xss" style="z-index:100;" onclick="del_cate(<?php echo $row->idx?>);">삭제</button> -->
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
$(document).ready(function(){


    /*
	$( ".sortable" ).sortable();
    $( ".sortable" ).disableSelection();
	*/

	/*
	$('.sortable').sortable({

		update: function(event, ui) {
			//console.log('update');
			//console.log(ui.item);
			//console.log( $(this).attr('id') );

			$(".item_box").each(function(i, box) {
				$(box).find(".item_num").html(i + 1);
			});
		}
	});

    $( ".sortable" ).disableSelection();
	*/



	


	/* - - - - - -  - - -  - - -  - - -  - - -  - - -  - - -  - - -  - - -  - - -  - - -  - - -  - - - 
	 * 카테고리 신규 등록
	 * - - - - - -  - - -  - - -  - - -  - - -  - - -  - - -  - - -  - - -  - - -  - - -  - - -  - - - */

		$('.reg_cate').on('click',function() {

			var ready = $(this).attr('name');

			if('ready' == ready) {
				pno = $(this).attr('alt');
				alert(pno+'차 카테고리를 먼저 선택해주세요.');

			}
			else {

					// 신규 카테고리 등록
					//var reg = $(this).siblings();
					var reg = $(this).prev();

					//console.log( $(this).attr('id') );  // btn_reg_cate1
					//console.log( reg.attr('id') );  // reg_cate1
					//console.log( reg.data('depth') );  // cate1
					//console.log( reg.val() );  // cate1

					var cate_depth = reg.data('depth'); // 1,2,3,4 (1차,2차,3차,4차메뉴)
					var cate_name = reg.val();  // 카테고리명

					if('' != cate_name) {

						var pcate1 = $('#pcate1').val();  // 2차메뉴용
						var pcate2 = $('#pcate2').val();  // 3차메뉴용
						var pcate3 = $('#pcate3').val();  // 4차메뉴용
						//var pcate4 = $('#pcate4').val();

						//fn_reg_cate(cate_name,cate_depth,pcate1,pcate2,pcate3,pcate4);
						fn_reg_cate(cate_name,cate_depth,pcate1,pcate2,pcate3);
					}
					else {
						alert('카테고리명을 입력하세요.');
					}

			}

		});


		//function fn_reg_cate(cate_name,cate_depth,pcate1,pcate2,pcate3,pcate4) {
		function fn_reg_cate(cate_name,cate_depth,pcate1,pcate2,pcate3) {

			//console.log(cate_name+'/'+cate_depth+'/'+pcate1+'/'+pcate2+'/'+pcate3);

			if('' != cate_name) {

				var request = $.ajax({
				  url: "/trans/fn_reg_cate",
				  method: "POST",
				 // data: { 'cate_name':cate_name,'cate_depth':cate_depth, 'pcate1':pcate1,'pcate2':pcate2,'pcate3':pcate3,'pcate4':pcate4},
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
			//$('.input_cate1').removeClass('active');
			$('.input_cate'+depth).removeClass('active');
			$(obj).addClass('active');

			// 하위 카테고리를 위한 부모카테고리 인덱스 값
			$('#pcate'+depth).val(idx);
			
			// 선택한 메뉴보다 하위의 부모카테고리 값들은 초기화
			var ino=depth+1;
			for(pno=ino;pno<=4;pno++) {
				$('#pcate'+pno).val('');
				$('#btn_reg_cate'+pno).attr('name','ready');
				$('#btn_reg_cate'+pno).removeClass('btn-dark').addClass('btn-secondary'); // 버튼 색

				$('#reg_cate'+pno).removeClass('active'); // input bg
				$('#reg_cate'+pno).attr('readonly',true); // input readonly
				$('#wrap_cate'+pno).html('');
			}

			// 하위 카테고리 신규등록 가능 전환
			$('#reg_cate'+ino).addClass('active'); // input bg
			$('#reg_cate'+ino).attr('readonly',false); // input readonly
			$('#btn_reg_cate'+ino).removeClass('btn-secondary').addClass('btn-dark'); // 버튼 색
			$('#btn_reg_cate'+ino).attr('name',''); // 버튼 명

			//reg_cate2

			// 하위 카테고리 목록 노출
			fn_list_child_cate(idx,depth);
		}


		function fn_list_child_cate(pidx,depth) {

			//  console.log(pidx+'/'+depth);
			var child_depth = depth + 1;

			// #wrap_cate
			var wrap_cate_id = 'wrap_cate'+child_depth;

			var request = $.ajax({
			  url: "/trans/fn_list_child_cate",
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
	 * 수정, 삭제
	 * - - - - - -  - - -  - - -  - - -  - - -  - - -  - - -  - - -  - - -  - - -  - - -  - - -  - - - */
		
		function edit_cate(idx) {

			var cate_id = 'cate_idx_'+idx;
			var cate_val = $('#'+cate_id).val();

			var cate_order_id = 'cate_order_'+idx;
			var cate_order_val = $('#'+cate_order_id).val();

			var request = $.ajax({
			  url: "/trans/fn_edit_cate",
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


		function del_cate(idx) {

			if(confirm('정말 삭제하시겠습니까?')) {

				var request = $.ajax({
				  url: "/trans/fn_del_cate",
				  method: "POST",
				  data: { 'cate_idx':idx},
				  dataType: "html"
				});

				request.done(function( res ) {
				  //console.log(res);
				  $('#cate_wrap_'+idx).remove();
				   
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
