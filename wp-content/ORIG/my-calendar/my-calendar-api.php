<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly



function my_calendar_api() {

	if ( isset( $_REQUEST['my-calendar-api'] ) ) {

		if ( get_option( 'mc_api_enabled' ) == 'true' ) {

			// use this filter to add custom scripting handling API keys

			$api_key = apply_filters( 'mc_api_key', true );

			if ( $api_key ) {

				$format = 		( isset( $_REQUEST['my-calendar-api'] ) ) ? $_REQUEST['my-calendar-api'] : 'json';

				$from = 		( isset( $_REQUEST['from'] ) ) ? $_REQUEST['from'] : date( 'Y-m-d', current_time( 'timestamp' ) );

				$to = 			( isset( $_REQUEST['to'] ) ) ? $_REQUEST['to'] : date( 'Y-m-d', strtotime( current_time( 'timestamp' ).apply_filters('mc_api_auto_date',' + 7 days') ) );

				// sanitization is handled elsewhere.

				$category = 	( isset( $_REQUEST['mcat'] ) ) ? $_REQUEST['mcat'] : '' ;

				$ltype = 		( isset( $_REQUEST['ltype'] ) ) ? $_REQUEST['ltype'] : '' ;

				$lvalue =		( isset( $_REQUEST['lvalue'] ) ) ? $_REQUEST['lvalue'] : '' ;

				$author = 		( isset( $_REQUEST['author'] ) ) ? $_REQUEST['author'] : '' ;

				$host = 		( isset( $_REQUEST['host'] ) ) ? $_REQUEST['host'] : '' ;

				$data = 		my_calendar_events( $from, $to, $category, $ltype, $lvalue, 'api', $author, $host );

				$output = 		mc_format_api( $data, $format );

				echo $output;

			}

			die;

		} else {

			_e( 'The My Calendar API is not enabled.','my-calendar' );

		}			

	}

}



function mc_format_api( $data, $format ) {

	$output = '';

	switch ( $format ) {

		case 'json' : $output = mc_format_json( $data ); break;

		case 'rss' : $output = mc_format_rss( $data ); break;

		case 'csv' : $ooutput = mc_format_csv( $data ) ; break;

	}

	return $output;

}



function mc_format_json( $data ) {

	return json_encode( $data );

}



function mc_format_csv( $data ) {

	$keyed = false;

	// Create a stream opening it with read / write mode

	$stream = fopen('data://text/plain,' . "", 'w+');

	// Iterate over the data, writting each line to the text stream

	foreach ($data as $key => $val) {

		foreach ( $val as $v ) {

			$values = get_object_vars( $v );

			if ( !$keyed ) {

				$keys = array_keys( $values );

				fputcsv($stream, $keys );

				$keyed = true;

			}

			fputcsv($stream, $values);

		}

	}

	// Rewind the stream

	rewind($stream);

	// You can now echo it's content

	header("Content-type: text/csv");

	header("Content-Disposition: attachment; filename=my-calendar.csv");

	header("Pragma: no-cache");

	header("Expires: 0");

	

	echo stream_get_contents($stream);

	// Close the stream 

	fclose($stream);

	die;

}



function mc_format_rss( $data ) {

	return my_calendar_rss( $data );

}