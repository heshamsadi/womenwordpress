<?php
/**
 * Rosalinda Child Theme Functions
 * 
 * This file contains all the custom functions for the child theme.
 * Add your custom PHP functions, hooks, and WordPress customizations here.
 * 
 * @package Rosalinda Child
 * @version 1.0.0
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Enqueue child theme styles and scripts
 * Parent theme styles are loaded by parent theme
 * We add child theme customizations for dropdown menus
 */
function rosalinda_child_enqueue_styles() {
    $child_style_version = wp_get_theme()->get('Version');
    
    // Enqueue child theme styles with dropdown menu fixes
    wp_enqueue_style('rosalinda-child-style',
        get_stylesheet_directory_uri() . '/style.css',
        array('rosalinda-style'),
        $child_style_version
    );
    
    // Enqueue menu hover JavaScript
    wp_enqueue_script('rosalinda-child-menu-hover',
        get_stylesheet_directory_uri() . '/assets/js/menu-hover.js',
        array(),
        $child_style_version,
        true
    );
}
add_action('wp_enqueue_scripts', 'rosalinda_child_enqueue_styles', 15);

/**
 * Add child theme version to body class
 */
function rosalinda_child_body_class($classes) {
    $classes[] = 'rosalinda-child';
    return $classes;
}
add_filter('body_class', 'rosalinda_child_body_class');

/* ==========================================================================
   Custom Functions - Add your custom functions below this line
   ========================================================================== */

/**
 * Example: Custom excerpt length
 */
/*
function rosalinda_child_excerpt_length($length) {
    return 20; // Number of words
}
add_filter('excerpt_length', 'rosalinda_child_excerpt_length', 999);
*/

/**
 * Example: Add custom image sizes
 */
/*
function rosalinda_child_image_sizes() {
    add_image_size('custom-large', 1200, 800, true);
    add_image_size('custom-medium', 600, 400, true);
    add_image_size('custom-small', 300, 200, true);
}
add_action('after_setup_theme', 'rosalinda_child_image_sizes');
*/

/**
 * Example: Customize login page
 */
/*
function rosalinda_child_login_logo() {
    echo '<style type="text/css">
        #login h1 a {
            background-image: url(' . get_stylesheet_directory_uri() . '/images/custom-logo.png);
            background-size: contain;
            width: 300px;
            height: 100px;
        }
    </style>';
}
add_action('login_enqueue_scripts', 'rosalinda_child_login_logo');
*/

/**
 * Example: Add custom post types
 */
/*
function rosalinda_child_custom_post_types() {
    register_post_type('custom_recipes', array(
        'labels' => array(
            'name' => 'Custom Recipes',
            'singular_name' => 'Recipe'
        ),
        'public' => true,
        'supports' => array('title', 'editor', 'thumbnail'),
        'menu_icon' => 'dashicons-carrot'
    ));
}
add_action('init', 'rosalinda_child_custom_post_types');
*/

/**
 * Example: Add custom admin styles
 */
/*
function rosalinda_child_admin_styles() {
    wp_enqueue_style('rosalinda-child-admin', 
        get_stylesheet_directory_uri() . '/admin-style.css',
        array(),
        wp_get_theme()->get('Version')
    );
}
add_action('admin_enqueue_scripts', 'rosalinda_child_admin_styles');
*/

/**
 * Example: Customize theme support
 */
/*
function rosalinda_child_theme_support() {
    // Add custom logo support
    add_theme_support('custom-logo', array(
        'height'      => 100,
        'width'       => 300,
        'flex-height' => true,
        'flex-width'  => true,
    ));
    
    // Add custom header support
    add_theme_support('custom-header', array(
        'default-image' => '',
        'width'         => 1200,
        'height'        => 600,
        'flex-height'   => true,
        'flex-width'    => true,
    ));
}
add_action('after_setup_theme', 'rosalinda_child_theme_support');
*/

/* ==========================================================================
   Security and Performance
   ========================================================================== */

/**
 * Remove WordPress version from head for security
 */
function rosalinda_child_remove_wp_version() {
    return '';
}
add_filter('the_generator', 'rosalinda_child_remove_wp_version');

