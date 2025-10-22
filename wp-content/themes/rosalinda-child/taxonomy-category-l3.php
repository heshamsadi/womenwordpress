<?php
/**
 * L3 Hub template for cooking taxonomy hubs
 */
defined('ABSPATH') || exit;
get_header();

$term = get_queried_object();
if (!$term || empty($term->term_id)) {
    get_template_part('404');
    get_footer();
    exit;
}

$term_id = $term->term_id;

// chips: prefer term meta override, otherwise discover
$chips = ros_hub_get_chips_for_term($term_id, 8);

// determine paged and filters from $_GET (validated via ros_hub_allowed_filters)
$allowed = ros_hub_allowed_filters();

// If override exists, include override keys/values in allowed set so filter validation
// can accept them (we trust values were validated on save via ros_hub_get_chips_for_term parsing)
$override_transient = get_transient('ros_hub_chips_override_' . $term_id);
if ($override_transient && is_array($override_transient)) {
    foreach ($override_transient as $k => $vals) {
        if (!isset($allowed[$k])) continue;
        // union allowed values with override values
        $allowed[$k] = array_values(array_unique(array_merge($allowed[$k], $vals)));
    }
}
$paged = max(1, get_query_var('paged') ? (int)get_query_var('paged') : ( isset($_GET['pg']) ? (int)$_GET['pg'] : 1 ));
$per_page = 12;
$filters = array(
    'protein' => isset($_GET['protein']) ? sanitize_key($_GET['protein']) : null,
    'state'   => isset($_GET['state'])   ? sanitize_key($_GET['state'])   : null,
    'time'    => isset($_GET['time'])    ? sanitize_key($_GET['time'])    : null,
    'diet'    => isset($_GET['diet'])    ? sanitize_key($_GET['diet'])    : null,
);
$filters = array_filter($filters, function($v){ return !empty($v); });

// ensure filters are whitelisted
foreach ($filters as $k => $v) {
    if (empty($allowed[$k]) || !in_array($v, $allowed[$k], true)) unset($filters[$k]);
}

// helper to build chip links
function ros_chip_link($term, $key, $value) {
    $q = $_GET; $q[$key] = $value; $q['pg'] = null;
    return esc_url(add_query_arg($q, get_term_link($term)));
}

// Intro: use term description or first 60 words excerpt
$intro = term_description($term->term_id) ?: wp_trim_words(get_bloginfo('description') . ' ' . $term->name, 60, '');

// Build featured 6 (term meta featured_posts expected as array of IDs)
$featured_meta = get_term_meta($term_id, 'featured_posts', true);
$featured_ids = is_array($featured_meta) && !empty($featured_meta) ? array_slice($featured_meta,0,6) : array();
if (empty($featured_ids)) {
    $featured_q = function() use ($term_id, $filters) {
        $args = array('posts_per_page'=>6,'tax_query'=>array(array('taxonomy'=>'category','field'=>'term_id','terms'=>$term_id)),'no_found_rows'=>true,'ignore_sticky_posts'=>true,'fields'=>'ids');
        return get_posts($args);
    };
    $featured_ids = rosalinda_hub_get_cached($term_id, array('featured', $filters, 'paged' => $paged), $featured_q);
}

