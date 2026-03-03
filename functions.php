<?php
/**
 * Fortune Financial Planning — functions.php
 * Registers theme support, enqueues assets, handles SPA URL routing,
 * contact form AJAX, custom post types, and REST API endpoints.
 */

if ( ! defined( 'ABSPATH' ) ) exit;

/* ═══════════════════════════════════════════════════════
   THEME SETUP
═══════════════════════════════════════════════════════ */
function fortune_theme_setup() {
    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'html5', [
        'search-form', 'comment-form', 'comment-list', 'gallery', 'caption',
    ] );
    add_theme_support( 'custom-logo' );
    add_theme_support( 'menus' );

    register_nav_menus( [
        'primary' => __( 'Primary Navigation', 'fortune-financial' ),
        'footer'  => __( 'Footer Navigation',  'fortune-financial' ),
    ] );
}
add_action( 'after_setup_theme', 'fortune_theme_setup' );


/* ═══════════════════════════════════════════════════════
   ENQUEUE STYLES & SCRIPTS
═══════════════════════════════════════════════════════ */
function fortune_enqueue_assets() {
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

    // Inject runtime data for JS — homeUrl used by slugFromPath() and urlForPage()
    wp_localize_script( 'fortune-main', 'fortuneData', [
        'ajaxUrl'  => admin_url( 'admin-ajax.php' ),
        'nonce'    => wp_create_nonce( 'fortune_nonce' ),
        'homeUrl'  => untrailingslashit( home_url() ),
        'themeUrl' => get_template_directory_uri(),
    ] );
}
add_action( 'wp_enqueue_scripts', 'fortune_enqueue_assets' );


/* ═══════════════════════════════════════════════════════
   SPA URL ROUTING — REWRITE RULES
   Maps /about, /solutions, etc. → the front page.
   WordPress serves the same index.php for all SPA routes;
   the JS router then reads window.location.pathname and
   activates the correct view.

   IMPORTANT: After activating the theme (or changing these),
   go to Settings → Permalinks and click Save Changes once
   to flush the rewrite rules cache.
═══════════════════════════════════════════════════════ */
function fortune_add_rewrite_rules() {
    $spa_pages = [ 'about', 'solutions', 'insights', 'resources', 'contact' ];

    foreach ( $spa_pages as $slug ) {
        // Match /slug and /slug/ (trailing slash) — both point to the homepage
        add_rewrite_rule(
            '^' . preg_quote( $slug, '#' ) . '/?$',
            'index.php',
            'top'
        );
    }
}
add_action( 'init', 'fortune_add_rewrite_rules' );

/**
 * Flush rewrite rules once on theme activation so the rules
 * take effect immediately without a manual Permalinks save.
 */
function fortune_activate() {
    fortune_add_rewrite_rules();
    flush_rewrite_rules();
}
add_action( 'after_switch_theme', 'fortune_activate' );


/* ═══════════════════════════════════════════════════════
   TRAILING SLASH REDIRECT
   Converts /about/ → /about (removes trailing slash).
   This prevents the "Forbidden" / grey screen issue that
   some server configs show for directory-like URLs.
   Only applies to our SPA routes, not to WP admin or files.
═══════════════════════════════════════════════════════ */
function fortune_redirect_trailing_slash() {
    // Don't touch admin, REST API, or actual files/directories
    if ( is_admin() ) return;
    if ( defined( 'REST_REQUEST' ) && REST_REQUEST ) return;

    $request_uri = $_SERVER['REQUEST_URI'] ?? '';

    // Only act on our known SPA slugs with a trailing slash
    $spa_pages = [ 'about', 'solutions', 'insights', 'resources', 'contact' ];
    foreach ( $spa_pages as $slug ) {
        if ( preg_match( '#^/' . preg_quote( $slug, '#' ) . '/$#', parse_url( $request_uri, PHP_URL_PATH ) ) ) {
            $clean = untrailingslashit( home_url( $slug ) );
            wp_redirect( $clean, 301 );
            exit;
        }
    }
}
add_action( 'template_redirect', 'fortune_redirect_trailing_slash' );


