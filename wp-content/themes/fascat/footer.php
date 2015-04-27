<?php

// File Security Check

if ( ! empty( $_SERVER['SCRIPT_FILENAME'] ) && basename( __FILE__ ) == basename( $_SERVER['SCRIPT_FILENAME'] ) ) {

    die ( 'You do not have sufficient permissions to access this page!' );

}

?>

</div><!-- /#wrapper -->

<?php

/**
 * Footer Template
 *
 * Here we setup all logic and XHTML that is required for the footer section of all screens.
 *
 * @package WooFramework
 * @subpackage Template
 */

	global $woo_options;

	echo '<div class="footer-wrap">';

	$total = 4;

	if ( isset( $woo_options['woo_footer_sidebars'] ) && ( $woo_options['woo_footer_sidebars'] != '' ) ) {

		$total = $woo_options['woo_footer_sidebars'];

	}



	if ( ( woo_active_sidebar( 'footer-1' ) ||

		   woo_active_sidebar( 'footer-2' ) ||

		   woo_active_sidebar( 'footer-3' ) ||

		   woo_active_sidebar( 'footer-4' ) ) && $total > 0 ) {



?>

	<?php woo_footer_before(); ?>

	<div class="call-us-now">
	  <?php echo stripslashes( $woo_options['woo_info_orange'] ); ?>
	</div>	

		<section id="footer-widgets" class="col-full col-<?php echo $total; ?> fix">

	

			<?php $i = 0; while ( $i < $total ) { $i++; ?>

				<?php if ( woo_active_sidebar( 'footer-' . $i ) ) { ?>

	

			<div class="block footer-widget-<?php echo $i; ?>">

	        	<?php woo_sidebar( 'footer-' . $i ); ?>

			</div>

	

		        <?php } ?>

			<?php } // End WHILE Loop ?>

	

		</section><!-- /#footer-widgets  -->

	<?php } // End IF Statement ?>

		<footer id="footer" class="col-full">

	

			<div id="copyright" class="col-left">

			<?php if( isset( $woo_options['woo_footer_left'] ) && $woo_options['woo_footer_left'] == 'true' ) {

	

					echo stripslashes( $woo_options['woo_footer_left_text'] );

	

			} else { ?>

				<p><?php bloginfo(); ?> &copy; <?php echo date( 'Y' ); ?>. <?php _e( 'All Rights Reserved.', 'fascat' ); ?></p>

			<?php } ?>

			</div>

	

			<div id="credit" class="col-right">

	        <?php if( isset( $woo_options['woo_footer_right'] ) && $woo_options['woo_footer_right'] == 'true' ) {

	

	        	echo stripslashes( $woo_options['woo_footer_right_text'] );

	

			} else { ?>

				<p><?php _e( 'Powered by', 'fascat' ); ?> <a href="<?php echo esc_url( 'http://www.wordpress.org' ); ?>">WordPress</a>. <?php _e( 'Designed by', 'fascat' ); ?> <a href="<?php echo ( isset( $woo_options['woo_footer_aff_link'] ) && ! empty( $woo_options['woo_footer_aff_link'] ) ? esc_url( $woo_options['woo_footer_aff_link'] ) : esc_url( 'http://www.baumhaur.com/' ) ) ?>">Baumhaur</a></p>

			<?php } ?>

			</div>

		</footer><!-- /#footer  -->

	

	</div><!-- / footer-wrap -->







<div id="login-form" class="white-popup  mfp-hide">
	<img src="/wp-content/themes/fascat/images/training-peaks-lgo.png" alt="Training Peaks" style="display: block; margin: auto;">
	<form action="https://home.trainingpeaks.com/login?cid2=MQDJLPNAUVC6S" method="post" name="formxx" id="formxx" style="margin-bottom: 0px; margin-left: 0px; margin-right: 0px; margin-top: 0px; padding-bottom: 0px; padding-left: 0px; padding-right: 0px; padding-top: 0px; position: 0px; border: 0px;"> 
		<table border="0" cellspacing="0" cellpadding="2" style="background-color: #FFFFFF;">
		<tr>
		<td><input type="text" name="username" placeholder="Username"></td>
		</tr>
		<tr>
		<td><input type="password" name="password" placeholder="Password"></td>
		</tr>
		<tr>
		<td><input type="submit" name="submit" value="Login" style="background-color: #FF5911; border: none; padding:0.4em 1.5em !important;"></td>
		</tr>
		</table>
	</form>
</div>



<?php wp_footer(); ?>

<?php woo_foot(); ?>

<script>
    jQuery( document ).ready(function() {
	 
        jQuery('#the_links').hide();
        
		jQuery(".social-links").mouseenter(function() {
			jQuery('#the_links').fadeIn();
			jQuery('#show_share').fadeOut();
			jQuery(this).animate({ left: 0 });
		})
		jQuery(".social-links").mouseleave(function() {
			jQuery('#the_links').fadeOut();
			jQuery('#show_share').fadeIn();
			jQuery(this).animate({ left: -140 });
		})
		
		
		jQuery('#navigation').mouseenter(function() {
			jQuery('.colored_logo').fadeOut();
		})
		jQuery('#navigation').mouseleave(function() {
			jQuery('.colored_logo').fadeIn();
		})
		
		
		
		// submit signup form #1 when option selected
	    jQuery('input#choice_6_0').change(function() {
		    // alert ( 'fucking go' );
	        this.form.submit();
	    });
	    
	    jQuery('input#choice_6_1').change(function() {
	        // alert ( 'fucking go' );
	        this.form.submit();
	    });
	  
	     jQuery('.tips-cats').on('click', function(){
              jQuery('.tips-cats-list').toggle();
              });
	  
	  jQuery('.tips-coaches').on('click', function(){
              jQuery('.tips-coaches-list').toggle();
              });
	  

	  
    });
  
if(jQuery('body').hasClass('page-id-353')){
		window.onscroll = function (event) {
		 var distance = jQuery('.headerindex').offset().top,
		    		$window = jQuery(window),
		    		$height = jQuery(window).height() - 50;
		    		entryHeader = jQuery(".headerindex").height() - 50;


		    		jQuery(window).bind('scroll', function () {
					    if (jQuery(window).scrollTop() + 150 > $height) {
					        jQuery('.block').height(220);
						  	jQuery('.headerindex a').fadeOut();
						  	jQuery('.headerindex p').fadeOut();
					        jQuery('.headerindex').addClass('fixed');
					        

					    } else {
					    	jQuery('.block').height(0);
						  	jQuery('.headerindex a').fadeIn();
						  	jQuery('.headerindex p').fadeIn();
					        jQuery('.headerindex').removeClass('fixed');
					        
					    }
					});
    	}
}




</script>







</body>

</html>