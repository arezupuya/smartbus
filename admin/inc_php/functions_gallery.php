<?php
	$g_arrAlowedSettings = array(
		"thumb_text_vert_pos"
		,"thumb_text"
		,"thumb_image_width"
		,"thumb_image_height"
		,"view_image_resize"
		,"view_image_width"
		,"view_image_height"
		,"view_overlay_opacity"
		,"view_overlay_color"
		,"view_fixed_navigation"
		,"view_resize_speed"
		,"view_txt_image"
		,"view_txt_of"
		,"view_key_close"
		,"view_key_prev"
		,"view_key_next"
		,"images_admin_url"
		,"view_use_images_default_url"
		,"view_image_loading"
		,"view_image_prev"
		,"view_image_next"
		,"view_image_close"
		,"view_image_blank"
		,"view_text_fields"
		,"view_show_text_numbers"
		,"category"
		,"thumbs_columns_enable"
		,"thumbs_num_cols"
		,"navigation_deeplink"
		,"empty_category_display_text"
		,"empty_category_text"
		,"empty_category_use_custom_class"
		,"empty_category_class"
		,"enable_caching"
		,"enable_links"
		,"links_target_self"
	);
	
	//------------------------------------------------------------------------------
	// check if there is a need to add categories to the response, and add it.
	function getItemResponse(){
			$itemID = getPostGetVariable("itemid");
			
			//get item data:
			$response = getItemData($itemID);
			if($response["success"] == false){
				output($response);
				exit();
			}
			
			$itemData = $response["data"];
			$catID = $itemData["categoryID"];
			
			//get category data:			
			$responseCategory = getCategory($catID);
			
			if($responseCategory["success"] == false){
				output($responseCategory);
				exit();
			}
			$categoryData = $responseCategory["data"];
			
			//get items if that category:
			$responseItems = getCategoryItemsShort($catID);
			if($responseItems["success"] == false){
				output($responseItems);
				exit();
			}
			
			$arrItems = $responseItems["arrItems"];
			
			//set next and previous item, first and last item id
			$nextItemID = "";
			$prevItemID = "";
			$flagExit = false;
			for($i=0;$i<count($arrItems) && $flagExit == false;$i++){
				if($arrItems[$i]["id"] == $itemID){
					if($i>=1) $prevItemID = $arrItems[$i-1]["id"];
					if($i<count($arrItems)-1) $nextItemID = $arrItems[$i+1]["id"];
					$flagExit = true;
				}
			}
			
			$itemData["fistItemID"] = $arrItems[0]["id"];
			$itemData["lastItemID"] = $arrItems[count($arrItems)-1]["id"];
			$itemData["nextItemID"] = $nextItemID;
			$itemData["prevItemID"] = $prevItemID;
			
			$response = array("success"=>true,"itemData"=>$itemData,"categoryData"=>$categoryData,"arrItems"=>$arrItems);
			$response = checkAddCategories($response);		//check add categories
			
			output($response);
	}
	
	//------------------------------------------------------------------------------
	//return array of categories with all items inside
	function getCategoriesWithData($catID = -1,$strict = false){
		
		$errorMessage = "Category with id: $catID doesn't exists. Please choose another category.";
		
		$arrAllCategories = array();
		
		if($catID != -1){			
			//get categories - single:
			$response = getCategory($catID);
			
			//if no category exists - take a first one
			if($response["success"] == false){
				
				if($strict == true) 
					throw new Exception($errorMessage);
				
				$response = getCategoriesShort(0,false);
				$categories = $response["categories"];
				$arrAllCategories = $categories;
				
				if(empty($categories)) $catID = -1;
				else{
					$cat = $categories[0];
					$categories = array($cat);
				}				
			}
			else{				//the category found - take it.				
				$cat = $response["data"];
				
				//throw error if the category is not "normal" - like upload or default
				if($strict == true && $cat["type"] != "normal") 
					throw new Exception($errorMessage);
				
				$categories = array($cat);
			}
		}
		
		//get categories - no items:
		if($catID == -1){
			$cat = array();
			$cat["id"] = 0;
			$cat["title"] = "none";
			$cat["items"] = array();
			$arrCategories = array($cat);
			$response = array("success"=>true,"categories"=>$arrCategories,"categoriesList"=>array());
			return($response);			
		}
		
		//get categories list
		if(empty($arrAllCategories)){
			$response = getCategoriesShort(0,false);
			$arrAllCategories = $response["categories"];
		}			
		
				
		foreach($categories as $key=>$category){
			//filter category
			$arrCategory = array();
			$arrCategory["id"] = $category["id"];
			$arrCategory["title"] = $category["name"];
			
			//get items:
			$response = getCategoryItems($category["id"]);
			if($response["success"] == false) output($response);
			
			$arrItems = array();
			//filter items
			foreach($response["arrItems"] as $item){
				$arrItem = array();
				$arrItem["id"] = $item["id"];
				$arrItem["filename"] = $item["filename"];
				$arrItem["title"] = $item["name"];
				$arrItem["description"] = $item["itemDesc"];
				$arrItem["link"] = $item["link"];
				$arrItems[] = $arrItem;
			}
			$arrCategory["items"] = $arrItems;
			$arrCategories[] = $arrCategory;			
		}		
		$response = array("success"=>true,"categories"=>$arrCategories,"categoriesList"=>$arrAllCategories);
		return($response);
	}		
	
	//------------------------------------------------------------------------------
	//output custom xml
	function outputGalleryXml($data){
		$xml = '<?xml version="1.0" encoding="UTF-8"?>';
		$settings = $data["settings"];
		$xml .= "<gallery>";
		
		// add settings:
		$xml .= "<settings ";
		foreach($settings as $name=>$value){
			$xml .= $name.'="'.$value.'" ';
		}
		$xml .= "/>";
		
		$xml .= "</gallery>";
		header("content-type: text/xml");
		echo $xml;
	}
	
	//------------------------------------------------------------------------------
	//get items array of the first category. if empty - remove empty array
	function getFirstCategoryItems($arrCategories){
		$arrItems = array();
		if(!empty($arrCategories)){
			$arrItems = $arrCategories[0]["items"];
		}
		return($arrItems);
	}
	
	//------------------------------------------------------------------------------
	//filter client settings
	function filterClientSettings($settings){
		global $g_arrAlowedSettings;
		$filteredSettings = array();
		foreach($settings as $key=>$val)
			if(in_array($key,$g_arrAlowedSettings) !== false) 
				$filteredSettings[$key] = $val;
		return($filteredSettings);
	}
	
	//------------------------------------------------------------------------------
	//return array of gallery data
	function getAllGalleryData(){
		global $g_settings;
		$data = "";
		$settings = $g_settings->getArrSavedSettings();
		
		//get category id
		if(isset($_POST["catid"]) && trim($_POST["catid"] != "")){
			$strict = true;			//get an error message if category don't exists
			$catID = $_POST["catid"];
			$settings["category"] = $catID;
		}	
		else{
			$strict = false;
			$catID = $settings["category"];
		}
		
		$client_settings = filterClientSettings($settings);
		
		//add images url to settings:
		$client_settings["images_admin_url"] = URL_SITE.DIR_ALL_IMAGES."/lightbox/";
		
		//if first request - get settings, and activate deeplink
		if(!isset($_POST["active"]) || $_POST["active"] == "false"){
		
			//deep linking:
			if($settings["navigation_deeplink"] == "true"){
				$deeplinkCatID = getPostVariable("deeplink_catid","");
				if(trim($deeplinkCatID) != ""){
					$catID = $deeplinkCatID;
					$client_settings["category"] = $deeplinkCatID;
				}
			}		
			
			//copy client settings to client
			$data["settings"] = $client_settings;			
		}
		else{	//if not first time, don't pass settings
			$data["settings"] = "";
		}
		
		$response = getCategoriesWithData($catID,$strict);
		$arrItems = getFirstCategoryItems($response["categories"]);
		
		//set items and categories list		
		$data["catlist"] = $response["categoriesList"];		
		$data["items"] = $arrItems;
		$data["success"] = true;
		return($data);
	}
	
?>