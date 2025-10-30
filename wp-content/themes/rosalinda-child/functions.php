<?php
/**
 * Rosalinda Child Theme Functions
 *
 * @package Rosalinda_Child
 * @since 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Theme Constants
 */
define( 'ROSALINDA_CHILD_VERSION', '1.0.0' );
define( 'ROSALINDA_CHILD_DIR', get_stylesheet_directory() );
define( 'ROSALINDA_CHILD_URI', get_stylesheet_directory_uri() );

/**
 * Enqueue Parent and Child Theme Styles
 * 
 * Priority 1000 ensures styles load after parent theme
 */
function rosalinda_child_enqueue_styles() {
	// Parent theme main stylesheet
	wp_enqueue_style(
		'rosalinda-parent-style',
		get_template_directory_uri() . '/style.css',
		array(),
		wp_get_theme( 'rosalinda' )->get( 'Version' )
	);
	
	// Child theme main stylesheet
	wp_enqueue_style(
		'rosalinda-child-style',
		get_stylesheet_directory_uri() . '/style.css',
		array( 'rosalinda-parent-style' ),
		ROSALINDA_CHILD_VERSION
	);
	
	// Recipe-specific styles (loaded on recipe pages and archives)
	if ( is_singular( TRX_ADDONS_CPT_DISHES_PT ) || is_post_type_archive( TRX_ADDONS_CPT_DISHES_PT ) ) {
		wp_enqueue_style(
			'rosalinda-child-recipe',
			get_stylesheet_directory_uri() . '/assets/css/recipe.css',
			array( 'rosalinda-child-style' ),
			ROSALINDA_CHILD_VERSION
		);
	}
}
add_action( 'wp_enqueue_scripts', 'rosalinda_child_enqueue_styles', 1000 );

/**
 * Helper: Convert minutes to ISO 8601 duration format
 * 
 * Used for recipe schema markup (prepTime, cookTime, totalTime)
 * 
 * @param int|string $minutes Number of minutes
 * @return string ISO 8601 duration (e.g., "PT30M")
 * 
 * @example rosalinda_child_minutes_to_iso8601( 45 ) returns "PT45M"
 * @example rosalinda_child_minutes_to_iso8601( "1 hour 30 min" ) returns "PT90M"
 */
function rosalinda_child_minutes_to_iso8601( $minutes ) {
	// Handle empty or invalid input
	if ( empty( $minutes ) ) {
		return '';
	}
	
	// Extract numeric value from string (e.g., "30 minutes" -> 30)
	if ( is_string( $minutes ) ) {
		// Try to extract hours and minutes
		$hours = 0;
		$mins = 0;
		
		// Match patterns like "1 hour 30 min", "2h 15m", "90 minutes"
		if ( preg_match( '/(\d+)\s*h(ou?r)?/i', $minutes, $hour_matches ) ) {
			$hours = intval( $hour_matches[1] );
		}
		if ( preg_match( '/(\d+)\s*m(in)?/i', $minutes, $min_matches ) ) {
			$mins = intval( $min_matches[1] );
		}
		
		// If no hours/minutes pattern found, try to extract plain number
		if ( $hours === 0 && $mins === 0 ) {
			preg_match( '/\d+/', $minutes, $matches );
			$mins = ! empty( $matches ) ? intval( $matches[0] ) : 0;
		}
		
		$total_minutes = ( $hours * 60 ) + $mins;
	} else {
		$total_minutes = intval( $minutes );
	}
	
	// Return empty string if no valid time found
	if ( $total_minutes <= 0 ) {
		return '';
	}
	
	// Convert to ISO 8601 duration format
	// PT = Period of Time, M = Minutes
	// Could be extended to support hours: PT1H30M
	if ( $total_minutes >= 60 ) {
		$hours = floor( $total_minutes / 60 );
		$mins = $total_minutes % 60;
		
		if ( $mins > 0 ) {
			return sprintf( 'PT%dH%dM', $hours, $mins );
		} else {
			return sprintf( 'PT%dH', $hours );
		}
	}
	
	return sprintf( 'PT%dM', $total_minutes );
}

/**
 * Helper: Get recipe meta field value safely
 * 
 * Retrieves value from trx_addons_options meta array with fallback
 * 
 * @param int $post_id Post ID
 * @param string $field_key Meta field key
 * @param mixed $default Default value if field is empty
 * @return mixed Field value or default
 */