/* ═══════════════════════════════════════════════════════
   ENSURE HOMEPAGE IS ALWAYS SERVED FOR SPA ROUTES
   When WP's query resolves to a 404 for /about etc.,
   force it to serve the front page template instead.
═══════════════════════════════════════════════════════ */
function fortune_spa_template( $template ) {
    if ( is_404() ) {
        $spa_pages = [ 'about', 'solutions', 'insights', 'resources', 'contact' ];
        $path      = trim( parse_url( $_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH ), '/' );
        $slug      = strtolower( explode( '/', $path )[0] );

        if ( in_array( $slug, $spa_pages, true ) ) {
            // Serve the front page template with a 200 status
            status_header( 200 );
            $front = get_template_directory() . '/index.php';
            return file_exists( $front ) ? $front : $template;
        }
    }
    return $template;
}
add_filter( 'template_include', 'fortune_spa_template', 99 );


/* ═══════════════════════════════════════════════════════
   DYNAMIC <title> TAG FOR SPA ROUTES
   Sets a sensible page title for each URL so browser tabs,
   bookmarks, and share previews show the right text.
═══════════════════════════════════════════════════════ */
function fortune_spa_title( $title ) {
    $spa_titles = [
        'about'     => 'About Us',
        'solutions' => 'Solutions',
        'insights'  => 'Insights',
        'resources' => 'Resources',
        'contact'   => 'Contact',
    ];

    $path = trim( parse_url( $_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH ), '/' );
    $slug = strtolower( explode( '/', $path )[0] );

    if ( isset( $spa_titles[ $slug ] ) ) {
        $site = get_bloginfo( 'name' );
        return $spa_titles[ $slug ] . ' — ' . $site;
    }

    return $title;
}
add_filter( 'pre_get_document_title', 'fortune_spa_title' );


/* ═══════════════════════════════════════════════════════
   CONTACT FORM AJAX HANDLER
═══════════════════════════════════════════════════════ */
function fortune_handle_contact_form() {
    check_ajax_referer( 'fortune_nonce', 'nonce' );

    $first   = sanitize_text_field( $_POST['first_name'] ?? '' );
    $last    = sanitize_text_field( $_POST['last_name']  ?? '' );
    $email   = sanitize_email(      $_POST['email']      ?? '' );
    $phone   = sanitize_text_field( $_POST['phone']      ?? '' );
    $topic   = sanitize_text_field( $_POST['topic']      ?? '' );
    $message = sanitize_textarea_field( $_POST['message'] ?? '' );

    if ( empty( $email ) || ! is_email( $email ) ) {
        wp_send_json_error( [ 'message' => 'Please provide a valid email address.' ] );
    }

    $to      = get_option( 'admin_email' );
    $subject = "New Contact Form Submission: {$topic}";
    $body    = "Name: {$first} {$last}\nEmail: {$email}\nPhone: {$phone}\nTopic: {$topic}\n\nMessage:\n{$message}";
    $headers = [
        'Content-Type: text/plain; charset=UTF-8',
        "Reply-To: {$first} {$last} <{$email}>",
    ];

    $sent = wp_mail( $to, $subject, $body, $headers );

    if ( $sent ) {
        wp_send_json_success( [ 'message' => "Thank you, {$first}! We'll be in touch shortly." ] );
    } else {
        wp_send_json_error( [ 'message' => 'There was an issue sending your message. Please call us directly at (856) 454-5005.' ] );
    }
}
add_action( 'wp_ajax_fortune_contact',        'fortune_handle_contact_form' );
add_action( 'wp_ajax_nopriv_fortune_contact', 'fortune_handle_contact_form' );


/* ═══════════════════════════════════════════════════════
   CUSTOM PAGE TEMPLATES
═══════════════════════════════════════════════════════ */
function fortune_add_page_templates( $templates ) {
    $templates['template-home.php']      = 'Home (SPA)';
    $templates['template-about.php']     = 'About';
    $templates['template-solutions.php'] = 'Solutions';
    $templates['template-insights.php']  = 'Insights';
    $templates['template-resources.php'] = 'Resources';
    $templates['template-contact.php']   = 'Contact';
    return $templates;
}
add_filter( 'theme_page_templates', 'fortune_add_page_templates' );


