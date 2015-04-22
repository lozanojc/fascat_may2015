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
          <header>
                <div class="custom_page_header" style="background: url(<?php echo($siteUrl = site_url());?>/wp-content/uploads/2014/06/page.jpg) no-repeat top center;">
			      <div class="header_txt" style="width:100%">
                    <h2><?php _e( 'Error 404 - Page not found!', 'fascat' ); ?></h2>
                    <p style="width:42%">What differentiates FasCat from other coaches and coaching groups is our COMMUNICATION.</p>
                    <a class="button small_txt" href="<?php echo $siteUrl?>/coaching/">How We Coach <i class="fa fa-chevron-right"></i></a>
                  </div>
			    </div>
	        </header>        

       <div class="content_wrapper">  
		<section class="fullwidth">

                <section class="entry">
                	<p><?php _e( 'The page you trying to reach does not exist, or has been moved. Please use the menus or the search box to find what you are looking for.', 'fascat' ); ?></p>
                </section>

		</section><!-- /#main -->

		<?php //woo_main_after(); ?>

	</div>	<!-- /.content_wrapper ends -->		

    </div><!-- /#content -->

<?php get_footer(); ?>
