<?
/***************************************************************************  
 *   copyright            : (C) 2007 PHPVersion.com 
 ***************************************************************************/ 

$vxg_root_path = "./";

$tpl = new MiniTemplator;
$tpl->readTemplateFromFile($vxg_root_path."template/".$template."/footer.tpl");
$tpl->setVariable ("COPYRIGHT",Get_Copy());
$tpl->generateOutput();

mysql_close($db);
?>