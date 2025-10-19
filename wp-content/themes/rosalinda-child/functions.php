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
 * Enqueue child theme styles
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
        $items = wp_get_nav_menu_items($new_menu->term_id);
        
        echo '<h2>Menu Created Successfully!</h2>';
        echo '<p>Menu ID: ' . $new_menu->term_id . '</p>';
        echo '<p>Total Items: ' . count($items) . '</p>';
        echo '<h3>Menu Structure (first 20 items):</h3><pre>';
        foreach (array_slice($items, 0, 20) as $item) {
            $indent = $item->menu_item_parent ? '  ' : '';
            echo $indent . '- ' . $item->title . " (ID: {$item->ID}, Parent: {$item->menu_item_parent})\n";
        }
        echo '</pre>';
        echo '<p><a href="' . admin_url('nav-menus.php') . '">View Menus in Admin</a> | <a href="' . home_url() . '">View Site</a></p>';
        
        wp_die();
    }
}
add_action('init', 'rosalinda_child_manual_menu_recreate');

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
 * Create Primary Menu with full hierarchy
 * Assigns to parent theme's menu location
 */
function rosalinda_child_create_primary_menu() {
    // Create menu
    $menu_id = wp_create_nav_menu('Primary Menu');
    
    if (is_wp_error($menu_id)) {
        return;
    }
    
    // Menu structure
    $menu_structure = array(
        // Health Hub
        array(
            'title' => 'Health',
            'url' => '/health/',
            'children' => array(
                array(
                    'title' => 'Nutrition',
                    'url' => '/health/nutrition/',
                    'children' => array(
                        array('title' => 'Meal Plans', 'url' => '/health/nutrition/meal-plans/'),
                        array('title' => 'Micronutrients 101', 'url' => '/health/nutrition/micronutrients/'),
                        array('title' => 'Hydration & Electrolytes', 'url' => '/health/nutrition/hydration/'),
                        array('title' => 'Food-First Guides', 'url' => '/health/nutrition/food-first/'),
                    )
                ),
                array(
                    'title' => 'Cycle Care',
                    'url' => '/health/cycle-care/',
                    'children' => array(
                        array('title' => 'Phase Guides', 'url' => '/health/cycle-care/phase-guides/'),
                        array('title' => 'Workout Syncing', 'url' => '/health/cycle-care/workout-sync/'),
                        array('title' => 'Symptom Care (education)', 'url' => '/health/cycle-care/symptom-care/'),
                        array('title' => 'Calendar & Tracker', 'url' => '/health/cycle-care/tracker/'),
                    )
                ),
                array(
                    'title' => 'Sleep & Stress',
                    'url' => '/health/sleep-stress/',
                    'children' => array(
                        array('title' => 'Sleep Habits', 'url' => '/health/sleep-stress/sleep-habits/'),
                        array('title' => 'Evening Routines', 'url' => '/health/sleep-stress/evening-routines/'),
                        array('title' => 'Stress Scripts', 'url' => '/health/sleep-stress/stress-scripts/'),
                        array('title' => 'Breathing & Micro-breaks', 'url' => '/health/sleep-stress/breathing/'),
                    )
                ),
            )
        ),
        // Beauty Hub
        array(
            'title' => 'Beauty',
            'url' => '/beauty/',
            'children' => array(
                array(
                    'title' => 'Skincare',
                    'url' => '/beauty/skincare/',
                    'children' => array(
                        array('title' => 'Routines (AM/PM)', 'url' => '/beauty/skincare/routines/'),
                        array('title' => 'Ingredients 101', 'url' => '/beauty/skincare/ingredients/'),
                        array('title' => 'Concern Guides', 'url' => '/beauty/skincare/concerns/'),
                        array('title' => 'SPF & Sun Care', 'url' => '/beauty/skincare/spf/'),
                    )
                ),
                array(
                    'title' => 'Haircare',
                    'url' => '/beauty/haircare/',
                    'children' => array(
                        array('title' => 'Wash Day Maps', 'url' => '/beauty/haircare/wash-day/'),
                        array('title' => 'Curl Types 2A–4C', 'url' => '/beauty/haircare/curl-types/'),
                        array('title' => 'Protective Styling', 'url' => '/beauty/haircare/protective-styles/'),
                        array('title' => 'Scalp Care', 'url' => '/beauty/haircare/scalp/'),
                    )
                ),
                array(
                    'title' => 'Makeup',
                    'url' => '/beauty/makeup/',
                    'children' => array(
                        array('title' => '5-Minute Looks', 'url' => '/beauty/makeup/fast-looks/'),
                        array('title' => 'Base & Complexion', 'url' => '/beauty/makeup/base/'),
                        array('title' => 'Eyes & Lips', 'url' => '/beauty/makeup/eyes-lips/'),
                        array('title' => 'Tools & Hygiene', 'url' => '/beauty/makeup/tools/'),
                    )
                ),
            )
        ),
        // Fitness Hub
        array(
            'title' => 'Fitness',
            'url' => '/fitness/',
            'children' => array(
                array(
                    'title' => 'Beginner',
                    'url' => '/fitness/beginner/',
                    'children' => array(
                        array('title' => 'Full-Body Basics', 'url' => '/fitness/beginner/full-body/'),
                        array('title' => 'No-Equipment Plans', 'url' => '/fitness/beginner/no-equipment/'),
                        array('title' => 'Form 101', 'url' => '/fitness/beginner/form-101/'),
                        array('title' => 'Mobility Reset', 'url' => '/fitness/beginner/mobility/'),
                    )
                ),
                array(
                    'title' => 'Postpartum',
                    'url' => '/fitness/postpartum/',
                    'children' => array(
                        array('title' => 'Core Basics', 'url' => '/fitness/postpartum/core-basics/'),
                        array('title' => 'Gentle Progressions', 'url' => '/fitness/postpartum/progressions/'),
                        array('title' => 'Time-Saver Workouts', 'url' => '/fitness/postpartum/time-savers/'),
                        array('title' => 'Return-to-Movement Checklist', 'url' => '/fitness/postpartum/checklist/'),
                    )
                ),
                array(
                    'title' => '40-Plus',
                    'url' => '/fitness/40-plus/',
                    'children' => array(
                        array('title' => 'Strength Focus', 'url' => '/fitness/40-plus/strength/'),
                        array('title' => 'Mobility & Balance', 'url' => '/fitness/40-plus/mobility/'),
                        array('title' => 'Joint-Friendly Sessions', 'url' => '/fitness/40-plus/joint-friendly/'),
                        array('title' => 'Recovery & Sleep', 'url' => '/fitness/40-plus/recovery/'),
                    )
                ),
            )
        ),
        // Money & Career Hub
        array(
            'title' => 'Money & Career',
            'url' => '/money-career/',
            'children' => array(
                array(
                    'title' => 'Budgeting',
                    'url' => '/money-career/budgeting/',
                    'children' => array(
                        array('title' => 'Starter Budget', 'url' => '/money-career/budgeting/starter/'),
                        array('title' => 'Zero-Based System', 'url' => '/money-career/budgeting/zero-based/'),
                        array('title' => 'Templates & Sheets', 'url' => '/money-career/budgeting/templates/'),
                        array('title' => 'Automations', 'url' => '/money-career/budgeting/automation/'),
                    )
                ),
                array(
                    'title' => 'Side Hustles',
                    'url' => '/money-career/side-hustles/',
                    'children' => array(
                        array('title' => 'Idea Matrix', 'url' => '/money-career/side-hustles/ideas/'),
                        array('title' => 'Skill Matching', 'url' => '/money-career/side-hustles/skill-match/'),
                        array('title' => 'Setup Guides', 'url' => '/money-career/side-hustles/setup/'),
                        array('title' => 'Basics & Taxes (info)', 'url' => '/money-career/side-hustles/basics/'),
                    )
                ),
                array(
                    'title' => 'Salary Growth',
                    'url' => '/money-career/salary-growth/',
                    'children' => array(
                        array('title' => 'Market Research', 'url' => '/money-career/salary-growth/research/'),
                        array('title' => 'Raise Scripts', 'url' => '/money-career/salary-growth/raise-scripts/'),
                        array('title' => 'Interview Prep', 'url' => '/money-career/salary-growth/interview/'),
                        array('title' => 'Portfolio & LinkedIn', 'url' => '/money-career/salary-growth/brand/'),
                    )
                ),
            )
        ),
        // Home & Parenting Hub
        array(
            'title' => 'Home & Parenting',
            'url' => '/home-parenting/',
            'children' => array(
                array(
                    'title' => 'New Mom',
                    'url' => '/home-parenting/new-mom/',
                    'children' => array(
                        array('title' => 'First 12 Weeks', 'url' => '/home-parenting/new-mom/first-12-weeks/'),
                        array('title' => 'Logs & Routines', 'url' => '/home-parenting/new-mom/logs/'),
                        array('title' => 'Gear Checklists', 'url' => '/home-parenting/new-mom/checklists/'),
                        array('title' => 'Support Scripts', 'url' => '/home-parenting/new-mom/support-scripts/'),
                    )
                ),
                array(
                    'title' => 'Meal Prep',
                    'url' => '/home-parenting/meal-prep/',
                    'children' => array(
                        array('title' => '30-Minute Meals', 'url' => '/home-parenting/meal-prep/30-minute/'),
                        array('title' => 'Weekly Plans', 'url' => '/home-parenting/meal-prep/weekly-plans/'),
                        array('title' => 'Shopping Lists', 'url' => '/home-parenting/meal-prep/shopping-lists/'),
                        array('title' => 'Storage & Reheat', 'url' => '/home-parenting/meal-prep/storage/'),
                    )
                ),
                array(
                    'title' => 'Family Organization',
                    'url' => '/home-parenting/family-organization/',
                    'children' => array(
                        array('title' => 'Command Center', 'url' => '/home-parenting/family-organization/command-center/'),
                        array('title' => 'Routines & Charts', 'url' => '/home-parenting/family-organization/routines/'),
                        array('title' => 'Cleaning Sprints', 'url' => '/home-parenting/family-organization/cleaning/'),
                        array('title' => 'Calendar Sync', 'url' => '/home-parenting/family-organization/calendar/'),
                    )
                ),
            )
        ),
        // Relationships Hub
        array(
            'title' => 'Relationships',
            'url' => '/relationships/',
            'children' => array(
                array(
                    'title' => 'Communication',
                    'url' => '/relationships/communication/',
                    'children' => array(
                        array('title' => 'What to Say…', 'url' => '/relationships/communication/what-to-say/'),
                        array('title' => 'De-escalation', 'url' => '/relationships/communication/deescalation/'),
                        array('title' => 'Workplace Boundaries', 'url' => '/relationships/communication/work-boundaries/'),
                        array('title' => 'Text Templates', 'url' => '/relationships/communication/text-templates/'),
                    )
                ),
                array(
                    'title' => 'Marriage',
                    'url' => '/relationships/marriage/',
                    'children' => array(
                        array('title' => 'Connection Rituals', 'url' => '/relationships/marriage/rituals/'),
                        array('title' => 'Budgeting Together', 'url' => '/relationships/marriage/budgeting/'),
                        array('title' => 'Household Ops', 'url' => '/relationships/marriage/household-ops/'),
                        array('title' => 'Date Ideas', 'url' => '/relationships/marriage/date-ideas/'),
                    )
                ),
                array(
                    'title' => 'Self-Worth',
                    'url' => '/relationships/self-worth/',
                    'children' => array(
                        array('title' => 'Boundaries 101', 'url' => '/relationships/self-worth/boundaries/'),
                        array('title' => 'Confidence Habits', 'url' => '/relationships/self-worth/confidence/'),
                        array('title' => 'Unlearning People-Pleasing', 'url' => '/relationships/self-worth/people-pleasing/'),
                        array('title' => 'Journaling Prompts', 'url' => '/relationships/self-worth/journaling/'),
                    )
                ),
            )
        ),
    );
    
    // Create menu items recursively
    rosalinda_child_add_menu_items($menu_id, $menu_structure);
    
    // Assign to parent theme's primary menu location
    $locations = get_theme_mod('nav_menu_locations');
    if (!is_array($locations)) {
        $locations = array();
    }
    $locations['menu_main'] = $menu_id; // Parent theme's main menu location
    set_theme_mod('nav_menu_locations', $locations);
}

/**
 * Recursively add menu items
 */
function rosalinda_child_add_menu_items($menu_id, $items, $parent_id = 0) {
    foreach ($items as $item) {
        $item_id = wp_update_nav_menu_item($menu_id, 0, array(
            'menu-item-title'       => $item['title'],
            'menu-item-url'         => home_url($item['url']),
            'menu-item-status'      => 'publish',
            'menu-item-type'        => 'custom',
            'menu-item-parent-id'   => $parent_id
        ));
        
        // Add children if they exist
        if (!empty($item['children']) && !is_wp_error($item_id)) {
            rosalinda_child_add_menu_items($menu_id, $item['children'], $item_id);
        }
    }
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