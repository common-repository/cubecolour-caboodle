( function( $ ) {

	/**
	* Text selection color
	*
	*/
	wp.customize( 'cc_caboodle[text_selection_color]', function( value ) {
		value.bind( function( newval ) {
			$( 'head').append('<style>::selection { color:' + newval + '!important;}</style>');
		} );
	} );

	/**
	* Text selection background color
	*
	*/
	wp.customize( 'cc_caboodle[text_selection_bgcolor]', function( value ) {
		value.bind( function( newval ) {
			$( 'head').append('<style>::selection { background-color:' + newval + '!important;}</style>');
		} );
	} );

	/**
	* Add caboodle dashicons
	*
	*/
	wp.customize( 'cc_caboodle[add_dashicons]', function( value ) {
		value.bind( function( newval ) {
			$( 'span' ).attr( 'data-show_dashicons', newval );	
		} );
	} );

	/**
	* Scrolltop icon
	*
	*/
	wp.customize( 'cc_caboodle[scrolltop_icon]', function( value ) {
		value.bind( function( newval ) {
			$( '.scrolltop' ).css( '--scrolltop-icon', '"' + newval + '"' );
		} );
	} );

	/**
	* Scrolltop 'button' diameter
	*
	*/
	wp.customize( 'cc_caboodle[scrolltop_size]', function( value ) {
		value.bind( function( newval ) {
			$( '.scrolltop' ).css( '--scrolltop-size', newval );
		} );
	} );

	/**
	* Scrolltop 'button' padding
	*
	*/
	wp.customize( 'cc_caboodle[scrolltop_padding]', function( value ) {
		value.bind( function( newval ) {
			$( '.scrolltop' ).css( '--scrolltop-padding', newval );
		} );
	} );

	/**
	* Scrolltop border width
	*
	*/
	wp.customize( 'cc_caboodle[scrolltop_border_width]', function( value ) {
		value.bind( function( newval ) {
			$( '.scrolltop' ).css( '--scrolltop-border-width', newval );
		} );
	} );

	/**
	* Scrolltop radius
	*
	*/
	wp.customize( 'cc_caboodle[scrolltop_radius]', function( value ) {
		value.bind( function( newval ) {
			$( '.scrolltop' ).css( '--scrolltop-radius', newval );
		} );
	} );

	/**
	* Scrolltop right
	*
	*/
	wp.customize( 'cc_caboodle[scrolltop_right]', function( value ) {
		value.bind( function( newval ) {
			$( '.scrolltop' ).css( '--scrolltop-right', newval );
		} );
	} );

	/**
	* Scrolltop bottom
	*
	*/
	wp.customize( 'cc_caboodle[scrolltop_bottom]', function( value ) {
		value.bind( function( newval ) {
			$( '.scrolltop' ).css( '--scrolltop-bottom', newval );
		} );
	} );

	/**
	* Scrolltop color
	*
	*/
	wp.customize( 'cc_caboodle[scrolltop_color]', function( value ) {
		value.bind( function( newval ) {
			$( '.scrolltop' ).css( '--scrolltop-color', newval );
		} );
	} );

	/**
	* Scrolltop background color
	*
	*/
	wp.customize( 'cc_caboodle[scrolltop_bgcolor]', function( value ) {
		value.bind( function( newval ) {
			$( '.scrolltop' ).css( '--scrolltop-bg-color', newval );
		} );
	} );

	/**
	* Scrolltop color hover
	*
	*/
	wp.customize( 'cc_caboodle[scrolltop_color_hover]', function( value ) {
		value.bind( function( newval ) {
			$( '.scrolltop' ).css( '--scrolltop-color-hover', newval );
		} );
	} );

	/**
	* Scrolltop background color hover
	*
	*/
	wp.customize( 'cc_caboodle[scrolltop_bgcolor_hover]', function( value ) {
		value.bind( function( newval ) {
			$( '.scrolltop' ).css( '--scrolltop-bg-color-hover', newval );
		} );
	} );


	/**
	* Stomp
	*
	*/
	wp.customize('cc_caboodle[stomp]', function(value) {
		value.bind(function(newval) {

			// Get the footer element
			var footer = wp.customize( 'cc_caboodle[stomp_element]' ).get()

			if (newval) {
				// If the 'stomp' setting is true, stick the footer to the bottom of the page
				$( footer ).css( 'position', 'fixed' );
				$( footer ).css( 'bottom', '0' );
				$( footer ).css( 'width', '100%' );

			} else {
				// If the 'stomp' setting is false, position the footer normally
				$( footer ).css( 'position', 'static' );
			}
		});
	});

	/**
	* Stomp Element
	*
	*/
	wp.customize('cc_caboodle[stomp_element]', function(value) {
		value.bind(function( newval ) {

			// Get the footer element
			var stomp = wp.customize( 'cc_caboodle[stomp]' ).get()

			if ( stomp ) {
				// If the 'stomp' setting is true, stick the footer to the bottom of the page
				$( newval ).css( 'position', 'fixed' );
				$( newval ).css( 'bottom', '0' );
				$( newval ).css( 'width', '100%' );

			} else {
				// If the 'stomp' setting is false, position the footer normally
				// this should never occur as the stomp_element control can only be seen and interacted with when stomp is true
				$( newval ).css( 'position', 'static' );
			}
		});
	});
		

	/**
	* External links icon
	*
	*/
	wp.customize( 'cc_caboodle[extlink_icon]', function( value ) {
		value.bind( function( newval ) {
			$( 'a' ).css( '--extlink-icon', '"' + newval + '"' );
		} );
	} );

	/**
	* External links size
	*
	*/
	wp.customize( 'cc_caboodle[extlink_size]', function( value ) {
		value.bind( function( newval ) {
			$( 'a' ).css( '--extlink-size', newval + 'px' );
		} );
	} );

	/**
	* External links vertical position (px)
	*
	*/
	wp.customize( 'cc_caboodle[extlink_vpos]', function( value ) {
		value.bind( function( newval ) {
			$( 'a' ).css( '--extlink-vpos', ( newval ) + 'px' );
		} );
	} );

	/**
	* External links color
	*
	*/
	wp.customize( 'cc_caboodle[extlink_color]', function( value ) {
		value.bind( function( newval ) {
			$( 'a' ).css( '--extlink-color', newval );
		} );
	} );

	/**
	* External links color hover
	*
	*/
	wp.customize( 'cc_caboodle[extlink_color_hover]', function( value ) {
		value.bind( function( newval ) {
			$( 'a' ).css( '--extlink-color-hover', newval );
		} );
	} );

	/**
	* Wavy links gap
	*
	*/
	wp.customize( 'cc_caboodle[wavylinks_gap]', function( value ) {
		value.bind( function( newval ) {
			$( 'a' ).css( '--wavylinks-gap', newval );
		} );
	} );	
	
	/**
	* Polylang flag size
	*
	*/
	wp.customize( 'cc_caboodle[polylang_flag_width]', function( value ) {
		value.bind( function( newval ) {
			$( 'head').append('<style>.lang-item img { width:' + newval + 'px!important;}</style>');
		} );
	} );

	/**
	* Polylang flag grayscale
	*
	*/
	wp.customize( 'cc_caboodle[polylang_flag_grayscale]', function( value ) {
		value.bind( function( newval ) {
			$( '.lang-item' ).css( '--flag-grayscale', 'grayscale(' + ( newval ) + '%)' );
		} );
	} );

	/**
	* Polylang flag opacity
	*
	*/
	wp.customize( 'cc_caboodle[polylang_flag_opacity]', function( value ) {
		value.bind( function( newval ) {
			$( '.lang-item' ).css( '--flag-opacity', ( newval ) + '%' );
		} );
	} );

	/**
	* Polylang flag spacing
	*
	*/
	wp.customize( 'cc_caboodle[polylang_flag_spacing]', function( value ) {
		value.bind( function( newval ) {
			$( '.lang-item:not(first-of-type)' ).css( 'margin-left', ( newval -4 ) + 'px' );
		} );
	} );

	/**
	* Gravity form border color
	*
	*/
	wp.customize( 'cc_caboodle[gform_border_color]', function( value ) {
		value.bind( function( newval ) {
			$( '.gform_body' ).css( '--gform-border-color', newval );
		} );
	} );

	/**
	* Gravity form border color: hover
	*
	*/
	wp.customize( 'cc_caboodle[gform_border_color_hover]', function( value ) {
		value.bind( function( newval ) {
			$( '.gform_body' ).css( '--gform-border-color-hover', newval );
		} );
	} );

	/**
	* Gravity form border color: focus
	*
	*/
	wp.customize( 'cc_caboodle[gform_border_color_focus]', function( value ) {
		value.bind( function( newval ) {
			$( '.gform_body' ).css( '--gform-border-color-focus', newval );
		} );
	} );

} )( jQuery );