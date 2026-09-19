<?
/***************************************************************************  
 *   copyright            : (C) 2007 PHPVersion.com 
 ***************************************************************************/ 

$vxg_root_path = "./../";
require($vxg_root_path . 'extension.inc');
include('header.' . $phpEx);

$tpl = new MiniTemplator;
$tpl->readTemplateFromFile($vxg_root_path."template/".$template."/admin/messages.tpl");

$tpl->setVariable ("phpEx",$phpEx);

$start = isset($_REQUEST['start']) ? intval($_REQUEST['start']) : 0;
$start = ($start < 0) ? 0 : $start;


$SQL = mysql_query ("SELECT * FROM ".$TABLE_PREFIX."posts WHERE validated = 1 ORDER BY pid DESC LIMIT ".$start.",".Get_Value("per_page")."") or die(mysql_error());
while ($row = mysql_fetch_array($SQL)) {

  if (Get_Value("gender") == 1) {
      if ($row['gender'] == "M") {
          $tpl->setVariable ("gender",$lang['aem_male']);
      }
      if ($row['gender'] == "F") {
          $tpl->setVariable ("gender",$lang['aem_female']);
      }
  }

  $tpl->setVariable ("poster",$row['poster']);

  if (Get_Value("age") == 1 && $row['age'] > 0) {
      $tpl->setVariable ("age","(".$row['age'].")");
  }

  if (Get_Value("poster_location") == 1 && $row['location'] != "") {
     
      $tpl->setVariable ("p_location",$row['location']);
      $tpl->setVariable ("location",$lang['location']);
      $tpl->addBlock ("blocation"); 
  }

  if (Get_Value("poster_mail") == 1 && $row['posteremail'] != "") {
      $tpl->setVariable ("posteremail",str_replace("@","@",$row['posteremail']));
      $tpl->setVariable ("email",$lang['aem_email']);
      $tpl->addBlock ("bpostermail"); 
  }

  if (Get_Value("homepage") == 1 && $row['homepage'] != "") {
      $tpl->setVariable ("p_homepage","http://" . $row['homepage']);
      $tpl->setVariable ("homepage",$lang['aem_homepage']);
      $tpl->addBlock ("bhomepage"); 
  }

  if (Get_Value("aim") == 1 && $row['aim'] != "") {
      $tpl->setVariable ("p_aim",$row['aim']);
      $tpl->setVariable ("aim",$lang['aem_aim']);
      $tpl->addBlock ("baim"); 
  }

  if (Get_Value("msn") == 1 && $row['msn'] != "") {
      $tpl->setVariable ("p_msn",$row['msn']);
      $tpl->setVariable ("msn",$lang['aem_msn']);
      $tpl->addBlock ("bmsn"); 
  }

  if (Get_Value("yim") == 1 && $row['yim'] != "") {
      $tpl->setVariable ("p_yim",$row['yim']);
      $tpl->setVariable ("yim",$lang['aem_yim']);
      $tpl->addBlock ("byim"); 
  }

  if (Get_Value("icq") == 1 && $row['icq'] > 10000) {
      $tpl->setVariable ("p_icq",$row['icq']);
      $tpl->setVariable ("icq",$lang['aem_icq']);
      $tpl->addBlock ("bicq"); 
  }

  if (Get_Value("c_field_1") == 1 && $row['c_field_1'] != "") {
      $tpl->setVariable ("p_c_field_1",$row['c_field_1']);
      $tpl->setVariable ("c_field_1",Get_Name_Value("c_field_1"));
      $tpl->addBlock ("bc_field_1"); 
  }

  if (Get_Value("c_field_2") == 1 && $row['c_field_2'] != "") {
      $tpl->setVariable ("p_c_field_2",$row['c_field_2']);
      $tpl->setVariable ("c_field_2",Get_Name_Value("c_field_2"));
      $tpl->addBlock ("bc_field_2"); 
  }

  if (Get_Value("c_field_3") == 1 && $row['c_field_3'] != "") {
      $tpl->setVariable ("p_c_field_3",$row['c_field_3']);
      $tpl->setVariable ("c_field_3",Get_Name_Value("c_field_3"));
      $tpl->addBlock ("bc_field_3"); 
  }

  if (Get_Value("c_field_4") == 1 && $row['c_field_4'] != "") {
      $tpl->setVariable ("p_c_field_4",$row['c_field_4']);
      $tpl->setVariable ("c_field_4",Get_Name_Value("c_field_4"));
      $tpl->addBlock ("bc_field_4"); 
  }

  if (Get_Value("c_field_5") == 1 && $row['c_field_5'] != "") {
      $tpl->setVariable ("p_c_field_5",$row['c_field_5']);
      $tpl->setVariable ("c_field_5",Get_Name_Value("c_field_5"));
      $tpl->addBlock ("bc_field_5"); 
  }

  $tpl->setVariable ("date",Get_Day($row['date'],$lang['today'],$lang['yesterday'],Get_Value("tzone")));
  $tpl->setVariable ("post_num",$lang['post_num']."".$row['pid']);
  $tpl->setVariable ("ip_addr",$lang['ip_addr'] . " " . $row['pip']);

  $text = nl2br(strip_tags($row['text'],Get_Value("allowed_tags")));
  $text = Get_Smilies ($text,"./../");
  $tpl->setVariable ("text",$text);
  $tpl->setVariable ("pid",$row['pid']);
  $tpl->setVariable ("aem_edit",$lang['aem_edit']);
  $tpl->setVariable ("aem_delete",$lang['aem_delete']);
  $tpl->addBlock ("messages"); 
}


// Pages Count
$SQL = mysql_query ("SELECT count(pid) AS total FROM ".$TABLE_PREFIX."posts WHERE validated = 1 ") or die(mysql_error());
$row = mysql_fetch_array($SQL);

$total_posts = $row['total'];
$ppp = Get_Value("per_page");

if ($total_posts > $ppp) {
      if ((($start/$ppp) - 2) >= 1)  {
         $tpl->setVariable ("first_page_link",$lang['first_page_link']);
  	 $tpl->addBlock ("FPL"); 
      }

      for ($i = ($start/$ppp) - 2; $i <= ($start/$ppp) + 2; $i++)  {
         if ($i*$ppp >= 0 && $i*$ppp < $total_posts) {
           if ($start == $i*$ppp) {
             $tpl->setVariable ("bold_page_link",$i);
  	     $tpl->addBlock ("BOLDPL"); 
           } else {
             $tpl->setVariable ("alink_page_link",$i*$ppp);
             $tpl->setVariable ("alink_page_number",$i);
  	     $tpl->addBlock ("ALINKPL"); 
           }
         }
  	 $tpl->addBlock ("CPL"); 
      }

      if (floor(($total_posts/$ppp)) > (($start/$ppp) + 2))  {
         $tpl->setVariable ("last_page_num",floor(floor($total_posts/$ppp))*$ppp);
         $tpl->setVariable ("last_page_link",$lang['last_page_link']);
  	 $tpl->addBlock ("LPL"); 
      }
}

$tpl->generateOutput();

include('footer.' . $phpEx);

?>