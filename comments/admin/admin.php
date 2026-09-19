<?
/***************************************************************************  
 *   copyright            : (C) 2007 PHPVersion.com 
 ***************************************************************************/ 

$vxg_root_path = "./../";
require($vxg_root_path . 'extension.inc');
include('header.' . $phpEx);

$tpl = new MiniTemplator;
$tpl->readTemplateFromFile($vxg_root_path."template/".$template."/admin/admin.tpl");
$tpl->setVariable ("amp_gs",$lang['amp_gs']);
$tpl->setVariable ("amp_ms",$lang['amp_ms']);
$tpl->setVariable ("amp_np",$lang['amp_np']);
$tpl->setVariable ("amp_wp",$lang['amp_wp']);
$tpl->setVariable ("amp_dbs",$lang['amp_dbs']);
$tpl->setVariable ("amp_gz",$lang['amp_gz']);
$tpl->setVariable ("amp_gd",$lang['amp_gd']);
$tpl->setVariable ("amp_gd_note",$lang['amp_gd_note']);

$SQL = mysql_query("SELECT count(pid) as TOTAL FROM ".$TABLE_PREFIX."posts");
$row = mysql_fetch_array($SQL);
$tpl->setVariable ("n_posts",$row['TOTAL']);

$SQL = mysql_query("SELECT count(pid) as TOTAL FROM ".$TABLE_PREFIX."posts WHERE validated = 0");
$row = mysql_fetch_array($SQL);
$tpl->setVariable ("w_posts",$row['TOTAL']);

$SQL = mysql_query("SHOW TABLE STATUS FROM ".$MYSQL_DATABASE);
while($row = mysql_fetch_array($SQL)) {
	$total = $total + $row['Data_length'] + $row['Index_length'];
}
$tpl->setVariable ("db_size",round(($total / 1024),2)." Kb");
$tpl->setVariable ("gzip",Get_Vchar_Value(Get_Value('gzip'),$lang['oa_on'],$lang['oa_off']));

if (function_exists('gd_info')) { $tpl->setVariable ("gdlib",$lang['oa_on']); }
else { $tpl->setVariable ("gdlib",$lang['oa_off']); }

$status = explode('  ', mysql_stat($db));

$tpl->setVariable ("status_0",$status[0]);
$tpl->setVariable ("status_1",$status[1]);
$tpl->setVariable ("status_2",$status[2]);
$tpl->setVariable ("status_3",$status[3]);
$tpl->setVariable ("status_4",$status[4]);
$tpl->setVariable ("status_5",$status[5]);
$tpl->setVariable ("status_6",$status[6]);
$tpl->setVariable ("status_7",$status[7]);

$tpl->setVariable ("an_mysql_uptime",$lang['an_mysql_uptime']);

$tpl->generateOutput();

include('footer.' . $phpEx);

?>