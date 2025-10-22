<?php
/**
 * Template Name: Hub L3
 * Description: Hub template for category-level hubs with filters and featured content
 */
defined('ABSPATH') || exit;
get_header();

// Simple parameters
$paged = max(1, get_query_var('paged',1));
$per_page = 12;

// Filters via querystring
$filters = array(); foreach (array('protein','fresh','time','diet') as $f) if (!empty($_GET[$f])) $filters[$f]=sanitize_text_field(wp_unslash($_GET[$f]));

// Featured 6 (tagged featured or sticky recent)
$featured = get_posts(array('posts_per_page'=>6,'tag'=>'featured','category_name'=>'cooking','orderby'=>'date','order'=>'DESC','fields'=>'ids'));

// Stream: query by sub-tags if provided
$tag_slugs = array(); if (!empty($filters['protein'])) $tag_slugs[]=$filters['protein'];
$args = array('post_type'=>'post','posts_per_page'=>$per_page,'paged'=>$paged,'category_name'=>'cooking','no_found_rows'=>false,'orderby'=>'date','order'=>'DESC');
if (!empty($tag_slugs)) $args['tag_slug__and']=$tag_slugs;
$q = new WP_Query($args);

?>
<div class="page_content_wrap">
  <div class="content_wrap">
    <div class="content">
      <article <?php post_class('post_item_single'); ?>>
        <div class="container"><div class="content">
          <h1 class="post_title sc_item_title"><?php the_title(); ?></h1>
          <p><?php echo wp_kses_post( wp_trim_words(get_the_excerpt()?:get_the_content(), 40) ); ?></p>

          <div class="sc_item_tags">
            <?php foreach ($filters as $k=>$v) echo '<a class="sc_item_tags_item" href="'.esc_url(remove_query_arg($k)).'">'.esc_html(ucwords(str_replace('_',' ',$v))).' ✕</a>'; ?>
          </div>

          <div class="ad-slot ad-hub-a1 margin_top_large margin_bottom_large" style="min-height:120px; border:2px dashed #e6e6e6; display:flex;align-items:center;justify-content:center;">Ad</div>

          <?php if (!empty($featured)): ?>
            <h2 class="h2">Featured</h2>
            <div class="columns_wrap">
              <?php foreach ($featured as $fid): ?>
                <div class="column-1_3"><article><h3 class="post_title"><a href="<?php echo get_permalink($fid); ?>"><?php echo esc_html(get_the_title($fid)); ?></a></h3></article></div>
              <?php endforeach; ?>
            </div>
          <?php endif; ?>

          <div class="ad-slot ad-hub-a2" style="margin:20px 0; min-height:90px; border:2px dashed #e6e6e6; display:flex;align-items:center;justify-content:center;">Ad</div>

          <h2 class="h2">Explore</h2>
          <div class="columns_wrap">
            <?php if ($q->have_posts()): while ($q->have_posts()): $q->the_post(); ?>
              <div class="column-1_3"><article><h3 class="post_title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3></article></div>
            <?php endwhile; wp_reset_postdata(); else: ?><p>No results</p><?php endif; ?>
          </div>

          <div class="ad-slot ad-hub-a3" style="margin:20px 0; min-height:120px; border:2px dashed #e6e6e6; display:flex;align-items:center;justify-content:center;">Ad</div>

          <?php // Pagination links
            echo '<nav class="pagination">'.paginate_links(array('current'=>$paged,'total'=>$q->max_num_pages)).'</nav>';
          ?>

        </div></div>
      </article>
    </div>
  </div>
</div>

<?php get_footer(); ?>
