<?php
/**
 * Recipe Meta Box
 * Provides simple fields for Ingredients, Times, Servings, Calories, and Dietary tags.
 */
add_action('add_meta_boxes', function () {
    add_meta_box(
        'rc_recipe_meta',
        'Recipe Details',
        'rc_recipe_meta_callback',
        'cpt_dishes',
        'normal',
        'default'
    );
});

function rc_recipe_meta_callback($post) {
    $meta = get_post_meta($post->ID, 'trx_addons_options', true) ?: [];
    $fields = [
        'ingredients'   => 'Ingredients (one per line)',
        'prep_time'     => 'Prep Time (minutes)',
        'cook_time'     => 'Cook Time (minutes)',
        'servings'      => 'Servings',
        'calories'      => 'Calories',
        'dietary_tags'  => 'Dietary Tags (comma separated)',
        'nutritions'    => 'Nutrition Info (optional, one per line)',
    ];

    echo '<table class="form-table">';
    foreach ($fields as $key => $label) {
        $val = isset($meta[$key]) ? esc_textarea($meta[$key]) : '';
        echo '<tr><th><label for="'.$key.'">'.$label.'</label></th><td>';
        if ($key === 'ingredients' || $key === 'nutritions') {
            echo '<textarea style="width:100%;min-height:80px" name="trx_addons_options['.$key.']">'.$val.'</textarea>';
        } else {
            echo '<input type="text" style="width:100%" name="trx_addons_options['.$key.']" value="'.$val.'" />';
        }
        echo '</td></tr>';
    }
    echo '</table>';
}

// Save meta
add_action('save_post_cpt_dishes', function ($post_id) {
    if (isset($_POST['trx_addons_options']) && is_array($_POST['trx_addons_options'])) {
        $clean = [];
        foreach ($_POST['trx_addons_options'] as $k => $v) {
            $clean[$k] = sanitize_textarea_field($v);
        }
        update_post_meta($post_id, 'trx_addons_options', $clean);
    }
});
