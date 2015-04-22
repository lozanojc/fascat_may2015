<?php
// File Security Check
if ( ! function_exists( 'wp' ) && ! empty( $_SERVER['SCRIPT_FILENAME'] ) && basename( __FILE__ ) == basename( $_SERVER['SCRIPT_FILENAME'] ) ) {
    die ( 'You do not have sufficient permissions to access this page!' );
}

/**
 * Template Name: Price-Plan
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
<style>
a {
    color: #fff;
    font-weight: bold;
    text-decoration: none;
}

</style>

    <div id="content" class="col-full" style="background-color:#f4f4f4;">

        <?php woo_main_before(); ?>
        
           <?php query_posts(array(
            	    'post_type'=> 'Price_Plan',
	  	    'posts_per_page' => 1,
	  	    'orderby' => 'post_date',
	  	    'order' => 'DESC',
	      	 ));
           ?>

        <?php

        	if ( have_posts() ) { $count = 0;

        		while ( have_posts() ) : the_post(); $count++;

        ?>

		<article <?php post_class(); ?>>

	           <header>
                      <div class="custom_page_header" style="background: url(<?php echo $cfs->get('header_image'); ?>) no-repeat top center;">
			   <div class="header_txt">
                          <h2><?php the_title(); ?></h2>
		            <p><?php the_content(); ?></p>
	                 

	                 </div>
			 </div>
	             </header>
            </article><!-- .post -->
			            
            	<?php endwhile;?>
          <?php } ?>  

        
		
		<article>
		    <section class="content_wrapper" id="train">
	            <section class="entry fix">
					<?php /*
						<ul id="submenu">
						<li<?php if('coaching' === $post->post_name){echo ' class="active"';}?>><a href="<?php echo($siteUrl = site_url())?>/coaching/">How We Coach</a></li>
						<li<?php if('price-plan-for-our-3-courses' === $post->post_name){echo ' class="active"';}?>><a href="<?php echo $siteUrl?>/coaching/price-plan/">Pricing Plan</a></li>
						<li<?php if('fascat-coaches' === $post->post_name){echo ' class="active"';}?>><a href="<?php echo $siteUrl?>/coaching/fascat-coaches/">FasCat Coaches</a></li>
						<li<?php if('fascat-athletes' === $post->post_name){echo ' class="active"';}?>><a href="<?php echo $siteUrl?>/coaching/fascat-athletes/">FasCat Athletes</a></li>
						<li<?php if('get-started' === $post->post_name){echo ' class="active"';}?>><a href="<?php echo $siteUrl?>/coaching/get-started/">Get Started</a></li>
						<li<?php if('tips' === $post->post_name){echo ' class="active"';}?>><a href="<?php echo $siteUrl?>/tips/">Training Tips</a></li>
						</ul>
					*/ ?>
					
					<div style="width:100%;">
						<div class="view_plan">
							<h1>Select a Plan</h1>
					   </div>
					
					   <?php /*
					    <div class="contact_details">
							<ul>
							   <li><span class="mob"></span>Call us now on <strong> 720 406 7444</strong> or</li>
							   <li><span class="eml"></span>Email:<a href="mailto:info@fascatcoaching.com">info@fascatcoaching.com</a></li>
							   <li><a href="<?php get_site_url(); ?>/contact-us" style="font-weight:normal; float:right;">visit our Performance Center</a></li>
							</ul>				   
					    </div>
					    */ ?>
					</div>
					
				<br clear="all" />	
				
				<?php include(locate_template('includes/price-plan.php')); ?>
				              
			</section>
		</section><!-- .content_wrapper -->
	</article>
		

	<?php woo_main_after(); ?>
	
	
	<div id="plan_contact">
		<h2>Need help?</h2>
		<h4>Let us help you find a plan thats<br />right for you.</h4>
		
		<ul>
		<li><strong>Call us:</strong> <a href="tel:17204067444">now on 720 406 7444 or</a></li>
		<li><strong>Email:</strong> <a href="mailto:info@fascatcoaching.com">info@fascatcoaching.com</a></li>
		<li><strong>Visit:</strong> <a href="https://www.google.com/maps/place/FasCat+Coaching/@40.05726,-105.281829,17z/data=!3m1!4b1!4m2!3m1!1s0x876beee3bc72864d:0x74bae9aec984c4da" target="_blank">The Performance Center</a></li>
		</ul>
	</div>
	


    </div><!-- #content -->

<?php get_footer(); ?>
