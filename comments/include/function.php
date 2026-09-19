<?
/***************************************************************************  
 *   copyright            : (C) 2007 PHPVersion.com 
 ***************************************************************************/ 

function auth_check ($admin_name,$admin_pass) {
  if (($admin_name == Get_Value("admin_name")) && ($admin_pass == Get_Value("admin_pass"))) {
    return ("true");
  } else {
    return ("false");
  }
}

function get_quotes ($var) {
  if (!get_magic_quotes_gpc()) {
    return(addslashes($var));
  } else {
    return($var);
  }
}

function quote_smart($var)
{
    if (get_magic_quotes_gpc()) {
        $var = stripslashes($var);
    }
    if (!is_numeric($var)) {
        $var = mysql_real_escape_string($var);
    }
    return $var;
}

function Get_Clean_Value($val) {
    $val = get_quotes(strip_tags($val));
    return($val);
}

function Get_Value ($var) {
  Global $db;
  Global $TABLE_PREFIX;

  $SQL = mysql_query("SELECT value FROM ".$TABLE_PREFIX."config WHERE variable = '".$var."'") or die(mysql_error());
  $row = mysql_fetch_array($SQL);

  return($row['value']);
}

function Get_Req_Value ($var) {
  Global $db;
  Global $TABLE_PREFIX;

  $SQL = mysql_query("SELECT req FROM ".$TABLE_PREFIX."config WHERE variable = '".$var."'") or die(mysql_error());
  $row = mysql_fetch_array($SQL);

  return($row['req']);
}

function Get_Name_Value ($var) {
  Global $db;
  Global $TABLE_PREFIX;

  $SQL = mysql_query("SELECT name FROM ".$TABLE_PREFIX."config WHERE variable = '".$var."'") or die(mysql_error());
  $row = mysql_fetch_array($SQL);

  return($row['name']);
}

function Get_Checked_Value ($var,$field) {
  Global $db;
  Global $TABLE_PREFIX;

  $SQL = mysql_query("SELECT ".$field." FROM ".$TABLE_PREFIX."config WHERE variable = '".$var."'") or die(mysql_error());
  $row = mysql_fetch_array($SQL);

  if ($row[$field] == 1) { return ("CHECKED");}
  else { return(""); };
}

function Put_Value ($var,$val) {
  Global $db;
  Global $TABLE_PREFIX;

  mysql_query("UPDATE ".$TABLE_PREFIX."config SET value='".$val."' WHERE variable = '".$var."'") or die(mysql_error());
}

function Put_Name_Value ($var,$val) {
  Global $db;
  Global $TABLE_PREFIX;

  mysql_query("UPDATE ".$TABLE_PREFIX."config SET name='".$val."' WHERE variable = '".$var."'") or die(mysql_error());
}

function Put_If_Value ($var,$val,$rval) {

  if (isset($val)) {
     Put_Value($var,1);
  } else {
     Put_Value($var,0);
  }

  if (isset($rval)) {
     Put_Req_Value($var,1);
  } else {
     Put_Req_Value($var,0);
  }

}

function Put_Req_Value ($var,$val) {
  Global $db;
  Global $TABLE_PREFIX;

  mysql_query("UPDATE ".$TABLE_PREFIX."config SET req='".$val."' WHERE variable = '".$var."'") or die(mysql_error());
}

function Get_Vchar_Value ($var,$on,$off) {
  if ($var == 1) {return($on);}
  else {return($off);}
}

function Get_Selected ($var,$compare) {
  if(Get_Value($var) == $compare) {return("SELECTED");}
}

function Get_Day ($day,$today,$yesterday,$tzone) {
  Global $date_format;
  Global $time_format;

  $d = gmdate ($date_format,$day + ( $tzone * 3600 ) );
  if (gmdate('jnY',time() + ( $tzone * 3600 )) == gmdate('jnY',$day + ( $tzone * 3600 ))) { $d = $today; }
  if (gmdate('jnY',time() + (( $tzone * 3600 ) - 86400)) == gmdate('jnY',$day + ( $tzone * 3600 ))) { $d = $yesterday; }
  $d.= gmdate(' '.$time_format,$day + ( $tzone * 3600 ));
  return($d);
}

function Get_Smilies ($text,$path) {

  Global $db;
  Global $TABLE_PREFIX;

  $SQL = mysql_query("SELECT * FROM ".$TABLE_PREFIX."smilies") or die(mysql_error());
  while ($row = mysql_fetch_array($SQL)) {
    $text = str_replace($row['code'],"<img src=' " . $path . "images/smilies/".$row['smile_url']."' alt='".$row['emoticon']."' title='".$row['emoticon']."'>",$text);
  }
  return($text);
}

function Put_Users_Online ($deltime) {
  Global $db;
  Global $TABLE_PREFIX;
  mysql_query("DELETE FROM ".$TABLE_PREFIX."sessions WHERE stime < ".(time() - $deltime));
  mysql_query("INSERT INTO ".$TABLE_PREFIX."sessions (ip,stime,sname) VALUES ('".$_SERVER['REMOTE_ADDR']."',".time().",'online')") or die(mysql_error());
}

