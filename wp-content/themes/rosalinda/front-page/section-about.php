<div class="front_page_section front_page_section_about<?php
	$rosalinda_scheme = rosalinda_get_theme_option( 'front_page_about_scheme' );
	if ( ! rosalinda_is_inherit( $rosalinda_scheme ) ) {
		echo ' scheme_' . esc_attr( $rosalinda_scheme );
	}
	echo ' front_page_section_paddings_' . esc_attr( rosalinda_get_theme_option( 'front_page_about_paddings' ) );
?>"
		<?php
		$rosalinda_css      = '';
		$rosalinda_bg_image = rosalinda_get_theme_option( 'front_page_about_bg_image' );
		if ( ! empty( $rosalinda_bg_image ) ) {
			$rosalinda_css .= 'background-image: url(' . esc_url( rosalinda_get_attachment_url( $rosalinda_bg_image ) ) . ');';
		}
		if ( ! empty( $rosalinda_css ) ) {
			echo ' style="' . esc_attr( $rosalinda_css ) . '"';
		}
		?>
>
<?php
	// Add anchor
	$rosalinda_anchor_icon = rosalinda_get_theme_option( 'front_page_about_anchor_icon' );
	$rosalinda_anchor_text = rosalinda_get_theme_option( 'front_page_about_anchor_text' );
if ( ( ! empty( $rosalinda_anchor_icon ) || ! empty( $rosalinda_anchor_text ) ) && shortcode_exists( 'trx_sc_anchor' ) ) {
	echo do_shortcode(
		'[trx_sc_anchor id="front_page_section_about"'
									. ( ! empty( $rosalinda_anchor_icon ) ? ' icon="' . esc_attr( $rosalinda_anchor_icon ) . '"' : '' )
									. ( ! empty( $rosalinda_anchor_text ) ? ' title="' . esc_attr( $rosalinda_anchor_text ) . '"' : '' )
									. ']'
	);
}
?>
	<div class="front_page_section_inner front_page_section_about_inner
	<?php
	if ( rosalinda_get_theme_option( 'front_page_about_fullheight' ) ) {
		echo ' rosalinda-full-height sc_layouts_flex sc_layouts_columns_middle';
	}
	?>
			"
			<?php
			$rosalinda_css           = '';
			$rosalinda_bg_mask       = rosalinda_get_theme_option( 'front_page_about_bg_mask' );
			$rosalinda_bg_color_type = rosalinda_get_theme_option( 'front_page_about_bg_color_type' );
			if ( 'custom' == $rosalinda_bg_color_type ) {
				$rosalinda_bg_color = rosalinda_get_theme_option( 'front_page_about_bg_color' );
			} elseif ( 'scheme_bg_color' == $rosalinda_bg_color_type ) {
				$rosalinda_bg_color = rosalinda_get_scheme_color( 'bg_color', $rosalinda_scheme );
			} else {
				$rosalinda_bg_color = '';
			}
			if ( ! empty( $rosalinda_bg_color ) && $rosalinda_bg_mask > 0 ) {
				$rosalinda_css .= 'background-color: ' . esc_attr(
					1 == $rosalinda_bg_mask ? $rosalinda_bg_color : rosalinda_hex2rgba( $rosalinda_bg_color, $rosalinda_bg_mask )
				) . ';';
			}
			if ( ! empty( $rosalinda_css ) ) {
				echo ' style="' . esc_attr( $rosalinda_css ) . '"';
			}
			?>
	>
		<div class="front_page_section_content_wrap front_page_section_about_content_wrap content_wrap">
			<?php
			// Caption
			$rosalinda_caption = rosalinda_get_theme_option( 'front_page_about_caption' );
			if ( ! empty( $rosalinda_caption ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
				?>
				<h2 class="front_page_section_caption front_page_section_about_caption front_page_block_<?php echo ! empty( $rosalinda_caption ) ? 'filled' : 'empty'; ?>"><?php echo wp_kses( $rosalinda_caption, 'rosalinda_kses_content' ); ?></h2>
				<?php
			}

			// Description (text)
			$rosalinda_description = rosalinda_get_theme_option( 'front_page_about_description' );
			if ( ! empty( $rosalinda_description ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
				?>
				<div class="front_page_section_description front_page_section_about_description front_page_block_<?php echo ! empty( $rosalinda_description ) ? 'filled' : 'empty'; ?>"><?php echo wp_kses( wpautop( $rosalinda_description ), 'rosalinda_kses_content' ); ?></div>
				<?php
			}

			// Content
			$rosalinda_content = rosalinda_get_theme_option( 'front_page_about_content' );
			if ( ! empty( $rosalinda_content ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
				?>
				<div class="front_page_section_content front_page_section_about_content front_page_block_<?php echo ! empty( $rosalinda_content ) ? 'filled' : 'empty'; ?>">
				<?php
					$rosalinda_page_content_mask = '%%CONTENT%%';
				if ( strpos( $rosalinda_content, $rosalinda_page_content_mask ) !== false ) {
					$rosalinda_content = preg_replace(
						'/(\<p\>\s*)?' . $rosalinda_page_content_mask . '(\s*\<\/p\>)/i',
						sprintf(
							'<div class="front_page_section_about_source">%s</div>',
							apply_filters( 'the_content', get_the_content() )
						),
						$rosalinda_content
					);
				}
					rosalinda_show_layout( $rosalinda_content );
				?>
				</div>
				<?php
			}
			?>
		</div>
	</div>
</div>
