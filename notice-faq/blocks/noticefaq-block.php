<?php
/**
 * Registers Notice block utilities
 *
 * @package Notice_Block
 */

/**
 * Register block editor assets
 */
function notice_enqueue_block_editor_assets() {
	$dir        = dirname( __FILE__ );
	$block_js   = 'notice/index.js';
	$editor_css = 'notice/editor.css';
	wp_enqueue_script(
		'notice-blocksr', plugins_url( $block_js, __FILE__ ), array(
			'wp-blocks',
			'wp-i18n',
			'wp-element',
		), filemtime( "$dir/$block_js" )
	);
	wp_enqueue_style(
		'notice-blocksy', plugins_url( $editor_css, __FILE__ ), array(
			'wp-blocks',
		), filemtime( "$dir/$editor_css" )
	);
}
add_action( 'enqueue_block_editor_assets', 'notice_enqueue_block_editor_assets' );
