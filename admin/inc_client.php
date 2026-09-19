<?php
	define("PATH_CURRENT",dirname(__FILE__));
	define("PATH_INC",PATH_CURRENT."/inc_php");
	define("PATH_CMS_INC",PATH_CURRENT."/inc_cms");
	define("PATH_CONFIG",PATH_CURRENT."/config");
	
	require_once(PATH_CONFIG."/"."config.php");
	require_once(PATH_INC."/"."defines.php");
	require_once(PATH_INC."/"."functions.class.php");
	require_once(PATH_INC."/"."system_config.php");
	require_once(PATH_INC."/"."functions_general.php");
	require_once(PATH_INC."/"."functions_category.php");
	require_once(PATH_INC."/"."settings.class.php");
	require_once(PATH_INC."/"."advanced_settings.class.php");

	// GLOBALS:
	//create global $database
	createDatabaseGlobal();
	
	//====================================================
	//				Functions for client
	//====================================================
	
	//----------------------------------------------------
	//get default category
	function getDefaultCategory(){
		global $database;
		$settings = new Settings($database);		
		$settings->addSection("blabla");
		$settings->addSap("blabla");		
		$settings->addTextBox("category","","Category");
		$arrSettings = $settings->getArrSavedSettings();
		$category = $arrSettings["category"];
		return($category);
	}
	
	//----------------------------------------------------
	//get categories list for client
	function getCategories(){
		//get actegories
		$response = getCategoriesList();
		$categories = $response["categories"];
		
		//filter categories with just needed items
		$fields = array("id","name","catDesc","longDesc","numItems");
		foreach($categories as $key => $category)
			$categories[$key] = Functions::filterArrFields($category,$fields);
		
		return($categories);
	}
	
?>