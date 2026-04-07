<?php
// 링크
	// 메인메뉴 추가
	$link_add_main_nav = '/admin/contents/cms/form/00000/write';
	// 하위(서브)메뉴 추가
	$link_add_sub_nav = '/admin/contents/cms/form/'.$page_code.'/write';
	// 삭제 
	$link_del_nav = '/admin/contents/cms/form/'.$page_code.'/del';

// 페이지 구분 selectbox

	$page_type = (isset($cms_row->page_type) && '' != $cms_row->page_type) ? $cms_row->page_type : '';
	$page_flag = (isset($cms_row->page_flag) && '' != $cms_row->page_flag) ? $cms_row->page_flag : '';

	/*
		<select class="o_selectbox" id="page_type" name="page_type">
		<option value="">* 페이지 타입을 선택해주세요.</option>
		  <option value="link">링크</option>
		  <option value="boardpage">게시판</option>
		  <option value="htmlpage">HTML 페이지</option>
		  <option value="ctntpage">컨텐츠 페이지</option>
		  <option value="landpage">랜딩 페이지</option>
		</select>
	*/
	$page_type_select_options = array(
		''=>'* 페이지 타입을 선택해주세요.',
		'link' => '링크',
		'boardpage' => '게시판',
		'htmlpage' => 'HTML 페이지',
		'ctntpage' => '컨텐츠 페이지',
		'landpage' => '랜딩 페이지',
	);
	$page_type_selected = ($this->input->post('page_type')) ? $this->input->post('page_type') : (isset($page_type) ? $page_type : '');


	$arr_ctntpage = array();
	$arr_landpage = array();

?>

<script type="text/javascript">
<!--
	/** - - - - - - - - - - - - - - - - - - - - - - - - - - -
	 | 메뉴 세팅
	 */

	var arr_cms = <?php echo json_encode($cms_result) ?>;
	var cms_cnt = arr_cms['total_count'];
	var cms_list = arr_cms['qry'];
	//console.log(cms_cnt);

	if(cms_cnt > 0) 
	{

		// dTree 초기 세팅
		d = new dTree('d');
		// dTree root 
		d.add(0,-1,'홈','/admin/contents/cms');
		// dTree 반복문
		for(i=0;i<cms_cnt;i++) {
			// 리스트 
			cms = cms_list[i];
			// 내용
			depth = cms['depth'];
			folder = cms['folder'];
			pageCode = cms['page_code'];
			parentCode = ('00000' == cms['parent_code']) ? '' : cms['parent_code'];
			menuName = cms['menu_name'];
			menuTitle = cms['menu_name'];
			pageUrl = '/admin/contents/cms/form/'+pageCode;

			use = cms['use_yn'];
			className = (use != 'Y') ? 'dtree_use_no' : '';


			// dtree 적용
			//d.add(pageCode,parentCode,menuName,pageUrl);
			//d.add(pageCode,parentCode,menuName,className,pageUrl,menuTitle);

			if(folder == 'AUTO') {
				d.add(pageCode,parentCode,menuName,className,pageUrl,menuTitle);
			}
			else if(folder == 'Y') {
				d.add(pageCode,parentCode,menuName,className,pageUrl,menuTitle,'','/assets/lib/dtree/img/folder.gif');
			}
			else {
				//d.add(pageCode,parentCode,menuName,pageUrl,'','','/assets/lib/dtree/img/page.gif');
				//d.add(pageCode,parentCode,menuName,pageUrl,'','','/assets/lib/dtree/img/empty.gif');
				d.add(pageCode,parentCode,menuName,className,pageUrl,menuTitle,'','/assets/lib/dtree/img/empty_w1.png');
			}
		}

	}

	/*
		d.add(1,0,'Node 1','example01.html');
		d.add(2,0,'Node 2','example01.html');
		d.add(3,1,'Node 1.1','example01.html');
		d.add(4,0,'Node 3','example01.html');
		d.add(5,3,'Node 1.1.1','example01.html');
		d.add(6,5,'Node 1.1.1.1','example01.html');
		d.add(7,0,'Node 4','example01.html');
		d.add(8,1,'Node 1.2','example01.html');
		d.add(9,0,'My Pictures','example01.html','Pictures I\'ve taken over the years','','/assets/lib/dtree/img/imgfolder.gif');
		d.add(10,9,'The trip to Iceland','example01.html','Pictures of Gullfoss and Geysir');
		d.add(11,9,'Mom\'s birthday','example01.html');
		d.add(12,0,'Recycle Bin','example01.html','','','/assets/lib/dtree/img/trash.gif');

		//document.write(d);
	*/

