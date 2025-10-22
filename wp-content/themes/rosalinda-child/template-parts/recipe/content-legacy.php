<?php
/** Legacy Styled Recipe Variant (pixel-identical to reference) */
defined('ABSPATH') || exit;
$post_id = get_the_ID();
$fields  = function_exists('child_get_recipe_fields') ? child_get_recipe_fields($post_id) : [];
$times   = isset($fields['times']) ? $fields['times'] : [];
$brand_gold = '#d4af37'; // legacy accent
$intro  = !empty($fields['intro']) ? wp_kses_post($fields['intro']) : '';
$yield  = !empty($fields['yield']) ? esc_html($fields['yield']) : '';
$cal    = !empty($fields['nutrition']['calories']) ? esc_html($fields['nutrition']['calories']) : '';
$ingredients = !empty($fields['ingredients']) ? (array)$fields['ingredients'] : [];
$steps  = !empty($fields['instructions']) ? (array)$fields['instructions'] : [];
$diets  = !empty($fields['diet']) ? (array)$fields['diet'] : [];
$related = function_exists('child_related_min') ? child_related_min($post_id) : ['uplink'=>null,'siblings'=>[],'guide'=>null];
// Ad guardrail
$sections_count = function_exists('child_count_recipe_sections') ? child_count_recipe_sections($fields) : 3;
$ad_slots = function_exists('child_ad_density_guardrail') ? child_ad_density_guardrail($sections_count) : array('A1'=>true,'A2'=>true,'A3'=>true,'A4'=>true);
// per-post layout
$ad_layout = function_exists('child_get_ad_layout') ? child_get_ad_layout($post_id) : 'A';
?>

