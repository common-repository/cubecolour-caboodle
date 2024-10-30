<?php

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 *	SHOW / HIDE control based on checkbox
 *	https://digitalapps.com/hide-show-controls-based-on-other-settings-in-wordpress-customizer/
 *
 *	Toggle Switch
 *	https://maddisondesigns.com/2017/05/the-wordpress-customizer-a-developers-guide-part-2/
 *
 *	Image radio buttons
 *	https://maddisondesigns.com/2017/05/the-wordpress-customizer-a-developers-guide-part-2/#imageradiobutton
 *
 **/

include_once( ABSPATH . 'wp-includes/class-wp-customize-control.php' );
include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

/**
 * Enqueue js & css for custom customize controls
 *
 */
function cc_caboodle_custom_customize_enqueue_js() {
	wp_enqueue_script( 'cc-caboodle-customizer', CC_CABOODLE_PLUGIN_URL . 'js/customizer-controls.js', array( 'jquery', 'customize-controls' ), CC_CABOODLE_PLUGIN_VERSION, true );
}
add_action( 'customize_controls_enqueue_scripts', 'cc_caboodle_custom_customize_enqueue_js' );

function cc_caboodle_custom_customize_enqueue_css() {
	wp_enqueue_style( 'cc-caboodle-customizer', CC_CABOODLE_PLUGIN_URL . 'css/customizer.css', '', CC_CABOODLE_PLUGIN_VERSION );
}
add_action( 'customize_controls_print_styles', 'cc_caboodle_custom_customize_enqueue_css' );


/**
 * Include range control with value indicator
 *
 */
if ( !class_exists( 'Cubecolour_Range_Value_Control' ) ) {
	include_once( CC_CABOODLE_PLUGIN_PATH . 'includes/class-customizer-range-value-control.php' );
}


/**
 * Include Custom toggle control
 *
 */
if ( !class_exists( 'Cubecolour_Toggle_Control' ) ) {
	require_once( CC_CABOODLE_PLUGIN_PATH . 'includes/class-customizer-toggle-control.php' );
}


/**
 * Include custom radio image control
 *
 */
if ( !class_exists( 'Cubecolour_Radio_Image_Control' ) ) {
	include_once( CC_CABOODLE_PLUGIN_PATH . 'includes/class-customizer-radio-image-control.php' );
}

/**
* Separator block
*/
if ( !class_exists( 'Cubecolour_Separator_Control' ) ) {
	class Cubecolour_Separator_Control extends WP_Customize_Control{
		public $type = 'separator';
		public function render_content(){
			?>
			<p><hr></p>
			<?php
		}
	}
}

/**
 * Sanitize and validation functions
 *
 */
require_once( CC_CABOODLE_PLUGIN_PATH . 'includes/sanitize.php' );


/**
 * Bind JS handlers to allow the Customizer preview to show changes as they are made
 *
 */
function cc_caboodle_customize_preview_js() {
	wp_enqueue_script( 'cc_caboodle_customizer_preview', CC_CABOODLE_PLUGIN_URL . 'js/customizer-preview.js', array( 'customize-preview' ), CC_CABOODLE_PLUGIN_VERSION, true );
}
add_action( 'customize_preview_init', 'cc_caboodle_customize_preview_js' );


/**
 * Customizer
 *
 */
