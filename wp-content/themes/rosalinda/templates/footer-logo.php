<?php
/**
 * The template to display the site logo in the footer
 *
 * @package WordPress
 * @subpackage ROSALINDA
 * @since ROSALINDA 1.0.10
 */

// Logo
if ( rosalinda_is_on( rosalinda_get_theme_option( 'logo_in_footer' ) ) ) {
	$rosalinda_logo_image = rosalinda_get_logo_image( 'footer' );
	$rosalinda_logo_text  = get_bloginfo( 'name' );
	if ( ! empty( $rosalinda_logo_image ) || ! empty( $rosalinda_logo_text ) ) {
		?>
		<div class="footer_logo_wrap">
			<div class="footer_logo_inner">
				<?php
				if ( ! empty( $rosalinda_logo_image ) ) {
					$rosalinda_attr = rosalinda_getimagesize( $rosalinda_logo_image );
					echo '<a href="' . esc_url( home_url( '/' ) ) . '">'
							. '<img src="' . esc_url( $rosalinda_logo_image ) . '"'
								. ' class="logo_footer_image"'
								. ' alt="' . esc_attr__( 'Site logo', 'rosalinda' ) . '"'
								. ( ! empty( $rosalinda_attr[3] ) ? ' ' . wp_kses_data( $rosalinda_attr[3] ) : '' )
							. '>'
						. '</a>';
				} elseif ( ! empty( $rosalinda_logo_text ) ) {
					echo '<h1 class="logo_footer_text">'
							. '<a href="' . esc_url( home_url( '/' ) ) . '">'
								. esc_html( $rosalinda_logo_text )
							. '</a>'
						. '</h1>';
				}
				?>
			</div>
		</div>
		<?php
	}
}
