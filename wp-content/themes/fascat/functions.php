

<?php ob_start(); //this is necessary since the last person to work on this must of uploaded alot of files with extra crlfs in the wrong ftp mode

// File Security Check

if ( ! empty( $_SERVER['SCRIPT_FILENAME'] ) && basename( __FILE__ ) == basename( $_SERVER['SCRIPT_FILENAME'] ) ) {

    die ( 'You do not have sufficient permissions to access this page!' );

}

/*-----------------------------------------------------------------------------------*/

/* Start fascat Functions - Please refrain from editing this section */

/*-----------------------------------------------------------------------------------*/



// Define the theme-specific key to be sent to PressTrends.

define( 'WOO_PRESSTRENDS_THEMEKEY', 'zdmv5lp26tfbp7jcwiw51ix9sj389e712' );



// WooFramework init

require_once ( get_template_directory() . '/functions/admin-init.php' );



/*-----------------------------------------------------------------------------------*/

/* Load the theme-specific files, with support for overriding via a child theme.

/*-----------------------------------------------------------------------------------*/



$includes = array(

				'includes/theme-options.php', 			// Options panel settings and custom settings

				'includes/theme-functions.php', 		// Custom theme functions

				'includes/theme-actions.php', 			// Theme actions & user defined hooks

				'includes/theme-comments.php', 			// Custom comments/pingback loop

				'includes/theme-js.php', 				// Load JavaScript via wp_enqueue_script

				'includes/sidebar-init.php', 			// Initialize widgetized areas

				'includes/theme-widgets.php',			// Theme widgets

				'includes/theme-install.php',			// Theme installation

				'includes/theme-woocommerce.php'		// WooCommerce options

				);



// Allow child themes/plugins to add widgets to be loaded.

$includes = apply_filters( 'woo_includes', $includes );



foreach ( $includes as $i ) {

	locate_template( $i, true );

}



/*-----------------------------------------------------------------------------------*/

/* You can add custom functions below */

/*-----------------------------------------------------------------------------------*/



// Define Post Types

add_action( 'init', 'create_post_type' );

