<?php
/**
 * Ingredients partial
 * Expects $args['fields'] to be present and use the same escaping as the inline version.
 */
defined('ABSPATH') || exit;
if (empty($args) || empty($args['fields'])) return;
$fields = $args['fields'];
if (empty($fields['ingredients'])) return;
?>
<section class="recipe-ingredients">
    <h2 class="h2 sc_item_title"><?php esc_html_e('Ingredients', 'rosalinda-child'); ?></h2>
    <ul class="trx_addons_list">
        <?php foreach ($fields['ingredients'] as $ing): if (trim($ing)==='') continue; ?>
            <li><?php echo wp_kses_post($ing); ?></li>
        <?php endforeach; ?>
    </ul>
</section>
