<!DOCTYPE html>

    <head>
    <meta charset="ISO-8859-4">
    <style>
body {
	font-family: sans-serif;
}
td {
	border-right: 1px solid black;
}
</style>
    </head>
    <body>
    <?php
      require_once("functions.php");
      require_once("config.php");
      $einleitung = "<h1>Bestellung</h1><p>Im Webshop ist eine neue Bestellung eingegangen. Weitere Details stehen unten.";
      $bestellertitel = "<h2>Besteller</h2>";
      $besteller ='<table style="width:300px;"><tr><td>Name</td><td>'.$_POST['name'].'</td></tr><tr><td>E-Mail</td><td>'.$_POST['email'].'</td></tr><tr><td>Telefon</td><td>'.$_POST['telefon'].'</td></tr><tr><td>Bemerkung</td><td>'.$_POST['bemerkung'].'</td></tr></table>';
      $outro = '<p><br><br><br><small>Bei Fragen: <a href="mailto:kaa@pfadiangenstein.ch">kaa@pfadiangenstein.ch</a></small></p>';

      $products = array(
        "item_code" => $_POST['item_code'],
        "item_qty" => $_POST['item_qty']
      );
      $mysqli = getDbConnection();
      $total = 0;

      $out  = "<h2>Bestellung</h2>";
      $out .= '<table style="width:300px;">';
      $out .= '<tr style="font-weight:900;"><td>Produkt</td><td>Anzahl</td><td>Preis</td></tr>';

      for($i=0;$i<count($products['item_code']);$i++) {
        $results = $mysqli->query("SELECT product_name,price FROM products WHERE product_code='".$products['item_code'][$i]."' LIMIT 1");
        $obj = $results->fetch_object();
        $price = $products['item_qty'][$i] * $obj->price;

        $out .= '<tr>';
        $out .= '<td>'.$obj->product_name.'</td>';
        $out .= '<td>'.$products['item_qty'][$i].'</td>';
        $out .= '<td>'.$price.' '.$GLOBALS['cfg_db_currency'].'</td>';
        $out .= '</tr>';

        $total += $price;
      }
      $out .= '<tr style="font-weight:900;border-top:1px grey solid;"><td>Total</td><td></td><td>'.$total.' '.$GLOBALS['cfg_db_currency'].'</td></tr>';
      $out .= "</table>";

      // echo $bestellertitel;
      // echo $besteller;
      // echo $out;
	 
      $mailtext = $einleitung.$bestellertitel.$besteller.$out.$outro;
      $betreff = "Webshop Pfadi Angenstein: Eine neue Bestellung ist eingegangen.";
      $antwortan = array("mail" => $_POST['email'], "name" => $_POST['name']);

      echo "<pre>";
      if(sendMail($antwortan, $betreff, $mailtext)) {
        header('Location: http://www.pfadiangenstein.ch/shop/danke.php');
      }
      echo "</pre>";
	 ?>
</body>
</html>