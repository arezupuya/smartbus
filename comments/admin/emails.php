<?
/***************************************************************************  
 *   copyright            : (C) 2007 PHPVersion.com 
 ***************************************************************************/ 

$vxg_root_path = "./../";
require($vxg_root_path . 'extension.inc');
include('header.' . $phpEx);

$tpl = new MiniTemplator;
$tpl->readTemplateFromFile($vxg_root_path."template/".$template."/admin/emails.tpl");

$tpl->setVariable ("phpEx",$phpEx);

/* 
Type :
0 = unused
1 = word  ban
2 = email ban
3 = IP    ban
*/

if ($_POST['add_action']) {
    if (strlen($_POST['email']) != 0) {
        mysql_query("INSERT INTO ".$TABLE_PREFIX."ban VALUES ('',2,'".$_POST['email']."')") or die(mysql_error());
    }
    $tpl->setVariable ("acn_updated",$lang['acn_updated']);
}

if ($_POST['del_action']) {
    $c = count($_POST['email']);
    for ($i = 0; $i<=$c ; $i++) {
        mysql_query("DELETE FROM ".$TABLE_PREFIX."ban WHERE bid = ".$_POST['email'][$i]);
    }
    $tpl->setVariable ("acn_updated",$lang['acn_updated']);
}     

$tpl->setVariable ("aeb_conf",$lang['aeb_conf']);
$tpl->setVariable ("aeb_add_email",$lang['aeb_add_email']);
$tpl->setVariable ("aeb_banned_emails",$lang['aeb_banned_emails']);

$SQL = mysql_query("SELECT bid,value FROM ".$TABLE_PREFIX."ban WHERE type = 2");
while ($row = mysql_fetch_array($SQL)) {
    $tpl->setVariable ("bid",$row[bid]);
    $tpl->setVariable ("value",$row[value]);
    $tpl->addBlock ("emails"); 
}

$tpl->setVariable ("aeb_example",$lang['aeb_example']);
$tpl->setVariable ("acn_update",$lang['acn_update']);
$tpl->setVariable ("acn_remove",$lang['acn_remove']);
$tpl->generateOutput();

include('footer.' . $phpEx);
?>