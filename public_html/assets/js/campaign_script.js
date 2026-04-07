
/* - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - */
/* 캠페인 만들기 # 목표기기 추가 */
	$(document).ready(function() {

		$('#btn_add_goal').on('click', function(){
			html = $('#add_goal_sample').html();
			html = '<dd class="box_goal_wrap">'+html+'</dd>';
			//console.log(html);
			cnt = $('.box_goal_wrap').length;
			//console.log(cnt);
			if( cnt < 5 ) {
				$('#wrap_goal_device').append(html);
			}
			else {
				alert('최대 5개까지 등록 가능합니다.');
			}
		});
	});


	function remove_goalbox(_this){
		$(_this).parents('.box_goal_wrap').remove();
	};



/* - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - */
/* 캠페인 상세 - 코멘트 */

	$(document).ready(function() {
		$('#btn_comment').click(function(){
			var cmt_idx = false;
			cmp_cmt_write(cmt_idx,'write');
		});
	});

	// 코멘트 신규
	function cmp_cmt_write(cmt_idx,cmt_mode) {
		
		var cmp_idx = $('#cmp_idx').val();
		var cmt_content = $('#cmt_content').val();
		if('update' == cmt_mode) {
			// 수정
			cmt_content = $('#cmt_content_'+cmt_idx).val();
		}
		else if('reply' == cmt_mode) {
			// 답변
			cmt_content = $('#reply_content_'+cmt_idx).val();
		}
		else {
			// 신규
			cmt_mode='write';
		}

		if( '' == cmt_content ) {
			alert('코멘트를 입력해주세요.');
		}
		else {

			$.ajax({
				  type: "POST",
				  url: "/trans/campaign/comment/"+cmt_mode+"/"+cmp_idx,
				  data: { 
					  'cmt_content': cmt_content,
					  'cmt_idx': cmt_idx
				  }
			}).done(function( res ) {
				  //alert("Data Loaded: " + res);
				  console.log(res);
				  //location.replace('<?php echo current_url() ?>');
				  //location.href = '<?php echo current_url() ?>';

				  if('not_logged_in' == res) {
					alert('로그인을 먼저 해주세요!');
				  }
				  else {

					// 새로고침
					location.reload();
				  }

			}).fail(function(error) {

				  //console.log(error);

				  //alert( "access error.." );
			}); // 맨 마지막에 세미콜론(;)

		}
	}

	// 코멘트 삭제
	function cmt_del(cmt_idx) {

		if( confirm('코멘트를 삭제하시겠습니까?\n확인을 누르시면 해당 코멘트가 완전히 삭제됩니다.') ) {
			$.ajax({
				type: "POST",
				url: "/trans/campaign/comment/del/"+cmt_idx,
				data: { 
					'cmt_idx': cmt_idx
				}
			}).done(function( res ) {

				if('not_logged_in' == res) {
					alert('로그인을 먼저 해주세요!');
				}
				else if('not_owner' == res) {
					alert('작성자만 삭제하실 수 있습니다!');
				}
				else if('exist_reply' == res) {
					alert('답글이 달린 댓글은 삭제하실 수 없습니다!');
				}
				else {
					//$('#cmt_layer_'+cmt_idx).remove();

					// 새로고침
					location.reload();
				}
			}).fail(function(error) {
				//console.log(error);
				//alert( "access error.." );
			}); // 맨 마지막에 세미콜론(;)
		}

	}

	// 코멘트 수정버튼 클릭
	function cmt_edit_view(cmt_idx) {
		$('#view_cmt_'+cmt_idx).hide();
		$('#edit_cmt_'+cmt_idx).show();
	}

	// 코멘트 댓글버튼 클릭
	function cmt_reply_view(cmt_idx) {
		$('#reply_cmt_'+cmt_idx).show();
	}







/* - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - */
/* 캠페인 상세 - 캠페인 모금 소식 */

	$(document).ready(function() {
		$('#btn_cmpnews').click(function(){
			var cmpnews_idx = false;
			var cmp_idx = $(this).data('cmpidx');
			var cmp_code = $(this).data('cmpcode');
			cmpnews_write('write',cmpnews_idx,cmp_idx,cmp_code);
		});
	});


	// 모금 소식 작성/수정
	//function cmp_cmt_write(cmt_idx,cmt_mode) {
	function cmpnews_write(mode=false,cmpnews_idx=false,cmp_idx=false,cmp_code=false) {
		
		//var cmp_idx = $('#cmp_idx').val();
		//console.log( cmp_idx );

		/*
		console.log( mode );
		console.log( cmpnews_idx );
		console.log( cmp_idx );
		console.log( cmp_code );

		return false;
		*/

		var cmpnews_content = $('#cmpnews_content').val();
		if('update' == mode) {
			// 수정
			cmpnews_content = $('#cmpnews_content_'+cmpnews_idx).val();
		}
		else if('reply' == mode) {
			// 답변
			cmpnews_content = $('#reply_content_'+cmpnews_idx).val();
		}
		else {
			// 신규
			mode='write';
		}

		if( '' == cmpnews_content ) {
			alert('모금 소식을 입력해주세요.');
		}
		else {

			$.ajax({
				  type: "POST",
				  url: "/trans/campaign/cmpnews/"+mode+"/"+cmp_idx,
				  data: { 
					  'cmp_code': cmp_code,
					  'cmpnews_content': cmpnews_content,
					  'cmpnews_idx': cmpnews_idx
				  }
			}).done(function( res ) {
				  //alert("Data Loaded: " + res);
				  console.log(res);
				  //location.replace('<?php echo current_url() ?>');
				  //location.href = '<?php echo current_url() ?>';

				  if('not_logged_in' == res) {
					alert('로그인을 먼저 해주세요!');
				  }
				  else {

					// 새로고침
					location.reload();
				  }

			}).fail(function(error) {

				  //console.log(error);

				  //alert( "access error.." );
			}); // 맨 마지막에 세미콜론(;)

		}
	}

	// 모금소식 삭제
	function cmpnews_del(cmpnews_idx) {

		if( confirm('모금소식을 삭제하시겠습니까?\n확인을 누르시면 해당 모금소식이 완전히 삭제됩니다.') ) {
			$.ajax({
				type: "POST",
				url: "/trans/campaign/cmpnews/del/"+cmpnews_idx,
				data: { 
					'cmpnews_idx': cmpnews_idx
				}
			}).done(function( res ) {

				if('not_logged_in' == res) {
					alert('로그인을 먼저 해주세요!');
				}
				else if('not_owner' == res) {
					alert('작성자만 삭제하실 수 있습니다!');
				}
				else {
					//$('#cmt_layer_'+cmpnews_idx).remove();

					// 새로고침
					location.reload();
				}
			}).fail(function(error) {
				//console.log(error);
				//alert( "access error.." );
			}); // 맨 마지막에 세미콜론(;)
		}

	}

	// 코멘트 수정버튼 클릭
	function cmpnews_edit_view(cmpnews_idx) {
		$('#view_cmpnews_'+cmpnews_idx).hide();
		$('#edit_cmpnews_'+cmpnews_idx).show();
	}
