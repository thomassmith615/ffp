<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo( 'charset' ); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<!-- ══════════ NAV ══════════ -->
<!--
  Nav uses real href URLs with data-route attributes so right-click
  "Copy Link Address" works correctly. The JS router intercepts the
  click and prevents the full page reload.
-->
<nav id="mainNav">
  <a class="nav-logo" href="/" data-route data-page="home">
    <div class="nav-logo-mark">F</div>
    <div class="nav-logo-text">Fortune Financial<span>Planning</span></div>
  </a>
  <ul class="nav-links">
    <li><a href="/about"     data-route data-page="about">About</a></li>
    <li><a href="/solutions" data-route data-page="solutions">Solutions</a></li>
    <li><a href="/insights"  data-route data-page="insights">Insights</a></li>
    <li><a href="/resources" data-route data-page="resources">Resources</a></li>
    <li><a href="/contact"   data-route data-page="contact" class="nav-cta">Schedule a Meeting</a></li>
  </ul>
  <button class="hamburger" id="ham" aria-label="Toggle menu">
    <span></span><span></span><span></span>
  </button>
</nav>

<div class="mobile-drawer" id="drawer">
  <a href="/"          data-route data-page="home"      onclick="closeDrawer()">Home</a>
  <a href="/about"     data-route data-page="about"     onclick="closeDrawer()">About</a>
  <a href="/solutions" data-route data-page="solutions" onclick="closeDrawer()">Solutions</a>
  <a href="/insights"  data-route data-page="insights"  onclick="closeDrawer()">Insights</a>
  <a href="/resources" data-route data-page="resources" onclick="closeDrawer()">Resources</a>
  <a href="/contact"   data-route data-page="contact"   onclick="closeDrawer()" class="drawer-cta">Schedule a Meeting</a>
</div>
