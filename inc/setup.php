<?php
/**
 * Theme setup, activation, and asset enqueueing.
 */

if ( ! defined( 'ABSPATH' ) ) exit;

function ffp_theme_setup() {
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'html5', [ 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption' ] );
	add_theme_support( 'custom-logo' );
	add_theme_support( 'menus' );

	register_nav_menus( [
		'primary' => __( 'Primary Navigation', 'fortune-financial' ),
		'footer'  => __( 'Footer Navigation', 'fortune-financial' ),
	] );
}
add_action( 'after_setup_theme', 'ffp_theme_setup' );

/**
 * On activation: create the site's pages if they don't exist, point the
 * front page at "Home", and flush rewrite rules so the deep routes
 * (/resources/article/{slug}, /insights/{slug}, …) resolve immediately.
 *
 * Templates resolve by slug (page-about.php, page-resources.php, …),
 * so no _wp_page_template meta is needed.
 */
function ffp_activate() {
	$pages = [
		'Home'      => 'home',
		'About'     => 'about',
		'Solutions' => 'solutions',
		'Insights'  => 'insights',
		'Resources' => 'resources',
		'Contact'   => 'contact',
		'Do Not Sell My Personal Information' => 'do-not-sell',
	];

	foreach ( $pages as $title => $slug ) {
		if ( get_page_by_path( $slug ) ) {
			continue;
		}
		$id = wp_insert_post( [
			'post_title'  => $title,
			'post_name'   => $slug,
			'post_type'   => 'page',
			'post_status' => 'publish',
		] );
		if ( 'Home' === $title && $id && ! is_wp_error( $id ) ) {
			update_option( 'show_on_front', 'page' );
			update_option( 'page_on_front', $id );
		}
	}

	// If Home already existed, still make sure it's the front page.
	$home = get_page_by_path( 'home' );
	if ( $home && 'page' !== get_option( 'show_on_front' ) ) {
		update_option( 'show_on_front', 'page' );
		update_option( 'page_on_front', $home->ID );
	}

	ffp_rewrite_rules();
	flush_rewrite_rules();
}
add_action( 'after_switch_theme', 'ffp_activate' );

/* ─────────────────────────── ASSETS ─────────────────────────── */

function ffp_enqueue_assets() {
	$ver = wp_get_theme()->get( 'Version' );

	wp_enqueue_style(
		'fortune-google-fonts',
		'https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,600;1,300;1,400&family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500;9..40,600&display=swap',
		[],
		null
	);

	wp_enqueue_style(
		'fortune-main',
		get_template_directory_uri() . '/assets/css/main.css',
		[ 'fortune-google-fonts' ],
		$ver
	);

	wp_enqueue_script(
		'fortune-main',
		get_template_directory_uri() . '/assets/js/main.js',
		[],
		$ver,
		true
	);

	wp_localize_script( 'fortune-main', 'fortuneData', [
		'ajaxUrl' => admin_url( 'admin-ajax.php' ),
		'nonce'   => wp_create_nonce( 'fortune_nonce' ),
	] );
}
add_action( 'wp_enqueue_scripts', 'ffp_enqueue_assets' );

/* ───────────────────── HEAD CLEANUP / PERFORMANCE ───────────────────── */

remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'wp_print_styles', 'print_emoji_styles' );
remove_action( 'wp_head', 'wp_generator' );
remove_action( 'wp_head', 'wlwmanifest_link' );
remove_action( 'wp_head', 'rsd_link' );
remove_action( 'wp_head', 'wp_shortlink_wp_head' );
