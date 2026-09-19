<?php 
	//write a head section of a gallery page
	function writeHeadSection(){
		?>
			<script type="text/javascript">
				var g_urlMain = "main.php";
				
				//-----------------------------------------------------------------------------------------
				// get call from flash
				function flashCall(argData){		
					$.ajax({
						  url: g_urlMain,
						  type: "POST",
						  data: (argData),
						  success: function(response){
							toFlash(response);
						  },
						  error:function(response){
							//trace("error!!!");
						  }
					   }
					)//ajax
				}
				
				//-----------------------------------------------------------------------------------------
				//send data from flash
				function toFlash(text){
					var adminObj = document.getElementById("admin");				
					adminObj.sendToFlash(text);
				}
				
				//-----------------------------------------------------------------------------------------
				
				function putFlash(){
					var flashvars = {};
					flashvars.url_server = "main.php";
					var params = {};
					//params.wmode = "transparent";
					var attributes = {};		
					attributes.id = "admin";
					
					swfobject.embedSWF("admin.swf", "flashcontent", "895", "640", "9", "inc_js/expressInstall.swf", flashvars, params, attributes);
				}
								
			</script>
		<?php
	}
	
	//--------------------------------------------------------------------------------------------------
	// write a body section of a gallery page.
	function writeBodySection(){
		?>
			<div id="flashcontent"></div>
			<script language="javascript">
				putFlash();
			</script>			
		<?php
	}
	
?>