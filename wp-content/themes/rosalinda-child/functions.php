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
 * Include additional child theme files
 * 
 * Uncomment as you add more functionality:
 * - Recipe meta fields extensions
 * - Recipe schema markup
 * - Custom REST API endpoints
 * - AdSense integration
 */

// if ( file_exists( ROSALINDA_CHILD_DIR . '/inc/recipe-meta-fields.php' ) ) {
// 	require_once ROSALINDA_CHILD_DIR . '/inc/recipe-meta-fields.php';
// }

// if ( file_exists( ROSALINDA_CHILD_DIR . '/inc/recipe-schema.php' ) ) {
// 	require_once ROSALINDA_CHILD_DIR . '/inc/recipe-schema.php';
// }

// if ( file_exists( ROSALINDA_CHILD_DIR . '/inc/recipe-rest-api.php' ) ) {
// 	require_once ROSALINDA_CHILD_DIR . '/inc/recipe-rest-api.php';
// }
