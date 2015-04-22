<?php
/**
 * Allow for payment dates to be synchronised to a specific day of the week, month or year.
 *
 * @package		WooCommerce Subscriptions
 * @subpackage	WC_Subscriptions_Sync
 * @category	Class
 * @author		Brent Shepherd
 * @since		1.5
 */
class WC_Subscriptions_Synchroniser {

	public static $setting_id;

	public static $post_meta_key       = '_subscription_payment_sync_date';
	public static $post_meta_key_day   = '_subscription_payment_sync_date_day';
	public static $post_meta_key_month = '_subscription_payment_sync_date_month';

	public static $sync_field_label;
	public static $sync_description;
	public static $sync_description_year;

	public static $billing_period_ranges;

	/**
	 * Bootstraps the class and hooks required actions & filters.
	 *
	 * @since 1.5
	 */
	public static function init() {

		self::$setting_id = WC_Subscriptions_Admin::$option_prefix . '_sync_payments';

		self::$sync_field_label      = __( 'Synchronise Renewals', 'woocommerce-subscriptions' );
		self::$sync_description      = __( 'Align the payment date for all customers who purchase this subscription to a specific day of the week or month.', 'woocommerce-subscriptions' );
		self::$sync_description_year = sprintf( __( 'Align the payment date for this subscription to a specific day of the year. If the date has already taken place this year, the first payment will be processed in %s. Set the day to 0 to disable payment syncing for this product.', 'woocommerce-subscriptions' ), date( 'Y', strtotime( '+1 year' ) ) );

		// Add the settings to control whether syncing is enabled and how it will behave
		add_filter( 'woocommerce_subscription_settings', __CLASS__ . '::add_settings' );

		// When enabled, add the sync selection fields to the Edit Product screen
		add_action( 'woocommerce_subscriptions_product_options_pricing', __CLASS__ . '::subscription_product_fields' );
		add_action( 'woocommerce_variable_subscription_pricing', __CLASS__ . '::variable_subscription_product_fields', 10, 3 );

		// Add the translated fields to the Subscriptions admin script
		add_filter( 'woocommerce_subscriptions_admin_script_parameters', __CLASS__ . '::admin_script_parameters', 10 );

		// Save sync options when a subscription product is saved
		add_action( 'woocommerce_process_product_meta_subscription', __CLASS__ . '::save_subscription_meta', 10 );

		// Save sync options when a variable subscription product is saved
		add_action( 'woocommerce_process_product_meta_variable-subscription', __CLASS__ . '::process_product_meta_variable_subscription' );

		// Make sure the expiration date is calculated from the synced start date
		add_filter( 'woocommerce_subscriptions_product_expiration_date', __CLASS__ . '::recalculate_product_expiration_date', 10, 3 );

		// Display a product's first payment date on the product's page to make sure it's obvious to the customer when payments will start
		add_action( 'woocommerce_single_product_summary', __CLASS__ . '::products_first_payment_date', 31 );

		// Display the "First Payment:" date on cart/checkout
		add_filter( 'woocommerce_cart_total_ex_tax', __CLASS__ . '::customise_subscription_price_string', 12 );
		add_filter( 'woocommerce_cart_total', __CLASS__ . '::customise_subscription_price_string', 12 );

		// Maybe mock a free trial on the product for calculating order totals
		add_filter( 'woocommerce_calculated_total', __CLASS__ . '::maybe_set_free_trial', 0, 1 );
		add_filter( 'woocommerce_calculated_total', __CLASS__ . '::maybe_unset_free_trial', 10000, 1 );

		// But don't display the free trial in cart subscription price strings unless the product actually has free trial
		add_filter( 'woocommerce_cart_subscription_string_details', __CLASS__ . '::maybe_hide_free_trial', 11, 4 );

		// When creating an order, add meta if it's for syncing a subscription
		add_action( 'woocommerce_checkout_update_order_meta', __CLASS__ . '::add_order_meta', 10, 2 );

		// Make sure the first payment date for a new subscription is correct
		add_filter( 'woocommerce_subscriptions_calculated_next_payment_date', __CLASS__ . '::get_first_payment_date', 15, 4 );

		// Make sure the sign-up fee for a synchronised subscription is correct
		add_filter( 'woocommerce_subscriptions_sign_up_fee', __CLASS__ . '::get_sign_up_fee', 1, 4 );
	}

