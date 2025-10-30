<?php
/**
 * Single Recipe Template (Dishes CPT)
 * 
 * This template overrides the default single post template for cpt_dishes
 * Implements a clean, professional recipe layout with structured data
 * 
 * @package Rosalinda_Child
 * @since 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

while ( have_posts() ) :
	the_post();
	
	// Get recipe meta data
	$post_id = get_the_ID();
	$meta = get_post_meta( $post_id, 'trx_addons_options', true );
	
	// Extract meta fields with fallbacks
	$prep_time = rosalinda_child_get_recipe_meta( $post_id, 'prep_time', '' );
	$cook_time = rosalinda_child_get_recipe_meta( $post_id, 'time', '' );
	$servings = rosalinda_child_get_recipe_meta( $post_id, 'servings', '' );
	$difficulty = rosalinda_child_get_recipe_meta( $post_id, 'difficulty', '' );
	$calories = rosalinda_child_get_recipe_meta( $post_id, 'calories', '' );
	$ingredients = rosalinda_child_get_recipe_meta( $post_id, 'ingredients', '' );
	$nutritions = rosalinda_child_get_recipe_meta( $post_id, 'nutritions', '' );
	$dietary_tags = rosalinda_child_get_recipe_meta( $post_id, 'dietary_tags', '' );
	$cuisine = rosalinda_child_get_recipe_meta( $post_id, 'cuisine', '' );
	$course = rosalinda_child_get_recipe_meta( $post_id, 'course', '' );
	$spicy = rosalinda_child_get_recipe_meta( $post_id, 'spicy', '' );
	
	?>
	
	<article id="recipe-<?php the_ID(); ?>" <?php post_class( 'rc-recipe' ); ?>>
		
		<!-- Recipe Header -->
		<header class="rc-recipe__header">
			<h1 class="rc-recipe__title"><?php the_title(); ?></h1>
			
			<!-- Recipe Meta Facts -->
			<div class="rc-recipe__meta">
				<?php
				// Prep Time
				if ( ! empty( $prep_time ) ) {
					rosalinda_child_display_recipe_time( 'Prep', $prep_time, '⏱️' );
				}
				
				// Cook Time
				if ( ! empty( $cook_time ) ) {
					rosalinda_child_display_recipe_time( 'Cook', $cook_time, '🔥' );
				}
				
				// Servings
				if ( ! empty( $servings ) ) {
					echo '<span class="rc-recipe__meta-item">';
					echo '<span class="rc-recipe__meta-icon">🍽️</span> ';
					echo '<span class="rc-recipe__meta-label">Servings:</span> ';
					echo '<span class="rc-recipe__meta-value">' . esc_html( $servings ) . '</span>';
					echo '</span>';
				}
				
				// Difficulty
				if ( ! empty( $difficulty ) ) {
					echo '<span class="rc-recipe__meta-item">';
					echo '<span class="rc-recipe__meta-icon">📊</span> ';
					echo '<span class="rc-recipe__meta-label">Difficulty:</span> ';
					echo '<span class="rc-recipe__meta-value">' . esc_html( $difficulty ) . '</span>';
					echo '</span>';
				}
				
				// Cuisine
				if ( ! empty( $cuisine ) ) {
					echo '<span class="rc-recipe__meta-item">';
					echo '<span class="rc-recipe__meta-icon">🌍</span> ';
					echo '<span class="rc-recipe__meta-label">Cuisine:</span> ';
					echo '<span class="rc-recipe__meta-value">' . esc_html( $cuisine ) . '</span>';
					echo '</span>';
				}
				
				// Course
				if ( ! empty( $course ) ) {
					echo '<span class="rc-recipe__meta-item">';
					echo '<span class="rc-recipe__meta-icon">🍴</span> ';
					echo '<span class="rc-recipe__meta-label">Course:</span> ';
					echo '<span class="rc-recipe__meta-value">' . esc_html( $course ) . '</span>';
					echo '</span>';
				}
				
				// Spicy Level
				if ( ! empty( $spicy ) && $spicy > 0 ) {
					echo '<span class="rc-recipe__meta-item">';
					echo '<span class="rc-recipe__meta-icon">🌶️</span> ';
					echo '<span class="rc-recipe__meta-label">Spicy:</span> ';
					echo '<span class="rc-recipe__meta-value">' . str_repeat( '🔥', intval( $spicy ) ) . '</span>';
					echo '</span>';
				}
				?>
			</div>
			
			<!-- Featured Image -->
			<?php if ( has_post_thumbnail() ) : ?>
				<div class="rc-recipe__image">
					<?php 
					the_post_thumbnail( 
						'large', 
						array( 
							'alt' => get_the_title(),
							'itemprop' => 'image'
						) 
					); 
					?>
				</div>
			<?php endif; ?>
			
			<!-- Recipe Description (Excerpt) -->
			<?php if ( has_excerpt() ) : ?>
				<div class="rc-recipe__description">
					<?php the_excerpt(); ?>
				</div>
			<?php endif; ?>
		</header>
		
		<!-- Recipe Details Grid: Ingredients + Nutrition -->
		<div class="rc-recipe__details-grid">
			
			<!-- Ingredients Section -->
			<div class="rc-recipe__section rc-recipe__ingredients">
				<h2 class="rc-recipe__section-title">Ingredients</h2>
				
				<?php if ( ! empty( $ingredients ) ) : ?>
					<ul class="rc-recipe__ingredients-list">
						<?php
						// Split ingredients by line break
						$ingredients_array = array_filter( array_map( 'trim', explode( "\n", $ingredients ) ) );
						
						foreach ( $ingredients_array as $ingredient ) {
							if ( ! empty( $ingredient ) ) {
								echo '<li>' . esc_html( $ingredient ) . '</li>';
							}
						}
						
						// Fallback if no ingredients
						if ( empty( $ingredients_array ) ) {
							echo '<li><em>No ingredients listed</em></li>';
						}
						?>
					</ul>
				<?php else : ?>
					<p><em>Ingredients to be added.</em></p>
				<?php endif; ?>
			</div>
			
			<!-- Nutrition Facts Section -->
			<div class="rc-recipe__section rc-recipe__nutrition">
				<h2 class="rc-recipe__section-title">Nutrition Facts</h2>
				
				<!-- Calories Highlight -->
				<?php if ( ! empty( $calories ) ) : ?>
					<div class="rc-recipe__calories">
						<strong>Calories:</strong> <?php echo esc_html( $calories ); ?>
					</div>
				<?php endif; ?>
				
				<!-- Additional Nutrition Info -->
				<?php if ( ! empty( $nutritions ) ) : ?>
					<ul class="rc-recipe__nutrition-list">
						<?php
						// Split nutrition info by line break
						$nutrition_array = array_filter( array_map( 'trim', explode( "\n", $nutritions ) ) );
						
						foreach ( $nutrition_array as $nutrition_item ) {
							if ( ! empty( $nutrition_item ) ) {
								// Check if it contains a colon (e.g., "Protein: 25g")
								if ( strpos( $nutrition_item, ':' ) !== false ) {
									list( $label, $value ) = explode( ':', $nutrition_item, 2 );
									echo '<li><strong>' . esc_html( trim( $label ) ) . ':</strong> ' . esc_html( trim( $value ) ) . '</li>';
								} else {
									echo '<li>' . esc_html( $nutrition_item ) . '</li>';
								}
							}
						}
						?>
					</ul>
				<?php else : ?>
					<p><em>Nutritional information not available.</em></p>
				<?php endif; ?>
			</div>
			
		</div><!-- .rc-recipe__details-grid -->
		
		<!-- Recipe Instructions -->
		<div class="rc-recipe__section rc-recipe__instructions">
			<h2 class="rc-recipe__section-title">Instructions</h2>
			
			<div class="rc-recipe__content">
				<?php
				// Display post content (supports Gutenberg blocks)
				the_content();
				
				// Pagination for multi-page recipes
				wp_link_pages(
					array(
						'before'      => '<div class="page-links"><span class="page-links-title">' . esc_html__( 'Pages:', 'rosalinda-child' ) . '</span>',
						'after'       => '</div>',
						'link_before' => '<span>',
						'link_after'  => '</span>',
					)
				);
				?>
			</div>
		</div>
		
		<!-- Dietary Tags -->
		<?php if ( ! empty( $dietary_tags ) ) : ?>
			<div class="rc-recipe__tags">
				<strong>Dietary Info:</strong> <?php echo esc_html( $dietary_tags ); ?>
			</div>
		<?php endif; ?>
		
		<!-- Print Button -->
		<button class="rc-recipe__print-btn" onclick="window.print()">
			<span>🖨️</span>
			<span>Print Recipe</span>
		</button>
		
		<!-- Social Share -->
		<?php if ( function_exists( 'rosalinda_show_share_links' ) ) : ?>
			<div class="rc-recipe__share">
				<?php
				rosalinda_show_share_links(
					array(
						'type'    => 'block',
						'caption' => 'Share this recipe:',
						'before'  => '<div class="post_meta_item post_share">',
						'after'   => '</div>',
					)
				);
				?>
			</div>
		<?php endif; ?>
		
		<!-- Post Meta (Tags/Categories from parent theme) -->
		<?php
		do_action( 'rosalinda_action_after_post_content' );
		?>
		
	</article><!-- .rc-recipe -->
	
	<?php
	// Author Bio (if enabled in theme options)
	if ( rosalinda_get_theme_option( 'show_author_info' ) == 1 
		&& ! is_attachment() 
		&& get_the_author_meta( 'description' ) ) {
		do_action( 'rosalinda_action_before_post_author' );
		get_template_part( apply_filters( 'rosalinda_filter_get_template_part', 'templates/author-bio' ) );
		do_action( 'rosalinda_action_after_post_author' );
	}
	
	// Related Recipes (using parent theme related posts)
	if ( rosalinda_get_theme_option( 'related_position' ) == 'below_content' ) {
		do_action( 'rosalinda_action_related_posts' );
	}
	
	// Comments
	if ( comments_open() || get_comments_number() ) {
		comments_template();
	}
	
endwhile;

get_footer();
