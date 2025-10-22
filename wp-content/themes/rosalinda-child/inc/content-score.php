<?php
/**
 * Content scoring and admin column
 */
defined('ABSPATH') || exit;

if (!function_exists('child_content_score')) {
    function child_content_score($post_id) {
        $post_id = (int)$post_id;
        $fields = function_exists('child_get_recipe_fields') ? child_get_recipe_fields($post_id) : array();

        // Define weights (sum to 100)
        $weights = array(
            'method' => 10,
            'time' => 10,       // prep/cook/total presence
            'time_temp' => 10,
            'instructions' => 25,
            'storage' => 5,
            'substitutions' => 5,
            'nutrition' => 10,
            'faqs' => 15,      // >=3 FAQs
            'schema' => 10,
        );

        $score = 0;
        // method
        if (!empty($fields['method'])) $score += $weights['method'];
        // time: any of prep/cook/total
        if (!empty($fields['prep']) || !empty($fields['cook']) || !empty($fields['total'])) $score += $weights['time'];
        // time_temp
        if (!empty($fields['time_temp'])) $score += $weights['time_temp'];
        // instructions/steps
        if (!empty($fields['steps']) && count($fields['steps']) > 0) $score += $weights['instructions'];
        // storage
        if (!empty($fields['storage'])) $score += $weights['storage'];
        // substitutions
        if (!empty($fields['substitutions'])) $score += $weights['substitutions'];
        // nutrition (kcal present)
        if (!empty($fields['nutrition']) && !empty($fields['nutrition']['kcal'])) $score += $weights['nutrition'];
        // faqs >= 3
        if (!empty($fields['faqs']) && count($fields['faqs']) >= 3) $score += $weights['faqs'];

        // schema presence: use child_recipe_schema_min output buffer
        $schema_present = false;
        if (function_exists('child_recipe_schema_min')) {
            ob_start();
            child_recipe_schema_min($post_id);
            $schema_out = ob_get_clean();
            if (!empty(trim($schema_out))) $schema_present = true;
        }
        if ($schema_present) $score += $weights['schema'];

        // Clamp and return int
        $score = max(0, min(100, (int)$score));
        return $score;
    }
}

// Admin column: add score
add_filter('manage_post_posts_columns', function($cols){ $cols['content_score'] = 'Content Score'; return $cols; });
add_action('manage_post_posts_custom_column', function($column, $post_id){
    if ($column !== 'content_score') return;
    $score = child_content_score($post_id);
    $color = $score >= 80 ? '#2ecc71' : ($score >= 60 ? '#f39c12' : '#e74c3c');
    $edit_link = esc_url(get_edit_post_link($post_id)) . '#content-checklist';
    // Simple accessible badge
    echo '<a href="' . $edit_link . '" style="display:inline-block;padding:4px 8px;border-radius:4px;background:' . esc_attr($color) . ';color:#fff;text-decoration:none;font-weight:600;">' . esc_html($score) . '</a>';
    // Small helper tooltip
    echo ' <a href="' . esc_url($edit_link) . '" style="font-size:11px;color:#666;">Checklist</a>';
}, 10, 2);

// Add a lightweight admin meta box with the checklist
add_action('add_meta_boxes', function() {
    add_meta_box('child_content_checklist', __('Content Checklist', 'rosalinda-child'), function($post){
        $post_id = $post->ID;
        $score = child_content_score($post_id);
        $fields = function_exists('child_get_recipe_fields') ? child_get_recipe_fields($post_id) : array();
        $items = array(
            'method' => 'Method / Technique',
            'time' => 'Prep / Cook / Total time',
            'time_temp' => 'Time & Temperature table',
            'instructions' => 'Full instructions / steps',
            'storage' => 'Storage / reheating notes',
            'substitutions' => 'Substitutions / swaps',
            'nutrition' => 'Nutrition (calories present)',
            'faqs' => 'At least 3 FAQs',
            'schema' => 'Structured data (Recipe/HowTo/FAQ)'
        );

        echo '<div id="content-checklist" style="padding:8px 0">';
        echo '<p><strong>' . esc_html__('Content Score: ', 'rosalinda-child') . '</strong>' . esc_html($score) . '</p>';
        echo '<ul style="margin:0; padding-left:18px;">';
        foreach ($items as $k => $label) {
            $ok = false;
            switch ($k) {
                case 'method': $ok = !empty($fields['method']); break;
                case 'time': $ok = !empty($fields['prep']) || !empty($fields['cook']) || !empty($fields['total']); break;
                case 'time_temp': $ok = !empty($fields['time_temp']); break;
                case 'instructions': $ok = !empty($fields['steps']); break;
                case 'storage': $ok = !empty($fields['storage']); break;
                case 'substitutions': $ok = !empty($fields['substitutions']); break;
                case 'nutrition': $ok = !empty($fields['nutrition']) && !empty($fields['nutrition']['kcal']); break;
                case 'faqs': $ok = !empty($fields['faqs']) && count($fields['faqs']) >= 3; break;
                case 'schema':
                    ob_start(); child_recipe_schema_min($post_id); $so = ob_get_clean(); $ok = !empty(trim($so));
                    break;
            }
            echo '<li style="margin:6px 0;">' . ($ok ? '✅ ' : '⬜ ') . esc_html($label) . '</li>';
        }
        echo '</ul>';
        echo '<p style="margin-top:8px;font-size:12px;color:#666;">' . esc_html__('Click the Content Score in the posts list to jump here and review missing items.', 'rosalinda-child') . '</p>';
        echo '</div>';
    }, 'post', 'side', 'high');
});

// Meta box to select Ad Layout (A or B)
add_action('add_meta_boxes', function() {
    add_meta_box('child_ad_layout', __('Ad Layout (A/B)', 'rosalinda-child'), function($post){
        $value = get_post_meta($post->ID, 'ad_layout', true) ?: 'A';
        ?>
        <label><input type="radio" name="ad_layout" value="A" <?php checked($value, 'A'); ?> /> A — standard (A1, A2, A3, A4)</label><br/>
        <label><input type="radio" name="ad_layout" value="B" <?php checked($value, 'B'); ?> /> B — alternate (A1, A2, A2.5, A3, A4)</label>
        <?php
    }, 'post', 'side', 'core');
});

// Save ad_layout
add_action('save_post', function($post_id, $post, $update) {
    if ($post->post_type !== 'post') return;
    if (wp_is_post_autosave($post_id) || wp_is_post_revision($post_id)) return;
    if (isset($_POST['ad_layout'])) {
        $v = sanitize_text_field($_POST['ad_layout']);
        update_post_meta($post_id, 'ad_layout', in_array(strtoupper($v), array('A','B')) ? strtoupper($v) : 'A');
    }
}, 20, 3);

// Register ad_layout in REST
add_action('rest_api_init', function() {
    register_rest_field('post', 'ad_layout', [
        'get_callback' => function($post_array) { return get_post_meta($post_array['id'], 'ad_layout', true); },
        'update_callback' => function($value, $post) { return update_post_meta($post->ID, 'ad_layout', sanitize_text_field($value)); },
        'schema' => [ 'description' => 'Per-post ad layout (A or B)', 'type' => 'string' ],
    ]);
});
