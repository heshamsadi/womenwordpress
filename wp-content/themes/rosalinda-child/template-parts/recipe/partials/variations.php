<?php
/**
 * Variations partial
 */
defined('ABSPATH') || exit;
if (empty($args) || empty($args['fields'])) return;
$fields = $args['fields'];
if (empty($fields['variations'])) return;
?>
<section class="recipe-variations">
    <h4><?php esc_html_e('Variations / Serving','rosalinda-child'); ?></h4>
    <p><?php echo wp_kses_post($fields['variations']); ?></p>
</section>