function create_post_type() {
    register_post_type( 'athletes', array(
      'labels' => array(
        'name' => __( 'Athletes' ),
        'singular_name' => __( 'Athletes' )
      ),
      'public' => true,
      'supports' => array('title', 'thumbnail', 'editor'),
    ));

    register_post_type( 'careers', array(
      'labels' => array(
        'name' => __( 'Careers' ),
        'singular_name' => __( 'Career' )
      ),
      'public' => true,
	  'supports' => array('title', 'thumbnail'),
      'has_archive' => true
	));

    register_post_type( 'camps', array(
      'labels' => array(
        'name' => __( 'Camps' ),
        'singular_name' => __( 'Camps' )
      ),
      'public' => true,
	  'supports' => array('title', 'thumbnail', 'editor'),
	));

    register_post_type( 'coach', array(
      'labels' => array(
        'name' => __( 'Coach' ),
        'singular_name' => __( 'Coach' )
      ),
      'public' => true,
	  'supports' => array('title', 'thumbnail', 'editor'),
	));

    register_post_type( 'Early-Bird',
      array(
      'labels' => array(
        'name' => __( 'Early-Bird' ),
        'singular_name' => __( 'Early-Bird' )
      ),
      'public' => true,
	  'supports' => array('title', 'thumbnail', 'editor'),
	));

    register_post_type( 'partners', array(
      'labels' => array(
        'name' => __( 'Partners' ),
        'singular_name' => __( 'Partners' )
      ),
      'public' => true,
      'supports' => array('title', 'thumbnail', 'editor'),
    ));

    register_post_type( 'price_plan', array(
      'labels' => array(
        'name' => __( 'Price Plan' ),
        'singular_name' => __( 'Price Plan' )
      ),
      'public' => true,
	  'supports' => array('title', 'thumbnail', 'editor'),
	));

    register_post_type( 'slides', array(
       'labels' => array(
            'name' => __( 'Slides' ),
            'singular_name' => __( 'Slides' )
        ),
        'public' => true,
        'supports' => array('title'),
	));

    register_post_type( 'testimonials', array(
        'labels' => array(
        'name' => __( 'Testimonials' ),
        'singular_name' => __( 'Testimonials' )
      ),
      'public' => true,
	  'supports' => array('title', 'editor'),
	));

    register_post_type( 'tips', array(
      'labels' => array(
        'name' => __( 'Tips' ),
        'singular_name' => __( 'Tips' )
      ),
      'public' => true,
	  'supports' => array('title', 'thumbnail', 'editor', 'comments', 'author'),
	));


register_taxonomy_for_object_type( 'category', 'tips' );
/*		  register_post_type( 'ecommerce_landing',

    array(

      'labels' => array(

        'name' => __( 'ecommerce_landing' ),

        'singular_name' => __( 'ecommerce_landing' )

      ),

      'public' => true,

	  'supports' => array('title', 'thumbnail', 'editor'),

	)

    );*/

    register_taxonomy('program', 'coach', array(
        'public'                => false,
		'hierarchical'          => true,
		'labels'                => array(
            'name'                       => _x( 'Programs', 'taxonomy general name' ),
            'singular_name'              => _x( 'Program', 'taxonomy singular name' ),
            'search_items'               => __( 'Search Programs' ),
            'popular_items'              => __( 'Popular Programs' ),
            'all_items'                  => __( 'All Programs' ),
            'edit_item'                  => __( 'Edit Program' ),
            'update_item'                => __( 'Update Program' ),
            'add_new_item'               => __( 'Add New Program' ),
            'new_item_name'              => __( 'New Program Name' ),
            'separate_items_with_commas' => __( 'Separate programs with commas' ),
            'add_or_remove_items'        => __( 'Add or remove programs' ),
            'choose_from_most_used'      => __( 'Choose from the most used programs' ),
            'not_found'                  => __( 'No Programs found.' ),
            'menu_name'                  => __( 'Programs' ),
        ),
		'show_ui'               => true,
		'show_admin_column'     => true,
		'update_count_callback' => '_update_post_term_count',
		'query_var'             => true,
		'rewrite'               => array( 'slug' => 'program' ),
	));
    flush_rewrite_rules();
}

/*used to redirect after add to cart*/
/*add_filter ('add_to_cart_redirect', 'redirect_to_checkout');
function redirect_to_checkout() {
    global $woocommerce;
    $checkout_url = $woocommerce->cart->get_checkout_url();
    return $checkout_url;
}*/
/*-----------------------------------------------------------------------------------*/

/* Don't add any code below here or the sky will fall down */

/*-----------------------------------------------------------------------------------*/
ob_flush();

class FascatNavWalker extends Walker_Nav_Menu {

	// function start_lvl( &$output, $depth = 0, $args = array() ) {
	// 	$indent = str_repeat("\t", $depth);
	// 	$output .= "\n$indent" . '<ul class="sub-menu"><li class="menu-item" style="text-align:center"><a href="' . FasCat::getShopUrl() . '"><i class="fa fa-chevron-circle-right fa-2x"></i> Products </a> ' . $level . ' ' .  "</li>\n";//print_r($args, true) .
	// }

	/**
	 * Ends the list of after the elements are added.
	 *
	 * @see Walker::end_lvl()
	 *
	 * @since 3.0.0
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param int    $depth  Depth of menu item. Used for padding.
	 * @param array  $args   An array of arguments. @see wp_nav_menu()
	 */
	// function end_lvl( &$output, $depth = 0, $args = array() ) {
	// 	$indent = str_repeat("\t", $depth);
	// 	$output .= "$indent</ul>\n";
	// }

	/**
	 * Start the element output.
	 *
	 * @see Walker::start_el()
	 *
	 * @since 3.0.0
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param object $item   Menu item data object.
	 * @param int    $depth  Depth of menu item. Used for padding.
	 * @param array  $args   An array of arguments. @see wp_nav_menu()
	 * @param int    $id     Current item ID.
	 */
	function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
		$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

		$class_names = '';

