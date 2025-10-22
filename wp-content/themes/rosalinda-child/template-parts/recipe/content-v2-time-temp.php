<?php
/**
 * Variant V2 - Time & Temp Quick Answer
 */
defined('ABSPATH') || exit;
$post_id = get_the_ID();
$recipe = child_get_recipe_fields($post_id);
// If no time_temp data, fallback to default
if (empty($recipe['time_temp'])) {
    include get_stylesheet_directory() . '/template-parts/recipe/content.php';
    return;
}
?>
<article id="post-<?php the_ID(); ?>" <?php post_class('post_item_single post_type_' . esc_attr(get_post_type()) . ' recipe-template'); ?>>
    <div class="container">
    <div class="content">
    <section class="v2-intro">
        <h1 class="post_title"><?php the_title(); ?></h1>
        <?php if (!empty($recipe['intro'])): ?><p><?php echo wp_kses_post($recipe['intro']); ?></p><?php endif; ?>
    </section>

    <div class="ad-slot ad-a1 mt-30 mb-30" style="min-height:280px;" aria-hidden="true"></div>

    <section class="v2-time-temp">
        <h2 class="h2"><?php esc_html_e('Time & Temperature Quick Guide','rosalinda-child'); ?></h2>
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

<section class="v2-steps">
    <h3><?php esc_html_e('Quick 3-Step Method','rosalinda-child'); ?></h3>
    <ol>
    <?php
    $steps = array_slice($recipe['steps'], 0, 3);
    foreach ($steps as $i => $s) {
        echo '<li>' . wp_kses_post(trim($s)) . '</li>';
    }
    ?>
    </ol>
</section>

<?php if (!empty($recipe['time_temp'])): ?>
    <div class="v2-doneness">
        <h4><?php esc_html_e('Doneness Cues','rosalinda-child'); ?></h4>
        <ul>
            <?php foreach ($recipe['time_temp'] as $tt) {
                if (!empty($tt['internal_temp'])) {
                    echo '<li>' . esc_html($tt['item'] . ': ' . $tt['internal_temp']) . '</li>';
                }
            } ?>
        </ul>
    </div>
<?php endif; ?>

    <div class="ad-slot ad-a2 mt-30 mb-30" style="min-height:150px;" aria-hidden="true"></div>

<?php if (!empty($recipe['variations'])): ?>
    <section class="v2-variations"><h3><?php esc_html_e('Seasoning Ideas','rosalinda-child'); ?></h3>
        <p><?php echo wp_kses_post($recipe['variations']); ?></p>
    </section>
<?php endif; ?>

<?php if (!empty($recipe['faqs'])): ?><section class="v2-faqs"><h3><?php esc_html_e('FAQ','rosalinda-child'); ?></h3><?php foreach($recipe['faqs'] as $faq){ echo '<h4>'.wp_kses_post($faq['q']).'</h4><p>'.wp_kses_post($faq['a']).'</p>'; } ?></section><?php endif; ?>

    <div class="ad-slot ad-a3 mt-30 mb-30" style="min-height:120px;" aria-hidden="true"></div>

    <?php $related = child_related_min($post_id); if (!empty($related['up_link']) || !empty($related['siblings'])): ?>
        <section class="v2-related"><h2 class="h2"><?php esc_html_e('Related','rosalinda-child'); ?></h2>
            <?php if(!empty($related['up_link'])) echo '<p><a href="'.esc_url($related['up_link']['url']).'">'.esc_html($related['up_link']['title']).'</a></p>'; ?>
        </section>
    <?php endif; ?>

    <div class="ad-slot ad-a4 mt-30 mb-30" style="min-height:90px;" aria-hidden="true"></div>

    <?php child_recipe_schema_min($post_id); ?>

    </div><!-- .content -->
    </div><!-- .container -->
</article>
