<?php
/**
 * Include Framework Widgets
 *
 * @author    Alexander Clarke
 * @copyright Copyright (c) 2015, WPExplorer.com
 * @link      http://www.wpexplorer.com
 * @since     1.0.0
 */

// Prevent direct file access
if ( ! defined ( 'ABSPATH' ) ) {
	exit;
}

function wpex_include_framework_widgets() {

	// Define dir
	$dir = WPEX_INC_DIR .'/widgets/classes/';

	// Apply filters so you can remove custom widgets via a child theme or plugin
	$widgets = apply_filters( 'wpex_theme_widgets', array(
		'about',
		'social',
		'instagram-grid',
		'facebook-page',
		'video',
		'posts-thumbnails',
		'comments-avatar',
	) );

	// Loop through and load widget files
	foreach ( $widgets as $widget ) {
		$widget_file = $dir . $widget .'.php';
		if ( file_exists( $widget_file ) ) {
			require_once( $widget_file );
	   }
	}

}

add_action( 'widgets_init', 'wpex_include_framework_widgets' );