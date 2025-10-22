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

// sections and guardrail
$sections_count = function_exists('child_count_recipe_sections') ? child_count_recipe_sections($recipe) : 3;
$ad_slots = function_exists('child_ad_density_guardrail') ? child_ad_density_guardrail($sections_count) : array('A1'=>true,'A2'=>true,'A3'=>true,'A4'=>true);
// per-post layout
$ad_layout = function_exists('child_get_ad_layout') ? child_get_ad_layout($post_id) : 'A';

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
    <section class="v3-intro"><h1 class="post_title sc_item_title"><?php the_title(); ?></h1><?php if (!empty($recipe['intro'])) echo '<p>'.wp_kses_post($recipe['intro']).'</p>'; ?>
    <?php $__fields = $recipe; $__ad_decisions = isset($ad_slots) ? $ad_slots : null; get_template_part('template-parts/recipe/partials/metrics-strip', null, array('fields'=>$__fields)); ?>
    </section>
    <?php if (!empty($ad_slots['A1'])): ?><div class="ad-slot ad-a1 margin_top_large margin_bottom_large" style="min-height:280px;" aria-hidden="true"></div><?php endif; ?>

    <?php $__fields = array('ingredients'=>$top) + $recipe; get_template_part('template-parts/recipe/partials/ingredients', null, array('fields'=>$__fields)); ?>
    <p class="v3-note"><?php esc_html_e('Keep to 5 ingredients for this variant.','rosalinda-child'); ?></p>

    <?php if (!empty($recipe['recipe_cost'])): ?><p><?php echo esc_html('≈$'.esc_html($recipe['recipe_cost']).' for '.esc_html($recipe['yield'])); ?></p><?php endif; ?>

    <?php $__fields = array('ingredients'=>$top,'steps'=>$recipe['steps']) + $recipe; get_template_part('template-parts/recipe/partials/steps', null, array('fields'=>$__fields)); ?>

    <?php
    // Layout B: optional A2.5 after steps
    $allowed_count = is_array($ad_slots) ? count(array_filter($ad_slots)) : 0;
    if ($ad_layout === 'B' && $allowed_count >= 3): ?>
        <div class="ad-slot ad-a2-5 mt-20 mb-20" style="min-height:140px;" aria-hidden="true"></div>
    <?php endif; ?>

    <?php get_template_part('template-parts/recipe/partials/storage', null, array('fields'=>$__fields)); ?>
    <?php get_template_part('template-parts/recipe/partials/faq', null, array('fields'=>$__fields)); ?>

    <?php if (!empty($ad_slots['A2'])): ?><div class="ad-slot ad-a2 mt-30 mb-30" style="min-height:150px;" aria-hidden="true"></div><?php endif; ?>

    <?php $related = child_related_min($post_id); get_template_part('template-parts/recipe/partials/related', null, array('related'=>$related,'fields'=>$__fields)); ?>

    <?php if (!empty($ad_slots['A3'])): ?><div class="ad-slot ad-a3 mt-30 mb-30" style="min-height:120px;" aria-hidden="true"></div><?php endif; ?>

    <?php child_recipe_schema_min($post_id); ?>

    </div><!-- .content -->
    </div><!-- .container -->
</article>
