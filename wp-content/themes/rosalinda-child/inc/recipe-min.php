<?php
/**
 * Recipe helper functions
 * Implements a small, reliable data contract for recipe posts.
 *
 * Sprint 0 & 1: returns normalized arrays, prints single JSON-LD blob,
 * and provides cached related-links helper.
 *
 * @package SmartLife Child
 */

defined('ABSPATH') || exit;

/**
 * Normalize and return recipe data for a post.
 * Falls back to parsing post content when fields are missing.
 *
 * @param int $post_id
 * @return array
 */
function child_get_recipe_fields($post_id) {
    $post_id = (int) $post_id;
    $data = array();

    // Helper to fetch and sanitize a single meta value
    $get_meta = function($key) use ($post_id) {
        $val = get_post_meta($post_id, $key, true);
        if ($val === '') {
            return null;
        }
        // Normalize decimal commas
        if (is_string($val)) {
            $val = str_replace(',', '.', $val);
            $val = wp_strip_all_tags(trim($val));
            return wp_kses_post($val);
        }
        return $val;
    };

    // Basic scalar fields
    $data['intro'] = $get_meta('recipe_intro_short') ?: '';
    $data['prep'] = $get_meta('recipe_prep') ?: '';
    $data['cook'] = $get_meta('recipe_cook') ?: '';
    $data['total'] = $get_meta('recipe_total') ?: '';
    $data['yield'] = $get_meta('recipe_yield') ?: '';
    $data['method'] = $get_meta('recipe_method') ?: '';
    $data['video_url'] = $get_meta('video_url') ?: '';

    // Ingredients (one per line)
    $ingredients_raw = $get_meta('recipe_ingredients');
    if (!empty($ingredients_raw)) {
        $lines = preg_split('/\r?\n/', $ingredients_raw);
        $data['ingredients'] = array_values(array_filter(array_map('trim', array_map('wp_kses_post', $lines))));
    } else {
        $data['ingredients'] = array();
    }

    // Steps (one per line)
    $steps_raw = $get_meta('recipe_steps');
    if (!empty($steps_raw)) {
        $lines = preg_split('/\r?\n/', $steps_raw);
        $data['steps'] = array_values(array_filter(array_map('trim', array_map('wp_kses_post', $lines))));
    } else {
        $data['steps'] = array();
    }

    // Time & Temperature: item|temp_f|temp_c|minutes|flip|internal_temp
    $data['time_temp'] = array();
    $tt_raw = $get_meta('recipe_time_temp');
    if (!empty($tt_raw)) {
        $lines = preg_split('/\r?\n/', $tt_raw);
        foreach ($lines as $line) {
            $parts = array_map('trim', explode('|', $line));
            if (count($parts) >= 4) {
                $data['time_temp'][] = array(
                    'item' => wp_kses_post($parts[0]),
                    'temp_f' => $parts[1],
                    'temp_c' => $parts[2],
                    'minutes' => preg_replace('/[^0-9\.]/','', $parts[3]),
                    'flip' => isset($parts[4]) ? $parts[4] : '',
                    'internal_temp' => isset($parts[5]) ? $parts[5] : '',
                );
            }
        }
    }

    // Diet tags (comma separated)
    $diet_raw = $get_meta('recipe_diet');
    $data['diet'] = array();
    if (!empty($diet_raw)) {
        $tags = array_map('trim', explode(',', $diet_raw));
        $data['diet'] = array_values(array_filter(array_map('sanitize_text_field', $tags)));
    }

    // Nutrition: kcal|protein|carb|fat
    $data['nutrition'] = array();
    $nut_raw = $get_meta('recipe_nutrition');
    if (!empty($nut_raw)) {
        $parts = array_map('trim', explode('|', $nut_raw));
        if (count($parts) >= 4) {
            // Coerce to numeric strings and strip non-digit except dot
            $k = preg_replace('/[^0-9\.]/', '', $parts[0]);
            $p = preg_replace('/[^0-9\.]/', '', $parts[1]);
            $c = preg_replace('/[^0-9\.]/', '', $parts[2]);
            $f = preg_replace('/[^0-9\.]/', '', $parts[3]);
            $data['nutrition'] = array(
                'kcal' => $k !== '' ? (string) $k : null,
                'protein' => $p !== '' ? (string) $p : null,
                'carb' => $c !== '' ? (string) $c : null,
                'fat' => $f !== '' ? (string) $f : null,
            );
            // If all null, reset
            if (empty(array_filter($data['nutrition']))) {
                $data['nutrition'] = array();
            }
        }
    }

    // FAQs q1..q3 / a1..a3
    $data['faqs'] = array();
    for ($i = 1; $i <= 3; $i++) {
        $q = $get_meta("recipe_faq_q{$i}");
        $a = $get_meta("recipe_faq_a{$i}");
        if (!empty($q) && !empty($a)) {
            $data['faqs'][] = array('q' => wp_kses_post($q), 'a' => wp_kses_post($a));
        }
    }

    // Tools: name|url|why per line
    $data['tools'] = array();
    $tools_raw = $get_meta('recipe_tools');
    if (!empty($tools_raw)) {
        $lines = preg_split('/\r?\n/', $tools_raw);
        foreach ($lines as $line) {
            $parts = array_map('trim', explode('|', $line));
            if (count($parts) >= 2) {
                $data['tools'][] = array(
                    'name' => sanitize_text_field($parts[0]),
                    'url' => esc_url_raw($parts[1]),
                    'why' => isset($parts[2]) ? sanitize_text_field($parts[2]) : '',
                );
            }
        }
    }

    // Additional fields
    $data['substitutions'] = $get_meta('recipe_substitutions') ?: '';
    $data['storage'] = $get_meta('recipe_storage') ?: '';
    $data['variations'] = $get_meta('recipe_variations') ?: '';

    // Fallbacks: parse post content if ingredients or steps are missing
    if (empty($data['ingredients']) || empty($data['steps']) || empty($data['intro'])) {
        $content = wp_strip_all_tags(get_post_field('post_content', $post_id));
        if (empty($data['steps'])) {
            // Use the shared helper if available
            if (function_exists('\SmartLife\Child\_get_first_ordered_list_items')) {
                $parsed_steps = \SmartLife\Child\_get_first_ordered_list_items($content);
            } else {
                $parsed_steps = array();
                if (preg_match('/\n/',$content)) {
                    // naive split on lines
                    $lines = preg_split('/\r?\n/', $content);
                    $parsed_steps = array_map('trim', $lines);
                }
            }
            if (!empty($parsed_steps)) {
                $data['steps'] = array_values(array_filter($parsed_steps));
            }
        }

        if (empty($data['ingredients'])) {
                // Try to extract lines that look like ingredients (lines with numbers, measurements, or commas)
                $lines = preg_split('/\r?\n/', $content);
                $cand = array();
                foreach ($lines as $ln) {
                    $l = trim($ln);
                    if ($l === '') continue;
                    // simple heuristic: contains digits or common units
                    if (preg_match('/\d|cup|tbsp|tsp|g|kg|oz|ml/i', $l)) {
                        $cand[] = wp_kses_post($l);
                    }
                }
                if (!empty($cand)) {
                    $data['ingredients'] = array_values(array_filter($cand));
                }
        }

        if (empty($data['intro'])) {
            $excerpt = get_the_excerpt($post_id);
            if (!empty($excerpt)) {
                $data['intro'] = wp_kses_post($excerpt);
            } else {
                // First paragraph
                if (preg_match('/<p>(.*?)<\/p>/is', $content, $p)) {
                    $data['intro'] = wp_kses_post(strip_tags($p[1]));
                }
            }
        }
    }

    return $data;
}

