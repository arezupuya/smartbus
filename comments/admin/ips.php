<?
/***************************************************************************  
 *   copyright            : (C) 2007 PHPVersion.com 
 ***************************************************************************/ 

$vxg_root_path = "./../";
require($vxg_root_path . 'extension.inc');
include('header.' . $phpEx);

$tpl = new MiniTemplator;
$tpl->readTemplateFromFile($vxg_root_path."template/".$template."/admin/ips.tpl");

$tpl->setVariable ("phpEx",$phpEx);

/* 
Type :
0 = unused
1 = word  ban
2 = email ban
3 = IP    ban
*/

if ($_POST['add_action']) {
    if (strlen($_POST['ip']) != 0) {
        mysql_query("INSERT INTO ".$TABLE_PREFIX."ban VALUES ('',3,'".$_POST['ip']."')") or die(mysql_error());
    }
    $tpl->setVariable ("acn_updated",$lang['acn_updated']);
}

if ($_POST['del_action']) {
    $c = count($_POST['ip']);
    for ($i = 0; $i<=$c ; $i++) {
        mysql_query("DELETE FROM ".$TABLE_PREFIX."ban WHERE bid = ".$_POST['ip'][$i]);
    }
    $tpl->setVariable ("acn_updated",$lang['acn_updated']);
}     

$tpl->setVariable ("aip_conf",$lang['aip_conf']);
$tpl->setVariable ("aip_add_ip",$lang['aip_add_ip']);
$tpl->setVariable ("aip_banned_ips",$lang['aip_banned_ips']);

$SQL = mysql_query("SELECT bid,value FROM ".$TABLE_PREFIX."ban WHERE type = 3");
while ($row = mysql_fetch_array($SQL)) {
    $tpl->setVariable ("bid",$row[bid]);
    $tpl->setVariable ("value",$row[value]);
    $tpl->addBlock ("ips"); 
}

$tpl->setVariable ("aip_example",$lang['aip_example']);
$tpl->setVariable ("acn_update",$lang['acn_update']);
$tpl->setVariable ("acn_remove",$lang['acn_remove']);
$tpl->generateOutput();

include('footer.' . $phpEx);
?>