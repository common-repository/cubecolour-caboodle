<?php

if ( ! defined( 'ABSPATH' ) ) exit;

/**
* Chroma Hash init
*
*/
function cc_passvis_enqueue() {

	/**
	 * Inline style to prevent layout shift on entering pw chars
	 **/
	wp_register_style( 'passvis', NULL );
	wp_add_inline_style( 'passvis', '.chroma-hash { position: absolute; }' );
	wp_enqueue_style( 'passvis' );


	/**
	 * Store a random value for passvis_salt in the options array if it does not exist
	 **/
	$caboodle_options = get_option('cc_caboodle');

	//* if there is no value for passvis_salt
	if ( ( ! array_key_exists('passvis_salt', $caboodle_options ) ) || ( '' == cc_caboodle( 'passvis_salt', '' ) ) ) {

		//* give passvis_salt a random value
		$caboodle_options['passvis_salt'] = cc_caboodle_passvis_random_hex();

		//* Update the option from the modified array
		update_option ('cc_caboodle', $caboodle_options );
	}

	wp_enqueue_script( 'passvis', CC_CABOODLE_PLUGIN_URL . 'js/chromahash.js', array( 'jquery' ), CC_CABOODLE_PLUGIN_VERSION );

	wp_localize_script(
		'passvis',
		'chvars',
		array(
		    'bars'		=> esc_attr( cc_caboodle( 'passvis_bars', 4 ) ),
		    'salt'		=> esc_attr( cc_caboodle( 'passvis_salt', cc_caboodle_passvis_random_hex() )  ),
		    'minimum'	=> esc_attr( cc_caboodle( 'passvis_minimum', 6 ) ),
		)
	);
}

/**
* enqueue the Chroma Hash script on the login page
*
*/
add_action( 'login_enqueue_scripts', 'cc_passvis_enqueue' );


/**
* if the onfront option is TRUE, also enqueue the ChromaHash scripts on the front-end
*
*/
if ( cc_caboodle( 'passvis_onfront', FALSE ) == TRUE )  {
	add_action( 'wp_enqueue_scripts', 'cc_passvis_enqueue' );
}