/**
 * Clear recipe-related transients for a post.
 *
 * @param int $post_id
 */
function child_clear_recipe_transients($post_id) {
    $post_id = (int) $post_id;
    $key = "recipe_related_{$post_id}";
    delete_transient($key);
}

// Hooks: clear cache on post save, term edit, and post trash
add_action('save_post', function($post_id, $post, $update) {
    if ($post->post_type === 'post') {
        child_clear_recipe_transients($post_id);
    }
}, 10, 3);

add_action('edited_terms', function($term_id, $tt_id, $taxonomy) {
    // For safety, clear all recipe transients (cheap for small sites). If large, restrict to affected posts.
    global $wpdb;
    $pattern = "recipe_related_%";
    $keys = $wpdb->get_col($wpdb->prepare("SELECT option_name FROM {$wpdb->options} WHERE option_name LIKE %s", '_transient_' . $pattern));
    if (!empty($keys)) {
        foreach ($keys as $k) {
            $t = str_replace('_transient_', '', $k);
            delete_transient($t);
        }
    }
});

add_action('trashed_post', function($post_id) {
    child_clear_recipe_transients($post_id);
});

/**
 * Return related links: up_link (L3 hub), up to 2 siblings, 1 guide. Cached with transients.
 *
 * @param int $post_id
 * @return array
 */
