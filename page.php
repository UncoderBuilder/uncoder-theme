<?php
/**
 * A page.
 *
 * Pages built with Uncoder get the full width, like the Uncoder Full Width template; the others get a reading
 * column. (The Uncoder Canvas and Uncoder Full Width page templates are printed by the plugin.)
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

		if ( comments_open() || get_comments_number() ) {
			comments_template();
		}
	endwhile;
	?>
</main>
<?php
get_footer();
