<?php
/**
 * The style "extra" of the Services
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.4
 */

$args = get_query_var('trx_addons_args_sc_services');
$number = get_query_var('trx_addons_args_item_number');

$meta = get_post_meta(get_the_ID(), 'trx_addons_options', true);
$link = empty($args['no_links'])
			? (!empty($meta['link']) ? $meta['link'] : get_permalink())
			: '';

if (empty($args['id'])) $args['id'] = 'sc_services_'.str_replace('.', '', mt_rand());
if (empty($args['featured'])) $args['featured'] = 'image';
if (empty($args['featured_position'])) $args['featured_position'] = 'top';
if (empty($args['hide_bg_image'])) $args['hide_bg_image'] = 0;

$svg_present = false;
$price_showed = true;

$image = '';
if ( has_post_thumbnail() ) {
    $image = trx_addons_get_attachment_url(
        get_post_thumbnail_id( get_the_ID() ),
        apply_filters('trx_addons_filter_thumb_size', trx_addons_get_thumb_size('serv'), 'services-hover')
    );
}

if (!empty($args['slider'])) {
	?><div class="slider-slide swiper-slide"><?php
} else if ((int)$args['columns'] > 1) {
	?><div class="<?php echo esc_attr(trx_addons_get_column_class(1, $args['columns'])); ?>"><?php
}
?>
<div <?php post_class( 'sc_services_item'
			. (empty($post_link) ? ' no_links' : '')
			. (isset($args['hide_excerpt']) && (int)$args['hide_excerpt']>0 ? ' without_content' : ' with_content')
			. (!trx_addons_is_off($args['featured']) ? ' with_'.esc_attr($args['featured']) : '')
			. ' sc_services_item_featured_'.esc_attr($args['featured']!='none' ? $args['featured_position'] : 'none')
			);
	if (!empty($args['popup'])) {
		?> data-post_id="<?php echo esc_attr(get_the_ID()); ?>"<?php
		?> data-post_type="<?php echo esc_attr(TRX_ADDONS_CPT_SERVICES_PT); ?>"<?php
	}
?>>
    <div class="sc_services_item_header <?php echo esc_attr($args['hide_bg_image']==1 ? ' without_image' : ''); ?>"<?php if ($args['hide_bg_image']==0 && !empty($image)) echo ' style="background-image: url('.esc_url($image).');"'; ?>>
        <div class="sc_services_item_info">
        <div class="sc_services_item_header">
            <h4 class="sc_services_item_title<?php if (!$price_showed && !empty($meta['price'])) echo ' with_price'; ?>"><?php
                if (!empty($link)) {
                ?><a href="<?php echo esc_url($link); ?>"<?php if (!empty($meta['link'])) echo ' target="_blank"'; ?>><?php
                    }
                    the_title();
                    if (!empty($link)) {
                    ?></a><?php
            }
            ?></h4>
            <?php if (!isset($args['hide_excerpt']) || (int)$args['hide_excerpt']==0) { ?>
                <div class="sc_services_item_excerpt"><?php the_excerpt(); ?></div>
                <?php
            }
                ?>
            </div>
            <div class="sc_services_item_link">
                <?php
                if (!empty($link) && empty($args['more_text'])) {
                    ?>
                    <a href="<?php echo esc_url($link);?>" class="icon-link"></a>
                    <?php
                }
                ?>
            </div>
        </div>
    </div>
<div class="sc_services_item_footer">
    <?php
    if (!empty($link) && !empty($args['more_text'])) {
        ?><div class="sc_services_item_button sc_item_button"><a href="<?php echo esc_url($link); ?>"<?php if (!empty($meta['link'])) echo ' target="_blank"'; ?> class="<?php echo esc_attr(apply_filters('trx_addons_filter_sc_item_link_classes', 'sc_button sc_button_simple', 'sc_services', $args)); ?>"><?php echo esc_html($args['more_text']); ?></a></div><?php
    }
    ?>
</div>

</div>
<?php
if (!empty($args['slider']) || (int)$args['columns'] > 1) {
	?></div><?php
}
if (trx_addons_is_on(trx_addons_get_option('debug_mode')) && $svg_present) {
	wp_enqueue_script( 'vivus', trx_addons_get_file_url(TRX_ADDONS_PLUGIN_SHORTCODES . 'icons/vivus.js'), array('jquery'), null, true );
	wp_enqueue_script( 'trx-addons-sc-icons', trx_addons_get_file_url(TRX_ADDONS_PLUGIN_SHORTCODES . 'icons/icons.js'), array('jquery'), null, true );
}
?>