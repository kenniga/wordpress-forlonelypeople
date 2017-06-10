<?php
/**
 * About Widget
 *
 * Learn more: http://codex.wordpress.org/Widgets_API
 *
 * @author    Alexander Clarke
 * @copyright Copyright (c) 2015, WPExplorer.com
 * @link      http://www.wpexplorer.com
 * @since     1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Start class
if ( ! class_exists( 'WPEX_About_ME_Widget' ) ) {

	class WPEX_About_ME_Widget extends WP_Widget {

		/**
		 * Register widget with WordPress.
		 *
		 * @since 1.0.0
		 */
		public function __construct() {
			parent::__construct(
				'wpex_about_me',
				WPEX_THEME_NAME . ' - '. esc_attr__( 'About Me', 'wpex-new-york' )
			);
		}

		/**
		 * Front-end display of widget.
		 *
		 * @see WP_Widget::widget()
		 * @since 1.0.0
		 *
		 * @param array $args     Widget arguments.
		 * @param array $instance Saved values from database.
		 */
		public function widget( $args, $instance ) {

			$title       = isset( $instance['title'] ) ? apply_filters( 'widget_title', $instance['title'] ) : '';
			$image_url   = isset( $instance['image_url'] ) ? $instance['image_url'] : '';
			$content     = isset( $instance['content'] ) ? $instance['content'] : '';
			$image_round = ! empty( $instance['image_round'] );
			$auto_p      = ! empty( $instance['auto_p'] );
			
			// Before widget WP hook
			echo wpex_sanitize( $args['before_widget'], 'html' );

				// Show widget title
				if ( $title ) {

					echo wpex_sanitize( $args['before_title'], 'html' );
					echo wpex_sanitize( $title, 'html' );
					echo wpex_sanitize( $args['after_title'], 'html' );

				}

				echo '<div class="wpex-about-me-widget">';
				
					// Show video
					if ( $image_url )  {

						$class = 'wpex-avatar';
						if ( $image_round ) {
							$class .= ' wpex-round';
						}

						echo '<img src="' . esc_url( $image_url ) . '"  class="' . $class . '" alt="' . esc_attr( $title ) . ' " />';

					}
					
					// Display content
					if ( $content ) {

						if ( $auto_p ) {
							$content = wpautop( wp_kses_post( $content ) );
						} else {
							$content = wp_kses_post( $content );
						}

						echo '<div class="wpex-content wpex-clr">' . $content . '</div>';

					}

				echo '</div>';

			// After widget WP hook
			echo wpex_sanitize( $args['after_widget'], 'html' );
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
			$instance                = $old_instance;
			$instance['title']       = strip_tags( $new_instance['title'] );
			$instance['image_url']   = esc_url( $new_instance['image_url'] );
			$instance['auto_p']      = ! empty( $new_instance['auto_p'] );
			$instance['image_round'] = ! empty( $new_instance['image_round'] );
			$instance['content']     = wp_kses_post( $new_instance['content'] );
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
				'image_url'   => '',
				'image_round' => true,
				'content'     => '',
				'auto_p'      => '',
			) ) ); ?>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title', 'wpex-new-york' ); ?>:</label>
				<input class="widefat" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
			</p>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'image_url' ) ); ?>">
				<?php esc_html_e( 'Image url', 'wpex-new-york' ); ?>:</label>
				<input class="widefat" name="<?php echo esc_attr( $this->get_field_name( 'image_url' ) ); ?>" type="text" value="<?php echo esc_attr( esc_url( $image_url ) ); ?>" />
			</p>

			<p><input id="<?php echo esc_attr( $this->get_field_id( 'image_round' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'image_round' ) ); ?>" type="checkbox"<?php checked( $image_round ); ?> />&nbsp;<label for="<?php echo esc_attr( $this->get_field_id( 'image_round' ) ); ?>"><?php esc_html_e( 'Rounded image?', 'wpex-new-york' ); ?></label><br /><small><?php esc_html_e( 'If enabled make sure to add an image with square dimensions to prevent distortion of the image.', 'wpex-new-york' ); ?></small></p>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'content' ) ); ?>">
				<?php esc_html_e( 'Content', 'wpex-new-york' ); ?>:</label>
				<textarea rows="16" class="widefat" name="<?php echo esc_attr( $this->get_field_name( 'content' ) ); ?>" type="text"><?php echo wp_kses_post( $content ); ?></textarea>
			</p>

			<p><input id="<?php echo esc_attr( $this->get_field_id( 'auto_p' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'auto_p' ) ); ?>" type="checkbox"<?php checked( $auto_p ); ?> />&nbsp;<label for="<?php echo esc_attr( $this->get_field_id( 'auto_p' ) ); ?>"><?php esc_html_e( 'Automatically add paragraphs', 'wpex-new-york' ); ?></label></p>
			
		<?php }

	}
}
register_widget( 'WPEX_About_ME_Widget' );