/* ==========================================================================
   Category Structure (Hubs + Subhubs)
   ========================================================================== */

/**
 * Category hierarchy map
 * Each hub has name, slug, description intro, and children (subhubs)
 * Each subhub can have its own children (sub-pages)
 */
function rosalinda_child_get_category_map() {
    return array(
        array(
            'name' => 'Health',
            'slug' => 'health',
            'description' => 'Evidence-based guides, tools, and templates for nutrition, cycle care, sleep, and stress management.',
            'children' => array(
                array(
                    'name' => 'Nutrition',
                    'slug' => 'nutrition',
                    'children' => array(
                        array('name' => 'Meal Plans', 'slug' => 'meal-plans'),
                        array('name' => 'Micronutrients 101', 'slug' => 'micronutrients'),
                        array('name' => 'Hydration & Electrolytes', 'slug' => 'hydration'),
                        array('name' => 'Food-First Guides', 'slug' => 'food-first'),
                    ),
                ),
                array(
                    'name' => 'Cycle Care',
                    'slug' => 'cycle-care',
                    'children' => array(
                        array('name' => 'Phase Guides', 'slug' => 'phase-guides'),
                        array('name' => 'Workout Syncing', 'slug' => 'workout-sync'),
                        array('name' => 'Symptom Care', 'slug' => 'symptom-care'),
                        array('name' => 'Calendar & Tracker', 'slug' => 'tracker'),
                    ),
                ),
                array(
                    'name' => 'Sleep & Stress',
                    'slug' => 'sleep-stress',
                    'children' => array(
                        array('name' => 'Sleep Habits', 'slug' => 'sleep-habits'),
                        array('name' => 'Evening Routines', 'slug' => 'evening-routines'),
                        array('name' => 'Stress Scripts', 'slug' => 'stress-scripts'),
                        array('name' => 'Breathing & Micro-breaks', 'slug' => 'breathing'),
                    ),
                ),
            ),
        ),
        array(
            'name' => 'Beauty',
            'slug' => 'beauty',
            'description' => 'Science-backed skincare, haircare, and makeup guides tailored to your needs.',
            'children' => array(
                array(
                    'name' => 'Skincare',
                    'slug' => 'skincare',
                    'children' => array(
                        array('name' => 'Routines (AM/PM)', 'slug' => 'routines'),
                        array('name' => 'Ingredients 101', 'slug' => 'ingredients'),
                        array('name' => 'Concern Guides', 'slug' => 'concerns'),
                        array('name' => 'SPF & Sun Care', 'slug' => 'spf'),
                    ),
                ),
                array(
                    'name' => 'Haircare',
                    'slug' => 'haircare',
                    'children' => array(
                        array('name' => 'Wash Day Maps', 'slug' => 'wash-day'),
                        array('name' => 'Curl Types 2A–4C', 'slug' => 'curl-types'),
                        array('name' => 'Protective Styling', 'slug' => 'protective-styles'),
                        array('name' => 'Scalp Care', 'slug' => 'scalp'),
                    ),
                ),
                array(
                    'name' => 'Makeup',
                    'slug' => 'makeup',
                    'children' => array(
                        array('name' => '5-Minute Looks', 'slug' => 'fast-looks'),
                        array('name' => 'Base & Complexion', 'slug' => 'base'),
                        array('name' => 'Eyes & Lips', 'slug' => 'eyes-lips'),
                        array('name' => 'Tools & Hygiene', 'slug' => 'tools'),
                    ),
                ),
            ),
        ),
        array(
            'name' => 'Fitness',
            'slug' => 'fitness',
            'description' => 'Movement plans for every stage of life—beginner-friendly, postpartum-safe, and age-appropriate.',
            'children' => array(
                array(
                    'name' => 'Beginner',
                    'slug' => 'beginner',
                    'children' => array(
                        array('name' => 'Full-Body Basics', 'slug' => 'full-body'),
                        array('name' => 'No-Equipment Plans', 'slug' => 'no-equipment'),
                        array('name' => 'Form 101', 'slug' => 'form-101'),
                        array('name' => 'Mobility Reset', 'slug' => 'mobility'),
                    ),
                ),
                array(
                    'name' => 'Postpartum',
                    'slug' => 'postpartum',
                    'children' => array(
                        array('name' => 'Core Basics', 'slug' => 'core-basics'),
                        array('name' => 'Gentle Progressions', 'slug' => 'progressions'),
                        array('name' => 'Time-Saver Workouts', 'slug' => 'time-savers'),
                        array('name' => 'Return-to-Movement Checklist', 'slug' => 'checklist'),
                    ),
                ),
                array(
                    'name' => '40-Plus',
                    'slug' => '40-plus',
                    'children' => array(
                        array('name' => 'Strength Focus', 'slug' => 'strength'),
                        array('name' => 'Mobility & Balance', 'slug' => 'mobility-balance'),
                        array('name' => 'Joint-Friendly Sessions', 'slug' => 'joint-friendly'),
                        array('name' => 'Recovery & Sleep', 'slug' => 'recovery'),
                    ),
                ),
            ),
        ),
        array(
            'name' => 'Money & Career',
            'slug' => 'money-career',
            'description' => 'Practical financial tools, budget templates, side hustle ideas, and salary negotiation scripts.',
            'children' => array(
                array(
                    'name' => 'Budgeting',
                    'slug' => 'budgeting',
                    'children' => array(
                        array('name' => 'Starter Budget', 'slug' => 'starter'),
                        array('name' => 'Zero-Based System', 'slug' => 'zero-based'),
                        array('name' => 'Templates & Sheets', 'slug' => 'templates'),
                        array('name' => 'Automations', 'slug' => 'automation'),
                    ),
                ),
                array(
                    'name' => 'Side Hustles',
                    'slug' => 'side-hustles',
                    'children' => array(
                        array('name' => 'Idea Matrix', 'slug' => 'ideas'),
                        array('name' => 'Skill Matching', 'slug' => 'skill-match'),
                        array('name' => 'Setup Guides', 'slug' => 'setup'),
                        array('name' => 'Basics & Taxes', 'slug' => 'basics'),
                    ),
                ),
                array(
                    'name' => 'Salary Growth',
                    'slug' => 'salary-growth',
                    'children' => array(
                        array('name' => 'Market Research', 'slug' => 'research'),
                        array('name' => 'Raise Scripts', 'slug' => 'raise-scripts'),
                        array('name' => 'Interview Prep', 'slug' => 'interview'),
                        array('name' => 'Portfolio & LinkedIn', 'slug' => 'brand'),
                    ),
                ),
            ),
        ),
        array(
            'name' => 'Home & Parenting',
            'slug' => 'home-parenting',
            'description' => 'New mom essentials, meal prep systems, and family organization strategies that actually work.',
            'children' => array(
                array(
                    'name' => 'New Mom',
                    'slug' => 'new-mom',
                    'children' => array(
                        array('name' => 'First 12 Weeks', 'slug' => 'first-12-weeks'),
                        array('name' => 'Logs & Routines', 'slug' => 'logs'),
                        array('name' => 'Gear Checklists', 'slug' => 'checklists'),
                        array('name' => 'Support Scripts', 'slug' => 'support-scripts'),
                    ),
                ),
                array(
                    'name' => 'Meal Prep',
                    'slug' => 'meal-prep',
                    'children' => array(
                        array('name' => '30-Minute Meals', 'slug' => '30-minute'),
                        array('name' => 'Weekly Plans', 'slug' => 'weekly-plans'),
                        array('name' => 'Shopping Lists', 'slug' => 'shopping-lists'),
                        array('name' => 'Storage & Reheat', 'slug' => 'storage'),
                    ),
                ),
                array(
                    'name' => 'Family Organization',
                    'slug' => 'family-organization',
                    'children' => array(
                        array('name' => 'Command Center', 'slug' => 'command-center'),
                        array('name' => 'Routines & Charts', 'slug' => 'routines'),
                        array('name' => 'Cleaning Sprints', 'slug' => 'cleaning'),
                        array('name' => 'Calendar Sync', 'slug' => 'calendar'),
                    ),
                ),
            ),
        ),
        array(
            'name' => 'Relationships',
            'slug' => 'relationships',
            'description' => 'Communication scripts, boundary-setting tools, and confidence-building exercises for healthier relationships.',
            'children' => array(
                array(
                    'name' => 'Communication',
                    'slug' => 'communication',
                    'children' => array(
                        array('name' => 'What to Say', 'slug' => 'what-to-say'),
                        array('name' => 'De-escalation', 'slug' => 'deescalation'),
                        array('name' => 'Workplace Boundaries', 'slug' => 'work-boundaries'),
                        array('name' => 'Text Templates', 'slug' => 'text-templates'),
                    ),
                ),
                array(
                    'name' => 'Marriage',
                    'slug' => 'marriage',
                    'children' => array(
                        array('name' => 'Connection Rituals', 'slug' => 'rituals'),
                        array('name' => 'Budgeting Together', 'slug' => 'budgeting-together'),
                        array('name' => 'Household Ops', 'slug' => 'household-ops'),
                        array('name' => 'Date Ideas', 'slug' => 'date-ideas'),
                    ),
                ),
                array(
                    'name' => 'Self-Worth',
                    'slug' => 'self-worth',
                    'children' => array(
                        array('name' => 'Boundaries 101', 'slug' => 'boundaries'),
                        array('name' => 'Confidence Habits', 'slug' => 'confidence'),
                        array('name' => 'Unlearning People-Pleasing', 'slug' => 'people-pleasing'),
                        array('name' => 'Journaling Prompts', 'slug' => 'journaling'),
                    ),
                ),
            ),
        ),
    );
}

