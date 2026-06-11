<?php
/**
 * All videos — /resources/videos/
 */

$videos = [];
foreach ( ffp_categories() as $slug => $cat ) {
	$videos = array_merge( $videos, ffp_get_items( $slug, 'video' ) );
}
?>

<div class="page-hero resources-hero res-cat-hero">
  <div class="page-hero-inner">
    <?php ffp_breadcrumbs( [
      [ 'label' => 'Resources', 'url' => ffp_url( 'resources' ) ],
      [ 'label' => 'All Videos' ],
    ] ); ?>
    <h1 class="display-title">All Videos</h1>
    <p class="body-copy page-hero-copy">Short, informative videos from our team covering key financial topics. Content added regularly.</p>
  </div>
</div>

<nav class="res-cats-nav" aria-label="Resource categories">
  <div class="res-cats-nav-inner">
    <?php foreach ( ffp_categories() as $slug => $cat ) : ?>
      <a href="<?php echo esc_url( ffp_category_url( $slug ) ); ?>"><?php echo esc_html( $cat['label'] ); ?></a>
    <?php endforeach; ?>
    <a href="<?php echo esc_url( ffp_url( 'resources/calculators' ) ); ?>">All Calculators</a>
    <a href="<?php echo esc_url( ffp_url( 'resources/videos' ) ); ?>" class="active">All Videos</a>
  </div>
</nav>

<div class="section">
  <div class="section-inner">
    <div class="reveal">
      <?php ffp_resource_list( $videos ); ?>
    </div>
  </div>
</div>
