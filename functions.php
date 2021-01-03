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
				$return["products"] = $products;
			}
			
			echo json_encode($return);
		}




		if( $cmd == 'getCart' ) {
			$return = array("success" => true);
			$return["products"] = getProductArray();
			$return["sum"] = getProductsSum($return["products"]);
			$return["sum_text"] = $return["sum"] . " " . $GLOBALS["cfg_db_currency"];
			
			echo json_encode($return);
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




		if( $cmd == 'removep' ) {
			if(isset($_REQUEST['code'])) {
				$db = getDbConnection();
				$code = mysqli_real_escape_string($db, $_REQUEST['code']);
				echo json_encode(array("success" => removeFromCart($code)));
			}
		}




		if( $cmd == 'submitOrder' ) {
			$db = getDbConnection();
			$info = array();

			if(isset($_REQUEST['name'])) { 		$info['name'] 		= mysqli_real_escape_string($db, $_REQUEST['name']); }
			if(isset($_REQUEST['email'])) { 	$info['email'] 		= mysqli_real_escape_string($db, $_REQUEST['email']); }
			if(isset($_REQUEST['telefon'])) { 	$info['phone'] 		= mysqli_real_escape_string($db, $_REQUEST['telefon']); }
			if(isset($_REQUEST['bemerkung'])) { $info['comment'] 	= mysqli_real_escape_string($db, $_REQUEST['bemerkung']); }

			$info["sum"] = getProductsSum(getProductArray());
			$info["sum_text"] = $info["sum"] . " " . $GLOBALS["cfg_db_currency"];
			
			echo json_encode(array("success" => submitOrder($info)));
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
			while($row = $res->fetch_assoc()) {
				$products[] = array(
					"product" => array_map( 'utf8_encode', $row ),
					"sizes" => getProductSizes($row["product_code"])
				);
			}
			return $products;
		} else {
			return $db->error;
		}
	}

	function getProductName($code) {
		$products = getProducts();
		$found = false;
		foreach ($products as $product) {
			if($product['product']['product_code'] == $code) {
				$found = true;
				$name = $product['product']['product_name'];
				break;
			}
		}
		return ($found) ? $name : false;
	}

	function getProductPrice($code) {
		$products = getProducts();
		$found = false;
		foreach ($products as $product) {
			if($product['product']['product_code'] == $code) {
				$found = true;
				$price = floatval($product['product']['price']);
				break;
			}
		}
		return ($found) ? $price : false;
	}

	function getProductSizes($code) {
		$sizes = array();
		$db = getDbConnection();
		$res = $db->query("SELECT * FROM shop_sizes WHERE fk_product=(SELECT id from products WHERE product_code='$code' LIMIT 1)");
		if($res->num_rows > 0) {
			while($row = $res->fetch_assoc()) {
				$sizes[] = array_map('utf8_encode', $row);
			}
		}
		return $sizes;
	}

	function getProductArray() {
		if(isset($_SESSION["products"])) {
			$products = array();
			foreach ($_SESSION["products"] as $code => $qty) {
				$products[] = array(
					"name" => getProductName($code),
					"code" => $code,
					"qty" => $qty,
					"price" => getProductPrice($code),
					"price_text" => getProductPrice($code) . " " . $GLOBALS["cfg_db_currency"]
				);
			}
			return $products;
		} else {
			return array();
		}
	}

	function getProductsSum($products) {
		$sum = 0;
		foreach ($products as $product) {
			$sum += $product['price'] * $product['qty'];
		}
		return $sum;
	}

	function addToCart($code, $qty) {
		$_SESSION['products'][$code] = (isset($_SESSION['products'][$code])) ? $_SESSION['products'][$code] + $qty : $qty;
		return true;
	}

	function removeFromCart($code) {
		unset($_SESSION['products'][$code]);
		return true;
	}

	function emptyCart() {
		unset($_SESSION['products']);
		return true;
	}

	function submitOrder($info) {
		$order = $info;
		$order["products"] = getProductArray();
		$mailHtml = include("mail_template.php");
		$subject = "Webshop Pfadi Angenstein: Eine neue Bestellung ist eingegangen.";
		$replyTo = array("mail" => $info['email'], "name" => $info['name']);
//		if(sendMail($replyTo, $subject, $mailHtml)) {
			emptyCart();
			return true;
//		} else {
//			return false;
//		}
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