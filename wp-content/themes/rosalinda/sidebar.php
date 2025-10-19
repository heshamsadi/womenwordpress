<?php
/**
 * The Sidebar containing the main widget areas.
 *
 * @package WordPress
 * @subpackage ROSALINDA
 * @since ROSALINDA 1.0
 */

if ( rosalinda_sidebar_present() ) {
	ob_start();
	$rosalinda_sidebar_name = rosalinda_get_theme_option( 'sidebar_widgets' );
	rosalinda_storage_set( 'current_sidebar', 'sidebar' );
	if ( is_active_sidebar( $rosalinda_sidebar_name ) ) {
		dynamic_sidebar( $rosalinda_sidebar_name );
	}
	$rosalinda_out = trim( ob_get_contents() );
	ob_end_clean();
	if ( ! empty( $rosalinda_out ) ) {
		$rosalinda_sidebar_position = rosalinda_get_theme_option( 'sidebar_position' );
		?>
		<div class="sidebar widget_area
			<?php
			echo esc_attr( $rosalinda_sidebar_position );
			if ( ! rosalinda_is_inherit( rosalinda_get_theme_option( 'sidebar_scheme' ) ) ) {
				echo ' scheme_' . esc_attr( rosalinda_get_theme_option( 'sidebar_scheme' ) );
			}
			?>
		" role="complementary">
		<?php
			// Single posts banner before sidebar
			rosalinda_show_post_banner( 'sidebar' ); ?>
			<div class="sidebar_inner">
				<?php
				do_action( 'rosalinda_action_before_sidebar' );
				rosalinda_show_layout( preg_replace( "/<\/aside>[\r\n\s]*<aside/", '</aside><aside', $rosalinda_out ) );
				do_action( 'rosalinda_action_after_sidebar' );
				?>
			</div><!-- /.sidebar_inner -->
		</div><!-- /.sidebar -->
		<div class="clearfix"></div>
		<?php
	}
}
