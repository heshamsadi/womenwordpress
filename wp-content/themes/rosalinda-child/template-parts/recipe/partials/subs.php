<?php
/**
 * Substitutions partial
 */
defined('ABSPATH') || exit;
if (empty($args) || empty($args['fields'])) return;
$fields = $args['fields'];
if (empty($fields['substitutions'])) return;
?>
<section class="recipe-substitutions">
    <h3 class="h3"><?php esc_html_e('Substitutions','rosalinda-child'); ?></h3>
    <p><?php echo wp_kses_post($fields['substitutions']); ?></p>
</section>
