<?php
/**
 * Integration with the Uncoder builder plugin.
 *
 * How the plugin and this theme share the page (classic theme):
 * - Header and footer: when a Theme Builder header (or footer) template applies, Uncoder hooks get_header()
 *   (get_footer()), prints the document head and its own header itself, then loads the theme's header.php
 *   (footer.php) once into a discarded buffer. header.php and footer.php therefore return early in that case,
 *   and never open an element that the other one closes: either can be replaced on its own.
 * - Body templates (single, archive, search results, 404) and the Uncoder Canvas / Full Width page templates
 *   are swapped in by Uncoder through template_include; they call get_header() and get_footer() and print
 *   <main id="content">, like this theme's templates.
 * - Content built with Uncoder replaces the_content(); the theme gives it the full width (no column, no padding).
 *
 * Every check below fails safe when the plugin is inactive or changes: the theme then simply prints its own parts.
 *
 * @package Uncoder_Theme
 */

defined( 'ABSPATH' ) || exit;

/**
 * Whether the Uncoder builder plugin is active.
 */
function uncoder_theme_plugin_active(): bool {
	return class_exists( '\Uncoder\Builder\Plugin' );
}

/**
 * Whether an Uncoder Theme Builder template replaces a theme location on this request.
 *
 * @param string $location header|footer.
 */
function uncoder_theme_has_location( string $location ): bool {
	$active = false;
	if ( class_exists( '\Uncoder\Builder\Theme\Theme_Builder' ) && method_exists( '\Uncoder\Builder\Theme\Theme_Builder', 'instance' ) ) {
		$builder = \Uncoder\Builder\Theme\Theme_Builder::instance();
		$active  = $builder && method_exists( $builder, 'resolve' ) && $builder->resolve( $location ) > 0;
	}
	/**
	 * Filters whether an Uncoder template prints a location instead of the theme.
	 *
	 * @param bool   $active   Whether Uncoder prints it.
	 * @param string $location header|footer.
	 */
	return (bool) apply_filters( 'uncoder_theme_has_location', $active, $location );
}

/**
 * Whether a post's content is built with Uncoder (and is shown: not behind a password form).
 *
 * @param int|WP_Post|null $post Post (default: the current post).
 */
function uncoder_theme_is_builder_content( $post = null ): bool {
	$post   = get_post( $post );
	$is_ucd = false;
	if ( $post && class_exists( '\Uncoder\Builder\Core\Utils' ) && method_exists( '\Uncoder\Builder\Core\Utils', 'is_builder_post' ) ) {
		$is_ucd = \Uncoder\Builder\Core\Utils::is_builder_post( (int) $post->ID ) && ! post_password_required( $post );
	}
	/**
	 * Filters whether the theme shows a post as an Uncoder page (full width, no reading column).
	 *
	 * @param bool    $is_ucd Built with Uncoder.
	 * @param WP_Post $post   Post.
	 */
	return (bool) apply_filters( 'uncoder_theme_is_builder_content', $is_ucd, $post );
}

/**
 * Adds a body class on singular views built with Uncoder (the plugin adds `uncoder-page` too).
 *
 * @param string[] $classes Body classes.
 * @return string[]
 */
function uncoder_theme_body_class( $classes ): array {
	$classes = (array) $classes;
	if ( is_singular() && uncoder_theme_is_builder_content( get_queried_object_id() ) ) {
		$classes[] = 'uncoder-theme-builder-page';
	}
	return $classes;
}
add_filter( 'body_class', 'uncoder_theme_body_class' );
