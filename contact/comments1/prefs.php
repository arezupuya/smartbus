<?php
//-----------------------------------------------------------------------------
// BellaBook Copyright © Jem Turner 2004-2007,2008 unless otherwise noted
// http://www.jemjabella.co.uk/
//
// This program is free software; you can redistribute it and/or modify
// it under the terms of the GNU General Public License. See README.txt
// or LICENSE.txt for more information.
//-----------------------------------------------------------------------------


$title = "My BellaBook Guestbook"; // set your guestbook title here

$admin_name	= "annklein";   // admin username
$admin_pass	= "annkl3in";   // admin password
$admin_email = "annarussel@gmail.com";   // admin e-mail address
$admin_url = "http://smarthomebus.com";   // your website url - used in guestbook footer
$admin_gburl = "http://smarthomebus.com/comments1";   // your guestbook url - used in the sign notification emails
$admin_sitename = "Comments Page";   // your website name - used in guestbook footer
$secret = "russ3l";    // this is like a second password. you won't have to remember it, so make it long and random

$dateformat	= "d M y h:ia";   // date format, more details: php.net/date
$stylecolor	= "bigblue";   // bellabook theme (download more from jemjabella.co.uk/scripts)

$showemail = "no";   // show email addresses in guestbook - write yes or no
$emailentries = "no";   // email new entries - write yes or no ($admin_email must be filled in, above)

$emailrequired = "yes";   // make email field required - write yes or no
$perpage = "15";   // Pagination - amount of entries per page. 
$smilies = "yes";   // convert text smilies like :) to images? - write yes or no

// spam protection options
$captcha = "yes";   // captcha on? - write yes or no
$moderate = "yes";   // new entries have to be approved first - write yes or no
$floodcontrol = "nyes";   // allow flood control? - write yes or no
$allowlinks = "no";   // allow urls in comment; choosing no cuts down on spam


?>