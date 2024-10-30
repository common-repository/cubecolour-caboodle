<?php

/**
 * Wavy Links
 *
 */
if ( ! defined( 'ABSPATH' ) ) exit;

function cc_caboodle_wavylinks() {
		if ( cc_caboodle( 'wavylinks', '' ) == '1' ) {
		$color = sanitize_hex_color_no_hash( cc_caboodle( 'wavylinks_color', '#0000ee' ) );
		$color_hover = sanitize_hex_color_no_hash( cc_caboodle( 'wavylinks_color_hover', '#ee0000' ) );
		
		$gap = absint( cc_caboodle( 'wavylinks_gap', 3 ) );
		$show = cc_caboodle_sanitize_checkbox( cc_caboodle( 'wavylinks_show', '' ) );
	
		$selector = cc_caboodle( 'wavylinks_selector', 'html body .entry-content a, footer a' );
		$selector_hover = str_replace(",", ':hover,', $selector) . ':hover';
	
		$wavylinkstyle = 
		'body a {
			--wavylinks-gap:' . $gap . ';
		}';
	
		if ( $show == 1 ) {
		$wavylinkstyle .=
		$selector . ' {
		text-decoration: none;
		padding-bottom: calc(var(--wavylinks-gap) * 1px);
		background-image: url("data:image/svg+xml;charset=utf8,%3Csvg id=\'wavy-link\' xmlns=\'http://www.w3.org/2000/svg\' xmlns:xlink=\'http://www.w3.org/1999/xlink\' xmlns:ev=\'http://www.w3.org/2001/xml-events\' viewBox=\'0 0 10 18\'%3E%3Cstyle type=\'text/css\'%3E.wavy%7B%7D%7D%7D%3C/style%3E%3Cpath fill=\'none\' stroke=\'transparent\' stroke-width=\'1\' class=\'wavy\' d=\'M0,17.5 c 2.5,0,2.5,-1.5,5,-1.5 s 2.5,1.5,5,1.5 c 2.5,0,2.5,-1.5,5,-1.5 s 2.5,1.5,5,1.5\' /%3E%3C/svg%3E");
	}';

		} else {
		$wavylinkstyle .=
		$selector . ' {	
		text-decoration: none;
		padding-bottom: calc(var(--wavylinks-gap) * 1px);
		background-image: url("data:image/svg+xml;charset=utf8,%3Csvg id=\'wavy-link\' xmlns=\'http://www.w3.org/2000/svg\' xmlns:xlink=\'http://www.w3.org/1999/xlink\' xmlns:ev=\'http://www.w3.org/2001/xml-events\' viewBox=\'0 0 10 18\'%3E%3Cstyle type=\'text/css\'%3E.wavy%7B%7D%7D%7D%3C/style%3E%3Cpath fill=\'none\' stroke=\'%23' . $color . '\' stroke-width=\'1\' class=\'wavy\' d=\'M0,17.5 c 2.5,0,2.5,-1.5,5,-1.5 s 2.5,1.5,5,1.5 c 2.5,0,2.5,-1.5,5,-1.5 s 2.5,1.5,5,1.5\' /%3E%3C/svg%3E");
	}';
		}
	
		$wavylinkstyle .=
		$selector_hover . ' {
		border-bottom: none;
		padding-bottom: calc(var(--wavylinks-gap) * 1px);
		background-repeat: repeat;
		background-image: url("data:image/svg+xml;charset=utf8,%3Csvg id=\'wavy-link\' xmlns=\'http://www.w3.org/2000/svg\' xmlns:xlink=\'http://www.w3.org/1999/xlink\' xmlns:ev=\'http://www.w3.org/2001/xml-events\' viewBox=\'0 0 10 18\'%3E%3Cstyle type=\'text/css\'%3E.wavy%7Banimation:shift .5s linear infinite;%7D@keyframes shift %7Bfrom %7Btransform:translateX(-10px);%7Dto %7Btransform:translateX(0);%7D%7D%3C/style%3E%3Cpath fill=\'none\' stroke=\'%23' . $color_hover . '\' stroke-width=\'1\' class=\'wavy\' d=\'M0,17.5 c 2.5,0,2.5,-1.5,5,-1.5 s 2.5,1.5,5,1.5 c 2.5,0,2.5,-1.5,5,-1.5 s 2.5,1.5,5,1.5\' /%3E%3C/svg%3E");
	}';

		wp_add_inline_style( 'cc-caboodle', $wavylinkstyle );
	}
}
add_action( 'wp_enqueue_scripts', 'cc_caboodle_wavylinks' );