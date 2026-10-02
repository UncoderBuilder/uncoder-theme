<?php
/**
 * The main template: the blog and the fallback for every other view.
 *
 * @package Uncoder_Theme
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>
<main id="content" class="site-main">
	<div class="ut-wide">
		<?php if ( is_home() && ! is_front_page() && single_post_title( '', false ) ) : ?>
			<header class="page-header">
				<h1 class="page-title"><?php single_post_title(); ?></h1>
			</header>
		<?php elseif ( is_front_page() && is_home() && uncoder_theme_has_location( 'header' ) ) : ?>
			<?php // The theme header makes the site title the h1 here; an Uncoder header may not. ?>
			<h1 class="screen-reader-text"><?php echo esc_html( get_bloginfo( 'name' ) ); ?></h1>
		<?php endif; ?>

		<?php if ( have_posts() ) : ?>
			<div class="ut-grid">
				<?php
				while ( have_posts() ) :
					the_post();
					get_template_part( 'template-parts/content', 'card' );
				endwhile;
				?>
			</div>
			<?php uncoder_theme_pagination(); ?>
		<?php else : ?>
			<?php get_template_part( 'template-parts/content', 'none' ); ?>
		<?php endif; ?>
	</div>
</main>
<?php
get_footer();
