<?php
	
	define("LF",chr(13).chr(10));
	define("TAB",chr(9));
	
	function dmp($var){
		echo "<pre>";
		print_r($var);
		echo "</pre>";
	}
	
	//------------------------------------------------------------
	
	function saveFile($str,$filepath){
		$fp = fopen($filepath,"w+");
		fwrite($fp,$str);
		fclose($fp);
	}
	
	//------------------------------------------------------------
	
	function exitWithMessage($message){
		echo $message;
		exit();
	}
	
	//------------------------------------------------------------
	
	function getGetVariable($name,$initVar = ""){
		$var = $initVar;
		if(isset($_GET[$name])) $var = $_GET[$name];
		return($var);
	}
	
	//------------------------------------------------------------
	
	function getPostVariable($name,$initVar = ""){
		$var = $initVar;
		if(isset($_POST[$name])) $var = $_POST[$name];
		return($var);
	}

	//------------------------------------------------------------
	// get variable from post or from get. get wins.
	function getPostGetVariable($name,$initVar = ""){
		$var = $initVar;
		if(isset($_POST[$name])) $var = $_POST[$name];
		else if(isset($_GET[$name])) $var = $_GET[$name];
		return($var);
	}
	
	//------------------------------------------------------------
	//get variable - if exists
	function getVariable($name,$initVar){
		$var = $initVar;
		if(isset($name)) $var = $name;
		return($var);
	}
	
	//------------------------------------------------------------
	// remove utf8 bom sign
	function remove_utf8_bom($content){
		$content = str_replace(chr(239),"",$content);
		$content = str_replace(chr(187),"",$content);
		$content = str_replace(chr(191),"",$content);		
		$content = trim($content);
		return($content);
	}
	
	//------------------------------------------------------------
	
	function toString($obj){
		return(trim((string)$obj));
	}
		
	//---------------------------------------------------------
	// convert br to new line
	function br2nl($text) { return  preg_replace('/<br\\s*?\/??>/i', '', $text);}	
	
	//---------------------------------------------------------
	//email validateion - response: true/false
	function validateEmail($email){
		return eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $email);
	}	
		
	
	//---------------------------------------------------------
	// get value from array. if not - return alternative
	function getArrValue($arr,$key,$altVal=""){
		if(isset($arr[$key])) return($arr[$key]);
		return($altVal);
	}
	
	//---------------------------------------------------------------------------------------------
	// decodes utf-8 string that was encoded in javascript.
	function decodeUtf8($strCodes){
		$arr = explode(" ",$strCodes);
		$str = "";
		foreach($arr as $value){
			$str .= chr(hexdec($value));
		}
		return($str);
	}
	
	//---------------------------------------------------------------------------------------------
	// get browser name (explorer), firefox, and explorer version.
	function getBrowser(){
		$ver = "";
		//determine explorer version:		
		ereg('MSIE ([3-9]\.[0-9])',$_SERVER['HTTP_USER_AGENT'],$reg);
		if(isset($reg[1])){
			$agent = "explorer";
			$ver = intval($reg[1]);
		}
		else{
			$agent = "firefox";
		}
		return(array("browser"=>$agent,"ver"=>$ver));
	}
	
	//---------------------------------------------------------------------------------------------
	// return if the browser is explorer or not.
	function isIE(){
		$browser = getBrowser();
		if($browser["browser"] == "explorer") return(true);
		else return(false);
	}
		
	//---------------------------------------------------------------------------------------------------
	
	function writeFile($str){
		$filename = "max.txt";
		$fp = fopen($filename,"a+");
		fwrite($fp,"\n".$str);
		fclose($fp);
	}
	
	//---------------------------------------------------------------------------------------------------
	
	function writeFileData($str){
		$strPost = "post: " . print_r($_POST,true);
		$strFiles = "files: " . print_r($_FILES,true);
		writeFile("---------------------------------------------------");
		writeFile($str);
		writeFile($strPost);
		writeFile($strFiles);
	}
	
	//---------------------------------------------------------------------------------------------------
	// convert timestamp to date string
	function timestamp2Date($stamp){
		$strDate = date("d M Y",$stamp);	//27 Jun 2009
		return($strDate);
	}
	
	// convert timestamp to time string
	function timestamp2Time($stamp){
		$strTime = date("H:i",$stamp);
		return($strTime);
	}
	
	// convert timestamp to date and time string
	function timestamp2DateTime($stamp){
		$strDateTime = date("d M Y, H:i",$stamp);
		return($strDateTime);		
	}
	
	//---------------------------------------------------------------------------------------------------
	// converts array to xml
	function toXml($array){
		$xml = new array2xml('response');	// main node
		$xml->createNode($array,null);
		return($xml);
	}
	
	//---------------------------------------------------------------------------------------------------
	// converts array to xml and echo it.
	function showXml($array,$showContentType=false){
		global $action,$fromObject;
		
		$array["action"] = $action;
		$array["fromobject"] = $fromObject;
		$xml = toXml($array);
		if($showContentType == true) header("content-type: text/xml");
		echo $xml;
	}
	
	//---------------------------------------------------------------------------------------------------
	//output by json
	function outputJson($arr){
		echo json_encode($arr);
		exit();
	}
	
	//---------------------------------------------------------------------------------------------------
	// return output by provider (global variable)
	function output($var,$showContentType=false){
		global $g_provider;
		switch($g_provider){
			case "json":
				echo json_encode($var);
			break;
			case "xml":
			default:			
				showXml($var,$showContentType);
			break;
		}
	}

	//---------------------------------------------------------------------------------------------------
	// return confirm response array
	function confirmResponse($message = ""){		
		$arrResponse = array("success"=>true,"message"=>$message);
		return($arrResponse);
	}

	//---------------------------------------------------------------------------------------------------
	// return error response array
	function errorResponse($message = ""){		
		$arrResponse = array("success"=>false,"message"=>$message);
		return($arrResponse);
	}
	
	//---------------------------------------------------------------------------------------------------
	// responses error message to the client (in xml format and exit.
	function clientResponseExit($message){
		$arrResponse = array("success"=>false,"message"=>$message);
		output($arrResponse);
		exit();
	}
	
	//---------------------------------------------------------------------------------------------------
	// responses confirm to the client. message is optional.
	function clientConfirmExit($message=""){
		$arrResponse = array("success"=>true,"message"=>$message);
		output($arrResponse);
		exit();		
	}
	
	//------------------------------------------------------------
	// get json object from json string.
	function getJsonObj($jsonStr){
		$jsonStr = trim($jsonStr);
		$jsonStr = stripslashes($jsonStr);
		$obj = json_decode($jsonStr);
		return($obj);
	}
	
	//------------------------------------------------------------
	// check assosiative array for must fields.
	function checkArrMustFields($arr,$arrFields){
		foreach($arrFields as $field) if(!isset($arr[$field])) return(array("success"=>false,"missingField"=>$field));
		return(confirmResponse());
	}
	
	//------------------------------------------------------------
	// sanitize request variable
	function sanitizeRequestVar($var){
		$var = htmlspecialchars_decode($var);
		$var = stripslashes($var);
		return($var);
	}
	
	//------------------------------------------------------------
	// sanitize get or post or files variable
	function santizeAllRequests(){
		foreach($_GET as $key=>$var) $_GET[$key] = sanitizeRequestVar($var);
		foreach($_POST as $key=>$var) $_POST[$key] = sanitizeRequestVar($var);		
	}
	
	//------------------------------------------------------------
	// return an error xml
	function outputErrorXml($message){
		header("content-type: text/xml");
		$str = '<?xml version="1.0" encoding="UTF-8"?>'."\n";
		$str.='<response><success></success><message>'.$message.'</message><action></action></response>';
		echo $str;	
		exit();
	}
	

	//------------------------------------------------------------
	// get black value from rgb value
	function yiq($r,$g,$b){
		return (($r*0.299)+($g*0.587)+($b*0.114));
	}
	
	//------------------------------------------------------------	
	// convert colors to rgb
	function html2rgb($color){
		if ($color[0] == '#')
			$color = substr($color, 1);
		if (strlen($color) == 6)
			list($r, $g, $b) = array($color[0].$color[1],
									 $color[2].$color[3],
									 $color[4].$color[5]);
		elseif (strlen($color) == 3)
			list($r, $g, $b) = array($color[0].$color[0], $color[1].$color[1], $color[2].$color[2]);
		else
			return false;
		$r = hexdec($r); $g = hexdec($g); $b = hexdec($b);
		return array($r, $g, $b);
	}	
	
?>