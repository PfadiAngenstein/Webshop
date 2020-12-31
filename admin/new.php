<?php
/* 
 NEW.PHP
 Allows user to create a new entry in the database
*/
 
 // creates the new record form
 // since this form is used multiple times in this file, I have made it a function that is easily reusable
 function renderForm($first, $last, $error)
 {
 ?>
 <!DOCTYPE HTML>
 <html>
 <head>
 <title>Neues Produkt erfassen</title>
  <link rel="stylesheet" type="text/css" href="../style/normalize.css">
 <link rel="stylesheet" type="text/css" href="style/style.css">
 </head>
 <body>
 <?php 
 // if there are any errors, display them
 if ($error != '')
 {
 echo '<div style="padding:4px; border:1px solid red; color:red;">'.$error.'</div>';
 }
 ?> 
 
 <form action="" method="post">
 <div>
<table>
	<tr>
		<td><strong>ID:</strong></td>
		<td><input type="text" name="id"/></td>
	</tr>
	<tr>
		<td><strong>Produktcode:</strong></td>
		<td><input type="text" name="product_code" value="<?php echo $product_code; ?>"/></td>
	</tr>
	<tr>
		<td><strong>Produktname:</strong></td>
		<td><input type="text" name="product_name" value="<?php echo $product_name; ?>"/></td>
	</tr>
	<tr>
		<td><strong>Beschreibung: </strong></td>
		<td><textarea name="product_desc" rows="5" cols="50"><?php echo $product_desc; ?></textarea></td>

	</tr>
	<tr>
		<td><strong>Bildname: </strong></td>
		<td><input type="text" name="product_img_name" value="<?php echo $product_img_name;?>"/></td>
	</tr>
	<tr>
		<td><strong>Preis: </strong></td>
		<td><input type="text" name="price" value="<?php echo $price; ?>"/></td>
	</tr>
	<tr>
		<td colspan="2"> <input type="submit" name="submit" value="Speichern"></td>
	</tr>

</table>

 </div>
 </form> 
 
 <p><a href="http://www.pfadiangenstein.ch/shop/admin">Abbrechen</a></p>
 
 </body>
 </html>
 <?php 
 }
 
 
 

 // connect to the database
 include('connect-db.php');
 
 // check if the form has been submitted. If it has, start to process the form and save it to the database
 if (isset($_POST['submit']))
 { 
 // get form data, making sure it is valid
 $id = $_POST['id'];
 $product_code = mysql_real_escape_string(htmlspecialchars($_POST['product_code']));
 $product_name = mysql_real_escape_string(htmlspecialchars($_POST['product_name']));
  $product_desc = mysql_real_escape_string(htmlspecialchars($_POST['product_desc']));
 $product_img_name = mysql_real_escape_string(htmlspecialchars($_POST['product_img_name']));
 $price = mysql_real_escape_string(htmlspecialchars($_POST['price']));
 
 // check to make sure both fields are entered
 if ($id == '' || $product_code == '' || $product_name == '' || $product_desc == '' || $price == "")
 {
 // generate error message
 $error = 'FEHLER: Bitte alle Felder ausfüllen!';
 
 // if either field is blank, display the form again
renderForm($id, $product_code, $product_name, $product_desc, $product_img_name, $product_img_name, $price);
 }
 else
 {
 // save the data to the database
 mysql_query("INSERT products SET id='$id', product_code='$product_code', product_name='$product_name', product_desc='$product_desc', product_img_name='$product_img_name', price='$price'")
 or die(mysql_error()); 
 
 // once saved, redirect back to the view page
 header("Location: index.php"); 
 }
 }
 else
 // if the form hasn't been submitted, display the form
 {
 renderForm('','','');
 }
?>