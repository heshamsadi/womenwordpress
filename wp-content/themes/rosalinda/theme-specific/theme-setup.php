<?php
/**
 * Setup theme-specific fonts and colors
 *
 * @package WordPress
 * @subpackage ROSALINDA
 * @since ROSALINDA 1.0.22
 */

// If this theme is a free version of premium theme
if ( ! defined( 'ROSALINDA_THEME_FREE' ) ) {
	define( 'ROSALINDA_THEME_FREE', false );
}
if ( ! defined( 'ROSALINDA_THEME_FREE_WP' ) ) {
	define( 'ROSALINDA_THEME_FREE_WP', false );
}

// If this theme uses multiple skins
if ( ! defined( 'ROSALINDA_ALLOW_SKINS' ) ) {
	define( 'ROSALINDA_ALLOW_SKINS', false );
}
if ( ! defined( 'ROSALINDA_DEFAULT_SKIN' ) ) {
	define( 'ROSALINDA_DEFAULT_SKIN', 'default' );
}

// Theme storage
// Attention! Must be in the global namespace to compatibility with WP CLI
$GLOBALS['ROSALINDA_STORAGE'] = array(

	// Theme required plugin's slugs
	'required_plugins'   => array_merge(

		// List of plugins for both - FREE and PREMIUM versions
		//-----------------------------------------------------
		array(
			// Required plugins
			// DON'T COMMENT OR REMOVE NEXT LINES!
			'trx_addons'         => esc_html__( 'ThemeREX Addons', 'rosalinda' ),

			// Recommended (supported) plugins for both (lite and full) versions
			// If plugin not need - comment (or remove) it
			'trx_updater'        => esc_html__( 'ThemeREX Updater', 'rosalinda' ),
			'trx_socials'        => esc_html__( 'ThemeREX Socials', 'rosalinda' ),
			'contact-form-7'     => esc_html__( 'Contact Form 7', 'rosalinda' ),
			'mailchimp-for-wp'   => esc_html__( 'MailChimp for WP', 'rosalinda' ),
			'gutenberg'          => esc_html__( 'Gutenberg', 'rosalinda' ),
			'instagram-feed'     => esc_html__( 'Smash Balloon Instagram Feed', 'rosalinda' ),
			'wp-gdpr-compliance' => esc_html__( 'Cookie Information', 'rosalinda' ),
		),
		// List of plugins for the FREE version only
		//-----------------------------------------------------
		ROSALINDA_THEME_FREE
			? array(
				// Recommended (supported) plugins for the FREE (lite) version
				'siteorigin-panels' => esc_html__( 'SiteOrigin Panels', 'rosalinda' ),
			)

		// List of plugins for the PREMIUM version only
		//-----------------------------------------------------
			: array(
				// Recommended (supported) plugins for the PRO (full) version
				// If plugin not need - comment (or remove) it
				'booked'                     => esc_html__( 'Booked Appointments', 'rosalinda' ),
				'essential-grid'             => esc_html__( 'Essential Grid', 'rosalinda' ),
				'js_composer'                => esc_html__( 'WPBakery PageBuilder', 'rosalinda' ),
                'revslider'                  => esc_html__( 'Revolution Slider', 'rosalinda' ),
			)
	),

	// Theme-specific blog layouts
	'blog_styles'        => array_merge(
		// Layouts for both - FREE and PREMIUM versions
		//-----------------------------------------------------
		array(
			'excerpt' => array(
				'title'   => esc_html__( 'Standard', 'rosalinda' ),
				'archive' => 'index-excerpt',
				'item'    => 'content-excerpt',
				'styles'  => 'excerpt',
			),
			'classic' => array(
				'title'   => esc_html__( 'Classic', 'rosalinda' ),
				'archive' => 'index-classic',
				'item'    => 'content-classic',
				'columns' => array( 2, 3 ),
				'styles'  => 'classic',
			),
		),
		// Layouts for the FREE version only
		//-----------------------------------------------------
		ROSALINDA_THEME_FREE
		? array()

		// Layouts for the PREMIUM version only
		//-----------------------------------------------------
		: array(
			'masonry'   => array(
				'title'   => esc_html__( 'Masonry', 'rosalinda' ),
				'archive' => 'index-classic',
				'item'    => 'content-classic',
				'columns' => array( 2, 3 ),
				'styles'  => 'masonry',
			),
			'portfolio' => array(
				'title'   => esc_html__( 'Portfolio', 'rosalinda' ),
				'archive' => 'index-portfolio',
				'item'    => 'content-portfolio',
				'columns' => array( 2, 3, 4 ),
				'styles'  => 'portfolio',
			),
			'gallery'   => array(
				'title'   => esc_html__( 'Gallery', 'rosalinda' ),
				'archive' => 'index-portfolio',
				'item'    => 'content-portfolio-gallery',
				'columns' => array( 2, 3, 4 ),
				'styles'  => array( 'portfolio', 'gallery' ),
			),
			'chess'     => array(
				'title'   => esc_html__( 'Chess', 'rosalinda' ),
				'archive' => 'index-chess',
				'item'    => 'content-chess',
				'columns' => array( 1, 2, 3 ),
				'styles'  => 'chess',
			),
		)
	),

	// Key validator: market[env|loc]-vendor[axiom|ancora|themerex]
	'theme_pro_key'      => 'env-axiom',

	// Theme-specific URLs (will be escaped in place of the output)
	'theme_demo_url'     => rosalinda_get_protocol() . '://rosalinda.axiomthemes.com',
	'theme_doc_url'      => rosalinda_get_protocol() . '://rosalinda.axiomthemes.com/doc',
	'theme_download_url' => rosalinda_get_protocol() . '://1.envato.market/c/1262870/275988/4415?subId1=axioma&u=themeforest.net/item/rosalinda-health-coach-vegetarian-lifestyle-blog-wordpress-theme/22986587?s_rank=14',

    'theme_support_url'  => rosalinda_get_protocol() . '://themerex.net/support/',                    // Axiom

	'theme_video_url'    => rosalinda_get_protocol() . '://www.youtube.com/channel/UCBjqhuwKj3MfE3B6Hg2oA8Q',  // Axiom

	'theme_privacy_url'  => rosalinda_get_protocol() . '://axiomthemes.com/privacy-policy/',                   // Axiom

	// Comma separated slugs of theme-specific categories (for get relevant news in the dashboard widget)
	// (i.e. 'children,kindergarten')
	'theme_categories'   => '',

	// Responsive resolutions
	// Parameters to create css media query: min, max
	'responsive'         => array(
		// By device
		'wide'     => array(
			'min' => 2160
		),
		'desktop'  => array(
			'min' => 1680,
			'max' => 2159,
		),
		'notebook' => array(
			'min' => 1280,
			'max' => 1679,
		),
		'tablet'   => array(
			'min' => 768,
			'max' => 1279,
		),
		'mobile'   => array( 'max' => 767 ),
		// By size
		'xxl'      => array( 'max' => 1679 ),
		'xl'       => array( 'max' => 1439 ),
		'lg'       => array( 'max' => 1279 ),
		'md'       => array( 'max' => 1023 ),
		'sm'       => array( 'max' => 767 ),
		'sm_wp'    => array( 'max' => 600 ),
		'xs'       => array( 'max' => 479 ),
	),
);

// Theme init priorities:
// Action 'after_setup_theme'
// 1 - register filters to add/remove lists items in the Theme Options
// 2 - create Theme Options
// 3 - add/remove Theme Options elements
// 5 - load Theme Options. Attention! After this step you can use only basic options (not overriden)
// 9 - register other filters (for installer, etc.)
//10 - standard Theme init procedures (not ordered)
// Action 'wp_loaded'
// 1 - detect override mode. Attention! Only after this step you can use overriden options (separate values for the shop, courses, etc.)

