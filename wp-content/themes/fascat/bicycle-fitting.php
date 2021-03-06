<?php

// File Security Check

if ( ! empty( $_SERVER['SCRIPT_FILENAME'] ) && basename( __FILE__ ) == basename( $_SERVER['SCRIPT_FILENAME'] ) ) {

    die ( 'You do not have sufficient permissions to access this page!' );

}

?>

<?php

/**

 * Template Name: Bicycle Fitting

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

          <div class="custom_page_header page_headers" style="background: url(<?php echo $cfs->get('header_image'); ?>) no-repeat top center;">
	      <div class="header_txt">
                 <h1><?php the_title(); ?></h1>
                 <p><?php echo $cfs->get('custom_header_text'); ?></p>
		   <a class="button small_txt" href="<?php echo $cfs->get('button_url'); ?>"><?php echo $cfs->get('button_text'); ?> <img class="right_arrow" src="<?php echo get_template_directory_uri() ?>/images/right_arrow.png" alt="right arrow icon" /></a>
             </div>
	   </div>        

       <div class="content_wrapper">  
		<section class="fullwidth">
            <ul id="submenu">
              <li><a href="<?php echo get_site_url(); ?>/services/physiological-testing/">Physiological Testing</a></li>
              <li class="active"><a href="<?php echo get_site_url(); ?>/services/bicycle-fitting/">Bicycle Fitting</li>
            </ul>
        <div class="clear"></div>                                                   
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
	
	
	
	
	
	
	
	
	<?php include(locate_template('includes/testimonials.php')); ?>
	
	
	
	
	
    </div><!-- /#content -->

		

<?php get_footer(); ?>