		$classes = empty( $item->classes ) ? array() : (array) $item->classes;
		$classes[] = 'menu-item-' . $item->ID;

		/**
		 * Filter the CSS class(es) applied to a menu item's <li>.
		 *
		 * @since 3.0.0
		 *
		 * @see wp_nav_menu()
		 *
		 * @param array  $classes The CSS classes that are applied to the menu item's <li>.
		 * @param object $item    The current menu item.
		 * @param array  $args    An array of wp_nav_menu() arguments.
		 */
		$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );
		$class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

		/**
		 * Filter the ID applied to a menu item's <li>.
		 *
		 * @since 3.0.1
		 *
		 * @see wp_nav_menu()
		 *
		 * @param string $menu_id The ID that is applied to the menu item's <li>.
		 * @param object $item    The current menu item.
		 * @param array  $args    An array of wp_nav_menu() arguments.
		 */
		$id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args );
		$id = $id ? ' id="' . esc_attr( $id ) . '"' : '';

		$output .= $indent . '<li' . $id . $class_names .'>';

		$atts = array();
		$atts['title']  = ! empty( $item->attr_title ) ? $item->attr_title : '';
		$atts['target'] = ! empty( $item->target )     ? $item->target     : '';
		$atts['rel']    = ! empty( $item->xfn )        ? $item->xfn        : '';
		$atts['href']   = ! empty( $item->url )        ? $item->url        : '';

		/**
		 * Filter the HTML attributes applied to a menu item's <a>.
		 *
		 * @since 3.6.0
		 *
		 * @see wp_nav_menu()
		 *
		 * @param array $atts {
		 *     The HTML attributes applied to the menu item's <a>, empty strings are ignored.
		 *
		 *     @type string $title  Title attribute.
		 *     @type string $target Target attribute.
		 *     @type string $rel    The rel attribute.
		 *     @type string $href   The href attribute.
		 * }
		 * @param object $item The current menu item.
		 * @param array  $args An array of wp_nav_menu() arguments.
		 */
		$atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args );

		$attributes = '';
		foreach ( $atts as $attr => $value ) {
			if ( ! empty( $value ) ) {
				$value = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
				$attributes .= ' ' . $attr . '="' . $value . '"';
			}
		}

		$item_output = $args->before;
		$item_output .= '<a'. $attributes .'>';
		/** This filter is documented in wp-includes/post-template.php */
		$item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
		$item_output .= '</a>';
		$item_output .= $args->after;

		/**
		 * Filter a menu item's starting output.
		 *
		 * The menu item's starting output only includes $args->before, the opening <a>,
		 * the menu item's title, the closing </a>, and $args->after. Currently, there is
		 * no filter for modifying the opening and closing <li> for a menu item.
		 *
		 * @since 3.0.0
		 *
		 * @see wp_nav_menu()
		 *
		 * @param string $item_output The menu item's starting HTML output.
		 * @param object $item        Menu item data object.
		 * @param int    $depth       Depth of menu item. Used for padding.
		 * @param array  $args        An array of wp_nav_menu() arguments.
		 */
		$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
	}

	/**
	 * Ends the element output, if needed.
	 *
	 * @see Walker::end_el()
	 *
	 * @since 3.0.0
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param object $item   Page data object. Not used.
	 * @param int    $depth  Depth of page. Not Used.
	 * @param array  $args   An array of arguments. @see wp_nav_menu()
	 */
	function end_el( &$output, $item, $depth = 0, $args = array() ) {
		$output .= "</li>\n";
	}

} // Walker_Nav_Menu

class FasCat
{
    protected static $isSale;
    protected static $brands = array();
    protected static $productTerms = array();
    protected static $coachingProducts = array();
    protected static $categoryBase;
    protected static $categoryUrl;
    protected static $siteUrl;
    protected static $attachments = array();
    protected static $required = array('name', 'email', 'account', 'city', 'phone_number', 'age', 'chosen_coach');
    protected static $fieldValues;
    protected static $errorField;
    protected static $coachingData = array();
    protected static $navWalker;
    protected static $shopUrl;
    const WC_SLIDER_ID = 1316;

