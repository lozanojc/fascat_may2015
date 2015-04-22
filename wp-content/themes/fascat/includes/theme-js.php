<?php
// File Security Check

if ( ! empty( $_SERVER['SCRIPT_FILENAME'] ) && basename( __FILE__ ) == basename( $_SERVER['SCRIPT_FILENAME'] ) ) {

    die ( 'You do not have sufficient permissions to access this page' );

}

if ( ! is_admin() ) { add_action( 'wp_enqueue_scripts', 'fascat_add_javascript' ); }



if ( ! function_exists( 'fascat_add_javascript' ) ) {

	function fascat_add_javascript() {

		global $woo_options;

		wp_register_script( 'prettyPhoto', get_template_directory_uri() . '/includes/js/jquery.prettyPhoto.js', array( 'jquery' ) );
		wp_register_script( 'enable-lightbox', get_template_directory_uri() . '/includes/js/enable-lightbox.js', array( 'jquery', 'prettyPhoto' ) );
		wp_enqueue_script( 'third party', get_template_directory_uri() . '/includes/js/third-party.js', array( 'jquery' ) );
		wp_enqueue_script( 'BxSlider', get_template_directory_uri() . '/includes/js/jquery.bxslider.min.js', array( 'jquery' ) );
        //if($notWC = (!is_product() && !is_checkout())){//this will break variable products add to cart script
            wp_enqueue_script( 'SelectBox', get_template_directory_uri() . '/includes/js/jquery.selectBox.js', array( 'jquery' ) );
        //}
		wp_enqueue_script( 'FancyboxPack', get_template_directory_uri() . '/includes/js/jquery.fancybox.pack.js', array( 'jquery' ) );
		wp_enqueue_script( 'FancyboxMedia', get_template_directory_uri() . '/includes/js/jquery.fancybox-media.js', array( 'jquery' ) );
		wp_enqueue_script( 'easing', get_template_directory_uri() . '/includes/js/jquery.easing.1.3.js', array( 'jquery' ) );
        //if($notWC){
        wp_enqueue_script( 'general', get_template_directory_uri() . '/includes/js/general.js', array( 'jquery' ) );
        //}
		wp_register_script( 'google-maps', 'http://maps.google.com/maps/api/js?sensor=false' );
		wp_register_script( 'google-maps-markers', get_template_directory_uri() . '/includes/js/markers.js' );

		// Load Google Script on Contact Form Page Template

		if ( is_page_template( 'template-contact.php' ) ) {

			wp_enqueue_script( 'google-maps' );

			wp_enqueue_script( 'google-maps-markers' );

		} // End If Statement

		

		do_action( 'fascat_add_javascript' );

	} // End fascat_add_javascript()

}



if ( ! is_admin() ) { add_action( 'wp_print_styles', 'fascat_add_css' ); }



if ( ! function_exists( 'fascat_add_css' ) ) {

	function fascat_add_css () {
		wp_enqueue_style( 'BxSlider', get_template_directory_uri().'/includes/css/jquery.bxslider.css' );
        if(!is_product() && !is_checkout()){
            wp_enqueue_style( 'SelectBox', get_template_directory_uri().'/includes/css/jquery.selectBox.css' );
        }
		wp_enqueue_style( 'FancyBox', get_template_directory_uri().'/includes/css/jquery.fancybox.css' );
		wp_register_style( 'prettyPhoto', get_template_directory_uri().'/includes/css/prettyPhoto.css' );
		do_action( 'fascat_add_css' );
	} // End fascat_add_css()

}



add_action('wp_head','html5_shiv');

function html5_shiv() {
	echo '<!--[if lte IE 8]>';
	echo '<script src="' . esc_url( 'https://html5shiv.googlecode.com/svn/trunk/html5.js' ) . '"></script>'. "\n";
	echo '<![endif]-->';
}
