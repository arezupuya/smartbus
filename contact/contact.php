<?php

// Do not edit this if you are not familiar with php
error_reporting (E_ALL ^ E_NOTICE);
$post = (!empty($_POST)) ? true : false;
include 'contactsetting.php';
if($post)
	{
	function ValidateEmail($email)
	{

$regex = "([a-z0-9_\.\-]+)". # name

"@". # at

"([a-z0-9\.\-]+){2,255}". # domain & possibly subdomains

"\.". # period

"([a-z]+){2,10}"; # domain extension 

$eregi = eregi_replace($regex, '', $email);

return empty($eregi) ? true : false;
}

$name = stripslashes($_POST['name']);
$email = trim($_POST['email']);
$subject = stripslashes($_POST['subject']);
$message = stripslashes($_POST['message']);
$phone = stripslashes($_POST['phone']);
$answer = trim($_POST['answer']);
$verificationanswer="4"; // plz  change edit your human answer
$to=$toemail.','.$replyto;
$error = '';
$headers="";
$headers.="Reply-to:$replyto\n";
$headers .= "From: $email\n";
$headers = 'MIME-Version: 1.0' . "\r\n";
$headers = "Content-Type: text/html; charset=iso-8859-1\n".$headers;

// Checks Name Field

if(!$name)
{
$error .= 'Please enter your name.<br />';
}

// Checks Email Field

if(!$email)
{
$error .= 'Please enter an e-mail address.<br />';
}

if($email && !ValidateEmail($email))
{
$error .= 'Please enter a valid e-mail address.<br />';
}

if(is_numeric($phone))
    {
        
if(!$phone || strlen($phone) < 5)
{
$error .= "Please enter your Phone Number. It should have more than 7 Numbers.<br />";
}


    }
    else
    {
       $error .="Please enter numeric characters in Phone Number field.<br />";
    }



// Checks Subject Field
if(!$subject)
{
$error .= 'Please enter your subject.<br />';
}

if( $answer <> $verificationanswer)
{
$error .= 'Please enter the Correct verification number.<br />';
}

// Checks Message (length)
if(!$message || strlen($message) < 5)
{
$error .= "Please enter your message. It should have at least 5 characters.<br />";
}




if(!$error)
	{
$messages="From: $email <br>";
$messages.="Name: $name <br>";
$messages.="Email: $email <br>";
$messages.="Phone: $phone <br>";
$messages.="Message: $message <br>";

	$mail = mail($to,$subject,$messages,$headers);	

if($mail)
	{
	echo 'OK';
if($autorespond == "yes")
{
	include("autoresponde.php");
}
	}

	}
	else
	{
	echo '<div class="error">'.$error.'</div>';
	}

}
?>