/**
 * Seed categories (hubs and subhubs) idempotently
 * Now supports 3 levels: Hub → Subhub → Sub-pages
 * 
 * @param bool $refresh If true, update hub descriptions even if they exist
 * @return array Result with counts and any errors
 */
function rosalinda_child_seed_categories($refresh = false) {
    // Safety checks
    if (!taxonomy_exists('category')) {
        return array('error' => 'Category taxonomy does not exist');
    }
    
    $result = array(
        'hubs_created' => 0,
        'hubs_updated' => 0,
        'subhubs_created' => 0,
        'subhubs_updated' => 0,
        'subpages_created' => 0,
        'subpages_updated' => 0,
        'errors' => array(),
    );
    
    $category_map = rosalinda_child_get_category_map();
    
    foreach ($category_map as $hub) {
        try {
            // Check if hub exists
            $hub_term = term_exists($hub['slug'], 'category');
            $hub_id = null;
            
            if (!$hub_term) {
                // Create hub
                $hub_term = wp_insert_term($hub['name'], 'category', array(
                    'slug' => $hub['slug'],
                    'description' => rosalinda_child_build_hub_description($hub['name'], $hub['description'], $hub['slug']),
                ));
                
                if (is_wp_error($hub_term)) {
                    $result['errors'][] = 'Hub ' . $hub['slug'] . ': ' . $hub_term->get_error_message();
                    continue;
                }
                
                $hub_id = $hub_term['term_id'];
                $result['hubs_created']++;
            } else {
                // Hub exists
                $hub_id = is_array($hub_term) ? $hub_term['term_id'] : $hub_term;
                
                // Update description if refresh requested or if empty
                $existing_term = get_term($hub_id, 'category');
                if ($refresh || empty($existing_term->description)) {
                    wp_update_term($hub_id, 'category', array(
                        'description' => rosalinda_child_build_hub_description($hub['name'], $hub['description'], $hub['slug']),
                    ));
                    $result['hubs_updated']++;
                }
            }
            
            // Create/update subhubs (level 2)
            if (!empty($hub['children']) && $hub_id) {
                foreach ($hub['children'] as $subhub) {
                    $subhub_slug = $hub['slug'] . '-' . $subhub['slug'];
                    $subhub_term = term_exists($subhub_slug, 'category');
                    $subhub_id = null;
                    
                    if (!$subhub_term) {
                        // Create subhub
                        $subhub_term = wp_insert_term($subhub['name'], 'category', array(
                            'slug' => $subhub_slug,
                            'parent' => $hub_id,
                            'description' => '', // Subhubs have no description
                        ));
                        
                        if (is_wp_error($subhub_term)) {
                            $result['errors'][] = 'Subhub ' . $subhub_slug . ': ' . $subhub_term->get_error_message();
                            continue;
                        } else {
                            $subhub_id = $subhub_term['term_id'];
                            $result['subhubs_created']++;
                        }
                    } else {
                        // Ensure parent is correct
                        $subhub_id = is_array($subhub_term) ? $subhub_term['term_id'] : $subhub_term;
                        wp_update_term($subhub_id, 'category', array(
                            'parent' => $hub_id,
                        ));
                        $result['subhubs_updated']++;
                    }
                    
                    // Create/update sub-pages (level 3)
                    if (!empty($subhub['children']) && $subhub_id) {
                        foreach ($subhub['children'] as $subpage) {
                            $subpage_slug = $subhub_slug . '-' . $subpage['slug'];
                            $subpage_term = term_exists($subpage_slug, 'category');
                            
                            if (!$subpage_term) {
                                // Create sub-page
                                $subpage_term = wp_insert_term($subpage['name'], 'category', array(
                                    'slug' => $subpage_slug,
                                    'parent' => $subhub_id,
                                    'description' => '',
                                ));
                                
                                if (is_wp_error($subpage_term)) {
                                    $result['errors'][] = 'Sub-page ' . $subpage_slug . ': ' . $subpage_term->get_error_message();
                                } else {
                                    $result['subpages_created']++;
                                }
                            } else {
                                // Ensure parent is correct
                                $subpage_id = is_array($subpage_term) ? $subpage_term['term_id'] : $subpage_term;
                                wp_update_term($subpage_id, 'category', array(
                                    'parent' => $subhub_id,
                                ));
                                $result['subpages_updated']++;
                            }
                        }
                    }
                }
            }
            
        } catch (Exception $e) {
            $result['errors'][] = 'Exception for hub ' . $hub['slug'] . ': ' . $e->getMessage();
            error_log('Rosalinda Child - Category seeding error: ' . $e->getMessage());
        }
    }
    
    // CRITICAL: Flush rewrite rules so WordPress recognizes the new category URLs
    flush_rewrite_rules();
    
    return $result;
}

