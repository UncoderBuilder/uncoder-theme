<?php
/**
 * WooCommerce shop, product category and product pages (used by WooCommerce when it is active).
 *
 * @package Uncoder_Theme
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>
<main id="content" class="site-main">
	<div class="ut-wide">
		<?php
		if ( function_exists( 'woocommerce_content' ) ) {
			woocommerce_content();
		}
		?>
	</div>
</main>
<?php
get_footer();
