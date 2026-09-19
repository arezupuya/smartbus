<?
/***************************************************************************  
 *   copyright            : (C) 2007 PHPVersion.com 
 ***************************************************************************/ 

$vxg_root_path = "./../";
require($vxg_root_path . 'extension.inc');
require($vxg_root_path . 'config.'.$phpEx);
require($vxg_root_path . '/include/function.'.$phpEx);

$db = mysql_connect($MYSQL_HOST,$MYSQL_USER,$MYSQL_PASS) or die (mysql_error());
mysql_select_db ($MYSQL_DATABASE) or die(mysql_error());

if ($_POST['login']) {
   setcookie("admin_name", $_POST['admin_name']);
   setcookie("admin_pass", md5($_POST['admin_pass']));
   header ("Location: index.".$phpEx."?post=1");
}

if (auth_check(quote_smart($_COOKIE['admin_name']),quote_smart($_COOKIE['admin_pass'])) == "true") {
   header ("Location: admin.".$phpEx);
} else {
	echo '<script type="text/javascript">
	<!--
	window.location = "login.'.$phpEx.'?post='.$_REQUEST['post'].'"
	//-->
	</script>';
}

//include('footer.' . $phpEx);
?>