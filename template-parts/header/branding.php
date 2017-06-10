<?php
/**
 * Header branding output
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
} ?>

<div class="wpex-site-branding wpex-clr">
	<?php

	if(is_single()) {
		?>
		<div class="wpex-site-logo wpex-clr">
			<h1 class="wpex-post-title">
				<?php echo the_title(); ?>

			</h1>
			<div class="wpex-post-meta wpex-clr">

				<ul class="wpex-post-meta-ul wpex-clr">

					<?php
					$blocks = array( 'date', 'categories', 'comments' );
					$blocks = apply_filters( 'wpex_post_meta_blocks', $blocks );
					// Loop through meta sections
					foreach ( $blocks as $block ) : ?>

						<?php
						// Date
						if ( 'date' == $block ) : ?>

							<li class="wpex-meta-date"><span class="fa fa-clock-o" aria-hidden="true"></span><time class="updated" datetime="<?php esc_attr( the_date( 'Y-m-d' ) ); ?>"<?php wpex_schema_markup( 'publish_date' ); ?>><?php echo get_the_date(); ?></time></li>

							<li><span class="wpex-seperator">/</span></li>

						<?php
						// Author
						elseif ( 'author' == $block ) : ?>

							<li class="wpex-meta-author"><span class="fa fa-user" aria-hidden="true"></span><span class="vcard author"<?php wpex_schema_markup( 'author_name' ); ?>><span class="fn"><?php the_author_posts_link(); ?></span></span></li>

							<li><span class="wpex-seperator">/</span></li>

						<?php
						// Categories
						elseif ( 'categories' == $block && 'post' == get_post_type() ) : ?>

							<li class="wpex-meta-category"><span class="fa fa-folder-open" aria-hidden="true"></span><?php the_category( ', ' ); ?></li>

							<li><span class="wpex-seperator">/</span></li>

						<?php
						// Comments
						elseif ( 'comments' == $block && comments_open() && ! post_password_required() ): ?>

							<li class="wpex-meta-comments"><span class="fa fa-comment" aria-hidden="true"></span><?php comments_popup_link( esc_html__( '0 Comments', 'wpex-new-york' ), esc_html__( '1 Comment',  'wpex-new-york' ), esc_html__( '% Comments', 'wpex-new-york' ), 'comments-link' ); ?></li>

						<?php endif; ?>

					<?php endforeach; ?>

				</ul>
		</div>
		<?php
	} else {
		wpex_get_template_part( 'site_header_logo' );
		wpex_get_template_part( 'site_header_desc' );
	}
	 ?>
</div><!-- .wpex-site-branding -->
