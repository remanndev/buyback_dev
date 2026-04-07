
<style type="text/css">
	/*
	.o_cate_wrap {width:100%; min-width:980px; max-width:1400px; }
	.o_cate_wrap table {width:100%;  border-top:2px solid #333333;  border-bottom:1px solid #cccccc; }
	*/

</style>


<?php echo form_open_multipart($this->uri->uri_string(), array('id'=>'item_form','name'=>'item_form','onsubmit'=>'return chk_form();')); ?>

	<?php //echo validation_errors('<div class="err_color_red">','</div>')?>

	<h1 style="margin-bottom:0;">제품 등록/수정</h1>

	<div id="scroll-fix-header"></div>

	<h3 class="page-header scroll_fixed" style="z-index:110; width:100%; position:relative;">
	  <div style="position:absolute; bottom:10px; right:0;">

		<?php if((isset($idx) && '' != $idx)) { ?>
		<a href="/admin/item/del_item/<?php echo $idx ?>" onclick="del_item(<?php echo $idx ?>); return false;"><input type="button" name="list" class="btn btn-danger btn-ssm" value="삭제" style="float:right; padding-left:20px; padding-right:20px; margin-left:5px; " /></a>
		<?php } ?>

		<input type="submit" name="submit" class="btn btn-dark btn-ssm" value="저장" style="float:right; padding-left:20px; padding-right:20px; margin-left:5px;" />

		<a href="/admin/item/lists"><input type="button" name="list" class="btn btn-dark btn-ssm" value="목록" style="float:right; padding-left:20px; padding-right:20px; " /></a>

	  </div>
	</h3>


	<h2 style="position:relative;">
		카테고리 선택 
		<?php if((isset($idx) && '' != $idx)) { ?><button type="button" class="btn btn-dark btn-xs" style="margin-left:20px; position:absolute; bottom:5px;" onclick="clk_edit_cate(this);">카테고리 수정</button><?php } ?>
	</h2>

	<div class="o_cate_wrap">

		<!-- onload chk -->
		<input type="hidden" id="onload_chk" value="0" />

		<!-- 제품 수정시 제품의 idx -->
		<input type="hidden" name="itm_idx" id="itm_idx" class="o_input" value="<?php echo isset($idx) ? $idx : ''; ?>" /><!-- 선택 카테고리 idx -->
		<!-- 선택 카테고리 idx -->
		<input type="hidden" name="cate_idx" id="cate_idx" class="o_input" value="<?php echo isset($row->cate_idx) ? $row->cate_idx : '' ?>" /><!-- 선택 카테고리 idx -->

		<!-- ajax 용 -->
		<input type="hidden" name="cate1" id="cate1" class="o_input" value="<?php echo isset($row->cate1) ? $row->cate1 : ''?>" alt="1차 선택 카테고리 idx" />
		<input type="hidden" name="cate2" id="cate2" class="o_input" value="<?php echo isset($row->cate2) ? $row->cate2 : ''?>" alt="2차 선택 카테고리 idx" />
		<input type="hidden" name="cate3" id="cate3" class="o_input" value="<?php echo isset($row->cate3) ? $row->cate3 : ''?>" alt="3차 선택 카테고리 idx" />
		<input type="hidden" name="cate4" id="cate4" class="o_input" value="<?php echo isset($row->cate4) ? $row->cate4 : ''?>" alt="4차 선택 카테고리 idx" />

		<!-- <h5><?php echo $cate_text ?></h5> -->
		<?php if((isset($idx) && '' != $idx)) { ?>

		<div class="panel panel-default-flat mt-2">
		  <!-- <div class="panel-heading"><?php echo $cate_text ?></div> -->
		  <div class="panel-body">
			<?php echo $cate_text ?>
		  </div>
		</div>

		<?php } ?>

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
				  <ul id="sdepth1" class="sortable">
					<?php foreach($result_cate1['qry'] as $i => $o) { ?>
						<li id="cate_wrap_<?php echo $o->idx?>" class="item_box input_cate1 cate1_<?php echo ($i+1)?>  <?php echo (isset($row_cate->pcate1) && $o->idx == $row_cate->pcate1) ? 'active' : '' ?>" onclick="ready_nextcate(<?php echo $o->idx?>,<?php echo $o->depth?>,this);">
							<!-- <input type="text" id="cate_idx_<?php echo $o->idx?>" name="" value="<?php echo $o->name ?>" class="o_input"  /> -->
							<span id="cate_idx_<?php echo $o->idx?>" class="o_item_cate_box"><?php echo $o->name ?></span>
						</li>
					<?php } ?>
				  </ul>
				</td>
				<td>
				  <div id="wrap_cate2">
					<ul id="sdepth2" class="sortable">
					<?php
					if( isset($result_cate2['qry']) ) {
					foreach($result_cate2['qry'] as $i => $o) { ?>
						<li id="cate_wrap_<?php echo $o->idx?>" class="item_box input_cate1 cate2_<?php echo ($i+1)?>  <?php //echo ($o->idx == $row_cate->pcate2) ? 'active' : '' ?>" onclick="ready_nextcate(<?php echo $o->idx?>,<?php echo $o->depth?>,this);">
							<!-- <input type="text" id="cate_idx_<?php echo $o->idx?>" name="" value="<?php echo $o->name ?>" class="o_input"  /> -->
							<span id="cate_idx_<?php echo $o->idx?>" class="o_item_cate_box"><?php echo $o->name ?></span>
						</li>
					<?php }} ?>
				  </ul>
				  </div>
				</td>
				<td>
				  <div id="wrap_cate3">
					<!-- cate name ☞ -->
					<ul id="sdepth3" class="sortable">
					<?php
					if( isset($result_cate3['qry']) ) {
					foreach($result_cate3['qry'] as $i => $o) { ?>
						<li id="cate_wrap_<?php echo $o->idx?>" class="item_box input_cate1 cate3_<?php echo ($i+1)?>  <?php //echo ($o->idx == $row_cate->pcate3) ? 'active' : '' ?>" onclick="ready_nextcate(<?php echo $o->idx?>,<?php echo $o->depth?>,this);">
							<!-- <input type="text" id="cate_idx_<?php echo $o->idx?>" name="" value="<?php echo $o->name ?>" class="o_input"  /> -->
							<span id="cate_idx_<?php echo $o->idx?>" class="o_item_cate_box"><?php echo $o->name ?></span>
						</li>
					<?php }} ?>
				  </ul>
				  </div>
				</td>
				<td>
				  <div id="wrap_cate4">
					<ul id="sdepth4" class="sortable">
					<?php 
					if( isset($result_cate4['qry']) ) {
					foreach($result_cate4['qry'] as $i => $o) { ?>
						<li id="cate_wrap_<?php echo $o->idx?>" class="item_box input_cate1 cate4_<?php echo ($i+1)?>  <?php //echo ($o->idx == $row_cate->idx) ? 'active' : '' ?>" onclick="ready_nextcate(<?php echo $o->idx?>,<?php echo $o->depth?>,this);">
							<!-- <input type="text" id="cate_idx_<?php echo $o->idx?>" name="" value="<?php echo $o->name ?>" class="o_input"  /> -->
							<span id="cate_idx_<?php echo $o->idx?>" class="o_item_cate_box"><?php echo $o->name ?></span>
						</li>
					<?php }} ?>
				  </ul>
				  </div>
				</td>
			  </tr>
			</tbody>
			</table>
			
		</div>

		<?php echo form_error('cate_idx','<div class="error">','</div>'); ?>

	</div>


	<div class="o_item_wrap">
		<h2 class="mt-5">기본 정보</h2>
		<div class="tbl_frm">
			<table>
			<colgroup>
			  <col width="200">
			  <col>
			</colgroup>
			<tr>
			  <th>제품 코드</th>
			  <td>
				<?php if((isset($idx) && '' != $idx)) { ?>
					<?php echo $row->itm_code ?>
				<?php } else { ?>
					<input type="text" id="itm_code" class="o_input" name="itm_code" value="<?php echo set_value('itm_code', isset($row->itm_code) ? $row->itm_code : time()) ?>" style="width:200px; " required maxlength="10" />
					<br />
					<small>상품코드는 10자리 숫자로 자동생성되며, 상품코드를 직접 입력할 수도 있습니다.<br />상품코드는 영문자, 숫자, -, _ 만 입력 가능합니다.</small>
				<?php } ?>
			  </td>
			</tr>
			<tr>
			  <th>제품명</th>
			  <td><input type="text" id="itm_title" class="o_input" name="itm_title" value="<?php echo set_value('itm_title', isset($row->itm_title) ? $row->itm_title : '') ?>" style="width:100%; " required /></td>
			</tr>
			<tr>
			  <th>제품명 하단 설명</th>
			  <td>
				<input type="text" id="itm_subtitle" class="o_input" name="itm_subtitle" value="<?php echo set_value('itm_subtitle', isset($row->itm_subtitle) ? $row->itm_subtitle : '') ?>" style="width:100%; " />
				<small>상품명 하단에 상품에 대한 추가적인 설명이 필요한 경우에 입력합니다. </small>
			  </td>
			</tr>
			<tr>
			  <th>제품 정렬순서</th>
			  <td>
				<input type="text" id="itm_order" class="o_input" name="itm_order" value="<?php echo set_value('itm_order', isset($row->itm_order) ? $row->itm_order : 0) ?>" style="width:100px; " required />
				<small>숫자가 작을수록 상위에 출력되며, 입력하지 않으면 자동으로 출력됩니다.</small>
			  </td>
			</tr>

			<tr>
			  <th>제조사</th>
			  <td>
				<input type="text" id="itm_maker" class="o_input" name="itm_maker" value="<?php echo set_value('itm_maker', isset($row->itm_maker) ? $row->itm_maker : '') ?>" style="width:200px; " />
				<!-- <small>입력하지 않으면 상세페이지에 노출되지 않습니다.</small> -->
			  </td>
			</tr>
			<tr>
			  <th>원산지</th>
			  <td>
				<input type="text" id="itm_origin" class="o_input" name="itm_origin" value="<?php echo set_value('itm_origin', isset($row->itm_origin) ? $row->itm_origin : '') ?>" style="width:200px; " />
				<!-- <small>입력하지 않으면 상세페이지에 노출되지 않습니다.</small> -->
			  </td>
			</tr>
			<tr>
			  <th>브랜드</th>
			  <td>
				<input type="text" id="itm_brand" class="o_input" name="itm_brand" value="<?php echo set_value('itm_brand', isset($row->itm_brand) ? $row->itm_brand : '') ?>" style="width:200px; " />
				<!-- <small>입력하지 않으면 상세페이지에 노출되지 않습니다.</small> -->
			  </td>
			</tr>
			<tr>
			  <th>모델</th>
			  <td>
				<input type="text" id="itm_model" class="o_input" name="itm_model" value="<?php echo set_value('itm_model', isset($row->itm_model) ? $row->itm_model : '') ?>" style="width:200px; " />
				<!-- <small>입력하지 않으면 상세페이지에 노출되지 않습니다.</small> -->
			  </td>
			</tr>

			<tr>
			  <th>메인 고정</th>
			  <td>
				<div class="d-inline-block">
					<div class="input-group">
					  <div class="input-group-text">
						<input type="checkbox" name="itm_main_dsp" value="1" id="itm_main_dsp" <?php echo (isset($row->itm_main_dsp) && '1' == $row->itm_main_dsp) ? 'checked' : '' ?> style="vertical-align:middle">
					  </div>
					  <label for="itm_main_dsp" class="input-group-text" style="font-size:13px;background-color:#fff;">메인 고정</label>
					</div>
				</div>
			  </td>
			</tr>

			<tr>
			  <th>관리자 PICK</th>
			  <td>
				<div class="d-inline-block">
					<div class="input-group">
					  <div class="input-group-text">
						<input type="checkbox" name="itm_type_hit" value="1" id="itm_type_hit" <?php echo (isset($row->itm_type_hit) && '1' == $row->itm_type_hit) ? 'checked' : '' ?> style="vertical-align:middle">
					  </div>
					  <label for="itm_type_hit" class="input-group-text" style="font-size:13px;background-color:#fff;"><span class="badge bg-primary">히트</span></label>
					</div>
				</div>
				<div class="d-inline-block">
					<div class="input-group">
					  <div class="input-group-text">
						<input type="checkbox" name="itm_type_pick" value="1" id="itm_type_pick" <?php echo (isset($row->itm_type_pick) && '1' == $row->itm_type_pick) ? 'checked' : '' ?> style="vertical-align:middle">
					  </div>
					  <label for="itm_type_pick" class="input-group-text" style="font-size:13px;background-color:#fff;"><span class="badge bg-info">추천</span></label>
					</div>
				</div>
				<div class="d-inline-block">
					<div class="input-group">
					  <div class="input-group-text">
						<input type="checkbox" name="itm_type_new" value="1" id="itm_type_new" <?php echo (isset($row->itm_type_new) && '1' == $row->itm_type_new) ? 'checked' : '' ?> style="vertical-align:middle">
					  </div>
					  <label for="itm_type_new" class="input-group-text" style="font-size:13px;background-color:#fff;"><span class="badge bg-success">신상품</span></label>
					</div>
				</div>

				<div class="d-inline-block">
					<div class="input-group">
					  <div class="input-group-text">
						<input type="checkbox" name="itm_type_best" value="1" id="itm_type_best" <?php echo (isset($row->itm_type_best) && '1' == $row->itm_type_best) ? 'checked' : '' ?> style="vertical-align:middle">
					  </div>
					  <label for="itm_type_best" class="input-group-text" style="font-size:13px;background-color:#fff;"><span class="badge bg-danger">베스트</span></label>
					</div>
				</div>
				<div class="d-inline-block">
					<div class="input-group">
					  <div class="input-group-text">
						<input type="checkbox" name="itm_type_dc" value="1" id="itm_type_dc" <?php echo (isset($row->itm_type_dc) && '1' == $row->itm_type_dc) ? 'checked' : '' ?> style="vertical-align:middle">
					  </div>
					  <label for="itm_type_dc" class="input-group-text" style="font-size:13px;background-color:#fff;"><span class="badge bg-warning">할인</span></label>
					</div>
				</div>
			  </td>
			</tr>

			<tr>
			  <th>가격</th>
			  <td>
				<input type="text" id="itm_price" class="o_input" name="itm_price" value="<?php echo set_value('itm_price', isset($row->itm_price) ? $row->itm_price : '') ?>" style="width:200px; " />
				<span id="itm_price_comma" style="margin-left:10px;"><?php echo (isset($row->itm_price) ? number_format($row->itm_price) : ''); ?>원</span>
			  </td>
			</tr>

			</table>
		</div>
	</div>


	<div class="o_item_wrap">
		<h2 class="mt-5">제품 이미지</h2>
		<div class="tbl_frm">
			<table>
			<colgroup>
			  <col width="150">
			  <col>
			</colgroup>
			<tr>
			  <th style="vertical-align:top;">

					<div class="o_img_list" style="width:100%;">
						
						<?php
						$n=1;
						foreach($img_list as $i => $o) { ?>
							<div style="margin:5px 0;">
								<div id="pthumb_<?php echo $n ?>" class="choose-file preview_thumb">
									<img src="<?php echo IMG_DIR ?>/icons/icon_btn_del.gif" style="cursor:pointer; position:absolute; top:0; right:0; z-index:10;" title="클릭하시면 삭제됩니다." onclick="delThumbnail(<?php echo $o->file_idx ?>,'<?php echo $o->wr_table?>','<?php echo $o->wr_table_idx?>');" />

									<input type="file" name="attach_file_img[]" id="attach_file_<?php echo $n ?>" class="form-file" onchange="setThumbnail(event,<?php echo $n ?>,<?php echo $o->file_idx;?>);" title="클릭하시면 파일을 선택할 수 있습니다!" />
									<label id="preview_thumb_<?php echo $n ?>" class="preview_img"><img src="<?php echo $o->file_src ?>" /></label>
								</div>
							</div>
						<?php
							$n++;
						} ?>
						<?php
						for($j=$n;$j<=10;$j++) {
						?>
							<div style="margin:5px 0;">
								<div id="pthumb_<?php echo $j ?>" class="choose-file preview_thumb">
									<input type="file" name="attach_file_img[]" id="attach_file_<?php echo $j ?>" class="form-file" onchange="setThumbnail(event,<?php echo $j ?>);" title="클릭하시면 파일을 선택할 수 있습니다!" />
									<label id="preview_thumb_<?php echo $j ?>" class="preview_img"><img src="<?php echo IMG_DIR ?>/common/empty3.png" /></label>
								</div>
							</div>
						<?php } ?>
					</div>

			  </th>
			  <td style="vertical-align:top; padding:15px;">

					<div class="preview_img o_img_view" style="width:100%;">
					<?php if( isset($img_list[0]->file_src )) { ?>
						<img id="preview_big" src="<?php echo $img_list[0]->file_src ?>" style="width:auto; max-width:100%;"/>
					<?php } else { ?>
						<img id="preview_big" src="<?php echo IMG_DIR ?>/common/empty3.png" style="width:auto; max-width:100%;"/>
					<?php } ?>
					</div>


			  </td>
			</tr>
			</table>
		</div>
	</div>


	<h2 class="mt-5">상세 정보</h2>
	<div class="o_cate_wrap" >
		<section class="row">
			<div class="col">
				<textarea id="itm_desc" class="itm_content" name="itm_desc"><?php echo set_value('itm_desc',isset($row->itm_desc) ? $row->itm_desc : '') ?></textarea>
			</div>
		</section>
	</div>

	<h2 class="mt-5">주요 사양</h2>
	<div class="o_cate_wrap" >
		<section class="row">
			<div class="col">
				<textarea id="itm_spec" class="itm_content" name="itm_spec"><?php echo set_value('itm_spec',isset($row->itm_spec) ? $row->itm_spec : '') ?></textarea>
			</div>
		</section>
	</div>

	<h2 class="mt-5">추가 정보</h2>
	<div class="o_cate_wrap" >
		<section class="row">
			<div class="col">
				<textarea id="itm_addinfo" class="itm_content" name="itm_addinfo"><?php echo set_value('itm_addinfo',isset($row->itm_addinfo) ? $row->itm_addinfo : '') ?></textarea>
			</div>
		</section>
	</div>




	<!-- 
	down_no
		1: Manual
		2: Catalog
		3: Specification
		4: Drawing
	-->
	<h2 class="mt-5">
		<span>다운로드 파일 관리</span>
		<!-- <button type="button" id="btn_add_file" class="btn btn-primary btn-xs" style="position:absolute; top:0; right:15px;">파일 추가</button> -->
		<span style="position:relative; display:inline-block; width:80px;"><button type="button" id="btn_add_file" class="btn btn-primary btn-xs" style="position:absolute; bottom:-5px; left:10px;">파일 추가</button> </span>
		<small style="padding-left:0px; color:#ff6600;">최대 20개</small>
		<input type="hidden" id="down_file_cnt" value="<?php echo isset($result_file_form['total_count']) ? $result_file_form['total_count'] : 0; ?>" />
	</h2>
	<div class="o_cate_wrap" >
		<section class="row">
			<div class="col">

				<?php 
				for($i=1;$i<=20;$i++) {
					$display = 'display:none;';
					if(isset($download[$i]->file_download) && $download[$i]->file_download) {
						$display = 'display:block;';
					}
				?>
				<div id="down_file_wrap_<?php echo $i ?>" class="down_file_wrap" style="<?php echo $display ?>">

						<div class="input-group my-1">
						  <span class="input-group-text o_item_file_title"><input type="text" id="input_file_title_<?php echo $i ?>" class="input_file_title" data-no="<?php echo $i ?>" style="width:100%;" name="file_title_<?php echo $i ?>" value="<?php echo isset($download[$i]->file_title) ? $download[$i]->file_title : ''; ?>" autocomplete="off" /></span>
						  <input type="file" name="attach_download_<?php echo $i ?>" id="attach_download_<?php echo $i ?>" class="form-control" style="border-left:none; font-size:13px;" />

						  <!-- 다운로드파일 타이틀 가져오기 -->
						  <span id="list_grp_ttl_<?php echo $i ?>" class="list_grp_ttl" style="position:absolute; left:0; bottom:0; display:none;">
							<ul class="dropdown-ftitle" style="position:absolute; top:0; left:7px; width:136px; z-index:1000;" >
							<?php foreach($list_down_title as $key => $o) { ?>
								<li><button class="btn btn-secondary btn-xs btn-block no-radius down_file_title" type="button" style=" padding:5px 5px 5px 10px; text-align:left;" data-no="<?php echo $i ?>" data-title="<?php echo $o->title ?>"><?php echo $o->title ?></button></li>
							<?php } ?>
							</ul>
						  </span>
						</div>

						<?php if(isset($download[$i]->file_download) && $download[$i]->file_download) { ?>
						  <div style="padding-left:155px;">
							<a href="/files/download/<?php echo $download[$i]->file_download_enc; ?>"><?php echo $download[$i]->file_name_org; ?></a>
							<button type="button" class="o_btn btn btn-danger btn-xs ml-2" style="padding:3px 5px; margin:0;"  onclick="delFile(<?php echo $download[$i]->file_idx ?>,'<?php echo $download[$i]->wr_table?>','<?php echo $download[$i]->wr_table_idx?>');">삭제</button>
						  </div>
						<?php } ?>

				</div>
				<?php } ?>

			</div>
		</section>
		<hr />
	</div>



	<h3 style="z-index:110; width:100%; position:relative; text-align:center; margin:50px auto;">

		<a href="/admin/item/lists"><input type="button" name="list" class="btn btn-dark btn-sm" value="목록" style="padding-left:20px; padding-right:20px; margin:0;" /></a>

		<input type="submit" name="submit" class="btn btn-dark btn-sm" value="저장" style="padding-left:20px; padding-right:20px; margin:0;" />

		<?php if((isset($idx) && '' != $idx)) { ?>
		<a href="/admin/item/del_item/<?php echo $idx ?>" onclick="del_item(<?php echo $idx ?>); return false;"><input type="button" name="list" class="btn btn-danger btn-sm" value="삭제" style="padding-left:20px; padding-right:20px; margin:0; " /></a>
		<?php } ?>

	</h3>




