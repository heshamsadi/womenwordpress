<?php
/**
 * Print link partial (small helper)
 */
defined('ABSPATH') || exit;
if (empty($args) || empty($args['fields'])) return;
$fields = $args['fields'];
// Simple print link; original inline code not present in templates but provide safe placeholder
?>
<p class="print-recipe"><a href="#" onclick="window.print();return false;" class="theme_button"><?php esc_html_e('Print Recipe','rosalinda-child'); ?></a></p>