function child_related_min($post_id) {
    $post_id = (int) $post_id;

    // Use categories/terms to build a stable cache key
    $cats = wp_get_post_categories($post_id);
    sort($cats);
    $key_hash = md5($post_id . '|' . implode(',', $cats));
    $cache_key = "recipe_related_{$key_hash}";
    $cached = get_transient($cache_key);
    if ($cached !== false) {
        return $cached;
    }

    $related = array('up_link' => null, 'siblings' => array(), 'guide' => null);

    if (empty($cats)) {
        set_transient($cache_key, $related, 12 * HOUR_IN_SECONDS);
        return $related;
    }

    // Pick the deepest category among assigned categories
    $deepest = null; $max_depth = -1;
    foreach ($cats as $cat_id) {
        $t = get_category($cat_id);
        if (!$t) continue;
        $depth = 0; $p = $t;
        while ($p && $p->parent) { $depth++; $p = get_category($p->parent); }
        if ($depth > $max_depth) { $max_depth = $depth; $deepest = $t; }
    }

    if ($deepest) {
        // up_link: parent category (L3 hub)
        if ($deepest->parent) {
            $parent = get_category($deepest->parent);
            if ($parent) {
                $related['up_link'] = array('title' => $parent->name, 'url' => get_category_link($parent->term_id));
            }
        }

        // Siblings: recent posts in same deepest category that share at least one tag
        $post_tags = wp_get_post_tags($post_id, array('fields' => 'ids'));
        $tag_ids = !empty($post_tags) ? $post_tags : array();

        if (!empty($tag_ids)) {
            $s_args = array(
                'post_type' => 'post',
                'posts_per_page' => 6, // fetch more and filter
                'category__in' => array($deepest->term_id),
                'post__not_in' => array($post_id),
                'orderby' => 'date',
                'order' => 'DESC',
                'no_found_rows' => true,
                'fields' => 'ids',
            );
            $cand = get_posts($s_args);
            $count = 0;
            foreach ($cand as $cid) {
                if ($count >= 2) break;
                $shared = array_intersect($tag_ids, wp_get_post_tags($cid, array('fields'=>'ids')));
                if (!empty($shared)) {
                    $related['siblings'][] = array('title' => get_the_title($cid), 'url' => get_permalink($cid));
                    $count++;
                }
            }
        } else {
            // Fallback: recent 2 posts in same category
            $s2 = get_posts(array('post_type'=>'post','posts_per_page'=>2,'category__in'=>array($deepest->term_id),'post__not_in'=>array($post_id),'orderby'=>'date','order'=>'DESC','no_found_rows'=>true,'fields'=>'ids'));
            foreach ($s2 as $sid) $related['siblings'][] = array('title'=>get_the_title($sid),'url'=>get_permalink($sid));
        }

        // Guide: preferred tag how-to/storage/guide and matching method/protein tag
        $preferred_tags = array('how-to','storage','guide');
        $guide_args = array(
            'post_type' => 'post',
            'posts_per_page' => 5,
            'category__in' => array($deepest->term_id),
            'post__not_in' => array($post_id),
            'tag_slug__in' => $preferred_tags,
            'orderby' => 'date',
            'order' => 'DESC',
            'no_found_rows' => true,
            'fields' => 'ids',
        );
        $cand_guides = get_posts($guide_args);
        if (!empty($cand_guides)) {
            // prefer same method/protein
            $best = null; $best_score = -1;
            $post_tag_slugs = wp_get_post_tags($post_id, array('fields'=>'slugs'));
            foreach ($cand_guides as $gid) {
                $g_tags = wp_get_post_tags($gid, array('fields'=>'slugs'));
                $score = count(array_intersect($post_tag_slugs, $g_tags));
                if ($score > $best_score) { $best_score = $score; $best = $gid; }
            }
            if ($best) {
                $related['guide'] = array('title'=>get_the_title($best),'url'=>get_permalink($best));
            }
        }
    }

    // Cache for 12 hours keyed by hash
    set_transient($cache_key, $related, 12 * HOUR_IN_SECONDS);
    return $related;
}