if ( ! function_exists( 'rosalinda_customizer_theme_setup1' ) ) {
	add_action( 'after_setup_theme', 'rosalinda_customizer_theme_setup1', 1 );
	function rosalinda_customizer_theme_setup1() {

		// -----------------------------------------------------------------
		// -- ONLY FOR PROGRAMMERS, NOT FOR CUSTOMER
		// -- Internal theme settings
		// -----------------------------------------------------------------
		rosalinda_storage_set(
			'settings', array(

				'duplicate_options'      => 'child',            // none  - use separate options for the main and the child-theme
																// child - duplicate theme options from the main theme to the child-theme only
																// both  - sinchronize changes in the theme options between main and child themes

				'customize_refresh'      => 'auto',             // Refresh method for preview area in the Appearance - Customize:
																// auto - refresh preview area on change each field with Theme Options
																// manual - refresh only obn press button 'Refresh' at the top of Customize frame

				'max_load_fonts'         => 5,                  // Max fonts number to load from Google fonts or from uploaded fonts

				'comment_after_name'     => true,               // Place 'comment' field after the 'name' and 'email'

				'icons_selector'         => 'internal',         // Icons selector in the shortcodes:
																// vc (default) - standard VC (very slow) or Elementor's icons selector (not support images and svg)
																// internal - internal popup with plugin's or theme's icons list (fast and support images and svg)

				'icons_type'             => 'icons',            // Type of icons (if 'icons_selector' is 'internal'):
																// icons  - use font icons to present icons
																// images - use images from theme's folder trx_addons/css/icons.png
																// svg    - use svg from theme's folder trx_addons/css/icons.svg

				'socials_type'           => 'icons',            // Type of socials icons (if 'icons_selector' is 'internal'):
																// icons  - use font icons to present social networks
																// images - use images from theme's folder trx_addons/css/icons.png
																// svg    - use svg from theme's folder trx_addons/css/icons.svg

				'check_min_version'      => true,               // Check if exists a .min version of .css and .js and return path to it
																// instead the path to the original file
																// (if debug_mode is off and modification time of the original file < time of the .min file)

				'autoselect_menu'        => false,              // Show any menu if no menu selected in the location 'main_menu'
																// (for example, the theme is just activated)

				'disable_jquery_ui'      => false,              // Prevent loading custom jQuery UI libraries in the third-party plugins

				'use_mediaelements'      => true,               // Load script "Media Elements" to play video and audio

				'tgmpa_upload'           => false,              // Allow upload not pre-packaged plugins via TGMPA

				'allow_no_image'         => false,              // Allow use image placeholder if no image present in the blog, related posts, post navigation, etc.

				'separate_schemes'       => true,               // Save color schemes to the separate files __color_xxx.css (true) or append its to the __custom.css (false)

				'allow_fullscreen'       => false,              // Allow cases 'fullscreen' and 'fullwide' for the body style in the Theme Options
																// In the Page Options this styles are present always
																// (can be removed if filter 'rosalinda_filter_allow_fullscreen' return false)

				'attachments_navigation' => false,              // Add arrows on the single attachment page to navigate to the prev/next attachment
				
				'gutenberg_safe_mode'    => array(),            // 'vc', 'elementor' - Prevent simultaneous editing of posts for Gutenberg and other PageBuilders (VC, Elementor)

				'allow_gutenberg_blocks' => true,               // Allow our shortcodes and widgets as blocks in the Gutenberg (not ready yet - in the development now)

				'subtitle_above_title'   => true,               // Put subtitle above the title in the shortcodes

				'add_hide_on_xxx' => 'replace',                 // Add our breakpoints to the Responsive section of each element
																// 'add' - add our breakpoints after Elementor's
																// 'replace' - add our breakpoints instead Elementor's
																// 'none' - don't add our breakpoints (using only Elementor's)
			)
		);

		// -----------------------------------------------------------------
		// -- Theme fonts (Google and/or custom fonts)
		// -----------------------------------------------------------------

		// Fonts to load when theme start
		// It can be Google fonts or uploaded fonts, placed in the folder /css/font-face/font-name inside the theme folder
		// Attention! Font's folder must have name equal to the font's name, with spaces replaced on the dash '-'
		
		rosalinda_storage_set(
			'load_fonts', array(
				// Google font
				array(
					'name'   => 'Signika',
					'family' => 'sans-serif',
					'styles' => '300,400,600,700',     // Parameter 'style' used only for the Google fonts
				),
                array(
					'name'   => 'Noto Serif',
					'family' => 'serif',
					'styles' => '400, 700',     // Parameter 'style' used only for the Google fonts
				),
                array(
					'name'   => 'Rancho',
					'family' => 'cursive',
					'styles' => '400',     // Parameter 'style' used only for the Google fonts
				),

			)
		);

		// Characters subset for the Google fonts. Available values are: latin,latin-ext,cyrillic,cyrillic-ext,greek,greek-ext,vietnamese
		rosalinda_storage_set( 'load_fonts_subset', 'latin,latin-ext' );

		// Settings of the main tags
		// Attention! Font name in the parameter 'font-family' will be enclosed in the quotes and no spaces after comma!
        
		rosalinda_storage_set(
			'theme_fonts', array(
				'p'       => array(
					'title'           => esc_html__( 'Main text', 'rosalinda' ),
					'description'     => esc_html__( 'Font settings of the main text of the site. Attention! For correct display of the site on mobile devices, use only units "rem", "em" or "ex"', 'rosalinda' ),
					'font-family'     => '"Noto Serif",serif',
					'font-size'       => '1rem',
					'font-weight'     => '400',
					'font-style'      => 'normal',
					'line-height'     => '1.6em',
					'text-decoration' => 'none',
					'text-transform'  => 'none',
					'letter-spacing'  => '0px',
					'margin-top'      => '0em',
					'margin-bottom'   => '1.6em',
				),
				'h1'      => array(
					'title'           => esc_html__( 'Heading 1', 'rosalinda' ),
					'font-family'     => '"Signika",sans-serif',
					'font-size'       => '5.6667em',
					'font-weight'     => '700',
					'font-style'      => 'normal',
					'line-height'     => '1em',
					'text-decoration' => 'none',
					'text-transform'  => 'none',
					'letter-spacing'  => '-2.9px',
					'margin-top'      => '1.3em',
					'margin-bottom'   => '0.8em',
				),
				'h2'      => array(
					'title'           => esc_html__( 'Heading 2', 'rosalinda' ),
					'font-family'     => '"Signika",sans-serif',
					'font-size'       => '4.66677em',
					'font-weight'     => '600',
					'font-style'      => 'normal',
					'line-height'     => '1.09em',
					'text-decoration' => 'none',
					'text-transform'  => 'none',
					'letter-spacing'  => '-2.6px',
					'margin-top'      => '1.22em',
					'margin-bottom'   => '0.74em',
				),
				'h3'      => array(
					'title'           => esc_html__( 'Heading 3', 'rosalinda' ),
					'font-family'     => '"Signika",sans-serif',
					'font-size'       => '3.2em',
					'font-weight'     => '600',
					'font-style'      => 'normal',
					'line-height'     => '1.16em',
					'text-decoration' => 'none',
					'text-transform'  => 'none',
					'letter-spacing'  => '-1.3px',
					'margin-top'      => '1.545em',
					'margin-bottom'   => '0.83em',
				),
				'h4'      => array(
					'title'           => esc_html__( 'Heading 4', 'rosalinda' ),
					'font-family'     => '"Signika",sans-serif',
					'font-size'       => '2.4em',
					'font-weight'     => '600',
					'font-style'      => 'normal',
					'line-height'     => '1.18em',
					'text-decoration' => 'none',
					'text-transform'  => 'none',
					'letter-spacing'  => '-1px',
					'margin-top'      => '1.6923em',
					'margin-bottom'   => '0.9em',
				),
				'h5'      => array(
					'title'           => esc_html__( 'Heading 5', 'rosalinda' ),
					'font-family'     => '"Signika",sans-serif',
					'font-size'       => '2em',
					'font-weight'     => '600',
					'font-style'      => 'normal',
					'line-height'     => '1.22em',
					'text-decoration' => 'none',
					'text-transform'  => 'none',
					'letter-spacing'  => '-0.8px',
					'margin-top'      => '1.7em',
					'margin-bottom'   => '0.8em',
				),
				'h6'      => array(
					'title'           => esc_html__( 'Heading 6', 'rosalinda' ),
					'font-family'     => '"Signika",sans-serif',
					'font-size'       => '1.6em',
					'font-weight'     => '600',
					'font-style'      => 'normal',
					'line-height'     => '1.25em',
					'text-decoration' => 'none',
					'text-transform'  => 'none',
					'letter-spacing'  => '-.65px',
					'margin-top'      => '1.55em',
					'margin-bottom'   => '0.99em',
				),
				'logo'    => array(
					'title'           => esc_html__( 'Logo text', 'rosalinda' ),
					'description'     => esc_html__( 'Font settings of the text case of the logo', 'rosalinda' ),
					'font-family'     => '"Signika",sans-serif',
					'font-size'       => '1.8em',
					'font-weight'     => '400',
					'font-style'      => 'normal',
					'line-height'     => '1.25em',
					'text-decoration' => 'none',
					'text-transform'  => 'uppercase',
					'letter-spacing'  => '1px',
				),
				'button'  => array(
					'title'           => esc_html__( 'Buttons', 'rosalinda' ),
					'font-family'     => '"Signika",sans-serif',
					'font-size'       => '14px',
					'font-weight'     => '700',
					'font-style'      => 'normal',
					'line-height'     => '20px',
					'text-decoration' => 'none',
					'text-transform'  => 'uppercase',
					'letter-spacing'  => '0',
				),
				'input'   => array(
					'title'           => esc_html__( 'Input fields', 'rosalinda' ),
					'description'     => esc_html__( 'Font settings of the input fields, dropdowns and textareas', 'rosalinda' ),
					'font-family'     => 'inherit',
					'font-size'       => '1em',
					'font-weight'     => '400',
					'font-style'      => 'normal',
					'line-height'     => '1.5em', // Attention! Firefox don't allow line-height less then 1.5em in the select
					'text-decoration' => 'none',
					'text-transform'  => 'none',
					'letter-spacing'  => '0px',
				),
				'info'    => array(
					'title'           => esc_html__( 'Post meta', 'rosalinda' ),
					'description'     => esc_html__( 'Font settings of the post meta: date, counters, share, etc.', 'rosalinda' ),
					'font-family'     => '"Signika",sans-serif',
					'font-size'       => '1.0667em',  // Old value '13px' don't allow using 'font zoom' in the custom blog items
					'font-weight'     => '600',
					'font-style'      => 'normal',
					'line-height'     => '1.5em',
					'text-decoration' => 'none',
					'text-transform'  => 'none',
					'letter-spacing'  => '-.5px',
					'margin-top'      => '0.4em',
					'margin-bottom'   => '',
				),
				'menu'    => array(
					'title'           => esc_html__( 'Main menu', 'rosalinda' ),
					'description'     => esc_html__( 'Font settings of the main menu items', 'rosalinda' ),
					'font-family'     => '"Signika",sans-serif',
					'font-size'       => '1em',
					'font-weight'     => '700',
					'font-style'      => 'normal',
					'line-height'     => '1.5em',
					'text-decoration' => 'none',
					'text-transform'  => 'uppercase',
					'letter-spacing'  => '-.8px',
				),
				'submenu' => array(
					'title'           => esc_html__( 'Dropdown menu', 'rosalinda' ),
					'description'     => esc_html__( 'Font settings of the dropdown menu items', 'rosalinda' ),
					'font-family'     => '"Signika",sans-serif',
					'font-size'       => '1em',
					'font-weight'     => '700',
					'font-style'      => 'normal',
					'line-height'     => '1.5em',
					'text-decoration' => 'none',
					'text-transform'  => 'uppercase',
					'letter-spacing'  => '-.8px',
				),
                'other' => array(
                    'title'           => esc_html__( 'Other', 'rosalinda' ),
                    'description'     => esc_html__( 'Other Font for Title', 'rosalinda' ),
                    'font-family'     => '"Rancho",cursive',
                ),
			)
		);

		// -----------------------------------------------------------------
		// -- Theme colors for customizer
		// -- Attention! Inner scheme must be last in the array below
		// -----------------------------------------------------------------
		rosalinda_storage_set(
			'scheme_color_groups', array(
				'main'    => array(
					'title'       => esc_html__( 'Main', 'rosalinda' ),
					'description' => esc_html__( 'Colors of the main content area', 'rosalinda' ),
				),
				'alter'   => array(
					'title'       => esc_html__( 'Alter', 'rosalinda' ),
					'description' => esc_html__( 'Colors of the alternative blocks (sidebars, etc.)', 'rosalinda' ),
				),
				'extra'   => array(
					'title'       => esc_html__( 'Extra', 'rosalinda' ),
					'description' => esc_html__( 'Colors of the extra blocks (dropdowns, price blocks, table headers, etc.)', 'rosalinda' ),
				),
				'inverse' => array(
					'title'       => esc_html__( 'Inverse', 'rosalinda' ),
					'description' => esc_html__( 'Colors of the inverse blocks - when link color used as background of the block (dropdowns, blockquotes, etc.)', 'rosalinda' ),
				),
				'input'   => array(
					'title'       => esc_html__( 'Input', 'rosalinda' ),
					'description' => esc_html__( 'Colors of the form fields (text field, textarea, select, etc.)', 'rosalinda' ),
				),
			)
		);
		rosalinda_storage_set(
			'scheme_color_names', array(
				'bg_color'    => array(
					'title'       => esc_html__( 'Background color', 'rosalinda' ),
					'description' => esc_html__( 'Background color of this block in the normal state', 'rosalinda' ),
				),
				'bg_hover'    => array(
					'title'       => esc_html__( 'Background hover', 'rosalinda' ),
					'description' => esc_html__( 'Background color of this block in the hovered state', 'rosalinda' ),
				),
				'bd_color'    => array(
					'title'       => esc_html__( 'Border color', 'rosalinda' ),
					'description' => esc_html__( 'Border color of this block in the normal state', 'rosalinda' ),
				),
				'bd_hover'    => array(
					'title'       => esc_html__( 'Border hover', 'rosalinda' ),
					'description' => esc_html__( 'Border color of this block in the hovered state', 'rosalinda' ),
				),
				'text'        => array(
					'title'       => esc_html__( 'Text', 'rosalinda' ),
					'description' => esc_html__( 'Color of the plain text inside this block', 'rosalinda' ),
				),
				'text_dark'   => array(
					'title'       => esc_html__( 'Text dark', 'rosalinda' ),
					'description' => esc_html__( 'Color of the dark text (bold, header, etc.) inside this block', 'rosalinda' ),
				),
				'text_light'  => array(
					'title'       => esc_html__( 'Text light', 'rosalinda' ),
					'description' => esc_html__( 'Color of the light text (post meta, etc.) inside this block', 'rosalinda' ),
				),
				'text_link'   => array(
					'title'       => esc_html__( 'Link', 'rosalinda' ),
					'description' => esc_html__( 'Color of the links inside this block', 'rosalinda' ),
				),
				'text_hover'  => array(
					'title'       => esc_html__( 'Link hover', 'rosalinda' ),
					'description' => esc_html__( 'Color of the hovered state of links inside this block', 'rosalinda' ),
				),
				'text_link2'  => array(
					'title'       => esc_html__( 'Link 2', 'rosalinda' ),
					'description' => esc_html__( 'Color of the accented texts (areas) inside this block', 'rosalinda' ),
				),
				'text_hover2' => array(
					'title'       => esc_html__( 'Link 2 hover', 'rosalinda' ),
					'description' => esc_html__( 'Color of the hovered state of accented texts (areas) inside this block', 'rosalinda' ),
				),
				'text_link3'  => array(
					'title'       => esc_html__( 'Link 3', 'rosalinda' ),
					'description' => esc_html__( 'Color of the other accented texts (buttons) inside this block', 'rosalinda' ),
				),
				'text_hover3' => array(
					'title'       => esc_html__( 'Link 3 hover', 'rosalinda' ),
					'description' => esc_html__( 'Color of the hovered state of other accented texts (buttons) inside this block', 'rosalinda' ),
				),
			)
		);
		rosalinda_storage_set(
			'schemes', array(

				// Color scheme: 'default'
				'default' => array(
					'title'    => esc_html__( 'Default', 'rosalinda' ),
					'internal' => true,
					'colors'   => array(

						// Whole block border and background
						'bg_color'         => '#ffffff', //+
						'bd_color'         => '#eae8e5', //+

						// Text and links colors
						'text'             => '#928884', //+
						'text_light'       => '#a2978e', //+
						'text_dark'        => '#433833', //+
						'text_link'        => '#e29979', //+
						'text_hover'       => '#a3b82e', //+
						'text_link2'       => '#f2a88e', //+
						'text_hover2'      => '#8be77c',
						'text_link3'       => '#ddb837',
						'text_hover3'      => '#9bba09', //+

						// Alternative blocks (sidebar, tabs, alternative blocks, etc.)
						'alter_bg_color'   => '#eee9e4', //+
						'alter_bg_hover'   => '#f3f2ee', //+
						'alter_bd_color'   => '#d8d2cc', //+
						'alter_bd_hover'   => '#f0eae5', //+
						'alter_text'       => '#928884', //+
						'alter_light'      => '#a2978e', //+
						'alter_dark'       => '#433833', //+
						'alter_link'       => '#e29979', //+
						'alter_hover'      => '#a3b82e', //+
						'alter_link2'      => '#8c8c8c', //+
						'alter_hover2'     => '#80d572',
						'alter_link3'      => '#eec432',
						'alter_hover3'     => '#b47a66', //+

						// Extra blocks (submenu, tabs, color blocks, etc.)
						'extra_bg_color'   => '#e29979', //+
						'extra_bg_hover'   => '#28272e',
						'extra_bd_color'   => '#ffffff', //+
						'extra_bd_hover'   => '#3d3d3d',
						'extra_text'       => '#928884', //+
						'extra_light'      => '#a2978e', //+
						'extra_dark'       => '#ffffff', //+
						'extra_link'       => '#ffffff', //+
						'extra_hover'      => '#fe7259',
						'extra_link2'      => '#80d572',
						'extra_hover2'     => '#8be77c',
						'extra_link3'      => '#ddb837',
						'extra_hover3'     => '#eec432',

						// Input fields (form's fields and textarea)
						'input_bg_color'   => '#eee9e4', //+
						'input_bg_hover'   => '#ffffff', //+
						'input_bd_color'   => '#e7eaed',
						'input_bd_hover'   => '#e29979', //+
						'input_text'       => '#928884', //+
						'input_light'      => '#a7a7a7',
						'input_dark'       => '#433833', //+

						// Inverse blocks (text and links on the 'text_link' background)
						'inverse_bd_color' => '#eee9e4', //+
						'inverse_bd_hover' => '#5aa4a9',
						'inverse_text'     => '#ffffff', //+
						'inverse_light'    => '#333333',
						'inverse_dark'     => '#433833', //+
						'inverse_link'     => '#ffffff', //+
						'inverse_hover'    => '#433833', //+
					),
				),

				// Color scheme: 'dark'
				'dark'    => array(
					'title'    => esc_html__( 'Dark', 'rosalinda' ),
					'internal' => true,
					'colors'   => array(

						// Whole block border and background
						'bg_color'         => '#433833', //+
						'bd_color'         => '#3e3836', //+

						// Text and links colors
						'text'             => '#cccccc', //+
						'text_light'       => '#a7a7a7', //+
						'text_dark'        => '#ffffff', //+
						'text_link'        => '#e29979', //+
						'text_hover'       => '#a3b82e', //+
						'text_link2'       => '#f2a88e', //+
						'text_hover2'      => '#8be77c',
						'text_link3'       => '#ddb837',
						'text_hover3'      => '#9bba09', //+

						// Alternative blocks (sidebar, tabs, alternative blocks, etc.)
						'alter_bg_color'   => '#372d29', //+
						'alter_bg_hover'   => '#1d1b1b', //+
						'alter_bd_color'   => '#3e3836', //+
						'alter_bd_hover'   => '#4a4a4a',
						'alter_text'       => '#cccccc', //+
						'alter_light'      => '#e29979', //+
						'alter_dark'       => '#ffffff', //+
						'alter_link'       => '#e29979', //+
						'alter_hover'      => '#a3b82e', //+
						'alter_link2'      => '#8c8c8c', //+
						'alter_hover2'     => '#80d572',
						'alter_link3'      => '#eec432',
						'alter_hover3'     => '#b47a66', //+

						// Extra blocks (submenu, tabs, color blocks, etc.)
						'extra_bg_color'   => '#e29979', //+
						'extra_bg_hover'   => '#242222', //+
						'extra_bd_color'   => '#e5e5e5', //+
						'extra_bd_hover'   => '#4a4a4a',
						'extra_text'       => '#cccccc', //+
						'extra_light'      => '#c3c3c3', //+
						'extra_dark'       => '#ffffff', //+
						'extra_link'       => '#ffffff', //+
						'extra_hover'      => '#fe7259',
						'extra_link2'      => '#80d572',
						'extra_hover2'     => '#8be77c',
						'extra_link3'      => '#ddb837',
						'extra_hover3'     => '#eec432',

						// Input fields (form's fields and textarea)
						'input_bg_color'   => '#ffffff', //+
						'input_bg_hover'   => '#ffffff', //+
						'input_bd_color'   => '#2e2d32',
						'input_bd_hover'   => '#e29979', //+
						'input_text'       => '#928884', //+
						'input_light'      => '#6f6f6f',
						'input_dark'       => '#928884', //+

						// Inverse blocks (text and links on the 'text_link' background)
						'inverse_bd_color' => '#ffffff', //+
						'inverse_bd_hover' => '#ffffff', //-
						'inverse_text'     => '#ffffff', //+
						'inverse_light'    => '#6f6f6f',
						'inverse_dark'     => '#433833', //+
						'inverse_link'     => '#ffffff', //+
						'inverse_hover'    => '#372d29', //+
					),
				),

			)
		);

		rosalinda_storage_set( 'schemes_original', rosalinda_storage_get( 'schemes' ) );

		// Simple scheme editor: lists the colors to edit in the "Simple" mode.
		// For each color you can set the array of 'slave' colors and brightness factors that are used to generate new values,
		// when 'main' color is changed
		// Leave 'slave' arrays empty if your scheme does not have a color dependency
		rosalinda_storage_set(
			'schemes_simple', array(
				'text_link'        => array(
					'alter_hover'      => 1,
					'extra_link'       => 1,
					'inverse_bd_color' => 0.85,
					'inverse_bd_hover' => 0.7,
				),
				'text_hover'       => array(
					'alter_link'  => 1,
					'extra_hover' => 1,
				),
				'text_link2'       => array(
					'alter_hover2' => 1,
					'extra_link2'  => 1,
				),
				'text_hover2'      => array(
					'alter_link2'  => 1,
					'extra_hover2' => 1,
				),
				'text_link3'       => array(
					'alter_hover3' => 1,
					'extra_link3'  => 1,
				),
				'text_hover3'      => array(
					'alter_link3'  => 1,
					'extra_hover3' => 1,
				),
				'alter_link'       => array(),
				'alter_hover'      => array(),
				'alter_link2'      => array(),
				'alter_hover2'     => array(),
				'alter_link3'      => array(),
				'alter_hover3'     => array(),
				'extra_link'       => array(),
				'extra_hover'      => array(),
				'extra_link2'      => array(),
				'extra_hover2'     => array(),
				'extra_link3'      => array(),
				'extra_hover3'     => array(),
				'inverse_bd_color' => array(),
				'inverse_bd_hover' => array(),
			)
		);

		// Additional colors for each scheme
		// Parameters:	'color' - name of the color from the scheme that should be used as source for the transformation
		//				'alpha' - to make color transparent (0.0 - 1.0)
		//				'hue', 'saturation', 'brightness' - inc/dec value for each color's component
		rosalinda_storage_set(
			'scheme_colors_add', array(
				'bg_color_0'        => array(
					'color' => 'bg_color',
					'alpha' => 0,
				),
				'bg_color_04'       => array(
					'color' => 'bg_color',
					'alpha' => 0.2,
				),
                'bg_color_02'       => array(
					'color' => 'bg_color',
					'alpha' => 0.2,
				),
				'bg_color_07'       => array(
					'color' => 'bg_color',
					'alpha' => 0.7,
				),
				'bg_color_08'       => array(
					'color' => 'bg_color',
					'alpha' => 0.8,
				),
				'bg_color_09'       => array(
					'color' => 'bg_color',
					'alpha' => 0.9,
				),
				'alter_bg_color_07' => array(
					'color' => 'alter_bg_color',
					'alpha' => 0.7,
				),
				'alter_bg_color_04' => array(
					'color' => 'alter_bg_color',
					'alpha' => 0.4,
				),
				'alter_bg_color_02' => array(
					'color' => 'alter_bg_color',
					'alpha' => 0.2,
				),
				'alter_bd_color_02' => array(
					'color' => 'alter_bd_color',
					'alpha' => 0.2,
				),
				'alter_link_02'     => array(
					'color' => 'alter_link',
					'alpha' => 0.2,
				),
				'alter_link_07'     => array(
					'color' => 'alter_link',
					'alpha' => 0.7,
				),
				'extra_bg_color_07' => array(
					'color' => 'extra_bg_color',
					'alpha' => 0.7,
				),
				'extra_link_02'     => array(
					'color' => 'extra_link',
					'alpha' => 0.2,
				),
				'extra_link_07'     => array(
					'color' => 'extra_link',
					'alpha' => 0.7,
				),
				'text_dark_07'      => array(
					'color' => 'text_dark',
					'alpha' => 0.7,
				),
				'text_link_02'      => array(
					'color' => 'text_link',
					'alpha' => 0.2,
				),
				'text_link_07'      => array(
					'color' => 'text_link',
					'alpha' => 0.7,
				),
                'text_link2_07'      => array(
					'color' => 'text_link',
					'alpha' => 0.7,
				),
				'text_link_blend'   => array(
					'color'      => 'text_link',
					'hue'        => 2,
					'saturation' => -5,
					'brightness' => 5,
				),
				'alter_link_blend'  => array(
					'color'      => 'alter_link',
					'hue'        => 2,
					'saturation' => -5,
					'brightness' => 5,
				),
			)
		);

		// Parameters to set order of schemes in the css
		rosalinda_storage_set(
			'schemes_sorted', array(
				'color_scheme',
				'header_scheme',
				'menu_scheme',
				'sidebar_scheme',
				'footer_scheme',
			)
		);

		// -----------------------------------------------------------------
		// -- Theme specific thumb sizes
		// -----------------------------------------------------------------
		rosalinda_storage_set(
			'theme_thumbs', apply_filters(
				'rosalinda_filter_add_thumb_sizes', array(
					// Width of the image is equal to the content area width (without sidebar)
					// Height is fixed
					'rosalinda-thumb-huge'        => array(
						'size'  => array( 1170, 658, true ),
						'title' => esc_html__( 'Huge image', 'rosalinda' ),
						'subst' => 'trx_addons-thumb-huge',
					),
					// Width of the image is equal to the content area width (with sidebar)
					// Height is fixed
					'rosalinda-thumb-big'         => array(
						'size'  => array( 760, 428, true ),
						'title' => esc_html__( 'Large image', 'rosalinda' ),
						'subst' => 'trx_addons-thumb-big',
					),

					// Width of the image is equal to the 1/3 of the content area width (without sidebar)
					// Height is fixed
					'rosalinda-thumb-med'         => array(
						'size'  => array( 370, 208, true ),
						'title' => esc_html__( 'Medium image', 'rosalinda' ),
						'subst' => 'trx_addons-thumb-medium',
					),

					// Small square image (for avatars in comments, etc.)
					'rosalinda-thumb-tiny'        => array(
						'size'  => array( 90, 90, true ),
						'title' => esc_html__( 'Small square avatar', 'rosalinda' ),
						'subst' => 'trx_addons-thumb-tiny',
					),

					// Width of the image is equal to the content area width (with sidebar)
					// Height is proportional (only downscale, not crop)
					'rosalinda-thumb-masonry-big' => array(
						'size'  => array( 760, 0, false ),     // Only downscale, not crop
						'title' => esc_html__( 'Masonry Large (scaled)', 'rosalinda' ),
						'subst' => 'trx_addons-thumb-masonry-big',
					),

					// Width of the image is equal to the 1/3 of the full content area width (without sidebar)
					// Height is proportional (only downscale, not crop)
					'rosalinda-thumb-masonry'     => array(
						'size'  => array( 370, 0, false ),     // Only downscale, not crop
						'title' => esc_html__( 'Masonry (scaled)', 'rosalinda' ),
						'subst' => 'trx_addons-thumb-masonry',
					),
                    'rosalinda-thumb-recent'     => array(
						'size'  => array( 325, 150, true ),     // Only downscale, not crop
						'title' => esc_html__( 'Recent New', 'rosalinda' ),
						'subst' => 'trx_addons-thumb-recent',
					),
                    'rosalinda-thumb-except'     => array(
						'size'  => array( 655, 350, true ),
						'title' => esc_html__( 'except img', 'rosalinda' ),
						'subst' => 'trx_addons-thumb-except',
					),
                    'rosalinda-thumb-services'     => array(
						'size'  => array( 406, 306, true ),
						'title' => esc_html__( 'Services img', 'rosalinda' ),
						'subst' => 'trx_addons-thumb-services',
					),
                    'rosalinda-thumb-serv'     => array(
						'size'  => array( 636, 433, true ),
						'title' => esc_html__( 'Services img', 'rosalinda' ),
						'subst' => 'trx_addons-thumb-serv',
					),
                    'rosalinda-thumb-blog'     => array(
						'size'  => array( 406, 274, true ),
						'title' => esc_html__( 'blog img', 'rosalinda' ),
						'subst' => 'trx_addons-thumb-blog',
					),
                    'rosalinda-thumb-dishes'     => array(
						'size'  => array(187, 187, true ),
						'title' => esc_html__( 'Dishes img', 'rosalinda' ),
						'subst' => 'trx_addons-thumb-dishes',
					),
				)
			)
		);
	}
}