<?php echo form_close(); ?>

<script type="text/javascript">
$(document).ready(function(){

	// 파일 수기입력 타이틀 그룹 불러와서 처리
	$('.input_file_title').on('click',function(){
		var obj = $(this);
		var no = obj.data('no');
		$('#list_grp_ttl_'+no).show();
	});

	$('.down_file_title').on('click',function(){
		var obj = $(this);
		var no = obj.data('no');
		var title = obj.data('title');
		$('#input_file_title_'+no).val(title);
	});

	$('.input_file_title').on('blur',function(){
		var obj = $(this);
		var no = obj.data('no');
		setTimeout(function(){$('#list_grp_ttl_'+no).hide();},200);
	});

	// 파일 추가
	$('#btn_add_file').on('click',function(){
		var file_total = $('#down_file_cnt').val();
		file_total++;
		$('#down_file_wrap_'+file_total).show();
		$('#down_file_cnt').val(file_total);
	});


});
</script>


<script type="text/javascript">

// 제품 삭제
function del_item(itm_idx) {
	if( confirm('제품을 삭제하시겠습니까?\n삭제된 제품과 이미지 및 파일은 복구할 수 없습니다.')) {
		location.href="/admin/item/del_item/"+itm_idx;
	}
}

function delFile(file_idx,wr_table,wr_table_idx){
	//alert(file_idx);
	if( confirm('클릭하신 파일을 삭제하시겠습니까?')) {
		location.href="/admin/item/del_file/"+file_idx+"/"+wr_table+"/"+wr_table_idx+"/<?php echo url_code($this->uri->uri_string(), 'e') ?>";
	}
}


