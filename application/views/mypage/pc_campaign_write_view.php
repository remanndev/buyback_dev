
	<div class="container_wrap">
		<div class="contents_wrap wrap_limit">
			<div class="row py_35">
				<div class="d-none d-lg-block col-lg-3">
					<!-- 마이페이지 사이드 메뉴 -->
					<?php $this->load->view('mypage/mypage_side_view'); ?>
				</div>
				<div class="col-12 col-lg-9">

					<!-- 캠페인 상세 -->
					<div id="campaign_write_wrap" class="contents_wrap">

						<h2 class="position_r">
							캠페인 <?php echo isset($row->idx) ? '수정' :'만들기'; ?>
							<span class="position_a" style="top:0; right:0;">
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
							<div class="col-7"><input type="text" class="o_input campaign_input goal_device" style="width:100%; font-size:18px;" name="goal_device[]" value="" placeholder="기기명" /></div>
							<div class="col-3"><input type="text" class="o_input campaign_input goal_device" style="width:100%; font-size:18px;" name="goal_amt[]" value="" placeholder="수량" /></div>
							<div class="col-2"><button type="button" onclick="remove_goalbox(this);" class="btn_del_goal o_btn  btn-danger-flat" style="width:100%; line-height:48px;padding-top:0; padding-bottom:0; vertical-align: baseline;">X</button></div>
						  </div>
						  <hr class="clear_both" />
						</div>

						<?php echo form_open_multipart($this->uri->uri_string(), array('id'=>'campaign_form','name'=>'campaign_form', 'onsubmit'=>'return form_check();')); ?>

							<div class="campaign_ctnt">
								<dl>
									<dt>캠페인 제목</dt>
									<dd><input type="text" id="campaign_title" class="o_input campaign_input campaign_title" name="campaign_title" value="<?php echo isset($row->cmp_title) ? $row->cmp_title : ''; ?>" /></dd>
								</dl>
								<dl>
									<dt>목표 기부 가치</dt>
									<dd><input type="text" id="goal_money" class="o_input campaign_input cmp_goal_money" name="goal_money" value="<?php echo isset($row->cmp_goal_money) ? number_format($row->cmp_goal_money) : ''; ?>" maxlength="12" /><span class="money_unit">원</span></dd>
								</dl>
								<dl id="wrap_goal_device">
									<dt>목표 기기</dt>
									
									<dd class="box_goal_wrap">
									  <div class="mt_10 row">
										<div class="col-7"><input type="text" class="o_input campaign_input goal_device" style="width:100%; font-size:18px;" name="goal_device[]" value="<?php echo isset($row->goal_device_1) ? $row->goal_device_1 : ''; ?>" placeholder="기기명" /></div>
										<div class="col-3"><input type="text" class="o_input campaign_input goal_device" style="width:100%; font-size:18px; " name="goal_amt[]" value="<?php echo isset($row->goal_amt_1) ? $row->goal_amt_1 : ''; ?>" placeholder="수량" /></div>
										<?php //if(isset($row->state) && 'write' == $row->state) { ?>
										<div class="col-2"><button type="button" id="btn_add_goal" class="o_btn btn-dark-flat" style="width:100%; line-height:48px;padding-top:0; padding-bottom:0; vertical-align: baseline;">추가</button></div>
										<?php //} ?>
									  </div>

									  <hr class="clear_both" />
									</dd>
									

									<?php 
									// goal_device_2, goal_amt_2 부터~ 
									foreach($arr_device as $i => $device) {
									?>
									<dd class="box_goal_wrap">
									  <div class="mt_5 row">
										<div class="col-7"><input type="text" class="o_input campaign_input goal_device" style="width:100%; font-size:18px;" name="goal_device[]" value="<?php echo $device ?>" placeholder="기기명" /></div>
										<div class="col-3"><input type="text" class="o_input campaign_input goal_device" style="width:100%; font-size:18px;" name="goal_amt[]" value="<?php echo $arr_amt[$i] ?>" placeholder="수량" /></div>
										<?php if(isset($row->state) && 'write' == $row->state) { ?>
										<div class="col-2"><button type="button" onclick="remove_goalbox(this);" class="btn_del_goal o_btn  btn-danger-flat" style="width:100%; line-height:48px;padding-top:0; padding-bottom:0;  vertical-align: baseline;">X</button></div>
										<?php } ?>
									  </div>

									  <hr class="clear_both" />
									</dd>

									<?php } ?>
								</dl>

								<dl>
									<dt>모금 기간</dt>
									<dd class="mt_10">
									  <div class="row">
										<div class="col-6"><input type="text" id="term_begin" class="o_input campaign_input datepicker cmp_term_begin" name="term_begin" value="<?php echo isset($row->cmp_term_begin) ? $row->cmp_term_begin : ''; ?>" placeholder="시작일자" title="시작일자" /></div>
										<div class="col-6"><input type="text" id="term_end" class="o_input campaign_input datepicker cmp_term_end" name="term_end" value="<?php echo isset($row->cmp_term_end) ? $row->cmp_term_end : ''; ?>" placeholder="마감일자" title="마감일자" /></div>
									</dd>
								</dl>

								<dl>
									<dt>단체명</dt>
									<dd><input type="text" class="o_input campaign_input cmp_org_name" name="org_name" value="<?php echo isset($row->cmp_org_name) ? $row->cmp_org_name : ''; ?>" placeholder="단체명을 입력해주세요." title="단체명을 입력해주세요." /></dd>
								</dl>

								<dl>
									<dt>단체 소개</dt>
									<dd><textarea id="cmp_org_info" class="o_input campaign_input cmp_org_info" name="org_info" placeholder="간략하게 단체를 소개해주세요." title="간략하게 단체를 소개해주세요."><?php echo isset($row->cmp_org_info) ? $row->cmp_org_info : ''; ?></textarea></dd>
								</dl>


								<h2 class="cmp_side_ttl mb_10">캠페인 메인(목록) 이미지 <small class="ml_10" style="color:#ff9900; font-weight:normal;">4:3 비율의 이미지를 업로드 해주세요. (ex. 1200px : 900px)</small></h2>
								<label for="campaign_main_img_input" style="cursor:pointer;display:block;">
								  <figure id="image_container" class="campaign_main_img"><?php echo isset($row->campaign_main_img) ? $row->campaign_main_img : ''; ?></figure>
								</label>
								<input type="hidden" id="file_idx_main_img" value="<?php echo isset($row->file_idx) ? $row->file_idx : ''; ?>" />
								<input type="file" id="campaign_main_img_input" class="o_input campaign_main_image" name="campaign_main_image" accept="image/*" onchange="setThumbnail(event);"/>

								<script> 
								  function setThumbnail(event) { 
									$('#image_container').html('');
									var reader = new FileReader(); 
									reader.onload = function(event) { var img = document.createElement("img"); img.setAttribute("src", event.target.result); document.querySelector("figure#image_container").appendChild(img); }; 
									reader.readAsDataURL(event.target.files[0]);
								  }
								</script>

								<h2 class="cmp_side_ttl mt_40">캠페인 내용</h2>
								<div class="campaign_ctnt_wrap mt_10">
									<textarea id="campaign_content" class="o_input campaign_ctnt" name="campaign_content" placeholder="캠페인 내용을 입력해주세요." title="캠페인 내용을 입력해주세요."><?php echo isset($row->cmp_content) ? $row->cmp_content : ''; ?></textarea>
								</div>

							</div>


							<hr class="clear_both" />

							<hr style="border:none; border-top:1px solid silver; margin: 50px 0;">

							<div class="mb_20 text_center">

							<?php if( ! isset($row->state) ) { ?>
								<button type="submit" class="btn  btn-dark o_btn_v50" style="margin:0 auto; width: 100px;">저장</button>
								<a href="<?php echo base_url() ?>/mypage/campaign/"><button type="button" class="btn  btn-dark o_btn_v50" style="margin:0 auto; width: 100px;">목록</button></a>

							<?php } elseif(isset($row->state) && 'write' == $row->state) { ?>
								<button type="submit" class="btn  btn-dark o_btn_v50" style="margin:0 auto; width: 100px;">저장</button>
								<a href="<?php echo base_url() ?>/mypage/campaign/"><button type="button" class="btn  btn-dark o_btn_v50" style="margin:0 auto; width: 100px;">목록</button></a>
								<a href="#" onclick="del_confirm('mypage/campaign/del/<?php echo $row->idx ?>'); return false;"><button type="button" class="btn  btn-danger o_btn_v50" style="margin:0 auto; width: 100px;">삭제</button></a>

								<a href="#" onclick="submit_confirm('/mypage/campaign/submit/<?php echo $row->idx ?>'); return false;"><button type="button" class="btn  btn-success o_btn_v50" style="margin:0 auto; width: 100px;">제출하기</button></a>

							<?php } else { ?>
								<a href="<?php echo base_url() ?>/mypage/campaign/"><button type="button" class="btn  btn-dark o_btn_v50" style="margin:0 auto; width: 100px;">목록</button></a>
							<?php } ?>
							</div>

						<?php echo form_close(); ?>
					</div>


				</div>
			</div>
		</div>
	</div>





	<script type="text/javascript">
		// datetimepicker
		$.datetimepicker.setLocale('kr');
		$('.datepicker').datetimepicker({
			lang:'kr',
			timepicker:false,
			format:'Y-m-d',
			formatDate:'Y/m/d'
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

			if( '' == $('#campaign_title').val() ) {
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
			if( confirm( '정말 제출하시겠습니까? \n\n제출하신 캠페인은 관리자의 승인을 거쳐 런칭됩니다.') ) {
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

	});
	</script>
