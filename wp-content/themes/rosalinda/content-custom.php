<?php
/**
 * The custom template to display the content
 *
 * Used for index/archive/search.
 *
 * @package WordPress
 * @subpackage ROSALINDA
 * @since ROSALINDA 1.0.50
 */

$rosalinda_template_args = get_query_var( 'rosalinda_template_args' );
if ( is_array( $rosalinda_template_args ) ) {
	$rosalinda_columns    = empty( $rosalinda_template_args['columns'] ) ? 2 : max( 1, $rosalinda_template_args['columns'] );
	$rosalinda_blog_style = array( $rosalinda_template_args['type'], $rosalinda_columns );
} else {
	$rosalinda_blog_style = explode( '_', rosalinda_get_theme_option( 'blog_style' ) );
	$rosalinda_columns    = empty( $rosalinda_blog_style[1] ) ? 2 : max( 1, $rosalinda_blog_style[1] );
}
$rosalinda_blog_id       = rosalinda_get_custom_blog_id( join( '_', $rosalinda_blog_style ) );
$rosalinda_blog_style[0] = str_replace( 'blog-custom-', '', $rosalinda_blog_style[0] );
$rosalinda_expanded      = ! rosalinda_sidebar_present() && rosalinda_is_on( rosalinda_get_theme_option( 'expand_content' ) );
$rosalinda_animation     = rosalinda_get_theme_option( 'blog_animation' );
$rosalinda_components    = rosalinda_array_get_keys_by_value( rosalinda_get_theme_option( 'meta_parts' ) );
$rosalinda_counters      = rosalinda_array_get_keys_by_value( rosalinda_get_theme_option( 'counters' ) );

$rosalinda_post_format   = get_post_format();
$rosalinda_post_format   = empty( $rosalinda_post_format ) ? 'standard' : str_replace( 'post-format-', '', $rosalinda_post_format );

$rosalinda_blog_meta     = rosalinda_get_custom_layout_meta( $rosalinda_blog_id );
$rosalinda_custom_style  = ! empty( $rosalinda_blog_meta['scripts_required'] ) ? $rosalinda_blog_meta['scripts_required'] : 'none';

if ( ! empty( $rosalinda_template_args['slider'] ) || $rosalinda_columns > 1 || ! rosalinda_is_off( $rosalinda_custom_style ) ) {
	?><div class="
		<?php
		if ( ! empty( $rosalinda_template_args['slider'] ) ) {
			echo 'slider-slide swiper-slide';
		} else {
			echo ( rosalinda_is_off( $rosalinda_custom_style ) ? 'column' : sprintf( '%1$s_item %1$s_item', $rosalinda_custom_style ) ) . '-1_' . esc_attr( $rosalinda_columns );
		}
		?>
	">
	<?php
}
?>
<article id="post-<?php the_ID(); ?>" 
<?php
	post_class(
			'post_item post_format_' . esc_attr( $rosalinda_post_format )
					. ' post_layout_custom post_layout_custom_' . esc_attr( $rosalinda_columns )
					. ' post_layout_' . esc_attr( $rosalinda_blog_style[0] )
					. ' post_layout_' . esc_attr( $rosalinda_blog_style[0] ) . '_' . esc_attr( $rosalinda_columns )
					. ( ! rosalinda_is_off( $rosalinda_custom_style )
						? ' post_layout_' . esc_attr( $rosalinda_custom_style )
							. ' post_layout_' . esc_attr( $rosalinda_custom_style ) . '_' . esc_attr( $rosalinda_columns )
						: ''
						)
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
	// Custom header's layout
	do_action( 'rosalinda_action_show_layout', $rosalinda_blog_id );
	?>
</article><?php
if ( ! empty( $rosalinda_template_args['slider'] ) || $rosalinda_columns > 1 || ! rosalinda_is_off( $rosalinda_custom_style ) ) {
	?></div><?php
	// Need opening PHP-tag above just after </div>, because <div> is a inline-block element (used as column)!
}
