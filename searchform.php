<?php
/**
 * Search form.
 *
 * @package Uncoder_Theme
 */

defined( 'ABSPATH' ) || exit;

$uncoder_theme_field = wp_unique_id( 'search-field-' );
$uncoder_theme_label = isset( $args['aria_label'] ) && '' !== $args['aria_label'] ? (string) $args['aria_label'] : '';
?>
<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>"<?php echo '' !== $uncoder_theme_label ? ' aria-label="' . esc_attr( $uncoder_theme_label ) . '"' : ''; ?>>
	<label class="screen-reader-text" for="<?php echo esc_attr( $uncoder_theme_field ); ?>"><?php echo esc_html_x( 'Search for:', 'label', 'uncoder-theme' ); ?></label>
	<input type="search" id="<?php echo esc_attr( $uncoder_theme_field ); ?>" class="search-field" placeholder="<?php echo esc_attr_x( 'Search&hellip;', 'placeholder', 'uncoder-theme' ); ?>" value="<?php echo esc_attr( get_search_query( false ) ); ?>" name="s">
	<button type="submit" class="search-submit ut-btn uncoder-btn"><?php echo esc_html_x( 'Search', 'submit button', 'uncoder-theme' ); ?></button>
</form>
