<?php
/* Essential Grid support functions
------------------------------------------------------------------------------- */


// Theme init priorities:
// 9 - register other filters (for installer, etc.)
if ( ! function_exists( 'rosalinda_essential_grid_theme_setup9' ) ) {
	add_action( 'after_setup_theme', 'rosalinda_essential_grid_theme_setup9', 9 );
	function rosalinda_essential_grid_theme_setup9() {

		add_filter( 'rosalinda_filter_merge_styles', 'rosalinda_essential_grid_merge_styles' );

		if ( is_admin() ) {
			add_filter( 'rosalinda_filter_tgmpa_required_plugins', 'rosalinda_essential_grid_tgmpa_required_plugins' );
		}
	}
}

// Filter to add in the required plugins list
if ( ! function_exists( 'rosalinda_essential_grid_tgmpa_required_plugins' ) ) {
	
	function rosalinda_essential_grid_tgmpa_required_plugins( $list = array() ) {
		if ( rosalinda_storage_isset( 'required_plugins', 'essential-grid' ) && rosalinda_is_theme_activated() ) {
			$path = rosalinda_get_plugin_source_path( 'plugins/essential-grid/essential-grid.zip' );
			if ( ! empty( $path ) || rosalinda_get_theme_setting( 'tgmpa_upload' ) ) {
				$list[] = array(
					'name'     => rosalinda_storage_get_array( 'required_plugins', 'essential-grid' ),
					'slug'     => 'essential-grid',
					'source'   => ! empty( $path ) ? $path : 'upload://essential-grid.zip',
					'required' => false,
				);
			}
		}
		return $list;
	}
}

// Check if plugin installed and activated
if ( ! function_exists( 'rosalinda_exists_essential_grid' ) ) {
	function rosalinda_exists_essential_grid() {
		return defined('EG_PLUGIN_PATH') || defined( 'ESG_PLUGIN_PATH' );
	}
}

// Merge custom styles
if ( ! function_exists( 'rosalinda_essential_grid_merge_styles' ) ) {
	
	function rosalinda_essential_grid_merge_styles( $list ) {
		if ( rosalinda_exists_essential_grid() ) {
			$list[] = 'plugins/essential-grid/_essential-grid.scss';
		}
		return $list;
	}
}

