<?php

	//--------------------------------------------------------------------------------------------------------------	
	//create table of images.
	function createImagesTable(){
		global $database;
		$arrCreate = array();
		$arrCreate["id"] = Database::TYPE_KEY;
		$arrCreate["filename"] = Database::TYPE_STRING;
		$arrCreate["name"] = Database::TYPE_STRING;
		$arrCreate["imageType"] = Database::TYPE_STRING;
		$arrCreate["width"] = Database::TYPE_NUMBER;
		$arrCreate["height"] = Database::TYPE_NUMBER;
		$arrCreate["orientation"] = Database::TYPE_NUMBER;
		$arrCreate["camera"] = Database::TYPE_STRING;
		$arrCreate["filesize"] = Database::TYPE_STRING;
		$arrCreate["timestampFileCreate"] = Database::TYPE_STRING;
		$arrCreate["timestampCreate"] = Database::TYPE_NUMBER;
		$arrCreate["timestampUpdate"] = Database::TYPE_NUMBER;
		$response = $database->createTable(TABLE_IMAGES,$arrCreate);
		return($response);
	}
	
	//--------------------------------------------------------------------------------------------------------------	
	//add image to database:
	function addImageToDatabase($arrImage){
		global $database;
		$errorMessage = "Can't add image";
		
		$filename = getArrValue($arrImage,"filename");
		$name = getArrValue($arrImage,"name");
		$imageType = getArrValue($arrImage,"imageType");
		
		$info = Functions::getPathInfo($filename);
		if($name == "") $name = $info["filename"];
		if($imageType == "") $name = $info["extension"];
		
		$response = createImagesTable();
		if($response["success"] == false) clientResponseExit($errorMessage);
		
		//insert the data to the table
		$arrInsert = array();
		$arrInsert["filename"] = $filename;
		$arrInsert["name"] = $name;
		$arrInsert["imageType"] = $imageType;
		$arrInsert["width"] = getArrValue($arrImage,"width","");
		$arrInsert["height"] = getArrValue($arrImage,"height");
		$arrInsert["orientation"] = getArrValue($arrImage,"orientation");
		$arrInsert["camera"] = getArrValue($arrImage,"camera");
		$stamp = mktime();
		$arrInsert["timestampCreate"] = $stamp;
		$arrInsert["timestampUpdate"] = $stamp;
				
		$response = $database->insert(TABLE_IMAGES,$arrInsert);
		
		if($response["success"] == false) clientResponseExit($errorMessage);
		
		$id = $response["lastID"];
		
		return(array("success"=>true,"id"=>$id));
	}
	
	//--------------------------------------------------------------------------------------------------------------	
	// process item row. set all additional fields like urls.
	function processImageRow($row){		
		$row["dateImageCreate"] = timestamp2Date($row["timestampCreate"]);
		$row["dateImageUpdate"] = timestamp2Date($row["timestampUpdate"]);
		
		$arrFields = array("url_images","thumb_width","thumb_height","image_width","image_height","admin_thumb_width"
							   ,"admin_thumb_height","admin_image_width","admin_image_height");
		return($row);
	}

	//--------------------------------------------------------------------------------------------------------------	
	// get image row by id
	function getImageData($imageID){
		global $database;
		$errorMessage = "image with id:$imageID no found";
		$response = $database->fetch(TABLE_IMAGES,"id=$imageID");				
		if($response["success"] == false) return(errorResponse($errorMessage));
		if(count($response["rows"]) == 0) return(errorResponse($errorMessage));
		$arrImage = $response["rows"][0];
		$arrImage = processImageRow($arrImage);
		return(array("success"=>true,"arrImage"=>$arrImage));
	}
	
	//--------------------------------------------------------------------------------------------------------------	
	// remain in the database just the files that on the disk.
	function syncImages(){
		global $database;
		
		$errorMessage = "error sync images";
		
		$arrRealFilenames = getFileList(PATH_IMAGES);
		
		$response = $database->fetch(TABLE_IMAGES);
		if($response["success"] == false) clientResponseExit($errorMessage);
		$rows = $response["rows"];
		
		$arrIdsToDelete = array();
		
		//get array of remain rows, and prepare id's array.
		$arrRowsToRemain = array();		
		$strIDs = "";		
		foreach($rows as $row){
			$filename = $row["filename"];
			$pos = array_search($filename,$arrRealFilenames);
			if($pos === FALSE) continue;
			if(!isset($arrRowsToRemain[$filename])){
				if($strIDs != "") $strIDs .= ",";
				$strIDs .= $row["id"];
				$arrRowsToRemain[$filename] = $row;
			}
		}
				
		// delete from table images:
		$query = "delete from ". TABLE_IMAGES . " where id not in($strIDs)";		
		$response = $database->runSql($query);
		if($response["success"] == false) return($response);
		
		// delete from table items:
		$query = "delete from ".TABLE_ITEMS." where itemType='".FILETYPE_IMAGE."' and itemID not in(select id from ".TABLE_IMAGES.")";
		$response = $database->runSql($query);
		if($response["success"] == false) return($response);
		
		return(confirmResponse());
	}
	
	//--------------------------------------------------------------------------------------------------------------	
	// return array of all resized images of current image.
	function getAllResizedImages($filename){
		$info = Functions::getPathInfo($filename);
		$name = $info["filename"];
		$ext = $info["extension"];		
		
		$pattern = PATH_THUMBS."/".$name."_*.".$ext;
		$files = glob($pattern);
		return($files);
	}
	
	//--------------------------------------------------------------------------------------------------------------	
	// delete image from the database, and filesystem
	function deleteImage($imageID){
		global $database;
		$errorMessageDatabase = "Can't get the image from the database.";
		$errorMessage = "Can't delete the image ";
		$errorMessageRealDelete = "Can't delete the real image from filesystem";		
		$errorMessageRealDeleteResize = "Can't delete resized image: ";
		
		$response = $database->fetch(TABLE_IMAGES,"id=$imageID");
		if($response["success"] == false) return(errorResponse($errorMessageDatabase));
		$rows = $response["rows"];
		if(count($rows) == 0) return(errorResponse($errorMessageDatabase));
		
		$arrImage = $rows[0];
		$filename = $arrImage["filename"];
		$imagePath = PATH_IMAGES."/".$filename;
				
		$response = $database->delete(TABLE_IMAGES,"id=$imageID");
		if($response["success"] == false) return(errorResponse($errorMessage));
		
		//delete image from database
		$database->delete(TABLE_ITEMS,"itemType='".FILETYPE_IMAGE."' and itemID=$imageID");
		if($response["success"] == false) return(errorResponse($errorMessage));
		
		//delete image from filesystem
		$success = unlink($imagePath);		
		if($success == false) return(errorResponse($errorMessageRealDelete));
		
		//delete all resized images of that image:		
		$arrResizedFilePaths = getAllResizedImages($filename);
		foreach($arrResizedFilePaths as $filepath){
			$success = unlink($filepath);
			if($success == false) return(errorResponse($errorMessageRealDeleteResize.$filepath));
		}
		
		return(confirmResponse());
	}
	
	//--------------------------------------------------------------------------------------------------------------	
	// get image type by extention
	function getImagetypeByExt($ext){
		$ext = strtolower($ext);
		$type = "";
		switch($ext){
			case "jpeg":
			case "jpg":
				$type = IMAGETYPE_JPEG;
			break;
			case "png":
				$type = IMAGETYPE_PNG;
			break;
			case "gif":
				$type = IMAGETYPE_GIF;
			break;
			case "bmp":
				$type = IMAGETYPE_BMP;
			break;			
		}
		return($type);
	}
	
?>