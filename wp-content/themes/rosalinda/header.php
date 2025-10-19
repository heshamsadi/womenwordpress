<?php
/**
 * The Header: Logo and main menu
 *
 * @package WordPress
 * @subpackage ROSALINDA
 * @since ROSALINDA 1.0
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js
									<?php
										// Class scheme_xxx need in the <html> as context for the <body>!
										echo ' scheme_' . esc_attr( rosalinda_get_theme_option( 'color_scheme' ) );
									?>
										">
<head>
	<?php wp_head(); ?>
</head>

<body <?php	body_class(); ?>>
	<?php wp_body_open(); ?>
	<?php do_action( 'rosalinda_action_before_body' ); ?>

	<div class="body_wrap">

		<div class="page_wrap">
			<?php
			// Desktop header
			$rosalinda_header_type = rosalinda_get_theme_option( 'header_type' );
			if ( 'custom' == $rosalinda_header_type && ! rosalinda_is_layouts_available() ) {
				$rosalinda_header_type = 'default';
			}
			get_template_part( apply_filters( 'rosalinda_filter_get_template_part', "templates/header-{$rosalinda_header_type}" ) );

			// Side menu
			if ( in_array( rosalinda_get_theme_option( 'menu_style' ), array( 'left', 'right' ) ) ) {
				get_template_part( apply_filters( 'rosalinda_filter_get_template_part', 'templates/header-navi-side' ) );
			}

			// Mobile menu
			get_template_part( apply_filters( 'rosalinda_filter_get_template_part', 'templates/header-navi-mobile' ) );
			
			// Single posts banner after header
			rosalinda_show_post_banner( 'header' );
			?>

			<div class="page_content_wrap">
				<?php
				// Single posts banner on the background
				if ( is_singular( 'post' ) ) {

					rosalinda_show_post_banner( 'background' );

					$rosalinda_post_thumbnail_type  = rosalinda_get_theme_option( 'post_thumbnail_type' );
					$rosalinda_post_header_position = rosalinda_get_theme_option( 'post_header_position' );
					$rosalinda_post_header_align    = rosalinda_get_theme_option( 'post_header_align' );

					// Boxed post thumbnail
					if ( in_array( $rosalinda_post_thumbnail_type, array( 'boxed', 'fullwidth') ) ) {
						?>
						<div class="header_content_wrap header_align_<?php echo esc_attr( $rosalinda_post_header_align ); ?>">
							<?php
							if ( 'boxed' === $rosalinda_post_thumbnail_type ) {
								?>
								<div class="content_wrap">
								<?php
							}

							// Post title and meta
							if ( 'above' === $rosalinda_post_header_position ) {
								rosalinda_show_post_title_and_meta();
							}

							// Featured image
							rosalinda_show_post_featured_image();

							// Post title and meta
							if ( in_array( $rosalinda_post_header_position, array( 'under', 'on_thumb' ) ) ) {
								rosalinda_show_post_title_and_meta();
							}

							if ( 'boxed' === $rosalinda_post_thumbnail_type ) {
								?>
								</div>
								<?php
							}
							?>
						</div>
						<?php
					}
				}

				if ( 'fullscreen' != rosalinda_get_theme_option( 'body_style' ) ) {
					?>
					<div class="content_wrap">
						<?php
				}

				// Widgets area above page content
				rosalinda_create_widgets_area( 'widgets_above_page' );
				?>

				<div class="content">
					<?php
					// Widgets area inside page content
					rosalinda_create_widgets_area( 'widgets_above_content' );
