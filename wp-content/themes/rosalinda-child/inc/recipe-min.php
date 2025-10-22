<?php
/**
 * Recipe helper functions
 * Minimal data extraction and formatting
 * 
 * @package SmartLife Child
 */

defined('ABSPATH') || exit;

/**
 * Get recipe fields from post meta and content
 * 
 * @param int $post_id Post ID
 * @return array Recipe data
 */
function child_get_recipe_fields($post_id) {
    $data = array();
    
    // Basic fields
    $data['intro'] = get_post_meta($post_id, 'recipe_intro_short', true);
    $data['prep'] = get_post_meta($post_id, 'recipe_prep', true);
    $data['cook'] = get_post_meta($post_id, 'recipe_cook', true);
    $data['total'] = get_post_meta($post_id, 'recipe_total', true);
    $data['yield'] = get_post_meta($post_id, 'recipe_yield', true);
    $data['method'] = get_post_meta($post_id, 'recipe_method', true);
    
    // Ingredients (newline-separated)
    $ingredients_raw = get_post_meta($post_id, 'recipe_ingredients', true);
    $data['ingredients'] = !empty($ingredients_raw) ? explode("\n", trim($ingredients_raw)) : array();
    
    // Steps (newline-separated)
    $steps_raw = get_post_meta($post_id, 'recipe_steps', true);
    $data['steps'] = !empty($steps_raw) ? explode("\n", trim($steps_raw)) : array();
    
    // Time & Temperature (newline or CSV: item|temp_f|minutes|flip|internal_temp)
    $time_temp_raw = get_post_meta($post_id, 'recipe_time_temp', true);
    $data['time_temp'] = array();
    if (!empty($time_temp_raw)) {
        $lines = explode("\n", trim($time_temp_raw));
        foreach ($lines as $line) {
            $parts = explode('|', trim($line));
            if (count($parts) >= 3) {
                $data['time_temp'][] = array(
                    'item' => $parts[0],
                    'temp' => $parts[1],
                    'time' => $parts[2],
                    'flip' => isset($parts[3]) ? $parts[3] : '',
                    'internal' => isset($parts[4]) ? $parts[4] : '',
                );
            }
        }
    }
    
    // Diet tags (comma-separated)
    $diet_raw = get_post_meta($post_id, 'recipe_diet', true);
    $data['diet'] = !empty($diet_raw) ? array_map('trim', explode(',', $diet_raw)) : array();
    
    // Nutrition (kcal|protein|carb|fat)
    $nutrition_raw = get_post_meta($post_id, 'recipe_nutrition', true);
    $data['nutrition'] = array();
    if (!empty($nutrition_raw)) {
        $parts = explode('|', $nutrition_raw);
        if (count($parts) >= 4) {
            $data['nutrition'] = array(
                'kcal' => $parts[0],
                'protein' => $parts[1],
                'carb' => $parts[2],
                'fat' => $parts[3],
            );
        }
    }
    
    // FAQ (q1/a1, q2/a2, q3/a3)
    $data['faqs'] = array();
    for ($i = 1; $i <= 5; $i++) {
        $q = get_post_meta($post_id, "recipe_faq_q{$i}", true);
        $a = get_post_meta($post_id, "recipe_faq_a{$i}", true);
        if (!empty($q) && !empty($a)) {
            $data['faqs'][] = array('q' => $q, 'a' => $a);
        }
    }
    
    // Tools (name|url per line)
    $tools_raw = get_post_meta($post_id, 'recipe_tools', true);
    $data['tools'] = array();
    if (!empty($tools_raw)) {
        $lines = explode("\n", trim($tools_raw));
        foreach ($lines as $line) {
            $parts = explode('|', trim($line));
            if (count($parts) >= 2) {
                $data['tools'][] = array(
                    'name' => $parts[0],
                    'url' => $parts[1],
                );
            }
        }
    }
    
    // Additional fields
    $data['substitutions'] = get_post_meta($post_id, 'recipe_substitutions', true);
    $data['storage'] = get_post_meta($post_id, 'recipe_storage', true);
    $data['variations'] = get_post_meta($post_id, 'recipe_variations', true);
    
    return $data;
}

/**
 * Get minimal related recipe links
 * 
 * @param int $post_id Post ID
 * @return array Related links
 */
function child_related_min($post_id) {
    $cache_key = "recipe_related_{$post_id}";
    $cached = get_transient($cache_key);
    
    if ($cached !== false) {
        return $cached;
    }
    
    $related = array(
        'up_link' => '',
        'siblings' => array(),
        'guide' => array(),
    );
    
    // Get categories
    $categories = get_the_category($post_id);
    if (!empty($categories)) {
        // Find deepest category (most specific)
        $deepest_cat = null;
        $max_depth = 0;
        
        foreach ($categories as $cat) {
            $depth = 0;
            $temp_cat = $cat;
            while ($temp_cat->parent != 0) {
                $depth++;
                $temp_cat = get_category($temp_cat->parent);
                if (!$temp_cat) break;
            }
            
            if ($depth > $max_depth) {
                $max_depth = $depth;
                $deepest_cat = $cat;
            }
        }
        
        if ($deepest_cat && $deepest_cat->parent != 0) {
            $parent_cat = get_category($deepest_cat->parent);
            if ($parent_cat) {
                $related['up_link'] = array(
                    'title' => $parent_cat->name,
                    'url' => get_category_link($parent_cat),
                );
            }
        }
        
        // Get siblings (same category, different post)
        $sibling_args = array(
            'post_type' => 'post',
            'posts_per_page' => 3,
            'post__not_in' => array($post_id),
            'category__in' => array($deepest_cat->term_id),
            'orderby' => 'date',
            'order' => 'DESC',
        );
        
        $sibling_posts = get_posts($sibling_args);
        foreach ($sibling_posts as $post) {
            $related['siblings'][] = array(
                'title' => $post->post_title,
                'url' => get_permalink($post->ID),
            );
        }
        
        // Get guide (posts with 'how-to' or 'storage' tag in same category)
        $guide_args = array(
            'post_type' => 'post',
            'posts_per_page' => 1,
            'post__not_in' => array($post_id),
            'category__in' => array($deepest_cat->term_id),
            'tag_slug__in' => array('how-to', 'storage', 'guide'),
            'orderby' => 'date',
            'order' => 'DESC',
        );
        
        $guide_posts = get_posts($guide_args);
        if (!empty($guide_posts)) {
            $related['guide'] = array(
                'title' => $guide_posts[0]->post_title,
                'url' => get_permalink($guide_posts[0]->ID),
            );
        }
    }
    
    // Cache for 12 hours
    set_transient($cache_key, $related, 12 * HOUR_IN_SECONDS);
    
    return $related;
}

