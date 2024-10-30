<?php

/**
 * This module was inspired by https://wordpress.org/plugins/dashboard-scratch-pad/
 *
 */
 
if ( ! defined( 'ABSPATH' ) ) exit;


/**
 * Define the callback function for saving the notes content
 *
 */ 
function cc_caboodle_save_dashnotes_callback() {
	if ( ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['_nonce'] ) ), 'dashboard_notes_nonce' ) ) {
		die( 'Invalid request.' );
	}

	$content = sanitize_textarea_field( $_POST['content'] );

	// Save the content to cc_caboodle['dashboard_notes']
	cc_caboodle_update_option_value( 'dashboard_notes_content', $content );

	wp_redirect( admin_url() );
	exit;
}

add_action( 'admin_post_save_dashnotes', 'cc_caboodle_save_dashnotes_callback' );



/**
 * Define the callback function for creating the dashboard widget
 *
 */ 
function cc_caboodle_create_dashnotes_widget() {
	wp_add_dashboard_widget( 'dashboard-dashnotes-widget', 'Dashboard Notes', function () {
		
		// Retrieve content from cc_caboodle
		$content = cc_caboodle( 'dashboard_notes_content', '' );
		$nonce_allowed_html = array(
			'input' => array(
				'type' => true,
				'name' => true,
				'value' => true,
				'id' => true,
			),
		);
		
		$placeholder = esc_html__( 'Notes&hellip;', 'cubecolour-caboodle' );
		
		?>
		<form name="post" action="<?php echo esc_attr( admin_url( 'admin-post.php' ) ); ?>" method="post">
			<input type="hidden" name="action" value="save_dashnotes">
			<?php echo wp_kses( wp_nonce_field( 'dashboard_notes_nonce', '_nonce', true, false ), $nonce_allowed_html ); ?>

			<div>
				<textarea name="content" placeholder="<?php echo esc_html( $placeholder ); ?>"
						  class="mceEditor" rows="10" autocomplete="off" style="width: 100%"
				><?php echo esc_textarea( $content ); ?></textarea>
			</div>

			<input type="submit" value="Save notes">
		</form>
		<?php
	} );
}
add_action( 'wp_dashboard_setup', 'cc_caboodle_create_dashnotes_widget' );