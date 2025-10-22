<?php
/**
 * Single post template - Child theme override
 * Detects cooking posts and loads recipe template
 * 
 * @package SmartLife Child
 */

defined('ABSPATH') || exit;

// Check if this post is in a Cooking category
$is_cooking_post = false;
$categories = get_the_category();

foreach ($categories as $category) {
    if ($category->slug === 'cooking') {
        $is_cooking_post = true;
        break;
    }
    
    // Check if it's a child of cooking category
    $parent_cat = $category;
    while ($parent_cat->parent != 0) {
        $parent_cat = get_category($parent_cat->parent);
        if ($parent_cat && $parent_cat->slug === 'cooking') {
            $is_cooking_post = true;
            break 2;
        }
    }
}

// If it's a cooking post, load recipe template
if ($is_cooking_post) {
    get_header(); ?>
    
    <div class="page_content_wrap">
        <div class="content_wrap">
            <div class="content">
                <article class="post_item_single">
                    <?php
                    while (have_posts()) : the_post();
                        // Include our recipe content template
                        include(get_stylesheet_directory() . '/template-parts/recipe/content.php');
                    endwhile;
                    ?>
                </article>
            </div>
        </div>
    </div>
    
    <?php get_footer();
    return;
}

// For non-cooking posts, use parent theme template
include(get_template_directory() . '/single.php');