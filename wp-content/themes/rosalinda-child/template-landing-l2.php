<?php
/**
 * Template Name: Landing L2
 * Shows L3 hubs and latest recipes across them
 */
defined('ABSPATH') || exit;
get_header();

$paged = max(1, get_query_var('paged',1));
$per_page = 12;

// Fetch L3 hubs as child pages or categories; we approximate by pages using template-hub-l3
$hubs = get_pages(array('meta_key'=>'_wp_page_template','meta_value'=>'template-hub-l3.php'));

// Latest across those hubs: recent cooking posts
$q = new WP_Query(array('post_type'=>'post','posts_per_page'=>$per_page,'paged'=>$paged,'category_name'=>'cooking','no_found_rows'=>false));
?>
<div class="page_content_wrap">
  <div class="content_wrap">
    <div class="content">
      <article <?php post_class('post_item_single'); ?>>
        <div class="container"><div class="content">
          <h1 class="post_title sc_item_title"><?php the_title(); ?></h1>
          <p><?php echo wp_kses_post( wp_trim_words(get_the_excerpt()?:get_the_content(), 40) ); ?></p>

          <h2 class="h2">Hubs</h2>
          <div class="columns_wrap">
            <?php foreach ($hubs as $hub): ?>
              <div class="column-1_3"><article><h3 class="post_title"><a href="<?php echo get_permalink($hub->ID); ?>"><?php echo esc_html($hub->post_title); ?></a></h3></article></div>
            <?php endforeach; ?>
          </div>

          <h2 class="h2">Start here</h2>
          <div class="columns_wrap">
            <?php if ($q->have_posts()): while ($q->have_posts()): $q->the_post(); ?>
              <div class="column-1_3"><article><h3 class="post_title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3></article></div>
            <?php endwhile; wp_reset_postdata(); else: ?><p>No results</p><?php endif; ?>
          </div>

          <?php echo '<nav class="pagination">'.paginate_links(array('current'=>$paged,'total'=>$q->max_num_pages)).'</nav>'; ?>

        </div></div>
      </article>
    </div>
  </div>
</div>

<?php get_footer(); ?>
