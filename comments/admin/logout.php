<?
$vxg_root_path = "./../";
require($vxg_root_path . 'extension.inc');

setcookie("admin_name", "");
setcookie("admin_pass", "");
header ("Location: index.".$phpEx);

?>