<?php

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Register caboodle dashicons stylesheet
 *
 */
function cc_caboodle_register_dashicons() {
 	wp_register_style( 'caboodle_dashicons', CC_CABOODLE_PLUGIN_URL . 'css/dashicons-caboodle.css' , false, CC_CABOODLE_PLUGIN_VERSION );
}
add_action( 'admin_enqueue_scripts', 'cc_caboodle_register_dashicons' ); // used in the posts module - rename as news
add_action( 'wp_enqueue_scripts', 'cc_caboodle_register_dashicons' );


/**
 * Function to enqueue caboodle dashicons stylesheet
 *
 */
function cc_caboodle_enqueue_dashicons() {
 	wp_enqueue_style( 'caboodle_dashicons' );
	wp_enqueue_style( 'dashicons' );
}


/**
 * Enqueue the caboodle dashicons stylesheet on the front end
 *
 */
if ( cc_caboodle( 'add_dashicons', '' ) == '1' ) {
	add_action( 'wp_enqueue_scripts', 'cc_caboodle_enqueue_dashicons' );
}


/**
 * To show/hide the caboodle dashicons in the customizer preview
 *
 */
function cc_caboodle_dashicons_jscss() {
	
	$show_dashicons = 'false';

	if ( cc_caboodle( 'add_dashicons', '' ) == 'true' ) {
		$show_dashicons = 'true';
	}

	?>
	<script type="text/javascript">
	document.addEventListener('DOMContentLoaded', function() {
		const dashSpans = Array.from(document.querySelectorAll('span')).filter(span => 
			span.classList.contains('dashicons') && 
			Array.from(span.classList).some(className => className.startsWith('dashicons-caboodle-'))
		);
		const showDashicons = <?php echo wp_json_encode( $show_dashicons === 'true' ); ?>;
	
		dashSpans.forEach((dashSpan) => {
			dashSpan.setAttribute('data-show_dashicons', showDashicons);
		});
	});
	</script>

	<style>
		span[data-show_dashicons='false'] { display: none !important; }
		span[data-show_dashicons='true'] { display: inline-block !important; }
	</style>
	<?php
}

/**
 * If we are on the customizer preview, enqueue the caboodle dashicons
 *
 */
if ( is_customize_preview() ) {	
	
	//Add script for Customiser preview
	add_action( 'admin_enqueue_scripts', 'cc_caboodle_enqueue_dashicons' );
	add_action( 'wp_enqueue_scripts', 'cc_caboodle_enqueue_dashicons' );

	// Add the JS & CSS
	add_action( 'wp_footer', 'cc_caboodle_dashicons_jscss' );
}
