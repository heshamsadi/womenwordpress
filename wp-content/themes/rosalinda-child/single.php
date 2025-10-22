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

// If it's a cooking post, load recipe template (with variant routing)
if ($is_cooking_post) {
    get_header();
    ?>
    <div class="page_content_wrap">
        <div class="content_wrap">
            <div class="content">
                <?php
                while (have_posts()) : the_post();
                        $variant = get_post_meta(get_the_ID(), '_template_variant', true);
                        if (empty($variant)) { $variant = 'u1'; }

                        // Allowed variants
                        $allowed = array('u1','v2','v3','v5');
                        if (!in_array($variant, $allowed, true)) { $variant = 'u1'; }

                        switch ($variant) {
                            case 'v2':
                                $path = get_stylesheet_directory() . '/template-parts/recipe/content-v2-time-temp.php';
                                break;
                            case 'v3':
                                $path = get_stylesheet_directory() . '/template-parts/recipe/content-v3-5ing.php';
                                break;
                            case 'v5':
                                $path = get_stylesheet_directory() . '/template-parts/recipe/content-v5-howto.php';
                                break;
                            default:
                                $path = get_stylesheet_directory() . '/template-parts/recipe/content.php';
                        }

                        if (file_exists($path)) {
                            include $path;
                        } else {
                            include get_stylesheet_directory() . '/template-parts/recipe/content.php';
                        }
                    endwhile;
                ?>
            </div>
        </div>
    </div>
    <?php
    get_footer();
    return;
}


// For non-cooking posts, use parent theme template
include(get_template_directory() . '/single.php');