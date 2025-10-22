<?php
/**
 * Recipe content template (namespaced minimal)
 * Renders only sections with data and reuses parent theme classes.
 */
defined('ABSPATH') || exit;

$post_id = get_the_ID();
$recipe = child_get_recipe_fields($post_id);
$related = child_related_min($post_id);
// Ad density guardrail: decide which slots to render
// sections and guardrail
$sections_count = function_exists('child_count_recipe_sections') ? child_count_recipe_sections($recipe) : 3;
$ad_slots = function_exists('child_ad_density_guardrail') ? child_ad_density_guardrail($sections_count) : array('A1'=>true,'A2'=>true,'A3'=>true,'A4'=>true);
// per-post layout choice
$ad_layout = function_exists('child_get_ad_layout') ? child_get_ad_layout($post_id) : 'A';

// Helper: parent grid classes prefer, fallback to .c-recipe-grid
$grid_left = 'column-1';
$grid_right = 'column-2';

// Title + intro + jump link
?>
<article id="post-<?php the_ID(); ?>" <?php post_class('post_item_single post_type_' . esc_attr(get_post_type()) . ' recipe-template'); ?>>
    <div class="container">
    <div class="content">
    <header class="post_header post_header_single">
        <h1 class="post_title sc_item_title"><?php the_title(); ?></h1>
    <?php if (!empty($recipe['intro'])): ?>
        <p class="post_intro"><?php echo wp_kses_post($recipe['intro']); ?></p>
    <?php endif; ?>
    <p><a href="#recipe-card" class="theme_button"><?php esc_html_e('JUMP TO RECIPE', 'rosalinda-child'); ?></a></p>
    
    <?php
    // Metrics strip (icons + chips). Uses child helper which prefers parent helpers when available.
    $__fields = $recipe; // local alias for partials
    $__ad_decisions = isset($ad_slots) ? $ad_slots : null;
    get_template_part('template-parts/recipe/partials/metrics-strip', null, array('fields'=>$__fields));
    ?>
    </header>

    <?php
    // Render A1 always first if allowed
    if (!empty($ad_slots['A1'])): ?>
    <div class="ad-slot ad-a1 margin_top_large margin_bottom_large" style="min-height:280px;" aria-hidden="true"></div>
    <?php endif; ?>

    <div class="post_content post_content_single entry-content">
        <?php the_content(); ?>

        <section class="section-block mt-30">
            <div class="columns_wrap">
                <div class="column-1_2">
                    <?php get_template_part('template-parts/recipe/partials/ingredients', null, array('fields'=>$__fields)); ?>
                </div>
                <div class="column-1_2">
                    <?php get_template_part('template-parts/recipe/partials/steps', null, array('fields'=>$__fields)); ?>
                </div>
            </div>
        </section>

    <?php get_template_part('template-parts/recipe/partials/time-temp', null, array('fields'=>$__fields)); ?>

    <?php
    // Layout B: optional extra ad slot A2.5 after Time & Temp.
    $allowed_count = is_array($ad_slots) ? count(array_filter($ad_slots)) : 0;
    if ($ad_layout === 'B' && $allowed_count >= 3) :
    ?>
    <div class="ad-slot ad-a2-5 mt-20 mb-20" style="min-height:140px;" aria-hidden="true"></div>
    <?php endif; ?>

    <?php
    // Layout A: A2 here. Layout B: A2 here and optionally A2.5 after time/temp (handled below).
    if (!empty($ad_slots['A2'])): ?>
    <div class="ad-slot ad-a2 mt-30 mb-30" style="min-height:150px;" aria-hidden="true"></div>
    <?php endif; ?>

    <?php get_template_part('template-parts/recipe/partials/subs', null, array('fields'=>$__fields)); ?>
    <?php get_template_part('template-parts/recipe/partials/storage', null, array('fields'=>$__fields)); ?>
    <?php get_template_part('template-parts/recipe/partials/variations', null, array('fields'=>$__fields)); ?>

    <?php get_template_part('template-parts/recipe/partials/tools', null, array('fields'=>$__fields)); ?>

    <?php get_template_part('template-parts/recipe/partials/faq', null, array('fields'=>$__fields)); ?>

    <?php if (!empty($ad_slots['A3'])): ?>
    <div class="ad-slot ad-a3 mt-30 mb-30" style="min-height:120px;" aria-hidden="true"></div>
    <?php endif; ?>

    <?php if (!empty($recipe['nutrition']) && !empty($recipe['nutrition']['kcal'])): ?>
        <section id="nutrition" class="recipe-nutrition"><h2 class="h2"><?php esc_html_e('Nutrition Facts','rosalinda-child'); ?></h2>
            <table class="sc_table table--compact c-recipe-table">
                <tr><td><?php esc_html_e('Calories','rosalinda-child'); ?></td><td><?php echo esc_html($recipe['nutrition']['kcal']); ?></td></tr>
                <tr><td><?php esc_html_e('Protein','rosalinda-child'); ?></td><td><?php echo esc_html($recipe['nutrition']['protein']); ?> g</td></tr>
                <tr><td><?php esc_html_e('Carbs','rosalinda-child'); ?></td><td><?php echo esc_html($recipe['nutrition']['carb']); ?> g</td></tr>
                <tr><td><?php esc_html_e('Fat','rosalinda-child'); ?></td><td><?php echo esc_html($recipe['nutrition']['fat']); ?> g</td></tr>
            </table>
        </section>
    <?php endif; ?>

    <?php get_template_part('template-parts/recipe/partials/related', null, array('related'=>$related,'fields'=>$__fields)); ?>

    <?php if (!empty($ad_slots['A4'])): ?>
    <div class="ad-slot ad-a4 mt-30 mb-30" style="min-height:90px;" aria-hidden="true"></div>
    <?php endif; ?>

        <div id="recipe-card"></div>
        <?php child_recipe_schema_min($post_id); ?>

    </div> <!-- .post_content -->

    </div> <!-- .content -->
    </div> <!-- .container -->
</article>