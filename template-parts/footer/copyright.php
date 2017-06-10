<?php
/**
 * Footer bottom
 *
 * @package   New York WordPress Theme
 * @author    Alexander Clarke
 * @copyright Copyright (c) 2015, WPExplorer.com
 * @link      http://www.wpexplorer.com
 * @since     1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Display copyright
if ( $copy = wpex_get_theme_mod( 'footer_copyright' ) ) : ?>

	<div class="footer-copyright wpex-clr"<?php wpex_schema_markup( 'footer_copyright' ); ?>>

		<?php echo wp_kses_post( do_shortcode( $copy ) ); ?>
		
	</div><!-- .footer-copyright -->

<?php endif; ?>