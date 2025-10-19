<?php
/**
 * The template for homepage posts with "Chess" style
 *
 * @package WordPress
 * @subpackage ROSALINDA
 * @since ROSALINDA 1.0
 */

rosalinda_storage_set( 'blog_archive', true );

get_header();

if ( have_posts() ) {

	rosalinda_blog_archive_start();

	$rosalinda_stickies   = is_home() ? get_option( 'sticky_posts' ) : false;
	$rosalinda_sticky_out = rosalinda_get_theme_option( 'sticky_style' ) == 'columns'
							&& is_array( $rosalinda_stickies ) && count( $rosalinda_stickies ) > 0 && get_query_var( 'paged' ) < 1;
	if ( $rosalinda_sticky_out ) {
		?>
		<div class="sticky_wrap columns_wrap">
		<?php
	}
	if ( ! $rosalinda_sticky_out ) {
		?>
		<div class="chess_wrap posts_container">
		<?php
	}
	while ( have_posts() ) {
		the_post();
		if ( $rosalinda_sticky_out && ! is_sticky() ) {
			$rosalinda_sticky_out = false;
			?>
			</div><div class="chess_wrap posts_container">
			<?php
		}
		$rosalinda_part = $rosalinda_sticky_out && is_sticky() ? 'sticky' : 'chess';
		get_template_part( apply_filters( 'rosalinda_filter_get_template_part', 'content', $rosalinda_part ), $rosalinda_part );
	}

	?>
	</div>
	<?php

	rosalinda_show_pagination();

	rosalinda_blog_archive_end();

} else {

	if ( is_search() ) {
		get_template_part( apply_filters( 'rosalinda_filter_get_template_part', 'content', 'none-search' ), 'none-search' );
	} else {
		get_template_part( apply_filters( 'rosalinda_filter_get_template_part', 'content', 'none-archive' ), 'none-archive' );
	}
}

get_footer();
