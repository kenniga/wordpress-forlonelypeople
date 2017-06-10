<?php
/**
 * Header settings
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

$panels['general']['sections']['general'] = array(
	'title' => esc_html__( 'Header', 'wpex-new-york' ),
	'settings' => array(
		array(
			'id' => 'sticky_main_menu',
			'default' => true,
			'control' => array(
				'label' => esc_html__( 'Sticky Menu', 'wpex-new-york' ),
				'type' => 'checkbox',
			),
		),
		array(
			'id' => 'logo',
			'control' => array(
				'label' => esc_html__( 'Custom Logo', 'wpex-new-york' ),
				'type' => 'upload',
			),
		),
		array(
			'id' => 'logo_retina',
			'control' => array(
				'label' => esc_html__( 'Custom Retina Logo', 'wpex-new-york' ),
				'type' => 'upload',
			),
		),
		array(
			'id' => 'logo_retina_height',
			'control' => array(
				'label' => esc_html__( 'Standard Logo Height', 'wpex-new-york' ),
				'desc' => esc_html__( 'Enter the standard height for your logo. Used to set your retina logo to the correct dimensions.', 'wpex-new-york' ),
				'type' => 'number',
			),
		),
		array(
			'id' => 'header_description',
			'default' => true,
			'control' => array(
				'label' => esc_html__( 'Display Site Description?', 'wpex-new-york' ),
				'type' => 'checkbox',
			),
		),
	),
);