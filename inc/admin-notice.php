<?php
/**
 * A small, dismissible notice on the Themes screen while the Uncoder builder plugin is not active.
 *
 * Shown only on Appearance > Themes, only to users who can install or activate it, and never again for a user
 * who dismissed it. Nothing is loaded from or sent to another site.
 *
 * @package Uncoder_Theme
 */

defined( 'ABSPATH' ) || exit;

/**
 * Plugin file of an installed (inactive) Uncoder plugin, or ''.
 */
function uncoder_theme_installed_plugin(): string {
	if ( ! function_exists( 'get_plugins' ) ) {
		require_once ABSPATH . 'wp-admin/includes/plugin.php';
	}
	foreach ( get_plugins() as $file => $data ) {
		if ( 'uncoder' === ( $data['TextDomain'] ?? '' ) ) {
			return (string) $file;
		}
	}
	return '';
}

/**
 * Prints the notice.
 */
function uncoder_theme_plugin_notice(): void {
	$screen = get_current_screen();
	if ( ! $screen || 'themes' !== $screen->id || uncoder_theme_plugin_active() ) {
		return;
	}
	if ( get_user_meta( get_current_user_id(), 'uncoder_theme_notice_dismissed', true ) ) {
		return;
	}

	$plugin = uncoder_theme_installed_plugin();
	if ( '' !== $plugin && current_user_can( 'activate_plugin', $plugin ) ) {
		$url  = wp_nonce_url( self_admin_url( 'plugins.php?action=activate&plugin=' . rawurlencode( $plugin ) ), 'activate-plugin_' . $plugin );
		$link = __( 'Activate Uncoder', 'uncoder-theme' );
	} elseif ( '' === $plugin && current_user_can( 'install_plugins' ) ) {
		$url  = 'https://uncoderbuilder.com/download/';
		$link = __( 'Get Uncoder', 'uncoder-theme' );
	} else {
		return;
	}
	?>
	<div id="uncoder-theme-notice" class="notice notice-info is-dismissible">
		<p>
			<?php esc_html_e( 'The Uncoder theme is made for the Uncoder visual website builder: design pages, headers and footers visually and keep the whole site on one Design System.', 'uncoder-theme' ); ?>
			<a href="<?php echo esc_url( $url ); ?>"><?php echo esc_html( $link ); ?></a>
		</p>
	</div>
	<?php
	wp_print_inline_script_tag(
		sprintf(
			'document.addEventListener("click",function(e){if(!e.target.closest||!e.target.closest("#uncoder-theme-notice .notice-dismiss")){return;}var d=new FormData();d.append("action","uncoder_theme_dismiss_notice");d.append("nonce",%1$s);fetch(%2$s,{method:"POST",credentials:"same-origin",body:d});});',
			wp_json_encode( wp_create_nonce( 'uncoder_theme_dismiss_notice' ) ),
			wp_json_encode( admin_url( 'admin-ajax.php' ) )
		)
	);
}
add_action( 'admin_notices', 'uncoder_theme_plugin_notice' );

/**
 * Remembers that the current user dismissed the notice.
 */
function uncoder_theme_dismiss_notice(): void {
	check_ajax_referer( 'uncoder_theme_dismiss_notice', 'nonce' );
	update_user_meta( get_current_user_id(), 'uncoder_theme_notice_dismissed', 1 );
	wp_send_json_success();
}
add_action( 'wp_ajax_uncoder_theme_dismiss_notice', 'uncoder_theme_dismiss_notice' );
