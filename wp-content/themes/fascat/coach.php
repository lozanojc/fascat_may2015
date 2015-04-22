<?php

// File Security Check

if ( ! function_exists( 'wp' ) && ! empty( $_SERVER['SCRIPT_FILENAME'] ) && basename( __FILE__ ) == basename( $_SERVER['SCRIPT_FILENAME'] ) ) {

    die ( 'You do not have sufficient permissions to access this page!' );

}

?>

<?php

/**

  * Template Name: coach

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
            	    'post_type'=> 'coach',
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
		                <p><?php echo $cfs->get('text_description'); ?></p>
	                    <div class="coach_button"><a href="">HOW WE COACH <img src="/wp-content/uploads/2014/04/down_arrow.png"/></a></div>

	                </div>
			    </div>
	        </header>
				 
				<section class="content_wrapper">
	                <section class="entry fix">
					<div style="width:100%;">
						<div class="view_plan">
							<h2><img src="/wp-content/uploads/2014/04/how.png"/>   How We Coach</h2>

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
            	            <a href=""><img src="/wp-content/uploads/2014/04/c1.png"/>
							   <h5 style="color:#fa6327;">1.<br/>Consult </h5>
		    
		                    </a>
		               </div>
					    <div class="featured_image12" style="margin-left:3%; margin-top:4%;">
            	            <a href=""><img src="/wp-content/uploads/2014/04/c2.png"/>
							   <h5 style="color:#fa6327;">2.<br/>plan</h5>
		    
		                    </a>
		               </div>
					    <div class="featured_image12" style="margin-left:3%; margin-top:4%;">
            	            <a href=""><img src="/wp-content/uploads/2014/04/c3.png"/>
							   <h5 style="color:#fa6327;">3.<br/>Communicate</h5>
		    
		                    </a>
		               </div>
					    <div class="featured_image12" style="margin-left:3%; margin-top:4%;">
            	            <a href=""><img src="/wp-content/uploads/2014/04/c4.png"/>
							   <h5 style="color:#fa6327;">4.<br/>Ride </h5>
		    
		                    </a>
		               </div>
					    <div class="featured_image12" style="margin-left:3%; margin-top:4%;">
            	            <a href=""><img src="/wp-content/uploads/2014/04/c5.png"/>
							   <h5 style="color:#fa6327;">5.<br/>Feedback (words & power data) </h5>
		    
		                    </a>
		               </div>
					    <div class="featured_image12" style="margin-left:3%; margin-top:4%;">
            	            <a href=""><img src="/wp-content/uploads/2014/04/c6.png"/>
							   <h5 style="color:#fa6327;">6.<br/>Analyze </h5>
		    
		                    </a>
		               </div>
					    <div class="featured_image12" style="margin-left:3%; margin-top:4%;">
            	            <a href=""><img src="/wp-content/uploads/2014/04/c7.png"/>
							   <h5 style="color:#fa6327;">7.<br/>Communicate</h5>
		    
		                    </a>
		               </div>
					    <div class="featured_image12" style="margin-left:3%; margin-top:4%;">
            	            <a href=""><img src="/wp-content/uploads/2014/04/c8.png"/>
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
                        <img src="/wp-content/uploads/2014/04/daire.png"/>
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
		             <div class="coach_view"><h2><img src="/wp-content/uploads/2014/04/alaram.png"/>&nbsp;View Plans</h2><p>View the 3 custom built Plans</p></div>
					
					
					<?php $args = array(
							'posts_per_page' => 3,
							'product_cat' => 'price_plan',
							'post_type' => 'product',
							'orderby' => 'title',
						);

					?>

					<?php $the_query = new WP_Query( $args );
							// The Loop
							while ( $the_query->have_posts() ) {
								$the_query->the_post();
		            ?>
					
               <div class="col_three" style="padding:0px; width: 33.332%;">
				    <div class="index1">
					 <?php the_post_thumbnail('full'); ?>
					<h1><?php echo '' . get_the_title() . '';?></h1>
					
					<?php if ( $price_html = $product->get_price_html() ) : ?>
	                <span><?php echo $price_html; ?></span>
                    <?php endif; ?>
					<?php $meta = get_post_meta( get_the_ID(), 'week_block', TRUE );?>
					<p><?php echo $meta; ?></p>
					<div class="start_now"><a href="<?php the_permalink() ?>">Start Now</a></div>
					<!--<div class="start_now"><a href="#">Start Now</a></div>-->
					<p><?php the_content();?></p>
					</div>
                </div>
				<?php 	} ?>
				
					<?php $args = array(
					'posts_per_page' => 3,
					'product_cat' => 'chase',
					'post_type' => 'product',
					'orderby' => 'title',
				);

				?>


				<?php $the_query = new WP_Query( $args );
			// The Loop
			while ( $the_query->have_posts() ) {
				$the_query->the_post();
				?>	
			
			<div class="col_three" style="padding:0px; width: 33.332%;">
				<div class="index2">
					 <?php the_post_thumbnail('full'); ?>
					<h1><?php echo '' . get_the_title() . '';?></h1>
					
					<?php if ( $price_html = $product->get_price_html() ) : ?>
	                <span><?php echo $price_html; ?></span>
                    <?php endif; ?>
					<?php $meta = get_post_meta( get_the_ID(), 'week_block', TRUE );?>
					<p><?php echo $meta; ?></p>
					<div class="start_now"><a href="<?php the_permalink() ?>">Start Now</a></div>
					<!--<div class="start_now"><a href="#">Start Now</a></div>-->
					<p><?php the_content();?></p>
					</div>
           </div>
				<?php 	} ?>	

		   		<?php $args = array(
					'posts_per_page' => 3,
					'product_cat' => 'kill',
					'post_type' => 'product',
					'orderby' => 'title',
				);

	?>
			<?php $the_query = new WP_Query( $args );
				// The Loop
				while ( $the_query->have_posts() ) {
					$the_query->the_post();
		?>
							
		   
        <div class="col_three last_col" style="padding:0px; width: 33.340%;">
				 <div class="index3">
					 <?php the_post_thumbnail('full'); ?>
			
				<h1><?php echo '' . get_the_title() . '';?></h1>
					
					<?php if ( $price_html = $product->get_price_html() ) : ?>
	                <span><?php echo $price_html; ?></span>
                    <?php endif; ?>
					<?php $meta = get_post_meta( get_the_ID(), 'week_block', TRUE );?>
					<p><?php echo $meta; ?></p>

		<div class="start_now"><a href<?php the_permalink() ?>">Start Now</a></div>
					<!--<div class="start_now"><a href="#">Start Now</a></div>-->
					<p><?php the_content();?></p>
					</div>
       </div>

					<?php 	}
	?>					   
		
		        <div class="read_more"><a href="/price-plan/">Read More</a></div>
		
					<div class="clear"> </div>                   
			        </section>
			   </section><!-- .content_wrapper -->
		
		
		   </article>
		
		
		</div>
		
		
		    <div class="dots_bg camps_listing" style="margin-top:0px;">

               <div class="content_wrapper">
		          <h2><img src="/wp-content/uploads/2014/04/glass_04.png"/>&nbsp;The Science</h2>
		                   <?php query_posts('post_type=page&page_id=386');?>
                           <?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

                           <?php the_content();?>
                           <?php endwhile;?>
						   
            
		<div class="clear"> </div>

	     </div>	<!-- .content_wrapper ends -->

        </div>  <!-- camps_listing ends -->
		
		
		
		
		        <div class="our_coach_bg">

            <div class="content_wrapper">
			
		<h2><img src="/wp-content/uploads/2014/04/coa_05.png">&nbsp;Our Coaches</h2>
            <?php query_posts('cat=47');?>
            <?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

              <div class="featured_image our_featured_image ">
               <a href="#"><?php the_post_thumbnail('full'); ?>
				  <div class="overlay">
					<h5><?php the_title();?></h5>
					<p><?php the_content();?></p>
				  </div>	<!-- .overlay ends -->
		          <div class="magnifier"> </div>
		       </a>
		</div>	<!-- featured_image ends -->
		<?php endwhile;?>
		

            
		<div class="clear"> </div>

	     </div>	<!-- .content_wrapper ends -->

        </div>  <!-- camps_listing ends -->
		
		           <?php query_posts(array(
            	    'post_type'=> 'coach',
	  	    'posts_per_page' => 1,
	  	    'orderby' => 'post_date',
	  	    'order' => 'DESC',
	      	 ));
           ?>

        <?php

        	if ( have_posts() ) { $count = 0;

        		while ( have_posts() ) : the_post(); $count++;

        ?>
		
		
		<div class="training_cal">
          <div class="train_calender">
		        <div class="content_wrapper" style="max-width:350px;">
			
			
			<?php echo $cfs->get('training_calendar'); ?>
		          <!--<h2><img src="/wp-content/uploads/2014/04/train.png">&nbsp;Training Calendar</h2>
		  
                  <h5>INCLUDING ANNUAL TRAINNG PLAN</h5>
				________
				
				<p>Training Calendar Design including Annual Training Plan "your coach designs a new training calendar for you every 4 weeks.</p>

		  <div class="train_button"><a href="#">SEE SAMOLE CALENDAR &nbsp;&nbsp;<img src="/wp-content/uploads/2014/04/left_arrow_02.png"/></a></div>
-->
	     </div>	<!-- .content_wrapper ends -->
		  </div>
		  
		  <div class="train_power">
		        <div class="content_wrapper" style="max-width:350px;">
			<?php echo $cfs->get('training_with_power'); ?>
		          <!--<h2><img src="/wp-content/uploads/2014/04/toffe.png">&nbsp;Training With Power</h2>
		  
                  <h5>TRAINNG WITH POWER</h5>
				________
				
				<p>Training With Power <span>with supported image?</span>- "the best way to train and share your workout data with your coach for feedback and analysis"</p>

		  <div class="train_button"><a href="#">SEE SAMOLE CALENDAR &nbsp;&nbsp;<img src="/wp-content/uploads/2014/04/left_arrow_02.png"/></a></div>
-->
	     </div>	<!-- .content_wrapper ends -->		  
		  
		  
		  </div>
		  <div class="clear"> </div>
		
		</div>  <!-- camps_listing ends -->
		
		            	<?php endwhile;?>
          <?php } ?> 
		  
		
		           <?php query_posts(array(
            	    'post_type'=> 'testimonials',
	  	    'posts_per_page' => 1,
	  	    'orderby' => 'post_date',
	  	    'order' => 'DESC',
	      	 ));
           ?>
		
		<div class="athletes_bg">

            <div class="content_wrapper">
        <?php

        	if ( have_posts() ) { $count = 0;

        		while ( have_posts() ) : the_post(); $count++;

        ?>
			<div class="testemonials">
	        <h1><img src="/wp-content/uploads/2014/04/user.png">&nbsp; <?php the_title();?></h1>
            <?php the_content();?>
			<div class="testemonials_button"><a href="#">SEE MORE TESTIMONIALS &nbsp;&nbsp;<img src="/wp-content/uploads/2014/04/left_arrow_02.png"/></a></div>

			</div>
			
	            	<?php endwhile;?>
          <?php } ?>  
			<div class="clear"> </div>
			</div>
			</div>
			
			
	<?php woo_main_after(); ?>

    </div><!-- #content -->

<?php get_footer(); ?>