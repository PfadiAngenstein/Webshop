<?php
    session_start();
    include_once("config.php");
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="ISO-8859-4">
    <meta name="theme-color" content="#FFEB3B">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    
    <title>Webshop - Pfadi Angenstein</title>
    
    <link rel="stylesheet" type="text/css" href="style/normalize.css">
    <link rel="stylesheet" type="text/css" href="style/style.css">
</head>

<body>
    <div class="banner">
        <div class="content">
            <a hreF="index.php"><h1><img src="images/angenstein.gif" alt="Logo Pfadi Angenstein">&nbsp;Webshop</h1></a>
         </div>
    </div>
    
<div id="products-wrapper">
    <div class="products">
        <?php
        //current URL of the Page. cart_update.php redirects back to this URL
        $current_url = base64_encode($url="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);

        $results = $mysqli->query("SELECT * FROM products ORDER BY id ASC");
        if ($results) { 

            //fetch results set as object and output HTML
            while($obj = $results->fetch_object())
            {
                echo '<div class="product">'; 
                echo '<form method="post" action="cart_update.php">';
                echo '<div class="product-thumb"><img src="images/'.$obj->product_img_name.'"></div>';
                echo '<div class="product-content"><h3>'.$obj->product_name.'</h3>';
                echo '<div class="product-desc">'.$obj->product_desc.'</div>';
                echo '<div class="product-info">';
                echo '<span class="preis">Preis '.$currency.$obj->price.' </span>| ';
                echo 'Anzahl <input type="number" name="product_qty" value="1" size="3" />';
                echo '<button class="add_to_cart">In den Warenkorb</button>';
                echo '</div></div>';
                echo '<input type="hidden" name="product_code" value="'.$obj->product_code.'" />';
                echo '<input type="hidden" name="type" value="add" />';
                echo '<input type="hidden" name="return_url" value="'.$current_url.'" />';
                echo '</form>';
                echo '</div>';
            }

        }
        ?>
    </div>
    
    <div class="shopping-cart">
        <h2><a href="view_cart.php">Warenkorb</a></h2>
        <?php
        if(isset($_SESSION["products"]))
        {
            $total = 0;
            echo '<ol>';
            foreach ($_SESSION["products"] as $cart_itm)
            {
                echo '<li class="cart-itm">';
                echo '<span class="remove-itm"><a href="cart_update.php?removep='.$cart_itm["code"].'&return_url='.$current_url.'">&times;</a></span>';
                echo '<h3>'.$cart_itm["name"].'</h3>';
                echo '<div class="p-code">Produktcode: '.$cart_itm["code"].'</div>';
                echo '<div class="p-qty">Anzahl: '.$cart_itm["qty"].'</div>';
                echo '<div class="p-price">Preis: '.$currency.$cart_itm["price"].'</div>';
                echo '</li>';
                $subtotal = ($cart_itm["price"]*$cart_itm["qty"]);
                $total = ($total + $subtotal);
            }
            echo '</ol>';
            echo '<strong>Total : '.$currency.$total.'</strong><br><a href="view_cart.php"><button>Bestellung abschliessen</button></a><br>';
            echo '<span class="empty-cart"><a href="cart_update.php?emptycart=1&return_url='.$current_url.'"><button>Warenkorb leeren</button></a></span>';
        } else {
            echo 'Der Warenkorb ist leer.';
        }
        ?>
    </div>
</div>
   
<div class="clear"></div>
    <footer>
        <p>&copy; Pfadi Angenstein</p>
    </footer>

</body>
</html>
