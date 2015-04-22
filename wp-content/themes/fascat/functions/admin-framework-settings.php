<?php
// File Security Check
if ( ! defined( 'ABSPATH' ) ) exit;
?>
<?php
/*-----------------------------------------------------------------------------------*/
/* Framework Settings page - fascat_framework_settings_page */
/*-----------------------------------------------------------------------------------*/

function fascat_framework_settings_page() {
    $manualurl =  get_option( 'woo_manual' );
	$shortname =  'framework_woo';

    //GET themes update RSS feed and do magic
	include_once(ABSPATH . WPINC . '/feed.php' );

	$pos = strpos( $manualurl, 'documentation' );
	$theme_slug = str_replace( "/", '', substr( $manualurl, ( $pos + 13 ) ) ); //13 for the word documentation

    //add filter to make the rss read cache clear every 4 hours
    add_filter( 'wp_feed_cache_transient_lifetime', create_function( '$a', 'return 14400;' ) );

	$framework_options = array();

	$framework_options[] = array( 	'name' => __( 'Admin Settings', 'fascat' ),
									'icon' => 'general',
									'type' => 'heading' );

	$framework_options[] = array( 	'name' => __( 'Super User (username)', 'fascat' ),
									'desc' => sprintf( __( 'Enter your %s to hide the Framework Settings and Update Framework from other users. Can be reset from the %s under %s.', 'fascat' ), '<strong>' . __( 'username', 'fascat' ) . '</strong>', '<a href="' . admin_url( 'options.php' ) . '">' . __( 'WP options page', 'fascat' ) . '</a>', '<code>framework_woo_super_user</code>' ),
									'id' => $shortname . '_super_user',
									'std' => '',
									'class' => 'text',
									'type' => 'text' );

	$framework_options[] = array( 	'name' => __( 'Disable Backup Settings Menu Item', 'fascat' ),
									'desc' => sprintf( __( 'Disable the %s menu item in the theme menu.', 'fascat' ), '<strong>' . __( 'Backup Settings', 'fascat' ) . '</strong>' ),
									'id' => $shortname . '_backupmenu_disable',
									'std' => '',
									'type' => 'checkbox' );
									
	$framework_options[] = array( 	'name' => __( 'WooFramework Update Notification', 'fascat' ),
									'desc' => __( 'This will enable notices on your theme options page that there is an update available for the WooFramework.', 'fascat' ),
									'id' => $shortname . '_framework_version_checker',
									'std' => '',
									'type' => 'checkbox' );

	$framework_options[] = array( 	'name' => __( 'Theme Settings', 'fascat' ),
									'icon' => 'general',
									'type' => 'heading' );

	$framework_options[] = array( 	'name' => __( 'Remove Generator Meta Tags', 'fascat' ),
									'desc' => __( 'This disables the output of generator meta tags in the HEAD section of your site.', 'fascat' ),
									'id' => $shortname . '_disable_generator',
									'std' => '',
									'type' => 'checkbox' );

	$framework_options[] = array( 	'name' => __( 'Image Placeholder', 'fascat' ),
									'desc' => __( 'Set a default image placeholder for your thumbnails. Use this if you want a default image to be shown if you haven\'t added a custom image to your post.', 'fascat' ),
									'id' => $shortname . '_default_image',
									'std' => '',
									'type' => 'upload' );

	$framework_options[] = array( 	'name' => __( 'Disable Shortcodes Stylesheet', 'fascat' ),
									'desc' => __( 'This disables the output of shortcodes.css in the HEAD section of your site.', 'fascat' ),
									'id' => $shortname . '_disable_shortcodes',
									'std' => '',
									'type' => 'checkbox' );

	$framework_options[] = array( 	'name' => __( 'Output "Tracking Code" Option in Header', 'fascat' ),
									'desc' => sprintf( __( 'This will output the %s option in your header instead of the footer of your website.', 'fascat' ), '<strong>' . __( 'Tracking Code', 'fascat' ) . '</strong>' ),
									'id' => $shortname . '_move_tracking_code',
									'std' => 'false',
									'type' => 'checkbox' );

	$framework_options[] = array( 	'name' => __( 'Branding', 'fascat' ),
									'icon' => 'misc',
									'type' => 'heading' );

	$framework_options[] = array( 	'name' => __( 'Options panel header', 'fascat' ),
									'desc' => __( 'Change the header image for the fascat Backend.', 'fascat' ),
									'id' => $shortname . '_backend_header_image',
									'std' => '',
									'type' => 'upload' );

	$framework_options[] = array( 	'name' => __( 'Options panel icon', 'fascat' ),
									'desc' => __( 'Change the icon image for the WordPress backend sidebar.', 'fascat' ),
									'id' => $shortname . '_backend_icon',
									'std' => '',
									'type' => 'upload' );

	$framework_options[] = array( 	'name' => __( 'WordPress login logo', 'fascat' ),
									'desc' => __( 'Change the logo image for the WordPress login page.', 'fascat' ) . '<br /><br />' . __( 'Optimal logo size is 274x63px', 'fascat' ),
									'id' => $shortname . '_custom_login_logo',
									'std' => '',
									'type' => 'upload' );

	$framework_options[] = array( 	'name' => __( 'WordPress login URL', 'fascat' ),
									'desc' => __( 'Change the URL that the logo image on the WordPress login page links to.', 'fascat' ),
									'id' => $shortname . '_custom_login_logo_url',
									'std' => '',
									'class' => 'text',
									'type' => 'text' );
									
	$framework_options[] = array( 	'name' => __( 'WordPress login logo Title', 'fascat' ),
									'desc' => __( 'Change the title of the logo image on the WordPress login page.', 'fascat' ),
									'id' => $shortname . '_custom_login_logo_title',
									'std' => '',
									'class' => 'text',
									'type' => 'text' );

/*
	$framework_options[] = array( 	'name' => __( 'Font Stacks (Beta)', 'fascat' ),
									'icon' => 'typography',
									'type' => 'heading' );

	$framework_options[] = array( 	'name' => __( 'Font Stack Builder', 'fascat' ),
									'desc' => __( 'Use the font stack builder to add your own custom font stacks to your theme.
									To create a new stack, fill in the name and a CSS ready font stack.
									Once you have added a stack you can select it from the font menu on any of the
									Typography settings in your theme options.', 'fascat' ),
									'id' => $shortname . '_font_stack',
									'std' => 'Added Font Stacks',
									'type' => 'string_builder" );
*/

	global $wp_version;

	if ( $wp_version >= '3.1' ) {

	$framework_options[] = array( 	'name' => __( 'WordPress Toolbar', 'fascat' ),
									'icon' => 'header',
									'type' => 'heading' );

	$framework_options[] = array( 	'name' => __( 'Disable WordPress Toolbar', 'fascat' ),
									'desc' => __( 'Disable the WordPress Toolbar.', 'fascat' ),
									'id' => $shortname . '_admin_bar_disable',
									'std' => '',
									'type' => 'checkbox' );

	$framework_options[] = array( 	'name' => __( 'Enable the WooFramework Toolbar enhancements', 'fascat' ),
									'desc' => __( 'Enable several WooFramework-specific enhancements to the WordPress Toolbar, such as custom navigation items for "Theme Options".', 'fascat' ),
									'id' => $shortname . '_admin_bar_enhancements',
									'std' => '',
									'type' => 'checkbox' );

	}


    update_option( 'woo_framework_template', $framework_options );

	?>

    <div class="wrap" id="woo_container">
    <?php do_action( 'wooframework_wooframeworksettings_container_inside' ); ?>
    <div id="woo-popup-save" class="woo-save-popup"><div class="woo-save-save"><?php _e( 'Options Updated', 'fascat' ); ?></div></div>
    <div id="woo-popup-reset" class="woo-save-popup"><div class="woo-save-reset"><?php _e( 'Options Reset', 'fascat' ); ?></div></div>
        <form action='' enctype="multipart/form-data" id="wooform" method="post">
        <?php
	    	// Add nonce for added security.
	    	if ( function_exists( 'wp_nonce_field' ) ) { wp_nonce_field( 'wooframework-framework-options-update' ); } // End IF Statement

	    	$woo_nonce = '';

	    	if ( function_exists( 'wp_create_nonce' ) ) { $woo_nonce = wp_create_nonce( 'wooframework-framework-options-update' ); } // End IF Statement

	    	if ( $woo_nonce == '' ) {} else {

	    ?>
	    	<input type="hidden" name="_ajax_nonce" value="<?php echo $woo_nonce; ?>" />
	    <?php

	    	} // End IF Statement
	    ?>
            <div id="header">
                <div class="logo">
                	Baumhaur
                </div>
                <div class="theme-info">
                	<?php wooframework_display_theme_version_data(); ?>
                </div>
                <div class="clear"></div>
            </div>
            
            <?php $return = fascat_machine( $framework_options ); ?>
            <div id="main">
                <div id="woo-nav">
                    <ul>
                        <?php echo $return[1]; ?>
                    </ul>
                </div>
                <div id="content">
   				<?php echo $return[0]; ?>
                </div>
                <div class="clear"></div>

            </div>
            <div class="save_bar_top">
            <input type="hidden" name="woo_save" value="save" />
            <img style="display:none" src="<?php echo get_template_directory_uri(); ?>/functions/images/loading-bottom.gif" class="ajax-loading-img ajax-loading-img-bottom" alt="<?php esc_attr_e( 'Working...', 'fascat' ); ?>" />
            <input type="submit" value="<?php esc_attr_e( 'Save All Changes', 'fascat' ); ?>" class="button submit-button" />
            </form>

            <form action="<?php echo esc_attr( $_SERVER['REQUEST_URI'] ) ?>" method="post" style="display:inline" id="wooform-reset">
            <?php
		    	// Add nonce for added security.
		    	if ( function_exists( 'wp_nonce_field' ) ) { wp_nonce_field( 'wooframework-framework-options-reset' ); } // End IF Statement

		    	$woo_nonce = '';

		    	if ( function_exists( 'wp_create_nonce' ) ) { $woo_nonce = wp_create_nonce( 'wooframework-framework-options-reset' ); } // End IF Statement

		    	if ( $woo_nonce == '' ) {} else {

		    ?>
		    	<input type="hidden" name="_ajax_nonce" value="<?php echo $woo_nonce; ?>" />
		    <?php

		    	} // End IF Statement
		    ?>
            <span class="submit-footer-reset">
<!--             <input name="reset" type="submit" value="<?php esc_attr_e( 'Reset Options', 'fascat' ); ?>" class="button submit-button reset-button" onclick="return confirm( '<?php esc_attr_e( 'Click OK to reset. Any settings will be lost!', 'fascat' ); ?>' );" /> -->
            <input type="hidden" name="woo_save" value="reset" />
            </span>
        	</form>


            </div>

    <div style="clear:both;"></div>
    </div><!--wrap-->
<?php } ?>