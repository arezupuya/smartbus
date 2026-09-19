<?php

	//---------------------------------------------------------------------------------------------------------------
	//add preset to presets array
	function addPreset($id,$title){
		global $g_presets;
		if(empty($g_presets))
			$g_presets = array();
		$g_presets[] = array("id"=>$id,"title"=>$title);
	}
	
	//---------------------------------------------------------------------------------------------------------------
	//get active preset from GET variable
	function getActivePreset(){
		global $g_presets;
		if(empty($g_presets)) return("");
		
		$presetID = $g_presets[0]["id"];
		$reqPresetID = getPostGetVariable("preset","");
		foreach($g_presets as $preset)
			if($preset["id"] == $reqPresetID)
				$presetID = $preset["id"];
		return($presetID);
	}
	
	//---------------------------------------------------------------------------------------------------------------
	//create globals $database variable
	function createDatabaseGlobal(){
		global $database;
		$type = strtolower(DB_TYPE);
		switch($type){
			case "sqlite":
				require_once(PATH_INC."/"."sqlite.class.php");
				$database = new Database(FILEPATH_DB);
			break;
			case "pdo_sqlite":
				require_once(PATH_INC."/"."pdo.class.php");
				$database = new Database(DbPdo::DBTYPE_SQLITE,FILEPATH_DB);
			break;
			case "pdo_mysql":
				require_once(PATH_INC."/"."pdo.class.php");
				$database = new Database(Database::DBTYPE_MYSQL,FILEPATH_DB);
				$database->setMysqlData(MYSQL_HOST,MYSQL_USERNAME,MYSQL_PASSWORD,MYSQL_DATABASE);
			break;
			case "mysql":
				require_once(PATH_INC."/"."mysql.class.php");
				$database = new Database(MYSQL_HOST,MYSQL_USERNAME,MYSQL_PASSWORD,MYSQL_DATABASE);
			break;
			default:
				throw new Exception("Wrong DB_TYPE:'$type' please edit it in config.php");
			break;
		}				
	}

	//validate settings. return success-false, and error message if true.
	function validateInitSettings(){
		if(!defined("URL_IMAGES")) return errorResponse("Can't find images url. please define URL_IMAGES in cofnig file.");	
		if(!defined("URL_THUMBS")) return errorResponse("Can't find thumbs url. plaese define URL_THUMBS in config file.");
		if(!is_dir(PATH_IMAGES)) return errorResponse("The path: ".PATH_IMAGES." doesn't exists. please create it");
		if(!is_dir(PATH_THUMBS)) return errorResponse("The path: ".PATH_THUMBS." doesn't exists. please create it.");
		return confirmResponse();
	}
	
	//---------------------------------------------------------------------------------------------------------------
	// get initial settings (include templates list)
	function getInitSettings(){		
		//validate init settings.		
		$response = validateInitSettings();
		if($response["success"] == false) return($response);
		
		// set arrSettings.
		$enableLogin = "true";
		if(ENABLE_LOGIN == false) $enableLogin = "false";
		
		$defultView = "admin";
		if(DEFAULT_VIEW == "user") $defultView = "user"; 
		
		$topText = "";
		if(defined("TEXT_TOP")) $topText = TEXT_TOP;
		
		$loginText = "";
		if(defined("TEXT_LOGIN")) $loginText = TEXT_LOGIN; 
		
		$arrSettings = array();
		$arrSettings["enableLogin"] = $enableLogin;
		$arrSettings["defaultView"] = $defultView;
		$arrSettings["topText"] = $topText;
		$arrSettings["loginText"] = $loginText;
		$arrSettings["urlGallery"] = URL_GALLERY;
		
		return(array("success"=>true,"arrSettings"=>$arrSettings));
	}
	
	
	//---------------------------------------------------------------------------------------------------
	// check login info, return if approved, and user type - admin,user. 
	function checkLogin($user,$pass){
		$approved = "false";
		$hash = "";
		if($user == ADMIN_USERNAME && $pass == md5(ADMIN_PASSWORD)){
			$approved = "true";
			$userType = "admin";
		}
		else if($user == USER_USERNAME && $pass == md5(USER_PASSWORD)){
			$approved = "true";
			$userType = "user";
		}				
		
		return(array("success"=>true,"approved"=>$approved,"userType"=>$userType));
	}
		
	//---------------------------------------------------------------------------------------------------
	// get list of all files in the directory
	function getFileList($path){
		$dir = scandir($path);
		$arrFiles = array();
		foreach($dir as $file){
			if($file == "." || $file == "..") continue;
			$filepath = $path . "/" . $file;
			if(is_file($filepath)) $arrFiles[] = $file;
		}
		return($arrFiles);
	}
	
	
?>