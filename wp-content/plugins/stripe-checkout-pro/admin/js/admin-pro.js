/**
 * Stripe Checkout Admin JS
 *
 * @package SC Pro
 * @author  Phil Derksen <pderksen@gmail.com>, Nick Young <mycorpweb@gmail.com>
 */

/* global jQuery, sc_script */

(function($) {
	'use strict';

	// Set debug flag.
	var script_debug = ( (typeof sc_script != 'undefined') && sc_script.script_debug == true);

	$(function () {

		if (script_debug) {
			console.log('sc_script', sc_script);
		}
		var $body = $( 'body' );

		$body.find( '.license-wrap button' ).on( 'click.eddLicenseActivate', function( event ) {

			event.preventDefault();
			
			var button = $(this);
			
			if( button.parent().find('input[type="text"]').val().length < 1 ) {
				button.html( sc_strings.activate );
				button.attr( 'data-sc-action', 'activate_license' );
				button.parent().find('.sc-license-message').html( sc_strings.inactive_msg ).removeClass('sc-valid sc-invalid').addClass( 'sc-inactive' );
			} else {
				button.parent().find('.sc-spinner-wrap').show();
				
				var data = {
					action: 'sc_activate_license',
					license: button.parent().find('input[type="text"]').val(),
					item: button.attr('data-sc-item'),
					sc_action: button.attr('data-sc-action'),
					id: button.parent().find('input[type="text"]').attr('id')
				};

				$.post( ajaxurl, data, function(response) {

					if (script_debug) {
						console.log('EDD license check response', response);
					}
					
					button.parent().find('.sc-spinner-wrap').hide();
					
					if( response == 'valid' ) {
						button.html( sc_strings.deactivate );
						button.attr('data-sc-action', 'deactivate_license');
						button.parent().find('.sc-license-message').html( sc_strings.valid_msg ).removeClass('sc-inactive sc-invalid').addClass( 'sc-valid' );
					} else if( response == 'deactivated' ) {
						button.html( sc_strings.activate );
						button.attr( 'data-sc-action', 'activate_license' );
						button.parent().find('.sc-license-message').html( sc_strings.inactive_msg ).removeClass('sc-valid sc-invalid').addClass( 'sc-inactive' );
					} else if( response == 'invalid' ) {
						button.parent().find('.sc-license-message').html( sc_strings.invalid_msg ).removeClass('sc-inactive sc-valid').addClass( 'sc-invalid' );
					} else if( response == 'notfound' ) {
						button.parent().find('.sc-license-message').html( sc_strings.notfound_msg ).removeClass('sc-inactive sc-valid').addClass( 'sc-invalid' );
					} else if ( response == 'error' ) {
						button.parent().find('.sc-license-message').html( sc_strings.error_msg ).removeClass('sc-inactive sc-valid').addClass( 'sc-invalid' );
					}
				});
			}
			
		});
	});
}(jQuery));
