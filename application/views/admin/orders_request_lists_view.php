<?php
/** - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
 * 검색
*/

// [1] 검색필드
	$sfl_select_options = array(
		//'all'       => '통합검색',
		'pr_order_id'   => '주문번호',
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
		'pr_datetime DESC'    => '주문일자 ↓',
		'pr_datetime ASC'     => '주문일자 ↑',
		'pr_total DESC'    => '총결제금액 ↓',
		'pr_total ASC'     => '총결제금액 ↑',
	);


/** - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
 * 카테고리 구분()
*/



// 구매의뢰(주문)내역 업로드 몰 선택
	$mall_select_options = array(
		'' => '몰을 선택해주세요.',
		'coscorea.com'  => '코스코리아',
		'ccorea.com'    => '씨코리아',
		'ebay_usa1'      => '이베이_미국1',
		'ebay_usa2'      => '이베이_미국2',
		'ebay_uk'       => '이베이_영국',
		'ebay_de'       => '이베이_독일',
		'ebay_au'       => '이베이_호주',
	);


/** - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
 * 엑셀 업로드/다운로드 사용 여부
*/
	$use_excel_upload = true;
	$use_excel_download = true;
?>
<div class="admin_wrap" style="max-width:100%;">

	<h1>구매의뢰 목록</h1>

	<?php 
	/**
	 | - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	 | 재고 목록 엑셀 업로드
	 */

	if($use_excel_upload) {
		//echo form_open($this->uri->uri_string(), array('id'=>'excel_form','name'=>'excel_form'));
	?>

		<h2>구매의뢰(주문) 목록 엑셀 업로드</h2>

		<div class="panel panel-default-flat">
		  <div class="panel-heading">
			<div style="position:relative;">
				

				<!-- 엑셀 업로드 -->
				<form name="excel_inven_upload" action="<?php echo base_url() ?><?php echo $this->uri->uri_string() ?>" method="post" enctype="multipart/form-data" target="hidden_ifr" onsubmit="return chk_upload_excel();">
					
					<?php echo form_dropdown('mall', $mall_select_options, '', 'id="arr_mall" class="o_selectbox"'); ?>

					<input type="hidden" name="chk_excel" value="upload" />
					<input type="file" name="excel_file" id="excel_file" class="o_input_file" style="border:none; display:inline-block; background-color:#dddddd;" />
					<input type="submit" name="excel_upload_submit" class="o_input" value="엑셀 업로드" />
				</form>
				<script type="text/javascript">
				function chk_upload_excel() {
					if($('#arr_mall').val() == '') {
						alert('온라인 몰을 먼저 선택해주세요.');
						return false;
					}
					else if($('#excel_file').val() == '') {
						alert('엑셀 파일을 선택해주세요.');
						return false;
					}
					return true;
				}
				</script>

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
		<h2>구매의뢰(주문)내역 검색</h2>

		<div class="panel panel-default-flat">
		  <div class="panel-heading">
			<div style="display:inline-block; ">
				<?php echo form_dropdown('pr_mall', $mall_select_options, $pr_mall, 'class="o_selectbox" onchange="document.search_form.submit();"'); ?>
				<?php echo form_dropdown('ofl', $ofl_select_options, $ofl, 'class="o_selectbox" onchange="document.search_form.submit();" '); ?>
				#
				<?php echo form_dropdown('sfl', $sfl_select_options, $sfl, 'class="o_selectbox"'); ?>
				<?php echo form_input($search_text); ?>
				<button type="submit" class="btn btn-dark btn-xs">검색</button>
				<?php echo ($use_excel_download) ? $btn_excel_download : '' ?>
			</div>

			<div style="position:absolute; bottom:10px; right:10px;">
				<?php //echo form_dropdown('level', $level_select_options, $level, 'class="o_selectbox" onchange="document.search_form.submit();" '); ?>
				<?php //echo form_dropdown('ofl', $ofl_select_options, $ofl, 'class="o_selectbox" onchange="document.search_form.submit();" '); ?>
			</div>

		  </div>
		</div>

		<h2>
			<span style="display:inline-block; width:200px;">구매의뢰(주문) 목록</span>
		</h2>
		<div>
			<small>
				검색 <span style="color:red;font-weight:bold;"><?php echo $list['total_count'] ?></span> 건 / 전체 <span style="color:red;font-weight:bold;"><?php echo $inven_total_count ?></span> 건
			</small>
			<div style="position:absolute; bottom:4px; right:0;">
				<?php //echo form_dropdown('level', $level_select_options, $level, 'class="o_selectbox" onchange="document.search_form.submit();" '); ?>
				<?php //echo form_dropdown('ofl', $ofl_select_options, $ofl, 'class="o_selectbox" onchange="document.search_form.submit();" '); ?>
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
		  <th>담당자</th>
		  <th>몰</th>
		  <th>구매의뢰 순번</th>
		  <th>구매의뢰주문번호</th>
		  <th>총금액</th>
		  <th>상태</th>
		  <th>구매일시</th>
		  <th>구매자정보</th>
		  <!-- <th>관리</th> -->
		  <th>수정/등록일</th>
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
		  <td><?php echo $o->manager ?></td>
		  <td><?php echo $o->pr_mall ?></td>
		  <td><?php echo $o->pr_order_num ?></td>
		  <td><a href="/admin/orders/request_detail/<?php echo $o->pr_order_id ?>"><?php echo $o->pr_order_id ?></a></td>
		  <td><?php echo isset($o->pr_total) && '' != $o->pr_total ? $o->currency.' '.$o->pr_total : ''; ?></td>
		  <td><?php echo $o->pr_status ?></td>
		  <td>
			<?php echo $o->pr_datetime ?><br /><?php echo $o->pr_datetime_org ?>
		  </td>
		  <td style="text-align:left;">
			<?php echo $o->buyer_info ?>
		  </td>
		  <!-- <td class="text-center"><a href="/admin/orders/request_detail/<?php echo $o->idx ?>"><button class="btn btn-secondary btn-xs">관리</button></a></td> -->
		  <td class="text-center">
			<a href="/admin/orders/request_form/<?php //echo $o->user_idx ?>"><button class="btn btn-secondary btn-xs">수정</button></a>
			<?php if($this->tank_auth->is_admin()) { ?>
			<!-- <a href="/admin/orders/request_del/<?php //echo $o->user_idx ?>" onclick="del_confirm('admin/orders/request_del/<?php //echo $o->user_idx ?>'); return false;"><button class="btn btn-danger btn-xs">삭제</button></a> -->
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
