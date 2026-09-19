<?
/***************************************************************************  
 *   copyright            : (C) 2007 PHPVersion.com 
 ***************************************************************************/ 

$vxg_root_path = "./../";
require($vxg_root_path . 'extension.inc');
include('header.' . $phpEx);

$tpl = new MiniTemplator;
$tpl->readTemplateFromFile($vxg_root_path."template/".$template."/admin/fconfig.tpl");

$tpl->setVariable ("phpEx",$phpEx);

if ($_POST['Update']) {
        Put_If_Value ("poster_mail",$_POST['poster_mail'],$_POST['poster_mail_req']);
        Put_If_Value ("poster_location",$_POST['poster_location'],$_POST['poster_location_req']);
        Put_If_Value ("msn",$_POST['msn'],$_POST['msn_req']);
        Put_If_Value ("aim",$_POST['aim'],$_POST['aim_req']);
        Put_If_Value ("yim",$_POST['yim'],$_POST['yim_req']);
        Put_If_Value ("homepage",$_POST['homepage'],$_POST['homepage_req']);
        Put_If_Value ("icq",$_POST['icq'],$_POST['icq_req']);
        Put_If_Value ("gender",$_POST['gender'],$_POST['gender_req']);
        Put_If_Value ("age",$_POST['age'],$_POST['age_req']);
        Put_If_Value ("c_field_1",$_POST['c_field_1'],$_POST['c_field_1_req']);
        Put_If_Value ("c_field_2",$_POST['c_field_2'],$_POST['c_field_2_req']);
        Put_If_Value ("c_field_3",$_POST['c_field_3'],$_POST['c_field_3_req']);
        Put_If_Value ("c_field_4",$_POST['c_field_4'],$_POST['c_field_4_req']);
        Put_If_Value ("c_field_5",$_POST['c_field_5'],$_POST['c_field_5_req']);

        Put_Name_Value ("c_field_1",$_POST['c_field_1_name']);
        Put_Name_Value ("c_field_2",$_POST['c_field_2_name']);
        Put_Name_Value ("c_field_3",$_POST['c_field_3_name']);
        Put_Name_Value ("c_field_4",$_POST['c_field_4_name']);
        Put_Name_Value ("c_field_5",$_POST['c_field_5_name']);

	$tpl->setVariable ("acn_updated",$lang['acn_updated']);
}


$tpl->setVariable ("afc_fc",$lang['afc_fc']);
$tpl->setVariable ("afc_enabled",$lang['afc_enabled']);
$tpl->setVariable ("afc_required",$lang['afc_required']);
$tpl->setVariable ("afc_field_name",$lang['afc_field_name']);

$tpl->setVariable ("afc_email",$lang['afc_email']);
$tpl->setVariable ("em_e",Get_Checked_Value("poster_mail","value"));
$tpl->setVariable ("em_r",Get_Checked_Value("poster_mail","req"));
$tpl->setVariable ("poster_mail",Get_Value("poster_mail"));
$tpl->setVariable ("poster_mail_req",Get_Req_Value("poster_mail"));

$tpl->setVariable ("afc_location",$lang['afc_location']);
$tpl->setVariable ("pl_e",Get_Checked_Value("poster_location","value"));
$tpl->setVariable ("pl_r",Get_Checked_Value("poster_location","req"));
$tpl->setVariable ("poster_location",Get_Value("poster_location"));
$tpl->setVariable ("poster_location_req",Get_Req_Value("poster_location"));

$tpl->setVariable ("afc_msn",$lang['afc_msn']);
$tpl->setVariable ("msn_e",Get_Checked_Value("msn","value"));
$tpl->setVariable ("msn_r",Get_Checked_Value("msn","req"));
$tpl->setVariable ("msn",Get_Value("msn"));
$tpl->setVariable ("msn_req",Get_Req_Value("msn"));

$tpl->setVariable ("afc_aim",$lang['afc_aim']);
$tpl->setVariable ("aim_e",Get_Checked_Value("aim","value"));
$tpl->setVariable ("aim_r",Get_Checked_Value("aim","req"));
$tpl->setVariable ("aim",Get_Value("aim"));
$tpl->setVariable ("aim_req",Get_Req_Value("aim"));

$tpl->setVariable ("afc_yim",$lang['afc_yim']);
$tpl->setVariable ("yim_e",Get_Checked_Value("yim","value"));
$tpl->setVariable ("yim_r",Get_Checked_Value("yim","req"));
$tpl->setVariable ("yim",Get_Value("yim"));
$tpl->setVariable ("yim_req",Get_Req_Value("yim"));

