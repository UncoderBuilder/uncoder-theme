<?php
/**
 * Nothing to list.
 *
 * @package Uncoder_Theme
 */

defined( 'ABSPATH' ) || exit;

// The blog page already has its title as the h1.
$uncoder_theme_tag = is_home() && ! is_front_page() ? 'h2' : 'h1';
?>
<section class="no-results ut-narrow">
	<<?php echo tag_escape( $uncoder_theme_tag ); ?> class="page-title"><?php esc_html_e( 'Nothing found', 'uncoder-theme' ); ?></<?php echo tag_escape( $uncoder_theme_tag ); ?>>
	<?php if ( is_home() && current_user_can( 'publish_posts' ) ) : ?>
		<p>
			<?php
			printf(
				/* translators: %s: link to the new post screen. */
				esc_html__( 'Ready to publish your first post? %s', 'uncoder-theme' ),
				'<a href="' . esc_url( admin_url( 'post-new.php' ) ) . '">' . esc_html__( 'Get started here', 'uncoder-theme' ) . '</a>'
			);
			?>
		</p>
	<?php elseif ( is_search() ) : ?>
		<p><?php esc_html_e( 'Nothing matched your search. Try other keywords.', 'uncoder-theme' ); ?></p>
		<?php get_search_form(); ?>
	<?php else : ?>
		<p><?php esc_html_e( 'There is nothing here yet. A search may help.', 'uncoder-theme' ); ?></p>
		<?php get_search_form(); ?>
	<?php endif; ?>
</section>
