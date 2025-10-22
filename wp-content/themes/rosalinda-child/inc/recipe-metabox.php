<?php
/**
 * Recipe Meta Box for WordPress Admin
 * Adds a dedicated recipe fields interface
 * 
 * @package SmartLife Child
 */

defined('ABSPATH') || exit;

/**
 * Add recipe meta box to post editor
 */
add_action('add_meta_boxes', 'child_add_recipe_meta_box');

function child_add_recipe_meta_box() {
    add_meta_box(
        'recipe-fields',
        'Recipe Information',
        'child_recipe_meta_box_callback',
        'post',
        'normal',
        'high'
    );
}

/**
 * Recipe meta box HTML
 */
function child_recipe_meta_box_callback($post) {
    // Add nonce for security
    wp_nonce_field('child_recipe_meta_box', 'child_recipe_meta_box_nonce');
    
    // Get existing values
    $prep = get_post_meta($post->ID, 'recipe_prep', true);
    $cook = get_post_meta($post->ID, 'recipe_cook', true);
    $total = get_post_meta($post->ID, 'recipe_total', true);
    $yield = get_post_meta($post->ID, 'recipe_yield', true);
    $method = get_post_meta($post->ID, 'recipe_method', true);
    $intro = get_post_meta($post->ID, 'recipe_intro_short', true);
    $ingredients = get_post_meta($post->ID, 'recipe_ingredients', true);
    $steps = get_post_meta($post->ID, 'recipe_steps', true);
    $nutrition = get_post_meta($post->ID, 'recipe_nutrition', true);
    $diet = get_post_meta($post->ID, 'recipe_diet', true);
    // Current template variant (hidden meta). Defaults to u1 if unset.
    $template_variant = get_post_meta($post->ID, '_template_variant', true) ?: 'u1';
    
    echo '<style>
        .recipe-meta-table { width: 100%; border-collapse: collapse; }
        .recipe-meta-table td { padding: 8px; vertical-align: top; }
        .recipe-meta-table input[type="text"], .recipe-meta-table input[type="number"] { width: 100%; }
        .recipe-meta-table textarea { width: 100%; min-height: 80px; }
        .recipe-meta-section { margin: 20px 0; padding: 15px; background: #f9f9f9; border-left: 4px solid #0073aa; }
        .recipe-meta-section h4 { margin-top: 0; color: #0073aa; }
    </style>';
    
    echo '<div class="recipe-meta-section">';
    echo '<h4>Basic Information</h4>';
    echo '<table class="recipe-meta-table">';
    echo '<tr><td><label>Short Description:</label></td><td><input type="text" name="recipe_intro_short" value="' . esc_attr($intro) . '" placeholder="Quick and delicious pasta dish..."></td></tr>';
    echo '<tr><td><label>Prep Time (minutes):</label></td><td><input type="number" name="recipe_prep" value="' . esc_attr($prep) . '" placeholder="15"></td></tr>';
    echo '<tr><td><label>Cook Time (minutes):</label></td><td><input type="number" name="recipe_cook" value="' . esc_attr($cook) . '" placeholder="20"></td></tr>';
    echo '<tr><td><label>Total Time (minutes):</label></td><td><input type="number" name="recipe_total" value="' . esc_attr($total) . '" placeholder="35"></td></tr>';
    echo '<tr><td><label>Servings/Yield:</label></td><td><input type="text" name="recipe_yield" value="' . esc_attr($yield) . '" placeholder="4 servings"></td></tr>';
    echo '<tr><td><label>Cooking Method:</label></td><td><input type="text" name="recipe_method" value="' . esc_attr($method) . '" placeholder="Stovetop"></td></tr>';
    echo '</table>';
    echo '</div>';
    
    echo '<div class="recipe-meta-section">';
    echo '<h4>Ingredients & Instructions</h4>';
    echo '<table class="recipe-meta-table">';
    echo '<tr><td style="width:50%;"><label>Ingredients (one per line):</label><br><textarea name="recipe_ingredients" placeholder="2 cups pasta&#10;1 tbsp olive oil&#10;3 cloves garlic">' . esc_textarea($ingredients) . '</textarea></td>';
    echo '<td><label>Instructions (one step per line):</label><br><textarea name="recipe_steps" placeholder="Cook pasta according to directions&#10;Heat oil in large pan&#10;Add garlic and cook 1 minute">' . esc_textarea($steps) . '</textarea></td></tr>';
    echo '</table>';
    echo '</div>';
    
    echo '<div class="recipe-meta-section">';
    echo '<h4>Nutrition & Diet</h4>';
    echo '<table class="recipe-meta-table">';
    echo '<tr><td><label>Nutrition (format: calories|protein|carbs|fat):</label></td><td><input type="text" name="recipe_nutrition" value="' . esc_attr($nutrition) . '" placeholder="350|12|45|8"></td></tr>';
    echo '<tr><td><label>Diet Tags (comma-separated):</label></td><td><input type="text" name="recipe_diet" value="' . esc_attr($diet) . '" placeholder="vegetarian, quick, healthy"></td></tr>';
    echo '</table>';
    echo '</div>';

    // Show template variant selector only for posts in the Cooking hub (by slug or ancestor name)
    $show_variant = false;
    $terms = get_the_terms($post->ID, 'category');
    if (!empty($terms) && !is_wp_error($terms)) {
        foreach ($terms as $t) {
            if (in_array(strtolower($t->slug), array('cooking')) || strtolower($t->name) === 'cooking') {
                $show_variant = true;
                break;
            }
            // check ancestors for a parent named Cooking
            $anc = get_ancestors($t->term_id, 'category');
            foreach ($anc as $aid) {
                $at = get_category($aid);
                if ($at && (strtolower($at->slug) === 'cooking' || strtolower($at->name) === 'cooking')) {
                    $show_variant = true;
                    break 2;
                }
            }
        }
    }

    if ($show_variant) {
        echo '<div class="recipe-meta-section">';
        echo '<h4>Template Variant</h4>';
        echo '<p>Select the recipe layout variant for this post. Default is <strong>Classic (u1)</strong>.</p>';
        echo '<select name="_template_variant">';
        $options = array(
            'u1' => 'Classic (U1) — full recipe',
            'v2' => 'Time & Temp (V2) — quick answer',
            'v3' => 'Five-Ingredient (V3) — short ingredient list',
            'v5' => 'How-To (V5) — technique / no-ingredients'
        );
        foreach ($options as $k => $label) {
            $sel = selected($template_variant, $k, false);
            echo '<option value="' . esc_attr($k) . '" ' . $sel . '>' . esc_html($label) . '</option>';
        }
        echo '</select>';
        echo '</div>';
    }

    echo '<p><strong>Note:</strong> This post will use the recipe template because it\'s in a Cooking category. Fill in any fields you want to display.</p>';
}

/**
 * Save recipe meta box data
 */
add_action('save_post', 'child_save_recipe_meta_box_data');

function child_save_recipe_meta_box_data($post_id) {
    // Check if nonce is valid
    if (!isset($_POST['child_recipe_meta_box_nonce']) || !wp_verify_nonce($_POST['child_recipe_meta_box_nonce'], 'child_recipe_meta_box')) {
        return;
    }
    
    // Check if user has permissions
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }
    
    // Don't save on autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    
    // Save recipe fields
    $fields = [
        'recipe_intro_short',
        'recipe_prep',
        'recipe_cook',
        'recipe_total',
        'recipe_yield',
        'recipe_method',
        'recipe_ingredients',
        'recipe_steps',
        'recipe_nutrition',
        'recipe_diet'
    ];
    
    foreach ($fields as $field) {
        if (isset($_POST[$field])) {
            update_post_meta($post_id, $field, sanitize_textarea_field($_POST[$field]));
        }
    }

    // Save template variant if provided. Only allow known values to avoid misuse.
    if (isset($_POST['_template_variant'])) {
        $allowed = array('u1','v2','v3','v5');
        $val = sanitize_text_field($_POST['_template_variant']);
        if (!in_array($val, $allowed, true)) {
            $val = 'u1';
        }
        update_post_meta($post_id, '_template_variant', $val);
    }
}