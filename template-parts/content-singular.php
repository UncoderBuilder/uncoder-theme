<?php
/**
 * A post or page that is not built with Uncoder: title, meta, featured image and a reading column.
 *
 * @package Uncoder_Theme
 */

defined( 'ABSPATH' ) || exit;
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header ut-narrow">
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
		<?php if ( 'post' === get_post_type() ) : ?>
			<div class="entry-meta"><?php uncoder_theme_entry_meta(); ?></div>
		<?php endif; ?>
	</header>

	<?php uncoder_theme_post_thumbnail(); ?>

	<div class="entry-content">
		<?php
		the_content();
		wp_link_pages(
			array(
				'before' => '<nav class="page-links" aria-label="' . esc_attr__( 'Page', 'uncoder-theme' ) . '">',
				'after'  => '</nav>',
			)
		);
		?>
	</div>

	<?php uncoder_theme_entry_footer(); ?>
</article>
