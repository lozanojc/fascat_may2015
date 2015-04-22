<?php

/**
 * Register all settings needed for the Settings API.
 *
 * @package    SC
 * @subpackage Includes
 * @author     Phil Derksen <pderksen@gmail.com>, Nick Young <mycorpweb@gmail.com>
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


/**
 * Add our add-on settings to the 'Default Settings' tab
 * 
 * @since 2.0.0
 */
function sc_pro_add_settings( $settings ) {
	
	$settings['default']['shipping'] = array(
		'id'   => 'shipping',
		'name' => __( 'Enable Shipping Address', 'sc' ),
		'desc' => __( 'Require the user to enter their shipping address during checkout.', 'sc' ) .
		          '<br><em>' . __( 'When a shipping address is required, the customer is also required to enter a billing address.', 'sc' ) . '</em>',
		'type' => 'checkbox'
	);

	$settings['default']['payment_button_style'] = array(
		'id'      => 'payment_button_style',
		'name'    => __( 'Payment Button Style', 'sc' ),
		'desc'    => __( 'Enable Stripe styles for the main payment button. Base button CSS class: <code>sc-payment-btn</code>.', 'sc' ),
		'type'    => 'radio',
		'std'     => 'stripe',
		'options' => array(
			'none'   => __( 'None', 'sc' ),
			'stripe' => __( 'Stripe', 'sc' )
		)
	);

	$settings['default']['sc_coup_label'] = array(
			'id'   => 'sc_coup_label',
			'name' => __( 'Coupon Input Label', 'sc' ),
			'desc' => __( 'Label to show before the coupon code input.', 'sc' ),
			'type' => 'text',
			'size' => 'regular-text'
		);
	
	$settings['default']['sc_coup_apply_button_style'] = array(
			'id'      => 'sc_coup_apply_button_style',
			'name'    => __( 'Apply Button Style', 'sc' ),
			'desc'    => __( 'Optionally enable Stripe styles for the coupon "Apply" button. Base button CSS class: <code>sc-coup-apply-btn</code>.', 'sc' ),
			'type'    => 'radio',
			'std'     => 'none',
			'options' => array(
				'none'   => __( 'None', 'sc' ),
				'stripe' => __( 'Stripe', 'sc' )
			)
		);
	
	$settings['default']['stripe_total_label'] = array(
			'id'   => 'stripe_total_label',
			'name' => __( 'Stripe Total Label', 'sc' ),
			'desc' => __( 'The default label for the stripe_total shortcode.' , 'sc' ),
			'type' => 'text',
			'size' => 'regular-text'
		);
	
	$settings['default']['sc_uea_label'] = array(
				'id'   => 'sc_uea_label',
				'name' => __( 'Amount Input Label', 'sc' ),
				'desc' => __( 'Label to show before the amount input.', 'sc' ),
				'type' => 'text',
				'size' => 'regular-text'
	);

	return $settings;
}
add_filter( 'sc_settings', 'sc_pro_add_settings' );

