<?
/***************************************************************************  
 *   copyright            : (C) 2007 PHPVersion.com 
 ***************************************************************************/ 

$vxg_root_path = "./../";
require($vxg_root_path . 'extension.inc');
include('header.' . $phpEx);

$tpl = new MiniTemplator;
$tpl->readTemplateFromFile($vxg_root_path."template/".$template."/admin/validation.tpl");

$tpl->setVariable ("phpEx",$phpEx);

if ($_POST['Update']) {
        
	$c = count($_POST['pid']);
	for ($i = 0 ; $i < $c; $i++) {
	    $pid = $_POST['pid'][$i];
	    if ($_POST['action'][$pid] == "add") {
                mysql_query ("UPDATE ".$TABLE_PREFIX."posts SET validated='1' WHERE pid='".$pid."'") or die(mysql_error());
            } 
	    if ($_POST['action'][$pid] == "delete") {
	        mysql_query ("DELETE FROM ".$TABLE_PREFIX."posts WHERE pid='".$pid."'") or die(mysql_error());
	    }
	}
	
	$tpl->setVariable ("acn_updated",$lang['acn_updated']);
}


$tpl->setVariable ("avm_conf",$lang['avm_conf']);

$SQL = mysql_query ("SELECT * FROM ".$TABLE_PREFIX."posts WHERE validated = 0 ORDER BY date LIMIT 10");
while ($row = mysql_fetch_array($SQL)) {
    $tpl->setVariable ("poster",$row[poster]);
    $tpl->setVariable ("pid",$row[pid]);
    $tpl->setVariable ("avm_add",$lang['avm_add']);
    $tpl->setVariable ("avm_delete",$lang['avm_delete']);
    $tpl->setVariable ("postdate",Get_Day($row[date],$lang['today'],$lang['yesterday'],Get_Value("tzone")));
    $tpl->setVariable ("postnum",$lang['avm_post_num'].$row[pid]);
    $tpl->setVariable ("message",nl2br($row[text]));
    $tpl->addBlock ("messages"); 
}

$row = mysql_fetch_array(mysql_query("SELECT count(pid) as total FROM ".$TABLE_PREFIX."posts WHERE validated = 0"));

$tpl->setVariable ("total_posts",$row['total']);
$tpl->setVariable ("avm_wv",$lang['avm_wv']);

$tpl->setVariable ("acn_update",$lang['acn_update']);

$tpl->generateOutput();

include('footer.' . $phpEx);

?>