<?php

// File Security Check

if ( ! empty( $_SERVER['SCRIPT_FILENAME'] ) && basename( __FILE__ ) == basename( $_SERVER['SCRIPT_FILENAME'] ) ) {

    die ( 'You do not have sufficient permissions to access this page' );

}

/*-----------------------------------------------------------------------------------



TABLE OF CONTENTS



- Theme Setup

- Load layout.css in the <head>

- Load responsive <meta> tags in the <head>

- Add custom styling to HEAD

- Add custom typograhpy to HEAD

- Add layout to body_class output

- woo_feedburner_link

- Load responsive IE JS

- Homepage hook

- Customise the breadcrumb



-----------------------------------------------------------------------------------*/



/*-----------------------------------------------------------------------------------*/

/* Theme Setup */

/*-----------------------------------------------------------------------------------*/

/**

 * Theme Setup

 *

 * This is the general theme setup, where we add_theme_support(), create global variables

 * and setup default generic filters and actions to be used across our theme.

 *

 * @package WooFramework

 * @subpackage Logic

 */



/**

 * Set the content width based on the theme's design and stylesheet.

 *

 * Used to set the width of images and content. Should be equal to the width the theme

 * is designed for, generally via the style.css stylesheet.

 */



if ( ! isset( $content_width ) ) $content_width = 640;



/**

 * Sets up theme defaults and registers support for various WordPress features.

 *

 * Note that this function is hooked into the after_setup_theme hook, which runs

 * before the init hook. The init hook is too late for some features, such as indicating

 * support for post thumbnails.

 *

 * To override fascat_setup() in a child theme, add your own fascat_setup to your child theme's

 * functions.php file.

 *

 * @uses add_theme_support() To add support for automatic feed links.

 * @uses add_editor_style() To style the visual editor.

 */



add_action( 'after_setup_theme', 'fascat_setup' );



if ( ! function_exists( 'fascat_setup' ) ) {

	function fascat_setup () {



		// This theme styles the visual editor with editor-style.css to match the theme style.

		if ( locate_template( 'editor-style.css' ) != '' ) { add_editor_style(); }



		// Add default posts and comments RSS feed links to head

		add_theme_support( 'automatic-feed-links' );



	}

}




/*-----------------------------------------------------------------------------------*/

/* Load layout.css in the <head> */

/*-----------------------------------------------------------------------------------*/



if ( ! is_admin() ) { add_action( 'get_header', 'woo_load_frontend_css', 10 ); }



if ( ! function_exists( 'woo_load_frontend_css' ) ) {

	function woo_load_frontend_css () {

		wp_register_style( 'woo-layout', get_template_directory_uri() . '/css/layout.css' );



		wp_enqueue_style( 'woo-layout' );

	} // End woo_load_frontend_css()

}



/*-----------------------------------------------------------------------------------*/

/* Load responsive <meta> tags in the <head> */

/*-----------------------------------------------------------------------------------*/



add_action( 'wp_head', 'woo_load_responsive_meta_tags', 10 );



if ( ! function_exists( 'woo_load_responsive_meta_tags' ) ) {

	function woo_load_responsive_meta_tags () {

		$html = '';



		$html .= "\n" . '<!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame -->' . "\n";

		$html .= '<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />' . "\n";



		/* Remove this if not responsive design */

		//$html .= "\n" . '<!--  Mobile viewport scale | Disable user zooming as the layout is optimised -->' . "\n";

		//$html .= '<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">' . "\n";



		echo $html;

	} // End woo_load_responsive_meta_tags()

}



/*-----------------------------------------------------------------------------------*/

/* Add Custom Styling to HEAD */

/*-----------------------------------------------------------------------------------*/



add_action( 'woo_head', 'woo_custom_styling', 10 ); // Add custom styling to HEAD



