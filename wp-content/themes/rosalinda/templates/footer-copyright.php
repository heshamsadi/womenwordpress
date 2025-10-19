<?php
/**
 * The template to display the copyright info in the footer
 *
 * @package WordPress
 * @subpackage ROSALINDA
 * @since ROSALINDA 1.0.10
 */

// Copyright area
?> 
<div class="footer_copyright_wrap
<?php
if ( ! rosalinda_is_inherit( rosalinda_get_theme_option( 'copyright_scheme' ) ) ) {
	echo ' scheme_' . esc_attr( rosalinda_get_theme_option( 'copyright_scheme' ) );
}
?>
				">
	<div class="footer_copyright_inner">
		<div class="content_wrap">
			<div class="copyright_text">
			<?php
				$rosalinda_copyright = rosalinda_get_theme_option( 'copyright' );
			if ( ! empty( $rosalinda_copyright ) ) {
				// Replace {{Y}} or {Y} with the current year
				$rosalinda_copyright = str_replace( array( '{{Y}}', '{Y}' ), date( 'Y' ), $rosalinda_copyright );
				// Replace {{...}} and ((...)) on the <i>...</i> and <b>...</b>
				$rosalinda_copyright = rosalinda_prepare_macros( $rosalinda_copyright );
				// Display copyright
				echo wp_kses( nl2br( $rosalinda_copyright ), 'rosalinda_kses_content' );
			}
			?>
			</div>
		</div>
	</div>
</div>
