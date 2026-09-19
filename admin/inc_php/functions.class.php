<?php

	/* standart functions class used in cms and with flash utils used in cms class */

	class Functions{
		
		//------------------------------------------------------------
		//filter array, leaving only needed fields - also array
		public static function filterArrFields($arr,$fields){
			$arrNew = array();
			foreach($fields as $field){
				if(isset($arr[$field])) 
					$arrNew[$field] = $arr[$field];
			}
			return($arrNew);
		}
		
		//------------------------------------------------------------
		//get path info of certain path with all needed fields
		public static function getPathInfo($filepath){
			$info = pathinfo($filepath);
			
			//fix the filename problem
			if(!isset($info["filename"])){
				$filename = $info["basename"];
				if(isset($info["extension"]))
					$filename = substr($info["basename"],0,(-strlen($info["extension"])-1));
				$info["filename"] = $filename;
			}
						
			return($info);
		}
		
		//------------------------------------------------------------
		//save some file to the filesystem with some text
		public static function saveFile($str,$filepath){
			$fp = fopen($filepath,"w+");
			fwrite($fp,$str);
			fclose($fp);
		}
		
		//--------------------------------------------------------------
		//check the php version. throw exception if the version beneath 5
		private static function checkPHPVersion(){
			$strVersion = phpversion();
			$version = (float)$strVersion;
			if($version < 5) throw new Exception("You must have php5 and higher in order to run the application. Your php version is: $version");
		}
		
		//--------------------------------------------------------------
		// valiadte if gd exists. if not - throw exception
		private static function validateGD(){
			if(function_exists('gd_info') == false) 
				throw new Exception("You need GD library to be available in order to run this application. Please turn it on in php.ini");
		}
				
		//--------------------------------------------------------------
		//validate if the theem exists
		private static function validateTheme(){
			if(is_dir(DIR_THEME) == false)  
				throw new Exception("The theme: '". ACTIVE_THEME."' doesn't exists. Make sure that the folder exists in themes folders");
		}
		
		//--------------------------------------------------------------
		//return if the json library is activated
		public function isJsonActivated(){
			return(function_exists('json_encode'));
		}
		
		//--------------------------------------------------------------
		//validate if json functions exists
		private static function validateJson(){
			if(function_exists('json_encode') == false)
				throw new Exception("You need 'Json' functions to be available in the php. Please include them in php.ini");
		}
		
		//--------------------------------------------------------------
		//validate if some directory is writable, if not - throw a exception
		private static function validateWritable($name,$path,$strList,$validateExists = true){
			
			if($validateExists == true){
				//if the file/directory doesn't exists - throw an error.
				if(file_exists($path) == false)
					throw new Exception("$name doesn't exists");
			}
			else{
				//if the file not exists - don't check. it will be created.
				if(file_exists($path) == false) return(false);
			}
			
			if(is_writable($path) == false){
				chmod($path,0755);		//try to change the permissions
				if(is_writable($path) == false){
					$strType = "Folder";
					if(is_file($path)) $strType = "File";
					$message = "$strType $name is doesn't have a write permissions. Those folders/files must have a write permissions in order that this application will work properly: $strList";					
					throw new Exception($message);
				}
			}
		}				
		
		//--------------------------------------------------------------
		//validate permissions
		private static function validatePermissions(){
			$arrPermissions = array();
			$arrPermissions[] = array(DIR_DB,PATH_DB);
			$arrPermissions[] = array(DIR_UPLOAD,PATH_UPLOAD);
			$arrPermissions[] = array(DIR_THUMBS,PATH_THUMBS);
			$arrPermissions[] = array(DIR_IMAGES,PATH_IMAGES);
			$arrPermissions[] = array(DISPLAY_NAME_DB,FILEPATH_DB,false);
			
			//make a strign of all items
			$arrStrItems = array();
			foreach($arrPermissions as $perm) $arrStrItems[] = $perm[0];
			$strList = "'".implode($arrStrItems,"','")."'";
			
			foreach($arrPermissions as $permission){
				$name = $permission[0];
				$path = $permission[1];
				$validateExists = true;
				if(isset($permission[2])) $validateExists = $permission[2];
				self::validateWritable($name,$path,$strList,$validateExists);
			}
		}
		
		//--------------------------------------------------------------
		//validate presets for identical keys
		public static function validatePresets(){
			global $g_presets;
			if(empty($g_presets)) return(false);
			//check for duplicates
			$assoc = array();
			foreach($g_presets as $preset){
				$id = $preset["id"];
				if(isset($assoc[$id]))
					throw new Exception("Double preset ID detected: $id");
				$assoc[$id] = true;
			}
		}
		
		//--------------------------------------------------------------
		//do some startup validations. if failed - throw exception
		public static function doStartupValidations(){
			//check php version
			self::checkPHPVersion();
			self::validateGD();			
		}
		
		//--------------------------------------------------------------
		//do some startup validations regarding the cms (theme folder etc)
		public static function doStartupCMSValidations(){
			self::validatePresets();			
			self::validateTheme();
			self::validatePermissions();
			self::validateJson();
		}
		
	}
	
?>