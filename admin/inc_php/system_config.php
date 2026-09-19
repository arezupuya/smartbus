<?php
		
	//set url site
	$scriptUrl = $_SERVER["SCRIPT_NAME"];
	$info = Functions::getPathInfo($scriptUrl);
	$path = $info["dirname"];
	$urlSite = "http://".$_SERVER["SERVER_NAME"].$path."/";
	
	define("URL_SITE",$urlSite);
	define("DIR_THEMES","themes");
	
	//------------------------------------------------------------------------------------------------
	//turn on error reporting
	if(isset($_GET["debug"]) && $_GET["debug"] == true){
		error_reporting(E_ALL); 
		ini_set("display_errors", 1);
	} 
	
	
	//------------------------------------------------------------------------------------------------
	
	define("URL_MAIN",URL_SITE.ADMIN_FILE);
	define("URL_GALLERY",URL_SITE.GALLERY_FILE);
	define("URL_THEME",URL_SITE.DIR_THEMES."/".ACTIVE_THEME."/");
	define("DIR_THEME",DIR_THEMES."/".ACTIVE_THEME."/");

	define("DIR_ALL_IMAGES","images");
	define("DIR_IMAGES",DIR_ALL_IMAGES."/original");
	define("DIR_THUMBS",DIR_ALL_IMAGES."/resized");
	define("DIR_IMAGES_SYSTEM",DIR_ALL_IMAGES."/system");
	define("DIR_UPLOAD","upload");
	
	define("URL_IMAGES",URL_SITE.DIR_IMAGES);
	define("URL_THUMBS",URL_SITE.DIR_THUMBS);

	define("PATH_UPLOAD",PATH_CURRENT."/".DIR_UPLOAD);
	define("PATH_THUMBS",PATH_CURRENT."/".DIR_THUMBS);
	define("PATH_IMAGES",PATH_CURRENT."/".DIR_IMAGES);
	
	define("FILENAME_NO_IMAGE","noimage.jpg");
	
	define("DIR_DB","db");
	define("FILENAME_DB","dbmain.sql");
	
	define("PATH_DB",PATH_CURRENT."/".DIR_DB);
	define("DISPLAY_NAME_DB",DIR_DB."/".FILENAME_DB);
	define("FILEPATH_DB",PATH_DB."/".FILENAME_DB);
	
	//------------------------------------------------------------------------------------------------
	
	define("USE_GD",true);
	
	define("INPAGE_ADMIN",5);
	
	//------------------------------------------------------------------------------------------------
	// set default image settings:
	define("DEFAULT_THUMB_WIDTH",100);
	define("DEFAULT_THUMB_HEIGHT",100);
	
	define("DEFAULT_IMAGE_WIDTH",800);
	define("DEFAULT_IMAGE_HEIGHT",800);
	
	define("ADMIN_THUMB_WIDTH",100);
	define("ADMIN_THUMB_HEIGHT",100);
	
	define("ADMIN_IMAGE_WIDTH",800);
	define("ADMIN_IMAGE_HEIGHT",800);
	
	//------------------------------------------------------------------------------------------------
	
	define("TABLE_CATEGORIES","categories");
	define("TABLE_IMAGES","images");
	define("TABLE_ITEMS","items");
	define("TABLE_SETTINGS","settings");
	
	//------------------------------------------------------------------------------------------------
	
	define("SEPARATOR_PERMISSIONS","|");
	
	define("CATEGORY_EMPTY_NAME","new category");
	define("CATEGORY_DEFAULT_NAME","Default");
	define("CATEGORY_UPLOADED_NAME","Uploaded");
	
	// set category types:
	define("TYPE_CATEGORY_NORMAL","normal");
	define("TYPE_CATEGORY_DEFAULT","default");
	define("TYPE_CATEGORY_UPLOADED","uploaded");
	
	//------------------------------------------------------------------------------------------------
	
	define("TYPE_SETTINGS_BOOLEAN","boolean");
	define("TYPE_SETTINGS_STRING","string");
	define("TYPE_SETTINGS_TEXT","text");
	define("TYPE_SETTINGS_NUMBER","number");
	define("TYPE_SETTINGS_CUSTOM","custom");
	
	//------------------------------------------------------------------------------------------------
	
	define("FILETYPE_IMAGE","image");
	define("FILETYPE_MUSIC","music");
	define("FILETYPE_VIDEO","movie");
	define("FILETYPE_FLASH","flash");
	define("FILETYPE_OTHER","other");
	
	//set category permission types:
	define("PERMISSION_CATEGORY_READONLY","readonly");
	define("PERMISSION_CATEGORY_NODETE","nodelete");
	define("PERMISSION_CATEGORY_NOUPDATE","noupdate");
	define("PERMISSION_CATEGORY_NOADDITEMS","noadditems");
	$arrPermissionTypes = array(PERMISSION_CATEGORY_READONLY,PERMISSION_CATEGORY_NODETE,PERMISSION_CATEGORY_NOUPDATE,PERMISSION_CATEGORY_NOADDITEMS);
?>