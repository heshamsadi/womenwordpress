<?php
/**
 * Steps partial
 */
defined('ABSPATH') || exit;
if (empty($args) || empty($args['fields'])) return;
$fields = $args['fields'];
if (empty($fields['steps'])) return;
?>
<section class="recipe-steps">
    <h2 class="h2 sc_item_title"><?php esc_html_e('Instructions', 'rosalinda-child'); ?></h2>
    <ol class="trx_addons_list trx_addons_list_numbered">
        <?php foreach ($fields['steps'] as $i => $s): if (trim($s)==='') continue; ?>
            <li><?php echo wp_kses_post($s); ?></li>
        <?php endforeach; ?>
    </ol>
</section>
