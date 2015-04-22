<?php

// File Security Check

if ( ! function_exists( 'wp' ) && ! empty( $_SERVER['SCRIPT_FILENAME'] ) && basename( __FILE__ ) == basename( $_SERVER['SCRIPT_FILENAME'] ) ) {

    die ( 'You do not have sufficient permissions to access this page!' );

}

?>

<?php

/**
  * Template Name: Tips
 *
 * Here we setup all logic and XHTML that is required for the index template, used as both the homepage
 * and as a fallback template, if a more appropriate template file doesn't exist for a specific context.
 *
 * @package WooFramework
 * @subpackage Template
 */

	get_header();

	

?>
  <section>
    <div id="content" class="col-full tips-content-cpt">
          <div class="custom_page_header page_headers tips-header" style="background: url(<?php echo $cfs->get('header_image'); ?>) no-repeat top center;">
	      	<div class="header_txt">
                 <h2><?php echo $cfs->get('custom_header_heading'); ?></h2>
                 <p><?php echo $cfs->get('custom_header_text'); ?></p>
             </div>

	   </div>
  </section>

	<section class="content_wrapper">

 <?php
        $args = array(
          'post_type' => 'tips',
          'posts_per_page' => -1,
          'orderby' => 'title',
          'order' => 'ASC'
        );
        $loop = new WP_Query( $args );
        
        while ( $loop->have_posts() ) : $loop->the_post(); ?>
          <li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
        <?php endwhile; // End the loop ?>
        </ul>
      </section>


	

       	<?php endwhile;  wp_reset_query(); ?> 

			    </section><!-- #main -->
            </article><!-- .post -->


             <div class="tips-cats">
              <h4 class="tips-cats-toggler">Categories</h4>
              <?php 
              wp_nav_menu( array( 
                  'theme_location' => 'tips-menu', 
                  'container' => '',
                  'menu_id' => 'tips-menu',
                  'menu_class' => 'cf sf-menu', 
                  'before' => '',
                  'fallback_cb' => '' 
              ) ); 
              ?>
             </div>
        
       </section><!-- .content_wrapper -->
<?php } ?>  

    </div><!-- #content -->

<?php get_footer(); ?>