if ( ! function_exists( 'woo_custom_styling' ) ) {

	function woo_custom_styling() {



		$output = '';

		// Get options

		$settings = array(

						'body_color' => '',

						'body_img' => '',

						'body_repeat' => '',

						'body_pos' => '',

						'body_attachment' => '',

						'link_color' => '',

						'link_hover_color' => '',

						'button_color' => '',

						'homepage_banner_text_color' => ''

						);

		$settings = woo_get_dynamic_values( $settings );





		// Add CSS to output



		if ( $settings['body_color'] != '' ) {

			$output .= 'html { background: ' . $settings['body_color'] . ' !important; }' . "\n";

		}



		if ( $settings['body_img'] != '' ) {

			$output .= 'html { background-image: url( ' . $settings['body_img'] . ' ) !important; }' . "\n";

		}



		if ( ( $settings['body_img'] != '' ) && ( $settings['body_repeat'] != '' ) && ( $settings['body_pos'] != '' ) ) {

			$output .= 'html { background-repeat: ' . $settings['body_repeat'] . ' !important; }' . "\n";

		}



		if ( ( $settings['body_img'] != '' ) && ( $settings['body_pos'] != '' ) ) {

			$output .= 'html { background-position: ' . $settings['body_pos'] . ' !important; }' . "\n";

		}



		if ( ( $settings['body_img'] != '' ) && ( $settings['body_attachment'] != '' ) ) {

			$output .= 'html { background-attachment: ' . $settings['body_attachment'] . ' !important; }' . "\n";

		}



		if ( $settings['link_color'] != '' ) {

			$output .= 'a { color: ' . $settings['link_color'] . ' !important; }' . "\n";

		}



		if ( $settings['link_hover_color'] != '' ) {

			$output .= 'a:hover, .post-more a:hover, .post-meta a:hover, .post p.tags a:hover { color: ' . $settings['link_hover_color'] . ' !important; }' . "\n";

		}



		if ( $settings['button_color'] != '' ) {

			$output .= 'a.button, a.comment-reply-link, #commentform #submit, #contact-page .submit { background: ' . $settings['button_color'] . ' !important; border-color: ' . $settings['button_color'] . ' !important; }' . "\n";

			$output .= 'a.button:hover, a.button.hover, a.button.active, a.comment-reply-link:hover, #commentform #submit:hover, #contact-page .submit:hover { background: ' . $settings['button_color'] . ' !important; opacity: 0.9; }' . "\n";

		}



		if ( $settings['homepage_banner_text_color'] != '' ) {

			$output .= '.homepage-banner h1, .homepage-banner .description { color: ' . $settings['homepage_banner_text_color'] . ' !important; }' . "\n";

		}



		// Output styles

		if ( isset( $output ) && $output != '' ) {

			$output = strip_tags( $output );

			$output = "\n" . "<!-- Woo Custom Styling -->\n<style type=\"text/css\">\n" . $output . "</style>\n";

			echo $output;

		}



	} // End woo_custom_styling()

}






// Output stylesheet and custom.css after custom styling

remove_action( 'wp_head', 'fascat_wp_head' );

add_action( 'woo_head', 'fascat_wp_head' );





/*-----------------------------------------------------------------------------------*/

/* Add layout to body_class output */

/*-----------------------------------------------------------------------------------*/



add_filter( 'body_class','woo_layout_body_class', 10 );		// Add layout to body_class output



if ( ! function_exists( 'woo_layout_body_class' ) ) {

	function woo_layout_body_class( $classes ) {



		global $woo_options;



		$layout = 'two-col-left';



		if ( isset( $woo_options['woo_site_layout'] ) && ( $woo_options['woo_site_layout'] != '' ) ) {

			$layout = $woo_options['woo_site_layout'];

		}



		// Set main layout on post or page

		if ( is_singular() ) {

			global $post;

			$single = get_post_meta($post->ID, '_layout', true);

			if ( $single != "" AND $single != "layout-default" )

				$layout = $single;

		}



		// Add layout to $woo_options array for use in theme

		$woo_options['woo_layout'] = $layout;



		// Add classes to body_class() output

		$classes[] = $layout;

		return $classes;



	} // End woo_layout_body_class()

}





/*-----------------------------------------------------------------------------------*/

/* woo_feedburner_link() */

/*-----------------------------------------------------------------------------------*/

/**

 * woo_feedburner_link()

 *

 * Replace the default RSS feed link with the Feedburner URL, if one

 * has been provided by the user.

 *

 * @package WooFramework

 * @subpackage Filters

 */



add_filter( 'feed_link', 'woo_feedburner_link', 10 );



function woo_feedburner_link ( $output, $feed = null ) {



	global $woo_options;



	$default = get_default_feed();



	if ( ! $feed ) $feed = $default;



	if ( isset($woo_options[ 'woo_feed_url']) && $woo_options[ 'woo_feed_url' ] && ( $feed == $default ) && ( ! stristr( $output, 'comments' ) ) ) $output = esc_url( $woo_options[ 'woo_feed_url' ] );



	return $output;



} // End woo_feedburner_link()



/*-----------------------------------------------------------------------------------*/

/* Load responsive IE scripts */

/*-----------------------------------------------------------------------------------*/



add_action( 'wp_head', 'woo_load_responsive_IE_footer', 10 );



if ( ! function_exists( 'woo_load_responsive_IE_footer' ) ) {

	function woo_load_responsive_IE_footer () {

		$html = '';

		echo '<!--[if lt IE 9]>'. "\n";

		echo '<script src="' . esc_url( get_template_directory_uri() . '/includes/js/respond-IE.js' ) . '"></script>'. "\n";

		echo '<![endif]-->'. "\n";



		echo $html;

	} // End ()

}



/*-----------------------------------------------------------------------------------*/

/* Homepage hook */

/*-----------------------------------------------------------------------------------*/



function mystile_homepage_content() {

    do_action('mystile_homepage_content');

}



/*-----------------------------------------------------------------------------------*/

/* Customise the breadcrumb */

/*-----------------------------------------------------------------------------------*/

add_filter( 'woo_breadcrumbs_args', 'woo_custom_breadcrumbs_args', 10 );



if (!function_exists('woo_custom_breadcrumbs_args')) {

	function woo_custom_breadcrumbs_args ( $args ) {

		$textdomain = 'fascat';

		$args = array('separator' => '/', 'before' => '', 'show_home' => __( 'Home', $textdomain ),);

		return $args;

	} // End woo_custom_breadcrumbs_args()

}



/*-----------------------------------------------------------------------------------*/

/* END */

/*-----------------------------------------------------------------------------------*/
