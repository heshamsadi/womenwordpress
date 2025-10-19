<?php
/* ThemeREX Updater support functions
------------------------------------------------------------------------------- */


// Theme init priorities:
// 9 - register other filters (for installer, etc.)
if ( ! function_exists( 'rosalinda_trx_socials_theme_setup9' ) ) {
	add_action( 'after_setup_theme', 'rosalinda_trx_socials_theme_setup9', 9 );
	function rosalinda_trx_socials_theme_setup9() {

		if ( is_admin() ) {
			add_filter( 'rosalinda_filter_tgmpa_required_plugins', 'rosalinda_trx_socials_tgmpa_required_plugins' );
		}
	}
}

// Filter to add in the required plugins list
if ( ! function_exists( 'rosalinda_trx_socials_tgmpa_required_plugins' ) ) {
	function rosalinda_trx_socials_tgmpa_required_plugins( $list = array() ) {
		if ( rosalinda_storage_isset( 'required_plugins', 'trx_socials' ) && rosalinda_is_theme_activated() ) {
			$path = rosalinda_get_plugin_source_path( 'plugins/trx_socials/trx_socials.zip' );
			if ( ! empty( $path ) || rosalinda_get_theme_setting( 'tgmpa_upload' ) ) {
				$list[] = array(
					'name'     => rosalinda_storage_get_array( 'required_plugins', 'trx_socials' ),
					'slug'     => 'trx_socials',
					'source'   => ! empty( $path ) ? $path : 'upload://trx_socials.zip',
					'required' => false,
				);
			}
		}
		return $list;
	}
}

// Check if plugin installed and activated
if ( ! function_exists( 'rosalinda_exists_trx_socials' ) ) {
	function rosalinda_exists_trx_socials() {
		return defined('TRX_SOCIALS_STORAGE');
	}
}