function delThumbnail(file_idx,wr_table,wr_table_idx){
	//alert(file_idx);
	if( confirm('클릭하신 이미지를 삭제하시겠습니까?')) {
		location.href="/admin/item/del_thumbnail/"+file_idx+"/"+wr_table+"/"+wr_table_idx+"/<?php echo url_code($this->uri->uri_string(), 'e') ?>";
	}
}

function setThumbnail(event,no,file_idx=false) { 
	var reader = new FileReader(); 
	reader.onload = function(event) { 
		var img = document.createElement("img");
		img.setAttribute("src", event.target.result);

		//console.log(no);

		if(1==no){
			$('#preview_big').attr('src',event.target.result);
		}
		$('#preview_thumb_'+no).html(img);
		//document.querySelector("div.o_img_view").appendChild(img); 

		// 수정일 때.. 이미지 바로 수정
		//var itm_idx = $('#itm_idx').val();

		//if('' != itm_idx) {
			

			var file_data = $('#attach_file_'+no).prop('files')[0];   
			var form_data = new FormData();                  
			form_data.append('file', file_data);
			//form_data.append('itm_idx', itm_idx); // 제품 인덱스
			form_data.append('file_idx', file_idx); // 파일 인덱스
			form_data.append('no', no);  // 썸네일 이미지 번호
			//alert(form_data);
			$.ajax({
				url: '/files/upload/item_image/<?php echo url_code("item/image","e") ?>/items/<?php echo isset($idx) ? $idx : ''; ?>', // idx : 제품 인덱스
				dataType: 'text',  // what to expect back from the PHP script, if anything
				cache: false,
				contentType: false,
				processData: false,
				data: form_data,                         
				type: 'post',
				success: function(php_script_response){
					//alert(php_script_response); // display response from the PHP script, if any
					//console.log(php_script_response);
				}
			});

		//}

	}; 
	reader.readAsDataURL(event.target.files[0]);
}
</script>

