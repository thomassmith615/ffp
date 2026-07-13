<?php
/**
 * All videos — /resources/videos/ — grouped by category, with each
 * video's one-line description. The catalog lives in data/videos.csv.
 */
?>

<div class="page-hero resources-hero res-cat-hero">
  <div class="page-hero-inner">
    <?php ffp_breadcrumbs( [
      [ 'label' => 'Resources', 'url' => ffp_url( 'resources' ) ],
      [ 'label' => 'All Videos' ],
    ] ); ?>
    <h1 class="display-title">All Videos</h1>
    <p class="body-copy page-hero-copy">Short, informative videos covering key financial topics, organized by category. Content added regularly.</p>
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

    <div class="video-search reveal">
      <svg class="video-search-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" width="16" height="16" aria-hidden="true"><circle cx="11" cy="11" r="7"/><line x1="21" y1="21" x2="16.5" y2="16.5"/></svg>
      <input type="search" id="videoSearch" placeholder="Search videos — try &ldquo;social security&rdquo;, &ldquo;bonds&rdquo;, or a category&hellip;" aria-label="Search videos" autocomplete="off" />
      <span class="video-search-count" id="videoSearchCount" aria-live="polite"></span>
    </div>

    <div class="calc-columns" id="videoCatalog">
      <?php foreach ( ffp_categories() as $slug => $cat ) :
        $videos = ffp_get_items( $slug, 'video' );
        if ( ! $videos ) continue;
        ?>
        <div class="calc-section reveal">
          <div class="calc-section-title"><?php echo esc_html( $cat['label'] ); ?></div>
          <?php ffp_resource_list( $videos, true ); ?>
        </div>
      <?php endforeach; ?>
    </div>

    <p class="video-search-empty" id="videoSearchEmpty" hidden>No videos match that search. Try fewer or different words &mdash; or <a href="<?php echo esc_url( ffp_url( 'contact' ) ); ?>">ask us directly</a>.</p>

  </div>
</div>
