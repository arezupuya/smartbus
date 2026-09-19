<?
/***************************************************************************  
 *   copyright            : (C) 2007 PHPVersion.com 
 ***************************************************************************/ 

$vxg_root_path = "./../";
require($vxg_root_path . 'extension.inc');
//include('header.' . $phpEx);
require($vxg_root_path . 'config.'.$phpEx);
require($vxg_root_path . '/include/function.'.$phpEx);
require($vxg_root_path . '/include/backup.class.'.$phpEx);

$db = mysql_connect($MYSQL_HOST,$MYSQL_USER,$MYSQL_PASS) or die (mysql_error());
mysql_select_db ($MYSQL_DATABASE) or die(mysql_error());

if (auth_check(get_quotes($_COOKIE['admin_name']),get_quotes($_COOKIE['admin_pass'])) == "false") {
	echo '<script type="text/javascript">
	<!--
	window.location = "login.'.$phpEx.'?post=1"
	//-->
	</script>';
	exit();
}


header("Content-Type: text/x-delimtext; name=\"".$MYSQL_DATABASE."_db_backup.sql\"");
header("Content-disposition: attachment; filename=".$MYSQL_DATABASE."_db_backup.sql");

echo  "# Table backup from FREE PHP VX GUESTBOOK\n".
      "# Creation date: ".date("d-M-Y h:s",time())."\n".
      "# Database: ".$MYSQL_DATABASE."\n".
      "# MySQL Server version: ".mysql_get_server_info()."\n\n";

echo "\n\n".get_def($MYSQL_DATABASE,$TABLE_PREFIX."config")."\n\n";
echo get_content($MYSQL_DATABASE,$TABLE_PREFIX."config");		

echo "\n\n".get_def($MYSQL_DATABASE,$TABLE_PREFIX."smilies")."\n\n";
echo get_content($MYSQL_DATABASE,$TABLE_PREFIX."smilies");		

echo "\n\n".get_def($MYSQL_DATABASE,$TABLE_PREFIX."posts")."\n\n";
echo get_content($MYSQL_DATABASE,$TABLE_PREFIX."posts");		

echo "\n\n".get_def($MYSQL_DATABASE,$TABLE_PREFIX."sessions")."\n\n";
echo get_content($MYSQL_DATABASE,$TABLE_PREFIX."sessions");		

mysql_close($db);
?>