<script type="text/javascript">
	$(document).ready(function(){
		/*

		var onload_chk = 0;

		// 카테고리 선택
		var cate_idx = $('#cate_idx').val();
		var cate1 = $('#cate1').val();
		var cate2 = $('#cate2').val();
		var cate3 = $('#cate3').val();
		var cate4 = $('#cate4').val();

		if('' != cate1) { $("#cate_wrap_"+cate1).trigger("click"); }
		if('' != cate2) { setTimeout(function(){ click_event('cate_wrap_'+cate2) }, 500); }
		if('' != cate3) { setTimeout(function(){ click_event('cate_wrap_'+cate3) }, 1000); }
		//if('' != cate4) { setTimeout(function(){ click_event('cate_wrap_'+cate4) }, 1500); }
		if('' != cate_idx) { setTimeout(function(){ click_event('cate_wrap_'+cate_idx) }, 1500); }

		setTimeout(function(){ $('#onload_chk').val(1); }, 3000); 
		*/


		// 제품 이미지 보기
		$('.preview_thumb').mouseenter(function(){
			var thumb_id = $(this).attr('id');
			var thumb_src = $('#'+thumb_id+' > label > img').attr('src');
			$('#preview_big').attr('src',thumb_src);
			//$('#preview_big').attr('src',event.target.result);
		});



		// 정렬용 가격 콤마 처리
		$('#itm_price').on('keyup keydown blur',function(){
			var itm_price = $(this).val();
			var itm_price_comma = addComma(itm_price);
			itm_price_comma = (itm_price_comma != '') ? addComma(itm_price)+'원' : '';
			//console.log(itm_price_comma);
			$('#itm_price_comma').html(itm_price_comma);

		});

		$('#ord_price').on('keyup keydown blur',function(){
			var ord_price = $(this).val();
			var ord_price_comma = addComma(ord_price)+'원';
			//console.log(ord_price_comma);
			$('#ord_price_comma').html(ord_price_comma);

		});
	});


	function clk_edit_cate(obj) {

		// 카테고리 수정 버튼 클릭 후, 감추기
		obj.style.display = 'none';

		// 초기화
		$('#onload_chk').val(0);
	
		$('#category_sect').show();

		//var onload_chk = 0;

		// 카테고리 선택
		var cate_idx = $('#cate_idx').val();
		var cate1 = $('#cate1').val();
		var cate2 = $('#cate2').val();
		var cate3 = $('#cate3').val();
		var cate4 = $('#cate4').val();

		if('' != cate1) { $("#cate_wrap_"+cate1).trigger("click"); }
		if('' != cate2) { setTimeout(function(){ click_event('cate_wrap_'+cate2) }, 500); }
		if('' != cate3) { setTimeout(function(){ click_event('cate_wrap_'+cate3) }, 1000); }
		//if('' != cate4) { setTimeout(function(){ click_event('cate_wrap_'+cate4) }, 1500); }
		if('' != cate_idx) { setTimeout(function(){ click_event('cate_wrap_'+cate_idx) }, 1500); }

		setTimeout(function(){ $('#onload_chk').val(1); }, 1500); 

	}

	// 폼체크 - 필수 항목 체크
	function chk_form() {

		// 카테고리 체크
		if( '' == $('#cate_idx').val() ) {
			alert('카테고리를 선택해주세요.');
			return false;
		}
		else if( '' == $('#frm_itm_name').val() ) {
			alert('제품명을 입력해주세요.');
			return false;
		}
		else if( '' == $('#frm_itm_name_sub').val() ) {
			alert('제품 간단 설명을 입력해주세요.');
			return false;
		}
		else if( '' == $('#itm_spec_simple').val() ) {
			alert('제품 간단 스펙을 입력해주세요.');
			return false;
		}

		return true;

	}

	function click_event(id) {
		$("#"+id).trigger("click");
	}

	/* - - - - - -  - - -  - - -  - - -  - - -  - - -  - - -  - - -  - - -  - - -  - - -  - - -  - - - 
	 * 카테고리 선택시 하위 카테고리 신규 등록 가능 전환 및 목록 노출
	 * - - - - - -  - - -  - - -  - - -  - - -  - - -  - - -  - - -  - - -  - - -  - - -  - - -  - - - */

		function ready_nextcate(idx, depth, obj) {
			
			// 클릭한 메뉴 선택 표시
			$('.input_cate'+depth).removeClass('active');
			$(obj).addClass('active');

			// 선택 카테고리 인덱스 값
			$('#cate'+depth).val(idx);
			$('#cate_idx').val(idx);
			
			// 선택한 메뉴보다 하위의 부모카테고리 값들은 초기화
			var ino=depth+1;
			for(pno=ino;pno<=4;pno++) {

				if($('#onload_chk').val() == 1) {
					$('#cate'+pno).val('');
				}

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

			// 하위 카테고리 목록 노출
			fn_list_next_cate(idx,depth);
		}


		function fn_list_next_cate(pidx,depth) {

			//  console.log(pidx+'/'+depth);
			var child_depth = depth + 1;

			// #wrap_cate
			var wrap_cate_id = 'wrap_cate'+child_depth;

			var request = $.ajax({
			  url: "/trans/item_list_next_cate",
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

			var request = $.ajax({
			  url: "/trans/item_edit_cate",
			  method: "POST",
			  data: { 'cate_idx':idx,'cate_val':cate_val},
			  dataType: "html"
			});

			request.done(function( res ) {
			  console.log(res);
			  
			   
			});

			request.fail(function( jqXHR, textStatus ) {
			  alert( "Request failed: " + textStatus );
			  return false;
			});

		}


		function del_cate(idx) {

			var request = $.ajax({
			  url: "/trans/item_del_cate",
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

	/* - - - - - -  - - -  - - -  - - -  - - -  - - -  - - -  - - -  - - -  - - -  - - -  - - -  - - - 
	 * 아이템 순서 조정 
	 * - - - - - -  - - -  - - -  - - -  - - -  - - -  - - -  - - -  - - -  - - -  - - -  - - -  - - - */

		function reorder_list() {
			$(".item_box").each(function(i, box) {
				$(box).find(".item_num").html(i + 1);
			});
		}


</script>





<script type="text/javascript">
	$R('.itm_content', { 
		//focus: true,
		//toolbarExternal: '#my-external-toolbar',
		lang: 'ko',
		minHeight: '400px',
		maxHeight: '1000px',
		//plugins: ['fontsize','fontcolor','filemanager','video','table','alignment','inlinestyle','specialchars','textdirection','widget','fontfamily','fullscreen'],
		plugins: ['fontsize','fontcolor','filemanager','video','table','alignment','inlinestyle','specialchars','fontfamily','fullscreen'],
		//imageUpload: "/files/upload/redactor_image/<?php //echo url_code('board/'. $bo_code .'/image','e') ?>/<?php //echo $bo_code ?>/<?php //echo $wr_idx ?>",
		//fileUpload: "/files/upload/redactor_file/<?php //echo url_code('board/'. $bo_code .'/files','e') ?>/<?php //echo $bo_code ?>/<?php //echo $wr_idx ?>",
		imageUpload: "/files/upload/redactor_image/<?php echo url_code('item/image','e') ?>/items/<?php echo isset($idx) ? $idx : ''; ?>",
		fileUpload: "/files/upload/redactor_file/<?php echo url_code('item/files','e') ?>/items/<?php echo isset($idx) ? $idx : ''; ?>",

		buttonsAddAfter: {
			after: 'deleted',
			//buttons: ['underline','line', 'redo', 'undo', 'underline', 'ol', 'ul', 'sup', 'sub']
			buttons: ['underline','line', 'ol', 'ul']
		},
		buttonsHide: ['lists']

	});

	$R('#itm_spec_simple', { 
		lang: 'ko',
		minHeight: '300px',
		maxHeight: '300px',
		plugins: ['fontsize','alignment','specialchars'],
		buttonsAddAfter: {
			after: 'deleted',
			//buttons: ['underline','line', 'redo', 'undo', 'underline', 'ol', 'ul', 'sup', 'sub']
			buttons: ['ol', 'ul']
		},
		buttonsHide: ['lists','bold','italic'],
		breakline: true
	});
</script>

<script type="text/javascript">


	// 파일을 본문 안에 추가
	function file_insert_to_content(file_dir,file_name,file_name_org,file_type,img_width,limit_width)
	{
		if('image' == file_type){
			var img_w = img_width+'px';
			if(Number(img_width) > Number(limit_width)) {
				img_w = limit_width +'px';
			}
			var add_tag = '<p><img class="'+file_name+'" src="/data/'+ file_dir + '/' + file_name +'" alt="" width="'+img_w+'"></p>';
		}
		else {
			var add_tag = '<p><a class="'+file_name+'" href="/data/'+ file_dir + '/' + file_name +'">'+file_name_org+'</a></p>';
		}

		// insert
		$R('#wr_content', 'insertion.insertHtml', add_tag);
	}

	// 선택 파일 삭제
	function delete_file_manager(idx,file_class,file_type,file_dir,file_name)
	{
		if( confirm('삭제하시겠습니까?') )
		{

				// 삭제하려는 사람과 등록한 사람 비교 포함.
				var request = $.ajax({
				  url: "/trans/delete_file_manager/",
				  method: "POST",
				  data: { 'idx': idx  /* , '<?php echo $this->security->get_csrf_token_name() ?>':'<?php echo $this->security->get_csrf_hash() ?>' */},
				  dataType: "html"
				});

				request.done(function( res ) {

					// 파일 삭제하고, 디비에서도 삭제하면
					// 에디터에서 삭제 및 파일 첨부 리스트에서도 삭제
					if('true' == res) {

						// 에디터에서 삭제
						if('image' == file_type) {
							//var del_attr = '/data'+ file_dir + file_name;
							//if($('img').attr('src') == del_attr) {$(this).remove();}
						}
						else {
							//var del_attr = '/data'+ file_dir + file_name;
							//if($('a').attr('href') == del_attr) {$(this).remove();}
						}
						$('.'+file_name).remove();

						// 파일 첨부 리스트에서 삭제
						$('.'+file_class).remove();
					}


				});

				request.fail(function( jqXHR, textStatus ) {
				  alert( "Request failed: " + textStatus );

				  return false;
				});
		}
	}
</script>
