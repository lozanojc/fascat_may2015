<?php
// File Security Check
if ( ! function_exists( 'wp' ) && ! empty( $_SERVER['SCRIPT_FILENAME'] ) && basename( __FILE__ ) == basename( $_SERVER['SCRIPT_FILENAME'] ) ) {
    die ( 'You do not have sufficient permissions to access this page!' );
}
/**
 * Template Name: Get Started Classes
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


	        <header>
                <div class="custom_page_header" style="background: url(<?php echo $cfs->get('header_image'); ?>) no-repeat top center;">
			      <div class="header_txt" style="width:42%">
                    <h2><?php echo $cfs->get('custom_header_heading'); ?></h2>
                    <p><?php echo $cfs->get('custom_header_text'); ?></p>
                  </div>
			    </div>
	        </header>
			            
            	<?php endwhile;?>
          <?php } ?>  

        



		<div class="content_wrapper listings-class" id="choose-a-class" style="padding-bottom: 25px;">
			<h2>Choose a class</h2>
			<div class="class-listing">
				<div class="light class-inner">
					<img src="<?php echo $siteUrl?>/wp-content/uploads/2014/06/pants.png">
					<a href="<?php echo $siteUrl?>/product/womens-specific-9-week-class/">SELECT</a> 
					<p class="bold">Women's Specific 9 Week Class, <span class="oj">Tuesdays 6:45 PM</span>, <span class="green">$185.00</span></p>
					<p>With Professional Road Racers, Heather Fischer and Lauren de Crescenzo.</p>
				</div>

				<div class="dark class-inner">
					<img src="<?php echo $siteUrl?>/wp-content/uploads/2014/06/watch.png">
					<a href="<?php echo $siteUrl?>/product/early-bird-class/">SELECT</a> 
					<p class="bold">Early Bird Class, <span class="oj">Wednesdays 6:30 AM</span>, <span class="green">$185.00</span></p>
					<p>This class will concentrate on raising your Functional Threshold Power with specific intervals.</p>
				</div>
					
				<div class="light class-inner">
					<img src="<?php echo $siteUrl?>/wp-content/uploads/2014/06/shoe.png">
					<a href="<?php echo $siteUrl?>/product/power-lunch-9-week-class/">SELECT</a> 
					<p class="bold">POWER Lunch 9 Week Class, <span class="oj">Wednesdays 12:00 PM</span>, <span class="green">$185.00</span></p>
					<p>Power Lunch (!) Wednesdays @ Noon Join us for a Power Lunch on Wednesdays for 9 Weeks!</p>
				</div>
					
				<div class="dark class-inner">
					<img src="<?php echo $siteUrl?>/wp-content/uploads/2014/06/pant-d.png">
					<a href="<?php echo $siteUrl?>/product/wednesdays-645pm/">SELECT</a> 
					<p class="bold">Wednesdays @ 6:45PM, <span class="oj"> Wednesdays 6:45 PM</span>, <span class="green">$185.00</span></p>
					<p>Starts January 8th and is held every Wednesday at 6:45pm. This class will concentrate on raising your Fun.</p>
				</div>

				<div class="light class-inner">
					<img src="<?php echo $siteUrl?>/wp-content/uploads/2014/06/watch-w.png">
					<a href="<?php echo $siteUrl?>/product/bcs-thursdays/">SELECT</a> 
					<p class="bold">BCS Thursdays, <span class="oj">Thursdays 6:45 PM</span>, <span class="green">$185.00</span></p>
					<p>Class Starts Thursday Janauary 9th @ 6:45PM BCS memberes receive 10% OFF!!</p>
				</div>
					
				<div class="dark class-inner">
					<img src="<?php echo $siteUrl?>/wp-content/uploads/2014/06/show-d.png">
					<a href="<?php echo $siteUrl?>/product/saturdays-9am-for-1-5-hours/">SELECT</a> 
					<p class="bold">Saturdays 9AM for 1.5 Hours, <span class="oj">Saturdays 9 AM</span>, <span class="green">$185.00</span></p>
					<p>Saturdays at 9AM for 1.5 hours This class will concentrate on raising your Functional Threshold Power.</p>
				</div>

				<div class="light class-inner">
					<img src="<?php echo $siteUrl?>/wp-content/uploads/2014/06/pants.png">
					<a href="<?php echo $siteUrl?>/product/saturdays-1045-am-for-1-5-hours/">SELECT</a> 
					<p class="bold">Saturdays 10:45 AM for 1.5 Hours, <span class="oj">Saturdays 10:45 AM</span>, <span class="green">$185.00</span></p>
					<p>Starts Saturday January 11th and is held weekly at 10:45AM. This class will concentrate on raising your Fun.</p>
				</div>

				<div class="dark class-inner">
					<img src="<?php echo $siteUrl?>/wp-content/uploads/2014/06/watch.png">
					<a href="<?php echo $siteUrl?>/product/imbapeople-for-bikes/">SELECT</a> 
					<p class="bold">IMBA/People for Bikes, <span class="oj">Tuesdays 5:30 PM</span>, <span class="green">$185.00</span></p>
					<p>Starts Tuesday January 7th and is held every Tuesday @ 5:30pm </p>
				</div>
					
				<div class="light class-inner">
					<img src="<?php echo $siteUrl?>/wp-content/uploads/2014/06/shoe.png">
					<a href="<?php echo $siteUrl?>/product/january-thru-march-membership/">SELECT</a> 
					<p class="bold">January thru March Membership <span class="green">$449.00</span></p>
					<p>January thru March Membership :: unlimited classes and visits from January thru March.</p>
				</div>

				<div class="dark class-inner">
					<img src="<?php echo $siteUrl?>/wp-content/uploads/2014/06/watch.png">
					<a href="<?php echo $siteUrl?>/product/1-hour-indoor-cycling-class/">SELECT</a> 
					<p class="bold">1 Hour Indoor Cycling Class, <span class="green">$20.00</span></p>
					<p>Drop In's are welcome but check with us that there's space.</p>
				</div>
			</div>
		</div>



		
			<!-- BEGIN orange dot section -->
		    <div class="dots_bg" style="margin-top:0px;">

               <div class="content_wrapper oj-get-started">
		            
               		<div class="col_three the_science" style="margin: 1.618em 0 0 0;">
		            	<img src="<?php echo $siteUrl?>/<?php echo $cfs->get('footer_image1');?>" alt="" />
						<h5><?php echo $cfs->get('footer_title1');?></h5>
						<p>________</p>
						<p><?php echo $cfs->get('footer_description1');?></p>


					</div>

					<div class="col_three the_science" style="margin: 1.618em 0 0 0;">
		            	<img src="<?php echo $siteUrl?>/<?php echo $cfs->get('footer_image2');?>" alt="" />
						<h5><?php echo $cfs->get('footer_title2');?></h5>
						<p>________</p>
						<p><?php echo $cfs->get('footer_description2');?></p>


					</div>

					<div class="col_three the_science" style="margin: 1.618em 0 0 0;">
		            	<img src="<?php echo $siteUrl?>/<?php echo $cfs->get('footer_image3');?>" alt="" />
						<h5><?php echo $cfs->get('footer_title3');?></h5>
						<p>________</p>
						<p><?php echo $cfs->get('footer_description3');?></p>
					</div>    
	     		</div>	
        	</div> 
			<!-- END orange dot section -->


	

		



		
		  
		







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
