<?php
/**
 * A post or page built with Uncoder: the content runs edge to edge, without theme padding or a column.
 *
 * The title is shown above the content unless "Hide page title" is on in the Uncoder page settings
 * (the plugin then empties it).
 *
 * @package Uncoder_Theme
 */

defined( 'ABSPATH' ) || exit;
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php if ( '' !== trim( get_the_title() ) ) : ?>
		<header class="entry-header entry-header--builder ut-wide">
			<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
		</header>
	<?php endif; ?>
	<?php the_content(); ?>
</article>
