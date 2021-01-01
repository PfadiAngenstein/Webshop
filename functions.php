<?php
	session_start();

	require_once("libs/class.phpmailer.php");
	require_once("libs/class.smtp.php");
	require_once("config.php");

	// Get command
	if(isset($_REQUEST['cmd'])) {
		$db = getDbConnection();
		$cmd = mysqli_real_escape_string( $db, $_REQUEST['cmd'] );
		$db->close();
	}

	// Commands
	if(isset($cmd)) {
		if( $cmd == 'getProducts' ) {
			$return = array("success" => false);

			$products = getProducts();
			if(!is_array($products)) {
				$return["error"] = $db->error;
			} else {
				$return["success"] = true;
				$return["currency"] = $GLOBALS['cfg_db_currency'];
				$return["return_url"] = base64_encode("https://".$_SERVER['HTTP_HOST'].substr($_SERVER['REQUEST_URI'], 0, strrpos($_SERVER['REQUEST_URI'], "/") + 1));
				$return["products"] = $products;
			}
			
			echo json_encode($return);
		}




		if( $cmd == 'getCart' ) {
			$return = array("success" => true);
			$return["return_url"] = base64_encode("https://".$_SERVER['HTTP_HOST'].substr($_SERVER['REQUEST_URI'], 0, strrpos($_SERVER['REQUEST_URI'], "/") + 1));
			$return["products"] = (isset($_SESSION["products"])) ? $_SESSION["products"] : array();
			echo json_encode($_SESSION);
			
			//echo json_encode($return);
		}




		if( $cmd == 'addToCart' ) {
			if(isset($_REQUEST['product_code']) && isset($_REQUEST['product_qty'])) {
				$db = getDbConnection();
				$code = mysqli_real_escape_string($db, $_REQUEST['product_code']);
				$qty = mysqli_real_escape_string($db, $_REQUEST['product_qty']);
				$return = array("success" => addToCart($code, $qty));
				echo json_encode($return);
			} else {
				echo json_encode(array("success" => false));
			}
		}



		if( $cmd == 'getProductDesc' ) {
			$return = array("success" => false);
			
			if(isset($_REQUEST['code'])) {
				$db = getDbConnection();
				$res = $db->query("SELECT product_desc FROM products WHERE product_code='" . mysqli_real_escape_string($db, $_REQUEST['code']) . "'");
				$row = $res->fetch_assoc();
				$return["desc"] = utf8_encode($row['product_desc']);
				$return["success"] = true;
			}

			echo json_encode($return);
		}
	}

	// Functions
	function getDbConnection() {
		$db_username = $GLOBALS['cfg_db_username'];
		$db_password = $GLOBALS['cfg_db_password'];
		$db_name = $GLOBALS['cfg_db_name'];
		$db_host = $GLOBALS['cfg_db_host'];
		return new mysqli($db_host, $db_username, $db_password,$db_name);
	}

	function getProducts() {
		$db = getDbConnection();
		$res = $db->query("SELECT * FROM products ORDER BY id ASC");
		$products = array();
		if($res) {
			while($row = $res->fetch_assoc()) { $products[] = array_map( 'utf8_encode', $row ); }
			return $products;
		} else {
			return $db->error;
		}
	}

	function getProductPrice($code) {
		$products = getProducts();
		return (isset($products[$code])) ? $products[$code]['price'] : false;
	}

	function addToCart($code, $qty) {
		$_SESSION['products'][$code] += $qty;
		$_SESSION['sum'] = getProducts();
		//$_SESSION['sum'] = getProductPrice($code);
		return true;
	}

	function sendMail($replyTo, $subject, $body) {
		$mail = new PHPMailer(true);
		
		try {
			$mail->ClearAllRecipients();
			$mail->addAddress("bekleidungsstelle@pfadiangenstein.ch", "Shop Pfadi Angenstein");
			$mail->setFrom("no-reply@pfadiangenstein.ch", "System");
			$mail->addReplyTo($replyTo["mail"], $replyTo["name"]);
			$mail->Subject	= $subject;
			$mail->Body	= $body;
			$mail->isHTML(true);
			$mail->CharSet	= 'UTF-8';
			$mail->isSMTP();									// Set mailer to use SMTP
			$mail->SMTPDebug = 0;								// 0 = nix, 3 = alles

			// DKIM
			$mail->DKIM_domain = 'pfadiangenstein.ch';
			$mail->DKIM_private = '/var/www/vhosts/pfadiangenstein.ch/.ssh/phpmailer.private.key';
			$mail->DKIM_selector = 'phpmailer';
			$mail->DKIM_passphrase = '';
			$mail->DKIM_identity = $mail->From;

			// $mail->Host = 'mail.pfadiangenstein.ch';			// Specify main and backup SMTP servers
			$mail->Host = 'localhost';							// Specify main and backup SMTP servers
			$mail->Port = 25;									// TCP port to connect to
			$mail->SMTPSecure = 'tls';							// Enable TLS encryption, `ssl` also accepted
			$mail->SMTPOptions = array(
					'ssl' => array(
						'verify_peer'  => true,
						'verify_depth' => 3,
						'allow_self_signed' => true,
						'peer_name' => '*.ssl.hosttech.eu'
					)
				);
			$mail->SMTPAuth = true;								// Enable SMTP authentication
			$mail->Username = $GLOBALS['cfg_smtp_username'];	// SMTP username
			$mail->Password = $GLOBALS['cfg_smtp_password'];	// SMTP password

			try {
				$mail->send();
				return true;
			} catch (phpmailerException $e) {
				return "Fehler: ".$mail->getCustomErrorMessage();
			}
		} catch (Exception $e) {
			return "Fehler: ".$e->getMessage();
		}
	}
?>