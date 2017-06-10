<?php
/**
 * Yoast SEO Fixes
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

// Start Class
if ( ! class_exists( 'WPEX_Yoast_SEO_Config' ) ) {
	
	class WPEX_Yoast_SEO_Config {

		/**
		 * Start things up
		 *
		 * @version 1.0.0
		 */
		public function __construct() {
			add_filter( 'wpseo_breadcrumb_output', array( 'WPEX_Yoast_SEO_Config', 'yoast_breadcrumbs_fixes' ) );
		}

		/**
		 * Fix some validation errors with Yoast breadcrumbs
		 *
		 * @since 1.0.0
		 */
		public static function yoast_breadcrumbs_fixes( $output ) {

			$output = preg_replace( array( '#<span xmlns:v="http://rdf.data-vocabulary.org/\#">#', '#<span typeof="v:Breadcrumb"><a href="(.*?)" .*?'.'>(.*?)</a></span>#', '#<span typeof="v:Breadcrumb">(.*?)</span>#','# property=".*?"#','#</span>$#'), array('','<span itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="$1" itemprop="url"><span itemprop="title">$2</span></a></span>', '<span itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><span itemprop="title">$1</span></span>', '', '' ), $output );

			return $output;

		}

	}

	new WPEX_Yoast_SEO_Config;

}