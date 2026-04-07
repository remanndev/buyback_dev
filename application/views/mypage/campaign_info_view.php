<?php
// 카테고리메뉴
$selected_cmp_cate =  (isset($row->cmp_cate) ? $row->cmp_cate : set_value('campaign_cate'));
$cmp_cate_options = array('' => '카테고리를 선택해주세요.');

foreach($result_cate['qry'] as $i=>$cate) {
	$cmp_cate_options[$cate->cate_name] = $cate->cate_name;
}
?>
<style type="text/css">
  .campaign_ctnt {  }
  .campaign_ctnt dl { font-size: 16px; position: relative;}
  .campaign_ctnt dl dt { padding-left: 10px; }
  .campaign_ctnt dl dt::before { content:''; position:absolute; top: 4px; left:0; width: 4px; height: 16px; background-color: #666666; }
  .campaign_ctnt dl dd { padding: 5px 10px 10px 10px; }

  .campaign_ctnt figure img {
    max-width: 100%;
  }
</style>

	<div class="ctnt_wrap">
		<div class="ctnt_inside" style="padding: 0 15px;">
			<div class="row py_35">
				<div class="d-none d-lg-block col-lg-3">
					<!-- 마이페이지 사이드 메뉴 -->
					<?php $this->load->view('mypage/mypage_side_view'); ?>
				</div>
				<div class="col-12 col-lg-9">

					<!-- 캠페인 상세 -->
					<div id="campaign_write_wrap" class="contents_wrap">

						<h2 class="position_r">
							캠페인 내용 
							<span class="position_a" style="top:0; right:0; width: 50%; text-align: right;">
							  <?php if( isset($row->state) ) { ?>
								<button type="button" class="btn  btn-xs btn-<?php echo ('write' == $row->state) ? 'success' : 'silver'; ?>" disabled>작성중</button>
								<button type="button" class="btn  btn-xs btn-<?php echo ('submit' == $row->state) ? 'success' : 'silver'; ?>" disabled>제출</button>
								<button type="button" class="btn  btn-xs btn-<?php echo ('launch' == $row->state) ? 'primary' : 'silver'; ?>" disabled>런칭</button>
							  <?php } else { ?>
								<!-- <button type="button" class="btn  btn-xs btn-success-flat" disabled>작성중</button>
								<button type="button" class="btn  btn-xs btn-silver-flat" disabled>제출</button>
								<button type="button" class="btn  btn-xs btn-silver-flat" disabled>런칭</button> -->
							  <?php } ?>
							</span>
						</h2>
						<hr class="mb_30" />

						<!-- 목표기기 추가 샘플용 # 삭제하지 마세요. -->
						<div id="add_goal_sample" style="display:none;">
						  <div class="row mt_5">
							<div class="col-7"><input type="text" class="o_input campaign_input goal_device" style="width:100%; font-size:18px;" name="goal_device[]" value="" placeholder="기기명" autocomplete='off' /></div>
							<div class="col-3"><input type="text" class="o_input campaign_input goal_device" style="width:100%; font-size:18px;" name="goal_amt[]" value="" placeholder="수량" autocomplete='off' /></div>
							<div class="col-2"><button type="button" onclick="remove_goalbox(this);" class="btn_del_goal o_btn  btn-danger-flat" style="width:100%; line-height:40px;padding-top:0; padding-bottom:0; vertical-align: baseline;">X</button></div>
						  </div>
						  <hr class="clear_both" />
						</div>


						<div class="campaign_ctnt">

							<?php if( $result_cate['total_count'] > 0) { ?>
							<dl>
								<dt>캠페인 카테고리</dt>
								<dd><?php echo $selected_cmp_cate ?></dd>
							</dl>
							<?php } ?>

							<dl>
								<dt>캠페인 대표 이미지</dt>
								<dd><figure><?php echo isset($row->campaign_main_img) ? $row->campaign_main_img : ''; ?></figure></dd>
							</dl>

							<dl>
								<dt>캠페인 제목</dt>
								<dd><?php echo isset($row->cmp_title) ? $row->cmp_title : ''; ?></dd>
							</dl>

							<input type="hidden" name="org_link" value="<?php echo $org_row->org_link ?>" />
							<dl>
								<dt>단체명</dt>
								<dd><?php echo isset($row->cmp_org_name) ? $row->cmp_org_name : (isset($org_row->org_name) ? $org_row->org_name : ''); ?></dd>
							</dl>
							<dl>
								<dt>단체 소개</dt>
								<dd><?php echo isset($row->cmp_org_info) ? $row->cmp_org_info : (isset($org_row->org_info) ? $org_row->org_info : ''); ?></dd>
							</dl>

							<dl>
								<dt>홈페이지 링크</dt>
								<dd>
									<?php // echo isset($row->cmp_website) ? $row->cmp_website : (isset($org_row->org_link) ? $org_row->org_link : ''); ?>
									<?php echo isset($row->cmp_website) ? $row->cmp_website : ''; ?>
								</dd>
							</dl>

							<dl>
								<dt>모금 기간</dt>
								<dd>
									<?php echo isset($row->cmp_term_begin) ? $row->cmp_term_begin : ''; ?> ~ <?php echo isset($row->cmp_term_end) ? $row->cmp_term_end : ''; ?>
								</dd>
							</dl>
							
							<dl>
								<dt>모금 목표 금액</dt>
								<dd>
									<?php echo (isset($row->cmp_goal_money) && '' != $row->cmp_goal_money) ? number_format(intVal($row->cmp_goal_money)).'원' : ''; ?>
								</dd>
							</dl>

							<dl id="wrap_goal_device">
								<dt>목표 모금 수량</dt>
								<dd class="box_goal_wrap">
									<?php 
									// goal_device_1, goal_amt_1 부터~ 
									if(! empty($arr_device)) {
										foreach($arr_device as $i => $device) {
									?>
										<div class="box_goal_wrap"><?php echo $device ?> : <?php echo $arr_amt[$i] ?></div>
									<?php 
										}
									}
									?>
							</dl>

							<dl>
								<dt>캠페인 단락1 - 제목</dt>
								<dd><?php echo isset($row->ctnt_ttl_1) ? $row->ctnt_ttl_1 : ''; ?></dd>
								<dt>캠페인 단락1 - 내용</dt>
								<dd><?php echo isset($row->ctnt_detail_1) ? $row->ctnt_detail_1 : ''; ?></dd>
								<dt>캠페인 단락1 - 이미지</dt>
								<dd><?php echo isset($row->ctnt_file_img[1]) ? $row->ctnt_file_img[1] : ''; ?></dd>
							</dl>

							<dl>
								<dt>캠페인 단락2 - 제목</dt>
								<dd><?php echo isset($row->ctnt_ttl_2) ? $row->ctnt_ttl_2 : ''; ?></dd>
								<dt>캠페인 단락2 - 내용</dt>
								<dd><?php echo isset($row->ctnt_detail_2) ? $row->ctnt_detail_2 : ''; ?></dd>
								<dt>캠페인 단락2 - 이미지</dt>
								<dd><?php echo isset($row->ctnt_file_img[2]) ? $row->ctnt_file_img[2] : ''; ?></dd>
							</dl>

							<dl>
								<dt>캠페인 단락3 - 제목</dt>
								<dd><?php echo isset($row->ctnt_ttl_3) ? $row->ctnt_ttl_3 : ''; ?></dd>
								<dt>캠페인 단락3 - 내용</dt>
								<dd><?php echo isset($row->ctnt_detail_3) ? $row->ctnt_detail_3 : ''; ?></dd>
								<dt>캠페인 단락3 - 이미지</dt>
								<dd><?php echo isset($row->ctnt_file_img[3]) ? $row->ctnt_file_img[3] : ''; ?></dd>
							</dl>

							<dl>
								<dt>캠페인 기타 내용</dt>
								<dd><figure><?php echo isset($row->cmp_content) ? $row->cmp_content : ''; ?></figure></textarea>
								</dd>
							</dl>
						</div>


						<hr />
						<div class="pt-3 text-center dsp_flex_x_center">
							<a href="<?php echo base_url('mypage/campaign') ?>"><button type="button" class="btn  btn-dark o_btn_v50 btn-md me-2" style="margin:0 auto; width: 100px;">목록</button></a>
							<?php echo form_open(base_url('campaign/preview'), array('id'=>'campaign_preview','name'=>'campaign_preview','target'=>'_new')); ?>
								<input type="hidden" name="code" value="<?php echo $row->code ?>" />
								<input type="submit" name="submit" value="미리 보기" class="btn  btn-primary-flat o_btn_v50" style="margin:0 auto; width: 100px;" />
							<?php echo form_close(); ?>
						</div>

					</div>
				</div>
			</div>
		</div>
	</div>





	<script type="text/javascript">
		// datetimepicker
		/*
		$.datetimepicker.setLocale('kr');
		$('.datepicker').datetimepicker({
			lang:'kr',
			timepicker:false,
			format:'Y-m-d',
			formatDate:'Y/m/d'
		});
		*/

		$.datetimepicker.setLocale('kr');
		$('.datepicker').datetimepicker({
			lang:'kr',
			timepicker:false,
			format:'Y-m-d',
			scrollMonth : false 
		});
	</script>


	<script type="text/javascript">
		$R('#cmp_org_info', { 
			//focus: true,
			//toolbarExternal: '#my-external-toolbar',
			lang: 'ko',
			minHeight: '200px',
			maxHeight: '300px',
			buttonsHide: ['html','format','italic','lists','deleted']
		});

		$R('#campaign_content', { 
			//focus: true,
			//toolbarExternal: '#my-external-toolbar',
			lang: 'ko',
			minHeight: '500px',
			maxHeight: '1000px',
			plugins: ['fontsize','fontcolor','filemanager','video','table','alignment','inlinestyle','specialchars','textdirection','widget','fontfamily','fullscreen'],
			imageUpload: "/files/upload/redactor_image/<?php echo url_code('campaign/image','e') ?>/campaign/<?php echo isset($row->idx) ? $row->idx :''; ?>",
			fileUpload: "/files/upload/redactor_file/<?php echo url_code('campaign/files','e') ?>/campaign/<?php echo isset($row->idx) ? $row->idx :''; ?>",

			buttonsAddAfter: {
				after: 'deleted',
				buttons: ['underline','line', 'redo', 'undo', 'underline', 'ol', 'ul', 'sup', 'sub']
			},
			buttonsHide: ['lists']
		});
	</script>

	<script type="text/javascript">
		function form_check() {

			if( '' == $('select[name="campaign_cate"]').val() ) {
				alert('캠페인 카테고리를 선택하세요.');
				// $('#campaign_title').focus();
				return false;
			}
			else if( '' == $('#campaign_title').val() ) {
				alert('캠페인 제목을 입력하세요.');
				// $('#campaign_title').focus();
				return false;
			}
			else if( '' == $('#campaign_main_img_input').val() && '' == $('#file_idx_main_img').val() ) {
				alert('캠페인 메인 이미지을 등록하세요.');
				// $('#campaign_main_img_input').focus();
				return false;
			}
			else if( '' == $('#campaign_content').val() ) {
				alert('캠페인 내용을 입력하세요.');
				return false;
			}
			else if( '' == $('#goal_money').val() ) {
				alert('목표 기부 가치를 입력해주세요.');
				return false;
			}
			/*
			else if( '' == $('#goal_desc').val() ) {
				alert('목표 기기를 입력하세요.');
				return false;
			}
			*/
			else if( '' == $('#term_begin').val()  ||  '' == $('#term_end').val() ) {
				alert('모금 기간을 입력하세요.');
				return false;
			}
			else {
				return true;
			}

		}

		// 제출하기
		function submit_confirm(url) {
			if( confirm( '\n정말 제출하시겠습니까? \n제출하신 캠페인은 관리자의 승인을 거쳐 런칭됩니다.') ) {
				location.href = url;
			}
		}

		// 제출상태의 캠페인 작성 상태로 되돌리기
		function submit_recover(url) {
			if( confirm( '\n제출된 캠페인을 회수하시겠습니까? \n회수된 캠페인은 작성상태로 변경됩니다.') ) {
				location.href = url;
			}
		}
	</script>



	<script type="text/javascript">
	$(document).ready(function(){

		$('#goal_money').on('keyup',function() {
			var str = removeComma(trim($(this).val()));
			var n = addComma(str);
			//console.log(n);
			$('#goal_money').val(n);
		});

		// 캠페인 기간 오류 잡기
		$('.campaign_term').on('blur',function() {
			var term_begin = $('#term_begin').val();
			var term_end = $('#term_end').val();

			console.log(term_begin);
			console.log(term_end);
			if('' != term_begin && '' != term_end) {
				if(term_begin > term_end) {
					alert('모금(캠페인) 기간 시작일과 종료일이 맞지 않습니다.');
					$('#term_begin').val('');
					$('#term_end').val('');
				}
			}
		});

	});
	</script>