    public static function getNavWalker(){
        return isset(self::$navWalker) ? self::$navWalker : self::$navWalker = new FascatNavWalker();
    }

    public static function getShopUrl(){
        return isset(self::$shopUrl) ? self::$shopUrl : self::$shopUrl = get_permalink(woocommerce_get_page_id('shop'));
    }

    public static function getRecentProducts($limit = 3){
        $args = array(
    		'posts_per_page' => $limit,
    		'post_status' 	 => 'publish',
    		'post_type' 	 => 'product',
            'fields' => 'ids'
        );
        $posts = get_posts($args);
        if(empty($posts)){
            return false;
        }
        return array_map('FasCat::mapProduct', $posts);
    }

    public static function mapProduct($id){
        $product = get_product($id);
        $product->thumbUrl = FasCat::getProductThumb($id);
        return $product;
    }

    public static function getProductThumb($id,  $size = 'shop_catalog'){
        //function woocommerce_get_product_thumbnail(, $placeholder_width = 0, $placeholder_height = 0  ) {
		if(false !== ($thumbId = get_post_thumbnail_id($id)) && false !== ($img = wp_get_attachment_image_src($thumbId, $size))){
            return $img[0];
        }
		if(woocommerce_placeholder_img_src()){
			return woocommerce_placeholder_img($size);
        }
    }

    public static function shopRedirect(){
        if(is_page('ecommerce_landing')){
            wp_redirect(get_permalink(woocommerce_get_page_id( 'shop' )), 302);
            exit();
        }
    }

    public static function checkSale($price){
        //throw new RuntimeException('Booya!');
        global $product;
        var_dump($price);
        return $product->is_on_sale() ? 'On Sale' : 'No Sale';
    }

    public static function getTerms($id, $taxonomy = 'product_cat'){
        if(isset(self::$productTerms[$id])){
            return self::$productTerms[$id];
        }
        $terms = wp_get_object_terms($id, $taxonomy);
        if(empty($terms) || is_wp_error($terms)){
            return self::$productTerms[$id] = false;
        }
        return self::$productTerms[$id] = $terms;
    }

    public static function getBrand($id){
        if(isset(self::$brands[$id])){
            return self::$brands[$id];
        }
        if(false === $terms = self::getTerms($id)){
            return self::$brands[$id] = false;
        }
        $term = current($terms);//assume the brand is the first category set
        $term->link = self::getCategoryUrl() . '/' . $term->slug . '/';
        if('Classes' === $term->name){
            $term->name = 'Fascat Classes';
        }
        return self::$brands[$id] = $term;
    }

    public static function isCoaching($id){
        if(isset(self::$coachingProducts[$id])){
            return self::$coachingProducts[$id];
        }
        if(false === ($terms = self::getTerms($id))){
            return self::$coachingProducts[$id] = false;
        }
        $terms = array_filter($terms, 'FasCat::filterCoaching');
        return self::$coachingProducts[$id] = !empty($terms);
    }

    public static function filterCoaching($term){
        return 'coaching' === $term->slug;
    }

    public static function getCategoryBase(){
        if(!isset(self::$categoryBase)){
            self::$categoryBase = false !== ($option = get_option('woocommerce_permalinks')) && !empty($option['category_base']) ? $option['category_base'] : 'product-category'; 
        }
        return self::$categoryBase;
    }

    public function getCategoryUrl(){
        if(!isset(self::$categoryUrl)){
            self::$categoryUrl = self::getSiteUrl() . '/' . self::getCategoryBase();
        }
        return self::$categoryUrl;
    }

    public static function getSiteUrl(){
        if(!isset(self::$siteUrl)){
            self::$siteUrl = site_url();
        }
        return self::$siteUrl;
    }

    public static function cartText(){
        return 'Add <i class="fa fa-shopping-cart"></i>';
    }

    public static function checkoutText(){
        return 'Pay';
    }

