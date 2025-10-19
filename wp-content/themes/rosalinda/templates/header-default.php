<?php
/**
 * The template to display default site header
 *
 * @package WordPress
 * @subpackage ROSALINDA
 * @since ROSALINDA 1.0
 */

$rosalinda_header_css   = '';
$rosalinda_header_image = get_header_image();
$rosalinda_header_video = rosalinda_get_header_video();
if ( ! empty( $rosalinda_header_image ) && rosalinda_trx_addons_featured_image_override( is_singular() || rosalinda_storage_isset( 'blog_archive' ) || is_category() ) ) {
	$rosalinda_header_image = rosalinda_get_current_mode_image( $rosalinda_header_image );
}

?><header class="top_panel top_panel_default
	<?php
	echo ! empty( $rosalinda_header_image ) || ! empty( $rosalinda_header_video ) ? ' with_bg_image' : ' without_bg_image';
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

	// Main menu
	if ( rosalinda_get_theme_option( 'menu_style' ) == 'top' ) {
		get_template_part( apply_filters( 'rosalinda_filter_get_template_part', 'templates/header-navi' ) );
	}

	// Mobile header
	if ( rosalinda_is_on( rosalinda_get_theme_option( 'header_mobile_enabled' ) ) ) {
		get_template_part( apply_filters( 'rosalinda_filter_get_template_part', 'templates/header-mobile' ) );
	}

	// Page title and breadcrumbs area
	get_template_part( apply_filters( 'rosalinda_filter_get_template_part', 'templates/header-title' ) );

	// Header widgets area
	get_template_part( apply_filters( 'rosalinda_filter_get_template_part', 'templates/header-widgets' ) );

	// Display featured image in the header on the single posts
	// Comment next line to prevent show featured image in the header area
	// and display it in the post's content
	get_template_part( apply_filters( 'rosalinda_filter_get_template_part', 'templates/header-single' ) );

	?>
</header>
