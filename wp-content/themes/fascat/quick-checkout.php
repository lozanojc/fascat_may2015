<?php
// File Security Check
if ( ! empty( $_SERVER['SCRIPT_FILENAME'] ) && basename( __FILE__ ) == basename( $_SERVER['SCRIPT_FILENAME'] ) ) {
    die ( 'You do not have sufficient permissions to access this page!' );
}
/**
 * Template Name: Quick Check out using stripe
 *
 * This template is the default page template. It is used to display content when someone is viewing a
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
							<div class="custom_page_header" style="background: url('/wp-content/uploads/2014/03/FasCat_v4.png') no-repeat top center;">
								<div class="header_txt" style="width:100%">
									<h2><?php the_title();?></h2>
									<p style="width:42%"><?php echo $cfs->get('text_contents');?></p>
							
								</div>
							</div>
						</header>  
						<section class="entry">  
								<section class="form-container">

					                <article <?php post_class(); ?>>
					                	<div><?php the_content(); ?></div>

					                    

						     				<section class="sidebar-content">
												<?php echo $cfs->get('sidebar_1');?>
					               			</section>

					               			<section class="sidebar-content">
												<?php echo $cfs->get('sidebar_2');?>
					               			</section>

					               			<section class="sidebar-content">
												<?php echo $cfs->get('sidebar_3');?>
					               			</section>

						             	<section class="form-container">
						             		<?php echo $cfs->get('questions_form');?>
						             	</section>



										<?php edit_post_link( __( '{ Edit }', 'fascat' ), '<span class="small">', '</span>' ); ?>



					                </article><!-- /.post -->
				               </section>
						

				        </div>


				
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

   

<?php get_footer(); ?>
