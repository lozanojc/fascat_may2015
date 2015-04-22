<?php
/**
 * The Template for displaying products in a product category. Simply includes the archive template.
 *
 * Override this template by copying it to yourtheme/woocommerce/taxonomy-product_cat.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if(is_product_category('powertap')) {
	
		get_header();
	?> 

	  <div id="content" class="page col-full">   
		<?php woo_main_before(); ?>

		<div class="custom_page_header page_headers shop_header" style="background: url(/wp-content/uploads/2015/01/powertap.png); ?>) no-repeat top center;">
	      <div class="header_txt">
                 <h2>PowerTap</h2>
                 <p><?php echo category_description();?></p>
           </div> 	
           
		</div>
		<?php include(locate_template('includes/powermeters-inner.php')); ?>

<?php } elseif(is_product_category('quarq')) {

	get_header(); 
		?>


	  <div id="content" class="page col-full">   
		<?php woo_main_before(); ?>

		<div class="custom_page_header page_headers shop_header" style="background: url(/wp-content/uploads/2015/01/fascat_quarq_header.jpg); ?>) no-repeat top center;">
	      <div class="header_txt">
	      		<h2>Quarq</h2>
                <p><?php echo category_description();?></p>
           </div> 	
           
		</div>
		<?php include(locate_template('includes/powermeters-inner.php')); ?>



<?php } elseif(is_product_category('garmin')) {

	get_header(); 
		?>


	  <div id="content" class="page col-full">   
		<?php woo_main_before(); ?>

		<div class="custom_page_header page_headers shop_header" style="background: url(/wp-content/uploads/2015/01/garmin.png); ?>) no-repeat top center;">
	      <div class="header_txt">
	      		<h2>Garmin</h2>
                 <p><?php echo category_description();?></p>
           </div> 	
		</div>
		<?php include(locate_template('includes/powermeters-inner.php')); ?>



<?php } elseif(is_product_category('srm')) {

	get_header(); 
		?>


	  <div id="content" class="page col-full">   
		<?php woo_main_before(); ?>

		<div class="custom_page_header page_headers shop_header" style="background: url(/wp-content/uploads/2015/01/fascat_srm_header.jpg); ?>) no-repeat top center;">
	      <div class="header_txt">
	      		<h2>SRM</h2>
	      		<p><?php echo category_description();?></p>
            </div> 	
		</div>
		<?php include(locate_template('includes/powermeters-inner.php')); ?>



<?php } elseif(is_product_category('stages')) {

	get_header(); 
		?>


	  <div id="content" class="page col-full">   
		<?php woo_main_before(); ?>

		<div class="custom_page_header page_headers shop_header" style="background: url(/wp-content/uploads/2015/01/stages.png); ?>) no-repeat top center;">
	      <div class="header_txt">
	      		<h2>Stages</h2>
	      		<p><?php echo category_description();?></p>
				</div> 
			</div>
		<?php include(locate_template('includes/powermeters-inner.php')); ?>



<?php } elseif(is_product_category('wahoo')) {

	get_header(); 
		?>


	  <div id="content" class="page col-full">   
		<?php woo_main_before(); ?>

		<div class="custom_page_header page_headers shop_header" style="background: url(/wp-content/uploads/2015/01/wahoo.png); ?>) no-repeat top center;">
	      <div class="header_txt">
	      		<h2>Wahoo Fitness</h2>
	      		<p><?php echo category_description();?></p>
	       </div> 	
           
		</div>
		<?php include(locate_template('includes/powermeters-inner.php')); ?>



<?php } ?>


<?php
woocommerce_get_template( 'archive-product.php' );

