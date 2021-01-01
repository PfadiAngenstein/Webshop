<?php
    include_once("functions.php");
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="theme-color" content="#FFEB3B">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    
    <title>Webshop - Pfadi Angenstein</title>

    <link href="https://fonts.googleapis.com/css?family=PT+Sans:400,400i,700,700i" rel="stylesheet">
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
        <div class="products" id="product-container">

            <div class="hidden" id="products-spinner"><img src="images/spinner.gif" /></div>

            <!-- products get added here by js -->

        </div>
        
        <div id="sticky-anchor"></div>
        <div class="shopping-cart" id="shopping-cart">
            <h2><a href="view_cart.php">Warenkorb</a></h2>

            <ol>
                <!-- cart items get added here by js -->
            </ol>

            <strong>Total : <span></span></strong><br>
            <a href="view_cart.php"><button>Bestellung abschliessen</button></a><br>
            <span class="empty-cart"><a href="cart_update.php?emptycart=1&return_url="><button>Warenkorb leeren</button></a></span>
        </div>
    </div>
   
    <div class="clear"></div>
    
    <footer>
        <p>&copy; Pfadi Angenstein</p>
    </footer>

    <script src="js/jquery-3.5.1.min.js"></script>
    <script src="js/script.js"></script>


<!-- TEMPLATES -->
<div class="product hidden" id="product-template">
    <form method="post" action="cart_update.php">
        <div class="product-thumb"><img src="images/"></div>
        <div class="product-content">
            <h3>name_not_found</h3>
            <div class="product-desc">desc</div>
            <div class="product-info">
                <span class="preis"></span>| Anzahl <input type="number" name="product_qty" value="1" size="3" />
                <button type="submit" class="add_to_cart">In den Warenkorb</button>
            </div>
        </div>
        <input type="hidden" name="product_code" value="product_code" />
        <input type="hidden" name="type" value="add" />
        <input type="hidden" name="return_url" value="current_url" />
    </form>
</div>


<li class="cart-itm hidden" id="cart-itm-template">
    <span class="remove-itm"><a href="cart_update.php?">&times;</a></span>
    <h3>name</h3>
    <div class="p-code">Produktcode: code</div>
    <div class="p-qty">Anzahl: qty</div>
    <div class="p-price">Preis: price</div>
</li>


</body>
</html>
