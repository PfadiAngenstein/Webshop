<!DOCTYPE html>
	<head>
		<meta charset="utf-8">
		<meta name="theme-color" content="#FFEB3B">
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">

		<title>Warenkorb - Pfadi Angenstein</title>

		<link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=PT+Sans:400,700">
		<link rel="stylesheet" type="text/css" href="style/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="style/style.css">
	</head>

	<body>
		<div class="banner">
			<div class="content">
			 <a href="index.php"><h1><img src="images/angenstein.gif" alt="Logo Pfadi Angenstein">&nbsp;Warenkorb</h1></a>
			 </div>
		</div>


		<div id="products-wrapper">
			<form id="form-submit-order" method="post" action="process.php">
				<div class="view-cart" id="shopping-cart-detail">
					<ul>
						<!-- cart items get added here by js -->
					</ul>

					<div class="cart-empty">Der Warenkorb ist leer :(</div>

					<div class="bestelltotal">
						<strong>Total : <span id="cart-total">0</span></strong>
					</div>
				</div>

				<div class="cart-empty hidden">
					Der Warenkorb ist leer. <a href="index.php">Zurück zum Shop.</a>
				</div>


				<div class="view-cart">
					<p>Bitte die Bestellung nochmals überprüfen! Falls etwas geändert werden muss, gehen Sie <a href="index.php">zurück zum Shop</a>.</p>
					<p><span class="wichtig"><strong>BITTE BEACHTEN:</strong> Je nach Uniformgrösse kann der Preis der Unifrom geringfügig nach unten schwanken. Der Bekleidungsstellenverantwortliche wird Ihnen alles weitere mitteilen.</span></p>
					<p><span class="wichtig">Die genauen Preise für die Uniformen können <strong><a class='iframe' href="https://www.pfadiangenstein.ch/shop/preise.html">hier</a></strong> nachgeschaut werden.</span></p>
					<p>Wenn die Bestellung in Ordnung ist, klicken Sie auf den untenstehenden Button. Der Bekleidungsstellenverantwortliche wird sich bei Ihnen melden. Geben Sie hierfür bitte noch Ihre Kontaktdaten ein.</p>
					<p>Bei Fragen wenden Sie sich bitte an den Verantwortlichen der Bekleidungsstelle.</p>
					<table>
						<tr>
							<td>Name</td>
							<!--<td><input type="text" name="name" placeholder="Vor- und Nachname" required></td>-->
							<td><input type="text" name="name" placeholder="Vor- und Nachname"></td>
						</tr>
						<tr>
							<td>E-Mail</td>
							<!--<td><input type="email" name="email" placeholder="beispiel@domain.ch" required></td>-->
							<td><input type="email" name="email" placeholder="beispiel@domain.ch"></td>
						</tr>
						<tr>
							<td>Telefon</td>
							<!--<td><input type="number" name="telefon" placeholder="Telefonummer" required></td>-->
							<td><input type="number" name="telefon" placeholder="Telefonummer"></td>
						</tr>
						<tr>
							<td>Bemerkung</td>
							<td><textarea name="bemerkung" placeholder="geschätzte Uniformgrösse, wann am besten Erreichbar usw." rows="5" cols="50"></textarea></td>
						</tr>
					</table>
					<button type="sumbit">Bestellung absenden</button>
				</div>
			</form>
		</div>



		<div class="clear"></div>


		<footer>
			<p>&copy; Pfadi Angenstein</p>
		</footer>


		<script src="js/jquery-3.5.1.min.js"></script>
		<script src="js/jquery.colorbox-min.js"></script>
		<script src="js/script.js"></script>


		<!-- TEMPLATES -->
		<li class="cart-itm hidden" id="cart-itm-template">
			<div class="p-price"></div>
			<div class="product-info">
				<h3></h3> 
				<div class="p-qty">Anzahl : <span></span></div>
				<div class="p-desc"></div>
			</div>
		</li>


	</body>
</html>
