<?php
session_start();
require_once("functions.php");
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="ISO-8859-4">
<meta name="theme-color" content="#FFEB3B">
<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
<title>Warenkorb - Pfadi Angenstein</title>
<link href="https://fonts.googleapis.com/css?family=PT+Sans:400,700" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="style/normalize.css">
<link rel="stylesheet" type="text/css" href="style/style.css">
<link rel="stylesheet" type="text/css" href="style/colorbox.css">

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="js/jquery.colorbox-min.js"></script>
</head>
<body>
<div class="banner">
	<div class="content">
	 <a href="index.php"><h1><img src="images/angenstein.gif" alt="Logo Pfadi Angenstein">&nbsp;Warenkorb</h1></a>
	 </div>
</div>
<div id="products-wrapper">

 <div class="view-cart">
 	<?php
    $current_url = base64_encode($url="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
	if(isset($_SESSION["products"]))
    {
	    $total = 0;
		echo '<form method="post" action="process.php">';
		echo '<ul>';
		$cart_items = 0;
		foreach ($_SESSION["products"] as $cart_itm)
        {
           $product_code = $cart_itm["code"];
           $mysqli = getDbConnection();
		   $results = $mysqli->query("SELECT product_name,product_desc, price FROM products WHERE product_code='$product_code' LIMIT 1");
		   $obj = $results->fetch_object();
		   
		    echo '<li class="cart-itm">';
			
			echo '<div class="p-price">'.$currency.$obj->price.'</div>';
            echo '<div class="product-info">';
			echo '<h3>'.$obj->product_name.' (Code: '.$product_code.')</h3> ';
            echo '<div class="p-qty">Anzahl : '.$cart_itm["qty"].'</div>';
            echo '<div>'.$obj->product_desc.'</div>';
			echo '</div>';
            echo '</li>';
			$subtotal = ($cart_itm["price"]*$cart_itm["qty"]);
			$total = ($total + $subtotal);

			echo '<input type="hidden" name="item_code['.$cart_items.']" value="'.$product_code.'" />';
			echo '<input type="hidden" name="item_qty['.$cart_items.']" value="'.$cart_itm["qty"].'" />';
			$cart_items ++;
			
        }
    	echo '</ul>';
		echo '<div class="bestelltotal">';
		echo '<strong>Total : '.$currency.$total.'</strong>  ';
		echo '</div>';

		
    }else{
		echo 'Der Warenkorb ist leer. <a href="index.php">Zur&uuml;ck zum Shop.</a>';
	}
	
    ?>
    </div>


	<div class="view-cart">
		<p>Bitte die Bestellung nochmals überprüfen! Falls etwas geändert werden muss, gehen Sie <a href="index.php">zurück zum Shop</a>.</p>
		<p><span class="wichtig"><strong>BITTE BEACHTEN:</strong> Je nach Uniformgrösse kann der Preis der Unifrom geringfügig nach unten schwanken. Der Bekleidungsstellenverantwortliche wird Ihnen alles weitere mitteilen.</span></p>
		<p><span class="wichtig">Die genauen Preise für die Uniformen können <strong><a class='iframe' href="http://www.pfadiangenstein.ch/shop/preise.html">hier</a></strong> nachgeschaut werden.</span></p>
		<p>Wenn die Bestellung in Ordnung ist, klicken Sie auf den untenstehenden Button. Der Bekleidungsstellenverantwortliche wird sich bei Ihnen melden. Geben Sie hierfür bitte noch Ihre Kontaktdaten ein.</p>
		<p>Bei Fragen wenden Sie sich bitte an den Verantwortlichen der Bekleidungsstelle.</p>
		<table>
			<tr>
				<td>Name</td>
				<td><input type="text" name="name" placeholder="Vor- und Nachname" required></td>
			</tr>
			<tr>
				<td>E-Mail</td>
				<td><input type="email" name="email" placeholder="beispiel@domain.ch" required></td>
			</tr>
			<tr>
				<td>Telefon</td>
				<td><input type="number" name="telefon" placeholder="Telefonummer" required></td>
			</tr>
			<tr>
				<td>Bemerkung</td>
				<td><textarea name="bemerkung" placeholder="geschätzte Uniformgrösse, wann am besten Erreichbar usw." rows="5" cols="50"></textarea></td>
			</tr>
		</table>
		<button type="sumbit">Bestellung absenden</button>
	</div>
		<?php echo '</form>'; ?>
</div>

<div class="clear"></div>
<footer>
	<p>&copy; Pfadi Angenstein</p>
</footer>

<script>
$(document).ready(function(){
				//Examples of how to assign the Colorbox event to elements
				
				$(".iframe").colorbox({iframe:true, width:"80%", height:"80%"});
				$(".callbacks").colorbox({
					onOpen:function(){ alert('onOpen: colorbox is about to open'); },
					onLoad:function(){ alert('onLoad: colorbox has started to load the targeted content'); },
					onComplete:function(){ alert('onComplete: colorbox has displayed the loaded content'); },
					onCleanup:function(){ alert('onCleanup: colorbox has begun the close process'); },
					onClosed:function(){ alert('onClosed: colorbox has completely closed'); }
				});

				
				
				//Example of preserving a JavaScript event for inline calls.
				$("#click").click(function(){ 
					$('#click').css({"background-color":"#f00", "color":"#fff", "cursor":"inherit"}).text("Open this window again and this message will still be here.");
					return false;
				});
			});
		</script>

</body>
</html>
