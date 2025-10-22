# Rosalinda Child — Developer Docs

Short, practical guide so a new developer can publish recipe posts, run the CSV importer, and understand templates and ad guardrails.

## 1) Setup
- Place this theme in `wp-content/themes/rosalinda-child` and activate it as a child of `rosalinda`.
- Ensure the parent theme `rosalinda` is active.
- Ensure WP-CLI is installed and available on your system for importer tasks.
- Recommended: run on a staging environment before production.

## 2) Data contract (quick)
The child theme expects recipe fields in post meta. Common keys:
- `recipe_intro_short` — short intro/excerpt
- `recipe_prep`, `recipe_cook`, `recipe_total` — minutes
- `recipe_yield` — servings/yield text
- `recipe_method` — method/technique string
- `recipe_ingredients` — newline-delimited list (one ingredient per line)
- `recipe_steps` — newline-delimited list (one step per line)
- `recipe_time_temp` — newline-delimited lines with `item|temp_f|temp_c|minutes|flip|internal_temp`
- `recipe_diet` — comma-separated diet tags
- `recipe_nutrition` — pipe-separated `kcal|protein|carb|fat`
- `recipe_tools` — newline `name|url|why`
- `recipe_substitutions`, `recipe_storage`, `recipe_variations` — free text
- `recipe_faq_q1..q3`, `recipe_faq_a1..a3` — FAQ pairs
- `_template_variant` — `u1`, `v2`, `v3`, `v4`, `v5`, `v7`, `legacy` (controls front-end template)
- `ad_layout` — `A` or `B` (controls per-post ad placement)

The importer accepts common CSV headers and will map them into these meta keys.

## 3) Template Variants
Templates live under `template-parts/recipe/`:
- `content.php` — default U1 recipe
- `content-v2-time-temp.php` — V2 time-first variant
- `content-v3-5ing.php` — V3 five-ingredient variant
- `content-v4-roundup.php` — V4 roundup / ItemList
- `content-v5-howto.php` — V5 how-to/technique
- `content-v7-mealplan.php` — V7 7-day meal plan
- `content-legacy.php` — legacy pixel-identical variant

Set `_template_variant` post meta to choose a variant, or use the meta box in the editor where available.

## 4) Importer usage (WP-CLI)
A WP-CLI command `cook:import` is provided.

Example dry-run:

```bash
wp cook:import --file=/full/path/recipes.csv --dry-run
```

Real run:

```bash
wp cook:import --file=/full/path/recipes.csv
```

CSV header should include at least `title,slug` and can include fields from the Data Contract section. List fields (ingredients[], instructions[]) accept JSON arrays, pipe-separated, or comma-separated.

Featured images may be provided as `featured_image` (remote URL) and will be sideloaded.

## 5) QA checklist (author)
- Content Score (admin column) shows 0–100. Weak posts are < 60. Improve by adding:
  - Method
  - Prep/cook/total time
  - Time & Temperature table
  - Full instructions
  - Storage / Substitutions
  - Nutrition (calories)
  - At least 3 FAQs
  - Ensure schema output (Recipe / HowTo / FAQ) is present (single JSON-LD block)

Click the Content Score badge in the posts list to jump to the checklist meta box on the post edit screen.

## 6) Ad guardrail notes
- Server-side heuristic controls which ad slots (A1..A4) render to keep mobile ad density ~<=30%.
- Per-post `ad_layout` meta chooses layout A or B:
  - A: A1, A2, A3, A4
  - B: A1, A2, A2.5 (mid), A3, A4
- Templates respect the guardrail: even if layout requests A2.5, the guardrail may suppress some slots. A2.5 renders only when the guardrail allows the third slot.

## 7) Troubleshooting
- If importer fails to sideload images: ensure `allow_url_fopen` or WP HTTP transports are available and that PHP can write to `wp-content/uploads`.
- If schema not output: ensure `child_get_recipe_fields()` returns ingredients and steps. The JSON-LD emitter will output a single block per post.
- Run PHP lint locally if you modify files:

```bash
php -l wp-content/themes/rosalinda-child/inc/recipe-min.php
php -l wp-content/themes/rosalinda-child/inc/content-score.php
```

## 8) Next steps
- Add more CSV mappings (FAQ pairs, per-field nutrition) if your CSV contains richer columns.
- Consider adding A/B analytics hooks to capture ad_layout impressions.

---
If you'd like, I can add a short `docs/importer.md` with an expanded CSV spec or create a sample CSV for testing.
