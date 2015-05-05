<div class="testimonials_bg">
	<section class="content_wrapper">
		<h2 class="big_heading">Athlete Testimonials</h2>
		
		<section class="entry fix">
			<?php $args = array(
				'post_type'=>'testimonials',
				'posts_per_page' => -1,
				'order' => 'ASC'
			); 
			
			$my_query = null;
			$my_query = new WP_Query($args);
			
			if( $my_query->have_posts() ) {
				$counter = 0;
				while ($my_query->have_posts()) : $my_query->the_post(); 
					$counter++; ?>
					
					<article <?php post_class(); ?>>
						<div class="testimonial_content">
							<h5><?php the_title(); ?></h5>
							<?php the_content(); ?>
						</div>	<!-- /.testimonial_content ends -->
					</article><!-- .post -->
				<?php endwhile;
			}
			
			wp_reset_query(); ?>
		
		</section>
		
		<div class="clear"></div>
		
		<a class="button small_txt" href="<?php bloginfo( 'url' ) ?>/coaching/fascat-athletes/">VIEW MORE ATHLETE TESTIMONIALS <img class="right_arrow" src="<?php echo get_template_directory_uri() ?>/images/right_arrow.png" alt="right arrow icon" /></a>
	
	</section><!-- .content_wrapper -->
</div>	<!-- testimonials_bg ends -->