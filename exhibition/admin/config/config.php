<?php

	//cms version: 2.4

	//------------------------------------------------------------------------
	//edit those settings below:

	//choose the db type (sqlite,mysql)
	//define("DB_TYPE","sqlite");
	define("DB_TYPE","mysql");
	
	//edit mysql connection proprties , if the DB_TYPE is set to mysql.
	//make sure that the schema (database) you create is empty.
	
	// To use mysql, please change the DB_TYPE to mysql, 
	// and uncomment the lines below (remove /* and */)

	define("MYSQL_HOST","localhost");
	define("MYSQL_USERNAME","smartbus_anna");
	define("MYSQL_PASSWORD","anna123");
	define("MYSQL_DATABASE","smartbus_exhibition");

	// the administrator can access 
	define("ADMIN_USERNAME","admin");		//set administrator username
	define("ADMIN_PASSWORD","smartadmin");		//set administrator password
		
	define("USER_USERNAME","user"); 		//set user username 
	define("USER_PASSWORD","smartuser");
	
	define("ENABLE_LOGIN",false);		   	//set if login required.
		
	//set default view if not logged in.
	//parameters: admin, user.
	define("DEFAULT_VIEW","admin");
	
	define("TEXT_TOP_PRODUCT","Smart Home Group Exhibitions");		//the text that appears on the top panel in the left.
	define("TEXT_TITLE_BASE","Smart Home Group Exhibitions");		//the text that used as the base of the title
	
	define("TEXT_LOGIN_WELLCOME_MESSAGE","<b> Smart Home Group Exhibitions</b>");		//set text of login welcome message
	define("TEXT_WELCOME_ADMIN","Hello Administrator");		//set text displayed on the top right corner of the admin		
	define("TEXT_WELCOME_USER","Hello User");	//set text displayed on the top right corner of the user
		
	//Add presets (id,title)	
	/*
	addPreset("example1","Example 1");
	addPreset("example2","Example 2");
	*/
	
	//set the active theme (from themes folder -theme name as folder name)  
	define("ACTIVE_THEME","blue");	
	
	define("ADMIN_FILE","main.php");
	define("GALLERY_FILE","gallery.php");
	
	//image quality when resized, max - 100. more quality, more storage cache size needed. 
	define("IMAGE_QUALITY",95);
		
?>