<?php
/**
 * Tools partial
 */
defined('ABSPATH') || exit;
if (empty($args) || empty($args['fields'])) return;
$fields = $args['fields'];
if (empty($fields['tools'])) return;
?>
<section class="recipe-tools">
    <h3 class="h3"><?php esc_html_e('Tools','rosalinda-child'); ?></h3>
    <ul class="trx_addons_list">
    <?php foreach ($fields['tools'] as $tool): ?>
        <li><a class="theme_button" href="<?php echo esc_url($tool['url']); ?>" target="_blank" rel="noopener noreferrer"><?php echo esc_html($tool['name']); ?></a><?php if (!empty($tool['why'])): ?> <small><?php echo esc_html($tool['why']); ?></small><?php endif; ?></li>
    <?php endforeach; ?>
    </ul>
</section>
