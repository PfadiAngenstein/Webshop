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
$einleitung = "<h1>Bestellung</h1><p>Im Webshop ist eine neue Bestellung eingegangen. Weitere Details stehen unten.";
  $bestellertitel = "<h2>Besteller</h2>";
  $besteller ="<table><tr><td>Name</td><td>".$_POST['name']."</td></tr><tr><td>E-Mail</td><td>".$_POST['email']."</td></tr><tr><td>Telefon</td><td>".$_POST['telefon']."</td></tr><tr><td>Bemerkung</td><td>".$_POST['bemerkung']."</td></tr></table>";
  $outro = "<p><br><br><br><small>Bei Fragen: kaa@pfadiangenstein.ch</small></p>";
  ;

	$myarray = array("key1"=>$_POST['item_name'],
                 "key2"=>$_POST['item_qty'],
                 "key3"=>$_POST['price']); //Having a key or not doesn't break it
$out  = "<h2>Bestellung</h2>";
$out .= "<table>";

foreach($myarray as $key => $element){
    $out .= "<tr>";
    foreach($element as $subkey => $subelement){
        $out .= "<td>$subelement</td>";
    }
    $out .= "</tr>";
}
$out .= "</table>";

// echo $bestellertitel;
// echo $besteller;
// echo $out;
	 
$mailtext = $einleitung.$bestellertitel.$besteller.$out.$outro;

$empfaenger = "shop@pfadiangenstein.ch";
$absender = "no-reply@pfadiangenstein.ch";
$betreff = "Webshop: Eine neue Bestellung ist eingegangen.";
$antwortan = "shop@pfadiangenstein.ch";

$header  = "MIME-Version: 1.0\r\n";
$header .= "Content-type: text/html; charset=iso-8859-1\r\n";

$header .= "From: $absender\r\n";
$header .= "Reply-To: $antwortan\r\n";
// $header .= "Cc: $cc\r\n";  // falls an CC gesendet werden soll
$header .= "X-Mailer: PHP ". phpversion();
 
mail( $empfaenger,
      $betreff,
      $mailtext,
      $header);
 
echo "Bestellung wurde gesendet!";
header('Location: http://www.pfadiangenstein.ch/shop/danke.php');
	 ?>
</body>
</html>
