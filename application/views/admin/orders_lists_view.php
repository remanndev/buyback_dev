<?php
/** - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
 * 회원검색
*/

// [1] 검색필드
	$sfl_select_options = array(
		'all'       => '통합검색',
		'barcode'   => '바코드',
		'itm_name'  => '제품명',
		'vendor'    => '매입처',
		'sku'       => 'SKU',
		'location'  => '위치',
	);
// [2] 검색어
	$search_text = array(
		'name'	=> 'stx',
		'id'	=> 'stx',
		'value' => ($stx) ? $stx : set_value('stx'),
		'maxlength'	=> 20,
		'class'	=> 'o_input'
	);

/** - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
 * 회원정렬
*/
	$ofl_select_options = array(
		'itm_name DESC'    => '제품명 ↓',
		'itm_name ASC'     => '제품명 ↑',
		'exp_date DESC'    => '유통기한 ↓',
		'exp_date ASC'     => '유통기한 ↑',
		'location DESC'    => '위치 ↓',
		'location ASC'     => '위치 ↑'
	);


/** - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
 * 카테고리 구분()
*/



/** - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
 * 엑셀 업로드/다운로드 사용 여부
*/
	$use_excel_upload = true;
	$use_excel_download = true;
?>
<div class="admin_wrap" style="max-width:100%;">

	<h1>재고 목록</h1>

	<?php 
	/**
	 | - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	 | 재고 목록 엑셀 업로드
	 */

	if($use_excel_upload) {
		//echo form_open($this->uri->uri_string(), array('id'=>'excel_form','name'=>'excel_form'));
	?>

		<h2>재고 목록 엑셀 업로드</h2>

		<div class="panel panel-default-flat">
		  <div class="panel-heading">
			<div style="position:relative;">
				

				<!-- 엑셀 업로드 -->
				<form name="excel_inven_upload" action="<?php echo base_url() ?><?php echo $this->uri->uri_string() ?>" method="post" enctype="multipart/form-data" target="hidden_ifr">
					
					<input type="hidden" name="chk_excel" value="upload" />
					<input type="file" name="excel_file" class="o_input_file" style="border:none; display:inline-block; background-color:#dddddd;" />
					<input type="submit" name="excel_upload_submit" class="o_input" value="엑셀 업로드" />
				</form>

				<!-- 엑셀 업로드 회원정보만 초기화 -->
				<div style="position:absolute;top:0; right:0;">
					<a class="btn btn-dark btn-ssm" title="엑셀업로드 샘플" href="/files/download/<?php echo url_code('sample', 'e') ?>/inven_upload_sample.xlsx" onclick="alert('준비중입니다.'); return false;">엑셀업로드 샘플</a>
					<!-- <form name="excel_users_truncate" action="<?php echo base_url() ?><?php echo $this->uri->uri_string() ?>" method="post" target="hidden_ifr" onsubmit="return chk_submit();" style="display:inline-block;">
						<input type="hidden" name="chk_excel" value="truncate" />
						<input type="submit" name="excel_truncate_submit" value="엑셀업로드회원만 삭제" class="btn btn-danger btn-ssm"  title="[주의!!!] 클릭하시면 엑셀업로드회원 정보가 모두 삭제화됩니다." />
					</form>
					<script type="text/javascript">
						function chk_submit() {
							if( confirm('정말 엑셀업로드 정보를 삭제하시겠습니까? 이 결정은 되돌릴 수 없습니다!') ) {
								return true;
							}
							else
								return false;
						}
					</script> -->
				</div>
				<iframe id="hidden_iframe" name="hidden_ifr" style="width:0; height:0; display: none;"></iframe>
			</div>
		  </div>
		</div>

	<?php 
		//echo form_close();
	}
	?>




	<?php 
	echo form_open($this->uri->uri_string(), array('id'=>'search_form','name'=>'search_form','method'=>'get'));
	?>
		<h2>재고 검색</h2>

		<div class="panel panel-default-flat">
		  <div class="panel-heading">
			<div style="display:inline-block; ">
				<?php echo form_dropdown('sfl', $sfl_select_options, $sfl, 'class="o_selectbox"'); ?>
				<?php echo form_input($search_text); ?>
				<button type="submit" class="btn btn-dark btn-xs">검색</button>
				<?php echo ($use_excel_download) ? $btn_excel_download : '' ?>
			</div>
		  </div>
		</div>

		<h2>
			<span style="display:inline-block; width:100px;">재고 목록</span>
		</h2>
		<div>
			<small>
				검색 <span style="color:red;font-weight:bold;"><?php echo $list['total_count'] ?></span> 건 / 전체 <span style="color:red;font-weight:bold;"><?php echo $inven_total_count ?></span> 건
			</small>
			<div style="position:absolute; bottom:4px; right:0;">
				<?php //echo form_dropdown('level', $level_select_options, $level, 'class="o_selectbox" onchange="document.search_form.submit();" '); ?>
				<?php echo form_dropdown('ofl', $ofl_select_options, $ofl, 'class="o_selectbox" onchange="document.search_form.submit();" '); ?>
			</div>
			
		</div>
		<hr style="clear:both; margin:0; height:0;" />
	<?php
	echo form_close();
	?>


	<div class="tbl_basic">
		<table class="table table-hover">
		<thead>
		<tr class='text-center'>
		  <th class='text-center'>NO</th>
		  <th>바코드</th>
		  <th>SKU</th>
		  <th>분류</th>
		  <th>상품명</th>
		  <th>수량</th>
		  <th>위치</th>
		  <th>브랜드</th>

		  <th>용량</th>
		  <th>단위</th>
		  <th>가로</th>
		  <th>세로</th>
		  <th>높이</th>
		  <th>무게</th>

		  <th>유통기한</th>
		  <th>매입일</th>
		  <th>매입가</th>
		  <th>매입처</th>
		  <!-- <th>매입몰</th> -->
		  <th>사진</th>

		  <th>관리/등록일</th>
		</tr>
		</thead>
		<tbody>
		<?php
		foreach($list['qry'] as $i => $o)
		{
			// 번호
			$num = ($list['total_count'] - $limit*($page-1) - $i);
		?>
		<tr class="text-center">
		  <td class="text-center"><?php echo $num ?></td>
		  <td><?php echo $o->barcode ?></td>
		  <td><?php echo $o->sku ?></td>
		  <td><?php echo $o->branch ?></td>
		  <td><?php echo $o->itm_name ?></td>
		  <td><?php echo $o->itm_qty ?></td>
		  <td><?php echo $o->location ?></td>
		  <td><?php echo $o->brand ?></td>

		  <td><?php echo $o->volume ?></td>
		  <td><?php echo $o->unit ?></td>
		  <td><?php echo $o->itm_garo ?></td>
		  <td><?php echo $o->itm_sero ?></td>
		  <td><?php echo $o->itm_height ?></td>
		  <td><?php echo $o->itm_weight ?></td>

		  <td><?php echo $o->exp_date ?></td>
		  <td><?php echo $o->buy_date ?></td>
		  <td><?php echo isset($o->buy_price) && '' != $o->buy_price ? number_format($o->buy_price).'원' : ''; ?></td>
		  <td><?php echo $o->vendor ?></td>
		  <!-- <td><?php echo $o->itm_mall_url ?></td> -->
		  <td><?php echo isset($o->itm_pic_url) && '' != $o->itm_pic_url ? '<img src="'.$o->itm_pic_url.'" style="width:100%; max-width: 100px;" />' : '' ?></td>
		  <td class="text-center">
			<a href="/admin/inven/write/<?php //echo $o->user_idx ?>"><button class="btn btn-secondary btn-xs">수정</button></a>
			<?php if($this->tank_auth->is_admin()) { ?>
			<a href="/admin/inven/del/<?php //echo $o->user_idx ?>" onclick="del_confirm('admin/inven/del/<?php //echo $o->user_idx ?>'); return false;"><button class="btn btn-danger btn-xs">삭제</button></a>
			<?php } ?>
			<div style="padding-top:5px; text-align:center;"><?php echo substr($o->created,0,10); ?></div>
		  </td>
		</tr>

		<?php
		}
		?>
		<tbody>
		</table>
	</div>

	<div style="text-align:center;"><?php echo $paging ?></div>


</div>
