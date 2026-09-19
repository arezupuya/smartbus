<?
/***************************************************************************  
 *   copyright            : (C) 2007 PHPVersion.com 
 ***************************************************************************/ 

$vxg_root_path = "./../";
require($vxg_root_path . 'extension.inc');
include('header.' . $phpEx);

$tpl = new MiniTemplator;
$tpl->readTemplateFromFile($vxg_root_path."template/".$template."/admin/editmessage.tpl");
$tpl->setVariable ("phpEx",$phpEx);

$ERROR = "";

if ($_POST['del_message']) {
      mysql_query ("DELETE FROM ".$TABLE_PREFIX."posts WHERE pid = " . $_POST['pid']) or die(mysql_error());
      $tpl->setVariable ("edit_other_messages",$lang['aem_edit_other_messages']);
      $tpl->setVariable ("MESSAGE",$lang['aem_deleted_message']);
      $tpl->setVariable ("back_refer",$_POST['refer']);
}

if ($_POST['update_message']) {

      $poster_name = Get_Clean_Value(($_POST['poster_name']));
      if(empty($ERROR) && (empty($poster_name) || strlen($poster_name) < 3)) {
      	$ERROR = $lang['add_error_name'];
      }

      $poster_mail = Get_Clean_Value(($_POST['poster_mail']));
      if(empty($ERROR) && Get_Req_Value("poster_mail") == 1) {
        if (!eregi("^[0-9a-z]([-_.]?[0-9a-z])*@[0-9a-z]([-.]?[0-9a-z])*\\.[a-z]{2,3}$",$poster_mail) || empty($poster_mail)) { 
	  $ERROR = $lang['add_error_mail']; 
        }
      }

      $poster_location = Get_Clean_Value(($_POST['poster_location']));
      if(empty($ERROR) && Get_Req_Value("poster_location") == 1) {
        if (empty($poster_location) || strlen($poster_location) < 3) { 
	  $ERROR = $lang['add_error_location']; 
        }
      }

      $msn = Get_Clean_Value(($_POST['msn']));
      if(empty($ERROR) && Get_Req_Value("msn") == 1) {
        if (!eregi("^[0-9a-z]([-_.]?[0-9a-z])*@[0-9a-z]([-.]?[0-9a-z])*\\.[a-z]{2,3}$",$msn) || empty($msn)) { 
	  $ERROR = $lang['add_error_msn']; 
        }
      }

      $aim = Get_Clean_Value(($_POST['aim']));
      if(empty($ERROR) && Get_Req_Value("aim") == 1) {
        if (empty($aim)) { 
	  $ERROR = $lang['add_error_aim']; 
        }
      }

      $yim = Get_Clean_Value(($_POST['yim']));
      if(empty($ERROR) && Get_Req_Value("yim") == 1) {
        if (empty($yim)) { 
	  $ERROR = $lang['add_error_yim']; 
        }
      }

      $icq = intval(Get_Clean_Value(($_POST['icq'])));
      if(empty($ERROR) && Get_Req_Value("icq") == 1) {
        if (empty($icq) || ($icq < 10000 || $icq > 999999999)) { 
	  $ERROR = $lang['add_error_icq']; 
        }
      }

      $homepage = str_replace("http://","",Get_Clean_Value(($_POST['homepage'])));
      if(empty($ERROR) && Get_Req_Value("homepage") == 1) {
        if (empty($homepage) || strlen($homepage) < 3) { 
	  $ERROR = $lang['add_error_homepage']; 
        }
      }

      $gender = Get_Clean_Value(($_POST['gender']));
      if(empty($ERROR) && Get_Req_Value("gender") == 1) {
        if (empty($gender) || ($gender != "M" && $gender != "F")) { 
	  $ERROR = $lang['add_error_gender']; 
        }
      }

      $age = intval(Get_Clean_Value(($_POST['age'])));
      if(empty($ERROR) && Get_Req_Value("age") == 1) {
        if (empty($age) || $age == 0) { 
	  $ERROR = $lang['add_error_age']; 
        }
      }

      $c_field_1 = Get_Clean_Value(($_POST['c_field_1']));
      if(empty($ERROR) && Get_Req_Value("c_field_1") == 1) {
        if (empty($c_field_1)) { 
	  $ERROR = $lang['add_error_cfield'] . " " . Get_Name_Value("c_field_1"); 
        }
      }

      $c_field_2 = Get_Clean_Value(($_POST['c_field_2']));
      if(empty($ERROR) && Get_Req_Value("c_field_2") == 1) {
        if (empty($c_field_2)) { 
	  $ERROR = $lang['add_error_cfield'] . " " . Get_Name_Value("c_field_2"); 
        }
      }

      $c_field_3 = Get_Clean_Value(($_POST['c_field_3']));
      if(empty($ERROR) && Get_Req_Value("c_field_3") == 1) {
        if (empty($c_field_3)) { 
	  $ERROR = $lang['add_error_cfield'] . " " . Get_Name_Value("c_field_3"); 
        }
      }

      $c_field_4 = Get_Clean_Value(($_POST['c_field_4']));
      if(empty($ERROR) && Get_Req_Value("c_field_4") == 1) {
        if (empty($c_field_4)) { 
	  $ERROR = $lang['add_error_cfield'] . " " . Get_Name_Value("c_field_4"); 
        }
      }

      $c_field_5 = Get_Clean_Value(($_POST['c_field_5']));
      if(empty($ERROR) && Get_Req_Value("c_field_5") == 1) {
        if (empty($c_field_5)) { 
	  $ERROR = $lang['add_error_cfield'] . " " . Get_Name_Value("c_field_5"); 
        }
      }

      // ********************************************************************
      // *********            Clean Message Text Block              *********
      // ********************************************************************

      if (empty($ERROR) && (Get_Value("allow_html") == 1)) {
        $message = strip_tags($_POST['message'],Get_Value("allowed_tags"));
      } else {
        $message = $_POST['message'];
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


      if ($ERROR) {
        $tpl->setVariable ("MESSAGE",$ERROR);
      } else {
        $message = get_quotes($message);

	mysql_query ("UPDATE ".$TABLE_PREFIX."posts 
		SET 
		text = '" . $message ."',
		poster = '" . $poster_name . "',
		location = '" . $poster_location . "',
		posteremail = '" . $poster_mail . "',
		msn = '" . $msn . "',
		aim = '" . $aim . "',
		yim = '" . $yim . "',
		homepage = '" . $homepage . "',
		icq = '" . $icq . "',
		gender = '" . $gender . "',
		age = '" . $age . "',
		validated = 1,
		c_field_1 = '" . $c_field_1 . "',
		c_field_2 = '" . $c_field_2 . "',
		c_field_3 = '" . $c_field_3 . "',
		c_field_4 = '" . $c_field_4 . "',
		c_field_5 = '" . $c_field_1 . "'
		WHERE pid = " . $_POST['pid'] . "
		") or die (mysql_error());

                $tpl->setVariable ("MESSAGE",$lang['aem_updated_message']);
                $tpl->setVariable ("edit_other_messages",$lang['aem_edit_other_messages']);
                $tpl->setVariable ("back_refer",$_POST['refer']);

      }	

}


$SQL = mysql_query ("SELECT * FROM ".$TABLE_PREFIX."posts WHERE pid = ".$_REQUEST['pid']);
$row = mysql_fetch_array ($SQL);

$tpl->setVariable ("add_name",$lang['add_name']);
$tpl->setVariable ("poster_name",$row['poster']);

$tpl->setVariable ("add_mail",$lang['add_mail']);
$tpl->setVariable ("poster_mail",$row['posteremail']);

$tpl->setVariable ("add_location",$lang['add_location']);
$tpl->setVariable ("poster_location",$row['location']);

$tpl->setVariable ("add_msn",$lang['add_msn']);
$tpl->setVariable ("msn",$row['msn']);

$tpl->setVariable ("add_aim",$lang['add_aim']);
$tpl->setVariable ("aim",$row['aim']);

$tpl->setVariable ("add_yim",$lang['add_yim']);
$tpl->setVariable ("yim",$row['yim']);

$tpl->setVariable ("add_icq",$lang['add_icq']);
$tpl->setVariable ("icq",$row['icq']);

$tpl->setVariable ("add_homepage",$lang['add_homepage']);
$tpl->setVariable ("homepage",$row['homepage']);

$tpl->setVariable ("add_gender",$lang['add_gender']);
$tpl->setVariable ("add_gender_male",$lang['add_gender_male']);
$tpl->setVariable ("add_gender_female",$lang['add_gender_female']);
if ($row['gender'] == "M") {
 $tpl->setVariable ("gender_m_selected","SELECTED");
} else {
 $tpl->setVariable ("gender_f_selected","SELECTED");
}

$tpl->setVariable ("add_age",$lang['add_age']);
$tpl->setVariable ("age",$row['age']);

$tpl->setVariable ("c_field_1",Get_Name_Value("c_field_1"));
$tpl->setVariable ("c_field_1v",$row['c_field_1']);

$tpl->setVariable ("c_field_2",Get_Name_Value("c_field_2"));
$tpl->setVariable ("c_field_2v",$row['c_field_2']);

$tpl->setVariable ("c_field_3",Get_Name_Value("c_field_3"));
$tpl->setVariable ("c_field_3v",$row['c_field_3']);

$tpl->setVariable ("c_field_4",Get_Name_Value("c_field_4"));
$tpl->setVariable ("c_field_4v",$row['c_field_4']);

$tpl->setVariable ("c_field_5",Get_Name_Value("c_field_5"));
$tpl->setVariable ("c_field_5v",$row['c_field_5']);

$tpl->setVariable ("add_message_text",$lang['add_message_text']);

if (Get_Value("allow_html") == 1) {
      $tpl->setVariable ("add_html",$lang['add_html']);
      $tpl->setVariable ("allow_html",$lang['yes']);
      $tpl->setVariable ("add_html_tags",$lang['add_html_tags']);
      $tpl->setVariable ("allowed_tags",htmlspecialchars(Get_Value("allowed_tags")));
} else {
      $tpl->setVariable ("add_html",$lang['add_html']);
      $tpl->setVariable ("allow_html",$lang['no']);
}

$tpl->setVariable ("message_text",$row['text']);
$tpl->setVariable ("pid",$row['pid']);

$SQL = mysql_query ("SELECT * FROM " . $TABLE_PREFIX . "smilies");
while ($row = mysql_fetch_array($SQL)) {
      $tpl->setVariable ("add_emoticon","<a href=\"javascript:emoticon('" . $row['code'] . "')\"><img src=\"./../images/smilies/" . $row['smile_url'] . "\" border=\"0\" alt=\"" . $row['emoticon'] . "\" title=\"" . $row['emoticon'] . "\" /></a>");
      $tpl->addBlock ("add_bemoticons"); 
}

$tpl->setVariable ("aem_update_message",$lang['aem_update_message']);
$tpl->setVariable ("aem_del_message",$lang['aem_del_message']);
$tpl->setVariable ("refer",$_SERVER['HTTP_REFERER']);

$tpl->generateOutput();

include('footer.' . $phpEx);

?>