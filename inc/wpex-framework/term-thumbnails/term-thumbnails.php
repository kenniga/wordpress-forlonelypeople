<?php
/**
 * Adds term thumbnail options
 *
 * @author    Alexander Clarke
 * @copyright Copyright (c) 2015, WPExplorer.com
 * @link      http://www.stplorer.com
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Start Class
if ( ! class_exists( 'WPEX_Term_Thumbnails' ) ) {
	class WPEX_Term_Thumbnails {

		/**
		 * Main constructor
		 *
		 * @since 1.0.0
		 */
		public function __construct() {
			if ( function_exists( 'get_term_meta' ) ) {
				add_action( 'admin_init', array( $this, 'meta_form_fields' ), 40 );
				add_action( 'admin_enqueue_scripts', array( $this, 'js' ) );
				add_action( 'wpex_get_image_sizes', array( 'WPEX_Term_Thumbnails', 'add_image_size' ) );
			}
		}

		/**
		 * Initialize things in the backend
		 *
		 * @since 1.0.0
		 */
		public static function taxonomies() {
			return apply_filters( 'wpex_term_thumbnails_taxonomies', array( 'category', 'post_tag' ) );
		}

		/**
		 * Initialize things in the backend
		 *
		 * @since 1.0.0
		 */
		public function meta_form_fields() {

			// Get taxonomies
			$taxonomies = self::taxonomies();

			// Loop through taxonomies
			foreach ( $taxonomies as $taxonomy ) {

				// Add forms
				add_action( $taxonomy . '_add_form_fields', array( $this, 'add_form_fields' ) );
				add_action( $taxonomy . '_edit_form_fields', array( $this, 'edit_form_fields' ) );
				
				// Add columns
				add_filter( 'manage_edit-'. $taxonomy .'_columns', array( $this, 'admin_columns' ) );
				add_filter( 'manage_'. $taxonomy .'_custom_column', array( $this, 'admin_column' ), 10, 3 );

				// Save forms
				add_action( 'created_'. $taxonomy, array( $this, 'save_forms' ), 10, 3 );
				add_action( 'edit_'. $taxonomy, array( $this, 'save_forms' ), 10, 3 );

			}

		}

		/**
		 * Loads custom js for the image selector
		 *
		 * @since 1.0.0
		 */
		public function js( $hook ) {

			//print_r( 'hook'. $hook );

			if ( 'edit-tags.php' != $hook
				&& 'term.php' != $hook
			) {
				return;
			}

			// Localize strings
			$strings = array(
				'title'       => esc_html__( 'Choose an image', 'wpex-new-york' ),
				'button'      => esc_html__( 'Use image', 'wpex-new-york' ),
				'placeholder' => esc_url( WPEX_FRAMEWORK_DIR_URI .'/term-thumbnails/placeholder.png' ),
			);

			// Add fields
			wp_enqueue_script(
				'wpex-term-thumbnails',
				WPEX_FRAMEWORK_DIR_URI .'/term-thumbnails/term-thumbnails.js',
				array( 'jquery' ),
				false,
				true
			);
			wp_localize_script( 'wpex-term-thumbnails', 'wpexTermThumbnails', $strings );

		}

		/**
		 * Add Thumbnail field to add form fields
		 *
		 * @since 1.0.0
		 */
		public function add_form_fields() {

			// Enqueue media for media selector
			wp_enqueue_media();

			// Get current taxonomy
			$taxonomy = get_taxonomy( $_GET['taxonomy'] );
			$taxonomy = $taxonomy->labels->singular_name; ?>

			<div class="form-field">

				<label for="display_type"><?php esc_html_e( 'Page Header Thumbnail', 'wpex-new-york' ); ?></label>

				<select id="wpex_term_page_header_image" name="wpex_term_page_header_image" class="postform">
					<option value=""><?php esc_html_e( 'Default', 'wpex-new-york' ); ?></option>
					<option value="false"><?php esc_html_e( 'No', 'wpex-new-york' ); ?></option>
					<option value="true"><?php esc_html_e( 'Yes', 'wpex-new-york' ); ?></option>
				</select>

			</div>

			<div class="form-field">

				<label for="term-thumbnail"><?php esc_html_e( 'Thumbnail', 'wpex-new-york' ); ?></label>

				<div>

					<div id="wpex-term-thumbnail" style="float:left;margin-right:10px;">
						<img class="wpex-term-thumbnail-img" src="<?php echo esc_url( WPEX_FRAMEWORK_DIR_URI .'/term-thumbnails/placeholder.png' ); ?>" width="60px" height="60px" />
					</div>

					<input type="hidden" id="wpex_term_thumbnail" name="wpex_term_thumbnail" />

					<button type="submit" class="wpex-remove-term-thumbnail button"><?php esc_html_e( 'Remove image', 'wpex-new-york' ); ?></button>
					<button type="submit" class="wpex-add-term-thumbnail button"><?php esc_html_e( 'Upload/Add image', 'wpex-new-york' ); ?></button>

				</div>

				<div class="clear"></div>

			</div>

		<?php
		}

		/**
		 * Add Thumbnail field to edit form fields
		 *
		 * @since 1.0.0
		 */
		public function edit_form_fields( $term ) {

			// Enqueue media for media selector
			wp_enqueue_media();

			// Get current taxonomy
			$term_id  = $term->term_id;
			$taxonomy = get_taxonomy( $_GET['taxonomy'] );
			$taxonomy = $taxonomy->labels->singular_name;

			// Get thumbnail
			$thumbnail_id = get_term_meta( $term_id, 'wpex_thumbnail', true );
			if ( $thumbnail_id ) {
				$thumbnail_src = wp_get_attachment_image_src( $thumbnail_id, 'thumbnail', false );
				$thumbnail_url = ! empty( $thumbnail_src[0] ) ? $thumbnail_src[0] : '';
			} ?>

			<tr class="form-field">

				<th scope="row" valign="top">
					<label for="term-thumbnail"><?php esc_html_e( 'Thumbnail', 'wpex-new-york' ); ?></label>
				</th>

				<td>

					<div id="wpex-term-thumbnail" style="float:left;margin-right:10px;">
						<?php if ( ! empty( $thumbnail_url ) ) { ?>
							<img class="wpex-term-thumbnail-img" src="<?php echo esc_url( $thumbnail_url ); ?>" width="60px" height="60px" />
						<?php } else { ?>
							<img class="wpex-term-thumbnail-img" src="<?php echo esc_url( WPEX_FRAMEWORK_DIR_URI .'/term-thumbnails/placeholder.png' ); ?>" width="60px" height="60px" />
						<?php } ?>
					</div>

					<input type="hidden" id="wpex_term_thumbnail" name="wpex_term_thumbnail" value="<?php echo intval( $thumbnail_id ); ?>" />

					<button type="submit" class="wpex-remove-term-thumbnail button"<?php if ( ! $thumbnail_id ) echo 'style="display:none;"'; ?>>
						<?php esc_html_e( 'Remove image', 'wpex-new-york' ); ?>
					</button>

					<button type="submit" class="wpex-add-term-thumbnail button">
						<?php esc_html_e( 'Upload/Add image', 'wpex-new-york' ); ?>
					</button>

					<div class="clear"></div>

				</td>

			</tr>

			<?php

		}

		/**
		 * Adds the thumbnail to the database
		 *
		 * @since 1.0.0
		 */
		public function add_term_meta( $term_id, $key, $value ) {

			// Validate data
			if ( empty( $term_id ) || empty( $value ) || empty( $key ) ) {
				return;
			}

			// Add/Update thumbnail
			update_term_meta( $term_id, $key, $value );

		}

		/**
		 * Deletes the thumbnail from the database
		 *
		 * @since 1.0.0
		 */
		public function remove_term_meta( $term_id, $key ) {

			// Validate data
			if ( empty( $term_id ) || empty( $key ) ) {
				return;
			}

			// Delete thumbnail
			delete_term_meta( $term_id, $key );
			
		}

		/**
		 * Update thumbnail value
		 *
		 * @since 1.0.0
		 */
		public function update_thumbnail( $term_id, $thumbnail_id ) {

			// Add thumbnail
			if ( ! empty( $thumbnail_id ) ) {
				$this->add_term_meta( $term_id, 'wpex_thumbnail', $thumbnail_id );
			}

			// Delete thumbnail
			else {
				$this->remove_term_meta( $term_id, 'wpex_thumbnail' );
			}

		}

		/**
		 * Save Forms
		 *
		 * @since 1.0.0
		 */
		public function save_forms( $term_id, $tt_id = '', $taxonomy = '' ) {
			if ( isset( $_POST['wpex_term_thumbnail'] ) ) {
				$this->update_thumbnail( $term_id, $_POST['wpex_term_thumbnail'] );
			}
		}

		/**
		 * Thumbnail column added to category admin.
		 *
		 * @since 1.0.0
		 */
		public function admin_columns( $columns ) {
			$columns['wpex-term-thumbnail-col'] = esc_html__( 'Thumbnail', 'wpex-new-york' );
			return $columns;
		}

		/**
		 * Thumbnail column value added to category admin.
		 *
		 * @since 1.0.0
		 */
		public function admin_column( $columns, $column, $id ) {

			// Add thumbnail to columns
			if ( 'wpex-term-thumbnail-col' == $column ) {
				if ( $thumbnail_id = $this->get_term_thumbnail_id( $id, 'thumbnail_id', true ) ) {
					$image = wp_get_attachment_image_src( $thumbnail_id, 'thumbnail' );
					$image = $image[0];
				} else {
					$image = esc_url( WPEX_FRAMEWORK_DIR_URI .'/term-thumbnails/placeholder.png' );
				}
				$columns .= '<img src="' . esc_url( $image ) . '" alt="' . esc_html__( 'Thumbnail', 'wpex-new-york' ) . '" class="wp-post-image" height="48" width="48" />';
			}

			// Return columns
			return $columns;

		}

		/**
		 * Retrieve term thumbnail
		 *
		 * @since 1.0.0
		 */
		public function get_term_thumbnail_id( $term_id = null ) {

			// Get term id if not defined and is tax
			$term_id = $term_id ? $term_id : get_queried_object()->term_id;

			// Return if no term id
			if ( ! $term_id ) {
				return;
			}

			// Get thumbnail id
			return get_term_meta( $term_id, 'wpex_thumbnail', true );
			
		}

		/**
		 * Add new WP image size for the archive thumbnail
		 *
		 * @since 1.0.0
		 */
		public static function add_image_size( $sizes ) {
			$sizes['archive_thumbnail'] = esc_html__( 'Category/Tag Banner', 'wpex-new-york' );
			return $sizes;
		}

	}
}
new WPEX_Term_Thumbnails();

// Returns term thumbnail_id
function wpex_get_term_thumbnail_id( $term_id = '' ) {

	// Return if term_meta doesn't exist
	if ( ! function_exists( 'get_term_meta' ) ) {
		return;
	}

	// Loop through enabled taxonomies and get term_id
	$taxonomies = WPEX_Term_Thumbnails::taxonomies();
	if ( $taxonomies ) {
		foreach ( $taxonomies as $taxonomy ) {
			if ( ( 'category' == $taxonomy && is_category() )
				|| ( 'post_tag' == $taxonomy && is_tag() )
				|| is_tax( $taxonomy )
			) {
				$term_id = $term_id ? $term_id : get_queried_object()->term_id;
				if ( $term_id ) {
					return get_term_meta( $term_id, 'wpex_thumbnail', true );
				}
			}
		}
	}

}

// Returns term thumbnail src
function wpex_get_term_thumbnail_src( $term_id = '' ) {

	// Return thumbnail ID
	if ( $thumbnail_id = wpex_get_term_thumbnail_id( $term_id  ) ) {

		// Get thumbnail attachment
		$image = wp_get_attachment_image_src( $thumbnail_id, 'wpex_archive_thumbnail' );
		$image = $image[0];

		// Return image
		return $image;

	}
}