/**
 * Print a single JSON-LD <script> containing Recipe or HowTo and FAQ (when available).
 * Outputs nothing if no relevant data exists.
 *
 * @param int $post_id
 */
function child_recipe_schema_min($post_id) {
    $post_id = (int) $post_id;
    $data = child_get_recipe_fields($post_id);

    $title = get_the_title($post_id);
    $url = get_permalink($post_id);
    $author = get_the_author_meta('display_name', get_post_field('post_author', $post_id));
    $date_published = get_the_date('c', $post_id);
    $date_modified = get_the_modified_date('c', $post_id);

    $graph = array();

    // Decide between Recipe and HowTo
    if (!empty($data['ingredients']) && !empty($data['steps'])) {
        $recipe = array('@type' => 'Recipe');
        $recipe['name'] = $title;
        if (!empty($data['intro'])) { $recipe['description'] = wp_strip_all_tags($data['intro']); }
        $recipe['author'] = array('@type' => 'Person', 'name' => $author);
        $recipe['datePublished'] = $date_published;
        $recipe['dateModified'] = $date_modified;
        $recipe['url'] = $url;

        if (!empty($data['prep'])) { $recipe['prepTime'] = 'PT' . intval($data['prep']) . 'M'; }
        if (!empty($data['cook'])) { $recipe['cookTime'] = 'PT' . intval($data['cook']) . 'M'; }
        if (!empty($data['total'])) { $recipe['totalTime'] = 'PT' . intval($data['total']) . 'M'; }
        if (!empty($data['yield'])) { $recipe['recipeYield'] = wp_kses_post($data['yield']); }

        $recipe['recipeIngredient'] = array_values(array_map('wp_strip_all_tags', $data['ingredients']));

        $instructions = array();
        foreach ($data['steps'] as $i => $step) {
            $instructions[] = array('@type' => 'HowToStep', 'name' => 'Step ' . ($i + 1), 'text' => wp_strip_all_tags($step));
        }
        $recipe['recipeInstructions'] = $instructions;

        if (!empty($data['nutrition'])) {
            $recipe['nutrition'] = array('@type' => 'NutritionInformation', 'calories' => $data['nutrition']['kcal']);
            if (!empty($data['nutrition']['protein'])) { $recipe['nutrition']['proteinContent'] = $data['nutrition']['protein'] . 'g'; }
            if (!empty($data['nutrition']['carb'])) { $recipe['nutrition']['carbohydrateContent'] = $data['nutrition']['carb'] . 'g'; }
            if (!empty($data['nutrition']['fat'])) { $recipe['nutrition']['fatContent'] = $data['nutrition']['fat'] . 'g'; }
        }

        if (!empty($data['diet'])) {
            $recipe['suitableForDiet'] = array_map(function($d) { return 'https://schema.org/' . str_replace(array(' ', '-'), '', ucwords($d, " -")) . 'Diet'; }, $data['diet']);
        }

        $graph[] = $recipe;
    } elseif (!empty($data['steps'])) {
        $howto = array('@type' => 'HowTo');
        $howto['name'] = $title;
        $howto['author'] = array('@type' => 'Person', 'name' => $author);
        $howto['datePublished'] = $date_published;
        $howto['url'] = $url;
        if (!empty($data['total'])) { $howto['totalTime'] = 'PT' . intval($data['total']) . 'M'; }
        $steps = array();
        foreach ($data['steps'] as $i => $step) {
            $steps[] = array('@type' => 'HowToStep', 'name' => 'Step ' . ($i + 1), 'text' => wp_strip_all_tags($step));
        }
        $howto['step'] = $steps;
        $graph[] = $howto;
    }

    // FAQ
    if (!empty($data['faqs'])) {
        $faq = array('@type' => 'FAQPage', 'mainEntity' => array());
        foreach ($data['faqs'] as $qa) {
            $faq['mainEntity'][] = array('@type' => 'Question', 'name' => wp_strip_all_tags($qa['q']), 'acceptedAnswer' => array('@type' => 'Answer', 'text' => wp_strip_all_tags($qa['a'])));
        }
        $graph[] = $faq;
    }

    if (empty($graph)) {
        return; // nothing to output
    }

    $out = array('@context' => 'https://schema.org');
    // If only one object, output it directly; else output @graph
    if (count($graph) === 1) {
        $out = array_merge($out, $graph[0]);
    } else {
        $out['@graph'] = $graph;
    }

    echo '<script type="application/ld+json">' . wp_json_encode($out, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) . '</script>' . "\n";
}

