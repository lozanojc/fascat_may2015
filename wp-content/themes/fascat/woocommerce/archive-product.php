<?php
// File Security Check
if ( ! empty( $_SERVER['SCRIPT_FILENAME'] ) && basename( __FILE__ ) == basename( $_SERVER['SCRIPT_FILENAME'] ) ) {
    die ( 'You do not have sufficient permissions to access this page!' );
}
/**
 * Template Name: ecommerce_landing
 *
 * This template is a full-width version of the page.php template file. It removes the sidebar area.
 *
 * @package WooFramework
 * @subpackage Template
 */
	global $woo_options;
    $categoryUrl = FasCat::getCategoryUrl();
    $siteUrl = FasCat::getSiteUrl();
?>

   <style>

#sidebar {
    display: none;
}

 p{
    margin: 0px;
}
.bx-wrapper img{
display: inline-table;
}

.srm_left1 .slides a {
    bottom: 85px;
    left: 410px;
    margin: 0;
    top: 0;
    z-index: 9999;
}
	
	
.srm_right1 .slides a {
    bottom: 85px;
    left: 410px;
    margin: 0;
    top: 0;
    z-index: 9999;
}
</style>    

 





		<?php if(!is_product_category('classes')){?>
		
		<?php }?>

		 
	<?php if(is_shop()){//show all this content on the main shop archive
		get_header();

		?>

	   <div id="content" class="page col-full">   
		<?php woo_main_before(); ?>


				<div class="custom_page_header page_headers shop_header" style="background: url(/wp-content/uploads/2015/01/fascat_header_v1__0002_shop.jpg); ?>) no-repeat top center;">
			      <div class="header_txt">
		                 <h2>Any retailer can sell you a powermeter, 
		                 	<br> 
		                 	but only <span class="orange">FasCat</span> can show you how to
		                 	<br>
		                 	use it by coaching you for FREE
		                 	<br>
		                 	for one month.</h2>
		           </div> 	
				</div>
				<?php include(locate_template('includes/powermeters.php')); ?>
		
	<div class="products-page-main">
		<?php $args = array(
			'posts_per_page' => 10,
			'product_cat' => 'featured-products',
			'post_type' => 'product',
			'orderby' => 'title',
		); ?>		   <div id="content" class="page col-full">   
		<?php woo_main_before(); ?>
		<article>
			<section class="content_wrapper" id="train">
				<section class="entry fix">
					<div class="dura_ace">
						<?php $the_query = new WP_Query( $args );
					
						while ( $the_query->have_posts() ) { // The Loop
							$the_query->the_post();
							?>					
							
							
							<div class="dura_product12">
								<a href="<?php the_permalink() ?>"><div><?php the_post_thumbnail('full'); ?></div></a>
							
					
								<h5>
									<div>
										<a href="<?php the_permalink() ?>"><?php echo get_the_title();?></a>
									</div>
								</h5>
						
								<div class="prices_add22">
									<?php if ( $price_html = $product->get_price_html() ) : ?>
										<div class="srm_price22">
											<span><?php echo $price_html; ?></span>
										</div>
									<?php endif; ?>
						
									<div class="srm_add22">
										<a href="<?php the_permalink() ?>">ADD &nbsp; <img src="<?php echo $siteUrl?>/wp-content/uploads/2014/04/shop.png"/></a>
									</div>
								</div>
							
							</div>	<!-- featured_image ends -->
					
					<?php 	} ?>
					
					
					</div>
					
					<div class="clear"></div>                   
				</section>
			</section><!-- .content_wrapper -->
		</article>
	</div>

<?php } // end main is shop

else{ //do the category loop
    if(is_product_category('on-sale')){
		// Get products on sale, from the built-in shortcode
        delete_transient('wc_products_onsale');
		$product_ids_on_sale = wc_get_product_ids_on_sale();
        //var_dump($product_ids_on_sale);

		$meta_query   = array();
		$meta_query[] = WC()->query->visibility_meta_query();
		$meta_query[] = WC()->query->stock_status_meta_query();
		$meta_query   = array_filter( $meta_query );

		$args = array(
			'posts_per_page'	=> -1,
			'orderby' 			=> 'title',
			'order' 			=> 'ASC',
			'no_found_rows' 	=> 1,
			'post_status' 		=> 'publish',
			'post_type' 		=> 'product',
			'meta_query' 		=> $meta_query,
			'post__in'			=> array_merge( array( 0 ), $product_ids_on_sale )
		);?>

<article>
		    <section class="content_wrapper" id="train">
	            <section class="entry fix">
				<div class="dura_ace">
				
					<?php $the_query = new WP_Query( $args );$count = 0;
							// The Loop
							while ( $the_query->have_posts() ) {
								$the_query->the_post();$count++; global $product;//var_dump($product);?>
								
								<div class="dura_product">
									<?php if($product->is_on_sale()){ ?>
										<span class="onsale">Sale!</span>
									<?php }?>
						
								<a href="<?php echo($link = get_the_permalink());?>"><div><?php the_post_thumbnail('full'); ?></a></div>
									<br/>
						
								<div style="height:102px;"><h5><a href="<?php echo $link;?>"><?php echo get_the_title();?></a></h5><!--<span>category</span>--></div>
								
								<div class="prices_add22">
									<?php if ( $price_html = $product->get_price_html() ) : ?>
										<div class="srm_price22">
											<span><?php echo $price_html; ?></span>
										</div>
									<?php endif; ?>
									
									<div class="srm_add22">
										<a href="<?php echo $link;?>">ADD &nbsp; <img src="<?php echo $siteUrl?>/wp-content/uploads/2014/04/shop.png"/></a>
		                			</div>	<!-- featured_image ends -->
                      			</div>
					  		</div>
					  	<?php }?>
	
					</div>
				  

				  <div class="clear"> </div>                   
			   </section>
			</section><!-- .content_wrapper -->
		
		
</article>
<?php } else{?>

<article>
		    <section class="content_wrapper" id="train">
	            <section class="entry fix">
				<div class="dura_ace">
				
					<?php 
                if ( have_posts() ) { $count = 0;$currency = get_woocommerce_currency_symbol();
        		while ( have_posts() ) { the_post(); $count++; global $product;?>
					<div class="dura_product12">
                    <?php if($isSale = $product->is_on_sale()){?>
                        <div class="onsale">Sale!</div>
                    <?php }?>
            	        <a href="<?php echo($link = get_the_permalink());?>"><div><?php the_post_thumbnail('full'); ?></div></a><br/>
						<h5><div><a href="<?php echo($link);?>"><?php echo get_the_title();?></a></div></h5><!--<span>category</span>-->
                        <div class="prices_add22">
                    <?php if('' !== ($price = $product->get_price())){?>
                          <div class="srm_price22<?php if($isSale)echo ' sale';?>"><span class="amount"><?php echo $currency . $price; ?></span></div>
                    <?php }?>
                          <div class="srm_add22">
                              <a href="<?php echo $link?>">ADD&nbsp;&nbsp;<img src="<?php echo $siteUrl?>/wp-content/uploads/2014/04/shop.png"/></a>
                          </div>
                        </div>
                      </div>	<!-- featured_image ends -->
						
						<?php 	} ?>
	

						
		 	 </div>
				  

				  <div class="clear"> </div>                   
			   </section>
			</section><!-- .content_wrapper -->
		
		
		</article>
    
<?php }}} ?>
		
				
			
	<?php woo_main_after(); ?>

    </div><!-- #content -->
<?php get_footer(); ?>
