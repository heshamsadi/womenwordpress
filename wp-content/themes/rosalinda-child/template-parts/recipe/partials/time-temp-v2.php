<?php
/**
 * Time & Temperature partial for V2 (preserves V2 heading)
 */
defined('ABSPATH') || exit;
if (empty($args) || empty($args['fields'])) return;
$fields = $args['fields'];
if (empty($fields['time_temp'])) return;
?>
<section class="v2-time-temp">
    <h2 class="h2 sc_item_title"><?php esc_html_e('Time & Temperature Quick Guide','rosalinda-child'); ?></h2>
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
<?php if (!empty($fields['time_temp'])): ?>
    <div class="v2-doneness">
        <h4><?php esc_html_e('Doneness Cues','rosalinda-child'); ?></h4>
        <ul>
            <?php foreach ($fields['time_temp'] as $tt) {
                if (!empty($tt['internal_temp'])) {
                    echo '<li>' . esc_html($tt['item'] . ': ' . $tt['internal_temp']) . '</li>';
                }
            } ?>
        </ul>
    </div>
<?php endif; ?>