	/**
	 * Check if payment syncing is enabled on the store.
	 *
	 * @since 1.5
	 */
	public static function is_syncing_enabled() {
		return ( 'yes' == get_option( self::$setting_id, false ) ) ? true : false;
	}

	/**
	 * Check if the cart includes a subscription that needs to be synced.
	 *
	 * @return bool Returns true if any item in the cart is a subscription sync request, otherwise, false.
	 * @since 1.5
	 */
	public static function cart_contains_synced_subscription() {
		global $woocommerce;

		$cart_contains_synced_subscription = false;

		if ( isset( $woocommerce->cart ) ) {
			foreach ( $woocommerce->cart->get_cart() as $cart_item_key => $cart_item ) {
				if ( ( ! is_array( $cart_item['data']->subscription_payment_sync_date ) && $cart_item['data']->subscription_payment_sync_date > 0 ) || ( is_array( $cart_item['data']->subscription_payment_sync_date ) && $cart_item['data']->subscription_payment_sync_date['day'] > 0 ) ) {
					$cart_contains_synced_subscription = $cart_item;
					break;
				}
			}
		}

		return $cart_contains_synced_subscription;
	}

	/**
	 * Check if a given order included a subscription that is synced to a certain day.
	 *
	 * @param int $order_id The ID or a WC_Order item to check.
	 * @return bool Returns true if the order contains a synced subscription, otherwise, false.
	 * @since 1.5
	 */
	public static function order_contains_synced_subscription( $order_id ) {

		if ( is_object( $order_id ) ) {
			$order_id = $order_id->id;
		}

		return ( 'true' == get_post_meta( $order_id, '_order_contains_synced_subscription', true ) ) ? true : false;
	}

	/**
	 * Add sync settings to the Subscription's settings page.
	 *
	 * @since 1.5
	 */
	public static function add_settings( $settings ) {

		// Get the index of the index of the 
		foreach ( $settings as $i => $setting ) {
			if ( 'sectionend' == $setting['type'] && 'woocommerce_subscriptions_miscellaneous' == $setting['id'] ) {
				$index = $i;
				break;
			}
		}

		array_splice( $settings, $index, 0, array(
			array(
				'name'          => __( 'Synchronise Renewals', 'woocommerce-subscriptions' ),
				'desc'          => sprintf( __( 'Align subscription renewal to a specific day of the week, month or year. %sLearn more%s.', 'woocommerce-subscriptions' ), '<a href="' . esc_url( 'http://docs.woothemes.com/document/subscriptions/renewal-synchronisation/' ) . '">', '</a>' ),
				'id'            => self::$setting_id,
				'default'       => 'no',
				'checkboxgroup' => 'start',
				'type'          => 'checkbox',
				'desc_tip'      => __( 'For example, process all payments for a weekly subscription on Sundays, or process all payments for a monthly subscription on the 1st of the month.', 'woocommerce-subscriptions' ),
			),
		));

		return $settings;
	}

