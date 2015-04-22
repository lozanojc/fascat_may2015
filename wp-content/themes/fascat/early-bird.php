<?php

// File Security Check

if ( ! function_exists( 'wp' ) && ! empty( $_SERVER['SCRIPT_FILENAME'] ) && basename( __FILE__ ) == basename( $_SERVER['SCRIPT_FILENAME'] ) ) {

    die ( 'You do not have sufficient permissions to access this page!' );

}

?>

<?php

/**

  * Template Name: Early-Bird

 *

 * Here we setup all logic and XHTML that is required for the index template, used as both the homepage

 * and as a fallback template, if a more appropriate template file doesn't exist for a specific context.

 *

 * @package WooFramework

 * @subpackage Template

 */

	get_header();

	global $woo_options;

	

?>
<style>


.srm_prod {
    background-color: #F94D00;
    float: left;
    margin-left: 130px;
    margin-top: -36px;
    padding: 0 10px 8px;
    text-align: center;
	min-width: 20%;
}
.col_three img {
    margin-bottom: 0px;
}.added_to_cart{display:none ;}
</style>
<script>
jQuery( document ).ready(function() {
jQuery(".training_black").click(function(){    var id = jQuery(this).attr('id');	
  jQuery('#'+id+" "+".chnages").attr('src', '/wp-content/uploads/2014/05/right-copy.png'); jQuery('#'+id).css("background-color","#F94B06"); //jQuery('.'+this+" "+".add_to_cart_button").click();   
});
});
</script>
    <div id="content" class="col-full">
  <?php $productid = $cfs->get('product_id'); ?>
	<?php $args = array(
        'posts_per_page' => 1,
		'p' => $productid,
        'product_cat' => 'Early_Bird',
        'post_type' => 'product',
        'orderby' => 'title',
    );

	?>
				
				<?php $the_query = new WP_Query( $args );
					// The Loop
					while ( $the_query->have_posts() ) {
						$the_query->the_post();
						

				?>

		<article <?php post_class(); ?>>

	           <header>
                      <div class="custom_page_header" style="background: url(<?php echo $cfs->get('header_image'); ?>) no-repeat top center;">
			   <div class="header_txt">
                          <h2><?php the_title(); ?></h2>
		            <p><?php echo $cfs->get('header_text'); ?></p>
					<?php //echo $cfs->get('add_cart'); ?>
					
					<div class="product_button">
					

				<?php if ( $price_html = $product->get_price_html() ) : ?>
				<div class="srm_price"><?php echo $price_html; ?></div>
				<?php endif; ?>
				<div class="srm_add"><a href="<?php the_permalink() ?>">ADD&nbsp;&nbsp;<img src="/wp-content/uploads/2014/03/right.png"/><div class="srm_prod"><img src="/wp-content/uploads/2014/04/shop.png"/></div></a></div>

					<?php //echo do_shortcode($cfs->get('add_cart'));?>

	               <!--<strong style="color:#fff; font-size: 20px;">$<?php //echo $cfs->get('order_tracking'); ?></strong><a class="button small_txt" href="<?php //the_permalink() ?>">ADD<img class="right_arrow" src="<?php //echo get_template_directory_uri() ?>/images/right.png" alt="right icon" /></a><a class="button small_txt" href="<?php //echo $cfs->get('sign_up_url'); ?>"><img class="right_arrow" src="<?php //echo get_template_directory_uri() ?>/images/pro.png" alt="pro icon" /></a>-->


	                 </div>
			 </div>
	             </header>

	                
    			<section class="content_wrapper">
	                <section class="entry fix">
	                	<?php the_content(); ?> 
						
						

						
						<div class="col_three last_col">
<div class="grey_box  box2">
<div class="shopp"><img alt="" src="/wp-content/uploads/2014/04/sp.png" />
<h3>SHOPPING CART</h3>
</div>
<div class="srm"><img alt="" src="<?php echo $cfs->get('header_image'); ?>" />
<h5><?php the_title(); ?></h5>
</div>
<div class="border"></div>
<div style="text-align: left; margin-top: 10px;">
<h5><?php _e('SUBTOTAL', 'woocommerce'); ?> : <?php echo $woocommerce->cart->get_cart_subtotal(); ?></h5>
</div>
<div style="width: 100%; margin-top: 20px;">
<?php global $woocommerce; ?>
 <div class="view"><a class="cart-contents" href="<?php echo $woocommerce->cart->get_cart_url(); ?>" title="<?php _e('View your shopping cart', 'woothemes'); ?>">VIEW CART</a></div>
<div class="check"><a href="<?php echo $woocommerce->cart->get_checkout_url();?>">CHECKOUT</a>


</div>
</div>
</div>
<?php echo $cfs->get('suitable_for_the_athlete'); ?>
<!--We'll measure your power at threshold at the beginning and at the end of the 9 week class to measure how much faster you've become. This is the IDEAL type of training for this time of year for road, mountain and multisport athletes.-->
<div style="width: 100%; margin-top: 20px; margin-bottom:10px;">

				<?php if ( $price_html = $product->get_price_html() ) : ?>
				<div class="srm_price"><?php echo $price_html; ?></div>
				<?php endif; ?>
				<div class="srm_add"><a href="<?php the_permalink() ?>">ADD&nbsp;&nbsp;<img src="/wp-content/uploads/2014/03/right.png"/><div class="srm_prod"><img src="/wp-content/uploads/2014/04/shop.png"/></div></a></div>
				
				<div class="clear"> </div>  

					<!--<?php //if ( $price_html = $product->get_price_html() ) : ?>
	                <div class="price"><?php //echo $price_html; ?></div>
                    <?php //endif; ?>-->
					
<!--<div class="add"><a class="add_to_cart_button button product_type_simple added" data-product_sku="" data-product_id="367" rel="nofollow" href="/clients/fascat/early-bird/?add-to-cart=367">ADD<img class="right_arrow" alt="right icon" src="/wp-content/uploads/2014/03/right.png" /></a></div>-->

<?php //printf('<a href="%s" rel="nofollow" data-product_id="%s" class="add_to_cart_button button product_type_%s">%sADD<img class="right_arrow" alt="right icon" src="/wp-content/uploads/2014/03/right.png" /></a>', $link, $product->id, $product->product_type, $label);?>
<!--<div class="price">$185.oo</div>-->
<!--<div class="add">ADD<img class="right_arrow" alt="right icon" src="/wp-content/uploads/2014/03/right.png" /></div>
<div class="shop_cart"><img alt="" src="/wp-content/uploads/2014/03/pro.png" /></div>-->
</div>
<!--FREE 45 Day Premium <strong>TrainingPeaks</strong> account for data upload for the first 125 sign ups!-->
<?php echo $cfs->get('week_block'); ?>
</div>
				<div class="clear"> </div>                   
			   </section>
			</section><!-- .content_wrapper -->
            </article><!-- .post -->

       	<?php } ?>  
        
        <div class="early_bird">
	     <?php query_posts(array(
            'post_type'=> 'Early-Bird',
	  	    'posts_per_page' => 10,
	  	    'orderby' => 'post_date',
	  	    'order' => 'DESC',
	      	  ));
            ?>
               
            <div class="content_wrapper">
		<h2>Class curriculum</h2>

           <?php if (have_posts()) : while (have_posts()) : the_post(); 
	   	  $thumbnail = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full');
		  $i++; //add 1 to the total count
           ?>

              <div class="featured_image12">
            	  <a href="<?php the_permalink(); ?>">
		     <?php the_post_thumbnail(); ?>
			 
		     	<h5><?php the_title(); ?></h5>

		     <!--<div class="magnifier"> </div>-->
		  </a>
		</div>	<!-- featured_image ends -->
            
            	<?php endwhile;?>
		<?php endif; ?>

		<div class="clear"> </div>

	     </div>	<!-- .content_wrapper ends -->

        </div>  <!-- camps_listing ends -->
		
		



		
		<article>
		    <section class="content_wrapper" id="train">
	            <section class="entry fix">
				
				<h1>Training Services Add Ons</h1>
				
									<?php $args = array(
        'posts_per_page' => 10,
        'product_cat' => 'Addons_services',
        'post_type' => 'product',
        'orderby' => 'title',
    );

	?>
				
				<?php $the_query = new WP_Query( $args );
					// The Loop
					while ( $the_query->have_posts() ) {
						$the_query->the_post();
						

				?>				<div class="temp">                  <?php printf('<a href="%s" rel="nofollow" data-product_id="%s" class="add_to_cart_button product_type_%s">%s', $link, $product->id, $product->product_type, $label);?>
				  <div class="training_black"  id="<?php printf($product->id);?>">
				  <div  style="float:right;color:#000;"><img class="chnages" src="/wp-content/uploads/2014/03/cross.png"></div>
				  <div style="margin-top:10px;"><?php the_post_thumbnail('full'); ?></div>
				 <br/>
                  <?php echo '' . get_the_title() . '';?><?php if ( $price_html = $product->get_price_html() ) : ?><strong> <?php echo $price_html; ?></strong>
                   <?php endif; ?>				                  
                 </div>                  <?php echo "</a>";?>
				            </div>
				 
				 <?php 	} ?>
				  <!--<div class="training_black">
				  <div style="float:right;"><img src="/wp-content/uploads/2014/03/cross.png"></div>
				  <div style="margin-top:10px;"><img src="/wp-content/uploads/2014/03/t2.png"></div>
				 <br/>
                  G3 Wheel & Joule GPS COMBO $1148.00<strong>- Add $149.00</strong>				 
                 </div>	
				  <div class="training_black">
				  <div style="float:right;"><img src="/wp-content/uploads/2014/03/cross.png"></div>
				  <div style="margin-top:10px;"><img src="/wp-content/uploads/2014/03/t3.png"></div>
				 <br/>
                  Lactate Threshold Test<strong>- Add $99.00</strong>				 
                 </div>	
				 
				  <div class="training_black">
				  <div style="float:right;"><img src="/wp-content/uploads/2014/03/cross.png"></div>
				  <div style="margin-top:10px;"><img src="/wp-content/uploads/2014/03/t4.png"></div>
				 <br/>
                  9 Week Winter Training Plan via<strong>- Add $49.95</strong>				 
                 </div>	
				  <div class="training_black">
				  <div style="float:right;"><img src="/wp-content/uploads/2014/03/cross.png"></div>
				  <div style="margin-top:10px;"><img src="/wp-content/uploads/2014/03/t5.png"></div>
				 <br/>
                  Coaching Levels 1 - 5,<strong>Start up Fee Waived</strong>- Call				 
                 </div>	
				 
				  <div class="training_black">
				  <div style="float:right;"><img src="/wp-content/uploads/2014/03/cross.png"></div>
				  <div style="margin-top:10px;"><img src="/wp-content/uploads/2014/03/t5.png"></div>
				 <br/>
                 Basic Bike Fit -<strong>Add $100.00</strong>			 
                 </div>		-->			 
				  

				<div class="clear"> </div>                   
			   </section>
			</section><!-- .content_wrapper -->
		
		
		</article>
		

		

	<?php woo_main_after(); ?>

    </div><!-- #content -->

<?php get_footer(); ?>