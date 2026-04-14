<?php
/** - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
 * 회원검색
*/

// [1] 검색필드
	$sfl_select_options = array(
		//'all'    => '통합검색',
		'username'   => '아이디',
		'nickname'   => '이름',
		'email'      => '이메일',
		'phone'      => '휴대전화',
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
		'nickname DESC'    => '이름 ↓',
		'nickname ASC'     => '이름 ↑',
		'username DESC'    => '아이디 ↓',
		'username ASC'     => '아이디 ↑',
		'created DESC'          => '회원가입일 ↓',
		'created ASC'           => '회원가입일 ↑',
		'last_login DESC'  => '최종 로그인 ↓',
		'last_login ASC'   => '최종 로그인 ↑'
	);

/** - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
 * 회원구분( 0:비회원 / 1:일반회원·sns로그인회원 / 2:NPO회원)
*/
/*
	$arr_level = array(
		'all'=>'전체', // 
		0=>'비회원', // 비회원, 탈퇴회원
		1=>'일반회원', // 일반회원·sns로그인회원
		2=>'NPO회원', // NPO회원
	);
	$level_select_options = $arr_level;
	unset($level_select_options[0]); // 비회원, 탈퇴회원
*/

/** - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
 * 엑셀 업로드/다운로드 사용 여부
*/
	$use_excel_upload = false;
	$use_excel_download = false;
?>


<div class=" admin_wrap">


	<h1>회원 관리</h1>

	<?php 
	/**
	 | - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	 | 회원 엑셀 업로드
	 */

	if($use_excel_upload) {
		echo form_open($this->uri->uri_string(), array('id'=>'excel_form','name'=>'excel_form'));
	?>

		<h2>회원 엑셀 업로드</h2>

		<div class="panel panel-default-flat">
		  <div class="panel-heading">
			<div style="position:relative;">
				

				<!-- 회원 정보 엑셀 업로드 -->
				<form name="excel_users_upload" action="<?php echo base_url() ?><?php echo $this->uri->uri_string() ?>" method="post" enctype="multipart/form-data" target="hidden_ifr">
					
					<input type="hidden" name="chk_excel" value="upload" />
					<input type="file" name="excel_file" class="o_input_file" style="border:none; display:inline-block; background-color:#dddddd;" />
					<input type="submit" name="excel_upload_submit" class="o_input" value="엑셀 업로드" />
				</form>

				<!-- 엑셀 업로드 회원정보만 초기화 -->
				<div style="position:absolute;top:0; right:0;">
					<a class="btn btn-dark btn-ssm" title="이름/아이디/비번/이메일" href="/files/download/<?php echo url_code('sample', 'e') ?>/users_upload_sample.xlsx">엑셀업로드 샘플</a>
					<form name="excel_users_truncate" action="<?php echo base_url() ?><?php echo $this->uri->uri_string() ?>" method="post" target="hidden_ifr" onsubmit="return chk_submit();" style="display:inline-block;">
						<input type="hidden" name="chk_excel" value="truncate" />
						<input type="submit" name="excel_truncate_submit" value="엑셀업로드회원만 삭제" class="btn btn-danger btn-ssm"  title="[주의!!!] 클릭하시면 엑셀업로드회원 정보가 모두 삭제화됩니다." />
					</form>
					<script type="text/javascript">
						function chk_submit() {
							if( confirm('정말 엑셀업로드 회원 정보를 삭제하시겠습니까? 이 결정은 되돌릴 수 없습니다!') ) {
								return true;
							}
							else
								return false;
						}
					</script>
				</div>

				<iframe id="hidden_iframe" name="hidden_ifr" style="width:0; height:0; display: none;"></iframe>


			</div>
		  </div>
		</div>

	<?php 
		echo form_close();
	}
	?>




	<?php 
	echo form_open($this->uri->uri_string(), array('id'=>'search_form','name'=>'search_form','method'=>'get'));
	?>
		<h2>회원 검색</h2>

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
			<span style="display:inline-block; width:100px;">관리자 목록</span>
		</h2>
		<div>
			<small>
				검색 <span style="color:red;font-weight:bold;"><?php echo $list['total_count'] ?></span> 명 / 전체 <span style="color:red;font-weight:bold;"><?php echo $user_total_count ?></span> 명
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
		<tr>
		  <th class='text-center'>NO</th>
		  <th>아이디</th>
		  <th>이름</th>
		  <th>이메일</th>
		  <th>TYPE</th>
		  <th>회원가입일</th>
		  <th>최종로그인</th>
		  <th class='text-center'>관리</th>
		</tr>
		</thead>
		<tbody>
		<?php
		foreach($list['qry'] as $i => $o)
		{
			// 번호
			$num = ($list['total_count'] - $limit*($page-1) - $i);
		?>
		<tr>
		  <td class="text-center"><?php echo $num ?></td>
		  <td><?php echo $o->username ?></td>
		  <td><?php echo $o->nickname ?></td>
		  <td><?php echo $o->email ?></td>
		  <td><?php echo isset($o->type) ? $o->type : '' ?></td>
		  <td><?php echo substr($o->created,0,10) ?></td>
		  <td><?php echo substr($o->last_login,0,10) ?></td>
		  <td class="text-center">
			<a href="/admin/user/admwrite/<?php echo $o->user_idx ?>"><button class="btn btn-secondary btn-xs">수정</button></a>
			<?php if($this->tank_auth->is_admin() && $o->username != 'admin') { ?>
			<a href="/admin/user/admdel/<?php echo $o->user_idx ?>" onclick="del_confirm('admin/user/admdel/<?php echo $o->user_idx ?>'); return false;"><button class="btn btn-danger btn-xs">삭제</button></a>
			<?php } ?>
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