function rosalinda_child_get_recipe_meta( $post_id, $field_key, $default = '' ) {
	$meta = get_post_meta( $post_id, 'trx_addons_options', true );
	
	if ( ! is_array( $meta ) || ! isset( $meta[ $field_key ] ) || empty( $meta[ $field_key ] ) ) {
		return $default;
	}
	
	return $meta[ $field_key ];
}

/**
 * Helper: Display recipe time with icon
 * 
 * @param string $label Label text (e.g., "Prep Time")
 * @param string $time Time value
 * @param string $icon Icon class or emoji
 * @return void
 */
function rosalinda_child_display_recipe_time( $label, $time, $icon = '⏱️' ) {
	if ( empty( $time ) ) {
		return;
	}
	
	echo '<span class="rc-recipe__meta-item rc-recipe__meta-time">';
	echo '<span class="rc-recipe__meta-icon">' . esc_html( $icon ) . '</span> ';
	echo '<span class="rc-recipe__meta-label">' . esc_html( $label ) . ':</span> ';
	echo '<span class="rc-recipe__meta-value">' . esc_html( $time ) . '</span>';
	echo '</span>';
}

/**
 * Theme Setup - Add child theme support and features
 */
function rosalinda_child_setup() {
	// Load child theme text domain for translations
	load_child_theme_textdomain( 'rosalinda-child', ROSALINDA_CHILD_DIR . '/languages' );
	
	// Add support for additional image sizes if needed
	// add_image_size( 'recipe-featured', 1200, 800, true );
}
add_action( 'after_setup_theme', 'rosalinda_child_setup', 11 );

/**
 * Generate Recipe JSON-LD Structured Data
 * 
 * Outputs schema.org Recipe markup for Google Rich Results
 * 
 * @param int $post_id Recipe post ID
 * @return array Recipe schema data
 */
