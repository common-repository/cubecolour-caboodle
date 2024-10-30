<?php


if ( ! defined( 'ABSPATH' ) ) exit;


/**
 * Developer Link in Admin Footer
 *
 */
function cc_caboodle_admin_devlink() {

	if ( cc_caboodle( 'devlink', '' ) == '1' ) {
		
		$devname = esc_html( cc_caboodle( 'devlink_name', '' ) );
		$devurl = esc_url( cc_caboodle( 'devlink_url', '' ) );
	
		$logocolor_nohash = 'e10a92';
		$cc_logo_svg = 'data:image/svg+xml,%3Csvg width=\'18\' height=\'18\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'%23' . sanitize_hex_color_no_hash( $logocolor_nohash ) . '\' fill-rule=\'evenodd\'%3E%3Cpath transform=\'rotate(20 9 9)\' d=\'M6.662 6.662H11.337V11.337H6.662z\'/%3E%3Cpath d=\'M0 4.803L13.197 0 18 13.197 4.803 18 0 4.803zm4.33-.473v9.363h9.363V4.33H4.33z\'/%3E%3C/g%3E%3C/svg%3E';
	
		if ( 'cubecolour' == $devname ) {
			// Add inline styles
			wp_add_inline_style( 'cc-dev-logo', '.devcredlink:before {display:inline-block;content:\'\';position:relative;top:5px;margin-right:2px;width:18px;height:18px;background-image:url("' . wp_kses( $cc_logo_svg , cc_kses_ruleset_svg() ) . '");}' );
	
			// Enqueue the style
			wp_enqueue_style( 'cc-dev-logo' );
		}
	
		/* translators: Developer name */
		return sprintf( esc_html__( 'website by %1$s', 'cubecolour-caboodle' ), '<a class="devcredlink" data-developername="' . esc_html( $devname ) . '" href="' . esc_url( $devurl ) . '">' . esc_html( $devname ) . '</a>' );
	}	
}
add_filter('admin_footer_text', 'cc_caboodle_admin_devlink');



/**
 * [developer] Shortcode to use in the site footer on the frontend
 *
 */
function cc_caboodle_front_devlink( $atts ) {
	
	$attr = shortcode_atts( array(
		'name'	=> esc_html( cc_caboodle( 'devlink_name', '' ) ),
		'url'	=> esc_url( cc_caboodle( 'devlink_url', '' ) ),
		'color'	=> 'e10a92',
	), $atts );

	$cc_logo_svg = 'data:image/svg+xml,%3Csvg width=\'18\' height=\'18\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'%23' . sanitize_hex_color_no_hash( $attr[ 'color' ] ) . '\' fill-rule=\'evenodd\'%3E%3Cpath transform=\'rotate(20 9 9)\' d=\'M6.662 6.662H11.337V11.337H6.662z\'/%3E%3Cpath d=\'M0 4.803L13.197 0 18 13.197 4.803 18 0 4.803zm4.33-.473v9.363h9.363V4.33H4.33z\'/%3E%3C/g%3E%3C/svg%3E';
		
	if ( 0 === strpos( $attr[ 'name' ], 'cubecolour' ) ) {
		wp_enqueue_style( 'cc-dev-logo' );
		wp_add_inline_style( 'cc-dev-logo', '.devlink:before {display:inline-block;content:\'\';position:relative;top:5px;margin-right:2px;width:18px;height:18px;background-image:url("' . wp_kses( $cc_logo_svg, cc_kses_ruleset_svg() ) . '");}' );
	}
	return '<a class="devlink" data-developername="' . esc_html( $attr[ 'name' ] ) . '" href="' . esc_url( $attr[ 'url' ] ) . '">' . esc_html( $attr[ 'name' ] ) . '</a>';
}
add_shortcode( 'developer', 'cc_caboodle_front_devlink' );