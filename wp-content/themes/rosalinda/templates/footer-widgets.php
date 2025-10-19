<?php
/**
 * The template to display the widgets area in the footer
 *
 * @package WordPress
 * @subpackage ROSALINDA
 * @since ROSALINDA 1.0.10
 */

// Footer sidebar
$rosalinda_footer_name    = rosalinda_get_theme_option( 'footer_widgets' );
$rosalinda_footer_present = ! rosalinda_is_off( $rosalinda_footer_name ) && is_active_sidebar( $rosalinda_footer_name );
if ( $rosalinda_footer_present ) {
	rosalinda_storage_set( 'current_sidebar', 'footer' );
	$rosalinda_footer_wide = rosalinda_get_theme_option( 'footer_wide' );
	ob_start();
	if ( is_active_sidebar( $rosalinda_footer_name ) ) {
		dynamic_sidebar( $rosalinda_footer_name );
	}
	$rosalinda_out = trim( ob_get_contents() );
	ob_end_clean();
	if ( ! empty( $rosalinda_out ) ) {
		$rosalinda_out          = preg_replace( "/<\\/aside>[\r\n\s]*<aside/", '</aside><aside', $rosalinda_out );
		$rosalinda_need_columns = true;   
		if ( $rosalinda_need_columns ) {
			$rosalinda_columns = max( 0, (int) rosalinda_get_theme_option( 'footer_columns' ) );
			if ( 0 == $rosalinda_columns ) {
				$rosalinda_columns = min( 4, max( 1, substr_count( $rosalinda_out, '<aside ' ) ) );
			}
			if ( $rosalinda_columns > 1 ) {
				$rosalinda_out = preg_replace( '/<aside([^>]*)class="widget/', '<aside$1class="column-1_' . esc_attr( $rosalinda_columns ) . ' widget', $rosalinda_out );
			} else {
				$rosalinda_need_columns = false;
			}
		}
		?>
		<div class="footer_widgets_wrap widget_area<?php echo ! empty( $rosalinda_footer_wide ) ? ' footer_fullwidth' : ''; ?> sc_layouts_row sc_layouts_row_type_normal">
			<div class="footer_widgets_inner widget_area_inner">
				<?php
				if ( ! $rosalinda_footer_wide ) {
					?>
					<div class="content_wrap">
					<?php
				}
				if ( $rosalinda_need_columns ) {
					?>
					<div class="columns_wrap">
					<?php
				}
				do_action( 'rosalinda_action_before_sidebar' );
				rosalinda_show_layout( $rosalinda_out );
				do_action( 'rosalinda_action_after_sidebar' );
				if ( $rosalinda_need_columns ) {
					?>
					</div><!-- /.columns_wrap -->
					<?php
				}
				if ( ! $rosalinda_footer_wide ) {
					?>
					</div><!-- /.content_wrap -->
					<?php
				}
				?>
			</div><!-- /.footer_widgets_inner -->
		</div><!-- /.footer_widgets_wrap -->
		<?php
	}
}
