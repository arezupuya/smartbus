<?php
	session_start();
	define("TEXT_LOGIN_BUTTON","Log in");											// set text of the login button
	define("TEXT_USERNAME","Username:");											//set username text
	define("TEXT_PASSWORD","Password:");											// set password text
	define("TEXT_WRONG_USERNAME_PASSWORD","Wrong username or password!!!");			//set text of wrong username or password
	
	define("COOKIE_ENABLED",false);		//if the cookie enabled, the application stays in login state as long as the cookie is set
	define("COOKIE_EXPIRE_DAYS",30);	// tells when the cookie will expire
	
	//======================================================================================
	//system variables and functions - editing them not recomended.
	
	define("LOGIN_STATE_LOGGEDIN","1");		//user logged
	define("LOGIN_STATE_LOGGEDOUT","2");	//user just loged out
	define("LOGIN_STATE_WRONG","3");		//user typed a wrong username or password
	define("LOGIN_STATE_NORMAL","4");		//user has not wrote every thing
	
	define("LOGIN_PERMISSIONS_ADMIN","admin");
	define("LOGIN_PERMISSIONS_USER","user");
	
	//set the cookie to expire in some time. if time not given, expire in some days defined in config.php
	function setMyCookie($name,$value,$time = -1){		
		$days = 30;		//default cookie value
		if(defined("COOKIE_EXPIRE_DAYS")) $days = COOKIE_EXPIRE_DAYS;
		if($time != -1) $timeToEnd = $time;
		else $timeToEnd = time()+60*60*24*$days;
		setcookie($name,$value,$timeToEnd);
	}
	
	////////////////////////////////////////////////////////////////////////////////////////////////	
	
	function deleteMyCookie($name){
		setcookie($name,"",time()-3600);		
	}
	
	//return the login state from database, and from admin var, and return the login state with the database installed state.
	function getLogInState(){
			$state = LOGIN_STATE_NORMAL;
			//cehck logout
			if(isset($_POST["logout"]) && $_POST["logout"] == "true"){					
					unset($_SESSION["permission"]);
					unset($_SESSION["userID"]);
					$state = LOGIN_STATE_LOGGEDOUT;
					deleteMyCookie("userID");
					return($state);
			}
			
			//check if already connected
			if($state == LOGIN_STATE_NORMAL){
				if(isset($_SESSION["userID"]) && $_SESSION["userID"]==1){	//if exists session - the user logged in
					$state = LOGIN_STATE_LOGGEDIN;
					return($state);
				}
				else if(isset($_COOKIE["userID"]) ){		//if exists cookie - the user logged in, update session.
					$_SESSION["userID"] = $_COOKIE["userID"];
					$state = LOGIN_STATE_LOGGEDIN;
					return($state);
				}
			}			
			
			$userID = 0;
			
			//In case of login command - check username and password
			if(isset($_POST["txtLoginServiceUsername"])&& isset($_POST["txtLoginServicePassword"]) && $state == LOGIN_STATE_NORMAL){
				//check root username and password (defined in config.php)
				if($_POST["txtLoginServiceUsername"] == ADMIN_USERNAME && $_POST["txtLoginServicePassword"] == ADMIN_PASSWORD
					|| $_POST["txtLoginServiceUsername"] == USER_USERNAME && $_POST["txtLoginServicePassword"] == USER_PASSWORD){
						
					switch($_POST["txtLoginServiceUsername"]){
						case ADMIN_USERNAME:
							$_SESSION["permission"] = LOGIN_PERMISSIONS_ADMIN;
						break;
						case USER_USERNAME:
							$_SESSION["permission"] = LOGIN_PERMISSIONS_USER;
						break;
						default:
							echo "wrong loing info, pelase turn to support";
							exit();
						break;
					}
					
					$_SESSION["userID"] = 1;
					
					setMyCookie("userID",1);
					$state = LOGIN_STATE_LOGGEDIN;
					return($state);
				}
				else{	//admin user failed and the database not installed
					$_SESSION["userID"] = 0;
					$state = LOGIN_STATE_WRONG;
					return($state);											
				}													
			}
		return($state);
	}
	
	//////////////////////////////////////////////////////////////////////////////////////////////////////	
	
	function drawLoggedInText(){
		//draw login text:
		if(USER_PERMISSION == LOGIN_PERMISSIONS_ADMIN) echo TEXT_WELCOME_ADMIN;
		 else echo TEXT_WELCOME_USER;
		
		//draw logout text and functions.
		if(ENABLE_LOGIN):
			echo ', &nbsp;';
			?>			
				<a href="#" onClick="document.getElementById('headerLoginForm').submit()"> Log Out</a>
				<Form action="<?php echo $_SERVER["PHP_SELF"] ?>" method="post" name="headerLoginForm" id="headerLoginForm" style="display:none">
					<input type="hidden" name="logout" value="true"></input>
					<input type="hidden" name="txtLoginServiceUsername"></input>
					<input type="hidden" name="txtLoginServicePassword"></input>
				</Form>
			<?php
		endif;			 		 
	}
	
	//////////////////////////////////////////////////////////////////////////////////////////////////////	
	// main function
	function drawHeaderLogin($state=LOGIN_STATE_NORMAL){
			$displayUsername = "";
			if(isset($_POST["txtLoginServiceUsername"]) && strlen($_POST["txtLoginServiceUsername"])>0) $displayUsername = $_POST["txtLoginServiceUsername"];
		?>
		<html>
			<style type="text/css">
			
				body{
					font-family:verdana;
				}
				
				.divWrapper{					
					width:300px;
					border:1px solid #D3D3D3;
					background-color:#ffffff;
					padding-top:15px;
					padding-bottom:10px;
					padding-left:10px;
					padding-right:10px;
					-moz-border-radius-bottomleft:4px;
					-moz-border-radius-bottomright:4px;
					-moz-border-radius-topleft:4px;
					-moz-border-radius-topright:4px;
				}
				
				.divWelcomeText{
					font-size:16px;
				}
				
				.border{
					border:1px solid blue;
				}
				
				.divMain{
					padding-top:100px;					
				}
				
				.divLoginBox{
					background-color:#EAF3FA;
					padding-top:15px;
					padding-bottom:15px;
					-moz-border-radius-bottomleft:4px;
					-moz-border-radius-bottomright:4px;
					-moz-border-radius-topleft:4px;
					-moz-border-radius-topright:4px;
				}
					
				.textLogin{	
					font-weight:bold;
					font-size:12px;					
				}
				
				.textError{
					color:red;
					font-size:12px;
				}
				
				.inputLogin{
					width:100%;
					border:1px solid #D3D3D3;
					height:28px;
					font-size:16px;
					padding:3px;
					color:#000000;
					-moz-border-radius-bottomleft:4px;
					-moz-border-radius-bottomright:4px;
					-moz-border-radius-topleft:4px;
					-moz-border-radius-topright:4px;
				}
				
				.inputLogin:focus{
					border-color:#767070;
				}

				.buttonLogin{
					border:1px solid #80B5D0;
					background-color:#CEE1EF;
					color:000000;
					font-size:14px;
					padding-top:3px;
					padding-bottom:3px;
					padding-left:5px;
					padding-right:5px;
					cursor:pointer;
					-moz-border-radius-bottomleft:4px;
					-moz-border-radius-bottomright:4px;
					-moz-border-radius-topleft:4px;
					-moz-border-radius-topright:4px;
				}
				
				.buttonLogin:hover{
					background-color:#92BDDC;
					border-color:#458FC3;					
					color:white;
				}
				
			</style>
			
			<head>
				<script language="javascript">							
						
						function loginFormKeyUp(e){
							if(e.keyCode==13) document.getElementById('frmLogin').submit()
						}
						
						<?php if($state == LOGIN_STATE_WRONG):?>
							function hideErrorMessage(){
								document.getElementById("tableErrorMessage").style.display = "none";
								return(false);
							}
							setTimeout(hideErrorMessage,3000);
						<?php endif ?>

				</script>
			</head>
			<body onload="document.getElementById('txtLoginUsername').focus()">
				<Form action="<?php echo $_SERVER["PHP_SELF"];?>" method="post" id="frmLogin" >
					<input type="hidden" name="logout" value="false"></input>			
					<div align="center" class="divMain">
						<div class="divWrapper" align="center">
							<Table cellpadding="0" cellspacing="0" width="100%">
								<Tr>
									<Td>
										<div class="divWelcomeText" align="center">
											<?php echo TEXT_LOGIN_WELLCOME_MESSAGE?>
										</div>
									</Td>
								</Tr>
								<Tr><Td height="20px"></Td></Tr>	<!--vertical saporator -->
								<Tr>
									<Td>
											<div class="divLoginBox" align="center">
												<Table cellpadding="0" cellspacing="0" width="90%">
													<Tr>
														<Td class="textLogin">
															<?php echo TEXT_USERNAME?>														
														</Td>
													</Tr>
													<tr><td height="2px;"></td></tr>
													<Tr>
														<Td>
															<input type="text" class="inputLogin" id="txtLoginUsername" name="txtLoginServiceUsername" value="<?php echo $displayUsername;?>" onKeyUp="loginFormKeyUp(event)"></input>
														</Td>
													</Tr>
													<tr><td height="20px;"></td></tr>
													<Tr>
														<Td class="textLogin">
															<?php echo TEXT_PASSWORD ?>
														</Td>			
													</Tr>
													<tr><td height="2px;"></td></tr>
													<Tr>
														<Td>
															<input type="password" class="inputLogin" name="txtLoginServicePassword" onKeyUp="loginFormKeyUp(event)"></input>
														</Td>
													</Tr>
													<tr><td height="20px;"></td></tr>
													<Tr>
														<Td colspan="3" align="center">
															<input type="submit" class="buttonLogin" value="<?php echo TEXT_LOGIN_BUTTON?>" id="txtLoginServiceLoginButton"></input>
														</Td>	
													</Tr>
													<?php
													if($state == LOGIN_STATE_WRONG):?>
													<Tr>
														<Td align="center">
															<div class="textError" id="tableErrorMessage" style="padding-top:8px;">
																<?php echo TEXT_WRONG_USERNAME_PASSWORD?>
															</div>
														</Td>
													</Tr>						  
													 <?php
													 endif?>
												</Table>
										</div>
									</Td>
								</Tr>
							</Table>			
						</div>
					</div>	<!-- main div -->
				</Form>
			
			</body>
		</html>
		<?php
	}//drawHeaderLogin function
	
	if(ENABLE_LOGIN == true){
		$state = getLogInState();
		if($state == LOGIN_STATE_LOGGEDIN){	//if logged in - set permissions
			if( isset($_SESSION["permission"]) && $_SESSION["permission"] == LOGIN_PERMISSIONS_USER)
				$permission = LOGIN_PERMISSIONS_USER;
			else
				$permission = LOGIN_PERMISSIONS_ADMIN;
		}	
		else{		//if not logged in - draw the login box
			drawHeaderLogin($state);
			exit();
		}
		
	}
	else{		//no login needed - set default permissions 		
		//set permission
		if(defined("DEFAULT_VIEW")){
			if(DEFAULT_VIEW == "admin")
				$permission = LOGIN_PERMISSIONS_ADMIN;
			else 
				$permission = LOGIN_PERMISSIONS_USER;
		}
		else{
			$permission = LOGIN_PERMISSIONS_ADMIN;
		}
	}//else
	
	define("USER_PERMISSION",$permission);
	
?>