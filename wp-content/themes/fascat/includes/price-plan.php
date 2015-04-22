<div id="product">
	
	<div class="headerindex index">
		<strong>Get Started</strong>
		<p>FREE Coaching Consultation, Cancel Anytime</p>
	</div>
  <div class="block"></div>
	
	<div class="power_based">
		<h4>Power Based Training</h4>
		
		<ul>
		<li>Basic Power Data Analysis</li>
		<li>Advanced Power Data Analysis</li>
		<li>Advanced Planning (ATP) Check Mark</li>
		<li>Predictive Performance Modelling</li>
		</ul>
	</div>
	
	<div class="communication">
		<h4>communication</h4>
		<ul>
		<li>Unlimted Email</li>
		<li>Available to Call (& Talk) with your Coach</li>
		<li>Walk Into Performance Center</li>
		<li>Video Consultations (Power Data screen shares)</li>
		</ul>
	</div>

		<div class="Consultations">
		<h4>Consultations</h4>
		<ul>
		<li>Phone</li>
		<li>Email</li>
		<li>Power Data Video Conference</li>
		<li>In Person at the FasCat Performance Center</li>
		</ul>
	</div>
	
	<div class="Depth">
		<h4>Depth of Coach-Athlete Relationship</h4>
	</div>
	
	<div class="Suitable">
		<h4>Suitable for the Athlete </h4>
	</div>
	
	<div class="Get_Started">
		<strong>Get Started</strong>
		<p>FREE Coaching Consultation, Cancel Anytime</p>
	</div>
	

</div>
	<?php $args = array(
    'posts_per_page' => 3,
    'product_cat' => 'coaching',
    'post_type' => 'product',
    'order' => 'asc'
    //'orderby' => 'title',
);

$the_query = new WP_Query( $args );
$currency = get_woocommerce_currency_symbol();
$number=0;

// The Loop
while ( $the_query->have_posts() ) {
	$the_query->the_post();
	
	?>

	<div id="product" class="column<?php echo $number++; ?>">
		<div class="headerindex index3">
			<h1><?php echo '' . get_the_title() . '';?></h1>
	
			<h4 class="monthly_price"><?php echo($price = $currency . $product->get_price()); ?></h4>

			<?php $meta = get_post_meta( get_the_ID(), 'week_block', TRUE );?>
			<p><?php echo $meta; ?></p>

			<a href="/coaching/<?php echo $cfs->get('form_slug'); ?>" class="signup">Start Now</a>

			<p><?php the_content();?></p>
		</div>
	    <div class="block"></div>

		
		<div class="hunt_power_based">
			<h4></h4>
			<ul>
			<?php $meta = get_post_meta( get_the_ID(), 'basic_power_data_analysis', TRUE ); ?>
			<li><a href="#"><img src="<?php echo $meta; ?>"></a></li>
			
			<?php $meta = get_post_meta( get_the_ID(), 'advanced_power_data_analysis', TRUE ); ?>
			<li><a href="#"><img src="<?php echo $meta; ?>"></a></li>
			
			<?php $meta = get_post_meta( get_the_ID(), 'advanced_planning_atp_check_mark', TRUE ); ?>
			<li><?php if( strlen($meta) > 10 ) { ?><a href="#"><img src="<?php echo $meta; ?>"></a><?php } ?></li>
			
			<?php $meta = get_post_meta( get_the_ID(), 'predictive_performance_modelling', TRUE );?>
			<li><?php if( strlen($meta) > 10 ) { ?><a href="#"><img src="<?php echo $meta; ?>"></a><?php } ?></li>
			</ul>
		</div>
	
		<div class="communication_hunt" style="padding-left:4px;">
			<h4></h4>
			<ul>
			<li><?php echo $cfs->get('unlimted_email'); ?></li>
			<li><?php echo $cfs->get('available_to_call_talk_with_your_coach'); ?></li>
			<li><?php if(strlen ( $cfs->get('walk_into_performance_center') ) > 10) echo  $cfs->get('walk_into_performance_center'); ?></li>
			<li><?php echo $cfs->get('video_consultations_power_data_screen_shares'); ?></li>
			</ul>
		</div>
		
		<div class="Consultations_hunt">
			<h4></h4>
			<ul>
            <li><?php echo $cfs->get('phone'); ?></li>
			<li><?php echo $cfs->get('email'); ?></li>
			<li><?php echo $cfs->get('power_data_video_conference'); ?></li>
			<li><img src="<?php echo $cfs->get('in_person_at_the_fascat_performance_center'); ?>"></li>	
			</ul>
		</div>
		
		<div class="Depth_hunt" style="text-align:center;">
			<ul>
			<li><?php echo $cfs->get('depth_of_coach_athlete_relationship'); ?></li>
			</ul>
		</div>
		
		<div class="Suitable_hunt">
			<ul>
			<li><?php echo $cfs->get('suitable_for_the_athlete'); ?></li>
           </ul>
		</div>
	
		<div class="Get_Started_hunt">
			<h4></h4>
            <span><?php echo $price;//echo $price_html; ?></span>

			<?php $meta = get_post_meta( get_the_ID(), 'week_block', TRUE );?>
			<p><?php echo $meta; ?></p>
			
				<a href="/coaching/<?php echo $cfs->get('form_slug'); ?>" class="signup">Start Now</a>
			
			<p><?php the_content();?></p>
		</div>
	</div>				
<?php } ?>				


<div class="clear"> </div>