/**
 * Print Recipe or HowTo + FAQ JSON-LD schema
 * 
 * @param int $post_id Post ID
 */
function child_recipe_schema_min($post_id) {
    $data = child_get_recipe_fields($post_id);
    
    // Base data
    $title = get_the_title($post_id);
    $url = get_permalink($post_id);
    $author = get_the_author_meta('display_name', get_post_field('post_author', $post_id));
    $date_published = get_the_date('c', $post_id);
    $date_modified = get_the_modified_date('c', $post_id);
    
    $schemas = array();
    
    // Recipe schema if we have ingredients and steps
    if (!empty($data['ingredients']) && !empty($data['steps'])) {
        $recipe = array(
            '@context' => 'https://schema.org',
            '@type' => 'Recipe',
            'name' => $title,
            'author' => array(
                '@type' => 'Person',
                'name' => $author,
            ),
            'datePublished' => $date_published,
            'dateModified' => $date_modified,
            'url' => $url,
        );
        
        // Optional fields
        if (!empty($data['intro'])) {
            $recipe['description'] = $data['intro'];
        }
        
        if (!empty($data['total'])) {
            $recipe['totalTime'] = 'PT' . $data['total'] . 'M';
        }
        
        if (!empty($data['prep'])) {
            $recipe['prepTime'] = 'PT' . $data['prep'] . 'M';
        }
        
        if (!empty($data['cook'])) {
            $recipe['cookTime'] = 'PT' . $data['cook'] . 'M';
        }
        
        if (!empty($data['yield'])) {
            $recipe['recipeYield'] = $data['yield'];
        }
        
        // Ingredients
        $recipe['recipeIngredient'] = array_filter($data['ingredients']);
        
        // Instructions
        $instructions = array();
        foreach (array_filter($data['steps']) as $i => $step) {
            $instructions[] = array(
                '@type' => 'HowToStep',
                'name' => 'Step ' . ($i + 1),
                'text' => $step,
            );
        }
        $recipe['recipeInstructions'] = $instructions;
        
        // Nutrition
        if (!empty($data['nutrition'])) {
            $recipe['nutrition'] = array(
                '@type' => 'NutritionInformation',
                'calories' => $data['nutrition']['kcal'],
                'proteinContent' => $data['nutrition']['protein'] . 'g',
                'carbohydrateContent' => $data['nutrition']['carb'] . 'g',
                'fatContent' => $data['nutrition']['fat'] . 'g',
            );
        }
        
        // Diet suitability
        if (!empty($data['diet'])) {
            $recipe['suitableForDiet'] = array_map(function($diet) {
                return 'https://schema.org/' . str_replace(array('-', ' '), '', ucwords($diet, '- ')) . 'Diet';
            }, $data['diet']);
        }
        
        $schemas[] = $recipe;
        
    } elseif (!empty($data['steps'])) {
        // HowTo schema if we only have steps
        $howto = array(
            '@context' => 'https://schema.org',
            '@type' => 'HowTo',
            'name' => $title,
            'author' => array(
                '@type' => 'Person',
                'name' => $author,
            ),
            'datePublished' => $date_published,
            'url' => $url,
        );
        
        if (!empty($data['total'])) {
            $howto['totalTime'] = 'PT' . $data['total'] . 'M';
        }
        
        $steps = array();
        foreach (array_filter($data['steps']) as $i => $step) {
            $steps[] = array(
                '@type' => 'HowToStep',
                'name' => 'Step ' . ($i + 1),
                'text' => $step,
            );
        }
        $howto['step'] = $steps;
        
        $schemas[] = $howto;
    }
    
    // FAQ schema if we have FAQs
    if (!empty($data['faqs'])) {
        $faq = array(
            '@context' => 'https://schema.org',
            '@type' => 'FAQPage',
            'mainEntity' => array(),
        );
        
        foreach ($data['faqs'] as $qa) {
            $faq['mainEntity'][] = array(
                '@type' => 'Question',
                'name' => $qa['q'],
                'acceptedAnswer' => array(
                    '@type' => 'Answer',
                    'text' => $qa['a'],
                ),
            );
        }
        
        $schemas[] = $faq;
    }
    
    // Output schemas
    foreach ($schemas as $schema) {
        echo '<script type="application/ld+json">';
        echo wp_json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        echo '</script>' . "\n";
    }
}