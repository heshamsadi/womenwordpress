<?php
/**
 * The template for homepage posts with "Portfolio" style
 *
 * @package WordPress
 * @subpackage ROSALINDA
 * @since ROSALINDA 1.0
 */

rosalinda_storage_set( 'blog_archive', true );

get_header();

if ( have_posts() ) {

	rosalinda_blog_archive_start();

	$rosalinda_stickies   = is_home() ? get_option( 'sticky_posts' ) : false;
	$rosalinda_sticky_out = rosalinda_get_theme_option( 'sticky_style' ) == 'columns'
							&& is_array( $rosalinda_stickies ) && count( $rosalinda_stickies ) > 0 && get_query_var( 'paged' ) < 1;

	// Show filters
	$rosalinda_cat          = rosalinda_get_theme_option( 'parent_cat' );
	$rosalinda_post_type    = rosalinda_get_theme_option( 'post_type' );
	$rosalinda_taxonomy     = rosalinda_get_post_type_taxonomy( $rosalinda_post_type );
	$rosalinda_show_filters = rosalinda_get_theme_option( 'show_filters' );
	$rosalinda_tabs         = array();
	if ( ! rosalinda_is_off( $rosalinda_show_filters ) ) {
		$rosalinda_args           = array(
			'type'         => $rosalinda_post_type,
			'child_of'     => $rosalinda_cat,
			'orderby'      => 'name',
			'order'        => 'ASC',
			'hide_empty'   => 1,
			'hierarchical' => 0,
			'taxonomy'     => $rosalinda_taxonomy,
			'pad_counts'   => false,
		);
		$rosalinda_portfolio_list = get_terms( $rosalinda_args );
		if ( is_array( $rosalinda_portfolio_list ) && count( $rosalinda_portfolio_list ) > 0 ) {
			$rosalinda_tabs[ $rosalinda_cat ] = esc_html__( 'All', 'rosalinda' );
			foreach ( $rosalinda_portfolio_list as $rosalinda_term ) {
				if ( isset( $rosalinda_term->term_id ) ) {
					$rosalinda_tabs[ $rosalinda_term->term_id ] = $rosalinda_term->name;
				}
			}
		}
	}
	if ( count( $rosalinda_tabs ) > 0 ) {
		$rosalinda_portfolio_filters_ajax   = true;
		$rosalinda_portfolio_filters_active = $rosalinda_cat;
		$rosalinda_portfolio_filters_id     = 'portfolio_filters';
		?>
		<div class="portfolio_filters rosalinda_tabs rosalinda_tabs_ajax">
			<ul class="portfolio_titles rosalinda_tabs_titles">
				<?php
				foreach ( $rosalinda_tabs as $rosalinda_id => $rosalinda_title ) {
					?>
					<li><a href="<?php echo esc_url( rosalinda_get_hash_link( sprintf( '#%s_%s_content', $rosalinda_portfolio_filters_id, $rosalinda_id ) ) ); ?>" data-tab="<?php echo esc_attr( $rosalinda_id ); ?>"><?php echo esc_html( $rosalinda_title ); ?></a></li>
					<?php
				}
				?>
			</ul>
			<?php
			$rosalinda_ppp = rosalinda_get_theme_option( 'posts_per_page' );
			if ( rosalinda_is_inherit( $rosalinda_ppp ) ) {
				$rosalinda_ppp = '';
			}
			foreach ( $rosalinda_tabs as $rosalinda_id => $rosalinda_title ) {
				$rosalinda_portfolio_need_content = $rosalinda_id == $rosalinda_portfolio_filters_active || ! $rosalinda_portfolio_filters_ajax;
				?>
				<div id="<?php echo esc_attr( sprintf( '%s_%s_content', $rosalinda_portfolio_filters_id, $rosalinda_id ) ); ?>"
					class="portfolio_content rosalinda_tabs_content"
					data-blog-template="<?php echo esc_attr( rosalinda_storage_get( 'blog_template' ) ); ?>"
					data-blog-style="<?php echo esc_attr( rosalinda_get_theme_option( 'blog_style' ) ); ?>"
					data-posts-per-page="<?php echo esc_attr( $rosalinda_ppp ); ?>"
					data-post-type="<?php echo esc_attr( $rosalinda_post_type ); ?>"
					data-taxonomy="<?php echo esc_attr( $rosalinda_taxonomy ); ?>"
					data-cat="<?php echo esc_attr( $rosalinda_id ); ?>"
					data-parent-cat="<?php echo esc_attr( $rosalinda_cat ); ?>"
					data-need-content="<?php echo ( false === $rosalinda_portfolio_need_content ? 'true' : 'false' ); ?>"
				>
					<?php
					if ( $rosalinda_portfolio_need_content ) {
						rosalinda_show_portfolio_posts(
							array(
								'cat'        => $rosalinda_id,
								'parent_cat' => $rosalinda_cat,
								'taxonomy'   => $rosalinda_taxonomy,
								'post_type'  => $rosalinda_post_type,
								'page'       => 1,
								'sticky'     => $rosalinda_sticky_out,
							)
						);
					}
					?>
				</div>
				<?php
			}
			?>
		</div>
		<?php
	} else {
		rosalinda_show_portfolio_posts(
			array(
				'cat'        => $rosalinda_cat,
				'parent_cat' => $rosalinda_cat,
				'taxonomy'   => $rosalinda_taxonomy,
				'post_type'  => $rosalinda_post_type,
				'page'       => 1,
				'sticky'     => $rosalinda_sticky_out,
			)
		);
	}

	rosalinda_blog_archive_end();

} else {

	if ( is_search() ) {
		get_template_part( apply_filters( 'rosalinda_filter_get_template_part', 'content', 'none-search' ), 'none-search' );
	} else {
		get_template_part( apply_filters( 'rosalinda_filter_get_template_part', 'content', 'none-archive' ), 'none-archive' );
	}
}

get_footer();
