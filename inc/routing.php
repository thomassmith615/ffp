<?php
/**
 * URL routing for library content.
 *
 * Every view on the site is a real, server-rendered URL:
 *
 *   /                                  front-page.php
 *   /about/                            page-about.php
 *   /solutions/                        page-solutions.php   (sections anchor-linkable)
 *   /insights/                         page-insights.php    (feed)
 *   /insights/{slug}/                  page-insights.php    (single — library or `insight` post)
 *   /resources/                        page-resources.php   (overview index)
 *   /resources/{category}/             page-resources.php   (category, Articles tab)
 *   /resources/{category}/{tab}/       page-resources.php   (calculators | videos tab)
 *   /resources/calculators/            page-resources.php   (all calculators)
 *   /resources/videos/                 page-resources.php   (all videos)
 *   /resources/{kind}/{slug}/          page-resources.php   (single article/calculator/video)
 *   /contact/                          page-contact.php
 *
 * The deep routes resolve to the Resources/Insights *pages* with extra
 * query vars (ffp_category, ffp_tab, ffp_kind, ffp_slug); the page
 * templates render the right view. Rewrite rules are flushed on theme
 * activation (see inc/setup.php).
 */

if ( ! defined( 'ABSPATH' ) ) exit;

const FFP_KINDS = [ 'article', 'calculator', 'video' ];

function ffp_register_query_vars( $vars ) {
	return array_merge( $vars, [ 'ffp_category', 'ffp_tab', 'ffp_kind', 'ffp_slug' ] );
}
add_filter( 'query_vars', 'ffp_register_query_vars' );

function ffp_rewrite_rules() {
	// Single resource item: /resources/article/{slug}
	add_rewrite_rule(
		'^resources/(article|calculator|video)/([^/]+)/?$',
		'index.php?pagename=resources&ffp_kind=$matches[1]&ffp_slug=$matches[2]',
		'top'
	);

	// Category page, optional tab: /resources/retirement[/calculators]
	$cats = 'retirement|investment|estate|insurance|tax|lifestyle';
	add_rewrite_rule(
		"^resources/({$cats})(?:/(articles|calculators|videos))?/?$",
		'index.php?pagename=resources&ffp_category=$matches[1]&ffp_tab=$matches[2]',
		'top'
	);

	// Cross-category indexes: /resources/calculators, /resources/videos
	add_rewrite_rule(
		'^resources/(calculators|videos)/?$',
		'index.php?pagename=resources&ffp_category=$matches[1]',
		'top'
	);

	// Single insight: /insights/{slug} (library article or `insight` post)
	add_rewrite_rule(
		'^insights/([^/]+)/?$',
		'index.php?pagename=insights&ffp_slug=$matches[1]',
		'top'
	);

	// Team member bio: /about/{slug}
	add_rewrite_rule(
		'^about/([^/]+)/?$',
		'index.php?pagename=about&ffp_slug=$matches[1]',
		'top'
	);

	// Single solution: /solutions/{slug}
	add_rewrite_rule(
		'^solutions/([^/]+)/?$',
		'index.php?pagename=solutions&ffp_slug=$matches[1]',
		'top'
	);
}
add_action( 'init', 'ffp_rewrite_rules' );

/**
 * WP's canonical redirect would bounce our deep URLs back to the bare
 * page permalink (/resources/article/x → /resources/). Disable it
 * whenever one of our query vars is in play.
 */
function ffp_disable_canonical_redirect( $redirect_url ) {
	if ( get_query_var( 'ffp_slug' ) || get_query_var( 'ffp_category' ) ) {
		return false;
	}
	return $redirect_url;
}
add_filter( 'redirect_canonical', 'ffp_disable_canonical_redirect' );

/** Legacy v1.1 URL: /resources/calc → /resources/calculators */
function ffp_legacy_redirects() {
	$path = trim( (string) parse_url( $_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH ), '/' );
	if ( 'resources/calc' === strtolower( $path ) ) {
		wp_safe_redirect( ffp_url( 'resources/calculators' ), 301 );
		exit;
	}
}
add_action( 'template_redirect', 'ffp_legacy_redirects', 5 );

/**
 * Validate deep routes once the query is parsed; unknown slugs,
 * categories, or kind/slug mismatches become genuine 404s.
 */
