<?
/***************************************************************************  
 *   copyright            : (C) 2007 PHPVersion.com 
 ***************************************************************************/ 

$vxg_root_path = "./../";
require($vxg_root_path . 'extension.inc');
include('header.' . $phpEx);

$tpl = new MiniTemplator;
$tpl->readTemplateFromFile($vxg_root_path."template/".$template."/admin/words.tpl");

$tpl->setVariable ("phpEx",$phpEx);

/* 
Type :
0 = unused
1 = word  ban
2 = email ban
3 = IP    ban
*/

if ($_POST['add_action']) {
    if (strlen($_POST['word']) != 0) {
        mysql_query("INSERT INTO ".$TABLE_PREFIX."ban VALUES ('',1,'".$_POST['word']."')") or die(mysql_error());
    }
    $tpl->setVariable ("acn_updated",$lang['acn_updated']);
}

if ($_POST['del_action']) {
    $c = count($_POST['word']);
    for ($i = 0; $i<=$c ; $i++) {
        mysql_query("DELETE FROM ".$TABLE_PREFIX."ban WHERE bid = ".$_POST['word'][$i]);
    }
    $tpl->setVariable ("acn_updated",$lang['acn_updated']);
}     

$tpl->setVariable ("aw_conf",$lang['aw_conf']);
$tpl->setVariable ("aw_add_word",$lang['aw_add_word']);
$tpl->setVariable ("aw_banned_words",$lang['aw_banned_words']);

$SQL = mysql_query("SELECT bid,value FROM ".$TABLE_PREFIX."ban WHERE type = 1");
while ($row = mysql_fetch_array($SQL)) {
    $tpl->setVariable ("bid",$row[bid]);
    $tpl->setVariable ("value",$row[value]);
    $tpl->addBlock ("words"); 
}

$tpl->setVariable ("acn_update",$lang['acn_update']);
$tpl->setVariable ("acn_remove",$lang['acn_remove']);
$tpl->generateOutput();

include('footer.' . $phpEx);
?>