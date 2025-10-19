<?php
/**
 * The template to display the logo or the site name and the slogan in the Header
 *
 * @package WordPress
 * @subpackage ROSALINDA
 * @since ROSALINDA 1.0
 */

$rosalinda_args = get_query_var( 'rosalinda_logo_args' );

// Site logo
$rosalinda_logo_type   = isset( $rosalinda_args['type'] ) ? $rosalinda_args['type'] : '';
$rosalinda_logo_image  = rosalinda_get_logo_image( $rosalinda_logo_type );
$rosalinda_logo_text   = rosalinda_is_on( rosalinda_get_theme_option( 'logo_text' ) ) ? get_bloginfo( 'name' ) : '';
$rosalinda_logo_slogan = get_bloginfo( 'description', 'display' );
if ( ! empty( $rosalinda_logo_image ) || ! empty( $rosalinda_logo_text ) ) {
	?><a class="sc_layouts_logo" href="<?php echo esc_url( home_url( '/' ) ); ?>">
		<?php
		if ( ! empty( $rosalinda_logo_image ) ) {
			if ( empty( $rosalinda_logo_type ) && function_exists( 'the_custom_logo' ) && is_numeric( $rosalinda_logo_image['logo'] ) && $rosalinda_logo_image['logo'] > 0 ) {
				the_custom_logo();
			} else {
				$rosalinda_attr = rosalinda_getimagesize( $rosalinda_logo_image );
				echo '<img src="' . esc_url( $rosalinda_logo_image ) . '" alt="' . esc_attr( $rosalinda_logo_text ) . '"' . ( ! empty( $rosalinda_attr[3] ) ? ' ' . wp_kses_data( $rosalinda_attr[3] ) : '' ) . '>';
			}
		} else {
			rosalinda_show_layout( rosalinda_prepare_macros( $rosalinda_logo_text ), '<span class="logo_text">', '</span>' );
			rosalinda_show_layout( rosalinda_prepare_macros( $rosalinda_logo_slogan ), '<span class="logo_slogan">', '</span>' );
		}
		?>
	</a>
	<?php
}
