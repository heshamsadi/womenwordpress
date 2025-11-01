# Recipe Meta Box - Quick Reference

**File Created:** `inc/recipe-meta-box.php`  
**Status:** ✅ Installed and Active

---

## What This Does

Adds a simplified **"Recipe Details"** meta box to the recipe editor that makes it easier to add recipe information without navigating through the ThemeREX Addons interface.

---

## Location in WordPress Admin

When editing a recipe (`Dishes → Edit`), you'll see a new meta box titled **"Recipe Details"** below the main content editor.

---

## Fields Provided

### 1. **Ingredients** (Textarea)
- One ingredient per line
- Example:
  ```
  2 cups flour
  1 cup sugar
  2 eggs
  ```

### 2. **Prep Time** (Text)
- Format: Just the number (in minutes)
- Example: `15` or `15 minutes`

### 3. **Cook Time** (Text)
- Format: Just the number (in minutes)
- Example: `30` or `30 minutes`

### 4. **Servings** (Text)
- Example: `4 servings` or `8 cookies`

### 5. **Calories** (Text)
- Just the number (per serving)
- Example: `250`

### 6. **Dietary Tags** (Text)
- Comma-separated
- Example: `vegetarian, gluten-free`

### 7. **Nutrition Info** (Textarea)
- Optional, one item per line
- Example:
  ```
  Fat: 12g
  Carbs: 35g
  Protein: 4g
  ```

---

## How It Works

### Data Storage
- Saves to the same `trx_addons_options` meta field
- Compatible with existing recipe data
- Works alongside ThemeREX Addons fields

### Integration
- ✅ Works with recipe template
- ✅ Works with JSON-LD schema
- ✅ Works with REST API automation
- ✅ Sanitizes all input automatically

---

## Benefits

1. **Simplified Interface**
   - All key fields in one place
   - No need to navigate complex ThemeREX UI

2. **Fast Editing**
   - Quick access to most-used fields
   - Textarea for ingredients (easier to edit)

3. **Editor Friendly**
   - Clean, WordPress-standard design
   - Clear labels with format hints

4. **Safe**
   - Proper sanitization on save
   - Uses WordPress nonce for security
   - Compatible with existing data

---

## Testing Steps

1. **Go to:** `Dashboard → Dishes → Add New`

2. **Look for:** "Recipe Details" meta box (below content editor)

3. **Fill in fields:**
   - Add ingredients (one per line)
   - Set prep/cook times
   - Enter servings and calories
   - Add dietary tags

4. **Save Draft** or **Publish**

5. **Verify:**
   - View recipe on frontend
   - Check ingredients list displays
   - Check meta facts bar shows times/servings
   - View page source and verify JSON-LD includes data

---

## Troubleshooting

### "Meta box not showing"
- ✅ Clear browser cache (Ctrl+Shift+R)
- ✅ Check Screen Options (top right) - ensure "Recipe Details" is checked
- ✅ Verify you're editing a `cpt_dishes` post (not regular post)

### "Fields not saving"
- ✅ Check file permissions on `/inc/recipe-meta-box.php`
- ✅ Look for PHP errors in `wp-content/debug.log`
- ✅ Verify `functions.php` includes the file correctly

### "Data not displaying on frontend"
- ✅ This is expected - meta box only changes admin interface
- ✅ Frontend template reads from same `trx_addons_options` meta key
- ✅ Existing recipes will display data entered via ThemeREX Addons or this meta box

---

## Comparison: ThemeREX Addons vs. Simple Meta Box

| Feature | ThemeREX Addons | Simple Meta Box |
|---------|----------------|-----------------|
| Location | Separate meta box | Single meta box |
| Fields | 20+ fields | 7 essential fields |
| Interface | Complex tabs | Simple table |
| Speed | Slower (more options) | Faster (focused) |
| Compatibility | ✅ Full | ✅ Full |
| Best For | Advanced users | Quick editing |

**Note:** Both save to the same meta key, so you can use either or both!

---

## Code Location

```
rosalinda-child/
├── inc/
│   └── recipe-meta-box.php   ← New file (51 lines)
└── functions.php              ← Updated (includes meta box)
```

---

## Customization

### Add More Fields

Edit `inc/recipe-meta-box.php` and add to the `$fields` array:

```php
$fields = [
    'ingredients'   => 'Ingredients (one per line)',
    'prep_time'     => 'Prep Time (minutes)',
    'cook_time'     => 'Cook Time (minutes)',
    'servings'      => 'Servings',
    'calories'      => 'Calories',
    'dietary_tags'  => 'Dietary Tags (comma separated)',
    'nutritions'    => 'Nutrition Info (optional, one per line)',
    'cuisine'       => 'Cuisine Type',           // ← Add this
    'course'        => 'Course (Appetizer, Main, etc.)', // ← And this
];
```

### Change Field Order

Reorder the `$fields` array to change display order.

### Make Field Required

Add validation in the save function:

```php
add_action('save_post_cpt_dishes', function ($post_id) {
    if (isset($_POST['trx_addons_options']) && is_array($_POST['trx_addons_options'])) {
        // Check if ingredients is empty
        if (empty($_POST['trx_addons_options']['ingredients'])) {
            // Add admin notice or prevent save
            add_settings_error('rc_recipe', 'missing_ingredients', 'Ingredients are required!');
        }
        
        $clean = [];
        foreach ($_POST['trx_addons_options'] as $k => $v) {
            $clean[$k] = sanitize_textarea_field($v);
        }
        update_post_meta($post_id, 'trx_addons_options', $clean);
    }
});
```

---

## Related Documentation

- **Main Guide:** `README.md`
- **Editor Workflow:** `README_EDITOR.md`
- **Automation:** `README_AUTOMATION.md`
- **Template File:** `single-cpt_dishes.php`

---

## Status

✅ **Installed and Active**

The meta box is now available when editing recipes. No additional configuration needed.

---

**Enjoy simplified recipe editing!** 🍳
