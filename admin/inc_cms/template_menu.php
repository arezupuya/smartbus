<?php
	function template_putMenu($page){
		$base = $_SERVER["PHP_SELF"];
		
		$class_settings = "";
		$class_gallery = "";
		$class_preview = "";
		$class_tools = "class='right'";
		
		$text_settings = "<a href='$base'>Settings</a>";		
		$text_preview = "<a href='".$base."?page=preview'>Preview</a>";
		$text_tools = "<a href='".$base."?page=tools'>Tools</a>";
		
		if(USER_PERMISSION == LOGIN_PERMISSIONS_ADMIN)
			$text_gallery = "<a href='".$base."?page=gallery'>Gallery</a>";
		else 
			$text_gallery = "<a href='".$base."'>Gallery</a>";
		
		switch($page){
			case "gallery":
				$class_gallery = "class='selected'";
				$text_gallery = "<span>Gallery</span>";				
			break;
			case "preview":
				$class_preview = "class='selected'";
				$text_preview = "<span>Preview</span>";
			break;
			default:
			case "settings":
				//admin permissions - settings as main page
				if(USER_PERMISSION == LOGIN_PERMISSIONS_ADMIN){
					$class_settings = "class='selected'";
					$text_settings = "<span>Settings</span>";				
				}
				else{	//user permissions - gallery as main page 
					$class_gallery = "class='selected'";
					$text_gallery = "<span>Gallery</span>";
				}				
			break;
			case "tools":
				//admin permissions - settings as main page
				if(USER_PERMISSION == LOGIN_PERMISSIONS_ADMIN){
					$class_tools = "class='right selected'";
					$text_tools = "<span>Tools</span>";
				}
				else{	//user permissions - gallery as main page 
					$class_gallery = "class='selected'";
					$text_gallery = "<span>Gallery</span>";
				}
			break;
		}
		
		?>
		
		<table class="tableMenuWrapper" cellpadding=0 cellspacing=0 width="100%">
			<td class="cellLeft"></td>
			<td class="cellMiddle">
					<ul class="mainMenu">
					<?php if(USER_PERMISSION == LOGIN_PERMISSIONS_ADMIN): ?>
						<li <?php echo $class_settings?>>
							<?php echo $text_settings?>
						</li>
					<?php endif ?>
						<li <?php echo $class_gallery?>>
							<?php echo $text_gallery?>
						</li>
						<li <?php echo $class_preview?>>
							<?php echo $text_preview?>
						</li>
					<?php if(USER_PERMISSION == LOGIN_PERMISSIONS_ADMIN): ?>
						<li <?php echo $class_tools?>>
							<?php echo $text_tools?>
						</li>
					<?php endif ?>
					</ul>					
			</td>
			<td class="cellRight"></td>
		</table>
		
		<?php
	} 
?>