<?php

if ( ! defined( 'ABSPATH' ) ) exit;

/*
 * props: https://github.com/soderlind/class-customizer-range-value-control/blob/master/class-customizer-range-value-control.php
 **/
 
if ( ! defined( 'ABSPATH' ) ) exit;

if ( !class_exists( 'Cubecolour_Range_Value_Control' ) ) {
	
	class Cubecolour_Range_Value_Control extends \WP_Customize_Control {
	
		public $type = 'range-value';
	
		/**
		 * Enqueue scripts/styles.
		 *
		 */
		public function enqueue() {
			wp_enqueue_script( 'customizer-range-value-control', CC_CABOODLE_PLUGIN_URL . 'js/customizer-range-value-control.js', array( 'jquery' ), CC_CABOODLE_PLUGIN_VERSION, true );
			wp_enqueue_style( 'customizer-range-value-control', CC_CABOODLE_PLUGIN_URL . 'css/customizer-range-value-control.css', array(), CC_CABOODLE_PLUGIN_VERSION );
		}
	
		/**
		 * Render the control's content.
		 *
		 */
		public function render_content() {
			?>
			<label>
				<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
				<div class="range-slider"  style="width:100%; display:flex;flex-direction: row;justify-content: flex-start;">
					<span  style="width:100%; flex: 1 0 0; vertical-align: middle;"><input class="range-slider__range" type="range" value="<?php echo esc_attr( $this->value() ); ?>"
																																					  <?php
																																						$this->input_attrs();
																																						$this->link();
																																						?>
					>
					<span class="range-slider__value">0</span></span>
				</div>
				<?php if ( ! empty( $this->description ) ) : ?>
				<span class="description customize-control-description"><?php echo esc_attr( $this->description ); ?></span>
				<?php endif; ?>
			</label>
			<?php
		}
	}
}