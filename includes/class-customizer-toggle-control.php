<?php

/*
 * props: https://madebydenis.com/adding-custom-controls-to-your-customization-api/
 **/
 
if ( ! defined( 'ABSPATH' ) ) exit;

if ( !class_exists( 'Cubecolour_Toggle_Control' ) ) {

	class Cubecolour_Toggle_Control extends WP_Customize_Control{
		public $type = 'toogle_checkbox';
		public function enqueue(){
			wp_enqueue_style( 'customizer-toggle-control', CC_CABOODLE_PLUGIN_URL . 'css/customizer-toggle-control.css', array(), CC_CABOODLE_PLUGIN_VERSION );
		}
		public function render_content(){
			?>
			<div class="checkbox_switch">
				<div class="onoffswitch">
					<input type="checkbox" id="<?php echo esc_attr($this->id); ?>" name="<?php echo esc_attr($this->id); ?>" class="onoffswitch-checkbox" value="<?php echo esc_attr( $this->value() ); ?>" <?php $this->link(); checked( $this->value() ); ?>>
					<label class="onoffswitch-label" for="<?php echo esc_attr($this->id); ?>"></label>
				</div>
				<span class="customize-control-title onoffswitch_label"><?php echo esc_html( $this->label ); ?></span>
				<p><?php echo wp_kses_post($this->description); ?></p>
			</div>
			<?php
		}
	}

}

if ( !function_exists( 'cc_toggle_control_sanitize' ) ) {
	function cc_toggle_control_sanitize( $input ) {	
		// Boolean check 
		return ( ( isset( $input ) && true == $input ) ? true : false );
	}
}