/**
 * Build hub description using core Gutenberg blocks
 * Returns block HTML that will be styled by parent theme
 * 
 * @param string $hub_name Hub display name
 * @param string $intro_text Short description text
 * @param string $hub_slug Hub slug for shortcode
 * @return string Block HTML
 */
function rosalinda_child_build_hub_description($hub_name, $intro_text, $hub_slug) {
    $description = <<<HTML
<!-- wp:heading {"level":2} -->
<h2 class="wp-block-heading">{$hub_name}</h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>{$intro_text}</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p>[subhub_buttons term_slug="{$hub_slug}"]</p>
<!-- /wp:paragraph -->
HTML;
    
    return $description;
}

/**
 * Shortcode: [subhub_buttons]
 * Renders core Buttons block with outline style for child categories
 * Inherits all styling from parent theme
 * 
 * @param array $atts Shortcode attributes (term_id or term_slug)
 * @return string Buttons block HTML
 */
function rosalinda_child_subhub_buttons_shortcode($atts) {
    $atts = shortcode_atts(array(
        'term_id' => 0,
        'term_slug' => '',
    ), $atts);
    
    // Determine term ID
    $term_id = (int) $atts['term_id'];
    
    if (!$term_id && !empty($atts['term_slug'])) {
        $term = get_term_by('slug', $atts['term_slug'], 'category');
        if ($term && !is_wp_error($term)) {
            $term_id = $term->term_id;
        }
    }
    
    // If still no term_id, try to get from current query
    if (!$term_id && is_category()) {
        $term_id = get_queried_object_id();
    }
    
    if (!$term_id) {
        return '';
    }
    
    // Get child terms
    $child_terms = get_terms(array(
        'taxonomy' => 'category',
        'parent' => $term_id,
        'hide_empty' => false,
        'orderby' => 'name',
        'order' => 'ASC',
    ));
    
    if (empty($child_terms) || is_wp_error($child_terms)) {
        return '';
    }
    
    // Build buttons block HTML
    $buttons_html = '<!-- wp:buttons -->' . "\n";
    $buttons_html .= '<div class="wp-block-buttons">' . "\n";
    
    foreach ($child_terms as $term) {
        $term_link = esc_url(get_term_link($term));
        $term_name = esc_html($term->name);
        
        $buttons_html .= '<!-- wp:button {"className":"is-style-outline"} -->' . "\n";
        $buttons_html .= '<div class="wp-block-button is-style-outline">';
        $buttons_html .= '<a class="wp-block-button__link wp-element-button" href="' . $term_link . '">';
        $buttons_html .= $term_name;
        $buttons_html .= '</a>';
        $buttons_html .= '</div>' . "\n";
        $buttons_html .= '<!-- /wp:button -->' . "\n\n";
    }
    
    $buttons_html .= '</div>' . "\n";
    $buttons_html .= '<!-- /wp:buttons -->';
    
    return $buttons_html;
}
add_shortcode('subhub_buttons', 'rosalinda_child_subhub_buttons_shortcode');

