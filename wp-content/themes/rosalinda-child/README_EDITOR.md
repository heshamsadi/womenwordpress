# Recipe Editor Guide

**Quick guide for creating beautiful recipes in under 10 minutes**

---

## 🎯 Quick Start

Publishing a recipe requires just **4 essential fields**:
1. ✅ **Title** - Recipe name
2. ✅ **Featured Image** - Recipe photo (1200px+ width recommended)
3. ✅ **Ingredients** - One ingredient per line in meta field
4. ✅ **Instructions** - Step-by-step directions in content editor

Everything else is optional but recommended for SEO and rich results.

---

## 📝 Step-by-Step Recipe Creation

### Step 1: Create New Recipe Post

1. Go to: **Dashboard → Dishes → Add New**
2. Enter recipe title (e.g., "Classic Chocolate Chip Cookies")

---

### Step 2: Add Featured Image ⭐ REQUIRED

**Why it matters:** Featured images appear in recipe cards, search results, and social shares.

**Best Practices:**
- ✅ Minimum size: **1200px width** (1200x800px or larger)
- ✅ Format: **JPG** (JPEG) for photos
- ✅ File size: Under 500KB (optimize with TinyPNG or similar)
- ✅ Aspect ratio: **3:2** or **4:3** (landscape orientation)
- ✅ High quality: Well-lit, appetizing, in-focus food shot

**How to Add:**
1. Click **"Set featured image"** in right sidebar
2. Upload your image or select from Media Library
3. Add **Alt Text** for accessibility (e.g., "Chocolate chip cookies on cooling rack")
4. Click **"Set featured image"**

**Tips:**
- Use hero shot of finished dish
- Natural lighting works best
- Show texture and color
- Include garnish or plating

---

### Step 3: Write Recipe Excerpt ⭐ RECOMMENDED

**What it is:** Short description (1-2 sentences) that appears below the title.

**Where it shows:**
- Below recipe title on single page
- In recipe archives/cards
- In Google search results (meta description)
- Social media previews

**Best Practices:**
- ✅ 120-160 characters ideal
- ✅ Describe taste, texture, or occasion
- ✅ Make it appetizing and clickable
- ❌ Don't repeat the title exactly

**Example:**
```
Soft, chewy cookies with crispy edges and gooey chocolate centers. 
Perfect for dessert or afternoon snacks!
```

**How to Add:**
1. Look for **"Excerpt"** panel in right sidebar (may need to enable in Screen Options)
2. Write your short description
3. No need for HTML formatting

---

### Step 4: Add Ingredients ⭐ REQUIRED

**Critical:** This field is required for JSON-LD structured data (Google Rich Results).

**Format:** One ingredient per line, with quantity and unit.

**How to Add:**
1. Scroll to **"Recipe Ingredients & Nutritions"** meta box (below content editor)
2. Find **"Ingredients"** text area
3. Enter ingredients, **one per line**
4. Press Enter after each ingredient

**Example:**
```
2 cups all-purpose flour
1 tsp baking soda
1/2 tsp salt
1 cup butter, softened
3/4 cup white sugar
3/4 cup brown sugar
2 large eggs
2 tsp vanilla extract
2 cups chocolate chips
```

**Best Practices:**
- ✅ Start with quantity: "2 cups flour" not "flour, 2 cups"
- ✅ Include preparation: "butter, softened" or "onions, diced"
- ✅ Use standard measurements (cups, tbsp, tsp, oz, grams)
- ✅ Group by section if complex (add blank line between sections)
- ✅ Be specific: "2 large eggs" not just "eggs"

**Optional Sections:**
```
For the Dough:
2 cups flour
1 cup sugar
1/2 cup butter

For the Filling:
1 cup cream cheese
1/4 cup honey
```

---

### Step 5: Write Instructions ⭐ REQUIRED

**What it is:** Step-by-step cooking directions in the main content editor.

**How to Add:**
1. Use the **main content editor** (Gutenberg/Block editor)
2. Write clear, numbered steps
3. Add images inline if desired

