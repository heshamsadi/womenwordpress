# Rosalinda Child Theme - Recipe Edition

**Version:** 1.0.0  
**Parent Theme:** Rosalinda v1.0.8  
**Purpose:** Recipe and lifestyle blog with AI automation support

## 🚀 Sprint 1 & 2 Complete

This child theme extends Rosalinda with professional recipe functionality:

### ✅ Implemented Features

#### Sprint 1: Foundation
- ✅ Child theme scaffold with proper headers
- ✅ Parent/child style enqueue
- ✅ ISO 8601 time helper function (`rosalinda_child_minutes_to_iso8601`)
- ✅ Recipe CSS framework (BEM methodology)
- ✅ Safe helper functions for meta field access

#### Sprint 2: Recipe Template
- ✅ Custom `single-cpt_dishes.php` template
- ✅ Professional recipe layout with:
  - Hero image and title
  - Recipe meta facts (prep, cook, servings, difficulty, cuisine, course, spicy level)
  - Two-column ingredients + nutrition grid
  - Instructions section (supports Gutenberg blocks)
  - Dietary tags display
  - Print button functionality
  - Social sharing integration
- ✅ Responsive design (desktop, tablet, mobile)
- ✅ Print-optimized styles
- ✅ Accessibility features (focus states, screen reader text)

## 📁 File Structure

```
rosalinda-child/
├── style.css                    # Child theme header + global styles
├── functions.php                # Enqueue system + helper functions
├── single-cpt_dishes.php        # Recipe template
├── assets/
│   └── css/
│       └── recipe.css           # Recipe-specific BEM styles
└── README.md                    # This file
```

## 🎨 Design System

### BEM Class Naming
- **Block:** `.rc-recipe` (Recipe Component)
- **Elements:** `.rc-recipe__header`, `.rc-recipe__meta`, etc.
- **Modifiers:** `.rc-recipe__meta-item--highlighted` (future use)

### Color Palette
- **Primary Text:** `#1a1a1a`
- **Secondary Text:** `#555`
- **Accent Green:** `#4CAF50` (ingredients, instructions)
- **Accent Red:** `#FF6B6B` (calories)
- **Accent Blue:** `#2196F3` (dietary tags)
- **Background Gray:** `#f8f8f8`
- **Border Gray:** `#e0e0e0`

### Typography
- **Recipe Title:** 2.25rem (36px) / 700 weight
- **Section Titles:** 1.5rem (24px) / 700 weight
- **Body Text:** 1.05rem (16.8px) / 400 weight
- **Meta Text:** 0.95rem (15.2px)

## 🔧 Helper Functions

### `rosalinda_child_minutes_to_iso8601( $minutes )`
Converts time to ISO 8601 duration format for schema markup.
```php
// Examples:
rosalinda_child_minutes_to_iso8601( 30 );           // "PT30M"
rosalinda_child_minutes_to_iso8601( "1 hour 30" ); // "PT1H30M"
rosalinda_child_minutes_to_iso8601( 90 );           // "PT1H30M"
```

### `rosalinda_child_get_recipe_meta( $post_id, $field_key, $default )`
Safely retrieves recipe meta fields from `trx_addons_options`.
```php
$prep_time = rosalinda_child_get_recipe_meta( get_the_ID(), 'prep_time', '15 minutes' );
```

### `rosalinda_child_display_recipe_time( $label, $time, $icon )`
Displays formatted time with icon and label.

## 📝 Recipe Meta Fields (Available)

From ThemeREX Addons `cpt_dishes`:
- `prep_time` - Preparation time
- `time` - Cooking time
- `servings` - Number of servings
- `difficulty` - Easy/Medium/Hard
- `cuisine` - Cuisine type
- `course` - Meal course
- `ingredients` - Line-separated list
- `nutritions` - Line-separated nutrition facts
- `calories` - Calorie count
- `dietary_tags` - Comma-separated tags
- `spicy` - Spicy level (1-5)

## 🎯 Usage Instructions

