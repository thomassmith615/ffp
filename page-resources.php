<?php
/**
 * Resources — dispatches on the routed query vars:
 *
 *   /resources/                     overview index
 *   /resources/{category}/[{tab}]   category view (articles default)
 *   /resources/calculators/         all calculators, grouped
 *   /resources/videos/              all videos
 *   /resources/{kind}/{slug}/       single item
 *
 * Routes are validated in inc/routing.php; invalid ones 404 first.
 */

$ffp_kind     = get_query_var( 'ffp_kind' );
$ffp_slug     = get_query_var( 'ffp_slug' );
$ffp_category = get_query_var( 'ffp_category' );

get_header();

if ( $ffp_kind && $ffp_slug ) {
	get_template_part( 'template-parts/single', 'item', [
		'item'    => ffp_get_item( $ffp_slug ),
		'context' => 'resources',
	] );
} elseif ( 'calculators' === $ffp_category || 'videos' === $ffp_category ) {
	get_template_part( 'template-parts/resources', 'all-' . $ffp_category );
} elseif ( $ffp_category ) {
	get_template_part( 'template-parts/resources', 'category', [
		'category' => $ffp_category,
		'tab'      => get_query_var( 'ffp_tab' ) ?: 'articles',
	] );
} else {
	get_template_part( 'template-parts/resources', 'overview' );
}

get_footer();