//-->
</script>
<script type="text/javascript">
<!--
$(document).ready(function(){

	/** - - - - - - - - - - - - - - - - - - - - - - - - - - -
	 | 좌측 dtree 선택시, 우측 타이틀 앞에 이미지 설정
	 | 좌측 선택 해제
	 */
	var page_code = '<?php echo isset($page_code) ? $page_code : "00000"; ?>';
	//console.log(page_code);
	
	// 좌측 선택
	$('.nodeSel').removeClass('nodeSel').addClass('node');
	$('.dtree').find('[href="/admin/contents/cms/form/'+page_code+'"]').removeClass('node').addClass('nodeSel');


	//console.log(nodeSelIconSrc);
	if('00000' != page_code && '' != page_code) {

		// 메뉴를 신규 등록했을 때, 신규 페이지 선택
		// var bo_title = $this.find("option:selected").data("title");

		// 좌측 선택 해제
		//$('.nodeSel').removeClass('nodeSel').addClass('node');
		//$('.dtree').find('[href="/admin/contents/cms/form/'+page_code+'"]').removeClass('node').addClass('nodeSel');

		// 좌측 dtree 선택시, 우측 타이틀 앞에 이미지 설정
		var nodeSelIconSrc = $('.nodeSel').prev().attr('src');
		$('#sel_dtree_icon').html('<img src="'+nodeSelIconSrc+'" style="margin-bottom:2px;" />');
	}
	else {
		// 좌측 선택 해제
		//$('.nodeSel').removeClass('nodeSel').addClass('node');
	}





	/** - - - - - - - - - - - - - - - - - - - - - - - - - - -
	 | 고유한 페이지코드 수정하기ㅏ
	 */
	// 사용 가능한지 여부 확인
	$('#page_code_edit').on('keyup blur', function(){

			var new_code = $(this).val();
			//console.log(new_code);
			//console.log(page_code);

			var request = $.ajax({
			  url: "/trans/page_code_edit/chk",
			  method: "POST",
			  data: { 'page_code':page_code,'new_code':new_code},
			  dataType: "html"
			});

			request.done(function( res ) {
			  console.log(res);
			  //$('#'+wrap_cate_id).html(res);
			   
				var err = '';
				var msg = '';

				if(res == 'exist-child') {
					err = '하위 메뉴가 존재합니다. 하위메뉴를 삭제하시면 수정이 가능합니다.';
				}
				else if(res == 'used') {
					err = '현재 사용중이거나, 과거에 사용했던 페이지 코드입니다.';
				}
				else if(res == 'able') {
					msg = '사용 가능합니다.';
				}

				/*
				if(err != ''){
					$('#err_page_code').text(err);
				}
				else {
					$('#err_page_code').text('');
				}
				*/
				$('#err_page_code').text(err);
				$('#msg_page_code').text(msg);


			});

			request.fail(function( jqXHR, textStatus ) {
			  alert( "Request failed: " + textStatus );
			  return false;
			});

	});


	$('#page_code_edit_btn').on('click', function(){
		$('.dsp_page_code').hide();
		$('#page_code_wrap').css('display','inline-block').show();
	});

	// 사용가능하면 수정 처리
	$('#page_code_save_btn').on('click', function(){

			//$('#page_code_edit_btn').hide();

			var new_code = $('#page_code_edit').val();
			//console.log(new_code);
			//console.log(page_code);

			var request = $.ajax({
			  url: "/trans/page_code_edit/save",
			  method: "POST",
			  data: { 'page_code':page_code,'new_code':new_code},
			  dataType: "html"
			});

			request.done(function( res ) {
			  console.log(res);
			  //$('#'+wrap_cate_id).html(res);
				var err = '';
				var msg = '';

				if(res == 'exist-child') {
					err = '하위 메뉴가 존재합니다. 하위메뉴를 삭제하시면 수정이 가능합니다!';
				}
				else if(res == 'used') {
					err = '현재 사용중이거나, 과거에 사용했던 페이지 코드입니다!';
				}
				else if(res == 'self') {
					err = '현재 사용중인 페이지 코드입니다!';
				}
				/*
				else if(res == 'succ') {
					msg = '수정이 완료되었습니다!';
					setTimeout(function(){ location.href = '/admin/contents/cms/form/'+new_code; },400);
					
				}
				*/
				else {
					msg = '수정이 완료되었습니다!';
					new_code = res;
					setTimeout(function(){ location.href = '/admin/contents/cms/form/'+new_code; },400);
				}

				/*
				if(err != ''){
					$('#err_page_code').text(err);
				}
				else {
					$('#err_page_code').text('');
				}
				*/

				$('#err_page_code').text(err);
				$('#msg_page_code').text(msg);

			});

			request.fail(function( jqXHR, textStatus ) {
			  alert( "Request failed: " + textStatus );
			  return false;
			});

	});




	/** - - - - - - - - - - - - - - - - - - - - - - - - - - -
	 | 페이지 구분 선택시 타입에 따라 콤보박스 노출
	 */
	$('#page_type').on('change', function(){
		var page_type = $(this).val();

		// 모든 콤보 박스 초기화
		//$('.page_combo option:eq(0)').prop("selected", true); //첫번째 option 선택
		$('#list_boardpage option:eq(0)').prop("selected", true); //첫번째 option 선택
		$('#list_htmlpage option:eq(0)').prop("selected", true); //첫번째 option 선택
		$('#list_ctntpage option:eq(0)').prop("selected", true); //첫번째 option 선택
		$('#list_landpage option:eq(0)').prop("selected", true); //첫번째 option 선택

		$('.page_combo').hide();
		$('.page_desc').hide();
		$('#page_url').val('');

		//$('#menu_name').val('').focus();
		$('#menu_name').focus();

		if(page_type == 'link') {
			//$('#page_url').focus();
			$('#desc_link').show();
		}
		else {
			$('#list_'+page_type).css('display','inline-block');

		}
	});


	/** - - - - - - - - - - - - - - - - - - - - - - - - - - -
	 | 페이지타입 선택시 url 적용
	 */
	$('.page_combo').on('change', function(){

		$this = $(this);

		var page_type = $this.attr('name');
		var page_val = $this.val();
		var page_url = '';
		//var base_url = '<?php //echo base_url() ?>';
		var base_url = '/';

		var menu_title = '';
		var page_title = '';
		var page_title_uri = '';


		if(page_type == 'boardpage') {
			//page_url = ('' != page_val) ? base_url +'board/'+ page_val : '';
			//page_url = ('' != page_val) ? base_url +'B/'+ page_val : '';

			var bo_title = $this.find("option:selected").data("title");

			if( '' == $('#menu_name').val() ) {
				$('#menu_name').val(bo_title);
			}
			if( '' == $('#input_page_title').val() ) {
				$('#input_page_title').val(bo_title);
			}

			menu_title = $('#menu_name').val();
			page_title = $('#input_page_title').val();
			page_title_uri = page_title.replaceAll(' ','-');
			page_title_uri = page_title_uri.replaceAll('.','');

			//page_url = ('' != page_val) ? base_url +'B/'+ page_val : '';
			//page_url = ('' != page_val) ? base_url +'B/'+ page_code + '/' + page_val : '';
			page_url = ('' != page_val) ? base_url +'B/'+ page_code + '/' + page_title_uri : '';

			/*
			menu_title = $('#menu_name').val();
			menu_title_uri = menu_title.replaceAll(' ','-');
			menu_title_uri = menu_title_uri.replaceAll('.','');
			page_url = ('' != page_val) ? base_url +'B/'+ page_val + '/' + menu_title_uri : '';
			*/
		}
		else if(page_type == 'htmlpage') {
			//page_url = ('' != page_val) ? base_url +'page/'+ page_val : '';
			//page_url = ('' != page_val) ? base_url +'H/'+ page_code + '/' + page_val : '';
			
			//console.log( page_val );
			//$('#menu_name').val(page_val);
			//$('#input_page_title').val(page_val);

			if( '' == $('#menu_name').val() ) {
				$('#menu_name').val(page_val);
			}
			if( '' == $('#input_page_title').val() ) {
				$('#input_page_title').val(page_val);
			}


			menu_title = $('#menu_name').val();
			page_title = $('#input_page_title').val();
			page_title_uri = page_title.replaceAll(' ','-');
			page_title_uri = page_title_uri.replaceAll('.','');

			//page_url = ('' != page_val) ? base_url +'H/'+ page_code + '/' + page_val + '/' + menu_title_uri : '';
			page_url = ('' != page_val) ? base_url +'H/'+ page_code + '/' + page_title_uri : '';
		}
		else if(page_type == 'ctntpage') {
			var ctntpage_title = $this.find("option:selected").data("title");

			//$('#menu_name').val(ctntpage_title);
			//$('#input_page_title').val(ctntpage_title);

			if( '' == $('#menu_name').val() ) {
				$('#menu_name').val(ctntpage_title);
			}
			if( '' == $('#input_page_title').val() ) {
				$('#input_page_title').val(ctntpage_title);
			}

			//page_url = ('' != page_val) ? base_url +'cpage/'+ page_val : '';

			//var title_uri = page_title.replaceAll(' ','-');
			//title_uri = title_uri.replaceAll('.','');
			// page_url = ('' != page_val) ? base_url +'C/'+ page_code + '/' + title_uri : '';

			menu_title = $('#menu_name').val();
			page_title = $('#input_page_title').val();
			page_title_uri = page_title.replaceAll(' ','-');
			page_title_uri = page_title_uri.replaceAll('.','');

			//page_url = ('' != page_val) ? base_url +'C/'+ page_code + '/' + page_val + '/' + menu_title_uri : '';
			page_url = ('' != page_val) ? base_url +'C/'+ page_code + '/' + page_title_uri : '';
		}
		else if(page_type == 'landpage') {
			var landing_title = $this.find("option:selected").data("title");
			//$('#menu_name').val(landing_title);
			//$('#input_page_title').val(landing_title);

			if( '' == $('#menu_name').val() ) {
				$('#menu_name').val(landing_title);
			}
			if( '' == $('#input_page_title').val() ) {
				$('#input_page_title').val(landing_title);
			}

			//page_url = ('' != page_val) ? base_url +'landing/'+ page_val : '';

			//var title_uri = landing_title.replaceAll(' ','-');
			//title_uri = title_uri.replaceAll('.','');
			//page_url = ('' != page_val) ? base_url +'L/'+ page_code + '/' + title_uri : '';

			menu_title = $('#menu_name').val();
			page_title = $('#input_page_title').val();
			page_title_uri = page_title.replaceAll(' ','-');
			page_title_uri = page_title_uri.replaceAll('.','');

			//page_url = ('' != page_val) ? base_url +'L/'+ page_code + '/' + page_val + '/' + menu_title_uri : '';
			page_url = ('' != page_val) ? base_url +'L/'+ page_code + '/' + page_title_uri : '';
		}
		
		$('#page_url').val(page_url);
		//$('#menu_name').focus();
		$('#input_page_title').focus();

	});




	/** - - - - - - - - - - - - - - - - - - - - - - - - - - -
	 | 메뉴명 변경시 url 적용
	 */
	/*
	$('#menu_name').on('keyup blur', function(){

		$this = $(this);

		//console.log($this.val());

		menu_title = $this.val().trim();
		menu_title_uri = menu_title.replaceAll(' ','-');
		menu_title_uri = menu_title_uri.replaceAll('.','');

		var page_url = $('#page_url').val();
		var arr_url = page_url.split("/");

		/*
		console.log(page_url);
		console.log('[0]' + arr_url[0]);
		console.log('[1]' + arr_url[1]);
		console.log('[2]' + arr_url[2]);
		console.log('[3]' + arr_url[3]);
		console.log('[4]' + arr_url[4]);

		[0]
		[1]H
		[2]P0002
		[3]about
		[4]about-company
		* /

		var edit_url = '';
		if(arr_url[1] == 'B' || arr_url[1] == 'board') {
			//edit_url = '/B/'+ arr_url[2] +'/'+ arr_url[3] +'/'+ menu_title_uri;
			edit_url = '/B/'+ arr_url[2] +'/'+ menu_title_uri;
		}
		else if(arr_url[1] == 'H') {
			//edit_url = '/'+ arr_url[1] +'/'+ arr_url[2] +'/'+ arr_url[3] +'/'+ menu_title_uri;
			edit_url = '/'+ arr_url[1] +'/'+ arr_url[2] +'/'+ menu_title_uri;
		}
		else if(arr_url[1] == 'C') {
			//edit_url = '/'+ arr_url[1] +'/'+ arr_url[2] +'/'+ arr_url[3] +'/'+ menu_title_uri;
			edit_url = '/'+ arr_url[1] +'/'+ arr_url[2] +'/'+ menu_title_uri;
		}
		else if(arr_url[1] == 'L') {
			edit_url = '/'+ arr_url[1] +'/'+ arr_url[2] +'/'+ menu_title_uri;
		}

		if('' != edit_url) {
			$('#page_url').val(edit_url);
		}

	});
	*/



	/** - - - - - - - - - - - - - - - - - - - - - - - - - - -
	 | 메뉴명 변경시 url 적용
	 */
	$('#input_page_title').on('keyup blur', function(){

		$this = $(this);

		//console.log($this.val());

		page_title = $this.val().trim();
		page_title_uri = page_title.replaceAll(' ','-');
		page_title_uri = page_title_uri.replaceAll('.','');

		var page_url = $('#page_url').val();
		var arr_url = page_url.split("/");

		/*
		console.log(page_url);
		console.log('[0]' + arr_url[0]);
		console.log('[1]' + arr_url[1]);
		console.log('[2]' + arr_url[2]);
		console.log('[3]' + arr_url[3]);
		console.log('[4]' + arr_url[4]);

		[0]
		[1]H
		[2]P0002
		[3]about
		[4]about-company
		*/

		var edit_url = '';
		if(arr_url[1] == 'B' || arr_url[1] == 'board') {
			//edit_url = '/B/'+ arr_url[2] +'/'+ arr_url[3] +'/'+ page_title_uri;
			edit_url = '/B/'+ arr_url[2] +'/'+ page_title_uri;
		}
		else if(arr_url[1] == 'H') {
			//edit_url = '/'+ arr_url[1] +'/'+ arr_url[2] +'/'+ arr_url[3] +'/'+ page_title_uri;
			edit_url = '/'+ arr_url[1] +'/'+ arr_url[2] +'/'+ page_title_uri;
		}
		else if(arr_url[1] == 'C') {
			//edit_url = '/'+ arr_url[1] +'/'+ arr_url[2] +'/'+ arr_url[3] +'/'+ page_title_uri;
			edit_url = '/'+ arr_url[1] +'/'+ arr_url[2] +'/'+ page_title_uri;
		}
		else if(arr_url[1] == 'L') {
			edit_url = '/'+ arr_url[1] +'/'+ arr_url[2] +'/'+ page_title_uri;
		}

		if('' != edit_url) {
			$('#page_url').val(edit_url);
		}

	});



});

