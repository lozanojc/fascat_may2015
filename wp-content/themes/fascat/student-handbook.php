<?php

// File Security Check

if ( ! empty( $_SERVER['SCRIPT_FILENAME'] ) && basename( __FILE__ ) == basename( $_SERVER['SCRIPT_FILENAME'] ) ) {

    die ( 'You do not have sufficient permissions to access this page!' );

}

?>

<?php

/**
 * Template Name: Student Handbook
 *
 * This template is a About template file showing its content and Coaches.
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
                 <h2><?php echo $cfs->get('custom_header_heading'); ?></h2>
                 <p><?php echo $cfs->get('custom_header_text'); ?></p>
             </div>
	   </div>        

    	<section class="fullwidth content_wrapper">
            <ul id="submenu">
              <li><a href="<?php echo($siteUrl = site_url());?>/about/">Overview</a></li>
              <li><a href="<?php echo $siteUrl?>/about/partners/">Partners</a></li>
              <li><a href="<?php echo $siteUrl?>/careers/">Careers</a></li>
              <li><a href="<?php echo $siteUrl?>/contact-us/">Contact</a></li>
              <li class="active"><a href="<?php echo $siteUrl?>/athlete-handbook/">New Athlete Handbook</a></li>
              <li><a href="<?php echo $siteUrl?>/core-value/">Core Coaching Values</a></li>
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
        </section><!-- .content_wrapper --> 

	<?php //woo_main_after(); ?>

    </div><!-- /#content -->

<?php get_footer(); ?>
