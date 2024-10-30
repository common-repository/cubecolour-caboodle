<?php

/* props: https://github.com/giantpaper/wp_bandcamp */



if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Embed bandcamp shortcode function
 *
 */
function cc_caboodle_embed_bandcamp( $atts ){
	$atts = shortcode_atts([
		'width'		=> 700,
		'height'	=> 900,
		'album'		=> null,
		'title'		=> null,
		'size'		=> 'large',
		'bgcol'		=> 'ffffff',
		'url'		=> null,
		'linkcol'	=> '0687f5',
		'tracklist' => 'true',
				'title'		=> null,
				'artwork'	=> null,
	], $atts);
	
		$width		= cc_caboodle_sanitize_width( $atts['width'] );
		$height		= absint( $atts['height'] );
		$album		= absint( $atts['album'] );
		$size		= sanitize_text_field( $atts['size'] );
		$bgcol		= sanitize_hex_color_no_hash( $atts['bgcol'] );
		$linkcol	= sanitize_hex_color_no_hash( $atts['linkcol'] );
		$tracklist	= cc_caboodle_sanitize_boolean( $atts['tracklist'] );
		$artwork	= sanitize_text_field( $atts['artwork'] );
		$title		= sanitize_text_field( $atts['title'] );

	if ($album == null)
		return false;

		if ( preg_match("#^[0-9]+$#", $width) ) {
				$width = $width.'px';
		}
		if ( preg_match("#^[0-9]+$#", $height) ) {
				$height = $height.'px';
		}

		$iframe = '<iframe style="border: 0; width: %s; height: %s; display: block; margin: auto;" src="https://bandcamp.com/EmbeddedPlayer/album=%s/size=%s/bgcol=%s/linkcol=%s/tracklist=%s/transparent=true/artwork=%s" title="%s" seamless></iframe>';

	return sprintf('<figure class="wp-block-embed-bandcamp wp-block-embed is-type-audio is-provider-bandcamp wp-embed-aspect-16-9 wp-has-aspect-ratio js">' . '<div class="wp-block-embed__wrapper">' . $iframe . '</div>' . '</figure>',
		$width,
		$height,
		$album,
		$size,
		$bgcol,
		$linkcol,
		$tracklist,
				$artwork,
				$title,
	);
};

add_shortcode( 'bandcamp', 'cc_caboodle_embed_bandcamp' );
