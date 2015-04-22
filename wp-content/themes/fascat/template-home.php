<?php
// File Security Check
if ( ! function_exists( 'wp' ) && ! empty( $_SERVER['SCRIPT_FILENAME'] ) && basename( __FILE__ ) == basename( $_SERVER['SCRIPT_FILENAME'] ) ) {
    die ( 'You do not have sufficient permissions to access this page!' );
}
/**
 * Template Name: Home
 *
 * Here we setup all logic and XHTML that is required for the index template, used as both the homepage
 * and as a fallback template, if a more appropriate template file doesn't exist for a specific context.
 *
 * @package WooFramework
 * @subpackage Template
 */
	get_header();
	global $woo_options;
    $categoryUrl = FasCat::getCategoryUrl();
    $siteUrl = FasCat::getSiteUrl();
?>


    <?php if ( $woo_options[ 'woo_homepage_banner' ] == "true" ) { ?>

    	<div class="homepage-banner">
    		<?php
		   if ( $woo_options[ 'woo_homepage_banner' ] == "true" ) { $banner = $woo_options['woo_homepage_banner_path']; }
		   if ( $woo_options[ 'woo_homepage_banner' ] == "true" && is_ssl() ) { $banner = preg_replace("/^http:/", "https:", $woo_options['woo_homepage_banner_path']); }
		?>

	       <img src="<?php echo $banner; ?>" alt="" />
    		<h1><span><?php echo $woo_options['woo_homepage_banner_headline']; ?></span></h1>
    		<div class="description"><?php echo wpautop($woo_options['woo_homepage_banner_standfirst']); ?></div>
    	</div>

    <?php } ?>

    <div id="content" class="col-full <?php if ( $woo_options[ 'woo_homepage_banner' ] == "true" ) echo 'with-banner'; ?> <?php if ( $woo_options[ 'woo_homepage_sidebar' ] == "false" ) echo 'no-sidebar'; ?>">
     <div class="dots_bg" style="padding:0;text-align:left">
      <div class="content_wrapper" style="max-width:970px">

	<?php global $cfs; ?>

	<div class="bxslider">
	 <?php

	    /*
   		A loop field named "brands" with sub-fields "slider_text", "headline", "tag_line"
    		Loop fields return an associative array containing *ALL* sub-fields and their values
   		NOTE: Values of sub-loop fields are returned when using get() on the parent loop!
	    */

	     	$fields = $cfs->get('slider_text');
	     if (!empty($fields)) {
	     	foreach ($fields as $field) {
    	     	echo "<div class='slider_text'><h2>{$field['headline']}</h2>";
    	     	echo "<h6>{$field['tag_line']}</h6></div>";

		}
	    }
	 ?>
	</div>	<!-- slider_text ends -->
</div>
	
	
	
	
	
	
	<?php include(locate_template('includes/powermeters.php')); ?>





	<div class="content_wrapper home-grid-wrapper">
		<div class="page_links" style="width: 100%;">
			<?php
			/*
			A loop field named "home_products" with sub-fields "products_image", "product_url", product_text"
			Loop fields return an associative array containing *ALL* sub-fields and their values
			NOTE: Values of sub-loop fields are returned when using get() on the parent loop!
			*/
			
			$fields = $cfs->get('home_products');
			$n=0;
			
			if (!empty($fields)) {
				foreach ($fields as $field) {
					$n++;
					
					echo "<a href='{$field['product_url']}' class='featured-img' id='featured-img-" . $n . "'>";
					echo "<div class='product_text'>{$field['product_text']}</div>";
					echo '<img src="'.$field['products_image'].'"';
					
					if(strstr($field['products_image'], 'wp-content/uploads/2014/01/img8.jpg')){
						echo ' style="width: 100%;"';
					}
					
					echo  '/> <span class="arrow"> </span></a>';
			
				}
			} ?>
		</div>	<!-- page_links ends -->
	</div>	<!-- content_wrapper ends -->

</div>	<!-- dots_bg ends -->




<div class="clear"></div>
<script type="text/javascript">jQuery('.cheetah_graphic').on('mouseenter mouseleave', function(e) {
    jQuery('.page_links a > img').last().toggleClass('hover');
    jQuery('.page_links a > .arrow').last().toggleClass('hover');
    //console.log(e.type);
});
</script>

<script type="text/javascript">
(function($){
   $('.content_wrapper.ecomm_icon').imagesLoaded(function(){
       var max = 0;
        $('.ecomm_icon ul > li').each(function(){
            if(max < $(this).height()){
                max = $(this).height()
            }
        });
        $('.ecomm_icon ul > li').css('height', max + 'px');
    });
})(jQuery);
</script>



    </div><!-- /#content -->

		

<?php get_footer(); ?>
