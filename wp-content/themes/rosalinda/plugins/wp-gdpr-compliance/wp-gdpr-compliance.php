<?php
/* Cookie Information support functions
------------------------------------------------------------------------------- */

// Theme init priorities:
// 9 - register other filters (for installer, etc.)
if ( ! function_exists( 'rosalinda_wp_gdpr_compliance_feed_theme_setup9' ) ) {
	add_action( 'after_setup_theme', 'rosalinda_wp_gdpr_compliance_theme_setup9', 9 );
	function rosalinda_wp_gdpr_compliance_theme_setup9() {
		if ( is_admin() ) {
			add_filter( 'rosalinda_filter_tgmpa_required_plugins', 'rosalinda_wp_gdpr_compliance_tgmpa_required_plugins' );
		}
	}
}

// Filter to add in the required plugins list
if ( ! function_exists( 'rosalinda_wp_gdpr_compliance_tgmpa_required_plugins' ) ) {
	
	function rosalinda_wp_gdpr_compliance_tgmpa_required_plugins( $list = array() ) {
		if ( rosalinda_storage_isset( 'required_plugins', 'wp-gdpr-compliance' ) ) {
			$list[] = array(
				'name'     => rosalinda_storage_get_array( 'required_plugins', 'wp-gdpr-compliance' ),
				'slug'     => 'wp-gdpr-compliance',
				'required' => false,
			);
		}
		return $list;
	}
}

// Check if this plugin installed and activated
if ( ! function_exists( 'rosalinda_exists_wp_gdpr_compliance' ) ) {
	function rosalinda_exists_wp_gdpr_compliance() {
		return defined( 'WP_GDPR_C_ROOT_FILE' ) || defined( 'WPGDPRC_ROOT_FILE' );
	}
}