function rosalinda_child_generate_recipe_schema( $post_id ) {
	// Get post data
	$post = get_post( $post_id );
	if ( ! $post ) {
		return array();
	}
	
	// Get recipe meta
	$prep_time = rosalinda_child_get_recipe_meta( $post_id, 'prep_time', '' );
	$cook_time = rosalinda_child_get_recipe_meta( $post_id, 'time', '' );
	$servings = rosalinda_child_get_recipe_meta( $post_id, 'servings', '' );
	$calories = rosalinda_child_get_recipe_meta( $post_id, 'calories', '' );
	$ingredients = rosalinda_child_get_recipe_meta( $post_id, 'ingredients', '' );
	$cuisine = rosalinda_child_get_recipe_meta( $post_id, 'cuisine', '' );
	$course = rosalinda_child_get_recipe_meta( $post_id, 'course', '' );
	
	// Fallback: if cook_time is empty but 'time' exists, use it
	if ( empty( $cook_time ) ) {
		$cook_time = rosalinda_child_get_recipe_meta( $post_id, 'cook_time', '' );
	}
	
	// Base schema structure
	$schema = array(
		'@context'    => 'https://schema.org',
		'@type'       => 'Recipe',
		'name'        => get_the_title( $post_id ),
		'datePublished' => get_the_date( 'c', $post_id ),
		'dateModified'  => get_the_modified_date( 'c', $post_id ),
	);
	
	// Author
	$author_id = $post->post_author;
	$schema['author'] = array(
		'@type' => 'Person',
		'name'  => get_the_author_meta( 'display_name', $author_id ),
	);
	
	// Description (excerpt or first 160 chars of content)
	$description = get_the_excerpt( $post_id );
	if ( empty( $description ) ) {
		$description = wp_trim_words( wp_strip_all_tags( $post->post_content ), 30, '...' );
	}
	if ( ! empty( $description ) ) {
		$schema['description'] = $description;
	}
	
	// Image
	if ( has_post_thumbnail( $post_id ) ) {
		$image_id = get_post_thumbnail_id( $post_id );
		$image_data = wp_get_attachment_image_src( $image_id, 'full' );
		if ( $image_data ) {
			$schema['image'] = array(
				'@type'  => 'ImageObject',
				'url'    => $image_data[0],
				'width'  => $image_data[1],
				'height' => $image_data[2],
			);
		}
	}
	
	// Recipe Ingredients (split by newline)
	if ( ! empty( $ingredients ) ) {
		$ingredients_array = array_filter( array_map( 'trim', explode( "\n", $ingredients ) ) );
		if ( ! empty( $ingredients_array ) ) {
			$schema['recipeIngredient'] = $ingredients_array;
		}
	}
	
	// Recipe Instructions (single HowToStep from content)
	$content = $post->post_content;
	if ( ! empty( $content ) ) {
		// Strip HTML and shortcodes for clean text
		$instructions_text = wp_strip_all_tags( strip_shortcodes( $content ) );
		$instructions_text = trim( $instructions_text );
		
		if ( ! empty( $instructions_text ) ) {
			$schema['recipeInstructions'] = array(
				array(
					'@type' => 'HowToStep',
					'text'  => $instructions_text,
				),
			);
		}
	}
	
	// Prep Time (ISO 8601 format)
	if ( ! empty( $prep_time ) ) {
		$prep_iso = rosalinda_child_minutes_to_iso8601( $prep_time );
		if ( ! empty( $prep_iso ) ) {
			$schema['prepTime'] = $prep_iso;
		}
	}
	
	// Cook Time (ISO 8601 format)
	if ( ! empty( $cook_time ) ) {
		$cook_iso = rosalinda_child_minutes_to_iso8601( $cook_time );
		if ( ! empty( $cook_iso ) ) {
			$schema['cookTime'] = $cook_iso;
		}
	}
	
	// Total Time (sum of prep + cook)
	if ( ! empty( $prep_time ) || ! empty( $cook_time ) ) {
		$prep_minutes = 0;
		$cook_minutes = 0;
		
		// Extract minutes from prep_time
		if ( ! empty( $prep_time ) ) {
			if ( is_numeric( $prep_time ) ) {
				$prep_minutes = intval( $prep_time );
			} else {
				preg_match( '/\d+/', $prep_time, $matches );
				$prep_minutes = ! empty( $matches ) ? intval( $matches[0] ) : 0;
			}
		}
		
		// Extract minutes from cook_time
		if ( ! empty( $cook_time ) ) {
			if ( is_numeric( $cook_time ) ) {
				$cook_minutes = intval( $cook_time );
			} else {
				preg_match( '/\d+/', $cook_time, $matches );
				$cook_minutes = ! empty( $matches ) ? intval( $matches[0] ) : 0;
			}
		}
		
		$total_minutes = $prep_minutes + $cook_minutes;
		if ( $total_minutes > 0 ) {
			$schema['totalTime'] = rosalinda_child_minutes_to_iso8601( $total_minutes );
		}
	}
	
	// Recipe Yield (servings)
	if ( ! empty( $servings ) ) {
		$schema['recipeYield'] = $servings;
	}
	
	// Recipe Category (course)
	if ( ! empty( $course ) ) {
		$schema['recipeCategory'] = $course;
	}
	
	// Recipe Cuisine
	if ( ! empty( $cuisine ) ) {
		$schema['recipeCuisine'] = $cuisine;
	}
	
	// Nutrition Information
	if ( ! empty( $calories ) ) {
		$schema['nutrition'] = array(
			'@type'    => 'NutritionInformation',
			'calories' => $calories . ' calories',
		);
	}
	
	// Remove any null or empty values for cleaner JSON
	$schema = array_filter( $schema, function( $value ) {
		return ! empty( $value ) || $value === 0 || $value === '0';
	} );
	
	return $schema;
}

/**
 * Output Recipe JSON-LD Schema in <head>
 * 
 * Hooks into wp_head to output structured data for single recipes
 */
function rosalinda_child_output_recipe_schema() {
	// Only output on single recipe pages
	if ( ! is_singular( TRX_ADDONS_CPT_DISHES_PT ) ) {
		return;
	}
	
	$post_id = get_the_ID();
	if ( ! $post_id ) {
		return;
	}
	
	// Generate schema data
	$schema = rosalinda_child_generate_recipe_schema( $post_id );
	
	// Only output if we have required fields
	if ( empty( $schema['name'] ) || empty( $schema['recipeIngredient'] ) ) {
		return;
	}
	
	// Output JSON-LD script tag
	?>
	<script type="application/ld+json">
	<?php echo wp_json_encode( $schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT ); ?>
	</script>
	<?php
}
add_action( 'wp_head', 'rosalinda_child_output_recipe_schema', 5 );

/**
 * Include additional child theme files
 * 
 * Uncomment as you add more functionality:
 * - Recipe meta fields extensions
 * - Custom REST API endpoints
 * - AdSense integration
 */

// if ( file_exists( ROSALINDA_CHILD_DIR . '/inc/recipe-meta-fields.php' ) ) {
// 	require_once ROSALINDA_CHILD_DIR . '/inc/recipe-meta-fields.php';
// }

// if ( file_exists( ROSALINDA_CHILD_DIR . '/inc/recipe-rest-api.php' ) ) {
// 	require_once ROSALINDA_CHILD_DIR . '/inc/recipe-rest-api.php';
// }
