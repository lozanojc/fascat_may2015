<?php
// File Security Check
if ( ! function_exists( 'wp' ) && ! empty( $_SERVER['SCRIPT_FILENAME'] ) && basename( __FILE__ ) == basename( $_SERVER['SCRIPT_FILENAME'] ) ) {
    die ( 'You do not have sufficient permissions to access this page!' );
}
/**
 * Template Name: Coaching
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
        
           <?php /*query_posts(array(
            	    'post_type'=> 'coach',
	  	    'posts_per_page' => 1,
	  	    'orderby' => 'post_date',
	  	    'order' => 'DESC',
	      	 ));*/
           ?>

        <?php

        	if ( have_posts() ) { $count = 0;

        		while ( have_posts() ) : the_post(); $count++;
//var_dump(get_post_meta(get_the_ID()));echo"<br/>\nPost Type: ";global $post;var_dump($post->post_type);
        ?>

		<article <?php post_class();?>>

	        <header>
                <div class="custom_page_header" style="background: url(<?php echo $cfs->get('header_image'); ?>) no-repeat top center;">
			      <div class="header_txt" style= "top:70px">
                    <h2><?php echo $cfs->get('custom_header_heading'); ?></h2>
                    <p><?php echo $cfs->get('custom_header_text'); ?></p>
                    <a class="button small_txt" href="<?php echo $cfs->get('button_url'); ?>"><?php echo $cfs->get('button_text'); ?> <i class="fa fa-chevron-right"></i></a>
                  </div>
			    </div>
	        </header>
				 
				<section class="content_wrapper">
	                <section class="entry fix">
            <ul id="submenu">
              <li<?php if('coaching' === $post->post_name){echo ' class="active"';}?>><a href="<?php echo($siteUrl = site_url())?>/coaching/">How We Coach</a></li>
              <li<?php if('price-plan-for-our-3-courses' === $post->post_name){echo ' class="active"';}?>><a href="<?php echo $siteUrl?>/price-plan/">Pricing Plan</a></li>
              <li<?php if('fascat-coaches' === $post->post_name){echo ' class="active"';}?>><a href="<?php echo $siteUrl?>/coaching/fascat-coaches/">FasCat Coaches</a></li>
              <li<?php if('fascat-athletes' === $post->post_name){echo ' class="active"';}?>><a href="<?php echo $siteUrl?>/coaching/fascat-athletes/">FasCat Athletes + Testimonials</a></li>
              <li<?php if('get-started' === $post->post_name){echo ' class="active"';}?>><a href="<?php echo $siteUrl?>/price-plan/">Get Started</a></li>
              <li<?php if('tips' === $post->post_name){echo ' class="active"';}?>><a href="<?php echo $siteUrl?>/tips/">Training Tips</a></li>
			 
            </ul>
					<div style="width:100%;">
						<div class="view_plan">
							<h2 class="coaching-page"><img src="<?php echo $siteUrl?>/wp-content/uploads/2014/04/how.png" class="inline"/>   How We Coach</h2>
					   </div>
                    </div>

                    <?php the_content();?>			

				        <div class="clear"> </div>                   
			       </section>
			    </section><!-- .content_wrapper -->
        </article><!-- .post -->
			            
            	<?php endwhile;?>
          <?php } ?>  

        
		
		<article>
		    <section class="content_wrapper" id="train">
	            <section class="entry fix">

					<!--<div class="coach_product">

					    <div class="featured_image12" style="margin-left:3%; margin-top:4%;">
            	            <a href=""><img src="<?php echo $siteUrl?>/wp-content/uploads/2014/04/c1.png"/>
							   <h5 style="color:#fa6327;">1.<br/>Consult </h5>
		    
		                    </a>
		               </div>
					    <div class="featured_image12" style="margin-left:3%; margin-top:4%;">
            	            <a href=""><img src="<?php echo $siteUrl?>/wp-content/uploads/2014/04/c2.png"/>
							   <h5 style="color:#fa6327;">2.<br/>plan</h5>
		    
		                    </a>
		               </div>
					    <div class="featured_image12" style="margin-left:3%; margin-top:4%;">
            	            <a href=""><img src="<?php echo $siteUrl?>/wp-content/uploads/2014/04/c3.png"/>
							   <h5 style="color:#fa6327;">3.<br/>Communicate</h5>
		    
		                    </a>
		               </div>
					    <div class="featured_image12" style="margin-left:3%; margin-top:4%;">
            	            <a href=""><img src="<?php echo $siteUrl?>/wp-content/uploads/2014/04/c4.png"/>
							   <h5 style="color:#fa6327;">4.<br/>Ride </h5>
		    
		                    </a>
		               </div>
					    <div class="featured_image12" style="margin-left:3%; margin-top:4%;">
            	            <a href=""><img src="<?php echo $siteUrl?>/wp-content/uploads/2014/04/c5.png"/>
							   <h5 style="color:#fa6327;">5.<br/>Feedback (words & power data) </h5>
		    
		                    </a>
		               </div>
					    <div class="featured_image12" style="margin-left:3%; margin-top:4%;">
            	            <a href=""><img src="<?php echo $siteUrl?>/wp-content/uploads/2014/04/c6.png"/>
							   <h5 style="color:#fa6327;">6.<br/>Analyze </h5>
		    
		                    </a>
		               </div>
					    <div class="featured_image12" style="margin-left:3%; margin-top:4%;">
            	            <a href=""><img src="<?php echo $siteUrl?>/wp-content/uploads/2014/04/c7.png"/>
							   <h5 style="color:#fa6327;">7.<br/>Communicate</h5>
		    
		                    </a>
		               </div>
					    <div class="featured_image12" style="margin-left:3%; margin-top:4%;">
            	            <a href=""><img src="<?php echo $siteUrl?>/wp-content/uploads/2014/04/c8.png"/>
							   <h5 style="color:#fa6327;">8.<br/>Achieve </h5>
		    
		                    </a>
		               </div>				   
					
					<div class="clear"> </div>
					
					<div style="width:100%;">
						<div class="view_plan" style="margin-top:50px;">
						<h5>New Athlete Handbook<br/>(can we password protect this to only serious inquiries?) to<br/>better explain the above?</h5>
                        <div class="coach_button"><a href="">GO TO HANDBOOK</a></div>
					   </div>
					   
					   	<div class="contact_details">
                        <img src="<?php echo $siteUrl?>/wp-content/uploads/2014/04/daire.png"/>
					    </div>
                    </div>
					
					</div>

					<div class="clear"> </div>-->                   
			   </section>
			</section><!-- .content_wrapper -->
		
		
		</article>
		
		<div class="coach_bg">
			<article>
		         <section class="content_wrapper" id="train">
	                <section class="entry fix">
		             <div class="coach_view"><h2 class="coaching-page"><img src="<?php echo $siteUrl?>/wp-content/uploads/2014/04/alaram.png"/>&nbsp;Coaching Plans</h2></div>
					
					 
					 	<?php /* ?>
					    <?php $currency = get_woocommerce_currency_symbol();
					        $the_query = new WP_Query(array(
					            'posts_per_page' => 3,
					            'product_cat' => 'coaching',
					            'post_type' => 'product',
					            'order' => 'asc')
					        );
					        // The Loop
					        while ( $the_query->have_posts() ) {
					            $the_query->the_post();?>
					               <div class="col_three" style="padding:0px; width: 33.332%;">
									    <div class="index1">
										 <?php the_post_thumbnail('full'); ?>
										<h1><?php echo '' . get_the_title() . '';?></h1>
						                <span><?php echo($currency . $product->get_price());?></span>
										<?php $meta = get_post_meta(get_the_ID(), 'week_block', true);?>
										<p><?php echo $meta; ?></p>
										<div class="start_now"><a href="<?php the_permalink() ?>">Start Now</a></div>
										<!--<div class="start_now"><a href="#">Start Now</a></div>-->
										<p><?php the_content();?></p>
										</div>
					                </div>
					        <?php }?>
							
							<div class="read_more"><a href="<?php echo $siteUrl?>/price-plan/">Read More</a></div>
							<? */ ?>
							
							
							
							<?php include(locate_template('includes/price-plan.php')); ?>
					<div class="clear"> </div>                   
			        </section>
			   </section><!-- .content_wrapper -->
		
		
		   </article>
		
		
		</div>
		
		
		    <div class="dots_bg" style="margin-top:0px;" id="science">
		    	<section class="entry">
	               <div class="content_wrapper">
			          <h2 class = "coaching-page"><img src="<?php echo $siteUrl?>/wp-content/uploads/2014/04/glass_04.png"/>&nbsp;The Science</h2>
			                   <?php query_posts('post_type=page&page_id=386');?>
	                           <?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

	                           <?php the_content();?>
	                           <?php endwhile;?>
						   
            
					<div class="clear"> </div>
	    			</div>	<!-- .content_wrapper ends -->
	 			</section>
        	</div>  <!-- camps_listing ends -->

		   	<div class="our_coach_bg">
		   		<section class ="entry">

            <div class="content_wrapper">
			
		<h2 class = "coaching-page"><img src="<?php echo $siteUrl?>/wp-content/uploads/2015/04/coa_05.png">&nbsp;Our Coaches</h2>
            <?php $my_query = new WP_Query( array(
      'post_type'=>'coach',
      'posts_per_page' => 12,
      'order' => 'ASC'
     ));?>
            <?php if ( $my_query->have_posts() ) while ( $my_query->have_posts() ) : $my_query->the_post(); ?>

              <div class="featured_image our_featured_image ">
               <a href="<?php echo get_the_permalink();?>"><?php the_post_thumbnail('full'); ?>
					<h5><?php the_title();?></h5>
					<span class="title-coach"><?php echo $cfs->get('custom_header_text'); ?></span>
					<!-- <p><?php //the_excerpt();?></p> -->
		       </a>
			</div>	<!-- featured_image ends -->
		<?php endwhile;?>
		

            
		<div class="clear"> </div>

	     </div>	<!-- .content_wrapper ends -->
	    </section>

        </div>  <!-- camps_listing ends -->
		
		
		
		<?php include(locate_template('includes/testimonials.php')); ?>

    </div><!-- #content -->

<?php get_footer(); ?>
