<?php
/**
 * Social Widget
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
if ( ! class_exists( 'WPEX_Social_Profiles_Widget' ) ) {

	class WPEX_Social_Profiles_Widget extends WP_Widget {
		private $social_services_array = array();

		/**
		 * Register widget with WordPress.
		 *
		 * @since 1.0.0
		 */
		public function __construct() {

			// Declare social services array
			$this->social_services_array = apply_filters( 'wpex_social_widget_profiles', array(
				'twitter' => array(
					'name' => 'Twitter',
					'url' => ''
				),
				'facebook' => array(
					'name' => 'Facebook',
					'url' => ''
				),
				'google-plus' => array(
					'name' => 'Google',
					'url' => ''
				),
				'instagram' => array(
					'name' => 'Instagram',
					'url' => ''
				),
				'bloglovin' => array(
					'name' => 'Bloglovin\'',
					'url' => '',
				),
				'linkedin' => array(
					'name' => 'LinkedIn',
					'url' => ''
				),
				'pinterest' => array(
					'name' => 'Pinterest',
					'url' => ''
				),
				'dribbble' => array(
					'name' => 'Dribbble',
					'url' => ''
				),
				'flickr' => array(
					'name' => 'Flickr',
					'url' => ''
				),
				'vimeo-square' => array(
					'name' => 'Vimeo',
					'url' => ''
				),
				'youtube' => array(
					'name' => 'Youtube',
					'url' => '',
				),
				'vk' => array(
					'name' => 'VK',
					'url' => ''
				),
				'github' => array(
					'name' => 'GitHub',
					'url' => ''
				),
				'tumblr' => array(
					'name' => 'Tumblr',
					'url' => ''
				),
				'skype' => array(
					'name' => 'Skype',
					'url' => ''
				),
				'trello' => array(
					'name' => 'Trello',
					'url' => ''
				),
				'foursquare' => array(
					'name' => 'Foursquare',
					'url' => ''
				),
				'renren' => array(
					'name' => 'RenRen',
					'url' => ''
				),
				'xing' => array(
					'name' => 'Xing',
					'url' => ''
				),
				'rss' => array(
					'name' => 'RSS',
					'url' => ''
				),
				'email' => array(
					'name' => esc_html__( 'Email', 'wpex-new-york' ),
					'url' => ''
				),
			) );

			// Start widget class
			parent::__construct(
				'wpex_social_profiles',
				WPEX_THEME_NAME . ' - '. esc_html__( 'Social Profiles', 'wpex-new-york' )
			);

			// Load scripts
			add_action( 'admin_enqueue_scripts', array( 'WPEX_Social_Profiles_Widget', 'scripts' ) );

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
			
			extract( $args );

			$title           = isset( $instance['title'] ) ? $instance['title'] : '';
			$title           = apply_filters( 'widget_title', $title );
			$description     = isset( $instance['description'] ) ? $instance['description'] : '';
			$target_blank    = isset( $instance['target'] ) ? $instance['target'] : false;
			$social_services = isset( $instance['social_services'] ) ? $instance['social_services'] : ''; ?>
			
			<?php echo wpex_sanitize( $before_widget, 'html' ); ?>
				
				<?php if ( $title ) echo wpex_sanitize( $before_title . $title . $after_title, 'html' ); ?>
				<div class="wpex-social-profiles-widget wpex-clr">
					<?php
					// Description
					if ( $description ) { ?>
						<div class="desc wpex-clr">
							<?php echo wpex_sanitize( $description, 'html' ); ?>
						</div>
					<?php } ?>
					<ul class="wpex-clr">
						<?php
						// Original Array
						$social_services_array = $this->social_services_array;

						// Loop through each item in the array
						foreach( $social_services as $key => $val ) {
							$link     = ! empty( $val['url'] ) ? esc_url( $val['url'] ) : null;
							$name     = $social_services_array[$key]['name'];
							$nofollow = isset( $social_services_array[$key]['nofollow'] ) ? ' rel="nofollow"' : '';
							if ( $link ) {
								$key  = 'vimeo-square' == $key ? 'vimeo' : $key;
								$icon = 'youtube' == $key ? 'youtube-play' : $key;
								$icon = 'bloglovin' == $key ? 'heart' : $icon;
								$icon = 'email' == $key ? 'envelope' : $icon;
								$icon = 'vimeo-square' == $key ? 'vimeo' : $icon;
								echo '<li>
										<a href="'. esc_url( $link ) .'" title="'. esc_attr( $name ) .'" class="wpex-'. $key .'"'. wpex_get_target_blank( $target_blank ) . $nofollow .'><span class="fa fa-'. $icon .'"></span></a>
									</li>';
							}
						} ?>
					</ul>
				</div>
			<?php
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
			$instance = $old_instance;
			$instance['title']           = strip_tags( $new_instance['title'] );
			$instance['description']     = wp_kses_post( $new_instance['description'] );
			$instance['target']          = strip_tags( $new_instance['target'] );
			$instance['social_services'] = ! empty( $new_instance['social_services'] ) ? $new_instance['social_services'] : array();
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
			$instance = wp_parse_args( ( array ) $instance, array(
				'title'           => '',
				'description'     => '',
				'font_size'       => '',
				'border_radius'   => '',
				'target'          => 'blank',
				'size'            => '',
				'social_services' => $this->social_services_array
			) ); ?>
			
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'wpex-new-york' ); ?></label> 
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $instance['title'] ); ?>" />
			</p>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'description' ) ); ?>"><?php esc_html_e( 'Description:','wpex-new-york' ); ?></label>
				<textarea class="widefat" rows="5" cols="20" id="<?php echo esc_attr( $this->get_field_id( 'description' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'description' ) ); ?>"><?php echo esc_html( $instance['description'] ); ?></textarea>
			</p>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'target' ) ); ?>"><?php esc_html_e( 'Link Target:', 'wpex-new-york' ); ?></label>
				<br />
				<select class='wpex-widget-select' name="<?php echo esc_attr( $this->get_field_name( 'target' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'target' ) ); ?>">
					<option value="blank" <?php if ( $instance['target'] == 'blank' ) { ?>selected="selected"<?php } ?>><?php esc_html_e( 'Blank', 'wpex-new-york' ); ?></option>
					<option value="self" <?php if ( $instance['target'] == 'self' ) { ?>selected="selected"<?php } ?>><?php esc_html_e( 'Self', 'wpex-new-york' ); ?></option>
				</select>
			</p>

			<?php
			$field_id_services   = $this->get_field_id( 'social_services' );
			$field_name_services = $this->get_field_name( 'social_services' ); ?>
			
			<h3 style="margin-top:20px;margin-bottom:0;"><?php esc_html_e( 'Social Links','wpex-new-york' ); ?></h3> 
			
			<?php if ( is_customize_preview() ) : ?>
				<small style="display:block;margin-bottom:10px;"><?php esc_html_e( 'To re-order your items you must be editing the widget at Appearance > Widgets. You will not be able to Drag and drop to re-order items in the Customizer.', 'wpex-new-york' ); ?></small>
			<?php else : ?>
				<small style="display:block;margin-bottom:10px;"><?php esc_html_e( 'To re-order your items click and drag them around then save your widget.', 'wpex-new-york' ); ?></small>
			<?php endif; ?>
			
			<ul id="<?php echo esc_attr( $field_id_services ); ?>" class="wpex-services-list">
				
				<input type="hidden" id="<?php echo esc_attr( $field_name_services ); ?>" value="<?php echo esc_attr( $field_name_services ); ?>">
				
				<input type="hidden" id="<?php echo wp_create_nonce( 'wpex_fontawesome_social_widget_nonce' ); ?>">
				
				<?php
				// Social array
				$social_services_array = $this->social_services_array;
				
				// Get current services display
				$display_services = isset ( $instance['social_services'] ) ? $instance['social_services']: '';
				
				// Loop through social services to display inputs
				foreach( $display_services as $key => $val ) {
					$url  = ! empty( $val['url'] ) ? esc_url( $val['url'] ) : null;
					$name = $social_services_array[$key]['name']; ?>
					<li id="<?php echo esc_attr( $field_id_services ); ?>_0<?php echo esc_attr( $key ); ?>">
						<p>
							<label for="<?php echo esc_attr( $field_id_services ); ?>-<?php echo esc_attr( $key ); ?>-name"><?php echo esc_attr( $name ); ?>:</label>
							<input type="hidden" id="<?php echo esc_attr( $field_id_services ); ?>-<?php echo esc_attr( $key ); ?>-url" name="<?php echo esc_attr( $field_name_services .'['.$key.'][name]' ); ?>" value="<?php echo esc_attr( $name ); ?>">
							<input type="url" class="widefat" id="<?php echo esc_attr( $field_id_services ); ?>-<?php echo esc_attr( $key ) ?>-url" name="<?php echo esc_attr( $field_name_services .'['.$key.'][url]' ); ?>" value="<?php echo esc_attr( $url ); ?>" />
						</p>
					</li>
				<?php } ?>
			</ul>
			
		<?php
		}

		/**
		 * Load scripts for this widget
		 *
		 */
		public static function scripts( $hook ) {

			$dir = WPEX_INC_DIR_URI .'/widgets/classes/assets/';

			if ( $hook != 'widgets.php' || is_customize_preview() ) {
				return;
			}

			wp_enqueue_style(
				'wpex-social-widget',
				$dir . 'wpex-social-widget.css'
			);

			wp_enqueue_script(
				'wpex-social-widget',
				$dir . 'wpex-social-widget.js',
				array( 'jquery' ),
				false,
				true
			);

		}

	}
}
register_widget( 'WPEX_Social_Profiles_Widget' );