<?php

// File Security Check

if ( ! empty( $_SERVER['SCRIPT_FILENAME'] ) && basename( __FILE__ ) == basename( $_SERVER['SCRIPT_FILENAME'] ) ) {

    die ( 'You do not have sufficient permissions to access this page!' );

}

?>

<?php

/**

 * Template Name: Products

 *

 * This template is a full-width version of the page.php template file. It removes the sidebar area.

 *

 * @package WooFramework

 * @subpackage Template

 */

	get_header();

	global $woo_options;

?>

       

    <div id="content" class="page col-full">   

    	<?php woo_main_before(); ?>

        <?php
        	if ( have_posts() ) { $count = 0;
        		while ( have_posts() ) { the_post(); $count++;
        ?>  


<div class="slides">
    <div class="bxslider">

	 <?php

	    /*
   		A loop field named "products_slider" with sub-fields "slider_image", "headline", "products_intro", "read_more"
        Loop fields return an associative array containing *ALL* sub-fields and their values
   		NOTE: Values of sub-loop fields are returned when using get() on the parent loop!
	    */

        $fields = $cfs->get('products_slider', FasCat::WC_SLIDER_ID);
	     if (!empty($fields)) {
         foreach ($fields as $field) {
            echo "<div class='slider' style='background: url({$field['slider_image']}) no-repeat top center #000;'>";
            echo "<div class='content_wrapper'><div class='product_headline'>{$field['headline']}</div>";
            echo "<div class='product_intro'>{$field['products_intro']}</div>";
            echo "<a class='read_more' href='{$field['product_url']}'>Read More</a></div></div>";
		}
	    }
	 ?>
     	
    </div>  <!-- bxslider ends --> 
	<h2 class="icon1"><img src="<?php echo get_template_directory_uri() ?>/images/slider_Cart.png" alt="slider cart icon" /> FREE U.S. SHIPPING NO TAX</h2>
	<h2 class="icon2"><img src="<?php echo get_template_directory_uri() ?>/images/slider_assist.png" alt="slider assist icon" /> FREE Technical Assistance for LIFE!</h2>      
</div>	<!-- class slides ends -->

       <div class="content_wrapper">  
		<section class="fullwidth">                                                    
                <article <?php post_class(); ?>>

                    <section class="entry">

	                	<?php the_content(); ?>

	             </section><!-- /.entry -->



					<?php edit_post_link( __( '{ Edit }', 'fascat' ), '<span class="small">', '</span>' ); ?>



                </article><!-- /.post -->

                                                    

			<?php

					} // End WHILE Loop

				} else {

			?>

				<article <?php post_class(); ?>>

                	<p><?php _e( 'Sorry, no posts matched your criteria.', 'fascat' ); ?></p>

                </article><!-- /.post -->

            <?php } ?>  

        

		</section><!-- /#main -->

		

		<?php //woo_main_after(); ?>

	</div>	<!-- /.content_wrapper ends -->		

    </div><!-- /#content -->

		

<?php get_footer(); ?>
