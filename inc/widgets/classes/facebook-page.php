<?php
/**
 * Facebook Page Widget
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
if ( ! class_exists( 'WPEX_Facebook_Page_Widget' ) ) {

	class WPEX_Facebook_Page_Widget extends WP_Widget {
		
		/**
		 * Register widget with WordPress.
		 *
		 */
		public function __construct() {

			parent::__construct(
				'wpex_facebook_page_widget',
				WPEX_THEME_NAME . ' - '. esc_html__( 'Facebook Page', 'wpex-new-york' )
			);

			// Load scripts -> Must keep in this file since it checks
			// for the id_base via the is_active_widget function
			add_action( 'wp_enqueue_scripts', array( $this, 'scripts' ), 20 );

		}

		/**
		 * Front-end display of widget.
		 *
		 * @see WP_Widget::widget()
		 *
		 * @param array $args     Widget arguments.
		 * @param array $instance Saved values from database.
		 */
		public function widget( $args, $instance ) {

			// Extract args
			extract( $args );

			// Set vars for widget usage
			$title        = isset( $instance['title'] ) ? $instance['title'] : '';
			$title        = apply_filters( 'widget_title', $title );
			$facebook_url = isset( $instance['facebook_url'] ) ? esc_url( $instance['facebook_url'] ) : '';

			// Before widget WP hook
			echo wpex_sanitize( $before_widget, 'html' );

			// Display title if defined
			if ( $title ) {
				echo wpex_sanitize( $before_title . $title . $after_title, 'html' );
			} ?>

			<?php
			// Show nothing in customizer to keep it fast
			if ( function_exists( 'is_customize_preview' ) && is_customize_preview() ) :

				esc_html_e( 'Facebook widget does not display in the Customizer because it can slow things down.', 'wpex-new-york' );

			elseif ( $facebook_url ) : ?>

				<div class="fb-page" data-href="<?php echo esc_url( $facebook_url ); ?>" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true" data-show-posts="false"><div class="fb-xfbml-parse-ignore"><a href="<?php echo esc_url( $facebook_url ); ?>"><?php echo esc_url( $facebook_url ); ?></a></div></div>
				<div id="fb-root"></div>

			<?php endif; ?>

			<?php
			// After widget WP hook
			echo wpex_sanitize( $after_widget, 'html' ); ?>
			
		<?php
		}

		/**
		 * Sanitize widget form values as they are saved.
		 *
		 * @see WP_Widget::update()
		 *
		 * @param array $new_instance Values just sent to be saved.
		 * @param array $old_instance Previously saved values from database.
		 *
		 * @return array Updated safe values to be saved.
		 */
		function update( $new_instance, $old_instance ) {
			$instance                 = $old_instance;
			$instance['title']        = strip_tags( $new_instance['title'] );
			$instance['facebook_url'] = ( ! empty( $new_instance['facebook_url'] ) ) ? esc_url( $new_instance['facebook_url'] ) : '';
			return $instance;
		}

		/**
		 * Back-end widget form.
		 *
		 * @see WP_Widget::form()
		 *
		 * @param array $instance Previously saved values from database.
		 */
		public function form( $instance ) {

			extract( wp_parse_args( ( array ) $instance, array(
				'title'        => '',
				'facebook_url' => 'https://www.facebook.com/WPExplorerThemes',
			) ) ); ?>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title', 'wpex-new-york' ); ?></label>
				<input class="widefat" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
			</p>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'facebook_url' ) ); ?>"><?php esc_html_e( 'Facebook Page URL', 'wpex-new-york' ); ?></label>
				<input class="widefat" name="<?php echo esc_attr( $this->get_field_name( 'facebook_url' ) ); ?>" type="text" value="<?php echo esc_attr( $facebook_url ); ?>" />
			</p>
			
		<?php
		}

		/**
		 * Scripts
		 *
		 */
		public function scripts() {
			if ( is_active_widget( false, false, $this->id_base, true ) ) {
				$language = apply_filters( 'wpex_fbpage_widget_language', 'en_US' );
				$script = '(function(d, s, id) {var js, fjs = d.getElementsByTagName(s)[0];if (d.getElementById(id)) return;js = d.createElement(s); js.id = id;js.async=true; js.src = "//connect.facebook.net/'. esc_html( $language ) .'/sdk.js#xfbml=1&version=v2.5&appId=944726105603358";fjs.parentNode.insertBefore(js, fjs);} ( document, "script", "facebook-jssdk" ) );';
				wp_add_inline_script( wpex_get_main_js_handle(), $script, 'after' );
			}
		}

	}

}
register_widget( 'WPEX_Facebook_Page_Widget' );