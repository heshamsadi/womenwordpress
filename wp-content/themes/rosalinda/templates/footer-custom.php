<?php
/**
 * The template to display default site footer
 *
 * @package WordPress
 * @subpackage ROSALINDA
 * @since ROSALINDA 1.0.10
 */

$rosalinda_footer_id = rosalinda_get_custom_footer_id();
$rosalinda_footer_meta = get_post_meta( $rosalinda_footer_id, 'trx_addons_options', true );
if ( ! empty( $rosalinda_footer_meta['margin'] ) ) {
	rosalinda_add_inline_css( sprintf( '.page_content_wrap{padding-bottom:%s}', esc_attr( rosalinda_prepare_css_value( $rosalinda_footer_meta['margin'] ) ) ) );
}
?>
<footer class="footer_wrap footer_custom footer_custom_<?php echo esc_attr( $rosalinda_footer_id ); ?> footer_custom_<?php echo esc_attr( sanitize_title( get_the_title( $rosalinda_footer_id ) ) ); ?>
						<?php
						if ( ! rosalinda_is_inherit( rosalinda_get_theme_option( 'footer_scheme' ) ) ) {
							echo ' scheme_' . esc_attr( rosalinda_get_theme_option( 'footer_scheme' ) );
						}
						?>
						">
	<?php
	// Custom footer's layout
	do_action( 'rosalinda_action_show_layout', $rosalinda_footer_id );
	?>
</footer><!-- /.footer_wrap -->
