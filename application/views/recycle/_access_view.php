<?php echo form_open(base_url().'recycle/step1', array('id'=>'form','name'=>'form')); ?>
	<input type="text" name="code" value="<?php echo $code ?>" />
<?php echo form_close(); ?>
<script type="text/javascript">
$(document).ready(function(){
  $('#form').submit();
});
</script>