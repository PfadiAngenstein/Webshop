<!DOCTYPE html>
    <head>
        <meta charset="utf-8">
        <meta name="theme-color" content="#FFEB3B">
        <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
        
        <title>Webshop - Pfadi Angenstein</title>

        <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=PT+Sans:400,700">
        <link rel="stylesheet" type="text/css" href="style/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="style/style.css">
        
    </head>

    <body>
        <header>
            <a href="index.php"><img src="images/angenstein.gif" class="logo" alt="Logo Pfadi Angenstein"></a>
            <h1 class="title">Pfadi Angenstein -  Webshop</h1>
            <img src="images/shopping-cart.svg" class="shopping-cart-icon">
            <p class="shopping-cart-count"></p>
        </header>
        <div class="content">
            <div id="products-wrapper">
                <div class="container">
                <div class="products row" id="product-container">
                    <div class="hidden" id="products-spinner"><img src="images/spinner.gif" /></div>
                    
                            <!-- products get added here by js -->

                </div>
                </div>
                <div class="shopping-cart" id="shopping-cart">
                    <div class="arrow-up"></div>

                    <h2><a href="view_cart.php">Warenkorb</a></h2>

                    <ol>
                        <!-- cart items get added here by js -->
                    </ol>

                    <div class="cart-empty">Der Warenkorb ist leer :(</div>

                    <strong>Total : <span class="cart-total"></span></strong><br>
                    <a href="view_cart.php"><button class="btn btn-sm btn-dark">Bestellung abschliessen</button></a><br>
                </div>
            </div>
        </div>
       
        <div class="clear"></div>
        
        <footer>
            <p>&copy; Pfadi Angenstein</p>
        </footer>

        <script src="js/jquery-3.5.1.min.js"></script>
        <script src="js/bootstrap.bundle.min.js"></script>
        <script src="js/script.js"></script>


    <!-- TEMPLATES -->

    <div class="product hidden col-xs-12 col-sm-6 col-md-4" id="product-template">
        <form method="post" class="product-style" action="cart_update.php">
        <div class="product-thumb"><img src="images/"></div>
            <div class="product-content">
                <!-- <div class="more-desc">
                    <div class="product-desc">desc</div>
                </div>   -->
                <h3 class="product-name">name_not_found</h3>             
                <div class="product-info">
                    <span class="preis"></span>| Anzahl <input class="product-qty form-control" type="number" name="product_qty" value="1" size="3" />
                    <button type="submit" class="add_to_cart btn btn-sm btn-dark">In den Warenkorb</button>
                </div>
            </div> 
            <input type="hidden" name="product_code" value="product_code" />
            <input type="hidden" name="type" value="add" />
            <input type="hidden" name="return_url" value="current_url" />
        </form>
    </div>


    <li class="cart-itm hidden" id="cart-itm-template">
        <span class="remove-itm"><a href="cart_update.php?">&times;</a></span>
        <div class="p-name"><span></span></div>
        <div class="p-code hidden"><span></span></div>
        <div class="p-qty">Anzahl: <span></span></div>
        <div class="p-price">Preis: <span></span></div>
    </li>


    </body>
</html>