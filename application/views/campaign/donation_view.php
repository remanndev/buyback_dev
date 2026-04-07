<style type="text/css">
	.dn_cmp_cate { font-size:22px; font-weight:bold; color: #a0a0a0; }
	.dn_cmp_cate2 { font-size:22px; font-weight:bold; }
	.dn_cmp_ttl { font-size:32px; font-weight:bold; color:#3d3c43;}

	.gd_wrap { display:flex; /* justify-content: space-between; */}
	.gd_wrap .gd_box { display:flex; margin-right: 20px; }
	.gd_wrap .gd_ttl {display:inline-block; font-size: 18px; width: 40px; min-width: 40px; line-height: 40px; margin:0; padding:0;}
	.gd_wrap .gd_ctnt {display:inline-block;}

	.gd_wrap #demo_goods_kind { width: 100px; height:40px; }
	.gd_wrap #demo_goods_amt { width: 100px; height:40px; }
	.gd_wrap #demo_goods_grade { width: 100px; height:40px; }


</style>

<style type="text/css">
	/* 2022-11-10 */
	/* 기부 신청폼 */
	#cmpfrm { width: 860px; margin:0 auto; }
	#cmpfrm dl.dsp_flex { display:flex; }
	#cmpfrm dl.dsp_flex dd { width: 100%; }
	.frm_dd_box { 
		margin:8px 0 0 0; padding: 28px 32px; 
		/* font-family: 'NanumGothic'; */
		font-size: 18px;
		font-weight: normal;
		font-stretch: normal;
		font-style: normal;
		line-height: 1.2;
		letter-spacing: -0.88px;
		text-align: left;
		color: #000;
		/* 
		min-height: 186px; */
	}
	.frm_subttl {  
		/*font-family: 'NanumGothic'; */ font-size: 22px;  font-weight: bold;  font-stretch: normal;  font-style: normal;  line-height: 1.2;  letter-spacing: -0.88px;  text-align: left;  color: #55a635;
	}

	.frm_tbl table {}
	.frm_tbl table tr th { padding: 5px 0; }
	.frm_tbl table tr td { padding: 5px 0; }
	.frm_tbl table tr th, .frm_tbl table tr td {}
	.frm_tbl table tr td input { height: 40px; font-size:16px !important; padding:10px 10px; }
	.frm_tbl table tr td select { height: 40px; font-size:16px !important; padding:0 10px; }

	#addr_detail::placeholder {
		opacity: 0.6; 
		filter: alpha(opacity=60); 
		-ms-filter: "alpha(opacity=60)"; 
		-khtml-opacity: 0.6; 
		-moz-opacity: 0.6;
		font-size:16px;
		letter-spacing:-1px;
	}

	.guide_cmp_itm { display:flex; justify-content: flex-start; }
	.guide_cmp_itm > div { 
		display: flex; flex-direction: column; 
		width:22.5%; 
		text-align: center;
		margin-left: 0;
		padding:15px 0 0 0;
	}
	.guide_cmp_itm .guide_cmp_itm_txt { width: 100%; height: 70px; font-weight: bold; display: flex; justify-content: center; align-items: center; }

	
	/* 물품의 종류에서 기타 를 선택한 경우 */
	input.goods_kind {
		padding-left: 10px;
	}
	input.goods_kind::placeholder {
		font-size:14px;
	}


	



	/*  모바일 - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - */
	#donation_form dl { display: flex; }
	@media screen and (max-width: 991px) {
		  #donation_form dl { display: flex;  flex-direction: column; }
		  #donation_form dl dt { color: #55a635; /* font-family: 'NanumGothic'; */ font-size: 20px; }

		  .guide_cmp_itm { display: block; }
		  .guide_cmp_itm > div { 
			display: inline-block; 
			width:45%; text-align: center;
			margin: 0 5px 10px 5px;
			padding:15px 0 0 0;
		  }
		  .guide_cmp_itm .guide_cmp_itm_txt { width: 100%; height: 50px; font-weight: bold; display: flex; justify-content: center; align-items: center; }



		  #cmpfrm { width: 100%; max-width: 860px; margin:0 auto; }
		  #cmpfrm dl.dsp_flex { display:flex; }
		  #cmpfrm dl.dsp_flex dd { width: 100%; }

		  .frm_dd_box { 
			margin:5px 0 0 0; 
			padding: 18px 22px; 
			/* font-family: 'NanumGothic'; */
			font-size: 18px;
			font-weight: normal;
			font-stretch: normal;
			font-style: normal;
			line-height: 1.2;
			letter-spacing: -0.88px;
			text-align: left;
			color: #000;
			/* 
			min-height: 186px; */
		  }
		  .frm_subttl {  
			/*font-family: 'NanumGothic'; */ font-size: 18px;  font-weight: bold;  font-stretch: normal;  font-style: normal;  line-height: 1.2;  letter-spacing: -0.88px;  text-align: left;  color: #55a635;
		  }


		.frm_tbl table {}
		.frm_tbl table tr th { padding: 5px 0; font-size: 18px !important; }
		.frm_tbl table tr td { padding: 5px 0; }
		.frm_tbl table tr th, .frm_tbl table tr td { display: block;  }
		.frm_tbl table tr td input { height: 40px; font-size:16px !important; padding:10px 10px; max-width: 100%;  }
		.frm_tbl table tr td select { height: 40px; font-size:16px !important; padding:0 10px; }

		.gd_wrap { display: flex; /* flex-direction: column; */ }
		.gd_wrap .gd_box { display:flex; flex-direction: column; margin-right: 5px; }
		.gd_wrap .gd_ttl { font-size: 13px !important; line-height: 25px; display: none; }
		.gd_wrap > div { margin-bottom: 5px; }

		.gd_wrap #demo_goods_kind { width: 22vw;/*70px;*/ height: 30px; padding-left: 5px; }
		.gd_wrap #demo_goods_amt { width: 14vw; /*40px;*/ height: 30px; padding-left: 5px;}
		.gd_wrap #demo_goods_grade { width: 20vw; /*60px;*/ height: 30px; padding-left: 5px;}

		.btn_add_goods_div {
			padding: 5px 10px;
			font-size: 12px;
			line-height: 1.5;
			border-radius: 3px;
		}



	}
</style>


<div class="pc_wrap">
  <div class="ctnt_wrap">
	<div class="ctnt_inside">


		<div id="cmpfrm">
		

			<!-- 캠페인 명 -->
			<div class="my-5" style="text-align:center; font-size:24px;">
				<div class="dn_cmp_ttl">
					<div style="display:inline-block; text-align:left;">
						<div style="font-size: 18px;"><?php echo $row->cmp_org_name ?></div>
						<?php echo $row->cmp_title ?>
					</div>
				</div>
			</div>

			<hr class="mb-1" />

			<!-- <small>기부하시기 전, 꼭 확인해주세요!</small> -->

			<?php echo form_open_multipart($this->uri->uri_string(), array('id'=>'donation_form','name'=>'donation_form', 'onsubmit'=>'return form_check();')); ?>

				<input type="hidden" name="cmp_idx" value="<?php echo $cidx ?>" />
				<input type="hidden" name="cmp_code" value="<?php echo $code ?>" />

				<dl class="frm_0 mt-5 dsp_flex">
					<dt>
						<div class="_pc"><img src="/assets/images/replus/cmpfrm_ttl_0.png" /></div>
						<div class="_mobile">기부 가능 품목 안내</div>
					</dt>

					<dd class="pt-2">

						<div style="font-weight: bold;">* 기부 가능 품목 </div>
						<ul class="" style="padding-left: 1rem; list-style-type: '- '; font-size:.9rem; margin: 0;">
							<li>데스크탑</li>
							<li>모니터</li>
							<li>노트북</li>
							<li>태블릿PC</li>
							<li>스마트폰 / 피처폰</li>
							<li>저장장치 (HDD/SSD/외장하드 등)가 들어있는 디지털기기</li>
						</ul>

						<div style="margin-top: 10px; font-size:.9rem; ">
							※ 스마트폰 및 태블릿PC는 1차 초기화를 진행 후 보내주시면 기부 가치가 더욱 높아질 수 있습니다.<br />
							※ 기부물품은 직접 박스에 포장해주신 후 박스 외관에 [리플러스] 메모를 남겨주세요.<br />
							※ 가능한 박스 크기가 우체국 5호(48+38+34=120cm) 가 넘지 않게 해주세요.
						</div>

					</dd>
				</dl>

				<hr />

				<dl class="frm_0 mt-5 dsp_flex">
					<dt>
						<div class="_pc"><img src="/assets/images/replus/cmpfrm_ttl_1.png" /></div>
						<div class="_mobile">1. 기부자 정보</div>
					</dt>
					<dd>
						<div class="frm_dd_box roundbox_5 class_shadow_rb">
							<div class="frm_subttl">개인정보 수집 및 이용에 관한 동의</div>

							<div class="mt-4 mb-2 dsp_flex">
								<label for="chk_agree_1" class="o_checkbox4"><strong>[필수]</strong> 개인정보 수집 및 이용에 동의합니다.
									<input type="checkbox" name="chk_agree_1" id="chk_agree_1" />
									<span class="checkmark"></span>
								</label>
								<small class="ms-2" style="display: inline-block;"><a href="/page/term_privacy" target="_blank" style="text-decoration:underline; color:#55a635; ">내용보기</a></small>
							</div>
						</div>

						<input type="hidden" name="donor_type" id="donor_type" value="A" >

						<input type="hidden" id="manager_dept" name="manager_dept" value="" >
						<input type="hidden" id="manager_title" name="manager_title" value="" > 

						<div class="frm_dd_box roundbox_5 class_shadow_rb">
							<div class="frm_subttl">기본 정보</div>
							<div class="mt-4 mb-3">

								<div class="frm_tbl">

									<table style="width:100%;">
										<colgroup>
											<col width="130px;">
											<col>
										</colgroup>
										<tr class="type_A">
											<th class="manager_name">이름</th>
											<td>
												<input type="text" id="name" class="o_input" style="width: 100%;" name="name" value="<?php echo isset($user->nickname) ? $user->nickname : ''; ?>"  autocomplete='off'>
												<div id="error_donor_name" class="error_donor"><span class="manager_name">이름</span> 입력은 필수입니다.</div>
											</td>
										</tr>
										<tr>
											<th>휴대전화</th>
											<td>
												<input type="text" id="phone_1" class="o_input " name="phone_1" value="<?php echo isset($user->arr_phone[0]) ? $user->arr_phone[0] : '010'; ?>"  pattern="[0-9]+" maxlength="3"  style="width: 30%; max-width: 100px;" onKeyup="this.value=this.value.replace(/[^0-9]/g,'');" autocomplete='off' />
												<input type="text" id="phone_2" class="o_input " name="phone_2" value="<?php echo isset($user->arr_phone[1]) ? $user->arr_phone[1] : ''; ?>"  pattern="[0-9]+" maxlength="4"  style="width: 33%; max-width: 120px;" onKeyup="this.value=this.value.replace(/[^0-9]/g,'');" autocomplete='off' />
												<input type="text" id="phone_3" class="o_input " name="phone_3" value="<?php echo isset($user->arr_phone[2]) ? $user->arr_phone[2] : ''; ?>"  pattern="[0-9]+" maxlength="4"  style="width: 33%; max-width: 120px;" onKeyup="this.value=this.value.replace(/[^0-9]/g,'');" onkeyup="return onlyNumber();" autocomplete='off' />
												<div id="error_donor_phone" class="error_donor">휴대전화 입력은 필수입니다.</div>
											</td>
										</tr>
										<tr>
											<th>방문주소</th>
											<td>
												<input type="text" id="postcode" name="postcode" value="<?php echo (isset($user->postcode) ? $user->postcode : ''); ?>" readonly class="o_input bg_readonly"  style="width:120px;" autocomplete='off' /> <button type="button" onclick="srh_execDaumPostcode(); return false;" class="o_btn btn btn-dark btn-md">우편번호 검색</button>
												<div class="pt_5">
													<input type="text" id="addr" class="o_input bg_readonly" style="width:100%;" name="addr" value="<?php echo (isset($user->addr) ? $user->addr : ''); ?>" readonly autocomplete='off' >
												</div>
												<div class="pt_5">
													<input type="text" id="addr_detail" class="o_input" style="width:100%;" name="addr_detail" value="<?php echo (isset($user->addr_detail) ? $user->addr_detail : ''); ?>" placeholder="상세주소를 입력해주세요. 만약 상세 주소가 없을 경우 <주소끝>이라고 메모해주세요." autocomplete='off' />
												</div>
												<div id="error_donor_addr" class="error_donor">주소 입력은 필수입니다.</div>
												<div id="error_donor_addr2" class="error_donor" onclick="no_addr_detail();">상세주소가 없을 경우 <주소끝>이라고 메모해주세요.</div>
												<script>
												function no_addr_detail(){
													if('' == $('#addr_detail').val()) {
														$('#addr_detail').val('<주소끝>');
													}
												}
												</script>
											</td>
										</tr>
										<tr>
											<th>이메일</th>
											<td>
												<input type="text" id="email" class="o_input" name="email" value="<?php echo (isset($user->email) ? $user->email : ''); ?>" style="width: 100%;"  autocomplete='off'/>
												<div class="type_A_only" style="display: none; padding: 5px 0; font-size: 15px; line-height: 22px;">※ 리플러스는 서비스 이용을 위해 필요한 개인정보만 수집하며, 만 14세 미만은 법정대리인 동의를 받아야 하기 때문에 '리플러스' 카카오톡 또는 이메일로 문의바랍니다.</div>

												<div id="error_donor_email" class="error_donor">이메일 주소 입력은 필수입니다.</div>
												
											</td>
										</tr>
									</table>

								</div>

							</div>
						</div>

					</dd>
				</dl>

				<dl class="frm_0 mt-5 dsp_flex">
					<dt>
						<div class="_pc"><img src="/assets/images/replus/cmpfrm_ttl_2.png" /></div>
						<div class="_mobile">2. 기부 물품 정보</div>
					</dt>

					<dd>
						<div class="frm_dd_box roundbox_5 class_shadow_rb">
							<div class="mb-3">
								
								<div style="position: absolute; top: 0; right: 0; z-index: 100;">
								  <button type="button" class="o_btn btn btn-success-flat   btn_add_goods_div d-block ">+ 추가</button>
								</div>
								<input type="hidden" id="tno" value="1" />


								<div id="goods_div_first" class="mb-1">
								  <div class="gd_wrap">
									<div class="gd_box">
										<h2 class="gd_ttl">종류</h2>
										<div class="gd_ctnt">
										  <select id="demo_goods_kind" name="demo_goods_kind[]" class="goods_kind o_selectbox">
											<option value="">종류</option>
											<option value="데스크탑">데스크탑</option>
											<option value="스마트폰">스마트폰</option>
											<option value="태블릿">태블릿</option>
											<option value="노트북">노트북</option>
											<option value="기타">기타</option>
										  </select>
										</div>
									</div>
									<div class="gd_box">
										<h2 class="gd_ttl">수량</h2>
										<div class="gd_ctnt">
										  <input type="number" min="1" id="demo_goods_amt" name="demo_goods_amt[]" class="goods_amt o_input" value="" maxlength="5" onKeyup="this.value=this.value.replace(/[^0-9]/g,'');" placeholder="수량" autocomplete='off' /> <!-- <span style="font-size: 18px;">대</span> -->
										</div>
									</div>
									<div class="gd_box">
										<h2 class="gd_ttl">등급</h2>
										<div class="gd_ctnt">
										  <select id="demo_goods_grade" name="demo_goods_grade[]" class="goods_grade o_selectbox" >
											<option value="">등급</option>
											<option value="A">A급</option>
											<option value="B">B급</option>
											<option value="C">C급</option>
											<option value="D">D급</option>
										  </select>
										</div>
										
									</div>
								  </div>
								</div>

								<div id="goods_div" class="mt-3"></div>
								<div id="error_donor_goods" class="error_donor">기부 물품 정보 등록은 필수입니다.</div>

								
							</div>

							<div class="mt-4" style="font-size:16px; line-height: 150%;">
								<div style="font-size: 18px; font-weight: 500; margin-bottom: 5px;">배출 물품 설명</div>
								<div>
									<textarea name="goods_memo" class="" placeholder="입력해주세요." style="width: 100%; height: 100px; padding: 5px; font-size: 17px; border: 1px solid #cccccc;"></textarea>
								</div>
							</div>


							<style type="text/css">
								.dnpic_ttl { font-size: 18px; font-weight: 500; margin-bottom: 10px; }
								.dnpic_wrap { width: 31%; height: clamp(50px, 18vw,120px); background-color: #e6e6f2; }
								.input_file_style { width: 100%; height: 100%; }
								.input_file_style input[type=file]{ display: none; }
								.input_file_style label { position: relative; display: block; width: 100%; height: 100%; background-color: #ebf7e7; overflow: hidden;  border:1px dashed gray; }
								.input_file_style label img { width: 100%; height: auto; }
								.imgPreview { text-align: center; padding: 0; cursor: pointer; }
								.imgPreview img { margin: 0; padding: 0; display: block; /*border:1px dashed gray;*/ max-width: 100%;}
							</style>
							<div class="mt-3">
								<div class="dnpic_ttl">사진 첨부(선택)</div>
								<div class="dsp_flex_sp_between">
									<div class="dnpic_wrap">
										<div class="input_file_style">
											<input type="file" id="attach_file_form_1" name="attach_file_form[]" />
											<label id="label_file_1" class="imgPreview" for="attach_file_form_1"></label>
										</div>
									</div>
									<div class="dnpic_wrap">
										<div class="input_file_style">
											<input type="file" id="attach_file_form_2" name="attach_file_form[]" />
											<label id="label_file_2" class="imgPreview" for="attach_file_form_2"></label>
										</div>
									</div>
									<div class="dnpic_wrap">
										<div class="input_file_style">
											<input type="file" id="attach_file_form_3" name="attach_file_form[]" />
											<label id="label_file_3" class="imgPreview" for="attach_file_form_3"></label>
										</div>
									</div>
								</div>
							</div>

							<script type="text/javascript">

								function readImage(input, no) {
									// 인풋 태그에 파일이 있는 경우
									if(input.files && input.files[0]) {

										let imgfile = input.files[0];
										let upload_call = true;

										let attach_file = $('#attach_file_form_'+no);
										let label_file = $('#label_file_'+no);

										// console.log( imgfile.name );

										// [1] 이미지 파일인지 검사 
										// 업로드 가능한 이미지 확장자 체크
										if(!/\.(gif|jpg|jpeg|png)$/i.test(imgfile.name)) {
											upload_call = false;
											attach_file.val('');
											alert('jpg, gif, png 파일만 선택해 주세요.\n\n현재 파일 : ' + imgfile.name);
										}

										// [2] 이미지 파일 크기 체크
										let imageFileSize = imgfile.size;
										// console.log( imageFileSize );
										if( imageFileSize > 10240000 ) { // 4MB = 4096000, 10MB = 10240000
											upload_call = false;
											attach_file.val('');
											alert('사진의 크기(10MB 초과)가 너무 큽니다.\n10MB 이하의 사진을 업로드해주세요.');
										}

										if( upload_call ) {
											// FileReader 인스턴스 생성
											const reader = new FileReader()
											// 이미지가 로드가 된 경우
											reader.onload = e => {
												// 이미지 노출
												label_file.html(" <img src='"+e.target.result+"' /> ");
											}
											// reader가 이미지 읽도록 하기
											reader.readAsDataURL(imgfile)
										}


									}
								}

								// input file에 change 이벤트 부여
								const inputImage1 = document.getElementById("attach_file_form_1")
								inputImage1.addEventListener("change", e => {
									readImage(e.target, 1)
								});

								const inputImage2 = document.getElementById("attach_file_form_2")
								inputImage2.addEventListener("change", e => {
									readImage(e.target, 2)
								});

								const inputImage3 = document.getElementById("attach_file_form_3")
								inputImage3.addEventListener("change", e => {
									readImage(e.target, 3)
								});

							</script>












							<div class="mt-3" style="font-size:1rem; line-height: 150%; ">

								<ul class="" style="padding-left: .5rem; list-style-type: '• '; font-size:.9rem;">
									<li>키보드, 마우스, 전원 케이블 등도 함께 보내주세요.</li>
									<li>재생이 안되는 PC는 적법한 방법으로 폐기하여, 폐기된 금액으로 부품을 구매하여 재생합니다.</li>
									<li>상태 설명 안내
									  <div style="margin-left: 10px;">
										[A급] 사용 흔적이 거의 없거나 미세한 생활 흠집만 있는 제품<br />
										[B급] 약간의 흠집 및 성능 문제는 있으나 실사용이 가능한 제품<br />
										[C급] 전원만 켜지거나, 주요 부품이 빠진 수리가 필요한 제품<br />
										[D급] 사용이 불가능하여 폐기해야 하는 제품
									  </div>
									</li>
								</ul>
							</div>
						</div>
					</dd>
				</dl>


				<input type="hidden" name="opt_request" id="opt_data_reset" value="" >
				<!-- <dl class="frm_0 mt-5 dsp_flex">
					<dt>
						<div class="_pc"><img src="/assets/images/replus/cmpfrm_ttl_3.png" /></div>
						<div class="_mobile">3. 기부 물품 처리</div>
					</dt>
					<dd>
						<div class="frm_dd_box roundbox_5 class_shadow_rb">
							<div class="frm_subttl">기부물품 처리옵션(선택)</div>
							<div class="mt-4 mb-3">

								<label class="o_radio4" for="opt_data_reset">데이터 삭제를 요청합니다.
								  <input type="radio" name="opt_request" id="opt_data_reset" value="data_reset" >
								  <span class="checkmark"></span>
								</label>
								<label class="o_radio4" for="opt_discard">재사용을 원하지 않습니다.(폐기만을 원합니다.)
								  <input type="radio" name="opt_request" id="opt_discard" value="discard">
								  <span class="checkmark"></span>
								</label>
							</div>
						</div>
					</dd>
				</dl> -->

				<!--  -->
				<dl class="frm_0 mt-5 dsp_flex"  style="display: ;">
					<dt>
						<div class="_pc"><img src="/assets/images/replus/cmpfrm_ttl_3_250821.png" /></div>
						<div class="_mobile">3. 물품 수거 요청 일자</div>
					</dt>
					<dd>
						<div class="frm_dd_box roundbox_5 class_shadow_rb">
							<div class="frm_subttl">방문 희망일</div>
							<div class="mt-4 mb-3">

								<div style="display: inline-block;">
									<input type="text" id="pickup_date_plz" class="o_input datepicker" name="pickup_date_plz" value="" placeholder="방문 희망일을 입력해주세요." style="width: 100%; max-width: 360px; height: 46px; font-size:17px;"  autocomplete='off' />
								</div>
								<div id="error_goods_pickup_date_plz" class="error_donor">물품 수거를 위한 방문 희망일자를 입력해주세요.</div>
								<div class="mt-3"><small style="font-size: .9rem;">※ 물품이 소규모이거나 수도권 외곽 지역일 경우 방문 희망일 보다 다소 늦어질 수 있습니다.</small></div>
								<div class="mt-1"><small style="font-size: .9rem;">※ 기부물품은 리플러스 협력업체인 <span style="color: blue; font-weight: bold;">(주)리맨</span>에서 수거 및 재생됩니다.</small></div>
								<div class="type_A_only" style="display: none;"><small style="font-size: .9rem;">※ CJ대한통운에서 수거되며 택배는 "반품"으로 예약됩니다.</small></div>
							</div>
						</div>
					</dd>
				</dl>


				<div style="margin: 50px auto; text-align: center;">
					<button type="submit" class="o_btn btn btn-lg btn-success-flat btn-block"><h3 class="m-0">작성 완료</h3></button>
				</div>


			<?php echo form_close(); ?>

		</div>

	</div>
  </div>
</div>




<!-- <div style="display: none;">
 <div id="goods_div_sample">
  <div class="gd_wrap">
	<div style="display:flex; margin-right: 20px;">
		<h2 class="gd_ttl">종류</h2>
		<div class="gd_ctnt">
		  <select id="goods_kind" name="goods_kind[]" class="goods_kind o_selectbox" style="width: 100px;height:40px;">
			<option value="">물품 종류</option>
			<option value="노트북">노트북</option>
			<option value="데스크탑">데스크탑</option>
			<option value="모니터">모니터</option>
			<option value="태블릿">태블릿</option>
			<option value="스마트폰">스마트폰</option>
		  </select>
		</div>
	</div>
	<div style="display:flex; margin-right: 20px;">
		<h2 class="gd_ttl">수량</h2>
		<div class="gd_ctnt">
		  <input type="number" min="1" id="goods_amt" name="goods_amt[]" class="goods_amt o_input" style="width: 100px;  height:40px;text-align:center; font-size:14px;" value="1" maxlength="5" onKeyup="this.value=this.value.replace(/[^0-9]/g,'');" placeholder="수량" autocomplete='off' />
		</div>
	</div>
	<div style="display:flex; margin-right: 20px;">
		<h2 class="gd_ttl">상태</h2>
		<div class="gd_ctnt">
		  <select id="goods_grade" name="goods_grade[]" class="goods_grade o_selectbox" style="width: 100px;height:40px;">
			<option value="">물품 상태</option>
			<option value="A">A급</option>
			<option value="B">B급</option>
			<option value="C">C급</option>
			<option value="D">D급</option>
		  </select>
		</div>
	</div>
	<div style="display:flex;">
		<button type="button" class="del_goods_tr o_btn btn btn-danger-flat btn-sm" style="margin-top: 5px;height: 34px;">X</button>
	</div>
  </div>
 </div>
</div> -->




<script type="text/javascript">
	$(document).ready(function(){

		// 기부물품 정보 폼 저장
		//var goods_div = '<div style="margin:5px 0;">'+ $('#goods_div').html() +'</div>';
		//var goods_div = '<div style="margin:5px 0;">'+ $('#goods_div_sample').html() +'</div>';
		//var goods_div = '<div style="margin:5px 0; display: ;">'+ $('#goods_div_sample').html() +'</div>';

		// 초기화
		//$('#goods_div_sample').html('');

		var tno;
		var add_html_sample;
		var add_html;

		// $('#btn_add_goods_div').on('click',function() {
		$('.btn_add_goods_div').on('click',function() {
			
			var ino = $("#donation_form select[name='goods_kind[]']").length;
			console.log( ino );

			if( ino > 4 ) {
				alert('5개까지 등록하실 수 있습니다.');
			}
			else {

				let tno = $('#tno').val();
				//console.log(tno);


				let demo_goods_kind = $('#demo_goods_kind').val();
				let demo_goods_amt = $('#demo_goods_amt').val();
				let demo_goods_grade = $('#demo_goods_grade').val();

				if( demo_goods_kind == '' || demo_goods_amt == '' || demo_goods_grade == '' ) {
					alert('종류, 수량, 상태를 선택해주세요.');
					return false;
				}
				else {
				
					add_html = '<div class="add_goods">';
					add_html +=   '<input type="hidden" name="goods_kind[]" value="'+demo_goods_kind+'" />';
					add_html +=   '<input type="hidden" name="goods_amt[]" value="'+demo_goods_amt+'" />';
					add_html +=   '<input type="hidden" name="goods_grade[]" value="'+demo_goods_grade+'" />';



					add_html += '  <div class="itm_list mt-0 pt-1" style="width: 100%; font-size: 16px;">';
					add_html += '	<div id="itm_'+tno+'" class="roundbox_10 class_shadow_3px bg-white mb-2 py-1 fw-bold dsp_flex_sp_between"  data-itm="lt" data-volume="1">';
					add_html += '		<div class="pt-1 ps-2" style="width: 19vw; max-width: 100px; text-align: center;">'+demo_goods_kind+'</div>';
					add_html += '		<div class="pt-1" style="width: 14vw; max-width: 100px; text-align: right;">'+demo_goods_amt+' 대</div>';
					add_html += '		<div class="py-1">'+demo_goods_grade+'급</div>';
					add_html += '		<div class="py-1 pe-2  del_goods_tr"><img src="/assets/images/layout/icon_remove2.png" style="width: 20px;"></div>';
					add_html += '	</div>';
					add_html += '  </div>';
					add_html += '</div>';

					$('#goods_div').append(add_html);

					tno++;
					$('#tno').val(tno);

				}

			}

		});


		// 방문 희망일 체크
		$('#pickup_date_plz').change(function() {
			let dt = new Date();
			let limit_date = dt.getFullYear() + "-" + (dt.getMonth() + 1) + "-" + dt.getDate();
			let pickup_date_plz = $(this).val();

			//console.log( limit_date );
			//console.log( pickup_date_plz );

			//console.log('today : '+today);
			//console.log('limit_date : '+date(limit_date));
			//console.log('limit_date : '+ Date(limit_date));
			//console.log('pickup_date_plz : '+pickup_date_plz);


		});


	});

	// 기부물품 삭제
	$(document).on("click",".del_goods_tr",function(){ 
		$(this).parent().parent().parent().remove();
	});


	// 기부물품 최소 수량 1
	$(document).on("blur",".goods_amt",function(){ 
		let amt_min = 1; // 최소 수량 지정
		let amt_cnt = $(this).val();
		let amt_value = (amt_cnt < amt_min) ? amt_min : amt_cnt;
		$(this).val(amt_value);
	});

</script>




<!-- 네이버 검색광고 전환코드 -->
<script type="text/javascript" src="//wcs.naver.net/wcslog.js"></script>

<!-- submit -->
<script type="text/javascript">
	function form_check() {

			// [1] 기본 정보 - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

			var chk_agree_1 = $("input:checkbox[name='chk_agree_1']").is(":checked");
			var donor_type = $('#donor_type').val();

			var name = $('#name').val();
			var name_org = $('#name_org').val();

			var phone_1 = $('#phone_1').val();
			var phone_2 = $('#phone_2').val();
			var phone_3 = $('#phone_3').val();

			var postcode = $('#postcode').val();
			var addr = $('#addr').val();
			var addr_detail = $('#addr_detail').val();

			//var email_1 = $('#email_1').val();
			//var email_2 = $('#email_2').val();
			var email = $('#email').val();

			var cnt_add = $('.add_goods').length;
			//console.log( cnt_add );


			// red msg
			if(! chk_agree_1) {
				$('#error_donor_chk_agree_1').show();
				alert('개인정보 수집 및 이용에 동의해주세요.');
				return false;
			}
			else {
				$('#error_donor_chk_agree_1').hide();
			}

			if('' == name) {
				$('#error_donor_name').show();
				alert('이름을 입력해주세요.');
				return false;
			}
			else {
				$('#error_donor_name').hide();
			}

			if('' == phone_1 || '' == phone_2 || '' == phone_3) { 
				$('#error_donor_phone').show();
				alert('휴대전화 번호를 입력해주세요.');
				return false;
			}
			else {
				$('#error_donor_phone').hide();
			}

			// error_donor_addr, error_donor_addr2
			if('' == postcode || '' == addr || '' == addr_detail) { 
				$('#error_donor_addr').show();
				$('#error_donor_addr2').show();
				alert('주소를 입력해주세요.');
				return false;
			}
			else {
				$('#error_donor_addr').hide();
				$('#error_donor_addr2').hide();
			}

			// red msg
			//if(! email_1 || ! email_2) {
			if(! email) {
				$('#error_donor_email').show();
				alert('이메일 주소를 입력해주세요.');
				return false;
			}
			else {
				$('#error_donor_email').hide();
			}




			// [2] 기부 물품 종류, 수량, 상태 등 - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
			// 기부물품정보 변수


			// 기부 물품 정보
			if( cnt_add < 1 ) {
				$('#error_donor_goods').show();
				alert('기부 물품을 등록해주세요.');
				return false;
			}
			else {
				$('#error_donor_goods').hide();
			}



			
			// [3] 기부물품 처리 옵션 및 물품수거 요청일자 체크 - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
			// 옵션
			var opt_request = $("input:radio[name='opt_request']:checked").val();
			var opt_request_text = trim($("input:radio[name='opt_request']:checked").parent().text());
			//console.log(opt_request);
			//console.log(opt_request_text);

			// 방문 희망일
			var pickup_date_plz = $('#pickup_date_plz').val();
			//console.log(pickup_date_plz);
			if('' == pickup_date_plz) {
				$('#error_goods_pickup_date_plz').show();
				alert('물품 수거를 위한 희망 방문일자를 입력해주세요.');
				return false;
			}
			else {
				$('#error_goods_pickup_date_plz').hide();
			}





			// [4] 최종 작성 완료 - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
			if( confirm('작성을 완료하시겠습니까?') ) {

				//<!-- NAVER 신청완료(lead) SCRIPT -->
				if(window.wcs){
				if(!wcs_add) var wcs_add = {};
				wcs_add['wa'] = 's_445f55a96389';
				var _conv = {};
					_conv.type = 'lead';
				wcs.trans(_conv);
				}

				return true;
			}
			else {
				return false;
			}


	}
</script>


<script type="text/javascript">
/* [2025-09-15] 직접입력 필요 없어서 주석처리
	$(document).ready(function(){

		$(document).on('change', '.goods_kind', function(){
			gk_val = $(this).val();
			// 기타를 선택하면 텍스트 입력칸으로 변경
			if('기타' == gk_val) {
				// console.log('기타');
				var parent_wrap = $(this).parent();
				//console.log( $(this).attr('id') );
				//console.log( $(this).attr('name') );
				//console.log( $(this).attr('class') );
				//console.log( $(this).attr('style') );

				var gk_id = $(this).attr('id');
				var gk_name = $(this).attr('name');
				var gk_class = $(this).attr('class');
				var gk_style = $(this).attr('style');
				var exchange_tag = '<input type="text" id="'+gk_id+'" name="'+gk_name+'" class="goods_kind o_input" style="'+gk_style+'" placeholder="직접 입력" />';
				$(this).remove();
				parent_wrap.append(exchange_tag);
			}
		});
	});
*/
</script>


	<!-- iOS에서는 position:fixed 버그가 있음, 적용하는 사이트에 맞게 position:absolute 등을 이용하여 top,left값 조정 필요 -->
	<div id="layer_execDaumPostcode" style="display:none;position:fixed;overflow:hidden;z-index:11;-webkit-overflow-scrolling:touch;">
	<img src="//t1.daumcdn.net/postcode/resource/images/close.png" id="btnCloseLayer" style="cursor:pointer;position:absolute;right:-3px;top:-3px;z-index:1" onclick="closeDaumPostcode()" alt="닫기 버튼">
	</div>
	<script src="//t1.daumcdn.net/mapjsapi/bundle/postcode/prod/postcode.v2.js"></script>
	<script>
		// 우편번호 찾기 화면을 넣을 element
		var element_layer = document.getElementById('layer_execDaumPostcode');

		function closeDaumPostcode() {
			// iframe을 넣은 element를 안보이게 한다.
			element_layer.style.display = 'none';
		}

		function srh_execDaumPostcode() {
			new daum.Postcode({
				oncomplete: function(data) {
					// 검색결과 항목을 클릭했을때 실행할 코드를 작성하는 부분.

					// 각 주소의 노출 규칙에 따라 주소를 조합한다.
					// 내려오는 변수가 값이 없는 경우엔 공백('')값을 가지므로, 이를 참고하여 분기 한다.
					var fullAddr = data.address; // 최종 주소 변수
					var extraAddr = ''; // 조합형 주소 변수

					// 기본 주소가 도로명 타입일때 조합한다.
					if(data.addressType === 'R'){
						//법정동명이 있을 경우 추가한다.
						if(data.bname !== ''){
							extraAddr += data.bname;
						}
						// 건물명이 있을 경우 추가한다.
						if(data.buildingName !== ''){
							extraAddr += (extraAddr !== '' ? ', ' + data.buildingName : data.buildingName);
						}
						// 조합형주소의 유무에 따라 양쪽에 괄호를 추가하여 최종 주소를 만든다.
						fullAddr += (extraAddr !== '' ? ' ('+ extraAddr +')' : '');
					}

					// 우편번호와 주소 정보를 해당 필드에 넣는다.
					document.getElementById('postcode').value = data.zonecode; //5자리 새우편번호 사용
					document.getElementById('addr').value = fullAddr;
					//document.getElementById('sample2_addressEnglish').value = data.addressEnglish;

					// iframe을 넣은 element를 안보이게 한다.
					// (autoClose:false 기능을 이용한다면, 아래 코드를 제거해야 화면에서 사라지지 않는다.)
					element_layer.style.display = 'none';
				},
				width : '100%',
				height : '100%'
			}).embed(element_layer);

			// iframe을 넣은 element를 보이게 한다.
			element_layer.style.display = 'block';

			// iframe을 넣은 element의 위치를 화면의 가운데로 이동시킨다.
			initLayerPosition();
		}

		// 브라우저의 크기 변경에 따라 레이어를 가운데로 이동시키고자 하실때에는
		// resize이벤트나, orientationchange이벤트를 이용하여 값이 변경될때마다 아래 함수를 실행 시켜 주시거나,
		// 직접 element_layer의 top,left값을 수정해 주시면 됩니다.
		function initLayerPosition(){
			var width = 450; //우편번호서비스가 들어갈 element의 width
			var height = 550; //우편번호서비스가 들어갈 element의 height
			var borderWidth = 5; //샘플에서 사용하는 border의 두께

			//console.log(document.documentElement.clientWidth);
			// 모바일 대응
			var client_width = document.documentElement.clientWidth;
			if(client_width <= 500) {
				width = client_width - 30;
				height = 300;
			}

			// 위에서 선언한 값들을 실제 element에 넣는다.
			element_layer.style.width = width + 'px';
			element_layer.style.height = height + 'px';
			element_layer.style.border = borderWidth + 'px solid';
			// 실행되는 순간의 화면 너비와 높이 값을 가져와서 중앙에 뜰 수 있도록 위치를 계산한다.
			element_layer.style.left = (((window.innerWidth || document.documentElement.clientWidth) - width)/2 - borderWidth) + 'px';
			element_layer.style.top = (((window.innerHeight || document.documentElement.clientHeight) - height)/2 - borderWidth + 40) + 'px';
		}
	</script>


	<?php
		$timestamp_tomorrow = strtotime("+2 days");
		$day_tomorrow = date("Y-m-d", $timestamp_tomorrow);
		//echo $day_tomorrow;


		// - - - - - - - - - - - - - - - - - - - - - - -
		// 2025-01-22 긴급요청
		// 2월4일 이후부터 선택 가능하도록 - (2월 4일 이전에는 선택 불가하도록.)
		if($day_tomorrow < '2025-02-04') {
			$day_tomorrow = '2025-02-04';
		}
	?>
	<script type="text/javascript">
		// datetimepicker
		/*
		$.datetimepicker.setLocale('kr');
		$('.datepicker').datetimepicker({
			lang:'kr',
			timepicker:false,
			format:'Y-m-d',
			scrollMonth : false,
			minDate: '<?php echo $day_tomorrow ?>',
			beforeShowDay: function(date){
			  // 주말(일,월,토) 선택 불가 
			  return [(date.getDay()  != 0 && date.getDay()  != 1 && date.getDay()  != 6)];      
			  
			}
		});
		*/
	</script>

	<script type="text/javascript">
		// 막을 날짜 구간 (포함 범위)과 단일 날짜(YYYY-MM-DD) 목록
		const blockedRanges = [
		  { start: '2025-10-03', end: '2025-10-13' },  // 요청 구간
		  // { start: '2025-12-24', end: '2025-12-26' }, // 예시
		];

		const blockedDates = new Set([
		  // '2025-11-11', // 예시: 단일 날짜
		]);

		// 'YYYY-MM-DD' -> Date(로컬, 시분초 00:00)
		function ymdToDate(s) {
		  const [y, m, d] = s.split('-').map(Number);
		  return new Date(y, m - 1, d);
		}

		// 미리 Date 객체로 변환해두기
		const blockedRangesParsed = blockedRanges.map(r => ({
		  start: ymdToDate(r.start),
		  end:   ymdToDate(r.end),
		}));

		// 연말연초 차단 구간
		const yearEndBlock = {
		  start: new Date(),               // 오늘
		  end: new Date('2026-01-05')       // 2026-01-05
		};
		yearEndBlock.start.setHours(0,0,0,0);
		yearEndBlock.end.setHours(23,59,59,999);


		$.datetimepicker.setLocale('kr');
		$('.datepicker').datetimepicker({
		  lang: 'kr',
		  timepicker: false,
		  format: 'Y-m-d',
		  scrollMonth: false,
		  minDate: '<?php echo $day_tomorrow ?>',
		  beforeShowDay: function(date) {
			// 요일 제한: 일(0), 월(1), 토(6) 불가
			const dow = date.getDay();
			const isWeekend = (dow === 0 || dow === 1 || dow === 6);

			// 구간 제한
			const inBlockedRange = blockedRangesParsed.some(r => date >= r.start && date <= r.end);

			// 단일 날짜 제한
			const iso = [
			  date.getFullYear(),
			  String(date.getMonth() + 1).padStart(2, '0'),
			  String(date.getDate()).padStart(2, '0')
			].join('-');
			const isBlockedDate = blockedDates.has(iso);


			// 🔴 연말연초 차단
			const isYearEndBlocked =
			  date >= yearEndBlock.start && date <= yearEndBlock.end;
			
			// true=선택가능 / false=불가
			return [!(isWeekend || inBlockedRange || isBlockedDate || isYearEndBlocked)];
		  }
		});

	</script>
