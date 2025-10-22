<?php
/**
 * Recipe single post template
 * Loads for posts in Cooking categories
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

// If not a cooking post, use default template
if (!$is_cooking_post) {
    include(get_template_directory() . '/single.php');
    return;
}

get_header(); ?>

<div class="container">
    <div class="grid">
        <?php
        while (have_posts()) : the_post();
            get_template_part('template-parts/recipe/content');
        endwhile;
        ?>
    </div>
</div>

<?php get_footer(); ?>