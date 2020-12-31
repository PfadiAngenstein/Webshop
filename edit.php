<?php
/* 
 EDIT.PHP
 Allows user to edit specific entry in database
*/

 // creates the edit record form
 // since this form is used multiple times in this file, I have made it a function that is easily reusable
 function renderForm($id, $product_code, $product_name, $product_desc, $product_img_name, $price, $error)
 {
 ?>
 <!DOCTYPE HTML>
 <html>
 <head>
 <title>Produkt bearbeiten</title>
 
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
 <input type="hidden" name="id" value="<?php echo $id; ?>"/>
 <div>
 <table>
	<tr>
		<td><strong>ID:</strong><td>
		<td><?php echo $id; ?></td>
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
 
 // check if the form has been submitted. If it has, process the form and save it to the database
 if (isset($_POST['submit']))
 { 
 // confirm that the 'id' value is a valid integer before getting the form data
 if (is_numeric($_POST['id']))
 {
 // get form data, making sure it is valid
 $id = $_POST['id'];
 $product_code = mysql_real_escape_string(htmlspecialchars($_POST['product_code']));
 $product_name = mysql_real_escape_string(htmlspecialchars($_POST['product_name']));
  $product_desc = mysql_real_escape_string(htmlspecialchars($_POST['product_desc']));
 $product_img_name = mysql_real_escape_string(htmlspecialchars($_POST['product_img_name']));
 $price = mysql_real_escape_string(htmlspecialchars($_POST['price']));
 
 // check that firstname/lastname fields are both filled in
 if ($product_code == '' || $product_name == '' || $product_desc == '' || $price == "")
 {
 // generate error message
 $error = 'FEHLER: Bitte alle Felder ausfüllen!';
 
 //error, display form
renderForm($id, $product_code, $product_name, $product_desc, $product_img_name, $product_img_name, $price);
 }
 else
 {
 // save the data to the database
 mysql_query("UPDATE products SET product_code='$product_code', product_name='$product_name', product_desc='$product_desc', product_img_name='$product_img_name', price='$price' WHERE id='$id'")
 or die(mysql_error()); 
 
 // once saved, redirect back to the view page
 header("Location: index.php"); 
 }
 }
 else
 {
 // if the 'id' isn't valid, display an error
 echo 'Error!';
 }
 }
 else
 // if the form hasn't been submitted, get the data from the db and display the form
 {
 
 // get the 'id' value from the URL (if it exists), making sure that it is valid (checing that it is numeric/larger than 0)
 if (isset($_GET['id']) && is_numeric($_GET['id']) && $_GET['id'] > 0)
 {
 // query db
 $id = $_GET['id'];
 $result = mysql_query("SELECT * FROM products WHERE id=$id")
 or die(mysql_error()); 
 $row = mysql_fetch_array($result);
 
 // check that the 'id' matches up with a row in the databse
 if($row)
 {
 
 // get data from db
 $product_code = $row['product_code'];
 $product_name = $row['product_name'];
 $product_desc = $row['product_desc'];
 $product_img_name = $row['product_img_name'];
 $price = $row['price'];
 
 // show form
renderForm($id, $product_code, $product_name, $product_desc, $product_img_name, $price, '');
 }
 else
 // if no match, display result
 {
 echo "No results!";
 }
 }
 else
 // if the 'id' in the URL isn't valid, or if there is no 'id' value, display an error
 {
 echo 'Error!';
 }
 }
?>