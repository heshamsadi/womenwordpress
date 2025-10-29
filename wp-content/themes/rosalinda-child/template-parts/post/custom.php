<?php
/**
 * Child article layout
 * Tweak this file to change your blog post design safely.
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'rl-child-article' ); ?>>

  <header class="entry-header">
    <?php
      // Breadcrumbs (optional helper added below).
      if ( function_exists( 'rosalinda_child_breadcrumbs' ) ) {
        echo '<nav class="breadcrumbs">' . rosalinda_child_breadcrumbs() . '</nav>';
      }

      the_title( '<h1 class="entry-title">', '</h1>' );

      // Meta row
      echo '<div class="entry-meta">';
        // Author
        printf(
          '<span class="byline">%s</span>',
          esc_html( get_the_author() )
        );
        // Date
        printf(
          ' · <time class="published" datetime="%s">%s</time>',
          esc_attr( get_the_date( DATE_W3C ) ),
          esc_html( get_the_date() )
        );
        // Reading time (optional helper)
        if ( function_exists( 'rosalinda_child_reading_time' ) ) {
          printf( ' · <span class="reading-time">%s</span>', esc_html( rosalinda_child_reading_time() ) );
        }
        // Categories
        $cats = get_the_category_list( ', ' );
        if ( $cats ) {
          echo ' · <span class="cat-links">' . $cats . '</span>';
        }
      echo '</div>';
    ?>
  </header>

  <?php if ( has_post_thumbnail() ) : ?>
    <figure class="entry-hero">
      <?php the_post_thumbnail( 'large' ); ?>
      <?php if ( get_the_post_thumbnail_caption() ) : ?>
        <figcaption class="wp-caption-text"><?php echo wp_kses_post( get_the_post_thumbnail_caption() ); ?></figcaption>
      <?php endif; ?>
    </figure>
  <?php endif; ?>

  <?php
    // Ad slot before content (optional hook)
    do_action( 'rosalinda_child_ad_before_content' );
  ?>

  <div class="entry-content">
    <?php
      the_content();

      // Pagination for long posts using <!--nextpage-->
      wp_link_pages( array(
        'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'rosalinda-child' ),
        'after'  => '</div>',
      ) );
    ?>
  </div>

  <?php
    // Ad slot inside/after content (optional hook)
    do_action( 'rosalinda_child_ad_after_content' );
  ?>

  <footer class="entry-footer">
    <div class="tags-links"><?php the_tags( '', ' ', '' ); ?></div>
    <?php
      // Previous/Next links
      the_post_navigation( array(
        'prev_text' => '← %title',
        'next_text' => '%title →',
      ) );
    ?>
  </footer>
</article>
