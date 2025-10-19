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
<div class="rosalinda_admin_notice rosalinda_rate_notice update-nag">
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
	<h3 class="rosalinda_notice_title"><a href="<?php echo esc_url( rosalinda_storage_get( 'theme_download_url' ) ); ?>" target="_blank">
		<?php
		echo esc_html(
			sprintf(
				// Translators: Add theme name and version to the 'Welcome' message
				esc_html__( 'Rate our theme "%s", please', 'rosalinda' ),
				$rosalinda_theme_obj->name . ( ROSALINDA_THEME_FREE ? ' ' . esc_html__( 'Free', 'rosalinda' ) : '' )
			)
		);
		?>
	</a></h3>
	<?php

	// Description
	?>
	<div class="rosalinda_notice_text">
		<p><?php echo wp_kses_data( __( 'We are glad you chose our WP theme for your website. You’ve done well customizing your website and we hope that you’ve enjoyed working with our theme.', 'rosalinda' ) ); ?></p>
		<p><?php echo wp_kses_data( __( 'It would be just awesome if you spend just a minute of your time to rate our theme or the customer service you’ve received from us.', 'rosalinda' ) ); ?></p>
		<p class="rosalinda_notice_text_info"><?php echo wp_kses_data( __( '* We love receiving your reviews! Every time you leave a review, our CEO Henry Rise gives $5 to homeless dog shelter! Save the planet with us!', 'rosalinda' ) ); ?></p>
	</div>
	<?php

	// Buttons
	?>
	<div class="rosalinda_notice_buttons">
		<?php
		// Link to the theme download page
		?>
		<a href="<?php echo esc_url( rosalinda_storage_get( 'theme_download_url' ) ); ?>" class="button button-primary" target="_blank"><i class="dashicons dashicons-star-filled"></i> 
			<?php
			// Translators: Add theme name
			echo esc_html( sprintf( __( 'Rate theme %s', 'rosalinda' ), $rosalinda_theme_obj->name ) );
			?>
		</a>
		<?php
		// Link to the theme support
		?>
		<a href="<?php echo esc_url( rosalinda_storage_get( 'theme_support_url' ) ); ?>" class="button" target="_blank"><i class="dashicons dashicons-sos"></i> 
			<?php
			esc_html_e( 'Support', 'rosalinda' );
			?>
		</a>
		<?php
		// Link to the theme documentation
		?>
		<a href="<?php echo esc_url( rosalinda_storage_get( 'theme_doc_url' ) ); ?>" class="button" target="_blank"><i class="dashicons dashicons-book"></i> 
			<?php
			esc_html_e( 'Documentation', 'rosalinda' );
			?>
		</a>
		<?php
		// Dismiss
		?>
		<a href="#" class="rosalinda_hide_notice"><i class="dashicons dashicons-dismiss"></i> <span class="rosalinda_hide_notice_text"><?php esc_html_e( 'Dismiss', 'rosalinda' ); ?></span></a>
	</div>
</div>
