<?php
/*
	// [1] 분류 - 캠페인 카테고리 배열
	$arr = array('sql_select' => '*','sql_from' => 'campaign_cate','sql_where' => array('use'=>'Y'), 'sql_order_by'=>'order ASC');
	$result_cate = $this->basic_model->arr_get_result($arr);

	$ca_code_options = array('' => '분류');
	foreach($result_cate['qry'] as $i=>$cate) {
		$ca_code_options[$cate->cate_name] = $cate->cate_name;
	}

	$cate_name_selected =  isset($cate_name) ? $cate_name : set_value('cate_name');
	$cate_name_selected = ('' != $cate_name_selected) ? $cate_name_selected : '분류';

	$cate_name_selected_val = ('' != $cate_name_selected && '분류' != $cate_name_selected ) ? $cate_name_selected : '';


	// [2] 정렬
	$ofl = $this->input->get('ofl',FALSE);
	$ordered_selected = ($ofl) ? $ofl : 'reg_datetime DESC';
	//echo $ordered_selected.'<<<<';
	$order_select_options = array(
					  'reg_datetime DESC'    => '등록일자 최신순',
					  'reg_datetime ASC'     => '등록일자 오래된순',

					  'cmp_term_end DESC'     => '종료임박',
					  'visit_cnt DESC'     => '조회수',
					);

	$ordered_selected_txt = isset($order_select_options[$ordered_selected]) ? $order_select_options[$ordered_selected] : '정렬';
	$ordered_selected_val = $ordered_selected;
*/
?>



<script type="text/javascript">
$(document).ready(function(){

	//var slt_cate = "<?php //echo $cate_name_selected_val ?>";
	//var slt_order = "<?php //echo $ordered_selected ?>";

	var slt_cate = $('#cate').val();
	var slt_order = $('#ofl').val();

	$('#cate_dropdown .dropdown-menu li > a').bind('click',function (e) {
		var cate_val = $(this).html();
		//$('#cate_dropdown button.dropdown-toggle').html(cate_val +' <span class="caret"></span>');
		$('#cate_dropdown button.dropdown-toggle').html(cate_val +' ');

		cate_val = (cate_val == '분류') ? '' : cate_val;
		$('#cate').val(cate_val);

		//document.search_form.submit();
		$('#search_form').submit();
	});

	$('#order_dropdown .dropdown-menu li > a').bind('click',function (e) {
		var order = $(this).html();
		var order_val = $(this).attr('alt');

		//console.log(order);
		//console.log(order_val);

		//$('#order_dropdown button.dropdown-toggle').html(order_val +' <span class="caret"></span>');
		$('#order_dropdown button.dropdown-toggle').html(order +' ');

		$('#ofl').val(order_val);
		//document.search_form.submit();
		$('#search_form').submit();
	});


	$('.dropdown-menu-cate-item').removeClass('on');
	$('.dropdown-menu-cate-item').each(function(){
		var $this = $(this);
		var cateVal = $this.data('value');
		//console.log(cateVal);

		if(slt_cate == cateVal) {
			$this.addClass('on');
		}
	});


	$('.dropdown-menu-order-item').removeClass('on');
	$('.dropdown-menu-order-item').each(function(){
		var $this = $(this);
		var cateVal = $this.data('value');
		//console.log(cateVal);

		if(slt_order == cateVal) {
			$this.addClass('on');
		}
	});

});
</script>





<div class="pc_wrap d-none d-lg-block">
<?php 
// [PC] 캠페인 목록
$this->load->view('campaign/lists_view_pc',$top_bnr_pc);
?>
</div>

<div class="mobile_wrap d-block d-lg-none">
<?php 
// [MOBILE] 캠페인 목록
$this->load->view('campaign/lists_view_mobile',$top_bnr_mobile);
?>
</div>




<div style="margin:15px auto 50px; text-align:center;">
	<?php echo $paging ?>
</div>






