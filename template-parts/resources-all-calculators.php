<?php
/**
 * All calculators — /resources/calculators/ — grouped by category.
 */
?>

<div class="page-hero resources-hero res-cat-hero">
  <div class="page-hero-inner">
    <?php ffp_breadcrumbs( [
      [ 'label' => 'Resources', 'url' => ffp_url( 'resources' ) ],
      [ 'label' => 'All Calculators' ],
    ] ); ?>
    <h1 class="display-title">All Calculators</h1>
    <p class="body-copy page-hero-copy">Every interactive calculator we offer, organized by category. Interactive versions are being built into the site — in the meantime, we're glad to run any of these numbers with you.</p>
  </div>
</div>

<nav class="res-cats-nav" aria-label="Resource categories">
  <div class="res-cats-nav-inner">
    <?php foreach ( ffp_categories() as $slug => $cat ) : ?>
      <a href="<?php echo esc_url( ffp_category_url( $slug ) ); ?>"><?php echo esc_html( $cat['label'] ); ?></a>
    <?php endforeach; ?>
    <a href="<?php echo esc_url( ffp_url( 'resources/calculators' ) ); ?>" class="active">All Calculators</a>
    <a href="<?php echo esc_url( ffp_url( 'resources/videos' ) ); ?>">All Videos</a>
  </div>
</nav>

<div class="section">
  <div class="section-inner">
    <div class="calc-columns">
      <?php foreach ( ffp_categories() as $slug => $cat ) :
        $calcs = ffp_get_items( $slug, 'calculator' );
        if ( ! $calcs ) continue;
        ?>
        <div class="calc-section reveal">
          <div class="calc-section-title"><?php echo esc_html( $cat['label'] ); ?></div>
          <?php ffp_resource_list( $calcs ); ?>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</div>