$tpl->setVariable ("afc_homepage",$lang['afc_homepage']);
$tpl->setVariable ("homepage_e",Get_Checked_Value("homepage","value"));
$tpl->setVariable ("homepage_r",Get_Checked_Value("homepage","req"));
$tpl->setVariable ("homepage",Get_Value("homepage"));
$tpl->setVariable ("homepage_req",Get_Req_Value("homepage"));

$tpl->setVariable ("afc_icq",$lang['afc_icq']);
$tpl->setVariable ("icq_e",Get_Checked_Value("icq","value"));
$tpl->setVariable ("icq_r",Get_Checked_Value("icq","req"));
$tpl->setVariable ("icq",Get_Value("icq"));
$tpl->setVariable ("icq_req",Get_Req_Value("icq"));

$tpl->setVariable ("afc_gender",$lang['afc_gender']);
$tpl->setVariable ("gender_e",Get_Checked_Value("gender","value"));
$tpl->setVariable ("gender_r",Get_Checked_Value("gender","req"));
$tpl->setVariable ("gender",Get_Value("gender"));
$tpl->setVariable ("gender_req",Get_Req_Value("gender"));

$tpl->setVariable ("afc_age",$lang['afc_age']);
$tpl->setVariable ("age_e",Get_Checked_Value("age","value"));
$tpl->setVariable ("age_r",Get_Checked_Value("age","req"));
$tpl->setVariable ("age",Get_Value("age"));
$tpl->setVariable ("age_req",Get_Req_Value("age"));

$tpl->setVariable ("afc_c_field_1",$lang['afc_c_field_1']);
$tpl->setVariable ("c_field_1_e",Get_Checked_Value("c_field_1","value"));
$tpl->setVariable ("c_field_1_r",Get_Checked_Value("c_field_1","req"));
$tpl->setVariable ("c_field_1",Get_Value("c_field_1"));
$tpl->setVariable ("c_field_1_req",Get_Req_Value("c_field_1"));
$tpl->setVariable ("c_field_1_name",Get_Name_Value("c_field_1"));

$tpl->setVariable ("afc_c_field_2",$lang['afc_c_field_2']);
$tpl->setVariable ("c_field_2_e",Get_Checked_Value("c_field_2","value"));
$tpl->setVariable ("c_field_2_r",Get_Checked_Value("c_field_2","req"));
$tpl->setVariable ("c_field_2",Get_Value("c_field_2"));
$tpl->setVariable ("c_field_2_req",Get_Req_Value("c_field_2"));
$tpl->setVariable ("c_field_2_name",Get_Name_Value("c_field_2"));

$tpl->setVariable ("afc_c_field_3",$lang['afc_c_field_3']);
$tpl->setVariable ("c_field_3_e",Get_Checked_Value("c_field_3","value"));
$tpl->setVariable ("c_field_3_r",Get_Checked_Value("c_field_3","req"));
$tpl->setVariable ("c_field_3",Get_Value("c_field_3"));
$tpl->setVariable ("c_field_3_req",Get_Req_Value("c_field_3"));
$tpl->setVariable ("c_field_3_name",Get_Name_Value("c_field_3"));

$tpl->setVariable ("afc_c_field_4",$lang['afc_c_field_4']);
$tpl->setVariable ("c_field_4_e",Get_Checked_Value("c_field_4","value"));
$tpl->setVariable ("c_field_4_r",Get_Checked_Value("c_field_4","req"));
$tpl->setVariable ("c_field_4",Get_Value("c_field_4"));
$tpl->setVariable ("c_field_4_req",Get_Req_Value("c_field_4"));
$tpl->setVariable ("c_field_4_name",Get_Name_Value("c_field_4"));

$tpl->setVariable ("afc_c_field_5",$lang['afc_c_field_5']);
$tpl->setVariable ("c_field_5_e",Get_Checked_Value("c_field_5","value"));
$tpl->setVariable ("c_field_5_r",Get_Checked_Value("c_field_5","req"));
$tpl->setVariable ("c_field_5",Get_Value("c_field_5"));
$tpl->setVariable ("c_field_5_req",Get_Req_Value("c_field_5"));
$tpl->setVariable ("c_field_5_name",Get_Name_Value("c_field_5"));

$tpl->setVariable ("acn_update",$lang['acn_update']);
$tpl->setVariable ("afc_notes",$lang['afc_notes']);

$tpl->generateOutput();

include('footer.' . $phpEx);

?>