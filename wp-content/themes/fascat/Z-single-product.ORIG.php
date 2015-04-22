<?php
// File Security Check
if ( ! empty( $_SERVER['SCRIPT_FILENAME'] ) && basename( __FILE__ ) == basename( $_SERVER['SCRIPT_FILENAME'] ) ) {
    die ( 'You do not have sufficient permissions to access this page!' );
}
/**
 * Single Post Template
 *
 * This template is the default page template. It is used to display content when someone is viewing a
 * singular view of a post ('post' post_type).
 * @link http://codex.wordpress.org/Post_Types#Post
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
                <div class="custom_page_header" style="background: url(<?php echo($siteUrl = site_url());?>/wp-content/uploads/2014/06/page.jpg) no-repeat top center;">
			      <div class="header_txt" style="width:100%">
                    <h2><?php the_title();?></h2>
                    <p style="width:42%">What differentiates FasCat from other coaches and coaching groups is our COMMUNICATION.</p>
                    <a class="button small_txt" href="<?php echo $siteUrl?>/coaching/">How We Coach <i class="fa fa-chevron-right"></i></a>
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
