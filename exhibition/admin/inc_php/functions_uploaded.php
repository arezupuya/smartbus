<?php
		
	//---------------------------------------------------------------------------------------------------
	// get array of all files in "uploaded" directory
	function getUploadedFilesList(){	
		//if uploads directory don't exists - try to craete it.
		if(is_dir(PATH_UPLOAD) == false){
			$success = mkdir(PATH_UPLOAD);
			if($success == false) return(array("success"=>true,"arrUploadedFiles"=>array()));			
		}
		
		$fileList = getFileList(PATH_UPLOAD);
		return(array("success"=>true,"arrUploadedFiles"=>$fileList));
	}
	
	//---------------------------------------------------------------------------------------------------
	// get uploaded category items number.
	function getUploadedNumItems(){
		if(is_dir(PATH_UPLOAD) == false){
			$success = mkdir(PATH_UPLOAD);
			if($success == false) return(0);
		}
		
		$dir = scandir(PATH_UPLOAD);
		$counter = 0;
		foreach($dir as $file){
			if($file == "." || $file == "..") continue;
			$filepath = PATH_UPLOAD . "/" . $file;
			if(is_file($filepath)) $counter++;
		}
		return($counter);
	}
	
	//---------------------------------------------------------------------------------------------------
	// delete selected uploaded filenames
	function deleteUploadedSelectedFilenames($arrFilesnames){
		foreach($arrFilesnames as $filaname){
			$filepath = PATH_UPLOAD . "/" . $filaname;
			$success = @unlink($filepath);
			if($success == false) clientResponseExit("Can't delete file: $filaname");			
		}
		
		$response = getUploadedFilesList();
		if($response["success"] == false) clientResponseExit("Can't get fileslist");
		
		return($response);
	}
	
	//---------------------------------------------------------------------------------------------------
	// delete all uploaded files.
	function deleteAllUploadedFiles(){
		$response = getUploadedFilesList();
		if($response["success"] == false) clientResponseExit("Can't get fileslist");
		
		$arrUploadedFiles = $response["arrUploadedFiles"];
		foreach($arrUploadedFiles as $filename){
			$filepath = PATH_UPLOAD . "/" . $filename;
			$success = @unlink($filepath);
			if($success == false) clientResponseExit("Can't delete file: $filaname");			
		}
		
		$response = getUploadedFilesList();
		if($response["success"] == false) clientResponseExit("Can't get fileslist");
		return($response);
	}
	
	//---------------------------------------------------------------------------------------------------------------
	// move uploaded file to upload directory, and after that to some category
	function treatUploadedFile(){
		$categoryId = getPostVariable("uploadCategoryId");		
		
		foreach($_FILES as $file){
			$filename = $file["name"];
			
			$info = Functions::getPathInfo($filename);
			$name = $info["filename"];
			$ext = $info["extension"];
			$ext = strtolower($ext);
			$filename = $name.".".$ext;
			
			$tempFilepath = $file["tmp_name"];
			$destFilepath = PATH_UPLOAD . "/" . $filename;
			
			//if file exists - egt next free filename
			if(file_exists($destFilepath)){				
				$counter = 1;
				do{
					$filename = "$name($counter).$ext";
					$destFilepath = PATH_UPLOAD . "/" . $filename;
					$counter++;	
				}while(file_exists($destFilepath));
			}
			
			move_uploaded_file($tempFilepath,$destFilepath);
			
			if($categoryId != "" && $categoryId != -1){
				moveUploadedItemToCategory($filename,$categoryId,true);
				updateCategoryNumItems($categoryId);				
			}
		}
	}
	
	
?>