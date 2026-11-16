<?php
/**
 * Fortune Financial Planning — theme bootstrap.
 *
 * All functionality lives in focused modules under inc/:
 *
 *   inc/setup.php          theme supports, activation (pages + rewrites), assets
 *   inc/library.php        content library access (data/resources.php) + URL builders
 *   inc/routing.php        rewrite rules, route validation, titles, social meta
 *   inc/post-types.php     insight / team_member / testimonial CPTs
 *   inc/contact.php        contact form AJAX handler
 *   inc/template-tags.php  breadcrumbs, share buttons, list renderers
 */

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Feature flag: calculators are hidden for the initial launch (no
 * interactive tools built yet). Flip to true to restore the calculator
 * tabs, the All Calculators page, and /resources/calculator/* routes —
 * all the data and templates are intact.
 */
const FFP_SHOW_CALCULATORS = false;

require_once get_template_directory() . '/inc/library.php';
require_once get_template_directory() . '/inc/setup.php';
require_once get_template_directory() . '/inc/routing.php';
require_once get_template_directory() . '/inc/post-types.php';
require_once get_template_directory() . '/inc/contact.php';
require_once get_template_directory() . '/inc/template-tags.php';