/**
 * Enable shortcodes in category descriptions
 */
add_filter('term_description', 'do_shortcode');

/**
 * Run seeder on theme activation
 */
function rosalinda_child_seed_on_activation() {
    rosalinda_child_seed_categories(false);
}
add_action('after_switch_theme', 'rosalinda_child_seed_on_activation');

/**
 * WP-CLI command: wp smartlife seed-categories [--refresh]
 */
if (defined('WP_CLI') && WP_CLI) {
    WP_CLI::add_command('smartlife seed-categories', function($args, $assoc_args) {
        $refresh = isset($assoc_args['refresh']);
        
        WP_CLI::log('Starting category seeding...');
        if ($refresh) {
            WP_CLI::log('Refresh mode: will update existing hub descriptions');
        }
        
        $result = rosalinda_child_seed_categories($refresh);
        
        WP_CLI::success(sprintf(
            'Hubs: %d created, %d updated | Subhubs: %d created, %d updated',
            $result['hubs_created'],
            $result['hubs_updated'],
            $result['subhubs_created'],
            $result['subhubs_updated']
        ));
        
        if (!empty($result['errors'])) {
            WP_CLI::warning('Errors encountered:');
            foreach ($result['errors'] as $error) {
                WP_CLI::log('  - ' . $error);
            }
        }
    });
}

