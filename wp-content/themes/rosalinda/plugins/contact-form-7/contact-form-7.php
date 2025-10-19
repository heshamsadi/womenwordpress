<?php
/* Contact Form 7 support functions
------------------------------------------------------------------------------- */

// Theme init priorities:
// 9 - register other filters (for installer, etc.)
if ( ! function_exists( 'rosalinda_cf7_theme_setup9' ) ) {
	add_action( 'after_setup_theme', 'rosalinda_cf7_theme_setup9', 9 );
	function rosalinda_cf7_theme_setup9() {

		add_filter( 'rosalinda_filter_merge_scripts', 'rosalinda_cf7_merge_scripts' );
		add_filter( 'rosalinda_filter_merge_styles', 'rosalinda_cf7_merge_styles' );

		if ( rosalinda_exists_cf7() ) {
			add_action( 'wp_enqueue_scripts', 'rosalinda_cf7_frontend_scripts', 1100 );
		}

		if ( is_admin() ) {
			add_filter( 'rosalinda_filter_tgmpa_required_plugins', 'rosalinda_cf7_tgmpa_required_plugins' );
		}
	}
}

// Filter to add in the required plugins list
if ( ! function_exists( 'rosalinda_cf7_tgmpa_required_plugins' ) ) {
	
	function rosalinda_cf7_tgmpa_required_plugins( $list = array() ) {
		if ( rosalinda_storage_isset( 'required_plugins', 'contact-form-7' ) ) {
			// CF7 plugin
			$list[] = array(
				'name'     => rosalinda_storage_get_array( 'required_plugins', 'contact-form-7' ),
				'slug'     => 'contact-form-7',
				'required' => false,
			);
		}
		return $list;
	}
}

// Check if cf7 installed and activated
if ( ! function_exists( 'rosalinda_exists_cf7' ) ) {
	function rosalinda_exists_cf7() {
		return class_exists( 'WPCF7' );
	}
}

// Enqueue custom scripts
if ( ! function_exists( 'rosalinda_cf7_frontend_scripts' ) ) {
	
	function rosalinda_cf7_frontend_scripts() {
		if ( rosalinda_exists_cf7() ) {
			if ( rosalinda_is_on( rosalinda_get_theme_option( 'debug_mode' ) ) ) {
				$rosalinda_url = rosalinda_get_file_url( 'plugins/contact-form-7/contact-form-7.js' );
				if ( '' != $rosalinda_url ) {
					wp_enqueue_script( 'rosalinda-cf7', $rosalinda_url, array( 'jquery' ), null, true );
				}
			}
		}
	}
}

// Merge custom scripts
if ( ! function_exists( 'rosalinda_cf7_merge_scripts' ) ) {
	
	function rosalinda_cf7_merge_scripts( $list ) {
		if ( rosalinda_exists_cf7() ) {
			$list[] = 'plugins/contact-form-7/contact-form-7.js';
		}
		return $list;
	}
}

// Merge custom styles
if ( ! function_exists( 'rosalinda_cf7_merge_styles' ) ) {
	
	function rosalinda_cf7_merge_styles( $list ) {
		if ( rosalinda_exists_cf7() ) {
			$list[] = 'plugins/contact-form-7/_contact-form-7.scss';
		}
		return $list;
	}
}

