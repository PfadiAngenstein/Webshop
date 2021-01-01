$(document).ready(function() {

	// load and show products
	if($("#product-container").length) {
		$("#products-spinner").show();
		$.ajax({
			method: "POST",
			url: "functions.php?cmd=getProducts",
			success: function(data) {
				data = JSON.parse(data);
				if(data.success) {
					$.each(data.products, function(i, row) {
						var box = $( '#product-template' ).clone().removeAttr( 'id' ).removeClass("hidden");
						
						box.find('.product-thumb img').attr('src', box.find('.product-thumb img').attr('src') + row.product_img_name);
						box.find('.product-content h3').text(row.product_name);
						box.find('.product-desc').text(row.product_desc);
						box.find('.preis').text(row.price + " " + data.currency);
						box.find('input[name="product_code"]').val(row.product_code);
						box.find('input[name="return_url"]').val(data.return_url);

						$("#product-container").append(box);
					});
				} else {
					// TODO: error handling
				}
			},
			complete: function() {
				$("#products-spinner").hide();
			}
		});
	}

	// load and show shopping cart
	if($("#shopping-cart").length) {
		$.ajax({
			method: "POST",
			url: "functions.php?cmd=getCart",
			success: function(data) {
				data = JSON.parse(data);
				console.log(data);
				if(data.success) {
					if(data.products.length > 0) {
						$.each(data.products, function(i, row) {
							var box = $("#cart-itm-template").clone().removeAttr( 'id' ).removeClass("hidden");

							box.find('.remove-itm a').attr("href", box.find('.remove-itm a').attr("href") + "removep=" + row.code + "&return_url=" + data.return_url);
							box.find('h3').text(row.name);
							box.find('.p-code').text(row.code);
							box.find('.p-qty').text(row.qty);
							box.find('.p-price').text(row.price);

							$("#shopping-cart ol").append(box);
						});
					}
				} else {
					// TODO: error handling
				}
			},
			complete: function() {
				// TODO: spinner
			}
		});
	}

	// load an show shopping cart on shopping cart page
	if($("#shopping-cart-detail").length) {
		$.ajax({
			method: "POST",
			url: "functions.php?cmd=getCart",
			success: function(data) {
				data = JSON.parse(data);
				if(data.success) {
					if(data.products.length > 0) {
						var sum = 0;
						$.each(data.products, function(i, row) {
							var box = $("#cart-itm-template").clone().removeAttr( 'id' ).removeClass("hidden");

							box.find('h3').text(row.name);
							box.find('.p-qty span').text(row.qty);
							box.find('.p-price').text(row.price);
							setProductDesc(box.find('.p-desc'), row.code);

							sum += parseFloat(row.price);

							$("#shopping-cart-detail ul").append(box);
						});


						$("#cart-total").text(sum);
					}
				} else {
					// TODO: error handling
				}
			},
			complete: function() {
				// TODO: spinner
			}
		});
	}

	$(document).on("submit", ".product form", function(e) {
		e.preventDefault();
		var formData = $(this).serialize();
		console.log(formData);
		
		$.ajax({
			method: "POST",
			url: "functions.php?cmd=addToCart",
			data: formData,
			success: function(data) {
				console.log(data);
				data = JSON.parse(data);
				if(data.success) {
					//field.text(data.desc);
				} else {
					// TODO: error handling
					return false;
				}
			}
		});
	});

	function setProductDesc(field, code) {
		$.ajax({
			method: "POST",
			url: "functions.php?cmd=getProductDesc&code=" + code,
			success: function(data) {
				data = JSON.parse(data);
				if(data.success) {
					field.text(data.desc);
				} else {
					// TODO: error handling
					return false;
				}
			}
		});
	}

	

/*


	            <?php
            //current URL of the Page. cart_update.php redirects back to this URL
            $current_url = base64_encode($url="https://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
            $results = getProducts();
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
                    echo '<span class="preis">Preis '.$GLOBALS['cfg_db_currency'].$obj->price.' </span>| ';
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
*/
});