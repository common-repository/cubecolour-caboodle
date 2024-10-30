jQuery(function($){

	function showhide( optn ) {

		var select = '#customize-control-cc_caboodle_'+ optn + ' input[type=checkbox]';
		
		// Select all controls and separators
		var controls = document.querySelectorAll('[id^="customize-control-cc_caboodle_'+ optn + '_"], .customize-control-separator');


		if ( !$( select ).is(':checked') ) {
			$( controls ).hide();
		}

		wp.customize( 'cc_caboodle[' + optn + ']', function( value ) {
			value.bind( function( newval ) {

				if ( $( select ).is(':checked') ) {
					$( controls ).slideDown(250);
				} else {
					$( controls ).slideUp(250);
				}
			});
		});
	}

	showhide( 'login_bg' );
	showhide( 'login_error' );
	showhide( 'login_warning' );
	showhide( 'passvis' );
	showhide( 'no_howdy' );
	showhide( 'limit_revisions' );
	showhide( 'scrolltop' );
	showhide( 'limitrev' );
	showhide( 'years' );
	showhide( 'devlink' );
	showhide( 'show_ids' );
	showhide( 'no_admin_bar' );
	showhide( 'text_selection' );
	showhide( 'add_image_sizes' );
	showhide( 'breakpoint' );
	showhide( 'excerpts' );
	showhide( 'extlink' );
	showhide( 'wavylinks' );
	showhide( 'stomp' );
	showhide( 'polylang' );
	showhide( 'gform' );


	/**
	 * Posts: show/hide controls on page load & when checkbox clicked (works reverse of others)
	 */
	var login_error_selector = '#customize-control-cc_caboodle_no_posts input[type=checkbox]';
	var login_error_controls = '#customize-control-cc_caboodle_rename_posts';

	if ( $( login_error_selector ).is(':checked') ) {
		$( login_error_controls ).hide();
	}

	wp.customize( 'cc_caboodle[no_posts]', function( value ) {
		value.bind( function( newval ) {

			if ( $( login_error_selector ).is(':checked') ) {
				$( login_error_controls ).slideUp(250);
			} else {
				$( login_error_controls ).slideDown(250);
			}
		});
	});

});