<?php
/*
phpFastNews 1.0.0
Last update: 02 Sep 2008

Skipping the blah-blah-blah I kindly ask you to keep the link back to phpFastNews website. Thanks!
*/

include_once( dirname(__FILE__) . '/fastnews-conf.php' );
define( 'DATAFILE', dirname(__FILE__) . '/fastnews-data.txt' );

$JAVASCRIPT = <<<EOT
<SCRIPT LANGUAGE="JavaScript">
function fn_HideElement( elementName ){
	ele = document.getElementById( elementName );
	if( ! ele ){
		alert( 'cannot find ' + elementName );
		return;
		}
	ele.style.display = "none";
	}
function fn_ShowElement( elementName ){
	ele = document.getElementById( elementName );
	if( ! ele ){
		alert( 'cannot find ' + elementName );
		return;
		}
	ele.style.display = "block";
	}
</SCRIPT>
EOT;

/* PROCESS ACTION */
$action = ( isset($_REQUEST['fn_action']) ) ? $_REQUEST['fn_action'] : '';
if( $action ){
	$fn = new fastNews;
	// NO ACTION IF NOT LOGGED IN
	if( $fn->isLoggedIn() || ($action == 'login') ){
		switch( $action ){
			case 'login':
				$password = $_POST['password'];
				if( $fn->checkPassword($password) )
					$fn->doLogin();
				else {
					$fn->displayError( 'Incorrect Password!' );
					exit;
					}
				break;
			case 'logout':
				$fn->doLogout();
				break;
			case 'add':
				$newItem = $fn->grabData();
				$fn->addItem( $newItem );
				$fn->save();
				break;
			case 'update':
				$newItem = $fn->grabData();
				$itemId = $newItem['id'];
				$fn->updateItem( $itemId, $newItem );
				$fn->save();
				break;
			case 'delete':
				$itemId = $_REQUEST['id'];
				$fn->deleteItem( $itemId );
				$fn->save();
				break;
			}
		}

	/* REDIRECT BACK TO THE REFERRER */
	$referrer = $_SERVER['HTTP_REFERER'];
	header( "Location: $referrer" );
	exit;
	}

class fastNews {
	var $news = array();

	function fastNews(){
		$this->news = array();
		$this->load();
		}

	function checkPassword( $pass ){
		if( $pass == FN_PASSWORD )
			return true;
		else
			return false;
		}

	function doLogin(){
		setcookie( FN_COOKIE_NAME, '1', time() + FN_COOKIE_EXPIRES );
		}

	function doLogout(){
		setcookie( FN_COOKIE_NAME, '', time() -1 );
		}

	function isLoggedIn(){
		if( isset($_COOKIE[FN_COOKIE_NAME]) && $_COOKIE[FN_COOKIE_NAME] )
			return true;
		else
			return false;
		}

	function grabData(){
		$subject = $_POST['subject'];
		$message = $_POST['message'];
		if( get_magic_quotes_gpc() ){
			$subject = stripslashes( $subject );
			$message = stripslashes( $message );
			}
		$itemId = isset($_POST['id']) ? $_POST['id'] : 0;

		$data = array(
			'subject'	=> $subject,
			'message'	=> $message,
			'id'		=> $itemId,
			);

		return $data;
		}
		
	function addItem( $item ){
//		$date = date( "j M Y H:i", time() );
		$date = date( "j M Y g:i a", time() );

		$item['date'] = $date;
		$this->news[] = $item;
		}

	function updateItem( $id, $newItem ){
		$item = $this->news[$id - 1];
		$item = array_merge( $item, $newItem );
		$this->news[ $id - 1 ] = $item;
		}

	function deleteItem( $id ){
		array_splice( $this->news, $id - 1, 1 );
		}

	function save(){
		// CHECK IF THE DATA FILE EXISTS
		if( ! file_exists(DATAFILE) ){
			$this->error( 'Datafile missing! Please create a new empty file <B>' . DATAFILE . '</B> and make chmod 666' );
			return;
			}
		// CHECK IF THE DATA FILE IS WRITABLE
		if( ! is_writable(DATAFILE) ){
			$this->error( 'Datafile is not writable! Please make chmod 666 for the <B>' . DATAFILE . '</B> file.' );
			return;
			}

		$this->setToFile( DATAFILE );
		}

	function load(){
		// CHECK IF THE DATA FILE EXISTS
		if( ! file_exists(DATAFILE) ){
			$this->error( 'Datafile missing! Please create a new empty file <B>' . DATAFILE . '</B> and make chmod 666' );
			return;
			}

		// LOAD THE DATA FILE
		$this->getFromFile( DATAFILE );
		}

