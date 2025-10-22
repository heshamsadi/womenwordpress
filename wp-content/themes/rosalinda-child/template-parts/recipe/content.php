<?php
/**
 * Recipe content template
 * Displays recipe with all fields and formatting
 * 
 * @package SmartLife Child
 */

defined('ABSPATH') || exit;

// Get recipe data
$recipe_data = child_get_recipe_fields(get_the_ID());
$related = child_related_min(get_the_ID());

?>

<div class="post_header post_header_single">
    <h1 class="post_title"><?php the_title(); ?></h1>
    
    <?php if (!empty($recipe_data['intro'])): ?>
    <div class="post_meta">
        <span class="recipe_intro"><?php echo esc_html($recipe_data['intro']); ?></span>
    </div>
    <?php endif; ?>
</div>

<?php if (!empty($recipe_data['prep']) || !empty($recipe_data['cook']) || !empty($recipe_data['total']) || !empty($recipe_data['yield'])): ?>
<div class="recipe_header_times" style="background: #f8f9fa; padding: 20px; margin: 20px 0; border-radius: 8px; display: flex; gap: 20px; justify-content: center; flex-wrap: wrap;">
    <?php if (!empty($recipe_data['prep'])): ?>
    <div class="time_item" style="text-align: center; min-width: 80px;">
        <div style="font-size: 24px; font-weight: bold; color: #d4af37;"><?php echo esc_html($recipe_data['prep']); ?></div>
        <div style="font-size: 12px; text-transform: uppercase; color: #666;">Prep Min</div>
    </div>
    <?php endif; ?>
    
    <?php if (!empty($recipe_data['cook'])): ?>
    <div class="time_item" style="text-align: center; min-width: 80px;">
        <div style="font-size: 24px; font-weight: bold; color: #d4af37;"><?php echo esc_html($recipe_data['cook']); ?></div>
        <div style="font-size: 12px; text-transform: uppercase; color: #666;">Cook Min</div>
    </div>
    <?php endif; ?>
    
    <?php if (!empty($recipe_data['total'])): ?>
    <div class="time_item" style="text-align: center; min-width: 80px;">
        <div style="font-size: 24px; font-weight: bold; color: #d4af37;"><?php echo esc_html($recipe_data['total']); ?></div>
        <div style="font-size: 12px; text-transform: uppercase; color: #666;">Total Min</div>
    </div>
    <?php endif; ?>
    
    <?php if (!empty($recipe_data['yield'])): ?>
    <div class="time_item" style="text-align: center; min-width: 100px;">
        <div style="font-size: 20px; font-weight: bold; color: #d4af37;"><?php echo esc_html($recipe_data['yield']); ?></div>
        <div style="font-size: 12px; text-transform: uppercase; color: #666;">Servings</div>
    </div>
    <?php endif; ?>
</div>
<?php endif; ?>