/* ═══════════════════════════════════════════════════════
   CUSTOM POST TYPE: INSIGHTS
═══════════════════════════════════════════════════════ */
function fortune_register_post_types() {
    register_post_type( 'insight', [
        'labels' => [
            'name'          => 'Insights',
            'singular_name' => 'Insight',
            'add_new_item'  => 'Add New Insight',
            'edit_item'     => 'Edit Insight',
        ],
        'public'       => true,
        'show_in_rest' => true,
        'has_archive'  => true,
        'menu_icon'    => 'dashicons-lightbulb',
        'supports'     => [ 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'custom-fields' ],
        'rewrite'      => [ 'slug' => 'insights' ],
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
add_action( 'init', 'fortune_register_post_types' );


/* ═══════════════════════════════════════════════════════
   TAXONOMY: INSIGHT CATEGORY
═══════════════════════════════════════════════════════ */
function fortune_register_taxonomies() {
    register_taxonomy( 'insight_category', 'insight', [
        'label'        => 'Category',
        'hierarchical' => true,
        'show_in_rest' => true,
        'rewrite'      => [ 'slug' => 'insight-category' ],
    ] );
}
add_action( 'init', 'fortune_register_taxonomies' );


/* ═══════════════════════════════════════════════════════
   REST API: INSIGHTS ENDPOINT
═══════════════════════════════════════════════════════ */
function fortune_rest_insights() {
    register_rest_route( 'fortune/v1', '/insights', [
        'methods'             => 'GET',
        'callback'            => 'fortune_rest_get_insights',
        'permission_callback' => '__return_true',
        'args' => [
            'per_page' => [ 'default' => 6,  'sanitize_callback' => 'absint' ],
            'page'     => [ 'default' => 1,  'sanitize_callback' => 'absint' ],
            'category' => [ 'default' => '', 'sanitize_callback' => 'sanitize_text_field' ],
        ],
    ] );
}
add_action( 'rest_api_init', 'fortune_rest_insights' );

function fortune_rest_get_insights( WP_REST_Request $request ) {
    $args = [
        'post_type'      => 'insight',
        'posts_per_page' => $request->get_param( 'per_page' ),
        'paged'          => $request->get_param( 'page' ),
        'post_status'    => 'publish',
        'orderby'        => 'date',
        'order'          => 'DESC',
    ];

    $cat = $request->get_param( 'category' );
    if ( $cat ) {
        $args['tax_query'] = [ [
            'taxonomy' => 'insight_category',
            'field'    => 'slug',
            'terms'    => $cat,
        ] ];
    }

    $query = new WP_Query( $args );
    $posts = [];

    foreach ( $query->posts as $post ) {
        $categories = wp_get_post_terms( $post->ID, 'insight_category', [ 'fields' => 'names' ] );
        $posts[] = [
            'id'       => $post->ID,
            'title'    => get_the_title( $post ),
            'excerpt'  => get_the_excerpt( $post ),
            'date'     => get_the_date( 'M j, Y', $post ),
            'author'   => get_the_author_meta( 'display_name', $post->post_author ),
            'category' => ! empty( $categories ) ? $categories[0] : 'General',
            'link'     => get_permalink( $post ),
            'thumb'    => get_the_post_thumbnail_url( $post, 'medium' ) ?: '',
        ];
    }

    return rest_ensure_response( [
        'posts'       => $posts,
        'total'       => (int) $query->found_posts,
        'total_pages' => (int) $query->max_num_pages,
    ] );
}


/* ═══════════════════════════════════════════════════════
   PERFORMANCE & HEAD CLEANUP
═══════════════════════════════════════════════════════ */
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'wp_print_styles', 'print_emoji_styles' );
remove_action( 'wp_head', 'wp_generator' );
remove_action( 'wp_head', 'wlwmanifest_link' );
remove_action( 'wp_head', 'rsd_link' );
remove_action( 'wp_head', 'wp_shortlink_wp_head' );
