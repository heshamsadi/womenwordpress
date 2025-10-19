<?php
/**
 * The default template to display the content of the single post, page or attachment
 *
 * Used for index/archive/search.
 *
 * @package WordPress
 * @subpackage ROSALINDA
 * @since ROSALINDA 1.0
 */

$rosalinda_seo = rosalinda_is_on( rosalinda_get_theme_option( 'seo_snippets' ) );
$rosalinda_expanded    = ! rosalinda_sidebar_present() && rosalinda_is_on( rosalinda_get_theme_option( 'expand_content' ) );
?>
<article id="post-<?php the_ID(); ?>" 
	<?php
	post_class('post_item_single post_type_' . esc_attr( get_post_type() ) 
		. ' post_format_' . esc_attr( str_replace( 'post-format-', '', get_post_format() ) )
	);
	if ( $rosalinda_seo ) {
		?>
		itemscope="itemscope" 
		itemprop="articleBody" 
		itemtype="//schema.org/<?php echo esc_attr( rosalinda_get_markup_schema() ); ?>" 
		itemid="<?php echo esc_url( get_the_permalink() ); ?>"
		content="<?php the_title_attribute(); ?>"
		<?php
	}
	?>
>
<?php

	do_action( 'rosalinda_action_before_post_data' );

	// Structured data snippets
	if ( $rosalinda_seo ) {
		get_template_part( apply_filters( 'rosalinda_filter_get_template_part', 'templates/seo' ) );
	}


	// Post content
	?>
	<div class="post_content post_content_single entry-content" itemprop="mainEntityOfPage">
		<?php
        if ( is_singular( 'post' ) ) {
            $rosalinda_post_thumbnail_type  = rosalinda_get_theme_option( 'post_thumbnail_type' );
            $rosalinda_post_header_position = rosalinda_get_theme_option( 'post_header_position' );
            $rosalinda_post_header_align    = rosalinda_get_theme_option( 'post_header_align' );

            if ( 'default' === $rosalinda_post_thumbnail_type ) {
                ?>
                <div class="header_content_wrap header_align_<?php echo esc_attr( $rosalinda_post_header_align ); ?>">
                    <?php
                    // Post title and meta
                    if ( 'above' === $rosalinda_post_header_position ) {
                        rosalinda_show_post_title_and_meta();
                    }

                    // Featured image
                    rosalinda_show_post_featured(
                        array(
                            'thumb_size' => rosalinda_get_thumb_size( strpos( rosalinda_get_theme_option( 'body_style' ), 'full' ) !== false ? 'full' : ( $rosalinda_expanded ? 'huge' : 'except' ) ),
                            'thumb_ratio' => '16:7',
                        )
                    );

                    // Post title and meta
                    if ( 'above' !== $rosalinda_post_header_position ) {
                        rosalinda_show_post_title_and_meta();
                    }
                    ?>
                </div>
                <?php
            } elseif ( 'default' === $rosalinda_post_header_position ) {
                // Post title and meta
                rosalinda_show_post_title_and_meta();
            }
        }

        do_action( 'rosalinda_action_before_post_content' );

		the_content();

		do_action( 'rosalinda_action_before_post_pagination' );

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

		// Taxonomies and share
		if ( is_single() && ! is_attachment() ) {

			do_action( 'rosalinda_action_before_post_meta' );

			// Post rating
			do_action(
				'trx_addons_action_post_rating', array(
					'class'                => 'single_post_rating',
					'rating_text_template' => esc_html__( 'Post rating: {{X}} from {{Y}} (according {{V}})', 'rosalinda' ),
				)
			);

			?>
			<div class="post_meta post_meta_single">
				<?php

				// Post taxonomies
				the_tags( '<span class="post_meta_item post_tags"><span class="post_meta_label">' . esc_html__( 'Tags:', 'rosalinda' ) . '</span> ', ', ', '</span>' );

				// Share
				if ( rosalinda_is_on( rosalinda_get_theme_option( 'show_share_links' ) ) ) {
					rosalinda_show_share_links(
						array(
							'type'    => 'block',
                            'caption' => 'Share:',
							'before'  => '<span class="post_meta_item post_share">',
							'after'   => '</span>',
						)
					);
				}
				?>
			</div>
			<?php

			do_action( 'rosalinda_action_after_post_meta' );
		}
		?>
	</div><!-- .entry-content -->


	<?php
	do_action( 'rosalinda_action_after_post_content' );

	// Author bio
	if ( rosalinda_get_theme_option( 'show_author_info' ) == 1 && is_single() && ! is_attachment() && get_the_author_meta( 'description' ) ) {
		do_action( 'rosalinda_action_before_post_author' );
		get_template_part( apply_filters( 'rosalinda_filter_get_template_part', 'templates/author-bio' ) );
		do_action( 'rosalinda_action_after_post_author' );
	}

	do_action( 'rosalinda_action_after_post_data' );
	?>
</article>
