<?php
/**
 * SmartLife Child Theme bootstrap.
 * No CSS, no template overrides. Core blocks only.
 * 
 * @package SmartLife Child
 * @version 2.0.0
 */

namespace SmartLife\Child;

defined('ABSPATH') || exit;

/* ==========================================================================
   BLOCK PATTERNS
   ========================================================================== */

/**
 * Register custom pattern category
 */
function register_pattern_category() {
    if (!function_exists('register_block_pattern_category')) {
        return;
    }
    
    register_block_pattern_category('smartlife-articles', array(
        'label' => __('SmartLife Articles', 'rosalinda-child'),
    ));
}

/**
 * Register article patterns
 */
function register_article_patterns() {
    if (!function_exists('register_block_pattern')) {
        return;
    }
    
    $patterns = array(
        array(
            'slug' => 'smartlife/how-to',
            'title' => __('How-To Article', 'rosalinda-child'),
            'description' => __('Step-by-step guide with FAQ and schema support', 'rosalinda-child'),
            'file' => 'how-to.html',
        ),
        array(
            'slug' => 'smartlife/listicle',
            'title' => __('Listicle Article', 'rosalinda-child'),
            'description' => __('Numbered list format for quick-read content', 'rosalinda-child'),
            'file' => 'listicle.html',
        ),
        array(
            'slug' => 'smartlife/comparison',
            'title' => __('Comparison Article', 'rosalinda-child'),
            'description' => __('Side-by-side comparison with verdict', 'rosalinda-child'),
            'file' => 'comparison.html',
        ),
        array(
            'slug' => 'smartlife/plan',
            'title' => __('Day Plan Article', 'rosalinda-child'),
            'description' => __('7/14/30-day action plan template', 'rosalinda-child'),
            'file' => 'plan.html',
        ),
        array(
            'slug' => 'smartlife/script-pack',
            'title' => __('Script Pack Article', 'rosalinda-child'),
            'description' => __('Copy-paste conversation scripts', 'rosalinda-child'),
            'file' => 'script-pack.html',
        ),
        array(
            'slug' => 'smartlife/checklist',
            'title' => __('Checklist Article', 'rosalinda-child'),
            'description' => __('Printable checklist format', 'rosalinda-child'),
            'file' => 'checklist.html',
        ),
    );
    
    $patterns_dir = get_stylesheet_directory() . '/patterns/';
    
    foreach ($patterns as $pattern) {
        // Skip if already registered (idempotent)
        if (_pattern_exists($pattern['slug'])) {
            continue;
        }
        
        $file_path = $patterns_dir . $pattern['file'];
        
        if (!file_exists($file_path)) {
            continue;
        }
        
        $content = file_get_contents($file_path);
        
        if ($content === false) {
            continue;
        }
        
        register_block_pattern($pattern['slug'], array(
            'title' => $pattern['title'],
            'description' => $pattern['description'],
            'content' => $content,
            'categories' => array('smartlife-articles'),
        ));
    }
}

/**
 * Check if pattern exists (helper for idempotency)
 * 
 * @param string $slug Pattern slug
 * @return bool
 */
function _pattern_exists($slug) {
    if (!class_exists('WP_Block_Patterns_Registry')) {
        return false;
    }
    
    $registry = \WP_Block_Patterns_Registry::get_instance();
    return $registry->is_registered($slug);
}

/* ==========================================================================
   SHORTCODES
   ========================================================================== */

/**
 * Ad placeholder shortcode
 * 
 * @param array $atts Shortcode attributes
 * @return string HTML output
 */
function shortcode_ad($atts) {
    $atts = shortcode_atts(array(
        'slot' => 'mid',
    ), $atts, 'ad');
    
    $allowed_slots = array('top', 'mid', 'end', 'sidebar', 'footer');
    $slot = in_array($atts['slot'], $allowed_slots, true) ? $atts['slot'] : 'mid';
    
    return sprintf(
        '<div id="ad-%s" class="ad-slot" aria-hidden="true"></div>',
        esc_attr($slot)
    );
}

/**
 * Disclosure shortcode
 * 
 * @return string HTML output
 */
function shortcode_disclosure() {
    return '<!-- wp:paragraph -->' . "\n"
        . '<p><em>' . esc_html__('This article may contain ads and/or affiliate links. Educational content only — not medical or financial advice.', 'rosalinda-child') . '</em></p>' . "\n"
        . '<!-- /wp:paragraph -->';
}

/**
 * Enable shortcodes in content and term descriptions
 */
function enable_shortcodes_in_content() {
    add_filter('the_content', 'do_shortcode', 9);
    add_filter('term_description', 'do_shortcode', 9);
}

/* ==========================================================================
   SCHEMA / STRUCTURED DATA
   ========================================================================== */

/**
 * Print Schema.org JSON-LD structured data
 */
