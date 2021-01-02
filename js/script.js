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
		updateCart();
	}

	// uniform pricelist popup
	if($("a.iframe").length) {
		$("a.iframe").colorbox({iframe:true, width:"80%", height:"80%"});
	}

	// add product to cart
	$(document).on("submit", ".product form", function(e) {
		e.preventDefault();
		var formData = $(this).serialize();
		
		$.ajax({
			method: "POST",
			url: "functions.php?cmd=addToCart",
			data: formData,
			success: function(data) {
				data = JSON.parse(data);
				if(data.success) {
					updateCart();
				} else {
					// TODO: error handling
					return false;
				}
			}
		});
	});

	$(document).on("click", ".shopping-cart-icon", function() {
		$(".shopping-cart").toggle();
	});

	$(document).on("click", "conetent", function() {
		$(".shopping-cart").hide();
	});

	// remove product from cart
	$(document).on("click", ".remove-itm", function(e) {
		e.preventDefault();
		var code = $(this).parent().find(".p-code").text();
		$.ajax({
			method: "POST",
			url: "functions.php?cmd=removep&code=" + code,
			success: function(data) {
				data = JSON.parse(data);
				if(data.success) {
					updateCart();
				} else {
					// TODO: error handling
				}
			}
		});
	});

	// load an show shopping cart on shopping cart page
	if($("#shopping-cart-detail").length) {
		$.ajax({
			method: "POST",
			url: "functions.php?cmd=getCart",
			success: function(data) {
				data = JSON.parse(data);
				if(data.success) {
					if(data.products.length > 0) {
						$.each(data.products, function(i, row) {
							var box = $("#cart-itm-template").clone().removeAttr( 'id' ).removeClass("hidden");

							box.find('h3').text(row.name);
							box.find('.p-qty span').text(row.qty);
							box.find('.p-price').text(row.price_text);
							setProductDesc(box.find('.p-desc'), row.code);

							$("#shopping-cart-detail ul").append(box);
						});

						$("#cart-total").text(data.sum_text);
						$("#shopping-cart-detail .cart-empty").hide();
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

	// submit order
	$("#form-submit-order").on("submit", function(e) {
		e.preventDefault();
		var formData = $(this).serialize();
		
		$.ajax({
			method: "POST",
			url: "functions.php?cmd=submitOrder",
			data: formData,
			success: function(data) {
				console.log(data);
				data = JSON.parse(data);
				console.log(data);
				if(data.success) {
					// TODO
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

	function updateCart() {
		$.ajax({
			method: "POST",
			url: "functions.php?cmd=getCart",
			success: function(data) {
				data = JSON.parse(data);
				if(data.success) {
					
					$("#shopping-cart .cart-itm").remove();
					var sum = 0;
					if(Object.keys(data.products).length > 0) {
						$.each(data.products, function(i, row) {
							var box = $("#cart-itm-template").clone().removeAttr( 'id' ).removeClass("hidden");

							box.find('.p-name span').text(row.name);
							box.find('.p-code span').text(row.code);
							box.find('.p-qty span').text(row.qty);
							box.find('.p-price span').text(row.price_text);

							$("#shopping-cart ol").append(box);

							sum += parseInt(row.qty);
						});

						$("#shopping-cart .cart-empty").hide();
					} else {
						$("#shopping-cart .cart-empty").show();
					}

					$("#shopping-cart .cart-total").text(data.sum_text);
					$(".shopping-cart-count").text(sum);
				} else {
					// TODO: error handling
				}
			},
			complete: function() {
				// TODO: spinner
			}
		});
	}
});