/**
 * Count visible recipe sections to estimate mobile content height.
 * Accepts the normalized fields array from child_get_recipe_fields().
 *
 * @param array $fields
 * @return int
 */
function child_count_recipe_sections($fields) {
    $count = 0;
    $checks = array('ingredients','steps','time_temp','tools','faqs','nutrition','substitutions','storage','variations');
    foreach ($checks as $k) {
        if (!empty($fields[$k])) $count++;
    }
    // Intro/hero counts as one
    if (!empty($fields['intro'])) $count++;
    return max(1, $count);
}


/**
 * Ad density guardrail: decide which ad slots (A1..A4) to render so mobile ad density <= ~30%.
 * Heuristic: allowed_ads = floor(0.36 * sections_count), min 1, max 4.
 * Priority: A1, A2, A3, A4 — hide A4 first, then A3 if needed.
 *
 * @param int $sections_count
 * @return array Associative array like ['A1'=>true,'A2'=>true,'A3'=>false,'A4'=>false]
 */
function child_ad_density_guardrail($sections_count) {
    $sections_count = max(1, (int)$sections_count);
    $allowed = (int) floor(0.36 * $sections_count);
    // Ensure at least one ad (A1) shows for monetization
    $allowed = max(1, $allowed);
    $allowed = min(4, $allowed);

    $slots = array('A1'=>false,'A2'=>false,'A3'=>false,'A4'=>false);
    $order = array('A1','A2','A3','A4');
    for ($i=0;$i<$allowed;$i++) {
        $slots[$order[$i]] = true;
    }
    return $slots;
}


/**
 * Return per-post ad layout choice. Stored in postmeta 'ad_layout'.
 * Valid values: 'A' or 'B' (default 'A').
 *
 * @param int $post_id
 * @return string 'A'|'B'
 */
function child_get_ad_layout($post_id) {
    $post_id = (int) $post_id;
    $v = get_post_meta($post_id, 'ad_layout', true);
    if (empty($v)) return 'A';
    $v = strtoupper(substr($v,0,1));
    return ($v === 'B') ? 'B' : 'A';
}
