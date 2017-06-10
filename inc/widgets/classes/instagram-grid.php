<?php
/**
 * Instagram Slider Widget
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

// Start widget class
if ( ! class_exists( 'WPEX_Instagram_Grid_Widget' ) ) {
	class WPEX_Instagram_Grid_Widget extends WP_Widget {
		
		/**
		 * Register widget with WordPress.
		 *
		 * @since 1.0.0
		 */
		public function __construct() {
			parent::__construct(
				'wpex_insagram_grid',
				WPEX_THEME_NAME . ' - '. esc_html__( 'Instagram', 'wpex-new-york' )
			);
		}

		/**
		 * Front-end display of widget.
		 *
		 * @see WP_Widget::widget()
		 * @since 1.0.0
		 *
		 *
		 * @param array $args     Widget arguments.
		 * @param array $instance Saved values from database.
		 */
		public function widget( $args, $instance ) {

			// Extract args
			extract( $args );

			// Args
			$title       = empty( $instance['title'] ) ? '' : apply_filters( 'widget_title', $instance['title'] );
			$username    = empty( $instance['username'] ) ? '' : $instance['username'];
			$number      = empty( $instance['number'] ) ? 8 : $instance['number'];
			$size        = empty( $instance['size'] ) ? 'thumbnail' : $instance['size'];
			$columns     = empty( $instance['columns'] ) ? '4' : $instance['columns'];
			$columns_gap = empty( $instance['columns_gap'] ) ? '10' : $instance['columns_gap'];
			$target      = isset( $instance['target'] ) ? $instance['target'] : false;

			// Prevent size issues
			if ( ! in_array( $size, array( 'thumbnail', 'small', 'large', 'original' ) ) ) {
				$size = 'thumbnail';
			}

			// Before widget hook
			echo wpex_sanitize( $before_widget, 'html' );

			// Display widget title
			if ( $title ) {

				echo wpex_sanitize( $before_title . $title . $after_title, 'html' );

			}

			// Display notice for username not added
			if ( ! $username ) :

				echo '<p>'. esc_html__( 'Please enter an instagram username for your widget.', 'wpex-new-york' ) .'</p>';

			else :

				// Get instagram images
				$media_array = wpex_fetch_instagram_feed( $username, $number );

				// Display error message
				if ( is_wp_error( $media_array ) ) :

					echo esc_html( $media_array->get_error_message() );

				// Display instagram slider
				elseif ( is_array( $media_array ) ) :

					echo '<ul class="wpex-instagram-grid-widget wpex-clr wpex-row wpex-gap-'. esc_attr( $columns_gap ) .'">';

						$count = 0;
						foreach ( $media_array as $item ) :

							$image = isset( $item['display_src'] ) ? $item['display_src'] : '';

							// Get correct image size
							if ( 'thumbnail' == $size ) {
								$image = ! empty( $item['thumbnail_src'] ) ? $item['thumbnail_src'] : $image;
								$image = ! empty( $item['thumbnail'] ) ? $item['thumbnail'] : $image;
							} elseif ( 'small' == $size ) {
								$image = ! empty( $item['small'] ) ? $item['small'] : $image;
							} elseif ( 'large' == $size ) {
								$image = ! empty( $item['large'] ) ? $item['large'] : $image;
							} elseif ( 'original' == $size ) {
								$image = ! empty( $item['original'] ) ? $item['original'] : $image;
							}
							
							if ( $image ) :

								$count++;

								if ( strpos( $item['link'], 'http' ) === false ) {
									$item['link'] = str_replace( '//instagram', 'https://instagram', $item['link'] );
								}

								echo '<li class="wpex-col-nr wpex-clr wpex-col-'. $columns .' wpex-count-'. $count .'">';

										echo '<a href="'. esc_url( $item['link'] ) .'" title="'. esc_attr( $item['description'] ) .'"'. wpex_get_target_blank( $target ) .'>';

											echo '<img src="'. esc_url( $image ) .'"  alt="'. esc_attr( $item['description'] ) .'" />';

										echo '</a>';

								echo '</li>';

								if ( $columns == $count ) {

									$count = 0;

								}

							endif;

						endforeach;

					echo '</ul>';

				endif;

			endif;

			// After widget hook
			echo wpex_sanitize( $after_widget, 'html' );
		}

		/**
		 * Sanitize widget form values as they are saved.
		 *
		 * @see WP_Widget::update()
		 * @since 1.0.0
		 *
		 * @param array $new_instance Values just sent to be saved.
		 * @param array $old_instance Previously saved values from database.
		 *
		 * @return array Updated safe values to be saved.
		 */
		public function update( $new_instance, $old_instance ) {

			// Get instance
			$instance                = $old_instance;
			$instance['title']       = strip_tags( $new_instance['title'] );
			$instance['size']        = strip_tags( $new_instance['size'] );
			$instance['username']    = trim( strip_tags( $new_instance['username'] ) );
			$instance['target']      = strip_tags( $new_instance['target'] );
			$instance['number']      = intval( $new_instance['number'] );
			$instance['columns']     = intval( $new_instance['columns'] );
			$instance['columns_gap'] = strip_tags( $new_instance['columns_gap'] );

			// Delete transient
			if ( ! empty( $instance['username'] ) ) {
				$sanitized_username = sanitize_title_with_dashes( $instance['username'] );
				$transient_name     = 'wpex-instagram-widget-new-'. $sanitized_username;
				delete_transient( $transient_name );
			}

			// Return instance
			return $instance;

		}

		/**
		 * Back-end widget form.
		 *
		 * @see WP_Widget::form()
		 * @since 1.0.0
		 *
		 * @param array $instance Previously saved values from database.
		 */
		public function form( $instance ) {

			extract( wp_parse_args( ( array ) $instance, array(
				'title'       => '',
				'username'    => 'wpexplorer',
				'number'      => '8',
				'columns'     => '4',
				'columns_gap' => '5',
				'target'      => '_self',
				'size'        => 'thumbnail',
			) ) );

			// Store arrays
			$get_gaps    = wpex_get_column_gap_options();
			$get_columns = wpex_get_column_options(); ?>
			
			<p><label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title', 'wpex-new-york' ); ?>: <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" /></label></p>

			<p><label for="<?php echo esc_attr( $this->get_field_id( 'username' ) ); ?>"><?php esc_html_e( 'Username', 'wpex-new-york' ); ?>: <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'username' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'username' ) ); ?>" type="text" value="<?php echo esc_attr( $username ); ?>" /></label></p>

			<p><label for="<?php echo esc_attr( $this->get_field_id( 'size' ) ); ?>"><?php esc_html_e( 'Size', 'wpex-new-york' ); ?>:</label>
				<select id="<?php echo esc_attr( $this->get_field_id( 'size' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'size' ) ); ?>" class="widefat">
					<option value="thumbnail" <?php selected( 'thumbnail', $size ) ?>><?php esc_html_e( 'Thumbnail', 'wpex-new-york' ); ?></option>
					<option value="small" <?php selected( 'small', $size ) ?>><?php esc_html_e( 'Small', 'wpex-new-york' ); ?></option>
					<option value="large" <?php selected( 'large', $size ) ?>><?php esc_html_e( 'Large', 'wpex-new-york' ); ?></option>
					<option value="original" <?php selected( 'original', $size ) ?>><?php esc_html_e( 'Original', 'wpex-new-york' ); ?></option>
				</select>
			</p>

			<p><label for="<?php echo esc_attr( $this->get_field_id( 'columns' ) ); ?>"><?php esc_html_e( 'Columns', 'wpex-new-york' ); ?>:</label>
				<select id="<?php echo esc_attr( $this->get_field_id( 'columns' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'columns' ) ); ?>" class="widefat">
					<?php foreach ( $get_columns as $key ) : ?>
						<option value="<?php echo esc_attr( $key ); ?>" <?php selected( $columns, $key ); ?>><?php echo esc_html( $key ); ?></option>
					<?php endforeach; ?>
				</select>
			</p>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'columns_gap' ) ); ?>"><?php esc_html_e( 'Column Gap', 'wpex-new-york' ); ?>:</label>
				<br />
				<select class='wpex-select' name="<?php echo esc_attr( $this->get_field_name( 'columns_gap' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'columns_gap' ) ); ?>">
					<?php foreach ( $get_gaps as $key => $val ) : ?>
						<option value="<?php echo esc_attr( $key ); ?>" <?php selected( $columns_gap, $key ); ?>><?php echo esc_html( $val ); ?></option>
					<?php endforeach; ?>
				</select>
			</p>

			<p><label for="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>"><?php esc_html_e( 'Number of photos', 'wpex-new-york' ); ?>: <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'number' ) ); ?>" type="text" value="<?php echo esc_attr( $number ); ?>" /></label><small><?php esc_html_e( 'Max 12 photos. This widget scraps instagram so you do not have to use the API. If you need to display more items you will want to use a 3rd party plugin.', 'wpex-new-york' ); ?></small></p>

			<p><label for="<?php echo esc_attr( $this->get_field_id( 'target' ) ); ?>"><?php esc_html_e( 'Open links in', 'wpex-new-york' ); ?>:</label>
				<select id="<?php echo esc_attr( $this->get_field_id( 'target' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'target' ) ); ?>" class="widefat">
					<option value="_self" <?php selected( '_self', $target ) ?>><?php esc_html_e( 'Current window', 'wpex-new-york' ); ?></option>
					<option value="_blank" <?php selected( '_blank', $target ) ?>><?php esc_html_e( 'New window', 'wpex-new-york' ); ?></option>
				</select>
			</p>

			<p>
				<strong><?php esc_html_e( 'Cache Notice', 'wpex-new-york' ); ?></strong>:<?php esc_html_e( 'The instagram feed is refreshed every 2 hours. However, you can click the save button below to clear the transient and refresh it instantly.', 'wpex-new-york' ); ?>
			</p>

			<?php
		}

	}
}
register_widget( 'WPEX_Instagram_Grid_Widget' );