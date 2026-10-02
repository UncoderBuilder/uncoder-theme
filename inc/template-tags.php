<?php
/**
 * Template tags.
 *
 * @package Uncoder_Theme
 */

defined( 'ABSPATH' ) || exit;

/**
 * Logo or site title. The site title is the page's h1 on a front page that lists posts.
 */
function uncoder_theme_site_branding(): void {
	$is_front_blog = is_front_page() && is_home();
	$name          = get_bloginfo( 'name' );

	echo '<div class="site-branding">';
	if ( has_custom_logo() ) {
		the_custom_logo();
		if ( $is_front_blog ) {
			echo '<h1 class="site-title screen-reader-text">' . esc_html( $name ) . '</h1>';
		}
	} else {
		$tag = $is_front_blog ? 'h1' : 'p';
		printf(
			'<%1$s class="site-title"><a href="%2$s" rel="home">%3$s</a></%1$s>',
			tag_escape( $tag ),
			esc_url( home_url( '/' ) ),
			esc_html( $name )
		);
	}
	echo '</div>';
}

/**
 * Inline SVG icons used by the header (decorative: the buttons carry their own text).
 *
 * @param string $icon menu|close.
 */
function uncoder_theme_icon( string $icon ): string {
	$paths = array(
		'menu'  => 'M4 7h16M4 12h16M4 17h16',
		'close' => 'M6 6l12 12M18 6L6 18',
	);
	if ( ! isset( $paths[ $icon ] ) ) {
		return '';
	}
	return '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true" focusable="false"><path d="' . esc_attr( $paths[ $icon ] ) . '"/></svg>';
}

/**
 * Publication date, linked to the post (so posts without a title stay reachable).
 */
function uncoder_theme_posted_on(): void {
	printf(
		'<span class="posted-on"><a href="%1$s" rel="bookmark"><time class="entry-date published" datetime="%2$s">%3$s</time></a></span>',
		esc_url( get_permalink() ),
		esc_attr( get_the_date( DATE_W3C ) ),
		esc_html( get_the_date() )
	);
}

/**
 * Date and author of a post.
 */
function uncoder_theme_entry_meta(): void {
	uncoder_theme_posted_on();
	if ( '' === (string) get_the_author() ) {
		return;
	}
	printf(
		'<span class="byline">%s</span>',
		sprintf(
			/* translators: %s: post author name. */
			esc_html_x( 'by %s', 'post author', 'uncoder-theme' ),
			'<a class="url fn n" href="' . esc_url( get_author_posts_url( (int) get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a>'
		)
	);
}

/**
 * Categories, tags and the edit link, in a footer below the post content.
 */
function uncoder_theme_entry_footer(): void {
	$parts = array();
	if ( 'post' === get_post_type() ) {
		$separator  = wp_get_list_item_separator();
		$categories = get_the_category_list( $separator );
		if ( $categories ) {
			/* translators: %s: list of categories. */
			$parts[] = '<span class="cat-links">' . sprintf( esc_html__( 'Posted in %s', 'uncoder-theme' ), $categories ) . '</span>';
		}
		$tags = get_the_tag_list( '', $separator );
		if ( $tags && ! is_wp_error( $tags ) ) {
			/* translators: %s: list of tags. */
			$parts[] = '<span class="tags-links">' . sprintf( esc_html__( 'Tagged %s', 'uncoder-theme' ), $tags ) . '</span>';
		}
	}
	$edit = get_edit_post_link();
	if ( $edit ) {
		$parts[] = sprintf(
			'<a class="post-edit-link" href="%1$s">%2$s<span class="screen-reader-text"> %3$s</span></a>',
			esc_url( $edit ),
			esc_html__( 'Edit', 'uncoder-theme' ),
			esc_html( get_the_title() )
		);
	}
	if ( $parts ) {
		echo '<footer class="entry-footer ut-narrow">' . implode( '', $parts ) . '</footer>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- every part is escaped above; term lists come from core.
	}
}

/**
 * Featured image of a post or page that is not built with Uncoder.
 */
function uncoder_theme_post_thumbnail(): void {
	if ( ! has_post_thumbnail() || post_password_required() || is_attachment() ) {
		return;
	}
	echo '<figure class="post-thumbnail ut-wide">';
	the_post_thumbnail( 'full' );
	echo '</figure>';
}

/**
 * Numbered pagination for lists of posts.
 */
function uncoder_theme_pagination(): void {
	the_posts_pagination(
		array(
			'mid_size'  => 1,
			'prev_text' => esc_html__( 'Previous', 'uncoder-theme' ),
			'next_text' => esc_html__( 'Next', 'uncoder-theme' ),
		)
	);
}

/**
 * Links to the previous and next post.
 */
function uncoder_theme_post_navigation(): void {
	the_post_navigation(
		array(
			'prev_text' => '<span class="meta-nav">' . esc_html__( 'Previous', 'uncoder-theme' ) . '</span> <span class="post-title">%title</span>',
			'next_text' => '<span class="meta-nav">' . esc_html__( 'Next', 'uncoder-theme' ) . '</span> <span class="post-title">%title</span>',
		)
	);
}