//------------------------------------------------------------------------
// One-click import support
//------------------------------------------------------------------------

// Set theme specific importer options
if ( ! function_exists( 'rosalinda_importer_set_options' ) ) {
	add_filter( 'trx_addons_filter_importer_options', 'rosalinda_importer_set_options', 9 );
	function rosalinda_importer_set_options( $options = array() ) {
		if ( is_array( $options ) ) {
			// Save or not installer's messages to the log-file
			$options['debug'] = false;
			// Allow import/export functionality
			$options['allow_import'] = true;
			$options['allow_export'] = false;
			// Prepare demo data
			$options['demo_url'] = esc_url( rosalinda_get_protocol() . '://demofiles.axiomthemes.com/rosalinda/' );
			// Required plugins
			$options['required_plugins'] = array_keys( rosalinda_storage_get( 'required_plugins' ) );
			// Set number of thumbnails (usually 3 - 5) to regenerate at once when its imported (if demo data was zipped without cropped images)
			// Set 0 to prevent regenerate thumbnails (if demo data archive is already contain cropped images)
			$options['regenerate_thumbnails'] = 0;
			// Default demo
			$options['files']['default']['title']       = esc_html__( 'Rosalinda Demo', 'rosalinda' );
			$options['files']['default']['domain_dev']  = '';       // Developers domain
			$options['files']['default']['domain_demo'] = esc_url( rosalinda_get_protocol() . '://rosalinda.axiomthemes.com' );       // Demo-site domain
			// If theme need more demo - just copy 'default' and change required parameter
			// Banners
			$options['banners'] = array(
				array(
					'image'        => rosalinda_get_file_url( 'theme-specific/theme-about/images/frontpage.png' ),
					'title'        => esc_html__( 'Front Page Builder', 'rosalinda' ),
					'content'      => wp_kses( __( "Create your front page right in the WordPress Customizer. There's no need in any page builder. Simply enable/disable sections, fill them out with content, and customize to your liking.", 'rosalinda' ), 'rosalinda_kses_content' ),
					'link_url'     => esc_url( '//www.youtube.com/watch?v=VT0AUbMl_KA' ),
					'link_caption' => esc_html__( 'Watch Video Introduction', 'rosalinda' ),
					'duration'     => 20,
				),
				array(
					'image'        => rosalinda_get_file_url( 'theme-specific/theme-about/images/layouts.png' ),
					'title'        => esc_html__( 'Layouts Builder', 'rosalinda' ),
					'content'      => wp_kses( __( 'Use Layouts Builder to create and customize header and footer styles for your website. With a flexible page builder interface and custom shortcodes, you can create as many header and footer layouts as you want with ease.', 'rosalinda' ), 'rosalinda_kses_content' ),
					'link_url'     => esc_url( '//www.youtube.com/watch?v=pYhdFVLd7y4' ),
					'link_caption' => esc_html__( 'Learn More', 'rosalinda' ),
					'duration'     => 20,
				),
				array(
					'image'        => rosalinda_get_file_url( 'theme-specific/theme-about/images/documentation.png' ),
					'title'        => esc_html__( 'Read Full Documentation', 'rosalinda' ),
					'content'      => wp_kses( __( 'Need more details? Please check our full online documentation for detailed information on how to use Rosalinda.', 'rosalinda' ), 'rosalinda_kses_content' ),
					'link_url'     => esc_url( rosalinda_storage_get( 'theme_doc_url' ) ),
					'link_caption' => esc_html__( 'Online Documentation', 'rosalinda' ),
					'duration'     => 15,
				),
				array(
					'image'        => rosalinda_get_file_url( 'theme-specific/theme-about/images/video-tutorials.png' ),
					'title'        => esc_html__( 'Video Tutorials', 'rosalinda' ),
					'content'      => wp_kses( __( 'No time for reading documentation? Check out our video tutorials and learn how to customize Rosalinda in detail.', 'rosalinda' ), 'rosalinda_kses_content' ),
					'link_url'     => esc_url( rosalinda_storage_get( 'theme_video_url' ) ),
					'link_caption' => esc_html__( 'Video Tutorials', 'rosalinda' ),
					'duration'     => 15,
				),
				array(
					'image'        => rosalinda_get_file_url( 'theme-specific/theme-about/images/studio.png' ),
					'title'        => esc_html__( 'Website Customization', 'rosalinda' ),
					'content'      => wp_kses( __( "Need a website fast? Order our custom service, and we'll build a website based on this theme for a very fair price. We can also implement additional functionality such as website translation, setting up WPML, and much more.", 'rosalinda' ), 'rosalinda_kses_content' ),
					'link_url'     => esc_url( '//themerex.net/offers/?utm_source=offers&utm_medium=click&utm_campaign=themedash' ),
					'link_caption' => esc_html__( 'Contact Us', 'rosalinda' ),
					'duration'     => 25,
				),
			);
		}
		return $options;
	}
}


//------------------------------------------------------------------------
// OCDI support
//------------------------------------------------------------------------

// Set theme specific OCDI options
if ( ! function_exists( 'rosalinda_ocdi_set_options' ) ) {
	add_filter( 'trx_addons_filter_ocdi_options', 'rosalinda_ocdi_set_options', 9 );
	function rosalinda_ocdi_set_options( $options = array() ) {
		if ( is_array( $options ) ) {
			// Prepare demo data
			$options['demo_url'] = esc_url( rosalinda_get_protocol() . '://demofiles.axiomthemes.com/rosalinda/' );
			// Required plugins
			$options['required_plugins'] = array_keys( rosalinda_storage_get( 'required_plugins' ) );
			// Demo-site domain
			$options['files']['ocdi']['title']       = esc_html__( 'Rosalinda OCDI Demo', 'rosalinda' );
			$options['files']['ocdi']['domain_demo'] = esc_url( rosalinda_get_protocol() . '://rosalinda.axiomthemes.com' );
		}
		return $options;
	}
}