**Best Practices:**
- ✅ Use headings (H3) to break into sections: "Prepare Dough", "Bake", "Cool"
- ✅ Write in imperative mood: "Mix flour" not "You should mix flour"
- ✅ One action per step when possible
- ✅ Include temperatures and times: "Bake at 350°F for 12 minutes"
- ✅ Mention visual cues: "until golden brown" or "bubbling around edges"
- ✅ Add images between steps (optional but helpful)

**Example Structure:**

```
### Prepare the Dough

Mix flour, baking soda, and salt in a medium bowl. Set aside.

In a large bowl, cream together butter and both sugars until fluffy (about 3 minutes).

Beat in eggs one at a time, then add vanilla extract.

### Combine Ingredients

Gradually mix in the flour mixture until just combined. Do not overmix.

Fold in chocolate chips with a rubber spatula.

### Bake

Preheat oven to 375°F (190°C).

Drop rounded tablespoons of dough onto ungreased cookie sheets, 2 inches apart.

Bake for 10-12 minutes, until edges are golden but centers still look slightly underdone.

### Cool and Serve

Let cookies cool on baking sheet for 5 minutes.

Transfer to wire rack to cool completely.

Store in airtight container for up to 5 days.
```

**Using Gutenberg Blocks:**
- **Paragraph** - For each step
- **Heading** - For section titles (use H3)
- **Image** - Inline photos of steps
- **List** - For sub-steps or variations

---

### Step 6: Fill Recipe Meta Fields (Optional but Recommended)

These fields appear in **"Recipe Ingredients & Nutritions"** meta box below the content editor.

#### ⏱️ Time Fields

**Prep Time:**
- Time to prepare ingredients (chopping, mixing)
- Format: `15 minutes` or `15` or `1 hour 30 minutes`
- Example: `20 minutes`

**Cook Time:**
- Active cooking/baking time
- Format: Same as prep time
- Example: `30 minutes`

*Note: Total time is calculated automatically for JSON-LD.*

#### 🍽️ Servings

**Format:** Include unit
- Example: `12 cookies` or `4 servings` or `8-10 people`
- Not just: `4` (too vague)

#### 🔥 Calories

**Format:** Number only (unit added automatically)
- Example: `250` (displays as "250 calories")
- Per serving, not total recipe

#### 📊 Difficulty

**Options:** Easy, Medium, Hard
- Easy: No special skills required
- Medium: Some technique needed
- Hard: Advanced skills required

#### 🌍 Cuisine

**Examples:**
- Italian, Mexican, Chinese, American, French, Indian, Thai, Japanese

#### 🍴 Course

**Examples:**
- Appetizer, Main Course, Side Dish, Dessert, Breakfast, Snack, Beverage

#### 🌶️ Spicy Level (Optional)

**Format:** Number 1-5
- 0: Not spicy
- 1: Mild
- 3: Medium heat
- 5: Very spicy

#### 🥗 Nutritions (Optional)

**Format:** One item per line with colon separator

**Example:**
```
Fat: 12g
Carbs: 35g
Protein: 4g
Fiber: 2g
Sugar: 18g
Sodium: 180mg
```

#### 🏷️ Dietary Tags (Optional)

**Format:** Comma-separated tags

**Examples:**
- `vegetarian`
- `vegan, gluten-free`
- `dairy-free, nut-free`
- `keto, low-carb`
- `paleo`

---

## ✅ Pre-Publish Checklist

Before clicking **Publish**, verify:

### Absolutely Required
- [ ] **Title** - Clear, descriptive recipe name
- [ ] **Featured Image** - High-quality photo (1200px+ width)
- [ ] **Ingredients** - Listed in "Ingredients" meta field (one per line)
- [ ] **Instructions** - Clear steps in content editor

### Highly Recommended for SEO
- [ ] **Excerpt** - 120-160 character description
- [ ] **Cook Time** - Helps users plan
- [ ] **Servings** - How many it feeds
- [ ] **Cuisine & Course** - Categorization for search
- [ ] **Alt Text on Featured Image** - Accessibility & SEO

### Optional but Valuable
- [ ] **Prep Time** - Additional planning info
- [ ] **Calories** - Nutrition info
- [ ] **Nutritions** - Detailed nutrition facts
- [ ] **Difficulty** - Helps users choose
- [ ] **Dietary Tags** - Important for restrictions
- [ ] **Inline Images** - Visual steps in instructions

---

