<?php
// File Security Check
if ( ! empty( $_SERVER['SCRIPT_FILENAME'] ) && basename( __FILE__ ) == basename( $_SERVER['SCRIPT_FILENAME'] ) ) {
    die ( 'You do not have sufficient permissions to access this page!' );
}
/**
 * Template Name: custom checkout
 *
 * This template is the custom checkout. It is used to display content when someone is viewing a
 * singular view of a page ('page' post_type) unless another page template overrules this one.
 * @link http://codex.wordpress.org/Pages
 *
 * @package WooFramework
 * @subpackage Template
 */
	get_header();
	global $woo_options;
?>
    <div id="content" class="page col-full">   
     	<?php woo_main_before();
		 	if ( have_posts() ) { $count = 0;
            while ( have_posts() ) { the_post();?>
				

			<header>
                <div class="custom_page_header" style="background: url(<?php echo $cfs->get('header_image'); ?>) no-repeat top center;">
			      <div class="header_txt" style= "top:70px">
                    <h2><?php echo $cfs->get('custom_header_heading'); ?></h2>
                    <p><?php echo $cfs->get('custom_header_text'); ?></p>
                    <a class="button small_txt" href="<?php echo $cfs->get('button_url'); ?>"><?php echo $cfs->get('button_text'); ?> <i class="fa fa-chevron-right"></i></a>
                  </div>
			    </div>
	        </header>
      

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
