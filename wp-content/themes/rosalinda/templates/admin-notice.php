<?php
/**
 * The template to display Admin notices
 *
 * @package WordPress
 * @subpackage ROSALINDA
 * @since ROSALINDA 1.0.1
 */

$rosalinda_theme_obj = wp_get_theme();
?>
<div class="rosalinda_admin_notice rosalinda_welcome_notice update-nag">
	<?php
	// Theme image
	$rosalinda_theme_img = rosalinda_get_file_url( 'screenshot.jpg' );
	if ( '' != $rosalinda_theme_img ) {
		?>
		<div class="rosalinda_notice_image"><img src="<?php echo esc_url( $rosalinda_theme_img ); ?>" alt="<?php esc_attr_e( 'Theme screenshot', 'rosalinda' ); ?>"></div>
		<?php
	}

	// Title
	?>
	<h3 class="rosalinda_notice_title">
		<?php
		echo esc_html(
			sprintf(
				// Translators: Add theme name and version to the 'Welcome' message
				__( 'Welcome to %1$s v.%2$s', 'rosalinda' ),
				$rosalinda_theme_obj->name . ( ROSALINDA_THEME_FREE ? ' ' . esc_html__( 'Free', 'rosalinda' ) : '' ),
				$rosalinda_theme_obj->version
			)
		);
		?>
	</h3>
	<?php

	// Description
	?>
	<div class="rosalinda_notice_text">
		<p class="rosalinda_notice_text_description">
			<?php
			echo str_replace( '. ', '.<br>', wp_kses_data( $rosalinda_theme_obj->description ) );
			?>
		</p>
		<p class="rosalinda_notice_text_info">
			<?php
			echo wp_kses_data( __( 'Attention! Plugin "ThemeREX Addons" is required! Please, install and activate it!', 'rosalinda' ) );
			?>
		</p>
	</div>
	<?php

	// Buttons
	?>
	<div class="rosalinda_notice_buttons">
		<?php
		// Link to the page 'About Theme'
		?>
		<a href="<?php echo esc_url( admin_url() . 'themes.php?page=rosalinda_about' ); ?>" class="button button-primary"><i class="dashicons dashicons-nametag"></i> 
			<?php
			echo esc_html__( 'Install plugin "ThemeREX Addons"', 'rosalinda' );
			?>
		</a>
		<?php		
		// Dismiss this notice
		?>
		<a href="#" class="rosalinda_hide_notice"><i class="dashicons dashicons-dismiss"></i> <span class="rosalinda_hide_notice_text"><?php esc_html_e( 'Dismiss', 'rosalinda' ); ?></span></a>
	</div>
</div>
