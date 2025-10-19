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
	$rosalinda_columns    = empty( $rosalinda_template_args['columns'] ) ? 2 : max( 1, $rosalinda_template_args['columns'] );
	$rosalinda_blog_style = array( $rosalinda_template_args['type'], $rosalinda_columns );
} else {
	$rosalinda_blog_style = explode( '_', rosalinda_get_theme_option( 'blog_style' ) );
	$rosalinda_columns    = empty( $rosalinda_blog_style[1] ) ? 2 : max( 1, $rosalinda_blog_style[1] );
}
$rosalinda_expanded   = ! rosalinda_sidebar_present() && rosalinda_is_on( rosalinda_get_theme_option( 'expand_content' ) );
$rosalinda_animation  = rosalinda_get_theme_option( 'blog_animation' );
$rosalinda_components = rosalinda_array_get_keys_by_value( rosalinda_get_theme_option( 'meta_parts' ) );
$rosalinda_counters   = rosalinda_array_get_keys_by_value( rosalinda_get_theme_option( 'counters' ) );

$rosalinda_post_format = get_post_format();
$rosalinda_post_format = empty( $rosalinda_post_format ) ? 'standard' : str_replace( 'post-format-', '', $rosalinda_post_format );

?><div class="
<?php
if ( ! empty( $rosalinda_template_args['slider'] ) ) {
	echo ' slider-slide swiper-slide';
} else {
	echo ( 'classic' == $rosalinda_blog_style[0] ? 'column' : 'masonry_item masonry_item' ) . '-1_' . esc_attr( $rosalinda_columns );
}
?>
"><article id="post-<?php the_ID(); ?>" 
	<?php
		post_class(
			'post_item post_format_' . esc_attr( $rosalinda_post_format )
					. ' post_layout_classic post_layout_classic_' . esc_attr( $rosalinda_columns )
					. ' post_layout_' . esc_attr( $rosalinda_blog_style[0] )
					. ' post_layout_' . esc_attr( $rosalinda_blog_style[0] ) . '_' . esc_attr( $rosalinda_columns )
		);
		echo ( ! rosalinda_is_off( $rosalinda_animation ) && empty( $rosalinda_template_args['slider'] ) ? ' data-animation="' . esc_attr( rosalinda_get_animation_classes( $rosalinda_animation ) ) . '"' : '' );
		?>
	>
	<?php

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
			'thumb_size' => rosalinda_get_thumb_size(
				'classic' == $rosalinda_blog_style[0]
						? ( strpos( rosalinda_get_theme_option( 'body_style' ), 'full' ) !== false
								? ( $rosalinda_columns > 2 ? 'big' : 'huge' )
								: ( $rosalinda_columns > 2
									? ( $rosalinda_expanded ? 'med' : 'small' )
									: ( $rosalinda_expanded ? 'big' : 'med' )
									)
							)
						: ( strpos( rosalinda_get_theme_option( 'body_style' ), 'full' ) !== false
								? ( $rosalinda_columns > 2 ? 'masonry-big' : 'full' )
								: ( $rosalinda_columns <= 2 && $rosalinda_expanded ? 'masonry-big' : 'masonry' )
							)
			),
			'hover'      => $rosalinda_hover,
			'no_links'   => ! empty( $rosalinda_template_args['no_links'] ),
			'singular'   => false,
		)
	);

	if ( ! in_array( $rosalinda_post_format, array( 'link', 'aside', 'status', 'quote' ) ) ) {
		?>
		<div class="post_header entry-header">
			<?php
			do_action( 'rosalinda_action_before_post_title' );

			// Post title
			if ( empty( $rosalinda_template_args['no_links'] ) ) {
				the_title( sprintf( '<h4 class="post_title entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h4>' );
			} else {
				the_title( '<h4 class="post_title entry-title">', '</h4>' );
			}

			do_action( 'rosalinda_action_before_post_meta' );

			// Post meta
			if ( ! empty( $rosalinda_components ) && ! in_array( $rosalinda_hover, array( 'border', 'pull', 'slide', 'fade' ) ) ) {
				rosalinda_show_post_meta(
					apply_filters(
						'rosalinda_filter_post_meta_args', array(
							'components' => $rosalinda_components,
							'counters'   => $rosalinda_counters,
							'seo'        => false,
						), $rosalinda_blog_style[0], $rosalinda_columns
					)
				);
			}

			do_action( 'rosalinda_action_after_post_meta' );
			?>
		</div><!-- .entry-header -->
		<?php
	}
	?>

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
		if ( ! empty( $rosalinda_components ) ) {
			rosalinda_show_post_meta(
				apply_filters(
					'rosalinda_filter_post_meta_args', array(
						'components' => $rosalinda_components,
						'counters'   => $rosalinda_counters,
					), $rosalinda_blog_style[0], $rosalinda_columns
				)
			);
		}
	}
		// More button
	if ( false && empty( $rosalinda_template_args['no_links'] ) && ! in_array( $rosalinda_post_format, array( 'link', 'aside', 'status', 'quote' ) ) ) {
		?>
			<p><a class="more-link" href="<?php echo esc_url( get_permalink() ); ?>"><?php esc_html_e( 'Read more', 'rosalinda' ); ?></a></p>
			<?php
	}
	?>
	</div><!-- .entry-content -->

</article></div><?php
// Need opening PHP-tag above, because <div> is a inline-block element (used as column)!
