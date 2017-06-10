<?php
/**
 * Retina logo suppport
 *
 * @package   New York WordPress Theme
 * @author    Alexander Clarke
 * @copyright Copyright (c) 2015, WPExplorer.com
 * @link      http://www.stplorer.com
 * @since     1.0.0
 */

function wpex_retina_logo() {
	$url    = esc_url( wpex_get_translated_theme_mod( 'logo_retina' ) );
	$height = intval( wpex_get_translated_theme_mod( 'logo_retina_height' ) );
	if ( $url && $height ) {
		$js = 'jQuery(function($){if (window.devicePixelRatio >= 2) {$(".gds-site-logo img").attr("src", "'. $url .'");$("#gds-site-logo img").css("height", "'. $height .'");}});';
		wp_add_inline_script( WPEX_THEME_MAIN_JS_HANDLE, $js, 'after' );
	}
}
add_filter( 'wp_enqueue_scripts', 'wpex_retina_logo' );