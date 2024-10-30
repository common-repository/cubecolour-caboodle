<?php


if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Developer Link in Admin Footer
 *
 */
function cc_caboodle_admin_devlink() {

	$devname = esc_html( cc_caboodle( 'devlink_name', '' ) );
	$devurl = esc_url( cc_caboodle( 'devlink_url', '' ) );

	$logocolor_nohash = 'e18500';

	if ( 'cubecolour' === $devname ) {

		wp_add_inline_style( 'cc-logo', '.devlink:before {display:inline-block;content:\'\';position:relative;top:5px;margin-right:2px;width:18px;height:18px;background-image:url("data:image/svg+xml,%3Csvg width=\'18\' height=\'18\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'%23' . esc_attr( $logocolor_nohash ) . '\' fill-rule=\'evenodd\'%3E%3Cpath transform=\'rotate(20 9 9)\' d=\'M6.662 6.662H11.337V11.337H6.662z\'/%3E%3Cpath d=\'M0 4.803L13.197 0 18 13.197 4.803 18 0 4.803zm4.33-.473v9.363h9.363V4.33H4.33z\'/%3E%3C/g%3E%3C/svg%3E");}' );
		wp_enqueue_style( 'cc-logo' );
	}

	/* translators: Developer credit */
	return sprintf( esc_html__( 'website by %1$s', 'cubecolour-caboodle' ), '<a class="devlink" data-developername="' . esc_html( $devname ) . '" href="' . esc_url( $devurl ) . '">' . esc_html( $devname ) . '</a>' );
}
add_filter('admin_footer_text', 'cc_caboodle_admin_devlink');


/**
 * [developer] Shortcode to use in the site footer on the frontend
 *
 */
function cc_caboodle_front_devlink( $atts ) {

	$attr = shortcode_atts( array(
		'devname'	=> esc_html( cc_caboodle( 'devlink_name', '' ) ),
		'devurl'	=> esc_url( cc_caboodle( 'devlink_url', '' ) ),
		'color'		=> esc_attr( cc_caboodle( 'devlink_color', '#fff' ) ),
	), $atts );

	$logocolor_nohash = substr( $attr[ 'color' ], 1);

	if ( 'cubecolour' === $attr[ 'devname' ] ) {

		wp_add_inline_style( 'cc-logo', '.devlink:before {display:inline-block;content:\'\';position:relative;top:5px;margin-right:2px;width:18px;height:18px;background-image:url("data:image/svg+xml,%3Csvg width=\'18\' height=\'18\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'%23' . esc_attr( $logocolor_nohash ) . '\' fill-rule=\'evenodd\'%3E%3Cpath transform=\'rotate(20 9 9)\' d=\'M6.662 6.662H11.337V11.337H6.662z\'/%3E%3Cpath d=\'M0 4.803L13.197 0 18 13.197 4.803 18 0 4.803zm4.33-.473v9.363h9.363V4.33H4.33z\'/%3E%3C/g%3E%3C/svg%3E");}' );

		wp_enqueue_style( 'cc-logo' );
	}
	return '<a style="color: ' . esc_attr( $attr[ 'color' ] ) . ';" class="devlink" data-developername="' . esc_html( $attr[ 'devname' ] ) . '" href="' . esc_url( $attr[ 'devurl' ] ) . '">' . esc_html( $attr[ 'devname' ] ) . '</a>';
}
add_shortcode( 'developer', 'cc_caboodle_front_devlink' );