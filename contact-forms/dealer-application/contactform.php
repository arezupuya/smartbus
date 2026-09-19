<?PHP
/*
    Contact Form from HTML Form Guide
    This program is free software published under the
    terms of the GNU Lesser General Public License.
    See this page for more info:
    http://www.html-form-guide.com/contact-form/contact-form-attachment.html
*/
require_once("./include/fgcontactform.php");
require_once("./include/captcha-creator.php");

$formproc = new FGContactForm();
$captcha = new FGCaptchaCreator('scaptcha');

$formproc->EnableCaptcha($captcha);

//1. Add your email address here.
//You can add more than one receipients.
$formproc->AddRecipient('firas@smarthomegroup.com, jay@smarthomegroup.com, helen@smarthomegroup.com, anna@smarthomegroup.com'); //<<---Put your email address here


//2. For better security. Get a random tring from this link: http://tinyurl.com/randstr
// and put it here
$formproc->SetFormRandomKey('XsHVufPpgD9Epwl');

$formproc->AddFileUploadField('license','jpg,jpeg,gif,png,bmp',2024);
$formproc->AddFileUploadField('passport','jpg,jpeg,gif,png,bmp',2024);

if(isset($_POST['submitted']))
{
   if($formproc->ProcessForm())
   {
        $formproc->RedirectToURL("thank-you.php");
   }
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-US" lang="en-US">
<head>
      <meta http-equiv='Content-Type' content='text/html; charset=utf-8'/>
      <title>Contact us</title>
      <link rel="STYLESHEET" type="text/css" href="contact.css" />
      <script type='text/javascript' src='scripts/gen_validatorv31.js'></script>
      <script type='text/javascript' src='scripts/fg_captcha_validator.js'></script>
</head>
<body>

<!-- Form Code Start -->
<form id='contactus' action='<?php echo $formproc->GetSelfScript(); ?>' method='post' enctype="multipart/form-data" accept-charset='UTF-8'>

<fieldset >
<legend>Dealer Form</legend>

<a href="http://www.smarthomebus.com/dealers/Others/Smart-Home-Group-Dealer-Application-2011.pdf" title="Smart Home Group Dealer Application Form" target="_new"><font face="Verdana, Geneva, sans-serif" style="font-size:11px; font-weight:bold; text-align:right; color:#333">Download Dealer Application<br />
</font></a><br />
<input type='hidden' name='submitted' id='submitted' value='1'/>
<input type='hidden' name='<?php echo $formproc->GetFormIDInputName(); ?>' value='<?php echo $formproc->GetFormIDInputValue(); ?>'/>
<input type='text'  class='spmhidip' name='<?php echo $formproc->GetSpamTrapInputName(); ?>' />

<div class='short_explanation'>* required fields</div>

<div><span class='error'><?php echo $formproc->GetErrorMessage(); ?></span></div>
<div class='container'>
    <label for='name' >Your Full Name*: </label><br/>
    <input type='text' name='name' id='name' value='<?php echo $formproc->SafeDisplay('name') ?>' maxlength="50" /><br/>
    <span id='contactus_name_errorloc' class='error'></span>
</div>
<div class='container'>
    <label for='company' >Company Name*: </label><br/>
    <input type='text' name='company' id='company' value='<?php echo $formproc->SafeDisplay('company') ?>' maxlength="50" /><br/>
    <span id='contactus_company_errorloc' class='error'></span>
</div>
<div class='container'>
    <label for='email' >Email Address*:</label><br/>
    <input type='text' name='email' id='email' value='<?php echo $formproc->SafeDisplay('email') ?>' maxlength="50" /><br/>
    <span id='contactus_email_errorloc' class='error'></span>
</div>
<div class='container'>
    <label for='tel' >Tel/Mobile*:</label><br/>
    <input type='text' name='tel' id='tel' value='<?php echo $formproc->SafeDisplay('tel') ?>' maxlength="50" /><br/>
    <span id='contactus_tel_errorloc' class='error'></span>
</div>
<div class='container'>
    <label for='area' >Area/Territory Covered:</label><br/>
    <input type='text' name='area' id='area' value='<?php echo $formproc->SafeDisplay('area') ?>' maxlength="50" /><br/>
    <span id='contactus_area_errorloc' class='error'></span>
</div>

<div class='container'>
    <label for='projvalue' >Project Value*:</label><br/>
    <input type='text' name='projvalue' id='projvalue' value='<?php echo $formproc->SafeDisplay('projvalue') ?>' maxlength="50" /><br/>
    <span id='contactus_projvalue_errorloc' class='error'></span>
</div>
<div class='container'>
    <label for='order' >When you will start ordering:</label><br/>
    <input type='text' name='order' id='order' value='<?php echo $formproc->SafeDisplay('order') ?>' maxlength="50" /><br/>
    <span id='contactus_tel_errorloc' class='error'></span>
</div>
<div class='container'>
    <label for='training' >When you can come for Training:</label><br/>
    <input type='text' name='training' id='training' value='<?php echo $formproc->SafeDisplay('training') ?>' maxlength="50" /><br/>
    <span id='contactus_training_errorloc' class='error'></span>
</div>
<div class='container'>
    <label for='technical' >How many technical team your company have:</label><br/>
    <input type='text' name='technical' id='technical' value='<?php echo $formproc->SafeDisplay('technical') ?>' maxlength="50" /><br/>
    <span id='contactus_technical_errorloc' class='error'></span>
</div>
<div class='container'>
    <label for='sales' >How many sales team your company have:</label><br/>
    <input type='text' name='sales' id='sales' value='<?php echo $formproc->SafeDisplay('sales') ?>' maxlength="50" /><br/>
    <span id='contactus_sales_errorloc' class='error'></span>
</div>
<div class='container'>
    <label for='license' >Attached Company Trade License (jpg,jpeg,gif,png,bmp):</label><br/>
    <input type="file" name='license' id='license' /><br/>
    <span id='contactus_license_errorloc' class='error'></span>
</div>
<div class='container'>
    <label for='passport' >Attached Owner's Passport Copy (jpg,jpeg,gif,png,bmp):</label><br/>
    <input type="file" name='passport' id='passport' /><br/>
    <span id='contactus_passport_errorloc' class='error'></span>
</div>
<div class='container'>
    <div><img alt='Captcha image' src='show-captcha.php?rand=1' id='scaptcha_img' /></div>
    <label for='scaptcha' >Enter the code above here:</label>
    <input type='text' name='scaptcha' id='scaptcha' maxlength="10" /><br/>
    <span id='contactus_scaptcha_errorloc' class='error'></span>
    <div class='short_explanation'>Can't read the image?
    <a href='javascript: refresh_captcha_img();'>Click here to refresh</a>.</div>
</div>


<div class='container'>
    <input type='submit' name='Submit' value='Submit' />
</div>

</fieldset>
</form>
<!-- client-side Form Validations:
Uses the excellent form validation script from JavaScript-coder.com-->

<script type='text/javascript'>
// <![CDATA[

    var frmvalidator  = new Validator("contactus");
    frmvalidator.EnableOnPageErrorDisplay();
    frmvalidator.EnableMsgsTogether();
    frmvalidator.addValidation("name","req","Please provide your name");
	
    frmvalidator.addValidation("company","req","Please provide your company name");


    frmvalidator.addValidation("email","req","Please provide your email address");

    frmvalidator.addValidation("email","email","Please provide a valid email address");
	
    frmvalidator.addValidation("tel","req","Please provide your telephone/mobile number");
	
    frmvalidator.addValidation("area","req","Please provide your area");

    frmvalidator.addValidation("projvalue","req","Please provide your project value");

    frmvalidator.addValidation("order","req","Please provide the date you will order");
	
    frmvalidator.addValidation("training","req","Please provide the date you are available for training");

    frmvalidator.addValidation("technical","req","Please provide the number of technical your company employ");

    frmvalidator.addValidation("sales","req","Please provide the number of sales your company employ");



   
    document.forms['contactus'].scaptcha.validator
      = new FG_CaptchaValidator(document.forms['contactus'].scaptcha,
                    document.images['scaptcha_img']);

    function SCaptcha_Validate()
    {
        return document.forms['contactus'].scaptcha.validator.validate();
    }

    frmvalidator.setAddnlValidationFunction("SCaptcha_Validate");

    function refresh_captcha_img()
    {
        var img = document.images['scaptcha_img'];
        img.src = img.src.substring(0,img.src.lastIndexOf("?")) + "?rand="+Math.random()*1000;
    }

// ]]>
</script>


</body>
</html>