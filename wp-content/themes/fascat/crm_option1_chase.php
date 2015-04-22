<?php

// File Security Check

if ( ! empty( $_SERVER['SCRIPT_FILENAME'] ) && basename( __FILE__ ) == basename( $_SERVER['SCRIPT_FILENAME'] ) ) {

    die ( 'You do not have sufficient permissions to access this page!' );

}

?>

<?php

/**
 * Template Name: CRM_Ootion1_Chase
 *
 * This template is a About template file showing its content and Coaches.
 *
 * @package WooFramework
 * @subpackage Template
 */

	get_header();

	global $woo_options;

?>

<style>
.header_txt h2{
    font: 32px/44pt 'Open Sans';
    margin: 0;
}
.header_txt p {
   font: 13px/20pt 'Open Sans';
    margin: 0;
}
.page_headers .header_txt p, .page_headers .header_txt h2 {
    color: #ffffff;
}
.col_two {
    float: left;
    width: 64%;
}
.col_three {
    float: left;
    padding: 0 3% 0 0;
    width: 32.333%;
}
.col_three h1{
    font-size: 36px;
    font-weight: bold;
}

.srm img {
    float: left;
    height: 50px;
    width: 60px;
}
.phone{
width:26%!important;
float:left;
}
.gender{
width:30%!important;
float:left;
margin-left:42px
}
.feild{
width:100%!important;
float:left;
}
.check{ background-color: #f94b06;}
.wpcf7-list-item-label {
    margin-left: -11px;
    position: relative;
    top: -5px;
}
p{
color:#000;
}
#contact-page ol.forms label {
    color: #000000;
    display: block;
    font-size: 12px;
    font-weight: bold;
    line-height: 20px;
    margin: 0;
    padding-bottom: 10px;
}
input[type="text"], input.input-text, textarea, input.txt, input[type="tel"], input[type="email"] {
border: 3px solid #C7C7C7;
 padding: 0.6em 0.5em;
}
</style>

       <div id="content" class="page col-full">

        <?php woo_main_before(); ?>
        
        <?php
        	if ( have_posts() ) { $count = 0;
        		while ( have_posts() )  the_post(); $count++;
        ?>  

        
          <div class="custom_page_header page_headers" style="background: url(<?php echo $cfs->get('header_image'); ?>) no-repeat top center;">
	      <div class="header_txt">
                 <h2><?php echo $cfs->get('custom_header_heading'); ?></h2>
                 <p><?php echo $cfs->get('custom_header_text'); ?></p>
             </div>
	   </div>        

    	<section class="fullwidth content_wrapper">

                <article id="contact-page" class="page">

                    <section class="entry">
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
<h5><?php _e('SUBTOTAL', 'woocommerce'); ?> : <span style="color:#f94b06;"><?php echo $woocommerce->cart->get_cart_subtotal(); ?><span></h5>
</div>
<div style="width: 100%; margin-top: 20px; min-height: 54px;">
<?php global $woocommerce; ?>
 <div class="view"><a class="cart-contents" href="<?php echo $woocommerce->cart->get_cart_url(); ?>" title="<?php _e('View your shopping cart', 'woothemes'); ?>">VIEW CART</a></div>
<div class="check"><a href="<?php echo $woocommerce->cart->get_checkout_url();?>">CHECKOUT</a>
</div>
</div>
<div class="clear"> </div>  
<div class="border"></div>
<div style="text-align: left; margin-top: 10px;">
<h5>Would you like to upgrade?</h5>
</div>

			<?php $args = array(
        'posts_per_page' => 3,
        'product_cat' => 'price_plan',
        'post_type' => 'product',
        'orderby' => 'title',
    );

	?>

						<?php $the_query = new WP_Query( $args );
	// The Loop
	while ( $the_query->have_posts() ) {
		$the_query->the_post();
		

?>

<div class="upgrade">
<div class="squaredFour">
	<input type="checkbox" value="None 1" id="squaredFour" name="check" />
	<label for="squaredFour"></label>
</div><?php the_post_thumbnail('full'); ?><span><?php echo '' . get_the_title() . '';?><br/><?php echo $cfs->get('text_contents'); ?></span></div>

<?php } ?> 

		   
		   		<?php $args = array(
        'posts_per_page' => 3,
        'product_cat' => 'kill',
        'post_type' => 'product',
        'orderby' => 'title',
    );

	?>
			<?php $the_query = new WP_Query( $args );
	// The Loop
	while ( $the_query->have_posts() ) {
		$the_query->the_post();
		?>
 
<div class="clear"> </div>  
<div class="upgrade"><div class="squaredFour">
	<input type="checkbox" value="None 2" id="squaredFour" name="check" />
	<label for="squaredFour"></label>
</div><?php the_post_thumbnail('full'); ?><span><?php echo '' . get_the_title() . '';?></br><?php echo $cfs->get('text_contents'); ?></span></div>

<?php } ?> 
</div>
</div>
	             </section><!-- /.entry -->

		    <?php edit_post_link( __( '{ Edit }', 'fascat' ), '<span class="small">', '</span>' ); ?>

                </article><!-- /.post -->

		  <?php

		    } // End WHILE Loop
        
 ?> 


        
        </section><!-- .content_wrapper --> 

	<?php //woo_main_after(); ?>

    </div><!-- /#content -->

<?php get_footer(); ?>