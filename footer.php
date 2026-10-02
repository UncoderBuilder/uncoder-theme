<?php
/**
 * Site footer and document end.
 *
 * When an Uncoder Theme Builder footer applies, Uncoder prints its own footer and the document end, and
 * loads this file only to discard it: nothing to do then.
 *
 * @package Uncoder_Theme
 */

defined( 'ABSPATH' ) || exit;

if ( uncoder_theme_has_location( 'footer' ) ) {
	return;
}
?>
<footer id="colophon" class="site-footer">
	<div class="site-footer__inner ut-wide">
		<p class="site-footer__copy">
			&copy; <?php echo esc_html( wp_date( 'Y' ) ); ?>
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php echo esc_html( get_bloginfo( 'name' ) ); ?></a>
		</p>
		<?php if ( has_nav_menu( 'footer' ) ) : ?>
			<nav class="footer-nav" aria-label="<?php esc_attr_e( 'Footer', 'uncoder-theme' ); ?>">
				<?php
				wp_nav_menu(
					array(
						'theme_location' => 'footer',
						'container'      => false,
						'menu_class'     => 'ut-menu',
						'depth'          => 1,
						'fallback_cb'    => false,
					)
				);
				?>
			</nav>
		<?php endif; ?>
	</div>
</footer>
<?php wp_footer(); ?>
</body>
</html>
