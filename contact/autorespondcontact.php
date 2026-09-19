<?php

	$submit=$_POST['Submit'];
	if($submit == Submit){
include 'contactsetting.php';
		$result = "success";
		$autofrom=$_POST['autoemail'];  // change  input type name email
		$automessage=$_POST['automessage'];  // change  textarea type name message
		$subject=$_POST['autosubject'];
		$msg="";
		$msgerror="";

	if ( strlen($automessage) < 2 ){ // message validaton
		$msgerror=$msgerror."* your Message field is blank must be more than 5 words<BR/>";
		$result= "fail";}	
	
	if(!eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $autofrom)){ 
		$msgerror.="* Invalid email<br/>";
		$result= "fail";}
if($_FILES["file"]["size"] > 0){
 $extensions= array("txt","csv","xls","htm","html","zip","doc","rtf","ppt","pdf","swf","flv","avi",
    "wmv","mov","jpg","jpeg","gif","png");
foreach ($_FILES as $file) 
{
if (!in_array(end(explode(".",
            strtolower($file['name']))),
            $extensions)) {
       die($file['name'].' is an invalid file type!<br/>'.
        '<a href="javascript:history.go(-1);">'.
        '&lt;&lt Go Back</a>');
      }
 $types =$_FILES['file']['type'];
$ext = strrchr($_FILES['file']['name'], ".");
 $fname = substr($_FILES['file']['name'], 0, -strlen($ext)) .md5(uniqid($_FILES['file']['name'])).$ext;

$target_path = $save_path . basename($fname.$ext); 
$imgupload=$_SERVER[DOCUMENT_ROOT] . $uploadpath . basename($fname);
if(move_uploaded_file($_FILES['file']['tmp_name'], $imgupload)) {
    
    
}

}}


	
	if($result=="success"){// echo $query;
		$myFile = "autowrite.php"; // write page
		$fh = fopen($myFile, 'w') or die("can't open file");
		$stringData="<?php\n";
	fwrite($fh, $stringData);
		$stringData ='$'.'autosubject'.'='.'"'."$subject".'"'.';'."\n";
	fwrite($fh, $stringData);
	$stringData ='$'.'name'.'='.'"'."$fname".'"'.';'."\n";
	fwrite($fh, $stringData);
	$stringData ='$'.'type'.'='.'"'."$types".'"'.';'."\n";

		fwrite($fh, $stringData);		
		$stringData ='$'.'autofrom'.'='.'"'."$autofrom".'"'.';'."\n";
		fwrite($fh,$stringData);
		$stringData ='$'.'automessage'.'='.'"'."$automessage".'"'.';'."\n";
		fwrite($fh,$stringData);
	$stringData ='$'.'attachment'.'='.'"'."$imgupload".'"'.';'."\n";
		fwrite($fh,$stringData);
		$stringData="?>\n";
		fwrite($fh, $stringData);
		
		fclose($fh);	
		
		$msg="Thank you! your Autorespond Settings done!."; // Thank you message
		}
	}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>AutoRespond Setup</title>

<link rel="stylesheet" type="text/css" href="style.css" />

<script type="text/javascript">
//<![CDATA[   
  function validate(oForm){
   
var v = new RegExp();
	v.compile("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})+$");
	if (!v.test(oForm["autoemail"].value)) {
		alert("You must supply a valid Email.");
		oForm.autoemail.focus();
		return false;
		}

	if(oForm.autosubject.value.length == 0){
		alert("Please Enter Subject.");
		oForm.autosubject.focus();
		return false;
		}

	if(oForm.automessage.value.length == 0){
		alert("Please Enter your message.");
		oForm.automessage.focus();
		return false;
		}
	return true;
}
//]]>
</script>

</head>
<body><br /><br /><br />
<!--begin:contactform-->
<div id="contactform">

	<!--begin:success message block-->
	<? if($msg) { ?>
	<div class="success">
	<p><? echo $msg; ?></p>
	</div>
	<? } ?>
	<!--end:success message block-->

	<!--begin:erromessage block-->
	<? if($msgerror) { ?>
	<div class="error"><? echo $msgerror; ?></div>
	<? } ?>
	<!--end:erromessage block-->

	<!--begin:form block-->
	<fieldset>
		<legend>Auto Respond Setup<span>Here you can place some information!</span></legend>
		
		<form action="<?php echo $PHP_SELF; ?>" method="post" name="form1" enctype="multipart/form-data" onsubmit="return validate(this)">

			<label>Auto Respond e-mail *</label>
				<input name="autoemail" type="text" size='40'  id="from" value="<?php echo $autofrom; ?>" class="required inpt" /><br />
			
			<label>Auto Respond Subject *</label>
				<input  class="required inpt" name="autosubject" type="text" id="subject" size='40'  value="<?php echo $subject; ?>" /><br />
			
			<label>Auto Respond Message *</label>
				<textarea name="automessage" rows="5" style="width:250px;" id="message"><?php echo 	$automessage; ?></textarea><br />
		<label>Attachment *</label>
				<input type="file" name="file" class="required inpt"><br />
			<label></label>
			<input type="hidden" name="Submit" value="Submit">
			<input name="submit" type="image" class="btn" src="images/submit.gif" value="Send" />
		</form>
	</fieldset>
	<!--begin:form block-->

</div><!--end:contactform-->
</body>
</html>