// Streams by sub-tags: pick 4 popular post_tag terms within this term
$streams = rosalinda_hub_get_cached($term_id, array('streams', $filters, 'paged' => $paged), function() use ($term_id) {
    global $wpdb;
    $sql = $wpdb->prepare("SELECT t.slug FROM {$wpdb->terms} t
        JOIN {$wpdb->term_taxonomy} tt ON tt.term_id=t.term_id
        JOIN {$wpdb->term_relationships} tr ON tr.term_taxonomy_id=tt.term_taxonomy_id
        WHERE tt.taxonomy='post_tag' AND tr.object_id IN (
            SELECT object_id FROM {$wpdb->term_relationships} tr2
            JOIN {$wpdb->term_taxonomy} tt2 ON tt2.term_taxonomy_id=tr2.term_taxonomy_id
            WHERE tt2.taxonomy='category' AND tt2.term_id=%d
        ) GROUP BY t.term_id ORDER BY COUNT(*) DESC LIMIT 4", $term_id);
    return $wpdb->get_col($sql);
});

// For each stream, fetch 6 latest post IDs (no_found_rows)
$stream_posts = array();
foreach ($streams as $s) {
    $q = function() use ($s, $term_id) {
        $args = array('posts_per_page'=>6,'tag'=>$s,'tax_query'=>array(array('taxonomy'=>'category','field'=>'term_id','terms'=>$term_id)),'no_found_rows'=>true,'ignore_sticky_posts'=>true,'fields'=>'ids');
        return get_posts($args);
    };
    $stream_posts[$s] = rosalinda_hub_get_cached($term_id, array('stream',$s, $filters, 'paged' => $paged), $q);
}

// Guides: find one how-to and one conversion post in this term
$guides = rosalinda_hub_get_cached($term_id, array('guides', $filters, 'paged' => $paged), function() use ($term_id) {
    $args = array('posts_per_page'=>2,'tag__in'=>array('how-to','conversion'),'tax_query'=>array(array('taxonomy'=>'category','field'=>'term_id','terms'=>$term_id)),'no_found_rows'=>true,'ignore_sticky_posts'=>true,'fields'=>'ids');
    return get_posts($args);
});

// Schema: collection + ItemList of first 10 links (build via IDs)
$collection = rosalinda_hub_get_cached($term_id, array('collection', $filters, 'paged' => $paged), function() use ($term_id) {
    $args = array('posts_per_page'=>10,'tax_query'=>array(array('taxonomy'=>'category','field'=>'term_id','terms'=>$term_id)),'no_found_rows'=>true,'ignore_sticky_posts'=>true,'fields'=>'ids');
    return get_posts($args);
});

// Render
?>
<main class="container">
    <div class="content">
        <header class="term-header">
            <h1 class="h2 sc_item_title"><?php echo esc_html($term->name); ?></h1>
            <p class="term-intro"><?php echo wp_kses_post($intro); ?></p>
            <div class="hub-chips">
                <?php foreach ($chips as $k => $vals) {
                    foreach ($vals as $v) {
                        echo '<a class="chip" href="' . ros_chip_link($term, $k, $v) . '">' . esc_html(ucfirst($v)) . '</a> ';
                    }
                } ?>
            </div>
        </header>

        <?php if (!empty($featured_ids)): ?>
            <section class="hub-featured">
                <h2 class="h2"><?php esc_html_e('Featured', 'rosalinda-child'); ?></h2>
                <div class="columns_wrap">
                    <?php $posts = get_posts(array('post__in'=>$featured_ids,'orderby'=>'post__in','posts_per_page'=>6)); foreach ($posts as $p): ?>
                        <div class="column-1_3"><a href="<?php echo get_permalink($p); ?>"><?php echo get_the_post_thumbnail($p, 'medium'); ?><h3><?php echo esc_html(get_the_title($p)); ?></h3></a></div>
                    <?php endforeach; ?>
                </div>
            </section>
        <?php endif; ?>

    <?php if (!empty($stream_posts)): $i=0; foreach ($stream_posts as $slug => $ids): $i++; ?>
            <section class="hub-stream hub-stream-<?php echo esc_attr($i); ?>">
                <h3 class="h3"><?php echo esc_html(ucfirst(str_replace('-',' ',$slug))); ?></h3>
                <div class="columns_wrap">
                    <?php if (!empty($ids)) { $ps = get_posts(array('post__in'=>$ids,'orderby'=>'date','posts_per_page'=>6)); foreach($ps as $p) { echo '<div class="column-1_4"><a href="'.get_permalink($p).'">'.get_the_post_thumbnail($p,'medium').'<h4>'.esc_html(get_the_title($p)).'</h4></a></div>'; } } ?>
                </div>
            </section>
            <?php if ($i==2): ?><div class="ad-slot ad-hub-1" aria-hidden="true"></div><?php endif; ?>
        <?php endforeach; endif; ?>

    <?php if (!empty($guides)): $g = get_posts(array('post__in'=>$guides,'posts_per_page'=>2)); ?>
            <section class="hub-guides">
                <h2 class="h2"><?php esc_html_e('Guides', 'rosalinda-child'); ?></h2>
                <div class="columns_wrap">
                    <?php foreach ($g as $p) { echo '<div class="column-1_2"><a href="'.get_permalink($p).'">'.get_the_post_thumbnail($p,'medium').'<h3>'.esc_html(get_the_title($p)).'</h3></a></div>'; } ?>
                </div>
            </section>
            <div class="ad-slot ad-hub-2" aria-hidden="true"></div>
        <?php endif; ?>

        <div class="hub-optin"><!-- email opt-in placeholder --></div>

        <?php
        // Primary paginated stream (12 per page) - respect filters and term
        $meta_query = array('relation'=>'AND');
        if (!empty($filters['protein'])) $meta_query[] = array('key'=>'protein','value'=>$filters['protein'],'compare'=>'=');
        if (!empty($filters['state']))   $meta_query[] = array('key'=>'state','value'=>$filters['state'],'compare'=>'=');
        if (!empty($filters['time'])) {
            $min = (int)$filters['time'];
            $max = $min === 15 ? 15 : ($min === 30 ? 30 : 60);
            $meta_query[] = array('key'=>'time_total','value'=>$max,'type'=>'NUMERIC','compare'=>'<=');
        }
        if (!empty($filters['diet'])) $meta_query[] = array('key'=>'diet','value'=>$filters['diet'],'compare'=>'LIKE');

        $primary_args = array(
            'post_type' => 'post',
            'posts_per_page' => $per_page,
            'paged' => $paged,
            'tax_query' => array(array('taxonomy'=>'category','field'=>'term_id','terms'=>$term->term_id)),
            'meta_query' => count($meta_query) > 1 ? $meta_query : array(),
            'ignore_sticky_posts' => true,
        );

        $primary = new WP_Query($primary_args);

        if ($primary->have_posts()):
            echo '<section class="hub-primary"><h2 class="h2">' . esc_html__('All recipes','rosalinda-child') . '</h2><div class="columns_wrap">';
            while ($primary->have_posts()): $primary->the_post();
                echo '<div class="column-1_3"><a href="'.get_permalink().'">'.get_the_post_thumbnail(null,'medium').'<h4>'.esc_html(get_the_title()).'</h4></a></div>';
            endwhile;
            echo '</div>';

            // Pagination
            echo '<div class="hub-pagination">';
            echo paginate_links(array(
                'total' => max(1, (int)$primary->max_num_pages),
                'current' => $paged,
                'format' => '?pg=%#%' . (!empty($filters) ? '&'.http_build_query($filters) : ''),
                'prev_text' => '« Prev',
                'next_text' => 'Next »',
            ));
            echo '</div>';

            // Build ItemList for current page items
            $offset = ($paged - 1) * $per_page;
            $items = array();
            $i = 0;
            while ($primary->have_posts()) { $primary->the_post(); $i++; }
            // We need fresh loop for items, so fetch posts for current page
            wp_reset_postdata();
            $current_ids = wp_list_pluck($primary->posts, 'ID');
            foreach ($current_ids as $pos => $id) {
                $items[] = array('@type'=>'ListItem','position'=>$offset + $pos + 1,'url'=>get_permalink($id),'name'=>get_the_title($id));
            }
            if (!empty($items)) {
                echo '<script type="application/ld+json">' . wp_json_encode(array('@context'=>'https://schema.org','@type'=>'CollectionPage','name'=>$term->name,'mainEntity'=>array('@type'=>'ItemList','itemListElement'=>$items)), JSON_UNESCAPED_SLASHES|JSON_PRETTY_PRINT) . '</script>';
            }
        endif;
        wp_reset_postdata();
        ?>

    </div>
</main>

<?php get_footer();
