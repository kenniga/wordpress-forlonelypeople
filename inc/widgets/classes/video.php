<?php
/**
 * Video Widget
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
if ( ! class_exists( 'WPEX_Video_Widget' ) ) {

	class WPEX_Video_Widget extends WP_Widget {

		/**
		 * Register widget with WordPress.
		 *
		 * @since 1.0.0
		 */
		public function __construct() {
			parent::__construct(
				'wpex_video',
				WPEX_THEME_NAME . ' - '. esc_attr__( 'Video', 'wpex-new-york' )
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
			$video_url   = isset( $instance['video_url'] ) ? $instance['video_url'] : '';
			$description = isset( $instance['video_description'] ) ? $instance['video_description'] : '';
			
			// Before widget WP hook
			echo wpex_sanitize( $args['before_widget'], 'html' );

				// Show widget title
				if ( $title ) {

					echo wpex_sanitize( $args['before_title'], 'html' );
					echo wpex_sanitize( $title, 'html' );
					echo wpex_sanitize( $args['after_title'], 'html' );

				}

				echo '<div class="wpex-video-widget">';
				
					// Show video
					if ( $video_url )  {

						echo '<div class="wpex-responsive-embed">'. wp_oembed_get( $video_url ) .'</div>';

					}
					
					// Show video description if field isn't empty
					if ( $description ) {

						echo '<div class="wpex-desc wpex-clr">'. wp_kses_post( $description ) .'</div>';

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
			$instance                      = $old_instance;
			$instance['title']             = ! empty( $new_instance['title'] ) ? strip_tags( $new_instance['title'] ) : '';
			$instance['video_url']         = ! empty( $new_instance['video_url'] ) ? esc_url( $new_instance['video_url'] ) : '';
			$instance['video_description'] = ! empty( $new_instance['video_description'] ) ? wp_kses_post( $new_instance['video_description'] ) : '';
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

			extract( wp_parse_args( (array) $instance, array(
				'title'             => '',
				'video_url'         => '',
				'video_description' => '',
			) ) ); ?>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title', 'wpex-new-york' ); ?>:</label>
				<input class="widefat" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
			</p>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'video_url' ) ); ?>">
				<?php esc_html_e( 'Video URL', 'wpex-new-york' ); ?>:</label>
				<input class="widefat" name="<?php echo esc_attr( $this->get_field_name( 'video_url' ) ); ?>" type="text" value="<?php echo esc_attr( esc_url( $video_url ) ); ?>" />
				<span style="display:block;padding:5px 0" class="description"><?php esc_html_e( 'Enter in a video URL that is compatible with WordPress\'s built-in oEmbed feature.', 'wpex-new-york' ); ?> <a href="http://codex.wordpress.org/Embeds" target="_blank"><?php esc_html_e( 'Learn More', 'wpex-new-york' ); ?></a></span>
			</p>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'video_description' ) ); ?>">
				<?php esc_html_e( 'Description', 'wpex-new-york' ); ?>:</label>
				<textarea rows="16" class="widefat" name="<?php echo esc_attr( $this->get_field_name( 'video_description' ) ); ?>" type="text"><?php echo wp_kses_post( $video_description ); ?></textarea>
			</p>
			
		<?php }

	}
}
register_widget( 'WPEX_Video_Widget' );