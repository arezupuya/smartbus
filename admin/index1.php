<?php
	try{
		require_once "inc_admin.php";
		
		//main functions:		
		function oper_saveSettings(){
			global $database;
			$settings = new Settings($database);
			
			//set the preset
			$preset = getPostVariable("preset");			
			if(!empty($preset))
			$settings->setRelated("preset",$preset);
						
			$response = $settings->saveSettings();
			outputJson($response);
		}
		
		//-------------------------------------------
		// restore settings:
		function oper_restoreSettings(){
			global $database;
						
			$settings = new Settings($database);
			
			$preset = getPostVariable("preset");			
			
			if(!empty($preset))
			$settings->setRelated("preset",$preset);
			
			$response = $settings->restoreSettings();
			outputJson($response);
		}
		
		//-------------------------------------------
		
		santizeAllRequests();
		
		$action = "noaction";		
		if(isset($_POST["action"])) $action = $_POST["action"];		
		switch($action){
			case "saveSettings":
				oper_saveSettings();
			break;
			case "restoreSettings":
				oper_restoreSettings();
			break;
			case "noaction":
				include "inc_cms/template_main.php";
				putTemplate();
			break;
			default:
				dmp("wrong action: ".$action);
				exit();
			break;	
		}
	
	}catch(Exception $e) {
		$message = "<b>" .$e->getMessage() ."</b>";
		$trace = $e->getTraceAsString();
		dmp($message);
		//dmp($trace);
		exit();
	}
?>