	/**
	 * Add the sync setting fields to the Edit Product screen
	 *
	 * @since 1.5
	 */
	public static function subscription_product_fields() {
		global $post, $wp_locale, $woocommerce;

		if ( self::is_syncing_enabled() ) {

			// Set month as the default billing period
			if ( ! $subscription_period = get_post_meta( $post->ID, '_subscription_period', true ) ) {
			 	$subscription_period = 'month';
			}

			// Determine whether to display the week/month sync fields or the annual sync fields
			$display_week_month_select = ( ! in_array( $subscription_period, array( 'month', 'week' ) ) ) ? ' style="display: none;"' : '';
			$display_annual_select     = ( 'year' != $subscription_period ) ? ' style="display: none;"' : '';

			$payment_day = self::get_products_payment_day( $post->ID );

			// An annual sync date is already set in the form: array( 'day' => 'nn', 'month' => 'nn' ), create a MySQL string from those values (year and time are irrelvent as they are ignored)
			if ( is_array( $payment_day ) ) {
				$payment_month = $payment_day['month'];
				$payment_day   = $payment_day['day'];
			} else {
				$payment_month = date( 'm' );
			}

			echo '<div class="options_group subscription_pricing subscription_sync show_if_subscription">';
			echo '<div class="subscription_sync_week_month"' . $display_week_month_select . '>';

			woocommerce_wp_select( array(
				'id'          => self::$post_meta_key,
				'class'       => 'wc_input_subscription_payment_sync',
				'label'       => self::$sync_field_label . ':',
				'options'     => self::get_billing_period_ranges( $subscription_period ),
				'description' => self::$sync_description,
				'desc_tip'    => true,
				'value'       => $payment_day, // Explicity set value in to ensure backward compatibility
				)
			);

			echo '</div>';

			echo '<div class="subscription_sync_annual"' . $display_annual_select . '>';

			woocommerce_wp_text_input( array(
				'id'            => self::$post_meta_key_day,
				'class'         => 'wc_input_subscription_payment_sync',
				'label'         => self::$sync_field_label . ':',
				'placeholder'   => __( 'Day', 'woocommerce-subscriptions' ),
				'value'         => $payment_day,
				)
			);

			woocommerce_wp_select( array(
				'id'          => self::$post_meta_key_month,
				'class'       => 'wc_input_subscription_payment_sync',
				'label'       => '',
				'options'     => $wp_locale->month,
				'description' => self::$sync_description_year,
				'desc_tip'    => true,
				'value'       => $payment_month, // Explicity set value in to ensure backward compatibility
				)
			);

			echo '</div>';
			echo '</div>';

		}
	}

	/**
	 * Add the sync setting fields to the variation section of the Edit Product screen
	 *
	 * @since 1.5
	 */
	public static function variable_subscription_product_fields( $loop, $variation_data, $variation ) {
		global $wp_locale;

		if ( self::is_syncing_enabled() ) :

			// Set month as the default billing period
			if ( ! $subscription_period = get_post_meta( $variation->ID, '_subscription_period', true ) ) {
				$subscription_period = 'month';
			}

			$display_week_month_select = ( ! in_array( $subscription_period, array( 'month', 'week' ) ) ) ? ' style="display: none;"' : '';
			$display_annual_select     = ( 'year' != $subscription_period ) ? ' style="display: none;"' : '';

			$payment_day = self::get_products_payment_day( $variation->ID );

			// An annual sync date is already set in the form: array( 'day' => 'nn', 'month' => 'nn' ), create a MySQL string from those values (year and time are irrelvent as they are ignored)
			if ( is_array( $payment_day ) ) {
				$payment_month = $payment_day['month'];
				$payment_day   = $payment_day['day'];
			} else {
				$payment_month = date( 'm' );
			}
?>
<tr class="variable_subscription_sync show_if_variable-subscription">
	<td colspan="1" class="subscription_sync_week_month"<?php echo $display_week_month_select; ?>>
		<label><?php _e( 'Synchronise Renewals', 'woocommerce-subscriptions' ); ?></label>
<?php	woocommerce_wp_select( array(
			'id'            => 'variable' . self::$post_meta_key . '[' . $loop . ']',
			'class'         => 'wc_input_subscription_payment_sync',
			'wrapper_class' => '_subscription_payment_sync_field',
			'label'         => self::$sync_field_label,
			'options'       => self::get_billing_period_ranges( $subscription_period ),
			'description'   => self::$sync_description,
			'desc_tip'      => true,
			'value'         => $payment_day,
			)
		);?>
	</td>
	<td colspan="1" class="subscription_sync_annual"<?php echo $display_annual_select; ?>>
		<label><?php _e( 'Synchronise Renewals', 'woocommerce-subscriptions' ); ?></label>
<?php
		woocommerce_wp_text_input( array(
			'id'            => 'variable' . self::$post_meta_key_day . '[' . $loop . ']',
			'class'         => 'wc_input_subscription_payment_sync',
			'wrapper_class' => '_subscription_payment_sync_field',
			'label'         => self::$sync_field_label,
			'placeholder'   => __( 'Day', 'woocommerce-subscriptions' ),
			'value'         => $payment_day,
			'custom_attributes' => array(
					'step' => '1',
					'min'  => '0',
					'max'  => '31',
				)
			)
		);

		woocommerce_wp_select( array(
			'id'            => 'variable' . self::$post_meta_key_month . '[' . $loop . ']',
			'class'         => 'wc_input_subscription_payment_sync',
			'wrapper_class' => '_subscription_payment_sync_field',
			'label'         => '',
			'options'       => $wp_locale->month,
			'description'   => self::$sync_description_year,
			'desc_tip'      => true,
			'value'         => $payment_month, // Explicity set value in to ensure backward compatibility
			)
		);
		?>
	</td>
</tr>

<?php 	endif;
	}

