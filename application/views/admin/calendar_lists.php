<style type='text/css'>
.calendar_table th, .calendar_table td { text-align:center; padding:5px; }
.calendar_table td { border:1px solid #e7e7e7;}

.calendar_list ul{ top:0;  vertical-align:top;}
.calendar_list li {}

.calendar_detail {width:100%; border-top: 1px solid #b2b2b2; border-bottom:1px solid #b2b2b2; }
.calendar_detail th, .calendar_detail td{ padding:10px; border-bottom:1px solid #b2b2b2;}
.calendar_detail th { width:100px; text-align:center; background-color:#ebebeb; height: 40px;}
.calendar_detail td {}

.cal_font {}
.cal_font_weight { font-weight:bolder; color:#393939; }


/* 라운딩 3px - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - */
.radius_3px {
	-moz-border-radius:3px;
	-webkit-border-radius:3px;
	-o-border-radius:3px;
	-ms-border-radius:3px;
	-khtml-border-radius:3px;
	border-radius:3px;
}
</style>
<script type='text/javascript'>
function view_cal_list(category, date, date_str) {

	console.log(date_str);

		$('#calendar_date_str').html(date_str);

		$.post( '/admin/calendar/view_date_list', {
			'category': category,
			'date': date 
		})
		.done(function( data ) {
			//alert( "Data Loaded: " + data );
			$('#calendar_ctnt').html(data);
			
			/*
			var arr = data.split('||');
			$('#prj_comment').val('');
			$('#prj_comment_now').prepend(arr[1]);
			$('#prj_cmt_'+arr[0]).hide().fadeIn('slow');
			*/

			//view_cal_detail();
		})
		.fail(function() {
			alert( "일정이 없습니다." );
		}); // 맨 마지막에 세미콜론(;)

}

function view_cal_detail(cno) {

		$.post( '/admin/calendar/view_date_detail', {
			'cno': cno 
		})
		.done(function( data ) {
			//alert( "Data Loaded: " + data );
			$('#calendar_detail').html(data);
			$('.cal_font').removeClass('cal_font_weight');
			$('#cal_list_'+cno).addClass('cal_font_weight');

			/*
			var arr = data.split('||');
			$('#prj_comment').val('');
			$('#prj_comment_now').prepend(arr[1]);
			$('#prj_cmt_'+arr[0]).hide().fadeIn('slow');
			*/

			//view_cal_detail();
		})
		.fail(function() {
			alert( "일정이 없습니다." );
		}); // 맨 마지막에 세미콜론(;)

}

function edit_calendar(category,cno,selected_year,selected_month) {
	//location.href = "/admin/calendar/write/"+category+"/"+cno;

	var edit_url = "/admin/calendar/write/"+category+"/"+cno;
	if(selected_year && selected_month)
	  edit_url += "/"+selected_year+"/"+selected_month;

    location.href = edit_url;
}

function del_calendar(category,cno,selected_year,selected_month) {
  if( confirm('삭제하시겠습니까?') ) {
	var del_url = "/admin/calendar/del/"+category+"/"+cno;
	if(selected_year && selected_month)
	  del_url += "/"+selected_year+"/"+selected_month;

    location.href = del_url;
  }
}
</script>

<h1>행사 일정</h1>

<h2 style="position:relative;">
	<?php echo $title ?>
	<a href="/admin/calendar/write/<?php echo $category?>"><button type="button" class="btn btn-primary btn-xs" style="position:absolute; right:0;" onclick="location.href='/admin/calendar/write/<?php echo $category?>'">일정 등록하기</button></a>
</h2>


<hr style="margin-top:5px;" />
<div class='row'>
  <div class='col-4'>
	<div class="radius_3px" style="padding:10px; background-color:#f9f9f9;height:273px; overflow:Hidden">
	  <?php echo $this->calendar->generate($selected_year, $selected_month,$calendar_list); ?>
	</div>
  </div>
  <div class='col-8'>

	<div class="panel panel-default-flat">
		<div id='calendar_date_str' class="panel-heading"><?php echo $selected_year."년 ".$selected_month."월 "; ?></div>
		<div id='calendar_ctnt' class="panel-body" style="height:230px; overflow-y:auto; vertical-align:top;">
			<?php echo $default_cal_list ?>
		</div>
	</div>

	<!-- <div id='calendar_date' class="panel panel-info-flat">
		<div id='calendar_date_str' class="panel-heading">
		  <?php echo $selected_year."년 ".$selected_month."월 "; ?>
		</div>
		<div id='calendar_ctnt' class="panel-body" style="height:230px; overflow-y:auto; vertical-align:top;">
		  <?php echo $default_cal_list ?>
		</div>
	</div> -->
  </div>
</div>



<h2 style="position:relative;">행사일정 상세</h2>
<hr style="margin-top:5px;" />
<div class='row'>
  <div class='col-md-12 col-sm-12 col-xs-12'>
	  <div id='calendar_detail'>
		<?php 
		if($cal_result_today['total_cnt']) {
		  foreach($cal_result_today['qry'] as $row) {
		?>
		  <table class='calendar_detail' style="margin-bottom:10px;">
			<tr><th style="min-width:120px;"> 날 짜 </th><td><?php echo $row['cal_date'] ?></td></tr>
			<tr><th> 제 목 </th><td><?php echo $row['cal_title'] ?></td></tr>
			<tr><th> 링 크 </th><td><?php echo $row['cal_url'] ?></td></tr>
			<tr><th> 내 용 </th><td><?php echo $row['cal_content'] ?></td></tr>
		  </table>
		<?php
		  }
		}
		else {
		  echo "금일 일정은 없습니다.";
		}
		?>
	  </div>
  </div>
</div>