function Get_Users_Online () {
  Global $db;
  Global $TABLE_PREFIX;
  $SQL = mysql_query("SELECT ip FROM ".$TABLE_PREFIX."sessions WHERE sname='online' GROUP BY ip") or die(mysql_error());
  $row = mysql_num_rows($SQL);
  if ($row > 1) {
    return ($row);
  } else {
    return ($row);
  }
}

function Check_Most_Online () {
  Global $db;
  Global $TABLE_PREFIX;

  $max_vo = Get_Value("max_visitors_online");
  $cur_vo = Get_Users_Online();

  if ($cur_vo > $max_vo) {
     Put_Value("max_visitors_online",$cur_vo);
     Put_Name_Value("max_visitors_online",time());
  }
}

function Make_Text() {
  $_char = array (1 => "A","B","C","D","E","F","G","H","J","K","L","M","N","P","Q","R","S","T","U","V","W","X","Y","Z","2","3","4","5","6","7","8","9");
  $vc = "";
  for ($i=1;$i<=4;$i++) {
    $randval = rand(1,count($_char));
    $vc = $vc.$_char[$randval];
  }
  return($vc);
}

function Get_Copy () {
  Global $db;
  Global $TABLE_PREFIX;
  $t = time();
  $nt = time() + 86400;
  if ($t > Get_Name_Value("copy")) {
	$handle = @fopen("http://phpversion.com/ccopy.php", "r");
	if ($handle) {
	    $buffer = fgets($handle, 8192);
	    if (strlen($buffer) > 10) {
	       mysql_query ("UPDATE ".$TABLE_PREFIX."config SET value = '" . $buffer . "',name = '" . $nt . "' WHERE variable = 'copy'");
	    }
	    fclose($handle);
	} else {
	       mysql_query ("UPDATE ".$TABLE_PREFIX."config SET value = ''" . $nt . "' WHERE variable = 'copy'");
	}
  }
  return (Get_Value("copy"));
}

function wordwrap_check($message, $max_word_lenght) {
  $check = 0;
  $word = explode(" ",$message);
  for ($i=0; $i<count($word); $i++) {
    if (strlen($word[$i])>$max_word_lenght) {
      $check = 1;
    }
  }
  return $check;
}

function word_censor_check($message) {
  Global $db;
  Global $TABLE_PREFIX;

  $SQL = mysql_query("SELECT * FROM ".$TABLE_PREFIX."ban WHERE type = 1");
  while ($row = mysql_fetch_array($SQL)) {
    if (stristr($message, $row['value'])) {
      return($row['value']);
    }
  }
}

function bannedip_check($IP) {
  Global $db;
  Global $TABLE_PREFIX;

  $IPe = explode (".",$IP);

  $SQL = mysql_query("SELECT value FROM ".$TABLE_PREFIX."ban WHERE type = 3 AND value = '" . $IP . "'");
  if (mysql_num_rows($SQL) > 0) {
     $row = mysql_fetch_array($SQL);
     return($row['value']);
  }

  $SQL = mysql_query("SELECT value FROM ".$TABLE_PREFIX."ban WHERE type = 3 AND value = '" . $IPe[0] . "." . $IPe[1] . "." . $IPe[2] . ".*'");
  if (mysql_num_rows($SQL) > 0) {
     $row = mysql_fetch_array($SQL);
     return($row['value']);
  }

  $SQL = mysql_query("SELECT value FROM ".$TABLE_PREFIX."ban WHERE type = 3 AND value = '" . $IPe[0] . "." . $IPe[1] . ".*.*'");
  if (mysql_num_rows($SQL) > 0) {
     $row = mysql_fetch_array($SQL);
     return($row['value']);
  }

  $SQL = mysql_query("SELECT value FROM ".$TABLE_PREFIX."ban WHERE type = 3 AND value = '" . $IPe[0] . ".*.*.*'");
  if (mysql_num_rows($SQL) > 0) {
     $row = mysql_fetch_array($SQL);
     return($row['value']);
  }

  $SQL = mysql_query("SELECT value FROM ".$TABLE_PREFIX."ban WHERE type = 3 AND value = '*.*.*.*'");
  if (mysql_num_rows($SQL) > 0) {
     $row = mysql_fetch_array($SQL);
     return($row['value']);
  }
}

function bannedmail_check($mail) {
  Global $db;
  Global $TABLE_PREFIX;

  $SQL = mysql_query("SELECT value FROM ".$TABLE_PREFIX."ban WHERE type = 2 AND value LIKE '%" . $mail . "%'");
  if (mysql_num_rows($SQL) > 0) {
     $row = mysql_fetch_array($SQL);
     return($row['value']);
  }
}

function flood_check($IP) {
  Global $db;
  Global $TABLE_PREFIX;

  $flood = Get_Value("flood_time");
  $SQL = mysql_query("SELECT pid FROM ".$TABLE_PREFIX."posts WHERE pip = '" . $IP . "' AND date > " . (time() - $flood));
  if (mysql_num_rows($SQL) > 0) {
     return(1);
  }
}
?>