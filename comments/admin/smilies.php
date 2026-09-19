<?
/***************************************************************************  
 *   copyright            : (C) 2007 PHPVersion.com 
 ***************************************************************************/ 

$vxg_root_path = "./../";
require($vxg_root_path . 'extension.inc');
include('header.' . $phpEx);

$tpl = new MiniTemplator;
$tpl->readTemplateFromFile($vxg_root_path."template/".$template."/admin/smilies.tpl");

$tpl->setVariable ("phpEx",$phpEx);

if ($_POST['Update']) {
        
	$c = count($_POST['sm_sid']);
	for ($i = 0 ; $i < $c; $i++) {
	    $sid = $_POST['sm_sid'][$i];
	    if ($_POST['sm_delete'][$sid] == 1) {
                mysql_query ("DELETE FROM ".$TABLE_PREFIX."smilies WHERE sid='".$_POST['sm_sid'][$i]."'") or die(mysql_error());
	    } else {
                mysql_query ("UPDATE ".$TABLE_PREFIX."smilies SET code='".$_POST['sm_code'][$i]."',smile_url='".$_POST['sm_smile_url'][$i]."',emoticon='".$_POST['sm_emoticon'][$i]."' WHERE sid='".$_POST['sm_sid'][$i]."'") or die(mysql_error());
	    }
	}
	
	//phpinfo();
	$tpl->setVariable ("acn_updated",$lang['acn_updated']);

	// Add new smile code
	if ($_POST['sm_code_add'] && $_POST['sm_smile_url_add'] && $_POST['sm_emoticon_add']) {
	   mysql_query ("INSERT INTO ".$TABLE_PREFIX."smilies (code,smile_url,emoticon) VALUES ('".$_POST['sm_code_add']."','".$_POST['sm_smile_url_add']."','".$_POST['sm_emoticon_add']."')") ;
	}
}


$tpl->setVariable ("asm_conf",$lang['asm_conf']);
$tpl->setVariable ("asm_code",$lang['asm_code']);
$tpl->setVariable ("asm_smile_url",$lang['asm_smile_url']);
$tpl->setVariable ("asm_emoticon",$lang['asm_emoticon']);
$tpl->setVariable ("asm_delete",$lang['asm_delete']);

$SQL = mysql_query ("SELECT * FROM ".$TABLE_PREFIX."smilies");
while ($row = mysql_fetch_array($SQL)) {
    $tpl->setVariable ("sm_sid",$row[sid]);
    $tpl->setVariable ("sm_code",$row[code]);
    $tpl->setVariable ("sm_smile_url",$row[smile_url]);
    $tpl->setVariable ("sm_emoticon",$row[emoticon]);
    $tpl->addBlock ("smilies"); 
}

$tpl->setVariable ("acn_update",$lang['acn_update']);

$tpl->generateOutput();

include('footer.' . $phpEx);

?>