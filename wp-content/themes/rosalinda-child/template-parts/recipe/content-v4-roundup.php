<?php
/**
 * V4 - Roundup / Collection
 * Shows a filtered grid of recipe cards and outputs ItemList JSON-LD
 */
defined('ABSPATH') || exit;

$paged = max(1, get_query_var('paged', 1));
$per_page = 12; // default, can be increased to 30

// Filters from querystring
$filters = array();
foreach (array('method','protein','time') as $f) {
    if (!empty($_GET[$f])) {
        $filters[$f] = sanitize_text_field(wp_unslash($_GET[$f]));
    }
}

$tag_slugs = array();
if (!empty($filters['method'])) $tag_slugs[] = $filters['method'];
if (!empty($filters['protein'])) $tag_slugs[] = $filters['protein'];
if (!empty($filters['time'])) $tag_slugs[] = $filters['time'];

$args = array(
    'post_type' => 'post',
    'posts_per_page' => $per_page,
    'paged' => $paged,
    'category_name' => 'cooking',
    'no_found_rows' => false,
    'orderby' => 'date',
    'order' => 'DESC',
);

if (!empty($tag_slugs)) {
    $args['tag_slug__and'] = $tag_slugs;
}

$q = new WP_Query($args);

// Ad guardrail
$sections_count = function_exists('child_count_recipe_sections') ? 6 : 6; // roundup uses multiple cards; assume 6 sections equivalent
$ad_slots = function_exists('child_ad_density_guardrail') ? child_ad_density_guardrail($sections_count) : array('A1'=>true,'A2'=>true,'A3'=>true,'A4'=>true);
// per-post layout
$ad_layout = function_exists('child_get_ad_layout') ? child_get_ad_layout(get_the_ID()) : 'A';

// Render filters as chips
?>
<article <?php post_class('post_item_single recipe-template'); ?>>
  <div class="container">
    <div class="content">
      <header class="post_header">
        <h1 class="post_title sc_item_title"><?php esc_html_e('Collection','rosalinda-child'); ?></h1>
        <p class="post_intro"><?php echo wp_kses_post( wp_trim_words( get_the_excerpt() ?: get_the_content(), 30 ) ); ?></p>

        <?php if (!empty($filters)): ?>
          <div class="filter_chips sc_item_tags">
            <?php foreach ($filters as $k => $v): ?>
              <a class="sc_item_tags_item" href="<?php echo esc_url( remove_query_arg($k) ); ?>"><?php echo esc_html( ucwords( str_replace('_',' ',$v) ) ); ?> ✕</a>
            <?php endforeach; ?>
            <a class="sc_item_tags_item" href="<?php echo esc_url( remove_query_arg( array_keys($filters) ) ); ?>"><?php esc_html_e('Clear','rosalinda-child'); ?></a>
          </div>
        <?php endif; ?>
      </header>

      <div class="columns_wrap">
        <?php
        $position = 0;
        $items_for_json = array();
        if ($q->have_posts()):
            while ($q->have_posts()): $q->the_post();
                $position++;
                $items_for_json[] = array(
                    'position' => $position,
                    'url' => get_permalink(),
                );
                $fields = function_exists('child_get_recipe_fields') ? child_get_recipe_fields(get_the_ID()) : array();
        ?>
          <div class="column-1_3">
            <article class="post_item post_craft">
              <h3 class="post_title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
              <p class="post_excerpt"><?php echo wp_kses_post( wp_trim_words( get_the_excerpt() ?: get_the_content(), 18 ) ); ?></p>
              <div class="post_meta">
                <?php if (!empty($fields['times']['total'])): ?><span class="meta_item"><?php echo esc_html($fields['times']['total']); ?> min</span><?php endif; ?>
                <?php if (!empty($fields['nutrition']['calories'])): ?><span class="meta_item"><?php echo esc_html($fields['nutrition']['calories']); ?> kcal</span><?php endif; ?>
              </div>
              <p><a class="theme_button" href="<?php the_permalink(); ?>"><?php esc_html_e('View','rosalinda-child'); ?></a></p>
            </article>
          </div>
        <?php
                // ad after every 4 cards
        if ($position % 4 === 0) {
          // For layout A, use A2 as inline ad. For layout B, if guardrail allows >=3 slots we may insert an extra inline ad earlier (A2.5 handled below).
          if (!empty($ad_slots['A2'])) {
            echo '<div class="column-1_1"><div class="ad-slot ad-inline ad-after-cards" style="margin:20px 0; min-height:90px; border:2px dashed #e6e6e6; display:flex;align-items:center;justify-content:center;color:#999;">Ad</div></div>';
          }
        }
            endwhile;
            wp_reset_postdata();
      // Layout B: optionally insert an extra inline ad (A2.5) after the first block if guardrail allows
      $allowed_count = is_array($ad_slots) ? count(array_filter($ad_slots)) : 0;
      if ($ad_layout === 'B' && $allowed_count >= 3) {
        echo '<div class="column-1_1"><div class="ad-slot ad-inline ad-after-cards-a2-5" style="margin:20px 0; min-height:120px; border:2px dashed #e6e6e6; display:flex;align-items:center;justify-content:center;color:#999;">Ad (A2.5)</div></div>';
      }
        else:
            echo '<p>' . esc_html__('No recipes found','rosalinda-child') . '</p>';
        endif;
        ?>
      </div>

      <?php
      // Pagination
      $big = 999999999; // need an unlikely integer
      echo '<nav class="pagination">' . paginate_links(array(
        'base' => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
        'format' => '?paged=%#%',
        'current' => $paged,
        'total' => $q->max_num_pages,
      )) . '</nav>';
      ?>

      <?php // ItemList JSON-LD ?>
      <?php if (!empty($items_for_json)): ?>
        <script type="application/ld+json">
        <?php echo wp_json_encode(array(
          '@context' => 'https://schema.org',
          '@type' => 'ItemList',
          'itemListElement' => array_map(function($it){ return array('@type'=>'ListItem','position'=>$it['position'],'url'=>$it['url']); }, $items_for_json)
        ), JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT); ?>
        </script>
      <?php endif; ?>

    </div>
  </div>
</article>
