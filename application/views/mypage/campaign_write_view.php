<style type="text/css">
.goal_number::after {
	content: '대';
	display: block;
	position:absolute;
	top:10px;
	right:20px;
}
.ctnt_input {
	width: 100%;
	font-size: 15px;
	padding: 5px 15px;
}
.ctnt_detail {
	width: 100%;
	min-height: 200px;
	font-size: 15px;
	padding: 5px 15px;
}

/*
.campaign_ctnt {}
.campaign_ctnt dl {}
.campaign_ctnt dl dt {
	padding-left: 10px;
	border-bottom: 1px dashed #666666;
}
.campaign_ctnt dl dt::before {
    content: '';
    position: absolute;
    top: 6px;
    left: 0;
    width: 4px;
    height: 22px;
    background-color: #666666;
}
*/
</style>
<?php
// 카테고리메뉴
$selected_cmp_cate =  (isset($row->cmp_cate) ? $row->cmp_cate : set_value('campaign_cate'));
$cmp_cate_options = array('' => '카테고리를 선택해주세요.');

foreach($result_cate['qry'] as $i=>$cate) {
	$cmp_cate_options[$cate->cate_name] = $cate->cate_name;
}

//print_r($row);

?>
	<div class="ctnt_wrap">
		<div class="ctnt_inside">
			<div class="row py_35">
				<div class="d-none d-lg-block col-lg-3">
					<!-- 마이페이지 사이드 메뉴 -->
					<?php $this->load->view('mypage/mypage_side_view'); ?>
				</div>
				<div class="col-12 col-lg-9">

					<!-- 캠페인 상세 -->
					<div id="campaign_write_wrap" class="contents_wrap">

						<h2 class="position_r">
							캠페인 <?php echo isset($row->idx) ? '수정' :'개설'; ?>
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

						<?php echo form_open_multipart($this->uri->uri_string(), array('id'=>'campaign_form','name'=>'campaign_form', 'onsubmit'=>'return form_check();')); ?>

							<div class="campaign_ctnt">

								<?php if( $result_cate['total_count'] > 0) { ?>
								<dl>
									<dt>캠페인 카테고리</dt>
									<dd>
										<?php echo form_dropdown('campaign_cate', $cmp_cate_options, $selected_cmp_cate, 'class="form-control o_selectbox campaign_input" style="width:auto; height:40px; padding-right: 30px; vertical-align:middle; background-color:#f7f7f7;"'); ?>
										<?php echo form_error('campaign_cate','<div class="err_color_red">','</div>'); ?>
									</dd>
								</dl>
								<?php } ?>

								<dl>
									<dt><strong>캠페인 대표 이미지</strong> <small class="ml_10" style="color:#ff9900; font-weight: bold;">4:3 비율의 이미지를 업로드 해주세요. (ex. 1200px : 900px)</small></dt>
									<dd>
										<label for="campaign_main_img_input" style="cursor:pointer;display:block;">
										  <figure id="image_container" class="campaign_main_img"><?php echo isset($row->campaign_main_img) ? $row->campaign_main_img : ''; ?></figure>
										</label>
										<input type="hidden" id="file_idx_main_img" value="<?php echo isset($row->file_idx) ? $row->file_idx : ''; ?>" />
										<input type="file" id="campaign_main_img_input" class="o_input campaign_main_image" name="campaign_main_image" accept="image/*" onchange="setThumbnail(event);"/>
									</dd>
								</dl>
								<script> 
								  function setThumbnail(event) { 
									$('#image_container').html('');
									var reader = new FileReader(); 
									reader.onload = function(event) {
										var img = document.createElement("img"); 
										var fsize = event.loaded;
										if( fsize < 5222193 ) {
											img.setAttribute("src", event.target.result); 
											document.querySelector("figure#image_container").appendChild(img);
										}
										else {
											alert('5MB 이하의 이미지를 올려주세요.');
											$('#campaign_main_img_input').val('');
										}
									}; 
									reader.readAsDataURL(event.target.files[0]);
								  }
								</script>

								<dl>
									<dt><strong>캠페인 제목</strong></dt>
									<dd><input type="text" id="campaign_title" class="o_input campaign_input campaign_title" name="campaign_title" value="<?php echo isset($row->cmp_title) ? $row->cmp_title : ''; ?>" autocomplete='off' /></dd>
								</dl>

								<?php
								// 단체명 및 단체 소개 내용
								$company_name = isset($company) ? $company : '';
								$company_info = isset($company_info) ? $company_info : '';
								?>
								<input type="hidden" name="org_link" value="<?php echo $org_row->org_link ?>" />
								<dl>
									<dt><strong>단체명</strong></dt>
									<dd><input type="text" class="o_input campaign_input cmp_org_name" name="org_name" value="<?php echo isset($company_name) ? $company_name : ''; ?>" placeholder="단체명은 수정할 수 없습니다." title="단체명은 수정할 수 없습니다." autocomplete='off' <?php echo (isset($company_name) && '' != $company_name) ? 'readonly' : ''; ?> style="color: #000000; background-color: #f4f4f4;" /></dd>
								</dl>

								<dl>
									<dt><strong>단체 소개</strong> <small class="ml_10" style="color:#ff9900; font-weight: bold;">20줄 이내로 작성</small></dt>
									<dd><textarea id="cmp_org_info" class="o_input campaign_input cmp_org_info" name="cmp_org_info" placeholder="간략하게 단체를 소개해주세요." title="간략하게 단체를 소개해주세요.">
										<?php //echo isset($company_info) ? $company_info : ''; ?>
										<?php echo isset($row->cmp_org_info) ? $row->cmp_org_info : $company_info; ?>
									</textarea></dd>
								</dl>

								<dl>
									<dt><strong>홈페이지 링크</strong></dt>
									<dd><input type="text" class="o_input campaign_input cmp_website" style="width: 100%;" name="cmp_website" value="<?php echo isset($row->cmp_website) ? $row->cmp_website : ''; ?>" placeholder="http 또는 https 로 시작하는 주소를 입력해주세요. (예: https://replus.kr)" autocomplete='off' /></dd>
								</dl>


								<dl>
									<dt><strong>모금 기간</strong></dt>
									<dd class="mt_10">
									  <div class="row">
										<div class="col-6"><input type="text" id="term_begin" class="o_input campaign_input campaign_term datepicker cmp_term_begin" name="term_begin" maxlength="10" value="<?php echo isset($row->cmp_term_begin) ? $row->cmp_term_begin : ''; ?>" placeholder="시작일자" title="시작일자" autocomplete="off" /></div>
										<div class="col-6"><input type="text" id="term_end" class="o_input campaign_input campaign_term datepicker cmp_term_end" name="term_end" maxlength="10" value="<?php echo isset($row->cmp_term_end) ? $row->cmp_term_end : ''; ?>" placeholder="마감일자" title="마감일자" autocomplete="off" /></div>
									</dd>
								</dl>


								<!--[2024-12-03] 모금 목표 금액 -->
								<dl>
									<dt><strong>모금 목표 금액</strong></dt>
									<dd><input type="text" id="goal_money" class="o_input campaign_input cmp_goal_money" name="goal_money" value="<?php echo (isset($row->cmp_goal_money) && '' != $row->cmp_goal_money) ? number_format($row->cmp_goal_money) : ''; ?>" maxlength="12" autocomplete='off' /><span class="money_unit">원</span></dd>
								</dl>



								<?php 
								  $saved_device = array(
									isset($row->goal_device_1) ? $row->goal_device_1 : '',
									isset($row->goal_device_2) ? $row->goal_device_2 : '',
									isset($row->goal_device_3) ? $row->goal_device_3 : '',
									isset($row->goal_device_4) ? $row->goal_device_4 : '',
									isset($row->goal_device_5) ? $row->goal_device_5 : ''
								  );
								?>

								<style>
								  #box_add_goal { margin-top: 10px; margin-bottom: 10px; width: 100%; max-width: 432px; padding: 3px; font-size: 15px;  }
								  #box_add_goal .add_goal { margin: 5px 0; padding: 5px 0 3px 12px; border-bottom: 1px dashed silver; }
								  #box_add_goal .add_goal:before {content: '';position: absolute;top: 46%;left: 0;width: 4px;height: 4px;background-color: #666666;}
								  #box_add_goal .add_goal .g_device {width: 50%; font-weight: bold; }
								  #box_add_goal .add_goal .g_amt {width: 30%; text-align: right; padding-right: 20px;  font-weight: bold;}
								  #box_add_goal .add_goal .g_del {width: 20%; text-align: right; }
								  #box_add_goal .add_goal .g_amt:after {content: '대';position: absolute;top: 0;right: 0;}
								</style>

								<script>
									/* - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - */
									/* 캠페인 만들기 # 목표기기 추가 */
										$(document).ready(function() {

											$('#btn_goal_add').on('click', function(){

												let html = '';

												let device = $('#goal_device').val();
												let amt = $('#goal_amt').val();

												if('' == device || '' == amt) {
													alert('목표기기와 수량은 필수입니다.');
													return false;
												}
												else {

													html = '<div class="add_goal dsp_flex_sp_between">';
													html += '  <div class="g_device">'+device+'<input type="hidden" name="goal_device[]" value="'+device+'" /></div>';
													html += '  <div class="g_amt">'+amt+'<input type="hidden" name="goal_amt[]" value="'+amt+'" /></div>';
													html += '  <div class="g_del"><button type="button" class="goal_del btn btn-danger btn-xs">삭제</button></div>';
													html += '</div>';

													cnt = $('.add_goal').length;

													if( cnt < 5 ) {
														$('#box_add_goal').append(html);
														$('#goal_amt').val('');
													}
													else {
														alert('최대 5개까지 등록 가능합니다.');
													}
												}
											});
											
										});

										// 목표 모금 수량 삭제
										$(document).on('click','.goal_del', function() {
											$(this).parent().parent().remove();
										});
								</script>

								<dl id="wrap_goal_device">
									<dt><strong>목표 모금 수량</strong></dt>
									
									<dd class="box_goal_wrap">
									  <div class="row">
										<div class="col-7">
											<?php /* 
											<select id="goal_device" class="campaign_input" style="width: 100%; height: 42px; border: 1px solid #cccccc">
											  <option value="노트북-일반업무용">노트북-일반업무용</option>
											  <option value="노트북-해외지원용">노트북-해외지원용</option>
											  <option value="PC(데스크탑+모니터)">PC(데스크탑+모니터)</option>
											  <option value="태블릿PC 및 핸드폰">태블릿PC 및 핸드폰</option>
											  <option value="태블릿">태블릿</option>
											</select>
											*/ ?>

											<select id="goal_device" class="campaign_input" style="width: 100%; height: 42px; border: 1px solid #cccccc">
											  <option value="(재제조) 업무용 노트북 ">(재제조) 업무용 노트북 </option>
											  <option value="(재제조) 해외지원용 노트북">(재제조) 해외지원용 노트북</option>
											  <option value="(재제조) PC 데스크탑+모니터">(재제조) PC 데스크탑+모니터</option>
											  <option value="(재제조) 태블릿 PC ">(재제조) 태블릿 PC </option>
											</select>

										</div>
										<div class="col-3 goal_number"><input type="text" id="goal_amt" class="o_input campaign_input goal_device goal_cnt" style="width:100%; font-size:18px; " value="" placeholder="수량(숫자만)" autocomplete='off' maxlength="10" /></div>
										<div class="col-2"><button type="button" id="btn_goal_add" class="o_btn btn-dark-flat" style="width:100%; line-height:40px;padding-top:0; padding-bottom:0; vertical-align: baseline;">추가</button></div>
									  </div>

									  <hr class="clear_both" />

									  <div id="box_add_goal">
										<?php 
										foreach($arr_device as $i => $device) {
										?>
											<div class="add_goal dsp_flex_sp_between">
											  <div class="g_device"><?php echo $saved_device[$i] ?><input type="hidden" name="goal_device[]" value="<?php echo $saved_device[$i] ?>" /></div>
											  <div class="g_amt"><?php echo $arr_amt[$i] ?><input type="hidden" name="goal_amt[]" value="<?php echo $arr_amt[$i] ?>" /></div>
											  <div class="g_del"><button type="button" class="goal_del btn btn-danger btn-xs">삭제</button></div>
											</div>
										<?php } ?>
									  </div>
									</dd>
								</dl>




								<style type="text/css">
								.tbl_device_guide {}
								.tbl_device_guide table { width: 100%; text-align: center; }
								.tbl_device_guide table tr th { background-color: #dae9f7; }
								.tbl_device_guide table tr td {  }
								.tbl_device_guide table tr th,
								.tbl_device_guide table tr td { border: 1px solid #616161; padding: 5px; }
								ul.ul_device_guide { padding-left: 5px;}
								ul.ul_device_guide li { list-style-type: '\2d'; padding: 0 0 0 10px; }
								</style>

								<div class="tbl_device_guide">
									<table cellpadding="0" cellspacing="0">
									  <tr>
									    <th>재제조 디지털기기 종류</th>
										<th>목표 모금 금액<span style="color: red;">(1대 기준)</span></th>
									  </tr>
									  <tr>
										<td>(재제조) 업무용 노트북</td>
										<td>약 40만원</td>
									  </tr>
									  <tr>
										<td>(재제조) 해외지원용 노트북</td>
										<td>약 30만원</td>
									  </tr>
									  <tr>
										<td>(재제조) PC 데스크탑+모니터</td>
										<td>약 35만원</td>
									  </tr>
									  <tr>
										<td>(재제조) 태블릿 PC </td>
										<td>약 33만원</td>
									  </tr>
									</table>
								</div>
								<ul class="ul_device_guide" style="margin: 10px 0 25px;">
									<li>평균적으로 재제조 노트북 1대를 만들기 위해서는 25대의 노트북 모금이 필요합니다.</li>
									<li>필요 기기의 구체적인 사양에 따라 목표 모금 수량은 변동될 수 있습니다.</li>
								</ul>

								<dl>
									<dt><strong>캠페인 단락1</strong></dt>
									<dd>
										<input type="text" id="ctnt_ttl_1" class="o_input ctnt_input" name="ctnt_ttl_1" value="<?php echo isset($row->ctnt_ttl_1) ? $row->ctnt_ttl_1 : ''; ?>" autocomplete='off' placeholder="(제목) 비영리단체 및 수혜자의 상황을 한 문장으로 작성해주세요." title="(제목) 비영리단체 및 수혜자의 상황을 한 문장으로 작성해주세요." />
									</dd>
									<dd>
										<textarea id="ctnt_detail_1" class="o_input ctnt_detail" name="ctnt_detail_1" placeholder="(내용) 모금이 필요한 비영리단체 현재 상황 또는 수혜자의 사연을 구체적으로 소개해 주세요.  " title="(내용) 모금이 필요한 비영리단체 현재 상황 또는 수혜자의 사연을 구체적으로 소개해 주세요.  "><?php echo isset($row->ctnt_detail_1) ? $row->ctnt_detail_1 : ''; ?></textarea>
									</dd>
									<dd>
										<label for="ctnt_img_1" style="cursor:pointer;display:block;">
										  <figure id="ctnt_img_container_1" class="campaign_ctnt_img"><?php echo isset($row->ctnt_file_img[1]) ? $row->ctnt_file_img[1] : ''; ?></figure>
										</label>
										<input type="hidden" id="file_idx_ctnt_img_1" value="<?php echo isset($row->ctnt_file_idx[1]) ? $row->ctnt_file_idx[1] : ''; ?>" />
										<input type="file" id="ctnt_img_1" class="o_input campaign_ctnt_image" name="campaign_ctnt_image_1" accept="image/*" onchange="setThumbnail_ctnt(event,'ctnt_img_container_1','ctnt_img_1');"/>
									</dd>
								</dl>
								<dl>
									<dt><strong>캠페인 단락2</strong></dt>
									<dd>
										<input type="text" id="ctnt_ttl_2" class="o_input ctnt_input" name="ctnt_ttl_2" value="<?php echo isset($row->ctnt_ttl_2) ? $row->ctnt_ttl_2 : ''; ?>" autocomplete='off' placeholder="(제목) 디지털기기의 필요성과 활용 계획을 한 문장으로 작성해주세요 " title="(제목) 디지털기기의 필요성과 활용 계획을 한 문장으로 작성해주세요 " />
									</dd>
									<dd>
										<textarea id="ctnt_detail_2" class="o_input ctnt_detail" name="ctnt_detail_2" placeholder="(내용) 디지털기기가 왜 필요한지, 받으신 이후에 어떻게 사용할 계획인지 구체적으로 작성해주세요." title="(내용) 디지털기기가 왜 필요한지, 받으신 이후에 어떻게 사용할 계획인지 구체적으로 작성해주세요."><?php echo isset($row->ctnt_detail_2) ? $row->ctnt_detail_2 : ''; ?></textarea>
									</dd>
									<dd>
										<label for="ctnt_img_2" style="cursor:pointer;display:block;">
										  <figure id="ctnt_img_container_2" class="campaign_ctnt_img"><?php echo isset($row->ctnt_file_img[2]) ? $row->ctnt_file_img[2] : ''; ?></figure>
										</label>
										<input type="hidden" id="file_idx_ctnt_img_2" value="<?php echo isset($row->ctnt_file_idx[2]) ? $row->ctnt_file_idx[2] : ''; ?>" />
										<input type="file" id="ctnt_img_2" class="o_input campaign_ctnt_image" name="campaign_ctnt_image_2" accept="image/*" onchange="setThumbnail_ctnt(event,'ctnt_img_container_2','ctnt_img_2');"/>
									</dd>
								</dl>


								<dl>
									<dt><strong>캠페인 단락3</strong></dt>
									<dd>
										<input type="text" id="ctnt_ttl_3" class="o_input ctnt_input" name="ctnt_ttl_3" value="<?php echo isset($row->ctnt_ttl_3) ? $row->ctnt_ttl_3 : ''; ?>" autocomplete='off' placeholder="(제목) 모금으로 기대되는 비영리단체 및 수혜자의 변화를 한 문장으로 작성해주세요. " title="(제목) 모금으로 기대되는 비영리단체 및 수혜자의 변화를 한 문장으로 작성해주세요. " />
									</dd>
									<dd>
										<textarea id="ctnt_detail_3" class="o_input ctnt_detail" name="ctnt_detail_3" placeholder="(내용) 모금으로 기대되는 변화를 상상해 보고, 그 모습을 함께 나누어 기부자의 참여를 이끌어내 주세요." title="(내용) 모금으로 기대되는 변화를 상상해 보고, 그 모습을 함께 나누어 기부자의 참여를 이끌어내 주세요."><?php echo isset($row->ctnt_detail_3) ? $row->ctnt_detail_3 : ''; ?></textarea>
									</dd>
									<dd>
										<label for="ctnt_img_3" style="cursor:pointer;display:block;">
										  <figure id="ctnt_img_container_3" class="campaign_ctnt_img"><?php echo isset($row->ctnt_file_img[3]) ? $row->ctnt_file_img[3] : ''; ?></figure>
										</label>
										<input type="hidden" id="file_idx_ctnt_img_3" value="<?php echo isset($row->ctnt_file_idx[3]) ? $row->ctnt_file_idx[3] : ''; ?>" />
										<input type="file" id="ctnt_img_3" class="o_input campaign_ctnt_image" name="campaign_ctnt_image_3" accept="image/*" onchange="setThumbnail_ctnt(event,'ctnt_img_container_3','ctnt_img_3');"/>
									</dd>
								</dl>
								<script> 
								  function setThumbnail_ctnt(event,img_figure,id_input_file) { 
									$('#'+img_figure).html('');
									var reader = new FileReader(); 
									reader.onload = function(event) { 
										var img = document.createElement("img"); 
										var fsize = event.loaded;
										if( fsize < 5222193 ) {
											img.setAttribute("src", event.target.result); 
											document.querySelector("figure#"+img_figure).appendChild(img); 
										}
										else {
											alert('5MB 이하의 이미지를 올려주세요.');
											$('#'+id_input_file).val('');
										}
									}; 
									reader.readAsDataURL(event.target.files[0]);
								  }
								</script>
								<dl>
									<dt title="필요시 캠페인 추가 내용, 콘텐츠 링크, 기타 사진 등을 입력해주세요."><strong>기타 내용 (선택사항)</strong></dt>
									<dd>
										<textarea id="campaign_content" class="o_input campaign_ctnt" name="campaign_content" placeholder="캠페인 추가 내용, 콘텐츠 링크, 기타 사진" ><?php echo isset($row->cmp_content) ? $row->cmp_content : ''; ?></textarea>
									</dd>
								</dl>

							</div>


							<hr class="clear_both" />

							<hr style="border:none; border-top:1px solid silver; margin: 50px 0;">


							<div>
							<?php if( ! isset($row->state) ) { ?>
							  <div class="dsp_flex_sp_between">
								<button type="submit" class="btn  btn-dark o_btn_v50" style="margin:0 auto; width: 100px;">저장</button>
								<!-- <a href="<?php echo base_url('mypage/campaign') ?>"><button type="button" class="btn  btn-dark o_btn_v50" style="margin:0 auto; width: 100px;">목록</button></a> -->
							  </div>

							<?php } elseif(isset($row->state) && 'write' == $row->state) { ?>
							  <div class="dsp_flex_sp_between">
								<!-- <a href="<?php echo base_url('mypage/campaign') ?>"><button type="button" class="btn  btn-dark o_btn_v50" style="margin:0 auto; width: 100px;">목록</button></a> -->

								<div>
									<button type="submit" class="btn btn-dark o_btn_v50" style="margin:0 auto; width: 100px;">저장</button>

									<button type="button" id="btn_preview" class="btn btn-primary-flat o_btn_v50" style="margin:0 auto; width: 100px;">미리 보기</button>

									<a href="#" onclick="submit_confirm('/mypage/campaign/submit/<?php echo $row->idx ?>'); return false;"><button type="button" class="btn  btn-success o_btn_v50" style="margin:0 auto; width: 100px;">제출하기</button></a>
								</div>

								<a href="#" onclick="del_confirm('mypage/campaign/del/<?php echo $row->idx ?>'); return false;"><button type="button" class="btn  btn-danger o_btn_v50" style="margin:0 auto; width: 100px;">삭제</button></a>
							  </div>
							<?php } else { ?>
							  <div class="dsp_flex_sp_between">
								<!-- <a href="<?php echo base_url('mypage/campaign') ?>"><button type="button" class="btn  btn-dark o_btn_v50" style="margin:0 auto; width: 100px;">목록</button></a> -->
								<?php if('submit' == $row->state) { ?>
								<a href="#" onclick="submit_recover('/mypage/campaign/recover/<?php echo $row->idx ?>'); return false;"><button type="button" class="btn  btn-secondary o_btn_v50" style="margin:0 auto; width: 100px;">회수하기</button></a>
								<?php } ?>
							  </div>
							<?php } ?>
							</div>

						<?php echo form_close(); ?>
					</div>


				</div>
			</div>
		</div>
	</div>


	<?php echo form_open(base_url('campaign/preview'), array('id'=>'campaign_preview','name'=>'campaign_preview','target'=>'_new','onsubmit'=>'return preview_check();')); ?>
		<input type="hidden" name="code" value="<?php echo isset($row->code) ? $row->code : ''; ?>" />
		<input type="submit" id="preview_submit" name="submit" value="미리 보기" class="btn  btn-primary-flat o_btn_v50" style="margin:0 auto; width: 100px; display: none;" />
	<?php echo form_close(); ?>

	<script type="text/javascript">
	$(document).ready(function(){
		$('#btn_preview').on('click', function() {
			$('#preview_submit').trigger('click');
		});
	});
	</script>

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
			//plugins: ['fontsize','fontcolor','filemanager','video','table','alignment','inlinestyle','specialchars','textdirection','widget','fontfamily','fullscreen'],
			plugins: ['fontsize','fontcolor','video','table','alignment','specialchars','widget'],
			imageUpload: "/files/upload/redactor_image/<?php echo url_code('campaign/image','e') ?>/campaign/<?php echo isset($row->idx) ? $row->idx :''; ?>",
			fileUpload: "/files/upload/redactor_file/<?php echo url_code('campaign/files','e') ?>/campaign/<?php echo isset($row->idx) ? $row->idx :''; ?>",

			/*
			buttonsAddAfter: {
				after: 'deleted',
				buttons: ['underline','line', 'redo', 'undo', 'underline', 'ol', 'ul', 'sup', 'sub']
			},
			*/
			buttonsHide: ['lists']
		});
	</script>

	<script type="text/javascript">
		function form_check() {

			/*
			console.log( $('#ctnt_img_1').val() );
			console.log( $('#file_idx_ctnt_img_1').val() );
			return false;
			*/

			if($('select[name="campaign_cate"]').val()  &&  '' == $('select[name="campaign_cate"]').val() ) {
				alert('캠페인 카테고리를 선택하세요.');
				// $('#campaign_title').focus();
				//console.log( 'category is exist' );
				return false;
			}
			else if( '' == $('#campaign_title').val() ) {
				alert('캠페인 제목을 입력하세요.');
				// $('#campaign_title').focus();
				return false;
			}
			else if( '' == $('#term_begin').val()  ||  '' == $('#term_end').val() ) {
				alert('모금 기간을 입력하세요.');
				return false;
			}
			else if( '' == $('#campaign_main_img_input').val() && '' == $('#file_idx_main_img').val() ) {
				alert('캠페인 메인 이미지을 등록하세요.');
				// $('#campaign_main_img_input').focus();
				return false;
			}
			/*
			else if( '' == $('#campaign_content').val() ) {
				alert('캠페인 기타 내용을 입력하세요.');
				return false;
			}
			*/

			/* [2023-05-23]
			else if( '' == $('#goal_money').val() ) {
				alert('목표 기부 가치를 입력해주세요.');
				return false;
			}
			*/
			/*
			else if( '' == $('#goal_desc').val() ) {
				alert('목표 기기를 입력하세요.');
				return false;
			}
			*/

			else if( '' == $('#ctnt_ttl_1').val() ) {
				alert('캠페인 단락1 제목을 입력하세요.');
				return false;
			}
			else if( '' == $('#ctnt_detail_1').val() ) {
				alert('캠페인 단락1 내용을 입력하세요.');
				return false;
			}
			else if( '' == $('#ctnt_img_1').val() && '' == $('#file_idx_ctnt_img_1').val() ) {
				alert('캠페인 단락1 이미지을 등록하세요.');
				return false;
			}

			else if( '' == $('#ctnt_ttl_2').val() ) {
				alert('캠페인 단락2 제목을 입력하세요.');
				return false;
			}
			else if( '' == $('#ctnt_detail_2').val() ) {
				alert('캠페인 단락2 내용을 입력하세요.');
				return false;
			}
			else if( '' == $('#ctnt_img_2').val() && '' == $('#file_idx_ctnt_img_2').val() ) {
				alert('캠페인 단락2 이미지을 등록하세요.');
				return false;
			}

			else if( '' == $('#ctnt_ttl_3').val() ) {
				alert('캠페인 단락3 제목을 입력하세요.');
				return false;
			}
			else if( '' == $('#ctnt_detail_3').val() ) {
				alert('캠페인 단락3 내용을 입력하세요.');
				return false;
			}
			else if( '' == $('#ctnt_img_3').val() && '' == $('#file_idx_ctnt_img_3').val() ) {
				alert('캠페인 단락3 이미지을 등록하세요.');
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

		// 미리보기 전 저장 여부 확인
		function preview_check() {
			if( confirm( '캠페인을 저장하셨나요? \n꼭 저장하신 후 미리 보기 버튼을 클릭해주세요.') ) {
				return true;
			}
			else 
				return false;

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

	<script type="text/javascript">
		$(document).on('keyup','.goal_cnt', function() {
			var replace_text = $(this).val().replace(/[^-0-9]/g, '');
			$(this).val(replace_text);
		});
		$(document).on('blur','.goal_cnt', function() {
			var replace_text = $(this).val().replace(/[^-0-9]/g, '');
			$(this).val(replace_text);
		});
	</script>