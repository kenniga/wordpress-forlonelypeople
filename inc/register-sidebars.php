<?php
/**
 * Register sidebars
 *
 * @link   http://codex.wordpress.org/Function_Reference/register_sidebar
 *
 * @package   New York WordPress Theme
 * @author    Alexander Clarke
 * @copyright Copyright (c) 2015, WPExplorer.com
 * @link      http://www.wpexplorer.com
 * @since     1.0.0
 */

if ( ! function_exists( 'wpex_register_sidebars' ) ) {

	function wpex_register_sidebars() {

		// Main Sidebar
		register_sidebar( array(
			'name'          => esc_html__( 'Sidebar - Main', 'wpex-new-york' ),
			'id'            => 'wpex_sidebar',
			'before_widget' => '<div id="%1$s" class="widget %2$s wpex-clr">',
			'after_widget'  => '</div>',
			'before_title'  => '<'. wpex_get_html_tag( 'sidebar_widget_title' ) .' class="widget-title"><span>',
			'after_title'   => '</span></'. wpex_get_html_tag( 'sidebar_widget_title' ) .'>',
			'description'   => esc_html__( 'Main sidebar displayed across the whole site.', 'wpex-new-york' ),
		) );

		// Pages Sidebar
		register_sidebar( array(
			'name'          => esc_html__( 'Sidebar - Pages', 'wpex-new-york' ),
			'id'            => 'wpex_sidebar_pages',
			'before_widget' => '<div id="%1$s" class="widget %2$s wpex-clr">',
			'after_widget'  => '</div>',
			'before_title'  => '<div class="widget-title"><span>',
			'after_title'   => '</span></div>',
			'description'   => esc_html__( 'Will override the Main sidebar for pages only.', 'wpex-new-york' ),
		) );

		// Instagram Footer
		register_sidebar( array(
			'name'          => esc_html__( 'Instagram - Footer', 'wpex-new-york' ),
			'id'            => 'wpex_instagram_footer',
			'before_widget' => '<div id="%1$s" class="widget %2$s wpex-clr">',
			'after_widget'  => '</div>',
			'before_title'  => '<div class="widget-title"><span>',
			'after_title'   => '</span></div>',
			'description'   => esc_html__( 'Widget area specifically for a full-width instagram grid in the footer area, but you can technically add any widgets you want.', 'wpex-new-york' ),
		) );

		// Footer Social Links
		register_sidebar( array(
			'name'          => esc_html__( 'Social - Footer', 'wpex-new-york' ),
			'id'            => 'wpex_social_footer',
			'before_widget' => '<div id="%1$s" class="widget %2$s wpex-clr">',
			'after_widget'  => '</div>',
			'before_title'  => '<div class="widget-title"><span>',
			'after_title'   => '</span></div>',
			'description'   => esc_html__( 'Widget area specifically for adding the "Social Profiles" to the bottom of the site under the copyright text, but you can technically add any widgets you want.', 'wpex-new-york' ),
		) );

		// Get footer columns
		if ( $cols = wpex_get_footer_widget_columns() ) {
			$cols = intval( $cols );
			$x = 1;
			while ( $x <= $cols ) {
				register_sidebar( array(
					'name'          => esc_html__( 'Footer', 'wpex-new-york' ) .' '. $x,
					'id'            => 'wpex_footer_'. $x,
					'before_widget' => '<div id="%1$s" class="widget %2$s wpex-clr">',
					'after_widget'  => '</div>',
					'before_title'  => '<div class="widget-title"><span>',
					'after_title'   => '</span></div>',
				) );
				$x++;
			}
		}

	}

}
add_action( 'widgets_init', 'wpex_register_sidebars' );