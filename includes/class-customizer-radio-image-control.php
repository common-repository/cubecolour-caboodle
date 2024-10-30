<?php

if ( ! defined( 'ABSPATH' ) ) exit;

/*
 * props: https://napitwptech.com/tutorial/wordpress-development/extend-customizer-options-include-radio-image-option/
 *
 **/

if ( !class_exists( 'Cubecolour_Image_Radio_Control' ) ) {

	class Cubecolour_Image_Radio_Control extends WP_Customize_Control {

		public function enqueue() {
			wp_enqueue_script( 'customizer-radio-image-control', CC_CABOODLE_PLUGIN_URL . 'js/customizer-radio-image-control.js', array( 'jquery' ), CC_CABOODLE_PLUGIN_VERSION, true );
			wp_enqueue_style( 'customizer-radio-image-control', CC_CABOODLE_PLUGIN_URL . 'css/customizer-radio-image-control.css', array(), CC_CABOODLE_PLUGIN_VERSION );
		}

		public function render_content() {

			if ( empty( $this->choices ) )
				return;

			$name = '_customize-radio-' . $this->id;
			?>
			<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
			<ul class="controls" id='caboodle-img-container'>
				<?php
				foreach ( $this->choices as $value => $label ) :
					$class = ( $this->value() == $value ) ? 'caboodle-radio-img-selected caboodle-radio-img' : 'caboodle-radio-img';
					?>
					<li style="display: inline;">
						<label>
							<input <?php $this->link(); ?>style = 'display:none' type="radio" value="<?php echo esc_html( $value ); ?>" name="<?php echo esc_attr( $name ); ?>" <?php
														  $this->link();
														  checked( $this->value(), esc_attr( $value ) );
														  ?> />
							<img src='<?php echo esc_url( $label ); ?>' class='<?php echo esc_attr( $class ); ?>' />
						</label>
					</li>
					<?php
				endforeach;
				?>
			</ul>
			<?php
		}
	}
}