// -----------------------------------------------------------------
// -- Theme options for customizer
// -----------------------------------------------------------------
if ( ! function_exists( 'rosalinda_create_theme_options' ) ) {

	function rosalinda_create_theme_options() {

		// Message about options override.
		// Attention! Not need esc_html() here, because this message put in wp_kses_data() below
		$msg_override = esc_html__( 'Attention! Some of these options can be overridden in the following sections (Blog, Plugins settings, etc.) or in the settings of individual pages. If you changed such parameter and nothing happened on the page, this option may be overridden in the corresponding section or in the Page Options of this page. These options are marked with an asterisk (*) in the title.', 'rosalinda' );

		// Color schemes number: if < 2 - hide fields with selectors
		$hide_schemes = count( rosalinda_storage_get( 'schemes' ) ) < 2;

		rosalinda_storage_set(
			'options', array(

				// 'Logo & Site Identity'
				'title_tagline'                 => array(
					'title'    => esc_html__( 'Logo & Site Identity', 'rosalinda' ),
					'desc'     => '',
					'priority' => 10,
					'type'     => 'section',
				),
				'logo_info'                     => array(
					'title'    => esc_html__( 'Logo Settings', 'rosalinda' ),
					'desc'     => '',
					'priority' => 20,
					'qsetup'   => esc_html__( 'General', 'rosalinda' ),
					'type'     => 'info',
				),
				'logo_text'                     => array(
					'title'    => esc_html__( 'Use Site Name as Logo', 'rosalinda' ),
					'desc'     => wp_kses_data( __( 'Use the site title and tagline as a text logo if no image is selected', 'rosalinda' ) ),
					'class'    => 'rosalinda_column-1_2 rosalinda_new_row',
					'priority' => 30,
					'std'      => 1,
					'qsetup'   => esc_html__( 'General', 'rosalinda' ),
					'type'     => ROSALINDA_THEME_FREE ? 'hidden' : 'checkbox',
				),
				'logo_retina_enabled'           => array(
					'title'    => esc_html__( 'Allow retina display logo', 'rosalinda' ),
					'desc'     => wp_kses_data( __( 'Show fields to select logo images for Retina display', 'rosalinda' ) ),
					'class'    => 'rosalinda_column-1_2',
					'priority' => 40,
					'refresh'  => false,
					'std'      => 0,
					'type'     => ROSALINDA_THEME_FREE ? 'hidden' : 'checkbox',
				),
				'logo_zoom'                     => array(
					'title'   => esc_html__( 'Logo zoom', 'rosalinda' ),
					'desc'    => wp_kses_data( __( 'Zoom the logo. 1 - original size. Maximum size of logo depends on the actual size of the picture', 'rosalinda' ) ),
					'std'     => 1,
					'min'     => 0.2,
					'max'     => 2,
					'step'    => 0.1,
					'refresh' => false,
					'type'    => ROSALINDA_THEME_FREE ? 'hidden' : 'slider',
				),
				// Parameter 'logo' was replaced with standard WordPress 'custom_logo'
				'logo_retina'                   => array(
					'title'      => esc_html__( 'Logo for Retina', 'rosalinda' ),
					'desc'       => wp_kses_data( __( 'Select or upload site logo used on Retina displays (if empty - use default logo from the field above)', 'rosalinda' ) ),
					'class'      => 'rosalinda_column-1_2',
					'priority'   => 70,
					'dependency' => array(
						'logo_retina_enabled' => array( 1 ),
					),
					'std'        => '',
					'type'       => ROSALINDA_THEME_FREE ? 'hidden' : 'image',
				),
				'logo_mobile_header'            => array(
					'title' => esc_html__( 'Logo for the mobile header', 'rosalinda' ),
					'desc'  => wp_kses_data( __( 'Select or upload site logo to display it in the mobile header (if enabled in the section "Header - Header mobile"', 'rosalinda' ) ),
					'class' => 'rosalinda_column-1_2 rosalinda_new_row',
					'std'   => '',
					'type'  => 'image',
				),
				'logo_mobile_header_retina'     => array(
					'title'      => esc_html__( 'Logo for the mobile header on Retina', 'rosalinda' ),
					'desc'       => wp_kses_data( __( 'Select or upload site logo used on Retina displays (if empty - use default logo from the field above)', 'rosalinda' ) ),
					'class'      => 'rosalinda_column-1_2',
					'dependency' => array(
						'logo_retina_enabled' => array( 1 ),
					),
					'std'        => '',
					'type'       => ROSALINDA_THEME_FREE ? 'hidden' : 'image',
				),
				'logo_mobile'                   => array(
					'title' => esc_html__( 'Logo for the mobile menu', 'rosalinda' ),
					'desc'  => wp_kses_data( __( 'Select or upload site logo to display it in the mobile menu', 'rosalinda' ) ),
					'class' => 'rosalinda_column-1_2 rosalinda_new_row',
					'std'   => '',
					'type'  => 'image',
				),
				'logo_mobile_retina'            => array(
					'title'      => esc_html__( 'Logo mobile on Retina', 'rosalinda' ),
					'desc'       => wp_kses_data( __( 'Select or upload site logo used on Retina displays (if empty - use default logo from the field above)', 'rosalinda' ) ),
					'class'      => 'rosalinda_column-1_2',
					'dependency' => array(
						'logo_retina_enabled' => array( 1 ),
					),
					'std'        => '',
					'type'       => ROSALINDA_THEME_FREE ? 'hidden' : 'image',
				),
				'logo_side'                     => array(
					'title' => esc_html__( 'Logo for the side menu', 'rosalinda' ),
					'desc'  => wp_kses_data( __( 'Select or upload site logo (with vertical orientation) to display it in the side menu', 'rosalinda' ) ),
					'class' => 'rosalinda_column-1_2 rosalinda_new_row',
					'std'   => '',
					'type'  => 'image',
				),
				'logo_side_retina'              => array(
					'title'      => esc_html__( 'Logo for the side menu on Retina', 'rosalinda' ),
					'desc'       => wp_kses_data( __( 'Select or upload site logo (with vertical orientation) to display it in the side menu on Retina displays (if empty - use default logo from the field above)', 'rosalinda' ) ),
					'class'      => 'rosalinda_column-1_2',
					'dependency' => array(
						'logo_retina_enabled' => array( 1 ),
					),
					'std'        => '',
					'type'       => ROSALINDA_THEME_FREE ? 'hidden' : 'image',
				),

				// 'General settings'
				'general'                       => array(
					'title'    => esc_html__( 'General Settings', 'rosalinda' ),
					'desc'     => wp_kses_data( $msg_override ),
					'priority' => 20,
					'type'     => 'section',
				),

				'general_layout_info'           => array(
					'title'  => esc_html__( 'Layout', 'rosalinda' ),
					'desc'   => '',
					'qsetup' => esc_html__( 'General', 'rosalinda' ),
					'type'   => 'info',
				),
				'body_style'                    => array(
					'title'    => esc_html__( 'Body style', 'rosalinda' ),
					'desc'     => wp_kses_data( __( 'Select width of the body content', 'rosalinda' ) ),
					'override' => array(
						'mode'    => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Content', 'rosalinda' ),
					),
					'qsetup'   => esc_html__( 'General', 'rosalinda' ),
					'refresh'  => false,
					'std'      => 'wide',
					'options'  => rosalinda_get_list_body_styles( false ),
					'type'     => 'select',
				),
				'page_width'                    => array(
					'title'      => esc_html__( 'Page width', 'rosalinda' ),
					'desc'       => wp_kses_data( __( 'Total width of the site content and sidebar (in pixels). If empty - use default width', 'rosalinda' ) ),
					'dependency' => array(
						'body_style' => array( 'boxed', 'wide' ),
					),
					'std'        => 1280,
					'min'        => 1000,
					'max'        => 1400,
					'step'       => 10,
					'refresh'    => false,
					'customizer' => 'page',         // SASS variable's name to preview changes 'on fly'
					'type'       => ROSALINDA_THEME_FREE ? 'hidden' : 'slider',
				),
				'boxed_bg_image'                => array(
					'title'      => esc_html__( 'Boxed bg image', 'rosalinda' ),
					'desc'       => wp_kses_data( __( 'Select or upload image, used as background in the boxed body', 'rosalinda' ) ),
					'dependency' => array(
						'body_style' => array( 'boxed' ),
					),
					'override'   => array(
						'mode'    => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Content', 'rosalinda' ),
					),
					'std'        => '',
					'qsetup'     => esc_html__( 'General', 'rosalinda' ),
					'type'       => 'image',
				),
				'remove_margins'                => array(
					'title'    => esc_html__( 'Remove margins', 'rosalinda' ),
					'desc'     => wp_kses_data( __( 'Remove margins above and below the content area', 'rosalinda' ) ),
					'override' => array(
						'mode'    => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Content', 'rosalinda' ),
					),
					'refresh'  => false,
					'std'      => 0,
					'type'     => 'checkbox',
				),

				'general_sidebar_info'          => array(
					'title' => esc_html__( 'Sidebar', 'rosalinda' ),
					'desc'  => '',
					'type'  => 'info',
				),
				'sidebar_position'              => array(
					'title'    => esc_html__( 'Sidebar position', 'rosalinda' ),
					'desc'     => wp_kses_data( __( 'Select position to show sidebar', 'rosalinda' ) ),
					'override' => array(
						'mode'    => 'page,post,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Widgets', 'rosalinda' ),
					),
					'std'      => 'right',
					'qsetup'   => esc_html__( 'General', 'rosalinda' ),
					'options'  => array(),
					'type'     => 'switch',
				),
				'sidebar_widgets'               => array(
					'title'      => esc_html__( 'Sidebar widgets', 'rosalinda' ),
					'desc'       => wp_kses_data( __( 'Select default widgets to show in the sidebar', 'rosalinda' ) ),
					'override'   => array(
						'mode'    => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Widgets', 'rosalinda' ),
					),
					'dependency' => array(
						'sidebar_position' => array( 'left', 'right' ),
					),
					'std'        => 'sidebar_widgets',
					'options'    => array(),
					'qsetup'     => esc_html__( 'General', 'rosalinda' ),
					'type'       => 'select',
				),
				'sidebar_width'                 => array(
					'title'      => esc_html__( 'Sidebar width', 'rosalinda' ),
					'desc'       => wp_kses_data( __( 'Width of the sidebar (in pixels). If empty - use default width', 'rosalinda' ) ),
					'std'        => 405,
					'min'        => 150,
					'max'        => 500,
					'step'       => 10,
					'refresh'    => false,
					'customizer' => 'sidebar',      // SASS variable's name to preview changes 'on fly'
					'type'       => ROSALINDA_THEME_FREE ? 'hidden' : 'slider',
				),
				'sidebar_gap'                   => array(
					'title'      => esc_html__( 'Sidebar gap', 'rosalinda' ),
					'desc'       => wp_kses_data( __( 'Gap between content and sidebar (in pixels). If empty - use default gap', 'rosalinda' ) ),
					'std'        => 140,
					'min'        => 0,
					'max'        => 150,
					'step'       => 1,
					'refresh'    => false,
					'customizer' => 'gap',          // SASS variable's name to preview changes 'on fly'
					'type'       => ROSALINDA_THEME_FREE ? 'hidden' : 'slider',
				),
				'expand_content'                => array(
					'title'   => esc_html__( 'Expand content', 'rosalinda' ),
					'desc'    => wp_kses_data( __( 'Expand the content width if the sidebar is hidden', 'rosalinda' ) ),
					'refresh' => false,
					'std'     => 1,
					'type'    => 'checkbox',
                ),

				'general_widgets_info'          => array(
					'title' => esc_html__( 'Additional widgets', 'rosalinda' ),
					'desc'  => '',
					'type'  => ROSALINDA_THEME_FREE ? 'hidden' : 'info',
				),
				'widgets_above_page'            => array(
					'title'    => esc_html__( 'Widgets at the top of the page', 'rosalinda' ),
					'desc'     => wp_kses_data( __( 'Select widgets to show at the top of the page (above content and sidebar)', 'rosalinda' ) ),
					'override' => array(
						'mode'    => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Widgets', 'rosalinda' ),
					),
					'std'      => 'hide',
					'options'  => array(),
					'type'     => ROSALINDA_THEME_FREE ? 'hidden' : 'select',
				),
				'widgets_above_content'         => array(
					'title'    => esc_html__( 'Widgets above the content', 'rosalinda' ),
					'desc'     => wp_kses_data( __( 'Select widgets to show at the beginning of the content area', 'rosalinda' ) ),
					'override' => array(
						'mode'    => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Widgets', 'rosalinda' ),
					),
					'std'      => 'hide',
					'options'  => array(),
					'type'     => ROSALINDA_THEME_FREE ? 'hidden' : 'select',
				),
				'widgets_below_content'         => array(
					'title'    => esc_html__( 'Widgets below the content', 'rosalinda' ),
					'desc'     => wp_kses_data( __( 'Select widgets to show at the ending of the content area', 'rosalinda' ) ),
					'override' => array(
						'mode'    => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Widgets', 'rosalinda' ),
					),
					'std'      => 'hide',
					'options'  => array(),
					'type'     => ROSALINDA_THEME_FREE ? 'hidden' : 'select',
				),
				'widgets_below_page'            => array(
					'title'    => esc_html__( 'Widgets at the bottom of the page', 'rosalinda' ),
					'desc'     => wp_kses_data( __( 'Select widgets to show at the bottom of the page (below content and sidebar)', 'rosalinda' ) ),
					'override' => array(
						'mode'    => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Widgets', 'rosalinda' ),
					),
					'std'      => 'hide',
					'options'  => array(),
					'type'     => ROSALINDA_THEME_FREE ? 'hidden' : 'select',
				),

				'general_effects_info'          => array(
					'title' => esc_html__( 'Design & Effects', 'rosalinda' ),
					'desc'  => '',
					'type'  => 'info',
				),
				'border_radius'                 => array(
					'title'      => esc_html__( 'Border radius', 'rosalinda' ),
					'desc'       => wp_kses_data( __( 'Specify the border radius of the form fields and buttons in pixels', 'rosalinda' ) ),
					'std'        => 0,
					'min'        => 0,
					'max'        => 20,
					'step'       => 1,
					'refresh'    => false,
					'customizer' => 'rad',      // SASS name to preview changes 'on fly'
					'type'       => ROSALINDA_THEME_FREE ? 'hidden' : 'slider',
				),

				'general_misc_info'             => array(
					'title' => esc_html__( 'Miscellaneous', 'rosalinda' ),
					'desc'  => '',
					'type'  => ROSALINDA_THEME_FREE ? 'hidden' : 'info',
				),
				'seo_snippets'                  => array(
					'title' => esc_html__( 'SEO snippets', 'rosalinda' ),
					'desc'  => wp_kses_data( __( 'Add structured data markup to the single posts and pages', 'rosalinda' ) ),
					'std'   => 0,
					'type'  => ROSALINDA_THEME_FREE ? 'hidden' : 'checkbox',
				),
				'privacy_text' => array(
					"title" => esc_html__("Text with Privacy Policy link", 'rosalinda'),
					"desc"  => wp_kses_data( __("Specify text with Privacy Policy link for the checkbox 'I agree ...'", 'rosalinda') ),
					"std"   => wp_kses( __( 'I agree that my submitted data is being collected and stored.', 'rosalinda'), 'rosalinda_kses_content' ),
					"type"  => "text"
				),

				// 'Header'
				'header'                        => array(
					'title'    => esc_html__( 'Header', 'rosalinda' ),
					'desc'     => wp_kses_data( $msg_override ),
					'priority' => 30,
					'type'     => 'section',
				),

				'header_style_info'             => array(
					'title' => esc_html__( 'Header style', 'rosalinda' ),
					'desc'  => '',
					'type'  => 'info',
				),
				'header_type'                   => array(
					'title'    => esc_html__( 'Header style', 'rosalinda' ),
					'desc'     => wp_kses_data( __( 'Choose whether to use the default header or header Layouts (available only if the ThemeREX Addons is activated)', 'rosalinda' ) ),
					'override' => array(
						'mode'    => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Header', 'rosalinda' ),
					),
					'std'      => 'default',
					'options'  => rosalinda_get_list_header_footer_types(),
					'type'     => ROSALINDA_THEME_FREE || ! rosalinda_exists_trx_addons() ? 'hidden' : 'switch',
				),
				'header_style'                  => array(
					'title'      => esc_html__( 'Select custom layout', 'rosalinda' ),
					'desc'       => wp_kses( __( 'Select custom header from Layouts Builder', 'rosalinda' ), 'rosalinda_kses_content' ),
					'override'   => array(
						'mode'    => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Header', 'rosalinda' ),
					),
					'dependency' => array(
						'header_type' => array( 'custom' ),
					),
					'std'        => ROSALINDA_THEME_FREE ? 'header-custom-elementor-header-default' : 'header-custom-header-default',
					'options'    => array(),
					'type'       => 'select',
				),
				'header_position'               => array(
					'title'    => esc_html__( 'Header position', 'rosalinda' ),
					'desc'     => wp_kses_data( __( 'Select position to display the site header', 'rosalinda' ) ),
					'override' => array(
						'mode'    => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Header', 'rosalinda' ),
					),
					'std'      => 'default',
					'options'  => array(),
					'type'     => ROSALINDA_THEME_FREE ? 'hidden' : 'switch',
				),
				'header_fullheight'             => array(
					'title'    => esc_html__( 'Header fullheight', 'rosalinda' ),
					'desc'     => wp_kses_data( __( 'Enlarge header area to fill whole screen. Used only if header have a background image', 'rosalinda' ) ),
					'override' => array(
						'mode'    => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Header', 'rosalinda' ),
					),
					'std'      => 0,
					'type'     => ROSALINDA_THEME_FREE ? 'hidden' : 'checkbox',
				),
				'header_zoom'                   => array(
					'title'   => esc_html__( 'Header zoom', 'rosalinda' ),
					'desc'    => wp_kses_data( __( 'Zoom the header title. 1 - original size', 'rosalinda' ) ),
					'std'     => 1,
					'min'     => 0.3,
					'max'     => 2,
					'step'    => 0.1,
					'refresh' => false,
					'type'    => ROSALINDA_THEME_FREE ? 'hidden' : 'slider',
				),
				'header_wide'                   => array(
					'title'      => esc_html__( 'Header fullwidth', 'rosalinda' ),
					'desc'       => wp_kses_data( __( 'Do you want to stretch the header widgets area to the entire window width?', 'rosalinda' ) ),
					'override'   => array(
						'mode'    => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Header', 'rosalinda' ),
					),
					'dependency' => array(
						'header_type' => array( 'default' ),
					),
					'std'        => 1,
					'type'       => ROSALINDA_THEME_FREE ? 'hidden' : 'checkbox',
				),

				'header_widgets_info'           => array(
					'title' => esc_html__( 'Header widgets', 'rosalinda' ),
					'desc'  => wp_kses_data( __( 'Here you can place a widget slider, advertising banners, etc.', 'rosalinda' ) ),
					'type'  => 'info',
				),
				'header_widgets'                => array(
					'title'    => esc_html__( 'Header widgets', 'rosalinda' ),
					'desc'     => wp_kses_data( __( 'Select set of widgets to show in the header on each page', 'rosalinda' ) ),
					'override' => array(
						'mode'    => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Header', 'rosalinda' ),
						'desc'    => wp_kses_data( __( 'Select set of widgets to show in the header on this page', 'rosalinda' ) ),
					),
					'std'      => 'hide',
					'options'  => array(),
					'type'     => 'select',
				),
				'header_columns'                => array(
					'title'      => esc_html__( 'Header columns', 'rosalinda' ),
					'desc'       => wp_kses_data( __( 'Select number columns to show widgets in the Header. If 0 - autodetect by the widgets count', 'rosalinda' ) ),
					'override'   => array(
						'mode'    => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Header', 'rosalinda' ),
					),
					'dependency' => array(
						'header_type'    => array( 'default' ),
						'header_widgets' => array( '^hide' ),
					),
					'std'        => 0,
					'options'    => rosalinda_get_list_range( 0, 6 ),
					'type'       => 'select',
				),

				'menu_info'                     => array(
					'title' => esc_html__( 'Main menu', 'rosalinda' ),
					'desc'  => wp_kses_data( __( 'Select main menu style, position and other parameters', 'rosalinda' ) ),
					'type'  => ROSALINDA_THEME_FREE ? 'hidden' : 'info',
				),
				'menu_style'                    => array(
					'title'    => esc_html__( 'Menu position', 'rosalinda' ),
					'desc'     => wp_kses_data( __( 'Select position of the main menu', 'rosalinda' ) ),
					'override' => array(
						'mode'    => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Header', 'rosalinda' ),
					),
					'std'      => 'top',
					'options'  => array(
						'top'   => esc_html__( 'Top', 'rosalinda' ),
						'left'  => esc_html__( 'Left', 'rosalinda' ),
						'right' => esc_html__( 'Right', 'rosalinda' ),
					),
					'type'     => ROSALINDA_THEME_FREE || ! rosalinda_exists_trx_addons() ? 'hidden' : 'switch',
				),
				'menu_side_stretch'             => array(
					'title'      => esc_html__( 'Stretch sidemenu', 'rosalinda' ),
					'desc'       => wp_kses_data( __( 'Stretch sidemenu to window height (if menu items number >= 5)', 'rosalinda' ) ),
					'override'   => array(
						'mode'    => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Header', 'rosalinda' ),
					),
					'dependency' => array(
						'menu_style' => array( 'left', 'right' ),
					),
					'std'        => 0,
					'type'       => ROSALINDA_THEME_FREE ? 'hidden' : 'checkbox',
				),
				'menu_side_icons'               => array(
					'title'      => esc_html__( 'Iconed sidemenu', 'rosalinda' ),
					'desc'       => wp_kses_data( __( 'Get icons from anchors and display it in the sidemenu or mark sidemenu items with simple dots', 'rosalinda' ) ),
					'override'   => array(
						'mode'    => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Header', 'rosalinda' ),
					),
					'dependency' => array(
						'menu_style' => array( 'left', 'right' ),
					),
					'std'        => 1,
					'type'       => ROSALINDA_THEME_FREE ? 'hidden' : 'checkbox',
				),
				'menu_mobile_fullscreen'        => array(
					'title' => esc_html__( 'Mobile menu fullscreen', 'rosalinda' ),
					'desc'  => wp_kses_data( __( 'Display mobile and side menus on full screen (if checked) or slide narrow menu from the left or from the right side (if not checked)', 'rosalinda' ) ),
					'std'   => 1,
					'type'  => ROSALINDA_THEME_FREE ? 'hidden' : 'checkbox',
				),

				'header_image_info'             => array(
					'title' => esc_html__( 'Header image', 'rosalinda' ),
					'desc'  => '',
					'type'  => ROSALINDA_THEME_FREE ? 'hidden' : 'info',
				),
				'header_image_override'         => array(
					'title'    => esc_html__( 'Header image override', 'rosalinda' ),
					'desc'     => wp_kses_data( __( "Allow override the header image with the page's/post's/product's/etc. featured image", 'rosalinda' ) ),
					'override' => array(
						'mode'    => 'page',
						'section' => esc_html__( 'Header', 'rosalinda' ),
					),
					'std'      => 0,
					'type'     => ROSALINDA_THEME_FREE ? 'hidden' : 'checkbox',
				),

				'header_mobile_info'            => array(
					'title'      => esc_html__( 'Mobile header', 'rosalinda' ),
					'desc'       => wp_kses_data( __( 'Configure the mobile version of the header', 'rosalinda' ) ),
					'priority'   => 500,
					'dependency' => array(
						'header_type' => array( 'default' ),
					),
					'type'       => ROSALINDA_THEME_FREE ? 'hidden' : 'info',
				),
				'header_mobile_enabled'         => array(
					'title'      => esc_html__( 'Enable the mobile header', 'rosalinda' ),
					'desc'       => wp_kses_data( __( 'Use the mobile version of the header (if checked) or relayout the current header on mobile devices', 'rosalinda' ) ),
					'dependency' => array(
						'header_type' => array( 'default' ),
					),
					'std'        => 0,
					'type'       => ROSALINDA_THEME_FREE ? 'hidden' : 'checkbox',
				),
				'header_mobile_additional_info' => array(
					'title'      => esc_html__( 'Additional info', 'rosalinda' ),
					'desc'       => wp_kses_data( __( 'Additional info to show at the top of the mobile header', 'rosalinda' ) ),
					'std'        => '',
					'dependency' => array(
						'header_type'           => array( 'default' ),
						'header_mobile_enabled' => array( 1 ),
					),
					'refresh'    => false,
					'teeny'      => false,
					'rows'       => 20,
					'type'       => ROSALINDA_THEME_FREE ? 'hidden' : 'text_editor',
				),
				'header_mobile_hide_info'       => array(
					'title'      => esc_html__( 'Hide additional info', 'rosalinda' ),
					'std'        => 0,
					'dependency' => array(
						'header_type'           => array( 'default' ),
						'header_mobile_enabled' => array( 1 ),
					),
					'type'       => ROSALINDA_THEME_FREE ? 'hidden' : 'checkbox',
				),
				'header_mobile_hide_logo'       => array(
					'title'      => esc_html__( 'Hide logo', 'rosalinda' ),
					'std'        => 0,
					'dependency' => array(
						'header_type'           => array( 'default' ),
						'header_mobile_enabled' => array( 1 ),
					),
					'type'       => ROSALINDA_THEME_FREE ? 'hidden' : 'checkbox',
				),
				'header_mobile_hide_login'      => array(
					'title'      => esc_html__( 'Hide login/logout', 'rosalinda' ),
					'std'        => 0,
					'dependency' => array(
						'header_type'           => array( 'default' ),
						'header_mobile_enabled' => array( 1 ),
					),
					'type'       => ROSALINDA_THEME_FREE ? 'hidden' : 'checkbox',
				),
				'header_mobile_hide_search'     => array(
					'title'      => esc_html__( 'Hide search', 'rosalinda' ),
					'std'        => 0,
					'dependency' => array(
						'header_type'           => array( 'default' ),
						'header_mobile_enabled' => array( 1 ),
					),
					'type'       => ROSALINDA_THEME_FREE ? 'hidden' : 'checkbox',
				),
				'header_mobile_hide_cart'       => array(
					'title'      => esc_html__( 'Hide cart', 'rosalinda' ),
					'std'        => 0,
					'dependency' => array(
						'header_type'           => array( 'default' ),
						'header_mobile_enabled' => array( 1 ),
					),
					'type'       => ROSALINDA_THEME_FREE ? 'hidden' : 'checkbox',
				),

				// 'Footer'
				'footer'                        => array(
					'title'    => esc_html__( 'Footer', 'rosalinda' ),
					'desc'     => wp_kses_data( $msg_override ),
					'priority' => 50,
					'type'     => 'section',
				),
				'footer_type'                   => array(
					'title'    => esc_html__( 'Footer style', 'rosalinda' ),
					'desc'     => wp_kses_data( __( 'Choose whether to use the default footer or footer Layouts (available only if the ThemeREX Addons is activated)', 'rosalinda' ) ),
					'override' => array(
						'mode'    => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Footer', 'rosalinda' ),
					),
					'std'      => 'default',
					'options'  => rosalinda_get_list_header_footer_types(),
					'type'     => ROSALINDA_THEME_FREE || ! rosalinda_exists_trx_addons() ? 'hidden' : 'switch',
				),
				'footer_style'                  => array(
					'title'      => esc_html__( 'Select custom layout', 'rosalinda' ),
					'desc'       => wp_kses( __( 'Select custom footer from Layouts Builder', 'rosalinda' ), 'rosalinda_kses_content' ),
					'override'   => array(
						'mode'    => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Footer', 'rosalinda' ),
					),
					'dependency' => array(
						'footer_type' => array( 'custom' ),
					),
					'std'        => ROSALINDA_THEME_FREE ? 'footer-custom-elementor-footer-default' : 'footer-custom-footer-default',
					'options'    => array(),
					'type'       => 'select',
				),
				'footer_widgets'                => array(
					'title'      => esc_html__( 'Footer widgets', 'rosalinda' ),
					'desc'       => wp_kses_data( __( 'Select set of widgets to show in the footer', 'rosalinda' ) ),
					'override'   => array(
						'mode'    => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Footer', 'rosalinda' ),
					),
					'dependency' => array(
						'footer_type' => array( 'default' ),
					),
					'std'        => 'footer_widgets',
					'options'    => array(),
					'type'       => 'select',
				),
				'footer_columns'                => array(
					'title'      => esc_html__( 'Footer columns', 'rosalinda' ),
					'desc'       => wp_kses_data( __( 'Select number columns to show widgets in the footer. If 0 - autodetect by the widgets count', 'rosalinda' ) ),
					'override'   => array(
						'mode'    => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Footer', 'rosalinda' ),
					),
					'dependency' => array(
						'footer_type'    => array( 'default' ),
						'footer_widgets' => array( '^hide' ),
					),
					'std'        => 0,
					'options'    => rosalinda_get_list_range( 0, 6 ),
					'type'       => 'select',
				),
				'footer_wide'                   => array(
					'title'      => esc_html__( 'Footer fullwidth', 'rosalinda' ),
					'desc'       => wp_kses_data( __( 'Do you want to stretch the footer to the entire window width?', 'rosalinda' ) ),
					'override'   => array(
						'mode'    => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Footer', 'rosalinda' ),
					),
					'dependency' => array(
						'footer_type' => array( 'default' ),
					),
					'std'        => 0,
					'type'       => 'checkbox',
				),
				'logo_in_footer'                => array(
					'title'      => esc_html__( 'Show logo', 'rosalinda' ),
					'desc'       => wp_kses_data( __( 'Show logo in the footer', 'rosalinda' ) ),
					'refresh'    => false,
					'dependency' => array(
						'footer_type' => array( 'default' ),
					),
					'std'        => 0,
					'type'       => 'checkbox',
				),
				'logo_footer'                   => array(
					'title'      => esc_html__( 'Logo for footer', 'rosalinda' ),
					'desc'       => wp_kses_data( __( 'Select or upload site logo to display it in the footer', 'rosalinda' ) ),
					'dependency' => array(
						'footer_type'    => array( 'default' ),
						'logo_in_footer' => array( 1 ),
					),
					'std'        => '',
					'type'       => 'image',
				),
				'logo_footer_retina'            => array(
					'title'      => esc_html__( 'Logo for footer (Retina)', 'rosalinda' ),
					'desc'       => wp_kses_data( __( 'Select or upload logo for the footer area used on Retina displays (if empty - use default logo from the field above)', 'rosalinda' ) ),
					'dependency' => array(
						'footer_type'         => array( 'default' ),
						'logo_in_footer'      => array( 1 ),
						'logo_retina_enabled' => array( 1 ),
					),
					'std'        => '',
					'type'       => ROSALINDA_THEME_FREE ? 'hidden' : 'image',
				),
				'socials_in_footer'             => array(
					'title'      => esc_html__( 'Show social icons', 'rosalinda' ),
					'desc'       => wp_kses_data( __( 'Show social icons in the footer (under logo or footer widgets)', 'rosalinda' ) ),
					'dependency' => array(
						'footer_type' => array( 'default' ),
					),
					'std'        => 0,
					'type'       => ! rosalinda_exists_trx_addons() ? 'hidden' : 'checkbox',
				),
				'copyright'                     => array(
					'title'      => esc_html__( 'Copyright', 'rosalinda' ),
					'desc'       => wp_kses_data( __( 'Copyright text in the footer. Use {Y} to insert current year and press "Enter" to create a new line', 'rosalinda' ) ),
					'translate'  => true,
					'std'        => esc_html__( 'Copyright &copy; {Y} by AxiomThemes. All rights reserved.', 'rosalinda' ),
					'dependency' => array(
						'footer_type' => array( 'default' ),
					),
					'refresh'    => false,
					'type'       => 'textarea',
				),

				// 'Blog'
				'blog'                          => array(
					'title'    => esc_html__( 'Blog', 'rosalinda' ),
					'desc'     => wp_kses_data( __( 'Options of the the blog archive', 'rosalinda' ) ),
					'priority' => 70,
					'type'     => 'panel',
				),

				// Blog - Posts page
				'blog_general'                  => array(
					'title' => esc_html__( 'Posts page', 'rosalinda' ),
					'desc'  => wp_kses_data( __( 'Style and components of the blog archive', 'rosalinda' ) ),
					'type'  => 'section',
				),
				'blog_general_info'             => array(
					'title'  => esc_html__( 'Posts page settings', 'rosalinda' ),
					'desc'   => '',
					'qsetup' => esc_html__( 'General', 'rosalinda' ),
					'type'   => 'info',
				),
				'blog_style'                    => array(
					'title'      => esc_html__( 'Blog style', 'rosalinda' ),
					'desc'       => '',
					'override'   => array(
						'mode'    => 'page',
						'section' => esc_html__( 'Content', 'rosalinda' ),
					),
					'dependency' => array(
						'compare' => 'or',
						'#page_template' => array( 'blog.php' ),
						'.components-select-control:not(.post-author-selector) select' => array( 'blog.php' ),
					),
					'std'        => 'excerpt',
					'qsetup'     => esc_html__( 'General', 'rosalinda' ),
					'options'    => array(),
					'type'       => 'select',
				),
				'first_post_large'              => array(
					'title'      => esc_html__( 'First post large', 'rosalinda' ),
					'desc'       => wp_kses_data( __( 'Make your first post stand out by making it bigger', 'rosalinda' ) ),
					'override'   => array(
						'mode'    => 'page',
						'section' => esc_html__( 'Content', 'rosalinda' ),
					),
					'dependency' => array(
						'compare' => 'or',
						'#page_template' => array( 'blog.php' ),
						'.components-select-control:not(.post-author-selector) select' => array( 'blog.php' ),
						'blog_style' => array( 'classic', 'masonry' ),
					),
					'std'        => 0,
					'type'       => 'checkbox',
				),
				'blog_content'                  => array(
					'title'      => esc_html__( 'Posts content', 'rosalinda' ),
					'desc'       => wp_kses_data( __( 'Display either post excerpts or the full post content', 'rosalinda' ) ),
					'std'        => 'excerpt',
					'dependency' => array(
						'blog_style' => array( 'excerpt' ),
					),
					'options'    => array(
						'excerpt'  => esc_html__( 'Excerpt', 'rosalinda' ),
						'fullpost' => esc_html__( 'Full post', 'rosalinda' ),
					),
					'type'       => 'switch',
				),
				'excerpt_length'                => array(
					'title'      => esc_html__( 'Excerpt length', 'rosalinda' ),
					'desc'       => wp_kses_data( __( 'Length (in words) to generate excerpt from the post content. Attention! If the post excerpt is explicitly specified - it appears unchanged', 'rosalinda' ) ),
					'dependency' => array(
						'blog_style'   => array( 'excerpt' ),
						'blog_content' => array( 'excerpt' ),
					),
					'std'        => 30,
					'type'       => 'text',
				),
				'blog_columns'                  => array(
					'title'   => esc_html__( 'Blog columns', 'rosalinda' ),
					'desc'    => wp_kses_data( __( 'How many columns should be used in the blog archive (from 2 to 4)?', 'rosalinda' ) ),
					'std'     => 2,
					'options' => rosalinda_get_list_range( 2, 4 ),
					'type'    => 'hidden',      // This options is available and must be overriden only for some modes (for example, 'shop')
				),
				'post_type'                     => array(
					'title'      => esc_html__( 'Post type', 'rosalinda' ),
					'desc'       => wp_kses_data( __( 'Select post type to show in the blog archive', 'rosalinda' ) ),
					'override'   => array(
						'mode'    => 'page',
						'section' => esc_html__( 'Content', 'rosalinda' ),
					),
					'dependency' => array(
						'compare' => 'or',
						'#page_template' => array( 'blog.php' ),
						'.components-select-control:not(.post-author-selector) select' => array( 'blog.php' ),
					),
					'linked'     => 'parent_cat',
					'refresh'    => false,
					'hidden'     => true,
					'std'        => 'post',
					'options'    => array(),
					'type'       => 'select',
				),
				'parent_cat'                    => array(
					'title'      => esc_html__( 'Category to show', 'rosalinda' ),
					'desc'       => wp_kses_data( __( 'Select category to show in the blog archive', 'rosalinda' ) ),
					'override'   => array(
						'mode'    => 'page',
						'section' => esc_html__( 'Content', 'rosalinda' ),
					),
					'dependency' => array(
						'compare' => 'or',
						'#page_template' => array( 'blog.php' ),
						'.components-select-control:not(.post-author-selector) select' => array( 'blog.php' ),
					),
					'refresh'    => false,
					'hidden'     => true,
					'std'        => '0',
					'options'    => array(),
					'type'       => 'select',
				),
				'posts_per_page'                => array(
					'title'      => esc_html__( 'Posts per page', 'rosalinda' ),
					'desc'       => wp_kses_data( __( 'How many posts will be displayed on this page', 'rosalinda' ) ),
					'override'   => array(
						'mode'    => 'page',
						'section' => esc_html__( 'Content', 'rosalinda' ),
					),
					'dependency' => array(
						'compare' => 'or',
						'#page_template' => array( 'blog.php' ),
						'.components-select-control:not(.post-author-selector) select' => array( 'blog.php' ),
					),
					'hidden'     => true,
					'std'        => '',
					'type'       => 'text',
				),
				'blog_pagination'               => array(
					'title'      => esc_html__( 'Pagination style', 'rosalinda' ),
					'desc'       => wp_kses_data( __( 'Show Older/Newest posts or Page numbers below the posts list', 'rosalinda' ) ),
					'override'   => array(
						'mode'    => 'page',
						'section' => esc_html__( 'Content', 'rosalinda' ),
					),
					'std'        => 'pages',
					'qsetup'     => esc_html__( 'General', 'rosalinda' ),
					'dependency' => array(
						'compare' => 'or',
						'#page_template' => array( 'blog.php' ),
						'.components-select-control:not(.post-author-selector) select' => array( 'blog.php' ),
					),
					'options'    => array(
						'pages'    => esc_html__( 'Page numbers', 'rosalinda' ),
						'links'    => esc_html__( 'Older/Newest', 'rosalinda' ),
						'more'     => esc_html__( 'Load more', 'rosalinda' ),
						'infinite' => esc_html__( 'Infinite scroll', 'rosalinda' ),
					),
					'type'       => 'select',
				),
				'blog_animation'                => array(
					'title'      => esc_html__( 'Animation for the posts', 'rosalinda' ),
					'desc'       => wp_kses_data( __( 'Select animation to show posts in the blog. Attention! Do not use any animation on pages with the "wheel to the anchor" behaviour (like a "Chess 2 columns")!', 'rosalinda' ) ),
					'override'   => array(
						'mode'    => 'page',
						'section' => esc_html__( 'Content', 'rosalinda' ),
					),
					'dependency' => array(
						'compare' => 'or',
						'#page_template' => array( 'blog.php' ),
						'.components-select-control:not(.post-author-selector) select' => array( 'blog.php' ),
					),
					'std'        => 'none',
					'options'    => array(),
					'type'       => ROSALINDA_THEME_FREE ? 'hidden' : 'select',
				),
				'show_filters'                  => array(
					'title'      => esc_html__( 'Show filters', 'rosalinda' ),
					'desc'       => wp_kses_data( __( 'Show categories as tabs to filter posts', 'rosalinda' ) ),
					'override'   => array(
						'mode'    => 'page',
						'section' => esc_html__( 'Content', 'rosalinda' ),
					),
					'dependency' => array(
						'compare' => 'or',
						'#page_template' => array( 'blog.php' ),
						'.components-select-control:not(.post-author-selector) select' => array( 'blog.php' ),
						'blog_style'     => array( 'portfolio', 'gallery' ),
					),
					'hidden'     => true,
					'std'        => 0,
					'type'       => ROSALINDA_THEME_FREE ? 'hidden' : 'checkbox',
				),

				'blog_sidebar_info'             => array(
					'title' => esc_html__( 'Sidebar', 'rosalinda' ),
					'desc'  => '',
					'type'  => 'info',
				),
				'sidebar_position_blog'         => array(
					'title'   => esc_html__( 'Sidebar position', 'rosalinda' ),
					'desc'    => wp_kses_data( __( 'Select position to show sidebar', 'rosalinda' ) ),
					'std'     => 'right',
					'options' => array(),
					'qsetup'     => esc_html__( 'General', 'rosalinda' ),
					'type'    => 'switch',
				),
				'sidebar_widgets_blog'          => array(
					'title'      => esc_html__( 'Sidebar widgets', 'rosalinda' ),
					'desc'       => wp_kses_data( __( 'Select default widgets to show in the sidebar', 'rosalinda' ) ),
					'dependency' => array(
						'sidebar_position_blog' => array( 'left', 'right' ),
					),
					'std'        => 'sidebar_widgets',
					'options'    => array(),
					'qsetup'     => esc_html__( 'General', 'rosalinda' ),
					'type'       => 'select',
				),
				'expand_content_blog'           => array(
					'title'   => esc_html__( 'Expand content blog', 'rosalinda' ),
					'desc'    => wp_kses_data( __( 'Expand the content width if the sidebar is hidden', 'rosalinda' ) ),
					'refresh' => false,
					'std'     => 1,
					'type'    => 'checkbox',
				),

				'blog_widgets_info'             => array(
					'title' => esc_html__( 'Additional widgets', 'rosalinda' ),
					'desc'  => '',
					'type'  => ROSALINDA_THEME_FREE ? 'hidden' : 'info',
				),
				'widgets_above_page_blog'       => array(
					'title'   => esc_html__( 'Widgets at the top of the page', 'rosalinda' ),
					'desc'    => wp_kses_data( __( 'Select widgets to show at the top of the page (above content and sidebar)', 'rosalinda' ) ),
					'std'     => 'hide',
					'options' => array(),
					'type'    => ROSALINDA_THEME_FREE ? 'hidden' : 'select',
				),
				'widgets_above_content_blog'    => array(
					'title'   => esc_html__( 'Widgets above the content', 'rosalinda' ),
					'desc'    => wp_kses_data( __( 'Select widgets to show at the beginning of the content area', 'rosalinda' ) ),
					'std'     => 'hide',
					'options' => array(),
					'type'    => ROSALINDA_THEME_FREE ? 'hidden' : 'select',
				),
				'widgets_below_content_blog'    => array(
					'title'   => esc_html__( 'Widgets below the content', 'rosalinda' ),
					'desc'    => wp_kses_data( __( 'Select widgets to show at the ending of the content area', 'rosalinda' ) ),
					'std'     => 'hide',
					'options' => array(),
					'type'    => ROSALINDA_THEME_FREE ? 'hidden' : 'select',
				),
				'widgets_below_page_blog'       => array(
					'title'   => esc_html__( 'Widgets at the bottom of the page', 'rosalinda' ),
					'desc'    => wp_kses_data( __( 'Select widgets to show at the bottom of the page (below content and sidebar)', 'rosalinda' ) ),
					'std'     => 'hide',
					'options' => array(),
					'type'    => ROSALINDA_THEME_FREE ? 'hidden' : 'select',
				),

				'blog_advanced_info'            => array(
					'title' => esc_html__( 'Advanced settings', 'rosalinda' ),
					'desc'  => '',
					'type'  => 'info',
				),
				'no_image'                      => array(
					'title' => esc_html__( 'Image placeholder', 'rosalinda' ),
					'desc'  => wp_kses_data( __( 'Select or upload an image used as placeholder for posts without a featured image', 'rosalinda' ) ),
					'std'   => '',
					'type'  => 'image',
				),
				'time_diff_before'              => array(
					'title' => esc_html__( 'Easy Readable Date Format', 'rosalinda' ),
					'desc'  => wp_kses_data( __( "For how many days to show the easy-readable date format (e.g. '3 days ago') instead of the standard publication date", 'rosalinda' ) ),
					'std'   => '',
					'type'  => 'text',
				),
				'sticky_style'                  => array(
					'title'   => esc_html__( 'Sticky posts style', 'rosalinda' ),
					'desc'    => wp_kses_data( __( 'Select style of the sticky posts output', 'rosalinda' ) ),
					'std'     => 'inherit',
					'options' => array(
						'inherit' => esc_html__( 'Decorated posts', 'rosalinda' ),
						'columns' => esc_html__( 'Mini-cards', 'rosalinda' ),
					),
					'type'    => ROSALINDA_THEME_FREE ? 'hidden' : 'select',
				),
				'meta_parts'                    => array(
					'title'      => esc_html__( 'Post meta', 'rosalinda' ),
					'desc'       => wp_kses_data( __( "If your blog page is created using the 'Blog archive' page template, set up the 'Post Meta' settings in the 'Theme Options' section of that page. Post counters and Share Links are available only if plugin ThemeREX Addons is active", 'rosalinda' ) )
								. '<br>'
								. wp_kses_data( __( '<b>Tip:</b> Drag items to change their order.', 'rosalinda' ) ),
					'override'   => array(
						'mode'    => 'page',
						'section' => esc_html__( 'Content', 'rosalinda' ),
					),
					'dependency' => array(
						'compare' => 'or',
						'#page_template' => array( 'blog.php' ),
						'.components-select-control:not(.post-author-selector) select' => array( 'blog.php' ),
					),
					'dir'        => 'vertical',
					'sortable'   => true,
					'std'        => 'categories=0|date=0|counters=1|author=0|share=0|edit=0',
					'options'    => rosalinda_get_list_meta_parts(),
					'type'       => ROSALINDA_THEME_FREE ? 'hidden' : 'checklist',
				),
				'counters'                      => array(
					'title'      => esc_html__( 'Post counters', 'rosalinda' ),
					'desc'       => wp_kses_data( __( 'Show only selected counters. Attention! Likes and Views are available only if ThemeREX Addons is active', 'rosalinda' ) ),
					'override'   => array(
						'mode'    => 'page',
						'section' => esc_html__( 'Content', 'rosalinda' ),
					),
					'dependency' => array(
						'compare' => 'or',
						'#page_template' => array( 'blog.php' ),
						'.components-select-control:not(.post-author-selector) select' => array( 'blog.php' ),
					),
					'dir'        => 'vertical',
					'sortable'   => true,
					'std'        => 'views=0|likes=1|comments=1',
					'options'    => rosalinda_get_list_counters(),
					'type'       => ROSALINDA_THEME_FREE || ! rosalinda_exists_trx_addons() ? 'hidden' : 'checklist',
				),

				// Blog - Single posts
				'blog_single'                   => array(
					'title' => esc_html__( 'Single posts', 'rosalinda' ),
					'desc'  => wp_kses_data( __( 'Settings of the single post', 'rosalinda' ) ),
					'type'  => 'section',
				),
				'hide_featured_on_single'       => array(
					'title'    => esc_html__( 'Hide featured image on the single post', 'rosalinda' ),
					'desc'     => wp_kses_data( __( "Hide featured image on the single post's pages", 'rosalinda' ) ),
					'override' => array(
						'mode'    => 'page,post',
						'section' => esc_html__( 'Content', 'rosalinda' ),
					),
					'std'      => 0,
					'type'     => 'checkbox',
				),
				'post_thumbnail_type'      => array(
					'title'      => esc_html__( 'Type of post thumbnail', 'rosalinda' ),
					'desc'       => wp_kses_data( __( "Select type of post thumbnail on the single post's pages", 'rosalinda' ) ),
					'override'   => array(
						'mode'    => 'post',
						'section' => esc_html__( 'Content', 'rosalinda' ),
					),
					'dependency' => array(
						'hide_featured_on_single' => array( 0 ),
					),
					'std'        => 'default',
					'options'    => array(
						'fullwidth'   => esc_html__( 'Fullwidth', 'rosalinda' ),
						'boxed'       => esc_html__( 'Boxed', 'rosalinda' ),
						'default'     => esc_html__( 'Default', 'rosalinda' ),
					),
					'type'       => ROSALINDA_THEME_FREE ? 'hidden' : 'select',
				),
				'post_header_position'          => array(
					'title'      => esc_html__( 'Post header position', 'rosalinda' ),
					'desc'       => wp_kses_data( __( "Select post header position on the single post's pages", 'rosalinda' ) ),
					'override'   => array(
						'mode'    => 'post',
						'section' => esc_html__( 'Content', 'rosalinda' ),
					),
					'dependency' => array(
						'hide_featured_on_single' => array( 0 ),
					),
					'std'        => 'default',
					'options'    => array(
						'above'      => esc_html__( 'Above the post thumbnail', 'rosalinda' ),
						'on_thumb'   => esc_html__( 'On the post thumbnail', 'rosalinda' ),
						'default'    => esc_html__( 'Default', 'rosalinda' ),
					),
					'type'       => ROSALINDA_THEME_FREE ? 'hidden' : 'select',
				),
				'post_header_align'             => array(
					'title'      => esc_html__( 'Align of the post header', 'rosalinda' ),
					'override'   => array(
						'mode'    => 'post',
						'section' => esc_html__( 'Content', 'rosalinda' ),
					),
					'dependency' => array(
						'post_header_position' => array( 'on_thumb' ),
					),
					'std'        => 'mc',
					'options'    => array(
						'ts' => esc_html__('Top Stick Out', 'rosalinda'),
						'tl' => esc_html__('Top Left', 'rosalinda'),
						'tc' => esc_html__('Top Center', 'rosalinda'),
						'tr' => esc_html__('Top Right', 'rosalinda'),
						'ml' => esc_html__('Middle Left', 'rosalinda'),
						'mc' => esc_html__('Middle Center', 'rosalinda'),
						'mr' => esc_html__('Middle Right', 'rosalinda'),
						'bl' => esc_html__('Bottom Left', 'rosalinda'),
						'bc' => esc_html__('Bottom Center', 'rosalinda'),
						'br' => esc_html__('Bottom Right', 'rosalinda'),
						'bs' => esc_html__('Bottom Stick Out', 'rosalinda'),
					),
					'type'       => ROSALINDA_THEME_FREE ? 'hidden' : 'select',
				),
				'hide_sidebar_on_single'        => array(
					'title' => esc_html__( 'Hide sidebar on the single post', 'rosalinda' ),
					'desc'  => wp_kses_data( __( "Hide sidebar on the single post's pages", 'rosalinda' ) ),
					'std'   => 0,
					'type'  => 'checkbox',
				),
				'show_post_excerpt'              => array(
					'title' => esc_html__( 'Show post excerpt', 'rosalinda' ),
					'desc'  => wp_kses_data( __( "Display post excerpt under post title.", 'rosalinda' ) ),
					'override' => array(
						'mode'    => 'post',
						'section' => esc_html__( 'Content', 'rosalinda' ),
					),
					'dependency' => array(
						'hide_featured_on_single' => array( 0 ),
					),
					'std'   => 0,
					'type'  => 'checkbox',
				),
				'show_post_meta'                => array(
					'title' => esc_html__( 'Show post meta', 'rosalinda' ),
					'desc'  => wp_kses_data( __( "Display block with post's meta: date, categories, counters, etc.", 'rosalinda' ) ),
					'std'   => 1,
					'type'  => 'checkbox',
				),
				'meta_parts_post'               => array(
					'title'      => esc_html__( 'Post meta', 'rosalinda' ),
					'desc'       => wp_kses_data( __( 'Meta parts for single posts. Post counters and Share Links are available only if plugin ThemeREX Addons is active', 'rosalinda' ) )
								. '<br>'
								. wp_kses_data( __( '<b>Tip:</b> Drag items to change their order.', 'rosalinda' ) ),
					'dependency' => array(
						'show_post_meta' => array( 1 ),
					),
					'dir'        => 'vertical',
					'sortable'   => true,
					'std'        => 'categories=0|date=0|counters=1|author=0|share=0|edit=0',
					'options'    => rosalinda_get_list_meta_parts(),
					'type'       => ROSALINDA_THEME_FREE ? 'hidden' : 'checklist',
				),
				'counters_post'                 => array(
					'title'      => esc_html__( 'Post counters', 'rosalinda' ),
					'desc'       => wp_kses_data( __( 'Show only selected counters. Attention! Likes and Views are available only if plugin ThemeREX Addons is active', 'rosalinda' ) ),
					'dependency' => array(
						'show_post_meta' => array( 1 ),
					),
					'dir'        => 'vertical',
					'sortable'   => true,
					'std'        => 'views=0|likes=1|comments=1',
					'options'    => rosalinda_get_list_counters(),
					'type'       => ROSALINDA_THEME_FREE || ! rosalinda_exists_trx_addons() ? 'hidden' : 'checklist',
				),
				'show_share_links'              => array(
					'title' => esc_html__( 'Show share links', 'rosalinda' ),
					'desc'  => wp_kses_data( __( 'Display share links on the single post', 'rosalinda' ) ),
					'std'   => 1,
					'type'  => ! rosalinda_exists_trx_addons() ? 'hidden' : 'checkbox',
				),
				'show_author_info'              => array(
					'title' => esc_html__( 'Show author info', 'rosalinda' ),
					'desc'  => wp_kses_data( __( "Display block with information about post's author", 'rosalinda' ) ),
					'std'   => 0,
					'type'  => 'checkbox',
				),
				'blog_single_related_info'      => array(
					'title' => esc_html__( 'Related posts', 'rosalinda' ),
					'desc'  => '',
					'type'  => 'info',
				),
				'show_related_posts'            => array(
					'title'    => esc_html__( 'Show related posts', 'rosalinda' ),
					'desc'     => wp_kses_data( __( "Show section 'Related posts' on the single post's pages", 'rosalinda' ) ),
					'override' => array(
						'mode'    => 'page',
						'section' => esc_html__( 'Content', 'rosalinda' ),
					),
					'std'      => 0,
					'type'     => 'checkbox',
				),
				'related_posts'                 => array(
					'title'      => esc_html__( 'Related posts', 'rosalinda' ),
					'desc'       => wp_kses_data( __( 'How many related posts should be displayed in the single post? If 0 - no related posts are shown.', 'rosalinda' ) ),
					'dependency' => array(
						'show_related_posts' => array( 1 ),
					),
					'std'        => 2,
					'options'    => rosalinda_get_list_range( 1, 9 ),
					'type'       => ROSALINDA_THEME_FREE ? 'hidden' : 'select',
				),
				'related_columns'               => array(
					'title'      => esc_html__( 'Related columns', 'rosalinda' ),
					'desc'       => wp_kses_data( __( 'How many columns should be used to output related posts in the single page (from 2 to 4)?', 'rosalinda' ) ),
					'dependency' => array(
						'show_related_posts' => array( 1 ),
					),
					'std'        => 2,
					'options'    => rosalinda_get_list_range( 1, 4 ),
					'type'       => ROSALINDA_THEME_FREE ? 'hidden' : 'switch',
				),
				'related_style'                 => array(
					'title'      => esc_html__( 'Related posts style', 'rosalinda' ),
					'desc'       => wp_kses_data( __( 'Select style of the related posts output', 'rosalinda' ) ),
					'dependency' => array(
						'show_related_posts' => array( 1 ),
					),
					'std'        => 2,
					'options'    => rosalinda_get_list_styles( 1, 3 ),
					'type'       => ROSALINDA_THEME_FREE ? 'hidden' : 'switch',
				),
				'related_slider'                => array(
					'title'      => esc_html__( 'Use slider layout', 'rosalinda' ),
					'desc'       => wp_kses_data( __( 'Use slider layout in case related posts count is more than columns count', 'rosalinda' ) ),
					'dependency' => array(
						'show_related_posts' => array( 1 ),
					),
					'std'        => 0,
					'type'       => ROSALINDA_THEME_FREE ? 'hidden' : 'checkbox',
				),
				'related_slider_controls'       => array(
					'title'      => esc_html__( 'Slider controls', 'rosalinda' ),
					'desc'       => wp_kses_data( __( 'Show arrows in the slider', 'rosalinda' ) ),
					'dependency' => array(
						'show_related_posts' => array( 1 ),
						'related_slider' => array( 1 ),
					),
					'std'        => 'none',
					'options'    => array(
						'none'    => esc_html__('None', 'rosalinda'),
						'side'    => esc_html__('Side', 'rosalinda'),
						'outside' => esc_html__('Outside', 'rosalinda'),
						'top'     => esc_html__('Top', 'rosalinda'),
						'bottom'  => esc_html__('Bottom', 'rosalinda')
					),
					'type'       => ROSALINDA_THEME_FREE ? 'hidden' : 'select',
				),
				'related_slider_pagination'       => array(
					'title'      => esc_html__( 'Slider pagination', 'rosalinda' ),
					'desc'       => wp_kses_data( __( 'Show bullets after the slider', 'rosalinda' ) ),
					'dependency' => array(
						'show_related_posts' => array( 1 ),
						'related_slider' => array( 1 ),
					),
					'std'        => 'bottom',
					'options'    => array(
						'none'    => esc_html__('None', 'rosalinda'),
						'bottom'  => esc_html__('Bottom', 'rosalinda')
					),
					'type'       => ROSALINDA_THEME_FREE ? 'hidden' : 'switch',
				),
				'related_slider_space'          => array(
					'title'      => esc_html__( 'Space', 'rosalinda' ),
					'desc'       => wp_kses_data( __( 'Space between slides', 'rosalinda' ) ),
					'dependency' => array(
						'show_related_posts' => array( 1 ),
						'related_slider' => array( 1 ),
					),
					'std'        => 30,
					'type'       => ROSALINDA_THEME_FREE ? 'hidden' : 'text',
				),
				'related_position'              => array(
					'title'      => esc_html__( 'Related posts position', 'rosalinda' ),
					'desc'       => wp_kses_data( __( 'Select position to display the related posts', 'rosalinda' ) ),
					'dependency' => array(
						'show_related_posts' => array( 1 ),
					),
					'std'        => 'below_content',
					'options'    => array (
						'below_content' => esc_html__( 'After content', 'rosalinda' ),
						'below_page'    => esc_html__( 'After content & sidebar', 'rosalinda' ),
					),
					'type'       => ROSALINDA_THEME_FREE ? 'hidden' : 'switch',
				),
				'posts_navigation_info'      => array(
					'title' => esc_html__( 'Posts navigation', 'rosalinda' ),
					'desc'  => '',
					'type'  => 'info',
				),
				'show_posts_navigation'		=> array(
					'title'    => esc_html__( 'Show posts navigation', 'rosalinda' ),
					'desc'     => wp_kses_data( __( "Show posts navigation on the single post's pages", 'rosalinda' ) ),
					'std'      => 1,
					'type'     => 'checkbox',
				),
				'fixed_posts_navigation'		=> array(
					'title'    => esc_html__( 'Fixed posts navigation', 'rosalinda' ),
					'desc'     => wp_kses_data( __( "Make posts navigation fixed position. Display them at the bottom of the window.", 'rosalinda' ) ),
					'dependency' => array(
						'show_posts_navigation' => array( 1 ),
					),
					'std'      => 0,
					'type'     => 'checkbox',
				),
				'posts_banners_info'      => array(
					'title' => esc_html__( 'Posts banners', 'rosalinda' ),
					'desc'  => '',
					'type'  => 'hidden',
				),
				'header_banner_link'     => array(
					'title' => esc_html__( 'Header banner link', 'rosalinda' ),
					'desc'  => wp_kses_data( __( 'Insert URL of the banner', 'rosalinda' ) ),
					'override'   => array(
						'mode'    => 'post',
						'section' => esc_html__( 'Banners', 'rosalinda' ),
					),
					'std'   => '',
					'type'  => 'hidden', //text
				),
				'header_banner_img'     => array(
					'title' => esc_html__( 'Header banner image', 'rosalinda' ),
					'desc'  => wp_kses_data( __( 'Select image to display at the backgound', 'rosalinda' ) ),
					'override'   => array(
						'mode'    => 'post',
						'section' => esc_html__( 'Banners', 'rosalinda' ),
					),
					'std'        => '',
					'type'       => 'hidden', //image
				),
				'header_banner_code'     => array(
					'title'      => esc_html__( 'Header banner code', 'rosalinda' ),
					'desc'       => wp_kses_data( __( 'Embed html code', 'rosalinda' ) ),
					'override'   => array(
						'mode'    => 'post',
						'section' => esc_html__( 'Banners', 'rosalinda' ),
					),
					'std'        => '',
					'allow_html' => true,
					'type'       => 'hidden', //textarea
				),
				'footer_banner_link'     => array(
					'title' => esc_html__( 'Footer banner link', 'rosalinda' ),
					'desc'  => wp_kses_data( __( 'Insert URL of the banner', 'rosalinda' ) ),
					'override'   => array(
						'mode'    => 'post',
						'section' => esc_html__( 'Banners', 'rosalinda' ),
					),
					'std'   => '',
					'type'  => 'text',
				),
				'footer_banner_img'     => array(
					'title' => esc_html__( 'Footer banner image', 'rosalinda' ),
					'desc'  => wp_kses_data( __( 'Select image to display at the backgound', 'rosalinda' ) ),
					'override'   => array(
						'mode'    => 'post',
						'section' => esc_html__( 'Banners', 'rosalinda' ),
					),
					'std'        => '',
					'type'       => 'image',
				),
				'footer_banner_code'     => array(
					'title'      => esc_html__( 'Footer banner code', 'rosalinda' ),
					'desc'       => wp_kses_data( __( 'Embed html code', 'rosalinda' ) ),
					'override'   => array(
						'mode'    => 'post',
						'section' => esc_html__( 'Banners', 'rosalinda' ),
					),
					'std'        => '',
					'allow_html' => true,
					'type'       => 'textarea',
				),
				'sidebar_banner_link'     => array(
					'title' => esc_html__( 'Sidebar banner link', 'rosalinda' ),
					'desc'  => wp_kses_data( __( 'Insert URL of the banner', 'rosalinda' ) ),
					'override'   => array(
						'mode'    => 'post',
						'section' => esc_html__( 'Banners', 'rosalinda' ),
					),
					'std'   => '',
					'type'  => 'text',
				),
				'sidebar_banner_img'     => array(
					'title' => esc_html__( 'Sidebar banner image', 'rosalinda' ),
					'desc'  => wp_kses_data( __( 'Select image to display at the backgound', 'rosalinda' ) ),
					'override'   => array(
						'mode'    => 'post',
						'section' => esc_html__( 'Banners', 'rosalinda' ),
					),
					'std'        => '',
					'type'       => 'image',
				),
				'sidebar_banner_code'     => array(
					'title'      => esc_html__( 'Sidebar banner code', 'rosalinda' ),
					'desc'       => wp_kses_data( __( 'Embed html code', 'rosalinda' ) ),
					'override'   => array(
						'mode'    => 'post',
						'section' => esc_html__( 'Banners', 'rosalinda' ),
					),
					'std'        => '',
					'allow_html' => true,
					'type'       => 'textarea',
				),
				'background_banner_link'     => array(
					'title' => esc_html__( "Post's background banner link", 'rosalinda' ),
					'desc'  => wp_kses_data( __( 'Insert URL of the banner', 'rosalinda' ) ),
					'override'   => array(
						'mode'    => 'post',
						'section' => esc_html__( 'Banners', 'rosalinda' ),
					),
					'std'   => '',
					'type'  => 'text',
				),
				'background_banner_img'     => array(
					'title' => esc_html__( "Post's background banner image", 'rosalinda' ),
					'desc'  => wp_kses_data( __( 'Select image to display at the backgound', 'rosalinda' ) ),
					'override'   => array(
						'mode'    => 'post',
						'section' => esc_html__( 'Banners', 'rosalinda' ),
					),
					'std'        => '',
					'type'       => 'image',
				),
				'background_banner_code'     => array(
					'title'      => esc_html__( "Post's background banner code", 'rosalinda' ),
					'desc'       => wp_kses_data( __( 'Embed html code', 'rosalinda' ) ),
					'override'   => array(
						'mode'    => 'post',
						'section' => esc_html__( 'Banners', 'rosalinda' ),
					),
					'std'        => '',
					'allow_html' => true,
					'type'       => 'textarea',
				),
				'blog_end'                      => array(
					'type' => 'panel_end',
				),

				// 'Colors'
				'panel_colors'                  => array(
					'title'    => esc_html__( 'Colors', 'rosalinda' ),
					'desc'     => '',
					'priority' => 300,
					'type'     => 'section',
				),

				'color_schemes_info'            => array(
					'title'  => esc_html__( 'Color schemes', 'rosalinda' ),
					'desc'   => wp_kses_data( __( 'Color schemes for various parts of the site. "Inherit" means that this block is used the Site color scheme (the first parameter)', 'rosalinda' ) ),
					'hidden' => $hide_schemes,
					'type'   => 'info',
				),
				'color_scheme'                  => array(
					'title'    => esc_html__( 'Site Color Scheme', 'rosalinda' ),
					'desc'     => '',
					'override' => array(
						'mode'    => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Colors', 'rosalinda' ),
					),
					'std'      => 'default',
					'options'  => array(),
					'refresh'  => false,
					'type'     => $hide_schemes ? 'hidden' : 'switch',
				),
				'header_scheme'                 => array(
					'title'    => esc_html__( 'Header Color Scheme', 'rosalinda' ),
					'desc'     => '',
					'override' => array(
						'mode'    => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Colors', 'rosalinda' ),
					),
					'std'      => 'inherit',
					'options'  => array(),
					'refresh'  => false,
					'type'     => $hide_schemes ? 'hidden' : 'switch',
				),
				'menu_scheme'                   => array(
					'title'    => esc_html__( 'Sidemenu Color Scheme', 'rosalinda' ),
					'desc'     => '',
					'override' => array(
						'mode'    => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Colors', 'rosalinda' ),
					),
					'std'      => 'inherit',
					'options'  => array(),
					'refresh'  => false,
					'type'     => $hide_schemes || ROSALINDA_THEME_FREE ? 'hidden' : 'switch',
				),
				'sidebar_scheme'                => array(
					'title'    => esc_html__( 'Sidebar Color Scheme', 'rosalinda' ),
					'desc'     => '',
					'override' => array(
						'mode'    => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Colors', 'rosalinda' ),
					),
					'std'      => 'inherit',
					'options'  => array(),
					'refresh'  => false,
					'type'     => $hide_schemes ? 'hidden' : 'switch',
				),
				'footer_scheme'                 => array(
					'title'    => esc_html__( 'Footer Color Scheme', 'rosalinda' ),
					'desc'     => '',
					'override' => array(
						'mode'    => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Colors', 'rosalinda' ),
					),
					'std'      => 'inherit',
					'options'  => array(),
					'refresh'  => false,
					'type'     => $hide_schemes ? 'hidden' : 'switch',
				),

				'color_scheme_editor_info'      => array(
					'title' => esc_html__( 'Color scheme editor', 'rosalinda' ),
					'desc'  => wp_kses_data( __( 'Select color scheme to modify. Attention! Only those sections in the site will be changed which this scheme was assigned to', 'rosalinda' ) ),
					'type'  => 'info',
				),
				'scheme_storage'                => array(
					'title'       => esc_html__( 'Color scheme editor', 'rosalinda' ),
					'desc'        => '',
					'std'         => '$rosalinda_get_scheme_storage',
					'refresh'     => false,
					'colorpicker' => 'tiny',
					'type'        => 'scheme_editor',
				),

				// Internal options.
				// Attention! Don't change any options in the section below!
				// Use huge priority to call render this elements after all options!
				'reset_options'                 => array(
					'title'    => '',
					'desc'     => '',
					'std'      => '0',
					'priority' => 10000,
					'type'     => 'hidden',
				),

				'last_option'                   => array(     // Need to manually call action to include Tiny MCE scripts
					'title' => '',
					'desc'  => '',
					'std'   => 1,
					'type'  => 'hidden',
				),

			)
		);

		// Prepare panel 'Fonts'
		// -------------------------------------------------------------
		$fonts = array(

			// 'Fonts'
			'fonts'             => array(
				'title'    => esc_html__( 'Typography', 'rosalinda' ),
				'desc'     => '',
				'priority' => 200,
				'type'     => 'panel',
			),

			// Fonts - Load_fonts
			'load_fonts'        => array(
				'title' => esc_html__( 'Load fonts', 'rosalinda' ),
				'desc'  => wp_kses_data( __( 'Specify fonts to load when theme start. You can use them in the base theme elements: headers, text, menu, links, input fields, etc.', 'rosalinda' ) )
						. '<br>'
						. wp_kses_data( __( 'Attention! Press "Refresh" button to reload preview area after the all fonts are changed', 'rosalinda' ) ),
				'type'  => 'section',
			),
			'load_fonts_subset' => array(
				'title'   => esc_html__( 'Google fonts subsets', 'rosalinda' ),
				'desc'    => wp_kses_data( __( 'Specify comma separated list of the subsets which will be load from Google fonts', 'rosalinda' ) )
						. '<br>'
						. wp_kses_data( __( 'Available subsets are: latin,latin-ext,cyrillic,cyrillic-ext,greek,greek-ext,vietnamese', 'rosalinda' ) ),
				'class'   => 'rosalinda_column-1_3 rosalinda_new_row',
				'refresh' => false,
				'std'     => '$rosalinda_get_load_fonts_subset',
				'type'    => 'text',
			),
		);

		for ( $i = 1; $i <= rosalinda_get_theme_setting( 'max_load_fonts' ); $i++ ) {
			if ( rosalinda_get_value_gp( 'page' ) != 'theme_options' ) {
				$fonts[ "load_fonts-{$i}-info" ] = array(
					// Translators: Add font's number - 'Font 1', 'Font 2', etc
					'title' => esc_html( sprintf( __( 'Font %s', 'rosalinda' ), $i ) ),
					'desc'  => '',
					'type'  => 'info',
				);
			}
			$fonts[ "load_fonts-{$i}-name" ]   = array(
				'title'   => esc_html__( 'Font name', 'rosalinda' ),
				'desc'    => '',
				'class'   => 'rosalinda_column-1_3 rosalinda_new_row',
				'refresh' => false,
				'std'     => '$rosalinda_get_load_fonts_option',
				'type'    => 'text',
			);
			$fonts[ "load_fonts-{$i}-family" ] = array(
				'title'   => esc_html__( 'Font family', 'rosalinda' ),
				'desc'    => 1 == $i
							? wp_kses_data( __( 'Select font family to use it if font above is not available', 'rosalinda' ) )
							: '',
				'class'   => 'rosalinda_column-1_3',
				'refresh' => false,
				'std'     => '$rosalinda_get_load_fonts_option',
				'options' => array(
					'inherit'    => esc_html__( 'Inherit', 'rosalinda' ),
					'serif'      => esc_html__( 'serif', 'rosalinda' ),
					'sans-serif' => esc_html__( 'sans-serif', 'rosalinda' ),
					'monospace'  => esc_html__( 'monospace', 'rosalinda' ),
					'cursive'    => esc_html__( 'cursive', 'rosalinda' ),
					'fantasy'    => esc_html__( 'fantasy', 'rosalinda' ),
				),
				'type'    => 'select',
			);
			$fonts[ "load_fonts-{$i}-styles" ] = array(
				'title'   => esc_html__( 'Font styles', 'rosalinda' ),
				'desc'    => 1 == $i
							? wp_kses_data( __( 'Font styles used only for the Google fonts. This is a comma separated list of the font weight and styles. For example: 400,400italic,700', 'rosalinda' ) )
								. '<br>'
								. wp_kses_data( __( 'Attention! Each weight and style increase download size! Specify only used weights and styles.', 'rosalinda' ) )
							: '',
				'class'   => 'rosalinda_column-1_3',
				'refresh' => false,
				'std'     => '$rosalinda_get_load_fonts_option',
				'type'    => 'text',
			);
		}
		$fonts['load_fonts_end'] = array(
			'type' => 'section_end',
		);

		// Fonts - H1..6, P, Info, Menu, etc.
		$theme_fonts = rosalinda_get_theme_fonts();
		foreach ( $theme_fonts as $tag => $v ) {
			$fonts[ "{$tag}_section" ] = array(
				'title' => ! empty( $v['title'] )
								? $v['title']
								// Translators: Add tag's name to make title 'H1 settings', 'P settings', etc.
								: esc_html( sprintf( __( '%s settings', 'rosalinda' ), $tag ) ),
				'desc'  => ! empty( $v['description'] )
								? $v['description']
								// Translators: Add tag's name to make description
								: wp_kses( sprintf( __( 'Font settings of the "%s" tag.', 'rosalinda' ), $tag ), 'rosalinda_kses_content' ),
				'type'  => 'section',
			);

			foreach ( $v as $css_prop => $css_value ) {
				if ( in_array( $css_prop, array( 'title', 'description' ) ) ) {
					continue;
				}
				$options    = '';
				$type       = 'text';
				$load_order = 1;
				$title      = ucfirst( str_replace( '-', ' ', $css_prop ) );
				if ( 'font-family' == $css_prop ) {
					$type       = 'select';
					$options    = array();
					$load_order = 2;        // Load this option's value after all options are loaded (use option 'load_fonts' to build fonts list)
				} elseif ( 'font-weight' == $css_prop ) {
					$type    = 'select';
					$options = array(
						'inherit' => esc_html__( 'Inherit', 'rosalinda' ),
						'100'     => esc_html__( '100 (Light)', 'rosalinda' ),
						'200'     => esc_html__( '200 (Light)', 'rosalinda' ),
						'300'     => esc_html__( '300 (Thin)', 'rosalinda' ),
						'400'     => esc_html__( '400 (Normal)', 'rosalinda' ),
						'500'     => esc_html__( '500 (Semibold)', 'rosalinda' ),
						'600'     => esc_html__( '600 (Semibold)', 'rosalinda' ),
						'700'     => esc_html__( '700 (Bold)', 'rosalinda' ),
						'800'     => esc_html__( '800 (Black)', 'rosalinda' ),
						'900'     => esc_html__( '900 (Black)', 'rosalinda' ),
					);
				} elseif ( 'font-style' == $css_prop ) {
					$type    = 'select';
					$options = array(
						'inherit' => esc_html__( 'Inherit', 'rosalinda' ),
						'normal'  => esc_html__( 'Normal', 'rosalinda' ),
						'italic'  => esc_html__( 'Italic', 'rosalinda' ),
					);
				} elseif ( 'text-decoration' == $css_prop ) {
					$type    = 'select';
					$options = array(
						'inherit'      => esc_html__( 'Inherit', 'rosalinda' ),
						'none'         => esc_html__( 'None', 'rosalinda' ),
						'underline'    => esc_html__( 'Underline', 'rosalinda' ),
						'overline'     => esc_html__( 'Overline', 'rosalinda' ),
						'line-through' => esc_html__( 'Line-through', 'rosalinda' ),
					);
				} elseif ( 'text-transform' == $css_prop ) {
					$type    = 'select';
					$options = array(
						'inherit'    => esc_html__( 'Inherit', 'rosalinda' ),
						'none'       => esc_html__( 'None', 'rosalinda' ),
						'uppercase'  => esc_html__( 'Uppercase', 'rosalinda' ),
						'lowercase'  => esc_html__( 'Lowercase', 'rosalinda' ),
						'capitalize' => esc_html__( 'Capitalize', 'rosalinda' ),
					);
				}
				$fonts[ "{$tag}_{$css_prop}" ] = array(
					'title'      => $title,
					'desc'       => '',
					'class'      => 'rosalinda_column-1_5',
					'refresh'    => false,
					'load_order' => $load_order,
					'std'        => '$rosalinda_get_theme_fonts_option',
					'options'    => $options,
					'type'       => $type,
				);
			}

			$fonts[ "{$tag}_section_end" ] = array(
				'type' => 'section_end',
			);
		}

		$fonts['fonts_end'] = array(
			'type' => 'panel_end',
		);

		// Add fonts parameters to Theme Options
		rosalinda_storage_set_array_before( 'options', 'panel_colors', $fonts );

		// Add Header Video if WP version < 4.7
		// -----------------------------------------------------
		if ( ! function_exists( 'get_header_video_url' ) ) {
			rosalinda_storage_set_array_after(
				'options', 'header_image_override', 'header_video', array(
					'title'    => esc_html__( 'Header video', 'rosalinda' ),
					'desc'     => wp_kses_data( __( 'Select video to use it as background for the header', 'rosalinda' ) ),
					'override' => array(
						'mode'    => 'page',
						'section' => esc_html__( 'Header', 'rosalinda' ),
					),
					'std'      => '',
					'type'     => 'video',
				)
			);
		}

		// Add option 'logo' if WP version < 4.5
		// or 'custom_logo' if current page is not 'Customize'
		// ------------------------------------------------------
		if ( ! function_exists( 'the_custom_logo' ) || ! rosalinda_check_current_url( 'customize.php' ) ) {
			rosalinda_storage_set_array_before(
				'options', 'logo_retina', function_exists( 'the_custom_logo' ) ? 'custom_logo' : 'logo', array(
					'title'    => esc_html__( 'Logo', 'rosalinda' ),
					'desc'     => wp_kses_data( __( 'Select or upload the site logo', 'rosalinda' ) ),
					'class'    => 'rosalinda_column-1_2 rosalinda_new_row',
					'priority' => 60,
					'std'      => '',
					'qsetup'   => esc_html__( 'General', 'rosalinda' ),
					'type'     => 'image',
				)
			);
		}

	}
}


