<?
/***************************************************************************  
 *   copyright            : (C) 2007 PHPVersion.com 
 ***************************************************************************/ 

$vxg_root_path = "./../";
require($vxg_root_path . 'extension.inc');
include('header.' . $phpEx);

$tpl = new MiniTemplator;
$tpl->readTemplateFromFile($vxg_root_path."template/".$template."/admin/config.tpl");

$tpl->setVariable ("phpEx",$phpEx);

if ($_POST['Update']) {
	
	Put_Value("admin_name",$_POST['admin_name']);
	if (strlen($_POST['admin_pass']) != 0) {
	    Put_Value("admin_pass",md5($_POST['admin_pass']));
	}
	Put_Value("admin_mail",$_POST['admin_mail']);

	Put_Value("gb_title",$_POST['gb_title']);
	Put_Value("gb_webpath",$_POST['gb_webpath']);
	Put_Value("word_censor",$_POST['word_censor']);
	Put_Value("captcha",$_POST['captcha']);
	Put_Value("admin_valid",$_POST['admin_valid']);
	Put_Value("enot",$_POST['enot']);
	Put_Value("allow_html",$_POST['allow_html']);
	Put_Value("allowed_tags",$_POST['allowed_tags']);
	Put_Value("template",$_POST['template']);
	Put_Value("lang",$_POST['lang']);
	Put_Value("gzip",$_POST['gzip']);
	Put_Value("min_len",$_POST['min_len']);
	Put_Value("max_len",$_POST['max_len']);
	Put_Value("max_word_lenght",$_POST['max_word_lenght']);
	Put_Value("flood_time",$_POST['flood_time']);
	Put_Value("per_page",$_POST['per_page']);
	Put_Value("tzone",$_POST['timezone']);

	//$tpl->setVariable ("acn_updated",$lang['acn_updated']);

	echo '<script type="text/javascript">
	<!--
	window.location = "config.'.$phpEx.'"
	//-->
	</script>';

}


$tpl->setVariable ("acn_cn",$lang['acn_cn']);
$tpl->setVariable ("acn_an",$lang['acn_an']);
$tpl->setVariable ("admin_name",Get_Value("admin_name"));
$tpl->setVariable ("acn_ap",$lang['acn_ap']);
$tpl->setVariable ("acn_amail",$lang['acn_amail']);
$tpl->setVariable ("admin_mail",Get_Value("admin_mail"));

$tpl->setVariable ("acn_title",$lang['acn_title']);
$tpl->setVariable ("gb_title",Get_Value("gb_title"));

$tpl->setVariable ("acn_webpath",$lang['acn_webpath']);
$tpl->setVariable ("gb_webpath",Get_Value("gb_webpath"));

$tpl->setVariable ("acn_uwc",$lang['acn_uwc']);
$selected = Get_Selected("word_censor",1);
$tpl->setVariable ("uwc_selected1",$selected);
$selected = Get_Selected("word_censor",0);
$tpl->setVariable ("uwc_selected0",$selected);

$tpl->setVariable ("acn_uvc",$lang['acn_uvc']);
$selected = Get_Selected("captcha",1);
$tpl->setVariable ("uvc_selected1",$selected);
$selected = Get_Selected("captcha",0);
$tpl->setVariable ("uvc_selected0",$selected);

$tpl->setVariable ("acn_uav",$lang['acn_uav']);
$selected = Get_Selected("admin_valid",1);
$tpl->setVariable ("uav_selected1",$selected);
$selected = Get_Selected("admin_valid",0);
$tpl->setVariable ("uav_selected0",$selected);

$tpl->setVariable ("acn_enot",$lang['acn_enot']);
$selected = Get_Selected("enot",1);
$tpl->setVariable ("enot_selected1",$selected);
$selected = Get_Selected("enot",0);
$tpl->setVariable ("enot_selected0",$selected);

