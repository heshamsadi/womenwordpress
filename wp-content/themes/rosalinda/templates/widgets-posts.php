<?php
/**
 * The template to display posts in widgets and/or in the search results
 *
 * @package WordPress
 * @subpackage ROSALINDA
 * @since ROSALINDA 1.0
 */

$rosalinda_post_id    = get_the_ID();
$rosalinda_post_date  = rosalinda_get_date();
$rosalinda_post_title = get_the_title();
$rosalinda_post_link  = get_permalink();
$rosalinda_post_author_id   = get_the_author_meta('ID');
$rosalinda_post_author_name = get_the_author_meta('display_name');
$rosalinda_post_author_url  = get_author_posts_url($rosalinda_post_author_id, '');

$rosalinda_args = get_query_var('rosalinda_args_widgets_posts');
$rosalinda_show_date = isset($rosalinda_args['show_date']) ? (int) $rosalinda_args['show_date'] : 1;
$rosalinda_show_image = isset($rosalinda_args['show_image']) ? (int) $rosalinda_args['show_image'] : 1;
$rosalinda_show_author = isset($rosalinda_args['show_author']) ? (int) $rosalinda_args['show_author'] : 1;
$rosalinda_show_counters = isset($rosalinda_args['show_counters']) ? (int) $rosalinda_args['show_counters'] : 1;
$rosalinda_show_categories = isset($rosalinda_args['show_categories']) ? (int) $rosalinda_args['show_categories'] : 1;

$rosalinda_output = rosalinda_storage_get('rosalinda_output_widgets_posts');

$rosalinda_post_counters_output = '';
if ( $rosalinda_show_counters ) {
	$rosalinda_post_counters_output = '<span class="post_info_item post_info_counters">'
								. rosalinda_get_post_counters('comments')
							. '</span>';
}


$rosalinda_output .= '<article class="post_item with_thumb">';

if ($rosalinda_show_image) {
	$rosalinda_post_thumb = get_the_post_thumbnail($rosalinda_post_id, rosalinda_get_thumb_size('tiny'), array(
		'alt' => the_title_attribute( array( 'echo' => false ) ) 
	));
	if ($rosalinda_post_thumb) $rosalinda_output .= '<div class="post_thumb">' . ($rosalinda_post_link ? '<a href="' . esc_url($rosalinda_post_link) . '">' : '') . ($rosalinda_post_thumb) . ($rosalinda_post_link ? '</a>' : '') . '</div>';
}

$rosalinda_output .= '<div class="post_content">'
			. ($rosalinda_show_categories 
					? '<div class="post_categories">'
						. rosalinda_get_post_categories()
						. $rosalinda_post_counters_output
						. '</div>' 
					: '')
			. '<h6 class="post_title">' . ($rosalinda_post_link ? '<a href="' . esc_url($rosalinda_post_link) . '">' : '') . ($rosalinda_post_title) . ($rosalinda_post_link ? '</a>' : '') . '</h6>'
			. apply_filters('rosalinda_filter_get_post_info', 
								'<div class="post_info">'
									. ($rosalinda_show_date 
										? '<span class="post_info_item post_info_posted">'
											. ($rosalinda_post_link ? '<a href="' . esc_url($rosalinda_post_link) . '" class="post_info_date">' : '') 
											. esc_html($rosalinda_post_date) 
											. ($rosalinda_post_link ? '</a>' : '')
											. '</span>'
										: '')
									. ($rosalinda_show_author 
										? '<span class="post_info_item post_info_posted_by">' 
											. esc_html__('by', 'rosalinda') . ' ' 
											. ($rosalinda_post_link ? '<a href="' . esc_url($rosalinda_post_author_url) . '" class="post_info_author">' : '') 
											. esc_html($rosalinda_post_author_name) 
											. ($rosalinda_post_link ? '</a>' : '') 
											. '</span>'
										: '')
									. (!$rosalinda_show_categories && $rosalinda_post_counters_output
										? $rosalinda_post_counters_output
										: '')
								. '</div>')
		. '</div>'
	. '</article>';
rosalinda_storage_set('rosalinda_output_widgets_posts', $rosalinda_output);
?>