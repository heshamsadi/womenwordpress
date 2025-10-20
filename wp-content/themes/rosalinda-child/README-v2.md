# SmartLife Child Theme v2.0

## Overview
Production-ready WordPress child theme with zero CSS/JS files, using only core Gutenberg blocks and structured data.

## Features

### 1. Block Patterns (6 Article Templates)
**Location:** Patterns → SmartLife Articles in Block Editor

- **How-To Article** - Step-by-step guides with HowTo schema and FAQ support
- **Listicle** - Numbered lists for quick-read content
- **Comparison** - Side-by-side product/option comparisons
- **Day Plan** - 7/14/30-day action plans
- **Script Pack** - Copy-paste conversation scripts
- **Checklist** - Printable checklists

All patterns use core blocks only - styled automatically by parent theme.

### 2. Shortcodes

#### `[ad slot="..."]`
Ad placeholder with 5 slots: `top`, `mid`, `end`, `sidebar`, `footer`

```
[ad slot="top"]
```

Output: `<div id="ad-top" class="ad-slot" aria-hidden="true"></div>`

#### `[disclosure]`
Affiliate/ad disclosure paragraph (core block format)

```
[disclosure]
```

Output: Styled paragraph with disclosure text

**Works in:** Post content, category descriptions, anywhere shortcodes are enabled

### 3. Structured Data (Schema.org JSON-LD)

#### Always Generated:
- **Article** - Headline, dates, author, featured image
- **BreadcrumbList** - Home → Category → Post

#### Conditional (based on content markers):

**HowTo Schema**
Add marker: `<!-- SMARTLIFE:HOWTO -->`
Requirements: First `<ol>` after marker (up to 8 steps extracted)

**FAQ Schema**
Add markers:
```html
<!-- FAQ: start -->
<ul>
<li><strong>Q:</strong> Question text <br/><strong>A:</strong> Answer text</li>
</ul>
<!-- FAQ: end -->
```

Requirements: List items with `Q:` and `A:` format between markers

### 4. SEO-Optimized Category URLs

**3-Level Hierarchy:**
- Hub: `/category/health/`
- Subhub: `/category/health/nutrition/`
- Sub-page: `/category/health/nutrition/meal-plans/`

Clean slugs with no repetition. WordPress handles hierarchy automatically.

**Total Categories:** 96 (6 hubs × 3 subhubs × 4 sub-pages + hubs + subhubs)

### 5. Navigation Menu

**3-Level Dropdown Menu:**
- Top-level hubs visible in navbar
- Hover to reveal subhubs (level 2)
- Hover subhubs to reveal sub-pages (level 3)

All menu items link to real category archives using parent theme's templates.

## File Structure

```
rosalinda-child/
├── functions.php          # Main bootstrap (namespaced: SmartLife\Child)
├── functions-legacy.php   # Original category/menu functions
├── style.css             # Minimal child theme header only
├── patterns/             # Block pattern HTML files
│   ├── how-to.html
│   ├── listicle.html
│   ├── comparison.html
│   ├── plan.html
│   ├── script-pack.html
│   └── checklist.html
└── assets/
    └── js/
        └── menu-hover.js  # Dropdown menu fix
```

## Usage

### Creating Content with Patterns

1. Create new post
2. Click `+` → Browse patterns
3. Filter by "SmartLife Articles"
4. Insert pattern
5. Replace `%%TITLE%%` and placeholder content
6. Publish

### Adding Schema Markup

**For How-To articles:**
1. Insert How-To pattern
2. Marker `<!-- SMARTLIFE:HOWTO -->` is already included
3. Edit the `<ol>` steps
4. Publish → HowTo schema auto-generates

**For FAQ articles:**
1. Add this structure anywhere in content:
```html
<!-- FAQ: start -->
<ul>
<li><strong>Q:</strong> Your question? <br/><strong>A:</strong> Your answer.</li>
</ul>
<!-- FAQ: end -->
```
2. Publish → FAQPage schema auto-generates

### Managing Categories

**Seed all categories:**
Visit: `http://yoursite.com/?seed_categories=1&refresh=1`

**Recreate menu:**
Visit: `http://yoursite.com/?recreate_menu=1`

**Manual management:**
WordPress Admin → Posts → Categories

## Technical Details

### Namespace
All functions use `SmartLife\Child` namespace to avoid conflicts.

### Idempotency
- Pattern registration checks if pattern exists before registering
- Category seeding updates existing terms without duplicates
- Safe to run multiple times

### Escaping
All output properly escaped:
- `esc_html()` for text
- `esc_attr()` for attributes
- `esc_url()` for URLs
- `wp_json_encode()` for JSON-LD

### Performance
- No database writes except pattern/category registration
- Schema generation only on single posts (not on archives)
- All legacy functions preserved in separate file

### Compatibility
- WordPress 6.5+
- PHP 8.2+
- Parent theme: Rosalinda v1.0.8

## Support

All categories and menus are preserved in `functions-legacy.php`.

To revert to old system:
```php
// At bottom of functions.php:
require_once __DIR__ . '/functions-legacy.php';
```

## Changelog

### v2.0.0 (October 2025)
- Added namespaced functions (SmartLife\Child)
- Added 6 block patterns with core blocks only
- Added structured data (Article, Breadcrumb, HowTo, FAQ)
- Added shortcodes: [ad], [disclosure]
- Improved SEO URLs (removed slug prefixes)
- Separated legacy functions to dedicated file
- Zero CSS/JS/template overrides

### v1.0.0 (October 2025)
- Initial child theme
- Category structure (96 categories)
- 3-level navigation menu
- Menu hover fix
