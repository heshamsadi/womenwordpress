# Rosalinda Child Theme

This child theme is a lightweight scaffold for customizing the `rosalinda` parent theme.

What this contains

- `style.css` — child theme header (already present).
- `functions.php` — enqueues parent + child styles and loads child helpers.
- `theme.json` — minimal block editor settings for the child.
- `assets/css/child.css` — main stylesheet to place custom CSS.
- `inc/` — place child-specific helpers here (placeholders included).
- `.editorconfig` and `.phpcs.xml.dist` — basic development configs.

How to use

1. Activate the `Rosalinda Child` theme from Appearance → Themes.
2. Make CSS changes in `assets/css/child.css` (this is enqueued after the parent stylesheet).
3. When you need to change templates, copy the specific file from the parent theme into this child theme and edit only the parts you need.

Notes

- Don’t copy the entire parent theme unless necessary. Prefer small overrides and helpers in `inc/`.
- Replace `screenshot.png` with a proper 1200x900 image to show in the WP dashboard.
# Rosalinda Child Theme

A custom child theme for the Rosalinda WordPress theme, designed for the women1.local project.

## 📁 Theme Structure

```
rosalinda-child/
├── style.css          # Main stylesheet (imports parent + custom styles)
├── functions.php      # Custom functions and WordPress hooks
├── screenshot.png     # Theme preview image (optional)
└── README.md         # This file
```

## 🎯 Purpose

This child theme allows safe customization of the Rosalinda theme without losing changes during theme updates.

## ✅ Features

- **Safe Updates**: Parent theme can update without affecting customizations
- **Clean Structure**: Well-organized code with comments
- **Performance Optimized**: Proper stylesheet enqueuing
- **Security Enhanced**: Removes unnecessary WordPress features
- **Development Ready**: Includes examples for common customizations

## 🚀 Usage

### Activating the Child Theme
1. Go to WordPress Admin → Appearance → Themes
2. Activate "Rosalinda Child"
3. Your site will now use the child theme

### Adding Custom Styles
Edit `style.css` and add your custom CSS below the import statement:

```css
/* Your custom styles here */
.custom-class {
    color: #your-color;
}
```

### Adding Custom Functions
Edit `functions.php` to add:
- Custom post types
- Theme modifications
- WordPress hooks
- Plugin customizations

## 📝 Common Customizations

### Change Colors
```css
/* In style.css */
:root {
    --primary-color: #your-brand-color;
    --secondary-color: #your-secondary-color;
}
```

### Add Custom Fonts
```php
// In functions.php
function custom_fonts() {
    wp_enqueue_style('custom-fonts', 
        'https://fonts.googleapis.com/css2?family=Your+Font:wght@300;400;700'
    );
}
add_action('wp_enqueue_scripts', 'custom_fonts');
```

### Override Parent Templates
Copy template files from the parent theme to this child theme directory and modify as needed.

## 🔧 Development

### Local Development
- Site URL: http://women1.local
- Parent Theme: Rosalinda v1.0.8
- WordPress Version: Latest

### Git Repository
This theme is part of the womenwordpress repository:
https://github.com/heshamsadi/womenwordpress

## 📚 Resources

- [WordPress Child Themes Documentation](https://developer.wordpress.org/themes/advanced-topics/child-themes/)
- [Rosalinda Theme Documentation](http://rosalinda.axiomthemes.com/)
- [WordPress Codex](https://codex.wordpress.org/)

## 🐛 Troubleshooting

### Styles Not Loading
1. Check that parent theme is active
2. Clear any caching plugins
3. Verify file permissions

### Functions Not Working
1. Check for PHP syntax errors
2. Enable WordPress debug mode
3. Check error logs

---

**Created for women1.local project**  
**Version**: 1.0.0  
**Last Updated**: October 19, 2025