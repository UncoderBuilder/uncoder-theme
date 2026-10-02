<?php
/**
 * A post in a list (blog, archives, search results).
 *
 * @package Uncoder_Theme
 */

defined( 'ABSPATH' ) || exit;
?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'ut-card' ); ?>>
	<?php if ( has_post_thumbnail() && ! post_password_required() ) : ?>
		<a class="ut-card__thumb" href="<?php the_permalink(); ?>" tabindex="-1" aria-hidden="true">
			<?php the_post_thumbnail( 'medium_large', array( 'alt' => '' ) ); ?>
		</a>
	<?php endif; ?>
	<div class="ut-card__body">
		<?php the_title( '<h2 class="ut-card__title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' ); ?>
		<?php if ( 'post' === get_post_type() ) : ?>
			<div class="ut-card__meta"><?php uncoder_theme_posted_on(); ?></div>
		<?php endif; ?>
		<div class="ut-card__excerpt"><?php the_excerpt(); ?></div>
	</div>
</article>
