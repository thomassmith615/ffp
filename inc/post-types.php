<?php
/**
 * Custom post types and taxonomies.
 *
 * `insight` posts publish at /insights/{slug}/ — the same namespace as
 * the static library articles. The CPT registers without its own
 * rewrite rules; inc/routing.php owns /insights/* and the insights page
 * template falls back to a CPT lookup when the slug isn't in the library.
 */

if ( ! defined( 'ABSPATH' ) ) exit;

function ffp_register_post_types() {
	register_post_type( 'insight', [
		'labels' => [
			'name'          => 'Insights',
			'singular_name' => 'Insight',
			'add_new_item'  => 'Add New Insight',
			'edit_item'     => 'Edit Insight',
		],
		'public'       => true,
		'show_in_rest' => true,
		'has_archive'  => false,
		'rewrite'      => false,
		'menu_icon'    => 'dashicons-lightbulb',
		'supports'     => [ 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'custom-fields' ],
	] );

	register_post_type( 'team_member', [
		'labels' => [
			'name'          => 'Team Members',
			'singular_name' => 'Team Member',
		],
		'public'       => true,
		'show_in_rest' => true,
		'menu_icon'    => 'dashicons-groups',
		'supports'     => [ 'title', 'editor', 'thumbnail', 'custom-fields', 'page-attributes' ],
		'rewrite'      => [ 'slug' => 'team' ],
	] );

	register_post_type( 'testimonial', [
		'labels' => [
			'name'          => 'Testimonials',
			'singular_name' => 'Testimonial',
		],
		'public'       => false,
		'show_ui'      => true,
		'show_in_rest' => true,
		'menu_icon'    => 'dashicons-format-quote',
		'supports'     => [ 'title', 'editor', 'custom-fields' ],
	] );
}
add_action( 'init', 'ffp_register_post_types' );

function ffp_register_taxonomies() {
	register_taxonomy( 'insight_category', 'insight', [
		'label'        => 'Category',
		'hierarchical' => true,
		'show_in_rest' => true,
		'rewrite'      => [ 'slug' => 'insight-category' ],
	] );
}
add_action( 'init', 'ffp_register_taxonomies' );

/** Point insight permalinks at the routed URL: /insights/{slug}/ */
function ffp_insight_permalink( $link, $post ) {
	if ( 'insight' === $post->post_type && 'publish' === $post->post_status ) {
		return ffp_insight_url( $post->post_name );
	}
	return $link;
}
add_filter( 'post_type_link', 'ffp_insight_permalink', 10, 2 );
