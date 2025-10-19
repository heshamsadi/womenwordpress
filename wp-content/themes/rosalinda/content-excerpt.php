<?php
/**
 * The default template to display the content
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
	if ( ! empty( $rosalinda_template_args['slider'] ) ) {
		?><div class="slider-slide swiper-slide">
		<?php
	} elseif ( $rosalinda_columns > 1 ) {
		?>
		<div class="column-1_<?php echo esc_attr( $rosalinda_columns ); ?>">
		<?php
	}
}
$rosalinda_expanded    = ! rosalinda_sidebar_present() && rosalinda_is_on( rosalinda_get_theme_option( 'expand_content' ) );
$rosalinda_post_format = get_post_format();
$rosalinda_post_format = empty( $rosalinda_post_format ) ? 'standard' : str_replace( 'post-format-', '', $rosalinda_post_format );
$rosalinda_animation   = rosalinda_get_theme_option( 'blog_animation' );
$rosalinda_components = rosalinda_array_get_keys_by_value( rosalinda_get_theme_option( 'meta_parts' ) );
$rosalinda_counters   = rosalinda_array_get_keys_by_value( rosalinda_get_theme_option( 'counters' ) );

?>
<article id="post-<?php the_ID(); ?>" 
	<?php post_class( 'post_item post_layout_excerpt post_format_' . esc_attr( $rosalinda_post_format ) ); ?>
	<?php echo ( ! rosalinda_is_off( $rosalinda_animation ) && empty( $rosalinda_template_args['slider'] ) ? ' data-animation="' . esc_attr( rosalinda_get_animation_classes( $rosalinda_animation ) ) . '"' : '' ); ?>
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
	$rosalinda_columns    = empty( $rosalinda_template_args['columns'] ) ? 2 : max( 1, $rosalinda_template_args['columns'] );
	rosalinda_show_post_featured(
		array(
			'singular'   => false,
			'no_links'   => ! empty( $rosalinda_template_args['no_links'] ),
			'hover'      => $rosalinda_hover,
			'thumb_size' => rosalinda_get_thumb_size( strpos( rosalinda_get_theme_option( 'body_style' ), 'full' ) !== false ? 'full' : ( $rosalinda_expanded ? ($rosalinda_columns > 2 ? 'blog' : 'huge' ) : 'except' ) ),
		)
	);

	// Title and post meta
	if ( get_the_title() != '' ) {
		?>
		<div class="post_header entry-header">
			<?php
            do_action( 'rosalinda_action_before_post_meta' );

			// Post meta

			if ( ! empty( $rosalinda_components ) && ! in_array( $rosalinda_hover, array( 'border', 'pull', 'slide', 'fade' ) ) ) {
				rosalinda_show_post_meta(
					apply_filters(
						'rosalinda_filter_post_meta_args', array(
							'components' => $rosalinda_components,
							'counters'   => $rosalinda_counters,
							'seo'        => false,
						), 'excerpt', 1
					)
				);
			}

			do_action( 'rosalinda_action_before_post_title' );

			// Post title
			if ( empty( $rosalinda_template_args['no_links'] ) ) {
				the_title( sprintf( '<h2 class="post_title entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' );
			} else {
				the_title( '<h2 class="post_title entry-title">', '</h2>' );
			}

			?>
		</div><!-- .post_header -->
		<?php
	}

	// Post content
	if ( empty( $rosalinda_template_args['hide_excerpt'] ) ) {

		?>
		<div class="post_content entry-content">
		<?php
		if ( rosalinda_get_theme_option( 'blog_content' ) == 'fullpost' ) {
			// Post content area
			?>
				<div class="post_content_inner">
				<?php
				the_content( '' );
				?>
				</div>
				<?php
				// Inner pages
				wp_link_pages(
					array(
						'before'      => '<div class="page_links"><span class="page_links_title">' . esc_html__( 'Pages:', 'rosalinda' ) . '</span>',
						'after'       => '</div>',
						'link_before' => '<span>',
						'link_after'  => '</span>',
						'pagelink'    => '<span class="screen-reader-text">' . esc_html__( 'Page', 'rosalinda' ) . ' </span>%',
						'separator'   => '<span class="screen-reader-text">, </span>',
					)
				);
		} else {
			// Post content area
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
		?>
		</div><!-- .entry-content -->
		<?php
	}
	?>
	 <div class="post_avtor">
         <?php
             $author_id = get_the_author_meta( 'ID' );
         if ( empty( $author_id ) && ! empty( $GLOBALS['post']->post_author ) ) {
            $author_id = $GLOBALS['post']->post_author;
         }
         if ( $author_id > 0 ) {
            $author_link = get_author_posts_url( $author_id );
            $author_name = get_the_author_meta( 'display_name', $author_id );
            esc_html_e( 'by ', 'rosalinda' )
            ?>
                <a class="post_meta_item post_author" rel="author" href="<?php echo esc_url( $author_link ); ?>">
                    <?php echo esc_html($author_name ); ?>
                </a>
                <?php
         }
              ?>
     </div>
     <?php
        // More button
        if ( false && empty( $rosalinda_template_args['no_links'] ) && ! in_array( $rosalinda_post_format, array( 'link', 'aside', 'status', 'quote' ) ) ) {
            ?>
                <p><a class="more-link" href="<?php echo esc_url( get_permalink() ); ?>"><?php esc_html_e( 'Read more', 'rosalinda' ); ?></a></p>
                <?php

        }
        if (get_the_title() == ''){
            ?>
                <p class="text-center"><a class="more-link" href="<?php echo esc_url( get_permalink() ); ?>"><?php esc_html_e( 'Read more', 'rosalinda' ); ?></a></p>
                <?php
        }
        ?>
	</article>
<?php

if ( is_array( $rosalinda_template_args ) ) {
	if ( ! empty( $rosalinda_template_args['slider'] ) || $rosalinda_columns > 1 ) {
		?>
		</div>
		<?php
	}
}