	/**
	 * Save sync options when a subscription product is saved
	 *
	 * @since 1.5
	 */
	public static function save_subscription_meta( $post_id ) {

		// Set month as the default billing period
		if ( ! isset( $_POST['_subscription_period'] ) ) {
			$_POST['_subscription_period'] = 'month';
		}

		if ( 'year' == $_POST['_subscription_period'] ) { // save the day & month for the date rather than just the day

			$_POST[ self::$post_meta_key ] = array(
				'day'    => isset( $_POST[ self::$post_meta_key_day ] ) ? $_POST[ self::$post_meta_key_day ] : 0,
				'month'  => isset( $_POST[ self::$post_meta_key_month ] ) ? $_POST[ self::$post_meta_key_month ] : '01',
			);

		} else {

			if ( ! isset( $_POST[ self::$post_meta_key ] ) ) {
				$_POST[ self::$post_meta_key ] = 0;
			}

		}

		update_post_meta( $post_id, self::$post_meta_key, $_POST[ self::$post_meta_key ] );
	}

	/**
	 * Save sync options when a variable subscription product is saved
	 *
	 * @since 1.5
	 */
	public static function process_product_meta_variable_subscription( $post_id ) {

		if ( ! isset( $_POST['variable_post_id'] ) || ! is_array( $_POST['variable_post_id'] ) ){
			return;
		}

		$variable_post_ids = $_POST['variable_post_id'];

		$max_loop = max( array_keys( $variable_post_ids ) );

		// Make sure the parent product doesn't have a sync value (in case it was once a simple subscription)
		update_post_meta( $post_id, self::$post_meta_key, 0 );

		$day_field   = 'variable' . self::$post_meta_key_day;
		$month_field = 'variable' . self::$post_meta_key_month;

		// Save each variations details
		for ( $i = 0; $i <= $max_loop; $i ++ ) {

			if ( ! isset( $variable_post_ids[ $i ] ) ) {
				continue;
			}

			$variation_id = absint( $variable_post_ids[ $i ] );

			if ( 'year' == $_POST['variable_subscription_period'][ $i ] ) { // save the day & month for the date rather than just the day

				$_POST[ 'variable' . self::$post_meta_key ][ $i ] = array(
					'day'    => isset( $_POST[ $day_field ][ $i ] ) ? $_POST[ $day_field ][ $i ] : 0,
					'month'  => isset( $_POST[ $month_field ][ $i ] ) ? $_POST[ $month_field ][ $i ] : 0,
				);

			} else {

				if ( ! isset( $_POST[ 'variable' . self::$post_meta_key ][ $i ] ) ) {
					$_POST[ 'variable' . self::$post_meta_key ][ $i ] = 0;
				}

			}

			if ( isset( $_POST[ 'variable' . self::$post_meta_key ][ $i ] ) ) {
				update_post_meta( $variation_id, self::$post_meta_key, $_POST[ 'variable' . self::$post_meta_key ][ $i ] );
			}
		}
	}

	/**
	 * Add translated syncing options for our client side script
	 *
	 * @since 1.5
	 */
	public static function admin_script_parameters( $script_parameters ) {

		// Get admin screen id
	    $screen = get_current_screen();

		if ( 'product' == $screen->id ) {

			$billing_period_strings = self::get_billing_period_ranges();

			$script_parameters['syncOptions'] = array(
				'week'  => $billing_period_strings['week'],
				'month' => $billing_period_strings['month'],
			);

		}

		return $script_parameters;
	}

	/**
	 * Determine whether a product, specified with $product, needs to have its first payment processed on a
	 * specific day (instead of at the time of sign-up).
	 *
	 * @return (bool) True is the product's first payment will be synced to a certain day.
	 * @since 1.5
	 */
	public static function is_product_synced( $product ) {

		$payment_date = self::get_products_payment_day( $product );

		return ( ( ! is_array( $payment_date ) && $payment_date > 0 ) || ( isset( $payment_date['day'] ) && $payment_date['day'] > 0 ) ) ? true : false;
	}

