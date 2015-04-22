<?php

// File Security Check

if ( ! function_exists( 'wp' ) && ! empty( $_SERVER['SCRIPT_FILENAME'] ) && basename( __FILE__ ) == basename( $_SERVER['SCRIPT_FILENAME'] ) ) {

    die ( 'You do not have sufficient permissions to access this page!' );

}

?>

<?php

/**
  * Template Name: Competiton
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

    <div id="content" class="col-full">

        <?php
        	if ( have_posts() ) { $count = 0;
        		while ( have_posts() ) the_post(); $count++;
        ?>

        <header>
           <div class="custom_page_header" style="background: url(<?php echo $cfs->get('header_image'); ?>) no-repeat top center;">
	      <div class="header_txt">
                <h2><?php echo $cfs->get('custom_header_heading'); ?></h2>
                <p><?php echo $cfs->get('custom_header_text'); ?></p>
             </div>
	  </div>
       </header>

	 <div class="grey_bg half_width">             
            <section class="entry col-full">
                <?php the_content(); ?>                    
             </section>
         </div>   <!-- /.half_width ends -->
            
         <div class="light_grey_bg half_width">
             <img class="upload_img" src="<?php echo $cfs->get('upload_image'); ?>" alt="competition Image" />
         </div>   <!-- /.half_width ends -->

	  <div class="clear"> </div>

    <?php } ?> 
        
    </div><!-- #content -->

<?php get_footer(); ?>