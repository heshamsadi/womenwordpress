<?php
/**
 * WP-CLI CSV importer for recipes
 * Usage: wp cook:import --file=/path/to/posts.csv [--dry-run]
 */
defined('ABSPATH') || exit;

if (!defined('WP_CLI') || !WP_CLI) {
    return;
}

class Cook_Import_Command {

    public function import($args, $assoc_args) {
        $file = isset($assoc_args['file']) ? $assoc_args['file'] : (isset($assoc_args[0]) ? $assoc_args[0] : '');
        $dry = !empty($assoc_args['dry-run']) || !empty($assoc_args['dry_run']) || !empty($assoc_args['dry']);

        if (empty($file) || !file_exists($file)) {
            WP_CLI::error("CSV file not found: {$file}");
            return;
        }

        $handle = fopen($file, 'r');
        if (!$handle) {
            WP_CLI::error("Unable to open file: {$file}");
            return;
        }

        $header = null;
        $row_num = 0;
        $created = 0; $updated = 0; $skipped = 0; $errors = 0;

        while (($row = fgetcsv($handle)) !== false) {
            $row_num++;
            if ($row_num === 1) { $header = $row; continue; }
            if (!$header) continue;
            $data = array_combine($header, $row);
            if (!$data) {
                WP_CLI::warning("Row {$row_num}: invalid CSV format"); $errors++; continue;
            }

            // Map expected fields
            $slug = sanitize_title($data['slug'] ?: $data['title']);
            if (empty($slug)) { WP_CLI::warning("Row {$row_num}: missing slug/title"); $errors++; continue; }

            // Find existing post by slug
            $existing = get_page_by_path($slug, OBJECT, 'post');
            $post_arr = array(
                'post_title' => wp_strip_all_tags($data['title']),
                'post_name' => $slug,
                'post_status' => 'publish',
                'post_type' => 'post',
                'post_content' => '',
            );

            // Categories: l1/l2/l3 under Cooking
            $cooking_cat = get_category_by_slug('cooking');
            if (!$cooking_cat) {
                // create top-level cooking category if missing
                $cooking_cat_id = wp_create_category('Cooking');
                $cooking_cat = get_category($cooking_cat_id);
            }
            $cat_ids = array();
            foreach (array('l1','l2','l3') as $lvl) {
                if (empty($data[$lvl])) continue;
                $name = sanitize_text_field($data[$lvl]);
                $slug_cat = sanitize_title($name);
                $term = get_term_by('slug', $slug_cat, 'category');
                if (!$term) {
                    $parent = ($lvl === 'l1') ? $cooking_cat->term_id : (end($cat_ids) ?: $cooking_cat->term_id);
                    $t = wp_insert_term($name, 'category', array('slug'=>$slug_cat,'parent'=>$parent));
                    if (!is_wp_error($t)) {
                        $term_id = $t['term_id'];
                    } else {
                        $term_id = $parent;
                    }
                } else {
                    $term_id = $term->term_id;
                }
                $cat_ids[] = $term_id;
            }
            if (empty($cat_ids)) $cat_ids[] = $cooking_cat->term_id;

            // Prepare meta mapping (exact keys expected by child_get_recipe_fields)
            $meta_map = array(
                'recipe_intro_short' => $data['intro'] ?? '',
                'recipe_prep' => '',
                'recipe_cook' => '',
                'recipe_total' => $data['time_total'] ?? '',
                'recipe_yield' => $data['servings'] ?? ($data['yield'] ?? ''),
                'recipe_method' => $data['method'] ?? '',
                'video_url' => $data['video_url'] ?? '',
                'recipe_ingredients' => $this->csv_list_to_text($data['ingredients[]'] ?? ''),
                'recipe_steps' => $this->csv_list_to_text($data['instructions[]'] ?? ''),
                'recipe_time_temp' => $this->csv_list_to_text($data['time_temp[]'] ?? ''),
                'recipe_diet' => $data['tags[]'] ?? '',
                'recipe_nutrition' => ($data['calories'] ?? '') . '|' . ($data['protein_g'] ?? '') . '|' . ($data['carb_g'] ?? '') . '|' . ($data['fat_g'] ?? ''),
                'recipe_substitutions' => $data['storage'] ?? '',
                'recipe_storage' => $data['storage'] ?? '',
                'recipe_variations' => $this->csv_list_to_text($data['variations[]'] ?? ''),
                'recipe_faq_q1' => '', 'recipe_faq_a1' => '', // advanced parsing skipped
                'recipe_tools' => $this->csv_list_to_text($data['tools[]'] ?? ''),
                'video_url' => $data['video_url'] ?? '',
                '_template_variant' => $data['_template_variant'] ?? '',
            );

            if ($dry) {
                WP_CLI::log("Row {$row_num}: would create/update post with slug={$slug}, title={$data['title']}, cats=".implode(',', $cat_ids));
                continue;
            }

            // Create or update post
            if ($existing) {
                $post_arr['ID'] = $existing->ID;
                $post_id = wp_update_post($post_arr, true);
                $updated++;
                WP_CLI::log("Row {$row_num}: updated post ID={$post_id}");
            } else {
                $post_arr['post_category'] = $cat_ids;
                $post_id = wp_insert_post($post_arr, true);
                if (is_wp_error($post_id)) { WP_CLI::warning("Row {$row_num}: post insert error: " . $post_id->get_error_message()); $errors++; continue; }
                $created++;
                WP_CLI::log("Row {$row_num}: created post ID={$post_id}");
            }

            // Assign categories
            wp_set_post_categories($post_id, $cat_ids, false);

            // Set meta
            foreach ($meta_map as $k => $v) {
                update_post_meta($post_id, $k, $v);
            }

            // Set tags
            if (!empty($data['tags[]'])) {
                $tags = array_map('trim', explode(',', $data['tags[]']));
                wp_set_post_tags($post_id, $tags, true);
            }

            // Featured image
            if (!empty($data['featured_image'])) {
                $this->attach_remote_image($post_id, $data['featured_image']);
            }

        }

        fclose($handle);
        WP_CLI::success("Import complete. Created={$created}, Updated={$updated}, Errors={$errors}");
    }

    protected function csv_list_to_text($cell) {
        // Accept JSON array or pipe-separated or comma
        if (empty($cell)) return '';
        $val = trim($cell);
        if (strpos($val, '[') === 0) {
            $arr = json_decode($val, true);
            if (is_array($arr)) return implode("\n", array_map('trim', $arr));
        }
        if (strpos($val, '|') !== false) return str_replace('|', "\n", $val);
        if (strpos($val, ',') !== false) return str_replace(',', "\n", $val);
        return $val;
    }

    protected function attach_remote_image($post_id, $url) {
        // Download image and attach to post, set as featured
        require_once ABSPATH . "wp-admin/includes/file.php";
        require_once ABSPATH . "wp-admin/includes/media.php";
        require_once ABSPATH . "wp-admin/includes/image.php";

        $tmp = download_url($url);
        if (is_wp_error($tmp)) {
            WP_CLI::warning("Image download failed: " . $tmp->get_error_message());
            return false;
        }
        $file_array = array();
        $file_array['name'] = basename($url);
        $file_array['tmp_name'] = $tmp;

        $id = media_handle_sideload($file_array, $post_id);
        if (is_wp_error($id)) {
            @unlink($tmp);
            WP_CLI::warning("Media sideload failed: " . $id->get_error_message());
            return false;
        }
        set_post_thumbnail($post_id, $id);
        return $id;
    }
}

WP_CLI::add_command('cook:import', 'Cook_Import_Command');
