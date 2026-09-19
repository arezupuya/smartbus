<?php	
	define("PATH_CURRENT",dirname(__FILE__));
	define("PATH_INC",PATH_CURRENT."/inc_php");
	define("PATH_CONFIG",PATH_CURRENT."/config");
	
	try{
		include(PATH_INC."/"."functions_general.php");
		require_once(PATH_CONFIG."/"."config.php");
		require_once(PATH_INC."/"."defines.php");
		require_once(PATH_INC."/"."functions.class.php");
		require_once(PATH_INC."/"."system_config.php");
		
		Functions::doStartupValidations();			//do some validations
		
		require_once(PATH_INC."/"."functions_imageView.php");

		santizeAllRequests();

		$action = getPostGetVariable("clientAction");	
		if($action == "") $action = getPostGetVariable("action");
		
		if($action == "" && getPostGetVariable("img","") != "") 
			$action = "showimage";		
		
		//images actions
		switch($action){	
			case "showimage":
				$filename = getPostGetVariable("img","");
				$maxWidth = getPostGetVariable("w",-1);
				$maxHeight = getPostGetVariable("h",-1);
				$type = getPostGetVariable("t","");
				showImage($filename,$maxWidth,$maxHeight,$type);
				exit();
			break;
			case "download":
				$filename = $_GET["img"];
				downloadImage($filename);
				exit();
			break;
		}
		
		$g_provider = getPostGetVariable("provider","json");
		
		$templateID = getPostGetVariable("templateid","");
		$templateTitle = getPostGetVariable("template","");
		if($action == "" && ($templateID != "" || $templateTitle != "")) $action = "getParsedTemplate";
		
		include(PATH_INC."/"."functions_images.php");
		include(PATH_INC."/"."functions_category.php");
		include(PATH_INC."/"."functions_uploaded.php");
		include(PATH_INC."/"."functions_items.php");
		include(PATH_INC."/"."settings.class.php");
		include(PATH_INC."/"."advanced_settings.class.php");
		include(PATH_INC."/"."functions_gallery.php");
		include(PATH_INC."/"."array2xml.class.php");
				
		// GLOBALS:
		//create global $database
		createDatabaseGlobal();
		
		//set the g_settings		
		require_once "inc_cms/page_settings.php";		
		
		
		//---------------------------------------------------------
		//filter categories list with certain fields
		function filterCategoriesList($categories){
			$fields = array("id","name","catDesc","longDesc","numItems");
			foreach($categories as $key => $category)
				$categories[$key] = Functions::filterArrFields($category,$fields);
			return($categories);
		}
		
		//---------------------------------------------------------
		
		switch(strtolower($action)){
			case "":			
			case "getdata":
				$response = getAllGalleryData();
				output($response,true);
			break;
			case "getcss":
				include(PATH_INC."/"."gallery_css_output.class.php");
				$settings = $g_settings->getArrSavedSettings();
				$css = new GalleryCssOutput();
				$css->setSettings($settings);
				$css->putCSS();
			break;
			case "getcategories":
				$response = getCategoriesList();
				$categories = filterCategoriesList($response["categories"]);
				output($categories,true);				
			break;
			default:
				$response = errorResponse("wrong action: ".$action);						
				output($response);
			break;
		}
		
	}catch(Exception $e) {
		$response = errorResponse($e->getMessage());
		output($response);
		exit();
	}
	
?>