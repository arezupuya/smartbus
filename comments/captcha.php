<?php

header("Content-type: image/png");

$vxg_root_path = "./";
require($vxg_root_path . 'extension.inc');
require($vxg_root_path . 'config.'.$phpEx);

$db = mysql_connect($MYSQL_HOST,$MYSQL_USER,$MYSQL_PASS) or die (mysql_error());
mysql_select_db ($MYSQL_DATABASE) or die(mysql_error());

$tstamp = intval($_REQUEST['tstamp']);

$SQL = mysql_query ("SELECT sval FROM ".$TABLE_PREFIX."sessions WHERE stime=$tstamp AND sname='key'");
$row = mysql_fetch_array($SQL);
$text = $row['sval'];

$im = imagecreatefrompng("images/code_bg.png") or die("Cannot Initialize new GD image stream");

$background_color = imagecolorallocate($im,25,25,25);
$black = imagecolorallocate($im, 0, 0, 0);
//$black1 = imagecolorallocate($im, 55, 155, 255);

// Pixels
for ($i=1;$i<=1000;$i++) {
  $rx = rand(0,110);
  $ry = rand(0,40);

  imagesetpixel ($im, $rx, $ry, imagecolorallocate($im,rand(0,255),rand(0,255),rand(0,255)));
}


for ($i=1;$i<=25;$i++) {
  $sx = rand(0,110);
  $sy = rand(0,40);
  $ex = rand(0,110);
  $ey = rand(0,40);

  imageline ($im, $sx, $sy, $ex, $ey, imagecolorallocate($im,rand(0,255),rand(0,255),rand(0,255)));
}

$step = 10;
$font = substr($_SERVER["SCRIPT_FILENAME"],0,strrpos($_SERVER["SCRIPT_FILENAME"],"/")).'/font/verdanab.ttf';

for ($i = 0 ; $i <4 ; $i++) {
  $t = substr ($text,$i,1);
  $randang = rand(-30,45);

  if ($randang >= 0) {
   $randang = rand(0,35);
  } else {
   $randang = rand(-35,0);
  }

  imagettftext ($im, 16, $randang, $step, 25, imagecolorallocate($im, 0, 0, 0), $font, $t);
  $step = $step + 25;
}

imagepng($im);
imagedestroy($im);



mysql_close($db);
?> 
