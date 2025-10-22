<?php
/**
 * Admin UI for term meta used by hubs: featured_posts, chips_override
 */
defined('ABSPATH') || exit;

add_action('category_add_form_fields', 'rosalinda_termmeta_add_fields', 10, 2);
add_action('category_edit_form_fields', 'rosalinda_termmeta_edit_fields', 10, 2);
add_action('created_category', 'rosalinda_termmeta_save', 10, 2);
add_action('edited_category', 'rosalinda_termmeta_save', 10, 2);

function rosalinda_termmeta_add_fields($taxonomy) {
    ?>
    <div class="form-field term-featured-posts-wrap">
        <label for="featured_posts"><?php esc_html_e('Featured posts (comma-separated IDs)', 'rosalinda-child'); ?></label>
        <input name="featured_posts" id="featured_posts" type="text" value="" />
        <p class="description"><?php esc_html_e('Optional: comma-separated post IDs to pin in this hub (max 6).', 'rosalinda-child'); ?></p>
    </div>
    <div class="form-field term-chips-override-wrap">
        <label for="chips_override"><?php esc_html_e('Chips override (k=v,k2=v2)', 'rosalinda-child'); ?></label>
        <input name="chips_override" id="chips_override" type="text" value="" />
        <p class="description"><?php esc_html_e('Optional: override discovered chips, format: protein=chicken,time=15,diet=vegan', 'rosalinda-child'); ?></p>
    </div>
    <?php
}

function rosalinda_termmeta_edit_fields($term) {
    $featured = get_term_meta($term->term_id, 'featured_posts', true);
    $chips = get_term_meta($term->term_id, 'chips_override', true);
    ?>
    <tr class="form-field term-featured-posts-wrap">
        <th scope="row"><label for="featured_posts"><?php esc_html_e('Featured posts', 'rosalinda-child'); ?></label></th>
        <td>
            <input name="featured_posts" id="featured_posts" type="text" value="<?php echo esc_attr(is_array($featured) ? implode(',', $featured) : $featured); ?>" />
            <p class="description"><?php esc_html_e('Comma-separated post IDs to pin in this hub (max 6).', 'rosalinda-child'); ?></p>
        </td>
    </tr>
    <tr class="form-field term-chips-override-wrap">
        <th scope="row"><label for="chips_override"><?php esc_html_e('Chips override', 'rosalinda-child'); ?></label></th>
        <td>
            <input name="chips_override" id="chips_override" type="text" value="<?php echo esc_attr($chips); ?>" />
            <p class="description"><?php esc_html_e('Override discovered chips, format: protein=chicken,time=15,diet=vegan', 'rosalinda-child'); ?></p>
        </td>
    </tr>
    <?php
}

function rosalinda_termmeta_save($term_id) {
    if (isset($_POST['featured_posts'])) {
        $raw = sanitize_text_field(wp_unslash($_POST['featured_posts']));
        $ids = array_filter(array_map('absint', array_map('trim', explode(',', $raw))));
        if (!empty($ids)) {
            update_term_meta($term_id, 'featured_posts', array_slice($ids,0,6));
        } else {
            delete_term_meta($term_id, 'featured_posts');
        }
    }
    if (isset($_POST['chips_override'])) {
        $raw = sanitize_text_field(wp_unslash($_POST['chips_override']));
        if (!empty($raw)) update_term_meta($term_id, 'chips_override', $raw); else delete_term_meta($term_id, 'chips_override');
    }
}
