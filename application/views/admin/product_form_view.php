
<style type="text/css">
	/*
	.o_cate_wrap {width:1200px; }
	.o_cate_wrap table {width:100%;  border-top:2px solid #333333;  border-bottom:1px solid #cccccc; }
	.o_cate_wrap table thead {border-bottom:1px solid #cccccc; }
	.o_cate_wrap table thead tr th {text-align:center; font-weight:bold; height:40px; border-left:1px solid #ccc; border-bottom:1px dashed #ccc; background-color:#f1f1f1; }
	.o_cate_wrap table thead tr td {text-align:left; padding:5px 10px; height:40px; border-left:1px solid #ccc; }
	.o_cate_wrap table thead tr td input { width:calc(100% - 60px); background-color:#cccccc}
	.o_cate_wrap table thead tr td input.active {background-color:#ffffff; }
	.o_cate_wrap table tbody tr td {text-align:left; padding:5px 10px; height:36px; border-left:1px solid #eee; vertical-align:top;}
	.o_cate_wrap table thead tr th:first-child, .o_cate_wrap table thead tr td:first-child, .o_cate_wrap table tbody tr td:first-child {border-left:none;}
	.o_cate_wrap table tbody tr td ul {list-style: none; margin:0; padding:0;}
	.o_cate_wrap table tbody tr td ul li {background-color:#f7f7f7; border:1px dashed #ccc; margin:.25rem 0; padding:0 .25rem;   cursor:pointer;}
	.o_cate_wrap table tbody tr td ul li.active {background-color:#e1e1f0; background-image:url('/assets/images/2020/next1.png'); background-repeat:no-repeat; background-position: right center; }
	*/

	.o_cate_wrap {width:1200px; }
	.o_cate_wrap table {width:100%;  border-top:2px solid #333333;  border-bottom:1px solid #cccccc; }


	.cate_box {font-size: 12px; padding:0 5px; line-height:100%; vertical-align:middle;}

	.file_title {font-size:13px; border-top-right-radius: 0; border-bottom-right-radius: 0; width:150px; padding:0 5px;}




	/*
	.o_img_list {}
	.o_img_list > ul > li {float:left;margin:0;padding:0; width:20%; display:inline-block; overflow:hidden; border-left:1px solid #ccc;}
	*/

	.o_img_list > ul {display:table; height:100%;}
	.o_img_list > ul > li {border-left:1px solid #dddddd; display:table-cell;  float:left;margin:0;padding:0; width:20%; height:100%; overflow:hidden; vertical-align:middle;}
	.o_img_list > ul > li:first-child {border-left:none;}
	.choose-file { position: relative;overflow: hidden;display: block; }
	.choose-file::before {
		position: absolute;
		/*font-family: 'unicons';
		content: '\e9cd';*/
		width: 100%;
		text-align: center;
		z-index: -1;
		left: 0;
		top: 10px;
		font-size: 22px;
		color: #0027e6;
		-webkit-transition: all 200ms linear;
		transition: all 200ms linear;
	}
	.choose-file input[type=file] {
		opacity: 0;
		position: absolute;
		width: 100%;
		height: 100%;
		display: block;
		font-size: 15px;
		cursor: pointer;
		z-index: 4;
	}
	.choose-file label {
		border: none;
		margin:0;
		padding: 0;
		display: block;
		text-align: center;
		z-index: 2;
		-webkit-transition: all 200ms linear;
		transition: all 200ms linear;
	}
	.choose-file label img {
		width:100%;
	}
	.choose-file:hover label {
		border-color: #0027e6;
	}
	.choose-file.colored-bg label {
		background-color: rgba(200, 200, 200, .2);
		border: none;
	}
	.choose-file.colored-bg:hover label {
		background-color: #0027e6;
		color: #fff;
	}
	.choose-file.colored-bg::before {
		z-index: 3;
	}
	.choose-file.colored-bg:hover::before {
		color: #fff;
	}
	.preview_img > img {width:100%;}

	input.o_hashtag::placeholder {
	  color: #007bff;
	}
	input::placeholder {
	  color: #007bff;
	}
	textarea::placeholder {
	  color: #007bff;
	}
</style>


<?php echo form_open_multipart($this->uri->uri_string(), array('id'=>'product_form','name'=>'product_form','onsubmit'=>'return chk_form();')); ?>

	<?php //echo validation_errors('<div class="err_color_red">','</div>')?>

	<h1 style="margin-bottom:0;">제품 등록/수정</h1>

	<div id="scroll-fix-header"></div>
	<!-- <h3 class="page-header scroll_fixed" style="z-index:110; width:100%; position:relative;">
		<input type="submit" name="submit" class="btn btn-danger btn-sm" value="저장" style="position:absolute; bottom:10px; right:0px; padding-left:20px; padding-right:20px; " />
		<a href="/admin/product/lists"><input type="button" name="list" class="btn btn-dark btn-sm" value="목록" style="position:absolute; bottom:10px; right:70px; padding-left:20px; padding-right:20px; " /></a>

		<?php if((isset($idx) && '' != $idx)) { ?>
		<a href="/admin/product/del_prd/<?php echo $idx ?>" onclick="del_prd(<?php echo $idx ?>); return false;"><input type="button" name="list" class="btn btn-danger btn-sm" value="삭제" style="position:absolute; bottom:10px; right:140px; padding-left:20px; padding-right:20px; " /></a>
		<?php } ?>
	</h3> -->


	<h3 class="page-header scroll_fixed" style="z-index:110; width:100%; position:relative;">
	  <div style="position:absolute; bottom:10px; right:0;">

		<?php if((isset($idx) && '' != $idx)) { ?>
		<a href="/admin/product/del_prd/<?php echo $idx ?>" onclick="del_prd(<?php echo $idx ?>); return false;"><input type="button" name="list" class="btn btn-danger btn-sm" value="삭제" style="float:right; padding-left:20px; padding-right:20px; margin-left:5px; " /></a>
		<?php } ?>

		<input type="submit" name="submit" class="btn btn-dark btn-ssm" value="저장" style="float:right; padding-left:20px; padding-right:20px; margin-left:5px;" />

		<a href="/admin/product/lists"><input type="button" name="list" class="btn btn-dark btn-ssm" value="목록" style="float:right; padding-left:20px; padding-right:20px; " /></a>

	  </div>
	</h3>


	<h2 style="position:relative;">
		카테고리 선택 
		<?php if((isset($idx) && '' != $idx)) { ?><button type="button" class="btn btn-dark btn-xs" style="margin-left:20px; position:absolute; bottom:5px;" onclick="$('#category_sect').show();">카테고리 수정</button><?php } ?>
	</h2>

	<div class="o_cate_wrap" >

		<!-- 제품 수정시 제품의 idx -->
		<input type="hidden" name="prd_idx" id="prd_idx" class="o_input" value="<?php echo isset($idx) ? $idx : ''; ?>" /><!-- 선택 카테고리 idx -->
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
							<span id="cate_idx_<?php echo $o->idx?>" class="cate_box"><?php echo $o->name ?></span>
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
							<span id="cate_idx_<?php echo $o->idx?>" class="cate_box"><?php echo $o->name ?></span>
						</li>
					<?php }} ?>
				  </ul>
				  </div>
				</td>
				<td>
				  <div id="wrap_cate3">
					<!-- 카메라 ☞ -->
					<ul id="sdepth2" class="sortable">
					<?php
					if( isset($result_cate3['qry']) ) {
					foreach($result_cate3['qry'] as $i => $o) { ?>
						<li id="cate_wrap_<?php echo $o->idx?>" class="item_box input_cate1 cate3_<?php echo ($i+1)?>  <?php //echo ($o->idx == $row_cate->pcate3) ? 'active' : '' ?>" onclick="ready_nextcate(<?php echo $o->idx?>,<?php echo $o->depth?>,this);">
							<!-- <input type="text" id="cate_idx_<?php echo $o->idx?>" name="" value="<?php echo $o->name ?>" class="o_input"  /> -->
							<span id="cate_idx_<?php echo $o->idx?>" class="cate_box"><?php echo $o->name ?></span>
						</li>
					<?php }} ?>
				  </ul>
				  </div>
				</td>
				<td>
				  <div id="wrap_cate4">
					<ul id="sdepth2" class="sortable">
					<?php 
					if( isset($result_cate4['qry']) ) {
					foreach($result_cate4['qry'] as $i => $o) { ?>
						<li id="cate_wrap_<?php echo $o->idx?>" class="item_box input_cate1 cate4_<?php echo ($i+1)?>  <?php //echo ($o->idx == $row_cate->idx) ? 'active' : '' ?>" onclick="ready_nextcate(<?php echo $o->idx?>,<?php echo $o->depth?>,this);">
							<!-- <input type="text" id="cate_idx_<?php echo $o->idx?>" name="" value="<?php echo $o->name ?>" class="o_input"  /> -->
							<span id="cate_idx_<?php echo $o->idx?>" class="cate_box"><?php echo $o->name ?></span>
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

		<hr />

	</div>

	<h2 class="mt-5">기본 정보</h2>

	<div class="o_cate_wrap" >

			<section class="row">
				<div class="col" style="margin-bottom:15px; ">
				  <div style="width:100%; background-color:#ffffff; border:1px solid #dddddd; overflow:hidden;">
					<div class="preview_img o_img_view" style="width:100%;border-bottom:1px solid #dddddd;">
					<?php if( isset($img_list[0]->file_src )) { ?>
						<img id="preview_big" src="<?php echo $img_list[0]->file_src ?>" style="width:100%;"/>
					<?php } else { ?>
						<img id="preview_big" src="<?php echo IMG_DIR ?>/common/empty2.jpg" style="width:100%;"/>
					<?php } ?>
					</div>
					<div class="o_img_list" style="width:100%;">
						<ul class="o_none" style="width:100%; margin:0; padding:0;">
						<?php
						$n=1;
						foreach($img_list as $i => $o) { ?>
							<li>
								<div id="pthumb_<?php echo $n ?>" class="choose-file preview_thumb">
									<img src="<?php echo IMG_DIR ?>/icons/icon_btn_del.gif" style="cursor:pointer; position:absolute; top:0; right:0; z-index:10;" title="클릭하시면 삭제됩니다." onclick="delThumbnail(<?php echo $o->file_idx ?>,'<?php echo $o->wr_table?>','<?php echo $o->wr_table_idx?>');" />

									<input type="file" name="attach_file_img[]" id="attach_file_<?php echo $n ?>" class="form-file" onchange="setThumbnail(event,<?php echo $n ?>,<?php echo $o->file_idx;?>);" title="클릭하시면 파일을 선택할 수 있습니다!" />
									<label id="preview_thumb_<?php echo $n ?>" class="preview_img"><img src="<?php echo $o->file_src ?>" /></label>
								</div>
							</li>
						<?php
							$n++;
						} ?>
						<?php
						for($j=$n;$j<=5;$j++) {
						?>
							<li>
								<div id="pthumb_<?php echo $j ?>" class="choose-file ">
									<input type="file" name="attach_file_img[]" id="attach_file_<?php echo $j ?>" class="form-file" onchange="setThumbnail(event,<?php echo $j ?>);" title="클릭하시면 파일을 선택할 수 있습니다!" />
									<label id="preview_thumb_<?php echo $j ?>" class="preview_img"><img src="<?php echo IMG_DIR ?>/common/empty2.jpg" /></label>
								</div>
							</li>
						<?php } ?>
						</ul>
					</div>
				  </div>
				</div>

				<style>
					.prd_desc_list ul{padding-left:20px;}
				</style>

				<div class="col" style="margin-bottom:15px;">

				  <div class="prd_desc_list" style="background-color:#ffffff; padding:20px; border:1px solid #dddddd; ">
					<h3 style="font-size:28px;">
						<input type="text" name="prd_name" id="frm_prd_name" class="o_input" value="<?php echo set_value('prd_name',isset($row->prd_name) ? $row->prd_name : '') ?>" style="width:100%; font-weight:bold; font-size:28px; padding:3px 5px;" placeholder="제품명" title="제품명을 입력해주세요." />
						<?php echo form_error('prd_name','<div class="error">','</div>'); ?>
					</h3>
					<h5 style="padding:10px 0 15px; color:#666666; font-size:18px;">
						<input type="text" name="prd_name_sub" id="frm_prd_name_sub" class="o_input" value="<?php echo set_value('prd_name_sub',isset($row->prd_name_sub) ? $row->prd_name_sub : '') ?>" style="width:100%; font-size:18px; padding:3px 5px;" placeholder="제품 간단 설명" title="제품 간단 설명을 입력해주세요." />
						<?php echo form_error('prd_name_sub','<div class="error">','</div>'); ?>
					</h5>
					<textarea name="prd_spec_simple" id="prd_spec_simple" class="o_input" style="width:100%; height:auto; min-height:300px;padding:3px 5px;" placeholder="제품 간단 스펙" title="제품 간단 스펙을 입력해주세요."><?php echo set_value('prd_spec_simple',isset($row->prd_spec_simple) ? $row->prd_spec_simple : '') ?></textarea>
					<?php echo form_error('prd_spec_simple','<div class="error">','</div>'); ?>
				  </div>

				  <div style="margin-top:15px; padding:18px 20px; width:100%; border:1px solid #dddddd; background-color:#ffffff;">
					
					<div class="input-group my-1">
					  <span class="input-group-text" style="font-size:13px;     border-top-right-radius: 0;    border-bottom-right-radius: 0;">해시태그</span>
					  <input type="text" name="prd_hashtag" class="form-control o_hashtag" value="<?php echo set_value('prd_hashtag',isset($row->prd_hashtag) ? $row->prd_hashtag : '') ?>" style="font-size:13px; padding:5px;  margin-left:-1px;" placeholder="콤마로 구분해서 입력해주세요." />
					</div>

				  </div>


				</div>
			</section>
			<hr />

	</div>



	<h2 class="mt-5">관리 정보 <small>(비워놓으면 노출되지 않습니다.)</small></h2>
	<div class="o_cate_wrap" >
		<section class="row">
			<div class="col-12">

					<div class="row">
						<div class="col-6 mb-2">
						  <div class="input-group">
							<span class="input-group-text" style="font-size:13px;     border-top-right-radius: 0;    border-bottom-right-radius: 0;">화소정보</span>
							<input type="text" name="prd_pixel" class="form-control o_hashtag" value="<?php echo set_value('prd_pixel',(isset($row->prd_pixel) && $row->prd_pixel > 0) ? $row->prd_pixel : '') ?>" style="font-size:13px; padding:5px;  margin-left:-1px;" placeholder="MP(메가픽셀) 단위로 입력해주세요. " />
							<span class="input-group-text" style="font-size:13px;     border-top-left-radius: 0;    border-bottom-left-radius: 0; margin-left:-1px;">MP(메가픽셀)</span>
						  </div>
						</div>
						<div class="col-6" style="margin-left:-15px; line-height:33px; color:#3333ff;">[공통]</div>
					</div>

					<?php 
					// 금액은 조달제품과 제품소개 등록 제품만 사용
					//if( isset($row->cate1) && ($row->cate1 == '1' OR $row->cate1 == '3') ) {
					?>
					<div class="row">
						<div class="col-6 mb-2">
						  <div class="input-group">
							  <span class="input-group-text" style="font-size:13px;     border-top-right-radius: 0;    border-bottom-right-radius: 0;">판매가격</span>
							  <input type="text" id="prd_price" name="prd_price" class="form-control o_hashtag price_add_comma" value="<?php echo set_value('prd_price',(isset($row->prd_price) && $row->prd_price > 0) ? $row->prd_price : '') ?>" style="font-size:13px; padding:5px;  margin-left:-1px;" placeholder="원 단위로 입력해주세요. <?php echo (isset($row->cate1) && $row->cate1 == '3') ? '(판매자회원에게만 노출)' : '' ?>" />
							  <!-- <span class="input-group-text" style="font-size:13px;     border-top-left-radius: 0;    border-bottom-left-radius: 0; margin-left:-1px;">원</span> -->

							  <span id="prd_price_comma" style="position:absolute; right:25px; display:inline-block; line-height:32px; color:#3333ff; z-index:10;"><?php echo (isset($row->prd_price) && $row->prd_price > 0) ? number_format($row->prd_price).'원' : '' ?></span>
						  </div>
						</div>
						<div class="col-6" style="margin-left:-15px; line-height:33px; color:#ff0000;">[제품소개], [조달제품]</div>
					</div>
					<div class="row">
						<div class="col-6 mb-2">
						  <div class="input-group">
							  <span class="input-group-text" style="font-size:13px;     border-top-right-radius: 0;    border-bottom-right-radius: 0;">정렬가격</span>
							  <input type="text" id="ord_price" name="ord_price" class="form-control o_hashtag price_add_comma" value="<?php echo set_value('ord_price',(isset($row->ord_price) && $row->ord_price > 0) ? $row->ord_price : '') ?>" style="font-size:13px; padding:5px;  margin-left:-1px;" placeholder="원 단위로 입력해주세요. <?php //echo (isset($row->cate1) && $row->cate1 == '3') ? '(판매자회원에게만 노출)' : '' ?>" />

							  <span id="ord_price_comma" style="position:absolute; right:25px; display:inline-block; line-height:32px; color:#3333ff; z-index:10;"><?php echo (isset($row->ord_price) && $row->ord_price > 0) ? number_format($row->ord_price).'원' : '' ?></span>
						  </div>
						</div>
						<div class="col-6" style="margin-left:-15px; line-height:33px; color:#ff0000;">[제품소개], [조달제품] <span style="color:gray;">(목록에서 가격순 클릭했을 때 우선 적용)</span></div>
					</div>
					<?php //} ?>


					<?php 
					// 제품소개 등록 제품만 사용
					//if( isset($row->cate1) && $row->cate1 == '3') {
					?>
					<div class="row">
						<div class="col-6">

							<div class="input-group mb-2">
							  <div class="input-group-text">
								<input type="checkbox" name="editor_trend_main" value="1" id="editor_trend_main" <?php echo (isset($row->editor_trend_main) && '1' == $row->editor_trend_main) ? 'checked' : '' ?> style="vertical-align:middle" aria-label="Checkbox for following text input">
							  </div>
							  <input type="text" class="form-control" aria-label="Text input with checkbox" readonly style="background-color:#fff; color:#007bff; font-size:13px; padding:5px; " value="[메인] 추천 및 트렌드 체크 : 메인페이지 노출" />
							</div>

						</div>
						<div class="col-6" style="margin-left:-15px; line-height:33px; color:#ff0000;">[제품소개]</div>
					</div>
					<?php //} ?>

					<!-- 인기순 -->
					<div class="row">
						<div class="col-6">
							<div class="input-group mb-2">
							  <input type="text" name="editor_pick" value="<?php echo set_value('editor_pick',(isset($row->editor_pick) && $row->editor_pick != '') ? $row->editor_pick : '') ?>" id="editor_pick" class="form-control" style="vertical-align:top; font-size: 13px; text-align:center;"  placeholder="인기순위" aria-label="인기순" aria-describedby="basic-addon2">
							  <span class="input-group-text" id="basic-addon2" style="font-size: 13px; width:88%;">[목록] 인기순 : 인기순 클릭시, 숫자가 작을수록 우선 노출</span>
							</div>
						</div>
						<div class="col-6" style="margin-left:-15px; line-height:33px; color:#3333ff;">[공통]</div>
					</div>

					<!-- 추천순 -->
					<div class="row">
						<div class="col-6">
							<div class="input-group mb-2">
							  <input type="text" name="editor_recommand" value="<?php echo set_value('editor_recommand',(isset($row->editor_recommand) && $row->editor_recommand != '') ? $row->editor_recommand : '') ?>" id="editor_recommand" class="form-control" style="vertical-align:top; font-size: 13px; text-align:center;"  placeholder="추천순위" aria-label="추천순" aria-describedby="basic-addon2">
							  <span class="input-group-text" id="basic-addon2" style="font-size: 13px; width:88%;">[목록] 추천순 : 추천순 클릭시, 숫자가 작을수록 우선 노출</span>
							</div>
						</div>
						<div class="col-6" style="margin-left:-15px; line-height:33px; color:#3333ff;">[공통]</div>
					</div>

					<?php 
					//if( isset($row->cate1) && $row->cate1 == '1' ) {
					?>
					<div class="row">
						<div class="col-6 mb-2">
						  <div class="input-group">
							  <span class="input-group-text" style="font-size:13px;     border-top-right-radius: 0;    border-bottom-right-radius: 0;">조달제품 바로구매 링크</span>
							  <input type="text" name="jodal_direct_link" class="form-control o_hashtag" value="<?php echo set_value('jodal_direct_link',(isset($row->jodal_direct_link) && $row->jodal_direct_link != '') ? $row->jodal_direct_link : '') ?>" style="font-size:13px; padding:5px;  margin-left:-1px;" placeholder="전체 URL 을 입력해주세요. ex) http://www.watchcam.co.kr" />
							  <!-- <span class="input-group-text" style="font-size:13px;     border-top-left-radius: 0;    border-bottom-left-radius: 0; margin-left:-1px;">원</span> -->
						  </div>
						</div>
						<div class="col-6" style="margin-left:-15px; line-height:33px; color:#ff0000;">[조달제품]</div>
					</div>
					<?php //} ?>

			</div>
		</section>
		<hr />
	</div>

	<h2 class="mt-5">주요 사양</h2>
	<div class="o_cate_wrap" >
		<section class="row">
			<div class="col">
				<textarea id="prd_info_detail" class="prd_content" name="prd_info_detail"><?php echo set_value('prd_info_detail',isset($row->prd_info_detail) ? $row->prd_info_detail : '') ?></textarea>
			</div>
		</section>
		<hr />
	</div>




	<h2 class="mt-5">상세정보</h2>
	<div class="o_cate_wrap" >
		<section class="row">
			<div class="col">
				<textarea id="prd_info_spec" class="prd_content" name="prd_info_spec"><?php echo set_value('prd_info_spec',isset($row->prd_info_spec) ? $row->prd_info_spec : '') ?></textarea>
			</div>
		</section>
		<hr />
	</div>


	<h2 class="mt-5">추가정보</h2>
	<div class="o_cate_wrap" >
		<section class="row">
			<div class="col">
				<textarea id="prd_info_add" class="prd_content" name="prd_info_add"><?php echo set_value('prd_info_add',isset($row->prd_info_add) ? $row->prd_info_add : '') ?></textarea>
			</div>
		</section>
		<hr />
	</div>

	<!-- 
	down_no
		1: Manual
		2: Catalog
		3: Specification
		4: Drawing
	-->
	<h2 class="mt-5" style="position:relative;">
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
				for($i=1;$i<=30;$i++) {
					$display = 'display:none;';
					if(isset($download[$i]->file_download) && $download[$i]->file_download) {
						$display = 'display:block;';
					}
				?>
				<div id="down_file_wrap_<?php echo $i ?>" class="down_file_wrap" style="<?php echo $display ?>">

						<div class="input-group my-1">
						  <span class="input-group-text file_title"><input type="text" id="input_file_title_<?php echo $i ?>" class="input_file_title" data-no="<?php echo $i ?>" style="width:100%;" name="file_title_<?php echo $i ?>" value="<?php echo isset($download[$i]->file_title) ? $download[$i]->file_title : ''; ?>" autocomplete="off" /></span>
						  <input type="file" name="attach_download_<?php echo $i ?>" id="attach_download_<?php echo $i ?>" class="form-control" style="border-left:none; padding:3px; font-size:13px;" />

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

		<a href="/admin/product/lists"><input type="button" name="list" class="btn btn-dark btn-sm" value="목록" style="padding-left:20px; padding-right:20px; margin:0;" /></a>

		<input type="submit" name="submit" class="btn btn-dark btn-sm" value="저장" style="padding-left:20px; padding-right:20px; margin:0;" />

		<?php if((isset($idx) && '' != $idx)) { ?>
		<a href="/admin/product/del_prd/<?php echo $idx ?>" onclick="del_prd(<?php echo $idx ?>); return false;"><input type="button" name="list" class="btn btn-danger btn-sm" value="삭제" style="padding-left:20px; padding-right:20px; margin:0; " /></a>
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
function del_prd(prd_idx) {
	if( confirm('제품을 삭제하시겠습니까?')) {
		location.href="/admin/product/del_prd/"+prd_idx;
	}
}

function delFile(file_idx,wr_table,wr_table_idx){
	//alert(file_idx);
	if( confirm('클릭하신 파일을 삭제하시겠습니까?')) {
		location.href="/admin/product/del_file/"+file_idx+"/"+wr_table+"/"+wr_table_idx+"/<?php echo url_code($this->uri->uri_string(), 'e') ?>";
	}
}


function delThumbnail(file_idx,wr_table,wr_table_idx){
	//alert(file_idx);
	if( confirm('클릭하신 이미지를 삭제하시겠습니까?')) {
		location.href="/admin/product/del_thumbnail/"+file_idx+"/"+wr_table+"/"+wr_table_idx+"/<?php echo url_code($this->uri->uri_string(), 'e') ?>";
	}
}

function setThumbnail(event,no,file_idx=false) { 
	var reader = new FileReader(); 
	reader.onload = function(event) { 
		var img = document.createElement("img");
		img.setAttribute("src", event.target.result);

		console.log(no);

		if(1==no){
			$('#preview_big').attr('src',event.target.result);
		}
		$('#preview_thumb_'+no).html(img);
		//document.querySelector("div.o_img_view").appendChild(img); 

		// 수정일 때.. 이미지 바로 수정
		//var prd_idx = $('#prd_idx').val();

		//if('' != prd_idx) {
			

			var file_data = $('#attach_file_'+no).prop('files')[0];   
			var form_data = new FormData();                  
			form_data.append('file', file_data);
			//form_data.append('prd_idx', prd_idx); // 제품 인덱스
			form_data.append('file_idx', file_idx); // 파일 인덱스
			form_data.append('no', no);  // 썸네일 이미지 번호
			//alert(form_data);
			$.ajax({
				url: '/files/upload/product_image/<?php echo url_code("product/image","e") ?>/products/<?php echo isset($idx) ? $idx : ''; ?>', // idx : 제품 인덱스
				dataType: 'text',  // what to expect back from the PHP script, if anything
				cache: false,
				contentType: false,
				processData: false,
				data: form_data,                         
				type: 'post',
				success: function(php_script_response){
					//alert(php_script_response); // display response from the PHP script, if any
					console.log(php_script_response);
				}
			});

		//}

	}; 
	reader.readAsDataURL(event.target.files[0]);
}
</script>

<script type="text/javascript">
	$(document).ready(function(){

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


		// 제품 이미지 보기
		$('.preview_thumb').mouseover(function(){
			var thumb_id = $(this).attr('id');
			var thumb_src = $('#'+thumb_id+' > label > img').attr('src');
			$('#preview_big').attr('src',thumb_src);
		});


		// 정렬용 가격 콤마 처리
		$('#prd_price').on('keyup keydown blur',function(){
			var prd_price = $(this).val();
			var prd_price_comma = addComma(prd_price)+'원';
			//console.log(prd_price_comma);
			$('#prd_price_comma').html(prd_price_comma);

		});

		$('#ord_price').on('keyup keydown blur',function(){
			var ord_price = $(this).val();
			var ord_price_comma = addComma(ord_price)+'원';
			//console.log(ord_price_comma);
			$('#ord_price_comma').html(ord_price_comma);

		});
	});


	


	// 폼체크 - 필수 항목 체크
	function chk_form() {

		// 카테고리 체크
		if( '' == $('#cate_idx').val() ) {
			alert('카테고리를 선택해주세요.');
			return false;
		}
		else if( '' == $('#frm_prd_name').val() ) {
			alert('제품명을 입력해주세요.');
			return false;
		}
		else if( '' == $('#frm_prd_name_sub').val() ) {
			alert('제품 간단 설명을 입력해주세요.');
			return false;
		}
		else if( '' == $('#prd_spec_simple').val() ) {
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
				$('#cate'+pno).val('');
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
			  url: "/trans/fn_list_next_cate",
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
			  url: "/trans/fn_edit_cate",
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
	$R('.prd_content', { 
		//focus: true,
		//toolbarExternal: '#my-external-toolbar',
		lang: 'ko',
		minHeight: '500px',
		maxHeight: '1000px',
		//plugins: ['fontsize','fontcolor','filemanager','video','table','alignment','inlinestyle','specialchars','textdirection','widget','fontfamily','fullscreen'],
		plugins: ['fontsize','fontcolor','filemanager','video','table','alignment','inlinestyle','specialchars','fontfamily','fullscreen'],
		//imageUpload: "/files/upload/redactor_image/<?php //echo url_code('board/'. $bo_code .'/image','e') ?>/<?php //echo $bo_code ?>/<?php //echo $wr_idx ?>",
		//fileUpload: "/files/upload/redactor_file/<?php //echo url_code('board/'. $bo_code .'/files','e') ?>/<?php //echo $bo_code ?>/<?php //echo $wr_idx ?>",
		imageUpload: "/files/upload/redactor_image/<?php echo url_code('product/image','e') ?>/products/<?php echo isset($idx) ? $idx : ''; ?>",
		fileUpload: "/files/upload/redactor_file/<?php echo url_code('product/files','e') ?>/products/<?php echo isset($idx) ? $idx : ''; ?>",

		buttonsAddAfter: {
			after: 'deleted',
			//buttons: ['underline','line', 'redo', 'undo', 'underline', 'ol', 'ul', 'sup', 'sub']
			buttons: ['underline','line', 'ol', 'ul']
		},
		buttonsHide: ['lists']

	});

	$R('#prd_spec_simple', { 
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
