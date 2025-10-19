<?php
/**
 * The template to display the widgets area in the header
 *
 * @package WordPress
 * @subpackage ROSALINDA
 * @since ROSALINDA 1.0
 */

// Header sidebar
$rosalinda_header_name    = rosalinda_get_theme_option( 'header_widgets' );
$rosalinda_header_present = ! rosalinda_is_off( $rosalinda_header_name ) && is_active_sidebar( $rosalinda_header_name );
if ( $rosalinda_header_present ) {
	rosalinda_storage_set( 'current_sidebar', 'header' );
	$rosalinda_header_wide = rosalinda_get_theme_option( 'header_wide' );
	ob_start();
	if ( is_active_sidebar( $rosalinda_header_name ) ) {
		dynamic_sidebar( $rosalinda_header_name );
	}
	$rosalinda_widgets_output = ob_get_contents();
	ob_end_clean();
	if ( ! empty( $rosalinda_widgets_output ) ) {
		$rosalinda_widgets_output = preg_replace( "/<\/aside>[\r\n\s]*<aside/", '</aside><aside', $rosalinda_widgets_output );
		$rosalinda_need_columns   = strpos( $rosalinda_widgets_output, 'columns_wrap' ) === false;
		if ( $rosalinda_need_columns ) {
			$rosalinda_columns = max( 0, (int) rosalinda_get_theme_option( 'header_columns' ) );
			if ( 0 == $rosalinda_columns ) {
				$rosalinda_columns = min( 6, max( 1, substr_count( $rosalinda_widgets_output, '<aside ' ) ) );
			}
			if ( $rosalinda_columns > 1 ) {
				$rosalinda_widgets_output = preg_replace( '/<aside([^>]*)class="widget/', '<aside$1class="column-1_' . esc_attr( $rosalinda_columns ) . ' widget', $rosalinda_widgets_output );
			} else {
				$rosalinda_need_columns = false;
			}
		}
		?>
		<div class="header_widgets_wrap widget_area<?php echo ! empty( $rosalinda_header_wide ) ? ' header_fullwidth' : ' header_boxed'; ?>">
			<div class="header_widgets_inner widget_area_inner">
				<?php
				if ( ! $rosalinda_header_wide ) {
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
				rosalinda_show_layout( $rosalinda_widgets_output );
				do_action( 'rosalinda_action_after_sidebar' );
				if ( $rosalinda_need_columns ) {
					?>
					</div>	<!-- /.columns_wrap -->
					<?php
				}
				if ( ! $rosalinda_header_wide ) {
					?>
					</div>	<!-- /.content_wrap -->
					<?php
				}
				?>
			</div>	<!-- /.header_widgets_inner -->
		</div>	<!-- /.header_widgets_wrap -->
		<?php
	}
}
