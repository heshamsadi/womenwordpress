<?php
/**
 * The template to display the page title and breadcrumbs
 *
 * @package WordPress
 * @subpackage ROSALINDA
 * @since ROSALINDA 1.0
 */

// Page (category, tag, archive, author) title

if ( rosalinda_need_page_title() ) {
	rosalinda_sc_layouts_showed( 'title', true );
	rosalinda_sc_layouts_showed( 'postmeta', false );
	?>
	<div class="top_panel_title sc_layouts_row sc_layouts_row_type_normal">
		<div class="content_wrap">
			<div class="sc_layouts_column sc_layouts_column_align_center">
				<div class="sc_layouts_item">
					<div class="sc_layouts_title sc_align_center">
						<?php
						// Post meta on the single post
						if ( false && is_single() ) {
							?>
							<div class="sc_layouts_title_meta">
							<?php
								rosalinda_show_post_meta(
									apply_filters(
										'rosalinda_filter_post_meta_args', array(
											'components' => rosalinda_array_get_keys_by_value( rosalinda_get_theme_option( 'meta_parts' ) ),
											'counters'   => rosalinda_array_get_keys_by_value( rosalinda_get_theme_option( 'counters' ) ),
											'seo'        => rosalinda_is_on( rosalinda_get_theme_option( 'seo_snippets' ) ),
										), 'header', 1
									)
								);
							?>
							</div>
							<?php
						}

						// Blog/Post title
						?>
						<div class="sc_layouts_title_title">
							<?php
							$rosalinda_blog_title           = rosalinda_get_blog_title();
							$rosalinda_blog_title_text      = '';
							$rosalinda_blog_title_class     = '';
							$rosalinda_blog_title_link      = '';
							$rosalinda_blog_title_link_text = '';
							if ( is_array( $rosalinda_blog_title ) ) {
								$rosalinda_blog_title_text      = $rosalinda_blog_title['text'];
								$rosalinda_blog_title_class     = ! empty( $rosalinda_blog_title['class'] ) ? ' ' . $rosalinda_blog_title['class'] : '';
								$rosalinda_blog_title_link      = ! empty( $rosalinda_blog_title['link'] ) ? $rosalinda_blog_title['link'] : '';
								$rosalinda_blog_title_link_text = ! empty( $rosalinda_blog_title['link_text'] ) ? $rosalinda_blog_title['link_text'] : '';
							} else {
								$rosalinda_blog_title_text = $rosalinda_blog_title;
							}
							?>
							<h1 itemprop="headline" class="sc_layouts_title_caption<?php echo esc_attr( $rosalinda_blog_title_class ); ?>">
								<?php
								$rosalinda_top_icon = rosalinda_get_category_icon();
								if ( ! empty( $rosalinda_top_icon ) ) {
									$rosalinda_attr = rosalinda_getimagesize( $rosalinda_top_icon );
									?>
									<img src="<?php echo esc_url( $rosalinda_top_icon ); ?>" alt="<?php esc_attr_e( 'Site icon', 'rosalinda' ); ?>"
										<?php
										if ( ! empty( $rosalinda_attr[3] ) ) {
											rosalinda_show_layout( $rosalinda_attr[3] );
										}
										?>
									>
									<?php
								}
								echo wp_kses_post( $rosalinda_blog_title_text );
								?>
							</h1>
							<?php
							if ( ! empty( $rosalinda_blog_title_link ) && ! empty( $rosalinda_blog_title_link_text ) ) {
								?>
								<a href="<?php echo esc_url( $rosalinda_blog_title_link ); ?>" class="theme_button theme_button_small sc_layouts_title_link"><?php echo esc_html( $rosalinda_blog_title_link_text ); ?></a>
								<?php
							}

							// Category/Tag description
							if ( is_category() || is_tag() || is_tax() ) {
								the_archive_description( '<div class="sc_layouts_title_description">', '</div>' );
							}

							?>
						</div>
						<?php
                        if ( rosalinda_exists_trx_addons() ) { // Breadcrumbs ?>
                            <div class="sc_layouts_title_breadcrumbs">
                                <?php
                                do_action( 'rosalinda_action_breadcrumbs' );
                                ?>
                            </div>
                        <?php
                        }
                        ?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php
}
?>
