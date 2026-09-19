<?php
	define("PATH_CURRENT",dirname(__FILE__));
	define("PATH_INC",PATH_CURRENT."/inc_php");
	define("PATH_CONFIG",PATH_CURRENT."/config");
	
	try{
		require_once(PATH_INC."/"."functions_general.php");
		require_once(PATH_CONFIG."/"."config.php");
		require_once(PATH_INC."/"."defines.php");
		require_once(PATH_INC."/"."functions.class.php");
		require_once(PATH_INC."/"."system_config.php");	
		
		Functions::doStartupValidations();			//do some validations
				
		santizeAllRequests();		//sanitize get or post variables
		
		$action = getPostGetVariable("clientAction");
		$fromObject = getPostGetVariable("fromObject");
		
		//include login script:
		switch($action){		
			case "uploadfile":		
			break;
			default:
				require_once "inc_cms/login.php";
			break;
		}

		//images actions
		switch($action){	
			case "showimage":
				require_once(PATH_INC."/"."functions_imageView.php");
				$filename = getPostGetVariable("img","");
				$maxWidth = getPostGetVariable("w",-1);
				$maxHeight = getPostGetVariable("h",-1);
				$type = getPostGetVariable("t","");
				showImage($filename,$maxWidth,$maxHeight);
				exit();
			break;
		}	
	
		require_once(PATH_INC."/"."functions_imageView.php");
		require_once(PATH_INC."/"."functions_images.php");
		require_once(PATH_INC."/"."functions_category.php");
		require_once(PATH_INC."/"."functions_uploaded.php");
		require_once(PATH_INC."/"."functions_items.php");
		require_once(PATH_INC."/"."array2xml.class.php");
	
	// GLOBALS:
		//create global $database
		createDatabaseGlobal();
		
	//---------------------------------------------------------------------------------------------------
		switch($action){			
			//============================ general actions ================================================
			case "checkLogin":
				$user = getPostGetVariable("user");
				$pass = getPostGetVariable("pass");
				$response = checkLogin($user,$pass);
				showXml($response);
			break;
			case "getInitSettings":
				$response = getInitSettings();
				showXml($response);
			break;		
			case "getTemplatesList":
				$response = getTemplatesList();
				showXml($response);
			break;
					
			//=============================== category actions ========================================================			
			case "addEmptyCategory":
				$response = addEmptyCategory();
				showXml($response);
			break;
			case "addDefaultCategories":
				$response = addDefaultCategories();
				showXml($response);
			break;
			case "addCategory":
				$categoryName = getPostVariable("categoryName");
				$response = addCategory($categoryName);
				showXml($response);
			break;
			case "getCategoriesList":
				$response = getCategoriesList();
				if(isset($_POST["actionAfter"])) $response["actionAfter"] = $_POST["actionAfter"];
				showXml($response);
			break;
			case "deleteCategory":
				$categoryID = getPostVariable("categoryID");
				$response = deleteAllCategoryItems($categoryID);
				if($response["success"] == false){
					showXml($response);
					exit();
				}
				$response = deleteCategory($categoryID);
				showXml($response);
			break;
			case "setCategoryOrder":
				$categoryID = getPostVariable("categoryID");
				$targetCategoryID = getPostVariable("targetCategoryID");
				$response = setCategoryOrder($categoryID,$targetCategoryID);
				showXml($response);
			break;
			case "deleteAllCategories":
				$response = $database->deleteTable(TABLE_CATEGORIES);
				showXml($response);
			break;
			case "saveCategoriesOrder":	
				$strJsonOrders = $_POST["strJsonOrders"];
				$arrCategoryOrders = getJsonObj($strJsonOrders);
				$response = setCategoryOrders_array($arrCategoryOrders);
				showXml($response);
			break;
			
			//=============================== upload actions ========================================================
			case "deleteUploadedSelectedFiles":	
				$strJsonFilenames = $_POST["strJsonFilenames"];
				$arrFilesnames = getJsonObj($strJsonFilenames);
				$response = deleteUploadedSelectedFilenames($arrFilesnames);
				showXml($response);
			break;
			case "deleteAllUploadedFiles":
				$response = deleteAllUploadedFiles();
				showXml($response);
			break;
			case "getUploadedFilesList":
				$response = getUploadedFilesList();
				if(isset($_POST["actionAfter"])) $response["actionAfter"] = $_POST["actionAfter"];
				showXml($response);
			break;
			case "getUploadedNumItems":
				$numItems = getUploadedNumItems();
				$arrResponse = array("success"=>true,"numItems"=>$numItems);
				showXML($arrResponse);
			break;
			case "moveUploadedItemsToCategory":	
				$strJsonFilenames = $_POST["strJsonFilenames"];
				$arrFilenames = getJsonObj($strJsonFilenames);
				$categoryID = $_POST["categoryID"];
				$autoDeleteWrongType = (Boolean)$_POST["autoDeleteWrongType"];
				$response = moveUploadedItemsToCategory($arrFilenames,$categoryID,$autoDeleteWrongType);
				updateCategoryNumItems($categoryID);
				showXML($response);
			break;
			case "moveAllUploadedItemsToCategory":
				$categoryID = getPostGetVariable("categoryID","");
				$response = moveAllUploadedItemsToCategory($categoryID);
				updateCategoryNumItems($categoryID);
				showXML($response);			
			break;
			case "uploadfile":
				treatUploadedFile();
			break;
			
			//---------------------------  Items --------------------------------
			
			case "getCategoryItems":
				$categoryID = $_POST["categoryID"];			
				$response = getCategoryItems($categoryID);
				showXml($response);
			break;
			case "getCategoryItemsOthers":		//get list of category items that not listed in current items.
				
				$categoryID = $_POST["categoryID"];
				$strCurrentItems = $_POST["strCurrentItems"];						
				$response = getCategoryItems_diff($categoryID,$strCurrentItems);			
				showXml($response);
			break;
			case "getCategoryItemsRemoved":
				
				$categoryID = $_POST["categoryID"];
				$strCurrentItems = $_POST["strCurrentItems"];
				$response = getArrRemovedItemIDs($categoryID,$strCurrentItems);
				showXml($response);
			break;
			case "setItemsOrder":
				
				$strJsonItems = $_POST["strJsonItems"];
				$arrItems = getJsonObj($strJsonItems);
				$response = setItemsOrder($arrItems);
				showXml($response);
			break;
			case "deleteCategoryItems":
				$strItemIDs = $_POST["strItemIDs"];
				$categoryID = $_POST["categoryID"];
				$strItemIDs = trim($strItemIDs);
				if($strItemIDs == "") $arrItemIDs = array();
				else $arrItemIDs = explode(",",$strItemIDs);
				$response = deleteItems($arrItemIDs);
				$response["categoryID"] = $categoryID;
				updateCategoryNumItems($categoryID);
				showXml($response);			
			break;
			case "updateItem":
				$itemID = $_POST["itemID"];
				$itemName = $_POST["itemName"];
				$itemDesc = $_POST["itemDesc"];
				$itemLink = $_POST["itemLink"];
				$response = updateItem($itemID,$itemName,$itemDesc,$itemLink);
				showXml($response);
			break;
			case "updateCategory":				
				$catID = $_POST["id"];
				$catName = $_POST["title"];
				$catDesc = $_POST["catDesc"];
				$catLongDesc = $_POST["longDesc"];
				$response = updateCategory($catID,$catName,$catDesc,$catLongDesc);
				showXml($response);			
			break;
			case "copyItemsToCategory":
				
				$strSelectedItems = $_POST["strSelectedItems"];
				$categoryID = $_POST["categoryID"];
				if($strSelectedItems == "") $response = errorResponse("No items found");
				else {
					$arrItems = explode(",",$strSelectedItems);	
					$response = copyItemsToCategory($arrItems,$categoryID);
					if($response["success"] == true) updateCategoryNumItems($categoryID);
				}
				showXml($response);
			break;
			case "moveItemsToCategory":
				
				$strSelectedItems = $_POST["strSelectedItems"];
				$categoryID = $_POST["categoryID"];
				if($strSelectedItems == "") $response = errorResponse("No items found");
				else {
					$arrItems = explode(",",$strSelectedItems);	
					$response = moveItemsToCategory($arrItems,$categoryID);
					updateCategoriesNumItems();
				}
				showXml($response);			
			break;
			case "duplicateItem":
				$categoryID = $_POST["categoryID"];
				$itemID = $_POST["itemID"];
				$response = copyItemToCategory($itemID,$categoryID,"duplicate");
				if($response["success"] == true){
					updateCategoryNumItems($categoryID);
				}
				
				showXml($response);
			break;
			case "downloadItem":
				$itemID = getPostGetVariable("itemID");
				downloadItem($itemID);
			break;
			
			//--------- templates functions --------------------
			
			case "addTemplate":
				
				$title = $_POST["dialogTitle"];
				$text = $_POST["dialogText"];
				$response = addNewTempalte($title,$text);
				showXml($response);
			break;
			case "removeTemplate":
				
				$templateID = $_POST["templateID"];
				$response = removeTemplate($templateID);
				showXml($response);
			break;
			case "saveTemplateData":
				
				$templateID = $_POST["templateID"];
				$templateData = $_POST["templateData"];
				$response = updateTemplate($templateID,array("data"=>$templateData));			
				showXml($response);			
			break;
			case "updateTemplateTitle":
				
				$templateID = $_POST["templateID"];
				$templateTitle = $_POST["templateTitle"];
				
				$response = updateTemplate($templateID,array("title"=>$templateTitle));			
				showXml($response);			
			break;
			case "test":
				downloadItem(10);
				//addItem_image("D:/xampp/htdocs/activeden/admin/main/dev/upload/5.jpg","image1.jpg",2);
			break;
			default:
				showXml(errorResponse("wrong action: $action"));
			break;
		}
	
	}catch(Exception $e) {
		$response = errorResponse($e->getMessage());
		showXml($response);
		exit();
	}	
	
?>