// Returns a list of options that can be overridden for CPT
if ( ! function_exists( 'rosalinda_options_get_list_cpt_options' ) ) {
	function rosalinda_options_get_list_cpt_options( $cpt, $title = '' ) {
		if ( empty( $title ) ) {
			$title = ucfirst( $cpt );
		}
		return array(
			"header_info_{$cpt}"            => array(
				'title' => esc_html__( 'Header', 'rosalinda' ),
				'desc'  => '',
				'type'  => 'info',
			),
			"header_type_{$cpt}"            => array(
				'title'   => esc_html__( 'Header style', 'rosalinda' ),
				'desc'    => wp_kses_data( __( 'Choose whether to use the default header or header Layouts (available only if the ThemeREX Addons is activated)', 'rosalinda' ) ),
				'std'     => 'inherit',
				'options' => rosalinda_get_list_header_footer_types( true ),
				'type'    => ROSALINDA_THEME_FREE ? 'hidden' : 'switch',
			),
			"header_style_{$cpt}"           => array(
				'title'      => esc_html__( 'Select custom layout', 'rosalinda' ),
				// Translators: Add CPT name to the description
				'desc'       => wp_kses_data( sprintf( __( 'Select custom layout to display the site header on the %s pages', 'rosalinda' ), $title ) ),
				'dependency' => array(
					"header_type_{$cpt}" => array( 'custom' ),
				),
				'std'        => 'inherit',
				'options'    => array(),
				'type'       => ROSALINDA_THEME_FREE ? 'hidden' : 'select',
			),
			"header_position_{$cpt}"        => array(
				'title'   => esc_html__( 'Header position', 'rosalinda' ),
				// Translators: Add CPT name to the description
				'desc'    => wp_kses_data( sprintf( __( 'Select position to display the site header on the %s pages', 'rosalinda' ), $title ) ),
				'std'     => 'inherit',
				'options' => array(),
				'type'    => ROSALINDA_THEME_FREE ? 'hidden' : 'switch',
			),
			"header_image_override_{$cpt}"  => array(
				'title'   => esc_html__( 'Header image override', 'rosalinda' ),
				'desc'    => wp_kses_data( __( "Allow override the header image with the post's featured image", 'rosalinda' ) ),
				'std'     => 'inherit',
				'options' => array(
					'inherit' => esc_html__( 'Inherit', 'rosalinda' ),
					1         => esc_html__( 'Yes', 'rosalinda' ),
					0         => esc_html__( 'No', 'rosalinda' ),
				),
				'type'    => ROSALINDA_THEME_FREE ? 'hidden' : 'switch',
			),
			"header_widgets_{$cpt}"         => array(
				'title'   => esc_html__( 'Header widgets', 'rosalinda' ),
				// Translators: Add CPT name to the description
				'desc'    => wp_kses_data( sprintf( __( 'Select set of widgets to show in the header on the %s pages', 'rosalinda' ), $title ) ),
				'std'     => 'hide',
				'options' => array(),
				'type'    => 'select',
			),

			"sidebar_info_{$cpt}"           => array(
				'title' => esc_html__( 'Sidebar', 'rosalinda' ),
				'desc'  => '',
				'type'  => 'info',
			),
			"sidebar_position_{$cpt}"       => array(
				'title'   => esc_html__( 'Sidebar position', 'rosalinda' ),
				// Translators: Add CPT name to the description
				'desc'    => wp_kses_data( sprintf( __( 'Select position to show sidebar on the %s pages', 'rosalinda' ), $title ) ),
				'std'     => 'left',
				'options' => array(),
				'type'    => 'switch',
			),
			"sidebar_widgets_{$cpt}"        => array(
				'title'      => esc_html__( 'Sidebar widgets', 'rosalinda' ),
				// Translators: Add CPT name to the description
				'desc'       => wp_kses_data( sprintf( __( 'Select sidebar to show on the %s pages', 'rosalinda' ), $title ) ),
				'dependency' => array(
					"sidebar_position_{$cpt}" => array( 'left', 'right' ),
				),
				'std'        => 'hide',
				'options'    => array(),
				'type'       => 'select',
			),
			"hide_sidebar_on_single_{$cpt}" => array(
				'title'   => esc_html__( 'Hide sidebar on the single pages', 'rosalinda' ),
				'desc'    => wp_kses_data( __( 'Hide sidebar on the single page', 'rosalinda' ) ),
				'std'     => 'inherit',
				'options' => array(
					'inherit' => esc_html__( 'Inherit', 'rosalinda' ),
					1         => esc_html__( 'Hide', 'rosalinda' ),
					0         => esc_html__( 'Show', 'rosalinda' ),
				),
				'type'    => 'switch',
			),

			"footer_info_{$cpt}"            => array(
				'title' => esc_html__( 'Footer', 'rosalinda' ),
				'desc'  => '',
				'type'  => 'info',
			),
			"footer_type_{$cpt}"            => array(
				'title'   => esc_html__( 'Footer style', 'rosalinda' ),
				'desc'    => wp_kses_data( __( 'Choose whether to use the default footer or footer Layouts (available only if the ThemeREX Addons is activated)', 'rosalinda' ) ),
				'std'     => 'inherit',
				'options' => rosalinda_get_list_header_footer_types( true ),
				'type'    => ROSALINDA_THEME_FREE ? 'hidden' : 'switch',
			),
			"footer_style_{$cpt}"           => array(
				'title'      => esc_html__( 'Select custom layout', 'rosalinda' ),
				'desc'       => wp_kses_data( __( 'Select custom layout to display the site footer', 'rosalinda' ) ),
				'std'        => 'inherit',
				'dependency' => array(
					"footer_type_{$cpt}" => array( 'custom' ),
				),
				'options'    => array(),
				'type'       => ROSALINDA_THEME_FREE ? 'hidden' : 'select',
			),
			"footer_widgets_{$cpt}"         => array(
				'title'      => esc_html__( 'Footer widgets', 'rosalinda' ),
				'desc'       => wp_kses_data( __( 'Select set of widgets to show in the footer', 'rosalinda' ) ),
				'dependency' => array(
					"footer_type_{$cpt}" => array( 'default' ),
				),
				'std'        => 'footer_widgets',
				'options'    => array(),
				'type'       => 'select',
			),
			"footer_columns_{$cpt}"         => array(
				'title'      => esc_html__( 'Footer columns', 'rosalinda' ),
				'desc'       => wp_kses_data( __( 'Select number columns to show widgets in the footer. If 0 - autodetect by the widgets count', 'rosalinda' ) ),
				'dependency' => array(
					"footer_type_{$cpt}"    => array( 'default' ),
					"footer_widgets_{$cpt}" => array( '^hide' ),
				),
				'std'        => 0,
				'options'    => rosalinda_get_list_range( 0, 6 ),
				'type'       => 'select',
			),
			"footer_wide_{$cpt}"            => array(
				'title'      => esc_html__( 'Footer fullwidth', 'rosalinda' ),
				'desc'       => wp_kses_data( __( 'Do you want to stretch the footer to the entire window width?', 'rosalinda' ) ),
				'dependency' => array(
					"footer_type_{$cpt}" => array( 'default' ),
				),
				'std'        => 0,
				'type'       => 'checkbox',
			),

			"widgets_info_{$cpt}"           => array(
				'title' => esc_html__( 'Additional panels', 'rosalinda' ),
				'desc'  => '',
				'type'  => ROSALINDA_THEME_FREE ? 'hidden' : 'info',
			),
			"widgets_above_page_{$cpt}"     => array(
				'title'   => esc_html__( 'Widgets at the top of the page', 'rosalinda' ),
				'desc'    => wp_kses_data( __( 'Select widgets to show at the top of the page (above content and sidebar)', 'rosalinda' ) ),
				'std'     => 'hide',
				'options' => array(),
				'type'    => ROSALINDA_THEME_FREE ? 'hidden' : 'select',
			),
			"widgets_above_content_{$cpt}"  => array(
				'title'   => esc_html__( 'Widgets above the content', 'rosalinda' ),
				'desc'    => wp_kses_data( __( 'Select widgets to show at the beginning of the content area', 'rosalinda' ) ),
				'std'     => 'hide',
				'options' => array(),
				'type'    => ROSALINDA_THEME_FREE ? 'hidden' : 'select',
			),
			"widgets_below_content_{$cpt}"  => array(
				'title'   => esc_html__( 'Widgets below the content', 'rosalinda' ),
				'desc'    => wp_kses_data( __( 'Select widgets to show at the ending of the content area', 'rosalinda' ) ),
				'std'     => 'hide',
				'options' => array(),
				'type'    => ROSALINDA_THEME_FREE ? 'hidden' : 'select',
			),
			"widgets_below_page_{$cpt}"     => array(
				'title'   => esc_html__( 'Widgets at the bottom of the page', 'rosalinda' ),
				'desc'    => wp_kses_data( __( 'Select widgets to show at the bottom of the page (below content and sidebar)', 'rosalinda' ) ),
				'std'     => 'hide',
				'options' => array(),
				'type'    => ROSALINDA_THEME_FREE ? 'hidden' : 'select',
			),
		);
	}
}