/* ==========================================================================
   Navigation Menu Auto-Creation
   Works with parent theme's existing menu system
   ========================================================================== */

/**
 * Programmatically create menus on theme activation
 * This uses the parent theme's existing menu location
 */
function rosalinda_child_create_menus() {
    // Check if menu already exists
    $primary_menu = wp_get_nav_menu_object('Primary Menu');
    
    if (!$primary_menu) {
        rosalinda_child_create_primary_menu();
    }
}
add_action('after_switch_theme', 'rosalinda_child_create_menus');

/**
 * MANUAL TRIGGER: Recreate menu (delete this after use)
 * Visit: yoursite.com/?recreate_menu=1 (while logged in as admin)
 */
function rosalinda_child_manual_menu_recreate() {
    if (isset($_GET['recreate_menu']) && current_user_can('manage_options')) {
        // Delete ALL existing menus
        $menus = wp_get_nav_menus();
        foreach ($menus as $menu) {
            wp_delete_nav_menu($menu->term_id);
        }
        
        // Create new menu
        rosalinda_child_create_primary_menu();
        
        // Show debug info
        $new_menu = wp_get_nav_menu_object('Primary Menu');
        if (!$new_menu) {
            wp_die('Error: Primary Menu was not created!');
        }
        
        $items = wp_get_nav_menu_items($new_menu->term_id);
        
        echo '<h2>Menu Created Successfully!</h2>';
        echo '<p>Menu ID: ' . $new_menu->term_id . '</p>';
        echo '<p>Total Items: ' . count($items) . '</p>';
        echo '<h3>Full Menu Structure:</h3><pre>';
        foreach ($items as $item) {
            $indent = $item->menu_item_parent ? '  ' : '';
            echo $indent . '- ' . $item->title . " (ID: {$item->ID}, Parent: {$item->menu_item_parent}, Type: {$item->type})\n";
            echo $indent . '  URL: ' . $item->url . "\n";
        }
        echo '</pre>';
        
        echo '<h3>Menu Assignments:</h3>';
        $locations = get_nav_menu_locations();
        echo '<pre>';
        print_r($locations);
        echo '</pre>';
        
        echo '<p><a href="' . admin_url('nav-menus.php') . '">View Menus in Admin</a> | <a href="' . home_url() . '">View Site</a></p>';
        
        wp_die();
    }
}
add_action('init', 'rosalinda_child_manual_menu_recreate');

