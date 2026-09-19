<?
/***************************************************************************  
 *   copyright            : (C) 2007 PHPVersion.com 
 ***************************************************************************/ 

$vxg_root_path = "./../";
require($vxg_root_path . 'extension.inc');
require($vxg_root_path . 'config.'.$phpEx);
require($vxg_root_path . '/include/function.'.$phpEx);
require($vxg_root_path . '/include/template.class.'.$phpEx);

$db = mysql_connect($MYSQL_HOST,$MYSQL_USER,$MYSQL_PASS) or die (mysql_error());
mysql_select_db ($MYSQL_DATABASE) or die(mysql_error());

if (Get_Value("gzip") == 1 && ini_get('zlib.output_compression') != 1) ob_start("ob_gzhandler");

if (auth_check(get_quotes($_COOKIE['admin_name']),get_quotes($_COOKIE['admin_pass'])) == "false") {
	echo '<script type="text/javascript">
	<!--
	window.location = "login.'.$phpEx.'?post=1"
	//-->
	</script>';
	exit();
}

$language = Get_Value("lang");
$template = Get_Value("template");
require($vxg_root_path . '/language/' . $language . '.' . $phpEx);

$tpl = new MiniTemplator;
$tpl->readTemplateFromFile($vxg_root_path."template/".$template."/admin/header.tpl");
$tpl->setVariable ("phpEx",$phpEx);
$tpl->setVariable ("TITLE",$lang['oa_acp']);
$tpl->setVariable ("content",$lang['content']);
$tpl->setVariable ("am_ga",$lang['am_ga']);
$tpl->setVariable ("am_mp",$lang['am_mp']);
$tpl->setVariable ("am_cn",$lang['am_cn']);
$tpl->setVariable ("am_fc",$lang['am_fc']);
$tpl->setVariable ("am_ss",$lang['am_ss']);
$tpl->setVariable ("am_eg",$lang['am_eg']);
$tpl->setVariable ("am_wv",$lang['am_wv']);
$tpl->setVariable ("am_mt",$lang['am_mt']);
$tpl->setVariable ("am_bp",$lang['am_bp']);
$tpl->setVariable ("am_re",$lang['am_re']);
$tpl->setVariable ("am_pg",$lang['am_pg']);
$tpl->setVariable ("am_bc",$lang['am_bc']);
$tpl->setVariable ("am_wc",$lang['am_wc']);
$tpl->setVariable ("am_el",$lang['am_el']);
$tpl->setVariable ("am_ip",$lang['am_ip']);
$tpl->setVariable ("am_lt",$lang['am_lt']);

$tpl->generateOutput();
?>
