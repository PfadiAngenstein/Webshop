<h1>Bestellung</h1>
<p>Im Webshop ist eine neue Bestellung eingegangen. Weitere Details stehen unten.</p>
<h2>Besteller</h2>
<table style="width:300px;">
	<tr>
		<td>Name</td>
		<td><?php echo $order["name"]; ?></td>
	</tr><tr>
		<td>E-Mail</td>
		<td><?php echo $order["email"]; ?></td>
	</tr><tr>
		<td>Telefon</td>
		<td><?php echo $order["phone"]; ?></td>
	</tr><tr>
		<td>Bemerkung</td>
		<td><?php echo $order["comment"]; ?></td>
	</tr>
</table>

<h2>Bestellung</h2>
<table style="width:300px;">
	<tr style="font-weight:900;">
		<td>Produkt</td>
		<td>Anzahl</td>
		<td>Preis</td>
	</tr>
	
	<?php foreach ($order["products"] as $product) { ?>
		<tr>
			<td><?php echo $product["name"]; ?></td>
			<td><?php echo $product["qty"]; ?></td>
			<td><?php echo $product["price_text"]; ?></td>
		</tr>
	<?php } ?>

	<tr style="font-weight:900;border-top:1px grey solid;">
		<td>Total</td>
		<td></td>
		<td><?php echo $order["sum_text"]; ?></td>
	</tr>
</table>

<p>
	<br>
	<br>
	<br>
	<small>Bei Fragen: <a href="mailto:kaa@pfadiangenstein.ch">kaa@pfadiangenstein.ch</a></small>
</p>