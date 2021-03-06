<?php
/**
 * Footer settings
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

$panels['general']['sections']['footer'] = array(
	'title' => esc_html__( 'Footer', 'wpex-new-york' ),
	'settings' => array(
		array(
			'id' => 'footer_widget_columns',
			'default' => 'none',
			'control' => array(
				'label' => esc_html__( 'Footer Widgets Columns', 'wpex-new-york' ),
				'type' => 'select',
				'choices' => array(
					'none' => esc_html__( 'None - Disable', 'wpex-new-york' ),
					1 => 1,
					2 => 2,
					3 => 3,
					4 => 4,
				),
				'desc' =>  esc_html__( 'Because of how WordPress works if you alter this option you must save the Customizer and refresh the page if you wish to use the added widget areas.', 'wpex-new-york' ),
			),
		),
		array(
			'id' => 'footer_bottom',
			'default' => true,
			'control' => array(
				'label' => esc_html__( 'Footer Bottom', 'wpex-new-york' ),
				'type' => 'checkbox',
				'desc' =>  esc_html__( 'Enable the Footer Bottom section which displays the copyright content and Social Footer widget area.', 'wpex-new-york' ),
			),
		),
		array(
			'id' => 'footer_copyright',
			'default' => '<a href="http://www.wordpress.org" title="WordPress" target="_blank">WordPress</a> Theme Designed &amp; Developed by <a href="http://www.wpexplorer.com/" target="_blank" title="WPExplorer">WPExplorer</a>',
			'control' => array(
				'label' => esc_html__( 'Footer Copyright', 'wpex-new-york' ),
				'type' => 'textarea',
				'desc' =>  esc_html__( 'Use shortcode [wpex_current_year] to display current year.', 'wpex-new-york' ),
			),
		),
	),
);