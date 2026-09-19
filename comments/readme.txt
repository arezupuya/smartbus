//===========================================================================\\
// Free PHP VX Guestbook                                                     \\
// Copyright (c) 2008 PHPVersion.Com.  All rights reserved.                  \\
//---------------------------------------------------------------------------\\
// http://phpversion.com/                                                    \\
//---------------------------------------------------------------------------\\
// This program is free software; you can redistribute it and/or modify it   \\
// under the terms of the GNU General Public License as published by the     \\
// Free Software Foundation; either version 2 of the License, or (at your    \\
// option) any later version.                                                \\
//                                                                           \\
// This program is distributed in the hope that it will be useful, but       \\
// WITHOUT ANY WARRANTY; without even the implied warranty of                \\
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General \\
// Public License for more details.                                          \\
//===========================================================================\\

Official Website... http://phpversion.com/
Support Forum...... http://phpversion.com/forums/


--------------------------
QUICK INSTALL INSTRUCTIONS
--------------------------
1. Upload all files and directories to your web server
2. Open and edit "config.php" , set correct values for variables
	$MYSQL_HOST = "localhost"; // Usually localhost
	$MYSQL_DATABASE = "";
	$MYSQL_USER = "";
	$MYSQL_PASS = "";
	$TABLE_PREFIX = "vxg_";
3. Upload correct "config.php" to your web server
4. Open "install/install.php" from your web browser , if you have no errors you can go to the item #5
5. Open "admin" directory from your browser, 
	DEFAULT Administrator : admin
	DEFAULT Password      : admin
    Login to "Administrator Control Panel" and change default password.
6. Now you can use "Free PHP VX Guestbook"



-----------------------------------------
SIMPLE CHANGELOG WITH UPDATE INSTRUCTIONS
-----------------------------------------
1.06 -> 1.07
  Fixed : Security in several files.

  Just replace these files
  /index.php

  /admin/backupdb.php
  /admin/index.php
  /admin/header.php

1.05 -> 1.06
  Added   : Add message fields are automatically filled after post action.

  Just replace these files
  /add_message.php

  1. Login to FTP server , go to templates directory , create directory "subsilver"
  2. Copy directory and all files from archive /templates/subsilver/ to your ftp server 
  3. Login to control panel and change guestbook theme from bluetheme to subsilver

  * subsilver is the default guestbook theme , bluetheme is unsupported now.

1.04 -> 1.05
  Added   : Ability to add new smiles

  Just replace these files
  /admin/smilies.php
  /template/bluetheme/smilies.tpl

1.03 -> 1.04
  Added   : Required fields indicator

  Just replace these files
  /add_message.php
  /template/bluetheme/add_message.tpl
  /language/english.php

1.02 -> 1.03
  Added   : Search Function 
  Changed : Captcha 

  Update instruction :
  Just replace these files
  /captcha.php
  /index.php
  /template/bluetheme/index.tpl
  /include/function.php
  /language/english.php
  /images/code_bg.png 

1.0 - > 1.01
-------------------------------------
1.01 -> 1.02
  Added : Timezone configuration
  Added : E-Mail Notification

  Update instruction :
  1. Upload all files , EXCLUDE config.php (Don't upload config.php)
  2. Open with browser "101to102sql.php" from "install" directory to update SQL tables.


1.0 - > 1.01
-------------------------------------
  Added : GDLib checking
  Fixed : Input data control
  Fixed : GZIP Compression output

  List of Fixed Files :
  /header.php
  /include/function.php
  /admin/header.php
  /add_message.php
  /admin/admin.php
  /language/english.php
  /template/bluetheme/admin/admin.tpl
-------------------------------------	