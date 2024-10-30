<?php

if ( ! defined( 'ABSPATH' ) ) exit;

/**
* Chroma Hash init
*
*/
function cc_caboodle_passvis_enqueue() {

	/**
	 * Inline style to prevent layout shift on entering pw chars
	 *
	 **/
	wp_register_style( 'passvis', false, array(), CC_CABOODLE_PLUGIN_VERSION, true );
	wp_add_inline_style( 'passvis', '.chroma-hash { position: absolute; }' );
	wp_enqueue_style( 'passvis' );


	/**
	 * Store a random value for passvis_salt in the options array if it does not exist
	 *
	 **/
	$caboodle_options = get_option('cc_caboodle');

	//* if there is no existing value for passvis_salt, generate a random salt
	if ( ( ! array_key_exists('passvis_salt', $caboodle_options ) ) || ( '' == cc_caboodle( 'passvis_salt', '' ) ) ) {

		//* give passvis_salt a random value
		$passvis_salt = cc_caboodle_passvis_random_hex();
		
		cc_caboodle_update_option_value( 'passvis_salt', $passvis_salt );
	}

	wp_enqueue_script( 'passvis', CC_CABOODLE_PLUGIN_URL . 'js/chromahash.js', array( 'jquery' ), CC_CABOODLE_PLUGIN_VERSION, true );

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
add_action( 'login_enqueue_scripts', 'cc_caboodle_passvis_enqueue' );


/**
* if the onfront option is TRUE, also enqueue the ChromaHash scripts on the front-end
*
*/
if ( cc_caboodle( 'passvis_onfront', FALSE ) == TRUE )  {
	add_action( 'wp_enqueue_scripts', 'cc_caboodle_passvis_enqueue' );
}

