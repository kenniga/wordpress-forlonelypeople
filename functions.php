<?php
/**
 * Main theme setup. Loads all core theme functions and classes.
 *
 * When using a child theme (see http://codex.wordpress.org/Theme_Development
 * and http://codex.wordpress.org/Child_Themes), you can override certain
 * functions (those wrapped in a function_exists() call) by defining them first
 * in your child theme's functions.php file. The child theme's functions.php
 * file is included before the parent theme's file, so the child theme
 * functions would be used.
 *
 *
 * For more information on hooks, actions, and filters,
 * see http://codex.wordpress.org/Plugin_API
 *
 * Text Domain: wpex-new-york
 *
 * @package   New York WordPress Theme
 * @author    Alexander Clarke
 * @copyright Copyright (c) 2015, WPExplorer.com
 * @link      http://www.wpexplorer.com
 * @since     1.0.0
 *
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class New_York_Theme_Setup {

	/**
	 * Start things up
	 *
     * @since  1.0.0
     * @access public
	 */
	public function __construct() {

		// Define constants
		self::define_constants();

		// Load files
		self::load_files();

		// Main theme Setup
		add_action( 'after_setup_theme', array( 'New_York_Theme_Setup', 'setup' ), 10 );

	}

	/**
	 * Define constants
	 *
     * @since  1.0.0
     * @access public
	 */
	public static function define_constants() {
		$dir     = get_template_directory();
		$dir_uri = get_template_directory_uri();
		if ( ! defined( 'WPEX_THEME_NAME' ) ) {
			define( 'WPEX_THEME_NAME', 'New York' );
		}
		define( 'WPEX_THEME_VERSION', '1.4.0' );
		define( 'WPEX_FRAMEWORK_DIR', $dir . '/inc/wpex-framework' );
		define( 'WPEX_FRAMEWORK_DIR_URI', $dir_uri . '/inc/wpex-framework' );
		define( 'WPEX_INC_DIR', $dir . '/inc' );
		define( 'WPEX_INC_DIR_URI', $dir_uri . '/inc' );
		define( 'WPEX_THEME_MAIN_STYLE_HANDLE', 'style' );
		define( 'WPEX_THEME_MAIN_JS_HANDLE', 'wpex-main' );
	}

	/**
	 * Include functions and classes
	 *
     * @since  1.0.0
     * @access public
	 */
	public static function load_files() {

		// Prevent update checks
		require_once( WPEX_FRAMEWORK_DIR . '/disable-wp-update-check.php' );

		// Add Theme meta generator
		require_once( WPEX_INC_DIR . '/meta-generator.php' );

		// Include main framework functions
		require_once( WPEX_FRAMEWORK_DIR . '/constants.php' );
		require_once( WPEX_FRAMEWORK_DIR . '/helpers.php' ); // must load before conditionals
		require_once( WPEX_FRAMEWORK_DIR . '/conditionals.php' );

		// Theme actions
		require_once( WPEX_INC_DIR . '/hooks/partials.php' );
		require_once( WPEX_INC_DIR . '/hooks/actions.php' );

		// Theme Specifc Functions
		require_once( WPEX_INC_DIR . '/recommend-plugins.php' );
		require_once( WPEX_INC_DIR . '/enqueue-css.php' );
		require_once( WPEX_INC_DIR . '/enqueue-js.php' );
		require_once( WPEX_INC_DIR . '/google-fonts.php' );
		require_once( WPEX_INC_DIR . '/ie11-meta-tag.php' );
		require_once( WPEX_INC_DIR . '/menus.php' );
		require_once( WPEX_INC_DIR . '/image-sizes.php' );
		require_once( WPEX_INC_DIR . '/layouts.php' );
		require_once( WPEX_INC_DIR . '/home-slider-ids.php' );
		require_once( WPEX_INC_DIR . '/pre-get-posts.php' );
		require_once( WPEX_INC_DIR . '/register-sidebars.php' );
		require_once( WPEX_INC_DIR . '/body-class.php' );
		require_once( WPEX_INC_DIR . '/advanced-styles.php' );
		require_once( WPEX_INC_DIR . '/meta-pages.php' );
		require_once( WPEX_INC_DIR . '/meta-posts.php' );
		require_once( WPEX_INC_DIR . '/widgets/include-widgets.php' );
		require_once( WPEX_INC_DIR . '/html-tags.php' );
		require_once( WPEX_INC_DIR . '/retina-logo.php' );
		require_once( WPEX_INC_DIR . '/archive-title.php' );
		require_once( WPEX_INC_DIR . '/archive-wrap-classes.php' );
		require_once( WPEX_INC_DIR . '/archive-wrap-data.php' );
		require_once( WPEX_INC_DIR . '/more-link.php' );
		require_once( WPEX_INC_DIR . '/responsive-embeds.php' );
		require_once( WPEX_INC_DIR . '/comments.php' );
		
		require_once( WPEX_INC_DIR . '/blocks-entry.php' );
		require_once( WPEX_INC_DIR . '/blocks-post.php' );
		require_once( WPEX_INC_DIR . '/blocks-page.php' );

		// 3rd party support
		require_once( WPEX_INC_DIR . '/yoast-seo.php' );
		require_once( WPEX_INC_DIR . '/yellow-pencil.php' );

		// WooCommerce Tweaks
		if ( WPEX_WOOCOMMERCE_ACTIVE ) {
			require_once( WPEX_INC_DIR . '/woocommerce/woocommerce.php' );
		}

		// Theme functions that should be last
		require_once( WPEX_INC_DIR . '/theme-mods/callbacks.php' );
		require_once( WPEX_INC_DIR . '/theme-mods/register.php' );
		require_once( WPEX_INC_DIR . '/theme-mods/translatable-strings.php' );

		// Framework Classes/Functions
		require_once( WPEX_FRAMEWORK_DIR . '/dashboard-thumbnails.php' );
		require_once( WPEX_FRAMEWORK_DIR . '/tgmpa/class-tgm-plugin-activation.php' );
		require_once( WPEX_FRAMEWORK_DIR . '/gmb/gmb.php' );
		require_once( WPEX_FRAMEWORK_DIR . '/term-thumbnails/term-thumbnails.php' );
		require_once( WPEX_FRAMEWORK_DIR . '/customizer.php' );
		require_once( WPEX_FRAMEWORK_DIR . '/schema.php' );
		require_once( WPEX_FRAMEWORK_DIR . '/image-sizes.php' );
		require_once( WPEX_FRAMEWORK_DIR . '/font-awesome/font-awesome.php' );
		require_once( WPEX_FRAMEWORK_DIR . '/theme-mod-translations.php' );
		require_once( WPEX_FRAMEWORK_DIR . '/instagram-fetcher.php' );
		require_once( WPEX_FRAMEWORK_DIR . '/move-comment-form-fields.php' );

		// Other filters
		require_once( WPEX_FRAMEWORK_DIR . '/disable-wp-gallery-styles.php' );

	}

	/**
	 * Functions called during each page load, after the theme is initialized
	 * Perform basic setup, registration, and init actions for the theme
	 *
     * @since  1.0.0
     * @access public
	 *
	 * @link   http://codex.wordpress.org/Plugin_API/Action_Reference/after_setup_theme
	 */
	public static function setup() {

		// Define content_width variable
		if ( ! isset( $content_width ) ) {
			$content_width = 1040;
		}

		// Add editor styles
		add_editor_style( 'css/editor-style.css' );
		
		// Localization support
		load_theme_textdomain( 'wpex-new-york', get_template_directory() . '/languages' );
			
		// Add theme support
		add_theme_support( 'title-tag' );
		add_theme_support( 'automatic-feed-links' );
		add_theme_support( 'custom-background' );
		add_theme_support( 'post-thumbnails' );
		
		// Custom header disabled by default
		if ( apply_filters( 'wpex_custom_header', false ) ) {

			add_theme_support( 'custom-header', array(
				'video' => true,
				'video-active-callback' => '__return_true',
			) );
			
		}

		// Add formats
		add_theme_support( 'post-formats', array( 'video', 'audio', 'gallery' ) );

		// Add support for page excerpts
		add_post_type_support( 'page', 'excerpt' );

	}

}
new New_York_Theme_Setup;