	/**
	 * Get the day of the week, month or year on which a subscription's payments should be
	 * synchronised to.
	 *
	 * @return int The day the products payments should be processed, or 0 if the payments should not be sync'd to a specific day.
	 * @since 1.5
	 */
	public static function get_products_payment_day( $product ) {

		if ( ! is_object( $product ) ) {
			$payment_date = get_post_meta( $product, self::$post_meta_key, true );
		} else {
			$payment_date = $product->subscription_payment_sync_date;
		}

		return $payment_date;
	}

	/**
	 * Make sure anything requesting the first payment date for a synced subscription receives a date which
	 * takes into account the day on which payments should be processed.
	 *
	 * This is necessary as the self::calculate_first_payment_date() is not called when the subscription is active
	 * (which it isn't until the first payment is completed and the subscription is activated).
	 *
	 * @since 1.5
	 */
	public static function get_first_payment_date( $first_payment_date, $order, $product_id, $type ) {

		$subscription_key = WC_Subscriptions_Manager::get_subscription_key( $order->id, $product_id );

		if ( self::order_contains_synced_subscription( $order->id ) && 1 >= WC_Subscriptions_Manager::get_subscriptions_completed_payment_count( $subscription_key ) ) {

			$subscription = WC_Subscriptions_Manager::get_subscription( $subscription_key );
			$id_for_calculation = ! empty( $subscription['variation_id'] ) ? $subscription['variation_id'] : $subscription['product_id'];

			$first_payment_timestamp = self::calculate_first_payment_date( $id_for_calculation, 'timestamp', $order->order_date );

			if ( 0 != $first_payment_timestamp ) {
				$first_payment_date = ( 'mysql' == $type ) ? date( 'Y-m-d H:i:s', $first_payment_timestamp ) : $first_payment_timestamp;
			}
		}

		return $first_payment_date;
	}

