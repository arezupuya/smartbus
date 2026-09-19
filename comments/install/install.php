<?
$vxg_root_path = "./../";
require($vxg_root_path . 'extension.inc');
require($vxg_root_path . 'config.'.$phpEx);

$db = mysql_connect($MYSQL_HOST,$MYSQL_USER,$MYSQL_PASS) or die (mysql_error());
mysql_select_db ($MYSQL_DATABASE) or die(mysql_error());

?>
Creating table : <? echo $TABLE_PREFIX . "ban" ;?>
<?
mysql_query ("
CREATE TABLE ".$TABLE_PREFIX."ban (
  bid int(11) unsigned NOT NULL auto_increment,
  type tinyint(4) unsigned NOT NULL default '0',
  value varchar(250) NOT NULL default '0',
  PRIMARY KEY  (bid),
  KEY type (type,value(1))
)") or die(mysql_error());
?>
...Ok<br>
Creating table : <? echo $TABLE_PREFIX . "config" ;?>
<?
mysql_query ("
CREATE TABLE ".$TABLE_PREFIX."config (
  vid int(11) unsigned NOT NULL auto_increment,
  variable varchar(30) NOT NULL default '0',
  value text NOT NULL,
  req tinyint(4) unsigned NOT NULL default '1',
  name varchar(40) NOT NULL default '0',
  PRIMARY KEY  (vid),
  KEY ivariable (variable)
)") or die(mysql_error());
?>
...Ok<br>
Insert Records to table : <? echo $TABLE_PREFIX . "config" ;?>
<?
mysql_query ("INSERT INTO ".$TABLE_PREFIX."config VALUES (2,'admin_name','admin',0,'0')") or die(mysql_error());
mysql_query ("INSERT INTO ".$TABLE_PREFIX."config VALUES (3,'admin_pass','21232f297a57a5a743894a0e4a801fc3',0,'0')") or die(mysql_error());
mysql_query ("INSERT INTO ".$TABLE_PREFIX."config VALUES (4,'word_censor','1',0,'0')") or die(mysql_error());
mysql_query ("INSERT INTO ".$TABLE_PREFIX."config VALUES (5,'captcha','0',0,'0')") or die(mysql_error());
mysql_query ("INSERT INTO ".$TABLE_PREFIX."config VALUES (6,'admin_valid','0',0,'0')") or die(mysql_error());
mysql_query ("INSERT INTO ".$TABLE_PREFIX."config VALUES (7,'allow_html','0',0,'0')") or die(mysql_error());
mysql_query ("INSERT INTO ".$TABLE_PREFIX."config VALUES (8,'allowed_tags','<i><font><b>',0,'0')") or die(mysql_error());
mysql_query ("INSERT INTO ".$TABLE_PREFIX."config VALUES (9,'poster_name','0',1,'0')") or die(mysql_error());
mysql_query ("INSERT INTO ".$TABLE_PREFIX."config VALUES (10,'poster_mail','1',0,'0')") or die(mysql_error());
mysql_query ("INSERT INTO ".$TABLE_PREFIX."config VALUES (11,'poster_location','1',0,'0')") or die(mysql_error());
mysql_query ("INSERT INTO ".$TABLE_PREFIX."config VALUES (12,'msn','1',0,'0')") or die(mysql_error());
mysql_query ("INSERT INTO ".$TABLE_PREFIX."config VALUES (13,'aim','1',0,'0')") or die(mysql_error());
mysql_query ("INSERT INTO ".$TABLE_PREFIX."config VALUES (14,'yim','1',0,'0')") or die(mysql_error());
mysql_query ("INSERT INTO ".$TABLE_PREFIX."config VALUES (15,'homepage','1',0,'0')") or die(mysql_error());
mysql_query ("INSERT INTO ".$TABLE_PREFIX."config VALUES (16,'icq','1',0,'0')") or die(mysql_error());
mysql_query ("INSERT INTO ".$TABLE_PREFIX."config VALUES (17,'gender','1',0,'0')") or die(mysql_error());
mysql_query ("INSERT INTO ".$TABLE_PREFIX."config VALUES (18,'age','1',0,'0')") or die(mysql_error());
mysql_query ("INSERT INTO ".$TABLE_PREFIX."config VALUES (19,'c_field_1','1',0,'field name')") or die(mysql_error());
mysql_query ("INSERT INTO ".$TABLE_PREFIX."config VALUES (20,'c_field_2','1',0,'field name')") or die(mysql_error());
mysql_query ("INSERT INTO ".$TABLE_PREFIX."config VALUES (21,'c_field_3','1',0,'field name')") or die(mysql_error());
mysql_query ("INSERT INTO ".$TABLE_PREFIX."config VALUES (22,'c_field_4','1',0,'field name')") or die(mysql_error());
mysql_query ("INSERT INTO ".$TABLE_PREFIX."config VALUES (23,'c_field_5','1',0,'field name')") or die(mysql_error());
mysql_query ("INSERT INTO ".$TABLE_PREFIX."config VALUES (24,'template','subsilver',0,'0')") or die(mysql_error());
mysql_query ("INSERT INTO ".$TABLE_PREFIX."config VALUES (25,'lang','english',0,'0')") or die(mysql_error());
mysql_query ("INSERT INTO ".$TABLE_PREFIX."config VALUES (26,'gzip','0',0,'0')") or die(mysql_error());
mysql_query ("INSERT INTO ".$TABLE_PREFIX."config VALUES (27,'min_len','10',0,'0')") or die(mysql_error());
mysql_query ("INSERT INTO ".$TABLE_PREFIX."config VALUES (28,'max_len','1024',0,'0')") or die(mysql_error());
mysql_query ("INSERT INTO ".$TABLE_PREFIX."config VALUES (29,'max_word_lenght','40',0,'0')") or die(mysql_error());
mysql_query ("INSERT INTO ".$TABLE_PREFIX."config VALUES (30,'flood_time','60',0,'0')") or die(mysql_error());
mysql_query ("INSERT INTO ".$TABLE_PREFIX."config VALUES (31,'per_page','10',0,'0')") or die(mysql_error());
mysql_query ("INSERT INTO ".$TABLE_PREFIX."config VALUES (32,'max_visitors_online','1',0,'1170642004')") or die(mysql_error());
mysql_query ("INSERT INTO ".$TABLE_PREFIX."config VALUES (33,'gb_title','Free PHP VX Guestbook',0,'0')") or die(mysql_error());
mysql_query ("INSERT INTO ".$TABLE_PREFIX."config VALUES (34,'gb_webpath','http://book',0,'0')") or die(mysql_error());
mysql_query ("INSERT INTO ".$TABLE_PREFIX."config VALUES (35,'copy','Powered by <a href=\"http://phpversion.com\">Free PHP VX Guestbook</a>',1,'1171770911')") or die(mysql_error());
mysql_query ("INSERT INTO ".$TABLE_PREFIX."config VALUES (36,'tzone','0',1,'0')") or die(mysql_error());
mysql_query ("INSERT INTO ".$TABLE_PREFIX."config VALUES (37,'enot','0',0,'0')") or die(mysql_error());
mysql_query ("INSERT INTO ".$TABLE_PREFIX."config VALUES (38,'admin_mail','my@mail.tld',0,'0')") or die(mysql_error());

?>
...Ok<br>
Creating table : <? echo $TABLE_PREFIX . "posts" ;?>
<?
mysql_query ("
CREATE TABLE ".$TABLE_PREFIX."posts (
  pid int(11) unsigned NOT NULL auto_increment,
  date int(11) unsigned NOT NULL default '0',
  text text NOT NULL,
  poster varchar(240) NOT NULL default '',
  location varchar(130) NOT NULL default '',
  posteremail varchar(240) NOT NULL default '',
  msn varchar(25) NOT NULL default '',
  aim varchar(70) NOT NULL default '',
  yim varchar(25) NOT NULL default '',
  homepage varchar(240) NOT NULL default '',
  icq int(11) unsigned default NULL,
  useragent varchar(240) NOT NULL default '',
  gender char(1) NOT NULL default '',
  age varchar(40) NOT NULL default '',
  validated tinyint(1) unsigned NOT NULL default '1',
  c_field_1 varchar(100) NOT NULL default '',
  c_field_2 varchar(100) NOT NULL default '',
  c_field_3 varchar(100) NOT NULL default '',
  c_field_4 varchar(100) NOT NULL default '',
  c_field_5 varchar(100) NOT NULL default '',
  pip varchar(16) NOT NULL default '0',
  PRIMARY KEY (pid)
)") or die(mysql_error());
?>
...Ok<br>
Insert Records to table : <? echo $TABLE_PREFIX . "posts" ;?>
<?
mysql_query ("INSERT INTO ".$TABLE_PREFIX."posts VALUES (1,1169100000,'Thanks for using Free PHP VX Guestook','PHP VX Guestbook','USA','','','','','phpversion.com',NULL,'','M','28',1,'','','','','','0')") or die(mysql_error());
?>
...Ok<br>
Creating table : <? echo $TABLE_PREFIX . "sessions" ;?>
<?
mysql_query ("
CREATE TABLE ".$TABLE_PREFIX."sessions (
  ip varchar(16) default NULL,
  stime int(11) unsigned NOT NULL default '0',
  sname varchar(10) NOT NULL default '0',
  sval varchar(15) NOT NULL default '0',
  PRIMARY KEY  (stime),
  KEY ip_stime_sname (ip,stime,sname)
)") or die(mysql_error());
?>
...Ok<br>
Creating table : <? echo $TABLE_PREFIX . "smilies" ;?>
<?
mysql_query ("
CREATE TABLE ".$TABLE_PREFIX."smilies (
  sid smallint(5) unsigned NOT NULL auto_increment,
  code varchar(50) default NULL,
  smile_url varchar(100) default NULL,
  emoticon varchar(75) default NULL,
  PRIMARY KEY  (sid)
)") or die(mysql_error());
?>
Insert Records to table : <? echo $TABLE_PREFIX . "smilies" ;?>
<?
mysql_query ("INSERT INTO ".$TABLE_PREFIX."smilies VALUES (1,':D','icon_biggrin.gif','Very Happy')") or die(mysql_error());
mysql_query ("INSERT INTO ".$TABLE_PREFIX."smilies VALUES (4,':)','icon_smile.gif','Smile')") or die(mysql_error());
mysql_query ("INSERT INTO ".$TABLE_PREFIX."smilies VALUES (7,':(','icon_sad.gif','Sad')") or die(mysql_error());
mysql_query ("INSERT INTO ".$TABLE_PREFIX."smilies VALUES (10,':o)','icon_surprised.gif','Surprised')") or die(mysql_error());
mysql_query ("INSERT INTO ".$TABLE_PREFIX."smilies VALUES (12,':eek:','icon_surprised.gif','Surprised')") or die(mysql_error());
mysql_query ("INSERT INTO ".$TABLE_PREFIX."smilies VALUES (13,':shock:','icon_eek.gif','Shocked')") or die(mysql_error());
mysql_query ("INSERT INTO ".$TABLE_PREFIX."smilies VALUES (14,':?','icon_confused.gif','Confused')") or die(mysql_error());
mysql_query ("INSERT INTO ".$TABLE_PREFIX."smilies VALUES (17,'8)','icon_cool.gif','Cool')") or die(mysql_error());
mysql_query ("INSERT INTO ".$TABLE_PREFIX."smilies VALUES (20,':lol:','icon_lol.gif','Laughing')") or die(mysql_error());
mysql_query ("INSERT INTO ".$TABLE_PREFIX."smilies VALUES (21,':x','icon_mad.gif','Mad')") or die(mysql_error());
mysql_query ("INSERT INTO ".$TABLE_PREFIX."smilies VALUES (24,':P','icon_razz.gif','Razz')") or die(mysql_error());
mysql_query ("INSERT INTO ".$TABLE_PREFIX."smilies VALUES (27,':oops:','icon_redface.gif','Embarassed')") or die(mysql_error());
mysql_query ("INSERT INTO ".$TABLE_PREFIX."smilies VALUES (28,':cry:','icon_cry.gif','Crying or Very sad')") or die(mysql_error());
mysql_query ("INSERT INTO ".$TABLE_PREFIX."smilies VALUES (29,':evil:','icon_evil.gif','Evil or Very Mad')") or die(mysql_error());
mysql_query ("INSERT INTO ".$TABLE_PREFIX."smilies VALUES (30,':twisted:','icon_twisted.gif','Twisted Evil')") or die(mysql_error());
mysql_query ("INSERT INTO ".$TABLE_PREFIX."smilies VALUES (31,':roll:','icon_rolleyes.gif','Rolling Eyes')") or die(mysql_error());
mysql_query ("INSERT INTO ".$TABLE_PREFIX."smilies VALUES (33,';)','icon_wink.gif','Wink')") or die(mysql_error());
mysql_query ("INSERT INTO ".$TABLE_PREFIX."smilies VALUES (35,':!:','icon_exclaim.gif','Exclamation')") or die(mysql_error());
mysql_query ("INSERT INTO ".$TABLE_PREFIX."smilies VALUES (36,':?:','icon_question.gif','Question')") or die(mysql_error());
mysql_query ("INSERT INTO ".$TABLE_PREFIX."smilies VALUES (37,':idea:','icon_idea.gif','Idea')") or die(mysql_error());
mysql_query ("INSERT INTO ".$TABLE_PREFIX."smilies VALUES (38,':arrow:','icon_arrow.gif','Arrow')") or die(mysql_error());
mysql_query ("INSERT INTO ".$TABLE_PREFIX."smilies VALUES (39,':|','icon_neutral.gif','Neutral')") or die(mysql_error());
mysql_query ("INSERT INTO ".$TABLE_PREFIX."smilies VALUES (42,':mrgreen:','icon_mrgreen.gif','Mr. Green')") or die(mysql_error());
?>
...Ok<br>
Installtion complete. Don't forget to delete an "install" directory.