/**
 * MANUAL TRIGGER: Seed categories (delete this after use)
 * Visit: yoursite.com/?seed_categories=1 (while logged in as admin)
 */
function rosalinda_child_manual_category_seed() {
    if (isset($_GET['seed_categories']) && current_user_can('manage_options')) {
        $refresh = isset($_GET['refresh']);
        
        echo '<h2>Seeding Categories...</h2>';
        if ($refresh) {
            echo '<p>Refresh mode: updating existing hub descriptions</p>';
        }
        
        $result = rosalinda_child_seed_categories($refresh);
        
        echo '<h3>Results:</h3>';
        echo '<ul>';
        echo '<li>Hubs created: ' . $result['hubs_created'] . '</li>';
        echo '<li>Hubs updated: ' . $result['hubs_updated'] . '</li>';
        echo '<li>Subhubs created: ' . $result['subhubs_created'] . '</li>';
        echo '<li>Subhubs updated: ' . $result['subhubs_updated'] . '</li>';
        echo '</ul>';
        
        if (!empty($result['errors'])) {
            echo '<h3>Errors:</h3><ul>';
            foreach ($result['errors'] as $error) {
                echo '<li>' . esc_html($error) . '</li>';
            }
            echo '</ul>';
        }
        
        // Show created categories
        echo '<h3>Hub Categories:</h3><ul>';
        foreach (rosalinda_child_get_category_map() as $hub) {
            $term = get_term_by('slug', $hub['slug'], 'category');
            if ($term) {
                echo '<li><strong>' . $term->name . '</strong> - <a href="' . get_term_link($term) . '">' . get_term_link($term) . '</a>';
                if (!empty($hub['children'])) {
                    echo '<ul>';
                    foreach ($hub['children'] as $subhub) {
                        $subhub_slug = $hub['slug'] . '-' . $subhub['slug'];
                        $subterm = get_term_by('slug', $subhub_slug, 'category');
                        if ($subterm) {
                            echo '<li>' . $subterm->name . ' - <a href="' . get_term_link($subterm) . '">' . get_term_link($subterm) . '</a></li>';
                        }
                    }
                    echo '</ul>';
                }
                echo '</li>';
            }
        }
        echo '</ul>';
        
        echo '<p><a href="' . admin_url('edit-tags.php?taxonomy=category') . '">View Categories in Admin</a> | <a href="' . home_url() . '">View Site</a></p>';
        
        wp_die();
    }
}
add_action('init', 'rosalinda_child_manual_category_seed');

/**
 * DEBUG: Check menu items (delete this after use)
 * Visit: yoursite.com/?check_menu=1 (while logged in as admin)
 */
function rosalinda_child_debug_menu() {
    if (isset($_GET['check_menu']) && current_user_can('manage_options')) {
        $primary_menu = wp_get_nav_menu_object('Primary Menu');
        
        echo '<h2>Menu Debug Info</h2>';
        echo '<pre>';
        echo "Menu Object:\n";
        print_r($primary_menu);
        
        if ($primary_menu) {
            $menu_items = wp_get_nav_menu_items($primary_menu->term_id);
            echo "\n\nMenu Items (" . count($menu_items) . " total):\n";
            foreach ($menu_items as $item) {
                echo "- " . str_repeat('  ', $item->menu_item_parent ? 1 : 0) . $item->title . " (ID: {$item->ID}, Parent: {$item->menu_item_parent})\n";
            }
        }
        
        echo "\n\nMenu Locations:\n";
        $locations = get_nav_menu_locations();
        print_r($locations);
        
        echo '</pre>';
        echo '<p><a href="' . admin_url('nav-menus.php') . '">View Menus</a> | <a href="' . home_url() . '">View Site</a></p>';
        wp_die();
    }
}
add_action('init', 'rosalinda_child_debug_menu');

