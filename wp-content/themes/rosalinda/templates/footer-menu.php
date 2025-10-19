<?php
/**
 * The template to display menu in the footer
 *
 * @package WordPress
 * @subpackage ROSALINDA
 * @since ROSALINDA 1.0.10
 */

// Footer menu
$rosalinda_menu_footer = rosalinda_get_nav_menu(
	array(
		'location' => 'menu_footer',
		'class'    => 'sc_layouts_menu sc_layouts_menu_default',
	)
);
if ( ! empty( $rosalinda_menu_footer ) ) {
	?>
	<div class="footer_menu_wrap">
		<div class="footer_menu_inner">
			<?php rosalinda_show_layout( $rosalinda_menu_footer ); ?>
		</div>
	</div>
	<?php
}
