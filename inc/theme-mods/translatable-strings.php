<?php
/**
 * Configures Translators (WPMl, Polylang, etc)
 *
 * @package   New York WordPress Theme
 * @author    Alexander Clarke
 * @copyright Copyright (c) 2015, WPExplorer.com
 * @link      http://www.wpexplorer.com
 * @since     1.0.0
 */

add_filter( 'wpex_register_theme_mod_strings', function() {
	return array(
		'wpex_logo'                    => '',
		'wpex_logo_retina'             => '',
		'wpex_logo_retina_height'      => '',
		'wpex_home_slider_custom_code' => '',
		'wpex_footer_copyright'        => '<a href="http://www.wordpress.org" title="WordPress" target="_blank">WordPress</a> Theme Designed &amp; Developed by <a href="http://www.wpexplorer.com/" target="_blank" title="WPExplorer">WPExplorer</a>',
	);
} );