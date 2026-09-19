<?php
	
	//---------------------------------------------------------------------------------------------------
	// create category table. return true if created successfully or whether the table already exists.
	function createCategoryTable(){
		global $database;
		$arrCreate = array();
		$arrCreate["id"] = Database::TYPE_KEY;
		$arrCreate["name"] = Database::TYPE_STRING;
		$arrCreate["type"] = Database::TYPE_STRING;
		$arrCreate["catDesc"] = Database::TYPE_TEXT;
		$arrCreate["longDesc"] = Database::TYPE_TEXT;
		$arrCreate["numItems"] = Database::TYPE_NUMBER;
		$arrCreate["catOrder"] = Database::TYPE_NUMBER;
		$arrCreate["timestampCreate"] = Database::TYPE_NUMBER;
		$arrCreate["timestampUpdate"] = Database::TYPE_NUMBER;
		$arrCreate["parentID"] = Database::TYPE_NUMBER;
		
		//permissions:
		$arrCreate["permission_nodelete"] = Database::TYPE_BOOLEAN;
		$arrCreate["permission_noupdate"] = Database::TYPE_BOOLEAN;
		$arrCreate["permission_noadditems"] = Database::TYPE_BOOLEAN;
		//attribute:
		$arrCreate["hidden"] = Database::TYPE_BOOLEAN;
		$response = $database->createTable(TABLE_CATEGORIES,$arrCreate);
		return($response);
	}
	
	//---------------------------------------------------------------------------------------------------
	// create category. can be types - normal, default, upload. can be unser other category, and have permissions string
	function addCategory($catName,$parentID = 0,$type=TYPE_CATEGORY_NORMAL,$arrPermissions=array(),$arrAttributes=array()){
		global $database;
		// create table if the table not exists:
		$errorMessage = "Can't add category.";
		$existsMessage = "The category \"$catName\" already exists";
		
		$response = createCategoryTable();
		
		if($response["success"] == false) clientResponseExit($errorMessage);
		
		$response = getMaxCategoryOrder();
		
		if($response["success"] == false) clientResponseExit($errorMessage);
		$maxOrder = $response["maxOrder"];
		$categoryOrder = $maxOrder+1;
		
		//validate category with such name doesn't exists.
		$catNameEscaped = $database->escape($catName);
		$response = $database->isRowExists(TABLE_CATEGORIES,"name='$catNameEscaped'");		
		if($response["success"] == false) clientResponseExit($errorMessage);		
		if($response["exists"] == true) clientResponseExit($existsMessage);
		
		// insert fields to database
		$arrInsert = array();
		$arrInsert["name"] = $catName;
		$arrInsert["catDesc"] = "";
		$arrInsert["longDesc"] = "";
		$arrInsert["numItems"] = 0;
		$arrInsert["catOrder"] = $categoryOrder;
		$arrInsert["parentID"] = 0;
		$arrInsert["type"] = $type;
		$arrInsert["permission_nodelete"] = false;
		$arrInsert["permission_noupdate"] = false;
		$arrInsert["permission_noadditems"] = false;
		$arrInsert["hidden"] = false;
		
		//set permissions:
		foreach($arrPermissions as $permission){
			switch($permission){
				case PERMISSION_CATEGORY_READONLY:
					$arrInsert["permission_nodelete"] = true;
					$arrInsert["permission_noupdate"] = true;
					$arrInsert["permission_noadditems"] = true;
				break;
				case PERMISSION_CATEGORY_NODETE:
					$arrInsert["permission_nodelete"] = true;					
				break;
				case PERMISSION_CATEGORY_NOUPDATE:
					$arrInsert["permission_noupdate"] = true;					
				break;
				case PERMISSION_CATEGORY_NOADDITEMS:
					$arrInsert["permission_noadditems"] = true;
				break;
				default:
					clientResponseExit($errorMessage);
				break;
			}
		}

		//set attributes:
		foreach($arrAttributes as $attribute=>$value) $arrInsert[$attribute] = $value;
		
		// make timestamp:
		$stamp = mktime();
		$arrInsert["timestampCreate"] = $stamp;
		$arrInsert["timestampUpdate"] = $stamp;
		
		$response = $database->insert(TABLE_CATEGORIES,$arrInsert);
		
		if($response["success"] == false) clientResponseExit($errorMessage);
		
		$arrInsert["id"] = $response["lastID"];
		
		$arrCategory = processCategoryRow($arrInsert);
		
		//output:
		return(array("success"=>true,"category"=>$arrCategory));
	}
	
	//---------------------------------------------------------------------------------------------------
	// create category with empty name. if this name is taken, make a new name in sequence.
	function addEmptyCategory(){
		global $database;
		
		//set initial category name:
		$emptyCategoryName = CATEGORY_EMPTY_NAME;
		
		//find next free name:
		if($database->isTableExists(TABLE_CATEGORIES)){
			$counter = 1;
			do{
				if($counter>1) $emptyCategoryName = CATEGORY_EMPTY_NAME . $counter;
				$response = $database->isRowExists(TABLE_CATEGORIES,"name='$emptyCategoryName'");
				if($response["success"] == true && $response["exists"] == true) $foundFlag = true;
				else $foundFlag = false;
				$counter++;
			}while($foundFlag == true);			
		}
		
		//create the category
		$response = addCategory($emptyCategoryName);
		return($response);
	}
	
	//---------------------------------------------------------------------------------------------------
	// create default categories (upload and defaule)
	function addDefaultCategories(){
		$arrPermissions = array();
		$arrPermissions[] = PERMISSION_CATEGORY_READONLY;
		$arrPermissions[] = PERMISSION_CATEGORY_NOADDITEMS;
		
		addCategory(CATEGORY_UPLOADED_NAME,0,TYPE_CATEGORY_UPLOADED,$arrPermissions);
		return(array("success"=>true));
	}
	
	//---------------------------------------------------------------------------------------------------
	//remove uplaoded category from rows
	function removeUploadedFromRows($rows){
		$newRows = array();
		foreach($rows as $row){
			if($row["type"] != TYPE_CATEGORY_UPLOADED) $newRows[] = $row;
		}
		return($newRows);
	}
	
	//---------------------------------------------------------------------------------------------------
	//get list of all categories.
	function getCategoriesList($parentID=0,$showUploaded=false,$ids="",$exceptIDs=""){
		global $database;
		$errorMessage = "Can't get categories list";
		$response = getCatRows($parentID,$ids,$exceptIDs);
		
		//get categories rows:
		if($response["success"] == false) clientResponseExit($errorMessage);
		
		$rows = $response["rows"];
		$rows = processCategoriesRows($rows);
		
		if($showUploaded == true) $rows = updateUploadedRow($rows);
		else $rows = removeUploadedFromRows($rows);
		
		return(array("success"=>true,"categories"=>$rows));
	}
	
	//---------------------------------------------------------------------------------------------------
	// get full categories list - includign info about items - last updated date, first category item, category image, 4 category items
	function getCategoriesListFull($parentID=0,$showUploaded=true){
		$responseCats = getCategoriesList($parentID,$showUploaded);
		if($responseCats["success"] == false) return($responseCats);
		
		$arrCategories = $responseCats["categories"];
		
		foreach($arrCategories as $key=>$category){
			$catID = $category["id"];
			// get category items:
			$response = getCategoryItems($catID);
			if($response["success"] == false) return($response);
			$arrItems = $response["arrItems"];
			$numItems = count($arrItems);
			
			//get first item, last item, and first four items:
			$firstItem = $lastItem = $first4Items = array();
			
			if($numItems>0){
				$firstItem = $arrItems[0];
				$lastItem = $arrItems[$numItems-1];
				for($i=0;$i<4;$i++){
					if($i < $numItems-1) $first4Items[] = $arrItems[$i];
				}
			}
			
			//get last create date and last update date
			$maxStampCreate = 0;
			$maxStampUpdate = 0;
			$maxDateCreate = "";
			$maxDateUpdate = "";
			foreach($arrItems as $item){
				if($item["timestampCreate"] > $maxStampCreate){
					$maxStampCreate = $item["timestampCreate"];
					$maxDateCreate = $item["dateItemCreate"];					
				}
				if($item["timestampCreate"] > $maxStampUpdate){
					$maxStampUpdate = $item["timestampUpdate"];
					$maxDateUpdate = $item["dateItemUpdate"];					
				}
			}
			
			$category["categoryItem"] = $firstItem;
			$category["firstItem"] = $firstItem;
			$category["lastItem"] = $lastItem;
			
			$category["lastItemStampCreate"] = $maxStampCreate;
			$category["lastItemStampUpdate"] = $maxStampUpdate;
			$category["lastItemDateCreate"] = $maxDateCreate;
			$category["lastItemDateUpdate"] = $maxDateUpdate;
			
			$arrCategories[$key] = $category;
		}
		
		//replace the original response
		$responseCats["categories"] = $arrCategories;
		return($responseCats);
	}
	
	//---------------------------------------------------------------------------------------------------
	// get short list of categories.
	function getCategoriesShort($parentID=0,$showUploaded=true){
		$response = getCategoriesList($parentID,$showUploaded);
		if($response["success"] == false) return($response);
		
		//make categories items
		$arrCategories = $response["categories"];
		$arrCategoriesNew = array();
		foreach($arrCategories as $category){
			$newCategory = array();
			$newCategory["id"] = $category["id"];
			$newCategory["name"] = $category["name"];
			$newCategory["numItems"] = $category["numItems"];
			$arrCategoriesNew[] = $newCategory;
		}
		
		$response["categories"] = $arrCategoriesNew;
		return($response);
	}
	
	//---------------------------------------------------------------------------------------------------
	// get list of all categories, but only id, name, numItems field.
	function getCategoriesListSmall($parentID=0,$ids=""){
		global $database;
		$errorMessage = "Can't get categories list";
		$response = getCatRows($parentID,$ids);
		
		//get categories rows:
		if($response["success"] == false) clientResponseExit($errorMessage);
		$rows = $response["rows"];
		
		$orderCounter = 0;
		foreach($rows as $key=>$row){
			$rows[$key] = processCategorySmall($rows[$key]);
			$orderCounter++;
			$rows["numOrder"] = $orderCounter;
		}
		
		//output:
		return(array("success"=>true,"categories"=>$rows));
	}
	
	//---------------------------------------------------------------------------------------------------
	// get category rows
	function getCatRows($parentID=0,$ids="",$exceptIDs=""){
		global $database;
		
		if($ids != "" && $exceptIDs != "") return(errorResponse("get categories error - ids and except ids can't work together.")); 
		
		$where = "parentID='$parentID'";
		if($ids != "") $where .= " and id in($ids)";
		else if($exceptIDs != "") $where .= " and id not in($exceptIDs)";
				
		$response = $database->fetch(TABLE_CATEGORIES,$where,"catOrder");
		if($response["success"] == false && $response["code"] == Database::CODE_TABLE_NOT_EXISTS){	//if the table has not craeted yet, create table.
			createCategoryTable();
			addDefaultCategories();
			$response = $database->fetch(TABLE_CATEGORIES,"parentID='$parentID'","catOrder");						
		}				
		return($response);
	}
	
	//---------------------------------------------------------------------------------------------------
	// get processed category by id
	function getCategory($categoryID){
		global $database;
		$response = $database->fetch(TABLE_CATEGORIES,"id='$categoryID'");
		if($response["success"] == false) return($response);
		$rows = $response["rows"];
		if(empty($rows)) return(errorResponse("The category with id: $categoryID doesn't exists"));
				
		$row = $rows[0];
		$row = processCategoryRow($row);
		return(array("success"=>true,"data"=>$row));
	}
	
	//---------------------------------------------------------------------------------------------------
	//get small array from category row
	function processCategorySmall($row){
		$arrFields = array("id","name","catOrder","numItems","permission_nodelete","permission_noupdate","permission_noadditems","hidden");
		
		$arrSmall = array();
		foreach($arrFields as $field){
			if(isset($row[$field])) $arrSmall[$field] = $row[$field];
		}
		return($arrSmall);
	}
	
	//---------------------------------------------------------------------------------------------------
	// process category row. add additional fields.
	function processCategoryRow($row){
		$row["dateCreate"] = timestamp2Date($row["timestampCreate"]);
		$row["dateUpdate"] = timestamp2Date($row["timestampUpdate"]);
		return($row);
	}
	
	//---------------------------------------------------------------------------------------------------
	// order categories rows and add some fields like date and time.
	function processCategoriesRows($arrRows){
		for($i=0;$i<count($arrRows);$i++){
			$arrRows[$i] = processCategoryRow($arrRows[$i]);
			$arrRows[$i]["catOrder"] = $i+1;
		}
		return($arrRows);
	}
	
	//---------------------------------------------------------------------------------------------------			
	// deletes category.
	function deleteCategory($categoryID){		
		global $database;
		$errorNotExists = "Can't delete the category, the category is not exists";
		$errorMessage = "Can't delete category.";
		
		//valdiate category exists
		$response = $database->isRowExists(TABLE_CATEGORIES,"id='$categoryID'");		
		if($response["success"] == false) clientResponseExit($errorMessage);
		if($response["exists"] == false) clientResponseExit($errorNotExists);
		
		$response = $database->delete(TABLE_CATEGORIES,"id='$categoryID'");
		if($response["success"] == false) clientResponseExit($errorMessage);
		
		return(array("success"=>true,"categoryID"=>$categoryID));
	}
		
	//---------------------------------------------------------------------------------------------------			
	// update category	
	function updateCategory($catID,$catName,$catDesc = "",$catLongDesc = ""){
		global $database;
		$errorMessage = "Can't update category";
		
		// validate sql illigal characters
		$arrUpdate = array();
		
		$arrUpdate["name"] = $catName;
		$arrUpdate["catDesc"] = $catDesc;
		$arrUpdate["longDesc"] = $catLongDesc;
		$arrUpdate["timestampUpdate"] = mktime();
		
		$response = $database->update(TABLE_CATEGORIES,$arrUpdate,"id=$catID");
		if($response["success"] == false) clientResponseExit($errorMessage);
		
		$response = getCategory($catID);
		if($response["success"] == false) clientResponseExit($errorMessage);
		
		$category = $response["data"];
		
		return(array("success"=>true,"category"=>$category));
	}
	
	//---------------------------------------------------------------------------------------------------			
	// get max order from categories list
	function getMaxCategoryOrder(){
		global $database;
		$query = "select MAX(catOrder) as maxOrder from ".TABLE_CATEGORIES;
		$response = $database->fetchSql($query);
		if($response["success"] == false) return($response);
		$maxOrder = 0;
		$rows = $response["rows"];
		if(count($rows)>0) $maxOrder = $rows[0]["maxOrder"];
		return(array("success"=>true,"maxOrder"=>$maxOrder));
	}
	
	//---------------------------------------------------------------------------------------------------			
	// sets category order instead of target 
	function setCategoryOrder($catID,$targetID){
		global $database;
		
		$errorMessage = "Can't set order. unknowed error accured";
		
		$response = getCategory($catID);
		if($response["success"] == false) clientResponseExit($errorMessage);
		
		$catOrder = $response["data"]["catOrder"];
		
		$response = getCategory($targetID);
		if($response["success"] == false) clientResponseExit($errorMessage);
		
		$targetCatOrder = $response["data"]["catOrder"];
		
		//change order down - move every item up
		if($targetCatOrder>$catOrder){
			$response = $database->fetch(TABLE_CATEGORIES,"catOrder>$catOrder and catOrder<=$targetCatOrder");
			if($response["success"] == false) clientResponseExit($errorMessage);
			$rows = $response["rows"];
			foreach($rows as $row){
				$id = $row["id"];
				$newCatOrder = $row["catOrder"]-1;
				$arrUpdate = array();
				$arrUpdate["catOrder"] = $newCatOrder;
				$response = $database->update(TABLE_CATEGORIES,$arrUpdate,"id=$id");
				if($response["success"] == false) clientResponseExit($errorMessage);
			}
		}
		else{	//change order up. move every items down
			$response = $database->fetch(TABLE_CATEGORIES,"catOrder>=$targetCatOrder and catOrder<$catOrder");
			if($response["success"] == false) clientResponseExit($errorMessage);
			$rows = $response["rows"];
			foreach($rows as $row){
				$id = $row["id"];
				$newCatOrder = $row["catOrder"]+1;
				$arrUpdate = array();
				$arrUpdate["catOrder"] = $newCatOrder;
				$response = $database->update(TABLE_CATEGORIES,$arrUpdate,"id=$id");
				if($response["success"] == false) clientResponseExit($errorMessage);
			}			
		}
		
		//set new category order
		$arrUpdate = array();
		$arrUpdate["catOrder"] = $targetCatOrder;
		$response = $database->update(TABLE_CATEGORIES,$arrUpdate,"id=$catID");
		if($response["success"] == false) clientResponseExit($errorMessage);
		
		return(array("success"=>true));
	}
	
	//---------------------------------------------------------------------------------------------------
	// simply set category order from array of object(id,order)
	function setCategoryOrders_array($arrCategoryOrders){
		global $database;
		foreach($arrCategoryOrders as $objOrder){
			$id = $objOrder->id;
			$order = $objOrder->order;
			$arrUpdate = array();
			$arrUpdate["catOrder"] = $order;
			$response = $database->update(TABLE_CATEGORIES,$arrUpdate,"id=$id");
			if($response["success"] == false) clientResponseExit($errorMessage);
		}
		return(array("success"=>true));
	}
	
	//---------------------------------------------------------------------------------------------------
	// update numItems in the uploaded row.
	function updateUploadedRow($rows){
		for($i=0;$i<count($rows);$i++){
			$row = $rows[$i];
			if($row["type"] == TYPE_CATEGORY_UPLOADED){				
				$row["numItems"] = getUploadedNumItems();
				$rows[$i] = $row;
			}
		}		
		return($rows);
	}
	
	//---------------------------------------------------------------------------------------------------
	// update category num items.
	function updateCategoryNumItems($categoryID){
		global $database;
		$errorMessage = "Can't update number of category items.";
		
		$response = $database->getNumRows(TABLE_ITEMS,"categoryID=$categoryID");
		if($response["success"] == false) return(errorResponse($errorMessage));
		$numItems = $response["numRows"];
		$arrUpdate = array();
		$arrUpdate["numItems"] = $numItems;
		$response = $database->update(TABLE_CATEGORIES,$arrUpdate,"id=$categoryID");
		if($response["success"] == false) return(errorResponse($errorMessage));
		
		return(confirmResponse());
	}
	
	//---------------------------------------------------------------------------------------------------
	// update all categories num items
	function updateCategoriesNumItems(){
		global $database;
		$errorMessage = "Can't update all categories numbers";
		$response = $database->fetch(TABLE_CATEGORIES);
		if($response["success"] == false) return(errorResponse($errorMessage));
		$arrCategories = $response["rows"];
		foreach($arrCategories as $category) updateCategoryNumItems($category["id"]);
		
		return(confirmResponse());
	}
	
?>