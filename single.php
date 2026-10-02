<?php
/**
 * A single post (or any custom post type without its own template).
 *
 * Posts built with Uncoder get the full width; the others get a reading column.
 *
 * @package Uncoder_Theme
 */

defined( 'ABSPATH' ) || exit;

get_header();

$uncoder_theme_builder = uncoder_theme_is_builder_content( get_queried_object_id() );
?>
<main id="content" class="site-main<?php echo $uncoder_theme_builder ? ' site-main--builder' : ''; ?>">
	<?php
	while ( have_posts() ) :
		the_post();
		get_template_part( 'template-parts/content', $uncoder_theme_builder ? 'builder' : 'singular' );

		if ( ! is_attachment() ) {
			uncoder_theme_post_navigation();
		}

		if ( comments_open() || get_comments_number() ) {
			comments_template();
		}
	endwhile;
	?>
</main>
<?php
get_footer();
