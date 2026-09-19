<?
/***************************************************************************  
 *   copyright            : (C) 2007 PHPVersion.com 
 ***************************************************************************/ 

$vxg_root_path = "./../";
require($vxg_root_path . 'extension.inc');
require($vxg_root_path . 'config.' .$phpEx);
require($vxg_root_path . '/include/function.' .$phpEx);
require($vxg_root_path . '/include/template.class.' .$phpEx);

$db = mysql_connect($MYSQL_HOST,$MYSQL_USER,$MYSQL_PASS) or die (mysql_error());
mysql_select_db ($MYSQL_DATABASE) or die(mysql_error());

$language = Get_Value("lang");
$template = Get_Value("template");

require($vxg_root_path . '/language/' . $language . '.' . $phpEx);

$tpl = new MiniTemplator;
$tpl->readTemplateFromFile($vxg_root_path."template/".$template."/admin/login.tpl");
$tpl->setVariable ("phpEx",$phpEx);
$tpl->setVariable ("TITLE",$lang['oa_acp']);
$tpl->setVariable ("content",$lang['content']);
$tpl->setVariable ("lf_title",$lang['oa_acp']);
$tpl->setVariable ("lf_user",$lang['lf_user']);
$tpl->setVariable ("lf_pass",$lang['lf_pass']);
$tpl->setVariable ("lf_login",$lang['lf_login']);
$tpl->setVariable ("lf_reset",$lang['lf_reset']);

if ($_REQUEST['post'] == 1) {
	$tpl->setVariable ("lf_error",$lang['lf_error']);
}

$tpl->generateOutput();

mysql_close($db);
?>