	function display(){
		global $NEWS_ITEM, $NEWS_LIST, $JAVASCRIPT;
		$CODE_URL = FN_CODE_URL;

		$view = '';
		$items = '';
		$itemId = count($this->news) + 1;

		// ORDER IN REVERSE
		reset( $this->news );
		foreach( array_reverse($this->news) as $n ){
			$itemId--;
			if( $this->isLoggedIn() ){
				$editLinks = <<<EOT
<A HREF="#" ONCLICK="fn_ShowElement('fn-edit-$itemId'); fn_HideElement('fn-view-$itemId'); return false;">Edit</A>
<A HREF="$CODE_URL?fn_action=delete&id=$itemId" ONCLICK="return confirm('Are you sure to delete this news item?')">Delete</A>
EOT;
				}
			else {
				$editLinks = '';
				}

			$formSubject = htmlentities( $n['subject'] );
			$replaces = array(
				'{SUBJECT}'			=> $n['subject'],
				'{FORM_SUBJECT}'	=> $formSubject,
				'{DATE}'			=> $n['date'],
				'{MESSAGE}'			=> $n['message'],
				'{ITEM_ID}'			=> $itemId,
				'{EDIT_LINKS}'		=> $editLinks,
				'{CODE_URL}'		=> FN_CODE_URL,
				);
			$itemDisplay = str_replace( array_keys($replaces), array_values($replaces), $NEWS_ITEM );
			$items .= $itemDisplay;
			}

		if( $this->isLoggedIn() ){
			$addLink = <<<EOT
<A ID="fn-addBar" HREF="#" ONCLICK="fn_ShowElement('fn-addForm'); fn_HideElement('fn-addBar'); return false;">Add News Item</A>
EOT;
			}
		else {
			$addLink = '';
			}

		if( $this->isLoggedIn() ){
			$loginLink = <<<EOT
<A HREF="$CODE_URL?fn_action=logout">Logout</A>
EOT;
			}
		else {
			$loginLink = <<<EOT
<A ID="fn-loginBar" HREF="#" ONCLICK="fn_ShowElement('fn-loginForm'); fn_HideElement('fn-loginBar'); return false;" style="color: #666; font-weight:bold;">NEWS UPDATE</A>
EOT;
			}

		// ADD UP OUR CREDENTIALS
		$copyright = <<<EOT
<DIV STYLE="font-size: 0.75em; margin: 1em 0 0 0;"></DIV>

EOT;
		$items = $items . "\n" . $copyright;

		$replaces = array(
			'{NEWS_ITEMS}'	=> $items,
			'{ADD_LINK}'	=> $addLink,
			'{LOGIN_LINK}'	=> $loginLink,
			'{CODE_URL}'	=> FN_CODE_URL,
			);
		$view = str_replace( array_keys($replaces), array_values($replaces), $NEWS_LIST );

		$view = $JAVASCRIPT . "\n" . $view;

		return $view;
		}

	function setToFile( $fileName ){
		reset( $this->news );
		$content = '';
		foreach( $this->news as $n ){
			if( ! $n )
				continue;
			$content .= 'ITEM_START' . "\n";
			$content .= $n['date'] . "\n";
			$content .= $n['subject'] . "\n";
			$content .= $n['message'] . "\n";
			$content .= 'ITEM_END' . "\n";
			}
		setFileContent( DATAFILE, $content );
		}

	function getFromFile( $fileName ){
		$fileContentArray = file( $fileName );
		reset( $fileContentArray );
		$lineIndex = 0;
		foreach( $fileContentArray as $line ){
			$line = trim( $line );
			if( ! $line )
				continue;

			if( $line == 'ITEM_END' ){
				$this->news[] = $item;
				continue;
				}

			if( $line == 'ITEM_START' ){
				$item = array();
				$lineIndex = 1;
				}
			else {
				// PARSE LINE
				switch( $lineIndex ){
					case 1:
						$key = 'date';
						break;
					case 2:
						$key = 'subject';
						break;
					default:
						$key = 'message';
						break;
					}

				if( isset($item[$key]) )
					$item[$key] .= $line;
				else
					$item[$key] = $line;
				
				$lineIndex++;
				}
			}
		}
		
	function displayError( $msg ){
		echo $msg;
		/* REDIRECT BACK TO THE REFERRER */
		$referrer = $_SERVER['HTTP_REFERER'];
		echo <<<EOT
<meta http-equiv="Refresh" content="1; URL=$referrer">
EOT;
		}

	function error( $msg ){
		echo 'Error: ' . $msg;
		}
	}
?>
<?php
function _print_r( $thing ){
	echo '<PRE>';
	print_r( $thing );
	echo '</PRE>';
	}

function setFileContent( $fileName, $content ){
	$length = strlen( $content );
	$f = fopen( $fileName, 'w' );
	$result = fwrite($f, $content, $length);
	fclose( $f );
	}
?>