$tpl->setVariable ("acn_ah",$lang['acn_ah']);
$selected = Get_Selected("allow_html",1);
$tpl->setVariable ("ah_selected1",$selected);
$selected = Get_Selected("allow_html",0);
$tpl->setVariable ("ah_selected0",$selected);

$tpl->setVariable ("acn_aht",$lang['acn_aht']);
$tpl->setVariable ("allowed_tags",Get_Value("allowed_tags"));

$tpl->setVariable ("acn_dt",$lang['acn_dt']);
if ($handle = opendir($vxg_root_path.'template')) {
    while (false !== ($dirs = readdir($handle))) {
        if ($dirs != "." && $dirs != "..") {
            if (is_dir($vxg_root_path.'template/'.$dirs)) {
		$tpl->setVariable ("template_name",$dirs);
		$selected = Get_Value("template");
		if ($dirs == $selected) {$tpl->setVariable ("tselected","SELECTED");}
		else {$tpl->setVariable ("tselected","");}
		$tpl->addBlock ("templates"); 
            }
        }
    }
    closedir($handle);
}

$tpl->setVariable ("acn_dl",$lang['acn_dl']);
if ($handle = opendir($vxg_root_path.'language')) {
    while (false !== ($files = readdir($handle))) {
        if ($files != "." && $files != "..") {
            if (is_file($vxg_root_path.'language/'.$files)) {
                $f = explode (".",$files);
		$tpl->setVariable ("language_name",$f[0]);
		$selected = Get_Value("lang");
		if ($f[0] == $selected) {$tpl->setVariable ("lselected","SELECTED");}
		else {$tpl->setVariable ("lselected","");}
		$tpl->addBlock ("languages"); 
            }
        }
    }
    closedir($handle);
}

$tpl->setVariable ("acn_gc",$lang['acn_gc']);
$selected = Get_Selected("gzip",1);
$tpl->setVariable ("gc_selected1",$selected);
$selected = Get_Selected("gzip",0);
$tpl->setVariable ("gc_selected0",$selected);

$tpl->setVariable ("acn_min",$lang['acn_min']);
$tpl->setVariable ("min_len",Get_Value("min_len"));

$tpl->setVariable ("acn_max",$lang['acn_max']);
$tpl->setVariable ("max_len",Get_Value("max_len"));

$tpl->setVariable ("acn_mwl",$lang['acn_mwl']);
$tpl->setVariable ("max_word_lenght",Get_Value("max_word_lenght"));

$tpl->setVariable ("acn_fc",$lang['acn_fc']);
$tpl->setVariable ("flood_time",Get_Value("flood_time"));

$tpl->setVariable ("acn_pp",$lang['acn_pp']);
$tpl->setVariable ("per_page",Get_Value("per_page"));

$tpl->setVariable ("acn_tz",$lang['acn_tz']);
for ($tze = -12; $tze <= 13; $tze++) {
        $tzev = "";

        if ($tze <= -10) $tzev = "-".abs($tze);
        if ($tze > -10 && $tze < 0) $tzev = "-0".abs($tze);
        if ($tze > 0 && $tze < 10) $tzev = "+0".$tze;
        if ($tze >= 10) $tzev = "+".$tze;

        if ($tze == 0) $tzev = 0; 

	$tpl->setVariable ("tz_value",$tzev);
	$tpl->setVariable ("tz_value_disp",$tzev.":"."00");
	$selected = Get_Value("tzone");
	if ($tzev == $selected) {$tpl->setVariable ("tzselected","SELECTED");}
	else {$tpl->setVariable ("tzselected","");}
	$tpl->addBlock ("timezone"); 
}

$tpl->setVariable ("acn_update",$lang['acn_update']);
$tpl->setVariable ("oa_on",$lang['oa_on']);
$tpl->setVariable ("oa_off",$lang['oa_off']);

$tpl->generateOutput();

include('footer.' . $phpEx);

?>