## 🖼️ Image Optimization Tips

### Featured Image
- **Dimensions:** 1200x800px minimum (3:2 ratio)
- **File Size:** 200-500KB (compress with TinyPNG)
- **Quality:** High resolution, well-lit
- **Subject:** Finished dish, hero shot
- **Background:** Clean, uncluttered
- **Alt Text:** Descriptive (e.g., "Stack of chocolate chip cookies on white plate")

### Inline Step Images (Optional)
- **Dimensions:** 800-1200px width
- **File Size:** 100-300KB each
- **Purpose:** Show technique or key visual cues
- **Placement:** Between instruction steps
- **Alt Text:** Describe what's shown (e.g., "Dough folded into thirds")

### Image Optimization Tools
- **TinyPNG** - https://tinypng.com (free, browser-based)
- **Squoosh** - https://squoosh.app (advanced, browser-based)
- **ImageOptim** - Mac desktop app
- **GIMP** - Free desktop software

---

## 🚀 Publishing Workflow

### Quick 10-Minute Recipe
1. **1 min** - Write title, select featured image
2. **2 min** - Write excerpt (1-2 sentences)
3. **3 min** - List ingredients in meta field
4. **3 min** - Write basic instructions
5. **1 min** - Fill time/servings/course fields
6. **Total: 10 minutes** ✅

### Full Optimized Recipe (20 minutes)
1. **2 min** - Title, featured image with alt text
2. **3 min** - Excerpt + SEO optimization
3. **4 min** - Detailed ingredients with measurements
4. **6 min** - Instructions with headings and images
5. **3 min** - All meta fields (nutrition, dietary, etc.)
6. **2 min** - Preview, test, publish
7. **Total: 20 minutes** ✅

---

## 📱 Preview Your Recipe

Before publishing, always preview:

1. Click **"Preview"** button (top right)
2. Check on desktop view
3. Test mobile view (resize browser or use DevTools)
4. Verify:
   - Featured image displays correctly
   - Ingredients list is readable
   - Instructions are clear
   - Meta facts bar shows all info
   - Print button works (test with Ctrl+P / Cmd+P)

---

## 🔍 SEO Tips

### Google Rich Results
Your recipe automatically generates JSON-LD structured data if you include:
- ✅ Title
- ✅ Ingredients
- ✅ Featured image
- ✅ Instructions

**To test:**
1. Publish recipe
2. Copy recipe URL
3. Visit: https://search.google.com/test/rich-results
4. Paste URL and click "Test URL"
5. Should show "Valid Recipe" result

### Search Optimization
- Use descriptive titles: "Classic Chocolate Chip Cookies" not just "Cookies"
- Include keywords in excerpt: "soft, chewy, chocolate"
- Fill cuisine and course fields (helps categorization)
- Add dietary tags (important search terms)
- Use clear H3 headings in instructions

---

## 🐛 Troubleshooting

### "Ingredients not showing"
- ✅ Make sure you filled the **"Ingredients"** field in meta box (not in content editor)
- ✅ Check one ingredient per line (press Enter after each)

### "Featured image not appearing"
- ✅ Verify you clicked **"Set featured image"** button (not just uploaded to media)
- ✅ Clear browser cache (Ctrl+Shift+R or Cmd+Shift+R)

### "Time not displaying"
- ✅ Use format: `30 minutes` or `30` or `1 hour 30`
- ✅ Fill either "Cook Time" or "Prep Time" (at least one)

### "JSON-LD not validating"
- ✅ Ensure ingredients field is filled (required for schema)
- ✅ Check featured image is set
- ✅ Verify recipe is published (not draft)

### "Print button not working"
- ✅ Check browser allows pop-ups
- ✅ Try Ctrl+P / Cmd+P instead

---

## 📚 Example Recipe (Copy This Structure)

### Title
```
Classic Homemade Pancakes
```

### Excerpt
```
Fluffy, golden pancakes with crispy edges. Perfect for weekend breakfast with maple syrup and butter!
```

### Ingredients (Meta Field)
```
2 cups all-purpose flour
2 tbsp white sugar
2 tsp baking powder
1 tsp salt
2 large eggs
1 1/2 cups milk
1/4 cup melted butter
1 tsp vanilla extract
```