function print_schema_jsonld() {
    // Only on single posts
    if (!is_singular('post') || !in_the_loop()) {
        return;
    }
    
    global $post;
    
    if (!$post || !have_posts()) {
        return;
    }
    
    // Always print Article schema
    _print_article_schema();
    
    // Always print BreadcrumbList
    _print_breadcrumb_schema();
    
    // Conditional schemas based on content markers
    $content = get_the_content();
    
    // HowTo schema if marker exists
    if (strpos($content, '<!-- SMARTLIFE:HOWTO -->') !== false) {
        _print_howto_schema($content);
    }
    
    // FAQ schema if markers exist
    if (strpos($content, '<!-- FAQ: start -->') !== false && strpos($content, '<!-- FAQ: end -->') !== false) {
        _print_faq_schema($content);
    }
}

/**
 * Print Article schema
 */
function _print_article_schema() {
    $schema = array(
        '@context' => 'https://schema.org',
        '@type' => 'Article',
        'headline' => get_the_title(),
        'datePublished' => get_the_date('c'),
        'dateModified' => get_the_modified_date('c'),
        'author' => array(
            '@type' => 'Person',
            'name' => get_the_author(),
        ),
        'mainEntityOfPage' => get_permalink(),
    );
    
    // Add featured image if exists
    if (has_post_thumbnail()) {
        $image_id = get_post_thumbnail_id();
        $image_url = wp_get_attachment_image_url($image_id, 'full');
        if ($image_url) {
            $schema['image'] = esc_url($image_url);
        }
    }
    
    echo '<script type="application/ld+json">' . "\n";
    echo wp_json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) . "\n";
    echo '</script>' . "\n";
}

/**
 * Print BreadcrumbList schema
 */
function _print_breadcrumb_schema() {
    $items = array();
    $position = 1;
    
    // Home
    $items[] = array(
        '@type' => 'ListItem',
        'position' => $position++,
        'name' => get_bloginfo('name'),
        'item' => esc_url(home_url('/')),
    );
    
    // First category
    $categories = get_the_category();
    if (!empty($categories)) {
        $category = $categories[0];
        $items[] = array(
            '@type' => 'ListItem',
            'position' => $position++,
            'name' => esc_html($category->name),
            'item' => esc_url(get_category_link($category->term_id)),
        );
    }
    
    // Current post
    $items[] = array(
        '@type' => 'ListItem',
        'position' => $position,
        'name' => get_the_title(),
        'item' => get_permalink(),
    );
    
    $schema = array(
        '@context' => 'https://schema.org',
        '@type' => 'BreadcrumbList',
        'itemListElement' => $items,
    );
    
    echo '<script type="application/ld+json">' . "\n";
    echo wp_json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) . "\n";
    echo '</script>' . "\n";
}

/**
 * Print HowTo schema
 * 
 * @param string $content Post content
 */
function _print_howto_schema($content) {
    $steps = _get_first_ordered_list_items($content);
    
    if (empty($steps)) {
        return;
    }
    
    $step_items = array();
    foreach ($steps as $index => $step_text) {
        $step_items[] = array(
            '@type' => 'HowToStep',
            'name' => esc_html($step_text),
            'position' => $index + 1,
        );
    }
    
    $schema = array(
        '@context' => 'https://schema.org',
        '@type' => 'HowTo',
        'name' => get_the_title(),
        'totalTime' => 'PT0H',
        'step' => $step_items,
    );
    
    echo '<script type="application/ld+json">' . "\n";
    echo wp_json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) . "\n";
    echo '</script>' . "\n";
}

/**
 * Print FAQPage schema
 * 
 * @param string $content Post content
 */
function _print_faq_schema($content) {
    $faq_pairs = _extract_faq_pairs($content);
    
    if (empty($faq_pairs)) {
        return;
    }
    
    $main_entity = array();
    foreach ($faq_pairs as $pair) {
        $main_entity[] = array(
            '@type' => 'Question',
            'name' => esc_html($pair['q']),
            'acceptedAnswer' => array(
                '@type' => 'Answer',
                'text' => esc_html($pair['a']),
            ),
        );
    }
    
    $schema = array(
        '@context' => 'https://schema.org',
        '@type' => 'FAQPage',
        'mainEntity' => $main_entity,
    );
    
    echo '<script type="application/ld+json">' . "\n";
    echo wp_json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) . "\n";
    echo '</script>' . "\n";
}

/**
 * Extract first ordered list items (up to 8 steps)
 * 
 * @param string $html HTML content
 * @return array Step strings
 */
function _get_first_ordered_list_items($html) {
    $steps = array();
    
    // Find first <ol> tag
    if (preg_match('/<ol[^>]*>(.*?)<\/ol>/is', $html, $ol_match)) {
        // Extract <li> items
        if (preg_match_all('/<li[^>]*>(.*?)<\/li>/is', $ol_match[1], $li_matches)) {
            foreach ($li_matches[1] as $index => $li_content) {
                if ($index >= 8) {
                    break;
                }
                
                // Strip HTML tags and clean up
                $text = wp_strip_all_tags($li_content);
                $text = trim($text);
                
                if (!empty($text)) {
                    $steps[] = $text;
                }
            }
        }
    }
    
    return $steps;
}

