<?php
/**
 * Yellow Pencil Tweaks
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

// Make sure plugin is active
if ( ! defined( 'WT_PLUGIN_DIR' ) ) {
	return;
}

// Start Class
if ( ! class_exists( 'WPEX_Yellow_Pencil_Config' ) ) {
	
	class WPEX_Yellow_Pencil_Config {

		/**
		 * Start things up
		 *
		 * @version 1.0.0
		 */
		public function __construct() {
			//define( 'WT_DEMO_MODE', 'true' );

			// Set to theme mode
			add_site_option( 'YP_PART_OF_THEME', 'true' );

			// Remove update notice
			remove_action( 'admin_notices', 'yp_update_message' );

			// Remove post editor button
			add_action( 'admin_enqueue_scripts', array( 'WPEX_Yellow_Pencil_Config', 'remove_scripts' ), 99 );

		}

		/**
		 * Remove scripts
		 *
		 * @version 1.0.0
		 */
		public static function remove_scripts( $hook ) {
			if ( 'post.php' == $hook ) {
				wp_dequeue_script( 'yellow-pencil-admin' );
			}
		}

	}

	new WPEX_Yellow_Pencil_Config;

}