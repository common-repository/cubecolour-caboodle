<?php

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Change 'Howdy' based on the local time
 *
 */
function cc_caboodle_howdy_replace( $wp_admin_bar ) {

	$hour = date( 'G', current_time( 'timestamp', 0 ) );

	if ( $hour >= 6 && $hour <= 11 ) {
		$greet = cc_caboodle( 'no_howdy_morning', esc_html__( 'Good morning', 'cubecolour-caboodle' ) );
	} else if ( $hour >= 12 && $hour <= 18 ) {
		$greet = cc_caboodle( 'no_howdy_afternoon', esc_html__( 'Good afternoon', 'cubecolour-caboodle' ) );
	} else if ( $hour >= 19 ) {
		$greet = cc_caboodle( 'no_howdy_evening', esc_html__( 'Good evening', 'cubecolour-caboodle' ) );
	} else if ( $hour <= 5 ) {
		$greet = cc_caboodle( 'no_howdy_night', esc_html__( 'Go to bed', 'cubecolour-caboodle' ) );
	}

	$current_user = wp_get_current_user();

	if ( 0 != get_current_user_id() ) {

		$wp_admin_bar->add_menu(
			array(
				'id'		=> 'my-account',
				'parent'	=> 'top-secondary',
				'title'		=> sprintf( __( '%1$s, %2$s' ), esc_html( $greet ), ucwords( $current_user->display_name ) ) . get_avatar( get_current_user_id(), 28 ),
				'href'		=> get_edit_profile_url( get_current_user_id() ),
				'meta'		=> array(
					'class'		=> empty( get_avatar( get_current_user_id(), 28 ) ) ? '' : 'with-avatar',
				),
			)
		);
	}
}
add_action( 'admin_bar_menu', 'cc_caboodle_howdy_replace', 11 );