<?php
/**
 * Theme updates from GitHub releases (https://github.com/UncoderBuilder/uncoder-theme).
 *
 * The "Update URI: https://github.com/UncoderBuilder/uncoder-theme" header in style.css makes WordPress ask the
 * update_themes_github.com filter (and never WordPress.org) for a newer version. Only the zip attached to a release
 * of that repository is ever offered. Like any theme code, this runs while the theme is active.
 *
 * @package Uncoder_Theme
 */

defined( 'ABSPATH' ) || exit;

/**
 * The newest published release: version, package (zip URL) and page, or null. Cached for six hours (an error
 * for one hour, so a GitHub outage does not slow every admin page).
 *
 * @param bool $fresh Ask GitHub now instead of using the cache.
 * @return array{version: string, package: string, page: string}|null
 */
function uncoder_theme_latest_release( bool $fresh = false ): ?array {
	$repo   = 'UncoderBuilder/uncoder-theme';
	$cached = $fresh ? false : get_site_transient( 'uncoder_theme_release' );
	if ( is_array( $cached ) ) {
		return $cached['release'] ?? null;
	}
	$response = wp_safe_remote_get(
		'https://api.github.com/repos/' . $repo . '/releases/latest',
		array(
			'timeout' => 10,
			'headers' => array(
				'Accept'     => 'application/vnd.github+json',
				'User-Agent' => 'Uncoder-Theme/' . UNCODER_THEME_VERSION . '; ' . home_url( '/' ),
			),
		)
	);
	$data    = is_wp_error( $response ) ? null : json_decode( (string) wp_remote_retrieve_body( $response ), true );
	$release = null;
	if ( 200 === (int) wp_remote_retrieve_response_code( $response ) && is_array( $data ) ) {
		$version = ltrim( (string) ( $data['tag_name'] ?? '' ), 'vV' );
		foreach ( (array) ( $data['assets'] ?? array() ) as $asset ) {
			$url = (string) ( $asset['browser_download_url'] ?? '' );
			if ( preg_match( '/^\d+(\.\d+){1,3}$/', $version )
				&& preg_match( '/^uncoder-theme(-\d+(\.\d+){1,3})?\.zip$/', (string) ( $asset['name'] ?? '' ) )
				&& 'https' === wp_parse_url( $url, PHP_URL_SCHEME )
				&& 'github.com' === wp_parse_url( $url, PHP_URL_HOST )
				&& 0 === strpos( (string) wp_parse_url( $url, PHP_URL_PATH ), '/' . $repo . '/releases/download/' ) ) {
				$release = array(
					'version' => $version,
					'package' => $url,
					'page'    => esc_url_raw( (string) ( $data['html_url'] ?? 'https://github.com/' . $repo . '/releases' ) ),
				);
				break;
			}
		}
		set_site_transient( 'uncoder_theme_release', array( 'release' => $release ), 6 * HOUR_IN_SECONDS );
	} else {
		set_site_transient( 'uncoder_theme_release', array( 'release' => null ), HOUR_IN_SECONDS );
	}
	return $release;
}

/**
 * Offers the newest release as a theme update when it is newer than this version.
 *
 * @param array|false $update     Update data from an earlier filter, or false.
 * @param array       $theme_data Theme headers.
 * @param string      $stylesheet Theme folder name.
 * @return array|false
 */
function uncoder_theme_offer_update( $update, $theme_data, $stylesheet ) {
	$dir = get_template_directory();
	// A development copy (linked folder, Windows junction or git checkout) is never replaced: its real location
	// is not the theme's folder inside the (resolved) themes directory.
	$root     = realpath( get_theme_root() );
	$expected = strtolower( wp_normalize_path( ( false !== $root ? $root : get_theme_root() ) . '/' . get_template() ) );
	$dev      = strtolower( wp_normalize_path( (string) realpath( $dir ) ) ) !== $expected || file_exists( $dir . '/.git' );
	if ( get_template() !== $stylesheet || $dev ) {
		return $update;
	}
	$fresh   = is_admin() && ! empty( $_GET['force-check'] ); // phpcs:ignore WordPress.Security.NonceVerification.Recommended -- read-only refresh ("Check again").
	$release = uncoder_theme_latest_release( $fresh );
	if ( ! $release || ! version_compare( $release['version'], UNCODER_THEME_VERSION, '>' ) ) {
		return $update;
	}
	return array(
		'theme'        => $stylesheet,
		'version'      => $release['version'],
		'url'          => $release['page'],
		'package'      => $release['package'],
		'requires'     => '6.6',
		'requires_php' => '8.0',
	);
}
add_filter( 'update_themes_github.com', 'uncoder_theme_offer_update', 10, 3 );

/**
 * Clears the cached release after this theme was updated.
 *
 * @param object $upgrader Upgrader.
 * @param array  $options  Hook extra (type, themes).
 */
function uncoder_theme_forget_release( $upgrader, $options ): void {
	if ( 'theme' === ( $options['type'] ?? '' ) && in_array( get_template(), (array) ( $options['themes'] ?? array() ), true ) ) {
		delete_site_transient( 'uncoder_theme_release' );
	}
}
add_action( 'upgrader_process_complete', 'uncoder_theme_forget_release', 10, 2 );