<div class="post_content">
    <?php the_content(); ?>
    
    <div style="margin: 30px 0; text-align: center; min-height: 100px; background: #fffbf0; border: 2px dashed #d4af37; display: flex; align-items: center; justify-content: center; color: #999;">
        [ad slot="recipe-top"]
    </div>
    
    <?php if (!empty($recipe_data['ingredients'])): ?>
    <div class="recipe_ingredients" style="background: white; padding: 25px; margin: 25px 0; border-left: 4px solid #d4af37;">
        <h3 style="margin-top: 0; color: #333;">🥘 Ingredients</h3>
        <ul style="columns: 2; column-gap: 30px; list-style: none; padding: 0; margin: 0;">
            <?php foreach ($recipe_data['ingredients'] as $ingredient): ?>
            <?php if (trim($ingredient)): ?>
            <li style="margin: 8px 0; padding-left: 20px; position: relative; break-inside: avoid;">
                <span style="position: absolute; left: 0; color: #d4af37; font-weight: bold;">•</span>
                <?php echo esc_html(trim($ingredient)); ?>
            </li>
            <?php endif; ?>
            <?php endforeach; ?>
        </ul>
    </div>
    <?php endif; ?>
    
    <?php if (!empty($recipe_data['steps'])): ?>
    <div class="recipe_instructions" style="background: white; padding: 25px; margin: 25px 0; border-left: 4px solid #d4af37;">
        <h3 style="margin-top: 0; color: #333;">👩‍🍳 Instructions</h3>
        <ol style="list-style: none; counter-reset: step-counter; padding: 0; margin: 0;">
            <?php foreach ($recipe_data['steps'] as $step): ?>
            <?php if (trim($step)): ?>
            <li style="counter-increment: step-counter; margin: 15px 0; padding-left: 50px; position: relative;">
                <span style="content: counter(step-counter); position: absolute; left: 0; top: 0; background: #d4af37; color: white; width: 30px; height: 30px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 14px;"><?php echo $step === reset($recipe_data['steps']) ? '1' : (array_search($step, $recipe_data['steps']) + 1); ?></span>
                <?php echo esc_html(trim($step)); ?>
            </li>
            <?php endif; ?>
            <?php endforeach; ?>
        </ol>
    </div>
    <?php endif; ?>
    
    <div style="margin: 30px 0; text-align: center; min-height: 100px; background: #fffbf0; border: 2px dashed #d4af37; display: flex; align-items: center; justify-content: center; color: #999;">
        [ad slot="recipe-middle"]
    </div>
    
    <?php if (!empty($recipe_data['nutrition']) && !empty($recipe_data['nutrition']['kcal'])): ?>
    <div class="recipe_nutrition" style="background: #f8f9fa; padding: 20px; margin: 25px 0; border-radius: 8px;">
        <h3 style="margin-top: 0; color: #333;">📊 Nutrition Facts</h3>
        <div style="display: flex; gap: 25px; justify-content: center; flex-wrap: wrap;">
            <div style="text-align: center; min-width: 80px;">
                <div style="font-size: 20px; font-weight: bold; color: #333;"><?php echo esc_html($recipe_data['nutrition']['kcal']); ?></div>
                <div style="font-size: 12px; color: #666;">Calories</div>
            </div>
            <div style="text-align: center; min-width: 80px;">
                <div style="font-size: 20px; font-weight: bold; color: #333;"><?php echo esc_html($recipe_data['nutrition']['protein']); ?>g</div>
                <div style="font-size: 12px; color: #666;">Protein</div>
            </div>
            <div style="text-align: center; min-width: 80px;">
                <div style="font-size: 20px; font-weight: bold; color: #333;"><?php echo esc_html($recipe_data['nutrition']['carb']); ?>g</div>
                <div style="font-size: 12px; color: #666;">Carbs</div>
            </div>
            <div style="text-align: center; min-width: 80px;">
                <div style="font-size: 20px; font-weight: bold; color: #333;"><?php echo esc_html($recipe_data['nutrition']['fat']); ?>g</div>
                <div style="font-size: 12px; color: #666;">Fat</div>
            </div>
        </div>
    </div>
    <?php endif; ?>
    
    <?php if (!empty($recipe_data['diet'])): ?>
    <div class="recipe_diet" style="margin: 20px 0;">
        <h4 style="color: #333;">🏷️ Diet Tags</h4>
        <div style="display: flex; gap: 10px; flex-wrap: wrap;">
            <?php foreach ($recipe_data['diet'] as $diet_tag): ?>
            <span style="background: #d4af37; color: white; padding: 4px 12px; border-radius: 15px; font-size: 12px; text-transform: uppercase;">
                <?php echo esc_html(trim($diet_tag)); ?>
            </span>
            <?php endforeach; ?>
        </div>
    </div>
    <?php endif; ?>
    
    <?php if (!empty($recipe_data['faqs'])): ?>
    <div class="recipe_faqs" style="background: white; padding: 25px; margin: 25px 0; border-left: 4px solid #d4af37;">
        <h3 style="margin-top: 0; color: #333;">❓ Frequently Asked Questions</h3>
        <?php foreach ($recipe_data['faqs'] as $faq): ?>
        <div style="margin: 20px 0;">
            <h4 style="color: #d4af37; margin: 0 0 10px 0;"><?php echo esc_html($faq['q']); ?></h4>
            <p style="margin: 0; color: #666;"><?php echo esc_html($faq['a']); ?></p>
        </div>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>
    
    <div style="margin: 30px 0; text-align: center; min-height: 100px; background: #fffbf0; border: 2px dashed #d4af37; display: flex; align-items: center; justify-content: center; color: #999;">
        [ad slot="recipe-bottom"]
    </div>
    
    <?php if (!empty($related['up_link']) || !empty($related['siblings'])): ?>
    <div class="recipe_related" style="background: #f8f9fa; padding: 20px; margin: 25px 0; border-radius: 8px;">
        <h3 style="margin-top: 0; color: #333;">🔗 More Recipes</h3>
        
        <?php if (!empty($related['up_link'])): ?>
        <p><strong>More from this category:</strong> 
            <a href="<?php echo esc_url($related['up_link']['url']); ?>" style="color: #d4af37;">
                <?php echo esc_html($related['up_link']['title']); ?>
            </a>
        </p>
        <?php endif; ?>
        
        <?php if (!empty($related['siblings'])): ?>
        <div>
            <strong>Similar recipes:</strong>
            <ul style="margin: 10px 0; padding-left: 20px;">
                <?php foreach ($related['siblings'] as $sibling): ?>
                <li><a href="<?php echo esc_url($sibling['url']); ?>" style="color: #d4af37;"><?php echo esc_html($sibling['title']); ?></a></li>
                <?php endforeach; ?>
            </ul>
        </div>
        <?php endif; ?>
    </div>
    <?php endif; ?>
</div>

<?php
// Print recipe schema
child_recipe_schema_min(get_the_ID());
?>