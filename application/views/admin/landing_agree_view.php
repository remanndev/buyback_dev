<style type="text/css">
.ttl1 {
    position: relative;
    text-align: left;
    color: #333;
    font-size: 24px;
    font-weight: 500;
    text-align: left;
    line-height: 30px;
    word-spacing: 0em;
    letter-spacing: -0.05em;
</style>

<h1>랜딩 관리</h1>
<h2>개인정보수집동의</h2>

<?php echo form_open($this->uri->uri_string(), array('id'=>'agree_form','name'=>'agree_form')); ?>
	<div style="width:1200px;">

		<input type="hidden" name="agree_type" value="개인정보수집동의" />

		<textarea id="agree_content" name="agree_content" style="width:1200px; height:250px;"><?php echo isset($row->agree_content) ? $row->agree_content : ''; ?></textarea>

		<button type="submit" class="o_btn  btn-black-flat o_btn_v50" style="margin:5px auto; width: 100px;">저장</button>

	</div>
<?php echo form_close(); ?>



<script type="text/javascript">
	$R('#agree_content', { 
		focus: true,
		//toolbarExternal: '#my-external-toolbar',
		breakline: true,
		lang: 'ko',
		minHeight: '250px',
		maxHeight: '1000px',
		plugins: ['fontsize','fontcolor','filemanager','video','table','alignment','inlinestyle','specialchars','textdirection','widget','fontfamily','fullscreen'],
		imageUpload: "/files/upload/redactor_image/<?php echo url_code('landing/image','e') ?>/landing/<?php echo isset($idx) ? $idx : '' ?>",
		fileUpload: "/files/upload/redactor_file/<?php echo url_code('landing/files','e') ?>/landing/<?php echo isset($idx) ? $idx : '' ?>",

		buttonsAddAfter: {
			after: 'deleted',
			buttons: ['underline','line', 'ol', 'ul']
		},
		buttonsHide: ['lists']
	});
</script>