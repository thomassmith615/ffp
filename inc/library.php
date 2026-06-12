<?php
/**
 * Content library access layer.
 *
 * Wraps data/resources.php with lookup helpers used by templates
 * and routing. An item is "routable" when it has a body; items
 * without a body are stubs shown as "coming soon" in listings.
 */

if ( ! defined( 'ABSPATH' ) ) exit;

/** Load (and memoize) the full library array. */
function ffp_library() {
	static $library = null;
	if ( null === $library ) {
		$library = require get_template_directory() . '/data/resources.php';
	}
	return $library;
}

/** All resource categories, keyed by slug. */
function ffp_categories() {
	return ffp_library()['categories'];
}

/** One category's metadata, or null. */
function ffp_get_category( $slug ) {
	$cats = ffp_categories();
	return $cats[ $slug ] ?? null;
}

/** One library item (with its slug merged in), or null. */
function ffp_get_item( $slug ) {
	$items = ffp_library()['items'];
	if ( ! isset( $items[ $slug ] ) ) {
		return null;
	}
	return array_merge( [ 'slug' => $slug ], $items[ $slug ] );
}

/** True when the item exists and has a full body to render. */
function ffp_item_is_routable( $item ) {
	return $item && ! empty( $item['body'] );
}

/**
 * Items filtered by category and/or kind, in library (curated) order.
 * Pass null to skip a filter.
 */
function ffp_get_items( $category = null, $kind = null ) {
	$out = [];
	foreach ( ffp_library()['items'] as $slug => $item ) {
		if ( null !== $category && ( $item['category'] ?? null ) !== $category ) continue;
		if ( null !== $kind && $item['kind'] !== $kind ) continue;
		$out[] = array_merge( [ 'slug' => $slug ], $item );
	}
	return $out;
}

/** Per-kind item counts for a category, e.g. [ 'article' => 5, ... ]. */
function ffp_category_counts( $category ) {
	$counts = [ 'article' => 0, 'calculator' => 0, 'video' => 0 ];
	foreach ( ffp_get_items( $category ) as $item ) {
		if ( isset( $counts[ $item['kind'] ] ) ) {
			$counts[ $item['kind'] ]++;
		}
	}
	return $counts;
}

/**
 * The Insights feed: library articles flagged with insight_tag plus any
 * published `insight` posts from WP admin, normalized to a common shape
 * and sorted newest first.
 */
function ffp_get_insights() {
	$feed = [];

	foreach ( ffp_library()['items'] as $slug => $item ) {
		if ( empty( $item['insight_tag'] ) ) continue;
		$feed[] = [
			'slug'      => $slug,
			'title'     => $item['title'],
			'tag'       => $item['insight_tag'],
			'dek'       => $item['insight_dek'] ?? $item['excerpt'],
			'author'    => $item['author'],
			'date'      => $item['date'],
			'read_time' => $item['read_time'] ?? '',
			'sort'      => $item['sort'],
		];
	}

	$posts = get_posts( [
		'post_type'      => 'insight',
		'post_status'    => 'publish',
		'posts_per_page' => -1,
	] );
	foreach ( $posts as $post ) {
		$terms = wp_get_post_terms( $post->ID, 'insight_category', [ 'fields' => 'names' ] );
		$feed[] = [
			'slug'      => $post->post_name,
			'title'     => get_the_title( $post ),
			'tag'       => ! is_wp_error( $terms ) && $terms ? $terms[0] : 'General',
			'dek'       => get_the_excerpt( $post ),
			'author'    => get_the_author_meta( 'display_name', $post->post_author ),
			'date'      => get_the_date( 'M j, Y', $post ),
			'read_time' => '',
			'sort'      => get_the_date( 'Y-m-d', $post ),
		];
	}

	usort( $feed, fn( $a, $b ) => strcmp( $b['sort'], $a['sort'] ) );
	return $feed;
}

/**
 * Find a published `insight` post by slug (for /insights/{slug} URLs
 * that aren't in the static library).
 */
function ffp_get_insight_post( $slug ) {
	$posts = get_posts( [
		'post_type'      => 'insight',
		'post_status'    => 'publish',
		'name'           => sanitize_title( $slug ),
		'posts_per_page' => 1,
	] );
	return $posts ? $posts[0] : null;
}

/* ─────────────────────────── TEAM ─────────────────────────── */

/** All team members (data/team.php), keyed by slug, in display order. */
function ffp_team() {
	static $team = null;
	if ( null === $team ) {
		$team = require get_template_directory() . '/data/team.php';
	}
	return $team;
}

/** One team member (with slug merged in), or null. */
function ffp_get_team_member( $slug ) {
	$team = ffp_team();
	if ( ! isset( $team[ $slug ] ) ) {
		return null;
	}
	return array_merge( [ 'slug' => $slug ], $team[ $slug ] );
}

/* ─────────────────────────── URL BUILDERS ─────────────────────────── */

/** Absolute URL for a site path, with WP's trailing-slash preference. */
function ffp_url( $path = '' ) {
	$path = '/' . ltrim( $path, '/' );
	return '/' === $path ? home_url( '/' ) : home_url( user_trailingslashit( $path ) );
}

/** URL of a single resource item: /resources/{kind}/{slug}/ */
function ffp_resource_url( $item ) {
	return ffp_url( 'resources/' . $item['kind'] . '/' . $item['slug'] );
}

/** URL of a resource category page (optionally a specific tab). */
function ffp_category_url( $category, $tab = '' ) {
	$path = 'resources/' . $category;
	if ( $tab && 'articles' !== $tab ) {
		$path .= '/' . $tab;
	}
	return ffp_url( $path );
}

/** URL of a single insight: /insights/{slug}/ */
function ffp_insight_url( $slug ) {
	return ffp_url( 'insights/' . $slug );
}

/** URL of a team member bio: /about/{slug}/ */
function ffp_member_url( $slug ) {
	return ffp_url( 'about/' . $slug );
}
