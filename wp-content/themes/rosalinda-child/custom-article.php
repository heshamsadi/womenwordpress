<?php
/**
 * Template Name: Custom Article
 * Template Post Type: post
 *
 * A lightweight post template that uses your child template part for layout.
 * Keeps the parent header/footer and global assets intact.
 */

get_header();

if ( have_posts() ) :
  while ( have_posts() ) : the_post();

    /**
     * Hook: before article (e.g., top ad slot). You can attach outputs in functions.php.
     */
    do_action( 'rosalinda_child_before_article' );

    // Load your child layout. If missing, fall back to simple markup.
    $loaded = locate_template( array( 'template-parts/post/custom.php' ), true, false );

    if ( ! $loaded ) : ?>
      <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
        <header class="entry-header">
          <?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
        </header>
        <div class="entry-content">
          <?php the_content(); ?>
        </div>
      </article>
    <?php endif;

    /**
     * Hook: after article (e.g., in-article ad, related posts, comments).
     */
    do_action( 'rosalinda_child_after_article' );

    // Comments (optional)
    if ( comments_open() || get_comments_number() ) {
      comments_template();
    }

  endwhile;
endif;

get_footer();
