<?php
/**
 * Recommended plugins
 *
 * @package   New York WordPress Theme
 * @author    Alexander Clarke
 * @copyright Copyright (c) 2015, WPExplorer.com
 * @link      http://www.wpexplorer.com
 * @since     1.0.0
 */

// Prevent direct file access
if ( ! defined ( 'ABSPATH' ) ) {
	exit;
}

/**
* Returns array of recommended plugins
*
* @since 1.0.0
*/
function wpex_recommended_plugins() {
	return apply_filters( 'wpex_recommended_plugins', array(
		'wpex-user-social-profiles' => array(
			'name'             => 'WPEX User Social Profiles',
			'slug'             => 'wpex-user-social-profiles',
			'required'         => false,
			'force_activation' => false,
			'source'           => WPEX_INC_DIR_URI . '/plugins/wpex-user-social-profiles.zip',
		),
		'waspthemes-yellow-pencil' => array(
			'name'             => 'Yellow pencil',
			'slug'             => 'waspthemes-yellow-pencil',
			'source'           => WPEX_INC_DIR_URI . '/plugins/waspthemes-yellow-pencil.zip',
			'required'         => false,
			'force_activation' => false,
		),
		'contact-form-7'       => array(
			'name'             => 'Contact Form 7',
			'slug'             => 'contact-form-7',
			'required'         => false,
			'force_activation' => false,
		),
		'woocommerce'       => array(
			'name'             => 'WooCommerce',
			'slug'             => 'woocommerce',
			'required'         => false,
			'force_activation' => false,
		),
	) );
}

function wpex_tgmpa_register() {
	tgmpa( wpex_recommended_plugins(), array(
		'id'           => 'wpex_theme',
		'domain'       => 'total',
		'menu'         => 'install-required-plugins',
		'has_notices'  => true,
		'is_automatic' => true,
		'parent_slug'  => 'themes.php'
	) );
}
add_action( 'tgmpa_register', 'wpex_tgmpa_register' );