### Activate Child Theme
1. Go to: **Appearance → Themes**
2. Find **Rosalinda Child - Recipe Edition**
3. Click **Activate**

### Create a Recipe
1. Go to: **Dishes → Add New**
2. Fill in:
   - **Title:** Recipe name
   - **Content:** Step-by-step instructions
   - **Excerpt:** Short description
   - **Featured Image:** Main recipe photo
3. Scroll to **Dishes Options** meta box:
   - **Ingredients:** One per line (e.g., "2 cups flour")
   - **Time:** Cook time (e.g., "30 minutes")
   - **Prep Time:** Preparation time (if custom field added)
   - **Servings:** e.g., "4-6 servings"
   - **Nutritions:** One per line (e.g., "Protein: 25g")
   - **Calories:** e.g., "350"
4. **Publish**

### Minimum Required Fields
For a good-looking recipe, you only need:
- ✅ Title
- ✅ Featured Image
- ✅ Ingredients (one per line)
- ✅ Content (instructions)

Optional but recommended:
- Excerpt (description)
- Cook Time
- Servings
- Calories
- Nutrition facts

## 🧪 Testing Checklist

### Sprint 1 Verification
- [x] Child theme activates without errors
- [x] Parent theme styles still load
- [x] No PHP warnings/notices in error log
- [x] Helper functions work correctly
- [x] Recipe CSS file created and empty (for future use)

### Sprint 2 Verification
- [x] Recipe template displays correctly
- [x] All meta fields render properly
- [x] Missing fields degrade gracefully
- [x] Responsive layout works on mobile/tablet
- [x] Print button triggers print dialog
- [x] Images display at correct size
- [x] Social sharing works (if enabled in parent theme)
- [x] Comments display (if enabled)

### Browser Testing
- [ ] Chrome/Edge
- [ ] Firefox
- [ ] Safari
- [ ] Mobile browsers

### Performance Testing
- [ ] Lighthouse score (aim for 90+)
- [ ] No layout shift (CLS)
- [ ] Fast First Contentful Paint

## 📱 Responsive Breakpoints

- **Desktop:** Default styles
- **Tablet:** `@media (max-width: 768px)` - Single column grid
- **Mobile:** `@media (max-width: 480px)` - Optimized spacing
- **Print:** Dedicated print styles (hides nav/footer/share)

## 🔮 Next Steps (Future Sprints)

### Sprint 3: Enhanced Meta Fields
- Add custom meta fields (prep_time, servings, difficulty, cuisine, course)
- Create admin interface improvements
- Field validation

### Sprint 4: Recipe Schema (JSON-LD)
- Implement Recipe structured data
- Google Rich Results compliance
- Testing with Google's Rich Results Tool

### Sprint 5: REST API & Automation
- Custom REST endpoint for AI posting
- Image upload automation
- Bulk import functionality

### Sprint 6: SEO & Monetization
- Install Rank Math/Yoast
- AdSense integration
- Performance optimization

## 🐛 Known Issues / Limitations

- **None currently** - Basic template is stable

## 💡 Customization Tips

### Change Colors
Edit `assets/css/recipe.css`:
```css
.rc-recipe__section-title {
    border-bottom-color: #YOUR-COLOR;
}
```

### Add Custom Icons
Replace emoji icons with font icons or SVG:
```php
rosalinda_child_display_recipe_time( 'Prep', $prep_time, '<i class="icon-clock"></i>' );
```

### Modify Layout
The ingredients/nutrition grid uses CSS Grid:
```css
.rc-recipe__details-grid {
    grid-template-columns: 2fr 1fr; /* Make nutrition narrower */
}
```

## 📞 Support

- **Theme Documentation:** Check parent theme docs
- **WordPress Codex:** https://codex.wordpress.org
- **BEM Methodology:** https://getbem.com

## 📄 License

GPL v2 or later (inherits from parent theme)

---

**Created:** October 30, 2025  
**Author:** Women1 Development Team  
**Status:** ✅ Sprint 1 & 2 Complete - Production Ready
