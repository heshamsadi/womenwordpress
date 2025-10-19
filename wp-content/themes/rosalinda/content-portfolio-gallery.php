<?php
/**
 * The Gallery template to display posts
 *
 * Used for index/archive/search.
 *
 * @package WordPress
 * @subpackage ROSALINDA
 * @since ROSALINDA 1.0
 */

$rosalinda_template_args = get_query_var( 'rosalinda_template_args' );
if ( is_array( $rosalinda_template_args ) ) {
	$rosalinda_columns    = empty( $rosalinda_template_args['columns'] ) ? 2 : max( 1, $rosalinda_template_args['columns'] );
	$rosalinda_blog_style = array( $rosalinda_template_args['type'], $rosalinda_columns );
} else {
	$rosalinda_blog_style = explode( '_', rosalinda_get_theme_option( 'blog_style' ) );
	$rosalinda_columns    = empty( $rosalinda_blog_style[1] ) ? 2 : max( 1, $rosalinda_blog_style[1] );
}
$rosalinda_post_format = get_post_format();
$rosalinda_post_format = empty( $rosalinda_post_format ) ? 'standard' : str_replace( 'post-format-', '', $rosalinda_post_format );
$rosalinda_animation   = rosalinda_get_theme_option( 'blog_animation' );
$rosalinda_image       = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'full' );

?><div class="
<?php
if ( ! empty( $rosalinda_template_args['slider'] ) ) {
	echo ' slider-slide swiper-slide';
} else {
	echo 'masonry_item masonry_item-1_' . esc_attr( $rosalinda_columns );
}
?>
"><article id="post-<?php the_ID(); ?>" 
	<?php
	post_class(
		'post_item post_format_' . esc_attr( $rosalinda_post_format )
		. ' post_layout_portfolio'
		. ' post_layout_portfolio_' . esc_attr( $rosalinda_columns )
		. ' post_layout_gallery'
		. ' post_layout_gallery_' . esc_attr( $rosalinda_columns )
	);
	echo ( ! rosalinda_is_off( $rosalinda_animation ) && empty( $rosalinda_template_args['slider'] ) ? ' data-animation="' . esc_attr( rosalinda_get_animation_classes( $rosalinda_animation ) ) . '"' : '' );
	?>
	data-size="
		<?php
		if ( ! empty( $rosalinda_image[1] ) && ! empty( $rosalinda_image[2] ) ) {
			echo intval( $rosalinda_image[1] ) . 'x' . intval( $rosalinda_image[2] );}
		?>
	"
	data-src="
		<?php
		if ( ! empty( $rosalinda_image[0] ) ) {
			echo esc_url( $rosalinda_image[0] );}
		?>
	"
>
<?php

	// Sticky label
if ( is_sticky() && ! is_paged() ) {
	?>
		<span class="post_label label_sticky"></span>
		<?php
}

	// Featured image
	$rosalinda_image_hover = 'icon'; 
if ( in_array( $rosalinda_image_hover, array( 'icons', 'zoom' ) ) ) {
	$rosalinda_image_hover = 'dots';
}
$rosalinda_components = rosalinda_array_get_keys_by_value( rosalinda_get_theme_option( 'meta_parts' ) );
$rosalinda_counters   = rosalinda_array_get_keys_by_value( rosalinda_get_theme_option( 'counters' ) );
rosalinda_show_post_featured(
	array(
		'hover'         => $rosalinda_image_hover,
		'singular'      => false,
		'no_links'      => ! empty( $rosalinda_template_args['no_links'] ),
		'thumb_size'    => rosalinda_get_thumb_size( strpos( rosalinda_get_theme_option( 'body_style' ), 'full' ) !== false || $rosalinda_columns < 3 ? 'masonry-big' : 'masonry' ),
		'thumb_only'    => true,
		'show_no_image' => true,
		'post_info'     => '<div class="post_details">'
						. '<h2 class="post_title">'
							. ( empty( $rosalinda_template_args['no_links'] )
								? '<a href="' . esc_url( get_permalink() ) . '">' . esc_html( get_the_title() ) . '</a>'
								: esc_html( get_the_title() )
								)
						. '</h2>'
						. '<div class="post_description">'
							. ( ! empty( $rosalinda_components )
								? rosalinda_show_post_meta(
									apply_filters(
										'rosalinda_filter_post_meta_args', array(
											'components' => $rosalinda_components,
											'counters' => $rosalinda_counters,
											'seo'      => false,
											'echo'     => false,
										), $rosalinda_blog_style[0], $rosalinda_columns
									)
								)
								: ''
								)
							. ( empty( $rosalinda_template_args['hide_excerpt'] )
								? '<div class="post_description_content">' . get_the_excerpt() . '</div>'
								: ''
								)
							. ( empty( $rosalinda_template_args['no_links'] )
								? '<a href="' . esc_url( get_permalink() ) . '" class="theme_button post_readmore"><span class="post_readmore_label">' . esc_html__( 'Learn more', 'rosalinda' ) . '</span></a>'
								: ''
								)
						. '</div>'
					. '</div>',
	)
);
?>
</article></div><?php
// Need opening PHP-tag above, because <article> is a inline-block element (used as column)!
