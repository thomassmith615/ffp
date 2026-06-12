<?php
/**
 * Site header: <head>, fixed nav, and mobile drawer.
 *
 * Nav state is server-rendered: ffp_current_section() drives the active
 * link, and the `nav-solid` body class (set in inc/routing.php) gives
 * every non-home page an opaque nav. JS only adds `.scrolled` on the
 * transparent home nav.
 */

$ffp_section = ffp_current_section();
$ffp_nav     = [
	'about'     => 'About',
	'solutions' => 'Solutions',
	'insights'  => 'Insights',
	'resources' => 'Resources',
];
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo( 'charset' ); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<nav id="mainNav">
  <a class="nav-logo" href="<?php echo esc_url( home_url( '/' ) ); ?>">
    <?php $ffp_mark = ffp_image_url( 'logo-tree-toolbar' ); // square mark, background baked in ?>
    <?php if ( $ffp_mark ) : ?>
      <img class="nav-logo-img" src="<?php echo esc_url( $ffp_mark ); ?>" alt="" width="42" height="42" />
    <?php else : ?>
      <div class="nav-logo-mark">F</div>
    <?php endif; ?>
    <div class="nav-logo-text">Fortune Financial<span>Planning</span></div>
  </a>
  <ul class="nav-links">
    <?php foreach ( $ffp_nav as $slug => $label ) : ?>
      <li><a href="<?php echo esc_url( ffp_url( $slug ) ); ?>" class="<?php echo $ffp_section === $slug ? 'active' : ''; ?>"><?php echo esc_html( $label ); ?></a></li>
    <?php endforeach; ?>
    <li><a href="<?php echo esc_url( ffp_url( 'contact' ) ); ?>" class="nav-cta">Schedule a Meeting</a></li>
  </ul>
  <button class="hamburger" id="ham" aria-label="Toggle menu" aria-expanded="false">
    <span></span><span></span><span></span>
  </button>
</nav>

<div class="mobile-drawer" id="drawer">
  <a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a>
  <?php foreach ( $ffp_nav as $slug => $label ) : ?>
    <a href="<?php echo esc_url( ffp_url( $slug ) ); ?>"><?php echo esc_html( $label ); ?></a>
  <?php endforeach; ?>
  <a href="<?php echo esc_url( ffp_url( 'contact' ) ); ?>" class="drawer-cta">Schedule a Meeting</a>
</div>

<main id="content">