    public static function loadScripts(){
        wp_enqueue_script('imagesloaded', ($uri = get_template_directory_uri()) . '/js/imagesloaded.pkgd.min.js');
        wp_enqueue_script('masonry-pkgd', '//cdnjs.cloudflare.com/ajax/libs/masonry/3.1.5/masonry.pkgd.min.js', array('jquery'), '3.1.5');
        
        // wp_enqueue_script('add-to-cart-variation', plugins_url() . '/woocommerce/assets/js/frontend/add-to-cart-variation.js',array('jquery'),'1.0',true);
        
        
        //wp_enqueue_style('woocommerce', WC()->plugin_url() . '/assets/css/woocommerce.css');
        if(($isProduct = is_product()) || is_cart()){
            if($isProduct){
                wp_enqueue_script('product-fields', $uri . '/js/product-fields.js', array('jquery'));
            }
            wp_enqueue_script('wc-chosen', WC()->plugin_url() . '/assets/js/frontend/chosen-frontend' . (defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min')  . '.js', array( 'chosen' ), WC_VERSION);
            wp_enqueue_style('woocommerce_chosen_styles', WC()->plugin_url() . '/assets/css/chosen.css' );
        }
        if(($hasValues = isset(self::$fieldValues)) || ($hasError = isset(self::$errorField))){
            $values = array('vals' => $hasValues ? self::$fieldValues : array());
            if($hasError){
                $values['error'] = self::$errorField;
            }
            wp_localize_script('product-fields', 'fsVals', $values);
        }
    }

    public static function getExcerptLength($length){
        return 10;
    }

    public static function getHeaderExcerptLength($length){
        return 20;
    }

    public static function checkoutCartName($name, $cart_item, $cart_item_key){
        //if(!is_product()){removed filter from mini-cart.php so this only for checkout
            return $cart_item['data']->get_image() . $name;
        //}
        return $name;
    }

    public static function getAllImages($product){
        if(false === ($id = get_post_thumbnail_id($product->id))){
            return false;
        }
        $shop = wp_get_attachment_image_src($id, 'shop_single');
        $full = wp_get_attachment_image_src($id, 'large');
        $value = array(
            'shop' => false === $shop ? false : $shop[0],
            'full' => false === $full ? false : $full[0]
        );
        if(false === ($attachments = self::getAttachments($product))){
            return array($id  => $value);
        }
        $attachments[$id] = $value;
        return $attachments;
    }

    public static function getAttachments($product){
        if(isset(self::$attachments[$product->id])){
            return self::$attachments[$product->id];
        }
        $attachments = $product->get_gallery_attachment_ids();
        if(empty($attachments)){
            return self::$attachments[$product->id] = false;
        }
        $value = array();
        foreach($attachments as $id){
            $shop = wp_get_attachment_image_src($id, 'shop_single');
            $full = wp_get_attachment_image_src($id, 'large');
            $value[$id] = array(
                'shop' => false === $shop ? false : $shop[0],
                'full' => false === $full ? false : $full[0]
            );
        }
        return self::$attachments[$product->id] = $value;
    }

    public static function validateCoachingProduct($valid, $product_id, $quantity, $variation_id = null, $variations = null){
        if(!self::isCoaching($product_id)){
            return $valid;
        }
        //filter all fields
        foreach($_POST as $k => $v){
            $_POST[$k] = wp_kses(stripslashes($v), 'strip');
        }
        foreach(self::$required as $fieldName){
            if(empty($_POST[$fieldName])){
                self::setFormValues();
                self::$errorField = $fieldName;
                wc_add_notice('Please enter your ' . ucwords(str_replace('_', ' ', $fieldName)), 'error');
                return false;
            }
        }
        self::setFormValues();
        return $valid;
    }

    public static function setFormValues(){
        self::$fieldValues = array();
        foreach($_POST as $k => $v){
            if(0 === strpos($k, 'attribute')){//starts the wc form
                break;
            }
            if(!empty($v)){
                self::$fieldValues[$k] = $v;
            }
        }
        if(empty(self::$fieldValues)){
            self::$fieldValues = null;
        }
    }

    public static function addCoachingData($cart_item_meta, $product_id){
        if(!self::isCoaching($product_id) || !isset(self::$fieldValues) || isset($cart_item_meta['_coaching_data'])){
            return $cart_item_meta;
        }
        $cart_item_meta['_coaching_data'] = self::$fieldValues;
        return $cart_item_meta;
    }

    public static function addSessionData($cart_item, $values, $key){
        if(isset($values['_coaching_data'])){//value data to cart item, otherwise lost on the next session save
            $cart_item['_coaching_data'] = $values['_coaching_data'];
        }
        return $cart_item;
    }

    public static function setOrderItemMeta($item_id, $cart_item){
        if(!isset($cart_item['_coaching_data'])){
            return;
        }
        woocommerce_add_order_item_meta($item_id, '_coaching_data', $cart_item['_coaching_data'], true);
    }

    public static function loadPost(){
        global $theorder, $post;
        if(isset($post)){
            if('shop_order' !== $post->post_type){
                return;
            }
            $postId = $post->ID;
        }
        elseif(isset($_GET['post'])){
            $postId = $_GET['post'];
        }
        else{
            return;
        }
        $order = empty($theorder) || !is_object($theorder) ? ($theorder = new WC_Order($postId)) : $theorder;
        if(null === $order->id){
            return;
        }
        $hasCoach = false;
        foreach($order->get_items() as $id => $item){
            if(isset($item['coaching_data'])){
                self::$coachingData[$id] = unserialize($item['coaching_data']);
                self::$coachingData[$id]['package_name'] = $item['name'];
                $hasCoach = true;
            }
        }
        if($hasCoach){
            add_meta_box('coachn-menu', 'Coaching Package Details' , 'FasCat::showInfoPanel', 'shop_order', 'normal', 'high');
        }
    }

    public static function showInfoPanel(){
        /*global $post, $theorder;
        $order = empty($theorder) || !is_object($theorder) ? ($theorder = new WC_Order($post->ID)) : $theorder;*/
        foreach(self::$coachingData as $data){
            echo '<h4>' . $data['package_name'] . '</h4><ul>';
            unset($data['package_name']);
            foreach($data as $k => $v){
                echo '<li><strong>' . ucwords(str_replace('_', ' ', $k)) . '</strong>: ' . $v . '</li>';
            }
            echo '</ul>';
        }
    }

    public static function getCoaches($term){
        $coaches = get_posts(array('post_type' => 'coach', 'post_status' => 'publish', 'posts_per_page' => 3,
            'tax_query' => array(
                array(
                    'taxonomy' => 'program',
                    'field' => 'slug',
                    'terms' => array($term),
                    'operator' => 'IN'
                )
            )
        ));
        return $coaches;
    }

    public static function getThumbUrl($post){
        return false === ($id = get_post_thumbnail_id($post->ID)) || false === ($url = wp_get_attachment_image_src($id)) ? false : $url[0];
    }

    public static function adminScripts($context){
        //var_dump($context);
        if('edit-tags.php' === $context && isset($_GET['taxonomy']) && 'program' === $_GET['taxonomy']){
            wp_enqueue_script('fascat-admin', get_template_directory_uri() . '/js/admin.js', array('jquery'));
        
        }
        elseif('post.php' !== $context){
            wp_enqueue_style('fascat-admin', get_template_directory_uri() . '/css/admin.css');
        }
    }

    public static function registerTaxonomy(){
        if(taxonomy_exists('product_featured')){
			return;
        }
        $labels = array(
            'name'                       => 'Featured',
            'singular_name'              => 'Featured',
            'search_items'               => 'Search Featured',
            'popular_items'              => 'Popular Featured',
            'all_items'                  => 'All Featured',
            'parent_item'                => null,
            'parent_item_colon'          => null,
            'edit_item'                  => 'Edit Featured',
            'update_item'                => 'Update Featured',
            'add_new_item'               => 'Add New Featured',
            'new_item_name'              => 'New City Featured',
            'separate_items_with_commas' => 'Separate featured with commas',
            'add_or_remove_items'        => 'Add or remove featured',
            'choose_from_most_used'      => 'Choose from the most used featured',
            'not_found'                  => 'No featured found',
            'menu_name'                  => 'Featured'
        );
        register_taxonomy('product_featured', 'product',
            array(
                'public'                => false,
                'hierarchical'          => true,
                'labels'                => $labels,
                'show_ui'               => true,
                'show_admin_column'     => true,
                'show_in_nav_menus'     => false,
                'show_tagcloud'         => false
            )
        );
        register_taxonomy_for_object_type('product_featured', 'product');
    }

    public static function sideMenu($items, $args){
        return '<li><a href="#">Hello World</a></li>' . $items;
        echo "\nItems";
        var_dump($items);
        echo "\nArgs";
        var_dump($args);
    }

    public static function startEle($item_output, $item, $depth, $args){
        //return 'Hello Item</li><li>' . $item_output;
        echo "\neleout";
        var_dump($item_output);
        /*echo "\nitem";
        var_dump($item);
        echo "\ndepth";
        var_dump($depth);*/
    }
}
add_filter('woocommerce_product_single_add_to_cart_text', 'FasCat::cartText', 11);
add_filter('woocommerce_order_button_text', 'FasCat::checkoutText', 11);
//redirect ecommerce landing to shop to avoid dupe contente
add_action('template_redirect', 'FasCat::shopRedirect', 11);
add_action('wp_enqueue_scripts', 'FasCat::loadScripts', 111);
add_filter('woocommerce_cart_item_name', 'FasCat::checkoutCartName', 11, 3);
//add_filter('woocommerce_get_price_html', 'FasCat::checkSale', 111);
//coaching products and cf7 form
add_filter('woocommerce_add_to_cart_validation', 'FasCat::validateCoachingProduct', 11, 5); 
add_filter('woocommerce_add_cart_item_data', 'FasCat::addCoachingData', 11, 5); 
add_filter('woocommerce_get_cart_item_from_session', 'FasCat::addSessionData', 11, 3);
add_action('woocommerce_add_order_item_meta', 'FasCat::setOrderItemMeta', 11, 2);
//coaching order admin
add_action('load-post.php', 'FasCat::loadPost');
//admin tags add css to hide adding parent to terms
add_action('admin_enqueue_scripts', 'FasCat::adminScripts', 111);
//custom taxonomy for featured products on ecommerce landing (shop) page
add_action('init', 'FasCat::registerTaxonomy', 11);
//menu
//add_filter('wp_nav_menu_items', 'FasCat::sideMenu', 11, 2);
//add_filter('walker_nav_menu_start_el', 'FasCat::startEle', 11, 4);


//addding menu for the tips page to have a categories  dropdown
function register_menu2() {
    register_nav_menu('tips-menu', __('Tips Menu'));
}
add_action('init', 'register_menu2');


// redirect searches on the tips page back to the tips template
// function template_chooser($template)   
// {    
//   global $wp_query;   
//   $post_type = get_query_var('post_type');   
//   if( $wp_query->is_archive && $post_type == 'tips' )   
//   {
//     return locate_template('tips.php');  //  redirect to template-home.php
//   }   
//   return $template;   
// }
// add_filter('template_include', 'template_chooser');  





/* invisible window added */
add_image_size( 'single-thumb', 320 ); // 300 pixels wide (and unlimited height)



function the_post_thumbnail_caption() {
  global $post;

  $thumb_id = get_post_thumbnail_id($post->id);

  $args = array(
	'post_type' => 'attachment',
	'post_status' => null,
	'post_parent' => $post->ID,
	'include'  => $thumb_id
	); 

   $thumbnail_image = get_posts($args);

   if ($thumbnail_image && isset($thumbnail_image[0])) {
     //show thumbnail title
     //echo $thumbnail_image[0]->post_title; 

     //Uncomment to show the thumbnail caption
     echo '<div class="f_caption"><h3>'.$thumbnail_image[0]->post_excerpt.'</h3></div>';

     //Uncomment to show the thumbnail description
     //echo $thumbnail_image[0]->post_content; 

     //Uncomment to show the thumbnail alt field
     //$alt = get_post_meta($thumbnail_id, '_wp_attachment_image_alt', true);
     //if(count($alt)) echo $alt;
  }
}




