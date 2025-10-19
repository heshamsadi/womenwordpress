<?php
/**
 * The template to display the socials in the footer
 *
 * @package WordPress
 * @subpackage ROSALINDA
 * @since ROSALINDA 1.0.10
 */


// Socials
if ( rosalinda_is_on( rosalinda_get_theme_option( 'socials_in_footer' ) ) ) {
	$rosalinda_output = rosalinda_get_socials_links();
	if ( '' != $rosalinda_output ) {
		?>
		<div class="footer_socials_wrap socials_wrap">
			<div class="footer_socials_inner">
				<?php rosalinda_show_layout( $rosalinda_output ); ?>
			</div>
		</div>
		<?php
	}
}
