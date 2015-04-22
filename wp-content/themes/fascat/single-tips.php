<?php if ( ! function_exists( 'wp' ) && ! empty( $_SERVER['SCRIPT_FILENAME'] ) && basename( __FILE__ ) == basename( $_SERVER['SCRIPT_FILENAME'] ) ) { // File Security Check
	die ( 'You do not have sufficient permissions to access this page!' );
}


/**
* Single Post Template for tips
*
* This template is the default page template. It is used to display content when someone is viewing a
* singular view of a post ('post' post_type).
* @link http://codex.wordpress.org/Post_Types#Post
*
* @package WooFramework
* @subpackage Template
*/

get_header("tips");
global $woo_options;
?>

<div id="content" class="col-full">
	<?php woo_main_before(); ?>
    <?php if ( have_posts() ) { $count = 0;
		while ( have_posts() ) the_post(); 
		$count++;
		?>

		<article <?php post_class(); ?>>
			<header>
				<div class="custom_page_header" style="background: url(<?php echo $cfs->get('header_image'); ?>) no-repeat top center;">
			        <div class="header_txt">
                          <h2><?php the_title(); ?></h2>
                          <p><?php echo $cfs->get('tips_subtitle'); ?></p>
					</div>
				</div>
			</header>

			<section class="content_wrapper">
				<section class="entry fix">
		
					
					<?php the_content(); ?>   
					
					Share: <?php echo do_shortcode ('[shareaholic app="share_buttons" id="eafb5fbf838369f426a096cc148b76f8"]'); ?>                 
				</section>

				<div class="tips-sidebar" style="display: block; position: relative; left: 10px;">
					<?php echo get_the_post_thumbnail( $post_id, 'single-thumb' ); ?>
					<div id="thumb_caption">
						<?php the_post_thumbnail_caption(); ?>
					</div>
					
					<ul>
					<li><a href="/coaching/fascat-coaches/" class="highlight">Meet the coaches</a></li>
					<li><a href="/price-plan/">See coaching plans</a></li>
					<li><a href="/powermeters/">Powermeters</a></li>
					<li>
						<h2>Free Month</h2>
						<p>of coaching with every<br />powermeter purchase</p>
					</li>
					</ul>
				</div>
			</section><!-- .content_wrapper -->
		</article><!-- .post -->
	<?php } ?>
	<?php woo_main_after(); ?>
</div><!-- #content -->



<?php get_footer(); ?>