<?php 
		
	//write a head section of a gallery page
	function writeHeadSection(){
		global $link;
		?>
		    <script type="text/javascript" src="inc_cms/js/jquery.lightbox-0.5.min.js"></script>
			<script type="text/javascript" src="inc_cms/js/jquery.easy_lightbox_gallery.min.js"></script>
		<?php
	}
	
	//--------------------------------------------------------------------------------------------------
	// write a body section of a gallery page.
	function writeBodySection(){
		?>
			<div id="gallery" align='center'>Loading gallery...</div>
			<div style='clear:both;'></div>
			<script language="javascript">
				$("#gallery").putEasyGallery({url_server:"gallery.php"});
			</script>
						
		<?php
	}
	
?>