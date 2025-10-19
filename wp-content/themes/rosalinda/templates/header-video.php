<?php
/**
 * The template to display the background video in the header
 *
 * @package WordPress
 * @subpackage ROSALINDA
 * @since ROSALINDA 1.0.14
 */
$rosalinda_header_video = rosalinda_get_header_video();
$rosalinda_embed_video  = '';
if ( ! empty( $rosalinda_header_video ) && ! rosalinda_is_from_uploads( $rosalinda_header_video ) ) {
	if ( rosalinda_is_youtube_url( $rosalinda_header_video ) && preg_match( '/[=\/]([^=\/]*)$/', $rosalinda_header_video, $matches ) && ! empty( $matches[1] ) ) {
		?><div id="background_video" data-youtube-code="<?php echo esc_attr( $matches[1] ); ?>"></div>
		<?php
	} else {
		global $wp_embed;
		if ( false && is_object( $wp_embed ) ) {
			$rosalinda_embed_video = do_shortcode( $wp_embed->run_shortcode( '[embed]' . trim( $rosalinda_header_video ) . '[/embed]' ) );
			$rosalinda_embed_video = rosalinda_make_video_autoplay( $rosalinda_embed_video );
		} else {
			$rosalinda_header_video = str_replace( '/watch?v=', '/embed/', $rosalinda_header_video );
			$rosalinda_header_video = rosalinda_add_to_url(
				$rosalinda_header_video, array(
					'feature'        => 'oembed',
					'controls'       => 0,
					'autoplay'       => 1,
					'showinfo'       => 0,
					'modestbranding' => 1,
					'wmode'          => 'transparent',
					'enablejsapi'    => 1,
					'origin'         => home_url(),
					'widgetid'       => 1,
				)
			);
			$rosalinda_embed_video  = '<iframe src="' . esc_url( $rosalinda_header_video ) . '" width="1170" height="658" allowfullscreen="0" frameborder="0"></iframe>';
		}
		?>
		<div id="background_video"><?php rosalinda_show_layout( $rosalinda_embed_video ); ?></div>
		<?php
	}
}