// Return lists with choises when its need in the admin mode
if ( ! function_exists( 'rosalinda_options_get_list_choises' ) ) {
	add_filter( 'rosalinda_filter_options_get_list_choises', 'rosalinda_options_get_list_choises', 10, 2 );
	function rosalinda_options_get_list_choises( $list, $id ) {
		if ( is_array( $list ) && count( $list ) == 0 ) {
			if ( strpos( $id, 'header_style' ) === 0 ) {
				$list = rosalinda_get_list_header_styles( strpos( $id, 'header_style_' ) === 0 );
			} elseif ( strpos( $id, 'header_position' ) === 0 ) {
				$list = rosalinda_get_list_header_positions( strpos( $id, 'header_position_' ) === 0 );
			} elseif ( strpos( $id, 'header_widgets' ) === 0 ) {
				$list = rosalinda_get_list_sidebars( strpos( $id, 'header_widgets_' ) === 0, true );
			} elseif ( strpos( $id, '_scheme' ) > 0 ) {
				$list = rosalinda_get_list_schemes( 'color_scheme' != $id );
			} elseif ( strpos( $id, 'sidebar_widgets' ) === 0 ) {
				$list = rosalinda_get_list_sidebars( strpos( $id, 'sidebar_widgets_' ) === 0, true );
			} elseif ( strpos( $id, 'sidebar_position' ) === 0 ) {
				$list = rosalinda_get_list_sidebars_positions( strpos( $id, 'sidebar_position_' ) === 0 );
			} elseif ( strpos( $id, 'widgets_above_page' ) === 0 ) {
				$list = rosalinda_get_list_sidebars( strpos( $id, 'widgets_above_page_' ) === 0, true );
			} elseif ( strpos( $id, 'widgets_above_content' ) === 0 ) {
				$list = rosalinda_get_list_sidebars( strpos( $id, 'widgets_above_content_' ) === 0, true );
			} elseif ( strpos( $id, 'widgets_below_page' ) === 0 ) {
				$list = rosalinda_get_list_sidebars( strpos( $id, 'widgets_below_page_' ) === 0, true );
			} elseif ( strpos( $id, 'widgets_below_content' ) === 0 ) {
				$list = rosalinda_get_list_sidebars( strpos( $id, 'widgets_below_content_' ) === 0, true );
			} elseif ( strpos( $id, 'footer_style' ) === 0 ) {
				$list = rosalinda_get_list_footer_styles( strpos( $id, 'footer_style_' ) === 0 );
			} elseif ( strpos( $id, 'footer_widgets' ) === 0 ) {
				$list = rosalinda_get_list_sidebars( strpos( $id, 'footer_widgets_' ) === 0, true );
			} elseif ( strpos( $id, 'blog_style' ) === 0 ) {
				$list = rosalinda_get_list_blog_styles( strpos( $id, 'blog_style_' ) === 0 );
			} elseif ( strpos( $id, 'post_type' ) === 0 ) {
				$list = rosalinda_get_list_posts_types();
			} elseif ( strpos( $id, 'parent_cat' ) === 0 ) {
				$list = rosalinda_array_merge( array( 0 => esc_html__( '- Select category -', 'rosalinda' ) ), rosalinda_get_list_categories() );
			} elseif ( strpos( $id, 'blog_animation' ) === 0 ) {
				$list = rosalinda_get_list_animations_in();
			} elseif ( 'color_scheme_editor' == $id ) {
				$list = rosalinda_get_list_schemes();
			} elseif ( strpos( $id, '_font-family' ) > 0 ) {
				$list = rosalinda_get_list_load_fonts( true );
			}
		}
		return $list;
	}
}
