<?php
/**
 * Recipe content template (namespaced minimal)
 * Renders only sections with data and reuses parent theme classes.
 */
defined('ABSPATH') || exit;

$post_id = get_the_ID();
$recipe = child_get_recipe_fields($post_id);
$related = child_related_min($post_id);

// Helper: parent grid classes prefer, fallback to .c-recipe-grid
$grid_left = 'column-1';
$grid_right = 'column-2';

// Title + intro + jump link
?>
<article id="post-<?php the_ID(); ?>" <?php post_class('post_item_single post_type_' . esc_attr(get_post_type()) . ' recipe-template'); ?>>
    <div class="container">
    <div class="content">
    <header class="post_header post_header_single">
        <h1 class="post_title"><?php the_title(); ?></h1>
    <?php if (!empty($recipe['intro'])): ?>
        <p class="post_intro"><?php echo wp_kses_post($recipe['intro']); ?></p>
    <?php endif; ?>
        <p><a href="#recipe-card" class="theme_button"><?php esc_html_e('Jump to Recipe', 'rosalinda-child'); ?></a></p>
    
    <div class="recipe_metrics" role="group" aria-label="Recipe metrics">
        <?php if (!empty($recipe['prep'])): ?><span class="metric metric-prep"><?php printf(esc_html__('%s min prep','rosalinda-child'), esc_html($recipe['prep'])); ?></span><?php endif; ?>
        <?php if (!empty($recipe['cook'])): ?><span class="metric metric-cook"><?php printf(esc_html__('%s min cook','rosalinda-child'), esc_html($recipe['cook'])); ?></span><?php endif; ?>
        <?php if (!empty($recipe['total'])): ?><span class="metric metric-total"><?php printf(esc_html__('%s min total','rosalinda-child'), esc_html($recipe['total'])); ?></span><?php endif; ?>
        <?php if (!empty($recipe['yield'])): ?><span class="metric metric-yield"><?php echo wp_kses_post($recipe['yield']); ?></span><?php endif; ?>
        <?php if (!empty($recipe['nutrition']['kcal'])): ?><span class="metric metric-kcal"><?php printf(esc_html__('%s kcal','rosalinda-child'), esc_html($recipe['nutrition']['kcal'])); ?></span><?php endif; ?>
        <?php if (!empty($recipe['method'])): ?><span class="metric metric-method"><?php echo esc_html($recipe['method']); ?></span><?php endif; ?>
        <?php if (!empty($recipe['diet'])): ?><span class="metric metric-diet"><?php echo esc_html(implode(', ', $recipe['diet'])); ?></span><?php endif; ?>
    </div>
    </header>

    <div class="ad-slot ad-a1 mt-30 mb-30" style="min-height:280px;" aria-hidden="true"></div>

    <div class="post_content post_content_single entry-content">
        <?php the_content(); ?>

        <section class="section-block mt-30">
            <div class="columns_wrap">
                <div class="column-1_2">
                    <div class="c-recipe-grid">
                        <?php if (!empty($recipe['ingredients'])): ?>
                            <section class="recipe-ingredients">
                                <h2 class="h2"><?php esc_html_e('Ingredients', 'rosalinda-child'); ?></h2>
                                <ul class="trx_addons_list">
                                    <?php foreach ($recipe['ingredients'] as $ing): if (trim($ing)==='') continue; ?>
                                        <li><?php echo wp_kses_post($ing); ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </section>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="column-1_2">
                    <?php if (!empty($recipe['steps'])): ?>
                        <section class="recipe-steps">
                            <h2 class="h2"><?php esc_html_e('Instructions', 'rosalinda-child'); ?></h2>
                            <ol class="trx_addons_list trx_addons_list_numbered">
                                <?php foreach ($recipe['steps'] as $i => $s): if (trim($s)==='') continue; ?>
                                    <li><?php echo wp_kses_post($s); ?></li>
                                <?php endforeach; ?>
                            </ol>
                        </section>
                    <?php endif; ?>
                </div>
            </div>
        </section>

    <?php if (!empty($recipe['time_temp'])): ?>
        <section class="section-block mt-30">
            <h2 class="h2"><?php esc_html_e('Time & Temperature', 'rosalinda-child'); ?></h2>
            <table class="sc_table table--compact c-recipe-table">
                <thead><tr><th><?php esc_html_e('Item','rosalinda-child'); ?></th><th><?php esc_html_e('Temp','rosalinda-child'); ?></th><th><?php esc_html_e('Minutes','rosalinda-child'); ?></th></tr></thead>
                <tbody>
                <?php foreach ($recipe['time_temp'] as $tt): ?>
                    <tr>
                        <td><?php echo wp_kses_post($tt['item']); ?></td>
                        <td><?php echo esc_html($tt['temp_c']) ? esc_html($tt['temp_c'].'°C') : esc_html($tt['temp_f'].'°F'); ?></td>
                        <td><?php echo esc_html($tt['minutes']); ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </section>
    <?php endif; ?>

    <div class="ad-slot ad-a2 mt-30 mb-30" style="min-height:150px;" aria-hidden="true"></div>

    <?php if (!empty($recipe['substitutions'])): ?>
        <section class="recipe-substitutions"><h3 class="h3"><?php esc_html_e('Substitutions','rosalinda-child'); ?></h3><p><?php echo wp_kses_post($recipe['substitutions']); ?></p></section>
    <?php endif; ?>
    <?php if (!empty($recipe['storage'])): ?>
        <section class="recipe-storage"><h4><?php esc_html_e('Storage / Reheat','rosalinda-child'); ?></h4><p><?php echo wp_kses_post($recipe['storage']); ?></p></section>
    <?php endif; ?>
    <?php if (!empty($recipe['variations'])): ?>
        <section class="recipe-variations"><h4><?php esc_html_e('Variations / Serving','rosalinda-child'); ?></h4><p><?php echo wp_kses_post($recipe['variations']); ?></p></section>
    <?php endif; ?>

    <?php if (!empty($recipe['tools'])): ?>
        <section class="recipe-tools"><h3 class="h3"><?php esc_html_e('Tools','rosalinda-child'); ?></h3>
            <ul class="trx_addons_list">
            <?php foreach ($recipe['tools'] as $tool): ?>
                <li><a class="theme_button" href="<?php echo esc_url($tool['url']); ?>" target="_blank" rel="noopener noreferrer"><?php echo esc_html($tool['name']); ?></a><?php if (!empty($tool['why'])): ?> <small><?php echo esc_html($tool['why']); ?></small><?php endif; ?></li>
            <?php endforeach; ?>
            </ul>
        </section>
    <?php endif; ?>

    <?php if (!empty($recipe['faqs'])): ?>
        <section class="recipe-faqs">
            <h2 class="h2"><?php esc_html_e('Frequently Asked Questions','rosalinda-child'); ?></h2>
            <?php foreach ($recipe['faqs'] as $faq): ?>
                <div class="faq"><h3 class="h3"><?php echo wp_kses_post($faq['q']); ?></h3><p><?php echo wp_kses_post($faq['a']); ?></p></div>
            <?php endforeach; ?>
        </section>
    <?php endif; ?>

    <div class="ad-slot ad-a3 mt-30 mb-30" style="min-height:120px;" aria-hidden="true"></div>

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

    <?php if (!empty($related['up_link']) || !empty($related['siblings']) || !empty($related['guide'])): ?>
        <section class="recipe-related"><h2 class="h2"><?php esc_html_e('More Recipes','rosalinda-child'); ?></h2>
            <?php if (!empty($related['up_link'])): ?><p><a href="<?php echo esc_url($related['up_link']['url']); ?>"><?php echo esc_html($related['up_link']['title']); ?></a></p><?php endif; ?>
            <?php if (!empty($related['siblings'])): ?><ul class="trx_addons_list"><?php foreach ($related['siblings'] as $s): ?><li><a href="<?php echo esc_url($s['url']); ?>"><?php echo esc_html($s['title']); ?></a></li><?php endforeach; ?></ul><?php endif; ?>
            <?php if (!empty($related['guide'])): ?><p><a href="<?php echo esc_url($related['guide']['url']); ?>"><?php echo esc_html($related['guide']['title']); ?></a></p><?php endif; ?>
        </section>
    <?php endif; ?>

    <div class="ad-slot ad-a4 mt-30 mb-30" style="min-height:90px;" aria-hidden="true"></div>

        <div id="recipe-card"></div>
        <?php child_recipe_schema_min($post_id); ?>

    </div> <!-- .post_content -->

    </div> <!-- .content -->
    </div> <!-- .container -->
</article>