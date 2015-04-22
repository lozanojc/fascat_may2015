<?php
// File Security Check
if ( ! function_exists( 'wp' ) && ! empty( $_SERVER['SCRIPT_FILENAME'] ) && basename( __FILE__ ) == basename( $_SERVER['SCRIPT_FILENAME'] ) ) {
    die ( 'You do not have sufficient permissions to access this page!' );
}
/**
 * Template Name: Get Started
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
			      <div class="header_txt" style="width:42%">
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
              <li<?php if('price-plan-for-our-3-courses' === $post->post_name){echo ' class="active"';}?>><a href="<?php echo $siteUrl?>/coaching/price-plan/">Pricing Plan</a></li>
              <li<?php if('fascat-coaches' === $post->post_name){echo ' class="active"';}?>><a href="<?php echo $siteUrl?>/coaching/fascat-coaches/">FasCat Coaches</a></li>
              <li<?php if('fascat-athletes' === $post->post_name){echo ' class="active"';}?>><a href="<?php echo $siteUrl?>/coaching/fascat-athletes/">FasCat Athletes</a></li>
              <li<?php if('get-started' === $post->post_name){echo ' class="active"';}?>><a href="<?php echo $siteUrl?>/coaching/get-started/">Get Started</a></li>
              <li<?php if('tips' === $post->post_name){echo ' class="active"';}?>><a href="<?php echo $siteUrl?>/tips/">Training Tips</a></li>
            </ul>
					

                    <?php the_content();?>			

				        <div class="clear"> </div>                   
			       </section>
			    </section><!-- .content_wrapper -->
        </article><!-- .post -->
			            
            	<?php endwhile;?>
          <?php } ?>  

        
		
		
		
		<div class="get-started-top">
          <div class="get-left">
		       <div class="content_wrapper" style="max-width:420px;">
			
		          <h2><span class="bolder">$185</span> per 9 week class or <span class="bolder">$20</span> per class</h2>

					<p>9 week classes <span class="green-i">(starts January 7th)<span></p>
					<p>Tuesday - Thursday: 4 classes each day</p>
					<p>Saturdays: 9am &amp; 10:45<span class="green-i">(90 minutes!)<span></p>
					<p>Sign Up for a 9 week class and complete our power-based curriculum</p>
					<p class="oj-i">All classes are Coach Led &amp; Power Based</p>
					<a href="#choose-a-class" class="button-mark">SIGN UP</a>

	    		</div>	<!-- .content_wrapper ends -->
		  </div>
		  
		  <div class="get-right">
		        <a href="#jd-calendar">
		        	<div class="content_wrapper bottom-right">
			
		         	<img src="<?php echo $siteUrl?>/wp-content/uploads/2014/04/train.png">
		        	 <h2>&nbsp;EVENT CALENDAR</h2>
		         	<p>&nbsp;&nbsp;Schedules, camps, and special events</p>
		 

	    			 </div>	<!-- .content_wrapper ends -->		
	    		</a>  
		  
		  
		  </div>
		  <div class="clear"> </div>
		
		</div>  <!-- camps_listing ends -->


		<div class="content_wrapper listings-class" id="choose-a-class">
			<h2>Choose a class</h2>
			<div class="class-listing">
				<div class="light class-inner">
					<img src="<?php echo $siteUrl?>/wp-content/uploads/2014/06/pants.png">
					<a href="<?php echo $siteUrl?>/product/womens-specific-9-week-class/">READ MORE</a> 
					<p class="bold">Women's Specific 9 Week Class, <span class="oj">Tuesdays 6:45 PM</span>, <span class="green">$185.00</span></p>
					<p>With Professional Road Racers, Heather Fischer and Lauren de Crescenzo.</p>
				</div>

				<div class="dark class-inner">
					<img src="<?php echo $siteUrl?>/wp-content/uploads/2014/06/watch.png">
					<a href="<?php echo $siteUrl?>/product/early-bird-class/">READ MORE</a> 
					<p class="bold">Early Bird Class, <span class="oj">Wednesdays 6:30 AM</span>, <span class="green">$185.00</span></p>
					<p>This class will concentrate on raising your Functional Threshold Power with specific intervals.</p>
				</div>
					
				<div class="light class-inner">
					<img src="<?php echo $siteUrl?>/wp-content/uploads/2014/06/shoe.png">
					<a href="<?php echo $siteUrl?>/product/power-lunch-9-week-class/">READ MORE</a> 
					<p class="bold">POWER Lunch 9 Week Class, <span class="oj">Wednesdays 12:00 PM</span>, <span class="green">$185.00</span></p>
					<p>Power Lunch (!) Wednesdays @ Noon Join us for a Power Lunch on Wednesdays for 9 Weeks!</p>
				</div>
					
				<div class="dark class-inner">
					<img src="<?php echo $siteUrl?>/wp-content/uploads/2014/06/pant-d.png">
					<a href="<?php echo $siteUrl?>/product/wednesdays-645pm/">READ MORE</a> 
					<p class="bold">Wednesdays @ 6:45PM, <span class="oj"> Wednesdays 6:45 PM</span>, <span class="green">$185.00</span></p>
					<p>Starts January 8th and is held every Wednesday at 6:45pm. This class will concentrate on raising your Fun.</p>
				</div>

				<div class="light class-inner">
					<img src="<?php echo $siteUrl?>/wp-content/uploads/2014/06/watch-w.png">
					<a href="<?php echo $siteUrl?>/product/bcs-thursdays/">READ MORE</a> 
					<p class="bold">BCS Thursdays, <span class="oj">Thursdays 6:45 PM</span>, <span class="green">$185.00</span></p>
					<p>Class Starts Thursday Janauary 9th @ 6:45PM BCS memberes receive 10% OFF!!</p>
				</div>
					
				<div class="dark class-inner">
					<img src="<?php echo $siteUrl?>/wp-content/uploads/2014/06/show-d.png">
					<a href="<?php echo $siteUrl?>/product/saturdays-9am-for-1-5-hours/">READ MORE</a> 
					<p class="bold">Saturdays 9AM for 1.5 Hours, <span class="oj">Saturdays 9 AM</span>, <span class="green">$185.00</span></p>
					<p>Saturdays at 9AM for 1.5 hours This class will concentrate on raising your Functional Threshold Power.</p>
				</div>

				<div class="light class-inner">
					<img src="<?php echo $siteUrl?>/wp-content/uploads/2014/06/pants.png">
					<a href="<?php echo $siteUrl?>/product/saturdays-1045-am-for-1-5-hours/">READ MORE</a> 
					<p class="bold">Saturdays 10:45 AM for 1.5 Hours, <span class="oj">Saturdays 10:45 AM</span>, <span class="green">$185.00</span></p>
					<p>Starts Saturday January 11th and is held weekly at 10:45AM. This class will concentrate on raising your Fun.</p>
				</div>

				<div class="dark class-inner">
					<img src="<?php echo $siteUrl?>/wp-content/uploads/2014/06/watch.png">
					<a href="<?php echo $siteUrl?>/product/imbapeople-for-bikes/">READ MORE</a> 
					<p class="bold">IMBA/People for Bikes, <span class="oj">Tuesdays 5:30 PM</span>, <span class="green">$185.00</span></p>
					<p>Starts Tuesday January 7th and is held every Tuesday @ 5:30pm </p>
				</div>
					
				<div class="light class-inner">
					<img src="<?php echo $siteUrl?>/wp-content/uploads/2014/06/shoe.png">
					<a href="<?php echo $siteUrl?>/product/january-thru-march-membership/">READ MORE</a> 
					<p class="bold">January thru March Membership <span class="green">$449.00</span></p>
					<p>January thru March Membership :: unlimited classes and visits from January thru March.</p>
				</div>

				<div class="dark class-inner">
					<img src="<?php echo $siteUrl?>/wp-content/uploads/2014/06/watch.png">
					<a href="<?php echo $siteUrl?>/product/1-hour-indoor-cycling-class/">READ MORE</a> 
					<p class="bold">1 Hour Indoor Cycling Class, <span class="green">$20.00</span></p>
					<p>Drop In's are welcome but check with us that there's space.</p>
				</div>
			</div>
		</div>


				   
		
		                      
			        </section>
			   </section><!-- .content_wrapper -->
		
		
		   </article>
		
		
		</div>
		
			<!-- BEGIN orange dot section -->
		    <div class="dots_bg" style="margin-top:0px;">

               <div class="content_wrapper oj-get-started">
		            <div class="col_three the_science" style="margin: 1.618em 0 0 0;">
		            	<img src="<?php echo $siteUrl?>/wp-content/uploads/2014/04/powertap.jpg" alt="" />
						<h5>POWER TAP</h5>
						<p>________</p>
						<p>100% of our classes are POWER Based using ANT+ wireless technology from CycleOps Power: Powertap G3 Wheels and the Joule GPS's. Bring your own bike &amp; we'll supply the powermeter.  Swap out your wheel for our PowerTap G3 Powermeter. </p>


					</div>
							
					<div class="col_three the_science">
						<img src="<?php echo $siteUrl?>/wp-content/uploads/2014/04/training-peaks.jpg" alt="" />
						<h5>TRAINING PEAKS</h5>
						<p>________</p>
						<p>After the class, the power data will be uploaded into their own TrainingPeaks account for analysis by our coaches and themselves. Free Premium TrainingPeaks accounts to the first 125 class registrants!</p>

					</div>
					
					<div class="col_three last_col the_science">
						<img src="<?php echo $siteUrl?>/wp-content/uploads/2014/04/photo3.jpg" alt="" />
						<h5>BE PRODUCTIVE</h5>
						<p>________</p>
						<p>Make this winter &amp; off season your most productive ever. Get a killer power based workout, led by a coach in a fun group setting setting at a convenient location. See what the buzz is all about training with power and leverage our equipment and our training with power expertise.We recommend a lactate threshold test to determine your wattage &amp; heart rate zones. Discounts available for athletes who sign up for our 12 week classes.</p>
					</div>     
	     		</div>	
        	</div> 
			<!-- END orange dot section -->

			<!-- BEGIN FAQ section -->
			<div class="faq-started">
				<img class="rider" src="<?php echo $siteUrl?>/wp-content/uploads/2014/04/Layer-68.png">
				<div class="faq-button">
					<p class="opening-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore.</p>
					<a href="<?php echo $siteUrl?>/coaching/">
						<img src="<?php echo $siteUrl?>/wp-content/uploads/2014/04/arrow.png" />
						<p class="closing-text">See the Frequently Asked Questions</p>
					</a>
				</div>


			</div>

			<!-- END FAQ section -->

			<div class="calendar-bot">
				<h2>Class Schedule and Events Calendar</h2>
				<?php echo do_shortcode('[my_calendar]');?>
			</div>	
			 
		  
		  </div>
		 
		
		</div>  <!-- camps_listing ends -->
		



		
		  
		







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

			
	            	<?php endwhile;?>
          <?php } ?>  
			<div class="clear"> </div>
			</div>
			</div>
			
			
	<?php woo_main_after(); ?>

    </div><!-- #content -->

<?php get_footer(); ?>
