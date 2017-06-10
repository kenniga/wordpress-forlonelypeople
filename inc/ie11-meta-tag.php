<?php
/**
 * Set IE 11 in IE 10 mode
 *
 * @package   New York WordPress Theme
 * @author    Alexander Clarke
 * @copyright Copyright (c) 2015, WPExplorer.com
 * @link      http://www.wpexplorer.com
 * @since     1.0.0
 */

function wpex_ie11_meta_tag() {
	echo '<meta http-equiv="X-UA-Compatible" content="IE=edge" />';
}
add_action( 'wp_head', 'wpex_ie11_meta_tag' );