<?php
// File Security Check
if ( ! empty( $_SERVER['SCRIPT_FILENAME'] ) && basename( __FILE__ ) == basename( $_SERVER['SCRIPT_FILENAME'] ) ) {
    die ( 'You do not have sufficient permissions to access this page!' );
} 


/**
 * Sidebar Template
 *
 * If a `primary` widget area is active and has widgets, display the sidebar.
 *
 * @package WooFramework
 * @subpackage Template
 */


global $woo_options;
if ( isset( $woo_options['woo_layout'] ) && ( $woo_options['woo_layout'] != 'layout-full' ) ) { ?>	
	<aside id="sidebar" class="col-right woocommerce">
		<?php woo_sidebar_inside_before(); ?>
		<?php if ( woo_active_sidebar( 'primary' ) ) { ?>
		
			<div class="primary">
				<?php woo_sidebar( 'primary' );  ?>
			</div>        
		<?php } // End IF Statement ?>
		
		
		<h3>SHOPPING CART</h3>
		<div class="widget_shopping_cart_content"></div>
		
		<?php
		/**
		* Related Products
		*
		* @author 		WooThemes
		* @package 	WooCommerce/Templates
		* @version     1.6.4
		*/
		
		/******* removed not in jay's designs 
		if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
		global $product, $woocommerce_loop;
		
		$related = $product->get_related( $posts_per_page = 3 );
		if ( sizeof( $related ) == 0 ) return;
		
		$args = apply_filters('woocommerce_related_products_args', array(
			'post_type'				=> 'product',
			'ignore_sticky_posts'	=> 1,
			'no_found_rows' 		=> 1,
			'posts_per_page' 		=> $posts_per_page,
			'orderby' 				=> $orderby,
			'post__in' 				=> $related,
			'post__not_in'			=> array($product->id)
		) );
		
		$products = new WP_Query( $args );
		$woocommerce_loop['columns'] 	= $columns;
		
		if ( $products->have_posts() ) : ?>
			<div class="related products">
				<h2><?php _e( 'Related Products', 'woocommerce' ); ?></h2>
				
				<?php woocommerce_product_loop_start(); ?>
					<?php while ( $products->have_posts() ) : $products->the_post(); ?>
						<?php woocommerce_get_template_part( 'content', 'related' ); ?>
					<?php endwhile; // end of the loop. ?>
				<?php woocommerce_product_loop_end(); ?>
			</div>
		<?php 
		endif;
		
		wp_reset_postdata();
		**********/
		woo_sidebar_inside_after(); 
		?> 
		



		
						
		<div class="free_month">
			<a href= "http://fascat.wpengine.com/wp-content/uploads/2015/01/flyer.png" rel=”lightbox”>
				<h1>FREE MONTH</h1>
				<p>of coaching with every<br />
				powermeter purchase</p>
			</a>
		</div>  <!-- free month ends -->
	
	
	</aside><!-- /#sidebar -->
<?php } // End IF Statement ?>
