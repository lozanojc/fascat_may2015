<?php

// File Security Check

if ( ! empty( $_SERVER['SCRIPT_FILENAME'] ) && basename( __FILE__ ) == basename( $_SERVER['SCRIPT_FILENAME'] ) ) {

    die ( 'You do not have sufficient permissions to access this page' );

}

?>

<?php

if (!function_exists( 'woo_options')) {

function woo_options() {



// THEME VARIABLES

$themename = 'FasCat';

$themeslug = 'fascat';



// STANDARD VARIABLES. DO NOT TOUCH!

$shortname = 'woo';


//Access the WordPress Categories via an Array

$woo_categories = array();

$woo_categories_obj = get_categories( 'hide_empty=0' );

foreach ($woo_categories_obj as $woo_cat) {

    $woo_categories[$woo_cat->cat_ID] = $woo_cat->cat_name;}

$categories_tmp = array_unshift($woo_categories, 'Select a category:' );



//Access the WordPress Pages via an Array

$woo_pages = array();

$woo_pages_obj = get_pages( 'sort_column=post_parent,menu_order' );

foreach ($woo_pages_obj as $woo_page) {

    $woo_pages[$woo_page->ID] = $woo_page->post_name; }

$woo_pages_tmp = array_unshift($woo_pages, 'Select a page:' );



//Stylesheets Reader

$alt_stylesheet_path = get_template_directory() . '/styles/';

$alt_stylesheets = array();

if ( is_dir($alt_stylesheet_path) ) {

    if ($alt_stylesheet_dir = opendir($alt_stylesheet_path) ) {

        while ( ($alt_stylesheet_file = readdir($alt_stylesheet_dir)) !== false ) {

            if(stristr($alt_stylesheet_file, '.css') !== false) {

                $alt_stylesheets[] = $alt_stylesheet_file;

            }

        }

    }

}



//More Options

$other_entries = array( '0','1','2','3','4','5','6','7','8','9','10','11','12','13','14','15','16','17','18','19' );



// THIS IS THE DIFFERENT FIELDS

$options = array();



/* General */



$options[] = array( 'name' => __( 'General Settings', 'fascat' ),

    				'type' => 'heading',

    				'icon' => 'general' );



$options[] = array( 'name' => __( 'Quick Start', 'fascat' ),

    				'type' => 'subheading' );



$options[] = array( 'name' => __( 'Theme Stylesheet', 'fascat' ),

    				'desc' => __( 'Select your themes alternative color scheme.', 'fascat' ),

    				'id' => $shortname . '_alt_stylesheet',

    				'std' => 'default.css',

    				'type' => 'select',

    				'options' => $alt_stylesheets );



$options[] = array( 'name' => __( 'Custom Logo', 'fascat' ),

    				'desc' => __( 'Upload a logo for your theme, or specify an image URL directly.', 'fascat' ),

    				'id' => $shortname . '_logo',

    				'std' => '',

    				'type' => 'upload' );



$options[] = array( 'name' => __( 'Text Title', 'fascat' ),

    				'desc' => sprintf( __( 'Enable text-based Site Title and Tagline. Setup title & tagline in %1$s.', 'fascat' ), '<a href="' . esc_url( home_url() ) . '/wp-admin/options-general.php">' . __( 'General Settings', 'fascat' ) . '</a>' ),

    				'id' => $shortname . '_texttitle',

    				'std' => 'true',

    				'type' => 'checkbox' );



$options[] = array( 'name' => __( 'Site Description', 'fascat' ),

    				'desc' => __( 'Enable the site description/tagline under site title.', 'fascat' ),

    				'id' => $shortname . '_tagline',

    				'std' => 'true',

    				'type' => 'checkbox' );



$options[] = array( 'name' => __( 'Custom Favicon', 'fascat' ),

    				'desc' => sprintf( __( 'Upload a 16px x 16px %1$s that will represent your website\'s favicon.', 'fascat' ), '<a href="http://www.faviconr.com/">'.__( 'ico image', 'fascat' ).'</a>' ),

    				'id' => $shortname . '_custom_favicon',

    				'std' => '',

    				'type' => 'upload' );



$options[] = array( 'name' => __( 'Tracking Code', 'fascat' ),

    				'desc' => __( 'Paste your Google Analytics (or other) tracking code here. This will be added into the footer template of your theme.', 'fascat' ),

    				'id' => $shortname . '_google_analytics',

    				'std' => '',

    				'type' => 'textarea' );

    				

$options[] = array( 'name' => __( 'Subscription Settings', 'fascat' ),

    				'type' => 'subheading' );



$options[] = array( 'name' => __( 'RSS URL', 'fascat' ),

    				'desc' => __( 'Enter your preferred RSS URL. (Feedburner or other)', 'fascat' ),

    				'id' => $shortname . '_feed_url',

    				'std' => '',

    				'type' => 'text' );



$options[] = array( 'name' => __( 'E-Mail Subscription URL', 'fascat' ),

    				'desc' => __( 'Enter your preferred E-mail subscription URL. (Feedburner or other)', 'fascat' ),

    				'id' => $shortname . '_subscribe_email',

    				'std' => '',

    				'type' => 'text' );



$options[] = array( 'name' => __( 'Display Options', 'fascat' ),

    				'type' => 'subheading' );



$options[] = array( 'name' => __( 'Custom CSS', 'fascat' ),

    				'desc' => __( 'Quickly add some CSS to your theme by adding it to this block.', 'fascat' ),

    				'id' => $shortname . '_custom_css',

    				'std' => '',

    				'type' => 'textarea' );



$options[] = array( 'name' => __( 'Post/Page Comments', 'fascat' ),

    				'desc' => __( 'Select if you want to enable/disable comments on posts and/or pages.', 'fascat' ),

    				'id' => $shortname . '_comments',

    				'std' => 'both',

    				'type' => 'select2',

    				'options' => array( 'post' => __( 'Posts Only', 'fascat' ), 'page' => __( 'Pages Only', 'fascat' ), 'both' => __( 'Pages / Posts', 'fascat' ), 'none' => __( 'None', 'fascat' ) ) );



$options[] = array( 'name' => __( 'Post Content', 'fascat' ),

    				'desc' => __( 'Select if you want to show the full content or the excerpt on posts.', 'fascat' ),

    				'id' => $shortname . '_post_content',

    				'type' => 'select2',

    				'options' => array( 'excerpt' => __( 'The Excerpt', 'fascat' ), 'content' => __( 'Full Content', 'fascat' ) ) );



$options[] = array( 'name' => __( 'Display Breadcrumbs', 'fascat' ),

    				'desc' => __( 'Display dynamic breadcrumbs on each page of your website.', 'fascat' ),

    				'id' => $shortname . '_breadcrumbs_show',

    				'std' => 'false',

    				'type' => 'checkbox' );



$options[] = array( 'name' => __( 'Display Pagination', 'fascat' ),

    				'desc' => __( 'Display pagination on the blog.', 'fascat' ),

    				'id' => $shortname . '_pagenav_show',

    				'std' => 'true',

    				'type' => 'checkbox' );



$options[] = array( 'name' => __( 'Pagination Style', 'fascat' ),

    				'desc' => __( 'Select the style of pagination you would like to use on the blog.', 'fascat' ),

    				'id' => $shortname . '_pagination_type',

    				'type' => 'select2',

    				'options' => array( 'paginated_links' => __( 'Numbers', 'fascat' ), 'simple' => __( 'Next/Previous', 'fascat' ) ) );



/* Styling */



$options[] = array( 'name' => __( 'Styling Options', 'fascat' ),

    				'type' => 'heading',

    				'icon' => 'styling' );



$options[] = array( 'name' => __( 'Background', 'fascat' ),

    				'type' => 'subheading' );



$options[] = array( 'name' => __( 'Body Background Color', 'fascat' ),

    				'desc' => __( 'Pick a custom color for background color of the theme e.g. #697e09. Only applied when using a boxed layout (see Layout Options).', 'fascat' ),

    				'id' => $shortname . '_body_color',

    				'std' => '',

    				'type' => 'color' );



$options[] = array( 'name' => __( 'Body background image', 'fascat' ),

    				'desc' => __( 'Upload an image for the theme\'s background', 'fascat' ),

    				'id' => $shortname . '_body_img',

    				'std' => '',

    				'type' => 'upload' );



$options[] = array( 'name' => __( 'Background image repeat', 'fascat' ),

    				'desc' => __( 'Select how you would like to repeat the background-image', 'fascat' ),

    				'id' => $shortname . '_body_repeat',

    				'std' => 'no-repeat',

    				'type' => 'select',

    				'options' => array( 'no-repeat', 'repeat-x', 'repeat-y', 'repeat' ) );



$options[] = array( 'name' => __( 'Background image position', 'fascat' ),

    				'desc' => __( 'Select how you would like to position the background', 'fascat' ),

    				'id' => $shortname . '_body_pos',

    				'std' => 'top',

    				'type' => 'select',

    				'options' => array( 'top left', 'top center', 'top right', 'center left', 'center center', 'center right', 'bottom left', 'bottom center', 'bottom right' ) );

    

$options[] = array( 'name' => __( 'Background Attachment', 'fascat' ),

    				'desc' => __( 'Select whether the background should be fixed or move when the user scrolls', 'fascat' ),

    				'id' => $shortname.'_body_attachment',

    				'std' => 'scroll',

    				'type' => 'select',

    				'options' => array( 'scroll', 'fixed' ) );



$options[] = array( 'name' => __( 'Links', 'fascat' ),

    				'type' => 'subheading' );



$options[] = array( 'name' => __( 'Link Color', 'fascat' ),

    				'desc' => __( 'Pick a custom color for links or add a hex color code e.g. #697e09', 'fascat' ),

    				'id' => $shortname . '_link_color',

    				'std' => '',

    				'type' => 'color' );

    				

$options[] = array( 'name' => __( 'Link Hover Color', 'fascat' ),

    				'desc' => __( 'Pick a custom color for links hover or add a hex color code e.g. #697e09', 'fascat' ),

    				'id' => $shortname . '_link_hover_color',

    				'std' => '',

    				'type' => 'color' );



$options[] = array( 'name' => __( 'Button Color', 'fascat' ),

    				'desc' => __( 'Pick a custom color for buttons or add a hex color code e.g. #697e09', 'fascat' ),

    				'id' => $shortname . '_button_color',

    				'std' => '',

    				'type' => 'color' );





/* Layout */



$options[] = array( 'name' => __( 'Layout Options', 'fascat' ),

    				'type' => 'heading',

    				'icon' => 'layout' );

    			

$options[] = array( 'name' => __( 'Enable boxed layout', 'fascat' ) ,

    				'desc' => __( 'Wrap your site content inside a frame.', 'fascat' ) ,

    				'id' => $shortname . '_boxed_layout',

    				'std' => 'false',

    				'type' => 'checkbox' );



$url =  get_template_directory_uri() . '/functions/images/';

$options[] = array( 'name' => __( 'Main Layout', 'fascat' ),

    				'desc' => __( 'Select which layout you want for your site.', 'fascat' ),

    				'id' => $shortname . '_site_layout',

    				'std' => 'layout-right-content',

    				'type' => 'images',

    				'options' => array(

    					'layout-left-content' => $url . '2cl.png',

    					'layout-right-content' => $url . '2cr.png' )

    				);					



$options[] = array( 'name' => __( 'Category Exclude - Homepage', 'fascat' ),

    				'desc' => __( 'Specify a comma seperated list of category IDs or slugs that you\'d like to exclude from your homepage (eg: uncategorized).', 'fascat' ),

    				'id' => $shortname . '_exclude_cats_home',

    				'std' => '',

    				'type' => 'text' );



$options[] = array( 'name' => __( 'Category Exclude - Blog Page Template', 'fascat' ),

    				'desc' => __( 'Specify a comma seperated list of category IDs or slugs that you\'d like to exclude from your \'Blog\' page template (eg: uncategorized).', 'fascat' ),

    				'id' => $shortname . '_exclude_cats_blog',

    				'std' => '',

    				'type' => 'text' );



/* Homepage */			

	$options[] = array( 'name' => __( 'Homepage', 'fascat' ),

	    				'type' => 'heading',

	    				'icon' => 'homepage' );

	    				

	$options[] = array( 'name' => __( 'Featured Image', 'fascat' ),

    					'type' => 'subheading' );

    $options[] = array( 'name' => __( 'Display a banner', 'fascat' ),

    					'desc' => __( 'Display a banner on the homepage?', 'fascat' ),

    					'id' => $shortname.'_homepage_banner',

    					'std' => 'false',

    					'class' => 'collapsed',

    					'type' => 'checkbox' );

	$options[] = array( 'name' => __( 'Featured Image', 'fascat' ),

    					'desc' => __( 'Upload a graphic to appear as a banner on the homepage.', 'fascat' ),

    					'id' => $shortname . '_homepage_banner_path',

    					'std' => '',

    					'class' => 'hidden',

    					'type' => 'upload' );

    $options[] = array( 'name' => __( 'Banner headline', 'fascat' ),

	    				'desc' => __( 'The headline which will overlay your banner.', 'fascat' ),

	    				'id' => $shortname . '_homepage_banner_headline',

	    				'std' => 'Welcome to our store',

	    				'class' => 'hidden',

	    				'type' => 'text' );

	$options[] = array( 'name' => __( 'Banner stand first', 'fascat' ),

	    				'desc' => __( 'The copy which overlays the banner beneath the headline.', 'fascat' ),

	    				'id' => $shortname . '_homepage_banner_standfirst',

	    				'std' => 'We hand make the most awesomest products in the world',

	    				'class' => 'hidden',

	    				'type' => 'textarea' );

	    				

	$options[] = array( 'name' => __( 'Banner text colour', 'fascat' ),

	    				'desc' => __( 'Pick a custom color for the text overlayed on the banner', 'fascat' ),

	    				'id' => $shortname . '_homepage_banner_text_color',

	    				'std' => '',

	    				'type' => 'color' );

	    				

	$options[] = array( 'name' => __( 'Sidebar', 'fascat' ),

    					'type' => 'subheading' );

	$options[] = array( 'name' => __( 'Display a sidebar', 'fascat' ),

    					'desc' => __( 'Display a sidebar on the homepage?', 'fascat' ),

    					'id' => $shortname.'_homepage_sidebar',

    					'std' => 'false',

    					'type' => 'checkbox' );

    if (class_exists('woocommerce')) {

    $options[] = array( 'name' => __( 'WooCommerce', 'fascat' ),

    					'type' => 'subheading' );

    $options[] = array( 'name' => __( 'Display product categories', 'fascat' ),

    					'desc' => __( 'Display product categories on the homepage?', 'fascat' ),

    					'id' => $shortname.'_homepage_product_categories',

    					'std' => 'false',

    					'type' => 'checkbox' );

	$options[] = array( 'name' => __( 'Display featured products', 'fascat' ),

    					'desc' => __( 'Display features products on the homepage?', 'fascat' ),

    					'id' => $shortname.'_homepage_featured_products',

    					'std' => 'false',

    					'type' => 'checkbox' );

    $options[] = array( 'name' => __( 'Display how many featured products?', 'fascat' ),

						'desc' => __( 'Specify how many featured products should appear on the homepage.', 'fascat' ),

						'id' => $shortname . '_homepage_featured_products_perpage',

						'std' => '8',

						'type' => 'select2',

						'options' => $other_entries);

	$options[] = array( 'name' => __( 'Display recent products', 'fascat' ),

    					'desc' => __( 'Display recent products on the homepage?', 'fascat' ),

    					'id' => $shortname.'_homepage_products',

    					'std' => 'true',

    					'type' => 'checkbox' );

    $options[] = array( 'name' => __( 'Display how many recent products?', 'fascat' ),

						'desc' => __( 'Specify how many recent products should appear on the homepage.', 'fascat' ),

						'id' => $shortname . '_homepage_products_perpage',

						'std' => '8',

						'type' => 'select2',

						'options' => $other_entries);

	}

    $options[] = array( 'name' => __( 'Blog', 'fascat' ),

    					'type' => 'subheading' );

	$options[] = array( 'name' => __( 'Display latest blog posts', 'fascat' ),

    					'desc' => __( 'Display latest posts on the homepage?', 'fascat' ),

    					'id' => $shortname.'_homepage_blog',

    					'std' => 'true',

    					'class' => 'collapsed',

    					'type' => 'checkbox' );

    $options[] = array( 'name' => __( 'Display how many posts?', 'fascat' ),

						'desc' => __( 'Specify how many posts should appear on the homepage.', 'fascat' ),

						'id' => $shortname . '_homepage_blog_perpage',

						'std' => '3',

						'type' => 'select2',

						'class' => 'hidden',

						'options' => $other_entries);

    

/* WooCommerce */



if (class_exists('woocommerce')) {

    $options[] = array( 'name' => __( 'WooCommerce', 'fascat' ),

    					'type' => 'heading',

    					'icon' => 'woocommerce' );

    	

    $options[] = array( 'name' => __( 'Products', 'fascat' ),

    					'type' => 'subheading' );



    $options[] = array( 'name' => __( 'Products per page', 'fascat' ),

    					'desc' => __( 'How many products do you want to display on product archive pages?', 'fascat' ),

    					'id' => $shortname.'commerce_products_per_page',

    					'std' => '12',

    					'type' => 'text' );

    

    $options[] = array( 'name' => __( 'Display product tabs', 'fascat' ),

    					'desc' => __( 'Display the product review / attribute tabs in product details page', 'fascat' ),

    					'id' => $shortname.'commerce_product_tabs',

    					'std' => 'true',

    					'type' => 'checkbox' );

    	

    $options[] = array( 'name' => __( 'Display related products', 'fascat' ),

    					'desc' => __( 'Display related products on the product details page', 'fascat' ),

    					'id' => $shortname.'commerce_related_products',

    					'std' => 'true',

    					'type' => 'checkbox' );

    	

    $options[] = array( 'name' => __( 'Layout', 'fascat' ),

    					'type' => 'subheading' );



    $options[] = array( 'name' => __( 'Display the sidebar on shop archives?', 'fascat' ),

    					'desc' => __( 'Global setting to show / hide the sidebar on product archive pages', 'fascat' ),

    					'id' => $shortname.'commerce_archives_fullwidth',

    					'std' => 'false',

    					'type' => 'checkbox' );  

    

    $options[] = array( 'name' => __( 'Display the sidebar on product pages?', 'fascat' ),

    					'desc' => __( 'Global setting to show / hide the sidebar on <em>all</em> product pages' ),

    					'id' => $shortname.'commerce_products_fullwidth',

    					'std' => 'false',

    					'type' => 'checkbox' );     					

}



/* Dynamic Images */



$options[] = array( 'name' => __( 'Dynamic Images', 'fascat' ),

    				'type' => 'heading',

    				'icon' => 'image' );



$options[] = array( 'name' => __( 'Resizer Settings', 'fascat' ),

    				'type' => 'subheading' );



$options[] = array( 'name' => __( 'Dynamic Image Resizing', 'fascat' ),

    				'desc' => '',

    				'id' => $shortname . '_wpthumb_notice',

    				'std' => __( 'There are two alternative methods of dynamically resizing the thumbnails in the theme, <strong>WP Post Thumbnail</strong> or <strong>TimThumb - Custom Settings panel</strong>. We recommend using WP Post Thumbnail option.', 'fascat' ),

    				'type' => 'info' );



$options[] = array( 'name' => __( 'WP Post Thumbnail', 'fascat' ),

    				'desc' => __( 'Use WordPress post thumbnail to assign a post thumbnail. Will enable the <strong>Featured Image panel</strong> in your post sidebar where you can assign a post thumbnail.', 'fascat' ),

    				'id' => $shortname . '_post_image_support',

    				'std' => 'true',

    				'class' => 'collapsed',

    				'type' => 'checkbox' );



$options[] = array( 'name' => __( 'WP Post Thumbnail - Dynamic Image Resizing', 'fascat' ),

    				'desc' => __( 'The post thumbnail will be dynamically resized using native WP resize functionality. <em>(Requires PHP 5.2+)</em>', 'fascat' ),

    				'id' => $shortname . '_pis_resize',

    				'std' => 'true',

    				'class' => 'hidden',

    				'type' => 'checkbox' );



$options[] = array( 'name' => __( 'WP Post Thumbnail - Hard Crop', 'fascat' ),

    				'desc' => __( 'The post thumbnail will be cropped to match the target aspect ratio (only used if "Dynamic Image Resizing" is enabled).', 'fascat' ),

    				'id' => $shortname . '_pis_hard_crop',

    				'std' => 'true',

    				'class' => 'hidden last',

    				'type' => 'checkbox' );



$options[] = array( 'name' => __( 'TimThumb - Custom Settings Panel', 'fascat' ),

    				'desc' => sprintf( __( 'This will enable the %1$s (thumb.php) script which dynamically resizes images added through the <strong>custom settings panel below the post</strong>. Make sure your themes <em>cache</em> folder is writable. %2$s', 'fascat' ), '<a href="http://code.google.com/p/timthumb/">TimThumb</a>', '<a href="http://www.fascat.com/2008/10/troubleshooting-image-resizer-thumbphp/">Need help?</a>' ),

    				'id' => $shortname . '_resize',

    				'std' => 'true',

    				'type' => 'checkbox' );



$options[] = array( 'name' => __( 'Automatic Image Thumbnail', 'fascat' ),

    				'desc' => __( 'If no thumbnail is specifified then the first uploaded image in the post is used.', 'fascat' ),

    				'id' => $shortname . '_auto_img',

    				'std' => 'false',

    				'type' => 'checkbox' );



$options[] = array( 'name' => __( 'Thumbnail Settings', 'fascat' ),

    				'type' => 'subheading' );



$options[] = array( 'name' => __( 'Thumbnail Image Dimensions', 'fascat' ),

    				'desc' => __( 'Enter an integer value i.e. 250 for the desired size which will be used when dynamically creating the images.', 'fascat' ),

    				'id' => $shortname . '_image_dimensions',

    				'std' => '',

    				'type' => array(

    					array(  'id' => $shortname . '_thumb_w',

    						'type' => 'text',

    						'std' => 787,

    						'meta' => __( 'Width', 'fascat' ) ),

    					array(  'id' => $shortname . '_thumb_h',

    						'type' => 'text',

    						'std' => 300,

    						'meta' => __( 'Height', 'fascat' ) )

    				) );



$options[] = array( 'name' => __( 'Thumbnail Alignment', 'fascat' ),

    				'desc' => __( 'Select how to align your thumbnails with posts.', 'fascat' ),

    				'id' => $shortname . '_thumb_align',

    				'std' => 'alignleft',

    				'type' => 'select2',

    				'options' => array( 'alignleft' => __( 'Left', 'fascat' ), 'alignright' => __( 'Right', 'fascat' ), 'aligncenter' => __( 'Center', 'fascat' ) ) );



$options[] = array( 'name' => __( 'Single Post - Show Thumbnail', 'fascat' ),

    				'desc' => __( 'Show the thumbnail in the single post page.', 'fascat' ),

    				'id' => $shortname . '_thumb_single',

    				'class' => 'collapsed',

    				'std' => 'true',

    				'type' => 'checkbox' );



$options[] = array( 'name' => __( 'Single Post - Thumbnail Dimensions', 'fascat' ),

    				'desc' => __( 'Enter an integer value i.e. 250 for the image size. Max width is 576.', 'fascat' ),

    				'id' => $shortname . '_image_dimensions',

    				'std' => '',

    				'class' => 'hidden last',

    				'type' => array(

    					array(  'id' => $shortname . '_single_w',

    						'type' => 'text',

    						'std' => 787,

    						'meta' => __( 'Width', 'fascat' ) ),

    					array(  'id' => $shortname . '_single_h',

    						'type' => 'text',

    						'std' => 300,

    						'meta' => __( 'Height', 'fascat' ) )

    				) );



$options[] = array( 'name' => __( 'Single Post - Thumbnail Alignment', 'fascat' ),

    				'desc' => __( 'Select how to align your thumbnail with single posts.', 'fascat' ),

    				'id' => $shortname . '_thumb_single_align',

    				'std' => 'alignright',

    				'type' => 'select2',

    				'class' => 'hidden',

    				'options' => array( 'alignleft' => __( 'Left', 'fascat' ), 'alignright' => __( 'Right', 'fascat' ), 'aligncenter' => __( 'Center', 'fascat' ) ) );



$options[] = array( 'name' => __( 'Add thumbnail to RSS feed', 'fascat' ),

    				'desc' => __( 'Add the the image uploaded via your Custom Settings panel to your RSS feed', 'fascat' ),

    				'id' => $shortname . '_rss_thumb',

    				'std' => 'false',

    				'type' => 'checkbox' );



$options[] = array( 'name' => __( 'Enable Lightbox', 'fascat' ),

    				'desc' => __( 'Enable the PrettyPhoto lighbox script on images within your website\'s content.', 'fascat' ),

    				'id' => $shortname . '_enable_lightbox',

    				'std' => 'false',

    				'type' => 'checkbox' );



/* Footer */



$options[] = array( 'name' => __( 'Footer Customization', 'fascat' ),

    				'type' => 'heading',

    				'icon' => 'footer' );



$url =  get_template_directory_uri() . '/functions/images/';

$options[] = array( 'name' => __( 'Footer Widget Areas', 'fascat' ),

    				'desc' => __( 'Select how many footer widget areas you want to display.', 'fascat' ),

    				'id' => $shortname . '_footer_sidebars',

    				'std' => '4',

    				'type' => 'images',

    				'options' => array(

    					'0' => $url . 'layout-off.png',

    					'1' => $url . 'footer-widgets-1.png',

    					'2' => $url . 'footer-widgets-2.png',

    					'3' => $url . 'footer-widgets-3.png',

    					'4' => $url . 'footer-widgets-4.png' )

    				);


$options[] = array( 'name' => __( 'Footer Copyright icons', 'fascat' ),

					'type' => 'subheading');


$options[] = array( 'name' => __( 'Custom Affiliate Link', 'fascat' ),

    				'desc' => __( 'Add an affiliate link to the fascat logo in the footer of the theme.', 'fascat' ),

    				'id' => $shortname . '_footer_aff_link',

    				'std' => '',

    				'type' => 'text' );



$options[] = array( 'name' => __( 'Enable Custom Footer (Left)', 'fascat' ),

    				'desc' => __( 'Activate to add the custom text below to the theme footer.', 'fascat' ),

    				'id' => $shortname . '_footer_left',

    				'std' => 'false',

    				'type' => 'checkbox' );



$options[] = array( 'name' => __( 'Custom Text (Left)', 'fascat' ),

    				'desc' => __( 'Custom HTML and Text that will appear in the footer of your theme.', 'fascat' ),

    				'id' => $shortname . '_footer_left_text',

    				'std' => '',

    				'type' => 'textarea' );



$options[] = array( 'name' => __( 'Enable Custom Footer (Right)', 'fascat' ),

    				'desc' => __( 'Activate to add the custom text below to the theme footer.', 'fascat' ),

    				'id' => $shortname . '_footer_right',

    				'std' => 'false',

    				'type' => 'checkbox' );



$options[] = array( 'name' => __( 'Custom Text (Right)', 'fascat' ),

    				'desc' => __( 'Custom HTML and Text that will appear in the footer of your theme.', 'fascat' ),

    				'id' => $shortname . '_footer_right_text',

    				'std' => '',

    				'type' => 'textarea' );

$options[] = array( 'name' => __( 'Contact Information on Orange Background', 'fascat' ),

					'type' => 'subheading');

$options[] = array( 'name' => __( 'Info', 'fascat' ),

					'desc' => __( "Enter the html to show over the Orange background", 'fascat' ),

					'id' => $shortname . '_info_orange',

					'std' => '',

					'type' => 'textarea' );



/* Subscribe & Connect */



$options[] = array( 'name' => __( 'Subscribe & Connect', 'fascat' ),

    				'type' => 'heading',

    				'icon' => 'connect' );



$options[] = array( 'name' => __( 'Setup', 'fascat' ),

    				'type' => 'subheading' );



$options[] = array( 'name' => __( 'Enable Subscribe & Connect - Single Post', 'fascat' ),

    				'desc' => sprintf( __( 'Enable the subscribe & connect area on single posts. You can also add this as a %1$s in your sidebar.', 'fascat' ), '<a href="' . esc_url( home_url() ) . '/wp-admin/widgets.php">widget</a>' ),

    				'id' => $shortname . '_connect',

    				'std' => 'false',

    				'type' => 'checkbox' );



$options[] = array( 'name' => __( 'Subscribe Title', 'fascat' ),

    				'desc' => __( 'Enter the title to show in your subscribe & connect area.', 'fascat' ),

    				'id' => $shortname . '_connect_title',

    				'std' => '',

    				'type' => 'text' );



$options[] = array( 'name' => __( 'Text', 'fascat' ),

    				'desc' => __( 'Change the default text in this area.', 'fascat' ),

    				'id' => $shortname . '_connect_content',

    				'std' => '',

    				'type' => 'textarea' );



$options[] = array( 'name' => __( 'Enable Related Posts', 'fascat' ),

    				'desc' => __( 'Enable related posts in the subscribe area. Uses posts with the same <strong>tags</strong> to find related posts. Note: Will not show in the Subscribe widget.', 'fascat' ),

    				'id' => $shortname . '_connect_related',

    				'std' => 'true',

    				'type' => 'checkbox' );



$options[] = array( 'name' => __( 'Subscribe Settings', 'fascat' ),

    				'type' => 'subheading' );



$options[] = array( 'name' => __( 'Subscribe By E-mail ID (Feedburner)', 'fascat' ),

    				'desc' => sprintf( __( 'Enter your %1$s for the e-mail subscription form.', 'fascat' ), '<a href="http://www.fascat.com/tutorials/how-to-find-your-feedburner-id-for-email-subscription/">'.__( 'Feedburner ID', 'fascat' ).'</a>' ),

    				'id' => $shortname . '_connect_newsletter_id',

    				'std' => '',

    				'type' => 'text' );



$options[] = array( 'name' => __( 'Subscribe By E-mail to MailChimp', 'fascat', 'fascat' ),

    				'desc' => sprintf( __( 'If you have a MailChimp account you can enter the %1$s to allow your users to subscribe to a MailChimp List.', 'fascat' ), '<a href="http://woochimp.heroku.com" target="_blank">'.__( 'MailChimp List Subscribe URL', 'fascat' ).'</a>' ),

    				'id' => $shortname . '_connect_mailchimp_list_url',

    				'std' => '',

    				'type' => 'text' );



$options[] = array( 'name' => __( 'Connect Settings', 'fascat' ),

    				'type' => 'subheading' );



$options[] = array( 'name' => __( 'Enable RSS', 'fascat' ),

    				'desc' => __( 'Enable the subscribe and RSS icon.', 'fascat' ),

    				'id' => $shortname . '_connect_rss',

    				'std' => 'true',

    				'type' => 'checkbox' );



$options[] = array( 'name' => __( 'Twitter URL', 'fascat' ),

    				'desc' => sprintf( __( 'Enter your %1$s URL e.g. http://www.twitter.com/fascat', 'fascat' ), '<a href="http://www.twitter.com/">'.__( 'Twitter', 'fascat' ).'</a>' ),

    				'id' => $shortname . '_connect_twitter',

    				'std' => '',

    				'type' => 'text' );



$options[] = array( 'name' => __( 'Facebook URL', 'fascat' ),

    				'desc' => sprintf( __( 'Enter your %1$s URL e.g. http://www.facebook.com/fascat', 'fascat' ), '<a href="http://www.facebook.com/">'.__( 'Facebook', 'fascat' ).'</a>' ),

    				'id' => $shortname . '_connect_facebook',

    				'std' => '',

    				'type' => 'text' );



$options[] = array( 'name' => __( 'YouTube URL', 'fascat' ),

    				'desc' => sprintf( __( 'Enter your %1$s URL e.g. http://www.youtube.com/fascat', 'fascat' ), '<a href="http://www.youtube.com/">'.__( 'YouTube', 'fascat' ).'</a>' ),

    				'id' => $shortname . '_connect_youtube',

    				'std' => '',

    				'type' => 'text' );



$options[] = array( 'name' => __( 'Flickr URL', 'fascat' ),

    				'desc' => sprintf( __( 'Enter your %1$s URL e.g. http://www.flickr.com/fascat', 'fascat' ), '<a href="http://www.flickr.com/">'.__( 'Flickr', 'fascat' ).'</a>' ),

    				'id' => $shortname . '_connect_flickr',

    				'std' => '',

    				'type' => 'text' );



$options[] = array( 'name' => __( 'LinkedIn URL', 'fascat' ),

    				'desc' => sprintf( __( 'Enter your %1$s URL e.g. http://www.linkedin.com/in/fascat', 'fascat' ), '<a href="http://www.www.linkedin.com.com/">'.__( 'LinkedIn', 'fascat' ).'</a>' ),

    				'id' => $shortname . '_connect_linkedin',

    				'std' => '',

    				'type' => 'text' );



$options[] = array( 'name' => __( 'Delicious URL', 'fascat' ),

    				'desc' => sprintf( __( 'Enter your %1$s URL e.g. http://www.delicious.com/fascat', 'fascat' ), '<a href="http://www.delicious.com/">'.__( 'Delicious', 'fascat' ).'</a>' ),

    				'id' => $shortname . '_connect_delicious',

    				'std' => '',

    				'type' => 'text' );



$options[] = array( 'name' => __( 'Google+ URL', 'fascat' ),

    				'desc' => sprintf( __( 'Enter your %1$s URL e.g. https://plus.google.com/104560124403688998123/', 'fascat' ), '<a href="http://plus.google.com/">'.__( 'Google+', 'fascat' ).'</a>' ),

    				'id' => $shortname . '_connect_googleplus',

    				'std' => '',

    				'type' => 'text' );



/* Advertising */



$options[] = array( 'name' => __( 'Advertising', 'fascat' ),

    				'type' => 'heading',

    				'icon' => 'ads' );



$options[] = array( 'name' => __( 'Adsense code', 'fascat' ),

    				'desc' => __( 'Enter your adsense code (or other ad network code) here.', 'fascat' ),

    				'id' => $shortname . '_ad_top_adsense',

    				'std' => '',

    				'type' => 'textarea' );

									

/* Contact Template Settings */



$options[] = array( 'name' => __( 'Contact Page', 'fascat' ),

					'icon' => 'maps',

				    'type' => 'heading');    										

$options[] = array( 'name' => __( 'Maps', 'fascat' ),

					'type' => 'subheading');

					

$options[] = array( 'name' => __( 'Contact Form Google Maps Coordinates', 'fascat' ),

					'desc' => sprintf( __( 'Enter your Google Map coordinates to display a map on the Contact Form page template and a link to it on the Contact Us widget. You can get these details from %1$s', 'fascat' ), '<a href="http://dbsgeo.com/latlon/" target="_blank">'.__( 'Google Maps', 'fascat' ).'</a>' ),

					'id' => $shortname . '_contactform_map_coords',

					'std' => '',

					'type' => 'text' );

					

$options[] = array( 'name' => __( 'Disable Mousescroll', 'fascat' ),

					'desc' => __( 'Turn off the mouse scroll action for all the Google Maps on the site. This could improve usability on your site.', 'fascat' ),

					'id' => $shortname . '_maps_scroll',

					'std' => '',

					'type' => 'checkbox');



$options[] = array( 'name' => __( 'Map Height', 'fascat' ),

					'desc' => __( 'Height in pixels for the maps displayed on Single.php pages.', 'fascat' ),

					'id' => $shortname . '_maps_single_height',

					'std' => '250',

					'type' => 'text');

					

$options[] = array( 'name' => __( 'Default Map Zoom Level', 'fascat' ),

					'desc' => __( 'Set this to adjust the default in the post & page edit backend.', 'fascat' ),

					'id' => $shortname . '_maps_default_mapzoom',

					'std' => '9',

					'type' => 'select2',

					'options' => $other_entries);



$options[] = array( 'name' => __( 'Default Map Type', 'fascat' ),

					'desc' => __( 'Set this to the default rendered in the post backend.', 'fascat' ),

					'id' => $shortname . '_maps_default_maptype',

					'std' => 'G_NORMAL_MAP',

					'type' => 'select2',

					'options' => array( 'G_NORMAL_MAP' => __( 'Normal', 'fascat' ), 'G_SATELLITE_MAP' => __( 'Satellite', 'fascat' ),'G_HYBRID_MAP' => __( 'Hybrid', 'fascat' ), 'G_PHYSICAL_MAP' => __( 'Terrain', 'fascat' ) ) );



$options[] = array( 'name' => __( 'Map Callout Text', 'fascat' ),

					'desc' => __( 'Text or HTML that will be output when you click on the map marker for your location.', 'fascat' ),

					'id' => $shortname . '_maps_callout_text',

					'std' => '',

					'type' => 'textarea');

					

// Add extra options through function

if ( function_exists( 'woo_options_add') )

	$options = woo_options_add($options);



if ( get_option( 'woo_template') != $options) update_option( 'woo_template',$options);

if ( get_option( 'woo_themename') != $themename) update_option( 'woo_themename',$themename);

if ( get_option( 'woo_shortname') != $shortname) update_option( 'woo_shortname',$shortname);

if ( get_option( 'woo_manual') != $manualurl) update_option( 'woo_manual',$manualurl);



// Woo Metabox Options

// Start name with underscore to hide custom key from the user

global $post;

$woo_metaboxes = array();



// Shown on both posts and pages





// Show only on specific post types or page



if ( ( get_post_type() == 'post') || ( !get_post_type() ) ) {



	// TimThumb is enabled in options

	if ( get_option( 'woo_resize') == 'true' ) {

	

		$woo_metaboxes[] = array (	'name' => 'image',

									'label' => __( 'Image', 'fascat' ),

									'type' => 'upload',

									'desc' => __( 'Upload an image or enter an URL.', 'fascat' ) );



		$woo_metaboxes[] = array (	'name' => '_image_alignment',

									'std' => __( 'Center', 'fascat' ),

									'label' => __( 'Image Crop Alignment', 'fascat' ),

									'type' => 'select2',

									'desc' => __( 'Select crop alignment for resized image', 'fascat' ),

									'options' => array(	'c' => 'Center',

														't' => 'Top',

														'b' => 'Bottom',

														'l' => 'Left',

														'r' => 'Right'));

	// TimThumb disabled in the options

	} else {

	

		$woo_metaboxes[] = array (	'name' => '_timthumb-info',

									'label' => __( 'Image', 'fascat' ),

									'type' => 'info',

									'desc' => sprintf( __( '%1$s is disabled. Use the %2$s panel in the sidebar instead, or enable TimThumb in the options panel.', 'fascat' ), '<strong>'.__( 'TimThumb', 'fascat' ).'</strong>', '<strong>'.__( 'Featured Image', 'fascat' ).'</strong>' ) ) ;



	}



	$woo_metaboxes[] = array (  'name'  => 'embed',

					            'std'  => '',

					            'label' => __( 'Embed Code', 'fascat' ),

					            'type' => 'textarea',

					            'desc' => __( 'Enter the video embed code for your video (YouTube, Vimeo or similar)', 'fascat' ) );



} // End post



$woo_metaboxes[] = array (	'name' => '_layout',

							'std' => 'normal',

							'label' => __( 'Layout', 'fascat' ),

							'type' => 'images',

							'desc' => __( 'Select the layout you want on this specific post/page.', 'fascat' ),

							'options' => array(

										'layout-default' => $url . 'layout-off.png',

										'layout-full' => get_template_directory_uri() . '/functions/images/' . '1c.png',

										'layout-left-content' => get_template_directory_uri() . '/functions/images/' . '2cl.png',

										'layout-right-content' => get_template_directory_uri() . '/functions/images/' . '2cr.png'));





// Add extra metaboxes through function

if ( function_exists( 'woo_metaboxes_add' ) )

	$woo_metaboxes = woo_metaboxes_add( $woo_metaboxes );



if ( get_option( 'woo_custom_template' ) != $woo_metaboxes) update_option( 'woo_custom_template', $woo_metaboxes );



} // END woo_options()

} // END function_exists()



// Add options to admin_head

add_action( 'admin_head', 'woo_options' );



//Enable WooSEO on these Post types

$seo_post_types = array( 'post', 'page' );

define( 'SEOPOSTTYPES', serialize( $seo_post_types ));



//Global options setup

add_action( 'init', 'woo_global_options' );

function woo_global_options(){

	// Populate fascat option in array for use in theme

	global $woo_options;

	$woo_options = get_option( 'woo_options' );

}



?>