	/**
	 * Calculate the first payment date for a synced subscription.
	 *
	 * The date is calculated in UTC timezone.
	 *
	 * This is necessary as the self::calculate_first_payment_date() is not called when the subscription is active
	 * (which it isn't until the first payment is completed and the subscription is activated).
	 *
	 * @param WC_Product $product A subscription product.
	 * @param string $type (optional) The format to return the first payment date in, either 'mysql' or 'timestamp'. Default 'mysql'.
	 * @param string $from_date (optional) The date to calculate the first payment from in GMT/UTC timzeone. If not set, it will use the current date. This should not include any trial period on the product.
	 * @since 1.5
	 */
	public static function calculate_first_payment_date( $product, $type = 'mysql', $from_date = '' ) {
		global $wp_locale;

		if ( ! is_object( $product ) ) {
			$product = WC_Subscriptions::get_product( $product );
		}

		if ( ! self::is_product_synced( $product ) ) {
			return 0;
		}

		$period       = WC_Subscriptions_Product::get_period( $product );
		$trial_period = WC_Subscriptions_Product::get_trial_period( $product );
		$trial_length = WC_Subscriptions_Product::get_trial_length( $product );

		$from_date_param = $from_date;

		if ( empty( $from_date ) ) {
			$from_date = gmdate( 'Y-m-d H:i:s' );
		}

		// If the subscription has a free trial period, the first payment should be synced to a day after the free trial
		if ( $trial_length > 0 ) {
			$from_date = WC_Subscriptions_Product::get_trial_expiration_date( $product, $from_date );
		}

		$from_timestamp = strtotime( $from_date ) + ( get_option( 'gmt_offset' ) * 3600 ); // Site time

		$payment_day = self::get_products_payment_day( $product );

		if ( 'week' == $period ) {

			// strtotime() will figure out if the day is in the future or today (see: https://gist.github.com/thenbrent/9698083)
			$first_payment_timestamp = strtotime( $wp_locale->weekday[ $payment_day ], $from_timestamp );

		} elseif ( 'month' == $period ) {

			// strtotime() needs to know the month, so we need to determine if the specified day has occured this month yet or if we want the last day of the month (see: https://gist.github.com/thenbrent/9698083)
			if ( $payment_day > 27 ) { // we actually want the last day of the month

				$payment_day = gmdate( 't', $from_timestamp );
				$month       = gmdate( 'F', $from_timestamp );

			} elseif ( gmdate( 'j', $from_timestamp ) > $payment_day ) { // today is later than specified day in the fromt date, we need the next month

				$month = date( 'F', WC_Subscriptions::add_months( $from_timestamp, 1 ) );

			} else { // specified day is either today or still to come in the month of the from date

				$month = gmdate( 'F', $from_timestamp );

			}

			$first_payment_timestamp = strtotime( "{$payment_day} {$month}", $from_timestamp );

		} elseif ( 'year' == $period ) {

			$day = $payment_day['day'];

			// We can't use $wp_locale here because it is translated
			switch ( $payment_day['month'] ) {
				case 1 :
					$month = 'January';
					break;
				case 2 :
					$month = 'February';
					break;
				case 3 :
					$month = 'March';
					break;
				case 4 :
					$month = 'April';
					break;
				case 5 :
					$month = 'May';
					break;
				case 6 :
					$month = 'June';
					break;
				case 7 :
					$month = 'July';
					break;
				case 8 :
					$month = 'August';
					break;
				case 9 :
					$month = 'September';
					break;
				case 10 :
					$month = 'October';
					break;
				case 11 :
					$month = 'November';
					break;
				case 12 :
					$month = 'December';
					break;
			}

			$first_payment_timestamp = strtotime( "{$day} {$month}", $from_timestamp );

			// Make sure the next payment is in the future and after the $from_date, as strtotime() will return the date this year for any day in the past (see: https://gist.github.com/thenbrent/9698083)
			if ( $first_payment_timestamp < $from_timestamp || ( $payment_day['month'] < gmdate( 'j' ) && $payment_day['month'] < gmdate( 'n' ) ) ) { // First make sure the day is different so that we don't end up jumping a year because of a few hours difference between now and the billing date
				$i = 1;
				while ( ( $first_payment_timestamp < gmdate( 'U' ) || $first_payment_timestamp < $from_timestamp ) && $i < 30 ) {
					$first_payment_timestamp = strtotime( "+ 1 year", $first_payment_timestamp );
					$i = $i + 1;
				}
			}
		}

		// We calculated a timestamp for midnight on the specific day in the site's timezone, so we need to convert it to the UTC equivalent of midnight on that day
		$first_payment_timestamp -= ( get_option( 'gmt_offset' ) * HOUR_IN_SECONDS );

		$first_payment = ( 'mysql' == $type && 0 != $first_payment_timestamp ) ? date( 'Y-m-d H:i:s', $first_payment_timestamp ) : $first_payment_timestamp;

		return apply_filters( 'woocommerce_subscriptions_synced_first_payment_date', $first_payment, $product, $type, $from_date, $from_date_param );
	}

	/**
	 * Return an i18n'ified associative array of all possible subscription periods.
	 *
	 * @since 1.5
	 */
	public static function get_billing_period_ranges( $billing_period = '' ) {
		global $wp_locale;

		if ( empty( self::$billing_period_ranges ) ) {

			foreach ( array( 'week', 'month', 'year' ) as $key ) {
				self::$billing_period_ranges[ $key ][0] = __( 'Do not synchronise', 'woocommerce-subscriptions' );
			}

			// Week
			$weekdays = array_merge( $wp_locale->weekday, array( $wp_locale->weekday[0] ) );
			unset( $weekdays[0] );
			foreach ( $weekdays as $i => $weekly_billing_period ) {
				self::$billing_period_ranges['week'][ $i ] = sprintf( __( '%s each week', 'woocommerce-subscriptions' ), $weekly_billing_period );
			}

			// Month
			foreach ( range( 1, 27 ) as $i ) {
				self::$billing_period_ranges['month'][ $i ] = sprintf( __( '%s day of the month', 'woocommerce-subscriptions' ), WC_Subscriptions::append_numeral_suffix( $i ) );
			}
			self::$billing_period_ranges['month'][28] = __( 'Last day of the month', 'woocommerce-subscriptions' );

			self::$billing_period_ranges = apply_filters( 'woocommerce_subscription_billing_period_ranges', self::$billing_period_ranges );
		}

		if ( empty( $billing_period ) ) {
			return self::$billing_period_ranges;
		} elseif ( isset( self::$billing_period_ranges[ $billing_period ] ) ) {
			return self::$billing_period_ranges[ $billing_period ];
		} else {
			return array();
		}
	}

