<?php 
	
	//write a head section of a gallery page
	function writeHeadSection(){
	}
	
	//--------------------------------------------------------------------------------------------------
	// write a body section of a gallery page.
	function writeBodySection(){
		$response = getUploadedFilesList();
		$arrFiles = $response["arrUploadedFiles"];
		$numFiles = count($arrFiles);
		
		global $database;
		global $g_settings;
		$g_settings = new AdvancedSettings($database);
		$g_settings->addCategoriesSelect("category","Select category");
		
		?>
			<div style="padding-left:50px;height:400px;">
				<br>
				
				<b>Move all images from 'uploaded' folder to category<?php if($numFiles > 0) echo " (".$numFiles."images)"?>:
				 </b>
				<br>
				<br>
				
				<div style="clear:none;height:30px;">
					<?php $g_settings->draw(); ?> 				
				</div>			
					<input id="butCopy" <?php if($numFiles == 0) echo 'disabled="true"'?>  type="button" value="Move All Images" onclick="onCopyClick()"></button>
					<span id="txtResult" style="display:none;"></span>
				<br>
				<br>
			</div>
			
			<script language="javascript">
				
				function bringButtonBack(){
					$("#txtResult").hide();
					$("#butCopy").show();
					$("#butCopy").attr("disabled",true);
				}
				
				function onCopyClick(){
					var catID = $("#category").val();

					$("#butCopy").hide();
					$("#txtResult").show();
					$("#txtResult").html("Moving");
					
					$.ajax({
						  type: 'POST',
						  url: "main.php",
						  data: {categoryID:catID,clientAction:"moveAllUploadedItemsToCategory"},
						  success: function(response){
								$("#txtResult").html("Move succeess");
								setInterval('bringButtonBack()',500);
						  },
						  error:function(){
								alert("Error copying files!!!");
								$("#butCopy").show();
								$("#txtResult").hide();								
						  },
						  dataType: "post"
					});					
				}				
			</script>
			
		<?php
	}
	
?>