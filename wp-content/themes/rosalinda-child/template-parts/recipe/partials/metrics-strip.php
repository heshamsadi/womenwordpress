<?php
/**
 * Metrics strip partial for recipes — uses parent classes and icons
 */
defined('ABSPATH') || exit;
if (empty($args) || empty($args['fields'])) {
    // fallback to old behavior for backwards compatibility
    $recipe = child_get_recipe_fields(get_the_ID());
} else {
    $recipe = $args['fields'];
}
// times array may have total/prep/cook
$times = isset($recipe['total']) ? array('total' => $recipe['total']) : (isset($recipe['time_temp']) ? array('total' => '') : array());
?>
<div class="c-recipe-metrics trx_addons_list">
    <?php if (!empty($recipe['total'])): ?>
        <span class="metric"><?php child_icon('clock'); ?> <?php echo esc_html($recipe['total']); ?> <?php esc_html_e('min','rosalinda-child'); ?></span>
    <?php endif; ?>
    <?php if (!empty($recipe['yield'])): ?>
        <span class="metric"><?php child_icon('servings'); ?> <?php echo esc_html($recipe['yield']); ?></span>
    <?php endif; ?>
    <?php if (!empty($recipe['nutrition']['kcal'])): ?>
        <span class="metric"><?php child_icon('fire'); ?> <?php echo esc_html($recipe['nutrition']['kcal']); ?> <?php esc_html_e('kcal','rosalinda-child'); ?></span>
    <?php endif; ?>
    <?php if (!empty($recipe['method'])): ?>
        <span class="metric"><?php child_icon('pan'); ?> <?php echo esc_html(ucwords(str_replace('_',' ',$recipe['method']))); ?></span>
    <?php endif; ?>

    <?php if (!empty($recipe['diet'])): ?>
        <div class="sc_item_tags">
            <?php foreach ((array)$recipe['diet'] as $d): ?>
                <span class="sc_item_tags_item"><?php echo esc_html(ucwords(str_replace('_',' ',$d))); ?></span>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>
