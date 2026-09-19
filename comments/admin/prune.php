<?
/***************************************************************************  
 *   copyright            : (C) 2007 PHPVersion.com 
 ***************************************************************************/ 

$vxg_root_path = "./../";
require($vxg_root_path . 'extension.inc');
include('header.' . $phpEx);

$tpl = new MiniTemplator;
$tpl->readTemplateFromFile($vxg_root_path."template/".$template."/admin/prune.tpl");

$tpl->setVariable ("phpEx",$phpEx);

if ($_POST['Update']) {
  $remove_days = (time() - ($_POST['days'] * 86400));
  mysql_query("DELETE FROM ".$TABLE_PREFIX."posts WHERE date < ".$remove_days);
  $tpl->setVariable ("ap_removed",mysql_affected_rows()." ".$lang['ap_removed']);
}

$tpl->setVariable ("ap_remove_b",$lang['ap_remove_b']);
$tpl->setVariable ("ap_remove_a",$lang['ap_remove_a']);
$tpl->setVariable ("ap_prune",$lang['ap_prune']);

$tpl->generateOutput();

include('footer.' . $phpEx);
?>