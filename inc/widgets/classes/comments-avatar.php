<?php
/**
 * Recent Recent Comments With Avatars Widget
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
if ( ! class_exists( 'WPEX_Recent_Comments_Avatar_Widget' ) ) {

	class WPEX_Recent_Comments_Avatar_Widget extends WP_Widget {
		
		/**
		 * Register widget with WordPress.
		 *
		 * @since 1.0.0
		 */
		public function __construct() {
			parent::__construct(
				'wpex_recent_comments_avatar',
				WPEX_THEME_NAME . ' - '. esc_html__( 'Comments With Avatars', 'wpex-new-york' )
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
		function widget( $args, $instance ) {

			// Extract args
			extract( $args );

			// Define variables for widget usage
			$title  = isset( $instance['title'] ) ? $instance['title'] : '';
			$title  = apply_filters( 'widget_title', $title );
			$number = isset( $instance['number'] ) ? $instance['number'] : '3';

			// Before widget WP Hook
			echo wpex_sanitize( $before_widget, 'html' );

			// Display the title
			if ( $title ) {
				echo wpex_sanitize( $before_title . $title . $after_title, 'html' );
			}

			echo '<ul class="wpex-recent-comments-widget wpex-clr">';

				// Query Comments
				$comments = get_comments( array(
					'number'      => $number,
					'status'      => 'approve',
					'post_status' => 'publish',
					'type'        => 'comment',
				) );

				// Display comments
				if ( $comments ) :

					// Loop through comments
					foreach ( $comments as $comment ) :

						// Get comment ID
						$comment_id   = $comment->comment_ID;
						$comment_link = get_permalink( $comment->comment_post_ID ) . '#comment-' . $comment_id;

						// Title alt
						$title_alt = esc_html__( 'Read Comment', 'wpex-new-york' );

						echo '<li class="wpex-clr">';

							
							echo '<a href="'. esc_url( $comment_link ) .'" title="'. esc_attr( $title_alt ) .'" class="wpex-avatar">';
								
								echo get_avatar( $comment->comment_author_email, '50' );
							
							echo '</a>';

							echo '<div class="wpex-details">';

								echo '<strong>'. esc_html( get_comment_author( $comment_id ) ) .':</strong>';

								echo ' <span>'. wp_trim_words( $comment->comment_content, '10', '&hellip;' ) .'</span>';

								echo '<a href="'. esc_url( $comment_link ) .'" title="'. esc_attr__( 'more', 'wpex-new-york' ) .'" class="wpex-more">['. esc_html__( 'more', 'wpex-new-york' ) .']</a>';

							echo '</div>';
						
						echo '</li>';

					endforeach;

				// Display no comments notice
				else :

					echo '<li>'. esc_html__( 'No comments yet.', 'wpex-new-york' ) .'</li>';

				endif;

			echo '</ul>';

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
		function update( $new_instance, $old_instance ) {
			$instance           = $old_instance;
			$instance['title']  = strip_tags( $new_instance['title'] );
			$instance['number'] = strip_tags( $new_instance['number'] );
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
		function form( $instance ) {

			extract( wp_parse_args( ( array ) $instance, array(
				'title'  => '',
				'number' => '3',
			) ) ); ?>
			
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'wpex-new-york' ); ?></label>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title', 'wpex-new-york' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
			</p>
			
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>"><?php esc_html_e( 'Number to Show:', 'wpex-new-york' ); ?></label> 
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'number' ) ); ?>" type="text" value="<?php echo esc_attr( $number ); ?>" />
			</p>

			<?php
		}
	}

}
register_widget( 'WPEX_Recent_Comments_Avatar_Widget' );