/**
 * Create Primary Menu with full 3-level hierarchy
 * Links to actual category pages created by the seeder
 * Assigns to parent theme's menu location
 */
function rosalinda_child_create_primary_menu() {
    // Create menu
    $menu_id = wp_create_nav_menu('Primary Menu');
    
    if (is_wp_error($menu_id)) {
        return;
    }
    
    // Build menu from category map
    $category_map = rosalinda_child_get_category_map();
    
    foreach ($category_map as $hub) {
        // Get hub category
        $hub_term = get_term_by('slug', $hub['slug'], 'category');
        if (!$hub_term || is_wp_error($hub_term)) {
            continue;
        }
        
        // Add hub to menu
        $hub_menu_item_id = wp_update_nav_menu_item($menu_id, 0, array(
            'menu-item-title' => $hub_term->name,
            'menu-item-url' => get_term_link($hub_term),
            'menu-item-object-id' => $hub_term->term_id,
            'menu-item-object' => 'category',
            'menu-item-type' => 'taxonomy',
            'menu-item-status' => 'publish',
        ));
        
        // Add subhubs under this hub (level 2)
        if (!empty($hub['children']) && !is_wp_error($hub_menu_item_id)) {
            foreach ($hub['children'] as $subhub) {
                $subhub_slug = $hub['slug'] . '-' . $subhub['slug'];
                $subhub_term = get_term_by('slug', $subhub_slug, 'category');
                
                if ($subhub_term && !is_wp_error($subhub_term)) {
                    $subhub_menu_item_id = wp_update_nav_menu_item($menu_id, 0, array(
                        'menu-item-title' => $subhub_term->name,
                        'menu-item-url' => get_term_link($subhub_term),
                        'menu-item-object-id' => $subhub_term->term_id,
                        'menu-item-object' => 'category',
                        'menu-item-type' => 'taxonomy',
                        'menu-item-status' => 'publish',
                        'menu-item-parent-id' => $hub_menu_item_id,
                    ));
                    
                    // Add sub-pages under this subhub (level 3)
                    if (!empty($subhub['children']) && !is_wp_error($subhub_menu_item_id)) {
                        foreach ($subhub['children'] as $subpage) {
                            $subpage_slug = $subhub_slug . '-' . $subpage['slug'];
                            $subpage_term = get_term_by('slug', $subpage_slug, 'category');
                            
                            if ($subpage_term && !is_wp_error($subpage_term)) {
                                wp_update_nav_menu_item($menu_id, 0, array(
                                    'menu-item-title' => $subpage_term->name,
                                    'menu-item-url' => get_term_link($subpage_term),
                                    'menu-item-object-id' => $subpage_term->term_id,
                                    'menu-item-object' => 'category',
                                    'menu-item-type' => 'taxonomy',
                                    'menu-item-status' => 'publish',
                                    'menu-item-parent-id' => $subhub_menu_item_id,
                                ));
                            }
                        }
                    }
                }
            }
        }
    }
    
    // Assign to parent theme's primary menu location
    $locations = get_theme_mod('nav_menu_locations');
    if (!is_array($locations)) {
        $locations = array();
    }
    $locations['menu_main'] = $menu_id;
    set_theme_mod('nav_menu_locations', $locations);
}

/* ==========================================================================
   Performance & Security
   ========================================================================== */

/**
 * Example: Optimize WordPress for performance
 */
/*
function rosalinda_child_optimize_wp() {
    // Remove unnecessary WordPress features
    remove_action('wp_head', 'rsd_link');
    remove_action('wp_head', 'wlwmanifest_link');
    remove_action('wp_head', 'wp_generator');
    remove_action('wp_head', 'start_post_rel_link');
    remove_action('wp_head', 'index_rel_link');
    remove_action('wp_head', 'adjacent_posts_rel_link');
}
add_action('init', 'rosalinda_child_optimize_wp');
*/