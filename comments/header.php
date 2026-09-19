<?
/***************************************************************************  
 *   copyright            : (C) 2007 PHPVersion.com 
 ***************************************************************************/ 

$vxg_root_path = "./";
require($vxg_root_path . 'extension.inc');
require($vxg_root_path . 'config.'.$phpEx);
require($vxg_root_path . '/include/function.'.$phpEx);
require($vxg_root_path . '/include/template.class.'.$phpEx);

$db = mysql_connect($MYSQL_HOST,$MYSQL_USER,$MYSQL_PASS) or die (mysql_error());
mysql_select_db ($MYSQL_DATABASE) or die(mysql_error());

if (Get_Value("gzip") == 1 && ini_get('zlib.output_compression') != 1) ob_start("ob_gzhandler");

$language = Get_Value("lang");
$template = Get_Value("template");
require($vxg_root_path . '/language/' . $language . '.' . $phpEx);

$tpl = new MiniTemplator;
$tpl->readTemplateFromFile($vxg_root_path."template/".$template."/header.tpl");
$tpl->setVariable ("gb_title",Get_Value("gb_title"));
$tpl->setVariable ("content",$lang['content']);
$tpl->generateOutput();
?>
