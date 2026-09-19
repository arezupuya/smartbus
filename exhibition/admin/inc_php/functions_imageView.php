<?php
	
	function getThumbFilename($filename,$width,$height,$type=""){
		$info = pathInfo($filename);
		$ext = $info["extension"];
		$name = $info["filename"];
		$width = ceil($width);
		$height = ceil($height);
		$thumbFilename = $name."_".$width."x".$height;		
		if($type != "") $thumbFilename .= "_" . $type;
		$thumbFilename .= ".".$ext;
		return($thumbFilename);
	}
	
	//------------------------------------------------------------------------------------------
	// get thumbnail fielpath by parameters.
	function getThumbFilepath($filename,$width,$height,$type=""){
		$filename = getThumbFilename($filename,$width,$height,$type);
		$filepath = PATH_THUMBS . "/".$filename;
		return($filepath);
	}

	//------------------------------------------------------------------------------------------
	// get thumbnail url by parameters.
	function getThumbUrl($filename,$width,$height){
		$filename = getThumbFilename($filename,$width,$height);
		$url = URL_THUMBS . "/".$filename;
		return($url);
	}
	
	//------------------------------------------------------------------------------------------
	// ouptput emtpy image code.
	function outputEmptyImageCode($width,$height){	
		echo "empty image";
		exit();
	}
	
	//------------------------------------------------------------------------------------------
	// outputs image and exit.
	function outputImage($filepath){
		$info = Functions::getPathInfo($filepath);
		$ext = $info["extension"];				
		$filetime = filemtime($filepath);
		
		$numExpires = 31536000;	//one year
		$strExpires = date('D, d M Y H:i:s',time()+$numExpires);
		$strModified = date('D, d M Y H:i:s',$filetime);
		
		$contents = file_get_contents($filepath);
		$filesize = strlen($contents);				
		header("Last-Modified: $strModified GMT");
		header("Expires: $strExpires GMT");
		header("Cache-Control: public");
		header("Content-Type: image/$ext");
		header("Content-Length: $filesize");
		echo $contents;
		exit();
	}
	
	//------------------------------------------------------------------------------------------
	// output image for downloading
	function outputImageForDownload($filepath,$filename,$mimeType=""){		
		$contents = file_get_contents($filepath);
		$filesize = strlen($contents);
		
		if($mimeType == ""){
			$info = Functions::getPathInfo($filepath);
			$ext = $info["extension"];
			$mimeType = "image/$ext";
		}
		
		header("Content-Type: $mimeType");	
		header("Content-Disposition: attachment; filename=\"$filename\"");
		header("Content-Length: $filesize");		
		echo $contents;
		exit();
	}
	
	//------------------------------------------------------------------------------------------
	// download image, change size and name if needed.
	function downloadImage($filename){
		$filepath = DIR_IMAGES."/".$filename;
		if(!is_file($filepath)) {
			echo "file doesn't exists";
			exit();
		}
		outputImageForDownload($filepath,$filename);
	}
	
	//------------------------------------------------------------------------------------------
	// get src image from filepath according the image type
	function getGdSrcImage($filepath,$type){
		// create the image
		$src_img = false;
		switch($type){
			case IMAGETYPE_JPEG:
				$src_img = @imagecreatefromjpeg($filepath);
			break;
			case IMAGETYPE_PNG:
				$src_img = @imagecreatefrompng($filepath);
			break;
			case IMAGETYPE_GIF:
				$src_img = @imagecreatefromgif($filepath);
			break;
			case IMAGETYPE_BMP:
				$src_img = @imagecreatefromwbmp($filepath);
			break;
			default:
				return(errorResponse("wrong image format, can't resize"));
			break;
		}
		
		if($src_img == false) errorResponse("Can't resize image");
		return(array("success"=>true,"image"=>$src_img));
	}
	
	//------------------------------------------------------------------------------------------
	// save gd image to some filepath. return if success or not
	function saveGdImage($dst_img,$filepath,$type){
		$successSaving = false;
		switch($type){
			case IMAGETYPE_JPEG:
				$successSaving = imagejpeg($dst_img,$filepath,100);
			break;
			case IMAGETYPE_PNG:
				$successSaving = imagepng($dst_img,$filepath);
			break;
			case IMAGETYPE_GIF:
				$successSaving = imagegif($dst_img,$filepath);
			break;
			case IMAGETYPE_BMP:
				$successSaving = imagewbmp($dst_img,$filepath);
			break;
		}
		
		return($successSaving);
	}
	
	//------------------------------------------------------------------------------------------
	// crop image to specifix height and width , and save it to new path
	function cropImageSaveNew($filepath,$cropWidth,$cropHeight,$filepathNew,$type){
		
		$imgInfo = getimagesize($filepath);
		$imgType = $imgInfo[2];
		
		$response = getGdSrcImage($filepath,$imgType);
		if($response["success"] == false) return($response);
		
		$src_img = $response["image"];		
		
		$width = imageSX($src_img);
		$height = imageSY($src_img);
		
		//crop the image from the top
		$startx = 0;
		$starty = 0;
		
		//find precrop width and height:
		$percent = $cropWidth / $width;
		$newWidth = $cropWidth;
		$newHeight = ceil($percent*$height);
		
		if($type == "exact"){ 	//crop the image from the middle
			$startx = 0;
			$starty = ($newHeight-$cropHeight)/2;
		}
		
		if($newHeight < $cropHeight){	//by width
			$percent = $cropHeight / $height;
			$newHeight = $cropHeight;
			$newWidth = ceil($percent*$width);
			
			if($type == "exact"){ 	//crop the image from the middle
				$startx = ($newWidth - $cropWidth)/2;
				$starty = 0;
			}
		}
		
		//resize the picture:
		$tmp_img = ImageCreateTrueColor($newWidth,$newHeight);
		
		handleTransparency($tmp_img,$imgType,$newWidth,$newHeight);
		
		imagecopyresampled($tmp_img,$src_img,0,0,$startx,$starty,$newWidth,$newHeight,$width,$height);
		
		//crop the picture:
		$dst_img = ImageCreateTrueColor($cropWidth,$cropHeight);
		
		handleTransparency($dst_img,$imgType,$cropWidth,$cropHeight);
		
		imagecopy($dst_img, $tmp_img, 0, 0, 0, 0, $newWidth, $newHeight);
		
		//save the picture
		saveGdImage($dst_img,$filepathNew,$imgType);
		
		imagedestroy($dst_img);
		imagedestroy($src_img);
		imagedestroy($tmp_img);
		
		return(array("success"=>true));		
	}
	
	//------------------------------------------------------------------------------------------
	// if the images are png or gif - handle image transparency
	function handleTransparency(&$dst_img,$imgType,$newWidth,$newHeight){
		//handle transparency:
		if($imgType == IMAGETYPE_PNG || $imgType == IMAGETYPE_GIF){
		  imagealphablending($dst_img, false);
		  imagesavealpha($dst_img,true);
		  $transparent = imagecolorallocatealpha($dst_img, 255,  255, 255, 127);
		  imagefilledrectangle($dst_img, 0,  0, $newWidth, $newHeight,  $transparent);
		}
	}
	
	//------------------------------------------------------------------------------------------
	// resize image and save it to new path
	function resizeImageSaveNew($filepath,$maxWidth,$maxHeight,$filepathNew){
		
		$imgInfo = getimagesize($filepath);
		$imgType = $imgInfo[2];
		
		$response = getGdSrcImage($filepath,$imgType);
		if($response["success"] == false) return($response);
		
		$src_img = $response["image"];				
		 
		$width = imageSX($src_img);
		$height = imageSY($src_img);
		
		$newWidth = $width;
		$newHeight = $height;

		
		//find new width
		if($height > $maxHeight){
			$procent = $maxHeight / $height;
			$newWidth = ceil($width * $procent);
			$newHeight = $maxHeight;
		}
		
		//if the new width is grater than max width, find new height, and remain the width.
		if($newWidth > $maxWidth){
			$procent = $maxWidth / $newWidth;
			$newHeight = ceil($newHeight * $procent);
			$newWidth = $maxWidth;
		}
		
		//if the image don't need to be resized, just copy it from source to destanation.
		if($newWidth == $width && $newHeight == $height){
			$success = copy($filepath,$filepathNew);
			if($success == false) return(errorResponse("can't copy the image from one path to another"));
		}
		else{		//else create the resized image, and save it to new path:
			$dst_img=ImageCreateTrueColor($newWidth,$newHeight);			
			
			handleTransparency($dst_img,$imgType,$newWidth,$newHeight);
			
			//copy the new resampled image:
			imagecopyresampled($dst_img,$src_img,0,0,0,0,$newWidth,$newHeight,$width,$height);
			
			saveGdImage($dst_img,$filepathNew,$imgType);
			imagedestroy($dst_img);
		}
		
		imagedestroy($src_img);
		$result = array();
		$result["success"] = true;
		return($result);
	}
	
	
	//------------------------------------------------------------------------------------------
	//return image
	function showImage($filename,$maxWidth=-1,$maxHeight=-1,$type=""){
		$filepath = DIR_IMAGES."/".$filename;		
		if(!is_file($filepath)) $filepath = DIR_IMAGES_SYSTEM."/".FILENAME_NO_IMAGE;
		
		if(!is_file($filepath)) outputEmptyImageCode($maxWidth,$maxHeight);
		
		//if gd library doesn't exists - output normal image without resizing.
		if(USE_GD == false) outputImage($filepath);
		if(function_exists("gd_info") == false) outputImage($filepath);
		
		if(is_numeric($maxWidth) == false || is_numeric($maxHeight) == false) outputImage($filepath);
		if($maxWidth == -1 && $maxHeight == -1) outputImage($filepath);
		
		if($maxWidth == -1) $maxWidth = 1000000;
		if($maxHeight == -1) $maxHeight = 100000;
				
		$filepathNew = getThumbFilepath($filename,$maxWidth,$maxHeight,$type);
		
		//if(is_file($filepathNew)) outputImage($filepathNew); 		//remove me
		if($type == "exact" || $type == "exacttop")
			$response = cropImageSaveNew($filepath,$maxWidth,$maxHeight,$filepathNew,$type);
		else 
			$response = resizeImageSaveNew($filepath,$maxWidth,$maxHeight,$filepathNew);
		
		if($response["success"] == false) outputImage($filepath);
		if(is_file($filepathNew)) outputImage($filepathNew);
		else outputImage($filepath);
		exit();
	}
	
?>