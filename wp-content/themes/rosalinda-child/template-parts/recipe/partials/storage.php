<?php
/**
 * Storage partial
 */
defined('ABSPATH') || exit;
if (empty($args) || empty($args['fields'])) return;
$fields = $args['fields'];
if (empty($fields['storage'])) return;
?>
<section class="recipe-storage">
    <h4><?php esc_html_e('Storage / Reheat','rosalinda-child'); ?></h4>
    <p><?php echo wp_kses_post($fields['storage']); ?></p>
</section>
