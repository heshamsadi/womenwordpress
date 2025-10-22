<?php
/**
 * Variant V3 - Five-Ingredient Dinner
 */
defined('ABSPATH') || exit;
$post_id = get_the_ID();
$recipe = child_get_recipe_fields($post_id);

// Helper to filter trivial ingredients
function _v3_filter_ingredients($ings) {
    $ignore = array('salt','pepper','oil','olive oil','spray');
    $clean = array();
    foreach ($ings as $i) {
        $t = strtolower(strip_tags($i));
        $has_ignore = false;
        foreach ($ignore as $ig) { if (strpos($t, $ig)!==false) { $has_ignore = true; break; } }
        if (!$has_ignore) $clean[] = $i;
    }
    return $clean;
}

$ings = _v3_filter_ingredients($recipe['ingredients']);

// Admin preview notice if more than 5
if (is_preview() && count($ings) > 5) {
    echo '<div class="notice notice-warning">' . esc_html__('This recipe has more than 5 ingredients. Preview will show top 5.', 'rosalinda-child') . '</div>';
}

// Front-end: show top 5 and a note
if (!empty($ings)) {
    $top = array_slice($ings, 0, 5);
} else {
    include get_stylesheet_directory() . '/template-parts/recipe/content.php';
    return;
}
?>
<article id="post-<?php the_ID(); ?>" <?php post_class('post_item_single post_type_' . esc_attr(get_post_type()) . ' recipe-template'); ?>>
    <div class="container">
    <div class="content">
    <section class="v3-intro"><h1 class="post_title"><?php the_title(); ?></h1><?php if (!empty($recipe['intro'])) echo '<p>'.wp_kses_post($recipe['intro']).'</p>'; ?></section>
    <div class="ad-slot ad-a1 mt-30 mb-30" style="min-height:280px;" aria-hidden="true"></div>

    <section class="v3-ings"><h2 class="h2"><?php esc_html_e('Ingredients (Top 5)','rosalinda-child'); ?></h2><ul class="trx_addons_list">
    <?php foreach ($top as $t) echo '<li>'.wp_kses_post($t).'</li>'; ?></ul>
    <p class="v3-note"><?php esc_html_e('Keep to 5 ingredients for this variant.','rosalinda-child'); ?></p>
    </section>

    <?php if (!empty($recipe['recipe_cost'])): ?><p><?php echo esc_html('≈$'.esc_html($recipe['recipe_cost']).' for '.esc_html($recipe['yield'])); ?></p><?php endif; ?>

    <section class="v3-steps"><h2 class="h2"><?php esc_html_e('Instructions','rosalinda-child'); ?></h2>
        <ol class="trx_addons_list trx_addons_list_numbered"><?php foreach ($recipe['steps'] as $s) echo '<li>'.wp_kses_post($s).'</li>'; ?></ol>
    </section>

    <?php if (!empty($recipe['storage'])) echo '<section class="v3-storage"><h3 class="h3">'.esc_html__('Storage','rosalinda-child').'</h3><p>'.wp_kses_post($recipe['storage']).'</p></section>'; ?>
    <?php if (!empty($recipe['faqs'])) { echo '<section class="v3-faqs"><h2 class="h2">'.esc_html__('FAQ','rosalinda-child').'</h2>'; foreach($recipe['faqs'] as $f) echo '<h3 class="h3">'.wp_kses_post($f['q']).'</h3><p>'.wp_kses_post($f['a']).'</p>'; echo '</section>'; } ?>

    <div class="ad-slot ad-a2 mt-30 mb-30" style="min-height:150px;" aria-hidden="true"></div>

    <?php $related = child_related_min($post_id); if (!empty($related['siblings'])) { echo '<section class="v3-related"><h2 class="h2">'.esc_html__('Related','rosalinda-child').'</h2><ul class="trx_addons_list">'; foreach($related['siblings'] as $s) echo '<li><a href="'.esc_url($s['url']).'">'.esc_html($s['title']).'</a></li>'; echo '</ul></section>'; } ?>

    <div class="ad-slot ad-a3 mt-30 mb-30" style="min-height:120px;" aria-hidden="true"></div>

    <?php child_recipe_schema_min($post_id); ?>

    </div><!-- .content -->
    </div><!-- .container -->
</article>
