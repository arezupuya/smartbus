<?php

// Change the Email Addresses below to email Id where you want to get your emails.
// Reply Email Address where you want to set reply to email ID

$replyto='sandra@smart-hdl.com, sweet@smart-hdl.com';

$uploadpath='/uploads/';

$save_path ='http://'.$_SERVER['SERVER_NAME'].$uploadpath;  // do not change this

switch ($subject) {
case "Sales Department": // appears as subject in mail and select field name 1 in form
$toemail='firas@smart-hdl.com'; // select field email 1

break;

case "Technical Deparment": // appears as subject in mail and select field name 3 in form
$toemail='firas@smart-hdl.com'; // select field email 2

break;

case "Billing Department": // appears as subject in mail and select field name 3 in form
$toemail='firas@smart-hdl.com'; // select field email 3

break;
}

$autorespond="no"; // no : Disable the Auto-Responder   yes : Enable Auto-Responder.

?>
