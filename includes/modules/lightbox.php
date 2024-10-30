<?php


if ( ! defined( 'ABSPATH' ) ) exit;

function cc_caboodle_lightbox_register() {
	wp_register_style( 'baguettebox', CC_CABOODLE_PLUGIN_URL . 'css/lightbox.css', [], '1.11.1' );
	wp_register_script( 'baguettebox', CC_CABOODLE_PLUGIN_URL . 'js/lightbox.js', [], '1.11.1', true );

	$lightbox_selector = apply_filters( 'baguettebox_selector', '.wp-block-gallery,:not(.wp-block-gallery)>.wp-block-image,.wp-block-media-text__media,.gallery,.wp-block-coblocks-gallery-masonry,.wp-block-coblocks-gallery-stacked,.wp-block-coblocks-gallery-collage,.wp-block-coblocks-gallery-offset,.wp-block-coblocks-gallery-stacked,.mgl-gallery,.gb-block-image' );

	$lightbox_filter = apply_filters( 'baguettebox_filter',  '/.+\.(gif|jpe?g|png|webp|svg|avif|heif|heic|tif?f|)($|\?)/i' );

	wp_add_inline_script( 'baguettebox', 'window.addEventListener("load", function() {baguetteBox.run("' . $lightbox_selector . '",{captions:function(t){var e=t.parentElement.classList.contains("wp-block-image")||t.parentElement.classList.contains("wp-block-media-text__media")?t.parentElement.querySelector("figcaption"):t.parentElement.parentElement.querySelector("figcaption,dd");return!!e&&e.innerHTML},filter:' . $lightbox_filter . '});});' );

}
add_action( 'wp_enqueue_scripts', 'cc_caboodle_lightbox_register' );

function cc_caboodle_lightbox_enqueue() {

	$lightbox_enqueue_assets = apply_filters( 'baguettebox_enqueue_assets',
		has_block( 'core/gallery' ) ||
		has_block( 'core/image' ) ||
		has_block( 'core/media-text' ) ||
		get_post_gallery() ||
		has_block( 'coblocks/gallery-masonry' ) ||
		has_block( 'coblocks/gallery-stacked' ) ||
		has_block( 'coblocks/gallery-collage' ) ||
		has_block( 'coblocks/gallery-offset' ) ||
		has_block( 'coblocks/gallery-stacked' ) ||
		has_block( 'meow-gallery/gallery' ) ||
		has_block( 'generateblocks/image' )
	);

	if ( $lightbox_enqueue_assets ) {
		wp_enqueue_script( 'baguettebox' );
		wp_enqueue_style( 'baguettebox' );
	}
}
add_action( 'wp_enqueue_scripts', 'cc_caboodle_lightbox_enqueue' );