function del_page(page_code) {
	if( confirm('정말 삭제하시겠습니까?\n하위메뉴가 있는 경우, 삭제되지 않습니다.') ) {
		if('' != page_code) {
			$('#command').val('del');
			$('#btn_submit').trigger('click');
		}
	}
}
//-->
</script>

<div class="admin_wrap">
	<h1>
		CMS 관리
		<a href="<?php echo $link_add_main_nav ?>" class="btn btn-xs btn-dark" style="position:absolute; margin-left:10px;">* 메인메뉴 추가</a>
	</h1>

	<div style="position:relative; width:100%; overflow:hidden;">

		<div style="position:absolute; top:0; left:170px; z-index:999;">
			<a href="javascript: d.openAll();" class="btn btn-xxs btn-primary">전체열기</a>
			<a href="javascript: d.closeAll();" class="btn btn-xxs btn-primary">전체닫기</a>
		</div>
		<div style="position:absolute; top:0; left:290px; width:1px; height:100%; border-right:1px dashed gray; background-color:#fff;"></div>
			<aside style="position:relative; width:280px; overflow:auto; display:inline-block;">
				<script type="text/javascript">
				<!--
					if(cms_cnt > 0) {
						// dtree 메뉴 출력
						document.write(d);
					}
				//-->
				</script>
			</aside>

			<article style="width:calc(100% - 290px); min-height:100%; display:inline-block; float:right; padding-top:0; padding-left:20px; border-left:1px dashed gray;">
				<dl style="display:block; font-size:16px; vertical-align:baseline; margin:0;    padding:0 15px; background-color:#efefef;line-height:54px;">
				  <?php if('00000' == $page_code && $command == 'write') { // 메인 메뉴 생성 ?>
					<dt style="display:inline-block;"><span id="sel_dtree_icon"><img src="/assets/lib/dtree/img/base.gif" /></span> ▶ 메인메뉴 추가</dt>
					<dd style="display:inline-block; font-size:14px; margin-bottom:0;"></dd>
				  <?php } elseif('' != $page_code && $command == 'write') { // 서브메뉴 생성 ?>
					<dt style="display:inline-block;"><span id="sel_dtree_icon"></span><?php echo isset($cms_row->menu_name) ? $cms_row->menu_name : ''; ?></dt>
					<dd style="display:inline-block; font-size:14px; margin-bottom:0;"> ▶ 하위메뉴 추가</dd>
				  <?php } elseif('' != $page_code) { // cms 확인 및 수정 페이지  ?>
					<dt style="display:inline-block; "><span id="sel_dtree_icon"></span><?php echo isset($cms_row->menu_name) ? $cms_row->menu_name : ''; ?></dt>
					<dd style="display:inline-block; font-size:14px; margin-bottom:0;">
						<a href="<?php echo $link_add_sub_nav ?>" class="btn btn-xs btn-dark" style="margin-bottom:5px;">하위메뉴 추가</a>
						<a href="<?php echo $link_del_nav ?>" onclick="del_page('<?php echo $page_code; ?>'); return false;" class="btn btn-xs btn-danger" style="margin-bottom:5px;">삭제</a>
					</dd>
				  <?php } ?>
				</dl>

				<?php if('' != $page_code) { ?>

				<!-- <form name="form" method="POST" action="<?php echo base_url() ?>admin/contents/cms/proc" style="width:100%;"> -->
				<?php echo form_open($this->uri->uri_string(), array('id'=>'cms_form','name'=>'cms_form')); ?>
					<input type="hidden" name="parent_code" value="<?php echo (isset($cms_row->page_code) && '' != $cms_row->page_code) ? $cms_row->page_code : '00000';?>" title="상위코드" readonly />
					<input type="hidden" name="page_code" value="<?php echo (isset($cms_row->page_code) && '' != $cms_row->page_code) ? $cms_row->page_code : '00000';?>" title="페이지코드" readonly />
					<input type="hidden" name="depth" value="<?php echo (isset($cms_row->depth) && '' != $cms_row->depth) ? $cms_row->depth : 0; ?>" title="메뉴차수" readonly />
					<input type="hidden" id="command" name="command" value="<?php echo (isset($command) && '' != $command) ? $command : 'edit'; ?>" readonly />

					<?php //echo validation_errors('<div class="err_color_red">', '</div>'); ?>

					<h2 style="margin-top:15px;">기본 정보</h2>
					<div class="tbl_classic_view">
						<table>
							<colgroup>
								<col style="width: 130px;" />
								<col />
							</colgroup>
							<tbody>
								<tr>
									<th><span>LOCATION</span></th>
									<td><?php echo $location_info ?></td>
								</tr>
								<tr>
									<th><span>page code</span></th>
									<td>
										<span class="dsp_page_code"><?php echo ($command != 'write' && $page_code != '00000' && $page_code != '') ? $page_code : ''; ?></span>

										<?php if($command != 'write') { ?>
										<div id="page_code_wrap" style="display:none;">
											<input type="text" id="page_code_edit" value="<?php echo (isset($cms_row->page_code) && '' != $cms_row->page_code) ? $cms_row->page_code : '';?>" title="페이지코드 수정" class="o_input" style="width:220px;" />
											<button id="page_code_save_btn" type="button" class="btn btn-xs btn-dark">저장</button>
											<div id="err_page_code" class="err_color_red"></div>
											<div id="msg_page_code" class="err_color_green"></div>
										</div>
										<button id="page_code_edit_btn" type="button" class="btn btn-xs btn-secondary dsp_page_code">수정</button>
										<?php } ?>
									</td>
								</tr>

								<tr>
									<th><span class="reqfield">페이지 구분</span></th>
									<td>
										<?php echo form_dropdown('page_type', $page_type_select_options, $page_type_selected, 'id="page_type" class="o_selectbox" style="width:220px;"'); ?>
										
										<select class="o_selectbox page_combo" id="list_boardpage" name="boardpage" style="display: <?php echo ($page_type == 'boardpage') ? 'inline-block' : 'none' ?>;">
										<option value="">* 게시판을 선택해주세요.</option>
										<?php foreach($boards_result['qry'] as $key => $bbs) { ?>
										  <option value="<?php echo $bbs->bo_code ?>" data-title="<?php echo $bbs->bo_title ?>" <?php echo ($page_flag==$bbs->bo_code) ? 'selected' : ''; ?> >[<?php echo $bbs->gr_title ?>] <?php echo $bbs->bo_title ?></option>
										<?php } ?>
										</select>

										<select class="o_selectbox page_combo" id="list_htmlpage" name="htmlpage" style="display: <?php echo ($page_type == 'htmlpage') ? 'inline-block' : 'none' ?>;">
										<option value="">* HTML 페이지를 선택해주세요.</option>
										<?php foreach($arr_htmlpage as $key => $page_val) { ?>
										  <option value="<?php echo $key ?>" <?php echo ($page_flag==$key) ? 'selected' : ''; ?> ><?php echo $page_val ?></option>
										<?php } ?>
										</select>

										<select class="o_selectbox page_combo" id="list_ctntpage" name="ctntpage" style="display: <?php echo ($page_type == 'ctntpage') ? 'inline-block' : 'none' ?>;">
										<option value="">* 컨텐츠 페이지를 선택해주세요.</option>
										<?php foreach($contents_result['qry'] as $key => $ctnt) { ?>
										  <option value="<?php echo $ctnt->idx ?>" data-title="<?php echo $ctnt->page_title ?>" <?php echo ($page_flag==$ctnt->idx) ? 'selected' : ''; ?> ><?php echo $ctnt->page_title ?></option>
										<?php } ?>
										</select>

										<select class="o_selectbox page_combo" id="list_landpage" name="landpage" style="display: <?php echo ($page_type == 'landpage') ? 'inline-block' : 'none' ?>;">
										<option value="">* 랜딩 페이지를 선택해주세요.</option>
										<?php foreach($landing_result['qry'] as $key => $land) { ?>
										  <option value="<?php echo $land->idx ?>" data-title="<?php echo $land->title ?>" <?php echo ($page_flag==$land->idx) ? 'selected' : ''; ?> ><?php echo $land->title ?></option>
										<?php } ?>
										</select>

										<div><?php echo form_error('page_type','<div class="err_color_red">','</div>'); ?></div>
									</td>
								</tr>

								<tr>
									<th><span class="reqfield">메뉴명</span></th>
									<td>
										<input type="text" id="menu_name" name="menu_name" value="<?php echo set_value('menu_name',(isset($cms_row->menu_name) ? $cms_row->menu_name : '')); ?>" class="required o_input w_90" title="메뉴명을 입력하세요."/>
										<?php echo form_error('menu_name','<div class="err_color_red">','</div>'); ?>
									</td>
								</tr>
								<tr id="page_title">
									<th><span class="reqfield">브라우저 타이틀</span></th>
									<td>
										<small class="page_seo_desc">브라우저 타이틀에 노출되며, URL 뒤에 추가되어 SEO 최적화에 활용됩니다.</small>
										<input type="text" id="input_page_title" name="page_title" value="<?php echo set_value('page_title',(isset($cms_row->page_title) ? $cms_row->page_title : '')); ?>" class="required o_input w_90" title="페이지 타이틀을 입력하세요."/>
										<?php echo form_error('page_title','<div class="err_color_red">','</div>'); ?>
									</td>
								</tr>

								<tr>
									<th><span class="reqfield">페이지 URL</span></th>
									<td>
										<small id="desc_link" class="page_desc" style="display: <?php echo ($page_type == 'link') ? 'block' : ''; ?>">도메인을 포함한 url 링크 전체를 입력해주세요. (<?php echo base_url() ?>~)</small>
										<input type="text" id="page_url" name="page_url" value="<?php echo set_value('page_url',(isset($cms_row->page_url) ? $cms_row->page_url : '')); ?>" class="o_input w_90" style="font-family:verdana;" />
										<?php echo form_error('page_url','<div class="err_color_red">','</div>'); ?>
									</td>
								</tr>
							</tbody>
						</table>
					</div>



					<h2 title="검색엔진최적화(SEO : search engine optimization)">
						SEO 관리
						<small style="font-weight:400;"><a href="https://developers.google.com/search/docs/beginner/seo-starter-guide?hl=ko" target="_blank">참고</a></small>
					</h2>
					<div class="tbl_classic_view">
						<table>
							<colgroup>
								<col style="width: 120px;" />
								<col />
							</colgroup>
							<tbody>

								<tr id="meta_keyword">
									<th><span>페이지 키워드<br />(keyword)</span></th>
									<td>
										<small class="page_seo_desc">콤마(,)로 구분해서 입력해주세요.</small>
										<input type="text" name="meta_keyword" value="<?php echo set_value('meta_keyword',(isset($cms_row->meta_keyword) ? $cms_row->meta_keyword : '')); ?>" class="required o_input w_90" title="페이지 키워드를 입력하세요."/>
										<?php echo form_error('meta_keyword','<div class="err_color_red">','</div>'); ?>
									</td>
								</tr>
								<tr id="meta_description">
									<th>
										<span class="">페이지 설명<br />(description)</span>
										<!-- html 페이지에서 사용하면 될 듯 -->
										<!-- <?php if(isset($cms_row->page_code) && '000000' != $cms_row->page_code) { ?>
										<button type="button" id="btn_parsing" class="btn btn-xs btn-default-flat" style="margin-top:10px;" title="<?php echo (isset($cms_row->page_url) ? $cms_row->page_url : '') ?>">읽어오기</button>
										<?php } ?> -->
									</th>
									<td>
										<small class="page_seo_desc">구글 등의 검색결과에 노출될 간단한 페이지 설명을 입력해주세요.</small>
										<textarea name="meta_description" rows="4" value="" class="o_textarea w_90" title="페이지 설명을 입력하세요."><?php echo set_value('meta_description',(isset($cms_row->meta_description) ? $cms_row->meta_description : '')); ?></textarea>

										<?php //echo form_error('meta_description','<div class="err_color_red">','</div>'); ?>
									</td>
								</tr>
								<tr id="og_title">
									<th>og:title</th>
									<td>
										<input type="text" name="og_title" value="<?php echo set_value('og_title',(isset($cms_row->og_title) ? $cms_row->og_title : '')); ?>" class="o_input w_90"/>
										<?php echo form_error('og_title','<div class="err_color_red">','</div>'); ?>
									</td>
								</tr>
								<tr id="og_description">
									<th>og:description</th>
									<td>
										<input type="text" name="og_description" value="<?php echo set_value('og_description',(isset($cms_row->og_description) ? $cms_row->og_description : '')); ?>" class="o_input w_90"/>
										<?php echo form_error('og_description','<div class="err_color_red">','</div>'); ?>
									</td>
								</tr>
								<tr id="og_image">
									<th>og:image</th>
									<td>
										<input type="text" name="og_image" value="<?php echo set_value('og_image',(isset($cms_row->og_image) ? $cms_row->og_image : '')); ?>" class="o_input w_90"/>
										<?php echo form_error('og_image','<div class="err_color_red">','</div>'); ?>
									</td>
								</tr>
								<tr id="og_url" style="display:none;">
									<th>og:url</th>
									<td>
										<input type="text" name="og_url" value="<?php echo set_value('og_url',(isset($cms_row->og_url) ? $cms_row->og_url : '')); ?>" class="o_input w_90"/>
										<?php echo form_error('og_url','<div class="err_color_red">','</div>'); ?>
									</td>
								</tr>
							</tbody>
						</table>
					</div>



					<h2>메뉴 관리</h2>
					<div class="tbl_classic_view">
						<table>
							<colgroup>
								<col style="width: 120px;" />
								<col />
							</colgroup>
							<tbody>
								<tr>
									<th><span class="reqfield">순번</span></th>
									<td>
										<input type="text" name="order" value="<?php echo set_value('order',(isset($cms_row->order) ? $cms_row->order : '')); ?>" class="required o_input w_10" title="순번을 입력하세요."/>
										<?php echo form_error('order','<div class="err_color_red">','</div>'); ?>
									</td>
								</tr>
								<tr>
									<th><span class="reqfield">사용여부</span></th>
									<td>
										<input type="radio" id="use_Y" name="use_yn" value="Y"  <?php echo set_radio('use_yn', 'Y', (! isset($cms_row->use_yn) OR (isset($cms_row->use_yn) && 'Y' == $cms_row->use_yn)) ? TRUE : FALSE); ?>> <label for="use_Y">사용</label>
										<input type="radio" id="use_N" name="use_yn" value="N"  <?php echo set_radio('use_yn', 'N', (isset($cms_row->use_yn) && 'N' == $cms_row->use_yn) ? TRUE : FALSE); ?>> <label for="use_N">사용 안함</label>
										<?php echo form_error('use_yn','<div class="err_color_red">','</div>'); ?>
									</td>
								</tr>
								<tr>
									<th><span class="reqfield">폴더사용</span></th>
									<td>
										<input type="radio" id="folder_AUTO" name="folder" value="AUTO"  <?php echo set_radio('folder', 'AUTO', (! isset($cms_row->folder) OR (isset($cms_row->folder) && 'AUTO' == $cms_row->folder)) ? TRUE : FALSE); ?>> <label for="folder_AUTO">자동 적용</label>
										<input type="radio" id="folder_Y" name="folder" value="Y"  <?php echo set_radio('folder', 'Y', (isset($cms_row->folder) && 'Y' == $cms_row->folder) ? TRUE : FALSE); ?>> <label for="folder_Y">사용</label>
										<input type="radio" id="folder_N" name="folder" value="N"  <?php echo set_radio('folder', 'N', (isset($cms_row->folder) && 'N' == $cms_row->folder) ? TRUE : FALSE); ?>> <label for="folder_N">사용 안함</label>

										<small style="font-size:12px; color:gray;">(하위 메뉴가 있는 경우는 폴더 자동 적용)</small>
										<?php echo form_error('folder','<div class="err_color_red">','</div>'); ?>
									</td>
								</tr>

							</tbody>
						</table>
					</div>



					<h2 style="display:none;">페이지 디자인</h2>
					<div class="tbl_classic_view" style="display:none;">
						<table>
							<colgroup>
								<col style="width: 120px;" />
								<col />
							</colgroup>
							<tbody>
								<tr>
									<th><span class="reqfield">헤더</span></th>
									<td>
										<input type="radio" id="layout_header_default" name="layout_header" value="default"  <?php echo set_radio('layout_header', 'default', (isset($cms_row->layout_header) && 'default' == $cms_row->layout_header) ? TRUE : (! isset($cms_row->layout_header)?TRUE:FALSE)); ?>> <label for="layout_header_default">DEFAULT</label>

										<input type="radio" id="layout_header_dark" name="layout_header" value="dark"  <?php echo set_radio('layout_header', 'dark', (isset($cms_row->layout_header) && 'dark' == $cms_row->layout_header) ? TRUE : FALSE); ?>> <label for="layout_header_dark">DARK</label>

										<input type="radio" id="layout_header_light" name="layout_header" value="light"  <?php echo set_radio('layout_header', 'light', (isset($cms_row->layout_header) && 'light' == $cms_row->layout_header) ? TRUE : FALSE); ?>> <label for="layout_header_light">LIGHT</label>

										<?php echo form_error('layout_header','<div class="err_color_red">','</div>'); ?>
									</td>
								</tr>
								<tr>
									<th><span class="reqfield">푸터</span></th>
									<td>
										<input type="radio" id="layout_footer_default" name="layout_footer" value="default"  <?php echo set_radio('layout_footer', 'default', (isset($cms_row->layout_footer) && 'default' == $cms_row->layout_footer) ? TRUE : (! isset($cms_row->layout_footer)?TRUE:FALSE)); ?>> <label for="layout_footer_default">DEFAULT</label>

										<input type="radio" id="layout_footer_dark" name="layout_footer" value="dark"  <?php echo set_radio('layout_footer', 'dark', (isset($cms_row->layout_footer) && 'dark' == $cms_row->layout_footer) ? TRUE : FALSE); ?>> <label for="layout_footer_dark">DARK</label>

										<input type="radio" id="layout_footer_light" name="layout_footer" value="light"  <?php echo set_radio('layout_footer', 'light', (isset($cms_row->layout_footer) && 'light' == $cms_row->layout_footer) ? TRUE : FALSE); ?>> <label for="layout_footer_light">LIGHT</label>

										<?php echo form_error('layout_footer','<div class="err_color_red">','</div>'); ?>
									</td>
								</tr>
							</tbody>
						</table>
					</div>


					
					<div class="buttonBox" style="width:100%; margin:50px auto 30px; text-align:center;">
						<hr style="margin-bottom:50px; " />
						<input type="submit" name="submit" id="btn_submit" class="btn btn-dark btn-sm" value="확인" style="margin:0 auto;"/>
					</div>

				</form>

				<?php } ?>
			

			</article>

		</div>



	</div>


</div>