/**
 * Extract FAQ pairs between markers
 * 
 * @param string $html HTML content
 * @return array Array of ['q' => '...', 'a' => '...']
 */
function _extract_faq_pairs($html) {
    $pairs = array();
    
    // Extract content between markers
    if (preg_match('/<!-- FAQ: start -->(.*?)<!-- FAQ: end -->/is', $html, $faq_match)) {
        $faq_content = $faq_match[1];
        
        // Find list items with Q: and A: format
        if (preg_match_all('/<li[^>]*>(.*?)<\/li>/is', $faq_content, $li_matches)) {
            foreach ($li_matches[1] as $li_content) {
                // Parse Q: ... A: ... format
                $text = wp_strip_all_tags($li_content, true);
                
                // Try to extract Q and A
                if (preg_match('/Q:\s*(.+?)\s+A:\s*(.+)/is', $text, $qa_match)) {
                    $pairs[] = array(
                        'q' => trim($qa_match[1]),
                        'a' => trim($qa_match[2]),
                    );
                }
            }
        }
    }
    
    return $pairs;
}

/* ==========================================================================
   LEGACY FUNCTIONS (preserved from original theme)
   ========================================================================== */

// Include original functions if they exist
if (file_exists(__DIR__ . '/functions-legacy.php')) {
    require_once __DIR__ . '/functions-legacy.php';
}

/* ==========================================================================
   HOOKS REGISTRATION
   ========================================================================== */

// Block patterns
add_action('init', __NAMESPACE__ . '\\register_pattern_category');
add_action('init', __NAMESPACE__ . '\\register_article_patterns');

// Shortcodes
add_action('init', function() {
    add_shortcode('ad', __NAMESPACE__ . '\\shortcode_ad');
    add_shortcode('disclosure', __NAMESPACE__ . '\\shortcode_disclosure');
}, 5);

add_action('init', __NAMESPACE__ . '\\enable_shortcodes_in_content');

// Schema
add_action('wp_head', __NAMESPACE__ . '\\print_schema_jsonld', 99);

/* ==========================================================================
   INCLUDES
   ========================================================================== */

/**
 * Include legacy functions for category/menu system
 */
if (file_exists(get_stylesheet_directory() . '/functions-legacy.php')) {
    require_once get_stylesheet_directory() . '/functions-legacy.php';
}

/**
 * Include recipe helper functions
 */
if (file_exists(get_stylesheet_directory() . '/inc/recipe-min.php')) {
    require_once get_stylesheet_directory() . '/inc/recipe-min.php';
}

/**
 * Include recipe meta box
 */
if (file_exists(get_stylesheet_directory() . '/inc/recipe-metabox.php')) {
    require_once get_stylesheet_directory() . '/inc/recipe-metabox.php';
}

/**
 * Enable custom fields in block editor
 */
add_action('init', function() {
    add_post_type_support('post', 'custom-fields');
});

/**
 * Force custom fields to show in block editor
 */
add_action('use_block_editor_for_post', function($use_block_editor, $post) {
    if ($post->post_type === 'post') {
        add_post_type_support('post', 'custom-fields');
    }
    return $use_block_editor;
}, 10, 2);

/**
 * Ensure custom fields meta box is enabled
 */
add_action('add_meta_boxes', function() {
    add_meta_box(
        'postcustom',
        'Custom Fields',
        'post_custom_meta_box',
        'post',
        'normal',
        'core'
    );
});

/**
 * Register custom fields for REST API (block editor)
 */
add_action('rest_api_init', function() {
    $recipe_fields = [
        'recipe_intro_short',
        'recipe_prep',
        'recipe_cook',
        'recipe_total',
        'recipe_yield',
        'recipe_method',
        'recipe_ingredients',
        'recipe_steps',
        'recipe_time_temp',
        'recipe_diet',
        'recipe_nutrition',
        'recipe_faq_q1',
        'recipe_faq_a1',
        'recipe_faq_q2',
        'recipe_faq_a2',
        'recipe_faq_q3',
        'recipe_faq_a3',
        'recipe_tools',
        'recipe_substitutions',
        'recipe_storage',
        'recipe_variations'
    ];
    
    foreach ($recipe_fields as $field) {
        register_rest_field('post', $field, [
            'get_callback' => function($post) use ($field) {
                return get_post_meta($post['id'], $field, true);
            },
            'update_callback' => function($value, $post) use ($field) {
                return update_post_meta($post->ID, $field, $value);
            },
            'schema' => [
                'description' => 'Recipe field: ' . $field,
                'type' => 'string',
                'context' => ['edit'],
            ],
        ]);
    }
});
