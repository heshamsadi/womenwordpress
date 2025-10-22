<?php
/**
 * Variant V5 - How-To / Technique (no ingredients)
 */
defined('ABSPATH') || exit;
$post_id = get_the_ID();
$recipe = child_get_recipe_fields($post_id);
?>
<article id="post-<?php the_ID(); ?>" <?php post_class('post_item_single post_type_' . esc_attr(get_post_type()) . ' recipe-template'); ?>>
	<div class="container">
	<div class="content">
	<section class="v5-intro"><h1 class="post_title"><?php the_title(); ?></h1><?php if (!empty($recipe['intro'])) echo '<p>'.wp_kses_post($recipe['intro']).'</p>'; ?></section>
	<div class="ad-slot ad-a1 mt-30 mb-30" style="min-height:280px;" aria-hidden="true"></div>

	<?php if (!empty($recipe['tools'])): ?><section class="v5-tools"><h3 class="h3"><?php esc_html_e('Tools','rosalinda-child'); ?></h3><ul class="trx_addons_list"><?php foreach($recipe['tools'] as $t) echo '<li><a class="theme_button" href="'.esc_url($t['url']).'">'.esc_html($t['name']).'</a> '.esc_html($t['why']).'</li>'; ?></ul></section><?php endif; ?>

	<?php if (!empty($recipe['steps'])): ?><section class="v5-steps"><h2 class="h2"><?php esc_html_e('Steps','rosalinda-child'); ?></h2><ol class="trx_addons_list trx_addons_list_numbered"><?php foreach($recipe['steps'] as $s) echo '<li>'.wp_kses_post($s).'</li>'; ?></ol></section><?php endif; ?>

	<?php if (!empty($recipe['variations'])): ?><section class="v5-troubleshoot"><h3 class="h3"><?php esc_html_e('Troubleshooting','rosalinda-child'); ?></h3><?php echo wp_kses_post($recipe['variations']); ?></section><?php endif; ?>

	<div class="ad-slot ad-a2 mt-30 mb-30" style="min-height:150px;" aria-hidden="true"></div>

	<?php if (!empty($recipe['faqs'])): ?><section class="v5-faqs"><h2 class="h2"><?php esc_html_e('FAQ','rosalinda-child'); ?></h2><?php foreach($recipe['faqs'] as $f) echo '<h3 class="h3">'.wp_kses_post($f['q']).'</h3><p>'.wp_kses_post($f['a']).'</p>'; ?></section><?php endif; ?>

	<div class="ad-slot ad-a3 mt-30 mb-30" style="min-height:120px;" aria-hidden="true"></div>

	<?php $related = child_related_min($post_id); if (!empty($related['siblings']) || !empty($related['up_link'])) { echo '<section class="v5-related"><h2 class="h2">'.esc_html__('Related','rosalinda-child').'</h2>'; if(!empty($related['up_link'])) echo '<p><a href="'.esc_url($related['up_link']['url']).'">'.esc_html($related['up_link']['title']).'</a></p>'; if(!empty($related['siblings'])) { echo '<ul class="trx_addons_list">'; foreach($related['siblings'] as $s) echo '<li><a href="'.esc_url($s['url']).'">'.esc_html($s['title']).'</a></li>'; echo '</ul>'; } echo '</section>'; } ?>

	<div class="ad-slot ad-a4 mt-30 mb-30" style="min-height:90px;" aria-hidden="true"></div>

	<?php // Ensure only HowTo schema for this variant
	child_recipe_schema_min($post_id); ?>

	</div><!-- .content -->
	</div><!-- .container -->
</article>
