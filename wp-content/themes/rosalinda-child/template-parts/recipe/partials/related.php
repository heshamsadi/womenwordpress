<?php
/**
 * Related partial
 * Expects $args['fields'] or can call child_related_min() itself if needed.
 */
defined('ABSPATH') || exit;
if (empty($args)) return;
$fields = $args['fields'] ?? null;
$related = isset($args['related']) ? $args['related'] : (function_exists('child_related_min') ? child_related_min(get_the_ID()) : array());
if (empty($related['up_link']) && empty($related['siblings']) && empty($related['guide'])) return;
?>
<section class="recipe-related">
    <h2 class="h2"><?php esc_html_e('More Recipes','rosalinda-child'); ?></h2>
    <?php if (!empty($related['up_link'])): ?><p><a href="<?php echo esc_url($related['up_link']['url']); ?>"><?php echo esc_html($related['up_link']['title']); ?></a></p><?php endif; ?>
    <?php if (!empty($related['siblings'])): ?><ul class="trx_addons_list"><?php foreach ($related['siblings'] as $s): ?><li><a href="<?php echo esc_url($s['url']); ?>"><?php echo esc_html($s['title']); ?></a></li><?php endforeach; ?></ul><?php endif; ?>
    <?php if (!empty($related['guide'])): ?><p><a href="<?php echo esc_url($related['guide']['url']); ?>"><?php echo esc_html($related['guide']['title']); ?></a></p><?php endif; ?>
</section>
