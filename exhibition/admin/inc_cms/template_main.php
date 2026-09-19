<?php	
	$g_page = getGetVariable("page","settings");
	
	$title = TEXT_TITLE_BASE;
	switch($g_page){
		case "gallery":
			require_once "inc_cms/page_gallery.php";
			$title =  TEXT_TITLE_BASE . ' - Gallery';
		break;
		case "preview":
			require_once "inc_cms/page_preview.php";
			$title =  TEXT_TITLE_BASE . ' - Preview';
		break;
		
		default:	
		case "settings":
			if(USER_PERMISSION == LOGIN_PERMISSIONS_ADMIN) 
					require_once "inc_cms/page_settings.php";
			else {
				require_once "inc_cms/page_gallery.php";
				$title =  TEXT_TITLE_BASE . ' - Gallery';
			}
		break;
		case "tools":
			if(USER_PERMISSION == LOGIN_PERMISSIONS_ADMIN) {
				require_once "inc_cms/page_tools.php";
				$title =  TEXT_TITLE_BASE . ' - Tools';
			}
			else {
				require_once "inc_cms/page_gallery.php";
				$title =  TEXT_TITLE_BASE . ' - Gallery';
			}
		break;
	}
	
	define("PAGE_TITLE",$title);
	
	require_once "inc_cms/template_menu.php";

	//----------------------------------------------------------------------------------------
	//put the header section of the template
	function putHeader(){
				
		?>
			<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
		<html xmlns="http://www.w3.org/1999/xhtml">
			<head>
			<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
			<title><?php echo PAGE_TITLE?></title>
			<script type="text/javascript" src="inc_js/swfobject.js"></script>
			<script type="text/javascript" src="inc_js/jsfunc.js"></script>
			<script type="text/javascript" src="inc_js/jquery.js"></script>
			<script type="text/javascript" src="inc_js/json.js"></script>
			<script type="text/javascript" src="inc_js/application.js"></script>
			
			<link rel="stylesheet" href="inc_css/common_styles.css" type="text/css" />
			<link rel="stylesheet" href="<?php echo URL_THEME ?>styles.css" type="text/css" />
			
			<?php writeHeadSection() ?>
						
			<script language="javascript">
				var g_self = "<?php echo $_SERVER["PHP_SELF"]?>";
			</script>
			
			</head>
			<body>
				<div id="div_debug"></div>
		<?php
	}
	
	//----------------------------------------------------------------------------------------
	//put the footer of the template
	function putFooter(){
		?>
			</body>
		</html>
		<?php
	}
	
	//----------------------------------------------------------------------------------------
	// put the header section (the top line)
	function template_putHeaderSection(){
		?>
			<div class="caption">
				<?php echo TEXT_TOP_PRODUCT?>
			</div>
			<div class="userInfo">
				<?php drawLoggedInText(); ?>
			</div>
		<?php	
	}
	
	//----------------------------------------------------------------------------------------
	// put the template
	function putTemplate(){
		global $g_page;						
		putHeader();
		?>
				
		<div class="divMain">
			<div class="divHeaderSection">
				<?php template_putHeaderSection()?>
			</div>		
			<div class="divBodySection">
				<div class="divBodyWrapperTop pngfix"></div>
				<div class="divWrapperMiddle pngfix">
					<div class="divMainMenu">		
						<?php template_putMenu($g_page);?>						
					</div>
					<div class="divTabContent">
						<?php writeBodySection(); ?>
					</div>
				</div>
				<div class="divBodyWrapperBottom pngfix"></div> 				
			</div>
		</div>
		
		<?php putFooter();
	}
	
?>	