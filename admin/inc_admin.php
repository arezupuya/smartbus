<?php
	define("PATH_CURRENT",dirname(__FILE__));
	define("PATH_INC",PATH_CURRENT."/inc_php");
	define("PATH_CMS_INC",PATH_CURRENT."/inc_cms");
	define("PATH_CONFIG",PATH_CURRENT."/config");
	
	require_once(PATH_INC."/"."functions_general.php");
	require_once(PATH_CONFIG."/"."config.php");
	require_once(PATH_INC."/"."defines.php");
	require_once(PATH_INC."/"."functions.class.php");
	require_once(PATH_INC."/"."system_config.php");	
	
	Functions::doStartupValidations();
	Functions::doStartupCMSValidations();
	
	require_once "inc_cms/login.php";
	
	require_once(PATH_CMS_INC."/"."utils.class.php");
	require_once(PATH_INC."/"."functions_imageView.php");
	require_once(PATH_INC."/"."functions_images.php");
	require_once(PATH_INC."/"."functions_category.php");
	require_once(PATH_INC."/"."functions_uploaded.php");
	require_once(PATH_INC."/"."functions_items.php");
	require_once(PATH_INC."/"."settings.class.php");
	require_once(PATH_INC."/"."advanced_settings.class.php");
	require_once(PATH_INC."/"."array2xml.class.php");

	// GLOBALS:
	//create global $database
	createDatabaseGlobal();
	
?>