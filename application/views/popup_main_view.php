<style type="text/css">
	.pu_footer {
		margin:0;

		position: absolute;
		left: 0;
		bottom: 0;
		height: 45px;
		width: 100%;

		background-color: #4a4a4a;
		border-top: 1px solid #E7E7E7;
		text-align:center;
		line-height:40px;

		/* overflow:hidden; */
	}

	.pu-wrapper img { max-width:100%; }

	#pu_layer {
		width:100%;
		height:100%;
		background-color:#ffffff;
	}

	.pu_footer span.btn-left{
		position:absolute;
		bottom:4px;
		left:8px;
	}
	.pu_footer span.btn-right{
		position:absolute;
		top:4px;
		right:8px;
	}


	/* 그림자 - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - */
	.class_shadow{
		margin: auto;
		background: #ccc;
		position:relative;
		box-shadow: 3px 3px 3px rgba(0, 0, 0, 0.50);
		-moz-box-shadow: 3px 3px 3px rgba(0, 0, 0, 0.50);
		-webkit-box-shadow: 3px 3px 3px rgba(0, 0, 0, 0.50);
	} 
</style>

<div id="<?php echo $id?>" class="<?php echo (isset($pu_type) && $pu_type == '1') ? 'class_shadow' : '' ?>" style="background-color:#ffffff; z-index:10; padding-bottom: 25px;">
	<div class="pu-wrapper">
		<div><?php echo $content ?></div>
	</div>

	<footer class="pu_footer">
		<span class="btn-left">
			<button type="button" class="btn btn-sm btn-dark" onclick="popup_close('<?php echo $id?>', true);">일주일간 보이지 않음</button>
		</span>
		<span class="btn-right">
			<a href="#" class="close" onclick="popup_close('<?php echo $id?>'); return false;" style="color:#FFFFFF; font-size:32px; padding:0;">&times;</a>
		</span>
	</footer>
</div>

<?php if( IS_MOBILE ) { ?>
<script type="text/javascript">
  $(function() {
	  $('.ipopuplayer').css('width','100%').css('height','auto').css('top','55px').css('left',0).css('background-color','#333333');
	  $('.pu-wrapper img').addClass('img-responsive').css('margin','0 auto').css('width','100%');
  });
</script>
<?php } ?>