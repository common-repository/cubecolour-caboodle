<?php

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Check whether the 'cc_caboodle_user_timezone_offset_' . $user_id transient exists and print the JavaScript if not
 *
 */
function print_timezone_offset_script() {
	$user_id = get_current_user_id();
	$transient_name = 'cc_caboodle_user_timezone_offset_' . $user_id;
	if ( false === get_transient( $transient_name ) ) {
		// The transient does not exist or has expired, print the JavaScript
		?>
		<script type="text/javascript">
		jQuery(document).ready(function($) {
			// Calculate timezone offset in hours
			var timezoneOffset = new Date().getTimezoneOffset() / 60;

			// Send the offset to the server using jQuery's AJAX
			$.post(
				ajaxurl, // WordPress admin AJAX URL
				{
					'action': 'store_timezone_offset',
					'offset': timezoneOffset,
					'security': '<?php echo esc_attr( wp_create_nonce( "timezone_offset_nonce" ) ); ?>'
				}
			);
		});
		</script>
		<?php
	}
}
add_action( 'admin_footer', 'print_timezone_offset_script' );


/**
 * Register the AJAX handler for storing the timezone offset
 *
 */
function store_timezone_offset() {
	// Check if nonce is valid
	check_ajax_referer( 'timezone_offset_nonce', 'security' );

	// Get current user ID and create transient name
	$user_id = get_current_user_id();
	$transient_name = 'cc_caboodle_user_timezone_offset_' . $user_id;

	// Check if offset is set in POST request
	if ( isset( $_POST['offset'] ) && $user_id ) {
		// Sanitize and store offset as transient unique to the user
		$offset = sanitize_text_field( $_POST['offset'] );
		set_transient( $transient_name, $offset, HOUR_IN_SECONDS );
	}
	wp_die(); // Terminate AJAX request
}
add_action( 'wp_ajax_store_timezone_offset', 'store_timezone_offset' );


/**
 * Change the admin bar 'Howdy' greeting based on the user's local time
 *
 */
function cc_caboodle_howdy_replace( $wp_admin_bar ) {

	$user_id = get_current_user_id();
	$transient_name = 'cc_caboodle_user_timezone_offset_' . $user_id;
	$hour = gmdate( 'G', current_time( 'timestamp', 0 ) + get_transient( $transient_name ) * HOUR_IN_SECONDS );

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
				
				/* translators: %1$s: Greeting, %2$s: Current user display name */
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