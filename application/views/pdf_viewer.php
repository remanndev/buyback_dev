<!-- <div id="myPdf"></div>
<script type="text/javascript" src="<?php echo LIB_DIR ?>/pdf/pdfobject.min.js"></script>
<script type="text/javascript">
var option = {
		height: "calc(100vh - 97px)",
		pdfOpenParams: {view: 'FitV', page: '2'}
}
PDFObject.embed("<?php echo $file_view_link ?>", "#myPdf", option);
</script>
 -->

<!-- <iframe src="<?php echo $file_view_link ?>" style="width:100%; height:calc(100vh - 90px);"></iframe> -->

	
<iframe src="<?php echo LIB_DIR ?>/pdf/pdfjs-3.0.279-dist/web/viewer.html?file=<?php echo $file_view_link ?>" width="100%" height="920px"></iframe>
