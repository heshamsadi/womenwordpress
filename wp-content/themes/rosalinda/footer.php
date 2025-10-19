<?php
/**
 * The Footer: widgets area, logo, footer menu and socials
 *
 * @package WordPress
 * @subpackage ROSALINDA
 * @since ROSALINDA 1.0
 */

						// Widgets area inside page content
						rosalinda_create_widgets_area( 'widgets_below_content' );
						?>
					</div><!-- </.content> -->

					<?php
					// Show main sidebar
					get_sidebar();

					$rosalinda_body_style = rosalinda_get_theme_option( 'body_style' );
					if ( 'fullscreen' != $rosalinda_body_style ) {
						?>
						</div><!-- </.content_wrap> -->
						<?php
					}

					// Widgets area below page content and related posts below page content
					$rosalinda_widgets_name = rosalinda_get_theme_option( 'widgets_below_page' );
					$rosalinda_show_widgets = ! rosalinda_is_off( $rosalinda_widgets_name ) && is_active_sidebar( $rosalinda_widgets_name );
					$rosalinda_show_related = is_single() && rosalinda_get_theme_option( 'related_position' ) == 'below_page';
					if ( $rosalinda_show_widgets || $rosalinda_show_related ) {
						if ( 'fullscreen' != $rosalinda_body_style ) {
							?>
							<div class="content_wrap">
							<?php
						}
						// Show related posts before footer
						if ( $rosalinda_show_related ) {
							do_action( 'rosalinda_action_related_posts' );
						}

						// Widgets area below page content
						if ( $rosalinda_show_widgets ) {
							rosalinda_create_widgets_area( 'widgets_below_page' );
						}
						if ( 'fullscreen' != $rosalinda_body_style ) {
							?>
							</div><!-- </.content_wrap> -->
							<?php
						}
					}
					?>
			</div><!-- </.page_content_wrap> -->

			<?php
			// Single posts banner before footer
			if ( is_singular( 'post' ) ) {
				rosalinda_show_post_banner('footer');
			}
			// Footer
			$rosalinda_footer_type = rosalinda_get_theme_option( 'footer_type' );
			if ( 'custom' == $rosalinda_footer_type && ! rosalinda_is_layouts_available() ) {
				$rosalinda_footer_type = 'default';
			}
			get_template_part( apply_filters( 'rosalinda_filter_get_template_part', "templates/footer-{$rosalinda_footer_type}" ) );
			?>

		</div><!-- /.page_wrap -->

	</div><!-- /.body_wrap -->

	<?php wp_footer(); ?>

</body>
</html>