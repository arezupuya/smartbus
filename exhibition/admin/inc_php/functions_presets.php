<?php
	
	define("TABLE_PRESETS","presets");
	
	//--------------------------------------------------------------------------------------------------------------	
	//create table of Presets.
	function createPresetsTable(){
		global $database;
		$arrCreate = array();
		$arrCreate["id"] = Database::TYPE_KEY;
		$arrCreate["name"] = Database::TYPE_STRING;
		$arrCreate["data"] = Database::TYPE_TEXT;
		$response = $database->createTable(TABLE_PRESETS,$arrCreate);
		return($response);
	}
	
	//--------------------------------------------------------------------------------------------------------------	
	//add Preset to database:
	function addPresetToDatabase($arrPreset){
		global $database;
		
		$errorMessage = "Can't add Preset";	
		
		$name = getArrValue($arrPreset,"name");
		$data = getArrValue($arrPreset,"data");
		
		$response = createPresetsTable();		
		if($response["success"] == false) clientResponseExit($errorMessage);
		
		//insert the data to the table
		$arrInsert = array();
		$arrInsert["name"] = $name;
		$arrInsert["data"] = $data;
		
		$response = $database->insert(TABLE_PRESETS,$arrInsert);
		
		if($response["success"] == false) clientResponseExit($errorMessage);
		
		$id = $response["lastID"];
		
		return(array("success"=>true,"id"=>$id));
	}
		
	//--------------------------------------------------------------------------------------------------------------	
	// get Preset row by id
	function getPresetData($presetID){
		global $database;
		$errorMessage = "Preset with id:$presetID no found";
		
		$response = $database->fetch(TABLE_PRESETS,"id=$presetID");
		if($response["success"] == false) return(errorResponse($errorMessage));
		if(count($response["rows"]) == 0) return(errorResponse($errorMessage));
		$arrPreset = $response["rows"][0];
		return(array("success"=>true,"arrPreset"=>$arrPreset));
	}
		
	//--------------------------------------------------------------------------------------------------------------	
	// delete Preset from the database, and filesystem
	function deletePreset($presetID){
		global $database;
		$errorMessageDatabase = "Can't get the preset from the database.";
		$errorMessage = "Can't delete preset from database";
		
		$response = $database->fetch(TABLE_PRESETS,"id=$presetID");

		if($response["success"] == false) return(errorResponse($errorMessageDatabase));
		$rows = $response["rows"];
		if(count($rows) == 0) return(errorResponse($errorMessageDatabase));
		
		$arrPreset = $rows[0];
		$filename = $arrPreset["filename"];
		$PresetPath = PATH_Presets."/".$filename;
		
		$response = $database->delete(TABLE_PRESETS,"id=$presetID");
		if($response["success"] == false) return(errorResponse($errorMessage));
		
		return(confirmResponse());
	}
	
	//------------------------------------------------------------------------------------
	// get pre4sets list
	function getPresetsList(){
		
	}
	
	//update preset
	function updatePreset($presetID,$arrPreset){
		
	}
	
?>