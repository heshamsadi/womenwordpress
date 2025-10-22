<?php
/**
 * Small icon helper for the child theme. Prefer parent helpers when available.
 */
defined('ABSPATH') || exit;

if (!function_exists('child_icon')) {
    function child_icon($name, $echo = true) {
        // Prefer TRX Addons / parent helpers if they exist
        $preferred = array(
            'trx_addons_get_svg_icon',
            'the_trx_addons_icon',
            'trx_addons_get_icon',
            'get_theme_svg',
            'the_theme_svg',
            'rosalinda_get_svg',
            'rosalinda_get_icon',
        );
        foreach ($preferred as $fn) {
            if (function_exists($fn)) {
                // Some helpers echo directly, others return markup
                if (in_array($fn, array('the_trx_addons_icon', 'the_theme_svg'))) {
                    // functions that echo
                    $fn($name);
                    return;
                }
                $out = $fn($name);
                if (!empty($out)) {
                    if ($echo) {
                        echo $out;
                        return;
                    }
                    return $out;
                }
            }
        }

        // Fallback inline SVGs (minimal, accessible)
        $svgs = array(
            'clock' => '<svg class="icon icon-clock" aria-hidden="true" width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="2"/><path d="M12 7v6l4 2" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>',
            'servings' => '<svg class="icon icon-servings" aria-hidden="true" width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M4 6h16M4 12h16M4 18h16" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>',
            'fire' => '<svg class="icon icon-fire" aria-hidden="true" width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12 3s4 4 4 8a4 4 0 0 1-8 0c0-4 4-8 4-8z" stroke="currentColor" stroke-width="2" fill="currentColor"/></svg>',
            'pan' => '<svg class="icon icon-pan" aria-hidden="true" width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><rect x="3" y="7" width="14" height="8" rx="2" stroke="currentColor" stroke-width="2"/><path d="M21 8v2" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>',
        );

        $out = isset($svgs[$name]) ? $svgs[$name] : '';
        if ($out) {
            if ($echo) echo $out;
            return $out;
        }

        // Final fallback to parent icon font/class if available
        $class = 'sc_icon icon-' . esc_attr($name);
        $html = '<span class="' . $class . '"></span>';
        if ($echo) echo $html;
        return $html;
    }
}
