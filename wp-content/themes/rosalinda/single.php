<?php
/**
 * The template to display single post
 *
 * @package WordPress
 * @subpackage ROSALINDA
 * @since ROSALINDA 1.0
 */

get_header();

while ( have_posts() ) {
	the_post();

	get_template_part( apply_filters( 'rosalinda_filter_get_template_part', 'content', get_post_format() ), get_post_format() );

	// Previous/next post navigation.
	$rosalinda_show_posts_navigation = ! rosalinda_is_off( rosalinda_get_theme_option( 'show_posts_navigation' ) );
	$rosalinda_fixed_posts_navigation = ! rosalinda_is_off( rosalinda_get_theme_option( 'fixed_posts_navigation' ) ) ? 'nav-links-fixed fixed' : '';
	if ( $rosalinda_show_posts_navigation ) {
		?>
		<div class="nav-links-single<?php echo ' ' . esc_attr( $rosalinda_fixed_posts_navigation ); ?>">
			<?php
			the_post_navigation(
				array(
					'next_text' => '<span class="nav-arrow"></span>'
						. '<span class="screen-reader-text">' . esc_html__( 'Next post:', 'rosalinda' ) . '</span> '
						. '<h6 class="post-title">%title</h6>'
						. '<span class="post_date">%date</span>',
					'prev_text' => '<span class="nav-arrow"></span>'
						. '<span class="screen-reader-text">' . esc_html__( 'Previous post:', 'rosalinda' ) . '</span> '
						. '<h6 class="post-title">%title</h6>'
						. '<span class="post_date">%date</span>',
				)
			);
			?>
		</div>
		<?php
	}

	// Related posts
	if ( rosalinda_get_theme_option( 'related_position' ) == 'below_content' ) {
		do_action( 'rosalinda_action_related_posts' );
	}

	// If comments are open or we have at least one comment, load up the comment template.
	if ( comments_open() || get_comments_number() ) {
		comments_template();
	}
}

get_footer();
