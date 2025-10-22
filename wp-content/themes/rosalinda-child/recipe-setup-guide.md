# WordPress Recipe Post Setup Guide

## What Your Screen Should Look Like

### Top Right Corner:
```
[⚙️ Settings] [👁️ Preview] [💾 Save] [🔵 Publish]
```

### Sidebar Panels (after clicking Settings ⚙️):

#### 📄 Document Tab:
```
┌─ Categories ─────────────────┐
│ ☐ Uncategorized             │
│ ☐ Cooking                   │
│   ☐ Quick & Few-Ingredient  │
│     ☐ 15-Minute Meals      │
│     ☐ 30-Minute Dinners    │
│     ☐ 5-Ingredient Dinners │
│   ☐ Healthy & Metabolic     │
│   ☐ Cooking Methods         │
│   ☐ Budget & Family         │
│   ☐ Special Diets           │  
│   ☐ Baking & Desserts       │
└─────────────────────────────┘

┌─ Tags ──────────────────────┐
│ Add new tag...              │
└─────────────────────────────┘

┌─ Featured Image ────────────┐
│ [Set featured image]        │
└─────────────────────────────┘

┌─ Custom Fields ─────────────┐
│ Name: [recipe_prep        ] │
│ Value: [5                ] │
│ [Add Custom Field]          │
└─────────────────────────────┘
```

### Recipe Meta Fields You'll Add:
```
recipe_prep = 10
recipe_cook = 15
recipe_total = 25
recipe_yield = 4 servings
recipe_method = Stovetop
recipe_ingredients = 2 cups pasta
1 tbsp olive oil
3 cloves garlic
1 cup tomatoes
recipe_steps = Cook pasta according to directions
Heat oil in large pan
Add garlic and cook 1 minute
Add tomatoes and simmer
recipe_nutrition = 350|12|45|8
recipe_diet = vegetarian, quick
```

## If You Don't See Categories:

1. Click **Screen Options** (top right)
2. Check ✅ **Categories**
3. Check ✅ **Custom Fields** 
4. Check ✅ **Tags**

## If Using Classic Editor:

The recipe template works with both editors:
- **Block Editor** (Gutenberg) - What you're using now
- **Classic Editor** - Has a different layout but same fields

## Quick Test:

1. **Title:** "Test Garlic Pasta"
2. **Category:** Cooking → Quick & Few-Ingredient → 15-Minute Meals  
3. **Custom Field:** recipe_prep = 5
4. **Publish**
5. **View Post** - Should show recipe template!