<?php
/**
 * Variable product add to cart
 *
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 2.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $product, $post;

?>

<?php do_action( 'woocommerce_before_add_to_cart_form' ); ?>
				<form class="variations_form cart <?php get_post_class(); ?>" method="post" enctype='multipart/form-data' data-product_id="<?php echo $post->ID; ?>" data-product_variations="<?php echo esc_attr( json_encode( $available_variations ) ) ?>">
					<h2>Order Details</h2>

					<?php 
			$classes = get_post_class();
            if (in_array('product-cat-stages',$classes)) {
               ?> 
               <div class="stages_text">
						<h2>Order Details</h2>
						<p class="disclaimer">Our Dealer Agreement requires that orders shipping to USA &amp; Canada must go through our Affiliate Link at Stages and will ship from there. Sorry, no international orders. Local pick up available.</p>
						<p class="disclaimer1">Order using our affiliate Stages link to still take advantage of a free month of coaching.</p>
						<p class="cart-stages">
							<a href="<?php echo CFS()->get('stages_product_url'); ?>" rel="nofollow" target="_blank" class="single_add_to_cart_button button alt"><i class="fa fa-truck"></i>&nbsp;&nbsp;Need It Shipped</a>
							<a href="#" rel="nofollow" class="single_add_to_cart_button button alt hide-stages"><i class="fa fa-home"></i>&nbsp;&nbsp;Pick Up Locally</a>
						</p>
					</div>
         <?php   }  else {  ?>
        	<?php  } ?>


					<?php if ( ! empty( $available_variations ) ) : ?>
						<table class="variations" cellspacing="0">
							<tbody>
								<?php $loop = 0; foreach ( $attributes as $name => $options ) : $loop++; ?>
									<tr class="variable-table">
										<td class="label"><label for="<?php echo sanitize_title( $name ); ?>"><?php echo wc_attribute_label( $name ); ?></label></td>
										<td class="value"><select id="<?php echo esc_attr( sanitize_title( $name ) ); ?>" name="attribute_<?php echo sanitize_title( $name ); ?>" data-attribute_name="attribute_<?php echo sanitize_title( $name ); ?>">
											<option value=""><?php echo __( 'Choose an option', 'woocommerce' ) ?>&hellip;</option>
											<?php
												if ( is_array( $options ) ) {

													if ( isset( $_REQUEST[ 'attribute_' . sanitize_title( $name ) ] ) ) {
														$selected_value = $_REQUEST[ 'attribute_' . sanitize_title( $name ) ];
													} elseif ( isset( $selected_attributes[ sanitize_title( $name ) ] ) ) {
														$selected_value = $selected_attributes[ sanitize_title( $name ) ];
													} else {
														$selected_value = '';
													}

													// Get terms if this is a taxonomy - ordered
													if ( taxonomy_exists( $name ) ) {

														$terms = wc_get_product_terms( $post->ID, $name, array( 'fields' => 'all' ) );

														foreach ( $terms as $term ) {
															if ( ! in_array( $term->slug, $options ) ) {
																continue;
															}
															echo '<option value="' . esc_attr( $term->slug ) . '" ' . selected( sanitize_title( $selected_value ), sanitize_title( $term->slug ), false ) . '>' . apply_filters( 'woocommerce_variation_option_name', $term->name ) . '</option>';
														}

													} else {

														foreach ( $options as $option ) {
															echo '<option value="' . esc_attr( sanitize_title( $option ) ) . '" ' . selected( sanitize_title( $selected_value ), sanitize_title( $option ), false ) . '>' . esc_html( apply_filters( 'woocommerce_variation_option_name', $option ) ) . '</option>';
														}

													}
												}
											?>
										</select> 
										</td>
									</tr>
						        <?php endforeach;?>
							</tbody>
						</table>

						<?php do_action( 'woocommerce_before_add_to_cart_button' ); ?>

						<div class="single_variation_wrap" style="display:none;">
							<?php do_action( 'woocommerce_before_single_variation' ); ?>

							<div class="single_variation"></div>

							<div class="variations_button">
								
								<button type="submit" class="single_add_to_cart_button button alt"><?php echo $product->single_add_to_cart_text(); ?></button>
							</div>

							<input type="hidden" name="add-to-cart" value="<?php echo $product->id; ?>" />
							<input type="hidden" name="product_id" value="<?php echo esc_attr( $post->ID ); ?>" />
							<input type="hidden" name="variation_id" class="variation_id" value="" />

							<?php do_action( 'woocommerce_after_single_variation' ); ?>
						</div>

						<?php do_action( 'woocommerce_after_add_to_cart_button' ); ?>

					<?php else : ?>

						<p class="stock out-of-stock"><?php _e( 'This product is currently out of stock and unavailable.', 'woocommerce' ); ?></p>

					<?php endif; ?>

				</form>




<?php do_action( 'woocommerce_after_add_to_cart_form' ); ?>
