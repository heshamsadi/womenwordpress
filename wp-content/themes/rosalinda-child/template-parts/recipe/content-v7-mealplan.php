<?php
/**
 * V7 - 7-Day Meal Plan
 */
defined('ABSPATH') || exit;
$post_id = get_the_ID();
// Example: mealplan saved in post meta 'mealplan' or generated from tags
$plan = get_post_meta($post_id,'mealplan',true);
// Ad guardrail compute (mealplan may include ads in the future)
$sections_count = 8;
$ad_slots = function_exists('child_ad_density_guardrail') ? child_ad_density_guardrail($sections_count) : array('A1'=>true,'A2'=>true,'A3'=>true,'A4'=>true);
// per-post layout
$ad_layout = function_exists('child_get_ad_layout') ? child_get_ad_layout($post_id) : 'A';
if (!$plan || !is_array($plan)) {
    // Fallback: build a simple sample plan from latest cooking posts
    $meals = array();
    $recent = get_posts(array('posts_per_page'=>21,'category_name'=>'cooking','fields'=>'ids'));
    for ($d=0;$d<7;$d++) {
        $meals[$d] = array_slice($recent, $d*3, 3);
        $snack = isset($recent[$d+21]) ? $recent[$d+21] : null;
        $meals[$d][] = $snack;
    }
} else {
    $meals = $plan;
}

// Build shopping list (aggregate ingredients from plan)
$shopping = array();
foreach ($meals as $dayMeals) {
    foreach ($dayMeals as $pid) {
        if (!$pid) continue;
        $fields = function_exists('child_get_recipe_fields') ? child_get_recipe_fields($pid) : array();
        foreach ((array)($fields['ingredients'] ?? array()) as $ing) {
            $text = is_array($ing) ? ($ing['text'] ?? '') : (string)$ing;
            if (!$text) continue;
            $shopping[] = $text;
        }
    }
}
// naive aisle grouping: by keywords (produce, dairy, meat, pantry)
$aisles = array('Produce'=>array(),'Dairy'=>array(),'Meat'=>array(),'Pantry'=>array());
foreach ($shopping as $s) {
    $low = strtolower($s);
    if (preg_match('/(lettuce|tomato|onion|carrot|parsley|spinach)/', $low)) $aisles['Produce'][]=$s;
    elseif (preg_match('/(milk|cheese|yogurt|butter)/', $low)) $aisles['Dairy'][]=$s;
    elseif (preg_match('/(chicken|beef|pork|salmon|tuna)/', $low)) $aisles['Meat'][]=$s;
    else $aisles['Pantry'][]=$s;
}

?>
<article <?php post_class('post_item_single recipe-template'); ?>>
  <div class="container">
    <div class="content">
      <header class="post_header"><h1 class="post_title sc_item_title"><?php the_title(); ?></h1>
      <p class="post_intro"><?php echo wp_kses_post( wp_trim_words(get_the_excerpt()?:get_the_content(), 30) ); ?></p>
      <p><a class="theme_button" href="#" onclick="window.print();return false;">Printable Plan</a></p>
      </header>

      <section class="mealplan_grid">
        <?php for ($d=0;$d<7;$d++): ?>
          <div class="column-1_1">
            <h3 class="h3">Day <?php echo $d+1; ?></h3>
            <div class="columns_wrap">
              <?php foreach ($meals[$d] as $midx => $pid): ?>
                <div class="column-1_4">
                  <?php if ($pid): $fields = child_get_recipe_fields($pid); ?>
                    <article class="mini_card">
                      <h4 class="post_title"><a href="<?php echo get_permalink($pid); ?>"><?php echo esc_html(get_the_title($pid)); ?></a></h4>
                      <div class="meta_small"><?php echo !empty($fields['nutrition']['kcal']) ? esc_html($fields['nutrition']['kcal']).' kcal' : ''; ?> <?php echo !empty($fields['times']['total']) ? ' · '.esc_html($fields['times']['total']).' min' : ''; ?></div>
                    </article>
                  <?php else: ?>
                    <div class="mini_card empty">Snack</div>
                  <?php endif; ?>
                </div>
              <?php endforeach; ?>
            </div>
          </div>
        <?php endfor; ?>
      </section>

      <?php
      // Layout B: optional A2.5 after the grid
      $allowed_count = is_array($ad_slots) ? count(array_filter($ad_slots)) : 0;
      if ($ad_layout === 'B' && $allowed_count >= 3): ?>
        <div class="ad-slot ad-a2-5 mt-20 mb-20" style="min-height:140px;" aria-hidden="true"></div>
      <?php endif; ?>

      <section class="shopping_list">
        <h2 class="h2 sc_item_title">Shopping List</h2>
        <?php foreach ($aisles as $aisle => $items): if (empty($items)) continue; ?>
          <h3 class="h3"><?php echo esc_html($aisle); ?></h3>
          <ul><?php foreach ($items as $it) echo '<li>'.esc_html($it).'</li>'; ?></ul>
        <?php endforeach; ?>
      </section>

      <section class="prep_checklist">
        <h2 class="h2 sc_item_title">Sunday 60-min Prep</h2>
        <ol>
          <li>Chop vegetables and store in containers</li>
          <li>Cook grains and refrigerate</li>
          <li>Pre-portion proteins and marinades</li>
          <li>Prepare dressings and sauces</li>
          <li>Label containers with dates</li>
        </ol>
      </section>

    </div>
  </div>
</article>