### Instructions (Content Editor)
```
### Prepare the Batter

Whisk together flour, sugar, baking powder, and salt in a large bowl.

In a separate bowl, beat eggs, then mix in milk, melted butter, and vanilla.

Pour wet ingredients into dry ingredients. Stir until just combined (batter will be lumpy).

### Cook the Pancakes

Heat a griddle or large skillet over medium heat. Lightly grease with butter.

Pour 1/4 cup batter for each pancake onto hot griddle.

Cook until bubbles form on surface and edges look set, about 2-3 minutes.

Flip and cook until golden brown, another 2 minutes.

### Serve

Stack pancakes on a warm plate.

Top with butter and maple syrup.

Serve immediately while hot.
```

### Meta Fields
- **Prep Time:** `10 minutes`
- **Cook Time:** `15 minutes`
- **Servings:** `8 pancakes`
- **Calories:** `180`
- **Difficulty:** `Easy`
- **Cuisine:** `American`
- **Course:** `Breakfast`
- **Dietary Tags:** `vegetarian`

---

## 🎨 Styling Tips

The recipe template is pre-styled, but you can enhance with:

### Content Editor Tips
- Use **H3 headings** for section breaks (Prepare, Cook, Serve)
- Add **images** between steps (click + → Image)
- Use **bold** for emphasis: "until **golden brown**"
- Add **lists** for sub-steps or variations

### What NOT to Do
- ❌ Don't add ingredients list to content (use meta field)
- ❌ Don't add nutrition table manually (use meta field)
- ❌ Don't use H1 or H2 headings (reserved for title and sections)
- ❌ Don't add multiple featured images (only one per recipe)

---

## 🚦 Recipe Status Guide

### Draft
- Not visible to public
- Safe to work on
- Use for recipes in progress

### Pending Review
- Awaiting approval (if using editorial workflow)
- Not public yet

### Published
- Live on website
- Visible in search engines
- Generates JSON-LD structured data
- Appears in recipe archives

### Private
- Only you can see it
- Useful for testing or personal recipes

---

## 📞 Need Help?

### Common Questions

**Q: Can I use videos in recipes?**
A: Yes! Add YouTube/Vimeo embeds in content editor. Paste URL and it auto-embeds.

**Q: How do I edit a published recipe?**
A: Go to Dishes → All Dishes → Click recipe title → Make changes → Update

**Q: Can I duplicate a recipe?**
A: Install "Yoast Duplicate Post" plugin for quick duplication.

**Q: What if I don't have prep time?**
A: Leave it blank. Cook time is sufficient for JSON-LD.

**Q: Can I add multiple images?**
A: Yes! Add inline images in instructions. Only one featured image though.

**Q: Will old recipes still work?**
A: Yes! Template is backwards compatible.

---

## ✨ Pro Tips

1. **Batch Cook Recipes:** Photograph multiple dishes in one session, then write recipes later.

2. **Template Reuse:** Find a similar recipe, duplicate it, then edit for faster creation.

3. **Seasonal Tags:** Add seasonal keywords in excerpt (e.g., "perfect for summer BBQs").

4. **User Testing:** Ask family/friends to follow your recipe and adjust based on feedback.

5. **Mobile First:** Always preview on mobile - most users browse recipes on phones.

6. **Print Test:** Click Print button to ensure recipe looks good printed.

7. **Ingredient Order:** List in order of use for easier cooking.

8. **Time Accuracy:** Test recipe timing and adjust fields accordingly.

9. **Portion Sizing:** If recipe serves 4 but can double, mention in excerpt or instructions.

10. **Storage Info:** Add storage instructions at end (e.g., "Store in fridge for 3 days").

---

## 📖 Further Reading

- **WordPress Block Editor Guide:** https://wordpress.org/documentation/article/wordpress-block-editor/
- **Recipe SEO Best Practices:** https://developers.google.com/search/docs/appearance/structured-data/recipe
- **Food Photography Tips:** Search "food photography lighting" for tutorials
- **Schema.org Recipe:** https://schema.org/Recipe

---

**Ready to create amazing recipes!** 🍳👨‍🍳

Start with the 4 essentials (title, image, ingredients, instructions) and build from there. Your first recipe should take about 10 minutes.