function ffp_validate_routes() {
	global $wp_query;

	$kind     = get_query_var( 'ffp_kind' );
	$slug     = get_query_var( 'ffp_slug' );
	$category = get_query_var( 'ffp_category' );

	$fail = function () use ( $wp_query ) {
		$wp_query->set_404();
		status_header( 404 );
		nocache_headers();
	};

	if ( is_page( 'resources' ) ) {
		if ( $kind && $slug ) {
			$item = ffp_get_item( $slug );
			if ( ! ffp_item_is_routable( $item ) || $item['kind'] !== $kind ) {
				$fail();
			}
		} elseif ( $category && ! in_array( $category, [ 'calculators', 'videos' ], true ) && ! ffp_get_category( $category ) ) {
			$fail();
		}
	}

	if ( is_page( 'insights' ) && $slug ) {
		$item = ffp_get_item( $slug );
		if ( ! ffp_item_is_routable( $item ) && ! ffp_get_insight_post( $slug ) ) {
			$fail();
		}
	}

	if ( is_page( 'about' ) && $slug && ! ffp_get_team_member( $slug ) ) {
		$fail();
	}

	if ( is_page( 'solutions' ) && $slug && ! ffp_get_solution( $slug ) ) {
		$fail();
	}
}
add_action( 'wp', 'ffp_validate_routes' );

/* ─────────────────────── TITLES & SOCIAL META ─────────────────────── */

/** Resolve the current deep route to [ title, description ] or null. */
function ffp_current_route_meta() {
	$slug     = get_query_var( 'ffp_slug' );
	$category = get_query_var( 'ffp_category' );

	if ( $slug ) {
		if ( is_page( 'about' ) ) {
			$member = ffp_get_team_member( $slug );
			if ( $member ) {
				return [ $member['name'] . ' — ' . $member['role'], $member['teaser'] ];
			}
		}
		if ( is_page( 'solutions' ) ) {
			$solution = ffp_get_solution( $slug );
			if ( $solution ) {
				return [ $solution['title'] . ' — Solutions', $solution['teaser'] ];
			}
		}
		$item = ffp_get_item( $slug );
		if ( ffp_item_is_routable( $item ) ) {
			return [ $item['title'], $item['excerpt'] ?? '' ];
		}
		if ( is_page( 'insights' ) ) {
			$post = ffp_get_insight_post( $slug );
			if ( $post ) {
				return [ get_the_title( $post ), get_the_excerpt( $post ) ];
			}
		}
	}

	if ( $category ) {
		if ( 'calculators' === $category ) return [ 'All Calculators — Resources', 'Every interactive calculator we offer, organized by category.' ];
		if ( 'videos' === $category )      return [ 'All Videos — Resources', 'Short, informative videos from our team covering key financial topics.' ];
		$cat = ffp_get_category( $category );
		if ( $cat ) {
			return [ $cat['label'] . ' — Resources', $cat['summary'] ];
		}
	}

	return null;
}

function ffp_document_title( $parts ) {
	$meta = ffp_current_route_meta();
	if ( $meta ) {
		$parts['title'] = $meta[0];
	}
	return $parts;
}
add_filter( 'document_title_parts', 'ffp_document_title' );

/** Canonical link + Open Graph tags for deep-linked views. */
function ffp_social_meta() {
	$meta = ffp_current_route_meta();
	if ( ! $meta ) {
		return;
	}

	$url  = home_url( user_trailingslashit( (string) parse_url( $_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH ) ) );
	$type = get_query_var( 'ffp_slug' ) ? 'article' : 'website';

	printf( '<link rel="canonical" href="%s" />' . "\n", esc_url( $url ) );
	printf( '<meta property="og:title" content="%s" />' . "\n", esc_attr( $meta[0] ) );
	if ( $meta[1] ) {
		printf( '<meta property="og:description" content="%s" />' . "\n", esc_attr( $meta[1] ) );
		printf( '<meta name="description" content="%s" />' . "\n", esc_attr( $meta[1] ) );
	}
	printf( '<meta property="og:url" content="%s" />' . "\n", esc_url( $url ) );
	printf( '<meta property="og:type" content="%s" />' . "\n", esc_attr( $type ) );
	echo '<meta name="twitter:card" content="summary" />' . "\n";
}
add_action( 'wp_head', 'ffp_social_meta', 5 );

/* ──────────────────────────── NAV STATE ───────────────────────────── */

/**
 * Slug of the current top-level section, used by the header for
 * active-link state and the solid (non-transparent) nav background.
 */
function ffp_current_section() {
	if ( is_front_page() ) return 'home';
	foreach ( [ 'about', 'solutions', 'insights', 'resources', 'contact' ] as $section ) {
		if ( is_page( $section ) ) return $section;
	}
	if ( is_singular( 'insight' ) ) return 'insights';
	return '';
}

function ffp_body_classes( $classes ) {
	if ( 'home' !== ffp_current_section() ) {
		$classes[] = 'nav-solid';
	}
	return $classes;
}
add_filter( 'body_class', 'ffp_body_classes' );