	/**
	 * Output
	 *
	 * @since 1.5
	 */
	public static function products_first_payment_date( $echo = false ) {
		global $product;

		$first_payment_date = '';

		if ( self::is_product_synced( $product ) ) {
			$first_payment_timestamp = self::calculate_first_payment_date( $product->id, 'timestamp' );

			if ( self::is_today( $first_payment_timestamp ) ) {
				$payment_date_string = __( 'Today!', 'woocommerce-subscriptions' );
			} else {
				$payment_date_string = date_i18n( woocommerce_date_format(), $first_payment_timestamp + ( get_option( 'gmt_offset' ) * HOUR_IN_SECONDS ) );
			}

			if ( 0 != $first_payment_timestamp ) {
				switch ( WC_Subscriptions_Product::get_period( $product ) ) {
					case 'week' :
						$first_payment_date = sprintf( __( 'First weekly payment: %s', 'woocommerce-subscriptions' ), $payment_date_string );
						break;
					case 'month' :
						$first_payment_date = sprintf( __( 'First monthly payment: %s', 'woocommerce-subscriptions' ), $payment_date_string );
						break;
					case 'year' :
						$first_payment_date = sprintf( __( 'First yearly payment: %s', 'woocommerce-subscriptions' ), $payment_date_string );
						break;
				}
				$first_payment_date = '<p class="first-payment-date">' . $first_payment_date .  '</p>';
			}
		}

		if ( false !== $echo ) {
			echo $first_payment_date;
		}

		return $first_payment_date;
	}


	/**
	 * Add the first payment date to the end of the subscription to clarify when the first payment will be processed
	 *
	 * @since 1.5
	 */
	public static function customise_subscription_price_string( $subscription_string ) {

		$cart_item = self::cart_contains_synced_subscription();

		if ( false !== $cart_item && isset( $cart_item['data']->subscription_period ) && ( 'year' != $cart_item['data']->subscription_period || $cart_item['data']->subscription_trial_length > 0 ) ) {
			$first_payment_timestamp = self::calculate_first_payment_date( $cart_item['product_id'], 'timestamp' );
			if ( 0 != $first_payment_timestamp ) {

				if ( self::is_today( $first_payment_timestamp ) ) {
					$payment_date_string = __( 'Today!', 'woocommerce-subscriptions' );
				} else {
					$payment_date_string = date_i18n( woocommerce_date_format(), $first_payment_timestamp + ( get_option( 'gmt_offset' ) * HOUR_IN_SECONDS ) );
				}

				$price_and_start_date = sprintf( __( '%s %s(First payment: %s)%s', 'woocommerce-subscriptions' ), $subscription_string, '<br/><small class="first-payment-date">', $payment_date_string, '</small>' );
				$subscription_string  = apply_filters( 'woocommerce_subscriptions_synced_start_date_string', $price_and_start_date, $subscription_string );
			}
		}

		return $subscription_string;
	}


	/**
	 * Don't display the trial period for a synchronised subscription unless the related product actually has a trial period (because
	 * we use a trial period to set the original order totals to 0).
	 *
	 * @since 1.5
	 */
	public static function maybe_hide_free_trial( $subscription_details ) {

		$cart_item = self::cart_contains_synced_subscription();

		if ( false !== $cart_item ) { // cart contains a sync

			$product_id = WC_Subscriptions_Cart::get_items_product_id( $cart_item );

			if ( woocommerce_price( 0 ) == $subscription_details['initial_amount'] && 0 == $subscription_details['trial_length'] ) {
				$subscription_details['initial_amount'] = '';
			}
		}

		return $subscription_details;
	}

	/**
	 * If the order being generated is for a synced subscription, keep a record of the syncing related meta data.
	 *
	 * @since 1.5
	 */
	public static function add_order_meta( $order_id, $posted ) {
		global $woocommerce;

		if ( $cart_item = self::cart_contains_synced_subscription() ) {
			update_post_meta( $order_id, '_order_contains_synced_subscription', 'true' );
		}
	}