<article <?php post_class('post_item_single'); ?>>

  <!-- Title + intro -->
  <div class="post_header post_header_single">
    <h1 class="post_title"><?php the_title(); ?></h1>
    <?php if ($intro): ?>
      <div class="post_meta"><span class="recipe_intro"><?php echo $intro; ?></span></div>
    <?php endif; ?>
  </div>

  <!-- Times header: PREP / COOK / TOTAL / SERVINGS -->
  <div class="recipe_header_times"
       style="background:#f8f9fa; padding:20px; margin:20px 0; border-radius:8px; display:flex; gap:20px; justify-content:center; flex-wrap:wrap;">
    <?php if (!empty($times['prep'])): ?>
      <div class="time_item" style="text-align:center; min-width:80px;">
        <div style="font-size:24px; font-weight:bold; color:<?php echo esc_attr($brand_gold); ?>;"><?php echo esc_html($times['prep']); ?></div>
        <div style="font-size:12px; text-transform:uppercase; color:#666;">Prep Min</div>
      </div>
    <?php endif; ?>
    <?php if (!empty($times['cook'])): ?>
      <div class="time_item" style="text-align:center; min-width:80px;">
        <div style="font-size:24px; font-weight:bold; color:<?php echo esc_attr($brand_gold); ?>;"><?php echo esc_html($times['cook']); ?></div>
        <div style="font-size:12px; text-transform:uppercase; color:#666;">Cook Min</div>
      </div>
    <?php endif; ?>
    <?php if (!empty($times['total'])): ?>
      <div class="time_item" style="text-align:center; min-width:80px;">
        <div style="font-size:24px; font-weight:bold; color:<?php echo esc_attr($brand_gold); ?>;"><?php echo esc_html($times['total']); ?></div>
        <div style="font-size:12px; text-transform:uppercase; color:#666;">Total Min</div>
      </div>
    <?php endif; ?>
    <?php if (!empty($yield)): ?>
      <div class="time_item" style="text-align:center; min-width:100px;">
        <div style="font-size:20px; font-weight:bold; color:<?php echo esc_attr($brand_gold); ?>;"><?php echo $yield; ?></div>
        <div style="font-size:12px; text-transform:uppercase; color:#666;">Servings</div>
      </div>
    <?php endif; ?>
  </div>

  <div class="post_content">

    <!-- AD A1 -->
    <?php if (!empty($ad_slots['A1'])): ?>
    <div class="ad-slot ad-a1"
         style="margin:30px 0; text-align:center; min-height:100px; background:#fffbf0; border:2px dashed <?php echo esc_attr($brand_gold); ?>; display:flex; align-items:center; justify-content:center; color:#999;">
      <!-- your ad will fill this container -->
    </div>
    <?php endif; ?>

    <!-- Ingredients -->
    <?php if ($ingredients): ?>
    <div class="recipe_ingredients"
         style="background:#fff; padding:25px; margin:25px 0; border-left:4px solid <?php echo esc_attr($brand_gold); ?>;">
      <h3 style="margin-top:0; color:#333;">
     <img draggable="false" role="img" class="emoji" alt="🥘" width="20" height="20" loading="lazy"
       src="https://s.w.org/images/core/emoji/16.0.1/svg/1f958.svg">
        Ingredients
      </h3>
      <ul style="columns:2; column-gap:30px; list-style:none; padding:0; margin:0;">
        <?php foreach ($ingredients as $ing): if (empty($ing)) continue; ?>
          <li style="margin:8px 0; padding-left:20px; position:relative; break-inside:avoid;">
            <span style="position:absolute; left:0; color:<?php echo esc_attr($brand_gold); ?>; font-weight:bold;">•</span>
            <?php echo esc_html( is_array($ing) && !empty($ing['text']) ? $ing['text'] : (string)$ing ); ?>
          </li>
        <?php endforeach; ?>
      </ul>
    </div>
    <?php endif; ?>

    <!-- Instructions -->
    <?php if ($steps): ?>
    <div class="recipe_instructions"
         style="background:#fff; padding:25px; margin:25px 0; border-left:4px solid <?php echo esc_attr($brand_gold); ?>;">
      <h3 style="margin-top:0; color:#333;">
     <img draggable="false" role="img" class="emoji" alt="👩‍🍳" width="20" height="20" loading="lazy"
       src="https://s.w.org/images/core/emoji/16.0.1/svg/1f469-200d-1f373.svg">
        Instructions
      </h3>
      <ol style="list-style:none; counter-reset:step-counter; padding:0; margin:0;">
        <?php $i=0; foreach ($steps as $st): $i++; if (empty($st)) continue; $txt = is_array($st) && !empty($st['text']) ? $st['text'] : (string)$st; ?>
          <li style="counter-increment:step-counter; margin:15px 0; padding-left:50px; position:relative;">
            <span style="position:absolute; left:0; top:0; background:<?php echo esc_attr($brand_gold); ?>; color:#fff; width:30px; height:30px; border-radius:50%; display:flex; align-items:center; justify-content:center; font-weight:bold; font-size:14px;"><?php echo $i; ?></span>
            <?php echo esc_html($txt); ?>
          </li>
        <?php endforeach; ?>
      </ol>
    </div>
    <?php endif; ?>

    <!-- AD A2 -->
    <?php if (!empty($ad_slots['A2'])): ?>
    <div class="ad-slot ad-a2"
      style="margin:30px 0; text-align:center; min-height:100px; background:#fffbf0; border:2px dashed <?php echo esc_attr($brand_gold); ?>; display:flex; align-items:center; justify-content:center; color:#999;">
    </div>
    <?php endif; ?>

    <?php
    // Layout B: insert A2.5 after the Time/Ingredients/Instructions area if guardrail allows 3+ slots
    $allowed_count = is_array($ad_slots) ? count(array_filter($ad_slots)) : 0;
    if ($ad_layout === 'B' && $allowed_count >= 3): ?>
    <div class="ad-slot ad-a2-5" style="margin:20px 0; min-height:120px;" aria-hidden="true"></div>
    <?php endif; ?>

    <!-- Diet chips (from diet tags) -->
    <?php if ($diets): ?>
      <div class="recipe_diet" style="margin:20px 0;">
    <h4 style="color:#333;">
    <img draggable="false" role="img" class="emoji" alt="🏷️" width="20" height="20" loading="lazy"
      src="https://s.w.org/images/core/emoji/16.0.1/svg/1f3f7.svg"> Diet Tags
     </h4>
        <div style="display:flex; gap:10px; flex-wrap:wrap;">
          <?php foreach ($diets as $d): ?>
            <span style="background:<?php echo esc_attr($brand_gold); ?>; color:#fff; padding:4px 12px; border-radius:15px; font-size:12px; text-transform:uppercase;">
              <?php echo esc_html( is_array($d) ? implode(' ', $d) : $d ); ?>
            </span>
          <?php endforeach; ?>
        </div>
      </div>
    <?php endif; ?>

    <!-- AD A3 -->
    <?php if (!empty($ad_slots['A3'])): ?>
    <div class="ad-slot ad-a3"
      style="margin:30px 0; text-align:center; min-height:100px; background:#fffbf0; border:2px dashed <?php echo esc_attr($brand_gold); ?>; display:flex; align-items:center; justify-content:center; color:#999;">
    </div>
    <?php endif; ?>

    <!-- Related -->
    <div class="recipe_related" style="background:#f8f9fa; padding:20px; margin:25px 0; border-radius:8px;">
      <h3 style="margin-top:0; color:#333;">
        <img draggable="false" role="img" class="emoji" alt="🔗" width="20" height="20" loading="lazy"
             src="https://s.w.org/images/core/emoji/16.0.1/svg/1f517.svg"> More Recipes
      </h3>

      <?php if (!empty($related['uplink']['url']) && !empty($related['uplink']['title'])): ?>
        <p><strong>More from this category:</strong>
          <a href="<?php echo esc_url($related['uplink']['url']); ?>" style="color:<?php echo esc_attr($brand_gold); ?>;">
            <?php echo esc_html($related['uplink']['title']); ?>
          </a>
        </p>
      <?php endif; ?>

      <?php if (!empty($related['siblings'])): ?>
        <div>
          <strong>Similar recipes:</strong>
          <ul style="margin:10px 0; padding-left:20px;">
            <?php foreach ($related['siblings'] as $s): ?>
              <li>
                <a href="<?php echo esc_url($s['url']); ?>" style="color:<?php echo esc_attr($brand_gold); ?>;">
                  <?php echo esc_html($s['title']); ?>
                </a>
              </li>
            <?php endforeach; ?>
          </ul>
        </div>
      <?php endif; ?>
    </div>

    <!-- AD A4 -->
    <?php if (!empty($ad_slots['A4'])): ?>
    <div class="ad-slot ad-a4"
      style="margin:30px 0; text-align:center; min-height:100px; background:#fffbf0; border:2px dashed <?php echo esc_attr($brand_gold); ?>; display:flex; align-items:center; justify-content:center; color:#999;">
    </div>
    <?php endif; ?>

  </div><!-- /.post_content -->

  <!-- JSON-LD (Recipe / HowTo + FAQ) -->
  <?php if (function_exists('child_recipe_schema_min')) child_recipe_schema_min($post_id); ?>

</article>
