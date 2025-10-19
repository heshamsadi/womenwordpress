<?php
/**
 * The template for homepage posts with custom style
 *
 * @package WordPress
 * @subpackage ROSALINDA
 * @since ROSALINDA 1.0.50
 */

rosalinda_storage_set( 'blog_archive', true );

get_header();

if ( have_posts() ) {

	$rosalinda_blog_style = rosalinda_get_theme_option( 'blog_style' );
	$rosalinda_parts      = explode( '_', $rosalinda_blog_style );
	$rosalinda_columns    = ! empty( $rosalinda_parts[1] ) ? max( 1, min( 6, (int) $rosalinda_parts[1] ) ) : 1;
	$rosalinda_blog_id    = rosalinda_get_custom_blog_id( $rosalinda_blog_style );
	$rosalinda_blog_meta  = rosalinda_get_custom_layout_meta( $rosalinda_blog_id );
	if ( ! empty( $rosalinda_blog_meta['margin'] ) ) {
		rosalinda_add_inline_css( sprintf( '.page_content_wrap{padding-top:%s}', esc_attr( rosalinda_prepare_css_value( $rosalinda_blog_meta['margin'] ) ) ) );
	}
	$rosalinda_custom_style = ! empty( $rosalinda_blog_meta['scripts_required'] ) ? $rosalinda_blog_meta['scripts_required'] : 'none';

	rosalinda_blog_archive_start();

	$rosalinda_classes    = 'posts_container blog_custom_wrap' 
							. ( ! rosalinda_is_off( $rosalinda_custom_style )
								? sprintf( ' %s_wrap', $rosalinda_custom_style )
								: ( $rosalinda_columns > 1 
									? ' columns_wrap columns_padding_bottom' 
									: ''
									)
								);
	$rosalinda_stickies   = is_home() ? get_option( 'sticky_posts' ) : false;
	$rosalinda_sticky_out = rosalinda_get_theme_option( 'sticky_style' ) == 'columns'
							&& is_array( $rosalinda_stickies ) && count( $rosalinda_stickies ) > 0 && get_query_var( 'paged' ) < 1;
	if ( $rosalinda_sticky_out ) {
		?>
		<div class="sticky_wrap columns_wrap">
		<?php
	}
	if ( ! $rosalinda_sticky_out ) {
		if ( rosalinda_get_theme_option( 'first_post_large' ) && ! is_paged() && ! in_array( rosalinda_get_theme_option( 'body_style' ), array( 'fullwide', 'fullscreen' ) ) ) {
			the_post();
			get_template_part( apply_filters( 'rosalinda_filter_get_template_part', 'content', 'excerpt' ), 'excerpt' );
		}
		?>
		<div class="<?php echo esc_attr( $rosalinda_classes ); ?>">
		<?php
	}
	while ( have_posts() ) {
		the_post();
		if ( $rosalinda_sticky_out && ! is_sticky() ) {
			$rosalinda_sticky_out = false;
			?>
			</div><div class="<?php echo esc_attr( $rosalinda_classes ); ?>">
			<?php
		}
		$rosalinda_part = $rosalinda_sticky_out && is_sticky() ? 'sticky' : 'custom';
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