	/**
	 * Make sure a synchronised subscription's price includes a free trial, unless it's first payment is today.
	 *
	 * @since 1.5
	 */
	public static function maybe_set_free_trial( $total ) {
		global $woocommerce;

		foreach ( $woocommerce->cart->get_cart() as $cart_item_key => $cart_item ) {
			if ( self::is_product_synced( $cart_item['data'] ) && ! self::is_today( self::calculate_first_payment_date( $cart_item['data'], 'timestamp' ) ) ) {
				$woocommerce->cart->cart_contents[ $cart_item_key ]['data']->subscription_trial_length = ( $woocommerce->cart->cart_contents[ $cart_item_key ]['data']->subscription_trial_length > 1 ) ? $woocommerce->cart->cart_contents[ $cart_item_key ]['data']->subscription_trial_length : 1;
			}
		}

		return $total;
	}

	/**
	 * Make sure a synchronised subscription's price includes a free trial, unless it's first payment is today.
	 *
	 * @since 1.5
	 */
	public static function maybe_unset_free_trial( $total ) {
		global $woocommerce;

		foreach ( $woocommerce->cart->get_cart() as $cart_item_key => $cart_item ) {
			if ( self::is_product_synced( $cart_item['data'] ) ) {
				$woocommerce->cart->cart_contents[ $cart_item_key ]['data']->subscription_trial_length = WC_Subscriptions_Product::get_trial_length( WC_Subscriptions_Cart::get_items_product_id( $cart_item ) );
			}
		}

		return $total;
	}

	/**
	 * Make sure the expiration date is calculated from the synced start date for products where the start date
	 * will be synced.
	 *
	 * @param string $expiration_date MySQL formatted date on which the subscription is set to expire
	 * @param mixed $product_id The product/post ID of the subscription
	 * @param mixed $from_date A MySQL formatted date/time string from which to calculate the expiration date, or empty (default), which will use today's date/time.
	 * @since 1.5
	 */
	public static function recalculate_product_expiration_date( $expiration_date, $product_id, $from_date ) {

		if ( self::is_product_synced( $product_id ) ) {
			remove_filter( 'woocommerce_subscriptions_product_expiration_date', __CLASS__ . '::' . __FUNCTION__ ); // avoid infinite loop
			$expiration_date = WC_Subscriptions_Product::get_expiration_date( $product_id, self::calculate_first_payment_date( $product_id, 'mysql' ) );
			add_filter( 'woocommerce_subscriptions_product_expiration_date', __CLASS__ . '::' . __FUNCTION__ );
		}

		return $expiration_date;
	}

	/**
	 * Check if a given timestamp (in the UTC timezone) is equivalent to today in the site's time.
	 *
	 * @param int $timestamp A time in UTC timezone to compare to today.
	 */
	private function is_today( $timestamp ) {

		// Convert timestamp to site's time
		$timestamp += get_option( 'gmt_offset' ) * HOUR_IN_SECONDS;

		return ( gmdate( 'Y-m-d', current_time( 'timestamp' ) ) == date( 'Y-m-d', $timestamp ) ) ? true : false;
	}

	/**
	 * Filters WC_Subscriptions_Order::get_sign_up_fee() to make sure the sign-up fee for a subscription product
	 * that is synchronised is returned correctly.
	 *
	 * @param float The initial sign-up fee charged when the subscription product in the order was first purchased, if any.
	 * @param mixed $order A WC_Order object or the ID of the order which the subscription was purchased in.
	 * @param int $product_id The post ID of the subscription WC_Product object purchased in the order. Defaults to the ID of the first product purchased in the order.
	 * @return float The initial sign-up fee charged when the subscription product in the order was first purchased, if any.
	 * @since 1.5.3
	 */
	public static function get_sign_up_fee( $sign_up_fee, $order, $product_id, $non_subscription_total ) {

		if ( self::order_contains_synced_subscription( $order->id ) && WC_Subscriptions_Order::get_subscription_trial_length( $order ) < 1 ) {
			$sign_up_fee = max( WC_Subscriptions_Order::get_total_initial_payment( $order ) - $non_subscription_total, 0 );
		}

		return $sign_up_fee;
	}
}
WC_Subscriptions_Synchroniser::init();
