<?php
/**
 * Add metabox to pages
 *
 * @package   Gridster WordPress Theme
 * @author    Alexander Clarke
 * @copyright Copyright (c) 2015, WPExplorer.com
 * @link      http://www.stplorer.com
 * @since     1.0.0
 */

// Only needed for the admin side
if ( ! is_admin() ) {
	return;
}

/** 
 * The Class.
 */
class New_York_Page_Meta_Settings {

	/**
	 * Hook into the appropriate actions when the class is constructed.
	 */
	public function __construct() {
		add_action( 'add_meta_boxes', array( $this, 'add_meta_box' ) );
		add_action( 'save_post', array( $this, 'save' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'load_css' ) );
	}

	/**
	 * Adds the meta box container.
	 */
	public function add_meta_box( $post_type ) {
		if ( 'page' == $post_type ) {
			add_meta_box(
				'wpex_page_settings_metabox',
				esc_html__( 'Page Settings', 'wpex-new-york' ),
				array( $this, 'render_meta_box_content' ),
				'page',
				'side',
				'high'
			);
		}
	}

	/**
	 * Render Meta Box content.
	 *
	 * @param WP_Post $post The post object.
	 */
	public function render_meta_box_content( $post ) {
	
		// Get meta prefix
		$prefix = 'wpex_';

		// Add an nonce field so we can check for it later.
		wp_nonce_field( 'wpe_page_meta_settings_action', 'wpe_page_meta_settings_nonce' );

		// Open metabox
		echo '<table class="form-table wpex-metabox-table"><tbody>';

			// Use get_post_meta to retrieve an existing value from the database.
			$value = esc_attr( get_post_meta( $post->ID, $prefix .'post_layout', true ) );

			/*** Layout **/

			// Layout options
			$post_layouts = array(
				''               => esc_html__( 'Default', 'wpex-new-york' ),
				'right-sidebar'  => esc_html__( 'Right Sidebar', 'wpex-new-york' ),
				'left-sidebar'   => esc_html__( 'Left Sidebar', 'wpex-new-york' ),
				'full-width'     => esc_html__( 'No Sidebar', 'wpex-new-york' ),
			);

			$value = get_post_meta( $post->ID, $prefix .'post_layout', true );
			echo '<tr>';
				echo '<th><p><label for="'. $prefix .'post_layout">'. esc_html__( 'Layout', 'wpex-new-york' ) .'</label></p></th>';
				echo '<td><select type="text" id="'. $prefix .'post_layout" name="'. $prefix .'post_layout">';
					foreach( $post_layouts as $key => $val ) {
						echo '<option value="'. esc_attr( $key ) .'" '. selected( $value, $key ) .'>'. esc_attr( $val ) .'</option>';
					}
				echo '</select></td>';
			echo '</tr>';

			/*** Hide Title ***/
			$value = get_post_meta( $post->ID, $prefix .'hide_title', true );
			echo '<tr>';
				echo '<th><p><label for="'. $prefix .'hide_title">'. esc_html__( 'Hide Title', 'wpex-new-york' ) .'</label></p></th>';
				echo '<td><input type="checkbox" id="g'. $prefix .'hide_title" name="'. $prefix .'hide_title" '. checked( $value, 1, false ) .' />';
				echo '</td>';
			echo '</tr>';

		// Close metabox
		echo '</tbody></table>';

	}

	/**
	 * Save the meta when the post is saved.
	 *
	 * @param int $post_id The ID of the post being saved.
	 */
	public function save( $post_id ) {
	
		/*
		 * We need to verify this came from the our screen and with proper authorization,
		 * because save_post can be triggered at other times.
		 */

		// Get type
		if ( ! isset( $_POST['post_type'] ) ) {
			return;
		}

		// Check type
		if ( 'page' != $_POST['post_type'] ) {
			return;
		}

		// Check if our nonce is set.
		if ( ! isset( $_POST['wpe_page_meta_settings_nonce'] ) ) {
			return $post_id;
		}

		$nonce = $_POST['wpe_page_meta_settings_nonce'];

		// Verify that the nonce is valid.
		if ( ! wp_verify_nonce( $nonce, 'wpe_page_meta_settings_action' ) ) {
			return $post_id;
		}

		// If this is an autosave, our form has not been submitted,
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return $post_id;
		}

		// Check the user's permissions.
		if ( ! current_user_can( 'edit_page', $post_id ) ) {
			return $post_id;
		}

		/* OK, its safe for us to save the data now. */

			// Get meta prefix
			$prefix = 'wpex_';

			// Save Post Layout
			$val = isset( $_POST[$prefix .'post_layout'] ) ? esc_html( $_POST[$prefix .'post_layout'] ) : '';
			if ( $val ) {
				update_post_meta( $post_id, $prefix .'post_layout', $val );
			} else {
				delete_post_meta( $post_id, $prefix .'post_layout' );
			}

			// Save hide title setting
			$val = ! empty( $_POST[$prefix .'hide_title'] ) ? true : false;
			if ( $val ) {
				update_post_meta( $post_id, $prefix .'hide_title', 1 );
			} else {
				delete_post_meta( $post_id, $prefix .'hide_title' );
			}

	}

	/**
	 * Adds metabox CSS
	 */
	public function load_css( $hook ) {
		if ( $hook == 'post.php' || $hook == 'post-new.php' || $hook == 'page-new.php' || $hook == 'page.php' ) {
			wp_enqueue_style( 'wpex-metaboxes', wpex_asset_url( 'css/metaboxes.css' ) );
		}
	}

}
new New_York_Page_Meta_Settings();