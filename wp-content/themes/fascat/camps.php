<?php
// File Security Check
if ( ! function_exists( 'wp' ) && ! empty( $_SERVER['SCRIPT_FILENAME'] ) && basename( __FILE__ ) == basename( $_SERVER['SCRIPT_FILENAME'] ) ) {
    die ( 'You do not have sufficient permissions to access this page!' );
}
/**
 * Template Name: Camps
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

        <?php woo_main_before(); ?>
        
           <?php query_posts(array(
            	    'post_type'=> 'camps',
	  	    'posts_per_page' => 1,
	  	    'orderby' => 'post_date',
	  	    'order' => 'DESC',
	      	 ));
           ?>

        <?php

        	if ( have_posts() ) { $count = 0;

        		while ( have_posts() ) the_post(); $count++;

        ?>

		<article <?php post_class(); ?>>

	           <header>
                      <div class="custom_page_header" style="background: url(<?php echo $cfs->get('header_image'); ?>) no-repeat top center;">
			   <div class="header_txt">
                          <h2>Camps</h2>
		            <p><?php echo($title = get_the_title());?></p>
	                    <a class="button small_txt" href="<?php echo($mailTo = 'info@fascatcoaching.com?subject=' . urlencode($title));?>">Sign Up <img class="right_arrow" src="<?php echo get_template_directory_uri() ?>/images/right_arrow.png" alt="right arrow icon" /></a>

	                 </div>
			 </div>
	             </header>

	                
    			<section class="content_wrapper">
	                <section class="entry fix">
	                	 <ul id="submenu">
              <li<?php if('fascat-custom-coachingtraining-camps' === $post->post_name){echo ' class="active"';}?>><a href="<?php echo($siteUrl = site_url());?>/camps/fascat-custom-coachingtraining-camps">Custom 1 on 1 weekend</a></li>
              <li<?php if('jeremy-powers-cyclocross' === $post->post_name){echo ' class="active"';}?>><a href="<?php echo $siteUrl?>/camps/jeremy-powers-cyclocross/">Jeremy Powers Cyclocross</a></li>
              <li<?php if('mountain-bike-skills-clinic-with-myles-rockwell' === $post->post_name){echo ' class="active"';}?>><a href="<?php echo $siteUrl?>/camps/mountain-bike-skills-clinic-with-myles-rockwell">MTB Skill Clinic</a></li>
              <li<?php if('junior-training-group-with-fascat-coaching' === $post->post_name){echo ' class="active"';}?>><a href="<?php echo $siteUrl?>/camps/junior-training-group-with-fascat-coaching">Junior Training Group</a></li>
              <li<?php if('fascat-cycleops-power-training-camp-with-timmy-duggan' === $post->post_name){echo ' class="active"';}?>><a href="<?php echo $siteUrl?>/camps/fascat-cycleops-power-training-camp-with-timmy-duggan">Cycleops Power Camp</a></li>
            </ul>
	                	<?php the_content(); ?> 
				<div class="clear"> </div>                   
			   </section>
			</section><!-- .content_wrapper -->
            </article><!-- .post -->

       	<?php } ?>  
        
        <div class="dots_bg camps_listing">
	     <?php query_posts(array(
            	    'post_type'=> 'camps',
	  	    'posts_per_page' => 4,
	  	    'orderby' => 'post_date',
	  	    'order' => 'DESC',
	      	  ));
            ?>
               
            <div class="content_wrapper">
		<h2>Camps</h2>

           <?php if (have_posts()) : while (have_posts()) : the_post(); 
	   	  $thumbnail = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full');
		  $i++; //add 1 to the total count
           ?>

              <div class="featured_image">
            	  <a href="<?php the_permalink(); ?>">
		     <?php the_post_thumbnail(); ?>
		     <div class="overlay">
		     	<h5><?php the_title(); ?></h5>
		     </div>	<!-- .overlay ends -->
		     <div class="magnifier"> </div>
		  </a>
		</div>	<!-- featured_image ends -->
            
            	<?php endwhile;?>
		<?php endif; ?>

		<div class="clear"> </div>

	     </div>	<!-- .content_wrapper ends -->

        </div>  <!-- camps_listing ends -->

	<?php woo_main_after(); ?>

    </div><!-- #content -->

<?php get_footer(); ?>
