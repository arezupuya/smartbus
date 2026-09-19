<?php
	
	//--------------------------------------------------------------------------------------------------------------	
	//create items table
	function createItemsTable(){
		global $database;
		$arrCreate = array();
		$arrCreate["id"] = Database::TYPE_KEY;
		$arrCreate["categoryID"] = Database::TYPE_NUMBER;
		$arrCreate["itemType"] = Database::TYPE_STRING;
		$arrCreate["itemID"] = Database::TYPE_NUMBER;
		$arrCreate["name"] = Database::TYPE_STRING;
		$arrCreate["itemDesc"] = Database::TYPE_TEXT;
		$arrCreate["link"] = Database::TYPE_STRING;
		$arrCreate["itemOrder"] = Database::TYPE_NUMBER;
		$arrCreate["timestampCreate"] = Database::TYPE_NUMBER;
		$arrCreate["timestampUpdate"] = Database::TYPE_NUMBER;
		
		$response = $database->createTable(TABLE_ITEMS,$arrCreate);
		return($response);
	}
	
	//--------------------------------------------------------------------------------------------------------------	
	//validate item type, return true/false
	function validateItemType($itemType){
		switch($itemType){
			case FILETYPE_IMAGE:
			case FILETYPE_MUSIC:
			case FILETYPE_VIDEO:
			case FILETYPE_FLASH:
			break;
				return(true);
			default:
				return(false);
			break;
		}
	}
	
	//--------------------------------------------------------------------------------------------------------------	
	// craete items table and add item to database.
	function addItemToDatabase($arrInsert){
			
		global $database;
		$errorMessage = "Can't add item to database";
		
		//validation:
		if($arrInsert["categoryID"] == "") return(errorResponse("Can't add item to database, no category gived"));
		
		if(validateItemType($arrInsert["itemType"]) == false) errorResponse("Can't add item to database, wrong item type");
		
		if($arrInsert["itemID"] == "") return(errorResponse("Can't add item to database, itemID empty"));
		if($arrInsert["name"] == "") return(errorResponse("Can't add item to database, item should have a name"));
		
		$response = createItemsTable();
		
		if($response["success"] == false) return(errorResponse($errorMessage));
		
		$response = $database->getMaxValue(TABLE_ITEMS,"itemOrder","categoryID='".$arrInsert["categoryID"]."'");
		
		if($response["success"] == false) return(errorResponse($errorMessage));
		$maxOrder = $response["maxValue"];
		$maxOrder++;
		
		$arrInsert["itemOrder"] = $maxOrder;
		$stamp = mktime();
		$arrInsert["timestampCreate"] = $stamp;
		$arrInsert["timestampUpdate"] = $stamp;	
		
		$response = $database->insert(TABLE_ITEMS,$arrInsert);
		
		if($response["success"] == false) return(errorResponse($errorMessage));
		$id = $response["lastID"];
		return(array("success"=>true,"id"=>$id));
	}
	
	//--------------------------------------------------------------------------------------------------------------	
	// process item row
	function processItemRow($row){
		$row["dateItemCreate"] = timestamp2Date($row["timestampCreate"]);
		$row["dateItemUpdate"] = timestamp2Date($row["timestampUpdate"]);
		return($row);
	}
	
	//--------------------------------------------------------------------------------------------------------------
	// process items rows and get additional data	
	function getItemsAdditionalData($rows){
		$errorMessage = "Can't get item from database.";
		$errorMessageType = "Can't get item from database. wrong type";
		
		$arrItems = array();
		foreach($rows as $arrItem){
			$arrItem = processItemRow($arrItem);
			
			// get real object data:		
			switch($arrItem["itemType"]){
				case FILETYPE_IMAGE:
					$response = getImageData($arrItem["itemID"]);
					if($response["success"] == false) return(errorResponse($errorMessage));
					$arrImage = $response["arrImage"];				
									
					foreach($arrImage as $key=>$value){
						if(!isset($arrItem[$key])) $arrItem[$key] = $value;				
						else{		//same name:
							switch($key){
								case "timestampCreate":
									$arrItem["timestampImageCreate"] = $value;
								break;
								case "timestampUpdate":
									$arrItem["timestampImageUpdate"] = $value;
								break;
								default:
								break;
							}						
						}
					}
				break;
				default:
					return(errorResponse($errorMessageType));
				break;
			}
			
			$arrItems[] = $arrItem;
		}
		return($arrItems);
	}
	
	//----------------------------------------------------------------------------------------------------	
	// get the data of the item together with inner object data
	function getItemData($itemID){
		$response = getItemsData($itemID);
		if($response["success"] == false) return($response);
		$arrItems = $response["arrItems"];
		return(array("success"=>true,"data"=>$arrItems[0]));
	}
	
	//--------------------------------------------------------------------------------------------------------------
	//the same as previous function, but with many items and not one.	
	function getItemsData($ids,$whereString=""){
		global $database;
		$errorMessage = "Cant get item from database.";
		$errorMessageType = "Cant get item from database. wrong type";
		
		$where = "";
		if($ids != "") $where = "id in($ids)";
		else if($whereString != "") $where = $whereString;
		
		$where = trim($where);
		
		//get item data:
		$response = $database->fetch(TABLE_ITEMS,$where);
		
		if($response["success"] == false) return(errorResponse($errorMessage)); 
		if(count($response["rows"]) == 0) return(errorResponse($errorMessage)); 
		$rows = $response["rows"];
		
		$arrItems = getItemsAdditionalData($rows);
		
		return(array("success"=>true,"arrItems"=>$arrItems));		
	}
	
	//==============================================================================================================
	
	//--------------------------------------------------------------------------------------------------------------	
	//gets item type by extention:
	function getFileType($filename){
		$info = Functions::getPathInfo($filename);
		$ext = strtolower($info["extension"]);
		switch($ext){
			case "jpg":
			case "jpeg":
			case "bmp":
			case "png":
			case "gif":
				return(FILETYPE_IMAGE);
			break;
			case "swf":
				return(FILETYPE_FLASH);
			break;
			case "flv":
				return(FILETYPE_VIDEO);
			break;
			case "mp3":
				return(FILETYPE_MUSIC);
			break;
			default:
				return(FILETYPE_OTHER);
			break;
		}
	}
	
	//--------------------------------------------------------------------------------------------------------------	
	//get filename of some directory that don't taken.
	function getTargetFilename($filename,$dir){
		$info = Functions::getPathInfo($filename);
		$name = $info["filename"];
		$ext = $info["extension"];
		
		$filepath = $dir ."/" . $filename;
		while(is_file($filepath) == true){
			$random = rand(1000,9999);		
			$filename = $name."_$random.".$ext;
			$filepath = $dir . "/" . $filename;
		}
		return($filename);
	}
	
	//--------------------------------------------------------------------------------------------------------------	
	//add image item to database
	function addItem_image($sourceFilepath,$filename,$categoryID){		
		global $database;
		
		$errorMessageDatabase = "Can't move file: $filename, can't add to database";
		$errorMessageItemsDatabase = "Can't move file: $filename, can't add item to database";
		$errorMovingImage = "Can't move image to the images location";

		$targetFilename = getTargetFilename($filename,PATH_IMAGES);
		$targetFilepath = PATH_IMAGES."/".$targetFilename;
		
		//add image to database:
		$arrImage = array();
		$arrImage["filename"] = $targetFilename;
		$info = Functions::getPathInfo($filename);
		$imageName = $info["filename"];
		$arrImage["name"] = $imageName;
		$arrImage["imageType"] = getImagetypeByExt($info["extension"]);
		
		$response = getimagesize($sourceFilepath);
		if(count($response)>=2){
			$arrImage["width"] = $response[0];
			$arrImage["height"] = $response[1];
		}
		
		//set image type by php function (more exact)
		if(count($response) >= 3) $arrImage["imageType"] = $response[2];
		
		//add image size
		if(function_exists("exif_read_data")){
			$response = exif_read_data($sourceFilepath);
			$arrImage["timestampFileCreate"] = getArrValue($response,"FileDateTime",0);
			$arrImage["filesize"] = getArrValue($response,"FileSize",0);
			$arrImage["orientation"] = getArrValue($response,"Orientation",0);
			if(isset($response["Model"])) $arrImage["camera"] = $response["Model"];
		}
		
		//add image to database.
		$response = addImageToDatabase($arrImage);
		if($response["success"] == false) return(errorResponse($errorMessageDatabase));
		$imageID = $response["id"];
		
		//add item to database.
		$arrInsert = array("categoryID"=>$categoryID,"itemType"=>FILETYPE_IMAGE,"itemID"=>$imageID,"name"=>$imageName);
		$response = addItemToDatabase($arrInsert);
		
		if($response["success"] == false){
			$database->delete(TABLE_IMAGES,"id=$imageID");
			return(errorResponse($errorMessageItemsDatabase));
		}
		$itemID = $response["id"];
		
		//moves the file to new location:
		$success = @rename($sourceFilepath,$targetFilepath);
		if($success == false){					
			//delete both items from the database.
			$database->delete(TABLE_ITEMS,"id=$itemID");
			$database->delete(TABLE_IMAGES,"id=$imageID");
			return(errorResponse($errorMovingImage));
		}
		
		$response = getItemData($itemID);
				
		return($response);
	}
	
	//--------------------------------------------------------------------------------------------------------------	
	//move item to some category.
	function moveUploadedItemToCategory($filename,$categoryID,$autoDeleteWrongType = false){
		global $database;
		
		$errorMessageType = "Can't move file: $filename, wrong type";		
		$errorNoSuchFile = "Can't move file: $filename, there is no such file: $filename";
		
		$filetype = getFileType($filename);
		
		$sourceFilepath = PATH_UPLOAD."/".$filename;
		
		if(!is_file($sourceFilepath)) return(errorResponse($errorNoSuchFile));
		
		//get target filename and target filepath, move the item to relative location, and add the item to database.
		switch($filetype){
			case FILETYPE_IMAGE:
				return(addItem_image($sourceFilepath,$filename,$categoryID));
			break;
			default:
				if($autoDeleteWrongType == true) unlink($sourceFilepath);
				return(errorResponse($errorMessageType));
			break;
		}
		
	}
	
	//--------------------------------------------------------------------------------------------------------------	
	//get all or part items that belong to some category. with paging or without, if strcurrentitems given, give all items besides those that in strCurrentItems
	function getCategoryItems_work($categoryID,$flagPaging=false,$page=1,$inPage=10,$strCurrentItems=""){
		global $database;
		
		$errorMessageNoCategory = "Can't get category items. No category given!!!";
		$errorMessage = "Can't get category items.";
		$errorMessageCreateTable = "Can't get items - can't create items table.";
				
		if($categoryID == "") clientResponseExit($errorMessageNoCategory);
		//$response = $database->fetch(TABLE_ITEMS,"categoryID='$categoryID'","itemOrder");
		
		$secondCondition = "";
		if($strCurrentItems != "") $secondCondition = " and id not in($strCurrentItems)";
		
		$whereString = "categoryID in($categoryID)".$secondCondition;
		
		if($flagPaging == true) $response = $database->fetchPage($page,$inPage,TABLE_ITEMS,$whereString,"itemOrder");
		else $response = $database->fetch(TABLE_ITEMS,$whereString,"itemOrder");
		
		$arrItems = array();
		
		// if no items - check if the table exists. if not - create it. 
		if($response["success"] == false){
			if($response["code"] == Database::CODE_TABLE_NOT_EXISTS){
				$response = createItemsTable();
				if($response == false) clientResponseExit($errorMessageCreateTable);				
			}
			else clientResponseExit($errorMessage);
		}
		else{
			$arrItems = $response["rows"];
			$arrItems = getItemsAdditionalData($arrItems);
		}
		
		//get items
		return(array("success"=>true,"arrItems"=>$arrItems,"categoryID"=>$categoryID));
	}
	
	//--------------------------------------------------------------------------------------------------------------	
	// get all category items (no paging)
	function getCategoryItems($categoryID){		
		$items = getCategoryItems_work($categoryID,false);
		return($items);
	}
	
	//--------------------------------------------------------------------------------------------------------------	
	// get all category items (no paging) - get short version - just name and filename.
	function getCategoryItemsShort($categoryID){
		$response = getCategoryItems_work($categoryID,false);
		if($response["success"] == false) return($response);
		
		//make short items
		$arrItems = $response["arrItems"];
		$arrItemsNew = array();
		foreach($arrItems as $item){
			$itemNew = array();
			$itemNew["id"] = $item["id"];
			$itemNew["filename"] = $item["filename"];
			$itemNew["itemType"] = $item["itemType"];
			$itemNew["name"] = $item["name"];
			$itemNew["itemDesc"] = $item["itemDesc"];
			$arrItemsNew[] = $itemNew;		
		}
		
		$response["arrItems"] = $arrItemsNew;
		return($response);
	}
	
	//--------------------------------------------------------------------------------------------------------------	
	// get all category items (with paging)
	function getCategoryItems_paging($categoryID,$page=1,$inPage=INPAGE_ADMIN){
		return(getCategoryItems_work($categoryID,true,$page,$inPage));
	}
	
	// get category items exceptthose items that in the list
	function getCategoryItems_added($categoryID,$strCurrentItems){
		return(getCategoryItems_work($categoryID,false,0,0,$strCurrentItems,"added"));
	}
	
	// get category items that has been added 
	function getCategoryItems_diff($categoryID,$strCurrentItems){
		return(getCategoryItems_work($categoryID,false,0,0,$strCurrentItems));
	}
	
	//--------------------------------------------------------------------------------------------------------------	
	//get last created items, maximum by top
	function getLastCreatedItems($top=false,$arrCategories=-1){
		global $database;
		
		//if categories list don't given - make one.
		$arrCategories = -1;
		if($arrCategories == -1){
			$response = getCategoriesList();
			if($response["success"] == false) return($response);
			$arrCategories = $response["categories"];
		}
		
		//flip categories list:
		$assocCategoriesList = array();
		foreach($arrCategories as $category){
			$catID = $category["id"];
			$assocCategoriesList[$catID] = $category;
		}
		
		//$query = "select * from images inner join items on images.id=item.itemID";
		$query = "select * from images inner join items on images.id = items.itemid order by images.timestampCreate desc";
		if($top != false) $query .= " limit 1,$top";
		
		$response = $database->fetchSql($query);
		
		//check for table images not exists
		if($response["success"] == false) return(array("success"=>true,"lastCreatedItems"=>array()));
		
		//add items data:
		$rows = $response["rows"];
		$arrItems = array();
		foreach($rows as $row){
			$itemID = $row["items.id"];
			$response = getItemData($itemID);
			if($response["success"] == false) return($response);
			$arrItem = $response["data"];
			
			//add category name to the item
			$categoryID = $arrItem["categoryID"];
			if(isset($assocCategoriesList[$categoryID]) == false) return(errorResponse("No category for item: $itemID"));
			$arrItem["categoryName"] = $assocCategoriesList[$categoryID]["name"];
			$arrItems[] = $arrItem;
		}		
		
		return(array("success"=>true,"lastCreatedItems"=>$arrItems));
	}
	
	//--------------------------------------------------------------------------------------------------------------	
	//get array of items that not in the list.
	function getArrRemovedItemIDs($categoryID,$strCurrentItems){		
		global $database;
		
		$arrCurrentItemIds = explode(",",$strCurrentItems);
		$response = $database->fetch(TABLE_ITEMS,"categoryID='$categoryID'","itemOrder");
		if($response["success"] == false) return(errorResponse($response["message"]));
		
		//set arrItem id's
		$rows = $response["rows"];
		$arrItemIDs = array();
		foreach($rows as $arrItem) $arrItemIDs[] = $arrItem["id"];
		$arrRemovedItems = array_diff($arrCurrentItemIds,$arrItemIDs);
		
		$response = array("success"=>true,"numDeletedItems"=>count($arrRemovedItems),"arrDeletedItems"=>$arrRemovedItems,"categoryID"=>$categoryID);
		return($response);
	}
	
	//--------------------------------------------------------------------------------------------------------------	
	//move item to some category. 
	function moveUploadedItemsToCategory($arrFilenames,$categoryID,$autoDeleteWrongType=true){
		$arrErrors = array();
		$arrSuccess = array();
		
		foreach($arrFilenames as $filename){
			$response = moveUploadedItemToCategory($filename,$categoryID,$autoDeleteWrongType);
			if($response["success"] == false) $arrErrors[] = $response["message"];
			else $arrSuccess[] = "File: $filename has been successfully moved";
		}
				
		$numSuccess = count($arrSuccess);
		$numError = count($arrErrors);
		
		$arrItems = getCategoryItems($categoryID);		
		return(array("success"=>true,"arrSuccess"=>$arrSuccess,"arrErrors"=>$arrErrors,"numSuccess"=>$numSuccess,"numErrors"=>$numError));
	}
	
	//--------------------------------------------------------------------------------------------------------------	
	//move all uploaded items to some category.
	function moveAllUploadedItemsToCategory($categoryID){
		//validation:
		if($categoryID == "") clientResponseExit("No category given!!!");
		
		$response = getUploadedFilesList();
		if($response["success"] == false) clientResponseExit("Can't get uploaded files list.");
		$arrFiles = $response["arrUploadedFiles"];
		$response = moveUploadedItemsToCategory($arrFiles,$categoryID);
		return($response);
	}
	
	//--------------------------------------------------------------------------------------------------------------	
	//validate item, return false and message if error, and true if ok.
	function validateItemForCopyOrMove($itemID,$categoryID,$oper){
		global $database;		
	
		switch(strtolower($oper)){
			case "move":
				$errorPrefix = "Can't move item";
				$strOper = "moved";
			break;
			case "copy":
				$errorPrefix = "Can't copy item";
				$strOper = "copied";
			break;
			case "duplicate":
				$errorPrefix = "Can't duplicate item";
				$strOper = "duplicated";				
			break;
			default:
				clientResponseExit("unknown command: $oper in function 'validateItemForCopyOrMove'");
			break;
		}
		
		$errorMessageGetItem = "$errorPrefix, Can't get current item from database";
		$errorMessageSameCats = "$errorPrefix, the item is in the same category";
		$errorMessageSameCategoryNotExists = "$errorPrefix, target category doesn't exists";
		$errorMessageItemAlreadyExists = "The item is already exists in the target category.";
		$errorMessage = "$errorPrefix - there was some error.";		

		//get current item.
		$response = $database->fetch(TABLE_ITEMS,"id=$itemID");
		if($response["success"] == false) return(errorResponse($errorMessageGetItem));
		$rows = $response["rows"];
		if(count($rows) == 0) return(errorResponse($errorMessageGetItem));
		$arrItem = $rows[0];
		
		if($oper != "duplicate"){
			//validate current category:
			$currentCategoryID = $arrItem["categoryID"];
			if($currentCategoryID == $categoryID) return(errorResponse($errorMessageSameCats));
		}
		
		//validate target category exists
		$response = $database->getNumRows(TABLE_CATEGORIES,"id=$categoryID");
		if($response["success"] == false) return(errorResponse($errorMessage));
		if($response["numRows"] == 0) return(errorResponse($errorMessageSameCategoryNotExists));
		
		if($oper != "duplicate"){
			//vaildate item already exists in the category
			$itemType = $arrItem["itemType"];
			$itemID =  $arrItem["itemID"];
			$response = $database->getNumRows(TABLE_ITEMS,"itemType='$itemType' and itemID=$itemID and categoryID=$categoryID");
			if($response["success"] == false) return(errorResponse($errorMessage));
 			if($response["numRows"] != 0) return(array("success"=>true,"already_exists"=>true,"message"=>$errorMessageItemAlreadyExists));	//tell caller not to proceed
		}
		
		return(array("success"=>true,"already_exists"=>false,"arrItem"=>$arrItem));
	}
	
	//--------------------------------------------------------------------------------------------------------------	
	//change the category id to the item. can't get 2 identical items in one category.
	function moveItemToCategory($itemID,$categoryID){
		global $database;
		$confirmMessage = "The item has successfully moved";
		
		$response = validateItemForCopyOrMove($itemID,$categoryID,"move");
		
		if($response["success"] == false) return($response);	//there was some error in the validation.
		//if($response["confirm"] == true) return($response);		//the item is already in the category.
		
		//update the item to new category.
		$arrUpdate = array();
		$arrUpdate["categoryID"] = $categoryID;
		$response = $database->update(TABLE_ITEMS,$arrUpdate,"id=$itemID");
		if($response["success"] == false) return(errorResponse($errorMessage));
		return(confirmResponse($confirmMessage));
	}
	
	//--------------------------------------------------------------------------------------------------------------	
	// duplicate new item
	function copyItemToCategory($itemID,$categoryID,$oper="copy"){
		global $database;
		$response = validateItemForCopyOrMove($itemID,$categoryID,$oper);
		
		if($response["success"] == false) return($response);	//there was some error in the validation.
		if($response["already_exists"] == true) return($response);		//the item is already in the category.
		
		//duplicate item with new category.
		$arrItem = $response["arrItem"];
		unset($arrItem["id"]);
		unset($arrItem["timestampCreate"]);
		unset($arrItem["timestampUpdate"]);
		unset($arrItem["itemOrder"]);
		$arrItem["categoryID"] = $categoryID;
		
		$response = addItemToDatabase($arrItem);
		if($response["success"] == true){
			if($oper == "copy") $response["message"] = "The item has successfully copied to target category";
			else $response["message"] = "The item has successfully duplicated";	
		}
		return($response);
	}
		
	//--------------------------------------------------------------------------------------------------------------	
	// delete item from database. if there is not copy of this item, delete the real item too.
	function deleteItem($itemID){
		global $database;
		$errorMessageDatabase = "Can't get the item from database";
		$errorMessage = "Can't delete item";
		$errorMessageUnknownType = "Can't delete item - unknown item type";
		$confirmMessage = "The item has been successfully deleted";
		
		$response = $database->fetch(TABLE_ITEMS,"id=$itemID");		
		if($response["success"] == false) return(errorResponse($errorMessageDatabase));
		$rows = $response["rows"];
		
		if(count($rows) == 0) return(errorResponse($errorMessageDatabase));
		
		$arrItem = $rows[0];
				
		//delete the item from database.
		
		$response = $database->delete(TABLE_ITEMS,"id=$itemID");
		if($response["success"] == false) return(errorResponse($errorMessage));
		
		$innerItemID = $arrItem["itemID"];
		$itemType = $arrItem["itemType"];
		
		//search if the current item exists elsewere.
		$response = $database->getNumRows(TABLE_ITEMS,"itemID=$innerItemID and itemType='$itemType'");
		if($response["success"] == false) return(errorResponse($errorMessage));
		
		if($response["numRows"] >0) return(confirmResponse($confirmMessage));	//if exists another item pointing to same real item, just exit.
		
		switch($itemType){
			case FILETYPE_IMAGE:
				$response = deleteImage($innerItemID);
				if($response["success"] == false) return($response["message"]);
			break;
			default:
				return(errorResponse($errorMessageUnknownType));
			break;
		}
		
		return(confirmResponse($confirmMessage));	//the item has been deleted from the database, and from filesystem.
	}
	
	//--------------------------------------------------------------------------------------------------------------	
	// delete multiple items.
	function deleteItems($arrItemIDs){
		$arrErrors = array();
		$arrConfirms = array();
		$arrResponses = array();
		$arrDeletedItemIds = array();
		$arrNotDeletedItemIds = array();
		
		foreach($arrItemIDs as $itemID){
			$response = deleteItem($itemID);
			
			$arrResponses[] = array("itemID"=>$itemID,"success"=>$response["success"],"message"=>$response["message"]);
			
			if($response["success"] == true){
				$arrConfirms[] = array("itemID"=>$itemID,"message"=>$response["message"]);
				$arrDeletedItemIds[] = $itemID;
			}
			else{
				$arrErrors[] = array("itemID"=>$itemID,"message"=>$response["message"]);
				$arrNotDeletedItemIds[] = $itemID;
			}
		}
		
		return(array("success"=>true,"numDeletedItems"=>count($arrDeletedItemIds),"numNotDeletedItems"=>count($arrNotDeletedItemIds),"arrDeletedItems"=>$arrDeletedItemIds,"arrNotDeletedItems"=>$arrNotDeletedItemIds));
		
		//return(array("success"=>true,"arrResponses"=>$arrResponses,"arrConfirms"=>$arrConfirms,"arrErrors"=>$arrErrors,"numConfirms"=>count($arrConfirms),"numErrors"=>count($arrErrors)));	
	}
	
	//--------------------------------------------------------------------------------------------------------------	
	//get category all item id's , and call delete items.
	function deleteAllCategoryItems($categoryID){
		global $database;
		$response = $database->fetch(TABLE_ITEMS,"categoryID=$categoryID");
		$rows = $response["rows"];
		$arrItemIDs = array();		
		foreach($rows as $row) $arrItemIDs[] = $row["id"];
		$response = deleteItems($arrItemIDs);
		return($response);
	}
	
	//--------------------------------------------------------------------------------------------------------------	
	// move several items to some category.
	function moveItemsToCategory($arrItemIDs,$categoryID){
		$arrErrors = array();
		$arrConfirms = array();
		$arrResponses = array();
		foreach($arrItemIDs as $itemID){
			$response = moveItemToCategory($itemID,$categoryID);
			if($response["success"] == false) $arrErrors[] = array("itemID"=>$itemID,"message"=>$response["message"]);
			else $arrConfirms[] = array("itemID"=>$itemID,"message"=>$response["message"]);
			$arrResponses[] = array("itemID"=>$itemID,"success"=>$response["success"],"message"=>$response["message"]);
		}
		return(array("success"=>true,"arrResponses"=>$arrResponses,"arrConfirms"=>$arrConfirms,"arrErrors"=>$arrErrors,"numConfirms"=>count($arrConfirms),"numErrors"=>count($arrErrors)));
	}
	
	//--------------------------------------------------------------------------------------------------------------	
	//copy multiple items to some category.
	function copyItemsToCategory($arrItemIDs,$categoryID){
		$arrErrors = array();
		$arrConfirms = array();
		$arrResponses = array();
		foreach($arrItemIDs as $itemID){
			$response = copyItemToCategory($itemID,$categoryID);
			if($response["success"] == false) $arrErrors[] = array("itemID"=>$itemID,"message"=>$response["message"]);
			else $arrConfirms[] = array("itemID"=>$itemID,"message"=>$response["message"]);
			$arrResponses[] = array("itemID"=>$itemID,"success"=>$response["success"],"message"=>$response["message"]);
		}
		return(array("success"=>true,"arrResponses"=>$arrResponses,"arrConfirms"=>$arrConfirms,"arrErrors"=>$arrErrors,"numConfirms"=>count($arrConfirms),"numErrors"=>count($arrErrors)));		
	}
	
	//--------------------------------------------------------------------------------------------------------------	
	// update item name and description.
	function updateItem($itemID,$name,$desc,$link){
		global $database;
		$errorMessageDatabase = "Can't get the item from database.";
		$errorMessage = "Can't update item";
		
		$response = $database->getNumRows(TABLE_ITEMS,"id=$itemID");
		if($response["success"] == false) return(errorResponse($errorMessageDatabase));
		if($response["numRows"] == 0) return(errorResponse($errorMessageDatabase));
		
		$arrUpdate = array();
		$arrUpdate["name"] = $name;
		$arrUpdate["itemDesc"] = $desc;
		$arrUpdate["link"] = $link;
		$arrUpdate["timestampUpdate"] = mktime();
		
		$response = $database->update(TABLE_ITEMS,$arrUpdate,"id=$itemID");
		
		if($response["success"] == false) return(errorResponse($errorMessage));
		return(confirmResponse("The item successfully updated"));
	}
	
	//--------------------------------------------------------------------------------------------------------------	
	//set items new order
	function setItemsOrder($arrItemsWithOrder){
		global $database;
		$errorMessage = "Can't set items order.";
		foreach($arrItemsWithOrder as $item){
			$itemID = toString($item->itemID);
			$itemOrder = toString($item->itemOrder);
			
			$arrUpdate = array();
			$arrUpdate["itemOrder"] = $itemOrder;
			$response = $database->update(TABLE_ITEMS,$arrUpdate,"id=$itemID");
			if($response["success"] == false) return(errorResponse($errorMessage));
		}
		return(confirmResponse());
	}
	
	//--------------------------------------------------------------------------------------------------------------	
	//download item file.
	function downloadItem($itemID){
		$errorMessage = "Wrong item id to downlaod";
		$errorMessageType = "Wrong item type to download";
		
		$response = getItemData($itemID);
		if($response["success"] == false) exitWithMessage($errorMessage);
		$arrItem = $response["data"];
		
		switch($arrItem["itemType"]){
			case FILETYPE_IMAGE:
				$ext = "jpg";				
				$mime = "";
				if($arrItem["imageType"]){
					$mimeType = image_type_to_mime_type($arrItem["imageType"]);
					$ext = image_type_to_extension($arrItem["imageType"]);
				}
				if($ext == ".jpeg") $ext = ".jpg";
				
				$filename = $arrItem["name"].$ext;				
				$filepath = DIR_IMAGES."/".$arrItem["filename"];
				outputImageForDownload($filepath,$filename,$mimeType);
			break;
			default:
				exitWithMessage($errorMessageType);
			break;
		}
		
	}
	
	//--------------------------------------------------------------------------------------------------------------	
	//sync all items in the database to the one that in the real files.
	function syncItems(){
		$response = syncImages();
		if($response["success"] == false) return($response);
		updateCategoriesNumItems();
		return(confirmResponse());
	}
		
?>