function cc_caboodle_customize_register( $wp_customize ){

	/**
	 * Caboodle customizer panel
	 *
	 */
	$wp_customize->add_panel( 'cc_caboodle_panel',
		array(
			'priority'			=> 900,
			'title'				=> esc_html__( 'Caboodle', 'cubecolour-caboodle' ),
		)
	);


	/** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** **
	 * Additional date and time format options
	 *
	 */
	$wp_customize->add_section( 'cc_caboodle_datetime_formats_section',
		array(
			'title'				=> esc_html__( 'Additional date & time formats', 'cubecolour-caboodle' ),
			'description'		=> esc_html__( 'Adds new options for date and time formats in the general settings admin page', 'cubecolour-caboodle' ),
			'panel'				=> 'cc_caboodle_panel'
		)
	);

	$wp_customize->add_setting('cc_caboodle[datetime_formats]', array(
		'default'		   => false,
		'sanitize_callback' => 'cc_toggle_control_sanitize',
		'type'				=> 'option',
		'transport'			=> 'postMessage',
	));
	$wp_customize->add_control( new Cubecolour_Toggle_Control(
		$wp_customize,
			'cc_caboodle_datetime_formats',
			array(
				'label'			=> esc_html__( 'Additional date & time formats', 'cubecolour-caboodle' ),
				'type'	 		=> 'checkbox',
				'section'  		=> 'cc_caboodle_datetime_formats_section',
				'settings'		=> 'cc_caboodle[datetime_formats]',
			)
		)
	);

	/** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** **
	 * Private site section (redirect unauthenticated users to login)
	 *
	 */
	$wp_customize->add_section( 'cc_caboodle_private_site_section',
		array(
			'title'				=> esc_html__( 'Private site', 'cubecolour-caboodle' ),
			'description'		=> esc_html__( 'Redirect unauthenticated visitors to the login page', 'cubecolour-caboodle' ),
			'panel'				=> 'cc_caboodle_panel'
		)
	);

	$wp_customize->add_setting('cc_caboodle[private_site]', array(
		'default'		   => false,
		'sanitize_callback' => 'cc_toggle_control_sanitize',
		'type'				=> 'option',
		'transport'			=> 'postMessage',
	));
	$wp_customize->add_control( new Cubecolour_Toggle_Control(
		$wp_customize,
			'cc_caboodle_private_site',
			array(
				'label'			=> esc_html__( 'Private site', 'cubecolour-caboodle' ),
				'type'	 		=> 'checkbox',
				'section'  		=> 'cc_caboodle_private_site_section',
				'settings'		=> 'cc_caboodle[private_site]',
			)
		)
	);


	/** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** **
	 * Login page background
	 *
	 */
	$wp_customize->add_section( 'cc_caboodle_login_bg_section',
		array(
			'title'				=> esc_html__( 'Login Background', 'cubecolour-caboodle' ),
			'description'		=> esc_html__( 'Apply a colored background to the login page', 'cubecolour-caboodle' ),
			'panel'				=> 'cc_caboodle_panel'
		)
	);

	$wp_customize->add_setting('cc_caboodle[login_bg]', array(
		'default'		   => false,
		'sanitize_callback' => 'cc_toggle_control_sanitize',
		'type'				=> 'option',
		'transport'			=> 'postMessage',
	));
	$wp_customize->add_control( new Cubecolour_Toggle_Control(
		$wp_customize,
			'cc_caboodle_login_bg',
			array(
				'label'			=> esc_html__( 'Login Background', 'cubecolour-caboodle' ),
				'type'	 		=> 'checkbox',
				'section'  		=> 'cc_caboodle_login_bg_section',
				'settings'		=> 'cc_caboodle[login_bg]',
			)
		)
	);

	$wp_customize->add_setting( 'cc_caboodle[login_bg_color_1]',
		array(
			'default'			=> '#fff',
			'sanitize_callback'	=> 'sanitize_hex_color',
			'type'				=> 'option',
			'transport'			=> 'postMessage',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize, 'cc_caboodle_login_bg_color_1',
			array(
				'label'			=> esc_html__( 'Color left &amp; Right', 'cubecolour-caboodle' ),
				'section'		=> 'cc_caboodle_login_bg_section',
				'settings'		=> 'cc_caboodle[login_bg_color_1]',
			)
		)
	);

	$wp_customize->add_setting( 'cc_caboodle[login_bg_color_2]',
		array(
			'default'			=> '#fff',
			'sanitize_callback'	=> 'sanitize_hex_color',
			'type'				=> 'option',
			'transport'			=> 'postMessage',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize, 'cc_caboodle_login_bg_color_2',
			array(
				'label'			=> esc_html__( 'Color centre', 'cubecolour-caboodle' ),
				'section'		=> 'cc_caboodle_login_bg_section',
				'settings'		=> 'cc_caboodle[login_bg_color_2]',
			)
		)
	);

	$wp_customize->add_setting('cc_caboodle[login_bg_borderless]', array(
		'default'		   => false,
		'sanitize_callback' => 'cc_toggle_control_sanitize',
		'type'				=> 'option',
		'transport'			=> 'refresh',
	));
	$wp_customize->add_control( new Cubecolour_Toggle_Control(
		$wp_customize,
			'cc_caboodle_login_bg_borderless',
			array(
				'label'			=> esc_html__( 'Borderless', 'cubecolour-caboodle' ),
				'type'	 		=> 'checkbox',
				'section'  		=> 'cc_caboodle_login_bg_section',
				'settings'		=> 'cc_caboodle[login_bg_borderless]',
			)
		)
	);
	/** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** **
	 * No login by email section
	 *
	 */
	$wp_customize->add_section( 'cc_caboodle_no_login_email_section',
		array(
			'title'				=> esc_html__( 'No login by email address', 'cubecolour-caboodle' ),
			'description'		=> esc_html__( 'Must log in by username, not by email address', 'cubecolour-caboodle' ),
			'panel'				=> 'cc_caboodle_panel'
		)
	);

	$wp_customize->add_setting('cc_caboodle[no_login_email]', array(
		'default'		   => false,
		'sanitize_callback' => 'cc_toggle_control_sanitize',
		'type'				=> 'option',
		'transport'			=> 'postMessage',
	));
	$wp_customize->add_control( new Cubecolour_Toggle_Control(
		$wp_customize,
			'cc_caboodle_no_login_email',
			array(
				'label'			=> esc_html__( 'No login by email', 'cubecolour-caboodle' ),
				'type'	 		=> 'checkbox',
				'section'  		=> 'cc_caboodle_no_login_email_section',
				'settings'		=> 'cc_caboodle[no_login_email]',
			)
		)
	);



	/** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** **
	 * Mask password section
	 *
	 */
	$wp_customize->add_section( 'cc_caboodle_password_mask_section',
		array(
			'title'				=> esc_html__( 'Mask password', 'cubecolour-caboodle' ),
			'description'		=> esc_html__( 'Do not expose password characters when entered on iPad, iPhone or android', 'cubecolour-caboodle' ),
			'panel'				=> 'cc_caboodle_panel'
		)
	);

	$wp_customize->add_setting('cc_caboodle[password_mask]', array(
		'default'		   => false,
		'sanitize_callback' => 'cc_toggle_control_sanitize',
		'type'				=> 'option',
		'transport'			=> 'postMessage',
	));
	$wp_customize->add_control( new Cubecolour_Toggle_Control(
		$wp_customize,
			'cc_caboodle_password_mask',
			array(
				'label'			=> esc_html__( 'Mask password', 'cubecolour-caboodle' ),
				'type'	 		=> 'checkbox',
				'section'  		=> 'cc_caboodle_password_mask_section',
				'settings'		=> 'cc_caboodle[password_mask]',
			)
		)
	);



	/** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** **
	 * Caboodle single login error message section
	 *
	 */
	$wp_customize->add_section( 'cc_caboodle_login_error_section',
		array(
			'title'				=> esc_html__( 'Single login error message', 'cubecolour-caboodle' ),
			'description'		=> esc_html__( 'The same message for wrong username or wrong password', 'cubecolour-caboodle' ),
			'panel'				=> 'cc_caboodle_panel'
		)
	);

	$wp_customize->add_setting('cc_caboodle[login_error]', array(
		'default'		   => false,
		'sanitize_callback' => 'cc_toggle_control_sanitize',
		'type'				=> 'option',
		'transport'			=> 'postMessage',
	));
	$wp_customize->add_control( new Cubecolour_Toggle_Control(
		$wp_customize,
			'cc_caboodle_login_error',
			array(
				'label'			=> esc_html__( 'Single error message', 'cubecolour-caboodle' ),
				'type'	 		=> 'checkbox',
				'section'  		=> 'cc_caboodle_login_error_section',
				'settings'		=> 'cc_caboodle[login_error]',
			)
		)
	);



	$wp_customize->add_setting( 'cc_caboodle[login_error_message]',
		array(
			'default'			=> esc_html__( 'Incorrect credentials', 'cubecolour-caboodle' ),
			'sanitize_callback'	=> 'sanitize_text_field',
			'type'				=> 'option',
			'transport'			=> 'postMessage',
		)
	);
	$wp_customize->add_control( 'cc_caboodle_login_error_message',
		array(
			'label'				=> esc_html__( 'Error message', 'cubecolour-caboodle' ),
			'section'			=> 'cc_caboodle_login_error_section',
			'settings'			=> 'cc_caboodle[login_error_message]',
			'type'				=> 'text',
		)
	);


	/** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** **
	 * Login warning message section
	 *
	 */
	$wp_customize->add_section( 'cc_caboodle_login_warning_section',
		array(
			'title'				=> esc_html__( 'Login warning message', 'cubecolour-caboodle' ),
			'description'		=> esc_html__( 'Extra text added to login form', 'cubecolour-caboodle' ),
			'panel'				=> 'cc_caboodle_panel'
		)
	);

	$wp_customize->add_setting('cc_caboodle[login_warning]', array(
		'default'		   => false,
		'sanitize_callback' => 'cc_toggle_control_sanitize',
		'type'				=> 'option',
		'transport'			=> 'postMessage',
	));
	$wp_customize->add_control( new Cubecolour_Toggle_Control(
		$wp_customize,
			'cc_caboodle_login_warning',
			array(
				'label'			=> esc_html__( 'Login warning message', 'cubecolour-caboodle' ),
				'type'	 		=> 'checkbox',
				'section'  		=> 'cc_caboodle_login_warning_section',
				'settings'		=> 'cc_caboodle[login_warning]',
			)
		)
	);


	$wp_customize->add_setting( 'cc_caboodle[login_warning_color]',
		array(
			'default'			=> '#777777',
			'sanitize_callback'	=> 'sanitize_hex_color',
			'type'				=> 'option',
			'transport'			=> 'postMessage',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize, 'cc_caboodle_login_warning_color',
			array(
				'label'			=> esc_html__( 'Text color', 'cubecolour-caboodle' ),
				'section'		=> 'cc_caboodle_login_warning_section',
				'settings'		=> 'cc_caboodle[login_warning_color]',
			)
		)
	);

	$wp_customize->add_setting( 'cc_caboodle[login_warning_heading]',
		array(
			'default'			=> esc_html__( 'Authorised access only', 'cubecolour-caboodle' ),
			'sanitize_callback'	=> 'sanitize_text_field',
			'type'				=> 'option',
			'transport'			=> 'refresh',
		)
	);
	$wp_customize->add_control( 'cc_caboodle_login_warning_heading',
		array(
			'label'				=> esc_html__( 'Title', 'cubecolour-caboodle' ),
			'section'			=> 'cc_caboodle_login_warning_section',
			'settings'			=> 'cc_caboodle[login_warning_heading]',
			'type'				=> 'text',
		)
	);
	
	$wp_customize->add_setting( 'cc_caboodle[login_warning_text]',
		array(
			'capability'		=> 'edit_theme_options',
			'default'			=> esc_html__( 'Disconnect immediately and do not attempt to log in if you are not an authorised user', 'cubecolour-caboodle' ),
			'sanitize_callback'	=> 'sanitize_textarea_field',
			'type'				=> 'option',
			'transport'			=> 'refresh',
		)
	);
	$wp_customize->add_control( 'cc_caboodle_login_warning_text',
		array(
			'label'				=> esc_html__( 'Message', 'cubecolour-caboodle' ),
			'section'			=> 'cc_caboodle_login_warning_section',
			'settings'			=> 'cc_caboodle[login_warning_text]',
			'type'				=> 'textarea',
		)
	);


	/** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** **
	 * Password visualisation section
	 *
	 */
	$wp_customize->add_section( 'cc_caboodle_passvis_section',
		array(
			'title'				=> esc_html__( 'Password visualisation', 'cubecolour-caboodle' ),
			'description'		=> esc_html__( 'Display colored bars for visual confirmation of password input', 'cubecolour-caboodle' ),
			'panel'				=> 'cc_caboodle_panel',
			'style'				=> 'margin-bottom 4px;'
		)
	);

	$wp_customize->add_setting('cc_caboodle[passvis]', array(
		'default'		   => false,
		'sanitize_callback' => 'cc_toggle_control_sanitize',
		'type'				=> 'option',
		'transport'			=> 'postMessage',
	));
	$wp_customize->add_control( new Cubecolour_Toggle_Control(
		$wp_customize,
			'cc_caboodle_passvis',
			array(
				'label'			=> esc_html__( 'Password visualisation', 'cubecolour-caboodle' ),
				'type'	 		=> 'checkbox',
				'section'  		=> 'cc_caboodle_passvis_section',
				'settings'		=> 'cc_caboodle[passvis]',
			)
		)
	);


	$wp_customize->add_setting( 'cc_caboodle[passvis_bars]',
		array(
			'default'			=> 4,
			'sanitize_callback'	=> 'absint',
			'type'				=> 'option',
			'transport'			=> 'postMessage',
		)
	);
	$wp_customize->add_control(
		new Cubecolour_Range_Value_Control(
			$wp_customize, 'cc_caboodle_passvis_bars', array(
				'label'				=> esc_html__( 'Number of bars', 'cubecolour-caboodle' ),
				'section'			=> 'cc_caboodle_passvis_section',
				'settings'			=> 'cc_caboodle[passvis_bars]',
				'type'				=> 'range',
				'input_attrs'		=> array(
					'min'				=> 1,
					'max'				=> 4,
					'step'				=> 1,
				)
			)
		)
	);

	$wp_customize->add_setting( 'cc_caboodle[passvis_salt]',
		array(
			'default'			=> cc_caboodle_passvis_random_hex(),
			'sanitize_callback'	=> 'cc_caboodle_passvis_sanitize_salt',
			'type'				=> 'option',
			'transport'			=> 'postMessage',
		)
	);
	$wp_customize->add_control( 'cc_caboodle_passvis_salt',
		array(
			'label'				=> esc_html__( 'Salt (random when blank)', 'cubecolour-caboodle' ),
			'section'			=> 'cc_caboodle_passvis_section',
			'settings'			=> 'cc_caboodle[passvis_salt]',
			'type'				=> 'text',
		)
	);

	$wp_customize->add_setting( 'cc_caboodle[passvis_onfront]', array(
			'default'			=> '',
			'sanitize_callback'	=> 'cc_caboodle_sanitize_checkbox',
			'type'				=> 'option',
			'transport'			=> 'postMessage',
		)
	);
	$wp_customize->add_control( 'cc_caboodle_passvis_onfront',
		array(
			'label'			=> esc_html__( 'Also include on frontend', 'cubecolour-caboodle' ),
			'section'		=> 'cc_caboodle_passvis_section',
			'settings'		=> 'cc_caboodle[passvis_onfront]',
			'type'			=> 'checkbox',
		)
	);

	/** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** **
	 * Open in new tab section (Admin toolbar 'view site' link )
	 *
	 */
	$wp_customize->add_section( 'cc_caboodle_new_tab_section',
		array(
			'title'				=> esc_html__( 'Open site in new tab', 'cubecolour-caboodle' ),
			'description'		=> esc_html__( 'Modify the view site link in admin to open in a new browser tab', 'cubecolour-caboodle' ),
			'panel'				=> 'cc_caboodle_panel'
		)
	);

	$wp_customize->add_setting('cc_caboodle[new_tab]', array(
		'default'		   => false,
		'sanitize_callback' => 'cc_toggle_control_sanitize',
		'type'				=> 'option',
		'transport'			=> 'postMessage',
	));
	$wp_customize->add_control( new Cubecolour_Toggle_Control(
		$wp_customize,
			'new_tab',
			array(
				'label'			=> esc_html__( 'Open site in new tab', 'cubecolour-caboodle' ),
				'type'	 		=> 'checkbox',
				'section'  		=> 'cc_caboodle_new_tab_section',
				'settings'		=> 'cc_caboodle[new_tab]',
			)
		)
	);

	/** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** **
	 * Replace WP logo section
	 *
	 */
	$wp_customize->add_section( 'cc_caboodle_replace_wplogo_section',
		array(
			'title'				=> esc_html__( 'Replace WordPress logo', 'cubecolour-caboodle' ),
			'description'		=> esc_html__( 'Replace the WP logo in the admin toolbar with the site icon if one is configured', 'cubecolour-caboodle' ),
			'panel'				=> 'cc_caboodle_panel'
		)
	);

	$wp_customize->add_setting('cc_caboodle[replace_wplogo]', array(
		'default'		   => false,
		'sanitize_callback' => 'cc_toggle_control_sanitize',
		'type'				=> 'option',
		'transport'			=> 'postMessage',
	));
	$wp_customize->add_control( new Cubecolour_Toggle_Control(
		$wp_customize,
			'replace_wplogo',
			array(
				'label'			=> esc_html__( 'Replace WP logo', 'cubecolour-caboodle' ),
				'type'	 		=> 'checkbox',
				'section'  		=> 'cc_caboodle_replace_wplogo_section',
				'settings'		=> 'cc_caboodle[replace_wplogo]',
			)
		)
	);

	/** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** **
	 * Dashboard notes section
	 *
	 */
	$wp_customize->add_section( 'cc_caboodle_dashboard_notes_section',
		array(
			'title'				=> esc_html__( 'Dashboard notes', 'cubecolour-caboodle' ),
			'description'		=> esc_html__( 'Adds a simple notepad widget to the dashboard', 'cubecolour-caboodle' ),
			'panel'				=> 'cc_caboodle_panel'
		)
	);

	$wp_customize->add_setting('cc_caboodle[dashboard_notes]', array(
		'default'		   => false,
		'sanitize_callback' => 'cc_toggle_control_sanitize',
		'type'				=> 'option',
		'transport'			=> 'postMessage',
	));
	$wp_customize->add_control( new Cubecolour_Toggle_Control(
		$wp_customize,
			'dashboard_notes',
			array(
				'label'			=> esc_html__( 'Dashboard notes', 'cubecolour-caboodle' ),
				'type'	 		=> 'checkbox',
				'section'  		=> 'cc_caboodle_dashboard_notes_section',
				'settings'		=> 'cc_caboodle[dashboard_notes]',
			)
		)
	);

	/** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** **
	 * Admin menu order section
	 *
	 */
	$wp_customize->add_section( 'cc_caboodle_admin_menu_order_section',
		array(
			'title'				=> esc_html__( 'Admin menu order', 'cubecolour-caboodle' ),
			'description'		=> esc_html__( 'Rearranges admin menu items: dashboard, pages, posts, media', 'cubecolour-caboodle' ),
			'panel'				=> 'cc_caboodle_panel'
		)
	);

	$wp_customize->add_setting('cc_caboodle[admin_menu_order]', array(
		'default'		   => false,
		'sanitize_callback' => 'cc_toggle_control_sanitize',
		'type'				=> 'option',
		'transport'			=> 'refresh',
	));
	$wp_customize->add_control( new Cubecolour_Toggle_Control(
		$wp_customize,
			'cc_caboodle_admin_menu_order',
			array(
				'label'			=> esc_html__( 'Admin menu order', 'cubecolour-caboodle' ),
				'type'	 		=> 'checkbox',
				'section'  		=> 'cc_caboodle_admin_menu_order_section',
				'settings'		=> 'cc_caboodle[admin_menu_order]',
			)
		)
	);


	/** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** **
	 * No avatars section
	 *
	 */
	$wp_customize->add_section( 'cc_caboodle_no_avatars_section',
		array(
			'title'				=> esc_html__( 'No avatars', 'cubecolour-caboodle' ),
			'description'		=> esc_html__( 'Remove support for gravatars or user avatars', 'cubecolour-caboodle' ),
			'panel'				=> 'cc_caboodle_panel'
		)
	);

				$wp_customize->add_setting( 'cc_caboodle[no_avatars]',
					array(
						'default'			=> '',
						'sanitize_callback'	=> 'cc_caboodle_sanitize_checkbox',
						'type'				=> 'option',
						'transport'			=> 'postMessage',
					)
				);
				$wp_customize->add_control( new Cubecolour_Toggle_Control(
					$wp_customize,
						'cc_caboodle_no_avatars',
						array(
							'label'			=> esc_html__( 'No avatars', 'cubecolour-caboodle' ),
							'section'		=> 'cc_caboodle_no_avatars_section',
							'settings'		=> 'cc_caboodle[no_avatars]',
						)
					)
				);


	/** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** **
	 * Show IDs in admin section
	 *
	 */
	$wp_customize->add_section( 'cc_caboodle_show_ids_section',
		array(
			'title'				=> esc_html__( 'Show IDs', 'cubecolour-caboodle' ),
			'description'		=> esc_html__( 'Show the ID for posts, pages, custom post types, taxonomies, media and user IDs in the admin pages', 'cubecolour-caboodle' ),
			'panel'				=> 'cc_caboodle_panel'
		)
	);

	$wp_customize->add_setting('cc_caboodle[show_ids]', array(
		'default'		   => false,
		'sanitize_callback' => 'cc_toggle_control_sanitize',
		'type'				=> 'option',
		'transport'			=> 'postMessage',
	));
	$wp_customize->add_control( new Cubecolour_Toggle_Control(
		$wp_customize,
			'cc_caboodle_show_ids',
			array(
				'label'			=> esc_html__( 'Show IDs', 'cubecolour-caboodle' ),
				'type'	 		=> 'checkbox',
				'section'  		=> 'cc_caboodle_show_ids_section',
				'settings'		=> 'cc_caboodle[show_ids]',
			)
		)
	);

	$wp_customize->add_setting('cc_caboodle[show_ids_posts]', array(
		'default'		   => false,
		'sanitize_callback' => 'cc_toggle_control_sanitize',
		'type'				=> 'option',
		'transport'			=> 'postMessage',
	));
	$wp_customize->add_control( new Cubecolour_Toggle_Control(
		$wp_customize,
			'cc_caboodle_show_ids_posts',
			array(
				'label'			=> esc_html__( 'Posts, pages, post types', 'cubecolour-caboodle' ),
				'type'	 		=> 'checkbox',
				'section'  		=> 'cc_caboodle_show_ids_section',
				'settings'		=> 'cc_caboodle[show_ids_posts]',
			)
		)
	);

	$wp_customize->add_setting('cc_caboodle[show_ids_media]', array(
		'default'		   => false,
		'sanitize_callback' => 'cc_toggle_control_sanitize',
		'type'				=> 'option',
		'transport'			=> 'postMessage',
	));
	$wp_customize->add_control( new Cubecolour_Toggle_Control(
		$wp_customize,
			'cc_caboodle_show_ids_media',
			array(
				'label'			=> esc_html__( 'Media', 'cubecolour-caboodle' ),
				'type'	 		=> 'checkbox',
				'section'  		=> 'cc_caboodle_show_ids_section',
				'settings'		=> 'cc_caboodle[show_ids_media]',
			)
		)
	);

	$wp_customize->add_setting('cc_caboodle[show_ids_taxonomies]', array(
		'default'		   => false,
		'sanitize_callback' => 'cc_toggle_control_sanitize',
		'type'				=> 'option',
		'transport'			=> 'postMessage',
	));
	$wp_customize->add_control( new Cubecolour_Toggle_Control(
		$wp_customize,
			'cc_caboodle_show_ids_taxonomies',
			array(
				'label'			=> esc_html__( 'Taxonomies', 'cubecolour-caboodle' ),
				'type'	 		=> 'checkbox',
				'section'  		=> 'cc_caboodle_show_ids_section',
				'settings'		=> 'cc_caboodle[show_ids_taxonomies]',
			)
		)
	);

	$wp_customize->add_setting('cc_caboodle[show_ids_users]', array(
		'default'		   => false,
		'sanitize_callback' => 'cc_toggle_control_sanitize',
		'type'				=> 'option',
		'transport'			=> 'postMessage',
	));
	$wp_customize->add_control( new Cubecolour_Toggle_Control(
		$wp_customize,
			'cc_caboodle_show_ids_users',
			array(
				'label'			=> esc_html__( 'Users', 'cubecolour-caboodle' ),
				'type'	 		=> 'checkbox',
				'section'  		=> 'cc_caboodle_show_ids_section',
				'settings'		=> 'cc_caboodle[show_ids_users]',
			)
		)
	);

	$wp_customize->add_setting('cc_caboodle[show_ids_comments]', array(
		'default'		   => false,
		'sanitize_callback' => 'cc_toggle_control_sanitize',
		'type'				=> 'option',
		'transport'			=> 'postMessage',
	));
	$wp_customize->add_control( new Cubecolour_Toggle_Control(
		$wp_customize,
			'cc_caboodle_show_ids_comments',
			array(
				'label'			=> esc_html__( 'Comments', 'cubecolour-caboodle' ),
				'type'	 		=> 'checkbox',
				'section'  		=> 'cc_caboodle_show_ids_section',
				'settings'		=> 'cc_caboodle[show_ids_comments]',
			)
		)
	);

	$wp_customize->add_setting('cc_caboodle[show_ids_links]', array(
		'default'		   => false,
		'sanitize_callback' => 'cc_toggle_control_sanitize',
		'type'				=> 'option',
		'transport'			=> 'postMessage',
	));
	$wp_customize->add_control( new Cubecolour_Toggle_Control(
		$wp_customize,
			'cc_caboodle_show_ids_links',
			array(
				'label'			=> esc_html__( 'Links', 'cubecolour-caboodle' ),
				'type'	 		=> 'checkbox',
				'section'  		=> 'cc_caboodle_show_ids_section',
				'settings'		=> 'cc_caboodle[show_ids_links]',
			)
		)
	);


	/** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** **
	 * Show current WP version customizer section
	 *
	 ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** **  **
	 */
	$wp_customize->add_section( 'cc_caboodle_current_version_section',
		array(
			'title'				=> esc_html__( 'Show current WP version', 'cubecolour-caboodle' ),
			'description'		=> esc_html__( 'Show the current WordPress version in the admin footer when an upgrade is available', 'cubecolour-caboodle' ),
			'panel'				=> 'cc_caboodle_panel'
		)
	);

	$wp_customize->add_setting('cc_caboodle[current_version]', array(
		'default'		   => false,
		'sanitize_callback' => 'cc_toggle_control_sanitize',
		'type'				=> 'option',
		'transport'			=> 'postMessage',
	));
	$wp_customize->add_control( new Cubecolour_Toggle_Control(
		$wp_customize,
			'cc_caboodle_current_version',
			array(
				'label'			=> esc_html__( 'Show WordPress version', 'cubecolour-caboodle' ),
				'type'	 		=> 'checkbox',
				'section'  		=> 'cc_caboodle_current_version_section',
				'settings'		=> 'cc_caboodle[current_version]',
			)
		)
	);


	/** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** **
	 * No howdy section
	 *
	 ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** **  **
	 */
	$wp_customize->add_section( 'cc_caboodle_no_howdy_section',
		array(
			'title'				=> esc_html__( 'No howdy', 'cubecolour-caboodle' ),
			'description'		=> esc_html__( 'Replace the howdy greeting with a salutation appropriate to the time of day', 'cubecolour-caboodle' ),
			'panel'				=> 'cc_caboodle_panel'
		)
	);

	$wp_customize->add_setting('cc_caboodle[no_howdy]', array(
		'default'		   => false,
		'sanitize_callback' => 'cc_toggle_control_sanitize',
		'type'				=> 'option',
		'transport'			=> 'postMessage',
	));
	$wp_customize->add_control( new Cubecolour_Toggle_Control(
		$wp_customize,
			'cc_caboodle_no_howdy',
			array(
				'label'			=> esc_html__( 'No howdy', 'cubecolour-caboodle' ),
				'type'	 		=> 'checkbox',
				'section'  		=> 'cc_caboodle_no_howdy_section',
				'settings'		=> 'cc_caboodle[no_howdy]',
			)
		)
	);

	$wp_customize->add_setting( 'cc_caboodle[no_howdy_morning]',
		array(
			'default'			=> esc_html__( 'Good morning', 'cubecolour-caboodle' ),
			'sanitize_callback'	=> 'sanitize_text_field',
			'type'				=> 'option',
			'transport'			=> 'postMessage',
		)
	);
	$wp_customize->add_control( 'cc_caboodle_no_howdy_morning',
		array(
			'label'				=> esc_html__( 'Morning greeting', 'cubecolour-caboodle' ),
			'section'			=> 'cc_caboodle_no_howdy_section',
			'settings'			=> 'cc_caboodle[no_howdy_morning]',
			'type'				=> 'text',
		)
	);

	$wp_customize->add_setting( 'cc_caboodle[no_howdy_afternoon]',
		array(
			'default'			=> esc_html__( 'Good afternoon', 'cubecolour-caboodle' ),
			'sanitize_callback'	=> 'sanitize_text_field',
			'type'				=> 'option',
			'transport'			=> 'postMessage',
		)
	);
	$wp_customize->add_control( 'cc_caboodle_no_howdy_afternoon',
		array(
			'label'				=> esc_html__( 'Afternoon greeting', 'cubecolour-caboodle' ),
			'section'			=> 'cc_caboodle_no_howdy_section',
			'settings'			=> 'cc_caboodle[no_howdy_afternoon]',
			'type'				=> 'text',
		)
	);

	$wp_customize->add_setting( 'cc_caboodle[no_howdy_evening]',
		array(
			'default'			=> esc_html__( 'Good evening', 'cubecolour-caboodle' ),
			'sanitize_callback'	=> 'sanitize_text_field',
			'type'				=> 'option',
			'transport'			=> 'postMessage',
		)
	);
	$wp_customize->add_control( 'cc_caboodle_no_howdy_evening',
		array(
			'label'				=> esc_html__( 'Evening greeting', 'cubecolour-caboodle' ),
			'section'			=> 'cc_caboodle_no_howdy_section',
			'settings'			=> 'cc_caboodle[no_howdy_evening]',
			'type'				=> 'text',
		)
	);

	$wp_customize->add_setting( 'cc_caboodle[no_howdy_night]',
		array(
			'default'			=> esc_html__( 'Go to bed', 'cubecolour-caboodle' ),
			'sanitize_callback'	=> 'sanitize_text_field',
			'type'				=> 'option',
			'transport'			=> 'postMessage',
		)
	);
	$wp_customize->add_control( 'cc_caboodle_no_howdy_night',
		array(
			'label'				=> esc_html__( 'Night greeting', 'cubecolour-caboodle' ),
			'section'			=> 'cc_caboodle_no_howdy_section',
			'settings'			=> 'cc_caboodle[no_howdy_night]',
			'type'				=> 'text',
		)
	);


	/** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** **
	 * Limit revisions section
	 *
	 */
	$wp_customize->add_section( 'cc_caboodle_limit_revisions_section',
		array(
			'title'				=> esc_html__( 'Revisions', 'cubecolour-caboodle' ),
			'description'		=> esc_html__( 'Limit the number of saved revisions', 'cubecolour-caboodle' ),
			'panel'				=> 'cc_caboodle_panel'
		)
	);

	$wp_customize->add_setting('cc_caboodle[limit_revisions]', array(
		'default'		   => false,
		'sanitize_callback' => 'cc_toggle_control_sanitize',
		'type'				=> 'option',
		'transport'			=> 'postMessage',
	));
	$wp_customize->add_control( new Cubecolour_Toggle_Control(
		$wp_customize,
			'cc_caboodle_limit_revisions',
			array(
				'label'			=> esc_html__( 'Limit revisions', 'cubecolour-caboodle' ),
				'type'	 		=> 'checkbox',
				'section'  		=> 'cc_caboodle_limit_revisions_section',
				'settings'		=> 'cc_caboodle[limit_revisions]',
			)
		)
	);

	$wp_customize->add_setting( 'cc_caboodle[limit_revisions_qty]',
		array(
			'default'			=> -1,
			'sanitize_callback'	=> 'cc_caboodle_sanitize_limit_revisions_qty',
			'type'				=> 'option',
			'transport'			=> 'postMessage',
		)
	);
	$wp_customize->add_control( 'cc_caboodle_limit_revisions_qty',
		array(
			'type'				=> 'select',
			'section'			=> 'cc_caboodle_limit_revisions_section',
			'settings'			=> 'cc_caboodle[limit_revisions_qty]',
			'label'				=> esc_html__( 'Number of Revisions to save', 'cubecolour-caboodle' ),

			'choices'	=> array(
				0			=> esc_html__( 'None', 'cubecolour-caboodle' ),
				1			=> '1',
				2			=> '2',
				3			=> '3',
				4			=> '4',
				5			=> '5',
				10			=> '10',
				25			=> '25',
				50			=> '50',
				-1			=> esc_html__( 'Unlimited', 'cubecolour-caboodle' ),
			),
		)
	);


	/** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** **
	 * Developer link section
	 *
	 */
	$wp_customize->add_section( 'cc_caboodle_devlink_section',
		array(
			'title'				=> esc_html__( 'Developer link', 'cubecolour-caboodle' ),
				'description'	=> esc_html__( 'Developer link in admin footer and [developer] shortcode for front end', 'cubecolour-caboodle' ),
			'panel'				=> 'cc_caboodle_panel'
		)
	);

	$wp_customize->add_setting('cc_caboodle[devlink]', array(
		'default'		   => false,
		'sanitize_callback' => 'cc_toggle_control_sanitize',
		'type'				=> 'option',
		'transport'			=> 'refresh',
	));
	$wp_customize->add_control( new Cubecolour_Toggle_Control(
		$wp_customize,
			'cc_caboodle_devlink',
			array(
				'label'			=> esc_html__( 'Developer link', 'cubecolour-caboodle' ),
				'type'	 		=> 'checkbox',
				'section'  		=> 'cc_caboodle_devlink_section',
				'settings'		=> 'cc_caboodle[devlink]',
			)
		)
	);

	$wp_customize->add_setting( 'cc_caboodle[devlink_name]',
		array(
			'default'			=> '',
			'sanitize_callback'	=> 'sanitize_text_field',
			'type'				=> 'option',
			'transport'			=> 'postMessage',
		)
	);
	$wp_customize->add_control( 'cc_caboodle_devlink_name',
		array(
			'label'				=> esc_html__( 'Developer name', 'cubecolour-caboodle' ),
			'section'			=> 'cc_caboodle_devlink_section',
			'settings'			=> 'cc_caboodle[devlink_name]',
			'type'				=> 'text',
		)
	);

	$wp_customize->add_setting( 'cc_caboodle[devlink_url]',
		array(
			'default'			=> '',
			'sanitize_callback' => 'esc_url_raw',
			'type'				=> 'option',
			'transport'			=> 'postMessage',
		)
	);
	$wp_customize->add_control( 'cc_caboodle_devlink_url',
		array(
			'label'				=> esc_html__( 'Developer link URL', 'cubecolour-caboodle' ),
			'settings'			=> 'cc_caboodle[devlink_url]',
			'section'			=> 'cc_caboodle_devlink_section',
			'type'				=> 'url',
		)
	);


	/** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** **
	 * Show site settings section
	 *
	 */
	$wp_customize->add_section( 'cc_caboodle_show_site_settings_section',
		array(
			'title'				=> esc_html__( 'Show settings', 'cubecolour-caboodle' ),
			'description'		=> esc_html__( 'Adds a link in admin settings menu to view saved options', 'cubecolour-caboodle' ),
			'panel'				=> 'cc_caboodle_panel'
		)
	);

	$wp_customize->add_setting('cc_caboodle[show_site_settings]', array(
		'default'		   => false,
		'sanitize_callback' => 'cc_toggle_control_sanitize',
		'type'				=> 'option',
		'transport'			=> 'postMessage',
	));
	$wp_customize->add_control( new Cubecolour_Toggle_Control(
		$wp_customize,
			'cc_caboodle_show_site_settings_loading',
			array(
				'label'			=> esc_html__( 'Show settings', 'cubecolour-caboodle' ),
				'type'	 		=> 'checkbox',
				'section'  		=> 'cc_caboodle_show_site_settings_section',
				'settings'		=> 'cc_caboodle[show_site_settings]',
			)
		)
	);


	/** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** **
	 * New Plugins Section
	 *
	 */
	$wp_customize->add_section( 'cc_caboodle_new_plugins_section',
		array(
			'title'				=> esc_html__( 'New plugins', 'cubecolour-caboodle' ),
			'description'		=> esc_html__( 'Add "New" & "Beta" links to the add plugins page', 'cubecolour-caboodle' ),
			'panel'				=> 'cc_caboodle_panel'
		)
	);

	$wp_customize->add_setting('cc_caboodle[new_plugins]', array(
		'default'		   => false,
		'sanitize_callback' => 'cc_toggle_control_sanitize',
		'type'				=> 'option',
		'transport'			=> 'postMessage',
	));
	$wp_customize->add_control( new Cubecolour_Toggle_Control(
		$wp_customize,
			'cc_caboodle_new_plugins',
			array(
				'label'			=> esc_html__( 'New plugins', 'cubecolour-caboodle' ),
				'type'	 		=> 'checkbox',
				'section'  		=> 'cc_caboodle_new_plugins_section',
				'settings'		=> 'cc_caboodle[new_plugins]',
			)
		)
	);


	/** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** **
	 * Preloading Section
	 *
	 */
	$wp_customize->add_section( 'cc_caboodle_preloading_section',
		array(
			'title'				=> esc_html__( 'Preloading', 'cubecolour-caboodle' ),
			'description'		=> esc_html__( 'Speed up browsing between pages', 'cubecolour-caboodle' ),
			'panel'				=> 'cc_caboodle_panel'
		)
	);

	$wp_customize->add_setting('cc_caboodle[preloading]', array(
		'default'		   => false,
		'sanitize_callback' => 'cc_toggle_control_sanitize',
		'type'				=> 'option',
		'transport'			=> 'postMessage',
	));
	$wp_customize->add_control( new Cubecolour_Toggle_Control(
		$wp_customize,
			'cc_caboodle_preloading',
			array(
				'label'			=> esc_html__( 'Preloading', 'cubecolour-caboodle' ),
				'type'	 		=> 'checkbox',
				'section'  		=> 'cc_caboodle_preloading_section',
				'settings'		=> 'cc_caboodle[preloading]',
			)
		)
	);


	/** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** **
	 * Force scrollbar section (vertical scrollbar)
	 *
	 */
	$wp_customize->add_section( 'cc_caboodle_force_scrollbar_section',
		array(
			'title'				=> esc_html__( 'Force vertical scrollbar', 'cubecolour-caboodle' ),
			'description'		=> esc_html__( 'Prevent layout shift between long and short pages', 'cubecolour-caboodle' ),
			'panel'				=> 'cc_caboodle_panel'
		)
	);

	$wp_customize->add_setting('cc_caboodle[force_scrollbar]', array(
		'default'		   => false,
		'sanitize_callback' => 'cc_toggle_control_sanitize',
		'type'				=> 'option',
		'transport'			=> 'refresh',
	));
	$wp_customize->add_control( new Cubecolour_Toggle_Control(
		$wp_customize,
			'cc_caboodle_force_scrollbar',
			array(
				'label'			=> esc_html__( 'Force vertical scrollbar', 'cubecolour-caboodle' ),
				'type'	 		=> 'checkbox',
				'section'  		=> 'cc_caboodle_force_scrollbar_section',
				'settings'		=> 'cc_caboodle[force_scrollbar]',
			)
		)
	);


	/** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** **
	 * scroll to anchor section
	 *
	 */
	$wp_customize->add_section( 'cc_caboodle_scroll_to_anchor_section',
		array(
			'title'				=> esc_html__( 'Scroll to anchor', 'cubecolour-caboodle' ),
			'description'		=> esc_html__( 'Smoothly animate when clicking a link targeting an anchored position', 'cubecolour-caboodle' ),
			'panel'				=> 'cc_caboodle_panel'
		)
	);

	$wp_customize->add_setting('cc_caboodle[scroll_to_anchor]', array(
		'default'		   => false,
		'sanitize_callback' => 'cc_toggle_control_sanitize',
		'type'				=> 'option',
		'transport'			=> 'refresh',
	));
	$wp_customize->add_control( new Cubecolour_Toggle_Control(
		$wp_customize,
			'cc_caboodle_scroll_to_anchor',
			array(
				'label'			=> esc_html__( 'Scroll to anchor', 'cubecolour-caboodle' ),
				'type'	 		=> 'checkbox',
				'section'  		=> 'cc_caboodle_scroll_to_anchor_section',
				'settings'		=> 'cc_caboodle[scroll_to_anchor]',
			)
		)
	);


	/** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** **
	 * Text selection section
	 *
	 */
	$wp_customize->add_section( 'cc_caboodle_text_selection_section',
		array(
			'title'				=> esc_html__( 'Text selection', 'cubecolour-caboodle' ),
			'description'		=> esc_html__( 'Color and background color of selected text', 'cubecolour-caboodle' ),
			'panel'				=> 'cc_caboodle_panel'
		)
	);

	$wp_customize->add_setting('cc_caboodle[text_selection]', array(
		'default'		   => false,
		'sanitize_callback' => 'cc_toggle_control_sanitize',
		'type'				=> 'option',
		'transport'			=> 'refresh',
	));
	$wp_customize->add_control( new Cubecolour_Toggle_Control(
		$wp_customize,
			'cc_caboodle_text_selection',
			array(
				'label'			=> esc_html__( 'Text selection', 'cubecolour-caboodle' ),
				'type'	 		=> 'checkbox',
				'section'  		=> 'cc_caboodle_text_selection_section',
				'settings'		=> 'cc_caboodle[text_selection]',
			)
		)
	);

	$wp_customize->add_setting( 'cc_caboodle[text_selection_color]',
		array(
			'default'			=> '#ffffff',
			'sanitize_callback'	=> 'sanitize_hex_color',
			'type'				=> 'option',
			'transport'			=> 'postMessage',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize, 'cc_caboodle_text_selection_color',
			array(
				'label'			=> esc_html__( 'Text color', 'cubecolour-caboodle' ),
				'section'		=> 'cc_caboodle_text_selection_section',
				'settings'		=> 'cc_caboodle[text_selection_color]',
			)
		)
	);

	$wp_customize->add_setting( 'cc_caboodle[text_selection_bgcolor]',
		array(
			'default'			=> '#ff69b4',
			'sanitize_callback'	=> 'sanitize_hex_color',
			'type'				=> 'option',
			'transport'			=> 'postMessage',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize, 'cc_caboodle_text_selection_bgcolor',
			array(
				'label'			=> esc_html__( 'Background color', 'cubecolour-caboodle' ),
				'section'		=> 'cc_caboodle_text_selection_section',
				'settings'		=> 'cc_caboodle[text_selection_bgcolor]',
			)
		)
	);


	/** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** **
	 * Page slug body class section
	 *
	 */
	$wp_customize->add_section( 'cc_caboodle_page_slug_body_class_section',
		array(
			'title'				=> esc_html__( 'Page slug body class', 'cubecolour-caboodle' ),
			'description'		=> esc_html__( 'Add a page slug class to the body tag', 'cubecolour-caboodle' ),
			'panel'				=> 'cc_caboodle_panel'
		)
	);

	$wp_customize->add_setting('cc_caboodle[page_slug_body_class]', array(
		'default'		   => false,
		'sanitize_callback' => 'cc_toggle_control_sanitize',
		'type'				=> 'option',
		'transport'			=> 'refresh',
	));
	$wp_customize->add_control( new Cubecolour_Toggle_Control(
		$wp_customize,
			'cc_caboodle_page_slug_body_class',
			array(
				'label'			=> esc_html__( 'Page slug body class', 'cubecolour-caboodle' ),
				'type'	 		=> 'checkbox',
				'section'  		=> 'cc_caboodle_page_slug_body_class_section',
				'settings'		=> 'cc_caboodle[page_slug_body_class]',
			)
		)
	);


	/** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** **
	 * Dash spacing section
	 *
	 */
	$wp_customize->add_section( 'cc_caboodle_dash_spacing_section',
		array(
			'title'				=> esc_html__( 'Dash spacing', 'cubecolour-caboodle' ),
			'description'		=> esc_html__( 'Replace the spaces around en-dashes & em-dashes with hairspaces', 'cubecolour-caboodle' ),
			'panel'				=> 'cc_caboodle_panel'
		)
	);

	$wp_customize->add_setting('cc_caboodle[dash_spacing]', array(
		'default'		   => false,
		'sanitize_callback' => 'cc_toggle_control_sanitize',
		'type'				=> 'option',
		'transport'			=> 'refresh',
	));
	$wp_customize->add_control( new Cubecolour_Toggle_Control(
		$wp_customize,
			'cc_caboodle_dash_spacing',
			array(
				'label'			=> esc_html__( 'Dash spacing', 'cubecolour-caboodle' ),
				'type'	 		=> 'checkbox',
				'section'  		=> 'cc_caboodle_dash_spacing_section',
				'settings'		=> 'cc_caboodle[dash_spacing]',
			)
		)
	);


	/** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** **
	 * Posts default post-type section
	 *
	 */
	$wp_customize->add_section( 'cc_caboodle_posts_section',
		array(
			'title'				=> esc_html__( 'Posts', 'cubecolour-caboodle' ),
			'description'		=> esc_html__( 'Remove or rename the posts post type', 'cubecolour-caboodle' ),
			'panel'				=> 'cc_caboodle_panel'
		)
	);

	$wp_customize->add_setting( 'cc_caboodle[posts]',
		array(
			'default'			=> '',
			'sanitize_callback'	=> 'cc_caboodle_sanitize_posts',
			'type'				=> 'option',
			'transport'			=> 'refresh',
		)
	);
	$wp_customize->add_control( 'cc_caboodle_posts',
		array(
			'type'				=> 'select',
			'section'			=> 'cc_caboodle_posts_section',
			'settings'			=> 'cc_caboodle[posts]',
			'label'				=> esc_html__( 'Posts post type', 'cubecolour-caboodle' ),

			'choices'		=> array(
				''				=>		esc_html__( 'Keep posts', 'cubecolour-caboodle' ),
				'rename_news'	=>		esc_html__( 'Rename posts to news', 'cubecolour-caboodle' ),
				'remove'		=>		esc_html__( 'Remove posts', 'cubecolour-caboodle' ),
			),
		)
	);


	/** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** **
	 * Caboodle page excerpts section
	 *
	 */
	$wp_customize->add_section( 'cc_caboodle_page_excerpts_section',
		array(
			'title'				=> esc_html__( 'Page excerpts', 'cubecolour-caboodle' ),
			'description'		=> esc_html__( 'Add support for manual excerpts to pages', 'cubecolour-caboodle' ),
			'panel'				=> 'cc_caboodle_panel'
		)
	);

	$wp_customize->add_setting('cc_caboodle[page_excerpts]', array(
		'default'		   => false,
		'sanitize_callback' => 'cc_toggle_control_sanitize',
		'type'				=> 'option',
		'transport'			=> 'postMessage',
	));
	$wp_customize->add_control( new Cubecolour_Toggle_Control(
		$wp_customize,
			'cc_caboodle_page_excerpts',
			array(
				'label'			=> esc_html__( 'Page excerpts', 'cubecolour-caboodle' ),
				'type'	 		=> 'checkbox',
				'section'  		=> 'cc_caboodle_page_excerpts_section',
				'settings'		=> 'cc_caboodle[page_excerpts]',
			)
		)
	);


	/** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** **
	 * Caboodle page excerpts section
	 *
	 */
	$wp_customize->add_section( 'cc_caboodle_page_excerpts_section',
		array(
			'title'				=> esc_html__( 'Page excerpts', 'cubecolour-caboodle' ),
			'description'		=> esc_html__( 'Add support for manual excerpts to pages', 'cubecolour-caboodle' ),
			'panel'				=> 'cc_caboodle_panel'
		)
	);

	$wp_customize->add_setting('cc_caboodle[page_excerpts]', array(
		'default'		   => false,
		'sanitize_callback' => 'cc_toggle_control_sanitize',
		'type'				=> 'option',
		'transport'			=> 'postMessage',
	));
	$wp_customize->add_control( new Cubecolour_Toggle_Control(
		$wp_customize,
			'cc_caboodle_page_excerpts',
			array(
				'label'			=> esc_html__( 'Page excerpts', 'cubecolour-caboodle' ),
				'type'	 		=> 'checkbox',
				'section'  		=> 'cc_caboodle_page_excerpts_section',
				'settings'		=> 'cc_caboodle[page_excerpts]',
			)
		)
	);


	/** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** **
	 * Unlink parent menu items
	 */
	$wp_customize->add_section( 'cc_caboodle_unlink_parent_section',
		array(
			'title'				=> esc_html__( 'Unlink parent menu items', 'cubecolour-caboodle' ),
			'description'		=> esc_html__( 'Enable drop down menus to work more intuitively', 'cubecolour-caboodle' ),
			'panel'				=> 'cc_caboodle_panel'
		)
	);

	$wp_customize->add_setting('cc_caboodle[unlink_parent]', array(
		'default'		   => false,
		'sanitize_callback' => 'cc_toggle_control_sanitize',
		'type'				=> 'option',
		'transport'			=> 'refresh',
	));
	$wp_customize->add_control( new Cubecolour_Toggle_Control(
		$wp_customize,
			'cc_caboodle_unlink_parent',
			array(
				'label'			=> esc_html__( 'Unlink parent menu items', 'cubecolour-caboodle' ),
				'type'	 		=> 'checkbox',
				'section'  		=> 'cc_caboodle_unlink_parent_section',
				'settings'		=> 'cc_caboodle[unlink_parent]',
			)
		)
	);


	/** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** **
	 * Indicate External Links
	 */
	$wp_customize->add_section( 'cc_caboodle_extlink_section',
		array(
			'title'				=> esc_html__( 'Indicate external links', 'cubecolour-caboodle' ),
			'description'		=> esc_html__( 'Add an icon to links which direct offsite', 'cubecolour-caboodle' ),
			'panel'				=> 'cc_caboodle_panel',
		)
	);


	$wp_customize->add_setting('cc_caboodle[extlink]', array(
		'default'		   => false,
		'sanitize_callback' => 'cc_toggle_control_sanitize',
		'type'				=> 'option',
		'transport'			=> 'refresh',
	));
	$wp_customize->add_control( new Cubecolour_Toggle_Control(
		$wp_customize,
			'cc_caboodle_extlink',
			array(
				'label'			=> esc_html__( 'Indicate external links', 'cubecolour-caboodle' ),
				'type'	 		=> 'checkbox',
				'section'  		=> 'cc_caboodle_extlink_section',
				'settings'		=> 'cc_caboodle[extlink]',
			)
		)
	);
	
	$wp_customize->add_setting('cc_caboodle[extlink_icon]',
		array(
			'default'			=> '\\e806',
			'sanitize_callback'	=> 'cc_caboodle_sanitize_extlink_icon',
			'transport'			=> 'postMessage',
			'type'				=> 'option',
		)
	);
	$wp_customize->add_control( new Cubecolour_Image_Radio_Control (
		$wp_customize,
			'cc_caboodle_extlink_icon', array(
				'type'			=> 'radio',
				'label'			=> esc_html__( 'Icon', 'cubecolour-caboodle' ),
				'section'		=> 'cc_caboodle_extlink_section',
				'settings'		=> 'cc_caboodle[extlink_icon]',
				'choices'		=> array(
					'\\f08e' 		=> CC_CABOODLE_PLUGIN_URL . '/images/extlink-icons/11.svg',
					'\\e80d' 		=> CC_CABOODLE_PLUGIN_URL . '/images/extlink-icons/21.svg',
					'\\e809' 		=> CC_CABOODLE_PLUGIN_URL . '/images/extlink-icons/31.svg',
					'\\e80f' 		=> CC_CABOODLE_PLUGIN_URL . '/images/extlink-icons/12.svg',
					'\\e80b' 		=> CC_CABOODLE_PLUGIN_URL . '/images/extlink-icons/22.svg',
					'\\e807' 		=> CC_CABOODLE_PLUGIN_URL . '/images/extlink-icons/32.svg',
					'\\f14c' 		=> CC_CABOODLE_PLUGIN_URL . '/images/extlink-icons/13.svg',
					'\\e80c' 		=> CC_CABOODLE_PLUGIN_URL . '/images/extlink-icons/23.svg',
					'\\e808' 		=> CC_CABOODLE_PLUGIN_URL . '/images/extlink-icons/33.svg',
					'\\e80e' 		=> CC_CABOODLE_PLUGIN_URL . '/images/extlink-icons/14.svg',
					'\\e80a' 		=> CC_CABOODLE_PLUGIN_URL . '/images/extlink-icons/24.svg',
					'\\e806' 		=> CC_CABOODLE_PLUGIN_URL . '/images/extlink-icons/34.svg',
				)
			)
		)
	);

	$wp_customize->add_setting( 'cc_caboodle[extlink_size]',
		array(
			'default'			=> 16,
			'sanitize_callback'	=> 'cc_caboodle_sanitize_extlink_size',
			'type'				=> 'option',
			'transport'			=> 'postMessage',
		)
	);
	$wp_customize->add_control(
		new Cubecolour_Range_Value_Control(
			$wp_customize, 'cc_caboodle_extlink_size', array(
				'label'				=> esc_html__( 'Size (px)', 'cubecolour-caboodle' ),
				'section'			=> 'cc_caboodle_extlink_section',
				'settings'			=> 'cc_caboodle[extlink_size]',
				'type'				=> 'range',
				'input_attrs'		=> array(
					'min'				=> 10,
					'max'				=> 36,
					'step'				=> 1,
				)
			)
		)
	);

	$wp_customize->add_setting( 'cc_caboodle[extlink_vpos]',
		array(
			'default'			=> 0,
			'sanitize_callback'	=> 'cc_caboodle_sanitize_extlink_vpos',
			'type'				=> 'option',
			'transport'			=> 'postMessage',
		)
	);
	$wp_customize->add_control(
		new Cubecolour_Range_Value_Control(
			$wp_customize, 'cc_caboodle_extlink_vpos', array(
				'label'				=> esc_html__( 'Vertical position (px)', 'cubecolour-caboodle' ),
				'section'			=> 'cc_caboodle_extlink_section',
				'settings'			=> 'cc_caboodle[extlink_vpos]',
				'type'				=> 'range',
				'input_attrs'		=> array(
					'min'				=> -8,
					'max'				=> 24,
					'step'				=> 1,
				)
			)
		)
	);

	$wp_customize->add_setting( 'cc_caboodle[extlink_color]',
		array(
			'default'			=> '',
			'sanitize_callback'	=> 'sanitize_hex_color',
			'type'				=> 'option',
			'transport'			=> 'postMessage',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize, 'cc_caboodle_extlink_color',
			array(
				'label'			=> esc_html__( 'Color', 'cubecolour-caboodle' ),
				'section'		=> 'cc_caboodle_extlink_section',
				'settings'		=> 'cc_caboodle[extlink_color]',
			)
		)
	);

	$wp_customize->add_setting( 'cc_caboodle[extlink_color_hover]',
		array(
			'default'			=> '',
			'sanitize_callback'	=> 'sanitize_hex_color',
			'type'				=> 'option',
			'transport'			=> 'postMessage',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize, 'cc_caboodle_extlink_color_hover',
			array(
				'label'			=> esc_html__( 'Hover color', 'cubecolour-caboodle' ),
				'section'		=> 'cc_caboodle_extlink_section',
				'settings'		=> 'cc_caboodle[extlink_color_hover]',
			)
		)
	);


	/**
	* Separator 1
	*
	*/
	$wp_customize->add_setting('separator_1', array(
			'default'		   => '',
			'sanitize_callback' => 'esc_html',
	));
	$wp_customize->add_control(new Cubecolour_Separator_Control( $wp_customize, 'separator_1', array(
			'settings'		=> 'separator_1',
			'section'  		=> 'cc_caboodle_extlink_section',
	)));


	$wp_customize->add_setting('cc_caboodle[extlink_attributes]', array(
		'default'		   => false,
		'sanitize_callback' => 'cc_toggle_control_sanitize',
		'type'				=> 'option',
		'transport'			=> 'postMessage',
	));
	$wp_customize->add_control( new Cubecolour_Toggle_Control(
		$wp_customize,
			'cc_caboodle_extlink_attributes',
			array(
				'label'			=> esc_html__( 'Add attributes', 'cubecolour-caboodle' ),
				/* translators: %1$s: <code>target="_blank"</code>, %2$s: <code>rel="noopener noreferrer nofollow"</code> */
				'description'	=> sprintf(  esc_html__( 'Add %1$s and %2$s attributes to external links', 'cubecolour-caboodle' ), '<code>target="_blank"</code>', '<code>rel="noopener noreferrer nofollow"</code>'),
				'type'	 		=> 'checkbox',
				'section'  		=> 'cc_caboodle_extlink_section',
				'settings'		=> 'cc_caboodle[extlink_attributes]',
			)
		)
	);

	/** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** **
	 * Wavy links section
	 *
	 */
	$wp_customize->add_section( 'cc_caboodle_wavylinks_section',
		array(
			'title'				=> esc_html__( 'Wavy links', 'cubecolour-caboodle' ),
			'description'		=> esc_html__( 'Wavy underline for links', 'cubecolour-caboodle' ),
			'panel'				=> 'cc_caboodle_panel'
		)
	);

	$wp_customize->add_setting( 'cc_caboodle[wavylinks]',
		array(
			'default'			=> '',
			'sanitize_callback'	=> 'cc_caboodle_sanitize_checkbox',
			'type'				=> 'option',
			'transport'			=> 'refresh',
		)
	);
	$wp_customize->add_control( new Cubecolour_Toggle_Control(
		$wp_customize,
			'cc_caboodle_wavylinks',
			array(
				'label'			=> esc_html__( 'Wavy links', 'cubecolour-caboodle' ),
				'section'		=> 'cc_caboodle_wavylinks_section',
				'settings'		=> 'cc_caboodle[wavylinks]',
			)
		)
	);
	
	$wp_customize->add_setting( 'cc_caboodle[wavylinks_show]',
		array(
			'default'			=> '',
			'sanitize_callback'	=> 'cc_caboodle_sanitize_checkbox',
			'type'				=> 'option',
			'transport'			=> 'refresh',
		)
	);
	$wp_customize->add_control( new Cubecolour_Toggle_Control(
		$wp_customize,
			'cc_caboodle_wavylinks_show',
			array(
				'label'			=> esc_html__( 'Show only when hovered', 'cubecolour-caboodle' ),
				'section'		=> 'cc_caboodle_wavylinks_section',
				'settings'		=> 'cc_caboodle[wavylinks_show]',
			)
		)
	);

	$wp_customize->add_setting( 'cc_caboodle[wavylinks_color]',
		array(
			'default'			=> '#0000ee',
			'sanitize_callback'	=> 'sanitize_hex_color',
			'type'				=> 'option',
			'transport'			=> 'refresh',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize, 'cc_caboodle_wavylinks_color',
			array(
				'label'			=> esc_html__( 'Underline Color', 'cubecolour-caboodle' ),
				'section'		=> 'cc_caboodle_wavylinks_section',
				'settings'		=> 'cc_caboodle[wavylinks_color]',
			)
		)
	);

	$wp_customize->add_setting( 'cc_caboodle[wavylinks_color_hover]',
		array(
			'default'			=> '#ee0000',
			'sanitize_callback'	=> 'sanitize_hex_color',
			'type'				=> 'option',
			'transport'			=> 'refresh',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize, 'cc_caboodle_wavylinks_color_hover',
			array(
				'label'			=> esc_html__( 'Hover Color', 'cubecolour-caboodle' ),
				'section'		=> 'cc_caboodle_wavylinks_section',
				'settings'		=> 'cc_caboodle[wavylinks_color_hover]',
			)
		)
	);

	$wp_customize->add_setting( 'cc_caboodle[wavylinks_gap]',
		array(
			'default'			=> 3,
			'sanitize_callback'	=> 'absint',
			'type'				=> 'option',
			'transport'			=> 'postMessage',
		)
	);
	$wp_customize->add_control(
		new Cubecolour_Range_Value_Control(
			$wp_customize, 'cc_caboodle_wavylinks_gap', array(
				'label'				=> esc_html__( 'Gap (px)', 'cubecolour-caboodle' ),
				'section'			=> 'cc_caboodle_wavylinks_section',
				'settings'			=> 'cc_caboodle[wavylinks_gap]',
				'type'				=> 'range',
				'input_attrs'		=> array(
					'min'				=> 0,
					'max'				=> 10,
					'step'				=> 1,
				)
			)
		)
	);

	$wp_customize->add_setting( 'cc_caboodle[wavylinks_selector]',
		array(
			'default'			=> esc_html( 'html body .entry-content a:not(.wp-block-button__link), footer a, widget a', 'cubecolour-caboodle' ),
			'sanitize_callback'	=> 'sanitize_textarea_field',
			'type'				=> 'option',
			'transport'			=> 'refresh',
		)
	);
	$wp_customize->add_control( 'cc_caboodle_wavylinks_selector',
		array(
			'label'				=> esc_html__( 'CSS Selector', 'cubecolour-caboodle' ),
			'section'			=> 'cc_caboodle_wavylinks_section',
			'settings'			=> 'cc_caboodle[wavylinks_selector]',
			'type'				=> 'textarea',
		)
	);


	/** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** **
	 * Lightbox section
	 *
	 */
	$wp_customize->add_section( 'cc_caboodle_lightbox_section',
		array(
			'title'				=> esc_html__( 'Lightbox', 'cubecolour-caboodle' ),
			'description'		=> esc_html__( 'Add a lightbox to images and galleries (Ensure you set the image or gallery to link to the media file)', 'cubecolour-caboodle' ),
			'panel'				=> 'cc_caboodle_panel',
		)
	);

	$wp_customize->add_setting('cc_caboodle[lightbox]', array(
		'default'		   => false,
		'sanitize_callback' => 'cc_toggle_control_sanitize',
		'type'				=> 'option',
		'transport'			=> 'postMessage',
	));
	$wp_customize->add_control( new Cubecolour_Toggle_Control(
		$wp_customize,
			'cc_caboodle_lightbox',
			array(
				'label'			=> esc_html__( 'Lightbox', 'cubecolour-caboodle' ),
				'type'	 		=> 'checkbox',
				'section'  		=> 'cc_caboodle_lightbox_section',
				'settings'		=> 'cc_caboodle[lightbox]',
			)
		)
	);


	/** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** **
	 * Media file size section
	 *
	 */
	$wp_customize->add_section( 'cc_caboodle_media_file_size_section',
		array(
			'title'				=> esc_html__( 'Show media file size', 'cubecolour-caboodle' ),
			'description'		=> esc_html__( 'Add a file size column in the media library list view', 'cubecolour-caboodle' ),
			'panel'				=> 'cc_caboodle_panel',
		)
	);

	$wp_customize->add_setting('cc_caboodle[media_file_size]', array(
		'default'		   => false,
		'sanitize_callback' => 'cc_toggle_control_sanitize',
		'type'				=> 'option',
		'transport'			=> 'postMessage',
	));
	$wp_customize->add_control( new Cubecolour_Toggle_Control(
		$wp_customize,
			'cc_caboodle_media_file_size',
			array(
				'label'			=> esc_html__( 'Show media file size', 'cubecolour-caboodle' ),
				'type'	 		=> 'checkbox',
				'section'  		=> 'cc_caboodle_media_file_size_section',
				'settings'		=> 'cc_caboodle[media_file_size]',
			)
		)
	);


	/** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** **
	 * Media attachment pages section
	 *
	 */
	$wp_customize->add_section( 'cc_caboodle_media_attachment_pages_section',
		array(
			'title'				=> esc_html__( 'Media attachment pages', 'cubecolour-caboodle' ),
			'description'		=> esc_html__( 'Enable media attachment pages', 'cubecolour-caboodle' ),
			'panel'				=> 'cc_caboodle_panel',
		)
	);

	$wp_customize->add_setting('cc_caboodle[media_attachment_pages]', array(
		'default'		   => false,
		'sanitize_callback' => 'cc_toggle_control_sanitize',
		'type'				=> 'option',
		'transport'			=> 'postMessage',
	));
	$wp_customize->add_control( new Cubecolour_Toggle_Control(
		$wp_customize,
			'cc_caboodle_media_attachment_pages',
			array(
				'label'			=> esc_html__( 'Enable attachment pages', 'cubecolour-caboodle' ),
				'type'	 		=> 'checkbox',
				'section'  		=> 'cc_caboodle_media_attachment_pages_section',
				'settings'		=> 'cc_caboodle[media_attachment_pages]',
			)
		)
	);


	/** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** **
	 * Add caboodle dashicons section
	 *
	 */
	$wp_customize->add_section( 'cc_caboodle_add_dashicons_section',
		array(
			'title'				=> esc_html__( 'Add dashicons', 'cubecolour-caboodle' ),
			'description'		=> esc_html__( 'Extend dashicons with new icons', 'cubecolour-caboodle' ),
			'panel'				=> 'cc_caboodle_panel'
		)
	);

	$wp_customize->add_setting('cc_caboodle[add_dashicons]', array(
		'default'		   => false,
		'sanitize_callback' => 'cc_toggle_control_sanitize',
		'type'				=> 'option',
		'transport'			=> 'postMessage',
	));
	$wp_customize->add_control( new Cubecolour_Toggle_Control(
		$wp_customize,
			'cc_caboodle_add_dashicons_loading',
			array(
				'label'			=> esc_html__( 'Add caboodle dashicons', 'cubecolour-caboodle' ),
				'type'	 		=> 'checkbox',
				'section'  		=> 'cc_caboodle_add_dashicons_section',
				'settings'		=> 'cc_caboodle[add_dashicons]',
			)
		)
	);


	/** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** **
	 * No lazy loading section
	 *
	 */
	$wp_customize->add_section( 'cc_caboodle_no_lazy_loading_section',
		array(
			'title'				=> esc_html__( 'No lazy loading', 'cubecolour-caboodle' ),
			'description'		=> esc_html__( 'No WordPress lazy loading', 'cubecolour-caboodle' ),
			'panel'				=> 'cc_caboodle_panel'
		)
	);

	$wp_customize->add_setting('cc_caboodle[no_lazy_loading]', array(
		'default'		   => false,
		'sanitize_callback' => 'cc_toggle_control_sanitize',
		'type'				=> 'option',
		'transport'			=> 'refresh',
	));
	$wp_customize->add_control( new Cubecolour_Toggle_Control(
		$wp_customize,
			'cc_caboodle_no_lazy_loading',
			array(
				'label'			=> esc_html__( 'No lazy loading', 'cubecolour-caboodle' ),
				'type'	 		=> 'checkbox',
				'section'  		=> 'cc_caboodle_no_lazy_loading_section',
				'settings'		=> 'cc_caboodle[no_lazy_loading]',
			)
		)
	);


	/** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** **
	 * Scroll to top section
	 *
	 */
	$wp_customize->add_section( 'cc_caboodle_scrolltop_section',
		array(
			'title'				=> esc_html__( 'Scroll to top', 'cubecolour-caboodle' ),
			'description'		=> esc_html__( 'Add a dynamic scroll to top button in the website footer', 'cubecolour-caboodle' ),
			'panel'				=> 'cc_caboodle_panel'
		)
	);

	$wp_customize->add_setting('cc_caboodle[scrolltop]', array(
		'default'		   => false,
		'sanitize_callback' => 'cc_toggle_control_sanitize',
		'type'				=> 'option',
		'transport'			=> 'refresh',
	));
	$wp_customize->add_control( new Cubecolour_Toggle_Control(
		$wp_customize,
			'cc_caboodle_scrolltop',
			array(
				'label'			=> esc_html__( 'Scroll to top', 'cubecolour-caboodle' ),
				'type'	 		=> 'checkbox',
				'section'  		=> 'cc_caboodle_scrolltop_section',
				'settings'		=> 'cc_caboodle[scrolltop]',
			)
		)
	);


	$wp_customize->add_setting('cc_caboodle[scrolltop_icon]',
		array(
			'default'			=> '\\f106',
			'sanitize_callback'	=> 'cc_caboodle_sanitize_scrolltop_icon',
			'transport'			=> 'postMessage',
			'type'				=> 'option',
		)
	);
	$wp_customize->add_control( new Cubecolour_Image_Radio_Control (
		$wp_customize,
			'cc_caboodle_scrolltop_icon', array(
				'type'			=> 'radio',
				'label'			=> esc_html__( 'Icon', 'cubecolour-caboodle' ),
				'section'		=> 'cc_caboodle_scrolltop_section',
				'settings'		=> 'cc_caboodle[scrolltop_icon]',
				'choices'		=> array(
					'\\f106' 		=> CC_CABOODLE_PLUGIN_URL . '/images/scrolltop/icon11.svg',
					'\\e803' 		=> CC_CABOODLE_PLUGIN_URL . '/images/scrolltop/icon21.svg',
					'\\e80a' 		=> CC_CABOODLE_PLUGIN_URL . '/images/scrolltop/icon31.svg',
					'\\f077' 		=> CC_CABOODLE_PLUGIN_URL . '/images/scrolltop/icon12.svg',
					'\\e801' 		=> CC_CABOODLE_PLUGIN_URL . '/images/scrolltop/icon22.svg',
					'\\e808' 		=> CC_CABOODLE_PLUGIN_URL . '/images/scrolltop/icon32.svg',
					'\\f0d8' 		=> CC_CABOODLE_PLUGIN_URL . '/images/scrolltop/icon13.svg',
					'\\e802' 		=> CC_CABOODLE_PLUGIN_URL . '/images/scrolltop/icon23.svg',
					'\\e809' 		=> CC_CABOODLE_PLUGIN_URL . '/images/scrolltop/icon33.svg',
					'\\f062' 		=> CC_CABOODLE_PLUGIN_URL . '/images/scrolltop/icon14.svg',
					'\\e800' 		=> CC_CABOODLE_PLUGIN_URL . '/images/scrolltop/icon24.svg',
					'\\e807' 		=> CC_CABOODLE_PLUGIN_URL . '/images/scrolltop/icon34.svg',
					'\\f357' 		=> CC_CABOODLE_PLUGIN_URL . '/images/scrolltop/icon15.svg',
					'\\e806' 		=> CC_CABOODLE_PLUGIN_URL . '/images/scrolltop/icon25.svg',
					'\\e80d' 		=> CC_CABOODLE_PLUGIN_URL . '/images/scrolltop/icon35.svg',
					'\\f176' 		=> CC_CABOODLE_PLUGIN_URL . '/images/scrolltop/icon16.svg',
					'\\e804' 		=> CC_CABOODLE_PLUGIN_URL . '/images/scrolltop/icon26.svg',
					'\\e80b' 		=> CC_CABOODLE_PLUGIN_URL . '/images/scrolltop/icon36.svg',
					'\\f30c' 		=> CC_CABOODLE_PLUGIN_URL . '/images/scrolltop/icon17.svg',
					'\\e805' 		=> CC_CABOODLE_PLUGIN_URL . '/images/scrolltop/icon27.svg',
					'\\e80c' 		=> CC_CABOODLE_PLUGIN_URL . '/images/scrolltop/icon37.svg',
				)
			)
		)
	);

	$wp_customize->add_setting( 'cc_caboodle[scrolltop_size]',
		array(
			'default'			=> 50,
			'sanitize_callback'	=> 'absint',
			'type'				=> 'option',
			'transport'			=> 'postMessage',
		)
	);
	$wp_customize->add_control(
		new Cubecolour_Range_Value_Control(
			$wp_customize, 'cc_caboodle_scrolltop_size', array(
				'label'				=> esc_html__( 'Icon size (px)', 'cubecolour-caboodle' ),
				'section'			=> 'cc_caboodle_scrolltop_section',
				'settings'			=> 'cc_caboodle[scrolltop_size]',
				'type'				=> 'range',
				'input_attrs'		=> array(
					'min'				=> 20,
					'max'				=> 100,
					'step'				=> 1,
				)
			)
		)
	);

	$wp_customize->add_setting( 'cc_caboodle[scrolltop_padding]',
		array(
			'default'			=> 0,
			'sanitize_callback'	=> 'absint',
			'type'				=> 'option',
			'transport'			=> 'postMessage',
		)
	);
	$wp_customize->add_control(
		new Cubecolour_Range_Value_Control(
			$wp_customize, 'cc_caboodle_scrolltop_padding', array(
				'label'				=> esc_html__( 'Padding (px)', 'cubecolour-caboodle' ),
				'section'			=> 'cc_caboodle_scrolltop_section',
				'settings'			=> 'cc_caboodle[scrolltop_padding]',
				'type'				=> 'range',
				'input_attrs'		=> array(
					'min'				=> 0,
					'max'				=> 50,
					'step'				=> 1,
				)
			)
		)
	);

	$wp_customize->add_setting( 'cc_caboodle[scrolltop_border_width]',
		array(
			'default'			=> 2,
			'sanitize_callback'	=> 'absint',
			'type'				=> 'option',
			'transport'			=> 'postMessage',
		)
	);
	$wp_customize->add_control(
		new Cubecolour_Range_Value_Control(
			$wp_customize, 'cc_caboodle_scrolltop_border_width', array(
				'label'				=> esc_html__( 'Border width (px)', 'cubecolour-caboodle' ),
				'section'			=> 'cc_caboodle_scrolltop_section',
				'settings'			=> 'cc_caboodle[scrolltop_border_width]',
				'type'				=> 'range',
				'input_attrs'		=> array(
					'min'				=> 0,
					'max'				=> 10,
					'step'				=> 1,
				)
			)
		)
	);

	$wp_customize->add_setting( 'cc_caboodle[scrolltop_radius]',
		array(
			'default'			=> 50,
			'sanitize_callback'	=> 'absint',
			'type'				=> 'option',
			'transport'			=> 'postMessage',
		)
	);
	$wp_customize->add_control(
		new Cubecolour_Range_Value_Control(
			$wp_customize, 'cc_caboodle_scrolltop_radius', array(
				'label'				=> esc_html__( 'Border radius (%)', 'cubecolour-caboodle' ),
				'section'			=> 'cc_caboodle_scrolltop_section',
				'settings'			=> 'cc_caboodle[scrolltop_radius]',
				'type'				=> 'range',
				'input_attrs'		=> array(
					'min'				=> 0,
					'max'				=> 50,
					'step'				=> 1,
				)
			)
		)
	);

	$wp_customize->add_setting( 'cc_caboodle[scrolltop_right]',
		array(
			'default'			=> 50,
			'sanitize_callback'	=> 'absint',
			'type'				=> 'option',
			'transport'			=> 'postMessage',
		)
	);
	$wp_customize->add_control(
		new Cubecolour_Range_Value_Control(
			$wp_customize, 'cc_caboodle_scrolltop_right', array(
				'label'				=> esc_html__( 'Position right (px)', 'cubecolour-caboodle' ),
				'section'			=> 'cc_caboodle_scrolltop_section',
				'settings'			=> 'cc_caboodle[scrolltop_right]',
				'type'				=> 'range',
				'input_attrs'		=> array(
					'min'				=> 0,
					'max'				=> 100,
					'step'				=> 1,
				)
			)
		)
	);

	$wp_customize->add_setting( 'cc_caboodle[scrolltop_bottom]',
		array(
			'default'			=> 50,
			'sanitize_callback'	=> 'absint',
			'type'				=> 'option',
			'transport'			=> 'postMessage',
		)
	);
	$wp_customize->add_control(
		new Cubecolour_Range_Value_Control(
			$wp_customize, 'cc_caboodle_scrolltop_bottom', array(
				'label'				=> esc_html__( 'Position bottom (px)', 'cubecolour-caboodle' ),
				'section'			=> 'cc_caboodle_scrolltop_section',
				'settings'			=> 'cc_caboodle[scrolltop_bottom]',
				'type'				=> 'range',
				'input_attrs'		=> array(
					'min'				=> 0,
					'max'				=> 100,
					'step'				=> 1,
				)
			)
		)
	);

	$wp_customize->add_setting( 'cc_caboodle[scrolltop_color]',
		array(
			'default'			=> '#3a3a3a',
			'sanitize_callback'	=> 'sanitize_hex_color',
			'type'				=> 'option',
			'transport'			=> 'postMessage',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize, 'cc_caboodle_scrolltop_color',
			array(
				'label'			=> esc_html__( 'Color', 'cubecolour-caboodle' ),
				'section'		=> 'cc_caboodle_scrolltop_section',
				'settings'		=> 'cc_caboodle[scrolltop_color]',
			)
		)
	);

	$wp_customize->add_setting( 'cc_caboodle[scrolltop_bgcolor]',
		array(
			'default'			=> '#ffffff',
			'sanitize_callback'	=> 'sanitize_hex_color',
			'type'				=> 'option',
			'transport'			=> 'postMessage',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize, 'cc_caboodle_scrolltop_bgcolor',
			array(
				'label'			=> esc_html__( 'Background color', 'cubecolour-caboodle' ),
				'section'		=> 'cc_caboodle_scrolltop_section',
				'settings'		=> 'cc_caboodle[scrolltop_bgcolor]',
			)
		)
	);

	$wp_customize->add_setting( 'cc_caboodle[scrolltop_color_hover]',
		array(
			'default'			=> '#ffffff',
			'sanitize_callback'	=> 'sanitize_hex_color',
			'type'				=> 'option',
			'transport'			=> 'postMessage',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize, 'cc_caboodle_scrolltop_color_hover',
			array(
				'label'			=> esc_html__( 'Hover color', 'cubecolour-caboodle' ),
				'section'		=> 'cc_caboodle_scrolltop_section',
				'settings'		=> 'cc_caboodle[scrolltop_color_hover]',
			)
		)
	);

	$wp_customize->add_setting( 'cc_caboodle[scrolltop_bgcolor_hover]',
		array(
			'default'			=> '#3a3a3a',
			'sanitize_callback'	=> 'sanitize_hex_color',
			'type'				=> 'option',
			'transport'			=> 'postMessage',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize, 'cc_caboodle_scrolltop_bgcolor_hover',
			array(
				'label'			=> esc_html__( 'Background hover color', 'cubecolour-caboodle' ),
				'section'		=> 'cc_caboodle_scrolltop_section',
				'settings'		=> 'cc_caboodle[scrolltop_bgcolor_hover]',
			)
		)
	);


	/** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** **
	 * Fix fooer (stomp) section
	 *
	 */
	$wp_customize->add_section( 'cc_caboodle_stomp_section',
		array(
			'title'				=> esc_html__( 'Fix footer', 'cubecolour-caboodle' ),
			'description'		=> esc_html__( 'Fix the footer element to the bottom of the viewport on short pages', 'cubecolour-caboodle' ),
			'panel'				=> 'cc_caboodle_panel'
		)
	);

	$wp_customize->add_setting('cc_caboodle[stomp]', array(
		'default'		   => false,
		'sanitize_callback' => 'cc_toggle_control_sanitize',
		'type'				=> 'option',
		'transport'			=> 'postMessage',
	));
	$wp_customize->add_control( new Cubecolour_Toggle_Control(
		$wp_customize,
			'cc_caboodle_stomp',
			array(
				'label'			=> esc_html__( 'Fix footer', 'cubecolour-caboodle' ),
				'type'	 		=> 'checkbox',
				'section'  		=> 'cc_caboodle_stomp_section',
				'settings'		=> 'cc_caboodle[stomp]',
			)
		)
	);

	$wp_customize->add_setting( 'cc_caboodle[stomp_element]',
		array(
			'default'			=> '#colophon',
			'sanitize_callback'	=> 'sanitize_text_field',
			'type'				=> 'option',
			'transport'			=> 'postMessage',
		)
	);
	$wp_customize->add_control( 'cc_caboodle_stomp_element',
		array(
			'label'				=> esc_html__( 'Footer element to fix', 'cubecolour-caboodle' ),
			'section'			=> 'cc_caboodle_stomp_section',
			'settings'			=> 'cc_caboodle[stomp_element]',
			'type'				=> 'text',
		)
	);


	/** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** **
	 * Footer Years range section
	 *
	 */
	$wp_customize->add_section( 'cc_caboodle_years_section',
		array(
			'title'				=> esc_html__( 'Footer years range', 'cubecolour-caboodle' ),
			'description'		=> esc_html__( 'Copyright years shortcode to use in footer', 'cubecolour-caboodle' ),
			'panel'				=> 'cc_caboodle_panel'
		)
	);

	$wp_customize->add_setting('cc_caboodle[years]', array(
		'default'		   => false,
		'sanitize_callback' => 'cc_toggle_control_sanitize',
		'type'				=> 'option',
		'transport'			=> 'refresh',
	));
	$wp_customize->add_control( new Cubecolour_Toggle_Control(
		$wp_customize,
			'cc_caboodle_years',
			array(
				'label'			=> esc_html__( 'Years shortcode', 'cubecolour-caboodle' ),
				'type'	 		=> 'checkbox',
				'section'  		=> 'cc_caboodle_years_section',
				'settings'		=> 'cc_caboodle[years]',
			)
		)
	);

	$this_year = absint( gmdate('Y') );
	$next_year = $this_year + 1;

	$wp_customize->add_setting( 'cc_caboodle[years_from]',
		array(
			'default'			=> $this_year,
			'sanitize_callback'	=> 'absint',
			'type'				=> 'option',
			'transport'			=> 'postMessage',
		)
	);
	$wp_customize->add_control( 'cc_caboodle_years_from',
		array(
			'label'				=> esc_html__( 'Copyright from year', 'cubecolour-caboodle' ),
			'section'			=> 'cc_caboodle_yearsrange_section',
			'settings'			=> 'cc_caboodle[years_from]',
			'type' => 'number',
			'input_attrs' => array(
				'min'		=> '1990',
				'step'		=> '1',
				'max'		=> $next_year,
			),
		)
	);


	/** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** **
	 * Anti_spambot
	 *  shortcode: [email][/email]
	 *
	 */
	 
	 $current_user = wp_get_current_user();
	 $user_email = $current_user->user_email;

	$wp_customize->add_section( 'cc_caboodle_anti_spambot_section',
		array(
			'title'				=> esc_html__( 'Anti spambot', 'cubecolour-caboodle' ),
			'description'		=> esc_html__( 'email shortcode to help protect email addresses from spambots', 'cubecolour-caboodle' ) . '<br><br><em>Usage:</em><br><code>[email]' . $user_email . '[/email]</code>',
			'panel'				=> 'cc_caboodle_panel'
		)
	);

	$wp_customize->add_setting('cc_caboodle[anti_spambot]', array(
		'default'		   => false,
		'sanitize_callback' => 'cc_toggle_control_sanitize',
		'type'				=> 'option',
		'transport'			=> 'postMessage',
	));
	$wp_customize->add_control( new Cubecolour_Toggle_Control(
		$wp_customize,
			'cc_caboodle_anti_spambot',
			array(
				'label'			=> esc_html__( 'Anti spambot', 'cubecolour-caboodle' ),
				'type'	 		=> 'checkbox',
				'section'  		=> 'cc_caboodle_anti_spambot_section',
				'settings'		=> 'cc_caboodle[anti_spambot]',
			)
		)
	);


	/** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** **
	 * Anti_clickjack section
	 *  Prevent site loading in an iFrame
	 *
	 */
	$wp_customize->add_section( 'cc_caboodle_anti_clickjack_section',
		array(
			'title'				=> esc_html__( 'Anti clickjack', 'cubecolour-caboodle' ),
			'description'	=> esc_html__( 'Prevent the site from loading inside an external frame or iframe', 'cubecolour-caboodle' ),
			'panel'				=> 'cc_caboodle_panel'
		)
	);

	$wp_customize->add_setting('cc_caboodle[anti_clickjack]', array(
		'default'		   => false,
		'sanitize_callback' => 'cc_toggle_control_sanitize',
		'type'				=> 'option',
		'transport'			=> 'postMessage',
	));
	$wp_customize->add_control( new Cubecolour_Toggle_Control(
		$wp_customize,
			'cc_caboodle_anti_clickjack',
			array(
				'label'			=> esc_html__( 'Anti clickjack', 'cubecolour-caboodle' ),
				'type'	 		=> 'checkbox',
				'section'  		=> 'cc_caboodle_anti_clickjack_section',
				'settings'		=> 'cc_caboodle[anti_clickjack]',
			)
		)
	);


	/** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** **
	 * No adminbar
	 *
	 */
	$wp_customize->add_section( 'cc_caboodle_no_admin_bar_section',
		array(
			'title'				=> esc_html__( 'No admin bar', 'cubecolour-caboodle' ),
			'description'		=> esc_html__( 'No admin bar on the front end for logged-in users', 'cubecolour-caboodle' ),
			'panel'				=> 'cc_caboodle_panel'
		)
	);

	$wp_customize->add_setting('cc_caboodle[no_admin_bar]', array(
		'default'		   => false,
		'sanitize_callback' => 'cc_toggle_control_sanitize',
		'type'				=> 'option',
		'transport'			=> 'postMessage',
	));
	$wp_customize->add_control( new Cubecolour_Toggle_Control(
		$wp_customize,
			'cc_caboodle_no_admin_bar',
			array(
				'label'			=> esc_html__( 'No admin bar', 'cubecolour-caboodle' ),
				'type'	 		=> 'checkbox',
				'section'  		=> 'cc_caboodle_no_admin_bar_section',
				'settings'		=> 'cc_caboodle[no_admin_bar]',
			)
		)
	);

	$wp_customize->add_setting('cc_caboodle[no_admin_bar_except_admins]', array(
		'default'		   => false,
		'sanitize_callback' => 'cc_toggle_control_sanitize',
		'type'				=> 'option',
		'transport'			=> 'postMessage',
	));
	$wp_customize->add_control( new Cubecolour_Toggle_Control(
		$wp_customize,
			'cc_caboodle_no_admin_bar_except_admins',
			array(
				'label'			=> esc_html__( 'Except for administrators', 'cubecolour-caboodle' ),
				'type'	 		=> 'checkbox',
				'section'  		=> 'cc_caboodle_no_admin_bar_section',
				'settings'		=> 'cc_caboodle[no_admin_bar_except_admins]',
			)
		)
	);


	/** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** **
	 * No file editors section
	 *
	 */
	$wp_customize->add_section( 'cc_caboodle_no_file_editors_section',
		array(
			'title'				=> esc_html__( 'No file editors', 'cubecolour-caboodle' ),
			'description'	=> esc_html__( 'Removes the theme and plugin editors from admin', 'cubecolour-caboodle' ),
			'panel'				=> 'cc_caboodle_panel'
		)
	);

	$wp_customize->add_setting('cc_caboodle[no_file_editors]', array(
		'default'		   => false,
		'sanitize_callback' => 'cc_toggle_control_sanitize',
		'type'				=> 'option',
		'transport'			=> 'postMessage',
	));
	$wp_customize->add_control( new Cubecolour_Toggle_Control(
		$wp_customize,
			'cc_caboodle_no_file_editors',
			array(
				'label'			=> esc_html__( 'No file editors', 'cubecolour-caboodle' ),
				'type'	 		=> 'checkbox',
				'section'  		=> 'cc_caboodle_no_file_editors_section',
				'settings'		=> 'cc_caboodle[no_file_editors]',
			)
		)
	);


	/** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** **
	 * No author archives section
	 *
	 */
	$wp_customize->add_section( 'cc_caboodle_no_author_archives_section',
		array(
			'title'				=> esc_html__( 'No author archives', 'cubecolour-caboodle' ),
			'description'		=> esc_html__( 'Redirect requests for author archives to the homepage', 'cubecolour-caboodle' ),
			'panel'				=> 'cc_caboodle_panel'
		)
	);

	$wp_customize->add_setting('cc_caboodle[no_author_archives]', array(
		'default'		   => false,
		'sanitize_callback' => 'cc_toggle_control_sanitize',
		'type'				=> 'option',
		'transport'			=> 'postMessage',
	));
	$wp_customize->add_control( new Cubecolour_Toggle_Control(
		$wp_customize,
			'cc_caboodle_no_author_archives',
			array(
				'label'			=> esc_html__( 'No author archives', 'cubecolour-caboodle' ),
				'type'	 		=> 'checkbox',
				'section'  		=> 'cc_caboodle_no_author_archives_section',
				'settings'		=> 'cc_caboodle[no_author_archives]',
			)
		)
	);


	/** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** **
	 * No generator tag section
	 *
	 */
	$wp_customize->add_section( 'cc_caboodle_no_generator_section',
		array(
			'title'				=> esc_html__( 'No generator', 'cubecolour-caboodle' ),
			'description'		=> esc_html__( 'Remove the WordPress generator meta tag', 'cubecolour-caboodle' ),
			'panel'				=> 'cc_caboodle_panel'
		)
	);

	$wp_customize->add_setting('cc_caboodle[no_generator]', array(
		'default'		   => false,
		'sanitize_callback' => 'cc_toggle_control_sanitize',
		'type'				=> 'option',
		'transport'			=> 'postMessage',
	));
	$wp_customize->add_control( new Cubecolour_Toggle_Control(
		$wp_customize,
			'cc_caboodle_no_generator',
			array(
				'label'			=> esc_html__( 'No generator tag', 'cubecolour-caboodle' ),
				'type'	 		=> 'checkbox',
				'section'  		=> 'cc_caboodle_no_generator_section',
				'settings'		=> 'cc_caboodle[no_generator]',
			)
		)
	);


	/** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** **
	 * No RSD (really simple discovery) section
	 *
	 */
	$wp_customize->add_section( 'cc_caboodle_no_rsd_section',
		array(
			'title'				=> esc_html__( 'No RSD', 'cubecolour-caboodle' ),
			'description'		=> esc_html__( 'Remove the Really Simple Discovery endpoint', 'cubecolour-caboodle' ),
			'panel'				=> 'cc_caboodle_panel'
		)
	);

	$wp_customize->add_setting('cc_caboodle[no_rsd]', array(
		'default'		   => false,
		'sanitize_callback' => 'cc_toggle_control_sanitize',
		'type'				=> 'option',
		'transport'			=> 'postMessage',
	));
	$wp_customize->add_control( new Cubecolour_Toggle_Control(
		$wp_customize,
			'cc_caboodle_no_rsd',
			array(
				'label'			=> esc_html__( 'No RSD', 'cubecolour-caboodle' ),
				'type'	 		=> 'checkbox',
				'section'  		=> 'cc_caboodle_no_rsd_section',
				'settings'		=> 'cc_caboodle[no_rsd]',
			)
		)
	);


	/** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** **
	 * No feeds (RSS, RDF, atom) section
	 *
	 */
	$wp_customize->add_section( 'cc_caboodle_no_feeds_section',
		array(
			'title'				=> esc_html__( 'No feeds', 'cubecolour-caboodle' ),
			'description'		=> esc_html__( 'Remove the RSS, RDF and atom feeds', 'cubecolour-caboodle' ),
			'panel'				=> 'cc_caboodle_panel'
		)
	);

	$wp_customize->add_setting('cc_caboodle[no_feeds]', array(
		'default'		   => false,
		'sanitize_callback' => 'cc_toggle_control_sanitize',
		'type'				=> 'option',
		'transport'			=> 'postMessage',
	));
	$wp_customize->add_control( new Cubecolour_Toggle_Control(
		$wp_customize,
			'cc_caboodle_no_feeds',
			array(
				'label'			=> esc_html__( 'No feeds', 'cubecolour-caboodle' ),
				'type'	 		=> 'checkbox',
				'section'  		=> 'cc_caboodle_no_feeds_section',
				'settings'		=> 'cc_caboodle[no_feeds]',
			)
		)
	);


	/** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** **
	 * No shortlinks section
	 *
	 */
	$wp_customize->add_section( 'cc_caboodle_no_shortlinks_section',
		array(
			'title'				=> esc_html__( 'No shortlink tags', 'cubecolour-caboodle' ),
			'description'		=> esc_html__( 'Remove the shortlink header tags', 'cubecolour-caboodle' ),
			'panel'				=> 'cc_caboodle_panel'
		)
	);

	$wp_customize->add_setting('cc_caboodle[no_shortlinks]', array(
		'default'		   => false,
		'sanitize_callback' => 'cc_toggle_control_sanitize',
		'type'				=> 'option',
		'transport'			=> 'postMessage',
	));
	$wp_customize->add_control( new Cubecolour_Toggle_Control(
		$wp_customize,
			'cc_caboodle_no_shortlinks',
			array(
				'label'			=> esc_html__( 'No shortlink tags', 'cubecolour-caboodle' ),
				'type'	 		=> 'checkbox',
				'section'  		=> 'cc_caboodle_no_shortlinks_section',
				'settings'		=> 'cc_caboodle[no_shortlinks]',
			)
		)
	);


	/** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** **
	 * No pingbacks section
	 *
	 */
	$wp_customize->add_section( 'cc_caboodle_no_pingbacks_section',
		array(
			'title'				=> esc_html__( 'No pingbacks', 'cubecolour-caboodle' ),
			'description'		=> esc_html__( 'Prevent self pingbacks', 'cubecolour-caboodle' ),
			'panel'				=> 'cc_caboodle_panel'
		)
	);

	$wp_customize->add_setting('cc_caboodle[no_pingbacks]', array(
		'default'		   => false,
		'sanitize_callback' => 'cc_toggle_control_sanitize',
		'type'				=> 'option',
		'transport'			=> 'postMessage',
	));
	$wp_customize->add_control( new Cubecolour_Toggle_Control(
		$wp_customize,
			'cc_caboodle_no_pingbacks',
			array(
				'label'			=> esc_html__( 'No pingbacks', 'cubecolour-caboodle' ),
				'type'	 		=> 'checkbox',
				'section'  		=> 'cc_caboodle_no_pingbacks_section',
				'settings'		=> 'cc_caboodle[no_pingbacks]',
			)
		)
	);


	/** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** **
	 * Embed bandcamp section
	 *
	 */
	$wp_customize->add_section( 'cc_caboodle_embed_bandcamp_section',
		array(
			'title'				=> esc_html__( 'Embed bandcamp', 'cubecolour-caboodle' ),
			'description'		=> esc_html__( 'Enable the [bandcamp] shortcode  generated by bandcamp to embed an audio player', 'cubecolour-caboodle' ),
			'panel'				=> 'cc_caboodle_panel'
		)
	);

	$wp_customize->add_setting('cc_caboodle[embed_bandcamp]', array(
		'default'		   => false,
		'sanitize_callback' => 'cc_toggle_control_sanitize',
		'type'				=> 'option',
		'transport'			=> 'postMessage',
	));
	$wp_customize->add_control( new Cubecolour_Toggle_Control(
		$wp_customize,
			'cc_caboodle_no_login_email',
			array(
				'label'			=> esc_html__( 'Embed bandcamp', 'cubecolour-caboodle' ),
				'type'	 		=> 'checkbox',
				'section'  		=> 'cc_caboodle_embed_bandcamp_section',
				'settings'		=> 'cc_caboodle[embed_bandcamp]',
			)
		)
	);

	/** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** **
	 * Astra theme specific controls
	 *
	 */
	if ( 'astra' === get_template() ) {

		/** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** **
		 * Caboodle search placeholder section (Astra)
		 *
		 */
		$wp_customize->add_section( 'cc_caboodle_search_placeholder_section',
			array(
				'title'				=> esc_html__( 'Search placeholder', 'cubecolour-caboodle' ),
				'description'		=> esc_html__( 'Use translatable default text in Astra theme header cover search', 'cubecolour-caboodle' ),
				'panel'				=> 'cc_caboodle_panel'
			)
		);

		$wp_customize->add_setting('cc_caboodle[search_placeholder]', array(
			'default'		   => false,
			'sanitize_callback' => 'cc_toggle_control_sanitize',
			'type'				=> 'option',
			'transport'			=> 'postMessage',
		));
		$wp_customize->add_control( new Cubecolour_Toggle_Control(
			$wp_customize,
				'cc_caboodle_search_placeholder',
				array(
					'label'			=> esc_html__( 'Search placeholder text', 'cubecolour-caboodle' ),
					'type'	 		=> 'checkbox',
					'section'  		=> 'cc_caboodle_search_placeholder_section',
					'settings'		=> 'cc_caboodle[search_placeholder]',
				)
			)
		);


		/** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** **
		 * Caboodle responsive breakpoints section (Astra)
		 *
		 */
		$wp_customize->add_section( 'cc_caboodle_breakpoint_section',
			array(
				'title'				=> esc_html__( 'Responsive breakpoints', 'cubecolour-caboodle' ),
				'description'		=> esc_html__( 'Set custom mobile and tablet breakpoints for the Astra theme', 'cubecolour-caboodle' ),
				'panel'				=> 'cc_caboodle_panel'
			)
		);

		$wp_customize->add_setting('cc_caboodle[breakpoint]', array(
			'default'		   => false,
			'sanitize_callback' => 'cc_toggle_control_sanitize',
			'type'				=> 'option',
			'transport'			=> 'refresh',
		));
		$wp_customize->add_control( new Cubecolour_Toggle_Control(
			$wp_customize,
				'cc_caboodle_breakpoint',
				array(
					'label'			=> esc_html__( 'Set breakpoints', 'cubecolour-caboodle' ),
					'type'	 		=> 'checkbox',
					'section'  		=> 'cc_caboodle_breakpoint_section',
					'settings'		=> 'cc_caboodle[breakpoint]',
				)
			)
		);

		$wp_customize->add_setting( 'cc_caboodle[breakpoint_tablet]',
			array(
				'default'			=> 1024,
				'sanitize_callback'	=> 'absint',
				'type'				=> 'option',
				'transport'			=> 'refresh',
			)
		);
		$wp_customize->add_control(
			new Cubecolour_Range_Value_Control(
				$wp_customize, 'cc_caboodle_breakpoint_tablet', array(
					'label'				=> esc_html__( 'Breakpoint for tablet', 'cubecolour-caboodle' ),
					'section'			=> 'cc_caboodle_breakpoint_section',
					'settings'			=> 'cc_caboodle[breakpoint_tablet]',
					'type'				=> 'range',
					'input_attrs'		=> array(
						'min'				=> 800,
						'max'				=> 1400,
						'step'				=> 1,
					)
				)
			)
		);

		$wp_customize->add_setting( 'cc_caboodle[breakpoint_mobile]',
			array(
				'default'			=> 767,
				'sanitize_callback'	=> 'absint',
				'type'				=> 'option',
				'transport'			=> 'refresh',
			)
		);
		$wp_customize->add_control(
			new Cubecolour_Range_Value_Control(
				$wp_customize, 'cc_caboodle_breakpoint_mobile', array(
					'label'				=> esc_html__( 'Breakpoint for mobile', 'cubecolour-caboodle' ),
					'section'			=> 'cc_caboodle_breakpoint_section',
					'settings'			=> 'cc_caboodle[breakpoint_mobile]',
					'type'				=> 'range',
					'input_attrs'		=> array(
						'min'				=> 600,
						'max'				=> 800,
						'step'				=> 1,
					)
				)
			)
		);
	}


	/** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** **
	 * Caboodle Polylang section
	 *
	 */

	if ( is_plugin_active( 'polylang/polylang.php' ) ) {

		$wp_customize->add_section( 'cc_caboodle_polylang_section',
			array(
				'title'				=> esc_html__( 'Polylang SVG flags', 'cubecolour-caboodle' ),
				'description'		=> esc_html__( 'Replace the default bitmap flags in polylang', 'cubecolour-caboodle' ),
				'panel'				=> 'cc_caboodle_panel'
			)
		);

		$wp_customize->add_setting('cc_caboodle[polylang]', array(
			'default'		   => false,
			'sanitize_callback' => 'cc_toggle_control_sanitize',
			'type'				=> 'option',
			'transport'			=> 'postMessage',
		));
		$wp_customize->add_control( new Cubecolour_Toggle_Control(
			$wp_customize,
				'cc_caboodle_polylang',
				array(
					'label'			=> esc_html__( 'Polylang', 'cubecolour-caboodle' ),
					'type'	 		=> 'checkbox',
					'section'  		=> 'cc_caboodle_polylang_section',
					'settings'		=> 'cc_caboodle[polylang]',
				)
			)
		);

		$wp_customize->add_setting( 'cc_caboodle[polylang_flag_width]',
			array(
				'default'			=> 36,
				'sanitize_callback'	=> 'absint',
				'type'				=> 'option',
				'transport'			=> 'postMessage',
			)
		);
		$wp_customize->add_control(
			new Cubecolour_Range_Value_Control(
				$wp_customize, 'cc_caboodle_polylang_flag_width', array(
					'label'				=> esc_html__( 'Flag width px', 'cubecolour-caboodle' ),
					'section'			=> 'cc_caboodle_polylang_section',
					'settings'			=> 'cc_caboodle[polylang_flag_width]',
					'type'				=> 'range',
					'input_attrs'		=> array(
						'min'				=> 4,
						'max'				=> 80,
						'step'				=> 4,
					)
				)
			)
		);

		$wp_customize->add_setting( 'cc_caboodle[polylang_flag_grayscale]',
			array(
				'default'			=> 80,
				'sanitize_callback'	=> 'absint',
				'type'				=> 'option',
				'transport'			=> 'postMessage',
			)
		);
		$wp_customize->add_control(
			new Cubecolour_Range_Value_Control(
				$wp_customize, 'cc_caboodle_polylang_flag_grayscale', array(
					'label'				=> esc_html__( 'Grayscale %', 'cubecolour-caboodle' ),
					'section'			=> 'cc_caboodle_polylang_section',
					'settings'			=> 'cc_caboodle[polylang_flag_grayscale]',
					'type'				=> 'range',
					'input_attrs'		=> array(
						'min'				=> 0,
						'max'				=> 100,
						'step'				=> 1,
					)
				)
			)
		);

		$wp_customize->add_setting( 'cc_caboodle[polylang_flag_opacity]',
			array(
				'default'			=> 60,
				'sanitize_callback'	=> 'absint',
				'type'				=> 'option',
				'transport'			=> 'postMessage',
			)
		);
		$wp_customize->add_control(
			new Cubecolour_Range_Value_Control(
				$wp_customize, 'cc_caboodle_polylang_flag_opacity', array(
					'label'				=> esc_html__( 'Opacity %', 'cubecolour-caboodle' ),
					'section'			=> 'cc_caboodle_polylang_section',
					'settings'			=> 'cc_caboodle[polylang_flag_opacity]',
					'type'				=> 'range',
					'input_attrs'		=> array(
						'min'				=> 0,
						'max'				=> 100,
						'step'				=> 1,
					)
				)
			)
		);

		$wp_customize->add_setting( 'cc_caboodle[polylang_flag_spacing]',
			array(
				'default'			=> 60,
				'sanitize_callback'	=> 'absint',
				'type'				=> 'option',
				'transport'			=> 'postMessage',
			)
		);
		$wp_customize->add_control(
			new Cubecolour_Range_Value_Control(
				$wp_customize, 'cc_caboodle_polylang_flag_spacing', array(
					'label'				=> esc_html__( 'Spacing between flags px', 'cubecolour-caboodle' ),
					'section'			=> 'cc_caboodle_polylang_section',
					'settings'			=> 'cc_caboodle[polylang_flag_spacing]',
					'type'				=> 'range',
					'input_attrs'		=> array(
						'min'				=> 0,
						'max'				=> 20,
						'step'				=> 1,
					)
				)
			)
		);
	}


	/** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** **
	 * Caboodle gravity forms section
	 *
	 */
	if ( is_plugin_active( 'gravityforms/gravityforms.php' ) ) {

		$wp_customize->add_section( 'cc_caboodle_gform_section',
			array(
				'title'				=> esc_html__( 'Gravity forms style', 'cubecolour-caboodle' ),
				'description'		=> esc_html__( 'Add some simple styles to forms created with the gravity forms plugin', 'cubecolour-caboodle' ),
				'panel'				=> 'cc_caboodle_panel'
			)
		);

		$wp_customize->add_setting('cc_caboodle[gform]', array(
			'default'		   => false,
			'sanitize_callback' => 'cc_toggle_control_sanitize',
			'type'				=> 'option',
			'transport'			=> 'refresh',
		));
		$wp_customize->add_control( new Cubecolour_Toggle_Control(
			$wp_customize,
				'cc_caboodle_gform',
				array(
					'label'			=> esc_html__( 'Gravity forms', 'cubecolour-caboodle' ),
					'type'	 		=> 'checkbox',
					'section'  		=> 'cc_caboodle_gform_section',
					'settings'		=> 'cc_caboodle[gform]',
				)
			)
		);

		$wp_customize->add_setting( 'cc_caboodle[gform_border_color]',
			array(
				'default'			=> '#cecece',
				'sanitize_callback'	=> 'sanitize_hex_color',
				'type'				=> 'option',
				'transport'			=> 'postMessage',
			)
		);
		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize, 'cc_caboodle_gform_border_color',
				array(
					'label'			=> esc_html__( 'Border color', 'cubecolour-caboodle' ),
					'section'		=> 'cc_caboodle_gform_section',
					'settings'		=> 'cc_caboodle[gform_border_color]',
				)
			)
		);

		$wp_customize->add_setting( 'cc_caboodle[gform_border_color_hover]',
			array(
				'default'			=> '#8e8e8e',
				'sanitize_callback'	=> 'sanitize_hex_color',
				'type'				=> 'option',
				'transport'			=> 'postMessage',
			)
		);
		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize, 'cc_caboodle_gform_border_color_hover',
				array(
					'label'			=> esc_html__( 'Border color: hover', 'cubecolour-caboodle' ),
					'section'		=> 'cc_caboodle_gform_section',
					'settings'		=> 'cc_caboodle[gform_border_color_hover]',
				)
			)
		);

		$wp_customize->add_setting( 'cc_caboodle[gform_border_color_focus]',
			array(
				'default'			=> '#3e3e3e',
				'sanitize_callback'	=> 'sanitize_hex_color',
				'type'				=> 'option',
				'transport'			=> 'postMessage',
			)
		);
		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize, 'cc_caboodle_gform_border_color_focus',
				array(
					'label'			=> esc_html__( 'Border color: focus', 'cubecolour-caboodle' ),
					'section'		=> 'cc_caboodle_gform_section',
					'settings'		=> 'cc_caboodle[gform_border_color_focus]',
				)
			)
		);
	}

}
add_action( 'customize_register', 'cc_caboodle_customize_register' );