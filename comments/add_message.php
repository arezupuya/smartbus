<?
/***************************************************************************  
 *   copyright            : (C) 2007 PHPVersion.com 
 ***************************************************************************/ 

$vxg_root_path = "./";
require($vxg_root_path . 'extension.inc');
include('header.' . $phpEx);

$tpl = new MiniTemplator;
$tpl->readTemplateFromFile($vxg_root_path."template/".$template."/add_message.tpl");
$tpl->setVariable ("phpEx",$phpEx);

$ERROR = "";
$REQFS = "*";


if ($_POST['addmessage']) {
      $poster_name = Get_Clean_Value(($_POST['poster_name']));
      if(empty($ERROR) && (empty($poster_name) || strlen($poster_name) < 3)) {
      	$ERROR = $lang['add_error_name'];
      }

      $poster_mail = Get_Clean_Value(($_POST['poster_mail']));
      if(empty($ERROR) && (Get_Req_Value("poster_mail") == 1 || !empty($poster_mail))) {
        if (!eregi("^[0-9a-z]([-_.]?[0-9a-z])*@[0-9a-z]([-.]?[0-9a-z])*\\.[a-z]{2,3}$",$poster_mail) || empty($poster_mail)) { 
	  $ERROR = $lang['add_error_mail']; 
        }
      }

      $poster_location = Get_Clean_Value(($_POST['poster_location']));
      if(empty($ERROR) && (Get_Req_Value("poster_location") == 1 || !empty($poster_location))) {
        if (empty($poster_location) || strlen($poster_location) < 3) { 
	  $ERROR = $lang['add_error_location']; 
        }
      }

      $msn = Get_Clean_Value(($_POST['msn']));
      if(empty($ERROR) && (Get_Req_Value("msn") == 1 || !empty($msn))) {
        if (!eregi("^[0-9a-z]([-_.]?[0-9a-z])*@[0-9a-z]([-.]?[0-9a-z])*\\.[a-z]{2,3}$",$msn) || empty($msn)) { 
	  $ERROR = $lang['add_error_msn']; 
        }
      }

      $aim = Get_Clean_Value(($_POST['aim']));
      if(empty($ERROR) && (Get_Req_Value("aim") == 1 || !empty($aim))) {
        if (empty($aim)) { 
	  $ERROR = $lang['add_error_aim']; 
        }
      }

      $yim = Get_Clean_Value(($_POST['yim']));
      if(empty($ERROR) && (Get_Req_Value("yim") == 1 || !empty($yim))) {
        if (empty($yim)) { 
	  $ERROR = $lang['add_error_yim']; 
        }
      }

      $icq = intval(Get_Clean_Value(($_POST['icq'])));
      if(empty($ERROR) && (Get_Req_Value("icq") == 1 || !empty($icq))) {
        if (empty($icq) || ($icq < 10000 || $icq > 999999999)) { 
	  $ERROR = $lang['add_error_icq']; 
        }
      }

      $homepage = str_replace("http://","",Get_Clean_Value(($_POST['homepage'])));
      if(empty($ERROR) && (Get_Req_Value("homepage") == 1 || !empty($homepage))) {
        if (empty($homepage) || strlen($homepage) < 3) { 
	  $ERROR = $lang['add_error_homepage']; 
        }
      }

      $gender = Get_Clean_Value(($_POST['gender']));
      if(empty($ERROR) && (Get_Req_Value("gender") == 1 || !empty($gender))) {
        if (empty($gender) || ($gender != "M" && $gender != "F")) { 
	  $ERROR = $lang['add_error_gender']; 
        }
      }

      $age = intval(Get_Clean_Value(($_POST['age'])));
      if(empty($ERROR) && (Get_Req_Value("age") == 1 || !empty($age))) {
        if (empty($age) || $age == 0 || $age > 100) { 
	  $ERROR = $lang['add_error_age']; 
        }
      }

      $c_field_1 = Get_Clean_Value(($_POST['c_field_1']));
      if(empty($ERROR) && (Get_Req_Value("c_field_1") == 1 || !empty($c_field_1))) {
        if (empty($c_field_1)) { 
	  $ERROR = $lang['add_error_cfield'] . " " . Get_Name_Value("c_field_1"); 
        }
      }

      $c_field_2 = Get_Clean_Value(($_POST['c_field_2']));
      if(empty($ERROR) && (Get_Req_Value("c_field_2") == 1 || !empty($c_field_2))) {
        if (empty($c_field_2)) { 
	  $ERROR = $lang['add_error_cfield'] . " " . Get_Name_Value("c_field_2"); 
        }
      }

      $c_field_3 = Get_Clean_Value(($_POST['c_field_3']));
      if(empty($ERROR) && (Get_Req_Value("c_field_3") == 1 || !empty($c_field_3))) {
        if (empty($c_field_3)) { 
	  $ERROR = $lang['add_error_cfield'] . " " . Get_Name_Value("c_field_3"); 
        }
      }

      $c_field_4 = Get_Clean_Value(($_POST['c_field_4']));
      if(empty($ERROR) && (Get_Req_Value("c_field_4") == 1 || !empty($c_field_4))) {
        if (empty($c_field_4)) { 
	  $ERROR = $lang['add_error_cfield'] . " " . Get_Name_Value("c_field_4"); 
        }
      }

      $c_field_5 = Get_Clean_Value(($_POST['c_field_5']));
      if(empty($ERROR) && (Get_Req_Value("c_field_5") == 1 || !empty($c_field_5))) {
        if (empty($c_field_5)) { 
	  $ERROR = $lang['add_error_cfield'] . " " . Get_Name_Value("c_field_5"); 
        }
      }

      $captcha = quote_smart(Get_Clean_Value(($_POST['captcha'])));
      if (empty($ERROR) && Get_Value("captcha") == 1) {
        $tstamp = intval($_POST['tstamp']);
        $SQL = mysql_query("SELECT sval FROM ".$TABLE_PREFIX."sessions WHERE stime='".$tstamp."' AND sname='key' AND sval='".$captcha."'");
        if (mysql_num_rows($SQL) < 1) {
          $ERROR = $lang['add_error_captcha'];
        }
      }

      // ********************************************************************
      // *********            Clean Message Text Block              *********
      // ********************************************************************

      if (empty($ERROR) && (Get_Value("allow_html") == 1)) {
        $message = strip_tags($_POST['message'],Get_Value("allowed_tags"));
      } else {
        $message = strip_tags($_POST['message']);
      }

      if (empty($ERROR) && (strlen($message) < Get_Value("min_len"))) {
        $ERROR = $lang['add_error_short'];
      }
      if (empty($ERROR) && (strlen($message) > Get_Value("max_len"))) {
        $ERROR = $lang['add_error_long'];
      }

      if (empty($ERROR) && (wordwrap_check($message,Get_Value("max_word_lenght"))) == 1) {
        $ERROR = $lang['add_error_lwords'];
      }

      if (empty($ERROR) && (Get_Value("word_censor") == 1)) {
        if (word_censor_check($message)) {
          $ERROR = $lang['add_error_censored'] . " " . word_censor_check($message);
        }
      }

      if (empty($ERROR) && bannedip_check($_SERVER['REMOTE_ADDR'])) {
        $ERROR = $lang['add_error_bannedip'] . " " . bannedip_check($_SERVER['REMOTE_ADDR']);
      }

      if (empty($ERROR) && !empty($poster_mail)) {
	if (bannedmail_check($poster_mail)) {
          $ERROR = $lang['add_error_bannedmail'] . " " . bannedmail_check($poster_mail);
        }
      }


      // ********************************************************************
      // *********              Flood Control Block                 *********
      // ********************************************************************
      if (empty($ERROR) && flood_check($_SERVER['REMOTE_ADDR'])) {
          $ERROR = $lang['add_error_flood'];
      }


      if ($ERROR) {
        $tpl->setVariable ("MESSAGE",$ERROR);
      } else {
        $message = get_quotes($message);
        $admin_validation = Get_Value ("admin_valid");
        if ($admin_validation != 0) {
          $validated = 0;
        } else {
	  $validated = 1;
	}

	mysql_query ("INSERT INTO ".$TABLE_PREFIX."posts 
		(date,
		text,
		poster,
		location,
		posteremail,
		msn,
		aim,
		yim,
		homepage,
		icq,
		useragent,
		gender,
		age,
		validated,
		c_field_1,
		c_field_2,
		c_field_3,
		c_field_4,
		c_field_5,
		pip) VALUES (
		" . time() . ",
		'" . $message . "',
		'" . $poster_name . "',
		'" . $poster_location . "',
		'" . $poster_mail . "',
		'" . $msn . "',
		'" . $aim . "',
		'" . $yim . "',
		'" . $homepage . "',
		" . $icq . ",
		'" . $_SERVER['HTTP_USER_AGENT'] . "',
		'" . $gender . "',
		" . $age . ",
		" . $validated . ",
		'" . $c_field_1 . "',
		'" . $c_field_2 . "',
		'" . $c_field_3 . "',
		'" . $c_field_4 . "',
		'" . $c_field_5 . "',
		'" . $_SERVER['REMOTE_ADDR'] . "'
		)") or die (mysql_error());

                $tpl->setVariable ("MESSAGE",$lang['add_noerror']);

		if (Get_Value("enot") == 1) {
			$headers = 'From: ' . Get_Value("admin_mail") . "\r\n" .
    			'Reply-To: ' . Get_Value("admin_mail") . "\r\n" .
    			'X-Mailer: PHP/ Free PHP VX Guestbook';
			mail(Get_Value("admin_mail"), $lang['add_mail_subj'], $lang['add_mail_msg'] , $headers);
		}
      }	

}


$tpl->setVariable ("view_guestbook",$lang['view_guestbook']);
$tpl->setVariable ("add_message",$lang['add_message']);
$tpl->setVariable ("add_name",$lang['add_name']);
$tpl->setVariable ("vposter_name",$_REQUEST['poster_name']);

if (Get_Value("poster_mail") == 1) {
      if (Get_Req_Value("poster_mail") == 1) { $rs = $REQFS; } else { $rs = ""; } 
      $tpl->setVariable ("add_mail",$rs." ".$lang['add_mail']);
      $tpl->setVariable ("vposter_mail",$_REQUEST['poster_mail']);
      $tpl->addBlock ("add_bemail"); 
}

if (Get_Value("poster_location") == 1) {
      if (Get_Req_Value("poster_location") == 1) { $rs = $REQFS; } else { $rs = ""; } 
      $tpl->setVariable ("add_location",$rs." ".$lang['add_location']);
      $tpl->setVariable ("vposter_location",$_REQUEST['poster_location']);
      $tpl->addBlock ("add_blocation"); 
}

if (Get_Value("msn") == 1) {
      if (Get_Req_Value("msn") == 1) { $rs = $REQFS; } else { $rs = ""; } 
      $tpl->setVariable ("add_msn",$rs." ".$lang['add_msn']);
      $tpl->setVariable ("vmsn",$_REQUEST['msn']);
      $tpl->addBlock ("add_bmsn"); 
}

if (Get_Value("aim") == 1) {
      if (Get_Req_Value("aim") == 1) { $rs = $REQFS; } else { $rs = ""; } 
      $tpl->setVariable ("add_aim",$rs." ".$lang['add_aim']);
      $tpl->setVariable ("vaim",$_REQUEST['aim']);
      $tpl->addBlock ("add_baim"); 
}

if (Get_Value("yim") == 1) {
      if (Get_Req_Value("yim") == 1) { $rs = $REQFS; } else { $rs = ""; } 
      $tpl->setVariable ("add_yim",$rs." ".$lang['add_yim']);
      $tpl->setVariable ("vyim",$_REQUEST['yim']);
      $tpl->addBlock ("add_byim"); 
}

if (Get_Value("icq") == 1) {
      if (Get_Req_Value("icq") == 1) { $rs = $REQFS; } else { $rs = ""; } 
      $tpl->setVariable ("add_icq",$rs." ".$lang['add_icq']);
      $tpl->setVariable ("vicq",$_REQUEST['icq']);
      $tpl->addBlock ("add_bicq"); 
}

if (Get_Value("homepage") == 1) {
      if (Get_Req_Value("homepage") == 1) { $rs = $REQFS; } else { $rs = ""; } 
      $tpl->setVariable ("add_homepage",$rs." ".$lang['add_homepage']);
      $tpl->setVariable ("vhomepage",$_REQUEST['homepage']);
      $tpl->addBlock ("add_bhomepage"); 
}

if (Get_Value("gender") == 1) {
      if (Get_Req_Value("gender") == 1) { $rs = $REQFS; } else { $rs = ""; } 
      $tpl->setVariable ("add_gender",$rs." ".$lang['add_gender']);
      $tpl->setVariable ("add_gender_male",$lang['add_gender_male']);
      $tpl->setVariable ("add_gender_female",$lang['add_gender_female']);
      if ($_POST['gender'] == "M") { 
	$tpl->setVariable ("vmgender","SELECTED") ; 
	$tpl->setVariable ("vfgender","") ; 
      }
      if ($_POST['gender'] == "F") { 
	$tpl->setVariable ("vfgender","SELECTED") ; 
	$tpl->setVariable ("vmgender","") ; 
      }
      $tpl->addBlock ("add_bgender"); 
}

if (Get_Value("age") == 1) {
      if (Get_Req_Value("age") == 1) { $rs = $REQFS; } else { $rs = ""; } 
      $tpl->setVariable ("add_age",$rs." ".$lang['add_age']);
      $tpl->setVariable ("vage",$_REQUEST['age']);
      $tpl->addBlock ("add_bage"); 
}

if (Get_Value("c_field_1") == 1) {
      if (Get_Req_Value("c_field_1") == 1) { $rs = $REQFS; } else { $rs = ""; } 
      $tpl->setVariable ("c_field_1",$rs." ".Get_Name_Value("c_field_1"));
      $tpl->setVariable ("vc_field_1",$_REQUEST['c_field_1']);
      $tpl->addBlock ("add_bc_field_1"); 
}

if (Get_Value("c_field_2") == 1) {
      if (Get_Req_Value("c_field_2") == 1) { $rs = $REQFS; } else { $rs = ""; } 
      $tpl->setVariable ("c_field_2",$rs." ".Get_Name_Value("c_field_2"));
      $tpl->setVariable ("vc_field_2",$_REQUEST['c_field_2']);
      $tpl->addBlock ("add_bc_field_2"); 
}

if (Get_Value("c_field_3") == 1) {
      if (Get_Req_Value("c_field_3") == 1) { $rs = $REQFS; } else { $rs = ""; } 
      $tpl->setVariable ("c_field_3",$rs." ".Get_Name_Value("c_field_3"));
      $tpl->setVariable ("vc_field_3",$_REQUEST['c_field_3']);
      $tpl->addBlock ("add_bc_field_3"); 
}

if (Get_Value("c_field_4") == 1) {
      if (Get_Req_Value("c_field_4") == 1) { $rs = $REQFS; } else { $rs = ""; } 
      $tpl->setVariable ("c_field_4",$rs." ".Get_Name_Value("c_field_4"));
      $tpl->setVariable ("vc_field_4",$_REQUEST['c_field_4']);
      $tpl->addBlock ("add_bc_field_4"); 
}

if (Get_Value("c_field_5") == 1) {
      if (Get_Req_Value("c_field_5") == 1) { $rs = $REQFS; } else { $rs = ""; } 
      $tpl->setVariable ("c_field_5",$rs." ".Get_Name_Value("c_field_5"));
      $tpl->setVariable ("vc_field_5",$_REQUEST['c_field_5']);
      $tpl->addBlock ("add_bc_field_5"); 
}

if (Get_Value("captcha") == 1) {
      // Generate random text
      $Key = Make_Text();
      $tstamp = time();
      // Delete old keys from sessions table (15 mins)
      mysql_query("DELETE FROM ".$TABLE_PREFIX."sessions WHERE stime < '".(time()-900)."' AND sname='key'");
      // Insert New Key to sessions table for current session
      mysql_query("INSERT INTO ".$TABLE_PREFIX."sessions (ip,stime,sname,sval) VALUES ('".$_SERVER['REMOTE_ADDR']."','".$tstamp."','key','".$Key."')");

      $tpl->setVariable ("captcha",$lang['add_captcha']);
      $tpl->setVariable ("tstamp",$tstamp);
      $tpl->setVariable ("md5tstamp",md5($tstamp));
      $tpl->setVariable ("key",md5($Key));
      $tpl->addBlock ("add_bcaptcha"); 
}

$tpl->setVariable ("add_message_text",$lang['add_message_text']);

if (Get_Value("allow_html") == 1) {
      $tpl->setVariable ("add_html",$lang['add_html']);
      $tpl->setVariable ("allow_html",$lang['yes']);
      $tpl->setVariable ("add_html_tags",$lang['add_html_tags']);
      $tpl->setVariable ("allowed_tags",htmlspecialchars(Get_Value("allowed_tags")));
      $tpl->addBlock ("add_bhtml"); 
} else {
      $tpl->setVariable ("add_html",$lang['add_html']);
      $tpl->setVariable ("allow_html",$lang['no']);
      $tpl->addBlock ("add_bhtml"); 
}

$SQL = mysql_query ("SELECT * FROM " . $TABLE_PREFIX . "smilies");
while ($row = mysql_fetch_array($SQL)) {
      $tpl->setVariable ("add_emoticon","<a href=\"javascript:emoticon('" . $row['code'] . "')\"><img src=\"images/smilies/" . $row['smile_url'] . "\" border=\"0\" alt=\"" . $row['emoticon'] . "\" title=\"" . $row['emoticon'] . "\" /></a>");
      $tpl->addBlock ("add_bemoticons"); 
}

$tpl->setVariable ("vmessage",$_REQUEST['message']);

$tpl->setVariable ("REQFS",$REQFS." ");
$tpl->setVariable ("add_req",$lang['add_req']);

$tpl->generateOutput();

include('footer.' . $phpEx);

?>