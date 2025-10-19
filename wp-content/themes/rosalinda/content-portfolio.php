<?php
/**
 * The Portfolio template to display the content
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
		. ( is_sticky() && ! is_paged() ? ' sticky' : '' )
	);
	echo ( ! rosalinda_is_off( $rosalinda_animation ) && empty( $rosalinda_template_args['slider'] ) ? ' data-animation="' . esc_attr( rosalinda_get_animation_classes( $rosalinda_animation ) ) . '"' : '' );
	?>
>
<?php

// Sticky label
if ( is_sticky() && ! is_paged() ) {
	?>
		<span class="post_label label_sticky"></span>
		<?php
}

	$rosalinda_image_hover = ! empty( $rosalinda_template_args['hover'] ) && ! rosalinda_is_inherit( $rosalinda_template_args['hover'] )
								? $rosalinda_template_args['hover']
								: rosalinda_get_theme_option( 'image_hover' );
	// Featured image
	rosalinda_show_post_featured(
		array(
			'singular'      => false,
			'hover'         => $rosalinda_image_hover,
			'no_links'      => ! empty( $rosalinda_template_args['no_links'] ),
			'thumb_size'    => rosalinda_get_thumb_size(
				strpos( rosalinda_get_theme_option( 'body_style' ), 'full' ) !== false || $rosalinda_columns < 3
								? 'masonry-big'
				: 'masonry'
			),
			'show_no_image' => true,
			'class'         => 'dots' == $rosalinda_image_hover ? 'hover_with_info' : '',
			'post_info'     => 'dots' == $rosalinda_image_hover ? '<div class="post_info">' . esc_html( get_the_title() ) . '</div>' : '',
		)
	);
	?>
</article></div><?php
// Need opening PHP-tag above, because <article> is a inline-block element (used as column)!