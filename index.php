<?php
/**
 * index.php — Main SPA shell template.
 * All page content is rendered client-side from the JS router.
 * This file outputs the full HTML shell that index.html normally provides,
 * but via WordPress's template system so WP can inject wp_head / wp_footer.
 *
 * NOTE: Page-specific templates (template-home.php, etc.) are available
 * for when you split this into individual WP pages in the future.
 */
get_header();
?>

<!-- All page views are in the JS-driven SPA. The full HTML is below. -->
<?php
// Include the full page partials
get_template_part( 'partials/page', 'home' );
get_template_part( 'partials/page', 'about' );
get_template_part( 'partials/page', 'solutions' );
get_template_part( 'partials/page', 'insights' );
get_template_part( 'partials/page', 'resources' );
get_template_part( 'partials/page', 'contact' );
?>

<?php get_footer(); ?>
