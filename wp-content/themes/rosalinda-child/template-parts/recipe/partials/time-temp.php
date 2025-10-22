<?php
/**
 * Time & Temperature partial
 */
defined('ABSPATH') || exit;
if (empty($args) || empty($args['fields'])) return;
$fields = $args['fields'];
if (empty($fields['time_temp'])) return;
?>
<section class="section-block mt-30">
    <h2 class="h2"><?php esc_html_e('Time & Temperature', 'rosalinda-child'); ?></h2>
    <table class="sc_table table--compact c-recipe-table">
        <thead><tr><th><?php esc_html_e('Item','rosalinda-child'); ?></th><th><?php esc_html_e('Temp','rosalinda-child'); ?></th><th><?php esc_html_e('Minutes','rosalinda-child'); ?></th></tr></thead>
        <tbody>
        <?php foreach ($fields['time_temp'] as $tt): ?>
            <tr>
                <td><?php echo wp_kses_post($tt['item']); ?></td>
                <td><?php echo esc_html($tt['temp_c']) ? esc_html($tt['temp_c'].'°C') : esc_html($tt['temp_f'].'°F'); ?></td>
                <td><?php echo esc_html($tt['minutes']); ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</section>
