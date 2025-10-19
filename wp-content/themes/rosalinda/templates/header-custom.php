<?php
/**
 * The template to display custom header from the ThemeREX Addons Layouts
 *
 * @package WordPress
 * @subpackage ROSALINDA
 * @since ROSALINDA 1.0.06
 */

$rosalinda_header_css   = '';
$rosalinda_header_image = get_header_image();
$rosalinda_header_video = rosalinda_get_header_video();
if ( ! empty( $rosalinda_header_image ) && rosalinda_trx_addons_featured_image_override( is_singular() || rosalinda_storage_isset( 'blog_archive' ) || is_category() ) ) {
	$rosalinda_header_image = rosalinda_get_current_mode_image( $rosalinda_header_image );
}

$rosalinda_header_id = rosalinda_get_custom_header_id();
$rosalinda_header_meta = get_post_meta( $rosalinda_header_id, 'trx_addons_options', true );
if ( ! empty( $rosalinda_header_meta['margin'] ) ) {
	rosalinda_add_inline_css( sprintf( '.page_content_wrap{padding-top:%s}', esc_attr( rosalinda_prepare_css_value( $rosalinda_header_meta['margin'] ) ) ) );
}

?><header class="top_panel top_panel_custom top_panel_custom_<?php echo esc_attr( $rosalinda_header_id ); ?> top_panel_custom_<?php echo esc_attr( sanitize_title( get_the_title( $rosalinda_header_id ) ) ); ?>
				<?php
				echo ! empty( $rosalinda_header_image ) || ! empty( $rosalinda_header_video )
					? ' with_bg_image'
					: ' without_bg_image';
				if ( '' != $rosalinda_header_video ) {
					echo ' with_bg_video';
				}
				if ( '' != $rosalinda_header_image ) {
					echo ' ' . esc_attr( rosalinda_add_inline_css_class( 'background-image: url(' . esc_url( $rosalinda_header_image ) . ');' ) );
				}
				if ( is_single() && has_post_thumbnail() ) {
					echo ' with_featured_image';
				}
				if ( rosalinda_is_on( rosalinda_get_theme_option( 'header_fullheight' ) ) ) {
					echo ' header_fullheight rosalinda-full-height';
				}
				if ( ! rosalinda_is_inherit( rosalinda_get_theme_option( 'header_scheme' ) ) ) {
					echo ' scheme_' . esc_attr( rosalinda_get_theme_option( 'header_scheme' ) );
				}
				?>
">
	<?php

	// Background video
	if ( ! empty( $rosalinda_header_video ) ) {
		get_template_part( apply_filters( 'rosalinda_filter_get_template_part', 'templates/header-video' ) );
	}

	// Custom header's layout
	do_action( 'rosalinda_action_show_layout', $rosalinda_header_id );

	// Header widgets area
	get_template_part( apply_filters( 'rosalinda_filter_get_template_part', 'templates/header-widgets' ) );

	?>
</header>
