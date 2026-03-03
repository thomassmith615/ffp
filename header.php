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
<nav id="mainNav">
  <a class="nav-logo" onclick="goTo('home')">
    <div class="nav-logo-mark">F</div>
    <div class="nav-logo-text">Fortune Financial<span>Planning</span></div>
  </a>
  <ul class="nav-links">
    <li><a onclick="goTo('about')"     data-page="about">About</a></li>
    <li><a onclick="goTo('solutions')" data-page="solutions">Solutions</a></li>
    <li><a onclick="goTo('insights')"  data-page="insights">Insights</a></li>
    <li><a onclick="goTo('resources')" data-page="resources">Resources</a></li>
    <li><a onclick="goTo('contact')"   class="nav-cta">Schedule a Meeting</a></li>
  </ul>
  <button class="hamburger" id="ham" aria-label="Toggle menu">
    <span></span><span></span><span></span>
  </button>
</nav>

<div class="mobile-drawer" id="drawer">
  <a onclick="goTo('home');closeDrawer()">Home</a>
  <a onclick="goTo('about');closeDrawer()">About</a>
  <a onclick="goTo('solutions');closeDrawer()">Solutions</a>
  <a onclick="goTo('insights');closeDrawer()">Insights</a>
  <a onclick="goTo('resources');closeDrawer()">Resources</a>
  <a onclick="goTo('contact');closeDrawer()" class="drawer-cta">Schedule a Meeting</a>
</div>
