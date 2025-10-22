<?php
/**
 * FAQ partial
 */
defined('ABSPATH') || exit;
if (empty($args) || empty($args['fields'])) return;
$fields = $args['fields'];
if (empty($fields['faqs'])) return;
?>
<section class="recipe-faqs">
    <h2 class="h2"><?php esc_html_e('Frequently Asked Questions','rosalinda-child'); ?></h2>
    <?php foreach ($fields['faqs'] as $faq): ?>
        <div class="faq"><h3 class="h3"><?php echo wp_kses_post($faq['q']); ?></h3><p><?php echo wp_kses_post($faq['a']); ?></p></div>
    <?php endforeach; ?>
</section>
