<?php
/**
 * Document head and site header.
 *
 * When an Uncoder Theme Builder header applies, Uncoder prints the head and its own header, and loads this
 * file only to discard it: nothing to do then. Nothing opened here is closed in footer.php, so the header
 * and the footer can each be replaced on their own.
 *
 * @package Uncoder_Theme
 */

defined( 'ABSPATH' ) || exit;

if ( uncoder_theme_has_location( 'header' ) ) {
	return;
}
?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<header id="masthead" class="site-header">
	<div class="site-header__inner ut-wide">
		<?php uncoder_theme_site_branding(); ?>
		<?php if ( has_nav_menu( 'primary' ) ) : ?>
			<nav class="site-nav" aria-label="<?php esc_attr_e( 'Primary', 'uncoder-theme' ); ?>">
				<button type="button" class="ut-nav-toggle" popovertarget="uncoder-theme-menu" aria-controls="uncoder-theme-menu">
					<?php echo uncoder_theme_icon( 'menu' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- static SVG. ?>
					<?php esc_html_e( 'Menu', 'uncoder-theme' ); ?>
				</button>
				<div id="uncoder-theme-menu" class="ut-nav-panel" popover>
					<button type="button" class="ut-nav-close" popovertarget="uncoder-theme-menu" popovertargetaction="hide">
						<?php echo uncoder_theme_icon( 'close' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- static SVG. ?>
						<span class="screen-reader-text"><?php esc_html_e( 'Close menu', 'uncoder-theme' ); ?></span>
					</button>
					<?php
					wp_nav_menu(
						array(
							'theme_location' => 'primary',
							'container'      => false,
							'menu_class'     => 'ut-menu',
							'depth'          => 2,
							'fallback_cb'    => false,
						)
					);
					?>
				</div>
			</nav>
		<?php endif; ?>
	</div>
</header>
