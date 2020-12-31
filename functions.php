<?php
	require_once("libs/class.phpmailer.php");
	require_once("libs/class.smtp.php");
	require_once("config.php");

	function getDbConnection() {
		$db_username = $GLOBALS['cfg_db_username'];
		$db_password = $GLOBALS['cfg_db_password'];
		$db_name = $GLOBALS['cfg_db_name'];
		$db_host = $GLOBALS['cfg_db_host'];
		return new mysqli($db_host, $db_username, $db_password,$db_name);
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