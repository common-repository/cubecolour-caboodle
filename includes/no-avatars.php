<?php

if ( ! defined( 'ABSPATH' ) ) exit;

/**
* Update the show_avatars option
*
*/
function cc_caboodle_update_customizer(){
	if ( cc_caboodle( 'no_avatars' ) == '' ) {
		update_option( 'show_avatars', '1' );
	} else {
		update_option( 'show_avatars', '' );
	}
}
add_action( 'customize_save_after', 'cc_caboodle_update_customizer' );
