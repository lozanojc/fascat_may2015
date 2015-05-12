<?php
/**
 * External product add to cart
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

?>

<?php do_action( 'woocommerce_before_add_to_cart_button' ); ?>

<div class="stages_text">
	<h2>Order Details</h2>
	<p class="cart">
		<a href="<?php echo esc_url( $product_url ); ?>" rel="nofollow" class="single_add_to_cart_button button alt"><i class="fa fa-shopping-cart"></i>&nbsp;&nbsp;Order Here</a>
	</p>
</div>





<?php do_action( 'woocommerce_after_add_to_cart_button' ); ?>
