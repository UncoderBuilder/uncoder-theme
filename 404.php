<?php
/**
 * Page not found.
 *
 * @package Uncoder_Theme
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>
<main id="content" class="site-main">
	<section class="error-404 ut-narrow">
		<p class="error-404__code" aria-hidden="true">404</p>
		<h1 class="page-title"><?php esc_html_e( 'Page not found', 'uncoder-theme' ); ?></h1>
		<p><?php esc_html_e( 'The page you are looking for may have moved, or the address may be mistyped. Try a search, or go back to the home page.', 'uncoder-theme' ); ?></p>
		<?php get_search_form(); ?>
		<a class="ut-btn uncoder-btn" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Back to the home page', 'uncoder-theme' ); ?></a>
	</section>
</main>
<?php
get_footer();
