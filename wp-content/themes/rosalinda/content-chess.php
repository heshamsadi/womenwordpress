<?php
/**
 * The Classic template to display the content
 *
 * Used for index/archive/search.
 *
 * @package WordPress
 * @subpackage ROSALINDA
 * @since ROSALINDA 1.0
 */

$rosalinda_template_args = get_query_var( 'rosalinda_template_args' );
if ( is_array( $rosalinda_template_args ) ) {
	$rosalinda_columns    = empty( $rosalinda_template_args['columns'] ) ? 1 : max( 1, min( 3, $rosalinda_template_args['columns'] ) );
	$rosalinda_blog_style = array( $rosalinda_template_args['type'], $rosalinda_columns );
} else {
	$rosalinda_blog_style = explode( '_', rosalinda_get_theme_option( 'blog_style' ) );
	$rosalinda_columns    = empty( $rosalinda_blog_style[1] ) ? 1 : max( 1, min( 3, $rosalinda_blog_style[1] ) );
}
$rosalinda_expanded    = ! rosalinda_sidebar_present() && rosalinda_is_on( rosalinda_get_theme_option( 'expand_content' ) );
$rosalinda_post_format = get_post_format();
$rosalinda_post_format = empty( $rosalinda_post_format ) ? 'standard' : str_replace( 'post-format-', '', $rosalinda_post_format );
$rosalinda_animation   = rosalinda_get_theme_option( 'blog_animation' );

?><article id="post-<?php the_ID(); ?>" 
									<?php
									post_class(
										'post_item'
										. ' post_layout_chess'
										. ' post_layout_chess_' . esc_attr( $rosalinda_columns )
										. ' post_format_' . esc_attr( $rosalinda_post_format )
										. ( ! empty( $rosalinda_template_args['slider'] ) ? ' slider-slide swiper-slide' : '' )
									);
									echo ( ! rosalinda_is_off( $rosalinda_animation ) && empty( $rosalinda_template_args['slider'] ) ? ' data-animation="' . esc_attr( rosalinda_get_animation_classes( $rosalinda_animation ) ) . '"' : '' );
									?>
	>

	<?php
	// Add anchor
	if ( 1 == $rosalinda_columns && ! is_array( $rosalinda_template_args ) && shortcode_exists( 'trx_sc_anchor' ) ) {
		echo do_shortcode( '[trx_sc_anchor id="post_' . esc_attr( get_the_ID() ) . '" title="' . esc_attr( the_title_attribute( array( 'echo' => false ) ) ) . '" icon="' . esc_attr( rosalinda_get_post_icon() ) . '"]' );
	}

	// Sticky label
	if ( is_sticky() && ! is_paged() ) {
		?>
		<span class="post_label label_sticky"></span>
		<?php
	}

	// Featured image
	$rosalinda_hover = ! empty( $rosalinda_template_args['hover'] ) && ! rosalinda_is_inherit( $rosalinda_template_args['hover'] )
						? $rosalinda_template_args['hover']
						: rosalinda_get_theme_option( 'image_hover' );
	rosalinda_show_post_featured(
		array(
			'class'         => 1 == $rosalinda_columns && ! is_array( $rosalinda_template_args ) ? 'rosalinda-full-height' : '',
			'singular'      => false,
			'hover'         => $rosalinda_hover,
			'no_links'      => ! empty( $rosalinda_template_args['no_links'] ),
			'show_no_image' => true,
			'thumb_ratio'   => '1:1',
			'thumb_bg'      => true,
			'thumb_size'    => rosalinda_get_thumb_size(
				strpos( rosalinda_get_theme_option( 'body_style' ), 'full' ) !== false
										? ( 1 < $rosalinda_columns ? 'huge' : 'original' )
										: ( 2 < $rosalinda_columns ? 'big' : 'huge' )
			),
		)
	);

	?>
	<div class="post_inner"><div class="post_inner_content"><div class="post_header entry-header">
		<?php
			do_action( 'rosalinda_action_before_post_title' );

			// Post title
		if ( empty( $rosalinda_template_args['no_links'] ) ) {
			the_title( sprintf( '<h3 class="post_title entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h3>' );
		} else {
			the_title( '<h3 class="post_title entry-title">', '</h3>' );
		}

			do_action( 'rosalinda_action_before_post_meta' );

			// Post meta
			$rosalinda_components = rosalinda_array_get_keys_by_value( rosalinda_get_theme_option( 'meta_parts' ) );
			$rosalinda_counters   = rosalinda_array_get_keys_by_value( rosalinda_get_theme_option( 'counters' ) );
			$rosalinda_post_meta  = empty( $rosalinda_components ) || in_array( $rosalinda_hover, array( 'border', 'pull', 'slide', 'fade' ) )
										? ''
										: rosalinda_show_post_meta(
											apply_filters(
												'rosalinda_filter_post_meta_args', array(
													'components' => $rosalinda_components,
													'counters' => $rosalinda_counters,
													'seo'  => false,
													'echo' => false,
												), $rosalinda_blog_style[0], $rosalinda_columns
											)
										);
			rosalinda_show_layout( $rosalinda_post_meta );
			?>
		</div><!-- .entry-header -->

		<div class="post_content entry-content">
		<?php
		if ( empty( $rosalinda_template_args['hide_excerpt'] ) ) {
			?>
				<div class="post_content_inner">
				<?php
				if ( has_excerpt() ) {
					the_excerpt();
				} elseif ( strpos( get_the_content( '!--more' ), '!--more' ) !== false ) {
					the_content( '' );
				} elseif ( in_array( $rosalinda_post_format, array( 'link', 'aside', 'status' ) ) ) {
					the_content();
				} elseif ( 'quote' == $rosalinda_post_format ) {
					$quote = rosalinda_get_tag( get_the_content(), '<blockquote>', '</blockquote>' );
					if ( ! empty( $quote ) ) {
						rosalinda_show_layout( wpautop( $quote ) );
					} else {
						the_excerpt();
					}
				} elseif ( substr( get_the_content(), 0, 4 ) != '[vc_' ) {
					the_excerpt();
				}
				?>
				</div>
				<?php
		}
			// Post meta
		if ( in_array( $rosalinda_post_format, array( 'link', 'aside', 'status', 'quote' ) ) ) {
			rosalinda_show_layout( $rosalinda_post_meta );
		}
			// More button
		if ( empty( $rosalinda_template_args['no_links'] ) && ! in_array( $rosalinda_post_format, array( 'link', 'aside', 'status', 'quote' ) ) ) {
			?>
				<p><a class="more-link" href="<?php echo esc_url( get_permalink() ); ?>"><?php esc_html_e( 'Read more', 'rosalinda' ); ?></a></p>
				<?php
		}
		?>
		</div><!-- .entry-content -->

	</div></div><!-- .post_inner -->

</article><?php
// Need opening PHP-tag above, because <article> is a inline-block element (used as column)!
