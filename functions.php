<?php
/**
 * Uncoder theme: setup, assets and the integration with the Uncoder builder plugin.
 *
 * @package Uncoder_Theme
 */

defined( 'ABSPATH' ) || exit;

define( 'UNCODER_THEME_VERSION', '1.0.0' );

require get_template_directory() . '/inc/uncoder.php';
require get_template_directory() . '/inc/template-tags.php';

if ( is_admin() ) {
	require get_template_directory() . '/inc/admin-notice.php';
}

/**
 * Width of the reading column, for embeds and images inserted in the classic editor.
 */
function uncoder_theme_content_width(): void {
	$GLOBALS['content_width'] = (int) apply_filters( 'uncoder_theme_content_width', 720 );
}
add_action( 'after_setup_theme', 'uncoder_theme_content_width', 0 );

/**
 * Theme supports, menus and editor styles.
 */
function uncoder_theme_setup(): void {
	load_theme_textdomain( 'uncoder-theme', get_template_directory() . '/languages' );

	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script', 'navigation-widgets' ) );
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 96,
			'width'       => 320,
			'flex-height' => true,
			'flex-width'  => true,
		)
	);
	add_theme_support( 'align-wide' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'wp-block-styles' );
	add_theme_support( 'editor-styles' );
	add_editor_style( 'assets/css/editor-style.css' );

	// WooCommerce renders inside woocommerce.php.
	add_theme_support( 'woocommerce' );
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );

	register_nav_menus(
		array(
			'primary' => esc_html__( 'Primary menu', 'uncoder-theme' ),
			'footer'  => esc_html__( 'Footer menu', 'uncoder-theme' ),
		)
	);
}
add_action( 'after_setup_theme', 'uncoder_theme_setup' );

/**
 * Front-end styles. The minified build of style.css, or style.css itself with SCRIPT_DEBUG.
 */
function uncoder_theme_enqueue(): void {
	$file = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? 'style.css' : 'assets/css/theme.min.css';
	wp_enqueue_style( 'uncoder-theme', get_template_directory_uri() . '/' . $file, array(), UNCODER_THEME_VERSION );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'uncoder_theme_enqueue' );

/**
 * Skip link, printed from wp_body_open so it is there with the theme header and with an Uncoder header.
 */
function uncoder_theme_skip_link(): void {
	// The Uncoder Canvas template and Theme Builder template previews have no #content.
	if ( is_page_template( 'uncoder-canvas' ) || is_singular( 'uncoder_template' ) ) {
		return;
	}
	printf(
		'<a class="skip-link screen-reader-text" href="#content">%s</a>',
		esc_html__( 'Skip to content', 'uncoder-theme' )
	);
}
add_action( 'wp_body_open', 'uncoder_theme_skip_link', 5 );

/**
 * Shorter excerpts with an ellipsis for the post cards.
 *
 * @param int $length Number of words.
 */
function uncoder_theme_excerpt_length( $length ): int {
	return is_admin() ? (int) $length : 28;
}
add_filter( 'excerpt_length', 'uncoder_theme_excerpt_length' );

/**
 * Replaces the "[…]" after excerpts.
 */
function uncoder_theme_excerpt_more(): string {
	return '&hellip;';
}
add_filter( 'excerpt_more', 'uncoder_theme_excerpt_more' );
