<?php
/**
 * Unified Recipe Meta Box
 * Replaces both "Recipe Details" and hides plugin "Item Options"
 * Contains ALL fields used on the recipe template
 */

// Remove ThemeREX "Item Options" meta box (we'll use our own)
add_action('add_meta_boxes', 'rosalinda_child_remove_trx_meta_box', 999);
function rosalinda_child_remove_trx_meta_box() {
    remove_meta_box('trx_addons_meta_box', 'cpt_dishes', 'advanced');
}

// Register our unified meta box
add_action('add_meta_boxes', 'rosalinda_child_add_recipe_meta_box');
function rosalinda_child_add_recipe_meta_box() {
    add_meta_box(
        'rc_recipe_meta',
        'Recipe Information',
        'rosalinda_child_recipe_meta_callback',
        'cpt_dishes',
        'normal',
        'high' // High priority to show at top
    );
}

// Display meta box with all fields
function rosalinda_child_recipe_meta_callback($post) {
    // Add nonce for security
    wp_nonce_field('rosalinda_child_recipe_meta_box', 'rosalinda_child_recipe_meta_nonce');
    
    // Get existing meta data
    $meta = get_post_meta($post->ID, 'trx_addons_options', true);
    if (!is_array($meta)) {
        $meta = array();
    }
    
    // Organized field groups
    $field_groups = array(
        'Basic Info' => array(
            'cuisine'       => 'Cuisine (e.g., Italian, Mexican, American)',
            'course'        => 'Course (e.g., Appetizer, Main Course, Dessert)',
            'difficulty'    => 'Difficulty (e.g., Easy, Medium, Hard)',
        ),
        'Timing' => array(
            'prep_time'     => 'Prep Time (minutes)',
            'cook_time'     => 'Cook Time (minutes - if empty, uses "time" field)',
            'time'          => 'Cook Time (alternative field name)',
        ),
        'Servings & Nutrition' => array(
            'servings'      => 'Servings (e.g., 4, 24 cookies)',
            'calories'      => 'Calories (per serving)',
            'dietary_tags'  => 'Dietary Tags (comma separated, e.g., Vegan, Gluten-Free)',
        ),
        'Details' => array(
            'ingredients'   => 'Ingredients (one per line)',
            'nutritions'    => 'Nutrition Info (one per line, e.g., "Protein: 25g")',
        ),
        'Additional Options' => array(
            'spicy'         => 'Spicy Level (1-5, shows as 🔥 icons)',
            'price'         => 'Price (optional, e.g., $12.99)',
        ),
    );

    echo '<style>
        .rc-meta-group { margin: 20px 0; border-top: 1px solid #ddd; padding-top: 15px; }
        .rc-meta-group:first-child { border-top: none; margin-top: 0; }
        .rc-meta-group-title { font-size: 14px; font-weight: 600; color: #1d2327; margin: 0 0 10px 0; }
        .rc-meta-table { width: 100%; }
        .rc-meta-table th { width: 25%; padding: 10px 0; text-align: left; font-weight: 500; }
        .rc-meta-table td { padding: 10px 0; }
        .rc-meta-table input[type="text"],
        .rc-meta-table input[type="number"],
        .rc-meta-table textarea { width: 100%; }
        .rc-meta-table textarea { min-height: 100px; font-family: monospace; }
        .rc-meta-help { font-size: 12px; color: #646970; font-style: italic; margin-top: 3px; }
    </style>';

    foreach ($field_groups as $group_title => $fields) {
        echo '<div class="rc-meta-group">';
        echo '<h3 class="rc-meta-group-title">' . esc_html($group_title) . '</h3>';
        echo '<table class="rc-meta-table">';
        
        foreach ($fields as $key => $label) {
            $val = isset($meta[$key]) ? $meta[$key] : '';
            echo '<tr>';
            echo '<th><label for="rc_' . esc_attr($key) . '">' . esc_html($label) . '</label></th>';
            echo '<td>';
            
            // Textarea fields
            if ($key === 'ingredients' || $key === 'nutritions') {
                echo '<textarea id="rc_' . esc_attr($key) . '" name="trx_addons_options[' . esc_attr($key) . ']">' . esc_textarea($val) . '</textarea>';
                
                if ($key === 'ingredients') {
                    echo '<div class="rc-meta-help">Example:<br>2 cups flour<br>1 cup sugar<br>3 eggs</div>';
                } elseif ($key === 'nutritions') {
                    echo '<div class="rc-meta-help">Example:<br>Protein: 25g<br>Carbs: 30g<br>Fat: 10g</div>';
                }
            }
            // Number fields
            elseif (in_array($key, array('prep_time', 'cook_time', 'time', 'calories', 'spicy'))) {
                echo '<input type="number" id="rc_' . esc_attr($key) . '" name="trx_addons_options[' . esc_attr($key) . ']" value="' . esc_attr($val) . '" min="0" />';
                
                if ($key === 'spicy') {
                    echo '<div class="rc-meta-help">Enter 1-5 (displays as fire icons 🔥)</div>';
                }
            }
            // Text fields
            else {
                echo '<input type="text" id="rc_' . esc_attr($key) . '" name="trx_addons_options[' . esc_attr($key) . ']" value="' . esc_attr($val) . '" />';
                
                if ($key === 'dietary_tags') {
                    echo '<div class="rc-meta-help">Separate with commas: Vegetarian, Nut-Free, Dairy-Free</div>';
                }
            }
            
            echo '</td>';
            echo '</tr>';
        }
        
        echo '</table>';
        echo '</div>';
    }
    
    // Note about required fields
    echo '<div class="rc-meta-group" style="background: #f0f6fc; padding: 10px; border-radius: 4px;">';
    echo '<p style="margin: 0;"><strong>📝 Required for Google Rich Results:</strong> Title, Featured Image, Ingredients, and at least one time field (prep_time, cook_time, or time)</p>';
    echo '</div>';
}

// Save meta box data
add_action('save_post_cpt_dishes', 'rosalinda_child_save_recipe_meta', 10, 2);
function rosalinda_child_save_recipe_meta($post_id, $post) {
    // Check if nonce is set
    if (!isset($_POST['rosalinda_child_recipe_meta_nonce'])) {
        return;
    }
    
    // Verify nonce
    if (!wp_verify_nonce($_POST['rosalinda_child_recipe_meta_nonce'], 'rosalinda_child_recipe_meta_box')) {
        return;
    }
    
    // If this is an autosave, don't do anything
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    
    // Check user permissions
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }
    
    // Save the data
    if (isset($_POST['trx_addons_options']) && is_array($_POST['trx_addons_options'])) {
        $clean = array();
        foreach ($_POST['trx_addons_options'] as $key => $value) {
            $clean[$key] = sanitize_textarea_field($value);
        }
        update_post_meta($post_id, 'trx_addons_options', $clean);
    }
}
