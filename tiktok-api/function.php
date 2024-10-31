<?php
/*
* Plugin Name: SAHU TikTok Pixel for E-Commerce
* Plugin URI: https://sahu.media
* Text Domain: sahu_tiktok_pixel
* @package sahu_tiktok_pixel
* @copyright Copyright (c) 2021-2022, SAHU MEDIA®
*
*/
 
add_action( 'wp_head', 'sahu_tiktok_pixel_main' );

function sahu_tiktok_pixel_main() {

	$tiktokpixel = get_option( 'sahu_tiktok_pixel_id' );

?>
<script>
	!function (w, d, t) {
	  w.TiktokAnalyticsObject=t;var ttq=w[t]=w[t]||[];ttq.methods=["page","track","identify","instances","debug","on","off","once","ready","alias","group","enableCookie","disableCookie"],ttq.setAndDefer=function(t,e){t[e]=function(){t.push([e].concat(Array.prototype.slice.call(arguments,0)))}};for(var i=0;i<ttq.methods.length;i++)ttq.setAndDefer(ttq,ttq.methods[i]);ttq.instance=function(t){for(var e=ttq._i[t]||[],n=0;n<ttq.methods.length;n++)ttq.setAndDefer(e,ttq.methods[n]);return e},ttq.load=function(e,n){var i="https://analytics.tiktok.com/i18n/pixel/events.js";ttq._i=ttq._i||{},ttq._i[e]=[],ttq._i[e]._u=i,ttq._t=ttq._t||{},ttq._t[e]=+new Date,ttq._o=ttq._o||{},ttq._o[e]=n||{};var o=document.createElement("script");o.type="text/javascript",o.async=!0,o.src=i+"?sdkid="+e+"&lib="+t;var a=document.getElementsByTagName("script")[0];a.parentNode.insertBefore(o,a)};


	  ttq.load(<?php print "'$tiktokpixel'"; ?>);
	  ttq.page();
	}(window, document, 'ttq');
</script>
<script>
	ttq.track('Browse')
</script>
<?php
}

// Wenn Produktseite Laade ViewContent-Event

add_action( 'woocommerce_before_single_product', 'sahu_tiktok_pixel_viewContent' );

function sahu_tiktok_pixel_viewContent( $product ){
	
	$options = get_option( 'sahu_tiktok_pixel_id_options_woo' );
	if( $options  == "on" ){
	
		if ( is_product() ) {
			global $product;
			$pname = $product->get_name();
			$price = $product->get_price();
			$id = $product->get_id();
			

	 ?>
			<script>
				ttq.track('ViewContent');
			</script>
	<?php	
		}
	}
	
}


// Wenn Warenkorb Lade AddtoCart-Event

add_action( 'woocommerce_after_cart_totals', 'sahu_tiktok_pixel_cart' );

function sahu_tiktok_pixel_cart( $order_id ) {
	
	$options = get_option( 'sahu_tiktok_pixel_id_options_woo' );
	if( $options  == "on" ){
		foreach( WC()->cart->get_cart() as $cart_item ){
		$product_id = $cart_item['product_id'];
		}

		?>

			<script>
				ttq.track('AddToCart');
			</script>
				 
		<?php
	}
	
}


// Wenn Checkout-Seite Lade Checkout-Event

add_action( 'woocommerce_after_checkout_billing_form', 'sahu_tiktok_pixel_checkout' );

function sahu_tiktok_pixel_checkout( $order_id ) {
	
	$options = get_option( 'sahu_tiktok_pixel_id_options_woo' );
	if( $options  == "on" ){
		 ?>

			<script>
				ttq.track('InitiateCheckout');
			</script>
				 
		<?php
	}
	
}

// Wenn Danke-Seite Lade Kauf-Event

add_action( 'woocommerce_thankyou', 'sahu_tiktok_pixel_purchase' );

function sahu_tiktok_pixel_purchase( $order_id ) {
	
	$options = get_option( 'sahu_tiktok_pixel_id_options_woo' );
	if( $options  == "on" ){
	   $order = new WC_Order( $order_id );
	   $order_total = $order->get_total();
	   $items = $order->get_items();
	   $currency = get_woocommerce_currency();
	   
	   $artikel = [];
	   
	   foreach ( $items as $item ) {
		$product_name = $item->get_name();
		$product_id = $item->get_product_id();
		$product_variation_id = $item->get_variation_id();
		$quantity = $item->get_quantity();
		$total = $item->get_total();
		
		$content = "{
		  content_id: {$product_id},
		  content_type: 'product',
		  content_name: '{$product_name}',
		  quantity: {$quantity},
		  price: {$total},
		}";
	  
		$artikel[] = $content;
	   }
	 ?>

		<script>
			ttq.track('PlaceAnOrder', {
			   contents: [
				  <?php implode(",", $artikel) ?>
				],
				value: <?php print $order_total; ?>,
				currency: <?php print "'$currency'"; ?>,
			});	
		</script>
		<script>
			ttq.track('CompletePayment', {
			   contents: [
				  <?php implode(",", $artikel) ?>
				],				
				value: <?php print $order_total; ?>,
				currency: <?php print "'$currency'"; ?>,
			});	
		</script>
			 
	<?php
	}
	
}

?>