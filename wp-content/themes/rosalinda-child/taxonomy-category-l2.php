<?php
/**
 * L2 Landing template for cooking sections
 */
defined('ABSPATH') || exit;
get_header();

$term = get_queried_object();
if (!$term || empty($term->term_id)) { get_template_part('404'); get_footer(); exit; }
$term_id = $term->term_id;

// Intro
$intro = term_description($term->term_id) ?: wp_trim_words($term->name . ' ' . get_bloginfo('description'), 80, '');

// L3 hubs under this L2 are child terms
$l3_terms = get_terms(array('taxonomy'=>'category','parent'=>$term_id,'hide_empty'=>false));
// allow editors to override chips for the whole section
$chips_override = get_term_meta($term_id, 'chips_override', true);
if (!empty($chips_override)) {
    // not used in this L2 template directly, but available for UI or downstream use
}

// Start-here guide
$start_here = rosalinda_hub_get_cached($term_id, array('start'), function() use ($term_id) {
    $args = array('posts_per_page'=>1,'tag'=>'start-here','tax_query'=>array(array('taxonomy'=>'category','field'=>'term_id','terms'=>$term_id)),'no_found_rows'=>true,'fields'=>'ids');
    $res = get_posts($args);
    return $res;
});

// Latest 12 across L3 hubs
// Latest 12 across L3 hubs (cached)
$latest_ids = rosalinda_hub_get_cached($term_id, array('latest12'), function() use ($l3_terms) {
    $term_ids = wp_list_pluck($l3_terms, 'term_id');
    $args = array('posts_per_page'=>12,'tax_query'=>array(array('taxonomy'=>'category','field'=>'term_id','terms'=>$term_ids)),'no_found_rows'=>true,'ignore_sticky_posts'=>true,'fields'=>'ids');
    return get_posts($args);
});

?>
<main class="container">
    <div class="content">
        <header class="term-header">
            <h1 class="h2 sc_item_title"><?php echo esc_html($term->name); ?></h1>
            <p class="term-intro"><?php echo wp_kses_post($intro); ?></p>
        </header>

        <?php if (!empty($l3_terms)): ?>
            <section class="l3-cards">
                <div class="columns_wrap">
                <?php foreach ($l3_terms as $t): ?>
                    <div class="column-1_3"><a href="<?php echo esc_url(get_term_link($t)); ?>"><h3><?php echo esc_html($t->name); ?></h3><p><?php echo esc_html(wp_trim_words($t->description,20)); ?></p></a></div>
                <?php endforeach; ?>
                </div>
            </section>
        <?php endif; ?>

        <div class="ad-slot ad-hub-1" aria-hidden="true"></div>

        <?php if (!empty($start_here)): $sh = get_posts(array('post__in'=>$start_here,'posts_per_page'=>1)); if (!empty($sh)) { $p = $sh[0]; ?>
            <section class="start-here"><h2><?php esc_html_e('Start here', 'rosalinda-child'); ?></h2><a href="<?php echo get_permalink($p); ?>"><?php echo get_the_title($p); ?></a></section>
        <?php } endif; ?>

        <?php if (!empty($latest_ids)): ?>
            <section class="latest-12"><h2><?php esc_html_e('Latest','rosalinda-child'); ?></h2>
                <div class="columns_wrap">
                    <?php $ps = get_posts(array('post__in'=>$latest_ids,'orderby'=>'date','posts_per_page'=>12)); foreach($ps as $p) { echo '<div class="column-1_4"><a href="'.get_permalink($p).'">'.get_the_post_thumbnail($p,'medium').'<h4>'.esc_html(get_the_title($p)).'</h4></a></div>'; } ?>
                </div>
            </section>
        <?php endif; ?>

        <script type="application/ld+json">
        <?php echo wp_json_encode(array('@context'=>'https://schema.org','@type'=>'CollectionPage','name'=>$term->name)); ?>
        </script>

    </div>
</main>

<?php get_footer();
